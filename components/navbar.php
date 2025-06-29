<?php include 'function.php';?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="../index.php">Sakurapai</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if ($user_name): ?>
                    <li class="nav-item nav-link text-white" style="background-color:grey;">
                        <i class="fas fa-user-circle" style="font-size: 18px; margin-right: 10px; color: pink"></i>
                            Hi, <?php echo htmlspecialchars($user_name); ?>!
                    </li>
                    <?php if ($is_admin): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../admin/views/dashboard.php">Dashboard</a>
                    </li>
                <?php endif; ?>
                    <li class="nav-item">
                            <a class="nav-link text-white" href="../index.php">Home</a>
                    </li><li class="nav-item">
                            <a class="nav-link text-white" href="donate.php">Donasi</a>
                    </li>
                    <?php if (!$is_premium): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="premium.php">Upgrade Akun!</a>
                    </li>
                <?php endif; ?>
                    <li class="nav-item">
                            <a class="nav-link text-white" href="logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                            <a class="nav-link text-white" href="register.php">Daftar</a>
                    </li>
                    <li class="nav-item">
                            <a class="nav-link text-white" href="login.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>