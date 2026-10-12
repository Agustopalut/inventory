<?php

namespace App\Http\Controllers;

use App\Models\ApprovalRequest;
use App\Models\BarangkeluarDetail;
use App\Models\BarangkeluarDetailPending;
use App\Models\BarangkeluarHeader;
use App\Models\BarangkeluarHeaderPending;
use App\Models\Barangmaster;
use App\Models\Barangmasuk;
use App\Models\BarangMasukPending;
use App\Models\History;
use App\Models\StokOpnameDetail;
use App\Models\StokOpnameDetailPending;
use App\Models\StokOpnameHeader;
use App\Models\StokOpnameHeaderPending;
use Carbon\Carbon;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApprovalRequestController extends Controller
{
    public function index()
    {

        $data = ApprovalRequest::all();
        return view('barang.approval-request', [
            'title' => 'Approval Request',
            'data' => $data
        ]);
    }

    public function getModul($modul, $aksi, $id, $idrequest)
    {
        switch ($modul) {
            case 'barang-masuk':
                // dd($id);
                $barang = BarangMasukPending::with('barang_master')->where('kd_barang_masuk_pending', $id)->firstOrFail();
                // dd($barang->barang_master);
                $idRequest = ApprovalRequest::where('kd_transaksi_pending', $id)
                    ->where('aksi', $aksi)
                    ->where('id_request', $idrequest)
                    ->firstOrFail();
                // dd($idRequest);
                $subTotal = $barang->harga_satuan * $barang->jumlah;
                $hargaTotal = 'Rp' . number_format($subTotal, 0, ',', '.');
                return view('barang.update-approval-barang-masuk', [
                    'title' => 'update approval barang masuk',
                    'data' => $barang,
                    'id_referensi' => $idRequest,
                    'subTotal' => $hargaTotal,
                    'aksi' => $aksi,
                    'idRequest' => $idRequest->id_request
                ]);

            case 'barang-keluar':
                $barangHeaderPending = BarangkeluarHeaderPending::where('kd_barang_keluar_pending', $id)->firstOrFail();
                $barangDetailPending = BarangkeluarDetailPending::with('barang_masuk.barang_master')->where('kd_barang_keluar_pending', $id)->get();

                return view('barang.update-approval-barang-keluar', [
                    'title' => 'update approval barang keluar',
                    'aksi' => $aksi,
                    'id_request' => $idrequest,
                    'kode' => $barangHeaderPending->kd_barang_keluar_pending,
                    'keterangan' => $barangHeaderPending->keterangan,
                    'tanggal_keluar' => $barangHeaderPending->tanggal_keluar,
                    'barangDetail' => $barangDetailPending,
                    'id' => $id
                ]);

            case 'stok-opname':
                $opnameHeader = StokOpnameHeaderPending::where('kd_opname_pending', $id)->firstOrFail();
                $opnameDetail = StokOpnameDetailPending::with('barang_master')->where('kd_opname_pending', $id)->get();
                // dd($opnameDetail->barang_master);

                return view('barang.update-approval-stok-opname', [
                    'title' => 'update approval stok opname',
                    'aksi' => $aksi,
                    'id_request' => $idrequest,
                    'id' => $id,
                    'opnameHeader' => $opnameHeader,
                    'opnameDetail' => $opnameDetail,
                    'kode' => $opnameHeader->kd_opname_pending
                ]);
        }
    }

    public function updateStatusBarangout(Request $request, $id, $aksi)
    {
        if ($aksi === 'Input') {
            $validated = $request->validate([
                'status' => 'required'
            ], [
                'status.required' => 'status wajib dipilih'
            ]);



            DB::transaction(function () use ($id, $request, $aksi, $validated) {
                $barangKeluarHeaderPending = BarangkeluarHeaderPending::where('kd_barang_keluar_pending', $id)->firstOrFail();

                BarangkeluarHeader::create([
                    'kd_barang_keluar' => $barangKeluarHeaderPending->kd_barang_keluar_pending,
                    'tanggal_keluar' => $barangKeluarHeaderPending->tanggal_keluar,
                    'user_id' => $barangKeluarHeaderPending->user_id,
                    'keterangan' => $barangKeluarHeaderPending->keterangan,
                    'tujuan' => $barangKeluarHeaderPending->tujuan
                ]);

                foreach ($request->kd_barang_masuk as $index => $kdBarangMasuk) {
                    $barangMasuk = Barangmasuk::with('barang_master')->where('kd_barang_masuk', $kdBarangMasuk)
                        ->lockForUpdate()
                        ->firstOrFail();
                    $jumlah = $request->jumlah_yang_diambil[$index];
                    $barang = $barangMasuk->barang_master;

                    if ($barangMasuk->sisa < $jumlah) {
                        throw new ErrorException('Stok tidak mencukupi');
                    }

                    $barangMasuk->sisa -= $jumlah;
                    $barangMasuk->save();

                    BarangkeluarDetail::create([
                        'kd_barang_keluar' => $barangKeluarHeaderPending->kd_barang_keluar_pending,
                        'kd_barang_masuk' => $kdBarangMasuk,
                        'jumlah_yang_diambil' => $jumlah
                    ]);
                    $barang->decrement('stok',$jumlah);
                }
                $keterangan = Auth::user()->name . " Mengubah status request barang keluar dengan kd : " . $id . " menjadi approved";
                // untuk history
                History::create([
                    'user_id' => Auth::id(),
                    'keterangan' => $keterangan,
                    'tanggal' => Carbon::now()
                ]);

                $approval = ApprovalRequest::where('id_request', $request->id_request)
                    ->where('aksi', $aksi)
                    ->where('kd_transaksi_pending', $id)->firstOrFail();
                $approval->status = 'approved';
                $approval->save();
            });


            return redirect('/approval-request')->with('success', 'status berhasil di approved');
        } else {

            $validated = $request->validate([
                'status' => 'required',
            ]);

            try {
                DB::transaction(function () use ($request, $id, $aksi, $validated) {
                    $header = BarangkeluarHeader::where('kd_barang_keluar', $id)->firstOrFail();
                    // dd($header);

                    $itemDetail = BarangkeluarDetail::where('kd_barang_keluar', $id)->get();

                    foreach ($itemDetail as $item) {
                        // menangkap semua detail
                        $barangmasuk = Barangmasuk::with('barang_master')->where('kd_barang_masuk', $item->kd_barang_masuk)->firstOrFail();
                        $barang = $barangmasuk->barang_master;
                        // kembalikan semua yang diambil
                        $barangmasuk->sisa += $item->jumlah_yang_diambil;
                        $barang->stok += $item->jumlah_yang_diambil;
                       

                        // simpan
                        $barang->save();
                        $barangmasuk->save();
                    }

                    BarangkeluarDetail::where('kd_barang_keluar', $id)->delete();
                    BarangkeluarDetailPending::where('kd_barang_keluar_pending', $id)->delete();
                    BarangkeluarHeaderPending::where('kd_barang_keluar_pending',$id)->delete();
                    

                    $header->delete();

                    ApprovalRequest::where('id_request', $request->id_request)
                        ->where('aksi', $aksi)
                        ->where('kd_transaksi_pending', $id)->update([
                            'status' => $validated['status']
                        ]);

                    History::create([
                        'user_id' => Auth::id(),
                        'keterangan' => Auth::user()->name . " Sudah menyetujui untuk menghapus barang keluar dengan kode : " . $id,
                        'tanggal' => Carbon::now()
                    ]);
                });

                return redirect('/approval-request')->with('success', "Data berhasil dihapus");
            } catch (\Exception $e) {
                return back()
                    ->withInput()
                    ->with('error', $e->getMessage());
            }
        }
    }

    public function updateStatus(Request $request, $id_referensi, $aksi)
    {


        if ($aksi === 'Input') {
            $idRequest = $request->id_request;
            $validate = $request->validate(
                [
                    'status' => 'required'
                ],
                [
                    'status.required' => 'Status wajib dipilih'
                ]
            );
            $getApproval = ApprovalRequest::where('kd_transaksi_pending', $id_referensi)
                ->where('aksi', $aksi)
                ->where('id_request', $idRequest)
                ->firstOrFail();
            // dd($request->status);
            $getApproval->status = $validate['status'];

            $getApproval->save();

            $item = BarangMasukPending::with('barang_master')->where('kd_barang_masuk_pending', $id_referensi)->firstOrFail();
            Barangmasuk::create([
                'kd_barang_masuk' => $id_referensi,
                'id_barang' => $item->barang_master->id_barang,
                'jumlah' => $item->jumlah,
                'harga_satuan' => $item->harga_satuan,
                'sisa' => $item->sisa,
                'tanggal_masuk' => $item->tanggal_masuk,
                'user_id' => $item->user_id
            ]);

            $barangMaster = Barangmaster::where('id_barang', $item->id_barang)->first();
            $barangMaster->stok += $item->jumlah;
            $barangMaster->save();

            History::create([
                'user_id' => Auth::id(),
                'keterangan' => Auth::user()->name . ' Mengubah status request Barang masuk : ' . $id_referensi . ' menjadi approved',
                'tanggal' => Carbon::now()
            ]);

            return redirect('/approval-request')->with('success', 'Data barang masuk berhasil di Approved');
        } else if ($aksi === 'update') {
            $itemPending = BarangMasukPending::find($id_referensi);
            $barangMasuk = Barangmasuk::find($id_referensi);
            $getApproval = ApprovalRequest::where('kd_transaksi_pending', $id_referensi);
            $validate = $request->validate(
                [
                    'status' => 'required'
                ],
                [
                    'status.required' => 'Status wajib dipilih'
                ]
            );

            $barangMasuk->update([
                'jumlah' => $itemPending->jumlah,
                'harga_satuan' => $itemPending->harga_satuan
            ]);

            ApprovalRequest::where('kd_transaksi_pending', $id_referensi)->update([
                'status' => $validate['status']
            ]);

            History::create([
                'user_id' => Auth::id(),
                'keterangan' => Auth::user()->name . ' Mengubah status request update barang masuk menjadi approved dengan kode : ' . $id_referensi,
                'tanggal' => Carbon::now()
            ]);

            return redirect('/approval-request')->with('success', 'Data berhasil di approved');
        } else {
            $barangMasuk = Barangmasuk::with('barang_master')->where('kd_barang_masuk', $id_referensi)->firstOrFail();
            $namaBarang = $barangMasuk->barang_master->nama_barang;
            $barangMasukPending = BarangmasukPending::where('kd_barang_masuk_pending', $id_referensi)->firstOrFail();

            $barangMasuk->delete();
            $barangMasukPending->delete();

            History::create([
                'user_id' => Auth::id(),
                'keterangan' => Auth::user()->name . ' Menyetujui menghapus barang masuk ' . $namaBarang . ' dengan kode : ' . $id_referensi,
                'tanggal' => Carbon::now()
            ]);

            return redirect('/barang-masuk')->with('success', 'Barang masuk berhasil dihapus');
        }
    }

    public function deleteBarangKeluar($idrequest, $aksi, $kode)
    {
        try {
        } catch (\Exception $e) {
            //throw $th;
        }
    }

    public function updateStatusStokOpname(Request $request, $id, $aksi)
    {
        $validated = $request->validate([
            'status' => 'required'
        ], [
            'status.required' => 'Status wajib dipilih'
        ]);

        if ($aksi === 'Input') {
            try {
                DB::transaction(function () use ($request, $id, $aksi, $validated) {
                    $getApproval = ApprovalRequest::where('id_request', $request->id_request)
                        ->where('kd_transaksi_pending', $id)
                        ->where('aksi', $aksi)
                        ->firstOrFail();
                    $getApproval->status = $validated['status'];
                    $getApproval->save();

                    $opnameHeaderPending = StokOpnameHeaderPending::where('kd_opname_pending', $id)->firstOrCreate();
                    StokOpnameHeader::create([
                        'kd_opname' => $opnameHeaderPending->kd_opname_pending,
                        'tangga_opname' => $opnameHeaderPending->tangga_opname,
                        'keterangan' => $opnameHeaderPending->keterangan,
                        'user_id' => $opnameHeaderPending->user_id
                    ]);
                    $opnameDetailPending = StokOpnameDetailPending::where('kd_opname_pending', $id)->get();

                    foreach ($opnameDetailPending as $item) {
                        StokOpnameDetail::create([
                            'id_barang' => $item->id_barang,
                            'stok_fisik' => $item->stok_fisik,
                            'stok_sistem' => $item->stok_sistem,
                            'kd_opname' => $item->kd_opname_pending
                        ]);
                    }

                    History::create([
                        'user_id' => Auth::id(),
                        'keterangan' => Auth::user()->name . ' Mengubah status request stok opname dengan kode : ' . $opnameHeaderPending->kd_opname_pending . ' Menjadi ' . $validated['status'],
                        'tanggal' => Carbon::now()
                    ]);
                });

                return redirect('/approval-request')->with('success', 'Request berhasil di approved');
            } catch (\Exception $e) {
                return back()
                    ->wihtInput()
                    ->with('error', $e->getMessage());
            }
        } else {

            try {
                DB::transaction(function () use ($request, $id, $aksi,$validated) {

                    $getApproval = ApprovalRequest::where('kd_transaksi_pending', $id)
                        ->where('id_request', $request->id_request)
                        ->where('aksi', $aksi)
                        ->firstOrFail();
                    $getApproval->status = $validated['status'];
                    $getApproval->save();

                    $headerOpname = StokOpnameHeader::where('kd_opname',$id)->firstOrFail();
                    $headerOpnamePending = StokOpnameHeaderPending::where('kd_opname_pending',$id)->firstOrFail();
                    StokOpnameDetail::where('kd_opname',$id)->delete();
                    StokOpnameDetailPending::where('kd_opname_pending',$id)->delete();

                    $headerOpname->delete();
                    $headerOpnamePending->delete();

                    History::create([
                        'user_id' => Auth::id(),
                        'keterangan' => Auth::user()->name . ' Mengubah status request Delete stok opname dengan kode : ' . $id . ' Menjadi Approved',
                        'tanggal' => Carbon::now() 
                    ]);
                });

                return redirect('/approval-request')->with('success','Data request berhasil di approved');
            } catch (\Exception $e) {
                return back()
                    ->withInput()
                    ->with('error',$e->getMessage());
            }
        }
    }
}
