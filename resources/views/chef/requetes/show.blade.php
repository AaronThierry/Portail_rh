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
/* ── Layout ── */
.rq-show { padding: 8px 0 56px; width: 100%; max-width: 100%; overflow: hidden; display: flex; flex-direction: column; gap: 20px; }

/* ── Breadcrumb ── */
.rq-bc { display: flex; align-items: center; gap: 8px; font-size: 0.8rem; color: var(--text-muted); }
.rq-bc a { color: #3b82f6; text-decoration: none; font-weight: 600; transition: color 0.15s; }
.rq-bc a:hover { color: #2563eb; }

/* ── Hero Card ── */
.rq-hero {
  background: var(--card-bg);
  border: 1px solid var(--card-border);
  border-radius: 16px;
  overflow: hidden;
  position: relative;
}
.rq-hero-stripe {
  height: 4px;
  background: linear-gradient(90deg, #3b82f6 0%, #818cf8 50%, #f59e0b 100%);
}
.rq-hero-stripe.urgente {
  background: linear-gradient(90deg, #ef4444, #f59e0b);
}
.rq-hero-body { padding: 24px 28px 22px; display: flex; align-items: flex-start; gap: 16px; }
.rq-hero-icon {
  width: 48px; height: 48px;
  border-radius: 12px;
  background: linear-gradient(135deg, rgba(59,130,246,0.15), rgba(129,140,248,0.15));
  border: 1px solid rgba(59,130,246,0.2);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
  color: #3b82f6;
}
.rq-hero-content { flex: 1; min-width: 0; }
.rq-hero-subject {
  font-size: 1.15rem;
  font-weight: 800;
  color: var(--text-primary);
  letter-spacing: -0.02em;
  line-height: 1.3;
  margin-bottom: 10px;
}
.rq-hero-tags { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.tag {
  display: inline-flex; align-items: center; gap: 5px;
  padding: 4px 11px;
  border-radius: 20px;
  font-size: 0.72rem;
  font-weight: 700;
  letter-spacing: 0.02em;
}
.tag.cat   { background: rgba(99,102,241,0.08); color: #6366f1; border: 1px solid rgba(99,102,241,0.15); }
.tag.date  { background: transparent; color: var(--text-muted); border: 1px solid var(--card-border); font-weight: 500; }
.tag.urg   { background: rgba(239,68,68,0.08); color: #dc2626; border: 1px solid rgba(239,68,68,0.15); }

/* Statut badge — droit du hero */
.rq-statut {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 6px 16px;
  border-radius: 24px;
  font-size: 0.75rem;
  font-weight: 800;
  letter-spacing: 0.04em;
  text-transform: uppercase;
  flex-shrink: 0;
}
.rq-statut::before { content: ''; width: 6px; height: 6px; border-radius: 50%; }
.rq-statut.en_attente { background: rgba(245,158,11,0.1); color: #d97706; }
.rq-statut.en_attente::before { background: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,0.2); animation: pulse 1.8s ease-in-out infinite; }
.rq-statut.en_cours   { background: rgba(59,130,246,0.1); color: #2563eb; }
.rq-statut.en_cours::before   { background: #3b82f6; }
.rq-statut.repondue   { background: rgba(16,185,129,0.1); color: #059669; }
.rq-statut.repondue::before   { background: #10b981; }
.rq-statut.fermee     { background: rgba(100,116,139,0.1); color: #64748b; }
.rq-statut.fermee::before     { background: #94a3b8; }

@keyframes pulse {
  0%, 100% { box-shadow: 0 0 0 0px rgba(245,158,11,0.4); }
  50%       { box-shadow: 0 0 0 5px rgba(245,158,11,0); }
}

/* ── Progress Steps ── */
.rq-progress {
  padding: 0 28px 22px;
  display: flex;
  align-items: center;
}
.step {
  display: flex; flex-direction: column; align-items: center; gap: 6px;
  flex: 1; position: relative;
}
.step:not(:last-child)::after {
  content: '';
  position: absolute;
  top: 12px;
  left: calc(50% + 14px);
  right: calc(-50% + 14px);
  height: 2px;
  background: var(--card-border);
}
.step.done:not(:last-child)::after { background: linear-gradient(90deg, #3b82f6, #818cf8); }
.step-dot {
  width: 24px; height: 24px;
  border-radius: 50%;
  border: 2px solid var(--card-border);
  background: var(--card-bg);
  display: flex; align-items: center; justify-content: center;
  font-size: 0.62rem;
  font-weight: 800;
  color: var(--text-muted);
  position: relative;
  z-index: 1;
}
.step.done .step-dot {
  background: linear-gradient(135deg, #3b82f6, #818cf8);
  border-color: transparent;
  color: white;
}
.step.current .step-dot {
  background: var(--card-bg);
  border-color: #3b82f6;
  border-width: 2px;
  color: #3b82f6;
  box-shadow: 0 0 0 4px rgba(59,130,246,0.12);
}
.step.done.green .step-dot { background: linear-gradient(135deg, #10b981, #059669); }
.step.done.slate .step-dot  { background: linear-gradient(135deg, #64748b, #475569); }
.step-label {
  font-size: 0.65rem;
  font-weight: 600;
  color: var(--text-muted);
  white-space: nowrap;
  text-align: center;
}
.step.current .step-label { color: #3b82f6; font-weight: 700; }
.step.done .step-label    { color: var(--text-secondary); }

/* ── Thread ── */
.thread-wrap {
  background: var(--card-bg);
  border: 1px solid var(--card-border);
  border-radius: 16px;
  overflow: hidden;
}
.thread-inner { padding: 28px; display: flex; flex-direction: column; gap: 28px; overflow: hidden; }

/* Bubble row */
.msg-row { display: flex; gap: 12px; }
.msg-row.right { flex-direction: row-reverse; }

.msg-avatar {
  width: 38px; height: 38px;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 0.82rem;
  font-weight: 800;
  flex-shrink: 0;
  margin-top: 2px;
}
.msg-avatar.you   { background: linear-gradient(135deg, #3b82f6, #818cf8); color: #fff; }
.msg-avatar.admin { background: linear-gradient(135deg, #10b981, #059669); color: #fff; }

.msg-content { flex: 1; min-width: 0; display: flex; flex-direction: column; max-width: 78%; }
.msg-row.right .msg-content { align-items: flex-end; }

.msg-name-time { font-size: 0.71rem; color: var(--text-muted); margin-bottom: 6px; display: flex; align-items: center; gap: 6px; }
.msg-row.right .msg-name-time { flex-direction: row-reverse; }

.msg-bubble {
  padding: 14px 18px;
  border-radius: 14px;
  font-size: 0.88rem;
  line-height: 1.7;
  white-space: pre-wrap;
  word-break: break-word;
  overflow-wrap: anywhere;
  max-width: 100%;
}
.msg-bubble.you {
  background: rgba(59,130,246,0.07);
  border: 1px solid rgba(59,130,246,0.15);
  color: var(--text-primary);
  border-top-right-radius: 4px;
}
.msg-bubble.admin {
  background: rgba(16,185,129,0.07);
  border: 1px solid rgba(16,185,129,0.15);
  color: var(--text-primary);
  border-top-left-radius: 4px;
}

/* ── Awaiting state ── */
.awaiting-wrap {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 14px;
  padding: 36px 0 8px;
}
.awaiting-dots {
  display: flex; gap: 6px; align-items: center;
}
.awaiting-dots span {
  width: 8px; height: 8px;
  border-radius: 50%;
  background: #f59e0b;
  animation: dotBounce 1.4s ease-in-out infinite;
}
.awaiting-dots span:nth-child(2) { animation-delay: 0.2s; background: #fbbf24; }
.awaiting-dots span:nth-child(3) { animation-delay: 0.4s; background: #fde68a; }
@keyframes dotBounce {
  0%, 80%, 100% { transform: translateY(0); opacity: 0.5; }
  40%           { transform: translateY(-8px); opacity: 1; }
}
.awaiting-text { font-size: 0.83rem; color: var(--text-muted); font-weight: 500; }
.awaiting-sub  { font-size: 0.74rem; color: var(--text-muted); opacity: 0.6; }

/* ── Divider ── */
.thread-divider {
  display: flex; align-items: center; gap: 12px;
  color: var(--text-muted);
  font-size: 0.71rem;
  font-weight: 600;
  letter-spacing: 0.06em;
  text-transform: uppercase;
}
.thread-divider::before, .thread-divider::after {
  content: '';
  flex: 1;
  height: 1px;
  background: var(--card-border);
}

/* ── Closed notice ── */
.closed-bar {
  margin: 0 28px 24px;
  padding: 12px 16px;
  border-radius: 10px;
  background: rgba(100,116,139,0.06);
  border: 1px solid rgba(100,116,139,0.15);
  font-size: 0.8rem;
  color: #64748b;
  display: flex;
  align-items: center;
  gap: 8px;
}

/* ── Reply card ── */
.reply-card {
  background: var(--card-bg);
  border: 1px solid var(--card-border);
  border-radius: 16px;
  overflow: hidden;
}
.reply-card-header {
  padding: 18px 24px 16px;
  border-bottom: 1px solid var(--card-border);
  font-size: 0.92rem;
  font-weight: 700;
  color: var(--text-primary);
  display: flex;
  align-items: center;
  gap: 8px;
}
.reply-form { padding: 24px; display: flex; flex-direction: column; gap: 16px; }
.reply-textarea {
  width: 100%;
  min-height: 120px;
  padding: 14px 16px;
  border: 1px solid var(--card-border);
  border-radius: 12px;
  background: var(--bg-tertiary);
  color: var(--text-primary);
  font-size: 0.9rem;
  line-height: 1.6;
  resize: vertical;
  font-family: inherit;
  transition: border-color 0.15s, box-shadow 0.15s;
  box-sizing: border-box;
}
.reply-textarea:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }

.reply-actions { display: flex; align-items: center; justify-content: flex-end; gap: 12px; flex-wrap: wrap; }

/* Buttons */
.btn-reply {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 11px 24px;
  border-radius: 10px;
  font-size: 0.87rem; font-weight: 700;
  background: linear-gradient(135deg, #3b82f6, #6366f1);
  color: #fff;
  border: none;
  cursor: pointer;
  transition: all 0.15s;
}
.btn-reply:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(59,130,246,0.35); }
.btn-reply:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

/* ── Back button ── */
.back-btn {
  display: inline-flex; align-items: center; gap: 7px;
  padding: 10px 18px;
  border: 1px solid var(--card-border);
  border-radius: 10px;
  font-size: 0.84rem;
  font-weight: 600;
  color: var(--text-primary);
  text-decoration: none;
  width: fit-content;
  transition: all 0.15s;
  background: var(--card-bg);
}
.back-btn:hover { border-color: #3b82f6; color: #3b82f6; background: rgba(59,130,246,0.04); }

/* Dark mode bubble slight adjustment */
.dark .msg-bubble.you  { background: rgba(59,130,246,0.1); }
.dark .msg-bubble.admin { background: rgba(16,185,129,0.09); }

@media (max-width: 600px) {
  .rq-hero-body { flex-direction: column; }
  .rq-progress { display: none; }
  .msg-content { max-width: 88%; }
}
</style>
@endsection

@section('content')
<div class="rq-show">

    {{-- Breadcrumb --}}
    <div class="rq-bc">
        <a href="{{ route('admin.requetes.index') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="vertical-align:-1px"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Mes Requêtes
        </a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
        <span>{{ \Str::limit($requete->sujet, 42) }}</span>
    </div>

    {{-- Hero card --}}
    <div class="rq-hero">
        <div class="rq-hero-stripe {{ $requete->isUrgente() ? 'urgente' : '' }}"></div>
        <div class="rq-hero-body">
            <div class="rq-hero-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div class="rq-hero-content">
                <div class="rq-hero-subject">{{ $requete->sujet }}</div>
                <div class="rq-hero-tags">
                    <span class="tag cat">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                        {{ $requete->categorieLibelle }}
                    </span>
                    <span class="tag date">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Envoyée {{ $requete->created_at->diffForHumans() }}
                    </span>
                    @if($requete->isUrgente())
                    <span class="tag urg">
                        🔴 Urgente
                    </span>
                    @endif
                </div>
            </div>
            <span class="rq-statut {{ $requete->statut }}">{{ $requete->statutLibelle }}</span>
        </div>

        {{-- Barre de progression --}}
        @php
            $steps = [
                ['key' => 'sent',      'label' => 'Envoyée',   'states' => ['en_attente','en_cours','repondue','fermee']],
                ['key' => 'en_cours',  'label' => 'En cours',  'states' => ['en_cours','repondue','fermee']],
                ['key' => 'repondue',  'label' => 'Répondue',  'states' => ['repondue','fermee']],
                ['key' => 'fermee',    'label' => 'Fermée',    'states' => ['fermee']],
            ];
            $currentStatut = $requete->statut;
        @endphp
        <div class="rq-progress">
            @foreach($steps as $i => $step)
            @php
                $isDone    = in_array($currentStatut, $step['states']);
                $isCurrent = ($i === 0 && $currentStatut === 'en_attente')
                          || ($step['key'] === $currentStatut);
                $colorClass = ($step['key'] === 'repondue') ? 'green' : (($step['key'] === 'fermee') ? 'slate' : '');
            @endphp
            <div class="step {{ $isDone ? 'done '.$colorClass : ($isCurrent ? 'current' : '') }}">
                <div class="step-dot">
                    @if($isDone)
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                    @else
                    {{ $i + 1 }}
                    @endif
                </div>
                <div class="step-label">{{ $step['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Thread --}}
    <div class="thread-wrap">
        <div class="thread-inner">

            {{-- Message initial du chef --}}
            <div class="msg-row right">
                <div class="msg-avatar you">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="msg-content">
                    <div class="msg-name-time">
                        <strong style="color: var(--text-primary);">Vous</strong>
                        <span>{{ $requete->created_at->format('d/m/Y à H\hi') }}</span>
                    </div>
                    <div class="msg-bubble you">{{ $requete->message }}</div>
                </div>
            </div>

            {{-- Messages du fil (requete_messages) --}}
            @if($messages->isNotEmpty())

            <div class="thread-divider">Échanges</div>

            @foreach($messages as $msg)
            @php $isAdmin = $msg->isFromAdmin(); @endphp
            <div class="msg-row {{ $isAdmin ? '' : 'right' }}">
                <div class="msg-avatar {{ $isAdmin ? 'admin' : 'you' }}">
                    @if($isAdmin)
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    @else
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    @endif
                </div>
                <div class="msg-content">
                    <div class="msg-name-time">
                        <strong style="color: var(--text-primary);">
                            {{ $isAdmin ? 'Support Portail RH+' : 'Vous' }}
                        </strong>
                        <span>{{ $msg->created_at->format('d/m/Y à H\hi') }}</span>
                    </div>
                    <div class="msg-bubble {{ $isAdmin ? 'admin' : 'you' }}">{{ $msg->content }}</div>
                </div>
            </div>
            @endforeach

            @elseif(!$requete->isFermee())

            <div class="awaiting-wrap">
                <div class="awaiting-dots">
                    <span></span><span></span><span></span>
                </div>
                <div class="awaiting-text">En attente de réponse du support</div>
                <div class="awaiting-sub">Nous vous notifierons dès qu'une réponse est disponible</div>
            </div>

            @endif
        </div>

        @if($requete->isFermee())
        <div class="closed-bar">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            Cette requête est fermée — plus aucune action n'est possible.
        </div>
        @endif
    </div>

    {{-- Formulaire de réponse (si une réponse admin existe et ticket non fermé) --}}
    @if($messages->isNotEmpty() && $messages->last()->isFromAdmin() && !$requete->isFermee())
    <div class="reply-card">
        <div class="reply-card-header">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            Répondre au support
        </div>

        <form id="replyForm" action="{{ route('admin.requetes.chef-reply', $requete) }}" method="POST" class="reply-form">
            @csrf

            @if($errors->any())
            <div style="padding: 12px 16px; border-radius: 8px; background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2); color: #dc2626; font-size: 0.84rem;">
                {{ $errors->first() }}
            </div>
            @endif

            <textarea name="content" class="reply-textarea" placeholder="Rédigez votre message…" rows="5" required>{{ old('content') }}</textarea>

            <div class="reply-actions">
                <a href="{{ route('admin.requetes.index') }}" class="back-btn">Annuler</a>
                <button type="submit" class="btn-reply" id="btnReply">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    Envoyer
                </button>
            </div>
        </form>
    </div>
    @endif

    {{-- Retour --}}
    @if($requete->isFermee() || $messages->isEmpty() || $messages->last()->isFromChef())
    <a href="{{ route('admin.requetes.index') }}" class="back-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Retour à mes requêtes
    </a>
    @endif

</div>
@endsection

@section('scripts')
<script>
const replyForm = document.getElementById('replyForm');
const btnReply  = document.getElementById('btnReply');
if (replyForm && btnReply) {
    replyForm.addEventListener('submit', function() {
        btnReply.disabled = true;
        btnReply.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation:spin 1s linear infinite"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg> Envoi…';
    });
}
</script>
@endsection
