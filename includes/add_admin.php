<?php
include 'koneksi.php';
include 'layouts/admin_header.php';

if(isset($_POST['create_admin'])){
    $name            = htmlentities($_POST['nama_admin']);
    $username        = htmlentities($_POST['username_admin']);
    $admin_email     = htmlentities($_POST['email_admin']);
    $telp            = htmlentities($_POST['telepon_admin']);
    $admin_password  = htmlentities($_POST['password_admin']);
    $hashedPassword  = password_hash($admin_password, PASSWORD_DEFAULT);

    if($name == '' || $username == '' || $admin_email == '' || $telp == '' || $admin_password == ''){
        $_SESSION['error'] = 'Isi Semua Kolom';
        header('Location: admins.php?page=add_admin');
        return;
    }

    $stmt = $pdo->prepare('SELECT * FROM tb_admin WHERE username_admin = :username_admin');
    $stmt->execute([':username_admin' => $username]);
    $username_validate = [];
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $username_validate[] = $row;
    }
    if(!empty($username_validate)){
        $_SESSION['error'] = 'Username telah digunakan.';
        header('Location: admins.php?page=add_admin');
        return;
    }

    $stmt = $pdo->prepare('SELECT * FROM tb_admin WHERE email_admin = :email_admin');
    $stmt->execute([':email_admin' => $admin_email]);
    $email_validate = [];
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $email_validate[] = $row;
    }
    if(!empty($email_validate)){
        $_SESSION['error'] = 'Alamat E-mail telah digunakan';
        header('Location: admins.php?page=add_admin');
        return;
    }

    else{
        $stmt = $pdo->prepare('INSERT INTO tb_admin(nama_admin, username_admin, password_admin, email_admin, telepon_admin) VALUES(:nama_admin, :username_admin, :password_admin, :email_admin, :telepon_admin)');

        $stmt->execute([
            ':nama_admin'        => $name,
            ':username_admin'    => $username,
            ':password_admin'    => $hashedPassword,
            ':email_admin'       => $admin_email,
            ':telepon_admin'     => $telp
        ]);
        $_SESSION['success'] = 'Admin Baru Ditambahkan';
        header('Location: admins.php');
        return;
    }
}
?>

<br><br>
<div class="container">
    <h2 class="p-2 pb-4">Tambah Admin</h2>

    <?php
    include 'flash_msg.php';
    ?>

    <form action="" method="post" enctype="multipart/form-data" class="col-md-8">
        <div class="form-group p-2">
            <label for="nama_admin">Nama Admin</label>
            <input type="text" class="form-control" id="" name="nama_admin">
        </div>
        <div class="form-group p-2">
            <label for="username_admin">Username</label>
            <input type="text" class="form-control" id="" name="username_admin">
        </div>
        <div class="form-group p-2">
            <label for="password_admin">Kata Sandi</label>
            <input type="password" class="form-control" id="" name="password_admin">
        </div>
        <div class="form-group p-2">
            <label for="email_admin">Email address</label>
            <input type="email" class="form-control" id="" name="email_admin">
        </div>
        <div class="form-group p-2">
            <label for="telepon_admin">Nomor Telepon</label>
            <input type="number" class="form-control" id="" name="telepon_admin">
        </div>
        <div class="form-group p-2">
            <input type="submit" value="Buat" name="create_admin" class="btn btn-primary">
            <a href="admins.php" type="button" class="btn btn-secondary float-right">Batal</a>
        </div>
    </form>
</div>

<?php
include 'layouts/admin_footer.php';
?>
