<?php
session_start();
include '../components/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit;
}

// Cek apakah pengguna adalah admin
$is_admin = ($_SESSION['username'] == 'admin'); // Sesuaikan dengan cara Anda mengatur admin

function generateRandomId($length = 12) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = generateRandomId();
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $video_url = trim($_POST['video_url']);
    $is_premium = trim($_POST['is_premium']);
    $member_link = trim($_POST['member_link']);
    $premium_link = trim($_POST['premium_link']);

    // Generate random alphanumeric ID
    $video_id = generateRandomId();

    // Upload thumbnail
    $thumbnail_path = "";
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == UPLOAD_ERR_OK) {
        $thumbnail_name = $_FILES['thumbnail']['name'];
        $target_dir = "uploads/thumbnails/";
        $thumbnail_path = $target_dir . basename($thumbnail_name);

        // Pastikan direktori tujuan ada
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Pindahkan file
        if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $thumbnail_path)) {
            echo "Thumbnail berhasil diunggah.<br>";
        } else {
            echo "Gagal mengunggah thumbnail.<br>";
            exit;
        }
    } else {
        echo "Error: " . $_FILES['thumbnail']['error'];
        exit;
    }

    // Simpan data video ke database
    $sql = "INSERT INTO videos (id, title, description, video_url, thumbnail, is_premium, member_link, premium_link)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $id, $title, $description, $video_url, $thumbnail_path, $is_premium, $member_link, $premium_link);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Video berhasil diunggah! <a href='../index.php'>Lihat Video</a></div>";
    } else {
        echo "<div class='alert alert-danger'>Gagal menyimpan data video.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unggah Video</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Unggah Video</h1>
    
    <?php if ($is_admin): ?>
        <form action="upload.php" method="POST" enctype="multipart/form-data" class="mt-4">
            <div class="mb-3">
                <label for="id" class="form-label">ID Video</label>
                <input type="text" name="id" id="id" value="<?= generateRandomId()?>" class="form-control" placeholder="ID Video" required>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Judul Video</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="Judul Video" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi Video</label>
                <textarea name="description" id="description" class="form-control" placeholder="Deskripsi Video" required></textarea>
            </div>
            <div class="mb-3">
                <label for="video_url" class="form-label">URL Video</label>
                <input type="text" name="video_url" id="video_url" class="form-control" placeholder="URL Video" required>
            </div>
            <div class="mb-3">
                <label for="is_premium" class="form-label">Video Premium</label><br>
                <input type="radio" name="is_premium" id="is_premium" value="1">Ya
                <input type="radio" name="is_premium" id="is_premium" value="0">Tidak
            </div>
            <div class="mb-3">
                <label for="thumbnail" class="form-label">Thumbnail</label>
                <input type="file" name="thumbnail" id="thumbnail" class="form-control" accept="image/*" required>
            </div>
            <div class="mb-3">
                <label for="premium_link" class="form-label">Premium Link</label>
                <input type="text" name="premium_link" id="premium_link" class="form-control" placeholder="Link Video Premium" required>
            </div>
            <div class="mb-3">
                <label for="member_link" class="form-label">Member Link</label>
                <input type="text" name="member_link" id="member_link" class="form-control" placeholder="Link Video Member" required>
            </div>
            <button type="submit" class="btn btn-primary">Unggah Video</button>
        </form>
    <?php else: ?>
        <div class="alert alert-warning mt-4">Hanya admin yang dapat mengunggah video.</div>
    <?php endif; ?>

    <a href="../index.php" class="btn btn-secondary mt-4">Kembali ke Daftar Video</a>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
