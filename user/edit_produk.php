<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preloved Shop</title>
    <link rel="stylesheet" href="../frontend/style1_baru.css">
     <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="../frontend/script.js" defer></script>
</head>

<?php
session_start();
include '../config.php';

$id = $_GET['id'];
$id_user = $_SESSION['id_user'];

$query = mysqli_query($koneksi, "SELECT * FROM pakaian WHERE id_pakaian = '$id' AND id_user = '$id_user'");
$data = mysqli_fetch_assoc($query);
if (!$data) die("Produk tidak ditemukan atau bukan milik Anda.");
?>

<body>
    <!-- Navbar -->
    <header>
        <div class="header-top">
            <div class="logo">
                <a href='index_user.php'>PRELOVE969</a>
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
            <a href="" class="donate">Donasi</a>
            <a href="#" id="registerBtn" class='btn'>Logout</a>
        </nav>
        <div class="main-links">
        </div>
        <!-- <span> <?php echo"<h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Welcome, " . $_SESSION['username'] . "</h3>"; ?></span> -->
    </header>
</section>

    <div class="profile-container">
    <div class="profile-header">
        <h2>Edit Produk</h2>
    </div>

    <div class="uploaded-products-container">
        <form class="form-edit-stacked" action="../proses/update_produk.php" method="post">
            <input type="hidden" name="id_pakaian" value="<?= $data['id_pakaian'] ?>">

            <label>Nama:</label>
            <input type="text" name="nama_pakaian" value="<?= $data['nama_pakaian'] ?>">

            <label>Harga:</label>
            <input type="number" name="harga" value="<?= $data['harga'] ?>">

            <label>Deskripsi:</label>
            <textarea name="deskripsi"><?= $data['deskripsi'] ?></textarea>

            <button type="submit" class="btn">Simpan</button>
        </form>
    </div>

</div>

</body>
<footer>
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
</footer>