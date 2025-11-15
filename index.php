<?php
session_start();
include 'components/db.php';
include 'components/function.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Video</title>
<!-- ✅ Tailwind v4 (CDN resmi) -->
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<!-- ✅ Font Inter (Linux-friendly) -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<!-- ✅ Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="icon" href="../assets/sakurapai.png" type="image/png">

    <!-- ✅ Tailwind v4 Theme (via @theme) -->
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
      }
    </style>
    <!-- ✅ Custom styles (hanya yang tidak bisa di-handle @theme) -->
    <style>
      /* Modal & JS-dependent styles */
      .modal-backdrop { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 50; }
      .modal { display: none; position: fixed; inset: 0; z-index: 60; padding: 1rem; align-items: center; justify-content: center; }
      .modal-open { overflow: hidden; }

      /* line-clamp for description (Tailwind v4 belum punya utiliti ini via CDN) */
      .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
      }
    </style>
</head>
<body class="bg-black text-white font-sans">
  <!-- Navbar -->
  <nav class="bg-gray-900 py-3 px-4">
    <div class="container mx-auto flex items-center justify-between">
      <a href="index.php" class="text-xl font-bold text-white">Sakurapai</a>

      <button id="mobileMenuButton" class="md:hidden text-white">
        <i class="fas fa-bars text-xl"></i>
      </button>

      <div id="navbarNav" class="hidden md:flex gap-4 ms-auto items-center">
        <?php if ($user_name): ?>
          <div class="flex items-center gap-2 px-3 py-1.5 bg-gray-700 rounded font-medium">
            <i class="fas fa-user-circle text-sakura-400"></i>
            Hi, <?= htmlspecialchars($user_name) ?>!
          </div>
          <?php if ($is_admin): ?>
            <a href="admin/views/dashboard.php" class="text-white hover:text-sakura-400 font-medium">Dashboard</a>
          <?php endif; ?>
          <a href="pages/donate.php" class="text-white hover:text-sakura-400 font-medium">Donasi</a>
          <?php if (!$is_premium): ?>
            <a href="premium.php" class="text-white hover:text-sakura-400 font-medium">Upgrade Akun!</a>
          <?php endif; ?>
          <a href="pages/logout.php" class="text-white hover:text-sakura-400 font-medium">Logout</a>
        <?php else: ?>
          <a href="pages/register.php" class="text-white hover:text-sakura-400 font-medium">Daftar</a>
          <a href="pages/login.php" class="text-white hover:text-sakura-400 font-medium">Login</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <!-- Mobile Menu -->
  <div id="mobileMenu" class="md:hidden hidden bg-gray-800 p-4 flex flex-col gap-2 text-sm">
    <?php if ($user_name): ?>
      <div class="flex items-center gap-2 px-3 py-1.5 bg-gray-700 rounded font-medium">
        <i class="fas fa-user-circle text-sakura-400"></i>
        Hi, <?= htmlspecialchars($user_name) ?>!
      </div>
      <?php if ($is_admin): ?>
        <a href="admin/views/dashboard.php" class="text-white hover:text-sakura-400">Dashboard</a>
      <?php endif; ?>
      <a href="pages/donate.php" class="text-white hover:text-sakura-400">Donasi</a>
      <?php if (!$is_premium): ?>
        <a href="premium.php" class="text-white hover:text-sakura-400">Upgrade Akun!</a>
      <?php endif; ?>
      <a href="pages/logout.php" class="text-white hover:text-sakura-400">Logout</a>
    <?php else: ?>
      <a href="pages/register.php" class="text-white hover:text-sakura-400">Daftar</a>
      <a href="pages/login.php" class="text-white hover:text-sakura-400">Login</a>
    <?php endif; ?>
  </div>

  <!-- Welcome Modal -->
  <div id="modalBackdrop" class="modal-backdrop"></div>
  <div id="welcomeModal" class="modal">
    <div class="bg-gray-900 border-2 border-sakura-400 rounded-xl w-full max-w-md text-white">
      <div class="bg-sakura-400 text-black font-bold rounded-t-xl p-4 flex justify-between items-center">
        <h5>🎉 Selamat Datang di Sakurapai! 🎉</h5>
        <button id="closeModal" class="text-black hover:text-gray-700">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="p-6 text-center">
        <h3 class="text-2xl font-bold text-sakura-500 mb-3">Halo! 👋</h3>
        <p class="mb-3">
          Selamat datang di <strong class="text-sakura-500">Sakurapai</strong>, tempat terbaik untuk menonton video anime favorit kamu! 🎥
        </p>
        <p>Jangan lupa <strong>Login</strong> atau <strong>Daftar</strong> agar bisa menikmati fitur premium.</p>
      </div>
      <div class="p-4 flex justify-center">
        <button id="modalContinue"
          class="bg-sakura-500 text-black font-bold py-2 px-6 rounded-full hover:bg-sakura-400 focus:outline-none focus:ring-2 focus:ring-sakura-500/50">
          Lanjutkan
        </button>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="container mx-auto mt-6 px-4 flex flex-col md:flex-row gap-6">
    <div class="flex-1">
      <!-- Search -->
      <div class="max-w-2xl mx-auto mb-6">
        <form action="index.php" method="GET" class="flex gap-2">
          <input 
            type="text" 
            name="search" 
            class="flex-1 px-4 py-2.5 bg-gray-800 text-white rounded-lg focus:ring-2 focus:ring-sakura-500 focus:outline-none"
            placeholder="Cari video..."
            required
          >
          <button type="submit" 
            class="px-5 py-2.5 bg-sakura-500 text-white font-medium rounded-lg hover:bg-black hover:text-sakura-400 transition">
            Cari
          </button>
        </form>
      </div>

      <?php if ($search): ?>
        <div class="max-w-2xl mx-auto text-center mb-6">
          <a href="index.php" class="inline-block px-5 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600">
            Kembali
          </a>
        </div>

        <h3 class="text-2xl font-bold text-center mb-6">Hasil Pencarian untuk "<?= htmlspecialchars($search) ?>"</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <?php if ($result->num_rows > 0): ?>
            <?php while ($video = $result->fetch_assoc()): ?>
              <div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-sakura-500/20">
                <img src="<?= htmlspecialchars($video['thumbnail']) ?>" 
                     alt="Thumbnail" class="w-full h-48 object-cover">
                <div class="p-4">
                  <h5 class="text-lg font-semibold mb-1">
                    <a href="pages/view.php?id=<?= $video['id'] ?>" 
                       class="text-white hover:text-sakura-400 hover:underline">
                      <?= htmlspecialchars($video['title']) ?>
                    </a>
                  </h5>
                  <p class="text-xs text-gray-400 mb-2"><?= htmlspecialchars($video['views']) ?> views</p>
                  <p class="text-gray-300 mb-4 line-clamp-2"><?= htmlspecialchars($video['description']) ?></p>
                  <a href="pages/view.php?id=<?= $video['id'] ?>" 
                     class="block w-full text-center py-2 bg-sakura-500 text-white font-medium rounded-lg hover:bg-black hover:text-sakura-400">
                    Lihat Video
                  </a>
                </div>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
            <p class="text-center col-span-full">Tidak ada video ditemukan.</p>
          <?php endif; ?>
        </div>
      <?php else: ?>
        <!-- Top Viewed -->
        <h3 class="text-2xl font-bold text-center my-8">Video Paling Sering Ditonton</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
          <?php if ($result_top_views->num_rows > 0): ?>
            <?php while ($video = $result_top_views->fetch_assoc()): ?>
              <div class="bg-gray-800 rounded-xl overflow-hidden shadow">
                <img src="<?= htmlspecialchars($video['thumbnail']) ?>" class="w-full h-48 object-cover">
                <div class="p-4">
                  <h5 class="text-lg font-semibold mb-2">
                    <a href="pages/view.php?id=<?= $video['id'] ?>" class="text-white hover:text-sakura-400 hover:underline">
                      <?= htmlspecialchars($video['title']) ?>
                    </a>
                  </h5>
                  <p class="text-gray-300 mb-4 line-clamp-2"><?= htmlspecialchars($video['description']) ?></p>
                  <a href="pages/view.php?id=<?= $video['id'] ?>" 
                     class="block w-full text-center py-2 bg-sakura-500 text-white font-medium rounded-lg hover:bg-black hover:text-sakura-400">
                    Lihat Video
                  </a>
                </div>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
            <p class="text-center col-span-full">Tidak ada video ditemukan.</p>
          <?php endif; ?>
        </div>

        <!-- Top Liked -->
        <h3 class="text-2xl font-bold text-center my-8">Video Paling Banyak Disukai</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
          <?php if ($result_top_likes->num_rows > 0): ?>
            <?php while ($video = $result_top_likes->fetch_assoc()): ?>
              <div class="bg-gray-800 rounded-xl overflow-hidden shadow">
                <img src="<?= htmlspecialchars($video['thumbnail']) ?>" class="w-full h-48 object-cover">
                <div class="p-4">
                  <h5 class="text-lg font-semibold mb-2">
                    <a href="pages/view.php?id=<?= $video['id'] ?>" class="text-white hover:text-sakura-400 hover:underline">
                      <?= htmlspecialchars($video['title']) ?>
                    </a>
                  </h5>
                  <p class="text-gray-300 mb-4 line-clamp-2"><?= htmlspecialchars($video['description']) ?></p>
                  <a href="pages/view.php?id=<?= $video['id'] ?>" 
                     class="block w-full text-center py-2 bg-sakura-500 text-white font-medium rounded-lg hover:bg-black hover:text-sakura-400">
                    Lihat Video
                  </a>
                </div>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
            <p class="text-center col-span-full">Tidak ada video ditemukan.</p>
          <?php endif; ?>
        </div>

        <!-- All Videos -->
        <h3 class="text-2xl font-bold text-center my-8">Semua Video</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <?php if ($result->num_rows > 0): ?>
            <?php while ($video = $result->fetch_assoc()): ?>
              <div class="bg-gray-800 rounded-xl overflow-hidden shadow">
                <img src="<?= htmlspecialchars($video['thumbnail']) ?>" class="w-full h-48 object-cover">
                <div class="p-4">
                  <h5 class="text-lg font-semibold mb-2">
                    <a href="pages/view.php?id=<?= $video['id'] ?>" class="text-white hover:text-sakura-400 hover:underline">
                      <?= htmlspecialchars($video['title']) ?>
                    </a>
                  </h5>
                  <p class="text-gray-300 mb-4 line-clamp-2"><?= htmlspecialchars($video['description']) ?></p>
                  <a href="pages/view.php?id=<?= $video['id'] ?>" 
                     class="block w-full text-center py-2 bg-sakura-500 text-white font-medium rounded-lg hover:bg-black hover:text-sakura-400">
                    Lihat Video
                  </a>
                </div>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
            <p class="text-center col-span-full">Tidak ada video ditemukan.</p>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <?php include 'components/pagination.php'; ?>
    </div>

    <!-- Mascot (desktop only) -->
    <div class="hidden md:block w-60 flex-shrink-0">
      <img src="components/sakurapai.png" alt="Maskot" class="w-full h-auto drop-shadow-lg">
    </div>
  </div>

  <?php include 'components/footer.php'; ?>

  <!-- ✅ Vanilla JS (no Bootstrap, no extra lib) -->
  <script>
    // Mobile menu
    const menuBtn = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');
    menuBtn?.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });

    // Modal
    const backdrop = document.getElementById('modalBackdrop');
    const modal = document.getElementById('welcomeModal');
    const closeBtn = document.getElementById('closeModal');
    const contBtn = document.getElementById('modalContinue');
    const body = document.body;

    if (!sessionStorage.getItem('modalShown')) {
      backdrop.style.display = 'block';
      modal.style.display = 'flex';
      body.classList.add('modal-open');
      sessionStorage.setItem('modalShown', 'true');
    }

    [backdrop, closeBtn, contBtn].forEach(el => {
      el?.addEventListener('click', () => {
        backdrop.style.display = 'none';
        modal.style.display = 'none';
        body.classList.remove('modal-open');
      });
    });
  </script>
</body>
</html>