<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Icons (FontAwesome) -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <!-- Fallback Tailwind CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        animation: {
                            blob: "blob 7s infinite",
                            'bounce-in': "bounceIn 0.4s ease both",
                            'slide-up': "slideUp 0.35s ease both",
                        },
                        keyframes: {
                            blob: {
                                "0%":   { transform: "translate(0px, 0px) scale(1)" },
                                "33%":  { transform: "translate(30px, -50px) scale(1.1)" },
                                "66%":  { transform: "translate(-20px, 20px) scale(0.9)" },
                                "100%": { transform: "translate(0px, 0px) scale(1)" },
                            },
                            bounceIn: {
                                "0%":   { transform: "scale(0)"; opacity: "0" },
                                "60%":  { transform: "scale(1.2)" },
                                "100%": { transform: "scale(1)"; opacity: "1" },
                            },
                            slideUp: {
                                "from": { opacity: "0"; transform: "translateY(20px)" },
                                "to":   { opacity: "1"; transform: "translateY(0)" },
                            },
                        },
                    },
                },
            }
        </script>

        <style>
            @keyframes bounceIn {
                0%   { transform: scale(0); opacity: 0; }
                60%  { transform: scale(1.25); }
                100% { transform: scale(1); opacity: 1; }
            }
            @keyframes slideUp {
                from { opacity: 0; transform: translateY(20px); }
                to   { opacity: 1; transform: translateY(0); }
            }
            @keyframes slideDown {
                from { opacity: 1; transform: translateY(0); }
                to   { opacity: 0; transform: translateY(-20px); }
            }
            .badge-bounce { animation: bounceIn 0.4s ease both; }
            .toast-enter  { animation: slideUp 0.35s ease both; }
            .toast-leave  { animation: slideDown 0.3s ease forwards; }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <!-- Top Desktop Navigation -->
            <div class="hidden sm:block">
                @include('components.navbar')
            </div>
            
            <!-- Navbar Spacer -->
            <div class="hidden sm:block h-20"></div>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <!-- ===== MOBILE BOTTOM NAVIGATION (5 tabs) ===== -->
            <div class="sm:hidden fixed bottom-0 left-0 w-full z-50 bg-white border-t border-gray-100 shadow-[0_-2px_10px_rgba(0,0,0,0.06)]">
                <div class="grid grid-cols-5 h-16">

                    {{-- Home --}}
                    <a href="{{ route('dashboard') }}"
                       class="flex flex-col items-center justify-center gap-0.5 transition-colors
                              {{ request()->routeIs('dashboard') ? 'text-pink-600' : 'text-gray-400 hover:text-pink-500' }}">
                        <i class="fas fa-home text-xl"></i>
                        <span class="text-[9px] font-semibold tracking-wide">Home</span>
                    </a>

                    {{-- Explore --}}
                    <a href="{{ route('user.catalog.index') }}"
                       class="flex flex-col items-center justify-center gap-0.5 transition-colors
                              {{ request()->routeIs('user.catalog.*') ? 'text-pink-600' : 'text-gray-400 hover:text-pink-500' }}">
                        <i class="fas fa-search text-xl"></i>
                        <span class="text-[9px] font-semibold tracking-wide">Explore</span>
                    </a>

                    {{-- Center FAB — Cart with badge --}}
                    <div class="relative -top-5 flex justify-center">
                        <a href="{{ route('user.cart.index') }}"
                           class="relative h-14 w-14 flex items-center justify-center rounded-full bg-pink-600 shadow-lg text-white hover:bg-pink-700 transition">
                            <i class="fas fa-shopping-bag text-xl"></i>
                            {{-- Cart count badge --}}
                            @php
                                $cart = Session::get('cart');
                                $cartCount = is_array($cart) ? count($cart) : 0;
                            @endphp
                            @if($cartCount > 0)
                                <span id="cartBadgeMobile"
                                      class="absolute -top-1 -right-1 h-5 w-5 flex items-center justify-center rounded-full bg-yellow-400 text-gray-900 text-[10px] font-extrabold ring-2 ring-white badge-bounce">
                                    {{ $cartCount > 9 ? '9+' : $cartCount }}
                                </span>
                            @endif
                        </a>
                    </div>

                    {{-- Chat with unread badge --}}
                    <a href="{{ route('user.messages.index') }}"
                       class="flex flex-col items-center justify-center gap-0.5 transition-colors relative
                              {{ request()->routeIs('user.messages.*') ? 'text-pink-600' : 'text-gray-400 hover:text-pink-500' }}">
                        <div class="relative">
                            <i class="far fa-comment-dots text-xl"></i>
                            <span id="msgBadgeMobile"
                                  class="absolute -top-1.5 -right-2 h-4.5 min-w-[18px] px-1 flex items-center justify-center rounded-full bg-red-500 text-white text-[9px] font-extrabold ring-1 ring-white hidden">
                                0
                            </span>
                        </div>
                        <span class="text-[9px] font-semibold tracking-wide">Chat</span>
                    </a>

                    {{-- Profile --}}
                    @auth
                    <a href="{{ route('profile.edit') }}"
                       class="flex flex-col items-center justify-center gap-0.5 transition-colors
                              {{ request()->routeIs('profile.*') ? 'text-pink-600' : 'text-gray-400 hover:text-pink-500' }}">
                        <div class="h-7 w-7 rounded-full overflow-hidden ring-2 {{ request()->routeIs('profile.*') ? 'ring-pink-500' : 'ring-gray-200' }}">
                            <img src="{{ Auth::user()->avatarUrl() }}" alt="Profile" class="h-full w-full object-cover">
                        </div>
                        <span class="text-[9px] font-semibold tracking-wide">Profil</span>
                    </a>
                    @else
                    <a href="{{ route('login') }}"
                       class="flex flex-col items-center justify-center gap-0.5 text-gray-400 hover:text-pink-500 transition-colors">
                        <i class="fas fa-sign-in-alt text-xl"></i>
                        <span class="text-[9px] font-semibold tracking-wide">Login</span>
                    </a>
                    @endauth

                </div>
            </div>
            
            <!-- Safe area for bottom nav -->
            <div class="h-20 sm:hidden"></div>

            <!-- Desktop Floating Chat Button with badge -->
            @auth
            <div class="hidden sm:flex fixed bottom-8 right-8 z-50">
                <a href="{{ route('user.messages.index') }}"
                   class="relative flex items-center justify-center h-14 w-14 rounded-full bg-pink-600 text-white shadow-lg hover:bg-pink-700 transition transform hover:scale-110 hover:-translate-y-1">
                    <i class="far fa-comment-dots text-2xl"></i>
                    <span id="msgBadgeDesktop"
                          class="absolute -top-1 -right-1 h-5 min-w-[20px] px-1 flex items-center justify-center rounded-full bg-red-500 text-white text-[10px] font-extrabold ring-2 ring-white hidden">
                        0
                    </span>
                </a>
            </div>
            @endauth
        </div>

        {{-- ===== TOAST NOTIFICATION ===== --}}
        @auth
        <div id="msgToast"
             class="fixed top-5 right-5 z-[9999] max-w-xs w-full hidden">
            <div class="bg-white rounded-2xl shadow-2xl border border-pink-100 overflow-hidden toast-enter">
                <div class="flex items-start gap-3 p-4">
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-gradient-to-br from-pink-500 to-purple-600 flex items-center justify-center shadow">
                        <i class="fas fa-comment-dots text-white text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-gray-800">Pesan Baru! 💬</p>
                        <p id="toastText" class="text-xs text-gray-500 mt-0.5 truncate">Admin mengirim pesan baru</p>
                    </div>
                    <button onclick="dismissToast()" class="text-gray-300 hover:text-gray-500 transition flex-shrink-0">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>
                <a href="{{ route('user.messages.index') }}"
                   class="block w-full text-center text-xs font-bold text-pink-600 py-2.5 bg-pink-50 hover:bg-pink-100 transition border-t border-pink-100">
                    Lihat Percakapan →
                </a>
            </div>
        </div>

        <script>
            // ─── State ────────────────────────────────────────────────────
            let lastUnreadCount = null;
            let toastTimeout    = null;
            const isOnChatPage  = {{ request()->routeIs('user.messages.*') ? 'true' : 'false' }};

            // ─── Update badge elements ────────────────────────────────────
            function updateBadges(count) {
                ['msgBadgeMobile', 'msgBadgeDesktop'].forEach(id => {
                    const el = document.getElementById(id);
                    if (!el) return;
                    if (count > 0) {
                        el.textContent = count > 99 ? '99+' : count;
                        el.classList.remove('hidden');
                        el.classList.add('badge-bounce');
                    } else {
                        el.classList.add('hidden');
                        el.classList.remove('badge-bounce');
                    }
                });
            }

            // ─── Show toast popup ─────────────────────────────────────────
            function showToast(count, latestMsg) {
                if (isOnChatPage) return; // sudah di halaman chat, jangan popup
                const toast = document.getElementById('msgToast');
                const text  = document.getElementById('toastText');
                if (latestMsg) {
                    text.innerHTML = `<strong>${latestMsg.sender_name}:</strong> ${latestMsg.message}`;
                } else {
                    text.textContent = count > 1
                        ? `Kamu punya ${count} pesan belum dibaca`
                        : 'Admin mengirim pesan baru';
                }
                toast.classList.remove('hidden');
                // Auto dismiss after 5 seconds
                clearTimeout(toastTimeout);
                toastTimeout = setTimeout(dismissToast, 5000);
            }

            function dismissToast() {
                const toast = document.getElementById('msgToast');
                toast.classList.add('hidden');
            }

            // ─── Poll for unread messages every 8 seconds ─────────────────
            async function pollUnread() {
                try {
                    const res  = await fetch('{{ route('user.messages.unread') }}', {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const data = await res.json();
                    const count = data.count ?? 0;

                    updateBadges(count);

                    // Only show toast when count increases
                    if (lastUnreadCount !== null && count > lastUnreadCount) {
                        showToast(count, data.latest);
                    }
                    lastUnreadCount = count;
                } catch (e) {
                    // silent fail
                }
            }

            // Start polling
            pollUnread();
            setInterval(pollUnread, 8000);
        </script>
        @endauth

    </body>
</html>
