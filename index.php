<?php
session_start();
include 'components/db.php';
include 'components/function.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Video</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="components/styles.css">
    <link rel="icon" href="assets/sakurapai.png" type="image/png">
    
    <style>
        body {
                background-color: black; /* Latar belakang hitam */
            color: white; /* Warna teks putih */
        }

        .thumbnail {
                width: 100%; /* Memastikan lebar thumbnail penuh */
            height: 200px; /* Atur tinggi sesuai kebutuhan */
            object-fit: cover; /* Memastikan gambar terpotong dan tetap proporsional */
        }
        .btn {
                background-color: rgb(255, 125, 146); /* Tombol pink */
            color: white; /* Teks tombol putih */
        }
        .btn:hover {
            background-color: black; /* Warna latar belakang tombol saat hover */
            color: black; /* Teks tombol pink saat hover */
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="index.php">Sakurapai</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                <?php if ($user_name): ?>
                    <li class="nav-item nav-link text-white" style="background-color:grey;">
                        <i class="fas fa-user-circle" style="font-size: 18px; margin-right: 10px; color: pink"></i>
                            Hi, <?php echo htmlspecialchars($user_name); ?>!
                    </li>
                    <?php if ($is_admin): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="admin/views/dashboard.php">Dashboard</a>
                    </li>
                <?php endif; ?>
                    <li class="nav-item">
                            <a class="nav-link text-white" href="pages/donate.php">Donasi</a>
                    </li>
                    <?php if (!$is_premium): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="premium.php">Upgrade Akun!</a>
                    </li>
                <?php endif; ?>
                    <li class="nav-item">
                            <a class="nav-link text-white" href="pages/logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                            <a class="nav-link text-white" href="pages/register.php">Daftar</a>
                    </li>
                    <li class="nav-item">
                            <a class="nav-link text-white" href="pages/login.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Welcome Modal -->
<div class="modal fade" id="welcomeModal" tabindex="-1" aria-labelledby="welcomeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #111; border: 2px solid pink; border-radius: 15px; color: white;">
            <div class="modal-header" style="background-color: pink; border-radius: 15px 15px 0 0;">
                <h5 class="modal-title fw-bold" id="welcomeModalLabel" style="color: black;">🎉 Selamat Datang di Sakurapai! 🎉</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h3 class="fw-bold" style="color: pink; text-shadow: 0px 0px 5px pink;">Halo! 👋</h3>
                <p class="mt-3" style="font-size: 1.1rem; line-height: 1.6;">
                    Selamat datang di <strong style="color: pink;">Sakurapai</strong>, tempat terbaik untuk menonton video anime favorit kamu! 🎥
                </p>
                <p style="font-size: 1rem;">
                    Jangan lupa <strong>Login</strong> atau <strong>Daftar</strong> agar kamu bisa menikmati fitur premium dan konten spesial lainnya.
                </p>
                <img src="" alt="Anime Icon" style="width: 100px; margin-top: 10px;">
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn" data-bs-dismiss="modal" style="
                    background-color: pink;
                    color: black;
                    font-weight: bold;
                    border-radius: 20px;
                    padding: 10px 20px;
                    box-shadow: 0px 0px 10px pink;
                    transition: all 0.3s ease-in-out;">
                    Lanjutkan
                </button>
            </div>
        </div>
    </div>
</div>


    <div class="container mt-4 d-flex">
    <!-- Pencarian -->
    <div class="main-content" style="flex: 1;">
    <div class="row mt-4">
        <div class="col-md-8 mx-auto">
            <form action="index.php" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari video..." required>
            <button type="submit" class="btn-primary btn-pink">Cari</button>
        </form>
    </div>
</div>
<?php if ($search): // Jika ada pencarian ?>
    <!-- Tombol Kembali -->
    <div class="row mt-4">
            <div class="col-md-8 mx-auto text-center">
                <a href="index.php" class=" btn-secondary">Kembali</a>
        </div>
    </div>
    <!-- Daftar Video dengan Grid 3x4 -->
    <div class="row mt-5">
        <h3 class="text-center">Hasil Pencarian untuk "<?php echo htmlspecialchars($search); ?>"</h3>
        <?php
        if ($result->num_rows > 0):
            while ($video = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card bg-dark text-white">
                        <img src="<?php echo htmlspecialchars($video['thumbnail']); ?>" class="card-img-top thumbnail" alt="Thumbnail Video">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="pages/view.php?id=<?php echo $video['id']; ?>" class="text-decoration-none text-white">
                                    <?php echo htmlspecialchars($video['title']); ?>
                                </a>
                            </h5><?php echo htmlspecialchars($video['views']); ?>
                            <p class="card-text"><?php echo htmlspecialchars($video['description']); ?></p>
                            <a href="pages/view.php?id=<?php echo $video['id']; ?>" class="btn">Lihat Video</a>
                        </div>
                    </div>
                </div>
            <?php endwhile;
        else: ?>
            <p class="text-center">Tidak ada video ditemukan.</p>
        <?php endif; ?>
    </div>
<?php else: // Jika tidak ada pencarian ?>
    <!-- Katalog Paling Sering Ditonton -->
    <div class="row mt-5">
        <h3 class="text-center">Video Paling Sering Ditonton</h3>
        <?php if ($result_top_views->num_rows > 0): ?>
            <?php while ($video = $result_top_views->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card bg-dark text-white">
                        <img src="<?php echo htmlspecialchars($video['thumbnail']); ?>" class="card-img-top thumbnail" alt="Thumbnail Video">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="pages/view.php?id=<?php echo $video['id']; ?>" class="text-decoration-none text-white">
                                    <?php echo htmlspecialchars($video['title']); ?>
                                </a>
                            </h5>
                            <p class="card-text"><?php echo htmlspecialchars($video['description']); ?></p>
                            <a href="pages/view.php?id=<?php echo $video['id']; ?>" class="btn">Lihat Video</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">Tidak ada video ditemukan.</p>
        <?php endif; ?>
    </div>
    <!-- Katalog Paling Banyak Disukai -->
    <div class="row mt-5">
        <h3 class="text-center">Video Paling Banyak Disukai</h3>
        <?php if ($result_top_likes->num_rows > 0): ?>
            <?php while ($video = $result_top_likes->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card bg-dark text-white">
                        <img src="<?php echo htmlspecialchars($video['thumbnail']); ?>" class="card-img-top thumbnail" alt="Thumbnail Video">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="pages/view.php?id=<?php echo $video['id']; ?>" class="text-decoration-none text-white">
                                    <?php echo htmlspecialchars($video['title']); ?>
                                </a>
                            </h5>
                            <p class="card-text"><?php echo htmlspecialchars($video['description']); ?></p>
                            <a href="pages/view.php?id=<?php echo $video['id']; ?>" class="btn">Lihat Video</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">Tidak ada video ditemukan.</p>
        <?php endif; ?>
    </div>
    <!-- Daftar Video dengan Grid 3x4 -->
    <div class="row mt-5">
        <h3 class="text-center">Semua Video</h3>
        <?php
        if ($result->num_rows > 0):
            while ($video = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card bg-dark text-white">
                        <img src="<?php echo htmlspecialchars($video['thumbnail']); ?>" class="card-img-top thumbnail" alt="Thumbnail Video">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="pages/view.php?id=<?php echo $video['id']; ?>" class="text-decoration-none text-white">
                                    <?php echo htmlspecialchars($video['title']); ?>
                                </a>
                            </h5>
                            <p class="card-text"><?php echo htmlspecialchars($video['description']); ?></p>
                            <a href="pages/view.php?id=<?php echo $video['id']; ?>" class="btn">Lihat Video</a>
                        </div>
                    </div>
                </div>
            <?php endwhile;
        else: ?>
            <p class="text-center">Tidak ada video ditemukan.</p>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php include 'components/pagination.php'?>
        </div>
    <div class="mascot-container" style="width: 250px; height: 100%; padding-left: 20px;">
        <img src="components/sakurapai.png" alt="Maskot" style="width: 100%; height: auto;">
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script>
    let modalShown = sessionStorage.getItem("modalShown");
if (!modalShown) {
    // Jika modal belum ditampilkan sebelumnya
    // Tampilkan modal
    var welcomeModal = new bootstrap.Modal(document.getElementById('welcomeModal'));
    welcomeModal.show();

    // Simpan status supaya modal tidak muncul lagi
    sessionStorage.setItem("modalShown", "true");
}
sessionStorage.setItem("modalShown", "true");
</script>
<?php include 'components/footer.php'?>
</body>
</html>
