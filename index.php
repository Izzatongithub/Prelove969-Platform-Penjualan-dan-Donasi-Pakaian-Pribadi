<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preloved - Platform Donasi & Jual Beli Pakaian</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #fff5f5 0%, #ffe0e9 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header Styles */
        .header {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(255, 182, 193, 0.2);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #ff8da1;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 20px;
        }

        .nav-links a {
            color: #ff8da1;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .nav-links a:hover {
            background: #ff8da1;
            color: white;
        }

        /* Hero Section */
        .hero {
            margin-top: 80px;
            text-align: center;
            padding: 60px 20px;
        }

        .hero h1 {
            font-size: 48px;
            color: #ff8da1;
            margin-bottom: 20px;
            animation: fadeInUp 1s ease;
        }

        .hero p {
            font-size: 20px;
            color: #ff6b88;
            margin-bottom: 40px;
            animation: fadeInUp 1s ease 0.2s;
            animation-fill-mode: both;
        }

        /* Features Section */
        .features {
            padding: 60px 0;
            background: rgba(255, 255, 255, 0.9);
        }

        .features h2 {
            color: #ff8da1;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .feature-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(255, 182, 193, 0.2);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .feature-icon {
            font-size: 40px;
            color: #ff8da1;
            margin-bottom: 20px;
        }

        .feature-card h3 {
            color: #ff6b88;
            margin-bottom: 15px;
        }

        .feature-card p {
            color: #ff8da1;
            line-height: 1.6;
        }

        /* CTA Section */
        .cta {
            text-align: center;
            padding: 80px 20px;
            background: linear-gradient(135deg, #ff8da1 0%, #ff6b88 100%);
            color: white;
        }

        .cta h2 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .cta p {
            font-size: 18px;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .btn {
            display: inline-block;
            padding: 15px 30px;
            background: white;
            color: #ff8da1;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(255, 182, 193, 0.4);
            background: #fff5f5;
        }

        /* Footer */
        .footer {
            background: #ff8da1;
            color: white;
            padding: 40px 0;
            margin-top: auto;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .footer-section h3 {
            margin-bottom: 20px;
        }

        .footer-section p {
            opacity: 0.8;
            line-height: 1.6;
        }

        .footer-section a {
            color: white;
            text-decoration: none;
            opacity: 0.8;
            display: block;
            margin-bottom: 10px;
        }

        .footer-section a:hover {
            opacity: 1;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 36px;
            }
            
            .hero p {
                font-size: 18px;
            }

            .nav {
                flex-direction: column;
                gap: 20px;
            }

            .nav-links {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <nav class="nav">
                <a href="#" class="logo">Preloved</a>
                <div class="nav-links">
                    <a href="#features">Fitur</a>
                    <a href="#about">Tentang</a>
                    <a href="auth/login.php">Masuk</a>
                    <a href="auth/register.php">Daftar</a>
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Selamat Datang di Preloved</h1>
            <p>Platform donasi dan jual beli pakaian bekas berkualitas</p>
            <a href="auth/register.php" class="btn">Mulai Sekarang</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <h2 style="text-align: center; margin-bottom: 20px;">Fitur Unggulan</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🔄</div>
                    <h3>Donasi Pakaian</h3>
                    <p>Berikan pakaian layak pakai Anda untuk mereka yang membutuhkan</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">💰</div>
                    <h3>Jual Beli</h3>
                    <p>Temukan pakaian berkualitas dengan harga terjangkau</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🌱</div>
                    <h3>Ramah Lingkungan</h3>
                    <p>Berkontribusi dalam mengurangi limbah tekstil</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2>Bergabung Bersama Kami</h2>
            <p>Mari kita bersama-sama membuat perubahan positif melalui donasi dan jual beli pakaian bekas</p>
            <a href="auth/register.php" class="btn">Daftar Sekarang</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Tentang Preloved</h3>
                    <p>Platform donasi dan jual beli pakaian bekas yang menghubungkan donatur dengan penerima manfaat.</p>
                </div>
                <div class="footer-section">
                    <h3>Link Cepat</h3>
                    <a href="#features">Fitur</a>
                    <a href="#about">Tentang</a>
                    <a href="auth/login.php">Masuk</a>
                    <a href="auth/register.php">Daftar</a>
                </div>
                <div class="footer-section">
                    <h3>Kontak</h3>
                    <p>Email: info@preloved.com</p>
                    <p>Telepon: (021) 1234-5678</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>