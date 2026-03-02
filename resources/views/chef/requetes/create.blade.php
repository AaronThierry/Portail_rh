@extends('layouts.app')

@section('title', 'Assistance RH — Portail RH+')
@section('page-title', 'Assistant RH')
@section('page-subtitle', 'Obtenez de l\'aide instantanément')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M12 2a4 4 0 0 1 4 4v1h1a3 3 0 0 1 3 3v7a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3V10a3 3 0 0 1 3-3h1V6a4 4 0 0 1 4-4z"/>
    <circle cx="9" cy="13" r="1" fill="currentColor"/><circle cx="12" cy="13" r="1" fill="currentColor"/><circle cx="15" cy="13" r="1" fill="currentColor"/>
</svg>
@endsection

@section('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&display=swap');

/* ── Layout ───────────────────────────────────── */
.assist-wrap {
    max-width: 780px;
    padding-bottom: 48px;
    font-family: 'Sora', var(--font-sans, system-ui), sans-serif;
}

/* ── Step container ───────────────────────────── */
.step-outer {
    position: relative;
    min-height: 560px;
    overflow: hidden;
}
.step-panel {
    position: absolute; inset: 0;
    opacity: 0;
    transform: translateX(48px);
    pointer-events: none;
    transition: opacity .38s cubic-bezier(.4,0,.2,1), transform .38s cubic-bezier(.4,0,.2,1);
    display: flex; flex-direction: column;
}
.step-panel.is-active {
    opacity: 1;
    transform: translateX(0);
    pointer-events: all;
    position: relative;
}
.step-panel.is-exit {
    opacity: 0;
    transform: translateX(-48px);
}

/* ── Card shell ───────────────────────────────── */
.assist-card {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 16px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 100%;
}
.card-stripe {
    height: 3px;
    background: linear-gradient(90deg, #6366f1 0%, #a78bfa 40%, #f59e0b 100%);
}

/* ── Chat header ──────────────────────────────── */
.chat-header {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 18px 24px 16px;
    border-bottom: 1px solid var(--card-border);
}
.bot-avatar-wrap {
    position: relative;
    width: 42px; height: 42px; flex-shrink: 0;
}
.bot-avatar {
    width: 42px; height: 42px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
}
.bot-avatar svg { color: white; }
.bot-pulse {
    position: absolute;
    bottom: -2px; right: -2px;
    width: 12px; height: 12px;
    background: #10b981;
    border-radius: 50%;
    border: 2px solid var(--card-bg);
}
.bot-pulse::before {
    content: '';
    position: absolute;
    inset: -3px;
    border-radius: 50%;
    background: rgba(16,185,129,.3);
    animation: pulse-ring 1.8s ease-out infinite;
}
@keyframes pulse-ring {
    0%   { transform: scale(1); opacity: .8; }
    100% { transform: scale(2.2); opacity: 0; }
}
.chat-header-info { flex: 1; min-width: 0; }
.chat-header-name {
    font-weight: 700;
    font-size: .92rem;
    color: var(--text-primary);
    letter-spacing: -.02em;
}
.chat-header-status {
    font-size: .73rem;
    color: #10b981;
    display: flex; align-items: center; gap: 5px;
    margin-top: 1px;
}
.chat-header-status::before {
    content: '';
    width: 6px; height: 6px;
    background: #10b981;
    border-radius: 50%;
    display: inline-block;
}
.chat-header-badge {
    font-size: .7rem;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
    background: rgba(99,102,241,.1);
    color: #6366f1;
    letter-spacing: .04em;
    text-transform: uppercase;
}

/* ── Chat messages area ───────────────────────── */
.chat-messages {
    flex: 1;
    padding: 20px 24px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 14px;
    min-height: 340px;
    max-height: 380px;
    scrollbar-width: thin;
    scrollbar-color: var(--card-border) transparent;
}

/* Message bubble */
.msg { display: flex; align-items: flex-end; gap: 10px; animation: msg-in .3s cubic-bezier(.4,0,.2,1); }
@keyframes msg-in {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}
.msg.msg-bot { flex-direction: row; }
.msg.msg-user { flex-direction: row-reverse; }

.msg-icon {
    width: 30px; height: 30px; flex-shrink: 0;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
}
.msg-icon svg { width: 14px; height: 14px; color: white; }

.bubble {
    max-width: 75%;
    padding: 11px 15px;
    border-radius: 14px;
    font-size: .875rem;
    line-height: 1.6;
    white-space: pre-wrap;
    word-break: break-word;
}
.msg-bot .bubble {
    background: rgba(99,102,241,.08);
    border: 1px solid rgba(99,102,241,.15);
    color: var(--text-primary);
    border-bottom-left-radius: 4px;
}
.msg-user .bubble {
    background: linear-gradient(135deg, #3b82f6, #6366f1);
    color: white;
    border-bottom-right-radius: 4px;
}

/* Typing indicator */
.typing-indicator {
    display: flex; align-items: flex-end; gap: 10px;
}
.typing-dots {
    background: rgba(99,102,241,.08);
    border: 1px solid rgba(99,102,241,.15);
    border-radius: 14px;
    border-bottom-left-radius: 4px;
    padding: 12px 16px;
    display: flex; align-items: center; gap: 4px;
}
.typing-dots span {
    width: 6px; height: 6px;
    background: #6366f1;
    border-radius: 50%;
    opacity: .5;
    animation: typing-bounce .9s ease-in-out infinite;
}
.typing-dots span:nth-child(2) { animation-delay: .15s; }
.typing-dots span:nth-child(3) { animation-delay: .3s; }
@keyframes typing-bounce {
    0%, 100% { transform: translateY(0); opacity: .5; }
    50%       { transform: translateY(-5px); opacity: 1; }
}

/* ── Chat input ───────────────────────────────── */
.chat-input-area {
    padding: 14px 20px 16px;
    border-top: 1px solid var(--card-border);
    background: var(--bg-tertiary, rgba(0,0,0,.02));
}
.chat-input-row {
    display: flex;
    align-items: center;
    gap: 10px;
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 12px;
    padding: 8px 8px 8px 16px;
    transition: border-color .15s, box-shadow .15s;
}
.chat-input-row:focus-within {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,.1);
}
.chat-input {
    flex: 1;
    border: none;
    background: transparent;
    color: var(--text-primary);
    font-family: inherit;
    font-size: .875rem;
    resize: none;
    outline: none;
    max-height: 120px;
    min-height: 24px;
    line-height: 1.5;
}
.chat-input::placeholder { color: var(--text-muted); }
.chat-send-btn {
    width: 36px; height: 36px;
    border-radius: 9px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border: none;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    transition: transform .15s, opacity .15s;
}
.chat-send-btn:hover:not(:disabled) { transform: scale(1.06); }
.chat-send-btn:disabled { opacity: .4; cursor: default; }
.chat-send-btn svg { color: white; }

/* Agent escalation button */
.escalate-bar {
    padding: 12px 20px 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
.escalate-btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 18px;
    font-family: inherit;
    font-size: .78rem;
    font-weight: 600;
    color: var(--text-muted);
    background: transparent;
    border: 1px solid var(--card-border);
    border-radius: 8px;
    cursor: pointer;
    transition: all .15s;
    letter-spacing: .01em;
}
.escalate-btn:hover {
    color: var(--text-primary);
    border-color: var(--text-muted);
    background: var(--bg-tertiary, rgba(0,0,0,.03));
}
.escalate-btn svg { opacity: .6; }

/* ── Form step ────────────────────────────────── */
.form-card {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 16px;
    overflow: hidden;
    height: 100%;
}
.form-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 18px 24px;
    border-bottom: 1px solid var(--card-border);
}
.back-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 12px;
    font-family: inherit;
    font-size: .78rem;
    font-weight: 600;
    color: var(--text-muted);
    background: transparent;
    border: 1px solid var(--card-border);
    border-radius: 7px;
    cursor: pointer;
    transition: all .15s;
    white-space: nowrap;
}
.back-btn:hover { color: var(--text-primary); background: var(--bg-tertiary); }
.form-header-title {
    font-size: .95rem;
    font-weight: 700;
    color: var(--text-primary);
    letter-spacing: -.02em;
}
.form-header-sub {
    font-size: .75rem;
    color: var(--text-muted);
    margin-top: 1px;
}

/* Chat summary badge in form */
.chat-summary-box {
    margin: 20px 24px 0;
    padding: 12px 16px;
    background: rgba(99,102,241,.05);
    border: 1px solid rgba(99,102,241,.15);
    border-radius: 10px;
    display: flex;
    gap: 10px;
    align-items: flex-start;
}
.chat-summary-box svg { flex-shrink: 0; margin-top: 1px; }
.chat-summary-text {
    font-size: .78rem;
    color: var(--text-muted);
    line-height: 1.55;
}
.chat-summary-text strong { color: var(--text-primary); font-weight: 600; }

.form-body { padding: 20px 24px 28px; }

/* Form controls */
.fg { margin-bottom: 20px; }
.fl {
    display: block;
    font-size: .72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .07em;
    color: var(--text-muted);
    margin-bottom: 7px;
}
.fl .star { color: #ef4444; margin-left: 2px; }
.fi, .fta {
    width: 100%;
    padding: 10px 13px;
    border: 1px solid var(--card-border);
    border-radius: 9px;
    background: var(--bg-tertiary, rgba(0,0,0,.02));
    color: var(--text-primary);
    font-family: inherit;
    font-size: .875rem;
    transition: border-color .15s, box-shadow .15s;
}
.fi:focus, .fta:focus {
    outline: none;
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,.1);
    background: var(--card-bg);
}
.fta { resize: vertical; min-height: 130px; line-height: 1.6; }
.form-error { color: #dc2626; font-size: .75rem; margin-top: 4px; }
.char-ct { font-size: .7rem; color: var(--text-muted); text-align: right; margin-top: 3px; }

/* Category pills */
.cat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; }
.cat-pill input { display: none; }
.cat-pill label {
    display: flex; flex-direction: column; align-items: center; gap: 5px;
    padding: 10px 6px;
    border: 1.5px solid var(--card-border);
    border-radius: 9px;
    cursor: pointer;
    font-size: .72rem; font-weight: 600;
    color: var(--text-muted);
    text-align: center;
    transition: all .15s;
}
.cat-pill label svg { width: 22px; height: 22px; }
.cat-pill label:hover { border-color: #6366f1; color: #6366f1; background: rgba(99,102,241,.05); }
.cat-pill input:checked + label {
    border-color: #6366f1;
    background: rgba(99,102,241,.08);
    color: #6366f1;
}

/* Priority toggle */
.prio-row { display: flex; gap: 8px; }
.prio-row input { display: none; }
.prio-row label {
    flex: 1; padding: 9px 14px;
    border: 1.5px solid var(--card-border);
    border-radius: 8px;
    cursor: pointer;
    text-align: center;
    font-size: .8rem; font-weight: 700;
    transition: all .15s;
}
.prio-n input:checked + label { border-color: #10b981; background: rgba(16,185,129,.08); color: #059669; }
.prio-u input:checked + label { border-color: #ef4444; background: rgba(239,68,68,.08); color: #dc2626; }

.form-actions {
    display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
    margin-top: 4px;
}
.btn-submit {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 11px 26px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: white; border: none; border-radius: 9px;
    font-family: inherit; font-size: .875rem; font-weight: 700;
    cursor: pointer; transition: opacity .15s, transform .15s;
    letter-spacing: -.01em;
}
.btn-submit:hover { opacity: .9; transform: translateY(-1px); }
.btn-cancel-link {
    font-size: .85rem; font-weight: 500; color: var(--text-muted);
    text-decoration: none; padding: 11px 14px;
    border-radius: 8px; transition: all .15s;
}
.btn-cancel-link:hover { background: var(--bg-tertiary); color: var(--text-primary); }

@media (max-width: 600px) {
    .cat-grid { grid-template-columns: repeat(2, 1fr); }
    .chat-messages { max-height: 300px; }
}
</style>
@endsection

@section('content')
<div class="assist-wrap">
<div class="step-outer" id="stepOuter">

    {{-- ─── STEP 1 : Chat assistant ──────────────────────────── --}}
    <div class="step-panel is-active" id="stepChat">
        <div class="assist-card">
            <div class="card-stripe"></div>

            {{-- Header --}}
            <div class="chat-header">
                <div class="bot-avatar-wrap">
                    <div class="bot-avatar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            <circle cx="12" cy="16" r="1" fill="currentColor"/>
                        </svg>
                    </div>
                    <div class="bot-pulse"></div>
                </div>
                <div class="chat-header-info">
                    <div class="chat-header-name">Assistant RH</div>
                    <div class="chat-header-status">En ligne · prêt à vous aider</div>
                </div>
                <div class="chat-header-badge">IA</div>
            </div>

            {{-- Messages --}}
            <div class="chat-messages" id="chatMessages">
                {{-- Message d'accueil du bot --}}
                <div class="msg msg-bot" id="welcomeMsg">
                    <div class="msg-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </div>
                    <div class="bubble">
Bonjour ! Je suis votre assistant RH du Portail RH+. 👋

Je suis là pour répondre à vos questions sur la gestion des congés, les bulletins de paie, la facturation ou le support technique.

Comment puis-je vous aider aujourd'hui ?
                    </div>
                </div>
            </div>

            {{-- Input --}}
            <div class="chat-input-area">
                <div class="chat-input-row">
                    <textarea
                        id="chatInput"
                        class="chat-input"
                        placeholder="Posez votre question…"
                        rows="1"
                        maxlength="1000"
                    ></textarea>
                    <button class="chat-send-btn" id="chatSendBtn" title="Envoyer" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Escalation --}}
            <div class="escalate-bar">
                <button class="escalate-btn" id="escalateBtn" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    Je souhaite parler à un agent humain
                </button>
            </div>
            <div style="height:16px"></div>
        </div>
    </div>

    {{-- ─── STEP 2 : Formulaire ──────────────────────────────── --}}
    <div class="step-panel" id="stepForm">
        <div class="form-card">
            <div class="card-stripe"></div>

            {{-- Header --}}
            <div class="form-header">
                <button class="back-btn" id="backToChat" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="15 18 9 12 15 6"/>
                    </svg>
                    Retour au chat
                </button>
                <div>
                    <div class="form-header-title">Contacter un agent</div>
                    <div class="form-header-sub">Votre message sera traité dans les plus brefs délais</div>
                </div>
            </div>

            {{-- Chat summary --}}
            <div class="chat-summary-box" id="chatSummaryBox" style="display:none">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
                <div class="chat-summary-text">
                    <strong>Résumé de votre échange avec l'assistant :</strong><br>
                    <span id="chatSummaryText"></span>
                </div>
            </div>

            {{-- Form --}}
            <form action="{{ route('admin.requetes.store') }}" method="POST" id="requeteForm">
                @csrf
                <div class="form-body">

                    @if($errors->any())
                    <div style="padding:12px 16px;border-radius:8px;background:rgba(239,68,68,.07);border:1px solid rgba(239,68,68,.18);color:#dc2626;font-size:.8rem;margin-bottom:18px;">
                        <strong>Veuillez corriger les erreurs :</strong>
                        <ul style="margin:6px 0 0 16px;padding:0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    {{-- Sujet --}}
                    <div class="fg">
                        <label class="fl">Sujet <span class="star">*</span></label>
                        <input type="text" name="sujet" id="fieldSujet" class="fi"
                               value="{{ old('sujet') }}"
                               placeholder="Résumez votre demande en quelques mots…"
                               maxlength="150" required>
                        @error('sujet')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Catégorie --}}
                    <div class="fg">
                        <label class="fl">Catégorie <span class="star">*</span></label>
                        <div class="cat-grid">
                            <div class="cat-pill">
                                <input type="radio" name="categorie" id="cat_q" value="question" {{ old('categorie','question')==='question' ? 'checked' : '' }}>
                                <label for="cat_q">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                    Question
                                </label>
                            </div>
                            <div class="cat-pill">
                                <input type="radio" name="categorie" id="cat_f" value="facturation" {{ old('categorie')==='facturation' ? 'checked' : '' }}>
                                <label for="cat_f">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                    Facturation
                                </label>
                            </div>
                            <div class="cat-pill">
                                <input type="radio" name="categorie" id="cat_s" value="support" {{ old('categorie')==='support' ? 'checked' : '' }}>
                                <label for="cat_s">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                                    Support
                                </label>
                            </div>
                            <div class="cat-pill">
                                <input type="radio" name="categorie" id="cat_a" value="autre" {{ old('categorie')==='autre' ? 'checked' : '' }}>
                                <label for="cat_a">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                                    Autre
                                </label>
                            </div>
                        </div>
                        @error('categorie')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Priorité --}}
                    <div class="fg">
                        <label class="fl">Priorité <span class="star">*</span></label>
                        <div class="prio-row">
                            <div class="prio-n">
                                <input type="radio" name="priorite" id="prio_n" value="normale" {{ old('priorite','normale')==='normale' ? 'checked' : '' }}>
                                <label for="prio_n">Normale</label>
                            </div>
                            <div class="prio-u">
                                <input type="radio" name="priorite" id="prio_u" value="urgente" {{ old('priorite')==='urgente' ? 'checked' : '' }}>
                                <label for="prio_u">🔴 Urgente</label>
                            </div>
                        </div>
                        @error('priorite')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Message --}}
                    <div class="fg">
                        <label class="fl">Message <span class="star">*</span></label>
                        <textarea name="message" id="fieldMessage" class="fta"
                                  maxlength="3000"
                                  placeholder="Décrivez votre demande en détail…" required>{{ old('message') }}</textarea>
                        <div class="char-ct"><span id="charCount">0</span> / 3000</div>
                        @error('message')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Actions --}}
                    <div class="form-actions">
                        <button type="submit" class="btn-submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
                            </svg>
                            Envoyer la requête
                        </button>
                        <a href="{{ route('admin.requetes.index') }}" class="btn-cancel-link">Annuler</a>
                    </div>

                </div>
            </form>
        </div>
    </div>

</div>{{-- /.step-outer --}}
</div>{{-- /.assist-wrap --}}
@endsection

@section('scripts')
<script>
(function () {
    'use strict';

    const CSRF      = '{{ csrf_token() }}';
    const BOT_URL   = '{{ route("admin.requetes.assistant") }}';

    // State
    let chatHistory = []; // [{role:'user'|'bot', text:'...'}]
    let isLoading   = false;

    // DOM refs
    const msgs       = document.getElementById('chatMessages');
    const input      = document.getElementById('chatInput');
    const sendBtn    = document.getElementById('chatSendBtn');
    const escalateBtn = document.getElementById('escalateBtn');
    const backBtn    = document.getElementById('backToChat');
    const stepChat   = document.getElementById('stepChat');
    const stepForm   = document.getElementById('stepForm');
    const outer      = document.getElementById('stepOuter');
    const summaryBox = document.getElementById('chatSummaryBox');
    const summaryTxt = document.getElementById('chatSummaryText');
    const fieldMsg   = document.getElementById('fieldMessage');
    const fieldSujet = document.getElementById('fieldSujet');
    const charCount  = document.getElementById('charCount');

    // ── Textarea auto-grow ──────────────────────────────────
    input.addEventListener('input', () => {
        input.style.height = 'auto';
        input.style.height = Math.min(input.scrollHeight, 120) + 'px';
        sendBtn.disabled = input.value.trim().length === 0 || isLoading;
    });

    input.addEventListener('keydown', e => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            if (!sendBtn.disabled) sendMessage();
        }
    });

    sendBtn.addEventListener('click', sendMessage);

    // ── Message append ──────────────────────────────────────
    function appendMessage(role, text) {
        const wrap = document.createElement('div');
        wrap.className = 'msg msg-' + (role === 'user' ? 'user' : 'bot');

        if (role === 'bot') {
            const icon = document.createElement('div');
            icon.className = 'msg-icon';
            icon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>`;
            wrap.appendChild(icon);
        }

        const bubble = document.createElement('div');
        bubble.className = 'bubble';
        bubble.textContent = text;
        wrap.appendChild(bubble);

        msgs.appendChild(wrap);
        msgs.scrollTo({ top: msgs.scrollHeight, behavior: 'smooth' });
        chatHistory.push({ role, text });
    }

    // ── Typing indicator ────────────────────────────────────
    function showTyping() {
        const wrap = document.createElement('div');
        wrap.className = 'msg msg-bot';
        wrap.id = 'typingIndicator';
        const icon = document.createElement('div');
        icon.className = 'msg-icon';
        icon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
        </svg>`;
        const dots = document.createElement('div');
        dots.className = 'typing-dots';
        dots.innerHTML = '<span></span><span></span><span></span>';
        wrap.appendChild(icon);
        wrap.appendChild(dots);
        msgs.appendChild(wrap);
        msgs.scrollTo({ top: msgs.scrollHeight, behavior: 'smooth' });
    }

    function hideTyping() {
        const el = document.getElementById('typingIndicator');
        if (el) el.remove();
    }

    // ── Send message ────────────────────────────────────────
    async function sendMessage() {
        const text = input.value.trim();
        if (!text || isLoading) return;

        isLoading = true;
        sendBtn.disabled = true;
        input.value = '';
        input.style.height = 'auto';

        appendMessage('user', text);
        showTyping();

        try {
            const res = await fetch(BOT_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ message: text }),
            });

            hideTyping();

            if (!res.ok) throw new Error('Erreur réseau');
            const data = await res.json();
            appendMessage('bot', data.reply);

        } catch (err) {
            hideTyping();
            appendMessage('bot', "Je rencontre une difficulté technique. Vous pouvez utiliser le formulaire pour contacter un agent directement.");
        } finally {
            isLoading = false;
            sendBtn.disabled = input.value.trim().length === 0;
        }
    }

    // ── Step transition ─────────────────────────────────────
    function goToForm() {
        // Build a summary from the chat history
        const summary = chatHistory
            .filter(m => m.role === 'user')
            .map(m => m.text)
            .slice(0, 3)
            .join(' — ');

        if (summary) {
            summaryTxt.textContent = summary.length > 300 ? summary.slice(0, 300) + '…' : summary;
            summaryBox.style.display = 'flex';

            // Pre-fill message field with the full conversation
            const fullConv = chatHistory
                .map(m => (m.role === 'user' ? 'Moi : ' : 'Assistant : ') + m.text)
                .join('\n\n');

            if (!fieldMsg.value) {
                fieldMsg.value = fullConv.length > 3000 ? fullConv.slice(0, 2997) + '…' : fullConv;
                charCount.textContent = fieldMsg.value.length;
            }

            // Auto-detect sujet if empty
            if (!fieldSujet.value) {
                const firstUserMsg = chatHistory.find(m => m.role === 'user');
                if (firstUserMsg) {
                    const s = firstUserMsg.text.slice(0, 140);
                    fieldSujet.value = s.length === 140 ? s + '…' : s;
                }
            }
        }

        // Animate transition
        outer.style.minHeight = outer.offsetHeight + 'px';
        stepChat.classList.remove('is-active');
        stepChat.classList.add('is-exit');
        stepForm.classList.add('is-active');

        setTimeout(() => {
            stepChat.classList.remove('is-exit');
            outer.style.minHeight = '';
        }, 400);

        stepForm.querySelector('.fi')?.focus();
    }

    function goToChat() {
        outer.style.minHeight = outer.offsetHeight + 'px';
        stepForm.classList.remove('is-active');
        stepChat.classList.add('is-active');
        stepChat.style.transform = 'translateX(-48px)';
        stepChat.style.opacity = '0';

        requestAnimationFrame(() => {
            stepChat.style.transform = '';
            stepChat.style.opacity = '';
        });

        setTimeout(() => { outer.style.minHeight = ''; }, 400);
        input.focus();
    }

    escalateBtn.addEventListener('click', goToForm);
    backBtn.addEventListener('click', () => {
        // Reset chat session on server
        fetch(BOT_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify({ message: '', reset: true }),
        }).catch(() => {});
        goToChat();
    });

    // ── Form char counter ───────────────────────────────────
    fieldMsg.addEventListener('input', () => {
        charCount.textContent = fieldMsg.value.length;
    });
    charCount.textContent = fieldMsg.value.length;

    // If redirected back here with errors, jump to form directly
    @if($errors->any())
    goToForm();
    @endif

})();
</script>
@endsection
