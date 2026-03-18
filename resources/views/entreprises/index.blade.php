@extends('layouts.app')

@section('title', 'Gestion des Entreprises')
@section('page-title', 'Entreprises')
@section('page-subtitle', 'Gérez vos entreprises partenaires')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
</svg>
@endsection

@section('styles')
<style>
/* ═══════════════════════════════════════════════════════════════
   ENTREPRISES — Indigo × Teal Design System
   Syne (display) · DM Sans (body) · DM Mono (mono)
   ═══════════════════════════════════════════════════════════════ */

:root {
    --e-ind:    #6366f1; --e-ind-d: #4338ca; --e-ind-l: #eef2ff; --e-ind-m: #c7d2fe;
    --e-teal:   #14b8a6; --e-teal-d: #0d9488; --e-teal-l: #f0fdfa; --e-teal-m: #99f6e4;
    --e-red:    #ef4444; --e-red-l: #fef2f2;
    --e-amber:  #f59e0b; --e-amb-l: #fffbeb;
    --e-emer:   #10b981; --e-emer-l: #ecfdf5;
    --e-surf:   #fff;
    --e-bg:     #f8fafc;
    --e-text:   #1e293b; --e-text2: #475569; --e-text3: #94a3b8;
    --e-bdr:    #e2e8f0; --e-bdr2: #f1f5f9;
    --e-sh:   0 1px 3px rgba(0,0,0,.05), 0 1px 2px rgba(0,0,0,.04);
    --e-shm:  0 4px 14px rgba(0,0,0,.07), 0 2px 4px rgba(0,0,0,.04);
    --e-shl:  0 14px 32px rgba(0,0,0,.09), 0 4px 8px rgba(0,0,0,.05);
    --e-r: 13px; --e-rl: 18px; --e-rxl: 20px;
}
.dark {
    --e-surf: #1e293b; --e-bg: #0f172a;
    --e-text: #f1f5f9; --e-text2: #cbd5e1; --e-text3: #64748b;
    --e-bdr: #334155; --e-bdr2: #1e293b;
    --e-ind-l:  rgba(99,102,241,.12); --e-ind-m: rgba(99,102,241,.25);
    --e-teal-l: rgba(20,184,166,.1);  --e-teal-m: rgba(20,184,166,.25);
    --e-amb-l:  rgba(245,158,11,.1);
    --e-red-l:  rgba(239,68,68,.1);   --e-emer-l: rgba(16,185,129,.1);
    --e-sh:  0 1px 3px rgba(0,0,0,.25);
    --e-shm: 0 4px 14px rgba(0,0,0,.35);
    --e-shl: 0 14px 32px rgba(0,0,0,.45);
}

/* ── Animations ── */
@keyframes e-up    { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }
@keyframes e-in    { from{opacity:0;transform:scale(.97)}       to{opacity:1;transform:scale(1)} }
@keyframes e-modal { from{opacity:0;transform:scale(.96) translateY(12px)} to{opacity:1;transform:scale(1) translateY(0)} }
@keyframes e-spin  { to{transform:rotate(360deg)} }
@keyframes e-dot   { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(1.5)} }
@keyframes e-pulse { 0%,100%{opacity:1} 50%{opacity:.4} }

/* ── Page ── */
.ent-page { font-family:'DM Sans',sans-serif; max-width:1440px; margin:0 auto; animation:e-up .4s cubic-bezier(.16,1,.3,1); }

/* ══════════════════════════════════
   HERO BANNER
══════════════════════════════════ */
.ent-hero {
    position:relative; border-radius:20px; overflow:hidden;
    margin-bottom:24px; animation:e-up .4s cubic-bezier(.16,1,.3,1) .04s both;
}
.ent-hero-bg {
    background:linear-gradient(135deg,#312e81 0%,#4338ca 40%,#0d9488 100%);
    padding:1.875rem 2rem; position:relative;
}
.ent-hero-bg::before {
    content:''; position:absolute; top:-70px; right:-70px; width:260px; height:260px;
    background:radial-gradient(circle,rgba(20,184,166,.35) 0%,transparent 70%);
    border-radius:50%; pointer-events:none;
}
.ent-hero-bg::after {
    content:''; position:absolute; bottom:-50px; left:-50px; width:200px; height:200px;
    background:radial-gradient(circle,rgba(99,102,241,.3) 0%,transparent 70%);
    border-radius:50%; pointer-events:none;
}
.ent-hero-inner {
    position:relative; display:flex; align-items:center;
    justify-content:space-between; gap:1.5rem; flex-wrap:wrap;
}
.ent-hero-left h1 {
    font-family:'Syne',sans-serif; font-size:1.75rem; font-weight:700;
    color:#fff; margin:0 0 .3rem; letter-spacing:-.4px; line-height:1.2;
}
.ent-hero-sub {
    font-size:.875rem; color:rgba(255,255,255,.72); margin:0;
    display:flex; align-items:center; gap:8px;
}
.ent-live-dot {
    width:7px; height:7px; border-radius:50%; background:#14b8a6;
    display:inline-block; animation:e-dot 2s ease-in-out infinite;
    box-shadow:0 0 0 3px rgba(20,184,166,.25);
}
.ent-hero-kpis {
    background:rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.14);
    border-radius:16px; padding:.875rem 1.5rem; display:flex; gap:2rem;
    backdrop-filter:blur(8px); -webkit-backdrop-filter:blur(8px);
}
.ent-hero-kpi { text-align:center; position:relative; }
.ent-hero-kpi + .ent-hero-kpi::before {
    content:''; position:absolute; left:-1rem; top:15%; bottom:15%;
    width:1px; background:rgba(255,255,255,.15);
}
.ent-hero-kpi-val {
    font-family:'Syne',sans-serif; font-size:1.5rem; font-weight:700; color:#fff; line-height:1;
}
.ent-hero-kpi-lbl {
    font-size:.6875rem; color:rgba(255,255,255,.6);
    text-transform:uppercase; letter-spacing:.5px; font-weight:600; margin-top:.3rem;
}
.ent-hero-actions { display:flex; align-items:center; gap:10px; flex-shrink:0; }
.ent-hero-accent {
    height:3px;
    background:linear-gradient(90deg,transparent,rgba(99,102,241,.6),rgba(20,184,166,.8),transparent);
}
.ent-btn-hero {
    display:inline-flex; align-items:center; gap:8px; padding:10px 20px;
    border-radius:12px; font-size:.875rem; font-weight:600; cursor:pointer;
    transition:all .22s; white-space:nowrap;
    background:rgba(255,255,255,.15); color:#fff;
    border:1.5px solid rgba(255,255,255,.25); backdrop-filter:blur(8px);
    text-decoration:none;
}
.ent-btn-hero:hover { background:rgba(255,255,255,.25); transform:translateY(-2px); color:#fff; }
.ent-btn-hero svg { width:17px; height:17px; flex-shrink:0; }
.ent-btn-hero-outline {
    display:inline-flex; align-items:center; gap:8px; padding:10px 18px;
    border-radius:12px; font-size:.875rem; font-weight:600; cursor:pointer;
    transition:all .22s; white-space:nowrap;
    background:rgba(255,255,255,.08); color:rgba(255,255,255,.75);
    border:1.5px solid rgba(255,255,255,.15); backdrop-filter:blur(4px);
    text-decoration:none;
}
.ent-btn-hero-outline:hover { background:rgba(255,255,255,.15); color:#fff; }
.ent-btn-hero-outline svg { width:16px; height:16px; flex-shrink:0; }

/* ══════════════════════════════════
   STAT CARDS
══════════════════════════════════ */
.ent-stats {
    display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px;
}
.ent-stat {
    background:var(--e-surf); border:1.5px solid var(--e-bdr);
    border-radius:var(--e-rl); padding:20px 22px;
    display:flex; align-items:center; gap:16px;
    box-shadow:var(--e-sh); transition:all .25s cubic-bezier(.16,1,.3,1);
    position:relative; overflow:hidden; cursor:default;
    animation:e-up .4s cubic-bezier(.16,1,.3,1) backwards;
}
.ent-stat:nth-child(1){animation-delay:.04s}.ent-stat:nth-child(2){animation-delay:.08s}
.ent-stat:nth-child(3){animation-delay:.12s}.ent-stat:nth-child(4){animation-delay:.16s}
.ent-stat:hover { transform:translateY(-4px); box-shadow:var(--e-shl); border-color:var(--e-stat-c,var(--e-ind)); }
.ent-stat::before {
    content:''; position:absolute; top:-28px; right:-28px;
    width:90px; height:90px; border-radius:50%;
    background:var(--e-stat-g,rgba(99,102,241,.06)); pointer-events:none;
}
.ent-stat::after {
    content:''; position:absolute; bottom:0; left:0; right:0; height:3px;
    background:var(--e-stat-c,var(--e-ind));
    transform:scaleX(0); transform-origin:left;
    transition:transform .32s cubic-bezier(.16,1,.3,1);
}
.ent-stat:hover::after { transform:scaleX(1); }
.ent-stat.s-blue  { --e-stat-c:var(--e-ind);   --e-stat-g:rgba(99,102,241,.06); }
.ent-stat.s-green { --e-stat-c:var(--e-teal);  --e-stat-g:rgba(20,184,166,.06); }
.ent-stat.s-red   { --e-stat-c:var(--e-red);   --e-stat-g:rgba(239,68,68,.05); }
.ent-stat.s-amber { --e-stat-c:var(--e-amber); --e-stat-g:rgba(245,158,11,.05); }
.ent-stat-icon {
    width:48px; height:48px; border-radius:13px;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.ent-stat-icon svg { width:22px; height:22px; stroke-width:2; }
.ent-stat.s-blue  .ent-stat-icon { background:var(--e-ind-l);  color:var(--e-ind); }
.ent-stat.s-green .ent-stat-icon { background:var(--e-teal-l); color:var(--e-teal-d); }
.ent-stat.s-red   .ent-stat-icon { background:var(--e-red-l);  color:var(--e-red); }
.ent-stat.s-amber .ent-stat-icon { background:var(--e-amb-l);  color:var(--e-amber); }
.ent-stat-body { flex:1; min-width:0; }
.ent-stat-val {
    font-family:'Syne',sans-serif; font-size:2rem; font-weight:700;
    color:var(--e-text); line-height:1; margin-bottom:4px;
}
.ent-stat-label {
    font-size:.68rem; color:var(--e-text3); font-weight:600;
    text-transform:uppercase; letter-spacing:.7px;
}

/* ══════════════════════════════════
   FLASH ALERTS
══════════════════════════════════ */
.ent-alert {
    display:flex; align-items:center; gap:.75rem;
    padding:.875rem 1.125rem; border-radius:var(--e-r); margin-bottom:1.25rem;
    font-size:.875rem; font-weight:500; border:1px solid; animation:e-up .3s ease;
}
.ent-alert svg { width:18px; height:18px; flex-shrink:0; }
.ent-alert-success { background:var(--e-emer-l); border-color:rgba(16,185,129,.2); color:#065f46; }
.ent-alert-error   { background:var(--e-red-l);  border-color:rgba(239,68,68,.2);  color:#991b1b; }
.dark .ent-alert-success { color:#6ee7b7; }
.dark .ent-alert-error   { color:#fca5a5; }

/* ══════════════════════════════════
   TOOLBAR
══════════════════════════════════ */
.ent-toolbar {
    background:var(--e-surf); border:1.5px solid var(--e-bdr);
    border-radius:var(--e-rl); padding:.875rem 1.25rem;
    margin-bottom:1.25rem; display:flex; align-items:center;
    gap:.875rem; flex-wrap:wrap; box-shadow:var(--e-sh);
}
.ent-search { flex:1; min-width:220px; position:relative; }
.ent-search svg {
    position:absolute; left:.875rem; top:50%; transform:translateY(-50%);
    color:var(--e-text3); width:16px; height:16px; pointer-events:none;
}
.ent-search input {
    width:100%; padding:.5rem .875rem .5rem 2.5rem;
    border:1.5px solid var(--e-bdr); border-radius:var(--e-r);
    background:var(--e-bg); color:var(--e-text); font-family:'DM Sans',sans-serif;
    font-size:.8125rem; transition:all .2s; box-sizing:border-box;
}
.ent-search input:focus { outline:none; border-color:var(--e-ind); box-shadow:0 0 0 3px rgba(99,102,241,.12); }
.ent-search input::placeholder { color:var(--e-text3); }
.ent-filters { display:flex; gap:.375rem; }
.ent-filter-btn {
    padding:.4375rem .875rem; border:1.5px solid var(--e-bdr);
    border-radius:100px; background:transparent; color:var(--e-text2);
    font-family:'DM Sans',sans-serif; font-size:.75rem; font-weight:600;
    cursor:pointer; transition:all .2s; display:flex; align-items:center;
    gap:.375rem; white-space:nowrap;
}
.ent-filter-btn:hover { border-color:var(--e-ind); color:var(--e-ind); }
.ent-filter-btn.active { background:linear-gradient(135deg,#4338ca,#6366f1); border-color:transparent; color:#fff; box-shadow:0 2px 8px rgba(99,102,241,.3); }
.ent-filter-count {
    font-size:.6875rem; padding:.0625rem .4375rem; border-radius:100px;
    background:rgba(255,255,255,.2); font-weight:700; min-width:18px; text-align:center;
}
.ent-filter-btn:not(.active) .ent-filter-count { background:var(--e-bdr); color:var(--e-text2); }
.ent-view-toggle {
    display:flex; background:var(--e-bg); border-radius:var(--e-r);
    padding:.1875rem; border:1.5px solid var(--e-bdr);
}
.ent-view-btn {
    padding:.375rem .625rem; border:none; background:transparent;
    color:var(--e-text3); border-radius:8px; cursor:pointer;
    transition:all .2s; display:flex; align-items:center;
}
.ent-view-btn:hover { color:var(--e-text2); }
.ent-view-btn.active { background:var(--e-surf); color:var(--e-ind); box-shadow:var(--e-sh); }
.ent-view-btn svg { width:16px; height:16px; }

/* ══════════════════════════════════
   CARD GRID
══════════════════════════════════ */
.ent-grid {
    display:grid; grid-template-columns:repeat(auto-fill,minmax(340px,1fr)); gap:1rem;
}
.ent-card {
    background:var(--e-surf); border:1.5px solid var(--e-bdr);
    border-radius:var(--e-rl); padding:1.375rem;
    transition:all .3s cubic-bezier(.4,0,.2,1);
    position:relative; display:flex; flex-direction:column;
    animation:e-up .4s cubic-bezier(.16,1,.3,1) backwards;
}
.ent-card:hover { box-shadow:var(--e-shl); border-color:var(--e-ind-m); transform:translateY(-3px); }
.dark .ent-card:hover { border-color:rgba(99,102,241,.3); }
.ent-card-top { display:flex; align-items:flex-start; gap:.875rem; margin-bottom:1.125rem; }
.ent-card-logo {
    width:48px; height:48px; border-radius:var(--e-r); flex-shrink:0;
    overflow:hidden; border:1.5px solid var(--e-bdr);
}
.ent-card-logo img { width:100%; height:100%; object-fit:cover; }
.ent-card-logo-ph {
    width:48px; height:48px; border-radius:var(--e-r);
    background:linear-gradient(135deg,#4338ca,#14b8a6);
    display:flex; align-items:center; justify-content:center;
    color:#fff; font-weight:700; font-size:.875rem; letter-spacing:-.5px; flex-shrink:0;
}
.ent-card-identity { flex:1; min-width:0; }
.ent-card-name {
    font-family:'Syne',sans-serif; font-size:.9375rem; font-weight:700;
    color:var(--e-text); margin:0;
    white-space:nowrap; overflow:hidden; text-overflow:ellipsis; line-height:1.3;
}
.ent-card-sigle {
    font-size:.6875rem; color:var(--e-text3); font-weight:600;
    text-transform:uppercase; letter-spacing:.75px; margin-top:.125rem;
}
.ent-badge {
    display:inline-flex; align-items:center; gap:.3125rem;
    padding:.25rem .625rem; border-radius:100px;
    font-size:.625rem; font-weight:700; text-transform:uppercase; letter-spacing:.5px;
    flex-shrink:0; margin-left:auto;
}
.ent-badge-active   { background:var(--e-teal-l); color:var(--e-teal-d); }
.ent-badge-inactive { background:var(--e-red-l);  color:var(--e-red); }
.ent-badge-dot { width:5px; height:5px; border-radius:50%; background:currentColor; }
.ent-badge-active .ent-badge-dot { animation:e-pulse 2s infinite; }

.ent-card-details { display:flex; flex-direction:column; gap:.5rem; flex:1; margin-bottom:1.125rem; }
.ent-card-row { display:flex; align-items:center; gap:.625rem; }
.ent-card-row-icon {
    width:28px; height:28px; border-radius:8px; background:var(--e-bg);
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
    color:var(--e-text3);
}
.ent-card-row-icon svg { width:14px; height:14px; }
.ent-card-row-value {
    font-size:.8125rem; color:var(--e-text2); font-weight:500;
    overflow:hidden; text-overflow:ellipsis; white-space:nowrap; flex:1;
}
.ent-card-footer {
    display:flex; gap:.5rem; padding-top:1rem;
    border-top:1px solid var(--e-bdr2); margin-top:auto;
}
.ent-card-btn {
    flex:1; display:inline-flex; align-items:center; justify-content:center;
    gap:.375rem; padding:.5rem; border-radius:var(--e-r);
    font-family:'DM Sans',sans-serif; font-size:.75rem; font-weight:600;
    cursor:pointer; transition:all .2s; border:1.5px solid transparent; text-decoration:none;
}
.ent-card-btn svg { width:14px; height:14px; }
.ent-card-btn-view   { background:var(--e-ind-l);  color:var(--e-ind); }
.ent-card-btn-view:hover   { background:var(--e-ind);  color:#fff; }
.ent-card-btn-edit   { background:var(--e-teal-l); color:var(--e-teal-d); }
.ent-card-btn-edit:hover   { background:var(--e-teal-d); color:#fff; }
.ent-card-btn-delete { background:var(--e-red-l);  color:var(--e-red); flex:0; padding:.5rem .625rem; }
.ent-card-btn-delete:hover { background:var(--e-red); color:#fff; }

/* ══════════════════════════════════
   TABLE VIEW
══════════════════════════════════ */
.ent-table-wrap {
    background:var(--e-surf); border:1.5px solid var(--e-bdr);
    border-radius:var(--e-rl); overflow:hidden; box-shadow:var(--e-sh);
}
.ent-table { width:100%; border-collapse:collapse; }
.ent-table thead { background:var(--e-bg); border-bottom:1px solid var(--e-bdr); }
.ent-table th {
    padding:.75rem 1.25rem; text-align:left; font-size:.6875rem;
    font-weight:700; color:var(--e-text3); text-transform:uppercase; letter-spacing:.5px;
}
.ent-table tbody tr { border-bottom:1px solid var(--e-bdr2); transition:background .15s; }
.ent-table tbody tr:last-child { border-bottom:none; }
.ent-table tbody tr:hover { background:rgba(99,102,241,.03); }
.dark .ent-table tbody tr:hover { background:rgba(99,102,241,.06); }
.ent-table td { padding:.875rem 1.25rem; font-size:.8125rem; color:var(--e-text); }
.ent-table-company { display:flex; align-items:center; gap:.75rem; }
.ent-table-company-info { display:flex; flex-direction:column; }
.ent-table-company-name { font-weight:700; color:var(--e-text); }
.ent-table-company-sigle { font-size:.6875rem; color:var(--e-text3); font-weight:500; }
.ent-table-actions { display:flex; gap:.375rem; }
.ent-table-btn {
    width:32px; height:32px; border-radius:8px;
    display:flex; align-items:center; justify-content:center;
    cursor:pointer; transition:all .2s; border:none; text-decoration:none;
}
.ent-table-btn svg { width:15px; height:15px; }

/* ══════════════════════════════════
   EMPTY STATE
══════════════════════════════════ */
.ent-empty {
    text-align:center; padding:4rem 2rem; grid-column:1 / -1;
}
.ent-empty-icon {
    width:80px; height:80px; margin:0 auto 1.25rem;
    background:linear-gradient(135deg,var(--e-ind-l),var(--e-teal-l));
    border-radius:50%; display:flex; align-items:center; justify-content:center;
    color:var(--e-ind);
}
.ent-empty-icon svg { width:36px; height:36px; }
.ent-empty h3 {
    font-family:'Syne',sans-serif; font-size:1.25rem; font-weight:700;
    color:var(--e-text); margin:0 0 .375rem;
}
.ent-empty p { color:var(--e-text2); margin:0 0 1.5rem; font-size:.875rem; }

/* ══════════════════════════════════
   MODAL — Conforme absences
══════════════════════════════════ */
@keyframes ent-overlay-in { from{opacity:0} to{opacity:1} }
@keyframes ent-modal-in { from{opacity:0;transform:translateY(20px) scale(.97)} to{opacity:1;transform:translateY(0) scale(1)} }

.ent-modal-overlay {
    display:none; position:fixed; inset:0;
    background:rgba(15,23,42,.72);
    backdrop-filter:blur(6px); -webkit-backdrop-filter:blur(6px);
    z-index:1000; align-items:center; justify-content:center; padding:1rem;
}
.ent-modal-overlay.show { display:flex; animation:ent-overlay-in .18s ease; }

.ent-modal {
    background:var(--e-surf); border-radius:16px; width:100%; max-width:720px;
    box-shadow:0 24px 60px rgba(0,0,0,.35), 0 0 0 1px rgba(99,102,241,.18);
    display:flex; flex-direction:column; max-height:88vh; overflow:hidden;
    animation:ent-modal-in .22s cubic-bezier(.34,1.56,.64,1);
}
.ent-modal > form {
    display:flex; flex-direction:column; flex:1; min-height:0; overflow:hidden;
}

/* Header coloré indigo */
.ent-modal-header {
    display:flex; align-items:center; justify-content:space-between;
    padding:0; flex-shrink:0;
    background:linear-gradient(135deg,#312e81 0%,#4338ca 60%,#1d4ed8 100%);
    position:relative; overflow:hidden;
}
.ent-modal-header::before {
    content:''; position:absolute; top:-60%; right:-10%;
    width:200px; height:200px;
    background:radial-gradient(circle,rgba(20,184,166,.2) 0%,transparent 70%);
    border-radius:50%; pointer-events:none;
}
.ent-modal-header-inner {
    flex:1; display:flex; align-items:center; gap:.875rem;
    padding:1.25rem 1.375rem; position:relative;
}
.ent-modal-icon {
    width:42px; height:42px; border-radius:11px; display:flex;
    align-items:center; justify-content:center; flex-shrink:0;
    background:rgba(255,255,255,.15); color:#fff;
    backdrop-filter:blur(4px);
}
.ent-modal-icon svg { width:20px; height:20px; stroke:#fff; }
.ent-modal-header h2 {
    font-family:'Syne',sans-serif; font-size:1.0625rem; font-weight:700;
    color:#fff; margin:0; line-height:1.3;
}
.ent-modal-header p { font-size:.8125rem; color:rgba(255,255,255,.65); margin:.125rem 0 0; }
.ent-modal-close {
    width:36px; height:36px; border-radius:10px; border:none;
    background:rgba(255,255,255,.1); cursor:pointer; display:flex;
    align-items:center; justify-content:center;
    color:rgba(255,255,255,.7); margin-right:1rem; flex-shrink:0;
    transition:background .15s,color .15s; position:relative;
}
.ent-modal-close:hover { background:rgba(255,255,255,.22); color:#fff; }
.ent-modal-close svg { width:16px; height:16px; stroke:currentColor; }

/* Body scrollable */
.ent-modal-body {
    padding:1.5rem 1.75rem; overflow-y:auto; flex:1; min-height:0;
    background:var(--e-surf);
}
.ent-modal-body::-webkit-scrollbar { width:4px; }
.ent-modal-body::-webkit-scrollbar-track { background:transparent; }
.ent-modal-body::-webkit-scrollbar-thumb { background:var(--e-bdr); border-radius:2px; }

/* Form sections */
.ent-form-section {
    margin-bottom:1.5rem; padding-bottom:1.5rem;
    border-bottom:1px solid var(--e-bdr2);
}
.ent-form-section:last-child { margin-bottom:0; padding-bottom:0; border-bottom:none; }
.ent-form-section-title { display:flex; align-items:center; gap:.625rem; margin-bottom:1rem; }
.ent-form-section-icon {
    width:32px; height:32px; background:var(--e-ind-l);
    border-radius:8px; display:flex; align-items:center; justify-content:center;
    color:var(--e-ind);
}
.ent-form-section-icon svg { width:16px; height:16px; }
.ent-form-section-icon.accent-teal  { background:var(--e-teal-l); color:var(--e-teal-d); }
.ent-form-section-icon.accent-green { background:var(--e-emer-l); color:var(--e-emer); }
.ent-form-section-title h3 {
    font-size:.8125rem; font-weight:700; color:var(--e-text);
    margin:0; text-transform:uppercase; letter-spacing:.3px;
}

/* Form grid */
.ent-form-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:.875rem; }
.ent-form-group { margin-bottom:0; }
.ent-form-group.full { grid-column:1 / -1; }
.ent-form-label {
    display:block; font-size:.6875rem; font-weight:700;
    color:var(--e-text2); text-transform:uppercase; letter-spacing:.4px; margin-bottom:.375rem;
}
.ent-form-label.required::after { content:'*'; color:var(--e-ind); margin-left:.25rem; font-size:.75rem; }
.ent-form-input {
    width:100%; padding:.5625rem .875rem; border:1.5px solid var(--e-bdr);
    border-radius:var(--e-r); background:var(--e-bg); color:var(--e-text);
    font-family:'DM Sans',sans-serif; font-size:.8125rem; transition:all .2s;
    box-sizing:border-box; appearance:none; -webkit-appearance:none;
}
.ent-form-input:hover { border-color:rgba(99,102,241,.3); }
.ent-form-input:focus { outline:none; border-color:var(--e-ind); background:var(--e-surf); box-shadow:0 0 0 3px rgba(99,102,241,.12); }
.dark .ent-form-input:hover { border-color:rgba(99,102,241,.2); }
.dark .ent-form-input:focus { background:var(--e-surf); }
.ent-form-input::placeholder { color:var(--e-text3); }
textarea.ent-form-input { resize:vertical; min-height:72px; line-height:1.5; }
.ent-form-input.error { border-color:var(--e-red); box-shadow:0 0 0 3px rgba(239,68,68,.1); }
.ent-form-error { font-size:.6875rem; color:var(--e-red); margin-top:.25rem; font-weight:500; }

/* Status selector */
.ent-status-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:.75rem; }
.ent-status-option {
    position:relative; display:flex; align-items:center; gap:.875rem;
    padding:1rem 1.125rem; background:var(--e-bg);
    border:2px solid var(--e-bdr); border-radius:var(--e-rl);
    cursor:pointer; transition:all .25s cubic-bezier(.4,0,.2,1);
}
.ent-status-option:hover { border-color:rgba(99,102,241,.3); }
.ent-status-option.is-active.selected  { border-color:var(--e-teal-d); background:var(--e-teal-l); }
.ent-status-option.is-inactive.selected{ border-color:var(--e-red);   background:var(--e-red-l); }
.ent-status-icon {
    width:40px; height:40px; border-radius:var(--e-r);
    display:flex; align-items:center; justify-content:center; flex-shrink:0; transition:all .25s;
}
.ent-status-icon svg { width:20px; height:20px; }
.ent-status-option.is-active  .ent-status-icon { background:var(--e-teal-l);  color:var(--e-teal-d); }
.ent-status-option.is-active.selected  .ent-status-icon { background:var(--e-teal-d); color:#fff; }
.ent-status-option.is-inactive .ent-status-icon{ background:var(--e-red-l);   color:var(--e-red); }
.ent-status-option.is-inactive.selected .ent-status-icon { background:var(--e-red); color:#fff; }
.ent-status-label { font-size:.875rem; font-weight:600; color:var(--e-text); }
.ent-status-desc  { font-size:.6875rem; color:var(--e-text2); margin-top:.0625rem; }
.ent-status-check {
    width:22px; height:22px; border-radius:50%;
    display:flex; align-items:center; justify-content:center;
    margin-left:auto; flex-shrink:0; opacity:0; transform:scale(.5);
    transition:all .25s cubic-bezier(.34,1.56,.64,1);
}
.ent-status-check svg { width:12px; height:12px; color:#fff; }
.ent-status-option.selected .ent-status-check { opacity:1; transform:scale(1); }
.ent-status-option.is-active.selected  .ent-status-check { background:var(--e-teal-d); }
.ent-status-option.is-inactive.selected .ent-status-check { background:var(--e-red); }

/* Modal footer sticky */
.ent-modal-footer {
    padding:1rem 1.375rem; border-top:1px solid var(--e-bdr);
    display:flex; justify-content:flex-end; gap:.625rem;
    background:var(--e-bg); flex-shrink:0;
}
.ent-btn-cancel {
    padding:.625rem 1.25rem; background:var(--e-bg);
    border:1.5px solid var(--e-bdr); border-radius:10px;
    font-family:'DM Sans',sans-serif; font-size:.875rem; font-weight:600;
    color:var(--e-text2); cursor:pointer; transition:border-color .15s,color .15s;
    display:inline-flex; align-items:center; gap:.375rem;
}
.ent-btn-cancel:hover { border-color:var(--e-ind); color:var(--e-ind); }
.ent-btn-cancel svg { width:14px; height:14px; }
.ent-btn-submit {
    padding:.625rem 1.375rem; border:none; border-radius:10px;
    font-family:'DM Sans',sans-serif; font-size:.875rem; font-weight:700;
    color:#fff; cursor:pointer;
    background:linear-gradient(135deg,#4338ca,#6366f1);
    box-shadow:0 2px 8px rgba(99,102,241,.3); transition:opacity .15s,box-shadow .15s;
    display:inline-flex; align-items:center; gap:.375rem;
}
.ent-btn-submit:hover { opacity:.92; box-shadow:0 4px 14px rgba(99,102,241,.4); }
.ent-btn-submit:disabled { opacity:.6; cursor:wait; }
.ent-btn-submit svg { width:14px; height:14px; }

/* Buttons in header area */
.ent-btn-primary {
    display:inline-flex; align-items:center; gap:.5rem; padding:.625rem 1.25rem;
    border-radius:var(--e-r); font-family:'DM Sans',sans-serif;
    font-size:.8125rem; font-weight:600; cursor:pointer; border:none;
    background:linear-gradient(135deg,#4338ca,#6366f1); color:#fff;
    box-shadow:0 2px 8px rgba(99,102,241,.3); transition:all .2s; text-decoration:none;
}
.ent-btn-primary:hover { transform:translateY(-1px); box-shadow:0 6px 16px rgba(99,102,241,.4); color:#fff; }
.ent-btn-primary svg { width:16px; height:16px; }
.ent-btn-outline {
    display:inline-flex; align-items:center; gap:.5rem; padding:.625rem 1.125rem;
    border-radius:var(--e-r); font-family:'DM Sans',sans-serif;
    font-size:.8125rem; font-weight:600; cursor:pointer;
    background:var(--e-surf); color:var(--e-text2); border:1.5px solid var(--e-bdr);
    transition:all .2s; text-decoration:none;
}
.ent-btn-outline:hover { color:var(--e-text); border-color:var(--e-text3); }
.ent-btn-outline svg { width:16px; height:16px; }

/* Spin */
@keyframes ent-spin { from{transform:rotate(0deg)} to{transform:rotate(360deg)} }
.ent-spin { animation:ent-spin .8s linear infinite; }

/* ══════════════════════════════════
   RESPONSIVE
══════════════════════════════════ */
@media(max-width:1100px){ .ent-stats{grid-template-columns:repeat(2,1fr)} }
@media(max-width:768px){
    .ent-hero-inner { flex-direction:column; align-items:flex-start; }
    .ent-hero-kpis  { width:100%; justify-content:space-around; }
    .ent-stats{grid-template-columns:1fr 1fr}
    .ent-toolbar{flex-direction:column;align-items:stretch}
    .ent-search{min-width:auto}
    .ent-grid{grid-template-columns:1fr}
    .ent-form-grid{grid-template-columns:1fr}
    .ent-status-grid{grid-template-columns:1fr}
}
@media(max-width:480px){ .ent-stats{grid-template-columns:1fr} }
</style>
@endsection

@section('content')
<div class="ent-page">

    {{-- ══ Hero Banner ══ --}}
    <div class="ent-hero">
        <div class="ent-hero-bg">
            <div class="ent-hero-inner">
                <div class="ent-hero-left">
                    <h1>Gestion des Entreprises</h1>
                    <p class="ent-hero-sub">
                        <span class="ent-live-dot"></span>
                        Portefeuille des entreprises partenaires
                    </p>
                </div>
                <div class="ent-hero-kpis">
                    <div class="ent-hero-kpi">
                        <div class="ent-hero-kpi-val">{{ $entreprises->count() }}</div>
                        <div class="ent-hero-kpi-lbl">Total</div>
                    </div>
                    <div class="ent-hero-kpi">
                        <div class="ent-hero-kpi-val">{{ $entreprises->where('is_active', true)->count() }}</div>
                        <div class="ent-hero-kpi-lbl">Actives</div>
                    </div>
                    <div class="ent-hero-kpi">
                        <div class="ent-hero-kpi-val">{{ number_format($entreprises->sum('nombre_employes') ?? 0) }}</div>
                        <div class="ent-hero-kpi-lbl">Employ&eacute;s</div>
                    </div>
                </div>
                <div class="ent-hero-actions">
                    <button type="button" class="ent-btn-hero-outline" onclick="window.print()">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Exporter
                    </button>
                    <button type="button" class="ent-btn-hero" onclick="openCreateModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Nouvelle entreprise
                    </button>
                </div>
            </div>
        </div>
        <div class="ent-hero-accent"></div>
    </div>

    {{-- Stats --}}
    <div class="ent-stats">
        <div class="ent-stat s-blue">
            <div class="ent-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/></svg>
            </div>
            <div class="ent-stat-body">
                <div class="ent-stat-val">{{ $entreprises->count() }}</div>
                <div class="ent-stat-label">Total</div>
            </div>
        </div>
        <div class="ent-stat s-green">
            <div class="ent-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div class="ent-stat-body">
                <div class="ent-stat-val">{{ $entreprises->where('is_active', true)->count() }}</div>
                <div class="ent-stat-label">Actives</div>
            </div>
        </div>
        <div class="ent-stat s-red">
            <div class="ent-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            </div>
            <div class="ent-stat-body">
                <div class="ent-stat-val">{{ $entreprises->where('is_active', false)->count() }}</div>
                <div class="ent-stat-label">Inactives</div>
            </div>
        </div>
        <div class="ent-stat s-amber">
            <div class="ent-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div class="ent-stat-body">
                <div class="ent-stat-val">{{ number_format($entreprises->sum('nombre_employes') ?? 0) }}</div>
                <div class="ent-stat-label">Employ&eacute;s</div>
            </div>
        </div>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="ent-alert ent-alert-success">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif
    @if(session('error'))
    <div class="ent-alert ent-alert-error">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    {{-- Toolbar --}}
    <div class="ent-toolbar">
        <div class="ent-search">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            <input type="search" placeholder="Rechercher une entreprise..." id="searchInput">
        </div>
        <div class="ent-filters">
            <button class="ent-filter-btn active" data-filter="all" onclick="filterCompanies('all')">
                Toutes <span class="ent-filter-count">{{ $entreprises->count() }}</span>
            </button>
            <button class="ent-filter-btn" data-filter="active" onclick="filterCompanies('active')">
                Actives <span class="ent-filter-count">{{ $entreprises->where('is_active', true)->count() }}</span>
            </button>
            <button class="ent-filter-btn" data-filter="inactive" onclick="filterCompanies('inactive')">
                Inactives <span class="ent-filter-count">{{ $entreprises->where('is_active', false)->count() }}</span>
            </button>
        </div>
        <div class="ent-view-toggle">
            <button type="button" class="ent-view-btn active" id="gridViewBtn" onclick="switchView('grid')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            </button>
            <button type="button" class="ent-view-btn" id="tableViewBtn" onclick="switchView('table')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
            </button>
        </div>
    </div>

    {{-- Grid View --}}
    <div class="ent-grid" id="companiesGrid">
        @forelse($entreprises as $entreprise)
        <div class="ent-card" data-status="{{ $entreprise->is_active ? 'active' : 'inactive' }}" data-name="{{ strtolower($entreprise->nom) }}" data-email="{{ strtolower($entreprise->email) }}">
            <div class="ent-card-top">
                @if($entreprise->logo)
                <div class="ent-card-logo"><img src="{{ asset($entreprise->logo) }}" alt="{{ $entreprise->nom }}"></div>
                @else
                <div class="ent-card-logo-ph">{{ strtoupper(substr($entreprise->nom, 0, 2)) }}</div>
                @endif
                <div class="ent-card-identity">
                    <h3 class="ent-card-name">{{ $entreprise->nom }}</h3>
                    @if($entreprise->sigle)
                    <div class="ent-card-sigle">{{ $entreprise->sigle }}</div>
                    @endif
                </div>
                <span class="ent-badge {{ $entreprise->is_active ? 'ent-badge-active' : 'ent-badge-inactive' }}">
                    <span class="ent-badge-dot"></span>
                    {{ $entreprise->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <div class="ent-card-details">
                <div class="ent-card-row">
                    <div class="ent-card-row-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </div>
                    <span class="ent-card-row-value">{{ $entreprise->email }}</span>
                </div>
                @if($entreprise->telephone)
                <div class="ent-card-row">
                    <div class="ent-card-row-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    </div>
                    <span class="ent-card-row-value">{{ $entreprise->telephone }}</span>
                </div>
                @endif
                <div class="ent-card-row">
                    <div class="ent-card-row-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    <span class="ent-card-row-value">{{ $entreprise->ville ?? $entreprise->pays ?? 'Non sp&eacute;cifi&eacute;' }}</span>
                </div>
            </div>
            <div class="ent-card-footer">
                <a href="{{ route('admin.entreprises.show', $entreprise->id) }}" class="ent-card-btn ent-card-btn-view">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    Voir
                </a>
                <button type="button" onclick="openEditModal({{ $entreprise->id }})" class="ent-card-btn ent-card-btn-edit">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Modifier
                </button>
                <form action="{{ route('admin.entreprises.destroy', $entreprise->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer cette entreprise ?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="ent-card-btn ent-card-btn-delete">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="ent-empty">
            <div class="ent-empty-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <h3>Aucune entreprise</h3>
            <p>Commencez par cr&eacute;er votre premi&egrave;re entreprise</p>
            <button type="button" class="ent-btn-primary" onclick="openCreateModal()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Cr&eacute;er une entreprise
            </button>
        </div>
        @endforelse
    </div>

    {{-- Table View --}}
    <div class="ent-table-wrap" id="companiesTable" style="display:none;">
        <table class="ent-table">
            <thead>
                <tr>
                    <th>Entreprise</th>
                    <th>Contact</th>
                    <th>Localisation</th>
                    <th>Employ&eacute;s</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($entreprises as $entreprise)
                <tr data-status="{{ $entreprise->is_active ? 'active' : 'inactive' }}" data-name="{{ strtolower($entreprise->nom) }}" data-email="{{ strtolower($entreprise->email) }}">
                    <td>
                        <div class="ent-table-company">
                            @if($entreprise->logo)
                            <div class="ent-card-logo" style="width:36px;height:36px;"><img src="{{ asset($entreprise->logo) }}" alt="{{ $entreprise->nom }}"></div>
                            @else
                            <div class="ent-card-logo-ph" style="width:36px;height:36px;font-size:.75rem;">{{ strtoupper(substr($entreprise->nom, 0, 2)) }}</div>
                            @endif
                            <div class="ent-table-company-info">
                                <span class="ent-table-company-name">{{ $entreprise->nom }}</span>
                                @if($entreprise->sigle)<span class="ent-table-company-sigle">{{ $entreprise->sigle }}</span>@endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <div>{{ $entreprise->email }}</div>
                        @if($entreprise->telephone)<small style="color:var(--e-text3);">{{ $entreprise->telephone }}</small>@endif
                    </td>
                    <td>{{ $entreprise->ville ?? $entreprise->pays ?? '-' }}</td>
                    <td><strong>{{ $entreprise->nombre_employes ?? '-' }}</strong></td>
                    <td>
                        <span class="ent-badge {{ $entreprise->is_active ? 'ent-badge-active' : 'ent-badge-inactive' }}">
                            <span class="ent-badge-dot"></span>
                            {{ $entreprise->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="ent-table-actions">
                            <a href="{{ route('admin.entreprises.show', $entreprise->id) }}" class="ent-table-btn ent-card-btn-view" title="Voir">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>
                            <button type="button" onclick="openEditModal({{ $entreprise->id }})" class="ent-table-btn ent-card-btn-edit" title="Modifier">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                            <form action="{{ route('admin.entreprises.destroy', $entreprise->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer cette entreprise ?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="ent-table-btn ent-card-btn-delete" title="Supprimer">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6"><div class="ent-empty"><h3>Aucune entreprise</h3><p>Commencez par cr&eacute;er votre premi&egrave;re entreprise</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

{{-- ══ Modal Cr&eacute;er / Modifier ══ --}}
<div class="ent-modal-overlay" id="entrepriseModal">
    <div class="ent-modal">
        <div class="ent-modal-header">
            <div class="ent-modal-header-inner">
                <div class="ent-modal-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div>
                    <h2 id="modalTitle">Nouvelle Entreprise</h2>
                    <p id="modalSubtitle">Remplissez les informations de l'entreprise</p>
                </div>
            </div>
            <button type="button" class="ent-modal-close" onclick="closeModal()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <form id="entrepriseForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div class="ent-modal-body">
                {{-- Informations g&eacute;n&eacute;rales --}}
                <div class="ent-form-section">
                    <div class="ent-form-section-title">
                        <div class="ent-form-section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/></svg>
                        </div>
                        <h3>Informations g&eacute;n&eacute;rales</h3>
                    </div>
                    <div class="ent-form-grid">
                        <div class="ent-form-group">
                            <label class="ent-form-label required">Nom de l'entreprise</label>
                            <input type="text" name="nom" id="nom" class="ent-form-input" placeholder="Nom de l'entreprise" required>
                        </div>
                        <div class="ent-form-group">
                            <label class="ent-form-label">Sigle</label>
                            <input type="text" name="sigle" id="sigle" class="ent-form-input" placeholder="Ex : ABC">
                        </div>
                        <div class="ent-form-group">
                            <label class="ent-form-label required">Email</label>
                            <input type="email" name="email" id="email" class="ent-form-input" placeholder="contact@entreprise.com" required>
                        </div>
                        <div class="ent-form-group">
                            <label class="ent-form-label">T&eacute;l&eacute;phone</label>
                            <input type="text" name="telephone" id="telephone" class="ent-form-input" placeholder="+225 XX XX XX XX">
                        </div>
                    </div>
                </div>

                {{-- Adresse --}}
                <div class="ent-form-section">
                    <div class="ent-form-section-title">
                        <div class="ent-form-section-icon accent-teal">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        </div>
                        <h3>Adresse</h3>
                    </div>
                    <div class="ent-form-grid">
                        <div class="ent-form-group full">
                            <label class="ent-form-label">Adresse</label>
                            <input type="text" name="adresse" id="adresse" class="ent-form-input" placeholder="Adresse compl&egrave;te">
                        </div>
                        <div class="ent-form-group">
                            <label class="ent-form-label">Ville</label>
                            <input type="text" name="ville" id="ville" class="ent-form-input" placeholder="Ville">
                        </div>
                        <div class="ent-form-group">
                            <label class="ent-form-label">Pays</label>
                            <input type="text" name="pays" id="pays" class="ent-form-input" placeholder="Pays">
                        </div>
                    </div>
                </div>

                {{-- Statut --}}
                <div class="ent-form-section">
                    <div class="ent-form-section-title">
                        <div class="ent-form-section-icon accent-green">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        </div>
                        <h3>Statut de l'entreprise</h3>
                    </div>
                    <input type="hidden" name="is_active" id="is_active" value="1">
                    <div class="ent-status-grid">
                        <div class="ent-status-option is-active selected" data-status="1" onclick="selectStatus(1)">
                            <div class="ent-status-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            </div>
                            <div>
                                <div class="ent-status-label">Active</div>
                                <div class="ent-status-desc">Visible et op&eacute;rationnelle</div>
                            </div>
                            <div class="ent-status-check">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                        </div>
                        <div class="ent-status-option is-inactive" data-status="0" onclick="selectStatus(0)">
                            <div class="ent-status-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                            </div>
                            <div>
                                <div class="ent-status-label">Inactive</div>
                                <div class="ent-status-desc">Suspendue temporairement</div>
                            </div>
                            <div class="ent-status-check">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ent-modal-footer">
                <button type="button" class="ent-btn-cancel" onclick="closeModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Annuler
                </button>
                <button type="submit" class="ent-btn-submit">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function switchView(view) {
    const gridView = document.getElementById('companiesGrid');
    const tableView = document.getElementById('companiesTable');
    const gridBtn = document.getElementById('gridViewBtn');
    const tableBtn = document.getElementById('tableViewBtn');
    if (view === 'grid') {
        gridView.style.display = 'grid';
        tableView.style.display = 'none';
        gridBtn.classList.add('active');
        tableBtn.classList.remove('active');
    } else {
        gridView.style.display = 'none';
        tableView.style.display = 'block';
        gridBtn.classList.remove('active');
        tableBtn.classList.add('active');
    }
}

function filterCompanies(filter) {
    const cards = document.querySelectorAll('.ent-card');
    const rows = document.querySelectorAll('.ent-table tbody tr[data-status]');
    const filterBtns = document.querySelectorAll('.ent-filter-btn');
    filterBtns.forEach(btn => btn.classList.remove('active'));
    document.querySelector(`[data-filter="${filter}"]`).classList.add('active');
    [...cards, ...rows].forEach(item => {
        item.style.display = (filter === 'all' || item.dataset.status === filter) ? '' : 'none';
    });
}

document.getElementById('searchInput').addEventListener('input', function(e) {
    const search = e.target.value.toLowerCase();
    const cards = document.querySelectorAll('.ent-card');
    const rows = document.querySelectorAll('.ent-table tbody tr[data-status]');
    [...cards, ...rows].forEach(item => {
        const name = item.dataset.name || '';
        const email = item.dataset.email || '';
        item.style.display = (name.includes(search) || email.includes(search)) ? '' : 'none';
    });
});

function selectStatus(status) {
    document.getElementById('is_active').value = status;
    document.querySelectorAll('.ent-status-option').forEach(card => card.classList.remove('selected'));
    const selected = document.querySelector(`.ent-status-option[data-status="${status}"]`);
    if (selected) selected.classList.add('selected');
}

function openCreateModal() {
    document.getElementById('modalTitle').textContent = 'Nouvelle Entreprise';
    document.getElementById('modalSubtitle').textContent = 'Remplissez les informations';
    document.getElementById('entrepriseForm').action = '{{ route("admin.entreprises.store") }}';
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('entrepriseForm').reset();
    selectStatus(1);
    document.getElementById('entrepriseModal').classList.add('show');
}

function openEditModal(id) {
    document.getElementById('modalTitle').textContent = 'Modifier l\'entreprise';
    document.getElementById('modalSubtitle').textContent = 'Modifiez les informations';
    document.getElementById('entrepriseForm').action = `/admin/entreprises/${id}`;
    document.getElementById('formMethod').value = 'PUT';
    fetch(`/admin/entreprises/${id}/edit`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(r => r.json())
    .then(data => {
        document.getElementById('nom').value = data.nom || '';
        document.getElementById('sigle').value = data.sigle || '';
        document.getElementById('email').value = data.email || '';
        document.getElementById('telephone').value = data.telephone || '';
        document.getElementById('adresse').value = data.adresse || '';
        document.getElementById('ville').value = data.ville || '';
        document.getElementById('pays').value = data.pays || '';
        selectStatus(data.is_active ? 1 : 0);
    })
    .catch(() => alert('Erreur lors du chargement des données'));
    document.getElementById('entrepriseModal').classList.add('show');
}

function closeModal() {
    document.getElementById('entrepriseModal').classList.remove('show');
    clearValidationErrors();
}

function clearValidationErrors() {
    document.querySelectorAll('.ent-form-input.error').forEach(i => i.classList.remove('error'));
    document.querySelectorAll('.ent-form-error').forEach(m => m.remove());
}

function showValidationErrors(errors) {
    clearValidationErrors();
    Object.keys(errors).forEach(field => {
        const input = document.getElementById(field);
        if (input) {
            input.classList.add('error');
            const div = document.createElement('div');
            div.className = 'ent-form-error';
            div.textContent = errors[field][0];
            input.parentNode.appendChild(div);
        }
    });
}

document.getElementById('entrepriseForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    const formData = new FormData(form);
    const submitBtn = form.querySelector('.ent-btn-submit');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<svg class="ent-spin" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" stroke-dasharray="32" stroke-dashoffset="12"/></svg> Enregistrement...';
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (!response.ok) return response.json().then(data => { throw { status: response.status, data }; });
        return response.json();
    })
    .then(data => { if (data.success !== false) window.location.reload(); })
    .catch(error => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
        if (error.status === 422 && error.data.errors) showValidationErrors(error.data.errors);
        else alert(error.data?.message || 'Une erreur est survenue');
    });
});

document.getElementById('entrepriseModal').addEventListener('click', function(e) { if (e.target === this) closeModal(); });
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeModal(); });
</script>
@endsection
