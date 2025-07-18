<!DOCTYPE html>
<html lang="id">
<head>
    <title>Preloved Shop</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../frontend/style1_baru.css">
    <script src="../frontend/script.js" defer></script>
</head>

<?php
    include "../config.php";
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: index.php?page=login");
    }

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
            <a href="riwayat_transaksi.php">Riwayat Transaksi</a>
            <!-- <a href="keranjang.php">Keranjang</a> -->
            <!-- <a href="profil_saya.php">Profil saya</a> -->
            <!-- <a href="wishlist.php">Wishlist</a> -->
            <!-- <a href="?gender=wanita">Wanita</a>
            <a href="?gender=pria">Pria</a>
            <a href="?gender=unisex">Unisex</a> -->
    </div>
    
    <!-- <span><?php echo"<h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Welcome, " . $_SESSION['username'] . "</h3>"; ?></span><br> -->
    
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
        <!-- <label for="gender-filter">Filter Gender:</label> -->
        <?php $gender = isset($_GET['gender']) ? $_GET['gender'] : ''; ?>

        <select id="gender-filter" name="gender">
            <option value="">Gender</option>

            <option value="pria"
                <?php
                if ($gender === 'pria') {
                    echo 'selected';
                }
                ?>
            >Pria</option>

            <option value="wanita"
                <?php
                if ($gender === 'wanita') {
                    echo 'selected';
                }
                ?>
            >Wanita</option>

            <option value="unisex"
                <?php
                if ($gender === 'unisex') {
                    echo 'selected';
                }
                ?>
            >Unisex</option>
        </select>

    </section>

    <script>
        document.getElementById('gender-filter').addEventListener('change', function () {
            const selectedGender = this.value;
            const urlParams = new URLSearchParams(window.location.search);

            if (selectedGender) {
                urlParams.set('gender', selectedGender);
            } else {
                urlParams.delete('gender');
            }

            // Redirect ke URL baru dengan parameter yang diperbarui
            window.location.search = urlParams.toString();
        });
    </script>

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

            $query = "SELECT p.id_pakaian, p.nama_pakaian, p.deskripsi, p.harga, k.kategori, u.ukuran, c.kondisi, f.path_foto, p.tgl_upload 
                FROM pakaian p LEFT JOIN kategori_pakaian k ON p.id_kategori = k.id_kategori
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

            // $result = mysqli_query($koneksi, $query);
            // if (!$result) {
            //     die("Query error: " . mysqli_error($koneksi)); // Tampilkan penyebab pasti
            // }

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
            
            //menampilkan produk detail 
            while ($row = mysqli_fetch_assoc($result)) {
                $id_user = $_SESSION['id_user'];
                $id_pakaian = $row['id_pakaian'];
                $cek = mysqli_query($koneksi, "SELECT * FROM likes WHERE id_user = '$id_user' AND id_pakaian = '$id_pakaian'");
                $sudah_suka = mysqli_num_rows($cek) > 0;

                echo "<div class='product'>
                    <a href='detail_produk.php?id={$row['id_pakaian']}'>
                        <img src='{$row['path_foto']}' alt='{$row['nama_pakaian']}' width='200'>
                    </a>";
                echo "<div class='product-header'>
                        <h3 style='margin: 0;'>{$row['nama_pakaian']}</h3>";

                if (isset($_SESSION['id_user'])) {
                    echo "<form method='POST' action='../proses/proses_likes.php' style='margin: 0;'>
                            <input type='hidden' name='id_pakaian' value='{$row['id_pakaian']}'>";
                    if ($sudah_suka) {
                        echo"<button type='submit' name='likes' value='batal' style='border: none; background: none; cursor: pointer; font-size: 18px; color:red;'>
                                <i class='fa-solid fa-heart'></i>
                            </button>";
                    } else {
                        echo"<button type='submit' name='likes' value='suka' style='border: none; background: none; cursor: pointer; font-size: 18px; color:#444;'>
                                <i class='fa-regular fa-heart'></i>
                            </button>";
                    }
                    echo "</form>";
                }
                
                echo "</div>"; // penutup product-header
                echo "<p>Rp " . number_format($row['harga'], 0, ',', '.') . "</p>
                <p>{$row['ukuran']}</p>
                <p><em>Diunggah " . waktuUpload($row['tgl_upload']) . "</em></p>";
                
                $jumlah_suka = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM likes WHERE id_pakaian='$id_pakaian'"));
                echo "<p>Disukai oleh $jumlah_suka orang</p>
                </div>";
            }
        ?>
    </section>

</body>
<!-- <footer> -->
    <!-- <div class="footer-container">
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