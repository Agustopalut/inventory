<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion bg-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav ">
                @can('melihat-barang-masuk')
                    <div class="sb-sidenav-menu-heading">Home</div>
                    <a class="nav-link" href="/">
                        <div class="sb-nav-link-icon text-light"><i class="fas fa-tachometer-alt"></i></div>
                        <span class="text-light">Dashboard</span>
                    </a>
                @endcan

                <hr class="mb-0">
                @can('melihat-user')
                    <a class="nav-link" href="/users">
                        <div class="sb-nav-link-icon text-light"><i class="fa-solid fa-user"></i></div>
                        <span class="text-light">User</span>
                    </a>
                @endcan

                @can('melihat-barang-master')
                    <a class="nav-link" href="">
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon text-light"><i class="fa-solid fa-box"></i> <span
                                    class="text-light">Barang</span></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="/barang-master"> <span class="text-light">Barang master</span>
                                </a>
                                <a class="nav-link" href="/barang-masuk"> <span class="text-light">Barang masuk</span> </a>
                                <a class="nav-link" href="/barang-keluar"> <span class="text-light">Barang keluar</span>
                                </a>
                                <a class="nav-link" href="/stok-opname"> <span class="text-light">Stok opname</span> </a>
                                <a class="nav-link" href="/approval-request"> <span class="text-light">Approval
                                        request</span> </a>
                            </nav>
                        </div>
                    </a>
                @endcan

                @can('cetak-pdf')
                    <a class="nav-link" href="">
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts2" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon text-light"><i class="fa-solid fa-print"></i> <span
                                    class="text-light">Cetak pdf</span> </div>
                        </a>
                        <div class="collapse" id="collapseLayouts2" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="/cetak/barang-master"> <span class="text-light">Cetak barang
                                        master</span></a>
                                <a class="nav-link" href="/cetak/barang-masuk"> <span class="text-light">Cetak barang
                                        masuk</span></a>
                                <a class="nav-link" href="/cetak/barang-keluar"> <span class="text-light">Cetak barang
                                        keluar</span></a>
                                <a class="nav-link" href="/cetak/stok-opname"> <span class="text-light">Cetak stok
                                        opname</span></a>
                            </nav>
                        </div>
                    </a>
                @endcan
                <a class="nav-link" href="">
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseLayouts3" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon text-light"> <span class="text-light">Produksi</span></div>
                    </a>
                    <div class="collapse" id="collapseLayouts3" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-light" href="/production-request">Production Request</a>
                        </nav>
                    </div>
                </a>

                <hr class="mb-0">
                <form action="/logout" method="post">
                    @csrf
                    <button type="submit" class="btn btn-danger ms-3 mt-3">Logout</button>
                </form>
            </div>
        </div>
        <div class="sb-sidenav-footer border text-primary">
            <div class="small">Logged in as:</div>
            {{ Auth::user()->getRoleNames()->first() }}
        </div>
    </nav>
</div>
