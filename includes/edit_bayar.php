<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'flash_msg.php';
include 'koneksi.php';

// Admin Update Query
if(isset($_GET['edit'])){
    $id_pembayaran = $_GET['edit'];

    if(isset($_POST['update_bayar'])){
        $id_pesanan = $_POST['id_pesanan'];
        $id_paket   = $_POST['id_paket'];
        $id_user    = $_POST['id_user'];
        $total_bayar = $_POST['total_bayar'];
        $bukti_lama = $_POST['bukti_lama']; // Nilai bukti lama yang disimpan dalam input tersembunyi

        $fileName = $_FILES["bukti"]["name"];
        $fileSize = $_FILES["bukti"]["size"];
        $tmpName = $_FILES["bukti"]["tmp_name"];

        if (empty($fileName) && !isset($_POST['keep_bukti'])) {
            echo "<script> alert('Image Does Not Exist'); </script>";
        } else if (!empty($fileName)) {
            $validImageExtension = ['jpg', 'jpeg', 'png'];
            $imageExtension = explode('.', $fileName);
            $imageExtension = strtolower(end($imageExtension));

            if(!in_array($imageExtension, $validImageExtension)){
                echo "<script> alert('Invalid Image Extension'); </script>";
            } else if($fileSize > 1000000){
                echo "<script> alert('Image Size is Too Large'); </script>";
            } else {
                $newImageName = uniqid() . '.' . $imageExtension;
                move_uploaded_file($tmpName, 'images/' . $newImageName);

                // Menggunakan nilai bukti lama jika checkbox "keep_bukti" tercentang
                $bukti = isset($_POST['keep_bukti']) ? $bukti_lama : $newImageName;

                $stmtUpdate = $pdo->prepare('UPDATE tb_pembayaran SET id_pesanan = :id_pesanan, id_paket = :id_paket, id_user = :id_user, total_bayar = :total_bayar, bukti = :bukti WHERE id_pembayaran = :id_pembayaran');

                $stmtUpdate->execute([
                    ':id_pesanan' => $id_pesanan,
                    ':id_paket' => $id_paket,
                    ':id_user' => $id_user,
                    ':total_bayar' => $total_bayar,
                    ':bukti' => $bukti,
                    ':id_pembayaran' => $id_pembayaran
                ]);

                $_SESSION['success'] = 'Data Pembayaran Telah Diupdate';
                header('Location: payments.php');
                return;
            }
        } else {
            // Tidak ada file yang diunggah dan checkbox "keep_bukti" tercentang
            $bukti = $bukti_lama;

            $stmtUpdate = $pdo->prepare('UPDATE tb_pembayaran SET id_pesanan = :id_pesanan, id_paket = :id_paket, id_user = :id_user, total_bayar = :total_bayar, bukti = :bukti WHERE id_pembayaran = :id_pembayaran');

            $stmtUpdate->execute([
                ':id_pesanan' => $id_pesanan,
                ':id_paket' => $id_paket,
                ':id_user' => $id_user,
                ':total_bayar' => $total_bayar,
                ':bukti' => $bukti,
                ':id_pembayaran' => $id_pembayaran
            ]);

            $_SESSION['success'] = 'Data Pembayaran Telah Diupdate';
            header('Location: payments.php');
            return;
        }
    } else {
        $stmt = $pdo->prepare('SELECT id_pesanan, id_paket, id_user, total_bayar, bukti FROM tb_pembayaran WHERE id_pembayaran = :id_pembayaran');
        $stmt->execute([':id_pembayaran' => $id_pembayaran]);
        $bayar = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

<div class="container">
    <h2 class="p-2 pb-5">Perbarui Data Pembayaran</h2>

    <?php
    include 'flash_msg.php';

    if(isset($_GET['edit'])){
    ?>

    <form action="" method="post" class="col-md-8" enctype="multipart/form-data">
        <div class="form-group p-2">
            <label for="id_pesanan">ID Pesan</label>
            <input type="number" class="form-control" value="<?php echo $bayar['id_pesanan']; ?>" name="id_pesanan">
        </div>
        <div class="form-group pb-2">
            <label for="id_paket">ID Paket</label>
            <input type="number" class="form-control" value="<?php echo $bayar['id_paket']; ?>" name="id_paket">
        </div>
        <div class="form-group p-2">
            <label for="id_user">ID User</label>
            <input type="number" class="form-control" value="<?php echo $bayar['id_user']; ?>" name="id_user">
        </div>
        <div class="form-group p-2">
            <label for="total_bayar">Total Bayar</label>
            <input type="number" class="form-control" value="<?php echo $bayar['total_bayar']; ?>" name="total_bayar">
        </div>
        <div class="form-group p-2">
            <label for="bukti">Bukti Pembayaran</label>
            <img src="images/<?= $bayar['bukti']; ?>" width="50"> <br>
            <input type="file" class="form-control" name="bukti">
            <input type="hidden" name="bukti_lama" value="<?= $bayar['bukti']; ?>">
        </div>
        <div class="form-group p-2">
            <input type="checkbox" class="form-check-input" name="keep_bukti" id="keep_bukti">
            <label class="form-check-label" for="keep_bukti">
                Gunakan Bukti Yang Sudah Ada
            </label>
        </div>
        <div class="form-group p-2">
            <input type="submit" value="Perbarui Data Pembayaran" name="update_bayar" class="btn btn-primary">

            <a href="payments.php" type="button" class="btn btn-secondary float-right">Batal</a>
        </div>
    </form>

    <?php
    }
    ?>
</div>
