<x-guest-layout>
    <x-slot name="pageTitle">Daftar Akun</x-slot>

    <style>
        .auth-heading {
            font-size: 26px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.5px;
            margin-bottom: 6px;
        }

        .auth-subheading {
            font-size: 14px;
            color: rgba(255,255,255,0.45);
            margin-bottom: 28px;
        }

        .auth-tabs {
            display: flex;
            background: rgba(255,255,255,0.05);
            border-radius: 12px;
            padding: 4px;
            margin-bottom: 28px;
            gap: 4px;
        }

        .auth-tab {
            flex: 1;
            text-align: center;
            padding: 9px 12px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            color: rgba(255,255,255,0.4);
            border: none;
            background: transparent;
            transition: all 0.25s ease;
            font-family: 'Inter', sans-serif;
            text-decoration: none;
            display: block;
        }

        .auth-tab.active {
            background: linear-gradient(135deg, #db2777, #9333ea);
            color: #fff;
            box-shadow: 0 4px 16px rgba(219, 39, 119, 0.35);
        }

        .auth-tab:hover:not(.active) {
            color: rgba(255,255,255,0.7);
            background: rgba(255,255,255,0.07);
        }

        .form-group { margin-bottom: 14px; }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: rgba(255,255,255,0.5);
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 7px;
        }

        .form-input {
            width: 100%;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 13px 16px;
            color: #fff;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s ease;
            outline: none;
        }

        .form-input::placeholder { color: rgba(255,255,255,0.2); }

        .form-input:focus {
            border-color: rgba(219, 39, 119, 0.6);
            background: rgba(255,255,255,0.09);
            box-shadow: 0 0 0 3px rgba(219, 39, 119, 0.12);
        }

        .form-input.is-invalid {
            border-color: rgba(239, 68, 68, 0.7);
        }

        .input-with-icon { position: relative; }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.25);
            font-size: 14px;
            pointer-events: none;
        }

        .input-with-icon .form-input { padding-left: 40px; }

        .input-toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.25);
            font-size: 14px;
            cursor: pointer;
            border: none;
            background: transparent;
            transition: color 0.2s;
        }

        .input-toggle-password:hover { color: rgba(255,255,255,0.6); }

        .form-error {
            font-size: 12px;
            color: #f87171;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-primary {
            width: 100%;
            margin-top: 6px;
            padding: 14px;
            background: linear-gradient(135deg, #db2777 0%, #9333ea 100%);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.25s ease;
            letter-spacing: 0.3px;
            box-shadow: 0 8px 24px rgba(219, 39, 119, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(219, 39, 119, 0.45);
        }

        /* Password strength */
        .password-strength {
            margin-top: 7px;
        }

        .password-strength-bar {
            height: 3px;
            border-radius: 4px;
            background: rgba(255,255,255,0.1);
            overflow: hidden;
        }

        .password-strength-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.35s ease, background 0.35s ease;
            width: 0%;
        }

        .strength-weak   { width: 33% !important; background: #ef4444; }
        .strength-medium { width: 66% !important; background: #f59e0b; }
        .strength-strong { width: 100% !important; background: #22c55e; }

        .password-strength-text {
            font-size: 11px;
            margin-top: 4px;
            color: rgba(255,255,255,0.3);
        }

        /* Terms */
        .terms-text {
            font-size: 12px;
            color: rgba(255,255,255,0.3);
            text-align: center;
            margin-top: 14px;
            line-height: 1.6;
        }

        .terms-text a {
            color: #f472b6;
            text-decoration: none;
        }

        .terms-text a:hover {
            text-decoration: underline;
        }
    </style>

    {{-- ===== TABS ===== --}}
    <div class="auth-tabs">
        <a href="{{ route('login') }}"
           class="auth-tab {{ request()->routeIs('login') ? 'active' : '' }}">
            <i class="fas fa-sign-in-alt" style="margin-right:5px"></i>Masuk
        </a>
        <a href="{{ route('register') }}"
           class="auth-tab {{ request()->routeIs('register') ? 'active' : '' }}">
            <i class="fas fa-user-plus" style="margin-right:5px"></i>Daftar
        </a>
    </div>

    <h2 class="auth-heading">Buat akun baru ✨</h2>
    <p class="auth-subheading">Bergabung dan mulai pengalamanmu</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Name --}}
        <div class="form-group">
            <label class="form-label" for="name">Nama Lengkap</label>
            <div class="input-with-icon">
                <i class="fas fa-user input-icon"></i>
                <input
                    id="name"
                    class="form-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Nama kamu"
                    required
                    autofocus
                    autocomplete="name"
                >
            </div>
            @error('name')
                <p class="form-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <div class="input-with-icon">
                <i class="fas fa-envelope input-icon"></i>
                <input
                    id="email"
                    class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="kamu@email.com"
                    required
                    autocomplete="username"
                >
            </div>
            @error('email')
                <p class="form-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <div class="input-with-icon">
                <i class="fas fa-lock input-icon"></i>
                <input
                    id="password"
                    class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                    type="password"
                    name="password"
                    placeholder="Min. 8 karakter"
                    required
                    autocomplete="new-password"
                    oninput="checkStrength(this.value)"
                >
                <button type="button" class="input-toggle-password" onclick="togglePassword('password', this)">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            {{-- Strength Bar --}}
            <div class="password-strength" id="strengthBox">
                <div class="password-strength-bar">
                    <div class="password-strength-fill" id="strengthFill"></div>
                </div>
                <p class="password-strength-text" id="strengthText">Masukkan password</p>
            </div>
            @error('password')
                <p class="form-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="form-group">
            <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
            <div class="input-with-icon">
                <i class="fas fa-shield-halved input-icon"></i>
                <input
                    id="password_confirmation"
                    class="form-input {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                    type="password"
                    name="password_confirmation"
                    placeholder="Ulangi password"
                    required
                    autocomplete="new-password"
                >
                <button type="button" class="input-toggle-password" onclick="togglePassword('password_confirmation', this)">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            @error('password_confirmation')
                <p class="form-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn-primary">
            <i class="fas fa-rocket"></i>
            Buat Akun
        </button>

        <p class="terms-text">
            Dengan mendaftar, kamu menyetujui <a href="#">Syarat & Ketentuan</a> kami
        </p>
    </form>

    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        function checkStrength(val) {
            const fill = document.getElementById('strengthFill');
            const text = document.getElementById('strengthText');
            fill.className = 'password-strength-fill';

            if (val.length === 0) {
                text.textContent = 'Masukkan password';
                text.style.color = 'rgba(255,255,255,0.3)';
                return;
            }

            let score = 0;
            if (val.length >= 8)  score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            if (score <= 1) {
                fill.classList.add('strength-weak');
                text.textContent = 'Lemah – coba tambah angka & simbol';
                text.style.color = '#ef4444';
            } else if (score <= 2) {
                fill.classList.add('strength-medium');
                text.textContent = 'Sedang – tambahkan huruf kapital';
                text.style.color = '#f59e0b';
            } else {
                fill.classList.add('strength-strong');
                text.textContent = 'Kuat ✓';
                text.style.color = '#22c55e';
            }
        }
    </script>
</x-guest-layout>
