<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vérification 2FA - Portail RH+</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --primary: #4A90D9;
            --primary-dark: #2E6BB3;
            --primary-light: #E8F4FD;
            --accent: #FF9500;
            --success: #22C55E;
            --danger: #EF4444;
            --text-dark: #1F2937;
            --text-muted: #6B7280;
            --border: #E5E7EB;
            --bg-light: #F8FAFC;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 50%, #0F172A 100%);
            padding: 1rem;
            position: relative;
            overflow: hidden;
        }

        /* Animated Background */
        .bg-shapes {
            position: fixed;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
            z-index: 0;
        }

        .bg-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.5;
            animation: float 20s ease-in-out infinite;
        }

        .bg-shape-1 {
            width: 500px;
            height: 500px;
            background: var(--primary);
            top: -150px;
            right: -100px;
        }

        .bg-shape-2 {
            width: 400px;
            height: 400px;
            background: var(--success);
            bottom: -100px;
            left: -80px;
            animation-delay: -5s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(20px, -20px) scale(1.03); }
            50% { transform: translate(-15px, 15px) scale(0.97); }
            75% { transform: translate(15px, 20px) scale(1.01); }
        }

        /* Main Container */
        .auth-container {
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 1;
        }

        /* Card */
        .auth-card {
            background: white;
            border-radius: 28px;
            box-shadow: 0 30px 100px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: card-enter 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes card-enter {
            from { opacity: 0; transform: translateY(30px) scale(0.96); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Card Header */
        .card-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 2rem 2rem 1.75rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
            pointer-events: none;
        }

        .header-icon {
            width: 72px;
            height: 72px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            position: relative;
        }

        .header-icon::after {
            content: '';
            position: absolute;
            inset: -4px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 26px;
            animation: icon-pulse 2s ease-in-out infinite;
        }

        @keyframes icon-pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.5; }
        }

        .header-icon svg {
            width: 36px;
            height: 36px;
            color: white;
        }

        .card-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.375rem;
        }

        .card-header p {
            font-size: 0.9375rem;
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.5;
        }

        /* Card Body */
        .card-body {
            padding: 2rem;
        }

        /* Alert */
        .alert {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            border-radius: 14px;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            animation: shake 0.5s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .alert svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        .alert-error {
            background: linear-gradient(135deg, #FEE2E2 0%, #FECACA 100%);
            color: #991B1B;
            border: 1px solid #FCA5A5;
        }

        /* OTP Input Section */
        .otp-section {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .otp-label {
            display: block;
            font-size: 0.9375rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }

        .otp-input-wrapper {
            position: relative;
            margin-bottom: 0.75rem;
        }

        .otp-input {
            width: 100%;
            padding: 1.25rem;
            text-align: center;
            font-size: 2rem;
            font-weight: 700;
            font-family: 'SF Mono', 'Monaco', 'Courier New', monospace;
            letter-spacing: 12px;
            color: var(--text-dark);
            background: var(--bg-light);
            border: 3px solid var(--border);
            border-radius: 16px;
            transition: all 0.3s ease;
            outline: none;
        }

        .otp-input:focus {
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 4px rgba(74, 144, 217, 0.15);
        }

        .otp-input::placeholder {
            color: #CBD5E1;
            letter-spacing: 8px;
        }

        .otp-input.valid {
            border-color: var(--success);
            background: rgba(34, 197, 94, 0.05);
        }

        .otp-input.invalid {
            border-color: var(--danger);
            animation: shake 0.4s ease;
        }

        /* Digit Indicators */
        .digit-indicators {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-bottom: 1rem;
        }

        .indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--border);
            transition: all 0.2s ease;
        }

        .indicator.filled {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            transform: scale(1.2);
            box-shadow: 0 2px 8px rgba(74, 144, 217, 0.4);
        }

        /* Timer */
        .timer-hint {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 0.8125rem;
            color: var(--text-muted);
        }

        .timer-hint svg {
            width: 16px;
            height: 16px;
            color: var(--accent);
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 1rem;
            font-size: 1rem;
            font-weight: 700;
            color: white;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.625rem;
            transition: all 0.3s ease;
            box-shadow: 0 8px 24px rgba(74, 144, 217, 0.35);
            margin-bottom: 1rem;
        }

        .btn-submit:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(74, 144, 217, 0.45);
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-submit svg {
            width: 20px;
            height: 20px;
        }

        .btn-submit .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            display: none;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .btn-submit.loading .spinner { display: block; }
        .btn-submit.loading .btn-content { display: none; }

        /* Card Footer */
        .card-footer {
            padding: 1.25rem 2rem;
            background: var(--bg-light);
            border-top: 1px solid var(--border);
            text-align: center;
        }

        .footer-text {
            font-size: 0.8125rem;
            color: var(--text-muted);
            margin-bottom: 0.75rem;
        }

        .btn-logout {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1rem;
            background: none;
            border: none;
            color: var(--primary);
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .btn-logout:hover {
            background: var(--primary-light);
            color: var(--primary-dark);
        }

        .btn-logout svg {
            width: 18px;
            height: 18px;
        }

        /* Info Tip */
        .info-tip {
            margin-top: 1rem;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .info-tip svg {
            width: 20px;
            height: 20px;
            color: var(--accent);
            flex-shrink: 0;
        }

        .info-tip span {
            font-size: 0.8125rem;
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.5;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .auth-card {
                border-radius: 24px;
            }

            .card-header {
                padding: 1.5rem 1.5rem 1.25rem;
            }

            .card-body {
                padding: 1.5rem;
            }

            .card-footer {
                padding: 1.125rem 1.5rem;
            }

            .otp-input {
                font-size: 1.75rem;
                letter-spacing: 10px;
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="bg-shapes">
        <div class="bg-shape bg-shape-1"></div>
        <div class="bg-shape bg-shape-2"></div>
    </div>

    <!-- Main Container -->
    <div class="auth-container">
        <div class="auth-card">
            <!-- Card Header -->
            <div class="card-header">
                <div class="header-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        <path d="M9 12l2 2 4-4"></path>
                    </svg>
                </div>
                <h1>Vérification 2FA</h1>
                <p>Entrez le code à 6 chiffres de votre application d'authentification</p>
            </div>

            <!-- Card Body -->
            <div class="card-body">
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

                <!-- Form -->
                <form method="POST" action="{{ route('two-factor.verify.login') }}" id="otpForm">
                    @csrf

                    <!-- OTP Section -->
                    <div class="otp-section">
                        <label class="otp-label">Code de vérification</label>
                        <div class="otp-input-wrapper">
                            <input
                                type="text"
                                name="one_time_password"
                                id="otpInput"
                                class="otp-input"
                                maxlength="6"
                                pattern="[0-9]{6}"
                                placeholder="000000"
                                required
                                autofocus
                                autocomplete="off"
                                inputmode="numeric"
                            >
                        </div>

                        <div class="digit-indicators">
                            <div class="indicator" data-i="0"></div>
                            <div class="indicator" data-i="1"></div>
                            <div class="indicator" data-i="2"></div>
                            <div class="indicator" data-i="3"></div>
                            <div class="indicator" data-i="4"></div>
                            <div class="indicator" data-i="5"></div>
                        </div>

                        <div class="timer-hint">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            <span>Le code expire dans 30 secondes</span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit" id="submitBtn" disabled>
                        <div class="spinner"></div>
                        <span class="btn-content">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Vérifier
                        </span>
                    </button>
                </form>
            </div>

            <!-- Card Footer -->
            <div class="card-footer">
                <p class="footer-text">Un problème avec le code ?</p>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        Se déconnecter
                    </button>
                </form>
            </div>
        </div>

        <!-- Info Tip -->
        <div class="info-tip">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="16" x2="12" y2="12"></line>
                <line x1="12" y1="8" x2="12.01" y2="8"></line>
            </svg>
            <span>Ouvrez Google Authenticator, Authy ou votre application d'authentification pour obtenir le code.</span>
        </div>
    </div>

    <script>
    (function() {
        const input = document.getElementById('otpInput');
        const btn = document.getElementById('submitBtn');
        const form = document.getElementById('otpForm');
        const indicators = document.querySelectorAll('.indicator');

        function updateIndicators(len) {
            indicators.forEach((ind, i) => {
                ind.classList.toggle('filled', i < len);
            });
        }

        input.addEventListener('input', function(e) {
            let val = e.target.value.replace(/\D/g, '');
            e.target.value = val;
            updateIndicators(val.length);

            // Remove error state
            input.classList.remove('invalid');

            if (val.length === 6) {
                btn.disabled = false;
                input.classList.add('valid');
                // Auto-submit after brief delay
                setTimeout(() => {
                    if (input.value.length === 6) {
                        btn.classList.add('loading');
                        form.submit();
                    }
                }, 350);
            } else {
                btn.disabled = true;
                input.classList.remove('valid');
            }
        });

        // Handle paste
        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const pasted = (e.clipboardData || window.clipboardData).getData('text');
            const nums = pasted.replace(/\D/g, '').substring(0, 6);
            input.value = nums;
            updateIndicators(nums.length);

            if (nums.length === 6) {
                btn.disabled = false;
                input.classList.add('valid');
                setTimeout(() => {
                    btn.classList.add('loading');
                    form.submit();
                }, 350);
            }
        });

        form.addEventListener('submit', function(e) {
            if (input.value.length !== 6) {
                e.preventDefault();
                input.classList.add('invalid');
                input.focus();
            } else {
                btn.classList.add('loading');
            }
        });

        // Focus input on load
        input.focus();

        // Only allow numbers
        input.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'v') return;
            if (['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab'].includes(e.key)) return;
            if (!/^\d$/.test(e.key)) e.preventDefault();
        });
    })();
    </script>
</body>
</html>
