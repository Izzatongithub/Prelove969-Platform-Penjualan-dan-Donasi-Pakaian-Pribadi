<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preloved Shop</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../frontend/style1_baru.css">
    <script src="../frontend/script.js" defer></script>
</head>

<?php
    include "../config.php";
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: index.php?page=login");
    }

    $id_user = $_SESSION['id_user'];

    // Ambil data user
    $query_user = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
    $data_user = mysqli_fetch_assoc($query_user);

    // Ambil daftar pakaian yang diunggah user
    $query_produk = mysqli_query($koneksi, "SELECT p.*, f.path_foto FROM pakaian p
            LEFT JOIN (SELECT * FROM foto_produk WHERE urutan = 1) f ON p.id_pakaian = f.id_pakaian WHERE p.id_user = '$id_user'");

    $qRating = mysqli_query($koneksi, "SELECT AVG(rating) AS rata_rata, COUNT(*) AS total FROM reviews WHERE id_penjual = '$id_user'");
    $rating = mysqli_fetch_assoc($qRating);

    // Fungsi tampilkan foto profil
    function tampilkanFotoProfil($foto_profil, $path = '../upload/profil/', $default = 'default.jpg', $width = 150, $height = 150) {
        $foto = (!empty($foto_profil) && file_exists($path . $foto_profil)) ? $foto_profil : $default;
        echo "<img src=\"{$path}{$foto}\" alt=\"Foto Profil\" style=\"width:{$width}px; height:{$height}px; border-radius:50%; object-fit:cover;\">";
    }
?>

<body>
    <!-- Navbar -->
    <header>
        <div class="header-top">
            <div class="logo">
                <a href='index_user.php'>
                    <i class="fas fa-heart me-2"></i>Prelove969</a>
            </div>
            <input type="text" id="search" class="search" placeholder="Cari pakaian...">
        </div>
        <nav class="navbar">
            <!-- <a href="?gender=wanita">Wanita</a>
            <a href="?gender=pria">Pria</a>
            <a href="?gender=unisex">Unisex</a>
            <a href="#">Anak</a>
            <a href="#" class="sale">Sale</a> -->
            <a href="jual_pakaian.php">Jual</a>
            <a href="keranjang.php">Keranjang</a>
            <a href="pesananku.php">Pesanan saya</a>
            <a href="pesanan_masuk.php">Pesanan masuk</a>
            <a href="profil_saya.php">Profil saya</a>
            <a href="wishlist.php">Wishlist</a>
            <a href="form_donasi.php" class="donate">Donasi</a>
        </nav>
        <!-- <div class="main-links">
        </div> -->
        <!-- <span> <?php echo"<h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Welcome, " . $_SESSION['username'] . "</h3>"; ?></span> -->
    </header>
</section>

    <div class="profile-container">
        <div class="profile-header">
            <?php tampilkanFotoProfil($data_user['ava']); ?>
                <div class="profile-info">
                    <h2>Profil Saya</h2>
                    <p><strong class="label">Nama</strong>: <?= $data_user['nama'] ?></p>
                    <p><strong class="label">Email</strong>: <?= $data_user['email'] ?></p>
                    <p><strong class="label">No HP</strong>: <?= $data_user['no_telp'] ?></p>
                    <p><strong class="label">Alamat</strong>: <?= $data_user['alamat'] ?></p>
                    <?php
                        echo "<p><strong class='label'>Rating</strong>: " . number_format($rating['rata_rata'], 1) . " / 5</p>";
                        echo "<p><strong class='label'>Total Ulasan</strong>: " . $rating['total'] . "</p>";
                    ?>
                    <div style="display: flex; gap: 10px;">
                        <a href="edit_profil.php" class="btn">Edit profile</a> 
                        <a href="#" id="registerBtn" class="btn">Logout</a>
                    </div>
                </div>
        </div>
        <div class="uploaded-products-container">
            <h3>Produk yang Diunggah</h3><br>
            <div class="uploaded-products-grid">
                <?php if (mysqli_num_rows($query_produk) > 0) { ?>
                    <?php while ($pakaian = mysqli_fetch_assoc($query_produk)) { ?>
                        <div class="product-card">
                            <img src="../uploads/<?= $pakaian['path_foto'] ?>" width="100"><br>
                            <strong><?= $pakaian['nama_pakaian'] ?></strong><br>
                            Harga: Rp<?= number_format($pakaian['harga'], 0, ',', '.') ?><br><br>
                            <a href="edit_produk.php?id=<?= $pakaian['id_pakaian'] ?>" class="btn">Edit</a>
                            <a href="delete_produk.php?id_pakaian=<?= $pakaian['id_pakaian'] ?>" onclick="return confirm('Yakin?')" class="btn">Hapus</a>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p style=" color: #888; font-style: italic;">Belum ada produk yang diunggah.</p>
                <?php } ?>
            </div>  
        </div>
    </div>
</body>

<!-- <footer>
    <div class="footer-container">
        <div class="footer-about">
            <h3>Tentang Kami</h3>
            <p>Website ini adalah platform preloved yang membantu pengguna menjual dan mendonasikan pakaian bekas yang masih layak pakai.</p>
        </div>
        <div class="footer-links">
            <h3>Tautan Cepat</h3>
            <ul>
                <li><a href="#">Beranda</a></li>
                <li><a href="#">Produk</a></li>
                <li><a href="#">Donasi</a></li>
                <li><a href="#">Kontak</a></li>
            </ul>
        </div>
        <div class="footer-contact">
            <h3>Kontak Kami</h3>
            <p>Email: support@preloved.com</p>
            <p>Telepon: +62 812 3456 7890</p>
            <div class="social-icons">
                <a href="#"><img src="facebook-icon.png" alt="Facebook"></a>
                <a href="#"><img src="instagram-icon.png" alt="Instagram"></a>
                <a href="#"><img src="twitter-icon.png" alt="Twitter"></a>
            </div>
        </div>
    </div>
    <p class="footer-bottom">&copy; 2025 Preloved | Semua Hak Dilindungi</p>
</footer> -->

</html>
