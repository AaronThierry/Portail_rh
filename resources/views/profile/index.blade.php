@extends('layouts.app')

@section('title', 'Mon Profil')
@section('page-title', 'Mon Profil')
@section('page-subtitle', 'Gérez vos informations personnelles et la sécurité de votre compte')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
    <circle cx="12" cy="7" r="4"></circle>
</svg>
@endsection

@section('content')
<div class="profile-page">
    <!-- Alerts -->
    @if(session('success'))
    <div class="alert alert-success">
        <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
        </svg>
        <span>{{ session('success') }}</span>
        <button type="button" class="alert-close" onclick="this.parentElement.remove()">×</button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-error">
        <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="15" y1="9" x2="9" y2="15"></line>
            <line x1="9" y1="9" x2="15" y2="15"></line>
        </svg>
        <span>{{ session('error') }}</span>
        <button type="button" class="alert-close" onclick="this.parentElement.remove()">×</button>
    </div>
    @endif
    @if($errors->any())
    <div class="alert alert-error">
        <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="15" y1="9" x2="9" y2="15"></line>
            <line x1="9" y1="9" x2="15" y2="15"></line>
        </svg>
        <div>@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>
    </div>
    @endif

    <!-- Profile Header Banner -->
    <div class="profile-banner">
        <div class="banner-bg"></div>
        <div class="banner-content">
            <div class="banner-avatar-section">
                <div class="banner-avatar-wrapper">
                    <img src="{{ $user->avatar ? asset(str_starts_with($user->avatar, 'storage/') ? $user->avatar : 'storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'User') . '&background=4A90D9&color=fff&bold=true&size=200' }}" alt="Avatar" class="banner-avatar" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name ?? 'User') }}&background=4A90D9&color=fff&bold=true&size=200'">
                    <span class="banner-status"></span>
                    <button type="button" class="banner-avatar-btn" onclick="document.getElementById('avatarInput').click()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                            <circle cx="12" cy="13" r="4"></circle>
                        </svg>
                    </button>
                </div>
                <div class="banner-info">
                    <h1 class="banner-name">{{ $user->name }}</h1>
                    <p class="banner-email">{{ $user->email }}</p>
                    <div class="banner-badges">
                        <span class="badge badge-role">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                            {{ $user->roles->first()->name ?? 'Utilisateur' }}
                        </span>
                        @if($user->google2fa_enabled)
                        <span class="badge badge-2fa">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            2FA Actif
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="banner-stats">
                <div class="banner-stat">
                    <span class="stat-number">{{ $user->created_at->format('d/m/Y') }}</span>
                    <span class="stat-text">Membre depuis</span>
                </div>
                <div class="banner-stat">
                    <span class="stat-number {{ $user->google2fa_enabled ? 'text-green' : 'text-orange' }}">{{ $user->google2fa_enabled ? 'Sécurisé' : 'Standard' }}</span>
                    <span class="stat-text">Niveau sécurité</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="profile-tabs">
        <button class="tab-btn active" data-tab="general">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            Général
        </button>
        <button class="tab-btn" data-tab="security">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
            Sécurité
        </button>
        <button class="tab-btn" data-tab="photo">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
            Photo
        </button>
    </div>

    <!-- Tab Contents -->
    <div class="tab-contents">
        <!-- General Tab -->
        <div class="tab-content active" id="tab-general">
            <div class="content-grid">
                <!-- Personal Info Card -->
                <div class="content-card">
                    <div class="card-icon blue">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </div>
                    <div class="card-body">
                        <h3>Informations personnelles</h3>
                        <p class="card-subtitle">Mettez à jour vos informations</p>
                        <form action="{{ route('admin.profile.update') }}" method="POST" class="compact-form">
                            @csrf
                            @method('PUT')
                            <div class="form-row">
                                <div class="form-field">
                                    <label>Nom complet</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                                </div>
                                <div class="form-field">
                                    <label>Email</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-field">
                                    <label>Téléphone</label>
                                    <input type="tel" name="telephone" value="{{ old('telephone', $user->telephone ?? '') }}" placeholder="+225 XX XX XX XX XX">
                                </div>
                            </div>
                            <button type="submit" class="btn-save">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                                Enregistrer
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Professional Info Card -->
                <div class="content-card compact">
                    <div class="card-icon purple">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div class="card-body">
                        <h3>Informations professionnelles</h3>
                        <div class="info-grid">
                            @if($user->entreprise)
                            <div class="info-row">
                                <span class="info-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M9 21V6a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v15M3 21V11a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v10M15 21V11a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v10"></path></svg></span>
                                <div><small>Entreprise</small><strong>{{ $user->entreprise->nom }}</strong></div>
                            </div>
                            @endif
                            @if($user->personnel?->departement)
                            <div class="info-row">
                                <span class="info-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg></span>
                                <div><small>Département</small><strong>{{ $user->personnel->departement->nom }}</strong></div>
                            </div>
                            @endif
                            @if($user->personnel?->service)
                            <div class="info-row">
                                <span class="info-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg></span>
                                <div><small>Service</small><strong>{{ $user->personnel->service->nom }}</strong></div>
                            </div>
                            @endif
                            @if(!$user->entreprise && !$user->personnel?->departement && !$user->personnel?->service)
                            <div class="info-empty">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                <span>Aucune information professionnelle</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Tab -->
        <div class="tab-content" id="tab-security">
            <div class="content-grid">
                <!-- 2FA Card -->
                <div class="content-card {{ $user->google2fa_enabled ? 'card-success' : 'card-warning' }}">
                    <div class="card-icon {{ $user->google2fa_enabled ? 'green' : 'orange' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>@if($user->google2fa_enabled)<polyline points="9 12 11 14 15 10"></polyline>@endif</svg>
                    </div>
                    <div class="card-body">
                        <div class="card-header-row">
                            <div>
                                <h3>Authentification à deux facteurs</h3>
                                <p class="card-subtitle">Sécurisez votre compte avec 2FA</p>
                            </div>
                            <span class="status-pill {{ $user->google2fa_enabled ? 'active' : 'inactive' }}">
                                <span class="status-dot"></span>
                                {{ $user->google2fa_enabled ? 'Activée' : 'Désactivée' }}
                            </span>
                        </div>

                        @if($user->google2fa_enabled)
                        <div class="security-info success">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                            <div>
                                <strong>Compte protégé</strong>
                                <p>Un code sera demandé à chaque connexion</p>
                                @if($user->google2fa_verified_at)
                                <small>Activée le {{ $user->google2fa_verified_at->format('d/m/Y à H:i') }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="features-list">
                            <div class="feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>Protection accès non autorisé</div>
                            <div class="feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>Codes temporaires automatiques</div>
                            <div class="feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>Compatible Google Authenticator, Authy</div>
                        </div>
                        <form action="{{ route('admin.two-factor.disable') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger" onclick="return confirm('Désactiver la 2FA rendra votre compte moins sécurisé. Continuer ?')">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><line x1="9" y1="9" x2="15" y2="15"></line><line x1="15" y1="9" x2="9" y2="15"></line></svg>
                                Désactiver 2FA
                            </button>
                        </form>
                        @else
                        <div class="security-info warning">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                            <div>
                                <strong>Compte non protégé</strong>
                                <p>Activez la 2FA pour plus de sécurité</p>
                            </div>
                        </div>
                        <div class="setup-steps">
                            <div class="step"><span>1</span><div><strong>Télécharger l'app</strong><small>Google Authenticator, Authy...</small></div></div>
                            <div class="step"><span>2</span><div><strong>Scanner le QR code</strong><small>Avec l'application</small></div></div>
                            <div class="step"><span>3</span><div><strong>Valider le code</strong><small>Entrer le code généré</small></div></div>
                        </div>
                        <form action="{{ route('admin.two-factor.enable') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-success">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><polyline points="9 12 11 14 15 10"></polyline></svg>
                                Activer 2FA
                            </button>
                        </form>
                        @endif
                    </div>
                </div>

                <!-- Password Card -->
                <div class="content-card">
                    <div class="card-icon orange">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    </div>
                    <div class="card-body">
                        <h3>Mot de passe</h3>
                        <p class="card-subtitle">Modifiez votre mot de passe</p>
                        <form action="{{ route('admin.profile.password') }}" method="POST" class="compact-form">
                            @csrf
                            @method('PUT')
                            <div class="form-field">
                                <label>Mot de passe actuel</label>
                                <div class="password-field">
                                    <input type="password" name="current_password" id="current_password" required>
                                    <button type="button" class="toggle-pwd" data-target="current_password"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></button>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-field">
                                    <label>Nouveau mot de passe</label>
                                    <div class="password-field">
                                        <input type="password" name="password" id="password" required minlength="8">
                                        <button type="button" class="toggle-pwd" data-target="password"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></button>
                                    </div>
                                    <div class="pwd-strength" id="pwdStrength"></div>
                                </div>
                                <div class="form-field">
                                    <label>Confirmer</label>
                                    <div class="password-field">
                                        <input type="password" name="password_confirmation" id="password_confirmation" required>
                                        <button type="button" class="toggle-pwd" data-target="password_confirmation"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></button>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn-warning">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                Modifier le mot de passe
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Photo Tab -->
        <div class="tab-content" id="tab-photo">
            <div class="content-grid single">
                <div class="content-card">
                    <div class="card-icon purple">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                    </div>
                    <div class="card-body">
                        <h3>Photo de profil</h3>
                        <p class="card-subtitle">Formats: JPG, PNG, GIF (max 2 Mo)</p>

                        <div class="avatar-section">
                            <div class="current-avatar">
                                <img src="{{ $user->avatar ? asset(str_starts_with($user->avatar, 'storage/') ? $user->avatar : 'storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'User') . '&background=4A90D9&color=fff&bold=true&size=200' }}" alt="Avatar" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name ?? 'User') }}&background=4A90D9&color=fff&bold=true&size=200'">
                                <div class="avatar-info">
                                    <span class="label">Photo actuelle</span>
                                    <span class="name">{{ $user->avatar ? basename($user->avatar) : 'Avatar par défaut' }}</span>
                                </div>
                            </div>

                            <form action="{{ route('admin.profile.avatar') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="upload-zone" id="uploadZone">
                                    <input type="file" name="avatar" id="avatarInput" accept="image/*" hidden>
                                    <div class="upload-content" id="uploadContent">
                                        <div class="upload-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                        </div>
                                        <span>Glissez ou <strong>cliquez</strong> pour sélectionner</span>
                                        <small>PNG, JPG ou GIF jusqu'à 2 Mo</small>
                                    </div>
                                    <img id="previewImg" class="preview-img" style="display:none;">
                                </div>
                                <div class="upload-actions">
                                    <button type="submit" class="btn-primary" id="uploadBtn" disabled>
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                        Envoyer
                                    </button>
                                    @if($user->avatar)
                                    <form action="{{ route('admin.profile.avatar.delete') }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-outline-danger" onclick="return confirm('Supprimer la photo ?')">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                            Supprimer
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ==================== PROFILE PAGE PRO DESIGN ==================== */
:root {
    --primary: #4A90D9;
    --primary-dark: #2E6BB3;
    --success: #22C55E;
    --warning: #F59E0B;
    --danger: #EF4444;
    --purple: #8B5CF6;
    --teal: #14B8A6;
}

.profile-page { animation: fadeIn 0.3s ease; }
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

/* Alerts */
.alert {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 0.875rem;
    border-radius: 8px;
    margin-bottom: 0.75rem;
    font-size: 0.8125rem;
}
.alert-icon { width: 18px; height: 18px; flex-shrink: 0; }
.alert-close { margin-left: auto; background: none; border: none; cursor: pointer; font-size: 1.25rem; opacity: 0.6; }
.alert-close:hover { opacity: 1; }
.alert-success { background: #D1FAE5; color: #065F46; border: 1px solid #6EE7B7; }
.alert-error { background: #FEE2E2; color: #991B1B; border: 1px solid #FCA5A5; }

/* Profile Banner */
.profile-banner {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 0.75rem;
    background: var(--card-bg, #fff);
    border: 1px solid var(--sidebar-border, #E8ECF0);
}
.banner-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 80px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
}
.banner-bg::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M20 20.5V18H0v-2h20v-2l4 3.25-4 3.25zM0 20h2v20H0V20zm4 0h2v20H4V20z'/%3E%3C/g%3E%3C/svg%3E");
}
.banner-content {
    position: relative;
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    padding: 0 1.25rem 1rem;
    padding-top: 45px;
}
.banner-avatar-section { display: flex; align-items: flex-end; gap: 1rem; }
.banner-avatar-wrapper { position: relative; }
.banner-avatar {
    width: 90px;
    height: 90px;
    border-radius: 16px;
    object-fit: cover;
    border: 4px solid white;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
}
.banner-status {
    position: absolute;
    bottom: 6px;
    right: 6px;
    width: 14px;
    height: 14px;
    background: var(--success);
    border: 3px solid white;
    border-radius: 50%;
}
.banner-avatar-btn {
    position: absolute;
    bottom: -4px;
    left: -4px;
    width: 28px;
    height: 28px;
    background: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    color: var(--primary);
    transition: all 0.2s;
}
.banner-avatar-btn:hover { background: var(--primary); color: white; transform: scale(1.1); }
.banner-avatar-btn svg { width: 14px; height: 14px; }
.banner-info { padding-bottom: 0.5rem; }
.banner-name { font-size: 1.25rem; font-weight: 700; color: var(--text-primary, #1F2937); margin: 0; }
.banner-email { font-size: 0.8125rem; color: var(--text-muted, #6B7280); margin: 0.125rem 0 0.5rem; }
.banner-badges { display: flex; gap: 0.375rem; }
.badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.625rem;
    font-size: 0.6875rem;
    font-weight: 600;
    border-radius: 12px;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}
.badge svg { width: 11px; height: 11px; }
.badge-role { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; }
.badge-2fa { background: linear-gradient(135deg, var(--success), #16A34A); color: white; }
.banner-stats { display: flex; gap: 1.5rem; padding-bottom: 0.5rem; }
.banner-stat { text-align: right; }
.stat-number { display: block; font-size: 0.9375rem; font-weight: 700; color: var(--text-primary, #1F2937); }
.stat-text { font-size: 0.6875rem; color: var(--text-muted, #6B7280); text-transform: uppercase; letter-spacing: 0.3px; }
.text-green { color: var(--success) !important; }
.text-orange { color: var(--warning) !important; }

/* Tabs */
.profile-tabs {
    display: flex;
    gap: 0.25rem;
    background: var(--card-bg, #fff);
    padding: 0.375rem;
    border-radius: 12px;
    border: 1px solid var(--sidebar-border, #E8ECF0);
    margin-bottom: 0.75rem;
}
.tab-btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.375rem;
    padding: 0.5rem 0.75rem;
    background: transparent;
    border: none;
    border-radius: 8px;
    font-size: 0.8125rem;
    font-weight: 500;
    color: var(--text-muted, #6B7280);
    cursor: pointer;
    transition: all 0.2s;
}
.tab-btn svg { width: 16px; height: 16px; }
.tab-btn:hover { background: var(--sidebar-hover, #F3F4F6); color: var(--text-primary, #374151); }
.tab-btn.active { background: var(--primary); color: white; box-shadow: 0 2px 8px rgba(74,144,217,0.3); }

/* Tab Contents */
.tab-content { display: none; animation: fadeIn 0.3s ease; }
.tab-content.active { display: block; }
.content-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.75rem; }
.content-grid.single { grid-template-columns: 1fr; max-width: 600px; }
@media (max-width: 900px) { .content-grid { grid-template-columns: 1fr; } }

/* Content Cards */
.content-card {
    background: var(--card-bg, #fff);
    border-radius: 14px;
    padding: 1rem;
    border: 1px solid var(--sidebar-border, #E8ECF0);
    display: flex;
    gap: 0.875rem;
    transition: box-shadow 0.2s;
}
.content-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.06); }
.content-card.compact { flex-direction: column; }
.content-card.compact .card-icon { align-self: flex-start; }
.content-card.card-success { border-color: rgba(34,197,94,0.3); background: linear-gradient(135deg, rgba(34,197,94,0.02) 0%, transparent 100%); }
.content-card.card-warning { border-color: rgba(245,158,11,0.3); background: linear-gradient(135deg, rgba(245,158,11,0.02) 0%, transparent 100%); }
.card-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.card-icon svg { width: 18px; height: 18px; }
.card-icon.blue { background: rgba(74,144,217,0.1); color: var(--primary); }
.card-icon.purple { background: rgba(139,92,246,0.1); color: var(--purple); }
.card-icon.green { background: rgba(34,197,94,0.1); color: var(--success); }
.card-icon.orange { background: rgba(245,158,11,0.1); color: var(--warning); }
.card-body { flex: 1; min-width: 0; }
.card-body h3 { font-size: 0.9375rem; font-weight: 700; color: var(--text-primary, #1F2937); margin: 0; }
.card-subtitle { font-size: 0.75rem; color: var(--text-muted, #6B7280); margin: 0.125rem 0 0.75rem; }
.card-header-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem; }
.card-header-row > div h3 { margin-bottom: 0.125rem; }

/* Status Pill */
.status-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.5rem;
    font-size: 0.6875rem;
    font-weight: 600;
    border-radius: 20px;
}
.status-dot { width: 6px; height: 6px; border-radius: 50%; }
.status-pill.active { background: rgba(34,197,94,0.1); color: #16A34A; }
.status-pill.active .status-dot { background: var(--success); animation: pulse 2s infinite; }
.status-pill.inactive { background: rgba(245,158,11,0.1); color: #D97706; }
.status-pill.inactive .status-dot { background: var(--warning); }
@keyframes pulse { 0%,100% { box-shadow: 0 0 0 0 rgba(34,197,94,0.4); } 50% { box-shadow: 0 0 0 4px rgba(34,197,94,0.1); } }

/* Security Info Box */
.security-info {
    display: flex;
    gap: 0.625rem;
    padding: 0.625rem;
    border-radius: 10px;
    margin-bottom: 0.75rem;
}
.security-info svg { width: 20px; height: 20px; flex-shrink: 0; margin-top: 0.125rem; }
.security-info strong { display: block; font-size: 0.8125rem; margin-bottom: 0.125rem; }
.security-info p { font-size: 0.75rem; margin: 0; opacity: 0.9; }
.security-info small { font-size: 0.6875rem; opacity: 0.7; margin-top: 0.25rem; display: block; }
.security-info.success { background: rgba(34,197,94,0.1); color: #065F46; }
.security-info.warning { background: rgba(245,158,11,0.1); color: #92400E; }

/* Features List */
.features-list { margin-bottom: 0.75rem; }
.feature {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.375rem 0;
    font-size: 0.75rem;
    color: var(--text-primary, #374151);
}
.feature svg { width: 14px; height: 14px; color: var(--success); }

/* Setup Steps */
.setup-steps { display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 0.75rem; }
.step {
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
}
.step span:first-child {
    width: 20px;
    height: 20px;
    background: var(--primary);
    color: white;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.6875rem;
    font-weight: 700;
    flex-shrink: 0;
}
.step strong { display: block; font-size: 0.8125rem; color: var(--text-primary, #1F2937); }
.step small { font-size: 0.6875rem; color: var(--text-muted, #6B7280); }

/* Info Grid */
.info-grid { display: flex; flex-direction: column; gap: 0.5rem; }
.info-row {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    padding: 0.5rem;
    background: var(--sidebar-hover, #F8FAFC);
    border-radius: 8px;
}
.info-row .info-icon {
    width: 28px;
    height: 28px;
    background: white;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}
.info-row .info-icon svg { width: 14px; height: 14px; }
.info-row small { display: block; font-size: 0.625rem; color: var(--text-muted, #6B7280); text-transform: uppercase; letter-spacing: 0.3px; }
.info-row strong { display: block; font-size: 0.8125rem; color: var(--text-primary, #1F2937); }
.info-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 1.5rem;
    color: var(--text-muted, #6B7280);
    text-align: center;
}
.info-empty svg { width: 32px; height: 32px; margin-bottom: 0.5rem; opacity: 0.5; }
.info-empty span { font-size: 0.8125rem; }

/* Forms */
.compact-form { margin-top: 0.5rem; }
.form-row { display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.625rem; margin-bottom: 0.625rem; }
@media (max-width: 500px) { .form-row { grid-template-columns: 1fr; } }
.form-field { margin-bottom: 0.625rem; }
.form-field label { display: block; font-size: 0.75rem; font-weight: 600; color: var(--text-primary, #374151); margin-bottom: 0.25rem; }
.form-field input {
    width: 100%;
    padding: 0.5rem 0.625rem;
    border: 1px solid var(--sidebar-border, #E8ECF0);
    border-radius: 8px;
    font-size: 0.8125rem;
    color: var(--text-primary, #1F2937);
    background: var(--card-bg, #fff);
    transition: all 0.2s;
}
.form-field input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(74,144,217,0.1); }
.password-field { position: relative; }
.password-field input { padding-right: 2.25rem; }
.toggle-pwd {
    position: absolute;
    right: 0.5rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: var(--text-muted, #9CA3AF);
    padding: 0.25rem;
}
.toggle-pwd:hover { color: var(--primary); }
.toggle-pwd svg { width: 16px; height: 16px; }
.pwd-strength { height: 3px; border-radius: 2px; margin-top: 0.375rem; background: var(--sidebar-border, #E8ECF0); overflow: hidden; }

/* Buttons */
.btn-save, .btn-primary, .btn-success, .btn-warning, .btn-danger, .btn-outline-danger {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.375rem;
    padding: 0.5rem 1rem;
    font-size: 0.8125rem;
    font-weight: 600;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-save svg, .btn-primary svg, .btn-success svg, .btn-warning svg, .btn-danger svg, .btn-outline-danger svg { width: 14px; height: 14px; }
.btn-save, .btn-primary { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; box-shadow: 0 2px 8px rgba(74,144,217,0.3); }
.btn-save:hover, .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(74,144,217,0.35); }
.btn-success { background: linear-gradient(135deg, var(--success), #16A34A); color: white; box-shadow: 0 2px 8px rgba(34,197,94,0.3); }
.btn-success:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(34,197,94,0.35); }
.btn-warning { background: linear-gradient(135deg, var(--warning), #D97706); color: white; box-shadow: 0 2px 8px rgba(245,158,11,0.3); }
.btn-warning:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(245,158,11,0.35); }
.btn-danger, .btn-outline-danger { background: transparent; border: 1px solid var(--danger); color: var(--danger); }
.btn-danger:hover, .btn-outline-danger:hover { background: var(--danger); color: white; box-shadow: 0 2px 8px rgba(239,68,68,0.3); }

/* Avatar Section */
.avatar-section { margin-top: 0.75rem; }
.current-avatar {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.625rem;
    background: var(--sidebar-hover, #F8FAFC);
    border-radius: 10px;
    margin-bottom: 0.75rem;
}
.current-avatar img { width: 48px; height: 48px; border-radius: 10px; object-fit: cover; border: 2px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
.avatar-info .label { display: block; font-size: 0.625rem; color: var(--text-muted, #6B7280); text-transform: uppercase; letter-spacing: 0.3px; }
.avatar-info .name { display: block; font-size: 0.8125rem; font-weight: 600; color: var(--text-primary, #1F2937); }
.upload-zone {
    border: 2px dashed var(--sidebar-border, #E8ECF0);
    border-radius: 12px;
    padding: 1.25rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
    background: var(--sidebar-hover, #F8FAFC);
    margin-bottom: 0.75rem;
}
.upload-zone:hover, .upload-zone.dragover { border-color: var(--primary); background: rgba(74,144,217,0.05); }
.upload-icon { width: 36px; height: 36px; margin: 0 auto 0.5rem; background: white; border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 6px rgba(0,0,0,0.06); }
.upload-icon svg { width: 18px; height: 18px; color: var(--primary); }
.upload-content span { display: block; font-size: 0.8125rem; color: var(--text-primary, #374151); }
.upload-content span strong { color: var(--primary); }
.upload-content small { display: block; font-size: 0.6875rem; color: var(--text-muted, #6B7280); margin-top: 0.25rem; }
.preview-img { max-width: 150px; max-height: 150px; border-radius: 10px; margin: 0 auto; }
.upload-actions { display: flex; gap: 0.5rem; }

/* Dark Mode */
.dark .profile-banner, .dark .profile-tabs, .dark .content-card { background: var(--card-bg); border-color: var(--sidebar-border); }
.dark .banner-name, .dark .card-body h3, .dark .form-field label, .dark .info-row strong, .dark .step strong { color: #F9FAFB; }
.dark .form-field input { background: var(--sidebar-hover); border-color: var(--sidebar-border); color: #F9FAFB; }
.dark .tab-btn { color: #9CA3AF; }
.dark .tab-btn:hover { background: rgba(255,255,255,0.05); color: #E5E7EB; }
.dark .tab-btn.active { background: var(--primary); color: white; }
.dark .info-row { background: var(--sidebar-hover); }
.dark .info-row .info-icon { background: var(--card-bg); }
.dark .current-avatar { background: var(--sidebar-hover); }
.dark .upload-zone { background: var(--sidebar-hover); border-color: var(--sidebar-border); }
.dark .upload-zone:hover { background: rgba(74,144,217,0.1); }
.dark .upload-icon { background: var(--card-bg); }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab Navigation
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('tab-' + btn.dataset.tab).classList.add('active');
        });
    });

    // Avatar Upload
    const uploadZone = document.getElementById('uploadZone');
    const avatarInput = document.getElementById('avatarInput');
    const previewImg = document.getElementById('previewImg');
    const uploadContent = document.getElementById('uploadContent');
    const uploadBtn = document.getElementById('uploadBtn');

    if (uploadZone) {
        uploadZone.addEventListener('click', () => avatarInput.click());
        uploadZone.addEventListener('dragover', e => { e.preventDefault(); uploadZone.classList.add('dragover'); });
        uploadZone.addEventListener('dragleave', () => uploadZone.classList.remove('dragover'));
        uploadZone.addEventListener('drop', e => {
            e.preventDefault();
            uploadZone.classList.remove('dragover');
            if (e.dataTransfer.files.length) {
                avatarInput.files = e.dataTransfer.files;
                handlePreview(e.dataTransfer.files[0]);
            }
        });
        avatarInput.addEventListener('change', e => {
            if (e.target.files.length) handlePreview(e.target.files[0]);
        });
    }

    function handlePreview(file) {
        if (!file.type.startsWith('image/')) return alert('Veuillez sélectionner une image');
        if (file.size > 2 * 1024 * 1024) return alert('Image trop volumineuse (max 2 Mo)');
        const reader = new FileReader();
        reader.onload = e => {
            previewImg.src = e.target.result;
            previewImg.style.display = 'block';
            uploadContent.style.display = 'none';
            uploadBtn.disabled = false;
        };
        reader.readAsDataURL(file);
    }

    // Password Toggle
    document.querySelectorAll('.toggle-pwd').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = document.getElementById(btn.dataset.target);
            input.type = input.type === 'password' ? 'text' : 'password';
        });
    });

    // Password Strength
    const pwdInput = document.getElementById('password');
    const pwdStrength = document.getElementById('pwdStrength');
    if (pwdInput && pwdStrength) {
        pwdInput.addEventListener('input', () => {
            const pwd = pwdInput.value;
            let strength = 0;
            if (pwd.length >= 8) strength++;
            if (/[a-z]/.test(pwd)) strength++;
            if (/[A-Z]/.test(pwd)) strength++;
            if (/[0-9]/.test(pwd)) strength++;
            if (/[^a-zA-Z0-9]/.test(pwd)) strength++;
            const colors = ['#EF4444', '#F97316', '#EAB308', '#22C55E', '#22C55E'];
            const widths = ['20%', '40%', '60%', '80%', '100%'];
            pwdStrength.style.background = pwd.length ? `linear-gradient(to right, ${colors[strength-1]} ${widths[strength-1]}, var(--sidebar-border, #E8ECF0) ${widths[strength-1]})` : 'var(--sidebar-border, #E8ECF0)';
        });
    }

    // Auto-dismiss alerts
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
});
</script>
@endsection
