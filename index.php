<?php
    include 'koneksi.php';
    include 'layouts/admin_header.php';

    if(isset($_POST['admin_login'])){
        $email      = htmlentities($_POST['email_admin']);
        $password   = htmlentities($_POST['password_admin']);

        if($email == '' || $password == ''){
            $_SESSION['error'] = 'Semua kolom harus diisi';
            header('Location: index.php');
            return;
        }

        $stmt = $pdo->prepare('SELECT * FROM tb_admin WHERE email_admin = :email_admin');
        $stmt->execute([':email_admin'    => $email ]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if($email !== $admin['email_admin'] ){
            //when email & password doesnot match with database
            $_SESSION['error'] = 'Info is Wrong';
            header('Location: index.php');
            return;
        }elseif($email === $admin['email_admin'] ){
            if(password_verify($password, $admin['password_admin'])){
                $_SESSION['id_admin']         = $admin['id_admin'];
                $_SESSION['username_admin']   = $admin['username_admin'];
                $_SESSION['email_admin']      = $admin['email_admin'];
                
                    $_SESSION['admin_login'] = 'admin';
                    //when admin is in approved state
                    header('Location: dashboard.php');
                    return;

            }else{
                $_SESSION['error'] = 'Kata Sandi Salah';
                header('Location: index.php');
                return;
            }
        }
    }
?>

<div class="container-fluid">
    <div class="card mx-auto col-sm-6" style="border: none;">
        <div class="container mt-5">
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="p-5 font-italic text-center font-weight-bold" style="font-size: 3rem;">Masuk Admin</h2>
                </div>
            </div>
        </div>

        <?php
            include 'flash_msg.php';
        ?>

        <form action="" method="post" class="col-md-12 pt-5">
            <div class="form-group">
                <label for="email">Alamat E-mail</label>
                <input type="email" class="form-control" id="" name="email_admin">
            </div>
            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <input type="password" class="form-control" id="" name="password_admin">
            </div>
            <div class="form-group">
                <input type="submit" value="Masuk" name="admin_login" class="btn btn-primary">
            </div>
        </form>
    </div>
</div>

<?php
    include 'layouts/admin_footer.php';
?>