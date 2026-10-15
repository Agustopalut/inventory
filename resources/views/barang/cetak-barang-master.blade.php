@extends('layout.home')

@section('content')
    <h1 class="mt-4">Barang master</h1>

    <div class="row text-end  w-100">
        @can('cetak-pdf')
            <div class="col-md-12 mt-4">
                <a href="{{ route('print.barang-master') }}" class="btn btn-primary">Cetak pdf</a>
            </div>
        @endcan
    </div>
    <table class="table mt-5 w-100">
        <thead>
            <tr>
                <th class="text-center" scope="col">No</th>
                <th class="text-center" scope="col">Nama</th>
                <th class="text-center" scope="col">Satuan</th>
                <th class="text-center" scope="col">Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $barang)
                <tr>
                    <th class="text-center" scope="row">{{ $loop->iteration }}</th>
                    <td class="text-center">{{ $barang->nama_barang }}</td>
                    <td class="text-center">{{ $barang->satuan }}</td>
                    <td class="text-center">{{ $barang->stok }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
