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
        
        <?php if (isset($_SESSION['errors'])): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>

        <!-- Content here -->
        <form action="../proses/proses_donasi.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="foto_produk" class="form-label">Upload Foto Pakaian yang Akan Didonasikan:</label>
                <input class="form-control" type="file" id="foto_produk" name="foto_produk[]" multiple accept="image/*">
                <small class="text-muted">Upload foto yang jelas untuk memudahkan verifikasi</small>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama lengkap:</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama lengkap" required>
            </div>
            <div class="mb-3">
                <label for="no_telp" class="form-label">No. Telepon:</label>
                <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="Masukkan nomor telepon aktif" required>
            </div>
            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori Pakaian:</label>
                <select class="form-select" name="kategori[]" id="kategori" multiple required>
                    <option value="Atasan">Atasan</option>
                    <option value="Bawahan">Bawahan</option>
                    <option value="Dress">Dress</option>
                    <option value="Outerwear">Outerwear</option>
                    <option value="Sepatu">Sepatu</option>
                    <option value="Tas">Tas</option>
                    <option value="Aksesoris">Aksesoris</option>
                </select>
                <small class="text-muted">Bisa pilih lebih dari satu kategori</small>
            </div>
            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah Item:</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" min="1" required>
            </div>
            <div class="mb-3">
                <label for="kondisi" class="form-label">Kondisi Pakaian:</label>
                <select class="form-select" name="kondisi" id="kondisi" required>
                    <option value="">Pilih kondisi</option>
                    <option value="Sangat Baik">Sangat Baik (Seperti Baru)</option>
                    <option value="Baik">Baik (Pernah dipakai, tidak ada kerusakan)</option>
                    <option value="Cukup Baik">Cukup Baik (Ada sedikit noda/kerusakan kecil)</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi:</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Jelaskan detail pakaian yang akan didonasikan (ukuran, warna, dll)"></textarea>
            </div>
            <div class="mb-3">
                <label for="metode" class="form-label">Metode Pengiriman:</label>
                <select class="form-select" name="metode_donasi" id="metode" required>
                    <option value="">Pilih metode</option>
                    <option value='antar langsung'>Antar Langsung</option>
                    <option value='pickup'>Pick-up</option>
                </select>
            </div>
            <div class="mb-3" id="waktuContainer" style="display:none;">
                <label for="waktu_pickup" class="form-label">Waktu Pickup yang Diinginkan:</label>
                <input type="datetime-local" class="form-control" id="waktu_pickup" name="waktu_pickup">
                <small class="text-muted">Pilih waktu yang sesuai dengan jadwal Anda</small>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat Lengkap:</label>
                <textarea class="form-control" id="alamat" rows="3" name="alamat" placeholder="Masukkan alamat lengkap (termasuk kode pos)" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Kirim Donasi</button>
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

    // Show/hide waktu pickup based on metode
    const metodeSelect = document.getElementById('metode');
    const waktuContainer = document.getElementById('waktuContainer');
    const waktuPickup = document.getElementById('waktu_pickup');

    metodeSelect.addEventListener('change', function() {
        if (this.value === 'pickup') {
            waktuContainer.style.display = 'block';
            waktuPickup.required = true;
        } else {
            waktuContainer.style.display = 'none';
            waktuPickup.required = false;
            waktuPickup.value = ''; // Clear value when hidden
        }
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
