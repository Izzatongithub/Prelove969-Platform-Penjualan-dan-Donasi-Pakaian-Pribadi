<?php
session_start();
include '../config.php';

// Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION['id_user'];

// Get transaction history
$query = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id_user = '$id_user' ORDER BY id_transaksi DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - PRELOVE969</title>
    <link rel="stylesheet" href="../frontend/style1.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Include Midtrans JS library -->
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="<?php echo $midtrans_client_key; ?>"></script>
</head>
<body>
    <!-- Header can be included here -->
    
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
                    <td><?php echo $row['kode_invoice']; ?></td>
                    <td><?php echo date('d/m/Y H:i', strtotime($row['tgl_transaksi'])); ?></td>
                    <td>Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                    <td>
                        <?php 
                            switch($row['status_transaksi']) {
                                case 'menunggu':
                                    echo '<span class="status-waiting">Menunggu Pembayaran</span>';
                                    break;
                                case 'pending':
                                    echo '<span class="status-pending">Pembayaran Pending</span>';
                                    break;
                                case 'dibayar':
                                    echo '<span class="status-paid">Dibayar</span>';
                                    break;
                                case 'batal':
                                    echo '<span class="status-canceled">Dibatalkan</span>';
                                    break;
                                case 'gagal':
                                    echo '<span class="status-failed">Gagal</span>';
                                    break;
                                default:
                                    echo $row['status_transaksi'];
                            }
                        ?>
                    </td>
                    <td><?php echo $row['metode_pembayaran'] == 'midtrans' ? ($row['midtrans_payment_type'] ?? 'Midtrans') : 'COD'; ?></td>
                    <td>
                        <a href="detail_transaksi.php?id=<?php echo $row['id_transaksi']; ?>" class="btn-small">Detail</a>
                        
                        <?php if(($row['status_transaksi'] == 'menunggu' || $row['status_transaksi'] == 'pending') && $row['metode_pembayaran'] == 'midtrans'): ?>
                            <?php if(!empty($row['snap_token'])): ?>
                                <button class="btn-small btn-pay" 
                                        onclick="payTransaction('<?php echo $row['snap_token']; ?>', '<?php echo $row['kode_invoice']; ?>')">
                                    Bayar
                                </button>
                            <?php else: ?>
                                <a href="regenerate_payment.php?id=<?php echo $row['id_transaksi']; ?>" class="btn-small">
                                    Bayar Ulang
                                </a>
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
    
    <!-- Footer can be included here -->
</body>
</html>