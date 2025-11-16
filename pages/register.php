<?php
session_start();
include '../components/db.php';

// Mengambil nama pengguna jika sudah login
$user_name = isset($_SESSION['username']) ? $_SESSION['username'] : null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Cek apakah username sudah ada
    $sql_check = "SELECT * FROM users WHERE username = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $username);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $error_message = "Username sudah terdaftar. Silakan pilih username lain.";
        $show_modal = 'username_exists'; // Set modal untuk username yang sudah ada
    } else {
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        if ($stmt->execute()) {
            $success_message = "Registrasi berhasil!";
            $show_modal = 'success'; // Set modal untuk sukses
        } else {
            $error_message = "Terjadi kesalahan. Silakan coba lagi.";
            $show_modal = 'failed'; // Set modal untuk gagal
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <!-- ✅ Tailwind v4 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- ✅ Font Inter (Linux-friendly) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- ✅ Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="../assets/sakurapai.png" type="image/png">

    <!-- ✅ @theme — konsisten dengan index.php -->
    <style type="text/tailwindcss">
      @theme {
        --font-sans: 'Inter', system-ui, Ubuntu, Roboto, sans-serif;
        --color-sakura-500: #ff7d92;
        --color-sakura-400: #ff99ab;
        --color-sakura-600: #ff5c79;
        --color-success-500: #2ecc71;
        --color-danger-500: #e74c3c;
        --color-gray-950: #0a0a0a;
        --color-gray-900: #111827;
        --color-gray-800: #1f2937;
        --radius-xl: 1rem;
      }
    </style>

    <!-- ✅ Modal & Fade-in styles -->
    <style>
      .modal-backdrop { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 50; }
      .modal { display: none; position: fixed; inset: 0; z-index: 60; padding: 1rem; align-items: center; justify-content: center; }
      .fade-in { animation: fadeIn 0.6s ease-out; }
      @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-black text-white font-sans">

  <?php include '../components/navbar.php'; ?>

  <!-- ✅ Modal: Username Exists -->
  <div id="usernameExistsModalBackdrop" class="modal-backdrop"></div>
  <div id="usernameExistsModal" class="modal">
    <div class="bg-gray-900 border border-gray-700 rounded-xl w-full max-w-md p-6">
      <div class="flex justify-between items-center mb-4">
        <h5 class="text-lg font-bold text-gray-200">Peringatan</h5>
        <button id="closeUsernameModal" class="text-gray-400 hover:text-white">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="text-gray-300 mb-5">
        <?= htmlspecialchars($error_message) ?: 'Username sudah terdaftar.' ?>
      </div>
      <div class="text-right">
        <button id="closeUsernameModalBtn" 
                class="px-4 py-2 bg-sakura-500 text-black font-medium rounded-lg hover:bg-sakura-400 transition">
          Tutup
        </button>
      </div>
    </div>
  </div>

  <!-- ✅ Modal: Failed -->
  <div id="failedModalBackdrop" class="modal-backdrop"></div>
  <div id="failedModal" class="modal">
    <div class="bg-gray-900 border border-danger-500 rounded-xl w-full max-w-md p-6">
      <div class="flex justify-between items-center mb-4">
        <h5 class="text-lg font-bold text-danger-400">Registrasi Gagal</h5>
        <button id="closeFailedModal" class="text-gray-400 hover:text-white">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="text-gray-300 mb-5">
        <?= htmlspecialchars($error_message) ?: 'Terjadi kesalahan. Silakan coba lagi.' ?>
      </div>
      <div class="text-right">
        <button id="closeFailedModalBtn" 
                class="px-4 py-2 bg-danger-500 text-white font-medium rounded-lg hover:bg-danger-400 transition">
          Tutup
        </button>
      </div>
    </div>
  </div>

  <!-- ✅ Modal: Success -->
  <div id="successModalBackdrop" class="modal-backdrop"></div>
  <div id="successModal" class="modal">
    <div class="bg-gray-900 border border-success-500 rounded-xl w-full max-w-md p-6">
      <div class="flex justify-between items-center mb-4">
        <h5 class="text-lg font-bold text-success-400">Registrasi Berhasil!</h5>
        <button id="closeSuccessModal" class="text-gray-400 hover:text-white">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="text-gray-300 mb-5">
        <?= htmlspecialchars($success_message) ?: 'Akun berhasil dibuat. Silakan login.' ?>
      </div>
      <div class="text-right">
        <a href="login.php" 
           class="px-4 py-2 bg-success-500 text-white font-medium rounded-lg hover:bg-success-400 transition">
          Login di sini
        </a>
      </div>
    </div>
  </div>

  <!-- ✅ Form Registrasi -->
  <div class="container mx-auto mt-8 px-4 fade-in">
    <div class="max-w-md mx-auto">
      <div class="bg-gray-900/70 backdrop-blur-sm rounded-2xl p-6 md:p-8 shadow-xl border border-sakura-500/20">
        <h1 class="text-2xl md:text-3xl font-bold text-center text-sakura-400 mb-6">Register</h1>
        <form action="register.php" method="POST">
          <div class="mb-5">
            <label for="username" class="block text-gray-300 mb-2 font-medium">Username</label>
            <input 
              type="text" 
              id="username" 
              name="username" 
              class="w-full px-4 py-3 bg-gray-800 text-white rounded-lg border border-gray-700 focus:outline-none focus:ring-2 focus:ring-sakura-500/50"
              placeholder="Masukkan Username"
              required
            >
          </div>
          <div class="mb-6">
            <label for="password" class="block text-gray-300 mb-2 font-medium">Password</label>
            <input 
              type="password" 
              id="password" 
              name="password" 
              class="w-full px-4 py-3 bg-gray-800 text-white rounded-lg border border-gray-700 focus:outline-none focus:ring-2 focus:ring-sakura-500/50"
              placeholder="Masukkan Password"
              required
            >
          </div>
          <button 
            type="submit" 
            class="w-full py-3 bg-gradient-to-r from-sakura-500 to-sakura-600 text-black font-bold rounded-xl shadow-lg hover:from-sakura-400 hover:to-sakura-500 transition-all duration-200"
          >
            Daftar
          </button>
        </form>
        <p class="mt-5 text-center text-gray-400">
          Sudah punya akun? 
          <a href="login.php" class="text-sakura-400 hover:underline font-medium">Login di sini</a>
        </p>
      </div>
    </div>
  </div>

  <!-- ✅ JS Modal Control -->
  <script>
    // Modal controllers
    const modals = {
      username: {
        backdrop: document.getElementById('usernameExistsModalBackdrop'),
        modal: document.getElementById('usernameExistsModal'),
        closeBtns: [
          document.getElementById('closeUsernameModal'),
          document.getElementById('closeUsernameModalBtn')
        ]
      },
      failed: {
        backdrop: document.getElementById('failedModalBackdrop'),
        modal: document.getElementById('failedModal'),
        closeBtns: [
          document.getElementById('closeFailedModal'),
          document.getElementById('closeFailedModalBtn')
        ]
      },
      success: {
        backdrop: document.getElementById('successModalBackdrop'),
        modal: document.getElementById('successModal'),
        closeBtns: [
          document.getElementById('closeSuccessModal')
        ]
      }
    };

    function openModal(name) {
      const m = modals[name];
      if (m && m.backdrop && m.modal) {
        m.backdrop.style.display = 'block';
        m.modal.style.display = 'flex';
        document.body.classList.add('modal-open');
      }
    }

    function closeModal(name) {
      const m = modals[name];
      if (m && m.backdrop && m.modal) {
        m.backdrop.style.display = 'none';
        m.modal.style.display = 'none';
        document.body.classList.remove('modal-open');
      }
    }

    // Assign close handlers
    Object.keys(modals).forEach(name => {
      const m = modals[name];
      m.closeBtns.forEach(btn => {
        btn?.addEventListener('click', () => closeModal(name));
      });
      m.backdrop?.addEventListener('click', () => closeModal(name));
    });

    // Auto-open modal berdasarkan PHP
    <?php if ($show_modal === 'username_exists'): ?>
      openModal('username');
    <?php elseif ($show_modal === 'failed'): ?>
      openModal('failed');
    <?php elseif ($show_modal === 'success'): ?>
      openModal('success');
    <?php endif; ?>
  </script>

</body>
</html>