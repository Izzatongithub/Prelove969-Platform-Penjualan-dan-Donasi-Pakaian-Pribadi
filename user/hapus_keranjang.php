<?php
session_start();
include '../config.php';

$id_user = $_SESSION['id_user'];
$id_produk = $_GET['id_produk'];

// Ambil id keranjang user
$query_keranjang = mysqli_query($koneksi, "SELECT id_keranjang FROM keranjang WHERE id_user = '$id_user'");
$data = mysqli_fetch_assoc($query_keranjang);
$id_keranjang = $data['id_keranjang'];

// Hapus produk dari keranjang_detail
mysqli_query($koneksi, "DELETE FROM keranjang_detail WHERE id_keranjang = '$id_keranjang' AND id_produk = '$id_produk'");

// Kembali ke halaman keranjang
header("Location: keranjang.php");
exit();
