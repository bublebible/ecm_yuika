<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Icons (FontAwesome) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Fallback Tailwind CDN (Instructions: Use build step for production, this is for dev reliability) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        blob: "blob 7s infinite",
                    },
                    keyframes: {
                        blob: {
                            "0%": { transform: "translate(0px, 0px) scale(1)" },
                            "33%": { transform: "translate(30px, -50px) scale(1.1)" },
                            "66%": { transform: "translate(-20px, 20px) scale(0.9)" },
                            "100%": { transform: "translate(0px, 0px) scale(1)" },
                        },
                    },
                },
            },
        }
    </script>
</head>
<body class="font-sans antialiased text-gray-900 bg-white">
    <!-- Navbar -->
    @include('components.navbar')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <!-- Footer -->
    @include('components.footer')

    <!-- Mobile Bottom Navigation (Public) -->
    <div class="sm:hidden fixed bottom-0 left-0 w-full z-50 bg-white border-t border-gray-200 safe-pb">
        <div class="grid grid-cols-5 h-16">
            <a href="{{ url('/') }}" class="flex flex-col items-center justify-center text-gray-500 hover:text-pink-600 {{ request()->is('/') ? 'text-pink-600' : '' }}">
                <i class="fas fa-home text-lg mb-1"></i>
                <span class="text-[10px] font-medium">Home</span>
            </a>
            <a href="{{ route('user.catalog.index') }}" class="flex flex-col items-center justify-center text-gray-500 hover:text-pink-600 {{ request()->routeIs('user.catalog.*') ? 'text-pink-600' : '' }}">
                <i class="fas fa-search text-lg mb-1"></i>
                <span class="text-[10px] font-medium">Explore</span>
            </a>
            <!-- Center FAB -->
            <div class="relative -top-5 flex justify-center">
                <a href="{{ route('user.cart.index') }}" class="h-14 w-14 flex items-center justify-center rounded-full bg-pink-600 shadow-lg text-white hover:bg-pink-700">
                     <i class="fas fa-shopping-bag text-xl"></i>
                </a>
            </div>
            <a href="{{ route('user.messages.index') }}" class="flex flex-col items-center justify-center text-gray-500 hover:text-pink-600 {{ request()->routeIs('user.messages.*') ? 'text-pink-600' : '' }}">
                <i class="far fa-comment-dots text-lg mb-1"></i>
                <span class="text-[10px] font-medium">Chat</span>
            </a>
            @auth
                <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center text-gray-500 hover:text-pink-600 {{ request()->routeIs('profile.*') ? 'text-pink-600' : '' }}">
                     <div class="h-6 w-6 rounded-full bg-gray-200 overflow-hidden mb-1">
                        <img src="{{ Auth::user()->avatarUrl() }}" alt="Profile" class="h-full w-full object-cover">
                     </div>
                    <span class="text-[10px] font-medium">Profile</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="flex flex-col items-center justify-center text-gray-500 hover:text-pink-600">
                    <i class="far fa-user text-lg mb-1"></i>
                    <span class="text-[10px] font-medium">Login</span>
                </a>
            @endauth
        </div>
    </div>
    
    <!-- Safe area for bottom nav -->
    <div class="h-20 sm:hidden"></div>
</body>
</html>
