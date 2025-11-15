<?php include 'function.php'; ?>

<!-- Navbar -->
<nav class="bg-gray-900 py-3 px-4 shadow-md">
  <div class="container mx-auto flex items-center justify-between">
    <!-- Logo -->
    <a href="../index.php" class="text-xl font-bold text-white">Sakurapai</a>

    <!-- Hamburger (mobile only) -->
    <button id="mobileMenuButton" class="md:hidden text-white focus:outline-none">
      <i class="fas fa-bars text-xl"></i>
    </button>

    <!-- Desktop Menu -->
    <div id="navbarNav" class="hidden md:flex items-center gap-5 ms-auto">
      <?php if ($user_name): ?>
        <!-- User Info -->
        <div class="flex items-center gap-2 px-3 py-1.5 bg-gray-700 rounded font-medium text-white">
          <i class="fas fa-user-circle text-sakura-400 text-lg"></i>
          Hi, <?= htmlspecialchars($user_name) ?>!
        </div>

        <!-- Admin Link -->
        <?php if ($is_admin): ?>
          <a href="../admin/views/dashboard.php" class="text-white hover:text-sakura-400 font-medium">Dashboard</a>
        <?php endif; ?>

        <!-- Nav Links -->
        <a href="../index.php" class="text-white hover:text-sakura-400 font-medium">Home</a>
        <a href="donate.php" class="text-white hover:text-sakura-400 font-medium">Donasi</a>

        <?php if (!$is_premium): ?>
          <a href="premium.php" class="text-white hover:text-sakura-400 font-medium">Upgrade Akun!</a>
        <?php endif; ?>

        <a href="logout.php" class="text-white hover:text-sakura-400 font-medium">Logout</a>
      <?php else: ?>
        <!-- Guest Links -->
        <a href="register.php" class="text-white hover:text-sakura-400 font-medium">Daftar</a>
        <a href="login.php" class="text-white hover:text-sakura-400 font-medium">Login</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<!-- Mobile Menu (hidden by default) -->
<div id="mobileMenu" class="md:hidden hidden bg-gray-800 p-4 mt-2 rounded-lg shadow-lg">
  <div class="flex flex-col gap-3 text-base">
    <?php if ($user_name): ?>
      <div class="flex items-center gap-2 px-3 py-2 bg-gray-700 rounded font-medium text-white">
        <i class="fas fa-user-circle text-sakura-400"></i>
        Hi, <?= htmlspecialchars($user_name) ?>!
      </div>

      <?php if ($is_admin): ?>
        <a href="../admin/views/dashboard.php" class="text-white hover:text-sakura-400 py-1.5">Dashboard</a>
      <?php endif; ?>

      <a href="../index.php" class="text-white hover:text-sakura-400 py-1.5">Home</a>
      <a href="donate.php" class="text-white hover:text-sakura-400 py-1.5">Donasi</a>

      <?php if (!$is_premium): ?>
        <a href="premium.php" class="text-white hover:text-sakura-400 py-1.5">Upgrade Akun!</a>
      <?php endif; ?>

      <a href="logout.php" class="text-white hover:text-sakura-400 py-1.5">Logout</a>
    <?php else: ?>
      <a href="register.php" class="text-white hover:text-sakura-400 py-1.5">Daftar</a>
      <a href="login.php" class="text-white hover:text-sakura-400 py-1.5">Login</a>
    <?php endif; ?>
  </div>
</div>

<!-- ✅ Vanilla JS Toggle -->
<script>
  const menuBtn = document.getElementById('mobileMenuButton');
  const mobileMenu = document.getElementById('mobileMenu');

  menuBtn?.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
  });

  // Tutup saat klik luar (opsional, tapi UX bagus)
  document.addEventListener('click', (e) => {
    if (!menuBtn?.contains(e.target) && !mobileMenu?.contains(e.target)) {
      mobileMenu?.classList.add('hidden');
    }
  });
</script>