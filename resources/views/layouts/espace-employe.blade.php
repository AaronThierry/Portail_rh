<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mon Espace') - Portail RH+</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/logo.png') }}">

    <!-- Theme init — must run BEFORE any render to prevent FOUC -->
    <script>(function(){var t=localStorage.getItem('theme');if(t==='dark'){document.documentElement.classList.add('dark');}})();</script>

    <!-- Google Fonts — Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ============================================================
           PORTAIL RH+ — ESPACE EMPLOYÉ
           Charte Orange · Bleu · Gris — Simple, Pro, Élégant
           ============================================================ */

        :root {
            color-scheme: light;

            /* ── Orange ── */
            --o-500: #f97316;
            --o-600: #ea580c;
            --o-100: #ffedd5;
            --o-50:  #fff7ed;

            /* ── Bleu ── */
            --b-600: #2563eb;
            --b-700: #1d4ed8;
            --b-100: #dbeafe;
            --b-50:  #eff6ff;

            /* ── Gris ── */
            --g-50:  #f9fafb;
            --g-100: #f3f4f6;
            --g-200: #e5e7eb;
            --g-300: #d1d5db;
            --g-400: #9ca3af;
            --g-500: #6b7280;
            --g-600: #4b5563;
            --g-700: #374151;
            --g-800: #1f2937;
            --g-900: #111827;

            /* ── Sémantique ── */
            --success:      #16a34a;
            --success-pale: #dcfce7;
            --danger:       #dc2626;
            --danger-pale:  #fee2e2;
            --warning:      #d97706;
            --warning-pale: #fef3c7;

            /* ── Layout ── */
            --bg:       #f0f2f5;
            --surface:  #ffffff;
            --border:   #e5e7eb;
            --border-light: #f3f4f6;
            --text:     #111827;
            --text-2:   #6b7280;
            --text-3:   #9ca3af;

            --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
            --shadow:    0 1px 3px rgba(0,0,0,0.07), 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.07), 0 2px 4px -2px rgba(0,0,0,0.04);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.08), 0 4px 6px -4px rgba(0,0,0,0.04);
            --shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.08), 0 8px 10px -6px rgba(0,0,0,0.04);

            --radius:    8px;
            --radius-sm: 6px;
            --radius-lg: 12px;

            --font: 'Plus Jakarta Sans', system-ui, sans-serif;
            --sidebar-w: 256px;
        }

        /* ── DARK MODE ── */
        .dark {
            color-scheme: dark;
            --bg:       #0d1117;
            --surface:  #161b22;
            --border:   #30363d;
            --border-light: #21262d;
            --text:     #e6edf3;
            --text-2:   #8b949e;
            --text-3:   #6e7681;
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.3);
            --shadow:    0 1px 4px rgba(0,0,0,0.4);
            --shadow-md: 0 4px 10px rgba(0,0,0,0.35);
            --shadow-lg: 0 12px 24px rgba(0,0,0,0.4);
            --shadow-xl: 0 24px 40px rgba(0,0,0,0.45);
            --o-50:      rgba(249,115,22,0.08);
            --o-100:     rgba(249,115,22,0.15);
            --b-50:      rgba(37,99,235,0.08);
            --b-100:     rgba(37,99,235,0.15);
            --success-pale: rgba(22,163,74,0.15);
            --danger-pale:  rgba(220,38,38,0.15);
            --warning-pale: rgba(217,119,6,0.15);
        }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-in { animation: fadeUp 0.35s ease both; }

        /* ── RESET ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: var(--font);
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            font-size: 0.9375rem;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        /* ════════════════════════════════════════
           LAYOUT
        ════════════════════════════════════════ */
        .ee-layout {
            display: flex;
            min-height: 100vh;
        }

        /* ════════════════════════════════════════
           SIDEBAR
        ════════════════════════════════════════ */
        .ee-sidebar {
            width: var(--sidebar-w);
            background: var(--surface);
            border-right: 1px solid var(--border);
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);
            overflow: hidden;
        }

        /* ── Brand ── */
        .ee-sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            padding: 1rem 1rem 0.875rem;
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
        }

        .ee-brand-logo {
            width: 36px; height: 36px;
            background: var(--o-500);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-shrink: 0;
        }
        .ee-brand-logo svg { width: 19px; height: 19px; }

        .ee-brand-name {
            font-size: 0.9375rem;
            font-weight: 700;
            color: var(--text);
            letter-spacing: -0.02em;
        }
        .ee-brand-name span { color: var(--o-500); }
        .ee-brand-label {
            display: block;
            font-size: 0.6875rem;
            font-weight: 500;
            color: var(--text-3);
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* ── User Profile ── */
        .ee-sidebar-user {
            padding: 0.875rem 1rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-shrink: 0;
        }

        .ee-user-avatar {
            width: 40px; height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--border);
            flex-shrink: 0;
            transition: border-color 0.2s;
        }
        .ee-sidebar-user:hover .ee-user-avatar { border-color: var(--o-500); }

        .ee-user-details { flex: 1; min-width: 0; }
        .ee-user-name {
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.3;
        }
        .ee-user-role {
            font-size: 0.75rem;
            color: var(--text-2);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ee-user-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.625rem;
            font-weight: 700;
            color: white;
            background: var(--o-500);
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            letter-spacing: 0.5px;
            flex-shrink: 0;
        }

        /* ── Navigation ── */
        .ee-sidebar-nav {
            flex: 1;
            padding: 0.75rem 0.625rem;
            overflow-y: auto;
        }
        .ee-sidebar-nav::-webkit-scrollbar { width: 3px; }
        .ee-sidebar-nav::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }

        .ee-nav-section { margin-bottom: 1rem; }

        .ee-nav-title {
            font-size: 0.625rem;
            font-weight: 700;
            color: var(--text-3);
            text-transform: uppercase;
            letter-spacing: 1.2px;
            padding: 0 0.625rem;
            margin-bottom: 0.375rem;
        }

        .ee-nav-link {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.5625rem 0.625rem;
            border-radius: var(--radius-sm);
            color: var(--text-2);
            text-decoration: none;
            font-size: 0.8125rem;
            font-weight: 500;
            transition: all 0.15s ease;
            margin-bottom: 1px;
            position: relative;
        }
        .ee-nav-link:hover {
            background: var(--g-50);
            color: var(--text);
        }
        .dark .ee-nav-link:hover {
            background: rgba(255,255,255,0.04);
            color: var(--text);
        }
        .ee-nav-link.active {
            background: var(--o-50);
            color: var(--o-600);
            font-weight: 600;
        }
        .dark .ee-nav-link.active {
            background: rgba(249,115,22,0.1);
            color: #fb923c;
        }
        .ee-nav-link.active::before {
            content: '';
            position: absolute;
            left: 0; top: 50%;
            transform: translateY(-50%);
            width: 3px; height: 18px;
            background: var(--o-500);
            border-radius: 0 3px 3px 0;
        }
        .ee-nav-link svg {
            width: 17px; height: 17px;
            flex-shrink: 0;
            opacity: 0.65;
            transition: opacity 0.15s;
        }
        .ee-nav-link.active svg, .ee-nav-link:hover svg { opacity: 1; }

        .ee-nav-badge {
            margin-left: auto;
            background: var(--o-100);
            color: var(--o-600);
            font-size: 0.625rem;
            font-weight: 700;
            padding: 0.15rem 0.45rem;
            border-radius: 10px;
        }
        .dark .ee-nav-badge {
            background: rgba(249,115,22,0.18);
            color: #fb923c;
        }

        /* ── Sidebar Footer ── */
        .ee-sidebar-footer {
            padding: 0.75rem 0.625rem;
            border-top: 1px solid var(--border);
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            gap: 0.375rem;
        }

        .ee-btn-portal {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.5625rem;
            background: var(--b-50);
            border: 1px solid var(--b-100);
            border-radius: var(--radius-sm);
            color: var(--b-600);
            font-size: 0.8125rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s;
            font-family: var(--font);
        }
        .ee-btn-portal:hover {
            background: var(--b-100);
            border-color: var(--b-600);
        }
        .dark .ee-btn-portal {
            background: rgba(37,99,235,0.08);
            border-color: rgba(37,99,235,0.2);
            color: #60a5fa;
        }
        .dark .ee-btn-portal:hover {
            background: rgba(37,99,235,0.15);
            border-color: rgba(37,99,235,0.4);
        }
        .ee-btn-portal svg { width: 15px; height: 15px; }

        .ee-btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.5625rem;
            background: transparent;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--text-2);
            font-size: 0.8125rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
            font-family: var(--font);
        }
        .ee-btn-logout:hover {
            background: var(--danger-pale);
            border-color: var(--danger);
            color: var(--danger);
        }
        .ee-btn-logout svg { width: 15px; height: 15px; }

        /* ════════════════════════════════════════
           MAIN
        ════════════════════════════════════════ */
        .ee-main {
            flex: 1;
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ════════════════════════════════════════
           HEADER
        ════════════════════════════════════════ */
        .ee-header {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 0 1.5rem;
            height: 56px;
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
            gap: 0.875rem;
        }

        .ee-mobile-toggle {
            display: none;
            width: 36px; height: 36px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            background: var(--surface);
            color: var(--text-2);
            cursor: pointer;
            align-items: center;
            justify-content: center;
            transition: all 0.15s;
        }
        .ee-mobile-toggle:hover {
            background: var(--o-50);
            border-color: var(--o-500);
            color: var(--o-600);
        }
        .ee-mobile-toggle svg { width: 18px; height: 18px; }

        .ee-page-info { display: flex; flex-direction: column; gap: 1px; }

        .ee-page-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text);
            letter-spacing: -0.01em;
            line-height: 1.2;
        }

        .ee-breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            font-size: 0.75rem;
            color: var(--text-3);
        }
        .ee-breadcrumb a { color: var(--b-600); text-decoration: none; font-weight: 500; }
        .ee-breadcrumb a:hover { color: var(--b-700); }
        .ee-breadcrumb svg { width: 10px; height: 10px; opacity: 0.5; }

        .ee-header-right {
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .ee-header-btn {
            position: relative;
            width: 36px; height: 36px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            background: var(--surface);
            color: var(--text-2);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s;
        }
        .ee-header-btn:hover {
            background: var(--o-50);
            border-color: var(--o-500);
            color: var(--o-600);
        }
        .ee-header-btn svg { width: 18px; height: 18px; }

        .ee-header-btn .badge {
            position: absolute;
            top: -5px; right: -5px;
            min-width: 17px; height: 17px;
            background: var(--danger);
            color: white;
            font-size: 0.5625rem;
            font-weight: 700;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 3px;
            border: 2px solid var(--surface);
        }

        /* Theme toggle */
        .ee-theme-toggle {
            width: 36px; height: 36px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            background: var(--surface);
            color: var(--text-2);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s;
            position: relative;
            overflow: hidden;
        }
        .ee-theme-toggle:hover {
            background: var(--o-50);
            border-color: var(--o-500);
            color: var(--o-500);
        }
        .dark .ee-theme-toggle:hover {
            background: rgba(96,165,250,0.1);
            border-color: rgba(96,165,250,0.3);
            color: #60a5fa;
        }
        .ee-theme-toggle .sun-icon,
        .ee-theme-toggle .moon-icon {
            position: absolute;
            width: 18px; height: 18px;
            transition: all 0.4s cubic-bezier(0.34,1.56,0.64,1);
        }
        .ee-theme-toggle .sun-icon  { opacity: 1; transform: rotate(0) scale(1); color: var(--o-500); }
        .ee-theme-toggle .moon-icon { opacity: 0; transform: rotate(-90deg) scale(0.5); color: #60a5fa; }
        .dark .ee-theme-toggle .sun-icon  { opacity: 0; transform: rotate(90deg) scale(0.5); }
        .dark .ee-theme-toggle .moon-icon { opacity: 1; transform: rotate(0) scale(1); }

        /* Header avatar */
        .ee-header-avatar {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            margin-left: 0.25rem;
        }
        .ee-header-avatar img {
            width: 32px; height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--border);
            transition: border-color 0.15s;
        }
        .ee-header-avatar:hover img { border-color: var(--o-500); }
        .ee-header-avatar-status {
            position: absolute;
            bottom: -1px; right: -1px;
            width: 9px; height: 9px;
            background: var(--success);
            border: 2px solid var(--surface);
            border-radius: 50%;
        }

        /* Notification dot */
        .ee-notif-btn.has-notif::after {
            content: '';
            position: absolute;
            top: 7px; right: 7px;
            width: 7px; height: 7px;
            background: var(--danger);
            border-radius: 50%;
            border: 1.5px solid var(--surface);
        }

        /* ════════════════════════════════════════
           NOTIFICATION DROPDOWN
        ════════════════════════════════════════ */
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
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-xl);
            z-index: 200;
            overflow: hidden;
        }
        .ee-notif-dropdown.open { display: block; animation: slideDown 0.2s ease; }

        .ee-notif-dropdown-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.875rem 1.125rem;
            border-bottom: 1px solid var(--border);
        }
        .ee-notif-dropdown-title { font-size: 0.875rem; font-weight: 700; color: var(--text); }
        .ee-notif-mark-all {
            font-size: 0.75rem; font-weight: 600; color: var(--b-600);
            background: none; border: none; cursor: pointer; padding: 0; font-family: var(--font);
        }
        .ee-notif-mark-all:hover { text-decoration: underline; }

        .ee-notif-dropdown-body { max-height: 300px; overflow-y: auto; }

        .ee-notif-item {
            display: flex;
            gap: 0.75rem;
            padding: 0.75rem 1.125rem;
            border-bottom: 1px solid var(--border-light);
            cursor: pointer;
            transition: background 0.15s;
        }
        .ee-notif-item:hover { background: var(--g-50); }
        .dark .ee-notif-item:hover { background: rgba(255,255,255,0.03); }
        .ee-notif-item:last-child { border-bottom: none; }

        .ee-notif-item-icon {
            width: 34px; height: 34px; border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .ee-notif-item-icon svg { width: 16px; height: 16px; }
        .ee-notif-item-icon.success { background: var(--success-pale); color: var(--success); }
        .ee-notif-item-icon.info    { background: var(--b-50); color: var(--b-600); }
        .ee-notif-item-icon.warning { background: var(--warning-pale); color: var(--warning); }
        .ee-notif-item-icon.danger  { background: var(--danger-pale); color: var(--danger); }

        .ee-notif-item-content { flex: 1; min-width: 0; }
        .ee-notif-item-msg {
            font-size: 0.8125rem; font-weight: 500; color: var(--text); margin-bottom: 0.2rem;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }
        .ee-notif-item-time { font-size: 0.6875rem; color: var(--text-3); }

        .ee-notif-empty {
            padding: 2rem; text-align: center;
            font-size: 0.8125rem; color: var(--text-2);
        }

        /* ════════════════════════════════════════
           CONTENT & FOOTER
        ════════════════════════════════════════ */
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
        .ee-footer-text { font-size: 0.75rem; color: var(--text-3); }
        .ee-footer-link { color: var(--o-500); text-decoration: none; font-weight: 600; }
        .ee-footer-link:hover { color: var(--o-600); }

        /* ════════════════════════════════════════
           OVERLAY MOBILE
        ════════════════════════════════════════ */
        .ee-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.4);
            backdrop-filter: blur(2px);
            z-index: 90;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .ee-overlay.active { display: block; opacity: 1; }

        /* ════════════════════════════════════════
           SCROLLBAR
        ════════════════════════════════════════ */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--text-3); }

        /* ════════════════════════════════════════
           DARK MODE — composants
        ════════════════════════════════════════ */
        .dark .ee-sidebar { background: #161b22; border-right-color: #30363d; }
        .dark .ee-header  { background: #161b22; border-bottom-color: #30363d; box-shadow: 0 1px 0 #30363d; }
        .dark .ee-header-btn { background: #161b22; border-color: #30363d; }
        .dark .ee-header-btn:hover { background: rgba(249,115,22,0.1); border-color: rgba(249,115,22,0.3); color: #fb923c; }
        .dark .ee-mobile-toggle { background: #161b22; border-color: #30363d; }
        .dark .ee-mobile-toggle:hover { background: rgba(249,115,22,0.1); border-color: rgba(249,115,22,0.3); color: #fb923c; }
        .dark .ee-header-avatar img { border-color: #30363d; }
        .dark .ee-notif-dropdown { background: #1c2128; border-color: #30363d; box-shadow: 0 20px 40px rgba(0,0,0,0.6); }
        .dark .ee-notif-dropdown-header { border-bottom-color: #30363d; }
        .dark .ee-notif-item { border-bottom-color: #21262d; }
        .dark .ee-footer { background: #161b22; border-top-color: #30363d; }
        .dark .ee-brand-logo { background: var(--o-500); }
        .dark .ee-btn-logout { border-color: #30363d; color: #8b949e; }

        /* ════════════════════════════════════════
           RESPONSIVE
        ════════════════════════════════════════ */
        @media (max-width: 1024px) {
            .ee-sidebar { transform: translateX(-100%); }
            .ee-sidebar.open { transform: translateX(0); box-shadow: var(--shadow-xl); }
            .ee-main { margin-left: 0; }
            .ee-mobile-toggle { display: flex; }
            .ee-content { padding: 1rem; }
        }
        @media (max-width: 640px) {
            .ee-header { padding: 0 1rem; }
            .ee-content { padding: 0.875rem; }
            .ee-page-title { font-size: 0.9375rem; }
            .ee-breadcrumb { display: none; }
            .ee-header-avatar { display: none; }
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="ee-layout">
        <!-- Overlay Mobile -->
        <div class="ee-overlay" id="eeOverlay" onclick="toggleSidebar()"></div>

        <!-- ════ SIDEBAR ════ -->
        <aside class="ee-sidebar" id="eeSidebar">

            <!-- Brand -->
            <div class="ee-sidebar-brand">
                <div class="ee-brand-logo">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        <path d="M21 21v-2a4 4 0 0 0-3-3.87"></path>
                    </svg>
                </div>
                <div>
                    <div class="ee-brand-name">Portail <span>RH+</span></div>
                    <span class="ee-brand-label">Espace Employ&eacute;</span>
                </div>
            </div>

            <!-- User -->
            <div class="ee-sidebar-user">
                @php $personnel = auth()->user()->personnel; @endphp
                <img src="{{ $personnel && $personnel->photo ? asset('storage/' . $personnel->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&size=200&background=f97316&color=ffffff&bold=true' }}"
                     alt="Photo" class="ee-user-avatar"
                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&size=200&background=f97316&color=ffffff&bold=true'">
                <div class="ee-user-details">
                    <div class="ee-user-name">{{ $personnel ? $personnel->nom . ' ' . $personnel->prenoms : auth()->user()->name }}</div>
                    <div class="ee-user-role">{{ $personnel->poste ?? 'Employ&eacute;' }}</div>
                </div>
                @if($personnel && $personnel->matricule)
                    <span class="ee-user-badge">{{ $personnel->matricule }}</span>
                @endif
            </div>

            <!-- Nav -->
            <nav class="ee-sidebar-nav">
                <div class="ee-nav-section">
                    <div class="ee-nav-title">Mon Espace</div>
                    <a href="{{ route('espace-employe.dashboard') }}" class="ee-nav-link {{ request()->routeIs('espace-employe.dashboard') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        Tableau de bord
                    </a>
                    <a href="{{ route('espace-employe.profil') }}" class="ee-nav-link {{ request()->routeIs('espace-employe.profil') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        Mon Profil
                    </a>
                </div>

                <div class="ee-nav-section">
                    <div class="ee-nav-title">Documents</div>
                    <a href="{{ route('espace-employe.documents') }}" class="ee-nav-link {{ request()->routeIs('espace-employe.documents') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                        Mes Documents
                    </a>
                    <a href="{{ route('espace-employe.bulletins') }}" class="ee-nav-link {{ request()->routeIs('espace-employe.bulletins') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                        Bulletins de paie
                    </a>
                    <a href="{{ route('espace-employe.attestations') }}" class="ee-nav-link {{ request()->routeIs('espace-employe.attestations') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="M9 12l2 2 4-4"></path></svg>
                        Attestations
                    </a>
                </div>

                <div class="ee-nav-section">
                    <div class="ee-nav-title">Demandes</div>
                    <a href="{{ route('espace-employe.conges') }}" class="ee-nav-link {{ request()->routeIs('espace-employe.conges') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        Mes Cong&eacute;s
                    </a>
                    <a href="{{ route('espace-employe.absences') }}" class="ee-nav-link {{ request()->routeIs('espace-employe.absences') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        Mes Absences
                    </a>
                    <a href="{{ route('espace-employe.demandes') }}" class="ee-nav-link {{ request()->routeIs('espace-employe.demandes') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect><path d="M9 14l2 2 4-4"></path></svg>
                        Mes Demandes
                    </a>
                </div>

                <div class="ee-nav-section">
                    <div class="ee-nav-title">Compte</div>
                    <a href="{{ route('espace-employe.parametres') }}" class="ee-nav-link {{ request()->routeIs('espace-employe.parametres') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9c.26.604.852.997 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        Param&egrave;tres
                    </a>
                </div>
            </nav>

            <!-- Footer -->
            <div class="ee-sidebar-footer">
                @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'RH']))
                <a href="{{ route('admin.dashboard') }}" class="ee-btn-portal">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"></path></svg>
                    Portail RH Admin
                </a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="ee-btn-logout">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        D&eacute;connexion
                    </button>
                </form>
            </div>
        </aside>

        <!-- ════ MAIN ════ -->
        <main class="ee-main">

            <!-- Header -->
            <header class="ee-header">
                <div class="ee-header-left">
                    <button class="ee-mobile-toggle" onclick="toggleSidebar()" aria-label="Menu">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
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

                    <!-- Theme -->
                    <button class="ee-theme-toggle" onclick="toggleTheme()" title="Changer le th&egrave;me">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="sun-icon">
                            <circle cx="12" cy="12" r="4" fill="currentColor" opacity="0.15"></circle>
                            <circle cx="12" cy="12" r="4"></circle>
                            <path d="M12 2v2"></path><path d="M12 20v2"></path>
                            <path d="M4.93 4.93l1.41 1.41"></path><path d="M17.66 17.66l1.41 1.41"></path>
                            <path d="M2 12h2"></path><path d="M20 12h2"></path>
                            <path d="M6.34 17.66l-1.41 1.41"></path><path d="M19.07 4.93l-1.41 1.41"></path>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="moon-icon">
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" fill="currentColor" opacity="0.1"></path>
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                            <path d="M17.5 5.5l.5 1 1 .5-1 .5-.5 1-.5-1-1-.5 1-.5z" fill="currentColor" stroke="none"></path>
                            <circle cx="20" cy="10" r="0.6" fill="currentColor" stroke="none"></circle>
                        </svg>
                    </button>

                    <!-- Avatar -->
                    <a href="{{ route('espace-employe.profil') }}" class="ee-header-avatar" title="Mon Profil">
                        @php $headerPersonnel = auth()->user()->personnel; @endphp
                        <img src="{{ $headerPersonnel && $headerPersonnel->photo ? asset('storage/' . $headerPersonnel->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&size=80&background=f97316&color=ffffff&bold=true' }}"
                             alt="Photo"
                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&size=80&background=f97316&color=ffffff&bold=true'">
                        <span class="ee-header-avatar-status"></span>
                    </a>
                </div>
            </header>

            <!-- Content -->
            <div class="ee-content animate-in">
                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="ee-footer">
                <p class="ee-footer-text">
                    &copy; {{ date('Y') }} <a href="{{ route('espace-employe.dashboard') }}" class="ee-footer-link">Portail RH+</a> &mdash; Tous droits r&eacute;serv&eacute;s
                </p>
            </footer>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('eeSidebar');
            const overlay = document.getElementById('eeOverlay');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
            document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
        }

        function toggleTheme() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        }

        window.addEventListener('resize', () => {
            if (window.innerWidth > 1024) {
                const sidebar = document.getElementById('eeSidebar');
                const overlay = document.getElementById('eeOverlay');
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        });

        // === NOTIFICATIONS AJAX ===
        (function() {
            const btn        = document.getElementById('eeNotifBtn');
            const dropdown   = document.getElementById('eeNotifDropdown');
            const badge      = document.getElementById('eeNotifBadge');
            const list       = document.getElementById('eeNotifList');
            const markAllBtn = document.getElementById('eeMarkAllRead');
            const csrfToken  = document.querySelector('meta[name="csrf-token"]')?.content;

            function fetchNotifications() {
                fetch('/api/notifications', { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(r => r.json())
                    .then(data => {
                        if (data.count > 0) {
                            badge.textContent = data.count > 9 ? '9+' : data.count;
                            badge.style.display = '';
                        } else {
                            badge.style.display = 'none';
                        }
                        renderNotifications(data.notifications || []);
                    })
                    .catch(() => {});
            }

            function renderNotifications(items) {
                if (!items.length) {
                    list.innerHTML = '<div class="ee-notif-empty">Aucune notification</div>';
                    return;
                }
                list.innerHTML = items.map(n => {
                    let iconClass = 'info';
                    let iconSvg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>';
                    if (n.status === 'approuve') {
                        iconClass = 'success';
                        iconSvg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>';
                    } else if (n.status === 'refuse') {
                        iconClass = 'danger';
                        iconSvg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';
                    } else if (n.type === 'nouvelle_demande_conge') {
                        iconClass = 'warning';
                        iconSvg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/></svg>';
                    }
                    return `<div class="ee-notif-item" data-id="${n.id}" onclick="markNotifRead('${n.id}', this)">
                        <div class="ee-notif-item-icon ${iconClass}">${iconSvg}</div>
                        <div class="ee-notif-item-content">
                            <div class="ee-notif-item-msg">${n.message}</div>
                            <div class="ee-notif-item-time">${n.created_at}</div>
                        </div>
                    </div>`;
                }).join('');
            }

            window.markNotifRead = function(id, el) {
                fetch(`/api/notifications/${id}/read`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                }).then(() => {
                    if (el) el.remove();
                    fetchNotifications();
                }).catch(() => {});
            };

            if (btn && dropdown) {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('open');
                });
                document.addEventListener('click', function(e) {
                    if (!e.target.closest('.ee-notif-wrapper')) dropdown.classList.remove('open');
                });
            }

            if (markAllBtn) {
                markAllBtn.addEventListener('click', function() {
                    fetch('/api/notifications/read-all', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                    }).then(() => fetchNotifications()).catch(() => {});
                });
            }

            fetchNotifications();
            setInterval(fetchNotifications, 30000);
        })();
    </script>
    @yield('scripts')
</body>
</html>
