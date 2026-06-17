<nav x-data="{ scrolled: true }" 
     class="fixed w-full z-50 top-0 bg-white/90 backdrop-blur-md shadow-md transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="text-3xl font-extrabold tracking-tight">
                        <span class="text-pink-600 transition-colors duration-300">Yuika</span>
                        <span class="text-gray-900 transition-colors duration-300">Rentcos</span>
                    </a>
                </div>
                <!-- Navigation Links -->
                <div class="hidden space-x-10 sm:ml-12 sm:flex">
                    <a href="{{ url('/') }}" 
                       class="text-sm font-semibold uppercase tracking-wider transition-colors duration-300 text-gray-900 hover:text-pink-600">
                        Home
                    </a>
                    <a href="{{ route('user.catalog.index') }}" 
                       class="text-sm font-semibold uppercase tracking-wider transition-colors duration-300 text-gray-900 hover:text-pink-600">
                        Katalog
                    </a>
                    <a href="{{ route('about') }}" 
                       class="text-sm font-semibold uppercase tracking-wider transition-colors duration-300 text-gray-900 hover:text-pink-600">
                        About Us
                    </a>
                    <a href="{{ route('user.blog.index') }}" 
                       class="text-sm font-semibold uppercase tracking-wider transition-colors duration-300 text-gray-900 hover:text-pink-600">
                        Tips & Trick
                    </a>
                </div>
            </div>
            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-3">
                <!-- Desktop Cart Icon with badge -->
                @php
                    $cart = Session::get('cart');
                    $cartCount = is_array($cart) ? count($cart) : 0;
                @endphp
                <a href="{{ route('user.cart.index') }}" class="relative text-gray-500 hover:text-pink-600 transition p-2 mr-2" title="Keranjang">
                    <i class="fas fa-shopping-bag text-xl"></i>
                    @if($cartCount > 0)
                        <span class="absolute -top-0.5 -right-0.5 h-5 min-w-[20px] px-1 flex items-center justify-center rounded-full bg-pink-500 text-white text-[10px] font-extrabold ring-2 ring-white">
                            {{ $cartCount > 9 ? '9+' : $cartCount }}
                        </span>
                    @endif
                </a>

                @auth
                    <div class="relative" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
                        <div @click="open = ! open">
                            <button class="inline-flex items-center gap-2 px-3 py-2 border border-gray-200 rounded-full text-sm font-semibold transition hover:border-pink-300 hover:bg-pink-50 text-gray-700">
                                <img src="{{ Auth::user()->avatarUrl() }}" alt="avatar"
                                     class="w-7 h-7 rounded-full object-cover ring-2 ring-pink-200">
                                <span class="max-w-[100px] truncate">{{ Auth::user()->name }}</span>
                                <svg class="fill-current h-3.5 w-3.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>

                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 z-50 mt-2 w-52 rounded-xl shadow-lg origin-top-right bg-white ring-1 ring-black/5 py-1.5 divide-y divide-gray-100"
                             style="display: none;">

                            {{-- User info --}}
                            <div class="px-4 py-2.5">
                                <p class="text-xs font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            {{-- Nav items --}}
                            <div class="py-1">
                                <a href="{{ route('user.history.index') }}"
                                   class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-700 transition">
                                    <i class="fas fa-box w-4 text-center text-gray-400"></i> Pesanan Saya
                                </a>
                                <a href="{{ route('profile.edit') }}"
                                   class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-700 transition">
                                    <i class="fas fa-user-circle w-4 text-center text-gray-400"></i> Profil
                                </a>
                            </div>

                            {{-- Logout --}}
                            <div class="py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); this.closest('form').submit();"
                                       class="flex items-center gap-2.5 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                                        <i class="fas fa-sign-out-alt w-4 text-center"></i> Keluar
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" 
                       class="text-sm font-semibold transition-colors duration-300 text-gray-900 hover:text-pink-600">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" 
                           class="px-5 py-2 rounded-full font-medium transition-all duration-300 transform hover:-translate-y-0.5 bg-pink-600 text-white shadow-lg hover:shadow-xl">
                            Get Started
                        </a>
                    @endif
                @endauth
            </div>
            <!-- Hamburger (Hidden in favor of Bottom Nav) -->
            <div class="-mr-2 flex items-center sm:hidden hidden">
                <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="inline-flex items-center justify-center p-2 rounded-md transition duration-150 ease-in-out text-gray-500">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden sm:hidden bg-white border-t border-gray-100 shadow-xl">
        <div class="pt-2 pb-3 space-y-1">
             <a href="{{ url('/') }}" class="block pl-3 pr-4 py-3 border-l-4 border-pink-500 text-base font-medium text-pink-700 bg-pink-50">
                Home
            </a>
            <a href="{{ route('user.catalog.index') }}" class="block pl-3 pr-4 py-3 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">
                Katalog
            </a>
             @auth
                <a href="{{ route('dashboard') }}" class="block pl-3 pr-4 py-3 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="block pl-3 pr-4 py-3 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">Log in</a>
            @endauth
        </div>
    </div>
</nav>
