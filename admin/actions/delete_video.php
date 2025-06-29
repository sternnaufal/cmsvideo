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
    echo "<div class='alert alert-warning mt-4'>Hanya admin yang dapat menghapus video.</div>";
    exit;
}

if (isset($_GET['id'])) {
    // Ambil ID video dari URL
    $video_id = $_GET['id'];

    // Ambil data video berdasarkan ID dari database untuk mendapatkan path thumbnail
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
    $thumbnail_path = $video['thumbnail']; // Menyimpan path thumbnail untuk dihapus

    // Hapus video dari database
    $sql = "DELETE FROM videos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $video_id);

    if ($stmt->execute()) {
        // Jika video berhasil dihapus, hapus file thumbnail
        if (file_exists("../../" . $thumbnail_path)) {
            unlink("../../" . $thumbnail_path); // Hapus file thumbnail dari server
        }

        echo "<div class='alert alert-success'>Video berhasil dihapus! <a href='../../index.php'>Kembali ke Daftar Video</a></div>";
    } else {
        echo "<div class='alert alert-danger'>Gagal menghapus video.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>ID video tidak valid.</div>";
}
?>
