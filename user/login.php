<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prelove969 - Login & Register</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../frontend/style_login.css">
</head>
<body>

    <!-- Back to Home Button -->
    <a href="#" class="back-home" onclick="goHome()">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
    </a>

    <!-- Login Page -->
    <div id="loginPage" class="page active page-login">
        <div class="auth-container">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="auth-card">
                            <div class="row g-0">
                                <!-- Left Side - Illustration -->
                                <div class="col-lg-5">
                                    <div class="auth-left">
                                        <div class="auth-logo">
                                            <i class="fas fa-heart me-2"></i>Prelove969
                                        </div>
                                        <div class="auth-illustration">
                                            <i class="fas fa-user-circle"></i>
                                        </div>
                                        <h2 class="auth-title">Selamat Datang Kembali!</h2>
                                        <p class="auth-subtitle">
                                            Masuk ke akun Anda untuk mulai menjual, membeli, atau mendonasikan pakaian preloved.
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Right Side - Login Form -->
                                <div class="col-lg-7">
                                    <div class="auth-right">
                                        <h2 class="form-title">Masuk</h2>
                                        <p class="form-subtitle">Masukkan detail akun Anda untuk melanjutkan</p>
                                        
                                        <div class="success-message" id="loginSuccess">
                                            <i class="fas fa-check-circle me-2"></i>Login berhasil! Mengarahkan ke dashboard...
                                        </div>
                                        
                                        <form id="loginForm" action="../auth/login.php" method="POST">
                                            <div class="form-group">
                                                <label for="loginUsername" class="form-label">Username</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-user"></i>
                                                    </span>
                                                    <input type="text" class="form-control" id="loginUsername" name="username" 
                                                           placeholder="masukkan username" required>
                                                </div>
                                                <div class="error-message" id="loginUsernameError"></div>
                                            </div>
                                            <!-- Password -->
                                            <div class="form-group">
                                                <label for="loginPassword" class="form-label">Password</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-lock"></i>
                                                    </span>
                                                    <input type="password" class="form-control" id="loginPassword" name="password" 
                                                           placeholder="masukkan password" required>
                                                    <button type="button" class="password-toggle" onclick="togglePassword('loginPassword')">
                                                        <i class="fas fa-eye" id="loginPasswordIcon"></i>
                                                    </button>
                                                </div>
                                                <div class="error-message" id="loginPasswordError"></div>
                                            </div>
                                            <!-- Remember Me & Forgot Password -->
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="rememberMe">
                                                    <label class="form-check-label" for="rememberMe">
                                                        Ingat saya
                                                    </label>
                                                </div>
                                                <a href="#" class="auth-link">Lupa Password?</a>
                                            </div>
                                            <!-- Submit Button -->
                                            <button type="submit" class="btn btn-auth">
                                                <i class="fas fa-sign-in-alt me-2"></i>Masuk
                                            </button>
                                        </form>
                                        
                                        <!-- Switch to Register -->
                                        <div class="text-center-auth">
                                            <p>Belum punya akun? 
                                                <a href="#" class="auth-link" onclick="switchPage('register')">Daftar sekarang</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Page -->
    <div id="registerPage" class="page page-register">
        <div class="auth-container">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="auth-card">
                            <div class="row g-0">
                                <!-- Left Side - Illustration -->
                                <div class="col-lg-5">
                                    <div class="auth-left">
                                        <div class="auth-logo">
                                            <i class="fas fa-heart me-2"></i>Prelove969
                                        </div>
                                        <div class="auth-illustration">
                                            <i class="fas fa-user-plus"></i>
                                        </div>
                                        <h2 class="auth-title">Bergabung dengan Kami!</h2>
                                        <p class="auth-subtitle">
                                            Daftar sekarang dan mulai berkontribusi dalam gerakan fashion berkelanjutan.
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Right Side - Register Form -->
                                <div class="col-lg-7">
                                    <div class="auth-right">
                                        <h2 class="form-title">Daftar</h2>
                                        <p class="form-subtitle">Buat akun baru untuk memulai</p>
                                        
                                        <div class="success-message" id="registerSuccess">
                                            <i class="fas fa-check-circle me-2"></i>Pendaftaran berhasil! Silakan masuk dengan akun Anda.
                                        </div>
                                        
                                        <form id="registerForm" novalidate>
                                            <!-- Full Name -->
                                            <div class="form-group">
                                                <label for="registerName" class="form-label">Nama Lengkap</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-user"></i>
                                                    </span>
                                                    <input type="text" class="form-control" id="registerName" name="name" 
                                                           placeholder="masukkan nama lengkap" required>
                                                </div>
                                                <div class="error-message" id="registerNameError"></div>
                                            </div>
                                            
                                            <!-- Email -->
                                            <div class="form-group">
                                                <label for="registerEmail" class="form-label">Email</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-envelope"></i>
                                                    </span>
                                                    <input type="email" class="form-control" id="registerEmail" name="email" 
                                                           placeholder="masukkan email" required>
                                                </div>
                                                <div class="error-message" id="registerEmailError"></div>
                                            </div>
                                            
                                            <!-- Password -->
                                            <div class="form-group">
                                                <label for="registerPassword" class="form-label">Password</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-lock"></i>
                                                    </span>
                                                    <input type="password" class="form-control" id="registerPassword" name="password" 
                                                           placeholder="minimal 6 karakter" required>
                                                    <button type="button" class="password-toggle" onclick="togglePassword('registerPassword')">
                                                        <i class="fas fa-eye" id="registerPasswordIcon"></i>
                                                    </button>
                                                </div>
                                                <div class="error-message" id="registerPasswordError"></div>
                                            </div>
                                            
                                            <!-- Confirm Password -->
                                            <div class="form-group">
                                                <label for="confirmPassword" class="form-label">Konfirmasi Password</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-lock"></i>
                                                    </span>
                                                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" 
                                                           placeholder="ulangi password" required>
                                                    <button type="button" class="password-toggle" onclick="togglePassword('confirmPassword')">
                                                        <i class="fas fa-eye" id="confirmPasswordIcon"></i>
                                                    </button>
                                                </div>
                                                <div class="error-message" id="confirmPasswordError"></div>
                                            </div>
                                            
                                            <!-- Role Selection -->
                                            <div class="form-group">
                                                <label class="form-label">Pilih Peran Anda</label>
                                                <div class="role-selection">
                                                    <div class="role-option">
                                                        <input type="radio" id="roleSeller" name="role" value="seller" required>
                                                        <label for="roleSeller">
                                                            <i class="fas fa-tags role-icon"></i>
                                                            <div class="role-title">Penjual</div>
                                                            <div class="role-desc">Jual pakaian bekas</div>
                                                        </label>
                                                    </div>
                                                    <div class="role-option">
                                                        <input type="radio" id="roleDonor" name="role" value="donor" required>
                                                        <label for="roleDonor">
                                                            <i class="fas fa-hand-holding-heart role-icon"></i>
                                                            <div class="role-title">Pendonor</div>
                                                            <div class="role-desc">Donasi pakaian</div>
                                                        </label>
                                                    </div>
                                                    <div class="role-option">
                                                        <input type="radio" id="roleBuyer" name="role" value="buyer" required>
                                                        <label for="roleBuyer">
                                                            <i class="fas fa-shopping-bag role-icon"></i>
                                                            <div class="role-title">Pembeli</div>
                                                            <div class="role-desc">Beli pakaian preloved</div>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="error-message" id="registerRoleError"></div>
                                            </div>
                                            
                                            <!-- Terms & Conditions -->
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="acceptTerms" required>
                                                    <label class="form-check-label" for="acceptTerms">
                                                        Saya menyetujui <a href="#" class="auth-link">Syarat & Ketentuan</a> 
                                                        dan <a href="#" class="auth-link">Kebijakan Privasi</a>
                                                    </label>
                                                </div>
                                                <div class="error-message" id="acceptTermsError"></div>
                                            </div>
                                            
                                            <!-- Submit Button -->
                                            <button type="submit" class="btn btn-auth">
                                                <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                                            </button>
                                        </form>
                                        
                                        <!-- Switch to Login -->
                                        <div class="text-center-auth">
                                            <p>Sudah punya akun? 
                                                <a href="#" class="auth-link" onclick="switchPage('login')">Masuk sekarang</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Switch between login and register pages
        function switchPage(page) {
            const loginPage = document.getElementById('loginPage');
            const registerPage = document.getElementById('registerPage');
            
            if (page === 'login') {
                loginPage.classList.add('active');
                registerPage.classList.remove('active');
            } else {
                registerPage.classList.add('active');
                loginPage.classList.remove('active');
            }
            
            // Clear forms when switching
            clearForms();
        }
        
        // Go back to home
        function goHome() {
            // Dalam implementasi nyata, redirect ke homepage
            alert('Kembali ke beranda (implementasi redirect ke homepage)');
        }
        
        // Toggle password visibility
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(inputId + 'Icon');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
        
        // Clear all forms
        function clearForms() {
            document.getElementById('loginForm').reset();
            document.getElementById('registerForm').reset();
            clearValidations();
            hideMessages();
        }
        
        // Clear validation states
        function clearValidations() {
            const inputs = document.querySelectorAll('.form-control');
            const errors = document.querySelectorAll('.error-message');
            
            inputs.forEach(input => {
                input.classList.remove('is-valid', 'is-invalid');
            });
            
            errors.forEach(error => {
                error.style.display = 'none';
                error.textContent = '';
            });
        }
        
        // Hide success messages
        function hideMessages() {
            document.getElementById('loginSuccess').style.display = 'none';
            document.getElementById('registerSuccess').style.display = 'none';
        }
        
        // Show error message
        function showError(fieldId, message) {
            const field = document.getElementById(fieldId);
            const errorElement = document.getElementById(fieldId + 'Error');
            
            field.classList.add('is-invalid');
            field.classList.remove('is-valid');
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }
        
        // Show success state
        function showSuccess(fieldId) {
            const field = document.getElementById(fieldId);
            const errorElement = document.getElementById(fieldId + 'Error');
            
            field.classList.add('is-valid');
            field.classList.remove('is-invalid');
            errorElement.style.display = 'none';
        }
        
        // Validate email format
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
        
        // Login form validation
        function validateLogin() {
            let isValid = true;
            
            // Email validation
            const email = document.getElementById('loginUsername').value.trim();
            if (!email) {
                showError('loginUsername', 'Username harus diisi');
                isValid = false;
            } else if (email.includes('@') && !isValidEmail(email)) {
                showError('loginUsername', 'Format email tidak valid');
                isValid = false;
            } else {
                showSuccess('loginUsername');
            }
            
            // Password validation
            const password = document.getElementById('loginPassword').value;
            if (!password) {
                showError('loginPassword', 'Password harus diisi');
                isValid = false;
            } else if (password.length < 6) {
                showError('loginPassword', 'Password minimal 6 karakter');
                isValid = false;
            } else {
                showSuccess('loginPassword');
            }
            
            return isValid;
        }
        
        // Register form validation
        function validateRegister() {
            let isValid = true;
            
            // Name validation
            const name = document.getElementById('registerName').value.trim();
            if (!name) {
                showError('registerName', 'Nama lengkap harus diisi');
                isValid = false;
            } else if (name.length < 2) {
                showError('registerName', 'Nama minimal 2 karakter');
                isValid = false;
            } else {
                showSuccess('registerName');
            }
            
            // Email validation
            const email = document.getElementById('registerEmail').value.trim();
            if (!email) {
                showError('registerEmail', 'Email harus diisi');
                isValid = false;
            } else if (!isValidEmail(email)) {
                showError('registerEmail', 'Format email tidak valid');
                isValid = false;
            } else {
                showSuccess('registerEmail');
            }
            
            // Password validation
            const password = document.getElementById('registerPassword').value;
            if (!password) {
                showError('registerPassword', 'Password harus diisi');
                isValid = false;
            } else if (password.length < 6) {
                showError('registerPassword', 'Password minimal 6 karakter');
                isValid = false;
            } else {
                showSuccess('registerPassword');
            }
            
            // Confirm password validation
            const confirmPassword = document.getElementById('confirmPassword').value;
            if (!confirmPassword) {
                showError('confirmPassword', 'Konfirmasi password harus diisi');
                isValid = false;
            } else if (password !== confirmPassword) {
                showError('confirmPassword', 'Password tidak cocok');
                isValid = false;
            } else {
                showSuccess('confirmPassword');
            }
            
            // Role validation
            const roleSelected = document.querySelector('input[name="role"]:checked');
            if (!roleSelected) {
                showError('registerRole', 'Pilih peran Anda');
                isValid = false;
            } else {
                document.getElementById('registerRoleError').style.display = 'none';
            }
            
            // Terms validation
            if (!document.getElementById('acceptTerms').checked) {
                showError('acceptTerms', 'Anda harus menyetujui syarat dan ketentuan');
                isValid = false;
            } else {
                document.getElementById('acceptTermsError').style.display = 'none';
            }
            
            return isValid;
        }

        // Form submission handlers
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            if (validateLogin()) {
                // Simulate successful login
                document.getElementById('loginSuccess').style.display = 'block';
                setTimeout(() => {
                    // Redirect to dashboard in real implementation
                    alert('Login berhasil! Mengarahkan ke dashboard...');
                }, 1500);
            }
        });

        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            if (validateRegister()) {
                // Simulate successful registration
                document.getElementById('registerSuccess').style.display = 'block';
                setTimeout(() => {
                    switchPage('login');
                }, 2000);
            }
        });

        // Fix the switchPage function
        function switchPage(page) {
            const loginPage = document.getElementById('loginPage');
            const registerPage = document.getElementById('registerPage');
            
            if (page === 'login' || page === 'loginPage') {
                loginPage.classList.add('active');
                registerPage.classList.remove('active');
            } else if (page === 'register' || page === 'registerPage') {
                registerPage.classList.add('active');
                loginPage.classList.remove('active');
            }
            
            // Clear forms when switching
            clearForms();
        }
    </script>
</body>
</html>