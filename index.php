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
<!-- Tailwind v4 (CDN resmi) -->
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<!-- Font Inter -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="icon" href="../assets/sakurapai.png" type="image/png">

    <!-- Tailwind v4 Theme (via @theme) -->
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
    <!-- Custom styles (hanya yang tidak bisa di-handle @theme) -->
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
   <!-- Navbar — versi premium sticky (disamakan) -->
  <nav class="sticky top-0 z-50 bg-gray-950 border-b border-sakura-500/20 backdrop-blur-md shadow-[var(--shadow-sticky)]">
    <div class="container mx-auto px-4">
      <div class="flex items-center justify-between h-16 md:h-20">
        <!-- Logo -->
        <a href="index.php" class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-white to-sakura-300 bg-clip-text text-transparent hover:opacity-90 transition-opacity">
          Sakurapai
        </a>

        <!-- Desktop Nav -->
        <div class="hidden md:flex items-center gap-2 md:gap-4 ms-auto">
          <?php if ($user_name): ?>
            <!-- User Badge -->
            <div class="flex items-center gap-3 px-4 py-2.5 bg-gray-800/70 backdrop-blur-sm rounded-xl border border-sakura-500/30 shadow-sm">
              <div class="w-8 h-8 rounded-full bg-sakura-500/20 flex items-center justify-center">
                <i class="fas fa-user-circle text-sakura-400 text-lg"></i>
              </div>
              <span class="text-white font-medium">
                Hi, <span class="text-sakura-400 font-semibold"><?= htmlspecialchars($user_name) ?></span>!
              </span>
            </div>

            <a href="pages/category.php" class="px-4 py-2.5 text-white font-medium rounded-xl bg-gray-800/50 hover:bg-sakura-500/10 hover:text-sakura-300 transition-all duration-200 border border-transparent hover:border-sakura-500/30">
              Category List
            </a>

            <!-- Links -->
            <?php if ($is_admin): ?>
              <a href="admin/views/dashboard.php" class="px-4 py-2.5 text-white font-medium rounded-xl bg-gray-800/50 hover:bg-sakura-500/10 hover:text-sakura-300 transition-all duration-200 border border-transparent hover:border-sakura-500/30">
                Dashboard
              </a>
            <?php endif; ?>

            <a href="pages/donate.php" class="px-4 py-2.5 text-white font-medium rounded-xl bg-gray-800/50 hover:bg-sakura-500/10 hover:text-sakura-300 transition-all duration-200 border border-transparent hover:border-sakura-500/30">
              Donasi
            </a>

            <?php if (!$is_premium): ?>
              <a href="premium.php" class="px-4 py-2.5 bg-gradient-to-r from-sakura-500 to-sakura-600 text-black font-bold rounded-xl hover:from-sakura-400 hover:to-sakura-500 shadow-lg hover:shadow-sakura-500/30 transition-all duration-200 animate-pulse">
                🌟 Upgrade Akun!
              </a>
            <?php endif; ?>

            <a href="pages/logout.php" class="px-4 py-2.5 text-white font-medium rounded-xl bg-gray-800/50 hover:bg-red-500/20 hover:text-red-300 transition-all duration-200 border border-transparent hover:border-red-500/30">
              Logout
            </a>
          <?php else: ?>
            <a href="pages/register.php" class="px-4 py-2.5 text-white font-medium rounded-xl bg-gray-800/50 hover:bg-sakura-500/10 hover:text-sakura-300 transition-all duration-200 border border-transparent hover:border-sakura-500/30">
              Daftar
            </a>
            <a href="pages/login.php" class="px-4 py-2.5 bg-gradient-to-r from-sakura-500 to-sakura-600 text-black font-bold rounded-xl hover:from-sakura-400 hover:to-sakura-500 shadow-lg hover:shadow-sakura-500/30 transition-all duration-200">
              Login
            </a>
          <?php endif; ?>
        </div>

        <!-- Mobile Trigger -->
        <button 
          id="mobileMenuButton" 
          class="md:hidden text-white p-2.5 rounded-lg hover:bg-gray-800 transition-colors focus:outline-none focus:ring-2 focus:ring-sakura-500"
          aria-label="Toggle menu"
        >
          <i class="fas fa-bars text-2xl"></i>
        </button>
      </div>
    </div>
  </nav>

  <!-- Mobile Menu (Full-Screen Drawer) -->
  <div id="mobileMenuBackdrop" class="fixed inset-0 bg-black/60 z-55 hidden transition-opacity duration-200"></div>
  <div id="mobileMenu" class="fixed inset-y-0 right-0 w-4/5 max-w-xs bg-gray-950 border-l border-sakura-500/20 shadow-2xl z-55 transform translate-x-full transition-transform duration-300 ease-in-out">
    <div class="flex flex-col h-full p-6">
      <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-bold text-white">Menu</h3>
        <button id="closeMobileMenu" class="text-gray-400 hover:text-white p-1.5 rounded-full hover:bg-gray-800" aria-label="Close menu">
          <i class="fas fa-times text-xl"></i>
        </button>
      </div>
      <nav class="flex flex-col gap-4 flex-1">
        <?php if ($user_name): ?>
          <div class="flex items-center gap-3 p-3 bg-gray-800/50 rounded-xl">
            <div class="w-10 h-10 rounded-full bg-sakura-500/20 flex items-center justify-center">
              <i class="fas fa-user-circle text-sakura-400 text-xl"></i>
            </div>
            <span class="text-white font-medium">Hi, <span class="text-sakura-400"><?= htmlspecialchars($user_name) ?></span>!</span>
          </div>
          <?php if ($is_admin): ?>
            <a href="admin/views/dashboard.php" class="text-white hover:text-sakura-300 py-3 px-4 rounded-lg hover:bg-gray-800 transition-colors font-medium border-l-2 border-transparent hover:border-sakura-500">Dashboard</a>
          <?php endif; ?>
          <a href="pages/donate.php" class="text-white hover:text-sakura-300 py-3 px-4 rounded-lg hover:bg-gray-800 transition-colors font-medium border-l-2 border-transparent hover:border-sakura-500">Donasi</a>
          <?php if (!$is_premium): ?>
            <a href="premium.php" class="bg-gradient-to-r from-sakura-500 to-sakura-600 text-black font-bold py-3 px-4 rounded-lg shadow hover:shadow-sakura-500/30 transition-all">🌟 Upgrade Akun!</a>
          <?php endif; ?>
          <a href="pages/logout.php" class="text-white hover:text-red-300 py-3 px-4 rounded-lg hover:bg-red-500/10 transition-colors font-medium border-l-2 border-transparent hover:border-red-500">Logout</a>
        <?php else: ?>
          <a href="pages/register.php" class="text-white hover:text-sakura-300 py-3 px-4 rounded-lg hover:bg-gray-800 transition-colors font-medium border-l-2 border-transparent hover:border-sakura-500">Daftar</a>
          <a href="pages/login.php" class="bg-gradient-to-r from-sakura-500 to-sakura-600 text-black font-bold py-3 px-4 rounded-lg shadow hover:shadow-sakura-500/30 transition-all">Login</a>
        <?php endif; ?>
      </nav>
    </div>
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
    <div class="hidden md:block w-50 flex-shrink-0">
      <img src="components/sakurapai.png" alt="Maskot" class="w-full h-auto drop-shadow-lg">
    </div>
  </div>

  <?php include 'components/footer.php'; ?>

  <!-- Vanilla JS (no Bootstrap, no extra lib) -->
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
