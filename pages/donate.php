<?php
session_start();
include '../components/setusername.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../components/styles.css">
    <link rel="icon" href="../assets/sakurapai.png" type="image/png">
    <style>
        body {
            background-color: #1c1c1c; /* Warna hitam untuk latar belakang */
            color: white;
            font-family: 'Arial', sans-serif;
        }
        h1, h2, h3 {
            color: #ff66b2; /* Warna pink kawaii untuk heading */
        }
        h2, h3 {
            margin-top: 30px;
        }
        .btn {
            background-color: #ff66b2; /* Warna pink kawaii untuk tombol */
            color: white;
            border-radius: 5px;
        }
        .btn-secondary {
            background-color: #333;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #ff3385; /* Warna pink sedikit lebih gelap saat hover */
        }
        .btn-secondary:hover {
            background-color: #555;
        }
        ul {
            list-style-type: none;
            padding-left: 0;
        }
        ul li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php include '../components/navbar.php'; ?>
    <div class="container mt-4">
        <h1>Donasi</h1>
        <p>Kami sangat menghargai dukungan Anda! Donasi Anda akan membantu kami untuk terus menyediakan konten yang berkualitas dan meningkatkan layanan kami.</p>
        <h2>Metode Donasi</h2>
        <p>Anda dapat melakukan donasi dengan nominal Rp.5.000 atau lebih. Untuk mendonasikan, silakan klik tombol di bawah ini:</p>

        <a href="https://trakteer.id/sakurapai" target="_blank" class="btn btn-success">Trakteer</a>

        <h3 class="mt-4">Ketentuan Donasi</h3>
        <ul>
            <li>Setiap donasi yang Anda berikan akan digunakan untuk pengembangan konten dan platform.</li>
            <li>Donasi tidak memberikan akses khusus atau manfaat tambahan kepada penyumbang.</li>
            <li>Terima kasih atas dukungan Anda!</li>
        </ul>

        <a href="../index.php" class="btn btn-secondary mt-4">Kembali ke Daftar Video</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <?php include '../components/footer.php'; ?>
</body>
</html>
