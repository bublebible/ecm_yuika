<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Sewa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($asset)
                        <div class="mb-6 p-4 bg-gray-50 border rounded flex justify-between items-center">
                            <div>
                                <h3 class="font-bold text-lg">{{ $asset->name }}</h3>
                                <p class="text-indigo-600">Rp {{ number_format($asset->price_per_day, 0, ',', '.') }} / hari</p>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('user.rentals.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="asset_id" value="{{ $asset ? $asset->id : '' }}">
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Selesai</label>
                            <input type="date" name="end_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah</label>
                            <input type="number" name="qty" value="1" min="1" max="{{ $asset ? $asset->stock_qty : 10 }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Buat Pesanan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
