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
    $query = "SELECT p.id_pakaian, p.nama_pakaian, p.harga, f.path_foto FROM keranjang_detail kd
    JOIN pakaian p ON kd.id_produk = p.id_pakaian LEFT JOIN (SELECT id_pakaian, MIN(path_foto) AS path_foto FROM foto_produk
    GROUP BY id_pakaian) f ON p.id_pakaian = f.id_pakaian
    WHERE kd.id_keranjang = '$id_keranjang'";

    $result = mysqli_query($koneksi, $query);

    $total = 0;

    if (!$result) {
        die("Query gagal: " . mysqli_error($koneksi)); // Ini akan memberitahu kesalahan SQL-nya
    }

    // $dataKeranjang = mysqli_fetch_assoc($result);

    echo "<h2>Keranjang Belanja</h2>";
    echo "<div style='display: flex; flex-direction: column; gap: 20px;'>";

    while ($row = mysqli_fetch_assoc($result)) {
        $total += $row['harga'];
        echo "<div style='border:1px solid #ccc; padding:10px; display:flex; align-items:center; gap:15px'>";
        echo "<img src='../upload/{$row['path_foto']}' width='100' height='100' style='object-fit:cover;border-radius:5px'>";
        echo "<div>";
        echo "<h4 style='margin:0'>{$row['nama_pakaian']}</h4>";
        echo "<p style='margin:0'>Rp " . number_format($row['harga'], 0, ',', '.') . "</p>";
        echo "<a href='hapus_keranjang.php?id_produk={$row['id_pakaian']}' style='color:red'>Hapus</a>";
        echo "</div></div>";
    }
        echo "</div>";
        echo "<hr><h3>Total: Rp " . number_format($total, 0, ',', '.') . "</h3>";
        echo "<a href='checkout.php?id_keranjang=$id_keranjang' class='btn'>Checkout</a>";
?>
