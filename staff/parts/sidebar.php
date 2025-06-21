<aside class="admin-sidebar" id="adminSidebar">
    <nav class="sidebar-nav">
        <ul>
            <?php $active_page = isset($_GET['page']) ? $_GET['page'] : 'dashboard'; ?>
            <li class="nav-item <?= ($active_page == 'dashboard') ? 'active' : '' ?>">
                <a href="admin.php?page=dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            </li>
            <li class="nav-item <?= ($active_page == 'produk') ? 'active' : '' ?>">
                <a href="admin.php?page=produk"><i class="fas fa-box"></i> Produk</a>
            </li>
            <li class="nav-item <?= ($active_page == 'pengguna') ? 'active' : '' ?>">
                <a href="admin.php?page=pengguna"><i class="fas fa-users"></i> Pengguna</a>
            </li>
            <li class="nav-item <?= ($active_page == 'ulasan') ? 'active' : '' ?>">
                <a href="admin.php?page=ulasan"><i class="fas fa-comments"></i> Toko</a>
            </li>
            <li class="nav-item <?= ($active_page == 'donasi') ? 'active' : '' ?>">
                <a href="admin.php?page=donasi"><i class="fas fa-hand-holding-heart"></i> Donasi</a>
            </li>
            <li class="nav-item <?= ($active_page == 'laporan') ? 'active' : '' ?>">
                <a href="admin.php?page=laporan"><i class="fas fa-chart-line"></i> Laporan</a>
            </li>
            <li class="nav-item <?= ($active_page == 'pengaturan') ? 'active' : '' ?>">
                <a href="admin.php?page=pengaturan"><i class="fas fa-cog"></i> Pengaturan</a>
            </li>
        </ul>
    </nav>
</aside>