<?php

namespace App\Http\Controllers;

use App\Models\BarangkeluarHeader;
use App\Models\Barangmaster;
use App\Models\Barangmasuk;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        $data = History::orderBy('id','desc')
            ->paginate(10);
        $barangMasuk = Barangmasuk::whereMonth('tanggal_masuk',Carbon::now()->month)
                    ->whereYear('tanggal_masuk',Carbon::now()->year)
                     ->get();
        $barangKeluar = BarangkeluarHeader::whereMonth('tanggal_keluar',Carbon::now()->month)
                    ->whereYear('tanggal_keluar',Carbon::now()->year)
                     ->get();
        $barangMaster = Barangmaster::all();
        $totalpriceInventory = Barangmasuk::sum(
            DB::raw('sisa * harga_satuan')
        );
        return view('dashboard', [
            'title' => 'dashboard',
            'data' => $data,
            'barangMasuk' => $barangMasuk,
            'barangKeluar' => $barangKeluar,
            'barangMaster' => $barangMaster,
            'totalPrice' =>  $totalpriceInventory
        ]);
    }
}
