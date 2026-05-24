<x-guest-layout>
    <x-slot name="pageTitle">Lupa Password</x-slot>

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
            margin-bottom: 24px;
        }

        .auth-info {
            background: rgba(99, 102, 241, 0.1);
            border: 1px solid rgba(99, 102, 241, 0.2);
            border-radius: 12px;
            padding: 14px 16px;
            color: rgba(255,255,255,0.6);
            font-size: 13px;
            line-height: 1.65;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .auth-info i {
            color: #818cf8;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .auth-status {
            background: rgba(34, 197, 94, 0.12);
            border: 1px solid rgba(34, 197, 94, 0.25);
            border-radius: 12px;
            padding: 14px 16px;
            color: #86efac;
            font-size: 13px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            line-height: 1.5;
        }

        .auth-status i { flex-shrink: 0; }

        /* Back navigation */
        .auth-back {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
        }

        .auth-back a {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-size: 13px;
            color: rgba(255,255,255,0.4);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .auth-back a:hover {
            color: rgba(255,255,255,0.7);
        }

        .form-group { margin-bottom: 20px; }

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

        .btn-back-link {
            width: 100%;
            margin-top: 12px;
            padding: 13px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            color: rgba(255,255,255,0.4);
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-back-link:hover {
            background: rgba(255,255,255,0.08);
            color: rgba(255,255,255,0.75);
        }

        /* Icon header */
        .forgot-icon-header {
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

        .forgot-icon-header i {
            font-size: 24px;
            background: linear-gradient(135deg, #f472b6, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>

    {{-- Icon header --}}
    <div class="forgot-icon-header">
        <i class="fas fa-key"></i>
    </div>

    <h2 class="auth-heading">Lupa password? 🔑</h2>
    <p class="auth-subheading">Tenang, kami akan bantu reset passwordmu</p>

    {{-- Session Status (email sent confirmation) --}}
    @if (session('status'))
        <div class="auth-status">
            <i class="fas fa-check-circle fa-lg"></i>
            <div>
                <strong style="display:block;margin-bottom:3px">Email terkirim!</strong>
                {{ session('status') }}
            </div>
        </div>
    @endif

    <div class="auth-info">
        <i class="fas fa-info-circle"></i>
        <span>Masukkan alamat email yang terdaftar. Kami akan mengirimkan link untuk mereset password ke email kamu.</span>
    </div>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        {{-- Email --}}
        <div class="form-group">
            <label class="form-label" for="email">Alamat Email</label>
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
                >
            </div>
            @error('email')
                <p class="form-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn-primary" id="sendBtn">
            <i class="fas fa-paper-plane"></i>
            Kirim Link Reset Password
        </button>
    </form>

    <a href="{{ route('login') }}" class="btn-back-link">
        <i class="fas fa-arrow-left"></i>
        Kembali ke Halaman Masuk
    </a>

    <script>
        // Prevent double submit + show loading state
        document.querySelector('form').addEventListener('submit', function() {
            const btn = document.getElementById('sendBtn');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
            btn.disabled = true;
        });
    </script>
</x-guest-layout>
