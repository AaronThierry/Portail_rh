@extends('layouts.app')

@section('title', 'Requête — ' . $requete->sujet)
@section('page-title', 'Détail de la requête')
@section('page-subtitle', $requete->sujet)
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
</svg>
@endsection

@section('styles')
<style>
.req-detail { padding: 8px 0 40px; max-width: 820px; display: flex; flex-direction: column; gap: 18px; }

.req-breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 0.82rem; color: var(--text-muted); }
.req-breadcrumb a { color: #3b82f6; text-decoration: none; }
.req-breadcrumb a:hover { text-decoration: underline; }

.thread-card {
  background: var(--card-bg);
  border: 1px solid var(--card-border);
  border-radius: var(--border-radius);
  overflow: hidden;
}
.thread-header {
  padding: 18px 22px 16px;
  border-bottom: 1px solid var(--card-border);
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 12px;
}
.thread-title { font-size: 0.97rem; font-weight: 700; color: var(--text-primary); margin-bottom: 6px; }
.thread-meta { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; font-size: 0.75rem; color: var(--text-muted); }

.badge-statut { display: inline-flex; align-items: center; gap: 4px; padding: 4px 12px; border-radius: 20px; font-size: 0.72rem; font-weight: 700; }
.badge-statut.en_attente { background: rgba(245,158,11,0.1); color: #d97706; }
.badge-statut.en_cours   { background: rgba(59,130,246,0.1); color: #2563eb; }
.badge-statut.repondue   { background: rgba(16,185,129,0.1); color: #059669; }
.badge-statut.fermee     { background: rgba(100,116,139,0.1); color: #64748b; }
.badge-urgente { display: inline-flex; padding: 3px 9px; border-radius: 12px; font-size: 0.68rem; font-weight: 700; background: rgba(239,68,68,0.1); color: #dc2626; }

/* Thread bubbles */
.thread-body { padding: 22px; display: flex; flex-direction: column; gap: 20px; }

.bubble-wrapper { display: flex; flex-direction: column; }
.bubble-wrapper.from-chef { align-items: flex-end; }
.bubble-wrapper.from-admin { align-items: flex-start; }

.bubble-meta { font-size: 0.72rem; color: var(--text-muted); margin-bottom: 5px; }

.bubble {
  max-width: 82%;
  padding: 14px 18px;
  border-radius: 12px;
  font-size: 0.88rem;
  line-height: 1.65;
  white-space: pre-wrap;
}
.bubble.chef {
  background: rgba(59,130,246,0.08);
  border: 1px solid rgba(59,130,246,0.15);
  color: var(--text-primary);
  border-bottom-right-radius: 3px;
}
.bubble.admin {
  background: rgba(16,185,129,0.08);
  border: 1px solid rgba(16,185,129,0.15);
  color: var(--text-primary);
  border-bottom-left-radius: 3px;
}
.bubble-label {
  font-size: 0.7rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  margin-bottom: 6px;
}
.bubble.chef .bubble-label { color: #3b82f6; }
.bubble.admin .bubble-label { color: #059669; }

.awaiting-reply {
  text-align: center;
  padding: 24px;
  color: var(--text-muted);
  font-size: 0.84rem;
}
.awaiting-reply .spinner {
  width: 28px; height: 28px;
  border: 3px solid var(--card-border);
  border-top-color: #f59e0b;
  border-radius: 50%;
  animation: spin 1.2s linear infinite;
  margin: 0 auto 10px;
}
@keyframes spin { to { transform: rotate(360deg); } }

.back-btn {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 9px 16px;
  border: 1px solid var(--card-border);
  border-radius: 8px;
  font-size: 0.83rem;
  font-weight: 600;
  color: var(--text-primary);
  text-decoration: none;
  transition: all 0.15s;
  width: fit-content;
}
.back-btn:hover { border-color: #3b82f6; color: #3b82f6; }
</style>
@endsection

@section('content')
<div class="req-detail">

    <div class="req-breadcrumb">
        <a href="{{ route('admin.requetes.index') }}">Mes Requêtes</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
        <span>{{ \Str::limit($requete->sujet, 40) }}</span>
    </div>

    <div class="thread-card">
        {{-- Header --}}
        <div class="thread-header">
            <div>
                <div class="thread-title">{{ $requete->sujet }}</div>
                <div class="thread-meta">
                    <span>{{ $requete->categorie_libelle }}</span>
                    <span>·</span>
                    <span>Envoyée {{ $requete->created_at->diffForHumans() }}</span>
                    @if($requete->isUrgente())
                        <span class="badge-urgente">🔴 Urgente</span>
                    @endif
                </div>
            </div>
            <span class="badge-statut {{ $requete->statut }}">{{ $requete->statut_libelle }}</span>
        </div>

        {{-- Thread --}}
        <div class="thread-body">
            {{-- Message du chef --}}
            <div class="bubble-wrapper from-chef">
                <div class="bubble-meta">Vous · {{ $requete->created_at->format('d/m/Y à H\hi') }}</div>
                <div class="bubble chef">
                    <div class="bubble-label">Votre message</div>
                    {{ $requete->message }}
                </div>
            </div>

            {{-- Réponse admin ou en attente --}}
            @if($requete->reponse)
            <div class="bubble-wrapper from-admin">
                <div class="bubble-meta">Support Portail RH+ · {{ $requete->repondu_le?->format('d/m/Y à H\hi') }}</div>
                <div class="bubble admin">
                    <div class="bubble-label">Réponse du support</div>
                    {{ $requete->reponse }}
                </div>
            </div>
            @elseif(!$requete->isFermee())
            <div class="awaiting-reply">
                <div class="spinner"></div>
                En attente de réponse du support…
            </div>
            @endif
        </div>
    </div>

    <a href="{{ route('admin.requetes.index') }}" class="back-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        Retour à mes requêtes
    </a>

</div>
@endsection
