<?php
require_once '../components/db.php'; // Pastikan koneksi database
session_start();
// Ambil semua kategori
$sql_categories = "SELECT id, name, image FROM categories";
$result_categories = mysqli_query($conn, $sql_categories);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori - Sakurapai</title>
<!-- ✅ Tailwind v4 (CDN resmi) -->
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<!-- ✅ Font Inter (Linux-friendly) -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<!-- ✅ Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style type="text/tailwindcss">
      @theme {
        --font-sans: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Ubuntu, sans-serif;

        --color-sakura-500: #ff7d92;
        --color-sakura-400: #ff99ab;
        --color-sakura-600: #ff5c79;
        --color-sakura-300: #ffa3d1;

        --color-gray-900: #111827;
        --color-gray-800: #1f2937;
        --color-gray-700: #374151;

        --radius-lg: 0.75rem;   /* 12px */
        --radius-xl: 1rem;      /* 16px */
        --radius-2xl: 1.25rem;  /* 20px */
        
    --shadow-sticky: 0 4px 12px -2px rgba(0,0,0,0.3), 0 8px 16px -4px rgba(255,102,178,0.1);
      }
    </style>
</head>
<body style='background-color:black;'>
    <?php include '../components/navbar.php' ?>
    <div class="container mt-5">
    <?php if (!isset($_GET['category_id'])): ?>
        <!-- Menampilkan daftar kategori jika tidak ada kategori yang dipilih -->
        <h1 class="text-center text-white">Daftar Kategori</h1>
        <div style="margin-left: 50px;" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
  <?php while ($category = mysqli_fetch_assoc($result_categories)): ?>
    <div class="bg-sakura-400 rounded-lg shadow overflow-hidden">
      <!-- Gambar (gunakan placeholder jika belum ada kolom image) -->
      <div class="h-32 w-full bg-gray-200 flex items-center justify-center">
      <?php if (!empty($category['image'])): ?>
          <img src="../admin/uploads/categories/<?= htmlspecialchars($category['image']) ?>" 
               alt="<?= htmlspecialchars($category['name']) ?>" 
               class="w-full h-full object-cover">
        <?php else: ?>
          <span class="text-gray-500 text-sm">No Image</span>
        <?php endif; ?>
      </div>

      <!-- Body card -->
      <div class="p-3 text-white">
        <h5 class="font-medium truncate"><?= htmlspecialchars($category['name']) ?></h5>
        <a href="category.php?category_id=<?= (int)$category['id'] ?>" 
           class="mt-2 inline-block w-full text-center text-xs font-semibold bg-black text-pink-300 py-1.5 rounded hover:bg-gray-800 transition">
          Lihat Judul
        </a>
      </div>
    </div>
  <?php endwhile; ?>
</div>
    <?php else: 
        $category_id = intval($_GET['category_id']);
        
        // Query untuk mendapatkan judul terkait kategori
        $sql_titles = "SELECT v.title 
                       FROM videos v 
                       JOIN video_categories vc ON v.id = vc.video_id 
                       WHERE vc.category_id = ?";
        $stmt = $conn->prepare($sql_titles);
        $stmt->bind_param('i', $category_id);
        $stmt->execute();
        $result_titles = $stmt->get_result();
        
        // Mengecek jika ada hasil dari query
        if ($result_titles->num_rows > 0):
    ?>
        <div class="mt-5">
            <h2>Judul Anime Terkait</h2>
            <ul class="list-group">
                <?php while ($title = $result_titles->fetch_assoc()): ?>
                    <li class="list-group-item"><?= htmlspecialchars($title['title']) ?></li>
                <?php endwhile; ?>
            </ul>
            <a href="category.php" class="btn btn-secondary mt-3">Kembali ke Daftar Kategori</a>
        </div>
    <?php else: ?>
        <div class="mt-5">
            <p class="alert alert-warning">Tidak ada video di kategori ini.</p>
            <a href="category.php" class="btn btn-secondary mt-3">Kembali ke Daftar Kategori</a>
        </div>
    <?php endif; ?>
    <?php endif; ?>
</div>


    <?php include '../components/footer.php'; ?>
</body>
</html>
