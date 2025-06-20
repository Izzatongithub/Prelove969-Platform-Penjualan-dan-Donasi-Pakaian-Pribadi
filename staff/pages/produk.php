<section id="all-products-content" class="content-section active">
    <h2>Semua Produk</h2>
    <div class="action-bar">
        <form method="get" action="" class="search-filter" style="display:flex;gap:10px;">
            <input type="hidden" name="page" value="produk">
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
                $page = isset($_GET['p']) ? max(1, intval($_GET['p'])) : 1;
                $limit = 10;
                $offset = ($page - 1) * $limit;
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
                // Query untuk data produk (LIMIT)
                $query = "SELECT p.id_pakaian, p.nama_pakaian, p.harga, k.kategori, u.ukuran, c.kondisi, f.path_foto
                    FROM pakaian p
                    LEFT JOIN kategori_pakaian k ON p.id_kategori = k.id_kategori
                    LEFT JOIN ukuran_pakaian u ON p.id_ukuran = u.id_ukuran
                    LEFT JOIN kondisi_pakaian c ON p.id_kondisi = c.id_kondisi
                    LEFT JOIN (SELECT * FROM foto_produk WHERE urutan = 1) f ON p.id_pakaian = f.id_pakaian
                    $whereSql
                    ORDER BY p.id_pakaian DESC
                    LIMIT $limit OFFSET $offset";
                $result = mysqli_query($koneksi, $query);
                // Query untuk total data
                $totalQ = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pakaian p LEFT JOIN kategori_pakaian k ON p.id_kategori = k.id_kategori $whereSql");
                $totalRow = mysqli_fetch_assoc($totalQ);
                $totalData = $totalRow ? intval($totalRow['total']) : 0;
                $hasMore = ($offset + $limit) < $totalData;
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
        <?php if ($hasMore || $page > 1): ?>
            <div style="text-align:center;margin:18px 0;display:flex;justify-content:center;gap:10px;">
                <?php if ($page > 1): ?>
                    <a href="?page=produk<?= isset($_GET['search_produk']) ? '&search_produk=' . urlencode($_GET['search_produk']) : '' ?><?= isset($_GET['filter_kategori']) ? '&filter_kategori=' . urlencode($_GET['filter_kategori']) : '' ?>&p=<?= $page-1 ?>" class="pagination-btn">Previous</a>
                <?php endif; ?>
                <?php if ($hasMore): ?>
                    <a href="?page=produk<?= isset($_GET['search_produk']) ? '&search_produk=' . urlencode($_GET['search_produk']) : '' ?><?= isset($_GET['filter_kategori']) ? '&filter_kategori=' . urlencode($_GET['filter_kategori']) : '' ?>&p=<?= $page+1 ?>" class="pagination-btn">See More</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

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

<style>
.pagination-btn {
    display: inline-block;
    padding: 8px 22px;
    border-radius: 6px;
    font-size: 15px;
    font-weight: 500;
    border: none;
    background: #f4f6fa;
    color: #222 !important;
    margin: 0 2px;
    transition: background 0.18s, color 0.18s;
    box-shadow: 0 1px 3px rgba(44,62,80,0.07);
    cursor: pointer;
    text-decoration: none;
}
.pagination-btn:hover, .pagination-btn.active {
    background: #2d6cdf;
    color: #fff !important;
}
.pagination-btn:disabled {
    background: #e9ecef;
    color: #aaa !important;
    cursor: not-allowed;
}
</style>

<script>
// Popup hapus produk
let popupHapusProduk = document.getElementById('popupHapusProduk');
let btnBatalHapusProduk = document.getElementById('btnBatalHapusProduk');
let btnKonfirmasiHapusProduk = document.getElementById('btnKonfirmasiHapusProduk');
let popupCloseHapusProduk = popupHapusProduk.querySelector('.popup-close');
let formToSubmitProduk = null;
document.querySelectorAll('.form-hapus-produk').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        formToSubmitProduk = this;
        popupHapusProduk.classList.add('show');
    });
});
function closePopupHapusProduk() {
    popupHapusProduk.classList.remove('show');
    formToSubmitProduk = null;
}
btnBatalHapusProduk.onclick = popupCloseHapusProduk.onclick = closePopupHapusProduk;
btnKonfirmasiHapusProduk.onclick = function() {
    if (formToSubmitProduk) formToSubmitProduk.submit();
    closePopupHapusProduk();
};
popupHapusProduk.addEventListener('click', function(e) {
    if (e.target === popupHapusProduk) closePopupHapusProduk();
});
// Modal edit produk
let modalEditProduk = document.getElementById('modalEditProduk');
let closeBtnsEditProduk = modalEditProduk.querySelectorAll('.popup-close');
let formEditProduk = document.getElementById('formEditProduk');
document.querySelectorAll('.btn-edit[data-produk]').forEach(btn => {
    btn.addEventListener('click', function() {
        let data = JSON.parse(this.getAttribute('data-produk'));
        document.getElementById('edit_produk_id').value = data.id_pakaian;
        document.getElementById('edit_nama').value = data.nama_pakaian;
        document.getElementById('edit_harga').value = data.harga;
        document.getElementById('edit_kategori').value = data.kategori;
        document.getElementById('edit_ukuran').value = data.ukuran;
        document.getElementById('edit_kondisi').value = data.kondisi;
        modalEditProduk.classList.add('show');
    });
});
closeBtnsEditProduk.forEach(btn => {
    btn.onclick = function() {
        modalEditProduk.classList.remove('show');
    };
});
modalEditProduk.addEventListener('click', function(e) {
    if (e.target === modalEditProduk) modalEditProduk.classList.remove('show');
});
</script>