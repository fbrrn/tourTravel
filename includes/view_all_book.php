<?php
    // Pesanan Read Query
    $stmt = $pdo->query('SELECT * FROM tb_pesanan');
    $pesanan = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Pesanan Delete Query
    if(isset($_GET['delete'])){
        $id_pesanan = $_GET['delete'];

        $stmt = $pdo->prepare('DELETE FROM tb_pesanan WHERE id_pesanan = :id_pesanan');
        $stmt->execute([':id_pesanan' => $id_pesanan]);

        $_SESSION['success'] = 'Pesanan Berhasil Dihapus';
        header('Location: bookings.php');
        return;
    }
?>

<div class="col-xs-12">

    <?php
    include 'flash_msg.php';

    if (empty($pesanan)) {
        echo '<h1 class="text-center pt-4">No Tourist Found</h1>';
    } else {
    ?>

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Pesanan</th>
                    <th>Nama Paket</th>
                    <th>Nama User</th>
                    <th>Jumlah Orang</th>
                    <th>Tanggal Wisata</th>
                    <th>Tanggal Pesan</th>
                    <th>Total Pembayaran</th>
                    <th>Status Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($pesanan as $tourist) {
                    echo '<tr>';
                    echo '<td>' . $no++ . '</td>';
                    echo '<td>' . $tourist['id_pesanan'] . '</td>';

                    // Read nama_paket from tb_paket using id_paket
                    $stmt = $pdo->prepare('SELECT nama_paket FROM tb_paket WHERE id_paket = :id_paket');
                    $stmt->execute([':id_paket' => $tourist['id_paket']]);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $nama_paket = $row['nama_paket'];
                    echo '<td>' . $nama_paket . '</td>';

                    // Read nama_user from tb_user using id_user
                    $stmt = $pdo->prepare('SELECT nama_user FROM tb_user WHERE id_user = :id_user');
                    $stmt->execute([':id_user' => $tourist['id_user']]);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $nama_user = $row['nama_user'];
                    echo '<td>' . $nama_user . '</td>';

                    echo '<td>' . $tourist['jml_orang'] . '</td>';
                    echo '<td>' . $tourist['tgl_wisata'] . '</td>';
                    echo '<td>' . $tourist['tgl_pesan'] . '</td>';
                    echo '<td>' . $tourist['total_bayar'] . '</td>';

                    echo '<td class="text-center">';
                    if ($tourist['status'] == 0) {
                        echo '<span class="badge badge-warning">Belum Lunas</span>';
                    } elseif ($tourist['status'] == 1) {
                        echo '<span class="badge badge-success">Lunas</span>';
                    }
                    echo '</td>';

                    echo '<td>';
                    echo '<a href="bookings.php?page=edit_book&edit=' . $tourist['id_pesanan'] . '" class="btn btn-outline-warning mt-1 mr-1"><i class="fas fa-edit"></i></a>';
                    echo '<a href="bookings.php?delete=' . $tourist['id_pesanan'] . '" class="btn btn-outline-danger mt-1"><i class="fas fa-trash-alt"></i></a>';
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
