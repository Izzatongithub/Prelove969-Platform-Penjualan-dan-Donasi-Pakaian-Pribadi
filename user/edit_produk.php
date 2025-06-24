<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preloved Shop</title>
    <link rel="stylesheet" href="../frontend/style1_baru.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="../frontend/script.js" defer></script>
</head>

<?php
session_start();
include '../config.php';

$id = $_GET['id'];
$id_user = $_SESSION['id_user'];

$query = mysqli_query($koneksi, "SELECT * FROM pakaian WHERE id_pakaian = '$id' AND id_user = '$id_user'");
$data = mysqli_fetch_assoc($query);
if (!$data) die("Produk tidak ditemukan atau bukan milik Anda.");
?>

<body>
    <!-- Navbar -->
    <header>
        <div class="header-top">
            <div class="logo">
                <a href='index_user.php'>
                    <i class="fas fa-heart me-2"></i> Prelove969</a>
            </div>
            <input type="text" id="search" class="search" placeholder="Cari pakaian...">
        </div>
        <nav class="navbar">
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
            </nav>
    </header>
        <div class="main-links">
            <a href="jual_pakaian.php">Jual</a>
            <a href="pesananku.php">Pesanan saya</a>
            <a href="pesanan_masuk.php">Pesanan masuk</a>
            <a href="riwayat_donasi.php">Riwayat Donasi</a>
            
        </div>
        <!-- <span> <?php echo"<h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Welcome, " . $_SESSION['username'] . "</h3>"; ?></span> -->
    </header>
</section>

    <div class="profile-container">
    <div class="profile-header">
        <h2>Edit Produk</h2>
    </div>

    <div class="uploaded-products-container">
        <form class="form-edit-stacked" action="../proses/update_produk.php" method="post">
            <input type="hidden" name="id_pakaian" value="<?= $data['id_pakaian'] ?>">

            <label>Nama:</label>
            <input type="text" name="nama_pakaian" value="<?= $data['nama_pakaian'] ?>">

            <label>Harga:</label>
            <input type="number" name="harga" value="<?= $data['harga'] ?>">

            <label>Deskripsi:</label>
            <textarea name="deskripsi"><?= $data['deskripsi'] ?></textarea>

            <button type="submit" class="btn">Simpan</button>
        </form>
    </div>

</div>

</body>
