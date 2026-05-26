<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mon Espace') — Portail RH+</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
    /* ═══════════════════════════════════════════════════════════════
       PORTAIL RH+  ·  ESPACE EMPLOYÉ  ·  TopNav + Burger Dropdown
       ═══════════════════════════════════════════════════════════════ */

    :root {
        --ind-50:  #EEEFFE; --ind-100: #D5D9FB; --ind-200: #B0B8F5;
        --ind-300: #808FE8; --ind-400: #5566D4; --ind-500: #3748C8;
        --ind-600: #2535A8; --ind-700: #1A2785; --ind-800: #111C62; --ind-900: #0A1040;

        /* Orange palette — Espace Employé */
        --org-50:  #FFF7ED; --org-100: #FFEDD5; --org-200: #FED7AA;
        --org-300: #FB923C; --org-400: #F97316;
        --org-500: #EA580C; --org-600: #C2470A; --org-700: #9A3B08;

        --amber-100: #FEF3C7; --amber-400: #F59E0B; --amber-800: #78350F;
        --rose-100:  #FFE4E6; --rose-400:  #FB7185; --rose-800:  #9F1239;
        --green-100: #D1FAE5; --green-400: #34D399; --green-800: #065F46;
        --violet-100: #EDE9FE; --violet-600: #7C3AED;

        --n-0:   #FFFFFF; --n-50:  #F8F9FA; --n-100: #F0F2F5;
        --n-200: #E2E5EA; --n-300: #C8CDD7; --n-400: #9CA3B0;
        --n-500: #6B7382; --n-600: #4B5263; --n-700: #343A47; --n-800: #1E2330;

        --bg:      #F2F4F8;
        --surface: #FFFFFF;
        --border:  #E2E5EA;
        --text:    #1E2330;
        --text-2:  #6B7382;
        --text-3:  #9CA3B0;

        --shadow-sm: 0 1px 3px rgba(10,16,64,.06), 0 1px 2px rgba(10,16,64,.04);
        --shadow:    0 2px 8px rgba(10,16,64,.08), 0 1px 3px rgba(10,16,64,.04);
        --shadow-md: 0 4px 16px rgba(10,16,64,.10), 0 2px 6px rgba(10,16,64,.05);
        --shadow-lg: 0 12px 32px rgba(10,16,64,.12), 0 4px 10px rgba(10,16,64,.06);
        --shadow-xl: 0 24px 48px rgba(10,16,64,.14), 0 8px 16px rgba(10,16,64,.06);

        --hd-h: 58px;

        /* Topnav dark bg (same palette as old sidebar) */
        --tn-bg-1: #1A0800;
        --tn-bg-2: #2C1200;
        --tn-border: rgba(255,255,255,.07);
        --tn-text: rgba(255,255,255,.9);
        --tn-text-dim: rgba(255,255,255,.55);

        --font:   'DM Sans', system-ui, sans-serif;
        --font-d: 'Syne', 'DM Sans', system-ui, sans-serif;
        --font-m: 'DM Mono', monospace;
        --r-sm: 4px; --r: 8px; --r-lg: 12px; --r-xl: 16px; --r-2xl: 24px; --r-f: 9999px;
    }

    @keyframes fadeUp    { from { opacity:0; transform:translateY(8px)  } to { opacity:1; transform:translateY(0) } }
    @keyframes slideDown { from { opacity:0; transform:translateY(-6px)  } to { opacity:1; transform:translateY(0) } }
    @keyframes dropIn    { from { opacity:0; transform:translateY(-10px) } to { opacity:1; transform:translateY(0) } }
    @keyframes pulse     { 0%,100% { opacity:1 } 50% { opacity:.5 } }

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

    /* ────────────────────────────────────────
       LAYOUT
    ──────────────────────────────────────── */
    .ee-layout {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    /* ────────────────────────────────────────
       TOP NAV BAR (fixed)
    ──────────────────────────────────────── */
    .ee-topnav {
        position: fixed;
        top: 0; left: 0; right: 0;
        height: var(--hd-h);
        background: linear-gradient(135deg, var(--tn-bg-1) 0%, var(--tn-bg-2) 100%);
        border-bottom: 1px solid var(--tn-border);
        box-shadow: 0 2px 20px rgba(0,0,0,.35);
        z-index: 100;
        display: flex;
        align-items: center;
        padding: 0 1.25rem;
        gap: 1rem;
    }

    .ee-topnav-left  {
        display: flex;
        align-items: center;
        gap: .75rem;
        flex: 1;
        min-width: 0;
    }
    .ee-topnav-center {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 0;
    }
    .ee-topnav-right {
        display: flex;
        align-items: center;
        gap: .4rem;
        flex: 1;
        justify-content: flex-end;
    }

    /* ── Burger button ── */
    .ee-burger {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 5px;
        width: 38px; height: 38px;
        border: 1px solid rgba(255,255,255,.14);
        border-radius: var(--r);
        background: rgba(255,255,255,.06);
        cursor: pointer;
        padding: 0;
        flex-shrink: 0;
        transition: background .15s, border-color .15s;
    }
    .ee-burger:hover {
        background: rgba(255,255,255,.12);
        border-color: rgba(255,255,255,.24);
    }
    html.menu-open .ee-burger {
        background: rgba(249,115,22,.18);
        border-color: rgba(249,115,22,.4);
    }
    .ee-burger span {
        display: block;
        width: 18px; height: 2px;
        background: var(--tn-text);
        border-radius: 2px;
        transform-origin: center;
        transition: transform .26s cubic-bezier(.4,0,.2,1), opacity .2s, width .22s;
    }
    /* Burger → X animation */
    html.menu-open .ee-burger span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
    html.menu-open .ee-burger span:nth-child(2) { opacity: 0; width: 0; }
    html.menu-open .ee-burger span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

    /* ── Brand link ── */
    .ee-brand-link {
        display: flex;
        align-items: center;
        gap: 9px;
        text-decoration: none;
        flex-shrink: 0;
    }
    .ee-brand-mark {
        width: 33px; height: 33px;
        background: linear-gradient(135deg, var(--org-600) 0%, var(--org-400) 100%);
        border-radius: var(--r);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 3px 10px rgba(249,115,22,.4);
    }
    .ee-brand-mark svg { width: 16px; height: 16px; color: #fff; stroke-width: 2; }
    .ee-brand-name {
        font-family: var(--font-d);
        font-size: .9375rem; font-weight: 700;
        color: var(--tn-text); letter-spacing: -.02em; line-height: 1.15;
    }
    .ee-brand-name em { font-style: normal; color: var(--org-300); }
    .ee-brand-sub {
        display: block;
        font-size: .5625rem; font-weight: 600;
        color: var(--tn-text-dim); letter-spacing: .1em; text-transform: uppercase;
        margin-top: 1px;
    }

    /* ── Page title (centered in nav) ── */
    .ee-nav-page-title {
        font-family: var(--font-d);
        font-size: .9375rem; font-weight: 600;
        color: rgba(255,255,255,.75);
        letter-spacing: -.01em;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        max-width: 260px;
    }

    /* ── Header right buttons ── */
    .ee-header-btn {
        position: relative;
        width: 35px; height: 35px;
        border: 1px solid rgba(255,255,255,.13);
        border-radius: var(--r);
        background: rgba(255,255,255,.06);
        color: var(--tn-text-dim);
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: background .14s, color .14s, border-color .14s;
        flex-shrink: 0;
    }
    .ee-header-btn:hover {
        background: rgba(255,255,255,.12);
        color: var(--tn-text);
        border-color: rgba(255,255,255,.24);
    }
    .ee-header-btn svg { width: 16px; height: 16px; stroke-width: 1.8; }

    .ee-header-btn .hb-badge {
        position: absolute; top: -5px; right: -5px;
        min-width: 15px; height: 15px;
        background: var(--rose-400); color: #fff;
        font-size: .5rem; font-weight: 700; border-radius: var(--r-f);
        display: flex; align-items: center; justify-content: center;
        padding: 0 3px; border: 2px solid var(--tn-bg-1);
    }
    .ee-notif-dot::after {
        content: ''; position: absolute; top: 5px; right: 5px;
        width: 7px; height: 7px; background: var(--rose-400);
        border-radius: 50%; border: 1.5px solid var(--tn-bg-1);
    }

    /* ── Avatar in topnav ── */
    .ee-hd-avatar {
        position: relative; display: flex; align-items: center;
        text-decoration: none; margin-left: .1rem;
    }
    .ee-hd-avatar img {
        width: 30px; height: 30px; border-radius: 50%; object-fit: cover;
        border: 2px solid rgba(255,255,255,.18); transition: border-color .15s; display: block;
    }
    .ee-hd-avatar:hover img { border-color: var(--org-400); }
    .ee-hd-avatar-dot {
        position: absolute; bottom: -1px; right: -1px;
        width: 8px; height: 8px;
        background: var(--green-400); border: 2px solid var(--tn-bg-1); border-radius: 50%;
    }

    /* ────────────────────────────────────────
       NOTIFICATION DROPDOWN
    ──────────────────────────────────────── */
    .ee-notif-wrap { position: relative; }
    .ee-notif-drop {
        display: none;
        position: absolute; top: calc(100% + 10px); right: 0;
        width: 340px; max-width: calc(100vw - 2rem);
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--r-xl); box-shadow: var(--shadow-xl);
        z-index: 200; overflow: hidden;
    }
    .ee-notif-drop.open { display: block; animation: slideDown .18s ease; }
    .ee-notif-drop-head {
        display: flex; align-items: center; justify-content: space-between;
        padding: .875rem 1.125rem; border-bottom: 1px solid var(--border);
    }
    .ee-notif-drop-title { font-family: var(--font-d); font-size: .875rem; font-weight: 700; color: var(--text); }
    .ee-notif-mark-all { font-size: .72rem; font-weight: 600; color: var(--org-500); background: none; border: none; cursor: pointer; padding: 0; font-family: var(--font); }
    .ee-notif-mark-all:hover { text-decoration: underline; }
    .ee-notif-body { max-height: 320px; overflow-y: auto; }
    .ee-notif-item {
        display: flex; gap: .75rem; padding: .75rem 1.125rem;
        border-bottom: 1px solid var(--n-100); cursor: pointer; transition: background .12s;
    }
    .ee-notif-item:hover { background: var(--n-50); }
    .ee-notif-item:last-child { border-bottom: none; }
    .ee-notif-icon {
        width: 32px; height: 32px; border-radius: var(--r);
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .ee-notif-icon svg { width: 14px; height: 14px; }
    .ee-notif-icon.success { background: var(--green-100); color: var(--green-800); }
    .ee-notif-icon.info    { background: var(--org-50);    color: var(--org-500); }
    .ee-notif-icon.warning { background: var(--amber-100); color: var(--amber-800); }
    .ee-notif-icon.danger  { background: var(--rose-100);  color: var(--rose-800); }
    .ee-notif-msg { font-size: .8125rem; font-weight: 500; color: var(--text); margin-bottom: .2rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .ee-notif-time { font-size: .6875rem; color: var(--text-3); font-family: var(--font-m); }
    .ee-notif-empty { padding: 2rem; text-align: center; font-size: .8125rem; color: var(--text-2); }

    /* ────────────────────────────────────────
       DRAWER NAV (glisse depuis la gauche)
    ──────────────────────────────────────── */
    .ee-menu-drop {
        position: fixed;
        top: var(--hd-h);
        left: 0; bottom: 0;
        width: 288px;
        z-index: 95;
        background: var(--surface);
        border-right: 1px solid var(--border);
        box-shadow: 4px 0 32px rgba(7,9,46,.16);
        overflow-y: auto;
        overflow-x: hidden;

        /* Hidden — glisse à gauche */
        transform: translateX(-100%);
        pointer-events: none;
        transition: transform .28s cubic-bezier(.4,0,.2,1);
    }
    html.menu-open .ee-menu-drop {
        transform: translateX(0);
        pointer-events: auto;
    }

    .ee-menu-inner {
        padding: .75rem .75rem 1rem;
        min-height: 100%;
        display: flex;
        flex-direction: column;
    }

    /* User card at top of dropdown */
    .ee-menu-user {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .5rem .875rem;
        background: linear-gradient(135deg, var(--org-50) 0%, var(--n-50) 100%);
        border: 1px solid var(--org-100);
        border-radius: var(--r-lg);
        text-decoration: none;
        margin-bottom: .625rem;
        transition: border-color .15s, background .15s;
        position: relative;
        overflow: hidden;
    }
    .ee-menu-user::before {
        content: '';
        position: absolute; left: 0; top: 0; bottom: 0;
        width: 3px;
        background: linear-gradient(180deg, var(--org-400), var(--org-600));
        border-radius: 3px 0 0 3px;
    }
    .ee-menu-user:hover {
        background: linear-gradient(135deg, var(--org-100) 0%, var(--org-50) 100%);
        border-color: var(--org-200);
    }
    .ee-menu-user-avatar {
        width: 36px; height: 36px;
        border-radius: 50%; object-fit: cover;
        border: 2px solid var(--org-200);
        flex-shrink: 0;
        box-shadow: 0 0 0 2px rgba(249,115,22,.12);
    }
    .ee-menu-user-info { min-width: 0; flex: 1; }
    .ee-menu-user-name {
        font-size: .8125rem; font-weight: 600;
        color: var(--text); line-height: 1.2;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .ee-menu-user-role {
        font-size: .6875rem; color: var(--text-2);
        margin-top: 1px;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .ee-menu-user-arrow { color: var(--text-3); flex-shrink: 0; }
    .ee-menu-user-arrow svg { width: 13px; height: 13px; stroke-width: 2; }

    /* Section group */
    .ee-menu-section { margin-bottom: 0; }

    .ee-menu-section-label {
        display: flex;
        align-items: center;
        gap: .4rem;
        padding: .35rem .875rem .15rem;
        font-size: .5625rem; font-weight: 700;
        letter-spacing: .13em; text-transform: uppercase;
        color: var(--text-3);
    }
    .ee-menu-section-label::before {
        content: '';
        display: block;
        width: 3px; height: 3px; border-radius: 50%;
        background: var(--org-400);
        flex-shrink: 0;
    }

    /* Nav link inside dropdown */
    .ee-menu-link {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: 0 .875rem;
        height: 38px;
        border-radius: var(--r);
        text-decoration: none;
        color: var(--text-2);
        font-size: .8125rem; font-weight: 500;
        transition: background .13s, color .13s, box-shadow .13s;
        margin-bottom: 1px;
        position: relative;
    }
    .ee-menu-link svg {
        width: 16px; height: 16px;
        stroke-width: 1.8; flex-shrink: 0;
        color: var(--text-3);
        transition: color .13s;
    }
    .ee-menu-link:hover {
        background: var(--n-50);
        color: var(--text);
    }
    .ee-menu-link:hover svg { color: var(--org-400); }
    .ee-menu-link.active {
        background: var(--org-50);
        color: var(--org-600);
        box-shadow: inset 3px 0 0 var(--org-400);
        font-weight: 600;
    }
    .ee-menu-link.active svg {
        color: var(--org-500);
        filter: drop-shadow(0 0 4px rgba(249,115,22,.4));
    }

    /* Badge on link */
    .ee-menu-badge {
        margin-left: auto; flex-shrink: 0;
        min-width: 16px; height: 16px;
        background: var(--rose-400);
        color: #fff; font-size: .58rem; font-weight: 700;
        border-radius: var(--r-f);
        display: flex; align-items: center; justify-content: center;
        padding: 0 3px;
    }

    /* Divider between sections */
    .ee-menu-divider {
        height: 1px;
        background: var(--n-100);
        margin: .3rem .875rem;
    }

    /* Footer actions — colle en bas du menu fullpage */
    .ee-menu-footer {
        display: flex;
        flex-direction: column;
        gap: 1px;
        padding-top: .375rem;
        margin-top: auto;
        border-top: 1px solid var(--border);
    }
    .ee-menu-footer-form { width: 100%; }
    .ee-menu-footer-btn {
        display: flex; align-items: center; gap: .75rem;
        padding: 0 .875rem;
        height: 38px;
        width: 100%;
        border-radius: var(--r);
        text-decoration: none;
        font-size: .8125rem; font-weight: 500;
        color: var(--text-2);
        background: transparent; border: none; cursor: pointer;
        font-family: var(--font);
        text-align: left;
        transition: background .13s, color .13s;
    }
    .ee-menu-footer-btn svg {
        width: 16px; height: 16px; stroke-width: 1.8; flex-shrink: 0;
    }
    .ee-menu-footer-btn.accent { color: var(--org-500); }
    .ee-menu-footer-btn.accent:hover { background: var(--org-50); color: var(--org-600); }
    .ee-menu-footer-btn.danger:hover { background: var(--rose-100); color: var(--rose-800); }

    /* ────────────────────────────────────────
       OVERLAY — backdrop sombre derrière le drawer
    ──────────────────────────────────────── */
    .ee-overlay {
        position: fixed;
        top: var(--hd-h); left: 0; right: 0; bottom: 0;
        z-index: 90;
        background: rgba(10,14,40,.45);
        backdrop-filter: blur(2px);
        opacity: 0;
        pointer-events: none;
        transition: opacity .28s cubic-bezier(.4,0,.2,1);
        cursor: default;
    }
    html.menu-open .ee-overlay {
        opacity: 1;
        pointer-events: auto;
    }

    /* ────────────────────────────────────────
       MAIN CONTENT
    ──────────────────────────────────────── */
    .ee-main {
        flex: 1;
        margin-top: var(--hd-h);
        display: flex; flex-direction: column;
        min-height: calc(100vh - var(--hd-h));
    }

    /* Breadcrumb sub-bar */
    .ee-breadcrumb-bar {
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        padding: .4rem 1.5rem;
        display: flex; align-items: center; gap: .375rem;
        font-size: .72rem; color: var(--text-3);
    }
    .ee-breadcrumb-bar a { color: var(--org-500); text-decoration: none; font-weight: 500; }
    .ee-breadcrumb-bar a:hover { text-decoration: underline; }
    .ee-breadcrumb-bar svg { width: 9px; height: 9px; opacity: .4; }

    /* Page header (title + breadcrumb inside content area) */
    .ee-page-header {
        margin-bottom: 1.25rem;
    }
    .ee-page-title {
        font-family: var(--font-d);
        font-size: 1.125rem; font-weight: 700;
        color: var(--org-600); letter-spacing: -.02em; line-height: 1.2;
    }

    .ee-content { flex: 1; padding: 1.5rem; }

    .ee-footer {
        padding: .875rem 1.5rem;
        background: var(--surface); border-top: 1px solid var(--border);
        text-align: center;
    }
    .ee-footer p { font-size: .72rem; color: var(--text-3); }
    .ee-footer a { color: var(--org-500); text-decoration: none; font-weight: 600; }
    .ee-footer a:hover { color: var(--org-600); }

    /* ────────────────────────────────────────
       SCROLLBAR
    ──────────────────────────────────────── */
    ::-webkit-scrollbar { width: 4px; height: 4px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: var(--n-200); border-radius: 4px; }
    ::-webkit-scrollbar-thumb:hover { background: var(--n-300); }

    /* ────────────────────────────────────────
       RESPONSIVE
    ──────────────────────────────────────── */
    @media (max-width: 640px) {
        .ee-topnav { padding: 0 .875rem; gap: .625rem; }
        .ee-brand-sub { display: none; }
        .ee-nav-page-title { display: none; }
        .ee-content { padding: .875rem; }
        .ee-breadcrumb-bar { padding: .4rem .875rem; }
        .ee-menu-inner { padding: .75rem .75rem 1rem; }
        .ee-menu-link { height: 48px; }
    }
    @media (max-width: 400px) {
        .ee-brand-name { font-size: .8125rem; }
    }
    </style>
    @yield('styles')
</head>
<body>

<!-- Invisible overlay to close menu on outside click -->
<div class="ee-overlay" id="eeOverlay"></div>

<div class="ee-layout">

    <!-- ════════════════ TOP NAV BAR ════════════════ -->
    <header class="ee-topnav" id="eeTopnav">

        <!-- Left: burger + brand -->
        <div class="ee-topnav-left">
            <button class="ee-burger" id="eeBurger" aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="eeMenuDrop">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <a href="{{ route('espace-employe.dashboard') }}" class="ee-brand-link">
                <div class="ee-brand-mark">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <div>
                    <div class="ee-brand-name">Portail <em>RH+</em></div>
                    <span class="ee-brand-sub">Espace Employé</span>
                </div>
            </a>
        </div>

        <!-- Center: current page title -->
        <div class="ee-topnav-center">
            <span class="ee-nav-page-title">@yield('page-title', 'Mon Espace')</span>
        </div>

        <!-- Right: notifications + avatar -->
        <div class="ee-topnav-right">
            <!-- Notifications -->
            <div class="ee-notif-wrap">
                <button class="ee-header-btn" id="eeNotifBtn" title="Notifications" aria-label="Notifications">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                    <span class="hb-badge" id="eeNotifBadge" style="display:none">0</span>
                </button>
                <div class="ee-notif-drop" id="eeNotifDrop">
                    <div class="ee-notif-drop-head">
                        <span class="ee-notif-drop-title">Notifications</span>
                        <button class="ee-notif-mark-all" id="eeMarkAll">Tout marquer lu</button>
                    </div>
                    <div class="ee-notif-body" id="eeNotifList">
                        <div class="ee-notif-empty">Aucune notification</div>
                    </div>
                </div>
            </div>

            <!-- Avatar -->
            @php $ha = auth()->user(); $hp = $ha->personnel ?? null; @endphp
            <a href="{{ route('espace-employe.profil') }}" class="ee-hd-avatar" title="Mon profil">
                <img
                    src="{{ $hp && $hp->photo ? asset('storage/'.$hp->photo) : 'https://ui-avatars.com/api/?name='.urlencode($ha->name).'&size=200&background=EA580C&color=ffffff&bold=true' }}"
                    alt="{{ $ha->name }}"
                    onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($ha->name) }}&size=200&background=EA580C&color=ffffff&bold=true'">
                <span class="ee-hd-avatar-dot"></span>
            </a>
        </div>

    </header>

    <!-- ════════════════ DROPDOWN NAV MENU ════════════════ -->
    @php
        $mu      = auth()->user();
        $mPerso  = $mu->personnel ?? null;
        $mAvatar = ($mPerso && $mPerso->photo)
            ? asset('storage/' . $mPerso->photo)
            : 'https://ui-avatars.com/api/?name=' . urlencode($mu->name) . '&size=200&background=EA580C&color=ffffff&bold=true';
    @endphp

    <nav class="ee-menu-drop" id="eeMenuDrop" role="navigation" aria-label="Navigation employé">
        <div class="ee-menu-inner">

            <!-- User card -->
            <a href="{{ route('espace-employe.profil') }}" class="ee-menu-user ee-menu-close-trigger">
                <img src="{{ $mAvatar }}" alt="{{ $mu->name }}" class="ee-menu-user-avatar"
                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($mu->name) }}&size=200&background=EA580C&color=ffffff&bold=true'">
                <div class="ee-menu-user-info">
                    <div class="ee-menu-user-name">{{ $mPerso ? $mPerso->nom . ' ' . ($mPerso->prenoms ?? '') : $mu->name }}</div>
                    <div class="ee-menu-user-role">{{ $mPerso->poste ?? 'Employé' }}</div>
                </div>
                <span class="ee-menu-user-arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6"/>
                    </svg>
                </span>
            </a>

            <!-- ── Mon Espace ── -->
            <div class="ee-menu-section">
                <div class="ee-menu-section-label">Mon Espace</div>
                <a href="{{ route('espace-employe.dashboard') }}"
                   class="ee-menu-link ee-menu-close-trigger {{ request()->routeIs('espace-employe.dashboard') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/>
                    </svg>
                    Tableau de bord
                </a>
                <a href="{{ route('espace-employe.profil') }}"
                   class="ee-menu-link ee-menu-close-trigger {{ request()->routeIs('espace-employe.profil') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                    </svg>
                    Mon profil
                </a>
            </div>

            <div class="ee-menu-divider"></div>

            <!-- ── Documents ── -->
            <div class="ee-menu-section">
                <div class="ee-menu-section-label">Documents</div>
                <a href="{{ route('espace-employe.documents') }}"
                   class="ee-menu-link ee-menu-close-trigger {{ request()->routeIs('espace-employe.documents') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                    Mes documents
                </a>
                <a href="{{ route('espace-employe.bulletins') }}"
                   class="ee-menu-link ee-menu-close-trigger {{ request()->routeIs('espace-employe.bulletins') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="3" width="20" height="14" rx="2"/>
                        <line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>
                    </svg>
                    Bulletins de paie
                </a>
                <a href="{{ route('espace-employe.attestations') }}"
                   class="ee-menu-link ee-menu-close-trigger {{ request()->routeIs('espace-employe.attestations') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        <path d="M9 12l2 2 4-4"/>
                    </svg>
                    Attestations
                </a>
            </div>

            <div class="ee-menu-divider"></div>

            <!-- ── Demandes ── -->
            <div class="ee-menu-section">
                <div class="ee-menu-section-label">Demandes</div>
                <a href="{{ route('espace-employe.conges') }}"
                   class="ee-menu-link ee-menu-close-trigger {{ request()->routeIs('espace-employe.conges') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/><path d="M9 16l2 2 4-4"/>
                    </svg>
                    Mes congés
                </a>
                <a href="{{ route('espace-employe.absences') }}"
                   class="ee-menu-link ee-menu-close-trigger {{ request()->routeIs('espace-employe.absences') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                    </svg>
                    Mes absences
                </a>
                <a href="{{ route('espace-employe.demandes') }}"
                   class="ee-menu-link ee-menu-close-trigger {{ request()->routeIs('espace-employe.demandes') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                        <rect x="8" y="2" width="8" height="4" rx="1"/><path d="M9 14l2 2 4-4"/>
                    </svg>
                    Mes demandes
                </a>
            </div>

            <div class="ee-menu-divider"></div>

            <!-- ── Compte ── -->
            <div class="ee-menu-section">
                <div class="ee-menu-section-label">Compte</div>
                <a href="{{ route('espace-employe.assistance') }}"
                   class="ee-menu-link ee-menu-close-trigger {{ request()->routeIs('espace-employe.assistance*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                        <line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                    Assistance
                </a>
                <a href="{{ route('espace-employe.parametres') }}"
                   class="ee-menu-link ee-menu-close-trigger {{ request()->routeIs('espace-employe.parametres') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                    </svg>
                    Paramètres
                </a>
            </div>

            <!-- ── Footer actions ── -->
            <div class="ee-menu-footer">
                @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'RH']))
                <a href="{{ route('admin.dashboard') }}" class="ee-menu-footer-btn accent ee-menu-close-trigger">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                        <path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/>
                    </svg>
                    Portail Admin
                </a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="ee-menu-footer-form">
                    @csrf
                    <button type="submit" class="ee-menu-footer-btn danger">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                            <polyline points="16 17 21 12 16 7"/>
                            <line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                        Déconnexion
                    </button>
                </form>
            </div>

        </div>
    </nav>

    <!-- ════════════════ MAIN ════════════════ -->
    <main class="ee-main">

        @hasSection('breadcrumb')
            <div class="ee-breadcrumb-bar">
                <nav>@yield('breadcrumb')</nav>
            </div>
        @endif

        <div class="ee-content">
            @yield('content')
        </div>

        <footer class="ee-footer">
            <p>&copy; {{ date('Y') }} <a href="#">Portail RH+</a> &mdash; Tous droits réservés</p>
        </footer>

    </main>

</div>

@yield('scripts')

<script>
(function () {
    'use strict';

    var html    = document.documentElement;
    var burger  = document.getElementById('eeBurger');
    var menu    = document.getElementById('eeMenuDrop');
    var overlay = document.getElementById('eeOverlay');

    /* ── Toggle menu ── */
    function openMenu() {
        html.classList.add('menu-open');
        if (burger) burger.setAttribute('aria-expanded', 'true');
    }
    function closeMenu() {
        html.classList.remove('menu-open');
        if (burger) burger.setAttribute('aria-expanded', 'false');
    }
    function toggleMenu() {
        html.classList.contains('menu-open') ? closeMenu() : openMenu();
    }

    if (burger) {
        burger.addEventListener('click', function (e) {
            e.stopPropagation();
            toggleMenu();
        });
    }

    /* ── Close on overlay click ── */
    if (overlay) {
        overlay.addEventListener('click', closeMenu);
    }

    /* ── Close on nav link click ── */
    document.querySelectorAll('.ee-menu-close-trigger').forEach(function (el) {
        el.addEventListener('click', closeMenu);
    });

    /* ── Close on Escape ── */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeMenu();
    });

    /* ── Notifications ── */
    var notifBtn  = document.getElementById('eeNotifBtn');
    var notifDrop = document.getElementById('eeNotifDrop');
    var notifBadge = document.getElementById('eeNotifBadge');
    var notifList = document.getElementById('eeNotifList');
    var markAll   = document.getElementById('eeMarkAll');

    var iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>';

    function fetchNotifs() {
        fetch('/notifications/unread', {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(function (r) { return r.ok ? r.json() : Promise.reject(); })
        .then(function (d) {
            var items = d.notifications || [];
            if (items.length) {
                notifBadge.textContent = items.length > 9 ? '9+' : items.length;
                notifBadge.style.display = 'flex';
                notifBtn.classList.add('ee-notif-dot');
            } else {
                notifBadge.style.display = 'none';
                notifBtn.classList.remove('ee-notif-dot');
            }
            notifList.innerHTML = items.length
                ? items.map(function (n) {
                    return '<div class="ee-notif-item" data-id="' + n.id + '">' +
                        '<div class="ee-notif-icon ' + (n.type || 'info') + '">' + iconSvg + '</div>' +
                        '<div><div class="ee-notif-msg">' + (n.message || (n.data && n.data.message) || '') + '</div>' +
                        '<div class="ee-notif-time">' + (n.time || '') + '</div></div></div>';
                }).join('')
                : '<div class="ee-notif-empty">Aucune notification</div>';
        })
        .catch(function () {});
    }

    if (notifBtn && notifDrop) {
        notifBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            /* Close burger menu if open */
            closeMenu();
            notifDrop.classList.toggle('open');
            if (notifDrop.classList.contains('open')) fetchNotifs();
        });
        document.addEventListener('click', function (e) {
            if (!notifDrop.contains(e.target) && e.target !== notifBtn) {
                notifDrop.classList.remove('open');
            }
        });
    }

    if (markAll) {
        markAll.addEventListener('click', function () {
            fetch('/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            }).then(fetchNotifs);
        });
    }

    fetchNotifs();
    setInterval(fetchNotifs, 45000);

})();
</script>
</body>
</html>
