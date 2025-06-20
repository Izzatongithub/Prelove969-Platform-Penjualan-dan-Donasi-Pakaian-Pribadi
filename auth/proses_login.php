<?php
include '../config.php';

session_start();

$username = $_POST['username'];
$password = md5($_POST['password']);

// $_SESSION['username'] = $username;
$sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
$result = mysqli_query($koneksi, $sql);

$cek = mysqli_num_rows($result);
// var_dump($cek);exit;

if ($cek > 0) {
    $data = mysqli_fetch_assoc($result);
    $_SESSION['id_user'] = $data['id_user']; 
    $_SESSION['username'] = $data['username'];
    header("location: ../user/index_user.php");
}else{
   echo "<script>alert('Login gagal!'); window.location='login.php?error=gagal';</script>";
}

?>