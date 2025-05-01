<?php
include '../config.php';

$username = $_POST['username'];
$password = $_POST['password'];


$sql = "INSERT INTO user(username, password) VALUES('$username', '$password')";

if (mysqli_query($koneksi, $sql)) {
    header("location: ../user/index_user.php");
}else{
    echo "Error: ";
}

?>