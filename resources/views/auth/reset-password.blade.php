<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Réinitialiser le mot de passe - Portail RH</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .bg-pattern {
            background-color: #f8fafc;
            background-image:
                linear-gradient(135deg, rgba(74, 144, 217, 0.03) 0%, transparent 50%),
                linear-gradient(225deg, rgba(147, 51, 234, 0.03) 0%, transparent 50%),
                repeating-linear-gradient(90deg, rgba(74, 144, 217, 0.03) 0px, transparent 1px, transparent 80px, rgba(74, 144, 217, 0.03) 81px),
                repeating-linear-gradient(0deg, rgba(147, 51, 234, 0.03) 0px, transparent 1px, transparent 80px, rgba(147, 51, 234, 0.03) 81px);
        }

        .dark .bg-pattern {
            background-color: #0f172a;
            background-image:
                linear-gradient(135deg, rgba(74, 144, 217, 0.05) 0%, transparent 50%),
                linear-gradient(225deg, rgba(147, 51, 234, 0.05) 0%, transparent 50%),
                repeating-linear-gradient(90deg, rgba(74, 144, 217, 0.05) 0px, transparent 1px, transparent 80px, rgba(74, 144, 217, 0.05) 81px),
                repeating-linear-gradient(0deg, rgba(147, 51, 234, 0.05) 0px, transparent 1px, transparent 80px, rgba(147, 51, 234, 0.05) 81px);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow:
                0 8px 32px 0 rgba(31, 38, 135, 0.1),
                inset 0 1px 0 0 rgba(255, 255, 255, 0.5);
        }

        .dark .glass-card {
            background: rgba(15, 23, 42, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow:
                0 8px 32px 0 rgba(0, 0, 0, 0.3),
                inset 0 1px 0 0 rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="h-full bg-pattern">

    <!-- Theme Toggle Button -->
    <button class="fixed top-8 right-8 p-3.5 glass-card rounded-2xl hover:scale-110 transition-all duration-300 z-50 group" data-theme-toggle aria-label="Changer le thème">
        <svg class="w-6 h-6 text-amber-500 hidden dark:block transition-all duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        <svg class="w-6 h-6 text-primary-600 dark:text-indigo-400 block dark:hidden transition-all duration-300 group-hover:-rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
        </svg>
    </button>

    <div class="relative flex items-center justify-center min-h-screen px-4 py-6 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-6 relative z-10">

            <!-- Logo & Title Section -->
            <div class="text-center space-y-4">
                <div class="inline-flex items-center justify-center relative group">
                    <div class="absolute inset-0 bg-gradient-to-r from-primary-500 via-primary-600 to-primary-700 rounded-3xl blur-2xl opacity-50 group-hover:opacity-75 transition-opacity duration-500"></div>
                    <div class="relative w-20 h-20 bg-gradient-to-br from-primary-500 via-primary-600 to-primary-700 rounded-3xl shadow-2xl flex items-center justify-center transform group-hover:scale-105 transition-all duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-12 h-12 text-white">
                            <path fill="currentColor" d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5zm0 18c-3.31 0-6-2.69-6-6s2.69-6 6-6 6 2.69 6 6-2.69 6-6 6zm0-10c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4z"/>
                        </svg>
                    </div>
                </div>

                <div class="space-y-1">
                    <h1 class="text-4xl font-extrabold">
                        <span class="bg-gradient-to-r from-primary-500 via-primary-600 to-primary-700 bg-clip-text text-transparent">
                            Nouveau mot de passe
                        </span>
                    </h1>
                    <p class="text-base text-gray-600 dark:text-gray-400 font-medium">
                        Entrez votre nouveau mot de passe pour réinitialiser votre compte
                    </p>
                </div>
            </div>

            <!-- Reset Form Card -->
            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-primary-500 via-primary-600 to-primary-700 rounded-3xl blur opacity-25 group-hover:opacity-40 transition duration-500 animate-pulse"></div>

                <div class="relative glass-card rounded-3xl p-6 space-y-6">

                    <!-- Error Messages -->
                    @if($errors->any())
                    <div class="p-4 rounded-2xl bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 border-2 border-red-200 dark:border-red-800">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-red-800 dark:text-red-200">{{ $errors->first() }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Reset Form -->
                    <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                        @csrf

                        <!-- Hidden Token & Email -->
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email }}">

                        <!-- Email Display -->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">
                                Adresse e-mail
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                        <polyline points="22,6 12,13 2,6"></polyline>
                                    </svg>
                                </div>
                                <input
                                    type="email"
                                    value="{{ $email }}"
                                    disabled
                                    class="w-full pl-12 pr-4 py-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 font-medium cursor-not-allowed"
                                >
                            </div>
                        </div>

                        <!-- New Password Field -->
                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">
                                Nouveau mot de passe
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-primary-500 transition-colors duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                </div>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder="Entrez votre nouveau mot de passe"
                                    autocomplete="new-password"
                                    minlength="6"
                                    required
                                    class="w-full pl-12 pr-24 py-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white/50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-4 focus:ring-primary-500/20 focus:border-primary-500 dark:focus:border-primary-500 transition-all duration-300 font-medium"
                                >
                                <button
                                    type="button"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 px-3 py-2 text-xs font-bold text-primary-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors rounded-lg hover:bg-primary-50 dark:hover:bg-blue-900/30"
                                    onclick="togglePassword('password')"
                                >
                                    Afficher
                                </button>
                            </div>
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="space-y-2">
                            <label for="password_confirmation" class="block text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">
                                Confirmer le mot de passe
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-primary-500 transition-colors duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                </div>
                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    placeholder="Confirmez votre nouveau mot de passe"
                                    autocomplete="new-password"
                                    minlength="6"
                                    required
                                    class="w-full pl-12 pr-24 py-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white/50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-4 focus:ring-primary-500/20 focus:border-primary-500 dark:focus:border-primary-500 transition-all duration-300 font-medium"
                                >
                                <button
                                    type="button"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 px-3 py-2 text-xs font-bold text-primary-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors rounded-lg hover:bg-primary-50 dark:hover:bg-blue-900/30"
                                    onclick="togglePassword('password_confirmation')"
                                >
                                    Afficher
                                </button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="group relative w-full overflow-hidden rounded-xl bg-gradient-to-r from-primary-500 via-primary-600 to-primary-700 px-6 py-4 font-bold text-white shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-[1.02] active:scale-[0.98]">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-purple-700 to-pink-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <span class="relative flex items-center justify-center gap-2 text-base">
                                Réinitialiser le mot de passe
                                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    © {{ date('Y') }} <span class="font-bold bg-gradient-to-r from-primary-500 to-purple-600 bg-clip-text text-transparent">Portail RH</span> • Tous droits réservés
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            const passwordInput = document.getElementById(inputId);
            const button = event.target;
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            button.textContent = type === 'password' ? 'Afficher' : 'Masquer';
        }
    </script>
</body>
</html>
