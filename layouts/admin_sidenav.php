<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav pt-5 mt-5">
                <a class="nav-link" href="dashboard.php">Dashboard</a>

                <a class="nav-link collapsed py-3" href="#" data-toggle="collapse" data-target="#collapseSubs" aria-expanded="false" aria-controls="collapsePages">
                    Pengguna
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseSubs" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="tourists.php">Lihat Semua Pengguna</a>
                        <a class="nav-link" href="tourists.php?page=add_tourist">Tambah Pengguna</a>
                    </nav>
                </div>

                <a class="nav-link collapsed py-3" href="#" data-toggle="collapse" data-target="#collapseAdmins" aria-expanded="false" aria-controls="collapsePages">
                    Admin
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseAdmins" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="admins.php">Lihat Semua Admin</a>
                        <a class="nav-link" href="admins.php?page=add_admin">Tambah Admin</a>
                    </nav>
                </div>

                <a class="nav-link collapsed py-3" href="#" data-toggle="collapse" data-target="#collapseAgencies" aria-expanded="false" aria-controls="collapsePages">
                    Paket
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseAgencies" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="packages.php">Lihat Semua Paket</a>
                        <a class="nav-link" href="packages.php?page=add_paket">Tambah Paket</a>
                    </nav>
                </div>

                <a class="nav-link collapsed py-3" href="#" data-toggle="collapse" data-target="#collapseBooking" aria-expanded="false" aria-controls="collapsePages">
                    Pesanan
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseBooking" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="bookings.php">Lihat Semua Pesanan</a>
                        <a class="nav-link" href="bookings.php?page=add_book">Tambah Pesanan</a>
                    </nav>
                </div>

                <a class="nav-link collapsed py-3" href="#" data-toggle="collapse" data-target="#collapseBayar" aria-expanded="false" aria-controls="collapsePages">
                    Pembayaran
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseBayar" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="payments.php">Lihat Semua Pembayaran</a>
                        <a class="nav-link" href="payments.php?page=add_bayar">Tambah Pembayaran</a>
                    </nav>
                </div>
            </div>
        </div>
    </nav>
</div>