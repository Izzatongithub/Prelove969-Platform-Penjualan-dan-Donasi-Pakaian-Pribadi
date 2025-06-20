<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Preloved Store</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../frontend/style_admin.css?v=<?=time()?>">
    <style>
     .notif-hapus-user { display: none; position: fixed; top: 50%; left: 50%; z-index: 99999; transform: translate(-50%, -50%); background: #27ae60; color: #fff; padding: 28px 48px; border-radius: 12px; box-shadow: 0 8px 40px rgba(39,174,96,0.18); font-size: 22px; font-weight: 600; align-items: center; gap: 16px; animation: notifFadeIn 0.3s; }
     .notif-hapus-user.show { display: flex; }
     .notif-hapus-user .fa-check-circle { font-size: 32px; margin-right: 16px; }
     @keyframes notifFadeIn { from { opacity: 0; transform: translate(-50%, -60%);} to { opacity: 1; transform: translate(-50%, -50%);} }
    </style>
</head>
<body>

<?php if (isset($_GET['msg'])): ?>
<div id="notification" class="notif-hapus-user show">
    <div class="notif-content">
        <i class="fas fa-check-circle"></i>
        <span>
            <?php
            switch ($_GET['msg']) {
                case 'hapus_sukses': echo 'Data berhasil dihapus!'; break;
                case 'edit_sukses': echo 'Data berhasil diubah!'; break;
                case 'approve_sukses': echo 'Ulasan berhasil disetujui!'; break;
                case 'update_sukses': echo 'Perubahan berhasil disimpan!'; break;
                default: echo 'Aksi berhasil!';
            }
            ?>
        </span>
    </div>
</div>
<?php endif; ?>

<header class="admin-header">
    <div class="header-left">
        <button id="toggleSidebar" class="sidebar-toggle-btn"><i class="fas fa-bars"></i></button>
        <div class="logo">Prelove969</div>
    </div>
    <div class="header-right">
        <div class="admin-profile">
            <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
</header>