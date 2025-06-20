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
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../frontend/style_landingpage.css?v=<?=time()?>">
</head>

<body>

    <!-- Header / Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="#home">
                <i class="fas fa-heart me-2"></i>Prelove969
            </a>
            
            <!-- Mobile Toggle Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Navigation Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-4">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">Testimoni</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Kontak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../auth/login.php">Login</a>
                    </li>
                </ul>
                <a href="../auth/register.php" class="btn btn-custom-primary">Daftar</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 order-2 order-lg-1">
                    <h1 class="hero-title">
                        Berikan <span style="color: var(--primary-color);">Hidup Kedua</span> untuk Pakaian Anda
                    </h1>
                    <p class="hero-subtitle">
                        Platform terpercaya untuk menjual, membeli, dan mendonasikan pakaian preloved. 
                        Wujudkan fashion berkelanjutan sambil membantu sesama.
                    </p>
                </div>
                
                <div class="col-lg-6 order-1 order-lg-2">
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
    <section id="features" class="features-section">
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
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials-section">
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
    <footer id="contact" class="footer">
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
                        <a href="https://www.facebook.com/share/1XzLJfgcLX/"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/fitrinufaa/"><i class="fab fa-instagram"></i></a>
                        <a href="https://x.com/abcdefghizat?t=I1bFvtcr13sZmiJkmFLiLg&s=08"><i class="fab fa-twitter"></i></a>
                        <a href="https://wa.me//6285337235764"><i class="fab fa-whatsapp"></i></a>
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

      <!-- Login Modal -->
    <div class="modal" id="loginModal">
        <div class="modal-content">
            <button class="close-modal" method="POST" onclick="closeModal('loginModal')">&times;</button>
            <h2 class="modal-title">Masuk ke Preloved</h2>
            <form id="loginForm" action="../auth/login.php" method="POST">
                <div class="form-group">
                    <label for="loginUsername" class="form-label">Username</label>
                    <input type="text" class="form-control" id="loginUsername" name="username" placeholder="masukkan username" required>
                    <div class="error-message" id="loginUsernameError"></div>
                </div>
                <div class="form-group">
                    <label for="loginPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="loginPassword" name="password" placeholder="masukkan password" required>
                    <div class="error-message" id="loginPasswordError"></div>
                </div>
                <button type="submit" class="btn btn-auth">
                    <i class="fas fa-sign-in-alt me-2"></i>Masuk
                </button>
                <div class="modal-footer" style="text-align:center !important; width:100%; display:block !important;">
                    Belum punya akun? <a href="#" onclick="switchModal('loginModal', 'registerModal')">Daftar</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal" id="registerModal">
        <div class="modal-content">
            <button class="close-modal" onclick="closeModal('registerModal')">&times;</button>
            <h2 class="modal-title">Daftar Akun Baru</h2>
            <form id="registerForm" action="../auth/register.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="registerUsername">Username</label>
                    <input type="text" id="registerUsername" name="username" class="form-control" required>
                    <div class="form-error">Username harus diisi</div>
                </div>
                <div class="form-group">
                    <label for="registerName">Nama Lengkap</label>
                    <input type="text" id="registerName" name="name" class="form-control" required>
                    <div class="form-error">Nama lengkap harus diisi</div>
                </div>
                <div class="form-group">
                    <label for="registerEmail">Email</label>
                    <input type="email" id="registerEmail" name="email" class="form-control" required>
                    <div class="form-error">Email tidak valid</div>
                </div>
                <div class="form-group">
                    <label for="registerPassword">Password</label>
                    <input type="password" id="registerPassword" name="password" class="form-control" required>
                    <div class="form-error">Password minimal 6 karakter</div>
                </div>
                <div class="form-group">
                    <label for="registerAddress">Alamat</label>
                    <textarea id="registerAddress" name="address" class="form-control textarea" required></textarea>
                    <div class="form-error">Alamat harus diisi</div>
                </div>
                <div class="form-group">
                    <label for="registerPhone">Nomor Telepon</label>
                    <input type="tel" id="registerPhone" name="phone" class="form-control" required>
                    <div class="form-error">Nomor telepon tidak valid</div>
                </div>
                <!-- <div class="form-group">
                    <label>Foto Profil</label>
                    <div class="file-input-group">
                        <label for="registerPhoto" class="file-input-label">
                            <span class="label-text">Pilih Foto</span>
                        </label>
                        <input type="file" id="registerPhoto" accept="image/*" required>
                        <div class="file-name"></div>
                        <img src="" alt="Preview" class="preview-image">
                        <div class="form-error">Pilih foto profil</div>
                    </div>
                </div> -->
                <input type="hidden" id="registerDate" value="">
                <button type="submit" class="submit-btn">Daftar</button>
                <div class="modal-footer" style="text-align:center !important; width:100%; display:block !important;">
                    Sudah punya akun? <a href="#" onclick="switchModal('registerModal', 'loginModal')">Masuk</a>
                </div>
            </form>
        </div>
    </div>


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

        const statsSection = document.querySelector('.stats-section');
        if (statsSection) {
            observer.observe(statsSection);
        }
    </script>

</body>
</html>