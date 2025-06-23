<?php
session_start();
include '../config.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit();
}

$id = $_GET['id_pakaian'];
$id_user = $_SESSION['id_user'];

// Debug sementara
// var_dump($id, $id_user);

$cek = mysqli_query($koneksi, "SELECT * FROM pakaian WHERE id_pakaian = '$id' AND id_user = '$id_user'");
if (!$cek) {
    die("Query error: " . mysqli_error($koneksi));
}

if (mysqli_num_rows($cek) > 0) {
    $hapus = mysqli_query($koneksi, "DELETE FROM pakaian WHERE id_pakaian = '$id'");
    if (!$hapus) {
        die("Gagal menghapus: " . mysqli_error($koneksi));
    }
}

header("Location: profil_saya.php");
exit();
