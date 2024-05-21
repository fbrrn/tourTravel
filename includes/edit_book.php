<?php
if (isset($_GET['edit'])) {
    $id_pesanan = $_GET['edit'];

    $stmt = $pdo->prepare('SELECT * FROM tb_pesanan WHERE id_pesanan = :id_pesanan');
    $stmt->execute([':id_pesanan' => $id_pesanan]);
    $pesanan = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($pesanan === false) {
        // Handle case when no pesanan found
        echo "Pesanan tidak ditemukan.";
        return;
    }

    $paket_id = $pesanan['id_paket'];

    $stmtPaket = $pdo->prepare('SELECT * FROM tb_paket WHERE id_paket = :id_paket');
    $stmtPaket->execute([':id_paket' => $paket_id]);
    $paket = $stmtPaket->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST['update_pesanan'])) {
    $id_pesanan = $_POST['id_pesanan'];
    $id_paket = $_POST['id_paket'];
    $id_user = $_POST['id_user'];
    $jml_orang = $_POST['jml_orang'];
    $tgl_wisata = $_POST['tgl_wisata'];
    $harga_paket = $_POST['harga_paket'];
    $total_bayar = $jml_orang * $harga_paket;
    $status = $_POST['status'];

    $stmtUpdate = $pdo->prepare('UPDATE tb_pesanan SET id_paket = :id_paket, id_user = :id_user, jml_orang = :jml_orang, tgl_wisata = :tgl_wisata, total_bayar = :total_bayar, status = :status WHERE id_pesanan = :id_pesanan');
    $stmtUpdate->execute([
        ':id_paket' => $id_paket,
        ':id_user' => $id_user,
        ':jml_orang' => $jml_orang,
        ':tgl_wisata' => $tgl_wisata,
        ':total_bayar' => $total_bayar,
        ':status' => $status,
        ':id_pesanan' => $id_pesanan,
    ]);

    $_SESSION['success'] = 'Data pesanan berhasil diperbarui.';
    header('Location: bookings.php');
    return;
}
?>

<form action="" method="post" enctype="multipart/form-data" class="col-md-8">
    <div class="form-group p-2">
        <label for="id_paket">Paket</label>
        <select class="form-control" name="id_paket" onchange="updateHarga(this.value)">
            <?php
            $stmtPaket = $pdo->prepare('SELECT * FROM tb_paket');
            $stmtPaket->execute();
            $paketList = $stmtPaket->fetchAll(PDO::FETCH_ASSOC);

            foreach ($paketList as $paket) {
                $selected = ($paket['id_paket'] == $paket_id) ? 'selected' : '';
                echo '<option value="' . $paket['id_paket'] . '" ' . $selected . '>' . $paket['nama_paket'] . '</option>';
            }
            ?>
        </select>
    </div>
    <div class="form-group p-2">
        <input type="hidden" name="id_pesanan" value="<?php echo $id_pesanan; ?>">
        <label for="id_user">Pengguna</label>
        <select class="form-control" name="id_user">
            <?php
            $stmtUser = $pdo->prepare('SELECT * FROM tb_user');
            $stmtUser->execute();
            $userList = $stmtUser->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userList as $user) {
                $selected = ($user['id_user'] == $pesanan['id_user']) ? 'selected' : '';
                echo '<option value="' . $user['id_user'] . '" ' . $selected . '>' . $user['nama_user'] . '</option>';
            }
            ?>
        </select>
    </div>
    <div class="form-group p-2">
        <label for="jml_orang">Jumlah Orang</label>
        <input type="number" class="form-control" value="<?php echo $pesanan['jml_orang']; ?>" id="jml_orang" name="jml_orang" onchange="calculateTotal()">
    </div>
    <div class="form-group p-2">
        <label for="tgl_wisata">Tanggal Wisata</label>
        <input type="date" class="form-control" value="<?php echo $pesanan['tgl_wisata']; ?>" id="tgl_wisata" name="tgl_wisata">
    </div>
    <div class="form-group p-2">
        <label for="harga_paket">Harga (Per Orang)</label>
        <input type="number" class="form-control" value="<?php echo $paket['harga_paket']; ?>" id="harga_paket" name="harga_paket" readonly>
    </div>
    <div class="form-group p-2">
        <label for="total_bayar">Total Bayar</label>
        <input type="number" class="form-control" value="<?php echo $pesanan['total_bayar']; ?>" id="total_bayar" name="total_bayar" readonly>
    </div>
<div class="form-group p-2">
    <label for="status">Status</label>
    <select class="form-control" id="status" name="status">
        <option value="0" <?php echo ($pesanan['status'] == 0) ? 'selected' : ''; ?>>Belum Lunas</option>
        <option value="1" <?php echo ($pesanan['status'] == 1) ? 'selected' : ''; ?>>Lunas</option>
    </select>
</div>
    <div class="form-group p-2">
        <input type="submit" value="Perbarui Data Pesanan" name="update_pesanan" class="btn btn-primary">
        <a href="bookings.php" type="button" class="btn btn-secondary float-right">Batal</a>
    </div>
</form>

<script>
    function updateHarga(paketId) {
        var paketList = <?php echo json_encode($paketList); ?>;
        var hargaPaket = 0;

        for (var i = 0; i < paketList.length; i++) {
            if (paketList[i].id_paket == paketId) {
                hargaPaket = paketList[i].harga_paket;
                break;
            }
        }

        document.getElementById("harga_paket").value = hargaPaket;
        calculateTotal();
    }

    function calculateTotal() {
        var hargaPaket = document.getElementById("harga_paket").value;
        var jmlOrang = document.getElementById("jml_orang").value;
        var totalBayar = hargaPaket * jmlOrang;
        document.getElementById("total_bayar").value = totalBayar;
    }
</script>
