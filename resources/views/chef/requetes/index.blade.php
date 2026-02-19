@extends('layouts.app')

@section('title', 'Mes Requêtes — Portail RH+')
@section('page-title', 'Mes Requêtes')
@section('page-subtitle', 'Suivi de vos demandes auprès du support')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
</svg>
@endsection

@section('styles')
<style>
.rq-page { padding: 8px 0 40px; display: flex; flex-direction: column; gap: 20px; }

/* Stats */
.rq-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; }
.rq-stat {
  background: var(--card-bg);
  border: 1px solid var(--card-border);
  border-radius: var(--border-radius);
  overflow: hidden;
  display: flex; flex-direction: column;
}
.rq-stat-bar { height: 3px; }
.rq-stat-inner { padding: 14px 16px; display: flex; align-items: center; gap: 12px; }
.rq-stat-icon { width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.rq-stat-icon.blue   { background: rgba(59,130,246,0.1); color: #3b82f6; }
.rq-stat-icon.amber  { background: rgba(245,158,11,0.1);  color: #d97706; }
.rq-stat-icon.green  { background: rgba(16,185,129,0.1);  color: #059669; }
.rq-stat-icon.red    { background: rgba(239,68,68,0.1);   color: #dc2626; }
.rq-stat-label { font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: var(--text-muted); }
.rq-stat-value { font-size: 1.5rem; font-weight: 800; color: var(--text-primary); letter-spacing: -0.03em; line-height: 1; }

/* Toolbar */
.rq-toolbar {
  display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap;
}
.rq-filters { display: flex; gap: 8px; flex-wrap: wrap; }
.filter-btn {
  padding: 6px 14px;
  border-radius: 20px;
  font-size: 0.78rem;
  font-weight: 600;
  border: 1.5px solid var(--card-border);
  background: var(--card-bg);
  color: var(--text-muted);
  text-decoration: none;
  transition: all 0.15s;
}
.filter-btn:hover, .filter-btn.active { border-color: #3b82f6; color: #3b82f6; background: rgba(59,130,246,0.06); }
.btn-new {
  display: inline-flex; align-items: center; gap: 7px;
  padding: 9px 18px;
  background: #3b82f6;
  color: white;
  border-radius: 8px;
  font-size: 0.85rem;
  font-weight: 700;
  text-decoration: none;
  transition: background 0.15s, transform 0.15s;
}
.btn-new:hover { background: #2563eb; transform: translateY(-1px); }

/* List */
.rq-list { display: flex; flex-direction: column; gap: 10px; }
.rq-item {
  background: var(--card-bg);
  border: 1px solid var(--card-border);
  border-radius: var(--border-radius);
  overflow: hidden;
  display: flex;
  transition: box-shadow 0.15s;
}
.rq-item:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.06); }
.rq-item-accent { width: 3px; flex-shrink: 0; }
.rq-item-accent.amber  { background: #f59e0b; }
.rq-item-accent.blue   { background: #3b82f6; }
.rq-item-accent.green  { background: #10b981; }
.rq-item-accent.slate  { background: #94a3b8; }
.rq-item-body { flex: 1; padding: 14px 18px; display: flex; align-items: center; gap: 16px; }
.rq-item-info { flex: 1; min-width: 0; }
.rq-item-sujet {
  font-size: 0.9rem;
  font-weight: 700;
  color: var(--text-primary);
  margin-bottom: 3px;
  display: flex; align-items: center; gap: 8px;
}
.rq-item-meta { font-size: 0.75rem; color: var(--text-muted); display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }

.badge-statut {
  display: inline-flex; align-items: center; gap: 4px;
  padding: 3px 10px; border-radius: 20px;
  font-size: 0.72rem; font-weight: 700; flex-shrink: 0;
}
.badge-statut.en_attente { background: rgba(245,158,11,0.1); color: #d97706; }
.badge-statut.en_cours   { background: rgba(59,130,246,0.1); color: #2563eb; }
.badge-statut.repondue   { background: rgba(16,185,129,0.1); color: #059669; }
.badge-statut.fermee     { background: rgba(100,116,139,0.1); color: #64748b; }

.badge-urgente {
  display: inline-flex; align-items: center;
  padding: 2px 8px; border-radius: 12px;
  font-size: 0.68rem; font-weight: 700;
  background: rgba(239,68,68,0.1); color: #dc2626;
}
.badge-new-reply {
  width: 8px; height: 8px; border-radius: 50%;
  background: #10b981;
  box-shadow: 0 0 0 3px rgba(16,185,129,0.2);
  flex-shrink: 0;
}

.rq-item-actions { display: flex; align-items: center; padding-right: 16px; }
.btn-voir {
  display: inline-flex; align-items: center; gap: 5px;
  padding: 7px 14px;
  border: 1px solid var(--card-border);
  border-radius: 7px;
  font-size: 0.78rem;
  font-weight: 600;
  color: var(--text-primary);
  text-decoration: none;
  transition: all 0.15s;
}
.btn-voir:hover { border-color: #3b82f6; color: #3b82f6; background: rgba(59,130,246,0.05); }

/* Empty state */
.rq-empty {
  background: var(--card-bg);
  border: 1px solid var(--card-border);
  border-radius: var(--border-radius);
  padding: 60px 32px;
  text-align: center;
  color: var(--text-muted);
}
.rq-empty-icon { margin: 0 auto 16px; opacity: 0.3; }
.rq-empty-title { font-size: 1rem; font-weight: 700; color: var(--text-primary); margin-bottom: 8px; }

.flash-bar { display: flex; align-items: center; gap: 10px; padding: 13px 18px; border-radius: var(--border-radius); font-size: 0.88rem; font-weight: 500; }
.flash-bar.success { background: rgba(16,185,129,0.08); border: 1px solid rgba(16,185,129,0.2); color: #059669; }
.flash-bar.error   { background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2); color: #dc2626; }

@media (max-width: 640px) { .rq-stats { grid-template-columns: repeat(2, 1fr); } .rq-item-body { flex-direction: column; align-items: flex-start; } }
</style>
@endsection

@section('content')
<div class="rq-page">

    @if(session('success'))
    <div class="flash-bar success">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="flash-bar error">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line></svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- Stats --}}
    <div class="rq-stats">
        <div class="rq-stat">
            <div class="rq-stat-bar" style="background: linear-gradient(90deg,#3b82f6,#818cf8);"></div>
            <div class="rq-stat-inner">
                <div class="rq-stat-icon blue">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                </div>
                <div><div class="rq-stat-label">Total</div><div class="rq-stat-value">{{ $stats['total'] }}</div></div>
            </div>
        </div>
        <div class="rq-stat">
            <div class="rq-stat-bar" style="background: linear-gradient(90deg,#f59e0b,#fbbf24);"></div>
            <div class="rq-stat-inner">
                <div class="rq-stat-icon amber">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
                <div><div class="rq-stat-label">En attente</div><div class="rq-stat-value">{{ $stats['en_attente'] }}</div></div>
            </div>
        </div>
        <div class="rq-stat">
            <div class="rq-stat-bar" style="background: linear-gradient(90deg,#10b981,#34d399);"></div>
            <div class="rq-stat-inner">
                <div class="rq-stat-icon green">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                </div>
                <div><div class="rq-stat-label">Répondues</div><div class="rq-stat-value">{{ $stats['repondue'] }}</div></div>
            </div>
        </div>
        <div class="rq-stat">
            <div class="rq-stat-bar" style="background: linear-gradient(90deg,#ef4444,#f87171);"></div>
            <div class="rq-stat-inner">
                <div class="rq-stat-icon red">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path></svg>
                </div>
                <div><div class="rq-stat-label">Nouvelles réponses</div><div class="rq-stat-value">{{ $stats['non_lues'] }}</div></div>
            </div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="rq-toolbar">
        <div class="rq-filters">
            <a href="{{ route('admin.requetes.index') }}" class="filter-btn {{ !$statut ? 'active' : '' }}">Toutes</a>
            <a href="{{ route('admin.requetes.index', ['statut' => 'en_attente']) }}" class="filter-btn {{ $statut === 'en_attente' ? 'active' : '' }}">En attente</a>
            <a href="{{ route('admin.requetes.index', ['statut' => 'en_cours']) }}" class="filter-btn {{ $statut === 'en_cours' ? 'active' : '' }}">En cours</a>
            <a href="{{ route('admin.requetes.index', ['statut' => 'repondue']) }}" class="filter-btn {{ $statut === 'repondue' ? 'active' : '' }}">Répondues</a>
            <a href="{{ route('admin.requetes.index', ['statut' => 'fermee']) }}" class="filter-btn {{ $statut === 'fermee' ? 'active' : '' }}">Fermées</a>
        </div>
        <a href="{{ route('admin.requetes.create') }}" class="btn-new">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Nouvelle requête
        </a>
    </div>

    {{-- Liste --}}
    <div class="rq-list">
        @forelse($requetes as $req)
        @php
            $accentMap = ['en_attente'=>'amber','en_cours'=>'blue','repondue'=>'green','fermee'=>'slate'];
            $accent = $accentMap[$req->statut] ?? 'blue';
        @endphp
        <div class="rq-item">
            <div class="rq-item-accent {{ $accent }}"></div>
            <div class="rq-item-body">
                <div class="rq-item-info">
                    <div class="rq-item-sujet">
                        @if($req->statut === 'repondue' && !$req->lu_par_chef)
                            <span class="badge-new-reply" title="Nouvelle réponse"></span>
                        @endif
                        {{ $req->sujet }}
                        @if($req->isUrgente())
                            <span class="badge-urgente">🔴 Urgent</span>
                        @endif
                    </div>
                    <div class="rq-item-meta">
                        <span>{{ $req->categorie_libelle }}</span>
                        <span>·</span>
                        <span>{{ $req->created_at->diffForHumans() }}</span>
                        @if($req->repondu_le)
                            <span>· Répondu {{ $req->repondu_le->diffForHumans() }}</span>
                        @endif
                    </div>
                </div>
                <span class="badge-statut {{ $req->statut }}">{{ $req->statut_libelle }}</span>
            </div>
            <div class="rq-item-actions">
                <a href="{{ route('admin.requetes.show', $req) }}" class="btn-voir">
                    Voir
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </a>
            </div>
        </div>
        @empty
        <div class="rq-empty">
            <svg class="rq-empty-icon" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
            </svg>
            <div class="rq-empty-title">Aucune requête</div>
            <p style="font-size:0.85rem; margin-bottom:20px;">Vous n'avez pas encore envoyé de requête.</p>
            <a href="{{ route('admin.requetes.create') }}" class="btn-new" style="margin: 0 auto;">Envoyer votre première requête</a>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($requetes->hasPages())
    <div style="display:flex; justify-content:center;">
        {{ $requetes->appends(request()->query())->links() }}
    </div>
    @endif

</div>
@endsection
