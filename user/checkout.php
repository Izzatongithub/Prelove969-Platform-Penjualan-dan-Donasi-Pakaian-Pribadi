<?php
session_start();
include '../config.php'; // koneksi ke database

// Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION['id_user'];

// Ambil id_keranjang user
$queryKeranjang = mysqli_query($koneksi, "SELECT id_keranjang FROM keranjang WHERE id_user = '$id_user'");
$dataKeranjang = mysqli_fetch_assoc($queryKeranjang);
if (!$dataKeranjang || !isset($dataKeranjang['id_keranjang'])) {
    die("Keranjang tidak ditemukan.");
}
$id_keranjang = $dataKeranjang['id_keranjang'];


if (!$id_keranjang) {
    die("Keranjang tidak ditemukan.");
}

// Ambil semua isi keranjang
$queryProduk = mysqli_query($koneksi, "SELECT kd.id_produk, p.harga 
    FROM keranjang_detail kd
    JOIN pakaian p ON kd.id_produk = p.id_pakaian
    WHERE kd.id_keranjang = '$id_keranjang'");

$total_harga = 0;
$produkList = [];

while ($row = mysqli_fetch_assoc($queryProduk)) {
    $produkList[] = $row;
    $total_harga += $row['harga'];
}

// Jika keranjang kosong
if (empty($produkList)) {
    die("Keranjang kosong, tidak bisa checkout.");
}

// Simulasi kode invoice dan id_midtrans
$kode_invoice = 'INV' . time();
$id_midtrans = 'MID' . uniqid();

// Buat entri transaksi baru
mysqli_query($koneksi, "INSERT INTO transaksi (id_keranjang, id_user, kode_invoice, total_harga, status_transaksi, metode_pembayaran, id_midtrans)
    VALUES ('$id_keranjang', '$id_user', '$kode_invoice', '$total_harga', 'menunggu', 'cod', '$id_midtrans')");

// Ambil ID transaksi terakhir
$id_transaksi = mysqli_insert_id($koneksi);

// Masukkan ke detail_transaksi dan update status pakaian
foreach ($produkList as $item) {
    $id_produk = $item['id_produk'];
    $harga = $item['harga'];
    $subtotal = $harga;

    mysqli_query($koneksi, "INSERT INTO detail_transaksi (id_transaksi, id_produk, harga, subtotal)
        VALUES ('$id_transaksi', '$id_produk', '$harga', '$subtotal')");

    // Ubah status ketersediaan pakaian jadi 'habis'
    mysqli_query($koneksi, "UPDATE pakaian SET status_ketersediaan = 'habis' WHERE id_pakaian = '$id_produk'");
}

// Kosongkan isi keranjang
mysqli_query($koneksi, "DELETE FROM keranjang_detail WHERE id_keranjang = '$id_keranjang'");

// Redirect ke halaman sukses
header("Location: transaksi_sukses.php?kode=$kode_invoice");
exit();
?>
