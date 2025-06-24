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
</head>
<?php
    session_start();
    include "../config.php";

    $id = $_GET['id'];

    $query = "SELECT p.*, k.kategori, u.ukuran, c.kondisi, us.nama AS nama_penjual, p.tgl_upload
        FROM pakaian p LEFT JOIN kategori_pakaian k ON p.id_kategori = k.id_kategori
        LEFT JOIN ukuran_pakaian u ON p.id_ukuran = u.id_ukuran
        LEFT JOIN kondisi_pakaian c ON p.id_kondisi = c.id_kondisi
        LEFT JOIN user us ON p.id_user = us.id_user WHERE p.id_pakaian = $id";
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
            $output .= $i <= $stars ? '<i class="fa-solid fa-star"></i>' : '<i class="fa-regular fa-star"></i>';
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
            <div class="logo">
                <a href='index_user.php'>
                    <i class="fas fa-heart me-2"></i> Prelove969</a>
            </div>
            <input type="text" id="search" class="search" placeholder="Cari pakaian...">
        </div>
        <nav class="navbar">
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
            </nav>
    </header>
        <div class="main-links">
            <a href="jual_pakaian.php">Jual</a>
            <a href="pesananku.php">Pesanan saya</a>
            <a href="pesanan_masuk.php">Pesanan masuk</a>
            <a href="riwayat_donasi.php">Riwayat Donasi</a>
            
        </div>

    <!-- <?php if (isset($_SESSION['username']) && !empty($_SESSION['username'])): ?>
        <span><h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h3></span>
    <?php endif; ?> -->

<div class="detail-box">
    <div class="image-section">
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
        <p><strong><?= 'Rp ' . number_format($data['harga'], 0, ',', '.') ?></strong></p>
        <p><?= nl2br($data['deskripsi']); ?></p>
        <p>Diunggah <?= waktuUpload($data['tgl_upload']) ?></p>
        <hr>
        <p><strong>Penjual :</strong>
            <a href="profil_penjual.php?id_user=<?= $data['id_user'] ?>" style="color: #d63384;text-decoration: none;">
                <?= htmlspecialchars($data['nama_penjual']) ?>
            </a>
        </p>
        <div class='rating'>
                <span>Rating :</span>
                <span class="rating-stars">
                    <?php 
                        if ($rating && $rating['total'] > 0) {
                            echo tampilkanBintang($rating['rata_rata']);
                        } else {
                            for ($i = 0; $i < 5; $i++) {
                                echo '<i class="fa-regular fa-star"></i>';
                            }
                        }
                    ?>
                </span>
                <span>(<?= $rating && $rating['total'] > 0 ? number_format($rating['rata_rata'], 1) : '0.0' ?>/5)</span>
            </div>
                <!-- <div class="detail-buttons">
                    <a href="profil_penjual.php?id_user=<?= $data['id_user'] ?>" class='btn'>Lihat profile</a>
                    <a href="profil_saya.php" class='btn'>Massage</a>
                </div> -->
                <div class="detail-buttons">
                    <hr>
                    <?php if (isset($_SESSION['id_user'])): ?>
                        <br><a href="checkout.php?id_pakaian=<?= $data['id_pakaian'] ?>" class="btn">Beli Sekarang</a>
                        <a href="keranjang.php?id_pakaian=<?= $data['id_pakaian'] ?>" class="btn">Keranjang</a>
                    <?php else: ?>
                        <p><em><a href="login.php" style="color: #d63384;">Login untuk membeli</a> atau menambahkan ke keranjang.</em></p>
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
</html>
