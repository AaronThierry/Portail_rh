@extends('layouts.app')

@section('title', 'Dossiers Agents')
@section('page-title', 'Dossiers Agents')
@section('page-subtitle', 'Gérez les documents du personnel')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
</svg>
@endsection

@section('styles')
<style>
/* ============================================================
   DOSSIERS AGENTS — Indigo × Teal Charter
   Syne · DM Sans · DM Mono · Progress Ring Avatar
   ============================================================ */

:root {
    --da-ind:      #6366f1;
    --da-ind-dk:   #4338ca;
    --da-ind-md:   #4f46e5;
    --da-ind-pale: rgba(99,102,241,.12);
    --da-ind-wash: rgba(99,102,241,.06);
    --da-teal:     #14b8a6;
    --da-teal-dk:  #0d9488;
    --da-teal-pale:rgba(20,184,166,.12);
    --da-amber:    #f59e0b;
    --da-amber-pale:rgba(245,158,11,.12);
    --da-red:      #ef4444;
    --da-red-pale: rgba(239,68,68,.12);
    --da-surf:     #ffffff;
    --da-bg:       #f8fafc;
    --da-text:     #1e293b;
    --da-text-2:   #64748b;
    --da-text-3:   #94a3b8;
    --da-border:   #e2e8f0;
    --da-border-2: #f1f5f9;
    --da-sh-sm:    0 1px 3px rgba(0,0,0,.05);
    --da-sh-md:    0 4px 12px rgba(0,0,0,.07);
    --da-sh-lg:    0 12px 28px rgba(0,0,0,.09);
    --da-r:        12px;
    --da-r-lg:     16px;
    --da-r-xl:     20px;
}

.dark {
    --da-surf:     #1e293b;
    --da-bg:       #0f172a;
    --da-text:     #f1f5f9;
    --da-text-2:   #94a3b8;
    --da-text-3:   #64748b;
    --da-border:   #334155;
    --da-border-2: #1e293b;
    --da-sh-sm:    0 1px 3px rgba(0,0,0,.3);
    --da-sh-md:    0 4px 12px rgba(0,0,0,.4);
    --da-sh-lg:    0 12px 28px rgba(0,0,0,.5);
}

/* ── Animations ── */
@keyframes da-up    { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:none} }
@keyframes da-scale { from{opacity:0;transform:scale(.97)}       to{opacity:1;transform:none} }
@keyframes da-glow  { 0%,100%{opacity:.6} 50%{opacity:1} }
@keyframes da-dash  { from{stroke-dashoffset:600} }
@keyframes da-ring-spin { from{transform:rotate(-90deg)} to{transform:rotate(270deg)} }
@keyframes da-shimmer {
    0%   { background-position: -400px 0 }
    100% { background-position:  400px 0 }
}

/* ── Page ── */
.da-page {
    font-family: 'DM Sans', sans-serif;
    max-width: 1440px;
    margin: 0 auto;
    padding: 0 1.5rem 3rem;
    animation: da-up .4s cubic-bezier(.16,1,.3,1);
}

/* ══════════════════════════════════
   HERO BANNER — signature du module
══════════════════════════════════ */
.da-hero {
    position: relative;
    border-radius: var(--da-r-xl);
    overflow: hidden;
    margin-bottom: 1.75rem;
    animation: da-up .4s cubic-bezier(.16,1,.3,1) .05s both;
}

.da-hero-bg {
    background: linear-gradient(135deg, #312e81 0%, #4338ca 45%, #0d9488 100%);
    padding: 2rem 2rem 1.75rem;
    position: relative;
}

/* Orbe glow haut-droite */
.da-hero-bg::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 280px; height: 280px;
    background: radial-gradient(circle, rgba(20,184,166,.35) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}
/* Orbe glow bas-gauche */
.da-hero-bg::after {
    content: '';
    position: absolute;
    bottom: -40px; left: -40px;
    width: 200px; height: 200px;
    background: radial-gradient(circle, rgba(99,102,241,.3) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}

.da-hero-inner {
    position: relative;
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.da-hero-left h1 {
    font-family: 'Syne', sans-serif;
    font-size: 1.75rem;
    font-weight: 700;
    color: #fff;
    margin: 0 0 .35rem;
    letter-spacing: -.4px;
    line-height: 1.2;
}

.da-hero-left p {
    font-size: .875rem;
    color: rgba(255,255,255,.7);
    margin: 0;
}

.da-hero-actions {
    display: flex;
    gap: .625rem;
    flex-shrink: 0;
}

/* Micro stats dans le hero */
.da-hero-kpis {
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(255,255,255,.12);
    border-radius: var(--da-r-lg);
    padding: .875rem 1.5rem;
    display: flex;
    gap: 2rem;
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    animation: da-up .4s cubic-bezier(.16,1,.3,1) .12s both;
}

.da-hero-kpi {
    text-align: center;
    position: relative;
}

.da-hero-kpi + .da-hero-kpi::before {
    content: '';
    position: absolute;
    left: -1rem; top: 10%; bottom: 10%;
    width: 1px;
    background: rgba(255,255,255,.15);
}

.da-hero-kpi-val {
    font-family: 'Syne', sans-serif;
    font-size: 1.5rem;
    font-weight: 700;
    color: #fff;
    line-height: 1;
}

.da-hero-kpi-lbl {
    font-size: .6875rem;
    color: rgba(255,255,255,.6);
    text-transform: uppercase;
    letter-spacing: .5px;
    font-weight: 600;
    margin-top: .3rem;
}

/* ── Ligne accent bottom du hero ── */
.da-hero-accent {
    height: 3px;
    background: linear-gradient(90deg, transparent, rgba(99,102,241,.6), rgba(20,184,166,.8), transparent);
}

/* ══════════════════════════════════
   ALERTES
══════════════════════════════════ */
.da-alerts {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: .875rem;
    margin-bottom: 1.75rem;
    animation: da-up .4s cubic-bezier(.16,1,.3,1) .15s both;
}

.da-alert {
    background: var(--da-surf);
    border: 1px solid var(--da-border);
    border-radius: var(--da-r-lg);
    padding: 1rem 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    position: relative;
    overflow: hidden;
    box-shadow: var(--da-sh-sm);
    transition: all .25s cubic-bezier(.4,0,.2,1);
}

.da-alert::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 4px;
}

.da-alert.danger::before  { background: linear-gradient(180deg, var(--da-red), #b91c1c); }
.da-alert.warning::before { background: linear-gradient(180deg, var(--da-amber), #d97706); }
.da-alert:hover { box-shadow: var(--da-sh-md); transform: translateY(-1px); }

.da-alert-icon {
    width: 40px; height: 40px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}

.da-alert-icon svg { width: 20px; height: 20px; }

.da-alert.danger .da-alert-icon  { background: var(--da-red-pale);   color: var(--da-red); }
.da-alert.warning .da-alert-icon { background: var(--da-amber-pale);  color: var(--da-amber); }

.da-alert-body { flex: 1; }
.da-alert-title { font-size: .875rem; font-weight: 600; color: var(--da-text);   margin: 0; }
.da-alert-desc  { font-size: .75rem;  color: var(--da-text-2); margin: .1rem 0 0; }

.da-alert-count {
    font-family: 'Syne', sans-serif;
    font-size: 1.5rem;
    font-weight: 700;
    padding: 0 .75rem;
}

.da-alert.danger .da-alert-count  { color: var(--da-red); }
.da-alert.warning .da-alert-count { color: var(--da-amber); }

.da-alert-link {
    font-size: .75rem; font-weight: 600;
    text-decoration: none;
    padding: .4rem .75rem;
    border-radius: 8px;
    transition: all .2s ease;
    white-space: nowrap;
}

.da-alert.danger .da-alert-link  { background: var(--da-red-pale);   color: var(--da-red); }
.da-alert.warning .da-alert-link { background: var(--da-amber-pale);  color: var(--da-amber); }
.da-alert-link:hover { transform: translateX(3px); }

/* ══════════════════════════════════
   TOOLBAR
══════════════════════════════════ */
.da-toolbar {
    display: flex;
    align-items: center;
    gap: .75rem;
    margin-bottom: 1.5rem;
    animation: da-up .4s cubic-bezier(.16,1,.3,1) .2s both;
}

.da-search-wrap {
    flex: 1;
    position: relative;
    max-width: 480px;
}

.da-search-wrap svg {
    position: absolute;
    left: 1rem; top: 50%;
    transform: translateY(-50%);
    width: 18px; height: 18px;
    color: var(--da-text-3);
    pointer-events: none;
    transition: color .2s ease;
}

.da-search-wrap:focus-within svg { color: var(--da-ind); }

.da-search-input {
    width: 100%;
    padding: .7rem 1rem .7rem 2.75rem;
    border: 1.5px solid var(--da-border);
    border-radius: var(--da-r);
    font-family: 'DM Sans', sans-serif;
    font-size: .875rem;
    background: var(--da-surf);
    color: var(--da-text);
    transition: all .2s cubic-bezier(.4,0,.2,1);
}

.da-search-input::placeholder { color: var(--da-text-3); }
.da-search-input:hover  { border-color: #c7d2fe; }
.da-search-input:focus  {
    outline: none;
    border-color: var(--da-ind);
    box-shadow: 0 0 0 3px var(--da-ind-pale);
}

.da-toolbar-right {
    display: flex;
    align-items: center;
    gap: .625rem;
    margin-left: auto;
}

.da-count-label {
    font-size: .8125rem;
    color: var(--da-text-2);
    font-weight: 500;
}

.da-count-label strong { color: var(--da-text); font-weight: 700; }

/* ══════════════════════════════════
   BOUTONS
══════════════════════════════════ */
.da-btn {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    padding: .625rem 1.25rem;
    border-radius: var(--da-r);
    font-family: 'DM Sans', sans-serif;
    font-size: .8125rem;
    font-weight: 600;
    cursor: pointer;
    transition: all .2s cubic-bezier(.4,0,.2,1);
    border: 1.5px solid transparent;
    text-decoration: none;
    white-space: nowrap;
    line-height: 1.4;
}

.da-btn svg { width: 16px; height: 16px; flex-shrink: 0; }

.da-btn-primary {
    background: linear-gradient(135deg, var(--da-ind), var(--da-ind-dk));
    color: #fff;
    box-shadow: 0 4px 12px rgba(99,102,241,.3);
}

.da-btn-primary:hover {
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(99,102,241,.4);
}

.da-btn-outline {
    background: var(--da-surf);
    color: var(--da-text-2);
    border-color: var(--da-border);
}

.da-btn-outline:hover {
    color: var(--da-ind);
    border-color: var(--da-ind);
    background: var(--da-ind-wash);
}

.da-btn-warning {
    background: var(--da-amber-pale);
    color: var(--da-amber);
    border-color: rgba(245,158,11,.25);
}

.da-btn-warning:hover {
    background: rgba(245,158,11,.2);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(245,158,11,.2);
}

.da-btn-warning .da-badge-count {
    background: var(--da-amber);
    color: #fff;
    padding: .1rem .45rem;
    border-radius: 20px;
    font-size: .7rem;
    font-weight: 700;
}

/* ══════════════════════════════════
   GRILLE CARTES
══════════════════════════════════ */
.da-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    gap: 1.125rem;
    margin-bottom: 2rem;
}

/* ══════════════════════════════════
   CARTE AGENT
══════════════════════════════════ */
.da-card {
    background: var(--da-surf);
    border: 1px solid var(--da-border);
    border-radius: var(--da-r-lg);
    overflow: hidden;
    transition: all .35s cubic-bezier(.16,1,.3,1);
    position: relative;
    box-shadow: var(--da-sh-sm);
    animation: da-scale .35s cubic-bezier(.16,1,.3,1) backwards;
}

/* Barre top indigo → teal au hover */
.da-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--da-ind), var(--da-teal));
    opacity: 0;
    transition: opacity .3s ease;
}

/* Glow de fond indigo au hover */
.da-card::after {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 50% 0%, var(--da-ind-wash), transparent 70%);
    opacity: 0;
    transition: opacity .4s ease;
    pointer-events: none;
}

.da-card:hover {
    border-color: #c7d2fe;
    box-shadow: var(--da-sh-lg), 0 0 0 1px rgba(99,102,241,.1);
    transform: translateY(-4px);
}

.da-card:hover::before { opacity: 1; }
.da-card:hover::after  { opacity: 1; }

/* ── Card Head ── */
.da-card-head {
    padding: 1.25rem 1.25rem 1rem;
    display: flex;
    align-items: center;
    gap: .875rem;
    border-bottom: 1px solid var(--da-border-2);
    position: relative;
}

/* ══════════════════════════════════
   AVATAR + RING — touche signature
══════════════════════════════════ */
.da-av-wrap {
    position: relative;
    width: 58px;
    height: 58px;
    flex-shrink: 0;
}

/* SVG ring de progression */
.da-ring {
    position: absolute;
    inset: -3px;
    width: calc(100% + 6px);
    height: calc(100% + 6px);
    transform: rotate(-90deg);
    pointer-events: none;
}

.da-ring-bg {
    fill: none;
    stroke: var(--da-border);
    stroke-width: 2.5;
}

.da-ring-fill {
    fill: none;
    stroke-width: 2.5;
    stroke-linecap: round;
    stroke-dasharray: 188.5; /* 2π × 30 */
    transition: stroke-dashoffset 1s cubic-bezier(.16,1,.3,1) .1s,
                stroke .4s ease;
}

/* Shimmer animation on ring */
.da-card:hover .da-ring-fill {
    filter: drop-shadow(0 0 3px currentColor);
}

.da-ring-fill.good { stroke: var(--da-teal); }
.da-ring-fill.mid  { stroke: var(--da-amber); }
.da-ring-fill.low  { stroke: var(--da-red); }

/* Avatar circle */
.da-avatar {
    position: absolute;
    inset: 0;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    font-size: .9375rem;
    overflow: hidden;
    background: linear-gradient(135deg, var(--da-ind), var(--da-ind-dk));
    color: #fff;
    transition: transform .3s cubic-bezier(.16,1,.3,1);
}

.da-card:hover .da-avatar { transform: scale(1.06); }

.da-avatar img {
    width: 100%; height: 100%;
    object-fit: cover;
}

/* Dot statut */
.da-av-dot {
    position: absolute;
    bottom: 1px; right: 1px;
    width: 12px; height: 12px;
    border-radius: 50%;
    border: 2px solid var(--da-surf);
    transition: transform .2s ease;
    z-index: 1;
}

.da-card:hover .da-av-dot { transform: scale(1.2); }
.da-av-dot.ok   { background: var(--da-teal); }
.da-av-dot.warn { background: var(--da-amber); }
.da-av-dot.err  { background: var(--da-red); }

/* ── Identité ── */
.da-card-identity { flex: 1; min-width: 0; }

.da-card-name {
    font-family: 'Syne', sans-serif;
    font-size: .9375rem;
    font-weight: 700;
    color: var(--da-text);
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.3;
    transition: color .2s ease;
}

.da-card:hover .da-card-name { color: var(--da-ind); }

.da-card-meta {
    display: flex;
    gap: .35rem;
    flex-wrap: wrap;
    margin-top: .35rem;
}

.da-card-badge {
    display: inline-flex;
    align-items: center;
    gap: .25rem;
    font-size: .6875rem;
    font-weight: 600;
    padding: .2rem .5rem;
    border-radius: 100px;
    background: var(--da-bg);
    color: var(--da-text-2);
    letter-spacing: .1px;
    font-family: 'DM Mono', monospace;
}

.dark .da-card-badge { background: rgba(255,255,255,.06); }
.da-card-badge svg { width: 11px; height: 11px; }

.da-card-badge.ind {
    background: var(--da-ind-wash);
    color: var(--da-ind);
}

/* ── Card Body ── */
.da-card-body {
    padding: 1rem 1.25rem 1.25rem;
}

/* Pills doc */
.da-doc-row {
    display: flex;
    gap: .5rem;
    margin-bottom: .875rem;
}

.da-doc-pill {
    flex: 1;
    text-align: center;
    padding: .625rem .375rem;
    border-radius: 10px;
    transition: all .2s cubic-bezier(.4,0,.2,1);
    cursor: default;
}

.da-doc-pill:hover { transform: translateY(-2px); }

.da-doc-pill.total   { background: var(--da-ind-wash); }
.da-doc-pill.valid   { background: var(--da-teal-pale); }
.da-doc-pill.expired { background: var(--da-red-pale);  }

.da-doc-pill-val {
    font-family: 'Syne', sans-serif;
    font-size: 1.25rem;
    font-weight: 700;
    line-height: 1;
}

.da-doc-pill.total .da-doc-pill-val   { color: var(--da-ind); }
.da-doc-pill.valid .da-doc-pill-val   { color: var(--da-teal); }
.da-doc-pill.expired .da-doc-pill-val { color: var(--da-red); }

.da-doc-pill-lbl {
    font-size: .625rem;
    color: var(--da-text-2);
    text-transform: uppercase;
    letter-spacing: .5px;
    font-weight: 700;
    margin-top: .25rem;
}

/* Progress bar */
.da-progress {
    height: 4px;
    background: var(--da-border-2);
    border-radius: 2px;
    overflow: hidden;
    margin-bottom: 1rem;
}

.dark .da-progress { background: rgba(255,255,255,.07); }

.da-progress-bar {
    height: 100%;
    border-radius: 2px;
    transition: width .9s cubic-bezier(.16,1,.3,1);
    position: relative;
}

.da-progress-bar::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,.35), transparent);
    background-size: 200% 100%;
    animation: da-shimmer 2s ease-in-out infinite;
}

.da-progress-bar.good { background: linear-gradient(90deg, var(--da-teal), var(--da-teal-dk)); }
.da-progress-bar.mid  { background: linear-gradient(90deg, var(--da-amber), #d97706); }
.da-progress-bar.low  { background: linear-gradient(90deg, var(--da-red),   #b91c1c); }

/* Card Actions */
.da-card-actions { display: flex; gap: .5rem; }

.da-card-link {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .4rem;
    padding: .625rem .75rem;
    background: linear-gradient(135deg, var(--da-ind), var(--da-ind-dk));
    color: #fff;
    border: none;
    border-radius: var(--da-r);
    font-family: 'DM Sans', sans-serif;
    font-size: .8rem;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all .25s cubic-bezier(.16,1,.3,1);
    box-shadow: 0 2px 8px rgba(99,102,241,.25);
}

.da-card-link svg { width: 15px; height: 15px; }

.da-card-link:hover {
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(99,102,241,.35);
}

.da-card-upload {
    width: 40px; height: 40px;
    display: flex; align-items: center; justify-content: center;
    border-radius: var(--da-r);
    border: 1.5px solid var(--da-border);
    background: var(--da-surf);
    color: var(--da-teal);
    cursor: pointer;
    transition: all .25s cubic-bezier(.16,1,.3,1);
    flex-shrink: 0;
}

.da-card-upload svg { width: 18px; height: 18px; }

.da-card-upload:hover {
    background: var(--da-teal-pale);
    border-color: var(--da-teal);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(20,184,166,.2);
}

/* ══════════════════════════════════
   EMPTY STATE
══════════════════════════════════ */
.da-empty {
    text-align: center;
    padding: 4rem 2rem;
    background: var(--da-surf);
    border: 2px dashed var(--da-border);
    border-radius: var(--da-r-xl);
    animation: da-up .4s cubic-bezier(.16,1,.3,1) .2s both;
}

.da-empty-icon {
    width: 72px; height: 72px;
    margin: 0 auto 1.5rem;
    background: var(--da-ind-wash);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: var(--da-ind);
}

.da-empty-icon svg { width: 32px; height: 32px; }

.da-empty h3 {
    font-family: 'Syne', sans-serif;
    font-size: 1.375rem;
    font-weight: 700;
    color: var(--da-text);
    margin: 0 0 .5rem;
}

.da-empty p {
    font-size: .875rem;
    color: var(--da-text-2);
    margin: 0 auto 1.5rem;
    max-width: 420px;
}

/* ══════════════════════════════════
   PAGINATION
══════════════════════════════════ */
.da-pagination {
    display: flex;
    justify-content: center;
    padding: 1.5rem 0;
    animation: da-up .4s cubic-bezier(.16,1,.3,1) .3s both;
}

.da-pagination .pagination {
    display: flex;
    gap: .25rem;
    list-style: none;
    margin: 0; padding: 0;
}

.da-pagination .page-item .page-link {
    display: flex; align-items: center; justify-content: center;
    min-width: 36px; height: 36px;
    padding: 0 .5rem;
    border-radius: 8px;
    font-size: .8125rem; font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    color: var(--da-text-2);
    background: var(--da-surf);
    border: 1px solid var(--da-border);
    text-decoration: none;
    transition: all .2s cubic-bezier(.4,0,.2,1);
}

.da-pagination .page-item .page-link:hover {
    border-color: var(--da-ind);
    color: var(--da-ind);
    background: var(--da-ind-wash);
    transform: translateY(-1px);
}

.da-pagination .page-item.active .page-link {
    background: var(--da-ind);
    border-color: var(--da-ind);
    color: #fff;
    box-shadow: 0 2px 8px rgba(99,102,241,.3);
}

.da-pagination .page-item.disabled .page-link {
    opacity: .4; cursor: default; pointer-events: none;
}

/* ══════════════════════════════════
   MODAL
══════════════════════════════════ */
.da-modal-overlay {
    display: none;
    position: fixed; inset: 0;
    background: rgba(15,23,42,.6);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    z-index: 99999;
    align-items: center; justify-content: center;
    padding: 1rem;
}

.da-modal-overlay.show { display: flex; }

.da-modal {
    background: var(--da-surf);
    border-radius: var(--da-r-xl);
    width: 100%; max-width: 540px;
    max-height: 90vh;
    overflow: hidden;
    box-shadow: 0 24px 48px rgba(0,0,0,.2), 0 0 0 1px rgba(0,0,0,.05);
    animation: da-scale .35s cubic-bezier(.16,1,.3,1);
}

.da-modal-head {
    background: linear-gradient(135deg, #312e81, #4338ca 60%, #0d9488);
    padding: 1.375rem 1.75rem;
    display: flex; align-items: center; justify-content: space-between;
    position: relative; overflow: hidden;
}

.da-modal-head::before {
    content: '';
    position: absolute;
    top: -60%; right: -20%;
    width: 200px; height: 200px;
    background: radial-gradient(circle, rgba(99,102,241,.2) 0%, transparent 70%);
    border-radius: 50%;
}

.da-modal-head-left { display: flex; align-items: center; gap: .875rem; position: relative; }

.da-modal-icon {
    width: 44px; height: 44px;
    background: rgba(255,255,255,.15);
    color: #fff;
    border-radius: var(--da-r);
    display: flex; align-items: center; justify-content: center;
}

.da-modal-icon svg { width: 22px; height: 22px; }

.da-modal-title {
    font-family: 'Syne', sans-serif;
    font-size: 1.125rem;
    font-weight: 700;
    color: #fff;
    margin: 0;
}

.da-modal-subtitle { font-size: .75rem; color: rgba(255,255,255,.65); margin: .1rem 0 0; }

.da-modal-close {
    width: 36px; height: 36px;
    border-radius: 10px;
    border: 1.5px solid rgba(255,255,255,.15);
    background: rgba(255,255,255,.07);
    color: rgba(255,255,255,.55);
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: all .2s ease;
    position: relative;
}

.da-modal-close svg { width: 18px; height: 18px; }
.da-modal-close:hover { border-color: rgba(239,68,68,.4); color: #fca5a5; background: rgba(239,68,68,.15); }

.da-modal-body {
    padding: 1.5rem 1.75rem;
    overflow-y: auto;
    max-height: calc(90vh - 200px);
}

.da-form-group { margin-bottom: 1.25rem; }

.da-form-label {
    display: block;
    font-size: .6875rem;
    font-weight: 700;
    color: var(--da-text-2);
    text-transform: uppercase;
    letter-spacing: .4px;
    margin-bottom: .5rem;
}

.da-form-select,
.da-form-input {
    width: 100%;
    padding: .625rem 1rem;
    border: 1.5px solid var(--da-border);
    border-radius: var(--da-r);
    font-family: 'DM Sans', sans-serif;
    font-size: .8125rem;
    background: var(--da-bg);
    color: var(--da-text);
    transition: all .2s ease;
}

.da-form-select:focus,
.da-form-input:focus {
    outline: none;
    border-color: var(--da-ind);
    box-shadow: 0 0 0 3px var(--da-ind-pale);
    background: var(--da-surf);
}

.da-form-select option { background: var(--da-surf); color: var(--da-text); }

/* Zone upload */
.da-file-zone {
    border: 2px dashed var(--da-border);
    border-radius: var(--da-r-lg);
    padding: 2rem 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: all .3s cubic-bezier(.16,1,.3,1);
    background: var(--da-bg);
    position: relative;
}

.da-file-zone:hover,
.da-file-zone.dragover {
    border-color: var(--da-ind);
    background: var(--da-ind-wash);
}

.da-file-zone input { display: none; }

.da-file-zone-icon {
    width: 52px; height: 52px;
    margin: 0 auto .875rem;
    background: var(--da-ind-pale);
    border-radius: var(--da-r);
    display: flex; align-items: center; justify-content: center;
    color: var(--da-ind);
    transition: all .3s cubic-bezier(.16,1,.3,1);
}

.da-file-zone:hover .da-file-zone-icon { transform: scale(1.08) translateY(-2px); }
.da-file-zone-icon svg { width: 24px; height: 24px; }

.da-file-zone-text {
    font-size: .875rem; font-weight: 600;
    color: var(--da-text); margin: 0 0 .25rem;
}

.da-file-zone-hint {
    font-size: .75rem;
    color: var(--da-text-3);
    margin: 0;
}

.da-selected-files {
    margin-top: .75rem;
    font-size: .8125rem;
    color: var(--da-teal);
    font-weight: 600;
}

.da-modal-foot {
    padding: 1rem 1.75rem;
    border-top: 1px solid var(--da-border);
    display: flex; justify-content: flex-end; gap: .625rem;
    background: var(--da-bg);
}

/* ══════════════════════════════════
   TOAST
══════════════════════════════════ */
.da-toast {
    position: fixed;
    bottom: 2rem; right: 2rem;
    padding: .875rem 1.25rem;
    border-radius: var(--da-r);
    display: flex; align-items: center; gap: .625rem;
    font-family: 'DM Sans', sans-serif;
    font-size: .85rem; font-weight: 600;
    z-index: 100000;
    box-shadow: 0 8px 24px rgba(0,0,0,.15);
    animation: da-scale .3s cubic-bezier(.16,1,.3,1);
    transition: all .3s ease;
}

.da-toast svg { width: 18px; height: 18px; flex-shrink: 0; }
.da-toast.success { background: var(--da-teal);    color: #fff; }
.da-toast.error   { background: var(--da-red);     color: #fff; }

/* ── Responsive ── */
@media (max-width: 1024px) {
    .da-grid { grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); }
    .da-hero-kpis { gap: 1.25rem; }
}

@media (max-width: 768px) {
    .da-page { padding: 0 1rem 2rem; }
    .da-hero-inner { flex-direction: column; align-items: flex-start; }
    .da-hero-kpis { width: 100%; justify-content: space-around; }
    .da-hero-actions { width: 100%; }
    .da-hero-actions .da-btn { flex: 1; justify-content: center; }
    .da-toolbar { flex-direction: column; }
    .da-search-wrap { max-width: none; }
    .da-toolbar-right { width: 100%; justify-content: space-between; }
    .da-grid { grid-template-columns: 1fr; }
    .da-alerts { grid-template-columns: 1fr; }
    .da-alert { flex-wrap: wrap; }
}
</style>
@endsection

@section('content')
<div class="da-page">

    <!-- ══ Hero Banner ══ -->
    <div class="da-hero">
        <div class="da-hero-bg">
            <div class="da-hero-inner">
                <div class="da-hero-left">
                    <h1>Dossiers Agents</h1>
                    <p>Gestion centralisée des documents de vos collaborateurs</p>
                </div>
                <div class="da-hero-kpis">
                    <div class="da-hero-kpi">
                        <div class="da-hero-kpi-val" data-count="{{ $stats['total_personnels'] }}">{{ $stats['total_personnels'] }}</div>
                        <div class="da-hero-kpi-lbl">Employés</div>
                    </div>
                    <div class="da-hero-kpi">
                        <div class="da-hero-kpi-val" data-count="{{ $stats['total_documents'] }}">{{ $stats['total_documents'] }}</div>
                        <div class="da-hero-kpi-lbl">Documents</div>
                    </div>
                    <div class="da-hero-kpi">
                        <div class="da-hero-kpi-val" data-count="{{ $stats['documents_expires'] }}">{{ $stats['documents_expires'] }}</div>
                        <div class="da-hero-kpi-lbl">Expirés</div>
                    </div>
                    <div class="da-hero-kpi">
                        <div class="da-hero-kpi-val" data-count="{{ $stats['documents_expirent_bientot'] }}">{{ $stats['documents_expirent_bientot'] }}</div>
                        <div class="da-hero-kpi-lbl">À renouveler</div>
                    </div>
                </div>
                <div class="da-hero-actions">
                    @if($stats['documents_expires'] + $stats['documents_expirent_bientot'] > 0)
                    <a href="{{ route('admin.dossier-agent.alertes') }}" class="da-btn da-btn-warning">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        Alertes
                        <span class="da-badge-count">{{ $stats['documents_expires'] + $stats['documents_expirent_bientot'] }}</span>
                    </a>
                    @endif
                    <a href="{{ route('admin.personnels.index') }}" class="da-btn da-btn-outline" style="background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.2);color:#fff;">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Personnel
                    </a>
                </div>
            </div>
        </div>
        <div class="da-hero-accent"></div>
    </div>

    <!-- ══ Alert Banners ══ -->
    @if($stats['documents_expires'] > 0 || $stats['documents_expirent_bientot'] > 0)
    <div class="da-alerts">
        @if($stats['documents_expires'] > 0)
        <div class="da-alert danger">
            <div class="da-alert-icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="da-alert-body">
                <p class="da-alert-title">Documents expirés</p>
                <p class="da-alert-desc">Action requise immédiatement</p>
            </div>
            <div class="da-alert-count">{{ $stats['documents_expires'] }}</div>
            <a href="{{ route('admin.dossier-agent.alertes') }}?type=expires" class="da-alert-link">Voir →</a>
        </div>
        @endif
        @if($stats['documents_expirent_bientot'] > 0)
        <div class="da-alert warning">
            <div class="da-alert-icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="da-alert-body">
                <p class="da-alert-title">Expirent dans 30 jours</p>
                <p class="da-alert-desc">Prévoir le renouvellement</p>
            </div>
            <div class="da-alert-count">{{ $stats['documents_expirent_bientot'] }}</div>
            <a href="{{ route('admin.dossier-agent.alertes') }}?type=bientot" class="da-alert-link">Voir →</a>
        </div>
        @endif
    </div>
    @endif

    <!-- ══ Toolbar ══ -->
    <div class="da-toolbar">
        <form action="{{ route('admin.dossiers-agents.index') }}" method="GET" class="da-search-wrap" id="searchForm">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="search" class="da-search-input"
                   placeholder="Rechercher par nom, prénom ou matricule..."
                   value="{{ request('search') }}" id="daSearchInput">
        </form>
        <div class="da-toolbar-right">
            @if(request('search'))
            <a href="{{ route('admin.dossiers-agents.index') }}" class="da-btn da-btn-outline" style="padding:.55rem .75rem;">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Réinitialiser
            </a>
            @endif
            <span class="da-count-label">
                <strong>{{ $personnels->total() }}</strong> employé{{ $personnels->total() > 1 ? 's' : '' }}
            </span>
        </div>
    </div>

    <!-- ══ Grille ══ -->
    @if($personnels->count() > 0)
    <div class="da-grid">
        @foreach($personnels as $personnel)
        @php
            $totalDocs   = $personnel->documents_count;
            $activeDocs  = $personnel->documents()->actifs()->count();
            $expiredDocs = $personnel->documents()->expires()->count();
            $validPercent = $totalDocs > 0 ? round($activeDocs / $totalDocs * 100) : 100;
            $statusClass  = $expiredDocs > 0 ? 'err' : ($activeDocs < $totalDocs ? 'warn' : 'ok');
            $progressClass = $validPercent >= 80 ? 'good' : ($validPercent >= 50 ? 'mid' : 'low');
            // SVG ring: circumference = 2π×30 ≈ 188.5
            $ringOffset = round(188.5 - (188.5 * $validPercent / 100), 2);
        @endphp
        <div class="da-card" style="animation-delay:{{ $loop->index * 0.04 }}s">
            <div class="da-card-head">
                <!-- Avatar + Ring SVG (touche signature) -->
                <div class="da-av-wrap">
                    <svg class="da-ring" viewBox="0 0 68 68">
                        <circle class="da-ring-bg"   cx="34" cy="34" r="30"/>
                        <circle class="da-ring-fill {{ $progressClass }}"
                                cx="34" cy="34" r="30"
                                style="stroke-dashoffset:{{ $ringOffset }}"/>
                    </svg>
                    <div class="da-avatar">
                        @if($personnel->photo)
                            <img src="{{ asset('storage/' . $personnel->photo) }}" alt="{{ $personnel->nom }}">
                        @else
                            {{ strtoupper(substr($personnel->nom, 0, 1) . substr($personnel->prenoms ?? '', 0, 1)) }}
                        @endif
                        <span class="da-av-dot {{ $statusClass }}"></span>
                    </div>
                </div>

                <div class="da-card-identity">
                    <h3 class="da-card-name">{{ $personnel->nom }} {{ $personnel->prenoms }}</h3>
                    <div class="da-card-meta">
                        @if($personnel->matricule)
                        <span class="da-card-badge">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                            </svg>
                            {{ $personnel->matricule }}
                        </span>
                        @endif
                        @if($personnel->poste)
                        <span class="da-card-badge ind">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ $personnel->poste }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="da-card-body">
                <div class="da-doc-row">
                    <div class="da-doc-pill total">
                        <div class="da-doc-pill-val">{{ $totalDocs }}</div>
                        <div class="da-doc-pill-lbl">Total</div>
                    </div>
                    <div class="da-doc-pill valid">
                        <div class="da-doc-pill-val">{{ $activeDocs }}</div>
                        <div class="da-doc-pill-lbl">Valides</div>
                    </div>
                    <div class="da-doc-pill expired">
                        <div class="da-doc-pill-val">{{ $expiredDocs }}</div>
                        <div class="da-doc-pill-lbl">Expirés</div>
                    </div>
                </div>

                @if($totalDocs > 0)
                <div class="da-progress">
                    <div class="da-progress-bar {{ $progressClass }}" style="width:{{ $validPercent }}%"></div>
                </div>
                @endif

                <div class="da-card-actions">
                    <a href="{{ route('admin.dossier-agent.show', $personnel) }}" class="da-card-link">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"/>
                        </svg>
                        Ouvrir le dossier
                    </a>
                    <button type="button" class="da-card-upload"
                            onclick="openQuickUpload({{ $personnel->id }}, '{{ addslashes($personnel->nom . ' ' . $personnel->prenoms) }}')"
                            title="Upload rapide">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($personnels->hasPages())
    <div class="da-pagination">
        {{ $personnels->withQueryString()->links() }}
    </div>
    @endif

    @else
    <div class="da-empty">
        <div class="da-empty-icon">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <h3>Aucun employé trouvé</h3>
        <p>
            @if(request('search'))
                Aucun résultat ne correspond à votre recherche.
            @else
                Commencez par ajouter des employés pour gérer leurs dossiers documentaires.
            @endif
        </p>
        @if(request('search'))
        <a href="{{ route('admin.dossiers-agents.index') }}" class="da-btn da-btn-outline">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Réinitialiser
        </a>
        @else
        <a href="{{ route('admin.personnels.index') }}" class="da-btn da-btn-primary">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
            Gérer les employés
        </a>
        @endif
    </div>
    @endif
</div>

<!-- Quick Upload Modal -->
<div class="da-modal-overlay" id="quickUploadModal">
    <div class="da-modal">
        <div class="da-modal-head">
            <div class="da-modal-head-left">
                <div class="da-modal-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                </div>
                <div>
                    <h3 class="da-modal-title">Upload rapide</h3>
                    <p class="da-modal-subtitle" id="modalEmployeeName">Ajouter des documents</p>
                </div>
            </div>
            <button class="da-modal-close" onclick="closeQuickUpload()">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <form id="quickUploadForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="personnel_id" id="quickUploadPersonnelId">
            <div class="da-modal-body">
                <div class="da-form-group">
                    <label class="da-form-label">Catégorie du document</label>
                    <select name="categorie_id" class="da-form-select">
                        <option value="">Sélectionner une catégorie...</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="da-form-group">
                    <label class="da-form-label">Document(s)</label>
                    <label class="da-file-zone" id="fileUploadLabel">
                        <input type="file" name="documents[]" id="fileInput" multiple
                               accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.webp">
                        <div class="da-file-zone-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                        </div>
                        <p class="da-file-zone-text">Cliquez ou glissez-déposez vos fichiers</p>
                        <p class="da-file-zone-hint">PDF, DOC, XLS, Images — max 10 Mo par fichier</p>
                    </label>
                    <div class="da-selected-files" id="selectedFiles"></div>
                </div>
            </div>
            <div class="da-modal-foot">
                <button type="button" class="da-btn da-btn-outline" onclick="closeQuickUpload()">Annuler</button>
                <button type="submit" class="da-btn da-btn-primary" id="uploadSubmitBtn">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    Uploader
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
/* ── Modal ── */
const quickUploadModal  = document.getElementById('quickUploadModal');
const quickUploadForm   = document.getElementById('quickUploadForm');
const fileInput         = document.getElementById('fileInput');
const selectedFilesDiv  = document.getElementById('selectedFiles');
const fileUploadLabel   = document.getElementById('fileUploadLabel');

function openQuickUpload(personnelId, employeeName) {
    document.getElementById('quickUploadPersonnelId').value = personnelId;
    document.getElementById('modalEmployeeName').textContent = employeeName;
    quickUploadModal.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeQuickUpload() {
    quickUploadModal.classList.remove('show');
    document.body.style.overflow = '';
    quickUploadForm.reset();
    selectedFilesDiv.textContent = '';
    fileUploadLabel.classList.remove('dragover');
}

/* ── File input ── */
fileInput.addEventListener('change', function() {
    const files = Array.from(this.files);
    selectedFilesDiv.innerHTML = files.length > 0
        ? files.map(f => `<div>✓ ${f.name}</div>`).join('')
        : '';
});

/* ── Drag & drop ── */
['dragenter','dragover','dragleave','drop'].forEach(evt => {
    fileUploadLabel.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); }, false);
});
['dragenter','dragover'].forEach(evt =>
    fileUploadLabel.addEventListener(evt, () => fileUploadLabel.classList.add('dragover'))
);
['dragleave','drop'].forEach(evt =>
    fileUploadLabel.addEventListener(evt, () => fileUploadLabel.classList.remove('dragover'))
);
fileUploadLabel.addEventListener('drop', function(e) {
    fileInput.files = e.dataTransfer.files;
    fileInput.dispatchEvent(new Event('change'));
});

/* ── Upload submit ── */
quickUploadForm.addEventListener('submit', async function(e) {
    e.preventDefault();
    const submitBtn  = document.getElementById('uploadSubmitBtn');
    const orig       = submitBtn.innerHTML;
    submitBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation:da-glow 1s infinite"><circle cx="12" cy="12" r="10"/></svg> Upload...';
    submitBtn.disabled = true;

    const personnelId = document.getElementById('quickUploadPersonnelId').value;
    const formData    = new FormData(this);

    try {
        const response = await fetch(`/admin/dossier-agent/${personnelId}/upload-multiple`, {
            method : 'POST',
            body   : formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept'      : 'application/json'
            }
        });
        const data = await response.json();
        if (data.success) {
            showToast(data.message || 'Documents uploadés avec succès', 'success');
            closeQuickUpload();
            setTimeout(() => window.location.reload(), 1500);
        } else {
            showToast(data.message || 'Erreur lors de l\'upload', 'error');
        }
    } catch(err) {
        showToast('Erreur de connexion', 'error');
    } finally {
        submitBtn.innerHTML = orig;
        submitBtn.disabled  = false;
    }
});

/* ── Modal close ── */
quickUploadModal.addEventListener('click', e => { if (e.target === quickUploadModal) closeQuickUpload(); });
document.addEventListener('keydown', e => {
    if (e.key === 'Escape' && quickUploadModal.classList.contains('show')) closeQuickUpload();
});

/* ── Search enter ── */
document.getElementById('daSearchInput').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') { e.preventDefault(); document.getElementById('searchForm').submit(); }
});

/* ── Toast ── */
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `da-toast ${type}`;
    toast.innerHTML = `
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            ${type === 'success'
                ? '<path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'
                : '<path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'}
        </svg>
        ${message}`;
    document.body.appendChild(toast);
    setTimeout(() => {
        toast.style.opacity   = '0';
        toast.style.transform = 'translateY(20px)';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

/* ── Counter animation (hero KPIs) ── */
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[data-count]').forEach(el => {
        const target   = parseInt(el.dataset.count);
        if (!target) return;
        el.textContent = '0';
        const duration = 700;
        const start    = performance.now();
        function tick(now) {
            const p    = Math.min((now - start) / duration, 1);
            const ease = 1 - Math.pow(1 - p, 3);
            el.textContent = Math.round(ease * target);
            if (p < 1) requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
    });
});
</script>
@endsection
