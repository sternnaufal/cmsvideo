<?php
session_start();
session_destroy(); // Menghancurkan sesi pengguna
header("Location: login.php"); // Mengarahkan pengguna ke halaman login
exit;
?>
