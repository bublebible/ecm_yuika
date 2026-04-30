<x-app-layout>
  <div class="min-h-screen bg-pink-100 font-sans text-gray-900 overflow-x-hidden">
   
   
<div class="relative bg-pink-200 mt-24 mx-6 rounded-3xl pt-12 pb-0 px-12 flex items-center justify-between overflow-visible shadow-xl h-64">
  
 
  <img src="{{ asset('storage/conditions/Hitori_Goto-removebg-preview.png') }}" 
       alt="Hitori Goto" 
       class="absolute left-10 bottom-0 h-[130%] w-auto object-cover object-bottom z-20">

  <!-- Konten Teks Tengah: relative z-10 agar di atas bingkai dan di bawah foto mencuat, mx-32 agar tidak tertutup foto -->
  <div class="flex-1 text-center relative z-10 mx-32">
    <h1 class="text-5xl font-extrabold text-white leading-tight">WELCOME, USERNAME</h1>
    <p class="text-white text-lg mt-2 opacity-90">GET 50% OFF YOUR FIRST RENTAL LIMITED TIME OFFER.</p>
    <button class="mt-6 bg-white text-pink-600 px-8 py-3 rounded-full font-bold text-sm hover:bg-pink-50 transition transform hover:-translate-y-1 shadow-md">
      CLAIM NOW
    </button>
  </div>

  <!-- FOTO KANAN DIPERBAIKI: Gunakan {{ asset('storage/...') }} -->
  <!-- Foto Kanan (Anya Forger - Spy x Family): absolute, right-0 agar mepet ke kanan bingkai, bottom-0 agar menempel bawah, tinggi h-[130%] agar mencuat ke atas, object-cover object-bottom agar proporsional -->
  <!-- Perubahan utama: right-10 diubah menjadi right-0 -->
  <img src="{{ asset('storage/conditions/Spy_x_family-removebg-preview.png') }}" 
       alt="Spy x Family" 
       class="absolute right-0 bottom-0 h-[130%] w-auto object-cover object-bottom z-20">
</div>

    <!-- Info Section (Tetap Sama) -->
    <div class="grid grid-cols-3 gap-8 mx-6 mt-12 mb-16">
      <div class="text-center">
        <h3 class="text-2xl font-bold text-pink-600 mb-3">READ RULES</h3>
        <p class="text-gray-700 text-sm leading-relaxed px-4">
          Please read the terms and conditions carefully before renting (see instagram or before checkout). Follow the restrictions. Please ask for permission to do certain things related to the costume. Violations will result in the agreed-upon sanctions.
        </p>
      </div>
      <div class="text-center border-x-2 border-pink-200">
        <h3 class="text-2xl font-bold text-pink-600 mb-3">ASK AVAILABLE</h3>
        <p class="text-gray-700 text-sm leading-relaxed px-4">
          Please inquire about availability on specific dates or check the costume details page. Complete the required documentation to secure your rental. Complete documentation and requirements will ensure prompt approval.
        </p>
      </div>
      <div class="text-center">
        <h3 class="text-2xl font-bold text-pink-600 mb-3">HAPPY COSPLAY</h3>
        <p class="text-gray-700 text-sm leading-relaxed px-4">
          If all requirements have been approved, proceed with payment via the available e-wallet. Shipping costs are covered by the renter (COD). Rentals are calculated from Friday to Saturday, costest, event week, and return Monday. Happy cosplay!
        </p>
      </div>
    </div>

    <!-- Most Rented Section -->
    <div class="max-w-[1400px] mx-auto mb-20 relative px-12">
      <div class="flex items-center gap-4 mb-10 px-6">
        <div class="w-2 h-10 bg-pink-600 rounded"></div>
        <h2 class="text-4xl font-extrabold text-pink-600">MOST RENTED</h2>
      </div>

      <!-- Carousel Container -->
      <div class="flex items-center gap-10 overflow-x-auto p-10 no-scrollbar snap-x snap-mandatory rounded-xl bg-pink-50 shadow-inner">
       
        <!-- FOTO DIPERBAIKI: Gunakan {{ asset('storage/...') }} -->
        <!-- Foto Kostum 1 (Kiri) -->
        <!-- MENUHIN BINGKAI: Hapus p-6, flex-col, items-center. Tambah overflow-hidden, relative, aspect. -->
        <div class="snap-center shrink-0 w-[28%] bg-white rounded-2xl shadow-lg transition-all duration-300 transform scale-95 opacity-80 group hover:scale-100 hover:opacity-100 overflow-hidden relative aspect-[3/4]">
          <!-- FOTO FULL: absolute inset-0, object-cover -->
          <img src="{{ asset('storage/conditions/Spy x family.jpg') }}" alt="Anya Forger" class="absolute inset-0 w-full h-full object-cover z-0 group-hover:scale-105 transition-transform duration-300">
          
          <!-- Gradient Overlay -->
          <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-black/80 to-transparent z-10"></div>

          <!-- Teks & Tombol di atas foto -->
          <div class="absolute inset-x-0 bottom-0 p-6 z-20 flex flex-col items-center">
            <h4 class="text-xl font-bold text-white self-start">ANYA FORGER</h4>
            <p class="text-gray-200 font-medium text-xs self-start">SPY X FAMILY</p>
            <button class="mt-5 w-full bg-red-600 text-white py-2.5 rounded-lg font-semibold text-xs hover:bg-red-700 transition shadow-md">DETAIL</button>
          </div>
        </div>

        <!-- FOTO DIPERBAIKI: Gunakan {{ asset('storage/...') }} -->
        <!-- Foto Kostum 2 (Tengah, Terpopuler) -->
        <!-- MENUHIN BINGKAI: Hapus p-8, flex-col, items-center. Tambah overflow-hidden, relative, aspect. border-pink-400 tetap ada. -->
        <div class="snap-center shrink-0 w-[36%] bg-white rounded-3xl shadow-2xl border-4 border-pink-400 transition-all duration-500 transform scale-105 group relative overflow-hidden flex items-center aspect-[3/4.5]">
          <!-- Efek Glow Pink Tipis (z-10 agar di atas foto) -->
          <div class="absolute -inset-2 bg-pink-100 opacity-20 group-hover:opacity-30 transition rounded-3xl z-10"></div>
          
          <!-- FOTO FULL: absolute inset-0, object-cover -->
          <img src="{{ asset('storage/conditions/firefly.jpg') }}" alt="Firefly" class="absolute inset-0 w-full h-full object-cover z-0 group-hover:scale-105 transition-transform duration-300">
          
          <!-- Gradient Overlay -->
          <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-black/90 to-transparent z-10"></div>

          <!-- Teks & Tombol di atas foto -->
          <div class="relative z-20 w-full p-8 mt-auto flex flex-col items-center">
            <h4 class="text-2xl font-bold text-white self-start">FIREFLY</h4>
            <p class="text-gray-100 font-medium text-base mb-1 self-start">HONKAI STAR RAIL</p>
            <button class="mt-5 w-full bg-red-600 text-white py-3 rounded-xl font-bold text-sm hover:bg-red-700 transition shadow-lg">DETAIL</button>
          </div>
        </div>

        <!-- FOTO DIPERBAIKI: Gunakan {{ asset('storage/...') }} -->
        <!-- Foto Kostum 3 (Kanan) -->
        <!-- MENUHIN BINGKAI: Hapus p-6, flex-col, items-center. Tambah overflow-hidden, relative, aspect. -->
        <div class="snap-center shrink-0 w-[28%] bg-white rounded-2xl shadow-lg transition-all duration-300 transform scale-95 opacity-80 group hover:scale-100 hover:opacity-100 overflow-hidden relative aspect-[3/4]">
          <!-- FOTO FULL: absolute inset-0, object-cover -->
          <img src="{{ asset('storage/conditions/Navia.jpg') }}" alt="Navia" class="absolute inset-0 w-full h-full object-cover z-0 group-hover:scale-105 transition-transform duration-300">
          
          <!-- Gradient Overlay -->
          <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-black/80 to-transparent z-10"></div>

          <!-- Teks & Tombol di atas foto -->
          <div class="absolute inset-x-0 bottom-0 p-6 z-20 flex flex-col items-center">
            <h4 class="text-xl font-bold text-white self-start">NAVIA</h4>
            <p class="text-gray-200 font-medium text-xs self-start">GENSHIN IMPACT</p>
            <button class="mt-5 w-full bg-red-600 text-white py-2.5 rounded-lg font-semibold text-xs hover:bg-red-700 transition shadow-md">DETAIL</button>
          </div>
        </div>

      </div>

      <!-- Carousel Buttons (Tetap Sama) -->
      <button class="absolute left-10 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/70 backdrop-blur-sm rounded-full shadow-md flex items-center justify-center text-pink-600 text-xl hover:bg-white transition z-20">
        <i class="fas fa-chevron-left"></i>
      </button>
      <button class="absolute right-10 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/70 backdrop-blur-sm rounded-full shadow-md flex items-center justify-center text-pink-600 text-xl hover:bg-white transition z-20">
        <i class="fas fa-chevron-right"></i>
      </button>
    </div>

    <!-- New Arrivals Section -->
    <div class="max-w-[1400px] mx-auto mb-20 relative px-12">
      <div class="flex items-center gap-4 mb-10 px-6">
        <div class="w-2 h-10 bg-pink-600 rounded"></div>
        <h2 class="text-4xl font-extrabold text-pink-600">NEW ARRIVALS</h2>
      </div>

      <div class="grid grid-cols-3 gap-6">
        <!-- FOTO DIPERBAIKI: Gunakan {{ asset('storage/...') }} -->
        <!-- Foto Kostum Baru 1 (Keqing) -->
        <!-- MENUHIN BINGKAI: Hapus p-5, border. Tambah overflow-hidden, relative, aspect. -->
        <div class="bg-white rounded-2xl shadow-lg group hover:shadow-2xl transition overflow-hidden relative aspect-[3/4]">
          <!-- FOTO FULL: absolute inset-0, object-cover. Hapus rounded, mb-4 -->
          <img src="{{ asset('storage/conditions/keqing.jpg') }}" alt="Keqing" class="absolute inset-0 w-full h-full object-cover z-0 group-hover:scale-105 transition-transform duration-300">
          
          <!-- Gradient Overlay -->
          <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-black/80 to-transparent z-10"></div>

          <!-- Teks & Tombol di atas foto -->
          <div class="absolute inset-x-0 bottom-0 p-5 z-20 flex flex-col items-center">
            <h4 class="text-lg font-bold text-white self-start">KEQING</h4>
            <p class="text-gray-200 font-medium text-xs self-start">GENSHIN IMPACT</p>
            <button class="mt-4 w-full bg-red-600 text-white py-2 rounded-lg font-semibold text-xs hover:bg-red-700 transition">DETAIL</button>
          </div>
        </div>

        <!-- FOTO DIPERBAIKI: Gunakan {{ asset('storage/...') }} -->
        <!-- Foto Kostum Baru 2 (Frieren) -->
        <!-- MENUHIN BINGKAI: Hapus p-5, border. Tambah overflow-hidden, relative, aspect. -->
        <div class="bg-white rounded-2xl shadow-lg group hover:shadow-2xl transition overflow-hidden relative aspect-[3/4]">
          <!-- FOTO FULL: absolute inset-0, object-cover. Hapus rounded, mb-4 -->
          <img src="{{ asset('storage/conditions/frieren.jpg') }}" alt="Frieren" class="absolute inset-0 w-full h-full object-cover z-0 group-hover:scale-105 transition-transform duration-300">
          
          <!-- Gradient Overlay -->
          <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-black/80 to-transparent z-10"></div>

          <!-- Teks & Tombol di atas foto -->
          <div class="absolute inset-x-0 bottom-0 p-5 z-20 flex flex-col items-center">
            <h4 class="text-lg font-bold text-white self-start">FRIEREN</h4>
            <p class="text-gray-200 font-medium text-xs self-start">BEYOND THE JOURNEY'END</p>
            <button class="mt-4 w-full bg-red-600 text-white py-2 rounded-lg font-semibold text-xs hover:bg-red-700 transition">DETAIL</button>
          </div>
        </div>

        <!-- FOTO DIPERBAIKI: Gunakan {{ asset('storage/...') }} -->
        <!-- Foto Kostum Baru 3 (Elaina) -->
        <!-- MENUHIN BINGKAI: Hapus p-5, border. Tambah overflow-hidden, relative, aspect. -->
        <div class="bg-white rounded-2xl shadow-lg group hover:shadow-2xl transition overflow-hidden relative aspect-[3/4]">
          <!-- FOTO FULL: absolute inset-0, object-cover. Hapus rounded, mb-4 -->
          <img src="{{ asset('storage/conditions/elaina.jpg') }}" alt="Elaina" class="absolute inset-0 w-full h-full object-cover z-0 group-hover:scale-105 transition-transform duration-300">
          
          <!-- Gradient Overlay -->
          <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-black/80 to-transparent z-10"></div>

          <!-- Teks & Tombol di atas foto -->
          <div class="absolute inset-x-0 bottom-0 p-5 z-20 flex flex-col items-center">
            <h4 class="text-lg font-bold text-white self-start">ELAINA</h4>
            <p class="text-gray-200 font-medium text-xs self-start">WANDERING WITCH</p>
            <button class="mt-4 w-full bg-red-600 text-white py-2 rounded-lg font-semibold text-xs hover:bg-red-700 transition">DETAIL</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Testimony Section (Tetap Sama) -->
    <div class="max-w-[1400px] mx-auto mb-20 relative px-12">
      <div class="flex items-center gap-4 mb-10 px-6">
        <div class="w-2 h-10 bg-pink-600 rounded"></div>
        <h2 class="text-4xl font-extrabold text-pink-600">TESTIMONY</h2>
      </div>

      <div class="grid grid-cols-2 gap-8">
        <!-- Testimony Card 1 -->
        <div class="bg-white rounded-2xl p-6 shadow-md flex gap-4 items-center border border-pink-100">
          <!-- FOTO DIPERBAIKI: Gunakan {{ asset('storage/...') }} -->
          <img src="{{ asset('storage/conditions/elaina.jpg') }}" alt="Elaina User" class="w-20 h-20 rounded-full border-4 border-pink-200 object-cover flex-shrink-0">
          <div>
            <h5 class="text-lg font-bold text-pink-600">ELAINA</h5>
            <div class="flex items-center text-yellow-400 mb-2">
              <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
            </div>
            <p class="text-sm text-gray-700 leading-relaxed italic">"Kostumnya wangi dan cakep, pokonya rekomen disini"</p>
          </div>
        </div>

        <!-- Testimony Card 2 -->
        <div class="bg-white rounded-2xl p-6 shadow-md flex gap-4 items-center border border-pink-100">
          <!-- FOTO DIPERBAIKI: Gunakan {{ asset('storage/...') }} -->
          <img src="{{ asset('storage/conditions/elaina.jpg') }}" alt="Elaina User" class="w-20 h-20 rounded-full border-4 border-pink-200 object-cover flex-shrink-0">
          <div>
            <h5 class="text-lg font-bold text-pink-600">ELAINA</h5>
            <div class="flex items-center text-yellow-400 mb-2">
              <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
            </div>
            <p class="text-sm text-gray-700 leading-relaxed italic">"Kostumnya wangi dan cakep, pokonya rekomen disini"</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer (Tetap Sama) -->
    <footer class="bg-white px-6 py-6 border-t border-pink-200 mt-auto flex justify-center gap-12 text-sm text-pink-600">
      <div class="flex items-center gap-2">
        <i class="fab fa-instagram text-xl"></i> @YUIKA.RENTCOS
      </div>
      <div class="flex items-center gap-2">
        <i class="fab fa-tiktok text-xl"></i> YUMICOS
      </div>
    </footer>

  </div>
</x-app-layout>

<style>
  /* Hide scrollbar for smooth carousel scrolling */
  .no-scrollbar::-webkit-scrollbar {
    display: none;
  }
  .no-scrollbar {
    -ms-overflow-style: none; /* IE and Edge */
    scrollbar-width: none; /* Firefox */
  }
</style>