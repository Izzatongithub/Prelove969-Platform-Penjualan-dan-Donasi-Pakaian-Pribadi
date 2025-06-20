<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_user'])) {
    $id_user = intval($_POST['id_user']);
    $query = "DELETE FROM user WHERE id_user = $id_user";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header("Location: admin.php?msg=hapus_sukses");
        exit;
    } else {
        header("Location: admin.php?msg=hapus_gagal");
        exit;
    }
} else {
    header("Location: admin.php");
    exit;
}
?>
