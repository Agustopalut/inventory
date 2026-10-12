@extends('layout.home')

@section('content')
    <h1 class="mt-4">Change password</h1>

    <div class="card mt-4">
        <form action="/change-password" method="post">
            @csrf
            <div class="card-header text-end">
                <button class="btn btn-primary btn-sm" type="submit" name="submit">Update</button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 w-50">
                        <label for="namaUser" class="form-label">Nama user </label>
                        <input type="text" class="form-control form-satuan" value="{{ Auth::user()->name }}"
                            id="namaUser" disabled readonly>
                    </div>
                    <div class="col-md-6 w-50">
                        <label for="password" class="form-label">Password </label>
                        <input type="password"
                            class="form-control form-satuan @error('password')
                            is-invalid
                        @enderror "
                            name="password" id="password">
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-6">
                        <label for="role" class="form-label">Role </label>
                        <input type="text" class="form-control" value="{{ Auth::user()->getRoleNames()->first() }}"
                            id="role" readonly disabled>
                    </div>
                    <div class="col-md-6">
                        <label for="confirmPassword" class="form-label">Confirm password </label>
                        <input type="password"
                            class="form-control @error('password_confirmation')
                            is-invalid
                        @enderror "
                            name="password_confirmation" id="confirmPassword">
                    </div>
                </div>

            </div>
        </form>
    </div>
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
                icon: 'warning',
                title: 'Gagal',
                text: "{{ session('error') }}",
                confirmButtonColor: '#3085d6'
            });
        </script>
    @endif
@endpush
