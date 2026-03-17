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
                    <!-- Soleil - Design moderne avec rayons animés -->
                    <svg class="theme-icon sun-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="4" fill="currentColor" opacity="0.15"></circle>
                        <circle cx="12" cy="12" r="4"></circle>
                        <path d="M12 2v2" class="sun-ray"></path>
                        <path d="M12 20v2" class="sun-ray"></path>
                        <path d="M4.93 4.93l1.41 1.41" class="sun-ray"></path>
                        <path d="M17.66 17.66l1.41 1.41" class="sun-ray"></path>
                        <path d="M2 12h2" class="sun-ray"></path>
                        <path d="M20 12h2" class="sun-ray"></path>
                        <path d="M6.34 17.66l-1.41 1.41" class="sun-ray"></path>
                        <path d="M19.07 4.93l-1.41 1.41" class="sun-ray"></path>
                    </svg>
                    <!-- Lune - Croissant élégant avec étoile -->
                    <svg class="theme-icon moon-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" fill="currentColor" opacity="0.1"></path>
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                        <path d="M17.5 5.5l.5 1 1 .5-1 .5-.5 1-.5-1-1-.5 1-.5z" class="moon-star" fill="currentColor" stroke="none"></path>
                        <circle cx="20" cy="10" r="0.6" class="moon-star" fill="currentColor" stroke="none"></circle>
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
                    <div class="dropdown-footer" id="adminNotifFooter" style="display:none;"></div>
                </div>
            </div>

            <!-- Separator -->
            <div class="hdr-sep"></div>

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
/* ═══════════════════════════════════════════════════════════
   HEADER — Indigo × Teal Charter — Design System Premium
   Syne (display) · DM Sans (body)
   ═══════════════════════════════════════════════════════════ */

/* ── Variables ── */
:root {
    --hdr-h: 70px;
    --hdr-bg: rgba(255,255,255,0.92);
    --hdr-border: rgba(226,232,240,0.8);
    --hdr-text:  #1e293b;
    --hdr-text2: #64748b;
    --hdr-btn-bg: #f1f5f9;
    --hdr-btn-hover: rgba(99,102,241,0.08);
    --hdr-shadow: 0 1px 0 rgba(0,0,0,.04), 0 4px 24px rgba(0,0,0,.04);
}
.dark {
    --hdr-bg: rgba(15,23,42,0.88);
    --hdr-border: rgba(51,65,85,0.7);
    --hdr-text:  #f1f5f9;
    --hdr-text2: #94a3b8;
    --hdr-btn-bg: rgba(255,255,255,0.06);
    --hdr-btn-hover: rgba(99,102,241,0.15);
    --hdr-shadow: 0 1px 0 rgba(0,0,0,.2), 0 4px 24px rgba(0,0,0,.25);
}

/* ── Header ── */
.app-header {
    position: fixed;
    top: 0; right: 0;
    left: var(--sidebar-collapsed-width, 72px);
    height: var(--hdr-h);
    background: var(--hdr-bg);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-bottom: 1px solid var(--hdr-border);
    box-shadow: var(--hdr-shadow);
    z-index: 90;
    transition: left 0.35s cubic-bezier(0.25,1,0.5,1);
}

/* Gradient accent line at bottom */
.app-header::after {
    content: '';
    position: absolute;
    bottom: -1px; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, transparent 0%, #6366f1 30%, #14b8a6 70%, transparent 100%);
    opacity: 0;
    transition: opacity 0.3s;
}
.app-header:hover::after { opacity: .5; }

@media (min-width: 1025px) {
    .sidebar:hover ~ .app-header { left: var(--sidebar-width, 280px); }
}
@media (max-width: 1024px) {
    .app-header { left: 0; }
}

/* ── Container ── */
.header-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 100%;
    padding: 0 1.5rem;
}

/* ── Title area ── */
.header-title { flex: 1; min-width: 0; }

.page-title-wrapper {
    display: flex;
    align-items: center;
    gap: 0.875rem;
}

.page-title-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px; height: 44px;
    background: linear-gradient(135deg, #6366f1, #4338ca);
    border-radius: 13px;
    color: #fff;
    box-shadow: 0 4px 14px rgba(99,102,241,.35), 0 0 0 3px rgba(99,102,241,.1);
    flex-shrink: 0;
    transition: all 0.3s cubic-bezier(0.34,1.56,0.64,1);
}
.page-title-icon:hover { transform: rotate(-6deg) scale(1.08); box-shadow: 0 6px 20px rgba(99,102,241,.45), 0 0 0 4px rgba(99,102,241,.12); }
.page-title-icon:empty { display: none; }
.page-title-icon svg { width: 22px; height: 22px; }

.page-title-content { display: flex; flex-direction: column; min-width: 0; }

.page-title {
    font-family: 'Syne', sans-serif;
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--hdr-text);
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    letter-spacing: -0.2px;
    line-height: 1.2;
}

.page-subtitle {
    font-size: 0.78rem;
    color: var(--hdr-text2);
    margin: 2px 0 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    font-family: 'DM Sans', sans-serif;
}

@media (max-width: 640px) {
    .page-title-icon { width: 38px; height: 38px; }
    .page-title-icon svg { width: 18px; height: 18px; }
    .page-title { font-size: 1.0625rem; }
    .page-subtitle { display: none; }
}

/* ── Actions ── */
.header-actions { display: flex; align-items: center; gap: 8px; }

/* ── Mobile burger ── */
.mobile-menu-btn {
    display: none;
    width: 40px; height: 40px;
    border: none; border-radius: 11px;
    background: var(--hdr-btn-bg);
    color: var(--hdr-text2);
    cursor: pointer;
    align-items: center; justify-content: center;
    transition: all 0.25s;
    margin-right: 12px;
}
.mobile-menu-btn:hover { background: var(--hdr-btn-hover); color: #6366f1; }
.burger-svg { width: 20px; height: 20px; }
.burger-line { transition: all 0.3s cubic-bezier(0.34,1.56,0.64,1); transform-origin: center; }
.mobile-menu-btn.active .line-top    { transform: translateY(6px) rotate(45deg); }
.mobile-menu-btn.active .line-middle { opacity: 0; transform: scaleX(0); }
.mobile-menu-btn.active .line-bottom { transform: translateY(-6px) rotate(-45deg); }
@media (max-width: 1024px) { .mobile-menu-btn { display: flex; } }

/* ── Action button base ── */
.header-action-btn {
    position: relative;
    display: flex;
    align-items: center; justify-content: center;
    width: 40px; height: 40px;
    border: 1.5px solid transparent;
    border-radius: 11px;
    background: var(--hdr-btn-bg);
    color: var(--hdr-text2);
    cursor: pointer;
    transition: all 0.22s cubic-bezier(0.25,1,0.5,1);
}
.header-action-btn:hover {
    background: var(--hdr-btn-hover);
    border-color: rgba(99,102,241,.2);
    color: #6366f1;
    transform: translateY(-2px);
    box-shadow: 0 4px 14px rgba(99,102,241,.15);
}
.header-action-btn:active { transform: translateY(0); }
.action-icon { width: 19px; height: 19px; }

/* ── Theme toggle ── */
.theme-toggle .theme-icon-wrapper { position: relative; width: 20px; height: 20px; }
.theme-icon { position: absolute; inset: 0; width: 20px; height: 20px; transition: all 0.5s cubic-bezier(0.34,1.56,0.64,1); }

.sun-icon { opacity: 1; transform: rotate(0deg) scale(1); color: #f59e0b; }
.sun-icon .sun-ray { transition: all 0.4s cubic-bezier(0.34,1.56,0.64,1); transform-origin: center; }
.theme-toggle:hover .sun-icon .sun-ray { stroke-width: 2.2; }
.theme-toggle:hover { background: rgba(245,158,11,.1) !important; border-color: rgba(245,158,11,.2) !important; color: #f59e0b !important; }

.moon-icon { opacity: 0; transform: rotate(-90deg) scale(0.5); color: #818cf8; }
.moon-icon .moon-star { transition: all 0.6s cubic-bezier(0.34,1.56,0.64,1); opacity: 0; }

.dark .sun-icon { opacity: 0; transform: rotate(90deg) scale(0.5); }
.dark .moon-icon { opacity: 1; transform: rotate(0deg) scale(1); }
.dark .moon-icon .moon-star { opacity: 1; animation: twinkle 3s ease-in-out infinite; }
@keyframes twinkle { 0%,100%{opacity:.6} 50%{opacity:1} }
.dark .theme-toggle:hover { background: rgba(129,140,248,.12) !important; border-color: rgba(129,140,248,.25) !important; color: #818cf8 !important; }

/* ── Notification ── */
.notification-btn { position: relative; }

.notification-badge {
    position: absolute;
    top: -3px; right: -3px;
    min-width: 18px; height: 18px;
    padding: 0 5px;
    background: linear-gradient(135deg, #6366f1, #4338ca);
    color: #fff;
    font-size: 0.6rem; font-weight: 800;
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    border: 2px solid var(--hdr-bg, #fff);
    box-shadow: 0 2px 10px rgba(99,102,241,.5);
    font-family: 'DM Mono', monospace;
    letter-spacing: 0;
}
.notification-badge.pulse { animation: badge-pulse 2.5s ease-in-out infinite; }
@keyframes badge-pulse {
    0%,100% { box-shadow: 0 2px 10px rgba(99,102,241,.5); }
    50%      { box-shadow: 0 4px 18px rgba(99,102,241,.7); transform: scale(1.05); }
}

/* ── Separator ── */
.hdr-sep {
    width: 1px; height: 24px;
    background: var(--hdr-border);
    margin: 0 4px;
    flex-shrink: 0;
}

/* ── User profile button ── */
.user-profile-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 6px 12px 6px 6px;
    border: 1.5px solid var(--hdr-border);
    border-radius: 13px;
    background: var(--hdr-btn-bg);
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.25,1,0.5,1);
}
.user-profile-btn:hover {
    background: var(--hdr-btn-hover);
    border-color: rgba(99,102,241,.3);
    box-shadow: 0 4px 16px rgba(99,102,241,.12);
    transform: translateY(-1px);
}

.user-avatar-wrapper { position: relative; }

.user-avatar {
    width: 36px; height: 36px;
    border-radius: 10px;
    object-fit: cover;
    border: 2px solid rgba(99,102,241,.2);
    box-shadow: 0 2px 8px rgba(0,0,0,.1);
    display: block;
}

.user-status {
    position: absolute; bottom: -2px; right: -2px;
    width: 11px; height: 11px;
    border-radius: 50%;
    border: 2px solid var(--hdr-bg, #fff);
}
.user-status.online {
    background: #10b981;
    box-shadow: 0 0 0 2px rgba(16,185,129,.2);
    animation: status-glow 2.5s ease-in-out infinite;
}
@keyframes status-glow {
    0%,100% { box-shadow: 0 0 0 2px rgba(16,185,129,.2); }
    50%      { box-shadow: 0 0 0 4px rgba(16,185,129,.35); }
}
.user-status.away  { background: #f59e0b; }
.user-status.offline { background: #94a3b8; }

.user-info { display: none; flex-direction: column; align-items: flex-start; }
@media (min-width: 768px) { .user-info { display: flex; } }

.user-name {
    font-family: 'Syne', sans-serif;
    font-size: 0.8125rem; font-weight: 700;
    color: var(--hdr-text);
    line-height: 1.2; white-space: nowrap;
}
.user-role {
    font-size: 0.6875rem; font-weight: 500;
    color: var(--hdr-text2);
    line-height: 1.2;
    display: flex; align-items: center; gap: 4px;
}
.user-role::before {
    content: '';
    width: 5px; height: 5px; border-radius: 50%;
    background: linear-gradient(135deg, #6366f1, #14b8a6);
    flex-shrink: 0;
}

.dropdown-arrow {
    width: 15px; height: 15px;
    color: var(--hdr-text2);
    transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1);
    display: none;
}
@media (min-width: 768px) { .dropdown-arrow { display: block; } }
.user-profile-btn:hover .dropdown-arrow,
.user-profile-btn.active .dropdown-arrow { transform: rotate(180deg); color: #6366f1; }

/* ── Dropdown wrappers ── */
.header-dropdown-wrapper { position: relative; }

.header-dropdown {
    position: absolute;
    top: calc(100% + 10px); right: 0;
    background: var(--card-bg, #fff);
    border-radius: 18px;
    box-shadow: 0 8px 32px rgba(0,0,0,.1), 0 2px 8px rgba(0,0,0,.06);
    border: 1.5px solid var(--card-border, #e2e8f0);
    overflow: hidden;
    opacity: 0; visibility: hidden;
    transform: translateY(-8px) scale(0.96);
    transition: all 0.28s cubic-bezier(0.34,1.56,0.64,1);
    z-index: 100;
}
.header-dropdown.show {
    opacity: 1; visibility: visible;
    transform: translateY(0) scale(1);
}

/* ── Notification dropdown ── */
.notification-dropdown {
    width: 380px;
    max-width: calc(100vw - 2rem);
}

.dropdown-header {
    padding: 1rem 1.25rem;
    background: linear-gradient(135deg, rgba(99,102,241,.06), rgba(20,184,166,.04));
    border-bottom: 1px solid var(--card-border, #e2e8f0);
}
.dropdown-header-content {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 6px;
}
.dropdown-title {
    font-family: 'Syne', sans-serif;
    font-size: 0.9375rem; font-weight: 700;
    color: var(--text-primary, #1e293b); margin: 0;
}
.notification-count {
    font-size: 0.7rem; font-weight: 700;
    color: #6366f1;
    background: rgba(99,102,241,.1);
    padding: 3px 8px; border-radius: 99px;
    font-family: 'DM Mono', monospace;
}
.mark-all-read {
    font-size: 0.78rem; font-weight: 600;
    color: #6366f1; background: none; border: none;
    cursor: pointer; padding: 0; transition: color .2s;
}
.mark-all-read:hover { color: #4338ca; text-decoration: underline; }

.dropdown-body { max-height: 320px; overflow-y: auto; }

/* ── Notification items ── */
.notification-item {
    display: flex; gap: 12px; padding: 14px 18px;
    text-decoration: none; transition: background .15s;
    border-bottom: 1px solid var(--card-border, #e2e8f0);
    position: relative;
}
.notification-item:last-child { border-bottom: none; }
.notification-item:hover { background: rgba(99,102,241,.04); }
.notification-item.unread { background: rgba(99,102,241,.04); }
.notification-item.unread::before {
    content: ''; position: absolute; left: 0; top: 0; bottom: 0;
    width: 3px; background: linear-gradient(180deg, #6366f1, #14b8a6);
}
.notification-icon {
    flex-shrink: 0; width: 38px; height: 38px;
    border-radius: 11px; display: flex; align-items: center; justify-content: center;
}
.notification-icon svg { width: 17px; height: 17px; }
.notification-icon.success { background: rgba(16,185,129,.1); color: #10b981; }
.notification-icon.info    { background: rgba(99,102,241,.1); color: #6366f1; }
.notification-icon.warning { background: rgba(245,158,11,.1); color: #f59e0b; }
.notification-icon.danger  { background: rgba(239,68,68,.1);  color: #ef4444; }
.notification-content { flex: 1; min-width: 0; }
.notification-title {
    font-size: 0.8125rem; font-weight: 600;
    color: var(--text-primary, #1e293b); margin: 0 0 3px;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    line-height: 1.4;
}
.notification-text {
    font-size: 0.75rem; color: var(--text-muted, #6b7280);
    margin: 0 0 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.notification-time { font-size: 0.7rem; color: var(--text-light, #94a3b8); }

/* ── Dropdown footer ── */
.dropdown-footer {
    padding: 12px 18px;
    border-top: 1px solid var(--card-border, #e2e8f0);
    background: rgba(248,250,252,.8);
}
.view-all-link {
    display: flex; align-items: center; justify-content: center; gap: 6px;
    font-size: 0.8125rem; font-weight: 600; color: #6366f1;
    text-decoration: none; transition: color .2s;
}
.view-all-link:hover { color: #4338ca; }
.view-all-link svg { width: 15px; height: 15px; transition: transform .2s; }
.view-all-link:hover svg { transform: translateX(4px); }

/* ── User dropdown ── */
.user-dropdown { width: 304px; padding: 0; overflow: hidden; }

.ud-card { position: relative; padding: 1.25rem 1.25rem 1rem; overflow: hidden; }
.ud-card-bg {
    position: absolute; inset: 0;
    background: linear-gradient(135deg, #6366f1 0%, #14b8a6 100%);
    opacity: .07;
}
.ud-card-content { position: relative; display: flex; align-items: center; gap: 14px; }
.ud-avatar-section { position: relative; flex-shrink: 0; }
.ud-avatar {
    width: 54px; height: 54px; border-radius: 14px; object-fit: cover;
    border: 3px solid rgba(99,102,241,.2);
    box-shadow: 0 4px 14px rgba(99,102,241,.2);
}
.ud-status-dot {
    position: absolute; bottom: 1px; right: 1px;
    width: 13px; height: 13px;
    background: #10b981;
    border: 2.5px solid var(--card-bg, #fff);
    border-radius: 50%;
    box-shadow: 0 2px 6px rgba(16,185,129,.4);
}
.ud-user-details { flex: 1; min-width: 0; }
.ud-name {
    font-family: 'Syne', sans-serif; font-size: .9375rem; font-weight: 700;
    color: var(--text-primary, #1e293b); margin: 0 0 2px; line-height: 1.3;
}
.ud-email {
    font-size: .75rem; color: var(--text-muted, #64748b);
    margin: 0 0 8px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.ud-role-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 10px;
    background: linear-gradient(135deg, #6366f1, #4338ca);
    color: #fff; font-size: .65rem; font-weight: 700;
    border-radius: 99px; text-transform: uppercase; letter-spacing: .4px;
}
.ud-role-badge svg { width: 10px; height: 10px; }

/* ── User dropdown actions ── */
.ud-actions { padding: 6px; border-top: 1px solid var(--card-border, #e2e8f0); }
.ud-action-item {
    display: flex; align-items: center; gap: 12px;
    padding: 10px 10px; text-decoration: none; border-radius: 11px;
    transition: all 0.18s;
}
.ud-action-item:hover { background: rgba(99,102,241,.06); }
.ud-action-item:hover .ud-action-icon { background: #6366f1; color: #fff; transform: scale(1.06); }
.ud-action-item:hover .ud-action-arrow { transform: translateX(4px); opacity: 1; }
.ud-action-icon {
    width: 38px; height: 38px; border-radius: 10px; flex-shrink: 0;
    background: #f1f5f9;
    color: #64748b;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.2s;
}
.ud-action-icon svg { width: 18px; height: 18px; }
.ud-action-text { flex: 1; min-width: 0; }
.ud-action-title { display: block; font-size: .8125rem; font-weight: 600; color: var(--text-primary, #374151); line-height: 1.3; }
.ud-action-desc  { display: block; font-size: .7rem; color: var(--text-muted, #94a3b8); margin-top: 1px; }
.ud-action-arrow { width: 15px; height: 15px; color: #94a3b8; opacity: 0; transition: all .2s; flex-shrink: 0; }

/* ── Logout ── */
.ud-logout-section {
    padding: 6px; border-top: 1px solid var(--card-border, #e2e8f0);
}
.ud-logout-btn {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%; padding: 10px 14px;
    background: transparent; border: 1.5px solid rgba(239,68,68,.2);
    color: #ef4444; font-size: .8125rem; font-weight: 600;
    border-radius: 11px; cursor: pointer; transition: all .2s;
    font-family: 'DM Sans', sans-serif;
}
.ud-logout-btn:hover { background: #ef4444; border-color: #ef4444; color: #fff; box-shadow: 0 4px 14px rgba(239,68,68,.3); }
.ud-logout-btn svg { width: 16px; height: 16px; }

/* ── Dropdown item (generic) ── */
.dropdown-item {
    display: flex; align-items: center; gap: 12px;
    padding: 12px 18px; text-decoration: none;
    color: var(--text-secondary, #374151); transition: all .18s;
}
.dropdown-item:hover { background: rgba(99,102,241,.05); color: #6366f1; }
.dropdown-item:hover .dropdown-item-icon { background: rgba(99,102,241,.12); color: #6366f1; transform: scale(1.1); }
.dropdown-item-icon {
    width: 34px; height: 34px; border-radius: 9px; background: #f1f5f9;
    display: flex; align-items: center; justify-content: center;
    transition: all .28s cubic-bezier(0.34,1.56,0.64,1);
}
.dropdown-item-icon svg { width: 17px; height: 17px; }
.dropdown-item span { font-size: .875rem; font-weight: 500; }

/* ── Logout section (old) ── */
.logout-section { background: rgba(239,68,68,.04); }
.logout-btn {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%; padding: 12px;
    background: transparent; border: none; border-radius: 9px;
    color: #ef4444; font-size: .9375rem; font-weight: 600; cursor: pointer; transition: all .2s;
}
.logout-btn:hover { background: #ef4444; color: #fff; }
.logout-btn svg { width: 17px; height: 17px; }

/* ═══════════════════════ DARK MODE ═══════════════════════ */
.dark .header-action-btn {
    background: rgba(255,255,255,.06);
    border-color: rgba(255,255,255,.07);
    color: #94a3b8;
}
.dark .header-action-btn:hover {
    background: rgba(99,102,241,.15);
    border-color: rgba(99,102,241,.3);
    color: #818cf8;
    box-shadow: 0 4px 14px rgba(99,102,241,.2);
}
.dark .mobile-menu-btn { background: rgba(255,255,255,.06); color: #94a3b8; }
.dark .mobile-menu-btn:hover { background: rgba(99,102,241,.15); color: #818cf8; }

.dark .user-profile-btn {
    background: rgba(255,255,255,.05);
    border-color: rgba(255,255,255,.08);
}
.dark .user-profile-btn:hover {
    background: rgba(99,102,241,.12);
    border-color: rgba(99,102,241,.3);
    box-shadow: 0 4px 16px rgba(99,102,241,.2);
}
.dark .user-avatar { border-color: rgba(99,102,241,.25); }
.dark .user-status { border-color: rgba(15,23,42,.9); }
.dark .user-name { color: #f1f5f9; }
.dark .user-role { color: #64748b; }

.dark .notification-badge { border-color: rgba(15,23,42,.9); }

.dark .header-dropdown {
    background: #1e293b;
    border-color: #334155;
    box-shadow: 0 12px 40px rgba(0,0,0,.4), 0 4px 12px rgba(0,0,0,.3);
}
.dark .dropdown-header {
    background: linear-gradient(135deg, rgba(99,102,241,.1), rgba(20,184,166,.06));
    border-color: #334155;
}
.dark .dropdown-title { color: #e2e8f0; }
.dark .notification-count { background: rgba(99,102,241,.2); color: #818cf8; }
.dark .mark-all-read { color: #818cf8; }
.dark .mark-all-read:hover { color: #a5b4fc; }

.dark .notification-item { border-color: #334155; }
.dark .notification-item:hover { background: rgba(255,255,255,.04); }
.dark .notification-item.unread { background: rgba(99,102,241,.08); }
.dark .notification-icon.success { background: rgba(16,185,129,.12); color: #34d399; }
.dark .notification-icon.info    { background: rgba(99,102,241,.12); color: #818cf8; }
.dark .notification-icon.warning { background: rgba(245,158,11,.12); color: #fbbf24; }
.dark .notification-icon.danger  { background: rgba(239,68,68,.12);  color: #f87171; }
.dark .notification-title { color: #e2e8f0; }
.dark .notification-text  { color: #94a3b8; }
.dark .notification-time  { color: #64748b; }

.dark .dropdown-footer { background: rgba(255,255,255,.03); border-color: #334155; }
.dark .view-all-link { color: #818cf8; }
.dark .view-all-link:hover { color: #a5b4fc; }

.dark .dropdown-item { color: #cbd5e1; }
.dark .dropdown-item:hover { background: rgba(255,255,255,.04); color: #818cf8; }
.dark .dropdown-item-icon { background: rgba(255,255,255,.06); }
.dark .dropdown-item:hover .dropdown-item-icon { background: rgba(99,102,241,.18); }

.dark .ud-card-bg { opacity: .12; }
.dark .ud-avatar  { border-color: rgba(99,102,241,.3); box-shadow: 0 4px 14px rgba(99,102,241,.25); }
.dark .ud-status-dot { border-color: #1e293b; }
.dark .ud-name  { color: #f1f5f9; }
.dark .ud-email { color: #64748b; }
.dark .ud-action-icon { background: rgba(255,255,255,.06); color: #94a3b8; }
.dark .ud-action-item:hover { background: rgba(255,255,255,.05); }
.dark .ud-action-item:hover .ud-action-icon { background: #6366f1; color: #fff; }
.dark .ud-action-title { color: #e2e8f0; }
.dark .ud-action-desc  { color: #64748b; }
.dark .ud-actions { border-color: #334155; }
.dark .ud-logout-section { border-color: #334155; }
.dark .ud-logout-btn { border-color: rgba(239,68,68,.3); }
.dark .ud-logout-btn:hover { background: #ef4444; border-color: #ef4444; }
.dark .logout-section { background: rgba(239,68,68,.06); }

/* ── Separator ── */
.hdr-sep { width: 1px; height: 22px; background: var(--hdr-border); margin: 0 4px; flex-shrink: 0; }
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

    const adminFooter = document.getElementById('adminNotifFooter');

    function getNotifMeta(n) {
        const icons = {
            nouvelle_requete: { cls: 'warning', svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>' },
            requete: { cls: 'info', svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>' },
            reponse_requete: { cls: 'success', svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><polyline points="9 10 12 13 15 10" stroke-width="2.5"/></svg>' },
            nouvelle_demande_conge: { cls: 'warning', svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/></svg>' },
        };
        let meta = icons[n.type] || { cls: 'info', svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>' };
        if (n.status === 'approuve') meta = { cls: 'success', svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>' };
        if (n.status === 'refuse') meta = { cls: 'danger', svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>' };
        return meta;
    }

    function truncate(str, len) { return str && str.length > len ? str.substring(0, len) + '...' : (str || ''); }

    function renderAdminNotifs(items) {
        if (!items.length) {
            adminList.innerHTML = '<div style="padding:2.5rem 1.5rem;text-align:center;"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color:var(--text-muted,#9CA3AF);margin:0 auto 12px;display:block;opacity:0.5;"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg><div style="font-size:0.875rem;font-weight:600;color:var(--text-primary,#374151);margin-bottom:4px;">Tout est lu</div><div style="font-size:0.78rem;color:var(--text-muted,#9CA3AF);">Aucune notification en attente</div></div>';
            adminFooter.style.display = 'none';
            return;
        }
        adminFooter.style.display = '';
        adminList.innerHTML = items.map(n => {
            const m = getNotifMeta(n);
            const title = truncate(n.message, 70);
            let sub = '';
            if (n.sujet) sub = truncate(n.sujet, 50);
            else if (n.employe) sub = n.employe + (n.date_debut ? ' &middot; ' + n.date_debut + ' → ' + n.date_fin : '');
            const href = n.link ? n.link : '#';
            return `<a href="${href}" class="notification-item unread" onclick="markAdminNotifRead('${n.id}',this);">
                <div class="notification-icon ${m.cls}">${m.svg}</div>
                <div class="notification-content">
                    <p class="notification-title">${title}</p>
                    ${sub ? '<p class="notification-text">' + sub + '</p>' : ''}
                    <span class="notification-time">${n.created_at}</span>
                </div>
            </a>`;
        }).join('');
    }

    window.markAdminNotifRead = function(id, el) {
        const href = el ? el.getAttribute('href') : null;
        fetch('/api/notifications/' + id + '/read', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfVal, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        }).then(() => {
            if (href && href !== '#') { window.location.href = href; return; }
            if (el) el.remove();
            fetchAdminNotifications();
        }).catch(() => {});
        return false;
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
