<x-guest-layout>
    <x-slot name="pageTitle">Masuk</x-slot>

    <style>
        /* ===== AUTH FORM SHARED STYLES ===== */
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

        /* Tabs */
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

        /* Form panels */
        .auth-panel {
            display: none;
            animation: fadeInPanel 0.35s ease both;
        }

        .auth-panel.active {
            display: block;
        }

        @keyframes fadeInPanel {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Form Group */
        .form-group {
            margin-bottom: 16px;
        }

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

        .form-input::placeholder {
            color: rgba(255,255,255,0.2);
        }

        .form-input:focus {
            border-color: rgba(219, 39, 119, 0.6);
            background: rgba(255,255,255,0.09);
            box-shadow: 0 0 0 3px rgba(219, 39, 119, 0.12);
        }

        .form-input.is-invalid {
            border-color: rgba(239, 68, 68, 0.7);
        }

        .input-with-icon {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.25);
            font-size: 14px;
            pointer-events: none;
        }

        .input-with-icon .form-input {
            padding-left: 40px;
        }

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

        .input-toggle-password:hover {
            color: rgba(255,255,255,0.6);
        }

        .form-error {
            font-size: 12px;
            color: #f87171;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Remember row */
        .form-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
            margin-top: 4px;
        }

        .form-checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: rgba(255,255,255,0.45);
            cursor: pointer;
            user-select: none;
        }

        .form-checkbox {
            width: 16px;
            height: 16px;
            accent-color: #db2777;
            cursor: pointer;
        }

        .form-link {
            font-size: 13px;
            color: #f472b6;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .form-link:hover {
            color: #ec4899;
        }

        /* Submit button */
        .btn-primary {
            width: 100%;
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
            background: linear-gradient(135deg, #be185d 0%, #7e22ce 100%);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* Divider */
        .auth-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px 0;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,0.08);
        }

        .auth-divider-text {
            font-size: 12px;
            color: rgba(255,255,255,0.25);
            white-space: nowrap;
        }

        /* Status message */
        .auth-status {
            background: rgba(34, 197, 94, 0.12);
            border: 1px solid rgba(34, 197, 94, 0.25);
            border-radius: 10px;
            padding: 12px 16px;
            color: #86efac;
            font-size: 13px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Forgot password success info */
        .auth-info {
            background: rgba(99, 102, 241, 0.1);
            border: 1px solid rgba(99, 102, 241, 0.2);
            border-radius: 10px;
            padding: 14px 16px;
            color: rgba(255,255,255,0.6);
            font-size: 13px;
            line-height: 1.6;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .auth-info i {
            color: #818cf8;
            margin-top: 1px;
            flex-shrink: 0;
        }

        /* Forgot back link */
        .btn-back {
            width: 100%;
            margin-top: 14px;
            padding: 12px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            color: rgba(255,255,255,0.5);
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-back:hover {
            background: rgba(255,255,255,0.08);
            color: rgba(255,255,255,0.75);
        }

        /* Password strength indicator */
        .password-strength {
            display: none;
            margin-top: 6px;
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
            transition: width 0.3s ease, background 0.3s ease;
            width: 0%;
        }

        .strength-weak   { width: 33%; background: #ef4444; }
        .strength-medium { width: 66%; background: #f59e0b; }
        .strength-strong { width: 100%; background: #22c55e; }

        .password-strength-text {
            font-size: 11px;
            margin-top: 4px;
        }
    </style>

    {{-- Session Status --}}
    @if (session('status'))
        <div class="auth-status">
            <i class="fas fa-check-circle"></i>
            {{ session('status') }}
        </div>
    @endif

    {{-- ===== TABS ===== --}}
    <div class="auth-tabs" id="authTabs">
        <a href="{{ route('login') }}"
           class="auth-tab {{ request()->routeIs('login') ? 'active' : '' }}"
           id="tabLogin">
            <i class="fas fa-sign-in-alt" style="margin-right:5px"></i>Masuk
        </a>
        <a href="{{ route('register') }}"
           class="auth-tab {{ request()->routeIs('register') ? 'active' : '' }}"
           id="tabRegister">
            <i class="fas fa-user-plus" style="margin-right:5px"></i>Daftar
        </a>
    </div>

    {{-- ===== LOGIN PANEL ===== --}}
    <div class="auth-panel active" id="panelLogin">
        <h2 class="auth-heading">Selamat datang kembali 👋</h2>
        <p class="auth-subheading">Masuk untuk melanjutkan ke akunmu</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

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
                        autofocus
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
                        placeholder="••••••••"
                        required
                        autocomplete="current-password"
                    >
                    <button type="button" class="input-toggle-password" onclick="togglePassword('password', this)">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <p class="form-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember + Forgot --}}
            <div class="form-row">
                <label class="form-checkbox-label">
                    <input type="checkbox" id="remember_me" name="remember" class="form-checkbox">
                    Ingat saya
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="form-link">Lupa password?</a>
                @endif
            </div>

            <button type="submit" class="btn-primary">
                <i class="fas fa-arrow-right-to-bracket"></i>
                Masuk Sekarang
            </button>
        </form>
    </div>

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
    </script>
</x-guest-layout>
