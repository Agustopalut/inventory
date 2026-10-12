@extends('layout.home')

@section('content')
    <h1 class="mt-4">Barang master</h1>

    <div class="row">
        @can('input-barang-master')
            <div class="col-md-9 mt-4">
                <a href="/input-barang-master" class="btn btn-primary">Tambah barang</a>
            </div>
        @endcan

        <div class="col-md-3">
            <input type="text" class="form-control-md w-70 form-control left cari-user" placeholder="Cari barang">
        </div>
    </div>
    <table class="table mt-5 w-100">
        <thead>
            <tr>
                <th class="text-center" scope="col">No</th>
                <th class="text-center" scope="col">Nama</th>
                <th class="text-center" scope="col">Satuan</th>
                <th class="text-center" scope="col">Stok</th>
                <th class="text-center" scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $barang)
                <tr>
                    <th class="text-center" scope="row">{{ $loop->iteration }}</th>
                    <td class="text-center">{{ $barang->nama_barang }}</td>
                    <td class="text-center">{{ $barang->satuan }}</td>
                    <td class="text-center">{{ $barang->stok }}</td>
                    <td class="text-center">
                        @can('update-barang-master')
                            <a href="/update/barang-master/{{ $barang->id_barang }}" class="btn btn-sm btn-primary">Update</a>
                        @endcan

                        <a href="/details-barang-master/{{ $barang->id_barang }}" class="btn btn-sm btn-success">Details</a>
                        @can('delete-barang-master')
                            <form action="/delete/barang-master/{{ $barang->id_barang }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger btn-delete">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@push('scripts')
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                confirmButtonColor: '#3085d6'
            });
        </script>
    @endif
@endpush
