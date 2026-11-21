@extends('layout.home')

@section('content')
    <h1 class="mt-5">Barang masuk</h1>

    <div class="row mt-5">
        @can('input-barang-masuk')
            <div class="col-md-9">
                <a href="/input-barang-masuk" class="btn btn-primary">Tambah Data</a>
            </div>
        @endcan

        <div class="col-md-3">
            <input type="text" id="searchBarangMasuk" class="form-control-md w-70 form-control left cari-user"
                placeholder="Cari barang masuk">
        </div>
    </div>
    <table class="table mt-4">
        <thead>
            <tr>
                <td class="text-center" scope="col-md-2">Kode barang masuk</td>
                <td class="text-center" scope="col-md-2">Tanggal masuk</td>
                <td class="text-center" scope="col-md-4">Nama barang</td>
                <td class="text-center" scope="col-md-2">Jumlah</td>
                <td class="text-center" scope="col-md-2">Sisa</td>
                <td class="text-center" scope="col-md-2">Harga satuan</td>
                <td class="text-center" scope="col-md-2">Subtotal</td>
                <td class="text-center" scope="col-md-2">Aksi</td>
            </tr>
        </thead>
        <tbody id="tableBarangMasuk">
            @include('barang.table.table-barang-masuk')
        </tbody>
    </table>
@endsection

@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const searchInput = document.getElementById('searchBarangMasuk');
            const tableBody = document.getElementById('tableBarangMasuk');

            let timeout = null;

            searchInput.addEventListener('input', function() {

                clearTimeout(timeout);

                timeout = setTimeout(() => {

                    const keyword = searchInput.value;

                    fetch(
                            `{{ route('barangmasuk.search') }}?keyword=${encodeURIComponent(keyword)}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Terjadi kesalahan saat mencari data.');
                            }

                            return response.json();
                        })
                        .then(data => {
                            tableBody.innerHTML = data.html;
                        })
                        .catch(error => {
                            console.error("terjadi kesalahan : ",error);
                        });

                }, 300);

            });

        });
    </script>
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
                icon: 'error',
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
                title: 'Menunggu!',
                text: "{{ session('pending') }}",
                confirmButtonColor: '#3085d6'
            });
        </script>
    @endif
@endpush
