<?php
session_start();
include '../config/db.php';

// Validasi input
if (empty($_POST['email']) || empty($_POST['password'])) { // Changed to check for empty values
    echo json_encode(['success' => false, 'message' => 'Username dan password harus diisi!']);
    exit();
}

$username = trim($_POST['email']); // Trim input to remove extra spaces
$password = trim($_POST['password']);

$sql = "SELECT * FROM users WHERE email=? AND is_active=1";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        $_SESSION['email'] = $row['email'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['is_logged_in'] = true;
        $redirect = $row['role'] === 'admin' ? '../Admin/index.php' : '../User/index.html';
        echo json_encode(['success' => true, 'redirect' => $redirect]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Password salah!']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'User tidak ditemukan atau akun tidak aktif!']);
}
exit();
?>
