<?php
include "../config.php"; // sesuaikan path jika diperlukan
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_SESSION['id_user'];
    $nama_pakaian = $_POST['nama_pakaian'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $id_kategori = $_POST['kategori'];
    $id_ukuran = $_POST['ukuran'];
    $id_kondisi = $_POST['kondisi'];
    $gender = $_POST['gender'];

    // 1. Simpan data ke tabel produk
    $sql = "INSERT INTO pakaian (id_user, nama_pakaian, gender, deskripsi, harga, id_kategori, id_ukuran, id_kondisi) 
        VALUES ($id_user, '$nama_pakaian', '$gender', '$deskripsi', $harga, $id_kategori, $id_ukuran, $id_kondisi)";

    $perintah = mysqli_query($koneksi, $sql);

      // Cek apakah produk berhasil disimpan
    if ($perintah) {
        $id_produk = mysqli_insert_id($koneksi); // ID produk terakhir disimpan

        // Proses upload semua foto
        $jumlah_foto = count($_FILES['foto_produk']['name']);

       // Pastikan ada file yang dipilih
        if ($jumlah_foto > 0) {
            for ($i = 0; $i < $jumlah_foto; $i++) {
                $nama_file = $_FILES['foto_produk']['name'][$i];
                $tmp_file  = $_FILES['foto_produk']['tmp_name'][$i];
                $path = "../upload/" . $nama_file;
                $urutan = $i + 1; // Urutan foto (1, 2, 3...)

                // Pastikan file berhasil dipindahkan
                if (move_uploaded_file($tmp_file, $path)) {
                    echo "Upload berhasil: $nama_file <br>";

                    // Masukkan data ke tabel foto_produk
                    $query_foto = "INSERT INTO foto_produk (id_pakaian, nama_file, path_foto, urutan)
                        VALUES ('$id_produk', '$nama_file', '$path', '$urutan')";

                    if (!mysqli_query($koneksi, $query_foto)) {
                        echo "Gagal insert DB: " . mysqli_error($koneksi) . "<br>";
                    }
                } else {
                    echo "Gagal upload file: $nama_file <br>";
                }
            }
        }
        echo "Produk dan semua foto berhasil diunggah!";
        header("location: ../user/jual_pakaian.php");
    } else {
        // echo "Gagal menyimpan produk.";
         echo "Error: " . mysqli_error($koneksi);
    }
} else {
    echo "Akses tidak sah.";
}
?>
