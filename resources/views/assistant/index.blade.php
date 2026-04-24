@extends('layouts.app')

@section('title', 'Assistant IA')

@section('content')
<style>
:root {
    --ai-bg:      #F2F4F8;
    --ai-surface: #FFFFFF;
    --ai-border:  #E2E5EA;
    --ai-ind-50:  #EEEFFE;
    --ai-ind-100: #D5D9FB;
    --ai-ind-400: #5566D4;
    --ai-ind-600: #2535A8;
    --ai-ind-700: #1A2785;
    --ai-ind-800: #111C62;
    --ai-ind-900: #0A1040;
    --ai-teal-300:#2ECABB;
    --ai-teal-400:#0AAFA2;
    --ai-teal-50: #E5FAF8;
    --ai-teal-100:#B0EFE9;
    --ai-n-100:   #F0F2F5;
    --ai-n-200:   #E2E5EA;
    --ai-n-400:   #9CA3B0;
    --ai-n-500:   #6B7382;
    --ai-n-800:   #1E2330;
    --ai-rose-400:#FB7185;
    --ai-green-400:#34D399;
    --sh: 0 2px 8px rgba(10,16,64,.08),0 1px 3px rgba(10,16,64,.04);
    --sh-md: 0 4px 16px rgba(10,16,64,.10),0 2px 6px rgba(10,16,64,.05);
    --sh-lg: 0 12px 32px rgba(10,16,64,.12),0 4px 10px rgba(10,16,64,.06);
    --r: 8px; --r-lg: 12px; --r-xl: 16px; --r-f: 9999px;
}

@keyframes fadeUp   { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
@keyframes msgIn    { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:translateY(0)} }
@keyframes spin     { to{transform:rotate(360deg)} }
@keyframes blink    { 0%,100%{opacity:1} 50%{opacity:.3} }
@keyframes pulse-ai { 0%,100%{box-shadow:0 0 0 0 rgba(10,175,162,.4)} 70%{box-shadow:0 0 0 8px rgba(10,175,162,0)} }

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

.ai-wrap {
    display: grid;
    grid-template-columns: 1fr 300px;
    grid-template-rows: auto 1fr auto;
    gap: 0;
    height: calc(100vh - 56px - 3rem);
    min-height: 580px;
    border-radius: var(--r-xl);
    overflow: hidden;
    box-shadow: var(--sh-lg);
    border: 1px solid var(--ai-border);
    background: var(--ai-surface);
    font-family: 'DM Sans', system-ui, sans-serif;
}

/* ── Header ── */
.ai-header {
    grid-column: 1 / -1;
    background: linear-gradient(135deg, var(--ai-ind-900) 0%, var(--ai-ind-700) 60%, var(--ai-teal-400) 100%);
    padding: 14px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
}

.ai-header-left { display: flex; align-items: center; gap: 12px; }

.ai-avatar {
    width: 40px; height: 40px;
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.18);
    border-radius: var(--r-lg);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    animation: pulse-ai 3s ease-out infinite;
}
.ai-avatar svg { width: 22px; height: 22px; color: var(--ai-teal-300); }

.ai-header-title {
    font-family: 'Syne', sans-serif;
    font-size: 1.0625rem; font-weight: 700;
    color: #fff; letter-spacing: -.02em; line-height: 1.2;
}
.ai-header-sub {
    font-size: .7rem; font-weight: 500;
    color: rgba(255,255,255,.5); letter-spacing: .06em;
    text-transform: uppercase; margin-top: 1px;
}

.ai-model-badge {
    display: flex; align-items: center; gap: 5px;
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.14);
    border-radius: var(--r-f);
    padding: 4px 10px;
    font-size: .68rem; font-weight: 600;
    color: rgba(255,255,255,.8);
    backdrop-filter: blur(4px);
    white-space: nowrap;
}
.ai-model-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: var(--ai-green-400);
    box-shadow: 0 0 6px rgba(52,211,153,.6);
    flex-shrink: 0;
}

/* ── Messages area ── */
.ai-messages {
    grid-column: 1;
    overflow-y: auto;
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 16px;
    background: var(--ai-n-100);
    scrollbar-width: thin;
    scrollbar-color: var(--ai-n-200) transparent;
}
.ai-messages::-webkit-scrollbar { width: 4px; }
.ai-messages::-webkit-scrollbar-thumb { background: var(--ai-n-200); border-radius: 4px; }

/* Welcome */
.ai-welcome {
    text-align: center;
    padding: 32px 20px;
    animation: fadeUp .4s ease both;
}
.ai-welcome-icon {
    width: 56px; height: 56px;
    background: linear-gradient(135deg, var(--ai-ind-600), var(--ai-teal-400));
    border-radius: var(--r-xl);
    display: inline-flex; align-items: center; justify-content: center;
    margin-bottom: 14px;
    box-shadow: 0 8px 24px rgba(10,175,162,.3);
}
.ai-welcome-icon svg { width: 28px; height: 28px; color: #fff; }
.ai-welcome h3 {
    font-family: 'Syne', sans-serif;
    font-size: 1.125rem; font-weight: 700;
    color: var(--ai-ind-800); margin-bottom: 6px;
}
.ai-welcome p { font-size: .8125rem; color: var(--ai-n-500); line-height: 1.5; max-width: 320px; margin: 0 auto; }

.ai-suggestions {
    display: flex; flex-wrap: wrap; gap: 6px;
    justify-content: center; margin-top: 16px;
}
.ai-sug {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 6px 12px;
    background: var(--ai-surface); border: 1.5px solid var(--ai-border);
    border-radius: var(--r-f);
    font-size: .75rem; font-weight: 500; color: var(--ai-ind-600);
    cursor: pointer; transition: all .14s;
}
.ai-sug:hover { background: var(--ai-ind-50); border-color: var(--ai-ind-400); transform: translateY(-1px); }
.ai-sug svg { width: 12px; height: 12px; flex-shrink: 0; }

/* Message bubbles */
.ai-msg { display: flex; gap: 10px; animation: msgIn .25s ease both; }

.ai-msg.user  { flex-direction: row-reverse; }
.ai-msg.user .ai-msg-bubble {
    background: linear-gradient(135deg, var(--ai-ind-600), var(--ai-ind-700));
    color: #fff;
    border-radius: var(--r-lg) var(--r-lg) 4px var(--r-lg);
}
.ai-msg.user .ai-msg-time { color: rgba(255,255,255,.55); }

.ai-msg-icon {
    width: 32px; height: 32px; flex-shrink: 0;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    align-self: flex-end;
}
.ai-msg.assistant .ai-msg-icon {
    background: linear-gradient(135deg, var(--ai-ind-600), var(--ai-teal-400));
    box-shadow: 0 2px 8px rgba(10,175,162,.25);
}
.ai-msg.assistant .ai-msg-icon svg { width: 16px; height: 16px; color: #fff; }
.ai-msg.user .ai-msg-icon { background: var(--ai-ind-100); }
.ai-msg.user .ai-msg-icon svg { width: 16px; height: 16px; color: var(--ai-ind-600); }

.ai-msg-bubble {
    max-width: 72%;
    background: var(--ai-surface);
    border: 1px solid var(--ai-border);
    border-radius: var(--r-lg) var(--r-lg) var(--r-lg) 4px;
    padding: 10px 14px;
    box-shadow: var(--sh);
    line-height: 1.6;
    font-size: .875rem;
    color: var(--ai-n-800);
}
.ai-msg-bubble p { margin-bottom: 6px; }
.ai-msg-bubble p:last-child { margin-bottom: 0; }
.ai-msg-bubble ul, .ai-msg-bubble ol { padding-left: 18px; margin: 6px 0; }
.ai-msg-bubble li { margin-bottom: 3px; }
.ai-msg-bubble strong { font-weight: 600; }
.ai-msg-bubble code { font-family: 'DM Mono', monospace; font-size: .8em; background: rgba(0,0,0,.05); padding: 1px 5px; border-radius: 4px; }

.ai-msg-time { font-size: .6rem; color: var(--ai-n-400); margin-top: 4px; font-family: 'DM Mono', monospace; }

/* Typing indicator */
.ai-typing .ai-msg-bubble {
    display: flex; align-items: center; gap: 4px; padding: 12px 16px;
}
.ai-typing-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: var(--ai-teal-400);
    animation: blink 1.2s ease infinite;
}
.ai-typing-dot:nth-child(2) { animation-delay: .2s; }
.ai-typing-dot:nth-child(3) { animation-delay: .4s; }

/* ── Documents panel ── */
.ai-docs-panel {
    grid-column: 2;
    grid-row: 2;
    border-left: 1px solid var(--ai-border);
    display: flex; flex-direction: column;
    background: var(--ai-surface);
    overflow: hidden;
}

.ai-docs-header {
    padding: 14px 16px 12px;
    border-bottom: 1px solid var(--ai-border);
    display: flex; align-items: center; justify-content: space-between;
    flex-shrink: 0;
}
.ai-docs-title {
    font-family: 'Syne', sans-serif;
    font-size: .8125rem; font-weight: 700;
    color: var(--ai-ind-800);
    display: flex; align-items: center; gap: 7px;
}
.ai-docs-title svg { width: 14px; height: 14px; color: var(--ai-teal-400); }
.ai-docs-count {
    font-size: .6rem; font-weight: 600;
    color: var(--ai-n-500);
    background: var(--ai-n-100); border: 1px solid var(--ai-border);
    padding: 1px 7px; border-radius: var(--r-f);
    font-family: 'DM Mono', monospace;
}

.ai-docs-list {
    flex: 1; overflow-y: auto; padding: 8px;
    scrollbar-width: thin; scrollbar-color: var(--ai-n-200) transparent;
}
.ai-docs-list::-webkit-scrollbar { width: 3px; }

.ai-doc-item {
    display: flex; align-items: center; gap: 9px;
    padding: 8px 10px; border-radius: var(--r);
    border: 1px solid var(--ai-border);
    margin-bottom: 6px;
    background: var(--ai-n-100);
    transition: background .12s;
}
.ai-doc-item:hover { background: var(--ai-ind-50); border-color: var(--ai-ind-100); }
.ai-doc-icon {
    width: 28px; height: 28px;
    background: #fff; border: 1px solid var(--ai-border);
    border-radius: var(--r);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.ai-doc-icon svg { width: 13px; height: 13px; color: var(--ai-rose-400); }
.ai-doc-info { flex: 1; min-width: 0; }
.ai-doc-name { font-size: .75rem; font-weight: 600; color: var(--ai-n-800); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.ai-doc-size { font-size: .6rem; color: var(--ai-n-400); font-family: 'DM Mono', monospace; margin-top: 1px; }
.ai-doc-del {
    width: 24px; height: 24px; border-radius: var(--r);
    border: none; background: transparent; cursor: pointer;
    color: var(--ai-n-400); display: flex; align-items: center; justify-content: center;
    transition: all .13s; flex-shrink: 0; padding: 0;
}
.ai-doc-del:hover { background: #FFE4E6; color: var(--ai-rose-400); }
.ai-doc-del svg { width: 12px; height: 12px; }

.ai-docs-empty { padding: 20px; text-align: center; color: var(--ai-n-400); font-size: .78rem; }
.ai-docs-empty svg { width: 32px; height: 32px; opacity: .3; margin-bottom: 8px; }

/* Upload form */
.ai-upload-form {
    border-top: 1px solid var(--ai-border);
    padding: 12px;
    flex-shrink: 0;
}
.ai-upload-label { font-size: .7rem; font-weight: 700; color: var(--ai-n-500); text-transform: uppercase; letter-spacing: .08em; margin-bottom: 8px; display: block; }

.ai-input-sm {
    width: 100%;
    padding: 7px 10px;
    border: 1.5px solid var(--ai-border);
    border-radius: var(--r);
    font-size: .8125rem;
    font-family: inherit;
    color: var(--ai-n-800);
    background: #fff;
    outline: none;
    transition: border-color .14s;
    margin-bottom: 6px;
}
.ai-input-sm:focus { border-color: var(--ai-ind-400); }

.ai-file-drop {
    width: 100%;
    border: 2px dashed var(--ai-border);
    border-radius: var(--r);
    padding: 10px;
    text-align: center;
    cursor: pointer;
    transition: all .14s;
    margin-bottom: 8px;
    background: var(--ai-n-100);
    position: relative;
}
.ai-file-drop:hover { border-color: var(--ai-ind-400); background: var(--ai-ind-50); }
.ai-file-drop input { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
.ai-file-drop-text { font-size: .72rem; color: var(--ai-n-500); pointer-events: none; }
.ai-file-drop-text svg { width: 16px; height: 16px; display: block; margin: 0 auto 4px; opacity: .5; }

.ai-btn-upload {
    width: 100%;
    padding: 8px;
    background: var(--ai-ind-600);
    color: #fff;
    border: none; border-radius: var(--r);
    font-size: .8125rem; font-weight: 600;
    cursor: pointer; font-family: inherit;
    transition: background .14s, transform .14s;
    display: flex; align-items: center; justify-content: center; gap: 6px;
}
.ai-btn-upload:hover { background: var(--ai-ind-700); transform: translateY(-1px); }
.ai-btn-upload svg { width: 13px; height: 13px; }
.ai-btn-upload:disabled { opacity: .6; cursor: not-allowed; transform: none; }

/* ── Footer / input ── */
.ai-footer {
    grid-column: 1 / 2;
    border-top: 1px solid var(--ai-border);
    padding: 12px 16px;
    background: var(--ai-surface);
    display: flex; flex-direction: column; gap: 10px;
}

.ai-quick-chips { display: flex; gap: 6px; flex-wrap: wrap; }
.ai-chip {
    padding: 4px 10px;
    background: var(--ai-n-100); border: 1.5px solid var(--ai-border);
    border-radius: var(--r-f);
    font-size: .72rem; font-weight: 500; color: var(--ai-n-500);
    cursor: pointer; transition: all .13s; white-space: nowrap;
}
.ai-chip:hover { background: var(--ai-teal-50); border-color: var(--ai-teal-400); color: var(--ai-teal-400); }

.ai-input-row { display: flex; gap: 8px; }

.ai-textarea {
    flex: 1;
    padding: 10px 14px;
    border: 1.5px solid var(--ai-border);
    border-radius: var(--r-lg);
    font-size: .875rem; font-family: inherit;
    color: var(--ai-n-800);
    background: var(--ai-n-100);
    outline: none; resize: none;
    transition: border-color .14s, background .14s;
    line-height: 1.5;
    min-height: 44px; max-height: 120px;
}
.ai-textarea:focus { border-color: var(--ai-ind-400); background: #fff; }
.ai-textarea::placeholder { color: var(--ai-n-400); }

.ai-send-btn {
    width: 44px; height: 44px;
    background: linear-gradient(135deg, var(--ai-ind-600), var(--ai-teal-400));
    border: none; border-radius: var(--r-lg);
    color: #fff; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    transition: opacity .14s, transform .14s;
    box-shadow: 0 4px 12px rgba(37,53,168,.3);
}
.ai-send-btn:hover { opacity: .9; transform: translateY(-1px); }
.ai-send-btn:disabled { opacity: .5; cursor: not-allowed; transform: none; }
.ai-send-btn svg { width: 18px; height: 18px; }
.ai-send-btn .spinner { animation: spin .8s linear infinite; }

/* ── No-docs panel (employee, no management) ── */
.ai-docs-panel.no-manage .ai-upload-form { display: none; }

/* ── Flash messages ── */
.ai-flash { padding: 10px 14px; border-radius: var(--r); font-size: .8125rem; font-weight: 500; margin-bottom: 12px; }
.ai-flash.success { background: #D1FAE5; color: #065F46; border: 1px solid #A7F3D0; }
.ai-flash.error   { background: #FFE4E6; color: #9F1239; border: 1px solid #FECDD3; }

/* ── Responsive ── */
@media (max-width: 900px) {
    .ai-wrap { grid-template-columns: 1fr; grid-template-rows: auto 1fr auto auto; }
    .ai-docs-panel { grid-column: 1; grid-row: 4; border-left: none; border-top: 1px solid var(--ai-border); max-height: 280px; }
    .ai-footer { grid-column: 1; }
}
</style>

@if(session('success'))
<div class="ai-flash success">{{ session('success') }}</div>
@endif
@if($errors->any())
<div class="ai-flash error">{{ $errors->first() }}</div>
@endif

<div class="ai-wrap">

    {{-- ── Header ── --}}
    <div class="ai-header">
        <div class="ai-header-left">
            <div class="ai-avatar">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2a2 2 0 0 1 2 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 0 1 7 7h1a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v1a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-1H2a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h1a7 7 0 0 1 7-7h1V5.73c-.6-.34-1-.99-1-1.73a2 2 0 0 1 2-2z"/>
                    <circle cx="9" cy="13" r="1" fill="currentColor"/><circle cx="15" cy="13" r="1" fill="currentColor"/>
                </svg>
            </div>
            <div>
                <div class="ai-header-title">Assistant RH IA</div>
                <div class="ai-header-sub">Basé sur vos documents officiels</div>
            </div>
        </div>
        <div class="ai-model-badge">
            <span class="ai-model-dot"></span>
            Gemini 2.0 Flash · Gratuit
        </div>
    </div>

    {{-- ── Messages ── --}}
    <div class="ai-messages" id="aiMessages">
        <div class="ai-welcome">
            <div class="ai-welcome-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
            </div>
            <h3>Bonjour, je suis votre assistant RH</h3>
            <p>Je peux répondre à vos questions en me basant sur
                @if($docs->isNotEmpty())
                    <strong>{{ $docs->count() }} document(s)</strong> chargé(s).
                @else
                    les documents disponibles. <em>Aucun document chargé pour l'instant.</em>
                @endif
            </p>
            <div class="ai-suggestions">
                <button class="ai-sug" onclick="suggest(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Durée du préavis
                </button>
                <button class="ai-sug" onclick="suggest(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Jours de congés annuels
                </button>
                <button class="ai-sug" onclick="suggest(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Mutuelle et prévoyance
                </button>
                <button class="ai-sug" onclick="suggest(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    Heures supplémentaires
                </button>
                <button class="ai-sug" onclick="suggest(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    Grille salariale
                </button>
            </div>
        </div>
    </div>

    {{-- ── Footer / Input ── --}}
    <div class="ai-footer">
        <div class="ai-quick-chips" id="quickChips">
            <span class="ai-chip" onclick="suggest(this)">Congé maladie</span>
            <span class="ai-chip" onclick="suggest(this)">Prime d'ancienneté</span>
            <span class="ai-chip" onclick="suggest(this)">Période d'essai</span>
            <span class="ai-chip" onclick="suggest(this)">Télétravail</span>
        </div>
        <div class="ai-input-row">
            <textarea class="ai-textarea" id="aiInput" placeholder="Posez votre question…" rows="1" onkeydown="handleKey(event)"></textarea>
            <button class="ai-send-btn" id="aiSendBtn" onclick="sendMessage()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- ── Documents panel ── --}}
    <div class="ai-docs-panel {{ $canManage ? '' : 'no-manage' }}">
        <div class="ai-docs-header">
            <span class="ai-docs-title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Documents
            </span>
            <span class="ai-docs-count">{{ $docs->count() }}</span>
        </div>

        <div class="ai-docs-list">
            @forelse($docs as $doc)
            <div class="ai-doc-item">
                <div class="ai-doc-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <div class="ai-doc-info">
                    <div class="ai-doc-name" title="{{ $doc->nom }}">{{ $doc->nom }}</div>
                    <div class="ai-doc-size">{{ $doc->tailleFormatee() }}</div>
                </div>
                @if($canManage)
                <form method="POST" action="{{ route('admin.assistant.documents.destroy', $doc) }}" onsubmit="return confirm('Supprimer ce document ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="ai-doc-del" title="Supprimer">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                    </button>
                </form>
                @endif
            </div>
            @empty
            <div class="ai-docs-empty">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" display="block" style="margin:0 auto 8px"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Aucun document chargé
            </div>
            @endforelse
        </div>

        @if($canManage)
        <div class="ai-upload-form">
            <span class="ai-upload-label">Ajouter un document</span>
            <form method="POST" action="{{ route('admin.assistant.documents.upload') }}" enctype="multipart/form-data" id="uploadForm">
                @csrf
                <input type="text" class="ai-input-sm" name="nom" placeholder="Nom du document" required>
                <div class="ai-file-drop" id="fileDrop">
                    <input type="file" name="pdf" accept=".pdf" onchange="updateDropLabel(this)" required>
                    <div class="ai-file-drop-text">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        <span id="dropLabel">Glisser un PDF ou cliquer</span>
                    </div>
                </div>
                <button type="submit" class="ai-btn-upload" id="uploadBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    Téléverser
                </button>
            </form>
        </div>
        @endif
    </div>

</div>

<script>
(function () {
    'use strict';

    var history = [];
    var input   = document.getElementById('aiInput');
    var sendBtn = document.getElementById('aiSendBtn');
    var msgs    = document.getElementById('aiMessages');

    /* ── Auto-resize textarea ── */
    input.addEventListener('input', function () {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });

    /* ── Send on Enter (Shift+Enter = newline) ── */
    window.handleKey = function (e) {
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
    };

    /* ── Quick suggestions ── */
    window.suggest = function (el) {
        input.value = el.textContent.trim();
        input.focus();
        sendMessage();
    };

    /* ── Format markdown-lite ── */
    function formatText(text) {
        return text
            .replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')
            .replace(/\*\*(.+?)\*\*/g,'<strong>$1</strong>')
            .replace(/\*(.+?)\*/g,'<em>$1</em>')
            .replace(/`(.+?)`/g,'<code>$1</code>')
            .replace(/^### (.+)$/gm,'<strong>$1</strong>')
            .replace(/^## (.+)$/gm,'<strong>$1</strong>')
            .replace(/^# (.+)$/gm,'<strong>$1</strong>')
            .replace(/^[\*\-] (.+)$/gm,'• $1')
            .replace(/^\d+\. (.+)$/gm,'→ $1')
            .replace(/\n/g,'<br>');
    }

    function addMsg(role, text) {
        var welcome = msgs.querySelector('.ai-welcome');
        if (welcome) welcome.remove();

        var time = new Date().toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
        var div  = document.createElement('div');
        div.className = 'ai-msg ' + role;

        var iconSvg = role === 'assistant'
            ? '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 2a2 2 0 0 1 2 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 0 1 7 7h1a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v1a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-1H2a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h1a7 7 0 0 1 7-7h1V5.73c-.6-.34-1-.99-1-1.73a2 2 0 0 1 2-2z"/></svg>'
            : '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>';

        div.innerHTML = '<div class="ai-msg-icon">' + iconSvg + '</div>'
            + '<div><div class="ai-msg-bubble">' + formatText(text) + '</div>'
            + '<div class="ai-msg-time">' + time + '</div></div>';

        msgs.appendChild(div);
        msgs.scrollTop = msgs.scrollHeight;
        return div;
    }

    function addTyping() {
        var div = document.createElement('div');
        div.className = 'ai-msg assistant ai-typing';
        div.innerHTML = '<div class="ai-msg-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 2a2 2 0 0 1 2 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 0 1 7 7h1a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v1a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-1H2a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h1a7 7 0 0 1 7-7h1V5.73c-.6-.34-1-.99-1-1.73a2 2 0 0 1 2-2z"/></svg></div>'
            + '<div class="ai-msg-bubble"><span class="ai-typing-dot"></span><span class="ai-typing-dot"></span><span class="ai-typing-dot"></span></div>';
        msgs.appendChild(div);
        msgs.scrollTop = msgs.scrollHeight;
        return div;
    }

    window.sendMessage = function () {
        var q = input.value.trim();
        if (!q || sendBtn.disabled) return;

        addMsg('user', q);
        input.value = '';
        input.style.height = 'auto';
        sendBtn.disabled = true;
        sendBtn.innerHTML = '<svg class="spinner" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="2" x2="12" y2="6"/><line x1="12" y1="18" x2="12" y2="22"/><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"/><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"/><line x1="2" y1="12" x2="6" y2="12"/><line x1="18" y1="12" x2="22" y2="12"/><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"/><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"/></svg>';

        var typing = addTyping();

        // Keep last 6 messages in history
        history.push({ role: 'user', content: q });
        if (history.length > 12) history = history.slice(-12);

        fetch('{{ route("admin.assistant.chat") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ question: q, history: history.slice(0, -1) }),
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            typing.remove();
            var answer = data.answer || 'Désolé, je n\'ai pas pu répondre.';
            addMsg('assistant', answer);
            history.push({ role: 'model', content: answer });
            if (history.length > 12) history = history.slice(-12);
        })
        .catch(function() {
            typing.remove();
            addMsg('assistant', 'Une erreur réseau s\'est produite. Veuillez réessayer.');
        })
        .finally(function() {
            sendBtn.disabled = false;
            sendBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>';
            input.focus();
        });
    };

    /* ── Upload form ── */
    window.updateDropLabel = function (input) {
        var lbl = document.getElementById('dropLabel');
        if (lbl && input.files[0]) lbl.textContent = input.files[0].name;
    };

    var uploadForm = document.getElementById('uploadForm');
    if (uploadForm) {
        uploadForm.addEventListener('submit', function() {
            var btn = document.getElementById('uploadBtn');
            if (btn) { btn.disabled = true; btn.textContent = 'Envoi en cours…'; }
        });
    }

    input.focus();
})();
</script>
@endsection
