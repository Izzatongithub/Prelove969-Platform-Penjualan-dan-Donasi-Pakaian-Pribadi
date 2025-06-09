<?php
session_start();
include '../config.php';

$id_transaksi = $_POST['id_transaksi'];
$id_pembeli = $_SESSION['id_user'];

// Ambil penjual dari produk yang dibeli
$q = mysqli_query($koneksi, "
    SELECT p.id_user AS id_penjual
    FROM detail_transaksi dt
    JOIN pakaian p ON dt.id_produk = p.id_pakaian
    WHERE dt.id_transaksi = '$id_transaksi' LIMIT 1
");
$data = mysqli_fetch_assoc($q);
$id_penjual = $data['id_penjual'];
?>

<h2>Beri Rating untuk Penjual</h2>

<form action="../proses/proses_rating.php" method="POST">
    <input type="hidden" name="id_transaksi" value="<?= $id_transaksi ?>">
    <input type="hidden" name="id_penjual" value="<?= $id_penjual ?>">
    <input type="hidden" name="id_pembeli" value="<?= $id_pembeli ?>">

    <label>Rating (1-5):</label><br>
    <select name="rating" required>
        <option value="">Pilih</option>
        <?php for ($i=1; $i<=5; $i++) echo "<option value='$i'>$i</option>"; ?>
    </select><br><br>

    <label>Ulasan:</label><br>
    <textarea name="ulasan" rows="4" cols="50"></textarea><br><br>

    <button type="submit">Kirim Rating</button>
</form>
