<?php
include '../config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "UPDATE donasi SET status_donasi = 'Terverifikasi' WHERE id_donasi = '$id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Donasi telah diverifikasi.')</script>";
        header("location: ../staff/donasi_masuk.php");
    } else {
        echo "Gagal verifikasi: " . mysqli_error($koneksi);
    }
} else {
    echo "ID donasi tidak ditemukan.";
}
?>
