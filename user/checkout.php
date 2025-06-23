<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preloved Shop</title>
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- font style -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../frontend/style1_baru.css">
    <script src="../frontend/script.js" defer></script>
    <!-- <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"> -->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<?php
    session_start();
    include '../config.php'; // koneksi ke database

    // Cek apakah user sudah login
    if (!isset($_SESSION['id_user'])) {
        header("Location: login.php");
        exit();
    }

    $id_user = $_SESSION['id_user'];
    $total = 0;
    $items = [];

    if (isset($_GET['id_pakaian'])) {
    // ✅ Checkout langsung
        $id_pakaian = $_GET['id_pakaian'];
        $query = mysqli_query($koneksi, "SELECT p.id_pakaian, p.nama_pakaian, p.harga, f.path_foto FROM pakaian p
            LEFT JOIN (
                SELECT id_pakaian, MIN(path_foto) AS path_foto FROM foto_produk GROUP BY id_pakaian
            ) f ON p.id_pakaian = f.id_pakaian
            WHERE p.id_pakaian = '$id_pakaian'");
    } else {
        // ✅ Checkout dari keranjang
        $query = mysqli_query($koneksi, "SELECT p.id_pakaian, p.nama_pakaian, p.harga, f.path_foto FROM keranjang k
            JOIN keranjang_detail kd ON k.id_keranjang = kd.id_keranjang
            JOIN pakaian p ON kd.id_produk = p.id_pakaian
            LEFT JOIN (
                SELECT id_pakaian, MIN(path_foto) AS path_foto FROM foto_produk GROUP BY id_pakaian
            ) f ON p.id_pakaian = f.id_pakaian
            WHERE k.id_user = '$id_user'");
    }

    if (!$query || mysqli_num_rows($query) == 0) {
        die("Tidak ada produk untuk di-checkout.");
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
        <?php
            echo "<div class='cart-container'>";
            echo "<h2 class='cart-title'>Checkout</h2>";
            echo "<div class='cart-wrapper'>";

            while ($row = mysqli_fetch_assoc($query)) {
                $total += $row['harga'];
                echo "<div class='cart-item'>";
                echo "<img src='../uploads/" . $row['path_foto'] . "' alt='" . $row['nama_pakaian'] . "'>";
                echo "<div class='cart-info'>";
                echo "<h4>{$row['nama_pakaian']}</h4>";
                echo "<p>Rp " . number_format($row['harga'], 0, ',', '.') . "</p>";
                echo "</div></div>";
            }
        ?>
        <!-- Form Checkout (ditulis di luar PHP) -->
            <form action="../proses/proses_checkout.php" method="POST" class="form-checkout">
                <input type="hidden" name="id_pakaian" value="<?= $id_pakaian ?>">
                <label for="status_transaksi" class="form-label">Pilih metode pembayaran</label>
                <div class="status-flex">
                    <select class="form-select" name="metode_pembayaran" id="metode_pembayaran" required>
                        <option value="">-- Pilih --</option>
                        <option value="cod">Bayar di Tempat (COD)</option>
                        <option value="midtrans">Pembayaran Online (Midtrans)</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary">Checkout</button>
            </form>
        <?php
            echo "</div>"; // close cart-wrapper
            echo "</div>"; // close cart-container
        ?>
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
