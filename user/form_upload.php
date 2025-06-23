<!DOCTYPE html>

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


<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preloved Shop</title>
    <link rel="stylesheet" href="../frontend/style1.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
    </select>1
    <input type="submit" name="submit" value="Simpan Produk">
</form>

<script>
    const ukuranData = <?= json_encode($ukuranData); ?>;
    const kategoriSelect = document.getElementById('kategori');
    const ukuranSelect = document.getElementById('ukuran');

    kategoriSelect.addEventListener('change', function () {
        const selectedOption = kategoriSelect.options[kategoriSelect.selectedIndex];
        const kategoriNama = selectedOption.getAttribute('data');

        let tipeUkuran = 'pakaian'; // default
        if (kategoriNama === 'Footwear') {
            tipeUkuran = 'sepatu';
        } else if (kategoriNama === 'Bottoms') {
            tipeUkuran = 'celana';
        } else if (kategoriNama === 'Bags & purses') {
            tipeUkuran = 'lain';
        }

        // Kosongkan ukuran
        ukuranSelect.innerHTML = '<option value="">-- Pilih Ukuran --</option>';

        // Tambahkan opsi dari data yang sesuai
        ukuranData[tipeUkuran].forEach(item => {
            const opt = document.createElement('option');
            opt.value = item.id_ukuran;
            opt.textContent = item.ukuran;
            ukuranSelect.appendChild(opt);
        });
    });
</script>


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
