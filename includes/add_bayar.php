<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'flash_msg.php';
include 'koneksi.php';

// Pembayaran Insert Query...Added by Admin
if(isset($_POST['create_pembayaran'])){
    $id_pesanan = $_POST['id_pesanan'];
    $id_paket   = $_POST['id_paket'];
    $id_user    = $_POST['id_user'];
    $total_bayar = $_POST['total_bayar'];
    if($_FILES["bukti"]["error"] === 4){
        echo "<script> alert('Image Does Not Exist'); </script>";
    } else {
        $fileName = $_FILES["bukti"]["name"];
        $fileSize = $_FILES["bukti"]["size"];
        $tmpName = $_FILES["bukti"]["tmp_name"];

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

            // Insert Query
            $stmt = $pdo->prepare('INSERT INTO tb_pembayaran(id_pesanan, id_paket, id_user, total_bayar, bukti) VALUES(:id_pesanan, :id_paket, :id_user, :total_bayar, :bukti)');

            $stmt->execute([
                ':id_pesanan' => $id_pesanan,
                ':id_paket' => $id_paket,
                ':id_user' => $id_user,
                ':total_bayar' => $total_bayar,
                ':bukti' => $newImageName
            ]);

            $_SESSION['success'] = 'Pembayaran Baru Ditambahkan';
            header('Location: payments.php');
            return;
        }
    }
}
?>

<div class="container">
    <h2 class="p-2 pb-5">Tambah Pembayaran</h2>
    <form method="post" class="col-md-8" enctype="multipart/form-data">
        <div class="form-group p-2">
            <label for="id_pesanan">ID Pesan</label>
            <input type="number" class="form-control" id="id_pesanan" name="id_pesanan" value="<?php echo $row['id_pesanan']; ?>">
        </div>
        <div class="form-group p-2">
            <label for="id_paket">ID Paket</label>
            <input type="number" class="form-control" id="id_paket" name="id_paket" value="<?php echo $row['id_paket']; ?>">
        </div>
        <div class="form-group p-2">
            <label for="id_user">ID User</label>
            <input type="number" class="form-control" id="id_user" name="id_user" value="<?php echo $row['id_user']; ?>">
        </div>
        <div class="form-group p-2">
            <label for="total_bayar">Total Bayar</label>
            <input type="number" class="form-control" id="total_bayar" name="total_bayar" value="<?php echo $row['total_bayar']; ?>">
        </div>
        <div class="form-group p-2">
            <label for="bukti">Bukti Pembayaran</label>
            <input type="file" class="form-control-file" id="bukti" name="bukti" accept=".jpg, .jpeg, .png" value="">
        </div>
        <div class="form-group p-2">
            <input type="submit" value="Tambah Pembayaran" name="create_pembayaran" class="btn btn-primary">
            <a href="payments.php" type="button" class="btn btn-secondary float-right">Batal</a>
        </div>
    </form>
</div>
