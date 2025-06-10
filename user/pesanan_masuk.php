<?php
session_start();
include '../config.php';

$id_penjual = $_SESSION['id_user']; // login sebagai penjual

$query = mysqli_query($koneksi, "SELECT t.id_transaksi, t.kode_invoice, t.status_transaksi, t.tgl_transaksi, 
        p.nama_pakaian, p.harga, u.nama AS nama_pembeli, f.path_foto FROM transaksi t
        JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
        JOIN pakaian p ON dt.id_produk = p.id_pakaian
        JOIN user u ON t.id_user = u.id_user
        LEFT JOIN (
            SELECT id_pakaian, MIN(path_foto) AS path_foto 
            FROM foto_produk GROUP BY id_pakaian
        ) f ON p.id_pakaian = f.id_pakaian
        WHERE p.id_user = '$id_penjual'
        ORDER BY t.tgl_transaksi DESC");

    if (!$query) {
    die("Query gagal: " . mysqli_error($koneksi));
}


?>


<!DOCTYPE html>
<html>
<head>
    <title>Pesanan Masuk</title>
    <style>
        .pesanan { border: 1px solid #ccc; padding: 15px; margin-bottom: 15px; border-radius: 8px; display: flex; gap: 15px; }
        .pesanan img { width: 100px; height: 100px; object-fit: cover; }
        .info { flex: 1; }
        .btn-proses {
            padding: 6px 10px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <h2>Pesanan Masuk</h2>

    <?php while($row = mysqli_fetch_assoc($query)): ?>
        <div class="pesanan">
            <img src="../uploads/<?= $row['path_foto']; ?>" alt="Foto">
            <div class="info">
                <p><strong>Invoice:</strong> <?= $row['kode_invoice']; ?></p>
                <p><strong>Pembeli:</strong> <?= $row['nama_pembeli']; ?></p>
                <p><strong>Produk:</strong> <?= $row['nama_pakaian']; ?></p>
                <p><strong>Harga:</strong> Rp<?= number_format($row['harga'], 0, ',', '.'); ?></p>
                <p><strong>Status:</strong> <?= ucfirst($row['status_transaksi']); ?></p>

                <?php
                    $current_status = $row['status_transaksi'];
                    $next_status_options = [];

                    switch ($current_status) {
                        case 'menunggu':
                            $next_status_options = ['diproses'];
                            break;
                        case 'diproses':
                            $next_status_options = ['dikirim'];
                            break;
                        case 'dikirim':
                            echo "<p><em>Pesanan sedang dikirim ke pembeli.</em></p>";
                            break;
                        case 'selesai':
                            echo "<p><em>Pesanan telah selesai.</em></p>";
                            break;
                    }
                    ?>

                            <?php if (!empty($next_status_options)): ?>
                <form method="POST" action="../proses/proses_pesanan.php">
                    <input type="hidden" name="id_transaksi" value="<?= $row['id_transaksi']; ?>">
                    <select name="status_transaksi" required>
                        <option value="">-- Pilih Status --</option>
                        <?php foreach ($next_status_options as $status): ?>
                            <option value="<?= $status ?>"><?= ucfirst($status) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn-proses">Update Status</button>
                </form>
                    <p><em>Pesanan sedang <?= $row['status_transaksi']; ?></em></p>
                <?php endif; ?>
            </div>
        </div>
    <?php endwhile; ?>
</body>
</html>

<!-- <?php
session_start();
include '../config.php';

$id_user = $_SESSION['id_user'];

$query = "
SELECT 
    t.id_transaksi, 
    t.kode_invoice, 
    t.tgl_transaksi, 
    t.status_transaksi, 
    p.nama_pakaian, 
    p.harga, 
    f.path_foto,
    u.nama AS nama_pembeli
FROM transaksi t
JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
JOIN pakaian p ON dt.id_produk = p.id_pakaian
JOIN user u ON t.id_user = u.id_user
LEFT JOIN (
    SELECT * FROM foto_produk WHERE urutan = 1
) f ON p.id_pakaian = f.id_pakaian
WHERE p.id_user = '$id_user' -- user sebagai PENJUAL
ORDER BY t.tgl_transaksi DESC
";

$result = mysqli_query($koneksi, $query);
?>

<h2>Pesanan Masuk</h2>

<?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <div style="border:1px solid #ccc; padding:10px; margin:10px;">
        <img src="<?= $row['path_foto']; ?>" width="100" height="100" style="object-fit:cover;"><br>
        <strong>Invoice:</strong> <?= $row['kode_invoice']; ?><br>
        <strong>Pembeli:</strong> <?= $row['nama_pembeli']; ?><br>
        <strong>Produk:</strong> <?= $row['nama_pakaian']; ?><br>
        <strong>Harga:</strong> Rp<?= number_format($row['harga'], 0, ',', '.'); ?><br>
        <strong>Tanggal:</strong> <?= $row['tgl_transaksi']; ?><br>
        <strong>Status:</strong> <?= ucfirst($row['status_transaksi']); ?><br>

        <?php if ($row['status_transaksi'] === 'menunggu') { ?>
            <form method="POST" action="proses_kirim.php">
                <input type="hidden" name="id_transaksi" value="<?= $row['id_transaksi']; ?>">
                <button type="submit">Kirim Pesanan</button>
            </form>
        <?php } ?>
    </div>
<?php } ?> -->

