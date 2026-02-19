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
.req-detail { padding: 8px 0 48px; max-width: 860px; display: flex; flex-direction: column; gap: 18px; }

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
  flex-wrap: wrap;
}
.thread-title { font-size: 1rem; font-weight: 700; color: var(--text-primary); margin-bottom: 6px; }
.thread-meta { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; font-size: 0.75rem; color: var(--text-muted); }
.thread-actions { display: flex; gap: 8px; align-items: center; flex-shrink: 0; }

.badge-statut { display: inline-flex; align-items: center; gap: 4px; padding: 4px 12px; border-radius: 20px; font-size: 0.72rem; font-weight: 700; }
.badge-statut.en_attente { background: rgba(245,158,11,0.1); color: #d97706; }
.badge-statut.en_cours   { background: rgba(59,130,246,0.1); color: #2563eb; }
.badge-statut.repondue   { background: rgba(16,185,129,0.1); color: #059669; }
.badge-statut.fermee     { background: rgba(100,116,139,0.1); color: #64748b; }
.badge-urgente { display: inline-flex; padding: 3px 9px; border-radius: 12px; font-size: 0.68rem; font-weight: 700; background: rgba(239,68,68,0.1); color: #dc2626; }
.badge-cat { display: inline-flex; padding: 3px 9px; border-radius: 12px; font-size: 0.68rem; font-weight: 600; background: rgba(99,102,241,0.08); color: #6366f1; }

/* Info client */
.client-banner {
  padding: 14px 22px;
  background: rgba(59,130,246,0.04);
  border-bottom: 1px solid var(--card-border);
  display: flex;
  align-items: center;
  gap: 14px;
  flex-wrap: wrap;
}
.client-avatar {
  width: 40px; height: 40px;
  border-radius: 10px;
  background: linear-gradient(135deg, #3b82f6, #818cf8);
  display: flex; align-items: center; justify-content: center;
  font-size: 1rem; font-weight: 800; color: #fff; flex-shrink: 0;
}
.client-info { display: flex; flex-direction: column; gap: 2px; }
.client-name { font-size: 0.88rem; font-weight: 700; color: var(--text-primary); }
.client-sub  { font-size: 0.75rem; color: var(--text-muted); }

/* Thread */
.thread-body { padding: 22px; display: flex; flex-direction: column; gap: 20px; }

.bubble-wrapper { display: flex; flex-direction: column; }
.bubble-wrapper.from-chef  { align-items: flex-end; }
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

/* Reply form */
.reply-card {
  background: var(--card-bg);
  border: 1px solid var(--card-border);
  border-radius: var(--border-radius);
  overflow: hidden;
}
.reply-card-header {
  padding: 16px 22px 14px;
  border-bottom: 1px solid var(--card-border);
  font-size: 0.92rem;
  font-weight: 700;
  color: var(--text-primary);
  display: flex;
  align-items: center;
  gap: 8px;
}
.reply-form { padding: 22px; display: flex; flex-direction: column; gap: 16px; }
.reply-textarea {
  width: 100%;
  min-height: 120px;
  padding: 12px 16px;
  border: 1px solid var(--card-border);
  border-radius: 10px;
  background: var(--bg-tertiary);
  color: var(--text-primary);
  font-size: 0.9rem;
  line-height: 1.6;
  resize: vertical;
  font-family: inherit;
}
.reply-textarea:focus { outline: none; border-color: #10b981; box-shadow: 0 0 0 3px rgba(16,185,129,0.1); }
.reply-actions { display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }

/* Buttons */
.btn-reply {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 10px 22px;
  border-radius: 10px;
  font-size: 0.87rem; font-weight: 700;
  background: linear-gradient(135deg, #10b981, #059669);
  color: #fff;
  border: none;
  cursor: pointer;
  transition: all 0.15s;
}
.btn-reply:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(16,185,129,0.35); }

.btn-close {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 10px 18px;
  border-radius: 10px;
  font-size: 0.85rem; font-weight: 700;
  background: transparent;
  color: #64748b;
  border: 1px solid var(--card-border);
  cursor: pointer;
  text-decoration: none;
  transition: all 0.15s;
}
.btn-close:hover { border-color: #ef4444; color: #ef4444; }

.btn-back {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 9px 16px;
  border: 1px solid var(--card-border);
  border-radius: 8px;
  font-size: 0.83rem; font-weight: 600;
  color: var(--text-primary);
  text-decoration: none;
  transition: all 0.15s;
  width: fit-content;
}
.btn-back:hover { border-color: #3b82f6; color: #3b82f6; }

.closed-notice {
  padding: 18px 22px;
  background: rgba(100,116,139,0.06);
  border-top: 1px solid var(--card-border);
  text-align: center;
  font-size: 0.83rem;
  color: var(--text-muted);
}
</style>
@endsection

@section('content')
<div class="req-detail">

    {{-- Breadcrumb --}}
    <div class="req-breadcrumb">
        <a href="{{ route('admin.admin-requetes.index') }}">Requêtes Clients</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
        <span>{{ \Str::limit($requete->sujet, 45) }}</span>
    </div>

    {{-- Thread card --}}
    <div class="thread-card">
        {{-- Header --}}
        <div class="thread-header">
            <div>
                <div class="thread-title">{{ $requete->sujet }}</div>
                <div class="thread-meta">
                    <span class="badge-cat">{{ $requete->categorieLibelle }}</span>
                    <span>·</span>
                    <span>Envoyée {{ $requete->created_at->diffForHumans() }}</span>
                    @if($requete->isUrgente())
                        <span class="badge-urgente">🔴 Urgente</span>
                    @endif
                </div>
            </div>
            <div class="thread-actions">
                <span class="badge-statut {{ $requete->statut }}">{{ $requete->statutLibelle }}</span>
            </div>
        </div>

        {{-- Client info --}}
        <div class="client-banner">
            <div class="client-avatar">{{ strtoupper(substr($requete->entreprise->nom ?? 'E', 0, 1)) }}</div>
            <div class="client-info">
                <span class="client-name">{{ $requete->entreprise->nom ?? '—' }}</span>
                <span class="client-sub">{{ $requete->user->name }} · {{ $requete->user->email }}</span>
            </div>
        </div>

        {{-- Thread bubbles --}}
        <div class="thread-body">
            {{-- Message du chef --}}
            <div class="bubble-wrapper from-chef">
                <div class="bubble-meta">{{ $requete->user->name }} · {{ $requete->created_at->format('d/m/Y à H\hi') }}</div>
                <div class="bubble chef">
                    <div class="bubble-label">Message du client</div>
                    {{ $requete->message }}
                </div>
            </div>

            {{-- Réponse admin --}}
            @if($requete->reponse)
            <div class="bubble-wrapper from-admin">
                <div class="bubble-meta">Support Portail RH+ · {{ $requete->repondu_le?->format('d/m/Y à H\hi') }}</div>
                <div class="bubble admin">
                    <div class="bubble-label">Votre réponse</div>
                    {{ $requete->reponse }}
                </div>
            </div>
            @endif
        </div>

        {{-- Fermée notice --}}
        @if($requete->isFermee())
        <div class="closed-notice">
            🔒 Cette requête est fermée.
        </div>
        @endif
    </div>

    {{-- Formulaire de réponse (si pas fermée) --}}
    @if(!$requete->isFermee())
    <div class="reply-card">
        <div class="reply-card-header">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            {{ $requete->reponse ? 'Modifier la réponse' : 'Répondre à la requête' }}
        </div>

        <form id="replyForm" action="{{ route('admin.admin-requetes.reply', $requete) }}" method="POST" class="reply-form">
            @csrf

            @if($errors->any())
            <div style="padding: 12px 16px; border-radius: 8px; background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2); color: #dc2626; font-size: 0.84rem;">
                {{ $errors->first() }}
            </div>
            @endif

            <textarea name="reponse" class="reply-textarea" placeholder="Rédigez votre réponse ici…" rows="6" required>{{ old('reponse', $requete->reponse) }}</textarea>

            <div class="reply-actions">
                {{-- Bouton "Fermer" — soumet le formulaire #closeForm --}}
                <button type="button" class="btn-close" onclick="document.getElementById('closeForm').submit()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Fermer la requête
                </button>

                <div style="display: flex; gap: 10px;">
                    <a href="{{ route('admin.admin-requetes.index') }}" class="btn-back">Retour</a>
                    <button type="submit" class="btn-reply">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        Envoyer la réponse
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Formulaire fermeture (hors du form de réponse pour HTML valide) --}}
    <form id="closeForm" action="{{ route('admin.admin-requetes.close', $requete) }}" method="POST" style="display:none;">
        @csrf
    </form>

    @else
    <a href="{{ route('admin.admin-requetes.index') }}" class="btn-back">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Retour à l'inbox
    </a>
    @endif

</div>

<script>
const closeBtn = document.querySelector('.btn-close[onclick]');
if (closeBtn) {
    closeBtn.addEventListener('click', function(e) {
        e.preventDefault();
        if (confirm('Fermer définitivement cette requête ?')) {
            document.getElementById('closeForm').submit();
        }
    });
    // Remove inline onclick to avoid double execution
    closeBtn.removeAttribute('onclick');
}
</script>
@endsection
