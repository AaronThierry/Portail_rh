<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Changement de mot de passe requis - Portail RH</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 500px;
        }

        .card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: slideUp 0.5s ease;
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
            padding: 40px 30px;
            text-align: center;
            color: white;
        }

        .lock-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .lock-icon svg {
            width: 40px;
            height: 40px;
        }

        .card-header h1 {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 10px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .card-header p {
            font-size: 16px;
            opacity: 0.95;
            line-height: 1.5;
        }

        .card-body {
            padding: 40px 30px;
        }

        .alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            font-size: 15px;
            line-height: 1.5;
        }

        .alert-warning {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(217, 119, 6, 0.1) 100%);
            border-left: 4px solid #f59e0b;
            color: #92400e;
        }

        .alert-info {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(37, 99, 235, 0.1) 100%);
            border-left: 4px solid #3b82f6;
            color: #1e40af;
        }

        .alert-error {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(220, 38, 38, 0.1) 100%);
            border-left: 4px solid #ef4444;
            color: #991b1b;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 15px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 10px;
            letter-spacing: 0.3px;
        }

        .form-label.required::after {
            content: '*';
            color: #ef4444;
            margin-left: 6px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 14px 48px 14px 18px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .form-input.error {
            border-color: #ef4444;
            background: rgba(239, 68, 68, 0.05);
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #64748b;
            padding: 8px;
            transition: color 0.2s ease;
        }

        .toggle-password:hover {
            color: #667eea;
        }

        .error-message {
            color: #ef4444;
            font-size: 13px;
            margin-top: 6px;
            display: none;
        }

        .error-message.show {
            display: block;
        }

        .password-requirements {
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            margin-top: 30px;
        }

        .password-requirements h3 {
            font-size: 15px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 12px;
        }

        .password-requirements ul {
            list-style: none;
            padding: 0;
        }

        .password-requirements li {
            font-size: 14px;
            color: #64748b;
            padding: 6px 0;
            padding-left: 25px;
            position: relative;
        }

        .password-requirements li::before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #10b981;
            font-weight: bold;
        }

        .btn {
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 30px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.5);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .logout-link {
            text-align: center;
            margin-top: 20px;
        }

        .logout-link a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .logout-link a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .card-header {
                padding: 30px 20px;
            }

            .card-body {
                padding: 30px 20px;
            }

            .card-header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="lock-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                </div>
                <h1>Changement de mot de passe requis</h1>
                <p>Pour votre sécurité, vous devez changer votre mot de passe temporaire avant de continuer</p>
            </div>

            <div class="card-body">
                @if(session('info'))
                <div class="alert alert-info">
                    {{ session('info') }}
                </div>
                @endif

                @if(session('warning'))
                <div class="alert alert-warning">
                    ⚠️ {{ session('warning') }}
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-error">
                    <strong>Erreur :</strong>
                    <ul style="margin-top: 8px; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('password.update-first') }}" method="POST" id="passwordForm">
                    @csrf

                    <div class="form-group">
                        <label for="current_password" class="form-label required">Mot de passe actuel (temporaire)</label>
                        <div class="input-wrapper">
                            <input type="password" id="current_password" name="current_password" class="form-input" required autofocus>
                            <button type="button" class="toggle-password" onclick="togglePassword('current_password')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path class="eye-open" d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle class="eye-open" cx="12" cy="12" r="3"></circle>
                                    <path class="eye-closed" d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" style="display:none;"></path>
                                    <line class="eye-closed" x1="1" y1="1" x2="23" y2="23" style="display:none;"></line>
                                </svg>
                            </button>
                        </div>
                        <span class="error-message" id="error-current_password"></span>
                    </div>

                    <div class="form-group">
                        <label for="new_password" class="form-label required">Nouveau mot de passe</label>
                        <div class="input-wrapper">
                            <input type="password" id="new_password" name="new_password" class="form-input" required>
                            <button type="button" class="toggle-password" onclick="togglePassword('new_password')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path class="eye-open" d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle class="eye-open" cx="12" cy="12" r="3"></circle>
                                    <path class="eye-closed" d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" style="display:none;"></path>
                                    <line class="eye-closed" x1="1" y1="1" x2="23" y2="23" style="display:none;"></line>
                                </svg>
                            </button>
                        </div>
                        <span class="error-message" id="error-new_password"></span>
                    </div>

                    <div class="form-group">
                        <label for="new_password_confirmation" class="form-label required">Confirmer le nouveau mot de passe</label>
                        <div class="input-wrapper">
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-input" required>
                            <button type="button" class="toggle-password" onclick="togglePassword('new_password_confirmation')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path class="eye-open" d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle class="eye-open" cx="12" cy="12" r="3"></circle>
                                    <path class="eye-closed" d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" style="display:none;"></path>
                                    <line class="eye-closed" x1="1" y1="1" x2="23" y2="23" style="display:none;"></line>
                                </svg>
                            </button>
                        </div>
                        <span class="error-message" id="error-new_password_confirmation"></span>
                    </div>

                    <div class="password-requirements">
                        <h3>🔒 Exigences du mot de passe</h3>
                        <ul>
                            <li>Au moins 8 caractères</li>
                            <li>Contenir des lettres majuscules et minuscules</li>
                            <li>Contenir au moins un chiffre</li>
                            <li>Contenir au moins un caractère spécial</li>
                            <li>Être différent de votre mot de passe actuel</li>
                        </ul>
                    </div>

                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        Changer mon mot de passe
                    </button>
                </form>

                <div class="logout-link">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Me déconnecter
                    </a>
                </div>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const button = field.nextElementSibling;
            const eyeOpen = button.querySelectorAll('.eye-open');
            const eyeClosed = button.querySelectorAll('.eye-closed');

            if (field.type === 'password') {
                field.type = 'text';
                eyeOpen.forEach(el => el.style.display = 'none');
                eyeClosed.forEach(el => el.style.display = 'block');
            } else {
                field.type = 'password';
                eyeOpen.forEach(el => el.style.display = 'block');
                eyeClosed.forEach(el => el.style.display = 'none');
            }
        }

        // Validation du formulaire
        document.getElementById('passwordForm').addEventListener('submit', function(e) {
            let isValid = true;

            // Réinitialiser les erreurs
            document.querySelectorAll('.error-message').forEach(el => {
                el.classList.remove('show');
                el.textContent = '';
            });
            document.querySelectorAll('.form-input').forEach(el => {
                el.classList.remove('error');
            });

            // Valider les champs
            const currentPassword = document.getElementById('current_password');
            const newPassword = document.getElementById('new_password');
            const confirmPassword = document.getElementById('new_password_confirmation');

            if (!currentPassword.value) {
                showError('current_password', 'Le mot de passe actuel est requis');
                isValid = false;
            }

            if (!newPassword.value) {
                showError('new_password', 'Le nouveau mot de passe est requis');
                isValid = false;
            } else if (newPassword.value.length < 8) {
                showError('new_password', 'Le mot de passe doit contenir au moins 8 caractères');
                isValid = false;
            }

            if (!confirmPassword.value) {
                showError('new_password_confirmation', 'Veuillez confirmer le mot de passe');
                isValid = false;
            } else if (newPassword.value !== confirmPassword.value) {
                showError('new_password_confirmation', 'Les mots de passe ne correspondent pas');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
            }
        });

        function showError(fieldId, message) {
            const field = document.getElementById(fieldId);
            const error = document.getElementById('error-' + fieldId);
            field.classList.add('error');
            error.textContent = message;
            error.classList.add('show');
        }
    </script>
</body>
</html>
