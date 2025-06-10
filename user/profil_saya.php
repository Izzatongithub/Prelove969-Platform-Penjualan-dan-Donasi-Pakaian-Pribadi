<?php
session_start();
include '../config.php';

$id_user = $_SESSION['id_user'];

// Ambil data user
$query_user = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
$data_user = mysqli_fetch_assoc($query_user);

// Ambil daftar pakaian yang diunggah user
$query_produk = mysqli_query($koneksi, "
    SELECT p.*, f.path_foto FROM pakaian p
    LEFT JOIN (SELECT * FROM foto_produk WHERE urutan = 1) f 
    ON p.id_pakaian = f.id_pakaian
    WHERE p.id_user = '$id_user'
");
?>

<h2>Profil Saya</h2>
<p><strong>Nama:</strong> <?= $data_user['nama'] ?></p>
<p><strong>Email:</strong> <?= $data_user['email'] ?></p>
<p><strong>No HP:</strong> <?= $data_user['no_telp'] ?></p>
<p><strong>Alamat:</strong> <?= $data_user['alamat'] ?></p>

<a href="edit_profil.php">Edit Profil</a> | <a href="hapus_profil.php">Hapus Akun</a>

<hr>

<h2>Pakaian yang Diunggah</h2>
<?php while ($pakaian = mysqli_fetch_assoc($query_produk)) { ?>
    <div style="border:1px solid #ccc; margin-bottom:10px; padding:10px;">
        <img src="../uploads/<?= $pakaian['path_foto'] ?>" width="100"><br>
        <strong><?= $pakaian['nama_pakaian'] ?></strong><br>
        Harga: Rp<?= number_format($pakaian['harga'], 0, ',', '.') ?><br>
        <a href="edit_produk.php?id=<?= $pakaian['id_pakaian'] ?>">Edit</a> |
        <a href="delete_produk.php?id_pakaian=<?= $pakaian['id_pakaian'] ?>" onclick="return confirm('Yakin?')">Hapus</a>
    </div>
<?php } ?>
