@extends('layouts.app')

@section('title', 'Gestion du Personnel')
@section('page-title', 'Personnel')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
</svg>
@endsection

@section('styles')
<style>
    .pp-toolbar { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
    .pp-toolbar .rh-input { max-width: 280px; min-height: 44px; }
    .pp-toolbar .rh-select { min-height: 44px; width: auto; padding-right: 38px; }
    .pp-table-wrap { overflow-x: auto; }
    .pp-table { width: 100%; border-collapse: collapse; font-size: 14px; }
    .pp-table thead th {
        padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 700; color: var(--faint);
        text-transform: uppercase; letter-spacing: .06em; white-space: nowrap; border-bottom: 1px solid var(--line-soft);
    }
    .pp-table tbody tr { border-top: 1px solid var(--line-soft); }
    .pp-table tbody tr:first-child { border-top: 0; }
    .pp-table tbody tr:hover { background: var(--page); }
    .pp-table tbody td { padding: 12px 16px; color: var(--ink); vertical-align: middle; white-space: nowrap; }
    .pp-person { display: flex; align-items: center; gap: 12px; }
    .pp-avatar { width: 38px; height: 38px; border-radius: 999px; object-fit: cover; flex-shrink: 0; }
    .pp-pname { font-weight: 600; display: block; line-height: 1.3; }
    .pp-pmat { font-size: 12px; color: var(--faint); font-family: var(--font); display: block; }
    .pp-date { font-size: 13.5px; color: var(--ink-2); }
    .pp-muted { color: var(--faint); font-style: italic; }
    .pp-act { width: 34px; height: 34px; border-radius: 10px; border: 0; background: transparent; color: var(--muted); display: inline-flex; align-items: center; justify-content: center; cursor: pointer; text-decoration: none; }
    .pp-act svg { width: 16px; height: 16px; }
    .pp-act:hover { background: var(--subtle); color: var(--ink); }
    .pp-act.del:hover { background: var(--no-bg); color: var(--no); }
    .pp-tfoot { display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; border-top: 1px solid var(--line-soft); font-size: 13px; color: var(--muted); }
    .pp-pagination { margin-top: 16px; display: flex; justify-content: center; }
    .pp-pagination .pagination { display: flex; align-items: center; gap: 4px; list-style: none; padding: 0; margin: 0; }
    .pp-pagination .page-link {
        display: flex; align-items: center; justify-content: center; min-width: 36px; height: 36px; padding: 0 10px;
        border-radius: 10px; border: 1px solid var(--line-soft); background: var(--surface); color: var(--ink-2);
        font-size: 13px; font-weight: 600; text-decoration: none;
    }
    .pp-pagination .page-item.active .page-link { background: var(--brand); border-color: var(--brand); color: #fff; }
    .pp-pagination .page-item.disabled .page-link { opacity: .4; }
</style>
@endsection

@section('content')
<div class="rh-page">
    @if(session('success'))
        <div class="rh-alert ok" role="status">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="rh-alert err" role="alert">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 8v5M12 16h.01"/></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <section class="rh-head">
        <div class="rh-head-txt">
            <h1 class="rh-h1">Gestion du personnel</h1>
            <p class="rh-lead">Registre des collaborateurs.</p>
        </div>
        <div class="rh-actions">
            <button type="button" class="rh-btn" id="btnAddPersonnel">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Nouveau personnel
            </button>
        </div>
    </section>

    <div class="rh-figures">
        <div class="rh-figure"><strong>{{ $personnels->total() }}</strong><span>employé{{ $personnels->total() > 1 ? 's' : '' }}</span></div>
        <div class="rh-figure"><strong>{{ $personnels->where('is_active', true)->count() }}</strong><span>actifs</span></div>
        <div class="rh-figure"><strong>{{ $personnels->where('is_active', false)->count() }}</strong><span>inactifs</span></div>
        <div class="rh-figure"><strong>{{ $personnels->whereNull('user_id')->count() }}</strong><span>sans compte</span></div>
    </div>

    <form method="GET" action="{{ request()->url() }}" id="filterForm">
        <div class="pp-toolbar">
            <input type="search" name="search" class="rh-input" id="searchInput"
                   placeholder="Nom, matricule, poste…" value="{{ request('search') }}" autocomplete="off">

            <select name="departement_id" class="rh-select" onchange="this.form.submit()">
                <option value="">Tous les départements</option>
                @foreach($departements as $dept)
                    <option value="{{ $dept->id }}" {{ request('departement_id') == $dept->id ? 'selected' : '' }}>{{ $dept->nom }}</option>
                @endforeach
            </select>

            <select name="type_contrat" class="rh-select" onchange="this.form.submit()">
                <option value="">Tous contrats</option>
                <option value="CDI" {{ request('type_contrat') === 'CDI' ? 'selected' : '' }}>CDI</option>
                <option value="CDD" {{ request('type_contrat') === 'CDD' ? 'selected' : '' }}>CDD</option>
                <option value="Stage" {{ request('type_contrat') === 'Stage' ? 'selected' : '' }}>Stage</option>
                <option value="Consultant" {{ request('type_contrat') === 'Consultant' ? 'selected' : '' }}>Consultant</option>
            </select>

            <select name="has_user" class="rh-select" onchange="this.form.submit()">
                <option value="">Tous statuts</option>
                <option value="yes" {{ request('has_user') === 'yes' ? 'selected' : '' }}>Avec compte</option>
                <option value="no"  {{ request('has_user') === 'no'  ? 'selected' : '' }}>Sans compte</option>
            </select>

            @if(request()->hasAny(['search','departement_id','type_contrat','has_user']))
                <a href="{{ request()->url() }}" class="rh-link">Réinitialiser</a>
            @endif
        </div>
    </form>

    <div class="rh-card-flat">
        <div class="pp-table-wrap">
            <table class="pp-table">
                <thead>
                    <tr>
                        <th>Personnel</th>
                        <th>Sexe</th>
                        <th>Poste</th>
                        <th>Département</th>
                        <th>Date d'embauche</th>
                        <th>Contrat</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="personnelTableBody">
                    @forelse($personnels as $personnel)
                    <tr data-search="{{ strtolower($personnel->nom_complet . ' ' . $personnel->matricule . ' ' . $personnel->poste) }}">
                        <td>
                            <div class="pp-person">
                                <img src="{{ $personnel->photo_url }}" alt="{{ $personnel->nom_complet }}" class="pp-avatar">
                                <div>
                                    <span class="pp-pname">{{ $personnel->nom_complet }}</span>
                                    <span class="pp-pmat">{{ $personnel->matricule }}</span>
                                </div>
                            </div>
                        </td>
                        <td>{{ $personnel->sexe ?? '—' }}</td>
                        <td>{{ $personnel->poste ?? '—' }}</td>
                        <td>{{ $personnel->departement->nom ?? '—' }}</td>
                        <td>
                            @if($personnel->date_embauche)
                                <span class="pp-date">{{ \Carbon\Carbon::parse($personnel->date_embauche)->locale('fr')->isoFormat('DD MMM YYYY') }}</span>
                            @else
                                <span class="pp-muted">N/A</span>
                            @endif
                        </td>
                        <td>
                            @php $tc = $personnel->type_contrat; @endphp
                            <span class="rh-badge {{ $tc === 'CDI' ? 'info' : ($tc === 'CDD' ? 'wait' : 'off') }}">{{ $tc ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <span class="rh-badge {{ $personnel->is_active ? 'ok' : 'no' }}">{{ $personnel->is_active ? 'Actif' : 'Inactif' }}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.personnels.show', $personnel->id) }}" class="pp-act" title="Voir le profil">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>
                            <button type="button" class="pp-act del" title="Supprimer" onclick="deletePersonnel({{ $personnel->id }}, '{{ addslashes($personnel->nom_complet) }}')">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="rh-empty">
                                <strong>Aucun personnel trouvé</strong>
                                <p>Commencez par ajouter votre premier employé.</p>
                                <button type="button" class="rh-btn" onclick="document.getElementById('btnAddPersonnel').click()">Créer un personnel</button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($personnels->count() > 0)
        <div class="pp-tfoot">
            <span>Affichage <strong>{{ $personnels->firstItem() }}–{{ $personnels->lastItem() }}</strong> sur <strong>{{ $personnels->total() }}</strong> employés</span>
            <span id="filterCount"></span>
        </div>
        @endif
    </div>

    @if($personnels->hasPages())
    <div class="pp-pagination">
        {{ $personnels->appends(request()->query())->links() }}
    </div>
    @endif
</div>

@include('personnels.modal_v3_final')
@endsection

@section('scripts')
<script>
/* ── Delete ── */
async function deletePersonnel(id, name) {
    if (!confirm(`Supprimer ${name} ? Cette action est irréversible.`)) return;
    try {
        const res = await fetch(`/admin/personnels/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        const data = await res.json();
        if (data.success) {
            window.location.reload();
        } else {
            alert(data.message || 'Une erreur est survenue.');
        }
    } catch (e) {
        alert('Erreur réseau. Veuillez réessayer.');
    }
}

/* ── Live search (client-side) ── */
document.getElementById('searchInput').addEventListener('input', function () {
    const q = this.value.toLowerCase().trim();
    const rows = document.querySelectorAll('#personnelTableBody tr[data-search]');
    let visible = 0;
    rows.forEach(r => {
        const show = !q || r.dataset.search.includes(q);
        r.style.display = show ? '' : 'none';
        if (show) visible++;
    });
    const fc = document.getElementById('filterCount');
    if (fc) fc.textContent = q ? `${visible} résultat${visible > 1 ? 's' : ''} trouvé${visible > 1 ? 's' : ''}` : '';
});
</script>
@endsection
