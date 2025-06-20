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
    include "../config.php";
    session_start();
    // if (!isset($_SESSION['username'])) {
    //     header("Location: index.php?page=login");
    // }

    $id_user = $_GET['id_user'];

    // Ambil data penjual
    $qUser = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
    $dataUser = mysqli_fetch_assoc($qUser);

    // Ambil pakaian yang diunggah user ini
    $qProduk = mysqli_query($koneksi, "SELECT p.*, f.path_foto FROM pakaian p
        LEFT JOIN (SELECT id_pakaian, MIN(path_foto) AS path_foto FROM foto_produk GROUP BY id_pakaian) f ON p.id_pakaian = f.id_pakaian
        WHERE p.id_user = '$id_user' AND p.status_ketersediaan = 'tersedia'");

    // id_penjual dari $_GET['id_user'] atau $_SESSION['id_user']
    $id_penjual = $_GET['id_user'];
    $qRating = mysqli_query($koneksi, "SELECT AVG(rating) AS rata_rata, COUNT(*) AS total
            FROM reviews WHERE id_penjual = '$id_penjual'");
    $rating = mysqli_fetch_assoc($qRating);

    $qUlasan = mysqli_query($koneksi, "SELECT r.*, u.nama AS nama_pembeli, GROUP_CONCAT(p.nama_pakaian SEPARATOR ', ') AS nama_pakaian 
    FROM reviews r LEFT JOIN user u ON r.id_pembeli = u.id_user
    LEFT JOIN transaksi t ON r.id_transaksi = t.id_transaksi
    LEFT JOIN detail_transaksi dt ON dt.id_transaksi = t.id_transaksi
    LEFT JOIN pakaian p ON dt.id_produk = p.id_pakaian
    WHERE r.id_penjual = '$id_user' GROUP BY r.id_reviews");

    if (!$qUlasan) {
        die("Query error: " . mysqli_error($koneksi));
    }

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
            <a href="form_donasi.php" class="donate">Donasi</a>
            <?php if (isset($_SESSION['username']) && !empty($_SESSION['username'])): ?>
                <a href="logout.php" class="btn">Logout</a>
            <?php endif; ?>
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
    <!-- <span> <?php echo"<h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Welcome, " . $_SESSION['username'] . "</h3>"; ?></span> -->
    <div class="profile-container">
        <div class="profile-header">
            <img src="foto-penjual.jpg" alt="Foto Profil Penjual">
            <div class="profile-info">
                <h3><?= htmlspecialchars($dataUser['nama']) ?></h3>
                <p><?= htmlspecialchars($dataUser['email']) ?></p>
                <?php
                    echo "<p>Rating: " . number_format($rating['rata_rata'], 1) . " / 5</p>";
                    echo "<p>Total Ulasan: " . $rating['total'] . "</p>";
                ?>
            </div>
        </div>

        <div class="uploaded-products-container">
        <h3>Produk yang Diunggah</h3><br>
            <div class="uploaded-products-grid">
                <?php while ($produk = mysqli_fetch_assoc($qProduk)) : ?>
                    <div class="product-card">
                        <a href="detail_produk.php?id=<?= $produk['id_pakaian'] ?>">
                        <img src="../uploads/<?= $produk['path_foto'] ?>" alt="<?= htmlspecialchars($produk['nama_pakaian']) ?>">
                        <h3><?= htmlspecialchars($produk['nama_pakaian']) ?></h3>
                        <p>Rp <?= number_format($produk['harga'], 0, ',', '.') ?></p>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <div class="review-section">
            <h3>Ulasan Pembeli</h3><br>
            <?php if (mysqli_num_rows($qUlasan) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($qUlasan)) : ?>
                    <div class="review-card">
                        <!-- <p><strong>Pembeli  :</strong>  -->
                        
                        <?php
                        if (isset($row['nama_pembeli'])) {
                            echo '<p><strong>Pembeli  :</strong> ' . htmlspecialchars($row['nama_pembeli']) . '</p>';
                        } else {
                            echo '<p><strong>Pembeli  :</strong> Tidak diketahui</p>';
                        }     
                        ?></p>
                        
                        <!-- <p><strong>Barang   :</strong> -->
                        <?php
                        if (isset($row['nama_pakaian'])) {
                            echo '<p><strong>Barang   :</strong> ' . htmlspecialchars($row['nama_pakaian']) . '</p>';
                        } else {
                            echo '<p><strong>Barang   :</strong> Tidak tersedia</p>';
                        }
                        ?></p>
                        <p><strong>Rating   :</strong> <?= $row['rating'] ?>/5</p>
                        <p><strong>Ulasan   :</strong> <?= htmlspecialchars($row['ulasan']) ?></p>      
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Belum ada ulasan untuk penjual ini.</p>
            <?php endif; ?>
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
