@extends('layouts.espace-employe')

@section('title', 'Mon Espace')
@section('page-title', 'Tableau de bord')
@section('breadcrumb')
    <span>Accueil</span>
@endsection

@section('styles')
<style>
/* ============================================================
   DASHBOARD — Espace Employé · Clarity Pro
   Orange · Bleu · Gris — Épuré, Dense, Élégant
   ============================================================ */

@keyframes db-fade-up {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes db-scale-in {
    from { opacity: 0; transform: scale(.97); }
    to   { opacity: 1; transform: scale(1); }
}
@keyframes db-dot-pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: .55; transform: scale(.85); }
}
@keyframes db-tick {
    0%, 100% { opacity: 1; }
    50%       { opacity: .35; }
}

.db-anim { animation: db-fade-up .4s ease both; }

/* ── Layout ───────────────────────────────────────────── */
.db-page {
    display: flex;
    flex-direction: column;
    gap: 18px;
    max-width: 1100px;
}

/* ── Hero ─────────────────────────────────────────────── */
.db-hero {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    overflow: hidden;
    position: relative;
    display: flex;
    align-items: stretch;
    justify-content: space-between;
    min-height: 148px;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.db-hero::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--o-500) 0%, #fb923c 60%, var(--o-500) 100%);
    background-size: 200% 100%;
    animation: db-stripe-slide 4s linear infinite;
}
@keyframes db-stripe-slide {
    0%   { background-position: 0% 0%; }
    100% { background-position: 200% 0%; }
}

.db-hero-left {
    padding: 28px 32px 26px;
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.db-greeting-label {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: .68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .12em;
    color: var(--o-500);
    margin-bottom: 8px;
}
.db-greeting-dot {
    width: 6px; height: 6px;
    background: var(--o-500);
    border-radius: 50%;
    animation: db-dot-pulse 2s ease-in-out infinite;
}

.db-greeting-name {
    font-size: 2rem;
    font-weight: 800;
    color: var(--text);
    letter-spacing: -.03em;
    line-height: 1.1;
    margin-bottom: 10px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.db-hero-tags {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}
.db-hero-tag {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: .72rem;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
    border: 1px solid var(--border);
    color: var(--text-2);
    background: var(--bg);
}
.db-hero-tag svg { width: 11px; height: 11px; flex-shrink: 0; }
.db-hero-tag.orange { border-color: var(--o-100); color: var(--o-600); background: var(--o-50); }
.dark .db-hero-tag.orange { background: rgba(249,115,22,.08); border-color: rgba(249,115,22,.2); }

/* Clock widget */
.db-clock-wrap {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    padding: 24px 32px;
    border-left: 1px solid var(--border);
    background: var(--bg);
    min-width: 196px;
    text-align: center;
    flex-direction: column;
    justify-content: center;
    gap: 6px;
    position: relative;
}

.db-clock-day-num {
    font-size: 3.75rem;
    font-weight: 800;
    color: var(--text);
    letter-spacing: -.06em;
    line-height: 1;
}
.db-clock-day-name {
    font-size: .625rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .14em;
    color: var(--text-2);
    margin-top: 2px;
}
.db-clock-sep {
    width: 24px; height: 1px;
    background: var(--border);
    border-radius: 1px;
    align-self: center;
}
.db-clock-time {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text);
    letter-spacing: .04em;
    font-variant-numeric: tabular-nums;
}
.db-clock-secs {
    font-size: .75rem;
    font-weight: 500;
    color: var(--text-2);
    animation: db-tick 1s ease-in-out infinite;
}
.db-clock-month {
    font-size: .7rem;
    font-weight: 600;
    color: var(--o-500);
    text-transform: uppercase;
    letter-spacing: .1em;
}

/* Day progress */
.db-day-progress {
    width: 100%;
    margin-top: 4px;
}
.db-day-progress-bar {
    height: 2px;
    background: var(--border);
    border-radius: 2px;
    overflow: hidden;
    margin-bottom: 3px;
}
.db-day-progress-fill {
    height: 100%;
    background: var(--o-500);
    border-radius: 2px;
    transition: width 1s linear;
}
.db-day-progress-label {
    font-size: .6rem;
    color: var(--text-2);
    text-transform: uppercase;
    letter-spacing: .08em;
    font-weight: 500;
}

/* ── Stats grid ───────────────────────────────────────── */
.db-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
}

.db-stat {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 18px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    position: relative;
    overflow: hidden;
    transition: transform .2s ease, box-shadow .2s ease;
    border-left-width: 3px;
    box-shadow: 0 1px 2px rgba(0,0,0,.04);
}
.db-stat:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,.08);
}
.db-stat.s-orange { border-left-color: var(--o-500); }
.db-stat.s-green  { border-left-color: #16a34a; }
.db-stat.s-yellow { border-left-color: #d97706; }
.db-stat.s-blue   { border-left-color: var(--b-600); }

.db-stat-icon {
    width: 44px; height: 44px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.db-stat-icon svg { width: 20px; height: 20px; }
.db-stat.s-orange .db-stat-icon { background: var(--o-50); color: var(--o-500); }
.db-stat.s-green  .db-stat-icon { background: #dcfce7; color: #16a34a; }
.db-stat.s-yellow .db-stat-icon { background: #fef3c7; color: #d97706; }
.db-stat.s-blue   .db-stat-icon { background: var(--b-50); color: var(--b-600); }
.dark .db-stat.s-orange .db-stat-icon { background: rgba(249,115,22,.1); }
.dark .db-stat.s-green  .db-stat-icon { background: rgba(22,163,74,.1); }
.dark .db-stat.s-yellow .db-stat-icon { background: rgba(217,119,6,.1); }
.dark .db-stat.s-blue   .db-stat-icon { background: rgba(37,99,235,.1); }

.db-stat-body { flex: 1; min-width: 0; }
.db-stat-val {
    font-size: 1.875rem;
    font-weight: 800;
    color: var(--text);
    letter-spacing: -.04em;
    line-height: 1;
    margin-bottom: 3px;
}
.db-stat-label {
    font-size: .75rem;
    font-weight: 500;
    color: var(--text-2);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.db-stat-badge {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    font-size: .65rem;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 10px;
    margin-top: 5px;
    text-transform: uppercase;
    letter-spacing: .04em;
}
.db-stat-badge svg { width: 9px; height: 9px; }
.s-orange .db-stat-badge { background: var(--o-50); color: var(--o-600); border: 1px solid var(--o-100); }
.s-green  .db-stat-badge { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
.s-yellow .db-stat-badge { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
.s-blue   .db-stat-badge { background: var(--b-50); color: var(--b-600); border: 1px solid var(--b-100); }
.dark .s-orange .db-stat-badge { background: rgba(249,115,22,.1); border-color: rgba(249,115,22,.2); }
.dark .s-green  .db-stat-badge { background: rgba(22,163,74,.1); border-color: rgba(22,163,74,.2); color: #4ade80; }
.dark .s-yellow .db-stat-badge { background: rgba(217,119,6,.1); border-color: rgba(217,119,6,.2); color: #fbbf24; }
.dark .s-blue   .db-stat-badge { background: rgba(37,99,235,.1); border-color: rgba(37,99,235,.2); color: #60a5fa; }

/* ── Quick actions ────────────────────────────────────── */
.db-actions-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 18px 20px;
    box-shadow: 0 1px 2px rgba(0,0,0,.04);
}
.db-actions-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 14px;
}
.db-section-title {
    font-size: .8rem;
    font-weight: 700;
    color: var(--text);
    text-transform: uppercase;
    letter-spacing: .09em;
    display: flex;
    align-items: center;
    gap: 7px;
}
.db-section-title::before {
    content: '';
    display: block;
    width: 3px; height: 14px;
    background: var(--o-500);
    border-radius: 2px;
}

.db-actions-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
}

.db-action {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    border: 1px solid var(--border);
    border-radius: 9px;
    text-decoration: none;
    background: var(--bg);
    transition: all .18s ease;
    position: relative;
    overflow: hidden;
    group: true;
}
.db-action:hover {
    border-color: transparent;
    transform: translateY(-1px);
    box-shadow: 0 4px 16px rgba(0,0,0,.09);
}
.db-action.a-orange:hover { background: var(--o-50); border-color: var(--o-100); }
.db-action.a-blue:hover   { background: var(--b-50); border-color: var(--b-100); }
.db-action.a-green:hover  { background: #f0fdf4; border-color: #bbf7d0; }
.db-action.a-violet:hover { background: #faf5ff; border-color: #e9d5ff; }
.dark .db-action.a-orange:hover { background: rgba(249,115,22,.08); border-color: rgba(249,115,22,.2); }
.dark .db-action.a-blue:hover   { background: rgba(37,99,235,.08); border-color: rgba(37,99,235,.2); }
.dark .db-action.a-green:hover  { background: rgba(22,163,74,.08); border-color: rgba(22,163,74,.2); }
.dark .db-action.a-violet:hover { background: rgba(139,92,246,.08); border-color: rgba(139,92,246,.2); }

.db-action-icon {
    width: 38px; height: 38px;
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    transition: transform .18s ease;
}
.db-action:hover .db-action-icon { transform: scale(1.08); }
.db-action-icon svg { width: 18px; height: 18px; }
.a-orange .db-action-icon { background: var(--o-100); color: var(--o-600); }
.a-blue   .db-action-icon { background: var(--b-100); color: var(--b-600); }
.a-green  .db-action-icon { background: #dcfce7; color: #16a34a; }
.a-violet .db-action-icon { background: #ede9fe; color: #7c3aed; }
.dark .a-orange .db-action-icon { background: rgba(249,115,22,.15); }
.dark .a-blue   .db-action-icon { background: rgba(37,99,235,.15); }
.dark .a-green  .db-action-icon { background: rgba(22,163,74,.15); }
.dark .a-violet .db-action-icon { background: rgba(139,92,246,.15); }

.db-action-text { flex: 1; min-width: 0; }
.db-action-label {
    font-size: .82rem;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 1px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.db-action-desc {
    font-size: .7rem;
    color: var(--text-2);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.db-action-arrow {
    flex-shrink: 0;
    color: var(--text-2);
    opacity: .4;
    transition: all .18s ease;
}
.db-action:hover .db-action-arrow {
    opacity: 1;
    transform: translateX(3px);
}
.db-action-arrow svg { width: 14px; height: 14px; }

/* ── Bottom grid ──────────────────────────────────────── */
.db-bottom {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 12px;
    align-items: start;
}

/* ── Activity feed ────────────────────────────────────── */
.db-feed {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 1px 2px rgba(0,0,0,.04);
}
.db-feed-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid var(--border);
}
.db-feed-link {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: .75rem;
    font-weight: 600;
    color: var(--b-600);
    text-decoration: none;
    padding: 4px 10px;
    border-radius: 6px;
    transition: background .15s;
}
.db-feed-link:hover { background: var(--b-50); }
.db-feed-link svg { width: 12px; height: 12px; transition: transform .15s; }
.db-feed-link:hover svg { transform: translateX(2px); }

.db-feed-list { padding: 6px 0; }

.db-feed-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 20px;
    transition: background .15s;
    border-bottom: 1px solid var(--border);
}
.db-feed-item:last-child { border-bottom: none; }
.db-feed-item:hover { background: var(--bg); }

.db-feed-icon {
    width: 34px; height: 34px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.db-feed-icon svg { width: 15px; height: 15px; }
.db-feed-icon.file     { background: var(--o-50); color: var(--o-500); }
.db-feed-icon.calendar { background: var(--b-50); color: var(--b-600); }
.db-feed-icon.user     { background: #f3f4f6; color: #6b7280; }
.dark .db-feed-icon.file     { background: rgba(249,115,22,.1); }
.dark .db-feed-icon.calendar { background: rgba(37,99,235,.1); }
.dark .db-feed-icon.user     { background: rgba(255,255,255,.06); color: #9ca3af; }

.db-feed-body { flex: 1; min-width: 0; }
.db-feed-title {
    font-size: .82rem;
    font-weight: 600;
    color: var(--text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: 2px;
}
.db-feed-meta {
    display: flex;
    align-items: center;
    gap: 7px;
}
.db-feed-date {
    font-size: .72rem;
    color: var(--text-2);
}
.db-feed-badge-new {
    display: inline-flex;
    align-items: center;
    font-size: .6rem;
    font-weight: 700;
    letter-spacing: .04em;
    text-transform: uppercase;
    padding: 1px 6px;
    border-radius: 8px;
    background: var(--o-50);
    color: var(--o-600);
    border: 1px solid var(--o-100);
}
.dark .db-feed-badge-new { background: rgba(249,115,22,.1); border-color: rgba(249,115,22,.2); }

.db-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    gap: 10px;
}
.db-empty-icon {
    width: 52px; height: 52px;
    background: var(--bg);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    border: 1px solid var(--border);
}
.db-empty-icon svg { width: 24px; height: 24px; color: var(--text-2); opacity: .5; }
.db-empty-text {
    font-size: .82rem;
    font-weight: 500;
    color: var(--text-2);
}

/* ── Profile card ─────────────────────────────────────── */
.db-profile {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 1px 2px rgba(0,0,0,.04);
}
.db-profile-head {
    background: var(--bg);
    border-bottom: 1px solid var(--border);
    padding: 22px 20px 18px;
    text-align: center;
    position: relative;
}
.db-profile-head::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: var(--o-500);
}

.db-avatar-ring {
    display: inline-block;
    position: relative;
    margin-bottom: 10px;
}
.db-avatar-ring::before {
    content: '';
    position: absolute;
    inset: -3px;
    border-radius: 50%;
    background: conic-gradient(var(--o-500) 0%, #fb923c 50%, var(--o-500) 100%);
    animation: db-ring-spin 8s linear infinite;
    opacity: .7;
}
@keyframes db-ring-spin { to { transform: rotate(360deg); } }
.db-avatar-ring::after {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 50%;
    background: var(--bg);
}
.db-avatar {
    width: 72px; height: 72px;
    border-radius: 50%;
    object-fit: cover;
    display: block;
    position: relative;
    z-index: 1;
    border: 2px solid var(--surface);
}
.db-status-dot {
    position: absolute;
    bottom: 3px; right: 3px;
    width: 11px; height: 11px;
    background: #16a34a;
    border: 2px solid var(--bg);
    border-radius: 50%;
    z-index: 2;
}

.db-profile-name {
    font-size: .95rem;
    font-weight: 800;
    color: var(--text);
    letter-spacing: -.02em;
    margin-bottom: 2px;
}
.db-profile-role {
    font-size: .75rem;
    color: var(--text-2);
    margin-bottom: 8px;
}
.db-profile-matricule {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: .65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    padding: 3px 9px;
    border-radius: 10px;
    background: var(--o-500);
    color: white;
}
.db-profile-matricule svg { width: 9px; height: 9px; }

.db-profile-info { padding: 6px 0; }
.db-profile-row {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px 16px;
    border-bottom: 1px solid var(--border);
    transition: background .15s;
}
.db-profile-row:last-child { border-bottom: none; }
.db-profile-row:hover { background: var(--bg); }

.db-profile-row-icon {
    width: 28px; height: 28px;
    border-radius: 7px;
    background: var(--bg);
    border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    color: var(--text-2);
    transition: all .15s;
}
.db-profile-row:hover .db-profile-row-icon {
    background: var(--o-50);
    border-color: var(--o-100);
    color: var(--o-500);
}
.db-profile-row-icon svg { width: 13px; height: 13px; }

.db-profile-row-body { flex: 1; min-width: 0; }
.db-profile-row-label {
    font-size: .6rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .07em;
    color: var(--text-2);
}
.db-profile-row-val {
    font-size: .78rem;
    font-weight: 600;
    color: var(--text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-top: 1px;
}

.db-profile-footer { padding: 12px 16px; }
.db-profile-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    width: 100%;
    padding: 9px;
    background: var(--b-600);
    color: white;
    border: none;
    border-radius: 8px;
    font-family: inherit;
    font-size: .8rem;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    transition: background .15s, transform .15s, box-shadow .15s;
    letter-spacing: -.01em;
}
.db-profile-btn:hover {
    background: #1d4ed8;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(37,99,235,.3);
}
.db-profile-btn svg { width: 14px; height: 14px; }

/* ── Responsive ───────────────────────────────────────── */
@media (max-width: 1100px) {
    .db-hero { flex-direction: column; min-height: auto; }
    .db-clock-wrap { border-left: none; border-top: 1px solid var(--border); flex-direction: row; justify-content: space-around; padding: 16px 24px; }
    .db-clock-sep { width: 1px; height: 40px; }
    .db-stats { grid-template-columns: repeat(2, 1fr); }
    .db-actions-grid { grid-template-columns: repeat(2, 1fr); }
    .db-bottom { grid-template-columns: 1fr; }
}
@media (max-width: 640px) {
    .db-hero-left { padding: 20px; }
    .db-greeting-name { font-size: 1.6rem; }
    .db-stats { grid-template-columns: 1fr; }
    .db-actions-grid { grid-template-columns: 1fr; }
}

/* ── Dark mode ────────────────────────────────────────── */
.dark .db-stat       { background: var(--surface); border-color: var(--border); }
.dark .db-actions-card { background: var(--surface); border-color: var(--border); }
.dark .db-hero        { background: var(--surface); border-color: var(--border); }
.dark .db-clock-wrap  { background: rgba(255,255,255,.03); border-color: var(--border); }
.dark .db-feed        { background: var(--surface); border-color: var(--border); }
.dark .db-profile     { background: var(--surface); border-color: var(--border); }
.dark .db-profile-head { background: rgba(255,255,255,.03); border-bottom-color: var(--border); }
.dark .db-action      { background: rgba(255,255,255,.03); border-color: var(--border); }
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
    <div class="db-hero db-anim" style="animation-delay:.02s">
        <div class="db-hero-left">
            <div class="db-greeting-label">
                <span class="db-greeting-dot"></span>
                <span id="db-greeting-word">Bonjour</span>
            </div>
            <div class="db-greeting-name" id="db-greeting-name">{{ $prenomDisplay }}</div>
            <div class="db-hero-tags">
                <span class="db-hero-tag orange">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                    Espace actif
                </span>
                @if($personnel && $personnel->poste)
                <span class="db-hero-tag">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    {{ $personnel->poste }}
                </span>
                @endif
                <span class="db-hero-tag">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    {{ $dayMonth }}
                </span>
            </div>
        </div>

        <div class="db-clock-wrap">
            <div style="text-align:center">
                <div class="db-clock-day-num">{{ $dayNum }}</div>
                <div class="db-clock-month">{{ $dayShort }}</div>
            </div>
            <div class="db-clock-sep"></div>
            <div style="text-align:center">
                <div class="db-clock-time" id="db-time">--:--<span class="db-clock-secs" id="db-secs">:--</span></div>
                <div class="db-clock-day-name" id="db-dayname">—</div>
                <div class="db-day-progress" style="margin-top:8px">
                    <div class="db-day-progress-bar">
                        <div class="db-day-progress-fill" id="db-prog" style="width:0%"></div>
                    </div>
                    <div class="db-day-progress-label" id="db-prog-lbl">Journée en cours</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══ STATS ══ --}}
    <div class="db-stats">
        <div class="db-stat s-orange db-anim" style="animation-delay:.07s">
            <div class="db-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            </div>
            <div class="db-stat-body">
                <div class="db-stat-val">{{ $stats['documents'] }}</div>
                <div class="db-stat-label">Documents disponibles</div>
                <div class="db-stat-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="4"/></svg>
                    Dossier actif
                </div>
            </div>
        </div>

        <div class="db-stat s-green db-anim" style="animation-delay:.12s">
            <div class="db-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><path d="M9 16l2 2 4-4"/></svg>
            </div>
            <div class="db-stat-body">
                <div class="db-stat-val">{{ $stats['conges_restants'] }}</div>
                <div class="db-stat-label">Jours de cong&eacute;s restants</div>
                <div class="db-stat-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    Disponibles
                </div>
            </div>
        </div>

        <div class="db-stat s-yellow db-anim" style="animation-delay:.17s">
            <div class="db-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div class="db-stat-body">
                <div class="db-stat-val">{{ $stats['demandes_en_cours'] }}</div>
                <div class="db-stat-label">Demandes en cours</div>
                <div class="db-stat-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    En attente
                </div>
            </div>
        </div>

        <div class="db-stat s-blue db-anim" style="animation-delay:.22s">
            <div class="db-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>
            </div>
            <div class="db-stat-body">
                <div class="db-stat-val">{{ $stats['anciennete'] }}</div>
                <div class="db-stat-label">Ann&eacute;es d'anciennet&eacute;</div>
                <div class="db-stat-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    Fid&eacute;lit&eacute;
                </div>
            </div>
        </div>
    </div>

    {{-- ══ QUICK ACTIONS ══ --}}
    <div class="db-actions-card db-anim" style="animation-delay:.27s">
        <div class="db-actions-header">
            <div class="db-section-title">Actions rapides</div>
        </div>
        <div class="db-actions-grid">
            <a href="{{ route('espace-employe.conges') }}" class="db-action a-orange">
                <div class="db-action-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><path d="M9 16h6"/></svg>
                </div>
                <div class="db-action-text">
                    <div class="db-action-label">Demander un cong&eacute;</div>
                    <div class="db-action-desc">Poser une demande</div>
                </div>
                <div class="db-action-arrow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg></div>
            </a>
            <a href="{{ route('espace-employe.bulletins') }}" class="db-action a-blue">
                <div class="db-action-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                </div>
                <div class="db-action-text">
                    <div class="db-action-label">Bulletins de paie</div>
                    <div class="db-action-desc">Consulter mes fiches</div>
                </div>
                <div class="db-action-arrow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg></div>
            </a>
            <a href="{{ route('espace-employe.attestations') }}" class="db-action a-green">
                <div class="db-action-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><path d="M9 15l2 2 4-4"/></svg>
                </div>
                <div class="db-action-text">
                    <div class="db-action-label">Attestations</div>
                    <div class="db-action-desc">Travail, salaire&hellip;</div>
                </div>
                <div class="db-action-arrow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg></div>
            </a>
            <a href="{{ route('espace-employe.documents') }}" class="db-action a-violet">
                <div class="db-action-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                </div>
                <div class="db-action-text">
                    <div class="db-action-label">Mes documents</div>
                    <div class="db-action-desc">Dossier personnel</div>
                </div>
                <div class="db-action-arrow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg></div>
            </a>
        </div>
    </div>

    {{-- ══ BOTTOM GRID ══ --}}
    <div class="db-bottom">

        {{-- Activity feed --}}
        <div class="db-feed db-anim" style="animation-delay:.32s">
            <div class="db-feed-header">
                <div class="db-section-title">Activit&eacute;s r&eacute;centes</div>
                <a href="{{ route('espace-employe.documents') }}" class="db-feed-link">
                    Voir tout
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>
            <div class="db-feed-list">
                @forelse($activities as $activity)
                <div class="db-feed-item">
                    <div class="db-feed-icon {{ $activity['icon'] }}">
                        @if($activity['icon'] === 'file')
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        @elseif($activity['icon'] === 'calendar')
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        @endif
                    </div>
                    <div class="db-feed-body">
                        <div class="db-feed-title">{{ $activity['title'] }}</div>
                        <div class="db-feed-meta">
                            <span class="db-feed-date">{{ $activity['date']->diffForHumans() }}</span>
                            @if($activity['date']->isToday())
                                <span class="db-feed-badge-new">Nouveau</span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="db-empty">
                    <div class="db-empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    </div>
                    <div class="db-empty-text">Aucune activit&eacute; r&eacute;cente</div>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Profile card --}}
        <div class="db-profile db-anim" style="animation-delay:.37s">
            <div class="db-profile-head">
                <div class="db-avatar-ring">
                    <img src="{{ $personnel && $personnel->photo ? asset('storage/' . $personnel->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($personnel ? $personnel->nom . ' ' . $personnel->prenoms : auth()->user()->name) . '&size=200&background=f97316&color=ffffff&bold=true' }}"
                         alt="Photo"
                         class="db-avatar"
                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&size=200&background=f97316&color=ffffff&bold=true'">
                    <span class="db-status-dot"></span>
                </div>
                <div class="db-profile-name">{{ $personnel ? $personnel->nom_complet : auth()->user()->name }}</div>
                <div class="db-profile-role">{{ $personnel ? $personnel->poste : 'Employ&eacute;' }}</div>
                @if($personnel && $personnel->matricule)
                <span class="db-profile-matricule">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/></svg>
                    {{ $personnel->matricule }}
                </span>
                @endif
            </div>

            <div class="db-profile-info">
                @if($personnel)
                <div class="db-profile-row">
                    <div class="db-profile-row-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    </div>
                    <div class="db-profile-row-body">
                        <div class="db-profile-row-label">D&eacute;partement</div>
                        <div class="db-profile-row-val">{{ $personnel->departement->nom ?? 'Non assign&eacute;' }}</div>
                    </div>
                </div>
                <div class="db-profile-row">
                    <div class="db-profile-row-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    </div>
                    <div class="db-profile-row-body">
                        <div class="db-profile-row-label">Service</div>
                        <div class="db-profile-row-val">{{ $personnel->service->nom ?? 'Non assign&eacute;' }}</div>
                    </div>
                </div>
                <div class="db-profile-row">
                    <div class="db-profile-row-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <div class="db-profile-row-body">
                        <div class="db-profile-row-label">Embauche</div>
                        <div class="db-profile-row-val">{{ $personnel->date_embauche ? $personnel->date_embauche->format('d/m/Y') : 'Non renseign&eacute;e' }}</div>
                    </div>
                </div>
                @endif
                <div class="db-profile-row">
                    <div class="db-profile-row-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </div>
                    <div class="db-profile-row-body">
                        <div class="db-profile-row-label">Email</div>
                        <div class="db-profile-row-val">{{ auth()->user()->email }}</div>
                    </div>
                </div>
            </div>

            <div class="db-profile-footer">
                <a href="{{ route('espace-employe.profil') }}" class="db-profile-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Voir mon profil complet
                </a>
            </div>
        </div>

    </div>{{-- /.db-bottom --}}

</div>{{-- /.db-page --}}
@endsection

@section('scripts')
<script>
(function() {
    const DAYS_FR = ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];

    function pad(n) { return String(n).padStart(2,'0'); }

    // Greeting dynamic
    (function setGreeting() {
        const h = new Date().getHours();
        const word = h < 12 ? 'Bonjour' : h < 18 ? 'Bon après-midi' : 'Bonsoir';
        const el = document.getElementById('db-greeting-word');
        if (el) el.textContent = word;
    })();

    // Day name
    const dayEl = document.getElementById('db-dayname');
    if (dayEl) dayEl.textContent = DAYS_FR[new Date().getDay()];

    // Live clock
    function tick() {
        const now = new Date();
        const h = pad(now.getHours()), m = pad(now.getMinutes()), s = pad(now.getSeconds());
        const timeEl = document.getElementById('db-time');
        const secsEl = document.getElementById('db-secs');
        if (timeEl) timeEl.childNodes[0].textContent = h + ':' + m;
        if (secsEl) secsEl.textContent = ':' + s;

        // Day progress (6h–23h)
        const totalMin = now.getHours() * 60 + now.getMinutes();
        const START = 6 * 60, END = 23 * 60;
        const pct = Math.min(100, Math.max(0, ((totalMin - START) / (END - START)) * 100));
        const prog = document.getElementById('db-prog');
        if (prog) prog.style.width = pct.toFixed(1) + '%';

        const lbl = document.getElementById('db-prog-lbl');
        if (lbl) {
            const rem = END - totalMin;
            if (rem > 60)      lbl.textContent = Math.floor(rem/60) + 'h ' + (rem%60) + 'min restantes';
            else if (rem > 0)  lbl.textContent = rem + ' min restantes';
            else               lbl.textContent = 'Bonne soirée !';
        }
    }
    tick();
    setInterval(tick, 1000);
})();
</script>
@endsection
