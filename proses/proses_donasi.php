<?php
include '../config.php'; // file koneksi ke database
session_start();

if (!isset($_SESSION['id_user'])) {
    die("Anda harus login terlebih dahulu");
}

// Debug: Tampilkan data yang diterima
error_log("POST data: " . print_r($_POST, true));
error_log("FILES data: " . print_r($_FILES, true));

// Validasi input
$errors = [];

// Validasi nama
$nama = trim($_POST['nama']);
if (empty($nama)) {
    $errors[] = "Nama tidak boleh kosong";
}

// Validasi no telp
$no_telp = trim($_POST['no_telp']);
if (empty($no_telp)) {
    $errors[] = "Nomor telepon tidak boleh kosong";
}

// Validasi kategori
$kategori = isset($_POST['kategori']) ? implode(", ", $_POST['kategori']) : '';
if (empty($kategori)) {
    $errors[] = "Pilih minimal satu kategori pakaian";
}

// Validasi jumlah
$jumlah = (int)$_POST['jumlah'];
if ($jumlah < 1) {
    $errors[] = "Jumlah item harus minimal 1";
}

// Validasi kondisi
$kondisi = trim($_POST['kondisi']);
if (empty($kondisi)) {
    $errors[] = "Pilih kondisi pakaian";
}

// Validasi metode donasi
$metode = trim($_POST['metode_donasi']);
if (empty($metode)) {
    $errors[] = "Pilih metode pengiriman";
}

// Validasi alamat
$alamat = trim($_POST['alamat']);
if (empty($alamat)) {
    $errors[] = "Alamat tidak boleh kosong";
}

// Optional fields
$deskripsi = trim($_POST['deskripsi']);
$waktu_pickup = null;
if ($metode === 'pickup' && !empty($_POST['waktu_pickup'])) {
    $waktu_pickup = $_POST['waktu_pickup'];
}

// Jika ada error, redirect kembali ke form
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    error_log("Validation errors: " . print_r($errors, true));
    header("Location: ../user/form_donasi.php");
    exit;
}

// Upload foto
$foto_names = [];
if (isset($_FILES['foto_produk'])) {
    foreach ($_FILES['foto_produk']['tmp_name'] as $key => $tmp_name) {
        if ($_FILES['foto_produk']['error'][$key] === UPLOAD_ERR_OK) {
            $nama_file = time() . '_' . $_FILES['foto_produk']['name'][$key];
            $tujuan = '../upload/' . $nama_file;

            if (move_uploaded_file($tmp_name, $tujuan)) {
                $foto_names[] = $nama_file;
            } else {
                error_log("Failed to move uploaded file: " . $nama_file);
            }
        } else {
            error_log("Upload error for file $key: " . $_FILES['foto_produk']['error'][$key]);
        }
    }
}

$foto = implode(",", $foto_names);

// Simpan ke database
$id_user = $_SESSION['id_user'];
$status_donasi = 'Menunggu Verifikasi';
$tanggal = date('Y-m-d H:i:s');

// Escape string untuk mencegah SQL injection
$nama = mysqli_real_escape_string($koneksi, $nama);
$no_telp = mysqli_real_escape_string($koneksi, $no_telp);
$kategori = mysqli_real_escape_string($koneksi, $kategori);
$kondisi = mysqli_real_escape_string($koneksi, $kondisi);
$deskripsi = mysqli_real_escape_string($koneksi, $deskripsi);
$metode = mysqli_real_escape_string($koneksi, $metode);
$alamat = mysqli_real_escape_string($koneksi, $alamat);
$foto = mysqli_real_escape_string($koneksi, $foto);

$sql = "INSERT INTO donasi_pakaian (
    id_user, 
    nama, 
    no_telp, 
    kategori,
    jumlah_item,
    kondisi,
    deskripsi,
    metode_donasi, 
    waktu_pickup,
    alamat, 
    foto,
    status_donasi,
    tanggal_donasi
) VALUES (
    '$id_user',
    '$nama',
    '$no_telp',
    '$kategori',
    $jumlah,
    '$kondisi',
    '$deskripsi',
    '$metode',
    " . ($waktu_pickup ? "'$waktu_pickup'" : "NULL") . ",
    '$alamat',
    '$foto',
    '$status_donasi',
    '$tanggal'
)";

error_log("SQL Query: " . $sql);

if (mysqli_query($koneksi, $sql)) {
    $_SESSION['success'] = "Donasi berhasil dikirim dan sedang menunggu verifikasi.";
    header("Location: ../user/riwayat_donasi.php");
} else {
    error_log("Database error: " . mysqli_error($koneksi));
    $_SESSION['errors'] = ["Terjadi kesalahan: " . mysqli_error($koneksi)];
    header("Location: ../user/form_donasi.php");
}

?>
