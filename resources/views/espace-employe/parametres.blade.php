@extends('layouts.espace-employe')

@section('title', 'Parametres')
@section('page-title', 'Parametres')
@section('breadcrumb')
    <a href="{{ route('espace-employe.dashboard') }}">Accueil</a>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
    <span>Parametres</span>
@endsection

@section('styles')
<style>
/* ================================================
   PARAMETRES — Settings Pro Layout
   Sidebar nav + Content cards
   ================================================ */

.prm-layout {
    display: grid;
    grid-template-columns: 240px 1fr;
    gap: 1.5rem;
    align-items: start;
    width: 100%;
    animation: prm-in .5s cubic-bezier(.16,1,.3,1);
}
@keyframes prm-in { from { opacity:0; transform:translateY(10px); } to { opacity:1; } }

/* ── SIDEBAR ── */
.prm-sidebar {
    position: sticky;
    top: calc(var(--header-h) + 1.25rem);
    display: flex;
    flex-direction: column;
    gap: .5rem;
}

.prm-id-card {
    background: var(--surface);
    border-radius: var(--r-xl);
    border: 1px solid var(--border);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    margin-bottom: .25rem;
}

.prm-id-cover {
    height: 56px;
    background: linear-gradient(135deg, var(--ind-900), var(--ind-700));
    position: relative;
}
.prm-id-cover::before {
    content:''; position:absolute; top:0; left:0; right:0; height:3px;
    background: linear-gradient(90deg, var(--teal-400), var(--teal-500));
}
.prm-id-cover-grid {
    position:absolute; inset:0;
    background:
        linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
    background-size: 20px 20px;
}

.prm-id-body {
    padding: 0 1rem 1rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    margin-top: -28px;
    position: relative;
}

.prm-id-avatar {
    width: 56px; height: 56px; border-radius: 50%;
    border: 3px solid var(--surface);
    object-fit: cover;
    box-shadow: var(--shadow-md);
    margin-bottom: .625rem;
}

.prm-id-name {
    font-family: var(--font-d);
    font-size: .9375rem; font-weight: 400; color: var(--text);
    margin: 0 0 .25rem; line-height: 1.2;
}
.prm-id-role {
    font-size: .6875rem; font-weight: 600; color: var(--text-2);
    text-transform: uppercase; letter-spacing: .5px;
    display: flex; align-items: center; gap: .25rem;
}
.prm-id-dot {
    width: 6px; height: 6px; border-radius: 50%; background: var(--teal-400);
    box-shadow: 0 0 0 3px rgba(20,184,166,.2);
}

/* Nav */
.prm-nav {
    background: var(--surface);
    border-radius: var(--r-xl);
    border: 1px solid var(--border);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    padding: .375rem;
}

.prm-nav-section {
    padding: .5rem .5rem .25rem;
    font-size: .5875rem; font-weight: 700; letter-spacing: 1px;
    text-transform: uppercase; color: var(--text-3);
}

.prm-nav-item {
    display: flex; align-items: center; gap: .75rem;
    padding: .625rem .75rem; border-radius: var(--r-md);
    text-decoration: none; color: var(--text-2);
    font-size: .8125rem; font-weight: 500;
    transition: all .2s; cursor: pointer;
    border: none; background: none; width: 100%; text-align: left;
}
.prm-nav-item:hover { background: var(--bg); color: var(--text); }
.prm-nav-item.active {
    background: var(--ind-50); color: var(--ind-700);
    font-weight: 600;
}
.prm-nav-item.active .prm-nav-icon { background: linear-gradient(135deg, var(--ind-500), var(--ind-600)); color: white; }

.prm-nav-icon {
    width: 30px; height: 30px; border-radius: var(--r-sm); flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    background: var(--bg); color: var(--text-3);
    transition: all .2s;
}
.prm-nav-item:hover .prm-nav-icon { color: var(--text-2); }
.prm-nav-icon svg { width: 14px; height: 14px; }

.prm-nav-item.danger { color: #be123c; }
.prm-nav-item.danger .prm-nav-icon { background: #fff1f2; color: #e11d48; }
.prm-nav-item.danger:hover { background: #fff1f2; }
.prm-nav-item.danger.active { background: #fff1f2; color: #be123c; }
.prm-nav-item.danger.active .prm-nav-icon { background: linear-gradient(135deg, #e11d48, #be123c); color: white; }

.prm-nav-divider { height: 1px; background: var(--border); margin: .375rem .25rem; }

/* ── CONTENT ── */
.prm-content {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

/* ── CARD ── */
.prm-card {
    background: var(--surface);
    border-radius: var(--r-xl);
    border: 1px solid var(--border);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    scroll-margin-top: calc(var(--header-h) + 1.5rem);
}

.prm-card-head {
    display: flex; align-items: center; gap: 1rem;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--border);
    background: var(--bg);
    position: relative; overflow: hidden;
}

/* Subtle left accent bar */
.prm-card-head::before {
    content:''; position:absolute; left:0; top:0; bottom:0; width:4px;
    background: var(--card-c, var(--ind-500));
}

.prm-card-icon {
    width: 46px; height: 46px; border-radius: var(--r-md); flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 4px 12px var(--card-shadow, rgba(99,102,241,.25));
}
.prm-card-icon svg { width: 20px; height: 20px; }

.prm-card-icon.indigo { background: linear-gradient(135deg, var(--ind-500), var(--ind-600)); color: white; }
.prm-card-icon.violet { background: linear-gradient(135deg, #7c3aed, #8b5cf6); color: white; }
.prm-card-icon.teal   { background: linear-gradient(135deg, var(--teal-500), var(--teal-600)); color: white; }
.prm-card-icon.amber  { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }
.prm-card-icon.rose   { background: linear-gradient(135deg, #e11d48, #be123c); color: white; }

.prm-card:has(.indigo) { --card-c: var(--ind-500); --card-shadow: rgba(99,102,241,.2); }
.prm-card:has(.violet) { --card-c: #7c3aed; --card-shadow: rgba(124,58,237,.2); }
.prm-card:has(.teal)   { --card-c: var(--teal-500); --card-shadow: rgba(20,184,166,.2); }
.prm-card:has(.amber)  { --card-c: #f59e0b; --card-shadow: rgba(245,158,11,.2); }
.prm-card:has(.rose)   { --card-c: #e11d48; --card-shadow: rgba(225,29,72,.2); }

.prm-card-texts { flex: 1; }
.prm-card-title {
    font-family: var(--font-d); font-size: 1rem; font-weight: 400;
    color: var(--text); margin: 0 0 .2rem; letter-spacing: .01em;
}
.prm-card-sub { font-size: .75rem; color: var(--text-2); }

.prm-card-body { padding: 1.5rem; }
.prm-card-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid var(--border);
    background: var(--bg);
    display: flex; align-items: center; justify-content: flex-end; gap: .5rem;
}

/* ── ACCOUNT ROWS ── */
.prm-field-row {
    display: flex; align-items: center;
    padding: .875rem 1.125rem; gap: 1rem;
    background: var(--bg); border: 1px solid var(--border);
    border-radius: var(--r-lg); margin-bottom: .75rem;
    transition: all .2s;
}
.prm-field-row:last-child { margin-bottom: 0; }
.prm-field-row:hover { border-color: var(--ind-200); background: var(--ind-50); }

.prm-field-row-icon {
    width: 38px; height: 38px; border-radius: var(--r-md); flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    background: var(--surface); border: 1px solid var(--border); color: var(--ind-500);
}
.prm-field-row-icon svg { width: 16px; height: 16px; }
.prm-field-row-info { flex: 1; min-width: 0; }
.prm-field-row-label {
    font-size: .625rem; font-weight: 700; color: var(--text-3);
    text-transform: uppercase; letter-spacing: .8px; margin-bottom: .25rem;
}
.prm-field-row-val {
    font-size: .875rem; font-weight: 600; color: var(--text);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    font-family: var(--font-m);
}
.prm-lock-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    font-size: .625rem; font-weight: 700; text-transform: uppercase; letter-spacing: .5px;
    color: var(--text-3); padding: .25rem .625rem;
    background: var(--surface); border: 1px solid var(--border);
    border-radius: 9999px; flex-shrink: 0;
}
.prm-lock-badge svg { width: 10px; height: 10px; }

/* ── FORM FIELDS ── */
.prm-fg { margin-bottom: 1.25rem; }
.prm-fg:last-child { margin-bottom: 0; }
.prm-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.125rem; }

.prm-label {
    display: flex; align-items: center; gap: .375rem;
    font-size: .6875rem; font-weight: 700; text-transform: uppercase; letter-spacing: .5px;
    color: var(--text); margin-bottom: .5rem;
}
.prm-label svg { width: 12px; height: 12px; color: var(--ind-400); }

.prm-input-wrap { position: relative; }

.prm-input {
    width: 100%; padding: .75rem 1rem; padding-right: 2.75rem;
    border: 1.5px solid var(--border); border-radius: var(--r-md);
    font-size: .875rem; color: var(--text); background: var(--bg);
    font-family: inherit; transition: all .2s;
}
.prm-input:focus {
    outline: none; background: var(--surface);
    border-color: var(--teal-400);
    box-shadow: 0 0 0 3px rgba(7,143,132,.12);
}
.prm-input::placeholder { color: var(--text-3); }
.prm-input:disabled { cursor: not-allowed; color: var(--text-2); }

.prm-input-icon {
    position: absolute; left: .875rem; top: 50%; transform: translateY(-50%);
    color: var(--text-3); pointer-events: none;
}
.prm-input-icon svg { width: 15px; height: 15px; }
.prm-input.with-icon { padding-left: 2.625rem; }

.prm-eye {
    position: absolute; right: .75rem; top: 50%; transform: translateY(-50%);
    background: none; border: none; color: var(--text-3); cursor: pointer;
    display: flex; padding: .25rem; border-radius: var(--r-sm);
    transition: color .2s;
}
.prm-eye:hover { color: var(--text); }
.prm-eye svg { width: 15px; height: 15px; }

.prm-hint {
    margin-top: .4rem; font-size: .6875rem; color: var(--text-3);
    display: flex; align-items: center; gap: .3rem;
}
.prm-hint svg { width: 11px; height: 11px; flex-shrink: 0; }

/* strength */
.prm-strength { margin-top: .625rem; display: none; }
.prm-strength.show { display: block; animation: sIn .25s ease; }
@keyframes sIn { from { opacity:0; transform:translateY(-4px); } to { opacity:1; } }
.prm-strength-bars { display: flex; gap: 4px; margin-bottom: .4rem; }
.prm-strength-bar { flex: 1; height: 4px; border-radius: 9999px; background: var(--border); transition: background .3s; }
.prm-strength-bar.on-1 { background: #e11d48; }
.prm-strength-bar.on-2 { background: #f59e0b; }
.prm-strength-bar.on-3 { background: var(--teal-500); }
.prm-strength-txt { font-size: .6875rem; font-weight: 700; }
.prm-strength-txt.l1 { color: #e11d48; }
.prm-strength-txt.l2 { color: #f59e0b; }
.prm-strength-txt.l3 { color: var(--teal-600); }

/* match */
.prm-match { display: none; margin-top: .4rem; font-size: .6875rem; font-weight: 600; align-items: center; gap: .3rem; }
.prm-match.show { display: flex; }
.prm-match.ok { color: var(--teal-600); }
.prm-match.no { color: #e11d48; }
.prm-match svg { width: 11px; height: 11px; }

/* ── BUTTONS ── */
.prm-btn {
    display: inline-flex; align-items: center; gap: .5rem;
    padding: .625rem 1.25rem; border-radius: var(--r-md);
    font-size: .8125rem; font-weight: 600; cursor: pointer;
    transition: all .2s; border: none; font-family: inherit; letter-spacing: .01em;
}
.prm-btn svg { width: 14px; height: 14px; }
.prm-btn.primary {
    background: linear-gradient(135deg, var(--teal-500), var(--teal-600)); color: white;
    box-shadow: 0 4px 14px rgba(7,143,132,.3);
}
.prm-btn.primary:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(7,143,132,.4); }
.prm-btn.ghost {
    background: var(--surface); color: var(--text-2);
    border: 1.5px solid var(--border);
}
.prm-btn.ghost:hover { border-color: var(--ind-300); color: var(--ind-700); background: var(--ind-50); }
.prm-btn.danger {
    background: #fff1f2; color: #be123c;
    border: 1.5px solid #fecdd3;
}
.prm-btn.danger:hover { background: #ffe4e6; border-color: #fda4af; transform: translateY(-1px); }

/* ── TOGGLES ── */
.prm-notif-list { display: flex; flex-direction: column; gap: 0; }
.prm-notif-row {
    display: flex; align-items: center; gap: 1rem;
    padding: 1rem 0; border-bottom: 1px solid var(--border);
    transition: all .2s;
}
.prm-notif-row:first-child { padding-top: 0; }
.prm-notif-row:last-child  { border-bottom: none; padding-bottom: 0; }

.prm-notif-icon {
    width: 42px; height: 42px; border-radius: var(--r-md); flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    transition: all .3s;
}
.prm-notif-icon svg { width: 18px; height: 18px; }
/* off state */
.prm-notif-row[data-id="email"]  .prm-notif-icon { background: var(--ind-50); color: var(--ind-400); border: 1px solid var(--ind-100); }
.prm-notif-row[data-id="conges"] .prm-notif-icon { background: var(--teal-50); color: var(--teal-500); border: 1px solid rgba(7,143,132,.15); }
.prm-notif-row[data-id="paie"]   .prm-notif-icon { background: rgba(124,58,237,.06); color: #8b5cf6; border: 1px solid rgba(124,58,237,.1); }
/* on state */
.prm-notif-row.on[data-id="email"]  .prm-notif-icon { background: linear-gradient(135deg,var(--ind-500),var(--ind-600)); color:white; border-color:transparent; box-shadow:0 4px 12px rgba(99,102,241,.3); }
.prm-notif-row.on[data-id="conges"] .prm-notif-icon { background: linear-gradient(135deg,var(--teal-500),var(--teal-600)); color:white; border-color:transparent; box-shadow:0 4px 12px rgba(7,143,132,.3); }
.prm-notif-row.on[data-id="paie"]   .prm-notif-icon { background: linear-gradient(135deg,#7c3aed,#8b5cf6); color:white; border-color:transparent; box-shadow:0 4px 12px rgba(124,58,237,.3); }

.prm-notif-info { flex: 1; }
.prm-notif-label { font-size: .875rem; font-weight: 600; color: var(--text); margin-bottom: .125rem; }
.prm-notif-desc  { font-size: .75rem; color: var(--text-2); }

.prm-switch { position: relative; width: 46px; height: 24px; flex-shrink: 0; cursor: pointer; }
.prm-switch input { opacity:0; width:0; height:0; }
.prm-switch-track {
    position: absolute; inset: 0; border-radius: 24px;
    background: var(--border); transition: all .3s cubic-bezier(.4,0,.2,1);
    cursor: pointer;
}
.prm-switch-track::before {
    content: ''; position: absolute;
    width: 18px; height: 18px; left: 3px; top: 3px;
    background: white; border-radius: 50%;
    transition: all .3s cubic-bezier(.4,0,.2,1);
    box-shadow: 0 1px 4px rgba(0,0,0,.25);
}
.prm-switch input:checked ~ .prm-switch-track { background: var(--teal-500); }
.prm-switch input:checked ~ .prm-switch-track::before { transform: translateX(22px); }

/* ── SECURITY GRID ── */
.prm-sec-grid {
    display: grid; grid-template-columns: 1fr 1fr; gap: .75rem;
    margin-bottom: 1.25rem;
}
.prm-sec-cell {
    padding: .875rem 1rem; border-radius: var(--r-lg);
    background: var(--bg); border: 1px solid var(--border);
}
.prm-sec-cell-label {
    font-size: .6rem; font-weight: 700; text-transform: uppercase; letter-spacing: .8px;
    color: var(--text-3); margin-bottom: .375rem;
}
.prm-sec-cell-val {
    font-size: .8125rem; font-weight: 700; color: var(--text);
    display: flex; align-items: center; gap: .5rem;
    font-family: var(--font-m);
}
.prm-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
.prm-dot.green { background: var(--teal-400); box-shadow: 0 0 0 3px rgba(7,143,132,.15); }
.prm-dot.amber { background: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,.15); }
.prm-dot.red   { background: #e11d48; box-shadow: 0 0 0 3px rgba(225,29,72,.12); }

/* info banner */
.prm-info {
    display: flex; align-items: flex-start; gap: .875rem;
    padding: 1rem 1.125rem; border-radius: var(--r-lg);
    background: var(--bg); border: 1px solid var(--border);
    border-left: 4px solid var(--ind-400);
}
.prm-info svg { width: 18px; height: 18px; color: var(--ind-500); flex-shrink: 0; margin-top: .1rem; }
.prm-info p { font-size: .8125rem; color: var(--text-2); line-height: 1.55; margin: 0; }

/* ── DANGER ROW ── */
.prm-danger-row {
    display: flex; align-items: center; gap: 1rem;
    padding: 1rem 1.125rem; border-radius: var(--r-lg);
    background: var(--bg); border: 1px solid #fecdd3;
    background: #fff9f9;
}
.prm-danger-texts { flex: 1; }
.prm-danger-title { font-size: .875rem; font-weight: 700; color: var(--text); margin-bottom: .125rem; }
.prm-danger-desc  { font-size: .75rem; color: var(--text-2); }

/* ── TOAST ── */
.prm-toast {
    position: fixed; top: 1.25rem; right: 1.25rem; z-index: 9000;
    display: flex; align-items: center; gap: .75rem;
    padding: .875rem 1.125rem;
    background: var(--surface); border-radius: var(--r-lg);
    box-shadow: var(--shadow-xl); border: 1px solid var(--border);
    max-width: 360px; overflow: hidden;
    animation: tIn .5s cubic-bezier(.16,1,.3,1);
}
@keyframes tIn  { from { opacity:0; transform:translateX(120px); } to { opacity:1; } }
@keyframes tOut { to   { opacity:0; transform:translateX(120px); } }
.prm-toast.out { animation: tOut .3s ease-in forwards; }
.prm-toast-dot { position:absolute; bottom:0; left:0; height:3px; background:var(--teal-500); animation: dot 5s linear forwards; }
.prm-toast.err .prm-toast-dot { background:#e11d48; }
@keyframes dot { from{width:100%;} to{width:0%;} }
.prm-toast-ico { width:34px; height:34px; border-radius:var(--r-md); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.prm-toast.ok  .prm-toast-ico { background:var(--teal-50); color:var(--teal-700); }
.prm-toast.err .prm-toast-ico { background:#ffe4e6; color:#be123c; }
.prm-toast-ico svg { width:16px; height:16px; }
.prm-toast-body { flex:1; }
.prm-toast-title { font-size:.8rem; font-weight:700; color:var(--text); }
.prm-toast-msg   { font-size:.75rem; color:var(--text-2); margin-top:.1rem; }
.prm-toast-x { width:26px; height:26px; border:none; background:var(--bg); border-radius:var(--r-sm); color:var(--text-3); cursor:pointer; display:flex; align-items:center; justify-content:center; flex-shrink:0; transition:all .15s; }
.prm-toast-x:hover { background:var(--border); color:var(--text); }
.prm-toast-x svg { width:13px; height:13px; }

/* ── RESPONSIVE ── */

/* Tablette paysage : sidebar plus étroite */
@media (max-width: 1024px) {
    .prm-layout { grid-template-columns: 200px 1fr; gap: 1.125rem; }
}

/* Tablette portrait : sidebar en barre horizontale */
@media (max-width: 768px) {
    .prm-layout { grid-template-columns: 1fr; gap: 1rem; }
    .prm-sidebar { position: static; flex-direction: row; flex-wrap: wrap; gap: .75rem; }
    .prm-id-card { display: none; }
    .prm-nav {
        flex: 1; display: flex; flex-direction: row; flex-wrap: nowrap;
        overflow-x: auto; padding: .25rem; gap: .25rem;
        border-radius: var(--r-lg); scrollbar-width: none;
    }
    .prm-nav::-webkit-scrollbar { display: none; }
    .prm-nav-section { display: none; }
    .prm-nav-divider { display: none; }
    .prm-nav-item { white-space: nowrap; flex-shrink: 0; padding: .5rem .875rem; }
    .prm-card-head { padding: 1rem 1.25rem; }
    .prm-card-body { padding: 1.125rem 1.25rem; }
    .prm-card-footer { padding: .875rem 1.25rem; }
}

/* Mobile */
@media (max-width: 540px) {
    .prm-row { grid-template-columns: 1fr; }
    .prm-sec-grid { grid-template-columns: 1fr; }
    .prm-danger-row { flex-direction: column; align-items: flex-start; gap: .75rem; }
    .prm-btn.danger { width: 100%; justify-content: center; }
    .prm-field-row { flex-wrap: wrap; }
    .prm-lock-badge { font-size: .5625rem; }
    .prm-card-head { gap: .75rem; }
    .prm-card-icon { width: 38px; height: 38px; }
    .prm-card-icon svg { width: 17px; height: 17px; }
    .prm-card-title { font-size: .9rem; }
    .prm-notif-row { gap: .75rem; }
    .prm-notif-icon { width: 36px; height: 36px; }
    .prm-sec-grid { gap: .5rem; }
}
</style>
@endsection

@section('content')

{{-- TOASTS --}}
@if(session('success'))
<div class="prm-toast ok" id="t-ok">
    <div class="prm-toast-ico"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
    <div class="prm-toast-body">
        <div class="prm-toast-title">Enregistre</div>
        <div class="prm-toast-msg">{{ session('success') }}</div>
    </div>
    <button class="prm-toast-x" onclick="dismissToast('t-ok')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
    <div class="prm-toast-dot"></div>
</div>
@endif
@if($errors->any())
<div class="prm-toast err" id="t-err">
    <div class="prm-toast-ico"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg></div>
    <div class="prm-toast-body">
        <div class="prm-toast-title">Erreur</div>
        <div class="prm-toast-msg">{{ $errors->first() }}</div>
    </div>
    <button class="prm-toast-x" onclick="dismissToast('t-err')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
    <div class="prm-toast-dot"></div>
</div>
@endif

<div class="prm-layout">

    {{-- ══ SIDEBAR ══ --}}
    <aside class="prm-sidebar">

        {{-- Identity card --}}
        <div class="prm-id-card">
            <div class="prm-id-cover"><div class="prm-id-cover-grid"></div></div>
            <div class="prm-id-body">
                <img src="{{ $personnel->photo_url }}" alt="{{ $personnel->nom_complet }}" class="prm-id-avatar">
                <p class="prm-id-name">{{ $personnel->nom_complet }}</p>
                <span class="prm-id-role">
                    <span class="prm-id-dot"></span>
                    {{ $personnel->poste ?? 'Employe' }}
                </span>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="prm-nav">
            <div class="prm-nav-section">Compte</div>
            <a href="#compte" class="prm-nav-item active" data-target="compte">
                <span class="prm-nav-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></span>
                Informations
            </a>
            <a href="#securite" class="prm-nav-item" data-target="securite">
                <span class="prm-nav-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></span>
                Mot de passe
            </a>
            <div class="prm-nav-divider"></div>
            <div class="prm-nav-section">Preferences</div>
            <a href="#notifications" class="prm-nav-item" data-target="notifications">
                <span class="prm-nav-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg></span>
                Notifications
            </a>
            <div class="prm-nav-divider"></div>
            <div class="prm-nav-section">Session</div>
            <a href="#session" class="prm-nav-item" data-target="session">
                <span class="prm-nav-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></span>
                Securite
            </a>
            <a href="#danger" class="prm-nav-item danger" data-target="danger">
                <span class="prm-nav-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></span>
                Zone sensible
            </a>
        </nav>
    </aside>

    {{-- ══ CONTENT ══ --}}
    <div class="prm-content">

        {{-- ── Compte ── --}}
        <section id="compte" class="prm-card">
            <div class="prm-card-head">
                <div class="prm-card-icon indigo">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <div class="prm-card-texts">
                    <h2 class="prm-card-title">Informations du compte</h2>
                    <p class="prm-card-sub">Identifiants de connexion — geres par l'administrateur</p>
                </div>
            </div>
            <div class="prm-card-body">
                <div class="prm-field-row">
                    <div class="prm-field-row-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
                    <div class="prm-field-row-info">
                        <div class="prm-field-row-label">Nom complet</div>
                        <div class="prm-field-row-val">{{ $user->name }}</div>
                    </div>
                    <span class="prm-lock-badge"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg> Verrouille</span>
                </div>
                <div class="prm-field-row">
                    <div class="prm-field-row-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></div>
                    <div class="prm-field-row-info">
                        <div class="prm-field-row-label">Adresse e-mail</div>
                        <div class="prm-field-row-val">{{ $user->email }}</div>
                    </div>
                    <span class="prm-lock-badge"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg> Verrouille</span>
                </div>
                <div class="prm-info" style="margin-top:1.125rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    <p>Pour modifier ces informations, soumettez une demande via <a href="{{ route('espace-employe.demandes') }}" style="color:var(--ind-600);font-weight:600;">l'espace demandes</a> ou contactez directement votre responsable RH.</p>
                </div>
            </div>
        </section>

        {{-- ── Mot de passe ── --}}
        <section id="securite" class="prm-card">
            <div class="prm-card-head">
                <div class="prm-card-icon violet">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
                <div class="prm-card-texts">
                    <h2 class="prm-card-title">Mot de passe</h2>
                    <p class="prm-card-sub">Modifiez votre mot de passe de connexion</p>
                </div>
            </div>
            <form action="{{ route('espace-employe.password.update') }}" method="POST">
                @csrf @method('PUT')
                <div class="prm-card-body">

                    <div class="prm-fg">
                        <label class="prm-label">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            Mot de passe actuel
                        </label>
                        <div class="prm-input-wrap">
                            <input type="password" name="current_password" id="pw0" class="prm-input" placeholder="Entrez votre mot de passe actuel" required>
                            <button type="button" class="prm-eye" onclick="togglePwd('pw0','ei0')">
                                <svg id="ei0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="prm-row">
                        <div class="prm-fg">
                            <label class="prm-label">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                Nouveau mot de passe
                            </label>
                            <div class="prm-input-wrap">
                                <input type="password" name="password" id="pw1" class="prm-input" placeholder="8 caracteres minimum" required oninput="evalStrength(this.value)">
                                <button type="button" class="prm-eye" onclick="togglePwd('pw1','ei1')">
                                    <svg id="ei1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                            </div>
                            <div class="prm-strength" id="stMeter">
                                <div class="prm-strength-bars">
                                    <div class="prm-strength-bar" id="sb1"></div>
                                    <div class="prm-strength-bar" id="sb2"></div>
                                    <div class="prm-strength-bar" id="sb3"></div>
                                </div>
                                <span class="prm-strength-txt" id="stLabel">Faible</span>
                            </div>
                        </div>

                        <div class="prm-fg">
                            <label class="prm-label">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                Confirmation
                            </label>
                            <div class="prm-input-wrap">
                                <input type="password" name="password_confirmation" id="pw2" class="prm-input" placeholder="Repetez le mot de passe" required oninput="evalMatch()">
                                <button type="button" class="prm-eye" onclick="togglePwd('pw2','ei2')">
                                    <svg id="ei2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                            </div>
                            <div class="prm-match" id="matchHint">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" id="matchIco"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                <span id="matchTxt"></span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="prm-card-footer">
                    <button type="reset" class="prm-btn ghost">Annuler</button>
                    <button type="submit" class="prm-btn primary">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Enregistrer
                    </button>
                </div>
            </form>
        </section>

        {{-- ── Notifications ── --}}
        <section id="notifications" class="prm-card">
            <div class="prm-card-head">
                <div class="prm-card-icon teal">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                </div>
                <div class="prm-card-texts">
                    <h2 class="prm-card-title">Notifications</h2>
                    <p class="prm-card-sub">Gerez les alertes et rappels que vous recevez</p>
                </div>
            </div>
            <div class="prm-card-body">
                <div class="prm-notif-list">

                    <div class="prm-notif-row on" data-id="email">
                        <div class="prm-notif-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </div>
                        <div class="prm-notif-info">
                            <div class="prm-notif-label">Notifications par e-mail</div>
                            <div class="prm-notif-desc">Mises a jour importantes et rappels par mail</div>
                        </div>
                        <label class="prm-switch">
                            <input type="checkbox" checked onchange="this.closest('.prm-notif-row').classList.toggle('on',this.checked)">
                            <span class="prm-switch-track"></span>
                        </label>
                    </div>

                    <div class="prm-notif-row on" data-id="conges">
                        <div class="prm-notif-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                        <div class="prm-notif-info">
                            <div class="prm-notif-label">Rappels de conges</div>
                            <div class="prm-notif-desc">Alerte avant expiration de vos soldes</div>
                        </div>
                        <label class="prm-switch">
                            <input type="checkbox" checked onchange="this.closest('.prm-notif-row').classList.toggle('on',this.checked)">
                            <span class="prm-switch-track"></span>
                        </label>
                    </div>

                    <div class="prm-notif-row on" data-id="paie">
                        <div class="prm-notif-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                        </div>
                        <div class="prm-notif-info">
                            <div class="prm-notif-label">Nouveaux bulletins de paie</div>
                            <div class="prm-notif-desc">Alerte a chaque nouveau bulletin disponible</div>
                        </div>
                        <label class="prm-switch">
                            <input type="checkbox" checked onchange="this.closest('.prm-notif-row').classList.toggle('on',this.checked)">
                            <span class="prm-switch-track"></span>
                        </label>
                    </div>

                </div>
            </div>
        </section>

        {{-- ── Securite ── --}}
        <section id="session" class="prm-card">
            <div class="prm-card-head">
                <div class="prm-card-icon amber">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <div class="prm-card-texts">
                    <h2 class="prm-card-title">Securite du compte</h2>
                    <p class="prm-card-sub">Etat et informations de session</p>
                </div>
            </div>
            <div class="prm-card-body">
                <div class="prm-sec-grid">
                    <div class="prm-sec-cell">
                        <div class="prm-sec-cell-label">Statut</div>
                        <div class="prm-sec-cell-val"><span class="prm-dot green"></span> Actif et securise</div>
                    </div>
                    <div class="prm-sec-cell">
                        <div class="prm-sec-cell-label">Derniere connexion</div>
                        <div class="prm-sec-cell-val">{{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() : 'Maintenant' }}</div>
                    </div>
                    <div class="prm-sec-cell">
                        <div class="prm-sec-cell-label">Authentification 2FA</div>
                        <div class="prm-sec-cell-val"><span class="prm-dot amber"></span> Non activee</div>
                    </div>
                    <div class="prm-sec-cell">
                        <div class="prm-sec-cell-label">Membre depuis</div>
                        <div class="prm-sec-cell-val">{{ $user->created_at->format('d/m/Y') }}</div>
                    </div>
                </div>
                <div class="prm-info">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    <p>Pour activer l'authentification a deux facteurs ou toute autre mesure de securite avancee, veuillez contacter votre administrateur RH.</p>
                </div>
            </div>
        </section>

        {{-- ── Zone sensible ── --}}
        <section id="danger" class="prm-card">
            <div class="prm-card-head">
                <div class="prm-card-icon rose">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                </div>
                <div class="prm-card-texts">
                    <h2 class="prm-card-title">Zone sensible</h2>
                    <p class="prm-card-sub">Actions irreversibles sur votre compte</p>
                </div>
            </div>
            <div class="prm-card-body">
                <div class="prm-danger-row">
                    <div class="prm-danger-texts">
                        <div class="prm-danger-title">Se deconnecter de toutes les sessions</div>
                        <div class="prm-danger-desc">Ferme toutes les sessions actives sur tous vos appareils</div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="prm-btn danger" onclick="return confirm('Deconnecter toutes les sessions ?')">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                            Deconnecter
                        </button>
                    </form>
                </div>
            </div>
        </section>

    </div><!-- /prm-content -->
</div><!-- /prm-layout -->

@endsection

@section('scripts')
<script>
/* Auto-dismiss toasts */
document.querySelectorAll('.prm-toast').forEach(t => {
    setTimeout(() => { t.classList.add('out'); setTimeout(() => t.remove(), 350); }, 5000);
});
function dismissToast(id) {
    const t = document.getElementById(id);
    if(t) { t.classList.add('out'); setTimeout(() => t.remove(), 350); }
}

/* Eye toggle */
function togglePwd(inputId, iconId) {
    const i = document.getElementById(inputId);
    const ico = document.getElementById(iconId);
    if(!i) return;
    const isText = i.type === 'text';
    i.type = isText ? 'password' : 'text';
    ico.innerHTML = isText
        ? '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>'
        : '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
}

/* Strength meter */
function evalStrength(val) {
    const meter = document.getElementById('stMeter');
    const lbl = document.getElementById('stLabel');
    const bars = [document.getElementById('sb1'),document.getElementById('sb2'),document.getElementById('sb3')];
    if(!val) { meter.classList.remove('show'); return; }
    meter.classList.add('show');
    let s = 0;
    if(val.length >= 8) s++;
    if(/[A-Z]/.test(val) && /[0-9]/.test(val)) s++;
    if(/[^A-Za-z0-9]/.test(val) && val.length >= 12) s++;
    s = Math.max(1, s);
    const cls = ['on-1','on-2','on-3'];
    const names = ['Faible','Moyen','Fort'];
    bars.forEach((b,i) => { b.className = 'prm-strength-bar' + (i < s ? ' '+cls[s-1] : ''); });
    lbl.className = 'prm-strength-txt l'+s;
    lbl.textContent = names[s-1];
}

/* Match check */
function evalMatch() {
    const np = document.getElementById('pw1').value;
    const cp = document.getElementById('pw2').value;
    const hint = document.getElementById('matchHint');
    const ico  = document.getElementById('matchIco');
    const txt  = document.getElementById('matchTxt');
    if(!cp) { hint.classList.remove('show','ok','no'); return; }
    hint.classList.add('show');
    if(np === cp) {
        hint.className = 'prm-match show ok';
        ico.innerHTML = '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>';
        txt.textContent = 'Les mots de passe correspondent';
    } else {
        hint.className = 'prm-match show no';
        ico.innerHTML = '<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>';
        txt.textContent = 'Ne correspondent pas';
    }
}

/* Sidebar active nav */
const navItems = document.querySelectorAll('.prm-nav-item[data-target]');
const sections = [...navItems].map(n => document.getElementById(n.dataset.target)).filter(Boolean);

function updateNav() {
    const mid = window.scrollY + window.innerHeight * .35;
    let active = sections[0];
    sections.forEach(s => { if(s.offsetTop <= mid) active = s; });
    navItems.forEach(n => {
        const on = n.dataset.target === active?.id;
        n.classList.toggle('active', on);
        if(on && n.classList.contains('danger')) return; // keep danger style
    });
}

navItems.forEach(n => n.addEventListener('click', e => {
    e.preventDefault();
    const sec = document.getElementById(n.dataset.target);
    if(sec) sec.scrollIntoView({ behavior: 'smooth', block: 'start' });
}));

window.addEventListener('scroll', updateNav, { passive: true });
updateNav();
</script>
@endsection
