<?php
    if (isset($_GET['edit'])) {
        $id_user = $_GET['edit'];

        $stmt = $pdo->prepare('SELECT * FROM tb_user WHERE id_user = :id_user');
        $stmt->execute([':id_user' => $id_user]);

        if (isset($_POST['update_tourist'])) {
            $firstname = htmlentities($_POST['nama_user']);
            $username = htmlentities($_POST['username_user']);
            $email = htmlentities($_POST['email_user']);
            $password = htmlentities($_POST['pass_user']);

            // Empty Field Validation
            if ($username == '' || $firstname == '' || $email == '' || $password == '') {
                $_SESSION['error'] = 'Mohon Isi Semua Kolom';
                header('Location: tourists.php?page=edit_tourist&edit=' . $id_user);
                return;
            } else {
                $stmt = $pdo->prepare('UPDATE tb_user SET  nama_user = :nama_user, username_user = :username_user, pass_user = :pass_user, email_user = :email_user WHERE id_user = :id_user');

                $stmt->execute([
                    ':id_user' => $id_user,
                    ':nama_user' => $firstname,
                    ':username_user' => $username,
                    ':pass_user' => $password,
                    ':email_user' => $email
                ]);

                $_SESSION['success'] = 'Pengguna Telah Diupdate';
                header('Location: tourists.php');
                return;
            }
        }
    }
?>


<br><br>
<div class="container">
    <h2 class="p-2 pb-5">Perbarui Data Pengguna</h2>

    <?php
    include 'flash_msg.php';

    //Tourist Read Query for specific id
    if (isset($_GET['edit'])) {
        $id_user = $_GET['edit'];

        $stmt = $pdo->prepare('SELECT * FROM tb_user WHERE id_user = :id_user');
        $stmt->execute([':id_user' => $id_user]);
        $tourist = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($tourist === false) {
            // Handle case when no tourist found
            echo "Pengguna tidak ditemukan.";
            return;
        }
    }
    ?>

    <form action="" method="post" enctype="multipart/form-data" class="col-md-8">
        <div class="form-group p-2">
            <label for="nama_user">Nama Pengguna</label>
            <input type="text" class="form-control" value="<?php echo isset($tourist['nama_user']) ? $tourist['nama_user'] : ''; ?>" id="" name="nama_user">
        </div>
        <div class="form-group pb-2">
            <label for="username_user">Username</label>
            <input type="text" class="form-control" value="<?php echo isset($tourist['username_user']) ? $tourist['username_user'] : ''; ?>" id="" name="username_user">
        </div>
        <div class="form-group p-2">
            <label for="pass_user">Kata Sandi</label>
            <input type="password" class="form-control" value="<?php echo isset($tourist['pass_user']) ? $tourist['pass_user'] : ''; ?>" id="" name="pass_user">
        </div>
        <div class="form-group p-2">
            <label for="email_user">Alamat E-mail</label>
            <input type="email" class="form-control" value="<?php echo isset($tourist['email_user']) ? $tourist['email_user'] : ''; ?>" id="" name="email_user">
        </div>
        <div class="form-group p-2">
            <input type="submit" value="Perbarui Data Pengguna" name="update_tourist" class="btn btn-primary">

            <a href="tourists.php" type="button" class="btn btn-secondary float-right">Batal</a>
        </div>
    </form>
</div>
<?php
    if (isset($_GET['edit'])) {
        $id_user = $_GET['edit'];

        $stmt = $pdo->prepare('SELECT * FROM tb_user WHERE id_user = :id_user');
        $stmt->execute([':id_user' => $id_user]);

        if (isset($_POST['update_tourist'])) {
            $firstname = htmlentities($_POST['nama_user']);
            $username = htmlentities($_POST['username_user']);
            $email = htmlentities($_POST['email_user']);
            $password = htmlentities($_POST['pass_user']);

            // Empty Field Validation
            if ($username == '' || $firstname == '' || $email == '' || $password == '') {
                $_SESSION['error'] = 'Mohon Isi Semua Kolom';
                header('Location: tourists.php?page=edit_tourist&edit=' . $id_user);
                return;
            } else {
                $stmt = $pdo->prepare('UPDATE tb_user SET  nama_user = :nama_user, username_user = :username_user, pass_user = :pass_user, email_user = :email_user WHERE id_user = :id_user');

                $stmt->execute([
                    ':id_user' => $id_user,
                    ':nama_user' => $firstname,
                    ':username_user' => $username,
                    ':pass_user' => $password,
                    ':email_user' => $email
                ]);

                $_SESSION['success'] = 'Pengguna Telah Diupdate';
                header('Location: tourists.php');
                return;
            }
        }
    }
?>


