@extends('layout.home')

@section('content')
    <h1 class="mt-4">Approval Request</h1>

    <table class="table mt-5" border="1">
        <thead>
            <tr>
                <th class="text-center" scope="col-md-2">Kd Transaksi Pending</th>
                <th class="text-center" scope="col-md-4">User</th>
                <th class="text-center" scope="col-md-2">Modul</th>
                <th class="text-center" scope="col-md-2">Aksi</th>
                <th class="text-center" scope="col-md-2">Tanggal Request</th>
                <th class="text-center" scope="col-md-2">Status</th>
                <th class="text-center" scope="col-md-2">Actions</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($data as $item)
                <tr>
                    <th class="text-center" scope="row">{{ $item->kd_transaksi_pending }}</th>
                    <td class="text-center">{{ $item->user->name }}</td>
                    <td class="text-center">{{ $item->modul }}</td>
                    <td class="text-center">{{ $item->aksi }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_request)->translatedFormat('d F Y') }}
                    </td>
                    @if ($item->status === 'pending')
                        <td class="text-center"> <span class="badge bg-warning text-light">{{ $item->status }}</span></td>
                    @elseif ($item->status === 'approved')
                        <td class="text-center"><span class="badge bg-success text-light">{{ $item->status }}</span></td>
                    @else
                        <td class="text-center"><span class="badge bg-danger text-light">{{ $item->status }}</span></td>
                    @endif

                    @can('update-approval-request')
                        @if ($item->status !== 'approved')
                            <td class="text-center">
                                <a href="/update/approval/{{ Str::slug($item->modul) }}/{{ $item->aksi }}/{{ $item->kd_transaksi_pending }}/{{ $item->id_request }}"
                                    class="btn btn-primary">Update</a>
                            </td>
                        @endif
                    @endcan
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
