{{-- Barre du haut admin — Direction B « l'année » --}}
@php
    $hdUser = auth()->user();
    $hdAvatar = $hdUser->avatar
        ? asset(str_starts_with($hdUser->avatar, 'storage/') ? $hdUser->avatar : 'storage/' . $hdUser->avatar)
        : null;
    $hdParts = preg_split('/\s+/', trim($hdUser->name ?? 'Admin'));
    $hdInitiales = mb_strtoupper(mb_substr($hdParts[0] ?? 'A', 0, 1) . mb_substr($hdParts[1] ?? '', 0, 1));
    // Recherche un agent → renvoie vers la gestion du personnel, que le Chef
    // d'Entreprise n'a plus dans son menu (voir partials/sidebar.blade.php).
    $hdSearch = $hdUser->hasAnyRole(['Super Admin', 'Admin', 'Manager', 'RH', 'Agent administratif']);
    // Le Chef d'Entreprise n'a pas de sidebar : sa navigation (4 liens) tient
    // dans une navbar horizontale ici, comme .rh-topnav côté espace employé.
    $hdIsChef = $hdUser->hasRole("Chef d'Entreprise");
    $hdCounts = $hdIsChef ? \App\Support\AdminQueue::counts($hdUser) : null;
@endphp

<header class="app-header">
    <div class="header-container">
        @unless($hdIsChef)
        <button type="button" class="mobile-menu-btn" id="mobileMenuButton" aria-label="Ouvrir le menu" aria-controls="sidebar">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h10"/></svg>
        </button>
        @endunless

        @if($hdIsChef)
            <a href="{{ route('admin.dashboard') }}" class="hd-logo">Portail RH<b>+</b></a>
            <nav class="hd-nav" aria-label="Navigation principale">
                <a href="{{ route('admin.dashboard') }}" @if(Request::is('admin') || Request::is('admin/dashboard')) aria-current="page" @endif>
                    À traiter{!! $hdCounts['total'] > 0 ? ' · ' . min($hdCounts['total'], 99) : '' !!}
                </a>
                <a href="{{ route('admin.conges.index') }}" @if(Request::is('admin/conges*')) aria-current="page" @endif>Congés</a>
                <a href="{{ route('admin.absences.index') }}" @if(Request::is('admin/absences*')) aria-current="page" @endif>Absences</a>
                <a href="{{ route('admin.requetes.index') }}" @if(Request::is('admin/requetes*')) aria-current="page" @endif>Mes requêtes</a>
            </nav>
        @else
        <div class="header-title">
            <span class="page-title">@yield('page-title', 'Tableau de bord')</span>
        </div>
        @endif

        @if($hdSearch)
        <form class="hd-search" role="search" method="GET" action="{{ route('admin.personnels.index') }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
            <label for="hdSearchInput" class="sr-only">Rechercher un agent</label>
            <input id="hdSearchInput" type="search" name="search" value="{{ request()->is('admin/personnels*') ? request('search') : '' }}" placeholder="Rechercher un agent, un matricule…" autocomplete="off">
        </form>
        @endif

        <div class="header-actions">
            <button type="button" class="hd-btn theme-toggle" data-theme-toggle aria-label="Changer le thème">
                <svg class="sun-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M6.3 17.7l-1.4 1.4M19.1 4.9l-1.4 1.4"/></svg>
                <svg class="moon-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12.8A9 9 0 1 1 11.2 3 7 7 0 0 0 21 12.8z"/></svg>
            </button>

            <div class="header-dropdown-wrapper">
                <button type="button" class="hd-btn" id="notificationBtn" aria-label="Notifications" aria-haspopup="true" aria-expanded="false">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.7 21a2 2 0 0 1-3.4 0"/></svg>
                    <span class="hd-dot" id="adminNotifBadge" style="display:none;">0</span>
                </button>
                <div class="header-dropdown hd-panel" id="notificationDropdown" role="dialog" aria-label="Notifications">
                    <div class="hd-panel-head">
                        <div>
                            <strong>Notifications</strong>
                            <span class="hd-muted" id="adminNotifCount">0 nouvelle</span>
                        </div>
                        <button type="button" class="hd-link" id="adminMarkAllRead">Tout marquer comme lu</button>
                    </div>
                    <div class="hd-panel-body" id="adminNotifList">
                        <p class="hd-empty">Aucune notification</p>
                    </div>
                    <div id="adminNotifFooter" style="display:none;"></div>
                </div>
            </div>

            <div class="header-dropdown-wrapper">
                <button type="button" class="hd-user" id="userMenuBtn" aria-label="Menu utilisateur" aria-haspopup="true" aria-expanded="false">
                    @if($hdAvatar)
                        <img src="{{ $hdAvatar }}" alt="" class="hd-av">
                    @else
                        <span class="hd-av" aria-hidden="true">{{ $hdInitiales }}</span>
                    @endif
                    <span class="hd-user-txt">
                        <span class="hd-user-name">{{ $hdUser->name ?? 'Admin' }}</span>
                        <span class="hd-user-role">{{ $hdUser->roles->first()->name ?? 'Utilisateur' }}</span>
                    </span>
                    <svg class="hd-caret" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <div class="header-dropdown hd-panel hd-menu" id="userDropdown">
                    <div class="hd-menu-who">
                        <strong>{{ $hdUser->name ?? 'Utilisateur' }}</strong>
                        <span class="hd-muted">{{ $hdUser->email }}</span>
                    </div>
                    <a href="{{ route('admin.profile.index') }}" class="hd-menu-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg>
                        Mon profil
                    </a>
                    @can('view-settings')
                    <a href="{{ route('admin.settings.index') }}" class="hd-menu-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="3"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3M4.9 4.9 7 7M17 17l2.1 2.1M4.9 19.1 7 17M17 7l2.1-2.1"/></svg>
                        Paramètres
                    </a>
                    @endcan
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="hd-menu-item danger">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/></svg>
                            Se déconnecter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

@if($hdIsChef)
<nav class="hd-bottom" aria-label="Navigation principale">
    <a href="{{ route('admin.dashboard') }}" @if(Request::is('admin') || Request::is('admin/dashboard')) aria-current="page" @endif>
        <span class="hd-bi">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            @if($hdCounts['total'] > 0)<span class="hd-bi-dot"></span>@endif
        </span>
        À traiter
    </a>
    <a href="{{ route('admin.conges.index') }}" @if(Request::is('admin/conges*')) aria-current="page" @endif>
        <span class="hd-bi"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg></span>
        Congés
    </a>
    <a href="{{ route('admin.absences.index') }}" @if(Request::is('admin/absences*')) aria-current="page" @endif>
        <span class="hd-bi"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></span>
        Absences
    </a>
    <a href="{{ route('admin.requetes.index') }}" @if(Request::is('admin/requetes*')) aria-current="page" @endif>
        <span class="hd-bi"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></span>
        Requêtes
    </a>
</nav>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
    var notifBtn = document.getElementById('notificationBtn');
    var notifPanel = document.getElementById('notificationDropdown');
    var userBtn = document.getElementById('userMenuBtn');
    var userPanel = document.getElementById('userDropdown');

    function closeAll() {
        [notifPanel, userPanel].forEach(function (p) { if (p) p.classList.remove('show'); });
        [notifBtn, userBtn].forEach(function (b) { if (b) { b.classList.remove('active'); b.setAttribute('aria-expanded', 'false'); } });
    }
    function toggle(btn, panel) {
        if (!btn || !panel) return;
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            var open = !panel.classList.contains('show');
            closeAll();
            if (open) { panel.classList.add('show'); btn.classList.add('active'); btn.setAttribute('aria-expanded', 'true'); }
        });
        panel.addEventListener('click', function (e) { e.stopPropagation(); });
    }
    toggle(notifBtn, notifPanel);
    toggle(userBtn, userPanel);
    document.addEventListener('click', closeAll);
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeAll(); });

    // ── Notifications (AJAX) ──
    var badge = document.getElementById('adminNotifBadge');
    var countEl = document.getElementById('adminNotifCount');
    var list = document.getElementById('adminNotifList');
    var markAll = document.getElementById('adminMarkAllRead');
    var csrfMeta = document.querySelector('meta[name="csrf-token"]');
    var csrf = csrfMeta ? csrfMeta.getAttribute('content') : '';

    function esc(s) {
        return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }
    function cut(s, n) { s = s || ''; return s.length > n ? s.substring(0, n) + '…' : s; }
    function safeHref(h) {
        if (!h) return '#';
        try { var u = new URL(h, window.location.origin); return u.origin === window.location.origin ? u.href : '#'; } catch (e) { return '#'; }
    }

    function render(items) {
        if (!items.length) {
            list.innerHTML = '<p class="hd-empty">Tout est lu. Aucune notification en attente.</p>';
            return;
        }
        list.innerHTML = items.map(function (n) {
            var tone = n.status === 'approuve' ? 'ok' : (n.status === 'refuse' ? 'no' : 'info');
            var sub = n.sujet ? cut(n.sujet, 60) : (n.employe ? n.employe + (n.date_debut ? ' · ' + n.date_debut + ' → ' + n.date_fin : '') : '');
            return '<a href="' + esc(safeHref(n.link)) + '" class="hd-notif" data-notif-id="' + esc(n.id) + '">'
                + '<span class="hd-notif-dot ' + tone + '" aria-hidden="true"></span>'
                + '<span class="hd-notif-txt"><span class="hd-notif-title">' + esc(cut(n.message, 90)) + '</span>'
                + (sub ? '<span class="hd-muted">' + esc(sub) + '</span>' : '')
                + '<span class="hd-muted">' + esc(n.created_at) + '</span></span></a>';
        }).join('');
    }

    function load() {
        if (!list) return;
        fetch('/api/notifications', { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, credentials: 'same-origin' })
            .then(function (r) { return r.ok ? r.json() : null; })
            .then(function (data) {
                if (!data) return;
                var items = data.notifications || [];
                var unread = parseInt(data.count, 10) || 0;
                if (badge) { badge.textContent = unread > 99 ? '99+' : unread; badge.style.display = unread > 0 ? '' : 'none'; }
                if (countEl) countEl.textContent = unread + (unread > 1 ? ' nouvelles' : ' nouvelle');
                render(items);
            })
            .catch(function () {});
    }

    if (list) {
        list.addEventListener('click', function (e) {
            var a = e.target.closest('[data-notif-id]');
            if (!a) return;
            e.preventDefault();
            var href = a.getAttribute('href');
            fetch('/api/notifications/' + encodeURIComponent(a.getAttribute('data-notif-id')) + '/read', {
                method: 'POST', credentials: 'same-origin',
                headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            }).finally(function () {
                if (href && href !== '#') { window.location.href = href; } else { a.remove(); load(); }
            });
        });
    }
    if (markAll) {
        markAll.addEventListener('click', function () {
            fetch('/api/notifications/read-all', {
                method: 'POST', credentials: 'same-origin',
                headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            }).then(load).catch(function () {});
        });
    }

    load();
    setInterval(load, 30000);
});
</script>
