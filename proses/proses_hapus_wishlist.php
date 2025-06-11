<?php
session_start();
include '../config.php';

// Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit();
}

$id_user = $_SESSION['id_user'];

// Pastikan ada data yang dikirim
if (!isset($_POST['id_pakaian'])) {
    die("ID pakaian tidak ditemukan.");
}

$id_pakaian = $_POST['id_pakaian'];

// Hapus data dari tabel likes
$query = "DELETE FROM likes WHERE id_user = '$id_user' AND id_pakaian = '$id_pakaian'";
$result = mysqli_query($koneksi, $query);

if ($result) {
    header("Location: ../user/wishlist.php");
    exit();
} else {
    die("Gagal menghapus dari wishlist: " . mysqli_error($koneksi));
}
?>
