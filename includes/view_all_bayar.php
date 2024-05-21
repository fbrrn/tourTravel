<?php
    // Pembayaran Read Query
    $stmt = $pdo->query('SELECT * FROM tb_pembayaran');
    $pays = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Pembayaran Delete Query
    if(isset($_GET['delete'])){
        $id_pembayaran = $_GET['delete'];

        $stmt = $pdo->prepare('DELETE FROM tb_pembayaran WHERE id_pembayaran = :id_pembayaran');
        $stmt->execute([':id_pembayaran' => $id_pembayaran]);

        $_SESSION['success'] = 'Pembayaran Berhasil Dihapus';
        header('Location: payments.php');
        return;
    }
?>

<div class="col-xs-12">

    <?php
    include 'flash_msg.php';

    if (empty($pays)) {
        echo '<h1 class="text-center pt-4">Pembayaran Tidak Ditemukan</h1>';
    } else {
    ?>

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Pesanan</th>
                    <th>Nama Paket</th>
                    <th>Nama User</th>
                    <th>Total Pembayaran</th>
                    <th>Bukti</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($pays as $pay) {
                    echo '<tr>';
                    echo '<td>' . $no++ . '</td>';
                    echo '<td>' . $pay['id_pesanan'] . '</td>';

                    // Read nama_paket from tb_paket using id_paket
                    $stmt = $pdo->prepare('SELECT nama_paket FROM tb_paket WHERE id_paket = :id_paket');
                    $stmt->execute([':id_paket' => $pay['id_paket']]);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $nama_paket = $row['nama_paket'];
                    echo '<td>' . $nama_paket . '</td>';

                    // Read nama_user from tb_user using id_user
                    $stmt = $pdo->prepare('SELECT nama_user FROM tb_user WHERE id_user = :id_user');
                    $stmt->execute([':id_user' => $pay['id_user']]);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $nama_user = $row['nama_user'];
                    echo '<td>' . $nama_user . '</td>';

                    echo '<td>' . $pay['total_bayar'] . '</td>';

                    echo '<td><img src="../images/'. $pay["bukti"] .'" width="100" height="100" alt=""></td>';

                    echo '<td>';
                    echo '<a href="payments.php?page=edit_bayar&edit=' . $pay['id_pembayaran'] . '" class="btn btn-outline-warning mt-1 mr-1"><i class="fas fa-edit"></i></a>';
                    echo '<a href="payments.php?delete=' . $pay['id_pembayaran'] . '" class="btn btn-outline-danger mt-1"><i class="fas fa-trash-alt"></i></a>';
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>

    <?php
    }
    ?>
</div>
