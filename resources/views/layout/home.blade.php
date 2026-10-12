<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title> {{ $title }} </title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous"> --}}

    <!-- agar absolute -->
    <link href="{{ asset('sb-admin') }}/css/styles.css" rel="stylesheet" />
    <link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.26.25/dist/sweetalert2.min.css
" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('sb-admin') }}/image/toga.png" type="image/x-icon">
    {{-- <link rel="stylesheet" href="{{ asset('css/custom.css') }}"> --}}

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="">Ettore Gelato inventory</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <span class="text-white text-capitalize"></span>
        </form>
        <!-- Navbar-->

        <!-- start dropdown menu ketika tombol user klick -->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="{{ route('change-password') }}">Change password</a></li>
                    </li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <form action="/logout" method="post">
                            @csrf
                            <button type="submit" name="submit" class="btn btn-danger">Logout</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>

        <!-- end dropdown menu ketika tombol user klick -->
    </nav>

    {{-- side bar --}}
    <div id="layoutSidenav">

        @include('layout/partials/sidebar')

        {{-- content --}}
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    @yield('content')
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto border">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright Ettore Gelato </div>

                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script> --}}
    <script src="{{ asset('sb-admin') }}/js/scripts.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script> --}}
    {{-- <script src="{{ asset('sb-admin') }}/assets/demo/chart-area-demo.js"></script>
    <script src="{{ asset('sb-admin') }}/assets/demo/chart-bar-demo.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script> --}}
    {{-- <script src="{{ asset('sb-admin') }}/js/datatables-simple-demo.js"></script> --}}
    @stack('scripts')
</body>

</html>
