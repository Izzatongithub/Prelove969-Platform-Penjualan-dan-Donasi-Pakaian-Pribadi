<?php
session_start();
include '../config.php';

if (!isset($_GET['id'])) {
    echo "ID transaksi tidak ditemukan.";
    exit();
}

$id_transaksi = $_GET['id'];
$id_user = $_SESSION['id_user'];

$query = mysqli_query($koneksi, "SELECT t.*, p.nama_pakaian, p.harga FROM transaksi t 
    JOIN detail_transaksi td ON t.id_transaksi = td.id_transaksi 
    JOIN pakaian p ON td.id_produk = p.id_pakaian
    WHERE t.id_transaksi = '$id_transaksi' AND t.id_user = '$id_user'
");

if (mysqli_num_rows($query) == 0) {
    echo "Transaksi tidak ditemukan.";
    exit();
}

$jumlah = 1;
$total = 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Transaksi #<?= $id_transaksi ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../frontend/style1_baru.css">
    <script src="../frontend/script.js" defer></script>

    <style>
        * {
            margin: 0; padding: 0; box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #fafafa;
            color: #333;
            padding: 40px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 30px 40px;
        }

        h1 {
            font-size: 28px;
            font-weight: 600;
            color:#ff6b9d;
            margin-bottom: 30px;
            text-align: center;
        }

        .transaction-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 15px;
        }

        .transaction-table th,
        .transaction-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            text-align: center;
        }

        .transaction-table th {
            background-color: #fbe5f2;
            /* color: #7c2d8e; */
            font-weight: 500;
        }

        .transaction-table tbody tr:hover {
            background-color: #fdf0f7;
            transition: 0.3s;
        }

        .btn-small {
            padding: 6px 12px;
            font-size: 13px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            margin-top: 20px;
            display: inline-block;
            background-color: #e2a9c4;
            color: white;
            transition: 0.2s;
        }

        .btn-small:hover {
            background-color: #c97bab;
        }

        @media screen and (max-width: 768px) {
            .transaction-table, .transaction-table thead, .transaction-table tbody, .transaction-table th, .transaction-table td, .transaction-table tr {
                display: block;
            }

            .transaction-table th {
                display: none;
            }

            .transaction-table td {
                position: relative;
                padding-left: 50%;
                text-align: left;
                border-bottom: 1px solid #eee;
            }

            .transaction-table td::before {
                position: absolute;
                left: 15px;
                top: 12px;
                font-weight: bold;
                color: #888;
                content: attr(data-label);
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-top">
            <div class="logo">
                <a href='index_user.php'>
                    <i class="fas fa-heart me-2"></i>Prelove969</a>
            </div>
            <input type="text" id="search" class="search" placeholder="Cari pakaian...">
        </div>
        <nav class="navbar">
            <!-- <a href="#">Anak</a> -->
            <a href="form_donasi.php" class="donate">
                <i class="fa-solid fa-hand-holding-heart fa-2x"></i>
            </a>
            <a href="wishlist.php">
                <i class="fa-regular fa-heart fa-2x"></i>
            </a>
            <a href="keranjang.php">
                &nbsp;<i class="fa-solid fa-bag-shopping fa-2x"></i>
            </a>
            <a href='profil_saya.php'>
                &nbsp;<i class="fa-regular fa-circle-user fa-2x"></i></a>
                <!-- <a href="logout.php" class='btn-primary'>Logout</a>   -->
            </nav>
        </header>
        <div class="main-links">
            <a href="jual_pakaian.php">Jual</a>
            <a href="pesananku.php">Pesanan saya</a>
            <a href="pesanan_masuk.php">Pesanan masuk</a>
            <a href="riwayat_donasi.php">Riwayat Donasi</a>
            <a href="riwayat_transaksi.php">Riwayat Transaksi</a>
            <!-- <a href="keranjang.php">Keranjang</a> -->
            <!-- <a href="profil_saya.php">Profil saya</a> -->
            <!-- <a href="wishlist.php">Wishlist</a> -->
            <!-- <a href="?gender=wanita">Wanita</a>
            <a href="?gender=pria">Pria</a>
            <a href="?gender=unisex">Unisex</a> -->
    </div><br><br>

    <div class="container">
        <h1>Detail Transaksi #<?= $id_transaksi ?></h1>
        <table class="transaction-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($query)) {
                    $subtotal = $row['harga'] * $jumlah;
                    $total += $subtotal;
                    echo "<tr>
                            <td data-label='Produk'>{$row['nama_pakaian']}</td>
                            <td data-label='Harga'>Rp " . number_format($row['harga']) . "</td>
                            <td data-label='Jumlah'>{$jumlah}</td>
                            <td data-label='Subtotal'>Rp " . number_format($subtotal) . "</td>
                          </tr>";
                }
                ?>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td><strong>Rp <?= number_format($total) ?></strong></td>
                </tr>
            </tbody>
        </table>
        <a href="riwayat_transaksi.php" class="btn-small">Kembali ke Riwayat</a>
    </div>
</body>
</html>
