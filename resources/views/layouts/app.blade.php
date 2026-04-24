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
        
        <!-- Fallback Tailwind CDN (For dev environment without npm run dev) -->
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
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <!-- Top Desktop Navigation (Replaces Standard Breeze Nav) -->
            <div class="hidden sm:block">
                @include('components.navbar')
            </div>
            
            <!-- Navbar Spacer since Custom Navbar is Fixed -->
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
            <!-- Mobile Bottom Navigation -->
            <div class="sm:hidden fixed bottom-0 left-0 w-full z-50 bg-white border-t border-gray-200 safe-pb">
                <div class="grid grid-cols-5 h-16">
                    <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center text-gray-500 hover:text-pink-600 {{ request()->routeIs('dashboard') ? 'text-pink-600' : '' }}">
                        <i class="fas fa-home text-lg mb-1"></i>
                        <span class="text-[10px] font-medium">Home</span>
                    </a>
                    <a href="{{ route('user.catalog.index') }}" class="flex flex-col items-center justify-center text-gray-500 hover:text-pink-600 {{ request()->routeIs('user.catalog.*') ? 'text-pink-600' : '' }}">
                        <i class="fas fa-search text-lg mb-1"></i>
                        <span class="text-[10px] font-medium">Explore</span>
                    </a>
                    <!-- Center FAB (Messages for now, or Scan) -->
                    <div class="relative -top-5 flex justify-center">
                        <a href="{{ route('user.cart.index') }}" class="h-14 w-14 flex items-center justify-center rounded-full bg-pink-600 shadow-lg text-white hover:bg-pink-700">
                             <i class="fas fa-shopping-bag text-xl"></i>
                        </a>
                    </div>
                    <a href="{{ route('user.history.index') }}" class="flex flex-col items-center justify-center text-gray-500 hover:text-pink-600 {{ request()->routeIs('user.history.index') ? 'text-pink-600' : '' }}">
                        <i class="fas fa-history text-lg mb-1"></i>
                        <span class="text-[10px] font-medium">History</span>
                    </a>
                    @auth
                    <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center text-gray-500 hover:text-pink-600 {{ request()->routeIs('profile.*') ? 'text-pink-600' : '' }}">
                         <div class="h-6 w-6 rounded-full bg-gray-200 overflow-hidden mb-1">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" alt="Profile" class="h-full w-full object-cover">
                         </div>
                        <span class="text-[10px] font-medium">Profile</span>
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="flex flex-col items-center justify-center text-gray-500 hover:text-pink-600">
                         <div class="h-6 w-6 rounded-full bg-gray-200 overflow-hidden mb-1 flex items-center justify-center">
                            <i class="fas fa-user text-xs text-gray-500"></i>
                         </div>
                        <span class="text-[10px] font-medium">Login</span>
                    </a>
                    @endauth
                </div>
            </div>
            
            <!-- Safe area for bottom nav -->
            <div class="h-20 sm:hidden"></div> 
            <!-- Desktop Floating Chat Button -->
            <div class="hidden sm:flex fixed bottom-8 right-8 z-50">
                <a href="{{ route('user.messages.index') }}" class="flex items-center justify-center h-14 w-14 rounded-full bg-pink-600 text-white shadow-lg hover:bg-pink-700 transition transform hover:scale-110 hover:-translate-y-1">
                    <i class="far fa-comment-dots text-2xl"></i>
                </a>
            </div>
            
        </div>
    </body>
</html>
