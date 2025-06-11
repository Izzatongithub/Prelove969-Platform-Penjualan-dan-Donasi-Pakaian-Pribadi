<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prelove969 - Platform Penjualan dan Donasi Pakaian Pribadi</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* Custom CSS Variables untuk Warna */
        :root {
            --primary-color: #ff6b9d;
            --secondary-color: #a8e6cf;
            --accent-color: #ffd93d;
            --light-pink: #ffe4e8;
            --light-green: #e8f5e8;
            --light-purple: #f0e8ff;
            --text-dark: #2c3e50;
            --text-light: #6c757d;
        }
        
        /* Font Family */
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
        }
        
        /* Header Styling */
        .navbar {
            padding: 0; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            background-color: white !important; 
            position: static;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--primary-color) !important;
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--text-dark) !important;
            margin: 0 0.5rem;
            transition: color 0.3s ease;
            padding: 0.5em 0.75em;
        }
        
        .nav-link:hover {
            color: var(--primary-color) !important;
        }
        
        .btn-custom-primary {
            background: linear-gradient(45deg, var(--primary-color), #ff8fab);
            border: none;
            color: white;
            padding: 0.7rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-custom-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 157, 0.4);
            color: white;
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--light-pink) 0%, var(--light-purple) 50%, var(--light-green) 100%);
            min-height: 80vh;
            display: flex;
            align-items: center;
            padding: 4rem 0;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }
        
        .hero-subtitle {
            font-size: 1.3rem;
            color: var(--text-light);
            margin-bottom: 2.5rem;
            line-height: 1.6;
        }
        
        .hero-illustration {
            text-align: center;
            position: relative;
        }
        
        .hero-circle {
            width: 300px;
            height: 300px;
            background: linear-gradient(45deg, var(--light-pink), var(--light-purple));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            animation: float 3s ease-in-out infinite;
        }
        
        .hero-circle i {
            font-size: 5rem;
            color: var(--text-light);
        }
        
        /* Animasi Float */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        /* Tombol CTA Hero
        .btn-cta-sell {
            background: linear-gradient(45deg, var(--primary-color), #ff8fab);
            border: none;
            color: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            margin: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .btn-cta-donate {
            background: linear-gradient(45deg, var(--secondary-color), #7fcdcd);
            border: none;
            color: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            margin: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .btn-cta-browse {
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            margin: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .btn-cta-sell:hover, .btn-cta-donate:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            color: white;
        }
        
        .btn-cta-browse:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-3px);
        } */
        
        /* Features Section */
        .features-section {
            padding: 5rem 0;
            background-color: #f8f9fa;
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 1rem;
        }
        
        .section-subtitle {
            font-size: 1.2rem;
            color: var(--text-light);
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem 2rem;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            height: 100%;
            border: none;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
        }
        
        .feature-icon.sell {
            background: linear-gradient(45deg, var(--primary-color), #ff8fab);
        }
        
        .feature-icon.donate {
            background: linear-gradient(45deg, var(--secondary-color), #7fcdcd);
        }
        
        .feature-icon.browse {
            background: linear-gradient(45deg, var(--accent-color), #ffed4e);
        }
        
        .feature-title {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .feature-description {
            color: var(--text-light);
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }
        
        /* .btn-feature {
            border-radius: 50px;
            padding: 0.7rem 1.5rem;
            font-weight: 600;
            border: none;
        }
        
        .btn-feature.sell {
            background-color: rgba(255, 107, 157, 0.1);
            color: var(--primary-color);
        }
        
        .btn-feature.donate {
            background-color: rgba(168, 230, 207, 0.1);
            color: var(--secondary-color);
        }
        
        .btn-feature.browse {
            background-color: rgba(255, 217, 61, 0.1);
            color: #e6c200;
        } */
        
        /* Stats Section */
        .stats-section {
            background: linear-gradient(45deg, var(--primary-color), #8b5cf6);
            color: white;
            padding: 4rem 0;
        }
        
        .stat-item {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        /* Testimonials Section */
        .testimonials-section {
            padding: 5rem 0;
            background-color: white;
        }
        
        .testimonial-card {
            background: #f8f9fa;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: none;
            transition: transform 0.3s ease;
        }
        
        .testimonial-card:hover {
            transform: translateY(-5px);
        }
        
        .testimonial-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: white;
            font-size: 1.5rem;
        }
        
        .testimonial-name {
            font-weight: 600;
            margin-bottom: 0.2rem;
        }
        
        .testimonial-role {
            color: var(--text-light);
            font-size: 0.9rem;
        }
        
        .testimonial-text {
            font-style: italic;
            color: var(--text-light);
            margin-top: 1rem;
            line-height: 1.6;
        }
        
        /* Footer */
        .footer {
            background-color: #2c3e50;
            color: white;
            padding: 3rem 0 2rem;
        }
        
        .footer-logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .footer-description {
            color: #bdc3c7;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }
        
        .social-links a {
            display: inline-block;
            width: 40px;
            height: 40px;
            background-color: #34495e;
            color: white;
            text-align: center;
            line-height: 40px;
            border-radius: 50%;
            margin-right: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background-color: var(--primary-color);
            transform: translateY(-2px);
        }
        
        .footer-title {
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 0.5rem;
        }
        
        .footer-links a {
            color: #bdc3c7;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-links a:hover {
            color: var(--primary-color);
        }
        
        .footer-bottom {
            border-top: 1px solid #34495e;
            margin-top: 2rem;
            padding-top: 1.5rem;
            text-align: center;
            color: #bdc3c7;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .hero-circle {
                width: 250px;
                height: 250px;
            }
            
            .hero-circle i {
                font-size: 4rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .btn-cta-sell, .btn-cta-donate, .btn-cta-browse {
                display: block;
                width: 100%;
                margin: 0.5rem 0;
            }
        }
    </style>
</head>
<body>

    <!-- Header / Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="#">
                <i class="#"></i>Prelove969
            </a>
            
            <!-- Mobile Toggle Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Navigation Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-4">
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#jual">Jual</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#donasi">Donasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#kategori">Kategori</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="#login">Login</a>
                    </li>
                </ul>
                <!-- CTA Button -->
                <button class="btn btn-custom-primary">Register</button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="hero-title">
                        Berikan <span style="color: var(--primary-color);">Hidup Kedua</span> untuk Pakaian Anda
                    </h1>
                    <p class="hero-subtitle">
                        Platform terpercaya untuk menjual, membeli, dan mendonasikan pakaian preloved. 
                        Wujudkan fashion berkelanjutan sambil membantu sesama.
                    </p>
                    
                    <!-- CTA Buttons
                    <div class="d-flex flex-wrap">
                        <button class="btn btn-cta-sell">
                            <i class="fas fa-plus me-2"></i>Jual Pakaian
                        </button>
                        <button class="btn btn-cta-donate">
                            <i class="fas fa-heart me-2"></i>Donasikan Sekarang
                        </button>
                        <button class="btn btn-cta-browse">
                            <i class="fas fa-search me-2"></i>Telusuri Produk
                        </button>
                    </div>
                </div> -->
                
                <div class="col-lg-6">
                    <div class="hero-illustration">
                        <div class="hero-circle">
                            <i class="fas fa-tshirt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <h2 class="section-title">Fitur Utama Prelove969</h2>
            <p class="section-subtitle">
                Tiga cara mudah untuk berpartisipasi dalam gerakan fashion berkelanjutan
            </p>
            
            <div class="row">
                <!-- Feature 1: Jual -->
                <div class="col-md-4 mb-4">
                    <div class="card feature-card">
                        <div class="feature-icon sell">
                            <i class="fas fa-tags"></i>
                        </div>
                        <h3 class="feature-title">Jual Pakaian Bekas</h3>
                        <p class="feature-description">
                            Ubah pakaian yang sudah tidak terpakai menjadi penghasilan tambahan. 
                            Proses mudah, aman, dan menguntungkan.
                        </p>
                        <!-- <button class="btn btn-feature sell">Mulai Jual</button> -->
                    </div>
                </div>
                
                <!-- Feature 2: Donasi -->
                <div class="col-md-4 mb-4">
                    <div class="card feature-card">
                        <div class="feature-icon donate">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>
                        <h3 class="feature-title">Donasi ke Lembaga Sosial</h3>
                        <p class="feature-description">
                            Berbagi kebaikan dengan mendonasikan pakaian layak pakai 
                            ke lembaga sosial terpercaya.
                        </p>
                        <!-- <button class="btn btn-feature donate">Donasi Sekarang</button> -->
                    </div>
                </div>
                
                <!-- Feature 3: Jelajahi -->
                <div class="col-md-4 mb-4">
                    <div class="card feature-card">
                        <div class="feature-icon browse">
                            <i class="fas fa-gem"></i>
                        </div>
                        <h3 class="feature-title">Jelajahi Koleksi Unik</h3>
                        <p class="feature-description">
                            Temukan pakaian preloved berkualitas dengan harga terjangkau. 
                            Fashion unik yang ramah lingkungan.
                        </p>
                        <!-- <button class="btn btn-feature browse">Jelajahi Sekarang</button> -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number">300+</div>
                        <div class="stat-label">Pakaian Didonasikan</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number">150+</div>
                        <div class="stat-label">Keluarga Terbantu</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Produk Terjual</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number">1000+</div>
                        <div class="stat-label">Pengguna Aktif</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <div class="container">
            <h2 class="section-title">Kata Mereka</h2>
            <p class="section-subtitle">Pengalaman nyata pengguna Prelove969</p>
            
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="card testimonial-card">
                        <div class="d-flex align-items-center mb-3">
                            <div class="testimonial-avatar" style="background: linear-gradient(45deg, var(--primary-color), #ff8fab);">
                                S
                            </div>
                            <div class="ms-3">
                                <div class="testimonial-name">Sari Nurhaliza</div>
                                <div class="testimonial-role">Ibu Rumah Tangga</div>
                            </div>
                        </div>
                        <p class="testimonial-text">
                            "Senang bisa membantu sesama melalui donasi pakaian. Prosesnya mudah dan transparan!"
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="card testimonial-card">
                        <div class="d-flex align-items-center mb-3">
                            <div class="testimonial-avatar" style="background: linear-gradient(45deg, var(--secondary-color), #7fcdcd);">
                                R
                            </div>
                            <div class="ms-3">
                                <div class="testimonial-name">Rina Maharani</div>
                                <div class="testimonial-role">Mahasiswa</div>
                            </div>
                        </div>
                        <p class="testimonial-text">
                            "Berhasil dapat outfit bagus dengan harga terjangkau. Kualitas pakaian juga masih sangat baik."
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="card testimonial-card">
                        <div class="d-flex align-items-center mb-3">
                            <div class="testimonial-avatar" style="background: linear-gradient(45deg, var(--accent-color), #ffed4e);">
                                D
                            </div>
                            <div class="ms-3">
                                <div class="testimonial-name">Doni Prakoso</div>
                                <div class="testimonial-role">Karyawan</div>
                            </div>
                        </div>
                        <p class="testimonial-text">
                            "Platform yang luar biasa! Bisa dapat penghasilan tambahan dari pakaian yang sudah tidak terpakai."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <!-- Company Info -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="footer-logo">
                        <i class="fas fa-heart me-2"></i>Prelove969
                    </div>
                    <p class="footer-description">
                        Platform terpercaya untuk menjual, membeli, dan mendonasikan pakaian preloved. 
                        Bersama menciptakan fashion berkelanjutan untuk masa depan yang lebih baik.
                    </p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="footer-title">Tautan Cepat</h5>
                    <ul class="footer-links">
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="#">Cara Kerja</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                
                <!-- Categories -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="footer-title">Kategori</h5>
                    <ul class="footer-links">
                        <li><a href="#">Pakaian Wanita</a></li>
                        <li><a href="#">Pakaian Pria</a></li>
                        <li><a href="#">Pakaian Anak</a></li>
                        <li><a href="#">Aksesoris</a></li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5 class="footer-title">Kontak</h5>
                    <div class="contact-info">
                        <p><i class="fas fa-envelope me-2"></i> info@prelove969.com</p>
                        <p><i class="fas fa-phone me-2"></i> +62 85-3372-35764</p>
                        <p><i class="fas fa-map-marker-alt me-2"></i> Mataram, Indonesia</p>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2025 Prelove969. Semua hak cipta dilindungi undang-undang.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Smooth scrolling untuk navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar background change on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.backgroundColor = 'rgba(255, 255, 255, 0.95)';
                navbar.style.backdropFilter = 'blur(10px)';
            } else {
                navbar.style.backgroundColor = 'white';
                navbar.style.backdropFilter = 'none';
            }
        });

        // Counter animation untuk stats
        function animateCounters() {
            const counters = document.querySelectorAll('.stat-number');
            
            counters.forEach(counter => {
                const target = parseInt(counter.textContent.replace('+', ''));
                let current = 0;
                const increment = target / 100;
                
                const updateCounter = () => {
                    if (current < target) {
                        current += increment;
                        counter.textContent = Math.ceil(current) + '+';
                        setTimeout(updateCounter, 20);
                    } else {
                        counter.textContent = target + '+';
                    }
                };
                
                updateCounter();
            });
        }

        // Trigger counter animation when stats section is visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    observer.unobserve(entry.target);
                }
            });
        });

        observer.observe(document.querySelector('.stats-section'));
    </script>

</body>
</html>