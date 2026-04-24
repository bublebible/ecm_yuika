<x-app-layout>
    <div class="pb-20 sm:py-12 bg-gray-50 min-h-screen">
        <!-- Header Section (Mobile) -->
        <div class="bg-white p-4 sm:hidden sticky top-0 z-40 shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center space-x-3">
                    @auth
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff" class="h-10 w-10 rounded-full border-2 border-pink-100">
                        <div>
                            <p class="text-xs text-gray-500">Hello, Cosplayer!</p>
                            <h3 class="font-bold text-gray-900 leading-none truncate w-32">{{ Auth::user()->name }}</h3>
                        </div>
                    @else
                        <!-- Guest View -->
                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-400">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Welcome to ECM!</p>
                            <a href="{{ route('login') }}" class="font-bold text-pink-600 leading-none text-sm hover:underline">
                                Login / Register
                            </a>
                        </div>
                    @endauth
                </div>
                <div class="flex space-x-2">
                    <button class="p-2 rounded-full bg-gray-100 text-gray-600 relative">
                        <i class="far fa-bell"></i>
                        @auth
                        <span class="absolute top-1 right-2 h-2 w-2 rounded-full bg-red-500 block border-2 border-white"></span>
                        @endauth
                    </button>
                    <a href="{{ route('user.cart.index') }}" class="p-2 rounded-full bg-gray-100 text-gray-600">
                        <i class="fas fa-shopping-bag"></i>
                    </a>
                </div>
            </div>
            
            <!-- Search Bar -->
            <div class="relative">
                <input type="text" placeholder="Cari Kostum..." class="w-full bg-gray-100 border-none rounded-2xl py-3 pl-10 pr-10 text-sm focus:ring-2 focus:ring-pink-300 transition-all">
                <i class="fas fa-search absolute left-4 top-3.5 text-gray-400"></i>
                <button class="absolute right-2 top-2 p-1.5 bg-pink-500 text-white rounded-xl shadow-md">
                    <i class="fas fa-sliders-h text-xs"></i>
                </button>
            </div>
        </div>

        <!-- Desktop Header (Keep simple) -->
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </x-slot>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4 mt-4 sm:mt-0">
            
            <!-- Promo Banner -->
            <div class="relative rounded-3xl overflow-hidden bg-gray-800 h-48 sm:h-64 shadow-xl mb-8 group">
                <img src="https://images.unsplash.com/photo-1578632767115-351597cf2477?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:scale-105 transition duration-700">
                <div class="absolute inset-0 bg-gradient-to-r from-gray-900 via-transparent to-transparent"></div>
                <div class="absolute inset-0 p-6 flex flex-col justify-center items-start">
                    <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded mb-2 uppercase tracking-wide">Promo</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-1 leading-tight">Welcome <br>Discount</h2>
                    <p class="text-gray-300 text-sm mb-4 max-w-xs">Get 50% off your first rental limited time offer.</p>
                    <button class="bg-white text-gray-900 px-6 py-2 rounded-full font-bold text-sm hover:bg-pink-50 transition transform hover:-translate-y-1 shadow-lg">
                        Claim Now
                    </button>
                </div>
            </div>

            <!-- Features / Why Choose Us -->
            <div class="grid grid-cols-3 gap-4 mb-8">
                <div class="bg-white p-4 rounded-2xl shadow-sm text-center">
                    <div class="w-10 h-10 mx-auto bg-pink-100 rounded-full flex items-center justify-center text-pink-600 mb-2">
                        <i class="fas fa-tshirt"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-xs sm:text-sm">Premium Quality</h4>
                </div>
                <div class="bg-white p-4 rounded-2xl shadow-sm text-center">
                    <div class="w-10 h-10 mx-auto bg-purple-100 rounded-full flex items-center justify-center text-purple-600 mb-2">
                        <i class="fas fa-soap"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-xs sm:text-sm">Hygienicized</h4>
                </div>
                <div class="bg-white p-4 rounded-2xl shadow-sm text-center">
                    <div class="w-10 h-10 mx-auto bg-blue-100 rounded-full flex items-center justify-center text-blue-600 mb-2">
                        <i class="fas fa-truck-fast"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-xs sm:text-sm">Fast Delivery</h4>
                </div>
            </div>

            <!-- Categories -->
            <div class="mb-8">
                <div class="flex justify-between items-end mb-4">
                    <h3 class="font-bold text-lg text-gray-900">Categories</h3>
                    <a href="{{ route('user.catalog.index') }}" class="text-pink-500 text-sm font-semibold">See all</a>
                </div>
                <div class="flex space-x-3 overflow-x-auto pb-4 no-scrollbar">
                    <button class="flex-shrink-0 px-6 py-2.5 bg-pink-500 text-white rounded-full text-sm font-medium shadow-md">
                        <i class="fas fa-sparkles mr-1"></i> All
                    </button>
                    <button class="flex-shrink-0 px-6 py-2.5 bg-white text-gray-600 border border-gray-100 rounded-full text-sm font-medium shadow-sm whitespace-nowrap">
                        ⚡ Genshin
                    </button>
                     <button class="flex-shrink-0 px-6 py-2.5 bg-white text-gray-600 border border-gray-100 rounded-full text-sm font-medium shadow-sm whitespace-nowrap">
                        ❤️ Spy x Family
                    </button>
                     <button class="flex-shrink-0 px-6 py-2.5 bg-white text-gray-600 border border-gray-100 rounded-full text-sm font-medium shadow-sm whitespace-nowrap">
                        🚀 Star Rail
                    </button>
                </div>
            </div>

            <!-- New Arrivals (Horizontal Scroll) -->
            <div class="mb-8">
                <h3 class="font-bold text-lg text-gray-900 mb-4">New Arrivals 🔥</h3>
                <div class="flex space-x-4 overflow-x-auto pb-4 no-scrollbar snap-x">
                    @forelse($newArrivals as $asset)
                    <div class="snap-center shrink-0 w-40 bg-white rounded-xl p-2 shadow-sm hover:shadow-md transition group relative">
                        <a href="{{ route('user.rentals.create', ['asset_id' => $asset->id]) }}" class="absolute inset-0 z-10"></a>
                        <div class="aspect-w-1 aspect-h-1 rounded-lg overflow-hidden bg-gray-200 mb-2">
                             @if($asset->latestCondition && $asset->latestCondition->image)
                                <img src="{{ Storage::url($asset->latestCondition->image) }}" class="object-cover w-full h-full group-hover:scale-105 transition duration-500">
                             @else
                                <div class="flex items-center justify-center h-full text-gray-300">
                                    <i class="fas fa-image"></i>
                                </div>
                             @endif
                        </div>
                        <h4 class="font-bold text-gray-800 text-sm truncate">{{ $asset->name }}</h4>
                        <p class="text-xs text-gray-500 mb-1">{{ $asset->category->name ?? 'Costume' }}</p>
                        <span class="text-pink-600 font-bold text-xs">Rp {{ number_format($asset->price_per_day, 0, ',', '.') }}</span>
                    </div>
                    @empty
                    <div class="col-span-full p-4 text-center text-gray-500 text-sm w-full">
                        Belum ada kostum baru.
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Popular Costumes -->
            <div class="mb-8">
                <h3 class="font-bold text-lg text-gray-900 mb-4">Popular Costumes</h3>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    @forelse($popularAssets as $asset)
                    <div class="bg-white rounded-2xl p-3 shadow-sm hover:shadow-md transition relative group">
                        <a href="{{ route('user.rentals.create', ['asset_id' => $asset->id]) }}" class="absolute inset-0 z-10"></a>
                        <div class="relative mb-3">
                            <div class="aspect-w-3 aspect-h-4 bg-gray-200 rounded-xl overflow-hidden relative">
                                 @if($asset->latestCondition && $asset->latestCondition->image)
                                    <img src="{{ Storage::url($asset->latestCondition->image) }}" class="object-cover w-full h-full group-hover:scale-105 transition duration-500">
                                 @else
                                    <div class="flex items-center justify-center h-full text-gray-300">
                                        <i class="fas fa-image fa-2x"></i>
                                    </div>
                                 @endif
                            </div>
                            @if($asset->stock_qty > 0)
                                <span class="absolute top-2 left-2 bg-green-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-md z-20">READY</span>
                            @else
                                <span class="absolute top-2 left-2 bg-gray-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-md z-20">RENTED</span>
                            @endif
                            
                            <button class="absolute top-2 right-2 h-7 w-7 bg-white/30 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-pink-500 transition shadow-sm z-20 relative">
                                <i class="far fa-heart text-xs"></i>
                            </button>
                        </div>
                        <h4 class="font-bold text-gray-900 truncate">{{ $asset->name }}</h4>
                        <div class="flex justify-between items-center text-xs text-gray-500 mb-2">
                            <span>{{ $asset->category->name ?? 'Anime' }}</span>
                             <div class="flex items-center text-yellow-400">
                                <i class="fas fa-star mr-1"></i> 5.0
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-pink-600 font-bold block text-sm">Rp {{ number_format($asset->price_per_day/1000, 0) }}rb</span>
                                <span class="text-gray-400 text-[10px]">/Day</span>
                            </div>
                            <button class="h-8 w-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-900 hover:bg-pink-500 hover:text-white transition z-20 relative">
                                <i class="fas fa-shopping-bag text-xs"></i>
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-8 text-center text-gray-500">
                        Belum ada kostum populer.
                    </div>
                    @endforelse
                </div>
            </div>

             <!-- Community / Testimonials -->
             <div class="mb-8">
                <h3 class="font-bold text-lg text-gray-900 mb-4">Community Love 💬</h3>
                <div class="bg-white rounded-3xl p-6 shadow-sm">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="flex -space-x-2 overflow-hidden">
                            <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt=""/>
                            <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt=""/>
                            <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt=""/>
                        </div>
                        <p class="text-sm text-gray-500">Joined by 100+ Cosplayers</p>
                    </div>
                    <div class="space-y-4">
                        <div class="bg-gray-50 p-4 rounded-xl">
                            <p class="text-gray-700 italic text-sm">"Kostumnya wangi banget dan bersih! Suka banget sewa di sini."</p>
                             <div class="flex items-center mt-2">
                                <span class="text-xs font-bold text-gray-900">- Sarah, Jakarta</span>
                                <div class="ml-auto text-yellow-400 text-xs">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="w-full mt-4 py-3 border border-pink-200 text-pink-600 rounded-xl font-bold text-sm hover:bg-pink-50 transition">
                        Read More Stories
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    /* Hide scrollbar for Chrome, Safari and Opera */
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    /* Hide scrollbar for IE, Edge and Firefox */
    .no-scrollbar {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
</style>
