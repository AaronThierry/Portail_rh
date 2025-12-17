<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mot de passe oublié - Portail RH+</title>
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
            background: var(--accent);
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
            background: linear-gradient(135deg, var(--accent) 0%, #E67E00 100%);
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

        .alert-success {
            background: linear-gradient(135deg, #D1FAE5 0%, #A7F3D0 100%);
            color: #065F46;
            border: 1px solid #6EE7B7;
        }

        .alert-error {
            background: linear-gradient(135deg, #FEE2E2 0%, #FECACA 100%);
            color: #991B1B;
            border: 1px solid #FCA5A5;
        }

        /* Form */
        .form-group {
            margin-bottom: 1.5rem;
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
            padding: 0.9375rem 1rem 0.9375rem 3rem;
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
            border-color: var(--accent);
            background: white;
            box-shadow: 0 0 0 4px rgba(255, 149, 0, 0.1);
        }

        .form-input:focus + .input-icon,
        .input-wrapper:focus-within .input-icon {
            color: var(--accent);
        }

        .form-input::placeholder {
            color: #9CA3AF;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 1rem;
            font-size: 1rem;
            font-weight: 700;
            color: white;
            background: linear-gradient(135deg, var(--accent) 0%, #E67E00 100%);
            border: none;
            border-radius: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.625rem;
            transition: all 0.3s ease;
            box-shadow: 0 8px 24px rgba(255, 149, 0, 0.35);
            margin-bottom: 1.25rem;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(255, 149, 0, 0.45);
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

        /* Back Link */
        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--primary);
            text-decoration: none;
            padding: 0.75rem;
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .back-link:hover {
            background: var(--primary-light);
            color: var(--primary-dark);
        }

        .back-link svg {
            width: 18px;
            height: 18px;
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

        /* Info Box */
        .info-box {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 1rem;
            background: var(--primary-light);
            border-radius: 14px;
            margin-bottom: 1.5rem;
        }

        .info-box svg {
            width: 20px;
            height: 20px;
            color: var(--primary);
            flex-shrink: 0;
            margin-top: 0.125rem;
        }

        .info-box p {
            font-size: 0.8125rem;
            color: var(--primary-dark);
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
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                </div>
                <h1>Mot de passe oublié ?</h1>
                <p>Entrez votre e-mail pour recevoir un code de réinitialisation</p>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                <!-- Success Alert -->
                @if(session('success'))
                <div class="alert alert-success">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

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

                <!-- Info Box -->
                <div class="info-box">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    <p>Un code de vérification sera envoyé à votre adresse e-mail. Vérifiez également vos spams.</p>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('password.send.code') }}">
                    @csrf

                    <!-- Email Field -->
                    <div class="form-group">
                        <label for="email" class="form-label">Adresse e-mail</label>
                        <div class="input-wrapper">
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-input"
                                value="{{ old('email') }}"
                                placeholder="votre.email@entreprise.com"
                                autocomplete="email"
                                required
                                autofocus
                            >
                            <span class="input-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                            </span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit">
                        <span>Envoyer le code</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <line x1="22" y1="2" x2="11" y2="13"></line>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                        </svg>
                    </button>

                    <!-- Back Link -->
                    <a href="{{ route('login') }}" class="back-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                        Retour à la connexion
                    </a>
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
</body>
</html>
