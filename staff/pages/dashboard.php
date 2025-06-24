<?php
// Statistik dan grafik
// Total Penjualan
$q = mysqli_query($koneksi, "SELECT SUM(total) as total FROM transaksi WHERE status='selesai'");
$total_penjualan = ($q && ($row = mysqli_fetch_assoc($q))) ? $row['total'] ?: 0 : 0;
// Pesanan Baru (pending saja)
$q = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM transaksi WHERE status='pending'");
$total_pesanan = ($q && ($row = mysqli_fetch_assoc($q))) ? $row['total'] ?: 0 : 0;
// Total Produk tersedia (hanya produk yang status_ketersediaan='tersedia', sama seperti halaman produk)
$q = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pakaian ");
$total_produk = ($q && ($row = mysqli_fetch_assoc($q))) ? $row['total'] ?: 0 : 0;
// Total Pengguna (role user saja, sama seperti halaman pengguna)
$q = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM user");
$total_pengguna = ($q && ($row = mysqli_fetch_assoc($q))) ? $row['total'] ?: 0 : 0;
$chart_labels = [];
$chart_data = [];
$q = mysqli_query($koneksi, "SELECT DATE_FORMAT(tanggal, '%b %Y') as bulan, SUM(total) as total FROM transaksi WHERE status='selesai' GROUP BY YEAR(tanggal), MONTH(tanggal) ORDER BY YEAR(tanggal) DESC, MONTH(tanggal) DESC LIMIT 12");
$temp_chart = [];
if ($q) { while ($row = mysqli_fetch_assoc($q)) { $temp_chart[] = $row; } }
$temp_chart = array_reverse($temp_chart);
foreach ($temp_chart as $row) {
    $chart_labels[] = $row['bulan'];
    $chart_data[] = (int)$row['total'];
}
$recent_activities = [];
$q = mysqli_query($koneksi, "SELECT id_transaksi, tanggal, status FROM transaksi ORDER BY tanggal DESC LIMIT 3");
if ($q) { while ($row = mysqli_fetch_assoc($q)) { $recent_activities[] = ['icon'=>'fa-shopping-cart','text'=>"Transaksi #{$row['id_transaksi']} status <b>{$row['status']}</b>.", 'tanggal'=>$row['tanggal']]; } }
$q = mysqli_query($koneksi, "SELECT id_pakaian, nama_pakaian, tgl_upload FROM pakaian ORDER BY tgl_upload DESC LIMIT 2");
if ($q) { while ($row = mysqli_fetch_assoc($q)) { $recent_activities[] = ['icon'=>'fa-plus-circle','text'=>"Produk baru \"{$row['nama_pakaian']}\" ditambahkan.", 'tanggal'=>$row['tgl_upload']]; } }
$q = mysqli_query($koneksi, "SELECT id_user, username, tgl_daftar FROM user ORDER BY tgl_daftar DESC LIMIT 2");
if ($q) { while ($row = mysqli_fetch_assoc($q)) { $recent_activities[] = ['icon'=>'fa-user-plus','text'=>"Total  Pengguna \"{$row['username']}\" terdaftar.", 'tanggal'=>$row['tgl_daftar']]; } }
$q = mysqli_query($koneksi, "SELECT id_ulasan, isi_ulasan, tanggal FROM ulasan ORDER BY tanggal DESC LIMIT 2");
if ($q) { while ($row = mysqli_fetch_assoc($q)) { $recent_activities[] = ['icon'=>'fa-star','text'=>"Ulasan baru: \"{$row['isi_ulasan']}\".", 'tanggal'=>$row['tanggal']]; } }
usort($recent_activities, function($a, $b) { return strtotime($b['tanggal']) - strtotime($a['tanggal']); });
$recent_activities = array_slice($recent_activities, 0, 10);
?>
<section class="content-section active">
    <h2>Dashboard Overview</h2>
    <div class="dashboard-grid">
        <!-- <div class="card sales-card">
            <h3>Total Penjualan</h3>
            <p class="card-value">Rp <?= number_format($total_penjualan, 0, ',', '.') ?></p>
        </div>
        <div class="card orders-card">
            <h3>Pesanan Baru</h3>
            <p class="card-value"><?= $total_pesanan ?></p>
            <span class="card-trend">Perlu Diproses</span>
        </div> -->
        <div class="card products-card">
            <h3>Total Produk</h3>
            <p class="card-value"><?= $total_produk ?></p>
        </div>
        <div class="card users-card">
            <h3>Total Pengguna</h3>
            <p class="card-value"><?= $total_pengguna ?></p>
        </div>
    </div>
    <!-- <div class="dashboard-charts">
        <h3>Grafik Penjualan Bulanan</h3>
        <canvas id="monthlySalesChart"></canvas>
        <script>
        var ctx = document.getElementById('monthlySalesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode($chart_labels) ?>,
                datasets: [{
                    label: 'Pendapatan Bulanan (Rp)',
                    data: <?= json_encode($chart_data) ?>,
                    backgroundColor: 'rgba(52, 152, 219, 0.2)',
                    borderColor: 'rgba(52, 152, 219, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                plugins: { legend: { display: false } }
            }
        });
        </script>
    </div> -->
    <div class="recent-activities">
        <h3>Aktivitas Terbaru</h3>
        <ul>
            <?php foreach ($recent_activities as $act): ?>
            <li>
                <i class="fas <?= $act['icon'] ?>"></i>
                <?= $act['text'] ?>
                <span style="color:#aaa;font-size:13px;">(<?= date('d/m/Y', strtotime($act['tanggal'])) ?>)</span>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>