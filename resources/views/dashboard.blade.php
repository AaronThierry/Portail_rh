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

/* ═══════════════════════ GREETING ═══════════════════════ */
.db-greet {
    position: relative; overflow: hidden;
    background: var(--d-surf);
    border: 1px solid var(--d-bdr);
    border-radius: 18px;
    padding: 24px 28px;
    margin-bottom: 20px;
    display: flex; align-items: center; justify-content: space-between; gap: 20px;
}
.db-greet::before {
    content:''; position:absolute; top:0; left:0; right:0; height:2px;
    background: linear-gradient(90deg, var(--d-ind), var(--d-teal), transparent);
}
.db-greet::after {
    content:''; position:absolute; top:-60px; right:-40px;
    width:200px; height:200px; border-radius:50%;
    background: radial-gradient(circle, rgba(99,102,241,.08) 0%, transparent 70%);
    pointer-events:none;
}
.db-greet-left { position:relative; z-index:1; }
.db-greet-time {
    font-size:.68rem; font-weight:700; letter-spacing:.12em; text-transform:uppercase;
    color:var(--d-teal); margin-bottom:6px; display:flex; align-items:center; gap:6px;
}
.db-greet-time::before { content:''; width:20px; height:1.5px; background:var(--d-teal); }
.db-greet-h1 {
    font-family:'Syne',sans-serif; font-size:1.6rem; font-weight:700;
    color:var(--d-text); letter-spacing:-.3px; margin:0 0 4px; line-height:1.2;
}
.db-greet-sub { font-size:.8125rem; color:var(--d-text2); margin:0; }

.db-greet-right { display:flex; align-items:center; gap:12px; flex-shrink:0; position:relative; z-index:1; }
.db-greet-date {
    display:flex; align-items:center; gap:7px;
    font-size:.75rem; font-weight:600; color:var(--d-text2);
    background:var(--d-surf2); border:1px solid var(--d-bdr);
    padding:8px 14px; border-radius:10px;
    font-family:'DM Mono',monospace;
}
.db-greet-date svg { color:var(--d-ind); flex-shrink:0; }

.db-greet-avatar {
    width:52px; height:52px; border-radius:14px;
    background:linear-gradient(135deg,var(--d-ind),var(--d-ind-d));
    display:flex; align-items:center; justify-content:center;
    font-family:'Syne',sans-serif; font-size:1.1rem; font-weight:700; color:#fff;
    box-shadow:0 4px 20px rgba(99,102,241,.35); flex-shrink:0;
}

/* ═══════════════════════ KPI CARDS ═══════════════════════ */
.db-kpi-grid {
    display:grid; grid-template-columns:repeat(5,1fr); gap:12px; margin-bottom:20px;
}
.db-kpi {
    background:var(--d-surf); border:1px solid var(--d-bdr);
    border-radius:var(--d-r); padding:18px 18px 14px;
    position:relative; overflow:hidden;
    transition:all .25s cubic-bezier(.16,1,.3,1);
    cursor:default;
    animation:db-kpi-in .4s cubic-bezier(.16,1,.3,1) backwards;
}
.db-kpi:nth-child(1){animation-delay:.04s}.db-kpi:nth-child(2){animation-delay:.08s}
.db-kpi:nth-child(3){animation-delay:.12s}.db-kpi:nth-child(4){animation-delay:.16s}
.db-kpi:nth-child(5){animation-delay:.20s}
@keyframes db-kpi-in { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:translateY(0)} }

/* Left border accent */
.db-kpi::before {
    content:''; position:absolute;
    left:0; top:10%; bottom:10%;
    width:3px; border-radius:0 3px 3px 0;
    background:var(--db-kc,var(--d-ind));
    transition:height .3s; opacity:.7;
}
/* Top right glow */
.db-kpi::after {
    content:''; position:absolute;
    top:-30px; right:-20px;
    width:80px; height:80px; border-radius:50%;
    background:radial-gradient(circle, var(--db-kg,rgba(99,102,241,.08)) 0%, transparent 70%);
    pointer-events:none;
}
.db-kpi:hover {
    border-color:var(--db-kc,var(--d-ind));
    transform:translateY(-4px);
    box-shadow:0 12px 32px rgba(0,0,0,.4), 0 0 0 1px var(--db-kc,var(--d-ind));
}
.db-kpi-ind  { --db-kc:var(--d-ind);  --db-kg:rgba(99,102,241,.08); }
.db-kpi-teal { --db-kc:var(--d-teal); --db-kg:rgba(20,184,166,.08); }
.db-kpi-amb  { --db-kc:var(--d-amb);  --db-kg:rgba(245,158,11,.07); }
.db-kpi-red  { --db-kc:var(--d-red);  --db-kg:rgba(239,68,68,.07); }
.db-kpi-emer { --db-kc:var(--d-emer); --db-kg:rgba(16,185,129,.08); }

.db-kpi-head { display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; }
.db-kpi-label { font-size:.62rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:var(--d-text3); }
.db-kpi-icon {
    width:34px; height:34px; border-radius:9px;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
    background:var(--db-kg,var(--d-ind-l));
    color:var(--db-kc,var(--d-ind));
    transition:all .2s;
}
.db-kpi:hover .db-kpi-icon { transform:scale(1.1) rotate(-5deg); }
.db-kpi-icon svg { width:16px; height:16px; }

.db-kpi-val {
    font-family:'Syne',sans-serif; font-size:2.1rem; font-weight:700;
    color:var(--d-text); line-height:1; margin-bottom:10px;
    letter-spacing:-.03em;
    transition:color .2s;
}
.db-kpi:hover .db-kpi-val { color:var(--db-kc,var(--d-ind)); }

.db-kpi-tags { display:flex; flex-wrap:wrap; gap:4px; }
.db-tag {
    display:inline-flex; align-items:center; gap:4px;
    padding:2px 8px; border-radius:5px;
    font-size:.6rem; font-weight:700; letter-spacing:.04em; text-transform:uppercase;
    white-space:nowrap;
}
.db-tag::before { content:''; width:4px; height:4px; border-radius:50%; flex-shrink:0; background:currentColor; opacity:.7; }
.db-tag-ind  { background:var(--d-ind-l);  color:#818cf8; }
.db-tag-teal { background:var(--d-teal-l); color:#2dd4bf; }
.db-tag-emer { background:var(--d-emer-l); color:#34d399; }
.db-tag-red  { background:var(--d-red-l);  color:#f87171; }
.db-tag-amb  { background:var(--d-amb-l);  color:#fbbf24; }
.db-tag-gray { background:rgba(100,116,139,.1); color:#64748b; }

/* ═══════════════════════ MAIN GRID ═══════════════════════ */
.db-main { display:grid; grid-template-columns:5fr 3fr; gap:14px; margin-bottom:14px; }

.db-card {
    background:var(--d-surf); border:1px solid var(--d-bdr);
    border-radius:var(--d-r); overflow:hidden;
    display:flex; flex-direction:column;
}
.db-card-head {
    display:flex; align-items:center; justify-content:space-between;
    padding:14px 18px; border-bottom:1px solid var(--d-bdr); flex-shrink:0;
}
.db-card-title {
    font-family:'Syne',sans-serif; font-size:.875rem; font-weight:700;
    color:var(--d-text); letter-spacing:-.01em;
}
.db-card-meta { font-size:.68rem; color:var(--d-text3); font-weight:600; letter-spacing:.04em; }
.db-card-body { flex:1; padding:16px 18px; overflow:hidden; position:relative; }

/* Chart legend pills */
.db-pills { display:flex; gap:7px; }
.db-pill {
    display:flex; align-items:center; gap:5px;
    padding:3px 9px; border-radius:6px;
    font-size:.62rem; font-weight:700; letter-spacing:.06em; text-transform:uppercase;
}
.db-pill-dot { width:7px; height:7px; border-radius:2px; flex-shrink:0; }
.db-pill-ind  { background:var(--d-ind-l);  color:#818cf8; border:1px solid rgba(99,102,241,.2); }
.db-pill-teal { background:var(--d-teal-l); color:#2dd4bf; border:1px solid rgba(20,184,166,.2); }

/* ═══════════════════════ ACTIVITY TIMELINE ═══════════════════════ */
.db-timeline { flex:1; overflow-y:auto; padding:8px 0; scrollbar-width:thin; scrollbar-color:var(--d-bdr) transparent; }
.db-timeline::-webkit-scrollbar { width:3px; }
.db-timeline::-webkit-scrollbar-thumb { background:var(--d-surf3); border-radius:2px; }

.db-tl-item {
    display:flex; gap:12px; padding:10px 18px;
    transition:background .15s; position:relative;
    animation:db-tl-in .35s cubic-bezier(.16,1,.3,1) backwards;
}
.db-tl-item:nth-child(1){animation-delay:.05s}.db-tl-item:nth-child(2){animation-delay:.1s}
.db-tl-item:nth-child(3){animation-delay:.15s}.db-tl-item:nth-child(4){animation-delay:.2s}
.db-tl-item:nth-child(5){animation-delay:.25s}.db-tl-item:nth-child(6){animation-delay:.3s}
.db-tl-item:nth-child(7){animation-delay:.35s}.db-tl-item:nth-child(8){animation-delay:.4s}
@keyframes db-tl-in { from{opacity:0;transform:translateX(-8px)} to{opacity:1;transform:translateX(0)} }
.db-tl-item:hover { background:var(--d-surf2); }

/* Connecting line */
.db-tl-item:not(:last-child)::after {
    content:''; position:absolute;
    left:29px; top:44px; bottom:-10px; width:1.5px;
    background:linear-gradient(180deg,var(--d-bdr2) 0%,transparent 100%);
}

.db-tl-icon {
    width:30px; height:30px; border-radius:9px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center;
    margin-top:1px; transition:transform .2s;
}
.db-tl-item:hover .db-tl-icon { transform:scale(1.12); }
.db-tl-icon svg { width:13px; height:13px; }
.db-tl-icon-ind  { background:var(--d-ind-l);  color:#818cf8; }
.db-tl-icon-teal { background:var(--d-teal-l); color:#2dd4bf; }
.db-tl-icon-emer { background:var(--d-emer-l); color:#34d399; }
.db-tl-icon-red  { background:var(--d-red-l);  color:#f87171; }
.db-tl-icon-amb  { background:var(--d-amb-l);  color:#fbbf24; }

.db-tl-body { flex:1; min-width:0; }
.db-tl-title {
    font-size:.78rem; font-weight:600; color:var(--d-text);
    white-space:nowrap; overflow:hidden; text-overflow:ellipsis; line-height:1.3;
}
.db-tl-desc {
    font-size:.7rem; color:var(--d-text2);
    white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
    line-height:1.4; margin-top:1px;
}
.db-tl-time {
    font-family:'DM Mono',monospace; font-size:.6rem; color:var(--d-text3);
    flex-shrink:0; margin-top:5px; letter-spacing:.02em;
}

.db-tl-empty {
    display:flex; flex-direction:column; align-items:center; justify-content:center;
    height:100%; gap:10px; color:var(--d-text3); font-size:.78rem;
}

/* ═══════════════════════ SUMMARY ═══════════════════════ */
.db-summary {
    background:var(--d-surf); border:1px solid var(--d-bdr);
    border-radius:var(--d-r); overflow:hidden; margin-bottom:14px;
}
.db-sum-inner { display:grid; grid-template-columns:repeat(6,1fr); }
.db-sum-cell {
    padding:14px 18px; border-right:1px solid var(--d-bdr);
    transition:background .15s; position:relative;
}
.db-sum-cell:last-child { border-right:none; }
.db-sum-cell:hover { background:var(--d-surf2); }
.db-sum-cell:hover::before {
    content:''; position:absolute; top:0; left:0; right:0; height:2px;
    background:linear-gradient(90deg,var(--d-ind),var(--d-teal));
}
.db-sum-label {
    font-size:.6rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase;
    color:var(--d-text3); margin-bottom:6px; white-space:nowrap;
    overflow:hidden; text-overflow:ellipsis;
}
.db-sum-val {
    font-family:'Syne',sans-serif; font-size:1.25rem; font-weight:700;
    color:var(--d-text); letter-spacing:-.02em; line-height:1.1;
}
.db-sum-cell.c-ind  .db-sum-val { color:#818cf8; }
.db-sum-cell.c-teal .db-sum-val { color:#2dd4bf; }
.db-sum-cell.c-amb  .db-sum-val { color:#fbbf24; }
.db-sum-cell.c-emer .db-sum-val { color:#34d399; }

/* ═══════════════════════ QUICK ACTIONS ═══════════════════════ */
.db-actions {
    background:var(--d-surf); border:1px solid var(--d-bdr);
    border-radius:var(--d-r); padding:14px 18px;
}
.db-actions-inner { display:flex; flex-wrap:wrap; gap:8px; }

.db-action {
    display:inline-flex; align-items:center; gap:8px;
    padding:8px 16px;
    background:var(--d-surf2);
    border:1px solid var(--d-bdr2);
    border-radius:10px;
    color:var(--d-text2); text-decoration:none;
    font-size:.78rem; font-weight:600; letter-spacing:.01em;
    transition:all .2s cubic-bezier(.16,1,.3,1);
    white-space:nowrap;
}
.db-action svg { width:14px; height:14px; flex-shrink:0; transition:transform .2s; }
.db-action:hover { transform:translateY(-2px); color:#fff; }
.db-action:hover svg { transform:scale(1.15) rotate(-5deg); }

.db-action-ind  { }
.db-action-ind:hover { background:var(--d-ind); border-color:var(--d-ind); box-shadow:0 6px 20px rgba(99,102,241,.4); }
.db-action-teal:hover { background:var(--d-teal); border-color:var(--d-teal); box-shadow:0 6px 20px rgba(20,184,166,.35); }
.db-action-amb:hover  { background:var(--d-amb);  border-color:var(--d-amb);  box-shadow:0 6px 20px rgba(245,158,11,.35); }
.db-action-red:hover  { background:var(--d-red);  border-color:var(--d-red);  box-shadow:0 6px 20px rgba(239,68,68,.35); }

/* ═══════════════════════ RESPONSIVE ═══════════════════════ */
@media(max-width:1300px) { .db-kpi-grid{grid-template-columns:repeat(3,1fr)} }
@media(max-width:960px)  {
    .db-kpi-grid{grid-template-columns:repeat(2,1fr)}
    .db-main{grid-template-columns:1fr;height:auto}
    .db-main .db-card:first-child{height:280px}
    .db-main .db-card:last-child{height:260px}
    .db-sum-inner{grid-template-columns:repeat(3,1fr)}
    .db-sum-cell:nth-child(3){border-right:none}
    .db-sum-cell:nth-child(n+4){border-top:1px solid var(--d-bdr)}
}
@media(max-width:600px)  {
    .db-kpi-grid{grid-template-columns:1fr}
    .db-sum-inner{grid-template-columns:repeat(2,1fr)}
    .db-sum-cell:nth-child(2n){border-right:none}
    .db-greet{flex-direction:column;align-items:flex-start;gap:16px}
    .db-greet-h1{font-size:1.3rem}
}
</style>
@endsection

@section('content')
<div class="db">

    {{-- ══ GREETING ══ --}}
    <div class="db-greet">
        <div class="db-greet-left">
            <div class="db-greet-time" id="greetLabel">Bonjour</div>
            <h1 class="db-greet-h1">{{ auth()->user()->prenom ?? explode(' ', auth()->user()->name ?? 'Admin')[0] }}, bienvenue</h1>
            <p class="db-greet-sub">Vue d'ensemble de votre portail RH · {{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}</p>
        </div>
        <div class="db-greet-right">
            <div class="db-greet-date">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/>
                    <line x1="8" y1="2" x2="8" y2="6"/><line x1="16" y1="2" x2="16" y2="6"/>
                </svg>
                {{ now()->locale('fr')->isoFormat('ddd D MMM') }}
            </div>
            <div class="db-greet-avatar">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}{{ strtoupper(substr(explode(' ', auth()->user()->name ?? 'A ')[1] ?? '', 0, 1)) }}
            </div>
        </div>
    </div>

    {{-- ══ KPI ══ --}}
    <div class="db-lbl">Indicateurs clés</div>
    <div class="db-kpi-grid">

        {{-- Employés actifs --}}
        <div class="db-kpi db-kpi-ind">
            <div class="db-kpi-head">
                <span class="db-kpi-label">Employés actifs</span>
                <div class="db-kpi-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
            </div>
            <div class="db-kpi-val" data-count="{{ $totalEmployes }}">0</div>
            <div class="db-kpi-tags">
                <span class="db-tag db-tag-ind">{{ $employesAvecCompte }} avec compte</span>
            </div>
        </div>

        {{-- Congés en attente --}}
        <div class="db-kpi db-kpi-amb">
            <div class="db-kpi-head">
                <span class="db-kpi-label">Congés attente</span>
                <div class="db-kpi-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
            </div>
            <div class="db-kpi-val" data-count="{{ $statsConges['en_attente'] }}">0</div>
            <div class="db-kpi-tags">
                <span class="db-tag db-tag-emer">{{ $statsConges['approuve'] }} approuvés</span>
                <span class="db-tag db-tag-red">{{ $statsConges['refuse'] }} refusés</span>
            </div>
        </div>

        {{-- Absences en attente --}}
        <div class="db-kpi db-kpi-teal">
            <div class="db-kpi-head">
                <span class="db-kpi-label">Absences attente</span>
                <div class="db-kpi-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                </div>
            </div>
            <div class="db-kpi-val" data-count="{{ $statsAbsences['en_attente'] }}">0</div>
            <div class="db-kpi-tags">
                <span class="db-tag db-tag-emer">{{ $statsAbsences['justifiees'] }} justifiées</span>
                <span class="db-tag db-tag-red">{{ $statsAbsences['injustifiees'] }} injust.</span>
            </div>
        </div>

        {{-- Bulletins --}}
        <div class="db-kpi db-kpi-ind">
            <div class="db-kpi-head">
                <span class="db-kpi-label">Bulletins {{ $annee }}</span>
                <div class="db-kpi-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                </div>
            </div>
            <div class="db-kpi-val" data-count="{{ $statsBulletins['total_bulletins'] }}">0</div>
            <div class="db-kpi-tags">
                <span class="db-tag db-tag-ind">{{ $statsBulletins['total_employes'] }} employés</span>
            </div>
        </div>

        {{-- Docs expirant --}}
        <div class="db-kpi db-kpi-{{ $docsExpirentBientot > 0 ? 'red' : 'emer' }}">
            <div class="db-kpi-head">
                <span class="db-kpi-label">Docs expirant</span>
                <div class="db-kpi-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                        <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                </div>
            </div>
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
    <div class="db-lbl">Résumé annuel — {{ $annee }}</div>
    <div class="db-summary">
        <div class="db-sum-inner">
            <div class="db-sum-cell">
                <div class="db-sum-label">Total congés</div>
                <div class="db-sum-val">{{ $statsConges['total'] }}</div>
            </div>
            <div class="db-sum-cell">
                <div class="db-sum-label">Total absences</div>
                <div class="db-sum-val">{{ $statsAbsences['total'] }}</div>
            </div>
            <div class="db-sum-cell">
                <div class="db-sum-label">Retards</div>
                <div class="db-sum-val c-amb">{{ $statsAbsences['retards'] }}</div>
            </div>
            <div class="db-sum-cell c-ind">
                <div class="db-sum-label">Bulletins émis</div>
                <div class="db-sum-val">{{ $statsBulletins['total_bulletins'] }}</div>
            </div>
            <div class="db-sum-cell c-teal">
                <div class="db-sum-label">Masse sal. nette</div>
                <div class="db-sum-val" style="font-size:1rem">
                    {{ number_format($statsBulletins['masse_salariale_nette'] ?? 0, 0, ',', '\u{202F}') }}&nbsp;F
                </div>
            </div>
            <div class="db-sum-cell">
                <div class="db-sum-label">Entreprises</div>
                <div class="db-sum-val">{{ $totalEntreprises }}</div>
            </div>
        </div>
    </div>

    {{-- ══ QUICK ACTIONS ══ --}}
    <div class="db-lbl">Actions rapides</div>
    <div class="db-actions">
        <div class="db-actions-inner">

            @if(auth()->user()->hasRole('Super Admin'))
            <a href="{{ route('admin.entreprises.index') }}" class="db-action db-action-ind">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 21V5a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v5m-4 0h4"/>
                </svg>
                Entreprises
            </a>
            @endif

            <a href="{{ route('admin.personnels.index') }}" class="db-action db-action-teal">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/>
                    <line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/>
                </svg>
                Ajouter employé
            </a>

            <a href="{{ route('admin.conges.index') }}" class="db-action db-action-ind">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                Gestion congés
            </a>

            <a href="{{ route('admin.absences.index') }}" class="db-action db-action-ind">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                Gestion absences
            </a>

            <a href="{{ route('admin.dossiers-agents.index') }}" class="db-action db-action-ind">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                </svg>
                Dossiers Agents
            </a>

            <a href="{{ route('admin.bulletins-paie.index') }}" class="db-action db-action-ind">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
                Bulletins de Paie
            </a>

            <a href="{{ route('admin.requetes.index') }}" class="db-action db-action-teal">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
                Requêtes RH
            </a>

        </div>
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
