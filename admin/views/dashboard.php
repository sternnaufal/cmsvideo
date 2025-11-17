<?php
include '../check_admin.php';
include '../../components/db.php';
include 'getdata.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" href="../../assets/sakurapai.png" type="image/png">

    <style type="text/tailwindcss">
      @theme {
        --font-sans: 'Inter', system-ui, -apple-system, sans-serif;
        --color-sakura-500: #ff6f61;
        --color-sakura-600: #e55a50;
        --color-sakura-300: #ffa3d1;
        --color-gray-900: #121212;    /* navbar: solid black */
        --color-gray-800: #1e1e1e;    /* card headers */
        --color-gray-700: #2d2d2d;    /* borders & dividers */
        --color-gray-600: #444;
        --color-gray-400: #a0a0a0;
        --color-gray-200: #e0e0e0;
        --color-primary-500: #4dabf7; /* light blue, friendly */
        --color-success-500: #51cf66;
        --color-warning-500: #fcc419;
        --color-danger-500: #ff6b6b;
        --radius-lg: 0.75rem;   /* 12px */
        --radius-xl: 1rem;      /* 16px */
        --radius-2xl: 1.25rem;  /* 20px */
        
    --shadow-sticky: 0 4px 12px -2px rgba(0,0,0,0.3), 0 8px 16px -4px rgba(255,102,178,0.1);
      
      }
    </style>
</head>
<body class="bg-black text-gray-200 font-sans">

<nav class="sticky top-0 z-50 bg-gray-950 border-b border-sakura-500/20 backdrop-blur-md shadow-[var(--shadow-sticky)]">
  <div class="container mx-auto px-4">
    <div class="flex items-center justify-between h-16 md:h-20">
      <a href="../../index.php" class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-white to-sakura-300 bg-clip-text text-transparent hover:opacity-90 transition-opacity">
          Sakurapai
        </a>
    <div class="hidden md:flex gap-4">
        <a href="../../index.php"
            class="px-4 py-2.5 text-white font-medium rounded-xl bg-gray-800/50 hover:bg-sakura-500/10 hover:text-sakura-300 transition-all duration-200 border border-transparent hover:border-sakura-500/30">
            Home
          </a>
        <a href="../actions/upload.php" class="px-4 py-2.5 text-white font-medium rounded-xl bg-gray-800/50 hover:bg-sakura-500/10 hover:text-sakura-300 transition-all duration-200 border border-transparent hover:border-sakura-500/30">Unggah Video</a>
        <a href="users_list.php" class="px-4 py-2.5 text-white font-medium rounded-xl bg-gray-800/50 hover:bg-sakura-500/10 hover:text-sakura-300 transition-all duration-200 border border-transparent hover:border-sakura-500/30">Pengguna</a>
      </div>
    </div>
  </div>
</nav>

    <main class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold text-white mb-6">Admin Dashboard</h1>

        <!-- Stat cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="px-4 py-3 bg-primary-500/10 border-b border-gray-700">
                    <h3 class="font-semibold text-primary-400">Total Video</h3>
                </div>
                <div class="p-4">
                    <p class="text-2xl font-bold text-white"><?= $total_videos ?></p>
                    <p class="text-gray-400 text-sm mt-1">video tersimpan</p>
                </div>
            </div>

            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="px-4 py-3 bg-secondary-500/10 border-b border-gray-700">
                    <h3 class="font-semibold text-gray-300">Total Pengguna</h3>
                </div>
                <div class="p-4">
                    <p class="text-2xl font-bold text-white"><?= $total_users ?></p>
                    <p class="text-gray-400 text-sm mt-1">akun terdaftar</p>
                </div>
            </div>

            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="px-4 py-3 bg-sakura-500/10 border-b border-gray-700">
                    <h3 class="font-semibold text-sakura-400">Video Terbaru</h3>
                </div>
                <div class="p-4 max-h-32 overflow-y-auto">
                    <ul class="space-y-1.5 text-sm">
                        <?php 
                        mysqli_data_seek($latest_videos, 0);
                        while ($video = mysqli_fetch_assoc($latest_videos)): ?>
                            <li class="text-gray-200">
                                <span class="font-medium"><?= htmlspecialchars($video['title']) ?></span>
                                <br><span class="text-gray-500 text-xs"><?= date('d M Y', strtotime($video['created_at'])) ?></span>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Chart & Recent Users -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-6">
            <!-- Chart -->
            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="px-4 py-3 border-b border-gray-700">
                    <h3 class="font-semibold text-white">Statistik Video (Views)</h3>
                </div>
                <div class="p-4">
                    <div class="h-60">
                        <canvas id="videoChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Users -->
            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="px-4 py-3 border-b border-gray-700">
                    <h3 class="font-semibold text-white">Pengguna Terbaru</h3>
                </div>
                <div class="p-4 overflow-y-auto max-h-60">
                    <table class="w-full text-sm">
                        <thead class="text-gray-400 border-b border-gray-700">
                            <tr>
                                <th class="py-2 text-left">Username</th>
                                <th class="py-2 text-left">Admin</th>
                                <th class="py-2 text-left">Premium</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            <?php 
                            mysqli_data_seek($latest_users, 0);
                            while ($user = mysqli_fetch_assoc($latest_users)): ?>
                                <tr>
                                    <td class="py-2"><?= htmlspecialchars($user['username']) ?></td>
                                    <td class="py-2"><?= $user['is_admin'] ? '<span class="text-success-500">✓</span>' : '—' ?></td>
                                    <td class="py-2"><?= $user['is_premium'] ? '<span class="text-sakura-500">✓</span>' : '—' ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Summary cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <?php
            $summary = [
                ['label' => 'Pengguna Premium', 'value' => $totalPremium, 'color' => 'text-sakura-500'],
                ['label' => 'Pengguna Biasa', 'value' => $totalBiasa, 'color' => 'text-gray-300'],
                ['label' => 'Video Premium', 'value' => $premium_count, 'color' => 'text-sakura-500'],
                ['label' => 'Video Biasa', 'value' => $biasa_count, 'color' => 'text-gray-300'],
            ];
            ?>
            <?php foreach ($summary as $item): ?>
            <div class="bg-gray-800 rounded-lg border border-gray-700 p-4">
                <p class="text-gray-400 text-sm"><?= $item['label'] ?></p>
                <p class="text-xl font-bold <?= $item['color'] ?> mt-1"><?= $item['value'] ?></p>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Video Likes/Dislikes -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-6">
            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="px-4 py-3 border-b border-gray-700">
                    <h3 class="font-semibold text-success-500">5 Video Terlike</h3>
                </div>
                <div class="p-4">
                    <ul class="space-y-2 text-sm">
                        <?php 
                        mysqli_data_seek($top_liked_videos, 0);
                        while ($video = mysqli_fetch_assoc($top_liked_videos)): ?>
                            <li class="border-l-2 border-success-500/30 pl-2">
                                <div class="font-medium"><?= htmlspecialchars($video['title']) ?></div>
                                <div class="text-gray-400">👍 <?= $video['likes'] ?> &nbsp;|&nbsp; 👎 <?= $video['dislikes'] ?></div>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>

            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="px-4 py-3 border-b border-gray-700">
                    <h3 class="font-semibold text-danger-500">5 Video Terdislike</h3>
                </div>
                <div class="p-4">
                    <ul class="space-y-2 text-sm">
                        <?php 
                        mysqli_data_seek($top_disliked_videos, 0);
                        while ($video = mysqli_fetch_assoc($top_disliked_videos)): ?>
                            <li class="border-l-2 border-danger-500/30 pl-2">
                                <div class="font-medium"><?= htmlspecialchars($video['title']) ?></div>
                                <div class="text-gray-400">👍 <?= $video['likes'] ?> &nbsp;|&nbsp; 👎 <?= $video['dislikes'] ?></div>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Recent Comments -->
        <div class="bg-gray-800 rounded-lg border border-gray-700 mb-6">
            <div class="px-4 py-3 border-b border-gray-700">
                <h3 class="font-semibold text-white">Komentar Terbaru</h3>
            </div>
            <div class="p-4 max-h-60 overflow-y-auto">
                <ul class="space-y-3">
                    <?php 
                    mysqli_data_seek($latest_comments, 0);
                    while ($comment = mysqli_fetch_assoc($latest_comments)): ?>
                        <li class="text-sm pb-3 border-b border-gray-700 last:border-0 last:pb-0">
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-200"><?= htmlspecialchars($comment['username']) ?></span>
                                <span class="text-gray-500 text-xs"><?= date('d M', strtotime($comment['created_at'])) ?></span>
                            </div>
                            <div class="mt-1 text-gray-300">“<?= htmlspecialchars(substr($comment['comment'], 0, 70)) ?><?= strlen($comment['comment']) > 70 ? '…' : '' ?>”</div>
                            <div class="text-xs text-sakura-500/80 mt-1">→ <?= htmlspecialchars($comment['video_title']) ?></div>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="flex flex-wrap gap-3 justify-center mb-6">
            <a href="../actions/upload.php" class="px-5 py-2.5 bg-sakura-500 hover:bg-sakura-600 text-white font-medium rounded-md transition">
                <i class="fas fa-upload me-2"></i>Unggah Video Baru
            </a>
            <a href="videos_list.php" class="px-5 py-2.5 bg-gray-700 hover:bg-gray-600 text-white font-medium rounded-md transition">
                <i class="fas fa-list me-2"></i>Lihat Semua Video
            </a>
            <a href="users_list.php" class="px-5 py-2.5 bg-gray-700 hover:bg-gray-600 text-white font-medium rounded-md transition">
                <i class="fas fa-users me-2"></i>Lihat Semua Pengguna
            </a>
        </div>
    </main>

    <script>
        var ctx = document.getElementById('videoChart').getContext('2d');
        var videoChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_map('htmlspecialchars', $video_titles)); ?>,
                datasets: [{
                    label: 'Views',
                    data: <?php echo json_encode($view_counts); ?>,
                    backgroundColor: 'rgba(77, 171, 247, 0.2)',
                    borderColor: '#4dabf7',
                    borderWidth: 1,
                    borderRadius: 4,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: { color: '#a0a0a0' }
                    }
                },
                scales: {
                    x: {
                        ticks: { color: '#a0a0a0' },
                        grid: { color: 'rgba(100,100,100,0.1)' }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { color: '#a0a0a0' },
                        grid: { color: 'rgba(100,100,100,0.1)' }
                    }
                }
            }
        });
    </script>

</body>
</html>