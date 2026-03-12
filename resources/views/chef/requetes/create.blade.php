@extends('layouts.app')

@section('title', 'Assistance — Portail RH+')
@section('page-title', 'Assistance')
@section('page-subtitle', 'Chat IA & support humain')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
</svg>
@endsection

@section('styles')
<style>
/* ══════════════════════════════════════════════════════
   ASSISTANCE RH+ — Charte Orange · Bleu · Gris
   ══════════════════════════════════════════════════════ */

/* Variables locales */
:root {
    --a-orange:      #f97316;
    --a-orange-d:    #ea580c;
    --a-orange-pale: #fff7ed;
    --a-orange-100:  #ffedd5;
    --a-blue:        #2563eb;
    --a-blue-d:      #1d4ed8;
    --a-blue-pale:   #eff6ff;
    --a-blue-100:    #dbeafe;
    --a-green:       #16a34a;
    --a-green-pale:  #dcfce7;
    --a-red:         #dc2626;
    --a-red-pale:    #fee2e2;
    --a-warn:        #d97706;
    --a-warn-pale:   #fef3c7;
    --a-surface:     #ffffff;
    --a-bg:          #f0f2f5;
    --a-border:      #e5e7eb;
    --a-text:        #111827;
    --a-text2:       #6b7280;
    --a-text3:       #9ca3af;
    --a-radius:      10px;
    --a-shadow:      0 1px 3px rgba(0,0,0,.07), 0 1px 2px rgba(0,0,0,.04);
    --a-shadow-md:   0 4px 12px rgba(0,0,0,.08);
    --a-shadow-lg:   0 12px 32px rgba(0,0,0,.1);
}

/* Dark mode */
.dark {
    --a-surface:  #161b22;
    --a-bg:       #0d1117;
    --a-border:   #30363d;
    --a-text:     #e6edf3;
    --a-text2:    #8b949e;
    --a-text3:    #6e7681;
    --a-orange-pale: rgba(249,115,22,.08);
    --a-orange-100:  rgba(249,115,22,.15);
    --a-blue-pale:   rgba(37,99,235,.08);
    --a-blue-100:    rgba(37,99,235,.15);
    --a-green-pale:  rgba(22,163,74,.12);
    --a-red-pale:    rgba(220,38,38,.12);
    --a-warn-pale:   rgba(217,119,6,.12);
}

/* ── Animations ─────────────────────────────────────── */
@keyframes a-fade-up {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes a-slide-in-r {
    from { opacity: 0; transform: translateX(32px); }
    to   { opacity: 1; transform: translateX(0); }
}
@keyframes a-slide-in-l {
    from { opacity: 0; transform: translateX(-32px); }
    to   { opacity: 1; transform: translateX(0); }
}
@keyframes a-msg-pop {
    from { opacity: 0; transform: translateY(8px) scale(.97); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}
@keyframes a-dot-bounce {
    0%, 80%, 100% { transform: translateY(0); opacity: .4; }
    40%           { transform: translateY(-6px); opacity: 1; }
}
@keyframes a-pulse-ring {
    0%   { transform: scale(1); opacity: .6; }
    100% { transform: scale(2.4); opacity: 0; }
}
@keyframes a-ticket-appear {
    0%   { opacity: 0; transform: translateY(-12px) scale(.96); }
    60%  { transform: translateY(2px) scale(1.01); }
    100% { opacity: 1; transform: translateY(0) scale(1); }
}
@keyframes a-shake {
    0%, 100% { transform: translateX(0); }
    20%, 60% { transform: translateX(-4px); }
    40%, 80% { transform: translateX(4px); }
}

/* ── Page layout ────────────────────────────────────── */
.assist-page {
    max-width: 860px;
    display: flex;
    flex-direction: column;
    gap: 0;
    font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
}

/* ── Step switcher ──────────────────────────────────── */
.step-outer {
    position: relative;
    min-height: 580px;
}
.step-panel {
    width: 100%;
    opacity: 0;
    pointer-events: none;
    position: absolute;
    top: 0; left: 0;
    transition: opacity .3s ease, transform .3s ease;
    transform: translateX(28px);
}
.step-panel.is-active {
    opacity: 1;
    pointer-events: all;
    position: relative;
    transform: translateX(0);
    animation: a-slide-in-r .32s ease both;
}
.step-panel.is-exit {
    opacity: 0;
    transform: translateX(-28px);
    pointer-events: none;
}

/* ── Auto-ticket toast ──────────────────────────────── */
.auto-ticket-toast {
    display: none;
    align-items: center;
    gap: 12px;
    padding: 14px 18px;
    background: linear-gradient(135deg, var(--a-orange) 0%, var(--a-orange-d) 100%);
    border-radius: var(--a-radius);
    color: white;
    margin-bottom: 16px;
    animation: a-ticket-appear .45s cubic-bezier(.34,1.56,.64,1) both;
    box-shadow: 0 4px 20px rgba(249,115,22,.35);
}
.auto-ticket-toast.show { display: flex; }
.auto-ticket-toast-icon {
    width: 36px; height: 36px;
    background: rgba(255,255,255,.18);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.auto-ticket-toast-icon svg { width: 18px; height: 18px; }
.auto-ticket-toast-body { flex: 1; min-width: 0; }
.auto-ticket-toast-title {
    font-weight: 700;
    font-size: .875rem;
    margin-bottom: 1px;
}
.auto-ticket-toast-sub {
    font-size: .75rem;
    opacity: .85;
}

/* ── Card shell ─────────────────────────────────────── */
.assist-card {
    background: var(--a-surface);
    border: 1px solid var(--a-border);
    border-radius: 14px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    box-shadow: var(--a-shadow);
}

/* Orange top accent bar */
.assist-card-stripe {
    height: 3px;
    background: linear-gradient(90deg, var(--a-orange) 0%, var(--a-orange-d) 60%, #fb923c 100%);
    flex-shrink: 0;
}

/* ── Chat header ────────────────────────────────────── */
.chat-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px 20px;
    border-bottom: 1px solid var(--a-border);
    flex-shrink: 0;
}

.bot-avatar-wrap {
    position: relative;
    width: 40px; height: 40px;
    flex-shrink: 0;
}
.bot-avatar {
    width: 40px; height: 40px;
    background: var(--a-orange);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: white;
}
.bot-avatar svg { width: 20px; height: 20px; }
.bot-online {
    position: absolute;
    bottom: -2px; right: -2px;
    width: 11px; height: 11px;
    background: var(--a-green);
    border: 2px solid var(--a-surface);
    border-radius: 50%;
}
.bot-online::before {
    content: '';
    position: absolute;
    inset: -3px;
    border-radius: 50%;
    background: rgba(22,163,74,.3);
    animation: a-pulse-ring 2s ease-out infinite;
}

.chat-header-info { flex: 1; min-width: 0; }
.chat-header-name {
    font-size: .9rem;
    font-weight: 700;
    color: var(--a-text);
    letter-spacing: -.015em;
    line-height: 1.2;
}
.chat-header-status {
    font-size: .72rem;
    color: var(--a-green);
    display: flex; align-items: center; gap: 4px;
    margin-top: 2px;
}
.chat-header-status::before {
    content: '';
    width: 5px; height: 5px;
    background: var(--a-green);
    border-radius: 50%;
    flex-shrink: 0;
}

.chat-ia-badge {
    display: flex; align-items: center; gap: 5px;
    font-size: .68rem;
    font-weight: 700;
    letter-spacing: .06em;
    text-transform: uppercase;
    padding: 4px 10px;
    border-radius: 20px;
    background: var(--a-orange-pale);
    border: 1px solid var(--a-orange-100);
    color: var(--a-orange-d);
}
.chat-ia-badge svg { width: 11px; height: 11px; }

/* ── Chat messages ──────────────────────────────────── */
.chat-messages {
    flex: 1;
    padding: 18px 20px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 12px;
    min-height: 360px;
    max-height: 400px;
    scrollbar-width: thin;
    scrollbar-color: var(--a-border) transparent;
}

.msg {
    display: flex;
    align-items: flex-end;
    gap: 8px;
    animation: a-msg-pop .25s ease both;
}
.msg-bot { flex-direction: row; }
.msg-user { flex-direction: row-reverse; }

.msg-avatar {
    width: 28px; height: 28px;
    background: var(--a-orange);
    border-radius: 7px;
    display: flex; align-items: center; justify-content: center;
    color: white;
    flex-shrink: 0;
}
.msg-avatar svg { width: 13px; height: 13px; }

.bubble {
    max-width: 72%;
    padding: 10px 14px;
    border-radius: 12px;
    font-size: .865rem;
    line-height: 1.6;
    white-space: pre-wrap;
    word-break: break-word;
}
.msg-bot .bubble {
    background: var(--a-orange-pale);
    border: 1px solid var(--a-orange-100);
    color: var(--a-text);
    border-bottom-left-radius: 3px;
}
.msg-user .bubble {
    background: var(--a-blue);
    color: white;
    border-bottom-right-radius: 3px;
}

/* ── Typing dots ────────────────────────────────────── */
.typing-wrap { display: flex; align-items: flex-end; gap: 8px; }
.typing-dots {
    background: var(--a-orange-pale);
    border: 1px solid var(--a-orange-100);
    border-radius: 12px;
    border-bottom-left-radius: 3px;
    padding: 10px 14px;
    display: flex; align-items: center; gap: 4px;
}
.typing-dots span {
    width: 6px; height: 6px;
    background: var(--a-orange);
    border-radius: 50%;
    animation: a-dot-bounce .9s ease-in-out infinite;
}
.typing-dots span:nth-child(2) { animation-delay: .15s; }
.typing-dots span:nth-child(3) { animation-delay: .3s; }

/* ── Chat input bar ─────────────────────────────────── */
.chat-input-wrap {
    padding: 12px 16px 14px;
    border-top: 1px solid var(--a-border);
    background: var(--a-bg);
    flex-shrink: 0;
}
.chat-input-row {
    display: flex;
    align-items: flex-end;
    gap: 8px;
    background: var(--a-surface);
    border: 1.5px solid var(--a-border);
    border-radius: 10px;
    padding: 8px 8px 8px 14px;
    transition: border-color .15s, box-shadow .15s;
}
.chat-input-row:focus-within {
    border-color: var(--a-orange);
    box-shadow: 0 0 0 3px rgba(249,115,22,.1);
}
.chat-input {
    flex: 1;
    border: none;
    background: transparent;
    color: var(--a-text);
    font-family: inherit;
    font-size: .875rem;
    resize: none;
    outline: none;
    min-height: 22px;
    max-height: 110px;
    line-height: 1.55;
}
.chat-input::placeholder { color: var(--a-text3); }

.chat-send-btn {
    width: 34px; height: 34px;
    border-radius: 8px;
    background: var(--a-orange);
    border: none;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    transition: background .15s, transform .15s;
    color: white;
}
.chat-send-btn:hover:not(:disabled) { background: var(--a-orange-d); transform: scale(1.05); }
.chat-send-btn:disabled { opacity: .35; cursor: default; }
.chat-send-btn svg { width: 14px; height: 14px; }

/* ── Escalation hint ────────────────────────────────── */
.escalate-bar {
    padding: 10px 16px 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    flex-shrink: 0;
}
.escalate-hint {
    font-size: .72rem;
    color: var(--a-text3);
}
.escalate-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 14px;
    font-family: inherit;
    font-size: .78rem;
    font-weight: 600;
    color: var(--a-blue);
    background: var(--a-blue-pale);
    border: 1px solid var(--a-blue-100);
    border-radius: 7px;
    cursor: pointer;
    transition: all .15s;
    white-space: nowrap;
}
.escalate-btn:hover {
    background: var(--a-blue-100);
    border-color: var(--a-blue);
}
.escalate-btn svg { width: 13px; height: 13px; }

/* Exchange counter badge */
.exchange-counter {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: .68rem;
    font-weight: 600;
    color: var(--a-text3);
    background: var(--a-bg);
    border: 1px solid var(--a-border);
    padding: 3px 8px;
    border-radius: 10px;
}

/* ══════════════════════════════════════════════════════
   STEP 2 — Ticket form
   ══════════════════════════════════════════════════════ */
.form-card {
    background: var(--a-surface);
    border: 1px solid var(--a-border);
    border-radius: 14px;
    overflow: hidden;
    box-shadow: var(--a-shadow);
}

.form-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 20px;
    border-bottom: 1px solid var(--a-border);
    background: var(--a-bg);
}
.back-btn {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 6px 12px;
    font-family: inherit;
    font-size: .78rem;
    font-weight: 600;
    color: var(--a-text2);
    background: var(--a-surface);
    border: 1px solid var(--a-border);
    border-radius: 7px;
    cursor: pointer;
    transition: all .15s;
    white-space: nowrap;
    flex-shrink: 0;
}
.back-btn:hover { color: var(--a-text); border-color: var(--a-text3); }
.back-btn svg { width: 13px; height: 13px; }

.form-header-info { flex: 1; min-width: 0; }
.form-header-title {
    font-size: .9rem;
    font-weight: 700;
    color: var(--a-text);
    letter-spacing: -.015em;
}
.form-header-sub {
    font-size: .72rem;
    color: var(--a-text2);
    margin-top: 1px;
}

/* Chat context summary */
.chat-context {
    margin: 16px 20px 0;
    padding: 12px 15px;
    background: var(--a-blue-pale);
    border: 1px solid var(--a-blue-100);
    border-radius: 8px;
    display: none;
    gap: 10px;
    align-items: flex-start;
}
.chat-context.show { display: flex; }
.chat-context-icon { color: var(--a-blue); flex-shrink: 0; margin-top: 1px; }
.chat-context-icon svg { width: 14px; height: 14px; }
.chat-context-text {
    font-size: .78rem;
    color: var(--a-text2);
    line-height: 1.5;
}
.chat-context-text strong { color: var(--a-text); font-weight: 600; }

.form-body { padding: 18px 20px 24px; }

/* Error box */
.form-error-box {
    padding: 12px 15px;
    border-radius: 8px;
    background: var(--a-red-pale);
    border: 1px solid rgba(220,38,38,.2);
    color: var(--a-red);
    font-size: .8rem;
    margin-bottom: 18px;
}
.form-error-box strong { display: block; margin-bottom: 4px; }
.form-error-box ul { margin: 4px 0 0 16px; padding: 0; }

/* Form groups */
.fg { margin-bottom: 18px; }
.fl {
    display: block;
    font-size: .7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .07em;
    color: var(--a-text2);
    margin-bottom: 6px;
}
.fl .req { color: var(--a-orange); margin-left: 2px; }

.fi, .fta {
    width: 100%;
    padding: 9px 12px;
    border: 1.5px solid var(--a-border);
    border-radius: 8px;
    background: var(--a-bg);
    color: var(--a-text);
    font-family: inherit;
    font-size: .875rem;
    transition: border-color .15s, box-shadow .15s, background .15s;
}
.fi:focus, .fta:focus {
    outline: none;
    border-color: var(--a-orange);
    box-shadow: 0 0 0 3px rgba(249,115,22,.1);
    background: var(--a-surface);
}
.fi-error { border-color: var(--a-red) !important; }
.fta { resize: vertical; min-height: 120px; line-height: 1.6; }
.field-error { color: var(--a-red); font-size: .73rem; margin-top: 4px; }
.char-count { font-size: .7rem; color: var(--a-text3); text-align: right; margin-top: 3px; }

/* Category pills */
.cat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 7px; }
.cat-pill input { display: none; }
.cat-pill label {
    display: flex; flex-direction: column; align-items: center; gap: 5px;
    padding: 10px 6px;
    border: 1.5px solid var(--a-border);
    border-radius: 8px;
    cursor: pointer;
    font-size: .72rem; font-weight: 600;
    color: var(--a-text2);
    text-align: center;
    transition: all .15s;
    background: var(--a-bg);
}
.cat-pill label svg { width: 20px; height: 20px; }
.cat-pill label:hover {
    border-color: var(--a-orange);
    color: var(--a-orange-d);
    background: var(--a-orange-pale);
}
.cat-pill input:checked + label {
    border-color: var(--a-orange);
    background: var(--a-orange-pale);
    color: var(--a-orange-d);
}

/* Priority */
.prio-row { display: flex; gap: 8px; }
.prio-row input { display: none; }
.prio-item { flex: 1; }
.prio-item label {
    display: flex; align-items: center; justify-content: center; gap: 6px;
    width: 100%;
    padding: 9px 14px;
    border: 1.5px solid var(--a-border);
    border-radius: 8px;
    cursor: pointer;
    text-align: center;
    font-size: .82rem; font-weight: 700;
    transition: all .15s;
    background: var(--a-bg);
    color: var(--a-text2);
}
.prio-item label svg { width: 14px; height: 14px; }
.prio-item.prio-n input:checked + label {
    border-color: var(--a-green);
    background: var(--a-green-pale);
    color: var(--a-green);
}
.prio-item.prio-u input:checked + label {
    border-color: var(--a-red);
    background: var(--a-red-pale);
    color: var(--a-red);
}

/* Actions */
.form-actions {
    display: flex; align-items: center; gap: 10px;
    flex-wrap: wrap;
    padding-top: 6px;
}
.btn-submit {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 10px 24px;
    background: var(--a-orange);
    color: white;
    border: none;
    border-radius: 8px;
    font-family: inherit;
    font-size: .875rem;
    font-weight: 700;
    cursor: pointer;
    transition: background .15s, transform .15s, box-shadow .15s;
    letter-spacing: -.01em;
}
.btn-submit:hover {
    background: var(--a-orange-d);
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(249,115,22,.3);
}
.btn-submit svg { width: 15px; height: 15px; }

.btn-cancel {
    font-size: .85rem;
    font-weight: 500;
    color: var(--a-text2);
    text-decoration: none;
    padding: 10px 14px;
    border-radius: 8px;
    transition: all .15s;
}
.btn-cancel:hover { background: var(--a-bg); color: var(--a-text); }

/* ── Responsive ─────────────────────────────────────── */
@media (max-width: 600px) {
    .cat-grid { grid-template-columns: repeat(2, 1fr); }
    .chat-messages { min-height: 280px; max-height: 320px; }
    .prio-row { flex-direction: column; }
    .escalate-bar { flex-direction: column; align-items: flex-start; gap: 6px; }
}
</style>
@endsection

@section('content')
<div class="assist-page">

    {{-- ── Auto-ticket toast ───────────────────────────────── --}}
    <div class="auto-ticket-toast" id="autoTicketToast">
        <div class="auto-ticket-toast-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
            </svg>
        </div>
        <div class="auto-ticket-toast-body">
            <div class="auto-ticket-toast-title">Ticket créé automatiquement</div>
            <div class="auto-ticket-toast-sub">L'IA a détecté que votre problème nécessite l'intervention d'un agent.</div>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16" style="cursor:pointer;opacity:.7;flex-shrink:0" onclick="document.getElementById('autoTicketToast').classList.remove('show')">
            <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
    </div>

    <div class="step-outer" id="stepOuter">

        {{-- ══════════════════════════════════════════════════════
             STEP 1 — Chat Assistant IA
        ══════════════════════════════════════════════════════ --}}
        <div class="step-panel is-active" id="stepChat">
            <div class="assist-card">
                <div class="assist-card-stripe"></div>

                {{-- Header --}}
                <div class="chat-header">
                    <div class="bot-avatar-wrap">
                        <div class="bot-avatar">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                <circle cx="12" cy="16" r="1" fill="currentColor"/>
                            </svg>
                        </div>
                        <div class="bot-online"></div>
                    </div>
                    <div class="chat-header-info">
                        <div class="chat-header-name">Assistant RH</div>
                        <div class="chat-header-status">En ligne &mdash; pr&ecirc;t &agrave; vous aider</div>
                    </div>
                    <div class="chat-ia-badge">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                        IA
                    </div>
                </div>

                {{-- Messages --}}
                <div class="chat-messages" id="chatMessages">
                    <div class="msg msg-bot" id="welcomeMsg">
                        <div class="msg-avatar">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </div>
                        <div class="bubble">Bonjour ! Je suis l'assistant IA du Portail RH+. 👋

Je peux répondre à vos questions sur les congés, bulletins de paie, la facturation ou le support technique.

Si votre problème est complexe, je créerai automatiquement un ticket pour vous connecter à un agent humain.

Comment puis-je vous aider ?</div>
                    </div>
                </div>

                {{-- Input --}}
                <div class="chat-input-wrap">
                    <div class="chat-input-row">
                        <textarea
                            id="chatInput"
                            class="chat-input"
                            placeholder="Décrivez votre problème…"
                            rows="1"
                            maxlength="1000"
                        ></textarea>
                        <button class="chat-send-btn" id="chatSendBtn" disabled title="Envoyer (Entrée)">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <line x1="22" y1="2" x2="11" y2="13"/>
                                <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Escalation bar --}}
                <div class="escalate-bar">
                    <div class="exchange-counter" id="exchangeCounter">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                        <span id="exchangeCountText">0 échange</span>
                    </div>
                    <button class="escalate-btn" id="escalateBtn" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                        Parler &agrave; un agent
                    </button>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════
             STEP 2 — Formulaire ticket
        ══════════════════════════════════════════════════════ --}}
        <div class="step-panel" id="stepForm">
            <div class="form-card">
                <div class="assist-card-stripe"></div>

                {{-- Header --}}
                <div class="form-header">
                    <button class="back-btn" id="backToChat" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="15 18 9 12 15 6"/>
                        </svg>
                        Retour au chat
                    </button>
                    <div class="form-header-info">
                        <div class="form-header-title">Ouvrir un ticket de support</div>
                        <div class="form-header-sub">Votre demande sera traitée par un agent dans les plus brefs d&eacute;lais</div>
                    </div>
                    <div class="chat-ia-badge" style="background:var(--a-orange-pale);border-color:var(--a-orange-100);color:var(--a-orange-d);">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                        Ticket
                    </div>
                </div>

                {{-- Chat context --}}
                <div class="chat-context" id="chatContext">
                    <div class="chat-context-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                    </div>
                    <div class="chat-context-text">
                        <strong>Contexte issu de votre échange avec l'IA :</strong><br>
                        <span id="chatContextText"></span>
                    </div>
                </div>

                {{-- Form --}}
                <form action="{{ route('admin.requetes.store') }}" method="POST" id="requeteForm">
                    @csrf
                    <div class="form-body">

                        @if($errors->any())
                        <div class="form-error-box">
                            <strong>Veuillez corriger les erreurs :</strong>
                            <ul>
                                @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        {{-- Sujet --}}
                        <div class="fg">
                            <label class="fl" for="fieldSujet">Sujet <span class="req">*</span></label>
                            <input type="text" name="sujet" id="fieldSujet" class="fi {{ $errors->has('sujet') ? 'fi-error' : '' }}"
                                   value="{{ old('sujet') }}"
                                   placeholder="Résumez votre demande en une phrase…"
                                   maxlength="150" required>
                            @error('sujet')<div class="field-error">{{ $message }}</div>@enderror
                        </div>

                        {{-- Catégorie --}}
                        <div class="fg">
                            <label class="fl">Catégorie <span class="req">*</span></label>
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
                            @error('categorie')<div class="field-error">{{ $message }}</div>@enderror
                        </div>

                        {{-- Priorité --}}
                        <div class="fg">
                            <label class="fl">Priorité <span class="req">*</span></label>
                            <div class="prio-row">
                                <div class="prio-item prio-n">
                                    <input type="radio" name="priorite" id="prio_n" value="normale" {{ old('priorite','normale')==='normale' ? 'checked' : '' }}>
                                    <label for="prio_n">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        Normale
                                    </label>
                                </div>
                                <div class="prio-item prio-u">
                                    <input type="radio" name="priorite" id="prio_u" value="urgente" {{ old('priorite')==='urgente' ? 'checked' : '' }}>
                                    <label for="prio_u">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                        Urgente
                                    </label>
                                </div>
                            </div>
                            @error('priorite')<div class="field-error">{{ $message }}</div>@enderror
                        </div>

                        {{-- Message --}}
                        <div class="fg">
                            <label class="fl" for="fieldMessage">Message <span class="req">*</span></label>
                            <textarea name="message" id="fieldMessage" class="fta {{ $errors->has('message') ? 'fi-error' : '' }}"
                                      maxlength="3000"
                                      placeholder="Décrivez votre problème en détail…" required>{{ old('message') }}</textarea>
                            <div class="char-count"><span id="charCount">0</span> / 3000</div>
                            @error('message')<div class="field-error">{{ $message }}</div>@enderror
                        </div>

                        {{-- Actions --}}
                        <div class="form-actions">
                            <button type="submit" class="btn-submit">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <line x1="22" y1="2" x2="11" y2="13"/>
                                    <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                                </svg>
                                Envoyer le ticket
                            </button>
                            <a href="{{ route('admin.requetes.index') }}" class="btn-cancel">Annuler</a>
                        </div>

                    </div>
                </form>
            </div>
        </div>

    </div>{{-- /.step-outer --}}
</div>{{-- /.assist-page --}}
@endsection

@section('scripts')
<script>
(function () {
    'use strict';

    const CSRF    = '{{ csrf_token() }}';
    const BOT_URL = '{{ route("admin.requetes.assistant") }}';

    // State
    let chatHistory  = [];
    let isLoading    = false;
    let exchangeCount = 0;
    let autoTicketed = false;

    // DOM
    const msgs       = document.getElementById('chatMessages');
    const input      = document.getElementById('chatInput');
    const sendBtn    = document.getElementById('chatSendBtn');
    const escalBtn   = document.getElementById('escalateBtn');
    const backBtn    = document.getElementById('backToChat');
    const stepChat   = document.getElementById('stepChat');
    const stepForm   = document.getElementById('stepForm');
    const outer      = document.getElementById('stepOuter');
    const ctxBox     = document.getElementById('chatContext');
    const ctxTxt     = document.getElementById('chatContextText');
    const fieldMsg   = document.getElementById('fieldMessage');
    const fieldSujet = document.getElementById('fieldSujet');
    const charCount  = document.getElementById('charCount');
    const toast      = document.getElementById('autoTicketToast');
    const exCounter  = document.getElementById('exchangeCountText');

    // ── Textarea auto-grow ──────────────────────────────────
    input.addEventListener('input', () => {
        input.style.height = 'auto';
        input.style.height = Math.min(input.scrollHeight, 110) + 'px';
        sendBtn.disabled = !input.value.trim() || isLoading;
    });
    input.addEventListener('keydown', e => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            if (!sendBtn.disabled) sendMessage();
        }
    });
    sendBtn.addEventListener('click', sendMessage);

    // ── Append message bubble ───────────────────────────────
    function appendMessage(role, text) {
        const wrap = document.createElement('div');
        wrap.className = 'msg msg-' + (role === 'user' ? 'user' : 'bot');

        if (role === 'bot') {
            const av = document.createElement('div');
            av.className = 'msg-avatar';
            av.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>`;
            wrap.appendChild(av);
        }

        const b = document.createElement('div');
        b.className = 'bubble';
        b.textContent = text;
        wrap.appendChild(b);

        msgs.appendChild(wrap);
        msgs.scrollTo({ top: msgs.scrollHeight, behavior: 'smooth' });
        chatHistory.push({ role, text });
    }

    // ── Typing indicator ────────────────────────────────────
    function showTyping() {
        const wrap = document.createElement('div');
        wrap.className = 'msg msg-bot';
        wrap.id = 'typingInd';
        const av = document.createElement('div');
        av.className = 'msg-avatar';
        av.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
        </svg>`;
        const dots = document.createElement('div');
        dots.className = 'typing-dots';
        dots.innerHTML = '<span></span><span></span><span></span>';
        wrap.appendChild(av); wrap.appendChild(dots);
        msgs.appendChild(wrap);
        msgs.scrollTo({ top: msgs.scrollHeight, behavior: 'smooth' });
    }
    function hideTyping() {
        document.getElementById('typingInd')?.remove();
    }

    // ── Update exchange counter ─────────────────────────────
    function updateCounter(n) {
        exchangeCount = n;
        exCounter.textContent = n === 0 ? '0 échange' : n + (n > 1 ? ' échanges' : ' échange');
    }

    // ── Pre-fill form from chat ─────────────────────────────
    function preFillForm(data) {
        // Sujet
        if (!fieldSujet.value && data.suggested_sujet) {
            fieldSujet.value = data.suggested_sujet;
        }

        // Catégorie
        if (data.suggested_categorie) {
            const catEl = document.getElementById('cat_' + data.suggested_categorie.charAt(0));
            if (catEl) catEl.checked = true;
        }

        // Priorité
        if (data.suggested_priorite === 'urgente') {
            document.getElementById('prio_u').checked = true;
        }

        // Message — résumé de la conversation
        if (!fieldMsg.value && chatHistory.length) {
            const conv = chatHistory
                .map(m => (m.role === 'user' ? 'Moi : ' : 'Assistant : ') + m.text)
                .join('\n\n');
            fieldMsg.value = conv.length > 3000 ? conv.slice(0, 2997) + '…' : conv;
            charCount.textContent = fieldMsg.value.length;
        }

        // Contexte visible
        const userMsgs = chatHistory.filter(m => m.role === 'user').map(m => m.text);
        if (userMsgs.length) {
            const summary = userMsgs.slice(0, 2).join(' — ');
            ctxTxt.textContent = summary.length > 250 ? summary.slice(0, 247) + '…' : summary;
            ctxBox.classList.add('show');
        }
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
            updateCounter(data.exchange_count ?? exchangeCount + 1);

            // ── Auto-ticket si nécessaire ────────────────────────
            if (data.requires_ticket && !autoTicketed) {
                autoTicketed = true;

                // Petit délai pour que l'utilisateur lise la réponse
                setTimeout(() => {
                    preFillForm(data);
                    goToForm(true); // true = auto (pas manuel)
                }, 1200);
            }

        } catch (err) {
            hideTyping();
            appendMessage('bot', "Je rencontre une difficulté technique. Vous pouvez ouvrir un ticket directement en cliquant sur « Parler à un agent ».");
        } finally {
            isLoading = false;
            sendBtn.disabled = !input.value.trim();
        }
    }

    // ── Transition Chat → Form ──────────────────────────────
    function goToForm(auto = false) {
        if (!auto) preFillForm({});

        if (auto) {
            // Show toast
            toast.classList.add('show');
        }

        outer.style.minHeight = outer.offsetHeight + 'px';
        stepChat.classList.remove('is-active');
        stepChat.classList.add('is-exit');
        stepForm.classList.add('is-active');

        setTimeout(() => {
            stepChat.classList.remove('is-exit');
            outer.style.minHeight = '';
        }, 380);

        setTimeout(() => stepForm.querySelector('.fi')?.focus(), 200);
    }

    // ── Transition Form → Chat ──────────────────────────────
    function goToChat() {
        outer.style.minHeight = outer.offsetHeight + 'px';
        stepForm.classList.remove('is-active');
        stepChat.classList.add('is-active');
        stepChat.style.transform = 'translateX(-28px)';
        stepChat.style.opacity   = '0';
        requestAnimationFrame(() => {
            stepChat.style.transform = '';
            stepChat.style.opacity   = '';
        });
        setTimeout(() => { outer.style.minHeight = ''; }, 380);

        // Reset session chat côté serveur
        fetch(BOT_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify({ message: '', reset: true }),
        }).catch(() => {});

        autoTicketed = false;
        input.focus();
    }

    // ── Events ──────────────────────────────────────────────
    escalBtn.addEventListener('click', () => goToForm(false));
    backBtn.addEventListener('click', goToChat);

    fieldMsg.addEventListener('input', () => {
        charCount.textContent = fieldMsg.value.length;
    });
    charCount.textContent = fieldMsg.value.length;

    // Si erreurs de validation → aller direct au formulaire
    @if($errors->any())
    goToForm(false);
    @endif

    // Init counter
    updateCounter(0);

})();
</script>
@endsection
