<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Profil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Perbarui informasi akun dan foto profilmu.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- ===== AVATAR UPLOAD ===== --}}
        <div class="flex items-center gap-5">
            {{-- Current Avatar --}}
            <div class="relative group">
                <img
                    id="avatar-preview"
                    src="{{ auth()->user()->avatarUrl() }}"
                    alt="Foto Profil"
                    class="w-20 h-20 rounded-full object-cover border-4 border-pink-200 shadow-md"
                >
                <label for="avatar"
                    class="absolute inset-0 flex items-center justify-center bg-black/40 rounded-full opacity-0 group-hover:opacity-100 cursor-pointer transition-opacity">
                    <i class="fas fa-camera text-white text-lg"></i>
                </label>
                <input
                    type="file"
                    id="avatar"
                    name="avatar"
                    class="hidden"
                    accept="image/jpeg,image/png,image/webp,image/gif"
                    onchange="previewAvatar(event)"
                >
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-700">Foto Profil</p>
                <p class="text-xs text-gray-500 mt-0.5">JPG, PNG, WebP, GIF. Maks 2MB.</p>
                <label for="avatar"
                    class="inline-block mt-2 text-xs font-semibold text-pink-600 border border-pink-300 rounded-lg px-3 py-1.5 cursor-pointer hover:bg-pink-50 transition">
                    <i class="fas fa-upload mr-1"></i> Ganti Foto
                </label>
                @error('avatar')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Name --}}
        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Email belum diverifikasi.') }}
                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Klik di sini untuk mengirim ulang verifikasi.') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Link verifikasi baru telah dikirim.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Tersimpan!') }}</p>
            @endif
        </div>
    </form>

    <script>
        function previewAvatar(event) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    </script>
</section>
