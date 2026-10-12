@extends('layout.home')

@section('content')
    <h1 class="mt-4">Update Barang master</h1>

    <div class="card mt-4">
        <form action="/update/barang-master/{{ $barang->id_barang }}" method="post">
            @csrf
            @method('PUT')
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
                        name="nama_barang" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $barang->nama_barang }}">
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
                    @enderror" name="satuan" id="exampleInputPassword1" value="{{ $barang->satuan }}">
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
