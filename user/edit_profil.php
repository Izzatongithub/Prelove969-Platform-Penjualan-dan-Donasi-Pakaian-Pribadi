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
    <link rel="stylesheet" href="../frontend/style1_baru.css">
     <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
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

        <hr><br>

        <h3>Edit Profil</h3>
        <form action="../proses/proses_edit_profil.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_user" value="<?= $data_user['id_user'] ?>">

            <label>Nama:</label><br>
            <input type="text" name="nama" value="<?= htmlspecialchars($data_user['nama']) ?>" required><br><br>

            <label>Email:</label><br>
            <input type="email" name="email" value="<?= htmlspecialchars($data_user['email']) ?>" required><br><br>

            <label>No Telepon:</label><br>
            <input type="text" name="no_telp" value="<?= htmlspecialchars($data_user['no_telp']) ?>" required><br><br>

            <label>Alamat:</label><br>
            <textarea name="alamat" rows="3" required><?= htmlspecialchars($data_user['alamat']) ?></textarea><br><br>

            <label>Ganti Foto Profil:</label><br>
            <input type="file" name="ava" accept="image/*"><br><br>

            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
