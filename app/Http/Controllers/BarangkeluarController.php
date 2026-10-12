<?php

namespace App\Http\Controllers;

use App\Models\ApprovalRequest;
use App\Models\BarangkeluarDetail;
use App\Models\BarangkeluarDetailPending;
use App\Models\BarangkeluarHeader;
use App\Models\BarangkeluarHeaderPending;
use App\Models\Barangmaster;
use App\Models\Barangmasuk;
use App\Models\History;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BarangkeluarController extends Controller
{
    public function index()
    {
        $data = BarangkeluarHeader::with('users')->get();
        return view('barang.barang-keluar', [
            'title' => 'barang keluar',
            'data' => $data,
        ]);
    }

    public function input()
    {
        $master = Barangmaster::all();

        return view('barang.add-barang-keluar', [
            'title' => 'input barang keluar',
            'barang' => $master
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'tujuan' => 'required',
                'keterangan' => 'nullable',
                'tanggal_keluar' => 'required',

                'id_barang' => 'required|array|min:1',
                'id_barang.*' => 'required|integer',

                'jumlah' => 'required|array|min:1',
                'jumlah.*' => 'required|numeric|min:1',
            ]);

            $idBarang = $request->id_barang;
            $jumlah = $request->jumlah;
            // dd($idBarang,$jumlah);


            $last = BarangkeluarHeaderPending::orderBy('kd_barang_keluar_pending', 'desc')->first();
            if ($last) {
                $nomor = (int) substr($last->kd_barang_keluar_pending, 2) + 1;
            } else {
                $nomor = 1;
            }
            $kode = 'BK' . str_pad($nomor, 3, '0', STR_PAD_LEFT);
            DB::transaction(function () use ($request, $kode, $jumlah) {

                BarangkeluarHeaderPending::create([
                    'kd_barang_keluar_pending' => $kode,
                    'tanggal_keluar' => $request->tanggal_keluar,
                    'user_id' => Auth::id(),
                    'keterangan' => $request->keterangan,
                    'tujuan' => $request->tujuan
                ]);


                foreach ($request->id_barang as $index => $id_barang) {

                    $jumlahDiminta = $request->jumlah[$index];

                    $sisaPermintaan = $jumlahDiminta;

                    // mencari batch FIFO

                    $batches = Barangmasuk::where('id_barang', $id_barang)
                        ->where('sisa', '>', 0)
                        ->orderBy('tanggal_masuk', 'asc')
                        ->lockForUpdate()
                        ->get();

                    $totalStok = $batches->sum('sisa');
                    // validasi stok
                    $barang = Barangmaster::where('id_barang', $id_barang)
                        ->lockForUpdate()
                        ->firstOrFail();
                    if ($totalStok < $jumlahDiminta) {
                        // jika stok nya tidak cukup
                        throw new Exception(
                            "Stok tidak mencukupi" . " Barang : "
                                . $barang->nama_barang . " Permintaan : " .
                                $jumlahDiminta .
                                " Stok yang tersedia : "
                                .  $totalStok,

                        );
                    }

                    foreach ($batches as $batch) {

                        $lastDetail = BarangkeluarDetailPending::orderBy('id_detail_pending', 'desc')->first();
                        if ($lastDetail) {
                            $nomor = (int) substr($lastDetail->kd_barang_masuk_pending, 2) + 1;
                        } else {
                            $nomor = 1;
                        }
                        $kodeDetail = 'BD' . str_pad($nomor, 3, '0', STR_PAD_LEFT);
                        if ($sisaPermintaan <= 0) {
                            break;
                        }

                        $jumlahDiambil = min($sisaPermintaan, $batch->sisa);
                        BarangkeluarDetailPending::create([
                            'id_detail_pending' => $kodeDetail,
                            'kd_barang_keluar_pending' => $kode,
                            'kd_barang_masuk' => $batch->kd_barang_masuk,
                            'jumlah_yang_diambil' => $jumlahDiambil
                        ]);

                        $sisaPermintaan -= $jumlahDiambil;
                    }
                }

                 ApprovalRequest::create([
                        'kd_transaksi_pending' => $kode,
                        'user_id' => Auth::id(),
                        'modul' => 'Barang keluar',
                        'aksi' => 'Input',
                        'tanggal_request' => Carbon::now()
                    ]);

                    History::create([
                        'user_id' => Auth::id(),
                        'id_referesni' => $kode,
                        'keterangan' => Auth::user()->name . ' Mengirim permintaan untuk menginput barang keluar dengan kode : ' . $kode,
                        'tanggal' => Carbon::now()
                    ]);
                    
            });
            return redirect('/barang-keluar')->with('pending', 'Data barang keluar berhasil diinput, sedang menunggu persetujuan manager!');
        } catch (\Exception $e) {
            // dd($e);
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function detail($id)
    {
        $item = BarangkeluarHeader::where('kd_barang_keluar', $id)->firstOrFail();
        $itemDetail = BarangkeluarDetail::with('barang_masuk.barang_master')->where('kd_barang_keluar', $id)->get();


        return view('barang.detail-barang-keluar', [
            'itemHeader' => $item,
            'itemDetail' => $itemDetail,
            'title' => 'Detail barang keluar'
        ]);
    }
    public function getBarangForDelete($id)
    {
        $item = BarangkeluarHeader::where('kd_barang_keluar', $id)->firstOrFail();
        $user = User::where('id', $item->user_id)->firstOrFail();
        try {
            DB::transaction(function () use ($item, $user) {
                ApprovalRequest::create([
                    'kd_transaksi_pending' => $item->kd_barang_keluar,
                    'user_id' => $item->user_id,
                    'modul' => 'Barang keluar',
                    'tanggal_request' => Carbon::now(),
                    'aksi' => 'Delete',
                ]);

                History::create([
                    'user_id' => $item->user_id,
                    'keterangan' => $user->name . " Melakukan Delete barang keluar dengan kode : " . $item->kd_barang_keluar . " Sedang menunggu persetujuan manager",
                    'tanggal' => Carbon::now()
                ]);
            });

            return redirect('/barang-keluar')->with('pending', ' Permintaan delete barang berhasil. Sedang menunggu persetujuan manager');
        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
            //throw $th;
        }
    }

    public function cetak()
    {
        return view('barang.cetak-barang-keluar', [
            'title' => 'cetak barang keluar',
            'data' => collect(),
            'jenisLaporan' => ''
        ]);
    }

    public function filterBarangKeluar(Request $request)
    {
        // dd([$request->bulan,$request->tahun]);
        $query = BarangkeluarHeader::with(['detail.barang_masuk', 'users']);
        $request->validate([
            'laporan' => 'required'
        ]);
        if ($request->laporan === 'harian') {
            $request->validate([
                'tanggal_awal' => 'required|date',
                'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal'
            ]);

            $query
                ->whereDate('tanggal_keluar', '>=', $request->tanggal_awal)
                ->whereDate('tanggal_keluar', '<=', $request->tanggal_akhir);

            $filterFirst = $request->tanggal_awal;
            $filterSecond = $request->tanggal_akhir;
        } else if ($request->laporan === 'bulan') {
            $request->validate([
                'bulan' => 'required|integer|between:1,12',
                'tahun' => 'required|integer'
            ]);

            $query
                ->whereMonth('tanggal_keluar', $request->bulan)
                ->whereYear('tanggal_keluar', $request->tahun);

            $filterFirst = $request->bulan;
            $filterSecond = $request->tahun;
        }

        $data = $query
            ->orderBy('tanggal_keluar', 'asc')
            ->get();

        if ($data->isEmpty()) {
            return back()
                ->withInput()
                ->with('error', "Data tidak ditemukan");
        }

        return view('barang.cetak-barang-keluar', [
            'data' => $data,
            'title' => 'cetak barang keluar',
            'filterFirst' => $filterFirst,
            'filterSecond' => $filterSecond,
            'jenisLaporan' => $request->laporan
        ]);
    }
}
