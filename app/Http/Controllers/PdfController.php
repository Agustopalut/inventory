<?php

namespace App\Http\Controllers;

use App\Models\BarangkeluarHeader;
use App\Models\Barangmaster;
use App\Models\Barangmasuk;
use App\Models\StokOpnameHeader;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function barang_master()
    {
        $barang = Barangmaster::all();
        $pdf = Pdf::loadView('pdf.barang-master-pdf', [
            'barang' => $barang
        ]);

        return $pdf->stream('barangmaster.pdf');
    }

    public function barang_masuk(Request $request)
    {
        $query = Barangmasuk::with(['barang_master', 'user']);
        if ($request->laporan === 'harian') {
            $request->validate([
                'filterFirst' => 'required|date',
                'filterSecond' => 'required|date|after_or_equal:filterFirst'
            ]);

            $query
                ->whereDate('tanggal_masuk', '>=', $request->filterFirst)
                ->whereDate('tanggal_masuk', '<=', $request->filterSecond);
        } else if ($request->laporan === 'bulan') {

            $request->validate([
                'filterFirst' => 'required|integer|between:1,12',
                'filterSecond' => 'required|integer'
            ]);

            $query
                ->whereMonth('tanggal_masuk', $request->filterFirst)
                ->whereYear('tanggal_masuk', $request->filterSecond);
        }

        $data = $query
            ->orderBy('tanggal_masuk', 'asc')
            ->get();

        if ($data->isEmpty()) {
            return back()
                ->withInput()
                ->with('error', "Data tidak ditemukan");
        }
        // generate
        $pdf = Pdf::loadView('pdf.barang-masuk-pdf', [
            'barangMasuk' => $data
        ]);

        return $pdf->stream('barangmasuk.pdf');
    }

    public function barang_keluar(Request $request)
    {
        $query = BarangkeluarHeader::with(['detail.barang_masuk', 'users']);
        if ($request->laporan === 'harian') {
            $request->validate([
                'filterFirst' => 'required|date',
                'filterSecond' => 'required|date|after_or_equal:filterFirst'
            ]);

            $query
                ->whereDate('tanggal_keluar', '>=', $request->filterFirst)
                ->whereDate('tanggal_keluar', '<=', $request->filterSecond);
        } else if ($request->laporan === 'bulan') {

            $request->validate([
                'filterFirst' => 'required|integer|between:1,12',
                'filterSecond' => 'required|integer'
            ]);

            $query
                ->whereMonth('tanggal_keluar', $request->filterFirst)
                ->whereYear('tanggal_keluar', $request->filterSecond);
        }

        $data = $query
            ->orderBy('tanggal_keluar', 'asc')
            ->get();

        if ($data->isEmpty()) {
            return back()
                ->withInput()
                ->with('error', "Data tidak ditemukan");
        }
        // generate
        $pdf = Pdf::loadView('pdf.barang-keluar-pdf', [
            'barangKeluar' => $data
        ]);

        return $pdf->stream('barangkeluar.pdf');
    }

    public function stok_opname(Request $request)
    {
        $query = StokOpnameHeader::with(['stok_opname_detail.barang_master', 'user']);
        $request->validate([
            'laporan' => 'required'
        ]);

        if ($request->laporan === 'harian') {

            $request->validate([
                'filterFirst' => 'required|date',
                'filterSecond' => 'required|date|after_or_equal:filterFirst'
            ]);

            $query
                ->whereDate('tangga_opname', '>=', $request->filterFirst)
                ->whereDate('tangga_opname', '<=', $request->filterSecond);

        } else if ($request->laporan === 'bulan') {

            $request->validate([
                'filterFirst' => 'required|integer|between:1,12',
                'filterSecond' => 'required|integer'
            ]);

            $query
                ->whereMonth('tangga_opname', $request->filterFirst)
                ->whereYear('tangga_opname', $request->filterSecond);

        }


        $data = $query
            ->orderBy('tangga_opname', 'asc')
            ->get();

        if ($data->isEmpty()) {
            return back()
                ->withInput()
                ->with('error', 'Data tidak ditemukan');
        }

        $pdf = Pdf::loadView('pdf.stok-opname-pdf', [
            'stokOpname' => $data
        ]);

        return $pdf->stream('stok-opname.pdf');
    


    }
}
