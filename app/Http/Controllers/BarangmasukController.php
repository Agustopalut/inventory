<?php

namespace App\Http\Controllers;

use App\Models\ApprovalRequest;
use App\Models\Barangmaster;
use App\Models\Barangmasuk;
use App\Models\BarangMasukPending;
use App\Models\History;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as FacadesRequest;

class BarangmasukController extends Controller
{
    public function index()
    {
        $data = Barangmasuk::with('barang_master')->get();
        return view('barang.barang-masuk', [
            'title' => 'barang masuk',
            'data' => $data,
        ]);
    }

    public function input()
    {

        $barang = Barangmaster::all();

        return view('barang.add-barang-masuk', [
            'title' => 'input barang masuk',
            'data' => $barang
        ]);
    }

    public function getBarang($id)
    {
        $getBarang = Barangmaster::findOrFail($id);

        return response()->json([
            'satuan' => $getBarang->satuan
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'id_barang' => 'required',
            'harga_satuan' => 'required',
            'jumlah' => 'required|numeric',
            'tanggal_masuk' => 'required|date'
        ], [
            'id_barang.required' => 'Barang harus dipilih',
            'harga_satuan.required' => 'Harga satuan wajib diisi',
            'jumlah.required' => 'Jumlah barang wajib diisi',
            'tanggal_masuk.required' => 'Tanggal masuk wajib diisi'
        ]);

        $last = BarangMasukPending::orderBy('kd_barang_masuk_pending', 'desc')->first();
        if ($last) {
            $nomor = (int) substr($last->kd_barang_masuk_pending, 2) + 1;
        } else {
            $nomor = 1;
        }
        $kode = 'BM' . str_pad($nomor, 3, '0', STR_PAD_LEFT);

        BarangMasukPending::create([
            'kd_barang_masuk_pending' => $kode,
            'id_barang' => $validate['id_barang'],
            'jumlah' => $validate['jumlah'],
            'harga_satuan' => $validate['harga_satuan'],
            'sisa' => $validate['jumlah'],
            'user_id' => Auth::id(),
            'tanggal_masuk' => $validate['tanggal_masuk']
        ]);

        ApprovalRequest::create([
            'kd_transaksi_pending' => $kode,
            'user_id' => Auth::id(),
            'modul' => 'Barang masuk',
            'aksi' => 'Input',
            'tanggal_request' => Carbon::now()
        ]);

        $barang = Barangmaster::findOrFail($validate['id_barang']);
        History::create([
            'user_id' => Auth::id(),
            'id_referesni' => $kode,
            'keterangan' => Auth::user()->name . ' Menambahkan barang masuk ' . $barang->nama_barang . ' dengan kode : ' . $kode,
            'tanggal' => Carbon::now()
        ]);

        return redirect('/barang-masuk')->with('pending', 'Data barang masuk berhasil diinput. Sedang menunggu persetujuan manager');
    }

    public function getBarangForDelete($id)
    {

        ApprovalRequest::create([
            'kd_transaksi_pending' => $id,
            'user_id' => Auth::id(),
            'modul' => 'Barang masuk',
            'aksi' => 'Delete',
            'tanggal_request' => Carbon::now()
        ]);

        $barang = Barangmasuk::with('barang_master')->where('kd_barang_masuk', $id)->firstOrFail();
        History::create([
            'user_id' => Auth::id(),
            'id_referesni' => $id,
            'keterangan' => Auth::user()->name . ' Mengirim permintaan untuk menghapus ' . $barang->barang_master->nama_barang . ' dengan kode : ' . $id,
            'tanggal' => Carbon::now()
        ]);
        return redirect('/barang-masuk')->with('pending', 'Data barang masuk akan dihapus jika sudah di approve oleh manager');
    }

    public function update($id) {
        $barang = Barangmasuk::with('barang_master')->findOrFail($id);
        $subtotal =$barang->harga_satuan * $barang->jumlah;
        $total = 'Rp'.number_format($subtotal, 0, ',', '.');

        return view('barang.update-barang-masuk',[
            'title' => 'update barang masuk',
            'barang' => $barang,
            'subtotal' => $total
        ]);
    }

    public function updateStore(Request $request, $id) {
        $barangPending = BarangMasukPending::find($id);

        $validate = $request->validate([
            'jumlah' => 'required',
            'harga_satuan' => 'required'
        ],[
            'jumlah.required' => 'Jumlah barang wajib diisi',
            'harga_satuan.required'
        ]);
        
        $barangPending->update([
            'jumlah' => $validate['jumlah'],
            'harga_satuan' => $validate['harga_satuan']
        ]);

        ApprovalRequest::create([
            'kd_transaksi_pending' => $barangPending->kd_barang_masuk_pending,
            'user_id' => Auth::id(),
            'modul' => 'barang masuk',
            'tanggal_request' => Carbon::now(),
            'aksi' => 'update'
        ]);

        History::create([
            'user_id' => Auth::id(),
            'keterangan' => Auth::user()->name . ' Mengirim permintaan approval update barang : ' . $barangPending->barang_master->nama_barang . ' dengan kode : ' . $barangPending->kd_barang_masuk_pending,
            'tanggal' => Carbon::now()
        ]);

        return redirect('/barang-masuk')->with('pending','update barang berhasil dilakukan, sedang menungggu persetujuan manager');
    }

    public function details($id) {
        $barang = Barangmasuk::with(['barang_master','user'])->find($id);
        $subtotal = $barang->harga_satuan * $barang->jumlah;
        $total ='Rp'. number_format($subtotal, 0, ',', '.');
        return view('barang.detail-barang-masuk',[
            'title' => 'detail barang masuk',
            'barang' => $barang,
            'subtotal' => $total
        ]);
    }

    public function cetak() {
        // $data = Barangmasuk::with(['user','barang_master'])->get();
        return view('barang.cetak-barang-masuk',[
            'title' => 'Cetak barang masuk',
            'data' => collect(),
            'jenisLaporan' => ''
        ]);
    }

    public function filterbarangmasuk(Request $request) {
        // dd([$request->bulan,$request->tahun]);
        $query = Barangmasuk::with(['barang_master','user']);
        if($request->laporan === 'harian'){
            $request->validate([
                'tanggal_awal' => 'required|date',
                'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal'
            ]);

            $query
                ->whereDate('tanggal_masuk','>=',$request->tanggal_awal)
                ->whereDate('tanggal_masuk','<=',$request->tanggal_akhir);
            $filterFirst= $request->tanggal_awal;
            $filterSecond= $request->tanggal_akhir;


        } else if($request->laporan ==='bulan') {

            $request->validate([
                'bulan' => 'required|integer|between:1,12',
                'tahun' => 'required|integer'
            ]);

            $query
                ->whereMonth('tanggal_masuk',$request->bulan)
                ->whereYear('tanggal_masuk',$request->tahun);
            
            $filterFirst= $request->bulan;
            $filterSecond= $request->tahun;

        }

        $data = $query  
                        ->orderBy('tanggal_masuk','asc')
                        ->get();

        if($data->isEmpty()) {
            return back()
                ->withInput()
                ->with('error',"Data tidak ditemukan");
        }

        return view('barang.cetak-barang-masuk',[
            'data' => $data,
            'title' => 'cetak barang masuk',
            'filterFirst' => $filterFirst,
            'filterSecond' => $filterSecond,
            'jenisLaporan' => $request->laporan
        ]);
    }
}
