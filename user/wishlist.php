<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preloved Shop</title>
    <link rel="stylesheet" href="../frontend/style1_baru.css">
    <script src="../frontend/script.js" defer></script>
</head>
<?php
    session_start();
    include '../config.php'; // koneksi ke database
    $id_user = $_SESSION['id_user'];


    // Cek apakah user sudah login
    if (!isset($_SESSION['id_user'])) {
        header("Location: login.php");
        exit();
    }

    $query = "SELECT p.id_pakaian, p.nama_pakaian, p.harga, u.ukuran AS ukuran,  f.path_foto
            FROM likes l
            JOIN pakaian p ON l.id_pakaian = p.id_pakaian
            LEFT JOIN ukuran_pakaian u ON p.id_ukuran = u.id_ukuran
            LEFT JOIN (
                SELECT * FROM foto_produk WHERE urutan = 1
            ) f ON p.id_pakaian = f.id_pakaian
            WHERE l.id_user = '$id_user'AND p.status_ketersediaan = 'tersedia'";


    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        die("Query Error: " . mysqli_error($koneksi));
    }

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
            <a href="form_donasi.php" class="donate">Donasi</a>
            <a href="#" id="registerBtn" class='btn'>Logout</a>
        </nav>
        <div class="main-links">
        </div>
    <!-- <span><?php echo"<h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Welcome, " . $_SESSION['username'] . "</h3>"; ?></span> -->
    </header>
    <?php
echo "<div class='cart-container'>";
echo "<h2 class='cart-title'>Wishlist Saya</h2>";
echo "<div class='cart-wrapper'>";

$total = 0;

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $total += $row['harga'];

        echo "<div class='cart-item'>";
        echo "<img src='../uploads/{$row['path_foto']}' alt='{$row['nama_pakaian']}'>";
        echo "<div class='cart-info'>";
        echo "<h4>{$row['nama_pakaian']}</h4>";
        echo "<p>Ukuran: {$row['ukuran']}</p>";
        echo "<p>Rp " . number_format($row['harga'], 0, ',', '.') . "</p>";

        // Tombol Hapus dari wishlist
        echo "<form method='POST' action='../proses/proses_hapus_wishlist.php'>";
        echo "<input type='hidden' name='id_pakaian' value='{$row['id_pakaian']}'>";
        echo "<input type='hidden' name='likes' value='batal'>";
        echo "<button type='submit' class='btn'>Hapus</button>";
        echo "</form>";

        echo "</div></div>"; // close cart-info & cart-item
    }

    echo "</div>"; // close cart-wrapper

} else {
    echo "<p class='empty-msg'>Belum ada produk di wishlist Anda.</p>";
    echo "</div>"; // close cart-wrapper
}

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
