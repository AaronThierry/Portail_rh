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
       PORTAIL RH+  ·  ESPACE EMPLOYÉ  ·  Pro Layout v3
       ═══════════════════════════════════════════════════════════════ */

    :root {
        --org-50:  #FFF7ED; --org-100: #FFEDD5; --org-200: #FED7AA;
        --org-300: #FB923C; --org-400: #F97316;
        --org-500: #EA580C; --org-600: #C2470A; --org-700: #9A3B08;

        --amber-100: #FEF3C7; --amber-400: #F59E0B; --amber-800: #78350F;
        --rose-100:  #FFE4E6; --rose-400:  #FB7185; --rose-800:  #9F1239;
        --green-100: #D1FAE5; --green-400: #34D399; --green-800: #065F46;

        --n-50:  #F8F9FA; --n-100: #F0F2F5;
        --n-200: #E2E5EA; --n-300: #C8CDD7; --n-400: #9CA3B0;
        --n-500: #6B7382; --n-600: #4B5263; --n-700: #343A47; --n-800: #1E2330;

        --bg:      #F1F3F7;
        --surface: #FFFFFF;
        --border:  #E2E5EA;
        --text:    #1A2030;
        --text-2:  #6B7382;
        --text-3:  #9CA3B0;

        --shadow-sm: 0 1px 3px rgba(10,16,64,.06);
        --shadow:    0 2px 8px rgba(10,16,64,.08), 0 1px 3px rgba(10,16,64,.04);
        --shadow-md: 0 4px 16px rgba(10,16,64,.10);
        --shadow-lg: 0 12px 32px rgba(10,16,64,.12), 0 4px 10px rgba(10,16,64,.06);
        --shadow-xl: 0 24px 48px rgba(10,16,64,.14), 0 8px 16px rgba(10,16,64,.06);

        --hd-h: 62px;

        /* Topnav tokens */
        --tn-bg:       rgba(12, 4, 0, 0.96);
        --tn-text:     rgba(255,255,255,.92);
        --tn-text-dim: rgba(255,255,255,.48);
        --tn-sep:      rgba(255,255,255,.1);

        /* Drawer tokens (dark) */
        --dr-bg:          #0C0400;
        --dr-bg-2:        #160700;
        --dr-border:      rgba(255,255,255,.06);
        --dr-text:        rgba(255,255,255,.88);
        --dr-text-dim:    rgba(255,255,255,.42);
        --dr-item-hover:  rgba(255,255,255,.055);
        --dr-item-active: rgba(249,115,22,.13);

        --font:   'DM Sans', system-ui, sans-serif;
        --font-d: 'Syne', 'DM Sans', system-ui, sans-serif;
        --font-m: 'DM Mono', monospace;
        --r-sm: 4px; --r: 8px; --r-lg: 12px; --r-xl: 16px; --r-2xl: 24px; --r-f: 9999px;
    }

    @keyframes slideDown { from { opacity:0; transform:translateY(-6px)  } to { opacity:1; transform:translateY(0) } }
    @keyframes fadeIn    { from { opacity:0 } to { opacity:1 } }

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

    /* ════════════════════════════════════════
       TOP NAV — glassmorphism pro
    ════════════════════════════════════════ */
    .ee-topnav {
        position: fixed;
        top: 0; left: 0; right: 0;
        height: var(--hd-h);
        z-index: 100;
        background: var(--tn-bg);
        backdrop-filter: blur(20px) saturate(1.6);
        -webkit-backdrop-filter: blur(20px) saturate(1.6);
        /* Bottom edge: orange accent + shadow */
        border-bottom: 1px solid rgba(249,115,22,.18);
        box-shadow:
            0 1px 0 rgba(249,115,22,.08),
            0 4px 32px rgba(0,0,0,.5);
        display: flex;
        align-items: center;
        padding: 0 1.25rem;
        gap: 0;
    }

    /* ── Left zone: burger + brand ── */
    .ee-tn-left {
        display: flex;
        align-items: center;
        gap: .75rem;
        flex-shrink: 0;
    }

    /* ── Center zone: page title ── */
    .ee-tn-center {
        flex: 1;
        min-width: 0;
        padding: 0 1.25rem;
        display: flex;
        align-items: center;
    }

    .ee-tn-page-title {
        font-family: var(--font-d);
        font-size: .9rem; font-weight: 600;
        color: rgba(255,255,255,.6);
        letter-spacing: -.01em;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }

    /* ── Right zone: actions + user ── */
    .ee-tn-right {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        gap: .25rem;
    }

    /* ── Burger ── */
    .ee-burger {
        width: 36px; height: 36px;
        border: none; border-radius: var(--r);
        background: transparent;
        cursor: pointer;
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        gap: 5px; padding: 0;
        transition: background .15s;
        flex-shrink: 0;
    }
    .ee-burger:hover { background: rgba(255,255,255,.08); }
    html.menu-open .ee-burger { background: rgba(249,115,22,.15); }
    .ee-burger span {
        display: block;
        width: 18px; height: 1.5px;
        background: var(--tn-text);
        border-radius: 2px;
        transition: transform .26s cubic-bezier(.4,0,.2,1), opacity .2s, width .22s;
    }
    html.menu-open .ee-burger span:nth-child(1) { transform: translateY(6.5px) rotate(45deg); }
    html.menu-open .ee-burger span:nth-child(2) { opacity: 0; width: 0; }
    html.menu-open .ee-burger span:nth-child(3) { transform: translateY(-6.5px) rotate(-45deg); }

    /* ── Brand ── */
    .ee-brand-link {
        display: flex; align-items: center; gap: 9px;
        text-decoration: none; flex-shrink: 0;
    }
    .ee-brand-mark {
        width: 32px; height: 32px;
        background: linear-gradient(135deg, var(--org-600) 0%, var(--org-400) 100%);
        border-radius: var(--r);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 0 0 1px rgba(249,115,22,.3), 0 4px 12px rgba(249,115,22,.35);
    }
    .ee-brand-mark svg { width: 15px; height: 15px; color: #fff; stroke-width: 2.2; }
    .ee-brand-info { display: flex; flex-direction: column; }
    .ee-brand-name {
        font-family: var(--font-d);
        font-size: .9375rem; font-weight: 700;
        color: var(--tn-text); letter-spacing: -.025em; line-height: 1.1;
    }
    .ee-brand-name em { font-style: normal; color: var(--org-300); }
    .ee-brand-sub {
        font-size: .5rem; font-weight: 600;
        color: var(--tn-text-dim); letter-spacing: .12em; text-transform: uppercase;
        margin-top: 1px;
    }

    /* ── Topnav separator ── */
    .ee-tn-sep {
        width: 1px; height: 20px;
        background: var(--tn-sep);
        margin: 0 .375rem;
        flex-shrink: 0;
    }

    /* ── Action buttons (notif, etc.) ── */
    .ee-tn-btn {
        position: relative;
        width: 36px; height: 36px;
        border: none; border-radius: var(--r);
        background: transparent;
        color: var(--tn-text-dim);
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: background .14s, color .14s;
        flex-shrink: 0;
    }
    .ee-tn-btn:hover {
        background: rgba(255,255,255,.08);
        color: var(--tn-text);
    }
    .ee-tn-btn svg { width: 17px; height: 17px; stroke-width: 1.7; }

    /* Notif badge */
    .ee-tn-btn .hb-badge {
        position: absolute; top: 4px; right: 4px;
        width: 7px; height: 7px;
        background: var(--rose-400);
        border-radius: 50%;
        border: 1.5px solid var(--tn-bg);
        display: none;
    }
    .ee-tn-btn.has-notif .hb-badge { display: block; }

    /* Full badge (number) */
    .ee-tn-btn .hb-count {
        position: absolute; top: -4px; right: -4px;
        min-width: 16px; height: 16px;
        background: var(--rose-400); color: #fff;
        font-size: .5rem; font-weight: 700; border-radius: var(--r-f);
        display: none; align-items: center; justify-content: center;
        padding: 0 3px; border: 2px solid rgba(12,4,0,.8);
    }

    /* ── User pill button ── */
    .ee-tn-user-wrap { position: relative; }
    .ee-tn-user {
        display: flex; align-items: center; gap: .5rem;
        padding: .25rem .625rem .25rem .25rem;
        border: 1px solid rgba(255,255,255,.1);
        border-radius: var(--r-f);
        background: rgba(255,255,255,.06);
        cursor: pointer;
        font-family: var(--font);
        transition: background .14s, border-color .14s;
        flex-shrink: 0;
    }
    .ee-tn-user:hover {
        background: rgba(255,255,255,.1);
        border-color: rgba(255,255,255,.18);
    }
    html.user-menu-open .ee-tn-user {
        background: rgba(249,115,22,.12);
        border-color: rgba(249,115,22,.3);
    }
    .ee-tn-avatar {
        width: 28px; height: 28px; border-radius: 50%; object-fit: cover;
        border: 1.5px solid rgba(249,115,22,.4); display: block; flex-shrink: 0;
    }
    .ee-tn-user-name {
        font-size: .78rem; font-weight: 600;
        color: var(--tn-text);
        max-width: 110px;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .ee-tn-chevron {
        width: 12px; height: 12px; stroke-width: 2.5;
        color: var(--tn-text-dim); flex-shrink: 0;
        transition: transform .2s;
    }
    html.user-menu-open .ee-tn-chevron { transform: rotate(180deg); }

    /* ── User dropdown ── */
    .ee-user-drop {
        position: absolute; top: calc(100% + 8px); right: 0;
        width: 210px;
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--r-xl); box-shadow: var(--shadow-xl);
        z-index: 200; overflow: hidden;
        display: none;
    }
    .ee-user-drop.open { display: block; animation: slideDown .16s ease; }

    .ee-user-drop-head {
        padding: .875rem 1rem .75rem;
        background: var(--n-50);
        border-bottom: 1px solid var(--n-100);
    }
    .ee-user-drop-name {
        font-size: .8125rem; font-weight: 700; color: var(--text); line-height: 1.2;
    }
    .ee-user-drop-role {
        font-size: .6875rem; color: var(--text-2); margin-top: 2px;
    }
    .ee-user-drop-badge {
        display: inline-flex; align-items: center; gap: 4px;
        margin-top: 5px;
        font-size: .6rem; font-weight: 600; color: var(--green-800);
        background: var(--green-100);
        padding: 1px 7px; border-radius: var(--r-f);
    }
    .ee-user-drop-badge::before {
        content: '';
        width: 5px; height: 5px; border-radius: 50%;
        background: var(--green-400);
        display: block;
    }

    .ee-user-drop-body { padding: .375rem 0; }
    .ee-user-drop-link {
        display: flex; align-items: center; gap: .625rem;
        padding: .5rem 1rem;
        font-size: .8125rem; font-weight: 500; color: var(--text-2);
        text-decoration: none;
        transition: background .12s, color .12s;
    }
    .ee-user-drop-link:hover { background: var(--n-50); color: var(--text); }
    .ee-user-drop-link svg { width: 14px; height: 14px; stroke-width: 1.8; flex-shrink: 0; color: var(--text-3); }
    .ee-user-drop-link:hover svg { color: var(--org-400); }
    .ee-user-drop-divider { height: 1px; background: var(--n-100); margin: .25rem 0; }
    .ee-user-drop-form { width: 100%; }
    .ee-user-drop-logout {
        display: flex; align-items: center; gap: .625rem;
        width: 100%; padding: .5rem 1rem;
        font-size: .8125rem; font-weight: 500; color: var(--text-2);
        background: transparent; border: none; cursor: pointer;
        font-family: var(--font); text-align: left;
        transition: background .12s, color .12s;
    }
    .ee-user-drop-logout:hover { background: var(--rose-100); color: var(--rose-800); }
    .ee-user-drop-logout svg { width: 14px; height: 14px; stroke-width: 1.8; flex-shrink: 0; }

    /* ════════════════════════════════════════
       NOTIFICATION DROPDOWN
    ════════════════════════════════════════ */
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

    /* ════════════════════════════════════════
       DRAWER — dark, slide from left
    ════════════════════════════════════════ */
    .ee-drawer {
        position: fixed;
        top: var(--hd-h); left: 0; bottom: 0;
        width: 272px;
        z-index: 95;
        display: flex; flex-direction: column;
        background: linear-gradient(180deg, var(--dr-bg) 0%, var(--dr-bg-2) 100%);
        border-right: 1px solid var(--dr-border);
        box-shadow: 6px 0 40px rgba(0,0,0,.55);
        overflow: hidden;

        /* Hidden state */
        transform: translateX(-100%);
        pointer-events: none;
        transition: transform .28s cubic-bezier(.4,0,.2,1);
    }
    html.menu-open .ee-drawer {
        transform: translateX(0);
        pointer-events: auto;
    }

    /* ── Drawer user header ── */
    .ee-dr-user {
        display: flex; align-items: center; gap: .75rem;
        padding: 1rem 1rem .875rem;
        border-bottom: 1px solid var(--dr-border);
        background: linear-gradient(135deg, rgba(249,115,22,.09) 0%, transparent 70%);
        text-decoration: none;
        flex-shrink: 0;
        transition: background .15s;
        position: relative;
        overflow: hidden;
    }
    .ee-dr-user::after {
        content: '';
        position: absolute; top: 0; left: 0; right: 0;
        height: 1px;
        background: linear-gradient(90deg, var(--org-500), transparent);
        opacity: .4;
    }
    .ee-dr-user:hover {
        background: linear-gradient(135deg, rgba(249,115,22,.15) 0%, transparent 70%);
    }
    .ee-dr-avatar {
        width: 40px; height: 40px; border-radius: 50%; object-fit: cover;
        border: 2px solid rgba(249,115,22,.3);
        flex-shrink: 0;
        box-shadow: 0 0 0 3px rgba(249,115,22,.08);
    }
    .ee-dr-user-info { min-width: 0; flex: 1; }
    .ee-dr-user-name {
        font-size: .8rem; font-weight: 600;
        color: var(--dr-text); line-height: 1.2;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .ee-dr-user-role {
        font-size: .6875rem; color: var(--dr-text-dim);
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        margin-top: 1px;
    }
    .ee-dr-online {
        display: flex; align-items: center; gap: 4px;
        font-size: .6rem; font-weight: 500; color: var(--green-400);
        margin-top: 4px; letter-spacing: .02em;
    }
    .ee-dr-online-dot {
        width: 5px; height: 5px; border-radius: 50%;
        background: var(--green-400);
        box-shadow: 0 0 5px rgba(52,211,153,.6);
        flex-shrink: 0;
    }

    /* ── Nav scrollable area ── */
    .ee-dr-nav {
        flex: 1;
        overflow-y: auto; overflow-x: hidden;
        padding: .5rem 0;
        scrollbar-width: none;
    }
    .ee-dr-nav::-webkit-scrollbar { display: none; }

    /* Section */
    .ee-dr-section { margin-bottom: .125rem; }

    .ee-dr-label {
        display: flex; align-items: center; gap: .5rem;
        padding: .5rem 1.125rem .2rem;
        font-size: .5625rem; font-weight: 700;
        letter-spacing: .13em; text-transform: uppercase;
        color: rgba(255,255,255,.25);
    }
    .ee-dr-label::after {
        content: '';
        flex: 1; height: 1px;
        background: linear-gradient(90deg, rgba(255,255,255,.08), transparent);
    }

    /* Nav link */
    .ee-dr-link {
        display: flex; align-items: center; gap: .75rem;
        margin: 0 .5rem 1px;
        padding: 0 .75rem;
        height: 38px;
        border-radius: var(--r);
        text-decoration: none;
        color: var(--dr-text-dim);
        font-size: .8125rem; font-weight: 500;
        transition: background .13s, color .13s;
        position: relative;
        overflow: hidden;
    }
    .ee-dr-link svg {
        width: 15px; height: 15px; stroke-width: 1.8;
        flex-shrink: 0; transition: color .13s;
    }
    .ee-dr-link:hover {
        background: var(--dr-item-hover);
        color: rgba(255,255,255,.75);
    }
    .ee-dr-link:hover svg { color: rgba(249,115,22,.7); }
    .ee-dr-link.active {
        background: var(--dr-item-active);
        color: var(--org-300);
        font-weight: 600;
    }
    .ee-dr-link.active::before {
        content: '';
        position: absolute; left: -.5rem; top: 50%;
        transform: translateY(-50%);
        width: 3px; height: 18px;
        background: linear-gradient(180deg, var(--org-300), var(--org-500));
        border-radius: 0 3px 3px 0;
    }
    .ee-dr-link.active svg { color: var(--org-400); filter: drop-shadow(0 0 4px rgba(249,115,22,.4)); }

    /* Badge */
    .ee-dr-badge {
        margin-left: auto; flex-shrink: 0;
        min-width: 16px; height: 16px;
        background: var(--rose-400);
        color: #fff; font-size: .58rem; font-weight: 700;
        border-radius: var(--r-f);
        display: flex; align-items: center; justify-content: center;
        padding: 0 3px;
    }

    /* Section divider */
    .ee-dr-divider {
        height: 1px;
        background: var(--dr-border);
        margin: .375rem .875rem;
    }

    /* ── Drawer footer ── */
    .ee-dr-footer {
        flex-shrink: 0;
        padding: .5rem .5rem .875rem;
        border-top: 1px solid var(--dr-border);
        background: rgba(0,0,0,.15);
        display: flex; flex-direction: column; gap: 1px;
    }
    .ee-dr-footer-form { width: 100%; }
    .ee-dr-footer-btn {
        display: flex; align-items: center; gap: .75rem;
        padding: 0 .75rem;
        height: 36px;
        border-radius: var(--r);
        text-decoration: none;
        font-size: .78rem; font-weight: 500;
        color: var(--dr-text-dim);
        background: transparent; border: none; cursor: pointer;
        font-family: var(--font); width: 100%; text-align: left;
        transition: background .13s, color .13s;
    }
    .ee-dr-footer-btn svg { width: 14px; height: 14px; stroke-width: 1.8; flex-shrink: 0; }
    .ee-dr-footer-btn.accent { color: rgba(249,115,22,.7); }
    .ee-dr-footer-btn.accent:hover { background: rgba(249,115,22,.1); color: var(--org-300); }
    .ee-dr-footer-btn.danger:hover { background: rgba(251,113,133,.1); color: #fb7185; }

    /* Drawer version tag */
    .ee-dr-version {
        padding: .5rem 1.125rem .25rem;
        font-size: .5625rem; color: rgba(255,255,255,.18);
        font-family: var(--font-m);
        letter-spacing: .06em;
    }

    /* ════════════════════════════════════════
       OVERLAY — backdrop behind drawer
    ════════════════════════════════════════ */
    .ee-overlay {
        position: fixed;
        top: var(--hd-h); left: 0; right: 0; bottom: 0;
        z-index: 90;
        background: rgba(8,3,0,.5);
        backdrop-filter: blur(3px);
        opacity: 0;
        pointer-events: none;
        transition: opacity .28s cubic-bezier(.4,0,.2,1);
        cursor: default;
    }
    html.menu-open .ee-overlay { opacity: 1; pointer-events: auto; }

    /* ════════════════════════════════════════
       MAIN CONTENT
    ════════════════════════════════════════ */
    .ee-main {
        flex: 1;
        margin-top: var(--hd-h);
        display: flex; flex-direction: column;
        min-height: calc(100vh - var(--hd-h));
    }

    /* Breadcrumb bar */
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

    .ee-content { flex: 1; padding: 1.5rem; }

    .ee-footer {
        padding: .875rem 1.5rem;
        background: var(--surface); border-top: 1px solid var(--border);
        text-align: center;
    }
    .ee-footer p { font-size: .72rem; color: var(--text-3); }
    .ee-footer a { color: var(--org-500); text-decoration: none; font-weight: 600; }
    .ee-footer a:hover { color: var(--org-600); }

    /* ════════════════════════════════════════
       SCROLLBAR
    ════════════════════════════════════════ */
    ::-webkit-scrollbar { width: 4px; height: 4px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: var(--n-200); border-radius: 4px; }
    ::-webkit-scrollbar-thumb:hover { background: var(--n-300); }

    /* ════════════════════════════════════════
       RESPONSIVE
    ════════════════════════════════════════ */
    @media (max-width: 768px) {
        .ee-tn-user-name { display: none; }
        .ee-tn-chevron   { display: none; }
        .ee-tn-user { padding: .25rem .25rem; border-radius: 50%; }
    }
    @media (max-width: 640px) {
        .ee-topnav { padding: 0 .875rem; }
        .ee-brand-sub { display: none; }
        .ee-tn-page-title { display: none; }
        .ee-content { padding: .875rem; }
        .ee-breadcrumb-bar { padding: .4rem .875rem; }
    }
    @media (max-width: 380px) {
        .ee-brand-name { font-size: .8125rem; }
        .ee-brand-info { display: none; }
    }
    </style>
    @yield('styles')
</head>
<body>

<div class="ee-overlay" id="eeOverlay"></div>

<div class="ee-layout">

    <!-- ════════════════ TOP NAV ════════════════ -->
    @php
        $tnUser  = auth()->user();
        $tnPerso = $tnUser->personnel ?? null;
        $tnName  = $tnPerso ? trim($tnPerso->nom . ' ' . ($tnPerso->prenoms ?? '')) : $tnUser->name;
        $tnAvatar = ($tnPerso && $tnPerso->photo)
            ? asset('storage/' . $tnPerso->photo)
            : 'https://ui-avatars.com/api/?name=' . urlencode($tnUser->name) . '&size=200&background=EA580C&color=ffffff&bold=true';
    @endphp

    <header class="ee-topnav" id="eeTopnav">

        <!-- Left: burger + brand -->
        <div class="ee-tn-left">
            <button class="ee-burger" id="eeBurger" aria-label="Menu" aria-expanded="false" aria-controls="eeDrawer">
                <span></span><span></span><span></span>
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
                <div class="ee-brand-info">
                    <span class="ee-brand-name">Portail <em>RH+</em></span>
                    <span class="ee-brand-sub">Espace Employé</span>
                </div>
            </a>
        </div>

        <!-- Center: page title -->
        <div class="ee-tn-center">
            <span class="ee-tn-page-title">@yield('page-title', 'Mon Espace')</span>
        </div>

        <!-- Right: notif + user -->
        <div class="ee-tn-right">

            <!-- Notifications -->
            <div class="ee-notif-wrap">
                <button class="ee-tn-btn" id="eeNotifBtn" title="Notifications" aria-label="Notifications">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                    <span class="hb-badge" id="eeNotifBadge"></span>
                    <span class="hb-count" id="eeNotifCount"></span>
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

            <div class="ee-tn-sep"></div>

            <!-- User pill + dropdown -->
            <div class="ee-tn-user-wrap">
                <button class="ee-tn-user" id="eeUserBtn" aria-haspopup="true" aria-expanded="false">
                    <img class="ee-tn-avatar"
                         src="{{ $tnAvatar }}"
                         alt="{{ $tnName }}"
                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($tnUser->name) }}&size=200&background=EA580C&color=ffffff&bold=true'">
                    <span class="ee-tn-user-name">{{ $tnPerso->nom ?? $tnUser->name }}</span>
                    <svg class="ee-tn-chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </button>

                <div class="ee-user-drop" id="eeUserDrop" role="menu">
                    <div class="ee-user-drop-head">
                        <div class="ee-user-drop-name">{{ $tnName }}</div>
                        <div class="ee-user-drop-role">{{ $tnPerso->poste ?? 'Employé' }}</div>
                        <span class="ee-user-drop-badge">En ligne</span>
                    </div>
                    <div class="ee-user-drop-body">
                        <a href="{{ route('espace-employe.profil') }}" class="ee-user-drop-link ee-close-user">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            Mon profil
                        </a>
                        <a href="{{ route('espace-employe.parametres') }}" class="ee-user-drop-link ee-close-user">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                            Paramètres
                        </a>
                        <div class="ee-user-drop-divider"></div>
                        <form method="POST" action="{{ route('logout') }}" class="ee-user-drop-form">
                            @csrf
                            <button type="submit" class="ee-user-drop-logout">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </header>

    <!-- ════════════════ DRAWER NAV ════════════════ -->
    @php
        $drUser  = auth()->user();
        $drPerso = $drUser->personnel ?? null;
        $drName  = $drPerso ? trim($drPerso->nom . ' ' . ($drPerso->prenoms ?? '')) : $drUser->name;
        $drAvatar = ($drPerso && $drPerso->photo)
            ? asset('storage/' . $drPerso->photo)
            : 'https://ui-avatars.com/api/?name=' . urlencode($drUser->name) . '&size=200&background=EA580C&color=ffffff&bold=true';
    @endphp

    <nav class="ee-drawer" id="eeDrawer" role="navigation" aria-label="Navigation employé">

        <!-- User header -->
        <a href="{{ route('espace-employe.profil') }}" class="ee-dr-user ee-drawer-close">
            <img src="{{ $drAvatar }}" alt="{{ $drName }}" class="ee-dr-avatar"
                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($drUser->name) }}&size=200&background=EA580C&color=ffffff&bold=true'">
            <div class="ee-dr-user-info">
                <div class="ee-dr-user-name">{{ $drName }}</div>
                <div class="ee-dr-user-role">{{ $drPerso->poste ?? 'Employé' }}</div>
                <div class="ee-dr-online"><span class="ee-dr-online-dot"></span> En ligne</div>
            </div>
        </a>

        <!-- Scrollable nav -->
        <div class="ee-dr-nav">

            <!-- Mon Espace -->
            <div class="ee-dr-section">
                <span class="ee-dr-label">Mon Espace</span>
                <a href="{{ route('espace-employe.dashboard') }}"
                   class="ee-dr-link ee-drawer-close {{ request()->routeIs('espace-employe.dashboard') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
                    Tableau de bord
                </a>
                <a href="{{ route('espace-employe.profil') }}"
                   class="ee-dr-link ee-drawer-close {{ request()->routeIs('espace-employe.profil') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Mon profil
                </a>
            </div>

            <div class="ee-dr-divider"></div>

            <!-- Documents -->
            <div class="ee-dr-section">
                <span class="ee-dr-label">Documents</span>
                <a href="{{ route('espace-employe.documents') }}"
                   class="ee-dr-link ee-drawer-close {{ request()->routeIs('espace-employe.documents') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    Mes documents
                </a>
                <a href="{{ route('espace-employe.bulletins') }}"
                   class="ee-dr-link ee-drawer-close {{ request()->routeIs('espace-employe.bulletins') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                    Bulletins de paie
                </a>
                <a href="{{ route('espace-employe.attestations') }}"
                   class="ee-dr-link ee-drawer-close {{ request()->routeIs('espace-employe.attestations') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>
                    Attestations
                </a>
            </div>

            <div class="ee-dr-divider"></div>

            <!-- Demandes -->
            <div class="ee-dr-section">
                <span class="ee-dr-label">Demandes</span>
                <a href="{{ route('espace-employe.conges') }}"
                   class="ee-dr-link ee-drawer-close {{ request()->routeIs('espace-employe.conges') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><path d="M9 16l2 2 4-4"/></svg>
                    Mes congés
                </a>
                <a href="{{ route('espace-employe.absences') }}"
                   class="ee-dr-link ee-drawer-close {{ request()->routeIs('espace-employe.absences') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                    Mes absences
                </a>
                <a href="{{ route('espace-employe.demandes') }}"
                   class="ee-dr-link ee-drawer-close {{ request()->routeIs('espace-employe.demandes') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1"/><path d="M9 14l2 2 4-4"/></svg>
                    Mes demandes
                </a>
            </div>

            <div class="ee-dr-divider"></div>

            <!-- Compte -->
            <div class="ee-dr-section">
                <span class="ee-dr-label">Compte</span>
                <a href="{{ route('espace-employe.assistance') }}"
                   class="ee-dr-link ee-drawer-close {{ request()->routeIs('espace-employe.assistance*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    Assistance
                </a>
                <a href="{{ route('espace-employe.parametres') }}"
                   class="ee-dr-link ee-drawer-close {{ request()->routeIs('espace-employe.parametres') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                    Paramètres
                </a>
            </div>

            <div class="ee-dr-version">PORTAIL RH+ · v2.0</div>

        </div>

        <!-- Footer: admin switch + logout -->
        <div class="ee-dr-footer">
            @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'RH']))
            <a href="{{ route('admin.dashboard') }}" class="ee-dr-footer-btn accent ee-drawer-close">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                Portail Admin
            </a>
            @endif
            <form method="POST" action="{{ route('logout') }}" class="ee-dr-footer-form">
                @csrf
                <button type="submit" class="ee-dr-footer-btn danger">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Déconnexion
                </button>
            </form>
        </div>

    </nav>

    <!-- ════════════════ MAIN ════════════════ -->
    <main class="ee-main">

        @hasSection('breadcrumb')
            <div class="ee-breadcrumb-bar"><nav>@yield('breadcrumb')</nav></div>
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
    var drawer  = document.getElementById('eeDrawer');
    var overlay = document.getElementById('eeOverlay');
    var userBtn = document.getElementById('eeUserBtn');
    var userDrop= document.getElementById('eeUserDrop');

    /* ── Drawer ── */
    function openDrawer()  { html.classList.add('menu-open');    if(burger) burger.setAttribute('aria-expanded','true'); }
    function closeDrawer() { html.classList.remove('menu-open'); if(burger) burger.setAttribute('aria-expanded','false'); }

    if (burger)  burger.addEventListener('click', function(e){ e.stopPropagation(); html.classList.contains('menu-open') ? closeDrawer() : openDrawer(); });
    if (overlay) overlay.addEventListener('click', function(){ closeDrawer(); closeUserMenu(); });

    document.querySelectorAll('.ee-drawer-close').forEach(function(el){
        el.addEventListener('click', closeDrawer);
    });

    /* ── User dropdown ── */
    function openUserMenu() {
        html.classList.add('user-menu-open');
        if(userDrop) userDrop.classList.add('open');
        if(userBtn)  userBtn.setAttribute('aria-expanded','true');
    }
    function closeUserMenu() {
        html.classList.remove('user-menu-open');
        if(userDrop) userDrop.classList.remove('open');
        if(userBtn)  userBtn.setAttribute('aria-expanded','false');
    }

    if (userBtn) {
        userBtn.addEventListener('click', function(e){
            e.stopPropagation();
            closeDrawer();
            userDrop && userDrop.classList.contains('open') ? closeUserMenu() : openUserMenu();
        });
    }
    document.querySelectorAll('.ee-close-user').forEach(function(el){
        el.addEventListener('click', closeUserMenu);
    });
    document.addEventListener('click', function(e){
        if (userDrop && !userDrop.contains(e.target) && e.target !== userBtn) closeUserMenu();
        if (drawer   && !drawer.contains(e.target)   && e.target !== burger)  closeDrawer();
    });
    document.addEventListener('keydown', function(e){ if(e.key==='Escape'){ closeDrawer(); closeUserMenu(); } });

    /* ── Notifications ── */
    var notifBtn  = document.getElementById('eeNotifBtn');
    var notifDrop = document.getElementById('eeNotifDrop');
    var notifBadge= document.getElementById('eeNotifBadge');
    var notifList = document.getElementById('eeNotifList');
    var markAll   = document.getElementById('eeMarkAll');

    var iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>';

    function fetchNotifs() {
        fetch('/notifications/unread', { headers:{ 'X-Requested-With':'XMLHttpRequest','Accept':'application/json' } })
        .then(function(r){ return r.ok ? r.json() : Promise.reject(); })
        .then(function(d){
            var items = d.notifications || [];
            if (notifBadge) notifBadge.style.display = items.length ? 'block' : 'none';
            if (notifBtn)   items.length ? notifBtn.classList.add('has-notif') : notifBtn.classList.remove('has-notif');
            if (notifList) notifList.innerHTML = items.length
                ? items.map(function(n){
                    return '<div class="ee-notif-item" data-id="'+n.id+'">' +
                        '<div class="ee-notif-icon '+(n.type||'info')+'">'+iconSvg+'</div>' +
                        '<div><div class="ee-notif-msg">'+(n.message||(n.data&&n.data.message)||'')+'</div>' +
                        '<div class="ee-notif-time">'+(n.time||'')+'</div></div></div>';
                }).join('')
                : '<div class="ee-notif-empty">Aucune notification</div>';
        }).catch(function(){});
    }

    if (notifBtn && notifDrop) {
        notifBtn.addEventListener('click', function(e){
            e.stopPropagation();
            closeDrawer(); closeUserMenu();
            notifDrop.classList.toggle('open');
            if (notifDrop.classList.contains('open')) fetchNotifs();
        });
        document.addEventListener('click', function(e){
            if (!notifDrop.contains(e.target) && e.target !== notifBtn)
                notifDrop.classList.remove('open');
        });
    }
    if (markAll) {
        markAll.addEventListener('click', function(){
            fetch('/notifications/mark-all-read',{
                method:'POST',
                headers:{ 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept':'application/json' }
            }).then(fetchNotifs);
        });
    }

    fetchNotifs();
    setInterval(fetchNotifs, 45000);

})();
</script>
</body>
</html>
