<?php
include "../config.php";
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Donasi - Preloved Shop</title>
    <link rel="stylesheet" href="../frontend/style1_baru.css">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            padding: 30px;
        }
        h2 {
            color: #2c3e50;
            margin-bottom: 30px;
            font-weight: 600;
        }
        .modal-xl {
            max-width: 1200px;
        }
        .modal-dialog {
            margin: 1.75rem auto;
            padding: 0;
            display: flex;
            align-items: center;
            min-height: calc(100% - 3.5rem);
        }
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
        }
        .modal-backdrop.show {
            opacity: 1;
        }
        .modal {
            background: transparent;
            padding: 0 !important;
        }
        .modal.fade .modal-dialog {
            transform: translate(0, -50px);
            transition: transform 0.3s ease-out;
        }
        .modal.show .modal-dialog {
            transform: none;
        }
        .modal-content {
            width: 100%;
            border: none;
            border-radius: 15px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            background: #fff;
            margin: 0;
            position: relative;
        }
        .modal-header {
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            padding: 1rem 1.5rem;
        }
        .modal-header .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
        }
        .modal-body {
            padding: 1.5rem;
        }
        .detail-section {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 1.25rem;
            margin-bottom: 1rem;
        }
        .detail-section:last-child {
            margin-bottom: 0;
        }
        .detail-section h6 {
            color: #2c3e50;
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e9ecef;
        }
        .detail-info {
            display: flex;
            align-items: flex-start;
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }
        .detail-info:last-child {
            margin-bottom: 0;
        }
        .detail-label {
            flex: 0 0 120px;
            font-weight: 500;
            color: #6c757d;
        }
        .detail-value {
            flex: 1;
            color: #2c3e50;
            padding-left: 0.5rem;
        }
        .foto-donasi {
            border: 1px solid #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            background: #f8f9fa;
            text-align: center;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .foto-donasi img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .foto-donasi p {
            margin: 0;
            color: #6c757d;
        }
        .status-badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 20px;
            text-align: center;
        }
        .status-menunggu { background: #fff3cd; color: #856404; }
        .status-terverifikasi { background: #d1ecf1; color: #0c5460; }
        .status-proses { background: #cce5ff; color: #004085; }
        .status-selesai { background: #d4edda; color: #155724; }
        .status-ditolak { background: #f8d7da; color: #721c24; }
        
        .row.g-4 {
            margin: -0.5rem;
        }
        .row.g-4 > [class^="col-"] {
            padding: 0.5rem;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <header>
        <div class="header-top">
            <div class="logo">
                <a href='index_user.php'>PRELOVE969</a>
            </div>
            <input type="text" id="search" class="search" placeholder="Cari pakaian...">
        </div>
        <nav class="navbar">
            <a href="jual_pakaian.php">Jual</a>
            <a href="keranjang.php">Keranjang</a>
            <a href="pesananku.php">Pesanan saya</a>
            <a href="pesanan_masuk.php">Pesanan masuk</a>
            <a href="profil_saya.php">Profil saya</a>
            <a href="wishlist.php">Wishlist</a>
            <a href="form_donasi.php" class="donate">Donasi</a>
            <a href="../auth/logout.php" id="registerBtn" class='btn'>Logout</a>
        </nav>
    </header>

    <div class="container mt-4">
        <h2>Riwayat Donasi</h2>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php 
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Jumlah Item</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $id_user = $_SESSION['id_user'];
                    $sql = "SELECT * FROM donasi_pakaian WHERE id_user = '$id_user' ORDER BY tanggal_donasi DESC";
                    $result = mysqli_query($koneksi, $sql);

                    while ($row = mysqli_fetch_assoc($result)):
                        $status_class = '';
                        switch ($row['status_donasi']) {
                            case 'Menunggu Verifikasi':
                                $status_class = 'status-menunggu';
                                break;
                            case 'Terverifikasi':
                                $status_class = 'status-terverifikasi';
                                break;
                            case 'Dalam Proses':
                                $status_class = 'status-proses';
                                break;
                            case 'Selesai':
                                $status_class = 'status-selesai';
                                break;
                            case 'Ditolak':
                                $status_class = 'status-ditolak';
                                break;
                        }
                    ?>
                    <tr>
                        <td><?= date('d/m/Y H:i', strtotime($row['tanggal_donasi'])) ?></td>
                        <td><?= $row['kategori'] ?></td>
                        <td><?= $row['jumlah_item'] ?> item</td>
                        <td><?= $row['metode_donasi'] ?></td>
                        <td><span class="status-badge <?= $status_class ?>"><?= $row['status_donasi'] ?></span></td>
                        <td>
                            <a href="detail_donasi.php?id=<?= $row['id_donasi'] ?>" class="btn btn-info btn-sm">
                                Detail
                            </a>
                        </td>
                    </tr>

                    <!-- Modal Detail -->
                    <div class="modal fade" id="detailModal<?= $row['id_donasi'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Donasi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-4">
                                        <div class="col-md-8">
                                            <div class="row g-4">
                                                <div class="col-md-6">
                                                    <div class="detail-section">
                                                        <h6>Informasi Donatur</h6>
                                                        <div class="detail-info">
                                                            <span class="detail-label">Nama</span>
                                                            <span class="detail-value"><?= htmlspecialchars($row['nama']) ?></span>
                                                        </div>
                                                        <div class="detail-info">
                                                            <span class="detail-label">No. Telepon</span>
                                                            <span class="detail-value"><?= htmlspecialchars($row['no_telp']) ?></span>
                                                        </div>
                                                        <div class="detail-info">
                                                            <span class="detail-label">Alamat</span>
                                                            <span class="detail-value"><?= htmlspecialchars($row['alamat']) ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="detail-section">
                                                        <h6>Detail Pakaian</h6>
                                                        <div class="detail-info">
                                                            <span class="detail-label">Kategori</span>
                                                            <span class="detail-value"><?= htmlspecialchars($row['kategori']) ?></span>
                                                        </div>
                                                        <div class="detail-info">
                                                            <span class="detail-label">Jumlah Item</span>
                                                            <span class="detail-value"><?= htmlspecialchars($row['jumlah_item']) ?> item</span>
                                                        </div>
                                                        <div class="detail-info">
                                                            <span class="detail-label">Kondisi</span>
                                                            <span class="detail-value"><?= htmlspecialchars($row['kondisi']) ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="detail-section">
                                                        <h6>Status Donasi</h6>
                                                        <div class="row g-4">
                                                            <div class="col-md-6">
                                                                <div class="detail-info">
                                                                    <span class="detail-label">Status</span>
                                                                    <span class="detail-value">
                                                                        <span class="status-badge status-<?= strtolower($row['status_donasi']) ?>">
                                                                            <?= htmlspecialchars($row['status_donasi']) ?>
                                                                        </span>
                                                                    </span>
                                                                </div>
                                                                <div class="detail-info">
                                                                    <span class="detail-label">Metode</span>
                                                                    <span class="detail-value"><?= htmlspecialchars($row['metode_donasi']) ?></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <?php if (!empty($row['waktu_pickup'])): ?>
                                                                <div class="detail-info">
                                                                    <span class="detail-label">Waktu Pickup</span>
                                                                    <span class="detail-value"><?= date('d/m/Y H:i', strtotime($row['waktu_pickup'])) ?></span>
                                                                </div>
                                                                <?php endif; ?>
                                                                <?php if (!empty($row['keterangan'])): ?>
                                                                <div class="detail-info">
                                                                    <span class="detail-label">Keterangan</span>
                                                                    <span class="detail-value"><?= htmlspecialchars($row['keterangan']) ?></span>
                                                                </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                        <?php if (!empty($row['alasan_penolakan']) && $row['status_donasi'] == 'Ditolak'): ?>
                                                        <div class="detail-info mt-2">
                                                            <span class="detail-label text-danger">Alasan Ditolak</span>
                                                            <span class="detail-value"><?= nl2br(htmlspecialchars($row['alasan_penolakan'])) ?></span>
                                                        </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="detail-section h-100">
                                                <h6>Foto Donasi</h6>
                                                <div class="foto-donasi">
                                                    <?php if (!empty($row['foto_donasi'])): ?>
                                                        <img src="../upload/<?= htmlspecialchars($row['foto_donasi']) ?>" alt="Foto Donasi">
                                                    <?php else: ?>
                                                        <p>Tidak ada foto</p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="../frontend/script.js"></script>
</body>
</html> 