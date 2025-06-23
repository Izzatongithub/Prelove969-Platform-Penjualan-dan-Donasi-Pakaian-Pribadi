<?php
session_start();
include '../config.php';

// Fungsi tampilkan foto profil
function tampilkanFotoProfil($foto_profil, $path = '../uploads/profil/', $default = 'default.jpg', $width = 150, $height = 150) {
    $foto = (!empty($foto_profil) && file_exists($path . $foto_profil)) ? $foto_profil : $default;
    echo "<img src=\"{$path}{$foto}\" alt=\"Foto Profil\" style=\"width:{$width}px; height:{$height}px; border-radius:50%; object-fit:cover;\">";
}

// Ambil data user dari session
$id_user = $_SESSION['id_user'];
$q = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
$data_user = mysqli_fetch_assoc($q);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Saya</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- font style -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../frontend/style1_baru.css">
</head>
<body>
        <header>
        <div class="header-top">
            <div class="logo">
                <a href='index_user.php'>
                    <i class="fas fa-heart me-2"></i>Prelove969</a>
            </div>
            <input type="text" id="search" class="search" placeholder="Cari pakaian...">
        </div>
        <nav class="navbar">
            <!-- <a href="#">Anak</a> -->
            <a href="form_donasi.php" class="donate">
                <i class="fa-solid fa-hand-holding-heart fa-2x"></i>
            </a>
            <a href="wishlist.php">
                <i class="fa-regular fa-heart fa-2x"></i>
            </a>
            <a href="keranjang.php">
                &nbsp;<i class="fa-solid fa-bag-shopping fa-2x"></i>
            </a>
            <a href='profil_saya.php'>
                &nbsp;<i class="fa-regular fa-circle-user fa-2x"></i></a>
                <!-- <a href="logout.php" class='btn-primary'>Logout</a>   -->
            </nav>
        </header>
        <div class="main-links">
            <a href="jual_pakaian.php">Jual</a>
            <a href="pesananku.php">Pesanan saya</a>
            <a href="pesanan_masuk.php">Pesanan masuk</a>
            <a href="riwayat_donasi.php">Riwayat Donasi</a>
            <!-- <a href="keranjang.php">Keranjang</a> -->
            <!-- <a href="profil_saya.php">Profil saya</a> -->
            <!-- <a href="wishlist.php">Wishlist</a> -->
            <!-- <a href="?gender=wanita">Wanita</a>
            <a href="?gender=pria">Pria</a>
            <a href="?gender=unisex">Unisex</a> -->
    </div>

    <div class="profile-container">
        <div class="profile-header">
            <?php tampilkanFotoProfil($data_user['ava']); ?>
            <div class="profile-info">
                <h2>Profil Saya</h2>
                <p><strong>Nama:</strong> <?= htmlspecialchars($data_user['nama']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($data_user['email']) ?></p>
                <p><strong>No HP:</strong> <?= htmlspecialchars($data_user['no_telp']) ?></p>
                <p><strong>Alamat:</strong> <?= htmlspecialchars($data_user['alamat']) ?></p>
            </div>
        </div>

        <h3>Edit Profil</h3>
        <form action="../proses/proses_edit_profil.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_user" value="<?= $id_user ?>">
            <div class="profile-form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($data_user['nama']) ?>" required>
            </div>
            <div class="profile-form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($data_user['email']) ?>" required>
            </div>
            <div class="profile-form-group">
                <label for="alamat">Alamat</label>
                <textarea id="alamat" name="alamat"><?= htmlspecialchars($data_user['alamat']) ?></textarea>
            </div>
            <div class="profile-form-group">
                <label for="no_hp">No. HP</label>
                <input type="text" id="no_hp" name="no_telp" value="<?= htmlspecialchars($data_user['no_telp']) ?>">
            </div>
            <div class="profile-form-group">
                <label for="fileInput">Ganti Foto Profil:</label>
                <input type="file" name="ava" accept="image/*" class="input-file" id="fileInput"><br>
            </div>

            <button type="submit" class="btn-save-profile">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
