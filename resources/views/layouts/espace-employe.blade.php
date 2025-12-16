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
            --ee-primary: #6366F1;
            --ee-primary-dark: #4F46E5;
            --ee-primary-light: #EEF2FF;
            --ee-secondary: #8B5CF6;
            --ee-accent: #F59E0B;
            --ee-success: #10B981;
            --ee-danger: #EF4444;
            --ee-warning: #F59E0B;
            --ee-info: #3B82F6;
            --ee-text: #1F2937;
            --ee-text-muted: #6B7280;
            --ee-text-light: #9CA3AF;
            --ee-bg: #F9FAFB;
            --ee-bg-alt: #F3F4F6;
            --ee-card: #FFFFFF;
            --ee-border: #E5E7EB;
            --ee-shadow: rgba(99, 102, 241, 0.1);
            --ee-gradient-start: #6366F1;
            --ee-gradient-end: #8B5CF6;
        }

        .dark {
            --ee-bg: #111827;
            --ee-bg-alt: #1F2937;
            --ee-card: #1F2937;
            --ee-text: #F9FAFB;
            --ee-text-muted: #9CA3AF;
            --ee-text-light: #6B7280;
            --ee-border: #374151;
            --ee-shadow: rgba(0, 0, 0, 0.3);
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
        }

        /* ==================== ESPACE EMPLOYE LAYOUT ==================== */
        .ee-layout {
            display: flex;
            min-height: 100vh;
        }

        /* ==================== SIDEBAR EMPLOYE ==================== */
        .ee-sidebar {
            width: 280px;
            background: linear-gradient(180deg, var(--ee-gradient-start) 0%, var(--ee-gradient-end) 100%);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
        }

        .ee-sidebar-header {
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .ee-user-avatar {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            border: 3px solid rgba(255, 255, 255, 0.3);
            object-fit: cover;
            background: rgba(255, 255, 255, 0.1);
        }

        .ee-user-info {
            flex: 1;
            min-width: 0;
        }

        .ee-user-name {
            font-size: 1rem;
            font-weight: 700;
            color: white;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ee-user-role {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.8);
            margin-top: 0.25rem;
        }

        .ee-user-matricule {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.625rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
            background: rgba(255, 255, 255, 0.2);
            padding: 0.25rem 0.5rem;
            border-radius: 20px;
            margin-top: 0.5rem;
        }

        .ee-sidebar-nav {
            flex: 1;
            padding: 1rem;
            overflow-y: auto;
        }

        .ee-nav-section {
            margin-bottom: 1.5rem;
        }

        .ee-nav-title {
            font-size: 0.625rem;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.5);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 0 0.75rem;
            margin-bottom: 0.75rem;
        }

        .ee-nav-link {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            padding: 0.875rem 1rem;
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.25s ease;
            margin-bottom: 0.25rem;
        }

        .ee-nav-link:hover {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            transform: translateX(4px);
        }

        .ee-nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .ee-nav-link svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        .ee-nav-badge {
            margin-left: auto;
            background: rgba(255, 255, 255, 0.25);
            color: white;
            font-size: 0.625rem;
            font-weight: 700;
            padding: 0.25rem 0.5rem;
            border-radius: 10px;
        }

        .ee-nav-badge.warning {
            background: var(--ee-warning);
        }

        .ee-nav-badge.danger {
            background: var(--ee-danger);
        }

        .ee-sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .ee-btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.875rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: white;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .ee-btn-logout:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .ee-btn-logout svg {
            width: 18px;
            height: 18px;
        }

        /* ==================== MAIN CONTENT ==================== */
        .ee-main {
            flex: 1;
            margin-left: 280px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ==================== HEADER ==================== */
        .ee-header {
            background: var(--ee-card);
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
            gap: 1rem;
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
        }

        .ee-mobile-toggle svg {
            width: 24px;
            height: 24px;
        }

        .ee-page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--ee-text);
        }

        .ee-breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--ee-text-muted);
        }

        .ee-breadcrumb a {
            color: var(--ee-primary);
            text-decoration: none;
        }

        .ee-breadcrumb a:hover {
            text-decoration: underline;
        }

        .ee-header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
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
            transition: all 0.25s ease;
        }

        .ee-header-btn:hover {
            background: var(--ee-primary-light);
            color: var(--ee-primary);
        }

        .ee-header-btn svg {
            width: 22px;
            height: 22px;
        }

        .ee-header-btn .badge {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 18px;
            height: 18px;
            background: var(--ee-danger);
            color: white;
            font-size: 0.625rem;
            font-weight: 700;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
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
            transition: all 0.25s ease;
        }

        .ee-theme-toggle:hover {
            background: var(--ee-primary-light);
            color: var(--ee-primary);
        }

        /* ==================== CONTENT AREA ==================== */
        .ee-content {
            flex: 1;
            padding: 2rem;
        }

        /* ==================== FOOTER ==================== */
        .ee-footer {
            padding: 1.5rem 2rem;
            background: var(--ee-card);
            border-top: 1px solid var(--ee-border);
            text-align: center;
        }

        .ee-footer-text {
            font-size: 0.875rem;
            color: var(--ee-text-muted);
        }

        .ee-footer-link {
            color: var(--ee-primary);
            text-decoration: none;
        }

        .ee-footer-link:hover {
            text-decoration: underline;
        }

        /* ==================== OVERLAY MOBILE ==================== */
        .ee-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
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
        }

        /* ==================== ANIMATIONS ==================== */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.4s ease forwards;
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .animate-slide-left {
            animation: slideInLeft 0.4s ease forwards;
        }

        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        .animate-scale {
            animation: scaleIn 0.3s ease forwards;
        }
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
                <img src="{{ $personnel ? $personnel->photo_url : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&size=200&background=6366F1&color=fff' }}"
                     alt="Photo"
                     class="ee-user-avatar">
                <div class="ee-user-info">
                    <div class="ee-user-name">{{ $personnel ? $personnel->nom_complet : auth()->user()->name }}</div>
                    <div class="ee-user-role">{{ $personnel ? $personnel->poste : 'Employé' }}</div>
                    @if($personnel && $personnel->matricule)
                        <span class="ee-user-matricule">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
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
                <!-- Navigation Principale -->
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
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        Mes Documents
                        @if(isset($documentsCount) && $documentsCount > 0)
                            <span class="ee-nav-badge">{{ $documentsCount }}</span>
                        @endif
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
                        Congés & Absences
                        @if(isset($congesPending) && $congesPending > 0)
                            <span class="ee-nav-badge warning">{{ $congesPending }}</span>
                        @endif
                    </a>
                    <a href="{{ route('espace-employe.demandes') }}" class="ee-nav-link {{ request()->routeIs('espace-employe.demandes') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                        Mes Demandes
                    </a>
                </div>

                <!-- Paramètres -->
                <div class="ee-nav-section">
                    <div class="ee-nav-title">Paramètres</div>
                    <a href="{{ route('espace-employe.parametres') }}" class="ee-nav-link {{ request()->routeIs('espace-employe.parametres') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                        </svg>
                        Paramètres
                    </a>
                </div>
            </nav>

            <div class="ee-sidebar-footer">
                <a href="{{ route('dashboard') }}" class="ee-btn-logout" style="margin-bottom: 0.5rem; background: rgba(255,255,255,0.05);">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 19l-7-7 7-7"></path>
                    </svg>
                    Portail RH
                </a>
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="ee-btn-logout">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="ee-main">
            <!-- Header -->
            <header class="ee-header">
                <div class="ee-header-left">
                    <button class="ee-mobile-toggle" onclick="toggleSidebar()">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </button>
                    <div>
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
                    <button class="ee-theme-toggle" onclick="toggleTheme()" title="Changer le thème">
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
                    &copy; {{ date('Y') }} <a href="{{ route('dashboard') }}" class="ee-footer-link">Portail RH</a> - Tous droits réservés
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
        }

        function toggleTheme() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
        }

        // Load saved theme
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>
    @yield('scripts')
</body>
</html>
