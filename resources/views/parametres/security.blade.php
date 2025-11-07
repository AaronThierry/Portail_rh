@extends('layouts.app')

@section('title', 'Paramètres de Sécurité')

@section('content')
<div class="settings-layout">
    @include('parametres.partials.sidebar')

    <div class="settings-sidebar-overlay" id="settingsSidebarOverlay"></div>

    <main class="settings-content">
        <div class="settings-header">
            <h1 class="settings-title">Paramètres de Sécurité</h1>
            <p class="settings-description">Configuration de la sécurité et des accès</p>
        </div>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('parametres.security.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="settings-section">
                <div class="settings-section-header">
                    <div class="settings-section-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="settings-section-title">Sécurité de l'Application</h3>
                        <p class="settings-section-description">Gérer les paramètres de sécurité</p>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                    <div class="form-group">
                        <label for="session_lifetime" class="form-label required">Durée de session (minutes)</label>
                        <input type="number" id="session_lifetime" name="session_lifetime" class="form-input"
                               value="{{ old('session_lifetime', $settings['session_lifetime'] ?? 120) }}" min="1" max="1440" required>
                        @error('session_lifetime')
                        <div class="form-error show">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_expiry_days" class="form-label required">Expiration mot de passe (jours)</label>
                        <input type="number" id="password_expiry_days" name="password_expiry_days" class="form-input"
                               value="{{ old('password_expiry_days', $settings['password_expiry_days'] ?? 90) }}" min="0" max="365" required>
                        @error('password_expiry_days')
                        <div class="form-error show">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="max_login_attempts" class="form-label required">Tentatives de connexion max</label>
                        <input type="number" id="max_login_attempts" name="max_login_attempts" class="form-input"
                               value="{{ old('max_login_attempts', $settings['max_login_attempts'] ?? 5) }}" min="1" max="10" required>
                        @error('max_login_attempts')
                        <div class="form-error show">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="enable_2fa" value="1"
                                   {{ old('enable_2fa', $settings['enable_2fa'] ?? false) ? 'checked' : '' }}
                                   class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary">
                            <span class="form-label mb-0">Activer l'authentification à deux facteurs</span>
                        </label>
                    </div>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <a href="{{ route('parametres.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
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
