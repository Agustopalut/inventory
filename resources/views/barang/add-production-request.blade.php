@extends('layout.home')

@section('content')
    <form action="/input/production-request" method="post">
        @csrf
        @method('POST')
        <div class="row">
            <div class="col-md-6">
                <h1 class="mt-4">Input production request</h1>
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary float-end mt-4" name="submit">Simpan</button>
            </div>
        </div>


        <div class="card mt-4">

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 w-50">
                        <label for="id_barang" class="form-label">Pilih barang : </label>
                        <select class="form-select" name="id_barang[]" id="id_barang">
                            <option value="" selected>Pilih Barang : </option>
                            @foreach ($barang as $item)
                                <option value="{{ $item->id_barang }}">{{ $item->nama_barang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 w-50">
                        <label for="satuanBarang" class="form-label">Satuan </label>
                        <input type="text" class="form-control form-satuan" id="satuanBarang" name="satuan" disabled
                            readonly>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-6">
                        <label for="jumlah" class="form-label">Jumlah yang diminta </label>
                        <input type="text" class="form-control" name="jumlah[]" id="jumlah">
                    </div>
                    <div class="col-md-6">
                        <label for="keterangan" class="form-label">Keterangan </label>
                        <input type="text" class="form-control" name="keterangan" id="keterangan">
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-6">
                        {{-- <label for="tanggal_keluar" class="form-label">Tanggal Request </label>
                        <input type="date" class="form-control" name="tanggal_request" id="tanggal_keluar"> --}}
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal_request" class="form-label">Tanggal Request </label>
                        <input type="datetime-local" name="tanggal_request" class="form-control" id="tanggal_request">
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-primary w-25 mt-4" id="btnTambahBarang"> Tambah barang</button>
        <table class="table mt-2">
            <thead>
                <tr>
                    <th scope="col">Nama barang</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Satuan</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="detailBarang">

            </tbody>
        </table>

    </form>

    <script>
        const dataBarang = @json($barang);
    </script>
@endsection

@push('scripts')
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: "{{ session('error') }}",
                confirmButtonColor: '#3085d6'
            });
        </script>
    @endif
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