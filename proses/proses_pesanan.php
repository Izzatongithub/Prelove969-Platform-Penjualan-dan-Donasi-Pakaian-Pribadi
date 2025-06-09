<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_transaksi = $_POST['id_transaksi'];
    $status = $_POST['status_transaksi'];

    if (!empty($id_transaksi) && !empty($status)) {
        $update = mysqli_query($koneksi, "UPDATE transaksi SET status_transaksi = '$status' WHERE id_transaksi = '$id_transaksi'");
        if ($update) {
            header("Location: ../user/pesanan_masuk.php?msg=berhasil");
            exit();
        } else {
            echo "Gagal memperbarui status.";
        }
    } else {
        echo "Data tidak lengkap.";
    }
}
?>
