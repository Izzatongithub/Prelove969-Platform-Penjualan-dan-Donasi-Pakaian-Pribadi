<?php
session_start();
include '../config.php';

$id_user = $_SESSION['id_user'];
$total = 0;
$items = [];

if (isset($_GET['id_pakaian'])) {
    // ✅ Checkout langsung
    $id_pakaian = $_GET['id_pakaian'];
    $query = mysqli_query($koneksi, "
        SELECT p.id_pakaian, p.nama_pakaian, p.harga, f.path_foto 
        FROM pakaian p
        LEFT JOIN (
            SELECT id_pakaian, MIN(path_foto) AS path_foto FROM foto_produk GROUP BY id_pakaian
        ) f ON p.id_pakaian = f.id_pakaian
        WHERE p.id_pakaian = '$id_pakaian'
    ");
} else {
    // ✅ Checkout dari keranjang
    $query = mysqli_query($koneksi, "
        SELECT p.id_pakaian, p.nama_pakaian, p.harga, f.path_foto 
        FROM keranjang k
        JOIN keranjang_detail kd ON k.id_keranjang = kd.id_keranjang
        JOIN pakaian p ON kd.id_produk = p.id_pakaian
        LEFT JOIN (
            SELECT id_pakaian, MIN(path_foto) AS path_foto FROM foto_produk GROUP BY id_pakaian
        ) f ON p.id_pakaian = f.id_pakaian
        WHERE k.id_user = '$id_user'
    ");
}

if (!$query || mysqli_num_rows($query) == 0) {
    die("Tidak ada produk untuk di-checkout.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <style>
        .checkout-container {
            max-width: 700px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background: #f9f9f9;
        }
        .produk-item {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }
        .produk-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }
        .produk-info {
            flex: 1;
        }
        .total {
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
        }
        .form-checkout {
            margin-top: 20px;
            text-align: right;
        }
        .form-checkout select,
        .form-checkout button {
            padding: 10px;
            border-radius: 6px;
        }
    </style>
</head>
<body>

<div class="checkout-container">
    <h2>Checkout</h2>

    <?php while ($item = mysqli_fetch_assoc($query)) : ?>
        <div class="produk-item">
            <img src="../uploads/<?= $item['path_foto'] ?>" alt="<?= $item['nama_pakaian'] ?>">
            <div class="produk-info">
                <p><strong><?= $item['nama_pakaian'] ?></strong></p>
                <p>Rp <?= number_format($item['harga'], 0, ',', '.') ?></p>
            </div>
        </div>
        <?php $total += $item['harga']; ?>
    <?php endwhile; ?>

    <p class="total">Total: Rp <?= number_format($total, 0, ',', '.') ?></p>

    <form action="../proses/proses_checkout.php" method="POST" class="form-checkout">
        <input type="hidden" name="id_pakaian" value="<?= $id_pakaian ?>">
        <label for="metode_pembayaran">Lanjut:</label>
        <!-- <select name="metode_pembayaran" id="metode_pembayaran" required>
            <option value="">-- Pilih --</option>
            <option value="cod">Bayar di Tempat (COD)</option>
            <option value="midtrans">Pembayaran Online (Midtrans)</option> -->
        </select>
        <br><br>
        <button type="submit">Checkout</button>
    </form>
</div>

</body>
</html>
