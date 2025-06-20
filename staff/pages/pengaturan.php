<?php
// Ambil data pengaturan saat ini
$pengaturan = ['logo' => '','nama_website' => '','copyright' => '','tentang_kami' => ''];
$q = mysqli_query($koneksi, "SELECT * FROM pengaturan LIMIT 1");
if ($q && ($row = mysqli_fetch_assoc($q))) {
    $pengaturan = $row;
}
?>
<section id="general-settings-content" class="content-section active">
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