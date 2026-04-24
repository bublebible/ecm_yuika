<x-app-layout>
    <div class="pb-24 pt-0 sm:pt-0 bg-gray-50 min-h-screen">
        <!-- Search Header (Mobile) -->
        <div class="bg-white p-4 sticky top-0 z-30 shadow-sm sm:hidden flex justify-between items-center">
             <h2 class="font-bold text-lg text-pink-600">Catalog</h2>
             <div class="flex space-x-2">
                 <button class="p-2 text-gray-600"><i class="fas fa-search"></i></button>
             </div>
        </div>

        <!-- Hero Section -->
        <div class="relative bg-gray-900 overflow-hidden mb-8">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1578632767115-351597cf2477?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80" alt="Cosplay Background" class="w-full h-full object-cover opacity-40">
                <div class="absolute inset-0 bg-gradient-to-r from-gray-900 via-gray-900/60 to-transparent"></div>
            </div>
            <div class="relative max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
                <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
                    Find Your <span class="text-pink-500">Alter Ego</span>.
                </h1>
                <p class="mt-4 text-xl text-gray-300 max-w-xl">
                    Explore our vast collection of anime, game, and movie costumes. High-quality, hygienic, and ready to wear.
                </p>
                <div class="mt-8 flex gap-4">
                    <div class="relative rounded-md shadow-sm flex-grow max-w-md">
                        <input type="text" class="focus:ring-pink-500 focus:border-pink-500 block w-full pl-4 pr-12 sm:text-sm border-gray-300 rounded-full py-3" placeholder="Search character, series...">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Category Highlights -->
            <div class="mb-10">
                <h3 class="font-bold text-xl text-gray-900 mb-4 px-1">Browse by Category</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                     @foreach($categories->take(6) as $category)
                        <a href="#" class="group block text-center">
                            <div class="relative rounded-full aspect-w-1 aspect-h-1 mb-2 overflow-hidden border-2 border-transparent group-hover:border-pink-500 transition">
                                @if($category->image)
                                    <img src="{{ Storage::url($category->image) }}" class="object-cover w-full h-full group-hover:scale-110 transition duration-500">
                                @else
                                    <div class="flex items-center justify-center h-full bg-gray-200 text-gray-400">
                                        <i class="fas fa-mask fa-2x"></i>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-700 group-hover:text-pink-600 transition">{{ $category->name }}</span>
                        </a>
                     @endforeach
                </div>
            </div>
            <!-- Filter Chips -->
            <div class="flex space-x-3 overflow-x-auto pb-4 no-scrollbar mb-4">
                <button class="flex-shrink-0 px-5 py-2 bg-pink-600 text-white rounded-full text-sm font-medium shadow-md">
                    All Costumes
                </button>
                @foreach($categories as $category)
                    <button class="flex-shrink-0 px-5 py-2 bg-white text-gray-600 border border-gray-200 rounded-full text-sm font-medium shadow-sm hover:bg-gray-50">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @forelse($assets as $asset)
                <div class="bg-white rounded-2xl p-3 shadow-sm hover:shadow-md transition block group relative">
                    <a href="{{ route('user.rentals.create', ['asset_id' => $asset->id]) }}" class="absolute inset-0 z-10"></a>
                    <div class="relative mb-3">
                        <div class="aspect-w-3 aspect-h-4 bg-gray-100 rounded-xl overflow-hidden relative">
                            @if($asset->latestCondition && $asset->latestCondition->image)
                                <img src="{{ Storage::url($asset->latestCondition->image) }}" class="object-cover w-full h-full group-hover:scale-105 transition duration-500">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-300">
                                    <i class="fas fa-image fa-2x"></i>
                                </div>
                            @endif
                        </div>
                        <!-- Status Badge -->
                        @if($asset->stock_qty > 0)
                            <span class="absolute top-2 left-2 bg-green-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-md z-20">READY</span>
                        @else
                            <span class="absolute top-2 left-2 bg-gray-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-md z-20">RENTED</span>
                        @endif
                        
                        <button class="absolute top-2 right-2 h-7 w-7 bg-white/30 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-pink-500 transition shadow-sm z-20 relative">
                            <i class="far fa-heart text-xs"></i>
                        </button>
                    </div>
                    
                    <h4 class="font-bold text-gray-900 truncate text-sm sm:text-base">{{ $asset->name }}</h4>
                    <!-- Categories/Tags -->
                    <div class="flex items-center text-xs text-gray-500 mb-2">
                            <i class="fas fa-tag mr-1 text-gray-300"></i> {{ $asset->category->name ?? 'Series' }}
                    </div>
                    
                    <div class="flex items-end justify-between mt-2">
                        <div>
                            <span class="text-pink-600 font-bold block text-sm">Rp {{ number_format($asset->price_per_day, 0, ',', '.') }}</span>
                            <span class="text-gray-400 text-[10px]">/day</span>
                        </div>
                        <a href="{{ route('user.cart.add', $asset->id) }}" class="h-8 w-8 bg-pink-50 text-pink-600 rounded-full flex items-center justify-center group-hover:bg-pink-600 group-hover:text-white transition z-20 relative">
                            <i class="fas fa-plus text-xs"></i>
                        </a>
                    </div>
                </div>
                @empty
                    <div class="col-span-full text-center py-12">
                         <div class="h-20 w-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                            <i class="fas fa-box-open fa-2x"></i>
                        </div>
                        <p class="text-gray-500">Belum ada kostum tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</x-app-layout>