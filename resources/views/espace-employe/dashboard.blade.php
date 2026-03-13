@extends('layouts.espace-employe')

@section('title', 'Mon Espace')
@section('page-title', 'Tableau de bord')
@section('breadcrumb')
    <span>Accueil</span>
@endsection

@section('styles')
<style>
/* ============================================================
   DASHBOARD ERP PRO — Espace Employé
   Rippling / Workday / SAP Fiori aesthetic
   Light · Structured · Data-forward
   ============================================================ */

/* ── Reset / Base ─────────────────────────────────────── */
.db-page { --db-bg: #f8fafc; --db-surface: #ffffff; --db-border: #e2e8f0;
    --db-text: #0f172a; --db-text-2: #475569; --db-text-3: #94a3b8;
    --db-orange: #f97316; --db-orange-pale: #fff7ed; --db-orange-border: #fed7aa;
    --db-blue: #2563eb; --db-blue-pale: #eff6ff; --db-blue-border: #bfdbfe;
    --db-green: #16a34a; --db-green-pale: #f0fdf4; --db-green-border: #bbf7d0;
    --db-amber: #d97706; --db-amber-pale: #fffbeb; --db-amber-border: #fde68a;
    --db-shadow: 0 1px 3px rgba(15,23,42,.06), 0 1px 2px rgba(15,23,42,.04);
    --db-shadow-md: 0 4px 12px rgba(15,23,42,.08), 0 2px 4px rgba(15,23,42,.04);
    background: var(--db-bg) !important;
}

@keyframes db-in {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes db-prog-grow { from { width: 0 } }

.db-page {
    display: flex;
    flex-direction: column;
    gap: 16px;
    max-width: 1120px;
    animation: db-in .3s ease both;
}

/* ── HERO ─────────────────────────────────────────────── */
.db-hero {
    background: var(--db-surface);
    border: 1px solid var(--db-border);
    border-left: 4px solid var(--db-orange);
    border-radius: 10px;
    box-shadow: var(--db-shadow);
    display: flex;
    align-items: stretch;
    justify-content: space-between;
    overflow: hidden;
}

.db-hero-left {
    padding: 24px 28px;
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 6px;
}

.db-hero-eyebrow {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 2px;
}
.db-hero-ts {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: .7rem;
    font-weight: 600;
    color: var(--db-text-3);
    letter-spacing: .04em;
    padding: 3px 8px;
    border: 1px solid var(--db-border);
    border-radius: 5px;
    background: var(--db-bg);
    font-variant-numeric: tabular-nums;
}
.db-hero-ts span { color: var(--db-orange); font-weight: 700; }

.db-hero-status {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: .68rem;
    font-weight: 600;
    color: var(--db-green);
    letter-spacing: .03em;
}
.db-hero-status::before {
    content: '';
    width: 6px; height: 6px;
    background: var(--db-green);
    border-radius: 50%;
    animation: db-pulse-dot 2s ease-in-out infinite;
}
@keyframes db-pulse-dot {
    0%, 100% { box-shadow: 0 0 0 0 rgba(22,163,74,.35); }
    50%       { box-shadow: 0 0 0 4px rgba(22,163,74,0); }
}

.db-hero-name {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--db-text);
    letter-spacing: -.035em;
    line-height: 1.15;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.db-hero-name em { font-style: normal; color: var(--db-orange); }

.db-hero-meta {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
    margin-top: 2px;
}
.db-hero-meta-item {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: .75rem;
    font-weight: 500;
    color: var(--db-text-2);
}
.db-hero-meta-item svg { width: 12px; height: 12px; color: var(--db-text-3); flex-shrink: 0; }
.db-hero-divider { width: 3px; height: 3px; background: var(--db-border); border-radius: 50%; flex-shrink: 0; }
.db-hero-mat {
    display: inline-flex;
    align-items: center;
    font-size: .68rem;
    font-weight: 700;
    letter-spacing: .06em;
    color: var(--db-orange);
    background: var(--db-orange-pale);
    border: 1px solid var(--db-orange-border);
    padding: 2px 7px;
    border-radius: 4px;
    text-transform: uppercase;
}

/* Date/clock panel */
.db-hero-right {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0;
    padding: 20px 28px;
    border-left: 1px solid var(--db-border);
    background: var(--db-bg);
    min-width: 188px;
    text-align: center;
}
.db-date-day-name {
    font-size: .6rem;
    font-weight: 700;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: var(--db-text-3);
    margin-bottom: 2px;
}
.db-date-num {
    font-size: 3rem;
    font-weight: 800;
    color: var(--db-text);
    letter-spacing: -.06em;
    line-height: 1;
}
.db-date-month {
    font-size: .65rem;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--db-orange);
    margin-top: 1px;
    margin-bottom: 10px;
}
.db-clock-row {
    display: flex;
    align-items: baseline;
    gap: 2px;
    font-variant-numeric: tabular-nums;
}
.db-clock-hhmm {
    font-size: 1.35rem;
    font-weight: 700;
    color: var(--db-text);
    letter-spacing: -.02em;
}
.db-clock-ss {
    font-size: .78rem;
    font-weight: 500;
    color: var(--db-text-3);
}
.db-prog-track {
    width: 100%;
    height: 2px;
    background: var(--db-border);
    border-radius: 2px;
    margin-top: 10px;
    overflow: hidden;
}
.db-prog-fill {
    height: 100%;
    background: var(--db-orange);
    border-radius: 2px;
    animation: db-prog-grow .8s ease both .3s;
    transition: width 1s linear;
}
.db-prog-label {
    font-size: .6rem;
    color: var(--db-text-3);
    margin-top: 4px;
    font-weight: 500;
    letter-spacing: .03em;
}

/* ── KPI GRID ─────────────────────────────────────────── */
.db-kpi-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
}

.db-kpi {
    background: var(--db-surface);
    border: 1px solid var(--db-border);
    border-radius: 10px;
    box-shadow: var(--db-shadow);
    padding: 20px 20px 0;
    display: flex;
    flex-direction: column;
    gap: 0;
    position: relative;
    overflow: hidden;
    transition: transform .18s ease, box-shadow .18s ease;
    cursor: default;
}
.db-kpi:hover {
    transform: translateY(-3px);
    box-shadow: var(--db-shadow-md);
}

.db-kpi-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 12px;
}
.db-kpi-icon {
    width: 40px; height: 40px;
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.db-kpi-icon svg { width: 18px; height: 18px; }
.db-kpi-icon.kpi-orange { background: var(--db-orange-pale); color: var(--db-orange); }
.db-kpi-icon.kpi-green  { background: var(--db-green-pale); color: var(--db-green); }
.db-kpi-icon.kpi-amber  { background: var(--db-amber-pale); color: var(--db-amber); }
.db-kpi-icon.kpi-blue   { background: var(--db-blue-pale); color: var(--db-blue); }

.db-kpi-trend {
    font-size: .68rem;
    font-weight: 600;
    padding: 2px 6px;
    border-radius: 4px;
    letter-spacing: .02em;
}
.db-kpi-trend.ok { color: var(--db-green); background: var(--db-green-pale); }
.db-kpi-trend.pending { color: var(--db-amber); background: var(--db-amber-pale); }
.db-kpi-trend.info { color: var(--db-blue); background: var(--db-blue-pale); }
.db-kpi-trend.active { color: var(--db-orange); background: var(--db-orange-pale); }

.db-kpi-val {
    font-size: 2.4rem;
    font-weight: 800;
    color: var(--db-text);
    letter-spacing: -.05em;
    line-height: 1;
    margin-bottom: 4px;
    font-variant-numeric: tabular-nums;
}
.db-kpi-label {
    font-size: .7rem;
    font-weight: 600;
    color: var(--db-text-3);
    text-transform: uppercase;
    letter-spacing: .07em;
    margin-bottom: 16px;
}
.db-kpi-bar {
    height: 3px;
    border-radius: 0 0 10px 10px;
    margin: 0 -20px;
    margin-top: auto;
}
.db-kpi-bar.bar-orange { background: var(--db-orange); }
.db-kpi-bar.bar-green  { background: var(--db-green); }
.db-kpi-bar.bar-amber  { background: var(--db-amber); }
.db-kpi-bar.bar-blue   { background: var(--db-blue); }

/* ── CONTENT GRID ─────────────────────────────────────── */
.db-content {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 16px;
    align-items: start;
}

/* ── CARD BASE ────────────────────────────────────────── */
.db-card {
    background: var(--db-surface);
    border: 1px solid var(--db-border);
    border-radius: 10px;
    box-shadow: var(--db-shadow);
    overflow: hidden;
}
.db-card-hd {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 20px;
    border-bottom: 1px solid var(--db-border);
}
.db-card-title {
    font-size: .8rem;
    font-weight: 700;
    color: var(--db-text);
    text-transform: uppercase;
    letter-spacing: .08em;
    display: flex;
    align-items: center;
    gap: 8px;
}
.db-card-title-bar {
    width: 3px; height: 14px;
    background: var(--db-orange);
    border-radius: 2px;
    flex-shrink: 0;
}
.db-card-badge {
    display: inline-flex;
    align-items: center;
    font-size: .68rem;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 20px;
    background: var(--db-bg);
    border: 1px solid var(--db-border);
    color: var(--db-text-2);
}
.db-card-link {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    font-size: .72rem;
    font-weight: 600;
    color: var(--db-blue);
    text-decoration: none;
    padding: 4px 8px;
    border-radius: 5px;
    transition: background .15s;
}
.db-card-link:hover { background: var(--db-blue-pale); }
.db-card-link svg { width: 11px; height: 11px; transition: transform .15s; }
.db-card-link:hover svg { transform: translateX(2px); }

/* ── ACTIVITY FEED ────────────────────────────────────── */
.db-act-list { padding: 4px 0; }

.db-act-row {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 12px 20px;
    border-bottom: 1px solid #f1f5f9;
    transition: background .12s;
}
.db-act-row:last-child { border-bottom: none; }
.db-act-row:hover { background: #fafbfc; }

.db-act-icon {
    width: 36px; height: 36px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    border: 1px solid var(--db-border);
}
.db-act-icon svg { width: 15px; height: 15px; }
.db-act-icon.file     { background: var(--db-orange-pale); color: var(--db-orange); border-color: var(--db-orange-border); }
.db-act-icon.calendar { background: var(--db-blue-pale); color: var(--db-blue); border-color: var(--db-blue-border); }
.db-act-icon.user     { background: #f8fafc; color: var(--db-text-3); }

.db-act-body { flex: 1; min-width: 0; }
.db-act-title {
    font-size: .82rem;
    font-weight: 600;
    color: var(--db-text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.db-act-sub {
    font-size: .7rem;
    color: var(--db-text-3);
    margin-top: 1px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.db-badge-new {
    font-size: .6rem;
    font-weight: 700;
    letter-spacing: .04em;
    text-transform: uppercase;
    padding: 1px 5px;
    border-radius: 3px;
    background: var(--db-orange-pale);
    color: var(--db-orange);
    border: 1px solid var(--db-orange-border);
}

.db-act-date {
    font-size: .7rem;
    color: var(--db-text-3);
    font-weight: 500;
    white-space: nowrap;
    flex-shrink: 0;
}

/* Empty state */
.db-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 44px 20px;
    gap: 10px;
}
.db-empty-icon {
    width: 48px; height: 48px;
    background: var(--db-bg);
    border: 1px solid var(--db-border);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
}
.db-empty-icon svg { width: 22px; height: 22px; color: var(--db-text-3); opacity: .5; }
.db-empty-txt {
    font-size: .8rem;
    color: var(--db-text-3);
    font-weight: 500;
}

/* ── RIGHT COLUMN ─────────────────────────────────────── */
.db-right { display: flex; flex-direction: column; gap: 14px; }

/* Profile card */
.db-prof-top {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 18px 18px 14px;
    border-bottom: 1px solid var(--db-border);
}
.db-prof-avatar-wrap { position: relative; flex-shrink: 0; }
.db-prof-avatar {
    width: 56px; height: 56px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--db-orange);
    display: block;
}
.db-prof-online {
    position: absolute;
    bottom: 1px; right: 1px;
    width: 11px; height: 11px;
    background: var(--db-green);
    border: 2px solid white;
    border-radius: 50%;
}
.db-prof-id { min-width: 0; flex: 1; }
.db-prof-name {
    font-size: .9rem;
    font-weight: 700;
    color: var(--db-text);
    letter-spacing: -.02em;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.db-prof-role {
    font-size: .72rem;
    color: var(--db-text-2);
    margin-top: 1px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.db-prof-mat {
    display: inline-block;
    font-size: .62rem;
    font-weight: 700;
    letter-spacing: .06em;
    text-transform: uppercase;
    color: var(--db-orange);
    background: var(--db-orange-pale);
    border: 1px solid var(--db-orange-border);
    padding: 2px 6px;
    border-radius: 3px;
    margin-top: 4px;
}

.db-prof-rows {}
.db-prof-row {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px 16px;
    border-bottom: 1px solid #f1f5f9;
    transition: background .12s;
}
.db-prof-row:last-child { border-bottom: none; }
.db-prof-row:hover { background: #fafbfc; }
.db-prof-row-ic {
    width: 24px; height: 24px;
    display: flex; align-items: center; justify-content: center;
    color: var(--db-text-3);
    flex-shrink: 0;
}
.db-prof-row-ic svg { width: 13px; height: 13px; }
.db-prof-row-info { flex: 1; min-width: 0; }
.db-prof-row-lbl {
    font-size: .6rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .07em;
    color: var(--db-text-3);
}
.db-prof-row-val {
    font-size: .77rem;
    font-weight: 600;
    color: var(--db-text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-top: 1px;
}

.db-prof-footer { padding: 12px 16px; }
.db-btn-primary {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    width: 100%;
    padding: 9px 16px;
    background: var(--db-blue);
    color: white;
    font-family: inherit;
    font-size: .78rem;
    font-weight: 700;
    border: none;
    border-radius: 7px;
    cursor: pointer;
    text-decoration: none;
    letter-spacing: -.01em;
    transition: background .15s, transform .15s, box-shadow .15s;
}
.db-btn-primary:hover {
    background: #1d4ed8;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(37,99,235,.25);
}
.db-btn-primary svg { width: 14px; height: 14px; }

/* Shortcuts card */
.db-shortcut {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 18px;
    border-bottom: 1px solid #f1f5f9;
    text-decoration: none;
    transition: background .12s;
}
.db-shortcut:last-child { border-bottom: none; }
.db-shortcut:hover { background: #fafbfc; }
.db-shortcut-ic {
    width: 32px; height: 32px;
    border-radius: 7px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.db-shortcut-ic svg { width: 14px; height: 14px; }
.db-shortcut-ic.s-orange { background: var(--db-orange-pale); color: var(--db-orange); }
.db-shortcut-ic.s-blue   { background: var(--db-blue-pale);   color: var(--db-blue);   }
.db-shortcut-ic.s-green  { background: var(--db-green-pale);  color: var(--db-green);  }
.db-shortcut-label {
    flex: 1;
    font-size: .8rem;
    font-weight: 600;
    color: var(--db-text);
}
.db-shortcut-chev { color: var(--db-text-3); transition: transform .15s; }
.db-shortcut:hover .db-shortcut-chev { transform: translateX(3px); color: var(--db-blue); }
.db-shortcut-chev svg { width: 13px; height: 13px; }

/* ── Responsive ───────────────────────────────────────── */
@media (max-width: 1080px) {
    .db-kpi-grid { grid-template-columns: repeat(2, 1fr); }
    .db-content   { grid-template-columns: 1fr; }
    .db-right     { flex-direction: row; gap: 12px; }
    .db-right > * { flex: 1; min-width: 0; }
}
@media (max-width: 740px) {
    .db-hero { flex-direction: column; }
    .db-hero-right { border-left: none; border-top: 1px solid var(--db-border); flex-direction: row; justify-content: space-around; min-width: unset; }
    .db-kpi-grid { grid-template-columns: repeat(2, 1fr); }
    .db-right { flex-direction: column; }
}
@media (max-width: 480px) {
    .db-kpi-grid { grid-template-columns: 1fr; }
    .db-hero-left { padding: 18px 16px; }
    .db-hero-name { font-size: 1.4rem; }
}
</style>
@endsection

@section('content')
@php
    $prenomDisplay = $personnel ? $personnel->prenoms : auth()->user()->name;
    $dayNum   = now()->format('d');
    $dayMonth = now()->translatedFormat('F Y');
    $dayShort = now()->translatedFormat('F');
@endphp

<div class="db-page">

    {{-- ══ HERO ══ --}}
    <div class="db-hero">
        <div class="db-hero-left">

            <div class="db-hero-eyebrow">
                <span class="db-hero-ts">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:11px;height:11px"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <span id="db-live-ts">--:--</span>
                </span>
                <span class="db-hero-status">Espace actif</span>
            </div>

            <div class="db-hero-name">
                <span id="db-greeting-word">Bonjour</span>, <em>{{ $prenomDisplay }}</em>
            </div>

            <div class="db-hero-meta">
                @if($personnel && $personnel->poste)
                <span class="db-hero-meta-item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    {{ $personnel->poste }}
                </span>
                <span class="db-hero-divider"></span>
                @endif
                @if($personnel && $personnel->departement)
                <span class="db-hero-meta-item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                    {{ $personnel->departement->nom }}
                </span>
                <span class="db-hero-divider"></span>
                @endif
                @if($personnel && $personnel->matricule)
                <span class="db-hero-mat"># {{ $personnel->matricule }}</span>
                @endif
            </div>

        </div>

        <div class="db-hero-right">
            <div class="db-date-day-name" id="db-day-name">—</div>
            <div class="db-date-num">{{ $dayNum }}</div>
            <div class="db-date-month">{{ $dayShort }}</div>
            <div class="db-clock-row">
                <span class="db-clock-hhmm" id="db-hhmm">--:--</span>
                <span class="db-clock-ss" id="db-ss">:--</span>
            </div>
            <div class="db-prog-track">
                <div class="db-prog-fill" id="db-prog-fill" style="width:0%"></div>
            </div>
            <div class="db-prog-label" id="db-prog-lbl">Journée en cours</div>
        </div>
    </div>

    {{-- ══ KPI GRID ══ --}}
    <div class="db-kpi-grid">

        <div class="db-kpi">
            <div class="db-kpi-header">
                <div class="db-kpi-icon kpi-orange">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <span class="db-kpi-trend active">Actif</span>
            </div>
            <div class="db-kpi-val">{{ $stats['documents'] }}</div>
            <div class="db-kpi-label">Documents</div>
            <div class="db-kpi-bar bar-orange"></div>
        </div>

        <div class="db-kpi">
            <div class="db-kpi-header">
                <div class="db-kpi-icon kpi-green">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><path d="M9 16l2 2 4-4"/></svg>
                </div>
                <span class="db-kpi-trend ok">Disponible</span>
            </div>
            <div class="db-kpi-val">{{ $stats['conges_restants'] }}</div>
            <div class="db-kpi-label">Jours de congés</div>
            <div class="db-kpi-bar bar-green"></div>
        </div>

        <div class="db-kpi">
            <div class="db-kpi-header">
                <div class="db-kpi-icon kpi-amber">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <span class="db-kpi-trend pending">En attente</span>
            </div>
            <div class="db-kpi-val">{{ $stats['demandes_en_cours'] }}</div>
            <div class="db-kpi-label">Demandes</div>
            <div class="db-kpi-bar bar-amber"></div>
        </div>

        <div class="db-kpi">
            <div class="db-kpi-header">
                <div class="db-kpi-icon kpi-blue">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <span class="db-kpi-trend info">Fidélité</span>
            </div>
            <div class="db-kpi-val">{{ $stats['anciennete'] }}</div>
            <div class="db-kpi-label">Ans d'ancienneté</div>
            <div class="db-kpi-bar bar-blue"></div>
        </div>

    </div>

    {{-- ══ CONTENT GRID ══ --}}
    <div class="db-content">

        {{-- ── Activités récentes ── --}}
        <div class="db-card">
            <div class="db-card-hd">
                <div class="db-card-title">
                    <span class="db-card-title-bar"></span>
                    Activités récentes
                    @if($activities->count() > 0)
                    <span class="db-card-badge">{{ $activities->count() }}</span>
                    @endif
                </div>
                <a href="{{ route('espace-employe.documents') }}" class="db-card-link">
                    Voir tout
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>

            <div class="db-act-list">
                @forelse($activities as $activity)
                <div class="db-act-row">
                    <div class="db-act-icon {{ $activity['icon'] }}">
                        @if($activity['icon'] === 'file')
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        @elseif($activity['icon'] === 'calendar')
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        @endif
                    </div>
                    <div class="db-act-body">
                        <div class="db-act-title">{{ $activity['title'] }}</div>
                        <div class="db-act-sub">
                            {{ $activity['date']->diffForHumans() }}
                            @if($activity['date']->isToday())
                                <span class="db-badge-new">Nouveau</span>
                            @endif
                        </div>
                    </div>
                    <div class="db-act-date">{{ $activity['date']->format('d/m/Y') }}</div>
                </div>
                @empty
                <div class="db-empty">
                    <div class="db-empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    </div>
                    <div class="db-empty-txt">Aucune activité récente</div>
                </div>
                @endforelse
            </div>
        </div>

        {{-- ── Colonne droite ── --}}
        <div class="db-right">

            {{-- Profil --}}
            <div class="db-card">
                <div class="db-prof-top">
                    <div class="db-prof-avatar-wrap">
                        <img src="{{ $personnel && $personnel->photo ? asset('storage/' . $personnel->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($personnel ? $personnel->nom . '+' . $personnel->prenoms : auth()->user()->name) . '&size=200&background=f97316&color=fff&bold=true' }}"
                             alt="Photo"
                             class="db-prof-avatar"
                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&size=200&background=f97316&color=fff&bold=true'">
                        <span class="db-prof-online"></span>
                    </div>
                    <div class="db-prof-id">
                        <div class="db-prof-name">{{ $personnel ? $personnel->nom_complet : auth()->user()->name }}</div>
                        <div class="db-prof-role">{{ $personnel ? $personnel->poste : 'Employé' }}</div>
                        @if($personnel && $personnel->matricule)
                        <span class="db-prof-mat">{{ $personnel->matricule }}</span>
                        @endif
                    </div>
                </div>

                <div class="db-prof-rows">
                    @if($personnel)
                    <div class="db-prof-row">
                        <div class="db-prof-row-ic">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        </div>
                        <div class="db-prof-row-info">
                            <div class="db-prof-row-lbl">Département</div>
                            <div class="db-prof-row-val">{{ $personnel->departement->nom ?? 'Non assigné' }}</div>
                        </div>
                    </div>
                    <div class="db-prof-row">
                        <div class="db-prof-row-ic">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                        </div>
                        <div class="db-prof-row-info">
                            <div class="db-prof-row-lbl">Service</div>
                            <div class="db-prof-row-val">{{ $personnel->service->nom ?? 'Non assigné' }}</div>
                        </div>
                    </div>
                    <div class="db-prof-row">
                        <div class="db-prof-row-ic">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                        <div class="db-prof-row-info">
                            <div class="db-prof-row-lbl">Embauche</div>
                            <div class="db-prof-row-val">{{ $personnel->date_embauche ? $personnel->date_embauche->format('d/m/Y') : 'N/A' }}</div>
                        </div>
                    </div>
                    @endif
                    <div class="db-prof-row">
                        <div class="db-prof-row-ic">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </div>
                        <div class="db-prof-row-info">
                            <div class="db-prof-row-lbl">Email</div>
                            <div class="db-prof-row-val">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                </div>

                <div class="db-prof-footer">
                    <a href="{{ route('espace-employe.profil') }}" class="db-btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Mon profil
                    </a>
                </div>
            </div>

            {{-- Raccourcis --}}
            <div class="db-card">
                <div class="db-card-hd">
                    <div class="db-card-title">
                        <span class="db-card-title-bar"></span>
                        Raccourcis
                    </div>
                </div>

                <a href="{{ route('espace-employe.conges') }}" class="db-shortcut">
                    <div class="db-shortcut-ic s-orange">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><path d="M9 16h6"/></svg>
                    </div>
                    <span class="db-shortcut-label">Mes Congés</span>
                    <span class="db-shortcut-chev"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg></span>
                </a>
                <a href="{{ route('espace-employe.bulletins') }}" class="db-shortcut">
                    <div class="db-shortcut-ic s-blue">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    </div>
                    <span class="db-shortcut-label">Mes Bulletins</span>
                    <span class="db-shortcut-chev"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg></span>
                </a>
                <a href="{{ route('espace-employe.documents') }}" class="db-shortcut">
                    <div class="db-shortcut-ic s-green">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                    </div>
                    <span class="db-shortcut-label">Mes Documents</span>
                    <span class="db-shortcut-chev"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg></span>
                </a>
                <a href="{{ route('espace-employe.attestations') }}" class="db-shortcut">
                    <div class="db-shortcut-ic s-orange">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><path d="M9 15l2 2 4-4"/></svg>
                    </div>
                    <span class="db-shortcut-label">Attestations</span>
                    <span class="db-shortcut-chev"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg></span>
                </a>
                <a href="{{ route('espace-employe.demandes') }}" class="db-shortcut">
                    <div class="db-shortcut-ic s-blue">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </div>
                    <span class="db-shortcut-label">Mes Demandes</span>
                    <span class="db-shortcut-chev"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg></span>
                </a>
            </div>

        </div>{{-- /.db-right --}}

    </div>{{-- /.db-content --}}

</div>{{-- /.db-page --}}
@endsection

@section('scripts')
<script>
(function () {
    var DAYS = ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
    function p(n) { return String(n).padStart(2,'0'); }

    // Greeting
    (function() {
        var h = new Date().getHours();
        var w = h < 12 ? 'Bonjour' : h < 18 ? 'Bon après-midi' : 'Bonsoir';
        var el = document.getElementById('db-greeting-word');
        if (el) el.textContent = w;
    })();

    // Day name
    var dnEl = document.getElementById('db-day-name');
    if (dnEl) dnEl.textContent = DAYS[new Date().getDay()];

    // Clock + progress
    function tick() {
        var now = new Date();
        var h = p(now.getHours()), m = p(now.getMinutes()), s = p(now.getSeconds());

        var tsEl = document.getElementById('db-live-ts');
        if (tsEl) tsEl.textContent = h + ':' + m;

        var hhEl = document.getElementById('db-hhmm');
        if (hhEl) hhEl.textContent = h + ':' + m;

        var ssEl = document.getElementById('db-ss');
        if (ssEl) ssEl.textContent = ':' + s;

        // Day progress 6h–23h
        var total = now.getHours() * 60 + now.getMinutes();
        var START = 360, END = 1380;
        var pct = Math.min(100, Math.max(0, ((total - START) / (END - START)) * 100));
        var fill = document.getElementById('db-prog-fill');
        if (fill) fill.style.width = pct.toFixed(1) + '%';

        var lbl = document.getElementById('db-prog-lbl');
        if (lbl) {
            var rem = END - total;
            lbl.textContent = rem > 60
                ? Math.floor(rem/60) + 'h ' + (rem % 60) + 'min restantes'
                : rem > 0 ? rem + ' min restantes'
                : 'Bonne soirée !';
        }
    }
    tick();
    setInterval(tick, 1000);
})();
</script>
@endsection
