<?php
session_start();
include '../../components/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../pages/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT is_admin FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user || !$user['is_admin']) {
    echo "Akses ditolak. Hanya admin yang dapat mengakses halaman ini.";
    exit;
}
?>
