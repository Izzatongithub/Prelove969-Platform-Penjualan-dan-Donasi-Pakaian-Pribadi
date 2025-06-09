<?php
session_start();
include '../config.php';

$id_transaksi = $_GET['id_transaksi'];
$query = mysqli_query($koneksi, "SELECT kode_invoice, total_harga FROM transaksi WHERE id_transaksi = '$id_transaksi'");
$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pilih Metode Pembayaran</title>
</head>
<body>
    <h2>Checkout</h2>
    <p><strong>Invoice:</strong> <?= $data['kode_invoice'] ?></p>
    <p><strong>Total:</strong> Rp <?= number_format($data['total_harga'], 0, ',', '.') ?></p>

    <form action="../proses/proses_metode_pembayaran.php" method="POST">
        <input type="hidden" name="id_transaksi" value="<?= $id_transaksi ?>">
        <label>Pilih Metode Pembayaran:</label><br>
        <select name="metode_pembayaran" required>
            <option value="cod">Bayar di Tempat (COD)</option>
            <option value="midtrans">Pembayaran Online</option>
        </select><br><br>
        <button type="submit">Lanjutkan Pembayaran</button>
    </form>
</body>
</html>
