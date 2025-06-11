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
            <a href="#">Anak</a>
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
        <!-- <span> <?php echo"<h5>Welcome, " . $_SESSION['username'] . "</h3>"; ?></span> -->
    </header>

    <div class="container-sm">
    <br><h2>Form donasi</h2><br>
        <!-- Content here -->
        <form action="../proses/proses_donasi.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="formFileMultiple" class="form-label">Upload Foto:</label>
                <input class="form-control" type="file" id="formFileMultiple" name="foto_produk[]" multiple>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Nama lengkap:</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="nama" placeholder="Title">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">No-Telp</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="no_telp" placeholder="No-Telp/Email">
            </div>
            <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Metode</label>
            <select class="form-select" aria-label="Default select example" name="metode_donasi" id="metode">
                <option selected>Select category</option>
                <option value='antar langsung'>Antar Langsung</option>
                <option value='pickup'>Pick-up</option>
            </select>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Alamat</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="alamat" placeholder="Alamat sesuai domisili"></textarea>
            </div>
            <button type="submit" class="btn-primary">Submit</button>
        </form>
    </div>

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
