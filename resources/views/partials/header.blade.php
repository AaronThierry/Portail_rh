<header class="app-header">
    <div class="header-container">
        <!-- Mobile Menu Button - Premium Design -->
        <button class="mobile-menu-btn" id="mobileMenuButton" aria-label="Toggle menu">
            <svg class="burger-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line class="burger-line line-top" x1="4" y1="6" x2="20" y2="6"></line>
                <line class="burger-line line-middle" x1="4" y1="12" x2="20" y2="12"></line>
                <line class="burger-line line-bottom" x1="4" y1="18" x2="16" y2="18"></line>
            </svg>
        </button>

        <!-- Page Title - Dynamic with Animation -->
        <div class="header-title">
            <div class="page-title-wrapper">
                <div class="page-title-icon">
                    @yield('page-icon')
                </div>
                <div class="page-title-content">
                    <h1 class="page-title">@yield('page-title', 'Tableau de bord')</h1>
                    @hasSection('page-subtitle')
                    <p class="page-subtitle">@yield('page-subtitle')</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Header Actions -->
        <div class="header-actions">
            <!-- Theme Toggle - Elegant -->
            <button class="header-action-btn theme-toggle" data-theme-toggle aria-label="Changer le thème">
                <div class="theme-icon-wrapper">
                    <svg class="theme-icon sun-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="5"></circle>
                        <line x1="12" y1="1" x2="12" y2="3"></line>
                        <line x1="12" y1="21" x2="12" y2="23"></line>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                        <line x1="1" y1="12" x2="3" y2="12"></line>
                        <line x1="21" y1="12" x2="23" y2="12"></line>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                    </svg>
                    <svg class="theme-icon moon-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                    </svg>
                </div>
            </button>

            <!-- Notifications - Premium Design (AJAX) -->
            <div class="header-dropdown-wrapper">
                <button class="header-action-btn notification-btn" id="notificationBtn" aria-label="Notifications">
                    <svg class="action-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    <span class="notification-badge pulse" id="adminNotifBadge" style="display:none;">0</span>
                </button>

                <!-- Notification Dropdown -->
                <div class="header-dropdown notification-dropdown" id="notificationDropdown">
                    <div class="dropdown-header">
                        <div class="dropdown-header-content">
                            <h3 class="dropdown-title">Notifications</h3>
                            <span class="notification-count" id="adminNotifCount">0 nouvelles</span>
                        </div>
                        <button class="mark-all-read" id="adminMarkAllRead">Tout marquer comme lu</button>
                    </div>
                    <div class="dropdown-body custom-scrollbar" id="adminNotifList">
                        <div style="padding: 2rem; text-align: center; color: var(--text-muted, #6B7280); font-size: 0.875rem;">Aucune notification</div>
                    </div>
                    <div class="dropdown-footer">
                        <a href="{{ route('admin.conges.index') }}" class="view-all-link">
                            <span>Voir les demandes de congés</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- User Profile - Elegant Design -->
            <div class="header-dropdown-wrapper">
                <button class="user-profile-btn" id="userMenuBtn" aria-label="Menu utilisateur">
                    <div class="user-avatar-wrapper">
                        <img src="{{ auth()->user()->avatar ? asset(str_starts_with(auth()->user()->avatar, 'storage/') ? auth()->user()->avatar : 'storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name ?? 'User') . '&background=4A90D9&color=fff&bold=true' }}" alt="Avatar" class="user-avatar">
                        <span class="user-status online"></span>
                    </div>
                    <div class="user-info">
                        <span class="user-name">{{ auth()->user()->name ?? 'Admin' }}</span>
                        <span class="user-role">{{ auth()->user()->roles->first()->name ?? 'Utilisateur' }}</span>
                    </div>
                    <svg class="dropdown-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>

                <!-- User Dropdown - Elegant Pro Design -->
                <div class="header-dropdown user-dropdown" id="userDropdown">
                    <!-- User Card Header -->
                    <div class="ud-card">
                        <div class="ud-card-bg"></div>
                        <div class="ud-card-content">
                            <div class="ud-avatar-section">
                                <img src="{{ auth()->user()->avatar ? asset(str_starts_with(auth()->user()->avatar, 'storage/') ? auth()->user()->avatar : 'storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name ?? 'User') . '&background=4A90D9&color=fff&bold=true&size=96' }}" alt="Avatar" class="ud-avatar">
                                <span class="ud-status-dot"></span>
                            </div>
                            <div class="ud-user-details">
                                <h4 class="ud-name">{{ auth()->user()->name ?? 'Utilisateur' }}</h4>
                                <p class="ud-email">{{ auth()->user()->email ?? 'admin@example.com' }}</p>
                                <span class="ud-role-badge">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                    </svg>
                                    {{ auth()->user()->roles->first()->name ?? 'Utilisateur' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="ud-actions">
                        <a href="{{ route('admin.profile.index') }}" class="ud-action-item">
                            <div class="ud-action-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <div class="ud-action-text">
                                <span class="ud-action-title">Mon Profil</span>
                                <span class="ud-action-desc">Gérer mon compte</span>
                            </div>
                            <svg class="ud-action-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </a>
                        <a href="{{ route('admin.settings.index') }}" class="ud-action-item">
                            <div class="ud-action-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                </svg>
                            </div>
                            <div class="ud-action-text">
                                <span class="ud-action-title">Paramètres</span>
                                <span class="ud-action-desc">Configuration système</span>
                            </div>
                            <svg class="ud-action-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </a>
                    </div>

                    <!-- Logout Section -->
                    <div class="ud-logout-section">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="ud-logout-btn">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                                <span>Déconnexion</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<style>
/* ==================== HEADER PREMIUM STYLES ==================== */

/* App Header - Main Container */
.app-header {
    position: fixed;
    top: 0;
    right: 0;
    left: var(--sidebar-collapsed-width, 72px);
    height: 70px;
    background: var(--header-bg, #ffffff);
    border-bottom: 1px solid var(--header-border, #E8ECF0);
    z-index: 90;
    transition: left 0.35s cubic-bezier(0.25, 1, 0.5, 1);
}

/* Adjust when sidebar is hovered (expanded) */
@media (min-width: 1025px) {
    .sidebar:hover ~ .app-header {
        left: var(--sidebar-width, 280px);
    }
}

/* Mobile - Header takes full width */
@media (max-width: 1024px) {
    .app-header {
        left: 0;
    }
}

/* Dark mode */
.dark .app-header {
    --header-bg: #1F2937;
    --header-border: #374151;
}

/* Header Container */
.header-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 100%;
    padding: 0 1.5rem;
    max-width: 100%;
}

/* Header Title */
.header-title {
    flex: 1;
    min-width: 0;
}

.page-title-wrapper {
    display: flex;
    align-items: center;
    gap: 0.875rem;
}

.page-title-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    background: linear-gradient(135deg, var(--primary, #4A90D9) 0%, var(--primary-dark, #2E6BB3) 100%);
    border-radius: 12px;
    color: white;
    box-shadow: 0 4px 14px rgba(74, 144, 217, 0.3);
    flex-shrink: 0;
}

.page-title-icon:empty {
    display: none;
}

.page-title-icon svg {
    width: 22px;
    height: 22px;
}

.page-title-content {
    display: flex;
    flex-direction: column;
    min-width: 0;
}

.page-title {
    font-size: 1.375rem;
    font-weight: 700;
    color: var(--text-primary, #1F2937);
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    letter-spacing: -0.3px;
}

.page-subtitle {
    font-size: 0.8125rem;
    color: var(--text-muted, #6B7280);
    margin: 0.125rem 0 0 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.dark .page-title {
    color: #F9FAFB;
}

.dark .page-subtitle {
    color: #9CA3AF;
}

.dark .page-title-icon {
    box-shadow: 0 4px 14px rgba(74, 144, 217, 0.2);
}

@media (max-width: 640px) {
    .page-title-icon {
        width: 38px;
        height: 38px;
    }

    .page-title-icon svg {
        width: 18px;
        height: 18px;
    }

    .page-title {
        font-size: 1.125rem;
    }

    .page-subtitle {
        display: none;
    }
}

/* Header Actions */
.header-actions {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

/* Mobile Menu Button */
.mobile-menu-btn {
    display: none;
    width: 44px;
    height: 44px;
    border: none;
    border-radius: var(--radius-md, 12px);
    background: var(--sidebar-hover, #F0F4F8);
    color: var(--sidebar-text, #5A6C7D);
    cursor: pointer;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
    margin-right: 1rem;
}

.mobile-menu-btn:hover {
    background: var(--primary-light, #E8F4FD);
    color: var(--primary, #4A90D9);
}

.burger-svg {
    width: 22px;
    height: 22px;
}

.burger-line {
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    transform-origin: center;
}

.mobile-menu-btn.active .line-top {
    transform: translateY(6px) rotate(45deg);
}

.mobile-menu-btn.active .line-middle {
    opacity: 0;
    transform: scaleX(0);
}

.mobile-menu-btn.active .line-bottom {
    transform: translateY(-6px) rotate(-45deg);
}

@media (max-width: 1024px) {
    .mobile-menu-btn {
        display: flex;
    }
}

.dark .mobile-menu-btn {
    background: #374151;
    color: #E5E7EB;
}

.dark .mobile-menu-btn:hover {
    background: var(--primary-light);
    color: var(--primary);
}

/* Header Action Button Base */
.header-action-btn {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    border: none;
    border-radius: var(--radius-md, 12px);
    background: var(--sidebar-hover, #F0F4F8);
    color: var(--sidebar-text, #5A6C7D);
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
}

.header-action-btn:hover {
    background: var(--primary-light, #E8F4FD);
    color: var(--primary, #4A90D9);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(74, 144, 217, 0.15);
}

.header-action-btn:active {
    transform: translateY(0);
}

.action-icon {
    width: 20px;
    height: 20px;
}

/* Theme Toggle */
.theme-toggle .theme-icon-wrapper {
    position: relative;
    width: 20px;
    height: 20px;
}

.theme-icon {
    position: absolute;
    inset: 0;
    width: 20px;
    height: 20px;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.sun-icon {
    opacity: 1;
    transform: rotate(0deg) scale(1);
}

.moon-icon {
    opacity: 0;
    transform: rotate(-90deg) scale(0.5);
}

.dark .sun-icon {
    opacity: 0;
    transform: rotate(90deg) scale(0.5);
}

.dark .moon-icon {
    opacity: 1;
    transform: rotate(0deg) scale(1);
}

/* Notification Badge */
.notification-btn {
    position: relative;
}

/* Notification Badge - Orange Vif RH+ */
.notification-badge {
    position: absolute;
    top: 4px;
    right: 4px;
    min-width: 20px;
    height: 20px;
    padding: 0 6px;
    background: linear-gradient(135deg, #FF9500 0%, #FF6B00 100%);
    color: white;
    font-size: 0.6875rem;
    font-weight: 700;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid var(--header-bg, #fff);
    box-shadow: 0 2px 12px rgba(255, 149, 0, 0.5);
}

.notification-badge.pulse {
    animation: badge-pulse 2s ease-in-out infinite;
}

@keyframes badge-pulse {
    0%, 100% {
        box-shadow: 0 2px 12px rgba(255, 149, 0, 0.5);
    }
    50% {
        box-shadow: 0 4px 20px rgba(255, 149, 0, 0.7);
    }
}

/* User Profile Button */
.user-profile-btn {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.5rem;
    padding-right: 1rem;
    border: none;
    border-radius: var(--radius-lg, 16px);
    background: var(--sidebar-hover, #F0F4F8);
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
}

.user-profile-btn:hover {
    background: var(--primary-light, #E8F4FD);
    box-shadow: 0 4px 16px rgba(74, 144, 217, 0.15);
    transform: translateY(-2px);
}

.user-avatar-wrapper {
    position: relative;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: var(--radius-md, 12px);
    object-fit: cover;
    border: 2px solid white;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.user-status {
    position: absolute;
    bottom: -2px;
    right: -2px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid var(--sidebar-hover, #F0F4F8);
}

.user-status.online {
    background: var(--accent-green, #27AE60);
    box-shadow: 0 0 0 2px rgba(39, 174, 96, 0.2);
    animation: status-glow-green 2s ease-in-out infinite;
}

@keyframes status-glow-green {
    0%, 100% { box-shadow: 0 0 0 2px rgba(39, 174, 96, 0.2); }
    50% { box-shadow: 0 0 0 4px rgba(39, 174, 96, 0.3); }
}

.user-status.away {
    background: linear-gradient(135deg, #FF9500 0%, #FF6B00 100%);
    box-shadow: 0 0 0 2px rgba(255, 149, 0, 0.3);
    animation: status-glow-orange 2s ease-in-out infinite;
}

@keyframes status-glow-orange {
    0%, 100% { box-shadow: 0 0 0 2px rgba(255, 149, 0, 0.3); }
    50% { box-shadow: 0 0 0 4px rgba(255, 149, 0, 0.5); }
}

.user-status.offline {
    background: var(--neutral-gray, #7F8C8D);
}

.user-info {
    display: none;
    flex-direction: column;
    align-items: flex-start;
    text-align: left;
}

@media (min-width: 768px) {
    .user-info {
        display: flex;
    }
}

.user-name {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--sidebar-text, #5A6C7D);
    line-height: 1.2;
}

.user-role {
    font-size: 0.75rem;
    color: var(--sidebar-text-muted, #8B9CAD);
    line-height: 1.2;
}

.dropdown-arrow {
    width: 16px;
    height: 16px;
    color: var(--sidebar-text-muted, #8B9CAD);
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    display: none;
}

@media (min-width: 768px) {
    .dropdown-arrow {
        display: block;
    }
}

.user-profile-btn:hover .dropdown-arrow,
.user-profile-btn.active .dropdown-arrow {
    transform: rotate(180deg);
}

/* Header Dropdown Wrapper */
.header-dropdown-wrapper {
    position: relative;
}

/* Header Dropdown Base */
.header-dropdown {
    position: absolute;
    top: calc(100% + 12px);
    right: 0;
    background: var(--card-bg, #fff);
    border-radius: var(--radius-lg, 16px);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12),
                0 2px 10px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--sidebar-border, #E8ECF0);
    overflow: hidden;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px) scale(0.95);
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    z-index: 100;
}

.header-dropdown.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0) scale(1);
}

/* Notification Dropdown */
.notification-dropdown {
    width: 380px;
    max-width: calc(100vw - 2rem);
}

/* User Dropdown - Elegant Pro Design */
.user-dropdown {
    width: 300px;
    padding: 0;
    overflow: hidden;
}

/* User Card */
.ud-card {
    position: relative;
    padding: 1.25rem;
    overflow: hidden;
}

.ud-card-bg {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, var(--primary, #4A90D9) 0%, var(--primary-dark, #2E6BB3) 100%);
    opacity: 0.08;
}

.ud-card-content {
    position: relative;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.ud-avatar-section {
    position: relative;
    flex-shrink: 0;
}

.ud-avatar {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    object-fit: cover;
    border: 3px solid white;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.ud-status-dot {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 14px;
    height: 14px;
    background: #22C55E;
    border: 3px solid white;
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(34, 197, 94, 0.4);
}

.ud-user-details {
    flex: 1;
    min-width: 0;
}

.ud-name {
    font-size: 1rem;
    font-weight: 700;
    color: var(--text-primary, #1F2937);
    margin: 0 0 0.125rem 0;
    line-height: 1.3;
}

.ud-email {
    font-size: 0.8125rem;
    color: var(--text-muted, #6B7280);
    margin: 0 0 0.5rem 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.ud-role-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.25rem 0.625rem;
    background: linear-gradient(135deg, var(--primary, #4A90D9) 0%, var(--primary-dark, #2E6BB3) 100%);
    color: white;
    font-size: 0.6875rem;
    font-weight: 600;
    border-radius: 20px;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.ud-role-badge svg {
    width: 12px;
    height: 12px;
}

/* Actions */
.ud-actions {
    padding: 0.5rem;
    border-top: 1px solid var(--sidebar-border, #E8ECF0);
}

.ud-action-item {
    display: flex;
    align-items: center;
    gap: 0.875rem;
    padding: 0.75rem;
    text-decoration: none;
    border-radius: 10px;
    transition: all 0.2s ease;
}

.ud-action-item:hover {
    background: var(--sidebar-hover, #F3F4F6);
}

.ud-action-item:hover .ud-action-icon {
    background: var(--primary, #4A90D9);
    color: white;
    transform: scale(1.05);
}

.ud-action-item:hover .ud-action-arrow {
    transform: translateX(3px);
    opacity: 1;
}

.ud-action-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--sidebar-hover, #F3F4F6);
    border-radius: 10px;
    color: var(--text-muted, #6B7280);
    transition: all 0.2s ease;
    flex-shrink: 0;
}

.ud-action-icon svg {
    width: 20px;
    height: 20px;
}

.ud-action-text {
    flex: 1;
    min-width: 0;
}

.ud-action-title {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-primary, #374151);
    line-height: 1.3;
}

.ud-action-desc {
    display: block;
    font-size: 0.75rem;
    color: var(--text-muted, #9CA3AF);
    margin-top: 0.125rem;
}

.ud-action-arrow {
    width: 16px;
    height: 16px;
    color: var(--text-muted, #9CA3AF);
    opacity: 0;
    transition: all 0.2s ease;
    flex-shrink: 0;
}

/* Logout Section */
.ud-logout-section {
    padding: 0.5rem;
    border-top: 1px solid var(--sidebar-border, #E8ECF0);
    background: linear-gradient(180deg, transparent 0%, rgba(239, 68, 68, 0.03) 100%);
}

.ud-logout-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.625rem;
    width: 100%;
    padding: 0.75rem;
    background: transparent;
    border: 1px solid rgba(239, 68, 68, 0.2);
    color: #EF4444;
    font-size: 0.875rem;
    font-weight: 600;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.ud-logout-btn:hover {
    background: #EF4444;
    border-color: #EF4444;
    color: white;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

.ud-logout-btn svg {
    width: 18px;
    height: 18px;
}

/* Dark Mode - User Dropdown */
.dark .ud-card-bg {
    opacity: 0.15;
}

.dark .ud-avatar {
    border-color: var(--card-bg, #1F2937);
}

.dark .ud-status-dot {
    border-color: var(--card-bg, #1F2937);
}

.dark .ud-name {
    color: #F9FAFB;
}

.dark .ud-email {
    color: #9CA3AF;
}

.dark .ud-action-icon {
    background: rgba(255, 255, 255, 0.05);
}

.dark .ud-action-item:hover {
    background: rgba(255, 255, 255, 0.05);
}

.dark .ud-action-item:hover .ud-action-icon {
    background: var(--primary, #4A90D9);
}

.dark .ud-action-title {
    color: #E5E7EB;
}

.dark .ud-action-desc {
    color: #6B7280;
}

.dark .ud-logout-section {
    background: linear-gradient(180deg, transparent 0%, rgba(239, 68, 68, 0.05) 100%);
}

.dark .ud-logout-btn {
    border-color: rgba(239, 68, 68, 0.3);
}

.dark .ud-logout-btn:hover {
    background: #EF4444;
    border-color: #EF4444;
}

/* Dropdown Header */
.dropdown-header {
    padding: 1rem 1.25rem;
    background: linear-gradient(135deg, var(--primary-lighter, #F0F8FF) 0%, var(--primary-light, #E8F4FD) 100%);
    border-bottom: 1px solid var(--sidebar-border, #E8ECF0);
}

.dropdown-header-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0.5rem;
}

.dropdown-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--primary-dark, #2E6BB3);
    margin: 0;
}

.notification-count {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--primary, #4A90D9);
    background: white;
    padding: 0.25rem 0.625rem;
    border-radius: var(--radius-sm, 8px);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.mark-all-read {
    font-size: 0.8125rem;
    font-weight: 500;
    color: var(--primary, #4A90D9);
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
    transition: color 0.2s;
}

.mark-all-read:hover {
    color: var(--primary-dark, #2E6BB3);
    text-decoration: underline;
}

/* User Header */
.user-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    padding: 1.25rem;
}

.user-header-avatar img {
    width: 56px;
    height: 56px;
    border-radius: var(--radius-md, 12px);
    border: 3px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.user-header-info {
    flex: 1;
}

.user-header-name {
    font-size: 1rem;
    font-weight: 700;
    color: white;
    margin: 0 0 0.25rem 0;
}

.user-header-email {
    font-size: 0.8125rem;
    color: rgba(255, 255, 255, 0.8);
    margin: 0;
}

/* Dropdown Body */
.dropdown-body {
    max-height: 320px;
    overflow-y: auto;
}

/* Notification Item */
.notification-item {
    display: flex;
    gap: 0.875rem;
    padding: 1rem 1.25rem;
    text-decoration: none;
    transition: all 0.2s;
    border-bottom: 1px solid var(--sidebar-border, #E8ECF0);
    position: relative;
}

.notification-item:last-child {
    border-bottom: none;
}

.notification-item:hover {
    background: var(--sidebar-hover, #F0F4F8);
}

.notification-item.unread {
    background: var(--primary-lighter, #F0F8FF);
}

.notification-item.unread::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 3px;
    background: var(--primary, #4A90D9);
}

.notification-icon {
    flex-shrink: 0;
    width: 40px;
    height: 40px;
    border-radius: var(--radius-md, 12px);
    display: flex;
    align-items: center;
    justify-content: center;
}

.notification-icon svg {
    width: 18px;
    height: 18px;
}

.notification-icon.success {
    background: var(--accent-green-light, #D5F5E3);
    color: var(--accent-green, #27AE60);
}

.notification-icon.info {
    background: var(--primary-light, #E8F4FD);
    color: var(--primary, #4A90D9);
}

.notification-icon.warning {
    background: linear-gradient(135deg, #FFF3E0 0%, #FFE5BF 100%);
    color: #FF9500;
    box-shadow: 0 2px 8px rgba(255, 149, 0, 0.15);
}

.notification-icon.danger {
    background: var(--accent-red-light, #FADBD8);
    color: var(--accent-red, #E74C3C);
}

.notification-content {
    flex: 1;
    min-width: 0;
}

.notification-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--sidebar-text, #5A6C7D);
    margin: 0 0 0.25rem 0;
}

.notification-text {
    font-size: 0.8125rem;
    color: var(--sidebar-text-muted, #8B9CAD);
    margin: 0 0 0.375rem 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.notification-time {
    font-size: 0.75rem;
    color: var(--sidebar-text-muted, #8B9CAD);
}

/* Dropdown Item */
.dropdown-item {
    display: flex;
    align-items: center;
    gap: 0.875rem;
    padding: 0.875rem 1.25rem;
    text-decoration: none;
    color: var(--sidebar-text, #5A6C7D);
    transition: all 0.2s;
}

.dropdown-item:hover {
    background: var(--sidebar-hover, #F0F4F8);
    color: var(--primary, #4A90D9);
}

.dropdown-item:hover .dropdown-item-icon {
    background: var(--primary-light, #E8F4FD);
    color: var(--primary, #4A90D9);
    transform: scale(1.1);
}

.dropdown-item-icon {
    width: 36px;
    height: 36px;
    border-radius: var(--radius-sm, 8px);
    background: var(--sidebar-hover, #F0F4F8);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.dropdown-item-icon svg {
    width: 18px;
    height: 18px;
}

.dropdown-item span {
    font-size: 0.9375rem;
    font-weight: 500;
}

/* Dropdown Footer */
.dropdown-footer {
    padding: 0.875rem 1.25rem;
    border-top: 1px solid var(--sidebar-border, #E8ECF0);
    background: var(--sidebar-hover, #F0F4F8);
}

.view-all-link {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--primary, #4A90D9);
    text-decoration: none;
    transition: all 0.2s;
}

.view-all-link:hover {
    color: var(--primary-dark, #2E6BB3);
}

.view-all-link svg {
    width: 16px;
    height: 16px;
    transition: transform 0.3s;
}

.view-all-link:hover svg {
    transform: translateX(4px);
}

/* Logout Section */
.logout-section {
    background: var(--accent-red-light, #FADBD8);
}

.dark .logout-section {
    background: rgba(231, 76, 60, 0.1);
}

.logout-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.625rem;
    width: 100%;
    padding: 0.75rem;
    background: transparent;
    border: none;
    border-radius: var(--radius-sm, 8px);
    color: var(--accent-red, #E74C3C);
    font-size: 0.9375rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.logout-btn:hover {
    background: var(--accent-red, #E74C3C);
    color: white;
}

.logout-btn svg {
    width: 18px;
    height: 18px;
}

/* Dark Mode Adjustments */
.dark .header-action-btn {
    background: var(--sidebar-hover);
    color: var(--sidebar-text);
}

.dark .header-action-btn:hover {
    background: var(--primary-light);
    color: var(--primary);
}

.dark .user-profile-btn {
    background: var(--sidebar-hover);
}

.dark .user-profile-btn:hover {
    background: var(--primary-light);
}

.dark .header-dropdown {
    background: var(--card-bg);
    border-color: var(--sidebar-border);
}

.dark .notification-item.unread {
    background: var(--primary-light);
}

.dark .dropdown-header {
    background: var(--primary-light);
}

.dark .dropdown-footer {
    background: var(--sidebar-hover);
}

.dark .notification-badge {
    border-color: var(--header-bg);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Notification Dropdown
    const notificationBtn = document.getElementById('notificationBtn');
    const notificationDropdown = document.getElementById('notificationDropdown');

    if (notificationBtn && notificationDropdown) {
        notificationBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            notificationDropdown.classList.toggle('show');
            userDropdown?.classList.remove('show');
        });
    }

    // User Dropdown
    const userMenuBtn = document.getElementById('userMenuBtn');
    const userDropdown = document.getElementById('userDropdown');

    if (userMenuBtn && userDropdown) {
        userMenuBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.classList.toggle('show');
            userMenuBtn.classList.toggle('active');
            notificationDropdown?.classList.remove('show');
        });
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.header-dropdown-wrapper')) {
            notificationDropdown?.classList.remove('show');
            userDropdown?.classList.remove('show');
            userMenuBtn?.classList.remove('active');
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            notificationDropdown?.classList.remove('show');
            userDropdown?.classList.remove('show');
            userMenuBtn?.classList.remove('active');
        }
    });

    // === ADMIN NOTIFICATIONS AJAX ===
    const adminBadge = document.getElementById('adminNotifBadge');
    const adminCount = document.getElementById('adminNotifCount');
    const adminList = document.getElementById('adminNotifList');
    const adminMarkAll = document.getElementById('adminMarkAllRead');
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfVal = csrfMeta ? csrfMeta.content : '';

    function fetchAdminNotifications() {
        fetch('/api/notifications', { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.json())
            .then(data => {
                const c = data.count || 0;
                if (c > 0) {
                    adminBadge.textContent = c > 9 ? '9+' : c;
                    adminBadge.style.display = '';
                    adminBadge.classList.add('pulse');
                } else {
                    adminBadge.style.display = 'none';
                    adminBadge.classList.remove('pulse');
                }
                adminCount.textContent = c + ' nouvelle' + (c > 1 ? 's' : '');
                renderAdminNotifs(data.notifications || []);
            })
            .catch(() => {});
    }

    function renderAdminNotifs(items) {
        if (!items.length) {
            adminList.innerHTML = '<div style="padding:2rem;text-align:center;color:var(--text-muted,#6B7280);font-size:0.875rem;">Aucune notification</div>';
            return;
        }
        adminList.innerHTML = items.map(n => {
            let iconClass = 'info', iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>';
            if (n.type === 'nouvelle_demande_conge') {
                iconClass = 'warning';
                iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/></svg>';
            } else if (n.status === 'approuve') {
                iconClass = 'success';
                iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>';
            } else if (n.status === 'refuse') {
                iconClass = 'danger';
                iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';
            }
            return `<a href="#" class="notification-item unread" onclick="markAdminNotifRead('${n.id}',this);return false;">
                <div class="notification-icon ${iconClass}">${iconSvg}</div>
                <div class="notification-content">
                    <p class="notification-title">${n.message}</p>
                    <p class="notification-text">${n.employe || ''} ${n.date_debut ? n.date_debut + ' - ' + n.date_fin : ''}</p>
                    <span class="notification-time">${n.created_at}</span>
                </div>
            </a>`;
        }).join('');
    }

    window.markAdminNotifRead = function(id, el) {
        fetch('/api/notifications/' + id + '/read', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfVal, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        }).then(() => {
            if (el) el.remove();
            fetchAdminNotifications();
        }).catch(() => {});
    };

    if (adminMarkAll) {
        adminMarkAll.addEventListener('click', function() {
            fetch('/api/notifications/read-all', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfVal, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            }).then(() => fetchAdminNotifications()).catch(() => {});
        });
    }

    fetchAdminNotifications();
    setInterval(fetchAdminNotifications, 30000);
});
</script>
