<?php
session_start();
include '../components/db.php';
include '../components/setusername.php';

$error_message = $_GET['error'] ?? null;
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- ✅ Tailwind v4 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- ✅ Font Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- ✅ Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="../assets/sakurapai.png" type="image/png">

    <!-- ✅ @theme — konsisten dengan project -->
    <style type="text/tailwindcss">
      @theme {
        --font-sans: 'Inter', system-ui, Ubuntu, Roboto, sans-serif;
        --color-sakura-500: #ff7d92;
        --color-sakura-400: #ff99ab;
        --color-sakura-600: #ff5c79;
        --color-danger-500: #e74c3c;
        --color-gray-950: #0a0a0a;
        --color-gray-900: #111827;
        --color-gray-800: #1f2937;
        --radius-xl: 1rem;
      }
    </style>

    <style>
      .fade-in { animation: fadeIn 0.6s ease-out; }
      @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-black text-white font-sans">

  <?php include '../components/navbar.php'; ?>

  <!-- ✅ Login Form -->
  <div class="container mx-auto mt-8 px-4 fade-in">
    <div class="max-w-md mx-auto">
      <div class="bg-gray-900/70 backdrop-blur-sm rounded-2xl p-6 md:p-8 shadow-xl border border-sakura-500/20">
        <h1 class="text-2xl md:text-3xl font-bold text-center text-sakura-400 mb-2">Login</h1>
        <p class="text-gray-400 text-center mb-6">Masuk ke akun Sakurapaimu</p>

        <!-- ✅ Error Alert (inline, bukan modal) -->
        <?php if ($error_message): ?>
          <div class="mb-5 p-3 bg-danger-500/20 border border-danger-500/40 rounded-lg text-danger-300 text-sm">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <?= htmlspecialchars($error_message) ?>
          </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
          <div class="mb-5">
            <label for="username" class="block text-gray-300 mb-2 font-medium">Username</label>
            <input 
              type="text" 
              id="username" 
              name="username" 
              class="w-full px-4 py-3 bg-gray-800 text-white rounded-lg border border-gray-700 focus:outline-none focus:ring-2 focus:ring-sakura-500/50"
              placeholder="Masukkan username"
              required
              autocomplete="username"
            >
          </div>
          <div class="mb-6">
            <label for="password" class="block text-gray-300 mb-2 font-medium">Password</label>
            <input 
              type="password" 
              id="password" 
              name="password" 
              class="w-full px-4 py-3 bg-gray-800 text-white rounded-lg border border-gray-700 focus:outline-none focus:ring-2 focus:ring-sakura-500/50"
              placeholder="••••••••"
              required
              autocomplete="current-password"
            >
          </div>
          <button 
            type="submit" 
            class="w-full py-3 bg-gradient-to-r from-sakura-500 to-sakura-600 text-black font-bold rounded-xl shadow-lg hover:from-sakura-400 hover:to-sakura-500 transition-all duration-200"
          >
            Login
          </button>
        </form>

        <div class="mt-6 pt-5 border-t border-gray-800 text-center">
          <p class="text-gray-400">
            Belum punya akun? 
            <a href="register.php" class="text-sakura-400 hover:underline font-medium">Daftar di sini</a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- ✅ Auto-focus username (UX boost) -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const usernameInput = document.getElementById('username');
      if (usernameInput) usernameInput.focus();
    });
  </script>

</body>
</html>