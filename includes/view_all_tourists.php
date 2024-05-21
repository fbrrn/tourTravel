<?php
    // Paket Read Query
    $stmt = $pdo->query('SELECT * FROM tb_user');
    $tourists = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Psket Delete Query
    if(isset($_GET['delete'])){
        $id_user = $_GET['delete'];

        $stmt = $pdo->prepare('DELETE FROM tb_user WHERE id_user = :id_user');
        $stmt->execute([':id_user' => $id_user]);

        $_SESSION['success'] = 'Pengguna Berhasil Dihapus';
        header('Location: tourists.php');
        return;
    }
?>

<div class="col-xs-12">

    <?php
        include 'flash_msg.php';

        if(empty($tourists)){
            echo '<h1 class="text-center pt-4">Pengguna Tidak Ditemukan</h1>';
        }else{
    ?>

<table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Pengguna</th>
                <th>Nama Pengguna</th>
                <th>Username</th>
                <th>E-mail</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($tourists as $user): ?>
                <tr>
                    <td><?php echo $no++ ; ?></td>
                    <td><?php echo $user['id_user']; ?></td>
                    <td><?php echo $user['nama_user']; ?></td>
                    <td><?php echo $user['username_user']; ?></td>
                    <td><?php echo $user['email_user']; ?></td>
                    <td>
                        <a href="tourists.php?page=edit_tourist&edit=<?php echo $user['id_user']; ?>" class="btn btn-outline-warning mt-1 mr-1"><i class="fas fa-edit"></i></a>
                        <a href="tourists.php?delete=<?php echo $user['id_user']; ?>" class="btn btn-outline-danger mt-1"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
    }
    ?>
</div>