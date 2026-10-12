@extends('layout.home')

@section('content')
    <h1 class="mt-5">Cetak Pdf Stok opname</h1>
    <form action="{{ route('filter.stok-opname') }}" method="GET">
        @csrf
        <div class="row border">
            <div class="col-md-2">
                <span class="ms-1">Jenis Laporan</span>
                <select name="laporan" id="jenisLaporan" class="form-select mt-2 mb-2">
                    <option value="">Jenis laporan</option>
                    <option value="harian">Harian</option>
                    <option value="bulan">Bulan</option>
                </select>
            </div>
            <div class="col-md-2 tanggal-awal" id="tanggalAwal" style="display: none">
                <span class="ms-1">Tanggal awal</span>
                <input type="date" class="form-control mt-2 mb-2" name="tanggal_awal">
            </div>
            <div class="col-md-2 tanggal-akhir" id="tanggalAkhir" style="display: none">
                <span class="ms-1">Tanggal akhir</span>
                <input type="date" class="form-control mt-2 mb-2" name="tanggal_akhir">
            </div>
            <div class="col-md-2 container-bulan ms-3" id="containerBulan" style="display: none;">
                <span class="ms-1">Pilih Bulan : </span>
                <select name="bulan" class="form-select mt-2">
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
            </div>
            <div class="col-md-2 container-bulan ms-3" id="containerTahun" style="display: none;">
                <span class="ms-1">Pilih Bulan : </span>
                <select name="tahun" class="form-select mt-2">
                    <option value="">Pilih Tahun</option>
                    @for ($tahun = 2025; $tahun <= date('Y'); $tahun++)
                        <option value="{{ $tahun }}">{{ $tahun }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary mt-4 ms-5">Preview</button>
            </div>
            <div class="col-md-2">
                <button type="reset" class="btn btn-primary mt-4">Reset</button>
            </div>
        </div>
    </form>

    <div class="row mt-5">
        @if ($jenisLaporan)
            <div class="col-md-12 text-end">
                <form action="{{ route('print.stok-opname') }}" method="GET">
                    @csrf
                    <input type="hidden" name="laporan" value="{{ $jenisLaporan }}">
                    <input type="hidden" name="filterFirst" value="{{ $filterFirst }}">
                    <input type="hidden" name="filterSecond" value="{{ $filterSecond }}">
                    <button type="submit" class="btn btn-primary">Cetak</button>
                </form>
            </div>
        @endif        
    </div>
    <table class="table mt-4 ms-1">
        <thead class="text-center">
            <tr>
                <td class="text-center" scope="col-md-2">Kd opname</td>
                <td class="text-center" scope="col-md-2">Tanggal opname</td>
                <td class="text-center" scope="col-md-4">keterangan</td>
                <td class="text-center" scope="col-md-2">User</td>
            </tr>
        </thead>
        <tbody>

            @if ($data->isEmpty())
                <tr class="text-center">
                    <td colspan="8" class="text-center">Data masih kosong</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @else
                @foreach ($data as $item)
                    <tr>
                        <th class="text-center" scope="row">{{ $item->kd_opname }}</th>
                        <td class="text-center" scope="row">
                            {{ \Carbon\Carbon::parse($item->tangga_opname)->translatedFormat('d F Y') }}</td>
                        <td class="text-center">{{ $item->keterangan }}</td>
                        <td class="text-center">{{ $item->user->name }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
@push('scripts')
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
