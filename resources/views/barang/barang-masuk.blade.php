@extends('layout.home')

@section('content')
    <h1 class="mt-5">Barang masuk</h1>

    <div class="row mt-5">
        @can('input-barang-masuk')
            <div class="col-md-9">
                <a href="/input-barang-masuk" class="btn btn-primary">Tambah barang</a>
            </div>
        @endcan

        <div class="col-md-3">
            <input type="text" class="form-control-md w-70 form-control left cari-user" placeholder="Cari barang masuk">
        </div>
    </div>
    <table class="table mt-4">
        <thead>
            <tr>
                <td class="text-center" scope="col-md-2">Kd barang masuk</td>
                <td class="text-center" scope="col-md-2">Tanggal masuk</td>
                <td class="text-center" scope="col-md-4">Nama barang</td>
                <td class="text-center" scope="col-md-2">Jumlah</td>
                <td class="text-center" scope="col-md-2">Sisa</td>
                <td class="text-center" scope="col-md-2">Harga satuan</td>
                <td class="text-center" scope="col-md-2">Subtotal</td>
                <td class="text-center" scope="col-md-2">Actions</td>
            </tr>
        </thead>
        <tbody>

            @foreach ($data as $item)
                <tr>
                    <th class="text-center" scope="row">{{ $item->kd_barang_masuk }}</th>
                    <td class="text-center" scope="row">
                        {{ \Carbon\Carbon::parse($item->tanggal_masuk)->translatedFormat('d F Y') }}</td>
                    <td class="text-center">{{ $item->barang_master->nama_barang }}</td>
                    <td class="text-center">{{ $item->jumlah }}</td>
                    <td class="text-center">{{ $item->sisa }}</td>
                    <td class="text-center">Rp{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td class="text-center">Rp{{ number_format($item->harga_satuan * $item->jumlah, 0, ',', '.') }}</td>
                    <td class="text-center">
                        <a href="/details/barang-masuk/{{ $item->kd_barang_masuk }}" class="btn btn-primary btn-sm">Details</a>
                        @can('update-barang-masuk')
                            <a href="/update/barang-masuk/{{ $item->kd_barang_masuk }}" class="btn btn-success btn-sm">Update</a>
                        @endcan

                        @can('delete-barang-masuk')
                            <form action="/delete/barang-masuk/{{ $item->kd_barang_masuk }}" class="d-inline" method="GET">
                                @csrf
                                <button type="submit" class="btn btn-delete btn-danger btn-sm">Delete</button>
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

    @if (session('pending'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Berhasil',
                text: "{{ session('pending') }}",
                confirmButtonColor: '#3085d6'
            });
        </script>
    @endif
@endpush
