@extends('layouts.app')

@section('title', 'Gestion des Absences')
@section('page-title', 'Gestion des Absences')
@section('page-subtitle', 'Suivi et enregistrement des absences')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <circle cx="12" cy="12" r="10"></circle>
    <line x1="15" y1="9" x2="9" y2="15"></line>
    <line x1="9" y1="9" x2="15" y2="15"></line>
</svg>
@endsection

@section('styles')
<style>
/* ================================================
   ABSENCES — Design System (Indigo × Teal charter)
   ================================================ */
:root {
    --ab-primary: #6366f1;
    --ab-primary-dark: #4338ca;
    --ab-primary-light: #eef2ff;
    --ab-teal: #14b8a6;
    --ab-teal-dark: #0d9488;
    --ab-teal-light: #f0fdfa;
    --ab-accent: #8b5cf6;
    --ab-accent-light: #f3e8ff;
    --ab-success: #10b981;
    --ab-success-light: #ecfdf5;
    --ab-danger: #ef4444;
    --ab-danger-light: #fef2f2;
    --ab-warning: #f59e0b;
    --ab-warning-light: #fffbeb;
    --ab-bg: #f8fafc;
    --ab-card-bg: #ffffff;
    --ab-card-border: #e2e8f0;
    --ab-text-primary: #1e293b;
    --ab-text-secondary: #64748b;
    --ab-text-muted: #94a3b8;
    --ab-shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
    --ab-shadow: 0 4px 6px -1px rgba(0,0,0,0.08), 0 2px 4px -1px rgba(0,0,0,0.04);
    --ab-shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.08), 0 4px 6px -2px rgba(0,0,0,0.04);
    --ab-shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.10), 0 10px 10px -5px rgba(0,0,0,0.04);
    --ab-radius: 12px;
    --ab-radius-lg: 16px;
}
.dark {
    --ab-bg: #0f172a;
    --ab-card-bg: #1e293b;
    --ab-card-border: #334155;
    --ab-text-primary: #f1f5f9;
    --ab-text-secondary: #94a3b8;
    --ab-text-muted: #64748b;
    --ab-primary-light: rgba(99,102,241,0.15);
    --ab-teal-light: rgba(20,184,166,0.15);
    --ab-accent-light: rgba(139,92,246,0.15);
    --ab-success-light: rgba(16,185,129,0.15);
    --ab-danger-light: rgba(239,68,68,0.15);
    --ab-warning-light: rgba(245,158,11,0.15);
}

/* Animations */
@keyframes ab-fadeIn   { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
@keyframes ab-scaleIn  { from { opacity:0; transform:scale(0.95); }       to { opacity:1; transform:scale(1); } }
@keyframes ab-countUp  { from { opacity:0; transform:translateY(8px); }   to { opacity:1; transform:translateY(0); } }

/* Page */
.absences-page { padding: 0; animation: ab-fadeIn 0.45s ease-out; }

/* ── STAT CARDS ── */
.ab-stats {
    display: grid; grid-template-columns: repeat(5,1fr);
    gap: 18px; margin-bottom: 24px;
}
.ab-stat-card {
    background: white; border-radius: 16px; padding: 20px 22px;
    position: relative; overflow: hidden;
    border: 1px solid var(--ab-card-border);
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
    animation: ab-fadeIn 0.5s ease-out backwards;
}
.dark .ab-stat-card { background: var(--ab-card-bg); }
.ab-stat-card:nth-child(1) { animation-delay:.07s }
.ab-stat-card:nth-child(2) { animation-delay:.14s }
.ab-stat-card:nth-child(3) { animation-delay:.21s }
.ab-stat-card:nth-child(4) { animation-delay:.28s }
.ab-stat-card:nth-child(5) { animation-delay:.35s }
.ab-stat-card:hover { transform:translateY(-4px); box-shadow:var(--ab-shadow-xl); }
.ab-stat-card::before {
    content:''; position:absolute; top:0; left:0; right:0; height:4px;
    border-radius:16px 16px 0 0;
}
.ab-stat-card.total::before      { background:linear-gradient(90deg,#4338ca,#6366f1); }
.ab-stat-card.justified::before  { background:linear-gradient(90deg,#0d9488,#14b8a6); }
.ab-stat-card.unjustified::before{ background:linear-gradient(90deg,#dc2626,#ef4444); }
.ab-stat-card.late::before       { background:linear-gradient(90deg,#d97706,#f59e0b); }
.ab-stat-card.pending::before    { background:linear-gradient(90deg,#7c3aed,#8b5cf6); }

.ab-stat-header { display:flex; justify-content:space-between; align-items:flex-start; }
.ab-stat-content { flex:1; }
.ab-stat-value {
    font-size: 2.125rem; font-weight:800; line-height:1; margin-bottom:5px;
    -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent;
    animation: ab-countUp 0.6s ease-out backwards;
}
.ab-stat-card.total      .ab-stat-value { background:linear-gradient(135deg,#4338ca,#6366f1); }
.ab-stat-card.justified  .ab-stat-value { background:linear-gradient(135deg,#0d9488,#14b8a6); }
.ab-stat-card.unjustified .ab-stat-value{ background:linear-gradient(135deg,#dc2626,#ef4444); }
.ab-stat-card.late       .ab-stat-value { background:linear-gradient(135deg,#d97706,#f59e0b); }
.ab-stat-card.pending    .ab-stat-value { background:linear-gradient(135deg,#7c3aed,#8b5cf6); }
.ab-stat-label {
    font-size:0.8125rem; font-weight:600; color:var(--ab-text-secondary);
    text-transform:uppercase; letter-spacing:0.4px;
}
.ab-stat-icon {
    width:50px; height:50px; border-radius:13px; display:flex;
    align-items:center; justify-content:center; flex-shrink:0;
}
.ab-stat-icon svg { width:24px; height:24px; stroke-width:2; }
.ab-stat-card.total      .ab-stat-icon { background:linear-gradient(135deg,rgba(99,102,241,.15),rgba(99,102,241,.05)); color:#6366f1; }
.ab-stat-card.justified  .ab-stat-icon { background:linear-gradient(135deg,rgba(20,184,166,.15),rgba(20,184,166,.05)); color:#0d9488; }
.ab-stat-card.unjustified .ab-stat-icon{ background:linear-gradient(135deg,rgba(239,68,68,.15),rgba(239,68,68,.05));  color:#ef4444; }
.ab-stat-card.late       .ab-stat-icon { background:linear-gradient(135deg,rgba(245,158,11,.15),rgba(245,158,11,.05)); color:#f59e0b; }
.ab-stat-card.pending    .ab-stat-icon { background:linear-gradient(135deg,rgba(139,92,246,.15),rgba(139,92,246,.05)); color:#8b5cf6; }

/* ── TOOLBAR ── */
.ab-toolbar {
    display:flex; justify-content:space-between; align-items:center; gap:16px;
    margin-bottom:22px; background:white; padding:14px 18px;
    border-radius:14px; border:1px solid var(--ab-card-border);
    box-shadow:var(--ab-shadow-sm); flex-wrap:wrap;
    animation: ab-fadeIn 0.5s ease-out 0.3s backwards;
}
.dark .ab-toolbar { background:var(--ab-card-bg); }
.ab-toolbar-left  { display:flex; align-items:center; gap:10px; flex:1; flex-wrap:wrap; }
.ab-toolbar-right { display:flex; align-items:center; gap:10px; flex-shrink:0; }

.ab-search-box { position:relative; min-width:220px; }
.ab-search-box input {
    width:100%; padding:9px 14px 9px 40px; border:1px solid var(--ab-card-border);
    border-radius:10px; font-size:0.9rem; background:var(--ab-bg); color:var(--ab-text-primary);
    transition:all 0.2s; box-sizing:border-box;
}
.ab-search-box input:focus { outline:none; border-color:#6366f1; background:white; box-shadow:0 0 0 3px rgba(99,102,241,0.1); }
.dark .ab-search-box input:focus { background:var(--ab-bg); }
.ab-search-box input::placeholder { color:var(--ab-text-muted); }
.ab-search-icon { position:absolute; left:13px; top:50%; transform:translateY(-50%); color:var(--ab-text-muted); pointer-events:none; }
.ab-search-icon svg { width:16px; height:16px; }

.ab-filter-select {
    padding:8px 12px; border:1px solid var(--ab-card-border); border-radius:10px;
    font-size:0.875rem; background:var(--ab-bg); color:var(--ab-text-primary);
    cursor:pointer; transition:all 0.2s; font-family:inherit;
}
.ab-filter-select:focus { outline:none; border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,0.1); }

.ab-btn-filter {
    padding:9px 18px; background:linear-gradient(135deg,#4338ca,#6366f1); color:white;
    border:none; border-radius:10px; font-size:0.875rem; font-weight:600;
    cursor:pointer; display:flex; align-items:center; gap:6px;
    box-shadow:0 2px 8px rgba(99,102,241,0.28); transition:all 0.2s;
}
.ab-btn-filter:hover { transform:translateY(-1px); box-shadow:0 4px 14px rgba(99,102,241,0.38); }
.ab-btn-filter svg { width:15px; height:15px; }

.ab-btn-reset {
    padding:9px 16px; background:white; color:var(--ab-text-secondary);
    border:1px solid var(--ab-card-border); border-radius:10px; font-size:0.875rem;
    font-weight:500; cursor:pointer; text-decoration:none; transition:all 0.2s;
    display:flex; align-items:center; gap:6px;
}
.dark .ab-btn-reset { background:var(--ab-bg); }
.ab-btn-reset:hover { border-color:#6366f1; color:#6366f1; }

.ab-btn-add {
    padding:9px 18px; background:linear-gradient(135deg,#0d9488,#14b8a6); color:white;
    border:none; border-radius:10px; font-size:0.875rem; font-weight:700;
    cursor:pointer; display:flex; align-items:center; gap:7px;
    box-shadow:0 2px 8px rgba(20,184,166,0.30); transition:all 0.3s;
}
.ab-btn-add:hover { transform:translateY(-2px); box-shadow:0 6px 18px rgba(20,184,166,0.40); }
.ab-btn-add svg { width:17px; height:17px; }

/* ── TABLE CARD ── */
.ab-table-card {
    background:white; border:1px solid var(--ab-card-border);
    border-radius:16px; overflow:hidden; box-shadow:var(--ab-shadow);
    animation: ab-scaleIn 0.4s ease-out 0.4s backwards;
}
.dark .ab-table-card { background:var(--ab-card-bg); }
.ab-table-header {
    display:flex; align-items:center; justify-content:space-between;
    padding:18px 22px; border-bottom:1px solid var(--ab-card-border);
    background:linear-gradient(135deg,rgba(99,102,241,0.04),rgba(20,184,166,0.03));
}
.ab-table-title {
    font-size:1rem; font-weight:700; color:var(--ab-text-primary);
    display:flex; align-items:center; gap:9px;
}
.ab-table-title-dot {
    width:8px; height:8px; border-radius:50%;
    background:linear-gradient(135deg,#6366f1,#14b8a6); flex-shrink:0;
}
.ab-table-count {
    font-size:0.8125rem; color:var(--ab-text-secondary);
    background:var(--ab-primary-light); color:#4338ca;
    padding:4px 12px; border-radius:20px; font-weight:600;
}
.dark .ab-table-count { background:rgba(99,102,241,0.15); color:#818cf8; }
.ab-table-wrap { overflow-x:auto; }
.ab-table { width:100%; border-collapse:collapse; }
.ab-table th {
    padding:11px 18px; text-align:left; font-size:0.6875rem; font-weight:700;
    color:var(--ab-text-muted); text-transform:uppercase; letter-spacing:0.6px;
    background:var(--ab-bg); border-bottom:1px solid var(--ab-card-border); white-space:nowrap;
}
.ab-table td {
    padding:14px 18px; font-size:0.9375rem; color:var(--ab-text-primary);
    border-bottom:1px solid var(--ab-card-border); vertical-align:middle;
}
.ab-table tr:last-child td { border-bottom:none; }
.ab-table tbody tr { transition:background 0.15s; }
.ab-table tbody tr:hover td { background:rgba(99,102,241,0.025); }
.dark .ab-table tbody tr:hover td { background:rgba(99,102,241,0.06); }

/* Employee cell */
.ab-employee { display:flex; align-items:center; gap:11px; }
.ab-employee-avatar {
    width:42px; height:42px; border-radius:11px; object-fit:cover;
    border:2px solid var(--ab-card-border); flex-shrink:0;
}
.ab-employee-name { font-weight:700; color:var(--ab-text-primary); font-size:0.9375rem; line-height:1.3; }
.ab-employee-matricule {
    font-size:0.75rem; color:var(--ab-text-muted); font-family:'DM Mono',monospace;
    background:var(--ab-bg); padding:1px 6px; border-radius:4px; display:inline-block; margin-top:2px;
}

/* Badges */
.ab-type-badge {
    display:inline-flex; align-items:center;
    padding:4px 10px; border-radius:7px;
    font-size:0.8125rem; font-weight:600; white-space:nowrap;
}
.ab-justif {
    display:inline-flex; align-items:center; gap:4px;
    padding:4px 10px; border-radius:20px; font-size:0.75rem; font-weight:700;
}
.ab-justif.oui { background:#ecfdf5; color:#059669; }
.ab-justif.non { background:#fef2f2; color:#dc2626; }
.dark .ab-justif.oui { background:rgba(16,185,129,0.15); color:#34d399; }
.dark .ab-justif.non { background:rgba(239,68,68,0.15); color:#f87171; }

.ab-source {
    display:inline-flex; align-items:center; gap:4px;
    padding:4px 10px; border-radius:20px;
    font-size:0.75rem; font-weight:600; white-space:nowrap;
}
.ab-source.admin   { background:#eef2ff; color:#4338ca; }
.ab-source.employe { background:#f3e8ff; color:#7c3aed; }
.dark .ab-source.admin   { background:rgba(99,102,241,0.15); color:#818cf8; }
.dark .ab-source.employe { background:rgba(139,92,246,0.15); color:#a78bfa; }

.ab-statut {
    display:inline-flex; align-items:center; gap:4px;
    padding:4px 10px; border-radius:20px;
    font-size:0.75rem; font-weight:700; white-space:nowrap;
}
.ab-statut.en-attente  { background:#fffbeb; color:#d97706; }
.ab-statut.valide-chef { background:#eff6ff; color:#2563eb; }
.ab-statut.approuvee   { background:#ecfdf5; color:#059669; }
.ab-statut.refusee     { background:#fef2f2; color:#dc2626; }
.dark .ab-statut.en-attente  { background:rgba(245,158,11,0.15); color:#fbbf24; }
.dark .ab-statut.valide-chef { background:rgba(59,130,246,0.15); color:#60a5fa; }
.dark .ab-statut.approuvee   { background:rgba(16,185,129,0.15); color:#34d399; }
.dark .ab-statut.refusee     { background:rgba(239,68,68,0.15); color:#f87171; }

/* Action buttons */
.ab-actions { display:flex; gap:6px; flex-wrap:wrap; }
.ab-btn {
    padding:6px 12px; border:none; border-radius:8px; font-size:0.8125rem; font-weight:600;
    cursor:pointer; display:inline-flex; align-items:center; gap:4px; white-space:nowrap;
    transition:all 0.15s;
}
.ab-btn svg { width:13px; height:13px; }
.ab-btn-toggle  { background:#ecfdf5; color:#059669; }
.ab-btn-toggle:hover  { background:#10b981; color:white; }
.ab-btn-delete  { background:#fef2f2; color:#dc2626; }
.ab-btn-delete:hover  { background:#ef4444; color:white; }
.ab-btn-approve { background:#ecfdf5; color:#059669; }
.ab-btn-approve:hover { background:#10b981; color:white; }
.ab-btn-reject  { background:#fef2f2; color:#dc2626; }
.ab-btn-reject:hover  { background:#ef4444; color:white; }

.ab-justif-link {
    display:inline-flex; align-items:center; gap:3px;
    font-size:0.75rem; color:#6366f1; text-decoration:none; font-weight:600;
}
.ab-justif-link:hover { text-decoration:underline; }
.ab-justif-link svg { width:11px; height:11px; }

/* Empty state */
.ab-empty { text-align:center; padding:4.5rem 2rem; }
.ab-empty-icon {
    width:72px; height:72px; margin:0 auto 1rem; border-radius:50%;
    background:linear-gradient(135deg,#eef2ff,#f0fdfa);
    display:flex; align-items:center; justify-content:center; color:#6366f1;
}
.ab-empty-icon svg { width:34px; height:34px; }
.ab-empty-title { font-size:1.125rem; font-weight:700; color:var(--ab-text-primary); margin-bottom:6px; }
.ab-empty-text  { font-size:0.9rem; color:var(--ab-text-secondary); }

/* Flash */
.ab-flash { padding:1rem 1.25rem; border-radius:12px; font-size:0.9375rem; font-weight:500; margin-bottom:20px; display:flex; align-items:center; gap:10px; }
.ab-flash-success { background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0; }
.ab-flash-error   { background:#fef2f2; color:#991b1b; border:1px solid #fecaca; }

/* Pagination */
.ab-pagination { display:flex; align-items:center; justify-content:center; padding:18px; gap:4px; }
.ab-pagination a,.ab-pagination span { padding:7px 13px; border-radius:9px; font-size:0.875rem; font-weight:500; text-decoration:none; color:var(--ab-text-secondary); }
.ab-pagination a:hover { background:var(--ab-primary-light); color:#4338ca; }
.ab-pagination .active span { background:linear-gradient(135deg,#4338ca,#6366f1); color:white; box-shadow:0 2px 8px rgba(99,102,241,0.3); }
.ab-pagination .disabled span { opacity:0.4; }

/* Responsive */
@media (max-width:1280px) { .ab-stats { grid-template-columns:repeat(3,1fr); } }
@media (max-width:900px)  { .ab-stats { grid-template-columns:repeat(2,1fr); } }
@media (max-width:640px)  { .ab-stats { grid-template-columns:1fr; } .ab-toolbar { flex-direction:column; align-items:stretch; } }

/* ── MODAL ── */
@keyframes ab-modal-in {
    from { opacity: 0; transform: translateY(20px) scale(0.97); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}
@keyframes ab-overlay-in {
    from { opacity: 0; }
    to   { opacity: 1; }
}
.ab-modal-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(15, 23, 42, 0.72);
    backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px);
    z-index: 1000; align-items: center; justify-content: center; padding: 1rem;
}
.ab-modal-overlay.active { display: flex; animation: ab-overlay-in 0.18s ease; }

/* Flex-column so header+footer never scroll away */
.ab-modal {
    background: var(--ab-card-bg); border-radius: 16px; width: 100%; max-width: 580px;
    box-shadow: 0 24px 60px rgba(0,0,0,0.35), 0 0 0 1px rgba(99,102,241,0.18);
    display: flex; flex-direction: column; max-height: 88vh; overflow: hidden;
    animation: ab-modal-in 0.22s cubic-bezier(0.34,1.56,0.64,1);
}
/* ── Le form enveloppant body+footer doit aussi être flex-column ── */
.ab-modal > form {
    display: flex; flex-direction: column; flex: 1; min-height: 0; overflow: hidden;
}

/* Header coloré indigo */
.ab-modal-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 0; flex-shrink: 0;
    background: linear-gradient(135deg, #312e81 0%, #4338ca 60%, #1d4ed8 100%);
}
.ab-modal-header-inner {
    flex: 1; display: flex; align-items: center; gap: 0.875rem; padding: 1.25rem 1.375rem;
}
.ab-modal-header-icon {
    width: 42px; height: 42px; border-radius: 11px; display: flex;
    align-items: center; justify-content: center; flex-shrink: 0;
    background: rgba(255,255,255,0.15); color: #ffffff;
    backdrop-filter: blur(4px);
}
.ab-modal-header-icon svg { width: 20px; height: 20px; stroke: #ffffff; }
.ab-modal-header-text { flex: 1; }
.ab-modal-title { font-size: 1.0625rem; font-weight: 700; color: #ffffff; margin: 0; line-height: 1.3; }
.ab-modal-subtitle { font-size: 0.8125rem; color: rgba(255,255,255,0.65); margin: 2px 0 0; }
.ab-modal-close {
    width: 36px; height: 36px; border-radius: 10px; border: none;
    background: rgba(255,255,255,0.10); cursor: pointer; display: flex; align-items: center;
    justify-content: center; color: rgba(255,255,255,0.7); margin-right: 1rem;
    transition: background 0.15s, color 0.15s; flex-shrink: 0;
}
.ab-modal-close:hover { background: rgba(255,255,255,0.22); color: #ffffff; }
.ab-modal-close svg { width: 16px; height: 16px; stroke: currentColor; }

/* Barre gradient — override couleur par contexte */
.ab-modal-header-bar { height: 4px; flex-shrink: 0; }
.ab-modal-header-bar-indigo { background: linear-gradient(90deg, #312e81, #6366f1, #14b8a6); }
.ab-modal-header-bar-teal   { background: linear-gradient(90deg, #0d9488, #14b8a6, #6366f1); }
.ab-modal-header-bar-red    { background: linear-gradient(90deg, #dc2626, #ef4444, #f97316); }

/* Header teal (approve) */
.ab-modal-header-teal {
    background: linear-gradient(135deg, #0f766e 0%, #0d9488 60%, #14b8a6 100%);
}
/* Header rouge (reject) */
.ab-modal-header-red {
    background: linear-gradient(135deg, #991b1b 0%, #dc2626 60%, #ef4444 100%);
}

/* Body scrollable — header et footer fixes */
.ab-modal-body { padding: 1.375rem; overflow-y: auto; flex: 1; min-height: 0; background: var(--ab-card-bg); }
.ab-modal-footer {
    padding: 1rem 1.375rem; border-top: 1px solid var(--ab-card-border);
    display: flex; justify-content: flex-end; gap: 0.625rem;
    background: var(--ab-bg); flex-shrink: 0;
}

/* Form elements */
.ab-form-group { margin-bottom: 1.125rem; }
.ab-form-label {
    display: block; font-size: 0.8125rem; font-weight: 600;
    color: var(--ab-text-secondary); margin-bottom: 0.4375rem; letter-spacing: 0.01em;
}
.ab-form-input, .ab-form-select, .ab-form-textarea {
    width: 100%; padding: 0.6875rem 1rem; background: #f8fafc;
    border: 1.5px solid #e2e8f0; border-radius: 10px;
    font-size: 0.9375rem; color: #1e293b; box-sizing: border-box;
    transition: border-color 0.15s, box-shadow 0.15s; font-family: inherit;
    appearance: none; -webkit-appearance: none;
}
.dark .ab-form-input, .dark .ab-form-select, .dark .ab-form-textarea {
    background: #0f172a; border-color: #334155; color: #f1f5f9;
}
.ab-form-input:focus, .ab-form-select:focus, .ab-form-textarea:focus {
    outline: none; border-color: #6366f1; background: #ffffff;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.14);
}
.dark .ab-form-input:focus, .dark .ab-form-select:focus, .dark .ab-form-textarea:focus {
    background: #1e293b; border-color: #818cf8;
}
.ab-form-textarea { resize: vertical; min-height: 80px; }
.ab-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 0.875rem; }
.ab-form-hint { font-size: 0.75rem; color: var(--ab-text-muted); margin-top: 0.3rem; }
/* File input */
.ab-form-file-wrap {
    position: relative; border: 1.5px dashed var(--ab-card-border); border-radius: 10px;
    padding: 0.875rem 1rem; background: var(--ab-bg); cursor: pointer;
    transition: border-color 0.15s;
}
.ab-form-file-wrap:hover { border-color: var(--ab-primary); }
.ab-form-file-wrap input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; }
.ab-form-file-label {
    display: flex; align-items: center; gap: 0.625rem; pointer-events: none;
    font-size: 0.875rem; color: var(--ab-text-muted);
}
.ab-form-file-label svg { width: 18px; height: 18px; color: var(--ab-primary); flex-shrink: 0; }
/* Custom checkbox */
.ab-checkbox-wrap { display: flex; align-items: center; gap: 0.625rem; padding: 0.75rem 1rem; background: var(--ab-bg); border-radius: 10px; border: 1.5px solid var(--ab-card-border); cursor: pointer; }
.ab-checkbox-wrap input[type="checkbox"] { width: 18px; height: 18px; accent-color: var(--ab-success); cursor: pointer; }
.ab-checkbox-wrap label { font-size: 0.9375rem; font-weight: 600; color: var(--ab-text-primary); cursor: pointer; margin: 0; }

/* Searchable Select */
.ab-search-select { position: relative; }
.ab-search-select .ab-search-input {
    width: 100%; padding: 0.6875rem 1rem 0.6875rem 2.375rem; background: var(--ab-bg);
    border: 1.5px solid var(--ab-card-border); border-radius: 10px;
    font-size: 0.9375rem; color: var(--ab-text-primary); box-sizing: border-box;
    transition: border-color 0.15s, box-shadow 0.15s;
}
.ab-search-select .ab-search-input:focus {
    outline: none; border-color: var(--ab-primary);
    box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
}
.ab-search-select .ab-search-icon {
    position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%);
    width: 16px; height: 16px; color: var(--ab-text-muted); pointer-events: none;
}
.ab-search-select .ab-search-clear {
    position: absolute; right: 0.625rem; top: 50%; transform: translateY(-50%);
    width: 22px; height: 22px; border: none; background: var(--ab-card-border); cursor: pointer;
    color: var(--ab-text-secondary); display: none; padding: 0; border-radius: 50%;
    font-size: 14px; line-height: 22px; text-align: center;
}
.ab-search-select .ab-search-clear:hover { background: var(--ab-primary); color: white; }
.ab-search-dropdown {
    display: none; position: absolute; top: calc(100% + 4px); left: 0; right: 0;
    background: var(--ab-card-bg); border: 1.5px solid var(--ab-card-border);
    border-radius: 12px; max-height: 230px; overflow-y: auto; z-index: 200;
    box-shadow: 0 12px 32px rgba(99,102,241,0.15), 0 2px 8px rgba(0,0,0,0.08);
}
.ab-search-option {
    padding: 0.6875rem 1rem; cursor: pointer; font-size: 0.9375rem;
    color: var(--ab-text-primary); transition: background 0.1s; border-radius: 0;
    display: flex; flex-direction: column; gap: 1px;
}
.ab-search-option:hover, .ab-search-option.highlighted { background: var(--ab-primary-light); }
.ab-search-option .ab-opt-sub { color: var(--ab-text-muted); font-size: 0.8125rem; }
.ab-search-no-results {
    padding: 1rem; color: var(--ab-text-muted); font-style: italic;
    font-size: 0.875rem; text-align: center; display: none;
}

/* Buttons */
.ab-modal-btn-cancel {
    padding: 0.625rem 1.25rem; background: var(--ab-bg);
    border: 1.5px solid var(--ab-card-border); border-radius: 10px;
    font-size: 0.875rem; font-weight: 600; color: var(--ab-text-secondary);
    cursor: pointer; transition: border-color 0.15s, color 0.15s;
}
.ab-modal-btn-cancel:hover { border-color: var(--ab-primary); color: var(--ab-primary); }
.ab-modal-btn-confirm {
    padding: 0.625rem 1.375rem; border: none; border-radius: 10px;
    font-size: 0.875rem; font-weight: 700; color: white; cursor: pointer;
    background: linear-gradient(135deg, #4338ca, #6366f1);
    box-shadow: 0 2px 8px rgba(99,102,241,0.30); transition: opacity 0.15s, box-shadow 0.15s;
}
.ab-modal-btn-confirm:hover { opacity: 0.92; box-shadow: 0 4px 14px rgba(99,102,241,0.40); }
.ab-modal-btn-confirm-teal {
    padding: 0.625rem 1.375rem; border: none; border-radius: 10px;
    font-size: 0.875rem; font-weight: 700; color: white; cursor: pointer;
    background: linear-gradient(135deg, #0d9488, #14b8a6);
    box-shadow: 0 2px 8px rgba(20,184,166,0.30); transition: opacity 0.15s;
}
.ab-modal-btn-confirm-teal:hover { opacity: 0.92; }
.ab-modal-btn-reject {
    padding: 0.625rem 1.375rem; border: none; border-radius: 10px;
    font-size: 0.875rem; font-weight: 700; color: white; cursor: pointer;
    background: linear-gradient(135deg, #dc2626, #ef4444);
    box-shadow: 0 2px 8px rgba(239,68,68,0.28); transition: opacity 0.15s;
}
.ab-modal-btn-reject:hover { opacity: 0.92; }

/* Approve / info card in modal */
.ab-modal-info-card {
    background: var(--ab-bg); border-radius: 12px; padding: 1rem 1.125rem;
    margin-bottom: 1rem; border: 1.5px solid var(--ab-card-border);
    display: flex; align-items: center; gap: 0.875rem;
}
.ab-modal-info-avatar {
    width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0;
    background: linear-gradient(135deg,#eef2ff,#e0e7ff);
    display: flex; align-items: center; justify-content: center;
}
.dark .ab-modal-info-avatar { background: rgba(99,102,241,0.15); }
.ab-modal-info-avatar svg { width: 20px; height: 20px; color: #4338ca; }
.dark .ab-modal-info-avatar svg { color: #818cf8; }
.ab-modal-info-label { font-size: 0.75rem; font-weight: 600; color: var(--ab-text-muted); text-transform: uppercase; letter-spacing: 0.04em; }
.ab-modal-info-value { font-size: 0.9375rem; font-weight: 700; color: var(--ab-text-primary); margin-top: 1px; }
.ab-modal-notice {
    display: flex; align-items: flex-start; gap: 0.75rem; font-size: 0.875rem;
    color: var(--ab-text-secondary); background: rgba(99,102,241,0.06);
    border: 1px solid rgba(99,102,241,0.15); border-radius: 10px;
    padding: 0.875rem 1rem; line-height: 1.6; margin-bottom: 1rem;
}
.ab-modal-notice svg { width: 18px; height: 18px; color: var(--ab-primary); flex-shrink: 0; margin-top: 1px; }
.ab-modal-notice-danger {
    background: rgba(239,68,68,0.05); border-color: rgba(239,68,68,0.15);
}
.ab-modal-notice-danger svg { color: #ef4444; }

/* Flash */
.ab-flash { padding: 1rem 1.25rem; border-radius: var(--ab-radius); font-size: 0.9375rem; font-weight: 500; margin-bottom: 1.25rem; }
.ab-flash-success { background: var(--ab-success-light); color: #065f46; border: 1px solid #a7f3d0; }
.ab-flash-error { background: var(--ab-danger-light); color: #991b1b; border: 1px solid #fecaca; }

/* RESPONSIVE */
@media (max-width: 1200px) { .ab-stats { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 1024px) { .ab-stats { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 768px) {
    .absences-page { padding: 1rem; }
    .ab-stats { grid-template-columns: 1fr; }
    .ab-filters { flex-direction: column; align-items: stretch; }
    .ab-actions { flex-direction: column; }
}
</style>
@endsection

@section('content')
<div class="absences-page">

    {{-- Flash --}}
    @if(session('success'))
        <div class="ab-flash ab-flash-success">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:18px;height:18px;flex-shrink:0;"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="ab-flash ab-flash-error">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:18px;height:18px;flex-shrink:0;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- ── Stats ── --}}
    <div class="ab-stats">

        <div class="ab-stat-card total">
            <div class="ab-stat-header">
                <div class="ab-stat-content">
                    <div class="ab-stat-value">{{ $stats['total'] }}</div>
                    <div class="ab-stat-label">Total absences</div>
                </div>
                <div class="ab-stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                </div>
            </div>
        </div>

        <div class="ab-stat-card justified">
            <div class="ab-stat-header">
                <div class="ab-stat-content">
                    <div class="ab-stat-value">{{ $stats['justifiees'] }}</div>
                    <div class="ab-stat-label">Justifi&eacute;es</div>
                </div>
                <div class="ab-stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
            </div>
        </div>

        <div class="ab-stat-card unjustified">
            <div class="ab-stat-header">
                <div class="ab-stat-content">
                    <div class="ab-stat-value">{{ $stats['injustifiees'] }}</div>
                    <div class="ab-stat-label">Non justifi&eacute;es</div>
                </div>
                <div class="ab-stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                </div>
            </div>
        </div>

        <div class="ab-stat-card late">
            <div class="ab-stat-header">
                <div class="ab-stat-content">
                    <div class="ab-stat-value">{{ $stats['retards'] }}</div>
                    <div class="ab-stat-label">Retards</div>
                </div>
                <div class="ab-stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
            </div>
        </div>

        <div class="ab-stat-card pending">
            <div class="ab-stat-header">
                <div class="ab-stat-content">
                    <div class="ab-stat-value">{{ $stats['en_attente'] }}</div>
                    <div class="ab-stat-label">En attente</div>
                </div>
                <div class="ab-stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                </div>
            </div>
        </div>

    </div>

    {{-- ── Toolbar ── --}}
    <form method="GET" action="{{ route('admin.absences.index') }}">
    <div class="ab-toolbar">
        <div class="ab-toolbar-left">

            {{-- Search --}}
            <div class="ab-search-box">
                <span class="ab-search-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </span>
                <input type="text" name="search" placeholder="Nom ou matricule..." value="{{ request('search') }}">
            </div>

            {{-- Type --}}
            <select name="type_absence" class="ab-filter-select">
                <option value="">Tous les types</option>
                @foreach($typesAbsence as $type)
                    <option value="{{ $type->id }}" {{ request('type_absence') == $type->id ? 'selected' : '' }}>{{ $type->nom }}</option>
                @endforeach
            </select>

            {{-- Justifiée --}}
            <select name="justifiee" class="ab-filter-select">
                <option value="">Justification</option>
                <option value="1" {{ request('justifiee') === '1' ? 'selected' : '' }}>Justifi&eacute;es</option>
                <option value="0" {{ request('justifiee') === '0' ? 'selected' : '' }}>Non justifi&eacute;es</option>
            </select>

            {{-- Statut --}}
            <select name="statut" class="ab-filter-select">
                <option value="">Tous les statuts</option>
                <option value="en_attente"  {{ request('statut') === 'en_attente'  ? 'selected' : '' }}>En attente</option>
                <option value="approuvee"   {{ request('statut') === 'approuvee'   ? 'selected' : '' }}>Approuv&eacute;es</option>
                <option value="refusee"     {{ request('statut') === 'refusee'     ? 'selected' : '' }}>Refus&eacute;es</option>
            </select>

            {{-- Année --}}
            <select name="annee" class="ab-filter-select">
                @foreach($anneesDisponibles as $a)
                    <option value="{{ $a }}" {{ request('annee', date('Y')) == $a ? 'selected' : '' }}>{{ $a }}</option>
                @endforeach
            </select>

            {{-- Submit --}}
            <button type="submit" class="ab-btn-filter">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                Filtrer
            </button>

            @if(request()->hasAny(['search','type_absence','justifiee','statut','annee']))
                <a href="{{ route('admin.absences.index') }}" class="ab-btn-reset">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Effacer
                </a>
            @endif
        </div>

        <div class="ab-toolbar-right">
            <button type="button" class="ab-btn-add" onclick="document.getElementById('addAbsenceModal').classList.add('active')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Enregistrer une absence
            </button>
        </div>
    </div>
    </form>

    {{-- ── Table ── --}}
    <div class="ab-table-card">
        <div class="ab-table-header">
            <h2 class="ab-table-title">
                <span class="ab-table-title-dot"></span>
                Absences enregistr&eacute;es
            </h2>
            <span class="ab-table-count">{{ $absences->total() }} r&eacute;sultat{{ $absences->total() > 1 ? 's' : '' }}</span>
        </div>

        @if($absences->count() > 0)
            <div class="ab-table-wrap">
                <table class="ab-table">
                    <thead>
                        <tr>
                            <th>Employ&eacute;</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Dur&eacute;e</th>
                            <th>Source</th>
                            <th>Statut</th>
                            <th>Justifi&eacute;e</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($absences as $absence)
                            <tr>
                                <td>
                                    <div class="ab-employee">
                                        <img src="{{ $absence->personnel && $absence->personnel->photo ? asset('storage/' . $absence->personnel->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(($absence->personnel->prenoms ?? '') . ' ' . ($absence->personnel->nom ?? '')) . '&size=80&background=E8F4FD&color=4A90D9&bold=true' }}"
                                             alt="" class="ab-employee-avatar">
                                        <div>
                                            <div class="ab-employee-name">{{ $absence->personnel->prenoms ?? '' }} {{ $absence->personnel->nom ?? '' }}</div>
                                            <div class="ab-employee-matricule">{{ $absence->personnel->matricule ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="ab-type-badge" style="background: {{ $absence->typeAbsence->couleur ?? '#6b7280' }}20; color: {{ $absence->typeAbsence->couleur ?? '#6b7280' }};">
                                        {{ $absence->typeAbsence->nom ?? 'Absence' }}
                                    </span>
                                </td>
                                <td style="font-size: 0.9375rem; white-space: nowrap;">
                                    {{ $absence->date_absence->format('d/m/Y') }}
                                </td>
                                <td style="font-size: 0.875rem; color: var(--ab-text-secondary);">
                                    {{ $absence->duree_label }}
                                </td>
                                <td>
                                    <span class="ab-source {{ $absence->source === 'admin' ? 'admin' : 'employe' }}">
                                        @if($absence->source === 'admin')
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                                            Admin
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                            Employ&eacute;
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    @if($absence->statut === 'en_attente')
                                        <span class="ab-statut en-attente">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                            En attente
                                        </span>
                                    @elseif($absence->statut === 'valide_chef')
                                        <span class="ab-statut valide-chef">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;"><path d="M9 12l2 2 4-4"></path><circle cx="12" cy="12" r="10"></circle></svg>
                                            Valid&eacute; Chef
                                        </span>
                                    @elseif($absence->statut === 'approuvee')
                                        <span class="ab-statut approuvee">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            Approuv&eacute;e
                                        </span>
                                    @elseif($absence->statut === 'refusee')
                                        <span class="ab-statut refusee">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            Refus&eacute;e
                                        </span>
                                    @else
                                        <span style="color:var(--ab-text-muted);font-size:0.75rem;">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="ab-justif {{ $absence->justifiee ? 'oui' : 'non' }}">
                                        @if($absence->justifiee)
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            Justifi&eacute;e
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            Non justifi&eacute;e
                                        @endif
                                    </span>
                                    @if($absence->justificatif)
                                        <a href="{{ asset('storage/' . $absence->justificatif) }}" target="_blank" class="ab-justif-link" style="margin-top: 0.25rem; display: inline-flex;">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                            T&eacute;l&eacute;charger
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <div class="ab-actions">
                                        @php $isChefAb = auth()->user()->hasRole("Chef d'Entreprise"); @endphp

                                        {{-- Étape 1 : Chef d'Entreprise — Valider les demandes en_attente --}}
                                        @if($isChefAb && $absence->statut === 'en_attente')
                                            <button type="button" class="ab-btn ab-btn-approve" onclick="openApproveAbModal({{ $absence->id }}, '{{ addslashes($absence->personnel->prenoms . ' ' . $absence->personnel->nom) }}', true)">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4"></path><circle cx="12" cy="12" r="10"></circle></svg>
                                                Valider
                                            </button>
                                            <button type="button" class="ab-btn ab-btn-reject" onclick="openRejectModal({{ $absence->id }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                Refuser
                                            </button>

                                        {{-- Étape 2 : Super Admin / RH — Approuver UNIQUEMENT si valide_chef --}}
                                        @elseif(!$isChefAb && $absence->statut === 'valide_chef')
                                            <button type="button" class="ab-btn ab-btn-approve" onclick="openApproveAbModal({{ $absence->id }}, '{{ addslashes($absence->personnel->prenoms . ' ' . $absence->personnel->nom) }}', false)">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                Approuver
                                            </button>
                                            <button type="button" class="ab-btn ab-btn-reject" onclick="openRejectModal({{ $absence->id }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                Refuser
                                            </button>

                                        {{-- en_attente : Super Admin/RH attend la validation du Chef d'Entreprise --}}
                                        @elseif(!$isChefAb && $absence->statut === 'en_attente')
                                            <span style="font-size:0.75rem;color:var(--ab-warning);background:var(--ab-warning-light);padding:0.25rem 0.625rem;border-radius:6px;white-space:nowrap;">
                                                ⏳ Attente Chef
                                            </span>
                                            <button type="button" class="ab-btn ab-btn-reject" onclick="openRejectModal({{ $absence->id }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                Refuser
                                            </button>

                                        @else
                                            {{-- Absence traitée (approuvee / refusee) : toggle justifiée + supprimer --}}
                                            @if(!$isChefAb)
                                                <form action="{{ route('admin.absences.toggle-justifiee', $absence) }}" method="POST" style="margin:0;">
                                                    @csrf
                                                    <button type="submit" class="ab-btn ab-btn-toggle" title="{{ $absence->justifiee ? 'Marquer non justifiée' : 'Marquer justifiée' }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                        {{ $absence->justifiee ? 'Déjustifier' : 'Justifier' }}
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.absences.destroy', $absence) }}" method="POST" style="margin:0;" onsubmit="return confirm('Supprimer cette absence ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="ab-btn ab-btn-delete" title="Supprimer">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                                    </button>
                                                </form>
                                            @else
                                                <span style="font-size:0.75rem;color:var(--ab-text-muted);">—</span>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($absences->hasPages())
                <div class="ab-pagination">
                    {{ $absences->withQueryString()->links('pagination::bootstrap-4') }}
                </div>
            @endif
        @else
            <div class="ab-empty">
                <div class="ab-empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                </div>
                <h3 class="ab-empty-title">Aucune absence enregistr&eacute;e</h3>
                <p class="ab-empty-text">Aucune absence ne correspond aux filtres s&eacute;lectionn&eacute;s.</p>
            </div>
        @endif
    </div>
</div>

{{-- Add Absence Modal --}}
<div class="ab-modal-overlay" id="addAbsenceModal">
    <div class="ab-modal">
        <div class="ab-modal-header-bar ab-modal-header-bar-indigo"></div>
        <div class="ab-modal-header">
            <div class="ab-modal-header-inner">
                <div class="ab-modal-header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                </div>
                <div class="ab-modal-header-text">
                    <h3 class="ab-modal-title">Enregistrer une absence</h3>
                    <p class="ab-modal-subtitle">Remplissez les informations de l'absence</p>
                </div>
            </div>
            <button class="ab-modal-close" onclick="closeAbModal('addAbsenceModal')" title="Fermer">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form action="{{ route('admin.absences.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="ab-modal-body">

                <div class="ab-form-group">
                    <label class="ab-form-label">Employ&eacute; <span style="color:var(--ab-danger)">*</span></label>
                    <div class="ab-search-select" id="abPersonnelSearch">
                        <svg class="ab-search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" class="ab-search-input" placeholder="Rechercher un employ&eacute;..." autocomplete="off">
                        <button type="button" class="ab-search-clear" title="Effacer">&times;</button>
                        <input type="hidden" name="personnel_id" value="{{ old('personnel_id') }}" required>
                        <div class="ab-search-dropdown">
                            @foreach($personnels as $p)
                                <div class="ab-search-option" data-value="{{ $p->id }}" data-text="{{ $p->prenoms }} {{ $p->nom }} ({{ $p->matricule ?? '-' }})">
                                    <span>{{ $p->prenoms }} {{ $p->nom }}</span>
                                    <span class="ab-opt-sub">{{ $p->matricule ?? 'Sans matricule' }}</span>
                                </div>
                            @endforeach
                            <div class="ab-search-no-results">Aucun r&eacute;sultat</div>
                        </div>
                    </div>
                </div>

                <div class="ab-form-row">
                    <div class="ab-form-group">
                        <label class="ab-form-label">Type d'absence <span style="color:var(--ab-danger)">*</span></label>
                        <select name="type_absence_id" class="ab-form-select" required>
                            <option value="">S&eacute;lectionnez</option>
                            @foreach($typesAbsence as $type)
                                <option value="{{ $type->id }}" {{ old('type_absence_id') == $type->id ? 'selected' : '' }}>{{ $type->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="ab-form-group">
                        <label class="ab-form-label">Date <span style="color:var(--ab-danger)">*</span></label>
                        <input type="date" name="date_absence" class="ab-form-input" value="{{ old('date_absence', date('Y-m-d')) }}" required>
                    </div>
                </div>

                <div class="ab-form-row">
                    <div class="ab-form-group">
                        <label class="ab-form-label">Type de dur&eacute;e <span style="color:var(--ab-danger)">*</span></label>
                        <select name="duree_type" class="ab-form-select" id="dureeTypeSelect" required onchange="toggleMinutesRetard()">
                            <option value="journee" {{ old('duree_type') === 'journee' ? 'selected' : '' }}>Journ&eacute;e compl&egrave;te</option>
                            <option value="demi_journee" {{ old('duree_type') === 'demi_journee' ? 'selected' : '' }}>Demi-journ&eacute;e</option>
                            <option value="retard" {{ old('duree_type') === 'retard' ? 'selected' : '' }}>Retard</option>
                            <option value="depart_anticipe" {{ old('duree_type') === 'depart_anticipe' ? 'selected' : '' }}>D&eacute;part anticip&eacute;</option>
                        </select>
                    </div>
                    <div class="ab-form-group" id="minutesRetardGroup" style="display:none;">
                        <label class="ab-form-label">Minutes de retard</label>
                        <input type="number" name="minutes_retard" class="ab-form-input" min="1" max="480" value="{{ old('minutes_retard') }}" placeholder="Ex: 30">
                    </div>
                </div>

                <div class="ab-form-row">
                    <div class="ab-form-group">
                        <label class="ab-form-label">Heure d&eacute;but</label>
                        <input type="time" name="heure_debut" class="ab-form-input" value="{{ old('heure_debut') }}">
                    </div>
                    <div class="ab-form-group">
                        <label class="ab-form-label">Heure fin</label>
                        <input type="time" name="heure_fin" class="ab-form-input" value="{{ old('heure_fin') }}">
                    </div>
                </div>

                <div class="ab-form-group">
                    <label class="ab-form-label">Motif</label>
                    <textarea name="motif" class="ab-form-textarea" placeholder="D&eacute;crivez le motif de l'absence...">{{ old('motif') }}</textarea>
                </div>

                <div class="ab-form-group">
                    <label class="ab-form-label">Justificatif</label>
                    <div class="ab-form-file-wrap">
                        <input type="file" name="justificatif" accept=".pdf,.jpg,.jpeg,.png" id="justificatifInput" onchange="updateFileLabel(this)">
                        <div class="ab-form-file-label" id="justificatifLabel">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            <span>Glisser un fichier ou cliquer pour choisir &mdash; <em>PDF, JPG, PNG &middot; max 5 Mo</em></span>
                        </div>
                    </div>
                </div>

                <div class="ab-form-group">
                    <input type="hidden" name="justifiee" value="0">
                    <label class="ab-checkbox-wrap">
                        <input type="checkbox" name="justifiee" value="1" id="justifieeCheck" {{ old('justifiee') ? 'checked' : '' }}>
                        <span style="font-size:0.9375rem;font-weight:600;color:var(--ab-text-primary);">Marquer comme absence justifi&eacute;e</span>
                    </label>
                </div>

            </div>
            <div class="ab-modal-footer">
                <button type="button" class="ab-modal-btn-cancel" onclick="closeAbModal('addAbsenceModal')">Annuler</button>
                <button type="submit" class="ab-modal-btn-confirm">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:15px;height:15px;display:inline;vertical-align:middle;margin-right:5px;"><polyline points="20 6 9 17 4 12"/></svg>
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Approve Modal --}}
<div class="ab-modal-overlay" id="approveAbModal">
    <div class="ab-modal" style="max-width:480px;">
        <div class="ab-modal-header-bar ab-modal-header-bar-teal"></div>
        <div class="ab-modal-header ab-modal-header-teal">
            <div class="ab-modal-header-inner">
                <div class="ab-modal-header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <div class="ab-modal-header-text">
                    <h3 class="ab-modal-title" id="approveAbModalTitle">Approuver l'absence</h3>
                    <p class="ab-modal-subtitle" id="approveAbStepLabel">Confirmation requise</p>
                </div>
            </div>
            <button class="ab-modal-close" onclick="closeAbModal('approveAbModal')" title="Fermer">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form id="approveAbForm" method="POST" action="">
            @csrf
            <div class="ab-modal-body">
                <div class="ab-modal-info-card">
                    <div class="ab-modal-info-avatar">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <div>
                        <p class="ab-modal-info-label">Employ&eacute;</p>
                        <p class="ab-modal-info-value" id="approveAbEmployee">—</p>
                    </div>
                </div>
                <div class="ab-modal-notice" id="approveAbDesc">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span id="approveAbDescText">Confirmer la validation de cette absence.</span>
                </div>
                <p style="font-size:0.875rem;color:var(--ab-text-muted);display:flex;align-items:center;gap:0.5rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:15px;height:15px;flex-shrink:0;color:var(--ab-primary);"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.18 2 2 0 0 1 3.6 1h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.6a16 16 0 0 0 6 6l.96-.96a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    Une notification sera envoy&eacute;e &agrave; l'employ&eacute;.
                </p>
            </div>
            <div class="ab-modal-footer">
                <button type="button" class="ab-modal-btn-cancel" onclick="closeAbModal('approveAbModal')">Annuler</button>
                <button type="submit" class="ab-modal-btn-confirm-teal" id="approveAbBtnLabel">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:15px;height:15px;display:inline;vertical-align:middle;margin-right:5px;"><polyline points="20 6 9 17 4 12"/></svg>
                    Approuver
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Reject Modal --}}
<div class="ab-modal-overlay" id="rejectModal">
    <div class="ab-modal" style="max-width:480px;">
        <div class="ab-modal-header-bar ab-modal-header-bar-red"></div>
        <div class="ab-modal-header ab-modal-header-red">
            <div class="ab-modal-header-inner">
                <div class="ab-modal-header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                </div>
                <div class="ab-modal-header-text">
                    <h3 class="ab-modal-title">Refuser l'absence</h3>
                    <p class="ab-modal-subtitle">Un motif est requis pour notifier l'employ&eacute;</p>
                </div>
            </div>
            <button class="ab-modal-close" onclick="closeAbModal('rejectModal')" title="Fermer">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form id="rejectForm" method="POST" action="">
            @csrf
            <div class="ab-modal-body">
                <div class="ab-modal-notice ab-modal-notice-danger" style="margin-bottom:1.25rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    <span>Cette d&eacute;cision est d&eacute;finitive. L'employ&eacute; recevra une notification avec le motif indiqu&eacute;.</span>
                </div>
                <div class="ab-form-group">
                    <label class="ab-form-label">Motif du refus <span style="color:var(--ab-danger)">*</span></label>
                    <textarea name="motif_refus" class="ab-form-textarea" required placeholder="Expliquez clairement la raison du refus à l'employé..." style="min-height:110px;"></textarea>
                </div>
            </div>
            <div class="ab-modal-footer">
                <button type="button" class="ab-modal-btn-cancel" onclick="closeAbModal('rejectModal')">Annuler</button>
                <button type="submit" class="ab-modal-btn-reject">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:15px;height:15px;display:inline;vertical-align:middle;margin-right:5px;"><polyline points="20 6 9 17 4 12"/></svg>
                    Confirmer le refus
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function closeAbModal(id) {
    document.getElementById(id).classList.remove('active');
}

function toggleMinutesRetard() {
    var sel = document.getElementById('dureeTypeSelect');
    var grp = document.getElementById('minutesRetardGroup');
    grp.style.display = sel.value === 'retard' ? '' : 'none';
}

function openApproveAbModal(absenceId, employee, isChefStep) {
    var form = document.getElementById('approveAbForm');
    form.action = '{{ url("admin/absences") }}/' + absenceId + '/approuver';
    document.getElementById('approveAbEmployee').textContent = employee;
    var btn = document.getElementById('approveAbBtnLabel');
    if (isChefStep) {
        document.getElementById('approveAbModalTitle').textContent = 'Valider l\'absence';
        document.getElementById('approveAbStepLabel').textContent = 'Étape 1 sur 2 — Validation chef';
        document.getElementById('approveAbDescText').textContent = 'Vous validez cette absence en tant que chef. Elle sera ensuite soumise à l\'approbation finale du service RH.';
        btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:15px;height:15px;display:inline;vertical-align:middle;margin-right:5px;"><polyline points="20 6 9 17 4 12"/></svg>Valider';
    } else {
        document.getElementById('approveAbModalTitle').textContent = 'Approuver l\'absence';
        document.getElementById('approveAbStepLabel').textContent = 'Étape finale — Approbation RH';
        document.getElementById('approveAbDescText').textContent = 'Confirmer l\'approbation définitive de cette absence. L\'employé sera notifié immédiatement.';
        btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:15px;height:15px;display:inline;vertical-align:middle;margin-right:5px;"><polyline points="20 6 9 17 4 12"/></svg>Approuver définitivement';
    }
    document.getElementById('approveAbModal').classList.add('active');
}

function updateFileLabel(input) {
    var label = document.getElementById('justificatifLabel');
    if (input.files && input.files[0]) {
        label.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px;height:18px;color:var(--ab-success);flex-shrink:0;"><polyline points="20 6 9 17 4 12"/></svg><span>' + input.files[0].name + '</span>';
    }
}

function openRejectModal(absenceId) {
    var form = document.getElementById('rejectForm');
    form.action = '{{ url("admin/absences") }}/' + absenceId + '/refuser';
    form.querySelector('textarea[name="motif_refus"]').value = '';
    document.getElementById('rejectModal').classList.add('active');
}

// ── Searchable Personnel Select ──
(function() {
    var wrapper = document.getElementById('abPersonnelSearch');
    if (!wrapper) return;
    var input = wrapper.querySelector('.ab-search-input');
    var hidden = wrapper.querySelector('input[name="personnel_id"]');
    var dropdown = wrapper.querySelector('.ab-search-dropdown');
    var options = wrapper.querySelectorAll('.ab-search-option');
    var noResults = wrapper.querySelector('.ab-search-no-results');
    var clearBtn = wrapper.querySelector('.ab-search-clear');

    function showDropdown() { dropdown.style.display = 'block'; }
    function hideDropdown() { dropdown.style.display = 'none'; }

    function filterOptions() {
        var term = input.value.toLowerCase().trim();
        var visible = 0;
        options.forEach(function(opt) {
            var match = opt.getAttribute('data-text').toLowerCase().indexOf(term) !== -1;
            opt.style.display = match ? '' : 'none';
            if (match) visible++;
        });
        noResults.style.display = visible === 0 ? 'block' : 'none';
        // Auto-select if single result and user typed something
        if (visible === 1 && term.length > 0) {
            options.forEach(function(opt) {
                if (opt.style.display !== 'none') {
                    selectOption(opt);
                }
            });
        }
    }

    function selectOption(opt) {
        hidden.value = opt.getAttribute('data-value');
        input.value = opt.getAttribute('data-text');
        clearBtn.style.display = 'block';
        hideDropdown();
    }

    function clearSelection() {
        hidden.value = '';
        input.value = '';
        clearBtn.style.display = 'none';
        options.forEach(function(opt) { opt.style.display = ''; });
        noResults.style.display = 'none';
    }

    input.addEventListener('focus', function() {
        showDropdown();
        filterOptions();
    });

    input.addEventListener('input', function() {
        hidden.value = '';
        clearBtn.style.display = input.value ? 'block' : 'none';
        showDropdown();
        filterOptions();
    });

    options.forEach(function(opt) {
        opt.addEventListener('click', function() { selectOption(opt); });
    });

    clearBtn.addEventListener('click', function(e) {
        e.preventDefault();
        clearSelection();
        input.focus();
    });

    document.addEventListener('click', function(e) {
        if (!wrapper.contains(e.target)) hideDropdown();
    });

    // Restore old() value on load
    if (hidden.value) {
        options.forEach(function(opt) {
            if (opt.getAttribute('data-value') === hidden.value) {
                input.value = opt.getAttribute('data-text');
                clearBtn.style.display = 'block';
            }
        });
    }
})();

// Init on load
toggleMinutesRetard();

// Close modals on overlay click
document.querySelectorAll('.ab-modal-overlay').forEach(function(overlay) {
    overlay.addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('active');
    });
});

// Ouvrir le modal si erreurs
@if($errors->any())
    document.getElementById('addAbsenceModal').classList.add('active');
@endif
</script>
@endsection
