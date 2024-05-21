<?php
// Pesanan Insert Query...Added by Admin
if(isset($_POST['create_book'])){
    $id_paket   = htmlentities($_POST['id_paket']);
    $id_user    = htmlentities($_POST['id_user']);
    $jml_orang  = htmlentities($_POST['jml_orang']);
    $tgl_wisata = htmlentities($_POST['tgl_wisata']);
    $tgl_pesan  = date('Y-m-d'); // Tanggal pesan diatur sebagai tanggal saat ini
    $total_bayar = 0; // Set total bayar awalnya sebagai 0
    $status     = 0; // Set status awal sebagai 'belum lunas'

    // Empty Field Validation
    if($id_paket == '' || $id_user == '' || $jml_orang == '' || $tgl_wisata == ''){
        $_SESSION['error'] = 'Isi Semua Form';
        header('Location: packages.php?page=add_paket');
        return;
    }

    // Query untuk memeriksa apakah paket dengan id_paket yang diberikan ada dalam tabel paket
    $stmt = $pdo->prepare('SELECT * FROM tb_paket WHERE id_paket = :id_paket');
    $stmt->execute([':id_paket' => $id_paket]);
    $paket = $stmt->fetch(PDO::FETCH_ASSOC);

    // Query untuk memeriksa apakah user dengan id_user yang diberikan ada dalam tabel user
    $stmt = $pdo->prepare('SELECT * FROM tb_user WHERE id_user = :id_user');
    $stmt->execute([':id_user' => $id_user]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Validasi paket dan user
    if(!$paket || !$user){
        $_SESSION['error'] = 'Paket atau user tidak valid.';
        header('Location: packages.php?page=add_paket');
        return;
    }

    // Hitung total bayar berdasarkan harga paket dan jumlah orang
    $total_bayar = $paket['harga_paket'] * $jml_orang;

    // Insert pesanan baru ke tabel pesanan
    $stmt = $pdo->prepare('INSERT INTO tb_pesanan(id_paket, id_user, jml_orang, tgl_wisata, tgl_pesan, total_bayar, status) VALUES(:id_paket, :id_user, :jml_orang, :tgl_wisata, :tgl_pesan, :total_bayar, :status)');

    $stmt->execute([
        ':id_paket' => $id_paket,
        ':id_user' => $id_user,
        ':jml_orang' => $jml_orang,
        ':tgl_wisata' => $tgl_wisata,
        ':tgl_pesan' => $tgl_pesan,
        ':total_bayar' => $total_bayar,
        ':status' => $status
    ]);

    $_SESSION['success'] = 'Pesanan Baru Ditambahkan';
    header('Location: bookings.php');
    return;
}
?>

<script>
function calculateTotal() {
    var hargaPaket = parseInt(document.getElementById('id_paket').options[document.getElementById('id_paket').selectedIndex].getAttribute('data-harga'));
    var jmlOrang = parseInt(document.getElementById('jml_orang').value);
    var totalBayar = hargaPaket * jmlOrang;

    document.getElementById('total_bayar').value = totalBayar;
}</script>

<br><br>
<div class="container">
    <h2 class="p-2 pb-5">Tambah Pesanan</h2>

    <?php
    include 'flash_msg.php';
    ?>

    <form action="" method="post" class="col-md-8">
        <div class="form-group p-2">
            <label for="id_paket">Paket</label>
            <select class="form-control" name="id_paket" id="id_paket" onchange="calculateTotal()">
                <?php
                // Query untuk mendapatkan daftar paket wisata
                $stmt = $pdo->prepare('SELECT * FROM tb_paket');
                $stmt->execute();
                $paketList = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($paketList as $paket) {
                    echo '<option value="' . $paket['id_paket'] . '" data-harga="' . $paket['harga_paket'] . '">' . $paket['nama_paket'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group p-2">
            <label for="id_user">Pengguna</label>
            <select class="form-control" name="id_user">
                <?php
                // Query untuk mendapatkan daftar user
                $stmt = $pdo->prepare('SELECT * FROM tb_user');
                $stmt->execute();
                $userList = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userList as $user) {
                    echo '<option value="' . $user['id_user'] . '">' . $user['nama_user'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group p-2">
            <label for="jml_orang">Jumlah Orang</label>
            <input type="number" class="form-control" value="" id="jml_orang" name="jml_orang" onchange="calculateTotal()">
        </div>
        <div class="form-group p-2">
            <label for="tgl_wisata">Tanggal Wisata</label>
            <input type="date" class="form-control" value="<?php echo date('Y/m/d'); ?>" id="" name="tgl_wisata">
        </div>
        <div class="form-group p-2">
            <label for="total_bayar">Total Bayar</label>
            <input type="text" class="form-control" id="total_bayar" name="total_bayar" readonly>
        </div>
        <div class="form-group p-2">
            <input type="submit" value="Buat" name="create_book" class="btn btn-primary">

            <a href="bookings.php" type="button" class="btn btn-secondary float-right">Batal</a>
        </div>
    </form>
</div>