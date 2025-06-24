<?php
session_start();
include '../config.php';

// Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit();
}

$id_user = $_SESSION['id_user'];

// Cek apakah id_produk tersedia
if (!isset($_GET['id_produk'])) {
    echo "ID produk tidak ditemukan.";
    exit();
}

$id_produk = $_GET['id_produk'];

// Ambil id keranjang user
$query_keranjang = mysqli_query($koneksi, "SELECT id_keranjang FROM keranjang WHERE id_user = '$id_user'");
$data = mysqli_fetch_assoc($query_keranjang);

if (!$data) {
    echo "Keranjang tidak ditemukan.";
    exit();
}

$id_keranjang = $data['id_keranjang'];

// Debug query hapus
$query_delete = "DELETE FROM keranjang_detail WHERE id_keranjang = '$id_keranjang' AND id_produk = '$id_produk'";
if (mysqli_query($koneksi, $query_delete)) {
    header("Location: keranjang.php");
    exit();
} else {
    echo "Gagal menghapus produk: " . mysqli_error($koneksi);
}
