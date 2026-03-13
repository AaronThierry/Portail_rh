@extends('layouts.espace-employe')

@section('title', 'Mon Espace')
@section('page-title', 'Tableau de bord')
@section('breadcrumb')
    <span>Accueil</span>
@endsection

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
/* ═══════════════════════════════════════════════════════════
   ESPACE EMPLOYÉ DASHBOARD — Precision Dark  (même style Admin)
   Bleu · Gris · Orange — DM Sans / DM Mono
   ═══════════════════════════════════════════════════════════ */
:root {
    --erp-bg:        #080e1a;
    --erp-surface:   #0e1726;
    --erp-surface-2: #131f30;
    --erp-border:    #1c2a3d;
    --erp-border-2:  #253347;
    --erp-text:      #e8edf5;
    --erp-text-2:    #8899aa;
    --erp-text-3:    #4d6070;
    --erp-blue:      #3b82f6;
    --erp-orange:    #f97316;
    --erp-green:     #22c55e;
    --erp-red:       #ef4444;
    --erp-amber:     #f59e0b;
    --erp-teal:      #06b6d4;
    --erp-mono:      'DM Mono', monospace;
    --erp-sans:      'DM Sans', sans-serif;
}

/* Force dark BG on the content area */
.emp-root,
.emp-root * { box-sizing: border-box; }

.emp-root {
    font-family: var(--erp-sans);
    color: var(--erp-text);
    padding: 0 4px;
    animation: emp-page-in .4s ease both;
    background: var(--erp-bg);
    border-radius: 12px;
    min-height: calc(100vh - 100px);
    padding: 20px;
    margin: -8px;
}

@keyframes emp-page-in {
    from { opacity: 0; transform: translateY(8px); }
    to   { opacity: 1; transform: translateY(0);   }
}

/* ── Section label ─────────────────────────────────────── */
.erp-section-label {
    font-size: .6875rem;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--erp-text-3);
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.erp-section-label::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--erp-border);
}

/* ── Greeting ──────────────────────────────────────────── */
.erp-greeting {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--erp-border);
}
.erp-greeting-left h1 {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--erp-text);
    letter-spacing: -.02em;
    margin: 0 0 2px;
}
.erp-greeting-left h1 span { color: var(--erp-orange); }
.erp-greeting-left p {
    font-size: .78rem;
    color: var(--erp-text-2);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
}
.erp-greeting-left p b { color: var(--erp-text); font-weight: 600; }
.erp-greeting-sep { color: var(--erp-border-2); }

.erp-greeting-right {
    display: flex;
    align-items: center;
    gap: 10px;
}
.erp-greeting-date {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: .75rem;
    font-weight: 500;
    color: var(--erp-text-3);
    background: var(--erp-surface);
    border: 1px solid var(--erp-border);
    padding: 5px 12px;
    border-radius: 6px;
    letter-spacing: .01em;
    font-family: var(--erp-mono);
}
.erp-greeting-date svg { color: var(--erp-blue); flex-shrink: 0; }

.erp-clock-badge {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: .75rem;
    font-weight: 500;
    color: var(--erp-text-3);
    background: var(--erp-surface);
    border: 1px solid var(--erp-border);
    padding: 5px 12px;
    border-radius: 6px;
    font-family: var(--erp-mono);
    letter-spacing: .04em;
}
.erp-clock-badge span { color: var(--erp-blue); font-weight: 700; }

/* ── KPI row ───────────────────────────────────────────── */
.erp-kpi-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
    margin-bottom: 18px;
}
.erp-kpi {
    background: var(--erp-surface);
    border: 1px solid var(--erp-border);
    border-radius: 10px;
    padding: 14px 16px 12px;
    position: relative;
    overflow: hidden;
    transition: border-color .2s, transform .2s, box-shadow .2s;
    cursor: default;
    animation: erp-kpi-in .4s ease both;
}
.erp-kpi:nth-child(1) { animation-delay:.04s; }
.erp-kpi:nth-child(2) { animation-delay:.08s; }
.erp-kpi:nth-child(3) { animation-delay:.12s; }
.erp-kpi:nth-child(4) { animation-delay:.16s; }

@keyframes erp-kpi-in {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0);    }
}
.erp-kpi::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 2px;
    opacity: 0;
    transition: opacity .2s;
}
.erp-kpi:hover { border-color: var(--erp-border-2); transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,.4); }
.erp-kpi:hover::before { opacity: 1; }

.erp-kpi-blue::before   { background: linear-gradient(90deg, var(--erp-blue), #818cf8); }
.erp-kpi-orange::before { background: linear-gradient(90deg, var(--erp-orange), var(--erp-amber)); }
.erp-kpi-green::before  { background: linear-gradient(90deg, var(--erp-green), #34d399); }
.erp-kpi-teal::before   { background: linear-gradient(90deg, var(--erp-teal), #0891b2); }

.erp-kpi-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
}
.erp-kpi-label {
    font-size: .65rem;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: var(--erp-text-3);
}
.erp-kpi-icon {
    width: 32px; height: 32px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.erp-kpi-blue   .erp-kpi-icon { background: rgba(59,130,246,.12); color: var(--erp-blue); }
.erp-kpi-orange .erp-kpi-icon { background: rgba(249,115,22,.12); color: var(--erp-orange); }
.erp-kpi-green  .erp-kpi-icon { background: rgba(34,197,94,.12);  color: var(--erp-green); }
.erp-kpi-teal   .erp-kpi-icon { background: rgba(6,182,212,.12);  color: var(--erp-teal); }

.erp-kpi-value {
    font-family: var(--erp-mono);
    font-size: 1.8rem;
    font-weight: 500;
    line-height: 1;
    letter-spacing: -.03em;
    margin-bottom: 8px;
}
.erp-kpi-blue   .erp-kpi-value { color: #e8f0ff; }
.erp-kpi-orange .erp-kpi-value { color: #fff0e6; }
.erp-kpi-green  .erp-kpi-value { color: #e6fff3; }
.erp-kpi-teal   .erp-kpi-value { color: #e6faff; }

.erp-kpi-badges { display: flex; flex-wrap: wrap; gap: 4px; }

.erp-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 2px 7px;
    border-radius: 4px;
    font-size: .6rem;
    font-weight: 700;
    letter-spacing: .03em;
    text-transform: uppercase;
    white-space: nowrap;
}
.erp-badge::before {
    content: '';
    width: 5px; height: 5px;
    border-radius: 50%;
    flex-shrink: 0;
}
.erp-badge-blue   { background: rgba(59,130,246,.1);  color: #60a5fa; }
.erp-badge-blue::before   { background: #3b82f6; }
.erp-badge-green  { background: rgba(34,197,94,.1);   color: #4ade80; }
.erp-badge-green::before  { background: #22c55e; }
.erp-badge-orange { background: rgba(249,115,22,.1);  color: #fb923c; }
.erp-badge-orange::before { background: #f97316; }
.erp-badge-teal   { background: rgba(6,182,212,.1);   color: #22d3ee; }
.erp-badge-teal::before   { background: #06b6d4; }
.erp-badge-gray   { background: rgba(100,116,139,.1); color: #94a3b8; }
.erp-badge-gray::before   { background: #64748b; }

/* ── Main grid ─────────────────────────────────────────── */
.erp-main {
    display: grid;
    grid-template-columns: 3fr 2fr;
    gap: 12px;
    margin-bottom: 12px;
    height: 340px;
}

.erp-card {
    background: var(--erp-surface);
    border: 1px solid var(--erp-border);
    border-radius: 10px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}
.erp-card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 13px 16px 11px;
    border-bottom: 1px solid var(--erp-border);
    flex-shrink: 0;
}
.erp-card-title {
    font-size: .8rem;
    font-weight: 700;
    color: var(--erp-text);
    letter-spacing: -.01em;
}
.erp-card-link {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: .68rem;
    font-weight: 600;
    color: var(--erp-blue);
    text-decoration: none;
    padding: 3px 8px;
    border-radius: 5px;
    border: 1px solid rgba(59,130,246,.2);
    background: rgba(59,130,246,.07);
    transition: background .15s;
}
.erp-card-link:hover { background: rgba(59,130,246,.15); }
.erp-card-link svg { width: 10px; height: 10px; transition: transform .15s; }
.erp-card-link:hover svg { transform: translateX(2px); }

/* ── Activity feed ─────────────────────────────────────── */
.erp-feed {
    flex: 1;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: var(--erp-border) transparent;
    padding: 4px 0;
}
.erp-feed::-webkit-scrollbar { width: 3px; }
.erp-feed::-webkit-scrollbar-track { background: transparent; }
.erp-feed::-webkit-scrollbar-thumb { background: var(--erp-border-2); border-radius: 2px; }

.erp-feed-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px 16px;
    transition: background .15s;
    animation: erp-feed-in .3s ease both;
}
.erp-feed-item:nth-child(1) { animation-delay:.05s; }
.erp-feed-item:nth-child(2) { animation-delay:.10s; }
.erp-feed-item:nth-child(3) { animation-delay:.15s; }
.erp-feed-item:nth-child(4) { animation-delay:.20s; }
.erp-feed-item:nth-child(5) { animation-delay:.25s; }
@keyframes erp-feed-in {
    from { opacity: 0; transform: translateX(-5px); }
    to   { opacity: 1; transform: translateX(0);    }
}
.erp-feed-item:hover { background: var(--erp-surface-2); }
.erp-feed-item:not(:last-child) { border-bottom: 1px solid var(--erp-border); }

.erp-feed-dot {
    width: 30px; height: 30px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.erp-feed-dot-orange  { background: rgba(249,115,22,.13); color: #fb923c; }
.erp-feed-dot-blue    { background: rgba(59,130,246,.13); color: #60a5fa; }
.erp-feed-dot-gray    { background: rgba(100,116,139,.13); color: #94a3b8; }

.erp-feed-body { flex: 1; min-width: 0; }
.erp-feed-title {
    font-size: .775rem;
    font-weight: 600;
    color: var(--erp-text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.35;
}
.erp-feed-sub {
    font-size: .68rem;
    color: var(--erp-text-2);
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 1px;
}
.erp-feed-time {
    font-family: var(--erp-mono);
    font-size: .63rem;
    color: var(--erp-text-3);
    flex-shrink: 0;
    letter-spacing: .02em;
}
.erp-new-pill {
    font-size: .58rem;
    font-weight: 700;
    letter-spacing: .04em;
    text-transform: uppercase;
    padding: 1px 5px;
    border-radius: 3px;
    background: rgba(249,115,22,.15);
    color: #fb923c;
    border: 1px solid rgba(249,115,22,.25);
}
.erp-feed-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    gap: 8px;
    color: var(--erp-text-3);
    font-size: .78rem;
}

/* ── Profile card ──────────────────────────────────────── */
.erp-profile-card {
    display: flex;
    flex-direction: column;
    height: 100%;
}
.erp-profile-top {
    padding: 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    border-bottom: 1px solid var(--erp-border);
    flex-shrink: 0;
}
.erp-profile-avatar-wrap { position: relative; flex-shrink: 0; }
.erp-profile-avatar {
    width: 52px; height: 52px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--erp-orange);
    display: block;
}
.erp-profile-online {
    position: absolute;
    bottom: 1px; right: 1px;
    width: 10px; height: 10px;
    background: var(--erp-green);
    border: 2px solid var(--erp-surface);
    border-radius: 50%;
}
.erp-profile-name {
    font-size: .9rem;
    font-weight: 700;
    color: var(--erp-text);
    letter-spacing: -.02em;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.erp-profile-role {
    font-size: .72rem;
    color: var(--erp-text-2);
    margin-top: 1px;
}
.erp-profile-mat {
    display: inline-block;
    font-family: var(--erp-mono);
    font-size: .62rem;
    font-weight: 500;
    color: var(--erp-orange);
    background: rgba(249,115,22,.1);
    border: 1px solid rgba(249,115,22,.2);
    padding: 2px 6px;
    border-radius: 4px;
    margin-top: 3px;
}
.erp-profile-rows { flex: 1; overflow-y: auto; }
.erp-profile-row {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 16px;
    border-bottom: 1px solid var(--erp-border);
    transition: background .12s;
}
.erp-profile-row:last-child { border-bottom: none; }
.erp-profile-row:hover { background: var(--erp-surface-2); }
.erp-profile-row-ic {
    width: 22px; height: 22px;
    display: flex; align-items: center; justify-content: center;
    color: var(--erp-text-3);
    flex-shrink: 0;
}
.erp-profile-row-ic svg { width: 12px; height: 12px; }
.erp-profile-row-info { flex: 1; min-width: 0; }
.erp-profile-row-lbl {
    font-size: .58rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .07em;
    color: var(--erp-text-3);
}
.erp-profile-row-val {
    font-size: .76rem;
    font-weight: 600;
    color: var(--erp-text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-top: 1px;
}
.erp-profile-footer {
    padding: 12px 16px;
    flex-shrink: 0;
    border-top: 1px solid var(--erp-border);
}
.erp-btn-blue {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    width: 100%;
    padding: 8px 16px;
    background: var(--erp-blue);
    color: white;
    font-family: var(--erp-sans);
    font-size: .78rem;
    font-weight: 700;
    border: none;
    border-radius: 7px;
    cursor: pointer;
    text-decoration: none;
    letter-spacing: -.01em;
    transition: background .15s, transform .15s, box-shadow .15s;
}
.erp-btn-blue:hover { background: #1d4ed8; transform: translateY(-1px); box-shadow: 0 4px 14px rgba(37,99,235,.4); }
.erp-btn-blue svg { width: 13px; height: 13px; }

/* ── Actions rapides ───────────────────────────────────── */
.erp-actions {
    background: var(--erp-surface);
    border: 1px solid var(--erp-border);
    border-radius: 10px;
    padding: 12px 16px;
    margin-bottom: 4px;
}
.erp-actions-inner { display: flex; gap: 8px; flex-wrap: wrap; }

.erp-action-pill {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 7px 14px;
    background: var(--erp-surface-2);
    border: 1px solid var(--erp-border-2);
    border-radius: 7px;
    color: var(--erp-text-2);
    text-decoration: none;
    font-family: var(--erp-sans);
    font-size: .775rem;
    font-weight: 600;
    letter-spacing: .01em;
    transition: all .18s ease;
    white-space: nowrap;
}
.erp-action-pill svg { flex-shrink: 0; transition: transform .18s ease; }
.erp-action-pill:hover { background: var(--erp-blue); border-color: var(--erp-blue); color: #fff; transform: translateY(-1px); box-shadow: 0 4px 16px rgba(59,130,246,.35); }
.erp-action-pill:hover svg { transform: scale(1.1); }
.erp-action-pill.orange-action:hover { background: var(--erp-orange); border-color: var(--erp-orange); box-shadow: 0 4px 16px rgba(249,115,22,.35); }

/* ── Summary strip ─────────────────────────────────────── */
.erp-summary {
    background: var(--erp-surface);
    border: 1px solid var(--erp-border);
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 12px;
}
.erp-summary-inner { display: grid; grid-template-columns: repeat(4, 1fr); }
.erp-summary-cell {
    padding: 13px 16px;
    border-right: 1px solid var(--erp-border);
    transition: background .15s;
}
.erp-summary-cell:last-child { border-right: none; }
.erp-summary-cell:hover { background: var(--erp-surface-2); }
.erp-summary-cell-label {
    font-size: .61rem;
    font-weight: 700;
    letter-spacing: .07em;
    text-transform: uppercase;
    color: var(--erp-text-3);
    margin-bottom: 5px;
}
.erp-summary-cell-value {
    font-family: var(--erp-mono);
    font-size: 1.15rem;
    font-weight: 500;
    color: var(--erp-text);
    letter-spacing: -.02em;
    line-height: 1.2;
}
.erp-summary-cell.accent-orange .erp-summary-cell-value { color: #fb923c; }
.erp-summary-cell.accent-green .erp-summary-cell-value  { color: #4ade80; }
.erp-summary-cell.accent-blue .erp-summary-cell-value   { color: #60a5fa; }
.erp-summary-cell.accent-teal .erp-summary-cell-value   { color: #22d3ee; }

/* ── Responsive ─────────────────────────────────────────── */
@media (max-width: 1080px) {
    .erp-kpi-row { grid-template-columns: repeat(2, 1fr); }
    .erp-main    { grid-template-columns: 1fr; height: auto; }
    .erp-main .erp-card:first-child { height: 280px; }
    .erp-main .erp-card:last-child  { height: 260px; }
    .erp-summary-inner { grid-template-columns: repeat(2, 1fr); }
    .erp-summary-cell:nth-child(2) { border-right: none; }
    .erp-summary-cell:nth-child(3) { border-top: 1px solid var(--erp-border); }
    .erp-summary-cell:nth-child(4) { border-top: 1px solid var(--erp-border); border-right: none; }
}
@media (max-width: 600px) {
    .erp-kpi-row { grid-template-columns: 1fr; }
    .erp-greeting { flex-direction: column; align-items: flex-start; gap: 10px; }
    .erp-greeting-right { flex-direction: column; align-items: flex-start; }
    .emp-root { padding: 12px; }
}
</style>
@endsection

@section('content')
@php
    $prenomDisplay = $personnel ? $personnel->prenoms : auth()->user()->name;
@endphp

<div class="emp-root">

    {{-- ══ GREETING ══ --}}
    <div class="erp-greeting">
        <div class="erp-greeting-left">
            <h1 id="emp-greeting">Bonjour, <span>{{ $prenomDisplay }}</span></h1>
            <p>
                @if($personnel && $personnel->poste)
                    <b>{{ $personnel->poste }}</b>
                    @if($personnel->departement)
                        <span class="erp-greeting-sep">·</span> {{ $personnel->departement->nom }}
                    @endif
                    @if($personnel->matricule)
                        <span class="erp-greeting-sep">·</span> <span style="font-family:var(--erp-mono);color:var(--erp-orange)">{{ $personnel->matricule }}</span>
                    @endif
                @else
                    Vue d'ensemble de votre espace employé
                @endif
            </p>
        </div>
        <div class="erp-greeting-right">
            <div class="erp-clock-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <span id="emp-clock">--:--</span>
            </div>
            <div class="erp-greeting-date">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="16" y1="2" x2="16" y2="6"/>
                </svg>
                {{ now()->translatedFormat('l j F Y') }}
            </div>
        </div>
    </div>

    {{-- ══ KPI ══ --}}
    <div class="erp-section-label">Indicateurs</div>
    <div class="erp-kpi-row">

        <div class="erp-kpi erp-kpi-orange">
            <div class="erp-kpi-top">
                <span class="erp-kpi-label">Documents</span>
                <div class="erp-kpi-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
            </div>
            <div class="erp-kpi-value">{{ $stats['documents'] }}</div>
            <div class="erp-kpi-badges">
                <span class="erp-badge erp-badge-orange">Dossier actif</span>
            </div>
        </div>

        <div class="erp-kpi erp-kpi-green">
            <div class="erp-kpi-top">
                <span class="erp-kpi-label">Congés restants</span>
                <div class="erp-kpi-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><path d="M9 16l2 2 4-4"/></svg>
                </div>
            </div>
            <div class="erp-kpi-value">{{ $stats['conges_restants'] }}</div>
            <div class="erp-kpi-badges">
                <span class="erp-badge erp-badge-green">Jours disponibles</span>
            </div>
        </div>

        <div class="erp-kpi erp-kpi-teal">
            <div class="erp-kpi-top">
                <span class="erp-kpi-label">Demandes</span>
                <div class="erp-kpi-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
            </div>
            <div class="erp-kpi-value">{{ $stats['demandes_en_cours'] }}</div>
            <div class="erp-kpi-badges">
                <span class="erp-badge erp-badge-teal">En cours</span>
            </div>
        </div>

        <div class="erp-kpi erp-kpi-blue">
            <div class="erp-kpi-top">
                <span class="erp-kpi-label">Ancienneté</span>
                <div class="erp-kpi-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
            </div>
            <div class="erp-kpi-value">{{ $stats['anciennete'] }}</div>
            <div class="erp-kpi-badges">
                <span class="erp-badge erp-badge-blue">{{ $stats['anciennete'] == 1 ? 'An' : 'Ans' }} de service</span>
            </div>
        </div>

    </div>

    {{-- ══ SUIVI : ACTIVITÉS + PROFIL ══ --}}
    <div class="erp-section-label">Suivi</div>
    <div class="erp-main">

        {{-- Activités récentes --}}
        <div class="erp-card">
            <div class="erp-card-head">
                <span class="erp-card-title">Activités récentes</span>
                <a href="{{ route('espace-employe.documents') }}" class="erp-card-link">
                    Voir tout
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>
            <div class="erp-feed">
                @forelse($activities as $activity)
                <div class="erp-feed-item">
                    <div class="erp-feed-dot erp-feed-dot-{{ $activity['icon'] === 'file' ? 'orange' : ($activity['icon'] === 'calendar' ? 'blue' : 'gray') }}">
                        @if($activity['icon'] === 'file')
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        @elseif($activity['icon'] === 'calendar')
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="16" y1="2" x2="16" y2="6"/></svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        @endif
                    </div>
                    <div class="erp-feed-body">
                        <div class="erp-feed-title">{{ $activity['title'] }}</div>
                        <div class="erp-feed-sub">
                            {{ $activity['date']->diffForHumans() }}
                            @if($activity['date']->isToday())
                                <span class="erp-new-pill">Nouveau</span>
                            @endif
                        </div>
                    </div>
                    <div class="erp-feed-time">{{ $activity['date']->format('d/m/Y') }}</div>
                </div>
                @empty
                <div class="erp-feed-empty">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="opacity:.3">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                    </svg>
                    Aucune activité récente
                </div>
                @endforelse
            </div>
        </div>

        {{-- Profil --}}
        <div class="erp-card">
            <div class="erp-card-head">
                <span class="erp-card-title">Mon profil</span>
                @if($personnel && $personnel->matricule)
                <span class="erp-badge erp-badge-orange">{{ $personnel->matricule }}</span>
                @endif
            </div>
            <div class="erp-profile-card">
                <div class="erp-profile-top">
                    <div class="erp-profile-avatar-wrap">
                        <img src="{{ $personnel && $personnel->photo ? asset('storage/' . $personnel->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($personnel ? $personnel->nom . '+' . $personnel->prenoms : auth()->user()->name) . '&size=200&background=f97316&color=fff&bold=true' }}"
                             alt="Photo"
                             class="erp-profile-avatar"
                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&size=200&background=f97316&color=fff&bold=true'">
                        <span class="erp-profile-online"></span>
                    </div>
                    <div style="flex:1;min-width:0">
                        <div class="erp-profile-name">{{ $personnel ? $personnel->nom_complet : auth()->user()->name }}</div>
                        <div class="erp-profile-role">{{ $personnel ? $personnel->poste : 'Employé' }}</div>
                        @if($personnel && $personnel->date_embauche)
                        <div class="erp-profile-mat">Depuis {{ $personnel->date_embauche->format('d/m/Y') }}</div>
                        @endif
                    </div>
                </div>
                <div class="erp-profile-rows">
                    @if($personnel)
                    <div class="erp-profile-row">
                        <div class="erp-profile-row-ic"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></div>
                        <div class="erp-profile-row-info">
                            <div class="erp-profile-row-lbl">Département</div>
                            <div class="erp-profile-row-val">{{ $personnel->departement->nom ?? 'Non assigné' }}</div>
                        </div>
                    </div>
                    <div class="erp-profile-row">
                        <div class="erp-profile-row-ic"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg></div>
                        <div class="erp-profile-row-info">
                            <div class="erp-profile-row-lbl">Service</div>
                            <div class="erp-profile-row-val">{{ $personnel->service->nom ?? 'Non assigné' }}</div>
                        </div>
                    </div>
                    @endif
                    <div class="erp-profile-row">
                        <div class="erp-profile-row-ic"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></div>
                        <div class="erp-profile-row-info">
                            <div class="erp-profile-row-lbl">Email</div>
                            <div class="erp-profile-row-val">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                </div>
                <div class="erp-profile-footer">
                    <a href="{{ route('espace-employe.profil') }}" class="erp-btn-blue">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Voir mon profil complet
                    </a>
                </div>
            </div>
        </div>

    </div>{{-- /erp-main --}}

    {{-- ══ RÉSUMÉ RAPIDE ══ --}}
    <div class="erp-section-label">Résumé</div>
    <div class="erp-summary" style="margin-bottom:12px">
        <div class="erp-summary-inner">
            <div class="erp-summary-cell accent-orange">
                <div class="erp-summary-cell-label">Documents</div>
                <div class="erp-summary-cell-value">{{ $stats['documents'] }}</div>
            </div>
            <div class="erp-summary-cell accent-green">
                <div class="erp-summary-cell-label">Congés restants</div>
                <div class="erp-summary-cell-value">{{ $stats['conges_restants'] }} j.</div>
            </div>
            <div class="erp-summary-cell accent-teal">
                <div class="erp-summary-cell-label">Demandes en cours</div>
                <div class="erp-summary-cell-value">{{ $stats['demandes_en_cours'] }}</div>
            </div>
            <div class="erp-summary-cell accent-blue">
                <div class="erp-summary-cell-label">Ancienneté</div>
                <div class="erp-summary-cell-value">{{ $stats['anciennete'] }} ans</div>
            </div>
        </div>
    </div>

    {{-- ══ ACTIONS RAPIDES ══ --}}
    <div class="erp-section-label">Actions rapides</div>
    <div class="erp-actions">
        <div class="erp-actions-inner">
            <a href="{{ route('espace-employe.conges') }}" class="erp-action-pill orange-action">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><path d="M9 16h6"/></svg>
                Demander un congé
            </a>
            <a href="{{ route('espace-employe.bulletins') }}" class="erp-action-pill">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                Bulletins de paie
            </a>
            <a href="{{ route('espace-employe.attestations') }}" class="erp-action-pill">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><path d="M9 15l2 2 4-4"/></svg>
                Attestations
            </a>
            <a href="{{ route('espace-employe.documents') }}" class="erp-action-pill">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                Mes documents
            </a>
            <a href="{{ route('espace-employe.demandes') }}" class="erp-action-pill">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Mes demandes
            </a>
            <a href="{{ route('espace-employe.profil') }}" class="erp-action-pill">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Mon profil
            </a>
        </div>
    </div>

</div>{{-- /.emp-root --}}
@endsection

@section('scripts')
<script>
(function () {
    var DAYS = ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
    function p(n) { return String(n).padStart(2,'0'); }

    // Greeting
    var h0 = new Date().getHours();
    var grEl = document.getElementById('emp-greeting');
    if (grEl) {
        var w = h0 < 12 ? 'Bonjour' : h0 < 18 ? 'Bon après-midi' : 'Bonsoir';
        grEl.childNodes[0].textContent = w + ', ';
    }

    // Live clock
    function tick() {
        var now = new Date();
        var el = document.getElementById('emp-clock');
        if (el) el.textContent = p(now.getHours()) + ':' + p(now.getMinutes()) + ':' + p(now.getSeconds());
    }
    tick();
    setInterval(tick, 1000);
})();
</script>
@endsection
