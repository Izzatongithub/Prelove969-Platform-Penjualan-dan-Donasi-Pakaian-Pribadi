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
    include "../config.php";
    $id = $_GET['id'];

    $query = "SELECT p.*, k.kategori, u.ukuran, c.kondisi, us.nama AS nama_penjual, p.tgl_upload
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

    $id_penjual = $data['id_user']; // ambil dari produk
    $qRating = mysqli_query($koneksi, "SELECT AVG(rating) AS rata_rata, COUNT(*) AS total FROM reviews WHERE id_penjual = '$id_penjual'");
    $rating = mysqli_fetch_assoc($qRating);

    // Fungsi untuk menampilkan bintang visual
    function tampilkanBintang($rating) {
        $stars = round($rating); // pembulatan ke atas/bawah
        $output = '';
        for ($i = 1; $i <= 5; $i++) {
            $output .= $i <= $stars ? '★' : '☆';
        }
        return $output;
    }

    //waktu upload pakaian
    function waktuUpload($waktu) {
            $sekarang = time(); // waktu saat ini (timestamp)
            $waktuUpload = strtotime($waktu); // ubah waktu dari database ke timestamp
            $selisih = $sekarang - $waktuUpload; // hitung selisih waktu (detik)

            if ($selisih < 60) {
                return 'Baru saja';
            } elseif ($selisih < 3600) {
                $menit = floor($selisih / 60);
                return "$menit menit yang lalu";
            } elseif ($selisih < 86400) {
                $jam = floor($selisih / 3600);
                return "$jam jam yang lalu";
            } elseif ($selisih < 604800) {
                $hari = floor($selisih / 86400);
                return "$hari hari yang lalu";
            } else {
                return date("d M Y", $waktuUpload); // jika lebih dari 7 hari, tampilkan tanggal
            }
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
            <a href="#" class="sale">Sale</a>
            <a href="#" class="donate">Donasi</a>
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
    <?php if (isset($_SESSION['username']) && !empty($_SESSION['username'])): ?>
        <span><h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h3></span>
    <?php endif; ?>


    <!-- Daftar Produk -->
    <!-- Galeri Foto -->
<div class="detail-box">
    <!-- Kolom kiri: gambar utama dan thumbnail -->
    <div class="image-section">
        <!-- Gambar utama -->
        <?php
            // Ambil gambar pertama sebagai default main image
            mysqli_data_seek($fotos, 0);
            $firstImg = mysqli_fetch_assoc($fotos);
        ?>
        <img id="mainImage" src="../upload/<?= $firstImg['path_foto'] ?>" alt="Gambar Utama" class="main-image">

        <!-- Thumbnail di bawah gambar utama -->
        <div class="thumbnail-gallery">
            <?php
                mysqli_data_seek($fotos, 0);
                while ($img = mysqli_fetch_assoc($fotos)) {
                    echo "<img src='../upload/{$img['path_foto']}' class='product-thumbnail' onclick='changeImage(this.src)'>";
                }
            ?>
        </div>
    </div>

    <!-- Kolom kanan: info produk -->
    <div class="detail-info">
        <h2><?= $data['nama_pakaian']; ?></h2>
        <p><?= $data['ukuran'] . " | " . $data['kondisi']; ?></p>
        <p>Rp <?= number_format($data['harga'], 0, ',', '.'); ?></p>
        <p><?= nl2br($data['deskripsi']); ?></p>
        <p>Diunggah <?= waktuUpload($data['tgl_upload']) ?></p>
        <hr>
        <p><strong>Penjual:</strong>
            <a href="profil_penjual.php?id_user=<?= $data['id_user'] ?>">
                <?= htmlspecialchars($data['nama_penjual']) ?>
            </a>
        </p>
        <?php 
            if ($rating && $rating['total'] > 0): ?>
                <div class='rating'>
                    <p>
                        Rating: <span class="rating-stars"><?= tampilkanBintang($rating['rata_rata']) ?></span> 
                        (<?= number_format($rating['rata_rata'], 1) ?>/5)
                        <!-- Rating: <span class="rating-stars"><?= tampilkanBintang($rating['rata_rata']) ?></span> 
                        (<?= number_format($rating['rata_rata'], 1) ?>/5 dari <?= $rating['total'] ?> ulasan) -->
                    </p>
        <?php else: ?>
                <p>☆☆☆☆☆</p>
        <?php endif; ?>
                <div class="detail-buttons">
                    <a href="profil_penjual.php?id_user=<?= $data['id_user'] ?>" class='btn'>Lihat profile</a>
                    <!-- <a href="profil_saya.php" class='btn'>Massage</a> -->
                </div>
                <div class="detail-buttons">
                    <?php if (isset($_SESSION['id_user'])): ?>
                        <hr><br>
                        <!-- <br><a href="checkout.php?id_pakaian=<?= $data['id_pakaian'] ?>" class="btn">Beli Sekarang</a> -->
                        <a href="keranjang.php?id_pakaian=<?= $data['id_pakaian'] ?>" class="btn">Keranjang</a>
                    <?php else: ?>
                        <p><em>Silakan login untuk membeli atau menambahkan ke keranjang.</em></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</section>
</body>
    <script>
        function changeImage(src) {
            document.getElementById("mainImage").src = src;
        }
    </script>
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
