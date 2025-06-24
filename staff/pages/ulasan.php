<section id="reviews-content" class="content-section active">
    <?php
    include "../config.php";

    // Pastikan hanya admin
    // if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
    //     header("Location: ../index.php");
    //     exit;
    // }

    // Ambil parameter dari URL
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $filter = isset($_GET['filter']) && $_GET['filter'] === 'asc' ? 'asc' : 'desc';
    $page = isset($_GET['p']) ? max(1, intval($_GET['p'])) : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    // Hitung total penjual
$qCount = "
    SELECT COUNT(*) as total FROM (
        SELECT u.id_user
        FROM user u
        LEFT JOIN pakaian p ON u.id_user = p.id_user
        WHERE p.id_pakaian IS NOT NULL";

if ($search !== '') {
    $qCount .= " AND u.nama LIKE '%" . mysqli_real_escape_string($koneksi, $search) . "%'";
}

$qCount .= " GROUP BY u.id_user ) as penjual";

$resCount = mysqli_query($koneksi, $qCount);
$totalData = mysqli_fetch_assoc($resCount)['total'];
$totalPage = ceil($totalData / $limit);


    // Ambil data penjual
$qPenjual = "
    SELECT u.id_user, u.nama, u.username, u.email,
           COUNT(p.id_pakaian) AS total_produk,
           ROUND(AVG(r.rating), 1) AS rata_rating
    FROM user u
    LEFT JOIN pakaian p ON u.id_user = p.id_user
    LEFT JOIN reviews r ON u.id_user = r.id_penjual
    WHERE p.id_pakaian IS NOT NULL";
if ($search !== '') {
    $qPenjual .= " AND u.nama LIKE '%" . mysqli_real_escape_string($koneksi, $search) . "%'";
}
$qPenjual .= "
    GROUP BY u.id_user
    ORDER BY rata_rating $filter
    LIMIT $limit OFFSET $offset";

    $res = mysqli_query($koneksi, $qPenjual);
    ?>

    <h2>Daftar Penjual</h2>

<div class="action-bar">
    <form method="get" class="search-filter" style="flex:1;display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
        <input type="hidden" name="page" value="ulasan">
        <input type="text" name="search" class="form-control" placeholder="Cari nama..." value="<?= htmlspecialchars($search) ?>" style="max-width:220px;">
        <button type="submit" class="btn btn-primary">Cari</button>
    </form>
    <div class="filter-kanan">
        <form method="get" style="margin:0;">
            <input type="hidden" name="page" value="ulasan">
            <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
            <select name="filter" class="form-select" onchange="this.form.submit()" style="max-width:180px;">
                <option value="desc" <?= $filter === 'desc' ? 'selected' : '' ?>>Rating Tertinggi</option>
                <option value="asc" <?= $filter === 'asc' ? 'selected' : '' ?>>Rating Terendah</option>
            </select>
        </form>
    </div>
</div>

    <div class="table-container">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID User</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Total Produk</th>
                    <th>Rating</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($res && mysqli_num_rows($res) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($res)): ?>
                        <tr>
                            <td><?= $row['id_user'] ?></td>
                            <td><?= htmlspecialchars($row['nama']) ?></td>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= $row['total_produk'] ?></td>
                            <td><?= $row['rata_rating'] !== null ? $row['rata_rating'] . '/5' : '-' ?></td>
                            <td>
                                <a href="../user/profil_penjual.php?id_user=<?= $row['id_user'] ?>" class="btn btn-sm btn-detail">
                                    <i class="fas fa-eye"></i> Lihat Profil
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7" style="text-align:center;">Data tidak ditemukan.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- <div class="pagination mt-3 text-center">
        <?php for ($i = 1; $i <= $totalPage; $i++): ?>
            <a href="admin.php?page=ulasan&search=<?= urlencode($search) ?>&filter=<?= $filter ?>&p=<?= $i ?>"
               class="btn btn-sm <?= $i == $page ? 'btn-primary' : 'btn-outline-secondary' ?> mx-1 <?= $i == $page ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div> -->

    <style>
    .action-bar {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 10px;
    }
    .filter-kanan {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-left: auto;
        min-width: 180px;
        /* Tambahkan agar mirip dengan search-filter */
        width: 100%;
        max-width: 220px;
    }
    .filter-kanan .form-select {
        border-radius: 5px;
        font-size: 15px;
        width: 100%;
        min-width: 180px;
        /* Tambahan agar konsisten */
        padding: 6px 12px;
        background: #fff;
        border: 1px solid #ced4da;
    }
    .filter-kanan form {
        width: 100%;
    }
    .search-filter {
        display: flex;
        gap: 10px;
        width: 100%;
        max-width: 600px;
        align-items: center;
        flex-wrap: wrap;
    }
    .search-filter .form-control {
        border-radius: 5px;
        font-size: 15px;
    }
    .search-filter .form-select {
        border-radius: 5px;
        font-size: 15px;
    }
    .search-filter .btn-primary {
        border-radius: 5px;
        font-size: 15px;
        min-width: 70px;
    }
    .search-filter [name="filter"] {
        min-width: 180px;
        margin-left: auto;
    }

    /* Style untuk tombol aksi lihat profil */
    .btn-detail {
        background-color: #ff6b9d;
        color: #fff !important;
        border-radius: 5px;
        padding: 4px 12px;
        font-size: 14px;
        transition: background 0.2s, color 0.2s;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
    }
    .btn-detail:hover, .btn-detail:focus {
        background-color: #e05585;
        color: #fff !important;
        text-decoration: none;
    }
    .btn-detail i {
        margin-right: 4px;
    }
    @media (max-width: 600px) {
        .action-bar {
            flex-direction: column;
            align-items: stretch;
        }
        .filter-kanan {
            margin-left: 0;
            width: 100%;
            max-width: 100%;
            margin-top: 10px;
        }
        .filter-kanan .form-select {
            width: 100%;
            max-width: 100%;
        }
        .search-filter {
            flex-direction: column;
            gap: 10px;
            max-width: 100%;
        }
        .search-filter .form-control,
        .search-filter .form-select,
        .search-filter .btn-primary {
            width: 100%;
            max-width: 100%;
        }
        .search-filter [name="filter"] {
            margin-left: 0;
            width: 100%;
        }
    }
    </style>
</section>
