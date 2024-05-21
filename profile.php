<?php
    include 'koneksi.php';
    include 'layouts/admin_header.php';
    include 'layouts/admin_navbar.php';

    if(empty($_SESSION['admin_login']) || $_SESSION['admin_login'] == ''){
        header('Location: index.php');
        return;
    }

    if(isset($_SESSION['id_admin'])){
        $admin_id = $_SESSION['id_admin'];

        $stmt = $pdo->prepare('SELECT * FROM tb_admin WHERE id_admin = :id_admin');
        $stmt->execute([':id_admin' => $admin_id]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        $username       = $admin['username_admin'];
        $admin_email    = $admin['email_admin'];

        if(isset($_POST['update_profile'])){
            $admin_firstname    = htmlentities($_POST['nama_admin']);
            $admin_password     = htmlentities($_POST['password_admin']);

            if($admin_firstname == '' || $admin_password == ''){
                $_SESSION['error'] = 'All Fields Are Required';
                header('Location: profile.php');
                return;
            }else{
                $hash_password = password_hash($admin_password, PASSWORD_BCRYPT, ['cost' => 12]);
                $stmt = $pdo->prepare('UPDATE tb_admin SET id_admin = :id_admin, nama_admin = :nama_admin, username_admin = :username_admin, password_admin = :password_admin, email_admin = :email_admin WHERE id_admin = :id_admin');

                $stmt->execute([':id_admin'         => $admin_id,
                                ':nama_admin'       => $admin_firstname,
                                ':username_admin'   => $username,
                                ':password_admin'   => $hash_password,
                                ':email_admin'      => $admin_email]);
                $_SESSION['success'] = 'Profil Telah Diupdate';
                header('Location: dashboard.php');
                return;
            }

        }
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
                    <li class="breadcrumb-item active">Profil</li>
                </ol>
                <?php
                    include 'flash_msg.php';
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <form action="" method="post" enctype="multipart/form-data" class="col-md-8">
                            <!-- <div class="form-group p-2">
                                <label for="username">username</label>
                                <input type="text" class="form-control" value="<?php echo $admin['username']; ?>" id="" name="username">
                            </div> -->
                            <div class="form-group p-2">
                                <label for="nama_admin">Nama</label>
                                <input type="text" class="form-control" value="<?php echo $admin['nama_admin']; ?>" id="" name="nama_admin">
                            </div>
                            <div class="form-group p-2">
                                <label for="username_admin">Last Name</label>
                                <input type="text" class="form-control" value="<?php echo $admin['username_admin']; ?>" id="" name="username_admin">
                            </div>
                            <div class="form-group p-2">
                                <label for="password_admin">Password</label>
                                <input type="password" class="form-control" value="<?php echo $admin['password_admin']; ?>" id="" name="password_admin">
                            </div>
                            <div class="form-group p-2">
                                <input type="submit" value="Perbarui Data" name="update_profile" class="btn btn-primary">

                                <a href="dashboard.php" type="button" class="btn btn-secondary float-right">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php
    include 'layouts/admin_footer.php';
?>
