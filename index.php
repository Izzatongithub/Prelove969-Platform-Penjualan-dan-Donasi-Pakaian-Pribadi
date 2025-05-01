<!DOCTYPE html>

<?php
include "config.php";
?>


<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preloved Shop</title>
    <link rel="stylesheet" href="./frontend/style1.css">
    <script src="./frontend/script.js" defer></script>
</head>
<body>

    <!-- Navbar -->
    <header>
        <div class="logo">PRELOVE969</div>
        <input type="text" id="search" class="search" placeholder="Cari pakaian...">
        <nav class="navbar">
        <div class="dropdown">
                <a href="#">Wanita</a>
                <div class="dropdown-menu">
                    <div class="dropdown-column">
                        <h4>Baju</h4>
                        <a href="#">T-shirts</a>
                        <a href="#">Polo shirts</a>
                        <a href="#">Kemeja</a>
                        <a href="#">Sweater</a>
                        <a href="#">Hoodie</a>
                        <a href="#">Jaket</a>
                        <a href="#">Jeans</a>
                        <a href="#">Celana</a>
                        <a href="#">Shorts</a>
                    </div>
            </div>
        </div>
            <div class="dropdown">
                <a href="#">Pria</a>
                <div class="dropdown-menu">
                    <div class="dropdown-column">
                        <h4>Baju</h4>
                        <a href="#">T-shirts</a>
                        <a href="#">Polo shirts</a>
                        <a href="#">Kemeja</a>
                        <a href="#">Sweater</a>
                        <a href="#">Hoodie</a>
                        <a href="#">Jaket</a>
                        <a href="#">Jeans</a>
                        <a href="#">Celana</a>
                        <a href="#">Shorts</a>
                    </div>
                    <div class="dropdown-column">
                        <h4>Baju</h4>
                        <a href="#">T-shirts</a>
                        <a href="#">Polo shirts</a>
                        <a href="#">Kemeja</a>
                        <a href="#">Sweater</a>
                        <a href="#">Hoodie</a>
                        <a href="#">Jaket</a>
                        <a href="#">Jeans</a>
                        <a href="#">Celana</a>
                        <a href="#">Shorts</a>
                    </div>
            </div>
        </div>
            <a href="#">Branded</a>
            <a href="#">Anak</a>
            <a href="#" class="sale">Sale</a>
            <a href="#" class="donate">Donasi</a>
            <a href="#" id="loginBtn">Login</a>
            <a href="register.php" class="btn">Sign Up</a>
        </nav>
    </header>

    <!-- Kategori -->
    <section class="categories">
        <button>Footwear</button>
        <button>Tops</button>
        <button>Bottoms</button>
        <button>Outerwear</button>
        <button>Underwear</button>
        <button>Accessories</button>
    </section>

    <!-- Filter -->
    <section class="filters">
        <select id="category-filter" class="filters-content">
            <option value="">Category</option>
            <option value="tops">Tops</option>
            <option value="bottoms">Bottoms</option>
        </select>
        <select id="size-filter">
            <option value="">Size</option>
            <option value="S">S</option>
            <option value="M">M</option>
        </select>
        <select id="color-filter">
            <option value="">Warna</option>
        </select>
    </section>

    <!-- Daftar Produk -->
    <section class="products">
        <?php
        // Simulasi data produk (bisa diganti dengan database)
        $products = [
            ["name" => "Hoodie Hijau", "price" => "Rp 60.000", "image" => "hoodie.jpg"],
            ["name" => "Celana Coklat", "price" => "Rp 25.000", "image" => "pants.jpg"],
            ["name" => "Kaos Putih", "price" => "Rp 85.000", "image" => "shirt.jpg"],
            ["name" => "Jeans FUBU", "price" => "Rp 250.000", "image" => "jeans.jpg"]
        ];

        foreach ($products as $product) {
            echo "<div class='product'>
                    <img src='images/{$product['image']}' alt='{$product['name']}'>
                    <h3>{$product['name']}</h3>
                    <p>{$product['price']}</p>
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
                <p>Belum punya akun? <a href=signup.php>Signup</a></p>
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
