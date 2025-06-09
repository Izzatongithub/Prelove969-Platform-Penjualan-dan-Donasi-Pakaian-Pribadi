<?php
session_start();
include '../config.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit();
}

$id_user = $_SESSION['id_user'];

// Ambil transaksi milik user
$query = "
SELECT t.id_transaksi, t.kode_invoice, t.tgl_transaksi, t.status_transaksi,
       p.nama_pakaian, p.harga, f.path_foto,
       u.id_user AS id_penjual, u.nama AS nama_penjual
FROM transaksi t
JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
JOIN pakaian p ON dt.id_produk = p.id_pakaian
LEFT JOIN (
    SELECT * FROM foto_produk WHERE urutan = 1
) f ON p.id_pakaian = f.id_pakaian
JOIN user u ON p.id_user = u.id_user
WHERE t.id_user = '$id_user'
ORDER BY t.tgl_transaksi DESC
";


$result = mysqli_query($koneksi, $query);
?>

<h2>Pesanan Saya</h2>

<?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <div style="border:1px solid #ccc; padding:10px; margin:10px;">
        <img src="<?= $row['path_foto']; ?>" width="100" height="100" style="object-fit:cover;"><br>
        <strong>Invoice:</strong> <?= $row['kode_invoice']; ?><br>
        <strong>Produk:</strong> <?= $row['nama_pakaian']; ?><br>
        <strong>Harga:</strong> Rp<?= number_format($row['harga'], 0, ',', '.'); ?><br>
        <strong>Tanggal:</strong> <?= $row['tgl_transaksi']; ?><br>
        <p><strong>Penjual:</strong> 
    <a href="profil_penjual.php?id_user=<?= $row['id_penjual'] ?>">
        <?= htmlspecialchars($row['nama_penjual']) ?>
    </a>
</p>

        <strong>Status:</strong> <?= ucfirst($row['status_transaksi']); ?><br>

        <?php if ($row['status_transaksi'] === 'dikirim') { ?>
            <form method="POST" action="form_rating.php">
                <input type="hidden" name="id_transaksi" value="<?= $row['id_transaksi']; ?>">
                <button type="submit">Konfirmasi dan Beri Rating</button>
            </form>
        <?php } ?>

    </div>
<?php } ?>
