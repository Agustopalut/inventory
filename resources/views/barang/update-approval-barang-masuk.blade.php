@extends('layout.home')

@section('content')
    <h1 class="mt-4">Approval Barang masuk : {{ $aksi }}</h1>

    <div class="card mt-4">
        <form action="/update/approval/{{ $id_referensi->kd_transaksi_pending }}/{{ $aksi }}" method="post">
            @csrf
            <div class="card-header text-end">
                <button class="btn btn-primary btn-sm" type="submit" name="submit">Update</button>
            </div>
            <input type="hidden" name="id_request" value="{{ $idRequest }}">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 w-50">
                        <label for="namaBarang" class="form-label">Pilih barang : </label>
                        <input type="text" class="form-control" value="{{ $data->barang_master->nama_barang }}" readonly>
                    </div>
                    <div class="col-md-6 w-50">
                        <label for="satuanBarang" class="form-label">Satuan </label>
                        <input type="text" class="form-control form-satuan" id="satuanBarang"
                            value="{{ $data->barang_master->satuan }}" readonly>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-6">
                        <label for="hargaSatuan" class="form-label">Harga satuan </label>
                        <input type="text" class="form-control" name="harga_satuan" id="hargaSatuan"
                            value="{{ $data->harga_satuan }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="jumlahBarang" class="form-label">Jumlah Masuk </label>
                        <input type="text" class="form-control" name="jumlah" id="jumlahBarang"
                            value="{{ $data->jumlah }}" readonly>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-6">
                        <label for="subTotal" class="form-label">Subtotal</label>
                        <input type="text" class="form-control" id="subTotal" value="{{ $subTotal }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggalMasuk">Tanggal masuk</label>
                        <input type="Date" class="form-control" name="tanggal_masuk" id="tanggalMasuk"
                            value="{{ $data->tanggal_masuk }}" readonly>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-md-4">
                        <label for="approval" class="formlabel">Update status</label>
                        <select name="status" id="" class="form-select mt-3 @error('status')
                            is-invalid
                        @enderror" id="approval"">
                            <option value="" selected>Pending</option>
                            <option value="approved">Approve</option>
                            <option value="rejected">Reject</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-8">
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
