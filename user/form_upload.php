<!DOCTYPE html>

<?php
    include "../config.php";

    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: index.php?page=login");
    }

?>


<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preloved Shop</title>
    <link rel="stylesheet" href="../frontend/style1.css">
    <script src="../frontend/script.js" defer></script>
</head>
<body>
    <!-- Navbar -->
    <header>
        <div class="topbar">
            <div class="logo">PRELOVE969</div>
            <input type="text" id="search" class="search" placeholder="Cari pakaian...">
            <a href="">Jual</a>
        </div>
        <span> <?php echo"<h3>Welcome, " . $_SESSION['username'] . "</h3>"; ?></span>
    </header>
    
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
    <select name="kategori" id="kategi">
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
        <?php

        $no = 1;
        $qry = mysqli_query($koneksi, "SELECT * FROM ukuran_pakaian");
        while ($data = mysqli_fetch_array($qry)) {
        ?>
            <option data="<?= $data['ukuran'] ?>" value="<?= $data['id_ukuran'] ?>"><?= $data['ukuran'] ?>
            </option>
        <?php }
        ?>
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
