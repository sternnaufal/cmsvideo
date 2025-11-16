<?php include 'function.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

<!-- ✅ Font Inter (Linux-friendly) -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
        
    --shadow-sticky: 0 4px 12px -2px rgba(0,0,0,0.3), 0 8px 16px -4px rgba(255,102,178,0.1);
      }
    </style>
<!-- ✅ Sticky Navbar -->
<nav class="sticky top-0 z-50 bg-gray-950 border-b border-sakura-500/20 backdrop-blur-md shadow-[var(--shadow-sticky)]">
  <div class="container mx-auto px-4">
    <div class="flex items-center justify-between h-16 md:h-20">
      <!-- Logo -->
      <a href="../index.php" class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-white to-sakura-300 bg-clip-text text-transparent hover:opacity-90 transition-opacity">
          Sakurapai
        </a>

      <!-- Desktop Nav -->
      <div class="hidden md:flex items-center gap-2 md:gap-4 ms-auto">
        <?php if ($user_name): ?>
          <!-- User Badge (lebih besar & glowing) -->
          <div class="flex items-center gap-3 px-4 py-2.5 bg-gray-800/70 backdrop-blur-sm rounded-xl border border-sakura-500/30 shadow-sm">
            <div class="w-8 h-8 rounded-full bg-sakura-500/20 flex items-center justify-center">
              <i class="fas fa-user-circle text-sakura-400 text-lg"></i>
            </div>
            <span class="text-white font-medium">
              Hi, <span class="text-sakura-400 font-semibold"><?= htmlspecialchars($user_name) ?></span>!
            </span>
          </div>

          <!-- Nav Links -->
          <?php if ($is_admin): ?>
            <a 
              href="../admin/views/dashboard.php" 
              class="px-4 py-2.5 text-white font-medium rounded-xl bg-gray-800/50 hover:bg-sakura-500/10 hover:text-sakura-300 transition-all duration-200 border border-transparent hover:border-sakura-500/30"
            >
              Dashboard
            </a>
          <?php endif; ?>

          <a 
            href="../index.php" 
            class="px-4 py-2.5 text-white font-medium rounded-xl bg-gray-800/50 hover:bg-sakura-500/10 hover:text-sakura-300 transition-all duration-200 border border-transparent hover:border-sakura-500/30"
          >
            Home
          </a>
          <a 
            href="donate.php" 
            class="px-4 py-2.5 text-white font-medium rounded-xl bg-gray-800/50 hover:bg-sakura-500/10 hover:text-sakura-300 transition-all duration-200 border border-transparent hover:border-sakura-500/30"
          >
            Donasi
          </a>

          <?php if (!$is_premium): ?>
            <a 
              href="premium.php" 
              class="px-4 py-2.5 bg-gradient-to-r from-sakura-500 to-sakura-600 text-black font-bold rounded-xl hover:from-sakura-400 hover:to-sakura-500 shadow-lg hover:shadow-sakura-500/30 transition-all duration-200 animate-pulse"
            >
              🌟 Upgrade Akun!
            </a>
          <?php endif; ?>

          <a 
            href="logout.php" 
            class="px-4 py-2.5 text-white font-medium rounded-xl bg-gray-800/50 hover:bg-red-500/20 hover:text-red-300 transition-all duration-200 border border-transparent hover:border-red-500/30"
          >
            Logout
          </a>
        <?php else: ?>
          <a 
            href="register.php" 
            class="px-4 py-2.5 text-white font-medium rounded-xl bg-gray-800/50 hover:bg-sakura-500/10 hover:text-sakura-300 transition-all duration-200 border border-transparent hover:border-sakura-500/30"
          >
            Daftar
          </a>
          <a 
            href="login.php" 
            class="px-4 py-2.5 bg-gradient-to-r from-sakura-500 to-sakura-600 text-black font-bold rounded-xl hover:from-sakura-400 hover:to-sakura-500 shadow-lg hover:shadow-sakura-500/30 transition-all duration-200"
          >
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

<!-- ✅ Mobile Menu (Full-Screen Drawer) -->
<div 
  id="mobileMenuBackdrop" 
  class="fixed inset-0 bg-black/60 z-55 hidden transition-opacity duration-200"
></div>
<div 
  id="mobileMenu" 
  class="fixed inset-y-0 right-0 w-4/5 max-w-xs bg-gray-950 border-l border-sakura-500/20 shadow-2xl z-55 transform translate-x-full transition-transform duration-300 ease-in-out"
>
  <div class="flex flex-col h-full p-6">
    <!-- Close Button -->
    <div class="flex justify-between items-center mb-6">
      <h3 class="text-xl font-bold text-white">Menu</h3>
      <button 
        id="closeMobileMenu" 
        class="text-gray-400 hover:text-white p-1.5 rounded-full hover:bg-gray-800"
        aria-label="Close menu"
      >
        <i class="fas fa-times text-xl"></i>
      </button>
    </div>

    <!-- Nav Links -->
    <nav class="flex flex-col gap-4 flex-1">
      <?php if ($user_name): ?>
        <div class="flex items-center gap-3 p-3 bg-gray-800/50 rounded-xl">
          <div class="w-10 h-10 rounded-full bg-sakura-500/20 flex items-center justify-center">
            <i class="fas fa-user-circle text-sakura-400 text-xl"></i>
          </div>
          <span class="text-white font-medium">
            Hi, <span class="text-sakura-400"><?= htmlspecialchars($user_name) ?></span>!
          </span>
        </div>

        <?php if ($is_admin): ?>
          <a href="../admin/views/dashboard.php" class="text-white hover:text-sakura-300 py-3 px-4 rounded-lg hover:bg-gray-800 transition-colors font-medium border-l-2 border-transparent hover:border-sakura-500">
            Dashboard
          </a>
        <?php endif; ?>

        <a href="../index.php" class="text-white hover:text-sakura-300 py-3 px-4 rounded-lg hover:bg-gray-800 transition-colors font-medium border-l-2 border-transparent hover:border-sakura-500">
          Home
        </a>
        <a href="donate.php" class="text-white hover:text-sakura-300 py-3 px-4 rounded-lg hover:bg-gray-800 transition-colors font-medium border-l-2 border-transparent hover:border-sakura-500">
          Donasi
        </a>

        <?php if (!$is_premium): ?>
          <a href="premium.php" class="bg-gradient-to-r from-sakura-500 to-sakura-600 text-black font-bold py-3 px-4 rounded-lg shadow hover:shadow-sakura-500/30 transition-all">
            🌟 Upgrade Akun!
          </a>
        <?php endif; ?>

        <a href="logout.php" class="text-white hover:text-red-300 py-3 px-4 rounded-lg hover:bg-red-500/10 transition-colors font-medium border-l-2 border-transparent hover:border-red-500">
          Logout
        </a>
      <?php else: ?>
        <a href="register.php" class="text-white hover:text-sakura-300 py-3 px-4 rounded-lg hover:bg-gray-800 transition-colors font-medium border-l-2 border-transparent hover:border-sakura-500">
          Daftar
        </a>
        <a href="login.php" class="bg-gradient-to-r from-sakura-500 to-sakura-600 text-black font-bold py-3 px-4 rounded-lg shadow hover:shadow-sakura-500/30 transition-all">
          Login
        </a>
      <?php endif; ?>
    </nav>
  </div>
</div>

<!-- ✅ JS Enhanced (toggle + close on click outside) -->
<script>
  const menuBtn = document.getElementById('mobileMenuButton');
  const closeBtn = document.getElementById('closeMobileMenu');
  const backdrop = document.getElementById('mobileMenuBackdrop');
  const mobileMenu = document.getElementById('mobileMenu');

  function openMenu() {
    backdrop.classList.remove('hidden');
    mobileMenu.classList.remove('translate-x-full');
    document.body.style.overflow = 'hidden'; // prevent scroll
  }

  function closeMenu() {
    backdrop.classList.add('hidden');
    mobileMenu.classList.add('translate-x-full');
    document.body.style.overflow = '';
  }

  menuBtn?.addEventListener('click', openMenu);
  closeBtn?.addEventListener('click', closeMenu);
  backdrop?.addEventListener('click', closeMenu);

  // ESC to close
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && !mobileMenu.classList.contains('translate-x-full')) {
      closeMenu();
    }
  });
</script>