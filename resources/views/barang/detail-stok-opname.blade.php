@extends('layout.home')

@section('content')
        <div class="row align-middle">
            <div class="col-md-6">
                <h1 class="mt-4">Detail Stok opname</h1>
            </div>
            <div class="col-md-6 text-end mt-4">
                <a href="/stok-opname" class="btn btn-primary">Kembali</a>
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
                    readonly value="{{ $header->kd_opname }}">
            </div>
            <div class="col-md-5"></div>
        <div class="row mt-2">
            <div class="col-md-2">
                <span>User</span>
            </div>
            <div class="col-sm-1">
                <span>:</span>
            </div>
            <div class="col-md-4">
                <input type="text" class="form form-control border-top-0 border-start-0 border-end-0 border border-dark"
                    readonly value="{{ $header->user->name }}">
            </div>
            <div class="col-md-5"></div>
        </div>
        <div class="row mt-2">
            <div class="col-md-2">
                <span>Tanggal opname</span>
            </div>
            <div class="col-sm-1">
                <span>:</span>
            </div>
            <div class="col-md-4">
                <input type="date" class="form form-control border-top-0 border-start-0 border-end-0 border border-dark"
                    readonly value="{{ $header->tangga_opname }}">
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
                <textarea name="" id="" cols="120" rows="5" draggable="off" readonly>{{ $header->keterangan }}</textarea>
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

                    @foreach ($detail as $item)
                        <tr>
                            <th class="text-center">{{ $loop->iteration }}</th>
                            <td class="text-center"><input type="text" class="form-control-sm text-center border-0"  value="{{ $item->barang_master->nama_barang }}" readonly></td>
                            <td class="text-center"><input type="text" class="form-control-sm text-center border-0" name="jumlah_yang_diambil[]" readonly value="{{ $item->stok_sistem }}"></td>
                            <td class="text-center"><input type="text" class="form-control-sm text-center border-0" name="jumlah_yang_diambil[]" readonly value="{{ $item->stok_fisik }}"></td>
                            @if ($item->stok_fisik > $item->stok_sistem)
                                <td class="text-center">+{{ $item->stok_fisik - $item->stok_sistem}}</td>
                            @elseif ($item->stok_fisik < $item->stok_sistem)
                                <td class="text-center">{{ $item->stok_fisik - $item->stok_sistem}}</td>
                            @else
                            <td class="text-center">{{ $item->stok_fisik - $item->stok_sistem}}</td>
                            @endif
                            <td class="text-center">{{ $item->barang_master->satuan}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
@endsection

