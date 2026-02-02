@extends('layouts.app')

@section('title', 'Dossiers Agents')
@section('page-title', 'Dossiers Agents')
@section('page-subtitle', 'Gérez les documents du personnel')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
</svg>
@endsection

@section('styles')
<style>
/* ============================================================
   DOSSIERS AGENTS — Swiss Corporate Editorial Design System
   Geometric precision · Warm accents · Editorial typography
   ============================================================ */

@import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=DM+Serif+Display&display=swap');

:root {
    --e-slate-50: #f8fafc;
    --e-slate-100: #f1f5f9;
    --e-slate-200: #e2e8f0;
    --e-slate-300: #cbd5e1;
    --e-slate-400: #94a3b8;
    --e-slate-500: #64748b;
    --e-slate-600: #475569;
    --e-slate-700: #334155;
    --e-slate-800: #1e293b;
    --e-slate-900: #0f172a;
    --e-slate-950: #020617;
    --e-blue: #3b7dd8;
    --e-blue-deep: #2563a0;
    --e-blue-pale: #dbeafe;
    --e-blue-wash: #eff6ff;
    --e-amber: #e8850c;
    --e-amber-bright: #f59e0b;
    --e-amber-pale: #fef3c7;
    --e-amber-wash: #fffbeb;
    --e-emerald: #059669;
    --e-emerald-pale: #d1fae5;
    --e-red: #dc2626;
    --e-red-pale: #fee2e2;
    --e-surface: #ffffff;
    --e-bg: var(--e-slate-50);
    --e-text: var(--e-slate-900);
    --e-text-secondary: var(--e-slate-500);
    --e-text-tertiary: var(--e-slate-400);
    --e-border: var(--e-slate-200);
    --e-border-light: var(--e-slate-100);
    --e-shadow-sm: 0 1px 2px rgba(0,0,0,0.04);
    --e-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
    --e-shadow-md: 0 4px 6px -1px rgba(0,0,0,0.07), 0 2px 4px -2px rgba(0,0,0,0.05);
    --e-shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.08), 0 4px 6px -4px rgba(0,0,0,0.04);
    --e-shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.08), 0 8px 10px -6px rgba(0,0,0,0.04);
    --e-radius: 12px;
    --e-radius-lg: 16px;
    --e-radius-xl: 20px;
    --e-font-body: 'DM Sans', 'Plus Jakarta Sans', system-ui, sans-serif;
    --e-font-display: 'DM Serif Display', Georgia, serif;
}

.dark {
    --e-surface: var(--e-slate-800);
    --e-bg: var(--e-slate-900);
    --e-text: var(--e-slate-100);
    --e-text-secondary: var(--e-slate-400);
    --e-text-tertiary: var(--e-slate-500);
    --e-border: var(--e-slate-700);
    --e-border-light: var(--e-slate-800);
    --e-blue-pale: rgba(59, 125, 216, 0.15);
    --e-blue-wash: rgba(59, 125, 216, 0.08);
    --e-amber-pale: rgba(232, 133, 12, 0.15);
    --e-amber-wash: rgba(232, 133, 12, 0.08);
    --e-emerald-pale: rgba(5, 150, 105, 0.15);
    --e-red-pale: rgba(220, 38, 38, 0.15);
    --e-shadow-sm: 0 1px 2px rgba(0,0,0,0.2);
    --e-shadow: 0 1px 3px rgba(0,0,0,0.3);
    --e-shadow-md: 0 4px 6px rgba(0,0,0,0.25);
    --e-shadow-lg: 0 10px 15px rgba(0,0,0,0.3);
    --e-shadow-xl: 0 20px 25px rgba(0,0,0,0.35);
}

/* ==================== ANIMATIONS ==================== */
@keyframes da-fadeUp {
    from { opacity: 0; transform: translateY(14px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes da-countUp {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes da-slideDown {
    from { opacity: 0; transform: translateY(-10px) scale(0.98); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

@keyframes da-scaleIn {
    from { opacity: 0; transform: scale(0.97); }
    to { opacity: 1; transform: scale(1); }
}

@keyframes da-pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: .6; }
}

@keyframes da-shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
}

/* ==================== PAGE ==================== */
.da-page {
    font-family: var(--e-font-body);
    max-width: 1440px;
    margin: 0 auto;
    padding: 0 1.5rem 3rem;
    color: var(--e-text);
    animation: da-fadeUp 0.45s cubic-bezier(0.16, 1, 0.3, 1);
}

/* ==================== HEADER ==================== */
.da-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    padding: 2rem 0 1.75rem;
    border-bottom: 1px solid var(--e-border);
    margin-bottom: 1.75rem;
    gap: 1rem;
    animation: da-fadeUp 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}

.da-header-left h1 {
    font-family: var(--e-font-display);
    font-size: 2rem;
    font-weight: 400;
    color: var(--e-text);
    margin: 0;
    letter-spacing: -0.5px;
    line-height: 1.2;
}

.da-header-left p {
    font-size: 0.875rem;
    color: var(--e-text-secondary);
    margin: 0.375rem 0 0 0;
    font-weight: 500;
}

.da-header-actions {
    display: flex;
    gap: 0.625rem;
    flex-shrink: 0;
}

/* ==================== BUTTONS ==================== */
.da-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1.25rem;
    border-radius: var(--e-radius);
    font-family: var(--e-font-body);
    font-size: 0.8125rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1.5px solid transparent;
    text-decoration: none;
    white-space: nowrap;
    line-height: 1.4;
}

.da-btn svg { width: 16px; height: 16px; flex-shrink: 0; }

.da-btn-primary {
    background: var(--e-blue);
    color: #fff;
    border-color: var(--e-blue);
    box-shadow: 0 1px 3px rgba(59, 125, 216, 0.3);
}

.da-btn-primary:hover {
    background: var(--e-blue-deep);
    border-color: var(--e-blue-deep);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 125, 216, 0.35);
}

.da-btn-outline {
    background: var(--e-surface);
    color: var(--e-text-secondary);
    border-color: var(--e-border);
}

.da-btn-outline:hover {
    color: var(--e-text);
    border-color: var(--e-slate-300);
    background: var(--e-slate-50);
}

.dark .da-btn-outline { background: var(--e-slate-800); }
.dark .da-btn-outline:hover { background: var(--e-slate-700); border-color: var(--e-slate-600); }

.da-btn-warning {
    background: var(--e-amber-wash);
    color: var(--e-amber);
    border-color: var(--e-amber-pale);
}

.da-btn-warning:hover {
    background: var(--e-amber-pale);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(232, 133, 12, 0.2);
}

.da-btn-warning .da-badge-count {
    background: var(--e-amber);
    color: #fff;
    padding: 0.1rem 0.45rem;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 700;
    line-height: 1.3;
}

/* ==================== STATS STRIP ==================== */
.da-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-bottom: 1.75rem;
}

.da-stat {
    background: var(--e-surface);
    border: 1px solid var(--e-border);
    border-radius: var(--e-radius-lg);
    padding: 1.25rem 1.375rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: var(--e-shadow-sm);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
    overflow: hidden;
    animation: da-fadeUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) backwards;
}

.da-stat:nth-child(1) { animation-delay: 0.05s; }
.da-stat:nth-child(2) { animation-delay: 0.1s; }
.da-stat:nth-child(3) { animation-delay: 0.15s; }
.da-stat:nth-child(4) { animation-delay: 0.2s; }

.da-stat::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.da-stat:nth-child(1)::after { background: linear-gradient(90deg, var(--e-blue), var(--e-blue-deep)); }
.da-stat:nth-child(2)::after { background: linear-gradient(90deg, var(--e-emerald), #047857); }
.da-stat:nth-child(3)::after { background: linear-gradient(90deg, var(--e-red), #b91c1c); }
.da-stat:nth-child(4)::after { background: linear-gradient(90deg, var(--e-amber), #d97706); }

.da-stat:hover {
    box-shadow: var(--e-shadow-md);
    transform: translateY(-2px);
}

.da-stat:hover::after { opacity: 1; }

.da-stat-icon {
    width: 46px; height: 46px;
    border-radius: var(--e-radius);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.da-stat:hover .da-stat-icon { transform: scale(1.05); }

.da-stat-icon svg { width: 20px; height: 20px; }

.da-stat-icon.blue { background: var(--e-blue-pale); color: var(--e-blue); }
.da-stat-icon.emerald { background: var(--e-emerald-pale); color: var(--e-emerald); }
.da-stat-icon.red { background: var(--e-red-pale); color: var(--e-red); }
.da-stat-icon.amber { background: var(--e-amber-pale); color: var(--e-amber); }

.da-stat-content { flex: 1; min-width: 0; }

.da-stat-value {
    font-family: var(--e-font-display);
    font-size: 1.75rem;
    font-weight: 400;
    line-height: 1;
    color: var(--e-text);
    animation: da-countUp .6s cubic-bezier(0.16, 1, 0.3, 1) .3s both;
}

.da-stat-label {
    font-size: 0.6875rem;
    color: var(--e-text-secondary);
    margin-top: 0.3rem;
    font-weight: 600;
    letter-spacing: 0.4px;
    text-transform: uppercase;
}

/* ==================== ALERT BANNERS ==================== */
.da-alerts {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 0.875rem;
    margin-bottom: 1.75rem;
    animation: da-fadeUp 0.45s cubic-bezier(0.16, 1, 0.3, 1) 0.15s both;
}

.da-alert {
    background: var(--e-surface);
    border: 1px solid var(--e-border);
    border-radius: var(--e-radius-lg);
    padding: 1rem 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    position: relative;
    overflow: hidden;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: var(--e-shadow-sm);
}

.da-alert::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 4px;
}

.da-alert.danger::before { background: linear-gradient(180deg, var(--e-red), #b91c1c); }
.da-alert.warning::before { background: linear-gradient(180deg, var(--e-amber), #d97706); }

.da-alert:hover { box-shadow: var(--e-shadow-md); transform: translateY(-1px); }

.da-alert-icon {
    width: 40px; height: 40px;
    border-radius: var(--e-radius);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.da-alert-icon svg { width: 20px; height: 20px; }

.da-alert.danger .da-alert-icon { background: var(--e-red-pale); color: var(--e-red); }
.da-alert.warning .da-alert-icon { background: var(--e-amber-pale); color: var(--e-amber); }

.da-alert-body { flex: 1; }
.da-alert-title { font-size: 0.875rem; font-weight: 600; color: var(--e-text); margin: 0; }
.da-alert-desc { font-size: 0.75rem; color: var(--e-text-secondary); margin: 0.125rem 0 0; }

.da-alert-count {
    font-family: var(--e-font-display);
    font-size: 1.5rem;
    font-weight: 400;
    padding: 0 0.75rem;
}

.da-alert.danger .da-alert-count { color: var(--e-red); }
.da-alert.warning .da-alert-count { color: var(--e-amber); }

.da-alert-link {
    font-size: 0.75rem;
    font-weight: 600;
    text-decoration: none;
    padding: 0.4rem 0.75rem;
    border-radius: 8px;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    white-space: nowrap;
}

.da-alert.danger .da-alert-link { background: var(--e-red-pale); color: var(--e-red); }
.da-alert.warning .da-alert-link { background: var(--e-amber-pale); color: var(--e-amber); }
.da-alert-link:hover { transform: translateX(3px); }

/* ==================== TOOLBAR ==================== */
.da-toolbar {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    animation: da-fadeUp 0.45s cubic-bezier(0.16, 1, 0.3, 1) 0.2s both;
}

.da-search-wrap {
    flex: 1;
    position: relative;
    max-width: 480px;
}

.da-search-wrap svg {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    width: 18px; height: 18px;
    color: var(--e-text-tertiary);
    pointer-events: none;
    transition: color 0.2s ease;
}

.da-search-wrap:focus-within svg { color: var(--e-blue); }

.da-search-input {
    width: 100%;
    padding: 0.7rem 1rem 0.7rem 2.75rem;
    border: 1.5px solid var(--e-border);
    border-radius: var(--e-radius);
    font-family: var(--e-font-body);
    font-size: 0.875rem;
    background: var(--e-surface);
    color: var(--e-text);
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.da-search-input::placeholder { color: var(--e-text-tertiary); }

.da-search-input:hover { border-color: var(--e-slate-300); }
.da-search-input:focus { outline: none; border-color: var(--e-blue); box-shadow: 0 0 0 3px rgba(59, 125, 216, 0.1); }

.da-toolbar-right {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-left: auto;
}

.da-count-label {
    font-size: 0.8125rem;
    color: var(--e-text-secondary);
    font-weight: 500;
}

.da-count-label strong {
    color: var(--e-text);
    font-weight: 700;
}

/* ==================== EMPLOYEES GRID ==================== */
.da-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
    gap: 1.125rem;
    margin-bottom: 2rem;
}

/* ==================== EMPLOYEE CARD ==================== */
.da-card {
    background: var(--e-surface);
    border: 1px solid var(--e-border);
    border-radius: var(--e-radius-lg);
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
    box-shadow: var(--e-shadow-sm);
    animation: da-scaleIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) backwards;
}

.da-card::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--e-blue), var(--e-blue-deep));
    opacity: 0;
    transition: opacity 0.3s ease;
}

.da-card:hover {
    border-color: var(--e-blue);
    box-shadow: var(--e-shadow-lg);
    transform: translateY(-3px);
}

.da-card:hover::after { opacity: 1; }

.da-card-head {
    padding: 1.25rem 1.25rem 1rem;
    display: flex;
    align-items: center;
    gap: 0.875rem;
    border-bottom: 1px solid var(--e-border-light);
}

.da-avatar {
    width: 52px; height: 52px;
    border-radius: var(--e-radius);
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--e-font-body);
    font-weight: 700;
    font-size: 1rem;
    flex-shrink: 0;
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, var(--e-blue) 0%, var(--e-blue-deep) 100%);
    color: #fff;
    box-shadow: 0 2px 8px rgba(59, 125, 216, 0.25);
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.da-card:hover .da-avatar { transform: scale(1.04); }

.da-avatar img {
    width: 100%; height: 100%;
    object-fit: cover;
    border-radius: var(--e-radius);
}

.da-avatar-dot {
    position: absolute;
    bottom: -1px; right: -1px;
    width: 14px; height: 14px;
    border-radius: 50%;
    border: 2.5px solid var(--e-surface);
    transition: transform 0.2s ease;
}

.da-card:hover .da-avatar-dot { transform: scale(1.15); }

.da-avatar-dot.ok { background: var(--e-emerald); }
.da-avatar-dot.warn { background: var(--e-amber); }
.da-avatar-dot.err { background: var(--e-red); }

.da-card-identity { flex: 1; min-width: 0; }

.da-card-name {
    font-size: 0.9375rem;
    font-weight: 700;
    color: var(--e-text);
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.3;
}

.da-card-meta {
    display: flex;
    gap: 0.375rem;
    flex-wrap: wrap;
    margin-top: 0.3rem;
}

.da-card-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.6875rem;
    font-weight: 600;
    padding: 0.2rem 0.5rem;
    border-radius: 100px;
    background: var(--e-slate-100);
    color: var(--e-text-secondary);
    letter-spacing: 0.15px;
}

.dark .da-card-badge { background: var(--e-slate-700); }

.da-card-badge svg { width: 11px; height: 11px; }

.da-card-badge.blue {
    background: var(--e-blue-wash);
    color: var(--e-blue);
}
.dark .da-card-badge.blue { background: var(--e-blue-pale); }

/* Card Body */
.da-card-body {
    padding: 1rem 1.25rem 1.25rem;
}

.da-doc-row {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 0.875rem;
}

.da-doc-pill {
    flex: 1;
    text-align: center;
    padding: 0.625rem 0.375rem;
    border-radius: 10px;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.da-doc-pill::before {
    content: '';
    position: absolute;
    inset: 0;
    opacity: 0;
    transition: opacity 0.2s ease;
}

.da-doc-pill:hover { transform: translateY(-2px); }
.da-doc-pill:hover::before { opacity: 1; }

.da-doc-pill.total { background: var(--e-blue-wash); }
.da-doc-pill.valid { background: var(--e-emerald-pale); }
.da-doc-pill.expired { background: var(--e-red-pale); }

.da-doc-pill-val {
    font-family: var(--e-font-display);
    font-size: 1.25rem;
    font-weight: 400;
    line-height: 1;
    position: relative;
}

.da-doc-pill.total .da-doc-pill-val { color: var(--e-blue); }
.da-doc-pill.valid .da-doc-pill-val { color: var(--e-emerald); }
.da-doc-pill.expired .da-doc-pill-val { color: var(--e-red); }

.da-doc-pill-lbl {
    font-size: 0.625rem;
    color: var(--e-text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 700;
    margin-top: 0.25rem;
    position: relative;
}

/* Progress */
.da-progress {
    height: 4px;
    background: var(--e-border-light);
    border-radius: 2px;
    overflow: hidden;
    margin-bottom: 1rem;
}

.dark .da-progress { background: var(--e-slate-700); }

.da-progress-bar {
    height: 100%;
    border-radius: 2px;
    transition: width 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
}

.da-progress-bar::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    background-size: 200% 100%;
    animation: da-shimmer 2s ease-in-out infinite;
}

.da-progress-bar.good { background: var(--e-emerald); }
.da-progress-bar.mid { background: var(--e-amber); }
.da-progress-bar.low { background: var(--e-red); }

/* Card Actions */
.da-card-actions {
    display: flex;
    gap: 0.5rem;
}

.da-card-link {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
    padding: 0.625rem 0.75rem;
    background: var(--e-blue);
    color: #fff;
    border: none;
    border-radius: var(--e-radius);
    font-family: var(--e-font-body);
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    box-shadow: 0 1px 3px rgba(59, 125, 216, 0.25);
}

.da-card-link svg { width: 15px; height: 15px; }

.da-card-link:hover {
    background: var(--e-blue-deep);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 125, 216, 0.3);
}

.da-card-upload {
    width: 40px; height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: var(--e-radius);
    border: 1.5px solid var(--e-border);
    background: var(--e-surface);
    color: var(--e-emerald);
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    flex-shrink: 0;
}

.da-card-upload svg { width: 18px; height: 18px; }

.da-card-upload:hover {
    background: var(--e-emerald-pale);
    border-color: var(--e-emerald);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(5, 150, 105, 0.2);
}

/* ==================== EMPTY STATE ==================== */
.da-empty {
    text-align: center;
    padding: 4rem 2rem;
    background: var(--e-surface);
    border: 2px dashed var(--e-border);
    border-radius: var(--e-radius-xl);
    animation: da-fadeUp 0.45s cubic-bezier(0.16, 1, 0.3, 1) 0.2s both;
}

.da-empty-icon {
    width: 72px; height: 72px;
    margin: 0 auto 1.5rem;
    background: var(--e-blue-wash);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--e-blue);
}

.da-empty-icon svg { width: 32px; height: 32px; }

.da-empty h3 {
    font-family: var(--e-font-display);
    font-size: 1.375rem;
    font-weight: 400;
    color: var(--e-text);
    margin: 0 0 0.5rem;
}

.da-empty p {
    font-size: 0.875rem;
    color: var(--e-text-secondary);
    margin: 0 auto 1.5rem;
    max-width: 420px;
}

/* ==================== PAGINATION ==================== */
.da-pagination {
    display: flex;
    justify-content: center;
    padding: 1.5rem 0;
    animation: da-fadeUp 0.45s cubic-bezier(0.16, 1, 0.3, 1) 0.3s both;
}

.da-pagination nav { display: flex; gap: 0.25rem; }

.da-pagination .pagination {
    display: flex;
    gap: 0.25rem;
    list-style: none;
    margin: 0;
    padding: 0;
}

.da-pagination .page-item .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 36px;
    height: 36px;
    padding: 0 0.5rem;
    border-radius: 8px;
    font-size: 0.8125rem;
    font-weight: 600;
    font-family: var(--e-font-body);
    color: var(--e-text-secondary);
    background: var(--e-surface);
    border: 1px solid var(--e-border);
    text-decoration: none;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.da-pagination .page-item .page-link:hover {
    border-color: var(--e-blue);
    color: var(--e-blue);
    background: var(--e-blue-wash);
    transform: translateY(-1px);
}

.da-pagination .page-item.active .page-link {
    background: var(--e-blue);
    border-color: var(--e-blue);
    color: #fff;
    box-shadow: 0 2px 8px rgba(59, 125, 216, 0.3);
}

.da-pagination .page-item.disabled .page-link {
    opacity: .4;
    cursor: default;
    pointer-events: none;
}

/* ==================== MODAL ==================== */
.da-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    z-index: 99999;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}

.da-modal-overlay.show { display: flex; }

.da-modal {
    background: var(--e-surface);
    border-radius: var(--e-radius-xl);
    width: 100%;
    max-width: 540px;
    max-height: 90vh;
    overflow: hidden;
    box-shadow: var(--e-shadow-xl), 0 0 0 1px rgba(0,0,0,0.05);
    animation: da-slideDown .35s cubic-bezier(0.16, 1, 0.3, 1);
}

/* Dark Gradient Modal Header — matches entreprises/personnels pattern */
.da-modal-head {
    background: linear-gradient(135deg, var(--e-slate-800) 0%, var(--e-slate-900) 100%);
    padding: 1.375rem 1.75rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
}

.da-modal-head::before {
    content: '';
    position: absolute;
    top: -60%;
    right: -20%;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(59, 125, 216, 0.15) 0%, transparent 70%);
    border-radius: 50%;
}

.da-modal-head-left { display: flex; align-items: center; gap: 0.875rem; position: relative; }

.da-modal-icon {
    width: 44px; height: 44px;
    background: rgba(59, 125, 216, 0.2);
    color: #93bbeb;
    border-radius: var(--e-radius);
    display: flex;
    align-items: center;
    justify-content: center;
}

.da-modal-icon svg { width: 22px; height: 22px; }

.da-modal-title {
    font-family: var(--e-font-display);
    font-size: 1.125rem;
    font-weight: 400;
    color: #fff;
    margin: 0;
}

.da-modal-subtitle { font-size: 0.75rem; color: rgba(255,255,255,0.6); margin: 0.125rem 0 0; }

.da-modal-close {
    width: 36px; height: 36px;
    border-radius: 10px;
    border: 1.5px solid rgba(255,255,255,0.1);
    background: rgba(255,255,255,0.05);
    color: rgba(255,255,255,0.5);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    position: relative;
}

.da-modal-close svg { width: 18px; height: 18px; }
.da-modal-close:hover { border-color: rgba(220, 38, 38, 0.4); color: #fca5a5; background: rgba(220, 38, 38, 0.15); }

.da-modal-body {
    padding: 1.5rem 1.75rem;
    overflow-y: auto;
    max-height: calc(90vh - 200px);
}

.da-form-group { margin-bottom: 1.25rem; }

.da-form-label {
    display: block;
    font-size: 0.6875rem;
    font-weight: 700;
    color: var(--e-text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.4px;
    margin-bottom: 0.5rem;
}

.da-form-select,
.da-form-input {
    width: 100%;
    padding: 0.625rem 1rem;
    border: 1.5px solid var(--e-border);
    border-radius: var(--e-radius);
    font-family: var(--e-font-body);
    font-size: 0.8125rem;
    background: var(--e-bg);
    color: var(--e-text);
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.da-form-select:hover,
.da-form-input:hover { border-color: var(--e-slate-300); }

.da-form-select:focus,
.da-form-input:focus {
    outline: none;
    border-color: var(--e-blue);
    box-shadow: 0 0 0 3px rgba(59, 125, 216, 0.1);
    background: var(--e-surface);
}

.da-form-select option { background: var(--e-surface); color: var(--e-text); }

/* File Upload Zone */
.da-file-zone {
    border: 2px dashed var(--e-border);
    border-radius: var(--e-radius-lg);
    padding: 2rem 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    background: var(--e-bg);
    position: relative;
}

.da-file-zone:hover,
.da-file-zone.dragover {
    border-color: var(--e-blue);
    background: var(--e-blue-wash);
}

.da-file-zone:hover .da-file-zone-icon { transform: scale(1.08) translateY(-2px); }

.da-file-zone input { display: none; }

.da-file-zone-icon {
    width: 52px; height: 52px;
    margin: 0 auto 0.875rem;
    background: var(--e-blue-pale);
    border-radius: var(--e-radius);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--e-blue);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.da-file-zone-icon svg { width: 24px; height: 24px; }

.da-file-zone-text {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--e-text);
    margin: 0 0 0.25rem;
}

.da-file-zone-hint {
    font-size: 0.75rem;
    color: var(--e-text-tertiary);
    margin: 0;
}

.da-selected-files {
    margin-top: 0.75rem;
    font-size: 0.8125rem;
    color: var(--e-emerald);
    font-weight: 600;
}

/* Modal Footer */
.da-modal-foot {
    padding: 1rem 1.75rem;
    border-top: 1px solid var(--e-border);
    display: flex;
    justify-content: flex-end;
    gap: 0.625rem;
    background: var(--e-bg);
}

/* ==================== TOAST ==================== */
.da-toast {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    padding: 0.875rem 1.25rem;
    border-radius: var(--e-radius);
    display: flex;
    align-items: center;
    gap: 0.625rem;
    font-family: var(--e-font-body);
    font-size: 0.85rem;
    font-weight: 600;
    z-index: 100000;
    box-shadow: var(--e-shadow-xl);
    animation: da-slideDown .3s cubic-bezier(0.16, 1, 0.3, 1);
    transition: all .3s cubic-bezier(0.16, 1, 0.3, 1);
}

.da-toast svg { width: 18px; height: 18px; flex-shrink: 0; }
.da-toast.success { background: var(--e-emerald); color: #fff; }
.da-toast.error { background: var(--e-red); color: #fff; }

/* ==================== RESPONSIVE ==================== */
@media (max-width: 1024px) {
    .da-stats { grid-template-columns: repeat(2, 1fr); }
    .da-grid { grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); }
}

@media (max-width: 768px) {
    .da-page { padding: 0 1rem 2rem; }
    .da-header { flex-direction: column; align-items: flex-start; }
    .da-header-actions { width: 100%; }
    .da-header-actions .da-btn { flex: 1; justify-content: center; }
    .da-stats { grid-template-columns: 1fr 1fr; }
    .da-toolbar { flex-direction: column; }
    .da-search-wrap { max-width: none; }
    .da-toolbar-right { width: 100%; justify-content: space-between; }
    .da-grid { grid-template-columns: 1fr; }
    .da-alerts { grid-template-columns: 1fr; }
    .da-alert { flex-wrap: wrap; }
}

@media (max-width: 480px) {
    .da-stats { grid-template-columns: 1fr; }
    .da-header-left h1 { font-size: 1.5rem; }
}
</style>
@endsection

@section('content')
<div class="da-page">
    <!-- Header -->
    <div class="da-header">
        <div class="da-header-left">
            <h1>Dossiers Agents</h1>
            <p>Gestion centralisée des documents de vos collaborateurs</p>
        </div>
        <div class="da-header-actions">
            @if($stats['documents_expires'] + $stats['documents_expirent_bientot'] > 0)
            <a href="{{ route('admin.dossier-agent.alertes') }}" class="da-btn da-btn-warning">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                Alertes
                <span class="da-badge-count">{{ $stats['documents_expires'] + $stats['documents_expirent_bientot'] }}</span>
            </a>
            @endif
            <a href="{{ route('admin.personnels.index') }}" class="da-btn da-btn-outline">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Personnel
            </a>
        </div>
    </div>

    <!-- Stats -->
    <div class="da-stats">
        <div class="da-stat">
            <div class="da-stat-icon blue">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div class="da-stat-content">
                <div class="da-stat-value" data-count="{{ $stats['total_personnels'] }}">{{ $stats['total_personnels'] }}</div>
                <div class="da-stat-label">Employés</div>
            </div>
        </div>
        <div class="da-stat">
            <div class="da-stat-icon emerald">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="da-stat-content">
                <div class="da-stat-value" data-count="{{ $stats['total_documents'] }}">{{ $stats['total_documents'] }}</div>
                <div class="da-stat-label">Documents</div>
            </div>
        </div>
        <div class="da-stat">
            <div class="da-stat-icon red">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="da-stat-content">
                <div class="da-stat-value" data-count="{{ $stats['documents_expires'] }}">{{ $stats['documents_expires'] }}</div>
                <div class="da-stat-label">Expirés</div>
            </div>
        </div>
        <div class="da-stat">
            <div class="da-stat-icon amber">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="da-stat-content">
                <div class="da-stat-value" data-count="{{ $stats['documents_expirent_bientot'] }}">{{ $stats['documents_expirent_bientot'] }}</div>
                <div class="da-stat-label">Expirent bientôt</div>
            </div>
        </div>
    </div>

    <!-- Alert Banners -->
    @if($stats['documents_expires'] > 0 || $stats['documents_expirent_bientot'] > 0)
    <div class="da-alerts">
        @if($stats['documents_expires'] > 0)
        <div class="da-alert danger">
            <div class="da-alert-icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="da-alert-body">
                <p class="da-alert-title">Documents expirés</p>
                <p class="da-alert-desc">Action requise immédiatement</p>
            </div>
            <div class="da-alert-count">{{ $stats['documents_expires'] }}</div>
            <a href="{{ route('admin.dossier-agent.alertes') }}?type=expires" class="da-alert-link">Voir détails →</a>
        </div>
        @endif
        @if($stats['documents_expirent_bientot'] > 0)
        <div class="da-alert warning">
            <div class="da-alert-icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="da-alert-body">
                <p class="da-alert-title">Expirent dans 30 jours</p>
                <p class="da-alert-desc">Prévoir le renouvellement</p>
            </div>
            <div class="da-alert-count">{{ $stats['documents_expirent_bientot'] }}</div>
            <a href="{{ route('admin.dossier-agent.alertes') }}?type=bientot" class="da-alert-link">Voir détails →</a>
        </div>
        @endif
    </div>
    @endif

    <!-- Toolbar -->
    <div class="da-toolbar">
        <form action="{{ route('admin.dossiers-agents.index') }}" method="GET" class="da-search-wrap" id="searchForm">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="search" class="da-search-input" placeholder="Rechercher par nom, prénom ou matricule..." value="{{ request('search') }}" id="daSearchInput">
        </form>
        <div class="da-toolbar-right">
            @if(request('search'))
            <a href="{{ route('admin.dossiers-agents.index') }}" class="da-btn da-btn-outline" style="padding: 0.55rem 0.75rem;">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Réinitialiser
            </a>
            @endif
            <span class="da-count-label"><strong>{{ $personnels->total() }}</strong> employé{{ $personnels->total() > 1 ? 's' : '' }}</span>
        </div>
    </div>

    <!-- Grid -->
    @if($personnels->count() > 0)
    <div class="da-grid">
        @foreach($personnels as $personnel)
        @php
            $totalDocs = $personnel->documents_count;
            $activeDocs = $personnel->documents()->actifs()->count();
            $expiredDocs = $personnel->documents()->expires()->count();
            $validPercent = $totalDocs > 0 ? round($activeDocs / $totalDocs * 100) : 100;
            $statusClass = $expiredDocs > 0 ? 'err' : ($activeDocs < $totalDocs ? 'warn' : 'ok');
            $progressClass = $validPercent >= 80 ? 'good' : ($validPercent >= 50 ? 'mid' : 'low');
        @endphp
        <div class="da-card" style="animation-delay: {{ $loop->index * 0.04 }}s">
            <div class="da-card-head">
                <div class="da-avatar">
                    @if($personnel->photo)
                        <img src="{{ asset('storage/' . $personnel->photo) }}" alt="{{ $personnel->nom }}">
                    @else
                        {{ strtoupper(substr($personnel->nom, 0, 1) . substr($personnel->prenoms ?? '', 0, 1)) }}
                    @endif
                    <span class="da-avatar-dot {{ $statusClass }}"></span>
                </div>
                <div class="da-card-identity">
                    <h3 class="da-card-name">{{ $personnel->nom }} {{ $personnel->prenoms }}</h3>
                    <div class="da-card-meta">
                        @if($personnel->matricule)
                        <span class="da-card-badge">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                            </svg>
                            {{ $personnel->matricule }}
                        </span>
                        @endif
                        @if($personnel->poste)
                        <span class="da-card-badge blue">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ $personnel->poste }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="da-card-body">
                <div class="da-doc-row">
                    <div class="da-doc-pill total">
                        <div class="da-doc-pill-val">{{ $totalDocs }}</div>
                        <div class="da-doc-pill-lbl">Total</div>
                    </div>
                    <div class="da-doc-pill valid">
                        <div class="da-doc-pill-val">{{ $activeDocs }}</div>
                        <div class="da-doc-pill-lbl">Valides</div>
                    </div>
                    <div class="da-doc-pill expired">
                        <div class="da-doc-pill-val">{{ $expiredDocs }}</div>
                        <div class="da-doc-pill-lbl">Expirés</div>
                    </div>
                </div>

                @if($totalDocs > 0)
                <div class="da-progress">
                    <div class="da-progress-bar {{ $progressClass }}" style="width: {{ $validPercent }}%"></div>
                </div>
                @endif

                <div class="da-card-actions">
                    <a href="{{ route('admin.dossier-agent.show', $personnel) }}" class="da-card-link">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"/>
                        </svg>
                        Ouvrir le dossier
                    </a>
                    <button type="button" class="da-card-upload" onclick="openQuickUpload({{ $personnel->id }}, '{{ addslashes($personnel->nom . ' ' . $personnel->prenoms) }}')" title="Upload rapide">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($personnels->hasPages())
    <div class="da-pagination">
        {{ $personnels->withQueryString()->links() }}
    </div>
    @endif

    @else
    <div class="da-empty">
        <div class="da-empty-icon">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <h3>Aucun employé trouvé</h3>
        <p>
            @if(request('search'))
                Aucun résultat ne correspond à votre recherche. Essayez d'autres termes.
            @else
                Commencez par ajouter des employés pour gérer leurs dossiers documentaires.
            @endif
        </p>
        @if(request('search'))
        <a href="{{ route('admin.dossiers-agents.index') }}" class="da-btn da-btn-outline">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Réinitialiser
        </a>
        @else
        <a href="{{ route('admin.personnels.index') }}" class="da-btn da-btn-primary">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
            Gérer les employés
        </a>
        @endif
    </div>
    @endif
</div>

<!-- Quick Upload Modal -->
<div class="da-modal-overlay" id="quickUploadModal">
    <div class="da-modal">
        <div class="da-modal-head">
            <div class="da-modal-head-left">
                <div class="da-modal-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                </div>
                <div>
                    <h3 class="da-modal-title">Upload rapide</h3>
                    <p class="da-modal-subtitle" id="modalEmployeeName">Ajouter des documents</p>
                </div>
            </div>
            <button class="da-modal-close" onclick="closeQuickUpload()">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <form id="quickUploadForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="personnel_id" id="quickUploadPersonnelId">
            <div class="da-modal-body">
                <div class="da-form-group">
                    <label class="da-form-label">Catégorie du document</label>
                    <select name="categorie_id" class="da-form-select">
                        <option value="">Sélectionner une catégorie...</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="da-form-group">
                    <label class="da-form-label">Document(s)</label>
                    <label class="da-file-zone" id="fileUploadLabel">
                        <input type="file" name="documents[]" id="fileInput" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.webp">
                        <div class="da-file-zone-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                        </div>
                        <p class="da-file-zone-text">Cliquez ou glissez-déposez vos fichiers</p>
                        <p class="da-file-zone-hint">PDF, DOC, XLS, Images — max 10 Mo par fichier</p>
                    </label>
                    <div class="da-selected-files" id="selectedFiles"></div>
                </div>
            </div>
            <div class="da-modal-foot">
                <button type="button" class="da-btn da-btn-outline" onclick="closeQuickUpload()">Annuler</button>
                <button type="submit" class="da-btn da-btn-primary" id="uploadSubmitBtn">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    Uploader
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
console.log('[Dossiers Agents] Init');

/* ==================== MODAL ==================== */
const quickUploadModal = document.getElementById('quickUploadModal');
const quickUploadForm = document.getElementById('quickUploadForm');
const fileInput = document.getElementById('fileInput');
const selectedFilesDiv = document.getElementById('selectedFiles');
const fileUploadLabel = document.getElementById('fileUploadLabel');

function openQuickUpload(personnelId, employeeName) {
    document.getElementById('quickUploadPersonnelId').value = personnelId;
    document.getElementById('modalEmployeeName').textContent = employeeName;
    quickUploadModal.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeQuickUpload() {
    quickUploadModal.classList.remove('show');
    document.body.style.overflow = '';
    quickUploadForm.reset();
    selectedFilesDiv.textContent = '';
    fileUploadLabel.classList.remove('dragover');
}

/* ==================== FILE INPUT ==================== */
fileInput.addEventListener('change', function() {
    const files = Array.from(this.files);
    if (files.length > 0) {
        selectedFilesDiv.innerHTML = files.map(f => `<div>✓ ${f.name}</div>`).join('');
    } else {
        selectedFilesDiv.textContent = '';
    }
});

/* ==================== DRAG & DROP ==================== */
['dragenter', 'dragover', 'dragleave', 'drop'].forEach(evt => {
    fileUploadLabel.addEventListener(evt, function(e) {
        e.preventDefault();
        e.stopPropagation();
    }, false);
});

['dragenter', 'dragover'].forEach(evt => {
    fileUploadLabel.addEventListener(evt, () => fileUploadLabel.classList.add('dragover'));
});

['dragleave', 'drop'].forEach(evt => {
    fileUploadLabel.addEventListener(evt, () => fileUploadLabel.classList.remove('dragover'));
});

fileUploadLabel.addEventListener('drop', function(e) {
    fileInput.files = e.dataTransfer.files;
    fileInput.dispatchEvent(new Event('change'));
});

/* ==================== UPLOAD SUBMIT ==================== */
quickUploadForm.addEventListener('submit', async function(e) {
    e.preventDefault();

    const submitBtn = document.getElementById('uploadSubmitBtn');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<svg style="animation: da-pulse 1s infinite" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/></svg> Upload...';
    submitBtn.disabled = true;

    const personnelId = document.getElementById('quickUploadPersonnelId').value;
    const formData = new FormData(this);

    try {
        const response = await fetch(`/admin/dossier-agent/${personnelId}/upload-multiple`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            showToast(data.message || 'Documents uploadés avec succès', 'success');
            closeQuickUpload();
            setTimeout(() => window.location.reload(), 1500);
        } else {
            showToast(data.message || 'Erreur lors de l\'upload', 'error');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showToast('Erreur de connexion', 'error');
    } finally {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
});

/* ==================== MODAL CLOSE ==================== */
quickUploadModal.addEventListener('click', function(e) {
    if (e.target === this) closeQuickUpload();
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && quickUploadModal.classList.contains('show')) closeQuickUpload();
});

/* ==================== SEARCH ==================== */
document.getElementById('daSearchInput').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('searchForm').submit();
    }
});

/* ==================== TOAST ==================== */
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `da-toast ${type}`;
    toast.innerHTML = `
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            ${type === 'success'
                ? '<path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'
                : '<path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'}
        </svg>
        ${message}
    `;
    document.body.appendChild(toast);
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(20px)';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

/* ==================== COUNTER ANIMATION ==================== */
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.da-stat-value[data-count]').forEach(el => {
        const target = parseInt(el.dataset.count);
        if (target === 0) return;
        el.textContent = '0';
        const duration = 600;
        const start = performance.now();
        function tick(now) {
            const elapsed = now - start;
            const progress = Math.min(elapsed / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.round(eased * target);
            if (progress < 1) requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
    });
});
</script>
@endsection
