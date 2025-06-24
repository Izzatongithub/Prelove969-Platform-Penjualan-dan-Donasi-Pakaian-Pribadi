<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preloved Shop</title>
    <!-- font style -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../frontend/style1_baru.css">
    <script src="../frontend/script.js" defer></script>
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

    // Ambil keranjang user
    $query_keranjang = mysqli_query($koneksi, "SELECT * FROM keranjang WHERE id_user = '$id_user'");
    if (mysqli_num_rows($query_keranjang) == 0) {
        mysqli_query($koneksi, "INSERT INTO keranjang (id_user) VALUES ('$id_user')");
        $id_keranjang = mysqli_insert_id($koneksi);
    } else {
        $data_keranjang = mysqli_fetch_assoc($query_keranjang);
        $id_keranjang = $data_keranjang['id_keranjang'];
    }

    // Tambahkan produk ke keranjang_detail
    if (isset($_GET['id_pakaian'])) {
        $id_produk = $_GET['id_pakaian'];
        $cek = mysqli_query($koneksi, "SELECT * FROM keranjang_detail WHERE id_keranjang = '$id_keranjang' AND id_produk = '$id_produk'");
            if (mysqli_num_rows($cek) == 0) {
                mysqli_query($koneksi, "INSERT INTO keranjang_detail (id_keranjang, id_produk) VALUES ('$id_keranjang', '$id_produk')");
            }
        header("Location: keranjang.php");
        exit();
    }

    // Tampilkan isi keranjang
    $query ="SELECT p.id_pakaian, p.nama_pakaian, p.harga, u.ukuran, f.path_foto FROM keranjang_detail kd
        JOIN pakaian p ON kd.id_produk = p.id_pakaian LEFT JOIN ukuran_pakaian u ON p.id_ukuran = u.id_ukuran
        LEFT JOIN (SELECT id_pakaian, MIN(path_foto) AS path_foto FROM foto_produk GROUP BY id_pakaian) f ON p.id_pakaian = f.id_pakaian
        WHERE kd.id_keranjang = '$id_keranjang'";

        $result = mysqli_query($koneksi, $query);
        $total = 0;

    if (!$result) {
        die("Query gagal: " . mysqli_error($koneksi)); // Ini akan memberitahu kesalahan SQL-nya
    }
    // $dataKeranjang = mysqli_fetch_assoc($result);
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
  
        <!-- <span><?php echo"<h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Welcome, " . $_SESSION['username'] . "</h3>"; ?></span> -->
    <?php
        echo "<div class='cart-container'>";
        echo "<h2 class='cart-title'>Keranjang</h2>";
        echo "<div class='cart-wrapper'>";
            while ($row = mysqli_fetch_assoc($result)) {
                $total += $row['harga'];
                echo "<div class='cart-item'>";
                echo "<img src='../upload/{$row['path_foto']}' alt='{$row['nama_pakaian']}'>";
                echo "<div class='cart-info'>";
                echo "<h4>{$row['nama_pakaian']}</h4>";
                echo "<p> {$row['ukuran']}</p>";
                echo "<p>Rp " . number_format($row['harga'], 0, ',', '.') . "</p>";
                // echo "<a href='hapus_keranjang.php?id_produk={$row['id_pakaian']}' class='btn' style='display: inline;' 
                // onsubmit=\"return confirm('Yakin ingin menghapus produk ini dari keranjang?')\">Hapus</a>";
                echo "<form method='POST' action='hapus_keranjang.php?id_produk={$row['id_pakaian']}' style='display: inline;' onsubmit=\"return confirm('Yakin ingin menghapus produk ini dari keranjang?')\">
                        <input type='hidden' name='id_produk' value='{$row['id_pakaian']}'>
                        <button type='submit' class='btn'>Hapus</button>
                    </form>";
                echo "</div></div>";
            }
        echo "</div>";
        echo "<div class='cart-total'>";
        echo "<hr><br>";
            echo "<h3>Total: Rp " . number_format($total, 0, ',', '.') . "</h3>";
            echo "<a href='checkout.php?id_keranjang=$id_keranjang' class='btn'>Checkout</a>";
        echo "</div>";
        echo "</div>";
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
