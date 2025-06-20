<?php
session_start();
include '../config.php'; // Sesuaikan path jika perlu

// --- AWAL BAGIAN PEMROSESAN FORM ---

// Proses hapus produk
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_produk_id'])) {
    $id = intval($_POST['hapus_produk_id']);
    mysqli_query($koneksi, "DELETE FROM pakaian WHERE id_pakaian = $id");
    // Hapus juga file foto terkait jika ada
    header("Location: admin.php?page=produk&msg=hapus_sukses");
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

    $id_kategori = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT id_kategori FROM kategori_pakaian WHERE kategori='$kategori'"))['id_kategori'];
    $id_ukuran = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT id_ukuran FROM ukuran_pakaian WHERE ukuran='$ukuran'"))['id_ukuran'];
    $id_kondisi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT id_kondisi FROM kondisi_pakaian WHERE kondisi='$kondisi'"))['id_kondisi'];

    mysqli_query($koneksi, "UPDATE pakaian SET nama_pakaian='$nama', harga='$harga', id_kategori='$id_kategori', id_ukuran='$id_ukuran', id_kondisi='$id_kondisi' WHERE id_pakaian=$id");
    header("Location: admin.php?page=produk&msg=edit_sukses");
    exit;
}

// Proses hapus ulasan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_ulasan_id'])) {
    $id = intval($_POST['hapus_ulasan_id']);
    mysqli_query($koneksi, "DELETE FROM ulasan WHERE id_ulasan = $id");
    header("Location: admin.php?page=ulasan&msg=hapus_sukses");
    exit;
}

// Proses approve ulasan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve_ulasan_id'])) {
    $id = intval($_POST['approve_ulasan_id']);
    mysqli_query($koneksi, "UPDATE ulasan SET status='disetujui' WHERE id_ulasan = $id");
    header("Location: admin.php?page=ulasan&msg=approve_sukses");
    exit;
}

// Proses update pengaturan umum
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_pengaturan_umum'])) {
    $nama_website = mysqli_real_escape_string($koneksi, $_POST['nama_website']);
    $copyright = mysqli_real_escape_string($koneksi, $_POST['copyright']);
    $tentang_kami = mysqli_real_escape_string($koneksi, $_POST['tentang_kami']);
    
    $q_pengaturan = mysqli_query($koneksi, "SELECT logo FROM pengaturan LIMIT 1");
    $logo = mysqli_fetch_assoc($q_pengaturan)['logo'];

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
    header("Location: admin.php?page=pengaturan&msg=update_sukses");
    exit;
}

// Proses aksi donasi (terima/tolak)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi_donasi']) && isset($_POST['id_donasi'])) {
    $id_donasi = intval($_POST['id_donasi']);
    $aksi = $_POST['aksi_donasi'];
    $status_baru = ($aksi === 'terima') ? 'diterima' : 'ditolak';
    
    mysqli_query($koneksi, "UPDATE donasi SET status='$status_baru' WHERE id_donasi=$id_donasi");
    header("Location: admin.php?page=donasi&msg=update_sukses");
    exit;
}

// --- AKHIR BAGIAN PEMROSESAN FORM ---

// Tentukan halaman yang akan dimuat
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
$page_file = "pages/{$page}.php";

// Sertakan bagian-bagian template
include 'parts/header.php';
?>

<div class="admin-wrapper">
    <?php include 'parts/sidebar.php'; ?>

    <main class="admin-main-content">
        <?php
        // Muat konten halaman dinamis
        if (file_exists($page_file)) {
            include $page_file;
        } else {
            // Tampilkan halaman error 404 jika file tidak ditemukan
            echo "<section class='content-section active'><h2>Error 404: Halaman Tidak Ditemukan</h2><p>Halaman yang Anda cari tidak ada.</p></section>";
        }
        ?>
    </main>
</div>

<?php
include 'parts/footer.php';
?>