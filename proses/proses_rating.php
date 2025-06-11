<?php
session_start();
include '../config.php';

$id_transaksi = $_POST['id_transaksi'];
$id_penjual = $_POST['id_penjual'];
$id_pembeli = $_POST['id_pembeli'];
$rating = $_POST['rating'];
$ulasan = mysqli_real_escape_string($koneksi, $_POST['ulasan']);

// Simpan rating
mysqli_query($koneksi, "INSERT INTO reviews (id_transaksi, id_penjual, id_pembeli, rating, ulasan)
    VALUES ('$id_transaksi', '$id_penjual', '$id_pembeli', '$rating', '$ulasan')");

// Ubah status transaksi menjadi "selesai"
mysqli_query($koneksi, "UPDATE transaksi SET status_transaksi = 'selesai' WHERE id_transaksi = '$id_transaksi'");

header("Location: ../user/pesananku.php");
exit();
