<x-app-layout>
    <div class="pb-24 pt-4 sm:pt-12 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto px-4 sm:px-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">🛒 Keranjang Sewa</h2>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative mb-4">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-4">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if($cart && count($cart) > 0)
                <div class="space-y-4">
                    @php $pricePerDay = 0; @endphp
                    @foreach($cart as $id => $details)
                    @php $pricePerDay += $details['price'] * $details['quantity']; @endphp
                    <div class="bg-white p-4 rounded-xl shadow-sm flex gap-4 relative">
                        {{-- Remove --}}
                        <form action="{{ route('user.cart.remove') }}" method="POST" class="absolute top-2 right-2">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $id }}">
                            <button type="submit" class="text-gray-400 hover:text-red-500 transition">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>

                        {{-- Image --}}
                        <div class="h-20 w-20 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0">
                            @if($details['image'])
                                <img src="{{ Storage::url($details['image']) }}" class="object-cover w-full h-full">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400">
                                    <i class="fas fa-image text-2xl"></i>
                                </div>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="flex-1 pr-4">
                            <h4 class="font-bold text-gray-900">{{ $details['name'] }}</h4>
                            <p class="text-sm text-pink-600 font-semibold mt-1">
                                Rp {{ number_format($details['price'], 0, ',', '.') }} / hari
                            </p>
                            <p class="text-xs text-gray-500 mt-0.5">Qty: {{ $details['quantity'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- ===== DATE PICKER + SUMMARY ===== --}}
                <form action="{{ route('user.cart.checkout') }}" method="POST" id="checkoutForm">
                    @csrf

                    <div class="mt-6 bg-white p-6 rounded-xl shadow-sm space-y-4">
                        <h3 class="text-base font-bold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-calendar-alt text-pink-500"></i>
                            Pilih Tanggal Sewa
                        </h3>

                        {{-- Date inputs --}}
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                                    Mulai Sewa
                                </label>
                                <input
                                    type="date"
                                    name="start_date"
                                    id="startDate"
                                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition"
                                    min="{{ date('Y-m-d') }}"
                                    required
                                    onchange="calculateTotal()"
                                >
                                @error('start_date')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                                    Selesai Sewa
                                </label>
                                <input
                                    type="date"
                                    name="end_date"
                                    id="endDate"
                                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition"
                                    min="{{ date('Y-m-d') }}"
                                    required
                                    onchange="calculateTotal()"
                                >
                                @error('end_date')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Duration indicator --}}
                        <div id="durationBadge" class="hidden">
                            <div class="flex items-center gap-2 bg-pink-50 border border-pink-200 rounded-xl px-4 py-3">
                                <i class="fas fa-clock text-pink-500"></i>
                                <span class="text-sm font-semibold text-pink-700" id="durationText">—</span>
                            </div>
                        </div>

                        {{-- Date error --}}
                        <p id="dateError" class="hidden text-xs text-red-500 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            Tanggal selesai harus setelah tanggal mulai.
                        </p>
                    </div>

                    {{-- ===== ORDER SUMMARY ===== --}}
                    <div class="mt-4 bg-white p-6 rounded-xl shadow-sm">
                        <h3 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-receipt text-pink-500"></i>
                            Ringkasan Pesanan
                        </h3>

                        {{-- Item breakdown --}}
                        @foreach($cart as $id => $details)
                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                            <span>{{ $details['name'] }} × {{ $details['quantity'] }}</span>
                            <span>Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }} / hari</span>
                        </div>
                        @endforeach

                        <div class="border-t border-dashed border-gray-200 my-3"></div>

                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                            <span>Harga per hari</span>
                            <span id="pricePerDay">Rp {{ number_format($pricePerDay, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                            <span>Durasi</span>
                            <span id="daysCount" class="font-medium text-gray-800">—</span>
                        </div>

                        <div class="border-t border-gray-200 my-3"></div>

                        <div class="flex justify-between">
                            <span class="text-base font-bold">Total</span>
                            <span class="text-base font-bold text-pink-600" id="totalPrice">
                                Pilih tanggal terlebih dahulu
                            </span>
                        </div>

                        <button
                            type="submit"
                            id="checkoutBtn"
                            disabled
                            class="w-full mt-5 py-4 bg-pink-600 text-white font-bold rounded-xl shadow hover:bg-pink-700 transition disabled:opacity-40 disabled:cursor-not-allowed">
                            <i class="fas fa-shopping-bag mr-2"></i>
                            Checkout Sekarang
                        </button>
                        <p class="text-center text-xs text-gray-400 mt-2">
                            Pesanan akan menunggu konfirmasi admin
                        </p>
                    </div>
                </form>

            @else
                {{-- Empty State --}}
                <div class="text-center py-16">
                    <div class="h-24 w-24 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4 text-pink-500">
                        <i class="fas fa-shopping-basket fa-3x"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Keranjangmu kosong</h3>
                    <p class="text-gray-500 mt-2 mb-6">Belum ada kostum yang ditambahkan.</p>
                    <a href="{{ route('user.catalog.index') }}"
                       class="inline-block px-6 py-3 bg-pink-600 text-white font-bold rounded-full shadow hover:bg-pink-700 transition">
                        Jelajahi Kostum
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        const pricePerDay = {{ $pricePerDay ?? 0 }};

        function calculateTotal() {
            const startInput = document.getElementById('startDate');
            const endInput   = document.getElementById('endDate');
            const startVal   = startInput.value;
            const endVal     = endInput.value;

            const badge     = document.getElementById('durationBadge');
            const durationText = document.getElementById('durationText');
            const daysCount = document.getElementById('daysCount');
            const totalPrice = document.getElementById('totalPrice');
            const checkoutBtn = document.getElementById('checkoutBtn');
            const dateError = document.getElementById('dateError');

            // Ensure end_date min = start_date
            if (startVal) {
                endInput.min = startVal;
            }

            if (!startVal || !endVal) {
                badge.classList.add('hidden');
                dateError.classList.add('hidden');
                daysCount.textContent = '—';
                totalPrice.textContent = 'Pilih tanggal terlebih dahulu';
                checkoutBtn.disabled = true;
                return;
            }

            const start = new Date(startVal);
            const end   = new Date(endVal);
            const diffMs = end - start;
            const days  = Math.floor(diffMs / (1000 * 60 * 60 * 24)) + 1; // inclusive

            if (days < 1 || end < start) {
                badge.classList.add('hidden');
                dateError.classList.remove('hidden');
                daysCount.textContent = '—';
                totalPrice.textContent = '—';
                checkoutBtn.disabled = true;
                return;
            }

            dateError.classList.add('hidden');

            // Show duration badge
            badge.classList.remove('hidden');
            durationText.textContent = days + ' hari sewa (inklusif)';
            daysCount.textContent = days + ' hari';

            // Calculate total
            const total = pricePerDay * days;
            totalPrice.textContent = 'Rp ' + total.toLocaleString('id-ID');
            checkoutBtn.disabled = false;
        }

        // Trigger on load if values already filled (e.g. browser autofill)
        document.addEventListener('DOMContentLoaded', calculateTotal);
    </script>
</x-app-layout>
