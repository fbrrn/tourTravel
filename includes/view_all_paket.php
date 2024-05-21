<?php
    // Paket Read Query
    $stmt = $pdo->query('SELECT * FROM tb_paket');
    $paket = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Psket Delete Query
    if(isset($_GET['delete'])){
        $id_paket = $_GET['delete'];

        $stmt = $pdo->prepare('DELETE FROM tb_paket WHERE id_paket = :id_paket');
        $stmt->execute([':id_paket' => $id_paket]);

        $_SESSION['success'] = 'Paket Berhasil Dihapus';
        header('Location: packages.php');
        return;
    }
?>

<div class="col-xs-12">
    <?php
        include 'flash_msg.php';

        if(empty($paket)){
            echo '<h1 class="text-center pt-4">Daftar Paket Tidak Ditemukan</h1>';
        }else{
    ?>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Paket</th>
                <th>Nama Paket</th>
                <th>Lokasi</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($paket as $pkt): ?>
                <tr>
                    <td><?php echo $no++ ; ?></td>
                    <td><?php echo $pkt['id_paket']; ?></td>
                    <td><?php echo $pkt['nama_paket']; ?></td>
                    <td><?php echo $pkt['lokasi_wisata']; ?></td>
                    <td><?php echo $pkt['deskripsi_paket']; ?></td>
                    <td><?php echo $pkt['harga_paket']; ?></td>
                    <td>
                        <a href="packages.php?page=edit_paket&edit=<?php echo $pkt['id_paket']; ?>" class="btn btn-outline-warning mt-1 mr-1"><i class="fas fa-edit"></i></a>
                        <a href="packages.php?delete=<?php echo $pkt['id_paket']; ?>" class="btn btn-outline-danger mt-1"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
        }
    ?>
</div>
