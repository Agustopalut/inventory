@extends('layout.home')

@section('content')
    <h1 class="mt-4">Daftar Permintaan Persetujuan</h1>

    @php
        $hasPending = $data->contains('status', 'Menunggu Persetujuan');
    @endphp

    <table class="table mt-5" border="1">
        <thead>
            <tr>
                <th class="text-center" scope="col-md-2">Kode Transaksi</th>
                <th class="text-center" scope="col-md-4">Diinput Oleh</th>
                <th class="text-center" scope="col-md-2">Modul</th>
                <th class="text-center" scope="col-md-2">Aksi</th>
                <th class="text-center" scope="col-md-2">Tanggal Permintaan</th>
                <th class="text-center" scope="col-md-2">Status</th>
                @can('update-approval-request')
                    @if ($hasPending)
                        <th class="text-center" scope="col-md-2">Aksi</th>
                    @endif
                @endcan

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
                    @if ($item->status === 'Menunggu Persetujuan')
                        <td class="text-center"> <span class="badge bg-warning text-light">{{ $item->status }}</span></td>
                    @elseif ($item->status === 'Disetujui')
                        <td class="text-center"><span class="badge bg-success text-light">{{ $item->status }}</span></td>
                    @else
                        <td class="text-center"><span class="badge bg-danger text-light">{{ $item->status }}</span></td>
                    @endif


                    @can('update-approval-request')
                        @if ($item->status !== 'Disetujui' && $item->status !== 'Ditolak')
                            <td class="text-center">
                                <a href="/update/approval/{{ Str::slug($item->modul) }}/{{ $item->aksi }}/{{ $item->kd_transaksi_pending }}/{{ $item->id_request }}"
                                    class="btn btn-primary">Ubah</a>
                            </td>
                        @endif
                    @endcan

                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-3 small-pagination">
        {{ $data->links() }}
    </div>
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
