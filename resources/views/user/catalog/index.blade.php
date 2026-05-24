<x-app-layout>
    <div class="min-h-screen bg-pink-100 font-sans text-gray-900 overflow-x-hidden">

        <!-- Hero Section (bganyacatalog sebagai background penuh) -->
        <div class="relative bg-pink-200 mt-0 mx-0 flex items-center justify-between overflow-hidden shadow-xl h-[450px]">
            <!-- Gambar Background Penuh -->
            <img src="{{ asset('storage/conditions/bganyacatalog.jpg') }}" alt="Anya Background" class="absolute inset-0 w-full h-full object-cover z-0 opacity-80">
            
            <!-- Overlay Gradien Halus agar Teks Search Jelas -->
            <div class="absolute inset-0 bg-gradient-to-r from-pink-300/40 via-transparent to-transparent z-0"></div>

            <!-- Konten Teks & Search -->
            <div class="relative z-10 max-w-2xl pl-20">
                <h1 class="text-6xl font-extrabold text-white leading-tight drop-shadow-lg">
                    Find Your Alter <span class="text-red-600">Ego.</span>
                </h1>
                <p class="text-white text-lg mt-4 font-bold drop-shadow-md opacity-100">
                    Explore our vast collection of anime, game, and movie costumes.<br>
                    High-quality, hygienic, and ready to wear.
                </p>
                
                <!-- Search Bar Putih Bulat -->
                <form action="{{ route('user.catalog.index') }}" method="GET" class="mt-8 relative max-w-md shadow-2xl">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <input type="text" name="search" value="{{ request('search') }}" class="w-full pl-6 pr-12 py-4 rounded-full border-none focus:ring-2 focus:ring-pink-400 text-gray-600 placeholder-gray-400" placeholder="Search character...">
                    <button type="submit" class="absolute inset-y-0 right-0 pr-5 flex items-center">
                        <i class="fas fa-search text-pink-500"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Browse By Category Section -->
        <div class="max-w-7xl mx-auto py-16 px-6">
            <h2 class="text-4xl font-extrabold text-pink-600 text-center mb-12 tracking-wide">BROWSE BY CATEGORY</h2>
            
            <div class="flex flex-wrap justify-center gap-6 mb-20">
                <!-- All category button -->
                <a href="{{ route('user.catalog.index', request()->only('search')) }}" class="px-12 py-4 rounded-full text-2xl font-black shadow-lg transition-all transform hover:scale-105 {{ !request('category') ? 'bg-pink-600 text-white' : 'bg-pink-500 text-white hover:bg-pink-600' }} flex items-center justify-center">
                    ALL
                </a>
                @foreach($categories as $category)
                <a href="{{ route('user.catalog.index', array_merge(request()->only('search'), ['category' => $category->id])) }}" class="px-12 py-4 rounded-full text-2xl font-black shadow-lg transition-all transform hover:scale-105 {{ request('category') == $category->id ? 'bg-pink-600 text-white' : 'bg-pink-500 text-white hover:bg-pink-600' }} flex items-center justify-center">
                    {{ strtoupper($category->name) }}
                </a>
                @endforeach
            </div>

            <!-- Result Divider -->
            <div class="relative flex items-center justify-center mb-16">
                <div class="absolute w-full h-1 bg-red-500"></div>
                <div class="relative bg-pink-100 px-10">
                    <h3 class="text-4xl font-black text-red-500 uppercase italic">RESULT</h3>
                </div>
            </div>
            
            <p class="text-center text-red-500 font-bold mb-12 uppercase tracking-widest">{{ $assets->count() }} DITEMUKAN</p>

            <!-- Product Grid (Kartu Kostum Gaya Dashboard/Overlay) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                @foreach($assets as $asset)
                <!-- Kartu Menggunakan absolute inset-0 untuk foto agar penuh -->
                <div class="bg-white rounded-3xl shadow-xl group hover:shadow-2xl transition-all duration-300 overflow-hidden relative aspect-[3/4] border-4 border-white">
                    <!-- Foto Kostum Full -->
                    <img src="{{ Storage::url($asset->latestCondition->image ?? 'default.jpg') }}" class="absolute inset-0 w-full h-full object-cover z-0 group-hover:scale-105 transition-transform duration-500 {{ $asset->stock_qty <= 0 ? 'grayscale opacity-75' : '' }}">
                    
                    @if($asset->stock_qty <= 0)
                    <!-- Badge Out of Stock -->
                    <span class="absolute top-4 right-4 bg-red-600 text-white text-xs font-black px-3 py-1.5 rounded-full z-20 shadow-md uppercase tracking-wider">
                        Out of Stock
                    </span>
                    @endif
                    
                    <!-- Overlay Gradien Gelap (Gaya Dashboard) agar teks putih terbaca -->
                    <div class="absolute inset-x-0 bottom-0 h-2/3 bg-gradient-to-t from-black/90 via-black/40 to-transparent z-10"></div>

                    <!-- Teks Informasi & Tombol (Gaya Dashboard) -->
                    <div class="absolute inset-x-0 bottom-0 p-8 z-20">
                        <h4 class="text-3xl font-black text-white leading-tight uppercase drop-shadow-md">{{ $asset->name }}</h4>
                        <p class="text-gray-200 font-bold text-xl uppercase mb-6">{{ $asset->category->name ?? 'Series' }}</p>
                        
                        <!-- Tombol Detail Merah -->
                        <a href="{{ route('user.catalog.show', $asset->id) }}" class="block text-center w-full bg-red-600 text-white py-4 rounded-xl text-xl font-black uppercase hover:bg-red-700 transition tracking-tighter shadow-lg">
                            DETAIL
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Footer Media Sosial -->
        <footer class="bg-white px-6 py-10 border-t border-pink-200 mt-20 flex justify-center gap-16">
            <div class="flex items-center gap-3 text-pink-600 font-bold text-xl">
                <i class="fab fa-instagram text-3xl"></i> @YUIKA.RENTCOS
            </div>
            <div class="flex items-center gap-3 text-pink-600 font-bold text-xl">
                <i class="fab fa-tiktok text-3xl"></i> YUMICOS
            </div>
        </footer>
    </div>
</x-app-layout>