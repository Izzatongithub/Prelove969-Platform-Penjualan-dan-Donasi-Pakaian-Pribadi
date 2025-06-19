<?php
session_start();
include '../config.php';

$username = trim($_POST['username']);
$password = md5(trim($_POST['password']));

$query = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' AND password='$password'");
if(mysqli_num_rows($query) > 0){
    $_SESSION['username'] = $username;
    header("Location: ../user/index_user.php");
} else {
    echo "<script>alert('Login gagal!'); window.location='login.php?error=gagal';</script>";
}
?>