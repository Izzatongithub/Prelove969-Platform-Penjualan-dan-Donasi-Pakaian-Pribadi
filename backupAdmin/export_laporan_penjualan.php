<?php
include '../config.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_penjualan.xls");

echo "ID Transaksi\tTanggal\tPembeli\tProduk\tJumlah\tTotal\tStatus\n";

$q = "SELECT t.id_transaksi, t.tanggal, u.username AS pembeli, p.nama_pakaian, dt.jumlah, t.total, t.status
    FROM transaksi t
    LEFT JOIN user u ON t.id_user = u.id_user
    LEFT JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
    LEFT JOIN pakaian p ON dt.id_pakaian = p.id_pakaian
    ORDER BY t.tanggal DESC";
$res = mysqli_query($koneksi, $q);
while ($row = mysqli_fetch_assoc($res)) {
    echo "{$row['id_transaksi']}\t{$row['tanggal']}\t{$row['pembeli']}\t{$row['nama_pakaian']}\t{$row['jumlah']}\t{$row['total']}\t{$row['status']}\n";
}
?>
