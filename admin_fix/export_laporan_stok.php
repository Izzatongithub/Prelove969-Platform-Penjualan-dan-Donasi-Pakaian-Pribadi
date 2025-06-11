<?php
include '../config.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_stok_produk.xls");

echo "ID Produk\tNama Produk\tKategori\tUkuran\tKondisi\tStok\tStatus\n";

$q = "SELECT p.id_pakaian, p.nama_pakaian, k.kategori, u.ukuran, c.kondisi, p.stok, p.status_ketersediaan
    FROM pakaian p
    LEFT JOIN kategori_pakaian k ON p.id_kategori = k.id_kategori
    LEFT JOIN ukuran_pakaian u ON p.id_ukuran = u.id_ukuran
    LEFT JOIN kondisi_pakaian c ON p.id_kondisi = c.id_kondisi
    ORDER BY p.id_pakaian DESC";
$res = mysqli_query($koneksi, $q);
while ($row = mysqli_fetch_assoc($res)) {
    echo "{$row['id_pakaian']}\t{$row['nama_pakaian']}\t{$row['kategori']}\t{$row['ukuran']}\t{$row['kondisi']}\t{$row['stok']}\t{$row['status_ketersediaan']}\n";
}
?>
