<?php
session_start();
include '../config.php';

$id = $_POST['id_pakaian'];
$id_user = $_SESSION['id_user'];
$nama = $_POST['nama_pakaian'];
$harga = $_POST['harga'];
$deskripsi = $_POST['deskripsi'];

$query = mysqli_query($koneksi, "SELECT * FROM pakaian WHERE id_pakaian = '$id' AND id_user = '$id_user'");
if (mysqli_num_rows($query) > 0) {
    mysqli_query($koneksi, "UPDATE pakaian SET nama_pakaian='$nama', harga='$harga', deskripsi='$deskripsi' WHERE id_pakaian='$id'");
}
header("Location: ../user/profil_saya.php");
exit();
