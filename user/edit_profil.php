<?php
session_start();
include '../config.php';

$id_user = $_SESSION['id_user'];
$user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));
?>

<h2>Edit Profil</h2>
<form action="../proses/update_profil.php" method="post">
    <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
    Nama: <input type="text" name="nama" value="<?= $user['nama'] ?>"><br>
    Email: <input type="email" name="email" value="<?= $user['email'] ?>"><br>
    no telp: <input type="number" name="no_telp" value="<?= $user['no_telp'] ?>"><br>
    alamat: <input type="text" name="alamat" value="<?= $user['alamat'] ?>"><br>
    <button type="submit">Simpan</button>
</form>
