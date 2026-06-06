<footer class="bg-gray-800 text-white">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Logo & About -->
            <div class="col-span-1">
                <span class="text-2xl font-bold text-pink-500">Yuika Rentcoss</span>
                <p class="mt-4 text-gray-300 text-sm">
                    Platform penyewaan kostum cosplay terlengkap dan terpercaya. Wujudkan karakter impianmu dengan mudah dan aman.
                </p>
                <!-- Social Icons -->
                <div class="flex space-x-4 mt-6">
                    <a href="#" class="text-gray-400 hover:text-white">
                        <span class="sr-only">Facebook</span>
                        <div class="h-6 w-6 bg-gray-600 rounded-full"></div> <!-- Placeholder Icon -->
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                         <span class="sr-only">Instagram</span>
                        <div class="h-6 w-6 bg-gray-600 rounded-full"></div> <!-- Placeholder Icon -->
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                         <span class="sr-only">Twitter</span>
                        <div class="h-6 w-6 bg-gray-600 rounded-full"></div> <!-- Placeholder Icon -->
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-sm font-semibold tracking-wider uppercase text-pink-400">Navigasi</h3>
                <ul class="mt-4 space-y-4">
                    <li>
                        <a href="{{ url('/') }}" class="text-base text-gray-300 hover:text-white">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.catalog.index') }}" class="text-base text-gray-300 hover:text-white">
                            Katalog Kostum
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-base text-gray-300 hover:text-white">
                            Tentang Kami
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-base text-gray-300 hover:text-white">
                            Syarat & Ketentuan
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h3 class="text-sm font-semibold tracking-wider uppercase text-pink-400">Hubungi Kami</h3>
                <ul class="mt-4 space-y-4">
                    <li class="flex items-start">
                        <div class="flex-shrink-0">
                            <!-- Phone Icon Placeholder -->
                            <div class="h-5 w-5 bg-gray-600 rounded-full mt-1"></div>
                        </div>
                        <div class="ml-3">
                            <p class="text-base text-gray-300">
                                +62 812 3456 7890
                            </p>
                            <p class="text-sm text-gray-400">Senin - Jumat, 09:00 - 17:00</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0">
                             <!-- Mail Icon Placeholder -->
                             <div class="h-5 w-5 bg-gray-600 rounded-full mt-1"></div>
                        </div>
                        <div class="ml-3">
                            <p class="text-base text-gray-300">
                                support@yuikarentcoss.com
                            </p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0">
                             <!-- Location Icon Placeholder -->
                             <div class="h-5 w-5 bg-gray-600 rounded-full mt-1"></div>
                        </div>
                        <div class="ml-3">
                            <p class="text-base text-gray-300">
                                Jl. Anime Raya No. 1, Jakarta
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="mt-8 border-t border-gray-700 pt-8">
            <p class="text-base text-gray-400 xl:text-center">
                &copy; {{ date('Y') }} Yuika Rentcoss. All rights reserved.
            </p>
        </div>
    </div>
</footer>
