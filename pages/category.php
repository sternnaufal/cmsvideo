<?php
require_once '../components/db.php'; // Pastikan koneksi database
session_start();
// Ambil semua kategori
$sql_categories = "SELECT id, name FROM categories";
$result_categories = mysqli_query($conn, $sql_categories);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori - Sakurapai</title>
    <link rel="stylesheet" href="../components/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body style='background-color:black;'>
    <?php include '../components/navbar.php' ?>
    <div class="container mt-5 bg-dark">
    <?php if (!isset($_GET['category_id'])): ?>
        <!-- Menampilkan daftar kategori jika tidak ada kategori yang dipilih -->
        <h1 class="text-center text-white">Daftar Kategori</h1>
        <div class="row mt-4 bg-dark">
            <?php while ($category = mysqli_fetch_assoc($result_categories)): ?>
                <div class="col-md-3 mb-3">
                    <div class="card" style='background-color : black;'>
                        <div class="card-body text-white">
                            <h5 class="card-title"><?= htmlspecialchars($category['name']) ?></h5>
                            <a href="category.php?category_id=<?= $category['id'] ?>" style='background-color:black; color:pink;' class="btn btn-pink btn-sm">Lihat Judul</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: 
        $category_id = intval($_GET['category_id']);
        
        // Query untuk mendapatkan judul terkait kategori
        $sql_titles = "SELECT v.title 
                       FROM videos v 
                       JOIN video_categories vc ON v.id = vc.video_id 
                       WHERE vc.category_id = ?";
        $stmt = $conn->prepare($sql_titles);
        $stmt->bind_param('i', $category_id);
        $stmt->execute();
        $result_titles = $stmt->get_result();
        
        // Mengecek jika ada hasil dari query
        if ($result_titles->num_rows > 0):
    ?>
        <div class="mt-5">
            <h2>Judul Anime Terkait</h2>
            <ul class="list-group">
                <?php while ($title = $result_titles->fetch_assoc()): ?>
                    <li class="list-group-item"><?= htmlspecialchars($title['title']) ?></li>
                <?php endwhile; ?>
            </ul>
            <a href="category.php" class="btn btn-secondary mt-3">Kembali ke Daftar Kategori</a>
        </div>
    <?php else: ?>
        <div class="mt-5">
            <p class="alert alert-warning">Tidak ada video di kategori ini.</p>
            <a href="category.php" class="btn btn-secondary mt-3">Kembali ke Daftar Kategori</a>
        </div>
    <?php endif; ?>
    <?php endif; ?>
</div>


    <?php include '../components/footer.php'; ?>
</body>
</html>
