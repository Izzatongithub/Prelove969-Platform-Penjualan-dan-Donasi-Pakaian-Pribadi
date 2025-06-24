<?php
// ========== KONFIGURASI AWAL ==========
require_once '../config.php';
session_start();

// ========== PROSES UTAMA ==========
// 1. Cek login user
if (!isset($_SESSION['id_user'])) {
    header("Location: ../auth/login.php");
    exit();
}

// 2. Cek parameter ID donasi
if (!isset($_GET['id'])) {
    header("Location: riwayat_donasi.php");
    exit();
}

// 3. Ambil data donasi
$id_donasi = $_GET['id'];
$id_user = $_SESSION['id_user'];

// Query untuk mengambil detail donasi
$query = "SELECT d.*, u.nama, u.no_telp, u.alamat 
          FROM donasi_pakaian d 
          JOIN user u ON d.id_user = u.id_user 
          WHERE d.id_donasi = ? AND d.id_user = ?";
          
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "ii", $id_donasi, $id_user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Cek apakah data ditemukan
if (mysqli_num_rows($result) === 0) {
    header("Location: riwayat_donasi.php");
    exit();
}

$donasi = mysqli_fetch_assoc($result);

// 4. Konfigurasi warna status
$status_warna = [
    'menunggu' => '#fff3cd',
    'terverifikasi' => '#cce5ff',
    'proses' => '#d1ecf1',
    'selesai' => '#d4edda',
    'ditolak' => '#f8d7da'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Donasi - Preloved</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../frontend/style1_baru.css">
    <!-- <script src="../frontend/script.js" defer></script> -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }

        .header h1 {
            color: #333;
            font-size: 24px;
        }

        .btn {
            display: inline-block;
            padding: 8px 16px;
            background: #666;
            color: #fff;
            text-decoration: none;
            border-radius: 3px;
        }

        .btn:hover {
            background: #555;
        }

        .content {
            display: flex;
            gap: 20px;
        }

        .main-content {
            flex: 2;
        }

        .side-content {
            flex: 1;
        }

        .bagian {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .judul {
            background: #f5f5f5;
            padding: 10px;
            border-bottom: 1px solid #ddd;
            font-size: 18px;
            font-weight: bold;
        }

        .isi {
            padding: 15px;
        }

        .baris {
            display: flex;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .label {
            width: 150px;
            color: #666;
        }

        .nilai {
            flex: 1;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 3px;
            color: #000;
        }

        .foto {
            text-align: center;
            padding: 10px;
            background: #f9f9f9;
        }

        .foto img {
            max-width: 100%;
            max-height: 300px;
        }

        .tolak {
            background: #ffebee;
            border-color: #ffcdd2;
        }

        .tolak .judul {
            background: #ffcdd2;
            color: #c62828;
        }

        @media (max-width: 768px) {
            .content {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
        <header>
        <div class="header-top">
            <div class="logo">
                <a href='index_user.php'>
                    <i class="fas fa-heart me-2"></i>Prelove969</a>
            </div>
            <input type="text" id="search" class="search" placeholder="Cari pakaian...">
        </div>
        <nav class="navbar">
            <!-- <a href="#">Anak</a> -->
            <a href="form_donasi.php" class="donate">
                <i class="fa-solid fa-hand-holding-heart fa-2x"></i>
            </a>
            <a href="wishlist.php">
                <i class="fa-regular fa-heart fa-2x"></i>
            </a>
            <a href="keranjang.php">
                &nbsp;<i class="fa-solid fa-bag-shopping fa-2x"></i>
            </a>
            <a href='profil_saya.php'>
                &nbsp;<i class="fa-regular fa-circle-user fa-2x"></i></a>
                <!-- <a href="logout.php" class='btn-primary'>Logout</a>   -->
            </nav>
    </header>
        <div class="main-links">
            <a href="jual_pakaian.php">Jual</a>
            <a href="pesananku.php">Pesanan saya</a>
            <a href="pesanan_masuk.php">Pesanan masuk</a>
            <a href="riwayat_donasi.php">Riwayat Donasi</a>
            <!-- <a href="keranjang.php">Keranjang</a> -->
            <!-- <a href="profil_saya.php">Profil saya</a> -->
            <!-- <a href="wishlist.php">Wishlist</a> -->
            <!-- <a href="?gender=wanita">Wanita</a>
            <a href="?gender=pria">Pria</a>
            <a href="?gender=unisex">Unisex</a> -->
        </div>
    <div class="container">
        <div class="header">
            <h1>Detail Donasi</h1>
            <a href="riwayat_donasi.php" class="btn">Kembali</a>
        </div>

        <div class="content">
            <div class="main-content">
                <!-- Informasi Donatur -->
                <div class="bagian">
                    <div class="judul">Informasi Donatur</div>
                    <div class="isi">
                        <div class="baris">
                            <div class="label">Nama</div>
                            <div class="nilai"><?= htmlspecialchars($donasi['nama']) ?></div>
                        </div>
                        <div class="baris">
                            <div class="label">No. Telepon</div>
                            <div class="nilai"><?= htmlspecialchars($donasi['no_telp']) ?></div>
                        </div>
                        <div class="baris">
                            <div class="label">Alamat</div>
                            <div class="nilai"><?= htmlspecialchars($donasi['alamat']) ?></div>
                        </div>
                    </div>
                </div>

                <!-- Detail Pakaian -->
                <div class="bagian">
                    <div class="judul">Detail Pakaian</div>
                    <div class="isi">
                        <div class="baris">
                            <div class="label">Kategori</div>
                            <div class="nilai"><?= htmlspecialchars($donasi['kategori']) ?></div>
                        </div>
                        <div class="baris">
                            <div class="label">Jumlah</div>
                            <div class="nilai"><?= htmlspecialchars($donasi['jumlah_item']) ?> item</div>
                        </div>
                        <div class="baris">
                            <div class="label">Kondisi</div>
                            <div class="nilai"><?= htmlspecialchars($donasi['kondisi']) ?></div>
                        </div>
                        <?php if (!empty($donasi['deskripsi'])): ?>
                        <div class="baris">
                            <div class="label">Deskripsi</div>
                            <div class="nilai"><?= nl2br(htmlspecialchars($donasi['deskripsi'])) ?></div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Informasi Penerima (Panti Asuhan) -->
                <div class="bagian">
                    <div class="judul">Informasi Penerima (Panti Asuhan)</div>
                    <div class="isi">
                        <?php
                        $panti_info = [];
                        if (!empty($donasi['id_panti'])) {
                            $id_pantis = explode(',', $donasi['id_panti']);
                            $id_pantis = array_filter($id_pantis, function($v) { return trim($v) !== ''; });
                            if (count($id_pantis) > 0) {
                                $id_in = implode(',', array_map('intval', $id_pantis));
                                $q_panti = mysqli_query($koneksi, "SELECT * FROM panti_asuhan WHERE id_panti IN ($id_in)");
                                if ($q_panti) {
                                    while ($panti = mysqli_fetch_assoc($q_panti)) {
                                        $panti_info[] = $panti;
                                    }
                                }
                            }
                        }
                        ?>
                        <?php if (!empty($panti_info)): ?>
                            <?php foreach ($panti_info as $panti): ?>
                                <div class="baris">
                                    <div class="label">Nama Panti</div>
                                    <div class="nilai"><?= htmlspecialchars($panti['nama_panti']) ?></div>
                                </div>
                                <div class="baris">
                                    <div class="label">Alamat</div>
                                    <div class="nilai"><?= htmlspecialchars($panti['alamat']) ?></div>
                                </div>
                                <hr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-muted">Belum ada panti asuhan penerima.</div>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- END Informasi Penerima -->
            </div>

            <div class="side-content">
                <!-- Status Donasi -->
                <div class="bagian">
                    <div class="judul">Status Donasi</div>
                    <div class="isi">
                        <div class="baris">
                            <div class="label">Status</div>
                            <div class="nilai">
                                <?php 
                                $status = strtolower($donasi['status_donasi']);
                                $warna = $status_warna[$status] ?? '#f8f9fa';
                                ?>
                                <span class="status" style="background: <?= $warna ?>">
                                    <?= htmlspecialchars($donasi['status_donasi']) ?>
                                </span>
                            </div>
                        </div>
                        <div class="baris">
                            <div class="label">Metode</div>
                            <div class="nilai"><?= htmlspecialchars($donasi['metode_donasi']) ?></div>
                        </div>
                        <?php if (!empty($donasi['waktu_pickup'])): ?>
                        <div class="baris">
                            <div class="label">Waktu Pickup</div>
                            <div class="nilai"><?= date('d/m/Y H:i', strtotime($donasi['waktu_pickup'])) ?></div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Foto Donasi -->
                <div class="bagian">
                    <div class="judul">Foto Donasi</div>
                    <div class="isi">
                        <div class="foto">
                            <?php 
                            // Debug informasi foto
                            $foto_path = "../upload/" . htmlspecialchars($donasi['foto']);
                            ?>
                            <?php if (!empty($donasi['foto'])): ?>
                                <?php if (file_exists($foto_path)): ?>
                                    <img src="<?= $foto_path ?>" alt="Foto Donasi">
                                <?php else: ?>
                                    <p>File foto tidak ditemukan di: <?= $foto_path ?></p>
                                <?php endif; ?>
                            <?php else: ?>
                                <p>Tidak ada foto</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Alasan Penolakan -->
                <?php if (!empty($donasi['alasan_penolakan']) && $donasi['status_donasi'] == 'Ditolak'): ?>
                <div class="bagian tolak">
                    <div class="judul">Alasan Penolakan</div>
                    <div class="isi">
                        <?= nl2br(htmlspecialchars($donasi['alasan_penolakan'])) ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>