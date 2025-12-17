@extends('layouts.app')

@section('title', 'Configuration 2FA')
@section('page-title', 'Authentification à deux facteurs')
@section('page-subtitle', 'Sécurisez votre compte avec Google Authenticator')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
    <path d="M9 12l2 2 4-4"></path>
</svg>
@endsection

@section('content')
<div class="twofa-setup-page">
    <div class="twofa-setup-container">
        <!-- Main Card -->
        <div class="twofa-main-card">
            <!-- Card Header with gradient -->
            <div class="twofa-card-header">
                <div class="twofa-header-pattern"></div>
                <div class="twofa-header-content">
                    <div class="twofa-header-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="5" y="11" width="14" height="10" rx="2" ry="2"></rect>
                            <circle cx="12" cy="16" r="1" fill="currentColor"></circle>
                            <path d="M8 11V7a4 4 0 0 1 8 0v4"></path>
                        </svg>
                    </div>
                    <div class="twofa-header-text">
                        <h1>Configuration de la 2FA</h1>
                        <p>Protégez votre compte avec une authentification renforcée</p>
                    </div>
                </div>
            </div>

            <!-- Card Body -->
            <div class="twofa-card-body">
                <!-- Steps Section -->
                <div class="twofa-steps-section">
                    <h3 class="section-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        Comment configurer
                    </h3>
                    <div class="steps-grid">
                        <div class="step-card">
                            <div class="step-number">1</div>
                            <div class="step-content">
                                <h4>Téléchargez l'application</h4>
                                <p>Google Authenticator, Authy ou Microsoft Authenticator sur votre smartphone</p>
                            </div>
                        </div>
                        <div class="step-card">
                            <div class="step-number">2</div>
                            <div class="step-content">
                                <h4>Scannez le QR code</h4>
                                <p>Ouvrez l'application et scannez le code QR affiché ci-dessous</p>
                            </div>
                        </div>
                        <div class="step-card">
                            <div class="step-number">3</div>
                            <div class="step-content">
                                <h4>Entrez le code</h4>
                                <p>Saisissez le code à 6 chiffres généré par l'application</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- QR Code Section -->
                <div class="qr-section">
                    <div class="qr-container">
                        <div class="qr-glow"></div>
                        <div class="qr-wrapper">
                            <div class="qr-code">
                                {!! $qrCodeSvg !!}
                            </div>
                        </div>
                        <div class="qr-scan-hint">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                                <circle cx="12" cy="13" r="4"></circle>
                            </svg>
                            <span>Scannez avec votre application</span>
                        </div>
                    </div>
                </div>

                <!-- Secret Key Section -->
                <div class="secret-section">
                    <div class="secret-header">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <span>Clé secrète (si vous ne pouvez pas scanner)</span>
                    </div>
                    <div class="secret-box">
                        <code id="secretCode">{{ $secret }}</code>
                        <button type="button" class="copy-btn" onclick="copySecret()">
                            <svg class="copy-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                            </svg>
                            <svg class="check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: none;">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            <span class="copy-text">Copier</span>
                        </button>
                    </div>
                </div>

                <!-- Error Alert -->
                @if(session('error'))
                <div class="alert alert-error">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
                @endif

                <!-- Verification Form -->
                @php
                    $isAdmin = auth()->user()->hasRole('Super Admin');
                    $verifyRoute = $isAdmin ? route('admin.two-factor.verify') : route('espace-employe.two-factor.verify');
                    $cancelRoute = $isAdmin ? route('admin.profile.index') : route('espace-employe.parametres');
                @endphp
                <form method="POST" action="{{ $verifyRoute }}" class="verification-form">
                    @csrf
                    <div class="form-header">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            <circle cx="12" cy="16" r="1"></circle>
                        </svg>
                        <span>Entrez le code de vérification</span>
                    </div>

                    <div class="otp-input-container">
                        <input
                            type="text"
                            name="one_time_password"
                            id="one_time_password"
                            maxlength="6"
                            pattern="[0-9]{6}"
                            class="otp-input"
                            placeholder="000000"
                            required
                            autofocus
                            autocomplete="off"
                        >
                        <div class="otp-timer">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            <span>Le code change toutes les 30 secondes</span>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ $cancelRoute }}" class="btn btn-secondary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="19" y1="12" x2="5" y2="12"></line>
                                <polyline points="12 19 5 12 12 5"></polyline>
                            </svg>
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                <polyline points="9 12 11 14 15 10"></polyline>
                            </svg>
                            Activer la 2FA
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Side Info Card -->
        <div class="twofa-info-card">
            <div class="info-card-header">
                <div class="info-icon success">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
                </div>
                <h3>Pourquoi activer la 2FA ?</h3>
            </div>
            <div class="info-benefits">
                <div class="benefit-item">
                    <div class="benefit-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <div class="benefit-text">
                        <strong>Protection renforcée</strong>
                        <span>Même si votre mot de passe est compromis</span>
                    </div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <div class="benefit-text">
                        <strong>Codes temporaires</strong>
                        <span>Valides seulement 30 secondes</span>
                    </div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <div class="benefit-text">
                        <strong>Standard de sécurité</strong>
                        <span>Utilisé par les banques et entreprises</span>
                    </div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <div class="benefit-text">
                        <strong>Fonctionne hors ligne</strong>
                        <span>Pas besoin de connexion internet</span>
                    </div>
                </div>
            </div>

            <div class="app-suggestions">
                <h4>Applications recommandées</h4>
                <div class="app-list">
                    <div class="app-item">
                        <div class="app-icon google">G</div>
                        <span>Google Authenticator</span>
                    </div>
                    <div class="app-item">
                        <div class="app-icon authy">A</div>
                        <span>Authy</span>
                    </div>
                    <div class="app-item">
                        <div class="app-icon microsoft">M</div>
                        <span>Microsoft Authenticator</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ==================== 2FA SETUP PAGE - PORTAIL RH DESIGN ==================== */

.twofa-setup-page {
    padding: 0;
    animation: fadeInUp 0.4s ease;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.twofa-setup-container {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 1.5rem;
    align-items: start;
}

@media (max-width: 1200px) {
    .twofa-setup-container {
        grid-template-columns: 1fr;
    }
}

/* Main Card */
.twofa-main-card {
    background: var(--card-bg, #fff);
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--sidebar-border, #E8ECF0);
}

/* Card Header */
.twofa-card-header {
    position: relative;
    background: linear-gradient(135deg, var(--primary, #4A90D9) 0%, var(--primary-dark, #2E6BB3) 100%);
    padding: 2rem;
    overflow: hidden;
}

.twofa-header-pattern {
    position: absolute;
    inset: 0;
    opacity: 0.1;
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.twofa-header-content {
    position: relative;
    display: flex;
    align-items: center;
    gap: 1.25rem;
}

.twofa-header-icon {
    width: 64px;
    height: 64px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.twofa-header-icon svg {
    width: 32px;
    height: 32px;
    color: white;
}

.twofa-header-text h1 {
    font-size: 1.5rem;
    font-weight: 700;
    color: white;
    margin: 0;
}

.twofa-header-text p {
    font-size: 0.9375rem;
    color: rgba(255, 255, 255, 0.9);
    margin: 0.25rem 0 0;
}

/* Card Body */
.twofa-card-body {
    padding: 2rem;
}

/* Steps Section */
.twofa-steps-section {
    margin-bottom: 2rem;
}

.section-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--text-primary, #1F2937);
    margin: 0 0 1.25rem;
}

.section-title svg {
    width: 24px;
    height: 24px;
    color: var(--primary, #4A90D9);
}

.steps-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}

@media (max-width: 768px) {
    .steps-grid {
        grid-template-columns: 1fr;
    }
}

.step-card {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1.25rem;
    background: var(--primary-light, #E8F4FD);
    border-radius: 16px;
    border: 1px solid rgba(74, 144, 217, 0.1);
    transition: all 0.3s ease;
}

.step-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(74, 144, 217, 0.15);
}

.step-number {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, var(--primary, #4A90D9) 0%, var(--primary-dark, #2E6BB3) 100%);
    color: white;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    font-weight: 700;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(74, 144, 217, 0.3);
}

.step-content h4 {
    font-size: 0.9375rem;
    font-weight: 700;
    color: var(--text-primary, #1F2937);
    margin: 0 0 0.25rem;
}

.step-content p {
    font-size: 0.8125rem;
    color: var(--text-muted, #6B7280);
    margin: 0;
    line-height: 1.5;
}

/* QR Section */
.qr-section {
    display: flex;
    justify-content: center;
    margin-bottom: 2rem;
}

.qr-container {
    position: relative;
    text-align: center;
}

.qr-glow {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 280px;
    height: 280px;
    background: radial-gradient(circle, rgba(74, 144, 217, 0.15) 0%, transparent 70%);
    border-radius: 50%;
    animation: pulse-glow 2s ease-in-out infinite;
}

@keyframes pulse-glow {
    0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.5; }
    50% { transform: translate(-50%, -50%) scale(1.1); opacity: 0.8; }
}

.qr-wrapper {
    position: relative;
    display: inline-block;
    padding: 1.5rem;
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    border: 3px solid var(--primary, #4A90D9);
}

.qr-code svg {
    display: block;
    width: 200px;
    height: 200px;
}

.qr-scan-hint {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 1rem;
    font-size: 0.875rem;
    color: var(--text-muted, #6B7280);
}

.qr-scan-hint svg {
    width: 18px;
    height: 18px;
    color: var(--primary, #4A90D9);
}

/* Secret Section */
.secret-section {
    background: var(--sidebar-hover, #F8FAFC);
    border-radius: 16px;
    padding: 1.25rem;
    margin-bottom: 2rem;
}

.secret-header {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-muted, #6B7280);
    margin-bottom: 0.75rem;
}

.secret-header svg {
    width: 18px;
    height: 18px;
    color: var(--accent-orange, #FF9500);
}

.secret-box {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: white;
    border: 2px solid var(--sidebar-border, #E8ECF0);
    border-radius: 12px;
    padding: 1rem 1.25rem;
}

.secret-box code {
    flex: 1;
    font-size: 1.125rem;
    font-weight: 700;
    font-family: 'Courier New', monospace;
    letter-spacing: 3px;
    color: var(--text-primary, #1F2937);
}

.copy-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1rem;
    background: linear-gradient(135deg, var(--primary, #4A90D9) 0%, var(--primary-dark, #2E6BB3) 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 0.8125rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    flex-shrink: 0;
}

.copy-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(74, 144, 217, 0.4);
}

.copy-btn.copied {
    background: linear-gradient(135deg, #22C55E 0%, #16A34A 100%);
}

.copy-btn svg {
    width: 16px;
    height: 16px;
}

/* Alert */
.alert {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 1.25rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    animation: shake 0.5s ease;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

.alert-error {
    background: linear-gradient(135deg, #FEE2E2 0%, #FECACA 100%);
    color: #991B1B;
    border: 1px solid #FCA5A5;
}

.alert svg {
    width: 20px;
    height: 20px;
    flex-shrink: 0;
}

/* Verification Form */
.verification-form {
    border-top: 1px solid var(--sidebar-border, #E8ECF0);
    padding-top: 2rem;
}

.form-header {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.625rem;
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary, #1F2937);
    margin-bottom: 1.25rem;
}

.form-header svg {
    width: 22px;
    height: 22px;
    color: var(--primary, #4A90D9);
}

.otp-input-container {
    text-align: center;
    margin-bottom: 1.5rem;
}

.otp-input {
    width: 100%;
    max-width: 320px;
    padding: 1.25rem;
    text-align: center;
    font-size: 2.5rem;
    font-weight: 700;
    font-family: 'Courier New', monospace;
    letter-spacing: 16px;
    border: 3px solid var(--sidebar-border, #E8ECF0);
    border-radius: 16px;
    background: var(--sidebar-hover, #F8FAFC);
    color: var(--text-primary, #1F2937);
    transition: all 0.3s ease;
    outline: none;
}

.otp-input:focus {
    border-color: var(--primary, #4A90D9);
    background: white;
    box-shadow: 0 0 0 4px rgba(74, 144, 217, 0.15);
}

.otp-input::placeholder {
    color: var(--text-muted, #9CA3AF);
    opacity: 0.5;
}

.otp-timer {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 0.75rem;
    font-size: 0.8125rem;
    color: var(--text-muted, #6B7280);
}

.otp-timer svg {
    width: 16px;
    height: 16px;
    color: var(--accent-orange, #FF9500);
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
}

@media (max-width: 480px) {
    .form-actions {
        flex-direction: column;
    }
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.625rem;
    padding: 1rem 2rem;
    font-size: 0.9375rem;
    font-weight: 600;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
}

.btn svg {
    width: 20px;
    height: 20px;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary, #4A90D9) 0%, var(--primary-dark, #2E6BB3) 100%);
    color: white;
    box-shadow: 0 4px 14px rgba(74, 144, 217, 0.35);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(74, 144, 217, 0.45);
}

.btn-secondary {
    background: var(--sidebar-hover, #F3F4F6);
    color: var(--text-primary, #374151);
    border: 1px solid var(--sidebar-border, #E8ECF0);
}

.btn-secondary:hover {
    background: var(--sidebar-border, #E8ECF0);
    transform: translateY(-2px);
}

/* Info Card (Sidebar) */
.twofa-info-card {
    background: var(--card-bg, #fff);
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    border: 1px solid var(--sidebar-border, #E8ECF0);
    position: sticky;
    top: 90px;
}

.info-card-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--sidebar-border, #E8ECF0);
}

.info-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.info-icon.success {
    background: rgba(39, 174, 96, 0.1);
    color: var(--accent-green, #27AE60);
}

.info-icon svg {
    width: 24px;
    height: 24px;
}

.info-card-header h3 {
    font-size: 1.0625rem;
    font-weight: 700;
    color: var(--text-primary, #1F2937);
    margin: 0;
}

.info-benefits {
    display: flex;
    flex-direction: column;
    gap: 0.875rem;
    margin-bottom: 1.5rem;
}

.benefit-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.benefit-icon {
    width: 24px;
    height: 24px;
    background: rgba(39, 174, 96, 0.1);
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 2px;
}

.benefit-icon svg {
    width: 14px;
    height: 14px;
    color: var(--accent-green, #27AE60);
}

.benefit-text strong {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-primary, #1F2937);
}

.benefit-text span {
    display: block;
    font-size: 0.8125rem;
    color: var(--text-muted, #6B7280);
    margin-top: 0.125rem;
}

/* App Suggestions */
.app-suggestions {
    background: var(--sidebar-hover, #F8FAFC);
    border-radius: 14px;
    padding: 1.25rem;
}

.app-suggestions h4 {
    font-size: 0.875rem;
    font-weight: 700;
    color: var(--text-primary, #1F2937);
    margin: 0 0 1rem;
}

.app-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.app-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.875rem;
    color: var(--text-muted, #6B7280);
}

.app-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    font-weight: 700;
    color: white;
}

.app-icon.google {
    background: linear-gradient(135deg, #4285F4 0%, #34A853 50%, #FBBC05 75%, #EA4335 100%);
}

.app-icon.authy {
    background: linear-gradient(135deg, #EC1C24 0%, #C51A1F 100%);
}

.app-icon.microsoft {
    background: linear-gradient(135deg, #00A4EF 0%, #7FBA00 50%, #FFB900 75%, #F25022 100%);
}

/* Dark Mode */
.dark .twofa-main-card,
.dark .twofa-info-card {
    background: var(--card-bg);
    border-color: var(--sidebar-border);
}

.dark .section-title,
.dark .step-content h4,
.dark .info-card-header h3,
.dark .benefit-text strong,
.dark .app-suggestions h4,
.dark .form-header,
.dark .secret-box code {
    color: #F9FAFB;
}

.dark .step-card {
    background: rgba(74, 144, 217, 0.1);
    border-color: rgba(74, 144, 217, 0.2);
}

.dark .qr-wrapper {
    background: #1F2937;
    border-color: var(--primary);
}

.dark .secret-section {
    background: var(--sidebar-hover);
}

.dark .secret-box {
    background: var(--card-bg);
    border-color: var(--sidebar-border);
}

.dark .otp-input {
    background: var(--sidebar-hover);
    border-color: var(--sidebar-border);
    color: #F9FAFB;
}

.dark .otp-input:focus {
    background: var(--card-bg);
    border-color: var(--primary);
}

.dark .btn-secondary {
    background: var(--sidebar-hover);
    border-color: var(--sidebar-border);
    color: #E5E7EB;
}

.dark .app-suggestions {
    background: var(--sidebar-hover);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const codeInput = document.getElementById('one_time_password');
    const submitBtn = document.getElementById('submitBtn');

    // Only allow numbers and auto-submit on 6 digits
    codeInput.addEventListener('input', function(e) {
        this.value = this.value.replace(/\D/g, '');

        if (this.value.length === 6) {
            submitBtn.disabled = false;
            // Visual feedback
            this.style.borderColor = 'var(--accent-green, #27AE60)';
            this.style.background = 'rgba(39, 174, 96, 0.05)';
            // Auto-submit after brief delay
            setTimeout(() => {
                this.form.submit();
            }, 400);
        } else {
            submitBtn.disabled = this.value.length !== 6;
            this.style.borderColor = '';
            this.style.background = '';
        }
    });

    // Focus input on load
    codeInput.focus();

    // Prevent form submission if code is invalid
    document.querySelector('form').addEventListener('submit', function(e) {
        if (codeInput.value.length !== 6) {
            e.preventDefault();
            codeInput.focus();
            codeInput.style.borderColor = 'var(--accent-red, #E74C3C)';
            codeInput.style.animation = 'shake 0.5s ease';
            setTimeout(() => {
                codeInput.style.borderColor = '';
                codeInput.style.animation = '';
            }, 500);
        }
    });
});

// Copy secret code to clipboard
function copySecret() {
    const secretCode = document.getElementById('secretCode').textContent;
    const btn = document.querySelector('.copy-btn');
    const copyIcon = btn.querySelector('.copy-icon');
    const checkIcon = btn.querySelector('.check-icon');
    const copyText = btn.querySelector('.copy-text');

    navigator.clipboard.writeText(secretCode).then(() => {
        btn.classList.add('copied');
        copyIcon.style.display = 'none';
        checkIcon.style.display = 'block';
        copyText.textContent = 'Copié !';

        setTimeout(() => {
            btn.classList.remove('copied');
            copyIcon.style.display = 'block';
            checkIcon.style.display = 'none';
            copyText.textContent = 'Copier';
        }, 2000);
    });
}
</script>
@endsection
