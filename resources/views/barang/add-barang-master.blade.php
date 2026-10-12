@extends('layout.home')

@section('content')
    <h1 class="mt-4">Input Barang master</h1>

    <div class="card mt-4">
        <form action="/barang-master" method="post">
            @csrf
            <div class="card-header text-end">
                <button class="btn btn-primary btn-sm" type="submit" name="submit">Simpan</button>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Nama barang</label>
                    <input type="text"
                        class="form-control @error('nama_barang')
                            is-invalid
                        @enderror"
                        name="nama_barang" id="exampleInputEmail1" aria-describedby="emailHelp" autocomplete="off">
                    @error('nama_barang')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Satuan</label>
                    <input type="text" class="form-control @error('satuan')
                        is-invalid
                    @enderror" name="satuan" id="exampleInputPassword1" autocomplete="off">
                    @error('satuan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </form>
    </div>
@endsection
