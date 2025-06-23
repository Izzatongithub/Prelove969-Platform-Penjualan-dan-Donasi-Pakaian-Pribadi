<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preloved Shop</title>
    <!-- font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../frontend/style1_baru.css">
    <script src="../frontend/script.js" defer></script>
    <!-- <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"> -->
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
            <div class="logo">
                <a href='index_user.php'>
                <i class="fas fa-heart me-2"></i>Prelove969</a>
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
            <a href="#" id="registerBtn" class='btn-primary'>Logout</a>
        </nav>
            <!-- <span><?php echo"<h5>Welcome, " . $_SESSION['username'] . "</h3>"; ?></span> -->
    </header>

    <div class="container-sm">
    <br><h2>Tambah produk</h2><br>
        <!-- Content here -->
        <form action="../proses/proses_upload_foto.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="formFileMultiple" class="form-label">Upload Foto Produk:</label>
                <input class="form-control" type="file" id="formFileMultiple" name="foto_produk[]" multiple>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Nama Produk:</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="nama_pakaian" placeholder="Title">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="deskripsi" placeholder="Deskripsikan produkmu dengan detail dan jelas"></textarea>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Harga:</label>
                <input type="number" class="form-control" id="exampleFormControlInput1" name="harga" placeholder="Harga">
            </div>
            <label for="exampleFormControlTextarea1" class="form-label">Category</label>
            <select class="form-select" aria-label="Default select example" name="kategori" id="kategori">
                <option selected>Select category</option>
                <?php

                $no = 1;
                $qry = mysqli_query($koneksi, "SELECT * FROM kategori_pakaian");
                while ($data = mysqli_fetch_array($qry)) {
                ?>
                    <option data="<?= $data['kategori'] ?>" value="<?= $data['id_kategori'] ?>"><?= $data['kategori'] ?>
                    </option>
                <?php }
                ?>
            </select>
            <label for="exampleFormControlTextarea1" class="form-label">Size</label>
            <select class="form-select" aria-label="Default select example" id="ukuran" name="ukuran">
                <option selected>Select size</option>
                
            </select>
            <label for="exampleFormControlTextarea1" class="form-label">Kondisi</label>
            <select class="form-select" aria-label="Default select example" name="kondisi">
                <option selected>Pilih kondisi</option>
                <?php

                $no = 1;
                $qry = mysqli_query($koneksi, "SELECT * FROM kondisi_pakaian");
                while ($data = mysqli_fetch_array($qry)) {
                ?>
                    <option data="<?= $data['kondisi'] ?>" value="<?= $data['id_kondisi'] ?>"><?= $data['kondisi'] ?>
                    </option>
                <?php }
                ?>
            </select>
            <label for="exampleFormControlTextarea1" class="form-label">Gender</label>
                <select class="form-select" aria-label="Default select example" name="gender">
                    <option selected>Pilih Gender</option>
                    <option value="pria">Pria</option>
                    <option value="wanita">Wanita</option>
                    <option value="unisex">Unisex</option>
                </select>
                <button type="submit" class="btn btn-primary">Submit</button>
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
