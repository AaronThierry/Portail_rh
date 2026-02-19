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
.rq-toolbar { display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
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
  border: none;
  cursor: pointer;
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
  font-size: 0.9rem; font-weight: 700; color: var(--text-primary);
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
  font-size: 0.78rem; font-weight: 600;
  color: var(--text-primary);
  text-decoration: none;
  transition: all 0.15s;
}
.btn-voir:hover { border-color: #3b82f6; color: #3b82f6; background: rgba(59,130,246,0.05); }
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

/* ── Modal ── */
.modal-overlay {
  position: fixed; inset: 0;
  background: rgba(0,0,0,0.45);
  backdrop-filter: blur(4px);
  -webkit-backdrop-filter: blur(4px);
  z-index: 900;
  display: flex; align-items: center; justify-content: center;
  padding: 16px;
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.2s ease;
}
.modal-overlay.open {
  opacity: 1;
  pointer-events: all;
}
.modal-box {
  background: var(--card-bg);
  border: 1px solid var(--card-border);
  border-radius: 16px;
  width: 100%;
  max-width: 680px;
  max-height: 90vh;
  overflow-y: auto;
  overflow-x: hidden;
  transform: translateY(20px) scale(0.98);
  transition: transform 0.22s cubic-bezier(0.34, 1.2, 0.64, 1);
  scrollbar-width: thin;
}
.modal-overlay.open .modal-box {
  transform: translateY(0) scale(1);
}
.modal-top-bar {
  height: 4px;
  background: linear-gradient(90deg, #3b82f6, #818cf8, #f59e0b);
  border-radius: 16px 16px 0 0;
}
.modal-header {
  padding: 20px 24px 0;
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 12px;
}
.modal-title {
  font-size: 1.05rem;
  font-weight: 800;
  color: var(--text-primary);
  letter-spacing: -0.02em;
}
.modal-subtitle {
  font-size: 0.8rem;
  color: var(--text-muted);
  margin-top: 2px;
}
.modal-close {
  width: 32px; height: 32px;
  border-radius: 8px;
  border: 1px solid var(--card-border);
  background: transparent;
  cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  color: var(--text-muted);
  flex-shrink: 0;
  transition: all 0.15s;
}
.modal-close:hover { background: rgba(239,68,68,0.08); border-color: #ef4444; color: #ef4444; }
.modal-body { padding: 20px 24px 28px; }

/* Form inside modal */
.mform-group { margin-bottom: 20px; }
.mform-label {
  display: block;
  font-size: 0.75rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.06em;
  color: var(--text-muted);
  margin-bottom: 8px;
}
.mform-label .req-star { color: #ef4444; margin-left: 2px; }
.mform-input, .mform-textarea {
  width: 100%;
  padding: 10px 14px;
  border: 1px solid var(--card-border);
  border-radius: 8px;
  background: var(--bg-tertiary);
  color: var(--text-primary);
  font-size: 0.9rem;
  transition: border-color 0.15s, box-shadow 0.15s;
  font-family: inherit;
}
.mform-input:focus, .mform-textarea:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
  background: var(--card-bg);
}
.mform-textarea { resize: vertical; min-height: 130px; line-height: 1.6; }
.mform-error { color: #dc2626; font-size: 0.78rem; margin-top: 5px; }

/* Categorie pills in modal */
.mcat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; }
.mcat-pill input { display: none; }
.mcat-pill label {
  display: flex; flex-direction: column; align-items: center; gap: 5px;
  padding: 10px 6px;
  border: 1.5px solid var(--card-border);
  border-radius: 10px;
  cursor: pointer;
  transition: all 0.15s;
  text-align: center;
  font-size: 0.75rem; font-weight: 600;
  color: var(--text-muted);
}
.mcat-pill label:hover { border-color: #3b82f6; color: #3b82f6; background: rgba(59,130,246,0.05); }
.mcat-pill input:checked + label {
  border-color: #3b82f6;
  background: rgba(59,130,246,0.08);
  color: #3b82f6;
}
.mcat-icon { width: 24px; height: 24px; }

/* Priorité toggle in modal */
.mprio-toggle { display: flex; gap: 10px; }
.mprio-toggle input { display: none; }
.mprio-toggle label {
  flex: 1; padding: 9px 14px;
  border: 1.5px solid var(--card-border);
  border-radius: 8px;
  cursor: pointer;
  text-align: center;
  font-size: 0.83rem; font-weight: 700;
  transition: all 0.15s;
  color: var(--text-muted);
}
.mprio-normale input:checked + label { border-color: #10b981; background: rgba(16,185,129,0.08); color: #059669; }
.mprio-urgente input:checked + label { border-color: #ef4444;  background: rgba(239,68,68,0.08);  color: #dc2626; }
.mprio-toggle label:hover { border-color: var(--text-muted); }

.mchar-count { font-size: 0.72rem; color: var(--text-muted); text-align: right; margin-top: 4px; }

.minfo-box {
  background: rgba(59,130,246,0.05);
  border: 1px solid rgba(59,130,246,0.15);
  border-radius: 8px;
  padding: 10px 14px;
  display: flex; align-items: flex-start; gap: 10px;
  font-size: 0.79rem; color: var(--text-muted);
  margin-bottom: 20px;
}

.modal-footer {
  display: flex; align-items: center; justify-content: flex-end; gap: 10px;
  padding: 16px 24px 20px;
  border-top: 1px solid var(--card-border);
}
.mbtn-cancel {
  padding: 9px 18px;
  border: 1px solid var(--card-border);
  border-radius: 8px;
  background: transparent;
  color: var(--text-muted);
  font-size: 0.85rem; font-weight: 600;
  cursor: pointer;
  transition: all 0.15s;
}
.mbtn-cancel:hover { border-color: var(--text-muted); color: var(--text-primary); }
.mbtn-submit {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 10px 22px;
  background: #3b82f6;
  color: white; border: none;
  border-radius: 8px;
  font-size: 0.87rem; font-weight: 700;
  cursor: pointer;
  transition: background 0.15s, transform 0.15s;
}
.mbtn-submit:hover { background: #2563eb; transform: translateY(-1px); }
.mbtn-submit:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

@media (max-width: 640px) {
  .rq-stats { grid-template-columns: repeat(2, 1fr); }
  .rq-item-body { flex-direction: column; align-items: flex-start; }
  .mcat-grid { grid-template-columns: repeat(2, 1fr); }
}
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
        <button type="button" class="btn-new" id="openModalBtn">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Nouvelle requête
        </button>
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
            <button type="button" class="btn-new" onclick="openModal()" style="margin: 0 auto;">Envoyer votre première requête</button>
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

{{-- ════════════════ MODAL NOUVELLE REQUÊTE ════════════════ --}}
<div class="modal-overlay" id="requeteModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="modal-box" id="modalBox">
        <div class="modal-top-bar"></div>

        <div class="modal-header">
            <div>
                <div class="modal-title" id="modalTitle">Nouvelle requête</div>
                <div class="modal-subtitle">Votre message sera transmis au support Portail RH+</div>
            </div>
            <button type="button" class="modal-close" id="closeModalBtn" aria-label="Fermer">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <form action="{{ route('admin.requetes.store') }}" method="POST" id="requeteForm">
            @csrf

            <div class="modal-body">

                <div class="minfo-box">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Vous recevrez une notification dès qu'une réponse sera disponible.
                </div>

                @if($errors->any())
                <div style="padding: 12px 16px; border-radius: 8px; background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2); color: #dc2626; font-size: 0.84rem; margin-bottom: 18px;">
                    <strong>Veuillez corriger les erreurs :</strong>
                    <ul style="margin: 6px 0 0 16px; padding: 0;">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Sujet --}}
                <div class="mform-group">
                    <label class="mform-label">Sujet <span class="req-star">*</span></label>
                    <input type="text" name="sujet" class="mform-input" value="{{ old('sujet') }}"
                           placeholder="Résumez votre demande en quelques mots…" maxlength="150" required>
                </div>

                {{-- Catégorie --}}
                <div class="mform-group">
                    <label class="mform-label">Catégorie <span class="req-star">*</span></label>
                    <div class="mcat-grid">
                        <div class="mcat-pill">
                            <input type="radio" name="categorie" id="mcat_question" value="question" {{ old('categorie','question')==='question' ? 'checked' : '' }}>
                            <label for="mcat_question">
                                <svg class="mcat-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                Question
                            </label>
                        </div>
                        <div class="mcat-pill">
                            <input type="radio" name="categorie" id="mcat_facturation" value="facturation" {{ old('categorie')==='facturation' ? 'checked' : '' }}>
                            <label for="mcat_facturation">
                                <svg class="mcat-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                Facturation
                            </label>
                        </div>
                        <div class="mcat-pill">
                            <input type="radio" name="categorie" id="mcat_support" value="support" {{ old('categorie')==='support' ? 'checked' : '' }}>
                            <label for="mcat_support">
                                <svg class="mcat-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                                Support technique
                            </label>
                        </div>
                        <div class="mcat-pill">
                            <input type="radio" name="categorie" id="mcat_autre" value="autre" {{ old('categorie')==='autre' ? 'checked' : '' }}>
                            <label for="mcat_autre">
                                <svg class="mcat-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                                Autre
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Priorité --}}
                <div class="mform-group">
                    <label class="mform-label">Priorité <span class="req-star">*</span></label>
                    <div class="mprio-toggle">
                        <div class="mprio-normale">
                            <input type="radio" name="priorite" id="mprio_normale" value="normale" {{ old('priorite','normale')==='normale' ? 'checked' : '' }}>
                            <label for="mprio_normale">Normale</label>
                        </div>
                        <div class="mprio-urgente">
                            <input type="radio" name="priorite" id="mprio_urgente" value="urgente" {{ old('priorite')==='urgente' ? 'checked' : '' }}>
                            <label for="mprio_urgente">🔴 Urgente</label>
                        </div>
                    </div>
                </div>

                {{-- Message --}}
                <div class="mform-group" style="margin-bottom: 0;">
                    <label class="mform-label">Message <span class="req-star">*</span></label>
                    <textarea name="message" id="mMessageField" class="mform-textarea" maxlength="3000"
                              placeholder="Décrivez votre demande en détail…" required>{{ old('message') }}</textarea>
                    <div class="mchar-count"><span id="mCharCount">0</span> / 3000</div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="mbtn-cancel" id="closeModalBtn2">Annuler</button>
                <button type="submit" class="mbtn-submit" id="mSubmitBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    Envoyer la requête
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
// ── Modal logic ──
const modal    = document.getElementById('requeteModal');
const openBtn  = document.getElementById('openModalBtn');
const closeBtn = document.getElementById('closeModalBtn');
const closeBtn2= document.getElementById('closeModalBtn2');

function openModal() {
    modal.classList.add('open');
    document.body.style.overflow = 'hidden';
    // Focus first input
    setTimeout(() => {
        const first = modal.querySelector('input[name="sujet"]');
        if (first) first.focus();
    }, 250);
}

function closeModal() {
    modal.classList.remove('open');
    document.body.style.overflow = '';
}

if (openBtn)  openBtn.addEventListener('click', openModal);
if (closeBtn) closeBtn.addEventListener('click', closeModal);
if (closeBtn2) closeBtn2.addEventListener('click', closeModal);

// Click outside to close
modal.addEventListener('click', function(e) {
    if (e.target === modal) closeModal();
});

// Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && modal.classList.contains('open')) closeModal();
});

// ── Character counter ──
const textarea = document.getElementById('mMessageField');
const charCount = document.getElementById('mCharCount');
function updateCount() {
    const len = textarea.value.length;
    charCount.textContent = len;
    charCount.style.color = len > 2800 ? '#ef4444' : '';
}
textarea.addEventListener('input', updateCount);
updateCount();

// ── Submit feedback ──
document.getElementById('requeteForm').addEventListener('submit', function() {
    const btn = document.getElementById('mSubmitBtn');
    btn.disabled = true;
    btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="animation:spin 1s linear infinite"><line x1="12" y1="2" x2="12" y2="6"/><line x1="12" y1="18" x2="12" y2="22"/><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"/><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"/><line x1="2" y1="12" x2="6" y2="12"/><line x1="18" y1="12" x2="22" y2="12"/><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"/><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"/></svg> Envoi en cours…';
});

// ── Auto-open if errors ──
@if($errors->any())
openModal();
@endif
</script>
<style>
@keyframes spin { to { transform: rotate(360deg); } }
</style>
@endsection
