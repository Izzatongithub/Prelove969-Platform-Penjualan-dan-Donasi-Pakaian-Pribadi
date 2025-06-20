<?php
include '../config.php';

$username = $_POST['username'];
$nama = $_POST['name'];
$email = $_POST['email'];
$password = md5($_POST['password']);
$alamat = $_POST['address'];
$no_telp = $_POST['phone'];

$cek = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' OR email='$email'");
if(mysqli_num_rows($cek) > 0){
    echo "<script>alert('Username atau email sudah terdaftar!'); window.location='register.php?error=exists';</script>";
    exit;
}

$query = mysqli_query($koneksi, "INSERT INTO user (username, nama, email, password, alamat, no_telp) VALUES ('$username', '$nama', '$email', '$password', '$alamat', '$no_telp')");
if($query){
    echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='login.php';</script>";
} else {
    echo "<script>alert('Registrasi gagal!'); window.location='register.php?error=gagal';</script>";
}
?>