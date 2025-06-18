-- Backup tabel lama
CREATE TABLE donasi_pakaian_backup AS SELECT * FROM donasi_pakaian;

-- Drop tabel lama
DROP TABLE IF EXISTS donasi_pakaian;

-- Buat tabel baru dengan struktur yang diperbarui
CREATE TABLE donasi_pakaian (
    id_donasi INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT NOT NULL,
    nama VARCHAR(100) NOT NULL,
    no_telp VARCHAR(20) NOT NULL,
    kategori TEXT NOT NULL,
    jumlah_item INT NOT NULL,
    kondisi VARCHAR(50) NOT NULL,
    deskripsi TEXT,
    metode_donasi VARCHAR(50) NOT NULL,
    waktu_pickup DATETIME NULL DEFAULT NULL,
    alamat TEXT NOT NULL,
    foto TEXT,
    status_donasi ENUM('Menunggu Verifikasi', 'Terverifikasi', 'Dalam Proses', 'Selesai', 'Ditolak') DEFAULT 'Menunggu Verifikasi',
    alasan_penolakan TEXT,
    catatan_proses TEXT,
    keterangan_selesai TEXT,
    tanggal_donasi DATETIME DEFAULT CURRENT_TIMESTAMP,
    tanggal_verifikasi DATETIME NULL DEFAULT NULL,
    tanggal_proses DATETIME NULL DEFAULT NULL,
    tanggal_selesai DATETIME NULL DEFAULT NULL,
    tanggal_update DATETIME NULL DEFAULT NULL,
    FOREIGN KEY (id_user) REFERENCES users(id_user)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Migrasi data dari backup
INSERT INTO donasi_pakaian (
    id_donasi,
    id_user,
    nama,
    no_telp,
    metode_donasi,
    alamat,
    foto,
    status_donasi,
    tanggal_donasi
)
SELECT 
    id_donasi,
    id_user,
    nama,
    no_telp,
    metode_donasi,
    alamat,
    foto,
    status_donasi,
    tanggal_donasi
FROM donasi_pakaian_backup;

-- Drop tabel backup
DROP TABLE donasi_pakaian_backup; 