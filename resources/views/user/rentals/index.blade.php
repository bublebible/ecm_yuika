<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Penyewaan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kostum</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rentals as $rental)
                                    <tr>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            #{{ $rental->id }}
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            @foreach($rental->items as $item)
                                                <div>{{ $item->asset->name ?? '-' }} (x{{ $item->qty }})</div>
                                            @endforeach
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            {{ $rental->start_date->format('d M') }} - {{ $rental->end_date->format('d M Y') }}
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            Rp {{ number_format($rental->total_price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            @php
                                                $statusColor = match($rental->status) {
                                                    'pending'   => ['text-yellow-900', 'bg-yellow-200'],
                                                    'approved'  => ['text-blue-900', 'bg-blue-200'],
                                                    'active'    => ['text-green-900', 'bg-green-200'],
                                                    'returned'  => ['text-orange-900', 'bg-orange-200'],
                                                    'completed' => ['text-emerald-900', 'bg-emerald-200'],
                                                    'cancelled' => ['text-red-900', 'bg-red-200'],
                                                    default     => ['text-gray-900', 'bg-gray-200'],
                                                };
                                                $statusLabel = match($rental->status) {
                                                    'pending'   => 'Menunggu',
                                                    'approved'  => 'Disetujui',
                                                    'active'    => 'Aktif',
                                                    'returned'  => 'Dikembalikan',
                                                    'completed' => 'Selesai ✓',
                                                    'cancelled' => 'Dibatalkan',
                                                    default     => ucfirst($rental->status),
                                                };
                                            @endphp
                                            <span class="relative inline-block px-3 py-1 font-semibold leading-tight {{ $statusColor[0] }}">
                                                <span aria-hidden class="absolute inset-0 opacity-50 rounded-full {{ $statusColor[1] }}"></span>
                                                <span class="relative">{{ $statusLabel }}</span>
                                            </span>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <div class="flex flex-wrap gap-2">
                                                @if($rental->status === 'pending')
                                                    <a href="{{ route('user.rentals.edit', $rental) }}"
                                                       class="text-blue-600 hover:text-blue-900 text-xs font-medium">
                                                        <i class="fas fa-info-circle mr-1"></i>Detail
                                                    </a>
                                                @elseif(in_array($rental->status, ['approved', 'active']))
                                                    <a href="{{ route('user.rentals.edit', $rental) }}"
                                                       class="text-blue-600 hover:text-blue-900 text-xs font-medium">
                                                        <i class="fas fa-file-contract mr-1"></i>Kontrak
                                                    </a>
                                                @elseif($rental->status === 'completed')
                                                    @if(!$rental->testimonial)
                                                        {{-- Belum ada testimoni → tampilkan tombol --}}
                                                        <button
                                                            type="button"
                                                            onclick="openTestimonialModal({{ $rental->id }})"
                                                            class="inline-flex items-center gap-1 text-xs font-semibold text-pink-600 border border-pink-300 rounded-lg px-2.5 py-1 hover:bg-pink-50 transition">
                                                            <i class="fas fa-star"></i> Beri Testimoni
                                                        </button>
                                                    @else
                                                        <span class="inline-flex items-center gap-1 text-xs text-emerald-600 font-medium">
                                                            <i class="fas fa-check-circle"></i> Sudah direview
                                                        </span>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-8 text-gray-400 italic">
                                            <i class="fas fa-box-open text-3xl mb-2 block"></i>
                                            Belum ada penyewaan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== TESTIMONIAL MODAL ===== --}}
    <div id="testimonialModal"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm hidden"
         onclick="if(event.target===this) closeTestimonialModal()">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 p-6 relative animate-[slideUp_0.3s_ease_both]">
            {{-- Close --}}
            <button onclick="closeTestimonialModal()"
                    class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-xl transition">
                <i class="fas fa-times"></i>
            </button>

            <div class="text-center mb-6">
                <div class="w-14 h-14 bg-gradient-to-br from-pink-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-star text-white text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Bagaimana pengalamanmu?</h3>
                <p class="text-sm text-gray-500 mt-1">Bantu cosplayer lain dengan testimonimu 🎉</p>
            </div>

            <form id="testimonialForm" method="POST" action="{{ route('testimonials.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="rental_id" id="testimonialRentalId">

                {{-- Star Rating --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Rating</label>
                    <div class="flex gap-2" id="starRating">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button"
                                    data-star="{{ $i }}"
                                    onclick="setRating({{ $i }})"
                                    class="star-btn text-3xl text-gray-300 hover:text-yellow-400 transition-colors cursor-pointer leading-none">
                                ★
                            </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="ratingInput" value="5">
                </div>

                {{-- Comment --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="testimonialComment">
                        Komentar
                    </label>
                    <textarea
                        id="testimonialComment"
                        name="comment"
                        rows="4"
                        placeholder="Ceritakan pengalamanmu menyewa kostum di sini..."
                        class="w-full border border-gray-200 rounded-xl p-3 text-sm text-gray-700 resize-none focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition"
                        required
                        minlength="5"
                        maxlength="1000"
                    ></textarea>
                    <p class="text-xs text-gray-400 mt-1">Min. 5 karakter</p>
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
                    <i class="fas fa-paper-plane mr-1"></i> Kirim Testimoni
                </button>
            </form>
        </div>
    </div>

    <style>
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
    </style>

    <script>
        let currentRating = 5;

        function openTestimonialModal(rentalId) {
            document.getElementById('testimonialRentalId').value = rentalId;
            document.getElementById('testimonialModal').classList.remove('hidden');
            setRating(5); // default 5 stars
        }

        function closeTestimonialModal() {
            document.getElementById('testimonialModal').classList.add('hidden');
        }

        function setRating(value) {
            currentRating = value;
            document.getElementById('ratingInput').value = value;
            document.querySelectorAll('.star-btn').forEach(btn => {
                const star = parseInt(btn.dataset.star);
                btn.style.color = star <= value ? '#facc15' : '#d1d5db';
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

        // Initialize stars
        document.addEventListener('DOMContentLoaded', () => setRating(5));
    </script>
</x-app-layout>
