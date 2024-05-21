<?php
    include 'koneksi.php';
    include 'layouts/admin_header.php';
    include 'layouts/admin_navbar.php';

    if(empty($_SESSION['admin_login']) || $_SESSION['admin_login'] == ''){
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
                    <li class="breadcrumb-item active">Informasi Paket Wisata</li>
                </ol>
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                            if(isset($_GET['page'])){
                                $page = $_GET['page'];
                            }else{
                                $page = '';
                            }
                            switch($page){
                                case 'add_paket':
                                    include 'includes/add_paket.php';
                                break;
                                case 'edit_paket':
                                    include 'includes/edit_paket.php';
                                break;
                                default:
                                    include 'includes/view_all_paket.php';
                            break;
                            }
                        ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php
    include 'layouts/admin_footer.php';
?>
