# Prelove969: Platform Penjualan dan Donasi Pakaian Pribadi

## 📋 Deskripsi

Prelove969 adalah platform berbasis web yang dirancang untuk memfasilitasi penjualan dan donasi pakaian bekas (preloved) yang masih layak pakai. Platform ini tidak hanya mempermudah transaksi jual-beli pakaian bekas, tetapi juga mendorong pengurangan limbah tekstil dan gaya hidup berkelanjutan melalui fitur donasi yang terintegrasi.

### 🎯 Tujuan Platform
- Memfasilitasi penjualan pakaian bekas yang masih layak pakai
- Mendorong budaya donasi pakaian untuk mengurangi limbah tekstil
- Menyediakan platform yang mudah digunakan untuk transaksi online
- Mendukung ekonomi sirkular dalam industri fashion

## ✨ Fitur Utama

### 👤 Fitur Pengguna (User)
1. **Manajemen Akun**
   - Registrasi dan login pengguna
   - Edit profil dan foto profil
   - Riwayat transaksi dan donasi

2. **E-commerce**
   - Belanja produk pakaian bekas
   - Keranjang belanja
   - Wishlist produk
   - Sistem rating dan review toko
   - Detail produk dengan foto

3. **Penjualan**
   - Upload dan jual produk pakaian
   - Edit dan hapus produk
   - Kelola pesanan masuk
   - Profil toko penjual

4. **Donasi**
   - Form donasi pakaian
   - Pilihan metode donasi (antar langsung/drop point)
   - Riwayat donasi
   - Status tracking donasi

5. **Pembayaran**
   - Integrasi Midtrans untuk pembayaran
   - Multiple payment methods
   - Konfirmasi pembayaran
   - Status pembayaran real-time

### 👨‍💼 Fitur Staff
1. **Manajemen Donasi**
   - Kelola donasi masuk (tambah, update, delete)
   - Update status donasi (menunggu, diterima, dalam proses, selesai)
   - Verifikasi donasi
   - Tracking donasi

2. **Laporan**
   - Cetak laporan donasi
   - Export data donasi
   - Monitoring donasi

### 👨‍💻 Fitur Admin
1. **Manajemen Pengguna**
   - Kelola data user (tambah, update, delete)
   - Monitoring aktivitas pengguna
   - Manajemen role dan permission

2. **Manajemen Konten**
   - Kelola konten website
   - Modifikasi fitur website
   - Hapus produk bermasalah

3. **Manajemen Donasi**
   - Kelola fitur donasi (tambah, update, delete)
   - Monitoring sistem donasi
   - Konfigurasi donasi

4. **Dashboard & Analytics**
   - Dashboard dengan statistik
   - Laporan penjualan
   - Laporan donasi
   - Monitoring sistem

## 🛠️ Teknologi yang Digunakan

### Backend
- **PHP** - Bahasa pemrograman utama
- **MySQL** - Database management system
- **Apache** - Web server

### Frontend
- **HTML5** - Struktur halaman web
- **CSS3** - Styling dan layout
- **JavaScript** - Interaktivitas client-side
- **Bootstrap** - Framework CSS untuk responsive design

### Payment Gateway
- **Midtrans** - Integrasi pembayaran online
- **Snap** - Payment popup
- **Core API** - Direct payment integration

### Development Tools
- **Composer** - Dependency management
- **XAMPP** - Local development environment

## 📁 Struktur Proyek

```
Prelove969-Platform-Penjualan-dan-Donasi-Pakaian-Pribadi/
├── admin/                 # Panel admin
├── auth/                  # Sistem autentikasi
├── bootstrap/             # Framework Bootstrap
├── frontend/              # Asset frontend
├── midtrans/              # Integrasi payment gateway
├── proses/                # File proses backend
├── staff/                 # Panel staff
├── ui/                    # Interface pengguna
├── upload/                # File upload (gambar)
├── user/                  # Halaman pengguna
├── vendor/                # Dependencies
├── config.php             # Konfigurasi database
└── index.php              # Halaman utama
```

## 🚀 Instalasi dan Setup

### Prasyarat
- PHP 7.4 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Apache/Nginx web server
- Composer (untuk dependency management)

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone [repository-url]
   cd Prelove969-Platform-Penjualan-dan-Donasi-Pakaian-Pribadi
   ```

2. **Setup Database**
   - Import file `prelove_2.sql` ke MySQL
   - Konfigurasi database di `config.php`

3. **Install Dependencies**
   ```bash
   composer install
   ```

4. **Konfigurasi Midtrans**
   - Update konfigurasi Midtrans di file terkait
   - Set environment variables untuk production

5. **Setup Web Server**
   - Arahkan document root ke folder proyek
   - Pastikan folder `upload/` memiliki permission write

6. **Testing**
   - Akses website melalui browser
   - Test fitur registrasi dan login
   - Verifikasi integrasi pembayaran

## 📖 Panduan Penggunaan

### Untuk Pengguna
1. **Registrasi/Login** - Buat akun atau login ke platform
2. **Beli Produk** - Jelajahi katalog, tambah ke keranjang, checkout
3. **Jual Produk** - Upload foto dan detail produk
4. **Donasi** - Isi form donasi dan pilih metode pengiriman
5. **Kelola Akun** - Update profil dan lihat riwayat

### Untuk Staff
1. **Login Staff** - Akses panel staff
2. **Kelola Donasi** - Review dan update status donasi
3. **Generate Laporan** - Cetak laporan donasi

### Untuk Admin
1. **Login Admin** - Akses panel admin
2. **Kelola Pengguna** - Monitor dan kelola user
3. **Kelola Konten** - Modifikasi fitur website
4. **Monitoring** - Lihat dashboard dan analytics

## 🔧 Konfigurasi

### Database Configuration
Edit file `config.php`:
```php
$host = 'localhost';
$username = 'your_username';
$password = 'your_password';
$database = 'prelove_db';
```

### Midtrans Configuration
Update konfigurasi Midtrans untuk environment yang sesuai:
```php
// Sandbox/Production
Midtrans\Config::$serverKey = 'your_server_key';
Midtrans\Config::$clientKey = 'your_client_key';
Midtrans\Config::$isProduction = false; // true for production
```

## 📊 Database Schema

Platform menggunakan database MySQL dengan tabel utama:
- `users` - Data pengguna
- `products` - Data produk
- `orders` - Data pesanan
- `donations` - Data donasi
- `reviews` - Data review/rating
- `wishlist` - Data wishlist pengguna

## 🔒 Keamanan

- Password hashing menggunakan PHP password_hash()
- Session management yang aman
- Input validation dan sanitization
- CSRF protection
- SQL injection prevention

## 📱 Responsive Design

Website didesain responsive menggunakan Bootstrap untuk kompatibilitas dengan berbagai device:
- Desktop
- Tablet
- Mobile

## 🤝 Kontribusi

Untuk berkontribusi pada proyek ini:
1. Fork repository
2. Buat branch fitur baru
3. Commit perubahan
4. Push ke branch
5. Buat Pull Request

## 📄 Lisensi

Proyek ini dilisensikan di bawah [Lisensi yang sesuai]

## 📞 Kontak

Untuk pertanyaan atau dukungan:
- Email: [email]
- Website: [website]
- Dokumentasi: [link dokumentasi]

## 🔄 Changelog

### Version 1.0.0
- Fitur dasar e-commerce
- Sistem donasi
- Integrasi Midtrans
- Panel admin dan staff
- Responsive design

---

**Prelove969** - Platform Penjualan dan Donasi Pakaian Pribadi

## Tertanda
- Fitri Nufa Dastana
- Izzat Nazhiefa
- M. Wahyu Hilal Abroor

