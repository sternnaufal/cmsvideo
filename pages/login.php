<?php
session_start();
include '../components/db.php';
include '../components/setusername.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../components/styles.css">
    <link rel="icon" href="../assets/sakurapai.png" type="image/png">
</head>
<body>
<!-- Navbar -->
<?php include '../components/navbar.php'; ?>

<!-- Login Form -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="login-card">
                <h1 class="text-center" style="color: pink;">Login</h1>
                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <form action="login.php" method="POST" class="mt-4">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan Username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan Password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-pink">Login</button>
                    </div>
                </form>
                <p class="mt-3 text-center">
                    Belum memiliki akun? <a href="register.php" class="text-decoration-none" style="color: pink;">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
