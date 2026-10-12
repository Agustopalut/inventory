@extends('layout.home')

@section('content')
    <form action="/input/stok-opname" method="POST">
        @csrf
        @method('POST')
        <div class="row">
            <div class="col-md-6">
                <h1 class="mt-4">Input Stok opname</h1>
            </div>
            <div class="col-md-6">
                <input type="date" name="tanggal_opname" class="form-control mt-5" id="">
            </div>
        </div>

        <div class="mt-4">
            <span>Keterangan</span>
            <textarea name="keterangan" id="" class="form-control mt-2"></textarea>
        </div>
        <table class="table mt-3">
            <thead>
                <tr class="text-center">
                    <th scope="col">No</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Stok sistem</th>
                    <th scope="col">Stok fisik</th>
                    <th scope="col">Satuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($item as $data)
                    <input type="hidden" name="id_barang[]" class="form-control" value="{{ $data->id_barang }}" readonly>
                    <tr class="text-center">
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td><input type="text" value="{{ $data->nama_barang }}" class="form-control form-control-sm" readonly></td>
                        <td><input type="text" name="stok_sistem[]" value="{{ $data->stok }}" class="form-control form-control-sm" readonly></td>
                        <td><input type="text" name="stok_fisik[]" class="form-control form-control-sm"></td>
                        <td><input type="text" value="{{ $data->satuan }}" class="form-control form-control-sm" disabled readonly></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary mb-3 text-end ">Simpan</button>
    </form>
@endsection
