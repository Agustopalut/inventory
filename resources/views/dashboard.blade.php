@extends('layout.home')

@section('content')
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Home</li>
    </ol>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Jumlah barang</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">{{ $barangMaster->count() }} barang</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">Jumlah barang masuk {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('F') }}
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">{{ $barangMasuk->count() }} barang</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">Jumlahbarang keluar {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('F') }}
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">{{ $barangKeluar->count() }} barang</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">Total price inventory</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">0 barang</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 ">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Data history
                </div>
                <div class="card-body w-100">
                    <table class="table w-100" style="table-layout: auto;">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col-2">No</th>
                                <th class="text-center" scope="col-2">Tanggal</th>
                                <th class="text-center" scope="col-8">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</td>
                                    <td class="text-center">{{ $item->created_at->format('d-m-Y') }}</td>
                                    <td class="text-center">{{ $item->keterangan }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3 small-pagination">
                        {{ $data->links() }}
                    </div>
                </div>
                {{-- <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div> --}}
            </div>
        </div>
    </div>
@endsection

