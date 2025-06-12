<?php
include '../config.php';

$id_user = $_POST['id_user'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$no_telp = $_POST['no_telp'];
$alamat = $_POST['alamat'];

// Handle foto profil
$foto_profil = '';
if ($_FILES['ava']['name'] != '') {
    $nama_file = $_FILES['ava']['name'];
    $tmp = $_FILES['ava']['tmp_name'];
    $ext = pathinfo($nama_file, PATHINFO_EXTENSION);
    $nama_baru = "profil_" . time() . "." . $ext;
    move_uploaded_file($tmp, "../upload/profil/" . $nama_baru);
    $foto_profil = ", ava = '$nama_baru'";
}

$query = "UPDATE user SET 
    nama = '$nama',
    email = '$email',
    no_telp = '$no_telp',
    alamat = '$alamat'
    $foto_profil
    WHERE id_user = '$id_user'";

if (mysqli_query($koneksi, $query)) {
    header("Location: ../user/profil_saya.php");
} else {
    echo "Gagal update profil: " . mysqli_error($koneksi);
}
