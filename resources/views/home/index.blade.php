<div class="relative bg-pink-200 mt-24 mx-6 rounded-3xl pt-12 pb-0 px-12 flex items-center justify-between overflow-visible shadow-xl h-64">
  <img src="{{ asset('storage/conditions/Hitori_Goto-removebg-preview.png') }}" 
       alt="Hitori Goto" 
       class="absolute left-10 bottom-0 h-[130%] w-auto object-cover object-bottom z-20">

  <!-- Konten Teks Tengah: relative z-10 agar di atas bingkai dan di bawah foto mencuat, mx-32 agar tidak tertutup foto -->
  <div class="flex-1 text-center relative z-10 mx-32">
    <h1 class="text-5xl font-extrabold text-white leading-tight">WELCOME, {{ auth()->check() ? strtoupper(auth()->user()->name) : 'GUEST' }}</h1>
    <p class="text-white text-lg mt-2 opacity-90">GET 50% OFF YOUR FIRST RENTAL LIMITED TIME OFFER.</p>
    <a href="{{ route('user.catalog.index') }}" class="inline-block mt-6 bg-white text-pink-600 px-8 py-3 rounded-full font-bold text-sm hover:bg-pink-50 transition transform hover:-translate-y-1 shadow-md">
      CLAIM NOW
    </a>
  </div>

  <!-- Foto Kanan -->
  <img src="{{ asset('storage/conditions/Spy_x_family-removebg-preview.png') }}" 
       alt="Spy x Family" 
       class="absolute right-0 bottom-0 h-[130%] w-auto object-cover object-bottom z-20">
</div>

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

<div class="max-w-[1400px] mx-auto mb-20 relative px-12">
  <div class="flex items-center gap-4 mb-10 px-6">
    <div class="w-2 h-10 bg-pink-600 rounded"></div>
    <h2 class="text-4xl font-extrabold text-pink-600">MOST RENTED</h2>
  </div>

  @if($popularAssets->isNotEmpty())
    <!-- Carousel Container (Relative for absolute position routing) -->
    <div id="most-rented-carousel" class="relative w-full h-[580px] overflow-hidden p-10 rounded-xl bg-pink-50 shadow-inner flex items-center justify-center">
      
      @foreach($popularAssets as $asset)
        @php
          $isLeft = ($loop->index == 0);
          $isCenter = ($loop->count > 1 ? $loop->index == 1 : true);
          $isRight = ($loop->index == 2);
          $isHidden = !$isLeft && !$isCenter && !$isRight;
        @endphp
        
        <!-- Foto Kostum Carousel Item -->
        <div class="carousel-item absolute transition-all duration-500 ease-in-out overflow-hidden flex items-center border-4 
          @if($isCenter)
            left-[50%] -translate-x-1/2 w-[34%] aspect-[3/4.5] z-20 scale-105 opacity-100 border-pink-400 shadow-2xl rounded-3xl
          @elseif($isLeft)
            left-[18%] -translate-x-1/2 w-[26%] aspect-[3/4] z-10 scale-95 opacity-80 border-transparent shadow-lg rounded-2xl cursor-pointer
          @elseif($isRight)
            left-[82%] -translate-x-1/2 w-[26%] aspect-[3/4] z-10 scale-95 opacity-80 border-transparent shadow-lg rounded-2xl cursor-pointer
          @else
            left-[100%] -translate-x-1/2 w-[26%] aspect-[3/4] z-0 scale-75 opacity-0 border-transparent shadow-none rounded-2xl pointer-events-none
          @endif
        ">
          <!-- Efek Glow Pink Tipis -->
          <div class="glow-overlay absolute -inset-2 bg-pink-100 transition rounded-3xl z-10 {{ $isCenter ? 'opacity-20' : 'opacity-0' }}"></div>
          
          <img src="{{ Storage::url($asset->latestCondition->image ?? 'default.jpg') }}" alt="{{ $asset->name }}" class="absolute inset-0 w-full h-full object-cover z-0 transition-transform duration-500 hover:scale-105 {{ $asset->stock_qty <= 0 ? 'grayscale opacity-75' : '' }}">
          
          @if($asset->stock_qty <= 0)
          <!-- Badge Out of Stock -->
          <span class="absolute top-4 right-4 bg-red-600 text-white text-[10px] font-black px-2.5 py-1 rounded-full z-20 shadow-md uppercase tracking-wider">
              Out of Stock
          </span>
          @endif
          
          <!-- Gradient Overlay -->
          <div class="gradient-overlay absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t z-10 transition-all duration-500 {{ $isCenter ? 'from-black/90 to-transparent' : 'from-black/80 to-transparent' }}"></div>
          
          <!-- Teks & Tombol di atas foto -->
          <div class="text-container relative z-20 w-full mt-auto flex flex-col items-center transition-all duration-500 {{ $isCenter ? 'p-8' : 'p-6' }}">
            <h4 class="asset-title font-bold text-white self-start uppercase transition-all duration-500 {{ $isCenter ? 'text-2xl' : 'text-xl' }}">{{ $asset->name }}</h4>
            <p class="asset-category font-medium mb-1 self-start uppercase transition-all duration-500 {{ $isCenter ? 'text-gray-100 text-base' : 'text-gray-200 text-xs' }}">{{ $asset->category->name ?? 'Series' }}</p>
            <a href="{{ route('user.catalog.show', $asset->id) }}" class="detail-btn block text-center mt-5 w-full bg-red-600 text-white font-bold transition-all duration-500 {{ $isCenter ? 'py-3 rounded-xl text-sm shadow-lg' : 'py-2.5 rounded-lg text-xs shadow-md' }}">DETAIL</a>
          </div>
        </div>
      @endforeach

    </div>
  @else
    <p class="text-center text-gray-500 italic py-10 w-full">No popular costumes available yet.</p>
  @endif

  <!-- Carousel Buttons -->
  <button id="carousel-prev-btn" class="absolute left-10 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/70 backdrop-blur-sm rounded-full shadow-md flex items-center justify-center text-pink-600 text-xl hover:bg-white transition z-20">
    <i class="fas fa-chevron-left"></i>
  </button>
  <button id="carousel-next-btn" class="absolute right-10 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/70 backdrop-blur-sm rounded-full shadow-md flex items-center justify-center text-pink-600 text-xl hover:bg-white transition z-20">
    <i class="fas fa-chevron-right"></i>
  </button>
</div>

<div class="max-w-[1400px] mx-auto mb-20 relative px-12">
  <div class="flex items-center gap-4 mb-10 px-6">
    <div class="w-2 h-10 bg-pink-600 rounded"></div>
    <h2 class="text-4xl font-extrabold text-pink-600">NEW ARRIVALS</h2>
  </div>

  @if($newArrivals->isNotEmpty())
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      @foreach($newArrivals as $asset)
      <!-- Foto Kostum Baru -->
      <div class="bg-white rounded-2xl shadow-lg group hover:shadow-2xl transition overflow-hidden relative aspect-[3/4]">
        <img src="{{ Storage::url($asset->latestCondition->image ?? 'default.jpg') }}" alt="{{ $asset->name }}" class="absolute inset-0 w-full h-full object-cover z-0 group-hover:scale-105 transition-transform duration-300 {{ $asset->stock_qty <= 0 ? 'grayscale opacity-75' : '' }}">
        
        @if($asset->stock_qty <= 0)
        <!-- Badge Out of Stock -->
        <span class="absolute top-4 right-4 bg-red-600 text-white text-[10px] font-black px-2.5 py-1 rounded-full z-20 shadow-md uppercase tracking-wider">
            Out of Stock
        </span>
        @endif
        
        <!-- Gradient Overlay -->
        <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-black/80 to-transparent z-10"></div>
        <!-- Teks & Tombol di atas foto -->
        <div class="absolute inset-x-0 bottom-0 p-5 z-20 flex flex-col items-center">
          <h4 class="text-lg font-bold text-white self-start uppercase">{{ $asset->name }}</h4>
          <p class="text-gray-200 font-medium text-xs self-start uppercase">{{ $asset->category->name ?? 'Series' }}</p>
          <a href="{{ route('user.catalog.show', $asset->id) }}" class="block text-center mt-4 w-full bg-red-600 text-white py-2 rounded-lg font-semibold text-xs hover:bg-red-700 transition">DETAIL</a>
        </div>
      </div>
      @endforeach
    </div>
  @else
    <p class="text-center text-gray-500 italic py-10 w-full">No new arrivals available yet.</p>
  @endif
</div>

<div class="max-w-[1400px] mx-auto mb-20 relative px-12">
  <div class="flex items-center gap-4 mb-10 px-6">
    <div class="w-2 h-10 bg-pink-600 rounded"></div>
    <h2 class="text-4xl font-extrabold text-pink-600">TESTIMONY</h2>
  </div>

  @if($testimonials->isNotEmpty())
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      @foreach($testimonials as $testimonial)
      <div class="bg-white rounded-2xl p-6 shadow-md flex gap-4 items-start border border-pink-100 hover:shadow-lg transition-shadow">
        {{-- User Avatar --}}
        <img
          src="{{ $testimonial->user->avatarUrl() }}"
          alt="{{ $testimonial->user->name }}"
          class="w-16 h-16 rounded-full border-4 border-pink-200 object-cover flex-shrink-0"
        >
        <div class="flex-1 min-w-0">
          {{-- Name --}}
          <h5 class="text-base font-bold text-pink-600 uppercase tracking-wide truncate">
            {{ $testimonial->user->name }}
          </h5>
          {{-- Stars --}}
          <div class="flex items-center gap-0.5 my-1">
            @for($s = 1; $s <= 5; $s++)
              @if($s <= $testimonial->rating)
                <i class="fas fa-star text-yellow-400 text-sm"></i>
              @else
                <i class="far fa-star text-gray-300 text-sm"></i>
              @endif
            @endfor
            <span class="text-xs text-gray-400 ml-1">({{ $testimonial->rating }}/5)</span>
          </div>
          {{-- Comment --}}
          <p class="text-sm text-gray-700 leading-relaxed italic">
            "{{ $testimonial->comment }}"
          </p>
          {{-- Review Image --}}
          @if($testimonial->image)
            <div class="mt-3">
              <img
                src="{{ $testimonial->imageUrl() }}"
                alt="Foto Review"
                class="max-h-24 w-auto rounded-xl object-cover border border-pink-100 hover:scale-[1.03] transition-transform cursor-pointer shadow-sm"
                onclick="openImageLightbox('{{ $testimonial->imageUrl() }}')"
              >
            </div>
          @endif
          {{-- Date --}}
          <p class="text-xs text-gray-400 mt-2">
            {{ $testimonial->created_at->diffForHumans() }}
          </p>
        </div>
      </div>
      @endforeach
    </div>
  @else
    {{-- Empty state --}}
    <div class="text-center py-12 bg-pink-50 rounded-2xl border border-pink-100">
      <i class="fas fa-star text-pink-300 text-5xl mb-4 block"></i>
      <p class="text-gray-500 font-medium">Belum ada testimoni.</p>
      <p class="text-sm text-gray-400 mt-1">Jadilah yang pertama berbagi pengalamanmu! 🎉</p>
    </div>
  @endif
</div>

<footer class="bg-white px-6 py-6 border-t border-pink-200 mt-auto flex justify-center gap-12 text-sm text-pink-600">
  <div class="flex items-center gap-2">
    <i class="fab fa-instagram text-xl"></i> @YUIKA.RENTCOS
  </div>
  <div class="flex items-center gap-2">
    <i class="fab fa-tiktok text-xl"></i> YUMICOS
  </div>
</footer>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const carousel = document.getElementById('most-rented-carousel');
    if (!carousel) return;
    
    const items = carousel.querySelectorAll('.carousel-item');
    if (items.length === 0) return;

    let currentIndex = 1; // Index of the center item

    function updateCarousel() {
      items.forEach((item, idx) => {
        // Reset classes
        item.className = 'carousel-item absolute transition-all duration-500 ease-in-out overflow-hidden flex items-center border-4';

        // Center Slot
        if (idx === currentIndex) {
          item.classList.add('left-[50%]', '-translate-x-1/2', 'w-[34%]', 'aspect-[3/4.5]', 'z-20', 'scale-105', 'opacity-100', 'border-pink-400', 'shadow-2xl', 'rounded-3xl');
          setCardStyle(item, true);
        }
        // Left Slot
        else if (idx === (currentIndex - 1 + items.length) % items.length) {
          item.classList.add('left-[18%]', '-translate-x-1/2', 'w-[26%]', 'aspect-[3/4]', 'z-10', 'scale-95', 'opacity-80', 'border-transparent', 'shadow-lg', 'rounded-2xl', 'cursor-pointer');
          setCardStyle(item, false);
        }
        // Right Slot
        else if (idx === (currentIndex + 1) % items.length) {
          item.classList.add('left-[82%]', '-translate-x-1/2', 'w-[26%]', 'aspect-[3/4]', 'z-10', 'scale-95', 'opacity-80', 'border-transparent', 'shadow-lg', 'rounded-2xl', 'cursor-pointer');
          setCardStyle(item, false);
        }
        // Hidden Slots (decide left or right hide for transition direction)
        else {
          const leftIdx = (currentIndex - 1 + items.length) % items.length;
          const rightIdx = (currentIndex + 1) % items.length;

          let isLeftHidden = false;
          if (leftIdx < rightIdx) {
            isLeftHidden = (idx <= leftIdx || idx > rightIdx);
          } else {
            isLeftHidden = (idx <= leftIdx && idx > rightIdx);
          }

          if (isLeftHidden) {
            item.classList.add('left-[0%]', '-translate-x-1/2', 'w-[26%]', 'aspect-[3/4]', 'z-0', 'scale-75', 'opacity-0', 'border-transparent', 'shadow-none', 'rounded-2xl', 'pointer-events-none');
          } else {
            item.classList.add('left-[100%]', '-translate-x-1/2', 'w-[26%]', 'aspect-[3/4]', 'z-0', 'scale-75', 'opacity-0', 'border-transparent', 'shadow-none', 'rounded-2xl', 'pointer-events-none');
          }
          setCardStyle(item, false);
        }
      });
    }

    function setCardStyle(item, isCenter) {
      // Glow overlay
      const glow = item.querySelector('.glow-overlay');
      if (glow) {
        if (isCenter) {
          glow.classList.remove('opacity-0');
          glow.classList.add('opacity-20');
        } else {
          glow.classList.remove('opacity-20');
          glow.classList.add('opacity-0');
        }
      }

      // Gradient overlay
      const gradient = item.querySelector('.gradient-overlay');
      if (gradient) {
        if (isCenter) {
          gradient.classList.remove('from-black/80');
          gradient.classList.add('from-black/90');
        } else {
          gradient.classList.remove('from-black/90');
          gradient.classList.add('from-black/80');
        }
      }

      // Text container
      const textContainer = item.querySelector('.text-container');
      if (textContainer) {
        if (isCenter) {
          textContainer.classList.remove('p-6');
          textContainer.classList.add('p-8');
        } else {
          textContainer.classList.remove('p-8');
          textContainer.classList.add('p-6');
        }
      }

      // Title
      const title = item.querySelector('.asset-title');
      if (title) {
        if (isCenter) {
          title.classList.remove('text-xl');
          title.classList.add('text-2xl');
        } else {
          title.classList.remove('text-2xl');
          title.classList.add('text-xl');
        }
      }

      // Category
      const category = item.querySelector('.asset-category');
      if (category) {
        if (isCenter) {
          category.classList.remove('text-gray-200', 'text-xs');
          category.classList.add('text-gray-100', 'text-base');
        } else {
          category.classList.remove('text-gray-100', 'text-base');
          category.classList.add('text-gray-200', 'text-xs');
        }
      }

      // Detail Button
      const btn = item.querySelector('.detail-btn');
      if (btn) {
        if (isCenter) {
          btn.classList.remove('py-2.5', 'rounded-lg', 'text-xs', 'shadow-md');
          btn.classList.add('py-3', 'rounded-xl', 'text-sm', 'shadow-lg');
        } else {
          btn.classList.remove('py-3', 'rounded-xl', 'text-sm', 'shadow-lg');
          btn.classList.add('py-2.5', 'rounded-lg', 'text-xs', 'shadow-md');
        }
      }
    }

    function showPrev() {
      currentIndex = (currentIndex - 1 + items.length) % items.length;
      updateCarousel();
    }

    function showNext() {
      currentIndex = (currentIndex + 1) % items.length;
      updateCarousel();
    }

    // Bind arrows
    const prevBtn = document.getElementById('carousel-prev-btn');
    const nextBtn = document.getElementById('carousel-next-btn');

    if (prevBtn) prevBtn.addEventListener('click', showPrev);
    if (nextBtn) nextBtn.addEventListener('click', showNext);

    // Bind clicks directly on left/right slots to slide them to center
    items.forEach((item, idx) => {
      item.addEventListener('click', (e) => {
        // If clicking inside detail button, let the link action work
        if (e.target.closest('.detail-btn')) return;

        if (item.classList.contains('left-[18%]')) {
          showPrev();
        } else if (item.classList.contains('left-[82%]')) {
          showNext();
        }
      });
    });

    // Run initially to set class lists correctly
    updateCarousel();
  });

  function openImageLightbox(url) {
    const lightbox = document.getElementById('reviewLightbox');
    const img = document.getElementById('lightboxImage');
    img.src = url;
    lightbox.classList.remove('hidden');
  }
  function closeReviewLightbox() {
    const lightbox = document.getElementById('reviewLightbox');
    lightbox.classList.add('hidden');
  }
</script>

{{-- Lightbox Modal --}}
<div id="reviewLightbox" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm hidden" onclick="closeReviewLightbox()">
  <div class="relative max-w-4xl max-h-[85vh] mx-4" onclick="event.stopPropagation()">
    <button onclick="closeReviewLightbox()" class="absolute -top-12 right-0 text-white hover:text-pink-300 text-3xl transition">
      <i class="fas fa-times"></i>
    </button>
    <img id="lightboxImage" src="" alt="Foto Review Enlarge" class="max-w-full max-h-[85vh] rounded-xl object-contain shadow-2xl">
  </div>
</div>
