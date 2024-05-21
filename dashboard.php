<?php
    include 'koneksi.php';
    include 'layouts/admin_header.php';
    include 'layouts/admin_navbar.php';

    if(empty($_SESSION['admin_login']) || $_SESSION['admin_login'] == '' ){
        header('Location: index.php');
        return;
    }
?>

<div id="layoutSidenav">
    <?php
        include 'layouts/admin_sidenav.php';
    ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <h1 class="mt-4">Selamat Datang</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
                <div class="row">

                <?php
                    $stmt = $pdo->prepare('SELECT count(*) FROM tb_user');
                    $stmt->execute();
                    $agency_count = $stmt->fetchColumn();
                ?>

                    <div class="col-xl-4 col-md-6">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body" style="font-size: 30px;">Pengguna</div>
                            <div class="col-xs-9 text-right pr-4">
                                <div style="font-size: 45px; line-height: normal;"><?php echo $agency_count; ?></div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="tourists.php">Selengkapnya</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>

                    <?php
                        $stmt = $pdo->prepare('SELECT count(*) FROM tb_admin');
                        $stmt->execute();
                        $tourist_count = $stmt->fetchColumn();
                    ?>

                    <div class="col-xl-4 col-md-6">
                        <div class="card bg-warning text-white mb-4">
                            <div class="card-body" style="font-size: 30px;">Admin</div>
                            <div class="col-xs-9 text-right pr-4">
                                <div style="font-size: 45px; line-height: normal;"><?php echo $tourist_count; ?></div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="admins.php">Selengkapnya</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>

                    <?php
                        $stmt = $pdo->prepare('SELECT count(*) FROM tb_paket');
                        $stmt->execute();
                        $package_count = $stmt->fetchColumn();
                    ?>

                    <div class="col-xl-4 col-md-6">
                        <div class="card bg-success text-white mb-4">
                            <div class="card-body" style="font-size: 30px;">Paket Wisata</div>
                            <div class="col-xs-9 text-right pr-4">
                                <div style="font-size: 45px; line-height: normal;"><?php echo $package_count; ?></div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="packages.php">Selengkapnya</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>

                    <?php
                        $stmt = $pdo->prepare('SELECT count(*) FROM tb_pesanan');
                        $stmt->execute();
                        $review_count = $stmt->fetchColumn();
                    ?>

                    <div class="col-xl-4 col-md-6">
                        <div class="card bg-info text-white mb-4">
                            <div class="card-body" style="font-size: 30px;">Pesanan</div>
                            <div class="col-xs-9 text-right pr-4">
                                <div style="font-size: 45px; line-height: normal;"><?php echo $review_count; ?></div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="bookings.php">Selengkapnya</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>


                    <?php
                        $stmt = $pdo->prepare('SELECT count(*) FROM tb_pembayaran');
                        $stmt->execute();
                        $payment_count = $stmt->fetchColumn();
                    ?>

                    <div class="col-xl-4 col-md-6">
                        <div class="card bg-danger text-white mb-4">
                            <div class="card-body" style="font-size: 30px;">Pembayaran</div>
                            <div class="col-xs-9 text-right pr-4">
                                <div style="font-size: 45px; line-height: normal;"><?php echo $payment_count; ?></div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="payments.php">Selengkapnya</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php
    include 'layouts/admin_footer.php';
?>
