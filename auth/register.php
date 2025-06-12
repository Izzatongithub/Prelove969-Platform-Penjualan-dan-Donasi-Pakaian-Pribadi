<?php
session_start();
include '../config/db.php';

$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
$role = 'user'; // Default role

$sql = "INSERT INTO users (username, email, password, role, is_active) VALUES (?, ?, ?, ?, 1)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssss', $username, $email, $password, $role);

if ($stmt->execute()) {
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $role;
    echo json_encode(['success' => true, 'redirect' => '../User/index.html']);
} else {
    echo json_encode(['success' => false, 'message' => 'Registrasi gagal. Coba lagi.']);
}
exit();
?>
