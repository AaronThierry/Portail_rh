<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mon Espace') - Portail RH</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            /* Palette Premium - Bleu Nuit & Or */
            --ee-primary: #6366F1;
            --ee-primary-dark: #4F46E5;
            --ee-primary-light: rgba(99, 102, 241, 0.1);
            --ee-secondary: #8B5CF6;
            --ee-accent: #F59E0B;
            --ee-accent-light: rgba(245, 158, 11, 0.1);
            --ee-success: #10B981;
            --ee-danger: #EF4444;
            --ee-warning: #F59E0B;
            --ee-info: #3B82F6;

            /* Textes */
            --ee-text: #1F2937;
            --ee-text-muted: #6B7280;
            --ee-text-light: #9CA3AF;

            /* Backgrounds */
            --ee-bg: #F8FAFC;
            --ee-bg-alt: #F1F5F9;
            --ee-card: #FFFFFF;
            --ee-border: #E2E8F0;

            /* Effets */
            --ee-shadow: rgba(15, 23, 42, 0.08);
            --ee-shadow-lg: rgba(15, 23, 42, 0.12);
            --ee-glass: rgba(255, 255, 255, 0.7);
            --ee-glass-border: rgba(255, 255, 255, 0.5);

            /* Gradients */
            --ee-gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --ee-gradient-sidebar: linear-gradient(180deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
            --ee-gradient-accent: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);

            /* Sidebar */
            --ee-sidebar-width: 280px;
        }

        .dark {
            --ee-bg: #0f172a;
            --ee-bg-alt: #1e293b;
            --ee-card: #1e293b;
            --ee-text: #f1f5f9;
            --ee-text-muted: #94a3b8;
            --ee-text-light: #64748b;
            --ee-border: #334155;
            --ee-shadow: rgba(0, 0, 0, 0.3);
            --ee-shadow-lg: rgba(0, 0, 0, 0.4);
            --ee-glass: rgba(30, 41, 59, 0.8);
            --ee-glass-border: rgba(51, 65, 85, 0.5);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            background: var(--ee-bg);
            color: var(--ee-text);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ==================== LAYOUT PRINCIPAL ==================== */
        .ee-layout {
            display: flex;
            min-height: 100vh;
        }

        /* ==================== SIDEBAR PREMIUM ==================== */
        .ee-sidebar {
            width: var(--ee-sidebar-width);
            background: var(--ee-gradient-sidebar);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.15);
        }

        .ee-sidebar::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }

        /* Header Sidebar - Profil Utilisateur */
        .ee-sidebar-header {
            padding: 1.75rem 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .ee-user-avatar-wrapper {
            position: relative;
            margin-bottom: 1rem;
        }

        .ee-user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid rgba(255, 255, 255, 0.25);
            object-fit: cover;
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .ee-user-avatar:hover {
            transform: scale(1.05);
            border-color: rgba(255, 255, 255, 0.4);
        }

        .ee-user-status {
            position: absolute;
            bottom: 4px;
            right: 4px;
            width: 16px;
            height: 16px;
            background: #22c55e;
            border: 3px solid #312e81;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(34, 197, 94, 0.4);
        }

        .ee-user-info {
            width: 100%;
        }

        .ee-user-name {
            font-size: 1.125rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.25rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ee-user-role {
            font-size: 0.8125rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 0.75rem;
        }

        .ee-user-matricule {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            font-size: 0.6875rem;
            font-weight: 700;
            color: white;
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.9) 0%, rgba(217, 119, 6, 0.9) 100%);
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }

        .ee-user-matricule svg {
            width: 12px;
            height: 12px;
        }

        /* Navigation Sidebar */
        .ee-sidebar-nav {
            flex: 1;
            padding: 0.5rem 1rem;
            overflow-y: auto;
            position: relative;
            z-index: 1;
        }

        .ee-sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .ee-sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }

        .ee-sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
        }

        .ee-nav-section {
            margin-bottom: 1.5rem;
        }

        .ee-nav-title {
            font-size: 0.6875rem;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.4);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 0 0.875rem;
            margin-bottom: 0.625rem;
        }

        .ee-nav-link {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            padding: 0.875rem 1rem;
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-bottom: 0.25rem;
            position: relative;
            overflow: hidden;
        }

        .ee-nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 0;
            background: var(--ee-accent);
            border-radius: 0 3px 3px 0;
            transition: height 0.3s ease;
        }

        .ee-nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(4px);
        }

        .ee-nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .ee-nav-link.active::before {
            height: 60%;
        }

        .ee-nav-link svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            opacity: 0.85;
            transition: all 0.3s ease;
        }

        .ee-nav-link:hover svg,
        .ee-nav-link.active svg {
            opacity: 1;
            transform: scale(1.1);
        }

        .ee-nav-badge {
            margin-left: auto;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            font-size: 0.625rem;
            font-weight: 700;
            padding: 0.25rem 0.625rem;
            border-radius: 10px;
            min-width: 22px;
            text-align: center;
        }

        .ee-nav-badge.warning {
            background: var(--ee-warning);
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.4);
        }

        .ee-nav-badge.danger {
            background: var(--ee-danger);
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4);
        }

        /* Footer Sidebar */
        .ee-sidebar-footer {
            padding: 1.25rem 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            z-index: 1;
        }

        .ee-btn-portal {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.625rem;
            width: 100%;
            padding: 0.875rem;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            color: white;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-bottom: 0.625rem;
        }

        .ee-btn-portal:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        .ee-btn-portal svg {
            width: 18px;
            height: 18px;
        }

        .ee-btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.625rem;
            width: 100%;
            padding: 0.875rem;
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 12px;
            color: #fca5a5;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .ee-btn-logout:hover {
            background: rgba(239, 68, 68, 0.25);
            border-color: rgba(239, 68, 68, 0.5);
            color: white;
            transform: translateY(-2px);
        }

        .ee-btn-logout svg {
            width: 18px;
            height: 18px;
        }

        /* ==================== MAIN CONTENT ==================== */
        .ee-main {
            flex: 1;
            margin-left: var(--ee-sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: var(--ee-bg);
        }

        /* ==================== HEADER PREMIUM ==================== */
        .ee-header {
            background: var(--ee-glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--ee-border);
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .ee-header-left {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .ee-mobile-toggle {
            display: none;
            width: 44px;
            height: 44px;
            border: none;
            border-radius: 12px;
            background: var(--ee-bg-alt);
            color: var(--ee-text);
            cursor: pointer;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .ee-mobile-toggle:hover {
            background: var(--ee-primary-light);
            color: var(--ee-primary);
        }

        .ee-mobile-toggle svg {
            width: 24px;
            height: 24px;
        }

        .ee-page-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .ee-page-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--ee-text);
            letter-spacing: -0.5px;
        }

        .ee-breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8125rem;
            color: var(--ee-text-muted);
        }

        .ee-breadcrumb a {
            color: var(--ee-primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .ee-breadcrumb a:hover {
            color: var(--ee-primary-dark);
        }

        .ee-breadcrumb svg {
            width: 14px;
            height: 14px;
            opacity: 0.5;
        }

        .ee-header-right {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .ee-header-btn {
            position: relative;
            width: 44px;
            height: 44px;
            border: none;
            border-radius: 12px;
            background: var(--ee-bg-alt);
            color: var(--ee-text-muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .ee-header-btn:hover {
            background: var(--ee-primary-light);
            color: var(--ee-primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px var(--ee-shadow);
        }

        .ee-header-btn svg {
            width: 22px;
            height: 22px;
        }

        .ee-header-btn .badge {
            position: absolute;
            top: 4px;
            right: 4px;
            min-width: 18px;
            height: 18px;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            font-size: 0.625rem;
            font-weight: 700;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4);
            animation: pulse-badge 2s infinite;
        }

        @keyframes pulse-badge {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .ee-theme-toggle {
            width: 44px;
            height: 44px;
            border: none;
            border-radius: 12px;
            background: var(--ee-bg-alt);
            color: var(--ee-text-muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .ee-theme-toggle:hover {
            background: var(--ee-accent-light);
            color: var(--ee-accent);
            transform: translateY(-2px);
        }

        .ee-theme-toggle .sun-icon,
        .ee-theme-toggle .moon-icon {
            position: absolute;
            width: 22px;
            height: 22px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .ee-theme-toggle .sun-icon {
            opacity: 1;
            transform: rotate(0deg) scale(1);
        }

        .ee-theme-toggle .moon-icon {
            opacity: 0;
            transform: rotate(-90deg) scale(0.5);
        }

        .dark .ee-theme-toggle .sun-icon {
            opacity: 0;
            transform: rotate(90deg) scale(0.5);
        }

        .dark .ee-theme-toggle .moon-icon {
            opacity: 1;
            transform: rotate(0deg) scale(1);
        }

        /* ==================== CONTENT AREA ==================== */
        .ee-content {
            flex: 1;
            padding: 2rem;
            background: var(--ee-bg);
        }

        /* ==================== FOOTER ==================== */
        .ee-footer {
            padding: 1.5rem 2rem;
            background: var(--ee-card);
            border-top: 1px solid var(--ee-border);
            text-align: center;
        }

        .ee-footer-text {
            font-size: 0.8125rem;
            color: var(--ee-text-muted);
        }

        .ee-footer-link {
            color: var(--ee-primary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .ee-footer-link:hover {
            color: var(--ee-primary-dark);
        }

        /* ==================== OVERLAY MOBILE ==================== */
        .ee-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.6);
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
            .ee-sidebar {
                transform: translateX(-100%);
            }

            .ee-sidebar.open {
                transform: translateX(0);
            }

            .ee-main {
                margin-left: 0;
            }

            .ee-mobile-toggle {
                display: flex;
            }

            .ee-content {
                padding: 1.5rem;
            }
        }

        @media (max-width: 640px) {
            .ee-header {
                padding: 1rem;
            }

            .ee-content {
                padding: 1rem;
            }

            .ee-page-title {
                font-size: 1.25rem;
            }

            .ee-breadcrumb {
                display: none;
            }
        }

        /* ==================== ANIMATIONS ==================== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .animate-fade-in {
            animation: fadeInUp 0.5s ease forwards;
        }

        .animate-slide-left {
            animation: slideInLeft 0.4s ease forwards;
        }

        .animate-scale {
            animation: scaleIn 0.3s ease forwards;
        }

        /* ==================== SCROLLBAR CUSTOM ==================== */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--ee-bg-alt);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--ee-border);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--ee-text-light);
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="ee-layout">
        <!-- Overlay Mobile -->
        <div class="ee-overlay" id="eeOverlay" onclick="toggleSidebar()"></div>

        <!-- Sidebar Premium -->
        <aside class="ee-sidebar" id="eeSidebar">
            <div class="ee-sidebar-header">
                @php
                    $personnel = auth()->user()->personnel;
                @endphp
                <div class="ee-user-avatar-wrapper">
                    <img src="{{ $personnel && $personnel->photo ? asset('storage/' . $personnel->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&size=200&background=6366F1&color=fff&bold=true' }}"
                         alt="Photo"
                         class="ee-user-avatar"
                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&size=200&background=6366F1&color=fff&bold=true'">
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
                    <button class="ee-header-btn" title="Notifications">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                        <span class="badge">3</span>
                    </button>
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
    </script>
    @yield('scripts')
</body>
</html>
