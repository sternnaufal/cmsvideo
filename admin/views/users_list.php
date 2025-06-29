<?php
include '../check_admin.php'; // Middleware untuk keamanan
include '../../components/db.php'; // Koneksi ke database

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
    <title>Daftar Pengguna dan Langganan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styling untuk tabel */
        .table th, .table td {
            vertical-align: middle;
        }
        .table thead {
            background-color: #f8f9fa;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f2f2f2;
        }
        .table-hover tbody tr:hover {
            background-color: #e9ecef;
        }
        .badge {
            font-size: 1em;
        }
        .btn {
            font-size: 0.9em;
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
                        <td><?= $user['username'] ?></td>
                        <td>
                            <span class="badge <?= $user['is_admin'] == 1 ? 'bg-success' : 'bg-secondary' ?>">
                                <?= $user['is_admin'] == 1 ? 'Ya' : 'Tidak' ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($user['is_premium']): ?>
                                <span class="badge bg-warning">Premium</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Tidak Ada Langganan</span>
                            <?php endif; ?>
                        </td>
                        <td><?= $user['subscription_start'] ? date('d M Y', strtotime($user['subscription_start'])) : 'N/A' ?></td>
                        <td><?= $user['subscription_end'] ? date('d M Y', strtotime($user['subscription_end'])) : 'N/A' ?></td>
                        <td>
                            <a href="../actions/edit_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="../actions/delete_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <a href="dashboard.php" class="btn btn-info">Kembali</a> <!-- Tombol Lihat Semua User -->
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
