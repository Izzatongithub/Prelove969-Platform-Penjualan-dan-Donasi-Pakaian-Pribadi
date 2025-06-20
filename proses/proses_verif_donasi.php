<?php
include '../config.php';
session_start();

// Cek apakah user adalah admin
if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'admin') {
    header("Location: ../user/login.php");
    exit;
}

// Handle GET requests (verifikasi langsung)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];
    $action = $_GET['action'];

    if ($action === 'verifikasi') {
        $query = "UPDATE donasi SET status_donasi = 'Terverifikasi', tanggal_verifikasi = NOW() WHERE id_donasi = '$id'";
        if (mysqli_query($koneksi, $query)) {
            $_SESSION['success'] = "Donasi berhasil diverifikasi.";
        } else {
            $_SESSION['error'] = "Gagal memverifikasi donasi: " . mysqli_error($koneksi);
        }
    }

    header("Location: ../staff/pages/donasi.php");
    exit;
}

// Handle POST requests (tolak, proses, selesai)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $action = $_POST['action'];

    switch ($action) {
        case 'tolak':
            $alasan = mysqli_real_escape_string($koneksi, $_POST['alasan']);
            $query = "UPDATE donasi SET 
                status_donasi = 'Ditolak',
                alasan_penolakan = '$alasan',
                tanggal_update = NOW()
                WHERE id_donasi = '$id'";
            break;

        case 'proses':
            $catatan = mysqli_real_escape_string($koneksi, $_POST['catatan']);
            $query = "UPDATE donasi SET 
                status_donasi = 'Dalam Proses',
                catatan_proses = '$catatan',
                tanggal_proses = NOW()
                WHERE id_donasi = '$id'";
            break;

        case 'selesai':
            $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
            $query = "UPDATE donasi SET 
                status_donasi = 'Selesai',
                keterangan_selesai = '$keterangan',
                tanggal_selesai = NOW()
                WHERE id_donasi = '$id'";
            break;

        default:
            $_SESSION['error'] = "Aksi tidak valid.";
            header("Location: ../staff/donasi.php");
            exit;
    }

    if (mysqli_query($koneksi, $query)) {
        $_SESSION['success'] = "Status donasi berhasil diperbarui.";
    } else {
        $_SESSION['error'] = "Gagal memperbarui status donasi: " . mysqli_error($koneksi);
    }

    header("Location: ../staff/donasi.php");
    exit;
}
?>
