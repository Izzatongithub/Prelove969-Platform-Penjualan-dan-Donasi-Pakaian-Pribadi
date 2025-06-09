<?php
session_start();
if (!isset($_SESSION['snap_token'])) {
    die("Snap token tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bayar Sekarang</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="SB-Mid-client-YNYtads1Nffj3p6l"></script>
</head>
<body>
    <h2>Silakan lakukan pembayaran</h2>
    <button id="pay-button">Bayar Sekarang</button>

    <script>
    document.getElementById('pay-button').addEventListener('click', function () {
        snap.pay("<?= $_SESSION['snap_token'] ?>", {
            onSuccess: function(result) {
                window.location.href = "payment_success.php?status=sukses";
            },
            onPending: function(result) {
                alert("Pembayaran tertunda.");
            },
            onError: function(result) {
                alert("Terjadi kesalahan pembayaran.");
            }
        });
    });
    </script>
</body>
</html>
