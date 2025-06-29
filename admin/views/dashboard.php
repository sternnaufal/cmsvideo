<?php
include '../check_admin.php'; // Middleware untuk keamanan
include '../../components/db.php'; // Koneksi ke database
include 'getdata.php'; // ambil data umum
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: black;
            /* Latar belakang hitam */
            color: white;
            /* Teks putih */
        }

        small {
            color: white;
        }

        .navbar {
            background-color: #2c3e50;
            /* Gelap, hampir hitam */
        }

        .navbar-brand,
        .nav-link {
            color: #ff6f61 !important;
            /* Warna pink pada navbar */
        }

        .navbar-nav .nav-link:hover {
            color: #ffd700 !important;
            /* Hover effect ke kuning */
        }

        .card {
            box-shadow: 0 2px 1px rgba(0, 0, 0, 0.1);
            background-color: white;
            /* Latar belakang putih untuk card */
        }

        .card-header {
            background-color: #ff6f61;
            /* Header berwarna pink */
            color: white;
            /* Teks putih pada header */
        }

        .card-body {
            background-color: black;
            /* Latar belakang putih pada body card */
            padding: 20px;
            color: white;
            /* Teks hitam pada body card */
        }

        .btn-primary {
            background-color: #ff6f61;
            border-color: #ff6f61;
            color: white;
            /* Teks putih pada tombol */
        }

        .btn-primary:hover {
            background-color: #e74c3c;
            border-color: #e74c3c;
        }

        .btn-info {
            background-color: #3498db;
            border-color: #3498db;
            color: white;
            /* Teks putih pada tombol info */
        }

        .btn-info:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }

        .chart-container {
            margin-top: 20px;
        }

        .chart-container canvas {
            max-width: 100% !important;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Dashboard Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="../../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../actions/upload.php">Unggah Video</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users_list.php">Pengguna</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Container -->
<div class="container mt-5">
    <h1 class="text-center mb-4">Admin Dashboard</h1>

    <div class="row">
        <!-- Statistik -->
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-primary">
                <div class="card-header">
                    <h5>Total Video</h5>
                </div>
                <div class="card-body">
                    <p class="fs-4"><?= $total_videos ?> video</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
        <div class="card text-white bg-secondary">
                <div class="card-header">
                    <h5>Total Pengguna</h5>
                </div>
                <div class="card-body">
                    <p class="fs-4"><?= $total_users ?> pengguna</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
        <div class="card text-white bg-success">
                <div class="card-header">
                    <h5>Video Terbaru</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <?php while ($video = mysqli_fetch_assoc($latest_videos)): ?>
                            <li><?= $video['title'] ?> <small><br>(<?= $video['created_at'] ?>)</small></li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Statistik Video -->
    <div class="row chart-container">
        <div class="col-md-6 mb-3">
        <div class="card text-white bg-danger">
                <div class="card-header">
                    <h5>Statistik Video</h5>
                </div>
                <div class="card-body">
                    <canvas id="videoChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
        <div class="card text-white bg-warning">
                <div class="card-header text-white">
                    <h5>Pengguna Terbaru</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-dark">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Admin</th>
                                <th>Premium</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($user = mysqli_fetch_assoc($latest_users)): ?>
                                <tr>
                                    <td><?= $user['username'] ?></td>
                                    <td><?= $user['is_admin'] == 1 ? 'Ya' : 'Tidak' ?></td>
                                    <td><?= $user['is_premium'] == 1 ? 'Ya' : 'Tidak' ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
        
    <div class="row">
        <!-- Card Jumlah Pengguna Premium -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card text-white bg-success">
                <div class="card-header">
                    Pengguna Premium
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $totalPremium; ?> Pengguna</h5>
                    <p class="card-text">Jumlah pengguna yang berlangganan premium.</p>
                </div>
            </div>
        </div>

        <!-- Card Jumlah Pengguna Biasa -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card text-white bg-info">
                <div class="card-header">
                    Pengguna Biasa
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $totalBiasa; ?> Pengguna</h5>
                    <p class="card-text">Jumlah pengguna yang tidak berlangganan premium.</p>
                </div>
            </div>
        </div>
            <!-- Card Jumlah Video Premium -->
        <div class="col-md-3 mb-4">
        <div class="card text-white bg-info">
                <div class="card-header">
                <h5 class="card-title">Jumlah Video Premium</h5>
                </div>
                <div class="card-body">
                    <p class="card-text"><?= $premium_count ?> Video</p>
                </div>
            </div>
        </div>

        <!-- Card Jumlah Video Biasa -->
        <div class="col-md-3 mb-4">
        <div class="card text-white bg-light">
                <div class="card-header">
                <h5 class="card-title">Jumlah Video Biasa</h5>
                </div>
                <div class="card-body">
                    <p class="card-text"><?= $biasa_count ?> Video</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Jumlah Video Per Kategori -->
    <div class="row">
        <div class="col-md-12 mb-3">
        <div class="card text-white bg-light">
                <div class="card-header text-white">
                    <h5>Jumlah Video Per Kategori</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php
                            foreach ($categories as $category) {
                                $sql = "SELECT c.name AS category_name, COUNT(v.id) AS video_count
                                        FROM categories c
                                        LEFT JOIN video_categories vc ON c.id = vc.category_id
                                        LEFT JOIN videos v ON vc.video_id = v.id
                                        GROUP BY c.id
                                        LIMIT {$category['limit']} OFFSET {$category['offset']}";
                                $result = $conn->query($sql);
                        ?>
                        <div class="col-md-3">
                            <table class="table table-dark table-striped">
                                <thead>
                                    <tr>
                                        <th style="color: #ff4081;">Kategori</th>
                                        <th style="color: #ff4081;">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result->num_rows > 0): ?>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td style="color: #ff4081;"><?= htmlspecialchars($row['category_name']) ?></td>
                                                <td><?= $row['video_count'] ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr><td colspan="2" class="text-center" style="color: #ff4081;">Tidak ada data.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Video Terlike dan Terdislike -->
    <div class="row">
        <div class="col-md-6 mb-3">
        <div class="card text-white bg-success">
                <div class="card-header">
                    <h5>5 Video Terlike</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <?php while ($video = mysqli_fetch_assoc($top_liked_videos)): ?>
                            <li><?= $video['title'] ?> <br> Likes: <?= $video['likes'] ?> | Dislikes: <?= $video['dislikes'] ?></li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
        <div class="card text-white bg-danger">
                <div class="card-header text-white">
                    <h5>5 Video Terdislike</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <?php while ($video = mysqli_fetch_assoc($top_disliked_videos)): ?>
                            <li><?= $video['title'] ?> <br> Likes: <?= $video['likes'] ?> | Dislikes: <?= $video['dislikes'] ?></li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Komentar Terbaru -->
    <div class="row">
        <div class="col-md-6 mb-3">
        <div class="card text-white bg-info">
                <div class="card-header text-white">
                    <h5>Komentar Terbaru</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <?php while ($comment = mysqli_fetch_assoc($latest_comments)): ?>
                            <li>
                                <strong><?= $comment['username'] ?> (<?= $comment['video_title'] ?>)</strong><br>
                                <small class="text-muted"><?= $comment['created_at'] ?></small>
                                <p><?= $comment['comment'] ?></p>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigasi cepat -->
    <div class="mt-4">
        <a href="../actions/upload.php" class="btn btn-primary">Unggah Video Baru</a>
        <a href="videos_list.php" class="btn btn-secondary">Lihat Semua Video</a>
        <a href="users_list.php" class="btn btn-info">Lihat Semua Pengguna</a>
    </div>
</div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Chart.js -->
    <script>
        var ctx = document.getElementById('videoChart').getContext('2d');
        var videoChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($video_titles); ?>, // Judul video dari database
                datasets: [{
                    label: 'Total Views per Video',
                    data: <?php echo json_encode($view_counts); ?>, // Total views per video dari database
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</body>

</html>