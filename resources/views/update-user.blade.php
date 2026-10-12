@extends('layout.home')

@section('content')
    <h1 class="mt-4">Update Userr</h1>

    <div class="card mt-4">
        <form action="/update/user/{{ $user->id }}" method="post">
            @csrf
            @method('PATCH')
            <div class="card-header text-end">
                <button class="btn btn-primary btn-sm" type="submit" name="submit">Simpan</button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nama user</label>
                            <input type="text"
                                class="form-control @error('name')
                            is-invalid
                        @enderror"
                                name="name" id="exampleInputEmail1" value="{{ $user->name }}"
                                aria-describedby="emailHelp" autocomplete="off">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Role</label>
                            <select name="role" class="form-select" id="">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}</option>
                                @endforeach
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
