<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preloved Shop</title>
    <link rel="stylesheet" href="../frontend/style1_baru.css">
    <script src="../frontend/script.js" defer></script>
     <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
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

    $id_penjual = $_SESSION['id_user']; // login sebagai penjual
    $query = mysqli_query($koneksi, "SELECT t.id_transaksi, t.kode_invoice, t.status_transaksi, t.tgl_transaksi, 
        p.nama_pakaian, p.harga, u.nama AS nama_pembeli, f.path_foto FROM transaksi t
        JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
        JOIN pakaian p ON dt.id_produk = p.id_pakaian
        JOIN user u ON t.id_user = u.id_user
        LEFT JOIN (
            SELECT id_pakaian, MIN(path_foto) AS path_foto 
            FROM foto_produk GROUP BY id_pakaian
        ) f ON p.id_pakaian = f.id_pakaian
        WHERE p.id_user = '$id_penjual'
        ORDER BY t.tgl_transaksi DESC");

    if (!$query) {
        die("Query gagal: " . mysqli_error($koneksi));
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
            <a href="#" class="donate">Donasi</a>
            <a href="#" id="registerBtn" class='btn'>Logout</a>
        </nav>
        <div class="main-links">
        </div>
        <!-- <span><?php echo"<h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Welcome, " . $_SESSION['username'] . "</h3>"; ?></span> -->
    </header>

        <div class='cart-container'>
        <h2 class='cart-title'>Pesanan Masuk</h2>
        <div class='cart-wrapper'>
        <?php if (mysqli_num_rows($query) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($query)): ?>
                <div class='cart-item'>
                    <img src="../uploads/<?= $row['path_foto']; ?>" alt="Foto">
                    <div class='cart-info'>
                        <p><strong>Invoice:</strong> <?= $row['kode_invoice']; ?></p>
                        <p><strong>Pembeli:</strong> <?= $row['nama_pembeli']; ?></p>
                        <p><strong>Produk:</strong> <?= $row['nama_pakaian']; ?></p>
                        <p><strong>Harga:</strong> Rp<?= number_format($row['harga'], 0, ',', '.'); ?></p>
                        <p><strong>Status:</strong> <?= ucfirst($row['status_transaksi']); ?></p>

                        <?php
                            $current_status = $row['status_transaksi'];
                            $next_status_options = [];

                            switch ($current_status) {
                                case 'menunggu':
                                    $next_status_options = ['diproses'];
                                    break;
                                case 'diproses':
                                    $next_status_options = ['dikirim'];
                                    break;
                                case 'dikirim':
                                    echo "<p><em>Pesanan sedang dikirim ke pembeli.</em></p>";
                                    break;
                                case 'selesai':
                                    echo "<p><em>Pesanan telah selesai.</em></p>";
                                    break;
                            }
                        ?>

                        <?php if (!empty($next_status_options)): ?>
                            <form method="POST" action="../proses/proses_pesanan.php">
                                <input type="hidden" name="id_transaksi" value="<?= $row['id_transaksi']; ?>">
                                <p><em>Pesanan sedang <?= $row['status_transaksi']; ?></em></p><br>
                                <label for="status_transaksi" class="form-label">Update status</label>
                                <div class="status-flex">
                                    <select class="form-select" name="status_transaksi" required>
                                        <option value="">Pilih status</option>
                                        <?php foreach ($next_status_options as $status): ?>
                                            <option value="<?= $status ?>"><?= ucfirst($status) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn-primary">Update Status</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
                <?php else: ?>
                    <p class="empty-msg">Belum ada pesanan masuk.</p>
                <?php endif; ?>
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
