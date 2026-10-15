@extends('layout.home')

@section('content')
    <h1 class="mt-4">Barang Keluar</h1>

    <div class="row mt-2">
        @can('input-barang-keluar')
            <div class="col-md-9">
                <a href="/input/barang-keluar" class="btn btn-primary mt-2">Tambah barang</a>
            </div>
        @endcan

        <div class="col-md-3 mt-2">
            <input type="text" class="form-control-md w-70 form-control left cari-user" placeholder="Cari barang keluar">
        </div>
    </div>
    <table class="table mt-2">
        <thead>
            <tr>
                <th class="text-center" scope="col-md-2">Kd barang keluar</th>
                <td class="text-center" scope="col-md-4">Tanggal keluar </td>
                <td class="text-center" scope="col-md-2">Tujuan</td>
                <td class="text-center" scope="col-md-2">User</td>
                <td class="text-center" scope="col-md-2">Action</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <th class="text-center" scope="row">{{ $item->kd_barang_keluar }}</th>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_keluar)->translatedFormat('d F Y') }}
                    </td>
                    <td class="text-center">{{ $item->tujuan }}</td>
                    <td class="text-center">{{ $item->users->name }}</td>
                    <td class="text-center">
                        <a href="/barang-keluar/{{ $item->kd_barang_keluar }}" class="btn btn-success">Details</a>
                        @can('delete-barang-keluar')
                            <form action="/delete/barang-keluar/{{ $item->kd_barang_keluar }}" class="d-inline" method="GET">
                                @csrf
                                <button type="submit" class="btn btn-delete btn-danger">Delete</button>
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

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'danger',
                title: 'Gagal',
                text: "{{ session('error') }}",
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
