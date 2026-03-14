<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mon Espace') - Portail RH+</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/logo.png') }}">

    <!-- Theme init — prevent FOUC -->
    <script>(function(){var t=localStorage.getItem('theme');if(t==='dark'){document.documentElement.classList.add('dark');}})();</script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
    /* ═══════════════════════════════════════════════════════
       PORTAIL RH+  ·  ESPACE EMPLOYÉ  ·  Obsidian Ember
       Plus Jakarta Sans  ×  Outfit
       ═══════════════════════════════════════════════════════ */

    :root {
        /* ── Brand ── */
        --o:         #f97316;
        --o-dim:     rgba(249,115,22,.09);
        --o-hi:      rgba(249,115,22,.16);
        --o-glow:    rgba(249,115,22,.28);
        --o-600:     #ea580c;
        --o-100:     #ffedd5;

        /* ── Semantic ── */
        --green:     #22c55e;
        --green-dim: rgba(34,197,94,.1);
        --blue:      #3b82f6;
        --blue-dim:  rgba(59,130,246,.1);
        --red:       #ef4444;
        --red-dim:   rgba(239,68,68,.1);
        --amber:     #f59e0b;

        /* ── Light Mode ── */
        --bg:       #f1f3f7;
        --surface:  #ffffff;
        --surface-2:#f8f9fb;
        --border:   #e4e7ec;
        --border-2: #f0f2f5;
        --text:     #111827;
        --text-2:   #6b7280;
        --text-3:   #9ca3af;

        /* ── Shadows ── */
        --shadow-sm: 0 1px 2px rgba(0,0,0,.05);
        --shadow:    0 1px 4px rgba(0,0,0,.07), 0 1px 2px rgba(0,0,0,.04);
        --shadow-md: 0 4px 10px rgba(0,0,0,.08), 0 2px 4px rgba(0,0,0,.04);
        --shadow-lg: 0 12px 28px rgba(0,0,0,.1), 0 4px 8px rgba(0,0,0,.04);
        --shadow-xl: 0 24px 48px rgba(0,0,0,.12), 0 8px 16px rgba(0,0,0,.05);

        /* ── Layout ── */
        --sidebar-w: 64px;
        --header-h:  54px;
        --font:      'Plus Jakarta Sans', system-ui, sans-serif;
        --font-d:    'Outfit', 'Plus Jakarta Sans', system-ui, sans-serif;

        /* ── Radius ── */
        --r:   8px;
        --r-sm:6px;
        --r-lg:12px;
    }

    /* ── DARK MODE ── */
    .dark {
        color-scheme: dark;
        --bg:       #0c0e14;
        --surface:  #141720;
        --surface-2:#1a1e2b;
        --border:   rgba(255,255,255,.07);
        --border-2: rgba(255,255,255,.04);
        --text:     #e2e8f0;
        --text-2:   #64748b;
        --text-3:   #334155;
        --shadow-sm: 0 1px 2px rgba(0,0,0,.3);
        --shadow:    0 2px 6px rgba(0,0,0,.4);
        --shadow-md: 0 6px 16px rgba(0,0,0,.4);
        --shadow-lg: 0 16px 36px rgba(0,0,0,.5);
        --shadow-xl: 0 28px 56px rgba(0,0,0,.6);
        --o-100:     rgba(249,115,22,.12);
    }

    /* ── Keyframes ── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-6px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ── Reset ── */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        font-family: var(--font);
        background: var(--bg);
        color: var(--text);
        min-height: 100vh;
        font-size: .9375rem;
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
        overflow-x: hidden;
    }

    /* ═══════════════════════════════════════
       LAYOUT
    ═══════════════════════════════════════ */
    .ee-layout {
        display: flex;
        min-height: 100vh;
    }

    /* ═══════════════════════════════════════
       SIDEBAR  —  Icon Rail  (always dark)
    ═══════════════════════════════════════ */
    .ee-sidebar {
        width: var(--sidebar-w);
        background: #080a0f;
        border-right: 1px solid rgba(255,255,255,.04);
        position: fixed;
        top: 0; left: 0; bottom: 0;
        z-index: 100;
        display: flex;
        flex-direction: column;
        align-items: center;
        overflow: visible; /* allow tooltip overflow */
        transition: transform .3s cubic-bezier(.4,0,.2,1);
    }

    /* ── Brand logo ── */
    .ee-sidebar-brand {
        width: 64px;
        height: 62px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-bottom: 1px solid rgba(255,255,255,.05);
    }

    .ee-brand-logo {
        width: 34px; height: 34px;
        background: var(--o);
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        box-shadow: 0 2px 12px rgba(249,115,22,.35);
        flex-shrink: 0;
    }
    .ee-brand-logo svg { width: 18px; height: 18px; }

    /* ── User avatar ── */
    .ee-sidebar-user {
        width: 64px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-bottom: 1px solid rgba(255,255,255,.04);
    }

    .ee-user-avatar {
        width: 32px; height: 32px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(255,255,255,.1);
        transition: border-color .2s;
        display: block;
    }
    .ee-sidebar-user:hover .ee-user-avatar { border-color: var(--o); }

    /* ── Navigation ── */
    .ee-sidebar-nav {
        flex: 1;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 10px 0 6px;
        overflow: visible;
    }

    .ee-nav-section {
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 2px;
    }

    /* Section separator line */
    .ee-nav-title {
        width: 22px;
        height: 1px;
        background: rgba(255,255,255,.07);
        margin: 7px 0;
        font-size: 0; /* hide text */
        flex-shrink: 0;
    }

    /* Nav link — icon only */
    .ee-nav-link {
        position: relative;
        width: 40px; height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255,255,255,.3);
        text-decoration: none;
        font-size: 0; /* hide text labels */
        transition: background .14s, color .14s, box-shadow .14s;
        margin-bottom: 1px;
        flex-shrink: 0;
    }

    .ee-nav-link svg {
        width: 18px; height: 18px;
        flex-shrink: 0;
        transition: color .14s;
    }

    .ee-nav-link:hover {
        background: rgba(255,255,255,.06);
        color: rgba(255,255,255,.7);
    }

    .ee-nav-link.active {
        background: rgba(249,115,22,.11);
        color: #f97316;
        box-shadow: inset 2px 0 0 #f97316;
    }

    /* Tooltip via ::after */
    .ee-nav-link::after {
        content: attr(data-tooltip);
        position: absolute;
        left: calc(100% + 11px);
        top: 50%;
        transform: translateY(-50%) translateX(-5px);
        background: #1a1e2b;
        color: #e2e8f0;
        font-size: .72rem;
        font-weight: 600;
        font-family: var(--font);
        white-space: nowrap;
        padding: 5px 10px;
        border-radius: 6px;
        border: 1px solid rgba(255,255,255,.09);
        box-shadow: 0 6px 16px rgba(0,0,0,.5);
        pointer-events: none;
        opacity: 0;
        transition: opacity .15s, transform .15s;
        z-index: 999;
    }

    .ee-nav-link:hover::after {
        opacity: 1;
        transform: translateY(-50%) translateX(0);
    }

    /* ── Sidebar Footer ── */
    .ee-sidebar-footer {
        width: 64px;
        padding: 8px 0 14px;
        border-top: 1px solid rgba(255,255,255,.04);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 3px;
        flex-shrink: 0;
    }

    .ee-btn-icon {
        position: relative;
        width: 40px; height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255,255,255,.28);
        background: transparent;
        border: none;
        cursor: pointer;
        transition: background .14s, color .14s;
        text-decoration: none;
        font-size: 0;
    }
    .ee-btn-icon svg { width: 17px; height: 17px; flex-shrink: 0; }
    .ee-btn-icon:hover { background: rgba(255,255,255,.06); color: rgba(255,255,255,.65); }
    .ee-btn-icon.danger:hover { background: rgba(239,68,68,.1); color: #ef4444; }

    /* Tooltip on footer icons */
    .ee-btn-icon::after {
        content: attr(data-tooltip);
        position: absolute;
        left: calc(100% + 11px);
        top: 50%;
        transform: translateY(-50%) translateX(-5px);
        background: #1a1e2b;
        color: #e2e8f0;
        font-size: .72rem;
        font-weight: 600;
        font-family: var(--font);
        white-space: nowrap;
        padding: 5px 10px;
        border-radius: 6px;
        border: 1px solid rgba(255,255,255,.09);
        box-shadow: 0 6px 16px rgba(0,0,0,.5);
        pointer-events: none;
        opacity: 0;
        transform: translateY(-50%) translateX(-5px);
        transition: opacity .15s, transform .15s;
        z-index: 999;
    }
    .ee-btn-icon:hover::after {
        opacity: 1;
        transform: translateY(-50%) translateX(0);
    }

    /* ═══════════════════════════════════════
       MAIN AREA
    ═══════════════════════════════════════ */
    .ee-main {
        flex: 1;
        margin-left: var(--sidebar-w);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    /* ═══════════════════════════════════════
       HEADER
    ═══════════════════════════════════════ */
    .ee-header {
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        padding: 0 1.5rem;
        height: var(--header-h);
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        z-index: 50;
        box-shadow: var(--shadow-sm);
        flex-shrink: 0;
    }

    .ee-header-left {
        display: flex;
        align-items: center;
        gap: .875rem;
    }

    /* Mobile toggle (hidden on desktop) */
    .ee-mobile-toggle {
        display: none;
        width: 36px; height: 36px;
        border: 1px solid var(--border);
        border-radius: var(--r-sm);
        background: var(--surface);
        color: var(--text-2);
        cursor: pointer;
        align-items: center;
        justify-content: center;
        transition: all .15s;
    }
    .ee-mobile-toggle:hover { background: var(--o-dim); border-color: var(--o); color: var(--o); }
    .ee-mobile-toggle svg { width: 18px; height: 18px; }

    .ee-page-info { display: flex; flex-direction: column; gap: 1px; }

    .ee-page-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--text);
        letter-spacing: -.01em;
        line-height: 1.2;
    }

    .ee-breadcrumb {
        display: flex;
        align-items: center;
        gap: .375rem;
        font-size: .72rem;
        color: var(--text-3);
    }
    .ee-breadcrumb a { color: var(--blue); text-decoration: none; font-weight: 500; }
    .ee-breadcrumb a:hover { text-decoration: underline; }
    .ee-breadcrumb svg { width: 9px; height: 9px; opacity: .45; }

    .ee-header-right {
        display: flex;
        align-items: center;
        gap: .375rem;
    }

    .ee-header-btn {
        position: relative;
        width: 34px; height: 34px;
        border: 1px solid var(--border);
        border-radius: var(--r-sm);
        background: var(--surface);
        color: var(--text-2);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all .15s;
    }
    .ee-header-btn:hover {
        background: var(--o-dim);
        border-color: rgba(249,115,22,.25);
        color: var(--o);
    }
    .ee-header-btn svg { width: 16px; height: 16px; }

    .ee-header-btn .badge {
        position: absolute;
        top: -5px; right: -5px;
        min-width: 16px; height: 16px;
        background: var(--red);
        color: #fff;
        font-size: .5rem;
        font-weight: 700;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 3px;
        border: 2px solid var(--surface);
    }

    /* Notification dot */
    .ee-notif-btn.has-notif::after {
        content: '';
        position: absolute;
        top: 7px; right: 7px;
        width: 7px; height: 7px;
        background: var(--red);
        border-radius: 50%;
        border: 1.5px solid var(--surface);
    }

    /* Theme toggle */
    .ee-theme-toggle {
        width: 34px; height: 34px;
        border: 1px solid var(--border);
        border-radius: var(--r-sm);
        background: var(--surface);
        color: var(--text-2);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all .15s;
        position: relative;
        overflow: hidden;
    }
    .ee-theme-toggle:hover { background: var(--o-dim); border-color: rgba(249,115,22,.25); color: var(--o); }
    .dark .ee-theme-toggle:hover { background: rgba(59,130,246,.08); border-color: rgba(59,130,246,.2); color: #60a5fa; }

    .ee-theme-toggle .sun-icon,
    .ee-theme-toggle .moon-icon {
        position: absolute;
        width: 16px; height: 16px;
        transition: all .4s cubic-bezier(.34,1.56,.64,1);
    }
    .ee-theme-toggle .sun-icon  { opacity: 1;  transform: rotate(0) scale(1);       color: var(--o); }
    .ee-theme-toggle .moon-icon { opacity: 0;  transform: rotate(-90deg) scale(.5); color: #60a5fa; }
    .dark .ee-theme-toggle .sun-icon  { opacity: 0; transform: rotate(90deg) scale(.5); }
    .dark .ee-theme-toggle .moon-icon { opacity: 1; transform: rotate(0) scale(1); }

    /* Header avatar */
    .ee-header-avatar {
        position: relative;
        display: flex;
        align-items: center;
        text-decoration: none;
        margin-left: .25rem;
    }
    .ee-header-avatar img {
        width: 30px; height: 30px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--border);
        transition: border-color .15s;
        display: block;
    }
    .ee-header-avatar:hover img { border-color: var(--o); }
    .ee-header-avatar-status {
        position: absolute;
        bottom: -1px; right: -1px;
        width: 8px; height: 8px;
        background: var(--green);
        border: 2px solid var(--surface);
        border-radius: 50%;
    }

    /* ═══════════════════════════════════════
       NOTIFICATION DROPDOWN
    ═══════════════════════════════════════ */
    .ee-notif-wrapper { position: relative; }

    .ee-notif-dropdown {
        display: none;
        position: absolute;
        top: calc(100% + 6px);
        right: 0;
        width: 340px;
        max-width: calc(100vw - 2rem);
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r-lg);
        box-shadow: var(--shadow-xl);
        z-index: 200;
        overflow: hidden;
    }
    .ee-notif-dropdown.open { display: block; animation: slideDown .2s ease; }

    .ee-notif-dropdown-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: .875rem 1.125rem;
        border-bottom: 1px solid var(--border);
    }
    .ee-notif-dropdown-title { font-size: .875rem; font-weight: 700; color: var(--text); }
    .ee-notif-mark-all {
        font-size: .72rem; font-weight: 600; color: var(--blue);
        background: none; border: none; cursor: pointer; padding: 0; font-family: var(--font);
    }
    .ee-notif-mark-all:hover { text-decoration: underline; }

    .ee-notif-dropdown-body { max-height: 300px; overflow-y: auto; }

    .ee-notif-item {
        display: flex;
        gap: .75rem;
        padding: .75rem 1.125rem;
        border-bottom: 1px solid var(--border-2);
        cursor: pointer;
        transition: background .15s;
    }
    .ee-notif-item:hover { background: var(--surface-2); }
    .ee-notif-item:last-child { border-bottom: none; }

    .ee-notif-item-icon {
        width: 32px; height: 32px; border-radius: var(--r-sm);
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .ee-notif-item-icon svg { width: 15px; height: 15px; }
    .ee-notif-item-icon.success { background: var(--green-dim); color: var(--green); }
    .ee-notif-item-icon.info    { background: var(--blue-dim);  color: var(--blue); }
    .ee-notif-item-icon.warning { background: rgba(245,158,11,.1); color: var(--amber); }
    .ee-notif-item-icon.danger  { background: var(--red-dim);   color: var(--red); }

    .ee-notif-item-content { flex: 1; min-width: 0; }
    .ee-notif-item-msg {
        font-size: .8125rem; font-weight: 500; color: var(--text); margin-bottom: .2rem;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .ee-notif-item-time { font-size: .6875rem; color: var(--text-3); }

    .ee-notif-empty {
        padding: 2rem; text-align: center;
        font-size: .8125rem; color: var(--text-2);
    }

    /* ═══════════════════════════════════════
       CONTENT & FOOTER
    ═══════════════════════════════════════ */
    .ee-content {
        flex: 1;
        padding: 1.5rem;
    }

    .ee-footer {
        padding: 1rem 1.5rem;
        background: var(--surface);
        border-top: 1px solid var(--border);
        text-align: center;
    }
    .ee-footer-text { font-size: .72rem; color: var(--text-3); }
    .ee-footer-link { color: var(--o); text-decoration: none; font-weight: 600; }
    .ee-footer-link:hover { color: var(--o-600); }

    /* ═══════════════════════════════════════
       MOBILE OVERLAY
    ═══════════════════════════════════════ */
    .ee-overlay {
        display: none;
        position: fixed; inset: 0;
        background: rgba(0,0,0,.45);
        backdrop-filter: blur(3px);
        z-index: 90;
        opacity: 0;
        transition: opacity .3s;
    }
    .ee-overlay.active { display: block; opacity: 1; }

    /* ═══════════════════════════════════════
       SCROLLBAR
    ═══════════════════════════════════════ */
    ::-webkit-scrollbar { width: 4px; height: 4px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }
    ::-webkit-scrollbar-thumb:hover { background: var(--text-3); }

    /* ═══════════════════════════════════════
       DARK MODE — Header & Main
    ═══════════════════════════════════════ */
    .dark .ee-header  { background: #141720; border-bottom-color: rgba(255,255,255,.06); }
    .dark .ee-header-btn { background: #141720; border-color: rgba(255,255,255,.07); }
    .dark .ee-mobile-toggle { background: #141720; border-color: rgba(255,255,255,.07); }
    .dark .ee-header-avatar img { border-color: rgba(255,255,255,.1); }
    .dark .ee-notif-dropdown { background: #1a1e2b; border-color: rgba(255,255,255,.08); }
    .dark .ee-notif-dropdown-header { border-bottom-color: rgba(255,255,255,.07); }
    .dark .ee-notif-item { border-bottom-color: rgba(255,255,255,.04); }
    .dark .ee-footer { background: #141720; border-top-color: rgba(255,255,255,.06); }
    .dark .ee-theme-toggle { background: #141720; border-color: rgba(255,255,255,.07); }

    /* ═══════════════════════════════════════
       RESPONSIVE
    ═══════════════════════════════════════ */
    @media (max-width: 1024px) {
        .ee-sidebar { transform: translateX(-100%); }
        .ee-sidebar.open { transform: translateX(0); box-shadow: 4px 0 24px rgba(0,0,0,.5); }
        .ee-main { margin-left: 0; }
        .ee-mobile-toggle { display: flex; }
        .ee-content { padding: 1rem; }
    }
    @media (max-width: 640px) {
        .ee-header { padding: 0 1rem; }
        .ee-content { padding: .875rem; }
        .ee-page-title { font-size: .9375rem; }
        .ee-breadcrumb { display: none; }
        .ee-header-avatar { display: none; }
    }
    </style>
    @yield('styles')
</head>
<body>
<div class="ee-layout">

    <!-- Mobile Overlay -->
    <div class="ee-overlay" id="eeOverlay" onclick="toggleSidebar()"></div>

    <!-- ════════════════ SIDEBAR ════════════════ -->
    <aside class="ee-sidebar" id="eeSidebar">

        <!-- Brand -->
        <div class="ee-sidebar-brand">
            <div class="ee-brand-logo">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
        </div>

        <!-- User avatar -->
        @php $sidebarUser = auth()->user(); $sidebarPersonnel = $sidebarUser->personnel ?? null; @endphp
        <div class="ee-sidebar-user">
            <img
                src="{{ $sidebarPersonnel && $sidebarPersonnel->photo
                    ? asset('storage/' . $sidebarPersonnel->photo)
                    : 'https://ui-avatars.com/api/?name=' . urlencode($sidebarUser->name) . '&size=200&background=f97316&color=ffffff&bold=true' }}"
                alt="{{ $sidebarUser->name }}"
                class="ee-user-avatar"
                onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($sidebarUser->name) }}&size=200&background=f97316&color=ffffff&bold=true'">
        </div>

        <!-- Navigation -->
        <nav class="ee-sidebar-nav">

            <!-- Mon Espace -->
            <div class="ee-nav-section">
                <div class="ee-nav-title">Mon Espace</div>

                <a href="{{ route('espace-employe.dashboard') }}"
                   class="ee-nav-link {{ request()->routeIs('espace-employe.dashboard') ? 'active' : '' }}"
                   data-tooltip="Tableau de bord">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                        <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                    </svg>
                </a>

                <a href="{{ route('espace-employe.profil') }}"
                   class="ee-nav-link {{ request()->routeIs('espace-employe.profil') ? 'active' : '' }}"
                   data-tooltip="Mon profil">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </a>
            </div>

            <!-- Documents -->
            <div class="ee-nav-section">
                <div class="ee-nav-title">Documents</div>

                <a href="{{ route('espace-employe.documents') }}"
                   class="ee-nav-link {{ request()->routeIs('espace-employe.documents') ? 'active' : '' }}"
                   data-tooltip="Mes documents">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                </a>

                <a href="{{ route('espace-employe.bulletins') }}"
                   class="ee-nav-link {{ request()->routeIs('espace-employe.bulletins') ? 'active' : '' }}"
                   data-tooltip="Bulletins de paie">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="3" width="20" height="14" rx="2"/>
                        <line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>
                    </svg>
                </a>

                <a href="{{ route('espace-employe.attestations') }}"
                   class="ee-nav-link {{ request()->routeIs('espace-employe.attestations') ? 'active' : '' }}"
                   data-tooltip="Attestations">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        <path d="M9 12l2 2 4-4"/>
                    </svg>
                </a>
            </div>

            <!-- Demandes -->
            <div class="ee-nav-section">
                <div class="ee-nav-title">Demandes</div>

                <a href="{{ route('espace-employe.conges') }}"
                   class="ee-nav-link {{ request()->routeIs('espace-employe.conges') ? 'active' : '' }}"
                   data-tooltip="Mes congés">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                        <path d="M9 16l2 2 4-4"/>
                    </svg>
                </a>

                <a href="{{ route('espace-employe.absences') }}"
                   class="ee-nav-link {{ request()->routeIs('espace-employe.absences') ? 'active' : '' }}"
                   data-tooltip="Mes absences">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                    </svg>
                </a>

                <a href="{{ route('espace-employe.demandes') }}"
                   class="ee-nav-link {{ request()->routeIs('espace-employe.demandes') ? 'active' : '' }}"
                   data-tooltip="Mes demandes">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                        <rect x="8" y="2" width="8" height="4" rx="1"/>
                        <path d="M9 14l2 2 4-4"/>
                    </svg>
                </a>
            </div>

            <!-- Compte -->
            <div class="ee-nav-section">
                <div class="ee-nav-title">Compte</div>

                <a href="{{ route('espace-employe.parametres') }}"
                   class="ee-nav-link {{ request()->routeIs('espace-employe.parametres') ? 'active' : '' }}"
                   data-tooltip="Paramètres">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                    </svg>
                </a>
            </div>

        </nav>

        <!-- Footer icons -->
        <div class="ee-sidebar-footer">

            @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'RH']))
            <a href="{{ route('admin.dashboard') }}" class="ee-btn-icon" data-tooltip="Portail Admin">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="3"/><path d="M3 12h1M20 12h1M12 3v1M12 20v1"/>
                    <path d="M5.64 5.64l.71.71M17.66 17.66l.71.71M5.64 18.36l.71-.71M17.66 6.34l.71-.71"/>
                </svg>
            </a>
            @endif

            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="ee-btn-icon danger" data-tooltip="Déconnexion">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                </button>
            </form>

        </div>
    </aside>

    <!-- ════════════════ MAIN ════════════════ -->
    <main class="ee-main">

        <!-- Header -->
        <header class="ee-header">
            <div class="ee-header-left">
                <button class="ee-mobile-toggle" onclick="toggleSidebar()" aria-label="Menu">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                </button>
                <div class="ee-page-info">
                    <h1 class="ee-page-title">@yield('page-title', 'Mon Espace')</h1>
                    @hasSection('breadcrumb')
                        <div class="ee-breadcrumb">
                            @yield('breadcrumb')
                        </div>
                    @endif
                </div>
            </div>

            <div class="ee-header-right">

                <!-- Notifications -->
                <div class="ee-notif-wrapper">
                    <button class="ee-header-btn ee-notif-btn" id="eeNotifBtn" title="Notifications">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                        </svg>
                        <span class="badge" id="eeNotifBadge" style="display:none;">0</span>
                    </button>
                    <div class="ee-notif-dropdown" id="eeNotifDropdown">
                        <div class="ee-notif-dropdown-header">
                            <span class="ee-notif-dropdown-title">Notifications</span>
                            <button class="ee-notif-mark-all" id="eeMarkAllRead">Tout marquer lu</button>
                        </div>
                        <div class="ee-notif-dropdown-body" id="eeNotifList">
                            <div class="ee-notif-empty">Aucune notification</div>
                        </div>
                    </div>
                </div>

                <!-- Theme toggle -->
                <button class="ee-theme-toggle" onclick="toggleTheme()" title="Changer le thème">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="sun-icon">
                        <circle cx="12" cy="12" r="4" fill="currentColor" opacity=".12"/><circle cx="12" cy="12" r="4"/>
                        <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="moon-icon">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" fill="currentColor" opacity=".1"/>
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                    </svg>
                </button>

                <!-- Avatar -->
                <a href="{{ route('espace-employe.profil') }}" class="ee-header-avatar">
                    @php $ha = auth()->user(); $hp = $ha->personnel ?? null; @endphp
                    <img
                        src="{{ $hp && $hp->photo ? asset('storage/' . $hp->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($ha->name) . '&size=200&background=f97316&color=ffffff&bold=true' }}"
                        alt="{{ $ha->name }}"
                        onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($ha->name) }}&size=200&background=f97316&color=ffffff&bold=true'">
                    <span class="ee-header-avatar-status"></span>
                </a>

            </div>
        </header>

        <!-- Content -->
        <div class="ee-content">
            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="ee-footer">
            <p class="ee-footer-text">
                &copy; {{ date('Y') }} <a href="#" class="ee-footer-link">Portail RH+</a> &mdash; Tous droits réservés
            </p>
        </footer>

    </main>
</div>

@yield('scripts')

<script>
(function () {
    'use strict';

    /* ── Theme ─────────────────────────────────────── */
    window.toggleTheme = function () {
        var isDark = document.documentElement.classList.toggle('dark');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
    };

    /* ── Sidebar mobile ─────────────────────────────── */
    window.toggleSidebar = function () {
        var sb = document.getElementById('eeSidebar');
        var ov = document.getElementById('eeOverlay');
        if (!sb) return;
        var isOpen = sb.classList.toggle('open');
        ov.classList.toggle('active', isOpen);
    };

    /* ── Notifications ──────────────────────────────── */
    var notifBtn      = document.getElementById('eeNotifBtn');
    var notifDropdown = document.getElementById('eeNotifDropdown');
    var notifBadge    = document.getElementById('eeNotifBadge');
    var notifList     = document.getElementById('eeNotifList');
    var markAllBtn    = document.getElementById('eeMarkAllRead');

    function fetchNotifications () {
        fetch('/notifications/unread', { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
            .then(function (r) { return r.ok ? r.json() : Promise.reject(); })
            .then(function (data) {
                var items = data.notifications || [];
                var count = items.length;
                if (count > 0) {
                    notifBadge.textContent = count > 9 ? '9+' : count;
                    notifBadge.style.display = 'flex';
                    notifBtn.classList.add('has-notif');
                } else {
                    notifBadge.style.display = 'none';
                    notifBtn.classList.remove('has-notif');
                }
                if (items.length === 0) {
                    notifList.innerHTML = '<div class="ee-notif-empty">Aucune notification</div>';
                    return;
                }
                notifList.innerHTML = items.map(function (n) {
                    return '<div class="ee-notif-item" data-id="' + n.id + '">' +
                        '<div class="ee-notif-item-icon ' + (n.type || 'info') + '">' +
                        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>' +
                        '</div>' +
                        '<div class="ee-notif-item-content">' +
                        '<div class="ee-notif-item-msg">' + (n.message || n.data?.message || '') + '</div>' +
                        '<div class="ee-notif-item-time">' + (n.time || '') + '</div>' +
                        '</div></div>';
                }).join('');
            })
            .catch(function () {});
    }

    if (notifBtn && notifDropdown) {
        notifBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            notifDropdown.classList.toggle('open');
            if (notifDropdown.classList.contains('open')) fetchNotifications();
        });
        document.addEventListener('click', function (e) {
            if (!notifDropdown.contains(e.target) && e.target !== notifBtn) {
                notifDropdown.classList.remove('open');
            }
        });
    }

    if (markAllBtn) {
        markAllBtn.addEventListener('click', function () {
            fetch('/notifications/mark-all-read', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }
            }).then(function () { fetchNotifications(); });
        });
    }

    /* Poll every 45s */
    fetchNotifications();
    setInterval(fetchNotifications, 45000);

})();
</script>
</body>
</html>
