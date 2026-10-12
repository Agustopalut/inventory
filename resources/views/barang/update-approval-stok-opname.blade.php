@extends('layout.home')

@section('content')
    <form action="/update/approval/stok-opname/{{ $id }}/{{ $aksi }}" method="post">
        @csrf
        @method('PATCH')
        <div class="row align-middle">
            <div class="col-md-6">
                <h1 class="mt-4">Approval Stok Opname : {{ $aksi }}</h1>
            </div>
            <div class="col-md-6 text-end mt-4">
                <button type="submit" class="btn btn-primary" name="submit">Update</button>
            </div>
        </div>
        <input type="hidden" name="id_request" value="{{ $id_request }}">
        <div class="row mt-2">
            <div class="col-md-2">
                <span>ID Request</span>
            </div>
            <div class="col-sm-1">
                <span>:</span>
            </div>
            <div class="col-md-4">
                <input type="text" class="form form-control border-top-0 border-start-0 border-end-0 border border-dark"
                    readonly value="{{ $id_request }}">
            </div>
            <div class="col-md-5"></div>
        </div>
        <div class="row mt-2">
            <div class="col-md-2">
                <span>Kd Transaksi</span>
            </div>
            <div class="col-sm-1">
                <span>:</span>
            </div>
            <div class="col-md-4">
                <input type="text" class="form form-control border-top-0 border-start-0 border-end-0 border border-dark"
                    readonly value="{{ $kode }}">
            </div>
            <div class="col-md-5"></div>
        </div>
        <div class="row mt-2">
            <div class="col-md-2">
                <span>Tanggal keluar</span>
            </div>
            <div class="col-sm-1">
                <span>:</span>
            </div>
            <div class="col-md-4">
                <input type="date" class="form form-control border-top-0 border-start-0 border-end-0 border border-dark"
                    readonly value="{{ $opnameHeader->tangga_opname }}">
            </div>
            <div class="col-md-5"></div>
        </div>
        <div class="row mt-2">
            <div class="col-md-2">
                <span>Status</span>
            </div>
            <div class="col-sm-1">
                <span>:</span>
            </div>
            <div class="col-md-4">
                <select name="status" id=""
                    class="form-select mt-3 @error('status')
                            is-invalid
                        @enderror"
                    id="approval"">
                    <option value="" selected>Pending</option>
                    <option value="approved">Approve</option>
                    <option value="rejected">Reject</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-5"></div>
        </div>
        <div class="row mt-2">
            <div class="col-md-2">
                <span>Keterangan</span>
            </div>
            <div class="col-sm-1">
                <span>:</span>
            </div>
            <div class="col-md-4">
            </div>
            <div class="col-md-5"></div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <textarea name="" id="" cols="120" rows="5" draggable="off" readonly>{{ $opnameHeader->keterangan }}</textarea>
            </div>
        </div>

        <div class="card mt-4">

            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama barang</th>
                        <th class="text-center">Stok sistem</th>
                        <th class="text-center">Stok fisik</th>
                        <th class="text-center">Selisih</th>
                        <th class="text-center">Satuan</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($opnameDetail as $item)
                        <tr class="text-center">
                            <th class="">{{ $loop->iteration }}</th>
                            <td><input type="text" value="{{ $item->barang_master->nama_barang }}" readonly></td>
                            <td><input type="text" value="{{ $item->stok_sistem }}" readonly></td>
                            <td><input type="text" value="{{ $item->stok_fisik }}" readonly></td>
                            @if ($item->stok_fisik > $item->stok_sistem)
                                <td><input type="text" value="+{{ $item->stok_fisik - $item->stok_sistem }}" readonly></td>
                            @elseif ($item->stok_fisik < $item->stok_sistem)
                                <td><input type="text" value="{{ $item->stok_fisik - $item->stok_sistem }}" readonly></td>
                            @else
                                <td><input type="text" value="{{ $item->stok_fisik - $item->stok_sistem }}" readonly></td>
                            @endif
                            <td><input type="text" value="{{ $item->barang_master->satuan }}" readonly></td
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </form>
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