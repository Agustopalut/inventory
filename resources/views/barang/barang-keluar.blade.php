@extends('layout.home')

@section('content')
    <h1 class="mt-4">Barang Keluar</h1>

    <div class="row mt-2">
        @can('input-barang-keluar')
            <div class="col-md-9">
                <a href="/input/barang-keluar" class="btn btn-primary mt-2">Tambah barang</a>
            </div>
        @endcan

        <div class="col-md-3 mt-2">
            <input type="text" class="form-control-md w-70 form-control left cari-user" id="searchBarangKeluar" placeholder="Cari barang keluar">
        </div>
    </div>
    <table class="table mt-2">
        <thead>
            <tr>
                <th class="text-center" scope="col-md-2">Kode barang keluar</th>
                <td class="text-center" scope="col-md-4">Tanggal keluar </td>
                <td class="text-center" scope="col-md-2">Tujuan</td>
                <td class="text-center" scope="col-md-2">Diinput Oleh</td>
                <td class="text-center" scope="col-md-2">Aksi</td>
            </tr>
        </thead>
        <tbody id="tableBarangKeluar">
            @include('barang.table.table-barang-keluar')
        </tbody>
    </table>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const searchInput = document.getElementById('searchBarangKeluar');
            const tableBody = document.getElementById('tableBarangKeluar');

            let timeout = null;

            searchInput.addEventListener('input', function() {

                clearTimeout(timeout);

                timeout = setTimeout(() => {

                    const keyword = searchInput.value;

                    fetch(
                            `{{ route('barangkeluar.search') }}?keyword=${encodeURIComponent(keyword)}`
                        )
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
                            console.error("terjadi kesalahan : ", error.message);
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
