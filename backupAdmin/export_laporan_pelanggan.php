<?php
include '../config.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_pelanggan_teratas.xls");

echo "ID User\tNama\tEmail\tTotal Transaksi\tTotal Belanja\n";

$q = "SELECT u.id_user, u.username, u.email, COUNT(t.id_transaksi) AS total_transaksi, COALESCE(SUM(t.total),0) AS total_belanja
    FROM user u
    LEFT JOIN transaksi t ON u.id_user = t.id_user
    GROUP BY u.id_user
    ORDER BY total_belanja DESC
    LIMIT 10";
$res = mysqli_query($koneksi, $q);
while ($row = mysqli_fetch_assoc($res)) {
    echo "{$row['id_user']}\t{$row['username']}\t{$row['email']}\t{$row['total_transaksi']}\t{$row['total_belanja']}\n";
}
?>
