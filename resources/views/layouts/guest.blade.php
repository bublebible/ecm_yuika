<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} — {{ $pageTitle ?? 'Auth' }}</title>

        <!-- SEO -->
        <meta name="description" content="Login atau daftar akun baru di {{ config('app.name') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            *, *::before, *::after {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }

            html, body {
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
                min-height: 100vh;
                overflow-x: hidden;
            }

            body {
                background: #0f0c1a;
                color: #fff;
            }

            /* ===== BACKGROUND ===== */
            .auth-bg {
                position: fixed;
                inset: 0;
                z-index: 0;
                background: linear-gradient(135deg, #0f0c1a 0%, #1a0d2e 40%, #0d1b2a 100%);
                overflow: hidden;
            }

            .auth-bg-blob1 {
                position: absolute;
                top: -20%;
                left: -10%;
                width: 650px;
                height: 650px;
                background: radial-gradient(circle, rgba(219, 39, 119, 0.22) 0%, transparent 70%);
                animation: floatBlob 12s ease-in-out infinite alternate;
                border-radius: 50%;
            }

            .auth-bg-blob2 {
                position: absolute;
                bottom: -20%;
                right: -5%;
                width: 550px;
                height: 550px;
                background: radial-gradient(circle, rgba(139, 92, 246, 0.2) 0%, transparent 70%);
                animation: floatBlob 16s ease-in-out infinite alternate-reverse;
                border-radius: 50%;
            }

            .auth-bg-blob3 {
                position: absolute;
                top: 40%;
                left: 55%;
                width: 350px;
                height: 350px;
                background: radial-gradient(circle, rgba(6, 182, 212, 0.07) 0%, transparent 70%);
                animation: floatBlob 20s ease-in-out infinite alternate;
                border-radius: 50%;
            }

            @keyframes floatBlob {
                0%   { transform: translate(0, 0) scale(1); }
                50%  { transform: translate(25px, -35px) scale(1.08); }
                100% { transform: translate(-18px, 28px) scale(0.94); }
            }

            /* Grid overlay */
            .auth-grid {
                position: absolute;
                inset: 0;
                background-image:
                    linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
                background-size: 64px 64px;
            }

            /* ===== WRAPPER ===== */
            .auth-wrapper {
                position: relative;
                z-index: 10;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 24px 16px;
            }

            /* ===== CARD ===== */
            .auth-card {
                width: 100%;
                max-width: 460px;
                background: rgba(255, 255, 255, 0.04);
                backdrop-filter: blur(32px);
                -webkit-backdrop-filter: blur(32px);
                border: 1px solid rgba(255, 255, 255, 0.08);
                border-radius: 24px;
                padding: 40px 36px;
                box-shadow:
                    0 0 0 1px rgba(219, 39, 119, 0.06),
                    0 40px 80px rgba(0, 0, 0, 0.55),
                    inset 0 1px 0 rgba(255, 255, 255, 0.09);
                animation: slideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) both;
            }

            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(28px) scale(0.97);
                }
                to {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }

            /* ===== LOGO ===== */
            .auth-logo {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 12px;
                margin-bottom: 32px;
                text-decoration: none;
            }

            .auth-logo-icon {
                width: 46px;
                height: 46px;
                background: linear-gradient(135deg, #db2777, #9333ea);
                border-radius: 14px;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow:
                    0 8px 24px rgba(219, 39, 119, 0.4),
                    inset 0 1px 0 rgba(255,255,255,0.2);
                flex-shrink: 0;
            }

            .auth-logo-icon svg {
                width: 26px;
                height: 26px;
                fill: white;
            }

            .auth-logo-name {
                font-size: 22px;
                font-weight: 800;
                background: linear-gradient(135deg, #f9a8d4 30%, #e879f9 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                letter-spacing: -0.5px;
            }

            /* ===== RESPONSIVE ===== */
            @media (max-width: 480px) {
                .auth-card {
                    padding: 28px 20px;
                    border-radius: 20px;
                }

                .auth-logo-name {
                    font-size: 20px;
                }
            }
        </style>
    </head>
    <body>
        <!-- Background Effects -->
        <div class="auth-bg">
            <div class="auth-grid"></div>
            <div class="auth-bg-blob1"></div>
            <div class="auth-bg-blob2"></div>
            <div class="auth-bg-blob3"></div>
        </div>

        <!-- Main Content -->
        <div class="auth-wrapper">
            <div class="auth-card">

                <!-- Logo -->
                <a href="{{ url('/') }}" class="auth-logo">
                    <div class="auth-logo-icon">
                        <svg viewBox="0 0 316 316" xmlns="http://www.w3.org/2000/svg">
                            <path d="M305.8 81.125C305.77 80.995 305.69 80.885 305.65 80.755C305.56 80.525 305.49 80.285 305.37 80.075C305.29 79.935 305.17 79.815 305.07 79.685C304.94 79.515 304.83 79.325 304.68 79.175C304.55 79.045 304.39 78.955 304.25 78.845C304.09 78.715 303.95 78.575 303.77 78.475L251.32 48.275C249.97 47.495 248.31 47.495 246.96 48.275L194.51 78.475C194.33 78.575 194.19 78.725 194.03 78.845C193.89 78.955 193.73 79.045 193.6 79.175C193.45 79.325 193.34 79.515 193.21 79.685C193.11 79.815 192.99 79.935 192.91 80.075C192.79 80.285 192.71 80.525 192.63 80.755C192.58 80.875 192.51 80.995 192.48 81.125C192.38 81.495 192.33 81.875 192.33 82.265V139.625L148.62 164.795V52.575C148.62 52.185 148.57 51.805 148.47 51.435C148.44 51.305 148.36 51.195 148.32 51.065C148.23 50.835 148.16 50.595 148.04 50.385C147.96 50.245 147.84 50.125 147.74 49.995C147.61 49.825 147.5 49.635 147.35 49.485C147.22 49.355 147.06 49.265 146.92 49.155C146.76 49.025 146.62 48.885 146.44 48.785L93.99 18.585C92.64 17.805 90.98 17.805 89.63 18.585L37.18 48.785C37 48.885 36.86 49.035 36.7 49.155C36.56 49.265 36.4 49.355 36.27 49.485C36.12 49.635 36.01 49.825 35.88 49.995C35.78 50.125 35.66 50.245 35.58 50.385C35.46 50.595 35.38 50.835 35.3 51.065C35.25 51.185 35.18 51.305 35.15 51.435C35.05 51.805 35 52.185 35 52.575V232.235C35 233.795 35.84 235.245 37.19 236.025L142.1 296.425C142.33 296.555 142.58 296.635 142.82 296.725C142.93 296.765 143.04 296.835 143.16 296.865C143.53 296.965 143.9 297.015 144.28 297.015C144.66 297.015 145.03 296.965 145.4 296.865C145.5 296.835 145.59 296.775 145.69 296.745C145.95 296.655 146.21 296.565 146.45 296.435L251.36 236.035C252.72 235.255 253.55 233.815 253.55 232.245V174.885L303.81 145.945C305.17 145.165 306 143.725 306 142.155V82.265C305.95 81.875 305.89 81.495 305.8 81.125Z"/>
                        </svg>
                    </div>
                    <span class="auth-logo-name">{{ config('app.name', 'Yuika') }}</span>
                </a>

                <!-- Slot Content -->
                {{ $slot }}

            </div>
        </div>
    </body>
</html>
