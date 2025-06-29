<?php
session_start();
// Mengambil nama pengguna jika sudah login
include '../components/setusername.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Langganan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="assets/sakurapai.png" type="image/png">
    <style>
        body {
            background-color: black;
            color: white;
        }
        h1, h2 {
            color: #f8f9fa; /* Warna untuk heading */
        }
    </style>
</head>
<body>
    <?php include '../components/navbar.php'; ?>
<div class="container mt-4">
    <h1>Pilih Jenis Langganan</h1>
    <form action="#" method="POST" id="subscription-form">
        <div class="mb-3">
            <label for="subscription_type" class="form-label">Jenis Langganan</label>
            <select name="subscription_type" class="form-select" required>
                <option value="Bulanan - Rp 5.000">Bulanan - Rp 5.000</option>
                <option value="6 Bulan - Rp 15.000">6 Bulan - Rp 15.000</option>
                <option value="Tahunan - Rp 40.000">Tahunan - Rp 40.000</option>
            </select>
        </div>
        <button type="button" class="btn btn-primary" id="send-payment-email">Kirim Bukti Pembayaran</button>
    </form>

    <h2 class="mt-4">Ketentuan Langganan</h2>
    <ul>
        <li>Biaya langganan bulanan adalah Rp 5.000.</li>
        <li>Biaya langganan 6 bulan adalah Rp 15.000 (hemat Rp 15.000).</li>
        <li>Biaya langganan tahunan adalah Rp 40.000 (hemat Rp 20.000).</li>
        <li>Setelah pembayaran, Anda akan mendapatkan akses ke konten premium tanpa iklan.</li>
        <li>Proses aktivasi langganan akan dilakukan dalam waktu 1 hari kerja setelah bukti pembayaran diterima.</li>
    </ul>

    <h2 class="mt-4">Langkah-langkah Pembayaran</h2>
    <ol>
        <li>Pilih jenis langganan yang diinginkan.</li>
        <li>Kirimkan bukti pembayaran ke email <strong>projecteukaria@gmail.com</strong> dengan menyertakan screenshot pembayaran dan username Anda.</li>
        <li>Tunggu konfirmasi dari kami dalam waktu 1 hari kerja.</li>
        <li>Setelah konfirmasi, Anda akan mendapatkan akses ke konten premium.</li>
    </ol>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script>
    document.getElementById('send-payment-email').addEventListener('click', function() {
        var subscriptionType = document.querySelector('select[name="subscription_type"]').value;
        var username = '<?php echo $_SESSION['username']; ?>'; // Ambil username dari session
        var emailBody = "Bukti pembayaran untuk pengguna: " + username + "\n" + "Jenis langganan: " + subscriptionType + "\n" + "Harap lampirkan screenshot pembayaran.";
        var mailtoLink = "mailto:projecteukaria@gmail.com?subject=Bukti Pembayaran Langganan - " + encodeURIComponent(username) + "&body=" + encodeURIComponent(emailBody);
        
        window.location.href = mailtoLink;
    });
</script>
<?php include '../components/footer.php'; ?>
</body>
</html>
