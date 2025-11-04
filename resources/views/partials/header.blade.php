<header class="dashboard-header">
    <div class="header-left">
        <!-- Mobile Menu Toggle -->
        <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Toggle menu">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>

        <!-- Search Bar -->
        <div class="search-container">
            <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
            <input type="search" class="search-input" placeholder="Rechercher un employé, document..." id="headerSearch">
            <kbd class="search-shortcut">Ctrl K</kbd>
        </div>
    </div>

    <div class="header-right">
        <!-- Theme Toggle -->
        <button class="header-btn theme-toggle-btn" id="themeToggle" aria-label="Changer le thème">
            <svg class="icon sun-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                <path fill="currentColor" d="M12 17.5C9.5 17.5 7.5 15.5 7.5 13S9.5 8.5 12 8.5s4.5 2 4.5 4.5-2 4.5-4.5 4.5zm0-7c-1.4 0-2.5 1.1-2.5 2.5s1.1 2.5 2.5 2.5 2.5-1.1 2.5-2.5-1.1-2.5-2.5-2.5zM13 5.08V2h-2v3.08c.3-.05.66-.08 1-.08s.7.03 1 .08zm-1 13.84c-.34 0-.7-.03-1-.08V22h2v-3.08c-.3.05-.66.08-1 .08zM5.08 11H2v2h3.08c-.05-.3-.08-.66-.08-1s.03-.7.08-1zm13.84 1c0 .34-.03.7-.08 1H22v-2h-3.08c.05.3.08.66.08 1zm-2.96 6.31l2.17 2.17 1.42-1.42-2.17-2.17c-.37.48-.84.9-1.42 1.42zM6.05 6.05L3.88 3.88 2.46 5.3l2.17 2.17c.37-.48.84-.9 1.42-1.42zm9.78.32l2.17-2.17-1.42-1.41-2.17 2.17c.48.37.9.84 1.42 1.41zM7.76 17.66l-2.17 2.17 1.41 1.41 2.17-2.17c-.48-.37-.9-.84-1.41-1.41z"/>
            </svg>
            <svg class="icon moon-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                <path fill="currentColor" d="M12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9 9-4.03 9-9c0-.46-.04-.92-.1-1.36-.98 1.37-2.58 2.26-4.4 2.26-2.98 0-5.4-2.42-5.4-5.4 0-1.81.89-3.42 2.26-4.4-.44-.06-.9-.1-1.36-.1z"/>
            </svg>
        </button>

        <!-- Notifications -->
        <div class="header-dropdown">
            <button class="header-btn notification-btn" id="notificationBtn" aria-label="Notifications">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
                <span class="notification-badge">3</span>
            </button>

            <div class="dropdown-menu notification-dropdown" id="notificationDropdown">
                <div class="dropdown-header">
                    <h3>Notifications</h3>
                    <button class="mark-read-btn">Tout marquer comme lu</button>
                </div>
                <div class="notification-list">
                    <div class="notification-item unread">
                        <div class="notification-icon success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </div>
                        <div class="notification-content">
                            <p class="notification-title">Nouvelle demande de congé</p>
                            <p class="notification-text">Jean Dupont a soumis une demande de congé</p>
                            <span class="notification-time">Il y a 5 minutes</span>
                        </div>
                    </div>
                    <div class="notification-item unread">
                        <div class="notification-icon info">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="16" x2="12" y2="12"></line>
                                <line x1="12" y1="8" x2="12.01" y2="8"></line>
                            </svg>
                        </div>
                        <div class="notification-content">
                            <p class="notification-title">Rappel de réunion</p>
                            <p class="notification-text">Réunion d'équipe dans 30 minutes</p>
                            <span class="notification-time">Il y a 25 minutes</span>
                        </div>
                    </div>
                    <div class="notification-item">
                        <div class="notification-icon warning">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                                <line x1="12" y1="9" x2="12" y2="13"></line>
                                <line x1="12" y1="17" x2="12.01" y2="17"></line>
                            </svg>
                        </div>
                        <div class="notification-content">
                            <p class="notification-title">Document à signer</p>
                            <p class="notification-text">2 documents en attente de signature</p>
                            <span class="notification-time">Il y a 2 heures</span>
                        </div>
                    </div>
                </div>
                <div class="dropdown-footer">
                    <a href="/notifications">Voir toutes les notifications</a>
                </div>
            </div>
        </div>

        <!-- User Profile -->
        <div class="header-dropdown">
            <button class="header-btn user-btn" id="userMenuBtn" aria-label="Menu utilisateur">
                <img src="{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name ?? 'User') . '&background=3b82f6&color=fff' }}" alt="Avatar" class="user-avatar">
                <span class="user-name">{{ auth()->user()->name ?? 'Admin' }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>

            <div class="dropdown-menu user-dropdown" id="userDropdown">
                <div class="user-info">
                    <img src="{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name ?? 'User') . '&background=3b82f6&color=fff' }}" alt="Avatar" class="user-avatar-large">
                    <div class="user-details">
                        <p class="user-fullname">{{ auth()->user()->name ?? 'Utilisateur' }}</p>
                        <p class="user-email">{{ auth()->user()->email ?? 'admin@example.com' }}</p>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <a href="{{ route('profile') }}" class="dropdown-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    Mon profil
                </a>
                <a href="/settings" class="dropdown-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M12 1v6m0 6v6m5.657-13.657l-4.243 4.243m-2.828 2.828l-4.243 4.243m16.97 1.414l-4.243-4.243m-2.828-2.828l-4.243-4.243"></path>
                    </svg>
                    Paramètres
                </a>
                <a href="/help" class="dropdown-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                    Aide
                </a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                    @csrf
                    <button type="submit" class="dropdown-item logout-item" style="width: 100%; text-align: left; background: none; cursor: pointer;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
</header>
