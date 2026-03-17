@extends('layouts.app')

@section('title', 'Gestion du Personnel')
@section('page-title', 'Personnel')
@section('page-subtitle', 'Gérez les fiches du personnel')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
</svg>
@endsection

@section('styles')
<style>
/* ═══════════════════════════════════════════════════════════════
   PERSONNEL — Indigo × Teal Design System
   Syne (display) · DM Sans (body) · DM Mono (mono)
   ═══════════════════════════════════════════════════════════════ */

:root {
    --pp-ind:    #6366f1; --pp-ind-d: #4338ca; --pp-ind-l: #eef2ff; --pp-ind-m: #c7d2fe;
    --pp-teal:   #14b8a6; --pp-teal-l: #f0fdfa; --pp-teal-m: #99f6e4;
    --pp-amber:  #f59e0b; --pp-amb-l: #fffbeb;
    --pp-red:    #ef4444; --pp-red-l: #fef2f2;
    --pp-emer:   #10b981; --pp-emer-l: #ecfdf5;
    --pp-surf:   #fff;
    --pp-bg:     #f8fafc;
    --pp-text:   #1e293b; --pp-text2: #475569; --pp-text3: #94a3b8;
    --pp-bdr:    #e2e8f0; --pp-bdr2: #f1f5f9;
    --pp-r: 13px; --pp-rl: 18px;
    --pp-sh:  0 1px 3px rgba(0,0,0,.05), 0 1px 2px rgba(0,0,0,.04);
    --pp-shm: 0 4px 14px rgba(0,0,0,.07), 0 2px 4px rgba(0,0,0,.04);
    --pp-shl: 0 14px 32px rgba(0,0,0,.09), 0 4px 8px rgba(0,0,0,.05);
}
.dark {
    --pp-surf:  #1e293b; --pp-bg:  #0f172a;
    --pp-text:  #f1f5f9; --pp-text2: #cbd5e1; --pp-text3: #64748b;
    --pp-bdr:   #334155; --pp-bdr2: #1e293b;
    --pp-ind-l:  rgba(99,102,241,.12); --pp-ind-m: rgba(99,102,241,.25);
    --pp-teal-l: rgba(20,184,166,.1);  --pp-teal-m: rgba(20,184,166,.25);
    --pp-amb-l:  rgba(245,158,11,.1);
    --pp-red-l:  rgba(239,68,68,.1);   --pp-emer-l: rgba(16,185,129,.1);
    --pp-sh:  0 1px 3px rgba(0,0,0,.25);
    --pp-shm: 0 4px 14px rgba(0,0,0,.35);
    --pp-shl: 0 14px 32px rgba(0,0,0,.45);
}

/* ── Animations ── */
@keyframes pp-up      { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:translateY(0)} }
@keyframes pp-in      { from{opacity:0;transform:scale(.97)}       to{opacity:1;transform:scale(1)} }
@keyframes pp-spin    { to{transform:rotate(360deg)} }
@keyframes pp-dot     { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(1.5)} }
@keyframes pp-shimmer { 0%{background-position:-400px 0} 100%{background-position:400px 0} }
@keyframes pp-float   { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-6px)} }

/* ── Page ── */
.pp-page { font-family:'DM Sans',sans-serif; max-width:1440px; margin:0 auto; animation:pp-up .4s cubic-bezier(.16,1,.3,1); }

/* ══════════════════════════════════
   HERO BANNER
══════════════════════════════════ */
.pp-hero {
    position:relative; border-radius:20px; overflow:hidden;
    margin-bottom:24px;
    animation:pp-up .4s cubic-bezier(.16,1,.3,1) .04s both;
}

.pp-hero-bg {
    background:linear-gradient(135deg,#312e81 0%,#4338ca 40%,#0d9488 100%);
    padding:1.875rem 2rem;
    position:relative;
}

/* Orbe haut-droite */
.pp-hero-bg::before {
    content:''; position:absolute;
    top:-70px; right:-70px;
    width:260px; height:260px;
    background:radial-gradient(circle,rgba(20,184,166,.35) 0%,transparent 70%);
    border-radius:50%; pointer-events:none;
}
/* Orbe bas-gauche */
.pp-hero-bg::after {
    content:''; position:absolute;
    bottom:-50px; left:-50px;
    width:200px; height:200px;
    background:radial-gradient(circle,rgba(99,102,241,.3) 0%,transparent 70%);
    border-radius:50%; pointer-events:none;
}

.pp-hero-inner {
    position:relative;
    display:flex; align-items:center; justify-content:space-between;
    gap:1.5rem; flex-wrap:wrap;
}

.pp-hero-left h1 {
    font-family:'Syne',sans-serif; font-size:1.75rem; font-weight:700;
    color:#fff; margin:0 0 .3rem; letter-spacing:-.4px; line-height:1.2;
}

.pp-hero-sub {
    font-size:.875rem; color:rgba(255,255,255,.72); margin:0;
    display:flex; align-items:center; gap:8px;
}

.pp-live-dot {
    width:7px; height:7px; border-radius:50%; background:var(--pp-teal);
    display:inline-block; animation:pp-dot 2s ease-in-out infinite;
    box-shadow:0 0 0 3px rgba(20,184,166,.25);
}

/* KPIs dans le hero */
.pp-hero-kpis {
    background:rgba(255,255,255,.08);
    border:1px solid rgba(255,255,255,.14);
    border-radius:16px; padding:.875rem 1.5rem;
    display:flex; gap:2rem;
    backdrop-filter:blur(8px); -webkit-backdrop-filter:blur(8px);
}

.pp-hero-kpi { text-align:center; position:relative; }

.pp-hero-kpi + .pp-hero-kpi::before {
    content:''; position:absolute;
    left:-1rem; top:15%; bottom:15%;
    width:1px; background:rgba(255,255,255,.15);
}

.pp-hero-kpi-val {
    font-family:'Syne',sans-serif; font-size:1.5rem; font-weight:700;
    color:#fff; line-height:1;
}

.pp-hero-kpi-lbl {
    font-size:.6875rem; color:rgba(255,255,255,.6);
    text-transform:uppercase; letter-spacing:.5px;
    font-weight:600; margin-top:.3rem;
}

.pp-hero-actions { display:flex; align-items:center; gap:10px; flex-shrink:0; }

/* Ligne accent */
.pp-hero-accent {
    height:3px;
    background:linear-gradient(90deg,transparent,rgba(99,102,241,.6),rgba(20,184,166,.8),transparent);
}

/* ── Buttons ── */
.pp-btn {
    display:inline-flex; align-items:center; gap:8px; padding:10px 20px;
    border-radius:12px; font-family:'DM Sans',sans-serif; font-size:.875rem;
    font-weight:600; cursor:pointer; transition:all .22s cubic-bezier(.16,1,.3,1);
    border:none; white-space:nowrap; text-decoration:none;
}
.pp-btn svg { width:17px; height:17px; flex-shrink:0; }
.pp-btn-primary {
    background:linear-gradient(135deg,#6366f1,#4338ca); color:#fff;
    box-shadow:0 4px 14px rgba(99,102,241,.35);
}
.pp-btn-primary:hover { transform:translateY(-2px); box-shadow:0 8px 22px rgba(99,102,241,.45); color:#fff; }
.pp-btn-secondary {
    background:var(--pp-surf); color:var(--pp-text2);
    border:1.5px solid var(--pp-bdr); box-shadow:var(--pp-sh);
}
.pp-btn-secondary:hover { background:var(--pp-bg); color:var(--pp-text); border-color:var(--pp-text3); }

/* ── Stats ── */
.pp-stats {
    display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px;
}
.pp-stat {
    background:var(--pp-surf); border:1.5px solid var(--pp-bdr);
    border-radius:var(--pp-rl); padding:20px 22px;
    display:flex; align-items:center; gap:16px;
    box-shadow:var(--pp-sh); transition:all .25s cubic-bezier(.16,1,.3,1);
    position:relative; overflow:hidden; cursor:default;
    animation:pp-up .4s cubic-bezier(.16,1,.3,1) backwards;
}
.pp-stat:nth-child(1){animation-delay:.04s}.pp-stat:nth-child(2){animation-delay:.08s}
.pp-stat:nth-child(3){animation-delay:.12s}.pp-stat:nth-child(4){animation-delay:.16s}
.pp-stat:hover { transform:translateY(-4px); box-shadow:var(--pp-shl); border-color:var(--pp-stat-c,var(--pp-ind)); }
.pp-stat::before {
    content:''; position:absolute; top:-28px; right:-28px;
    width:90px; height:90px; border-radius:50%;
    background:var(--pp-stat-g,rgba(99,102,241,.06));
    transition:opacity .3s; pointer-events:none;
}
.pp-stat::after {
    content:''; position:absolute; bottom:0; left:0; right:0; height:3px;
    background:var(--pp-stat-c,var(--pp-ind));
    transform:scaleX(0); transform-origin:left;
    transition:transform .32s cubic-bezier(.16,1,.3,1);
}
.pp-stat:hover::after { transform:scaleX(1); }
.pp-stat-ind  { --pp-stat-c:var(--pp-ind);   --pp-stat-g:rgba(99,102,241,.06); }
.pp-stat-teal { --pp-stat-c:var(--pp-teal);  --pp-stat-g:rgba(20,184,166,.06); }
.pp-stat-red  { --pp-stat-c:var(--pp-red);   --pp-stat-g:rgba(239,68,68,.05); }
.pp-stat-amb  { --pp-stat-c:var(--pp-amber); --pp-stat-g:rgba(245,158,11,.05); }

.pp-stat-icon {
    width:48px; height:48px; border-radius:13px;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.pp-stat-icon svg { width:22px; height:22px; }
.pp-stat-ind  .pp-stat-icon { background:var(--pp-ind-l);  color:var(--pp-ind); }
.pp-stat-teal .pp-stat-icon { background:var(--pp-teal-l); color:var(--pp-teal); }
.pp-stat-red  .pp-stat-icon { background:var(--pp-red-l);  color:var(--pp-red); }
.pp-stat-amb  .pp-stat-icon { background:var(--pp-amb-l);  color:var(--pp-amber); }
.pp-stat-body { flex:1; min-width:0; }
.pp-stat-val {
    font-family:'Syne',sans-serif; font-size:2rem; font-weight:700;
    color:var(--pp-text); line-height:1; margin-bottom:4px;
}
.pp-stat-label {
    font-size:.68rem; color:var(--pp-text3); font-weight:600;
    text-transform:uppercase; letter-spacing:.7px;
}

/* ── Toolbar ── */
.pp-toolbar {
    display:flex; align-items:center; gap:10px;
    margin-bottom:20px; flex-wrap:wrap;
}
.pp-search-wrap { flex:1; min-width:200px; max-width:340px; position:relative; }
.pp-search-wrap svg {
    position:absolute; left:12px; top:50%; transform:translateY(-50%);
    width:16px; height:16px; color:var(--pp-text3);
    pointer-events:none; transition:color .2s;
}
.pp-search-wrap:focus-within svg { color:var(--pp-ind); }
.pp-search-input {
    width:100%; padding:10px 12px 10px 38px;
    background:var(--pp-surf); border:1.5px solid var(--pp-bdr);
    border-radius:12px; font-family:'DM Sans',sans-serif;
    font-size:.875rem; color:var(--pp-text); outline:none;
    transition:all .2s; box-shadow:var(--pp-sh);
}
.pp-search-input::placeholder { color:var(--pp-text3); }
.pp-search-input:focus { border-color:var(--pp-ind); box-shadow:0 0 0 3px rgba(99,102,241,.12); }

.pp-filter-sel {
    padding:9px 30px 9px 12px; background:var(--pp-surf);
    border:1.5px solid var(--pp-bdr); border-radius:11px;
    font-family:'DM Sans',sans-serif; font-size:.8125rem;
    color:var(--pp-text2); cursor:pointer; outline:none;
    transition:all .2s; box-shadow:var(--pp-sh); appearance:none;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5' stroke-linecap='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat:no-repeat; background-position:right 8px center;
}
.pp-filter-sel:focus { border-color:var(--pp-ind); box-shadow:0 0 0 3px rgba(99,102,241,.1); }

.pp-spacer { flex:1; }

/* View toggle */
.pp-view-toggle {
    display:flex; background:var(--pp-bg); border:1.5px solid var(--pp-bdr);
    border-radius:11px; padding:3px; gap:2px;
}
.pp-vbtn {
    width:34px; height:34px; border-radius:8px; border:none;
    background:transparent; color:var(--pp-text3); cursor:pointer;
    display:flex; align-items:center; justify-content:center; transition:all .18s;
}
.pp-vbtn svg { width:17px; height:17px; }
.pp-vbtn.active { background:var(--pp-surf); color:var(--pp-ind); box-shadow:var(--pp-sh); }
.pp-vbtn:hover:not(.active) { color:var(--pp-text2); background:rgba(0,0,0,.04); }

/* ── Table Card ── */
.pp-table-card {
    background:var(--pp-surf); border:1.5px solid var(--pp-bdr);
    border-radius:var(--pp-rl); overflow:hidden;
    box-shadow:var(--pp-sh); animation:pp-in .4s cubic-bezier(.16,1,.3,1) .18s both;
}
.pp-table-wrap { overflow-x:auto; }
.pp-table-wrap::-webkit-scrollbar { height:5px; }
.pp-table-wrap::-webkit-scrollbar-track { background:var(--pp-bdr2); }
.pp-table-wrap::-webkit-scrollbar-thumb { background:var(--pp-bdr); border-radius:3px; }

/* ── Table ── */
.pp-table { width:100%; border-collapse:collapse; font-size:.875rem; }
.pp-table thead { background:var(--pp-bg); border-bottom:1.5px solid var(--pp-bdr); }
.pp-table thead th {
    padding:12px 18px; text-align:left; font-size:.68rem;
    font-weight:700; color:var(--pp-text3);
    text-transform:uppercase; letter-spacing:.7px; white-space:nowrap; user-select:none;
}
.pp-table tbody tr { border-bottom:1px solid var(--pp-bdr2); transition:background .12s; }
.pp-table tbody tr:last-child { border-bottom:none; }
.pp-table tbody tr:hover { background:var(--pp-ind-l); }
.pp-table tbody td { padding:13px 18px; color:var(--pp-text); vertical-align:middle; white-space:nowrap; }

/* Person cell */
.pp-person { display:flex; align-items:center; gap:12px; }
.pp-av-wrap { position:relative; flex-shrink:0; }
.pp-avatar {
    width:40px; height:40px; border-radius:11px; object-fit:cover;
    border:2px solid var(--pp-bdr); transition:transform .22s; display:block;
}
.pp-table tbody tr:hover .pp-avatar { transform:scale(1.1) rotate(-2deg); }
.pp-av-dot {
    position:absolute; bottom:-2px; right:-2px;
    width:11px; height:11px; border-radius:50%; border:2px solid var(--pp-surf);
}
.pp-av-dot.on  { background:#10b981; }
.pp-av-dot.off { background:var(--pp-text3); }
.pp-pname { font-weight:600; color:var(--pp-text); display:block; line-height:1.3; }
.pp-pmat  { font-size:.72rem; color:var(--pp-text3); font-family:'DM Mono',monospace; letter-spacing:.3px; display:block; }

/* Muted */
.pp-muted { color:var(--pp-text3); font-size:.8125rem; font-style:italic; }

/* Date */
.pp-date { display:inline-flex; align-items:center; gap:5px; font-size:.8125rem; color:var(--pp-text2); }
.pp-date svg { width:13px; height:13px; color:var(--pp-text3); }

/* Badges */
.pp-badge {
    display:inline-flex; align-items:center; gap:5px;
    padding:3px 10px; border-radius:999px;
    font-size:.68rem; font-weight:700; letter-spacing:.2px; text-transform:uppercase;
}
.pp-badge::before { content:''; width:5px; height:5px; border-radius:50%; background:currentColor; opacity:.6; }
.pp-badge-ind  { background:var(--pp-ind-l);  color:var(--pp-ind); }
.pp-badge-teal { background:var(--pp-teal-l); color:var(--pp-teal); }
.pp-badge-amb  { background:var(--pp-amb-l);  color:var(--pp-amber); }
.pp-badge-red  { background:var(--pp-red-l);  color:var(--pp-red); }
.pp-badge-emer { background:var(--pp-emer-l); color:var(--pp-emer); }
.pp-badge-gray { background:var(--pp-bdr2);   color:var(--pp-text3); }

/* Actions */
.pp-actions { display:flex; align-items:center; gap:5px; }
.pp-act {
    width:33px; height:33px; border-radius:9px; border:1.5px solid var(--pp-bdr);
    background:var(--pp-surf); display:flex; align-items:center; justify-content:center;
    cursor:pointer; transition:all .18s; color:var(--pp-text3); text-decoration:none;
}
.pp-act svg { width:15px; height:15px; }
.pp-act.view:hover { background:var(--pp-ind-l); border-color:var(--pp-ind-m); color:var(--pp-ind); transform:scale(1.1); }
.pp-act.del:hover  { background:var(--pp-red-l); border-color:rgba(239,68,68,.3); color:var(--pp-red); transform:scale(1.1); }

/* Table footer */
.pp-tfoot {
    display:flex; align-items:center; justify-content:space-between;
    padding:11px 18px; border-top:1px solid var(--pp-bdr); background:var(--pp-bg);
}
.pp-tfoot-txt { font-size:.8rem; color:var(--pp-text3); }
.pp-tfoot-txt strong { color:var(--pp-text2); font-weight:600; }

/* ── Card Grid ── */
.pp-grid {
    display:none; grid-template-columns:repeat(auto-fill,minmax(280px,1fr));
    gap:16px; animation:pp-in .3s cubic-bezier(.16,1,.3,1);
}
.pp-grid.pp-active { display:grid; }
.pp-table-card.pp-hidden { display:none; }

.pp-card {
    background:var(--pp-surf); border:1.5px solid var(--pp-bdr);
    border-radius:var(--pp-rl); padding:20px;
    box-shadow:var(--pp-sh);
    position:relative; overflow:hidden;
    transform-style:preserve-3d;
    transform:perspective(700px) rotateX(var(--rx,0deg)) rotateY(var(--ry,0deg)) translateZ(0);
    transition:transform .12s cubic-bezier(.16,1,.3,1),
               box-shadow .25s cubic-bezier(.16,1,.3,1),
               border-color .25s ease;
    will-change:transform;
}

/* Barre top gradient au hover */
.pp-card::before {
    content:''; position:absolute; top:0; left:0; right:0; height:3px;
    background:linear-gradient(90deg,var(--pp-ind),var(--pp-teal));
    transform:scaleX(0); transform-origin:left;
    transition:transform .3s cubic-bezier(.16,1,.3,1);
}

/* Spotlight lumineux suivant le curseur */
.pp-card::after {
    content:''; position:absolute; inset:0; pointer-events:none; border-radius:var(--pp-rl);
    background:radial-gradient(circle 160px at var(--mx,50%) var(--my,50%), rgba(99,102,241,.10), transparent 70%);
    opacity:0; transition:opacity .3s ease;
}

.pp-card:hover {
    box-shadow:var(--pp-shl), 0 0 0 1px rgba(99,102,241,.12);
    border-color:var(--pp-ind-m);
}

.pp-card:hover::before { transform:scaleX(1); }
.pp-card:hover::after  { opacity:1; }

/* Quand on relâche le hover → spring back */
.pp-card.pp-tilt-off {
    transform:perspective(700px) rotateX(0deg) rotateY(0deg) translateZ(0) !important;
    transition:transform .45s cubic-bezier(.16,1,.3,1);
}
.pp-card-head { display:flex; align-items:center; gap:14px; margin-bottom:16px; }
.pp-card-av { width:52px; height:52px; border-radius:14px; object-fit:cover; border:2px solid var(--pp-bdr); flex-shrink:0; }
.pp-card-info { flex:1; min-width:0; }
.pp-card-name {
    font-family:'Syne',sans-serif; font-weight:700; font-size:.9375rem;
    color:var(--pp-text); display:block;
    white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
}
.pp-card-mat { font-family:'DM Mono',monospace; font-size:.7rem; color:var(--pp-text3); }
.pp-card-rows { display:flex; flex-direction:column; gap:8px; margin-bottom:16px; }
.pp-card-row { display:flex; align-items:center; justify-content:space-between; }
.pp-card-rlabel { font-size:.7rem; font-weight:600; color:var(--pp-text3); text-transform:uppercase; letter-spacing:.5px; }
.pp-card-rval { font-size:.8125rem; font-weight:500; color:var(--pp-text2); text-align:right; }
.pp-card-foot {
    display:flex; align-items:center; justify-content:space-between;
    padding-top:14px; border-top:1px solid var(--pp-bdr2);
}

/* ── Table cursor glow ── */
#personnelTableBody {
    position:relative;
}
#personnelTableBody::before {
    content:''; pointer-events:none;
    position:absolute;
    width:320px; height:320px;
    border-radius:50%;
    left:calc(var(--gx,-999px) - 160px);
    top:calc(var(--gy,-999px) - 160px);
    background:radial-gradient(circle,rgba(99,102,241,.055) 0%,transparent 70%);
    transition:left .04s linear, top .04s linear;
    z-index:0;
}
#personnelTableBody tr { position:relative; z-index:1; }

/* ── Empty ── */
.pp-empty { padding:72px 24px; text-align:center; }
.pp-empty-icon {
    width:72px; height:72px; margin:0 auto 20px; border-radius:18px;
    background:linear-gradient(135deg,var(--pp-ind-l),var(--pp-teal-l));
    display:flex; align-items:center; justify-content:center;
}
.pp-empty-icon svg { width:32px; height:32px; color:var(--pp-ind); }
.pp-empty-title { font-family:'Syne',sans-serif; font-size:1.25rem; font-weight:700; color:var(--pp-text); margin:0 0 8px; }
.pp-empty-desc  { color:var(--pp-text3); font-size:.875rem; margin:0 0 24px; }

/* ── Pagination ── */
.pp-pagination { margin-top:20px; display:flex; justify-content:center; }
.pp-pagination nav,.pp-pagination .pagination { display:flex; align-items:center; gap:4px; list-style:none; padding:0; margin:0; }
.pp-pagination .page-item .page-link {
    display:flex; align-items:center; justify-content:center;
    min-width:36px; height:36px; padding:0 10px; border-radius:10px;
    border:1.5px solid var(--pp-bdr); background:var(--pp-surf);
    color:var(--pp-text2); font-family:'DM Sans',sans-serif;
    font-size:.8125rem; font-weight:600; text-decoration:none; transition:all .18s;
}
.pp-pagination .page-item .page-link:hover { background:var(--pp-ind-l); border-color:var(--pp-ind-m); color:var(--pp-ind); }
.pp-pagination .page-item.active .page-link {
    background:linear-gradient(135deg,#6366f1,#4338ca); border-color:transparent;
    color:#fff; box-shadow:0 4px 12px rgba(99,102,241,.4);
}
.pp-pagination .page-item.disabled .page-link { opacity:.4; cursor:not-allowed; }

/* ══ Premium Notification ══ */
.hrp-notif {
    position:fixed; top:20px; left:50%; width:min(480px,calc(100vw - 32px));
    background:#fff; border-radius:16px; padding:0; z-index:100001; overflow:hidden;
    font-family:'DM Sans',sans-serif;
    transform:translateX(-50%) translateY(-130%) scale(.92); opacity:0;
    transition:transform .52s cubic-bezier(.34,1.56,.64,1),opacity .28s ease;
}
.hrp-notif.hrp-show { transform:translateX(-50%) translateY(0) scale(1); opacity:1; }
.hrp-notif.hrp-hide {
    transform:translateX(-50%) translateY(-110%) scale(.94); opacity:0;
    transition:transform .3s cubic-bezier(.55,0,1,.45),opacity .22s ease;
}
.hrp-notif::before { content:''; display:block; height:5px; width:100%; }
.hrp-notif-success::before { background:linear-gradient(90deg,#059669,#10b981,#34d399); }
.hrp-notif-error::before   { background:linear-gradient(90deg,#dc2626,#ef4444,#f87171); }
.hrp-notif-info::before    { background:linear-gradient(90deg,var(--pp-ind-d),var(--pp-ind),#818cf8); }
.hrp-notif-success { box-shadow:0 4px 6px rgba(16,185,129,.12),0 20px 50px rgba(16,185,129,.18),0 8px 24px rgba(0,0,0,.1),0 0 0 1px rgba(16,185,129,.15); }
.hrp-notif-error   { box-shadow:0 4px 6px rgba(239,68,68,.12),0 20px 50px rgba(239,68,68,.16),0 8px 24px rgba(0,0,0,.1),0 0 0 1px rgba(239,68,68,.15); }
.hrp-notif-info    { box-shadow:0 4px 6px rgba(99,102,241,.12),0 20px 50px rgba(99,102,241,.18),0 8px 24px rgba(0,0,0,.1),0 0 0 1px rgba(99,102,241,.15); }
.hrp-notif-inner { display:flex; align-items:center; gap:16px; padding:18px 20px; }
.hrp-notif-icon-wrap { position:relative; width:52px; height:52px; flex-shrink:0; }
.hrp-notif-icon-bg { width:52px; height:52px; border-radius:50%; display:flex; align-items:center; justify-content:center; }
.hrp-notif-success .hrp-notif-icon-bg { background:linear-gradient(135deg,#d1fae5,#6ee7b7); box-shadow:0 0 0 8px rgba(16,185,129,.1); }
.hrp-notif-error   .hrp-notif-icon-bg { background:linear-gradient(135deg,#fee2e2,#fca5a5); box-shadow:0 0 0 8px rgba(239,68,68,.1); }
.hrp-notif-info    .hrp-notif-icon-bg { background:linear-gradient(135deg,var(--pp-ind-l),var(--pp-ind-m)); box-shadow:0 0 0 8px rgba(99,102,241,.1); }
.hrp-check-path { stroke-dasharray:1; stroke-dashoffset:1; }
.hrp-notif-success .hrp-check-path { animation:hrp-check .55s cubic-bezier(.65,0,.35,1) .2s forwards; }
@keyframes hrp-check { to{ stroke-dashoffset:0; } }
.hrp-notif-ring { position:absolute; inset:-7px; border-radius:50%; border:3px solid #10b981; opacity:0; }
.hrp-notif-success .hrp-notif-ring { animation:hrp-ring 1.1s cubic-bezier(.4,0,.6,1) .45s both; }
@keyframes hrp-ring { 0%{opacity:.9;transform:scale(.82)} 100%{opacity:0;transform:scale(1.6)} }
.hrp-notif-body { flex:1; min-width:0; }
.hrp-notif-label { font-size:.73rem; font-weight:800; letter-spacing:.08em; text-transform:uppercase; margin-bottom:3px; }
.hrp-notif-success .hrp-notif-label { color:#047857; }
.hrp-notif-error   .hrp-notif-label { color:#b91c1c; }
.hrp-notif-info    .hrp-notif-label { color:var(--pp-ind-d); }
.hrp-notif-msg { font-size:.9375rem; color:#0f172a; font-weight:600; line-height:1.45; }
.hrp-notif-close { background:none; border:none; width:32px; height:32px; border-radius:10px; cursor:pointer; display:flex; align-items:center; justify-content:center; color:#94a3b8; flex-shrink:0; transition:background .15s,color .15s; }
.hrp-notif-close:hover { background:#f1f5f9; color:#334155; }
.hrp-notif-progress { height:4px; background:rgba(0,0,0,.05); }
.hrp-notif-bar { height:100%; transform-origin:left; transform:scaleX(1); }
.hrp-notif-success .hrp-notif-bar { background:linear-gradient(90deg,#059669,#10b981,#34d399); }
.hrp-notif-error   .hrp-notif-bar { background:linear-gradient(90deg,#dc2626,#ef4444); }
.hrp-notif-info    .hrp-notif-bar { background:linear-gradient(90deg,var(--pp-ind-d),var(--pp-ind)); }
.dark .hrp-notif { background:#0f172a; border:1px solid rgba(255,255,255,.07); }
.dark .hrp-notif-msg { color:#f1f5f9; }
.dark .hrp-notif-close:hover { background:rgba(255,255,255,.07); color:#cbd5e1; }
.dark .hrp-notif-progress { background:rgba(255,255,255,.06); }

/* ── Responsive ── */
@media(max-width:1200px){ .pp-stats{grid-template-columns:repeat(2,1fr)} }
@media(max-width:768px){
    .pp-header{flex-direction:column;align-items:flex-start}
    .pp-header-title{font-size:1.5rem}
    .pp-stats{grid-template-columns:repeat(2,1fr)}
    .pp-toolbar{flex-direction:column;align-items:stretch}
    .pp-search-wrap{max-width:none}
}
@media(max-width:480px){
    .pp-stats{grid-template-columns:1fr}
    .pp-grid{grid-template-columns:1fr}
}
</style>
@endsection

@section('content')
<div class="pp-page">

    {{-- ══ Hero Banner ══ --}}
    <div class="pp-hero">
        <div class="pp-hero-bg">
            <div class="pp-hero-inner">
                <div class="pp-hero-left">
                    <h1>Gestion du Personnel</h1>
                    <p class="pp-hero-sub">
                        <span class="pp-live-dot"></span>
                        Registre actif des collaborateurs
                    </p>
                </div>

                <div class="pp-hero-kpis">
                    <div class="pp-hero-kpi">
                        <div class="pp-hero-kpi-val" data-count="{{ $personnels->total() }}">{{ $personnels->total() }}</div>
                        <div class="pp-hero-kpi-lbl">Total</div>
                    </div>
                    <div class="pp-hero-kpi">
                        <div class="pp-hero-kpi-val" data-count="{{ $personnels->where('is_active', true)->count() }}">{{ $personnels->where('is_active', true)->count() }}</div>
                        <div class="pp-hero-kpi-lbl">Actifs</div>
                    </div>
                    <div class="pp-hero-kpi">
                        <div class="pp-hero-kpi-val" data-count="{{ $personnels->whereNull('user_id')->count() }}">{{ $personnels->whereNull('user_id')->count() }}</div>
                        <div class="pp-hero-kpi-lbl">Sans compte</div>
                    </div>
                </div>

                <div class="pp-hero-actions">
                    <button class="pp-btn pp-btn-primary" id="btnAddPersonnel" style="background:rgba(255,255,255,.15);border:1.5px solid rgba(255,255,255,.25);backdrop-filter:blur(8px);box-shadow:none;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Nouveau personnel
                    </button>
                </div>
            </div>
        </div>
        <div class="pp-hero-accent"></div>
    </div>

    {{-- ── Stats ── --}}
    <div class="pp-stats">
        <div class="pp-stat pp-stat-ind">
            <div class="pp-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div class="pp-stat-body">
                <div class="pp-stat-val" data-count="{{ $personnels->total() }}">0</div>
                <div class="pp-stat-label">Total</div>
            </div>
        </div>
        <div class="pp-stat pp-stat-teal">
            <div class="pp-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div class="pp-stat-body">
                <div class="pp-stat-val" data-count="{{ $personnels->where('is_active', true)->count() }}">0</div>
                <div class="pp-stat-label">Actifs</div>
            </div>
        </div>
        <div class="pp-stat pp-stat-red">
            <div class="pp-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            </div>
            <div class="pp-stat-body">
                <div class="pp-stat-val" data-count="{{ $personnels->where('is_active', false)->count() }}">0</div>
                <div class="pp-stat-label">Inactifs</div>
            </div>
        </div>
        <div class="pp-stat pp-stat-amb">
            <div class="pp-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
            </div>
            <div class="pp-stat-body">
                <div class="pp-stat-val" data-count="{{ $personnels->whereNull('user_id')->count() }}">0</div>
                <div class="pp-stat-label">Sans compte</div>
            </div>
        </div>
    </div>

    {{-- ── Toolbar ── --}}
    <form method="GET" action="{{ request()->url() }}" id="filterForm">
        <div class="pp-toolbar">
            {{-- Search --}}
            <div class="pp-search-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <input type="search" name="search" class="pp-search-input" id="searchInput"
                       placeholder="Nom, matricule, poste…" value="{{ request('search') }}"
                       autocomplete="off">
            </div>

            {{-- Département filter --}}
            <select name="departement_id" class="pp-filter-sel" onchange="this.form.submit()">
                <option value="">Tous les départements</option>
                @foreach($departements as $dept)
                    <option value="{{ $dept->id }}" {{ request('departement_id') == $dept->id ? 'selected' : '' }}>
                        {{ $dept->nom }}
                    </option>
                @endforeach
            </select>

            {{-- Contrat filter --}}
            <select name="type_contrat" class="pp-filter-sel" onchange="this.form.submit()">
                <option value="">Tous contrats</option>
                <option value="CDI" {{ request('type_contrat') === 'CDI' ? 'selected' : '' }}>CDI</option>
                <option value="CDD" {{ request('type_contrat') === 'CDD' ? 'selected' : '' }}>CDD</option>
                <option value="Stage" {{ request('type_contrat') === 'Stage' ? 'selected' : '' }}>Stage</option>
                <option value="Consultant" {{ request('type_contrat') === 'Consultant' ? 'selected' : '' }}>Consultant</option>
            </select>

            {{-- Statut filter --}}
            <select name="has_user" class="pp-filter-sel" onchange="this.form.submit()">
                <option value="">Tous statuts</option>
                <option value="yes" {{ request('has_user') === 'yes' ? 'selected' : '' }}>Avec compte</option>
                <option value="no"  {{ request('has_user') === 'no'  ? 'selected' : '' }}>Sans compte</option>
            </select>

            @if(request()->hasAny(['search','departement_id','type_contrat','has_user']))
            <a href="{{ request()->url() }}" class="pp-btn pp-btn-secondary" style="padding:9px 14px; font-size:.8rem;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                Réinitialiser
            </a>
            @endif

            <div class="pp-spacer"></div>

            {{-- View toggle --}}
            <div class="pp-view-toggle">
                <button type="button" class="pp-vbtn active" id="btnTable" title="Vue tableau">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="3" y1="15" x2="21" y2="15"/><line x1="9" y1="9" x2="9" y2="21"/></svg>
                </button>
                <button type="button" class="pp-vbtn" id="btnGrid" title="Vue cartes">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                </button>
            </div>
        </div>
    </form>

    {{-- ── Table View ── --}}
    <div class="pp-table-card" id="tableView">
        <div class="pp-table-wrap">
            <table class="pp-table">
                <thead>
                    <tr>
                        <th>Personnel</th>
                        <th>Sexe</th>
                        <th>Poste</th>
                        <th>Département</th>
                        <th>Date Embauche</th>
                        <th>Contrat</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="personnelTableBody">
                    @forelse($personnels as $personnel)
                    <tr data-search="{{ strtolower($personnel->nom_complet . ' ' . $personnel->matricule . ' ' . $personnel->poste) }}">
                        <td>
                            <div class="pp-person">
                                <div class="pp-av-wrap">
                                    <img src="{{ $personnel->photo_url }}" alt="{{ $personnel->nom_complet }}" class="pp-avatar">
                                    <span class="pp-av-dot {{ $personnel->is_active ? 'on' : 'off' }}"></span>
                                </div>
                                <div>
                                    <span class="pp-pname">{{ $personnel->nom_complet }}</span>
                                    <span class="pp-pmat">{{ $personnel->matricule }}</span>
                                </div>
                            </div>
                        </td>
                        <td>{{ $personnel->sexe ?? '—' }}</td>
                        <td>{{ $personnel->poste ?? '—' }}</td>
                        <td>{{ $personnel->departement->nom ?? '—' }}</td>
                        <td>
                            @if($personnel->date_embauche)
                                <div class="pp-date">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    {{ \Carbon\Carbon::parse($personnel->date_embauche)->locale('fr')->isoFormat('DD MMM YYYY') }}
                                </div>
                            @else
                                <span class="pp-muted">N/A</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $tc = $personnel->type_contrat;
                                $tcClass = $tc === 'CDI' ? 'pp-badge-ind' : ($tc === 'CDD' ? 'pp-badge-amb' : 'pp-badge-gray');
                            @endphp
                            <span class="pp-badge {{ $tcClass }}">{{ $tc ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <span class="pp-badge {{ $personnel->is_active ? 'pp-badge-teal' : 'pp-badge-red' }}">
                                {{ $personnel->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td>
                            <div class="pp-actions">
                                <a href="{{ route('admin.personnels.show', $personnel->id) }}" class="pp-act view" title="Voir le profil">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>
                                <button class="pp-act del" title="Supprimer" onclick="deletePersonnel({{ $personnel->id }}, '{{ addslashes($personnel->nom_complet) }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="pp-empty">
                                <div class="pp-empty-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                </div>
                                <p class="pp-empty-title">Aucun personnel trouvé</p>
                                <p class="pp-empty-desc">Commencez par ajouter votre premier employé</p>
                                <button type="button" class="pp-btn pp-btn-primary" onclick="document.getElementById('btnAddPersonnel').click()">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                    Créer un personnel
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($personnels->count() > 0)
        <div class="pp-tfoot">
            <span class="pp-tfoot-txt">
                Affichage <strong>{{ $personnels->firstItem() }}–{{ $personnels->lastItem() }}</strong>
                sur <strong>{{ $personnels->total() }}</strong> employés
            </span>
            <span class="pp-tfoot-txt" id="filterCount"></span>
        </div>
        @endif
    </div>

    {{-- ── Card Grid View ── --}}
    <div class="pp-grid" id="gridView">
        @foreach($personnels as $personnel)
        @php
            $tc = $personnel->type_contrat;
            $tcClass = $tc === 'CDI' ? 'pp-badge-ind' : ($tc === 'CDD' ? 'pp-badge-amb' : 'pp-badge-gray');
        @endphp
        <div class="pp-card" data-search="{{ strtolower($personnel->nom_complet . ' ' . $personnel->matricule . ' ' . $personnel->poste) }}">
            <div class="pp-card-head">
                <img src="{{ $personnel->photo_url }}" alt="{{ $personnel->nom_complet }}" class="pp-card-av">
                <div class="pp-card-info">
                    <span class="pp-card-name">{{ $personnel->nom_complet }}</span>
                    <span class="pp-card-mat">{{ $personnel->matricule }}</span>
                </div>
                <span class="pp-badge {{ $personnel->is_active ? 'pp-badge-teal' : 'pp-badge-red' }}">
                    {{ $personnel->is_active ? 'Actif' : 'Inactif' }}
                </span>
            </div>
            <div class="pp-card-rows">
                <div class="pp-card-row">
                    <span class="pp-card-rlabel">Poste</span>
                    <span class="pp-card-rval">{{ $personnel->poste ?? '—' }}</span>
                </div>
                <div class="pp-card-row">
                    <span class="pp-card-rlabel">Département</span>
                    <span class="pp-card-rval">{{ $personnel->departement->nom ?? '—' }}</span>
                </div>
                <div class="pp-card-row">
                    <span class="pp-card-rlabel">Embauche</span>
                    <span class="pp-card-rval">
                        {{ $personnel->date_embauche
                            ? \Carbon\Carbon::parse($personnel->date_embauche)->locale('fr')->isoFormat('DD MMM YYYY')
                            : '—' }}
                    </span>
                </div>
            </div>
            <div class="pp-card-foot">
                <span class="pp-badge {{ $tcClass }}">{{ $tc ?? 'N/A' }}</span>
                <div class="pp-actions">
                    <a href="{{ route('admin.personnels.show', $personnel->id) }}" class="pp-act view" title="Voir le profil">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </a>
                    <button class="pp-act del" title="Supprimer" onclick="deletePersonnel({{ $personnel->id }}, '{{ addslashes($personnel->nom_complet) }}')">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── Pagination ── --}}
    @if($personnels->hasPages())
    <div class="pp-pagination">
        {{ $personnels->appends(request()->query())->links() }}
    </div>
    @endif

</div>

@include('personnels.modal_v3_final')
@endsection

@section('scripts')
<script>
/* ── Animate stat counters ── */
function animateStats() {
    document.querySelectorAll('.pp-stat-val[data-count]').forEach(el => {
        const target = parseInt(el.dataset.count) || 0;
        const dur = 700, start = performance.now();
        (function tick(now) {
            const p = Math.min((now - start) / dur, 1);
            const e = 1 - Math.pow(1 - p, 3);
            el.textContent = Math.round(target * e);
            if (p < 1) requestAnimationFrame(tick);
        })(start);
    });
}

/* ── Premium Notification ── */
function showNotification(message, type = 'info', duration = 6000) {
    document.querySelectorAll('.hrp-notif').forEach(n => {
        n.classList.add('hrp-hide');
        setTimeout(() => n.remove(), 400);
    });
    const labels = { success:'Succès', error:'Erreur', info:'Information' };
    const icons = {
        success: `<svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path class="hrp-check-path" d="M20 6L9 17L4 12" stroke="#10b981" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" pathLength="1"/></svg>`,
        error:   `<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><line x1="18" y1="6" x2="6"  y2="18" stroke="#ef4444" stroke-width="2.5" stroke-linecap="round"/><line x1="6"  y1="6" x2="18" y2="18" stroke="#ef4444" stroke-width="2.5" stroke-linecap="round"/></svg>`,
        info:    `<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="#6366f1" stroke-width="2.2"/><line x1="12" y1="8" x2="12" y2="12" stroke="#6366f1" stroke-width="2.2" stroke-linecap="round"/><line x1="12" y1="16" x2="12.01" y2="16" stroke="#6366f1" stroke-width="2.5" stroke-linecap="round"/></svg>`,
    };
    const notif = document.createElement('div');
    notif.className = `hrp-notif hrp-notif-${type}`;
    notif.setAttribute('role','status');
    notif.innerHTML = `
        <div class="hrp-notif-inner">
            <div class="hrp-notif-icon-wrap">
                <div class="hrp-notif-icon-bg">${icons[type] ?? icons.info}</div>
                <div class="hrp-notif-ring"></div>
            </div>
            <div class="hrp-notif-body">
                <div class="hrp-notif-label">${labels[type] ?? type}</div>
                <div class="hrp-notif-msg">${message.replace(/\n/g,'<br>')}</div>
            </div>
            <button class="hrp-notif-close" onclick="this.closest('.hrp-notif').classList.add('hrp-hide');setTimeout(()=>this.closest('.hrp-notif').remove(),400)" title="Fermer">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        ${duration > 0 ? '<div class="hrp-notif-progress"><div class="hrp-notif-bar"></div></div>' : ''}
    `;
    document.body.appendChild(notif);
    requestAnimationFrame(() => requestAnimationFrame(() => notif.classList.add('hrp-show')));
    if (duration > 0) {
        const bar = notif.querySelector('.hrp-notif-bar');
        if (bar) {
            bar.style.transition = `transform ${duration}ms linear`;
            requestAnimationFrame(() => requestAnimationFrame(() => { bar.style.transform = 'scaleX(0)'; }));
        }
        setTimeout(() => {
            notif.classList.add('hrp-hide');
            setTimeout(() => notif.remove(), 400);
        }, duration);
    }
}

/* ── Delete ── */
async function deletePersonnel(id, name) {
    if (!confirm(`Supprimer ${name} ? Cette action est irréversible.`)) return;
    try {
        const res = await fetch(`/admin/personnels/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        const data = await res.json();
        if (data.success) {
            sessionStorage.setItem('pp_flash', JSON.stringify({ type:'success', message:`${name} a été supprimé avec succès.` }));
            window.location.reload();
        } else {
            showNotification(data.message || 'Une erreur est survenue.', 'error', 0);
        }
    } catch(e) {
        showNotification('Erreur réseau. Veuillez réessayer.', 'error', 0);
    }
}

/* ── Live search (client-side) ── */
document.getElementById('searchInput').addEventListener('input', function() {
    const q = this.value.toLowerCase().trim();
    const rows = document.querySelectorAll('#personnelTableBody tr[data-search]');
    const cards = document.querySelectorAll('#gridView .pp-card[data-search]');
    let visible = 0;

    rows.forEach(r => {
        const show = !q || r.dataset.search.includes(q);
        r.style.display = show ? '' : 'none';
        if (show) visible++;
    });
    cards.forEach(c => {
        const show = !q || c.dataset.search.includes(q);
        c.style.display = show ? '' : 'none';
    });

    const fc = document.getElementById('filterCount');
    if (fc) fc.textContent = q ? `${visible} résultat${visible > 1 ? 's' : ''} trouvé${visible > 1 ? 's' : ''}` : '';
});

/* ── View toggle ── */
const tableView = document.getElementById('tableView');
const gridView  = document.getElementById('gridView');
const btnTable  = document.getElementById('btnTable');
const btnGrid   = document.getElementById('btnGrid');

const savedView = localStorage.getItem('pp_view') || 'table';
if (savedView === 'grid') switchView('grid', false);

btnTable.addEventListener('click', () => switchView('table'));
btnGrid.addEventListener('click',  () => switchView('grid'));

function switchView(mode, save = true) {
    if (mode === 'grid') {
        tableView.classList.add('pp-hidden');
        gridView.classList.add('pp-active');
        btnTable.classList.remove('active');
        btnGrid.classList.add('active');
    } else {
        tableView.classList.remove('pp-hidden');
        gridView.classList.remove('pp-active');
        btnTable.classList.add('active');
        btnGrid.classList.remove('active');
    }
    if (save) localStorage.setItem('pp_view', mode);
}

/* ══════════════════════════════
   3D TILT + SPOTLIGHT on cards
══════════════════════════════ */
function initTilt() {
    document.querySelectorAll('.pp-card').forEach(card => {
        card.addEventListener('mousemove', e => {
            const r  = card.getBoundingClientRect();
            const x  = (e.clientX - r.left) / r.width;
            const y  = (e.clientY - r.top)  / r.height;
            const rx = (y - 0.5) * -9;
            const ry = (x - 0.5) *  9;
            card.style.setProperty('--rx', rx + 'deg');
            card.style.setProperty('--ry', ry + 'deg');
            card.style.setProperty('--mx', (x * 100) + '%');
            card.style.setProperty('--my', (y * 100) + '%');
            card.classList.remove('pp-tilt-off');
        });
        card.addEventListener('mouseleave', () => {
            card.classList.add('pp-tilt-off');
            card.style.setProperty('--rx', '0deg');
            card.style.setProperty('--ry', '0deg');
            setTimeout(() => card.classList.remove('pp-tilt-off'), 450);
        });
    });
}

/* ══════════════════════════════
   TABLE cursor glow
══════════════════════════════ */
function initTableGlow() {
    const tbody = document.getElementById('personnelTableBody');
    if (!tbody) return;
    tbody.addEventListener('mousemove', e => {
        const r = tbody.getBoundingClientRect();
        tbody.style.setProperty('--gx', (e.clientX - r.left) + 'px');
        tbody.style.setProperty('--gy', (e.clientY - r.top)  + 'px');
    });
    tbody.addEventListener('mouseleave', () => {
        tbody.style.setProperty('--gx', '-999px');
        tbody.style.setProperty('--gy', '-999px');
    });
}

/* ── Hero KPI counters ── */
function animateHeroKpis() {
    document.querySelectorAll('.pp-hero-kpi-val[data-count]').forEach(el => {
        const target = parseInt(el.dataset.count) || 0;
        if (!target) return;
        el.textContent = '0';
        const dur = 700, start = performance.now();
        (function tick(now) {
            const p = Math.min((now - start) / dur, 1);
            el.textContent = Math.round(target * (1 - Math.pow(1 - p, 3)));
            if (p < 1) requestAnimationFrame(tick);
        })(start);
    });
}

/* ── Init ── */
document.addEventListener('DOMContentLoaded', () => {
    // Flash message
    try {
        const flash = sessionStorage.getItem('pp_flash');
        if (flash) {
            sessionStorage.removeItem('pp_flash');
            const { type, message } = JSON.parse(flash);
            setTimeout(() => showNotification(message, type, type === 'success' ? 7000 : 0), 500);
        }
    } catch(e) {}

    // Laravel flash
    @if(session('success'))
        setTimeout(() => showNotification('{{ session('success') }}', 'success', 7000), 500);
    @endif
    @if(session('error'))
        setTimeout(() => showNotification('{{ session('error') }}', 'error', 0), 500);
    @endif

    animateStats();
    animateHeroKpis();
    initTilt();
    initTableGlow();
});
</script>
@endsection
