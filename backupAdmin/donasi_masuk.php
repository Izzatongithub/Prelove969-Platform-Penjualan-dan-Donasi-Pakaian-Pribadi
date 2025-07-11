<?php
include '../config.php';
session_start();

// Cek apakah user adalah admin
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     header("Location: ../user/login.php");
//     exit;
// }

// Filter status
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Base query
$sql = "SELECT d.*, u.username FROM donasi_pakaian d 
        LEFT JOIN user u ON d.id_user = u.id_user 
        WHERE 1=1";

// Add filters
if ($status_filter) {
    $sql .= " AND status_donasi = '$status_filter'";
}
if ($search) {
    $sql .= " AND (d.nama LIKE '%$search%' OR d.no_telp LIKE '%$search%' OR d.alamat LIKE '%$search%')";
}

$sql .= " ORDER BY tanggal_donasi DESC";
$result = mysqli_query($koneksi, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Donasi Masuk</title>
    <link rel="stylesheet" href="../frontend/style_admin.css?v=<?=time()?>">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        .status-badge {
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 500;
            display: inline-block;
        }
        .status-menunggu { background: #fff3cd; color: #856404; }
        .status-terverifikasi { background: #d1ecf1; color: #0c5460; }
        .status-proses { background: #cce5ff; color: #004085; }
        .status-selesai { background: #d4edda; color: #155724; }
        .status-ditolak { background: #f8d7da; color: #721c24; }

        .modal-xl {
            max-width: 1200px;
        }
        .detail-section {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .detail-section h6 {
            color: #2c3e50;
            margin-bottom: 25px;
            font-size: 18px;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 12px;
            font-weight: 600;
        }
        .detail-info {
            display: flex;
            margin-bottom: 20px;
            align-items: flex-start;
        }
        .detail-label {
            font-weight: 500;
            color: #666;
            min-width: 180px;
            position: relative;
            padding-right: 15px;
        }
        .detail-label::after {
            content: ':';
            position: absolute;
            right: 5px;
        }
        .detail-value {
            flex: 1;
            color: #333;
            line-height: 1.5;
        }
        .foto-donasi {
            max-height: 300px;
            width: 100%;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .modal-title {
            font-weight: 600;
            color: #2c3e50;
        }
        .modal-header {
            background: #f8f9fa;
            border-bottom: 2px solid #e9ecef;
        }
        .modal-footer {
            background: #f8f9fa;
            border-top: 2px solid #e9ecef;
        }
    </style>
</head>
<body>
<div class="admin-wrapper">
    <header class="admin-header">
        <div class="header-left">
            <button id="toggleSidebar" class="sidebar-toggle-btn"><i class="fas fa-bars"></i></button>
            <div class="logo">Prelove969</div>
        </div>
        <div class="header-right">
            <div class="admin-profile">
                <a href="../staff/admin.php" class="logout-btn"><i class="fas fa-arrow-left"></i> Dashboard</a>
            </div>
        </div>
    </header>
    <aside class="admin-sidebar" id="adminSidebar">
        <nav class="sidebar-nav">
            <ul>
                <li class="nav-item" data-target="dashboard-content">
                    <a href="admin.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                </li>
                <li class="nav-item" data-target="all-products-content">
                    <a href="admin.php"><i class="fas fa-box"></i> Produk</a>
                </li>
                <li class="nav-item" data-target="users-content">
                    <a href="admin.php"><i class="fas fa-users"></i> Pengguna</a>
                </li>
                <li class="nav-item" data-target="reviews-content">
                    <a href="admin.php"><i class="fas fa-comments"></i> Ulasan</a>
                </li>
                <li class="nav-item active">
                    <a href="donasi_masuk.php"><i class="fas fa-hand-holding-heart"></i> Donasi</a>
                </li>
                <li class="nav-item" data-target="reports-content">
                    <a href="admin.php"><i class="fas fa-chart-line"></i> Laporan</a>
                </li>
                <li class="nav-item" data-target="general-settings-content">
                    <a href="admin.php"><i class="fas fa-cog"></i> Pengaturan</a>
                </li>
            </ul>
        </nav>
    </aside>
    <main class="admin-main-content">
        <section class="content-section active">
            <h2>Daftar Donasi Masuk</h2>
            <div class="action-bar">
                <form class="search-filter" method="get">
                    <select name="status">
                        <option value="">Semua Status</option>
                        <option value="Menunggu Verifikasi" <?= $status_filter == 'Menunggu Verifikasi' ? 'selected' : '' ?>>Menunggu Verifikasi</option>
                        <option value="Terverifikasi" <?= $status_filter == 'Terverifikasi' ? 'selected' : '' ?>>Terverifikasi</option>
                        <option value="Dalam Proses" <?= $status_filter == 'Dalam Proses' ? 'selected' : '' ?>>Dalam Proses</option>
                        <option value="Selesai" <?= $status_filter == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                        <option value="Ditolak" <?= $status_filter == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                    </select>
                    <input type="text" name="search" placeholder="Cari donatur..." value="<?= htmlspecialchars($search) ?>">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>
            </div>
            <div class="table-container">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Donatur</th>
                            <th>Username</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                            <th>Metode</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
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
                            <td><?= $no++ ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($row['tanggal_donasi'])) ?></td>
                            <td><?= htmlspecialchars($row['nama']) ?></td>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td><?= $row['kategori'] ?></td>
                            <td><?= $row['jumlah_item'] ?> item</td>
                            <td><?= $row['metode_donasi'] ?></td>
                            <td><span class="status-badge <?= $status_class ?>"><?= $row['status_donasi'] ?></span></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal<?= $row['id_donasi'] ?>">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <?php if ($row['status_donasi'] === 'Menunggu Verifikasi'): ?>
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#verifikasiModal<?= $row['id_donasi'] ?>">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#tolakModal<?= $row['id_donasi'] ?>">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                <?php elseif ($row['status_donasi'] === 'Terverifikasi'): ?>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#prosesModal<?= $row['id_donasi'] ?>">
                                        <i class="bi bi-arrow-right-circle"></i>
                                    </button>
                                <?php elseif ($row['status_donasi'] === 'Dalam Proses'): ?>
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#selesaiModal<?= $row['id_donasi'] ?>">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <!-- Modal Detail -->
                        <div class="modal fade" id="detailModal<?= $row['id_donasi'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title fs-4">Detail Donasi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <div class="detail-section">
                                                    <h6>Informasi Donatur</h6>
                                                    <div class="detail-info">
                                                        <span class="detail-label">Nama</span>
                                                        <span class="detail-value"><?= htmlspecialchars($row['nama']) ?></span>
                                                    </div>
                                                    <div class="detail-info">
                                                        <span class="detail-label">Username</span>
                                                        <span class="detail-value"><?= htmlspecialchars($row['username']) ?></span>
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

                                                <div class="detail-section">
                                                    <h6>Detail Pakaian</h6>
                                                    <div class="detail-info">
                                                        <span class="detail-label">Kategori</span>
                                                        <span class="detail-value"><?= $row['kategori'] ?></span>
                                                    </div>
                                                    <div class="detail-info">
                                                        <span class="detail-label">Jumlah Item</span>
                                                        <span class="detail-value"><?= $row['jumlah_item'] ?> item</span>
                                                    </div>
                                                    <div class="detail-info">
                                                        <span class="detail-label">Kondisi</span>
                                                        <span class="detail-value"><?= $row['kondisi'] ?></span>
                                                    </div>
                                                    <div class="detail-info">
                                                        <span class="detail-label">Deskripsi</span>
                                                        <span class="detail-value"><?= nl2br(htmlspecialchars($row['deskripsi'])) ?></span>
                                                    </div>
                                                </div>

                                                <div class="detail-section">
                                                    <h6>Informasi Pengiriman</h6>
                                                    <div class="detail-info">
                                                        <span class="detail-label">Metode</span>
                                                        <span class="detail-value"><?= $row['metode_donasi'] ?></span>
                                                    </div>
                                                    <?php if ($row['waktu_pickup']): ?>
                                                    <div class="detail-info">
                                                        <span class="detail-label">Waktu Pickup</span>
                                                        <span class="detail-value"><?= date('d/m/Y H:i', strtotime($row['waktu_pickup'])) ?></span>
                                                    </div>
                                                    <?php endif; ?>
                                                    <div class="detail-info">
                                                        <span class="detail-label">Status</span>
                                                        <span class="detail-value">
                                                            <?php
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
                                                            <span class="status-badge <?= $status_class ?>"><?= $row['status_donasi'] ?></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="detail-section">
                                                    <h6>Foto Donasi</h6>
                                                    <?php
                                                    $fotos = explode(',', $row['foto']);
                                                    foreach ($fotos as $foto):
                                                        if (!empty($foto)):
                                                    ?>
                                                        <img src="../upload/<?= $foto ?>" alt="Foto Donasi" class="foto-donasi">
                                                    <?php
                                                        endif;
                                                    endforeach;
                                                    ?>
                                                </div>

                                                <?php if (!empty($row['alasan_penolakan'])): ?>
                                                <div class="detail-section">
                                                    <h6 class="text-danger">Alasan Penolakan</h6>
                                                    <div class="detail-info">
                                                        <span class="detail-value"><?= nl2br(htmlspecialchars($row['alasan_penolakan'])) ?></span>
                                                    </div>
                                                </div>
                                                <?php endif; ?>

                                                <?php if (!empty($row['catatan_proses'])): ?>
                                                <div class="detail-section">
                                                    <h6 class="text-primary">Catatan Proses</h6>
                                                    <div class="detail-info">
                                                        <span class="detail-value"><?= nl2br(htmlspecialchars($row['catatan_proses'])) ?></span>
                                                    </div>
                                                </div>
                                                <?php endif; ?>

                                                <?php if (!empty($row['keterangan_selesai'])): ?>
                                                <div class="detail-section">
                                                    <h6 class="text-success">Keterangan Selesai</h6>
                                                    <div class="detail-info">
                                                        <span class="detail-value"><?= nl2br(htmlspecialchars($row['keterangan_selesai'])) ?></span>
                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Verifikasi -->
                        <div class="modal fade" id="verifikasiModal<?= $row['id_donasi'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Verifikasi Donasi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Apakah Anda yakin ingin memverifikasi donasi ini?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <a href="../proses/proses_verif_donasi.php?id=<?= $row['id_donasi'] ?>&action=verifikasi" class="btn btn-success">Verifikasi</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Tolak -->
                        <div class="modal fade" id="tolakModal<?= $row['id_donasi'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tolak Donasi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="../proses/proses_verif_donasi.php" method="post">
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="<?= $row['id_donasi'] ?>">
                                            <input type="hidden" name="action" value="tolak">
                                            <div class="mb-3">
                                                <label for="alasan" class="form-label">Alasan Penolakan:</label>
                                                <textarea class="form-control" id="alasan" name="alasan" rows="3" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Tolak</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Proses -->
                        <div class="modal fade" id="prosesModal<?= $row['id_donasi'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Proses Donasi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="../proses/proses_verif_donasi.php" method="post">
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="<?= $row['id_donasi'] ?>">
                                            <input type="hidden" name="action" value="proses">
                                            <div class="mb-3">
                                                <label for="catatan" class="form-label">Catatan Proses:</label>
                                                <textarea class="form-control" id="catatan" name="catatan" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Proses</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Selesai -->
                        <div class="modal fade" id="selesaiModal<?= $row['id_donasi'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Selesaikan Donasi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="../proses/proses_verif_donasi.php" method="post">
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="<?= $row['id_donasi'] ?>">
                                            <input type="hidden" name="action" value="selesai">
                                            <div class="mb-3">
                                                <label for="keterangan" class="form-label">Keterangan:</label>
                                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success">Selesai</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>
<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
