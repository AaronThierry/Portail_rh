@extends('layouts.app')

@section('title', 'Configuration 2FA')

@section('styles')
<style>
/* Two Factor Setup Styles */
.two-factor-setup-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    position: relative;
    overflow: hidden;
}

.two-factor-setup-page::before {
    content: '';
    position: absolute;
    width: 500px;
    height: 500px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    top: -250px;
    right: -250px;
    animation: float 6s ease-in-out infinite;
}

.two-factor-setup-page::after {
    content: '';
    position: absolute;
    width: 300px;
    height: 300px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 50%;
    bottom: -150px;
    left: -150px;
    animation: float 8s ease-in-out infinite reverse;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(5deg); }
}

.two-factor-card {
    background: var(--card-bg);
    border-radius: 24px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    max-width: 600px;
    width: 100%;
    overflow: hidden;
    position: relative;
    z-index: 1;
    animation: slideUp 0.5s ease-out;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 40px 32px;
    text-align: center;
    position: relative;
}

.header-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    backdrop-filter: blur(10px);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.header-icon svg {
    width: 40px;
    height: 40px;
    color: white;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
}

.card-header h1 {
    color: white;
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.card-header p {
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.9375rem;
    margin-top: 8px;
}

.card-body {
    padding: 40px 32px;
}

.instructions-box {
    background: linear-gradient(135deg, #e0e7ff 0%, #ede9fe 100%);
    border: 2px solid #c7d2fe;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 32px;
    position: relative;
    overflow: hidden;
}

.instructions-box::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
}

.instructions-title {
    display: flex;
    align-items: center;
    font-size: 1.125rem;
    font-weight: 700;
    color: #5b21b6;
    margin-bottom: 16px;
}

.instructions-title svg {
    width: 24px;
    height: 24px;
    margin-right: 12px;
    color: #7c3aed;
}

.instruction-steps {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.instruction-step {
    display: flex;
    align-items: flex-start;
    color: #6b21a8;
    font-size: 0.9375rem;
    line-height: 1.6;
}

.step-number {
    width: 28px;
    height: 28px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.875rem;
    flex-shrink: 0;
    margin-right: 12px;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.qr-code-container {
    text-align: center;
    margin-bottom: 32px;
}

.qr-code-wrapper {
    display: inline-block;
    padding: 20px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    position: relative;
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { box-shadow: 0 8px 32px rgba(102, 126, 234, 0.2); }
    50% { box-shadow: 0 8px 48px rgba(102, 126, 234, 0.4); }
}

.qr-code-wrapper svg {
    display: block;
    width: 220px;
    height: 220px;
    border-radius: 12px;
}

.secret-code-box {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border: 2px dashed #cbd5e1;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 32px;
    text-align: center;
}

.secret-code-label {
    color: #64748b;
    font-size: 0.875rem;
    margin-bottom: 12px;
    font-weight: 500;
}

.secret-code-value {
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 16px;
    position: relative;
}

.secret-code-value code {
    font-size: 1.125rem;
    font-weight: 600;
    color: #334155;
    font-family: 'Courier New', monospace;
    letter-spacing: 3px;
}

.copy-btn {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 0.75rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 6px;
}

.copy-btn:hover {
    transform: translateY(-50%) scale(1.05);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.copy-btn svg {
    width: 14px;
    height: 14px;
}

.verification-form {
    margin-top: 32px;
}

.form-label {
    display: block;
    text-align: center;
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 16px;
}

.code-input-wrapper {
    position: relative;
    margin-bottom: 12px;
}

.code-input {
    width: 100%;
    padding: 20px;
    text-align: center;
    font-size: 2rem;
    font-weight: 700;
    font-family: 'Courier New', monospace;
    letter-spacing: 12px;
    border: 3px solid #e2e8f0;
    border-radius: 16px;
    background: #f8fafc;
    color: #334155;
    transition: all 0.3s ease;
    outline: none;
}

.code-input:focus {
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
}

.code-input::placeholder {
    color: #cbd5e1;
    opacity: 0.6;
}

.input-hint {
    text-align: center;
    color: #64748b;
    font-size: 0.875rem;
    margin-bottom: 24px;
}

.button-group {
    display: flex;
    gap: 12px;
}

.btn-cancel,
.btn-verify {
    flex: 1;
    padding: 16px;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-decoration: none;
}

.btn-cancel {
    background: #f1f5f9;
    color: #475569;
}

.btn-cancel:hover {
    background: #e2e8f0;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.btn-verify {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.btn-verify:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(102, 126, 234, 0.5);
}

.btn-verify:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

.btn-verify svg,
.btn-cancel svg {
    width: 20px;
    height: 20px;
}

.alert-error {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    border: 2px solid #f87171;
    color: #991b1b;
    padding: 16px 20px;
    border-radius: 12px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 500;
    animation: shake 0.5s ease;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-10px); }
    75% { transform: translateX(10px); }
}

.alert-error svg {
    width: 20px;
    height: 20px;
    flex-shrink: 0;
}

/* Responsive */
@media (max-width: 640px) {
    .two-factor-setup-page {
        padding: 12px;
    }

    .card-header {
        padding: 32px 20px;
    }

    .card-body {
        padding: 24px 20px;
    }

    .header-icon {
        width: 64px;
        height: 64px;
    }

    .header-icon svg {
        width: 32px;
        height: 32px;
    }

    .card-header h1 {
        font-size: 1.5rem;
    }

    .qr-code-wrapper svg {
        width: 180px;
        height: 180px;
    }

    .code-input {
        font-size: 1.5rem;
        letter-spacing: 8px;
        padding: 16px;
    }

    .button-group {
        flex-direction: column;
    }

    .secret-code-value code {
        font-size: 0.9375rem;
        letter-spacing: 2px;
    }

    .copy-btn {
        position: static;
        transform: none;
        margin-top: 12px;
        width: 100%;
        justify-content: center;
    }

    .copy-btn:hover {
        transform: none;
    }
}
</style>
@endsection

@section('content')
<div class="two-factor-setup-page">
    <div class="two-factor-card">
        <!-- Card Header -->
        <div class="card-header">
            <div class="header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <rect x="5" y="11" width="14" height="10" rx="2" ry="2" stroke-width="2"></rect>
                    <circle cx="12" cy="16" r="1" fill="currentColor"></circle>
                    <path d="M8 11V7a4 4 0 0 1 8 0v4" stroke-width="2"></path>
                </svg>
            </div>
            <h1>Configuration de l'authentification 2FA</h1>
            <p>Sécurisez votre compte avec Google Authenticator</p>
        </div>

        <!-- Card Body -->
        <div class="card-body">
            <!-- Instructions -->
            <div class="instructions-box">
                <div class="instructions-title">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    Comment configurer
                </div>
                <div class="instruction-steps">
                    <div class="instruction-step">
                        <span class="step-number">1</span>
                        <span>Téléchargez <strong>Google Authenticator</strong> sur votre smartphone (iOS ou Android)</span>
                    </div>
                    <div class="instruction-step">
                        <span class="step-number">2</span>
                        <span>Ouvrez l'application et <strong>scannez le QR code</strong> ci-dessous avec votre caméra</span>
                    </div>
                    <div class="instruction-step">
                        <span class="step-number">3</span>
                        <span>Entrez le <strong>code à 6 chiffres</strong> généré pour finaliser l'activation</span>
                    </div>
                </div>
            </div>

            <!-- QR Code -->
            <div class="qr-code-container">
                <div class="qr-code-wrapper">
                    {!! $qrCodeSvg !!}
                </div>
            </div>

            <!-- Secret Code -->
            <div class="secret-code-box">
                <div class="secret-code-label">
                    Impossible de scanner ? Utilisez cette clé secrète :
                </div>
                <div class="secret-code-value">
                    <code id="secretCode">{{ $secret }}</code>
                    <button type="button" class="copy-btn" onclick="copySecret()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        Copier
                    </button>
                </div>
            </div>

            <!-- Error Alert -->
            @if(session('error'))
                <div class="alert-error">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Verification Form -->
            <form method="POST" action="{{ route('two-factor.verify') }}" class="verification-form">
                @csrf
                <label for="one_time_password" class="form-label">
                    Entrez le code de vérification
                </label>

                <div class="code-input-wrapper">
                    <input
                        type="text"
                        name="one_time_password"
                        id="one_time_password"
                        maxlength="6"
                        pattern="[0-9]{6}"
                        class="code-input"
                        placeholder="000000"
                        required
                        autofocus
                        autocomplete="off"
                    >
                </div>

                <div class="input-hint">
                    Le code change toutes les 30 secondes
                </div>

                <div class="button-group">
                    <a href="{{ route('profile') }}" class="btn-cancel">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Annuler
                    </a>
                    <button type="submit" class="btn-verify" id="submitBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Vérifier et activer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Copy secret code to clipboard
function copySecret() {
    const secretCode = document.getElementById('secretCode').textContent;
    navigator.clipboard.writeText(secretCode).then(() => {
        const btn = event.target.closest('.copy-btn');
        const originalText = btn.innerHTML;
        btn.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Copié !
        `;
        btn.style.background = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';

        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
        }, 2000);
    });
}

// Auto-format code input
const codeInput = document.getElementById('one_time_password');
const submitBtn = document.getElementById('submitBtn');

codeInput.addEventListener('input', function(e) {
    // Only allow numbers
    this.value = this.value.replace(/\D/g, '');

    // Enable/disable submit button
    if (this.value.length === 6) {
        submitBtn.disabled = false;
        // Auto-submit when 6 digits entered
        setTimeout(() => {
            this.form.submit();
        }, 300);
    } else {
        submitBtn.disabled = true;
    }
});

// Focus input on load
window.addEventListener('load', function() {
    codeInput.focus();
});

// Prevent form submission if code is not 6 digits
document.querySelector('form').addEventListener('submit', function(e) {
    if (codeInput.value.length !== 6) {
        e.preventDefault();
        codeInput.focus();
        codeInput.style.borderColor = '#ef4444';
        setTimeout(() => {
            codeInput.style.borderColor = '#e2e8f0';
        }, 1000);
    }
});
</script>
@endsection
