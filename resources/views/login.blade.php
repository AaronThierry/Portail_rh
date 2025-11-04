<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion - Portail RH</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
</head>
<body>
    <!-- Theme Toggle Button -->
    <button class="theme-toggle" id="themeToggle" aria-label="Changer le thème">
        <svg class="icon sun-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M12 17.5C9.5 17.5 7.5 15.5 7.5 13S9.5 8.5 12 8.5s4.5 2 4.5 4.5-2 4.5-4.5 4.5zm0-7c-1.4 0-2.5 1.1-2.5 2.5s1.1 2.5 2.5 2.5 2.5-1.1 2.5-2.5-1.1-2.5-2.5-2.5zM13 5.08V2h-2v3.08c.3-.05.66-.08 1-.08s.7.03 1 .08zm-1 13.84c-.34 0-.7-.03-1-.08V22h2v-3.08c-.3.05-.66.08-1 .08zM5.08 11H2v2h3.08c-.05-.3-.08-.66-.08-1s.03-.7.08-1zm13.84 1c0 .34-.03.7-.08 1H22v-2h-3.08c.05.3.08.66.08 1zm-2.96 6.31l2.17 2.17 1.42-1.42-2.17-2.17c-.37.48-.84.9-1.42 1.42zM6.05 6.05L3.88 3.88 2.46 5.3l2.17 2.17c.37-.48.84-.9 1.42-1.42zm9.78.32l2.17-2.17-1.42-1.41-2.17 2.17c.48.37.9.84 1.42 1.41zM7.76 17.66l-2.17 2.17 1.41 1.41 2.17-2.17c-.48-.37-.9-.84-1.41-1.41z"/>
        </svg>
        <svg class="icon moon-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9 9-4.03 9-9c0-.46-.04-.92-.1-1.36-.98 1.37-2.58 2.26-4.4 2.26-2.98 0-5.4-2.42-5.4-5.4 0-1.81.89-3.42 2.26-4.4-.44-.06-.9-.1-1.36-.1z"/>
        </svg>
    </button>

    <div class="container">
        <!-- Logo Section -->
        <div class="logo-section">
            <div class="logo">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5zm0 18c-3.31 0-6-2.69-6-6s2.69-6 6-6 6 2.69 6 6-2.69 6-6 6zm0-10c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4z"/>
                </svg>
            </div>
            <div class="brand-name">Portail RH</div>
        </div>

        <!-- Login Card -->
        <div class="card">
            <header>
                <h1>Bienvenue</h1>
                <p class="subtitle">Connectez-vous pour accéder à votre espace sécurisé</p>
            </header>

            <!-- Alert Box -->
            <div id="alert" class="alert"></div>

            <!-- Login Form -->
            <form id="loginForm" novalidate>
                <!-- Email Field -->
                <div class="form-group">
                    <label for="courrier">Adresse e-mail</label>
                    <div class="input-wrapper">
                        <input
                            type="email"
                            id="courrier"
                            name="courrier"
                            placeholder="votre.email@entreprise.com"
                            autocomplete="email"
                            required
                        >
                    </div>
                    <div class="error-message" id="err-courrier"></div>
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <div class="input-wrapper">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Entrez votre mot de passe"
                            autocomplete="current-password"
                            minlength="6"
                            required
                        >
                        <button
                            type="button"
                            class="toggle-password"
                            id="togglePassword"
                            aria-label="Afficher le mot de passe"
                        >
                            Afficher
                        </button>
                    </div>
                    <div class="error-message" id="err-password"></div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit" id="submitBtn">
                    <span class="btn-text">Se connecter</span>
                    <div class="spinner"></div>
                </button>

                <!-- Footer Links -->
                <div class="footer-links">
                    <a href="/password/reset">Mot de passe oublié ?</a>
                    <span class="divider">•</span>
                    <a href="/signup">Créer un compte</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Custom Scripts -->
    <script src="{{ asset('assets/js/login.js') }}"></script>
</body>
</html>