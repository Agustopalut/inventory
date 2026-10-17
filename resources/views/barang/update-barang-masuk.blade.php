@extends('layout.home')

@section('content')
    <h1 class="mt-4">Update Barang masuk</h1>

    <div class="card mt-4">
        <form action="/update/barang-masuk/{{ $barang->kd_barang_masuk }}" method="post">
            @csrf
            @method('PUT')
            <div class="card-header text-end">
                <button class="btn btn-primary btn-sm" type="submit" name="submit">Simpan</button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 w-50">
                        <label for="namaBarang" class="form-label"> Nama barang </label>
                        <input type="text" class="form-control form-satuan" id="namaBarang" value="{{ $barang->barang_master->nama_barang }}" disabled readonly>
                    </div>
                    <div class="col-md-6 w-50">
                        <label for="satuanBarang" class="form-label">Satuan </label>
                        <input type="text" class="form-control form-satuan" value="{{ $barang->barang_master->satuan }}" id="satuanBarang" disabled readonly>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-6">
                        <label for="hargaSatuan" class="form-label">Harga satuan </label>
                        <input type="text" class="form-control" name="harga_satuan" value="{{$barang->harga_satuan}}" id="hargaSatuan" >
                    </div>
                    <div class="col-md-6">
                        <label for="jumlahBarang" class="form-label">Jumlah Masuk </label>
                        <input type="text" class="form-control" name="jumlah" value="{{ $barang->jumlah }}" id="jumlahBarang">
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-6">
                        <label for="subTotal" class="form-label">Subtotal </label>
                        <input type="text" class="form-control" value="{{ $subtotal }}" id="subTotal" disabled readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggalMasuk">Tanggal masuk</label>
                        <input type="Date" class="form-control" value="{{ $barang->tanggal_masuk }}" name="tanggal_masuk" id="tanggalMasuk" disabled readonly>
                    </div>
                </div>

            </div>
        </form>
    </div>
@endsection
