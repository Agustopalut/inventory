@extends('layout.home')

@section('content')
    <h1 class="mt-4">Request production management</h1>

    <div class="row mt-4">
        @can('input-production-request')
            <div class="col-md-9">
                <a href="/input/production-request" class="btn btn-primary">Request barang</a>
            </div>
        @endcan

        <div class="col-md-3">
            <input type="text" class="form-control-md w-70 form-control left cari-user" placeholder="Cari request">
        </div>
    </div>
    <table class="table mt-4">
        <thead>
            <tr>
                <td class="text-center" scope="col-md-2">No</td>
                <td class="text-center" scope="col-md-4">ID Request </td>
                <td class="text-center" scope="col-md-2">Tanggal</td>
                <td class="text-center" scope="col-md-2">Total barang</td>
                <td class="text-center" scope="col-md-2">User</td>
                <td class="text-center" scope="col-md-2">Action</td>
            </tr>
        </thead>
        <tbody>
            @if ($data->isEmpty())
                <tr class="text-center">
                    <td colspan="5">Data masih kosong</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endif
            @foreach ($data as $item)
                <tr>
                    <td class="text-center" scope="row">{{ $loop->iteration }}</td>
                    <td class="text-center" scope="row">{{ $item->kd_production_request }}</td>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($item->tanggal_request)->locale('id')->translatedFormat('d F Y, h:i: a') }}
                    </td>
                    <td class="text-center">{{ $item->production_request_detail->count() }}</td>
                    <td class="text-center">{{ $item->user->name }}</td>
                    <td class="text-center">
                        <a href="{{ route('detail.production-request', ['id' => $item->kd_production_request]) }}"
                            class="btn btn-success btn-sm">Details</a>
                        <form action="{{ route('delete.production-request', ['id' => $item->kd_production_request]) }}"
                            class="d-inline" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm btn-delete">Delete</button>
                        </form>
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
