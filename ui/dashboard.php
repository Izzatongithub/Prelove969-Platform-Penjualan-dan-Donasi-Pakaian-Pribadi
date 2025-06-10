<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Prelove969</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Custom CSS Variables */
        :root {
            --primary-color: #ff6b9d;
            --secondary-color: #a8e6cf;
            --accent-color: #ffd93d;
            --light-pink: #ffe4e8;
            --light-green: #e8f5e8;
            --light-blue: #e3f2fd;
            --text-dark: #2c3e50;
            --text-light: #6c757d;
            --sidebar-width: 280px;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
        }

        /* Layout Structure */
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(135deg, var(--primary-color), #ff8fab);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transition: transform 0.3s ease;
            z-index: 1000;
        }

        .sidebar.collapsed {
            transform: translateX(-100%);
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
        }

        .sidebar-nav {
            padding: 20px 0;
        }

        .nav-item {
            margin-bottom: 5px;
        }

        .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left-color: white;
        }

        .nav-link i {
            width: 20px;
            margin-right: 10px;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s ease;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        /* Top Bar */
        .topbar {
            background: white;
            padding: 15px 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--text-dark);
            cursor: pointer;
            display: none;
        }

        .user-info {
            display: flex;
            align-items: center;
            margin-left: auto;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            margin-right: 10px;
        }

        /* Content Area */
        .content {
            padding: 30px;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 30px;
            color: var(--text-dark);
        }

        /* Stats Cards */
        .stats-row {
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
            border-left: 4px solid;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card.primary {
            border-left-color: var(--primary-color);
        }

        .stat-card.success {
            border-left-color: var(--secondary-color);
        }

        .stat-card.warning {
            border-left-color: var(--accent-color);
        }

        .stat-card.info {
            border-left-color: #17a2b8;
        }

        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .stat-icon.primary { color: var(--primary-color); }
        .stat-icon.success { color: var(--secondary-color); }
        .stat-icon.warning { color: var(--accent-color); }
        .stat-icon.info { color: #17a2b8; }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-label {
            color: var(--text-light);
            font-size: 0.9rem;
        }

        /* Items Section */
        .section-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }

        .section-header {
            padding: 20px 25px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin: 0;
        }

        .btn-add {
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 15px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .btn-add:hover {
            background: #ff8fab;
            color: white;
        }

        /* Item Cards */
        .items-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 25px;
        }

        .item-card {
            border: 1px solid #eee;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .item-card:hover {
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transform: translateY(-3px);
        }

        .item-image {
            height: 200px;
            background: #f8f9fa;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .item-image .placeholder {
            color: #ccc;
            font-size: 3rem;
        }

        .item-status {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-jual {
            background: var(--primary-color);
            color: white;
        }

        .status-donasi {
            background: var(--secondary-color);
            color: white;
        }

        .status-sold {
            background: #6c757d;
            color: white;
        }

        .status-donated {
            background: #28a745;
            color: white;
        }

        .status-active {
            background: var(--accent-color);
            color: #333;
        }

        .item-info {
            padding: 15px;
        }

        .item-name {
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 1.1rem;
        }

        .item-price {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 10px;
        }

        .item-meta {
            color: var(--text-light);
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        .item-actions {
            display: flex;
            gap: 8px;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.85rem;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background: #17a2b8;
            color: white;
        }

        .btn-edit:hover {
            background: #138496;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background: #c82333;
        }

        .btn-view {
            background: var(--accent-color);
            color: #333;
        }

        .btn-view:hover {
            background: #ffed4a;
        }

        /* Profile Section */
        .profile-card {
            padding: 25px;
        }

        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: 600;
            margin-right: 20px;
        }

        .profile-info h3 {
            margin: 0 0 5px 0;
            color: var(--text-dark);
        }

        .profile-role {
            color: var(--text-light);
            margin-bottom: 15px;
        }

        .profile-actions {
            display: flex;
            gap: 10px;
        }

        .btn-outline {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-outline:hover {
            background: var(--primary-color);
            color: white;
        }

        /* Transaction Table */
        .table-responsive {
            background: white;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            background: #f8f9fa;
            border-top: none;
            font-weight: 600;
            color: var(--text-dark);
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-selesai {
            background: #d4edda;
            color: #155724;
        }

        .status-proses {
            background: #fff3cd;
            color: #856404;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: block;
            }

            .items-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .content {
                padding: 20px 15px;
            }

            .items-grid {
                grid-template-columns: 1fr;
                padding: 15px;
            }

            .stats-row .col-md-3 {
                margin-bottom: 15px;
            }
        }

        /* Loading States */
        .loading {
            text-align: center;
            padding: 40px;
            color: var(--text-light);
        }

        .loading i {
            font-size: 2rem;
            margin-bottom: 10px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-light);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #dee2e6;
        }

        .empty-state h4 {
            margin-bottom: 10px;
            color: var(--text-dark);
        }

        /* Notification styles */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            z-index: 9999;
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.3s ease;
        }

        .notification.show {
            opacity: 1;
            transform: translateX(0);
        }

        .notification.success {
            background: #28a745;
        }

        .notification.error {
            background: #dc3545;
        }

        .notification.warning {
            background: #ffc107;
            color: #333;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="#" class="sidebar-brand">
                <i class="fas fa-tshirt me-2"></i>Prelove969
            </a>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-item">
                <a href="#" class="nav-link active" data-section="dashboard">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link" data-section="items">
                    <i class="fas fa-tshirt"></i>
                    Item Saya
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link" data-section="transactions">
                    <i class="fas fa-exchange-alt"></i>
                    Riwayat Transaksi
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link" data-section="profile">
                    <i class="fas fa-user"></i>
                    Profil Saya
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-cog"></i>
                    Pengaturan
                </a>
            </div>
            <hr style="border-color: rgba(255,255,255,0.1); margin: 20px 0;">
            <div class="nav-item">
                <a href="#" class="nav-link" onclick="logout()">
                    <i class="fas fa-sign-out-alt"></i>
                    Keluar
                </a>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Bar -->
        <div class="topbar">
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <div class="user-info">
                <div class="user-avatar">AS</div>
                <div>
                    <div style="font-weight: 600;">Andi Santoso</div>
                    <div style="font-size: 0.8rem; color: var(--text-light);">Penjual & Pendonor</div>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content">
            <!-- Dashboard Section -->
            <div id="dashboardSection" class="content-section">
                <h1 class="page-title">
                    <i class="fas fa-home me-2" style="color: var(--primary-color);"></i>
                    Dashboard
                </h1>

                <!-- Stats Row -->
                <div class="row stats-row">
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="stat-card primary">
                            <div class="stat-icon primary">
                                <i class="fas fa-tshirt"></i>
                            </div>
                            <div class="stat-number" id="totalItems">12</div>
                            <div class="stat-label">Total Item</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="stat-card success">
                            <div class="stat-icon success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-number" id="completedItems">8</div>
                            <div class="stat-label">Terjual/Terdonasi</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="stat-card warning">
                            <div class="stat-icon warning">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stat-number" id="activeItems">4</div>
                            <div class="stat-label">Masih Aktif</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="stat-card info">
                            <div class="stat-icon info">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div class="stat-number" id="totalEarnings">2.4M</div>
                            <div class="stat-label">Total Penjualan</div>
                        </div>
                    </div>
                </div>

                <!-- Recent Items -->
                <div class="section-card">
                    <div class="section-header">
                        <h3 class="section-title">Item Terbaru</h3>
                        <button class="btn-add" onclick="showAddItemModal()">
                            <i class="fas fa-plus me-1"></i>Tambah Item
                        </button>
                    </div>
                    <div class="items-grid" id="recentItems">
                        <!-- Items will be loaded here -->
                    </div>
                </div>
            </div>

            <!-- Items Section -->
            <div id="itemsSection" class="content-section" style="display: none;">
                <h1 class="page-title">
                    <i class="fas fa-tshirt me-2" style="color: var(--primary-color);"></i>
                    Item Saya
                </h1>

                <div class="section-card">
                    <div class="section-header">
                        <h3 class="section-title">Semua Item Pakaian</h3>
                        <button class="btn-add" onclick="showAddItemModal()">
                            <i class="fas fa-plus me-1"></i>Tambah Item Baru
                        </button>
                    </div>
                    <div class="items-grid" id="allItems">
                        <!-- All items will be loaded here -->
                    </div>
                </div>
            </div>

            <!-- Transactions Section -->
            <div id="transactionsSection" class="content-section" style="display: none;">
                <h1 class="page-title">
                    <i class="fas fa-exchange-alt me-2" style="color: var(--primary-color);"></i>
                    Riwayat Transaksi
                </h1>

                <div class="section-card">
                    <div class="section-header">
                        <h3 class="section-title">Riwayat Aktivitas</h3>
                    </div>
                    <div class="table-responsive" style="padding: 25px;">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Tipe</th>
                                    <th>Penerima/Pembeli</th>
                                    <th>Harga</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="transactionsList">
                                <!-- Transactions will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Profile Section -->
            <div id="profileSection" class="content-section" style="display: none;">
                <h1 class="page-title">
                    <i class="fas fa-user me-2" style="color: var(--primary-color);"></i>
                    Profil Saya
                </h1>

                <div class="section-card">
                    <div class="profile-card">
                        <div class="profile-header">
                            <div class="profile-avatar">AS</div>
                            <div class="profile-info">
                                <h3>Andi Santoso</h3>
                                <div class="profile-role">Penjual & Pendonor Aktif</div>
                                <div style="color: var(--text-light); margin-bottom: 10px;">
                                    <i class="fas fa-envelope me-2"></i>andi.santoso@email.com
                                </div>
                                <div style="color: var(--text-light); margin-bottom: 15px;">
                                    <i class="fas fa-map-marker-alt me-2"></i>Jakarta, Indonesia
                                </div>
                                <div class="profile-actions">
                                    <a href="#" class="btn-outline" onclick="editProfile()">
                                        <i class="fas fa-edit me-1"></i>Edit Profil
                                    </a>
                                    <a href="#" class="btn-outline" onclick="changePassword()">
                                        <i class="fas fa-key me-1"></i>Ubah Password
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Statistik Aktivitas</h5>
                                <ul class="list-unstyled">
                                    <li><strong>Bergabung:</strong> Januari 2024</li>
                                    <li><strong>Total Upload:</strong> 12 item</li>
                                    <li><strong>Berhasil Terjual:</strong> 5 item</li>
                                    <li><strong>Berhasil Didonasi:</strong> 3 item</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5>Preferensi</h5>
                                <ul class="list-unstyled">
                                    <li><strong>Kategori Favorit:</strong> Pakaian Wanita</li>
                                    <li><strong>Lokasi Utama:</strong> Jakarta</li>
                                    <li><strong>Rating:</strong> ⭐⭐⭐⭐⭐ (4.8/5)</li>
                                    <li><strong>Verifikasi:</strong> ✅ Terverifikasi</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        // Sample Data - In real app, this would come from API/Database
        const userData = {
            name: "Andi Santoso",
            email: "andi.santoso@email.com",
            role: "Penjual & Pendonor",
            avatar: "AS",
            location: "Jakarta"
        };

        const sampleItems = [
            {
                id: 1,
                name: "Kemeja Formal Biru",
                category: "Pria",
                size: "L",
                condition: "Seperti Baru",
                type: "jual",
                price: 150000,
                status: "active",
                uploadDate: "2024-06-01",
                image: null
            },
            {
                id: 2,
                name: "Dress Casual Pink",
                category: "Wanita",
                size: "M",
                condition: "Baru",
                type: "donasi",
                price: 0,
                status: "donated",
                uploadDate: "2024-06-05",
                image: null
            },
            {
                id: 3,
                name: "Jaket Denim Vintage",
                category: "Wanita",
                size: "S",
                condition: "Lumayan",
                type: "jual",
                price: 200000,
                status: "sold",
                uploadDate: "2024-06-08",
                image: null
            },
            {
                id: 4,
                name: "Kaos Anak Karakter",
                category: "Anak",
                size: "XS",
                condition: "Seperti Baru",
                type: "donasi",
                price: 0,
                status: "active",
                uploadDate: "2024-06-10",
                image: null
            },
            {
                id: 5,
                name: "Blazer Kantor Hitam",
                category: "Wanita",
                size: "M",
                condition: "Seperti Baru",
                type: "jual",
                price: 300000,
                status: "active",
                uploadDate: "2024-06-12",
                image: null
            }
        ];

        const sampleTransactions = [
            {
                id: 1,
                itemName: "Jaket Denim Vintage",
                type: "Penjualan",
                buyer: "Sari Dewi",
                price: 200000,
                date: "2024-06-08",
                status: "Selesai"
            },
            {
                id: 2,
                itemName: "Dress Casual Pink",
                type: "Donasi",
                buyer: "Yayasan Peduli Anak",
                price: 0,
                date: "2024-06-07",
                status: "Selesai"
            },
            {
                id: 3,
                itemName: "Kemeja Batik",
                type: "Penjualan",
                buyer: "Budi Pratama",
                price: 125000,
                date: "2024-06-05",
                status: "Selesai"
            }
        ];

        // DOM Elements
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const mainContent = document.getElementById('mainContent');
        const navLinks = document.querySelectorAll('.nav-link[data-section]');
        const contentSections = document.querySelectorAll('.content-section');

        // Initialize Dashboard
        document.addEventListener('DOMContentLoaded', function() {
            // Check authentication (simulate)
            if (!checkAuth()) {
                alert('Silakan login terlebih dahulu!');
                // In real app: window.location.href = 'login.html';
                return;
            }

            // Load initial data
            loadDashboardData();
            loadItems();
            loadTransactions();
            updateStats();

            // Set up event listeners
            setupEventListeners();
        });

        function checkAuth() {
            // In real app, check for valid session/token
            // Example: check if JWT token exists and is valid
            const token = localStorage.getItem('authToken');
            return true; // For demo, always return true
        }

        // function setupEventListeners() {
        //     // Sidebar toggle
        //     sidebarToggle.addEventListener('click', function() {
        //         sidebar.classList.toggle('show');
        //     });

        //     // Navigation
        //     navLinks.forEach(link => {
        //         link.addEventListener('