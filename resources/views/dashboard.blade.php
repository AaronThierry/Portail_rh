@extends('layouts.app')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')
@section('page-subtitle', 'Vue d\'ensemble de votre activite')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <rect x="3" y="3" width="7" height="7" rx="1"></rect>
    <rect x="14" y="3" width="7" height="7" rx="1"></rect>
    <rect x="3" y="14" width="7" height="7" rx="1"></rect>
    <rect x="14" y="14" width="7" height="7" rx="1"></rect>
</svg>
@endsection

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
/* ═══════════════════════════════════════════════════════════
   ERP DASHBOARD — Precision Dark  ·  Bleu · Gris · Orange
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
    --erp-blue-dim:  #1d4ed8;
    --erp-orange:    #f97316;
    --erp-orange-dim:#c2410c;
    --erp-green:     #22c55e;
    --erp-red:       #ef4444;
    --erp-amber:     #f59e0b;
    --erp-mono:      'DM Mono', monospace;
    --erp-sans:      'DM Sans', sans-serif;
}

.erp-root {
    font-family: var(--erp-sans);
    color: var(--erp-text);
    padding: 0 4px;
    animation: erp-page-in 0.4s ease both;
}

@keyframes erp-page-in {
    from { opacity: 0; transform: translateY(8px); }
    to   { opacity: 1; transform: translateY(0);   }
}

/* ── Section header ───────────────────────────────────────── */
.erp-section-label {
    font-size: 0.6875rem;
    font-weight: 700;
    letter-spacing: 0.1em;
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

/* ── Greeting bar ─────────────────────────────────────────── */
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
    letter-spacing: -0.02em;
    margin: 0 0 2px;
}

.erp-greeting-left p {
    font-size: 0.78rem;
    color: var(--erp-text-2);
    margin: 0;
}

.erp-greeting-date {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.75rem;
    font-weight: 500;
    color: var(--erp-text-3);
    background: var(--erp-surface);
    border: 1px solid var(--erp-border);
    padding: 5px 12px;
    border-radius: 6px;
    letter-spacing: 0.01em;
}

.erp-greeting-date svg { color: var(--erp-blue); flex-shrink: 0; }

/* ── KPI row ──────────────────────────────────────────────── */
.erp-kpi-row {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
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

.erp-kpi:nth-child(1) { animation-delay: .04s; }
.erp-kpi:nth-child(2) { animation-delay: .08s; }
.erp-kpi:nth-child(3) { animation-delay: .12s; }
.erp-kpi:nth-child(4) { animation-delay: .16s; }
.erp-kpi:nth-child(5) { animation-delay: .20s; }

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

.erp-kpi:hover {
    border-color: var(--erp-border-2);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,0,0,.4);
}

.erp-kpi:hover::before { opacity: 1; }

.erp-kpi-blue::before  { background: linear-gradient(90deg, var(--erp-blue), #818cf8); }
.erp-kpi-orange::before { background: linear-gradient(90deg, var(--erp-orange), var(--erp-amber)); }
.erp-kpi-green::before { background: linear-gradient(90deg, var(--erp-green), #34d399); }
.erp-kpi-red::before   { background: linear-gradient(90deg, var(--erp-red), #f87171); }
.erp-kpi-teal::before  { background: linear-gradient(90deg, #06b6d4, #0891b2); }

.erp-kpi-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
}

.erp-kpi-label {
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--erp-text-3);
}

.erp-kpi-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.erp-kpi-blue   .erp-kpi-icon { background: rgba(59,130,246,.12); color: var(--erp-blue); }
.erp-kpi-orange .erp-kpi-icon { background: rgba(249,115,22,.12); color: var(--erp-orange); }
.erp-kpi-green  .erp-kpi-icon { background: rgba(34,197,94,.12);  color: var(--erp-green); }
.erp-kpi-red    .erp-kpi-icon { background: rgba(239,68,68,.12);  color: var(--erp-red); }
.erp-kpi-teal   .erp-kpi-icon { background: rgba(6,182,212,.12);  color: #06b6d4; }

.erp-kpi-value {
    font-family: var(--erp-mono);
    font-size: 1.8rem;
    font-weight: 500;
    line-height: 1;
    letter-spacing: -0.03em;
    margin-bottom: 8px;
}

.erp-kpi-blue   .erp-kpi-value { color: #e8f0ff; }
.erp-kpi-orange .erp-kpi-value { color: #fff0e6; }
.erp-kpi-green  .erp-kpi-value { color: #e6fff3; }
.erp-kpi-red    .erp-kpi-value { color: #ffe6e6; }
.erp-kpi-teal   .erp-kpi-value { color: #e6faff; }

.erp-kpi-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
}

.erp-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 2px 7px;
    border-radius: 4px;
    font-size: 0.6rem;
    font-weight: 700;
    letter-spacing: 0.03em;
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
.erp-badge-red    { background: rgba(239,68,68,.1);   color: #f87171; }
.erp-badge-red::before    { background: #ef4444; }
.erp-badge-orange { background: rgba(249,115,22,.1);  color: #fb923c; }
.erp-badge-orange::before { background: #f97316; }
.erp-badge-gray   { background: rgba(100,116,139,.1); color: #94a3b8; }
.erp-badge-gray::before   { background: #64748b; }

/* ── Main layout: chart + activity ───────────────────────── */
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
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--erp-text);
    letter-spacing: -0.01em;
}

.erp-card-meta {
    font-size: 0.67rem;
    color: var(--erp-text-3);
    font-weight: 500;
    letter-spacing: 0.02em;
}

.erp-card-body {
    flex: 1;
    padding: 14px 16px;
    overflow: hidden;
    position: relative;
}

/* Pill legend */
.erp-legend {
    display: flex;
    gap: 8px;
}

.erp-legend-pill {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 0.63rem;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}

.erp-legend-pill-blue   { background: rgba(59,130,246,.1); color: #60a5fa; border: 1px solid rgba(59,130,246,.2); }
.erp-legend-pill-orange { background: rgba(249,115,22,.1); color: #fb923c; border: 1px solid rgba(249,115,22,.2); }

.erp-legend-dot {
    width: 6px; height: 6px;
    border-radius: 2px;
    flex-shrink: 0;
}

/* ── Activity feed ────────────────────────────────────────── */
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
    align-items: flex-start;
    gap: 10px;
    padding: 8px 16px;
    transition: background .15s;
    animation: erp-feed-in .3s ease both;
}

.erp-feed-item:nth-child(1) { animation-delay:.05s; }
.erp-feed-item:nth-child(2) { animation-delay:.10s; }
.erp-feed-item:nth-child(3) { animation-delay:.15s; }
.erp-feed-item:nth-child(4) { animation-delay:.20s; }
.erp-feed-item:nth-child(5) { animation-delay:.25s; }
.erp-feed-item:nth-child(6) { animation-delay:.30s; }
.erp-feed-item:nth-child(7) { animation-delay:.35s; }
.erp-feed-item:nth-child(8) { animation-delay:.40s; }

@keyframes erp-feed-in {
    from { opacity: 0; transform: translateX(-5px); }
    to   { opacity: 1; transform: translateX(0);    }
}

.erp-feed-item:hover { background: var(--erp-surface-2); }

.erp-feed-dot {
    width: 28px;
    height: 28px;
    border-radius: 7px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 1px;
}

.erp-feed-dot-success { background: rgba(34,197,94,.13);  color: #4ade80; }
.erp-feed-dot-danger  { background: rgba(239,68,68,.13);  color: #f87171; }
.erp-feed-dot-warning { background: rgba(245,158,11,.13); color: #fbbf24; }
.erp-feed-dot-info    { background: rgba(6,182,212,.13);  color: #22d3ee; }
.erp-feed-dot-primary { background: rgba(59,130,246,.13); color: #60a5fa; }

.erp-feed-text { flex: 1; min-width: 0; }

.erp-feed-title {
    font-size: 0.775rem;
    font-weight: 600;
    color: var(--erp-text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.35;
}

.erp-feed-desc {
    font-size: 0.7rem;
    color: var(--erp-text-2);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.4;
}

.erp-feed-time {
    font-family: var(--erp-mono);
    font-size: 0.63rem;
    color: var(--erp-text-3);
    flex-shrink: 0;
    margin-top: 4px;
    letter-spacing: 0.02em;
}

.erp-feed-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    gap: 8px;
    color: var(--erp-text-3);
    font-size: 0.78rem;
}

/* ── Summary strip ────────────────────────────────────────── */
.erp-summary {
    background: var(--erp-surface);
    border: 1px solid var(--erp-border);
    border-radius: 10px;
    padding: 0;
    margin-bottom: 12px;
    overflow: hidden;
}

.erp-summary-inner {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
}

.erp-summary-cell {
    padding: 13px 16px;
    border-right: 1px solid var(--erp-border);
    position: relative;
    transition: background .15s;
}

.erp-summary-cell:last-child { border-right: none; }
.erp-summary-cell:hover { background: var(--erp-surface-2); }

.erp-summary-cell-label {
    font-size: 0.61rem;
    font-weight: 700;
    letter-spacing: 0.07em;
    text-transform: uppercase;
    color: var(--erp-text-3);
    margin-bottom: 5px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.erp-summary-cell-value {
    font-family: var(--erp-mono);
    font-size: 1.15rem;
    font-weight: 500;
    color: var(--erp-text);
    letter-spacing: -0.02em;
    line-height: 1.2;
}

.erp-summary-cell.accent-blue .erp-summary-cell-value  { color: #60a5fa; }
.erp-summary-cell.accent-orange .erp-summary-cell-value { color: #fb923c; }
.erp-summary-cell.accent-green .erp-summary-cell-value  { color: #4ade80; }

/* ── Quick actions ────────────────────────────────────────── */
.erp-actions {
    background: var(--erp-surface);
    border: 1px solid var(--erp-border);
    border-radius: 10px;
    padding: 12px 16px;
    margin-bottom: 4px;
}

.erp-actions-inner {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

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
    font-size: 0.775rem;
    font-weight: 600;
    letter-spacing: 0.01em;
    transition: all .18s ease;
    white-space: nowrap;
}

.erp-action-pill svg { flex-shrink: 0; transition: transform .18s ease; }

.erp-action-pill:hover {
    background: var(--erp-blue);
    border-color: var(--erp-blue);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 16px rgba(59,130,246,.35);
}

.erp-action-pill:hover svg { transform: scale(1.1); }

.erp-action-pill.orange-action:hover {
    background: var(--erp-orange);
    border-color: var(--erp-orange);
    box-shadow: 0 4px 16px rgba(249,115,22,.35);
}

/* ── Responsive ───────────────────────────────────────────── */
@media (max-width: 1200px) {
    .erp-kpi-row { grid-template-columns: repeat(3, 1fr); }
    .erp-summary-inner { grid-template-columns: repeat(3, 1fr); }
    .erp-summary-cell:nth-child(3) { border-right: none; }
    .erp-summary-cell:nth-child(4) { border-top: 1px solid var(--erp-border); }
    .erp-summary-cell:nth-child(5) { border-top: 1px solid var(--erp-border); }
    .erp-summary-cell:nth-child(6) { border-top: 1px solid var(--erp-border); border-right: none; }
}

@media (max-width: 900px) {
    .erp-kpi-row  { grid-template-columns: repeat(2, 1fr); }
    .erp-main     { grid-template-columns: 1fr; height: auto; }
    .erp-main .erp-card:first-child { height: 280px; }
    .erp-main .erp-card:last-child  { height: 260px; }
    .erp-summary-inner { grid-template-columns: repeat(2, 1fr); }
    .erp-summary-cell { border-right: 1px solid var(--erp-border); }
    .erp-summary-cell:nth-child(2n) { border-right: none; }
    .erp-summary-cell:nth-child(n+3) { border-top: 1px solid var(--erp-border); }
}
</style>
@endsection

@section('content')
<div class="erp-root">

    {{-- ── GREETING ──────────────────────────────────────────── --}}
    <div class="erp-greeting">
        <div class="erp-greeting-left">
            <h1>Bonjour, {{ auth()->user()->prenom ?? auth()->user()->name ?? 'Admin' }}</h1>
            <p>Vue d'ensemble de votre portail RH</p>
        </div>
        <div class="erp-greeting-date">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="16" y1="2" x2="16" y2="6"/>
            </svg>
            {{ now()->translatedFormat('l j F Y') }}
        </div>
    </div>

    {{-- ── KPI ROW ───────────────────────────────────────────── --}}
    <div class="erp-section-label">Indicateurs</div>
    <div class="erp-kpi-row">

        {{-- Employés actifs --}}
        <div class="erp-kpi erp-kpi-blue">
            <div class="erp-kpi-top">
                <span class="erp-kpi-label">Employés actifs</span>
                <div class="erp-kpi-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
            </div>
            <div class="erp-kpi-value">{{ $totalEmployes }}</div>
            <div class="erp-kpi-badges">
                <span class="erp-badge erp-badge-blue">{{ $employesAvecCompte }} avec compte</span>
            </div>
        </div>

        {{-- Congés en attente --}}
        <div class="erp-kpi erp-kpi-orange">
            <div class="erp-kpi-top">
                <span class="erp-kpi-label">Congés attente</span>
                <div class="erp-kpi-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
            </div>
            <div class="erp-kpi-value">{{ $statsConges['en_attente'] }}</div>
            <div class="erp-kpi-badges">
                <span class="erp-badge erp-badge-green">{{ $statsConges['approuve'] }} approuvés</span>
                <span class="erp-badge erp-badge-red">{{ $statsConges['refuse'] }} refusés</span>
            </div>
        </div>

        {{-- Absences en attente --}}
        <div class="erp-kpi erp-kpi-teal">
            <div class="erp-kpi-top">
                <span class="erp-kpi-label">Absences attente</span>
                <div class="erp-kpi-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                </div>
            </div>
            <div class="erp-kpi-value">{{ $statsAbsences['en_attente'] }}</div>
            <div class="erp-kpi-badges">
                <span class="erp-badge erp-badge-green">{{ $statsAbsences['justifiees'] }} justifiées</span>
                <span class="erp-badge erp-badge-red">{{ $statsAbsences['injustifiees'] }} injust.</span>
            </div>
        </div>

        {{-- Bulletins --}}
        <div class="erp-kpi erp-kpi-blue">
            <div class="erp-kpi-top">
                <span class="erp-kpi-label">Bulletins {{ $annee }}</span>
                <div class="erp-kpi-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                </div>
            </div>
            <div class="erp-kpi-value">{{ $statsBulletins['total_bulletins'] }}</div>
            <div class="erp-kpi-badges">
                <span class="erp-badge erp-badge-blue">{{ $statsBulletins['total_employes'] }} employés</span>
            </div>
        </div>

        {{-- Documents expirant --}}
        <div class="erp-kpi erp-kpi-{{ $docsExpirentBientot > 0 ? 'red' : 'green' }}">
            <div class="erp-kpi-top">
                <span class="erp-kpi-label">Docs expirant</span>
                <div class="erp-kpi-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                </div>
            </div>
            <div class="erp-kpi-value">{{ $docsExpirentBientot }}</div>
            <div class="erp-kpi-badges">
                @if($docsExpirentBientot > 0)
                    <span class="erp-badge erp-badge-orange">À renouveler</span>
                @else
                    <span class="erp-badge erp-badge-green">Tout est en ordre</span>
                @endif
            </div>
        </div>

    </div>{{-- /kpi-row --}}

    {{-- ── CHART + ACTIVITÉS ────────────────────────────────── --}}
    <div class="erp-section-label">Suivi</div>
    <div class="erp-main">

        {{-- Graphique --}}
        <div class="erp-card">
            <div class="erp-card-head">
                <span class="erp-card-title">Congés &amp; Absences</span>
                <div style="display:flex;align-items:center;gap:10px;">
                    <div class="erp-legend">
                        <div class="erp-legend-pill erp-legend-pill-blue">
                            <div class="erp-legend-dot" style="background:#3b82f6;"></div>
                            Congés
                        </div>
                        <div class="erp-legend-pill erp-legend-pill-orange">
                            <div class="erp-legend-dot" style="background:#f97316;"></div>
                            Absences
                        </div>
                    </div>
                    <span class="erp-card-meta">{{ $annee }}</span>
                </div>
            </div>
            <div class="erp-card-body">
                <canvas id="chartErpMain"></canvas>
            </div>
        </div>

        {{-- Activités récentes --}}
        <div class="erp-card">
            <div class="erp-card-head">
                <span class="erp-card-title">Activités récentes</span>
                @if($activitesRecentes->count() > 0)
                <span class="erp-badge erp-badge-gray">{{ $activitesRecentes->count() }}</span>
                @endif
            </div>
            <div class="erp-feed">
                @forelse($activitesRecentes as $activite)
                <div class="erp-feed-item">
                    <div class="erp-feed-dot erp-feed-dot-{{ $activite['icon'] }}">
                        @if($activite['type'] === 'conge')
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                @if($activite['icon'] === 'success')
                                    <polyline points="20 6 9 17 4 12"/>
                                @else
                                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                                @endif
                            </svg>
                        @elseif($activite['type'] === 'demande_conge')
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                        @elseif($activite['type'] === 'absence')
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/>
                            </svg>
                        @elseif($activite['type'] === 'bulletin')
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/>
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/>
                            </svg>
                        @endif
                    </div>
                    <div class="erp-feed-text">
                        <div class="erp-feed-title">{{ $activite['titre'] }}</div>
                        <div class="erp-feed-desc">{{ $activite['description'] }}</div>
                    </div>
                    <div class="erp-feed-time">{{ $activite['date']->diffForHumans() }}</div>
                </div>
                @empty
                <div class="erp-feed-empty">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="opacity:.3">
                        <rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/>
                    </svg>
                    Aucune activité récente
                </div>
                @endforelse
            </div>
        </div>

    </div>{{-- /erp-main --}}

    {{-- ── RÉSUMÉ ANNUEL ─────────────────────────────────────── --}}
    <div class="erp-section-label">Résumé annuel — {{ $annee }}</div>
    <div class="erp-summary">
        <div class="erp-summary-inner">
            <div class="erp-summary-cell">
                <div class="erp-summary-cell-label">Total congés</div>
                <div class="erp-summary-cell-value">{{ $statsConges['total'] }}</div>
            </div>
            <div class="erp-summary-cell">
                <div class="erp-summary-cell-label">Total absences</div>
                <div class="erp-summary-cell-value">{{ $statsAbsences['total'] }}</div>
            </div>
            <div class="erp-summary-cell">
                <div class="erp-summary-cell-label">Retards</div>
                <div class="erp-summary-cell-value">{{ $statsAbsences['retards'] }}</div>
            </div>
            <div class="erp-summary-cell">
                <div class="erp-summary-cell-label">Bulletins émis</div>
                <div class="erp-summary-cell-value accent-blue">{{ $statsBulletins['total_bulletins'] }}</div>
            </div>
            <div class="erp-summary-cell">
                <div class="erp-summary-cell-label">Masse sal. nette</div>
                <div class="erp-summary-cell-value accent-orange" style="font-size:.9rem;">
                    {{ number_format($statsBulletins['masse_salariale_nette'] ?? 0, 0, ',', ' ') }}&nbsp;F
                </div>
            </div>
            <div class="erp-summary-cell">
                <div class="erp-summary-cell-label">Entreprises</div>
                <div class="erp-summary-cell-value">{{ $totalEntreprises }}</div>
            </div>
        </div>
    </div>

    {{-- ── ACTIONS RAPIDES ──────────────────────────────────── --}}
    <div class="erp-section-label">Actions rapides</div>
    <div class="erp-actions">
        <div class="erp-actions-inner">

            @if(auth()->user()->hasRole('Super Admin'))
            <a href="{{ route('admin.entreprises.index') }}" class="erp-action-pill">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                Entreprises
            </a>
            @endif

            <a href="{{ route('admin.personnels.index') }}" class="erp-action-pill orange-action">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/>
                    <line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/>
                </svg>
                Ajouter employé
            </a>

            <a href="{{ route('admin.conges.index') }}" class="erp-action-pill">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                Gestion congés
            </a>

            <a href="{{ route('admin.absences.index') }}" class="erp-action-pill">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                Gestion absences
            </a>

            <a href="{{ route('admin.dossiers-agents.index') }}" class="erp-action-pill">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/>
                </svg>
                Dossiers Agents
            </a>

            <a href="{{ route('admin.bulletins-paie.index') }}" class="erp-action-pill">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
                Bulletins de Paie
            </a>

        </div>
    </div>

</div>{{-- /erp-root --}}
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('chartErpMain');
    if (!canvas) return;

    const moisLabels   = @json($moisLabels);
    const congesData   = @json($congesParMois);
    const absencesData = @json($absencesParMois);

    const ctx = canvas.getContext('2d');

    const congeGrad = ctx.createLinearGradient(0, 0, 0, 240);
    congeGrad.addColorStop(0, 'rgba(59,130,246,0.75)');
    congeGrad.addColorStop(1, 'rgba(59,130,246,0.08)');

    const absenceGrad = ctx.createLinearGradient(0, 0, 0, 240);
    absenceGrad.addColorStop(0, 'rgba(249,115,22,0.75)');
    absenceGrad.addColorStop(1, 'rgba(249,115,22,0.08)');

    new Chart(canvas, {
        type: 'bar',
        data: {
            labels: moisLabels,
            datasets: [
                {
                    label: 'Congés approuvés',
                    data: congesData,
                    backgroundColor: congeGrad,
                    borderColor: 'rgba(59,130,246,0.85)',
                    borderWidth: 1,
                    borderRadius: 4,
                    borderSkipped: false,
                },
                {
                    label: 'Absences',
                    data: absencesData,
                    backgroundColor: absenceGrad,
                    borderColor: 'rgba(249,115,22,0.85)',
                    borderWidth: 1,
                    borderRadius: 4,
                    borderSkipped: false,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { intersect: false, mode: 'index' },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0e1726',
                    titleColor: '#e8edf5',
                    bodyColor: '#8899aa',
                    borderColor: '#1c2a3d',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 8,
                    titleFont: { size: 11, weight: '700', family: "'DM Sans', sans-serif" },
                    bodyFont:  { size: 11, family: "'DM Mono', monospace" },
                    boxWidth: 8, boxHeight: 8, boxPadding: 4,
                    usePointStyle: true, pointStyle: 'rectRounded',
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    border: { display: false },
                    ticks: {
                        color: '#4d6070',
                        font: { size: 10, weight: '600', family: "'DM Sans', sans-serif" },
                        maxRotation: 0,
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#1c2a3d', drawBorder: false },
                    border: { display: false, dash: [3, 3] },
                    ticks: {
                        color: '#4d6070',
                        font: { size: 10, family: "'DM Mono', monospace" },
                        stepSize: 1,
                        precision: 0,
                        padding: 6,
                    }
                }
            },
            animation: { duration: 700, easing: 'easeOutQuart' }
        }
    });
});
</script>
@endsection
