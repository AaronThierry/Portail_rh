<header class="app-header">
    <div class="header-container">
        <!-- Mobile Menu Button - Only visible on mobile -->
        <button class="mobile-menu-btn" id="mobileMenuButton" aria-label="Toggle menu">
            <span class="burger-line"></span>
            <span class="burger-line"></span>
            <span class="burger-line"></span>
        </button>

        <!-- Page Title - Dynamic -->
        <div class="header-title">
            <h1 class="page-title">@yield('page-title', 'Tableau de bord')</h1>
        </div>

        <div class="header-actions">
        <!-- Theme Toggle -->
        <button class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" data-theme-toggle aria-label="Changer le thème">
            <svg class="w-5 h-5 hidden dark:block" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 17.5C9.5 17.5 7.5 15.5 7.5 13S9.5 8.5 12 8.5s4.5 2 4.5 4.5-2 4.5-4.5 4.5zm0-7c-1.4 0-2.5 1.1-2.5 2.5s1.1 2.5 2.5 2.5 2.5-1.1 2.5-2.5-1.1-2.5-2.5-2.5z"/>
            </svg>
            <svg class="w-5 h-5 block dark:hidden" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9 9-4.03 9-9c0-.46-.04-.92-.1-1.36-.98 1.37-2.58 2.26-4.4 2.26-2.98 0-5.4-2.42-5.4-5.4 0-1.81.89-3.42 2.26-4.4-.44-.06-.9-.1-1.36-.1z"/>
            </svg>
        </button>

        <!-- Notifications -->
        <div class="relative">
            <button class="relative p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" id="notificationBtn" aria-label="Notifications">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>

            <!-- Notification Dropdown (hidden by default) -->
            <div class="hidden absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-xl shadow-xl dark:shadow-2xl border-2 border-gray-200 dark:border-gray-600 overflow-hidden z-50" id="notificationDropdown">
                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-900 border-b-2 border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <h3 class="font-bold text-gray-900 dark:text-white">Notifications</h3>
                    <button class="text-xs text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 hover:underline font-medium">Tout marquer comme lu</button>
                </div>
                <div class="max-h-96 overflow-y-auto custom-scrollbar">
                    <a href="/notifications/1" class="flex gap-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700 transition-colors">
                        <div class="flex-shrink-0 w-8 h-8 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Nouvelle demande de congé</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate">Jean Dupont a soumis une demande</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Il y a 5 minutes</p>
                        </div>
                    </a>
                    <a href="/notifications/2" class="flex gap-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700 transition-colors">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="16" x2="12" y2="12"></line>
                                <line x1="12" y1="8" x2="12.01" y2="8"></line>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Rappel de réunion</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate">Réunion d'équipe dans 30 minutes</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Il y a 25 minutes</p>
                        </div>
                    </a>
                </div>
                <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700 text-center">
                    <a href="/notifications" class="text-sm text-primary-600 dark:text-primary-400 hover:underline font-medium">Voir toutes les notifications</a>
                </div>
            </div>
        </div>

        <!-- User Profile -->
        <div class="relative">
            <button class="flex items-center gap-2 p-1 pr-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" id="userMenuBtn" aria-label="Menu utilisateur">
                <img src="{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name ?? 'User') . '&background=3b82f6&color=fff' }}" alt="Avatar" class="w-8 h-8 rounded-full">
                <span class="hidden lg:block text-sm font-medium text-gray-700 dark:text-gray-200">{{ auth()->user()->name ?? 'Admin' }}</span>
                <svg class="hidden lg:block w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>

            <!-- User Dropdown (hidden by default) -->
            <div class="hidden absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-xl dark:shadow-2xl border-2 border-gray-200 dark:border-gray-600 overflow-hidden z-50" id="userDropdown">
                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-900 border-b-2 border-gray-200 dark:border-gray-700">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ auth()->user()->name ?? 'Utilisateur' }}</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400 truncate">{{ auth()->user()->email ?? 'admin@example.com' }}</p>
                </div>
                <div class="py-2">
                    <a href="/profile" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        Mon profil
                    </a>
                    <a href="/settings" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M12 1v6m0 6v6m5.657-13.657l-4.243 4.243m-2.828 2.828l-4.243 4.243m16.97 1.414l-4.243-4.243m-2.828-2.828l-4.243-4.243"></path>
                        </svg>
                        Paramètres
                    </a>
                    <a href="/help" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                            <line x1="12" y1="17" x2="12.01" y2="17"></line>
                        </svg>
                        Aide
                    </a>
                </div>
                <div class="border-t-2 border-gray-200 dark:border-gray-700">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-700 dark:hover:text-red-300 transition-colors">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    // Dropdown functionality
    document.getElementById('notificationBtn')?.addEventListener('click', function(e) {
        e.stopPropagation();
        const dropdown = document.getElementById('notificationDropdown');
        dropdown.classList.toggle('hidden');
        document.getElementById('userDropdown')?.classList.add('hidden');
    });

    document.getElementById('userMenuBtn')?.addEventListener('click', function(e) {
        e.stopPropagation();
        const dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('hidden');
        document.getElementById('notificationDropdown')?.classList.add('hidden');
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function() {
        document.getElementById('notificationDropdown')?.classList.add('hidden');
        document.getElementById('userDropdown')?.classList.add('hidden');
    });
</script>
