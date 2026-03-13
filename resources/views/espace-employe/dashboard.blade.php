@extends('layouts.espace-employe')

@section('title', 'Mon Espace')
@section('page-title', 'Tableau de bord')
@section('breadcrumb')
    <span>Accueil</span>
@endsection

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=Instrument+Sans:ital,wght@0,400;0,500;0,600;1,400&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
/* ═══════════════════════════════════════════════════════════════════
   CARBON EMBER  ·  Espace Employé Dashboard
   Syne  ×  Instrument Sans  ×  JetBrains Mono
   ═══════════════════════════════════════════════════════════════════ */

:root {
    --void:      #07070b;
    --ink:       #0c0c11;
    --card:      #111116;
    --card-hi:   #16161d;
    --rim:       rgba(255,255,255,.055);
    --rim-hi:    rgba(255,255,255,.10);
    --ember:     #ff6930;
    --ember-a:   rgba(255,105,48,.11);
    --amber:     #f59e0b;
    --jade:      #10d98a;
    --sky:       #38bdf8;
    --rose:      #f43f5e;
    --t1:        #f0f0f5;
    --t2:        #87879a;
    --t3:        #3f3f52;
    --fd: 'Syne', sans-serif;
    --fb: 'Instrument Sans', sans-serif;
    --fm: 'JetBrains Mono', monospace;
}

/* ── Reset & base ──────────────────────────────────────────────── */
.dash, .dash * { box-sizing: border-box; }

.dash {
    font-family: var(--fb);
    background: var(--void);
    color: var(--t1);
    min-height: calc(100vh - 90px);
    padding: 20px;
    margin: -8px;
    border-radius: 12px;
}

/* ── Hero ──────────────────────────────────────────────────────── */
.dash-hero {
    position: relative;
    background: var(--card);
    border: 1px solid var(--rim);
    border-radius: 16px;
    padding: 28px 32px;
    margin-bottom: 12px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    animation: ce-rise .5s ease both;
}

/* Animated ember glow behind */
.dash-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 55% 90% at 0% 60%, rgba(255,105,48,.09) 0%, transparent 65%),
        radial-gradient(ellipse 25% 50% at 12% 15%, rgba(245,158,11,.06) 0%, transparent 55%);
    animation: ember-drift 9s ease-in-out infinite alternate;
    pointer-events: none;
}

@keyframes ember-drift {
    from { opacity: .6; transform: scale(1); }
    to   { opacity: 1;  transform: scale(1.05); }
}

/* Subtle bottom accent line */
.dash-hero::after {
    content: '';
    position: absolute;
    bottom: 0; left: 32px; right: 32px;
    height: 1px;
    background: linear-gradient(90deg, rgba(255,105,48,.45), transparent);
}

.hero-left { position: relative; z-index: 1; }

.hero-eyebrow {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 10px;
}

.hero-pulse {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: var(--jade);
    box-shadow: 0 0 0 0 rgba(16,217,138,.4);
    animation: pulse-ring 2.5s ease-out infinite;
}

@keyframes pulse-ring {
    0%   { box-shadow: 0 0 0 0 rgba(16,217,138,.45); }
    70%  { box-shadow: 0 0 0 8px rgba(16,217,138,.0); }
    100% { box-shadow: 0 0 0 0 rgba(16,217,138,.0); }
}

.hero-eyebrow-lbl {
    font-size: .67rem;
    font-weight: 600;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: var(--t3);
}

.hero-name {
    font-family: var(--fd);
    font-size: 2.1rem;
    font-weight: 800;
    letter-spacing: -.05em;
    color: var(--t1);
    line-height: 1;
    margin-bottom: 14px;
}

.hero-chips {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
}

.chip {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: .71rem;
    font-weight: 600;
    color: var(--t2);
    background: rgba(255,255,255,.04);
    border: 1px solid var(--rim);
    padding: 4px 10px;
    border-radius: 100px;
    letter-spacing: .01em;
    white-space: nowrap;
}

.chip svg { flex-shrink: 0; opacity: .6; }

.chip-ember {
    color: #fb923c;
    background: var(--ember-a);
    border-color: rgba(255,105,48,.18);
    font-family: var(--fm);
    font-size: .66rem;
    letter-spacing: .03em;
}

/* Right: clock */
.hero-right {
    position: relative;
    z-index: 1;
    flex-shrink: 0;
    text-align: right;
}

.hero-clock-display {
    font-family: var(--fm);
    font-weight: 500;
    line-height: 1;
    margin-bottom: 6px;
    display: flex;
    align-items: baseline;
    justify-content: flex-end;
    gap: 1px;
}

.clock-hm {
    font-size: 2.8rem;
    letter-spacing: -.04em;
    color: var(--t1);
}

.clock-sep { font-size: 2.8rem; color: var(--t3); letter-spacing: -.04em; }

.clock-ss {
    font-size: 1.1rem;
    color: var(--t3);
    align-self: flex-end;
    margin-bottom: 4px;
    margin-left: 1px;
}

.hero-clock-date {
    font-size: .7rem;
    font-weight: 600;
    letter-spacing: .09em;
    text-transform: uppercase;
    color: var(--t3);
    margin-bottom: 10px;
}

/* Day progress */
.day-prog-label {
    font-size: .6rem;
    font-weight: 600;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: var(--t3);
    margin-bottom: 5px;
    display: flex;
    justify-content: flex-end;
    gap: 6px;
}

.day-prog-label span { color: var(--t2); font-family: var(--fm); }

.day-bar {
    width: 180px;
    height: 3px;
    background: rgba(255,255,255,.06);
    border-radius: 10px;
    overflow: hidden;
    margin-left: auto;
}

.day-bar-fill {
    height: 100%;
    border-radius: 10px;
    background: linear-gradient(90deg, var(--ember), var(--amber));
    box-shadow: 0 0 8px rgba(255,105,48,.4);
    transition: width .8s cubic-bezier(.4,0,.2,1);
}

/* ── Stats ─────────────────────────────────────────────────────── */
.dash-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
    margin-bottom: 12px;
}

.scard {
    background: var(--card);
    border: 1px solid var(--rim);
    border-radius: 13px;
    padding: 16px 18px 15px;
    position: relative;
    overflow: hidden;
    transition: border-color .2s, transform .2s, box-shadow .2s;
    cursor: default;
    animation: ce-rise .5s ease both;
}

.scard::before {
    content: '';
    position: absolute;
    left: 0; top: 14%; bottom: 14%;
    width: 2.5px;
    border-radius: 0 3px 3px 0;
}

.scard.sc-ember::before { background: var(--ember); box-shadow: 0 0 8px rgba(255,105,48,.5); }
.scard.sc-jade::before  { background: var(--jade);  box-shadow: 0 0 8px rgba(16,217,138,.5); }
.scard.sc-sky::before   { background: var(--sky);   box-shadow: 0 0 8px rgba(56,189,248,.5); }
.scard.sc-amber::before { background: var(--amber); box-shadow: 0 0 8px rgba(245,158,11,.5); }

.scard:nth-child(1) { animation-delay: .06s; }
.scard:nth-child(2) { animation-delay: .10s; }
.scard:nth-child(3) { animation-delay: .14s; }
.scard:nth-child(4) { animation-delay: .18s; }

.scard:hover {
    border-color: var(--rim-hi);
    transform: translateY(-3px);
    box-shadow: 0 12px 32px rgba(0,0,0,.55);
}

.scard-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 14px;
}

.scard-label {
    font-size: .61rem;
    font-weight: 700;
    letter-spacing: .11em;
    text-transform: uppercase;
    color: var(--t3);
}

.scard-icon {
    width: 28px; height: 28px;
    border-radius: 7px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}

.sc-ember .scard-icon { background: rgba(255,105,48,.1); color: var(--ember); }
.sc-jade  .scard-icon { background: rgba(16,217,138,.1); color: var(--jade); }
.sc-sky   .scard-icon { background: rgba(56,189,248,.1); color: var(--sky); }
.sc-amber .scard-icon { background: rgba(245,158,11,.1); color: var(--amber); }

.scard-icon svg { width: 14px; height: 14px; }

.scard-val {
    font-family: var(--fd);
    font-size: 2.4rem;
    font-weight: 800;
    letter-spacing: -.06em;
    line-height: 1;
    margin-bottom: 10px;
    transition: color .3s;
}

.sc-ember .scard-val { color: #ffe3d6; }
.sc-jade  .scard-val { color: #d0ffec; }
.sc-sky   .scard-val { color: #d8f0ff; }
.sc-amber .scard-val { color: #fff3d0; }

.scard-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: .6rem;
    font-weight: 700;
    letter-spacing: .05em;
    text-transform: uppercase;
    padding: 2px 7px;
    border-radius: 4px;
}

.scard-badge::before {
    content: '';
    width: 4px; height: 4px;
    border-radius: 50%;
    flex-shrink: 0;
}

.sc-ember .scard-badge { background: rgba(255,105,48,.1); color: #fb923c; border: 1px solid rgba(255,105,48,.15); }
.sc-ember .scard-badge::before { background: var(--ember); }
.sc-jade  .scard-badge { background: rgba(16,217,138,.1); color: #34d399; border: 1px solid rgba(16,217,138,.15); }
.sc-jade  .scard-badge::before { background: var(--jade); }
.sc-sky   .scard-badge { background: rgba(56,189,248,.1); color: var(--sky); border: 1px solid rgba(56,189,248,.15); }
.sc-sky   .scard-badge::before { background: var(--sky); }
.sc-amber .scard-badge { background: rgba(245,158,11,.1); color: var(--amber); border: 1px solid rgba(245,158,11,.15); }
.sc-amber .scard-badge::before { background: var(--amber); }

/* ── Main grid ─────────────────────────────────────────────────── */
.dash-main {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 12px;
    align-items: start;
}

/* ── Panel ─────────────────────────────────────────────────────── */
.panel {
    background: var(--card);
    border: 1px solid var(--rim);
    border-radius: 13px;
    overflow: hidden;
    animation: ce-rise .5s .22s ease both;
}

.panel-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 20px 13px;
    border-bottom: 1px solid var(--rim);
}

.panel-title {
    font-family: var(--fd);
    font-size: .83rem;
    font-weight: 700;
    color: var(--t1);
    letter-spacing: -.015em;
    display: flex;
    align-items: center;
    gap: 8px;
}

.panel-count {
    font-family: var(--fm);
    font-size: .6rem;
    font-weight: 500;
    color: var(--t3);
    background: rgba(255,255,255,.04);
    border: 1px solid var(--rim);
    padding: 1px 6px;
    border-radius: 20px;
    letter-spacing: .02em;
}

.panel-link {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    font-size: .69rem;
    font-weight: 600;
    color: var(--t3);
    text-decoration: none;
    letter-spacing: .02em;
    transition: color .15s;
    padding: 3px 0;
}

.panel-link:hover { color: var(--ember); }
.panel-link svg { width: 9px; height: 9px; transition: transform .15s; }
.panel-link:hover svg { transform: translateX(2px); }

/* ── Activity list ─────────────────────────────────────────────── */
.act-list { padding: 4px 0; }

.act-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 20px;
    transition: background .13s;
    cursor: default;
}

.act-item:hover { background: var(--card-hi); }
.act-item + .act-item { border-top: 1px solid rgba(255,255,255,.028); }

.act-item:nth-child(1) { animation: act-in .35s .08s ease both; }
.act-item:nth-child(2) { animation: act-in .35s .13s ease both; }
.act-item:nth-child(3) { animation: act-in .35s .18s ease both; }
.act-item:nth-child(4) { animation: act-in .35s .23s ease both; }
.act-item:nth-child(5) { animation: act-in .35s .28s ease both; }
.act-item:nth-child(6) { animation: act-in .35s .33s ease both; }
.act-item:nth-child(7) { animation: act-in .35s .38s ease both; }

@keyframes act-in {
    from { opacity: 0; transform: translateX(-10px); }
    to   { opacity: 1; transform: translateX(0); }
}

.act-ico {
    width: 33px; height: 33px;
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.act-ico svg { width: 14px; height: 14px; }

.act-ico-file     { background: rgba(255,105,48,.1);  color: var(--ember); }
.act-ico-calendar { background: rgba(56,189,248,.1);  color: var(--sky); }
.act-ico-user     { background: rgba(135,135,154,.1); color: var(--t2); }

.act-body { flex: 1; min-width: 0; }

.act-title {
    font-size: .8rem;
    font-weight: 600;
    color: var(--t1);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.3;
}

.act-sub {
    font-size: .67rem;
    color: var(--t3);
    margin-top: 2px;
    font-family: var(--fm);
    display: flex;
    align-items: center;
    gap: 6px;
}

.act-new {
    font-family: var(--fb);
    font-size: .55rem;
    font-weight: 700;
    letter-spacing: .07em;
    text-transform: uppercase;
    padding: 1px 5px;
    border-radius: 3px;
    background: rgba(255,105,48,.12);
    color: #fb923c;
    border: 1px solid rgba(255,105,48,.2);
}

.act-date {
    font-family: var(--fm);
    font-size: .63rem;
    color: var(--t3);
    flex-shrink: 0;
}

.act-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 52px 20px;
    gap: 10px;
    color: var(--t3);
}

.act-empty svg { opacity: .2; }
.act-empty p { font-size: .78rem; letter-spacing: .02em; }

/* ── Right column ──────────────────────────────────────────────── */
.right-col { display: flex; flex-direction: column; gap: 10px; }

/* ── Profile card ──────────────────────────────────────────────── */
.profile-card {
    background: var(--card);
    border: 1px solid var(--rim);
    border-radius: 13px;
    overflow: hidden;
    animation: ce-rise .5s .28s ease both;
}

.profile-top {
    padding: 18px 20px 16px;
    display: flex;
    align-items: center;
    gap: 14px;
    border-bottom: 1px solid var(--rim);
    background: linear-gradient(145deg, rgba(255,105,48,.04) 0%, transparent 70%);
}

/* Rotating ring avatar */
.av-ring {
    position: relative;
    width: 54px; height: 54px;
    flex-shrink: 0;
}

.av-ring::before {
    content: '';
    position: absolute;
    inset: -2px;
    border-radius: 50%;
    background: conic-gradient(
        var(--ember) 0deg,
        var(--amber) 100deg,
        rgba(255,255,255,.06) 160deg,
        rgba(255,255,255,.06) 320deg,
        var(--ember) 360deg
    );
    animation: ring-turn 5s linear infinite;
}

@keyframes ring-turn {
    to { transform: rotate(360deg); }
}

.av-ring::after {
    content: '';
    position: absolute;
    inset: 1px;
    border-radius: 50%;
    background: var(--card);
    z-index: 1;
}

.av-img {
    position: absolute;
    inset: 2px;
    border-radius: 50%;
    object-fit: cover;
    z-index: 2;
    display: block;
}

.av-dot {
    position: absolute;
    bottom: 2px; right: 2px;
    width: 10px; height: 10px;
    background: var(--jade);
    border: 2px solid var(--card);
    border-radius: 50%;
    z-index: 3;
    box-shadow: 0 0 0 0 rgba(16,217,138,.4);
    animation: pulse-ring 2.5s ease-out infinite;
}

.profile-info { flex: 1; min-width: 0; }

.profile-name {
    font-family: var(--fd);
    font-size: .95rem;
    font-weight: 700;
    color: var(--t1);
    letter-spacing: -.025em;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.2;
}

.profile-post {
    font-size: .7rem;
    font-weight: 500;
    color: var(--t2);
    margin-top: 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.profile-mat {
    display: inline-block;
    margin-top: 5px;
    font-family: var(--fm);
    font-size: .61rem;
    color: var(--ember);
    background: var(--ember-a);
    border: 1px solid rgba(255,105,48,.18);
    padding: 2px 7px;
    border-radius: 4px;
    letter-spacing: .02em;
}

/* Profile rows */
.profile-rows {}

.prow {
    display: flex;
    align-items: center;
    gap: 11px;
    padding: 9px 20px;
    border-bottom: 1px solid rgba(255,255,255,.028);
    transition: background .12s;
}

.prow:last-child { border-bottom: none; }
.prow:hover { background: var(--card-hi); }

.prow-ic {
    width: 16px;
    display: flex; align-items: center; justify-content: center;
    color: var(--t3);
    flex-shrink: 0;
}
.prow-ic svg { width: 12px; height: 12px; }

.prow-txt { flex: 1; min-width: 0; }

.prow-lbl {
    font-size: .57rem;
    font-weight: 700;
    letter-spacing: .09em;
    text-transform: uppercase;
    color: var(--t3);
}

.prow-val {
    font-size: .75rem;
    font-weight: 600;
    color: var(--t1);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-top: 1px;
}

.profile-footer {
    padding: 14px 20px;
    border-top: 1px solid var(--rim);
}

.btn-orange {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    width: 100%;
    padding: 9px 16px;
    background: var(--ember);
    color: #fff;
    font-family: var(--fb);
    font-size: .78rem;
    font-weight: 700;
    letter-spacing: -.01em;
    border: none;
    border-radius: 8px;
    text-decoration: none;
    cursor: pointer;
    transition: background .15s, transform .15s, box-shadow .15s;
}

.btn-orange svg { width: 13px; height: 13px; flex-shrink: 0; }

.btn-orange:hover {
    background: #e85520;
    transform: translateY(-1px);
    box-shadow: 0 6px 22px rgba(255,105,48,.38);
}

/* ── Quick actions ─────────────────────────────────────────────── */
.actions-card {
    background: var(--card);
    border: 1px solid var(--rim);
    border-radius: 13px;
    overflow: hidden;
    animation: ce-rise .5s .35s ease both;
}

.actions-grid {
    padding: 12px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 6px;
}

.qa-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 9px 10px;
    background: rgba(255,255,255,.022);
    border: 1px solid rgba(255,255,255,.04);
    border-radius: 8px;
    color: var(--t2);
    text-decoration: none;
    font-size: .72rem;
    font-weight: 600;
    transition: all .15s ease;
    white-space: nowrap;
    overflow: hidden;
    letter-spacing: .005em;
}

.qa-ic {
    width: 24px; height: 24px;
    border-radius: 6px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    background: rgba(255,255,255,.04);
    transition: background .15s;
}
.qa-ic svg { width: 11px; height: 11px; }

.qa-btn:hover {
    background: var(--ember-a);
    border-color: rgba(255,105,48,.16);
    color: var(--t1);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,.3);
}
.qa-btn:hover .qa-ic { background: rgba(255,105,48,.18); color: var(--ember); }

/* Primary action — full width */
.qa-btn.qa-primary {
    grid-column: 1 / -1;
    background: var(--ember-a);
    border-color: rgba(255,105,48,.18);
    color: #fb923c;
    font-weight: 700;
}
.qa-btn.qa-primary .qa-ic { background: rgba(255,105,48,.18); color: var(--ember); }
.qa-btn.qa-primary:hover { background: rgba(255,105,48,.2); box-shadow: 0 4px 16px rgba(255,105,48,.18); }

/* ── Animations ────────────────────────────────────────────────── */
@keyframes ce-rise {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Responsive ────────────────────────────────────────────────── */
@media (max-width: 1080px) {
    .dash-stats { grid-template-columns: repeat(2, 1fr); }
    .dash-main  { grid-template-columns: 1fr; }
}
@media (max-width: 640px) {
    .dash        { padding: 12px; }
    .dash-stats  { grid-template-columns: 1fr 1fr; }
    .dash-hero   { flex-direction: column; align-items: flex-start; gap: 16px; padding: 22px 20px; }
    .hero-right  { text-align: left; }
    .day-bar     { width: 100%; margin-left: 0; }
    .hero-name   { font-size: 1.6rem; }
    .clock-hm    { font-size: 2rem; }
    .clock-sep   { font-size: 2rem; }
}
</style>
@endsection

@section('content')
@php
    $prenomDisplay = $personnel ? $personnel->prenoms : auth()->user()->name;
@endphp

<div class="dash">

    {{-- ══════════════════════ HERO ══════════════════════ --}}
    <div class="dash-hero">
        <div class="hero-left">
            <div class="hero-eyebrow">
                <div class="hero-pulse"></div>
                <span class="hero-eyebrow-lbl" id="ce-greeting-lbl">Bonjour</span>
            </div>
            <h1 class="hero-name">{{ $prenomDisplay }}</h1>
            <div class="hero-chips">
                @if($personnel && $personnel->poste)
                <span class="chip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    {{ $personnel->poste }}
                </span>
                @endif
                @if($personnel && $personnel->departement)
                <span class="chip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                    {{ $personnel->departement->nom }}
                </span>
                @endif
                @if($personnel && $personnel->matricule)
                <span class="chip chip-ember">{{ $personnel->matricule }}</span>
                @endif
                @if($personnel && $personnel->date_embauche)
                <span class="chip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Depuis {{ $personnel->date_embauche->format('d/m/Y') }}
                </span>
                @endif
            </div>
        </div>

        <div class="hero-right">
            <div class="hero-clock-display">
                <span class="clock-hm" id="ce-clock-hm">--:--</span>
                <span class="clock-ss" id="ce-clock-ss">--</span>
            </div>
            <div class="hero-clock-date">{{ now()->translatedFormat('l j F Y') }}</div>
            <div class="day-prog-label">
                Journée <span id="ce-day-pct">0%</span>
            </div>
            <div class="day-bar">
                <div class="day-bar-fill" id="ce-day-fill" style="width:0%"></div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════ KPI ══════════════════════ --}}
    <div class="dash-stats">

        <div class="scard sc-ember">
            <div class="scard-top">
                <span class="scard-label">Documents</span>
                <div class="scard-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
            </div>
            <div class="scard-val" data-count="{{ $stats['documents'] }}">0</div>
            <span class="scard-badge">Dossier actif</span>
        </div>

        <div class="scard sc-jade">
            <div class="scard-top">
                <span class="scard-label">Congés restants</span>
                <div class="scard-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><path d="M9 16l2 2 4-4"/></svg>
                </div>
            </div>
            <div class="scard-val" data-count="{{ $stats['conges_restants'] }}">0</div>
            <span class="scard-badge">Jours disponibles</span>
        </div>

        <div class="scard sc-sky">
            <div class="scard-top">
                <span class="scard-label">Demandes</span>
                <div class="scard-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
            </div>
            <div class="scard-val" data-count="{{ $stats['demandes_en_cours'] }}">0</div>
            <span class="scard-badge">En cours</span>
        </div>

        <div class="scard sc-amber">
            <div class="scard-top">
                <span class="scard-label">Ancienneté</span>
                <div class="scard-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
            </div>
            <div class="scard-val" data-count="{{ $stats['anciennete'] }}">0</div>
            <span class="scard-badge">{{ $stats['anciennete'] <= 1 ? 'An de service' : 'Ans de service' }}</span>
        </div>

    </div>

    {{-- ══════════════════════ MAIN GRID ══════════════════════ --}}
    <div class="dash-main">

        {{-- ─ Activité ─ --}}
        <div class="panel">
            <div class="panel-head">
                <span class="panel-title">
                    Activité récente
                    @if(count($activities) > 0)
                    <span class="panel-count">{{ count($activities) }}</span>
                    @endif
                </span>
                <a href="{{ route('espace-employe.documents') }}" class="panel-link">
                    Voir tout
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>
            <div class="act-list">
                @forelse($activities as $activity)
                <div class="act-item">
                    <div class="act-ico act-ico-{{ $activity['icon'] ?? 'file' }}">
                        @if(($activity['icon'] ?? '') === 'calendar')
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="16" y1="2" x2="16" y2="6"/></svg>
                        @elseif(($activity['icon'] ?? '') === 'user')
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        @endif
                    </div>
                    <div class="act-body">
                        <div class="act-title">{{ $activity['title'] }}</div>
                        <div class="act-sub">
                            {{ $activity['date']->diffForHumans() }}
                            @if($activity['date']->isToday())
                                <span class="act-new">New</span>
                            @endif
                        </div>
                    </div>
                    <div class="act-date">{{ $activity['date']->format('d/m/Y') }}</div>
                </div>
                @empty
                <div class="act-empty">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    <p>Aucune activité récente</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- ─ Right column ─ --}}
        <div class="right-col">

            {{-- Profil --}}
            <div class="profile-card">
                <div class="profile-top">
                    <div class="av-ring">
                        <img
                            src="{{ $personnel && $personnel->photo
                                ? asset('storage/' . $personnel->photo)
                                : 'https://ui-avatars.com/api/?name=' . urlencode($personnel ? $personnel->nom . '+' . $personnel->prenoms : auth()->user()->name) . '&size=200&background=ff6930&color=fff&bold=true' }}"
                            alt="Avatar"
                            class="av-img"
                            onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&size=200&background=ff6930&color=fff&bold=true'">
                        <span class="av-dot"></span>
                    </div>
                    <div class="profile-info">
                        <div class="profile-name">{{ $personnel ? $personnel->nom_complet : auth()->user()->name }}</div>
                        <div class="profile-post">{{ $personnel ? $personnel->poste : 'Employé' }}</div>
                        @if($personnel && $personnel->matricule)
                        <div class="profile-mat">{{ $personnel->matricule }}</div>
                        @endif
                    </div>
                </div>

                <div class="profile-rows">
                    @if($personnel && $personnel->departement)
                    <div class="prow">
                        <div class="prow-ic"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg></div>
                        <div class="prow-txt">
                            <div class="prow-lbl">Département</div>
                            <div class="prow-val">{{ $personnel->departement->nom }}</div>
                        </div>
                    </div>
                    @endif
                    @if($personnel && $personnel->service)
                    <div class="prow">
                        <div class="prow-ic"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg></div>
                        <div class="prow-txt">
                            <div class="prow-lbl">Service</div>
                            <div class="prow-val">{{ $personnel->service->nom }}</div>
                        </div>
                    </div>
                    @endif
                    <div class="prow">
                        <div class="prow-ic"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></div>
                        <div class="prow-txt">
                            <div class="prow-lbl">Email</div>
                            <div class="prow-val">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                </div>

                <div class="profile-footer">
                    <a href="{{ route('espace-employe.profil') }}" class="btn-orange">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Mon profil complet
                    </a>
                </div>
            </div>

            {{-- Actions --}}
            <div class="actions-card">
                <div class="panel-head">
                    <span class="panel-title">Actions rapides</span>
                </div>
                <div class="actions-grid">

                    <a href="{{ route('espace-employe.conges') }}" class="qa-btn qa-primary">
                        <div class="qa-ic">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><path d="M9 16h6"/></svg>
                        </div>
                        Demander un congé
                    </a>

                    <a href="{{ route('espace-employe.bulletins') }}" class="qa-btn">
                        <div class="qa-ic">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                        </div>
                        Bulletins de paie
                    </a>

                    <a href="{{ route('espace-employe.attestations') }}" class="qa-btn">
                        <div class="qa-ic">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><path d="M9 15l2 2 4-4"/></svg>
                        </div>
                        Attestations
                    </a>

                    <a href="{{ route('espace-employe.documents') }}" class="qa-btn">
                        <div class="qa-ic">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                        </div>
                        Mes documents
                    </a>

                    <a href="{{ route('espace-employe.demandes') }}" class="qa-btn">
                        <div class="qa-ic">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </div>
                        Mes demandes
                    </a>

                    <a href="{{ route('espace-employe.profil') }}" class="qa-btn">
                        <div class="qa-ic">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        Mon profil
                    </a>

                </div>
            </div>

        </div>{{-- /right-col --}}
    </div>{{-- /dash-main --}}

</div>{{-- /.dash --}}
@endsection

@section('scripts')
<script>
(function () {
    'use strict';

    /* ── Greeting ───────────────────────────────────────────── */
    var h = new Date().getHours();
    var lbl = document.getElementById('ce-greeting-lbl');
    if (lbl) lbl.textContent = h < 12 ? 'Bonjour' : h < 18 ? 'Bon après-midi' : 'Bonsoir';

    /* ── Live clock ─────────────────────────────────────────── */
    function pad(n) { return String(n).padStart(2, '0'); }

    function tick() {
        var d  = new Date();
        var hm = document.getElementById('ce-clock-hm');
        var ss = document.getElementById('ce-clock-ss');
        if (hm) hm.textContent = pad(d.getHours()) + ':' + pad(d.getMinutes());
        if (ss) ss.textContent = pad(d.getSeconds());

        /* Day progress */
        var totalSecs = 86400;
        var elapsed   = d.getHours() * 3600 + d.getMinutes() * 60 + d.getSeconds();
        var pct       = Math.round((elapsed / totalSecs) * 100);
        var fill      = document.getElementById('ce-day-fill');
        var lbl2      = document.getElementById('ce-day-pct');
        if (fill) fill.style.width = pct + '%';
        if (lbl2) lbl2.textContent = pct + '%';
    }

    tick();
    setInterval(tick, 1000);

    /* ── Count-up animation ─────────────────────────────────── */
    function countUp(el) {
        var target   = parseInt(el.dataset.count, 10) || 0;
        if (target === 0) { el.textContent = '0'; return; }
        var duration = 700;
        var start    = null;
        function step(ts) {
            if (!start) start = ts;
            var progress = Math.min((ts - start) / duration, 1);
            var ease     = 1 - Math.pow(1 - progress, 3); /* ease-out-cubic */
            el.textContent = Math.round(ease * target);
            if (progress < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    }

    /* Trigger countUp when cards enter viewport */
    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                countUp(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: .3 });

    document.querySelectorAll('[data-count]').forEach(function (el) {
        observer.observe(el);
    });

})();
</script>
@endsection
