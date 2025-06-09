<?php
include '../config.php'; // Sesuaikan path ke file koneksi.php
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Donasi Masuk</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            max-height: 100px;
        }
    </style>
</head>
<body>

<h2>Daftar Donasi Masuk</h2>

<table>
    <tr>
        <th>No</th>
        <th>Nama Donatur</th>
        <th>Kontak</th>
        <th>Metode</th>
        <th>Alamat</th>
        <th>Foto</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    <?php
    $no = 1;
    $sql = "SELECT * FROM donasi ORDER BY id_donasi DESC";
    $result = mysqli_query($koneksi, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$no}</td>";
        echo "<td>{$row['nama']}</td>";
        echo "<td>{$row['no_telp']}</td>";
        echo "<td>{$row['metode_donasi']}</td>";
        echo "<td>{$row['alamat']}</td>";
        echo "<td>";
        if (!empty($row['foto'])) {
            echo "<img src='../upload/{$row['foto']}' alt='Bukti Donasi'>";
        } else {
            echo "-";
        }
        echo "</td>";
        echo "<td>{$row['status_donasi']}</td>";
        echo "<td>";
        if ($row['status_donasi'] === 'Belum Diverifikasi') {
            echo "<a href='../proses/proses_verif_donasi.php?id={$row['id_donasi']}'>Verifikasi</a>";
        } else {
            echo "pp";
        }
        echo "</td>";
        echo "</tr>";
        $no++;
    }
    ?>
</table>


</body>
</html>
