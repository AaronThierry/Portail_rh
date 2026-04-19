@extends('layouts.app')

@section('title', 'Import en lot — Bulletins de paie')

@section('styles')
<style>
/* ═══════════════════════════════════════════════════════════════
   BULLETIN IMPORT — Indigo × Teal Premium Design System
   ═══════════════════════════════════════════════════════════════ */

.bi-page { padding: 0; background: #f8fafc; min-height: 100vh; }

/* ── HERO ── */
.bi-hero {
    background: linear-gradient(135deg, #312e81 0%, #4338ca 45%, #0d9488 100%);
    padding: 2.5rem 2rem 3.5rem;
    position: relative;
    overflow: hidden;
}
.bi-hero::before {
    content: '';
    position: absolute; inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    pointer-events: none;
}
.bi-hero-inner { max-width: 1100px; margin: 0 auto; position: relative; z-index: 1; }
.bi-hero-top { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem; }
.bi-breadcrumb { display: flex; align-items: center; gap: .5rem; font-size: .82rem; color: rgba(255,255,255,.65); }
.bi-breadcrumb a { color: rgba(255,255,255,.8); text-decoration: none; transition: color .2s; }
.bi-breadcrumb a:hover { color: #fff; }
.bi-breadcrumb svg { width: 12px; height: 12px; }

.bi-hero-title { font-family: 'Syne', sans-serif; font-size: clamp(1.6rem, 3vw, 2.2rem); font-weight: 800; color: #fff; margin: 0 0 .5rem; line-height: 1.1; }
.bi-hero-sub { color: rgba(255,255,255,.75); font-size: .95rem; margin: 0; }

.bi-hero-kpis { display: flex; gap: 1rem; flex-wrap: wrap; margin-top: 1.75rem; }
.bi-kpi {
    background: rgba(255,255,255,.1);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,.2);
    border-radius: 14px;
    padding: .9rem 1.4rem;
    min-width: 140px;
    flex: 1;
}
.bi-kpi-val { font-family: 'Syne', sans-serif; font-size: 1.6rem; font-weight: 800; color: #fff; line-height: 1; }
.bi-kpi-lbl { font-size: .78rem; color: rgba(255,255,255,.7); margin-top: .25rem; }

/* ── BODY ── */
.bi-body { max-width: 1100px; margin: -1.5rem auto 0; padding: 0 2rem 3rem; position: relative; z-index: 2; }

/* ── RESULT BANNER ── */
.bi-result {
    border-radius: 16px; padding: 1.5rem 1.75rem;
    margin-bottom: 1.75rem; position: relative;
    animation: bi-fadeUp .4s ease;
}
@keyframes bi-fadeUp { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }

.bi-result-success { background: linear-gradient(135deg, #ecfdf5, #d1fae5); border: 1px solid #6ee7b7; }
.bi-result-partial  { background: linear-gradient(135deg, #fffbeb, #fef3c7); border: 1px solid #fcd34d; }
.bi-result-error    { background: linear-gradient(135deg, #fef2f2, #fee2e2); border: 1px solid #fca5a5; }

.bi-result-head { display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; }
.bi-result-icon { width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.bi-result-success .bi-result-icon { background: #d1fae5; color: #059669; }
.bi-result-partial  .bi-result-icon { background: #fef3c7; color: #d97706; }
.bi-result-error    .bi-result-icon { background: #fee2e2; color: #dc2626; }
.bi-result-icon svg { width: 22px; height: 22px; }
.bi-result-title { font-size: 1.05rem; font-weight: 700; }
.bi-result-success .bi-result-title { color: #065f46; }
.bi-result-partial  .bi-result-title { color: #78350f; }
.bi-result-error    .bi-result-title { color: #7f1d1d; }

.bi-result-stats { display: flex; gap: 1.5rem; flex-wrap: wrap; margin-bottom: .5rem; }
.bi-result-stat {
    display: flex; align-items: center; gap: .5rem;
    padding: .5rem .9rem; border-radius: 8px;
    font-size: .875rem; font-weight: 600;
}
.bi-stat-ok   { background: rgba(5,150,105,.1); color: #065f46; }
.bi-stat-dup  { background: rgba(217,119,6,.1);  color: #78350f; }
.bi-stat-err  { background: rgba(220,38,38,.1);  color: #7f1d1d; }
.bi-stat-tot  { background: rgba(99,102,241,.1); color: #3730a3; }

.bi-result-errors { margin-top: .75rem; }
.bi-result-errors summary { cursor: pointer; font-size: .85rem; font-weight: 600; color: #7f1d1d; padding: .35rem 0; }
.bi-err-list { margin: .5rem 0 0; padding-left: 1.25rem; }
.bi-err-list li { font-size: .82rem; color: #991b1b; margin-bottom: .3rem; line-height: 1.5; }
.bi-err-file { font-family: monospace; font-weight: 700; }

/* ── CARDS ── */
.bi-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
    animation: bi-fadeUp .45s ease;
}
.bi-card-title {
    font-size: 1rem; font-weight: 700; color: #1e293b;
    margin: 0 0 1.5rem; display: flex; align-items: center; gap: .6rem;
}
.bi-card-title svg { width: 20px; height: 20px; color: #6366f1; flex-shrink: 0; }

/* ── STEP INDICATOR ── */
.bi-steps {
    display: flex; align-items: center; gap: 0;
    margin-bottom: 2rem; padding: 0;
    list-style: none;
}
.bi-step {
    display: flex; align-items: center; gap: .6rem;
    flex: 1; position: relative;
}
.bi-step:not(:last-child)::after {
    content: '';
    flex: 1; height: 2px;
    background: #e2e8f0;
    margin: 0 .75rem;
    transition: background .4s;
}
.bi-step.done::after { background: linear-gradient(90deg, #6366f1, #0d9488); }
.bi-step-num {
    width: 32px; height: 32px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .8rem; font-weight: 700;
    background: #f1f5f9; color: #94a3b8;
    border: 2px solid #e2e8f0;
    flex-shrink: 0;
    transition: all .3s;
}
.bi-step.active .bi-step-num {
    background: linear-gradient(135deg, #4338ca, #6366f1);
    color: #fff; border-color: transparent;
    box-shadow: 0 0 0 4px rgba(99,102,241,.15);
}
.bi-step.done .bi-step-num {
    background: linear-gradient(135deg, #0d9488, #14b8a6);
    color: #fff; border-color: transparent;
}
.bi-step-label { font-size: .78rem; font-weight: 600; color: #94a3b8; white-space: nowrap; }
.bi-step.active .bi-step-label { color: #4338ca; }
.bi-step.done .bi-step-label { color: #0d9488; }

/* ── NAMING CONVENTION ── */
.bi-convention {
    background: linear-gradient(135deg, #eef2ff, #f0fdfa);
    border: 1px solid #c7d2fe;
    border-radius: 12px;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.5rem;
}
.bi-convention-title { font-size: .82rem; font-weight: 700; color: #3730a3; text-transform: uppercase; letter-spacing: .05em; margin-bottom: .75rem; }
.bi-convention-pattern {
    font-family: 'Courier New', monospace;
    font-size: .88rem;
    background: rgba(99,102,241,.08);
    color: #4338ca;
    padding: .5rem .85rem;
    border-radius: 7px;
    border: 1px solid rgba(99,102,241,.2);
    margin-bottom: .75rem;
    word-break: break-all;
}
.bi-convention-pattern em { color: #0d9488; font-style: normal; font-weight: 700; }
.bi-convention-examples { display: flex; flex-direction: column; gap: .25rem; }
.bi-convention-example {
    font-family: 'Courier New', monospace; font-size: .78rem;
    color: #475569; padding: .15rem .4rem;
    border-left: 2px solid #c7d2fe;
}
.bi-convention-tip { margin-top: .75rem; font-size: .8rem; color: #64748b; }
.bi-convention-tip code { background: rgba(99,102,241,.08); color: #4338ca; padding: .1rem .4rem; border-radius: 4px; font-family: monospace; }

/* ── FORM GRID ── */
.bi-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.5rem; }
@media (max-width: 640px) { .bi-form-grid { grid-template-columns: 1fr; } }

.bi-field { display: flex; flex-direction: column; gap: .4rem; }
.bi-label { font-size: .82rem; font-weight: 600; color: #374151; }
.bi-label-req { color: #ef4444; }
.bi-select {
    padding: .65rem .9rem;
    border: 1.5px solid #e2e8f0; border-radius: 10px;
    background: #fff; color: #1e293b;
    font-size: .9rem; outline: none;
    transition: border-color .2s, box-shadow .2s;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right .75rem center;
    padding-right: 2.5rem;
}
.bi-select:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.12); }

.bi-error-msg { font-size: .78rem; color: #ef4444; }

/* ── DROP ZONE ── */
.bi-drop-wrap { grid-column: 1 / -1; }
.bi-drop-zone {
    border: 2.5px dashed #c7d2fe;
    border-radius: 16px;
    padding: 3rem 2rem;
    text-align: center;
    cursor: pointer;
    position: relative;
    transition: all .25s cubic-bezier(.4,0,.2,1);
    background: #fafbff;
    overflow: hidden;
}
.bi-drop-zone::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 50% 120%, rgba(99,102,241,.06), transparent 70%);
}
.bi-drop-zone:hover, .bi-drop-zone.drag-over {
    border-color: #6366f1;
    background: #eef2ff;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(99,102,241,.12);
}
.bi-drop-zone.has-file {
    border-color: #10b981; border-style: solid;
    background: #f0fdf4;
    padding: 1.5rem 2rem;
}
.bi-drop-icon {
    width: 64px; height: 64px; margin: 0 auto .75rem;
    background: linear-gradient(135deg, #eef2ff, #e0e7ff);
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    transition: all .25s;
}
.bi-drop-zone:hover .bi-drop-icon,
.bi-drop-zone.drag-over .bi-drop-icon { background: linear-gradient(135deg, #6366f1, #4338ca); }
.bi-drop-zone.has-file .bi-drop-icon { background: linear-gradient(135deg, #d1fae5, #6ee7b7); width:48px; height:48px; border-radius:12px; }
.bi-drop-icon svg { width: 28px; height: 28px; color: #6366f1; }
.bi-drop-zone:hover .bi-drop-icon svg,
.bi-drop-zone.drag-over .bi-drop-icon svg { color: #fff; }
.bi-drop-zone.has-file .bi-drop-icon svg { color: #059669; width:22px; height:22px; }
.bi-drop-title { font-size: 1rem; font-weight: 600; color: #1e293b; margin-bottom: .35rem; }
.bi-drop-title strong { color: #6366f1; }
.bi-drop-sub { font-size: .82rem; color: #94a3b8; }
.bi-drop-file-info {
    display: none;
    align-items: center; justify-content: space-between; gap: .75rem;
    flex-wrap: wrap;
}
.bi-drop-zone.has-file .bi-drop-file-info { display: flex; }
.bi-drop-zone.has-file .bi-drop-default { display: none; }
.bi-drop-file-meta { display:flex; align-items:center; gap:.75rem; }
.bi-file-icon {
    width: 36px; height: 36px; background: #d1fae5;
    border-radius: 8px; display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.bi-file-icon svg { width: 18px; height: 18px; color: #059669; }
.bi-file-details .bi-file-name { font-size: .875rem; font-weight: 700; color: #059669; }
.bi-file-details .bi-file-meta2 { font-size: .78rem; color: #64748b; }
.bi-pdf-count-badge {
    background: linear-gradient(135deg, #4338ca, #6366f1);
    color: #fff; font-size: .8rem; font-weight: 700;
    padding: .35rem .9rem; border-radius: 20px;
    white-space: nowrap;
}
.bi-drop-input {
    position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
}

/* ── CHECKBOX ── */
.bi-toggle-row {
    display: flex; align-items: center; gap: .75rem;
    padding: .85rem 1.1rem;
    background: #f8fafc; border: 1px solid #e2e8f0;
    border-radius: 10px; cursor: pointer;
    transition: border-color .2s, background .2s;
}
.bi-toggle-row:hover { border-color: #c7d2fe; background: #eef2ff; }
.bi-toggle-row input[type="checkbox"] { width: 18px; height: 18px; accent-color: #6366f1; cursor: pointer; }
.bi-toggle-label { flex: 1; font-size: .875rem; font-weight: 500; color: #374151; }
.bi-toggle-badge {
    font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .04em;
    padding: .2rem .5rem; border-radius: 6px;
    background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46;
}

/* ── ACTIONS ── */
.bi-actions { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
.bi-btn {
    display: inline-flex; align-items: center; gap: .5rem;
    padding: .75rem 1.75rem; border-radius: 12px;
    font-size: .9rem; font-weight: 600; cursor: pointer;
    border: none; text-decoration: none;
    transition: all .2s cubic-bezier(.4,0,.2,1);
    white-space: nowrap;
}
.bi-btn-primary {
    background: linear-gradient(135deg, #4338ca, #6366f1);
    color: #fff; box-shadow: 0 4px 14px rgba(99,102,241,.3);
}
.bi-btn-primary:hover:not(:disabled) { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(99,102,241,.4); }
.bi-btn-primary:disabled { opacity: .5; cursor: not-allowed; }
.bi-btn-teal {
    background: linear-gradient(135deg, #0d9488, #14b8a6);
    color: #fff; box-shadow: 0 4px 14px rgba(13,148,136,.3);
}
.bi-btn-teal:hover:not(:disabled) { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(13,148,136,.4); }
.bi-btn-teal:disabled { opacity: .5; cursor: not-allowed; }
.bi-btn-ghost {
    background: transparent; color: #64748b;
    border: 1.5px solid #e2e8f0;
}
.bi-btn-ghost:hover { background: #f8fafc; color: #374151; }
.bi-btn svg { width: 18px; height: 18px; flex-shrink: 0; }
.bi-progress-msg {
    display: none; align-items: center; gap: .6rem;
    font-size: .85rem; color: #6366f1; font-weight: 500;
}
.bi-progress-msg.visible { display: flex; }

/* ── PREVIEW SECTION ── */
.bi-preview-section {
    display: none;
    animation: bi-fadeUp .4s ease;
}
.bi-preview-section.visible { display: block; }

/* ── STATS BAR ── */
.bi-stats-bar {
    display: flex; gap: .75rem; flex-wrap: wrap; margin-bottom: 1.5rem;
}
.bi-chip {
    display: inline-flex; align-items: center; gap: .5rem;
    padding: .6rem 1rem; border-radius: 12px;
    font-size: .82rem; font-weight: 700;
    border: 1.5px solid transparent;
}
.bi-chip-total  { background: #eef2ff; color: #3730a3; border-color: #c7d2fe; }
.bi-chip-ok     { background: #ecfdf5; color: #065f46; border-color: #6ee7b7; }
.bi-chip-nf     { background: #fef2f2; color: #7f1d1d; border-color: #fca5a5; }
.bi-chip-dup    { background: #fffbeb; color: #78350f; border-color: #fcd34d; }
.bi-chip-parse  { background: #f8fafc; color: #374151; border-color: #cbd5e1; }
.bi-chip-dot {
    width: 8px; height: 8px; border-radius: 50%;
}
.bi-chip-total  .bi-chip-dot { background: #6366f1; }
.bi-chip-ok     .bi-chip-dot { background: #10b981; }
.bi-chip-nf     .bi-chip-dot { background: #ef4444; }
.bi-chip-dup    .bi-chip-dot { background: #f59e0b; }
.bi-chip-parse  .bi-chip-dot { background: #94a3b8; }

/* ── PREVIEW TABLE ── */
.bi-preview-wrap {
    border-radius: 14px; overflow: hidden;
    border: 1px solid #e2e8f0;
    margin-bottom: 1.5rem;
    max-height: 480px; overflow-y: auto;
}
.bi-preview-table { width: 100%; border-collapse: collapse; font-size: .84rem; }
.bi-preview-table thead { position: sticky; top: 0; z-index: 5; }
.bi-preview-table th {
    text-align: left; padding: .7rem 1rem;
    font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em;
    color: #64748b;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
}
.bi-preview-table td {
    padding: .8rem 1rem;
    border-bottom: 1px solid #f1f5f9;
    color: #374151;
    vertical-align: middle;
}
.bi-preview-table tr:last-child td { border-bottom: none; }

/* Row status backgrounds */
.bi-row-ok    td { background: #f0fdf4; }
.bi-row-nf    td { background: #fef2f2; }
.bi-row-dup   td { background: #fffbeb; }
.bi-row-parse td { background: #fafafa; }
.bi-row-pend  td { background: #fafbff; }

.bi-row-ok:hover    td { background: #dcfce7; }
.bi-row-nf:hover    td { background: #fee2e2; }
.bi-row-dup:hover   td { background: #fef3c7; }
.bi-row-pend:hover  td { background: #eef2ff; }
.bi-row-parse:hover td { background: #f1f5f9; }

/* Status pill */
.bi-pill {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .2rem .65rem; border-radius: 20px;
    font-size: .72rem; font-weight: 700; white-space: nowrap;
}
.bi-pill-ok    { background: #dcfce7; color: #15803d; }
.bi-pill-nf    { background: #fee2e2; color: #b91c1c; }
.bi-pill-dup   { background: #fef3c7; color: #92400e; }
.bi-pill-parse { background: #f1f5f9; color: #475569; }
.bi-pill-pend  { background: #eef2ff; color: #4338ca; }

/* Police badge */
.bi-police-tag {
    font-family: 'Courier New', monospace;
    font-size: .78rem; font-weight: 700;
    background: rgba(99,102,241,.08);
    color: #4338ca;
    padding: .15rem .5rem; border-radius: 5px;
    border: 1px solid rgba(99,102,241,.2);
}
.bi-emp-name { font-weight: 600; color: #1e293b; font-size: .82rem; }
.bi-emp-mat  { font-size: .72rem; color: #64748b; margin-top: .1rem; }
.bi-file-mono { font-family: 'Courier New', monospace; font-size: .75rem; color: #475569; max-width: 260px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

/* ── ALERT BANNER ── */
.bi-alert {
    display: flex; align-items: flex-start; gap: .75rem;
    padding: 1rem 1.25rem; border-radius: 12px;
    font-size: .85rem; margin-bottom: 1.25rem;
}
.bi-alert-info { background: #eef2ff; border: 1px solid #c7d2fe; color: #3730a3; }
.bi-alert svg { width: 18px; height: 18px; flex-shrink: 0; margin-top: .05rem; }

/* ── HISTORY ── */
.bi-hist-table { width: 100%; border-collapse: collapse; }
.bi-hist-table th {
    text-align: left; padding: .6rem 1rem;
    font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em;
    color: #94a3b8; border-bottom: 1px solid #f1f5f9;
}
.bi-hist-table td { padding: .9rem 1rem; border-bottom: 1px solid #f8fafc; font-size: .875rem; color: #374151; }
.bi-hist-table tr:last-child td { border-bottom: none; }
.bi-hist-table tr:hover td { background: #fafbff; }

.bi-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .25rem .65rem; border-radius: 20px; font-size: .75rem; font-weight: 700;
}
.bi-badge-success { background: #d1fae5; color: #065f46; }
.bi-badge-warning { background: #fef3c7; color: #78350f; }
.bi-badge-danger  { background: #fee2e2; color: #7f1d1d; }
.bi-badge-info    { background: #e0e7ff; color: #3730a3; }

.bi-num-ok  { color: #059669; font-weight: 700; }
.bi-num-dup { color: #d97706; font-weight: 600; }
.bi-num-err { color: #dc2626; font-weight: 600; }

/* Spinner */
@keyframes bi-spin { to { transform: rotate(360deg); } }
.bi-spinner { animation: bi-spin 1s linear infinite; flex-shrink: 0; }

/* Empty state */
.bi-empty { text-align: center; padding: 2.5rem 1rem; color: #94a3b8; }
.bi-empty svg { width: 40px; height: 40px; margin-bottom: .75rem; }
.bi-empty p { font-size: .875rem; margin: 0; }

/* Divider */
.bi-divider { border: none; border-top: 1px solid #f1f5f9; margin: 1.5rem 0; }
</style>
@endsection

@section('content')
<div class="bi-page">

{{-- ══ HERO ══ --}}
<div class="bi-hero">
    <div class="bi-hero-inner">
        <div class="bi-hero-top">
            <nav class="bi-breadcrumb">
                <a href="{{ route('admin.dashboard') }}">Tableau de bord</a>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                <a href="{{ route('admin.bulletins-paie.index') }}">Bulletins de paie</a>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                <span>Import en lot</span>
            </nav>
        </div>

        <h1 class="bi-hero-title">Import en lot de bulletins</h1>
        <p class="bi-hero-sub">Chargez un ZIP contenant vos PDFs — le système identifie chaque bulletin par numéro de police et l'associe automatiquement</p>

        <div class="bi-hero-kpis">
            <div class="bi-kpi">
                <div class="bi-kpi-val">{{ $historique->sum('succes') }}</div>
                <div class="bi-kpi-lbl">Bulletins importés au total</div>
            </div>
            <div class="bi-kpi">
                <div class="bi-kpi-val">{{ $historique->count() }}</div>
                <div class="bi-kpi-lbl">Imports effectués</div>
            </div>
            <div class="bi-kpi">
                <div class="bi-kpi-val">{{ $historique->where('statut', 'termine')->count() }}</div>
                <div class="bi-kpi-lbl">Imports réussis</div>
            </div>
        </div>
    </div>
</div>

{{-- ══ BODY ══ --}}
<div class="bi-body">

    {{-- ── Résultat import (flash) ── --}}
    @if(session('import_result'))
        @php
            $res    = session('import_result');
            $statut = session('import_statut', 'termine');
            $cls    = match($statut) { 'echec' => 'bi-result-error', 'partiel' => 'bi-result-partial', default => 'bi-result-success' };
            $label  = match($statut) { 'echec' => 'Import échoué', 'partiel' => 'Import partiel — certains bulletins n\'ont pas pu être traités', default => 'Import terminé avec succès !' };
        @endphp
        <div class="bi-result {{ $cls }}">
            <div class="bi-result-head">
                <div class="bi-result-icon">
                    @if($statut === 'echec')
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                    @elseif($statut === 'partiel')
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    @else
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    @endif
                </div>
                <div class="bi-result-title">{{ $label }}</div>
            </div>

            <div class="bi-result-stats">
                <div class="bi-result-stat bi-stat-tot">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/></svg>
                    <strong>{{ $res['total'] }}</strong> fichiers traités
                </div>
                <div class="bi-result-stat bi-stat-ok">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <strong>{{ $res['succes'] }}</strong> bulletins créés
                </div>
                <div class="bi-result-stat bi-stat-dup">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <strong>{{ $res['doublons'] }}</strong> doublons ignorés
                </div>
                @if(count($res['erreurs']) > 0)
                <div class="bi-result-stat bi-stat-err">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                    <strong>{{ count($res['erreurs']) }}</strong> erreurs
                </div>
                @endif
            </div>

            @if(!empty($res['erreurs']))
            <div class="bi-result-errors">
                <details>
                    <summary>Voir les {{ count($res['erreurs']) }} erreur(s)</summary>
                    <ul class="bi-err-list">
                        @foreach($res['erreurs'] as $err)
                            <li><span class="bi-err-file">{{ $err['fichier'] }}</span> — {{ $err['raison'] }}</li>
                        @endforeach
                    </ul>
                </details>
            </div>
            @endif
        </div>
    @endif

    @if(session('error'))
        <div class="bi-result bi-result-error" style="margin-bottom:1.75rem;">
            <div class="bi-result-head">
                <div class="bi-result-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg></div>
                <div class="bi-result-title">{{ session('error') }}</div>
            </div>
        </div>
    @endif

    {{-- ══ MAIN IMPORT CARD ══ --}}
    <div class="bi-card">

        {{-- Step indicator --}}
        <ul class="bi-steps" id="biSteps">
            <li class="bi-step active" id="step1">
                <div class="bi-step-num">1</div>
                <span class="bi-step-label">Configuration</span>
            </li>
            <li class="bi-step" id="step2">
                <div class="bi-step-num">2</div>
                <span class="bi-step-label">Prévisualisation</span>
            </li>
            <li class="bi-step" id="step3">
                <div class="bi-step-num">3</div>
                <span class="bi-step-label">Import</span>
            </li>
        </ul>

        {{-- Convention de nommage --}}
        <div class="bi-convention">
            <div class="bi-convention-title">Convention de nommage des PDFs dans le ZIP</div>
            <div class="bi-convention-pattern">Bulletin_<em>{Police}</em>_{NOM_PRENOM}_{YYYY-MM-DD}_au_{YYYY-MM-DD}.pdf</div>
            <div class="bi-convention-examples">
                <div class="bi-convention-example">Bulletin_580U224_TAMINI_THIERRY_NOHMITE_2026-04-19_au_2026-04-19.pdf</div>
                <div class="bi-convention-example">Bulletin_001ABC_KABORE_BRICE_2026-03-01_au_2026-03-31.pdf</div>
                <div class="bi-convention-example">Bulletin_MAT123_OUEDRAOGO_ALICE_2026-02-01_au_2026-02-28.pdf</div>
            </div>
            <div class="bi-convention-tip">
                Le premier segment après <code>Bulletin_</code> est le <strong>numéro de police</strong> — il sert d'identifiant principal pour associer le bulletin à l'employé.
                Optionnel : ajoutez un fichier <code>salaires.csv</code> (<code>matricule, salaire_brut, salaire_net</code>) pour importer les montants.
            </div>
        </div>

        {{-- ═══ ÉTAPE 1 — Configuration + Upload ═══ --}}
        <div id="phaseConfig">
            <div class="bi-form-grid">

                {{-- Entreprise --}}
                <div class="bi-field">
                    <label class="bi-label" for="entreprise_id">Entreprise <span class="bi-label-req">*</span></label>
                    <select name="entreprise_id" id="entreprise_id" class="bi-select" required>
                        <option value="">— Sélectionner une entreprise —</option>
                        @foreach($entreprises as $ent)
                            <option value="{{ $ent->id }}" {{ old('entreprise_id') == $ent->id ? 'selected' : '' }}>
                                {{ $ent->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('entreprise_id')
                        <span class="bi-error-msg">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Notification --}}
                <div class="bi-field" style="justify-content:flex-end;">
                    <label class="bi-toggle-row">
                        <input type="checkbox" id="notifierCheck" name="notifier" value="1" {{ old('notifier') ? 'checked' : '' }}>
                        <span class="bi-toggle-label">
                            <strong>Notifier les employés</strong> après import
                        </span>
                        <span class="bi-toggle-badge">WhatsApp</span>
                    </label>
                </div>

                {{-- Drop zone —— pleine largeur --}}
                <div class="bi-drop-wrap">
                    <label class="bi-label">Archive ZIP <span class="bi-label-req">*</span></label>
                    <div class="bi-drop-zone" id="dropZone">
                        <input type="file" id="fichierZip" accept=".zip" required class="bi-drop-input">

                        <div class="bi-drop-default">
                            <div class="bi-drop-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <polyline points="17 8 12 3 7 8"/>
                                    <line x1="12" y1="3" x2="12" y2="15"/>
                                </svg>
                            </div>
                            <div class="bi-drop-title">Glissez votre ZIP ici ou <strong>cliquez pour choisir</strong></div>
                            <div class="bi-drop-sub">Format : .zip · Taille max : 100 Mo · Contient les PDFs des bulletins</div>
                        </div>

                        <div class="bi-drop-file-info">
                            <div class="bi-drop-file-meta">
                                <div class="bi-file-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                        <polyline points="17 8 12 3 7 8"/>
                                        <line x1="12" y1="3" x2="12" y2="15"/>
                                    </svg>
                                </div>
                                <div class="bi-file-details">
                                    <div class="bi-file-name" id="fileName">—</div>
                                    <div class="bi-file-meta2" id="fileSize"></div>
                                </div>
                            </div>
                            <div style="display:flex;align-items:center;gap:.75rem;">
                                <span class="bi-pdf-count-badge" id="pdfCountBadge" style="display:none;"></span>
                                <button type="button" id="changeFile" style="background:none;border:none;color:#64748b;font-size:.8rem;cursor:pointer;text-decoration:underline;">Changer</button>
                            </div>
                        </div>
                    </div>
                    @error('fichier_zip')
                        <span class="bi-error-msg">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            {{-- Actions étape 1 --}}
            <div class="bi-actions" id="actionsConfig">
                <button type="button" class="bi-btn bi-btn-primary" id="analyserBtn" disabled>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    Analyser les fichiers
                </button>
                <a href="{{ route('admin.bulletins-paie.index') }}" class="bi-btn bi-btn-ghost">Annuler</a>
                <div class="bi-progress-msg" id="analyseMsg">
                    <svg class="bi-spinner" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                    Analyse en cours…
                </div>
            </div>
        </div>

        {{-- ═══ ÉTAPE 2 — Prévisualisation ═══ --}}
        <div id="phasePreview" class="bi-preview-section">
            <hr class="bi-divider">

            {{-- Stats chips --}}
            <div class="bi-stats-bar" id="statsBar">
                <div class="bi-chip bi-chip-total"><span class="bi-chip-dot"></span> <span id="chipTotal">0</span> fichiers</div>
                <div class="bi-chip bi-chip-ok"   ><span class="bi-chip-dot"></span> <span id="chipOk">0</span> prêts à importer</div>
                <div class="bi-chip bi-chip-nf"   ><span class="bi-chip-dot"></span> <span id="chipNf">0</span> introuvables</div>
                <div class="bi-chip bi-chip-dup"  ><span class="bi-chip-dot"></span> <span id="chipDup">0</span> doublons</div>
                <div class="bi-chip bi-chip-parse"><span class="bi-chip-dot"></span> <span id="chipErr">0</span> format invalide</div>
            </div>

            {{-- Alert si introuvables --}}
            <div class="bi-alert bi-alert-info" id="nfAlert" style="display:none;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <div id="nfAlertText"></div>
            </div>

            {{-- Preview table --}}
            <div class="bi-preview-wrap">
                <table class="bi-preview-table">
                    <thead>
                        <tr>
                            <th>Fichier PDF</th>
                            <th>Police</th>
                            <th>Nom extrait</th>
                            <th>Période</th>
                            <th>Employé trouvé</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody id="previewTbody">
                    </tbody>
                </table>
            </div>

            {{-- Actions étape 2 --}}
            <div class="bi-actions">
                <button type="button" class="bi-btn bi-btn-teal" id="lancerImportBtn" disabled>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="16 16 12 12 8 16"/>
                        <line x1="12" y1="12" x2="12" y2="21"/>
                        <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/>
                    </svg>
                    Lancer l'import
                </button>
                <button type="button" class="bi-btn bi-btn-ghost" id="resetBtn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.5"/></svg>
                    Recommencer
                </button>
                <div class="bi-progress-msg" id="importMsg">
                    <svg class="bi-spinner" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                    Import en cours, veuillez patienter…
                </div>
            </div>
        </div>

    </div>{{-- /bi-card --}}

    {{-- Formulaire caché pour la soumission réelle --}}
    <form action="{{ url('/admin/bulletins-paie/import') }}" method="POST" enctype="multipart/form-data" id="importForm" style="display:none;">
        @csrf
        <input type="file" name="fichier_zip" id="hiddenZipInput">
        <input type="hidden" name="entreprise_id" id="hiddenEntrepriseId">
        <input type="hidden" name="notifier" id="hiddenNotifier" value="0">
    </form>

    {{-- ── HISTORIQUE ── --}}
    <div class="bi-card">
        <h2 class="bi-card-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="12 8 12 12 14 14"/>
                <path d="M3.05 11a9 9 0 1 1 .5 4m-.5 5v-5h5"/>
            </svg>
            Historique des imports
        </h2>

        @if($historique->isEmpty())
            <div class="bi-empty">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
                <p>Aucun import effectué pour le moment.</p>
            </div>
        @else
            <table class="bi-hist-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Entreprise</th>
                        <th>Effectué par</th>
                        <th>Total</th>
                        <th>Créés</th>
                        <th>Doublons</th>
                        <th>Erreurs</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($historique as $log)
                    <tr>
                        <td style="white-space:nowrap;">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                        <td><strong>{{ $log->entreprise?->nom ?? '—' }}</strong></td>
                        <td>{{ $log->uploadedBy?->name ?? '—' }}</td>
                        <td style="font-weight:600;">{{ $log->total }}</td>
                        <td class="bi-num-ok">{{ $log->succes }}</td>
                        <td class="bi-num-dup">{{ $log->doublons }}</td>
                        <td class="bi-num-err">{{ $log->erreurs_count }}</td>
                        <td>
                            @php
                                $bc = match($log->statut) {
                                    'termine'  => 'success',
                                    'partiel'  => 'warning',
                                    'echec'    => 'danger',
                                    default    => 'info',
                                };
                            @endphp
                            <span class="bi-badge bi-badge-{{ $bc }}">
                                @if($log->statut === 'termine') ✓ @elseif($log->statut === 'echec') ✗ @elseif($log->statut === 'partiel') ⚠ @else … @endif
                                {{ $log->statut_label }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/jszip@3.10.1/dist/jszip.min.js"></script>
<script>
// ═══════════════════════════════════════════════════════════════
//  BULLETIN IMPORT — 3-phase smart import with AJAX preview
// ═══════════════════════════════════════════════════════════════

const CSRF     = '{{ csrf_token() }}';
const PREVIEW_URL = '{{ url("/admin/bulletins-paie/import/preview") }}';

// DOM refs
const dropZone       = document.getElementById('dropZone');
const fileInput      = document.getElementById('fichierZip');
const fileNameEl     = document.getElementById('fileName');
const fileSizeEl     = document.getElementById('fileSize');
const pdfCountBadge  = document.getElementById('pdfCountBadge');
const changeBtn      = document.getElementById('changeFile');
const entrepriseEl   = document.getElementById('entreprise_id');
const notifierEl     = document.getElementById('notifierCheck');
const analyserBtn    = document.getElementById('analyserBtn');
const analyseMsg     = document.getElementById('analyseMsg');
const phasePreview   = document.getElementById('phasePreview');
const previewTbody   = document.getElementById('previewTbody');
const lancerBtn      = document.getElementById('lancerImportBtn');
const importMsg      = document.getElementById('importMsg');
const resetBtn       = document.getElementById('resetBtn');
const nfAlert        = document.getElementById('nfAlert');
const nfAlertText    = document.getElementById('nfAlertText');
const importForm     = document.getElementById('importForm');
const hiddenZipInput = document.getElementById('hiddenZipInput');
const hiddenEnt      = document.getElementById('hiddenEntrepriseId');
const hiddenNotif    = document.getElementById('hiddenNotifier');

// Steps
const stepEls = [
    document.getElementById('step1'),
    document.getElementById('step2'),
    document.getElementById('step3'),
];

// State
let currentFile = null;
let parsedFiles = []; // { filename, police, nom, periode, annee, mois, statut:'pend'|'ok'|'nf'|'dup'|'parse' }
let analysed    = false;

// ── Step indicator ──────────────────────────────────────────
function setStep(active) {
    stepEls.forEach((el, i) => {
        el.classList.remove('active', 'done');
        if (i + 1 < active) el.classList.add('done');
        else if (i + 1 === active) el.classList.add('active');
    });
}

// ── Client-side filename parser (mirrors PHP BulletinImportService::parseFilename) ──
function parseFilename(filename) {
    const base = filename.replace(/\.pdf$/i, '');
    const m = base.match(/^Bulletin_(.+)_(\d{4}-\d{2}-\d{2})_au_(\d{4}-\d{2}-\d{2})$/i);
    if (!m) return null;

    const middle    = m[1];
    const dateDebut = m[2];
    const annee     = parseInt(dateDebut.substring(0, 4));
    const mois      = parseInt(dateDebut.substring(5, 7));

    if (annee < 2000 || annee > 2100 || mois < 1 || mois > 12) return null;

    const parts  = middle.split('_');
    const police = parts[0];
    const nom    = parts.slice(1).join(' ');

    return {
        police,
        nom,
        annee,
        mois,
        periode: String(mois).padStart(2,'0') + '/' + annee,
    };
}

// ── Read ZIP with JSZip ─────────────────────────────────────
async function readZipPdfs(file) {
    const zip    = new JSZip();
    const loaded = await zip.loadAsync(file);
    const pdfs   = [];

    zip.forEach((relativePath, entry) => {
        if (!entry.dir && relativePath.toLowerCase().endsWith('.pdf')) {
            // Take only the basename (ignore sub-folders)
            const base = relativePath.split('/').pop();
            pdfs.push(base);
        }
    });

    return pdfs;
}

// ── Show file info in drop zone ─────────────────────────────
function showFileInfo(file) {
    const mb = (file.size / 1024 / 1024).toFixed(2);
    fileNameEl.textContent = file.name;
    fileSizeEl.textContent = mb + ' Mo';
    dropZone.classList.add('has-file');
    pdfCountBadge.style.display = 'none';
    analysed = false;
    phasePreview.classList.remove('visible');
    setStep(1);
}

// ── Update analyser button state ────────────────────────────
function updateAnalyserBtn() {
    analyserBtn.disabled = !(currentFile && entrepriseEl.value);
}

// ── Build preview table from parsedFiles ────────────────────
function renderPreviewTable() {
    previewTbody.innerHTML = '';

    parsedFiles.forEach((row, idx) => {
        const tr = document.createElement('tr');
        tr.dataset.idx = idx;

        let rowClass = 'bi-row-pend';
        if (row.statut === 'ok')     rowClass = 'bi-row-ok';
        if (row.statut === 'nf')     rowClass = 'bi-row-nf';
        if (row.statut === 'dup')    rowClass = 'bi-row-dup';
        if (row.statut === 'parse')  rowClass = 'bi-row-parse';
        tr.className = rowClass;

        const pillHtml = pillFor(row);
        const policeHtml = row.police
            ? `<span class="bi-police-tag">${esc(row.police)}</span>`
            : '<span style="color:#94a3b8;">—</span>';
        const nomHtml = row.nom
            ? esc(row.nom)
            : '<span style="color:#94a3b8;">—</span>';
        const periodeHtml = row.periode
            ? `<strong>${esc(row.periode)}</strong>`
            : '<span style="color:#94a3b8;">—</span>';

        let empHtml = '<span style="color:#94a3b8;">—</span>';
        if (row.statut === 'pend') {
            empHtml = '<span style="color:#94a3b8;font-style:italic;">en attente d\'analyse…</span>';
        } else if (row.personnel) {
            empHtml = `<div class="bi-emp-name">${esc(row.personnel.nom_complet)}</div>
                       <div class="bi-emp-mat">Police : ${esc(row.personnel.police || '—')} · Mat. ${esc(row.personnel.matricule || '—')}</div>`;
        } else if (row.statut === 'nf') {
            empHtml = `<span style="color:#ef4444;font-size:.78rem;">Police introuvable</span>`;
        } else if (row.statut === 'dup') {
            empHtml = row.personnel
                ? `<div class="bi-emp-name">${esc(row.personnel.nom_complet)}</div><div class="bi-emp-mat" style="color:#d97706;">Bulletin déjà existant</div>`
                : '<span style="color:#f59e0b;">Doublon</span>';
        }

        tr.innerHTML = `
            <td><div class="bi-file-mono" title="${esc(row.filename)}">${esc(row.filename)}</div></td>
            <td>${policeHtml}</td>
            <td>${nomHtml}</td>
            <td>${periodeHtml}</td>
            <td>${empHtml}</td>
            <td>${pillHtml}</td>
        `;

        previewTbody.appendChild(tr);
    });
}

function pillFor(row) {
    switch (row.statut) {
        case 'ok':    return '<span class="bi-pill bi-pill-ok">✓ Prêt</span>';
        case 'nf':    return '<span class="bi-pill bi-pill-nf">✗ Introuvable</span>';
        case 'dup':   return '<span class="bi-pill bi-pill-dup">~ Doublon</span>';
        case 'parse': return '<span class="bi-pill bi-pill-parse">⚠ Format invalide</span>';
        default:      return '<span class="bi-pill bi-pill-pend">⋯ À analyser</span>';
    }
}

function esc(str) {
    if (!str) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

// ── Update chips ────────────────────────────────────────────
function updateChips() {
    const counts = { ok: 0, nf: 0, dup: 0, parse: 0 };
    parsedFiles.forEach(r => {
        if (r.statut in counts) counts[r.statut]++;
    });
    document.getElementById('chipTotal').textContent = parsedFiles.length;
    document.getElementById('chipOk').textContent    = counts.ok;
    document.getElementById('chipNf').textContent    = counts.nf;
    document.getElementById('chipDup').textContent   = counts.dup;
    document.getElementById('chipErr').textContent   = counts.parse;

    // NF alert
    if (counts.nf > 0) {
        nfAlertText.textContent = `${counts.nf} fichier(s) n'ont pas pu être associés à un employé de cette entreprise. Vérifiez que le numéro de police dans le nom du fichier correspond bien à un employé existant.`;
        nfAlert.style.display = 'flex';
    } else {
        nfAlert.style.display = 'none';
    }

    // Enable lancer only if ok > 0
    lancerBtn.disabled = counts.ok === 0;
}

// ── DRAG & DROP ─────────────────────────────────────────────
dropZone.addEventListener('dragover', e => {
    e.preventDefault();
    dropZone.classList.add('drag-over');
});
dropZone.addEventListener('dragleave', e => {
    if (!dropZone.contains(e.relatedTarget)) dropZone.classList.remove('drag-over');
});
dropZone.addEventListener('drop', e => {
    e.preventDefault();
    dropZone.classList.remove('drag-over');
    const file = e.dataTransfer.files[0];
    if (file && file.name.toLowerCase().endsWith('.zip')) {
        const dt = new DataTransfer();
        dt.items.add(file);
        fileInput.files = dt.files;
        currentFile = file;
        showFileInfo(file);
        updateAnalyserBtn();
        parseZipContents(file);
    }
});

dropZone.addEventListener('click', e => {
    if (e.target !== changeBtn) fileInput.click();
});
changeBtn.addEventListener('click', e => {
    e.stopPropagation();
    resetState();
    fileInput.value = '';
    fileInput.click();
});

fileInput.addEventListener('change', () => {
    if (fileInput.files[0]) {
        currentFile = fileInput.files[0];
        showFileInfo(currentFile);
        updateAnalyserBtn();
        parseZipContents(currentFile);
    }
});

entrepriseEl.addEventListener('change', updateAnalyserBtn);

// ── Parse ZIP and build initial preview ─────────────────────
async function parseZipContents(file) {
    pdfCountBadge.textContent = '…';
    pdfCountBadge.style.display = 'inline-flex';

    try {
        const pdfNames = await readZipPdfs(file);
        pdfCountBadge.textContent = pdfNames.length + ' PDF' + (pdfNames.length > 1 ? 's' : '') + ' détecté' + (pdfNames.length > 1 ? 's' : '');

        // Build parsedFiles with client-side parse only (statut = pend or parse)
        parsedFiles = pdfNames.map(name => {
            const parsed = parseFilename(name);
            if (!parsed) {
                return { filename: name, police: null, nom: null, periode: null, annee: null, mois: null, statut: 'parse', personnel: null };
            }
            return { filename: name, ...parsed, statut: 'pend', personnel: null };
        });

        updateChips();
        renderPreviewTable();
        phasePreview.classList.add('visible');
        setStep(2);

    } catch (err) {
        pdfCountBadge.textContent = 'Erreur lecture ZIP';
        console.error(err);
    }
}

// ── ANALYSER AJAX ────────────────────────────────────────────
analyserBtn.addEventListener('click', async () => {
    const entrepriseId = entrepriseEl.value;
    if (!entrepriseId || !currentFile) return;

    // Only analyse non-parse files
    const validFilenames = parsedFiles
        .filter(r => r.statut !== 'parse')
        .map(r => r.filename);

    if (validFilenames.length === 0) return;

    // UI loading state
    analyserBtn.disabled = true;
    analyserBtn.innerHTML = `
        <svg class="bi-spinner" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
        Analyse…
    `;
    analyseMsg.classList.add('visible');

    try {
        const resp = await fetch(PREVIEW_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ filenames: validFilenames, entreprise_id: entrepriseId }),
        });

        if (!resp.ok) {
            const text = await resp.text();
            throw new Error(`Erreur serveur (${resp.status})`);
        }

        const data = await resp.json();

        // Merge server results into parsedFiles
        const resultMap = {};
        data.rows.forEach(row => {
            resultMap[row.fichier] = row;
        });

        parsedFiles = parsedFiles.map(local => {
            if (local.statut === 'parse') return local; // keep parse errors as-is
            const srv = resultMap[local.filename];
            if (!srv) return local;

            return {
                ...local,
                statut: srv.statut === 'ok' ? 'ok' : srv.statut === 'doublon' ? 'dup' : srv.statut === 'not_found' ? 'nf' : 'parse',
                personnel: srv.personnel ?? null,
            };
        });

        analysed = true;
        updateChips();
        renderPreviewTable();
        setStep(2);

    } catch (err) {
        alert('Erreur lors de l\'analyse : ' + err.message);
    } finally {
        analyserBtn.disabled = false;
        analyserBtn.innerHTML = `
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            Ré-analyser
        `;
        analyseMsg.classList.remove('visible');
    }
});

// ── LANCER L'IMPORT ─────────────────────────────────────────
lancerBtn.addEventListener('click', () => {
    if (!currentFile || !entrepriseEl.value) return;
    if (!analysed) {
        alert('Veuillez d\'abord analyser les fichiers avant de lancer l\'import.');
        return;
    }

    const okCount = parsedFiles.filter(r => r.statut === 'ok').length;
    if (okCount === 0) {
        alert('Aucun bulletin prêt à importer. Vérifiez les correspondances de police.');
        return;
    }

    // UI state
    lancerBtn.disabled = true;
    lancerBtn.innerHTML = `
        <svg class="bi-spinner" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
        Envoi en cours…
    `;
    importMsg.classList.add('visible');
    setStep(3);

    // Transfer file to hidden form and submit
    const dt = new DataTransfer();
    dt.items.add(currentFile);
    hiddenZipInput.files = dt.files;
    hiddenEnt.value      = entrepriseEl.value;
    hiddenNotif.value    = notifierEl.checked ? '1' : '0';
    importForm.submit();
});

// ── RESET ────────────────────────────────────────────────────
resetBtn.addEventListener('click', () => {
    resetState();
    fileInput.value = '';
});

function resetState() {
    currentFile  = null;
    parsedFiles  = [];
    analysed     = false;
    dropZone.classList.remove('has-file');
    pdfCountBadge.style.display = 'none';
    phasePreview.classList.remove('visible');
    setStep(1);
    analyserBtn.disabled = true;
    analyserBtn.innerHTML = `
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        Analyser les fichiers
    `;
}
</script>
@endsection
