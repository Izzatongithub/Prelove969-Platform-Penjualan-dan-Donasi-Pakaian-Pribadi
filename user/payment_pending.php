<?php
session_start();
include '../config.php';

if (!isset($_GET['order_id'])) {
    header("Location: index.php");
    exit();
}

$order_id = $_GET['order_id'];
$result = isset($_GET['result']) ? json_decode($_GET['result'], true) : null;

// Get transaction data
$query = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE kode_invoice = '$order_id'");
$transaksi = mysqli_fetch_assoc($query);

// Get payment instructions from result
$payment_type = $result['payment_type'] ?? '';
$va_numbers = $result['va_numbers'][0]['va_number'] ?? '';
$bank = $result['va_numbers'][0]['bank'] ?? '';
$payment_code = $result['payment_code'] ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menunggu Pembayaran - PRELOVE969</title>
    <link rel="stylesheet" href="../frontend/style1.css">
</head>
<body>
    <!-- Header can be included here -->
    
    <div class="container">
        <div class="payment-pending">
            <h1>Menunggu Pembayaran</h1>
            <p>Silahkan selesaikan pembayaran Anda sesuai instruksi berikut:</p>
            
            <div class="payment-instructions">
                <p>Kode Invoice: <?php echo $order_id; ?></p>
                <p>Total Pembayaran: Rp <?php echo number_format($transaksi['total_harga'], 0, ',', '.'); ?></p>
                
                <?php if ($payment_type == 'bank_transfer'): ?>
                    <h3>Instruksi Transfer Bank</h3>
                    <?php if (!empty($bank)): ?>
                        <p>Bank: <?php echo strtoupper($bank); ?></p>
                        <p>Virtual Account: <?php echo $va_numbers; ?></p>
                    <?php endif; ?>
                <?php elseif ($payment_type == 'echannel'): ?>
                    <h3>Instruksi Pembayaran Mandiri Bill</h3>
                    <p>Bill Key: <?php echo $result['bill_key']; ?></p>
                    <p>Biller Code: <?php echo $result['biller_code']; ?></p>
                <?php elseif ($payment_type == 'cstore'): ?>
                    <h3>Instruksi Pembayaran <?php echo strtoupper($bank); ?></h3>
                    <p>Kode Pembayaran: <?php echo $payment_code; ?></p>
                <?php endif; ?>
                
                <p>Batas waktu pembayaran: 24 jam</p>
            </div>
            
            <div class="buttons">
                <a href="riwayat_transaksi.php" class="btn">Cek Status Pembayaran</a>
                <a href="index.php" class="btn btn-secondary">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
    
    <!-- Footer can be included here -->
</body>
</html>