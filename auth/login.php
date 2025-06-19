<?php
session_start();
include '../config.php'; // koneksi ke database

$username = $_POST['username'];
$password = md5($_POST['password']);

$query = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' AND password='$password'");


if(mysqli_num_rows($query) > 0){
    $_SESSION['username'] = $username;
    header("Location: ../user/index_user.php");
} else {
    echo "<script>alert('Login gagal!'); window.location='../ui/homepage.php?page=login&error=gagal';</script>";
}

?>
    