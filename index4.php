<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preloved Shop</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        /* Header Styles */
        header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 20px 30px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .logo {
            font-size: 32px;
            font-weight: bold;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            letter-spacing: 2px;
        }

        .search {
            flex: 1;
            max-width: 500px;
            padding: 12px 20px;
            border-radius: 25px;
            border: none;
            margin: 0 30px;
            font-size: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .search:focus {
            outline: none;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.2);
            transform: translateY(-2px);
        }

        .navbar {
            display: flex;
            align-items: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            padding: 10px 15px;
            border-radius: 20px;
            transition: all 0.3s ease;
            position: relative;
        }

        .navbar a:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        /* Dropdown Styles */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background: white;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            width: 500px;
            padding: 20px;
            visibility: hidden;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s ease;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
        }

        .dropdown:hover > .dropdown-menu {
            visibility: visible;
            opacity: 1;
            transform: translateY(0);
        }

        .dropdown-column {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .dropdown-column h4 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
            border-bottom: 2px solid #667eea;
            padding-bottom: 5px;
        }

        .dropdown-menu a {
            display: block;
            padding: 8px 12px;
            color: #555;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .dropdown-menu a:hover {
            background: #f8f9ff;
            color: #667eea;
            transform: translateX(5px);
        }

        .sale {
            background: linear-gradient(45deg, #ff6b6b, #ff8e8e);
            color: white !important;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .donate {
            background: linear-gradient(45deg, #4ecdc4, #6bccc4);
            color: white !important;
        }

        .btn {
            padding: 10px 20px;
            background: linear-gradient(45deg, #333, #555);
            color: white;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        /* Categories Styles */
        .categories {
            display: flex;
            justify-content: center;
            gap: 15px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            margin: 20px;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }

        .categories button {
            padding: 12px 24px;
            border: none;
            background: linear-gradient(45deg, #e3f2fd, #bbdefb);
            cursor: pointer;
            border-radius: 25px;
            font-weight: 600;
            color: #1976d2;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .categories button:hover {
            background: linear-gradient(45deg, #1976d2, #42a5f5);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(25, 118, 210, 0.4);
        }

        /* Filters Styles */
        .filters {
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 20px;
            margin: 0 20px;
        }

        select {
            width: 200px;
            padding: 12px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            font-size: 16px;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        select:hover, select:focus {
            border-color: #667eea;
            outline: none;
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
            transform: translateY(-2px);
        }

        select option {
            padding: 10px;
            font-size: 16px;
        }

        /* Products Grid */
        .products {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
            padding: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .product {
            background: white;
            padding: 20px;
            text-align: center;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
        }

        .product:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
        }

        .product::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .product a {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .product img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .product:hover img {
            transform: scale(1.05);
        }

        .product h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #333;
            font-weight: 600;
        }

        .product p {
            margin: 8px 0;
            color: #666;
            line-height: 1.5;
        }

        .product p strong {
            color: #333;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            align-items: center;
            justify-content: center;
            visibility: hidden;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .modal.show {
            visibility: visible;
            opacity: 1;
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 40px;
            border-radius: 20px;
            width: 450px;
            text-align: center;
            position: relative;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: modalSlideIn 0.3s ease;
        }

        @keyframes modalSlideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .close {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 28px;
            cursor: pointer;
            color: #999;
            transition: all 0.3s ease;
        }

        .close:hover {
            color: #333;
            transform: scale(1.2);
        }

        .modal-content h2 {
            margin-bottom: 30px;
            color: #333;
            font-size: 28px;
        }

        .modal-content input {
            width: 90%;
            padding: 15px 20px;
            margin: 10px 0;
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .modal-content input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 15px rgba(102, 126, 234, 0.3);
        }

        .modal-content button {
            width: 95%;
            padding: 15px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .modal-content button:hover {
            background: linear-gradient(45deg, #5a6fd8, #6a4190);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .modal-content p {
            margin-top: 20px;
            color: #666;
        }

        .modal-content a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .modal-content a:hover {
            text-decoration: underline;
        }

        /* Footer Styles */
        footer {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 40px 0 20px;
            margin-top: 50px;
        }

        .footer-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-container div {
            max-width: 300px;
            margin-bottom: 30px;
        }

        .footer-container h3 {
            font-size: 20px;
            margin-bottom: 15px;
            color: #fff;
            border-bottom: 2px solid #667eea;
            padding-bottom: 8px;
            display: inline-block;
        }

        .footer-container p, 
        .footer-container ul {
            font-size: 14px;
            line-height: 1.8;
            color: #bdc3c7;
        }

        .footer-container ul {
            list-style: none;
            padding: 0;
        }

        .footer-container ul li {
            margin: 8px 0;
        }

        .footer-container ul li a {
            color: #bdc3c7;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-container ul li a:hover {
            color: #667eea;
            transform: translateX(5px);
        }

        .social-icons {
            margin-top: 15px;
        }

        .social-icons a img {
            width: 35px;
            height: 35px;
            margin: 0 8px;
            transition: all 0.3s ease;
            border-radius: 50%;
        }

        .social-icons a img:hover {
            transform: scale(1.2);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .footer-bottom {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #34495e;
            font-size: 14px;
            text-align: center;
            color: #95a5a6;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 15px;
            }
            
            .dropdown-menu {
                width: 300px;
                flex-direction: column;
            }
            
            .categories {
                flex-wrap: wrap;
                gap: 10px;
            }
            
            .filters {
                flex-direction: column;
                align-items: center;
            }
            
            select {
                width: 250px;
            }
            
            .products {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 20px;
                padding: 20px;
            }
            
            .modal-content {
                width: 90%;
                margin: 20px;
            }
            
            .footer-container {
                flex-direction: column;
                text-align: center;
            }
        }

        /* Utility Classes */
        .text-gradient {
            background: linear-gradient(45deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hover-lift {
            transition: transform 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-3px);
        }
    </style>
    <script>
        // Modal functionality
        document.addEventListener("DOMContentLoaded", function() {
            const loginBtn = document.getElementById("loginBtn");
            const modal = document.getElementById("loginModal");
            const closeModal = document.querySelector(".close");
            
            if (loginBtn && modal) {
                loginBtn.addEventListener("click", function(e) {
                    e.preventDefault();
                    modal.classList.add("show");
                });
            }
            
            if (closeModal && modal) {
                closeModal.addEventListener("click", function() {
                    modal.classList.remove("show");
                });
            }
            
            if (modal) {
                modal.addEventListener("click", function(e) {
                    if (e.target === modal) {
                        modal.classList.remove("show");
                    }
                });
            }
        });

        // Search functionality
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("search");
            if (searchInput) {
                searchInput.addEventListener("keypress", function(e) {
                    if (e.key === "Enter") {
                        const searchTerm = this.value.toLowerCase();
                        const products = document.querySelectorAll(".product");
                        
                        products.forEach(function(product) {
                            const productText = product.textContent.toLowerCase();
                            if (productText.includes(searchTerm)) {
                                product.style.display = "block";
                            } else {
                                product.style.display = "none";
                            }
                        });
                    }
                });
            }
        });
    </script>
</head>

<?php
    include "config.php";
?>

<body>
    <!-- Navbar -->
    <header>
        <div class="topbar">
            <div class="logo">PRELOVE969</div>
            <input type="text" id="search" class="search" placeholder="Cari pakaian impian Anda...">
        </div>
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
                        <h4>Aksesoris</h4>
                        <a href="#">Topi</a>
                        <a href="#">Tas</a>
                        <a href="#">Sepatu</a>
                        <a href="#">Jam Tangan</a>
                        <a href="#">Kacamata</a>
                        <a href="#">Dompet</a>
                        <a href="#">Ikat Pinggang</a>
                        <a href="#">Kaos Kaki</a>
                        <a href="#">Aksesoris Lain</a>
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
                $query = "SELECT p.id_pakaian, p.nama_pakaian, p.deskripsi, p.harga, k.kategori, u.ukuran, c.kondisi, f.path_foto FROM pakaian p
                        LEFT JOIN kategori_pakaian k ON p.id_kategori = k.id_kategori
                        LEFT JOIN ukuran_pakaian u ON p.id_ukuran = u.id_ukuran
                        LEFT JOIN kondisi_pakaian c ON p.id_kondisi = c.id_kondisi
                        LEFT JOIN (SELECT * FROM foto_produk WHERE urutan = 1) f ON p.id_pakaian = f.id_pakaian WHERE p.status_ketersediaan = 'tersedia'
                        ORDER BY p.id_pakaian DESC";

                $result = mysqli_query($koneksi, $query);

                if (!$result) {
                    die("Query error: " . mysqli_error($koneksi)); // Tampilkan penyebab pasti
                }
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='product'>
                        <a href='user/detail_produk.php?id={$row['id_pakaian']}'>
                            <img src='upload/{$row['path_foto']}' alt='{$row['nama_pakaian']}' width='200'>
                            <h3>{$row['nama_pakaian']}</h3>
                            <p><strong>Harga:</strong> Rp " . number_format($row['harga'], 0, ',', '.') . "</p>
                            <p><strong>Kategori:</strong> {$row['kategori']}</p>
                            <p><strong>Ukuran:</strong> {$row['ukuran']}</p>
                            <p><strong>Kondisi:</strong> {$row['kondisi']}</p>
                            <p>{$row['deskripsi']}</p>
                        </a>
                            </div>";
                }
            ?>
        </div>
            </section>      

    <!-- Popup Login -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Selamat Datang!</h2>
            <form action="./proses/proses-login.php" method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="submit">Login</button>
                <p>Belum punya akun? <a href="signup.php">Sign Up</a></p>
            </form>
        </div>
    </div>

    <footer>
        <div class="footer-container">
            <div class="footer-about">
                <h3>Tentang Kami</h3>
                <p>Website ini adalah platform preloved yang membantu pengguna menjual dan mendonasikan pakaian bekas yang masih layak pakai. Bergabunglah dengan gerakan fashion berkelanjutan!</p>
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
                    <a href="#"><img src="https://cdn-icons-png.flaticon.com/32/124/124010.png" alt="Facebook"></a>
                    <a href="#"><img src="https://cdn-icons-png.flaticon.com/32/2111/2111463.png" alt="Instagram"></a>
                    <a href="#"><img src="https://cdn-icons-png.flaticon.com/32/124/124021.png" alt="Twitter"></a>
                </div>
            </div>
        </div>
        <p class="footer-bottom">&copy; 2025 Preloved | Semua Hak Dilindungi</p>
    </footer>

</body>
</html>