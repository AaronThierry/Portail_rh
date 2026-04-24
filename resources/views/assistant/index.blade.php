@extends('layouts.app')

@section('title', 'Assistant RH IA')

@section('content')
<style>
/* ═══════════════════════════════════════════════════════════
   ASSISTANT RH IA  —  Design Pro
   ═══════════════════════════════════════════════════════════ */
:root {
    --c-bg:      #F0F2F7;
    --c-surface: #FFFFFF;
    --c-border:  #E4E7EE;
    --c-ind-50:  #EEEFFE;
    --c-ind-100: #D5D9FB;
    --c-ind-200: #B0BAEC;
    --c-ind-500: #3748C8;
    --c-ind-600: #2535A8;
    --c-ind-700: #1A2785;
    --c-ind-800: #111C62;
    --c-ind-900: #0A1040;
    --c-teal-300:#2ECABB;
    --c-teal-400:#0AAFA2;
    --c-teal-50: #E5FAF8;
    --c-teal-100:#B0EFE9;
    --c-n-100:   #F3F5F8;
    --c-n-200:   #E4E7EE;
    --c-n-300:   #C8CDD8;
    --c-n-400:   #9CA4B2;
    --c-n-500:   #6B7382;
    --c-n-600:   #4B5363;
    --c-n-800:   #1E2330;
    --c-rose-400:#FB7185;
    --c-green-400:#34D399;
    --c-amber-400:#F59E0B;
    --sh-sm: 0 1px 4px rgba(10,16,64,.07);
    --sh:    0 2px 10px rgba(10,16,64,.09);
    --sh-md: 0 4px 20px rgba(10,16,64,.11);
    --sh-lg: 0 12px 40px rgba(10,16,64,.13);
    --r: 8px; --r-lg: 12px; --r-xl: 18px; --r-2xl: 24px; --r-f: 9999px;
    --font:  'DM Sans', system-ui, sans-serif;
    --font-d:'Syne', 'DM Sans', system-ui, sans-serif;
    --font-m:'DM Mono', monospace;
}

@keyframes fadeUp  { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:translateY(0)} }
@keyframes msgIn   { from{opacity:0;transform:translateY(6px)} to{opacity:1;transform:translateY(0)} }
@keyframes spin    { to{transform:rotate(360deg)} }
@keyframes blink3  { 0%,80%,100%{opacity:0} 40%{opacity:1} }
@keyframes gradAni { 0%,100%{background-position:0% 50%} 50%{background-position:100% 50%} }
@keyframes pulseDot{ 0%,100%{box-shadow:0 0 0 0 rgba(52,211,153,.5)} 50%{box-shadow:0 0 0 7px rgba(52,211,153,0)} }

*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}

/* ── Root container ── */
.ast {
    display: flex;
    height: calc(100vh - var(--header-h, 56px) - 3rem);
    min-height: 560px;
    border-radius: var(--r-xl);
    overflow: hidden;
    box-shadow: var(--sh-lg);
    border: 1px solid var(--c-border);
    font-family: var(--font);
    background: var(--c-surface);
    animation: fadeUp .35s ease both;
}

/* ══════════════════════════════════════
   LEFT PANEL — Document manager
══════════════════════════════════════ */
.ast-left {
    width: 272px;
    flex-shrink: 0;
    background: linear-gradient(180deg, var(--c-ind-900) 0%, #0E1550 100%);
    display: flex;
    flex-direction: column;
    border-right: 1px solid rgba(255,255,255,.05);
    overflow: hidden;
}

/* Brand */
.ast-brand {
    padding: 18px 16px 14px;
    border-bottom: 1px solid rgba(255,255,255,.06);
    flex-shrink: 0;
}
.ast-brand-row {
    display: flex; align-items: center; gap: 10px; margin-bottom: 12px;
}
.ast-brand-mark {
    width: 36px; height: 36px;
    background: linear-gradient(135deg, var(--c-ind-600) 0%, var(--c-teal-400) 100%);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 4px 14px rgba(10,175,162,.35);
}
.ast-brand-mark svg { width: 19px; height: 19px; color: #fff; }
.ast-brand-name {
    font-family: var(--font-d);
    font-size: .9375rem; font-weight: 700;
    color: #fff; letter-spacing: -.02em; line-height: 1.1;
}
.ast-brand-sub {
    font-size: .62rem; font-weight: 600; letter-spacing: .1em;
    text-transform: uppercase; color: rgba(255,255,255,.38);
    margin-top: 1px;
}

/* Status pill */
.ast-status {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(255,255,255,.09);
    border-radius: var(--r-f);
    padding: 4px 10px;
    font-size: .68rem; font-weight: 600;
    color: rgba(255,255,255,.6);
}
.ast-status-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: var(--c-green-400);
    animation: pulseDot 2.5s ease infinite;
    flex-shrink: 0;
}

/* Docs list */
.ast-docs-head {
    padding: 14px 16px 8px;
    font-size: .6rem; font-weight: 700; letter-spacing: .12em;
    text-transform: uppercase; color: rgba(255,255,255,.28);
    flex-shrink: 0;
    display: flex; align-items: center; justify-content: space-between;
}
.ast-docs-count {
    background: rgba(255,255,255,.08);
    border: 1px solid rgba(255,255,255,.1);
    border-radius: var(--r-f);
    padding: 1px 7px;
    font-size: .6rem; color: rgba(255,255,255,.45);
    font-family: var(--font-m);
}

.ast-docs-list {
    flex: 1; overflow-y: auto; padding: 0 8px 8px;
    scrollbar-width: thin; scrollbar-color: rgba(255,255,255,.08) transparent;
}
.ast-docs-list::-webkit-scrollbar { width: 3px; }
.ast-docs-list::-webkit-scrollbar-thumb { background: rgba(255,255,255,.1); border-radius: 4px; }

.ast-doc-item {
    display: flex; align-items: center; gap: 9px;
    padding: 8px 10px; border-radius: var(--r);
    margin-bottom: 4px;
    transition: background .13s;
    cursor: default;
    position: relative;
}
.ast-doc-item:hover { background: rgba(255,255,255,.06); }
.ast-doc-ico {
    width: 30px; height: 30px; flex-shrink: 0;
    background: rgba(255,255,255,.07);
    border: 1px solid rgba(255,255,255,.1);
    border-radius: var(--r);
    display: flex; align-items: center; justify-content: center;
}
.ast-doc-ico svg { width: 14px; height: 14px; color: var(--c-rose-400); }
.ast-doc-info { flex: 1; min-width: 0; }
.ast-doc-name { font-size: .78rem; font-weight: 600; color: rgba(255,255,255,.85); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.ast-doc-size { font-size: .6rem; color: rgba(255,255,255,.35); font-family: var(--font-m); margin-top: 1px; }
.ast-doc-del {
    width: 22px; height: 22px; border-radius: 6px;
    border: none; background: transparent; cursor: pointer;
    color: rgba(255,255,255,.25);
    display: flex; align-items: center; justify-content: center;
    transition: all .12s; flex-shrink: 0; padding: 0;
    opacity: 0;
}
.ast-doc-item:hover .ast-doc-del { opacity: 1; }
.ast-doc-del:hover { background: rgba(251,113,133,.18); color: var(--c-rose-400); }
.ast-doc-del svg { width: 11px; height: 11px; }

.ast-docs-empty {
    padding: 24px 16px; text-align: center;
    color: rgba(255,255,255,.25); font-size: .78rem;
}
.ast-docs-empty svg { width: 36px; height: 36px; opacity: .18; display: block; margin: 0 auto 10px; }

/* Upload form */
.ast-upload {
    border-top: 1px solid rgba(255,255,255,.06);
    padding: 12px 12px 16px;
    flex-shrink: 0;
}
.ast-upload-title {
    font-size: .6rem; font-weight: 700; letter-spacing: .1em;
    text-transform: uppercase; color: rgba(255,255,255,.28);
    margin-bottom: 10px;
}
.ast-inp {
    width: 100%;
    padding: 8px 10px;
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(255,255,255,.1);
    border-radius: var(--r);
    font-size: .8125rem; font-family: var(--font);
    color: rgba(255,255,255,.9);
    outline: none;
    transition: border-color .14s, background .14s;
    margin-bottom: 6px;
}
.ast-inp::placeholder { color: rgba(255,255,255,.28); }
.ast-inp:focus { border-color: var(--c-teal-400); background: rgba(255,255,255,.09); }

.ast-drop {
    width: 100%; border: 1.5px dashed rgba(255,255,255,.14);
    border-radius: var(--r); padding: 10px;
    text-align: center; cursor: pointer;
    transition: all .14s; margin-bottom: 8px;
    background: rgba(255,255,255,.03);
    position: relative;
}
.ast-drop:hover { border-color: var(--c-teal-400); background: rgba(10,175,162,.06); }
.ast-drop input { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
.ast-drop-lbl { font-size: .72rem; color: rgba(255,255,255,.35); pointer-events: none; }
.ast-drop-lbl svg { width: 16px; height: 16px; display: block; margin: 0 auto 4px; opacity: .5; }

.ast-upload-btn {
    width: 100%; padding: 9px;
    background: linear-gradient(135deg, var(--c-ind-600), var(--c-teal-400));
    color: #fff; border: none; border-radius: var(--r);
    font-size: .8125rem; font-weight: 600; font-family: var(--font);
    cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 6px;
    transition: opacity .14s, transform .14s;
    box-shadow: 0 4px 14px rgba(10,175,162,.3);
}
.ast-upload-btn:hover { opacity: .9; transform: translateY(-1px); }
.ast-upload-btn:disabled { opacity: .5; cursor: not-allowed; transform: none; }
.ast-upload-btn svg { width: 13px; height: 13px; }

/* ══════════════════════════════════════
   RIGHT PANEL — Chat
══════════════════════════════════════ */
.ast-right {
    flex: 1; min-width: 0;
    display: flex; flex-direction: column;
    background: var(--c-n-100);
}

/* Chat header */
.ast-chat-head {
    background: var(--c-surface);
    border-bottom: 1px solid var(--c-border);
    padding: 12px 20px;
    display: flex; align-items: center; justify-content: space-between;
    flex-shrink: 0;
    box-shadow: var(--sh-sm);
}
.ast-chat-head-info { display: flex; align-items: center; gap: 10px; }
.ast-chat-head-avatar {
    width: 34px; height: 34px; border-radius: 50%;
    background: linear-gradient(135deg, var(--c-ind-600), var(--c-teal-400));
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 2px 8px rgba(10,175,162,.3);
    flex-shrink: 0;
}
.ast-chat-head-avatar svg { width: 17px; height: 17px; color: #fff; }
.ast-chat-head-name {
    font-family: var(--font-d);
    font-size: .9375rem; font-weight: 700;
    color: var(--c-ind-800); letter-spacing: -.02em;
}
.ast-chat-head-docs { font-size: .72rem; color: var(--c-n-400); margin-top: 1px; }

.ast-model-tag {
    display: flex; align-items: center; gap: 5px;
    background: var(--c-teal-50); border: 1px solid var(--c-teal-100);
    border-radius: var(--r-f); padding: 4px 10px;
    font-size: .68rem; font-weight: 600; color: var(--c-teal-400);
}
.ast-model-tag svg { width: 11px; height: 11px; }

/* Messages */
.ast-msgs {
    flex: 1; overflow-y: auto;
    padding: 24px 24px 16px;
    display: flex; flex-direction: column; gap: 20px;
    scrollbar-width: thin; scrollbar-color: var(--c-n-200) transparent;
}
.ast-msgs::-webkit-scrollbar { width: 4px; }
.ast-msgs::-webkit-scrollbar-thumb { background: var(--c-n-200); border-radius: 4px; }

/* Welcome state */
.ast-welcome {
    flex: 1; display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    padding: 32px 24px; text-align: center;
    animation: fadeUp .4s ease both;
    gap: 0;
}
.ast-welcome-glyph {
    width: 72px; height: 72px;
    background: linear-gradient(135deg, var(--c-ind-600) 0%, var(--c-teal-400) 100%);
    border-radius: 20px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 20px;
    box-shadow: 0 12px 32px rgba(10,175,162,.28);
}
.ast-welcome-glyph svg { width: 36px; height: 36px; color: #fff; }
.ast-welcome h2 {
    font-family: var(--font-d);
    font-size: 1.375rem; font-weight: 800;
    color: var(--c-ind-800); letter-spacing: -.03em;
    margin-bottom: 8px;
}
.ast-welcome p {
    font-size: .875rem; color: var(--c-n-500);
    line-height: 1.6; max-width: 340px; margin-bottom: 28px;
}

.ast-sug-grid {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 8px; width: 100%; max-width: 480px;
}
.ast-sug-card {
    background: var(--c-surface);
    border: 1.5px solid var(--c-border);
    border-radius: var(--r-lg);
    padding: 12px 14px;
    text-align: left; cursor: pointer;
    transition: all .15s;
    display: flex; flex-direction: column; gap: 4px;
}
.ast-sug-card:hover {
    border-color: var(--c-ind-200);
    background: var(--c-ind-50);
    transform: translateY(-2px);
    box-shadow: var(--sh);
}
.ast-sug-card-icon {
    width: 28px; height: 28px; border-radius: var(--r);
    background: var(--c-n-100); display: flex; align-items: center; justify-content: center;
    margin-bottom: 4px; transition: background .15s;
}
.ast-sug-card-icon svg { width: 14px; height: 14px; color: var(--c-ind-500); }
.ast-sug-card:hover .ast-sug-card-icon { background: var(--c-ind-100); }
.ast-sug-label { font-size: .8125rem; font-weight: 600; color: var(--c-n-800); }
.ast-sug-desc  { font-size: .72rem; color: var(--c-n-400); }

/* Message row */
.ast-msg { display: flex; gap: 10px; max-width: 100%; animation: msgIn .22s ease both; }
.ast-msg.user { flex-direction: row-reverse; align-self: flex-end; max-width: 75%; }
.ast-msg.assistant { align-self: flex-start; max-width: 85%; }

.ast-msg-av {
    width: 30px; height: 30px; border-radius: 50%;
    flex-shrink: 0; align-self: flex-end;
    display: flex; align-items: center; justify-content: center;
}
.ast-msg.assistant .ast-msg-av {
    background: linear-gradient(135deg, var(--c-ind-600), var(--c-teal-400));
    box-shadow: 0 2px 8px rgba(10,175,162,.25);
}
.ast-msg.assistant .ast-msg-av svg { width: 15px; height: 15px; color: #fff; }
.ast-msg.user .ast-msg-av { background: var(--c-ind-100); }
.ast-msg.user .ast-msg-av svg { width: 14px; height: 14px; color: var(--c-ind-600); }

.ast-msg-body { display: flex; flex-direction: column; gap: 4px; min-width: 0; }
.ast-msg.user .ast-msg-body { align-items: flex-end; }

.ast-bubble {
    padding: 11px 15px;
    border-radius: var(--r-lg);
    font-size: .875rem; line-height: 1.65;
    position: relative;
}
.ast-msg.assistant .ast-bubble {
    background: var(--c-surface);
    border: 1px solid var(--c-border);
    color: var(--c-n-800);
    border-radius: var(--r-lg) var(--r-lg) var(--r-lg) 4px;
    box-shadow: var(--sh-sm);
}
.ast-msg.user .ast-bubble {
    background: linear-gradient(135deg, var(--c-ind-600), var(--c-ind-700));
    color: #fff;
    border-radius: var(--r-lg) var(--r-lg) 4px var(--r-lg);
    box-shadow: 0 4px 14px rgba(37,53,168,.25);
}

/* Markdown in bubble */
.ast-bubble p { margin-bottom: 6px; }
.ast-bubble p:last-child { margin-bottom: 0; }
.ast-bubble ul,.ast-bubble ol { padding-left: 16px; margin: 6px 0; }
.ast-bubble li { margin-bottom: 3px; }
.ast-bubble strong { font-weight: 700; }
.ast-bubble em { font-style: italic; }
.ast-bubble code {
    font-family: var(--font-m); font-size: .8em;
    background: rgba(0,0,0,.06); padding: 2px 6px; border-radius: 4px;
}
.ast-msg.user .ast-bubble code { background: rgba(255,255,255,.15); }
.ast-bubble h3 { font-weight: 700; margin-bottom: 4px; margin-top: 8px; }

.ast-msg-time {
    font-size: .6rem; color: var(--c-n-300);
    font-family: var(--font-m);
}
.ast-msg.user .ast-msg-time { color: rgba(255,255,255,.4); }

/* Typing */
.ast-typing .ast-bubble {
    display: flex; align-items: center; gap: 4px;
    padding: 14px 16px;
}
.ast-dot {
    width: 7px; height: 7px; border-radius: 50%;
    background: var(--c-teal-400);
    animation: blink3 1.4s ease infinite;
}
.ast-dot:nth-child(2) { animation-delay: .16s; }
.ast-dot:nth-child(3) { animation-delay: .32s; }

/* Source tag */
.ast-source {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: .65rem; font-weight: 600;
    color: var(--c-teal-400);
    background: var(--c-teal-50); border: 1px solid var(--c-teal-100);
    padding: 2px 8px; border-radius: var(--r-f);
    margin-top: 4px;
}
.ast-source svg { width: 10px; height: 10px; }

/* ── Input area ── */
.ast-input-wrap {
    background: var(--c-surface);
    border-top: 1px solid var(--c-border);
    padding: 14px 20px 16px;
    flex-shrink: 0;
}

.ast-chips { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 10px; }
.ast-chip {
    padding: 4px 11px;
    background: var(--c-n-100); border: 1.5px solid var(--c-border);
    border-radius: var(--r-f);
    font-size: .72rem; font-weight: 500; color: var(--c-n-500);
    cursor: pointer; transition: all .13s; white-space: nowrap;
}
.ast-chip:hover { background: var(--c-teal-50); border-color: var(--c-teal-400); color: var(--c-teal-400); }

.ast-input-row {
    display: flex; align-items: flex-end; gap: 8px;
    background: var(--c-n-100);
    border: 1.5px solid var(--c-border);
    border-radius: var(--r-xl);
    padding: 8px 8px 8px 16px;
    transition: border-color .15s, box-shadow .15s;
}
.ast-input-row:focus-within {
    border-color: var(--c-ind-200);
    box-shadow: 0 0 0 3px rgba(55,72,200,.08);
    background: var(--c-surface);
}

.ast-textarea {
    flex: 1; border: none; background: transparent;
    outline: none; resize: none;
    font-size: .9375rem; font-family: var(--font);
    color: var(--c-n-800); line-height: 1.5;
    min-height: 28px; max-height: 120px;
    padding: 2px 0;
}
.ast-textarea::placeholder { color: var(--c-n-300); }

.ast-send {
    width: 38px; height: 38px; flex-shrink: 0;
    border: none; border-radius: var(--r-lg);
    background: linear-gradient(135deg, var(--c-ind-600), var(--c-teal-400));
    color: #fff; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: opacity .14s, transform .14s;
    box-shadow: 0 3px 10px rgba(37,53,168,.28);
}
.ast-send:hover:not(:disabled) { opacity: .9; transform: translateY(-1px); }
.ast-send:disabled { opacity: .45; cursor: not-allowed; transform: none; }
.ast-send svg { width: 16px; height: 16px; }
.ast-send .spin-ico { animation: spin .8s linear infinite; }

.ast-hint {
    text-align: center; font-size: .65rem; color: var(--c-n-300);
    margin-top: 8px; font-family: var(--font-m);
}

/* ── Alert ── */
.ast-alert { padding: 10px 14px; border-radius: var(--r); font-size: .8125rem; font-weight: 500; margin-bottom: 12px; }
.ast-alert.ok  { background: #D1FAE5; color: #065F46; border: 1px solid #A7F3D0; }
.ast-alert.err { background: #FFE4E6; color: #9F1239; border: 1px solid #FECDD3; }

/* ── Responsive ── */
@media (max-width: 860px) {
    .ast { flex-direction: column; height: auto; min-height: unset; }
    .ast-left { width: 100%; max-height: 300px; }
    .ast-right { height: calc(100vh - 360px - var(--header-h,56px)); min-height: 400px; }
}
@media (max-width: 600px) {
    .ast-sug-grid { grid-template-columns: 1fr; }
    .ast-msgs { padding: 16px 14px 10px; }
    .ast-input-wrap { padding: 10px 12px 12px; }
    .ast-msg.user,.ast-msg.assistant { max-width: 95%; }
}
</style>

@if(session('success'))
<div class="ast-alert ok">{{ session('success') }}</div>
@endif
@if($errors->any())
<div class="ast-alert err">{{ $errors->first() }}</div>
@endif

<div class="ast">

    {{-- ══════════ LEFT — Documents ══════════ --}}
    <div class="ast-left">

        <div class="ast-brand">
            <div class="ast-brand-row">
                <div class="ast-brand-mark">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2a2 2 0 0 1 2 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 0 1 7 7h1a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v1a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-1H2a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h1a7 7 0 0 1 7-7h1V5.73c-.6-.34-1-.99-1-1.73a2 2 0 0 1 2-2z"/>
                        <circle cx="9" cy="13" r="1" fill="currentColor"/><circle cx="15" cy="13" r="1" fill="currentColor"/>
                    </svg>
                </div>
                <div>
                    <div class="ast-brand-name">Assistant RH</div>
                    <div class="ast-brand-sub">Portail RH+</div>
                </div>
            </div>
            <div class="ast-status">
                <span class="ast-status-dot"></span>
                Gemini 2.0 Flash · Gratuit
            </div>
        </div>

        <div class="ast-docs-head">
            <span>Base documentaire</span>
            <span class="ast-docs-count">{{ $docs->count() }}</span>
        </div>

        <div class="ast-docs-list">
            @forelse($docs as $doc)
            <div class="ast-doc-item">
                <div class="ast-doc-ico">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <div class="ast-doc-info">
                    <div class="ast-doc-name" title="{{ $doc->nom }}">{{ $doc->nom }}</div>
                    <div class="ast-doc-size">
                        PDF · {{ $doc->tailleFormatee() }}
                        @if(!$doc->contenu_texte)
                            &nbsp;<span style="color:var(--c-amber-400);font-size:.58rem;" title="Extraction de texte non disponible">⚠ non indexé</span>
                        @endif
                    </div>
                </div>
                @if($canManage)
                <form method="POST" action="{{ route('admin.assistant.documents.destroy', $doc) }}" onsubmit="return confirm('Supprimer «{{ $doc->nom }}» ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="ast-doc-del" title="Supprimer">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                    </button>
                </form>
                @endif
            </div>
            @empty
            <div class="ast-docs-empty">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/></svg>
                Aucun document chargé.<br>Ajoutez un PDF ci-dessous.
            </div>
            @endforelse
        </div>

        @if($canManage)
        <div class="ast-upload">
            <div class="ast-upload-title">Ajouter un document</div>
            <form method="POST" action="{{ route('admin.assistant.documents.upload') }}" enctype="multipart/form-data" id="astUploadForm">
                @csrf
                <input type="text" class="ast-inp" name="nom" placeholder="Nom du document…" required>
                <div class="ast-drop" id="astDrop">
                    <input type="file" name="pdf" accept=".pdf" onchange="onFileChange(this)" required>
                    <div class="ast-drop-lbl">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        <span id="astDropLbl">Glisser un PDF ici</span>
                    </div>
                </div>
                <button type="submit" class="ast-upload-btn" id="astUpBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    Téléverser
                </button>
            </form>
        </div>
        @endif

    </div>

    {{-- ══════════ RIGHT — Chat ══════════ --}}
    <div class="ast-right">

        <div class="ast-chat-head">
            <div class="ast-chat-head-info">
                <div class="ast-chat-head-avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <div>
                    <div class="ast-chat-head-name">Assistant RH IA</div>
                    <div class="ast-chat-head-docs">
                        @if($docs->count() > 0)
                            {{ $docs->count() }} document(s) · {{ round($docs->sum('taille') / 1024) }} Ko
                        @else
                            Aucun document chargé
                        @endif
                    </div>
                </div>
            </div>
            <div class="ast-model-tag">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                Gemini 2.0 Flash
            </div>
        </div>

        <div class="ast-msgs" id="astMsgs">
            <div class="ast-welcome" id="astWelcome">
                <div class="ast-welcome-glyph">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2a2 2 0 0 1 2 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 0 1 7 7h1a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v1a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-1H2a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h1a7 7 0 0 1 7-7h1V5.73c-.6-.34-1-.99-1-1.73a2 2 0 0 1 2-2z"/>
                        <circle cx="9" cy="13" r="1" fill="currentColor"/><circle cx="15" cy="13" r="1" fill="currentColor"/>
                    </svg>
                </div>
                <h2>Que puis-je faire pour vous ?</h2>
                <p>Je réponds à toutes vos questions RH en me basant sur vos documents officiels — convention collective, règlement intérieur, fiches de poste…</p>
                <div class="ast-sug-grid">
                    <button class="ast-sug-card" onclick="askSug(this)">
                        <div class="ast-sug-card-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
                        <div class="ast-sug-label">Congés & absences</div>
                        <div class="ast-sug-desc">Droits, procédures, délais</div>
                    </button>
                    <button class="ast-sug-card" onclick="askSug(this)">
                        <div class="ast-sug-card-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
                        <div class="ast-sug-label">Rémunération</div>
                        <div class="ast-sug-desc">Salaires, primes, avantages</div>
                    </button>
                    <button class="ast-sug-card" onclick="askSug(this)">
                        <div class="ast-sug-card-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
                        <div class="ast-sug-label">Droits & obligations</div>
                        <div class="ast-sug-desc">Règlement, sanctions, préavis</div>
                    </button>
                    <button class="ast-sug-card" onclick="askSug(this)">
                        <div class="ast-sug-card-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
                        <div class="ast-sug-label">Conditions de travail</div>
                        <div class="ast-sug-desc">Horaires, télétravail, équipements</div>
                    </button>
                </div>
            </div>
        </div>

        <div class="ast-input-wrap">
            <div class="ast-chips">
                <span class="ast-chip" onclick="chip(this)">Durée du préavis</span>
                <span class="ast-chip" onclick="chip(this)">Congé maladie</span>
                <span class="ast-chip" onclick="chip(this)">Prime d'ancienneté</span>
                <span class="ast-chip" onclick="chip(this)">Heures supplémentaires</span>
                <span class="ast-chip" onclick="chip(this)">Période d'essai</span>
            </div>
            <div class="ast-input-row">
                <textarea class="ast-textarea" id="astInput" placeholder="Posez votre question…" rows="1"
                    onkeydown="onKey(event)" oninput="autoResize(this)"></textarea>
                <button class="ast-send" id="astSend" onclick="send()">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                </button>
            </div>
            <div class="ast-hint">Entrée pour envoyer · Maj+Entrée pour saut de ligne</div>
        </div>

    </div>
</div>

<script>
(function(){
    'use strict';

    var msgs    = document.getElementById('astMsgs');
    var input   = document.getElementById('astInput');
    var sendBtn = document.getElementById('astSend');
    var welcome = document.getElementById('astWelcome');
    var history = [];

    var SEND_ICON = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>';
    var SPIN_ICON = '<svg class="spin-ico" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="2" x2="12" y2="6"/><line x1="12" y1="18" x2="12" y2="22"/><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"/><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"/><line x1="2" y1="12" x2="6" y2="12"/><line x1="18" y1="12" x2="22" y2="12"/><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"/><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"/></svg>';
    var AI_AV    = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M12 2a2 2 0 0 1 2 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 0 1 7 7h1a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v1a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-1H2a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h1a7 7 0 0 1 7-7h1V5.73c-.6-.34-1-.99-1-1.73a2 2 0 0 1 2-2z"/></svg>';
    var USER_AV  = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>';

    function now(){
        return new Date().toLocaleTimeString('fr-FR',{hour:'2-digit',minute:'2-digit'});
    }

    function esc(s){
        return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    }

    function md(text){
        return esc(text)
            .replace(/\*\*(.+?)\*\*/g,'<strong>$1</strong>')
            .replace(/\*(.+?)\*/g,'<em>$1</em>')
            .replace(/`([^`]+)`/g,'<code>$1</code>')
            .replace(/^#{1,3} (.+)$/gm,'<h3>$1</h3>')
            .replace(/^[\*\-•] (.+)$/gm,'<li>$1</li>')
            .replace(/(<li>.*<\/li>)/gs, function(m){ return '<ul>'+m+'</ul>'; })
            .replace(/^\d+\. (.+)$/gm,'<li>$1</li>')
            .replace(/\n\n/g,'</p><p>')
            .replace(/\n/g,'<br>');
    }

    function scrollBottom(){ msgs.scrollTop = msgs.scrollHeight; }

    function addMsg(role, text){
        if(welcome){ welcome.remove(); welcome = null; }
        var t   = now();
        var div = document.createElement('div');
        div.className = 'ast-msg ' + role;
        var av  = role === 'assistant' ? AI_AV : USER_AV;
        var bubble = role === 'assistant'
            ? '<div class="ast-bubble"><p>' + md(text) + '</p></div>'
            : '<div class="ast-bubble">' + esc(text) + '</div>';
        div.innerHTML =
            '<div class="ast-msg-av">' + av + '</div>' +
            '<div class="ast-msg-body">' + bubble +
            '<div class="ast-msg-time">' + t + '</div>' +
            (role === 'assistant' ? '<div class="ast-source"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>Basé sur vos documents</div>' : '') +
            '</div>';
        msgs.appendChild(div);
        scrollBottom();
        return div;
    }

    function addTyping(){
        if(welcome){ welcome.remove(); welcome = null; }
        var div = document.createElement('div');
        div.className = 'ast-msg assistant ast-typing';
        div.innerHTML = '<div class="ast-msg-av">'+AI_AV+'</div>'
            +'<div class="ast-msg-body"><div class="ast-bubble">'
            +'<span class="ast-dot"></span><span class="ast-dot"></span><span class="ast-dot"></span>'
            +'</div></div>';
        msgs.appendChild(div);
        scrollBottom();
        return div;
    }

    window.send = function(){
        var q = input.value.trim();
        if(!q || sendBtn.disabled) return;
        addMsg('user', q);
        input.value = '';
        input.style.height = 'auto';
        sendBtn.disabled = true;
        sendBtn.innerHTML = SPIN_ICON;

        history.push({ role:'user', content: q });
        if(history.length > 14) history = history.slice(-14);

        var typing = addTyping();

        fetch('{{ route("admin.assistant.chat") }}',{
            method:'POST',
            headers:{
                'Content-Type':'application/json',
                'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content,
                'Accept':'application/json'
            },
            body: JSON.stringify({ question: q, history: history.slice(0,-1) })
        })
        .then(function(r){ return r.json(); })
        .then(function(d){
            typing.remove();
            var ans = d.answer || 'Désolé, je n\'ai pas pu répondre.';
            addMsg('assistant', ans);
            history.push({ role:'model', content: ans });
            if(history.length > 14) history = history.slice(-14);
        })
        .catch(function(){
            typing.remove();
            addMsg('assistant', 'Une erreur réseau s\'est produite. Veuillez réessayer.');
        })
        .finally(function(){
            sendBtn.disabled = false;
            sendBtn.innerHTML = SEND_ICON;
            input.focus();
        });
    };

    window.onKey = function(e){
        if(e.key === 'Enter' && !e.shiftKey){ e.preventDefault(); send(); }
    };

    window.autoResize = function(el){
        el.style.height = 'auto';
        el.style.height = Math.min(el.scrollHeight, 120) + 'px';
    };

    window.chip = function(el){
        input.value = el.textContent.trim();
        input.focus();
        send();
    };

    window.askSug = function(el){
        var lbl = el.querySelector('.ast-sug-label');
        if(lbl){ input.value = 'Quelles sont les règles concernant : ' + lbl.textContent.trim() + ' ?'; }
        send();
    };

    window.onFileChange = function(inp){
        var lbl = document.getElementById('astDropLbl');
        if(lbl && inp.files[0]) lbl.textContent = inp.files[0].name;
    };

    var upForm = document.getElementById('astUploadForm');
    if(upForm){
        upForm.addEventListener('submit', function(){
            var btn = document.getElementById('astUpBtn');
            if(btn){ btn.disabled = true; btn.textContent = 'Envoi en cours…'; }
        });
    }

    input.focus();
})();
</script>
@endsection
