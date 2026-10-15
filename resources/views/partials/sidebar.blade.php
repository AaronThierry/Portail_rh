{{-- Barre latérale admin — Direction B « l'année » --}}
@php
    $sbUser = auth()->user();
    $sbCounts = \App\Support\AdminQueue::counts($sbUser);
    $sbEntreprise = $sbUser->entreprise ?? null;
    $sbIsSuper = $sbUser->hasRole('Super Admin');
    $sbIsChef = $sbUser->hasRole("Chef d'Entreprise");
    $sbRh = $sbUser->hasAnyRole(['Super Admin', 'Admin', 'Manager', 'RH', "Chef d'Entreprise", 'Agent administratif']);
    $sbPaie = $sbUser->hasAnyRole(['Super Admin', 'Admin', 'RH', "Chef d'Entreprise", 'Agent administratif']);
    $sbRepertoires = $sbUser->hasAnyRole(['Super Admin', 'Admin', 'Manager', 'RH', 'Agent administratif']);
    $sbOrga = $sbUser->hasAnyRole(['Super Admin', 'Admin']);
    $sbPill = fn ($n) => $n > 0 ? '<span class="sb-count" aria-label="' . $n . ' à traiter">' . ($n > 99 ? '99+' : $n) . '</span>' : '';
@endphp

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<aside class="sidebar" id="sidebar" aria-label="Navigation de l'administration">
    <div class="sb-top">
        <a href="{{ route('admin.dashboard') }}" class="sb-logo" aria-label="Portail RH+, accueil">Portail RH<b>+</b></a>
        <button type="button" class="sidebar-close-btn" id="sidebarCloseBtn" aria-label="Fermer le menu" onclick="closeMobileSidebar()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M18 6 6 18M6 6l12 12"/></svg>
        </button>
    </div>

    <div class="sb-org" title="{{ $sbEntreprise->nom ?? 'Toutes les entreprises' }}">
        <span class="sb-org-ico" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 9h1M9 13h1M14 9h1M14 13h1M10 21v-4h4v4"/></svg>
        </span>
        <span class="sb-org-txt">
            <span class="sb-org-name">{{ $sbEntreprise->nom ?? ($sbIsSuper ? 'Toutes les entreprises' : 'Mon entreprise') }}</span>
            <span class="sb-org-role">{{ $sbUser->roles->first()->name ?? 'Utilisateur' }}</span>
        </span>
        @if($sbIsSuper && Route::has('admin.entreprises.index'))
            <a href="{{ route('admin.entreprises.index') }}" class="sb-org-link" aria-label="Voir les entreprises">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
            </a>
        @endif
    </div>

    <nav class="sidebar-nav" aria-label="Menu principal">
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::is('admin') || Request::is('admin/dashboard') ? 'active' : '' }}" @if(Request::is('admin') || Request::is('admin/dashboard')) aria-current="page" @endif>
            <svg class="sb-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            <span class="nav-link-text">À traiter</span>{!! $sbPill($sbCounts['total']) !!}
        </a>

        @if($sbRh)
            <a href="{{ route('admin.personnels.index') }}" class="nav-link {{ Request::is('admin/personnels*') ? 'active' : '' }}">
                <svg class="sb-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <span class="nav-link-text">Personnel</span>
            </a>
        @endif

        @if($sbPaie)
            <a href="{{ route('admin.conges.index') }}" class="nav-link {{ Request::is('admin/conges*') ? 'active' : '' }}">
                <svg class="sb-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                <span class="nav-link-text">Congés</span>{!! $sbPill($sbCounts['conges']) !!}
            </a>
            <a href="{{ route('admin.absences.index') }}" class="nav-link {{ Request::is('admin/absences*') ? 'active' : '' }}">
                <svg class="sb-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                <span class="nav-link-text">Absences</span>{!! $sbPill($sbCounts['absences']) !!}
            </a>
            <a href="{{ route('admin.bulletins-paie.index') }}" class="nav-link {{ Request::is('admin/bulletins-paie*') ? 'active' : '' }}">
                <svg class="sb-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M8 13h8M8 17h5"/></svg>
                <span class="nav-link-text">Bulletins de paie</span>
            </a>
        @endif

        @if($sbRh)
            <a href="{{ route('admin.dossiers-agents.index') }}" class="nav-link {{ Request::is('admin/dossiers-agents*') ? 'active' : '' }}">
                <svg class="sb-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                <span class="nav-link-text">Dossiers agents</span>
            </a>
            @if($sbRepertoires)
                <a href="{{ route('admin.dossier-agent.categories') }}" class="nav-link {{ Request::is('admin/dossier-agent/categories*') ? 'active' : '' }}">
                    <svg class="sb-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 7v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-6l-2-2H5a2 2 0 0 0-2 2z"/><path d="M8 13h8"/></svg>
                    <span class="nav-link-text">Répertoires</span>
                </a>
            @endif
        @endif

        @if($sbIsChef)
            <a href="{{ route('admin.requetes.index') }}" class="nav-link {{ Request::is('admin/requetes*') ? 'active' : '' }}">
                <svg class="sb-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                <span class="nav-link-text">Mes requêtes</span>{!! $sbPill($sbCounts['requetes']) !!}
            </a>
        @endif
        @if($sbIsSuper)
            <a href="{{ route('admin.admin-requetes.index') }}" class="nav-link {{ Request::is('admin/admin-requetes*') ? 'active' : '' }}">
                <svg class="sb-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                <span class="nav-link-text">Requêtes clients</span>{!! $sbPill($sbCounts['requetes']) !!}
            </a>
        @endif

        <a href="{{ route('admin.assistant.index') }}" class="nav-link {{ Request::is('admin/assistant*') ? 'active' : '' }}">
            <svg class="sb-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l1.9 4.6L18.5 9.5l-4.6 1.9L12 16l-1.9-4.6L5.5 9.5l4.6-1.9z"/><path d="M19 15l.8 2 2 .8-2 .8-.8 2-.8-2-2-.8 2-.8z"/></svg>
            <span class="nav-link-text">Assistant IA</span>
        </a>

        @if($sbOrga)
            <p class="sb-section">Organisation</p>
            @if($sbIsSuper)
                @can('view-entreprises')
                <a href="{{ route('admin.entreprises.index') }}" class="nav-link {{ Request::is('admin/entreprises*') ? 'active' : '' }}">
                    <svg class="sb-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 21h18M5 21V7l7-4 7 4v14M10 21v-4h4v4"/></svg>
                    <span class="nav-link-text">Entreprises</span>
                </a>
                @endcan
            @endif
            @if($sbRepertoires)
                <a href="{{ route('admin.utilisateurs.index') }}" class="nav-link {{ Request::is('admin/utilisateurs*') ? 'active' : '' }}">
                    <svg class="sb-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg>
                    <span class="nav-link-text">Comptes utilisateurs</span>
                </a>
            @endif
            @can('view-roles')
            <a href="{{ route('admin.roles.index') }}" class="nav-link {{ Request::is('admin/roles*') ? 'active' : '' }}">
                <svg class="sb-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                <span class="nav-link-text">Rôles</span>
            </a>
            @endcan
            @can('manage-permissions')
            <a href="{{ route('admin.permissions.index') }}" class="nav-link {{ Request::is('admin/permissions*') ? 'active' : '' }}">
                <svg class="sb-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                <span class="nav-link-text">Permissions</span>
            </a>
            @endcan
            @can('view-settings')
            <a href="{{ route('admin.settings.index') }}" class="nav-link {{ Request::is('admin/settings*') ? 'active' : '' }}">
                <svg class="sb-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .3 1.8l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.8-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1.1-1.5 1.7 1.7 0 0 0-1.8.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.8 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.5-1.1 1.7 1.7 0 0 0-.3-1.8l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.8.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.8-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.8V9a1.7 1.7 0 0 0 1.5 1H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1z"/></svg>
                <span class="nav-link-text">Paramètres</span>
            </a>
            @endcan
        @endif
    </nav>

    <div class="sb-foot">
        <span>Portail RH<b>+</b> · RHPLUS</span>
    </div>
</aside>

<script>
function closeMobileSidebar() {
    var sidebar = document.getElementById('sidebar');
    var overlay = document.getElementById('sidebarOverlay');
    var burger = document.getElementById('mobileMenuButton');
    if (sidebar) sidebar.classList.remove('mobile-open');
    if (overlay) overlay.classList.remove('active');
    if (burger) burger.classList.remove('active');
    document.body.style.overflow = '';
}
</script>
