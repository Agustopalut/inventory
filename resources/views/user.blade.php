@extends('layout.home')

@section('content')
    <h1 class="mt-4">User</h1>

    @can('input-user')
        <div class="row">
            <div class="col-md-9">
                <a href="/add-user" class="btn btn-primary">Tambah user</a>
            </div>
        </div>
    @endcan

    <table class="table">
        <thead>
            <tr class="text-center">
                <th scope="col-md-2">No</th>
                <th scope="col-md-4">Nama</th>
                <th scope="col-md-4">Role</th>
                @can('update-user')
                    <th scope="col-md-2">Action</th>
                @endcan

            </tr>
        </thead>
        <tbody>

            @foreach ($users as $user)
                <tr class="text-center">
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->getRoleNames()->first() }}</td>
                    @can('update-user')
                        <td>
                            <a href="/update/user/{{ $user->id }}" class="btn btn-primary">Update</a>

                            <form action="/delete/user/{{ $user->id }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete btn-danger">Delete</button>
                            </form>

                        </td>
                    @endcan

                </tr>
            @endforeach

        </tbody>
    </table>
@endsection
@push('scripts')
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
