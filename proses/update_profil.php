<?php
session_start();
include '../config.php';

$id = $_POST['id_user'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$alamat = $_POST['alamat'];
$no_telp = $_POST['no_telp'];

if ($id == $_SESSION['id_user']) {
    mysqli_query($koneksi, "UPDATE user SET nama='$nama', email='$email', alamat='$alamat', no_telp='$no_telp' WHERE id_user='$id'");
}
header("Location: ../user/profil_saya.php");
exit();
