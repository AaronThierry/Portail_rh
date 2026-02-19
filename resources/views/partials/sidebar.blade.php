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
            <div class="sidebar-logo-content">
                <span class="sidebar-logo-text">Portail RH</span>
            </div>
        </div>
        <!-- Close Button for Mobile -->
        <button class="sidebar-close-btn" id="sidebarCloseBtn" aria-label="Fermer le menu" onclick="closeMobileSidebar()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <!-- Quick Stats Panel (collapsed on hover) -->
    @php
        $sidebarQuery = \App\Models\Personnel::query();
        if (!auth()->user()->hasRole('Super Admin') && auth()->user()->entreprise_id) {
            $sidebarQuery->where('entreprise_id', auth()->user()->entreprise_id);
        }
        $personnelCount = $sidebarQuery->count();
        $activeCount    = (clone $sidebarQuery)->actif()->count();

        // Badges requêtes
        $requetesNonLues = 0;
        if (auth()->user()->hasRole("Chef d'Entreprise")) {
            $requetesNonLues = \App\Models\Requete::where('user_id', auth()->id())
                ->where('lu_par_chef', false)
                ->where('statut', 'repondue')
                ->count();
        }
        $requetesAdminNonLues = 0;
        if (auth()->user()->hasRole('Super Admin')) {
            $requetesAdminNonLues = \App\Models\Requete::where('lu_par_admin', false)
                ->whereIn('statut', ['en_attente', 'en_cours'])
                ->count();
        }
    @endphp
    <div class="sidebar-quick-stats">
        <div class="quick-stat-item">
            <span class="quick-stat-value">{{ $personnelCount }}</span>
            <span class="quick-stat-label">Employés</span>
        </div>
        <div class="quick-stat-divider"></div>
        <div class="quick-stat-item">
            <span class="quick-stat-value success">{{ $activeCount }}</span>
            <span class="quick-stat-label">Actifs</span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="sidebar-nav">
        <!-- SECTION: Accueil -->
        <div class="nav-section">
            <div class="nav-section-header">
                <span class="nav-section-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/>
                        <rect x="14" y="14" width="7" height="7" rx="1"/>
                    </svg>
                </span>
                <span class="nav-section-title">Accueil</span>
            </div>
            <div class="nav-items">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::is('admin') || Request::is('admin/dashboard') ? 'active' : '' }}" data-tooltip="Tableau de bord">
                    <span class="nav-link-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                    </span>
                    <span class="nav-link-text">Tableau de bord</span>
                    <span class="nav-link-indicator"></span>
                </a>
            </div>
        </div>

        <!-- SECTION: Ressources Humaines -->
        @if(auth()->user()->roles()->exists())
        <div class="nav-section">
            <div class="nav-section-header">
                <span class="nav-section-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </span>
                <span class="nav-section-title">Ressources Humaines</span>
            </div>
            <div class="nav-items">
                @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Manager', 'RH', "Chef d'Entreprise"]))
                    <a href="{{ route('admin.personnels.index') }}" class="nav-link {{ Request::is('admin/personnels*') ? 'active' : '' }}" data-tooltip="Personnel">
                        <span class="nav-link-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </span>
                        <span class="nav-link-text">Gestion du Personnel</span>
                        <span class="nav-link-indicator"></span>
                    </a>

                    <a href="{{ route('admin.dossiers-agents.index') }}" class="nav-link {{ Request::is('admin/dossiers-agents') ? 'active' : '' }}" data-tooltip="Dossiers Agents">
                        <span class="nav-link-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                        </span>
                        <span class="nav-link-text">Dossiers Agents</span>
                        <span class="nav-link-indicator"></span>
                    </a>

                    @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Manager', 'RH']))
                    <a href="{{ route('admin.dossier-agent.categories') }}" class="nav-link {{ Request::is('admin/dossier-agent/categories*') ? 'active' : '' }}" data-tooltip="Répertoires Documents">
                        <span class="nav-link-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                            </svg>
                        </span>
                        <span class="nav-link-text">Répertoires Documents</span>
                        <span class="nav-link-indicator"></span>
                    </a>

                    <a href="{{ route('admin.utilisateurs.index') }}" class="nav-link {{ Request::is('admin/utilisateurs*') ? 'active' : '' }}" data-tooltip="Comptes Utilisateurs">
                        <span class="nav-link-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </span>
                        <span class="nav-link-text">Comptes Utilisateurs</span>
                        <span class="nav-link-indicator"></span>
                    </a>
                    @endif

                @endif
            </div>
        </div>
        @endif

        <!-- SECTION: Gestion Documentaire -->
        @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Manager', 'RH', 'Employé', "Chef d'Entreprise"]))
        <div class="nav-section">
            <div class="nav-section-header">
                <span class="nav-section-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                </span>
                <span class="nav-section-title">Documents & Demandes</span>
            </div>
            <div class="nav-items">
                @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'RH', "Chef d'Entreprise"]))
                <a href="{{ route('admin.bulletins-paie.index') }}" class="nav-link {{ Request::is('admin/bulletins-paie*') ? 'active' : '' }}" data-tooltip="Bulletins de Paie">
                    <span class="nav-link-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <span class="nav-link-text">Bulletins de Paie</span>
                    <span class="nav-link-indicator"></span>
                </a>

                <a href="{{ route('admin.conges.index') }}" class="nav-link {{ Request::is('admin/conges*') ? 'active' : '' }}" data-tooltip="Gestion des Congés">
                    <span class="nav-link-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <span class="nav-link-text">Gestion des Congés</span>
                    @php
                        $isChefSidebar = auth()->user()->hasRole("Chef d'Entreprise");
                        // Chef : uniquement en_attente (étape 1 à traiter)
                        // Super Admin / RH : en_attente + valide_chef (les deux étapes en attente d'action)
                        if ($isChefSidebar) {
                            $pendingCongesQuery = \App\Models\Conge::where('statut', 'en_attente');
                            if (auth()->user()->entreprise_id) {
                                $pendingCongesQuery->forEntreprise(auth()->user()->entreprise_id);
                            }
                        } else {
                            // Super Admin / RH : uniquement valide_chef (prêts pour approbation finale)
                            $pendingCongesQuery = \App\Models\Conge::where('statut', 'valide_chef');
                            if (auth()->user()->hasRole('RH') && auth()->user()->entreprise_id) {
                                $pendingCongesQuery->forEntreprise(auth()->user()->entreprise_id);
                            }
                        }
                        $pendingCongesCount = $pendingCongesQuery->count();
                    @endphp
                    @if($pendingCongesCount > 0)
                        <span class="nav-badge" style="background: linear-gradient(135deg, #FF9500 0%, #FF6B00 100%); color: white;">{{ $pendingCongesCount }}</span>
                    @endif
                </a>

                <a href="{{ route('admin.absences.index') }}" class="nav-link {{ Request::is('admin/absences*') ? 'active' : '' }}" data-tooltip="Gestion des Absences">
                    <span class="nav-link-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" stroke-width="2"/>
                            <line x1="15" y1="9" x2="9" y2="15" stroke-width="2"/>
                            <line x1="9" y1="9" x2="15" y2="15" stroke-width="2"/>
                        </svg>
                    </span>
                    <span class="nav-link-text">Gestion des Absences</span>
                    @php
                        $isChefAbsence = auth()->user()->hasRole("Chef d'Entreprise");
                        // Chef : uniquement en_attente (étape 1)
                        // Super Admin / RH : en_attente + valide_chef
                        if ($isChefAbsence) {
                            $injustifiedQuery = \App\Models\Absence::where('statut', 'en_attente');
                            if (auth()->user()->entreprise_id) {
                                $injustifiedQuery->forEntreprise(auth()->user()->entreprise_id);
                            }
                        } else {
                            $injustifiedQuery = \App\Models\Absence::whereIn('statut', ['en_attente', 'valide_chef']);
                            if (auth()->user()->hasRole('RH') && auth()->user()->entreprise_id) {
                                $injustifiedQuery->forEntreprise(auth()->user()->entreprise_id);
                            }
                        }
                        $injustifiedCount = $injustifiedQuery->count();
                    @endphp
                    @if($injustifiedCount > 0)
                        <span class="nav-badge" style="background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%); color: white;">{{ $injustifiedCount }}</span>
                    @endif
                </a>
                @endif

                @can('view-documents')
                <a href="#" class="nav-link disabled" data-tooltip="Documents" onclick="event.preventDefault();">
                    <span class="nav-link-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </span>
                    <span class="nav-link-text">Documents</span>
                    <span class="nav-badge coming-soon">Bientôt</span>
                </a>
                @endcan

                @can('view-demandes')
                <a href="#" class="nav-link disabled" data-tooltip="Demandes" onclick="event.preventDefault();">
                    <span class="nav-link-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </span>
                    <span class="nav-link-text">Demandes</span>
                    <span class="nav-badge coming-soon">Bientôt</span>
                </a>
                @endcan

                {{-- Requêtes : Chef d'Entreprise --}}
                @if(auth()->user()->hasRole("Chef d'Entreprise"))
                <a href="{{ route('admin.requetes.index') }}" class="nav-link {{ Request::is('admin/requetes*') ? 'active' : '' }}" data-tooltip="Mes Requêtes">
                    <span class="nav-link-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
                        </svg>
                    </span>
                    <span class="nav-link-text">Mes Requêtes</span>
                    @if($requetesNonLues > 0)
                        <span class="nav-badge" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white;">{{ $requetesNonLues }}</span>
                    @endif
                </a>
                @endif

                {{-- Requêtes : Super Admin inbox --}}
                @if(auth()->user()->hasRole('Super Admin'))
                <a href="{{ route('admin.admin-requetes.index') }}" class="nav-link {{ Request::is('admin/admin-requetes*') ? 'active' : '' }}" data-tooltip="Requêtes Clients">
                    <span class="nav-link-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
                        </svg>
                    </span>
                    <span class="nav-link-text">Requêtes Clients</span>
                    @if($requetesAdminNonLues > 0)
                        <span class="nav-badge" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white;">{{ $requetesAdminNonLues }}</span>
                    @endif
                </a>
                @endif
            </div>
        </div>
        @endif

        <!-- SECTION: Organisation -->
        @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
        <div class="nav-section">
            <div class="nav-section-header">
                <span class="nav-section-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </span>
                <span class="nav-section-title">Organisation</span>
            </div>
            <div class="nav-items">
                @if(auth()->user()->hasRole('Super Admin'))
                    @can('view-entreprises')
                    <a href="{{ route('admin.entreprises.index') }}" class="nav-link {{ Request::is('admin/entreprises*') ? 'active' : '' }}" data-tooltip="Entreprises">
                        <span class="nav-link-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </span>
                        <span class="nav-link-text">Entreprises</span>
                        <span class="nav-link-indicator"></span>
                    </a>
                    @endcan
                @endif

            </div>
        </div>
        @endif

        <!-- SECTION: Administration -->
        @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
        <div class="nav-section">
            <div class="nav-section-header">
                <span class="nav-section-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                    </svg>
                </span>
                <span class="nav-section-title">Administration</span>
            </div>
            <div class="nav-items">
                @can('view-settings')
                <a href="{{ route('admin.settings.index') }}" class="nav-link {{ Request::is('admin/settings*') ? 'active' : '' }}" data-tooltip="Paramètres">
                    <span class="nav-link-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                    </span>
                    <span class="nav-link-text">Paramètres</span>
                    <span class="nav-link-indicator"></span>
                </a>
                @endcan

                @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
                    @can('view-roles')
                    <a href="{{ route('admin.roles.index') }}" class="nav-link {{ Request::is('admin/roles*') ? 'active' : '' }}" data-tooltip="Gestion des Rôles">
                        <span class="nav-link-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </span>
                        <span class="nav-link-text">Rôles</span>
                        <span class="nav-link-indicator"></span>
                    </a>
                    @endcan

                    @can('manage-permissions')
                    <a href="{{ route('admin.permissions.index') }}" class="nav-link {{ Request::is('admin/permissions*') ? 'active' : '' }}" data-tooltip="Gestion des Permissions">
                        <span class="nav-link-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                        </span>
                        <span class="nav-link-text">Permissions</span>
                        <span class="nav-link-indicator"></span>
                    </a>
                    @endcan
                @endif
            </div>
        </div>
        @endif
    </nav>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <div class="sidebar-tagline">
            <span class="tagline-text">Valoriser l'humain, optimiser la performance</span>
        </div>
        <div class="sidebar-footer-bottom">
            <div class="sidebar-version">
                <span class="version-dot"></span>
                <span class="version-text">v1.0.0</span>
            </div>
            <div class="sidebar-help">
                <a href="#" class="help-link" title="Centre d'aide">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                        <line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</aside>

<script>
// Global function to close mobile sidebar
function closeMobileSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const burger = document.getElementById('mobileMenuButton');

    if (sidebar) sidebar.classList.remove('mobile-open');
    if (overlay) overlay.classList.remove('active');
    if (burger) burger.classList.remove('active');
    document.body.style.overflow = '';
}
</script>
