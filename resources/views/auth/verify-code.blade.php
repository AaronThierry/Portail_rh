<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vérifier le code - Portail RH</title>

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

        .otp-input {
            width: 3.5rem;
            height: 4rem;
            font-size: 1.875rem;
            font-weight: 700;
            text-align: center;
            letter-spacing: 0.05em;
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
                            <path fill="currentColor" d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                        </svg>
                    </div>
                </div>

                <div class="space-y-1">
                    <h1 class="text-4xl font-extrabold">
                        <span class="bg-gradient-to-r from-primary-500 via-primary-600 to-primary-700 bg-clip-text text-transparent">
                            Vérifier votre code
                        </span>
                    </h1>
                    <p class="text-base text-gray-600 dark:text-gray-400 font-medium">
                        Entrez le code de vérification envoyé à<br>
                        <span class="font-bold text-gray-900 dark:text-gray-200">{{ $email }}</span>
                    </p>
                </div>
            </div>

            <!-- Verify Code Form Card -->
            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-primary-500 via-primary-600 to-primary-700 rounded-3xl blur opacity-25 group-hover:opacity-40 transition duration-500 animate-pulse"></div>

                <div class="relative glass-card rounded-3xl p-6 space-y-6">

                    <!-- Success Message -->
                    @if(session('success'))
                    <div class="p-4 rounded-2xl bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border-2 border-green-200 dark:border-green-800">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-green-800 dark:text-green-200">{{ session('success') }}</p>
                        </div>
                    </div>
                    @endif

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

                    <!-- Verify Form -->
                    <form method="POST" action="{{ route('password.verify.code') }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">

                        <!-- OTP Input Fields -->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">
                                Code de vérification (6 chiffres)
                            </label>
                            <div class="flex justify-center gap-2" id="otp-container">
                                <input type="text" maxlength="1" class="otp-input rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white/50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:ring-4 focus:ring-primary-500/20 focus:border-primary-500 transition-all" data-index="0">
                                <input type="text" maxlength="1" class="otp-input rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white/50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:ring-4 focus:ring-primary-500/20 focus:border-primary-500 transition-all" data-index="1">
                                <input type="text" maxlength="1" class="otp-input rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white/50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:ring-4 focus:ring-primary-500/20 focus:border-primary-500 transition-all" data-index="2">
                                <input type="text" maxlength="1" class="otp-input rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white/50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:ring-4 focus:ring-primary-500/20 focus:border-primary-500 transition-all" data-index="3">
                                <input type="text" maxlength="1" class="otp-input rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white/50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:ring-4 focus:ring-primary-500/20 focus:border-primary-500 transition-all" data-index="4">
                                <input type="text" maxlength="1" class="otp-input rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white/50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:ring-4 focus:ring-primary-500/20 focus:border-primary-500 transition-all" data-index="5">
                            </div>
                            <input type="hidden" name="code" id="otp-code" required>
                        </div>

                        <!-- Timer -->
                        <div class="text-center space-y-2">
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Le code expire dans <span id="timer" class="font-bold text-primary-600 dark:text-blue-400">10:00</span>
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="group relative w-full overflow-hidden rounded-xl bg-gradient-to-r from-primary-500 via-primary-600 to-primary-700 px-6 py-4 font-bold text-white shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-[1.02] active:scale-[0.98]">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-purple-700 to-pink-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <span class="relative flex items-center justify-center gap-2 text-base">
                                Vérifier le code
                                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </span>
                        </button>

                        <!-- Resend Link -->
                        <div class="text-center">
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Vous n'avez pas reçu le code ?
                                <button type="button" onclick="resendCode()" id="resend-button" class="font-bold text-primary-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">
                                    Renvoyer
                                </button>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center space-y-3">
                <a href="{{ route('password.request') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-blue-400 font-medium transition-colors">
                    ← Retour à la réinitialisation
                </a>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    © {{ date('Y') }} <span class="font-bold bg-gradient-to-r from-primary-500 to-purple-600 bg-clip-text text-transparent">Portail RH</span> • Tous droits réservés
                </p>
            </div>
        </div>
    </div>

    <script>
        // OTP Input Management
        const otpInputs = document.querySelectorAll('.otp-input');
        const otpCodeInput = document.getElementById('otp-code');

        otpInputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                // Only allow numbers
                e.target.value = e.target.value.replace(/[^0-9]/g, '');

                // Move to next input
                if (e.target.value && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }

                // Update hidden input
                updateOTPCode();
            });

            input.addEventListener('keydown', (e) => {
                // Move to previous input on backspace
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    otpInputs[index - 1].focus();
                }
            });

            // Paste handling
            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pastedData = e.clipboardData.getData('text').replace(/[^0-9]/g, '');
                const digits = pastedData.split('');

                digits.forEach((digit, i) => {
                    if (index + i < otpInputs.length) {
                        otpInputs[index + i].value = digit;
                    }
                });

                // Focus last filled input
                const lastIndex = Math.min(index + digits.length - 1, otpInputs.length - 1);
                otpInputs[lastIndex].focus();

                updateOTPCode();
            });
        });

        function updateOTPCode() {
            const code = Array.from(otpInputs).map(input => input.value).join('');
            otpCodeInput.value = code;
        }

        // Timer countdown
        let timeLeft = 600; // 10 minutes in seconds
        const timerDisplay = document.getElementById('timer');

        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerDisplay.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;

            if (timeLeft > 0) {
                timeLeft--;
            } else {
                timerDisplay.textContent = 'Expiré';
                timerDisplay.classList.add('text-red-600');
            }
        }

        setInterval(updateTimer, 1000);

        // Resend code function
        function resendCode() {
            const button = document.getElementById('resend-button');
            button.disabled = true;
            button.textContent = 'Envoi...';

            fetch('{{ route('password.resend') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ email: '{{ $email }}' })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Un nouveau code a été envoyé à votre adresse e-mail.');
                    timeLeft = 600; // Reset timer
                    button.disabled = false;
                    button.textContent = 'Renvoyer';
                } else {
                    alert('Erreur lors de l\'envoi du code.');
                    button.disabled = false;
                    button.textContent = 'Renvoyer';
                }
            })
            .catch(error => {
                alert('Erreur de connexion.');
                button.disabled = false;
                button.textContent = 'Renvoyer';
            });
        }

        // Focus first input on load
        otpInputs[0].focus();
    </script>
</body>
</html>
