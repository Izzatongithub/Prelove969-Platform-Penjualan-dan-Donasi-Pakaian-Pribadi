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
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="SB-Mid-client-YNYtads1Nffj3p6l"></script>
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
                <a href='index_user.php'>PRELOVE969</a>
            </div>
            <input type="text" id="search" class="search" placeholder="Cari pakaian...">
        </div>
        <nav class="navbar">
            <!-- <a href="?gender=wanita">Wanita</a>
            <a href="?gender=pria">Pria</a>
            <a href="?gender=unisex">Unisex</a>
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
        <!-- <span><?php echo"<h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Welcome, " . $_SESSION['username'] . "</h3>"; ?></span> -->
    </header>
<?php
    echo "<div class='cart-container'>";
    echo "<h2 class='cart-title'>Autentikasi</h2>";
    echo "<div class='cart-wrapper'>";
?>


<!-- Form Checkout -->
<form action="" method="" class="form-checkout">
    <button id="pay-button" class='btn-primary'>Bayar Sekarang!</button>
    </form>

<?php
    echo "</div>"; // close cart-wrapper
    echo "</div>"; // close cart-container
?>

</body>
</html>
