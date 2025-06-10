<?php
session_start();
include '../config.php';

$id = $_GET['id'];
$id_user = $_SESSION['id_user'];

$query = mysqli_query($koneksi, "SELECT * FROM pakaian WHERE id_pakaian = '$id' AND id_user = '$id_user'");
$data = mysqli_fetch_assoc($query);
if (!$data) die("Produk tidak ditemukan atau bukan milik Anda.");
?>

<h2>Edit Produk</h2>
<form action="../proses/update_produk.php" method="post">
    <input type="hidden" name="id_pakaian" value="<?= $data['id_pakaian'] ?>">
    Nama: <input type="text" name="nama_pakaian" value="<?= $data['nama_pakaian'] ?>"><br>
    Harga: <input type="number" name="harga" value="<?= $data['harga'] ?>"><br>
    Deskripsi:<br>
    <textarea name="deskripsi"><?= $data['deskripsi'] ?></textarea><br>
    <button type="submit">Simpan</button>
</form>
