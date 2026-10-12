@extends('layout.home')

@section('content')
        <div class="row align-middle">
            <div class="col-md-6">
                <h1 class="mt-4">Detail production request</h1>
            </div>
            <div class="col-md-6 text-end mt-4">
                <a href="/production-request" class="btn btn-primary">Kembali</a>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-2">
                <span>Kode</span>
            </div>
            <div class="col-sm-1">
                <span>:</span>
            </div>
            <div class="col-md-4">
                <input type="text" class="form form-control border-top-0 border-start-0 border-end-0 border border-dark"
                    readonly value="{{ $itemHeader->kd_production_request }}">
            </div>
            <div class="col-md-5"></div>
        </div>
        <div class="row mt-2">
            <div class="col-md-2">
                <span>Tanggal request</span>
            </div>
            <div class="col-sm-1">
                <span>:</span>
            </div>
            <div class="col-md-4">
                <input type="datetime-local" class="form form-control border-top-0 border-start-0 border-end-0 border border-dark"
                    readonly value="{{ $itemHeader->tanggal_request }}">
            </div>
            <div class="col-md-5"></div>
        </div>
        {{-- user --}}
        <div class="row mt-2">
            <div class="col-md-2">
                <span>User</span>
            </div>
            <div class="col-sm-1">
                <span>:</span>
            </div>
            <div class="col-md-4">
                <input type="text" class="form form-control border-top-0 border-start-0 border-end-0 border border-dark"
                    readonly value="{{ $itemHeader->user->name }}">
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
                <textarea name="" id="" cols="120" rows="5" draggable="off" readonly>{{ $itemHeader->keterangan }}</textarea>
            </div>
        </div>

        <div class="card mt-4">

            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama barang</th>
                        <th class="text-center">Jumlah yang diambil</th>
                        <th class="text-center">Satuan</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($itemDetail as $item)
                        <tr>
                            <th class="text-center">{{ $loop->iteration }}</th>
                            <td class="text-center"><input type="text" value="{{ $item->barang_master->nama_barang }}" class="form-control-sm border-0 text-center" readonly></td>
                            <td class="text-center"><input type="text" class="form-control-sm text-center border-0" name="jumlah_yang_diambil[]" readonly value="{{ $item->jumlah_yang_diminta }}"></td>
                            <td class="text-center">{{ $item->barang_master->satuan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
@endsection

