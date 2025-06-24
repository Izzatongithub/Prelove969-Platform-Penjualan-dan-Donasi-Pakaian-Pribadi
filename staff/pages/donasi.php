<!DOCTYPE html>
<html>
<head>
    <title>Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../frontend/style_admin.css?v=<?=time()?>">
</head>
<body>
<?php
    include_once dirname(__DIR__, 2) . '/config.php';

    $status_filter = isset($_GET['status']) ? $_GET['status'] : '';
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $sql = "SELECT d.*, u.username FROM donasi_pakaian d LEFT JOIN user u ON d.id_user = u.id_user WHERE 1 = 1";

    if ($status_filter) {
        $sql .= " AND status_donasi = '" . mysqli_real_escape_string($koneksi, $status_filter) . "'";
    }

    if ($search) {
        $search_esc = mysqli_real_escape_string($koneksi, $search);
        $sql .= " AND (d.nama LIKE '%$search_esc%' OR d.no_telp LIKE '%$search_esc%' OR d.alamat LIKE '%$search_esc%')";
    }

    $sql .= " ORDER BY tanggal_donasi DESC";
    $result = mysqli_query($koneksi, $sql);

    // Ambil data panti asuhan untuk dropdown
    $pantis = [];
    $result_panti = mysqli_query($koneksi, "SELECT * FROM panti_asuhan");
    while ($row_panti = mysqli_fetch_assoc($result_panti)) {
        $pantis[] = $row_panti;
    }
?>
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
    <div class="main-content">
    <div class="table-container">
        <table>
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
                        case 'Menunggu Verifikasi': $status_class = 'status-menunggu'; break;
                        case 'Terverifikasi': $status_class = 'status-terverifikasi'; break;
                        case 'Dalam Proses': $status_class = 'status-proses'; break;
                        case 'Selesai': $status_class = 'status-selesai'; break;
                        case 'Ditolak': $status_class = 'status-ditolak'; break;
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
                            <i class="fas fa-eye"></i>
                        </button>
                        <?php if ($row['status_donasi'] === 'Menunggu Verifikasi'): ?>
                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#verifikasiModal<?= $row['id_donasi'] ?>">
                                <i class="fas fa-check"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#tolakModal<?= $row['id_donasi'] ?>">
                                <i class="fas fa-times"></i>
                            </button>
                        <?php elseif ($row['status_donasi'] === 'Terverifikasi'): ?>
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#prosesModal<?= $row['id_donasi'] ?>">
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        <?php elseif ($row['status_donasi'] === 'Dalam Proses'): ?>
                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#selesaiModal<?= $row['id_donasi'] ?>">
                                <i class="fas fa-check-circle"></i>
                            </button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php
        mysqli_data_seek($result, 0); // Kembalikan pointer hasil ke awal
        while ($row = mysqli_fetch_assoc($result)):
        ?>
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

                                <!-- Informasi Penerima (Panti Asuhan) -->
                                <div class="detail-section">
                                    <h6>Informasi Penerima (Panti Asuhan)</h6>
                                    <?php
                                    $panti_info = [];
                                    if (!empty($row['id_panti'])) {
                                        $id_pantis = explode(',', $row['id_panti']);
                                        foreach ($pantis as $panti) {
                                            if (in_array($panti['id_panti'], $id_pantis)) {
                                                $panti_info[] = $panti;
                                            }
                                        }
                                    }
                                    ?>
                                    <?php if (!empty($panti_info)): ?>
                                        <?php foreach ($panti_info as $panti): ?>
                                            <div class="detail-info">
                                                <span class="detail-label">Nama Panti</span>
                                                <span class="detail-value"><?= htmlspecialchars($panti['nama_panti']) ?></span>
                                            </div>
                                            <div class="detail-info">
                                                <span class="detail-label">Alamat</span>
                                                <span class="detail-value"><?= htmlspecialchars($panti['alamat']) ?></span>
                                            </div>
                                            <hr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="text-muted">Belum ada panti asuhan penerima.</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <!-- Foto Donasi -->
                                <div class="detail-section">
                                    <h6>Foto Donasi</h6>
                                    <?php
                                    $fotos = explode(',', $row['foto']);
                                    $ada_foto = false;
                                    foreach ($fotos as $foto):
                                        if (!empty($foto)):
                                            $ada_foto = true;
                                    ?>
                                        <img src="../upload/<?= $foto ?>" alt="Foto Donasi" class="foto-donasi">
                                    <?php
                                        endif;
                                    endforeach;
                                    if (!$ada_foto): ?>
                                        <div class="text-muted">Belum ada foto donasi.</div>
                                    <?php endif; ?>
                                </div>

                                <!-- Catatan Proses -->
                                <div class="detail-section">
                                    <h6 class="text-primary">Catatan Proses</h6>
                                    <div class="detail-info">
                                        <span class="detail-value">
                                            <?= !empty($row['catatan_proses']) ? nl2br(htmlspecialchars($row['catatan_proses'])) : '<span class="text-muted">Belum ada catatan proses.</span>' ?>
                                        </span>
                                    </div>
                                </div>

                                <?php if (!empty($row['alasan_penolakan'])): ?>
                                <div class="detail-section">
                                    <h6 class="text-danger">Alasan Penolakan</h6>
                                    <div class="detail-info">
                                        <span class="detail-value"><?= nl2br(htmlspecialchars($row['alasan_penolakan'])) ?></span>
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
                            <div class="mb-3">
                                <label for="id_panti_<?= $row['id_donasi'] ?>" class="form-label">Serahkan ke Panti Asuhan:</label>
                                <select class="form-select" id="id_panti_<?= $row['id_donasi'] ?>" name="id_panti[]" multiple required>
                                    <?php foreach ($pantis as $panti): ?>
                                        <option value="<?= $panti['id_panti'] ?>"><?= htmlspecialchars($panti['nama_panti']) ?></option>
                                    <?php endforeach; ?>
                                </select>
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
    </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>