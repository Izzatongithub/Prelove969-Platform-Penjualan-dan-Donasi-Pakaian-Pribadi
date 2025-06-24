<?php
include '../config.php';
session_start();

$username = $_POST['username'];
$password = md5($_POST['password']);

$sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
$result = mysqli_query($koneksi, $sql);

$cek = mysqli_num_rows($result);

if ($cek > 0) {
    $data = mysqli_fetch_assoc($result);
    $_SESSION['id_user'] = $data['id_user']; 
    $_SESSION['username'] = $data['username'];
    $_SESSION['level'] = $data['level']; // simpan level ke session

    // mditrans
    // $_SESSION['id_user'] = $data['id_user'];
    $_SESSION['nama'] = $data['nama'];
    $_SESSION['email'] = $data['email'];
    $_SESSION['no_telp'] = $data['no_telp'];
    $_SESSION['alamat'] = $data['alamat'];


    // Redirect sesuai level
    if ($data['level'] == 'admin') {
        header("location: ../staff/admin.php");
    } else {
        header("location: ../user/index_user.php");
    }
} else {
   echo "<script>alert('Login gagal!'); window.location='../index.php?error=gagal';</script>";
}
?>