<?php
// Mengambil nama pengguna jika sudah login
$user_name = isset($_SESSION['username']) ? $_SESSION['username'] : null;
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit;
}

if (!isset($_GET['id']) || empty(trim($_GET['id']))) {
    header("Location: index.php"); // Ganti dengan halaman tujuan
    exit;
}

$video_id = trim($_GET['id']);


// Validasi panjang ID jika diperlukan (contohnya 12 karakter seperti pada sistem Anda)
if (strlen($video_id) !== 12) {
    header("Location: 404.php");
    exit;
}
// Query untuk mendapatkan data video berdasarkan id
$query = "SELECT * FROM videos WHERE id = '$video_id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    // Jika tidak ada video dengan id tersebut
    header("Location: 404.php");
    exit;
}

$video = mysqli_fetch_assoc($result);

// Proses pengiriman komentar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $user_id = $_SESSION['user_id'];
    $comment = $_POST['comment'];

    // Menyimpan komentar
    $sql_insert_comment = "INSERT INTO comments (video_id, user_id, comment) VALUES (?, ?, ?)";
    $stmt_insert_comment = $conn->prepare($sql_insert_comment);
    $stmt_insert_comment->bind_param("sis", $video_id, $user_id, $comment);
    $stmt_insert_comment->execute();
    // Redirect ke halaman yang sama untuk menampilkan komentar baru
    header("Location: view.php?id=" . $video_id);
    exit;
}

// Cek apakah video ini premium
$is_premium_video = $video['is_premium'];
// Proses feedback (like/dislike)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['feedback'])) {
    // Pastikan user login
    if (!isset($_SESSION['user_id'])) {
        die("Error: User is not logged in.");
    }

    $feedback_value = $_POST['feedback'];

    // Ambil 'id' dari URL sebagai video_id
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        die("Error: video ID (id) is not set or invalid.");
    }

    $video_id = $_GET['id']; // Gunakan 'id' dari URL sebagai video_id

    // Validasi keberadaan video_id di tabel videos
    $sql_check_video = "SELECT id, likes, dislikes FROM videos WHERE id = ?";
    $stmt_check_video = $conn->prepare($sql_check_video);
    $stmt_check_video->bind_param("s", $video_id); // Sesuaikan dengan tipe data id (string atau integer)
    $stmt_check_video->execute();
    $result_check_video = $stmt_check_video->get_result();

    if ($result_check_video->num_rows === 0) {
        die("Error: The specified video_id does not exist in the videos table.");
    }

    // Ambil data video (likes & dislikes)
    $video_data = $result_check_video->fetch_assoc();
    $likes = $video_data['likes'];
    $dislikes = $video_data['dislikes'];

    // Update jumlah likes atau dislikes berdasarkan feedback
    if ($feedback_value === 'like') {
        $likes++;
    } elseif ($feedback_value === 'dislike') {
        $dislikes++;
    } else {
        die("Error: Invalid feedback value.");
    }

    // Simpan pembaruan jumlah likes dan dislikes ke database
    $sql_update_video = "UPDATE videos SET likes = ?, dislikes = ? WHERE id = ?";
    $stmt_update_video = $conn->prepare($sql_update_video);
    $stmt_update_video->bind_param("iis", $likes, $dislikes, $video_id); // Sesuaikan tipe data (s = string, i = integer)
    $stmt_update_video->execute();

    // Reload halaman untuk menampilkan perubahan
    header("Location: view.php?id=" . $video_id);
    exit;
}

// Menghitung jumlah likes dan dislikes dari tabel feedback
$sql_feedback_count = "
    SELECT 
        SUM(CASE WHEN feedback = 'like' THEN 1 ELSE 0 END) AS likes,
        SUM(CASE WHEN feedback = 'dislike' THEN 1 ELSE 0 END) AS dislikes
    FROM feedback
    WHERE video_id = ?";
$stmt_feedback_count = $conn->prepare($sql_feedback_count);
$stmt_feedback_count->bind_param("i", $video_id);
$stmt_feedback_count->execute();
$result_feedback_count = $stmt_feedback_count->get_result();
$feedback_counts = $result_feedback_count->fetch_assoc();

// Simpan jumlah likes dan dislikes dalam variabel
$video['likes'] = $feedback_counts['likes'] ?? 0;
$video['dislikes'] = $feedback_counts['dislikes'] ?? 0;

// Cek langganan premium
$user_id = $_SESSION['user_id'];
$sql_check_subscription = "SELECT * FROM user_subscriptions WHERE user_id = ?";
$stmt_check_subscription = $conn->prepare($sql_check_subscription);
$stmt_check_subscription->bind_param("i", $user_id);
$stmt_check_subscription->execute();
$subscription = $stmt_check_subscription->get_result()->fetch_assoc();
$is_premium_user = $subscription['is_premium'] ?? false;
// Update tampilan video

// Query untuk mengambil data video berdasarkan ID
$query = "SELECT * FROM videos WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $video_id);
$stmt->execute();
$result = $stmt->get_result();

// Mengecek apakah video ditemukan
if ($result->num_rows == 0) {
    echo "Video dengan ID $video_id tidak ditemukan.";
    exit;
}

$video = $result->fetch_assoc(); // Mengambil data video
?>