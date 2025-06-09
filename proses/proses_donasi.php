<?php
include '../config.php'; // file koneksi ke database

// Ambil data dari form
$nama = $_POST['nama'];
$no_telp = $_POST['no_telp'];
// $jenis = $_POST['jenis_pakaian'];
// $ukuran = $_POST['ukuran'];
// $kondisi = $_POST['kondisi'];
// $jumlah = $_POST['jumlah'];
$metode = $_POST['metode_donasi'];
$alamat = $_POST['alamat'];

// Upload foto jika ada
$foto = '';
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $tmp = $_FILES['foto']['tmp_name'];
    $nama_file = time() . '_' . $_FILES['foto']['name'];
    $tujuan = '../upload/' . $nama_file;

    if (move_uploaded_file($tmp, $tujuan)) {
        $foto = $nama_file;
    }
}

// Simpan ke database
$sql = "INSERT INTO donasi (nama, no_telp, metode_donasi, alamat, foto) 
    VALUES ('$nama', '$no_telp', '$metode', '$alamat', '$foto')";

$result = mysqli_query($koneksi, $sql);
$cek = mysqli_num_rows($result);

    if ($result) {
        echo "Donasi berhasil dikirim.";
        header("location: ../user/form_donasi.php");
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }

?>
