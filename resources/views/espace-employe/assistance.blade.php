@extends('layouts.espace-employe')

@section('title', 'Assistance')
@section('page-title', 'Assistance')
@section('breadcrumb')
    <a href="{{ route('espace-employe.dashboard') }}">Accueil</a>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
    <span>Assistance</span>
@endsection

@section('styles')
<style>
/* ================================================
   ASSISTANCE — Indigo × Teal Charter
   ================================================ */
.ast-page {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
    width: 100%;
    min-width: 0;
    animation: ast-in .5s cubic-bezier(.16,1,.3,1);
}
@keyframes ast-in { from { opacity:0; transform:translateY(10px); } to { opacity:1; } }

/* ── TOAST ── */
.ast-toast {
    position: fixed; top: 1.25rem; right: 1.25rem; z-index: 9000;
    display: flex; align-items: center; gap: .75rem;
    padding: .875rem 1.125rem;
    background: var(--surface); border-radius: var(--r-lg);
    box-shadow: var(--shadow-xl); border: 1px solid var(--border);
    max-width: 360px; overflow: hidden;
    animation: tIn .5s cubic-bezier(.16,1,.3,1);
}
@keyframes tIn  { from { opacity:0; transform:translateX(120px); } to { opacity:1; } }
@keyframes tOut { to   { opacity:0; transform:translateX(120px); } }
.ast-toast.out { animation: tOut .3s ease-in forwards; }
.ast-toast-bar { position:absolute; bottom:0; left:0; height:3px; background:var(--teal-500); animation: tdot 5s linear forwards; }
@keyframes tdot { from{width:100%;} to{width:0%;} }
.ast-toast-ico { width:34px; height:34px; border-radius:var(--r-md); display:flex; align-items:center; justify-content:center; flex-shrink:0; background:var(--teal-50); color:var(--teal-700); }
.ast-toast-ico svg { width:16px; height:16px; }
.ast-toast-body { flex:1; }
.ast-toast-title { font-size:.8rem; font-weight:700; color:var(--text); }
.ast-toast-msg   { font-size:.75rem; color:var(--text-2); margin-top:.1rem; }
.ast-toast-x { width:26px; height:26px; border:none; background:var(--bg); border-radius:var(--r-sm); color:var(--text-3); cursor:pointer; display:flex; align-items:center; justify-content:center; flex-shrink:0; transition:all .15s; }
.ast-toast-x:hover { background:var(--border); color:var(--text); }
.ast-toast-x svg { width:13px; height:13px; }

/* ── HERO ── */
.ast-hero {
    background: linear-gradient(135deg, var(--ind-900), var(--ind-700));
    border-radius: var(--r-xl);
    padding: 1.75rem 2rem;
    position: relative; overflow: hidden;
    border: 1px solid var(--ind-800);
    box-shadow: var(--shadow-lg);
}
.ast-hero::before {
    content:''; position:absolute; top:0; left:0; right:0; height:3px;
    background: linear-gradient(90deg, var(--teal-400), var(--teal-500), var(--teal-400));
}
.ast-hero-grid {
    position:absolute; inset:0; pointer-events:none;
    background:
        linear-gradient(rgba(255,255,255,.025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.025) 1px, transparent 1px);
    background-size: 30px 30px;
}
.ast-hero-glow {
    position:absolute; width:350px; height:350px; top:-120px; right:-60px; border-radius:50%;
    background: radial-gradient(circle, rgba(20,184,166,.18) 0%, transparent 65%); pointer-events:none;
}
.ast-hero-body {
    position:relative; z-index:1;
    display:flex; align-items:center; gap:1.5rem;
}
.ast-hero-icon {
    width:64px; height:64px; border-radius:var(--r-xl); flex-shrink:0;
    background: rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.15);
    display:flex; align-items:center; justify-content:center; color:white;
    backdrop-filter: blur(6px);
}
.ast-hero-icon svg { width:30px; height:30px; }
.ast-hero-text { flex:1; }
.ast-hero-title {
    font-family:var(--font-d); font-size:1.5rem; font-weight:400; color:white;
    margin:0 0 .375rem; letter-spacing:.01em;
}
.ast-hero-sub { font-size:.875rem; color:rgba(255,255,255,.65); margin-bottom:.875rem; }
.ast-hero-chips { display:flex; flex-wrap:wrap; gap:.5rem; }
.ast-hero-chip {
    display:inline-flex; align-items:center; gap:.375rem;
    padding:.3125rem .875rem;
    background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.14);
    border-radius:9999px; backdrop-filter:blur(4px);
    font-size:.75rem; font-weight:700; color:rgba(255,255,255,.9);
    font-family:var(--font-m);
}
.ast-hero-chip svg { width:12px; height:12px; }
.ast-hero-chip.teal { background:rgba(20,184,166,.25); border-color:rgba(20,184,166,.35); color:var(--teal-300); }
.ast-hero-chip.amber { background:rgba(245,158,11,.2); border-color:rgba(245,158,11,.3); color:#fcd34d; }

.ast-hero-cta {
    display:inline-flex; align-items:center; gap:.5rem;
    padding:.625rem 1.25rem; border-radius:var(--r-md);
    font-size:.8125rem; font-weight:600; cursor:pointer;
    background: linear-gradient(135deg, var(--teal-500), var(--teal-600));
    color:white; border:none; font-family:inherit;
    box-shadow: 0 4px 16px rgba(7,143,132,.4);
    transition:all .25s; flex-shrink:0;
}
.ast-hero-cta:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(7,143,132,.5); }
.ast-hero-cta svg { width:15px; height:15px; }

/* ── STATS ROW ── */
.ast-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
}
.ast-stat {
    background: var(--surface); border-radius: var(--r-lg);
    border: 1px solid var(--border); padding: 1.125rem 1.25rem;
    box-shadow: var(--shadow-sm); position:relative; overflow:hidden;
    transition: all .2s;
}
.ast-stat::after {
    content:''; position:absolute; bottom:0; left:0; right:0; height:3px;
    background:var(--sc, var(--ind-400)); opacity:.4; transition:opacity .2s;
}
.ast-stat:hover { transform:translateY(-2px); box-shadow:var(--shadow-md); }
.ast-stat:hover::after { opacity:1; }
.ast-stat.s-indigo { --sc:var(--ind-500); }
.ast-stat.s-amber  { --sc:#f59e0b; }
.ast-stat.s-teal   { --sc:var(--teal-500); }
.ast-stat.s-n      { --sc:var(--n-400); }
.ast-stat-lbl { font-size:.625rem; font-weight:700; text-transform:uppercase; letter-spacing:.8px; color:var(--text-3); margin-bottom:.5rem; }
.ast-stat-val { font-family:var(--font-d); font-size:2rem; font-weight:400; color:var(--text); line-height:1; }

/* ── LAYOUT ── */
.ast-grid {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 1.25rem;
    align-items: start;
}

/* ── CARDS ── */
.ast-card {
    background: var(--surface); border-radius: var(--r-xl);
    border: 1px solid var(--border); overflow:hidden;
    box-shadow: var(--shadow-sm);
}
.ast-card-head {
    display:flex; align-items:center; gap:.875rem;
    padding:1.125rem 1.375rem; border-bottom:1px solid var(--border);
    background:var(--bg); position:relative; overflow:hidden;
}
.ast-card-head::before {
    content:''; position:absolute; left:0; top:0; bottom:0; width:4px;
    background:var(--hc, var(--ind-500));
}
.ast-card-icon {
    width:40px; height:40px; border-radius:var(--r-md); flex-shrink:0;
    display:flex; align-items:center; justify-content:center;
}
.ast-card-icon svg { width:18px; height:18px; }
.ast-card-icon.indigo { background:linear-gradient(135deg,var(--ind-500),var(--ind-600)); color:white; box-shadow:0 4px 10px rgba(99,102,241,.2); }
.ast-card-icon.teal   { background:linear-gradient(135deg,var(--teal-500),var(--teal-600)); color:white; box-shadow:0 4px 10px rgba(7,143,132,.2); }
.ast-card-icon.amber  { background:linear-gradient(135deg,#f59e0b,#d97706); color:white; box-shadow:0 4px 10px rgba(245,158,11,.2); }
.ast-card:has(.indigo) { --hc:var(--ind-500); }
.ast-card:has(.teal)   { --hc:var(--teal-500); }
.ast-card:has(.amber)  { --hc:#f59e0b; }

.ast-card-title { font-family:var(--font-d); font-size:.9375rem; font-weight:400; color:var(--text); margin:0; }
.ast-card-sub   { font-size:.75rem; color:var(--text-2); margin-top:.125rem; }
.ast-card-body  { padding:1.375rem; }
.ast-card-foot  {
    padding:1rem 1.375rem; border-top:1px solid var(--border); background:var(--bg);
    display:flex; justify-content:flex-end; gap:.5rem;
}

/* ── REQUÊTE ITEMS ── */
.ast-empty {
    text-align:center; padding:3rem 1.5rem;
    display:flex; flex-direction:column; align-items:center; gap:.875rem;
}
.ast-empty-ico {
    width:64px; height:64px; border-radius:50%;
    background:var(--ind-50); display:flex; align-items:center; justify-content:center;
    color:var(--ind-400);
}
.ast-empty-ico svg { width:28px; height:28px; }
.ast-empty-title { font-family:var(--font-d); font-size:1rem; color:var(--text); margin:0; }
.ast-empty-sub   { font-size:.8125rem; color:var(--text-2); margin:0; max-width:260px; }

.ast-item {
    display:flex; flex-direction:column; gap:.625rem;
    padding:1.125rem 0; border-bottom:1px solid var(--border);
    transition:all .2s; cursor:default;
}
.ast-item:first-child { padding-top:0; }
.ast-item:last-child  { border-bottom:none; padding-bottom:0; }

.ast-item-top { display:flex; align-items:flex-start; gap:.75rem; }

.ast-item-cat {
    width:36px; height:36px; border-radius:var(--r-sm); flex-shrink:0;
    display:flex; align-items:center; justify-content:center;
}
.ast-item-cat svg { width:16px; height:16px; }
.ast-item-cat.question  { background:var(--ind-50); color:var(--ind-500); border:1px solid var(--ind-100); }
.ast-item-cat.support   { background:var(--teal-50); color:var(--teal-600); border:1px solid rgba(7,143,132,.15); }
.ast-item-cat.facturation { background:rgba(245,158,11,.08); color:#d97706; border:1px solid rgba(245,158,11,.15); }
.ast-item-cat.autre     { background:var(--bg); color:var(--text-3); border:1px solid var(--border); }

.ast-item-main { flex:1; min-width:0; }
.ast-item-sujet {
    font-size:.875rem; font-weight:600; color:var(--text); margin-bottom:.25rem;
    white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
}
.ast-item-meta {
    display:flex; align-items:center; gap:.5rem; flex-wrap:wrap;
    font-size:.6875rem; color:var(--text-3); font-family:var(--font-m);
}
.ast-item-meta span { display:inline-flex; align-items:center; gap:.25rem; }

/* Status badges */
.ast-badge {
    display:inline-flex; align-items:center; gap:.3rem;
    padding:.2rem .625rem; border-radius:9999px;
    font-size:.625rem; font-weight:700; letter-spacing:.3px; text-transform:uppercase;
}
.ast-badge.en_attente { background:#fef3c7; color:#92400e; border:1px solid #fde68a; }
.ast-badge.en_cours   { background:var(--ind-50); color:var(--ind-700); border:1px solid var(--ind-200); }
.ast-badge.repondue   { background:var(--teal-50); color:var(--teal-700); border:1px solid rgba(7,143,132,.2); }
.ast-badge.fermee     { background:var(--bg); color:var(--text-3); border:1px solid var(--border); }
.ast-badge-dot { width:5px; height:5px; border-radius:50%; flex-shrink:0; }
.ast-badge.en_attente .ast-badge-dot { background:#f59e0b; }
.ast-badge.en_cours   .ast-badge-dot { background:var(--ind-500); }
.ast-badge.repondue   .ast-badge-dot { background:var(--teal-500); }
.ast-badge.fermee     .ast-badge-dot { background:var(--n-400); }

.ast-prio-badge {
    display:inline-flex; align-items:center; gap:.25rem;
    padding:.175rem .5rem; border-radius:9999px;
    font-size:.5875rem; font-weight:700; text-transform:uppercase; letter-spacing:.4px;
}
.ast-prio-badge.normale { background:var(--bg); color:var(--text-3); border:1px solid var(--border); }
.ast-prio-badge.urgente { background:#fff1f2; color:#be123c; border:1px solid #fecdd3; }

/* Reponse block */
.ast-reply {
    margin-top:.375rem; padding:.875rem 1rem;
    background: var(--teal-50); border-radius:var(--r-md);
    border:1px solid rgba(7,143,132,.15);
    border-left:3px solid var(--teal-400);
}
.ast-reply-label {
    font-size:.5875rem; font-weight:700; text-transform:uppercase; letter-spacing:.6px;
    color:var(--teal-600); margin-bottom:.4rem; display:flex; align-items:center; gap:.375rem;
}
.ast-reply-label svg { width:12px; height:12px; }
.ast-reply-text { font-size:.8125rem; color:var(--text); line-height:1.5; }

.ast-item-actions { display:flex; justify-content:flex-end; gap:.375rem; }

/* ── FORM ── */
.ast-fg { margin-bottom:1.125rem; }
.ast-fg:last-child { margin-bottom:0; }
.ast-label {
    display:flex; align-items:center; gap:.375rem;
    font-size:.6875rem; font-weight:700; text-transform:uppercase; letter-spacing:.5px;
    color:var(--text); margin-bottom:.5rem;
}
.ast-label svg { width:12px; height:12px; color:var(--ind-400); }
.ast-input, .ast-select, .ast-textarea {
    width:100%; padding:.6875rem 1rem;
    border:1.5px solid var(--border); border-radius:var(--r-md);
    font-size:.875rem; color:var(--text); background:var(--bg);
    font-family:inherit; transition:all .2s;
}
.ast-input:focus, .ast-select:focus, .ast-textarea:focus {
    outline:none; border-color:var(--teal-400); background:var(--surface);
    box-shadow:0 0 0 3px rgba(7,143,132,.12);
}
.ast-input::placeholder, .ast-textarea::placeholder { color:var(--text-3); }
.ast-select { cursor:pointer; appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%239EA4B0' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right .75rem center; background-size:16px; padding-right:2.5rem; }
.ast-textarea { resize:vertical; min-height:110px; line-height:1.55; }

.ast-char-count { font-size:.6875rem; color:var(--text-3); text-align:right; margin-top:.3rem; font-family:var(--font-m); }
.ast-char-count.warn { color:#f59e0b; }
.ast-char-count.over { color:#e11d48; }

/* Row select */
.ast-row { display:grid; grid-template-columns:1fr 1fr; gap:.875rem; }

/* Submit */
.ast-submit {
    display:flex; align-items:center; justify-content:center; gap:.5rem;
    width:100%; padding:.75rem 1.5rem; margin-top:1.125rem;
    background:linear-gradient(135deg,var(--teal-500),var(--teal-600));
    color:white; border:none; border-radius:var(--r-md);
    font-size:.875rem; font-weight:600; cursor:pointer;
    transition:all .25s; font-family:inherit;
    box-shadow:0 4px 16px rgba(7,143,132,.25);
}
.ast-submit:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(7,143,132,.35); }
.ast-submit svg { width:15px; height:15px; }

/* Btn compact */
.ast-btn {
    display:inline-flex; align-items:center; gap:.375rem;
    padding:.375rem .875rem; border-radius:var(--r-md);
    font-size:.75rem; font-weight:600; cursor:pointer; border:none;
    font-family:inherit; transition:all .2s;
}
.ast-btn svg { width:13px; height:13px; }
.ast-btn.ghost { background:var(--bg); color:var(--text-2); border:1.5px solid var(--border); }
.ast-btn.ghost:hover { border-color:var(--ind-300); color:var(--ind-700); background:var(--ind-50); }

/* ── FAQ ── */
.ast-faq-item {
    border-bottom: 1px solid var(--border); overflow:hidden;
}
.ast-faq-item:last-child { border-bottom:none; }
.ast-faq-q {
    display:flex; align-items:center; justify-content:space-between;
    padding:.875rem 0; cursor:pointer; gap:.75rem;
    font-size:.875rem; font-weight:600; color:var(--text);
    border:none; background:none; width:100%; text-align:left; font-family:inherit;
    transition:color .2s;
}
.ast-faq-q:hover { color:var(--ind-600); }
.ast-faq-arrow { width:18px; height:18px; flex-shrink:0; color:var(--text-3); transition:transform .3s; }
.ast-faq-item.open .ast-faq-arrow { transform:rotate(180deg); }
.ast-faq-a {
    display:none; font-size:.8125rem; color:var(--text-2); line-height:1.6;
    padding:0 0 .875rem;
}
.ast-faq-item.open .ast-faq-a { display:block; animation:fadeIn .25s ease; }
@keyframes fadeIn { from{opacity:0;transform:translateY(-4px);} to{opacity:1;transform:none;} }

/* ── CONTACT CARD ── */
.ast-contact-item {
    display:flex; align-items:center; gap:.875rem;
    padding:.875rem 0; border-bottom:1px solid var(--border);
}
.ast-contact-item:first-child { padding-top:0; }
.ast-contact-item:last-child  { border-bottom:none; padding-bottom:0; }
.ast-contact-ico {
    width:40px; height:40px; border-radius:var(--r-md); flex-shrink:0;
    display:flex; align-items:center; justify-content:center; transition:all .2s;
}
.ast-contact-ico svg { width:18px; height:18px; }
.ast-contact-ico.ind   { background:var(--ind-50); color:var(--ind-500); border:1px solid var(--ind-100); }
.ast-contact-ico.teal  { background:var(--teal-50); color:var(--teal-600); border:1px solid rgba(7,143,132,.15); }
.ast-contact-ico.amber { background:rgba(245,158,11,.08); color:#d97706; border:1px solid rgba(245,158,11,.15); }
.ast-contact-info { flex:1; }
.ast-contact-label { font-size:.625rem; font-weight:700; text-transform:uppercase; letter-spacing:.7px; color:var(--text-3); margin-bottom:.25rem; }
.ast-contact-val   { font-size:.875rem; font-weight:600; color:var(--text); font-family:var(--font-m); }

/* ── CHAT IA ── */
.ast-chat-wrap {
    display: flex;
    flex-direction: column;
    height: 100%;
    min-height: 420px;
}

.ast-chat-messages {
    flex: 1; overflow-y: auto; padding: 1.25rem;
    display: flex; flex-direction: column; gap: .875rem;
    scrollbar-width: thin; scrollbar-color: var(--border) transparent;
    background: var(--bg);
    min-height: 320px; max-height: 420px;
}
.ast-chat-messages::-webkit-scrollbar { width: 4px; }
.ast-chat-messages::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

/* Bulles */
.ast-bubble {
    display: flex; gap: .625rem; align-items: flex-end; max-width: 90%;
}
.ast-bubble.user { flex-direction: row-reverse; align-self: flex-end; }
.ast-bubble.bot  { align-self: flex-start; }

.ast-bubble-avatar {
    width: 28px; height: 28px; border-radius: 50%; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; font-size: .625rem; font-weight: 700;
}
.ast-bubble.bot  .ast-bubble-avatar { background: linear-gradient(135deg, var(--ind-500), var(--teal-500)); color: white; }
.ast-bubble.user .ast-bubble-avatar { background: var(--ind-50); color: var(--ind-600); border: 1px solid var(--ind-200); }

.ast-bubble-content {
    padding: .625rem .875rem;
    border-radius: var(--r-lg);
    font-size: .8125rem; line-height: 1.55; max-width: 100%;
    word-break: break-word;
}
.ast-bubble.bot  .ast-bubble-content { background: var(--surface); border: 1px solid var(--border); color: var(--text); border-bottom-left-radius: 4px; }
.ast-bubble.user .ast-bubble-content { background: linear-gradient(135deg, var(--ind-600), var(--ind-700)); color: white; border-bottom-right-radius: 4px; }

/* Typing indicator */
.ast-typing { display: none; }
.ast-typing.show { display: flex; }
.ast-typing .ast-bubble-content { padding: .75rem 1rem; }
.ast-dots { display: inline-flex; gap: 4px; align-items: center; }
.ast-dots span {
    width: 6px; height: 6px; border-radius: 50%; background: var(--text-3);
    animation: bounce .9s ease-in-out infinite;
}
.ast-dots span:nth-child(2) { animation-delay: .15s; }
.ast-dots span:nth-child(3) { animation-delay: .3s; }
@keyframes bounce { 0%,60%,100% { transform: translateY(0); } 30% { transform: translateY(-6px); } }

/* Ticket suggest banner */
.ast-ticket-suggest {
    display: none; margin: 0 1.25rem 1rem;
    padding: .875rem 1rem; border-radius: var(--r-lg);
    background: linear-gradient(135deg, rgba(99,102,241,.08), rgba(20,184,166,.06));
    border: 1px solid var(--ind-200);
    border-left: 4px solid var(--teal-500);
}
.ast-ticket-suggest.show { display: flex; align-items: center; gap: .875rem; }
.ast-ticket-suggest-icon { width: 36px; height: 36px; border-radius: var(--r-md); flex-shrink: 0; background: linear-gradient(135deg, var(--teal-500), var(--teal-600)); color: white; display: flex; align-items: center; justify-content: center; }
.ast-ticket-suggest-icon svg { width: 16px; height: 16px; }
.ast-ticket-suggest-text { flex: 1; }
.ast-ticket-suggest-title { font-size: .8125rem; font-weight: 700; color: var(--text); margin-bottom: .125rem; }
.ast-ticket-suggest-sub   { font-size: .75rem; color: var(--text-2); }
.ast-ticket-btn {
    display: inline-flex; align-items: center; gap: .375rem;
    padding: .5rem 1rem; border-radius: var(--r-md);
    background: linear-gradient(135deg, var(--teal-500), var(--teal-600));
    color: white; border: none; font-size: .75rem; font-weight: 700;
    cursor: pointer; font-family: inherit; flex-shrink: 0;
    box-shadow: 0 3px 10px rgba(7,143,132,.3); transition: all .2s;
}
.ast-ticket-btn:hover { transform: translateY(-1px); box-shadow: 0 5px 14px rgba(7,143,132,.4); }
.ast-ticket-btn svg { width: 13px; height: 13px; }

/* Input bar */
.ast-chat-bar {
    display: flex; align-items: center; gap: .625rem;
    padding: .875rem 1.25rem; border-top: 1px solid var(--border);
    background: var(--surface);
}
.ast-chat-input {
    flex: 1; padding: .625rem .875rem;
    border: 1.5px solid var(--border); border-radius: var(--r-lg);
    font-size: .875rem; color: var(--text); background: var(--bg);
    font-family: inherit; resize: none; line-height: 1.4;
    max-height: 100px; overflow-y: auto; outline: none;
    transition: border-color .2s, box-shadow .2s;
}
.ast-chat-input:focus { border-color: var(--teal-400); box-shadow: 0 0 0 3px rgba(7,143,132,.1); }
.ast-chat-input::placeholder { color: var(--text-3); }
.ast-chat-send {
    width: 40px; height: 40px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(135deg, var(--teal-500), var(--teal-600));
    color: white; border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 3px 10px rgba(7,143,132,.3); transition: all .2s;
}
.ast-chat-send:hover:not(:disabled) { transform: scale(1.08); box-shadow: 0 5px 14px rgba(7,143,132,.4); }
.ast-chat-send:disabled { opacity: .5; cursor: not-allowed; }
.ast-chat-send svg { width: 16px; height: 16px; }

/* Chat header */
.ast-chat-head-status {
    display: inline-flex; align-items: center; gap: .375rem;
    font-size: .6875rem; font-weight: 600; color: var(--teal-600);
}
.ast-chat-head-status::before {
    content: ''; width: 7px; height: 7px; border-radius: 50%;
    background: var(--teal-500); box-shadow: 0 0 0 3px rgba(7,143,132,.2);
    animation: pulse-dot 2s ease-in-out infinite;
}
@keyframes pulse-dot { 0%,100% { box-shadow:0 0 0 3px rgba(7,143,132,.2); } 50% { box-shadow:0 0 0 6px rgba(7,143,132,.06); } }

/* Ticket modal créé depuis chat */
.ast-chat-modal-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(15,23,42,.55); backdrop-filter: blur(10px);
    z-index: 800; align-items: center; justify-content: center; padding: 1rem;
}
.ast-chat-modal-overlay.open { display: flex; }
.ast-chat-modal {
    background: var(--surface); border-radius: var(--r-xl);
    width: 100%; max-width: 480px; max-height: 90vh; overflow: hidden;
    animation: mIn .4s cubic-bezier(.16,1,.3,1);
    box-shadow: 0 32px 64px -16px rgba(0,0,0,.22);
    border: 1px solid var(--border); display: flex; flex-direction: column;
}
@keyframes mIn { from { opacity:0; transform:scale(.96) translateY(16px); } to { opacity:1; transform:none; } }
.ast-chat-modal-head {
    background: linear-gradient(135deg, var(--ind-900), var(--ind-700));
    padding: 1.25rem 1.375rem; color: white; position: relative; overflow: hidden; flex-shrink: 0;
    display: flex; align-items: flex-start; gap: .75rem;
}
.ast-chat-modal-head::before {
    content:''; position:absolute; inset:0;
    background: linear-gradient(rgba(255,255,255,.025) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.025) 1px, transparent 1px);
    background-size: 20px 20px;
}
.ast-chat-modal-head::after { content:''; position:absolute; bottom:0; left:0; right:0; height:3px; background:linear-gradient(90deg,var(--teal-400),var(--teal-500)); }
.ast-chat-modal-title { font-family:var(--font-d); font-size:1.0625rem; font-weight:400; margin:0 0 .25rem; position:relative; z-index:1; }
.ast-chat-modal-sub   { font-size:.75rem; opacity:.7; position:relative; z-index:1; }
.ast-chat-modal-close { position:absolute; top:.875rem; right:.875rem; width:30px; height:30px; border:none; border-radius:var(--r-sm); background:rgba(255,255,255,.1); color:rgba(255,255,255,.7); cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all .2s; z-index:2; }
.ast-chat-modal-close:hover { background:rgba(255,255,255,.2); color:white; transform:rotate(90deg); }
.ast-chat-modal-close svg { width:14px; height:14px; }
.ast-chat-modal-body  { padding: 1.375rem; overflow-y: auto; flex: 1; display: flex; flex-direction: column; gap: 1rem; }
.ast-chat-modal-row   { display: grid; grid-template-columns: 1fr 1fr; gap: .75rem; }
.ast-chat-modal-field { display: flex; flex-direction: column; gap: .375rem; }
.ast-chat-modal-label { font-size: .75rem; font-weight: 600; color: var(--text-2); text-transform: uppercase; letter-spacing: .04em; }
.ast-chat-modal-input,
.ast-chat-modal-select,
.ast-chat-modal-textarea {
    width: 100%; padding: .625rem .875rem; border: 1.5px solid var(--border);
    border-radius: var(--r-md); background: var(--bg); color: var(--text);
    font-family: var(--font-b); font-size: .875rem; transition: border-color .2s, box-shadow .2s;
}
.ast-chat-modal-input:focus,
.ast-chat-modal-select:focus,
.ast-chat-modal-textarea:focus {
    outline: none; border-color: var(--ind-400); box-shadow: 0 0 0 3px rgba(99,102,241,.12);
}
.ast-chat-modal-textarea { resize: vertical; min-height: 100px; }
.ast-chat-modal-ia-note {
    display: flex; align-items: center; gap: .5rem;
    padding: .625rem .875rem; border-radius: var(--r-md);
    background: rgba(99,102,241,.06); border: 1px solid rgba(99,102,241,.15);
    font-size: .75rem; color: var(--ind-400);
}
.ast-chat-modal-foot  { padding: 1rem 1.375rem; border-top: 1px solid var(--border); background: var(--bg); display: flex; justify-content: flex-end; gap: .5rem; flex-shrink: 0; }
.ast-chat-modal-cancel { padding: .5rem 1.125rem; border: 1.5px solid var(--border); border-radius: var(--r-md); background: transparent; color: var(--text-2); font-size: .875rem; cursor: pointer; transition: all .2s; }
.ast-chat-modal-cancel:hover { border-color: var(--text-3); color: var(--text); }
.ast-chat-modal-submit {
    display: flex; align-items: center; gap: .5rem;
    padding: .5rem 1.25rem; border: none; border-radius: var(--r-md);
    background: linear-gradient(135deg, var(--ind-600), var(--ind-500)); color: white;
    font-family: var(--font-b); font-size: .875rem; font-weight: 600; cursor: pointer; transition: all .2s;
}
.ast-chat-modal-submit:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(99,102,241,.3); }
.ast-chat-modal-submit:disabled { opacity: .6; cursor: default; transform: none; }

/* ── RESPONSIVE ── */

/* Tablette paysage */
@media (max-width: 1100px) {
    .ast-grid { grid-template-columns: 1fr 320px; }
}

/* Tablette portrait */
@media (max-width: 860px) {
    .ast-grid { grid-template-columns: 1fr; }
    .ast-stats { grid-template-columns: repeat(2, 1fr); }
    .ast-hero-body { flex-wrap: wrap; }
    .ast-hero-cta { width: 100%; justify-content: center; }
}

/* Mobile */
@media (max-width: 540px) {
    .ast-page, .ast-card, .ast-grid > div { min-width: 0; overflow: hidden; }
    .ast-hero { padding: 1.25rem; }
    .ast-hero-body { flex-direction: column; align-items: flex-start; gap: 1rem; }
    .ast-hero-title { font-size: 1.25rem; }
    .ast-hero-icon { width: 48px; height: 48px; }
    .ast-hero-icon svg { width: 22px; height: 22px; }
    .ast-stats { grid-template-columns: 1fr 1fr; gap: .625rem; }
    .ast-stat { padding: .875rem 1rem; }
    .ast-stat-val { font-size: 1.625rem; }
    .ast-row { grid-template-columns: 1fr; }
    .ast-card-body { padding: 1rem; }
    .ast-card-foot { padding: .875rem 1rem; }
    .ast-card-head { padding: .875rem 1rem; gap: .625rem; }
    .ast-card-icon { width: 36px; height: 36px; }
    .ast-card-icon svg { width: 16px; height: 16px; }
    .ast-item-top { gap: .5rem; }
    .ast-item-cat { width: 30px; height: 30px; }
    .ast-item-cat svg { width: 13px; height: 13px; }
    .ast-item-sujet { font-size: .8125rem; }
    .ast-reply { margin-left: 0; }
    .ast-item-actions { padding-left: 0; }
    .ast-contact-item { gap: .625rem; }
    .ast-contact-ico { width: 34px; height: 34px; }
}
</style>
@endsection

@section('content')

@if(session('success'))
<div class="ast-toast" id="t-ok">
    <div class="ast-toast-ico"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
    <div class="ast-toast-body">
        <div class="ast-toast-title">Demande soumise</div>
        <div class="ast-toast-msg">{{ session('success') }}</div>
    </div>
    <button class="ast-toast-x" onclick="this.closest('.ast-toast').classList.add('out')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
    <div class="ast-toast-bar"></div>
</div>
@endif

<div class="ast-page">

    {{-- ── HERO ── --}}
    <section class="ast-hero">
        <div class="ast-hero-grid"></div>
        <div class="ast-hero-glow"></div>
        <div class="ast-hero-body">
            <div class="ast-hero-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </div>
            <div class="ast-hero-text">
                <h1 class="ast-hero-title">Assistance & Support</h1>
                <p class="ast-hero-sub">Posez vos questions, signalez un probleme ou contactez votre equipe RH</p>
                <div class="ast-hero-chips">
                    <span class="ast-hero-chip teal">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        {{ $stats['repondues'] }} repondue{{ $stats['repondues'] > 1 ? 's' : '' }}
                    </span>
                    @if($stats['en_attente'] > 0)
                    <span class="ast-hero-chip amber">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        {{ $stats['en_attente'] }} en attente
                    </span>
                    @endif
                </div>
            </div>
            <button class="ast-hero-cta" onclick="document.getElementById('newTicketForm').scrollIntoView({behavior:'smooth'})">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Nouvelle demande
            </button>
        </div>
    </section>

    {{-- ── STATS ── --}}
    <div class="ast-stats">
        <div class="ast-stat s-indigo">
            <div class="ast-stat-lbl">Total</div>
            <div class="ast-stat-val">{{ $stats['total'] }}</div>
        </div>
        <div class="ast-stat s-amber">
            <div class="ast-stat-lbl">En attente</div>
            <div class="ast-stat-val">{{ $stats['en_attente'] }}</div>
        </div>
        <div class="ast-stat s-teal">
            <div class="ast-stat-lbl">Repondues</div>
            <div class="ast-stat-val">{{ $stats['repondues'] }}</div>
        </div>
        <div class="ast-stat s-n">
            <div class="ast-stat-lbl">Fermees</div>
            <div class="ast-stat-val">{{ $stats['fermees'] }}</div>
        </div>
    </div>

    {{-- ── MAIN GRID ── --}}
    <div class="ast-grid">

        {{-- LEFT : historique + nouveau ticket --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem;">

            {{-- Mes demandes --}}
            <article class="ast-card">
                <header class="ast-card-head">
                    <div class="ast-card-icon indigo">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    </div>
                    <div>
                        <h2 class="ast-card-title">Mes demandes</h2>
                        <p class="ast-card-sub">Historique de vos requetes de support</p>
                    </div>
                </header>
                <div class="ast-card-body">
                    @if($requetes->isEmpty())
                    <div class="ast-empty">
                        <div class="ast-empty-ico">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        </div>
                        <p class="ast-empty-title">Aucune demande</p>
                        <p class="ast-empty-sub">Vous n'avez pas encore soumis de demande d'assistance.</p>
                    </div>
                    @else
                    @foreach($requetes as $req)
                    <div class="ast-item">
                        <div class="ast-item-top">
                            {{-- Icon categorie --}}
                            <div class="ast-item-cat {{ $req->categorie }}">
                                @if($req->categorie === 'question')
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                @elseif($req->categorie === 'support')
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                @elseif($req->categorie === 'facturation')
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                @endif
                            </div>

                            <div class="ast-item-main">
                                <div class="ast-item-sujet">{{ $req->sujet }}</div>
                                <div class="ast-item-meta">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="10" height="10"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/></svg>
                                        {{ $req->created_at->format('d/m/Y') }}
                                    </span>
                                    <span>·</span>
                                    <span>{{ \App\Models\Requete::CATEGORIES[$req->categorie] ?? $req->categorie }}</span>
                                    <span>·</span>
                                    <span class="ast-badge {{ $req->statut }}">
                                        <span class="ast-badge-dot"></span>
                                        {{ \App\Models\Requete::STATUTS[$req->statut] ?? $req->statut }}
                                    </span>
                                    <span class="ast-prio-badge {{ $req->priorite }}">
                                        @if($req->priorite === 'urgente')⚡ @endif{{ \App\Models\Requete::PRIORITES[$req->priorite] ?? $req->priorite }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Message employé --}}
                        <div style="font-size:.8125rem;color:var(--text-2);line-height:1.5;padding-left:2.75rem;">
                            {{ Str::limit($req->message, 160) }}
                        </div>

                        {{-- Réponse RH --}}
                        @if($req->reponse)
                        <div class="ast-reply" style="margin-left:2.75rem;">
                            <div class="ast-reply-label">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                Reponse RH {{ $req->repondu_le ? '— '.$req->repondu_le->format('d/m/Y') : '' }}
                            </div>
                            <div class="ast-reply-text">{{ $req->reponse }}</div>
                        </div>
                        @endif

                        {{-- Actions --}}
                        @if($req->statut === 'repondue')
                        <div class="ast-item-actions" style="padding-left:2.75rem;">
                            <form action="{{ route('espace-employe.assistance.fermer', $req) }}" method="POST">
                                @csrf
                                <button type="submit" class="ast-btn ghost">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                    Marquer comme resolu
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                    @endforeach
                    @endif
                </div>
            </article>

            {{-- Nouveau ticket --}}
            <article class="ast-card" id="newTicketForm">
                <header class="ast-card-head">
                    <div class="ast-card-icon teal">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    </div>
                    <div>
                        <h2 class="ast-card-title">Nouvelle demande</h2>
                        <p class="ast-card-sub">Decrivez votre probleme ou question</p>
                    </div>
                </header>
                <form action="{{ route('espace-employe.assistance.store') }}" method="POST">
                    @csrf
                    <div class="ast-card-body">

                        <div class="ast-fg">
                            <label class="ast-label">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Sujet
                            </label>
                            <input type="text" name="sujet" class="ast-input" placeholder="Decrivez brievement votre demande" value="{{ old('sujet') }}" required maxlength="255">
                            @error('sujet')<p style="font-size:.6875rem;color:#e11d48;margin-top:.3rem;">{{ $message }}</p>@enderror
                        </div>

                        <div class="ast-row">
                            <div class="ast-fg">
                                <label class="ast-label">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                                    Categorie
                                </label>
                                <select name="categorie" class="ast-select" required>
                                    <option value="">— Choisir —</option>
                                    @foreach(\App\Models\Requete::CATEGORIES as $k => $v)
                                    <option value="{{ $k }}" {{ old('categorie') === $k ? 'selected' : '' }}>{{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="ast-fg">
                                <label class="ast-label">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                                    Priorite
                                </label>
                                <select name="priorite" class="ast-select" required>
                                    @foreach(\App\Models\Requete::PRIORITES as $k => $v)
                                    <option value="{{ $k }}" {{ old('priorite', 'normale') === $k ? 'selected' : '' }}>{{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="ast-fg">
                            <label class="ast-label">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                Message
                            </label>
                            <textarea name="message" class="ast-textarea" placeholder="Decrivez votre probleme en detail..." required maxlength="3000" oninput="countChars(this)">{{ old('message') }}</textarea>
                            <div class="ast-char-count" id="charCount">0 / 3000</div>
                            @error('message')<p style="font-size:.6875rem;color:#e11d48;margin-top:.3rem;">{{ $message }}</p>@enderror
                        </div>

                    </div>
                    <div class="ast-card-foot">
                        <button type="submit" class="ast-submit" style="margin-top:0;width:auto;padding:.625rem 1.75rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                            Soumettre la demande
                        </button>
                    </div>
                </form>
            </article>

        </div>

        {{-- RIGHT : Chat IA + FAQ + Contact --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem;">

            {{-- Chat IA --}}
            <article class="ast-card">
                <header class="ast-card-head">
                    <div class="ast-card-icon" style="background:linear-gradient(135deg,var(--ind-500),var(--teal-500));color:white;box-shadow:0 4px 12px rgba(99,102,241,.2);">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a9 9 0 0 1 9 9c0 4.97-4.03 9-9 9a9 9 0 0 1-9-9A9 9 0 0 1 12 2z"/><path d="M8 12h.01M12 12h.01M16 12h.01"/></svg>
                    </div>
                    <div style="flex:1;">
                        <h2 class="ast-card-title">Assistant IA</h2>
                        <span class="ast-chat-head-status">En ligne · Repond instantanement</span>
                    </div>
                </header>
                <div class="ast-chat-wrap">
                    <div class="ast-chat-messages" id="chatMessages">
                        {{-- Message d'accueil --}}
                        <div class="ast-bubble bot">
                            <div class="ast-bubble-avatar">IA</div>
                            <div class="ast-bubble-content">Bonjour {{ $personnel->prenoms ?? 'vous' }} ! Je suis votre assistant RH. Comment puis-je vous aider aujourd'hui ? Posez-moi votre question et je ferai de mon mieux pour y repondre. Si je ne peux pas resoudre votre probleme, je vous aiderai a créer un ticket de support.</div>
                        </div>
                        {{-- Typing indicator — DOIT être dans chatMessages pour insertBefore --}}
                        <div class="ast-bubble bot ast-typing" id="typingIndicator">
                            <div class="ast-bubble-avatar">IA</div>
                            <div class="ast-bubble-content"><div class="ast-dots"><span></span><span></span><span></span></div></div>
                        </div>
                    </div>

                    {{-- Suggestion de ticket --}}
                    <div class="ast-ticket-suggest" id="ticketSuggest">
                        <div class="ast-ticket-suggest-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        </div>
                        <div class="ast-ticket-suggest-text">
                            <div class="ast-ticket-suggest-title">Creer un ticket de support</div>
                            <div class="ast-ticket-suggest-sub">L'IA n'a pas pu resoudre votre probleme — un agent humain prendra le relais.</div>
                        </div>
                        <button class="ast-ticket-btn" id="openTicketModal">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Creer
                        </button>
                    </div>

                    {{-- Input --}}
                    <div class="ast-chat-bar">
                        <textarea class="ast-chat-input" id="chatInput" placeholder="Posez votre question..." rows="1" maxlength="1000" onkeydown="handleChatKey(event)"></textarea>
                        <button class="ast-chat-send" id="chatSend" onclick="sendChat()">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                        </button>
                    </div>
                </div>
            </article>

            {{-- FAQ --}}
            <article class="ast-card">
                <header class="ast-card-head">
                    <div class="ast-card-icon amber">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    </div>
                    <div>
                        <h2 class="ast-card-title">Questions frequentes</h2>
                        <p class="ast-card-sub">Reponses aux demandes les plus courantes</p>
                    </div>
                </header>
                <div class="ast-card-body">

                    <div class="ast-faq-item">
                        <button class="ast-faq-q" onclick="toggleFaq(this)">
                            Comment demander un conge ?
                            <svg class="ast-faq-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                        </button>
                        <div class="ast-faq-a">Rendez-vous dans <strong>Mes Conges</strong> depuis le menu lateral, puis cliquez sur <em>Nouvelle demande</em>. Selectionnez le type, les dates et validez. Votre responsable recevra une notification.</div>
                    </div>

                    <div class="ast-faq-item">
                        <button class="ast-faq-q" onclick="toggleFaq(this)">
                            Ou trouver mes bulletins de paie ?
                            <svg class="ast-faq-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                        </button>
                        <div class="ast-faq-a">Vos bulletins sont accessibles dans la section <strong>Bulletins de paie</strong>. Ils sont classes par annee et par mois. Vous pouvez les consulter en ligne ou les telecharger en PDF.</div>
                    </div>

                    <div class="ast-faq-item">
                        <button class="ast-faq-q" onclick="toggleFaq(this)">
                            Comment modifier mon mot de passe ?
                            <svg class="ast-faq-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                        </button>
                        <div class="ast-faq-a">Allez dans <strong>Parametres</strong> puis dans la section <em>Mot de passe</em>. Entrez votre mot de passe actuel, puis votre nouveau mot de passe (minimum 8 caracteres) et confirmez.</div>
                    </div>

                    <div class="ast-faq-item">
                        <button class="ast-faq-q" onclick="toggleFaq(this)">
                            Comment declarer une absence ?
                            <svg class="ast-faq-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                        </button>
                        <div class="ast-faq-a">Dans <strong>Mes Absences</strong>, cliquez sur <em>Declarer une absence</em>. Selectionnez le type, la date et la duree, ajoutez un motif et eventuellement un justificatif. La RH sera notifiee.</div>
                    </div>

                    <div class="ast-faq-item">
                        <button class="ast-faq-q" onclick="toggleFaq(this)">
                            Combien de jours de conge me restent-il ?
                            <svg class="ast-faq-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                        </button>
                        <div class="ast-faq-a">Votre solde de conges est affiche sur la page <strong>Mes Conges</strong> (cartes en haut) et sur votre <strong>Tableau de bord</strong>. En cas de doute, contactez votre service RH.</div>
                    </div>

                </div>
            </article>

            {{-- Contact --}}
            <article class="ast-card">
                <header class="ast-card-head">
                    <div class="ast-card-icon teal">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.58 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    </div>
                    <div>
                        <h2 class="ast-card-title">Nous contacter</h2>
                        <p class="ast-card-sub">Coordonnees du service RH</p>
                    </div>
                </header>
                <div class="ast-card-body">
                    <div class="ast-contact-item">
                        <div class="ast-contact-ico ind">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </div>
                        <div class="ast-contact-info">
                            <div class="ast-contact-label">E-mail RH</div>
                            <div class="ast-contact-val">rh@{{ $personnel?->entreprise?->nom ? strtolower(str_replace(' ', '', $personnel->entreprise->nom)).'.com' : 'portail-rh.com' }}</div>
                        </div>
                    </div>
                    <div class="ast-contact-item">
                        <div class="ast-contact-ico teal">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.58 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </div>
                        <div class="ast-contact-info">
                            <div class="ast-contact-label">Telephone</div>
                            <div class="ast-contact-val">{{ $personnel?->entreprise?->telephone ?? '+225 00 00 00 00 00' }}</div>
                        </div>
                    </div>
                    <div class="ast-contact-item">
                        <div class="ast-contact-ico amber">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <div class="ast-contact-info">
                            <div class="ast-contact-label">Horaires</div>
                            <div class="ast-contact-val">Lun–Ven, 08h–17h</div>
                        </div>
                    </div>
                </div>
            </article>

        </div>{{-- /right --}}
    </div>{{-- /ast-grid --}}
</div>{{-- /ast-page --}}

{{-- ── Ticket Modal (chat) ── --}}
<div class="ast-chat-modal-overlay" id="chatTicketModal" onclick="if(event.target===this)closeTicketModal()">
    <div class="ast-chat-modal">
        <div class="ast-chat-modal-head">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:20px;height:20px;flex-shrink:0;"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            <div>
                <div class="ast-chat-modal-title">Créer un ticket de support</div>
                <div class="ast-chat-modal-sub">Pré-rempli depuis votre conversation avec l'IA</div>
            </div>
            <button class="ast-chat-modal-close" onclick="closeTicketModal()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="ast-chat-modal-body">
            <div class="ast-chat-modal-field">
                <label class="ast-chat-modal-label">Sujet</label>
                <input type="text" class="ast-chat-modal-input" id="modalSujet" placeholder="Sujet du ticket" maxlength="255">
            </div>
            <div class="ast-chat-modal-row">
                <div class="ast-chat-modal-field">
                    <label class="ast-chat-modal-label">Catégorie</label>
                    <select class="ast-chat-modal-select" id="modalCategorie">
                        <option value="question">Question générale</option>
                        <option value="facturation">Facturation / Paie</option>
                        <option value="support">Support technique</option>
                        <option value="autre">Autre</option>
                    </select>
                </div>
                <div class="ast-chat-modal-field">
                    <label class="ast-chat-modal-label">Priorité</label>
                    <select class="ast-chat-modal-select" id="modalPriorite">
                        <option value="normale">Normale</option>
                        <option value="urgente">Urgente</option>
                    </select>
                </div>
            </div>
            <div class="ast-chat-modal-field">
                <label class="ast-chat-modal-label">Message</label>
                <textarea class="ast-chat-modal-textarea" id="modalMessage" rows="5" placeholder="Décrivez votre problème..."></textarea>
            </div>
            <div class="ast-chat-modal-ia-note">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;flex-shrink:0;"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                Le résumé de votre échange avec l'IA a été pré-rempli dans le message.
            </div>
        </div>
        <div class="ast-chat-modal-foot">
            <button class="ast-chat-modal-cancel" onclick="closeTicketModal()">Annuler</button>
            <button class="ast-chat-modal-submit" id="modalSubmitBtn" onclick="submitChatTicket()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;"><path d="M22 2L11 13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                Envoyer le ticket
            </button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
/* ── Toast ── */
document.querySelectorAll('.ast-toast').forEach(t => {
    setTimeout(() => { t.classList.add('out'); setTimeout(() => t.remove(), 350); }, 5000);
});

/* ── Char counter (ticket form) ── */
function countChars(el) {
    const max = 3000, cur = el.value.length;
    const cnt = document.getElementById('charCount');
    cnt.textContent = cur + ' / ' + max;
    cnt.className = 'ast-char-count' + (cur > max - 200 ? ' warn' : '') + (cur >= max ? ' over' : '');
}
document.querySelector('.ast-textarea')?.dispatchEvent(new Event('input'));

/* ── FAQ accordion ── */
function toggleFaq(btn) {
    const item = btn.closest('.ast-faq-item');
    const wasOpen = item.classList.contains('open');
    document.querySelectorAll('.ast-faq-item.open').forEach(i => i.classList.remove('open'));
    if(!wasOpen) item.classList.add('open');
}

/* ══════════════════════════════════════════════════
   CHAT IA
   ══════════════════════════════════════════════════ */
let chatHistory    = [];
let ticketCreated  = false;   // évite les doublons
const csrfToken    = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

const chatMessages    = document.getElementById('chatMessages');
const typingIndicator = document.getElementById('typingIndicator');
const ticketSuggest   = document.getElementById('ticketSuggest');
const chatInput       = document.getElementById('chatInput');

/* ── Auto-resize textarea ── */
chatInput?.addEventListener('input', () => {
    chatInput.style.height = 'auto';
    chatInput.style.height = Math.min(chatInput.scrollHeight, 120) + 'px';
});

/* ── Enter sends, Shift+Enter = newline ── */
function handleChatKey(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        sendChat();
    }
}

/* ── Add a chat bubble ── */
function addBubble(role, text) {
    const wrap = document.createElement('div');
    wrap.className = 'ast-bubble ' + (role === 'user' ? 'user' : 'bot');

    if (role === 'assistant') {
        const av = document.createElement('div');
        av.className = 'ast-bubble-avatar';
        av.textContent = 'IA';
        wrap.appendChild(av);
    }

    const content = document.createElement('div');
    content.className = 'ast-bubble-content';
    content.innerHTML = text
        .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
        .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
        .replace(/\n/g, '<br>');
    wrap.appendChild(content);

    chatMessages.insertBefore(wrap, typingIndicator);
    chatMessages.scrollTop = chatMessages.scrollHeight;
    return wrap;
}

/* ── Typing indicator ── */
function setTyping(on) {
    typingIndicator.style.display = on ? 'flex' : 'none';
    if (on) chatMessages.scrollTop = chatMessages.scrollHeight;
}

/* ── Créer ticket automatiquement ── */
async function autoCreateTicket(sujet, categorie, priorite, history) {
    if (ticketCreated) return;   // ne pas créer deux fois
    ticketCreated = true;

    const message = history
        .map(m => (m.role === 'user' ? 'Moi : ' : 'IA : ') + m.content)
        .join('\n\n')
        .substring(0, 3000);

    try {
        const res = await fetch('{{ url("/mon-espace/assistance/chat/ticket") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ sujet: sujet || 'Demande via assistant IA', categorie, priorite, message }),
        });

        const data = res.ok ? await res.json() : null;

        if (data && data.success) {
            const ref = data.reference ? ' (réf. ' + data.reference + ')' : (data.id ? ' #' + data.id : '');
            addBubble('assistant', '🎫 J\'ai créé un ticket de support' + ref + ' en votre nom. Un agent RH va prendre en charge votre demande et vous répondra très prochainement.');
            if (ticketSuggest) ticketSuggest.style.display = 'none';
            showToast('Ticket créé avec succès !', 'success');
        } else {
            ticketCreated = false;   // autoriser retry
            addBubble('assistant', 'Je n\'ai pas pu créer le ticket automatiquement. Utilisez le formulaire "Nouvelle demande" ci-dessous pour nous contacter.');
        }
    } catch (err) {
        ticketCreated = false;
        console.error('autoCreateTicket error:', err);
        addBubble('assistant', 'Erreur lors de la création du ticket. Veuillez utiliser le formulaire ci-dessous.');
    }
}

/* ── Main send function ── */
async function sendChat() {
    const text = chatInput.value.trim();
    if (!text) return;

    chatInput.value = '';
    chatInput.style.height = 'auto';
    chatInput.disabled = true;
    document.getElementById('chatSend').disabled = true;

    addBubble('user', text);
    setTyping(true);

    try {
        const res = await fetch('{{ url("/mon-espace/assistance/chat") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ message: text, history: chatHistory }),
        });

        if (!res.ok) throw new Error('Erreur serveur (' + res.status + ')');
        const data = await res.json();

        setTyping(false);
        addBubble('assistant', data.reply);

        chatHistory = data.history ?? [...chatHistory, { role: 'user', content: text }];

        // Création automatique du ticket si nécessaire
        if (data.requires_ticket && !ticketCreated) {
            // Petit délai pour que l'user lise la réponse IA avant la confirmation
            setTimeout(() => {
                autoCreateTicket(
                    data.suggested_sujet     ?? text,
                    data.suggested_categorie ?? 'question',
                    data.suggested_priorite  ?? 'normale',
                    chatHistory
                );
            }, 800);
        }

    } catch (err) {
        setTyping(false);
        addBubble('assistant', 'Désolé, une erreur s\'est produite. Veuillez réessayer ou utiliser le formulaire ci-dessous.');
        console.error('Chat error:', err);
    } finally {
        chatInput.disabled = false;
        document.getElementById('chatSend').disabled = false;
        chatInput.focus();
    }
}

/* ── Toast helper ── */
function showToast(msg, type = 'success') {
    const color = type === 'error' ? '#ef4444' : 'var(--teal-500)';
    const t = document.createElement('div');
    t.className = 'ast-toast';
    t.innerHTML = `<span style="font-size:.875rem;color:var(--text);">${msg}</span><div class="ast-toast-bar" style="background:${color};"></div>`;
    document.body.appendChild(t);
    setTimeout(() => { t.classList.add('out'); setTimeout(() => t.remove(), 350); }, 5000);
}

/* Init */
setTyping(false);
ticketSuggest.style.display = 'none';
</script>
@endsection
