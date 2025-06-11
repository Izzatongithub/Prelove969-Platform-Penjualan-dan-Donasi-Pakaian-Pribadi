<?php
session_start();
include '../config.php';

// Proses hapus produk
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_produk_id'])) {
    $id = intval($_POST['hapus_produk_id']);
    mysqli_query($koneksi, "DELETE FROM pakaian WHERE id_pakaian = $id");
    // Hapus juga foto jika perlu
    header("Location: admin.php?msg=hapus_produk_sukses");
    exit;
}

// Proses edit produk
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_produk_id'])) {
    $id = intval($_POST['edit_produk_id']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['edit_nama']);
    $harga = floatval($_POST['edit_harga']);
    $kategori = mysqli_real_escape_string($koneksi, $_POST['edit_kategori']);
    $ukuran = mysqli_real_escape_string($koneksi, $_POST['edit_ukuran']);
    $kondisi = mysqli_real_escape_string($koneksi, $_POST['edit_kondisi']);
    $status = mysqli_real_escape_string($koneksi, $_POST['edit_status']);

    // Ambil id_kategori, id_ukuran, id_kondisi
    $id_kategori = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT id_kategori FROM kategori_pakaian WHERE kategori='$kategori'"))['id_kategori'];
    $id_ukuran = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT id_ukuran FROM ukuran_pakaian WHERE ukuran='$ukuran'"))['id_ukuran'];
    $id_kondisi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT id_kondisi FROM kondisi_pakaian WHERE kondisi='$kondisi'"))['id_kondisi'];

    mysqli_query($koneksi, "UPDATE pakaian SET nama_pakaian='$nama', harga='$harga', id_kategori='$id_kategori', id_ukuran='$id_ukuran', id_kondisi='$id_kondisi', status_ketersediaan='$status' WHERE id_pakaian=$id");
    header("Location: admin.php?msg=edit_produk_sukses");
    exit;
}

// Proses hapus ulasan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_ulasan_id'])) {
    $id = intval($_POST['hapus_ulasan_id']);
    mysqli_query($koneksi, "DELETE FROM ulasan WHERE id_ulasan = $id");
    header("Location: admin.php?msg=hapus_ulasan_sukses");
    exit;
}

// Proses approve ulasan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve_ulasan_id'])) {
    $id = intval($_POST['approve_ulasan_id']);
    mysqli_query($koneksi, "UPDATE ulasan SET status='disetujui' WHERE id_ulasan = $id");
    header("Location: admin.php?msg=approve_ulasan_sukses");
    exit;
}

// Dashboard data
$total_penjualan = 0;
$total_pesanan = 0;
$total_produk = 0;
$total_pengguna = 0;
$chart_labels = [];
$chart_data = [];
$recent_activities = [];

// Total penjualan (sum transaksi sukses)
$q = mysqli_query($koneksi, "SELECT SUM(total) as total FROM transaksi WHERE status='selesai'");
if ($q && ($row = mysqli_fetch_assoc($q))) {
    $total_penjualan = $row['total'] ?: 0;
}

// Total pesanan (status belum selesai)
$q = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM transaksi WHERE status IN ('pending','diproses','dikirim')");
if ($q && ($row = mysqli_fetch_assoc($q))) {
    $total_pesanan = $row['total'] ?: 0;
}

// Total produk tersedia
$q = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pakaian WHERE status_ketersediaan='tersedia'");
if ($q && ($row = mysqli_fetch_assoc($q))) {
    $total_produk = $row['total'] ?: 0;
}

// Total pengguna
$q = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM user");
if ($q && ($row = mysqli_fetch_assoc($q))) {
    $total_pengguna = $row['total'] ?: 0;
}

// Grafik penjualan bulanan (12 bulan terakhir)
$chart_labels = [];
$chart_data = [];
$q = mysqli_query($koneksi, "
    SELECT DATE_FORMAT(tanggal, '%b %Y') as bulan, SUM(total) as total
    FROM transaksi
    WHERE status='selesai'
    GROUP BY YEAR(tanggal), MONTH(tanggal)
    ORDER BY YEAR(tanggal) DESC, MONTH(tanggal) DESC
    LIMIT 12
");
$temp_chart = [];
if ($q) {
    while ($row = mysqli_fetch_assoc($q)) {
        $temp_chart[] = $row;
    }
}
$temp_chart = array_reverse($temp_chart); // urutkan dari bulan lama ke baru
foreach ($temp_chart as $row) {
    $chart_labels[] = $row['bulan'];
    $chart_data[] = (int)$row['total'];
}

// Aktivitas terbaru (ambil 10 aktivitas dari transaksi, produk, user, ulasan)
$recent_activities = [];
// Transaksi
$q = mysqli_query($koneksi, "SELECT id_transaksi, tanggal, status FROM transaksi ORDER BY tanggal DESC LIMIT 3");
if ($q) {
    while ($row = mysqli_fetch_assoc($q)) {
        $recent_activities[] = [
            'icon' => 'fa-shopping-cart',
            'text' => "Transaksi #{$row['id_transaksi']} status <b>{$row['status']}</b>.",
            'tanggal' => $row['tanggal']
        ];
    }
}
// Produk baru
$q = mysqli_query($koneksi, "SELECT id_pakaian, nama_pakaian, tgl_upload FROM pakaian ORDER BY tgl_upload DESC LIMIT 2");
if ($q) {
    while ($row = mysqli_fetch_assoc($q)) {
        $recent_activities[] = [
            'icon' => 'fa-plus-circle',
            'text' => "Produk baru \"{$row['nama_pakaian']}\" ditambahkan.",
            'tanggal' => $row['tgl_upload']
        ];
    }
}

// Total Pengguna
$q = mysqli_query($koneksi, "SELECT id_user, username, tgl_daftar FROM user ORDER BY tgl_daftar DESC LIMIT 2");
if ($q) {
    while ($row = mysqli_fetch_assoc($q)) {
        $recent_activities[] = [
            'icon' => 'fa-user-plus',
            'text' => "Total  Pengguna \"{$row['username']}\" terdaftar.",
            'tanggal' => $row['tgl_daftar']
        ];
    }
}
// Ulasan baru
$q = mysqli_query($koneksi, "SELECT id_ulasan, isi_ulasan, tanggal FROM ulasan ORDER BY tanggal DESC LIMIT 2");
if ($q) {
    while ($row = mysqli_fetch_assoc($q)) {
        $recent_activities[] = [
            'icon' => 'fa-star',
            'text' => "Ulasan baru: \"{$row['isi_ulasan']}\".",
            'tanggal' => $row['tanggal']
        ];
    }
}
// Urutkan aktivitas terbaru berdasarkan tanggal
usort($recent_activities, function($a, $b) {
    return strtotime($b['tanggal']) - strtotime($a['tanggal']);
});
$recent_activities = array_slice($recent_activities, 0, 10);

// --- Pengaturan Umum: Ambil data dari database ---
$pengaturan = [
    'logo' => '',
    'nama_website' => '',
    'copyright' => '',
    'tentang_kami' => ''
];
$q = mysqli_query($koneksi, "SELECT * FROM pengaturan LIMIT 1");
if ($q && ($row = mysqli_fetch_assoc($q))) {
    $pengaturan = $row;
}

// --- Proses update pengaturan umum ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_pengaturan_umum'])) {
    $nama_website = mysqli_real_escape_string($koneksi, $_POST['nama_website']);
    $copyright = mysqli_real_escape_string($koneksi, $_POST['copyright']);
    $tentang_kami = mysqli_real_escape_string($koneksi, $_POST['tentang_kami']);
    $logo = $pengaturan['logo'];

    // Proses upload logo jika ada file baru
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array($ext, $allowed)) {
            $logo_name = 'logo_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['logo']['tmp_name'], "../upload/$logo_name");
            $logo = $logo_name;
        }
    }
    mysqli_query($koneksi, "UPDATE pengaturan SET nama_website='$nama_website', logo='$logo', copyright='$copyright', tentang_kami='$tentang_kami'");
    header("Location: admin.php?msg=pengaturan_umum_sukses");
    exit;
}

// --- Pengaturan Donasi: Daftar pengajuan donasi ---
$daftar_donasi = [];
$q = mysqli_query($koneksi, "SELECT d.*, u.username FROM donasi d LEFT JOIN user u ON d.id_user = u.id_user ORDER BY d.tanggal_pengajuan DESC");
if ($q) {
    while ($row = mysqli_fetch_assoc($q)) {
        $daftar_donasi[] = $row;
    }
}

// Proses aksi donasi (terima/tolak)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi_donasi']) && isset($_POST['id_donasi'])) {
    $id_donasi = intval($_POST['id_donasi']);
    $aksi = $_POST['aksi_donasi'];
    if ($aksi === 'terima') {
        mysqli_query($koneksi, "UPDATE donasi SET status='diterima' WHERE id_donasi=$id_donasi");
    } elseif ($aksi === 'tolak') {
        mysqli_query($koneksi, "UPDATE donasi SET status='ditolak' WHERE id_donasi=$id_donasi");
    }
    header("Location: admin.php?msg=aksi_donasi_sukses");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Preloved Store</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../frontend/style_admin.css"> 
</head>
<body>
    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'hapus_produk_sukses'): ?>
    <div id="notifProduk" class="notif-hapus-user show">
        <div class="notif-content">
            <i class="fas fa-check-circle"></i>
            <span>Produk berhasil dihapus!</span>
        </div>
    </div>
    <?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'edit_produk_sukses'): ?>
    <div id="notifProduk" class="notif-hapus-user show">
        <div class="notif-content">
            <i class="fas fa-check-circle"></i>
            <span>Produk berhasil diedit!</span>
        </div>
    </div>
    <?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'hapus_ulasan_sukses'): ?>
    <div id="notifUlasan" class="notif-hapus-user show">
        <div class="notif-content">
            <i class="fas fa-check-circle"></i>
            <span>Ulasan berhasil dihapus!</span>
        </div>
    </div>
    <?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'approve_ulasan_sukses'): ?>
    <div id="notifUlasan" class="notif-hapus-user show">
        <div class="notif-content">
            <i class="fas fa-check-circle"></i>
            <span>Ulasan berhasil disetujui!</span>
        </div>
    </div>
    <?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'pengaturan_umum_sukses'): ?>
    <div class="notif-hapus-user show" style="background:#27ae60;">
        <div class="notif-content">
            <i class="fas fa-check-circle"></i>
            <span>Pengaturan umum berhasil disimpan!</span>
        </div>
    </div>
    <?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'aksi_donasi_sukses'): ?>
    <div class="notif-hapus-user show" style="background:#27ae60;">
        <div class="notif-content">
            <i class="fas fa-check-circle"></i>
            <span>Status donasi berhasil diperbarui!</span>
        </div>
    </div>
    <?php endif; ?>
    <style>
    .notif-hapus-user {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        z-index: 99999;
        transform: translate(-50%, -50%);
        background: #27ae60;
        color: #fff;
        padding: 28px 48px;
        border-radius: 12px;
        box-shadow: 0 8px 40px rgba(39,174,96,0.18);
        font-size: 22px;
        font-weight: 600;
        align-items: center;
        gap: 16px;
        animation: notifFadeIn 0.3s;
    }
    .notif-hapus-user.show { display: flex; }
    .notif-hapus-user .fa-check-circle { font-size: 32px; margin-right: 16px; }
    @keyframes notifFadeIn { from { opacity: 0; transform: translate(-50%, -60%);} to { opacity: 1; transform: translate(-50%, -50%);} }
    </style>
    <script>
    setTimeout(function() {
        var notifProduk = document.getElementById('notifProduk');
        if (notifProduk) notifProduk.style.display = 'none';
        var notifUlasan = document.getElementById('notifUlasan');
        if (notifUlasan) notifUlasan.style.display = 'none';
        if (window.history.replaceState) {
            const url = new URL(window.location.href);
            url.searchParams.delete('msg');
            window.history.replaceState({}, document.title, url.pathname + url.search);
        }
    }, 2200);
    </script>
    <div class="admin-wrapper">
        <header class="admin-header">
            <div class="header-left">
                <button id="toggleSidebar" class="sidebar-toggle-btn"><i class="fas fa-bars"></i></button>
                <div class="logo">PRELOVE969</div>
            </div>
            <div class="header-right">
                <div class="admin-profile">
                    <a href="#" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>
        </header>

        <aside class="admin-sidebar" id="adminSidebar">
            <nav class="sidebar-nav">
                <ul>
                    <li class="nav-item active" data-target="dashboard-content">
                        <a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    </li>
                    <li class="nav-item" data-target="all-products-content">
                        <a href="#"><i class="fas fa-box"></i> Produk</a>
                    </li>
                    <li class="nav-item" data-target="users-content">
                        <a href="#"><i class="fas fa-users"></i> Pengguna</a>
                    </li>
                    <li class="nav-item" data-target="reviews-content">
                        <a href="#"><i class="fas fa-comments"></i> Ulasan</a>
                    </li>
                    <li class="nav-item" data-target="reports-content">
                        <a href="#"><i class="fas fa-chart-line"></i> Laporan</a>
                    </li>
                    <li class="nav-item has-submenu">
                        <a href="#"><i class="fas fa-cog"></i> Pengaturan <i class="fas fa-chevron-down submenu-icon"></i></a>
                        <ul class="submenu">
                            <li data-target="general-settings-content"><a href="#">Umum</a></li>
                            <li data-target="payment-settings-content"><a href="#">Donasi</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="admin-main-content">
            <section id="dashboard-content" class="content-section active">
                <h2>Dashboard Overview</h2>
                <div class="dashboard-grid">
                    <div class="card sales-card">
                        <h3>Total Penjualan</h3>
                        <p class="card-value">Rp <?= number_format($total_penjualan, 0, ',', '.') ?></p>

                    </div>
                    <div class="card orders-card">
                        <h3>Pesanan Baru</h3>
                        <p class="card-value"><?= $total_pesanan ?></p>
                        <span class="card-trend">Perlu Diproses</span>
                    </div>
                    <div class="card products-card">
                        <h3>Total Produk</h3>
                        <p class="card-value"><?= $total_produk ?></p>
                        <!-- <span class="card-trend">Produk tersedia</span> -->
                    </div>
                    <div class="card users-card">
                        <h3>Total Pengguna</h3>
                        <p class="card-value"><?= $total_pengguna ?></p>
                        <!-- <span class="card-trend">Total pengguna</span> -->
                    </div>
                </div>

                <div class="dashboard-charts">
                    <h3>Grafik Penjualan Bulanan</h3>
                    <canvas id="monthlySalesChart"></canvas>
                </div>

                <div class="recent-activities">
                    <h3>Aktivitas Terbaru</h3>
                    <ul>
                        <?php foreach ($recent_activities as $act): ?>
                        <li>
                            <i class="fas <?= $act['icon'] ?>"></i>
                            <?= $act['text'] ?>
                            <span style="color:#aaa;font-size:13px;">(<?= date('d/m/Y', strtotime($act['tanggal'])) ?>)</span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </section>

            <section id="all-products-content" class="content-section">
                <h2>Semua Produk</h2>
                <div class="action-bar">
                    <form method="get" class="search-filter" style="display:flex;gap:10px;">
                        <input type="text" name="search_produk" placeholder="Cari produk..." value="<?= isset($_GET['search_produk']) ? htmlspecialchars($_GET['search_produk']) : '' ?>">
                        <select name="filter_kategori">
                            <option value="">Filter Kategori</option>
                            <?php
                            $kategoriQ = mysqli_query($koneksi, "SELECT * FROM kategori_pakaian");
                            $selectedKat = isset($_GET['filter_kategori']) ? $_GET['filter_kategori'] : '';
                            while ($kat = mysqli_fetch_assoc($kategoriQ)) {
                                $selected = ($kat['kategori'] == $selectedKat) ? 'selected' : '';
                                echo "<option value=\"{$kat['kategori']}\" $selected>{$kat['kategori']}</option>";
                            }
                            ?>
                        </select>
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </form>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Gambar</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Kondisi</th>
                                <th>Ukuran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $where = [];
                            if (!empty($_GET['search_produk'])) {
                                $search = mysqli_real_escape_string($koneksi, $_GET['search_produk']);
                                $where[] = "(p.nama_pakaian LIKE '%$search%' OR p.deskripsi LIKE '%$search%')";
                            }
                            if (!empty($_GET['filter_kategori'])) {
                                $filterKat = mysqli_real_escape_string($koneksi, $_GET['filter_kategori']);
                                $where[] = "k.kategori = '$filterKat'";
                            }
                            $whereSql = $where ? "WHERE " . implode(" AND ", $where) : "";

                            $query = "SELECT p.id_pakaian, p.nama_pakaian, p.harga, k.kategori, u.ukuran, c.kondisi, f.path_foto
                                FROM pakaian p
                                LEFT JOIN kategori_pakaian k ON p.id_kategori = k.id_kategori
                                LEFT JOIN ukuran_pakaian u ON p.id_ukuran = u.id_ukuran
                                LEFT JOIN kondisi_pakaian c ON p.id_kondisi = c.id_kondisi
                                LEFT JOIN (SELECT * FROM foto_produk WHERE urutan = 1) f ON p.id_pakaian = f.id_pakaian
                                $whereSql
                                ORDER BY p.id_pakaian DESC";
                            $result = mysqli_query($koneksi, $query);

                            if (!$result) {
                                echo "<tr><td colspan='8'>Query error: " . mysqli_error($koneksi) . "</td></tr>";
                            } elseif (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $img = $row['path_foto'] ? "../upload/{$row['path_foto']}" : "https://via.placeholder.com/50";
                                    $row_json = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                                    echo "<tr>
                                        <td>{$row['id_pakaian']}</td>
                                        <td><img src='{$img}' alt='{$row['nama_pakaian']}'></td>
                                        <td>{$row['nama_pakaian']}</td>
                                        <td>{$row['kategori']}</td>
                                        <td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>
                                        <td>{$row['kondisi']}</td>
                                        <td>{$row['ukuran']}</td>
                                        <td>
                                            <button class='btn btn-sm btn-edit' data-produk='{$row_json}'><i class='fas fa-edit'></i> Edit</button>
                                            <form action='' method='POST' style='display:inline;' class='form-hapus-produk'>
                                                <input type='hidden' name='hapus_produk_id' value='{$row['id_pakaian']}'>
                                                <button type='submit' class='btn btn-sm btn-delete'><i class='fas fa-trash-alt'></i> Hapus</button>
                                            </form>
                                        </td>
                                    </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8' style='text-align:center;color:#888;'>Belum ada produk di database.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="users-content" class="content-section">
                <h2>Manajemen Pengguna</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID User</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Tanggal Bergabung</th>
                                <th>Alamat</th>
                                <th>Pengaturan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Ambil data user dari database
                            $queryUser = "SELECT * FROM user ORDER BY id_user DESC";
                            $resultUser = mysqli_query($koneksi, $queryUser);
                            if ($resultUser && mysqli_num_rows($resultUser) > 0) {
                                while ($user = mysqli_fetch_assoc($resultUser)) {
                                    $user_json = htmlspecialchars(json_encode($user), ENT_QUOTES, 'UTF-8');
                                    echo "<tr>
                                        <td>{$user['id_user']}</td>
                                        <td>{$user['username']}</td>
                                        <td>{$user['email']}</td>
                                        <td>{$user['tgl_daftar']}</td>
                                        <td><span class='alamat-".($user['alamat'] == 'aktif' ? "active" : "pending")."'>".ucfirst($user['alamat'])."</span></td>
                                        <td>
                                            <button type='button' class='btn btn-sm btn-view btn-detail-user' data-user='{$user_json}'><i class='fas fa-eye'></i> Detail</button>
                                            <form action='hapus_user.php' method='POST' style='display:inline;' class='form-hapus-user'>
                                                <input type='hidden' name='id_user' value='{$user['id_user']}'>
                                                <button type='submit' class='btn btn-sm btn-delete'><i class='fas fa-user-slash'></i> Hapus</button>
                                            </form>
                                        </td>
                                    </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>Tidak ada data pengguna.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="reviews-content" class="content-section">
                <h2>Manajemen Ulasan</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID Ulasan</th>
                                <th>Produk</th>
                                <th>Pengguna</th>
                                <th>Rating</th>
                                <th>Ulasan</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $q = "SELECT u.id_ulasan, p.nama_pakaian, us.username, u.rating, u.isi_ulasan, u.tanggal, u.status
                                FROM ulasan u
                                LEFT JOIN pakaian p ON u.id_pakaian = p.id_pakaian
                                LEFT JOIN user us ON u.id_user = us.id_user
                                ORDER BY u.tanggal DESC";
                            $res = mysqli_query($koneksi, $q);
                            if ($res && mysqli_num_rows($res) > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $stars = str_repeat('<i class="fas fa-star text-warning"></i> ', intval($row['rating']));
                                    $status = $row['status'] == 'disetujui'
                                        ? "<span class='status-active'>Disetujui</span>"
                                        : "<span class='status-pending'>Menunggu</span>";
                                    echo "<tr>
                                        <td>{$row['id_ulasan']}</td>
                                        <td>{$row['nama_pakaian']}</td>
                                        <td>{$row['username']}</td>
                                        <td>{$stars}{$row['rating']}</td>
                                        <td>\"{$row['isi_ulasan']}\"</td>
                                        <td>{$row['tanggal']}</td>
                                        <td>{$status}</td>
                                        <td>
                                            <form action='' method='POST' style='display:inline;' class='form-hapus-ulasan'>
                                                <input type='hidden' name='hapus_ulasan_id' value='{$row['id_ulasan']}'>
                                                <button type='submit' class='btn btn-sm btn-delete'><i class='fas fa-trash-alt'></i> Hapus</button>
                                            </form>
                                            ";
                                    if ($row['status'] != 'disetujui') {
                                        echo "
                                            <form action='' method='POST' style='display:inline;' class='form-approve-ulasan'>
                                                <input type='hidden' name='approve_ulasan_id' value='{$row['id_ulasan']}'>
                                                <button type='submit' class='btn btn-sm btn-approve'><i class='fas fa-check'></i> Setujui</button>
                                            </form>
                                        ";
                                    }
                                    echo "</td></tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8' style='text-align:center;color:#888;'>Belum ada ulasan di database.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="reports-content" class="content-section">
                <h2>Laporan & Analitik</h2>
                <div class="report-section">
                    <h3>Laporan Penjualan</h3>
                    <form method="post" action="export_laporan_penjualan.php" style="margin-bottom:15px;display:inline;">
                        <button type="submit" class="btn btn-success"><i class="fas fa-file-excel"></i> Ekspor Excel</button>
                    </form>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID Transaksi</th>
                                    <th>Tanggal</th>
                                    <th>Pembeli</th>
                                    <th>Produk</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Query laporan penjualan
                                $q = "SELECT t.id_transaksi, t.tanggal, u.username AS pembeli, p.nama_pakaian, dt.jumlah, t.total, t.status
                                    FROM transaksi t
                                    LEFT JOIN user u ON t.id_user = u.id_user
                                    LEFT JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
                                    LEFT JOIN pakaian p ON dt.id_pakaian = p.id_pakaian
                                    ORDER BY t.tanggal DESC";
                                $res = mysqli_query($koneksi, $q);
                                if ($res && mysqli_num_rows($res) > 0) {
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        echo "<tr>
                                            <td>{$row['id_transaksi']}</td>
                                            <td>{$row['tanggal']}</td>
                                            <td>{$row['pembeli']}</td>
                                            <td>{$row['nama_pakaian']}</td>
                                            <td>{$row['jumlah']}</td>
                                            <td>Rp " . number_format($row['total'], 0, ',', '.') . "</td>
                                            <td>{$row['status']}</td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7' style='text-align:center;color:#888;'>Belum ada data penjualan.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table> 
                    </div>
                </div>
            </section>

            <section id="general-settings-content" class="content-section">
                <h2>Pengaturan Umum</h2>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="update_pengaturan_umum" value="1">
                    <div class="form-group">
                        <label for="logo">Logo Website:</label><br>
                        <?php if ($pengaturan['logo']): ?>
                            <img src="../upload/<?= htmlspecialchars($pengaturan['logo']) ?>" alt="Logo" style="max-height:60px;display:block;margin-bottom:8px;">
                        <?php endif; ?>
                        <input type="file" name="logo" id="logo" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="nama_website">Nama Website:</label>
                        <input type="text" id="nama_website" name="nama_website" value="<?= htmlspecialchars($pengaturan['nama_website']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="copyright">Copyright:</label>
                        <input type="text" id="copyright" name="copyright" value="<?= htmlspecialchars($pengaturan['copyright']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="tentang_kami">Tentang Kami:</label>
                        <textarea id="tentang_kami" name="tentang_kami" rows="4" required><?= htmlspecialchars($pengaturan['tentang_kami']) ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan Perubahan</button>
                </form>
            </section>

            <section id="payment-settings-content" class="content-section">
                <h2>Daftar Pengajuan Donasi</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID Donasi</th>
                                <th>Pengaju</th>
                                <th>Nominal</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($daftar_donasi) > 0): foreach ($daftar_donasi as $donasi): ?>
                                <tr>
                                    <td><?= $donasi['id_donasi'] ?></td>
                                    <td><?= htmlspecialchars($donasi['username']) ?></td>
                                    <td>Rp <?= number_format($donasi['nominal'], 0, ',', '.') ?></td>
                                    <td><?= $donasi['tanggal_pengajuan'] ?></td>
                                    <td>
                                        <?php
                                            if ($donasi['status'] == 'pending') echo '<span class="status-pending">Menunggu</span>';
                                            elseif ($donasi['status'] == 'diterima') echo '<span class="status-active">Diterima</span>';
                                            else echo '<span class="status-reject">Ditolak</span>';
                                        ?>
                                    </td>
                                    <td>
                                        <?php if ($donasi['status'] == 'pending'): ?>
                                            <form method="POST" style="display:inline;">
                                                <input type="hidden" name="id_donasi" value="<?= $donasi['id_donasi'] ?>">
                                                <button type="submit" name="aksi_donasi" value="terima" class="btn btn-sm btn-success"><i class="fas fa-check"></i> Terima</button>
                                                <button type="submit" name="aksi_donasi" value="tolak" class="btn btn-sm btn-danger"><i class="fas fa-times"></i> Tolak</button>
                                            </form>
                                        <?php else: ?>
                                            <i class="fas fa-minus" style="color:#aaa;"></i>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr><td colspan="6" style="text-align:center;color:#888;">Belum ada pengajuan donasi.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../frontend/admin.js"></script>
    <script>
// Grafik penjualan bulanan dari PHP
document.addEventListener('DOMContentLoaded', function() {
    const salesChartCanvas = document.getElementById('monthlySalesChart');
    if (salesChartCanvas) {
        new Chart(salesChartCanvas, {
            type: 'line',
            data: {
                labels: <?= json_encode($chart_labels) ?>,
                datasets: [{
                    label: 'Pendapatan Bulanan (Rp)',
                    data: <?= json_encode($chart_data) ?>,
                    backgroundColor: 'rgba(52, 152, 219, 0.2)',
                    borderColor: 'rgba(52, 152, 219, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }
});
</script>
<!-- ...existing code... -->
<!-- Popup Konfirmasi Hapus User -->
<div id="popupHapusUser" class="popup-hapus-user">
    <div class="popup-content">
        <span class="popup-close">&times;</span>
        <h3>Konfirmasi Hapus User</h3>
        <p>Apakah Anda yakin ingin menghapus user ini?<br><b>Tindakan ini tidak dapat dibatalkan!</b></p>
        <div class="popup-actions">
            <button id="btnBatalHapus" class="btn btn-secondary">Batal</button>
            <button id="btnKonfirmasiHapus" class="btn btn-danger">Hapus</button>
        </div>
    </div>
</div>

<!-- Popup Konfirmasi Hapus Produk -->
<div id="popupHapusProduk" class="popup-hapus-user">
    <div class="popup-content">
        <span class="popup-close">&times;</span>
        <h3>Konfirmasi Hapus Produk</h3>
        <p>Apakah Anda yakin ingin menghapus produk ini?<br><b>Tindakan ini tidak dapat dibatalkan!</b></p>
        <div class="popup-actions">
            <button id="btnBatalHapusProduk" class="btn btn-secondary">Batal</button>
            <button id="btnKonfirmasiHapusProduk" class="btn btn-danger">Hapus</button>
        </div>
    </div>
</div>

<!-- Popup Konfirmasi Hapus Ulasan -->
<div id="popupHapusUlasan" class="popup-hapus-user">
    <div class="popup-content">
        <span class="popup-close">&times;</span>
        <h3>Konfirmasi Hapus Ulasan</h3>
        <p>Apakah Anda yakin ingin menghapus ulasan ini?<br><b>Tindakan ini tidak dapat dibatalkan!</b></p>
        <div class="popup-actions">
            <button id="btnBatalHapusUlasan" class="btn btn-secondary">Batal</button>
            <button id="btnKonfirmasiHapusUlasan" class="btn btn-danger">Hapus</button>
        </div>
    </div>
</div>

<!-- Modal Edit Produk -->
<div id="modalEditProduk" class="popup-hapus-user">
    <div class="popup-content" style="max-width:400px;">
        <span class="popup-close">&times;</span>
        <h3>Edit Produk</h3>
        <form id="formEditProduk" method="POST">
            <input type="hidden" name="edit_produk_id" id="edit_produk_id">
            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" name="edit_nama" id="edit_nama" required>
            </div>
            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="edit_harga" id="edit_harga" required>
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <select name="edit_kategori" id="edit_kategori" required>
                    <?php
                    $kategoriQ = mysqli_query($koneksi, "SELECT * FROM kategori_pakaian");
                    while ($kat = mysqli_fetch_assoc($kategoriQ)) {
                        echo "<option value=\"{$kat['kategori']}\">{$kat['kategori']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Ukuran</label>
                <select name="edit_ukuran" id="edit_ukuran" required>
                    <?php
                    $ukuranQ = mysqli_query($koneksi, "SELECT * FROM ukuran_pakaian");
                    while ($uk = mysqli_fetch_assoc($ukuranQ)) {
                        echo "<option value=\"{$uk['ukuran']}\">{$uk['ukuran']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Kondisi</label>
                <select name="edit_kondisi" id="edit_kondisi" required>
                    <?php
                    $kondisiQ = mysqli_query($koneksi, "SELECT * FROM kondisi_pakaian");
                    while ($kond = mysqli_fetch_assoc($kondisiQ)) {
                        echo "<option value=\"{$kond['kondisi']}\">{$kond['kondisi']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success mt-3"><i class="fas fa-save"></i> Simpan Perubahan</button>
        </form>
    </div>
</div>

<!-- Modal Detail User -->
<div id="modalDetailUser" class="popup-hapus-user">
    <div class="popup-content" style="max-width:420px;text-align:left;">
        <span class="popup-close">&times;</span>
        <h3>Detail Pengguna</h3>
        <div id="detailUserContent">
            <!-- Konten detail user akan diisi via JS -->
        </div>
    </div>
</div>

<style>
/* Popup Hapus User */
.popup-hapus-user {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0; top: 0; width: 100vw; height: 100vh;
    background: rgba(44,62,80,0.6);
    align-items: center; justify-content: center;
}
.popup-hapus-user.show { display: flex; }
.popup-hapus-user .popup-content {
    background: #fff;
    border-radius: 12px;
    padding: 32px 28px 24px;
    box-shadow: 0 8px 40px rgba(44,62,80,0.25);
    text-align: center;
    min-width: 320px;
    position: relative;
    animation: popupFadeIn 0.25s;
}
@keyframes popupFadeIn { from { transform: scale(0.95); opacity: 0; } to { transform: scale(1); opacity: 1; } }
.popup-hapus-user .popup-close {
    position: absolute; top: 12px; right: 18px;
    font-size: 22px; color: #888; cursor: pointer;
    transition: color 0.2s;
}
.popup-hapus-user .popup-close:hover { color: #e74c3c; }
.popup-hapus-user h3 { margin-top: 0; color: #e74c3c; }
.popup-hapus-user .popup-actions { margin-top: 24px; display: flex; gap: 18px; justify-content: center; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let popup = document.getElementById('popupHapusUser');
    let btnBatal = document.getElementById('btnBatalHapus');
    let btnKonfirmasi = document.getElementById('btnKonfirmasiHapus');
    let popupClose = document.querySelector('.popup-hapus-user .popup-close');
    let formToSubmit = null;

    document.querySelectorAll('.form-hapus-user').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            formToSubmit = this;
            popup.classList.add('show');
        });
    });

    function closePopup() {
        popup.classList.remove('show');
        formToSubmit = null;
    }

    btnBatal.onclick = popupClose.onclick = closePopup;

    btnKonfirmasi.onclick = function() {
        if (formToSubmit) formToSubmit.submit();
        closePopup();
    };

    // Optional: close popup if click outside content
    popup.addEventListener('click', function(e) {
        if (e.target === popup) closePopup();
    });
});
</script>

<script>
// Popup hapus produk
document.addEventListener('DOMContentLoaded', function() {
    let popup = document.getElementById('popupHapusProduk');
    let btnBatal = document.getElementById('btnBatalHapusProduk');
    let btnKonfirmasi = document.getElementById('btnKonfirmasiHapusProduk');
    let popupClose = popup.querySelector('.popup-close');
    let formToSubmit = null;

    document.querySelectorAll('.form-hapus-produk').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            formToSubmit = this;
            popup.classList.add('show');
        });
    });

    function closePopup() {
        popup.classList.remove('show');
        formToSubmit = null;
    }

    btnBatal.onclick = popupClose.onclick = closePopup;

    btnKonfirmasi.onclick = function() {
        if (formToSubmit) formToSubmit.submit();
        closePopup();
    };

    popup.addEventListener('click', function(e) {
        if (e.target === popup) closePopup();
    });
});

// Popup hapus ulasan
document.addEventListener('DOMContentLoaded', function() {
    let popup = document.getElementById('popupHapusUlasan');
    let btnBatal = document.getElementById('btnBatalHapusUlasan');
    let btnKonfirmasi = document.getElementById('btnKonfirmasiHapusUlasan');
    let popupClose = popup.querySelector('.popup-close');
    let formToSubmit = null;

    document.querySelectorAll('.form-hapus-ulasan').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            formToSubmit = this;
            popup.classList.add('show');
        });
    });

    function closePopup() {
        popup.classList.remove('show');
        formToSubmit = null;
    }

    btnBatal.onclick = popupClose.onclick = closePopup;

    btnKonfirmasi.onclick = function() {
        if (formToSubmit) formToSubmit.submit();
        closePopup();
    };

    popup.addEventListener('click', function(e) {
        if (e.target === popup) closePopup();
    });
});

// Modal edit produk
document.addEventListener('DOMContentLoaded', function() {
    let modal = document.getElementById('modalEditProduk');
    let closeBtns = modal.querySelectorAll('.popup-close');
    let form = document.getElementById('formEditProduk');

    document.querySelectorAll('.btn-edit[data-produk]').forEach(btn => {
        btn.addEventListener('click', function() {
            let data = JSON.parse(this.getAttribute('data-produk'));
            document.getElementById('edit_produk_id').value = data.id_pakaian;
            document.getElementById('edit_nama').value = data.nama_pakaian;
            document.getElementById('edit_harga').value = data.harga;
            document.getElementById('edit_kategori').value = data.kategori;
            document.getElementById('edit_ukuran').value = data.ukuran;
            document.getElementById('edit_kondisi').value = data.kondisi;
            modal.classList.add('show');
        });
    });

    closeBtns.forEach(btn => {
        btn.onclick = function() {
            modal.classList.remove('show');
        };
    });

    modal.addEventListener('click', function(e) {
        if (e.target === modal) modal.classList.remove('show');
    });
});

// Modal detail user
document.addEventListener('DOMContentLoaded', function() {
    let modal = document.getElementById('modalDetailUser');
    let closeBtn = modal.querySelector('.popup-close');
    let content = document.getElementById('detailUserContent');

    document.querySelectorAll('.btn-detail-user').forEach(btn => {
        btn.addEventListener('click', function() {
            let data = JSON.parse(this.getAttribute('data-user'));
            let foto = data.foto_profil ? "../upload/" + data.foto_profil : "https://ui-avatars.com/api/?name=" + encodeURIComponent(data.username);
            content.innerHTML = `
                <div style="text-align:center;margin-bottom:18px;">
                    <img src="${foto}" alt="Foto Profil" style="width:100px;height:100px;border-radius:50%;object-fit:cover;border:3px solid #eee;">
                </div>
                <table style="width:100%;font-size:16px;">
                    <tr><td style="font-weight:bold;width:120px;">ID User</td><td>: ${data.id_user}</td></tr>
                    <tr><td style="font-weight:bold;">Nama</td><td>: ${data.username}</td></tr>
                    <tr><td style="font-weight:bold;">Email</td><td>: ${data.email}</td></tr>
                    <tr><td style="font-weight:bold;">Tanggal Daftar</td><td>: ${data.tgl_daftar}</td></tr>
                    <tr><td style="font-weight:bold;">Alamat</td><td>: ${data.alamat}</td></tr>
                </table>
            `;
            modal.classList.add('show');
        });
    });

    closeBtn.onclick = function() {
        modal.classList.remove('show');
    };
    modal.addEventListener('click', function(e) {
        if (e.target === modal) modal.classList.remove('show');
    });
});
</script>