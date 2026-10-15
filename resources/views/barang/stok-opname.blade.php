@extends('layout.home')

@section('content')
    <h1 class="mt-4">Stok opname</h1>

    <div class="row mt-3">
        @can('input-stok-opname')
            <div class="col-md-9">
                <a href="/input/stok-opname" class="btn btn-primary">Input data</a>
            </div>
        @endcan
        <div class="col-md-3">
            <input type="text" class="form-control-md w-70 form-control left cari-user" placeholder="Cari stok opname">
        </div>
    </div>
    <table class="table mt-3">
        <thead>
            <tr class="text-center">
                <th scope="col-md-2">Kd Opname</th>
                <th scope="col-md-4">Tanggal</th>
                <th scope="col-md-4">User</th>
                <th scope="col-md-4">Jumlah barang yang dicek</th>
                <th scope="col-md-2">Action</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($data as $item)
                <tr class="text-center">
                    <td>{{ $item->kd_opname }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tangga_opname)->translatedFormat('d F Y')  }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->stok_opname_detail_count }}</td>
                    <td>
                        <a href="/detail/stok-opname/{{ $item->kd_opname }}" class="btn btn-primary">Details</a>

                        @can('delete-stok-opname')
                            <form action="/delete/stok-opname/{{ $item->kd_opname }}" class="d-inline" method="POST">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-danger btn-delete">Delete</button>
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
@endpush
