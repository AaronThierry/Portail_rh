<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tableau de bord') - Portail RH+</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/apple-touch-icon-180x180.png') }}">

    <!-- PWA -->
    <link rel="manifest" href="{{ asset('build/manifest.webmanifest') }}">
    <meta name="theme-color" content="#2563EB">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/images/pwa-192x192.png') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Portail RH+">

    <!-- Polices — Syne (titres) · DM Sans (texte) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

    <!-- Thème appliqué avant l'affichage (évite le flash clair → sombre) -->
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

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @php $rhAssetV = fn ($f) => @filemtime(public_path($f)) ?: '1'; @endphp
    <!-- Composants rh-* (Direction B) -->
    <link rel="stylesheet" href="{{ asset('assets/css/rh-admin.css') }}?v={{ $rhAssetV('assets/css/rh-admin.css') }}">
    <!-- Cadre admin : barre latérale + barre du haut -->
    <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}?v={{ $rhAssetV('assets/css/sidebar.css') }}">
    <!-- Fenêtres des pages historiques -->
    <link rel="stylesheet" href="{{ asset('assets/css/modal.css') }}?v={{ $rhAssetV('assets/css/modal.css') }}">

    @yield('styles')
</head>
<body class="h-full font-sans antialiased">
    @include('partials.app-loader')
    @include('partials.pin-gate')

    <div class="app-layout">
        @include('partials.sidebar')

        @include('partials.header')

        <div class="main-content" id="mainContent">
            <main class="app-main" id="contenu">
                <div class="main-container">
                    @yield('content')
                </div>
            </main>

            @include('partials.footer')
        </div>
    </div>

    <script>
    /* Petits comportements partagés des pages « rh-* » :
       data-open="id" / data-close  → ouvre / ferme une fenêtre .rh-sheet
       data-confirm="Question ?"    → demande confirmation avant d'envoyer un formulaire
       data-lock                    → désactive le bouton d'envoi pendant l'envoi */
    (function () {
        var lastTrigger = null;
        window.rhOpen = function (id, trigger) {
            var s = document.getElementById(id);
            if (!s) return;
            lastTrigger = trigger || document.activeElement;
            s.classList.add('open');
            document.body.style.overflow = 'hidden';
            var f = s.querySelector('[autofocus], textarea, input:not([type=hidden]), select');
            if (f) setTimeout(function () { f.focus(); }, 30);
        };
        window.rhClose = function (el) {
            var s = el && el.closest ? el.closest('.rh-sheet') : document.getElementById(el);
            if (!s) return;
            s.classList.remove('open');
            if (!document.querySelector('.rh-sheet.open')) document.body.style.overflow = '';
            if (lastTrigger && lastTrigger.focus) lastTrigger.focus();
        };
        document.addEventListener('click', function (e) {
            var o = e.target.closest('[data-open]');
            if (o) { e.preventDefault(); rhOpen(o.getAttribute('data-open'), o); return; }
            var c = e.target.closest('[data-close]');
            if (c) { e.preventDefault(); rhClose(c); return; }
            if (e.target.classList && e.target.classList.contains('rh-sheet')) rhClose(e.target);
        });
        document.addEventListener('keydown', function (e) {
            if (e.key !== 'Escape') return;
            var open = document.querySelectorAll('.rh-sheet.open');
            if (open.length) rhClose(open[open.length - 1]);
        });
        document.addEventListener('submit', function (e) {
            var f = e.target;
            var q = f.getAttribute('data-confirm');
            if (q && !window.confirm(q)) { e.preventDefault(); e.stopPropagation(); return; }
            if (f.hasAttribute('data-lock')) {
                var b = f.querySelector('[type=submit]') || (f.id ? document.querySelector('[type=submit][form="' + f.id + '"]') : null);
                if (b) { setTimeout(function () { b.disabled = true; }, 0); }
            }
        }, true);
        document.addEventListener('DOMContentLoaded', function () {
            var a = document.querySelector('.rh-sheet[data-autoopen]');
            if (a) rhOpen(a.id);
        });
    })();
    </script>

    @yield('scripts')
</body>
</html>
