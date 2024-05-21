<?php
//Tourist Insert Query...Added by Admin
if(isset($_POST['create_tourist'])){
    $firstname  = htmlentities($_POST['nama_user']);
    $username   = htmlentities($_POST['username_user']);
    $email      = htmlentities($_POST['email_user']);
    $password   = htmlentities($_POST['pass_user']);

    //Empty Field Validation
    if($username == '' || $firstname == '' || $email == '' || $password == ''){
        $_SESSION['error'] = 'Isi Semua Form';
        header('Location: tourists.php?page=add_tourist');
        return;
    }

    //Username Validation
    $stmt = $pdo->prepare('SELECT * FROM tb_user WHERE username_user = :username_user');
    $stmt->execute([':username_user' => $username]);
    $tourist_usernames = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(!empty($tourist_usernames)){
        $_SESSION['error'] = 'Username telah ada. Mohon gunakan username yang lain.';
        header('Location: tourists.php?page=add_tourist');
        return;
    }

    //Email Validation
    $stmt = $pdo->prepare('SELECT * FROM tb_user WHERE email_user = :email_user');
    $stmt->execute([':email_user' => $email]);
    $tourist_emails = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(!empty($tourist_emails)){
        $_SESSION['error'] = 'Alamat E-mail telah digunakan. Gunakan alamat e-mail yang lain.';
        header('Location: tourists.php?page=add_tourist');
        return;
    }
    else{
        $stmt = $pdo->prepare('INSERT INTO tb_user(nama_user, username_user, pass_user, email_user) VALUES(:nama_user, :username_user, :pass_user, :email_user)');

        $stmt->execute([
            ':nama_user' => $firstname,
            ':username_user' => $username,
            ':pass_user' => $password,
            ':email_user' => $email
        ]);

        $_SESSION['success'] = 'Pengguna Baru Ditambahkan';
        header('Location: tourists.php');
        return;
    }
}
?>

<br><br>
<div class="container">
    <h2 class="p-2 pb-5">Tambah Pengguna</h2>

    <?php
    include 'flash_msg.php';
    ?>

    <form action="" method="post" class="col-md-8">
        <div class="form-group p-2">
            <label for="nama_user">Nama Pengguna</label>
            <input type="text" class="form-control" id="" name="nama_user">
        </div>
        <div class="form-group p-2">
            <label for="username_user">Username</label>
            <input type="text" class="form-control" id="" name="username_user">
        </div>
        <div class="form-group p-2">
            <label for="pass_user">Kata Sandi</label>
            <input type="password" class="form-control" id="" name="pass_user">
        </div>
        <div class="form-group p-2">
            <label for="email_user">Alamat E-mail</label>
            <input type="email" class="form-control" id="" name="email_user">
        </div>
        <div class="form-group p-2">
            <input type="submit" value="Tambah Pengguna" name="create_tourist" class="btn btn-primary">

            <a href="tourists.php" type="button" class="btn btn-secondary float-right">Batal</a>
        </div>
    </form>
</div>
