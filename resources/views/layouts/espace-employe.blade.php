<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mon Espace') - Portail RH</title>

    <!-- Google Fonts — Swiss Editorial Design System -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=DM+Serif+Display&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ============================================================
           ESPACE EMPLOYE — Swiss Corporate Editorial Design System
           Geometric precision · Warm accents · Editorial typography
           ============================================================ */
        :root {
            --e-slate-50: #f8fafc;
            --e-slate-100: #f1f5f9;
            --e-slate-200: #e2e8f0;
            --e-slate-300: #cbd5e1;
            --e-slate-400: #94a3b8;
            --e-slate-500: #64748b;
            --e-slate-600: #475569;
            --e-slate-700: #334155;
            --e-slate-800: #1e293b;
            --e-slate-900: #0f172a;
            --e-slate-950: #020617;
            --e-blue: #3b7dd8;
            --e-blue-deep: #2563a0;
            --e-blue-pale: #dbeafe;
            --e-blue-wash: #eff6ff;
            --e-amber: #e8850c;
            --e-amber-bright: #f59e0b;
            --e-amber-pale: #fef3c7;
            --e-amber-wash: #fffbeb;
            --e-emerald: #059669;
            --e-emerald-pale: #d1fae5;
            --e-red: #dc2626;
            --e-red-pale: #fee2e2;
            --e-surface: #ffffff;
            --e-bg: var(--e-slate-50);
            --e-text: var(--e-slate-900);
            --e-text-secondary: var(--e-slate-500);
            --e-text-tertiary: var(--e-slate-400);
            --e-border: var(--e-slate-200);
            --e-border-light: var(--e-slate-100);
            --e-shadow-sm: 0 1px 2px rgba(0,0,0,0.04);
            --e-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            --e-shadow-md: 0 4px 6px -1px rgba(0,0,0,0.07), 0 2px 4px -2px rgba(0,0,0,0.05);
            --e-shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.08), 0 4px 6px -4px rgba(0,0,0,0.04);
            --e-shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.08), 0 8px 10px -6px rgba(0,0,0,0.04);
            --e-radius: 12px;
            --e-radius-lg: 16px;
            --e-radius-xl: 20px;
            --e-font-body: 'DM Sans', system-ui, sans-serif;
            --e-font-display: 'DM Serif Display', Georgia, serif;

            /* Layout */
            --ee-sidebar-width: 272px;
        }

        .dark {
            --e-surface: var(--e-slate-800);
            --e-bg: var(--e-slate-900);
            --e-text: var(--e-slate-100);
            --e-text-secondary: var(--e-slate-400);
            --e-text-tertiary: var(--e-slate-500);
            --e-border: var(--e-slate-700);
            --e-border-light: var(--e-slate-800);
            --e-blue-pale: rgba(59, 125, 216, 0.15);
            --e-blue-wash: rgba(59, 125, 216, 0.08);
            --e-amber-pale: rgba(232, 133, 12, 0.15);
            --e-amber-wash: rgba(232, 133, 12, 0.08);
            --e-emerald-pale: rgba(5, 150, 105, 0.15);
            --e-red-pale: rgba(220, 38, 38, 0.15);
            --e-shadow-sm: 0 1px 2px rgba(0,0,0,0.2);
            --e-shadow: 0 1px 3px rgba(0,0,0,0.3);
            --e-shadow-md: 0 4px 6px rgba(0,0,0,0.25);
            --e-shadow-lg: 0 10px 15px rgba(0,0,0,0.3);
            --e-shadow-xl: 0 20px 25px rgba(0,0,0,0.35);
        }

        /* ==================== ANIMATIONS ==================== */
        @keyframes ee-fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes ee-slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes ee-scaleIn {
            from { opacity: 0; transform: scale(0.97); }
            to { opacity: 1; transform: scale(1); }
        }

        @keyframes ee-pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .6; }
        }

        .animate-fade-in {
            animation: ee-fadeUp 0.5s ease both;
        }

        /* ==================== BASE ==================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--e-font-body);
            background: var(--e-bg);
            color: var(--e-text);
            min-height: 100vh;
            overflow-x: hidden;
            font-size: 0.9375rem;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* ==================== LAYOUT ==================== */
        .ee-layout {
            display: flex;
            min-height: 100vh;
        }

        /* ==================== SIDEBAR ==================== */
        .ee-sidebar {
            width: var(--ee-sidebar-width);
            background: var(--e-slate-900);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Sidebar Header */
        .ee-sidebar-header {
            padding: 1.5rem 1.25rem 1.25rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .ee-user-avatar-wrapper {
            position: relative;
            margin-bottom: 0.875rem;
        }

        .ee-user-avatar {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.15);
            object-fit: cover;
            background: rgba(255, 255, 255, 0.08);
            transition: all 0.3s ease;
        }

        .ee-user-avatar:hover {
            border-color: var(--e-amber);
        }

        .ee-user-status {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 14px;
            height: 14px;
            background: var(--e-emerald);
            border: 2.5px solid var(--e-slate-900);
            border-radius: 50%;
        }

        .ee-user-info { width: 100%; }

        .ee-user-name {
            font-family: var(--e-font-display);
            font-size: 1.0625rem;
            font-weight: 400;
            color: white;
            margin-bottom: 0.125rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ee-user-role {
            font-size: 0.8125rem;
            color: var(--e-slate-400);
            margin-bottom: 0.625rem;
        }

        .ee-user-matricule {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            font-size: 0.6875rem;
            font-weight: 600;
            color: var(--e-slate-900);
            background: var(--e-amber);
            padding: 0.3rem 0.75rem;
            border-radius: 6px;
            letter-spacing: 0.5px;
        }

        .ee-user-matricule svg {
            width: 11px;
            height: 11px;
        }

        /* Sidebar Nav */
        .ee-sidebar-nav {
            flex: 1;
            padding: 0.75rem 0.75rem;
            overflow-y: auto;
        }

        .ee-sidebar-nav::-webkit-scrollbar { width: 3px; }
        .ee-sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        .ee-sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.15); border-radius: 3px; }

        .ee-nav-section { margin-bottom: 1.25rem; }

        .ee-nav-title {
            font-size: 0.625rem;
            font-weight: 700;
            color: var(--e-slate-500);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 0 0.75rem;
            margin-bottom: 0.5rem;
        }

        .ee-nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6875rem 0.75rem;
            border-radius: 8px;
            color: var(--e-slate-400);
            text-decoration: none;
            font-size: 0.8125rem;
            font-weight: 500;
            transition: all 0.2s ease;
            margin-bottom: 2px;
            position: relative;
        }

        .ee-nav-link:hover {
            background: rgba(255, 255, 255, 0.06);
            color: var(--e-slate-200);
        }

        .ee-nav-link.active {
            background: rgba(59, 125, 216, 0.12);
            color: white;
        }

        .ee-nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 20px;
            background: var(--e-amber);
            border-radius: 0 3px 3px 0;
        }

        .ee-nav-link svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            opacity: 0.7;
        }

        .ee-nav-link.active svg { opacity: 1; }

        .ee-nav-badge {
            margin-left: auto;
            background: rgba(255, 255, 255, 0.12);
            color: var(--e-slate-300);
            font-size: 0.625rem;
            font-weight: 700;
            padding: 0.2rem 0.5rem;
            border-radius: 6px;
            min-width: 20px;
            text-align: center;
        }

        .ee-nav-badge.warning { background: rgba(232, 133, 12, 0.25); color: var(--e-amber-bright); }
        .ee-nav-badge.danger { background: rgba(220, 38, 38, 0.25); color: #fca5a5; }

        /* Sidebar Footer */
        .ee-sidebar-footer {
            padding: 1rem 0.75rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .ee-btn-portal {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.6875rem;
            background: rgba(59, 125, 216, 0.1);
            border: 1px solid rgba(59, 125, 216, 0.2);
            border-radius: 8px;
            color: var(--e-blue);
            font-size: 0.8125rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
            margin-bottom: 0.5rem;
        }

        .ee-btn-portal:hover {
            background: rgba(59, 125, 216, 0.18);
            border-color: rgba(59, 125, 216, 0.3);
        }

        .ee-btn-portal svg { width: 16px; height: 16px; }

        .ee-btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.6875rem;
            background: rgba(220, 38, 38, 0.08);
            border: 1px solid rgba(220, 38, 38, 0.15);
            border-radius: 8px;
            color: #f87171;
            font-size: 0.8125rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .ee-btn-logout:hover {
            background: rgba(220, 38, 38, 0.15);
            border-color: rgba(220, 38, 38, 0.3);
            color: #fca5a5;
        }

        .ee-btn-logout svg { width: 16px; height: 16px; }

        /* ==================== MAIN CONTENT ==================== */
        .ee-main {
            flex: 1;
            margin-left: var(--ee-sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: var(--e-bg);
        }

        /* ==================== HEADER ==================== */
        .ee-header {
            background: var(--e-surface);
            border-bottom: 1px solid var(--e-border);
            padding: 0.875rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: var(--e-shadow-sm);
        }

        .ee-header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .ee-mobile-toggle {
            display: none;
            width: 40px;
            height: 40px;
            border: 1px solid var(--e-border);
            border-radius: 8px;
            background: var(--e-surface);
            color: var(--e-text);
            cursor: pointer;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .ee-mobile-toggle:hover {
            background: var(--e-blue-wash);
            color: var(--e-blue);
            border-color: var(--e-blue);
        }

        .ee-mobile-toggle svg { width: 20px; height: 20px; }

        .ee-page-info { display: flex; flex-direction: column; gap: 0.125rem; }

        .ee-page-title {
            font-family: var(--e-font-display);
            font-size: 1.375rem;
            font-weight: 400;
            color: var(--e-text);
            letter-spacing: -0.01em;
        }

        .ee-breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            font-size: 0.8125rem;
            color: var(--e-text-secondary);
        }

        .ee-breadcrumb a {
            color: var(--e-blue);
            text-decoration: none;
            font-weight: 500;
        }

        .ee-breadcrumb a:hover { color: var(--e-blue-deep); }
        .ee-breadcrumb svg { width: 12px; height: 12px; opacity: 0.5; }

        .ee-header-right {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .ee-header-btn {
            position: relative;
            width: 40px;
            height: 40px;
            border: 1px solid var(--e-border);
            border-radius: 8px;
            background: var(--e-surface);
            color: var(--e-text-secondary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .ee-header-btn:hover {
            background: var(--e-blue-wash);
            color: var(--e-blue);
            border-color: var(--e-blue);
        }

        .ee-header-btn svg { width: 20px; height: 20px; }

        .ee-header-btn .badge {
            position: absolute;
            top: -4px;
            right: -4px;
            min-width: 18px;
            height: 18px;
            background: var(--e-red);
            color: white;
            font-size: 0.625rem;
            font-weight: 700;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
            border: 2px solid var(--e-surface);
        }

        .ee-theme-toggle {
            width: 40px;
            height: 40px;
            border: 1px solid var(--e-border);
            border-radius: 8px;
            background: var(--e-surface);
            color: var(--e-text-secondary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .ee-theme-toggle:hover {
            background: var(--e-amber-wash);
            color: var(--e-amber);
            border-color: var(--e-amber);
        }

        .ee-theme-toggle .sun-icon,
        .ee-theme-toggle .moon-icon {
            position: absolute;
            width: 20px;
            height: 20px;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .ee-theme-toggle .sun-icon { opacity: 1; transform: rotate(0deg) scale(1); }
        .ee-theme-toggle .moon-icon { opacity: 0; transform: rotate(-90deg) scale(0.5); }
        .dark .ee-theme-toggle .sun-icon { opacity: 0; transform: rotate(90deg) scale(0.5); }
        .dark .ee-theme-toggle .moon-icon { opacity: 1; transform: rotate(0deg) scale(1); }

        /* ==================== CONTENT ==================== */
        .ee-content {
            flex: 1;
            padding: 1.75rem 2rem;
            background: var(--e-bg);
        }

        /* ==================== FOOTER ==================== */
        .ee-footer {
            padding: 1.25rem 2rem;
            background: var(--e-surface);
            border-top: 1px solid var(--e-border);
            text-align: center;
        }

        .ee-footer-text {
            font-size: 0.8125rem;
            color: var(--e-text-secondary);
        }

        .ee-footer-link {
            color: var(--e-blue);
            text-decoration: none;
            font-weight: 600;
        }

        .ee-footer-link:hover { color: var(--e-blue-deep); }

        /* ==================== OVERLAY MOBILE ==================== */
        .ee-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(4px);
            z-index: 90;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .ee-overlay.active {
            display: block;
            opacity: 1;
        }

        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 1024px) {
            .ee-sidebar { transform: translateX(-100%); }
            .ee-sidebar.open { transform: translateX(0); }
            .ee-main { margin-left: 0; }
            .ee-mobile-toggle { display: flex; }
            .ee-content { padding: 1.25rem; }
        }

        @media (max-width: 640px) {
            .ee-header { padding: 0.75rem 1rem; }
            .ee-content { padding: 1rem; }
            .ee-page-title { font-size: 1.125rem; }
            .ee-breadcrumb { display: none; }
        }

        /* ==================== NOTIFICATION DROPDOWN ==================== */
        .ee-notif-wrapper { position: relative; }

        .ee-notif-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            width: 360px;
            max-width: calc(100vw - 2rem);
            background: var(--e-surface);
            border: 1px solid var(--e-border);
            border-radius: var(--e-radius-lg);
            box-shadow: var(--e-shadow-xl);
            z-index: 200;
            overflow: hidden;
        }
        .ee-notif-dropdown.open { display: block; animation: ee-slideDown 0.2s ease; }

        .ee-notif-dropdown-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--e-border);
        }
        .ee-notif-dropdown-title { font-size: 0.9375rem; font-weight: 700; color: var(--e-text); }
        .ee-notif-mark-all {
            font-size: 0.8125rem; font-weight: 500; color: var(--e-blue);
            background: none; border: none; cursor: pointer; padding: 0;
        }
        .ee-notif-mark-all:hover { text-decoration: underline; }

        .ee-notif-dropdown-body {
            max-height: 320px;
            overflow-y: auto;
        }

        .ee-notif-item {
            display: flex;
            gap: 0.75rem;
            padding: 0.875rem 1.25rem;
            border-bottom: 1px solid var(--e-border-light);
            cursor: pointer;
            transition: background 0.15s;
        }
        .ee-notif-item:hover { background: var(--e-bg); }
        .ee-notif-item:last-child { border-bottom: none; }

        .ee-notif-item-icon {
            width: 36px; height: 36px; border-radius: var(--e-radius);
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .ee-notif-item-icon svg { width: 18px; height: 18px; }
        .ee-notif-item-icon.success { background: var(--e-emerald-pale); color: var(--e-emerald); }
        .ee-notif-item-icon.info { background: var(--e-blue-wash); color: var(--e-blue); }
        .ee-notif-item-icon.warning { background: var(--e-amber-pale); color: var(--e-amber); }
        .ee-notif-item-icon.danger { background: var(--e-red-pale); color: var(--e-red); }

        .ee-notif-item-content { flex: 1; min-width: 0; }
        .ee-notif-item-msg {
            font-size: 0.875rem; font-weight: 500; color: var(--e-text);
            margin-bottom: 0.25rem;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }
        .ee-notif-item-time { font-size: 0.75rem; color: var(--e-text-secondary); }

        .ee-notif-empty {
            padding: 2rem;
            text-align: center;
            font-size: 0.875rem;
            color: var(--e-text-secondary);
        }

        /* ==================== SCROLLBAR ==================== */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--e-border); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--e-text-tertiary); }
    </style>
    @yield('styles')
</head>
<body>
    <div class="ee-layout">
        <!-- Overlay Mobile -->
        <div class="ee-overlay" id="eeOverlay" onclick="toggleSidebar()"></div>

        <!-- Sidebar -->
        <aside class="ee-sidebar" id="eeSidebar">
            <div class="ee-sidebar-header">
                @php
                    $personnel = auth()->user()->personnel;
                @endphp
                <div class="ee-user-avatar-wrapper">
                    <img src="{{ $personnel && $personnel->photo ? asset('storage/' . $personnel->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&size=200&background=1e293b&color=e2e8f0&bold=true' }}"
                         alt="Photo"
                         class="ee-user-avatar"
                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&size=200&background=1e293b&color=e2e8f0&bold=true'">
                    <span class="ee-user-status"></span>
                </div>
                <div class="ee-user-info">
                    <div class="ee-user-name">{{ $personnel ? $personnel->civilite . ' ' . $personnel->nom . ' ' . $personnel->prenoms : auth()->user()->name }}</div>
                    <div class="ee-user-role">{{ $personnel->poste ?? 'Employ&eacute;' }}</div>
                    @if($personnel && $personnel->matricule)
                        <span class="ee-user-matricule">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            {{ $personnel->matricule }}
                        </span>
                    @endif
                </div>
            </div>

            <nav class="ee-sidebar-nav">
                <!-- Mon Espace -->
                <div class="ee-nav-section">
                    <div class="ee-nav-title">Mon Espace</div>
                    <a href="{{ route('espace-employe.dashboard') }}" class="ee-nav-link {{ request()->routeIs('espace-employe.dashboard') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        Tableau de bord
                    </a>
                    <a href="{{ route('espace-employe.profil') }}" class="ee-nav-link {{ request()->routeIs('espace-employe.profil') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        Mon Profil
                    </a>
                </div>

                <!-- Documents -->
                <div class="ee-nav-section">
                    <div class="ee-nav-title">Documents</div>
                    <a href="{{ route('espace-employe.documents') }}" class="ee-nav-link {{ request()->routeIs('espace-employe.documents') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                        </svg>
                        Mes Documents
                    </a>
                    <a href="{{ route('espace-employe.bulletins') }}" class="ee-nav-link {{ request()->routeIs('espace-employe.bulletins') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                            <line x1="8" y1="21" x2="16" y2="21"></line>
                            <line x1="12" y1="17" x2="12" y2="21"></line>
                        </svg>
                        Bulletins de paie
                    </a>
                    <a href="{{ route('espace-employe.attestations') }}" class="ee-nav-link {{ request()->routeIs('espace-employe.attestations') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            <path d="M9 12l2 2 4-4"></path>
                        </svg>
                        Attestations
                    </a>
                </div>

                <!-- Demandes -->
                <div class="ee-nav-section">
                    <div class="ee-nav-title">Demandes</div>
                    <a href="{{ route('espace-employe.conges') }}" class="ee-nav-link {{ request()->routeIs('espace-employe.conges') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        Cong&eacute;s &amp; Absences
                    </a>
                </div>
            </nav>

            <div class="ee-sidebar-footer">
                @if(auth()->user()->hasRole('Super Admin'))
                <a href="{{ route('admin.dashboard') }}" class="ee-btn-portal">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 19l-7-7 7-7"></path>
                    </svg>
                    Portail RH
                </a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="ee-btn-logout">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        D&eacute;connexion
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="ee-main">
            <!-- Header -->
            <header class="ee-header">
                <div class="ee-header-left">
                    <button class="ee-mobile-toggle" onclick="toggleSidebar()" aria-label="Menu">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
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
                    <div class="ee-notif-wrapper">
                        <button class="ee-header-btn" id="eeNotifBtn" title="Notifications">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
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
                    <button class="ee-theme-toggle" onclick="toggleTheme()" title="Changer le th&egrave;me">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="sun-icon">
                            <circle cx="12" cy="12" r="5"></circle>
                            <line x1="12" y1="1" x2="12" y2="3"></line>
                            <line x1="12" y1="21" x2="12" y2="23"></line>
                            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                            <line x1="1" y1="12" x2="3" y2="12"></line>
                            <line x1="21" y1="12" x2="23" y2="12"></line>
                            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="moon-icon">
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                        </svg>
                    </button>
                </div>
            </header>

            <!-- Content -->
            <div class="ee-content">
                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="ee-footer">
                <p class="ee-footer-text">
                    &copy; {{ date('Y') }} <a href="{{ route('espace-employe.dashboard') }}" class="ee-footer-link">Portail RH</a> - Tous droits r&eacute;serv&eacute;s
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
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
        }

        // Load saved theme
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }

        // Close sidebar on window resize (desktop)
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
            const btn = document.getElementById('eeNotifBtn');
            const dropdown = document.getElementById('eeNotifDropdown');
            const badge = document.getElementById('eeNotifBadge');
            const list = document.getElementById('eeNotifList');
            const markAllBtn = document.getElementById('eeMarkAllRead');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

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
                    }).then(() => {
                        fetchNotifications();
                    }).catch(() => {});
                });
            }

            fetchNotifications();
            setInterval(fetchNotifications, 30000);
        })();
    </script>
    @yield('scripts')
</body>
</html>
