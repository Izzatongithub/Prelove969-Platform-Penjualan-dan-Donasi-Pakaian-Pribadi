<?php
session_start();
if (isset($_SESSION['username'])) {
    header('Location: ../user/index_user.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Prelove969</title>
    <link rel="stylesheet" href="../frontend/style_landingpage.css">
</head>
<body>
    <h2>Login</h2>
<div class="login-container">
    <h2>Login</h2>
    <form action="proses_login.php" method="POST" class="login-form">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>

        <button type="submit" class="btn-login">Login</button>
    </form>
    <p class="register-link">Belum punya akun? <a href="register.php">Daftar</a></p>
</div>


    <p>Belum punya akun? <a href="register.php">Daftar</a></p>
</body>
</html>