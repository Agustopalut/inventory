<?php

namespace App\Http\Controllers;

use App\Models\Barangmaster;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class BarangmasterController extends Controller
{
    public function index()
    {

        $barang = Barangmaster::all();
        return view('barang.barang-master', [
            'title' => 'barang master',
            'data' => $barang
        ]);
    }

    public function input()
    {
        return view('barang.add-barang-master', [
            'title' => 'input barang master'
        ]);
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'nama_barang' => 'required',
            'satuan' => 'required',
        ], [
            'nama_barang.required' => 'nama barang wajib diisi',
            'satuan.required' => 'satuan wajib diisi'
        ]);

        $proses =  Barangmaster::create([
            'nama_barang' => $validated['nama_barang'],
            'satuan' => $validated['satuan'],
            'user_id' => Auth::id()
        ]);

        // dd($proses);

        History::create([
            'user_id' => Auth::id(),
            'id_referensi' => $proses->id_barang,
            'keterangan' => Auth::user()->name . ' menambahkan barang ' . $validated['nama_barang'],
            'tanggal' => Carbon::now()
        ]);


        return redirect('/barang-master')->with('success', 'data berhasil disimpan');
    }

    public function update($id)
    {
        // dd($id);
        $barang = Barangmaster::findOrFail($id);

        return view('barang.update-barang-master', [
            'title' => 'update barang master',
            'barang' => $barang
        ]);
    }

    public function edit(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_barang' => 'required',
            'satuan' => 'required',
        ], [
            'nama_barang.required' => 'nama barang wajib diisi',
            'satuan.required' => 'satuan wajib diisi'
        ]);


        $barang = Barangmaster::findOrFail($id);

        $barang->update([
            'nama_barang' => $validated['nama_barang'],
            'satuan' => $validated['satuan']
        ]);

        // dd($barang);
        History::create([
            'user_id' => Auth::id(),
            'id_referensi' => $barang->id_barang,
            'keterangan' => Auth::user()->name . ' melakukan update barang ' . $validated['nama_barang'],
            'tanggal' => Carbon::now()
        ]);

        return redirect('/barang-master')->with('success', 'Data berhasil di perbaharui');
    }

    public function destroy($id) {
        $barang = Barangmaster::findOrFail($id);
        $namaBarang = $barang->nama_barang;
        $barang->delete();

        History::create([
            'user_id' => Auth::id(),
            'keterangan' => Auth::user()->name . ' menghapus barang ' . $namaBarang,
            'tanggal' => Carbon::now()
        ]);

        return redirect('/barang-master')->with('success', 'Data berhasil di hapus');
    }

    public function detail($id) {
        
    }

    public function cetak() {
        $data = Barangmaster::with('user')->get();

        return view('barang.cetak-barang-master',[
            'title' => 'Cetak pdf barang master',
            'data' => $data
        ]);
    }
}
