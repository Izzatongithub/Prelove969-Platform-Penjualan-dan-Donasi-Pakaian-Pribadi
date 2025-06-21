<section id="reviews-content" class="content-section active">
    <?php
    include "../config.php";

    // Pastikan hanya admin
    if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
        header("Location: ../index.php");
        exit;
    }

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

    <div class="search-filter-bar" style="display: flex; justify-content: space-between; margin-bottom: 10px;">
        <form method="get" style="flex: 1;">
            <input type="hidden" name="page" value="ulasan">
            <input type="text" name="search" placeholder="Cari nama..." value="<?= htmlspecialchars($search) ?>">
            <input type="hidden" name="filter" value="<?= $filter ?>">
            <button type="submit">Cari</button>
        </form>
        <form method="get">
            <input type="hidden" name="page" value="ulasan">
            <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
            <select name="filter" onchange="this.form.submit()">
                <option value="desc" <?= $filter === 'desc' ? 'selected' : '' ?>>Rating Tertinggi</option>
                <option value="asc" <?= $filter === 'asc' ? 'selected' : '' ?>>Rating Terendah</option>
            </select>
        </form>
    </div>

    <div class="table-container">
        <table>
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

    <div class="pagination" style="margin-top: 10px; text-align: center;">
        <?php for ($i = 1; $i <= $totalPage; $i++): ?>
            <a href="admin.php?page=ulasan&search=<?= urlencode($search) ?>&filter=<?= $filter ?>&p=<?= $i ?>"
               class="<?= $i == $page ? 'active' : '' ?>"
               style="margin: 0 3px; padding: 5px 10px; <?= $i == $page ? 'background-color:#ff69b4;color:#fff;' : 'background:#eee;color:#000;' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
</section>
