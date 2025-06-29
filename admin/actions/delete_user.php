<?php
include '../check_admin.php';
include '../../components/db.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Hapus pengguna berdasarkan ID
    $delete_query = "DELETE FROM users WHERE id = '$user_id'";
    mysqli_query($conn, $delete_query);

    header('Location: ../views/users_list.php'); // Redirect setelah menghapus
}
?>
