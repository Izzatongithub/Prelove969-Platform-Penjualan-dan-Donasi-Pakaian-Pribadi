<?php
session_start();
include '../config.php'; // koneksi ke database

// Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION['id_user'];

// Ambil keranjang user
$query_keranjang = mysqli_query($koneksi, "SELECT * FROM keranjang WHERE id_user = '$id_user'");
if (mysqli_num_rows($query_keranjang) == 0) {
    mysqli_query($koneksi, "INSERT INTO keranjang (id_user) VALUES ('$id_user')");
    $id_keranjang = mysqli_insert_id($koneksi);
} else {
    $data_keranjang = mysqli_fetch_assoc($query_keranjang);
    $id_keranjang = $data_keranjang['id_keranjang'];
}

// Tambahkan produk ke keranjang_detail
if (isset($_GET['id_pakaian'])) {
    $id_produk = $_GET['id_pakaian'];
    $cek = mysqli_query($koneksi, "SELECT * FROM keranjang_detail WHERE id_keranjang = '$id_keranjang' AND id_produk = '$id_produk'");
    if (mysqli_num_rows($cek) == 0) {
        mysqli_query($koneksi, "INSERT INTO keranjang_detail (id_keranjang, id_produk) VALUES ('$id_keranjang', '$id_produk')");
    }
    header("Location: keranjang.php");
    exit();
}

    // Tampilkan isi keranjang
    $query = "SELECT p.nama_pakaian, p.harga, p.id_pakaian FROM keranjang_detail kd 
    JOIN pakaian p ON kd.id_produk = p.id_pakaian WHERE kd.id_keranjang = '$id_keranjang'";

    $result = mysqli_query($koneksi, $query);

    $total = 0;

    if (!$result) {
        die("Query gagal: " . mysqli_error($koneksi)); // Ini akan memberitahu kesalahan SQL-nya
    }

    // $dataKeranjang = mysqli_fetch_assoc($result);

    echo "<h2>Keranjang Belanja</h2><ul>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li>{$row['nama_pakaian']} - Rp {$row['harga']}</li>";
        $total += $row['harga'];
    }
echo "</ul><p>Total: Rp $total</p>";

echo "<a href='checkout.php?id_keranjang=$id_keranjang'>Checkout</a>";
?>
