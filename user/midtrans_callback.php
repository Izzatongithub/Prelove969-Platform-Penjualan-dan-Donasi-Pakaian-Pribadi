<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preloved Shop</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../frontend/style1_baru.css">
    <script src="../frontend/script.js" defer></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="your-client-key"></script>
</head>
<?php
    session_start();
    include '../config.php'; // koneksi ke database
    if (!isset($_SESSION['snap_token'])) {
        die("Snap token tidak ditemukan.");
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
    
    <!-- <span><?php echo"<h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Welcome, " . $_SESSION['username'] . "</h3>"; ?></span> -->
<?php
    echo "<div class='cart-container'>";
    echo "<h2 class='cart-title'>Autentikasi</h2>";
    echo "<div class='cart-wrapper'>";
?>


<!-- Form Checkout -->
<form action="" method="" class="form-checkout">
    <button id="pay-button" class='btn-primary' type="button">Bayar Sekarang!</button>
    <script>
    document.getElementById('pay-button').addEventListener('click', function () {
        snap.pay("<?= $_SESSION['snap_token'] ?>", {
            onSuccess: function(result) {
                window.location.href = "payment_success.php?status=sukses";
            },
            onPending: function(result) {
                alert("Pembayaran tertunda.");
            },
            onError: function(result) {
                alert("Terjadi kesalahan pembayaran.");
            }
        });
    });
    </script>

    </form>

<?php
    echo "</div>"; // close cart-wrapper
    echo "</div>"; // close cart-container
?>

</body>
</html>
