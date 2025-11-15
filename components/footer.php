<footer class="bg-black text-white py-10 font-sans">
  <div class="container mx-auto px-4">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
      <!-- Tentang -->
      <div>
        <h5 class="text-sakura-500 text-xl font-bold mb-3">Tentang Sakurapai</h5>
        <p class="text-gray-300 text-base leading-relaxed">
          Sakurapai adalah platform video yang menghadirkan konten anime terbaru dengan pengalaman menonton yang menyenangkan dan mudah. Kami menawarkan berbagai video dengan fitur seperti komentar, like/dislike, dan konten premium yang menggemaskan!
        </p>
      </div>

      <!-- Kontak -->
      <div>
        <h5 class="text-sakura-500 text-xl font-bold mb-3">Kontak Kami</h5>
        <ul class="space-y-2 text-gray-300 text-base">
          <li>
            <i class="fas fa-envelope text-sakura-400 mr-2"></i>
            <a href="mailto:contact@sakurapai.com" class="text-sakura-400 hover:underline">
              contact@sakurapai.com
            </a>
          </li>
          <li class="flex items-center">
            <i class="fas fa-phone text-sakura-400 mr-2"></i>
            (123) 456-7890
          </li>
        </ul>
      </div>

      <!-- Ikuti Kami -->
      <div>
        <h5 class="text-sakura-500 text-xl font-bold mb-3">Ikuti Kami</h5>
        <ul class="space-y-2">
          <li>
            <a 
              href="https://github.com/sternnaufal/sakurapai" 
              class="inline-flex items-center text-sakura-400 hover:text-sakura-300 text-lg font-medium"
              target="_blank"
            >
              <i class="fab fa-github mr-2"></i> GitHub
            </a>
          </li>
        </ul>
      </div>
    </div>

    <!-- Divider -->
    <div class="w-1/2 h-px bg-sakura-500 mx-auto my-6"></div>

    <!-- Copyright -->
    <p class="text-gray-400 text-sm text-center">
      &copy; <?= date('Y') ?> Sakurapai. Semua hak cipta dilindungi. 
      <span class="text-sakura-400 text-lg ml-1">🌸</span>
    </p>
  </div>
</footer>