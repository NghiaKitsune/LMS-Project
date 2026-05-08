<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($data['title']) ? htmlspecialchars($data['title']) : 'LMS Platform' ?></title>

    <link rel="icon" type="image/avif" href="<?= BASE_URL ?>/assets/uploads/logo.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Auth wrapper ─────────────────────────────── */
        .auth-wrapper {
            flex: 1;
            display: flex;
            align-items: stretch;
            min-height: 100vh;
        }

        /* ── Left branding panel ──────────────────────── */
        .auth-panel-left {
            width: 42%;
            background: linear-gradient(145deg, #3b5bdb 0%, #1971c2 55%, #0c4a6e 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px 52px;
            position: relative;
            overflow: hidden;
        }
        .auth-panel-left::before {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: rgba(255,255,255,.06);
            top: -130px; right: -130px;
            pointer-events: none;
        }
        .auth-panel-left::after {
            content: '';
            position: absolute;
            width: 280px; height: 280px;
            border-radius: 50%;
            background: rgba(255,255,255,.05);
            bottom: -90px; left: -70px;
            pointer-events: none;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 60px;
            position: relative;
            z-index: 1;
        }
        .brand-logo .icon-wrap {
            width: 50px; height: 50px;
            background: rgba(255,255,255,.18);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
        }
        .brand-logo .icon-wrap i { color: #fff; font-size: 22px; }
        .brand-logo .brand-name {
            font-size: 20px;
            font-weight: 800;
            color: #fff;
            letter-spacing: 1.5px;
            line-height: 1.2;
        }
        .brand-logo .brand-name small {
            display: block;
            font-size: 10px;
            font-weight: 400;
            letter-spacing: 3px;
            opacity: .65;
            text-transform: uppercase;
        }

        .panel-headline {
            font-size: 30px;
            font-weight: 800;
            color: #fff;
            line-height: 1.3;
            margin-bottom: 14px;
            position: relative; z-index: 1;
        }
        .panel-headline span { color: #93c5fd; }

        .panel-sub {
            color: rgba(255,255,255,.72);
            font-size: 14.5px;
            line-height: 1.65;
            margin-bottom: 48px;
            position: relative; z-index: 1;
        }

        .feature-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 16px;
            position: relative; z-index: 1;
        }
        .feature-list li {
            display: flex;
            align-items: center;
            gap: 14px;
            color: rgba(255,255,255,.88);
            font-size: 14px;
        }
        .feature-list li .feat-icon {
            width: 36px; height: 36px;
            background: rgba(255,255,255,.12);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .feature-list li .feat-icon i { color: #93c5fd; font-size: 14px; }

        .panel-copy {
            margin-top: auto;
            padding-top: 52px;
            font-size: 11.5px;
            color: rgba(255,255,255,.38);
            position: relative; z-index: 1;
        }

        /* ── Right form panel ─────────────────────────── */
        .auth-panel-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px 40px;
            background: #fff;
        }

        .auth-form-box {
            width: 100%;
            max-width: 400px;
        }

        .form-eyebrow {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #4c6ef5;
            margin-bottom: 8px;
        }
        .form-title {
            font-size: 28px;
            font-weight: 800;
            color: #1a1a2e;
            margin-bottom: 6px;
        }
        .form-subtitle {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 32px;
        }
        .form-subtitle a {
            color: #4c6ef5;
            text-decoration: none;
            font-weight: 600;
        }
        .form-subtitle a:hover { text-decoration: underline; }

        /* Fields */
        .field-group { margin-bottom: 20px; }
        .field-label {
            display: block;
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: #374151;
            margin-bottom: 7px;
        }
        .field-wrap { position: relative; }
        .field-wrap .field-icon {
            position: absolute;
            left: 14px; top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 14px;
            pointer-events: none;
        }
        .field-wrap input {
            width: 100%;
            padding: 11px 42px 11px 42px;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            font-size: 14.5px;
            color: #1a1a2e;
            background: #fafafa;
            transition: border-color .2s, box-shadow .2s, background .2s;
            outline: none;
        }
        .field-wrap input:focus {
            border-color: #4c6ef5;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(76,110,245,.12);
        }
        .field-wrap input::placeholder { color: #c4c9d4; }
        .field-wrap input.is-invalid {
            border-color: #f87171;
            background: #fff8f8;
        }
        .field-wrap input.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(248,113,113,.12);
        }

        .toggle-pw {
            position: absolute;
            right: 12px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            color: #9ca3af;
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            transition: color .2s;
            line-height: 1;
        }
        .toggle-pw:hover { color: #4c6ef5; }

        .password-hint {
            font-size: 11.5px;
            color: #9ca3af;
            margin-top: 6px;
        }

        /* Meta row (remember + forgot) */
        .form-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
            font-size: 13px;
        }
        .form-meta label { color: #4b5563; cursor: pointer; user-select: none; }
        .form-meta a { color: #4c6ef5; text-decoration: none; }
        .form-meta a:hover { text-decoration: underline; }
        .form-check-input:checked { background-color: #4c6ef5; border-color: #4c6ef5; }

        /* Submit button */
        .btn-auth {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #4c6ef5, #3b5bdb);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: transform .15s, box-shadow .2s;
            box-shadow: 0 4px 14px rgba(76,110,245,.35);
            letter-spacing: .3px;
        }
        .btn-auth:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(76,110,245,.45);
        }
        .btn-auth:active { transform: translateY(0); }
        .btn-auth i { margin-right: 8px; }

        /* Divider */
        .auth-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 22px 0;
            color: #d1d5db;
            font-size: 12px;
        }
        .auth-divider::before, .auth-divider::after {
            content: ''; flex: 1;
            height: 1px; background: #f0f0f0;
        }

        .back-home {
            text-align: center;
            font-size: 13px;
        }
        .back-home a {
            color: #6b7280;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: color .2s;
        }
        .back-home a:hover { color: #4c6ef5; }

        /* Alerts */
        .auth-alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 14px;
            border-radius: 9px;
            font-size: 13.5px;
            margin-bottom: 22px;
        }
        .auth-alert.danger  { background: #fff0f0; color: #b91c1c; border: 1px solid #fecaca; }
        .auth-alert.success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }

        /* ── Mobile brand header (hidden on desktop) ──── */
        .mobile-brand-header { display: none; }

        /* ── Responsive ───────────────────────────────── */
        @media (max-width: 768px) {
            .auth-wrapper { flex-direction: column; min-height: 100vh; }
            .auth-panel-left { display: none; }

            .auth-panel-right {
                padding: 0 0 48px;
                justify-content: flex-start;
                align-items: stretch;
            }

            .mobile-brand-header {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 6px;
                background: linear-gradient(135deg, #3b5bdb, #1971c2);
                padding: 30px 24px 36px;
                text-align: center;
            }
            .mobile-brand-header .mob-icon {
                width: 52px; height: 52px;
                background: rgba(255,255,255,.18);
                border-radius: 16px;
                display: flex; align-items: center; justify-content: center;
                margin-bottom: 8px;
            }
            .mobile-brand-header .mob-icon i { color: #fff; font-size: 24px; }
            .mobile-brand-header .mob-name {
                font-size: 18px; font-weight: 800;
                color: #fff; letter-spacing: 1.5px;
            }
            .mobile-brand-header .mob-tagline {
                font-size: 12px;
                color: rgba(255,255,255,.65);
                letter-spacing: .5px;
            }

            .auth-panel-right { background: #f0f4ff; }

            .auth-form-box {
                max-width: 100%;
                background: #fff;
                border-radius: 16px;
                padding: 28px 22px;
                box-shadow: 0 2px 16px rgba(0,0,0,.07);
                margin: 24px 16px 0;
            }

            .form-title { font-size: 22px; }
        }
    </style>
</head>
<body>
