@extends('layouts.app')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')
@section('page-subtitle', 'Vue d\'ensemble de votre activité')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
    <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
</svg>
@endsection

@section('styles')
<style>
/* ═══════════════════════════════════════════════════════════════════
   DASHBOARD — Indigo × Teal · Precision Dark Design System
   Syne (display) · DM Sans (body) · DM Mono (data)
   ═══════════════════════════════════════════════════════════════════ */

:root {
    --d-bg:       #0b1120;
    --d-surf:     #111827;
    --d-surf2:    #1a2332;
    --d-surf3:    #1f2d3f;
    --d-bdr:      rgba(255,255,255,.07);
    --d-bdr2:     rgba(255,255,255,.12);
    --d-text:     #e2e8f0;
    --d-text2:    #94a3b8;
    --d-text3:    #4b6070;
    --d-ind:      #6366f1;
    --d-ind-d:    #4338ca;
    --d-ind-l:    rgba(99,102,241,.12);
    --d-teal:     #14b8a6;
    --d-teal-l:   rgba(20,184,166,.12);
    --d-amb:      #f59e0b;
    --d-amb-l:    rgba(245,158,11,.12);
    --d-red:      #ef4444;
    --d-red-l:    rgba(239,68,68,.12);
    --d-emer:     #10b981;
    --d-emer-l:   rgba(16,185,129,.12);
    --d-r:        14px;
}

/* ── Page ── */
.db { font-family: 'DM Sans', sans-serif; color: var(--d-text); padding: 0 4px; animation: db-in .4s cubic-bezier(.16,1,.3,1); }
@keyframes db-in { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }

/* ── Section label ── */
.db-lbl {
    font-size: .65rem; font-weight: 700; letter-spacing: .12em;
    text-transform: uppercase; color: var(--d-text3);
    margin-bottom: 12px; display: flex; align-items: center; gap: 10px;
}
.db-lbl::after { content:''; flex:1; height:1px; background:var(--d-bdr); }

/* ═══════════════════════ HERO ═══════════════════════ */
.db-hero {
    position: relative; overflow: hidden;
    background: linear-gradient(135deg, #312e81 0%, #4338ca 40%, #0d9488 100%);
    border-radius: 20px;
    padding: 44px 48px 40px;
    margin-bottom: 24px;
}
.db-hero::before {
    content: ''; position: absolute;
    top: -90px; right: -60px;
    width: 380px; height: 380px; border-radius: 50%;
    background: radial-gradient(circle, rgba(255,255,255,.07) 0%, transparent 70%);
    pointer-events: none;
}
.db-hero::after {
    content: ''; position: absolute;
    bottom: -80px; left: 28%;
    width: 280px; height: 280px; border-radius: 50%;
    background: radial-gradient(circle, rgba(20,184,166,.13) 0%, transparent 70%);
    pointer-events: none;
}

.db-hero-content { position: relative; z-index: 1; }

.db-hero-meta {
    display: flex; align-items: center; gap: 8px;
    font-size: .65rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase;
    color: rgba(255,255,255,.55); margin-bottom: 16px;
}
.db-live-dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: #34d399; flex-shrink: 0;
    box-shadow: 0 0 0 3px rgba(52,211,153,.25);
    animation: db-dot 2s infinite;
}
@keyframes db-dot {
    0%,100% { box-shadow: 0 0 0 3px rgba(52,211,153,.25); }
    50%      { box-shadow: 0 0 0 7px rgba(52,211,153,.07); }
}

.db-hero-row { display: flex; align-items: flex-end; justify-content: space-between; gap: 24px; flex-wrap: wrap; }
.db-hero-left {}
.db-hero-title {
    font-family: 'Syne', sans-serif; font-size: 2.5rem; font-weight: 800;
    color: #fff; letter-spacing: -.05em; margin: 0 0 8px; line-height: 1.1;
}
.db-hero-title span { color: #5eead4; }
.db-hero-sub {
    font-size: .8125rem; color: rgba(255,255,255,.5);
    margin: 0; line-height: 1.6; max-width: 420px;
}

.db-hero-right { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
.db-hero-date {
    display: flex; align-items: center; gap: 7px;
    font-family: 'DM Mono', monospace; font-size: .75rem; font-weight: 600;
    color: rgba(255,255,255,.6);
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.15);
    padding: 9px 15px; border-radius: 10px;
    backdrop-filter: blur(8px);
}
.db-hero-date svg { color: #5eead4; flex-shrink: 0; }
.db-hero-avatar {
    width: 54px; height: 54px; border-radius: 14px;
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.2);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Syne', sans-serif; font-size: 1.15rem; font-weight: 700; color: #fff;
    backdrop-filter: blur(8px); flex-shrink: 0;
}

.db-hero-kpis {
    display: flex; gap: 10px; flex-wrap: wrap; margin-top: 32px;
    padding-top: 28px;
    border-top: 1px solid rgba(255,255,255,.1);
}
.db-hero-kpi {
    background: rgba(255,255,255,.09);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,.14);
    border-radius: 14px; padding: 14px 20px;
    min-width: 120px; flex: 1;
    transition: background .2s, border-color .2s;
    cursor: default;
}
.db-hero-kpi:hover { background: rgba(255,255,255,.14); border-color: rgba(255,255,255,.25); }
.db-hero-kpi-label {
    font-size: .6rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase;
    color: rgba(255,255,255,.45); margin-bottom: 8px; white-space: nowrap;
}
.db-hero-kpi-val {
    font-family: 'Syne', sans-serif; font-size: 1.8rem; font-weight: 700;
    color: #fff; line-height: 1; letter-spacing: -.04em;
}

/* ═══════════════════════ ALERT BANNER ═══════════════════════ */
.db-alert {
    display: flex; align-items: center; gap: 14px;
    background: rgba(245,158,11,.07);
    border: 1px solid rgba(245,158,11,.18);
    border-left: 3px solid var(--d-amb);
    border-radius: 12px; padding: 13px 18px;
    margin-bottom: 20px;
}
.db-alert-icon { color: var(--d-amb); flex-shrink: 0; }
.db-alert-icon svg { width: 17px; height: 17px; display: block; }
.db-alert-text { flex: 1; font-size: .78rem; color: var(--d-text2); line-height: 1.5; }
.db-alert-text strong { color: #fbbf24; font-weight: 700; }
.db-alert-links { display: flex; gap: 8px; flex-shrink: 0; }
.db-alert-link {
    font-size: .72rem; font-weight: 700; color: #fbbf24; text-decoration: none; white-space: nowrap;
    padding: 6px 13px; background: rgba(245,158,11,.12);
    border-radius: 8px; transition: background .2s;
}
.db-alert-link:hover { background: rgba(245,158,11,.22); color: #fff; }

/* ═══════════════════════ KPI CARDS ═══════════════════════ */
.db-kpi-grid {
    display: grid; grid-template-columns: repeat(5,1fr); gap: 12px; margin-bottom: 20px;
}
.db-kpi {
    background: var(--d-surf); border: 1px solid var(--d-bdr);
    border-radius: var(--d-r); padding: 20px 22px;
    position: relative; overflow: hidden;
    display: flex; align-items: center; gap: 16px;
    transition: all .25s cubic-bezier(.16,1,.3,1);
    cursor: default;
    animation: db-kpi-in .4s cubic-bezier(.16,1,.3,1) backwards;
}
.db-kpi:nth-child(1){animation-delay:.04s}.db-kpi:nth-child(2){animation-delay:.08s}
.db-kpi:nth-child(3){animation-delay:.12s}.db-kpi:nth-child(4){animation-delay:.16s}
.db-kpi:nth-child(5){animation-delay:.20s}
@keyframes db-kpi-in { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:translateY(0)} }

/* orb top-right */
.db-kpi::before {
    content: ''; position: absolute;
    top: -30px; right: -20px;
    width: 110px; height: 110px; border-radius: 50%;
    background: radial-gradient(circle, var(--db-kg, rgba(99,102,241,.07)) 0%, transparent 70%);
    pointer-events: none;
}
/* bottom bar slides in */
.db-kpi::after {
    content: ''; position: absolute;
    bottom: 0; left: 0; right: 0; height: 3px;
    background: linear-gradient(90deg, var(--db-kc, var(--d-ind)), transparent);
    transform: scaleX(0); transform-origin: left;
    transition: transform .3s cubic-bezier(.16,1,.3,1);
}
.db-kpi:hover { border-color: var(--db-kc, var(--d-ind)); transform: translateY(-3px); box-shadow: 0 12px 32px rgba(0,0,0,.4); }
.db-kpi:hover::after { transform: scaleX(1); }
.db-kpi:hover .db-kpi-icon { transform: scale(1.1) rotate(-5deg); }

.db-kpi-ind  { --db-kc: var(--d-ind);  --db-kg: rgba(99,102,241,.08); }
.db-kpi-teal { --db-kc: var(--d-teal); --db-kg: rgba(20,184,166,.08); }
.db-kpi-amb  { --db-kc: var(--d-amb);  --db-kg: rgba(245,158,11,.07); }
.db-kpi-red  { --db-kc: var(--d-red);  --db-kg: rgba(239,68,68,.07); }
.db-kpi-emer { --db-kc: var(--d-emer); --db-kg: rgba(16,185,129,.08); }

.db-kpi-icon {
    width: 52px; height: 52px; border-radius: 14px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    background: var(--db-kg, var(--d-ind-l));
    color: var(--db-kc, var(--d-ind));
    transition: transform .2s;
    position: relative; z-index: 1;
}
.db-kpi-icon svg { width: 23px; height: 23px; }

.db-kpi-body { flex: 1; min-width: 0; position: relative; z-index: 1; }
.db-kpi-label { font-size: .6rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--d-text3); margin-bottom: 4px; }
.db-kpi-val {
    font-family: 'Syne', sans-serif; font-size: 2rem; font-weight: 700;
    color: var(--d-text); line-height: 1; margin-bottom: 8px;
    letter-spacing: -.03em; transition: color .2s;
}
.db-kpi:hover .db-kpi-val { color: var(--db-kc, var(--d-ind)); }

.db-kpi-tags { display: flex; flex-wrap: wrap; gap: 4px; }
.db-tag {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 2px 8px; border-radius: 5px;
    font-size: .6rem; font-weight: 700; letter-spacing: .04em; text-transform: uppercase;
    white-space: nowrap;
}
.db-tag::before { content:''; width:4px; height:4px; border-radius:50%; flex-shrink:0; background:currentColor; opacity:.7; }
.db-tag-ind  { background: var(--d-ind-l);  color: #818cf8; }
.db-tag-teal { background: var(--d-teal-l); color: #2dd4bf; }
.db-tag-emer { background: var(--d-emer-l); color: #34d399; }
.db-tag-red  { background: var(--d-red-l);  color: #f87171; }
.db-tag-amb  { background: var(--d-amb-l);  color: #fbbf24; }
.db-tag-gray { background: rgba(100,116,139,.1); color: #64748b; }

/* ═══════════════════════ MAIN GRID ═══════════════════════ */
.db-main { display: grid; grid-template-columns: 5fr 3fr; gap: 14px; margin-bottom: 14px; }

.db-card {
    background: var(--d-surf); border: 1px solid var(--d-bdr);
    border-radius: var(--d-r); overflow: hidden;
    display: flex; flex-direction: column;
}
.db-card-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: 14px 18px; border-bottom: 1px solid var(--d-bdr); flex-shrink: 0;
}
.db-card-title {
    font-family: 'Syne', sans-serif; font-size: .875rem; font-weight: 700;
    color: var(--d-text); letter-spacing: -.01em;
}
.db-card-meta { font-size: .68rem; color: var(--d-text3); font-weight: 600; letter-spacing: .04em; }
.db-card-body { flex: 1; padding: 16px 18px; overflow: hidden; position: relative; }

/* Chart legend pills */
.db-pills { display: flex; gap: 7px; }
.db-pill {
    display: flex; align-items: center; gap: 5px;
    padding: 3px 9px; border-radius: 6px;
    font-size: .62rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase;
}
.db-pill-dot { width: 7px; height: 7px; border-radius: 2px; flex-shrink: 0; }
.db-pill-ind  { background: var(--d-ind-l);  color: #818cf8; border: 1px solid rgba(99,102,241,.2); }
.db-pill-teal { background: var(--d-teal-l); color: #2dd4bf; border: 1px solid rgba(20,184,166,.2); }

/* ═══════════════════════ ACTIVITY TIMELINE ═══════════════════════ */
.db-timeline { flex: 1; overflow-y: auto; padding: 8px 0; scrollbar-width: thin; scrollbar-color: var(--d-bdr) transparent; }
.db-timeline::-webkit-scrollbar { width: 3px; }
.db-timeline::-webkit-scrollbar-thumb { background: var(--d-surf3); border-radius: 2px; }

.db-tl-item {
    display: flex; gap: 12px; padding: 10px 18px;
    transition: background .15s; position: relative;
    animation: db-tl-in .35s cubic-bezier(.16,1,.3,1) backwards;
}
.db-tl-item:nth-child(1){animation-delay:.05s}.db-tl-item:nth-child(2){animation-delay:.1s}
.db-tl-item:nth-child(3){animation-delay:.15s}.db-tl-item:nth-child(4){animation-delay:.2s}
.db-tl-item:nth-child(5){animation-delay:.25s}.db-tl-item:nth-child(6){animation-delay:.3s}
.db-tl-item:nth-child(7){animation-delay:.35s}.db-tl-item:nth-child(8){animation-delay:.4s}
@keyframes db-tl-in { from{opacity:0;transform:translateX(-8px)} to{opacity:1;transform:translateX(0)} }
.db-tl-item:hover { background: var(--d-surf2); }

.db-tl-item:not(:last-child)::after {
    content: ''; position: absolute;
    left: 29px; top: 44px; bottom: -10px; width: 1.5px;
    background: linear-gradient(180deg, var(--d-bdr2) 0%, transparent 100%);
}
.db-tl-icon {
    width: 30px; height: 30px; border-radius: 9px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    margin-top: 1px; transition: transform .2s;
}
.db-tl-item:hover .db-tl-icon { transform: scale(1.12); }
.db-tl-icon svg { width: 13px; height: 13px; }
.db-tl-icon-ind  { background: var(--d-ind-l);  color: #818cf8; }
.db-tl-icon-teal { background: var(--d-teal-l); color: #2dd4bf; }
.db-tl-icon-emer { background: var(--d-emer-l); color: #34d399; }
.db-tl-icon-red  { background: var(--d-red-l);  color: #f87171; }
.db-tl-icon-amb  { background: var(--d-amb-l);  color: #fbbf24; }

.db-tl-body { flex: 1; min-width: 0; }
.db-tl-title { font-size: .78rem; font-weight: 600; color: var(--d-text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; line-height: 1.3; }
.db-tl-desc { font-size: .7rem; color: var(--d-text2); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; line-height: 1.4; margin-top: 1px; }
.db-tl-time { font-family: 'DM Mono', monospace; font-size: .6rem; color: var(--d-text3); flex-shrink: 0; margin-top: 5px; letter-spacing: .02em; }
.db-tl-empty { display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; gap: 10px; color: var(--d-text3); font-size: .78rem; }

/* ═══════════════════════ SUMMARY ═══════════════════════ */
.db-summary {
    background: var(--d-surf); border: 1px solid var(--d-bdr);
    border-radius: var(--d-r); overflow: hidden; margin-bottom: 14px;
}
.db-sum-inner { display: grid; grid-template-columns: repeat(6,1fr); }
.db-sum-cell {
    padding: 16px 18px; border-right: 1px solid var(--d-bdr);
    transition: background .15s; position: relative; cursor: default;
}
.db-sum-cell:last-child { border-right: none; }
.db-sum-cell:hover { background: var(--d-surf2); }
.db-sum-cell:hover::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, var(--d-ind), var(--d-teal));
}
.db-sum-icon {
    width: 26px; height: 26px; border-radius: 7px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 10px;
}
.db-sum-icon svg { width: 13px; height: 13px; }
.db-sum-label { font-size: .6rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--d-text3); margin-bottom: 5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.db-sum-val { font-family: 'Syne', sans-serif; font-size: 1.35rem; font-weight: 700; color: var(--d-text); letter-spacing: -.02em; line-height: 1.1; }
.db-sum-cell.c-ind  .db-sum-val { color: #818cf8; }
.db-sum-cell.c-teal .db-sum-val { color: #2dd4bf; }
.db-sum-cell.c-amb  .db-sum-val { color: #fbbf24; }
.db-sum-cell.c-emer .db-sum-val { color: #34d399; }
.db-sum-cell.c-ind  .db-sum-icon { background: var(--d-ind-l);  color: #818cf8; }
.db-sum-cell.c-teal .db-sum-icon { background: var(--d-teal-l); color: #2dd4bf; }
.db-sum-cell.c-amb  .db-sum-icon { background: var(--d-amb-l);  color: #fbbf24; }
.db-sum-cell.c-emer .db-sum-icon { background: var(--d-emer-l); color: #34d399; }
.db-sum-cell:not([class*="c-"]) .db-sum-icon { background: rgba(100,116,139,.1); color: #64748b; }

/* ═══════════════════════ QUICK ACTIONS ═══════════════════════ */
.db-actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 10px;
}
.db-ac {
    display: flex; flex-direction: column; align-items: flex-start;
    padding: 18px 18px 16px;
    background: var(--d-surf2);
    border: 1px solid var(--d-bdr2);
    border-radius: 14px;
    text-decoration: none;
    transition: all .25s cubic-bezier(.16,1,.3,1);
    position: relative; overflow: hidden;
}
.db-ac::after {
    content: ''; position: absolute;
    bottom: 0; left: 0; right: 0; height: 2.5px;
    background: linear-gradient(90deg, var(--db-ac-c), transparent);
    transform: scaleX(0); transform-origin: left;
    transition: transform .3s cubic-bezier(.16,1,.3,1);
}
.db-ac:hover { border-color: var(--db-ac-c); transform: translateY(-3px); box-shadow: 0 10px 28px rgba(0,0,0,.32); }
.db-ac:hover::after { transform: scaleX(1); }
.db-ac:hover .db-ac-icon { transform: scale(1.1) rotate(-6deg); }
.db-ac-icon {
    width: 40px; height: 40px; border-radius: 11px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    background: rgba(var(--db-ac-rgb), .12);
    color: var(--db-ac-c);
    margin-bottom: 14px;
    transition: transform .2s;
}
.db-ac-icon svg { width: 19px; height: 19px; }
.db-ac-label { font-size: .8rem; font-weight: 700; color: var(--d-text); letter-spacing: -.01em; margin-bottom: 3px; line-height: 1.3; }
.db-ac-desc  { font-size: .68rem; color: var(--d-text3); line-height: 1.5; }

.db-ac-ind  { --db-ac-c: var(--d-ind);  --db-ac-rgb: 99,102,241; }
.db-ac-teal { --db-ac-c: var(--d-teal); --db-ac-rgb: 20,184,166; }
.db-ac-amb  { --db-ac-c: var(--d-amb);  --db-ac-rgb: 245,158,11; }
.db-ac-red  { --db-ac-c: var(--d-red);  --db-ac-rgb: 239,68,68; }
.db-ac-emer { --db-ac-c: var(--d-emer); --db-ac-rgb: 16,185,129; }

/* ═══════════════════════ RESPONSIVE ═══════════════════════ */
@media(max-width:1300px) {
    .db-kpi-grid { grid-template-columns: repeat(3,1fr); }
    .db-hero { padding: 36px 36px 32px; }
}
@media(max-width:960px)  {
    .db-kpi-grid { grid-template-columns: repeat(2,1fr); }
    .db-main { grid-template-columns: 1fr; height: auto; }
    .db-main .db-card:first-child { height: 280px; }
    .db-main .db-card:last-child  { height: 260px; }
    .db-sum-inner { grid-template-columns: repeat(3,1fr); }
    .db-sum-cell:nth-child(3) { border-right: none; }
    .db-sum-cell:nth-child(n+4) { border-top: 1px solid var(--d-bdr); }
    .db-hero-row { flex-direction: column; align-items: flex-start; gap: 20px; }
}
@media(max-width:600px)  {
    .db-kpi-grid { grid-template-columns: 1fr; }
    .db-sum-inner { grid-template-columns: repeat(2,1fr); }
    .db-sum-cell:nth-child(2n) { border-right: none; }
    .db-hero { padding: 28px 24px; }
    .db-hero-title { font-size: 1.8rem; }
    .db-hero-kpis { gap: 8px; }
    .db-hero-kpi { min-width: calc(50% - 4px); }
}
</style>
@endsection

@section('content')
<div class="db">

    {{-- ══ HERO ══ --}}
    <div class="db-hero">
        <div class="db-hero-content">
            <div class="db-hero-meta">
                <span class="db-live-dot"></span>
                <span>Portail RH+ &mdash; Tableau de bord</span>
            </div>
            <div class="db-hero-row">
                <div class="db-hero-left">
                    <h1 class="db-hero-title">
                        <span id="greetLabel">Bonjour</span>,&nbsp;<span>{{ auth()->user()->prenom ?? explode(' ', auth()->user()->name ?? 'Admin')[0] }}</span>
                    </h1>
                    <p class="db-hero-sub">
                        {{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }} &mdash; Vue d'ensemble de votre portail
                    </p>
                </div>
                <div class="db-hero-right">
                    <div class="db-hero-date">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/>
                            <line x1="8" y1="2" x2="8" y2="6"/><line x1="16" y1="2" x2="16" y2="6"/>
                        </svg>
                        {{ now()->locale('fr')->isoFormat('ddd D MMM YYYY') }}
                    </div>
                    <div class="db-hero-avatar">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}{{ strtoupper(substr(explode(' ', auth()->user()->name ?? 'A ')[1] ?? '', 0, 1)) }}
                    </div>
                </div>
            </div>

            <div class="db-hero-kpis">
                <div class="db-hero-kpi">
                    <div class="db-hero-kpi-label">Employés actifs</div>
                    <div class="db-hero-kpi-val" data-hero-count="{{ $totalEmployes }}">{{ $totalEmployes }}</div>
                </div>
                <div class="db-hero-kpi">
                    <div class="db-hero-kpi-label">Congés en attente</div>
                    <div class="db-hero-kpi-val" data-hero-count="{{ $statsConges['en_attente'] }}">{{ $statsConges['en_attente'] }}</div>
                </div>
                <div class="db-hero-kpi">
                    <div class="db-hero-kpi-label">Absences à traiter</div>
                    <div class="db-hero-kpi-val" data-hero-count="{{ $statsAbsences['en_attente'] }}">{{ $statsAbsences['en_attente'] }}</div>
                </div>
                <div class="db-hero-kpi">
                    <div class="db-hero-kpi-label">Bulletins {{ $annee }}</div>
                    <div class="db-hero-kpi-val" data-hero-count="{{ $statsBulletins['total_bulletins'] }}">{{ $statsBulletins['total_bulletins'] }}</div>
                </div>
                @if(auth()->user()->hasRole('Super Admin'))
                <div class="db-hero-kpi">
                    <div class="db-hero-kpi-label">Entreprises</div>
                    <div class="db-hero-kpi-val" data-hero-count="{{ $totalEntreprises }}">{{ $totalEntreprises }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ══ ALERT ══ --}}
    @php $totalPending = $statsConges['en_attente'] + $statsAbsences['en_attente']; @endphp
    @if($totalPending > 0)
    <div class="db-alert">
        <div class="db-alert-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
        </div>
        <div class="db-alert-text">
            <strong>{{ $totalPending }} demande{{ $totalPending > 1 ? 's' : '' }} en attente</strong> &mdash;
            @if($statsConges['en_attente'] > 0){{ $statsConges['en_attente'] }} congé{{ $statsConges['en_attente'] > 1 ? 's' : '' }}@endif
            @if($statsConges['en_attente'] > 0 && $statsAbsences['en_attente'] > 0) et @endif
            @if($statsAbsences['en_attente'] > 0){{ $statsAbsences['en_attente'] }} absence{{ $statsAbsences['en_attente'] > 1 ? 's' : '' }}@endif
            nécessite{{ $totalPending > 1 ? 'nt' : '' }} votre validation.
        </div>
        <div class="db-alert-links">
            @if($statsConges['en_attente'] > 0)
            <a href="{{ route('admin.conges.index') }}" class="db-alert-link">Congés</a>
            @endif
            @if($statsAbsences['en_attente'] > 0)
            <a href="{{ route('admin.absences.index') }}" class="db-alert-link">Absences</a>
            @endif
        </div>
    </div>
    @endif

    {{-- ══ KPI ══ --}}
    <div class="db-lbl">Indicateurs clés</div>
    <div class="db-kpi-grid">

        {{-- Employés actifs --}}
        <div class="db-kpi db-kpi-ind">
            <div class="db-kpi-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div class="db-kpi-body">
                <div class="db-kpi-label">Employés actifs</div>
                <div class="db-kpi-val" data-count="{{ $totalEmployes }}">0</div>
                <div class="db-kpi-tags">
                    <span class="db-tag db-tag-ind">{{ $employesAvecCompte }} avec compte</span>
                </div>
            </div>
        </div>

        {{-- Congés en attente --}}
        <div class="db-kpi db-kpi-amb">
            <div class="db-kpi-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
            </div>
            <div class="db-kpi-body">
                <div class="db-kpi-label">Congés attente</div>
                <div class="db-kpi-val" data-count="{{ $statsConges['en_attente'] }}">0</div>
                <div class="db-kpi-tags">
                    <span class="db-tag db-tag-emer">{{ $statsConges['approuve'] }} approuvés</span>
                    <span class="db-tag db-tag-red">{{ $statsConges['refuse'] }} refusés</span>
                </div>
            </div>
        </div>

        {{-- Absences en attente --}}
        <div class="db-kpi db-kpi-teal">
            <div class="db-kpi-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>
            <div class="db-kpi-body">
                <div class="db-kpi-label">Absences attente</div>
                <div class="db-kpi-val" data-count="{{ $statsAbsences['en_attente'] }}">0</div>
                <div class="db-kpi-tags">
                    <span class="db-tag db-tag-emer">{{ $statsAbsences['justifiees'] }} justifiées</span>
                    <span class="db-tag db-tag-red">{{ $statsAbsences['injustifiees'] }} injust.</span>
                </div>
            </div>
        </div>

        {{-- Bulletins --}}
        <div class="db-kpi db-kpi-ind">
            <div class="db-kpi-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
            </div>
            <div class="db-kpi-body">
                <div class="db-kpi-label">Bulletins {{ $annee }}</div>
                <div class="db-kpi-val" data-count="{{ $statsBulletins['total_bulletins'] }}">0</div>
                <div class="db-kpi-tags">
                    <span class="db-tag db-tag-ind">{{ $statsBulletins['total_employes'] }} employés</span>
                </div>
            </div>
        </div>

        {{-- Docs expirant --}}
        <div class="db-kpi db-kpi-{{ $docsExpirentBientot > 0 ? 'red' : 'emer' }}">
            <div class="db-kpi-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
            </div>
            <div class="db-kpi-body">
                <div class="db-kpi-label">Docs expirant</div>
                <div class="db-kpi-val" data-count="{{ $docsExpirentBientot }}">0</div>
                <div class="db-kpi-tags">
                    @if($docsExpirentBientot > 0)
                        <span class="db-tag db-tag-red">À renouveler</span>
                    @else
                        <span class="db-tag db-tag-emer">Tout en ordre</span>
                    @endif
                </div>
            </div>
        </div>

    </div>

    {{-- ══ CHART + ACTIVITY ══ --}}
    <div class="db-lbl">Suivi &amp; Activité</div>
    <div class="db-main">

        {{-- Chart --}}
        <div class="db-card" style="height:320px">
            <div class="db-card-head">
                <span class="db-card-title">Congés &amp; Absences</span>
                <div style="display:flex;align-items:center;gap:10px">
                    <div class="db-pills">
                        <div class="db-pill db-pill-ind">
                            <div class="db-pill-dot" style="background:#6366f1"></div>Congés
                        </div>
                        <div class="db-pill db-pill-teal">
                            <div class="db-pill-dot" style="background:#14b8a6"></div>Absences
                        </div>
                    </div>
                    <span class="db-card-meta">{{ $annee }}</span>
                </div>
            </div>
            <div class="db-card-body">
                <canvas id="dbChart"></canvas>
            </div>
        </div>

        {{-- Activity timeline --}}
        <div class="db-card" style="height:320px">
            <div class="db-card-head">
                <span class="db-card-title">Activités récentes</span>
                @if($activitesRecentes->count() > 0)
                <span class="db-tag db-tag-gray">{{ $activitesRecentes->count() }}</span>
                @endif
            </div>
            <div class="db-timeline">
                @forelse($activitesRecentes as $activite)
                @php
                    $ic = match($activite['type']) {
                        'conge','demande_conge' => ['cls'=>'db-tl-icon-amb',
                            'svg'=>'<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/>'],
                        'absence'              => ['cls'=>'db-tl-icon-teal',
                            'svg'=>'<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/>'],
                        'bulletin'             => ['cls'=>'db-tl-icon-ind',
                            'svg'=>'<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>'],
                        default                => ['cls'=>'db-tl-icon-emer',
                            'svg'=>'<path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/>'],
                    };
                    if(isset($activite['icon']) && $activite['icon']==='success') $ic['cls']='db-tl-icon-emer';
                    if(isset($activite['icon']) && $activite['icon']==='danger')  $ic['cls']='db-tl-icon-red';
                @endphp
                <div class="db-tl-item">
                    <div class="db-tl-icon {{ $ic['cls'] }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            {!! $ic['svg'] !!}
                        </svg>
                    </div>
                    <div class="db-tl-body">
                        <div class="db-tl-title">{{ $activite['titre'] }}</div>
                        <div class="db-tl-desc">{{ $activite['description'] }}</div>
                    </div>
                    <div class="db-tl-time">{{ $activite['date']->diffForHumans() }}</div>
                </div>
                @empty
                <div class="db-tl-empty">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="opacity:.25">
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <line x1="3" y1="9" x2="21" y2="9"/>
                    </svg>
                    Aucune activité récente
                </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- ══ ANNUAL SUMMARY ══ --}}
    <div class="db-lbl">Résumé annuel &mdash; {{ $annee }}</div>
    <div class="db-summary">
        <div class="db-sum-inner">
            <div class="db-sum-cell">
                <div class="db-sum-icon" style="background:rgba(100,116,139,.1);color:#64748b">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                <div class="db-sum-label">Total congés</div>
                <div class="db-sum-val">{{ $statsConges['total'] }}</div>
            </div>
            <div class="db-sum-cell">
                <div class="db-sum-icon" style="background:rgba(100,116,139,.1);color:#64748b">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/>
                    </svg>
                </div>
                <div class="db-sum-label">Total absences</div>
                <div class="db-sum-val">{{ $statsAbsences['total'] }}</div>
            </div>
            <div class="db-sum-cell c-amb">
                <div class="db-sum-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <div class="db-sum-label">Retards</div>
                <div class="db-sum-val">{{ $statsAbsences['retards'] }}</div>
            </div>
            <div class="db-sum-cell c-ind">
                <div class="db-sum-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                </div>
                <div class="db-sum-label">Bulletins émis</div>
                <div class="db-sum-val">{{ $statsBulletins['total_bulletins'] }}</div>
            </div>
            <div class="db-sum-cell c-teal">
                <div class="db-sum-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                </div>
                <div class="db-sum-label">Masse sal. nette</div>
                <div class="db-sum-val" style="font-size:.95rem">
                    {{ number_format($statsBulletins['masse_salariale_nette'] ?? 0, 0, ',', "\u{202F}") }}&nbsp;F
                </div>
            </div>
            <div class="db-sum-cell">
                <div class="db-sum-icon" style="background:rgba(100,116,139,.1);color:#64748b">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21V5a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                    </svg>
                </div>
                <div class="db-sum-label">Entreprises</div>
                <div class="db-sum-val">{{ $totalEntreprises }}</div>
            </div>
        </div>
    </div>

    {{-- ══ QUICK ACTIONS ══ --}}
    <div class="db-lbl">Actions rapides</div>
    <div class="db-actions-grid">

        @if(auth()->user()->hasRole('Super Admin'))
        <a href="{{ route('admin.entreprises.index') }}" class="db-ac db-ac-ind">
            <div class="db-ac-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 21V5a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v5m-4 0h4"/>
                </svg>
            </div>
            <div class="db-ac-label">Entreprises</div>
            <div class="db-ac-desc">Gérer les sociétés</div>
        </a>
        @endif

        <a href="{{ route('admin.personnels.index') }}" class="db-ac db-ac-teal">
            <div class="db-ac-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/>
                    <line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/>
                </svg>
            </div>
            <div class="db-ac-label">Ajouter employé</div>
            <div class="db-ac-desc">Nouveau personnel</div>
        </a>

        <a href="{{ route('admin.conges.index') }}" class="db-ac db-ac-amb">
            <div class="db-ac-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
            </div>
            <div class="db-ac-label">Gestion congés</div>
            <div class="db-ac-desc">Valider les demandes</div>
        </a>

        <a href="{{ route('admin.absences.index') }}" class="db-ac db-ac-teal">
            <div class="db-ac-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>
            <div class="db-ac-label">Gestion absences</div>
            <div class="db-ac-desc">Suivre les absences</div>
        </a>

        <a href="{{ route('admin.dossiers-agents.index') }}" class="db-ac db-ac-ind">
            <div class="db-ac-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                </svg>
            </div>
            <div class="db-ac-label">Dossiers agents</div>
            <div class="db-ac-desc">Documents RH</div>
        </a>

        <a href="{{ route('admin.bulletins-paie.index') }}" class="db-ac db-ac-emer">
            <div class="db-ac-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
            </div>
            <div class="db-ac-label">Bulletins de paie</div>
            <div class="db-ac-desc">Fiches de salaire</div>
        </a>

        <a href="{{ route('admin.requetes.index') }}" class="db-ac db-ac-ind">
            <div class="db-ac-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
            </div>
            <div class="db-ac-label">Requêtes RH</div>
            <div class="db-ac-desc">Messages employés</div>
        </a>

    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
/* ── Time-based greeting ── */
(function() {
    const h = new Date().getHours();
    const label = document.getElementById('greetLabel');
    if (!label) return;
    if      (h >= 5  && h < 12) { label.textContent = 'Bonjour'; }
    else if (h >= 12 && h < 18) { label.textContent = 'Bon après-midi'; }
    else                         { label.textContent = 'Bonsoir'; }
})();

/* ── Animate KPI counters ── */
document.querySelectorAll('.db-kpi-val[data-count]').forEach(el => {
    const t = parseInt(el.dataset.count) || 0;
    const dur = 800; const start = performance.now();
    (function tick(now) {
        const p = Math.min((now - start) / dur, 1);
        const e = 1 - Math.pow(1 - p, 3);
        el.textContent = Math.round(t * e);
        if (p < 1) requestAnimationFrame(tick);
    })(start);
});

/* ── Animate Hero KPI counters ── */
document.querySelectorAll('.db-hero-kpi-val[data-hero-count]').forEach(el => {
    const t = parseInt(el.dataset.heroCount) || 0;
    const dur = 1000; const start = performance.now();
    (function tick(now) {
        const p = Math.min((now - start) / dur, 1);
        const e = 1 - Math.pow(1 - p, 3);
        el.textContent = Math.round(t * e);
        if (p < 1) requestAnimationFrame(tick);
    })(start);
});

/* ── Chart ── */
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('dbChart');
    if (!canvas) return;

    const moisLabels   = @json($moisLabels);
    const congesData   = @json($congesParMois);
    const absencesData = @json($absencesParMois);
    const ctx = canvas.getContext('2d');

    /* Gradients */
    const gInd = ctx.createLinearGradient(0, 0, 0, 220);
    gInd.addColorStop(0, 'rgba(99,102,241,.65)');
    gInd.addColorStop(1, 'rgba(99,102,241,.04)');

    const gTeal = ctx.createLinearGradient(0, 0, 0, 220);
    gTeal.addColorStop(0, 'rgba(20,184,166,.65)');
    gTeal.addColorStop(1, 'rgba(20,184,166,.04)');

    new Chart(canvas, {
        type: 'bar',
        data: {
            labels: moisLabels,
            datasets: [
                {
                    label: 'Congés',
                    data: congesData,
                    backgroundColor: gInd,
                    borderColor: 'rgba(99,102,241,.9)',
                    borderWidth: 1.5,
                    borderRadius: 5,
                    borderSkipped: false,
                },
                {
                    label: 'Absences',
                    data: absencesData,
                    backgroundColor: gTeal,
                    borderColor: 'rgba(20,184,166,.9)',
                    borderWidth: 1.5,
                    borderRadius: 5,
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
                    backgroundColor: '#1e293b',
                    titleColor: '#e2e8f0',
                    bodyColor:  '#94a3b8',
                    borderColor: 'rgba(99,102,241,.3)',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 10,
                    titleFont: { size: 11, weight: '700', family: "'DM Sans',sans-serif" },
                    bodyFont:  { size: 11, family: "'DM Mono',monospace" },
                    boxWidth: 8, boxHeight: 8, boxPadding: 4,
                    usePointStyle: true, pointStyle: 'rectRounded',
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    border: { display: false },
                    ticks: {
                        color: '#4b6070',
                        font: { size: 10, weight: '600', family: "'DM Sans',sans-serif" },
                        maxRotation: 0,
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(255,255,255,.05)', drawBorder: false },
                    border: { display: false },
                    ticks: {
                        color: '#4b6070',
                        font: { size: 10, family: "'DM Mono',monospace" },
                        stepSize: 1, precision: 0, padding: 6,
                    }
                }
            },
            animation: { duration: 900, easing: 'easeOutQuart' }
        }
    });
});
</script>
@endsection
