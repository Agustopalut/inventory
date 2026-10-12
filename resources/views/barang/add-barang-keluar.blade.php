@extends('layout.home')

@section('content')
    <form action="/input/barang-keluar" method="post">
        @csrf
        @method('POST')
        <div class="row">
            <div class="col-md-6">
                <h1 class="mt-4">Input Barang keluar</h1>
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
                        <label for="jumlah" class="form-label">Jumlah yang dikeluarkan </label>
                        <input type="number" class="form-control" step="0.01" min="0.01" name="jumlah[]" id="jumlah">
                    </div>
                    <div class="col-md-6">
                        <label for="keterangan" class="form-label">Keterangan </label>
                        <input type="text" class="form-control" name="keterangan" id="keterangan">
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-6">
                        <label for="tujuan" class="form-label">Tujuan </label>
                        <input type="text" class="form-control" name="tujuan" id="tujuan">
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal_keluar" class="form-label">Tanggal keluar </label>
                        <input type="date" class="form-control" name="tanggal_keluar" id="tanggal_keluar">
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
@endpush