<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mon espace') — Portail RH+</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/apple-touch-icon-180x180.png') }}">
    <link rel="manifest" href="{{ asset('build/manifest.webmanifest') }}">
    <meta name="theme-color" content="#ffffff">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/images/pwa-192x192.png') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Portail RH+">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
    /* ═══════════════════════════════════════════════════════════════════
       Portail RH+ — Espace employé (charte « Direction B »)
       Bleu = action · Orange = touche de marque · Statuts : ambre / vert / rouge
       Toutes les classes partagées commencent par « rh- ».
       ═══════════════════════════════════════════════════════════════════ */
    :root {
        --brand: #2563eb; --brand-dk: #1d4ed8; --brand-soft: #dbeafe; --brand-bg: #eff6ff;
        --orange: #ea580c; --orange-bg: #fff7ed; --orange-tx: #9a3412;
        --ink: #0f172a; --ink-2: #334155; --muted: #475569; --faint: #94a3b8;
        --line: #cbd5e1; --line-soft: #e2e8f0; --page: #f8fafc; --subtle: #f1f5f9;
        --wait: #b45309; --wait-bg: #fef3c7;
        --ok: #047857; --ok-bg: #d1fae5;
        --no: #b91c1c; --no-bg: #fee2e2;
        --off: #475569; --off-bg: #f1f5f9;
        --info: #1d4ed8; --info-bg: #dbeafe;
        --radius: 16px; --radius-lg: 24px;
        --top-h: 64px; --bottom-h: 68px;
        --font: 'DM Sans', system-ui, -apple-system, sans-serif;
        --display: 'Syne', 'DM Sans', sans-serif;
    }
    html { overscroll-behavior-y: none; -webkit-text-size-adjust: 100%; color-scheme: light; background: var(--page, #f8fafc); }
    body {
        margin: 0; background: var(--page); color: var(--ink);
        font-family: var(--font); font-size: 15px; line-height: 1.5;
        -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: transparent;
    }
    a { color: var(--brand); }
    :focus-visible { outline: 2px solid var(--brand); outline-offset: 2px; }
    [hidden] { display: none !important; }
    .rh-sr { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0 0 0 0); white-space: nowrap; }

    /* ── Barre du haut ───────────────────────────────────────────── */
    .rh-top {
        position: sticky; top: 0; z-index: 40;
        background: rgba(255,255,255,.94); backdrop-filter: saturate(1.4) blur(10px);
        border-bottom: 1px solid var(--line-soft);
        padding-top: env(safe-area-inset-top);
    }
    .rh-top-in {
        max-width: 1120px; margin: 0 auto; height: var(--top-h);
        padding: 0 16px; display: flex; align-items: center; gap: 24px;
    }
    .rh-logo { font-family: var(--display); font-weight: 800; font-size: 20px; letter-spacing: -0.03em; color: var(--ink); text-decoration: none; white-space: nowrap; }
    .rh-logo b { color: var(--orange); font-weight: 800; }
    .rh-topnav { display: none; gap: 4px; flex-grow: 1; }
    .rh-topnav a {
        height: 40px; padding: 0 16px; border-radius: 999px; display: flex; align-items: center;
        color: var(--ink-2); font-size: 15px; font-weight: 600; text-decoration: none;
    }
    .rh-topnav a:hover { background: var(--subtle); }
    .rh-topnav a[aria-current="page"] { background: var(--brand-soft); color: #1e3a8a; font-weight: 700; }
    .rh-top-right { display: flex; align-items: center; gap: 6px; margin-left: auto; }
    .rh-iconbtn {
        position: relative; width: 44px; height: 44px; border: 0; border-radius: 999px;
        background: transparent; color: var(--ink); display: flex; align-items: center; justify-content: center; cursor: pointer;
    }
    .rh-iconbtn:hover { background: var(--subtle); }
    .rh-iconbtn svg { width: 22px; height: 22px; }
    .rh-dot { position: absolute; top: 9px; right: 9px; min-width: 9px; height: 9px; border-radius: 999px; background: var(--orange); border: 2px solid #fff; display: none; }
    .rh-dot.on { display: block; }
    .rh-userbtn {
        height: 44px; padding: 0 4px; border: 0; border-radius: 999px; background: transparent;
        display: flex; align-items: center; gap: 8px; cursor: pointer; font: 600 14px var(--font); color: var(--ink);
    }
    .rh-userbtn:hover { background: var(--subtle); }
    .rh-userbtn .rh-username { display: none; }
    .rh-avatar {
        width: 36px; height: 36px; border-radius: 999px; object-fit: cover; flex-shrink: 0;
        background: var(--ink); color: #fff; display: inline-flex; align-items: center; justify-content: center;
        font-size: 13px; font-weight: 700;
    }

    /* Menus déroulants */
    .rh-pop { position: relative; }
    .rh-menu {
        position: absolute; right: 0; top: calc(100% + 8px); z-index: 50;
        width: min(320px, calc(100vw - 32px)); background: #fff; border-radius: var(--radius);
        box-shadow: 0 16px 48px rgba(15,23,42,.16), 0 0 0 1px var(--line-soft);
        padding: 8px; display: none;
    }
    .rh-menu.open { display: block; }
    .rh-menu-head { padding: 10px 12px 12px; border-bottom: 1px solid var(--line-soft); margin-bottom: 6px; }
    .rh-menu-head strong { display: block; font-size: 15px; }
    .rh-menu-head span { font-size: 13px; color: var(--muted); }
    .rh-menu a, .rh-menu button.rh-menu-item {
        display: flex; align-items: center; gap: 10px; width: 100%; min-height: 44px; padding: 0 12px;
        border: 0; background: none; border-radius: 12px; text-align: left; cursor: pointer;
        font: 500 15px var(--font); color: var(--ink); text-decoration: none;
    }
    .rh-menu a:hover, .rh-menu button.rh-menu-item:hover { background: var(--subtle); }
    .rh-menu svg { width: 18px; height: 18px; color: var(--muted); }
    .rh-menu hr { border: 0; border-top: 1px solid var(--line-soft); margin: 6px 0; }
    .rh-menu .rh-danger { color: var(--no); }
    .rh-menu .rh-danger svg { color: var(--no); }
    .rh-notifs { max-height: 60vh; overflow-y: auto; }
    .rh-notif { display: flex; gap: 10px; padding: 10px 12px; border-radius: 12px; text-decoration: none; color: var(--ink); }
    .rh-notif:hover { background: var(--subtle); }
    .rh-notif-dot { width: 8px; height: 8px; border-radius: 999px; background: var(--brand); margin-top: 7px; flex-shrink: 0; }
    .rh-notif p { margin: 0; font-size: 14px; line-height: 20px; }
    .rh-notif small { font-size: 12px; color: var(--muted); }
    .rh-menu-empty { padding: 20px 12px; text-align: center; color: var(--muted); font-size: 14px; }
    .rh-menu-title { display: flex; justify-content: space-between; align-items: center; padding: 6px 12px 10px; }
    .rh-menu-title strong { font-size: 15px; }

    /* ── Barre du bas (mobile) ───────────────────────────────────── */
    .rh-bottom {
        position: fixed; left: 0; right: 0; bottom: 0; z-index: 40;
        background: #fff; border-top: 1px solid var(--line-soft);
        padding-bottom: env(safe-area-inset-bottom);
        display: grid; grid-template-columns: repeat(4, minmax(0, 1fr));
    }
    .rh-bottom a {
        height: var(--bottom-h); display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 4px;
        color: #475569; font-size: 12px; font-weight: 600; text-decoration: none;
    }
    .rh-bottom .rh-bi { width: 56px; height: 30px; border-radius: 999px; display: flex; align-items: center; justify-content: center; }
    .rh-bottom svg { width: 21px; height: 21px; }
    .rh-bottom a[aria-current="page"] { color: var(--ink); font-weight: 700; }
    .rh-bottom a[aria-current="page"] .rh-bi { background: var(--brand-soft); color: var(--brand-dk); }

    /* ── Contenu ─────────────────────────────────────────────────── */
    .rh-main { max-width: 1120px; margin: 0 auto; padding: 24px 16px calc(var(--bottom-h) + env(safe-area-inset-bottom) + 32px); }
    .rh-page { display: flex; flex-direction: column; gap: 28px; }

    .rh-head { display: flex; flex-wrap: wrap; align-items: flex-end; justify-content: space-between; gap: 16px; }
    .rh-head-txt { display: flex; flex-direction: column; gap: 6px; min-width: 0; }
    .rh-kicker { font-size: 15px; color: var(--muted); }
    .rh-h1 { margin: 0; font-family: var(--display); font-weight: 700; font-size: 30px; line-height: 1.15; letter-spacing: -0.02em; }
    .rh-lead { margin: 0; font-size: 15px; color: var(--muted); max-width: 60ch; }
    .rh-actions { display: flex; flex-wrap: wrap; gap: 8px; }
    .rh-head > .rh-actions { width: 100%; }
    .rh-head > .rh-actions .rh-btn { flex: 1 1 auto; }
    .rh-h2 { margin: 0; font-family: var(--display); font-weight: 700; font-size: 19px; line-height: 1.3; }
    .rh-section { display: flex; flex-direction: column; gap: 14px; }
    .rh-section-head { display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }

    /* Onglets de section (Demandes / Documents) */
    .rh-tabs { display: flex; gap: 6px; overflow-x: auto; scrollbar-width: none; margin: -4px -16px 0; padding: 4px 16px; }
    .rh-tabs::-webkit-scrollbar { display: none; }
    .rh-tabs a {
        flex-shrink: 0; height: 40px; padding: 0 16px; border-radius: 999px; display: flex; align-items: center;
        border: 1px solid var(--line); color: var(--ink); font-size: 14px; font-weight: 600; text-decoration: none; background: #fff;
    }
    .rh-tabs a[aria-current="page"] { background: var(--ink); border-color: var(--ink); color: #fff; }

    /* Cartes, listes */
    .rh-card { background: #fff; border-radius: var(--radius-lg); padding: 20px; box-shadow: 0 1px 2px rgba(15,23,42,.05), 0 0 0 1px var(--line-soft); }
    .rh-card-flat { background: #fff; border-radius: var(--radius-lg); box-shadow: 0 0 0 1px var(--line-soft); overflow: hidden; }
    .rh-list { list-style: none; margin: 0; padding: 0; }
    .rh-row { display: flex; align-items: center; gap: 12px; padding: 14px 16px; border-top: 1px solid var(--line-soft); min-height: 64px; }
    .rh-list > li:first-child > .rh-row, .rh-list > .rh-row:first-child { border-top: 0; }
    a.rh-row { color: inherit; text-decoration: none; }
    a.rh-row:hover { background: var(--page); }
    .rh-row-main { flex: 1; min-width: 0; display: flex; flex-direction: column; gap: 2px; }
    .rh-row-title { font-size: 15px; font-weight: 600; line-height: 1.35; overflow-wrap: anywhere; }
    .rh-row-sub { font-size: 13px; color: var(--muted); line-height: 1.4; }
    .rh-row-end { display: flex; align-items: center; gap: 8px; flex-shrink: 0; flex-wrap: wrap; justify-content: flex-end; }
    .rh-swatch { width: 10px; height: 10px; border-radius: 999px; flex-shrink: 0; }
    .rh-ico { width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background: var(--brand-bg); color: var(--brand); }
    .rh-ico svg { width: 20px; height: 20px; }

    /* Chiffres */
    .rh-figures { display: flex; flex-wrap: wrap; gap: 1px; background: var(--line-soft); border-radius: var(--radius-lg); overflow: hidden; box-shadow: 0 0 0 1px var(--line-soft); }
    .rh-figure { flex: 1 1 140px; background: #fff; padding: 16px 18px; display: flex; flex-direction: column; gap: 2px; }
    .rh-figure strong { font-family: var(--display); font-size: 26px; line-height: 1.1; font-weight: 700; letter-spacing: -0.02em; }
    .rh-figure span { font-size: 13px; color: var(--muted); }

    /* Badges de statut */
    .rh-badge { display: inline-flex; align-items: center; gap: 6px; height: 26px; padding: 0 10px; border-radius: 999px; font-size: 12px; font-weight: 700; white-space: nowrap; }
    .rh-badge::before { content: ''; width: 6px; height: 6px; border-radius: 999px; background: currentColor; }
    .rh-badge.wait { color: var(--wait); background: var(--wait-bg); }
    .rh-badge.ok   { color: var(--ok);   background: var(--ok-bg); }
    .rh-badge.no   { color: var(--no);   background: var(--no-bg); }
    .rh-badge.off  { color: var(--off);  background: var(--off-bg); }
    .rh-badge.info { color: var(--info); background: var(--info-bg); }
    .rh-badge.new  { color: var(--orange-tx); background: var(--orange-bg); }

    /* Boutons */
    .rh-btn {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        height: 48px; padding: 0 22px; border-radius: 999px; border: 0; cursor: pointer;
        font: 700 15px var(--font); text-decoration: none; white-space: nowrap;
        background: var(--brand); color: #fff; transition: background .15s;
    }
    .rh-btn:hover { background: var(--brand-dk); color: #fff; }
    .rh-btn svg { width: 18px; height: 18px; }
    .rh-btn.ghost { background: #fff; color: var(--ink); box-shadow: inset 0 0 0 1.5px var(--ink); }
    .rh-btn.ghost:hover { background: var(--subtle); color: var(--ink); }
    .rh-btn.soft { background: var(--subtle); color: var(--ink); }
    .rh-btn.soft:hover { background: var(--line-soft); color: var(--ink); }
    .rh-btn.danger { background: #fff; color: var(--no); box-shadow: inset 0 0 0 1.5px #fca5a5; }
    .rh-btn.danger:hover { background: var(--no-bg); }
    .rh-btn.sm { height: 36px; padding: 0 14px; font-size: 13px; }
    .rh-btn.block { width: 100%; }
    .rh-btn[disabled] { opacity: .65; cursor: progress; }
    .rh-link { background: none; border: 0; padding: 8px 0; cursor: pointer; font: 600 14px var(--font); color: var(--brand); text-decoration: none; }
    .rh-link:hover { text-decoration: underline; }

    /* Messages */
    .rh-alert { display: flex; gap: 10px; align-items: flex-start; padding: 12px 16px; border-radius: 14px; font-size: 14px; line-height: 20px; font-weight: 500; }
    .rh-alert svg { width: 18px; height: 18px; flex-shrink: 0; margin-top: 1px; }
    .rh-alert.ok   { background: var(--ok-bg);     color: #065f46; }
    .rh-alert.err  { background: var(--no-bg);     color: #991b1b; }
    .rh-alert.warn { background: var(--orange-bg); color: var(--orange-tx); }
    .rh-alert.info { background: var(--brand-bg);  color: #1e3a8a; }
    .rh-alert ul { margin: 0; padding-left: 18px; }

    .rh-empty { text-align: center; padding: 40px 20px; display: flex; flex-direction: column; align-items: center; gap: 8px; }
    .rh-empty strong { font-size: 16px; }
    .rh-empty p { margin: 0; color: var(--muted); font-size: 14px; max-width: 42ch; }

    /* Formulaires */
    .rh-form { display: flex; flex-direction: column; gap: 16px; }
    .rh-field { display: flex; flex-direction: column; gap: 6px; }
    .rh-field > label, .rh-label { font-size: 14px; font-weight: 600; }
    .rh-opt { font-weight: 400; color: var(--muted); }
    .rh-hint { font-size: 13px; color: var(--muted); }
    .rh-err { font-size: 13px; color: var(--no); font-weight: 600; margin: 0; }
    .rh-input, .rh-select, .rh-textarea {
        width: 100%; box-sizing: border-box; min-height: 52px; padding: 0 16px;
        font: 400 16px var(--font); color: var(--ink); background: #fff;
        border: 1.5px solid var(--line); border-radius: var(--radius); outline: none;
        transition: border-color .15s, box-shadow .15s;
    }
    .rh-textarea { padding: 14px 16px; min-height: 110px; resize: vertical; line-height: 1.5; }
    .rh-select { appearance: none; background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") right 14px center/18px no-repeat; padding-right: 44px; }
    .rh-input:focus, .rh-select:focus, .rh-textarea:focus { border-color: var(--brand); box-shadow: 0 0 0 4px var(--brand-soft); }
    .rh-input[type="file"] { padding: 12px 16px; }
    .rh-grid2 { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 12px; }
    .rh-pwd { position: relative; }
    .rh-pwd .rh-input { padding-right: 56px; }
    .rh-eye { position: absolute; right: 5px; top: 4px; width: 44px; height: 44px; border: 0; border-radius: 999px; background: transparent; color: var(--ink-2); display: flex; align-items: center; justify-content: center; cursor: pointer; }
    .rh-eye svg { width: 20px; height: 20px; }

    /* Fenêtres (feuille en bas sur mobile, centrée sur ordinateur) */
    .rh-sheet {
        position: fixed; inset: 0; z-index: 60; display: none;
        background: rgba(15,23,42,.45); align-items: flex-end; justify-content: center;
    }
    .rh-sheet.open { display: flex; }
    .rh-sheet-box {
        width: 100%; max-height: calc(100dvh - 40px); overflow-y: auto; background: #fff;
        border-radius: var(--radius-lg) var(--radius-lg) 0 0;
        padding: 12px 20px calc(20px + env(safe-area-inset-bottom));
        box-shadow: 0 -12px 48px rgba(15,23,42,.18);
    }
    .rh-sheet-grip { width: 40px; height: 4px; border-radius: 999px; background: var(--line-soft); margin: 0 auto 12px; }
    .rh-sheet-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; margin-bottom: 18px; }
    .rh-sheet-head h2 { margin: 0; font-family: var(--display); font-size: 21px; line-height: 1.25; font-weight: 700; }
    .rh-sheet-head p { margin: 4px 0 0; font-size: 14px; color: var(--muted); }
    .rh-sheet-foot { display: flex; gap: 8px; margin-top: 20px; }
    .rh-sheet-foot .rh-btn { flex: 1; }

    /* Frise de l'année */
    .rh-year { display: grid; grid-template-columns: repeat(12, minmax(0, 1fr)); gap: 6px; }
    .rh-year-m { display: flex; flex-direction: column; gap: 2px; }
    .rh-year-m em { font-style: normal; font-size: 11px; line-height: 16px; text-align: center; color: var(--muted); margin-bottom: 4px; font-weight: 500; }
    .rh-year-m em.now { color: var(--ink); font-weight: 700; }
    .rh-year-m em .l { display: none; }
    .rh-year-m i { display: block; height: 5px; border-radius: 2px; background: var(--line-soft); }
    .rh-year-m i.p  { background: var(--line); }
    .rh-year-m i.w  { background: var(--subtle); }
    .rh-year-m i.pw { background: var(--line-soft); }
    .rh-year-m i.f  { background: transparent; box-shadow: inset 0 0 0 1px var(--faint); }
    .rh-year-m i.c  { background: var(--brand); }
    .rh-year-m i.a  { background: #f59e0b; }
    .rh-year-m i.x  { background: #a78bfa; }
    .rh-year-m i.t  { background: var(--orange); }
    .rh-legend { display: flex; flex-wrap: wrap; gap: 6px 16px; font-size: 12px; color: var(--muted); }
    .rh-legend span { display: inline-flex; align-items: center; gap: 6px; }
    .rh-legend i { display: inline-block; width: 14px; height: 6px; border-radius: 2px; }

    /* Frise chronologique (« À venir ») */
    .rh-timeline { list-style: none; margin: 0; padding: 0; }
    .rh-timeline li { display: grid; grid-template-columns: 78px 16px minmax(0, 1fr); column-gap: 10px; }
    .rh-timeline .d { font-family: var(--display); font-weight: 700; font-size: 15px; line-height: 22px; }
    .rh-timeline .rail { display: flex; flex-direction: column; align-items: center; }
    .rh-timeline .rail::before { content: ''; width: 10px; height: 10px; margin-top: 6px; border-radius: 999px; background: var(--rail, var(--brand)); flex-shrink: 0; }
    .rh-timeline .rail::after { content: ''; flex-grow: 1; width: 1px; background: var(--line-soft); margin-top: 4px; }
    .rh-timeline li:last-child .rail::after { display: none; }
    .rh-timeline .body { padding-bottom: 18px; display: flex; flex-direction: column; gap: 2px; }

    .rh-footer { text-align: center; font-size: 12px; color: var(--faint); margin-top: 40px; }

    /* ── Ordinateur ──────────────────────────────────────────────── */
    @media (min-width: 1024px) {
        .rh-top-in { padding: 0 24px; }
        .rh-topnav { display: flex; }
        .rh-bottom { display: none; }
        .rh-userbtn { padding: 0 14px 0 4px; background: var(--subtle); }
        .rh-userbtn .rh-username { display: inline; }
        .rh-main { padding: 40px 24px 56px; }
        .rh-page { gap: 36px; }
        .rh-h1 { font-size: 40px; }
        .rh-tabs { margin: 0; padding: 0; }
        .rh-sheet { align-items: center; padding: 24px; }
        .rh-sheet-box { max-width: 560px; border-radius: var(--radius-lg); padding: 28px; }
        .rh-sheet-grip { display: none; }
        .rh-sheet-foot { justify-content: flex-end; }
        .rh-sheet-foot .rh-btn { flex: 0 0 auto; }
        .rh-year { gap: 10px; }
        .rh-year-m i { height: 7px; }
        .rh-year-m em { font-size: 13px; text-align: left; }
        .rh-year-m em .l { display: inline; }
        .rh-year-m em .s { display: none; }
        .rh-head > .rh-actions { width: auto; }
        .rh-head > .rh-actions .rh-btn { flex: 0 0 auto; }
    }
    @media (prefers-reduced-motion: reduce) { * { transition: none !important; scroll-behavior: auto !important; } }

    /* ── Bascule clair / sombre ──────────────────────────────────── */
    .rh-theme-moon { display: none; }
    html.dark .rh-theme-sun { display: none; }
    html.dark .rh-theme-moon { display: block; }

    /* ═══════════════════════════════════════════════════════════════════
       THÈME SOMBRE — mêmes composants, palette réassignée
       ═══════════════════════════════════════════════════════════════════ */
    html.dark {
        color-scheme: dark;
        --ink: #f8fafc; --ink-2: #e2e8f0; --muted: #a8b6ca; --faint: #7489a6;
        --line: #4f6085; --line-soft: #2f3e5c; --page: #060a13; --subtle: #141f33;
        --surface: #202d47;
        --brand: #3b82f6; --brand-dk: #60a5fa; --brand-soft: rgba(59,130,246,.22); --brand-bg: rgba(59,130,246,.14);
        --orange: #fb923c; --orange-bg: rgba(251,146,60,.16); --orange-tx: #fdba74;
        --wait: #fbbf24; --wait-bg: rgba(251,191,36,.16);
        --ok: #34d399; --ok-bg: rgba(52,211,153,.16);
        --no: #f87171; --no-bg: rgba(248,113,113,.16);
        --off: #94a3b8; --off-bg: rgba(148,163,184,.14);
        --info: #60a5fa; --info-bg: rgba(96,165,250,.16);
    }
    html.dark body { background: var(--page); }
    html.dark .rh-top { background: rgba(6,10,19,.9); }
    html.dark .rh-card,
    html.dark .rh-card-flat,
    html.dark .rh-figure,
    html.dark .bp-m,
    html.dark .doc-folder,
    html.dark .att-type {
        box-shadow: 0 4px 16px rgba(0,0,0,.35), 0 0 0 1px var(--line-soft);
    }
    html.dark .rh-menu,
    html.dark .rh-bottom,
    html.dark .rh-tabs a,
    html.dark .rh-card,
    html.dark .rh-card-flat,
    html.dark .rh-figure,
    html.dark .rh-btn.ghost,
    html.dark .rh-btn.danger,
    html.dark .rh-input, html.dark .rh-select, html.dark .rh-textarea,
    html.dark .rh-sheet-box {
        background: var(--surface);
    }
    html.dark .rh-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
    }
    /* Pastilles qui utilisent --ink comme fond (texte blanc) : --ink devient clair en
       sombre, donc le texte blanc ne passerait plus — on le repasse en sombre ici. */
    html.dark .rh-tabs a[aria-current="page"],
    html.dark .rh-avatar {
        color: var(--page);
    }
    html.dark .rh-dot { border-color: var(--page); }
    html.dark .rh-alert.ok   { color: #6ee7b7; }
    html.dark .rh-alert.err  { color: #fca5a5; }
    html.dark .rh-alert.info { color: #93c5fd; }
    html.dark .rh-sheet { background: rgba(0,0,0,.6); }
    </style>
    @yield('styles')
</head>
<body>
@include('partials.app-loader')
@include('partials.pin-gate')

@php
    $rhUser   = auth()->user();
    $rhPerso  = $rhUser->personnel ?? null;
    $rhPrenom = $rhPerso->prenoms ?? null;
    $rhNom    = $rhPerso ? trim(($rhPerso->prenoms ?? '') . ' ' . $rhPerso->nom) : $rhUser->name;
    $rhPhoto  = ($rhPerso && $rhPerso->photo) ? asset('storage/' . $rhPerso->photo) : null;
    $rhInit   = strtoupper(mb_substr($rhPerso->prenoms ?? $rhUser->name, 0, 1) . mb_substr($rhPerso->nom ?? '', 0, 1));
    $rhGroup  = match (true) {
        request()->routeIs('espace-employe.conges*', 'espace-employe.absences*', 'espace-employe.demandes') => 'demandes',
        request()->routeIs('espace-employe.bulletins*', 'espace-employe.documents*', 'espace-employe.attestations') => 'documents',
        request()->routeIs('espace-employe.assistance*') => 'assistance',
        request()->routeIs('espace-employe.profil', 'espace-employe.parametres') => 'profil',
        default => 'accueil',
    };
    $rhCur = fn ($g) => $rhGroup === $g ? 'aria-current=page' : '';
@endphp

<header class="rh-top">
    <div class="rh-top-in">
        <a href="{{ route('espace-employe.dashboard') }}" class="rh-logo">Portail RH<b>+</b></a>

        <nav class="rh-topnav" aria-label="Navigation principale">
            <a href="{{ route('espace-employe.dashboard') }}" {{ $rhCur('accueil') }}>Accueil</a>
            <a href="{{ route('espace-employe.conges') }}" {{ $rhCur('demandes') }}>Congés et absences</a>
            <a href="{{ route('espace-employe.bulletins') }}" {{ $rhCur('documents') }}>Documents</a>
            <a href="{{ route('espace-employe.assistance') }}" {{ $rhCur('assistance') }}>Assistance</a>
        </nav>

        <div class="rh-top-right">
            <button type="button" class="rh-iconbtn rh-theme-toggle" data-theme-toggle aria-label="Changer de thème">
                <svg class="rh-theme-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
                <svg class="rh-theme-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
            </button>
            <div class="rh-pop">
                <button type="button" class="rh-iconbtn" id="rhNotifBtn" aria-label="Notifications" aria-expanded="false" aria-controls="rhNotifMenu">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                    <span class="rh-dot" id="rhNotifDot"></span>
                </button>
                <div class="rh-menu" id="rhNotifMenu" role="region" aria-label="Notifications">
                    <div class="rh-menu-title">
                        <strong>Notifications</strong>
                        <button type="button" class="rh-link" id="rhMarkAll">Tout marquer comme lu</button>
                    </div>
                    <div class="rh-notifs" id="rhNotifList"><div class="rh-menu-empty">Aucune notification</div></div>
                </div>
            </div>

            <div class="rh-pop">
                <button type="button" class="rh-userbtn" id="rhUserBtn" aria-haspopup="true" aria-expanded="false" aria-controls="rhUserMenu" aria-label="Mon compte">
                    @if($rhPhoto)
                        <img src="{{ $rhPhoto }}" alt="" class="rh-avatar">
                    @else
                        <span class="rh-avatar" aria-hidden="true">{{ $rhInit }}</span>
                    @endif
                    <span class="rh-username">{{ $rhPrenom ?? $rhUser->name }}</span>
                </button>
                <div class="rh-menu" id="rhUserMenu">
                    <div class="rh-menu-head">
                        <strong>{{ $rhNom }}</strong>
                        <span>{{ $rhPerso->poste ?? 'Employé' }}</span>
                    </div>
                    <a href="{{ route('espace-employe.profil') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg>Mon profil
                    </a>
                    <a href="{{ route('espace-employe.parametres') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>Sécurité du compte
                    </a>
                    @if($rhUser->hasAnyRole(['Super Admin', 'Admin', 'RH']))
                        <a href="{{ route('admin.dashboard') }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>Portail admin
                        </a>
                    @endif
                    <hr>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rh-menu-item rh-danger">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5M21 12H9"/></svg>Se déconnecter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<main class="rh-main" id="contenu">
    @foreach(['success' => 'ok', 'error' => 'err', 'warning' => 'warn', 'info' => 'info'] as $rhKey => $rhCls)
        @if(session($rhKey))
            <div class="rh-alert {{ $rhCls }}" role="{{ $rhKey === 'error' ? 'alert' : 'status' }}" style="margin-bottom: 20px">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    @if($rhKey === 'success')<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>@else<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>@endif
                </svg>
                <span>{{ session($rhKey) }}</span>
            </div>
        @endif
    @endforeach

    @yield('content')

    <p class="rh-footer">© {{ date('Y') }} Portail RH+</p>
</main>

<nav class="rh-bottom" aria-label="Navigation principale">
    <a href="{{ route('espace-employe.dashboard') }}" {{ $rhCur('accueil') }}>
        <span class="rh-bi"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 10.5 12 3l9 7.5V20a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1z"/></svg></span>Accueil
    </a>
    <a href="{{ route('espace-employe.conges') }}" {{ $rhCur('demandes') }}>
        <span class="rh-bi"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="3"/><path d="M16 2v4M8 2v4M3 10h18"/></svg></span>Demandes
    </a>
    <a href="{{ route('espace-employe.bulletins') }}" {{ $rhCur('documents') }}>
        <span class="rh-bi"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg></span>Documents
    </a>
    <a href="{{ route('espace-employe.profil') }}" @if(in_array($rhGroup, ['profil', 'assistance'])) aria-current="page" @endif>
        <span class="rh-bi"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg></span>Profil
    </a>
</nav>

@yield('scripts')

<script>
(function () {
    'use strict';
    var csrf = document.querySelector('meta[name="csrf-token"]').content;

    /* ── Menus (compte, notifications) ── */
    function bindMenu(btnId, menuId, onOpen) {
        var btn = document.getElementById(btnId), menu = document.getElementById(menuId);
        if (!btn || !menu) return null;
        function close() { menu.classList.remove('open'); btn.setAttribute('aria-expanded', 'false'); }
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            var open = !menu.classList.contains('open');
            document.querySelectorAll('.rh-menu.open').forEach(function (m) { m.classList.remove('open'); });
            if (open) { menu.classList.add('open'); btn.setAttribute('aria-expanded', 'true'); if (onOpen) onOpen(); }
            else close();
        });
        document.addEventListener('click', function (e) { if (!menu.contains(e.target)) close(); });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') close(); });
        return close;
    }

    /* ── Notifications ── */
    var list = document.getElementById('rhNotifList'), dot = document.getElementById('rhNotifDot');
    function esc(s) { var d = document.createElement('div'); d.textContent = s == null ? '' : String(s); return d.innerHTML; }
    function fetchNotifs() {
        fetch('/api/notifications', { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
            .then(function (r) { return r.ok ? r.json() : Promise.reject(); })
            .then(function (d) {
                var items = d.notifications || [];
                dot.classList.toggle('on', items.length > 0);
                list.innerHTML = items.length ? items.map(function (n) {
                    var body = '<span class="rh-notif-dot"></span><span><p>' + esc(n.message) + '</p><small>' + esc(n.created_at) + '</small></span>';
                    var link = (n.link && /^(\/|https?:\/\/)/.test(n.link)) ? n.link : null;
                    return link
                        ? '<a href="' + esc(link) + '" class="rh-notif" data-id="' + esc(n.id) + '">' + body + '</a>'
                        : '<div class="rh-notif" data-id="' + esc(n.id) + '">' + body + '</div>';
                }).join('') : '<div class="rh-menu-empty">Aucune notification</div>';
            }).catch(function () {});
    }
    bindMenu('rhNotifBtn', 'rhNotifMenu', fetchNotifs);
    bindMenu('rhUserBtn', 'rhUserMenu');
    document.getElementById('rhMarkAll').addEventListener('click', function () {
        fetch('/api/notifications/read-all', { method: 'POST', headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' } }).then(fetchNotifs);
    });
    list.addEventListener('click', function (e) {
        var item = e.target.closest('.rh-notif');
        if (item && item.dataset.id) {
            fetch('/api/notifications/' + encodeURIComponent(item.dataset.id) + '/read', { method: 'POST', headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' } }).catch(function () {});
        }
    });
    fetchNotifs();
    setInterval(fetchNotifs, 60000);

    /* ── Fenêtres : <button data-open="id">, <button data-close>, <div class="rh-sheet" id="id"> ── */
    var lastTrigger = null;
    window.rhOpen = function (id, trigger) {
        var s = document.getElementById(id);
        if (!s) return;
        lastTrigger = trigger || document.activeElement;
        s.classList.add('open');
        document.body.style.overflow = 'hidden';
        var f = s.querySelector('input:not([type=hidden]):not([disabled]), select, textarea, button');
        if (f) setTimeout(function () { f.focus(); }, 30);
    };
    window.rhClose = function (s) {
        if (!s) return;
        s.classList.remove('open');
        if (!document.querySelector('.rh-sheet.open')) document.body.style.overflow = '';
        if (lastTrigger && lastTrigger.focus) lastTrigger.focus();
    };
    document.addEventListener('click', function (e) {
        var o = e.target.closest('[data-open]');
        if (o) { e.preventDefault(); rhOpen(o.getAttribute('data-open'), o); return; }
        var c = e.target.closest('[data-close]');
        if (c) { e.preventDefault(); rhClose(c.closest('.rh-sheet')); return; }
        if (e.target.classList && e.target.classList.contains('rh-sheet')) rhClose(e.target);
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') document.querySelectorAll('.rh-sheet.open').forEach(rhClose);
    });

    /* ── Confirmation : <form data-confirm="Question ?"> ── */
    document.addEventListener('submit', function (e) {
        var q = e.target.getAttribute && e.target.getAttribute('data-confirm');
        if (q && !window.confirm(q)) { e.preventDefault(); return; }
        // Bouton verrouillé pendant l'envoi : <form data-lock="Envoi…">
        var lock = e.target.getAttribute && e.target.getAttribute('data-lock');
        if (lock && !e.defaultPrevented) {
            var b = e.target.querySelector('button[type=submit]');
            if (b) { b.disabled = true; b.textContent = lock; }
        }
    });

    /* ── Afficher / masquer un mot de passe : <button data-toggle-pwd="id"> ── */
    document.querySelectorAll('[data-toggle-pwd]').forEach(function (btn) {
        var input = document.getElementById(btn.getAttribute('data-toggle-pwd'));
        btn.addEventListener('click', function () {
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            btn.setAttribute('aria-pressed', show ? 'true' : 'false');
            btn.setAttribute('aria-label', show ? 'Masquer le mot de passe' : 'Afficher le mot de passe');
        });
    });
})();
</script>
</body>
</html>
