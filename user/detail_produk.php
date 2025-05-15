<!DOCTYPE html>

<?php
    include "../config.php";

    // session_start();
    // if (!isset($_SESSION['username'])) {
    //     header("Location: index.php?page=login");
    // }

    $id = $_GET['id'];

    $query = "SELECT p.*, k.kategori, u.ukuran, c.kondisi FROM pakaian p
            LEFT JOIN kategori_pakaian k ON p.id_kategori = k.id_kategori
            LEFT JOIN ukuran_pakaian u ON p.id_ukuran = u.id_ukuran
            LEFT JOIN kondisi_pakaian c ON p.id_kondisi = c.id_kondisi WHERE p.id_pakaian = $id";

    $data = mysqli_fetch_assoc(mysqli_query($koneksi, $query));

    // Ambil semua foto produk
    $fotos = mysqli_query($koneksi, "SELECT * FROM foto_produk WHERE id_pakaian = $id ORDER BY urutan ASC");

    // Ambil semua data ke dalam array
$all_fotos = [];
while ($foto = mysqli_fetch_assoc($fotos)) {
    $all_fotos[] = $foto;
}

// Ambil gambar pertama sebagai gambar utama
$gambar_utama = $all_fotos[0]['path_foto'];
?>


<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['nama_pakaian']; ?> | Preloved</title>
    <link rel="stylesheet" href="../frontend/style1.css">
    <script src="../frontend/script.js" defer></script>
</head>
<body>
    <!-- Navbar -->
    <header>
        <div class="topbar">
            <div class="logo">PRELOVE969</div>
            <input type="text" id="search" class="search" placeholder="Cari pakaian...">
            <a href="jual_pakaian.php">Jual</a>
        </div>
        <nav class="menu">
            <div class="dropdown">
                <a href="#">Wanita</a>
                <div class="dropdown-menu">
                    <div class="dropdown-column">
                        <h4>Baju</h4>
                        <a href="#">T-shirts</a>
                        <a href="#">Polo shirts</a>
                        <a href="#">Kemeja</a>
                        <a href="#">Sweater</a>
                        <a href="#">Hoodie</a>
                        <a href="#">Jaket</a>
                        <a href="#">Jeans</a>
                        <a href="#">Celana</a>
                        <a href="#">Shorts</a>
                    </div>
                </div>
             </div>
        <div class="dropdown">
            <a href="#">Pria</a>
                <div class="dropdown-menu">
                    <div class="dropdown-column">
                        <h4>Baju</h4>
                            <a href="#">T-shirts</a>
                            <a href="#">Polo shirts</a>
                            <a href="#">Kemeja</a>
                            <a href="#">Sweater</a>
                            <a href="#">Hoodie</a>
                            <a href="#">Jaket</a>
                            <a href="#">Jeans</a>
                            <a href="#">Celana</a>
                            <a href="#">Shorts</a>
                    </div>
                    <div class="dropdown-column">
                        <h4>Baju</h4>
                            <a href="#">T-shirts</a>
                            <a href="#">Polo shirts</a>
                            <a href="#">Kemeja</a>
                            <a href="#">Sweater</a>
                            <a href="#">Hoodie</a>
                            <a href="#">Jaket</a>
                            <a href="#">Jeans</a>
                            <a href="#">Celana</a>
                            <a href="#">Shorts</a>
                    </div>
                </div>
            </div>
                <a href="#">Branded</a>
                <a href="#">Anak</a>
                <a href="#" class="sale">Sale</a>
                <a href="#" class="donate">Donasi</a>
                <!-- <a href="#" id="loginBtn">Login</a> -->
                <a href="register.php" class="btn">Logout</a>
        </nav>
    </header>
        <!-- <span> <?php echo"<h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Welcome, " . $_SESSION['username'] . "</h3>"; ?></span> -->
    
    <!-- Kategori -->
    <section class="categories">
        <button>Footwear</button>
        <button>Tops</button>
        <button>Bottoms</button>
        <button>Outerwear</button>
        <button>Underwear</button>
        <button>Accessories</button>
    </section>

    <!-- Filter -->
    <section class="filters">
        <select id="category-filter" class="filters-content">
            <option value="">Category</option>
            <option value="tops">Tops</option>
            <option value="bottoms">Bottoms</option>
        </select>
        <select id="size-filter">
            <option value="">Size</option>
            <option value="S">S</option>
            <option value="M">M</option>
        </select>
        <select id="color-filter">
            <option value="">Warna</option>
        </select>
    </section>
    <!-- <div class="foto-besar">
        <img id="mainImage" src="<?= mysqli_fetch_assoc($fotos)['path_foto']; ?>" alt="Gambar Utama">
    </div> -->

    <!-- Daftar Produk -->
    <div class="detail-container">
        <div class="galeri">
            <?php
            mysqli_data_seek($fotos, 0); // Kembalikan pointer ke awal
                while ($img = mysqli_fetch_assoc($fotos)) {
                    echo "<img src='{$img['path_foto']}' class='thumbnail' onclick='changeImage(this.src)'>";
                }
            ?>
        </div>
    <div class="info-produk">
        <h2><?= $data['nama_pakaian']; ?></h2>
            <p><strong>Harga:</strong> Rp <?= number_format($data['harga'], 0, ',', '.'); ?></p>
            <p><strong>Ukuran:</strong> <?= $data['ukuran']; ?></p>
            <p><strong>Kategori:</strong> <?= $data['kategori']; ?></p>
            <p><strong>Kondisi:</strong> <?= $data['kondisi']; ?></p>
            <p><?= nl2br($data['deskripsi']); ?></p>
        <nav>
            <br><a href="checkout.php" class="btn">+ Beli sekarang</a><br><br>
            <br><a href="keranjang.php?id_pakaian=<?= $data['id_pakaian'] ?>" class="btn">+ Keranjang</a><br><br>
        </nav>
    </div>

<script>
function changeImage(src) {
    document.getElementById("mainImage").src = src;
}
</script>

</section>

</body>
</html>
