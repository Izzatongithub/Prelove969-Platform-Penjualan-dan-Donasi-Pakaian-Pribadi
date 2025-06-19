<!DOCTYPE html>
<html>
<head>
    <title>Register - Prelove969</title>
    <link rel="stylesheet" href="../frontend/style_landingpage.css">
</head>
<body>
    <h2>Daftar Akun Baru</h2>
    <form action="proses_register.php" method="POST">
        <label>Username</label>
        <input type="text" name="username" required><br>
        <label>Nama Lengkap</label>
        <input type="text" name="name" required><br>
        <label>Email</label>
        <input type="email" name="email" required><br>
        <label>Password</label>
        <input type="password" name="password" required><br>
        <label>Alamat</label>
        <textarea name="address" required></textarea><br>
        <label>Nomor Telepon</label>
        <input type="tel" name="phone" required><br>
        <button type="submit">Daftar</button>
    </form>
    <p>Sudah punya akun? <a href="login.php">Login</a></p>
</body>
</html>