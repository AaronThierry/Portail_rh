@extends('layouts.app')

@section('title', 'Paramètres Système')

@section('content')
<div class="settings-layout">
    @include('parametres.partials.sidebar')

    <div class="settings-sidebar-overlay" id="settingsSidebarOverlay"></div>

    <main class="settings-content">
        <div class="settings-header">
            <h1 class="settings-title">Paramètres Système</h1>
            <p class="settings-description">Configuration système (Super Admin uniquement)</p>
        </div>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- System Information -->
        <div class="settings-section">
            <div class="settings-section-header">
                <div class="settings-section-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                        <line x1="8" y1="21" x2="16" y2="21"></line>
                        <line x1="12" y1="17" x2="12" y2="21"></line>
                    </svg>
                </div>
                <div>
                    <h3 class="settings-section-title">Informations Système</h3>
                    <p class="settings-section-description">Détails sur l'environnement</p>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                <div style="padding: 16px; background: var(--bg-tertiary); border-radius: 10px;">
                    <p style="color: var(--text-muted); font-size: 0.875rem; margin-bottom: 4px;">Version PHP</p>
                    <p style="color: var(--text-primary); font-weight: 600; font-size: 1.125rem;">{{ $systemInfo['php_version'] }}</p>
                </div>

                <div style="padding: 16px; background: var(--bg-tertiary); border-radius: 10px;">
                    <p style="color: var(--text-muted); font-size: 0.875rem; margin-bottom: 4px;">Version Laravel</p>
                    <p style="color: var(--text-primary); font-weight: 600; font-size: 1.125rem;">{{ $systemInfo['laravel_version'] }}</p>
                </div>

                <div style="padding: 16px; background: var(--bg-tertiary); border-radius: 10px;">
                    <p style="color: var(--text-muted); font-size: 0.875rem; margin-bottom: 4px;">Base de données</p>
                    <p style="color: var(--text-primary); font-weight: 600; font-size: 1.125rem;">{{ $systemInfo['database'] }}</p>
                </div>

                <div style="padding: 16px; background: var(--bg-tertiary); border-radius: 10px;">
                    <p style="color: var(--text-muted); font-size: 0.875rem; margin-bottom: 4px;">Driver Cache</p>
                    <p style="color: var(--text-primary); font-weight: 600; font-size: 1.125rem;">{{ $systemInfo['cache_driver'] }}</p>
                </div>

                <div style="padding: 16px; background: var(--bg-tertiary); border-radius: 10px;">
                    <p style="color: var(--text-muted); font-size: 0.875rem; margin-bottom: 4px;">Driver Queue</p>
                    <p style="color: var(--text-primary); font-weight: 600; font-size: 1.125rem;">{{ $systemInfo['queue_driver'] }}</p>
                </div>

                <div style="padding: 16px; background: var(--bg-tertiary); border-radius: 10px;">
                    <p style="color: var(--text-muted); font-size: 0.875rem; margin-bottom: 4px;">Driver Mail</p>
                    <p style="color: var(--text-primary); font-weight: 600; font-size: 1.125rem;">{{ $systemInfo['mail_driver'] }}</p>
                </div>
            </div>
        </div>

        <!-- System Actions -->
        <div class="settings-section">
            <div class="settings-section-header">
                <div class="settings-section-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="1 4 1 10 7 10"></polyline>
                        <polyline points="23 20 23 14 17 14"></polyline>
                        <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="settings-section-title">Actions Système</h3>
                    <p class="settings-section-description">Maintenance et optimisation</p>
                </div>
            </div>

            <div style="display: grid; gap: 16px;">
                <form action="{{ route('parametres.cache.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <div class="flex items-center gap-3">
                            <div style="width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-center; color: white;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                            </div>
                            <div class="text-left">
                                <span class="font-semibold text-gray-900 dark:text-white block">Vider le cache</span>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Effacer tous les caches de l'application</p>
                            </div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </main>

    <button class="settings-mobile-toggle" id="settingsMobileToggle">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="3"></circle>
            <path d="M12 1v6m0 6v6m0-6h6m-6 0H6"></path>
        </svg>
    </button>
</div>

<link rel="stylesheet" href="{{ asset('assets/css/settings.css') }}">
@endsection
