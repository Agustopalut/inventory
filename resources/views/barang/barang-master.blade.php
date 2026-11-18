@extends('layout.home')

@section('content')
    <h1 class="mt-4">Barang Utama</h1>

    <div class="row">
        @can('input-barang-master')
            <div class="col-md-9 mt-4">
                <a href="/input-barang-master" class="btn btn-primary">Tambah barang</a>
            </div>
        @endcan

        <div class="col-md-3 mt-2">

            <input type="text" class="form-control-md w-70 form-control left cari-user" id="searchBarangMaster"
                name="nama_barang"" placeholder="Cari barang">
        </div>
    </div>
    <table class="table mt-5 w-100">
        <thead>
            <tr>
                <th class="text-center" scope="col">No</th>
                <th class="text-center" scope="col">Nama</th>
                <th class="text-center" scope="col">Satuan</th>
                <th class="text-center" scope="col">Stok</th>
                <th class="text-center" scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody id="tableBarangMaster">
            @include('barang.table.table-barang-master')
        </tbody>
    </table>
@endsection

@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const searchInput = document.getElementById('searchBarangMaster');
            const tableBody = document.getElementById('tableBarangMaster');

            let timeout = null;

            searchInput.addEventListener('input', function() {

                clearTimeout(timeout);

                timeout = setTimeout(() => {

                    const keyword = searchInput.value;

                    fetch(
                            `{{ route('barangmaster.search') }}?keyword=${encodeURIComponent(keyword)}`
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
                            console.error("terjadi kesalahan : ", error);
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
@endpush
