<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nouveau mot de passe - Portail RH+</title>
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
            max-width: 440px;
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
            background: linear-gradient(135deg, var(--success) 0%, #16A34A 100%);
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
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 60%);
            pointer-events: none;
        }

        .header-icon {
            width: 64px;
            height: 64px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .header-icon svg {
            width: 32px;
            height: 32px;
            color: white;
        }

        .card-header h1 {
            font-size: 1.375rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.375rem;
        }

        .card-header p {
            font-size: 0.875rem;
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

        /* Form */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            transition: color 0.3s ease;
            pointer-events: none;
        }

        .input-icon svg {
            width: 20px;
            height: 20px;
        }

        .form-input {
            width: 100%;
            padding: 0.9375rem 3rem 0.9375rem 3rem;
            font-size: 0.9375rem;
            font-weight: 500;
            color: var(--text-dark);
            background: var(--bg-light);
            border: 2px solid var(--border);
            border-radius: 14px;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: var(--success);
            background: white;
            box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.1);
        }

        .form-input:focus + .input-icon,
        .input-wrapper:focus-within .input-icon {
            color: var(--success);
        }

        .form-input::placeholder {
            color: #9CA3AF;
        }

        .form-input:disabled {
            background: var(--border);
            color: var(--text-muted);
            cursor: not-allowed;
        }

        /* Password Toggle */
        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .password-toggle:hover {
            color: var(--success);
            background: rgba(34, 197, 94, 0.1);
        }

        .password-toggle svg {
            width: 20px;
            height: 20px;
        }

        /* Password Strength */
        .password-strength {
            margin-top: 0.5rem;
        }

        .strength-bar {
            display: flex;
            gap: 4px;
            margin-bottom: 0.375rem;
        }

        .strength-segment {
            flex: 1;
            height: 4px;
            background: var(--border);
            border-radius: 2px;
            transition: background 0.3s ease;
        }

        .strength-segment.active.weak { background: var(--danger); }
        .strength-segment.active.medium { background: var(--accent); }
        .strength-segment.active.strong { background: var(--success); }

        .strength-text {
            font-size: 0.75rem;
            font-weight: 500;
            text-align: right;
        }

        .strength-text.weak { color: var(--danger); }
        .strength-text.medium { color: var(--accent); }
        .strength-text.strong { color: var(--success); }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 1rem;
            font-size: 1rem;
            font-weight: 700;
            color: white;
            background: linear-gradient(135deg, var(--success) 0%, #16A34A 100%);
            border: none;
            border-radius: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.625rem;
            transition: all 0.3s ease;
            box-shadow: 0 8px 24px rgba(34, 197, 94, 0.35);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(34, 197, 94, 0.45);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit svg {
            width: 20px;
            height: 20px;
            transition: transform 0.3s ease;
        }

        .btn-submit:hover svg {
            transform: translateX(4px);
        }

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
        }

        .footer-text strong {
            color: var(--primary);
            font-weight: 700;
        }

        /* Email Display */
        .email-display {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            background: var(--primary-light);
            border-radius: 14px;
            margin-bottom: 1.25rem;
        }

        .email-display svg {
            width: 20px;
            height: 20px;
            color: var(--primary);
            flex-shrink: 0;
        }

        .email-display span {
            font-size: 0.9375rem;
            font-weight: 600;
            color: var(--primary-dark);
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
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        <circle cx="12" cy="16" r="1"></circle>
                    </svg>
                </div>
                <h1>Nouveau mot de passe</h1>
                <p>Choisissez un mot de passe sécurisé pour votre compte</p>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                <!-- Error Alert -->
                @if($errors->any())
                <div class="alert alert-error">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                    <span>{{ $errors->first() }}</span>
                </div>
                @endif

                <!-- Email Display -->
                <div class="email-display">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    <span>{{ $email }}</span>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">

                    <!-- New Password Field -->
                    <div class="form-group">
                        <label for="password" class="form-label">Nouveau mot de passe</label>
                        <div class="input-wrapper">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-input"
                                placeholder="Entrez votre nouveau mot de passe"
                                autocomplete="new-password"
                                minlength="6"
                                required
                                autofocus
                            >
                            <span class="input-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </span>
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <svg id="eye-icon-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                        <div class="password-strength" id="strengthIndicator">
                            <div class="strength-bar">
                                <div class="strength-segment" data-i="1"></div>
                                <div class="strength-segment" data-i="2"></div>
                                <div class="strength-segment" data-i="3"></div>
                                <div class="strength-segment" data-i="4"></div>
                            </div>
                            <div class="strength-text" id="strengthText"></div>
                        </div>
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                        <div class="input-wrapper">
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="form-input"
                                placeholder="Confirmez votre mot de passe"
                                autocomplete="new-password"
                                minlength="6"
                                required
                            >
                            <span class="input-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </span>
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                <svg id="eye-icon-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit">
                        <span>Réinitialiser le mot de passe</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Card Footer -->
            <div class="card-footer">
                <p class="footer-text">
                    &copy; {{ date('Y') }} <strong>Portail RH+</strong> &bull; Tous droits réservés
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const iconNum = inputId === 'password' ? '1' : '2';
            const icon = document.getElementById('eye-icon-' + iconNum);

            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
            }
        }

        // Password strength indicator
        const passwordInput = document.getElementById('password');
        const strengthText = document.getElementById('strengthText');
        const segments = document.querySelectorAll('.strength-segment');

        passwordInput.addEventListener('input', function() {
            const val = this.value;
            let strength = 0;
            let level = '';

            if (val.length >= 6) strength++;
            if (val.length >= 8) strength++;
            if (/[A-Z]/.test(val) && /[a-z]/.test(val)) strength++;
            if (/[0-9]/.test(val)) strength++;
            if (/[^A-Za-z0-9]/.test(val)) strength++;

            segments.forEach((seg, i) => {
                seg.classList.remove('active', 'weak', 'medium', 'strong');
            });

            if (val.length === 0) {
                strengthText.textContent = '';
                return;
            }

            if (strength <= 2) {
                level = 'weak';
                strengthText.textContent = 'Faible';
                for (let i = 0; i < 1; i++) segments[i].classList.add('active', level);
            } else if (strength <= 3) {
                level = 'medium';
                strengthText.textContent = 'Moyen';
                for (let i = 0; i < 2; i++) segments[i].classList.add('active', level);
            } else {
                level = 'strong';
                strengthText.textContent = 'Fort';
                for (let i = 0; i < 4; i++) segments[i].classList.add('active', level);
            }

            strengthText.className = 'strength-text ' + level;
        });
    </script>
</body>
</html>
