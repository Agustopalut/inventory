@extends('layout.home')

@section('content')
    <h1 class="mt-4">Stok opname</h1>

    <div class="row mt-3">
        @can('input-stok-opname')
            <div class="col-md-9">
                <a href="/input/stok-opname" class="btn btn-primary"> <i class='fa-solid fa-plus'></i> Tambah data</a>
            </div>
        @endcan
        <div class="col-md-3">
            <input type="text" class="form-control-md w-70 form-control left cari-user" id="searchStokOpname" placeholder="Cari stok opname">
        </div>
    </div>
    <table class="table mt-3">
        <thead>
            <tr class="text-center">
                <th scope="col-md-2">Kode Opname</th>
                <td scope="col-md-4">Tanggal</td>
                <td scope="col-md-4">Diinput Oleh</td>
                <td scope="col-md-4">Jumlah barang yang dicek</td>
                <td scope="col-md-2">Aksi</td>
            </tr>
        </thead>
        <tbody id="tableStokOpname">
            @include('barang.table.table-stok-opname')
        </tbody>
    </table>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const searchInput = document.getElementById('searchStokOpname');
            const tableBody = document.getElementById('tableStokOpname');

            let timeout = null;

            searchInput.addEventListener('input', function() {

                clearTimeout(timeout);

                timeout = setTimeout(() => {

                    const keyword = searchInput.value;

                    fetch(
                            `{{ route('stokopname.search') }}?keyword=${encodeURIComponent(keyword)}`
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

    @if (session('pending'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Menunggu',
                text: "{{ session('pending') }}",
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
@endpush
