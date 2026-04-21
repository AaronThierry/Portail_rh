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
       PORTAIL RH+  ·  ESPACE EMPLOYÉ  ·  Sidebar Pro v2
       ═══════════════════════════════════════════════════════════════ */

    :root {
        --ind-50:  #EEEFFE; --ind-100: #D5D9FB; --ind-200: #B0B8F5;
        --ind-300: #808FE8; --ind-400: #5566D4; --ind-500: #3748C8;
        --ind-600: #2535A8; --ind-700: #1A2785; --ind-800: #111C62; --ind-900: #0A1040;

        --teal-50:  #E5FAF8; --teal-100: #B0EFE9;
        --teal-300: #2ECABB; --teal-400: #0AAFA2;
        --teal-500: #078F84; --teal-600: #056B62;

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

        /* Sidebar */
        --sb-w:  64px;
        --sb-wE: 240px;
        --hd-h:  56px;

        --font:   'DM Sans', system-ui, sans-serif;
        --font-d: 'Syne', 'DM Sans', system-ui, sans-serif;
        --font-m: 'DM Mono', monospace;
        --r-sm: 4px; --r: 8px; --r-lg: 12px; --r-xl: 16px; --r-2xl: 24px; --r-f: 9999px;

        /* Sidebar bg tokens */
        --sb-bg-1: #07092E;
        --sb-bg-2: #0C1245;
        --sb-item-hover: rgba(255,255,255,.07);
        --sb-item-active: rgba(10,175,162,.14);
        --sb-border: rgba(255,255,255,.06);
        --sb-text-muted: rgba(255,255,255,.38);
        --sb-text-dim: rgba(255,255,255,.6);
        --sb-text: rgba(255,255,255,.92);
    }

    @keyframes fadeUp   { from { opacity:0; transform:translateY(10px) } to { opacity:1; transform:translateY(0) } }
    @keyframes slideDown{ from { opacity:0; transform:translateY(-6px)  } to { opacity:1; transform:translateY(0) } }
    @keyframes pulse    { 0%,100% { opacity:1 } 50% { opacity:.5 } }

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
    .ee-layout { display: flex; min-height: 100vh; }

    /* ────────────────────────────────────────
       SIDEBAR
    ──────────────────────────────────────── */
    .ee-sidebar {
        width: var(--sb-w);
        background: linear-gradient(180deg, var(--sb-bg-1) 0%, var(--sb-bg-2) 100%);
        border-right: 1px solid var(--sb-border);
        position: fixed;
        inset: 0 auto 0 0;
        z-index: 100;
        display: flex;
        flex-direction: column;
        overflow: visible;
        transition: width .26s cubic-bezier(.4,0,.2,1);
        /* subtle inner glow */
        box-shadow: inset -1px 0 0 rgba(255,255,255,.03), 2px 0 24px rgba(7,9,46,.35);
    }

    /* Expanded state: pinned OR hovered */
    html.sb-pinned .ee-sidebar,
    html.sb-open   .ee-sidebar {
        width: var(--sb-wE);
        overflow: hidden;
    }
    html.sb-pinned .ee-main { margin-left: var(--sb-wE); }

    /* ── Brand ── */
    .ee-brand {
        height: var(--hd-h);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-bottom: 1px solid var(--sb-border);
        padding: 0;
        gap: 0;
        overflow: hidden;
        transition: padding .26s, gap .26s;
        position: relative;
    }
    html.sb-pinned .ee-brand,
    html.sb-open   .ee-brand { justify-content: flex-start; padding: 0 12px; gap: 10px; }

    .ee-brand-mark {
        width: 36px; height: 36px;
        background: linear-gradient(135deg, var(--ind-600) 0%, var(--teal-500) 100%);
        border-radius: var(--r-lg);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(7,143,132,.35);
    }
    .ee-brand-mark svg { width: 18px; height: 18px; color: #fff; stroke-width: 2; }

    .ee-brand-info {
        max-width: 0; opacity: 0; overflow: hidden; white-space: nowrap;
        transition: max-width .26s cubic-bezier(.4,0,.2,1), opacity .18s .05s;
        flex: 1; min-width: 0;
    }
    html.sb-pinned .ee-brand-info,
    html.sb-open   .ee-brand-info { max-width: 160px; opacity: 1; }

    .ee-brand-name {
        font-family: var(--font-d);
        font-size: 1.0625rem; font-weight: 700;
        color: #fff; letter-spacing: -.02em; line-height: 1.15;
    }
    .ee-brand-name em { font-style: normal; color: var(--teal-300); }
    .ee-brand-sub {
        display: block; font-size: .6rem; font-weight: 600;
        color: var(--sb-text-muted); letter-spacing: .1em; text-transform: uppercase;
        margin-top: 1px;
    }

    /* Pin toggle button */
    .ee-pin-btn {
        position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
        width: 22px; height: 22px;
        background: rgba(255,255,255,.07);
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 6px;
        display: none;
        align-items: center; justify-content: center;
        cursor: pointer;
        color: var(--sb-text-dim);
        transition: background .14s, color .14s, transform .26s;
        flex-shrink: 0;
        padding: 0;
    }
    .ee-pin-btn svg { width: 12px; height: 12px; stroke-width: 2.2; transition: transform .26s; }
    .ee-pin-btn:hover { background: rgba(255,255,255,.12); color: #fff; }
    html.sb-pinned .ee-pin-btn svg,
    html.sb-open   .ee-pin-btn svg { transform: rotate(180deg); }
    html.sb-pinned .ee-pin-btn,
    html.sb-open   .ee-pin-btn { display: flex; }

    /* ── User card ── */
    .ee-user-card {
        display: flex; align-items: center;
        justify-content: center;
        flex-shrink: 0;
        height: 56px;
        padding: 0;
        gap: 0;
        text-decoration: none;
        border-bottom: 1px solid var(--sb-border);
        overflow: hidden;
        transition: padding .26s, gap .26s, background .14s;
        position: relative;
    }
    html.sb-pinned .ee-user-card,
    html.sb-open   .ee-user-card { justify-content: flex-start; padding: 0 12px; gap: 10px; }
    .ee-user-card:hover { background: var(--sb-item-hover); }

    .ee-user-avatar-wrap {
        position: relative; flex-shrink: 0;
    }
    .ee-user-avatar {
        width: 32px; height: 32px;
        border-radius: 50%; object-fit: cover; display: block;
        border: 2px solid transparent;
        background-clip: padding-box;
        box-shadow: 0 0 0 2px rgba(10,175,162,.4);
        transition: box-shadow .2s;
    }
    .ee-user-card:hover .ee-user-avatar { box-shadow: 0 0 0 2px var(--teal-400); }
    .ee-user-online {
        position: absolute; bottom: 0; right: 0;
        width: 8px; height: 8px;
        background: var(--green-400); border: 2px solid var(--sb-bg-1);
        border-radius: 50%;
    }

    .ee-user-info {
        max-width: 0; opacity: 0; overflow: hidden; white-space: nowrap;
        transition: max-width .26s cubic-bezier(.4,0,.2,1), opacity .18s .05s;
        min-width: 0; flex: 1;
    }
    html.sb-pinned .ee-user-info,
    html.sb-open   .ee-user-info { max-width: 160px; opacity: 1; }

    .ee-user-name {
        font-size: .8125rem; font-weight: 600; color: var(--sb-text);
        line-height: 1.2; overflow: hidden; text-overflow: ellipsis;
    }
    .ee-user-role {
        font-size: .6875rem; color: var(--sb-text-muted);
        margin-top: 1px; overflow: hidden; text-overflow: ellipsis;
    }

    /* ── Navigation ── */
    .ee-nav {
        flex: 1; width: 100%;
        display: flex; flex-direction: column;
        align-items: center;
        padding: 8px 0 4px;
        overflow-y: auto; overflow-x: hidden;
        scrollbar-width: none;
        transition: align-items .1s;
    }
    .ee-nav::-webkit-scrollbar { display: none; }
    html.sb-pinned .ee-nav,
    html.sb-open   .ee-nav { align-items: stretch; padding: 8px 0 4px; }

    .ee-nav-section {
        width: 100%;
        display: flex; flex-direction: column; align-items: center;
        margin-bottom: 4px;
    }
    html.sb-pinned .ee-nav-section,
    html.sb-open   .ee-nav-section { align-items: stretch; padding: 0 8px; }

    /* Section title */
    .ee-nav-label {
        height: 20px;
        display: flex; align-items: center; justify-content: center;
        margin: 4px 0 2px;
        overflow: hidden;
    }
    html.sb-pinned .ee-nav-label,
    html.sb-open   .ee-nav-label { justify-content: flex-start; margin: 6px 4px 2px; }

    .ee-nav-label-dot {
        width: 4px; height: 4px; border-radius: 50%;
        background: rgba(255,255,255,.12); flex-shrink: 0;
        transition: opacity .2s;
    }
    .ee-nav-label-text {
        max-width: 0; opacity: 0; overflow: hidden; white-space: nowrap;
        font-size: .6rem; font-weight: 700; letter-spacing: .14em; text-transform: uppercase;
        color: var(--sb-text-muted);
        transition: max-width .26s cubic-bezier(.4,0,.2,1), opacity .18s .06s;
    }
    html.sb-pinned .ee-nav-label-dot,
    html.sb-open   .ee-nav-label-dot { opacity: 0; }
    html.sb-pinned .ee-nav-label-text,
    html.sb-open   .ee-nav-label-text { max-width: 180px; opacity: 1; }

    /* Nav link */
    .ee-nav-link {
        position: relative;
        width: 40px; height: 40px;
        border-radius: var(--r-lg);
        display: flex; align-items: center; justify-content: center;
        gap: 0;
        color: var(--sb-text-dim);
        text-decoration: none;
        transition:
            background .14s, color .14s, box-shadow .14s,
            width .26s cubic-bezier(.4,0,.2,1),
            height .26s, border-radius .26s, padding .26s, gap .26s;
        margin-bottom: 2px;
        flex-shrink: 0;
        overflow: hidden;
    }
    .ee-nav-link svg {
        width: 18px; height: 18px; stroke-width: 1.8; flex-shrink: 0;
        transition: color .14s;
    }
    .ee-nav-link:hover {
        background: var(--sb-item-hover);
        color: var(--sb-text);
    }
    .ee-nav-link.active {
        background: var(--sb-item-active);
        color: var(--teal-300);
        box-shadow: inset 3px 0 0 var(--teal-400);
    }
    .ee-nav-link.active svg { filter: drop-shadow(0 0 6px rgba(10,175,162,.4)); }

    /* Label in nav link */
    .ee-nav-link-label {
        max-width: 0; opacity: 0; overflow: hidden; white-space: nowrap;
        font-size: .875rem; font-weight: 500; color: inherit;
        transition: max-width .26s cubic-bezier(.4,0,.2,1), opacity .18s .06s;
        flex-shrink: 0; flex: 1;
    }
    html.sb-pinned .ee-nav-link,
    html.sb-open   .ee-nav-link {
        width: 100%; height: 36px; border-radius: var(--r);
        justify-content: flex-start; padding: 0 10px; gap: 10px;
    }
    html.sb-pinned .ee-nav-link-label,
    html.sb-open   .ee-nav-link-label { max-width: 180px; opacity: 1; }

    /* Badge on nav link */
    .ee-nav-badge {
        margin-left: auto; flex-shrink: 0;
        min-width: 18px; height: 18px;
        background: var(--rose-400);
        color: #fff; font-size: .6rem; font-weight: 700;
        border-radius: var(--r-f);
        display: none; align-items: center; justify-content: center;
        padding: 0 4px;
    }
    html.sb-pinned .ee-nav-badge[data-count]:not([data-count="0"]),
    html.sb-open   .ee-nav-badge[data-count]:not([data-count="0"]) { display: flex; }

    /* Tooltip (collapsed only) */
    .ee-nav-link[data-tip]::after {
        content: attr(data-tip);
        position: absolute; left: calc(100% + 10px); top: 50%;
        transform: translateY(-50%) translateX(-4px);
        background: var(--ind-800); color: rgba(255,255,255,.92);
        font-family: var(--font); font-size: .72rem; font-weight: 500;
        white-space: nowrap; padding: 5px 11px;
        border-radius: var(--r); border: 1px solid rgba(255,255,255,.08);
        box-shadow: var(--shadow-lg);
        pointer-events: none; opacity: 0;
        transition: opacity .15s, transform .15s; z-index: 999;
    }
    .ee-nav-link[data-tip]:hover::after { opacity: 1; transform: translateY(-50%) translateX(0); }
    html.sb-pinned .ee-nav-link[data-tip]::after,
    html.sb-open   .ee-nav-link[data-tip]::after { display: none; }

    /* ── Sidebar Divider ── */
    .ee-sidebar-divider {
        width: 32px; height: 1px;
        background: var(--sb-border);
        margin: 4px auto;
        flex-shrink: 0;
        transition: width .26s;
    }
    html.sb-pinned .ee-sidebar-divider,
    html.sb-open   .ee-sidebar-divider { width: calc(100% - 16px); margin: 4px 8px; }

    /* ── Footer ── */
    .ee-sidebar-footer {
        width: 100%; flex-shrink: 0;
        border-top: 1px solid var(--sb-border);
        padding: 6px 0 12px;
        display: flex; flex-direction: column; align-items: center; gap: 1px;
    }
    html.sb-pinned .ee-sidebar-footer,
    html.sb-open   .ee-sidebar-footer { align-items: stretch; padding: 6px 8px 12px; }

    .ee-footer-btn {
        position: relative;
        width: 40px; height: 38px;
        border-radius: var(--r-lg);
        display: flex; align-items: center; justify-content: center;
        gap: 0;
        color: var(--sb-text-muted);
        background: transparent; border: none; cursor: pointer;
        text-decoration: none; overflow: hidden; flex-shrink: 0;
        transition:
            background .14s, color .14s,
            width .26s cubic-bezier(.4,0,.2,1), height .26s,
            border-radius .26s, padding .26s, gap .26s;
    }
    .ee-footer-btn svg { width: 17px; height: 17px; stroke-width: 1.8; flex-shrink: 0; }
    .ee-footer-btn:hover { background: var(--sb-item-hover); color: var(--sb-text); }
    .ee-footer-btn.danger:hover { background: rgba(251,113,133,.12); color: var(--rose-400); }
    .ee-footer-btn.accent { color: rgba(10,175,162,.7); }
    .ee-footer-btn.accent:hover { background: rgba(10,175,162,.1); color: var(--teal-300); }

    .ee-footer-btn-label {
        max-width: 0; opacity: 0; overflow: hidden; white-space: nowrap;
        font-size: .875rem; font-weight: 500; color: inherit;
        transition: max-width .26s cubic-bezier(.4,0,.2,1), opacity .18s .06s;
        flex-shrink: 0; flex: 1;
    }
    html.sb-pinned .ee-footer-btn,
    html.sb-open   .ee-footer-btn {
        width: 100%; height: 36px; border-radius: var(--r);
        justify-content: flex-start; padding: 0 10px; gap: 10px;
    }
    html.sb-pinned .ee-footer-btn-label,
    html.sb-open   .ee-footer-btn-label { max-width: 180px; opacity: 1; }

    /* Footer tooltips */
    .ee-footer-btn[data-tip]::after {
        content: attr(data-tip);
        position: absolute; left: calc(100% + 10px); top: 50%;
        transform: translateY(-50%) translateX(-4px);
        background: var(--ind-800); color: rgba(255,255,255,.92);
        font-family: var(--font); font-size: .72rem; font-weight: 500;
        white-space: nowrap; padding: 5px 11px;
        border-radius: var(--r); border: 1px solid rgba(255,255,255,.08);
        box-shadow: var(--shadow-lg);
        pointer-events: none; opacity: 0;
        transition: opacity .15s, transform .15s; z-index: 999;
    }
    .ee-footer-btn[data-tip]:hover::after { opacity: 1; transform: translateY(-50%) translateX(0); }
    html.sb-pinned .ee-footer-btn[data-tip]::after,
    html.sb-open   .ee-footer-btn[data-tip]::after { display: none; }

    /* Form inside footer */
    .ee-footer-form { width: 100%; display: flex; }
    .ee-footer-form .ee-footer-btn { width: 40px; }
    html.sb-pinned .ee-footer-form .ee-footer-btn,
    html.sb-open   .ee-footer-form .ee-footer-btn { width: 100%; }

    /* ────────────────────────────────────────
       MAIN
    ──────────────────────────────────────── */
    .ee-main {
        flex: 1;
        margin-left: var(--sb-w);
        min-height: 100vh;
        display: flex; flex-direction: column;
        transition: margin-left .26s cubic-bezier(.4,0,.2,1);
    }

    /* ────────────────────────────────────────
       HEADER
    ──────────────────────────────────────── */
    .ee-header {
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        padding: 0 1.5rem;
        height: var(--hd-h);
        display: flex; align-items: center; justify-content: space-between;
        position: sticky; top: 0; z-index: 50;
        box-shadow: var(--shadow-sm);
        flex-shrink: 0;
    }

    .ee-header-left  { display: flex; align-items: center; gap: .75rem; }
    .ee-header-right { display: flex; align-items: center; gap: .375rem; }

    /* Desktop sidebar toggle (hamburger in header) */
    .ee-sb-toggle {
        width: 34px; height: 34px;
        border: 1.5px solid var(--border); border-radius: var(--r);
        background: var(--surface); color: var(--text-2); cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: all .15s;
    }
    .ee-sb-toggle:hover { background: var(--ind-50); border-color: var(--ind-300); color: var(--ind-600); }
    .ee-sb-toggle svg { width: 17px; height: 17px; stroke-width: 1.8; }
    @media (max-width: 1024px) { .ee-sb-toggle { display: none; } }

    .ee-mobile-toggle {
        display: none;
        width: 34px; height: 34px;
        border: 1.5px solid var(--border); border-radius: var(--r);
        background: var(--surface); color: var(--text-2); cursor: pointer;
        align-items: center; justify-content: center; transition: all .15s;
    }
    .ee-mobile-toggle:hover { background: var(--ind-50); border-color: var(--ind-300); color: var(--ind-600); }
    .ee-mobile-toggle svg { width: 17px; height: 17px; }
    @media (max-width: 1024px) { .ee-mobile-toggle { display: flex; } }

    .ee-page-info { display: flex; flex-direction: column; gap: 1px; }
    .ee-page-title {
        font-family: var(--font-d);
        font-size: 1rem; font-weight: 700;
        color: var(--ind-800); letter-spacing: -.01em; line-height: 1.2;
    }
    .ee-breadcrumb {
        display: flex; align-items: center; gap: .375rem;
        font-size: .72rem; color: var(--text-3);
    }
    .ee-breadcrumb a { color: var(--ind-600); text-decoration: none; font-weight: 500; }
    .ee-breadcrumb a:hover { text-decoration: underline; }
    .ee-breadcrumb svg { width: 9px; height: 9px; opacity: .4; }

    .ee-header-btn {
        position: relative;
        width: 34px; height: 34px;
        border: 1.5px solid var(--border); border-radius: var(--r);
        background: var(--surface); color: var(--text-2); cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: all .15s;
    }
    .ee-header-btn:hover { background: var(--ind-50); border-color: var(--ind-300); color: var(--ind-600); }
    .ee-header-btn svg { width: 16px; height: 16px; stroke-width: 1.8; }

    .ee-header-btn .hb-badge {
        position: absolute; top: -5px; right: -5px;
        min-width: 15px; height: 15px;
        background: var(--rose-400); color: #fff;
        font-size: .5rem; font-weight: 700; border-radius: var(--r-f);
        display: flex; align-items: center; justify-content: center;
        padding: 0 3px; border: 2px solid var(--surface);
    }
    .ee-notif-dot::after {
        content: ''; position: absolute; top: 6px; right: 6px;
        width: 7px; height: 7px; background: var(--rose-400);
        border-radius: 50%; border: 1.5px solid var(--surface);
    }

    .ee-hd-avatar {
        position: relative; display: flex; align-items: center;
        text-decoration: none; margin-left: .25rem;
    }
    .ee-hd-avatar img {
        width: 30px; height: 30px; border-radius: 50%; object-fit: cover;
        border: 2px solid var(--border); transition: border-color .15s; display: block;
    }
    .ee-hd-avatar:hover img { border-color: var(--ind-400); }
    .ee-hd-avatar-dot {
        position: absolute; bottom: -1px; right: -1px;
        width: 8px; height: 8px;
        background: var(--green-400); border: 2px solid var(--surface); border-radius: 50%;
    }

    /* ────────────────────────────────────────
       NOTIFICATION DROPDOWN
    ──────────────────────────────────────── */
    .ee-notif-wrap { position: relative; }
    .ee-notif-drop {
        display: none; position: absolute; top: calc(100% + 8px); right: 0;
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
    .ee-notif-mark-all { font-size: .72rem; font-weight: 600; color: var(--ind-600); background: none; border: none; cursor: pointer; padding: 0; font-family: var(--font); }
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
    .ee-notif-icon.info    { background: var(--ind-50);    color: var(--ind-600); }
    .ee-notif-icon.warning { background: var(--amber-100); color: var(--amber-800); }
    .ee-notif-icon.danger  { background: var(--rose-100);  color: var(--rose-800); }
    .ee-notif-msg { font-size: .8125rem; font-weight: 500; color: var(--text); margin-bottom: .2rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .ee-notif-time { font-size: .6875rem; color: var(--text-3); font-family: var(--font-m); }
    .ee-notif-empty { padding: 2rem; text-align: center; font-size: .8125rem; color: var(--text-2); }

    /* ────────────────────────────────────────
       CONTENT & FOOTER
    ──────────────────────────────────────── */
    .ee-content { flex: 1; padding: 1.5rem; }
    .ee-footer {
        padding: .875rem 1.5rem;
        background: var(--surface); border-top: 1px solid var(--border);
        text-align: center;
    }
    .ee-footer p { font-size: .72rem; color: var(--text-3); }
    .ee-footer a { color: var(--ind-600); text-decoration: none; font-weight: 600; }
    .ee-footer a:hover { color: var(--ind-700); }

    /* ────────────────────────────────────────
       MOBILE OVERLAY
    ──────────────────────────────────────── */
    .ee-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(7,9,46,.45); backdrop-filter: blur(4px);
        z-index: 90; opacity: 0; transition: opacity .28s;
    }
    .ee-overlay.active { display: block; opacity: 1; }

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
    @media (max-width: 1024px) {
        .ee-sidebar {
            transform: translateX(-100%);
            box-shadow: none;
            transition: transform .28s cubic-bezier(.4,0,.2,1), width .26s cubic-bezier(.4,0,.2,1);
        }
        .ee-sidebar.mob-open {
            transform: translateX(0);
            width: var(--sb-wE) !important;
            overflow: hidden;
            box-shadow: 4px 0 40px rgba(7,9,46,.3);
        }
        .ee-sidebar.mob-open .ee-brand-info,
        .ee-sidebar.mob-open .ee-user-info,
        .ee-sidebar.mob-open .ee-nav-link-label,
        .ee-sidebar.mob-open .ee-footer-btn-label,
        .ee-sidebar.mob-open .ee-nav-label-text { max-width: 180px; opacity: 1; }
        .ee-sidebar.mob-open .ee-brand,
        .ee-sidebar.mob-open .ee-user-card { justify-content: flex-start; padding: 0 12px; gap: 10px; }
        .ee-sidebar.mob-open .ee-nav { align-items: stretch; }
        .ee-sidebar.mob-open .ee-nav-section,
        .ee-sidebar.mob-open .ee-sidebar-footer { align-items: stretch; padding: 0 8px; }
        .ee-sidebar.mob-open .ee-sidebar-footer { padding: 6px 8px 12px; }
        .ee-sidebar.mob-open .ee-nav-link,
        .ee-sidebar.mob-open .ee-footer-btn { width: 100%; height: 36px; border-radius: var(--r); justify-content: flex-start; padding: 0 10px; gap: 10px; }
        .ee-sidebar.mob-open .ee-footer-form .ee-footer-btn { width: 100%; }
        .ee-sidebar.mob-open .ee-nav-label { justify-content: flex-start; margin: 6px 4px 2px; }
        .ee-sidebar.mob-open .ee-nav-label-dot { opacity: 0; }
        .ee-sidebar.mob-open .ee-sidebar-divider { width: calc(100% - 16px); margin: 4px 8px; }
        .ee-sidebar.mob-open .ee-pin-btn { display: none; }
        html.sb-pinned .ee-main { margin-left: var(--sb-w); }
        .ee-main { margin-left: 0 !important; }
        .ee-content { padding: 1rem; }
    }
    @media (max-width: 640px) {
        .ee-header { padding: 0 1rem; }
        .ee-content { padding: .875rem; }
        .ee-page-title { font-size: .9375rem; }
        .ee-breadcrumb { display: none; }
    }
    </style>
    @yield('styles')
</head>
<body>
<div class="ee-layout">

    <!-- Mobile overlay -->
    <div class="ee-overlay" id="eeOverlay" onclick="mobClose()"></div>

    <!-- ════════════════ SIDEBAR ════════════════ -->
    <aside class="ee-sidebar" id="eeSidebar">

        <!-- Brand -->
        <div class="ee-brand">
            <div class="ee-brand-mark">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div class="ee-brand-info">
                <div class="ee-brand-name">Portail <em>RH+</em></div>
                <span class="ee-brand-sub">Espace Employé</span>
            </div>
            <!-- Pin toggle -->
            <button class="ee-pin-btn" id="eePinBtn" title="Épingler la barre latérale">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
            </button>
        </div>

        <!-- User card -->
        @php
            $sbUser  = auth()->user();
            $sbPerso = $sbUser->personnel ?? null;
            $sbAvatarUrl = ($sbPerso && $sbPerso->photo)
                ? asset('storage/' . $sbPerso->photo)
                : 'https://ui-avatars.com/api/?name=' . urlencode($sbUser->name) . '&size=200&background=2535A8&color=ffffff&bold=true';
        @endphp
        <a href="{{ route('espace-employe.profil') }}" class="ee-user-card">
            <div class="ee-user-avatar-wrap">
                <img src="{{ $sbAvatarUrl }}" alt="{{ $sbUser->name }}" class="ee-user-avatar"
                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($sbUser->name) }}&size=200&background=2535A8&color=ffffff&bold=true'">
                <span class="ee-user-online"></span>
            </div>
            <div class="ee-user-info">
                <div class="ee-user-name">{{ $sbPerso ? $sbPerso->nom . ' ' . ($sbPerso->prenoms ?? '') : $sbUser->name }}</div>
                <div class="ee-user-role">{{ $sbPerso->poste ?? 'Employé' }}</div>
            </div>
        </a>

        <!-- Navigation -->
        <nav class="ee-nav" id="eeNav">

            <!-- Mon Espace -->
            <div class="ee-nav-section">
                <div class="ee-nav-label">
                    <span class="ee-nav-label-dot"></span>
                    <span class="ee-nav-label-text">Mon Espace</span>
                </div>
                <a href="{{ route('espace-employe.dashboard') }}"
                   class="ee-nav-link {{ request()->routeIs('espace-employe.dashboard') ? 'active' : '' }}"
                   data-tip="Tableau de bord">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/>
                    </svg>
                    <span class="ee-nav-link-label">Tableau de bord</span>
                </a>
                <a href="{{ route('espace-employe.profil') }}"
                   class="ee-nav-link {{ request()->routeIs('espace-employe.profil') ? 'active' : '' }}"
                   data-tip="Mon profil">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                    </svg>
                    <span class="ee-nav-link-label">Mon profil</span>
                </a>
            </div>

            <div class="ee-sidebar-divider"></div>

            <!-- Documents -->
            <div class="ee-nav-section">
                <div class="ee-nav-label">
                    <span class="ee-nav-label-dot"></span>
                    <span class="ee-nav-label-text">Documents</span>
                </div>
                <a href="{{ route('espace-employe.documents') }}"
                   class="ee-nav-link {{ request()->routeIs('espace-employe.documents') ? 'active' : '' }}"
                   data-tip="Mes documents">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                    <span class="ee-nav-link-label">Mes documents</span>
                </a>
                <a href="{{ route('espace-employe.bulletins') }}"
                   class="ee-nav-link {{ request()->routeIs('espace-employe.bulletins') ? 'active' : '' }}"
                   data-tip="Bulletins de paie">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="3" width="20" height="14" rx="2"/>
                        <line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>
                    </svg>
                    <span class="ee-nav-link-label">Bulletins de paie</span>
                </a>
                <a href="{{ route('espace-employe.attestations') }}"
                   class="ee-nav-link {{ request()->routeIs('espace-employe.attestations') ? 'active' : '' }}"
                   data-tip="Attestations">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/>
                    </svg>
                    <span class="ee-nav-link-label">Attestations</span>
                </a>
            </div>

            <div class="ee-sidebar-divider"></div>

            <!-- Demandes -->
            <div class="ee-nav-section">
                <div class="ee-nav-label">
                    <span class="ee-nav-label-dot"></span>
                    <span class="ee-nav-label-text">Demandes</span>
                </div>
                <a href="{{ route('espace-employe.conges') }}"
                   class="ee-nav-link {{ request()->routeIs('espace-employe.conges') ? 'active' : '' }}"
                   data-tip="Mes congés">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/><path d="M9 16l2 2 4-4"/>
                    </svg>
                    <span class="ee-nav-link-label">Mes congés</span>
                </a>
                <a href="{{ route('espace-employe.absences') }}"
                   class="ee-nav-link {{ request()->routeIs('espace-employe.absences') ? 'active' : '' }}"
                   data-tip="Mes absences">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                    </svg>
                    <span class="ee-nav-link-label">Mes absences</span>
                </a>
                <a href="{{ route('espace-employe.demandes') }}"
                   class="ee-nav-link {{ request()->routeIs('espace-employe.demandes') ? 'active' : '' }}"
                   data-tip="Mes demandes">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                        <rect x="8" y="2" width="8" height="4" rx="1"/><path d="M9 14l2 2 4-4"/>
                    </svg>
                    <span class="ee-nav-link-label">Mes demandes</span>
                </a>
            </div>

            <div class="ee-sidebar-divider"></div>

            <!-- Compte -->
            <div class="ee-nav-section">
                <div class="ee-nav-label">
                    <span class="ee-nav-label-dot"></span>
                    <span class="ee-nav-label-text">Compte</span>
                </div>
                <a href="{{ route('espace-employe.assistance') }}"
                   class="ee-nav-link {{ request()->routeIs('espace-employe.assistance*') ? 'active' : '' }}"
                   data-tip="Assistance">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                        <line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                    <span class="ee-nav-link-label">Assistance</span>
                </a>
                <a href="{{ route('espace-employe.parametres') }}"
                   class="ee-nav-link {{ request()->routeIs('espace-employe.parametres') ? 'active' : '' }}"
                   data-tip="Paramètres">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                    </svg>
                    <span class="ee-nav-link-label">Paramètres</span>
                </a>
            </div>

        </nav>

        <!-- Footer -->
        <div class="ee-sidebar-footer">
            @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'RH']))
            <a href="{{ route('admin.dashboard') }}" class="ee-footer-btn accent" data-tip="Portail Admin">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                    <path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/>
                </svg>
                <span class="ee-footer-btn-label">Portail Admin</span>
            </a>
            @endif
            <form method="POST" action="{{ route('logout') }}" class="ee-footer-form">
                @csrf
                <button type="submit" class="ee-footer-btn danger" data-tip="Déconnexion">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    <span class="ee-footer-btn-label">Déconnexion</span>
                </button>
            </form>
        </div>

    </aside>

    <!-- ════════════════ MAIN ════════════════ -->
    <main class="ee-main">

        <header class="ee-header">
            <div class="ee-header-left">
                <!-- Desktop toggle -->
                <button class="ee-sb-toggle" id="eeSbToggle" title="Épingler la barre latérale">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <line x1="3" y1="12" x2="21" y2="12"/>
                        <line x1="3" y1="6"  x2="21" y2="6"/>
                        <line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                </button>
                <!-- Mobile toggle -->
                <button class="ee-mobile-toggle" onclick="mobOpen()" aria-label="Menu">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <line x1="3" y1="12" x2="21" y2="12"/>
                        <line x1="3" y1="6"  x2="21" y2="6"/>
                        <line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                </button>
                <div class="ee-page-info">
                    <h1 class="ee-page-title">@yield('page-title', 'Mon Espace')</h1>
                    @hasSection('breadcrumb')
                        <nav class="ee-breadcrumb">@yield('breadcrumb')</nav>
                    @endif
                </div>
            </div>

            <div class="ee-header-right">
                <!-- Notifications -->
                <div class="ee-notif-wrap">
                    <button class="ee-header-btn" id="eeNotifBtn" title="Notifications">
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
                <a href="{{ route('espace-employe.profil') }}" class="ee-hd-avatar">
                    <img
                        src="{{ $hp && $hp->photo ? asset('storage/'.$hp->photo) : 'https://ui-avatars.com/api/?name='.urlencode($ha->name).'&size=200&background=2535A8&color=ffffff&bold=true' }}"
                        alt="{{ $ha->name }}"
                        onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($ha->name) }}&size=200&background=2535A8&color=ffffff&bold=true'">
                    <span class="ee-hd-avatar-dot"></span>
                </a>
            </div>
        </header>

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

    var html = document.documentElement;
    var sb   = document.getElementById('eeSidebar');
    var PINNED_KEY = 'ee_sb_pinned';

    /* ── Restore pin state ── */
    if (localStorage.getItem(PINNED_KEY) === '1') {
        html.classList.add('sb-pinned');
    }

    /* ── Desktop hover (only when not pinned) ── */
    if (sb) {
        sb.addEventListener('mouseenter', function () {
            if (!html.classList.contains('sb-pinned')) html.classList.add('sb-open');
        });
        sb.addEventListener('mouseleave', function () {
            html.classList.remove('sb-open');
        });
    }

    /* ── Pin toggle (sidebar chevron button) ── */
    function togglePin() {
        var pinned = html.classList.toggle('sb-pinned');
        html.classList.remove('sb-open');
        localStorage.setItem(PINNED_KEY, pinned ? '1' : '0');
    }

    var pinBtn    = document.getElementById('eePinBtn');
    var sbToggle  = document.getElementById('eeSbToggle');
    if (pinBtn)   pinBtn.addEventListener('click', function(e) { e.stopPropagation(); togglePin(); });
    if (sbToggle) sbToggle.addEventListener('click', togglePin);

    /* ── Mobile sidebar ── */
    window.mobOpen = function () {
        if (sb) sb.classList.add('mob-open');
        var ov = document.getElementById('eeOverlay');
        if (ov) { ov.style.display = 'block'; requestAnimationFrame(function(){ ov.classList.add('active'); }); }
    };
    window.mobClose = function () {
        if (sb) sb.classList.remove('mob-open');
        var ov = document.getElementById('eeOverlay');
        if (ov) { ov.classList.remove('active'); setTimeout(function(){ ov.style.display='none'; }, 300); }
    };

    /* ── Notifications ── */
    var notifBtn  = document.getElementById('eeNotifBtn');
    var notifDrop = document.getElementById('eeNotifDrop');
    var notifBadge= document.getElementById('eeNotifBadge');
    var notifList = document.getElementById('eeNotifList');
    var markAll   = document.getElementById('eeMarkAll');

    var iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>';

    function fetchNotifs() {
        fetch('/notifications/unread', { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
            .then(function(r) { return r.ok ? r.json() : Promise.reject(); })
            .then(function(d) {
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
                    ? items.map(function(n) {
                        return '<div class="ee-notif-item" data-id="'+n.id+'">' +
                            '<div class="ee-notif-icon '+(n.type||'info')+'">'+iconSvg+'</div>' +
                            '<div><div class="ee-notif-msg">'+(n.message||(n.data&&n.data.message)||'')+'</div>' +
                            '<div class="ee-notif-time">'+(n.time||'')+'</div></div></div>';
                    }).join('')
                    : '<div class="ee-notif-empty">Aucune notification</div>';
            })
            .catch(function(){});
    }

    if (notifBtn && notifDrop) {
        notifBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            notifDrop.classList.toggle('open');
            if (notifDrop.classList.contains('open')) fetchNotifs();
        });
        document.addEventListener('click', function(e) {
            if (!notifDrop.contains(e.target) && e.target !== notifBtn)
                notifDrop.classList.remove('open');
        });
    }
    if (markAll) {
        markAll.addEventListener('click', function() {
            fetch('/notifications/mark-all-read', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }
            }).then(fetchNotifs);
        });
    }

    fetchNotifs();
    setInterval(fetchNotifs, 45000);

})();
</script>
</body>
</html>
