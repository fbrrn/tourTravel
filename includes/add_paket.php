<?php
//Tourist Insert Query...Added by Admin
if(isset($_POST['create_tourist'])){
    $name  = htmlentities($_POST['nama_paket']);
    $location   = htmlentities($_POST['lokasi_wisata']);
    $desc      = htmlentities($_POST['deskripsi_paket']);
    $harga      = htmlentities($_POST['harga_paket']);

    //Empty Field Validation
    if($location == '' || $name == '' || $desc == '' || $harga == ''){
        $_SESSION['error'] = 'Isi Semua Form';
        header('Location: packages.php?page=add_paket');
        return;
    }

    //location Validation
    $stmt = $pdo->prepare('SELECT * FROM tb_paket WHERE nama_paket = :nama_paket');
    $stmt->execute([':nama_paket' => $location]);
    $name_paket = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(!empty($name_paket)){
        $_SESSION['error'] = 'Nama paket telah ada.';
        header('Location: packages.php?page=add_paket');
        return;
    }
    else{
        $stmt = $pdo->prepare('INSERT INTO tb_paket(nama_paket, lokasi_wisata, deskripsi_paket, harga_paket) VALUES(:nama_paket, :lokasi_wisata, :deskripsi_paket, :harga_paket)');

        $stmt->execute([
            ':nama_paket' => $name,
            ':lokasi_wisata' => $location,
            ':deskripsi_paket' => $desc,
            ':harga_paket' => $harga
        ]);

        $_SESSION['success'] = 'Paket Baru Ditambahkan';
        header('Location: packages.php');
        return;
    }
}
?>

<br><br>
<div class="container">
    <h2 class="p-2 pb-5">Tambah Paket</h2>

    <?php
    include 'flash_msg.php';
    ?>

    <form action="" method="post" class="col-md-8">
        <div class="form-group p-2">
            <label for="nama_paket">Nama Paket</label>
            <input type="text" class="form-control" id="" name="nama_paket">
        </div>
        <div class="form-group p-2">
            <label for="lokasi_wisata">Lokasi</label>
            <input type="text" class="form-control" id="" name="lokasi_wisata">
        </div>
        <div class="form-group p-2">
            <label for="deskripsi_paket">Deskripsi</label>
            <textarea name="deskripsi_paket" class="form-control" id="body" cols="30" rows="5"></textarea>
        </div>
        <div class="form-group p-2">
            <label for="harga_paket">Harga (Per Orang)</label>
            <input type="number" class="form-control" value="" id="" name="harga_paket"><br>
        </div>
        <div class="form-group p-2">
            <input type="submit" value="Buat Paket" name="create_tourist" class="btn btn-primary">

            <a href="packages.php" type="button" class="btn btn-secondary float-right">Batal</a>
        </div>
    </form>
</div>
