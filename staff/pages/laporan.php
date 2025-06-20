<section id="reports-content" class="content-section active">
    <h2>Laporan</h2>
    <div class="report-section">
        <h3>Laporan Penjualan</h3>
        <form method="post" action="export_laporan_penjualan.php" style="margin-bottom:15px;display:inline;">
            <button type="submit" class="btn btn-success"><i class="fas fa-file-excel"></i> Ekspor Excel</button>
        </form>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Tanggal</th>
                        <th>Pembeli</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $q = "SELECT t.id_transaksi, t.tanggal, u.username AS pembeli, p.nama_pakaian, dt.jumlah, t.total, t.status
                        FROM transaksi t
                        LEFT JOIN user u ON t.id_user = u.id_user
                        LEFT JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
                        LEFT JOIN pakaian p ON dt.id_pakaian = p.id_pakaian
                        ORDER BY t.tanggal DESC";
                    $res = mysqli_query($koneksi, $q);
                    if ($res && mysqli_num_rows($res) > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            echo "<tr>
                                <td>{$row['id_transaksi']}</td>
                                <td>{$row['tanggal']}</td>
                                <td>{$row['pembeli']}</td>
                                <td>{$row['nama_pakaian']}</td>
                                <td>{$row['jumlah']}</td>
                                <td>Rp " . number_format($row['total'], 0, ',', '.') . "</td>
                                <td>{$row['status']}</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' style='text-align:center;color:#888;'>Belum ada data penjualan.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>