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
    include "../config.php";
    $id = $_GET['id'];

    $query = "SELECT p.*, k.kategori, u.ukuran, c.kondisi, us.nama AS nama_penjual
        FROM pakaian p
        LEFT JOIN kategori_pakaian k ON p.id_kategori = k.id_kategori
        LEFT JOIN ukuran_pakaian u ON p.id_ukuran = u.id_ukuran
        LEFT JOIN kondisi_pakaian c ON p.id_kondisi = c.id_kondisi
        LEFT JOIN user us ON p.id_user = us.id_user
        WHERE p.id_pakaian = $id";


    $data = mysqli_fetch_assoc(mysqli_query($koneksi, $query));

    // Ambil semua foto produk
    $fotos = mysqli_query($koneksi, "SELECT * FROM foto_produk WHERE id_pakaian = $id ORDER BY urutan ASC");

    // Ambil semua data ke dalam array
    $all_fotos = [];
    while ($foto = mysqli_fetch_assoc($fotos)) {
        $all_fotos[] = $foto;
    }

    // Ambil gambar pertama sebagai gambar utama
    $gambar_utama = $all_fotos[0]['path_foto'];
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
    <span><?php echo"<h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Welcome, " . $_SESSION['username'] . "</h3>"; ?></span>

    <!-- Daftar Produk -->
    <div class='cart-container'>
        <div class='cart-item'>
            <?php
                mysqli_data_seek($fotos, 0); // Kembalikan pointer ke awal
                    while ($img = mysqli_fetch_assoc($fotos)) {
                        echo "<img src='{$img['path_foto']}' class='thumbnail' onclick='changeImage(this.src)'>";
                    }
            ?>
                <div class='cart-wrapper'>
                    <h2><?= $data['nama_pakaian']; ?></h2>
                    <p> <?= $data['ukuran'], " | ", $data['kondisi']; ?></p>
                    <p>Rp <?= number_format($data['harga'], 0, ',', '.'); ?>
                    <p><?= nl2br($data['deskripsi']); ?></p>
                    <p><strong>Penjual:</strong> 
                    <a href="profil_penjual.php?id_user=<?= $data['id_user'] ?>"><?= htmlspecialchars($data['nama_penjual']) ?></a>
                </div></p>
            </div>
            <nav>
                <?php 
                    if (isset($_SESSION['id_user'])): ?>
                        <br><a href="checkout.php?id_pakaian=<?= $data['id_pakaian'] ?>" class="btn">+ Beli sekarang</a>
                         <!-- <a href="../proses/proses_checkout.php?id_pakaian=<?= $data['id_pakaian'] ?>" class="btn">+ Beli Sekarang</a> -->
                        <br><a href="keranjang.php?id_pakaian=<?= $data['id_pakaian'] ?>" class="btn">+ Keranjang</a><br><br>
                <?php else: ?>
                    <p><em>Silakan login untuk membeli atau menambahkan ke keranjang.</em></p>
                <?php endif; ?>
            </nav>
        </div>

    <script>
        function changeImage(src) {
            document.getElementById("mainImage").src = src;
        }
    </script>
</section>
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
