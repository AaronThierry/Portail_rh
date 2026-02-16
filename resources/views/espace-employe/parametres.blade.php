@extends('layouts.espace-employe')

@section('title', 'Paramètres')
@section('page-title', 'Paramètres')
@section('breadcrumb')
    <a href="{{ route('espace-employe.dashboard') }}">Accueil</a>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
    <span>Paramètres</span>
@endsection

@section('styles')
<style>
.ee-parametres-page {
    display: flex;
    flex-direction: column;
    gap: 2rem;
    max-width: 900px;
}

/* Alert Messages */
.ee-alert {
    padding: 1rem 1.25rem;
    border-radius: var(--e-radius);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.ee-alert.success {
    background: var(--e-emerald-pale);
    border: 1px solid var(--e-emerald);
    color: var(--e-emerald);
}

.ee-alert.error {
    background: var(--e-red-pale);
    border: 1px solid var(--e-red);
    color: var(--e-red);
}

.ee-alert svg {
    width: 22px;
    height: 22px;
    flex-shrink: 0;
}

/* Settings Card */
.ee-settings-card {
    background: var(--e-surface);
    border-radius: var(--e-radius-xl);
    border: 1px solid var(--e-border);
    overflow: hidden;
    border-top: 3px solid var(--e-blue);
}

.ee-settings-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    border-bottom: 1px solid var(--e-border);
}

.ee-settings-icon {
    width: 48px;
    height: 48px;
    border-radius: var(--e-radius);
    display: flex;
    align-items: center;
    justify-content: center;
}

.ee-settings-icon svg {
    width: 24px;
    height: 24px;
}

.ee-settings-icon.blue {
    background: var(--e-blue-wash);
    color: var(--e-blue);
}

.ee-settings-icon.purple {
    background: rgba(124, 58, 237, 0.08);
    color: #7c3aed;
}

.ee-settings-icon.green {
    background: var(--e-emerald-pale);
    color: var(--e-emerald);
}

.ee-settings-icon.orange {
    background: var(--e-amber-wash);
    color: var(--e-amber);
}

.ee-settings-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--e-text);
}

.ee-settings-subtitle {
    font-size: 0.8125rem;
    font-weight: 600;
    color: var(--e-text-secondary);
    margin-top: 0.25rem;
}

.ee-settings-body {
    padding: 1.5rem;
}

/* Form Group */
.ee-form-group {
    margin-bottom: 1.5rem;
}

.ee-form-group:last-child {
    margin-bottom: 0;
}

.ee-form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--e-text);
    margin-bottom: 0.5rem;
}

.ee-form-input {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid var(--e-border);
    border-radius: var(--e-radius);
    font-size: 1rem;
    color: var(--e-text);
    background: var(--e-surface);
    transition: all 0.25s ease;
}

.ee-form-input:focus {
    outline: none;
    border-color: var(--e-blue);
    box-shadow: 0 0 0 4px var(--e-blue-wash);
}

.ee-form-input::placeholder {
    color: var(--e-text-tertiary);
}

.ee-form-input:disabled {
    background: var(--e-bg);
    cursor: not-allowed;
}

.ee-form-hint {
    font-size: 0.75rem;
    color: var(--e-text-secondary);
    margin-top: 0.375rem;
}

/* Form Row */
.ee-form-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

/* Submit Button */
.ee-submit-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    width: 100%;
    padding: 1rem;
    background: var(--e-blue);
    color: white;
    border: none;
    border-radius: var(--e-radius);
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 1rem;
}

.ee-submit-btn:hover {
    transform: translateY(-2px);
    background: var(--e-blue-deep);
    box-shadow: var(--e-shadow-md);
}

.ee-submit-btn svg {
    width: 20px;
    height: 20px;
}

/* Toggle Switch */
.ee-toggle-group {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 0;
    border-bottom: 1px solid var(--e-border);
}

.ee-toggle-group:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.ee-toggle-info {
    flex: 1;
}

.ee-toggle-label {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--e-text);
}

.ee-toggle-desc {
    font-size: 0.8125rem;
    color: var(--e-text-secondary);
    margin-top: 0.25rem;
}

.ee-toggle {
    position: relative;
    width: 52px;
    height: 28px;
    flex-shrink: 0;
}

.ee-toggle input {
    opacity: 0;
    width: 0;
    height: 0;
}

.ee-toggle-slider {
    position: absolute;
    cursor: pointer;
    inset: 0;
    background: var(--e-border);
    border-radius: 28px;
    transition: all 0.3s ease;
}

.ee-toggle-slider::before {
    content: '';
    position: absolute;
    width: 22px;
    height: 22px;
    left: 3px;
    top: 3px;
    background: white;
    border-radius: 50%;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.ee-toggle input:checked + .ee-toggle-slider {
    background: var(--e-blue);
}

.ee-toggle input:checked + .ee-toggle-slider::before {
    transform: translateX(24px);
}

/* Info Section */
.ee-info-section {
    background: var(--e-bg);
    border-radius: var(--e-radius);
    padding: 1rem;
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.ee-info-section svg {
    width: 20px;
    height: 20px;
    color: var(--e-blue);
    flex-shrink: 0;
    margin-top: 0.125rem;
}

.ee-info-section p {
    font-size: 0.875rem;
    color: var(--e-text-secondary);
    line-height: 1.5;
}

/* Responsive */
@media (max-width: 640px) {
    .ee-form-row {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection

@section('content')
<div class="ee-parametres-page">
    <!-- Alerts -->
    @if(session('success'))
        <div class="ee-alert success">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="ee-alert error">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="15" y1="9" x2="9" y2="15"></line>
                <line x1="9" y1="9" x2="15" y2="15"></line>
            </svg>
            {{ $errors->first() }}
        </div>
    @endif

    <!-- Account Settings -->
    <div class="ee-settings-card animate-fade-in">
        <div class="ee-settings-header">
            <div class="ee-settings-icon blue">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
            <div>
                <h2 class="ee-settings-title">Informations du compte</h2>
                <p class="ee-settings-subtitle">Gérez vos informations de connexion</p>
            </div>
        </div>
        <div class="ee-settings-body">
            <div class="ee-form-group">
                <label class="ee-form-label">Nom complet</label>
                <input type="text" class="ee-form-input" value="{{ $user->name }}" disabled>
                <p class="ee-form-hint">Contactez l'administrateur pour modifier votre nom</p>
            </div>
            <div class="ee-form-group">
                <label class="ee-form-label">Adresse e-mail</label>
                <input type="email" class="ee-form-input" value="{{ $user->email }}" disabled>
                <p class="ee-form-hint">Contactez l'administrateur pour modifier votre e-mail</p>
            </div>
        </div>
    </div>

    <!-- Password Settings -->
    <div class="ee-settings-card animate-fade-in" style="animation-delay: 0.1s;">
        <div class="ee-settings-header">
            <div class="ee-settings-icon purple">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
            </div>
            <div>
                <h2 class="ee-settings-title">Mot de passe</h2>
                <p class="ee-settings-subtitle">Modifiez votre mot de passe de connexion</p>
            </div>
        </div>
        <div class="ee-settings-body">
            <form action="{{ route('espace-employe.password.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="ee-form-group">
                    <label class="ee-form-label">Mot de passe actuel</label>
                    <input type="password" name="current_password" class="ee-form-input" placeholder="Entrez votre mot de passe actuel" required>
                </div>
                <div class="ee-form-row">
                    <div class="ee-form-group">
                        <label class="ee-form-label">Nouveau mot de passe</label>
                        <input type="password" name="password" class="ee-form-input" placeholder="Minimum 8 caractères" required>
                    </div>
                    <div class="ee-form-group">
                        <label class="ee-form-label">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" class="ee-form-input" placeholder="Confirmez le mot de passe" required>
                    </div>
                </div>
                <button type="submit" class="ee-submit-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    Mettre à jour le mot de passe
                </button>
            </form>
        </div>
    </div>

    <!-- Notifications Settings -->
    <div class="ee-settings-card animate-fade-in" style="animation-delay: 0.2s;">
        <div class="ee-settings-header">
            <div class="ee-settings-icon green">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
            </div>
            <div>
                <h2 class="ee-settings-title">Notifications</h2>
                <p class="ee-settings-subtitle">Gérez vos préférences de notifications</p>
            </div>
        </div>
        <div class="ee-settings-body">
            <div class="ee-toggle-group">
                <div class="ee-toggle-info">
                    <div class="ee-toggle-label">Notifications par e-mail</div>
                    <div class="ee-toggle-desc">Recevez des notifications par e-mail pour les mises à jour importantes</div>
                </div>
                <label class="ee-toggle">
                    <input type="checkbox" checked>
                    <span class="ee-toggle-slider"></span>
                </label>
            </div>
            <div class="ee-toggle-group">
                <div class="ee-toggle-info">
                    <div class="ee-toggle-label">Rappels de congés</div>
                    <div class="ee-toggle-desc">Rappels avant l'expiration de vos congés</div>
                </div>
                <label class="ee-toggle">
                    <input type="checkbox" checked>
                    <span class="ee-toggle-slider"></span>
                </label>
            </div>
            <div class="ee-toggle-group">
                <div class="ee-toggle-info">
                    <div class="ee-toggle-label">Nouveaux bulletins de paie</div>
                    <div class="ee-toggle-desc">Notification lors de la disponibilité d'un nouveau bulletin</div>
                </div>
                <label class="ee-toggle">
                    <input type="checkbox" checked>
                    <span class="ee-toggle-slider"></span>
                </label>
            </div>
        </div>
    </div>

    <!-- WhatsApp Configuration -->
    <div class="ee-settings-card animate-fade-in" style="animation-delay: 0.25s; border-top-color: #25D366;">
        <div class="ee-settings-header">
            <div class="ee-settings-icon" style="background: rgba(37, 211, 102, 0.1); color: #25D366;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24" height="24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
            </div>
            <div>
                <h2 class="ee-settings-title">Notifications WhatsApp</h2>
                <p class="ee-settings-subtitle">Recevez vos notifications RH directement sur WhatsApp</p>
            </div>
        </div>
        <div class="ee-settings-body">
            <div class="ee-info-section" style="margin-bottom: 1.5rem; background: rgba(37, 211, 102, 0.06); border: 1px solid rgba(37, 211, 102, 0.15);">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#25D366" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="16" x2="12" y2="12"></line>
                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                </svg>
                <div style="font-size: 0.875rem; color: var(--e-text-secondary); line-height: 1.6;">
                    <strong style="color: var(--e-text);">Comment activer :</strong>
                    <ol style="margin: 0.5rem 0 0 1.25rem; padding: 0;">
                        <li>Enregistrez le numero <strong>+34 644 71 89 03</strong> dans vos contacts WhatsApp</li>
                        <li>Envoyez le message : <code style="background: rgba(37, 211, 102, 0.1); padding: 2px 6px; border-radius: 4px; font-size: 0.8125rem;">I allow callmebot to send me messages</code></li>
                        <li>Vous recevrez une <strong>cle API</strong> en reponse</li>
                        <li>Collez cette cle ci-dessous et enregistrez</li>
                    </ol>
                </div>
            </div>

            <form action="{{ route('espace-employe.whatsapp.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="ee-form-group">
                    <label class="ee-form-label">Cle API CallMeBot</label>
                    <input type="text" name="callmebot_apikey" class="ee-form-input"
                           value="{{ $personnel->callmebot_apikey ?? '' }}"
                           placeholder="Ex: 1234567">
                    <p class="ee-form-hint">
                        @if($personnel && $personnel->callmebot_apikey)
                            WhatsApp actif - vous recevrez les notifications sur votre numero
                        @else
                            Entrez votre cle API pour activer les notifications WhatsApp
                        @endif
                    </p>
                </div>

                @if($personnel && $personnel->telephone)
                <div class="ee-form-group">
                    <label class="ee-form-label">Numero WhatsApp</label>
                    <input type="text" class="ee-form-input" value="{{ ($personnel->telephone_code_pays ?? '+226') . ' ' . $personnel->telephone }}" disabled>
                    <p class="ee-form-hint">Ce numero sera utilise pour les notifications WhatsApp</p>
                </div>
                @else
                <div class="ee-info-section" style="background: var(--e-amber-wash); border: 1px solid var(--e-amber);">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="var(--e-amber)" stroke-width="2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                    <p>Vous devez d'abord renseigner votre numero de telephone dans votre profil pour activer WhatsApp.</p>
                </div>
                @endif

                <button type="submit" class="ee-submit-btn" style="background: #25D366;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    Enregistrer la configuration WhatsApp
                </button>
            </form>
        </div>
    </div>

    <!-- Security Info -->
    <div class="ee-settings-card animate-fade-in" style="animation-delay: 0.3s;">
        <div class="ee-settings-header">
            <div class="ee-settings-icon orange">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                </svg>
            </div>
            <div>
                <h2 class="ee-settings-title">Sécurité</h2>
                <p class="ee-settings-subtitle">Informations sur la sécurité de votre compte</p>
            </div>
        </div>
        <div class="ee-settings-body">
            <div class="ee-info-section">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="16" x2="12" y2="12"></line>
                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                </svg>
                <p>
                    Pour activer l'authentification à deux facteurs (2FA) ou pour toute autre demande de sécurité avancée,
                    veuillez contacter votre administrateur RH ou accéder aux paramètres de sécurité depuis le portail principal.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
