@extends('layouts.app')

@section('title', 'Bulletins de Paie')
@section('page-title', 'Bulletins de Paie')
@section('page-subtitle', 'Gestion des fiches de paie du personnel')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
    <polyline points="14 2 14 8 20 8"/>
    <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
</svg>
@endsection

@section('styles')
<style>
/* ═══════════════════════════════════════════════════════════════
   BULLETINS DE PAIE — Indigo × Teal Design System
   Syne (display) · DM Sans (body) · DM Mono (data)
   ═══════════════════════════════════════════════════════════════ */

:root {
    --bp-ind:     #6366f1;
    --bp-ind-d:   #4338ca;
    --bp-ind-900: #312e81;
    --bp-ind-l:   rgba(99,102,241,.10);
    --bp-ind-l2:  rgba(99,102,241,.06);
    --bp-teal:    #14b8a6;
    --bp-teal-d:  #0d9488;
    --bp-teal-l:  rgba(20,184,166,.10);
    --bp-emer:    #10b981;
    --bp-emer-l:  rgba(16,185,129,.10);
    --bp-red:     #ef4444;
    --bp-red-l:   rgba(239,68,68,.10);
    --bp-amb:     #f59e0b;
    --bp-amb-l:   rgba(245,158,11,.10);
    --bp-bg:      #f1f5f9;
    --bp-surf:    #ffffff;
    --bp-bdr:     #e2e8f0;
    --bp-bdr2:    #cbd5e1;
    --bp-txt:     #0f172a;
    --bp-txt2:    #475569;
    --bp-txt3:    #94a3b8;
    --bp-r:       14px;
    --bp-sh:      0 1px 3px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04);
    --bp-sh-md:   0 4px 16px rgba(0,0,0,.08);
    --bp-sh-lg:   0 8px 32px rgba(0,0,0,.12);
}

/* ── Page ── */
.bp { font-family:'DM Sans',sans-serif; color:var(--bp-txt); animation:bp-in .4s cubic-bezier(.16,1,.3,1); }
@keyframes bp-in { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:translateY(0)} }

/* ═══════════════════════ HERO ═══════════════════════ */
.bp-hero {
    position:relative; overflow:hidden;
    background:linear-gradient(135deg,#312e81 0%,#4338ca 40%,#0d9488 100%);
    border-radius:20px; padding:40px 44px 36px;
    margin-bottom:24px;
}
.bp-hero::before {
    content:''; position:absolute; top:-80px; right:-50px;
    width:360px; height:360px; border-radius:50%;
    background:radial-gradient(circle,rgba(255,255,255,.07) 0%,transparent 70%);
    pointer-events:none;
}
.bp-hero::after {
    content:''; position:absolute; bottom:-70px; left:30%;
    width:260px; height:260px; border-radius:50%;
    background:radial-gradient(circle,rgba(20,184,166,.13) 0%,transparent 70%);
    pointer-events:none;
}
.bp-hero-content { position:relative; z-index:1; }

.bp-hero-meta {
    display:flex; align-items:center; gap:8px;
    font-size:.65rem; font-weight:700; letter-spacing:.12em; text-transform:uppercase;
    color:rgba(255,255,255,.55); margin-bottom:16px;
}
.bp-live-dot {
    width:8px; height:8px; border-radius:50%;
    background:#34d399; flex-shrink:0;
    box-shadow:0 0 0 3px rgba(52,211,153,.25);
    animation:bp-dot 2s infinite;
}
@keyframes bp-dot {
    0%,100%{box-shadow:0 0 0 3px rgba(52,211,153,.25)}
    50%{box-shadow:0 0 0 7px rgba(52,211,153,.07)}
}

.bp-hero-row { display:flex; align-items:flex-end; justify-content:space-between; gap:24px; flex-wrap:wrap; }
.bp-hero-title {
    font-family:'Syne',sans-serif; font-size:2.2rem; font-weight:800;
    color:#fff; letter-spacing:-.04em; margin:0 0 8px; line-height:1.1;
}
.bp-hero-title span { color:#5eead4; }
.bp-hero-sub { font-size:.8125rem; color:rgba(255,255,255,.5); margin:0; line-height:1.6; }

.bp-hero-actions { display:flex; align-items:center; gap:10px; flex-shrink:0; }
.bp-btn-hero-outline {
    display:inline-flex; align-items:center; gap:7px;
    padding:9px 18px; border-radius:10px;
    border:1.5px solid rgba(255,255,255,.25);
    background:rgba(255,255,255,.08); backdrop-filter:blur(8px);
    color:rgba(255,255,255,.85); font-size:.8rem; font-weight:600;
    text-decoration:none; cursor:pointer;
    transition:all .2s; white-space:nowrap; font-family:'DM Sans',sans-serif;
}
.bp-btn-hero-outline svg { width:15px; height:15px; flex-shrink:0; }
.bp-btn-hero-outline:hover { background:rgba(255,255,255,.16); border-color:rgba(255,255,255,.4); color:#fff; }

.bp-btn-hero-fill {
    display:inline-flex; align-items:center; gap:7px;
    padding:9px 20px; border-radius:10px;
    background:rgba(255,255,255,.95);
    border:none; cursor:pointer;
    color:var(--bp-ind-d); font-size:.8rem; font-weight:700;
    text-decoration:none;
    transition:all .2s; white-space:nowrap; font-family:'DM Sans',sans-serif;
    box-shadow:0 4px 16px rgba(0,0,0,.15);
}
.bp-btn-hero-fill svg { width:15px; height:15px; flex-shrink:0; }
.bp-btn-hero-fill:hover { background:#fff; transform:translateY(-1px); box-shadow:0 6px 20px rgba(0,0,0,.2); color:var(--bp-ind-900); }

.bp-hero-kpis { display:flex; gap:10px; flex-wrap:wrap; margin-top:28px; padding-top:24px; border-top:1px solid rgba(255,255,255,.1); }
.bp-hero-kpi {
    background:rgba(255,255,255,.09); backdrop-filter:blur(10px);
    border:1px solid rgba(255,255,255,.14); border-radius:14px;
    padding:13px 18px; min-width:110px; flex:1;
    transition:background .2s; cursor:default;
}
.bp-hero-kpi:hover { background:rgba(255,255,255,.14); }
.bp-hero-kpi-lbl { font-size:.6rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:rgba(255,255,255,.45); margin-bottom:7px; }
.bp-hero-kpi-val { font-family:'Syne',sans-serif; font-size:1.7rem; font-weight:700; color:#fff; line-height:1; letter-spacing:-.04em; }

/* ═══════════════════════ STAT CARDS ═══════════════════════ */
.bp-stats-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:22px; }
.bp-stat {
    background:var(--bp-surf); border:1px solid var(--bp-bdr);
    border-radius:var(--bp-r); padding:20px 22px;
    display:flex; align-items:center; gap:16px;
    position:relative; overflow:hidden;
    box-shadow:var(--bp-sh);
    transition:all .25s cubic-bezier(.16,1,.3,1); cursor:default;
    animation:bp-stat-in .4s cubic-bezier(.16,1,.3,1) backwards;
}
.bp-stat:nth-child(1){animation-delay:.04s}
.bp-stat:nth-child(2){animation-delay:.08s}
.bp-stat:nth-child(3){animation-delay:.12s}
@keyframes bp-stat-in { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }

/* orb top-right */
.bp-stat::before {
    content:''; position:absolute; top:-30px; right:-20px;
    width:110px; height:110px; border-radius:50%;
    background:radial-gradient(circle,var(--bp-sc-orb,rgba(99,102,241,.07)) 0%,transparent 70%);
    pointer-events:none;
}
/* bottom bar */
.bp-stat::after {
    content:''; position:absolute; bottom:0; left:0; right:0; height:3px;
    background:linear-gradient(90deg,var(--bp-sc-c,var(--bp-ind)),transparent);
    transform:scaleX(0); transform-origin:left;
    transition:transform .3s cubic-bezier(.16,1,.3,1);
}
.bp-stat:hover { border-color:var(--bp-sc-c,var(--bp-ind)); transform:translateY(-3px); box-shadow:var(--bp-sh-md); }
.bp-stat:hover::after { transform:scaleX(1); }
.bp-stat:hover .bp-stat-icon { transform:scale(1.08) rotate(-5deg); }

.bp-stat-c-ind  { --bp-sc-c:var(--bp-ind);  --bp-sc-orb:rgba(99,102,241,.07); }
.bp-stat-c-teal { --bp-sc-c:var(--bp-teal); --bp-sc-orb:rgba(20,184,166,.07); }
.bp-stat-c-emer { --bp-sc-c:var(--bp-emer); --bp-sc-orb:rgba(16,185,129,.07); }

.bp-stat-icon {
    width:52px; height:52px; border-radius:14px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center;
    background:var(--bp-sc-orb,var(--bp-ind-l));
    color:var(--bp-sc-c,var(--bp-ind));
    transition:transform .2s; position:relative; z-index:1;
}
.bp-stat-icon svg { width:24px; height:24px; }
.bp-stat-body { flex:1; min-width:0; position:relative; z-index:1; }
.bp-stat-lbl { font-size:.62rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:var(--bp-txt3); margin-bottom:4px; }
.bp-stat-val { font-family:'Syne',sans-serif; font-size:2rem; font-weight:700; color:var(--bp-txt); line-height:1; margin-bottom:5px; letter-spacing:-.03em; }
.bp-stat-sub { font-size:.72rem; color:var(--bp-txt3); font-weight:500; }

/* ═══════════════════════ TIMELINE ═══════════════════════ */
.bp-timeline-card {
    background:var(--bp-surf); border:1px solid var(--bp-bdr);
    border-radius:var(--bp-r); padding:18px 22px;
    box-shadow:var(--bp-sh); margin-bottom:16px;
}
.bp-tl-head {
    display:flex; align-items:center; justify-content:space-between;
    margin-bottom:16px;
}
.bp-tl-title {
    font-family:'Syne',sans-serif; font-size:.875rem; font-weight:700;
    color:var(--bp-txt); letter-spacing:-.01em;
    display:flex; align-items:center; gap:8px;
}
.bp-tl-title-dot { width:6px; height:6px; border-radius:50%; background:var(--bp-ind); }

.bp-year-select {
    font-family:'DM Mono',monospace; font-size:.8rem; font-weight:600;
    color:var(--bp-txt); background:var(--bp-bg);
    border:1.5px solid var(--bp-bdr); border-radius:9px;
    padding:6px 30px 6px 12px; cursor:pointer; appearance:none;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat:no-repeat; background-position:right 10px center;
    transition:border-color .2s;
}
.bp-year-select:focus { outline:none; border-color:var(--bp-ind); box-shadow:0 0 0 3px var(--bp-ind-l); }

.bp-month-grid { display:grid; grid-template-columns:repeat(12,1fr); gap:6px; }
.bp-month {
    display:flex; flex-direction:column; align-items:center; gap:4px;
    padding:10px 6px 8px;
    border-radius:10px; border:1.5px solid transparent;
    text-decoration:none; cursor:pointer;
    transition:all .2s cubic-bezier(.16,1,.3,1);
    position:relative;
}
.bp-month:hover { background:var(--bp-ind-l2); border-color:var(--bp-ind-l); }
.bp-month.active {
    background:linear-gradient(135deg,var(--bp-ind-d),var(--bp-ind));
    border-color:var(--bp-ind); box-shadow:0 4px 14px rgba(99,102,241,.3);
}
.bp-month.is-future { opacity:.45; pointer-events:none; }
.bp-month-name {
    font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em;
    color:var(--bp-txt2); transition:color .2s;
}
.bp-month.active .bp-month-name { color:#fff; }
.bp-month-count {
    font-family:'DM Mono',monospace; font-size:.6rem; font-weight:600;
    padding:1px 6px; border-radius:5px;
    background:var(--bp-ind-l); color:var(--bp-ind);
    min-width:18px; text-align:center;
    transition:all .2s;
}
.bp-month.active .bp-month-count { background:rgba(255,255,255,.2); color:#fff; }
.bp-month-dot {
    width:5px; height:5px; border-radius:50%;
    background:var(--bp-bdr2);
}
.bp-month.has-data .bp-month-dot { background:var(--bp-teal); }
.bp-month.active .bp-month-dot { display:none; }

/* Reset month filter link */
.bp-tl-reset {
    font-size:.72rem; font-weight:600; color:var(--bp-ind);
    text-decoration:none; padding:5px 12px;
    background:var(--bp-ind-l); border-radius:8px;
    transition:all .2s;
}
.bp-tl-reset:hover { background:var(--bp-ind); color:#fff; }

/* ═══════════════════════ FILTERS ═══════════════════════ */
.bp-filter-bar {
    background:var(--bp-surf); border:1px solid var(--bp-bdr);
    border-radius:var(--bp-r); padding:14px 18px;
    box-shadow:var(--bp-sh); margin-bottom:14px;
    display:flex; align-items:center; gap:12px; flex-wrap:wrap;
}
.bp-search-wrap {
    flex:1; min-width:220px;
    display:flex; align-items:center; gap:8px;
    background:var(--bp-bg); border:1.5px solid var(--bp-bdr);
    border-radius:10px; padding:0 14px; transition:border-color .2s;
}
.bp-search-wrap:focus-within { border-color:var(--bp-ind); box-shadow:0 0 0 3px var(--bp-ind-l); }
.bp-search-wrap svg { color:var(--bp-txt3); flex-shrink:0; }
.bp-search-input {
    flex:1; border:none; background:transparent; padding:9px 0;
    font-size:.83rem; color:var(--bp-txt); font-family:'DM Sans',sans-serif;
    outline:none;
}
.bp-search-input::placeholder { color:var(--bp-txt3); }
.bp-search-btn {
    padding:8px 18px; border-radius:9px;
    background:linear-gradient(135deg,var(--bp-ind-d),var(--bp-ind));
    border:none; cursor:pointer; color:#fff; font-size:.8rem; font-weight:600;
    font-family:'DM Sans',sans-serif; transition:all .2s; white-space:nowrap;
}
.bp-search-btn:hover { opacity:.9; transform:translateY(-1px); box-shadow:0 4px 12px rgba(99,102,241,.35); }

.bp-filter-tags { display:flex; gap:7px; flex-wrap:wrap; align-items:center; }
.bp-filter-tag {
    display:inline-flex; align-items:center; gap:5px;
    padding:4px 10px 4px 12px; border-radius:8px;
    background:var(--bp-ind-l); border:1px solid rgba(99,102,241,.2);
    font-size:.72rem; font-weight:600; color:var(--bp-ind);
}
.bp-filter-tag a { color:var(--bp-ind); text-decoration:none; display:flex; align-items:center; opacity:.7; transition:opacity .15s; }
.bp-filter-tag a:hover { opacity:1; }
.bp-filter-tag a svg { width:12px; height:12px; }
.bp-filter-clear { font-size:.72rem; font-weight:600; color:var(--bp-txt3); text-decoration:none; padding:4px 10px; border-radius:8px; transition:all .2s; }
.bp-filter-clear:hover { background:var(--bp-red-l); color:var(--bp-red); }

/* ═══════════════════════ LIST ═══════════════════════ */
.bp-list-card {
    background:var(--bp-surf); border:1px solid var(--bp-bdr);
    border-radius:var(--bp-r); box-shadow:var(--bp-sh); overflow:hidden;
}
.bp-list-head {
    display:flex; align-items:center; justify-content:space-between;
    padding:14px 20px; border-bottom:1px solid var(--bp-bdr);
}
.bp-list-title {
    font-family:'Syne',sans-serif; font-size:.875rem; font-weight:700;
    color:var(--bp-txt); letter-spacing:-.01em;
    display:flex; align-items:center; gap:10px;
}
.bp-list-count {
    display:inline-flex; align-items:center; justify-content:center;
    min-width:24px; height:20px; padding:0 7px;
    border-radius:6px; background:var(--bp-ind-l);
    font-size:.65rem; font-weight:700; color:var(--bp-ind);
    font-family:'DM Mono',monospace; letter-spacing:.02em;
}

/* Bulletin item */
.bp-item {
    display:flex; align-items:center; gap:14px;
    padding:14px 20px; border-bottom:1px solid var(--bp-bdr);
    transition:background .15s; position:relative;
    animation:bp-item-in .3s cubic-bezier(.16,1,.3,1) backwards;
}
@keyframes bp-item-in { from{opacity:0;transform:translateX(-6px)} to{opacity:1;transform:translateX(0)} }
.bp-item:last-child { border-bottom:none; }
.bp-item:hover { background:#fafbff; }
.bp-item:hover .bp-item-icon { transform:scale(1.05); }

.bp-item-icon {
    width:44px; height:44px; border-radius:12px; flex-shrink:0;
    background:linear-gradient(135deg,var(--bp-ind-l),rgba(99,102,241,.04));
    border:1.5px solid rgba(99,102,241,.15);
    display:flex; align-items:center; justify-content:center;
    color:var(--bp-ind); transition:transform .2s;
}
.bp-item-icon svg { width:20px; height:20px; }

.bp-item-main { flex:1; min-width:0; }
.bp-item-name {
    font-size:.875rem; font-weight:600; color:var(--bp-txt);
    white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
    line-height:1.3; margin-bottom:3px;
}
.bp-item-meta {
    display:flex; align-items:center; gap:8px; flex-wrap:wrap;
}
.bp-item-meta-dot { width:3px; height:3px; border-radius:50%; background:var(--bp-txt3); flex-shrink:0; }
.bp-item-meta span { font-size:.72rem; color:var(--bp-txt3); font-family:'DM Mono',monospace; white-space:nowrap; }

.bp-item-period {
    flex-shrink:0;
    display:flex; align-items:center; gap:6px;
}
.bp-period-badge {
    display:inline-flex; align-items:center; gap:5px;
    padding:4px 12px; border-radius:8px;
    background:linear-gradient(135deg,var(--bp-ind-l),var(--bp-teal-l));
    border:1px solid rgba(99,102,241,.15);
    font-size:.72rem; font-weight:700; color:var(--bp-ind-d);
    font-family:'DM Mono',monospace; white-space:nowrap;
}

.bp-item-actions { display:flex; align-items:center; gap:4px; flex-shrink:0; }
.bp-act-btn {
    width:34px; height:34px; border-radius:9px;
    display:flex; align-items:center; justify-content:center;
    border:1.5px solid var(--bp-bdr); background:transparent;
    color:var(--bp-txt3); cursor:pointer; text-decoration:none;
    transition:all .2s;
}
.bp-act-btn svg { width:15px; height:15px; }
.bp-act-btn:hover { transform:scale(1.05); }
.bp-act-btn-view:hover  { background:var(--bp-ind-l);  border-color:rgba(99,102,241,.3); color:var(--bp-ind); }
.bp-act-btn-dl:hover    { background:var(--bp-teal-l); border-color:rgba(20,184,166,.3); color:var(--bp-teal-d); }
.bp-act-btn-del:hover   { background:var(--bp-red-l);  border-color:rgba(239,68,68,.3);  color:var(--bp-red); }

/* Empty state */
.bp-empty {
    display:flex; flex-direction:column; align-items:center; justify-content:center;
    padding:60px 24px; gap:16px; text-align:center;
}
.bp-empty-icon {
    width:72px; height:72px; border-radius:20px;
    background:var(--bp-ind-l); display:flex; align-items:center; justify-content:center;
    color:var(--bp-ind); margin-bottom:4px;
}
.bp-empty-icon svg { width:36px; height:36px; }
.bp-empty-title { font-family:'Syne',sans-serif; font-size:1.1rem; font-weight:700; color:var(--bp-txt); margin:0; }
.bp-empty-sub { font-size:.83rem; color:var(--bp-txt3); margin:0; max-width:320px; line-height:1.6; }
.bp-empty-btn {
    display:inline-flex; align-items:center; gap:8px;
    padding:10px 22px; border-radius:11px; border:none; cursor:pointer;
    background:linear-gradient(135deg,var(--bp-ind-d),var(--bp-ind));
    color:#fff; font-size:.83rem; font-weight:600;
    font-family:'DM Sans',sans-serif;
    transition:all .2s; box-shadow:0 4px 14px rgba(99,102,241,.35);
}
.bp-empty-btn:hover { opacity:.9; transform:translateY(-1px); }
.bp-empty-btn svg { width:16px; height:16px; }

/* Pagination */
.bp-pagination { display:flex; justify-content:center; padding:16px 20px; }
.bp-pagination .pagination { display:flex; gap:4px; align-items:center; list-style:none; margin:0; padding:0; }
.bp-pagination .page-item .page-link {
    display:flex; align-items:center; justify-content:center;
    min-width:34px; height:34px; padding:0 10px;
    border:1.5px solid var(--bp-bdr); border-radius:9px;
    font-size:.78rem; font-weight:600; color:var(--bp-txt2);
    text-decoration:none; font-family:'DM Mono',monospace;
    transition:all .2s;
}
.bp-pagination .page-item .page-link:hover { border-color:var(--bp-ind); color:var(--bp-ind); background:var(--bp-ind-l); }
.bp-pagination .page-item.active .page-link { background:linear-gradient(135deg,var(--bp-ind-d),var(--bp-ind)); border-color:var(--bp-ind); color:#fff; }
.bp-pagination .page-item.disabled .page-link { opacity:.4; pointer-events:none; }

/* ═══════════════════════ MODAL ═══════════════════════ */
.bp-modal-overlay {
    position:fixed; inset:0; z-index:1050;
    background:rgba(15,23,42,.6); backdrop-filter:blur(4px);
    display:flex; align-items:center; justify-content:center;
    padding:20px; opacity:0; pointer-events:none;
    transition:opacity .25s;
}
.bp-modal-overlay.open { opacity:1; pointer-events:all; }

.bp-modal {
    background:var(--bp-surf); border-radius:18px;
    width:100%; max-width:560px; max-height:88vh;
    display:flex; flex-direction:column; overflow:hidden;
    box-shadow:0 24px 64px rgba(0,0,0,.18);
    transform:translateY(20px) scale(.98);
    transition:transform .3s cubic-bezier(.16,1,.3,1);
}
.bp-modal-overlay.open .bp-modal { transform:translateY(0) scale(1); }

.bp-modal > form { display:flex; flex-direction:column; flex:1; min-height:0; overflow:hidden; }

.bp-modal-header {
    background:linear-gradient(135deg,#312e81 0%,#4338ca 60%,#1d4ed8 100%);
    padding:24px 28px 22px; flex-shrink:0;
    display:flex; align-items:flex-start; justify-content:space-between; gap:16px;
}
.bp-modal-header-left { display:flex; align-items:center; gap:14px; }
.bp-modal-header-icon {
    width:44px; height:44px; border-radius:12px;
    background:rgba(255,255,255,.15);
    display:flex; align-items:center; justify-content:center;
    color:#fff; flex-shrink:0;
}
.bp-modal-header-icon svg { width:22px; height:22px; }
.bp-modal-header-title {
    font-family:'Syne',sans-serif; font-size:1.1rem; font-weight:700;
    color:#fff; margin:0 0 3px; line-height:1.2;
}
.bp-modal-header-sub { font-size:.75rem; color:rgba(255,255,255,.55); margin:0; }
.bp-modal-close {
    width:32px; height:32px; border-radius:8px;
    background:rgba(255,255,255,.12); border:none; cursor:pointer;
    color:rgba(255,255,255,.7); display:flex; align-items:center; justify-content:center;
    transition:all .2s; flex-shrink:0;
}
.bp-modal-close:hover { background:rgba(255,255,255,.22); color:#fff; }
.bp-modal-close svg { width:16px; height:16px; }

.bp-modal-body { flex:1; overflow-y:auto; min-height:0; padding:24px 28px; scrollbar-width:thin; scrollbar-color:var(--bp-bdr) transparent; }
.bp-modal-body::-webkit-scrollbar { width:4px; }
.bp-modal-body::-webkit-scrollbar-thumb { background:var(--bp-bdr2); border-radius:2px; }

.bp-modal-footer {
    flex-shrink:0; background:var(--bp-bg);
    border-top:1px solid var(--bp-bdr); padding:16px 28px;
    display:flex; align-items:center; justify-content:flex-end; gap:10px;
}

/* ── Form elements ── */
.bp-field { margin-bottom:18px; }
.bp-field:last-child { margin-bottom:0; }
.bp-field-row { display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:18px; }
.bp-label {
    display:block; font-size:.72rem; font-weight:700; letter-spacing:.04em;
    text-transform:uppercase; color:var(--bp-txt2); margin-bottom:7px;
}
.bp-label span { color:var(--bp-red); margin-left:2px; }

.bp-input, .bp-select, .bp-textarea {
    width:100%; padding:10px 14px;
    border:1.5px solid var(--bp-bdr); border-radius:10px;
    background:var(--bp-bg); color:var(--bp-txt);
    font-family:'DM Sans',sans-serif; font-size:.83rem;
    transition:border-color .2s, box-shadow .2s; box-sizing:border-box;
}
.bp-input:focus, .bp-select:focus, .bp-textarea:focus {
    outline:none; border-color:var(--bp-ind);
    box-shadow:0 0 0 3px rgba(99,102,241,.12);
}
.bp-select { appearance:none; cursor:pointer; padding-right:36px;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat:no-repeat; background-position:right 12px center;
}
.bp-textarea { resize:vertical; min-height:80px; line-height:1.6; }

/* Error */
.bp-error-box {
    background:var(--bp-red-l); border:1px solid rgba(239,68,68,.2);
    border-radius:10px; padding:12px 16px; margin-bottom:18px;
    font-size:.78rem; color:var(--bp-red); line-height:1.6;
}
.bp-error-box ul { margin:4px 0 0; padding-left:16px; }
.bp-field-error { font-size:.72rem; color:var(--bp-red); margin-top:5px; font-weight:500; }

/* Searchable select */
.bp-ss-wrap { position:relative; }
.bp-ss-input-wrap {
    display:flex; align-items:center; gap:8px;
    border:1.5px solid var(--bp-bdr); border-radius:10px;
    background:var(--bp-bg); padding:0 14px;
    transition:border-color .2s, box-shadow .2s; cursor:text;
}
.bp-ss-input-wrap.focused { border-color:var(--bp-ind); box-shadow:0 0 0 3px rgba(99,102,241,.12); }
.bp-ss-input-wrap svg { color:var(--bp-txt3); flex-shrink:0; }
.bp-ss-input {
    flex:1; border:none; background:transparent; padding:10px 0;
    font-size:.83rem; color:var(--bp-txt); font-family:'DM Sans',sans-serif; outline:none;
}
.bp-ss-input::placeholder { color:var(--bp-txt3); }
.bp-ss-clear { background:none; border:none; cursor:pointer; color:var(--bp-txt3); padding:4px; border-radius:4px; transition:color .15s; display:none; }
.bp-ss-clear:hover { color:var(--bp-red); }
.bp-ss-clear svg { width:14px; height:14px; display:block; }

.bp-ss-dropdown {
    position:absolute; top:calc(100% + 6px); left:0; right:0;
    background:var(--bp-surf); border:1.5px solid var(--bp-bdr);
    border-radius:12px; box-shadow:var(--bp-sh-lg);
    max-height:220px; overflow-y:auto; z-index:100;
    scrollbar-width:thin; scrollbar-color:var(--bp-bdr) transparent;
    display:none;
}
.bp-ss-dropdown.open { display:block; }
.bp-ss-dropdown::-webkit-scrollbar { width:4px; }
.bp-ss-opt {
    padding:10px 14px; cursor:pointer; font-size:.83rem; color:var(--bp-txt);
    transition:background .12s; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
}
.bp-ss-opt:first-child { border-radius:10px 10px 0 0; }
.bp-ss-opt:last-child { border-radius:0 0 10px 10px; }
.bp-ss-opt:hover { background:var(--bp-ind-l2); }
.bp-ss-opt.hidden { display:none; }
.bp-ss-opt.selected { background:var(--bp-ind-l); color:var(--bp-ind); font-weight:600; }
.bp-ss-no-results { padding:14px; text-align:center; font-size:.78rem; color:var(--bp-txt3); }

/* Upload zone */
.bp-upload-zone {
    border:2px dashed var(--bp-bdr2); border-radius:12px;
    padding:28px 20px; text-align:center; cursor:pointer;
    transition:all .2s; position:relative;
}
.bp-upload-zone:hover, .bp-upload-zone.dragover {
    border-color:var(--bp-ind); background:var(--bp-ind-l2);
}
.bp-upload-zone input[type="file"] { position:absolute; inset:0; opacity:0; cursor:pointer; }
.bp-uz-icon {
    width:48px; height:48px; border-radius:13px;
    background:var(--bp-ind-l); display:flex; align-items:center; justify-content:center;
    color:var(--bp-ind); margin:0 auto 12px;
}
.bp-uz-icon svg { width:24px; height:24px; }
.bp-uz-title { font-size:.83rem; font-weight:600; color:var(--bp-txt); margin-bottom:4px; }
.bp-uz-sub { font-size:.72rem; color:var(--bp-txt3); }

.bp-file-preview {
    display:none; align-items:center; gap:12px;
    padding:12px 14px; background:var(--bp-ind-l2);
    border:1.5px solid rgba(99,102,241,.2); border-radius:10px;
    margin-top:10px;
}
.bp-file-preview.show { display:flex; }
.bp-file-icon { color:var(--bp-ind); flex-shrink:0; }
.bp-file-icon svg { width:24px; height:24px; display:block; }
.bp-file-info { flex:1; min-width:0; }
.bp-file-name { font-size:.8rem; font-weight:600; color:var(--bp-txt); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.bp-file-size { font-size:.7rem; color:var(--bp-txt3); font-family:'DM Mono',monospace; margin-top:2px; }
.bp-file-remove { background:none; border:none; cursor:pointer; color:var(--bp-txt3); padding:4px; border-radius:6px; transition:all .15s; flex-shrink:0; }
.bp-file-remove:hover { color:var(--bp-red); background:var(--bp-red-l); }
.bp-file-remove svg { width:14px; height:14px; display:block; }

/* Checkbox */
.bp-check-wrap { display:flex; align-items:flex-start; gap:10px; cursor:pointer; }
.bp-check-wrap input[type="checkbox"] {
    width:17px; height:17px; border-radius:5px; flex-shrink:0;
    border:1.5px solid var(--bp-bdr2); cursor:pointer;
    accent-color:var(--bp-ind); margin-top:1px;
}
.bp-check-lbl { font-size:.82rem; color:var(--bp-txt2); line-height:1.5; }
.bp-check-lbl strong { color:var(--bp-txt); font-weight:600; }

/* Modal buttons */
.bp-btn-cancel {
    padding:9px 20px; border-radius:10px;
    border:1.5px solid var(--bp-bdr); background:transparent;
    color:var(--bp-txt2); font-size:.8rem; font-weight:600;
    font-family:'DM Sans',sans-serif; cursor:pointer; transition:all .2s;
}
.bp-btn-cancel:hover { border-color:var(--bp-bdr2); background:var(--bp-bg); }
.bp-btn-submit {
    display:inline-flex; align-items:center; gap:7px;
    padding:9px 22px; border-radius:10px; border:none; cursor:pointer;
    background:linear-gradient(135deg,var(--bp-ind-d),var(--bp-ind));
    color:#fff; font-size:.8rem; font-weight:700;
    font-family:'DM Sans',sans-serif;
    transition:all .2s; box-shadow:0 4px 14px rgba(99,102,241,.35);
}
.bp-btn-submit:hover { opacity:.9; transform:translateY(-1px); }
.bp-btn-submit svg { width:15px; height:15px; }

/* ── Notification premium ── */
.bp-notif {
    position:fixed; top:20px; left:50%; width:min(480px,calc(100vw - 32px));
    background:#fff; border-radius:16px; padding:0; z-index:100001; overflow:hidden;
    transform:translateX(-50%) translateY(-130%) scale(.92); opacity:0;
    transition:transform .52s cubic-bezier(.34,1.56,.64,1),opacity .28s ease;
    box-shadow:0 20px 60px rgba(0,0,0,.18), 0 0 0 1px rgba(0,0,0,.04);
}
.bp-notif.bp-notif-show { transform:translateX(-50%) translateY(0) scale(1); opacity:1; }
.bp-notif::before { content:''; display:block; height:5px; width:100%; }
.bp-notif-success::before { background:linear-gradient(90deg,#059669,#10b981,#34d399); }
.bp-notif-error::before   { background:linear-gradient(90deg,#dc2626,#ef4444,#f87171); }
.bp-notif-inner { display:flex; align-items:center; gap:16px; padding:18px 20px; }
.bp-notif-icon { width:52px; height:52px; border-radius:50%; flex-shrink:0;
    display:flex; align-items:center; justify-content:center; }
.bp-notif-success .bp-notif-icon { background:linear-gradient(135deg,#d1fae5,#6ee7b7); box-shadow:0 0 0 8px rgba(16,185,129,.1); }
.bp-notif-error   .bp-notif-icon { background:linear-gradient(135deg,#fee2e2,#fca5a5); box-shadow:0 0 0 8px rgba(239,68,68,.1); }
.bp-notif-icon svg { width:24px; height:24px; }
.bp-notif-text { flex:1; }
.bp-notif-text strong { display:block; font-size:.9375rem; font-weight:700; color:#111827; margin-bottom:2px; }
.bp-notif-text span { font-size:.8125rem; color:#6b7280; }
.bp-notif-close { width:32px; height:32px; border-radius:8px; border:none; background:none;
    cursor:pointer; display:flex; align-items:center; justify-content:center; color:#9ca3af;
    flex-shrink:0; transition:background .15s; }
.bp-notif-close:hover { background:#f3f4f6; }
.bp-notif-close svg { width:16px; height:16px; }
.bp-notif-bar { height:3px; background:#f3f4f6; }
.bp-notif-progress { height:100%; transform-origin:left; }
.bp-notif-success .bp-notif-progress { background:linear-gradient(90deg,#059669,#10b981); }
.bp-notif-error   .bp-notif-progress { background:linear-gradient(90deg,#dc2626,#ef4444); }
@keyframes bp-notif-bar { from{transform:scaleX(1)} to{transform:scaleX(0)} }

/* ── List avatar ── */
.bp-item-avatar {
    width:44px; height:44px; border-radius:12px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center;
    font-family:'Syne',sans-serif; font-size:.8rem; font-weight:700;
    color:#fff; position:relative; overflow:hidden;
    background:linear-gradient(135deg,var(--bp-ind-d),var(--bp-ind));
    transition:transform .2s;
}
.bp-item:hover .bp-item-avatar { transform:scale(1.05); }

/* ── Salary chip ── */
.bp-salary-chip {
    display:inline-flex; align-items:center; gap:4px;
    padding:3px 9px; border-radius:7px; font-size:.68rem; font-weight:700;
    font-family:'DM Mono',monospace; white-space:nowrap;
    background:var(--bp-emer-l); color:#059669;
    border:1px solid rgba(16,185,129,.2);
}

/* ── Modal salary row ── */
.bp-salary-row {
    display:grid; grid-template-columns:1fr 1fr; gap:14px;
    padding:14px 16px; background:linear-gradient(135deg,rgba(99,102,241,.04),rgba(20,184,166,.04));
    border:1.5px solid rgba(99,102,241,.12); border-radius:12px;
    margin-bottom:18px;
}
.bp-salary-lbl { font-size:.6rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase; color:var(--bp-txt3); margin-bottom:6px; }
.bp-salary-input-wrap { position:relative; }
.bp-salary-input-wrap input { padding-right:40px; }
.bp-salary-currency { position:absolute; right:12px; top:50%; transform:translateY(-50%);
    font-size:.7rem; font-weight:700; color:var(--bp-txt3); font-family:'DM Mono',monospace; pointer-events:none; }

/* ── Responsive ── */
@media(max-width:1024px) {
    .bp-stats-grid { grid-template-columns:repeat(2,1fr); }
    .bp-month-grid { grid-template-columns:repeat(6,1fr); }
}
@media(max-width:768px) {
    .bp-stats-grid { grid-template-columns:1fr; }
    .bp-hero { padding:28px 24px; }
    .bp-hero-title { font-size:1.7rem; }
    .bp-hero-actions { flex-direction:column; align-items:flex-start; }
    .bp-hero-row { flex-direction:column; align-items:flex-start; }
    .bp-month-grid { grid-template-columns:repeat(4,1fr); }
    .bp-field-row { grid-template-columns:1fr; }
    .bp-item { flex-wrap:wrap; gap:10px; }
    .bp-item-period { order:3; }
    .bp-item-actions { margin-left:auto; }
}
</style>
@endsection

@section('content')
<div class="bp">

    {{-- ══ HERO ══ --}}
    <div class="bp-hero">
        <div class="bp-hero-content">
            <div class="bp-hero-meta">
                <span class="bp-live-dot"></span>
                <span>Portail RH+ &mdash; Bulletins de Paie</span>
            </div>
            <div class="bp-hero-row">
                <div class="bp-hero-left">
                    <h1 class="bp-hero-title">Fiches de paie &middot; <span>{{ $anneeSelectionnee }}</span></h1>
                    <p class="bp-hero-sub">{{ $stats['total_employes'] }} employé{{ $stats['total_employes'] > 1 ? 's' : '' }} couverts &mdash; {{ $stats['total_bulletins'] }} bulletin{{ $stats['total_bulletins'] > 1 ? 's' : '' }} générés</p>
                </div>
                <div class="bp-hero-actions">
                    <a href="{{ route('admin.bulletins-paie.export', ['annee' => $anneeSelectionnee]) }}" class="bp-btn-hero-outline">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
                        </svg>
                        Exporter
                    </a>
                    <a href="{{ route('admin.bulletins-paie.import.index') }}" class="bp-btn-hero-outline">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
                        </svg>
                        Import ZIP
                    </a>
                    <button onclick="openUploadModal()" class="bp-btn-hero-fill">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                        Nouveau bulletin
                    </button>
                </div>
            </div>
            <div class="bp-hero-kpis">
                <div class="bp-hero-kpi">
                    <div class="bp-hero-kpi-lbl">Total bulletins</div>
                    <div class="bp-hero-kpi-val">{{ $stats['total_bulletins'] }}</div>
                </div>
                <div class="bp-hero-kpi">
                    <div class="bp-hero-kpi-lbl">Employés couverts</div>
                    <div class="bp-hero-kpi-val">{{ $stats['total_employes'] }}</div>
                </div>
                <div class="bp-hero-kpi">
                    <div class="bp-hero-kpi-lbl">Année en cours</div>
                    <div class="bp-hero-kpi-val">{{ $anneeSelectionnee }}</div>
                </div>
                @if($moisSelectionne)
                <div class="bp-hero-kpi">
                    <div class="bp-hero-kpi-lbl">Mois sélectionné</div>
                    <div class="bp-hero-kpi-val">{{ \App\Models\BulletinPaie::MOIS_NOMS[(int)$moisSelectionne] ?? $moisSelectionne }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ══ STAT CARDS ══ --}}
    <div class="bp-stats-grid">
        <div class="bp-stat bp-stat-c-ind">
            <div class="bp-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
            </div>
            <div class="bp-stat-body">
                <div class="bp-stat-lbl">Total bulletins</div>
                <div class="bp-stat-val">{{ $stats['total_bulletins'] }}</div>
                <div class="bp-stat-sub">{{ $anneeSelectionnee }}{{ $moisSelectionne ? ' · ' . (\App\Models\BulletinPaie::MOIS_NOMS[(int)$moisSelectionne] ?? $moisSelectionne) : ' · Tous les mois' }}</div>
            </div>
        </div>
        <div class="bp-stat bp-stat-c-teal">
            <div class="bp-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div class="bp-stat-body">
                <div class="bp-stat-lbl">Employés couverts</div>
                <div class="bp-stat-val">{{ $stats['total_employes'] }}</div>
                <div class="bp-stat-sub">Avec au moins un bulletin</div>
            </div>
        </div>
        <div class="bp-stat bp-stat-c-emer">
            <div class="bp-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/>
                    <line x1="8" y1="2" x2="8" y2="6"/><line x1="16" y1="2" x2="16" y2="6"/>
                </svg>
            </div>
            <div class="bp-stat-body">
                <div class="bp-stat-lbl">Mois distribués</div>
                <div class="bp-stat-val">{{ $stats['total_bulletins'] > 0 ? (int)ceil($stats['total_bulletins'] / max($stats['total_employes'],1)) : 0 }}</div>
                <div class="bp-stat-sub">Moyenne par employé</div>
            </div>
        </div>
    </div>

    {{-- ══ TIMELINE ══ --}}
    <div class="bp-timeline-card">
        <div class="bp-tl-head">
            <div class="bp-tl-title">
                <span class="bp-tl-title-dot"></span>
                Calendrier annuel
            </div>
            <div style="display:flex;align-items:center;gap:10px;">
                @if($moisSelectionne)
                <a href="{{ route('admin.bulletins-paie.index', ['annee' => $anneeSelectionnee]) }}" class="bp-tl-reset">
                    Tous les mois
                </a>
                @endif
                <form method="GET" action="{{ route('admin.bulletins-paie.index') }}" style="display:flex;align-items:center;gap:0">
                    @if($search)<input type="hidden" name="search" value="{{ $search }}">@endif
                    <select name="annee" class="bp-year-select" onchange="this.form.submit()">
                        @foreach($anneesDisponibles as $annee)
                        <option value="{{ $annee }}" {{ $annee == $anneeSelectionnee ? 'selected' : '' }}>{{ $annee }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
        <div class="bp-month-grid">
            @foreach($timeline as $num => $data)
            @php
                $isFuture = $anneeSelectionnee == date('Y') && $num > date('n');
                $hasData = $data['total'] > 0;
                $isActive = $moisSelectionne == $num;
                $url = route('admin.bulletins-paie.index', ['annee' => $anneeSelectionnee, 'mois' => $num, 'search' => $search]);
                $classes = 'bp-month' . ($isActive ? ' active' : '') . ($isFuture ? ' is-future' : '') . ($hasData ? ' has-data' : '');
            @endphp
            <a href="{{ $isFuture ? '#' : $url }}" class="{{ $classes }}">
                <span class="bp-month-name">{{ $data['mois_court'] }}</span>
                @if($hasData)
                    <span class="bp-month-count">{{ $data['total'] }}</span>
                @else
                    <span class="bp-month-dot"></span>
                @endif
            </a>
            @endforeach
        </div>
    </div>

    {{-- ══ FILTERS ══ --}}
    <div class="bp-filter-bar">
        <form method="GET" action="{{ route('admin.bulletins-paie.index') }}" style="display:contents">
            @if($anneeSelectionnee)<input type="hidden" name="annee" value="{{ $anneeSelectionnee }}">@endif
            @if($moisSelectionne)<input type="hidden" name="mois" value="{{ $moisSelectionne }}">@endif
            <div class="bp-search-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" name="search" class="bp-search-input" placeholder="Rechercher par employé, matricule…" value="{{ $search }}">
            </div>
            <button type="submit" class="bp-search-btn">Rechercher</button>
        </form>
        @if($moisSelectionne || $search)
        <div class="bp-filter-tags">
            @if($moisSelectionne)
            <div class="bp-filter-tag">
                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                {{ \App\Models\BulletinPaie::MOIS_NOMS[(int)$moisSelectionne] ?? $moisSelectionne }}
                <a href="{{ route('admin.bulletins-paie.index', ['annee' => $anneeSelectionnee, 'search' => $search]) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </a>
            </div>
            @endif
            @if($search)
            <div class="bp-filter-tag">
                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                "{{ Str::limit($search, 20) }}"
                <a href="{{ route('admin.bulletins-paie.index', ['annee' => $anneeSelectionnee, 'mois' => $moisSelectionne]) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </a>
            </div>
            @endif
            <a href="{{ route('admin.bulletins-paie.index', ['annee' => $anneeSelectionnee]) }}" class="bp-filter-clear">Réinitialiser</a>
        </div>
        @endif
    </div>

    {{-- ══ BULLETIN LIST ══ --}}
    <div class="bp-list-card">
        <div class="bp-list-head">
            <div class="bp-list-title">
                Bulletins
                @if($bulletins->total() > 0)
                <span class="bp-list-count">{{ $bulletins->total() }}</span>
                @endif
            </div>
            @if($bulletins->total() > 0)
            <button onclick="openUploadModal()" class="bp-btn-submit" style="font-size:.75rem;padding:7px 16px;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:13px;height:13px">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Ajouter
            </button>
            @endif
        </div>

        @forelse($bulletins as $i => $bulletin)
        @php
            $initials = collect(explode(' ', $bulletin->personnel->nom_complet))->take(2)->map(fn($w) => strtoupper(substr($w,0,1)))->implode('');
            $colors = ['linear-gradient(135deg,#6366f1,#4338ca)','linear-gradient(135deg,#14b8a6,#0d9488)','linear-gradient(135deg,#8b5cf6,#7c3aed)','linear-gradient(135deg,#f59e0b,#d97706)','linear-gradient(135deg,#ef4444,#dc2626)'];
            $colorIdx = crc32($bulletin->personnel->nom_complet) % count($colors);
        @endphp
        <div class="bp-item" style="animation-delay:{{ $i * 0.03 }}s">
            <div class="bp-item-avatar" style="background:{{ $colors[$colorIdx] }}">{{ $initials }}</div>
            <div class="bp-item-main">
                <div class="bp-item-name">{{ $bulletin->personnel->nom_complet }}</div>
                <div class="bp-item-meta">
                    <span>{{ $bulletin->personnel->matricule }}</span>
                    <span class="bp-item-meta-dot"></span>
                    <span>{{ $bulletin->fichier_taille_formatee }}</span>
                    @if($bulletin->salaire_net)
                    <span class="bp-item-meta-dot"></span>
                    <span class="bp-salary-chip">{{ number_format($bulletin->salaire_net, 0, ',', ' ') }} FCFA</span>
                    @endif
                </div>
            </div>
            <div class="bp-item-period">
                <span class="bp-period-badge">{{ $bulletin->mois_court }} {{ $bulletin->annee }}</span>
            </div>
            <div class="bp-item-actions">
                <a href="{{ route('admin.bulletins-paie.preview', $bulletin) }}" target="_blank" class="bp-act-btn bp-act-btn-view" title="Aperçu">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                    </svg>
                </a>
                <a href="{{ route('admin.bulletins-paie.download', $bulletin) }}" class="bp-act-btn bp-act-btn-dl" title="Télécharger">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                </a>
                <form method="POST" action="{{ route('admin.bulletins-paie.destroy', $bulletin) }}" style="display:contents"
                      onsubmit="return confirm('Supprimer ce bulletin ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="bp-act-btn bp-act-btn-del" title="Supprimer">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                            <path d="M10 11v6"/><path d="M14 11v6"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="bp-empty">
            <div class="bp-empty-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                </svg>
            </div>
            <h3 class="bp-empty-title">Aucun bulletin trouvé</h3>
            <p class="bp-empty-sub">
                @if($search || $moisSelectionne)
                    Aucun résultat pour ces filtres. Modifiez votre recherche ou sélectionnez un autre mois.
                @else
                    Commencez par ajouter un premier bulletin de paie pour vos employés.
                @endif
            </p>
            <button onclick="openUploadModal()" class="bp-empty-btn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Ajouter un bulletin
            </button>
        </div>
        @endforelse

        @if($bulletins->hasPages())
        <div class="bp-pagination">
            {{ $bulletins->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

</div>

{{-- ══ MODAL UPLOAD ══ --}}
<div class="bp-modal-overlay" id="uploadModal">
    <div class="bp-modal">
        <form method="POST" action="{{ route('admin.bulletins-paie.store') }}" enctype="multipart/form-data">
            @csrf
            {{-- Header --}}
            <div class="bp-modal-header" style="position:relative;overflow:hidden;">
                <div style="position:absolute;top:-40px;right:-40px;width:180px;height:180px;border-radius:50%;background:radial-gradient(circle,rgba(20,184,166,.25) 0%,transparent 70%);pointer-events:none;"></div>
                <div style="position:absolute;bottom:-60px;left:20%;width:160px;height:160px;border-radius:50%;background:radial-gradient(circle,rgba(255,255,255,.06) 0%,transparent 70%);pointer-events:none;"></div>
                <div class="bp-modal-header-left" style="position:relative;z-index:1;">
                    <div class="bp-modal-header-icon" style="background:rgba(255,255,255,.18);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,.25);border-radius:14px;width:52px;height:52px;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                        </svg>
                    </div>
                    <div>
                        <div class="bp-modal-header-title" style="font-size:1.15rem;">Ajouter un bulletin de paie</div>
                        <div class="bp-modal-header-sub">Fiche de paie PDF &mdash; Portail RH+</div>
                    </div>
                </div>
                <button type="button" class="bp-modal-close" onclick="closeUploadModal()" style="position:relative;z-index:1;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>

            {{-- Body --}}
            <div class="bp-modal-body">
                @if($errors->any())
                <div class="bp-error-box">
                    <strong>Veuillez corriger les erreurs :</strong>
                    <ul>
                        @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Personnel --}}
                <div class="bp-field">
                    <label class="bp-label">Employé <span>*</span></label>
                    <div class="bp-ss-wrap" id="personnelSelectWrap">
                        <input type="hidden" name="personnel_id" id="personnelId" value="{{ old('personnel_id') }}">
                        <div class="bp-ss-input-wrap" id="ssInputWrap">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                            </svg>
                            <input type="text" class="bp-ss-input" id="personnelSearch" placeholder="Rechercher un employé…" autocomplete="off">
                            <button type="button" class="bp-ss-clear" id="personnelClear">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                                </svg>
                            </button>
                        </div>
                        <div class="bp-ss-dropdown" id="personnelDropdown">
                            @foreach($personnels as $p)
                            <div class="bp-ss-opt" data-value="{{ $p->id }}" data-label="{{ $p->matricule }} — {{ $p->nom_complet }}">
                                {{ $p->matricule }} — {{ $p->nom_complet }}
                            </div>
                            @endforeach
                            <div class="bp-ss-no-results" id="ssNoResults" style="display:none">Aucun résultat</div>
                        </div>
                    </div>
                    @error('personnel_id')<div class="bp-field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Mois / Année --}}
                <div class="bp-field-row">
                    <div>
                        <label class="bp-label">Mois <span>*</span></label>
                        <select name="mois" class="bp-select">
                            <option value="">Sélectionner…</option>
                            @foreach(\App\Models\BulletinPaie::MOIS_NOMS as $num => $nom)
                            <option value="{{ $num }}" {{ old('mois', $moisSelectionne) == $num ? 'selected' : '' }}>{{ $nom }}</option>
                            @endforeach
                        </select>
                        @error('mois')<div class="bp-field-error">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="bp-label">Année <span>*</span></label>
                        <select name="annee" class="bp-select">
                            <option value="">Sélectionner…</option>
                            @foreach(range(date('Y'), date('Y') - 5) as $a)
                            <option value="{{ $a }}" {{ old('annee', $anneeSelectionnee) == $a ? 'selected' : '' }}>{{ $a }}</option>
                            @endforeach
                        </select>
                        @error('annee')<div class="bp-field-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Salaires --}}
                <div class="bp-salary-row">
                    <div>
                        <div class="bp-salary-lbl">Salaire brut</div>
                        <div class="bp-salary-input-wrap">
                            <input type="number" name="salaire_brut" class="bp-input" placeholder="0" value="{{ old('salaire_brut') }}" min="0" step="500">
                            <span class="bp-salary-currency">FCFA</span>
                        </div>
                    </div>
                    <div>
                        <div class="bp-salary-lbl">Salaire net</div>
                        <div class="bp-salary-input-wrap">
                            <input type="number" name="salaire_net" class="bp-input" placeholder="0" value="{{ old('salaire_net') }}" min="0" step="500">
                            <span class="bp-salary-currency">FCFA</span>
                        </div>
                    </div>
                </div>

                {{-- File upload --}}
                <div class="bp-field">
                    <label class="bp-label">Fichier PDF <span>*</span></label>
                    <div class="bp-upload-zone" id="uploadZone" style="background:linear-gradient(135deg,rgba(99,102,241,.03),rgba(20,184,166,.03));">
                        <input type="file" name="fichier" id="fileInput" accept=".pdf">
                        <div class="bp-uz-icon" style="background:linear-gradient(135deg,var(--bp-ind-l),var(--bp-teal-l));border:1px solid rgba(99,102,241,.15);">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                <polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
                            </svg>
                        </div>
                        <div class="bp-uz-title" style="font-weight:700;">Glissez votre PDF ici</div>
                        <div class="bp-uz-sub">ou cliquez pour parcourir &middot; <strong>PDF uniquement</strong> &middot; max 10 Mo</div>
                    </div>
                    <div class="bp-file-preview" id="filePreview">
                        <div class="bp-file-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                        </div>
                        <div class="bp-file-info">
                            <div class="bp-file-name" id="fileName"></div>
                            <div class="bp-file-size" id="fileSize"></div>
                        </div>
                        <button type="button" class="bp-file-remove" id="removeFile">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                            </svg>
                        </button>
                    </div>
                    @error('fichier')<div class="bp-field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Visibility --}}
                <div class="bp-field">
                    <label class="bp-check-wrap">
                        <input type="checkbox" name="visible_employe" value="1" {{ old('visible_employe', '1') == '1' ? 'checked' : '' }}>
                        <span class="bp-check-lbl"><strong>Rendre visible à l'employé</strong> — Il pourra consulter ce bulletin depuis son espace</span>
                    </label>
                </div>

                {{-- Comment --}}
                <div class="bp-field">
                    <label class="bp-label">Commentaire <span style="color:var(--bp-txt3);font-weight:400;text-transform:none;letter-spacing:0">(facultatif)</span></label>
                    <textarea name="commentaire" class="bp-textarea" placeholder="Note interne ou message pour l'employé…">{{ old('commentaire') }}</textarea>
                </div>
            </div>

            {{-- Footer --}}
            <div class="bp-modal-footer">
                <button type="button" class="bp-btn-cancel" onclick="closeUploadModal()">Annuler</button>
                <button type="submit" class="bp-btn-submit" id="submitBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
                    </svg>
                    Enregistrer le bulletin
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══ NOTIFICATION PREMIUM ══ --}}
<div class="bp-notif" id="bpNotif" role="alert">
    <div class="bp-notif-inner">
        <div class="bp-notif-icon" id="bpNotifIcon"></div>
        <div class="bp-notif-text">
            <strong id="bpNotifTitle"></strong>
            <span id="bpNotifMsg"></span>
        </div>
        <button class="bp-notif-close" onclick="bpHideNotif()">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
    <div class="bp-notif-bar"><div class="bp-notif-progress" id="bpNotifProgress"></div></div>
</div>
@endsection

@section('scripts')
<script>
/* ── Modal ── */
function openUploadModal() {
    document.getElementById('uploadModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeUploadModal() {
    document.getElementById('uploadModal').classList.remove('open');
    document.body.style.overflow = '';
}
document.getElementById('uploadModal').addEventListener('click', function(e) {
    if (e.target === this) closeUploadModal();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeUploadModal();
});

/* ── File upload drag-drop ── */
const zone   = document.getElementById('uploadZone');
const input  = document.getElementById('fileInput');
const prev   = document.getElementById('filePreview');
const fname  = document.getElementById('fileName');
const fsize  = document.getElementById('fileSize');
const rmBtn  = document.getElementById('removeFile');

zone.addEventListener('dragover',  e => { e.preventDefault(); zone.classList.add('dragover'); });
zone.addEventListener('dragleave', ()  => zone.classList.remove('dragover'));
zone.addEventListener('drop', e => {
    e.preventDefault(); zone.classList.remove('dragover');
    if (e.dataTransfer.files[0]) displayFile(e.dataTransfer.files[0]);
});
input.addEventListener('change', () => { if (input.files[0]) displayFile(input.files[0]); });

rmBtn.addEventListener('click', e => {
    e.preventDefault();
    input.value = '';
    prev.classList.remove('show');
    zone.style.display = '';
});

function displayFile(file) {
    if (file.type !== 'application/pdf') {
        bpShowNotif('error', 'Format invalide', 'Veuillez sélectionner un fichier PDF uniquement.');
        input.value = '';
        return;
    }
    if (file.size > 10 * 1024 * 1024) {
        bpShowNotif('error', 'Fichier trop lourd', 'Le fichier dépasse la limite de 10 Mo.');
        input.value = '';
        return;
    }
    const dt = new DataTransfer();
    dt.items.add(file);
    input.files = dt.files;
    fname.textContent = file.name;
    fsize.textContent = formatFileSize(file.size);
    prev.classList.add('show');
    zone.style.display = 'none';
}

function formatFileSize(b) {
    if (b < 1024)       return b + ' o';
    if (b < 1024*1024)  return (b/1024).toFixed(1) + ' Ko';
    return (b/(1024*1024)).toFixed(1) + ' Mo';
}

/* ── Searchable personnel select ── */
const searchInput  = document.getElementById('personnelSearch');
const hiddenInput  = document.getElementById('personnelId');
const dropdown     = document.getElementById('personnelDropdown');
const clearBtn     = document.getElementById('personnelClear');
const noResults    = document.getElementById('ssNoResults');
const inputWrap    = document.getElementById('ssInputWrap');
const opts         = dropdown.querySelectorAll('.bp-ss-opt');
let selectedLabel  = '';

function openDropdown() { dropdown.classList.add('open'); inputWrap.classList.add('focused'); }
function closeDropdown() { dropdown.classList.remove('open'); inputWrap.classList.remove('focused'); }

searchInput.addEventListener('focus', openDropdown);
searchInput.addEventListener('input', function() {
    const q = this.value.toLowerCase();
    let visible = 0;
    opts.forEach(o => {
        const match = o.dataset.label.toLowerCase().includes(q);
        o.classList.toggle('hidden', !match);
        if (match) visible++;
    });
    noResults.style.display = visible === 0 ? '' : 'none';
    if (!q) { hiddenInput.value = ''; clearBtn.style.display = 'none'; selectedLabel = ''; }
    openDropdown();
});

opts.forEach(o => {
    o.addEventListener('mousedown', e => {
        e.preventDefault();
        opts.forEach(x => x.classList.remove('selected'));
        o.classList.add('selected');
        hiddenInput.value = o.dataset.value;
        searchInput.value = o.dataset.label;
        selectedLabel = o.dataset.label;
        clearBtn.style.display = 'flex';
        closeDropdown();
    });
});

clearBtn.addEventListener('click', () => {
    hiddenInput.value = '';
    searchInput.value = '';
    selectedLabel = '';
    clearBtn.style.display = 'none';
    opts.forEach(o => { o.classList.remove('hidden', 'selected'); });
    noResults.style.display = 'none';
    searchInput.focus();
});

document.addEventListener('click', e => {
    if (!document.getElementById('personnelSelectWrap').contains(e.target)) {
        if (!hiddenInput.value) searchInput.value = '';
        else searchInput.value = selectedLabel;
        closeDropdown();
    }
});

// Restore old() value on reload after validation error
@if(old('personnel_id'))
(function() {
    const oldId = "{{ old('personnel_id') }}";
    const opt = dropdown.querySelector(`.bp-ss-opt[data-value="${oldId}"]`);
    if (opt) {
        hiddenInput.value = oldId;
        searchInput.value = opt.dataset.label;
        selectedLabel = opt.dataset.label;
        opt.classList.add('selected');
        clearBtn.style.display = 'flex';
    }
})();
@endif

// Prevent submit without personnel
document.querySelector('.bp-modal form').addEventListener('submit', function(e) {
    if (!hiddenInput.value) {
        e.preventDefault();
        searchInput.focus();
        inputWrap.style.borderColor = 'var(--bp-red)';
        setTimeout(() => inputWrap.style.borderColor = '', 2000);
    }
});

/* ── Auto-open on validation errors ── */
@if($errors->any())
openUploadModal();
@endif

/* ── Notification premium ── */
let _bpNotifTimer = null;
function bpShowNotif(type, title, msg, duration = 6000) {
    const el   = document.getElementById('bpNotif');
    const icon = document.getElementById('bpNotifIcon');
    const t    = document.getElementById('bpNotifTitle');
    const m    = document.getElementById('bpNotifMsg');
    const bar  = document.getElementById('bpNotifProgress');
    const isS  = type === 'success';
    el.className = 'bp-notif bp-notif-' + type;
    icon.style.background  = isS ? 'linear-gradient(135deg,#d1fae5,#6ee7b7)' : 'linear-gradient(135deg,#fee2e2,#fca5a5)';
    icon.style.boxShadow   = isS ? '0 0 0 8px rgba(16,185,129,.1)' : '0 0 0 8px rgba(239,68,68,.1)';
    icon.innerHTML = isS
        ? '<svg viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="24" height="24"><path d="M20 6L9 17l-5-5"/></svg>'
        : '<svg viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="24" height="24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>';
    t.textContent = title;
    m.textContent = msg;
    bar.style.animation = 'none'; bar.offsetHeight;
    bar.style.transition = `transform ${duration}ms linear`;
    bar.style.transform  = 'scaleX(1)';
    el.classList.add('bp-notif-show');
    requestAnimationFrame(() => { bar.style.transform = 'scaleX(0)'; });
    if (_bpNotifTimer) clearTimeout(_bpNotifTimer);
    _bpNotifTimer = setTimeout(bpHideNotif, duration);
}
function bpHideNotif() {
    document.getElementById('bpNotif').classList.remove('bp-notif-show');
}

@if(session('success'))
setTimeout(() => bpShowNotif('success', 'Succès', @json(session('success')), 7000), 400);
@endif
@if(session('error'))
setTimeout(() => bpShowNotif('error', 'Erreur', @json(session('error')), 7000), 400);
@endif
</script>
@endsection
