</main>
</div>

<!-- Modals -->
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

<div id="modalEditProduk" class="popup-hapus-user">
    <div class="popup-content" style="max-width:400px;text-align:left;">
        <span class="popup-close">&times;</span>
        <h3>Edit Produk</h3>
        <form id="formEditProduk" method="POST" action="admin.php?page=produk">
            <input type="hidden" name="edit_produk_id" id="edit_produk_id">
            <div class="form-group"><label>Nama Produk</label><input type="text" name="edit_nama" id="edit_nama" required></div>
            <div class="form-group"><label>Harga</label><input type="number" name="edit_harga" id="edit_harga" required></div>
            <div class="form-group"><label>Kategori</label><select name="edit_kategori" id="edit_kategori" required>
                <?php $kategoriQ = mysqli_query($koneksi, "SELECT * FROM kategori_pakaian"); while ($kat = mysqli_fetch_assoc($kategoriQ)) { echo "<option value=\"{$kat['kategori']}\">{$kat['kategori']}</option>"; } ?>
            </select></div>
            <div class="form-group"><label>Ukuran</label><select name="edit_ukuran" id="edit_ukuran" required>
                <?php $ukuranQ = mysqli_query($koneksi, "SELECT * FROM ukuran_pakaian"); while ($uk = mysqli_fetch_assoc($ukuranQ)) { echo "<option value=\"{$uk['ukuran']}\">{$uk['ukuran']}</option>"; } ?>
            </select></div>
            <div class="form-group"><label>Kondisi</label><select name="edit_kondisi" id="edit_kondisi" required>
                <?php $kondisiQ = mysqli_query($koneksi, "SELECT * FROM kondisi_pakaian"); while ($kond = mysqli_fetch_assoc($kondisiQ)) { echo "<option value=\"{$kond['kondisi']}\">{$kond['kondisi']}</option>"; } ?>
            </select></div>
            <button type="submit" class="btn btn-success mt-3"><i class="fas fa-save"></i> Simpan Perubahan</button>
        </form>
    </div>
</div>

<div id="modalDetailUser" class="popup-hapus-user">
    <div class="popup-content" style="max-width:420px;text-align:left;">
        <span class="popup-close">&times;</span>
        <h3>Detail Pengguna</h3>
        <div id="detailUserContent"></div>
    </div>
</div>

<style>
/* (Letakkan semua CSS untuk popup/modal di sini) */
.popup-hapus-user { display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100vw; height: 100vh; background: rgba(44,62,80,0.6); align-items: center; justify-content: center; }
.popup-hapus-user.show { display: flex; }
.popup-hapus-user .popup-content { background: #fff; border-radius: 12px; padding: 32px 28px 24px; box-shadow: 0 8px 40px rgba(44,62,80,0.25); text-align: center; min-width: 320px; position: relative; animation: popupFadeIn 0.25s; }
@keyframes popupFadeIn { from { transform: scale(0.95); opacity: 0; } to { transform: scale(1); opacity: 1; } }
.popup-hapus-user .popup-close { position: absolute; top: 12px; right: 18px; font-size: 22px; color: #888; cursor: pointer; transition: color 0.2s; }
.popup-hapus-user .popup-close:hover { color: #e74c3c; }
.popup-hapus-user h3 { margin-top: 0; color: #2c3e50; }
.popup-hapus-user .popup-actions { margin-top: 24px; display: flex; gap: 18px; justify-content: center; }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Handle popup modals
document.addEventListener('DOMContentLoaded', function() {
    // Hapus produk modal
    const popupHapusProduk = document.getElementById('popupHapusProduk');
    if (popupHapusProduk) {
        const btnBatal = document.getElementById('btnBatalHapusProduk');
        const btnKonfirmasi = document.getElementById('btnKonfirmasiHapusProduk');
        const popupClose = popupHapusProduk.querySelector('.popup-close');
        
        btnBatal?.addEventListener('click', () => popupHapusProduk.classList.remove('show'));
        btnKonfirmasi?.addEventListener('click', () => {
            const form = document.getElementById('formHapusProduk');
            if (form) form.submit();
        });
        popupClose?.addEventListener('click', () => popupHapusProduk.classList.remove('show'));
        popupHapusProduk?.addEventListener('click', (e) => {
            if (e.target === popupHapusProduk) {
                popupHapusProduk.classList.remove('show');
            }
        });
    }

    // Hapus ulasan modal
    const popupHapusUlasan = document.getElementById('popupHapusUlasan');
    if (popupHapusUlasan) {
        const btnBatal = document.getElementById('btnBatalHapusUlasan');
        const btnKonfirmasi = document.getElementById('btnKonfirmasiHapusUlasan');
        const popupClose = popupHapusUlasan.querySelector('.popup-close');
        
        btnBatal?.addEventListener('click', () => popupHapusUlasan.classList.remove('show'));
        btnKonfirmasi?.addEventListener('click', () => {
            const form = document.getElementById('formHapusUlasan');
            if (form) form.submit();
        });
        popupClose?.addEventListener('click', () => popupHapusUlasan.classList.remove('show'));
        popupHapusUlasan?.addEventListener('click', (e) => {
            if (e.target === popupHapusUlasan) {
                popupHapusUlasan.classList.remove('show');
            }
        });
    }

    // Edit produk modal
    const modalEditProduk = document.getElementById('modalEditProduk');
    if (modalEditProduk) {
        const closeBtn = modalEditProduk.querySelector('.popup-close');
        const form = document.getElementById('formEditProduk');
        
        closeBtn?.addEventListener('click', () => modalEditProduk.classList.remove('show'));
        modalEditProduk?.addEventListener('click', (e) => {
            if (e.target === modalEditProduk) {
                modalEditProduk.classList.remove('show');
            }
        });
    }

    // Detail user modal
    const modalDetailUser = document.getElementById('modalDetailUser');
    if (modalDetailUser) {
        const closeBtn = modalDetailUser.querySelector('.popup-close');
        
        closeBtn?.addEventListener('click', () => modalDetailUser.classList.remove('show'));
        modalDetailUser?.addEventListener('click', (e) => {
            if (e.target === modalDetailUser) {
                modalDetailUser.classList.remove('show');
            }
        });
    }
});

// Skrip untuk notifikasi
setTimeout(function() {
    var notification = document.getElementById('notification');
    if (notification) {
        notification.style.display = 'none';
        // Hapus parameter 'msg' dari URL
        const url = new URL(window.location.href);
        url.searchParams.delete('msg');
        window.history.replaceState({}, document.title, url.pathname + url.search + url.hash);
    }
}, 2500);
        });
    });
    
    function closeModal() { modal.classList.remove('show'); }
    closeBtns.forEach(btn => btn.onclick = closeModal);
    modal.addEventListener('click', (e) => (e.target === modal) && closeModal());
});

// (Tambahkan skrip untuk modal/popup lainnya seperti Hapus Ulasan, Detail User, dll)

</script>
</body>
</html>