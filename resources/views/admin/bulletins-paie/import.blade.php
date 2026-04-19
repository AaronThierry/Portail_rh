@extends('layouts.app')

@section('title', 'Import en lot — Bulletins de paie')

@section('styles')
<style>
/* ═══════════════════════════════════════════════════════════════
   BULLETIN IMPORT — Indigo × Teal Dark Design System
   Syne (display) · DM Sans (body) · DM Mono (data)
   ═══════════════════════════════════════════════════════════════ */
:root {
    --bi-ind:      #6366f1;
    --bi-ind-d:    #4338ca;
    --bi-ind-900:  #312e81;
    --bi-ind-l:    rgba(99,102,241,.18);
    --bi-ind-l2:   rgba(99,102,241,.09);
    --bi-teal:     #14b8a6;
    --bi-teal-d:   #0d9488;
    --bi-teal-l:   rgba(20,184,166,.16);
    --bi-emer:     #10b981;
    --bi-emer-l:   rgba(16,185,129,.16);
    --bi-red:      #ef4444;
    --bi-red-l:    rgba(239,68,68,.16);
    --bi-amb:      #f59e0b;
    --bi-amb-l:    rgba(245,158,11,.16);
    --bi-bg:       #0b1120;
    --bi-surf:     #111827;
    --bi-surf2:    #1a2236;
    --bi-surf3:    #1e2a3e;
    --bi-bdr:      rgba(255,255,255,.08);
    --bi-bdr2:     rgba(255,255,255,.14);
    --bi-txt:      #e2e8f0;
    --bi-txt2:     #94a3b8;
    --bi-txt3:     #4b5563;
    --bi-sh:       0 1px 4px rgba(0,0,0,.35), 0 1px 2px rgba(0,0,0,.25);
    --bi-sh-md:    0 4px 20px rgba(0,0,0,.4);
    --bi-r:        14px;
}

/* ── Page wrapper ── */
.bi-page {
    background: #0b1120 !important;
    min-height: 100vh;
    font-family: 'DM Sans', sans-serif;
    color: #e2e8f0;
}
/* Force dark background on content containers */
.bi-page .bi-body,
.bi-page ~ * { background: transparent; }

/* ── HERO ── */
.bi-hero {
    background: linear-gradient(135deg, #312e81 0%, #4338ca 45%, #0d9488 100%);
    padding: 2.5rem 2rem 3.5rem;
    position: relative;
    overflow: hidden;
}
.bi-hero::before {
    content: '';
    position: absolute; top: -80px; right: -50px;
    width: 360px; height: 360px; border-radius: 50%;
    background: radial-gradient(circle, rgba(255,255,255,.07) 0%, transparent 70%);
    pointer-events: none;
}
.bi-hero::after {
    content: '';
    position: absolute; bottom: -70px; left: 30%;
    width: 260px; height: 260px; border-radius: 50%;
    background: radial-gradient(circle, rgba(20,184,166,.13) 0%, transparent 70%);
    pointer-events: none;
}
.bi-hero-inner { max-width: 1100px; margin: 0 auto; position: relative; z-index: 1; }

.bi-breadcrumb {
    display: flex; align-items: center; gap: .5rem;
    font-size: .65rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase;
    color: rgba(255,255,255,.5); margin-bottom: 1.25rem;
}
.bi-breadcrumb a { color: rgba(255,255,255,.7); text-decoration: none; transition: color .2s; }
.bi-breadcrumb a:hover { color: #fff; }
.bi-breadcrumb svg { width: 10px; height: 10px; }

.bi-live-dot {
    width: 7px; height: 7px; border-radius: 50%;
    background: #34d399; flex-shrink: 0;
    box-shadow: 0 0 0 3px rgba(52,211,153,.25);
    animation: bi-dot 2s infinite;
}
@keyframes bi-dot {
    0%,100%{ box-shadow:0 0 0 3px rgba(52,211,153,.25); }
    50%{ box-shadow:0 0 0 7px rgba(52,211,153,.07); }
}

.bi-hero-title {
    font-family: 'Syne', sans-serif;
    font-size: clamp(1.6rem, 3vw, 2.2rem);
    font-weight: 800;
    color: #fff; margin: 0 0 .5rem; line-height: 1.1;
    letter-spacing: -.04em;
}
.bi-hero-title span { color: #5eead4; }
.bi-hero-sub { color: rgba(255,255,255,.55); font-size: .83rem; margin: 0; line-height: 1.6; }

.bi-hero-kpis {
    display: flex; gap: .75rem; flex-wrap: wrap;
    margin-top: 1.75rem; padding-top: 1.5rem;
    border-top: 1px solid rgba(255,255,255,.1);
}
.bi-kpi {
    background: rgba(255,255,255,.09);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,.14);
    border-radius: 14px;
    padding: .85rem 1.25rem; min-width: 120px; flex: 1;
    transition: background .2s;
}
.bi-kpi:hover { background: rgba(255,255,255,.14); }
.bi-kpi-val {
    font-family: 'Syne', sans-serif; font-size: 1.6rem; font-weight: 700;
    color: #fff; line-height: 1; letter-spacing: -.04em;
}
.bi-kpi-lbl { font-size: .6rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: rgba(255,255,255,.45); margin-top: .3rem; }

/* ── BODY ── */
.bi-body { max-width: 1100px; margin: -1.5rem auto 0; padding: 0 2rem 3rem; position: relative; z-index: 2; }

/* ── FLASH RESULT ── */
.bi-result {
    border-radius: 16px; padding: 1.25rem 1.5rem;
    margin-bottom: 1.5rem; position: relative;
    animation: bi-fadeUp .4s ease;
    border: 1px solid var(--bi-bdr2);
}
@keyframes bi-fadeUp { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
.bi-result-success { background: rgba(16,185,129,.08); border-color: rgba(16,185,129,.25); }
.bi-result-partial  { background: rgba(245,158,11,.08); border-color: rgba(245,158,11,.25); }
.bi-result-error    { background: rgba(239,68,68,.08);  border-color: rgba(239,68,68,.25); }
.bi-result-head { display: flex; align-items: center; gap: .9rem; margin-bottom: .9rem; }
.bi-result-icon {
    width: 44px; height: 44px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.bi-result-success .bi-result-icon { background: var(--bi-emer-l); color: var(--bi-emer); }
.bi-result-partial  .bi-result-icon { background: var(--bi-amb-l);  color: var(--bi-amb); }
.bi-result-error    .bi-result-icon { background: var(--bi-red-l);  color: var(--bi-red); }
.bi-result-icon svg { width: 20px; height: 20px; }
.bi-result-title { font-family: 'Syne', sans-serif; font-size: 1rem; font-weight: 700; color: var(--bi-txt); }
.bi-result-stats { display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: .4rem; }
.bi-result-stat {
    display: flex; align-items: center; gap: .45rem;
    padding: .4rem .8rem; border-radius: 8px;
    font-size: .8rem; font-weight: 600;
}
.bi-stat-ok  { background: var(--bi-emer-l); color: #34d399; }
.bi-stat-dup { background: var(--bi-amb-l);  color: #fbbf24; }
.bi-stat-err { background: var(--bi-red-l);  color: #f87171; }
.bi-stat-tot { background: var(--bi-ind-l);  color: #a5b4fc; }
.bi-result-errors summary { cursor: pointer; font-size: .82rem; font-weight: 600; color: #f87171; padding: .3rem 0; }
.bi-err-list { margin: .4rem 0 0; padding-left: 1.25rem; }
.bi-err-list li { font-size: .8rem; color: #fca5a5; margin-bottom: .25rem; line-height: 1.5; }
.bi-err-file { font-family: 'DM Mono', monospace; font-weight: 700; }

/* ── CARDS ── */
.bi-card {
    background: #1a2236;
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 18px;
    padding: 1.75rem;
    margin-bottom: 1.25rem;
    box-shadow: 0 1px 4px rgba(0,0,0,.35), 0 1px 2px rgba(0,0,0,.25);
    animation: bi-fadeUp .45s ease;
}
.bi-card-title {
    font-family: 'Syne', sans-serif; font-size: .9rem; font-weight: 700;
    color: var(--bi-txt); margin: 0 0 1.5rem;
    display: flex; align-items: center; gap: .6rem; letter-spacing: -.01em;
}
.bi-card-title-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--bi-ind); flex-shrink: 0; }
.bi-card-title svg { width: 18px; height: 18px; color: var(--bi-ind); flex-shrink: 0; }

/* ── STEP INDICATOR ── */
.bi-steps { display: flex; align-items: center; list-style: none; padding: 0; margin: 0 0 1.75rem; }
.bi-step { display: flex; align-items: center; gap: .5rem; flex: 1; position: relative; }
.bi-step:not(:last-child)::after {
    content: ''; flex: 1; height: 1.5px;
    background: var(--bi-bdr2); margin: 0 .6rem;
    transition: background .4s;
}
.bi-step.done::after { background: linear-gradient(90deg, var(--bi-teal-d), var(--bi-ind)); }
.bi-step-num {
    width: 30px; height: 30px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .75rem; font-weight: 700; font-family: 'DM Mono', monospace;
    background: #1e2a3e; color: #4b5563;
    border: 1.5px solid rgba(255,255,255,.14); flex-shrink: 0;
    transition: all .3s;
}
.bi-step.active .bi-step-num {
    background: linear-gradient(135deg, var(--bi-ind-d), var(--bi-ind));
    color: #fff; border-color: transparent;
    box-shadow: 0 0 0 4px var(--bi-ind-l);
}
.bi-step.done .bi-step-num {
    background: linear-gradient(135deg, var(--bi-teal-d), var(--bi-teal));
    color: #fff; border-color: transparent;
}
.bi-step-label { font-size: .72rem; font-weight: 700; letter-spacing: .03em; color: var(--bi-txt3); white-space: nowrap; }
.bi-step.active .bi-step-label { color: var(--bi-ind); }
.bi-step.done .bi-step-label { color: var(--bi-teal); }

/* ── NAMING CONVENTION ── */
.bi-convention {
    background: #1e2a3e;
    border: 1px solid rgba(255,255,255,.14);
    border-radius: 12px;
    padding: 1.1rem 1.35rem;
    margin-bottom: 1.5rem;
    position: relative; overflow: hidden;
}
.bi-convention::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, var(--bi-ind), var(--bi-teal));
}
.bi-convention-title {
    font-size: .62rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .1em; color: var(--bi-txt2); margin-bottom: .75rem;
}
.bi-convention-pattern {
    font-family: 'DM Mono', monospace;
    font-size: .83rem;
    background: rgba(99,102,241,.1);
    color: #a5b4fc;
    padding: .5rem .85rem;
    border-radius: 8px;
    border: 1px solid rgba(99,102,241,.2);
    margin-bottom: .75rem;
    word-break: break-all;
}
.bi-convention-pattern em { color: #5eead4; font-style: normal; font-weight: 700; }
.bi-convention-examples { display: flex; flex-direction: column; gap: .2rem; }
.bi-convention-example {
    font-family: 'DM Mono', monospace; font-size: .73rem;
    color: var(--bi-txt3); padding: .15rem .4rem;
    border-left: 2px solid rgba(99,102,241,.3);
}
.bi-convention-tip { margin-top: .75rem; font-size: .78rem; color: var(--bi-txt2); line-height: 1.6; }
.bi-convention-tip code {
    background: rgba(99,102,241,.12); color: #a5b4fc;
    padding: .1rem .4rem; border-radius: 4px;
    font-family: 'DM Mono', monospace; font-size: .75rem;
}

/* ── FORM GRID ── */
.bi-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.1rem; margin-bottom: 1.5rem; }
@media (max-width: 640px) { .bi-form-grid { grid-template-columns: 1fr; } }
.bi-field { display: flex; flex-direction: column; gap: .35rem; }
.bi-label {
    font-size: .68rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .07em; color: var(--bi-txt2);
}
.bi-label-req { color: var(--bi-red); margin-left: 2px; }
.bi-select {
    padding: .6rem .9rem;
    border: 1.5px solid rgba(255,255,255,.08); border-radius: 10px;
    background: #1e2a3e; color: #e2e8f0;
    font-family: 'DM Sans', sans-serif; font-size: .85rem;
    outline: none; transition: border-color .2s, box-shadow .2s;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right .75rem center;
    padding-right: 2.5rem;
}
.bi-select:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.18); }
.bi-select option { background: #1a2236; color: #e2e8f0; }
.bi-error-msg { font-size: .75rem; color: var(--bi-red); }

/* ── TOGGLE ROW ── */
.bi-toggle-row {
    display: flex; align-items: center; gap: .75rem;
    padding: .8rem 1rem;
    background: #1e2a3e; border: 1.5px solid rgba(255,255,255,.08);
    border-radius: 10px; cursor: pointer;
    transition: border-color .2s, background .2s;
    height: 100%;
}
.bi-toggle-row:hover { border-color: rgba(99,102,241,.35); background: rgba(99,102,241,.06); }
.bi-toggle-row input[type="checkbox"] { width: 17px; height: 17px; accent-color: var(--bi-ind); cursor: pointer; }
.bi-toggle-label { flex: 1; font-size: .83rem; font-weight: 500; color: var(--bi-txt2); }
.bi-toggle-label strong { color: var(--bi-txt); }
.bi-toggle-badge {
    font-size: .65rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em;
    padding: .2rem .55rem; border-radius: 6px;
    background: var(--bi-emer-l); color: #34d399; white-space: nowrap;
}

/* ── DROP ZONE ── */
.bi-drop-wrap { grid-column: 1 / -1; }
.bi-drop-zone {
    border: 2px dashed rgba(99,102,241,.35);
    border-radius: 14px;
    padding: 2.75rem 2rem;
    text-align: center;
    cursor: pointer;
    position: relative;
    transition: all .25s cubic-bezier(.4,0,.2,1);
    background: #1e2a3e;
    overflow: hidden;
}
.bi-drop-zone::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 50% 110%, rgba(99,102,241,.06), transparent 70%);
    pointer-events: none;
}
.bi-drop-zone:hover, .bi-drop-zone.drag-over {
    border-color: var(--bi-ind);
    background: rgba(99,102,241,.06);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(99,102,241,.15);
}
.bi-drop-zone.has-file {
    border-color: var(--bi-emer); border-style: solid;
    background: rgba(16,185,129,.05);
    padding: 1.25rem 1.5rem;
}
.bi-drop-icon {
    width: 60px; height: 60px; margin: 0 auto .75rem;
    background: var(--bi-ind-l);
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    transition: all .25s;
}
.bi-drop-zone:hover .bi-drop-icon,
.bi-drop-zone.drag-over .bi-drop-icon { background: linear-gradient(135deg, var(--bi-ind-d), var(--bi-ind)); }
.bi-drop-zone.has-file .bi-drop-icon { background: var(--bi-emer-l); width:44px; height:44px; border-radius:12px; }
.bi-drop-icon svg { width: 26px; height: 26px; color: var(--bi-ind); }
.bi-drop-zone:hover .bi-drop-icon svg,
.bi-drop-zone.drag-over .bi-drop-icon svg { color: #fff; }
.bi-drop-zone.has-file .bi-drop-icon svg { color: var(--bi-emer); width:20px; height:20px; }
.bi-drop-title { font-size: .95rem; font-weight: 600; color: var(--bi-txt); margin-bottom: .3rem; }
.bi-drop-title strong { color: #a5b4fc; }
.bi-drop-sub { font-size: .78rem; color: var(--bi-txt3); }
.bi-drop-file-info {
    display: none;
    align-items: center; justify-content: space-between; gap: .75rem; flex-wrap: wrap;
}
.bi-drop-zone.has-file .bi-drop-file-info { display: flex; }
.bi-drop-zone.has-file .bi-drop-default { display: none; }
.bi-drop-file-meta { display: flex; align-items: center; gap: .75rem; }
.bi-file-icon {
    width: 36px; height: 36px; background: var(--bi-emer-l);
    border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.bi-file-icon svg { width: 17px; height: 17px; color: var(--bi-emer); }
.bi-file-name { font-size: .875rem; font-weight: 700; color: var(--bi-emer); }
.bi-file-meta2 { font-size: .73rem; color: var(--bi-txt3); }
.bi-pdf-count-badge {
    background: linear-gradient(135deg, var(--bi-ind-d), var(--bi-ind));
    color: #fff; font-size: .73rem; font-weight: 700;
    padding: .3rem .85rem; border-radius: 20px; white-space: nowrap;
    box-shadow: 0 3px 10px rgba(99,102,241,.3);
}
.bi-drop-input { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }

/* ── ACTIONS ── */
.bi-actions { display: flex; align-items: center; gap: .85rem; flex-wrap: wrap; }
.bi-btn {
    display: inline-flex; align-items: center; gap: .45rem;
    padding: .65rem 1.5rem; border-radius: 10px;
    font-size: .83rem; font-weight: 600;
    cursor: pointer; border: none; text-decoration: none;
    transition: all .2s cubic-bezier(.4,0,.2,1);
    white-space: nowrap; font-family: 'DM Sans', sans-serif;
}
.bi-btn-primary {
    background: linear-gradient(135deg, var(--bi-ind-d), var(--bi-ind));
    color: #fff; box-shadow: 0 4px 14px rgba(99,102,241,.35);
}
.bi-btn-primary:hover:not(:disabled) { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(99,102,241,.45); }
.bi-btn-primary:disabled { opacity: .45; cursor: not-allowed; }
.bi-btn-teal {
    background: linear-gradient(135deg, var(--bi-teal-d), var(--bi-teal));
    color: #fff; box-shadow: 0 4px 14px rgba(13,148,136,.3);
}
.bi-btn-teal:hover:not(:disabled) { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(13,148,136,.4); }
.bi-btn-teal:disabled { opacity: .45; cursor: not-allowed; }
.bi-btn-ghost {
    background: transparent; color: var(--bi-txt2);
    border: 1.5px solid var(--bi-bdr2);
}
.bi-btn-ghost:hover { background: var(--bi-surf3); color: var(--bi-txt); border-color: rgba(255,255,255,.2); }
.bi-btn svg { width: 16px; height: 16px; flex-shrink: 0; }
.bi-progress-msg {
    display: none; align-items: center; gap: .5rem;
    font-size: .82rem; color: var(--bi-ind); font-weight: 500;
}
.bi-progress-msg.visible { display: flex; }

/* ── PREVIEW SECTION ── */
.bi-preview-section { display: none; animation: bi-fadeUp .4s ease; }
.bi-preview-section.visible { display: block; }

/* ── STATS BAR ── */
.bi-stats-bar { display: flex; gap: .6rem; flex-wrap: wrap; margin-bottom: 1.25rem; }
.bi-chip {
    display: inline-flex; align-items: center; gap: .45rem;
    padding: .5rem .9rem; border-radius: 10px;
    font-size: .75rem; font-weight: 700;
    border: 1px solid transparent;
}
.bi-chip-total { background: var(--bi-ind-l);  color: #a5b4fc; border-color: rgba(99,102,241,.25); }
.bi-chip-ok    { background: var(--bi-emer-l); color: #34d399; border-color: rgba(16,185,129,.25); }
.bi-chip-nf    { background: var(--bi-red-l);  color: #f87171; border-color: rgba(239,68,68,.25); }
.bi-chip-dup   { background: var(--bi-amb-l);  color: #fbbf24; border-color: rgba(245,158,11,.25); }
.bi-chip-parse { background: var(--bi-surf3);  color: var(--bi-txt3); border-color: var(--bi-bdr2); }
.bi-chip-dot { width: 7px; height: 7px; border-radius: 50%; }
.bi-chip-total .bi-chip-dot { background: var(--bi-ind); }
.bi-chip-ok    .bi-chip-dot { background: var(--bi-emer); }
.bi-chip-nf    .bi-chip-dot { background: var(--bi-red); }
.bi-chip-dup   .bi-chip-dot { background: var(--bi-amb); }
.bi-chip-parse .bi-chip-dot { background: var(--bi-txt3); }

/* ── ALERT ── */
.bi-alert {
    display: flex; align-items: flex-start; gap: .65rem;
    padding: .9rem 1.1rem; border-radius: 10px;
    font-size: .82rem; margin-bottom: 1.1rem;
    border: 1px solid;
}
.bi-alert-info { background: rgba(99,102,241,.08); border-color: rgba(99,102,241,.25); color: #a5b4fc; }
.bi-alert svg { width: 16px; height: 16px; flex-shrink: 0; margin-top: .1rem; }

/* ── PREVIEW TABLE ── */
.bi-preview-wrap {
    border-radius: 12px; overflow: hidden;
    border: 1px solid var(--bi-bdr);
    margin-bottom: 1.5rem;
    max-height: 460px; overflow-y: auto;
    scrollbar-width: thin; scrollbar-color: var(--bi-surf3) transparent;
}
.bi-preview-wrap::-webkit-scrollbar { width: 4px; }
.bi-preview-wrap::-webkit-scrollbar-thumb { background: var(--bi-surf3); border-radius: 2px; }
.bi-preview-table { width: 100%; border-collapse: collapse; font-size: .8rem; }
.bi-preview-table thead { position: sticky; top: 0; z-index: 5; }
.bi-preview-table th {
    text-align: left; padding: .6rem .9rem;
    font-size: .65rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em;
    color: #4b5563; background: #111827;
    border-bottom: 1px solid rgba(255,255,255,.08);
}
.bi-preview-table td {
    padding: .75rem .9rem;
    border-bottom: 1px solid rgba(255,255,255,.08);
    color: #94a3b8; vertical-align: middle;
}
.bi-preview-table tr:last-child td { border-bottom: none; }

/* Row status */
.bi-row-ok   td { background: rgba(16,185,129,.06); }
.bi-row-nf   td { background: rgba(239,68,68,.06); }
.bi-row-dup  td { background: rgba(245,158,11,.06); }
.bi-row-pend td { background: #1a2236; }
.bi-row-parse td { background: rgba(255,255,255,.02); }
.bi-row-ok:hover   td { background: rgba(16,185,129,.12); }
.bi-row-nf:hover   td { background: rgba(239,68,68,.12); }
.bi-row-dup:hover  td { background: rgba(245,158,11,.12); }
.bi-row-pend:hover td { background: #1e2a3e; }

/* Status pill */
.bi-pill {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .2rem .6rem; border-radius: 20px;
    font-size: .68rem; font-weight: 700; white-space: nowrap;
}
.bi-pill-ok    { background: var(--bi-emer-l); color: #34d399; }
.bi-pill-nf    { background: var(--bi-red-l);  color: #f87171; }
.bi-pill-dup   { background: var(--bi-amb-l);  color: #fbbf24; }
.bi-pill-parse { background: var(--bi-surf3);  color: var(--bi-txt3); }
.bi-pill-pend  { background: var(--bi-ind-l);  color: #a5b4fc; }

/* Police badge */
.bi-police-tag {
    font-family: 'DM Mono', monospace;
    font-size: .72rem; font-weight: 600;
    background: rgba(99,102,241,.12); color: #a5b4fc;
    padding: .15rem .5rem; border-radius: 5px;
    border: 1px solid rgba(99,102,241,.2);
}
.bi-emp-name { font-weight: 600; color: var(--bi-txt); font-size: .8rem; }
.bi-emp-mat  { font-size: .68rem; color: var(--bi-txt3); margin-top: .1rem; font-family: 'DM Mono', monospace; }
.bi-file-mono {
    font-family: 'DM Mono', monospace; font-size: .7rem; color: var(--bi-txt3);
    max-width: 240px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
}

/* ── HISTORY TABLE ── */
.bi-hist-table { width: 100%; border-collapse: collapse; }
.bi-hist-table th {
    text-align: left; padding: .55rem .9rem;
    font-size: .63rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em;
    color: #4b5563; border-bottom: 1px solid rgba(255,255,255,.08);
}
.bi-hist-table td { padding: .85rem .9rem; border-bottom: 1px solid rgba(255,255,255,.05); font-size: .82rem; color: #94a3b8; }
.bi-hist-table tr:last-child td { border-bottom: none; }
.bi-hist-table tr:hover td { background: #1e2a3e; }
.bi-hist-table strong { color: #e2e8f0; font-weight: 600; }

.bi-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .2rem .6rem; border-radius: 20px; font-size: .7rem; font-weight: 700;
}
.bi-badge-success { background: var(--bi-emer-l); color: #34d399; }
.bi-badge-warning { background: var(--bi-amb-l);  color: #fbbf24; }
.bi-badge-danger  { background: var(--bi-red-l);  color: #f87171; }
.bi-badge-info    { background: var(--bi-ind-l);  color: #a5b4fc; }

.bi-num-ok  { color: #34d399; font-weight: 700; font-family: 'DM Mono', monospace; }
.bi-num-dup { color: #fbbf24; font-weight: 600; font-family: 'DM Mono', monospace; }
.bi-num-err { color: #f87171; font-weight: 600; font-family: 'DM Mono', monospace; }

/* Spinner */
@keyframes bi-spin { to { transform: rotate(360deg); } }
.bi-spinner { animation: bi-spin 1s linear infinite; flex-shrink: 0; }

/* Empty state */
.bi-empty { text-align: center; padding: 2.5rem 1rem; color: var(--bi-txt3); }
.bi-empty-icon {
    width: 64px; height: 64px; border-radius: 18px;
    background: rgba(99,102,241,.18); display: flex; align-items: center; justify-content: center;
    color: #6366f1; margin: 0 auto .75rem;
}
.bi-empty-icon svg { width: 30px; height: 30px; }
.bi-empty-title { font-family: 'Syne', sans-serif; font-size: 1rem; font-weight: 700; color: #e2e8f0; margin: 0 0 .3rem; }
.bi-empty-sub { font-size: .82rem; color: #4b5563; margin: 0; }

/* Divider */
.bi-divider { border: none; border-top: 1px solid rgba(255,255,255,.08); margin: 1.5rem 0; }

/* Hint message */
.bi-hint-msg {
    font-size: .78rem; color: #f59e0b; font-weight: 500;
    display: none; align-items: center; gap: .4rem;
    animation: bi-fadeUp .25s ease;
}
.bi-hint-msg.visible { display: flex; }
.bi-hint-msg svg { width: 15px; height: 15px; flex-shrink: 0; }
</style>
@endsection

@section('content')
<div class="bi-page">

{{-- ══ HERO ══ --}}
<div class="bi-hero">
    <div class="bi-hero-inner">

        <nav class="bi-breadcrumb">
            <span class="bi-live-dot"></span>
            <a href="{{ route('admin.dashboard') }}">Tableau de bord</a>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
            <a href="{{ route('admin.bulletins-paie.index') }}">Bulletins de paie</a>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
            <span>Import en lot</span>
        </nav>

        <h1 class="bi-hero-title">Import en lot de <span>bulletins</span></h1>
        <p class="bi-hero-sub">Chargez un ZIP contenant vos PDFs — le système identifie chaque bulletin par numéro de police et l'associe automatiquement</p>

        <div class="bi-hero-kpis">
            <div class="bi-kpi">
                <div class="bi-kpi-val">{{ $historique->sum('succes') }}</div>
                <div class="bi-kpi-lbl">Bulletins importés</div>
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
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/></svg>
                    <strong>{{ $res['total'] }}</strong> traités
                </div>
                <div class="bi-result-stat bi-stat-ok">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <strong>{{ $res['succes'] }}</strong> créés
                </div>
                <div class="bi-result-stat bi-stat-dup">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <strong>{{ $res['doublons'] }}</strong> doublons
                </div>
                @if(count($res['erreurs']) > 0)
                <div class="bi-result-stat bi-stat-err">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
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
        <div class="bi-result bi-result-error">
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
                Le premier segment après <code>Bulletin_</code> est le <strong>numéro de police</strong> — identifiant principal pour associer le bulletin à l'employé.
                Optionnel : <code>salaires.csv</code> (<code>matricule, salaire_brut, salaire_net</code>) pour importer les montants.
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

                {{-- Drop zone --}}
                <div class="bi-drop-wrap">
                    <label class="bi-label" style="margin-bottom:.5rem;">Archive ZIP <span class="bi-label-req">*</span></label>
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
                            <div class="bi-drop-sub">Format .zip · Max 100 Mo · Archive contenant les PDFs bulletins</div>
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
                                <div>
                                    <div class="bi-file-name" id="fileName">—</div>
                                    <div class="bi-file-meta2" id="fileSize"></div>
                                </div>
                            </div>
                            <div style="display:flex;align-items:center;gap:.65rem;">
                                <span class="bi-pdf-count-badge" id="pdfCountBadge" style="display:none;"></span>
                                <button type="button" id="changeFile" style="background:none;border:none;color:var(--bi-txt3);font-size:.75rem;cursor:pointer;text-decoration:underline;font-family:'DM Sans',sans-serif;">Changer</button>
                            </div>
                        </div>
                    </div>
                    @error('fichier_zip')
                        <span class="bi-error-msg">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            {{-- Actions étape 1 --}}
            <div class="bi-actions">
                <button type="button" class="bi-btn bi-btn-primary" id="analyserBtn" disabled>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    Analyser les fichiers
                </button>
                <a href="{{ route('admin.bulletins-paie.index') }}" class="bi-btn bi-btn-ghost">Annuler</a>
                <div class="bi-progress-msg" id="analyseMsg">
                    <svg class="bi-spinner" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
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
                <div class="bi-chip bi-chip-ok"   ><span class="bi-chip-dot"></span> <span id="chipOk">0</span> prêts</div>
                <div class="bi-chip bi-chip-nf"   ><span class="bi-chip-dot"></span> <span id="chipNf">0</span> introuvables</div>
                <div class="bi-chip bi-chip-dup"  ><span class="bi-chip-dot"></span> <span id="chipDup">0</span> doublons</div>
                <div class="bi-chip bi-chip-parse"><span class="bi-chip-dot"></span> <span id="chipErr">0</span> format invalide</div>
            </div>

            {{-- Alert introuvables --}}
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
                    <tbody id="previewTbody"></tbody>
                </table>
            </div>

            {{-- Actions étape 2 --}}
            <div class="bi-actions" style="flex-wrap:wrap;">
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
                    <svg class="bi-spinner" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                    Import en cours, veuillez patienter…
                </div>
                <div class="bi-hint-msg" id="lancerHintMsg">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    Cliquez d'abord sur <strong style="color:#fbbf24;margin:0 .2rem;">Analyser les fichiers</strong> (sélectionnez l'entreprise si ce n'est pas fait)
                </div>
            </div>
        </div>

    </div>{{-- /bi-card --}}

    {{-- Formulaire caché --}}
    <form action="{{ url('/admin/bulletins-paie/import') }}" method="POST" enctype="multipart/form-data" id="importForm" style="display:none;">
        @csrf
        <input type="file" name="fichier_zip" id="hiddenZipInput">
        <input type="hidden" name="entreprise_id" id="hiddenEntrepriseId">
        <input type="hidden" name="notifier" id="hiddenNotifier" value="0">
    </form>

    {{-- ── HISTORIQUE ── --}}
    <div class="bi-card">
        <h2 class="bi-card-title">
            <span class="bi-card-title-dot"></span>
            Historique des imports
        </h2>

        @if($historique->isEmpty())
            <div class="bi-empty">
                <div class="bi-empty-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
                </div>
                <div class="bi-empty-title">Aucun import effectué</div>
                <p class="bi-empty-sub">Les imports apparaîtront ici une fois lancés.</p>
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
                        <td style="white-space:nowrap;font-family:'DM Mono',monospace;font-size:.75rem;">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                        <td><strong>{{ $log->entreprise?->nom ?? '—' }}</strong></td>
                        <td style="color:var(--bi-txt2);">{{ $log->uploadedBy?->name ?? '—' }}</td>
                        <td style="font-family:'DM Mono',monospace;font-weight:600;color:var(--bi-txt);">{{ $log->total }}</td>
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
<script src="{{ asset('assets/js/jszip.min.js') }}"></script>
<script>
// ═══════════════════════════════════════════════════════════════
//  BULLETIN IMPORT — 3-phase smart import with AJAX preview
// ═══════════════════════════════════════════════════════════════

const CSRF        = '{{ csrf_token() }}';
const PREVIEW_URL = '{{ url("/admin/bulletins-paie/import/preview") }}';

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
const lancerHintMsg  = document.getElementById('lancerHintMsg');
const resetBtn       = document.getElementById('resetBtn');
const nfAlert        = document.getElementById('nfAlert');
const nfAlertText    = document.getElementById('nfAlertText');
const importForm     = document.getElementById('importForm');
const hiddenZipInput = document.getElementById('hiddenZipInput');
const hiddenEnt      = document.getElementById('hiddenEntrepriseId');
const hiddenNotif    = document.getElementById('hiddenNotifier');
const stepEls        = [document.getElementById('step1'), document.getElementById('step2'), document.getElementById('step3')];

let currentFile = null;
let parsedFiles = [];
let analysed    = false;

// ── Step indicator ──────────────────────────────────────────
function setStep(active) {
    stepEls.forEach((el, i) => {
        el.classList.remove('active', 'done');
        if (i + 1 < active) el.classList.add('done');
        else if (i + 1 === active) el.classList.add('active');
    });
}

// ── Client-side filename parser ──────────────────────────────
function parseFilename(filename) {
    const base = filename.replace(/\.pdf$/i, '');
    const m = base.match(/^Bulletin_(.+)_(\d{4}-\d{2}-\d{2})_au_(\d{4}-\d{2}-\d{2})$/i);
    if (!m) return null;
    const middle = m[1];
    const dateDebut = m[2];
    const annee = parseInt(dateDebut.substring(0, 4));
    const mois  = parseInt(dateDebut.substring(5, 7));
    if (annee < 2000 || annee > 2100 || mois < 1 || mois > 12) return null;
    const parts  = middle.split('_');
    const police = parts[0];
    const nom    = parts.slice(1).join(' ');
    return { police, nom, annee, mois, periode: String(mois).padStart(2,'0') + '/' + annee };
}

// ── Read ZIP with JSZip ──────────────────────────────────────
async function readZipPdfs(file) {
    const zip    = new JSZip();
    const loaded = await zip.loadAsync(file);
    const pdfs   = [];
    zip.forEach((relativePath, entry) => {
        if (!entry.dir && relativePath.toLowerCase().endsWith('.pdf')) {
            pdfs.push(relativePath.split('/').pop());
        }
    });
    return pdfs;
}

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

function updateAnalyserBtn() {
    analyserBtn.disabled = !(currentFile && entrepriseEl.value);
}

// ── Render preview table ─────────────────────────────────────
function renderPreviewTable() {
    previewTbody.innerHTML = '';
    parsedFiles.forEach((row, idx) => {
        const tr = document.createElement('tr');
        let rowClass = 'bi-row-pend';
        if (row.statut === 'ok')    rowClass = 'bi-row-ok';
        if (row.statut === 'nf')    rowClass = 'bi-row-nf';
        if (row.statut === 'dup')   rowClass = 'bi-row-dup';
        if (row.statut === 'parse') rowClass = 'bi-row-parse';
        tr.className = rowClass;

        const policeHtml = row.police
            ? `<span class="bi-police-tag">${esc(row.police)}</span>`
            : `<span style="color:var(--bi-txt3)">—</span>`;
        const nomHtml = row.nom || `<span style="color:var(--bi-txt3)">—</span>`;
        const periodeHtml = row.periode
            ? `<span style="font-family:'DM Mono',monospace;font-weight:700;color:var(--bi-txt)">${esc(row.periode)}</span>`
            : `<span style="color:var(--bi-txt3)">—</span>`;

        let empHtml = `<span style="color:var(--bi-txt3)">—</span>`;
        if (row.statut === 'pend') {
            empHtml = `<span style="color:var(--bi-txt3);font-style:italic;font-size:.75rem;">en attente…</span>`;
        } else if (row.personnel) {
            empHtml = `<div class="bi-emp-name">${esc(row.personnel.nom_complet)}</div><div class="bi-emp-mat">Police ${esc(row.personnel.police || '—')} · ${esc(row.personnel.matricule || '—')}</div>`;
        } else if (row.statut === 'nf') {
            empHtml = `<span style="color:#f87171;font-size:.75rem;">Police introuvable</span>`;
        } else if (row.statut === 'dup') {
            empHtml = `<span style="color:#fbbf24;font-size:.75rem;">Doublon</span>`;
        }

        tr.innerHTML = `
            <td><div class="bi-file-mono" title="${esc(row.filename)}">${esc(row.filename)}</div></td>
            <td>${policeHtml}</td>
            <td style="color:var(--bi-txt2)">${esc(row.nom || '')||'<span style="color:var(--bi-txt3)">—</span>'}</td>
            <td>${periodeHtml}</td>
            <td>${empHtml}</td>
            <td>${pillFor(row)}</td>
        `;
        previewTbody.appendChild(tr);
    });
}

function pillFor(row) {
    switch (row.statut) {
        case 'ok':    return '<span class="bi-pill bi-pill-ok">✓ Prêt</span>';
        case 'nf':    return '<span class="bi-pill bi-pill-nf">✗ Introuvable</span>';
        case 'dup':   return '<span class="bi-pill bi-pill-dup">~ Doublon</span>';
        case 'parse': return '<span class="bi-pill bi-pill-parse">⚠ Format</span>';
        default:      return '<span class="bi-pill bi-pill-pend">⋯ En attente</span>';
    }
}

function esc(str) {
    if (!str) return '';
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

function updateChips() {
    const c = { ok:0, nf:0, dup:0, parse:0 };
    parsedFiles.forEach(r => { if (r.statut in c) c[r.statut]++; });
    document.getElementById('chipTotal').textContent = parsedFiles.length;
    document.getElementById('chipOk').textContent    = c.ok;
    document.getElementById('chipNf').textContent    = c.nf;
    document.getElementById('chipDup').textContent   = c.dup;
    document.getElementById('chipErr').textContent   = c.parse;
    if (c.nf > 0) {
        nfAlertText.textContent = `${c.nf} fichier(s) n'ont pas pu être associés — vérifiez que la police dans le nom du fichier correspond à un employé de cette entreprise.`;
        nfAlert.style.display = 'flex';
    } else {
        nfAlert.style.display = 'none';
    }
    lancerBtn.disabled = c.ok === 0;
}

// ── Drag & Drop ──────────────────────────────────────────────
dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('drag-over'); });
dropZone.addEventListener('dragleave', e => { if (!dropZone.contains(e.relatedTarget)) dropZone.classList.remove('drag-over'); });
dropZone.addEventListener('drop', e => {
    e.preventDefault(); dropZone.classList.remove('drag-over');
    const file = e.dataTransfer.files[0];
    if (file && file.name.toLowerCase().endsWith('.zip')) {
        const dt = new DataTransfer(); dt.items.add(file);
        fileInput.files = dt.files;
        currentFile = file; showFileInfo(file); updateAnalyserBtn(); parseZipContents(file);
    }
});
dropZone.addEventListener('click', e => { if (e.target !== changeBtn) fileInput.click(); });
changeBtn.addEventListener('click', e => { e.stopPropagation(); resetState(); fileInput.value=''; fileInput.click(); });
fileInput.addEventListener('change', () => {
    if (fileInput.files[0]) { currentFile = fileInput.files[0]; showFileInfo(currentFile); updateAnalyserBtn(); parseZipContents(currentFile); }
});
entrepriseEl.addEventListener('change', updateAnalyserBtn);

// ── Parse ZIP ────────────────────────────────────────────────
async function parseZipContents(file) {
    pdfCountBadge.textContent = '…'; pdfCountBadge.style.display = 'inline-flex';
    try {
        const pdfNames = await readZipPdfs(file);
        pdfCountBadge.textContent = pdfNames.length + ' PDF' + (pdfNames.length > 1 ? 's' : '');
        parsedFiles = pdfNames.map(name => {
            const p = parseFilename(name);
            if (!p) return { filename: name, police: null, nom: null, periode: null, statut: 'parse', personnel: null };
            return { filename: name, ...p, statut: 'pend', personnel: null };
        });
        updateChips(); renderPreviewTable();
        phasePreview.classList.add('visible'); setStep(2);
    } catch (err) {
        pdfCountBadge.textContent = 'Erreur ZIP'; console.error(err);
    }
}

// ── Analyser AJAX ────────────────────────────────────────────
analyserBtn.addEventListener('click', async () => {
    if (!entrepriseEl.value || !currentFile) return;
    const validFilenames = parsedFiles.filter(r => r.statut !== 'parse').map(r => r.filename);
    if (!validFilenames.length) return;

    analyserBtn.disabled = true;
    analyserBtn.innerHTML = `<svg class="bi-spinner" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Analyse…`;
    analyseMsg.classList.add('visible');

    try {
        const resp = await fetch(PREVIEW_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: JSON.stringify({ filenames: validFilenames, entreprise_id: entrepriseEl.value }),
        });
        if (!resp.ok) throw new Error(`Erreur serveur (${resp.status})`);
        const data = await resp.json();

        const resultMap = {};
        data.rows.forEach(row => { resultMap[row.fichier] = row; });

        parsedFiles = parsedFiles.map(local => {
            if (local.statut === 'parse') return local;
            const srv = resultMap[local.filename];
            if (!srv) return local;
            const statut = srv.statut === 'ok' ? 'ok' : srv.statut === 'doublon' ? 'dup' : srv.statut === 'not_found' ? 'nf' : 'parse';
            return { ...local, statut, personnel: srv.personnel ?? null };
        });

        analysed = true; updateChips(); renderPreviewTable(); setStep(2);
    } catch (err) {
        nfAlertText.innerHTML = '<strong>Erreur lors de l\'analyse :</strong> ' + err.message + ' — Vérifiez que les routes ont bien été rechargées sur le serveur (<code>php artisan route:clear</code>).';
        nfAlert.style.display = 'flex';
    } finally {
        analyserBtn.disabled = false;
        analyserBtn.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg> Ré-analyser`;
        analyseMsg.classList.remove('visible');
    }
});

// ── Lancer l'import ──────────────────────────────────────────
lancerBtn.addEventListener('click', () => {
    if (!currentFile || !entrepriseEl.value || !analysed) {
        lancerHintMsg.classList.add('visible');
        // Scroll to analyser button and flash it
        analyserBtn.scrollIntoView({ behavior: 'smooth', block: 'center' });
        analyserBtn.style.boxShadow = '0 0 0 4px rgba(245,158,11,.5)';
        setTimeout(() => { analyserBtn.style.boxShadow = ''; lancerHintMsg.classList.remove('visible'); }, 3000);
        return;
    }
    const okCount = parsedFiles.filter(r => r.statut === 'ok').length;
    if (okCount === 0) {
        lancerHintMsg.classList.add('visible');
        setTimeout(() => lancerHintMsg.classList.remove('visible'), 3000);
        return;
    }

    lancerBtn.disabled = true;
    lancerBtn.innerHTML = `<svg class="bi-spinner" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Envoi…`;
    importMsg.classList.add('visible');
    setStep(3);

    const dt = new DataTransfer(); dt.items.add(currentFile);
    hiddenZipInput.files = dt.files;
    hiddenEnt.value   = entrepriseEl.value;
    hiddenNotif.value = notifierEl.checked ? '1' : '0';
    importForm.submit();
});

// ── Reset ────────────────────────────────────────────────────
resetBtn.addEventListener('click', () => { resetState(); fileInput.value=''; });
function resetState() {
    currentFile = null; parsedFiles = []; analysed = false;
    dropZone.classList.remove('has-file');
    pdfCountBadge.style.display = 'none';
    phasePreview.classList.remove('visible');
    setStep(1); analyserBtn.disabled = true;
    analyserBtn.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg> Analyser les fichiers`;
}
</script>
@endsection
