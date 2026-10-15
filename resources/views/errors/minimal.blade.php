<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Erreur' }} — Portail RH+</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand: #2563eb; --brand-dk: #1d4ed8; --brand-bg: #eff6ff;
            --ink: #0f172a; --muted: #475569; --faint: #94a3b8;
            --line-soft: #e2e8f0; --page: #f8fafc; --surface: #ffffff;
            --font: 'DM Sans', system-ui, -apple-system, sans-serif;
            --display: 'Syne', 'DM Sans', sans-serif;
        }
        html.dark {
            color-scheme: dark;
            --ink: #f8fafc; --muted: #a8b6ca; --faint: #7489a6;
            --line-soft: #2f3e5c; --page: #060a13; --surface: #202d47;
            --brand: #3b82f6; --brand-dk: #60a5fa; --brand-bg: rgba(59,130,246,.14);
        }
        html { color-scheme: light; background: var(--page); }
        body {
            margin: 0; min-height: 100vh; background: var(--page); color: var(--ink);
            font-family: var(--font); -webkit-font-smoothing: antialiased;
            display: flex; align-items: center; justify-content: center; padding: 24px;
        }
        .err-card {
            width: 100%; max-width: 440px; background: var(--surface);
            border-radius: 24px; box-shadow: 0 1px 2px rgba(15,23,42,.05), 0 0 0 1px var(--line-soft);
            padding: 40px 32px; text-align: center;
        }
        .err-ico {
            width: 56px; height: 56px; margin: 0 auto 20px; border-radius: 16px;
            background: var(--brand-bg); color: var(--brand);
            display: flex; align-items: center; justify-content: center;
        }
        .err-ico svg { width: 28px; height: 28px; }
        .err-code { font-family: var(--display); font-weight: 700; font-size: 13px; letter-spacing: .1em; color: var(--faint); margin: 0 0 8px; text-transform: uppercase; }
        .err-title { font-family: var(--display); font-weight: 800; font-size: 24px; line-height: 1.3; margin: 0 0 10px; letter-spacing: -0.01em; }
        .err-text { font-size: 15px; line-height: 1.55; color: var(--muted); margin: 0 0 28px; }
        .err-actions { display: flex; flex-direction: column; gap: 10px; }
        .err-btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            height: 48px; padding: 0 22px; border-radius: 999px; border: 0; cursor: pointer;
            font: 700 15px var(--font); text-decoration: none; white-space: nowrap;
            background: var(--brand); color: #fff; transition: background .15s;
        }
        .err-btn:hover { background: var(--brand-dk); }
        .err-btn.ghost { background: transparent; color: var(--ink); box-shadow: inset 0 0 0 1.5px var(--line-soft); }
        .err-btn.ghost:hover { background: var(--page); }
    </style>
    <script>
        (function () {
            try {
                var t = localStorage.getItem('theme');
                if (t === 'dark' || (!t && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                }
            } catch (e) {}
        })();
    </script>
</head>
<body>
    <div class="err-card">
        <div class="err-ico" aria-hidden="true">{!! $icon ?? '' !!}</div>
        <p class="err-code">Erreur {{ $code ?? '' }}</p>
        <h1 class="err-title">{{ $title ?? 'Une erreur est survenue' }}</h1>
        <p class="err-text">{{ $message ?? "Quelque chose s'est mal passé. L'équipe technique a été informée." }}</p>
        <div class="err-actions">
            <a href="{{ url('/') }}" class="err-btn">Retour à l'accueil</a>
            <a href="javascript:location.reload()" class="err-btn ghost">Réessayer</a>
        </div>
    </div>
</body>
</html>
