@extends('layouts.app')

@section('title', 'Requêtes Clients')
@section('page-title', 'Requêtes Clients')
@section('page-subtitle', 'Inbox des demandes des chefs d\'entreprise')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
</svg>
@endsection

@section('styles')
<style>
.inbox-wrap { padding: 8px 0 48px; display: flex; flex-direction: column; gap: 22px; }

/* Stats row */
.inbox-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; }
@media (max-width: 900px) { .inbox-stats { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 500px) { .inbox-stats { grid-template-columns: 1fr 1fr; } }

.istat {
  background: var(--card-bg);
  border: 1px solid var(--card-border);
  border-radius: var(--border-radius);
  padding: 18px 20px 16px;
  display: flex;
  flex-direction: column;
  gap: 6px;
  position: relative;
  overflow: hidden;
}
.istat::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 3px;
}
.istat.amber::before { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
.istat.blue::before  { background: linear-gradient(90deg, #3b82f6, #818cf8); }
.istat.green::before { background: linear-gradient(90deg, #10b981, #34d399); }
.istat.red::before   { background: linear-gradient(90deg, #ef4444, #f87171); }

.istat-value { font-size: 1.75rem; font-weight: 800; line-height: 1; color: var(--text-primary); }
.istat-label { font-size: 0.75rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.06em; }
.istat.amber .istat-value { color: #d97706; }
.istat.blue  .istat-value { color: #2563eb; }
.istat.green .istat-value { color: #059669; }
.istat.red   .istat-value { color: #dc2626; }

/* Toolbar */
.inbox-toolbar {
  display: flex;
  align-items: center;
  gap: 12px;
  flex-wrap: wrap;
}
.search-box {
  flex: 1;
  min-width: 200px;
  position: relative;
}
.search-box svg {
  position: absolute;
  left: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--text-muted);
  pointer-events: none;
}
.search-box input {
  width: 100%;
  padding: 9px 12px 9px 38px;
  border: 1px solid var(--card-border);
  border-radius: 10px;
  background: var(--card-bg);
  color: var(--text-primary);
  font-size: 0.87rem;
}
.search-box input:focus { outline: none; border-color: #3b82f6; }

.filter-pills { display: flex; gap: 6px; flex-wrap: wrap; }
.pill {
  display: inline-flex; align-items: center; gap: 5px;
  padding: 6px 14px;
  border-radius: 20px;
  font-size: 0.75rem;
  font-weight: 700;
  border: 1px solid var(--card-border);
  color: var(--text-muted);
  background: var(--card-bg);
  cursor: pointer;
  text-decoration: none;
  transition: all 0.15s;
}
.pill:hover { border-color: #3b82f6; color: #3b82f6; }
.pill.active { background: #3b82f6; border-color: #3b82f6; color: #fff; }
.pill.amber.active  { background: #f59e0b; border-color: #f59e0b; color: #fff; }
.pill.green.active  { background: #10b981; border-color: #10b981; color: #fff; }
.pill.slate.active  { background: #64748b; border-color: #64748b; color: #fff; }

/* List */
.inbox-list { display: flex; flex-direction: column; gap: 10px; }
.inbox-empty {
  text-align: center;
  padding: 64px 32px;
  background: var(--card-bg);
  border: 1px solid var(--card-border);
  border-radius: var(--border-radius);
  color: var(--text-muted);
}
.inbox-empty-icon { width: 64px; height: 64px; margin: 0 auto 16px; opacity: 0.25; }
.inbox-empty h3 { font-size: 1rem; font-weight: 700; color: var(--text-primary); margin-bottom: 6px; }

.req-item {
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 16px 20px;
  background: var(--card-bg);
  border: 1px solid var(--card-border);
  border-radius: var(--border-radius);
  text-decoration: none;
  transition: all 0.15s;
  position: relative;
  overflow: hidden;
}
.req-item::before {
  content: '';
  position: absolute;
  left: 0; top: 0; bottom: 0;
  width: 4px;
  border-radius: 0;
}
.req-item.en_attente::before { background: #f59e0b; }
.req-item.en_cours::before   { background: #3b82f6; }
.req-item.repondue::before   { background: #10b981; }
.req-item.fermee::before     { background: #64748b; }
.req-item.urgente-item::after {
  content: '';
  position: absolute;
  right: 0; top: 0; bottom: 0;
  width: 3px;
  background: #ef4444;
  border-radius: 0;
}

.req-item:hover {
  border-color: #3b82f6;
  transform: translateX(3px);
  box-shadow: 0 2px 16px rgba(59,130,246,0.08);
}

.req-unread-dot {
  width: 8px; height: 8px;
  border-radius: 50%;
  background: #f59e0b;
  flex-shrink: 0;
}
.req-company-avatar {
  width: 42px; height: 42px;
  border-radius: 10px;
  background: linear-gradient(135deg, #3b82f6, #818cf8);
  display: flex; align-items: center; justify-content: center;
  font-size: 1rem;
  font-weight: 800;
  color: #fff;
  flex-shrink: 0;
}
.req-info { flex: 1; min-width: 0; }
.req-top { display: flex; align-items: center; gap: 8px; margin-bottom: 3px; flex-wrap: wrap; }
.req-sujet {
  font-size: 0.9rem;
  font-weight: 700;
  color: var(--text-primary);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 300px;
}
.req-company-name { font-size: 0.78rem; color: var(--text-muted); font-weight: 600; }
.req-bottom { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.req-preview { font-size: 0.8rem; color: var(--text-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 380px; }

.badge-statut { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 20px; font-size: 0.68rem; font-weight: 700; }
.badge-statut.en_attente { background: rgba(245,158,11,0.1); color: #d97706; }
.badge-statut.en_cours   { background: rgba(59,130,246,0.1); color: #2563eb; }
.badge-statut.repondue   { background: rgba(16,185,129,0.1); color: #059669; }
.badge-statut.fermee     { background: rgba(100,116,139,0.1); color: #64748b; }
.badge-urgente { display: inline-flex; padding: 2px 8px; border-radius: 12px; font-size: 0.66rem; font-weight: 700; background: rgba(239,68,68,0.1); color: #dc2626; }
.badge-cat { display: inline-flex; padding: 2px 8px; border-radius: 12px; font-size: 0.66rem; font-weight: 600; background: rgba(99,102,241,0.08); color: #6366f1; }

.req-time { font-size: 0.75rem; color: var(--text-muted); white-space: nowrap; margin-left: auto; }
</style>
@endsection

@section('content')
<div class="inbox-wrap">

    {{-- Stats --}}
    <div class="inbox-stats">
        <div class="istat amber">
            <span class="istat-value">{{ $stats['non_lues'] }}</span>
            <span class="istat-label">Non lues</span>
        </div>
        <div class="istat blue">
            <span class="istat-value">{{ $stats['en_attente'] }}</span>
            <span class="istat-label">En attente</span>
        </div>
        <div class="istat red">
            <span class="istat-value">{{ $stats['urgentes'] }}</span>
            <span class="istat-label">Urgentes</span>
        </div>
        <div class="istat green">
            <span class="istat-value">{{ $stats['repondues'] }}</span>
            <span class="istat-label">Répondues</span>
        </div>
    </div>

    {{-- Toolbar : recherche + filtres --}}
    <div class="inbox-toolbar">
        <div class="search-box">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" id="searchInput" placeholder="Rechercher par sujet, entreprise…" value="{{ request('q') }}">
        </div>
        <div class="filter-pills">
            <a href="{{ route('admin.admin-requetes.index') }}" class="pill {{ !request('statut') ? 'active' : '' }}">Toutes</a>
            <a href="{{ route('admin.admin-requetes.index', ['statut' => 'en_attente']) }}" class="pill amber {{ request('statut') === 'en_attente' ? 'active' : '' }}">En attente</a>
            <a href="{{ route('admin.admin-requetes.index', ['statut' => 'en_cours']) }}" class="pill {{ request('statut') === 'en_cours' ? 'active' : '' }}">En cours</a>
            <a href="{{ route('admin.admin-requetes.index', ['statut' => 'repondue']) }}" class="pill green {{ request('statut') === 'repondue' ? 'active' : '' }}">Répondues</a>
            <a href="{{ route('admin.admin-requetes.index', ['statut' => 'fermee']) }}" class="pill slate {{ request('statut') === 'fermee' ? 'active' : '' }}">Fermées</a>
        </div>
    </div>

    {{-- Liste --}}
    <div class="inbox-list" id="inboxList">
        @forelse($requetes as $req)
        <a href="{{ route('admin.admin-requetes.show', $req) }}"
           class="req-item {{ $req->statut }} {{ $req->isUrgente() ? 'urgente-item' : '' }}"
           data-sujet="{{ strtolower($req->sujet) }}"
           data-company="{{ strtolower($req->entreprise->nom ?? '') }}">

            {{-- Indicateur non-lu --}}
            @if(!$req->lu_par_admin)
            <span class="req-unread-dot" title="Non lue"></span>
            @endif

            {{-- Avatar entreprise --}}
            <div class="req-company-avatar">{{ strtoupper(substr($req->entreprise->nom ?? 'E', 0, 1)) }}</div>

            {{-- Infos --}}
            <div class="req-info">
                <div class="req-top">
                    <span class="req-sujet">{{ $req->sujet }}</span>
                    <span class="badge-statut {{ $req->statut }}">{{ $req->statutLibelle }}</span>
                    @if($req->isUrgente())
                        <span class="badge-urgente">🔴 Urgente</span>
                    @endif
                    <span class="badge-cat">{{ $req->categorieLibelle }}</span>
                </div>
                <div class="req-bottom">
                    <span class="req-company-name">{{ $req->entreprise->nom ?? '—' }}</span>
                    <span>·</span>
                    <span class="req-preview">{{ \Str::limit($req->message, 90) }}</span>
                </div>
            </div>

            <span class="req-time">{{ $req->created_at->diffForHumans() }}</span>
        </a>
        @empty
        <div class="inbox-empty">
            <div class="inbox-empty-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <h3>Aucune requête trouvée</h3>
            <p>Aucune requête ne correspond aux critères sélectionnés.</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($requetes->hasPages())
    <div>{{ $requetes->appends(request()->query())->links() }}</div>
    @endif

</div>

<script>
const searchInput = document.getElementById('searchInput');
const items = document.querySelectorAll('#inboxList .req-item');

let debounceTimer;
searchInput.addEventListener('input', function () {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        const q = this.value.toLowerCase().trim();
        items.forEach(item => {
            const match = item.dataset.sujet.includes(q) || item.dataset.company.includes(q);
            item.style.display = match ? '' : 'none';
        });
    }, 200);
});
</script>
@endsection
