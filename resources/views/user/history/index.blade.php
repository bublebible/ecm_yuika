<x-app-layout>
    <div class="py-8 sm:py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6">

            {{-- Header --}}
            <div class="flex items-center gap-3 mb-6">
                <div class="w-1.5 h-8 bg-pink-600 rounded-full"></div>
                <h2 class="font-bold text-2xl text-gray-800">Pesanan Saya</h2>
            </div>

            {{-- Flash messages --}}
            @if(session('success'))
                <div class="bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded-xl mb-5 flex items-center gap-2">
                    <i class="fas fa-check-circle text-green-500"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-xl mb-5 flex items-center gap-2">
                    <i class="fas fa-exclamation-circle text-red-400"></i>
                    {{ session('error') }}
                </div>
            @endif

            <div x-data="{ tab: 'active' }">
                {{-- Tab Headers --}}
                <div class="flex space-x-1 bg-white p-1 rounded-xl shadow-sm mb-6 max-w-xs">
                    <button @click="tab = 'active'"
                        :class="{ 'bg-pink-500 text-white shadow': tab === 'active', 'text-gray-500 hover:text-gray-700': tab !== 'active' }"
                        class="flex-1 py-2.5 px-4 rounded-lg text-sm font-semibold transition-all duration-200 flex items-center justify-center gap-1.5">
                        <i class="fas fa-clock text-xs"></i> Aktif
                        @if($activeRentals->count() > 0)
                            <span class="bg-white/30 text-current text-[10px] font-bold px-1.5 py-0.5 rounded-full ml-1"
                                  :class="{ 'bg-white/30': tab === 'active', 'bg-pink-100 text-pink-600': tab !== 'active' }">
                                {{ $activeRentals->count() }}
                            </span>
                        @endif
                    </button>
                    <button @click="tab = 'past'"
                        :class="{ 'bg-gray-800 text-white shadow': tab === 'past', 'text-gray-500 hover:text-gray-700': tab !== 'past' }"
                        class="flex-1 py-2.5 px-4 rounded-lg text-sm font-semibold transition-all duration-200 flex items-center justify-center gap-1.5">
                        <i class="fas fa-history text-xs"></i> Riwayat
                    </button>
                </div>

                {{-- ===== ACTIVE RENTALS ===== --}}
                <div x-show="tab === 'active'" class="space-y-4">
                    @forelse($activeRentals as $rental)
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                            {{-- Card Header --}}
                            <div class="flex justify-between items-center px-5 py-3 bg-gray-50 border-b border-gray-100">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">#{{ $rental->id }}</span>
                                    <span class="text-xs text-gray-400">•</span>
                                    <span class="text-xs text-gray-500">{{ $rental->created_at->format('d M Y') }}</span>
                                </div>
                                @php
                                    $badge = match($rental->status) {
                                        'pending'  => ['Menunggu Konfirmasi', 'bg-yellow-100 text-yellow-700'],
                                        'approved' => ['Disetujui', 'bg-blue-100 text-blue-700'],
                                        'active'   => ['Sedang Dipinjam', 'bg-green-100 text-green-700'],
                                        default    => [ucfirst($rental->status), 'bg-gray-100 text-gray-700'],
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge[1] }}">
                                    {{ $badge[0] }}
                                </span>
                            </div>

                            {{-- Items --}}
                            <div class="px-5 py-4 space-y-3">
                                @foreach($rental->items as $item)
                                    <div class="flex items-center gap-3">
                                        <div class="flex-shrink-0 h-14 w-14 bg-gray-100 rounded-xl overflow-hidden">
                                            @if($item->asset->latestCondition && $item->asset->latestCondition->image)
                                                <img src="{{ Storage::url($item->asset->latestCondition->image) }}" class="h-full w-full object-cover">
                                            @else
                                                <div class="h-full w-full flex items-center justify-center text-gray-300">
                                                    <i class="fas fa-tshirt text-xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $item->asset->name }}</p>
                                            <p class="text-xs text-gray-400">{{ $item->asset->category->name ?? 'Kostum' }} • Qty {{ $item->qty }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Footer: dates + total + actions --}}
                            <div class="px-5 py-3 bg-gray-50 border-t border-gray-100 flex flex-wrap items-center justify-between gap-3">
                                <div>
                                    <p class="text-xs text-gray-500">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        {{ $rental->start_date->format('d M') }} – {{ $rental->end_date->format('d M Y') }}
                                    </p>
                                    <p class="text-sm font-bold text-gray-800 mt-0.5">
                                        Rp {{ number_format($rental->total_price, 0, ',', '.') }}
                                    </p>
                                </div>

                                {{-- Action buttons --}}
                                <div class="flex flex-wrap gap-2">
                                    @if($rental->status === 'pending')
                                        {{-- Upload KTP --}}
                                        <a href="{{ route('user.rentals.edit', $rental) }}"
                                           class="inline-flex items-center gap-1.5 text-xs font-semibold bg-blue-600 text-white px-3 py-1.5 rounded-lg hover:bg-blue-700 transition">
                                            <i class="fas fa-id-card"></i> Upload KTP
                                        </a>
                                        {{-- Batal (pending) --}}
                                        <form action="{{ route('payment.cancel', $rental) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin membatalkan pesanan ini? Stok akan dikembalikan.')">
                                            @csrf
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1.5 text-xs font-semibold bg-red-100 text-red-600 px-3 py-1.5 rounded-lg hover:bg-red-200 transition">
                                                <i class="fas fa-times-circle"></i> Batal
                                            </button>
                                        </form>

                                    @elseif($rental->status === 'approved')
                                        {{-- BAYAR SEKARANG (Midtrans Snap) --}}
                                        @if($rental->payment_status !== 'paid')
                                            <button type="button"
                                                    onclick="bayarSekarang({{ $rental->id }}, '{{ $rental->snap_token }}')"
                                                    data-rental-id="{{ $rental->id }}"
                                                    class="pay-btn inline-flex items-center gap-1.5 text-xs font-bold bg-gradient-to-r from-green-500 to-emerald-600 text-white px-4 py-1.5 rounded-lg hover:from-green-600 hover:to-emerald-700 transition shadow-sm">
                                                <i class="fas fa-wallet"></i> Bayar Sekarang
                                            </button>
                                        @else
                                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-700 bg-emerald-100 px-3 py-1.5 rounded-lg">
                                                <i class="fas fa-check-circle"></i> Lunas
                                            </span>
                                        @endif

                                        {{-- Download Kontrak --}}
                                        <a href="{{ route('user.rentals.contract', $rental) }}"
                                           class="inline-flex items-center gap-1.5 text-xs font-semibold bg-indigo-600 text-white px-3 py-1.5 rounded-lg hover:bg-indigo-700 transition">
                                            <i class="fas fa-file-pdf"></i> Kontrak
                                        </a>

                                        {{-- Batal (approved & belum bayar) --}}
                                        @if($rental->payment_status !== 'paid')
                                            <form action="{{ route('payment.cancel', $rental) }}" method="POST"
                                                  onsubmit="return confirm('Yakin ingin membatalkan? Pesanan yang dibatalkan tidak bisa dikembalikan.')">
                                                @csrf
                                                <button type="submit"
                                                        class="inline-flex items-center gap-1.5 text-xs font-semibold bg-red-100 text-red-600 px-3 py-1.5 rounded-lg hover:bg-red-200 transition">
                                                    <i class="fas fa-times-circle"></i> Batal
                                                </button>
                                            </form>
                                        @endif

                                    @elseif($rental->status === 'active')
                                        {{-- Kontrak & Kembalikan --}}
                                        <a href="{{ route('user.rentals.contract', $rental) }}"
                                           class="inline-flex items-center gap-1.5 text-xs font-semibold bg-indigo-600 text-white px-3 py-1.5 rounded-lg hover:bg-indigo-700 transition">
                                            <i class="fas fa-file-pdf"></i> Kontrak
                                        </a>
                                        <form action="{{ route('user.rentals.return', $rental->id) }}" method="POST"
                                              onsubmit="return confirm('Yakin sudah mengembalikan kostum?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1.5 text-xs font-semibold bg-orange-500 text-white px-3 py-1.5 rounded-lg hover:bg-orange-600 transition">
                                                <i class="fas fa-undo-alt"></i> Kembalikan
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-100">
                            <i class="fas fa-box-open text-gray-200 text-5xl mb-3 block"></i>
                            <p class="text-gray-500 font-medium">Belum ada pesanan aktif.</p>
                            <a href="{{ route('user.catalog.index') }}"
                               class="inline-block mt-4 px-5 py-2 bg-pink-600 text-white text-sm font-bold rounded-full hover:bg-pink-700 transition">
                                Mulai Menyewa →
                            </a>
                        </div>
                    @endforelse
                </div>

                {{-- ===== PAST RENTALS ===== --}}
                <div x-show="tab === 'past'" class="space-y-4" style="display:none;">
                    @forelse($pastRentals as $rental)
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                            {{-- Card Header --}}
                            <div class="flex justify-between items-center px-5 py-3 bg-gray-50 border-b border-gray-100">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">#{{ $rental->id }}</span>
                                    <span class="text-xs text-gray-400">•</span>
                                    <span class="text-xs text-gray-500">{{ $rental->created_at->format('d M Y') }}</span>
                                </div>
                                @php
                                    $badge = match($rental->status) {
                                        'returned'  => ['Dikembalikan', 'bg-orange-100 text-orange-700'],
                                        'completed' => ['Selesai ✓', 'bg-emerald-100 text-emerald-700'],
                                        'cancelled' => ['Dibatalkan', 'bg-red-100 text-red-700'],
                                        default     => [ucfirst($rental->status), 'bg-gray-100 text-gray-600'],
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge[1] }}">
                                    {{ $badge[0] }}
                                </span>
                            </div>

                            {{-- Items (grayscale for past) --}}
                            <div class="px-5 py-4 space-y-3">
                                @foreach($rental->items as $item)
                                    <div class="flex items-center gap-3">
                                        <div class="flex-shrink-0 h-12 w-12 bg-gray-100 rounded-xl overflow-hidden grayscale opacity-75">
                                            @if($item->asset->latestCondition && $item->asset->latestCondition->image)
                                                <img src="{{ Storage::url($item->asset->latestCondition->image) }}" class="h-full w-full object-cover">
                                            @else
                                                <div class="h-full w-full flex items-center justify-center text-gray-300">
                                                    <i class="fas fa-tshirt"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-700 truncate">{{ $item->asset->name }}</p>
                                            <p class="text-xs text-gray-400">Qty {{ $item->qty }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Footer: total + testimoni --}}
                            <div class="px-5 py-3 bg-gray-50 border-t border-gray-100 flex flex-wrap items-center justify-between gap-3">
                                <div>
                                    <p class="text-xs text-gray-500">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        {{ $rental->start_date->format('d M') }} – {{ $rental->end_date->format('d M Y') }}
                                    </p>
                                    <p class="text-sm font-bold text-gray-700 mt-0.5">
                                        Rp {{ number_format($rental->total_price, 0, ',', '.') }}
                                    </p>
                                </div>

                                {{-- Testimonial button (only for completed without existing testimonial) --}}
                                @if($rental->status === 'completed')
                                    @if(!$rental->testimonial)
                                        <button type="button"
                                                onclick="openTestimonialModal({{ $rental->id }})"
                                                class="inline-flex items-center gap-1.5 text-xs font-semibold bg-gradient-to-r from-pink-500 to-purple-600 text-white px-3 py-1.5 rounded-lg hover:from-pink-600 hover:to-purple-700 transition shadow-sm">
                                            <i class="fas fa-star"></i> Beri Ulasan
                                        </button>
                                    @else
                                        <div class="flex items-center gap-1 text-xs text-emerald-600 font-medium">
                                            @for($s = 1; $s <= $rental->testimonial->rating; $s++)
                                                <i class="fas fa-star text-yellow-400 text-[10px]"></i>
                                            @endfor
                                            <span class="ml-1">Sudah diulas</span>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-100">
                            <i class="fas fa-history text-gray-200 text-5xl mb-3 block"></i>
                            <p class="text-gray-500 font-medium">Belum ada riwayat penyewaan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- ===== TESTIMONIAL MODAL ===== --}}
    <div id="testimonialModal"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm hidden"
         onclick="if(event.target===this) closeTestimonialModal()">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 p-6 relative">
            <button onclick="closeTestimonialModal()"
                    class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-xl transition">
                <i class="fas fa-times"></i>
            </button>

            <div class="text-center mb-5">
                <div class="w-14 h-14 bg-gradient-to-br from-pink-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-lg">
                    <i class="fas fa-star text-white text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Bagaimana pengalamanmu?</h3>
                <p class="text-sm text-gray-500 mt-1">Bantu cosplayer lain dengan ulasanmu 🎉</p>
            </div>

            <form method="POST" action="{{ route('testimonials.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="rental_id" id="testimonialRentalId">

                {{-- Star Rating --}}
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Rating</label>
                    <div class="flex gap-2" id="starRating">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" data-star="{{ $i }}" onclick="setRating({{ $i }})"
                                    class="star-btn text-3xl text-gray-300 hover:text-yellow-400 transition-colors cursor-pointer leading-none">
                                ★
                            </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="ratingInput" value="5">
                </div>

                {{-- Comment --}}
                <div class="mb-5">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Komentar</label>
                    <textarea
                        name="comment"
                        rows="4"
                        placeholder="Ceritakan pengalamanmu menyewa kostum di sini..."
                        class="w-full border border-gray-200 rounded-xl p-3 text-sm text-gray-700 resize-none focus:outline-none focus:ring-2 focus:ring-pink-400 transition"
                        required minlength="5" maxlength="1000"
                    ></textarea>
                </div>

                {{-- Image Upload --}}
                <div class="mb-5">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Foto Review (Opsional)</label>
                    <div class="flex items-center justify-center w-full">
                        <label class="flex flex-col items-center justify-center w-full h-24 border-2 border-gray-200 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                            <div class="flex flex-col items-center justify-center pt-2 pb-3">
                                <i class="fas fa-camera text-gray-400 text-lg mb-1"></i>
                                <p class="text-[11px] text-gray-500"><span class="font-semibold">Klik untuk unggah</span> foto kostum</p>
                                <p class="text-[9px] text-gray-400">PNG, JPG, JPEG (Max. 2MB)</p>
                            </div>
                            <input type="file" name="image" accept="image/*" class="hidden" onchange="previewImage(event)">
                        </label>
                    </div>
                    <div id="imagePreviewContainer" class="mt-3 hidden">
                        <p class="text-[10px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Pratinjau Foto:</p>
                        <div class="relative inline-block">
                            <img id="imagePreview" src="#" alt="Pratinjau" class="h-16 w-auto rounded-lg object-cover border border-gray-200">
                            <button type="button" onclick="removeImagePreview()" class="absolute -top-1.5 -right-1.5 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-[10px] hover:bg-red-600 transition shadow">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit"
                        class="w-full py-3 bg-gradient-to-r from-pink-500 to-purple-600 text-white font-bold rounded-xl text-sm hover:from-pink-600 hover:to-purple-700 transition shadow-lg">
                    <i class="fas fa-paper-plane mr-1"></i> Kirim Ulasan
                </button>
            </form>
        </div>
    </div>

    <script>
        function openTestimonialModal(rentalId) {
            document.getElementById('testimonialRentalId').value = rentalId;
            document.getElementById('testimonialModal').classList.remove('hidden');
            setRating(5);
        }
        function closeTestimonialModal() {
            document.getElementById('testimonialModal').classList.add('hidden');
        }
        function setRating(value) {
            document.getElementById('ratingInput').value = value;
            document.querySelectorAll('.star-btn').forEach(btn => {
                btn.style.color = parseInt(btn.dataset.star) <= value ? '#facc15' : '#d1d5db';
            });
        }
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('imagePreview');
                output.src = reader.result;
                document.getElementById('imagePreviewContainer').classList.remove('hidden');
            };
            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }
        function removeImagePreview() {
            const fileInput = document.querySelector('input[name="image"]');
            if (fileInput) fileInput.value = '';
            document.getElementById('imagePreviewContainer').classList.add('hidden');
        }
        document.addEventListener('DOMContentLoaded', () => setRating(5));
    </script>

    {{-- ===== MIDTRANS SNAP ===== --}}
    <script src="{{ config('midtrans.snap_url') }}"
            data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script>
        /**
         * bayarSekarang(rentalId, existingToken)
         * - Jika snap_token sudah ada (dari DB) → langsung pakai
         * - Jika belum → minta token baru ke backend
         */
        async function bayarSekarang(rentalId, existingToken) {
            const btn = document.querySelector(`[data-rental-id="${rentalId}"]`);
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memuat...';
            }

            let snapToken = existingToken;

            // Fetch new token if not available
            if (!snapToken) {
                try {
                    const res = await fetch(`/rentals/${rentalId}/pay`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                    });
                    const data = await res.json();

                    if (data.error) {
                        showPayAlert('error', data.error);
                        resetBtn(btn);
                        return;
                    }
                    snapToken = data.snap_token;
                } catch (e) {
                    showPayAlert('error', 'Gagal menghubungi server. Coba lagi.');
                    resetBtn(btn);
                    return;
                }
            }

            // Open Midtrans Snap popup
            snap.pay(snapToken, {
                onSuccess: async function(result) {
                    showPayAlert('success', '✅ Pembayaran berhasil! Memproses data...');
                    try {
                        await fetch(`/rentals/${rentalId}/pay-success-local`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                            }
                        });
                    } catch (e) {
                        console.error('Local update failed', e);
                    }
                    setTimeout(() => location.reload(), 1000);
                },
                onPending: function(result) {
                    showPayAlert('info', '⏳ Pembayaran tertunda. Selesaikan sesuai instruksi.');
                    setTimeout(() => location.reload(), 2000);
                },
                onError: function(result) {
                    showPayAlert('error', '❌ Pembayaran gagal. Coba lagi.');
                    resetBtn(btn);
                },
                onClose: function() {
                    // User closed popup without paying
                    resetBtn(btn);
                }
            });
        }

        function resetBtn(btn) {
            if (!btn) return;
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-wallet"></i> Bayar Sekarang';
        }

        function showPayAlert(type, msg) {
            const colors = {
                success: 'bg-green-50 border-green-300 text-green-700',
                error:   'bg-red-50 border-red-300 text-red-700',
                info:    'bg-blue-50 border-blue-300 text-blue-700',
            };
            const el = document.createElement('div');
            el.className = `fixed top-4 left-1/2 -translate-x-1/2 z-[9999] px-5 py-3 rounded-xl border text-sm font-semibold shadow-xl ${colors[type] ?? colors.info}`;
            el.textContent = msg;
            document.body.appendChild(el);
            setTimeout(() => el.remove(), 4000);
        }
    </script>
</x-app-layout>
