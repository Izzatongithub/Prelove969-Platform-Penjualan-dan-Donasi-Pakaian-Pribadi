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
    
    <link rel="stylesheet" href="frontend/style1_baru.css">
    <script src="frontend/script.js" defer></script>
</head>
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
            <a href="?gender=unisex">Unisex</a> -->
            <!-- <a href="#">Anak</a> -->
            <a href="form_donasi.php" class="donate">Donasi</a>
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
        <!-- <a href="keranjang.php">Keranjang</a> -->
        <a href="pesananku.php">Pesanan saya</a>
        <a href="pesanan_masuk.php">Pesanan masuk</a>
        <!-- <a href="profil_saya.php">Profil saya</a> -->
        <!-- <a href="wishlist.php">Wishlist</a> -->
        <a href="riwayat_donasi.php">Riwayat Donasi</a>
    </div>
</body>
</html>