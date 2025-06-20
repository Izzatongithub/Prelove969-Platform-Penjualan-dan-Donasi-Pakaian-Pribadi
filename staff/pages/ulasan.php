<section id="reviews-content" class="content-section active">
    <h2>Manajemen Ulasan</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID Ulasan</th>
                    <th>Produk</th>
                    <th>Pengguna</th>
                    <th>Rating</th>
                    <th>Ulasan</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $q = "SELECT u.id_ulasan, p.nama_pakaian, us.username, u.rating, u.isi_ulasan, u.tanggal, u.status
                    FROM ulasan u
                    LEFT JOIN pakaian p ON u.id_pakaian = p.id_pakaian
                    LEFT JOIN user us ON u.id_user = us.id_user
                    ORDER BY u.tanggal DESC";
                $res = mysqli_query($koneksi, $q);
                if ($res && mysqli_num_rows($res) > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $stars = str_repeat('<i class="fas fa-star text-warning"></i> ', intval($row['rating']));
                        $status = $row['status'] == 'disetujui'
                            ? "<span class='status-active'>Disetujui</span>"
                            : "<span class='status-pending'>Menunggu</span>";
                ?>
                        <tr>
                            <td><?= $row['id_ulasan'] ?></td>
                            <td><?= $row['nama_pakaian'] ?></td>
                            <td><?= $row['username'] ?></td>
                            <td><?= $stars . $row['rating'] ?></td>
                            <td>"<?= $row['isi_ulasan'] ?>"</td>
                            <td><?= $row['tanggal'] ?></td>
                            <td><?= $status ?></td>
                            <td>
                                <form action='' method='POST' style='display:inline;' class='form-hapus-ulasan'>
                                    <input type='hidden' name='hapus_ulasan_id' value='<?= $row['id_ulasan'] ?>'>
                                    <button type='submit' class='btn btn-sm btn-delete'><i class='fas fa-trash-alt'></i> Hapus</button>
                                </form>
                                <?php if ($row['status'] != 'disetujui'): ?>
                                <form action='' method='POST' style='display:inline;' class='form-approve-ulasan'>
                                    <input type='hidden' name='approve_ulasan_id' value='<?= $row['id_ulasan'] ?>'>
                                    <button type='submit' class='btn btn-sm btn-approve'><i class='fas fa-check'></i> Setujui</button>
                                </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                ?>
                    <tr><td colspan='8' style='text-align:center;color:#888;'>Belum ada ulasan di database.</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>