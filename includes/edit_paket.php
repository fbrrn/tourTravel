<?php
    if (isset($_GET['edit'])) {
        $id_paket = $_GET['edit'];

        $stmt = $pdo->prepare('SELECT * FROM tb_paket WHERE id_paket = :id_paket');
        $stmt->execute([':id_paket' => $id_paket]);

        if (isset($_POST['update_package'])) {
            $name = htmlentities($_POST['nama_paket']);
            $lokasi = htmlentities($_POST['lokasi_wisata']);
            $desk = htmlentities($_POST['deskripsi_paket']);
            $harga = htmlentities($_POST['harga_paket']);

            // Empty Field Validation
            if ($name == '' || $harga == '') {
                $_SESSION['error'] = 'Mohon Isi Semua Kolom';
                header('Location: packages.php?page=edit_paket&edit='. $id_paket);
                return;
            } else {
                $stmt = $pdo->prepare('UPDATE tb_paket SET nama_paket = :nama_paket, lokasi_wisata = :lokasi_wisata, deskripsi_paket = :deskripsi_paket, harga_paket = :harga_paket WHERE id_paket = :id_paket');

                $stmt->execute([
                    ':id_paket' => $id_paket,
                    ':nama_paket' => $name,
                    ':lokasi_wisata' => $lokasi,
                    ':deskripsi_paket' => $desk,
                    ':harga_paket' => $harga,
                ]);

                $_SESSION['success'] = 'Paket Telah Terupdate';
                header('Location: packages.php');
                return;
            }
        }
    }
?>


<br><br>
<div class="container">
    <h2 class="p-2 pb-5">Update Data Paket</h2>

    <?php
    include 'flash_msg.php';

    //package Read Query for specific id
    if (isset($_GET['edit'])) {
        $id_paket = $_GET['edit'];

        $stmt = $pdo->prepare('SELECT * FROM tb_paket WHERE id_paket = :id_paket');
        $stmt->execute([':id_paket' => $id_paket]);
        $package = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($package === false) {
            // Handle case when no package found
            echo "Paket tidak ditemukan.";
            return;
        }
    }
    ?>

    <form action="" method="post" enctype="multipart/form-data" class="col-md-8">
        <div class="form-group p-2">
            <label for="nama_paket">Nama Paket</label>
            <input type="text" class="form-control" value="<?php echo isset($package['nama_paket']) ? $package['nama_paket'] : ''; ?>" id="" name="nama_paket">
        </div>
        <div class="form-group pb-2">
            <label for="lokasi_wisata">Lokasi</label>
            <input type="text" class="form-control" value="<?php echo isset($package['lokasi_wisata']) ? $package['lokasi_wisata'] : ''; ?>" id="" name="lokasi_wisata">
        </div>
        <div class="form-group p-2">
            <label for="harga_paket">Harga (Per Orang)</label>
            <input type="number" class="form-control" value="<?php echo $package['harga_paket']; ?>" id="" name="harga_paket"><br>
        </div>
        <div class="form-group p-2">
            <label for="deskripsi_paket">Deskripsi</label>
            <textarea name="deskripsi_paket" class="form-control" id="" cols="30" rows="5"><?php echo $package['deskripsi_paket']; ?></textarea>
        </div>
        <div class="form-group p-2">
            <input type="submit" value="Perbarui Data Paket" name="update_package" class="btn btn-primary">

            <a href="packages.php" type="button" class="btn btn-secondary float-right">Batal</a>
        </div>
    </form>
</div>
