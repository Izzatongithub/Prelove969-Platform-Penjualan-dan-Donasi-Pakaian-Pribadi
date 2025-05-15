<?php
include '../config.php';

session_start();

$username = $_POST['username'];
$password = $_POST['password'];

// $_SESSION['username'] = $username;

$sql = "SELECT * FROM user where username='$username' AND password='$password'";
$result = mysqli_query($koneksi, $sql);

$cek = mysqli_num_rows($result);

if ($cek > 0) {
    $data = mysqli_fetch_assoc($result);
    $_SESSION['id_user'] = $data['id_user']; 
    $_SESSION['username'] = $data['username'];
    // $_SESSION['username'] = $username;
    header("location: ../user/index_user.php");
}else{
    header("location: ../index.php?error=gagal");
}

?>