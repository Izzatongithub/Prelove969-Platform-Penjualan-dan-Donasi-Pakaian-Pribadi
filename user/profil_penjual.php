<?php
include "../config.php";
$id_user = $_GET['id_user'];

// Ambil data penjual
$qUser = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
$dataUser = mysqli_fetch_assoc($qUser);

// Ambil pakaian yang diunggah user ini
$qProduk = mysqli_query($koneksi, "
    SELECT p.*, f.path_foto 
    FROM pakaian p
    LEFT JOIN (
        SELECT id_pakaian, MIN(path_foto) AS path_foto FROM foto_produk GROUP BY id_pakaian
    ) f ON p.id_pakaian = f.id_pakaian
    WHERE p.id_user = '$id_user' AND p.status_ketersediaan = 'tersedia'
");

    // id_penjual dari $_GET['id_user'] atau $_SESSION['id_user']
$id_penjual = $_GET['id_user'];

$qRating = mysqli_query($koneksi, "SELECT AVG(rating) AS rata_rata, COUNT(*) AS total
    FROM reviews WHERE id_penjual = '$id_penjual'
");

$rating = mysqli_fetch_assoc($qRating);
echo "<p>Rating: " . number_format($rating['rata_rata'], 1) . " / 5</p>";
echo "<p>Total Ulasan: " . $rating['total'] . "</p>";

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Penjual - <?= htmlspecialchars($dataUser['nama']) ?></title>
</head>
<body>
    <h2>Profil Penjual</h2>
    <p><strong>Nama:</strong> <?= htmlspecialchars($dataUser['nama']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($dataUser['email']) ?></p>
    <p><strong>No. HP:</strong> <?= htmlspecialchars($dataUser['no_hp']) ?></p>

    <h3>Barang Dijual:</h3>
    <div class="produk-list">
        <?php while ($produk = mysqli_fetch_assoc($qProduk)) : ?>
            <div class="produk">
                <a href="detail_produk.php?id=<?= $produk['id_pakaian'] ?>">
                    <img src="../uploads/<?= $produk['path_foto'] ?>" width="100"><br>
                    <?= htmlspecialchars($produk['nama_pakaian']) ?><br>
                    Rp <?= number_format($produk['harga'], 0, ',', '.') ?>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
