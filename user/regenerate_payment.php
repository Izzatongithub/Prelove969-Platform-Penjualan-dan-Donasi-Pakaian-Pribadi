<?php
session_start();
include '../config.php';
include '../midtrans/Midtrans.php'; // file konfigurasi Midtrans kamu

if (!isset($_GET['id'])) {
    echo "ID transaksi tidak ditemukan.";
    exit();
}

$id_transaksi = $_GET['id'];
$id_user = $_SESSION['id_user'];

// Ambil data transaksi
$query = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id_transaksi = '$id_transaksi' AND id_user = '$id_user'");
$transaksi = mysqli_fetch_assoc($query);

if (!$query) {
    die("Query gagal: " . mysqli_error($koneksi));
}

// Ambil data produk dari transaksi_detail
// $detail_query = mysqli_query($koneksi, "SELECT dt.*, p.nama_produk, p.harga 
//     FROM detail_transaksi dt
//     JOIN pakaian p ON dt.id_produk = p.id_pakaian
//     WHERE dt.id_transaksi = '$id_transaksi'
// ");

$detail_query = mysqli_query($koneksi, "SELECT dt.*, p.nama_pakaian, p.harga 
    FROM detail_transaksi dt
    JOIN pakaian p ON dt.id_produk = p.id_pakaian
    WHERE dt.id_transaksi = '$id_transaksi'
");

// Ambil detail user dari database
$user_query = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
$user_data = mysqli_fetch_assoc($user_query);

if (!$detail_query) {
    die("Query detail transaksi gagal: " . mysqli_error($koneksi));
}

$items = [];
while ($item = mysqli_fetch_assoc($detail_query)) {
    $items[] = [
        'id' => $item['id_produk'],
        'price' => $item['harga'],
        'quantity' => 1,
        'name' => $item['nama_pakaian']
    ];
}

// $params = [
//     'transaction_details' => [
//         'order_id' => $transaksi['kode_invoice'],
//         'gross_amount' => $transaksi['total'] // total dari database
//     ],
//     'item_details' => $items,
//     'customer_details' => [
//         'first_name' => $_SESSION['nama'], // asumsinya sudah ada di session
//         'email' => $_SESSION['email'],
//     ]
// ];

$order_id = $transaksi['kode_invoice'] . '-' . time(); // hasil: INV123456-1729870000
$params = [
        'transaction_details' => [
            // 'order_id' => $order_id['kode_invoice'],
            'order_id' => $order_id,
            'gross_amount' =>  $transaksi['total_harga']
        ],
        'item_details' => $items,
        'customer_details' => [
            'first_name' => $user_data['nama'],
            'email' => $user_data['email'],
            'phone' => $user_data['no_telp'],
            'billing_address' => [
                'first_name'    => $user_data['nama'],
                'address'       => $user_data['alamat'],
                'phone'         => $user_data['no_telp'],
                'country_code'  => 'IDN'
            ],
            'shipping_address' => [ // <- perbaikan dari shipping_details
                'first_name'    =>$user_data['nama'],
                'address'       => $user_data['alamat'],
                'phone'         => $user_data['no_telp'],
                'country_code'  => 'IDN'
            ]
        ]
    ];

// Generate snap token
try {
    \Midtrans\Config::$serverKey = 'SB-Mid-server-VYeannctibrg8gOriM-hLpaK';
    \Midtrans\Config::$isProduction = false;
    \Midtrans\Config::$isSanitized = true;
    \Midtrans\Config::$is3ds = true;

    $snapToken = \Midtrans\Snap::getSnapToken($params);

    // Simpan token ke database
    mysqli_query($koneksi, "UPDATE transaksi SET snap_token = '$snapToken' WHERE id_transaksi = '$id_transaksi'");

    header("Location: midtrans_callback.php");
    exit();
} catch (Exception $e) {
    echo "Gagal generate Snap Token: " . $e->getMessage();
}
