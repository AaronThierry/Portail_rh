@extends('layouts.app')

@section('title', 'Gestion des Utilisateurs')
@section('page-title', 'Comptes utilisateurs')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/>
    <line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/>
</svg>
@endsection

@section('styles')
<style>
    .us-toolbar { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
    .us-toolbar .rh-input { max-width: 300px; min-height: 44px; }
    .us-filters { display: flex; gap: 6px; }
    .us-filters button {
        height: 38px; padding: 0 14px; border-radius: 999px; border: 1px solid var(--line-soft);
        background: var(--surface); color: var(--muted); font: 600 13px var(--font); cursor: pointer;
    }
    .us-filters button.active { background: var(--brand); border-color: var(--brand); color: #fff; }

    .us-table-wrap { overflow-x: auto; }
    .us-table { width: 100%; border-collapse: collapse; font-size: 14px; }
    .us-table thead th {
        padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 700; color: var(--faint);
        text-transform: uppercase; letter-spacing: .06em; white-space: nowrap; border-bottom: 1px solid var(--line-soft);
    }
    .us-table tbody tr { border-top: 1px solid var(--line-soft); }
    .us-table tbody tr:first-child { border-top: 0; }
    .us-table tbody tr:hover { background: var(--page); }
    .us-table tbody td { padding: 11px 16px; color: var(--ink); vertical-align: middle; white-space: nowrap; }
    .us-person { display: flex; align-items: center; gap: 12px; }
    .us-avatar { width: 38px; height: 38px; border-radius: 999px; object-fit: cover; flex-shrink: 0; }
    .us-name { font-weight: 600; display: block; line-height: 1.3; }
    .us-email { font-size: 12.5px; color: var(--faint); display: block; }
    .us-act { width: 34px; height: 34px; border-radius: 10px; border: 0; background: transparent; color: var(--muted); display: inline-flex; align-items: center; justify-content: center; cursor: pointer; text-decoration: none; }
    .us-act svg { width: 16px; height: 16px; }
    .us-act:hover { background: var(--subtle); color: var(--ink); }
    .us-act.del:hover { background: var(--no-bg); color: var(--no); }

    .us-ss { position: relative; }
    .us-ss-dd {
        position: absolute; top: calc(100% + 6px); left: 0; right: 0; z-index: 60;
        background: var(--surface); border: 1px solid var(--line-soft); border-radius: var(--radius);
        box-shadow: 0 16px 48px rgba(15,23,42,.16); max-height: 220px; overflow-y: auto; display: none;
    }
    .us-ss-dd.open { display: block; }
    .us-ss-opt { padding: 10px 14px; cursor: pointer; font-size: 14px; }
    .us-ss-opt:hover { background: var(--subtle); }
    .us-ss-opt.hidden { display: none; }
    .us-ss-empty { padding: 14px; text-align: center; font-size: 13px; color: var(--muted); }
</style>
@endsection

@section('content')
<div class="rh-page">
    @if(session('success'))
        <div class="rh-alert ok" role="status"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg><span>{{ session('success') }}</span></div>
    @endif
    @if(session('error'))
        <div class="rh-alert err" role="alert"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 8v5M12 16h.01"/></svg><span>{{ session('error') }}</span></div>
    @endif
    @if($errors->any())
        <div class="rh-alert err" role="alert"><span>{{ $errors->first() }}</span></div>
    @endif

    <section class="rh-head">
        <div class="rh-head-txt">
            <h1 class="rh-h1">Comptes utilisateurs</h1>
            <p class="rh-lead">Accès et permissions des comptes liés au personnel.</p>
        </div>
        @can('create-users')
        <div class="rh-actions">
            <button type="button" class="rh-btn" id="usBtnAdd">Créer un compte</button>
        </div>
        @endcan
    </section>

    <div class="rh-figures">
        <div class="rh-figure"><strong>{{ $users->count() }}</strong><span>compte{{ $users->count() > 1 ? 's' : '' }}</span></div>
        <div class="rh-figure"><strong>{{ $users->where('status', 'active')->count() }}</strong><span>actifs</span></div>
        <div class="rh-figure"><strong>{{ $users->where('status', 'inactive')->count() }}</strong><span>inactifs</span></div>
        <div class="rh-figure"><strong>{{ $users->filter(fn($u) => !$u->personnel)->count() }}</strong><span>sans personnel lié</span></div>
    </div>

    <div class="us-toolbar">
        <input type="text" class="rh-input" id="usSearchInput" placeholder="Rechercher par nom, email ou rôle…">
        <div class="us-filters">
            <button type="button" class="active" data-filter="all">Tous <span>({{ $users->count() }})</span></button>
            <button type="button" data-filter="active">Actifs <span>({{ $users->where('status', 'active')->count() }})</span></button>
            <button type="button" data-filter="inactive">Inactifs <span>({{ $users->where('status', 'inactive')->count() }})</span></button>
        </div>
    </div>

    <div class="rh-card-flat">
        @if($users->count() > 0)
        <div class="us-table-wrap">
            <table class="us-table" id="usTable">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Personnel associé</th>
                        <th>Rôle</th>
                        <th>Statut</th>
                        <th>2FA</th>
                        <th>Créé le</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        @php $roleName = $user->getRoleNames()->first() ?? 'Aucun rôle'; @endphp
                        <tr data-status="{{ $user->status }}" data-search="{{ strtolower($user->name . ' ' . $user->email . ' ' . $roleName) }}">
                            <td>
                                <div class="us-person">
                                    <img src="{{ $user->avatar ? asset($user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=2563EB&color=fff&bold=true' }}" alt="" class="us-avatar">
                                    <div>
                                        <span class="us-name">{{ $user->name }}</span>
                                        <span class="us-email">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($user->personnel)
                                    <a href="{{ route('admin.personnels.show', $user->personnel->id) }}" class="rh-link">{{ $user->personnel->matricule }} — {{ $user->personnel->nom_complet }}</a>
                                @else
                                    <span class="pp-muted">Aucun</span>
                                @endif
                            </td>
                            <td><span class="rh-badge info">{{ $roleName }}</span></td>
                            <td><span class="rh-badge {{ $user->status === 'active' ? 'ok' : 'no' }}">{{ $user->status === 'active' ? 'Actif' : 'Inactif' }}</span></td>
                            <td><span class="rh-badge {{ $user->google2fa_enabled ? 'ok' : 'off' }}">{{ $user->google2fa_enabled ? 'Activée' : 'Désactivée' }}</span></td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('admin.utilisateurs.show', $user->id) }}" class="us-act" title="Voir">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>
                                @can('edit-users')
                                <a href="{{ route('admin.utilisateurs.edit', $user->id) }}" class="us-act" title="Modifier">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </a>
                                @endcan
                                @can('delete-users')
                                <form method="POST" action="{{ route('admin.utilisateurs.destroy', $user->id) }}" onsubmit="return confirm('Supprimer cet utilisateur ? Cette action est irréversible.')" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="us-act del" title="Supprimer">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <div class="rh-empty">
                <strong>Aucun compte utilisateur</strong>
                <p>Commencez par créer un compte pour votre personnel.</p>
            </div>
        @endif
    </div>
</div>

{{-- ── Nouveau compte ── --}}
<div class="rh-sheet" id="usModal" role="dialog" aria-modal="true" aria-labelledby="usModalTitre">
    <div class="rh-sheet-box">
        <div class="rh-sheet-grip"></div>
        <div class="rh-sheet-head">
            <div>
                <h2 id="usModalTitre">Créer un compte</h2>
                <p>Le mot de passe est généré automatiquement et envoyé à l'employé.</p>
            </div>
            <button type="button" class="rh-iconbtn" id="usModalClose" aria-label="Fermer">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg>
            </button>
        </div>

        <form id="usForm" action="{{ route('admin.utilisateurs.store') }}" method="POST" class="rh-form">
            @csrf

            <div class="rh-field">
                <label for="usPersonnelInput">Employé</label>
                <div class="us-ss" id="usPersonnelSearch">
                    <input type="text" class="rh-input" id="usPersonnelInput" placeholder="Rechercher un employé…" autocomplete="off">
                    <input type="hidden" id="usPersonnelId" name="personnel_id" required>
                    <div class="us-ss-dd" id="usPersonnelDropdown">
                        @foreach($personnels_sans_compte ?? [] as $personnel)
                            <div class="us-ss-opt"
                                 data-value="{{ $personnel->id }}"
                                 data-text="{{ $personnel->matricule }} — {{ $personnel->nom_complet }}{{ $personnel->poste ? ' (' . $personnel->poste . ')' : '' }}"
                                 data-email="{{ $personnel->email }}">
                                {{ $personnel->matricule }} — {{ $personnel->nom_complet }}
                            </div>
                        @endforeach
                        <div class="us-ss-empty" id="usNoResults" style="display:none">Aucun résultat</div>
                    </div>
                </div>
            </div>

            <div class="rh-field">
                <label for="usEmail">Adresse e-mail</label>
                <input type="email" id="usEmail" name="email" class="rh-input" placeholder="prenom.nom@entreprise.com" required>
                <p class="rh-hint">Pré-remplie depuis la fiche de l'employé — modifiable si besoin.</p>
            </div>

            <div class="rh-grid2">
                <div class="rh-field">
                    <label for="usRole">Rôle</label>
                    <select id="usRole" name="role" class="rh-select" required>
                        <option value="">— Choisir —</option>
                        @if(auth()->user()->hasRole('Super Admin'))
                            <option value="Super Admin">Super Administrateur</option>
                        @endif
                        <option value="Admin">Administrateur</option>
                        <option value="Manager">Manager</option>
                        <option value="RH">Ressources Humaines</option>
                        <option value="Employé">Employé</option>
                        @if(auth()->user()->hasRole('Super Admin'))
                            <option value="Chef d'Entreprise">Chef d'Entreprise</option>
                        @endif
                    </select>
                </div>
                <div class="rh-field">
                    <label for="usStatus">Statut</label>
                    <select id="usStatus" name="status" class="rh-select">
                        <option value="active" selected>Actif</option>
                        <option value="inactive">Inactif</option>
                    </select>
                </div>
            </div>

            <div class="rh-sheet-foot">
                <button type="button" class="rh-btn soft" id="usBtnCancel">Annuler</button>
                <button type="submit" class="rh-btn" id="usBtnSubmit">Créer le compte</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
// ── Recherche / filtre ──
const usSearchInput = document.getElementById('usSearchInput');
const usRows = document.querySelectorAll('#usTable tbody tr');
let usCurrentFilter = 'all';

function usFilterRows() {
    const term = (usSearchInput.value || '').toLowerCase();
    usRows.forEach(row => {
        const matchesFilter = usCurrentFilter === 'all' || row.dataset.status === usCurrentFilter;
        const matchesSearch = !term || row.dataset.search.includes(term);
        row.style.display = matchesFilter && matchesSearch ? '' : 'none';
    });
}
usSearchInput?.addEventListener('input', usFilterRows);
document.querySelectorAll('.us-filters button').forEach(btn => {
    btn.addEventListener('click', function () {
        document.querySelectorAll('.us-filters button').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        usCurrentFilter = this.dataset.filter;
        usFilterRows();
    });
});

// ── Modal ──
const usModal = document.getElementById('usModal');
document.getElementById('usBtnAdd')?.addEventListener('click', () => {
    usModal.classList.add('open');
    document.body.style.overflow = 'hidden';
});
function usCloseModal() {
    usModal.classList.remove('open');
    document.body.style.overflow = '';
}
document.getElementById('usModalClose')?.addEventListener('click', usCloseModal);
document.getElementById('usBtnCancel')?.addEventListener('click', usCloseModal);
usModal?.addEventListener('click', e => { if (e.target === usModal) usCloseModal(); });
document.addEventListener('keydown', e => { if (e.key === 'Escape' && usModal.classList.contains('open')) usCloseModal(); });

document.getElementById('usForm')?.addEventListener('submit', function () {
    const btn = document.getElementById('usBtnSubmit');
    btn.disabled = true;
    btn.textContent = 'Création en cours…';
});

// ── Sélecteur employé avec recherche ──
(function () {
    const wrapper = document.getElementById('usPersonnelSearch');
    if (!wrapper) return;
    const input = document.getElementById('usPersonnelInput');
    const hidden = document.getElementById('usPersonnelId');
    const dropdown = document.getElementById('usPersonnelDropdown');
    const options = wrapper.querySelectorAll('.us-ss-opt');
    const noResults = document.getElementById('usNoResults');
    const emailInput = document.getElementById('usEmail');

    function open() { dropdown.classList.add('open'); }
    function close() { dropdown.classList.remove('open'); }

    input.addEventListener('focus', () => { open(); filter(); });
    input.addEventListener('input', () => { hidden.value = ''; open(); filter(); });

    function filter() {
        const term = input.value.toLowerCase().trim();
        let visible = 0;
        options.forEach(opt => {
            const match = opt.dataset.text.toLowerCase().includes(term);
            opt.classList.toggle('hidden', !match);
            if (match) visible++;
        });
        noResults.style.display = visible === 0 ? 'block' : 'none';
    }

    options.forEach(opt => {
        opt.addEventListener('mousedown', e => {
            e.preventDefault();
            hidden.value = opt.dataset.value;
            input.value = opt.dataset.text;
            if (opt.dataset.email && emailInput) emailInput.value = opt.dataset.email;
            close();
        });
    });

    document.addEventListener('click', e => {
        if (!wrapper.contains(e.target)) {
            if (!hidden.value) input.value = '';
            close();
        }
    });
})();
</script>
@endsection
