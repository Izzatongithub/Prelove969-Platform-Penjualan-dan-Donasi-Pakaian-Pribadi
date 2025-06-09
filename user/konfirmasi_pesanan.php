<?php
include '../config.php';
session_start();

if (isset($_POST['id_transaksi'])) {
    $id_transaksi = $_POST['id_transaksi'];

    // Ubah status transaksi jadi 'selesai'
    mysqli_query($koneksi, "UPDATE transaksi SET status_transaksi = 'selesai' WHERE id_transaksi = '$id_transaksi'");

    header("Location: pesananku.php");
    exit();
}
?>
