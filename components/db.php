<?php
$host = "localhost"; // Ganti dengan host Anda
$user = "root";      // Ganti dengan username database Anda
$password = "";      // Ganti dengan password database Anda
$dbname = "cms_video"; // Ganti dengan nama database Anda
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
}
?>
