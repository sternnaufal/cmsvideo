<?php
session_start();
include '../components/db.php';
include '../components/viewfunc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($video['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://vjs.zencdn.net/7.11.4/video-js.css" rel="stylesheet" />
    <link rel="stylesheet" href="../components/styles.css">
    <link rel="icon" href="assets/sakurapai.png" type="image/png">
    <style>
        body {
            background-color: black;
            color: white;
        }
        /* Kustomisasi CSS untuk memusatkan kontrol video */
        .video-js .vjs-control-bar {
            display: flex;
            justify-content: center; /* Memusatkan kontrol */
            align-items: center; /* Vertikal tengah */
        }
        <style>
    /* Set video to be responsive */
    #my-video {
        width: 80%;
        max-width: 640px; /* Maksimal lebar untuk tampilan laptop/PC */
        height: 320px; /* Menyesuaikan tinggi dengan proporsi */
    }
    /* Optional: If you want specific styling for smaller screens */
    @media (max-width: 768px) { /* Untuk tablet dan perangkat lebih kecil */
        #my-video {
            max-width: 768px; /* Memanfaatkan lebar penuh pada layar kecil */
            height: 384px;
        }
    }
    @media (max-width: 480px) { /* Untuk perangkat seluler */
        #my-video {
            max-width: 100%;
            height: 240px;
        }
    }
</style>
    </style>
<script type='text/javascript' src='//pl24865725.profitablecpmrate.com/36/d5/3e/36d53ec55af0327cd432e002e765dd21.js'></script>
</head>
<body>
<!-- Navbar -->
    <?php include '../components/navbar.php'?>
    <div>
	
    <?php if (!$is_premium_user): ?>
    <div class="alert alert-info" id="premium-alert">
        Kamu saat ini adalah pengguna biasa. Tingkatkan ke premium untuk mendapatkan lebih banyak keuntungan, seperti akses tanpa iklan dan konten eksklusif!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="closeAlert()">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <script>
        function closeAlert() {
            document.getElementById('premium-alert').style.display = 'none';
        }
    </script>
<?php endif; ?>

<div class="container mt-4">
    <div class="card shadow-lg border-0" style="background-color: black; color: white;">
        <div class="card-body d-flex flex-column flex-lg-row">
            <!-- Kolom Kiri: Video -->
            <div class="video-area flex-grow-1 mb-4 mb-lg-0 mr-lg-4" style="max-width: 75%;"> <!-- Perbesar area video -->
                <h1 class="card-title text-center" style="color: #ff4081;"><?php echo htmlspecialchars($video['title']); ?></h1>
                <p class="card-text" style="color: white;"><?php echo htmlspecialchars($video['description']); ?></p>

                <?php if ($is_premium_video && !$is_premium_user): ?>
                    <div class="alert alert-warning d-flex justify-content-between align-items-center" style="background-color: #000; color: #ff4081;">
                        <h3>Konten ini hanya tersedia untuk anggota premium.</h3>
                        <a href="premium.php" class="btn btn-warning btn-lg" style="background-color: #ff4081; color: white;">Berlangganan</a>
                    </div>
                <?php else: ?>
                    <div class="video-container mb-4">
                        <video id="my-video" class="video-js w-100 shadow" controls preload="auto" data-setup='{"controlBar": { "playToggle": true, "volumePanel": true, "fullscreenToggle": true, "downloadButton": <?php echo $is_premium_user ? 'true' : 'false'; ?> }}'>
                            <source src="../uploads/<?php echo htmlspecialchars($video['video_url']); ?>" type="video/mp4" />
                            <p class="vjs-no-js" style="color: #fff;">
                                To view this video please enable JavaScript, and consider upgrading to a
                                <a href="https://videojs.com/html5-video-support/" target="_blank" style="color: #ff4081;">web browser that supports HTML5 video</a>
                            </p>
                        </video>
                    </div>
                <?php endif; ?>

                <!-- Feedback (Like/Dislike) -->
                <div class="mt-3 text-center">
                    <form action="view.php?id=<?php echo $video_id; ?>" method="POST">
                        <button name="feedback" value="like" class="btn btn-success btn-lg mr-2" style="background-color: #ff4081;">Like</button>
                        <button name="feedback" value="dislike" class="btn btn-danger btn-lg" style="background-color: #000; color: #fff;">Dislike</button>
                    </form>
                    <p class="mt-2" style="color: #ff4081;">Likes: <?php echo htmlspecialchars($video['likes']); ?> | Dislikes: <?php echo htmlspecialchars($video['dislikes']); ?></p>
                </div>

                <!-- Tombol Unduhan -->
                <div class="text-center mt-3">
                    <?php if ($is_premium_user): ?>
                        <a href="<?php echo htmlspecialchars($video['premium_link']); ?>" class="btn btn-success btn-lg" style="background-color: #ff4081;">Unduh Video (VVIP)</a>
                    <?php else: ?>
                        <a href="<?php echo htmlspecialchars($video['member_link']); ?>" class="btn btn-info btn-lg" style="background-color: #000; color: #fff;">Unduh Video</a>
                    <?php endif; ?>
                </div>

                <!-- Komentar -->
                <div class="mt-4">
                    <h3 style="color: #ff4081;">Tambah Komentar</h3>
                    <form action="view.php?id=<?php echo $video_id; ?>" method="POST" class="mb-4">
                        <div class="mb-3">
                            <textarea name="comment" class="form-control" placeholder="Tulis komentar Anda..." required style="background-color: #f5f5f5; color: #333;"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100" style="background-color: #ff4081; color: white;">Kirim</button>
                    </form>

                    <h4 style="color: #ff4081;">Komentar:</h4>
                    <?php
                    // Tampilkan komentar
                    $sql_comments = "SELECT comments.*, users.username FROM comments JOIN users ON comments.user_id = users.id WHERE video_id = ?";
                    $stmt_comments = $conn->prepare($sql_comments);
                    $stmt_comments->bind_param("i", $video_id);
                    $stmt_comments->execute();
                    $result_comments = $stmt_comments->get_result();
                    while ($comment = $result_comments->fetch_assoc()) {
                        echo "<p><strong style='color: #ff4081;'>" . htmlspecialchars($comment['username']) . ":</strong> " . htmlspecialchars($comment['comment']) . "</p>";
                    }
                    ?>
                </div>
            </div>

            <!-- Kolom Kanan: Rekomendasi Video -->
            <div class="recommendations-area flex-shrink-0 w-100 w-lg-25" style="max-width: 25%;"> <!-- Perkecil kolom rekomendasi -->
                <h3 style="color: #ff4081;">Rekomendasi Video</h3>
                <ul class="list-unstyled">
                    <?php
                    // Ambil rekomendasi video (misalnya video dengan kategori yang sama)
                    $sql_recommendations = "SELECT * FROM videos WHERE category_id = ? LIMIT 5";
                    $stmt_recommendations = $conn->prepare($sql_recommendations);
                    $stmt_recommendations->bind_param("i", $video['category_id']);
                    $stmt_recommendations->execute();
                    $result_recommendations = $stmt_recommendations->get_result();

                    while ($recommendation = $result_recommendations->fetch_assoc()) {
                        echo "<li><a href='view.php?id=" . $recommendation['id'] . "' style='color: #ff4081;'>" . htmlspecialchars($recommendation['title']) . "</a></li>";
                    }
                    ?>
                </ul>
            </div>
        </div>

        <!-- Update views -->
        <?php
        $sql_update_views = "UPDATE videos SET views = views + 1 WHERE id = ?";
        $stmt_update_views = $conn->prepare($sql_update_views);
        $stmt_update_views->bind_param("s", $video_id);
        $stmt_update_views->execute();
        ?>

        <!-- Kembali ke Daftar Video -->
        <div class="mt-4 text-center">
            <a href="index.php" class="btn btn-secondary btn-lg" style="background-color: #000; color: #fff;">Kembali ke Daftar Video</a>
        </div>
    </div>
</div>
<?php include '../components/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script src="https://vjs.zencdn.net/7.11.4/video.min.js"></script>
<script>
var videoElement = document.getElementById('my-video');
videoElement.addEventListener('contextmenu', function(e) {
    e.preventDefault();
});
</script><script type="text/javascript"> var infolinks_pid = 3428094; var infolinks_wsid = 0; </script> <script type="text/javascript" src="//resources.infolinks.com/js/infolinks_main.js"></script>
</body>
</html>

