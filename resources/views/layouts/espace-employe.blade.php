<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mon Espace') - Portail RH+</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/logo.png') }}">

    <!-- Fonts — Charte Portail RH+ -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,400&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
    /* ═══════════════════════════════════════════════════════════════
       PORTAIL RH+  ·  ESPACE EMPLOYÉ
       Charte graphique officielle — Indigo × Teal × Neutres
       Syne (display) · DM Sans (body) · DM Mono (mono)
       ═══════════════════════════════════════════════════════════════ */

    :root {
        /* ── Indigo (Primary) ── */
        --ind-50:  #EEF0FB;
        --ind-100: #D5DAF5;
        --ind-200: #B0BAEC;
        --ind-300: #8090E0;
        --ind-400: #5566D4;
        --ind-500: #3748C8;
        --ind-600: #2535A8;
        --ind-700: #1A2785;
        --ind-800: #111C62;
        --ind-900: #0A1040;

        /* ── Teal (Accent / Success) ── */
        --teal-50:  #E6FAF7;
        --teal-100: #B3F0E6;
        --teal-300: #2ECABB;
        --teal-400: #0AAFA2;
        --teal-500: #078F84;
        --teal-600: #057068;
        --teal-700: #03524C;

        /* ── Semantic ── */
        --amber-100: #FEF3C7;
        --amber-400: #F59E0B;
        --amber-800: #78350F;
        --rose-100:  #FFE4E6;
        --rose-400:  #FB7185;
        --rose-800:  #9F1239;
        --green-100: #D1FAE5;
        --green-400: #34D399;
        --green-800: #065F46;

        /* ── Neutrals ── */
        --n-0:   #FFFFFF;
        --n-50:  #F8F8F9;
        --n-100: #F0F1F3;
        --n-200: #E2E4E8;
        --n-300: #C9CDD5;
        --n-400: #9EA4B0;
        --n-500: #6B7282;
        --n-600: #4B5263;
        --n-700: #343A47;
        --n-800: #1E2330;
        --n-900: #0D1017;

        /* ── Layout tokens ── */
        --bg:       #F8F8F9;
        --surface:  #FFFFFF;
        --surface-2:#F8F8F9;
        --border:   #E2E4E8;
        --border-2: #F0F1F3;
        --text:     #1E2330;
        --text-2:   #6B7282;
        --text-3:   #9EA4B0;

        /* ── Shadows ── */
        --shadow-sm: 0 1px 3px rgba(10,16,64,.06), 0 1px 2px rgba(10,16,64,.04);
        --shadow:    0 2px 8px rgba(10,16,64,.07), 0 1px 3px rgba(10,16,64,.04);
        --shadow-md: 0 4px 16px rgba(10,16,64,.08), 0 2px 6px rgba(10,16,64,.05);
        --shadow-lg: 0 12px 32px rgba(10,16,64,.10), 0 4px 10px rgba(10,16,64,.06);
        --shadow-xl: 0 24px 48px rgba(10,16,64,.12), 0 8px 16px rgba(10,16,64,.05);

        /* ── Layout ── */
        --sidebar-w: 64px;
        --header-h:  56px;

        /* ── Fonts ── */
        --font:   'DM Sans', system-ui, sans-serif;
        --font-d: 'Syne', 'DM Sans', system-ui, sans-serif;
        --font-m: 'DM Mono', monospace;

        /* ── Radius ── */
        --r-sm:  4px;
        --r:     8px;
        --r-lg:  12px;
        --r-xl:  16px;
        --r-2xl: 24px;
        --r-full:9999px;
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
       SIDEBAR  —  Icon Rail  (indigo-900)
    ═══════════════════════════════════════ */
    .ee-sidebar {
        width: var(--sidebar-w);
        background: var(--ind-900);
        border-right: 1px solid rgba(255,255,255,.05);
        position: fixed;
        top: 0; left: 0; bottom: 0;
        z-index: 100;
        display: flex;
        flex-direction: column;
        align-items: center;
        overflow: visible;
        transition: transform .3s cubic-bezier(.4,0,.2,1);
    }

    /* ── Brand ── */
    .ee-sidebar-brand {
        width: 64px;
        height: var(--header-h);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-bottom: 1px solid rgba(255,255,255,.06);
    }

    .ee-brand-logo {
        width: 34px; height: 34px;
        background: var(--ind-600);
        border-radius: var(--r-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        flex-shrink: 0;
        transition: background .2s;
    }
    .ee-brand-logo:hover { background: var(--ind-500); }
    .ee-brand-logo svg { width: 18px; height: 18px; }

    /* ── User Avatar ── */
    .ee-sidebar-user {
        width: 64px;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-bottom: 1px solid rgba(255,255,255,.05);
    }

    .ee-user-avatar {
        width: 30px; height: 30px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(255,255,255,.12);
        transition: border-color .2s;
        display: block;
    }
    .ee-sidebar-user:hover .ee-user-avatar { border-color: var(--teal-400); }

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

    .ee-nav-title {
        width: 20px;
        height: 1px;
        background: rgba(255,255,255,.1);
        margin: 6px 0;
        font-size: 0;
        flex-shrink: 0;
    }

    .ee-nav-link {
        position: relative;
        width: 40px; height: 40px;
        border-radius: var(--r-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255,255,255,.32);
        text-decoration: none;
        font-size: 0;
        transition: background .14s, color .14s, box-shadow .14s;
        margin-bottom: 1px;
        flex-shrink: 0;
    }
    .ee-nav-link svg {
        width: 18px; height: 18px;
        flex-shrink: 0;
        stroke-width: 1.8;
    }
    .ee-nav-link:hover {
        background: rgba(255,255,255,.07);
        color: rgba(255,255,255,.7);
    }
    .ee-nav-link.active {
        background: rgba(10,175,162,.14);
        color: var(--teal-300);
        box-shadow: inset 2px 0 0 var(--teal-400);
    }

    /* CSS Tooltip */
    .ee-nav-link::after {
        content: attr(data-tooltip);
        position: absolute;
        left: calc(100% + 12px);
        top: 50%;
        transform: translateY(-50%) translateX(-4px);
        background: var(--ind-800);
        color: rgba(255,255,255,.9);
        font-family: var(--font);
        font-size: .72rem;
        font-weight: 500;
        white-space: nowrap;
        padding: 5px 11px;
        border-radius: var(--r);
        border: 1px solid rgba(255,255,255,.08);
        box-shadow: var(--shadow-lg);
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
        border-top: 1px solid rgba(255,255,255,.06);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 2px;
        flex-shrink: 0;
    }

    .ee-btn-icon {
        position: relative;
        width: 40px; height: 40px;
        border-radius: var(--r-lg);
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
    .ee-btn-icon svg { width: 17px; height: 17px; stroke-width: 1.8; }
    .ee-btn-icon:hover { background: rgba(255,255,255,.07); color: rgba(255,255,255,.65); }
    .ee-btn-icon.danger:hover { background: rgba(251,113,133,.12); color: var(--rose-400); }

    .ee-btn-icon::after {
        content: attr(data-tooltip);
        position: absolute;
        left: calc(100% + 12px);
        top: 50%;
        transform: translateY(-50%) translateX(-4px);
        background: var(--ind-800);
        color: rgba(255,255,255,.9);
        font-family: var(--font);
        font-size: .72rem;
        font-weight: 500;
        white-space: nowrap;
        padding: 5px 11px;
        border-radius: var(--r);
        border: 1px solid rgba(255,255,255,.08);
        box-shadow: var(--shadow-lg);
        pointer-events: none;
        opacity: 0;
        transform: translateY(-50%) translateX(-4px);
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

    .ee-mobile-toggle {
        display: none;
        width: 36px; height: 36px;
        border: 1.5px solid var(--border);
        border-radius: var(--r);
        background: var(--surface);
        color: var(--text-2);
        cursor: pointer;
        align-items: center;
        justify-content: center;
        transition: all .15s;
    }
    .ee-mobile-toggle:hover { background: var(--ind-50); border-color: var(--ind-300); color: var(--ind-600); }
    .ee-mobile-toggle svg { width: 18px; height: 18px; }

    .ee-page-info { display: flex; flex-direction: column; gap: 1px; }

    .ee-page-title {
        font-family: var(--font-d);
        font-size: 1rem;
        font-weight: 700;
        color: var(--ind-800);
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
    .ee-breadcrumb a { color: var(--ind-600); text-decoration: none; font-weight: 500; }
    .ee-breadcrumb a:hover { text-decoration: underline; }
    .ee-breadcrumb svg { width: 9px; height: 9px; opacity: .45; }

    .ee-header-right {
        display: flex;
        align-items: center;
        gap: .375rem;
    }

    .ee-header-btn {
        position: relative;
        width: 36px; height: 36px;
        border: 1.5px solid var(--border);
        border-radius: var(--r);
        background: var(--surface);
        color: var(--text-2);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all .15s;
    }
    .ee-header-btn:hover {
        background: var(--ind-50);
        border-color: var(--ind-300);
        color: var(--ind-600);
    }
    .ee-header-btn svg { width: 17px; height: 17px; stroke-width: 1.8; }

    .ee-header-btn .badge {
        position: absolute;
        top: -5px; right: -5px;
        min-width: 16px; height: 16px;
        background: var(--rose-400);
        color: #fff;
        font-size: .5rem;
        font-weight: 700;
        border-radius: var(--r-full);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 3px;
        border: 2px solid var(--surface);
    }

    .ee-notif-btn.has-notif::after {
        content: '';
        position: absolute;
        top: 7px; right: 7px;
        width: 7px; height: 7px;
        background: var(--rose-400);
        border-radius: 50%;
        border: 1.5px solid var(--surface);
    }

    /* Avatar */
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
    .ee-header-avatar:hover img { border-color: var(--ind-400); }
    .ee-header-avatar-status {
        position: absolute;
        bottom: -1px; right: -1px;
        width: 8px; height: 8px;
        background: var(--green-400);
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
        border-radius: var(--r-xl);
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
    .ee-notif-dropdown-title {
        font-family: var(--font-d);
        font-size: .875rem; font-weight: 700; color: var(--text);
    }
    .ee-notif-mark-all {
        font-size: .72rem; font-weight: 600; color: var(--ind-600);
        background: none; border: none; cursor: pointer; padding: 0; font-family: var(--font);
    }
    .ee-notif-mark-all:hover { text-decoration: underline; }

    .ee-notif-dropdown-body { max-height: 320px; overflow-y: auto; }

    .ee-notif-item {
        display: flex;
        gap: .75rem;
        padding: .75rem 1.125rem;
        border-bottom: 1px solid var(--border-2);
        cursor: pointer;
        transition: background .13s;
    }
    .ee-notif-item:hover { background: var(--n-50); }
    .ee-notif-item:last-child { border-bottom: none; }

    .ee-notif-item-icon {
        width: 34px; height: 34px; border-radius: var(--r);
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .ee-notif-item-icon svg { width: 15px; height: 15px; }
    .ee-notif-item-icon.success { background: var(--green-100); color: var(--green-800); }
    .ee-notif-item-icon.info    { background: var(--ind-50);    color: var(--ind-600); }
    .ee-notif-item-icon.warning { background: var(--amber-100); color: var(--amber-800); }
    .ee-notif-item-icon.danger  { background: var(--rose-100);  color: var(--rose-800); }

    .ee-notif-item-content { flex: 1; min-width: 0; }
    .ee-notif-item-msg {
        font-size: .8125rem; font-weight: 500; color: var(--text); margin-bottom: .2rem;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .ee-notif-item-time { font-size: .6875rem; color: var(--text-3); font-family: var(--font-m); }

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
    .ee-footer-link { color: var(--ind-600); text-decoration: none; font-weight: 600; }
    .ee-footer-link:hover { color: var(--ind-700); }

    /* ═══════════════════════════════════════
       MOBILE OVERLAY
    ═══════════════════════════════════════ */
    .ee-overlay {
        display: none;
        position: fixed; inset: 0;
        background: rgba(10,16,64,.4);
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
    ::-webkit-scrollbar-thumb { background: var(--n-200); border-radius: 4px; }
    ::-webkit-scrollbar-thumb:hover { background: var(--n-300); }

    /* ═══════════════════════════════════════
       RESPONSIVE
    ═══════════════════════════════════════ */
    @media (max-width: 1024px) {
        .ee-sidebar { transform: translateX(-100%); }
        .ee-sidebar.open { transform: translateX(0); box-shadow: 4px 0 32px rgba(10,16,64,.25); }
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

        <!-- User -->
        @php $sidebarUser = auth()->user(); $sidebarPerso = $sidebarUser->personnel ?? null; @endphp
        <div class="ee-sidebar-user">
            <img
                src="{{ $sidebarPerso && $sidebarPerso->photo
                    ? asset('storage/' . $sidebarPerso->photo)
                    : 'https://ui-avatars.com/api/?name=' . urlencode($sidebarUser->name) . '&size=200&background=2535A8&color=ffffff&bold=true' }}"
                alt="{{ $sidebarUser->name }}"
                class="ee-user-avatar"
                onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($sidebarUser->name) }}&size=200&background=2535A8&color=ffffff&bold=true'">
        </div>

        <!-- Nav -->
        <nav class="ee-sidebar-nav">

            <div class="ee-nav-section">
                <div class="ee-nav-title">Mon Espace</div>

                <a href="{{ route('espace-employe.dashboard') }}"
                   class="ee-nav-link {{ request()->routeIs('espace-employe.dashboard') ? 'active' : '' }}"
                   data-tooltip="Tableau de bord">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="14" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/>
                    </svg>
                </a>

                <a href="{{ route('espace-employe.profil') }}"
                   class="ee-nav-link {{ request()->routeIs('espace-employe.profil') ? 'active' : '' }}"
                   data-tooltip="Mon profil">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </a>
            </div>

            <div class="ee-nav-section">
                <div class="ee-nav-title">Documents</div>

                <a href="{{ route('espace-employe.documents') }}"
                   class="ee-nav-link {{ request()->routeIs('espace-employe.documents') ? 'active' : '' }}"
                   data-tooltip="Mes documents">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                </a>

                <a href="{{ route('espace-employe.bulletins') }}"
                   class="ee-nav-link {{ request()->routeIs('espace-employe.bulletins') ? 'active' : '' }}"
                   data-tooltip="Bulletins de paie">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="3" width="20" height="14" rx="2"/>
                        <line x1="8" y1="21" x2="16" y2="21"/>
                        <line x1="12" y1="17" x2="12" y2="21"/>
                    </svg>
                </a>

                <a href="{{ route('espace-employe.attestations') }}"
                   class="ee-nav-link {{ request()->routeIs('espace-employe.attestations') ? 'active' : '' }}"
                   data-tooltip="Attestations">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        <path d="M9 12l2 2 4-4"/>
                    </svg>
                </a>
            </div>

            <div class="ee-nav-section">
                <div class="ee-nav-title">Demandes</div>

                <a href="{{ route('espace-employe.conges') }}"
                   class="ee-nav-link {{ request()->routeIs('espace-employe.conges') ? 'active' : '' }}"
                   data-tooltip="Mes congés">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                        <path d="M9 16l2 2 4-4"/>
                    </svg>
                </a>

                <a href="{{ route('espace-employe.absences') }}"
                   class="ee-nav-link {{ request()->routeIs('espace-employe.absences') ? 'active' : '' }}"
                   data-tooltip="Mes absences">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="15" y1="9" x2="9" y2="15"/>
                        <line x1="9" y1="9" x2="15" y2="15"/>
                    </svg>
                </a>

                <a href="{{ route('espace-employe.demandes') }}"
                   class="ee-nav-link {{ request()->routeIs('espace-employe.demandes') ? 'active' : '' }}"
                   data-tooltip="Mes demandes">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                        <rect x="8" y="2" width="8" height="4" rx="1"/>
                        <path d="M9 14l2 2 4-4"/>
                    </svg>
                </a>
            </div>

            <div class="ee-nav-section">
                <div class="ee-nav-title">Compte</div>

                <a href="{{ route('espace-employe.parametres') }}"
                   class="ee-nav-link {{ request()->routeIs('espace-employe.parametres') ? 'active' : '' }}"
                   data-tooltip="Paramètres">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                    </svg>
                </a>
            </div>

        </nav>

        <!-- Footer -->
        <div class="ee-sidebar-footer">
            @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'RH']))
            <a href="{{ route('admin.dashboard') }}" class="ee-btn-icon" data-tooltip="Portail Admin">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </a>
            @endif
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="ee-btn-icon danger" data-tooltip="Déconnexion">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
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

        <header class="ee-header">
            <div class="ee-header-left">
                <button class="ee-mobile-toggle" onclick="toggleSidebar()" aria-label="Menu">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="12" x2="21" y2="12"/>
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                </button>
                <div class="ee-page-info">
                    <h1 class="ee-page-title">@yield('page-title', 'Mon Espace')</h1>
                    @hasSection('breadcrumb')
                        <div class="ee-breadcrumb">@yield('breadcrumb')</div>
                    @endif
                </div>
            </div>

            <div class="ee-header-right">
                <!-- Notifications -->
                <div class="ee-notif-wrapper">
                    <button class="ee-header-btn ee-notif-btn" id="eeNotifBtn" title="Notifications">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
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

                <!-- Avatar -->
                <a href="{{ route('espace-employe.profil') }}" class="ee-header-avatar">
                    @php $ha = auth()->user(); $hp = $ha->personnel ?? null; @endphp
                    <img
                        src="{{ $hp && $hp->photo ? asset('storage/' . $hp->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($ha->name) . '&size=200&background=2535A8&color=ffffff&bold=true' }}"
                        alt="{{ $ha->name }}"
                        onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($ha->name) }}&size=200&background=2535A8&color=ffffff&bold=true'">
                    <span class="ee-header-avatar-status"></span>
                </a>
            </div>
        </header>

        <div class="ee-content">
            @yield('content')
        </div>

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

    /* ── Sidebar mobile ── */
    window.toggleSidebar = function () {
        var sb = document.getElementById('eeSidebar');
        var ov = document.getElementById('eeOverlay');
        if (!sb) return;
        var open = sb.classList.toggle('open');
        ov.classList.toggle('active', open);
    };

    /* ── Notifications ── */
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
                        '<div class="ee-notif-item-msg">' + (n.message || (n.data && n.data.message) || '') + '</div>' +
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

    fetchNotifications();
    setInterval(fetchNotifications, 45000);

})();
</script>
</body>
</html>
