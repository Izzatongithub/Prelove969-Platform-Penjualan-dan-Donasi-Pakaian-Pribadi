<?php
session_start();
include '../config.php';

// Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION['id_user'];

// Ambil riwayat transaksi
$query = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id_user = '$id_user' ORDER BY id_transaksi DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - PRELOVE969</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../frontend/style1_baru.css">
    <script src="../frontend/script.js" defer></script>

    <!-- Embedded CSS -->
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
            color: #d281bc;
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
            color: #7c2d8e;
            font-weight: 500;
        }

        .transaction-table tbody tr:hover {
            background-color: #fdf0f7;
            transition: 0.3s;
        }

        .status-waiting {
            background-color: #ffecd1;
            color: #b26e00;
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 13px;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 13px;
        }

        .status-paid {
            background-color: #d4edda;
            color: #155724;
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 13px;
        }

        .status-canceled,
        .status-failed {
            background-color: #f8d7da;
            color: #721c24;
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 13px;
        }

        .btn-small {
            padding: 6px 12px;
            font-size: 13px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            margin: 4px;
            display: inline-block;
            background-color: #e2a9c4;
            color: white;
            transition: 0.2s;
        }

        .btn-small:hover {
            background-color: #c97bab;
        }

        .btn-pay {
            background-color: #f67280;
        }

        .btn-pay:hover {
            background-color: #ec407a;
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

    <!-- Midtrans JS -->
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="<?php echo $midtrans_client_key; ?>"></script>
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
    <h1>Riwayat Transaksi</h1>
    
    <table class="transaction-table">
        <thead>
            <tr>
                <th>Kode Invoice</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Status</th>
                <th>Metode Pembayaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($query)): ?>
            <tr>
                <td data-label="Kode Invoice"><?php echo $row['kode_invoice']; ?></td>
                <td data-label="Tanggal"><?php echo date('d/m/Y H:i', strtotime($row['tgl_transaksi'])); ?></td>
                <td data-label="Total">Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                <td data-label="Status">
                    <?php 
                        switch($row['status_transaksi']) {
                            case 'menunggu':
                                echo '<span class="status-waiting">Menunggu Pembayaran</span>'; break;
                            case 'pending':
                                echo '<span class="status-pending">Pembayaran Pending</span>'; break;
                            case 'dibayar':
                                echo '<span class="status-paid">Dibayar</span>'; break;
                            case 'batal':
                                echo '<span class="status-canceled">Dibatalkan</span>'; break;
                            case 'gagal':
                                echo '<span class="status-failed">Gagal</span>'; break;
                            default:
                                echo $row['status_transaksi'];
                        }
                    ?>
                </td>
                <td data-label="Metode"><?php echo $row['metode_pembayaran'] == 'midtrans' ? ($row['midtrans_payment_type'] ?? 'Midtrans') : 'COD'; ?></td>
                <td data-label="Aksi">
                    <a href="detail_transaksi.php?id=<?php echo $row['id_transaksi']; ?>" class="btn-primary">Detail</a>
                    <?php if(($row['status_transaksi'] == 'menunggu' || $row['status_transaksi'] == 'pending') && $row['metode_pembayaran'] == 'midtrans'): ?>
                        <?php if(!empty($row['snap_token'])): ?>
                            <button class="btn-primary"
                                    onclick="payTransaction('<?php echo $row['snap_token']; ?>', '<?php echo $row['kode_invoice']; ?>')">Bayar</button>
                        <?php else: ?>
                            <br><br><a href="regenerate_payment.php?id=<?php echo $row['id_transaksi']; ?>" class="btn-primary">Bayar Ulang</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
function payTransaction(snapToken, orderId) {
    snap.pay(snapToken, {
        onSuccess: function(result) {
            window.location.href = 'payment_success.php?order_id=' + orderId + '&result=' + JSON.stringify(result);
        },
        onPending: function(result) {
            window.location.href = 'payment_pending.php?order_id=' + orderId + '&result=' + JSON.stringify(result);
        },
        onError: function(result) {
            window.location.href = 'payment_error.php?order_id=' + orderId + '&result=' + JSON.stringify(result);
        }
    });
}
</script>



</body>
</html>
