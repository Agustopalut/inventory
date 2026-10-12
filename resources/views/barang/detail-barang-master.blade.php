@extends('layout.home')

@section('content')
    <h1 class="mt-4">Input Barang master</h1>

    <div class="card mt-4">
        <form action="/barang-master" method="post">
            @csrf
            <div class="card-header text-end">
                <button class="btn btn-primary btn-sm" type="submit" name="submit">Simpan</button>
            </div>
            <div class="card-body">
                
            </div>
        </form>
    </div>
@endsection
