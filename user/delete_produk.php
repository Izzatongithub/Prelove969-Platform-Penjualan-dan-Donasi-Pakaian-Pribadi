<?php
session_start();
include '../config.php';

$id = $_GET['id_pakaian'];
$id_user = $_SESSION['id_user'];

// Pastikan produk milik user
$cek = mysqli_query($koneksi, "SELECT * FROM pakaian WHERE id_pakaian = '$id' AND id_user = '$id_user'");
echo "error" . mysqli_error($cek);
if (mysqli_num_rows($cek) > 0) {
    mysqli_query($koneksi, "DELETE FROM pakaian WHERE id_pakaian = '$id'");
}


header("Location: ../user/profil_saya.php");
exit();
