@extends('layout.home')

@section('content')
    <h1 class="mt-4">Detail Barang masuk : {{ $barang->kd_barang_masuk }}</h1>

    <div class="card mt-4">
        <div class="card-header text-end">
            <a href="/barang-masuk" class="btn btn-primary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 w-50">
                    <label for="namaBarang" class="form-label"> Nama Baarang </label>
                    <input type="text" class="form-control form-satuan" id="namaBarang" value="{{ $barang->barang_master->nama_barang }}" disabled readonly>
                </div>
                <div class="col-md-6 w-50">
                    <label for="satuanBarang" class="form-label">Satuan </label>
                    <input type="text" class="form-control form-satuan" id="satuanBarang" value="{{ $barang->barang_master->satuan }}" disabled readonly>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-6">
                    <label for="hargaSatuan" class="form-label">Harga satuan </label>
                    <input type="text" class="form-control" name="harga_satuan" value="Rp{{ number_format($barang->harga_satuan, 0, ',', '.');}}" id="hargaSatuan" disabled readonly>
                </div>
                <div class="col-md-6">
                    <label for="jumlahBarang" class="form-label">Jumlah Masuk </label>
                    <input type="text" class="form-control" name="jumlah" value="{{ $barang->jumlah }}" id="jumlahBarang" disabled readonly>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-6">
                    <label for="subTotal" class="form-label">Subtotal </label>
                    <input type="text" class="form-control" id="subTotal" value="{{ $subtotal }}" disabled readonly>
                </div>
                <div class="col-md-6">
                    <label for="tanggalMasuk">Tanggal masuk</label>
                    <input type="date" class="form-control" name="tanggal_masuk" id="tanggalMasuk" value="{{ $barang->tanggal_masuk }}" disabled readonly>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-6">
                    <label for="user" class="form-label">User </label>
                    <input type="text" class="form-control" id="user" value="{{ $barang->user->name }}" disabled readonly>
                </div>
                <div class="col-md-6">
                </div>
            </div>

        </div>
    </div>
@endsection
