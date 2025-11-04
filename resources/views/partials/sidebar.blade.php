<aside class="sidebar" id="sidebar">
    <!-- Logo -->
    <div class="sidebar-header">
        <div class="logo">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32">
                <path fill="currentColor" d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5zm0 18c-3.31 0-6-2.69-6-6s2.69-6 6-6 6 2.69 6 6-2.69 6-6 6zm0-10c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4z"/>
            </svg>
            <span class="logo-text">Portail RH</span>
        </div>
        <button class="sidebar-toggle" id="sidebarToggle" aria-label="Réduire le menu">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="sidebar-nav">
        <!-- Dashboard -->
        <div class="nav-section">
            <a href="/dashboard" class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
                <span class="nav-text">Tableau de bord</span>
            </a>
        </div>

        <!-- Gestion des Employés -->
        <div class="nav-section">
            <p class="nav-section-title">Gestion des Employés</p>

            <a href="/employes" class="nav-item {{ Request::is('employes*') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span class="nav-text">Employés</span>
                <span class="nav-badge">{{ $totalEmployees ?? 0 }}</span>
            </a>

            <a href="/departements" class="nav-item {{ Request::is('departements*') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span class="nav-text">Départements</span>
            </a>

            <a href="/postes" class="nav-item {{ Request::is('postes*') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                </svg>
                <span class="nav-text">Postes</span>
            </a>
        </div>

        <!-- Temps & Présence -->
        <div class="nav-section">
            <p class="nav-section-title">Temps & Présence</p>

            <a href="/pointage" class="nav-item {{ Request::is('pointage*') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                <span class="nav-text">Pointage</span>
            </a>

            <a href="/conges" class="nav-item {{ Request::is('conges*') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                <span class="nav-text">Congés</span>
                <span class="nav-badge warning">{{ $pendingLeaves ?? 0 }}</span>
            </a>

            <a href="/absences" class="nav-item {{ Request::is('absences*') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
                <span class="nav-text">Absences</span>
            </a>

            <a href="/horaires" class="nav-item {{ Request::is('horaires*') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                    <path d="M8 14h.01"></path>
                    <path d="M12 14h.01"></path>
                    <path d="M16 14h.01"></path>
                    <path d="M8 18h.01"></path>
                    <path d="M12 18h.01"></path>
                    <path d="M16 18h.01"></path>
                </svg>
                <span class="nav-text">Horaires</span>
            </a>
        </div>

        <!-- Paie & Rémunération -->
        <div class="nav-section">
            <p class="nav-section-title">Paie & Rémunération</p>

            <a href="/paie" class="nav-item {{ Request::is('paie*') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="1" x2="12" y2="23"></line>
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                </svg>
                <span class="nav-text">Gestion de la paie</span>
            </a>

            <a href="/bulletins" class="nav-item {{ Request::is('bulletins*') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
                <span class="nav-text">Bulletins de paie</span>
            </a>

            <a href="/primes" class="nav-item {{ Request::is('primes*') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="8" r="7"></circle>
                    <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                </svg>
                <span class="nav-text">Primes & Bonus</span>
            </a>
        </div>

        <!-- Recrutement -->
        <div class="nav-section">
            <p class="nav-section-title">Recrutement</p>

            <a href="/offres" class="nav-item {{ Request::is('offres*') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                    <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                </svg>
                <span class="nav-text">Offres d'emploi</span>
            </a>

            <a href="/candidatures" class="nav-item {{ Request::is('candidatures*') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <polyline points="17 11 19 13 23 9"></polyline>
                </svg>
                <span class="nav-text">Candidatures</span>
                <span class="nav-badge info">{{ $newCandidates ?? 0 }}</span>
            </a>

            <a href="/entretiens" class="nav-item {{ Request::is('entretiens*') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
                <span class="nav-text">Entretiens</span>
            </a>
        </div>

        <!-- Formation & Développement -->
        <div class="nav-section">
            <p class="nav-section-title">Formation</p>

            <a href="/formations" class="nav-item {{ Request::is('formations*') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                </svg>
                <span class="nav-text">Formations</span>
            </a>

            <a href="/evaluations" class="nav-item {{ Request::is('evaluations*') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                </svg>
                <span class="nav-text">Évaluations</span>
            </a>

            <a href="/competences" class="nav-item {{ Request::is('competences*') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                </svg>
                <span class="nav-text">Compétences</span>
            </a>
        </div>

        <!-- Documents & Rapports -->
        <div class="nav-section">
            <p class="nav-section-title">Documents</p>

            <a href="/documents" class="nav-item {{ Request::is('documents*') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                    <polyline points="13 2 13 9 20 9"></polyline>
                </svg>
                <span class="nav-text">Documents</span>
            </a>

            <a href="/rapports" class="nav-item {{ Request::is('rapports*') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="20" x2="18" y2="10"></line>
                    <line x1="12" y1="20" x2="12" y2="4"></line>
                    <line x1="6" y1="20" x2="6" y2="14"></line>
                </svg>
                <span class="nav-text">Rapports</span>
            </a>
        </div>

        <!-- Paramètres -->
        <div class="nav-section">
            <p class="nav-section-title">Administration</p>

            <a href="/parametres" class="nav-item {{ Request::is('parametres*') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="3"></circle>
                    <path d="M12 1v6m0 6v6m5.657-13.657l-4.243 4.243m-2.828 2.828l-4.243 4.243m16.97 1.414l-4.243-4.243m-2.828-2.828l-4.243-4.243"></path>
                </svg>
                <span class="nav-text">Paramètres</span>
            </a>

            <a href="{{ route('utilisateurs.index') }}" class="nav-item {{ Request::is('utilisateurs*') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <line x1="20" y1="8" x2="20" y2="14"></line>
                    <line x1="23" y1="11" x2="17" y2="11"></line>
                </svg>
                <span class="nav-text">Utilisateurs</span>
            </a>
        </div>
    </nav>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <div class="storage-info">
            <div class="storage-header">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                </svg>
                <span>Stockage</span>
            </div>
            <div class="storage-bar">
                <div class="storage-used" style="width: 65%"></div>
            </div>
            <p class="storage-text">6.5 GB sur 10 GB utilisés</p>
        </div>
    </div>
</aside>
