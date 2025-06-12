'<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preloved Shop</title>
    <link rel="stylesheet" href="./frontend/style1_baru.css">
    <script src="./frontend/script.js" defer></script>
</head>

<?php
    include "config.php";

    // Ambil data kategori
    $kategoriQuery = mysqli_query($koneksi, "SELECT * FROM kategori_pakaian");
    $ukuranQuery = mysqli_query($koneksi, "SELECT * FROM ukuran_pakaian");
    $ukuranArray = [];
    while ($row = mysqli_fetch_assoc($ukuranQuery)) {
        $ukuranArray[$row['tipe_ukuran']][] = $row['ukuran'];
    }

?>

<body>

    <!-- Navbar -->
    <header>
        <div class="logo">PRELOVE969</div>
        <input type="text" id="search" class="search" placeholder="Cari pakaian...">
        <nav class="navbar">
            <a href="?gender=wanita">Wanita</a>
            <a href="?gender=pria">Pria</a>
            <a href="?gender=unisex">Unisex</a>
            <!-- <a href="#">Anak</a> -->
            <a href="#" class="sale">Sale</a>
            <a href="#" class="donate">Donasi</a>
            <a href="#" id="loginBtn">Login</a>
            <a href="#" id="registerBtn" class='btn'>Sign Up</a>
        </nav>
    </header>

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

<script>
    // Data ukuran dari PHP (diubah jadi JS array)
    const ukuranData = <?= json_encode($ukuranArray); ?>;

    const sizeSelect = document.getElementById('size-filter');
    const categorySelect = document.getElementById('category-filter');

    // Fungsi untuk menentukan tipe berdasarkan kategori
    function getTipeFromKategori(kategori) {
        switch (kategori.toLowerCase()) {
            case 'footwear': return 'sepatu';
            case 'bottoms': return 'celana';
            case 'bags&purses': return 'lain';
            default: return 'pakaian';
        }
    }

    
categorySelect.addEventListener('change', function () {
    const kategori = this.value;
    const tipe = getTipeFromKategori(kategori);

    // Kosongkan dan isi ulang <select> ukuran
    sizeSelect.innerHTML = '<option value="">Size</option>';
    if (ukuranData[tipe]) {
        ukuranData[tipe].forEach(ukuran => {
            const opt = document.createElement('option');
            opt.value = ukuran;
            opt.textContent = ukuran;
            sizeSelect.appendChild(opt);
        });
    }

    // Redirect jika hanya pilih kategori
    const url = new URL(window.location.href);
    url.searchParams.set('kategori', kategori);
    url.searchParams.delete('ukuran'); // Reset ukuran
    window.location.href = url.toString();
});

sizeSelect.addEventListener('change', function () {
    const kategori = categorySelect.value;
    const ukuran = this.value;
    const genderParam = new URLSearchParams(window.location.search).get('gender');
    
    
    const url = new URL(window.location.href);
    if (kategori) url.searchParams.set('kategori', kategori);
    if (ukuran) url.searchParams.set('ukuran', ukuran);
    if (genderParam) url.searchParams.set('gender', genderParam);

    window.location.href = url.toString();
});

// Set nilai dropdown sesuai URL
window.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    const selectedKategori = params.get('kategori') || '';
    const selectedUkuran = params.get('ukuran') || '';

    if (selectedKategori) {
        categorySelect.value = selectedKategori;
        const tipe = getTipeFromKategori(selectedKategori);
        sizeSelect.innerHTML = '<option value="">Size</option>';
        if (ukuranData[tipe]) {
            ukuranData[tipe].forEach(ukuran => {
                const opt = document.createElement('option');
                opt.value = ukuran;
                opt.textContent = ukuran;
                sizeSelect.appendChild(opt);
            });
        }
    }

    if (selectedUkuran) {
        sizeSelect.value = selectedUkuran;
    }
});


</script>


    <!-- Daftar Produk -->
<section class="products">
    <?php
        // Tangkap filter dari URL
        $filterKategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
        $filterUkuran   = isset($_GET['ukuran']) ? $_GET['ukuran'] : '';
        $filterGender = isset($_GET['gender']) ? $_GET['gender'] : '';

        // Query
        $query = "SELECT p.id_pakaian, p.nama_pakaian, p.deskripsi, p.harga, k.kategori, u.ukuran, c.kondisi, f.path_foto, p.tgl_upload 
            FROM pakaian p
            LEFT JOIN kategori_pakaian k ON p.id_kategori = k.id_kategori
            LEFT JOIN ukuran_pakaian u ON p.id_ukuran = u.id_ukuran
            LEFT JOIN kondisi_pakaian c ON p.id_kondisi = c.id_kondisi
            LEFT JOIN (SELECT * FROM foto_produk WHERE urutan = 1) f ON p.id_pakaian = f.id_pakaian 
            WHERE p.status_ketersediaan = 'tersedia'";

        // Tambahkan filter jika ada
        if (!empty($filterKategori)) {
            $filterKategori = mysqli_real_escape_string($koneksi, $filterKategori);
            $query .= " AND k.kategori = '$filterKategori'";
        }
        if (!empty($filterUkuran)) {
            $filterUkuran = mysqli_real_escape_string($koneksi, $filterUkuran);
            $query .= " AND u.ukuran = '$filterUkuran'";
        }

        if (!empty($filterGender)) {
            $filterGender = mysqli_real_escape_string($koneksi, $filterGender);
            $query .= " AND p.gender = '$filterGender'";
        }

        $query .= " ORDER BY p.id_pakaian DESC";

        $result = mysqli_query($koneksi, $query);

        if (!$result) {
            die("Query error: " . mysqli_error($koneksi)); // Tampilkan penyebab pasti
        }

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='product'>
                <a href='user/detail_produk.php?id={$row['id_pakaian']}'>
                    <img src='upload/{$row['path_foto']}' alt='{$row['nama_pakaian']}' width='200'>
                    <h3>{$row['nama_pakaian']}</h3>
                    <p>Rp " . number_format($row['harga'], 0, ',', '.') . "</p>
                    <p> {$row['ukuran']}</p>
                    <p> {$row['kondisi']}</p>
                </a>
                    </div>";
        }
    ?>
</section>

    <!-- Popup Login -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Selamat Datang!</h2>
            <form action="./proses/proses-login.php" method="POST">
                <input type="text" name="username" placeholder="Username" required size="200">
                <input type="password" name="password" placeholder="Password" required><br><br>
                <button type="submit" name="submit">Login</button><br><br>
                <p>Belum punya akun? <a href='#' id="registerBtn">Signup</a></p>
            </form>
        </div>
    </div>
    
    <!-- Popup Registrasi -->
    <div id="registerModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Daftar Akun</h2>
            <form action="./proses/proses-register.php" method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Ulangi Password" required><br><br>
                <button type="submit" name="submit">Daftar</button><br><br>
                <p>Sudah punya akun? <a href="#" id="loginBtn">Login</a></p>
            </form>
        </div>
    </div>

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