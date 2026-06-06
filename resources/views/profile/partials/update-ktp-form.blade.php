<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Verifikasi KTP / Identitas') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Verifikasi identitas diperlukan agar Anda dapat menyewa kostum di Yuika Rentcoss.') }}
        </p>
    </header>

    @if(session('status') === 'ktp-uploaded')
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
            KTP berhasil diunggah! Mohon menunggu verifikasi dari admin.
        </div>
    @endif

    {{-- KTP STATUS BADGES & ALERTS --}}
    <div class="p-4 rounded-2xl border transition-all duration-300
        @if($user->ktp_status === 'verified') bg-emerald-50 border-emerald-200 text-emerald-800
        @elseif($user->ktp_status === 'pending') bg-amber-50 border-amber-200 text-amber-800
        @elseif($user->ktp_status === 'rejected') bg-rose-50 border-rose-200 text-rose-800
        @else bg-gray-50 border-gray-200 text-gray-800
        @endif">
        
        <div class="flex items-center gap-3">
            <div class="p-2 rounded-xl bg-white shadow-sm">
                @if($user->ktp_status === 'verified')
                    <i class="fas fa-check-circle text-emerald-600 text-lg"></i>
                @elseif($user->ktp_status === 'pending')
                    <i class="fas fa-clock text-amber-600 text-lg"></i>
                @elseif($user->ktp_status === 'rejected')
                    <i class="fas fa-times-circle text-rose-600 text-lg"></i>
                @else
                    <i class="fas fa-id-card text-gray-500 text-lg"></i>
                @endif
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Status Verifikasi KTP</p>
                <h4 class="font-bold text-sm">
                    @if($user->ktp_status === 'verified')
                        DIVERIFIKASI (Aktif)
                    @elseif($user->ktp_status === 'pending')
                        MENUNGGU VERIFIKASI ADMIN
                    @elseif($user->ktp_status === 'rejected')
                        VERIFIKASI DITOLAK
                    @else
                        BELUM MELAKUKAN VERIFIKASI
                    @endif
                </h4>
            </div>
        </div>

        @if($user->ktp_status === 'rejected' && $user->ktp_rejection_reason)
            <div class="mt-3 text-xs bg-white/60 p-3 rounded-xl border border-rose-200/50">
                <strong class="text-rose-700 block mb-1">Alasan Penolakan:</strong>
                <p>{{ $user->ktp_rejection_reason }}</p>
            </div>
        @endif
    </div>

    {{-- KTP IMAGE PREVIEW & UPLOAD FORM --}}
    @if($user->ktp_image)
        <div class="mt-4">
            <p class="text-sm font-semibold text-gray-700 mb-2">Foto KTP yang Diunggah:</p>
            <div class="relative max-w-sm rounded-2xl overflow-hidden border border-gray-200 bg-gray-100 shadow-sm aspect-[3/2]">
                <img src="{{ Storage::url($user->ktp_image) }}" alt="KTP {{ $user->name }}" class="object-cover w-full h-full">
            </div>
        </div>
    @endif

    @if($user->ktp_status === 'unverified' || $user->ktp_status === 'rejected')
        <form method="post" action="{{ route('profile.upload_ktp') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
            @csrf

            <div>
                <x-input-label for="ktp_image" :value="__('Pilih Foto KTP / Identitas')" />
                <div class="mt-2 flex items-center justify-center border-2 border-dashed border-gray-300 rounded-2xl px-6 py-8 hover:border-pink-500 transition cursor-pointer relative" id="dropzone">
                    <input type="file" id="ktp_image" name="ktp_image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/jpeg,image/png,image/webp" onchange="previewKtp(event)" required>
                    <div class="text-center" id="upload-prompt">
                        <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-3"></i>
                        <p class="text-sm text-gray-600 font-semibold">Klik untuk memilih atau seret gambar ke sini</p>
                        <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, WebP (Maksimal 2MB)</p>
                    </div>
                    <div class="hidden text-center" id="upload-preview-container">
                        <img id="ktp-preview" src="#" alt="Pratinjau KTP" class="max-h-40 rounded-lg mx-auto shadow-md border">
                        <p class="text-xs text-pink-600 font-semibold mt-2" id="filename-text"></p>
                    </div>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('ktp_image')" />
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Unggah KTP') }}</x-primary-button>
            </div>
        </form>
    @endif

    <script>
        function previewKtp(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('ktp-preview').src = e.target.result;
                document.getElementById('upload-prompt').classList.add('hidden');
                document.getElementById('upload-preview-container').classList.remove('hidden');
                document.getElementById('filename-text').textContent = file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
            };
            reader.readAsDataURL(file);
        }
    </script>
</section>
