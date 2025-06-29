<?php
include 'check_admin.php'; // Middleware untuk keamanan
include '../components/db.php'; // Koneksi ke database

// Query untuk menggabungkan data pengguna dan status langganan
$query = "
    SELECT users.id, users.username, users.is_admin, user_subscriptions.is_premium, user_subscriptions.subscription_start, user_subscriptions.subscription_end
    FROM users 
    LEFT JOIN user_subscriptions ON users.id = user_subscriptions.user_id
";
$users = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengguna dan Langganan - Sakurapai</title>
    <link href="../../components/styles.css" rel="stylesheet"> <!-- Menambahkan file CSS khusus Sakurapai -->
    <style>
        /* Tema Sakurapai */
        body {
            background-color: #000000; /* Latar belakang lembut dengan nuansa sakura */
            font-family: 'Roboto', sans-serif;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
            margin: 0 auto;
        }
        h1 {
            color: #ff6f61; /* Warna pink sakura untuk header */
            font-weight: 700;
            text-align: center;
        }
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }
        .table thead {
            background-color: #ffe0e0; /* Warna latar tabel header */
            color: #ff6f61; /* Warna teks header */
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #fce4ec; /* Warna latar belakang tabel baris ganjil */
        }
        .table-hover tbody tr:hover {
            background-color: #ffebf2; /* Warna saat hover pada baris */
        }
        .badge {
            font-size: 1em;
        }
        .badge.bg-success {
            background-color: #81c784; /* Warna hijau untuk status admin */
        }
        .badge.bg-secondary {
            background-color: #cfd8dc; /* Warna abu-abu untuk non-admin */
        }
        .badge.bg-warning {
            background-color: #ffeb3b; /* Warna kuning untuk premium */
        }
        .badge.bg-danger {
            background-color: #f44336; /* Warna merah untuk tidak ada langganan */
        }
        .btn-info {
            background-color: #2196f3;
            border-color: #2196f3;
        }
        .btn-info:hover {
            background-color: #1976d2;
            border-color: #1976d2;
        }
        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .btn-sm {
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Daftar Semua Pengguna dan Langganan</h1>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Status Admin</th>
                    <th>Status Langganan</th>
                    <th>Tanggal Mulai Langganan</th>
                    <th>Tanggal Akhir Langganan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = mysqli_fetch_assoc($users)): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td>
                            <span class="badge <?= $user['is_admin'] == 1 ? 'bg-success' : 'bg-secondary' ?>">
                                <?= $user['is_admin'] == 1 ? 'Ya' : 'Tidak' ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($user['is_premium']): ?>
                                <span class="badge bg-info">Premium</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Tidak Ada Langganan</span>
                            <?php endif; ?>
                        </td>
                        <td><?= $user['subscription_start'] ? date('d M Y', strtotime($user['subscription_start'])) : 'N/A' ?></td>
                        <td><?= $user['subscription_end'] ? date('d M Y', strtotime($user['subscription_end'])) : 'N/A' ?></td>
                        <td>
                            <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="delete_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="dashboard.php" class="btn btn-info">Kembali ke Dashboard</a>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
