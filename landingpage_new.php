<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preloved - Platform Donasi & Jual Beli Pakaian</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #fff5f7;
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
            background: rgba(255, 255, 255, 0.95);
            padding: 20px 0;
            box-shadow: 0 2px 15px rgba(255, 182, 193, 0.2);
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
            font-size: 28px;
            font-weight: 700;
            color: #ff8da1;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo span {
            color: #ff6b88;
        }

        .nav-links {
            display: flex;
            gap: 30px;
        }

        .nav-links a {
            color: #ff8da1;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 25px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-links a:hover {
            background: #ff8da1;
            color: white;
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero {
            margin-top: 100px;
            padding: 80px 20px;
            text-align: center;
            background: linear-gradient(135deg, #fff5f7 0%, #ffe0e9 100%);
            border-radius: 0 0 50px 50px;
        }

        .hero h1 {
            font-size: 52px;
            color: #ff6b88;
            margin-bottom: 20px;
            animation: fadeInUp 1s ease;
            line-height: 1.2;
        }

        .hero p {
            font-size: 20px;
            color: #ff8da1;
            margin-bottom: 40px;
            animation: fadeInUp 1s ease 0.2s;
            animation-fill-mode: both;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Features Section */
        .features {
            padding: 80px 0;
            background: white;
        }

        .section-title {
            text-align: center;
            color: #ff6b88;
            font-size: 36px;
            margin-bottom: 50px;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: #ff8da1;
            border-radius: 2px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            margin-top: 40px;
        }

        .feature-card {
            background: white;
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(255, 182, 193, 0.15);
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 182, 193, 0.2);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(255, 182, 193, 0.25);
        }

        .feature-icon {
            font-size: 50px;
            color: #ff8da1;
            margin-bottom: 25px;
        }

        .feature-card h3 {
            color: #ff6b88;
            margin-bottom: 15px;
            font-size: 22px;
        }

        .feature-card p {
            color: #ff8da1;
            line-height: 1.6;
            font-size: 16px;
        }

        /* CTA Section */
        .cta {
            text-align: center;
            padding: 100px 20px;
            background: linear-gradient(135deg, #ff8da1 0%, #ff6b88 100%);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .cta::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><circle cx="2" cy="2" r="2" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
            opacity: 0.1;
        }

        .cta h2 {
            font-size: 42px;
            margin-bottom: 20px;
            position: relative;
        }

        .cta p {
            font-size: 18px;
            margin-bottom: 40px;
            opacity: 0.9;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            position: relative;
        }

        .btn {
            display: inline-block;
            padding: 15px 40px;
            background: white;
            color: #ff8da1;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            font-size: 18px;
        }

        .btn:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(255, 182, 193, 0.4);
            background: #fff5f5;
        }

        /* Footer */
        .footer {
            background: #ff8da1;
            color: white;
            padding: 60px 0 30px;
            margin-top: auto;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-section h3 {
            margin-bottom: 25px;
            font-size: 20px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-section h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 30px;
            height: 2px;
            background: white;
        }

        .footer-section p {
            opacity: 0.9;
            line-height: 1.8;
            margin-bottom: 15px;
        }

        .footer-section a {
            color: white;
            text-decoration: none;
            opacity: 0.9;
            display: block;
            margin-bottom: 12px;
            transition: all 0.3s ease;
        }

        .footer-section a:hover {
            opacity: 1;
            transform: translateX(5px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
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

            .section-title {
                font-size: 28px;
            }

            .cta h2 {
                font-size: 32px;
            }
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1100;
            opacity: 0;
            transition: opacity 0.3s ease;
            overflow-y: auto;
            padding: 20px 0;
        }

        .modal.show {
            display: flex;
            opacity: 1;
            align-items: flex-start;
        }

        .modal-content {
            background: white;
            width: 90%;
            max-width: 400px;
            margin: 20px auto;
            border-radius: 20px;
            padding: 30px;
            position: relative;
            transform: translateY(-20px);
            transition: transform 0.3s ease;
            box-shadow: 0 10px 30px rgba(255, 182, 193, 0.3);
        }

        .modal.show .modal-content {
            transform: translateY(0);
        }

        .close-modal {
            position: absolute;
            right: 20px;
            top: 20px;
            font-size: 24px;
            color: #ff8da1;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .close-modal:hover {
            background: #fff5f7;
            transform: rotate(90deg);
        }

        .modal-title {
            color: #ff6b88;
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #ff8da1;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ffe0e9;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #ff8da1;
            box-shadow: 0 0 0 3px rgba(255, 141, 161, 0.1);
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background: #ff8da1;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            background: #ff6b88;
            transform: translateY(-2px);
        }

        .modal-footer {
            text-align: center;
            margin-top: 20px;
            color: #ff8da1;
        }

        .modal-footer a {
            color: #ff6b88;
            text-decoration: none;
            font-weight: 500;
        }

        .modal-footer a:hover {
            text-decoration: underline;
        }

        .form-error {
            color: #ff4757;
            font-size: 14px;
            margin-top: 5px;
            display: none;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .shake {
            animation: shake 0.5s ease-in-out;
        }

        /* Tambahkan CSS baru untuk file input dan textarea */
        .form-control.textarea {
            min-height: 100px;
            resize: vertical;
        }

        .file-input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .file-input-group input[type="file"] {
            display: none;
        }

        .file-input-label {
            display: block;
            padding: 12px 15px;
            background: #fff5f7;
            border: 2px dashed #ff8da1;
            border-radius: 10px;
            text-align: center;
            color: #ff8da1;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-input-label:hover {
            background: #ffe0e9;
            border-color: #ff6b88;
        }

        .file-name {
            margin-top: 8px;
            font-size: 14px;
            color: #ff8da1;
        }

        .preview-image {
            max-width: 100px;
            max-height: 100px;
            margin-top: 10px;
            border-radius: 50%;
            display: none;
            object-fit: cover;
        }

        /* Update form max-height jika diperlukan */
        #registerForm {
            max-height: calc(100vh - 160px);
            overflow-y: auto;
            padding-right: 10px;
        }

        #registerForm::-webkit-scrollbar {
            width: 8px;
        }

        #registerForm::-webkit-scrollbar-track {
            background: #fff5f7;
            border-radius: 4px;
        }

        #registerForm::-webkit-scrollbar-thumb {
            background: #ff8da1;
            border-radius: 4px;
        }

        #registerForm::-webkit-scrollbar-thumb:hover {
            background: #ff6b88;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <nav class="nav">
                <a href="#" class="logo">Pre<span>loved</span></a>
                <div class="nav-links">
                    <a href="#features">Fitur</a>
                    <a href="#about">Tentang</a>
                    <a href="#" onclick="openModal('loginModal'); return false;">Masuk</a>
                    <a href="#" onclick="openModal('registerModal'); return false;">Daftar</a>
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Selamat Datang di Preloved</h1>
            <p>Platform donasi dan jual beli pakaian bekas berkualitas yang menghubungkan donatur dengan mereka yang membutuhkan</p>
            <a href="auth/register.php" class="btn">Mulai Sekarang</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <h2 class="section-title">Fitur Unggulan</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🔄</div>
                    <h3>Donasi Pakaian</h3>
                    <p>Berikan pakaian layak pakai Anda untuk mereka yang membutuhkan dengan mudah dan aman</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">💰</div>
                    <h3>Jual Beli</h3>
                    <p>Temukan pakaian berkualitas dengan harga terjangkau dan proses yang aman</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🌱</div>
                    <h3>Ramah Lingkungan</h3>
                    <p>Berkontribusi dalam mengurangi limbah tekstil dan menjaga kelestarian lingkungan</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2>Bergabung Bersama Kami</h2>
            <p>Mari kita bersama-sama membuat perubahan positif melalui donasi dan jual beli pakaian bekas. Setiap kontribusi Anda sangat berarti.</p>
            <a href="auth/register.php" class="btn">Daftar Sekarang</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Tentang Preloved</h3>
                    <p>Platform donasi dan jual beli pakaian bekas yang menghubungkan donatur dengan penerima manfaat. Kami berkomitmen untuk membuat perubahan positif dalam masyarakat.</p>
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
                    <p>Alamat: Jakarta, Indonesia</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Preloved. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Login Modal -->
    <div class="modal" id="loginModal">
        <div class="modal-content">
            <button class="close-modal" onclick="closeModal('loginModal')">&times;</button>
            <h2 class="modal-title">Masuk ke Preloved</h2>
            <form id="loginForm" onsubmit="handleLogin(event)">
                <div class="form-group">
                    <label for="loginEmail">Email</label>
                    <input type="email" id="loginEmail" class="form-control" required>
                    <div class="form-error">Email tidak valid</div>
                </div>
                <div class="form-group">
                    <label for="loginPassword">Password</label>
                    <input type="password" id="loginPassword" class="form-control" required>
                    <div class="form-error">Password minimal 6 karakter</div>
                </div>
                <button type="submit" class="submit-btn">Masuk</button>
                <div class="modal-footer">
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
            <form id="registerForm" onsubmit="handleRegister(event)" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="registerUsername">Username</label>
                    <input type="text" id="registerUsername" class="form-control" required>
                    <div class="form-error">Username harus diisi</div>
                </div>
                <div class="form-group">
                    <label for="registerName">Nama Lengkap</label>
                    <input type="text" id="registerName" class="form-control" required>
                    <div class="form-error">Nama lengkap harus diisi</div>
                </div>
                <div class="form-group">
                    <label for="registerEmail">Email</label>
                    <input type="email" id="registerEmail" class="form-control" required>
                    <div class="form-error">Email tidak valid</div>
                </div>
                <div class="form-group">
                    <label for="registerPassword">Password</label>
                    <input type="password" id="registerPassword" class="form-control" required>
                    <div class="form-error">Password minimal 6 karakter</div>
                </div>
                <div class="form-group">
                    <label for="registerAddress">Alamat</label>
                    <textarea id="registerAddress" class="form-control textarea" required></textarea>
                    <div class="form-error">Alamat harus diisi</div>
                </div>
                <div class="form-group">
                    <label for="registerPhone">Nomor Telepon</label>
                    <input type="tel" id="registerPhone" class="form-control" required>
                    <div class="form-error">Nomor telepon tidak valid</div>
                </div>
                <div class="form-group">
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
                </div>
                <input type="hidden" id="registerDate" value="">
                <button type="submit" class="submit-btn">Daftar</button>
                <div class="modal-footer">
                    Sudah punya akun? <a href="#" onclick="switchModal('registerModal', 'loginModal')">Masuk</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Modal functions
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('show');
            document.body.style.overflow = '';
        }

        function switchModal(fromModalId, toModalId) {
            closeModal(fromModalId);
            setTimeout(() => openModal(toModalId), 300);
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                closeModal(event.target.id);
            }
        }

        // Form validation and submission
        function handleLogin(event) {
            event.preventDefault();
            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;
            
            // Basic validation
            if (!validateEmail(email)) {
                showError('loginEmail', 'Email tidak valid');
                return;
            }
            
            if (password.length < 6) {
                showError('loginPassword', 'Password minimal 6 karakter');
                return;
            }

            // Here you would typically make an AJAX call to your login endpoint
            console.log('Login attempt:', { email, password });
            // Simulate successful login
            window.location.href = 'dashboard.php';
        }

        function handleRegister(event) {
            event.preventDefault();
            const username = document.getElementById('registerUsername').value;
            const name = document.getElementById('registerName').value;
            const email = document.getElementById('registerEmail').value;
            const password = document.getElementById('registerPassword').value;
            const address = document.getElementById('registerAddress').value;
            const phone = document.getElementById('registerPhone').value;
            const photo = document.getElementById('registerPhoto').files[0];
            const registerDate = new Date().toISOString().split('T')[0];
            
            // Basic validation
            if (!username.trim()) {
                showError('registerUsername', 'Username harus diisi');
                return;
            }

            if (!name.trim()) {
                showError('registerName', 'Nama lengkap harus diisi');
                return;
            }

            if (!validateEmail(email)) {
                showError('registerEmail', 'Email tidak valid');
                return;
            }

            if (password.length < 6) {
                showError('registerPassword', 'Password minimal 6 karakter');
                return;
            }

            if (!address.trim()) {
                showError('registerAddress', 'Alamat harus diisi');
                return;
            }

            if (!validatePhone(phone)) {
                showError('registerPhone', 'Nomor telepon tidak valid');
                return;
            }

            if (!photo) {
                showError('registerPhoto', 'Pilih foto profil');
                return;
            }

            // Create FormData object for file upload
            const formData = new FormData();
            formData.append('username', username);
            formData.append('name', name);
            formData.append('email', email);
            formData.append('password', password);
            formData.append('address', address);
            formData.append('phone', phone);
            formData.append('photo', photo);
            formData.append('register_date', registerDate);

            // Here you would typically make an AJAX call to your register endpoint
            console.log('Register attempt:', formData);
            // Simulate successful registration
            window.location.href = 'dashboard.php';
        }

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        function validatePhone(phone) {
            const re = /^[0-9]{10,13}$/;
            return re.test(phone.replace(/[-\s]/g, ''));
        }

        function showError(inputId, message) {
            const input = document.getElementById(inputId);
            const errorDiv = input.nextElementSibling;
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
            input.classList.add('shake');
            
            setTimeout(() => {
                input.classList.remove('shake');
            }, 500);
        }

        // Add file input preview handler
        document.getElementById('registerPhoto').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const fileName = document.querySelector('.file-name');
            const preview = document.querySelector('.preview-image');
            const labelText = document.querySelector('.label-text');

            if (file) {
                fileName.textContent = file.name;
                labelText.textContent = 'Ganti Foto';
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                fileName.textContent = '';
                labelText.textContent = 'Pilih Foto';
                preview.style.display = 'none';
            }
        });
    </script>
</body>
</html>