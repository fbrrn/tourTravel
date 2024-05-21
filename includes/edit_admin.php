<?php
// Admin Update Query
if(isset($_GET['edit'])){
    $admin_id = $_GET['edit'];

    if(isset($_POST['update_admin'])){
        $admin_firstname = htmlentities($_POST['nama_admin']);
        $username = htmlentities($_POST['username_admin']);
        $admin_email = htmlentities($_POST['email_admin']);
        $admin_telp = htmlentities($_POST['telepon_admin']);
        $admin_password = $_POST['password_admin'];

        // Empty Field Validation
        if($username == '' || $admin_firstname == '' || $admin_email == ''){
            $_SESSION['error'] = 'Isi semua kolom';
            header('Location: admins.php?page=edit_admin&edit='. $admin_id);
            return;
        } else {
            // Check if the password field is not empty
            if(empty($admin_password)){
                $stmt = $pdo->prepare('UPDATE tb_admin SET nama_admin = :nama_admin, username_admin = :username_admin, email_admin = :email_admin, telepon_admin = :telepon_admin WHERE id_admin = :id_admin');

                $stmt->execute([
                    ':nama_admin' => $admin_firstname,
                    ':username_admin'  => $username,
                    ':email_admin'     => $admin_email,
                    ':telepon_admin'   => $admin_telp,
                    ':id_admin' => $admin_id
                ]);
            } else {
                $hashedPassword = password_hash($admin_password, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare('UPDATE tb_admin SET nama_admin = :nama_admin, username_admin = :username_admin, email_admin = :email_admin, telepon_admin = :telepon_admin, password_admin = :password_admin WHERE id_admin = :id_admin');

                $stmt->execute([
                    ':nama_admin' => $admin_firstname,
                    ':username_admin'  => $username,
                    ':email_admin'     => $admin_email,
                    ':telepon_admin'   => $admin_telp,
                    ':password_admin'  => $hashedPassword,
                    ':id_admin' => $admin_id
                ]);
            }
            
            $_SESSION['success'] = 'Admin Telah Diupdate';
            header('Location: admins.php');
            return;
        }
    } else {
        $stmt = $pdo->prepare('SELECT * FROM tb_admin WHERE id_admin = :id_admin');
        $stmt->execute([':id_admin' => $admin_id]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

<div class="container">
    <h2 class="p-2 pb-5">Perbarui Data Admin</h2>

    <?php
        include 'flash_msg.php';

        if(isset($_GET['edit'])){
    ?>

    <form action="" method="post" class="col-md-8">
        <div class="form-group p-2">
            <label for="nama_admin">Nama Admin</label>
            <input type="text" class="form-control" value="<?php echo $admin['nama_admin']; ?>" id="" name="nama_admin">
        </div>
        <div class="form-group pb-2">
            <label for="username_admin">Username</label>
            <input type="text" class="form-control" value="<?php echo $admin['username_admin']; ?>" id="" name="username_admin">
        </div>
        <div class="form-group p-2">
            <label for="email_admin">Alamat E-mail</label>
            <input type="email" class="form-control" value="<?php echo $admin['email_admin']; ?>" id="" name="email_admin">
        </div>
        <div class="form-group p-2">
            <label for="password_admin">Kata Sandi</label>
            <input type="password" class="form-control" placeholder="Biarkan kosong jika tidak ingin mengubah kata sandi" id="" name="password_admin">
        </div>
        <div class="form-group p-2">
            <label for="telepon_admin">Nomor Telepon</label>
            <input type="number" class="form-control" value="<?php echo $admin['telepon_admin']; ?>" id="" name="telepon_admin">
        </div>
        <div class="form-group p-2">
            <input type="submit" value="Perbarui Data Admin" name="update_admin" class="btn btn-primary">

            <a href="admins.php" type="button" class="btn btn-secondary float-right">Batal</a>
        </div>
    </form>

    <?php
        }
    ?>
</div>
