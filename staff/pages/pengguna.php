<section id="users-content" class="content-section active">
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

<!-- Popup Konfirmasi Hapus User -->
<div id="popupHapusUser" class="popup-hapus-user">
    <div class="popup-content">
        <span class="popup-close">&times;</span>
        <h3>Konfirmasi Hapus User</h3>
        <p>Apakah Anda yakin ingin menghapus user ini?<br><b>Tindakan ini tidak dapat dibatalkan!</b></p>
        <div class="popup-actions">
            <button id="btnBatalHapusUser" class="btn btn-secondary">Batal</button>
            <button id="btnKonfirmasiHapusUser" class="btn btn-danger">Hapus</button>
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
// Popup hapus user
let popupHapusUser = document.getElementById('popupHapusUser');
let btnBatalHapusUser = document.getElementById('btnBatalHapusUser');
let btnKonfirmasiHapusUser = document.getElementById('btnKonfirmasiHapusUser');
let popupCloseHapusUser = popupHapusUser ? popupHapusUser.querySelector('.popup-close') : null;
let formToSubmitUser = null;
document.querySelectorAll('.form-hapus-user').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        formToSubmitUser = this;
        popupHapusUser.classList.add('show');
    });
});
function closePopupHapusUser() {
    popupHapusUser.classList.remove('show');
    formToSubmitUser = null;
}
if (btnBatalHapusUser && popupCloseHapusUser) {
    btnBatalHapusUser.onclick = popupCloseHapusUser.onclick = closePopupHapusUser;
}
if (btnKonfirmasiHapusUser) {
    btnKonfirmasiHapusUser.onclick = function() {
        if (formToSubmitUser) formToSubmitUser.submit();
        closePopupHapusUser();
    };
}
if (popupHapusUser) {
    popupHapusUser.addEventListener('click', function(e) {
        if (e.target === popupHapusUser) closePopupHapusUser();
    });
}

// Modal detail user
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
</script>