@extends('layout.home')

@section('content')
    <h1 class="mt-4">Menambah Barang Masuk</h1>

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
                        <select class="form-select @error('id_barang') is-invalid
                        @enderror"
                            name="id_barang" id="id_barang">
                            <option value="" selected>Pilih Barang : </option>
                            @foreach ($data as $item)
                                <option value="{{ $item->id_barang }}">{{ $item->nama_barang }}</option>
                            @endforeach
                        </select>
                        @error('id_barang')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6 w-50">
                        <label for="satuanBarang" class="form-label">Satuan </label>
                        <input type="text" class="form-control form-satuan" id="satuanBarang" disabled readonly>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-6">
                        <label for="hargaSatuan" class="form-label">Harga satuan </label>
                        <input type="text"
                            class="form-control @error('harga_satuan') is-invalid
                        @enderror "
                            name="harga_satuan" value="{{ old('harga_satuan') }}" id="hargaSatuan">
                        @error('harga_satuan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="jumlahBarang" class="form-label">Jumlah Masuk </label>
                        <input type="text"
                            class="form-control @error('jumlah') is-invalid
                        @enderror"
                            name="jumlah" value="{{ old('jumlah') }}" id="jumlahBarang">
                        @error('jumlah')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-6">
                        <label for="subTotal" class="form-label">Subtotal </label>
                        <input type="text" class="form-control" id="subTotal" disabled readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggalMasuk">Tanggal masuk</label>
                        <input type="date"
                            class="form-control @error('tanggal_masuk') is-invalid
                        @enderror"
                            name="tanggal_masuk" value="{{ old('tanggal_masuk') }}" id="tanggalMasuk">
                        @error('tanggal_masuk')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

            </div>
        </form>
    </div>
@endsection
