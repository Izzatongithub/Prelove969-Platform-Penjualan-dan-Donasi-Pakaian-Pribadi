<?php
session_start();
include '../config.php';

$id_transaksi = $_SESSION['id_transaksi'] ?? null;
$status = $_GET['status'] ?? null;

if (!$id_transaksi || !$status) {
    die("Transaksi tidak ditemukan.");
}

if ($status === 'sukses') {

    // 1. Update status transaksi
    $q1 = mysqli_query($koneksi, "UPDATE transaksi SET status_transaksi='menunggu' WHERE id_transaksi='$id_transaksi'");
    if (!$q1) {
        die("Gagal update transaksi: " . mysqli_error($koneksi));
    }

    // 2. Update status pakaian ke 'habis'
    $produk = mysqli_query($koneksi, "SELECT id_produk FROM detail_transaksi WHERE id_transaksi='$id_transaksi'");
    if (!$produk) {
        die("Gagal ambil data produk: " . mysqli_error($koneksi));
    }

    while ($row = mysqli_fetch_assoc($produk)) {
        $id_produk = $row['id_produk'];
        $update = mysqli_query($koneksi, "UPDATE pakaian SET status_ketersediaan='Terjual' WHERE id_pakaian='$id_produk'");
        if (!$update) {
            echo "Gagal update status pakaian ID $id_produk: " . mysqli_error($koneksi) . "<br>";
        }
    }

    // 3. Hapus isi keranjang
    $hapus = mysqli_query($koneksi, "DELETE FROM keranjang_detail 
        WHERE id_keranjang = (SELECT id_keranjang FROM transaksi WHERE id_transaksi='$id_transaksi')");
    if (!$hapus) {
        echo "Gagal hapus keranjang: " . mysqli_error($koneksi);
    }
}

header("Location: pesananku.php?kode=" . $_SESSION['kode_invoice']);
exit;
?>
