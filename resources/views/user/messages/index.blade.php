<x-app-layout>
    <div class="pb-24 pt-4 sm:pt-12 bg-white min-h-screen">
        <div class="max-w-2xl mx-auto">
            <div class="px-4 mb-4">
                <h2 class="text-2xl font-bold text-gray-900">Messages</h2>
            </div>
            
            <div class="divide-y divide-gray-100">
                <!-- Message Item -->
                <div class="flex items-center gap-4 p-4 hover:bg-gray-50 transition cursor-pointer">
                    <div class="relative">
                        <div class="h-12 w-12 bg-pink-100 rounded-full flex items-center justify-center text-pink-600 font-bold text-lg">
                            Y
                        </div>
                        <span class="absolute bottom-0 right-0 h-3 w-3 bg-green-500 border-2 border-white rounded-full"></span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-baseline">
                            <h3 class="font-bold text-gray-900 truncate">Yuika Rentcos Admin</h3>
                            <span class="text-xs text-gray-500">10:30 AM</span>
                        </div>
                        <p class="text-sm text-gray-500 truncate">Selamat pagi! Kostum pesanan kak sudah bisa diambil ya...</p>
                    </div>
                </div>

                <!-- Message Item -->
                 <div class="flex items-center gap-4 p-4 hover:bg-gray-50 transition cursor-pointer">
                    <div class="h-12 w-12 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 font-bold text-lg">
                        S
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-baseline">
                            <h3 class="font-bold text-gray-900 truncate">System Notification</h3>
                            <span class="text-xs text-gray-500">Yesterday</span>
                        </div>
                        <p class="text-sm text-gray-500 truncate">Rental #4459 has been completed. Don't forget to review!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
