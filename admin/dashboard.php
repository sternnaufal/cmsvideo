<?php
include 'check_admin.php'; // Middleware untuk keamanan
include '../components/db.php'; // Koneksi ke database

// Ambil statistik dari database
$total_videos = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM videos"))['count'];
$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM users"))['count'];
$latest_videos = mysqli_query($conn, "SELECT * FROM videos ORDER BY created_at DESC LIMIT 5");
$latest_users = mysqli_query($conn, "
    SELECT u.username, u.is_admin, us.is_premium 
    FROM users u
    LEFT JOIN user_subscriptions us ON u.id = us.user_id 
    LIMIT 5
");

// Ambil 5 video terlike
$top_liked_videos = mysqli_query($conn, "
    SELECT video_id, title, likes, dislikes
    FROM videos
    ORDER BY likes DESC
    LIMIT 5
");

// Ambil 5 video terdislike
$top_disliked_videos = mysqli_query($conn, "
    SELECT video_id, title, likes, dislikes
    FROM videos
    ORDER BY dislikes DESC
    LIMIT 5
");

// Ambil 5 video terakhir dan total view-nya
$query = "SELECT title, views FROM videos ORDER BY created_at DESC LIMIT 5";
$result = mysqli_query($conn, $query);

//Ambil data judul dan jumlah view dari video terakhir
$video_titles = [];
$view_counts = [];

while ($row = mysqli_fetch_assoc($result)) {
    $video_titles[] = $row['title'];  // Menyimpan judul video
    $view_counts[] = $row['views'];  // Menyimpan jumlah views
}

// Ambil 5 komentar terbaru
$query_comments = "SELECT c.comment, c.created_at, u.username, v.title AS video_title
                   FROM comments c
                   JOIN users u ON c.user_id = u.id
                   JOIN videos v ON c.video_id = v.id
                   ORDER BY c.created_at DESC LIMIT 5";
$latest_comments = mysqli_query($conn, $query_comments);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Dashboard Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="../index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="upload.php">Unggah Video</a>
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
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5>Total Video</h5>
                </div>
                <div class="card-body">
                    <p class="fs-4"><?= $total_videos ?> video</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5>Total Pengguna</h5>
                </div>
                <div class="card-body">
                    <p class="fs-4"><?= $total_users ?> pengguna</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5>Video Terbaru</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <?php while ($video = mysqli_fetch_assoc($latest_videos)): ?>
                            <li><?= $video['title'] ?> <small class="text-muted">(<?= $video['created_at'] ?>)</small></li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Statistik Video -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h5>Statistik Video</h5>
                </div>
                <div class="card-body">
                    <canvas id="videoChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengguna Terbaru -->
    <div class="row">
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5>Pengguna Terbaru</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
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
    <!-- Video Terlike -->
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5>5 Video Terlike</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <?php while ($video = mysqli_fetch_assoc($top_liked_videos)): ?>
                        <li>
                            <?= $video['title'] ?> <br>
                            Likes: <?= $video['likes'] ?> | Dislikes: <?= $video['dislikes'] ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Video Terdislike -->
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5>5 Video Terdislike</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <?php while ($video = mysqli_fetch_assoc($top_disliked_videos)): ?>
                        <li>
                            <?= $video['title'] ?> <br>
                            Likes: <?= $video['likes'] ?> | Dislikes: <?= $video['dislikes'] ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

    <!-- Komentar Terbaru -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5>Komentar Terbaru</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <?php while ($comment = mysqli_fetch_assoc($latest_comments)): ?>
                            <li>
                                <strong><?= $comment['username'] ?> (<?= $comment['video_title'] ?>)</strong>
                                <br>
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
        <h3>Manajemen Konten</h3>
        <a href="upload.php" class="btn btn-primary">Unggah Video Baru</a>
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
