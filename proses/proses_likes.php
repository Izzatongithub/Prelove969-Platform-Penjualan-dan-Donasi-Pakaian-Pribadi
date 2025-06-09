<?php
session_start();
include '../config.php';

if (!isset($_SESSION['id_user']) || !isset($_POST['id_pakaian']) || !isset($_POST['likes'])) {
    die("Data tidak lengkap.");
}

$id_user = $_SESSION['id_user'];
$id_pakaian = $_POST['id_pakaian'];
$aksi = $_POST['likes'];


if ($aksi == 'suka') {
    $insert = mysqli_query($koneksi, "INSERT INTO likes (id_user, id_pakaian) VALUES ('$id_user', '$id_pakaian')");
    // mysqli_query($koneksi, $insert) or die(mysqli_error($koneksi));
    if (!$insert) echo "Gagal menyukai: " . mysqli_error($koneksi);
} elseif ($aksi == 'batal') {
    $delete = mysqli_query($koneksi, "DELETE FROM likes WHERE id_user = '$id_user' AND id_pakaian = '$id_pakaian'");
    if (!$delete) echo "Gagal batal suka: " . mysqli_error($koneksi);
}

header("Location: ../user/index_user.php");
exit();
?>
