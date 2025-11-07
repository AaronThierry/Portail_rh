<!-- Sidebar Overlay for Mobile -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<aside class="sidebar" id="sidebar">
    <!-- Header with Logo -->
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <div class="sidebar-logo-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2L2 7l10 5 10-5-10-5z"></path>
                    <path d="M2 17l10 5 10-5M2 12l10 5 10-5"></path>
                </svg>
            </div>
            <span class="sidebar-logo-text">Portail RH</span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="sidebar-nav">
        <!-- Dashboard -->
        <div class="nav-section">
            <div class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" data-tooltip="Tableau de bord">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    <span class="nav-text">Tableau de bord</span>
                </a>
            </div>
        </div>

        <!-- Personnel -->
        @if(auth()->user()->roles()->exists())
        <div class="nav-section">
            <div class="nav-category">Gestion</div>

            {{-- Vérifier d'abord le rôle, puis la permission --}}
            @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Manager', 'RH']))
                @can('view-personnel')
                <div class="nav-item">
                    <a href="{{ route('personnels.index') }}" class="nav-link {{ Request::is('personnels*') ? 'active' : '' }}" data-tooltip="Personnel">
                        <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="nav-text">Personnel</span>
                    </a>
                </div>
                @endcan

                @can('view-users')
                <div class="nav-item">
                    <a href="{{ route('utilisateurs.index') }}" class="nav-link {{ Request::is('utilisateurs*') ? 'active' : '' }}" data-tooltip="Comptes Utilisateurs">
                        <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="nav-text">Comptes Utilisateurs</span>
                    </a>
                </div>
                @endcan
            @endif

            @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Manager', 'RH', 'Employé']))
                @can('view-documents')
                <div class="nav-item">
                    <a href="#" class="nav-link {{ Request::is('documents*') ? 'active' : '' }}" data-tooltip="Documents" onclick="alert('Module Documents à venir'); return false;">
                        <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="nav-text">Documents</span>
                        <span class="badge" style="margin-left: auto; background: #fbbf24; color: #78350f; font-size: 0.625rem; padding: 2px 6px; border-radius: 4px;">Bientôt</span>
                    </a>
                </div>
                @endcan
            @endif

            @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Manager', 'RH', 'Employé']))
                @can('view-demandes')
                <div class="nav-item">
                    <a href="#" class="nav-link {{ Request::is('demandes*') ? 'active' : '' }}" data-tooltip="Demandes" onclick="alert('Module Demandes à venir'); return false;">
                        <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        <span class="nav-text">Demandes</span>
                        <span class="badge" style="margin-left: auto; background: #fbbf24; color: #78350f; font-size: 0.625rem; padding: 2px 6px; border-radius: 4px;">Bientôt</span>
                    </a>
                </div>
                @endcan
            @endif
        </div>
        @endif

        <!-- Paramètres -->
        @if(auth()->user()->roles()->exists() && auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
        <div class="nav-section">
            <div class="nav-category">Administration</div>

            <div class="nav-item">
                <button class="nav-link {{ Request::is('parametres*') || Request::is('entreprises*') || Request::is('departements*') || Request::is('services*') || Request::is('utilisateurs*') || Request::is('roles*') ? 'active' : '' }}" data-submenu="parametres" data-tooltip="Paramètres">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="nav-text">Paramètres</span>
                </button>
                <div class="submenu">
                    @can('view-settings')
                    <a href="{{ route('parametres.general') }}" class="submenu-link {{ Request::is('parametres/general*') ? 'active' : '' }}">
                        <span>Général</span>
                    </a>
                    @endcan

                    @if(auth()->user()->hasRole('Super Admin'))
                        @can('view-entreprises')
                        <a href="{{ route('entreprises.index') }}" class="submenu-link {{ Request::is('entreprises*') ? 'active' : '' }}">
                            <span>Entreprises</span>
                        </a>
                        @endcan
                    @endif

                    @can('view-departements')
                    <a href="{{ route('departements.index') }}" class="submenu-link {{ Request::is('departements*') ? 'active' : '' }}">
                        <span>Départements</span>
                    </a>
                    @endcan

                    @can('view-services')
                    <a href="{{ route('services.index') }}" class="submenu-link {{ Request::is('services*') ? 'active' : '' }}">
                        <span>Services</span>
                    </a>
                    @endcan

                    @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
                        @can('view-users')
                        <a href="{{ route('utilisateurs.index') }}" class="submenu-link {{ Request::is('utilisateurs*') ? 'active' : '' }}">
                            <span>Utilisateurs</span>
                        </a>
                        @endcan
                    @endif

                    @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
                        @can('view-roles')
                        <a href="{{ route('parametres.roles') }}" class="submenu-link {{ Request::is('parametres/roles') && !Request::is('parametres/roles-permissions') ? 'active' : '' }}">
                            <span>Rôles</span>
                        </a>
                        @endcan
                    @endif

                    @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
                        @can('manage-permissions')
                        <a href="{{ route('parametres.permissions') }}" class="submenu-link {{ Request::is('parametres/permissions') ? 'active' : '' }}">
                            <span>Permissions</span>
                        </a>
                        @endcan
                    @endif

                    @can('view-settings')
                    <a href="{{ route('parametres.security') }}" class="submenu-link {{ Request::is('parametres/security*') ? 'active' : '' }}">
                        <span>Sécurité</span>
                    </a>
                    @endcan
                </div>
            </div>
        </div>
        @endif
    </nav>
</aside>

