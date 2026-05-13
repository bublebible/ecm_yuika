<x-app-layout>
    <div class="min-h-screen bg-pink-100 font-sans text-gray-900 py-12 px-6 lg:px-12">
        <div class="max-w-7xl mx-auto bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col md:flex-row">
            <!-- Left Side: Image -->
            <div class="w-full md:w-1/2 relative bg-pink-50 h-[500px] md:h-auto">
                <img src="{{ Storage::url($asset->latestCondition->image ?? 'default.jpg') }}" alt="{{ $asset->name }}" class="absolute inset-0 w-full h-full object-cover">
            </div>

            <!-- Right Side: Details -->
            <div class="w-full md:w-1/2 p-10 md:p-16 flex flex-col justify-center">
                <div class="uppercase tracking-widest text-sm text-pink-500 font-bold mb-2">{{ $asset->category->name ?? 'Category' }}</div>
                <h1 class="text-5xl font-black text-gray-800 mb-4">{{ $asset->name }}</h1>
                <p class="text-3xl font-bold text-red-600 mb-6">Rp {{ number_format($asset->price_per_day, 0, ',', '.') }} <span class="text-lg text-gray-500">/ day</span></p>

                <p class="text-gray-600 text-lg mb-8 leading-relaxed">{{ $asset->description }}</p>

                <div class="bg-pink-50 rounded-xl p-6 mb-8 border border-pink-100 shadow-sm">
                    <h3 class="text-xl font-bold text-pink-600 mb-4 border-b border-pink-200 pb-2">Latest Condition</h3>
                    @if($asset->latestCondition)
                        <div class="flex flex-col sm:flex-row items-start gap-4">
                            @if($asset->latestCondition->image)
                                <img src="{{ Storage::url($asset->latestCondition->image) }}" class="w-32 h-32 rounded-lg object-cover shadow-sm border-2 border-white">
                            @endif
                            <div>
                                <p class="text-gray-800 font-bold mb-1">Status: <span class="text-pink-600 uppercase">{{ $asset->latestCondition->status }}</span></p>
                                <p class="text-gray-600 text-sm leading-relaxed mb-2">{{ $asset->latestCondition->notes }}</p>
                                <p class="text-gray-400 text-xs font-semibold">Updated on {{ $asset->latestCondition->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    @else
                        <p class="text-gray-500 italic">No condition records available yet.</p>
                    @endif
                </div>

                <div class="flex items-center gap-4">
                    <div class="font-bold text-lg text-gray-700 bg-gray-100 px-6 py-2 rounded-full">
                        Stock Available: <span class="text-pink-600">{{ $asset->stock_qty }}</span>
                    </div>
                </div>

                <div class="mt-8 flex gap-4">
                    @if($asset->stock_qty > 0)
                        <a href="{{ route('user.cart.add', $asset->id) }}" class="flex-1 bg-red-600 hover:bg-red-700 text-white text-center py-4 rounded-xl font-bold uppercase tracking-wider transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            Add to Cart
                        </a>
                    @else
                        <button disabled class="flex-1 bg-gray-400 text-white py-4 rounded-xl font-bold uppercase tracking-wider cursor-not-allowed">
                            Out of Stock
                        </button>
                    @endif
                    <a href="{{ route('user.catalog.index') }}" class="px-8 py-4 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-bold uppercase transition-all shadow-sm flex items-center justify-center">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
