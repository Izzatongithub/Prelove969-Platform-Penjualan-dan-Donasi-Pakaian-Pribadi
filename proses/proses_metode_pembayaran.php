<?php
// This is just for very basic implementation reference, in production, you should validate the incoming requests and implement your backend more securely.
// Please refer to this docs for snap popup:
// https://docs.midtrans.com/en/snap/integration-guide?id=integration-steps-overview

namespace Midtrans;

require_once dirname(__FILE__) . '../../midtrans/Midtrans.php';
// Set Your server key
// can find in Merchant Portal -> Settings -> Access keys
Config::$serverKey = 'Your-Server-Key';
Config::$clientKey = 'Your-Client-key';

// non-relevant function only used for demo/example purpose
printExampleWarningMessage();

// Uncomment for production environment
// Config::$isProduction = true;

// Enable sanitization
Config::$isSanitized = true;

// Enable 3D-Secure
Config::$is3ds = true;

// Uncomment for append and override notification URL
// Config::$appendNotifUrl = "https://example.com";
// Config::$overrideNotifUrl = "https://example.com";

// Required

session_start();
include '../config.php';

$id_user = $_SESSION['id_user'];
$id_transaksi = $_POST['id_transaksi'];
$metode = $_POST['metode_pembayaran'];
$snapToken = '';
$status = 'menunggu';

$query = mysqli_query($koneksi, "SELECT t.*, dt.id_produk, p.nama_pakaian, p.harga FROM transaksi t
    JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
    JOIN pakaian p ON dt.id_produk = p.id_pakaian
    WHERE t.id_transaksi = '$id_transaksi'
");

// Ambil detail user dari database
$user_query = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
$user_data = mysqli_fetch_assoc($user_query);

$items = [];
$total = 0;
$kode_invoice = '';

while ($row = mysqli_fetch_assoc($query)) {
    $kode_invoice = $row['kode_invoice'];
    $items[] = [
        'id' => $row['id_produk'],
        'price' => $row['harga'],
        'quantity' => 1,
        'name' => $row['nama_pakaian']
    ];
    $total += $row['harga'];
}

if ($metode === 'midtrans') {
    $params = [
        'transaction_details' => [
            'order_id' => $kode_invoice,
            'gross_amount' => (int)$total
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
                'first_name'    => $user_data['nama'],
                'address'       => $user_data['alamat'],
                'phone'         => $user_data['no_telp'],
                'country_code'  => 'IDN'
            ]
        ]
    ];

// echo "<pre>";
// print_r($params);
// echo "</pre>";
// exit;

    $snapToken = \Midtrans\Snap::getSnapToken($params);
    mysqli_query($koneksi, "UPDATE transaksi SET metode_pembayaran='midtrans', id_midtrans='$snapToken' WHERE id_transaksi='$id_transaksi'");

    $_SESSION['snap_token'] = $snapToken;
    $_SESSION['id_transaksi'] = $id_transaksi;
    $_SESSION['kode_invoice'] = $kode_invoice;
    header("Location: ../user/midtrans_callback.php");
    exit();
}else if ($metode === 'cod') {
    // Update transaksi
    $id_midtrans = 'COD-' . uniqid();
    $update_transaksi = mysqli_query($koneksi, "UPDATE transaksi SET metode_pembayaran='cod', id_midtrans='$id_midtrans' WHERE id_transaksi='$id_transaksi'");
    if (!$update_transaksi) {
        die("Gagal update transaksi: " . mysqli_error($koneksi));
    }

    // Update status produk
    foreach ($items as $item) {
        $id_produk = $item['id'];
        $update_produk = mysqli_query($koneksi, "UPDATE pakaian SET status_ketersediaan='Terjual' WHERE id_pakaian='$id_produk'");
        if (!$update_produk) {
            die("Gagal update status pakaian: " . mysqli_error($koneksi));
        }
    }

    // Ambil dan hapus isi keranjang
    $result = mysqli_query($koneksi, "SELECT id_keranjang FROM transaksi WHERE id_transaksi = '$id_transaksi'");
    $data = mysqli_fetch_assoc($result);
    $id_keranjang = $data['id_keranjang'] ?? null;

    if ($id_keranjang) {
        $hapus_keranjang = mysqli_query($koneksi, "DELETE FROM keranjang_detail WHERE id_keranjang = '$id_keranjang'");
        if (!$hapus_keranjang) {
            die("Gagal hapus keranjang: " . mysqli_error($koneksi));
        }
    }

    header("Location: ../user/pesananku.php?kode=$kode_invoice");
    exit();
}

function printExampleWarningMessage() {
    if (strpos(Config::$serverKey, 'your-server-key') != false ) {
        echo "<code>";
        echo "<h4>Please set your server key from sandbox</h4>";
        echo "In file: " . __FILE__;
        echo "<br>";
        echo "<br>";
        echo htmlspecialchars('Config::$serverKey = \'your-server-key\';');
        die();
    } 
}

?>

<!DOCTYPE html>
<html>
    <body>
        <button id="pay-button">Pay!</button>
        <pre><div id="result-json">JSON result will appear here after payment:<br></div></pre> 

        <!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo Config::$clientKey;?>"></script>
        <script type="text/javascript">
            document.getElementById('pay-button').onclick = function(){
                // SnapToken acquired from previous step
                snap.pay('<?php echo $snap_token?>', {
                    // Optional
                    onSuccess: function(result){
                        /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    },
                    // Optional
                    onPending: function(result){
                        /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    },
                    // Optional
                    onError: function(result){
                        /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    }
                });
            };
        </script>
    </body>
</html>