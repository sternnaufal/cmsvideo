# 📺 Sakurapai  

**Sakurapai** adalah platform CMS video sederhana yang berfokus pada konten anime. Proyek ini dibangun untuk mempermudah pengelolaan, penayangan, serta monetisasi video dengan sistem role-based user dan fitur premium.  

## ✨ Fitur Utama  
- 🔑 **Autentikasi Pengguna** – Registrasi & login  
- 🎥 **Upload & Tonton Video** – Dengan dukungan thumbnail  
- 👍 **Interaksi Pengguna** – Like, dislike, dan komentar  
- 🏷️ **Kategori Anime** – Video dapat dikelompokkan berdasarkan kategori  
- 🌟 **Premium & Member Role**  
  - **Member biasa**: menonton gratis dengan iklan  
  - **VIP/Premium**: tanpa iklan, akses konten premium, tombol unduh video  
- 📊 **Statistik Populer** – Daftar video terpopuler berdasarkan jumlah like & views  
- 💳 **Monetisasi**  
  - Langganan premium via **Trakteer** (Rp.5.000/bulan, 6 bulan, atau tahunan)  
  - Iklan dari **Infolinks, Adsterra, AdClickMedia, PopAds**  
  - Donasi  

## 🛠️ Teknologi yang Digunakan  
- **Frontend**: HTML, CSS, JavaScript  
- **Backend**: PHP (Native)  
- **Database**: MySQL  
- **Styling**: Bootstrap  

## 📂 Struktur Proyek (ringkas)

sakurapai/ │── admin/          # Panel admin │── assets/         # File CSS, JS, images │── includes/       # File helper, config │── uploads/        # Video & thumbnail │── index.php       # Halaman utama │── category.php    # Halaman kategori │── title.php       # Halaman judul anime │── 403.php         # Halaman akses ditolak │── 404.php         # Halaman tidak ditemukan

## 🚀 Cara Menjalankan  
1. Clone repository  
   ```bash
   git clone https://github.com/sternnaufal/sakurapai.git

2. Import database dari file sakurapai.sql ke MySQL


3. Konfigurasi koneksi database di includes/config.php


4. Jalankan di XAMPP / Laragon / LAMP lalu buka http://localhost/sakurapai



📌 Rencana Pengembangan

[ ] Dark mode UI

[ ] Fitur pencarian (opsional)

[ ] Optimasi caching untuk performa

[ ] Support multi-bahasa


👤 Author

Naufal Rakha Putra

🌍 SMKN 1 Bukittinggi

💻 Web Programmer | React.js Enthusiast

