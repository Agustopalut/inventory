@extends('layout.home')

@section('content')
    <h1 class="mt-4">Input Barang masuk</h1>

    <div class="card mt-4">
        <form action="/input-barang-masuk" method="post">
            @csrf
            <div class="card-header text-end">
                <button class="btn btn-primary btn-sm" type="submit" name="submit">Simpan</button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 w-50">
                        <label for="namaBarang" class="form-label">Pilih barang : </label>
                        <select class="form-select" name="id_barang" id="id_barang">
                            <option value="" selected>Pilih Barang : </option>
                            @foreach ($data as $item )
                                <option value="{{ $item->id_barang }}">{{ $item->nama_barang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 w-50">
                        <label for="satuanBarang" class="form-label">Satuan </label>
                        <input type="text" class="form-control form-satuan" id="satuanBarang" disabled readonly>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-6">
                        <label for="hargaSatuan" class="form-label">Harga satuan </label>
                        <input type="text" class="form-control" name="harga_satuan" id="hargaSatuan" >
                    </div>
                    <div class="col-md-6">
                        <label for="jumlahBarang" class="form-label">Jumlah Masuk </label>
                        <input type="text" class="form-control" name="jumlah" id="jumlahBarang">
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-6">
                        <label for="subTotal" class="form-label">Subtotal </label>
                        <input type="text" class="form-control" id="subTotal" disabled readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggalMasuk">Tanggal masuk</label>
                        <input type="date" class="form-control" name="tanggal_masuk" id="tanggalMasuk">
                    </div>
                </div>

            </div>
        </form>
    </div>
@endsection
