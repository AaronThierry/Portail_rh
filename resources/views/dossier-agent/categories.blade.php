@extends('layouts.app')

@section('title', 'Répertoires Documents')
@section('page-title', 'Répertoires')
@section('page-subtitle', 'Organisez les catégories de documents')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
</svg>
@endsection

@section('styles')
<style>
/* ============================================================
   RÉPERTOIRES — Indigo × Teal Charter
   Syne · DM Sans · DM Mono · Color-aura cards
   ============================================================ */

:root {
    --rc-ind:      #6366f1;
    --rc-ind-dk:   #4338ca;
    --rc-ind-pale: rgba(99,102,241,.10);
    --rc-ind-wash: rgba(99,102,241,.05);
    --rc-teal:     #14b8a6;
    --rc-teal-dk:  #0d9488;
    --rc-teal-pale:rgba(20,184,166,.10);
    --rc-amber:    #f59e0b;
    --rc-amber-pale:rgba(245,158,11,.10);
    --rc-red:      #ef4444;
    --rc-red-pale: rgba(239,68,68,.10);
    --rc-green:    #10b981;
    --rc-surf:     #ffffff;
    --rc-bg:       #f8fafc;
    --rc-text:     #1e293b;
    --rc-text2:    #64748b;
    --rc-text3:    #94a3b8;
    --rc-bdr:      #e2e8f0;
    --rc-bdr2:     #f1f5f9;
    --rc-sh-sm:    0 1px 3px rgba(0,0,0,.05);
    --rc-sh-md:    0 4px 12px rgba(0,0,0,.07);
    --rc-sh-lg:    0 14px 32px rgba(0,0,0,.10);
    --rc-r:  12px;
    --rc-rl: 16px;
    --rc-rx: 20px;
}

.dark {
    --rc-surf:  #1e293b; --rc-bg:  #0f172a;
    --rc-text:  #f1f5f9; --rc-text2:#94a3b8; --rc-text3:#64748b;
    --rc-bdr:   #334155; --rc-bdr2: #1e293b;
    --rc-sh-sm: 0 1px 3px rgba(0,0,0,.3);
    --rc-sh-md: 0 4px 12px rgba(0,0,0,.4);
    --rc-sh-lg: 0 14px 32px rgba(0,0,0,.5);
}

/* ── Animations ── */
@keyframes rc-up    { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:none} }
@keyframes rc-scale { from{opacity:0;transform:scale(.96)}       to{opacity:1;transform:none} }
@keyframes rc-down  { from{opacity:0;transform:translateY(-10px) scale(.98)} to{opacity:1;transform:none} }
@keyframes rc-shimmer { 0%{background-position:-400px 0} 100%{background-position:400px 0} }

/* ── Page ── */
.rc-page {
    font-family: 'DM Sans', sans-serif;
    max-width: 1440px;
    margin: 0 auto;
    padding: 0 1.5rem 3rem;
    animation: rc-up .4s cubic-bezier(.16,1,.3,1);
}

/* ══════════════════════════════
   BREADCRUMB
══════════════════════════════ */
.rc-breadcrumb {
    display: flex; align-items: center; gap: .5rem;
    margin-bottom: 1.25rem;
    font-size: .8125rem; font-weight: 500;
}
.rc-breadcrumb a {
    color: var(--rc-text2); text-decoration: none;
    display: flex; align-items: center; gap: .35rem;
    transition: color .2s ease;
}
.rc-breadcrumb a:hover { color: var(--rc-ind); }
.rc-breadcrumb-sep   { color: var(--rc-text3); }
.rc-breadcrumb-current { color: var(--rc-text); font-weight: 600; }

/* ══════════════════════════════
   HERO BANNER
══════════════════════════════ */
.rc-hero {
    position: relative; border-radius: var(--rc-rx);
    overflow: hidden; margin-bottom: 1.75rem;
    animation: rc-up .4s cubic-bezier(.16,1,.3,1) .04s both;
}

.rc-hero-bg {
    background: linear-gradient(135deg, #312e81 0%, #4338ca 40%, #0d9488 100%);
    padding: 1.875rem 2rem;
    position: relative;
}

.rc-hero-bg::before {
    content:''; position:absolute;
    top:-70px; right:-70px;
    width:260px; height:260px;
    background:radial-gradient(circle,rgba(20,184,166,.35) 0%,transparent 70%);
    border-radius:50%; pointer-events:none;
}
.rc-hero-bg::after {
    content:''; position:absolute;
    bottom:-50px; left:-50px;
    width:200px; height:200px;
    background:radial-gradient(circle,rgba(99,102,241,.28) 0%,transparent 70%);
    border-radius:50%; pointer-events:none;
}

.rc-hero-inner {
    position: relative;
    display: flex; align-items: center;
    justify-content: space-between; gap: 1.5rem; flex-wrap: wrap;
}

.rc-hero-left h1 {
    font-family: 'Syne', sans-serif;
    font-size: 1.75rem; font-weight: 700;
    color: #fff; margin: 0 0 .3rem;
    letter-spacing: -.4px; line-height: 1.2;
}

.rc-hero-left p {
    font-size: .875rem; color: rgba(255,255,255,.72); margin: 0;
}

/* KPIs hero */
.rc-hero-kpis {
    background: rgba(255,255,255,.08);
    border: 1px solid rgba(255,255,255,.14);
    border-radius: var(--rc-rl); padding: .875rem 1.5rem;
    display: flex; gap: 2rem;
    backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);
}

.rc-hero-kpi { text-align: center; position: relative; }
.rc-hero-kpi + .rc-hero-kpi::before {
    content: ''; position: absolute;
    left: -1rem; top: 15%; bottom: 15%;
    width: 1px; background: rgba(255,255,255,.15);
}

.rc-hero-kpi-val {
    font-family: 'Syne', sans-serif;
    font-size: 1.5rem; font-weight: 700; color: #fff; line-height: 1;
}
.rc-hero-kpi-lbl {
    font-size: .6875rem; color: rgba(255,255,255,.6);
    text-transform: uppercase; letter-spacing: .5px;
    font-weight: 600; margin-top: .3rem;
}

/* Actions hero */
.rc-hero-actions { display: flex; gap: .625rem; flex-shrink: 0; }

/* Accent bottom */
.rc-hero-accent {
    height: 3px;
    background: linear-gradient(90deg,transparent,rgba(99,102,241,.6),rgba(20,184,166,.8),transparent);
}

/* ══════════════════════════════
   INFO BANNER
══════════════════════════════ */
.rc-info-banner {
    background: var(--rc-ind-wash);
    border: 1px solid var(--rc-ind-pale);
    border-left: 3px solid var(--rc-ind);
    border-radius: var(--rc-rl); padding: 1rem 1.25rem;
    margin-bottom: 1.75rem;
    display: flex; align-items: center; gap: 1rem;
    animation: rc-up .4s cubic-bezier(.16,1,.3,1) .1s both;
}
.rc-info-banner-icon {
    width: 38px; height: 38px;
    background: var(--rc-ind-pale);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: var(--rc-ind); flex-shrink: 0;
}
.rc-info-banner-icon svg { width: 18px; height: 18px; }
.rc-info-banner-content h4 {
    margin: 0 0 .1rem; font-size: .875rem; font-weight: 600; color: var(--rc-text);
}
.rc-info-banner-content p {
    margin: 0; font-size: .8125rem; color: var(--rc-text2); line-height: 1.5;
}

/* ══════════════════════════════
   FLASH
══════════════════════════════ */
.rc-flash {
    padding: 1rem 1.25rem; border-radius: var(--rc-r);
    margin-bottom: 1.5rem;
    display: flex; align-items: center; gap: .75rem;
    font-size: .875rem; font-weight: 500;
    animation: rc-down .4s cubic-bezier(.16,1,.3,1) both;
}
.rc-flash-success {
    background: rgba(16,185,129,.08); color: #065f46;
    border: 1px solid rgba(16,185,129,.2);
}
.rc-flash-error {
    background: var(--rc-red-pale); color: #991b1b;
    border: 1px solid rgba(239,68,68,.2);
}

/* ══════════════════════════════
   BOUTONS
══════════════════════════════ */
.rc-btn {
    display: inline-flex; align-items: center; gap: .5rem;
    padding: .625rem 1.25rem;
    border-radius: var(--rc-r);
    font-family: 'DM Sans', sans-serif;
    font-size: .8125rem; font-weight: 600;
    cursor: pointer; transition: all .22s cubic-bezier(.16,1,.3,1);
    border: 1.5px solid transparent; text-decoration: none; line-height: 1.4;
}
.rc-btn svg { width: 16px; height: 16px; }

.rc-btn-primary {
    background: linear-gradient(135deg, var(--rc-ind), var(--rc-ind-dk));
    color: #fff; box-shadow: 0 4px 14px rgba(99,102,241,.3);
}
.rc-btn-primary:hover {
    color: #fff; transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(99,102,241,.4);
}

.rc-btn-ghost {
    background: rgba(255,255,255,.12);
    border: 1.5px solid rgba(255,255,255,.22);
    color: #fff;
    backdrop-filter: blur(8px);
}
.rc-btn-ghost:hover {
    background: rgba(255,255,255,.2); color: #fff;
}

.rc-btn-outline {
    background: var(--rc-surf); color: var(--rc-text2);
    border-color: var(--rc-bdr);
}
.rc-btn-outline:hover {
    color: var(--rc-ind); border-color: var(--rc-ind);
    background: var(--rc-ind-wash);
}

/* ══════════════════════════════
   GRILLE
══════════════════════════════ */
.rc-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.25rem;
}

/* ══════════════════════════════
   CARTE — touche signature :
   aura de la couleur propre de la catégorie
══════════════════════════════ */
.rc-card {
    background: var(--rc-surf);
    border: 1px solid var(--rc-bdr);
    border-radius: var(--rc-rl);
    overflow: hidden;
    box-shadow: var(--rc-sh-sm);
    transition: all .35s cubic-bezier(.16,1,.3,1);
    animation: rc-scale .35s cubic-bezier(.16,1,.3,1) backwards;
    position: relative;
}

/* Glow aura de la couleur de catégorie — unique touch */
.rc-card::before {
    content: '';
    position: absolute; inset: 0;
    border-radius: var(--rc-rl);
    background: radial-gradient(
        circle at 25% 35%,
        rgba(var(--cat-r,99), var(--cat-g,102), var(--cat-b,241), .07) 0%,
        transparent 65%
    );
    opacity: 0;
    transition: opacity .4s ease;
    pointer-events: none;
    z-index: 0;
}

/* Barre top couleur catégorie */
.rc-card::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg,
        rgba(var(--cat-r,99), var(--cat-g,102), var(--cat-b,241), 1),
        rgba(var(--cat-r,99), var(--cat-g,102), var(--cat-b,241), .5)
    );
    transition: height .3s ease, opacity .3s ease;
}

.rc-card:hover {
    border-color: rgba(var(--cat-r,99), var(--cat-g,102), var(--cat-b,241), .35);
    box-shadow: var(--rc-sh-lg),
                0 0 0 1px rgba(var(--cat-r,99), var(--cat-g,102), var(--cat-b,241), .15);
    transform: translateY(-4px);
}
.rc-card:hover::before { opacity: 1; }
.rc-card:hover::after   { height: 4px; }

.rc-card.rc-card-inactive { opacity: .55; }
.rc-card.rc-card-inactive:hover { opacity: .8; }

/* Contenu au-dessus des pseudo-éléments */
.rc-card > * { position: relative; z-index: 1; }

/* Card header */
.rc-card-header {
    padding: 1.375rem 1.375rem 0;
    display: flex; align-items: flex-start; gap: 1rem;
}

.rc-card-icon {
    width: 50px; height: 50px;
    border-radius: var(--rc-r);
    display: flex; align-items: center; justify-content: center;
    color: #fff; flex-shrink: 0;
    box-shadow: 0 4px 14px rgba(var(--cat-r,99), var(--cat-g,102), var(--cat-b,241), .3);
    transition: transform .3s cubic-bezier(.16,1,.3,1), box-shadow .3s ease;
}

.rc-card:hover .rc-card-icon {
    transform: scale(1.07);
    box-shadow: 0 8px 22px rgba(var(--cat-r,99), var(--cat-g,102), var(--cat-b,241), .4);
}

.rc-card-icon svg { width: 22px; height: 22px; }

.rc-card-info { flex: 1; min-width: 0; }

.rc-card-name {
    font-family: 'Syne', sans-serif;
    font-size: .9375rem; font-weight: 700;
    color: var(--rc-text); margin: 0 0 .25rem;
    display: flex; align-items: center; gap: .4rem; flex-wrap: wrap;
    transition: color .2s ease;
}
.rc-card:hover .rc-card-name {
    color: rgba(var(--cat-r,99), var(--cat-g,102), var(--cat-b,241), 1);
}

/* Badges */
.rc-badge {
    padding: .15rem .45rem; border-radius: 100px;
    font-size: .5625rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .4px;
    font-family: 'DM Mono', monospace;
}
.rc-badge-required { background: var(--rc-red-pale); color: var(--rc-red); }
.rc-badge-inactive { background: var(--rc-bdr2); color: var(--rc-text3); }

.rc-card-desc {
    font-size: .8125rem; color: var(--rc-text2); margin: 0;
    line-height: 1.45;
    display: -webkit-box; -webkit-line-clamp: 2;
    -webkit-box-orient: vertical; overflow: hidden;
}

/* Card stats */
.rc-card-stats {
    padding: .875rem 1.375rem;
    display: flex; gap: 1.25rem;
}
.rc-card-stat {
    display: flex; align-items: center; gap: .4rem;
    font-size: .75rem; color: var(--rc-text2);
}
.rc-card-stat svg { width: 13px; height: 13px; color: var(--rc-text3); }
.rc-card-stat strong { font-weight: 700; color: var(--rc-text); font-size: .8125rem; }

/* Card actions */
.rc-card-actions {
    padding: .75rem 1.375rem 1.125rem;
    display: flex; gap: .5rem;
    border-top: 1px solid var(--rc-bdr2);
}

.rc-card-btn {
    flex: 1; padding: .5rem .625rem;
    border-radius: 8px; border: 1px solid transparent;
    cursor: pointer; font-size: .75rem; font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    display: flex; align-items: center; justify-content: center;
    gap: .35rem; transition: all .2s cubic-bezier(.16,1,.3,1); line-height: 1;
}
.rc-card-btn svg { width: 13px; height: 13px; }

.rc-card-btn-edit {
    background: rgba(var(--cat-r,99), var(--cat-g,102), var(--cat-b,241), .07);
    color: rgba(var(--cat-r,99), var(--cat-g,102), var(--cat-b,241), 1);
    border-color: rgba(var(--cat-r,99), var(--cat-g,102), var(--cat-b,241), .15);
}
.rc-card-btn-edit:hover {
    background: rgba(var(--cat-r,99), var(--cat-g,102), var(--cat-b,241), .14);
}

.rc-card-btn-toggle {
    background: var(--rc-amber-pale); color: var(--rc-amber);
    border-color: rgba(245,158,11,.15);
}
.rc-card-btn-toggle:hover { background: rgba(245,158,11,.18); }

.rc-card-btn-delete {
    flex: 0; padding: .5rem .625rem;
    background: var(--rc-red-pale); color: var(--rc-red);
    border-color: rgba(239,68,68,.15);
}
.rc-card-btn-delete:hover { background: rgba(239,68,68,.18); }

/* ══════════════════════════════
   EMPTY STATE
══════════════════════════════ */
.rc-empty {
    text-align: center; padding: 4rem 2rem;
    background: var(--rc-surf);
    border: 2px dashed var(--rc-bdr);
    border-radius: var(--rc-rx);
    animation: rc-up .4s cubic-bezier(.16,1,.3,1) both;
}
.rc-empty-icon {
    width: 80px; height: 80px; margin: 0 auto 1.5rem;
    background: var(--rc-ind-pale); border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: var(--rc-ind);
}
.rc-empty-icon svg { width: 36px; height: 36px; }
.rc-empty h3 {
    font-family: 'Syne', sans-serif;
    font-size: 1.375rem; font-weight: 700;
    color: var(--rc-text); margin: 0 0 .5rem;
}
.rc-empty p { color: var(--rc-text2); margin: 0 0 2rem; font-size: .875rem; }

/* ══════════════════════════════
   MODAL
══════════════════════════════ */
.rc-modal-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(15,23,42,.7);
    backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);
    z-index: 10000; align-items: center; justify-content: center;
    padding: 1rem; opacity: 0;
    transition: opacity .3s cubic-bezier(.16,1,.3,1);
}
.rc-modal-overlay.show { display: flex; opacity: 1; }

.rc-modal {
    background: var(--rc-surf); border-radius: var(--rc-rx);
    width: 100%; max-width: 560px; max-height: 92vh;
    overflow: hidden;
    box-shadow: 0 32px 64px -12px rgba(0,0,0,.3), 0 0 0 1px rgba(255,255,255,.05);
    transform: scale(.92) translateY(20px);
    transition: transform .4s cubic-bezier(.16,1,.3,1);
}
.rc-modal-overlay.show .rc-modal { transform: scale(1) translateY(0); }

/* Modal header gradient indigo → teal */
.rc-modal-header {
    background: linear-gradient(135deg, #312e81 0%, #4338ca 55%, #0d9488 100%);
    color: #fff;
    padding: 1.5rem 1.75rem;
    position: relative; overflow: hidden;
}

.rc-modal-header::before {
    content: ''; position: absolute;
    top: -50%; right: -20%;
    width: 250px; height: 250px;
    background: radial-gradient(circle, rgba(99,102,241,.2) 0%, transparent 70%);
    border-radius: 50%; pointer-events: none;
}

.rc-modal-header-content {
    position: relative; z-index: 2;
    display: flex; align-items: center; gap: 1rem;
}

.rc-modal-icon {
    width: 46px; height: 46px;
    background: rgba(255,255,255,.15);
    backdrop-filter: blur(8px);
    border-radius: var(--rc-r);
    display: flex; align-items: center; justify-content: center;
    border: 1px solid rgba(255,255,255,.2);
    flex-shrink: 0;
}
.rc-modal-icon svg { width: 22px; height: 22px; }

.rc-modal-title {
    font-family: 'Syne', sans-serif;
    font-size: 1.125rem; font-weight: 700;
    margin: 0 0 .2rem; letter-spacing: -.2px;
}
.rc-modal-subtitle { margin: 0; font-size: .8125rem; color: rgba(255,255,255,.65); }

.rc-modal-close {
    position: absolute; right: 1.25rem; top: 1.25rem;
    background: rgba(255,255,255,.08);
    border: 1px solid rgba(255,255,255,.14);
    color: rgba(255,255,255,.7);
    width: 34px; height: 34px; border-radius: 10px;
    cursor: pointer; transition: all .2s ease;
    display: flex; align-items: center; justify-content: center;
    z-index: 3;
}
.rc-modal-close:hover {
    background: rgba(239,68,68,.2); border-color: rgba(239,68,68,.4);
    color: #fca5a5; transform: rotate(90deg);
}

.rc-modal-body {
    padding: 1.5rem 1.75rem;
    max-height: calc(92vh - 200px);
    overflow-y: auto;
}
.rc-modal-body::-webkit-scrollbar { width: 4px; }
.rc-modal-body::-webkit-scrollbar-thumb { background: var(--rc-bdr); border-radius: 2px; }

/* ── Formulaire ── */
.rc-form-group { margin-bottom: 1.25rem; }

.rc-form-label {
    display: flex; align-items: center; gap: .4rem;
    font-weight: 600; color: var(--rc-text2);
    margin-bottom: .4rem;
    font-size: .6875rem; text-transform: uppercase; letter-spacing: .4px;
}
.rc-form-label svg { width: 14px; height: 14px; color: var(--rc-ind); }
.rc-required { color: var(--rc-red); font-weight: 700; }

.rc-form-control {
    width: 100%; padding: .65rem 1rem;
    border: 1.5px solid var(--rc-bdr);
    border-radius: var(--rc-r);
    font-size: .875rem; font-family: 'DM Sans', sans-serif;
    color: var(--rc-text); background: var(--rc-surf);
    transition: all .22s cubic-bezier(.16,1,.3,1);
    box-sizing: border-box;
}
.rc-form-control:hover { border-color: #c7d2fe; }
.rc-form-control:focus {
    outline: none;
    border-color: var(--rc-ind);
    box-shadow: 0 0 0 3px var(--rc-ind-pale);
}
.rc-form-control::placeholder { color: var(--rc-text3); }

/* Pickers */
.rc-picker-grid { display: flex; gap: .5rem; flex-wrap: wrap; }

.rc-color-option {
    width: 34px; height: 34px; border-radius: 9px;
    cursor: pointer; border: 3px solid transparent;
    transition: all .22s cubic-bezier(.16,1,.3,1);
}
.rc-color-option:hover { transform: scale(1.14); }
.rc-color-option.selected {
    border-color: var(--rc-text);
    box-shadow: 0 0 0 2px var(--rc-surf), 0 0 0 4px var(--rc-text);
    transform: scale(1.08);
}

.rc-icon-option {
    width: 44px; height: 44px; border-radius: var(--rc-r);
    cursor: pointer; border: 1.5px solid var(--rc-bdr);
    background: var(--rc-bg);
    display: flex; align-items: center; justify-content: center;
    color: var(--rc-text2);
    transition: all .22s cubic-bezier(.16,1,.3,1);
}
.rc-icon-option:hover {
    border-color: var(--rc-ind); color: var(--rc-ind);
    background: var(--rc-ind-wash);
}
.rc-icon-option.selected {
    border-color: var(--rc-ind);
    background: linear-gradient(135deg, var(--rc-ind), var(--rc-ind-dk));
    color: #fff;
    box-shadow: 0 4px 12px rgba(99,102,241,.35);
}

/* Checkbox */
.rc-form-check {
    display: flex; align-items: center; gap: .75rem;
    padding: .875rem 1rem;
    background: var(--rc-bg); border-radius: var(--rc-r);
    border: 1.5px solid transparent;
    cursor: pointer; transition: all .22s ease; margin-top: .5rem;
}
.rc-form-check:hover { background: var(--rc-bdr2); border-color: var(--rc-bdr); }
.rc-form-check.checked { background: var(--rc-ind-wash); border-color: var(--rc-ind); }
.rc-form-check input[type="checkbox"] { display: none; }

.rc-check-box {
    width: 20px; height: 20px; border-radius: 6px;
    border: 2px solid var(--rc-bdr); background: var(--rc-surf);
    display: flex; align-items: center; justify-content: center;
    transition: all .2s; flex-shrink: 0;
}
.rc-form-check.checked .rc-check-box { background: var(--rc-ind); border-color: transparent; }
.rc-check-box svg { width: 12px; height: 12px; color: #fff; opacity: 0; transform: scale(.5); transition: all .2s; }
.rc-form-check.checked .rc-check-box svg { opacity: 1; transform: scale(1); }

.rc-check-label { font-weight: 600; font-size: .8125rem; color: var(--rc-text); }
.rc-check-desc  { font-size: .6875rem; color: var(--rc-text2); margin-top: .125rem; }

.rc-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

/* Modal footer */
.rc-modal-footer {
    padding: 1.125rem 1.75rem;
    background: var(--rc-bg);
    border-top: 1px solid var(--rc-bdr);
    display: flex; gap: .625rem; justify-content: flex-end;
}

.rc-btn-modal {
    display: inline-flex; align-items: center; justify-content: center;
    gap: .5rem; padding: .65rem 1.25rem;
    border-radius: var(--rc-r);
    font-size: .875rem; font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer; transition: all .22s ease;
    border: none; line-height: 1;
}
.rc-btn-modal svg { width: 15px; height: 15px; }

.rc-btn-modal-cancel {
    background: var(--rc-surf); color: var(--rc-text2);
    border: 1.5px solid var(--rc-bdr);
}
.rc-btn-modal-cancel:hover { border-color: var(--rc-ind); color: var(--rc-ind); }

.rc-btn-modal-submit {
    background: linear-gradient(135deg, var(--rc-ind), var(--rc-ind-dk));
    color: #fff;
    box-shadow: 0 4px 14px rgba(99,102,241,.3);
}
.rc-btn-modal-submit:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(99,102,241,.4);
}

/* ── Responsive ── */
@media (max-width: 768px) {
    .rc-hero-inner { flex-direction: column; align-items: flex-start; }
    .rc-hero-kpis  { width: 100%; justify-content: space-around; }
    .rc-hero-actions { width: 100%; }
    .rc-hero-actions .rc-btn { flex: 1; justify-content: center; }
    .rc-grid { grid-template-columns: 1fr; }
    .rc-form-row { grid-template-columns: 1fr; }
}
</style>
@endsection

@section('content')
<div class="rc-page">

    {{-- Breadcrumb --}}
    <div class="rc-breadcrumb">
        <a href="{{ route('admin.dossiers-agents.index') }}">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
            </svg>
            Dossiers Agents
        </a>
        <span class="rc-breadcrumb-sep">/</span>
        <span class="rc-breadcrumb-current">Répertoires Documents</span>
    </div>

    {{-- ══ Hero Banner ══ --}}
    <div class="rc-hero">
        <div class="rc-hero-bg">
            <div class="rc-hero-inner">
                <div class="rc-hero-left">
                    <h1>Répertoires Globaux</h1>
                    <p>Définissez les types de documents pour tous les employés</p>
                </div>

                <div class="rc-hero-kpis">
                    <div class="rc-hero-kpi">
                        <div class="rc-hero-kpi-val" data-count="{{ $categories->count() }}">{{ $categories->count() }}</div>
                        <div class="rc-hero-kpi-lbl">Répertoires</div>
                    </div>
                    <div class="rc-hero-kpi">
                        <div class="rc-hero-kpi-val" data-count="{{ $categories->where('actif', true)->count() }}">{{ $categories->where('actif', true)->count() }}</div>
                        <div class="rc-hero-kpi-lbl">Actifs</div>
                    </div>
                    <div class="rc-hero-kpi">
                        <div class="rc-hero-kpi-val" data-count="{{ $categories->where('obligatoire', true)->count() }}">{{ $categories->where('obligatoire', true)->count() }}</div>
                        <div class="rc-hero-kpi-lbl">Obligatoires</div>
                    </div>
                </div>

                <div class="rc-hero-actions">
                    <button onclick="openCreateModal()" class="rc-btn rc-btn-ghost">
                        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M12 4v16m8-8H4"/>
                        </svg>
                        Nouveau répertoire
                    </button>
                </div>
            </div>
        </div>
        <div class="rc-hero-accent"></div>
    </div>

    {{-- Info banner --}}
    <div class="rc-info-banner">
        <div class="rc-info-banner-icon">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="rc-info-banner-content">
            <h4>Comment fonctionnent les répertoires ?</h4>
            <p>Les répertoires créés ici s'appliquent <strong>globalement à tous les employés</strong>. Chaque employé aura ces mêmes catégories dans son dossier.</p>
        </div>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="rc-flash rc-flash-success">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="rc-flash rc-flash-error">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- Grille --}}
    @if($categories->count() > 0)
    <div class="rc-grid">
        @foreach($categories as $categorie)
        @php
            /* Décomposer la couleur hex en RGB pour les CSS custom props */
            $hex = ltrim($categorie->couleur, '#');
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        @endphp
        <div class="rc-card {{ !$categorie->actif ? 'rc-card-inactive' : '' }}"
             style="animation-delay:{{ $loop->index * 0.05 }}s; --cat-r:{{ $r }}; --cat-g:{{ $g }}; --cat-b:{{ $b }}; --cat-color:{{ $categorie->couleur }}">

            <div class="rc-card-header">
                <div class="rc-card-icon" style="background:{{ $categorie->couleur }};">
                    @include('dossier-agent.partials.icon', ['icon' => $categorie->icone, 'size' => 22])
                </div>
                <div class="rc-card-info">
                    <h3 class="rc-card-name">
                        {{ $categorie->nom }}
                        @if($categorie->obligatoire)
                        <span class="rc-badge rc-badge-required">Requis</span>
                        @endif
                        @if(!$categorie->actif)
                        <span class="rc-badge rc-badge-inactive">Inactif</span>
                        @endif
                    </h3>
                    <p class="rc-card-desc">{{ $categorie->description ?: 'Aucune description' }}</p>
                </div>
            </div>

            <div class="rc-card-stats">
                <div class="rc-card-stat">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <strong>{{ $categorie->documents_count }}</strong> documents
                </div>
                <div class="rc-card-stat">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                    </svg>
                    Ordre <strong>{{ $categorie->ordre }}</strong>
                </div>
            </div>

            <div class="rc-card-actions">
                <button class="rc-card-btn rc-card-btn-edit" onclick="openEditModal({{ json_encode($categorie) }})">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Modifier
                </button>
                <button class="rc-card-btn rc-card-btn-toggle" onclick="toggleCategorie({{ $categorie->id }}, {{ $categorie->actif ? 'false' : 'true' }})">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        @if($categorie->actif)
                        <path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M3 3l18 18"/>
                        @else
                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        @endif
                    </svg>
                    {{ $categorie->actif ? 'Masquer' : 'Activer' }}
                </button>
                @if($categorie->documents_count == 0)
                <button class="rc-card-btn rc-card-btn-delete" onclick="deleteCategorie({{ $categorie->id }}, '{{ addslashes($categorie->nom) }}')" title="Supprimer">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    @else
    <div class="rc-empty">
        <div class="rc-empty-icon">
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
            </svg>
        </div>
        <h3>Aucun répertoire configuré</h3>
        <p>Créez des répertoires pour organiser les documents de vos employés</p>
        <button onclick="initDefaultCategories()" class="rc-btn rc-btn-primary">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
            Initialiser les répertoires par défaut
        </button>
    </div>
    @endif
</div>

{{-- Modal Création / Édition --}}
<div class="rc-modal-overlay" id="categorieModal">
    <div class="rc-modal">
        <div class="rc-modal-header">
            <div class="rc-modal-header-content">
                <div class="rc-modal-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="rc-modal-title" id="modalTitle">Nouveau Répertoire</h3>
                    <p class="rc-modal-subtitle">Configurez les propriétés du répertoire</p>
                </div>
            </div>
            <button class="rc-modal-close" onclick="closeModal()">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="categorieForm" method="POST">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="rc-modal-body">
                <div class="rc-form-group">
                    <label class="rc-form-label">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                        Nom du répertoire <span class="rc-required">*</span>
                    </label>
                    <input type="text" name="nom" id="categorie_nom" class="rc-form-control" required placeholder="Ex : Contrats, Fiches de poste...">
                </div>

                <div class="rc-form-group">
                    <label class="rc-form-label">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                        Description
                    </label>
                    <textarea name="description" id="categorie_description" class="rc-form-control" rows="2" placeholder="Décrivez le type de documents à stocker..."></textarea>
                </div>

                <div class="rc-form-row">
                    <div class="rc-form-group">
                        <label class="rc-form-label">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                            Couleur
                        </label>
                        <div class="rc-picker-grid">
                            @php
                            $colors = ['#667eea','#8b5cf6','#3b82f6','#10b981','#06b6d4','#14b8a6','#f59e0b','#ef4444','#ec4899','#64748b'];
                            @endphp
                            @foreach($colors as $color)
                            <div class="rc-color-option" style="background:{{ $color }};" data-color="{{ $color }}" onclick="selectColor('{{ $color }}')"></div>
                            @endforeach
                        </div>
                        <input type="hidden" name="couleur" id="categorie_couleur" value="#667eea">
                    </div>

                    <div class="rc-form-group">
                        <label class="rc-form-label">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                            </svg>
                            Ordre d'affichage
                        </label>
                        <input type="number" name="ordre" id="categorie_ordre" class="rc-form-control" min="1" value="{{ $categories->count() + 1 }}">
                    </div>
                </div>

                <div class="rc-form-group">
                    <label class="rc-form-label">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="7" height="7" rx="1"/>
                            <rect x="14" y="3" width="7" height="7" rx="1"/>
                            <rect x="3" y="14" width="7" height="7" rx="1"/>
                            <rect x="14" y="14" width="7" height="7" rx="1"/>
                        </svg>
                        Icône
                    </label>
                    <div class="rc-picker-grid">
                        @php
                        $icons = ['folder','briefcase','clipboard-list','id-card','graduation-cap','file-text','heart-pulse','calculator','award','chart-bar'];
                        @endphp
                        @foreach($icons as $icon)
                        <div class="rc-icon-option" data-icon="{{ $icon }}" onclick="selectIcon('{{ $icon }}')">
                            @include('dossier-agent.partials.icon', ['icon' => $icon, 'size' => 20])
                        </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="icone" id="categorie_icone" value="folder">
                </div>

                <label class="rc-form-check" id="obligatoireCheck">
                    <input type="checkbox" name="obligatoire" id="categorie_obligatoire" value="1">
                    <div class="rc-check-box">
                        <svg fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </div>
                    <div>
                        <span class="rc-check-label">Répertoire obligatoire</span>
                        <span class="rc-check-desc">Les documents de ce type sont requis pour chaque employé</span>
                    </div>
                </label>
            </div>

            <div class="rc-modal-footer">
                <button type="button" class="rc-btn-modal rc-btn-modal-cancel" onclick="closeModal()">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Annuler
                </button>
                <button type="submit" class="rc-btn-modal rc-btn-modal-submit">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7"/>
                    </svg>
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
const categorieModal = document.getElementById('categorieModal');
const categorieForm  = document.getElementById('categorieForm');

function openCreateModal() {
    document.getElementById('modalTitle').textContent = 'Nouveau Répertoire';
    document.getElementById('formMethod').value = 'POST';
    categorieForm.action = '{{ route("admin.dossier-agent.categories.store") }}';
    categorieForm.reset();
    selectColor('#667eea');
    selectIcon('folder');
    document.getElementById('categorie_ordre').value = '{{ $categories->count() + 1 }}';
    categorieModal.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function openEditModal(categorie) {
    document.getElementById('modalTitle').textContent = 'Modifier le Répertoire';
    document.getElementById('formMethod').value = 'PUT';
    categorieForm.action = '{{ url("admin/dossier-agent/categories") }}/' + categorie.id;
    document.getElementById('categorie_nom').value         = categorie.nom;
    document.getElementById('categorie_description').value = categorie.description || '';
    document.getElementById('categorie_ordre').value       = categorie.ordre;
    const cb = document.getElementById('categorie_obligatoire');
    cb.checked = categorie.obligatoire;
    updateCheckState(cb);
    selectColor(categorie.couleur);
    selectIcon(categorie.icone);
    categorieModal.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    categorieModal.classList.remove('show');
    document.body.style.overflow = '';
}

function selectColor(color) {
    document.querySelectorAll('.rc-color-option').forEach(el => el.classList.remove('selected'));
    document.querySelector(`.rc-color-option[data-color="${color}"]`)?.classList.add('selected');
    document.getElementById('categorie_couleur').value = color;
}

function selectIcon(icon) {
    document.querySelectorAll('.rc-icon-option').forEach(el => el.classList.remove('selected'));
    document.querySelector(`.rc-icon-option[data-icon="${icon}"]`)?.classList.add('selected');
    document.getElementById('categorie_icone').value = icon;
}

function updateCheckState(checkbox) {
    const w = checkbox.closest('.rc-form-check');
    w.classList.toggle('checked', checkbox.checked);
}

async function toggleCategorie(id, newState) {
    try {
        const res = await fetch('{{ url("admin/dossier-agent/categories") }}/' + id, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ actif: newState })
        });
        const data = await res.json();
        if (data.success) location.reload();
        else alert('Erreur : ' + data.message);
    } catch { alert('Erreur lors de la mise à jour'); }
}

async function deleteCategorie(id, nom) {
    if (!confirm('Supprimer le répertoire "' + nom + '" ?')) return;
    try {
        const res = await fetch('{{ url("admin/dossier-agent/categories") }}/' + id, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        const data = await res.json();
        if (data.success) location.reload();
        else alert('Erreur : ' + data.message);
    } catch { alert('Erreur lors de la suppression'); }
}

async function initDefaultCategories() {
    if (!confirm('Initialiser les 10 répertoires par défaut ?')) return;
    try {
        const res = await fetch('{{ route("admin.dossier-agent.categories.init") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        const data = await res.json();
        if (data.success) location.reload();
        else alert('Erreur : ' + data.message);
    } catch { alert('Erreur lors de l\'initialisation'); }
}

/* Checkbox */
document.querySelectorAll('.rc-form-check input[type="checkbox"]').forEach(cb => {
    cb.addEventListener('change', function() { updateCheckState(this); });
});

/* Modal close */
categorieModal.addEventListener('click', e => { if (e.target === categorieModal) closeModal(); });
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

/* Init */
selectColor('#667eea');
selectIcon('folder');

/* Counter animation hero KPIs */
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.rc-hero-kpi-val[data-count]').forEach(el => {
        const target = parseInt(el.dataset.count) || 0;
        if (!target) return;
        el.textContent = '0';
        const dur = 700, start = performance.now();
        (function tick(now) {
            const p = Math.min((now - start) / dur, 1);
            el.textContent = Math.round(target * (1 - Math.pow(1 - p, 3)));
            if (p < 1) requestAnimationFrame(tick);
        })(start);
    });
});
</script>
@endsection
