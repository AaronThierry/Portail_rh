<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vérification 2FA - Portail RH</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
/* Two Factor Challenge Styles */
.two-factor-challenge-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    position: relative;
    overflow: hidden;
}

/* Animated Background Elements */
.bg-shape {
    position: absolute;
    border-radius: 50%;
    opacity: 0.1;
    animation: float 20s ease-in-out infinite;
}

.bg-shape-1 {
    width: 400px;
    height: 400px;
    background: white;
    top: -200px;
    right: -100px;
    animation-delay: 0s;
}

.bg-shape-2 {
    width: 300px;
    height: 300px;
    background: white;
    bottom: -150px;
    left: -100px;
    animation-delay: 5s;
}

.bg-shape-3 {
    width: 200px;
    height: 200px;
    background: white;
    top: 50%;
    left: -50px;
    animation-delay: 10s;
}

@keyframes float {
    0%, 100% {
        transform: translate(0, 0) rotate(0deg);
    }
    25% {
        transform: translate(20px, -20px) rotate(5deg);
    }
    50% {
        transform: translate(-20px, 20px) rotate(-5deg);
    }
    75% {
        transform: translate(10px, 10px) rotate(3deg);
    }
}

/* Main Card */
.challenge-card {
    background: white;
    border-radius: 28px;
    box-shadow: 0 25px 70px rgba(0, 0, 0, 0.35);
    max-width: 480px;
    width: 100%;
    position: relative;
    z-index: 1;
    animation: slideIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    overflow: hidden;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(50px) scale(0.9);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* Header Section */
.challenge-header {
    padding: 48px 32px 32px;
    text-align: center;
    position: relative;
}

/* Animated Shield Icon */
.shield-icon-wrapper {
    position: relative;
    width: 120px;
    height: 120px;
    margin: 0 auto 24px;
}

.shield-background {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    animation: pulse-shield 3s ease-in-out infinite;
}

@keyframes pulse-shield {
    0%, 100% {
        transform: scale(1);
        opacity: 0.2;
    }
    50% {
        transform: scale(1.2);
        opacity: 0.1;
    }
}

.shield-icon {
    position: relative;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 12px 40px rgba(102, 126, 234, 0.4);
    animation: bounce 2s ease-in-out infinite;
}

@keyframes bounce {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

.shield-icon svg {
    width: 56px;
    height: 56px;
    color: white;
    filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
}

.challenge-header h1 {
    font-size: 1.875rem;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 12px;
    letter-spacing: -0.5px;
}

.challenge-header p {
    font-size: 0.9375rem;
    color: #64748b;
    line-height: 1.6;
    max-width: 380px;
    margin: 0 auto;
}

/* Card Body */
.challenge-body {
    padding: 0 32px 48px;
}

/* Error Alert with Animation */
.alert-error {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    border: 2px solid #f87171;
    color: #991b1b;
    padding: 16px 20px;
    border-radius: 16px;
    margin-bottom: 28px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 500;
    font-size: 0.9375rem;
    animation: shake 0.6s ease, fadeIn 0.3s ease;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
    20%, 40%, 60%, 80% { transform: translateX(5px); }
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.alert-error svg {
    width: 22px;
    height: 22px;
    flex-shrink: 0;
}

/* Code Input Section */
.code-input-section {
    margin-bottom: 32px;
}

.input-label {
    display: block;
    text-align: center;
    font-size: 1rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 20px;
    letter-spacing: -0.3px;
}

.code-input-container {
    position: relative;
}

.code-input {
    width: 100%;
    padding: 24px 20px;
    text-align: center;
    font-size: 2.5rem;
    font-weight: 800;
    font-family: 'SF Mono', 'Monaco', 'Cascadia Code', 'Courier New', monospace;
    letter-spacing: 16px;
    border: 3px solid #e2e8f0;
    border-radius: 20px;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    color: #1e293b;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    outline: none;
    box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.05);
}

.code-input:focus {
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 5px rgba(102, 126, 234, 0.12), inset 0 2px 8px rgba(0, 0, 0, 0.05);
    transform: scale(1.02);
}

.code-input::placeholder {
    color: #cbd5e1;
    opacity: 0.5;
}

/* Digit Indicators */
.digit-indicators {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 16px;
}

.digit-indicator {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #e2e8f0;
    transition: all 0.3s ease;
}

.digit-indicator.filled {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    transform: scale(1.2);
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.4);
}

/* Timer and Hint */
.input-hint {
    text-align: center;
    margin-top: 16px;
    font-size: 0.875rem;
    color: #64748b;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.timer-icon {
    width: 16px;
    height: 16px;
    color: #667eea;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Submit Button */
.submit-btn {
    width: 100%;
    padding: 18px 24px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-size: 1.0625rem;
    font-weight: 700;
    border-radius: 16px;
    border: none;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    box-shadow: 0 8px 24px rgba(102, 126, 234, 0.35);
    position: relative;
    overflow: hidden;
}

.submit-btn::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, transparent 0%, rgba(255, 255, 255, 0.2) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.submit-btn:hover:not(:disabled) {
    transform: translateY(-3px);
    box-shadow: 0 12px 32px rgba(102, 126, 234, 0.45);
}

.submit-btn:hover:not(:disabled)::before {
    opacity: 1;
}

.submit-btn:active:not(:disabled) {
    transform: translateY(-1px);
}

.submit-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

.submit-btn svg {
    width: 24px;
    height: 24px;
}

.submit-btn .spinner {
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-top-color: white;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
    display: none;
}

.submit-btn.loading .spinner {
    display: block;
}

.submit-btn.loading .btn-text {
    display: none;
}

/* Footer Actions */
.challenge-footer {
    margin-top: 32px;
    padding-top: 24px;
    border-top: 2px solid #f1f5f9;
    text-align: center;
}

.footer-text {
    font-size: 0.875rem;
    color: #64748b;
    margin-bottom: 12px;
}

.logout-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #667eea;
    font-weight: 600;
    font-size: 0.9375rem;
    text-decoration: none;
    transition: all 0.3s ease;
    padding: 8px 16px;
    border-radius: 10px;
    border: none;
    background: none;
    cursor: pointer;
}

.logout-btn:hover {
    background: #f0f4ff;
    color: #5568d3;
}

.logout-btn svg {
    width: 18px;
    height: 18px;
}

/* Info Card at Bottom */
.info-card {
    margin-top: 24px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 20px 24px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.info-card-content {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    color: #475569;
    font-size: 0.875rem;
    line-height: 1.6;
}

.info-card-content svg {
    width: 20px;
    height: 20px;
    color: #667eea;
    flex-shrink: 0;
}

/* Responsive Design */
@media (max-width: 640px) {
    .two-factor-challenge-page {
        padding: 16px;
    }

    .challenge-card {
        border-radius: 24px;
    }

    .challenge-header {
        padding: 36px 24px 24px;
    }

    .shield-icon-wrapper {
        width: 100px;
        height: 100px;
    }

    .shield-icon svg {
        width: 48px;
        height: 48px;
    }

    .challenge-header h1 {
        font-size: 1.625rem;
    }

    .challenge-body {
        padding: 0 24px 36px;
    }

    .code-input {
        font-size: 2rem;
        letter-spacing: 12px;
        padding: 20px 16px;
    }

    .info-card {
        margin-top: 20px;
        padding: 16px 20px;
    }
}

/* Loading State */
@keyframes shimmer {
    0% { background-position: -1000px 0; }
    100% { background-position: 1000px 0; }
}

.loading-shimmer {
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
    background-size: 1000px 100%;
    animation: shimmer 2s infinite;
}
    </style>
</head>
<body>
<div class="two-factor-challenge-page">
    <!-- Animated Background Shapes -->
    <div class="bg-shape bg-shape-1"></div>
    <div class="bg-shape bg-shape-2"></div>
    <div class="bg-shape bg-shape-3"></div>

    <div style="max-width: 480px; width: 100%; position: relative; z-index: 1;">
        <!-- Main Challenge Card -->
        <div class="challenge-card">
            <!-- Header -->
            <div class="challenge-header">
                <div class="shield-icon-wrapper">
                    <div class="shield-background"></div>
                    <div class="shield-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                </div>
                <h1>Vérification de sécurité</h1>
                <p>Pour protéger votre compte, veuillez entrer le code de vérification à 6 chiffres depuis Google Authenticator</p>
            </div>

            <!-- Body -->
            <div class="challenge-body">
                <!-- Error Alert -->
                @if(session('error'))
                    <div class="alert-error">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('two-factor.verify.login') }}" id="challengeForm">
                    @csrf

                    <div class="code-input-section">
                        <label for="one_time_password" class="input-label">
                            Entrez votre code de vérification
                        </label>

                        <div class="code-input-container">
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
                                inputmode="numeric"
                            >
                        </div>

                        <!-- Digit Indicators -->
                        <div class="digit-indicators">
                            <div class="digit-indicator" data-digit="0"></div>
                            <div class="digit-indicator" data-digit="1"></div>
                            <div class="digit-indicator" data-digit="2"></div>
                            <div class="digit-indicator" data-digit="3"></div>
                            <div class="digit-indicator" data-digit="4"></div>
                            <div class="digit-indicator" data-digit="5"></div>
                        </div>

                        <div class="input-hint">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="timer-icon">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Le code change toutes les 30 secondes</span>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn" id="submitBtn">
                        <div class="spinner"></div>
                        <span class="btn-text">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Vérifier le code</span>
                        </span>
                    </button>
                </form>

                <!-- Footer -->
                <div class="challenge-footer">
                    <p class="footer-text">Vous rencontrez des problèmes ?</p>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Se déconnecter
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="info-card">
            <div class="info-card-content">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Si le code ne fonctionne pas, patientez et utilisez le code suivant</span>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    const codeInput = document.getElementById('one_time_password');
    const submitBtn = document.getElementById('submitBtn');
    const form = document.getElementById('challengeForm');
    const digitIndicators = document.querySelectorAll('.digit-indicator');

    // Update digit indicators
    function updateIndicators(value) {
        digitIndicators.forEach((indicator, index) => {
            if (index < value.length) {
                indicator.classList.add('filled');
            } else {
                indicator.classList.remove('filled');
            }
        });
    }

    // Input handling
    codeInput.addEventListener('input', function(e) {
        // Only allow numbers
        let value = e.target.value.replace(/\D/g, '');
        e.target.value = value;

        // Update indicators
        updateIndicators(value);

        // Enable/disable submit button
        if (value.length === 6) {
            submitBtn.disabled = false;
            // Auto-submit after a short delay
            setTimeout(() => {
                if (codeInput.value.length === 6) {
                    submitBtn.classList.add('loading');
                    form.submit();
                }
            }, 400);
        } else {
            submitBtn.disabled = true;
        }
    });

    // Paste handling
    codeInput.addEventListener('paste', function(e) {
        e.preventDefault();
        const pastedData = (e.clipboardData || window.clipboardData).getData('text');
        const numbers = pastedData.replace(/\D/g, '').substring(0, 6);
        codeInput.value = numbers;
        updateIndicators(numbers);

        if (numbers.length === 6) {
            submitBtn.disabled = false;
            setTimeout(() => {
                submitBtn.classList.add('loading');
                form.submit();
            }, 400);
        }
    });

    // Form submission handling
    form.addEventListener('submit', function(e) {
        if (codeInput.value.length !== 6) {
            e.preventDefault();
            codeInput.focus();

            // Shake animation for invalid input
            codeInput.style.animation = 'shake 0.5s ease';
            codeInput.style.borderColor = '#ef4444';

            setTimeout(() => {
                codeInput.style.animation = '';
                codeInput.style.borderColor = '#e2e8f0';
            }, 500);
        } else {
            submitBtn.classList.add('loading');
        }
    });

    // Focus input on page load
    window.addEventListener('load', function() {
        codeInput.focus();
    });

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        // Allow Ctrl/Cmd + V for paste
        if ((e.ctrlKey || e.metaKey) && e.key === 'v') {
            return;
        }

        // Allow backspace, delete, arrow keys
        if (['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab'].includes(e.key)) {
            return;
        }

        // Only allow numbers if input is focused
        if (document.activeElement === codeInput) {
            if (!/^\d$/.test(e.key)) {
                e.preventDefault();
            }
        }
    });
})();
</script>
</body>
</html>
