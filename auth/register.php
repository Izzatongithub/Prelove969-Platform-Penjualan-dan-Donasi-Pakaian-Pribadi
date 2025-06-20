<!DOCTYPE html>
<html>
<head>
    <title>Register - Prelove969</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../frontend/style_landingpage.css">
</head>
<body>
    <div class="register-container">
        <h2>Daftar Akun Baru</h2>
        <form class="register-form" action="proses_register.php" method="POST">
            <label>Username</label>
            <input type="text" name="username" required>

            <label>Nama Lengkap</label>
            <input type="text" name="name" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <label>Alamat</label>
            <textarea name="address" required></textarea>

            <label>Nomor Telepon</label>
            <input type="tel" name="phone" required>

            <button type="submit" class="btn-register">Daftar</button>
        </form>
        <p class="login-link">Sudah punya akun? <a href="login.php">Login</a></p>
    </div>
</body>
</html>
