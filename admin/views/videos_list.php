<?php
include '../check_admin.php';
include '../../components/db.php';

// Ambil data video dari database
$videos = mysqli_query($conn, "SELECT * FROM videos ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Video</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Daftar Video</h1>
        
        <!-- Tombol navigasi -->
        <div class="mb-4 text-end">
            <a href="../actions/upload.php" class="btn btn-primary">Unggah Video Baru</a>
        </div>

        <!-- Tabel daftar video -->
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($videos) > 0): ?>
                    <?php $no = 1; while ($video = mysqli_fetch_assoc($videos)): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($video['title']) ?></td>
                            <td>
                                <a href="../actions/edit_video.php?id=<?= $video['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="../actions/delete_video.php?id=<?= $video['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus video ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center">Tidak ada video ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
