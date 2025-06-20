<?php
session_start();
include '../config.php';
include '../midtrans_config.php';

// Cek apakah user sudah login dan memiliki snap token
if (!isset($_SESSION['id_user']) || !isset($_SESSION['snap_token'])) {
    header("Location: login.php");
    exit();
}

$snap_token = $_SESSION['snap_token'];
$kode_invoice = $_SESSION['kode_invoice'];
$id_transaksi = $_SESSION['id_transaksi'];

// Ambil informasi transaksi
$query = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id_transaksi = '$id_transaksi'");
$transaksi = mysqli_fetch_assoc($query);

// Ambil detail produk
$queryDetail = mysqli_query($koneksi, "SELECT dt.*, p.nama_pakaian, p.id_pakaian
    FROM detail_transaksi dt
    JOIN pakaian p ON dt.id_produk = p.id_pakaian
    WHERE dt.id_transaksi = '$id_transaksi'");

$produkList = [];
while ($row = mysqli_fetch_assoc($queryDetail)) {
    $produkList[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - PRELOVE969</title>
    <link rel="stylesheet" href="../frontend/style1.css">
    <!-- Include Midtrans JS library -->
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="<?php echo $midtrans_client_key; ?>"></script>
    <!-- Note: change to https://app.midtrans.com/snap/snap.js for production environment -->
</head>
<body>
    <!-- Header can be included here -->
    
    <div class="container">
        <h1>Pembayaran</h1>
        
        <div class="payment-details">
            <h2>Detail Pesanan</h2>
            <p>Kode Invoice: <?php echo $kode_invoice; ?></p>
            <p>Total Pembayaran: Rp <?php echo number_format($transaksi['total_harga'], 0, ',', '.'); ?></p>
            
            <h3>Daftar Produk:</h3>
            <ul>
                <?php foreach($produkList as $produk): ?>
                <li>
                    <?php echo $produk['nama_pakaian']; ?> - 
                    Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?>
                </li>
                <?php endforeach; ?>
            </ul>
            
            <button id="pay-button" class="btn btn-primary">Bayar Sekarang</button>
        </div>
    </div>
    
    <script type="text/javascript">
        // Trigger Snap popup when pay button clicked
        document.getElementById('pay-button').onclick = function() {
            // SnapToken acquired from previous step
            snap.pay('<?php echo $snap_token; ?>', {
                // Optional
                onSuccess: function(result) {
                    /* You may add your own js here, this is just example */
                    window.location.href = 'payment_success.php?order_id=<?php echo $kode_invoice; ?>&result=' + JSON.stringify(result);
                },
                onPending: function(result) {
                    /* You may add your own js here, this is just example */
                    window.location.href = 'payment_pending.php?order_id=<?php echo $kode_invoice; ?>&result=' + JSON.stringify(result);
                },
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    window.location.href = 'payment_error.php?order_id=<?php echo $kode_invoice; ?>&result=' + JSON.stringify(result);
                },
                onClose: function() {
                    /* You may add your own implementation here */
                    alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                }
            });
        };
    </script>
    
</body>
</html>