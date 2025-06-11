<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preloved Shop</title>
    <link rel="stylesheet" href="../frontend/style1.css">
    <script src="../frontend/script.js" defer></script>
</head>

<?php
    include "../config.php";
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: index.php?page=login");
    }
?>

<body>
    <!-- Navbar -->
    <header>
        <div class="topbar">
            <div class="logo">PRELOVE969</div>
            <input type="text" id="search" class="search" placeholder="Cari pakaian...">
            <a href="jual_pakaian.php">Jual</a>
            <a href="keranjang.php">keranjang</a>
            <a href="pesananku.php">Pesanan saya</a>
            <a href="pesanan_masuk.php">Pesanan masuk</a>
            <a href="profil_saya.php">Profil saya</a>
            <a href="wishlist.php">Wishlist</a>
        </div>
        <nav class="menu">
            <div class="dropdown">
                <a href="#">Wanita</a>
                <div class="dropdown-menu">
                    <div class="dropdown-column">
                        <h4>Baju</h4>
                        <a href="#">T-shirts</a>
                        <a href="#">Polo shirts</a>
                        <a href="#">Kemeja</a>
                        <a href="#">Sweater</a>
                        <a href="#">Hoodie</a>
                        <a href="#">Jaket</a>
                        <a href="#">Jeans</a>
                        <a href="#">Celana</a>
                        <a href="#">Shorts</a>
                    </div>
                </div>
             </div>
        <div class="dropdown">
            <a href="#">Pria</a>
                <div class="dropdown-menu">
                    <div class="dropdown-column">
                        <h4>Baju</h4>
                            <a href="#">T-shirts</a>
                            <a href="#">Polo shirts</a>
                            <a href="#">Kemeja</a>
                            <a href="#">Sweater</a>
                            <a href="#">Hoodie</a>
                            <a href="#">Jaket</a>
                            <a href="#">Jeans</a>
                            <a href="#">Celana</a>
                            <a href="#">Shorts</a>
                    </div>
                    <div class="dropdown-column">
                        <h4>Baju</h4>
                            <a href="#">T-shirts</a>
                            <a href="#">Polo shirts</a>
                            <a href="#">Kemeja</a>
                            <a href="#">Sweater</a>
                            <a href="#">Hoodie</a>
                            <a href="#">Jaket</a>
                            <a href="#">Jeans</a>
                            <a href="#">Celana</a>
                            <a href="#">Shorts</a>
                    </div>
                </div>
            </div>
                <a href="#">Branded</a>
                <a href="#">Anak</a>
                <a href="#" class="sale">Sale</a>
                <a href="form_donasi.php" class="donate">Donasi</a>
                <!-- <a href="#" id="loginBtn">Login</a> -->
                <a href="../index.php" class="btn">Logout</a>
        </nav>
    </header>
        <span> <?php echo"<h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Welcome, " . $_SESSION['username'] . "</h3>"; ?></span>
    
    <!-- Kategori -->
    <section class="categories">
        <button>Footwear</button>
        <button>Tops</button>
        <button>Bottoms</button>
        <button>Outerwear</button>
        <button>Underwear</button>
        <button>Accessories</button>
    </section>

    <!-- Filter -->
    <section class="filters">
        <select id="category-filter" class="filters-content">
            <option value="">Category</option>
            <option value="tops">Tops</option>
            <option value="bottoms">Bottoms</option>
        </select>
        <select id="size-filter">
            <option value="">Size</option>
            <option value="S">S</option>
            <option value="M">M</option>
        </select>
        <select id="color-filter">
            <option value="">Warna</option>
        </select>
    </section>

    <!-- Daftar Produk -->
    <section class="products">
    <?php
    //     $query = "SELECT p.id_pakaian, p.nama_pakaian, p.deskripsi, p.harga, k.kategori, u.ukuran, c.kondisi, f.path_foto
    // FROM pakaian p
    // LEFT JOIN kategori_pakaian k ON p.id_kategori = k.id_kategori
    // LEFT JOIN ukuran_pakaian u ON p.id_ukuran = u.id_ukuran
    // LEFT JOIN kondisi_pakaian c ON p.id_kondisi = c.id_kondisi
    // LEFT JOIN (
    //     SELECT * FROM foto_produk WHERE urutan = 1
    // ) f ON p.id_pakaian = f.id_pakaian
    // WHERE p.status_ketersediaan = 'tersedia'
    // ORDER BY p.id_pakaian DESC";

    $query = "SELECT p.id_pakaian, p.nama_pakaian, p.deskripsi, p.harga, k.kategori, u.ukuran, c.kondisi, f.path_foto, p.tgl_upload
FROM pakaian p
LEFT JOIN kategori_pakaian k ON p.id_kategori = k.id_kategori
LEFT JOIN ukuran_pakaian u ON p.id_ukuran = u.id_ukuran
LEFT JOIN kondisi_pakaian c ON p.id_kondisi = c.id_kondisi
LEFT JOIN (
    SELECT * FROM foto_produk WHERE urutan = 1
) f ON p.id_pakaian = f.id_pakaian
WHERE p.status_ketersediaan = 'tersedia'
ORDER BY p.id_pakaian DESC";


$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Query error: " . mysqli_error($koneksi)); // Tampilkan penyebab pasti
}

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

            while ($row = mysqli_fetch_assoc($result)) {
                $id_user = $_SESSION['id_user'];
                // Di dalam while, sebelum echo tombol
            $id_pakaian = $row['id_pakaian'];
            $cek = mysqli_query($koneksi, "SELECT * FROM likes WHERE id_user = '$id_user' AND id_pakaian = '$id_pakaian'");
            $sudah_suka = mysqli_num_rows($cek) > 0;

    echo "<div class='product'>
        <a href='detail_produk.php?id={$row['id_pakaian']}'>
            <img src='{$row['path_foto']}' alt='{$row['nama_pakaian']}' width='200'>
            <h3>{$row['nama_pakaian']}</h3>
            <p><strong>Harga:</strong> Rp " . number_format($row['harga'], 0, ',', '.') . "</p>
            <p><strong>Kategori:</strong> {$row['kategori']}</p>
            <p><strong>Ukuran:</strong> {$row['ukuran']}</p>
            <p><strong>Kondisi:</strong> {$row['kondisi']}</p>
            <p>{$row['deskripsi']}</p>
            <p><em>Diunggah " . waktuUpload($row['tgl_upload']) . "</em></p>
        </a>";
    
    if (isset($_SESSION['id_user'])) {
        echo "<form method='POST' action='../proses/proses_likes.php' style='display:inline;'>";
        echo"<input type='hidden' name='id_pakaian' value='{$row['id_pakaian']}'>";
                if ($sudah_suka){
                    echo"<button type='submit' name='likes' value='batal' style='border:none; background:none; cursor:pointer; font-size:18px;'>
                        💔 Batal Sukai
                    </button>";
                }else{
                    echo"<button type='submit' name='likes' value='suka' style='border:none; background:none; cursor:pointer; font-size:18px;'>
                        ❤️ Sukai
                    </button>";
                }
        echo"</form>";
    }

    $jumlah_suka = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM likes WHERE id_pakaian='$id_pakaian'"));
    echo "<p>Disukai oleh $jumlah_suka orang</p>";


    echo "</div>";
}
?>
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
