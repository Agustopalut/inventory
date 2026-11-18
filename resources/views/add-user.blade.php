@extends('layout.home')

@section('content')
    <h1 class="mt-4">Menambah Pengguna</h1>

    <div class="card mt-4">
        <form action="/add-user" method="post">
            @csrf
            <div class="card-header text-end">
                <button class="btn btn-primary btn-sm" type="submit" name="submit">Simpan</button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nama Pengguna</label>
                            <input type="text"
                                class="form-control @error('name')
                            is-invalid
                        @enderror"
                                name="name" id="exampleInputEmail1" aria-describedby="emailHelp" autocomplete="off">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Peran</label>
                            <select name="role" class="form-select @error('role') is-invalid
                            @enderror" id="">
                                <option value="">Pilih Peran</option>
                                <option value="manager">Manager</option>
                                <option value="guest">Guest</option>
                                <option value="production">Produksi</option>
                                <option value="admin">Admin</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                </div>

            </div>
        </form>
    </div>
@endsection
