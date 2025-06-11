<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preloved Shop</title>
    <link rel="stylesheet" href="../frontend/style1_baru.css">
    <script src="../frontend/script.js" defer></script>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</head>

<?php
    include "../config.php";
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: index.php?page=login");
    }

    // Ambil semua ukuran dan kategorikan
    $ukuran_pakaian = mysqli_query($koneksi, "SELECT * FROM ukuran_pakaian WHERE tipe_ukuran = 'pakaian'");
    $ukuran_footwear = mysqli_query($koneksi, "SELECT * FROM ukuran_pakaian WHERE tipe_ukuran = 'sepatu'");
    $ukuran_bottoms = mysqli_query($koneksi, "SELECT * FROM ukuran_pakaian WHERE tipe_ukuran = 'celana'");
    $ukuran_bagspurses = mysqli_query($koneksi, "SELECT * FROM ukuran_pakaian WHERE tipe_ukuran = 'lain'");

    // Simpan ke array untuk dioper ke JavaScript
    $ukuranData = [
        'pakaian' => [],
        'sepatu' => [],
        'celana' => [],
        'lain' => []
    ];

    while ($row = mysqli_fetch_assoc($ukuran_pakaian)) {
        $ukuranData['pakaian'][] = $row;
    }
    while ($row = mysqli_fetch_assoc($ukuran_footwear)) {
        $ukuranData['sepatu'][] = $row;
    }
    while ($row = mysqli_fetch_assoc($ukuran_bottoms)) {
        $ukuranData['celana'][] = $row;
    }
    while ($row = mysqli_fetch_assoc($ukuran_bagspurses)) {
        $ukuranData['lain'][] = $row;
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
    <!-- Filter -->
    <section class="filters">
        <select id="category-filter" class="filters-content">
            <option value="">Category</option>
            <?php while ($kat = mysqli_fetch_assoc($kategoriQuery)) : ?>
                <option value="<?= $kat['kategori']; ?>"><?= $kat['kategori']; ?></option>
            <?php endwhile; ?>
        </select>
        <select id="size-filter">
            <option value="">Size</option>
        </select>
    </section>

    <div class="container-sm">
        <h2>Tambah produk</h2>
    <!-- Content here -->
    <form action="../proses/proses_upload_foto.php" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="formFileMultiple" class="form-label">Upload Foto Produk:</label>
        <input class="form-control" type="file" id="formFileMultiple" name="foto_produk[]" multiple>
    </div>
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Nama Produk:</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Title">
    </div>
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Deskripsi</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Deskripsikan produkmu dengan detail dan jelas"></textarea>
    </div>
    <select class="form-select" aria-label="Default select example">
        <option selected>Open this select menu</option>
        <option value="1">One</option>
        <option value="2">Two</option>
        <option value="3">Three</option>
    </select>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1">
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Check me out</label>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>


    <h2>Tambah produk</h2>
    <form action="../proses/proses_upload_foto.php" method="post" enctype="multipart/form-data">

    <label>Upload Foto Produk:</label><br>
    <input type="file" name="foto_produk[]" multiple required><br><br>

    <label>Nama Produk:</label><br>
    <input type="text" name="nama_pakaian" required><br>

    <label>Deskripsi:</label><br>
    <textarea name="deskripsi" required></textarea><br>

    <label>Harga:</label><br>
    <input type="number" name="harga" required><br>
    
    <label>Kategori:</label><br>
    <select name="kategori" id="kategori">
        <option value="0">-- Pilih Kategori --</option>
        <?php

        $no = 1;
        $qry = mysqli_query($koneksi, "SELECT * FROM kategori_pakaian");
        while ($data = mysqli_fetch_array($qry)) {
        ?>
            <option data="<?= $data['kategori'] ?>" value="<?= $data['id_kategori'] ?>"><?= $data['kategori'] ?>
            </option>
        <?php }
        ?>
    </select><br>
    
    <label>Ukuran:</label><br>
    <select name="ukuran" id="ukuran">
        <option value="0">-- Pilih Ukuran --</option>
        <!-- <?php

        $no = 1;
        $qry = mysqli_query($koneksi, "SELECT * FROM ukuran_pakaian");
        while ($data = mysqli_fetch_array($qry)) {
        ?>
            <option data="<?= $data['ukuran'] ?>" value="<?= $data['id_ukuran'] ?>"><?= $data['ukuran'] ?>
            </option>
        <?php }
        ?> -->
    </select><br>
    
    <label>Kondisi pakaian:</label><br>
    <select name="kondisi" id="kondisi">
        <option value="0">-- Pilih kondisi --</option>
        <?php

        $no = 1;
        $qry = mysqli_query($koneksi, "SELECT * FROM kondisi_pakaian");
        while ($data = mysqli_fetch_array($qry)) {
        ?>
            <option data="<?= $data['kondisi'] ?>" value="<?= $data['id_kondisi'] ?>"><?= $data['kondisi'] ?>
            </option>
        <?php }
        ?>
    </select><br>

    <label for="status">Gender:</label>
<select name="gender" id="status">
  <option value="pria">Pria</option>
  <option value="wanita">Wanita</option>
  <option value="unisex">Unisex</option>
</select>



    <input type="submit" name="submit" value="Simpan Produk">
</form>


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
