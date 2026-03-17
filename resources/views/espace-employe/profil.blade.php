@extends('layouts.espace-employe')

@section('title', 'Mon Profil')
@section('page-title', 'Mon Profil')
@section('breadcrumb')
    <a href="{{ route('espace-employe.dashboard') }}">Accueil</a>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
    <span>Mon Profil</span>
@endsection

@section('styles')
<style>
/* ============================================
   PROFIL PAGE — Indigo × Teal — Premium v2
   ============================================ */
.profil-page {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
    max-width: 1200px;
    margin: 0 auto;
    animation: pp-in 0.5s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes pp-in {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ===== TOAST ===== */
.pp-toast {
    position: fixed; top: 1.25rem; right: 1.25rem; z-index: 1000;
    display: flex; align-items: center; gap: 0.75rem;
    padding: 0.875rem 1.125rem;
    background: var(--surface); border-radius: var(--r-lg);
    box-shadow: var(--shadow-lg); border: 1px solid var(--border);
    max-width: 360px; overflow: hidden;
    animation: toastIn 0.5s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes toastIn  { from { opacity:0; transform: translateX(100px); } to { opacity:1; transform:none; } }
@keyframes toastOut { to   { opacity:0; transform: translateX(100px); } }
.pp-toast.hiding { animation: toastOut 0.3s ease-in forwards; }
.pp-toast-bar { position:absolute; bottom:0; left:0; height:3px; background:var(--teal-500); animation: shrink 5s linear forwards; }
.pp-toast.error .pp-toast-bar { background:#be123c; }
@keyframes shrink { from { width:100%; } to { width:0%; } }
.pp-toast-icon {
    width:34px; height:34px; border-radius:var(--r-md);
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.pp-toast.success .pp-toast-icon { background:var(--teal-100); color:var(--teal-700); }
.pp-toast.error   .pp-toast-icon { background:#ffe4e6; color:#be123c; }
.pp-toast-icon svg { width:16px; height:16px; }
.pp-toast-body { flex:1; }
.pp-toast-title   { font-size:.8125rem; font-weight:600; color:var(--text); }
.pp-toast-msg     { font-size:.75rem; color:var(--text-2); margin-top:.1rem; }
.pp-toast-close {
    width:28px; height:28px; border:none; background:var(--bg); border-radius:var(--r-sm);
    color:var(--text-2); cursor:pointer; display:flex; align-items:center; justify-content:center;
    transition: all .2s; flex-shrink:0;
}
.pp-toast-close:hover { background:var(--border); color:var(--text); }
.pp-toast-close svg { width:14px; height:14px; }

/* ===== HERO ===== */
.pp-hero {
    background: var(--surface);
    border-radius: var(--r-xl);
    border: 1px solid var(--border);
    overflow: hidden;
    box-shadow: var(--shadow-lg);
    position: relative;
}

.pp-cover {
    height: 190px;
    background: linear-gradient(135deg, var(--ind-900) 0%, var(--ind-700) 60%, #1e3a5f 100%);
    position: relative;
    overflow: hidden;
}

/* 3px teal top bar */
.pp-cover::before {
    content: '';
    position: absolute; top:0; left:0; right:0; height:3px;
    background: linear-gradient(90deg, var(--teal-400), var(--teal-500), var(--teal-400));
    z-index: 5;
}

/* Grid texture */
.pp-cover-grid {
    position: absolute; inset:0;
    background:
        linear-gradient(rgba(255,255,255,.025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.025) 1px, transparent 1px);
    background-size: 36px 36px;
}

/* Glows */
.pp-cover-glow {
    position: absolute; border-radius:50%; pointer-events:none;
}
.pp-cover-glow:nth-child(2) {
    width:350px; height:350px; top:-120px; right:-80px;
    background: radial-gradient(circle, rgba(20,184,166,.18) 0%, transparent 65%);
}
.pp-cover-glow:nth-child(3) {
    width:200px; height:200px; bottom:-70px; left:5%;
    background: radial-gradient(circle, rgba(99,102,241,.12) 0%, transparent 70%);
}
.pp-cover-glow:nth-child(4) {
    width:120px; height:120px; top:28px; left:42%;
    background: radial-gradient(circle, rgba(255,255,255,.05) 0%, transparent 70%);
}

/* Bottom fade */
.pp-cover-fade {
    position:absolute; bottom:0; left:0; right:0; height:90px;
    background: linear-gradient(to top, var(--surface), transparent);
    z-index: 3;
}

/* Decorative label in cover */
.pp-cover-label {
    position: absolute; bottom: 22px; right: 1.75rem;
    z-index: 4;
    display: flex; align-items: center; gap: 0.5rem;
    padding: 0.375rem 0.875rem;
    background: rgba(255,255,255,.08);
    border: 1px solid rgba(255,255,255,.14);
    border-radius: 9999px;
    backdrop-filter: blur(8px);
    font-size: 0.6875rem; font-weight: 600; color: rgba(255,255,255,.85);
    letter-spacing: .5px;
}
.pp-cover-label::before {
    content: '';
    width: 7px; height: 7px; border-radius: 50%;
    background: var(--teal-400);
    box-shadow: 0 0 0 3px rgba(20,184,166,.25);
    animation: pulse 2s ease-in-out infinite;
}
@keyframes pulse {
    0%,100% { box-shadow: 0 0 0 3px rgba(20,184,166,.25); }
    50%      { box-shadow: 0 0 0 6px rgba(20,184,166,.08); }
}

/* Body */
.pp-hero-body {
    display: flex;
    align-items: flex-end;
    gap: 1.5rem;
    padding: 0 2rem 1.5rem;
    margin-top: -68px;
    position: relative;
    z-index: 4;
}

/* Avatar */
.pp-avatar-wrap { position:relative; flex-shrink:0; }

.pp-avatar-ring {
    width: 116px; height: 116px;
    border-radius: 50%; padding: 3px;
    background: conic-gradient(
        var(--teal-400) 0%,
        var(--teal-500) 40%,
        var(--ind-400) 70%,
        var(--teal-400) 100%
    );
    box-shadow: 0 8px 32px rgba(0,0,0,.2), 0 0 0 4px rgba(20,184,166,.15);
    animation: ring-spin 18s linear infinite;
}
@keyframes ring-spin { to { transform: rotate(360deg); } }

.pp-avatar {
    width:100%; height:100%; border-radius:50%;
    object-fit:cover; border:4px solid var(--surface);
    transition: transform .4s cubic-bezier(.4,0,.2,1);
    position: relative; z-index: 1;
}
.pp-avatar-wrap:hover .pp-avatar { transform: scale(1.04); }

.pp-avatar-edit {
    position:absolute; bottom:4px; right:4px;
    width:34px; height:34px; border:none; border-radius:50%;
    background: linear-gradient(135deg, var(--teal-500), var(--teal-700));
    color:white; cursor:pointer;
    display:flex; align-items:center; justify-content:center;
    box-shadow: 0 4px 12px rgba(20,184,166,.4);
    transition: all .25s cubic-bezier(.4,0,.2,1);
    z-index: 5;
}
.pp-avatar-edit:hover { transform: scale(1.15) rotate(12deg); box-shadow: 0 6px 18px rgba(20,184,166,.5); }
.pp-avatar-edit svg { width:14px; height:14px; }

/* Identity */
.pp-identity { flex:1; padding-bottom:.375rem; min-width:0; }

.pp-name {
    font-family: var(--font-d);
    font-size: 1.75rem; font-weight: 400;
    color: var(--text); margin: 0 0 .375rem;
    letter-spacing: .01em; line-height: 1.15;
}

.pp-meta {
    display: flex; align-items: center; gap: .625rem;
    margin-bottom: .875rem; flex-wrap: wrap;
}

.pp-role-chip {
    display: inline-flex; align-items: center; gap: .375rem;
    padding: .3125rem .75rem;
    background: var(--ind-50); border: 1px solid var(--ind-200);
    border-radius: 9999px;
    font-size: .8125rem; font-weight: 600; color: var(--ind-700);
}
.pp-role-chip svg { width:13px; height:13px; color:var(--ind-500); }

.pp-dept-chip {
    display: inline-flex; align-items: center; gap: .375rem;
    padding: .3125rem .75rem;
    background: var(--bg); border: 1px solid var(--border);
    border-radius: 9999px;
    font-size: .75rem; color: var(--text-2);
}
.pp-dept-chip svg { width:12px; height:12px; color: var(--text-3); }

.pp-badges { display:flex; flex-wrap:wrap; gap:.5rem; }

.pp-badge {
    display: inline-flex; align-items:center; gap:.375rem;
    padding: .3125rem .75rem;
    background: var(--bg); border: 1px solid var(--border);
    border-radius: 9999px;
    font-size: .75rem; font-weight: 600; color: var(--text);
    font-family: var(--font-m);
    transition: all .2s;
}
.pp-badge:hover { border-color:var(--ind-300); background:var(--ind-50); color:var(--ind-700); transform:translateY(-1px); }
.pp-badge svg { width:11px; height:11px; color:var(--ind-400); }
.pp-badge.active { background:var(--teal-50); border-color:var(--teal-300); color:var(--teal-700); }
.pp-badge.active svg { color:var(--teal-500); }

/* Hero Actions */
.pp-actions { display:flex; gap:.5rem; flex-shrink:0; padding-bottom:.375rem; }

.pp-btn {
    display:inline-flex; align-items:center; justify-content:center; gap:.5rem;
    padding: .5625rem 1.125rem; border-radius: var(--r-md);
    font-size: .8125rem; font-weight: 600;
    cursor:pointer; transition: all .25s; border:none;
    text-decoration:none; letter-spacing:.01em;
}
.pp-btn svg { width:14px; height:14px; transition:transform .2s; }
.pp-btn:hover svg { transform:scale(1.1); }
.pp-btn.primary {
    background: linear-gradient(135deg, var(--teal-500), var(--teal-600));
    color:white; box-shadow: 0 4px 16px rgba(20,184,166,.3);
}
.pp-btn.primary:hover { transform:translateY(-2px); box-shadow: 0 8px 24px rgba(20,184,166,.4); }
.pp-btn.ghost {
    background: var(--surface); color:var(--text);
    border: 1px solid var(--border);
}
.pp-btn.ghost:hover { border-color:var(--ind-300); color:var(--ind-700); background:var(--ind-50); }

/* ===== COMPLETION BAR ===== */
@php
    $filled = 0; $total = 6;
    if($personnel->telephone) $filled++;
    if($personnel->adresse) $filled++;
    if($personnel->date_naissance) $filled++;
    if($personnel->numero_identification) $filled++;
    if($personnel->civilite) $filled++;
    if($personnel->photo_url && !str_contains($personnel->photo_url, 'default')) $filled++;
    $pct = round(($filled / $total) * 100);
@endphp
.pp-completion {
    background: var(--surface);
    border-radius: var(--r-xl);
    border: 1px solid var(--border);
    padding: 1.125rem 1.5rem;
    display: flex; align-items: center; gap: 1.5rem;
    box-shadow: var(--shadow-sm);
}
.pp-completion-icon {
    width:44px; height:44px; border-radius:var(--r-md); flex-shrink:0;
    background: linear-gradient(135deg, var(--teal-500), var(--teal-600));
    display:flex; align-items:center; justify-content:center; color:white;
    box-shadow: 0 4px 12px rgba(20,184,166,.25);
}
.pp-completion-icon svg { width:20px; height:20px; }
.pp-completion-text { flex:1; min-width:0; }
.pp-completion-title {
    font-family: var(--font-d); font-size:.9375rem; font-weight:400;
    color:var(--text); margin:0 0 .125rem;
}
.pp-completion-sub { font-size:.75rem; color:var(--text-2); }
.pp-completion-track {
    flex: 1; max-width: 240px;
    display: flex; flex-direction:column; gap:.375rem; align-items:flex-end;
}
.pp-completion-pct {
    font-family: var(--font-d); font-size:1.375rem; font-weight:400;
    color: var(--teal-600); line-height:1;
}
.pp-bar-outer {
    width:100%; height:8px; background:var(--bg);
    border-radius:9999px; border:1px solid var(--border); overflow:hidden;
}
.pp-bar-inner {
    height:100%; border-radius:9999px;
    background: linear-gradient(90deg, var(--teal-400), var(--teal-600));
    width: {{ $pct }}%;
    transition: width 1s cubic-bezier(.4,0,.2,1);
    box-shadow: 0 0 8px rgba(20,184,166,.35);
}

/* ===== STATS ROW ===== */
.pp-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
}

.pp-stat {
    background: var(--surface);
    border-radius: var(--r-lg);
    border: 1px solid var(--border);
    padding: 1.25rem;
    display: flex; flex-direction: column; gap: .875rem;
    position: relative; overflow: hidden;
    transition: all .25s;
    box-shadow: var(--shadow-sm);
}

/* Colored accent bottom bar — always visible */
.pp-stat::after {
    content: '';
    position: absolute; bottom:0; left:0; right:0; height:3px;
    background: var(--stat-c, var(--ind-400));
    opacity: .5; transition: opacity .25s;
}
.pp-stat:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); }
.pp-stat:hover::after { opacity: 1; }

.pp-stat-head { display:flex; align-items:center; justify-content:space-between; }

.pp-stat-icon {
    width:42px; height:42px; border-radius:var(--r-md);
    display:flex; align-items:center; justify-content:center;
    flex-shrink:0; transition: transform .25s;
}
.pp-stat:hover .pp-stat-icon { transform: scale(1.08) rotate(-3deg); }
.pp-stat-icon svg { width:20px; height:20px; }

.pp-stat-badge {
    font-size:.625rem; font-weight:700; letter-spacing:.5px;
    text-transform:uppercase; padding:.25rem .5rem;
    border-radius:9999px;
    background:var(--bg); border:1px solid var(--border); color:var(--text-3);
}

.pp-stat-val {
    font-family: var(--font-d); font-size:2rem; font-weight:400;
    color:var(--text); line-height:1; letter-spacing:-.5px;
}

.pp-stat-lbl {
    font-size:.6875rem; font-weight:600; color:var(--text-2);
    text-transform:uppercase; letter-spacing:.5px; margin-top:.125rem;
}

/* color variants */
.pp-stat-icon.violet { background:linear-gradient(135deg,#7c3aed,#8b5cf6); color:white; box-shadow:0 4px 12px rgba(124,58,237,.25); }
.pp-stat-icon.teal   { background:linear-gradient(135deg,var(--teal-500),var(--teal-600)); color:white; box-shadow:0 4px 12px rgba(20,184,166,.25); }
.pp-stat-icon.indigo { background:linear-gradient(135deg,var(--ind-500),var(--ind-600)); color:white; box-shadow:0 4px 12px rgba(99,102,241,.25); }
.pp-stat-icon.amber  { background:linear-gradient(135deg,#f59e0b,#d97706); color:white; box-shadow:0 4px 12px rgba(245,158,11,.25); }

.pp-stat:has(.violet) { --stat-c: #8b5cf6; }
.pp-stat:has(.teal)   { --stat-c: var(--teal-500); }
.pp-stat:has(.indigo) { --stat-c: var(--ind-500); }
.pp-stat:has(.amber)  { --stat-c: #f59e0b; }

/* ===== GRID ===== */
.pp-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
}
.pp-grid-full { grid-column: 1 / -1; }

/* ===== INFO CARDS ===== */
.pp-card {
    background: var(--surface);
    border-radius: var(--r-xl);
    border: 1px solid var(--border);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    transition: all .3s;
    position: relative;
}

.pp-card::before {
    content:''; position:absolute; top:0; left:0; right:0; height:3px;
    background: var(--cc, var(--ind-500));
    transform: scaleX(0); transform-origin: left;
    transition: transform .35s cubic-bezier(.4,0,.2,1);
}
.pp-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
.pp-card:hover::before { transform: scaleX(1); }
.pp-card:has(.pp-ci-indigo) { --cc: var(--ind-500); }
.pp-card:has(.pp-ci-teal)   { --cc: var(--teal-500); }
.pp-card:has(.pp-ci-amber)  { --cc: #f59e0b; }
.pp-card:has(.pp-ci-violet) { --cc: #7c3aed; }

.pp-card-head {
    display:flex; align-items:center; justify-content:space-between;
    padding: 1.125rem 1.375rem;
    border-bottom: 1px solid var(--border);
}

.pp-card-title {
    display:flex; align-items:center; gap:.75rem;
    font-family: var(--font-d); font-size:.9375rem; font-weight:400;
    color:var(--text); margin:0;
}

.pp-ci {
    width:38px; height:38px; border-radius:var(--r-md);
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.pp-ci svg { width:18px; height:18px; }
.pp-ci-indigo { background:linear-gradient(135deg,var(--ind-500),var(--ind-600)); color:white; box-shadow:0 4px 12px rgba(99,102,241,.2); }
.pp-ci-teal   { background:linear-gradient(135deg,var(--teal-500),var(--teal-600)); color:white; box-shadow:0 4px 12px rgba(20,184,166,.2); }
.pp-ci-amber  { background:linear-gradient(135deg,#f59e0b,#d97706); color:white; box-shadow:0 4px 12px rgba(245,158,11,.2); }
.pp-ci-violet { background:linear-gradient(135deg,#7c3aed,#8b5cf6); color:white; box-shadow:0 4px 12px rgba(124,58,237,.2); }

.pp-card-body { padding: 1.375rem; }

/* ===== FIELDS ===== */
.pp-sec {
    padding-bottom: 1.25rem; margin-bottom: 1.25rem;
    border-bottom: 1px solid var(--border);
}
.pp-sec:last-child { padding-bottom:0; margin-bottom:0; border-bottom:none; }

.pp-sec-title {
    display:flex; align-items:center; gap:.5rem;
    font-size:.6875rem; font-weight:700; color:var(--text-2);
    text-transform:uppercase; letter-spacing:1px;
    margin: 0 0 1rem;
}
.pp-sec-title svg { width:14px; height:14px; padding:2px; background:var(--ind-50); border-radius:4px; color:var(--ind-600); }
.pp-sec-title::after { content:''; flex:1; height:1px; background:var(--border); margin-left:.5rem; }

.pp-fields {
    display: grid; grid-template-columns: repeat(2, 1fr);
    gap: .75rem;
}
.pp-field { display:flex; flex-direction:column; gap:.375rem; }
.pp-field.full { grid-column: span 2; }

.pp-fl {
    display:flex; align-items:center; gap:.375rem;
    font-size:.625rem; font-weight:700; color:var(--text-3);
    text-transform:uppercase; letter-spacing:.8px;
}
.pp-fl svg { width:11px; height:11px; color:var(--ind-400); }

.pp-fv {
    font-size:.8125rem; font-weight:500; color:var(--text);
    padding: .625rem .875rem;
    background: var(--bg); border-radius: var(--r-md);
    border: 1px solid var(--border);
    transition: all .2s; position:relative; overflow:hidden;
    display: flex; align-items: center; gap: .5rem;
}
.pp-fv::before {
    content:''; position:absolute; left:0; top:0; bottom:0; width:3px;
    background: var(--cc, var(--ind-400)); opacity:0; transition:opacity .2s;
    border-radius: 0 2px 2px 0;
}
.pp-fv:hover { border-color:var(--border-2); background:var(--surface); box-shadow:var(--shadow-sm); }
.pp-fv:hover::before { opacity:1; }

.pp-fv.hi {
    background: var(--ind-50); color:var(--ind-800);
    font-weight:600; border-color:var(--ind-200);
    font-family: var(--font-m); font-size:.8rem;
}
.pp-fv.hi::before { opacity:1; }

.pp-fv.em { color:var(--text-3); font-style:italic; }

.pp-fv-icon {
    width:20px; height:20px; border-radius:5px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center;
    background: var(--ind-50); color:var(--ind-500);
}
.pp-fv-icon svg { width:11px; height:11px; }
.pp-fv.hi .pp-fv-icon { background:var(--ind-100); }

/* ===== QUICK ACTIONS ===== */
.pp-actions-grid {
    display: grid; grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}

.pp-action {
    display: flex; flex-direction:column; gap: 1rem;
    padding: 1.5rem 1.25rem;
    background: var(--bg);
    border-radius: var(--r-xl);
    border: 1.5px solid var(--border);
    text-decoration: none; color:var(--text);
    transition: all .25s; position:relative; overflow:hidden;
}

/* color bottom bar on hover */
.pp-action::after {
    content:''; position:absolute; bottom:0; left:0; right:0; height:3px;
    background: var(--ac, var(--ind-500));
    transform: scaleX(0); transition: transform .3s cubic-bezier(.4,0,.2,1);
}
.pp-action:hover { border-color:var(--ind-200); transform:translateY(-4px); box-shadow:var(--shadow-md); background:var(--surface); }
.pp-action:hover::after { transform: scaleX(1); }

.pp-action-top { display:flex; align-items:flex-start; justify-content:space-between; }

.pp-action-icon {
    width:52px; height:52px; border-radius:var(--r-lg);
    display:flex; align-items:center; justify-content:center;
    transition: transform .25s;
}
.pp-action:hover .pp-action-icon { transform: scale(1.08) rotate(-4deg); }
.pp-action-icon svg { width:22px; height:22px; }

.pp-action-arrow {
    width:28px; height:28px; border-radius:var(--r-sm);
    display:flex; align-items:center; justify-content:center;
    background:var(--bg); border:1px solid var(--border); color:var(--text-3);
    transition: all .25s; flex-shrink:0;
}
.pp-action:hover .pp-action-arrow { background:var(--ac,var(--ind-500)); border-color:transparent; color:white; }
.pp-action-arrow svg { width:13px; height:13px; }

.pp-action-label {
    font-size:.875rem; font-weight:700; color:var(--text); margin-bottom:.125rem;
}
.pp-action-desc { font-size:.75rem; color:var(--text-2); line-height:1.4; }

/* ===== MODALS ===== */
.pp-overlay {
    display:none; position:fixed; inset:0;
    background: rgba(15,23,42,.55); backdrop-filter:blur(10px);
    z-index:500; align-items:center; justify-content:center; padding:1rem;
}
.pp-overlay.show { display:flex; }

.pp-modal {
    background: var(--surface); border-radius:var(--r-xl);
    width:100%; max-width:420px; max-height:90vh; overflow:hidden;
    animation: mIn .4s cubic-bezier(.16,1,.3,1);
    box-shadow:0 32px 64px -16px rgba(0,0,0,.22);
    display:flex; flex-direction:column;
    border:1px solid var(--border);
}
@keyframes mIn { from { opacity:0; transform:scale(.96) translateY(16px); } to { opacity:1; transform:none; } }

.pp-modal form { display:flex; flex-direction:column; overflow:hidden; flex:1; min-height:0; }

.pp-mhead {
    background: linear-gradient(135deg, var(--ind-900), var(--ind-700));
    padding: 1.25rem 1.375rem; color:white;
    position:relative; overflow:hidden; flex-shrink:0;
}
/* teal bottom line */
.pp-mhead::after {
    content:''; position:absolute; bottom:0; left:0; right:0; height:3px;
    background: linear-gradient(90deg, var(--teal-400), var(--teal-500));
}
/* grid texture */
.pp-mhead::before {
    content:''; position:absolute; inset:0;
    background:
        linear-gradient(rgba(255,255,255,.025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.025) 1px, transparent 1px);
    background-size:20px 20px;
}
.pp-mtitle {
    font-family:var(--font-d); font-size:1.0625rem; font-weight:400;
    margin:0 0 .25rem; position:relative; z-index:1;
}
.pp-msub { font-size:.75rem; opacity:.7; position:relative; z-index:1; }
.pp-mclose {
    position:absolute; top:.875rem; right:.875rem;
    width:30px; height:30px; border:none; border-radius:var(--r-sm);
    background:rgba(255,255,255,.1); color:rgba(255,255,255,.7);
    cursor:pointer; display:flex; align-items:center; justify-content:center;
    transition:all .2s; z-index:2;
}
.pp-mclose:hover { background:rgba(255,255,255,.2); color:white; transform:rotate(90deg); }
.pp-mclose svg { width:14px; height:14px; }

.pp-mbody {
    padding:1.375rem; overflow-y:auto; flex:1; min-height:0;
    overscroll-behavior:contain; scrollbar-width:thin;
    scrollbar-color:var(--border) transparent;
}
.pp-mbody::-webkit-scrollbar { width:5px; }
.pp-mbody::-webkit-scrollbar-thumb { background:var(--border); border-radius:3px; }

.pp-fg { margin-bottom:1.125rem; }
.pp-fg:last-child { margin-bottom:0; }
.pp-flabel {
    display:block; font-size:.6875rem; font-weight:700; color:var(--text);
    margin-bottom:.5rem; text-transform:uppercase; letter-spacing:.5px;
}
.pp-finput {
    width:100%; padding:.6875rem 1rem;
    border:1px solid var(--border); border-radius:var(--r-md);
    font-size:.8125rem; color:var(--text); background:var(--bg);
    transition:all .2s; font-family:inherit;
}
.pp-finput:focus { outline:none; border-color:var(--teal-400); box-shadow:0 0 0 3px var(--teal-50); background:var(--surface); }
.pp-finput::placeholder { color:var(--text-3); }

.pp-mfoot {
    padding:1rem 1.375rem; border-top:1px solid var(--border);
    display:flex; justify-content:flex-end; gap:.5rem;
    background:var(--bg); flex-shrink:0;
}

/* Upload zone */
.pp-upload {
    border:2px dashed var(--border); border-radius:var(--r-lg);
    padding:1.75rem 1.25rem; text-align:center; cursor:pointer;
    transition:all .25s; background:var(--bg); position:relative;
}
.pp-upload:hover { border-color:var(--teal-400); background:var(--teal-50); }
.pp-upload.dragover { border-color:var(--teal-500); background:var(--teal-50); transform:scale(1.01); }
.pp-upload input[type="file"] { position:absolute; inset:0; opacity:0; cursor:pointer; }
.pp-upload-icon {
    width:52px; height:52px; margin:0 auto .75rem; border-radius:50%;
    background:var(--teal-50); display:flex; align-items:center; justify-content:center;
    color:var(--teal-600); transition:all .25s;
}
.pp-upload:hover .pp-upload-icon { transform:scale(1.08); background:var(--teal-500); color:white; box-shadow:0 4px 12px rgba(20,184,166,.3); }
.pp-upload-icon svg { width:22px; height:22px; }
.pp-upload-text { font-size:.8125rem; font-weight:600; color:var(--text); margin-bottom:.25rem; }
.pp-upload-hint { font-size:.6875rem; color:var(--text-2); }
.pp-preview { display:none; margin-top:1rem; }
.pp-preview.show { display:block; animation:fadeUp .3s ease; }
@keyframes fadeUp { from { opacity:0; transform:scale(.95); } to { opacity:1; transform:none; } }
.pp-preview img { max-width:100px; border-radius:50%; border:3px solid var(--teal-400); box-shadow:0 4px 12px rgba(20,184,166,.2); }

/* ===== RESPONSIVE ===== */
@media (max-width:1100px) {
    .pp-grid { grid-template-columns:1fr; }
    .pp-grid-full { grid-column:1; }
    .pp-stats { grid-template-columns:repeat(2, 1fr); gap:.75rem; }
    .pp-completion { flex-wrap:wrap; }
    .pp-completion-track { max-width:100%; width:100%; align-items:flex-start; }
}
@media (max-width:768px) {
    .pp-hero-body { flex-direction:column; align-items:center; text-align:center; gap:1rem; padding:0 1.25rem 1.25rem; }
    .pp-avatar-ring { width:100px; height:100px; }
    .pp-badges { justify-content:center; }
    .pp-meta { justify-content:center; }
    .pp-actions { width:100%; justify-content:center; }
    .pp-name { font-size:1.375rem; }
    .pp-actions-grid { grid-template-columns:1fr; gap:.75rem; }
    .pp-action { flex-direction:row; align-items:center; padding:1rem 1.125rem; }
    .pp-action-icon { width:44px; height:44px; }
    .pp-action::after { display:none; }
    .pp-cover-label { display:none; }
}
@media (max-width:576px) {
    .pp-cover { height:130px; }
    .pp-hero-body { margin-top:-52px; padding:0 1rem 1rem; }
    .pp-avatar-ring { width:90px; height:90px; }
    .pp-stats { grid-template-columns:1fr 1fr; gap:.5rem; }
    .pp-stat { padding:1rem; }
    .pp-stat-val { font-size:1.5rem; }
    .pp-fields { grid-template-columns:1fr; gap:.625rem; }
    .pp-field.full { grid-column:span 1; }
    .pp-btn { width:100%; }
    .pp-actions { flex-direction:column; }
}
</style>
@endsection

@section('content')

{{-- PHP completude calcul --}}
@php
    $filled = 0; $total = 6;
    if($personnel->telephone) $filled++;
    if($personnel->adresse) $filled++;
    if($personnel->date_naissance) $filled++;
    if($personnel->numero_identification) $filled++;
    if($personnel->civilite) $filled++;
    $photoDefault = str_contains($personnel->photo_url ?? '', 'default') || str_contains($personnel->photo_url ?? '', 'ui-avatars');
    if(!$photoDefault) $filled++;
    $pct = round(($filled / $total) * 100);
@endphp

<div class="profil-page">

    {{-- TOASTS --}}
    @if(session('success'))
    <div class="pp-toast success" id="successToast">
        <div class="pp-toast-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg></div>
        <div class="pp-toast-body">
            <div class="pp-toast-title">Modifications enregistrees</div>
            <div class="pp-toast-msg">{{ session('success') }}</div>
        </div>
        <button class="pp-toast-close" onclick="closeToast('successToast')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        <div class="pp-toast-bar"></div>
    </div>
    @endif
    @if(session('error'))
    <div class="pp-toast error" id="errorToast">
        <div class="pp-toast-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></div>
        <div class="pp-toast-body">
            <div class="pp-toast-title">Erreur</div>
            <div class="pp-toast-msg">{{ session('error') }}</div>
        </div>
        <button class="pp-toast-close" onclick="closeToast('errorToast')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        <div class="pp-toast-bar"></div>
    </div>
    @endif

    {{-- HERO --}}
    <section class="pp-hero">
        <div class="pp-cover">
            <div class="pp-cover-grid"></div>
            <div class="pp-cover-glow"></div>
            <div class="pp-cover-glow"></div>
            <div class="pp-cover-glow"></div>
            <div class="pp-cover-fade"></div>
            @if($personnel->is_active)
            <div class="pp-cover-label">Employe actif</div>
            @endif
        </div>
        <div class="pp-hero-body">
            {{-- Avatar --}}
            <div class="pp-avatar-wrap">
                <div class="pp-avatar-ring">
                    <img src="{{ $personnel->photo_url }}" alt="{{ $personnel->nom_complet }}" class="pp-avatar">
                </div>
                <button class="pp-avatar-edit" onclick="openModal('photoModal')" title="Changer la photo">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                </button>
            </div>

            {{-- Identity --}}
            <div class="pp-identity">
                <h1 class="pp-name">{{ $personnel->nom_complet }}</h1>
                <div class="pp-meta">
                    <span class="pp-role-chip">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                        {{ $personnel->poste ?? 'Poste non defini' }}
                    </span>
                    @if($personnel->departement)
                    <span class="pp-dept-chip">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
                        {{ $personnel->departement->nom }}
                    </span>
                    @endif
                </div>
                <div class="pp-badges">
                    <span class="pp-badge">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line></svg>
                        {{ $personnel->matricule }}
                    </span>
                    <span class="pp-badge">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                        {{ $personnel->type_contrat }}
                    </span>
                    @if($personnel->is_active)
                    <span class="pp-badge active">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        Actif
                    </span>
                    @endif
                </div>
            </div>

            {{-- Actions --}}
            <div class="pp-actions">
                <button class="pp-btn primary" onclick="openModal('editModal')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                    <span>Modifier</span>
                </button>
                <a href="{{ route('espace-employe.parametres') }}" class="pp-btn ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                    Parametres
                </a>
            </div>
        </div>
    </section>

    {{-- COMPLETION BAR --}}
    <div class="pp-completion">
        <div class="pp-completion-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
        </div>
        <div class="pp-completion-text">
            <p class="pp-completion-title">Completude du profil</p>
            <p class="pp-completion-sub">{{ $filled }} / {{ $total }} informations renseignees{{ $pct < 100 ? ' — completez votre profil pour une meilleure visibilite' : ' — profil complet !' }}</p>
        </div>
        <div class="pp-completion-track">
            <span class="pp-completion-pct">{{ $pct }}%</span>
            <div class="pp-bar-outer"><div class="pp-bar-inner" style="width:{{ $pct }}%"></div></div>
        </div>
    </div>

    {{-- STATS --}}
    <div class="pp-stats">
        <div class="pp-stat">
            <div class="pp-stat-head">
                <div class="pp-stat-icon violet">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                </div>
                <span class="pp-stat-badge">Anciennete</span>
            </div>
            <div>
                <div class="pp-stat-val" data-count="{{ $personnel->anciennete ?? 0 }}">{{ $personnel->anciennete ?? 0 }}</div>
                <div class="pp-stat-lbl">Annees dans l'entreprise</div>
            </div>
        </div>
        <div class="pp-stat">
            <div class="pp-stat-head">
                <div class="pp-stat-icon teal">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                </div>
                <span class="pp-stat-badge">Conges</span>
            </div>
            <div>
                <div class="pp-stat-val" data-count="25">25</div>
                <div class="pp-stat-lbl">Jours de solde restants</div>
            </div>
        </div>
        <div class="pp-stat">
            <div class="pp-stat-head">
                <div class="pp-stat-icon indigo">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                </div>
                <span class="pp-stat-badge">Documents</span>
            </div>
            <div>
                <div class="pp-stat-val" data-count="{{ $personnel->documents()->count() }}">{{ $personnel->documents()->count() }}</div>
                <div class="pp-stat-lbl">Fichiers dans mon dossier</div>
            </div>
        </div>
        <div class="pp-stat">
            <div class="pp-stat-head">
                <div class="pp-stat-icon amber">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
                <span class="pp-stat-badge">Age</span>
            </div>
            <div>
                <div class="pp-stat-val" data-count="{{ $personnel->age ?? 0 }}">{{ $personnel->age ?? '—' }}</div>
                <div class="pp-stat-lbl">Annees{{ $personnel->date_naissance ? ' (né le '.$personnel->date_naissance->format('d/m/Y').')' : '' }}</div>
            </div>
        </div>
    </div>

    {{-- MAIN GRID --}}
    <div class="pp-grid">

        {{-- Infos personnelles --}}
        <article class="pp-card">
            <header class="pp-card-head">
                <h2 class="pp-card-title">
                    <span class="pp-ci pp-ci-indigo">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </span>
                    Informations personnelles
                </h2>
            </header>
            <div class="pp-card-body">
                <div class="pp-sec">
                    <h4 class="pp-sec-title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><circle cx="9" cy="10" r="2"></circle><path d="M15 8h2"></path><path d="M15 12h2"></path><path d="M7 16h10"></path></svg>
                        Identite
                    </h4>
                    <div class="pp-fields">
                        <div class="pp-field">
                            <span class="pp-fl">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                Nom
                            </span>
                            <span class="pp-fv">{{ $personnel->nom }}</span>
                        </div>
                        <div class="pp-field">
                            <span class="pp-fl">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                Prenoms
                            </span>
                            <span class="pp-fv">{{ $personnel->prenoms }}</span>
                        </div>
                        <div class="pp-field">
                            <span class="pp-fl">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                Civilite
                            </span>
                            <span class="pp-fv {{ !$personnel->civilite ? 'em' : '' }}">{{ $personnel->civilite ?? 'Non renseigne' }}</span>
                        </div>
                        <div class="pp-field">
                            <span class="pp-fl">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                                Sexe
                            </span>
                            <span class="pp-fv">{{ $personnel->sexe === 'M' ? 'Masculin' : ($personnel->sexe === 'F' ? 'Feminin' : 'Non renseigne') }}</span>
                        </div>
                        <div class="pp-field">
                            <span class="pp-fl">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line></svg>
                                Date de naissance
                            </span>
                            <span class="pp-fv {{ !$personnel->date_naissance ? 'em' : '' }}">{{ $personnel->date_naissance ? $personnel->date_naissance->format('d/m/Y') : 'Non renseignee' }}</span>
                        </div>
                        <div class="pp-field">
                            <span class="pp-fl">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><circle cx="9" cy="10" r="2"></circle><path d="M15 8h2"></path><path d="M15 12h2"></path></svg>
                                N. Identification
                            </span>
                            <span class="pp-fv {{ !$personnel->numero_identification ? 'em' : '' }}">{{ $personnel->numero_identification ?? 'Non renseigne' }}</span>
                        </div>
                    </div>
                </div>

                <div class="pp-sec">
                    <h4 class="pp-sec-title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        Coordonnees
                    </h4>
                    <div class="pp-fields">
                        <div class="pp-field full">
                            <span class="pp-fl">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                Email professionnel
                            </span>
                            <span class="pp-fv hi">{{ $personnel->email }}</span>
                        </div>
                        <div class="pp-field">
                            <span class="pp-fl">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6"></path></svg>
                                Telephone
                            </span>
                            <span class="pp-fv {{ !$personnel->telephone ? 'em' : '' }}">{{ $personnel->telephone_complet ?? 'Non renseigne' }}</span>
                        </div>
                        <div class="pp-field">
                            <span class="pp-fl">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07"></path></svg>
                                Tel. secondaire
                            </span>
                            <span class="pp-fv em">Non renseigne</span>
                        </div>
                        <div class="pp-field full">
                            <span class="pp-fl">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                Adresse
                            </span>
                            <span class="pp-fv {{ !$personnel->adresse ? 'em' : '' }}">{{ $personnel->adresse ?? 'Non renseignee' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </article>

        {{-- Infos professionnelles --}}
        <article class="pp-card">
            <header class="pp-card-head">
                <h2 class="pp-card-title">
                    <span class="pp-ci pp-ci-teal">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                    </span>
                    Informations professionnelles
                </h2>
            </header>
            <div class="pp-card-body">
                <div class="pp-sec">
                    <h4 class="pp-sec-title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        Organisation
                    </h4>
                    <div class="pp-fields">
                        <div class="pp-field full">
                            <span class="pp-fl">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
                                Entreprise
                            </span>
                            <span class="pp-fv hi">{{ $personnel->entreprise->nom ?? 'Non assigne' }}</span>
                        </div>
                        <div class="pp-field">
                            <span class="pp-fl">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect></svg>
                                Departement
                            </span>
                            <span class="pp-fv">{{ $personnel->departement->nom ?? 'Non assigne' }}</span>
                        </div>
                        <div class="pp-field">
                            <span class="pp-fl">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle></svg>
                                Service
                            </span>
                            <span class="pp-fv">{{ $personnel->service->nom ?? 'Non assigne' }}</span>
                        </div>
                    </div>
                </div>

                <div class="pp-sec">
                    <h4 class="pp-sec-title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                        Contrat
                    </h4>
                    <div class="pp-fields">
                        <div class="pp-field full">
                            <span class="pp-fl">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                                Poste occupe
                            </span>
                            <span class="pp-fv hi">{{ $personnel->poste ?? 'Non defini' }}</span>
                        </div>
                        <div class="pp-field">
                            <span class="pp-fl">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                                Type de contrat
                            </span>
                            <span class="pp-fv">{{ $personnel->statut_contrat }}</span>
                        </div>
                        <div class="pp-field">
                            <span class="pp-fl">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line></svg>
                                Date d'embauche
                            </span>
                            <span class="pp-fv {{ !$personnel->date_embauche ? 'em' : '' }}">{{ $personnel->date_embauche ? $personnel->date_embauche->format('d/m/Y') : 'Non renseignee' }}</span>
                        </div>
                        @if($personnel->date_fin_contrat)
                        <div class="pp-field full">
                            <span class="pp-fl">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line></svg>
                                Fin de contrat
                            </span>
                            <span class="pp-fv">{{ $personnel->date_fin_contrat->format('d/m/Y') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </article>

        {{-- Acces rapide -- Full width --}}
        <article class="pp-card pp-grid-full">
            <header class="pp-card-head">
                <h2 class="pp-card-title">
                    <span class="pp-ci pp-ci-amber">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                    </span>
                    Acces rapide
                </h2>
            </header>
            <div class="pp-card-body">
                <div class="pp-actions-grid">

                    <a href="{{ route('espace-employe.documents') }}" class="pp-action" style="--ac: var(--ind-500);">
                        <div class="pp-action-top">
                            <div class="pp-action-icon" style="background:linear-gradient(135deg,var(--ind-500),var(--ind-600));color:white;box-shadow:0 6px 16px rgba(99,102,241,.25);">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                            </div>
                            <div class="pp-action-arrow">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </div>
                        <div>
                            <div class="pp-action-label">Mon dossier</div>
                            <div class="pp-action-desc">Consulter et telecharger mes documents RH</div>
                        </div>
                    </a>

                    <a href="{{ route('espace-employe.bulletins') }}" class="pp-action" style="--ac: var(--teal-500);">
                        <div class="pp-action-top">
                            <div class="pp-action-icon" style="background:linear-gradient(135deg,var(--teal-500),var(--teal-600));color:white;box-shadow:0 6px 16px rgba(20,184,166,.25);">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                            </div>
                            <div class="pp-action-arrow">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </div>
                        <div>
                            <div class="pp-action-label">Bulletins de paie</div>
                            <div class="pp-action-desc">Acceder a mes fiches de remuneration</div>
                        </div>
                    </a>

                    <a href="{{ route('espace-employe.parametres') }}" class="pp-action" style="--ac: #7c3aed;">
                        <div class="pp-action-top">
                            <div class="pp-action-icon" style="background:linear-gradient(135deg,#7c3aed,#8b5cf6);color:white;box-shadow:0 6px 16px rgba(124,58,237,.25);">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                            </div>
                            <div class="pp-action-arrow">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </div>
                        <div>
                            <div class="pp-action-label">Securite du compte</div>
                            <div class="pp-action-desc">Mot de passe, 2FA et confidentialite</div>
                        </div>
                    </a>

                </div>
            </div>
        </article>

    </div><!-- /pp-grid -->
</div><!-- /profil-page -->

{{-- MODAL EDIT --}}
<div class="pp-overlay" id="editModal">
    <div class="pp-modal">
        <div class="pp-mhead">
            <h3 class="pp-mtitle">Modifier mes informations</h3>
            <p class="pp-msub">Mettez a jour vos coordonnees personnelles</p>
            <button class="pp-mclose" onclick="closeModal('editModal')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        </div>
        <form action="{{ route('espace-employe.profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="pp-mbody">
                <div class="pp-fg">
                    <label class="pp-flabel">Numero de telephone</label>
                    <input type="text" name="telephone" class="pp-finput" value="{{ $personnel->telephone }}" placeholder="Ex: 07 08 09 10 11">
                </div>
                <div class="pp-fg">
                    <label class="pp-flabel">Adresse de residence</label>
                    <input type="text" name="adresse" class="pp-finput" value="{{ $personnel->adresse }}" placeholder="Ex: Cocody, Abidjan">
                </div>
            </div>
            <div class="pp-mfoot">
                <button type="button" class="pp-btn ghost" onclick="closeModal('editModal')">Annuler</button>
                <button type="submit" class="pp-btn primary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL PHOTO --}}
<div class="pp-overlay" id="photoModal">
    <div class="pp-modal">
        <div class="pp-mhead">
            <h3 class="pp-mtitle">Modifier ma photo</h3>
            <p class="pp-msub">Choisissez une nouvelle photo de profil</p>
            <button class="pp-mclose" onclick="closeModal('photoModal')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        </div>
        <form action="{{ route('espace-employe.profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="pp-mbody">
                <label class="pp-upload" id="uploadZone">
                    <input type="file" name="photo" accept="image/*" onchange="previewPhoto(this)">
                    <div class="pp-upload-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                    </div>
                    <div class="pp-upload-text">Cliquez ou glissez-deposez votre photo</div>
                    <div class="pp-upload-hint">JPG, PNG — Max 2 Mo</div>
                </label>
                <div class="pp-preview" id="photoPreview">
                    <img id="previewImage" src="" alt="Apercu">
                </div>
            </div>
            <div class="pp-mfoot">
                <button type="button" class="pp-btn ghost" onclick="closeModal('photoModal')">Annuler</button>
                <button type="submit" class="pp-btn primary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                    Changer la photo
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
function openModal(id)  { const m = document.getElementById(id); if(m){ m.classList.add('show'); document.body.style.overflow='hidden'; } }
function closeModal(id) { const m = document.getElementById(id); if(m){ m.classList.remove('show'); document.body.style.overflow=''; } }

function closeToast(id) {
    const t = document.getElementById(id);
    if(t){ t.classList.add('hiding'); setTimeout(() => t.remove(), 300); }
}
document.querySelectorAll('.pp-toast').forEach(t => {
    setTimeout(() => { t.classList.add('hiding'); setTimeout(() => t.remove(), 300); }, 5000);
});

function previewPhoto(input) {
    if(input.files && input.files[0]) {
        const r = new FileReader();
        r.onload = e => { document.getElementById('previewImage').src = e.target.result; document.getElementById('photoPreview').classList.add('show'); };
        r.readAsDataURL(input.files[0]);
    }
}

const uz = document.getElementById('uploadZone');
if(uz) {
    ['dragover','dragenter'].forEach(t => uz.addEventListener(t, e => { e.preventDefault(); uz.classList.add('dragover'); }));
    ['dragleave','dragend','drop'].forEach(t => uz.addEventListener(t, e => { e.preventDefault(); uz.classList.remove('dragover'); }));
    uz.addEventListener('drop', e => {
        const f = e.dataTransfer.files[0];
        if(f && f.type.startsWith('image/')) {
            const inp = uz.querySelector('input[type="file"]');
            const dt = new DataTransfer(); dt.items.add(f); inp.files = dt.files;
            previewPhoto(inp);
        }
    });
}

document.querySelectorAll('.pp-overlay').forEach(o => o.addEventListener('click', e => {
    if(e.target === o) { o.classList.remove('show'); document.body.style.overflow=''; }
}));

document.addEventListener('keydown', e => {
    if(e.key === 'Escape') { document.querySelectorAll('.pp-overlay.show').forEach(m => m.classList.remove('show')); document.body.style.overflow=''; }
});

/* Counter animation on stats */
document.querySelectorAll('.pp-stat-val[data-count]').forEach(el => {
    const target = parseInt(el.dataset.count) || 0;
    if(target === 0 || isNaN(target)) return;
    let current = 0;
    const step = Math.max(1, Math.floor(target / 30));
    const timer = setInterval(() => {
        current = Math.min(current + step, target);
        el.textContent = current;
        if(current >= target) clearInterval(timer);
    }, 30);
});
</script>
@endsection
