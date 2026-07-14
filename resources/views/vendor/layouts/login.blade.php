<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vendor Login — {{ config('app.name', 'TVR') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/logo_icon/shopping.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    @if (!App::environment('testing'))
        @vite(['resources/sass/app.scss'])
    @endif

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --accent:          #7c3aed;
            --accent-mid:      #8b5cf6;
            --accent-light:    #a78bfa;
            --accent-glow:     rgba(124,58,237,0.25);
            --panel-bg:        #0d0d1a;
            --panel-card:      rgba(255,255,255,0.04);
            --panel-border:    rgba(255,255,255,0.08);
            --form-bg:         #ffffff;
            --text-dark:       #0f0e17;
            --text-mid:        #4a4a6a;
            --text-muted:      #9090b0;
            --border:          #e8e8f0;
            --input-bg:        #f7f7fb;
            --radius-sm:       8px;
            --radius-md:       12px;
            --radius-lg:       16px;
            --radius-xl:       24px;
            --ease:            cubic-bezier(0.4, 0, 0.2, 1);
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* ============================================================
           ROOT WRAPPER
        ============================================================ */
        .vl-root {
            display: flex;
            flex: 1;
            min-height: 100vh;
            min-height: 100dvh;
        }

        /* ============================================================
           LEFT PANEL
        ============================================================ */
        .vl-left {
            flex: 1;
            background: var(--panel-bg);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 64px 56px;
        }

        /* Layered gradient orbs */
        .vl-left::before {
            content: '';
            position: absolute;
            top: -120px; left: -80px;
            width: 520px; height: 520px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(124,58,237,0.45) 0%, transparent 70%);
            pointer-events: none;
        }

        .vl-left::after {
            content: '';
            position: absolute;
            bottom: -160px; right: -100px;
            width: 600px; height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(139,92,246,0.3) 0%, transparent 65%);
            pointer-events: none;
        }

        /* Grid dot texture */
        .vl-dots {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle, rgba(255,255,255,0.07) 1px, transparent 1px);
            background-size: 32px 32px;
            pointer-events: none;
        }

        .vl-left-inner {
            position: relative;
            z-index: 2;
            max-width: 380px;
            width: 100%;
        }

        /* Logo badge */
        .vl-logo-badge {
            width: 72px; height: 72px;
            border-radius: 20px;
            background: linear-gradient(135deg, rgba(255,255,255,0.15), rgba(255,255,255,0.06));
            border: 1px solid rgba(255,255,255,0.12);
            backdrop-filter: blur(12px);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 32px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3), inset 0 1px 0 rgba(255,255,255,0.1);
            overflow: hidden;
        }

        .vl-logo-badge img {
            width: 44px; height: 44px; object-fit: contain;
            filter: brightness(0) invert(1) opacity(0.9);
        }

        /* Brand badge pill */
        .vl-brand-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(167,139,250,0.15);
            border: 1px solid rgba(167,139,250,0.25);
            border-radius: 100px;
            padding: 5px 14px 5px 10px;
            margin-bottom: 20px;
        }

        .vl-brand-pill-dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: #a78bfa;
            box-shadow: 0 0 8px rgba(167,139,250,0.8);
            animation: pulse-dot 2s ease-in-out infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: 0.6; transform: scale(0.85); }
        }

        .vl-brand-pill span {
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #a78bfa;
        }

        .vl-left-title {
            font-size: 2.4rem;
            font-weight: 900;
            color: #ffffff;
            line-height: 1.15;
            letter-spacing: -0.04em;
            margin-bottom: 14px;
        }

        .vl-left-title span {
            background: linear-gradient(90deg, #a78bfa, #c4b5fd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .vl-left-sub {
            font-size: 0.88rem;
            color: rgba(255,255,255,0.45);
            line-height: 1.7;
            margin-bottom: 44px;
        }

        /* Feature cards */
        .vl-features {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .vl-feature-card {
            display: flex;
            align-items: center;
            gap: 14px;
            background: var(--panel-card);
            border: 1px solid var(--panel-border);
            border-radius: var(--radius-md);
            padding: 13px 16px;
            transition: background 0.2s var(--ease), border-color 0.2s var(--ease);
            cursor: default;
        }

        .vl-feature-card:hover {
            background: rgba(255,255,255,0.07);
            border-color: rgba(167,139,250,0.25);
        }

        .vl-feature-icon {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, rgba(124,58,237,0.4), rgba(139,92,246,0.2));
            border: 1px solid rgba(167,139,250,0.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.8rem;
            color: #c4b5fd;
            flex-shrink: 0;
        }

        .vl-feature-text {
            font-size: 0.82rem;
            font-weight: 500;
            color: rgba(255,255,255,0.65);
            line-height: 1.4;
        }

        /* Bottom brand watermark */
        .vl-watermark {
            position: absolute;
            bottom: 28px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 2;
        }

        .vl-watermark-text {
            font-size: 0.72rem;
            color: rgba(255,255,255,0.2);
            letter-spacing: 0.04em;
        }

        /* ============================================================
           RIGHT FORM PANEL
        ============================================================ */
        .vl-right {
            width: 520px;
            flex-shrink: 0;
            background: #f4f4f8;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 48px;
            position: relative;
        }

        /* Subtle top accent line */
        .vl-right::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent), var(--accent-light), transparent);
        }

        .vl-form-box {
            width: 100%;
            max-width: 400px;
            background: #ffffff;
            border-radius: var(--radius-xl);
            box-shadow:
                0 0 0 1px rgba(0,0,0,0.05),
                0 4px 6px rgba(0,0,0,0.04),
                0 20px 48px rgba(0,0,0,0.07);
            padding: 40px 36px;
        }

        /* Form header */
        .vl-form-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 10px;
        }

        .vl-form-eyebrow::before {
            content: '';
            width: 18px; height: 2px;
            background: var(--accent);
            border-radius: 2px;
            display: inline-block;
        }

        .vl-form-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-dark);
            letter-spacing: -0.03em;
            margin-bottom: 6px;
            line-height: 1.2;
        }

        .vl-form-desc {
            font-size: 0.83rem;
            color: var(--text-muted);
            margin-bottom: 30px;
            line-height: 1.5;
        }

        /* Divider */
        .vl-divider {
            height: 1px;
            background: var(--border);
            margin-bottom: 28px;
        }

        /* Alert */
        .vl-alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            background: #fff1f2;
            border: 1px solid #fecdd3;
            border-left: 3px solid #ef4444;
            border-radius: var(--radius-sm);
            padding: 11px 14px;
            font-size: 0.78rem;
            color: #be123c;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .vl-alert i { font-size: 0.78rem; flex-shrink: 0; margin-top: 1px; }

        /* Form field */
        .vl-field {
            margin-bottom: 20px;
        }

        .vl-label {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-mid);
            letter-spacing: 0.02em;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .vl-input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .vl-input-icon {
            position: absolute;
            left: 14px;
            color: var(--text-muted);
            font-size: 0.8rem;
            pointer-events: none;
            z-index: 1;
            transition: color 0.18s var(--ease);
        }

        .vl-input {
            width: 100%;
            background: var(--input-bg);
            border: 1.5px solid var(--border);
            border-radius: var(--radius-md);
            color: var(--text-dark);
            font-size: 0.875rem;
            font-family: inherit;
            padding: 11px 14px 11px 40px;
            outline: none;
            transition: border-color 0.18s var(--ease), box-shadow 0.18s var(--ease), background 0.18s var(--ease);
        }

        .vl-input::placeholder { color: #c0c0d0; }

        .vl-input-wrap:focus-within .vl-input-icon { color: var(--accent); }

        .vl-input:focus {
            background: #fff;
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(124,58,237,0.1);
        }

        .vl-input.is-invalid {
            background: #fff;
            border-color: #ef4444;
            box-shadow: 0 0 0 4px rgba(239,68,68,0.08);
        }

        .vl-toggle-pw {
            position: absolute;
            right: 13px;
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 0.8rem;
            padding: 5px;
            display: flex; align-items: center;
            border-radius: 6px;
            transition: color 0.15s var(--ease), background 0.15s var(--ease);
        }

        .vl-toggle-pw:hover {
            color: var(--accent);
            background: rgba(124,58,237,0.08);
        }

        /* Bottom row: remember + forgot */
        .vl-bottom-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 26px;
        }

        .vl-check {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .vl-check input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: var(--accent);
            cursor: pointer;
            border-radius: 4px;
        }

        .vl-check label {
            font-size: 0.8rem;
            color: var(--text-mid);
            cursor: pointer;
            margin: 0;
            user-select: none;
        }

        /* Submit button */
        .vl-submit {
            width: 100%;
            padding: 13px 20px;
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-mid) 100%);
            color: #fff;
            border: none;
            border-radius: var(--radius-md);
            font-size: 0.9rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            letter-spacing: 0.01em;
            display: flex; align-items: center; justify-content: center; gap: 9px;
            box-shadow: 0 4px 16px rgba(124,58,237,0.4), 0 1px 0 rgba(255,255,255,0.1) inset;
            transition: all 0.2s var(--ease);
            position: relative;
            overflow: hidden;
        }

        .vl-submit::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
            opacity: 0;
            transition: opacity 0.2s var(--ease);
        }

        .vl-submit:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(124,58,237,0.5); }
        .vl-submit:hover::before { opacity: 1; }
        .vl-submit:active { transform: translateY(0); box-shadow: 0 3px 10px rgba(124,58,237,0.35); }
        .vl-submit:disabled { opacity: 0.65; cursor: not-allowed; transform: none; }

        /* Footer note */
        .vl-form-footer {
            margin-top: 22px;
            text-align: center;
            font-size: 0.76rem;
            color: var(--text-muted);
        }

        /* ============================================================
           MOBILE HERO HEADER
           Hidden on desktop, replaces left panel on mobile
        ============================================================ */
        .vl-mobile-header {
            display: none;
        }

        /* ============================================================
           RESPONSIVE — Tablet (≤ 1024px): shrink left panel
        ============================================================ */
        @media (max-width: 1024px) {
            .vl-left { padding: 48px 36px; }
            .vl-left-title { font-size: 2rem; }
            .vl-right { width: 460px; padding: 40px 32px; }
        }

        /* ============================================================
           RESPONSIVE — Mobile (≤ 768px)
           Full-screen stacked layout. Hero top, form fills & centers.
        ============================================================ */
        @media (max-width: 768px) {

            html {
                height: 100%;
            }

            body {
                height: 100%;
                min-height: 100vh;
                min-height: 100dvh;
            }

            /* The root becomes a full-screen column */
            .vl-root {
                flex-direction: column;
                width: 100%;
                min-height: 100vh;
                min-height: 100dvh;
                background: linear-gradient(160deg, #1e1b4b 0%, #3730a3 55%, #6366f1 100%);
            }

            /* Hide desktop left panel */
            .vl-left { display: none; }

            /* ---- Mobile hero header ---- */
            .vl-mobile-header {
                display: block;
                position: relative;
                overflow: hidden;
                padding: 48px 24px 72px;
                flex-shrink: 0;
            }

            /* Dot texture */
            .vl-mobile-header::before {
                content: '';
                position: absolute;
                inset: 0;
                background-image: radial-gradient(circle, rgba(255,255,255,0.07) 1px, transparent 1px);
                background-size: 28px 28px;
                pointer-events: none;
            }

            /* Glow orb */
            .vl-mobile-header::after {
                content: '';
                position: absolute;
                top: -60px; right: -60px;
                width: 240px; height: 240px;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(167,139,250,0.4) 0%, transparent 70%);
                pointer-events: none;
            }

            .vl-mobile-header-inner {
                position: relative;
                z-index: 1;
                display: flex;
                align-items: center;
                gap: 14px;
            }

            .vl-mobile-logo {
                width: 52px; height: 52px;
                border-radius: 16px;
                background: rgba(255,255,255,0.12);
                border: 1px solid rgba(255,255,255,0.18);
                backdrop-filter: blur(10px);
                display: flex; align-items: center; justify-content: center;
                flex-shrink: 0;
                overflow: hidden;
                box-shadow: 0 4px 16px rgba(0,0,0,0.2);
            }

            .vl-mobile-logo img {
                width: 30px; height: 30px; object-fit: contain;
                filter: brightness(0) invert(1) opacity(0.9);
            }

            .vl-mobile-brand-name {
                font-size: 1.15rem;
                font-weight: 800;
                color: #fff;
                letter-spacing: -0.02em;
                line-height: 1.2;
            }

            .vl-mobile-brand-sub {
                font-size: 0.7rem;
                font-weight: 500;
                color: rgba(255,255,255,0.5);
                letter-spacing: 0.1em;
                text-transform: uppercase;
                margin-top: 3px;
            }

            /* ---- White sheet: overlaps hero, stretches to bottom ---- */
            .vl-right {
                width: 100%;
                /* Stretch to fill remaining viewport height */
                flex-grow: 1;
                flex-shrink: 0;
                flex-basis: auto;
                background: #ffffff;
                border-radius: 28px 28px 0 0;
                margin-top: -32px;
                box-shadow: 0 -8px 40px rgba(0,0,0,0.15);
                /* Center form content */
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 40px 24px 48px;
                position: relative;
                /* Ensure it always reaches the bottom of screen */
                min-height: calc(100vh - 120px);
                min-height: calc(100dvh - 120px);
            }

            .vl-right::before { display: none; }

            /* Form box — transparent, just a width wrapper */
            .vl-form-box {
                width: 100%;
                max-width: 100%;
                background: transparent;
                border-radius: 0;
                box-shadow: none;
                padding: 0;
            }

            .vl-form-title { font-size: 1.6rem; }
        }

        /* ============================================================
           RESPONSIVE — Mobile (≤ 480px)
        ============================================================ */
        @media (max-width: 480px) {
            .vl-mobile-header { padding: 40px 20px 64px; }
            .vl-right { padding: 36px 20px 44px; }
            .vl-form-title { font-size: 1.45rem; }
            .vl-form-desc { font-size: 0.82rem; }

            /* Prevents iOS Safari auto-zoom on input tap */
            .vl-input {
                font-size: 1rem;
                padding: 13px 14px 13px 40px;
            }

            .vl-submit { padding: 15px 20px; font-size: 1rem; }
            .vl-toggle-pw { padding: 8px; }
            .vl-check input[type="checkbox"] { width: 18px; height: 18px; }
            .vl-check label { font-size: 0.85rem; }
            .vl-bottom-row { margin-bottom: 24px; }
        }

        /* ============================================================
           RESPONSIVE — Very small (≤ 360px)
        ============================================================ */
        @media (max-width: 360px) {
            .vl-mobile-header { padding: 32px 16px 56px; }
            .vl-right { padding: 28px 16px 36px; }
            .vl-form-title { font-size: 1.3rem; }
        }
    </style>
    @yield('css')
</head>
<body style="display:flex; flex-direction:column; min-height:100vh; min-height:100dvh;">
    @yield('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('js')
</body>
</html>
