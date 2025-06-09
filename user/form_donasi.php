<?php

?>

<html>

<body>
    <form action="../proses/proses_donasi.php" method="POST" enctype="multipart/form-data">
    <label>Nama Lengkap:</label>
        <input type="text" name="nama" placeholder="Nama" required><br>

    <label>Kontak (WA/Email):</label>
        <input type="text" name="no_telp" placeholder="Kontak (WA/Email)" required><br>

    <!-- <label>Jenis Pakaian:</label>
        <select name="jenis_pakaian">
            <option value="tops">Tops</option>
            <option value="bottoms">Bottoms</option>
            <option value="outerwear">Outerwear</option>
            <option value="accessories">Accessories</option>
            <option value="bags">Bags & Purses</option>
        </select><br> -->

    <!-- <label>Ukuran:</label>
        <select name="ukuran">
            <option value="S">S</option>
            <option value="M">M</option>
            <option value="L">L</option>
            <option value="XL">XL</option>
        </select><br> -->

    <!-- <label>Kondisi:</label>
        <select name="kondisi">
            <option value="baru dengan tag">Baru dengan tag</option>
            <option value="baru tanpa tag">Baru tanpa tag</option>
            <option value="sangat baik">Sangat baik</option>
            <option value="baik">Baik</option>
            <option value="memuaskan">Memuaskan</option>
        </select><br> -->

  <!-- <input type="number" name="jumlah" placeholder="Jumlah pakaian" required><br> -->

    <label>Metode:</label>
        <select name="metode_donasi">
            <option value="antar langsung">Antar langsung</option>
            <option value="pick-up">Pick-up</option>
        </select><br>

    <textarea name="alamat" placeholder="Alamat (jika pick-up)"></textarea><br>
    <input type="file" name="foto"><br>

    <button type="submit">Kirim Donasi</button>
</form>

</body>



</html>