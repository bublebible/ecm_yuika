<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight mb-6 px-4 sm:px-0">
                Riwayat Sewa
            </h2>

            <div x-data="{ tab: 'active' }">
                <!-- Tab Headers -->
                <div class="flex space-x-1 bg-white p-1 rounded-xl shadow-sm mb-6 mx-4 sm:mx-0 max-w-md">
                    <button @click="tab = 'active'" 
                        :class="{ 'bg-pink-100 text-pink-700 shadow-sm': tab === 'active', 'text-gray-500 hover:text-gray-700': tab !== 'active' }"
                        class="flex-1 py-2.5 px-4 rounded-lg text-sm font-medium transition-all duration-200">
                        Sedang Berjalan
                    </button>
                    <button @click="tab = 'past'" 
                        :class="{ 'bg-gray-100 text-gray-900 shadow-sm': tab === 'past', 'text-gray-500 hover:text-gray-700': tab !== 'past' }"
                        class="flex-1 py-2.5 px-4 rounded-lg text-sm font-medium transition-all duration-200">
                        Riwayat Selesai
                    </button>
                </div>

                <!-- Active Rentals -->
                <div x-show="tab === 'active'" class="space-y-4 px-4 sm:px-0">
                    @forelse($activeRentals as $rental)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg rounded-xl border border-gray-100 p-5">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $rental->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $rental->status === 'approved' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $rental->status === 'active' ? 'bg-green-100 text-green-800' : '' }}">
                                        {{ ucfirst($rental->status) }}
                                    </span>
                                    <p class="text-xs text-gray-500 mt-1">Order #{{ $rental->id }} • {{ $rental->created_at->format('d M Y') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-gray-900">Total: Rp {{ number_format($rental->total_price, 0, ',', '.') }}</p>
                                    <p class="text-xs text-red-500 font-medium mt-1">Kembali: {{ $rental->end_date->format('d M Y') }}</p>
                                    
                                    @if($rental->status === 'active')
                                        <form action="{{ route('user.rentals.return', $rental->id) }}" method="POST" class="mt-2 text-right" onsubmit="return confirm('Apakah Anda yakin sudah mengembalikan kostum ini?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bg-indigo-600 text-white text-xs px-3 py-1.5 rounded-full hover:bg-indigo-700 transition shadow-sm">
                                                <i class="fas fa-undo-alt mr-1"></i> Kembalikan
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            <div class="border-t border-gray-100 pt-4">
                                @foreach($rental->items as $item)
                                    <div class="flex items-center space-x-4 mb-3 last:mb-0">
                                        <div class="flex-shrink-0 h-16 w-16 bg-gray-100 rounded-lg overflow-hidden">
                                            @if($item->asset->latestCondition && $item->asset->latestCondition->image)
                                                <img src="{{ Storage::url($item->asset->latestCondition->image) }}" class="h-full w-full object-cover">
                                            @else
                                                <div class="h-full w-full flex items-center justify-center text-gray-400">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                {{ $item->asset->name }}
                                            </p>
                                            <p class="text-xs text-gray-500 truncate">
                                                {{ $item->asset->category->name ?? 'Costume' }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-white rounded-xl shadow-sm">
                            <i class="fas fa-box-open text-gray-300 text-4xl mb-3"></i>
                            <p class="text-gray-500">Belum ada penyewaan aktif.</p>
                            <a href="{{ route('user.catalog.index') }}" class="text-pink-600 font-bold text-sm mt-2 inline-block">Mulai Menyewa &rarr;</a>
                        </div>
                    @endforelse
                </div>

                <!-- Past Rentals -->
                <div x-show="tab === 'past'" class="space-y-4 px-4 sm:px-0" style="display: none;">
                    @forelse($pastRentals as $rental)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg rounded-xl border border-gray-100 p-5 opacity-75 hover:opacity-100 transition">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $rental->status === 'returned' ? 'bg-gray-100 text-gray-800' : '' }}
                                        {{ $rental->status === 'completed' ? 'bg-gray-100 text-gray-800' : '' }}
                                        {{ $rental->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($rental->status) }}
                                    </span>
                                    <p class="text-xs text-gray-500 mt-1">Order #{{ $rental->id }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-gray-900">Total: Rp {{ number_format($rental->total_price, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            <div class="border-t border-gray-100 pt-4">
                                @foreach($rental->items as $item)
                                    <div class="flex items-center space-x-4 mb-3 last:mb-0">
                                        <div class="flex-shrink-0 h-12 w-12 bg-gray-100 rounded-lg overflow-hidden grayscale">
                                            @if($item->asset->latestCondition && $item->asset->latestCondition->image)
                                                <img src="{{ Storage::url($item->asset->latestCondition->image) }}" class="h-full w-full object-cover">
                                            @else
                                                <div class="h-full w-full flex items-center justify-center text-gray-400">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-700 truncate">
                                                {{ $item->asset->name }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                         <div class="text-center py-12 bg-white rounded-xl shadow-sm">
                            <p class="text-gray-500">Belum ada riwayat penyewaan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
