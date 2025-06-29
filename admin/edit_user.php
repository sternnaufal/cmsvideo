<?php
include 'check_admin.php';
include '../components/db.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Ambil data pengguna berdasarkan ID
    $query = "SELECT users.*, user_subscriptions.is_premium, user_subscriptions.subscription_start, user_subscriptions.subscription_end 
              FROM users 
              LEFT JOIN user_subscriptions ON users.id = user_subscriptions.user_id
              WHERE users.id = '$user_id'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    // Jika data ditemukan, tampilkan form edit
    if ($user) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Update data pengguna
            $username = $_POST['username'];
            $is_admin = $_POST['is_admin'];
            $is_premium = $_POST['is_premium'] ?? null;
            $subscription_start = $_POST['subscription_start'] ?? null;
            $subscription_end = $_POST['subscription_end'] ?? null;

            // Update status admin dan username
            $update_query = "UPDATE users SET username = '$username', is_admin = '$is_admin' WHERE id = '$user_id'";
            mysqli_query($conn, $update_query);

            // Update langganan jika ada perubahan
            if ($is_premium !== null) {
                // Cek apakah langganan sudah ada atau belum
                $subscription_query = "SELECT * FROM user_subscriptions WHERE user_id = '$user_id'";
                $subscription_result = mysqli_query($conn, $subscription_query);
                
                if (mysqli_num_rows($subscription_result) > 0) {
                    // Update subscription yang sudah ada
                    $update_subscription_query = "UPDATE user_subscriptions 
                                                  SET is_premium = '$is_premium', subscription_start = '$subscription_start', subscription_end = '$subscription_end'
                                                  WHERE user_id = '$user_id'";
                    mysqli_query($conn, $update_subscription_query);
                } else {
                    // Insert langganan baru jika belum ada
                    $insert_subscription_query = "INSERT INTO user_subscriptions (user_id, is_premium, subscription_start, subscription_end) 
                                                  VALUES ('$user_id', '$is_premium', '$subscription_start', '$subscription_end')";
                    mysqli_query($conn, $insert_subscription_query);
                }
            }

            header('Location: users_list.php'); // Redirect setelah update
        }
    } else {
        echo "Pengguna tidak ditemukan.";
    }
}
?>

<!-- Form Edit Pengguna -->
<div class="container mt-5">
    <h1 class="text-center mb-4">Edit Pengguna</h1>
    <form method="POST">
        <div class="row mb-3">
            <label for="username" class="col-sm-2 col-form-label">Username</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="username" value="<?= $user['username'] ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <label for="is_admin" class="col-sm-2 col-form-label">Status Admin</label>
            <div class="col-sm-10">
                <select class="form-select" name="is_admin">
                    <option value="1" <?= $user['is_admin'] == 1 ? 'selected' : '' ?>>Admin</option>
                    <option value="0" <?= $user['is_admin'] == 0 ? 'selected' : '' ?>>Bukan Admin</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label for="is_premium" class="col-sm-2 col-form-label">Status Langganan</label>
            <div class="col-sm-10">
                <select class="form-select" name="is_premium">
                    <option value="1" <?= $user['is_premium'] == 1 ? 'selected' : '' ?>>Premium</option>
                    <option value="0" <?= $user['is_premium'] == 0 ? 'selected' : '' ?>>Tidak Premium</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label for="subscription_start" class="col-sm-2 col-form-label">Tanggal Mulai Langganan</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" name="subscription_start" value="<?= $user['subscription_start'] ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <label for="subscription_end" class="col-sm-2 col-form-label">Tanggal Akhir Langganan</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" name="subscription_end" value="<?= $user['subscription_end'] ?>" required>
            </div>
        </div>

        <div class="row mb-3 justify-content-center">
            <div class="col-sm-4">
                <button type="submit" class="btn btn-success w-100">Update</button>
            </div>
        </div>
    </form>
</div>

<!-- Link Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
