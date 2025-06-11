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
    include "../config.php";
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: index.php?page=login");
    }

    $id_user = $_SESSION['id_user'];

    // Ambil transaksi milik user
    $query = "SELECT t.id_transaksi, t.kode_invoice, t.tgl_transaksi, t.status_transaksi,
        p.nama_pakaian, p.harga, f.path_foto,
        u.id_user AS id_penjual, u.nama AS nama_penjual
    FROM transaksi t
    JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
    JOIN pakaian p ON dt.id_produk = p.id_pakaian
    LEFT JOIN (
        SELECT * FROM foto_produk WHERE urutan = 1
    ) f ON p.id_pakaian = f.id_pakaian
    JOIN user u ON p.id_user = u.id_user
    WHERE t.id_user = '$id_user'
    ORDER BY t.tgl_transaksi DESC";

    $result = mysqli_query($koneksi, $query);

?>

<body>
    <!-- Navbar -->
    <header>
        <div class="header-top">
            <div class="logo">PRELOVE969</div>
            <input type="text" id="search" class="search" placeholder="Cari pakaian...">
        </div>
        <nav class="navbar">
            <a href="?gender=wanita">Wanita</a>
            <a href="?gender=pria">Pria</a>
            <a href="?gender=unisex">Unisex</a>
            <!-- <a href="#">Anak</a> -->
            <a href="#" class="sale">Sale</a>
            <a href="#" class="donate">Donasi</a>
            <a href="#" id="registerBtn" class='btn'>Logout</a>
            
        </nav>
    </header>
    <div class="main-links">
        <a href="jual_pakaian.php">Jual</a>
        <a href="keranjang.php">Keranjang</a>
        <a href="pesananku.php">Pesanan saya</a>
        <a href="pesanan_masuk.php">Pesanan masuk</a>
        <a href="profil_saya.php">Profil saya</a>
        <a href="wishlist.php">Wishlist</a>
    </div>
    <span> <?php echo"<h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Welcome, " . $_SESSION['username'] . "</h3>"; ?></span>
</section>

    <div class="profile-container">
    <div class="profile-header">
        <img src="foto-penjual.jpg" alt="Foto Profil Penjual">
        <div class="profile-info">
        <!-- <h3><?= htmlspecialchars($dataUser['nama']) ?></h3>
        <p><?= htmlspecialchars($dataUser['email']) ?></p> -->
        <!-- <?php
            echo "<p>Rating: " . number_format($rating['rata_rata'], 1) . " / 5</p>";
            echo "<p>Total Ulasan: " . $rating['total'] . "</p>";
        ?> -->
        </div>
    </div>

    <div class="uploaded-products-container">
        <h1>Pesanan Saya</h1>
            <div class="pesanan-container">
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div style="border:1px solid #ccc; padding:10px; margin:10px;">
                <img src="<?= $row['path_foto']; ?>" width="100" height="100" style="object-fit:cover;"><br>
                <strong>Invoice:</strong> <?= $row['kode_invoice']; ?><br>
                <strong>Produk:</strong> <?= $row['nama_pakaian']; ?><br>
                <strong>Harga:</strong> Rp<?= number_format($row['harga'], 0, ',', '.'); ?><br>
                <strong>Tanggal:</strong> <?= $row['tgl_transaksi']; ?><br>
                <p><strong>Penjual:</strong> 
            <a href="profil_penjual.php?id_user=<?= $row['id_penjual'] ?>">
                <?= htmlspecialchars($row['nama_penjual']) ?>
            </a>
            </p>
        <strong>Status:</strong> <?= ucfirst($row['status_transaksi']); ?><br>
        <?php if ($row['status_transaksi'] === 'dikirim') { ?>
            <form method="POST" action="form_rating.php">
                <input type="hidden" name="id_transaksi" value="<?= $row['id_transaksi']; ?>">
                <button type="submit">Konfirmasi dan Beri Rating</button>
            </form>
        <?php } ?>
    </div>
<?php } ?>
    </div>
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

</html>