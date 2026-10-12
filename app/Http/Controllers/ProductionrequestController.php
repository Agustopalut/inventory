<?php

namespace App\Http\Controllers;

use App\Models\Barangmaster;
use App\Models\History;
use App\Models\ProductionRequestDetail;
use App\Models\ProductionRequestHeader;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductionrequestController extends Controller
{
    public function index()
    {
        $data = ProductionRequestHeader::with(['production_request_detail', 'user'])
                ->orderBy('tanggal_request','desc')
                ->get();

        return view('barang.production-request', [
            'title' => 'production request',
            'data' => $data
        ]);
    }
    public function input(Request $request)
    {
        $barang = Barangmaster::all();
        return view('barang.add-production-request', [
            'title' => 'add production request',
            'barang' => $barang
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|array',
            'id_barang.*' => 'required|integer',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer',
            'keterangan' => 'nullable',
            'tanggal_request' => 'required'
        ]);

        $idBarang = $request->id_barang;
        $jumlah = $request->jumlah;

        $last = ProductionRequestHeader::orderBy('kd_production_request', 'desc')->first();
        if ($last) {
            $nomor = (int) substr($last->kd_production_request, 2) + 1;
        } else {
            $nomor = 1;
        }
        $kode = 'RP' . str_pad($nomor, 3, '0', STR_PAD_LEFT);
        
        try {

            DB::transaction(function () use ($request, $idBarang, $jumlah, $kode) {

                ProductionRequestHeader::create([
                    'kd_production_request' => $kode,
                    'keterangan' => $request->keterangan,
                    'tanggal_request' => $request->tanggal_request,
                    'user_id' => Auth::id()
                ]);
                foreach ($idBarang as $index => $item) {
                    ProductionRequestDetail::create([
                        'kd_production_request' => $kode,
                        'id_barang' => $item,
                        'jumlah_yang_diminta' => $jumlah[$index]
                    ]);
                }

                History::create([
                    'user_id' => Auth::id(),
                    'keterangan' => Auth::user()->name . ' Menginput production request dengan kode :' . $kode,
                    'tanggal' => Carbon::now()
                ]);

            });

            return redirect('/production-request')->with('success','Data berhasil diinput');
            
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error',$e->getMessage());
        }
    }

    public function delete($id) {
        ProductionRequestDetail::where('kd_production_request',$id)->delete();
        $header = ProductionRequestHeader::where('kd_production_request',$id)->firstOrFail();
        $header->delete();

        return redirect('/production-request')->with('success','Data berhasil dihapus');
    }

    public function detail($id) {
        $itemHeader = ProductionRequestHeader::with(['production_request_detail.barang_master','user'])
                    ->where('kd_production_request',$id)
                    ->firstOrFail();

        return view('barang.detail-production-request',[
            'title' => 'Detai production request',
            'itemHeader' => $itemHeader,
            'itemDetail' => $itemHeader->production_request_detail
        ]);


    }
}
