@extends('layouts.espace-employe')

@section('title', 'Parametres')
@section('page-title', 'Parametres')
@section('breadcrumb')
    <a href="{{ route('espace-employe.dashboard') }}">Accueil</a>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
    <span>Parametres</span>
@endsection

@section('styles')
<style>
/* ============================================
   PARAMETRES PAGE — Indigo × Teal Charter
   ============================================ */
.prm-page {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
    max-width: 760px;
    animation: prm-in 0.5s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes prm-in {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ===== TOAST ===== */
.prm-toast {
    position: fixed; top: 1.25rem; right: 1.25rem; z-index: 1000;
    display: flex; align-items: center; gap: .75rem;
    padding: .875rem 1.125rem;
    background: var(--surface); border-radius: var(--r-lg);
    box-shadow: var(--shadow-lg); border: 1px solid var(--border);
    max-width: 360px; overflow: hidden;
    animation: tIn .5s cubic-bezier(.16,1,.3,1);
}
@keyframes tIn  { from { opacity:0; transform:translateX(100px); } to { opacity:1; transform:none; } }
@keyframes tOut { to   { opacity:0; transform:translateX(100px); } }
.prm-toast.hiding { animation: tOut .3s ease-in forwards; }
.prm-toast-bar { position:absolute; bottom:0; left:0; height:3px; background:var(--teal-500); animation: shrink 5s linear forwards; }
.prm-toast.error .prm-toast-bar { background:#be123c; }
@keyframes shrink { from { width:100%; } to { width:0%; } }
.prm-toast-icon {
    width:34px; height:34px; border-radius:var(--r-md);
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.prm-toast.success .prm-toast-icon { background:var(--teal-100); color:var(--teal-700); }
.prm-toast.error   .prm-toast-icon { background:#ffe4e6; color:#be123c; }
.prm-toast-icon svg { width:16px; height:16px; }
.prm-toast-body { flex:1; }
.prm-toast-title { font-size:.8125rem; font-weight:600; color:var(--text); }
.prm-toast-msg   { font-size:.75rem; color:var(--text-2); margin-top:.1rem; }
.prm-toast-close {
    width:28px; height:28px; border:none; background:var(--bg); border-radius:var(--r-sm);
    color:var(--text-2); cursor:pointer; display:flex; align-items:center; justify-content:center;
    transition: all .2s; flex-shrink:0;
}
.prm-toast-close:hover { background:var(--border); color:var(--text); }
.prm-toast-close svg { width:14px; height:14px; }

/* ===== HERO ===== */
.prm-hero {
    background: linear-gradient(135deg, var(--ind-900), var(--ind-700));
    border-radius: var(--r-xl);
    padding: 1.75rem 2rem;
    position: relative; overflow: hidden;
    border: 1px solid var(--ind-800);
    box-shadow: var(--shadow-lg);
}
.prm-hero::before {
    content:''; position:absolute; top:0; left:0; right:0; height:3px;
    background: linear-gradient(90deg, var(--teal-400), var(--teal-500), var(--teal-400));
}
.prm-hero-grid {
    position:absolute; inset:0; pointer-events:none;
    background:
        linear-gradient(rgba(255,255,255,.025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.025) 1px, transparent 1px);
    background-size:28px 28px;
}
.prm-hero-glow {
    position:absolute; width:300px; height:300px; top:-100px; right:-60px; border-radius:50%; pointer-events:none;
    background: radial-gradient(circle, rgba(20,184,166,.18) 0%, transparent 65%);
}
.prm-hero-body {
    display:flex; align-items:center; gap:1.25rem; position:relative; z-index:1;
}
.prm-hero-avatar {
    width:64px; height:64px; border-radius:50%; flex-shrink:0;
    border:3px solid rgba(255,255,255,.25); object-fit:cover;
    box-shadow: 0 4px 16px rgba(0,0,0,.25);
}
.prm-hero-text { flex:1; }
.prm-hero-name {
    font-family:var(--font-d); font-size:1.375rem; font-weight:400;
    color:white; margin:0 0 .375rem; letter-spacing:.01em;
}
.prm-hero-chips { display:flex; align-items:center; gap:.5rem; flex-wrap:wrap; }
.prm-hero-chip {
    display:inline-flex; align-items:center; gap:.375rem;
    padding:.2875rem .75rem;
    background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.15);
    border-radius:9999px; backdrop-filter:blur(6px);
    font-size:.75rem; color:rgba(255,255,255,.8);
}
.prm-hero-chip svg { width:12px; height:12px; }
.prm-hero-nav {
    display:flex; gap:.375rem; flex-shrink:0;
}
.prm-hnav {
    display:inline-flex; align-items:center; gap:.375rem;
    padding:.5rem 1rem; border-radius:var(--r-md);
    font-size:.75rem; font-weight:600; cursor:pointer;
    border:none; text-decoration:none;
    background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.15);
    color:rgba(255,255,255,.8); transition:all .2s; backdrop-filter:blur(6px);
}
.prm-hnav:hover { background:rgba(255,255,255,.18); color:white; }
.prm-hnav svg { width:13px; height:13px; }

/* ===== SECTION CARDS ===== */
.prm-card {
    background: var(--surface);
    border-radius: var(--r-xl);
    border: 1px solid var(--border);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    transition: all .3s;
    position: relative;
}
.prm-card::before {
    content:''; position:absolute; top:0; left:0; right:0; height:3px;
    background: var(--cc, var(--ind-500));
    transform:scaleX(0); transform-origin:left;
    transition:transform .35s cubic-bezier(.4,0,.2,1);
}
.prm-card:hover { box-shadow:var(--shadow-md); }
.prm-card:hover::before { transform:scaleX(1); }
.prm-card.cc-indigo { --cc:var(--ind-500); }
.prm-card.cc-teal   { --cc:var(--teal-500); }
.prm-card.cc-violet { --cc:#7c3aed; }
.prm-card.cc-amber  { --cc:#f59e0b; }
.prm-card.cc-rose   { --cc:#e11d48; }

.prm-card-head {
    display:flex; align-items:center; justify-content:space-between;
    padding:1.125rem 1.375rem; border-bottom:1px solid var(--border);
}
.prm-card-title {
    display:flex; align-items:center; gap:.75rem;
    margin:0; font-family:var(--font-d); font-size:.9375rem; font-weight:400; color:var(--text);
}
.prm-ci {
    width:38px; height:38px; border-radius:var(--r-md); flex-shrink:0;
    display:flex; align-items:center; justify-content:center;
}
.prm-ci svg { width:18px; height:18px; }
.prm-ci.indigo { background:linear-gradient(135deg,var(--ind-500),var(--ind-600)); color:white; box-shadow:0 4px 12px rgba(99,102,241,.2); }
.prm-ci.teal   { background:linear-gradient(135deg,var(--teal-500),var(--teal-600)); color:white; box-shadow:0 4px 12px rgba(20,184,166,.2); }
.prm-ci.violet { background:linear-gradient(135deg,#7c3aed,#8b5cf6); color:white; box-shadow:0 4px 12px rgba(124,58,237,.2); }
.prm-ci.amber  { background:linear-gradient(135deg,#f59e0b,#d97706); color:white; box-shadow:0 4px 12px rgba(245,158,11,.2); }
.prm-ci.rose   { background:linear-gradient(135deg,#e11d48,#be123c); color:white; box-shadow:0 4px 12px rgba(225,29,72,.2); }
.prm-card-sub { font-size:.75rem; color:var(--text-2); margin-top:.125rem; }

.prm-card-body { padding:1.375rem; }

/* ===== ACCOUNT INFO ===== */
.prm-account-row {
    display:flex; align-items:center; gap:1rem;
    padding:1rem; background:var(--bg); border-radius:var(--r-lg);
    border:1px solid var(--border); margin-bottom:1rem;
}
.prm-account-row:last-child { margin-bottom:0; }
.prm-account-icon {
    width:40px; height:40px; border-radius:var(--r-md); flex-shrink:0;
    display:flex; align-items:center; justify-content:center;
    background:var(--ind-50); color:var(--ind-500); border:1px solid var(--ind-100);
}
.prm-account-icon svg { width:18px; height:18px; }
.prm-account-info { flex:1; min-width:0; }
.prm-account-label {
    font-size:.625rem; font-weight:700; text-transform:uppercase; letter-spacing:.8px;
    color:var(--text-3); margin-bottom:.25rem;
}
.prm-account-val {
    font-size:.875rem; font-weight:600; color:var(--text); font-family:var(--font-m);
    white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
}
.prm-account-badge {
    font-size:.6875rem; font-weight:600; padding:.25rem .625rem;
    background:var(--bg); border:1px solid var(--border); border-radius:9999px;
    color:var(--text-3); flex-shrink:0;
}

/* ===== FORM ===== */
.prm-fg { margin-bottom:1.125rem; }
.prm-fg:last-child { margin-bottom:0; }

.prm-label {
    display:flex; align-items:center; gap:.375rem;
    font-size:.6875rem; font-weight:700; color:var(--text);
    text-transform:uppercase; letter-spacing:.5px; margin-bottom:.5rem;
}
.prm-label svg { width:12px; height:12px; color:var(--ind-400); }

.prm-row { display:grid; grid-template-columns:repeat(2,1fr); gap:1rem; }

.prm-input-wrap { position:relative; }

.prm-input {
    width:100%; padding:.6875rem 1rem;
    border:1px solid var(--border); border-radius:var(--r-md);
    font-size:.875rem; color:var(--text); background:var(--bg);
    transition:all .2s; font-family:inherit;
}
.prm-input:focus {
    outline:none; border-color:var(--teal-400);
    box-shadow:0 0 0 3px var(--teal-50); background:var(--surface);
}
.prm-input::placeholder { color:var(--text-3); }
.prm-input:disabled { background:var(--bg); cursor:not-allowed; color:var(--text-2); }
.prm-input.has-toggle { padding-right:3rem; }

.prm-hint {
    font-size:.6875rem; color:var(--text-3); margin-top:.375rem;
    display:flex; align-items:center; gap:.25rem;
}
.prm-hint svg { width:11px; height:11px; flex-shrink:0; }

.prm-eye {
    position:absolute; right:.75rem; top:50%; transform:translateY(-50%);
    background:none; border:none; color:var(--text-3); cursor:pointer;
    display:flex; align-items:center; justify-content:center;
    padding:.25rem; border-radius:var(--r-sm); transition:color .2s;
}
.prm-eye:hover { color:var(--text); }
.prm-eye svg { width:16px; height:16px; }

/* ===== PASSWORD STRENGTH ===== */
.prm-strength {
    margin-top:.625rem; display:none;
}
.prm-strength.visible { display:block; animation: fadeIn .3s ease; }
@keyframes fadeIn { from { opacity:0; } to { opacity:1; } }

.prm-strength-bars {
    display:flex; gap:3px; margin-bottom:.375rem;
}
.prm-strength-bar {
    flex:1; height:4px; border-radius:9999px;
    background:var(--border); transition:background .3s;
}
.prm-strength-bar.active.s1 { background:#e11d48; }
.prm-strength-bar.active.s2 { background:#f59e0b; }
.prm-strength-bar.active.s3 { background:var(--teal-500); }
.prm-strength-label { font-size:.6875rem; font-weight:600; color:var(--text-3); }
.prm-strength-label.s1 { color:#e11d48; }
.prm-strength-label.s2 { color:#f59e0b; }
.prm-strength-label.s3 { color:var(--teal-600); }

/* ===== SUBMIT ===== */
.prm-submit {
    display:flex; align-items:center; justify-content:center; gap:.5rem;
    width:100%; padding:.75rem 1.5rem; margin-top:1.25rem;
    background:linear-gradient(135deg,var(--teal-500),var(--teal-600));
    color:white; border:none; border-radius:var(--r-md);
    font-size:.875rem; font-weight:600; cursor:pointer;
    transition:all .25s; font-family:inherit; letter-spacing:.01em;
    box-shadow:0 4px 16px rgba(20,184,166,.25);
}
.prm-submit:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(20,184,166,.35); }
.prm-submit svg { width:15px; height:15px; }

/* ===== TOGGLE ===== */
.prm-toggle-row {
    display:flex; align-items:center; gap:1rem;
    padding:1rem 0; border-bottom:1px solid var(--border);
    transition:all .2s;
}
.prm-toggle-row:first-child { padding-top:0; }
.prm-toggle-row:last-child  { border-bottom:none; padding-bottom:0; }

.prm-toggle-icon {
    width:38px; height:38px; border-radius:var(--r-md); flex-shrink:0;
    display:flex; align-items:center; justify-content:center;
    transition:all .2s;
}
.prm-toggle-icon svg { width:17px; height:17px; }
.notif-email  .prm-toggle-icon { background:var(--ind-50);  color:var(--ind-500);  }
.notif-conges .prm-toggle-icon { background:var(--teal-50); color:var(--teal-600); }
.notif-paie   .prm-toggle-icon { background:rgba(124,58,237,.08); color:#7c3aed;   }
.notif-email.is-on  .prm-toggle-icon { background:linear-gradient(135deg,var(--ind-500),var(--ind-600)); color:white; box-shadow:0 4px 10px rgba(99,102,241,.2); }
.notif-conges.is-on .prm-toggle-icon { background:linear-gradient(135deg,var(--teal-500),var(--teal-600)); color:white; box-shadow:0 4px 10px rgba(20,184,166,.2); }
.notif-paie.is-on   .prm-toggle-icon { background:linear-gradient(135deg,#7c3aed,#8b5cf6); color:white; box-shadow:0 4px 10px rgba(124,58,237,.2); }

.prm-toggle-info { flex:1; }
.prm-toggle-label { font-size:.875rem; font-weight:600; color:var(--text); }
.prm-toggle-desc  { font-size:.75rem; color:var(--text-2); margin-top:.2rem; }

/* Custom toggle switch */
.prm-switch { position:relative; width:50px; height:26px; flex-shrink:0; }
.prm-switch input { opacity:0; width:0; height:0; }
.prm-switch-track {
    position:absolute; inset:0; cursor:pointer;
    background:var(--border); border-radius:26px;
    transition:all .3s cubic-bezier(.4,0,.2,1);
}
.prm-switch-track::before {
    content:''; position:absolute;
    width:20px; height:20px; left:3px; top:3px;
    background:white; border-radius:50%;
    transition:all .3s cubic-bezier(.4,0,.2,1);
    box-shadow:0 1px 4px rgba(0,0,0,.2);
}
.prm-switch input:checked + .prm-switch-track { background:var(--teal-500); }
.prm-switch input:checked + .prm-switch-track::before { transform:translateX(24px); }
.prm-switch input:focus + .prm-switch-track { box-shadow:0 0 0 3px var(--teal-50); }

/* ===== SECURITY INFO ===== */
.prm-sec-grid {
    display:grid; grid-template-columns:repeat(2,1fr); gap:.75rem; margin-bottom:1.125rem;
}
.prm-sec-item {
    padding:.875rem 1rem; background:var(--bg);
    border-radius:var(--r-md); border:1px solid var(--border);
}
.prm-sec-item-label {
    font-size:.625rem; font-weight:700; text-transform:uppercase; letter-spacing:.8px;
    color:var(--text-3); margin-bottom:.35rem;
}
.prm-sec-item-val {
    font-size:.8125rem; font-weight:600; color:var(--text); font-family:var(--font-m);
    display:flex; align-items:center; gap:.375rem;
}
.prm-sec-item-val .dot {
    width:7px; height:7px; border-radius:50%; flex-shrink:0;
}
.dot-green { background:var(--teal-500); box-shadow:0 0 0 3px rgba(20,184,166,.2); }
.dot-amber { background:#f59e0b; }

.prm-info-banner {
    padding:1rem 1.125rem; background:var(--bg);
    border-radius:var(--r-md); border:1px solid var(--border);
    border-left:4px solid var(--ind-400);
    display:flex; align-items:flex-start; gap:.75rem;
}
.prm-info-banner svg { width:18px; height:18px; color:var(--ind-500); flex-shrink:0; margin-top:.125rem; }
.prm-info-banner-text { font-size:.8125rem; color:var(--text-2); line-height:1.5; }

/* ===== DANGER ZONE ===== */
.prm-danger-row {
    display:flex; align-items:center; gap:1rem;
    padding:1rem; background:var(--bg);
    border-radius:var(--r-md); border:1px solid var(--border);
}
.prm-danger-info { flex:1; }
.prm-danger-title { font-size:.875rem; font-weight:600; color:var(--text); margin-bottom:.125rem; }
.prm-danger-desc  { font-size:.75rem; color:var(--text-2); }
.prm-danger-btn {
    display:inline-flex; align-items:center; gap:.375rem;
    padding:.5rem 1rem; border-radius:var(--r-md);
    font-size:.8125rem; font-weight:600; cursor:pointer;
    border:1.5px solid #fecdd3; background:#fff1f2; color:#be123c;
    transition:all .2s; flex-shrink:0; font-family:inherit;
}
.prm-danger-btn:hover { background:#ffe4e6; border-color:#fda4af; transform:translateY(-1px); }
.prm-danger-btn svg { width:14px; height:14px; }

/* ===== RESPONSIVE ===== */
@media (max-width: 640px) {
    .prm-row { grid-template-columns:1fr; }
    .prm-sec-grid { grid-template-columns:1fr; }
    .prm-hero-body { flex-direction:column; align-items:flex-start; gap:1rem; }
    .prm-hero-nav { width:100%; }
    .prm-hnav { flex:1; justify-content:center; }
    .prm-danger-row { flex-direction:column; align-items:flex-start; }
    .prm-danger-btn { width:100%; justify-content:center; }
}
</style>
@endsection

@section('content')
<div class="prm-page">

    {{-- TOASTS --}}
    @if(session('success'))
    <div class="prm-toast success" id="successToast">
        <div class="prm-toast-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg></div>
        <div class="prm-toast-body">
            <div class="prm-toast-title">Modification enregistree</div>
            <div class="prm-toast-msg">{{ session('success') }}</div>
        </div>
        <button class="prm-toast-close" onclick="closeToast('successToast')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        <div class="prm-toast-bar"></div>
    </div>
    @endif
    @if($errors->any())
    <div class="prm-toast error" id="errorToast">
        <div class="prm-toast-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></div>
        <div class="prm-toast-body">
            <div class="prm-toast-title">Erreur</div>
            <div class="prm-toast-msg">{{ $errors->first() }}</div>
        </div>
        <button class="prm-toast-close" onclick="closeToast('errorToast')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        <div class="prm-toast-bar"></div>
    </div>
    @endif

    {{-- HERO --}}
    <section class="prm-hero">
        <div class="prm-hero-grid"></div>
        <div class="prm-hero-glow"></div>
        <div class="prm-hero-body">
            <img src="{{ $personnel->photo_url }}" alt="{{ $personnel->nom_complet }}" class="prm-hero-avatar">
            <div class="prm-hero-text">
                <h1 class="prm-hero-name">Parametres du compte</h1>
                <div class="prm-hero-chips">
                    <span class="prm-hero-chip">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        {{ $personnel->nom_complet }}
                    </span>
                    <span class="prm-hero-chip">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        {{ $user->email }}
                    </span>
                </div>
            </div>
            <nav class="prm-hero-nav">
                <a href="{{ route('espace-employe.profil') }}" class="prm-hnav">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    Mon profil
                </a>
            </nav>
        </div>
    </section>

    {{-- COMPTE --}}
    <article class="prm-card cc-indigo">
        <header class="prm-card-head">
            <h2 class="prm-card-title">
                <span class="prm-ci indigo">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                </span>
                <div>
                    Informations du compte
                    <div class="prm-card-sub">Identifiants de connexion au portail</div>
                </div>
            </h2>
        </header>
        <div class="prm-card-body">
            <div class="prm-account-row">
                <div class="prm-account-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                </div>
                <div class="prm-account-info">
                    <div class="prm-account-label">Nom complet</div>
                    <div class="prm-account-val">{{ $user->name }}</div>
                </div>
                <span class="prm-account-badge">Non modifiable</span>
            </div>
            <div class="prm-account-row">
                <div class="prm-account-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                </div>
                <div class="prm-account-info">
                    <div class="prm-account-label">Adresse e-mail</div>
                    <div class="prm-account-val">{{ $user->email }}</div>
                </div>
                <span class="prm-account-badge">Non modifiable</span>
            </div>
            <div class="prm-info-banner" style="margin-top:1rem;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                <p class="prm-info-banner-text">Ces informations sont gerees par votre administrateur RH. Pour toute modification, veuillez adresser votre demande via le formulaire de demandes.</p>
            </div>
        </div>
    </article>

    {{-- MOT DE PASSE --}}
    <article class="prm-card cc-violet">
        <header class="prm-card-head">
            <h2 class="prm-card-title">
                <span class="prm-ci violet">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                </span>
                <div>
                    Mot de passe
                    <div class="prm-card-sub">Modifiez votre mot de passe de connexion</div>
                </div>
            </h2>
        </header>
        <div class="prm-card-body">
            <form action="{{ route('espace-employe.password.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="prm-fg">
                    <label class="prm-label">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        Mot de passe actuel
                    </label>
                    <div class="prm-input-wrap">
                        <input type="password" name="current_password" id="currentPwd" class="prm-input has-toggle" placeholder="Entrez votre mot de passe actuel" required>
                        <button type="button" class="prm-eye" onclick="toggleEye('currentPwd','eyeIcon0')">
                            <svg id="eyeIcon0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </button>
                    </div>
                </div>

                <div class="prm-row">
                    <div class="prm-fg">
                        <label class="prm-label">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                            Nouveau mot de passe
                        </label>
                        <div class="prm-input-wrap">
                            <input type="password" name="password" id="newPwd" class="prm-input has-toggle" placeholder="8 caracteres minimum" required oninput="checkStrength(this.value)">
                            <button type="button" class="prm-eye" onclick="toggleEye('newPwd','eyeIcon1')">
                                <svg id="eyeIcon1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </button>
                        </div>
                        {{-- Strength meter --}}
                        <div class="prm-strength" id="strengthMeter">
                            <div class="prm-strength-bars">
                                <div class="prm-strength-bar" id="sb1"></div>
                                <div class="prm-strength-bar" id="sb2"></div>
                                <div class="prm-strength-bar" id="sb3"></div>
                            </div>
                            <div class="prm-strength-label" id="strengthLabel">Faible</div>
                        </div>
                    </div>

                    <div class="prm-fg">
                        <label class="prm-label">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                            Confirmation
                        </label>
                        <div class="prm-input-wrap">
                            <input type="password" name="password_confirmation" id="confirmPwd" class="prm-input has-toggle" placeholder="Repetez le nouveau mot de passe" required oninput="checkMatch()">
                            <button type="button" class="prm-eye" onclick="toggleEye('confirmPwd','eyeIcon2')">
                                <svg id="eyeIcon2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </button>
                        </div>
                        <div class="prm-hint" id="matchHint" style="display:none;"></div>
                    </div>
                </div>

                <button type="submit" class="prm-submit">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    Mettre a jour le mot de passe
                </button>
            </form>
        </div>
    </article>

    {{-- NOTIFICATIONS --}}
    <article class="prm-card cc-teal">
        <header class="prm-card-head">
            <h2 class="prm-card-title">
                <span class="prm-ci teal">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                </span>
                <div>
                    Notifications
                    <div class="prm-card-sub">Gerez vos preferences de notifications</div>
                </div>
            </h2>
        </header>
        <div class="prm-card-body">

            <div class="prm-toggle-row notif-email is-on" id="tr-email">
                <div class="prm-toggle-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                </div>
                <div class="prm-toggle-info">
                    <div class="prm-toggle-label">Notifications par e-mail</div>
                    <div class="prm-toggle-desc">Recevez des mises a jour importantes sur votre compte</div>
                </div>
                <label class="prm-switch">
                    <input type="checkbox" checked onchange="toggleRow('tr-email',this)">
                    <span class="prm-switch-track"></span>
                </label>
            </div>

            <div class="prm-toggle-row notif-conges is-on" id="tr-conges">
                <div class="prm-toggle-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                </div>
                <div class="prm-toggle-info">
                    <div class="prm-toggle-label">Rappels de conges</div>
                    <div class="prm-toggle-desc">Rappels avant l'expiration de vos soldes de conges</div>
                </div>
                <label class="prm-switch">
                    <input type="checkbox" checked onchange="toggleRow('tr-conges',this)">
                    <span class="prm-switch-track"></span>
                </label>
            </div>

            <div class="prm-toggle-row notif-paie is-on" id="tr-paie">
                <div class="prm-toggle-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                </div>
                <div class="prm-toggle-info">
                    <div class="prm-toggle-label">Nouveaux bulletins de paie</div>
                    <div class="prm-toggle-desc">Alerte lorsqu'un nouveau bulletin est disponible</div>
                </div>
                <label class="prm-switch">
                    <input type="checkbox" checked onchange="toggleRow('tr-paie',this)">
                    <span class="prm-switch-track"></span>
                </label>
            </div>

        </div>
    </article>

    {{-- SECURITE --}}
    <article class="prm-card cc-amber">
        <header class="prm-card-head">
            <h2 class="prm-card-title">
                <span class="prm-ci amber">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                </span>
                <div>
                    Securite du compte
                    <div class="prm-card-sub">Etat de la securite et informations de session</div>
                </div>
            </h2>
        </header>
        <div class="prm-card-body">
            <div class="prm-sec-grid">
                <div class="prm-sec-item">
                    <div class="prm-sec-item-label">Statut du compte</div>
                    <div class="prm-sec-item-val">
                        <span class="dot dot-green"></span>
                        Actif et securise
                    </div>
                </div>
                <div class="prm-sec-item">
                    <div class="prm-sec-item-label">Derniere connexion</div>
                    <div class="prm-sec-item-val">{{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() : 'Maintenant' }}</div>
                </div>
                <div class="prm-sec-item">
                    <div class="prm-sec-item-label">Authentification 2FA</div>
                    <div class="prm-sec-item-val">
                        <span class="dot dot-amber"></span>
                        Non activee
                    </div>
                </div>
                <div class="prm-sec-item">
                    <div class="prm-sec-item-label">Compte cree le</div>
                    <div class="prm-sec-item-val">{{ $user->created_at->format('d/m/Y') }}</div>
                </div>
            </div>
            <div class="prm-info-banner">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                <p class="prm-info-banner-text">Pour activer l'authentification a deux facteurs (2FA) ou pour toute demande de securite avancee, veuillez contacter votre administrateur RH.</p>
            </div>
        </div>
    </article>

    {{-- ZONE DANGER --}}
    <article class="prm-card cc-rose">
        <header class="prm-card-head">
            <h2 class="prm-card-title">
                <span class="prm-ci rose">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                </span>
                <div>
                    Zone sensible
                    <div class="prm-card-sub">Actions irreversibles sur votre compte</div>
                </div>
            </h2>
        </header>
        <div class="prm-card-body">
            <div class="prm-danger-row">
                <div class="prm-danger-info">
                    <div class="prm-danger-title">Se deconnecter de toutes les sessions</div>
                    <div class="prm-danger-desc">Ferme toutes les sessions actives sur tous les appareils</div>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="flex-shrink:0;">
                    @csrf
                    <button type="submit" class="prm-danger-btn" onclick="return confirm('Confirmer la deconnexion de toutes les sessions ?')">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        Deconnexion
                    </button>
                </form>
            </div>
        </div>
    </article>

</div><!-- /prm-page -->
@endsection

@section('scripts')
<script>
/* ===== Toast auto-dismiss ===== */
function closeToast(id) {
    const t = document.getElementById(id);
    if(t){ t.classList.add('hiding'); setTimeout(() => t.remove(), 300); }
}
document.querySelectorAll('.prm-toast').forEach(t => {
    setTimeout(() => { t.classList.add('hiding'); setTimeout(() => t.remove(), 300); }, 5000);
});

/* ===== Eye toggle ===== */
function toggleEye(inputId, iconId) {
    const inp = document.getElementById(inputId);
    const ico = document.getElementById(iconId);
    if(!inp) return;
    if(inp.type === 'password') {
        inp.type = 'text';
        ico.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
    } else {
        inp.type = 'password';
        ico.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
    }
}

/* ===== Password strength ===== */
function checkStrength(val) {
    const meter = document.getElementById('strengthMeter');
    const label = document.getElementById('strengthLabel');
    const bars = [document.getElementById('sb1'), document.getElementById('sb2'), document.getElementById('sb3')];

    if(!val) { meter.classList.remove('visible'); return; }
    meter.classList.add('visible');

    let score = 0;
    if(val.length >= 8) score++;
    if(/[A-Z]/.test(val) && /[0-9]/.test(val)) score++;
    if(/[^A-Za-z0-9]/.test(val) && val.length >= 12) score++;

    const cls = ['s1','s2','s3'][score - 1] || 's1';
    const labels = ['Faible', 'Moyen', 'Fort'];

    bars.forEach((b,i) => {
        b.className = 'prm-strength-bar';
        if(i < score) b.classList.add('active', cls);
    });
    label.className = 'prm-strength-label ' + cls;
    label.textContent = labels[score - 1] || 'Faible';
}

/* ===== Match check ===== */
function checkMatch() {
    const np = document.getElementById('newPwd').value;
    const cp = document.getElementById('confirmPwd').value;
    const hint = document.getElementById('matchHint');
    if(!cp) { hint.style.display='none'; return; }
    if(np === cp) {
        hint.style.display='flex';
        hint.style.color='var(--teal-600)';
        hint.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="11" height="11"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg> Les mots de passe correspondent';
    } else {
        hint.style.display='flex';
        hint.style.color='#e11d48';
        hint.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="11" height="11"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg> Les mots de passe ne correspondent pas';
    }
}

/* ===== Toggle notif rows ===== */
function toggleRow(rowId, checkbox) {
    const row = document.getElementById(rowId);
    if(!row) return;
    if(checkbox.checked) row.classList.add('is-on');
    else row.classList.remove('is-on');
}
</script>
@endsection
