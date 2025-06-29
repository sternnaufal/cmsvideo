<?php
include_once 'db.php';
// Mengambil nama pengguna jika sudah login
$user_name = isset($_SESSION['username']) ? $_SESSION['username'] : null;
// Cek apakah pengguna adalah admin
$is_admin = isset($_SESSION['username']) && $_SESSION['username'] == 'admin';

// Ambil user_id dari sesi
$user_id = $_SESSION['user_id'] ?? null;

$is_premium = false; // Default, bukan premium

if ($user_id) {
    // Query untuk cek status premium
    $query = "SELECT is_premium 
              FROM user_subscriptions 
              WHERE user_id = ? AND is_premium = '1'";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $user_id); // Bind user_id
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Jika ada hasil, maka user premium
        $is_premium = true;
    }
    $stmt->close();
}

// Bagian pencarian
$search = '';
$search_param = '';
if (isset($_GET['search'])) {
        $search = $_GET['search'];
    $search_param = "%" . $search . "%";
    $sql = "SELECT * FROM videos WHERE title LIKE ? ORDER BY created_at DESC";
} else {
        $sql = "SELECT * FROM videos ORDER BY created_at DESC";
}
// Pagination
$videos_per_page = 12;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $videos_per_page;
// Menyiapkan SQL untuk menghitung total halaman
$sql_count = isset($_GET['search']) ? "SELECT COUNT(*) FROM videos WHERE title LIKE ?" : "SELECT COUNT(*) FROM videos";
$count_stmt = $conn->prepare($sql_count);
if (isset($_GET['search'])) {
        $count_stmt->bind_param("s", $search_param);
}
$count_stmt->execute();
$count_result = $count_stmt->get_result();
$total_videos = $count_result->fetch_row()[0];
$total_pages = ceil($total_videos / $videos_per_page);
// Menyiapkan SQL untuk mengambil video dengan batas pagination
$sql .= " LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
if (isset($_GET['search'])) {
        $stmt->bind_param("sii", $search_param, $videos_per_page, $offset);
} else {
        $stmt->bind_param("ii", $videos_per_page, $offset);
}
$stmt->execute();
$result = $stmt->get_result();
// Mengambil 3 video paling sering ditonton
$sql_top_views = "SELECT * FROM videos ORDER BY views DESC LIMIT 3";
$result_top_views = $conn->query($sql_top_views);
// Mengambil 3 video paling banyak disukai
$sql_top_likes = "SELECT * FROM videos ORDER BY likes DESC LIMIT 3";
$result_top_likes = $conn->query($sql_top_likes);
?>