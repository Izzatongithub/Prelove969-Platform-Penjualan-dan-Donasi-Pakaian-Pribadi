<?php
session_start();
include '../config.php';

$id_user = $_SESSION['id_user'];
$kode_invoice = 'INV' . time();
$status = 'menunggu';
$total = 0;
$produkList = [];
$isLangsung = isset($_GET['id_pakaian']);

// ======== 1. CHECKOUT LANGSUNG (DARI "BELI SEKARANG") =========
if ($isLangsung) {
    $id_pakaian = $_GET['id_pakaian'];

    $qProduk = mysqli_query($koneksi, "SELECT id_pakaian, nama_pakaian, harga FROM pakaian WHERE id_pakaian = '$id_pakaian'");

    if ($row = mysqli_fetch_assoc($qProduk)) {
        $produkList[] = $row;
        $total += $row['harga'];
    } else {
        die("Produk tidak ditemukan.");
    }

    // Simpan transaksi langsung tanpa keranjang
    mysqli_query($koneksi, "INSERT INTO transaksi (id_user, kode_invoice, total_harga, status_transaksi, tgl_transaksi) 
        VALUES ('$id_user', '$kode_invoice', '$total', '$status', NOW())");
    $id_transaksi = mysqli_insert_id($koneksi);

    // Simpan detail produk
    foreach ($produkList as $item) {
        $id_produk = $item['id_pakaian'];
        $harga = $item['harga'];

        mysqli_query($koneksi, "INSERT INTO detail_transaksi (id_transaksi, id_produk, harga, subtotal)
            VALUES ('$id_transaksi', '$id_produk', '$harga', '$harga')
        ");
    }
} 

// ======== 2. CHECKOUT DARI KERANJANG =========
else {
    $qKeranjang = mysqli_query($koneksi, "SELECT * FROM keranjang WHERE id_user = '$id_user'");
    $dKeranjang = mysqli_fetch_assoc($qKeranjang);
    $id_keranjang = $dKeranjang['id_keranjang'] ?? null;

    if (!$id_keranjang) die("Keranjang tidak ditemukan.");

    $qProduk = mysqli_query($koneksi, "SELECT p.id_pakaian, p.nama_pakaian, p.harga
        FROM keranjang_detail kd
        JOIN pakaian p ON kd.id_produk = p.id_pakaian
        WHERE kd.id_keranjang = '$id_keranjang'");

    while ($row = mysqli_fetch_assoc($qProduk)) {
        $produkList[] = $row;
        $total += $row['harga'];
    }

    if (empty($produkList)) die("Keranjang kosong.");

    // Simpan transaksi
    mysqli_query($koneksi, "INSERT INTO transaksi (id_keranjang, id_user, kode_invoice, total_harga, status_transaksi, tgl_transaksi)
        VALUES ('$id_keranjang', '$id_user', '$kode_invoice', '$total', '$status', NOW())
    ");
    $id_transaksi = mysqli_insert_id($koneksi);

    // Simpan detail produk
    foreach ($produkList as $item) {
        $id_produk = $item['id_pakaian'];
        $harga = $item['harga'];

        mysqli_query($koneksi, "
            INSERT INTO detail_transaksi (id_transaksi, id_produk, harga, subtotal)
            VALUES ('$id_transaksi', '$id_produk', '$harga', '$harga')
        ");
    }
}

// Redirect ke pemilihan metode pembayaran
header("Location: ../user/pilih_metode_pembayaran.php?id_transaksi=$id_transaksi");
exit();
?>
