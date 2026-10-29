<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#ffffff">
    <title>@yield('title') — Portail RH+</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/apple-touch-icon-180x180.png') }}">
    <link rel="manifest" href="{{ asset('build/manifest.webmanifest') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Portail RH+">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">
    <style>
    /* ═══════════════════════════════════════════════════════════════
       Portail RH+ — pages d'authentification (charte « Direction B »)
       Bleu = action · Orange = touche de marque (le « + », aujourd'hui)
       ═══════════════════════════════════════════════════════════════ */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; -webkit-tap-highlight-color: transparent; touch-action: manipulation; }

    :root {
        --brand:      #2563eb;
        --brand-dk:   #1d4ed8;
        --brand-soft: #dbeafe;
        --orange:     #ea580c;
        --orange-bg:  #fff7ed;
        --orange-tx:  #9a3412;
        --ink:        #0f172a;
        --ink-2:      #475569;
        --muted:      #475569;
        --line:       #cbd5e1;
        --line-soft:  #e2e8f0;
        --page:       #f8fafc;
        --red:        #dc2626;
        --red-bg:     #fef2f2;
        --red-tx:     #991b1b;
        --green:      #16a34a;
        --green-bg:   #ecfdf5;
        --green-tx:   #065f46;
    }

    html { overscroll-behavior-y: none; color-scheme: light; background: #ffffff; }
    body {
        font-family: 'DM Sans', system-ui, sans-serif;
        color: var(--ink);
        background: #ffffff;
        min-height: 100vh; min-height: 100dvh;
        display: grid; grid-template-columns: 1fr;
    }

    /* ── Frise de l'année ─────────────────────────────────────────── */
    .year { display: grid; grid-template-columns: repeat(12, minmax(0, 1fr)); gap: 5px; }
    .year-m { display: flex; flex-direction: column; gap: 2px; }
    .year-m span { display: block; height: 2px; border-radius: 2px; background: var(--line-soft); }
    .year-m span.p  { background: var(--line); }
    .year-m span.w  { background: #f1f5f9; }
    .year-m span.pw { background: var(--line-soft); }
    .year-m span.t  { background: var(--orange); }
    .year-lbl { display: none; font-style: normal; }

    /* ── Marque ───────────────────────────────────────────────────── */
    .logo {
        font-family: 'Syne', sans-serif; font-weight: 800;
        font-size: 34px; line-height: 38px; letter-spacing: -0.03em;
        color: var(--ink); text-decoration: none;
    }
    .logo b { font-weight: 800; color: var(--orange); }
    .logo-sm { font-size: 22px; line-height: 28px; }

    .brand-side { display: none; }

    /* ── Colonne principale ───────────────────────────────────────── */
    .auth {
        display: flex; flex-direction: column; gap: 32px;
        padding: max(32px, calc(env(safe-area-inset-top) + 20px)) 24px max(24px, calc(env(safe-area-inset-bottom) + 16px));
        min-height: 100vh; min-height: 100dvh;
    }
    .intro { display: flex; flex-direction: column; gap: 10px; }
    .intro h1 { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 28px; line-height: 34px; letter-spacing: -0.02em; }
    .intro p  { font-size: 16px; line-height: 24px; color: var(--ink-2); max-width: 38ch; }
    .intro .is-home-title { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0 0 0 0); white-space: nowrap; }
    .intro.home p { font-size: 17px; line-height: 26px; }

    form.stack { display: flex; flex-direction: column; gap: 16px; flex-grow: 1; }

    /* ── Champs ───────────────────────────────────────────────────── */
    .field { display: flex; flex-direction: column; gap: 6px; }
    .field > label, .label { font-size: 14px; font-weight: 600; }
    .hint { font-size: 13px; line-height: 18px; color: var(--muted); }
    .field-err { font-size: 13px; line-height: 18px; color: var(--red); font-weight: 600; display: none; }
    .field-err.show { display: block; }

    .input {
        width: 100%; height: 54px; padding: 0 16px;
        font: 400 16px/1 'DM Sans', system-ui, sans-serif;   /* 16px : pas de zoom auto sur iOS */
        color: var(--ink); background: #ffffff;
        border: 1.5px solid var(--line); border-radius: 16px; outline: none;
        transition: border-color .15s, box-shadow .15s;
    }
    .input::placeholder { color: #94a3b8; }
    .input:focus { border-color: var(--brand); box-shadow: 0 0 0 4px var(--brand-soft); }
    .input[aria-invalid="true"] { border-color: var(--red); }
    .input[aria-invalid="true"]:focus { box-shadow: 0 0 0 4px #fee2e2; }

    .pwd { position: relative; }
    .pwd .input { padding-right: 56px; }
    .eye {
        position: absolute; right: 5px; top: 5px; width: 44px; height: 44px;
        border: 0; border-radius: 999px; background: transparent;
        display: flex; align-items: center; justify-content: center;
        color: var(--ink-2); cursor: pointer;
    }
    .eye svg { width: 20px; height: 20px; }
    .caps { display: none; font-size: 13px; color: var(--orange); font-weight: 600; }
    .caps.on { display: block; }

    /* ── Code à 6 chiffres ────────────────────────────────────────── */
    .otp { display: grid; grid-template-columns: repeat(6, minmax(0, 1fr)); gap: 8px; }
    .otp input {
        width: 100%; height: 60px; text-align: center;
        font: 600 24px/1 'DM Sans', system-ui, sans-serif; color: var(--ink);
        background: #ffffff; border: 1.5px solid var(--line); border-radius: 14px; outline: none;
        transition: border-color .15s, box-shadow .15s;
    }
    .otp input:focus { border-color: var(--brand); box-shadow: 0 0 0 4px var(--brand-soft); }
    .otp input.filled { border-color: var(--ink); }
    .otp.error input { border-color: var(--red); }
    .otp-single {
        width: 100%; height: 64px; text-align: center;
        font: 600 30px/1 'DM Sans', system-ui, sans-serif; letter-spacing: .5em; text-indent: .5em;
        color: var(--ink); background: #ffffff;
        border: 1.5px solid var(--line); border-radius: 16px; outline: none;
    }
    .otp-single::placeholder { color: var(--line); }
    .otp-single:focus { border-color: var(--brand); box-shadow: 0 0 0 4px var(--brand-soft); }
    .otp-single[aria-invalid="true"] { border-color: var(--red); }

    /* ── Force du mot de passe ────────────────────────────────────── */
    .meter { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 4px; margin-top: 4px; }
    .meter i { display: block; height: 4px; border-radius: 4px; background: var(--line-soft); }
    .meter[data-level="1"] i:nth-child(-n+1) { background: var(--red); }
    .meter[data-level="2"] i:nth-child(-n+2) { background: var(--orange); }
    .meter[data-level="3"] i:nth-child(-n+3) { background: #ca8a04; }
    .meter[data-level="4"] i:nth-child(-n+4) { background: var(--green); }
    .meter-lbl { font-size: 13px; color: var(--muted); min-height: 18px; }

    .reqs { list-style: none; display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 6px 16px; }
    .reqs li { display: flex; align-items: center; gap: 8px; font-size: 13px; line-height: 18px; color: var(--muted); }
    .reqs li::before { content: ''; width: 16px; height: 16px; flex-shrink: 0; border-radius: 999px; box-shadow: inset 0 0 0 1.5px var(--line); }
    .reqs li.ok { color: var(--green-tx); }
    .reqs li.ok::before { box-shadow: none; background: var(--green) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='3.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M5 12l5 5L20 7'/%3E%3C/svg%3E") center/10px no-repeat; }

    /* ── Messages ─────────────────────────────────────────────────── */
    .alert { display: flex; gap: 10px; align-items: flex-start; padding: 12px 14px; border-radius: 14px; font-size: 14px; line-height: 20px; font-weight: 500; }
    .alert svg { width: 18px; height: 18px; flex-shrink: 0; margin-top: 1px; }
    .alert-err  { background: var(--red-bg);    color: var(--red-tx); }
    .alert-ok   { background: var(--green-bg);  color: var(--green-tx); }
    .alert-warn { background: var(--orange-bg); color: var(--orange-tx); }
    .alert-info { background: var(--page);      color: var(--ink-2); }

    .chip {
        display: inline-flex; align-items: center; gap: 8px; align-self: flex-start;
        max-width: 100%; height: 36px; padding: 0 14px; border-radius: 999px;
        background: #f1f5f9; font-size: 14px; font-weight: 600; color: var(--ink);
        overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    }
    .chip svg { width: 16px; height: 16px; color: var(--muted); flex-shrink: 0; }

    /* ── Liens et boutons ─────────────────────────────────────────── */
    .row { display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
    .check { display: flex; align-items: center; gap: 10px; min-height: 44px; font-size: 14px; color: var(--ink-2); cursor: pointer; }
    .check input { width: 20px; height: 20px; accent-color: var(--brand); cursor: pointer; }

    .link, .text-btn {
        font: 600 14px/1.4 'DM Sans', system-ui, sans-serif;
        color: var(--brand); text-decoration: none;
        background: none; border: 0; padding: 10px 0; cursor: pointer;
    }
    .link:hover, .text-btn:hover { color: var(--brand-dk); text-decoration: underline; }
    .text-btn[disabled] { color: var(--muted); cursor: default; text-decoration: none; }

    .back { display: inline-flex; align-items: center; gap: 6px; align-self: flex-start; }
    .back svg { width: 16px; height: 16px; }

    .spacer { flex-grow: 1; min-height: 8px; }
    .submit {
        width: 100%; height: 56px; border: 0; border-radius: 999px;
        background: var(--brand); color: #ffffff;
        font: 700 16px/1 'DM Sans', system-ui, sans-serif; cursor: pointer;
        transition: background .15s;
    }
    .submit:hover { background: var(--brand-dk); }
    .submit[disabled] { opacity: .7; cursor: progress; }
    .help { font-size: 13px; line-height: 19px; color: var(--muted); text-align: center; margin-top: 14px; }
    .center { text-align: center; }

    :focus-visible { outline: 2px solid var(--brand); outline-offset: 2px; }
    .input:focus-visible, .otp input:focus-visible, .otp-single:focus-visible { outline: none; }

    /* ── Ordinateur : deux colonnes ───────────────────────────────── */
    @media (min-width: 1024px) {
        body { grid-template-columns: minmax(0, 1.1fr) minmax(460px, 1fr); }
        .brand-side {
            display: flex; flex-direction: column; justify-content: space-between; gap: 48px;
            background: var(--page); border-right: 1px solid var(--line-soft);
            padding: 56px clamp(40px, 6vw, 96px);
            position: sticky; top: 0; height: 100vh;
        }
        .brand-side .logo { font-size: 28px; line-height: 32px; }
        .brand-side h2 {
            font-family: 'Syne', sans-serif; font-weight: 700;
            font-size: clamp(36px, 3.4vw, 48px); line-height: 1.08; letter-spacing: -0.03em; max-width: 14ch;
        }
        .brand-side .year { gap: 10px; }
        .brand-side .year-m span { height: 6px; }
        .brand-side .year-lbl { display: block; font-size: 13px; color: var(--muted); margin-bottom: 6px; }
        .brand-side .year-lbl.now { color: var(--ink); font-weight: 700; }
        .brand-side small { font-size: 14px; color: var(--muted); }

        .auth { justify-content: center; max-width: 460px; width: 100%; margin: 0 auto; padding: 56px 32px; }
        .auth > .year, .auth .mobile-only { display: none; }
        form.stack { flex-grow: 0; }
        .spacer { display: none; }
        .intro .is-home-title { position: static; width: auto; height: auto; overflow: visible; clip: auto; white-space: normal; }
    }

    @media (prefers-reduced-motion: reduce) { * { transition: none !important; } }
    </style>
    @stack('styles')
</head>
<body>

    @yield('before')

    <aside class="brand-side" aria-hidden="true">
        <span class="logo">Portail RH<b>+</b></span>
        <h2>Votre année de travail, au même endroit.</h2>
        @include('partials.auth-year', ['labels' => true])
        <small>Congés, absences, bulletins de paie et documents RH.</small>
    </aside>

    <main class="auth">
        @hasSection('home')
            @include('partials.auth-year', ['labels' => false])
        @else
            <span class="logo logo-sm mobile-only">Portail RH<b>+</b></span>
        @endif

        <div class="intro @hasSection('home') home @endif">
            @hasSection('home')
                <span class="logo mobile-only">Portail RH<b>+</b></span>
                <h1 class="is-home-title">@yield('heading')</h1>
            @else
                <h1>@yield('heading')</h1>
            @endif
            @hasSection('lead')
                <p>@yield('lead')</p>
            @endif
        </div>

        @yield('content')
    </main>

    @stack('scripts')

    <script>
    (function () {
        var eyeOpen = '<path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/>';
        var eyeOff  = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';

        // Afficher / masquer un mot de passe : <button data-toggle-pwd="idDuChamp">
        document.querySelectorAll('[data-toggle-pwd]').forEach(function (btn) {
            var input = document.getElementById(btn.getAttribute('data-toggle-pwd'));
            if (!input) return;
            btn.addEventListener('click', function () {
                var show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                btn.setAttribute('aria-pressed', show ? 'true' : 'false');
                btn.setAttribute('aria-label', show ? 'Masquer le mot de passe' : 'Afficher le mot de passe');
                btn.querySelector('svg').innerHTML = show ? eyeOff : eyeOpen;
                input.focus();
            });
        });

        // Avertissement « Majuscules activées » : <span class="caps" data-caps-for="idDuChamp">
        document.querySelectorAll('[data-caps-for]').forEach(function (warn) {
            var input = document.getElementById(warn.getAttribute('data-caps-for'));
            if (!input) return;
            function check(e) { if (e.getModifierState) warn.classList.toggle('on', e.getModifierState('CapsLock')); }
            input.addEventListener('keydown', check);
            input.addEventListener('keyup', check);
            input.addEventListener('blur', function () { warn.classList.remove('on'); });
        });

        // Focus automatique : sur ordinateur seulement, sauf data-autofocus="always" (saisie de code)
        var af = document.querySelector('[data-autofocus]');
        if (af && (af.getAttribute('data-autofocus') === 'always' || window.matchMedia('(min-width: 1024px)').matches)) {
            af.focus();
        }

        // Bouton verrouillé pendant l'envoi : <form data-lock="Texte pendant l'envoi…">
        // (écouteur ajouté après ceux des pages : il respecte leurs propres validations)
        document.querySelectorAll('form[data-lock]').forEach(function (form) {
            var btn = form.querySelector('.submit');
            if (!btn) return;
            var label = btn.textContent;
            form.addEventListener('submit', function (e) {
                if (e.defaultPrevented) return;
                btn.disabled = true;
                btn.textContent = form.getAttribute('data-lock');
            });
            window.addEventListener('pageshow', function () { btn.disabled = false; btn.textContent = label; });
        });
    })();
    </script>
</body>
</html>
