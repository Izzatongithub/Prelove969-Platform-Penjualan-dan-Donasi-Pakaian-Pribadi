<?php
session_start();
include '../config.php';

$id_transaksi = $_POST['id_transaksi'];
$status_baru = $_POST['status_transaksi'];

// Ambil status saat ini dari database
$result = mysqli_query($koneksi, "SELECT status_transaksi FROM transaksi WHERE id_transaksi = '$id_transaksi'");
$data = mysqli_fetch_assoc($result);
$status_sekarang = $data['status_transaksi'];

// Cek perubahan status hanya boleh urut
$valid_transisi = [
    'menunggu' => 'diproses',
    'diproses' => 'dikirim',
    'dikirim'  => 'selesai'
];

if (isset($valid_transisi[$status_sekarang]) && $valid_transisi[$status_sekarang] === $status_baru) {
    mysqli_query($koneksi, "UPDATE transaksi SET status_transaksi = '$status_baru' WHERE id_transaksi = '$id_transaksi'");
    header("Location: ../user/pesanan_masuk.php");
    exit();
} else {
    echo "Transisi status tidak valid.";
}
?>
