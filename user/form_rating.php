<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preloved Shop</title>
    <link rel="stylesheet" href="../frontend/style1_baru.css">
    <script src="../frontend/script.js" defer></script>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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

    $id_transaksi = $_POST['id_transaksi'];
    $id_pembeli = $_SESSION['id_user'];

    // Ambil penjual dari produk yang dibeli
    $q = mysqli_query($koneksi, "SELECT p.id_user AS id_penjual FROM detail_transaksi dt
        JOIN pakaian p ON dt.id_produk = p.id_pakaian
        WHERE dt.id_transaksi = '$id_transaksi' LIMIT 1
    ");
    $data = mysqli_fetch_assoc($q);
    $id_penjual = $data['id_penjual'];

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
            <a href="#" class="sale">Sale</a> -->
            <a href="jual_pakaian.php">Jual</a>
            <a href="keranjang.php">Keranjang</a>
            <a href="pesananku.php">Pesanan saya</a>
            <a href="pesanan_masuk.php">Pesanan masuk</a>
            <a href="profil_saya.php">Profil saya</a>
            <a href="wishlist.php">Wishlist</a>
            <a href="#" class="donate">Donasi</a>
            <a href="#" id="registerBtn" class='btn'>Logout</a>
        </nav>
        <div class="main-links">
        </div>
        <!-- <span><?php echo"<h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Welcome, " . $_SESSION['username'] . "</h3>"; ?></span> -->
    </header>
<?php
    echo "<div class='cart-container'>";
    echo "<h2 class='cart-title'>Review</h2>";
    echo "<div class='cart-wrapper'>";
?>

<form action="../proses/proses_rating.php" method="POST">
    <input type="hidden" name="id_transaksi" value="<?= $id_transaksi ?>">
    <input type="hidden" name="id_penjual" value="<?= $id_penjual ?>">
    <input type="hidden" name="id_pembeli" value="<?= $id_pembeli ?>">

    <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Beri Penilaian (1-5)</label>
            <select class="form-select" aria-label="Default select example" name="rating" id="rating">
                <option value="">Pilih</option>
                    <?php
                        for ($i = 1; $i <= 5; $i++) {
                            echo "<option value='$i'>$i</option>";
                        }
                    ?>
            </select>
    </div>
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Ulasan</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="ulasan" placeholder="Alamat sesuai domisili"></textarea>
    </div>
    <button type="submit" class='btn-primary'>Kirim Rating</button>
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
