<?php

namespace App\Http\Controllers;

use App\Models\ApprovalRequest;
use App\Models\Barangmaster;
use App\Models\History;
use App\Models\StokOpnameDetail;
use App\Models\StokOpnameDetailPending;
use App\Models\StokOpnameHeader;
use App\Models\StokOpnameHeaderPending;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StokopnameController extends Controller
{
    public function index()
    {
        $data = StokOpnameHeader::with('user')
            ->withCount('stok_opname_detail')
            ->latest()
            ->get();

        return view('barang.stok-opname', [
            'title' => 'stok opname',
            'stokopname' => $data
        ]);
    }
    public function input()
    {

        $item = Barangmaster::all();
        return view('barang.add-stok-opname', [
            'title' => 'input stok opname',
            'item' => $item
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|array',
            'id_barang.*' => 'required',
            'stok_fisik' => 'required|array',
            'stok_fisik.*' => 'required',
            'stok_sistem' => 'required|array',
            'stok_sistem.*' => 'required',
            'keterangan' => 'required',
            'tanggal_opname' => 'required'
        ], [
            'stok_fisik.required' => 'stok fisik wajib diisi',
            'stok_fisik.*.required' => 'setiap stok fisik wajib diisi',
            'stok_sistem.required' => 'stok sistem wajib diisi',
            'stok_sistem.*.required' => 'setiap stok sistem wajib diisi',
            'keterangan.required' => 'keterangan wajib diisi',
            'tanggal_opname.required' => 'Tanggal opname wajib diisi'
        ]);
        try {
            $last = StokOpnameHeaderPending::orderBy('kd_opname_pending', 'desc')->first();
            if ($last) {
                $nomor = (int) substr($last->kd_opname_pending, 2) + 1;
            } else {
                $nomor = 1;
            }
            $kode = 'SO' . str_pad($nomor, 3, '0', STR_PAD_LEFT);
            DB::transaction(function () use ($kode, $request) {
                ApprovalRequest::create([
                    'kd_transaksi_pending' => $kode,
                    'user_id' => Auth::id(),
                    'modul' => 'Stok opname',
                    'tanggal_request' => Carbon::now(),
                    'aksi' => 'Menambah'
                ]);

                StokOpnameHeaderPending::create([
                    'kd_opname_pending' => $kode,
                    'tangga_opname' => $request->tanggal_opname,
                    'keterangan' => $request->keterangan,
                    'user_id' => Auth::id()
                ]);

                foreach ($request->id_barang as $index => $item) {
                    StokOpnameDetailPending::create([
                        'id_barang' => $item,
                        'stok_sistem' => $request->stok_sistem[$index],
                        'stok_fisik' => $request->stok_fisik[$index],
                        'kd_opname_pending' => $kode
                    ]);
                }

                History::create([
                    'user_id' => Auth::id(),
                    'keterangan' => Auth::user()->name . ' Melakukan request input stok opname dengan kode : ' . $kode . ' Sedang menunggu persetujuan manager',
                    'tanggal' => Carbon::now()
                ]);
            });

            return redirect('/stok-opname')->with('pending', 'Permintaan menambah data stok opname berhasil dikirim, sedang menunggu persetujuan manager');
        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function detail($id)
    {
        $itemHeader = StokOpnameHeader::with('user')->where('kd_opname', $id)->firstOrFail();
        $itemDetail = StokOpnameDetail::with('barang_master')->where('kd_opname', $id)->get();

        return view('barang.detail-stok-opname', [
            'title' => 'Detail stok opname',
            'header' => $itemHeader,
            'detail' => $itemDetail
        ]);
    }

    public function delete($id)
    {
        $opnameHeader = StokOpnameHeader::where('kd_opname', $id)->firstOrFail();

        try {

            DB::transaction(function () use ($opnameHeader, $id) {
                ApprovalRequest::create([
                    'kd_transaksi_pending' => $id,
                    'user_id' => $opnameHeader->user_id,
                    'modul' => 'stok opname',
                    'tanggal_request' => Carbon::now(),
                    'aksi' => 'Menghapus'
                ]);

                History::create([
                    'user_id' => Auth::id(),
                    'keterangan' => Auth::user()->name . ' Menghapus data stok opname dengan kode : ' .  $id . ' Sedang menunggu persetujuan manager',
                    'tanggal' => Carbon::now()
                ]);
            });

            return redirect('/stok-opname')->with('pending', 'Permintaan menghapus data stok opname berhasil dikirim, sedang menunggu persetujuan manager');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function cetak()
    {
        return view('barang.cetak-stok-opname', [
            'title' => 'cetak stok opname',
            'data' => collect(),
            'jenisLaporan' => ''
        ]);
    }


    public function filter(Request $request)
    {
        $query = StokOpnameHeader::with(['stok_opname_detail.barang_master', 'user']);
        $request->validate([
            'laporan' => 'required'
        ]);

        if ($request->laporan === 'harian') {

            $request->validate([
                'tanggal_awal' => 'required|date',
                'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal'
            ]);

            $query
                ->whereDate('tangga_opname', '>=', $request->tanggal_awal)
                ->whereDate('tangga_opname', '<=', $request->tanggal_akhir);

            $filterFirst = $request->tanggal_awal;
            $filterSecond = $request->tanggal_akhir;
        } else if ($request->laporan === 'bulan') {

            $request->validate([
                'bulan' => 'required|integer|between:1,12',
                'tahun' => 'required|integer'
            ]);

            $query
                ->whereMonth('tangga_opname', $request->bulan)
                ->whereYear('tangga_opname', $request->tahun);

            $filterFirst = $request->bulan;
            $filterSecond = $request->tahun;
        }


        $data = $query
            ->orderBy('tangga_opname', 'asc')
            ->get();

        if ($data->isEmpty()) {
            return back()
                ->withInput()
                ->with('error', 'Data tidak ditemukan');
        }

        return view('barang.cetak-stok-opname', [
            'title' => 'cetak stok opname',
            'data' => $data,
            'jenisLaporan' => $request->laporan,
            'filterFirst' => $filterFirst,
            'filterSecond' => $filterSecond
        ]);
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;

        $stokopname = StokOpnameHeader::when($keyword !== '', fn($q) => $q->where('kd_opname', 'like', "%{$keyword}%"))
            ->latest()
            ->get();

        return response()->json([
            'html' => view('barang.table.table-stok-opname', [
                'stokopname' => $stokopname
            ])->render()
        ]);
    }
}
