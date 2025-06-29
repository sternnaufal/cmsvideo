<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../components/styles.css">
    <link rel="icon" href="assets/sakurapai.png" type="image/png">
    <style>
        .sakurapai-404 {
            text-align: center;
            margin : 5%;

        }
        .sakurapai-404 img {
            width: 200px;
            height: auto;
            margin: 20px 0;
        }
    </style>
</head>
<body>
<?php include '../components/navbar.php'?>
    <div class="sakurapai-404">
        <img src="../components/sakurapai.png" alt="Sakurapai Mascot">
        <h1>404</h1>
        <p>Ups! Halaman yang kamu cari tidak ditemukan.</p>
        <a href="../index.php">Kembali ke Beranda</a>
    </div>
    <?php include '../components/footer.php'?>
</body>
</html>
