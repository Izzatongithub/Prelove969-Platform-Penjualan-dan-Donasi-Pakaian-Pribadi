<?php

$server = "localhost";
$username = "root";
$password = "";
$db = "prelove";

$koneksi = mysqli_connect($server, $username, $password, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}


?>