<x-guest-layout>
    <x-slot name="pageTitle">Reset Password</x-slot>

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

        .form-group { margin-bottom: 16px; }

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
            padding: 13px 16px 13px 42px;
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
            margin-top: 8px;
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

        .reset-icon-header {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, rgba(219,39,119,0.2), rgba(147,51,234,0.2));
            border: 1px solid rgba(219,39,119,0.25);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .reset-icon-header i {
            font-size: 24px;
            background: linear-gradient(135deg, #f472b6, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>

    <div class="reset-icon-header">
        <i class="fas fa-shield-halved"></i>
    </div>

    <h2 class="auth-heading">Reset Password 🔐</h2>
    <p class="auth-subheading">Buat password baru yang kuat untuk akunmu</p>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

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
                    value="{{ old('email', $request->email) }}"
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
            <label class="form-label" for="password">Password Baru</label>
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
                >
                <button type="button" class="input-toggle-password" onclick="togglePassword('password', this)">
                    <i class="fas fa-eye"></i>
                </button>
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
                    placeholder="Ulangi password baru"
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
            <i class="fas fa-check-circle"></i>
            Simpan Password Baru
        </button>
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
    </script>
</x-guest-layout>
