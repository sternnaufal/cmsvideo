<?php
session_start();
include '../../components/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../pages/login.php");
    exit;
}

// Cek apakah pengguna adalah admin
$is_admin = ($_SESSION['username'] == 'admin'); // Sesuaikan dengan cara Anda mengatur admin

if (!$is_admin) {
    echo "<div class='alert alert-warning mt-4'>Hanya admin yang dapat mengedit video.</div>";
    exit;
}

if (isset($_GET['id'])) {
    // Ambil ID video dari URL
    $video_id = $_GET['id'];

    // Ambil data video berdasarkan ID dari database
    $sql = "SELECT * FROM videos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $video_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "<div class='alert alert-danger'>Video tidak ditemukan.</div>";
        exit;
    }

    $video = $result->fetch_assoc();
} else {
    echo "<div class='alert alert-danger'>ID video tidak valid.</div>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $video_url = trim($_POST['video_url']);
    $is_premium = trim($_POST['is_premium']);
    $member_link = trim($_POST['member_link']);
    $premium_link = trim($_POST['premium_link']);

    // Cek jika ada thumbnail yang diupload
    $thumbnail_path = $video['thumbnail']; // Jika tidak ada file baru, gunakan thumbnail lama
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == UPLOAD_ERR_OK) {
        $thumbnail_name = $_FILES['thumbnail']['name'];
        $target_dir = "uploads/thumbnails/";
        $thumbnail_path = $target_dir . basename($thumbnail_name);

        // Pindahkan file
        if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $thumbnail_path)) {
            echo "Thumbnail berhasil diunggah.<br>";
        } else {
            echo "Gagal mengunggah thumbnail.<br>";
            exit;
        }
    }

    // Update data video ke database
    $sql = "UPDATE videos SET title = ?, description = ?, video_url = ?, thumbnail = ?, is_premium = ?, member_link = ?, premium_link = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $title, $description, $video_url, $thumbnail_path, $is_premium, $member_link, $premium_link, $video_id);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Video berhasil diperbarui! <a href='../../index.php'>Lihat Video</a></div>";
    } else {
        echo "<div class='alert alert-danger'>Gagal memperbarui data video.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Video</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Edit Video</h1>

    <?php if ($is_admin): ?>
        <form action="edit_video.php?id=<?= $video['id'] ?>" method="POST" enctype="multipart/form-data" class="mt-4">
            <div class="mb-3">
                <label for="id" class="form-label">ID Video</label>
                <input type="text" name="id" id="id" value="<?= $video['id'] ?>" class="form-control" readonly>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Judul Video</label>
                <input type="text" name="title" id="title" value="<?= $video['title'] ?>" class="form-control" placeholder="Judul Video" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi Video</label>
                <textarea name="description" id="description" class="form-control" placeholder="Deskripsi Video" required><?= $video['description'] ?></textarea>
            </div>
            <div class="mb-3">
                <label for="video_url" class="form-label">URL Video</label>
                <input type="text" name="video_url" id="video_url" value="<?= $video['video_url'] ?>" class="form-control" placeholder="URL Video" required>
            </div>
            <div class="mb-3">
                <label for="is_premium" class="form-label">Video Premium</label><br>
                <input type="radio" name="is_premium" value="1" <?= ($video['is_premium'] == 1) ? 'checked' : '' ?>>Ya
                <input type="radio" name="is_premium" value="0" <?= ($video['is_premium'] == 0) ? 'checked' : '' ?>>Tidak
            </div>
            <div class="mb-3">
                <label for="thumbnail" class="form-label">Thumbnail</label>
                <input type="file" name="thumbnail" id="thumbnail" class="form-control" accept="image/*">
                <img src="../../<?= $video['thumbnail'] ?>" alt="Thumbnail" class="mt-3" style="max-width: 200px;">
            </div>
            <div class="mb-3">
                <label for="premium_link" class="form-label">Premium Link</label>
                <input type="text" name="premium_link" id="premium_link" value="<?= $video['premium_link'] ?>" class="form-control" placeholder="Link Video Premium" required>
            </div>
            <div class="mb-3">
                <label for="member_link" class="form-label">Member Link</label>
                <input type="text" name="member_link" id="member_link" value="<?= $video['member_link'] ?>" class="form-control" placeholder="Link Video Member" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Video</button>
        </form>
    <?php endif; ?>

    <a href="../../index.php" class="btn btn-secondary mt-4">Kembali ke Daftar Video</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
