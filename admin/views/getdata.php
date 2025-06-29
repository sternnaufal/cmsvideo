<?php
// Menghitung jumlah pengguna premium dan biasa
$sqlPremium = "SELECT COUNT(*) as totalPremium FROM user_subscriptions WHERE is_premium = 1";
$sqlBiasa = "SELECT COUNT(*) as totalBiasa FROM user_subscriptions WHERE is_premium = 0";

// Eksekusi query
$resultPremium = $conn->query($sqlPremium);
$resultBiasa = $conn->query($sqlBiasa);

// Ambil hasilnya
$dataPremium = $resultPremium->fetch_assoc();
$dataBiasa = $resultBiasa->fetch_assoc();

$totalPremium = $dataPremium['totalPremium'];
$totalBiasa = $dataBiasa['totalBiasa'];
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
    SELECT id, title, likes, dislikes
    FROM videos
    ORDER BY likes DESC
    LIMIT 5
");

// Ambil 5 video terdislike
$top_disliked_videos = mysqli_query($conn, "
    SELECT id, title, likes, dislikes
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

$categories = [
    ['limit' => 10, 'offset' => 0],
    ['limit' => 10, 'offset' => 10],
    ['limit' => 10, 'offset' => 20],
    ['limit' => 10, 'offset' => 30]
];

// Query untuk menghitung jumlah video premium
$sql_premium = "SELECT COUNT(*) as premium_count FROM videos WHERE is_premium = 1";
$result_premium = mysqli_query($conn, $sql_premium);
$premium_data = mysqli_fetch_assoc($result_premium);
$premium_count = $premium_data['premium_count'];

// Query untuk menghitung jumlah video biasa
$sql_biasa = "SELECT COUNT(*) as biasa_count FROM videos WHERE is_premium = 0";
$result_biasa = mysqli_query($conn, $sql_biasa);
$biasa_data = mysqli_fetch_assoc($result_biasa);
$biasa_count = $biasa_data['biasa_count'];

?>