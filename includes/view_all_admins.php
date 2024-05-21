<?php
    // Admin Read Query
    $stmt = $pdo->query('SELECT * FROM tb_admin');
    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Admin Delete Query
    if(isset($_GET['delete'])){
        $admin_id = $_GET['delete'];

        $stmt = $pdo->prepare('DELETE FROM tb_admin WHERE id_admin = :id_admin');
        $stmt->execute([':id_admin' => $admin_id]);

        $_SESSION['success'] = 'Admin Berhasil Dihapus';
        header('Location: admins.php');
        return;
    }
?>

<div class="col-xs-12">
    
    <?php
        include 'flash_msg.php';

        if(empty($admins)){
            echo '<h1 class="text-center pt-4">Admin Tidak Ditemukan/h1>';
        }else{
    ?>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Admin</th>
                <th>Nama Admin</th>
                <th>Username</th>
                <th>E-mail</th>
                <th>Nomor Telepon</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($admins as $admin): 
                ?>
                <tr>
                    <td><?php echo $no++ ; ?></td>
                    <td><?php echo $admin['id_admin']; ?></td>
                    <td><?php echo $admin['nama_admin']; ?></td>
                    <td><?php echo $admin['username_admin']; ?></td>
                    <td><?php echo $admin['email_admin']; ?></td>
                    <td><?php echo $admin['telepon_admin']; ?></td>
                    <td>
                        <a href="admins.php?page=edit_admin&edit=<?php echo $admin['id_admin']; ?>" class="btn btn-outline-warning mt-1 mr-1"><i class="fas fa-edit"></i></a>
                        <a href="admins.php?delete=<?php echo $admin['id_admin']; ?>" class="btn btn-outline-danger mt-1"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
        }
    ?>
</div>
