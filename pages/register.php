<?php
session_start();
include '../components/db.php';

// Mengambil nama pengguna jika sudah login
$user_name = isset($_SESSION['username']) ? $_SESSION['username'] : null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Cek apakah username sudah ada
    $sql_check = "SELECT * FROM users WHERE username = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $username);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $error_message = "Username sudah terdaftar. Silakan pilih username lain.";
        $show_modal = 'username_exists'; // Set modal untuk username yang sudah ada
    } else {
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        if ($stmt->execute()) {
            $success_message = "Registrasi berhasil! <a href='login.php'>Login di sini</a>";
            $show_modal = 'success'; // Set modal untuk sukses
        } else {
            $error_message = "Terjadi kesalahan. Silakan coba lagi.";
            $show_modal = 'failed'; // Set modal untuk gagal
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../components/styles.css">
    <link rel="icon" href="assets/sakurapai.png" type="image/png">
</head>
<body>
    <?php include '../components/navbar.php'; ?>

    <!-- Modal Username Sudah Terdaftar -->
<div class="modal fade" id="usernameExistsModal" tabindex="-1" aria-labelledby="usernameExistsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: black; color: white;">
            <div class="modal-header" style="background-color: #333;">
                <h5 class="modal-title" id="usernameExistsModalLabel">Peringatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php echo isset($error_message) ? $error_message : ''; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-pink" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Registrasi Gagal -->
<div class="modal fade" id="failedModal" tabindex="-1" aria-labelledby="failedModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: black; color: white;">
            <div class="modal-header" style="background-color: #c0392b;">
                <h5 class="modal-title" id="failedModalLabel">Registrasi Gagal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php echo isset($error_message) ? $error_message : ''; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Registrasi Berhasil -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: black; color: white;">
            <div class="modal-header" style="background-color: #2ecc71;">
                <h5 class="modal-title" id="successModalLabel">Registrasi Berhasil!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php echo isset($success_message) ? $success_message : ''; ?>
            </div>
            <div class="modal-footer">
                <a href="login.php" class="btn btn-success">Login di sini</a>
            </div>
        </div>
    </div>
</div>


    <!-- Konten Registrasi -->
    <div class="container mt-5 fade-in">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="register.php" method="POST" class="mt-4 p-4 rounded shadow" style="background-color: #1c1c1c;">
                    <h1 class="text-center" style="color: pink;">Register</h1>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan Username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan Password" required>
                    </div>
                    <button type="submit" class="btn btn-pink w-100">Daftar</button>
                </form>
                <p class="mt-3 text-center">Sudah memiliki akun? <a href="login.php">Login di sini</a></p>
            </div>
        </div>
    </div>

    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <!-- Show Modal Based on Condition -->
    <script>
        <?php if (isset($show_modal)) { ?>
            var showModal = '<?php echo $show_modal; ?>';
            if (showModal === 'username_exists') {
                var usernameExistsModal = new bootstrap.Modal(document.getElementById('usernameExistsModal'));
                usernameExistsModal.show();
            } else if (showModal === 'failed') {
                var failedModal = new bootstrap.Modal(document.getElementById('failedModal'));
                failedModal.show();
            } else if (showModal === 'success') {
                var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
            }
        <?php } ?>
    </script>
</body>
</html>
