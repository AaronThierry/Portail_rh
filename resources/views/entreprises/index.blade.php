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
/* ============================================================
   ENTREPRISES — Swiss Corporate Editorial Design System
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

/* ==================== PAGE CONTAINER ==================== */
.ent-page {
    font-family: var(--e-font-body);
    max-width: 1440px;
    margin: 0 auto;
    padding: 0 1.5rem 3rem;
    color: var(--e-text);
}

/* ==================== PAGE HEADER ==================== */
.ent-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    padding: 2rem 0 1.75rem;
    border-bottom: 1px solid var(--e-border);
    margin-bottom: 1.75rem;
    gap: 1rem;
}

.ent-header-left h1 {
    font-family: var(--e-font-display);
    font-size: 2rem;
    font-weight: 400;
    color: var(--e-text);
    margin: 0;
    letter-spacing: -0.5px;
    line-height: 1.2;
}

.ent-header-left p {
    font-size: 0.9rem;
    color: var(--e-text-secondary);
    margin: 0.375rem 0 0 0;
    font-weight: 400;
}

.ent-header-actions {
    display: flex;
    gap: 0.625rem;
    flex-shrink: 0;
}

/* ==================== BUTTONS ==================== */
.btn-e {
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
    line-height: 1.4;
}

.btn-e svg {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
}

.btn-e-primary {
    background: var(--e-blue);
    color: #fff;
    border-color: var(--e-blue);
    box-shadow: 0 1px 3px rgba(59, 125, 216, 0.3);
}

.btn-e-primary:hover {
    background: var(--e-blue-deep);
    border-color: var(--e-blue-deep);
    box-shadow: 0 4px 12px rgba(59, 125, 216, 0.35);
    transform: translateY(-1px);
}

.btn-e-outline {
    background: var(--e-surface);
    color: var(--e-text-secondary);
    border-color: var(--e-border);
}

.btn-e-outline:hover {
    color: var(--e-text);
    border-color: var(--e-slate-300);
    background: var(--e-slate-50);
}

.dark .btn-e-outline {
    background: var(--e-slate-800);
}

.dark .btn-e-outline:hover {
    background: var(--e-slate-700);
    border-color: var(--e-slate-600);
}

/* ==================== STATS ROW ==================== */
.ent-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.ent-stat {
    background: var(--e-surface);
    border: 1px solid var(--e-border);
    border-radius: var(--e-radius-lg);
    padding: 1.25rem 1.375rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.ent-stat::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 3px;
    height: 100%;
    opacity: 0;
    transition: opacity 0.25s;
}

.ent-stat:hover {
    box-shadow: var(--e-shadow-md);
    transform: translateY(-2px);
}

.ent-stat:hover::after { opacity: 1; }

.ent-stat.s-blue::after { background: var(--e-blue); }
.ent-stat.s-green::after { background: var(--e-emerald); }
.ent-stat.s-red::after { background: var(--e-red); }
.ent-stat.s-amber::after { background: var(--e-amber); }

.ent-stat-icon {
    width: 44px;
    height: 44px;
    border-radius: var(--e-radius);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.ent-stat-icon svg { width: 20px; height: 20px; }

.s-blue .ent-stat-icon { background: var(--e-blue-pale); color: var(--e-blue); }
.s-green .ent-stat-icon { background: var(--e-emerald-pale); color: var(--e-emerald); }
.s-red .ent-stat-icon { background: var(--e-red-pale); color: var(--e-red); }
.s-amber .ent-stat-icon { background: var(--e-amber-pale); color: var(--e-amber); }

.ent-stat-text h3 {
    font-family: var(--e-font-display);
    font-size: 1.625rem;
    font-weight: 400;
    color: var(--e-text);
    margin: 0;
    line-height: 1;
}

.ent-stat-text p {
    font-size: 0.75rem;
    color: var(--e-text-secondary);
    margin: 0.25rem 0 0 0;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.4px;
}

/* ==================== NOTIFICATIONS ==================== */
.ent-alert {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.875rem 1.25rem;
    border-radius: var(--e-radius);
    margin-bottom: 1.25rem;
    font-size: 0.875rem;
    font-weight: 500;
    border: 1px solid;
    animation: ent-slideDown 0.3s ease;
}

@keyframes ent-slideDown {
    from { opacity: 0; transform: translateY(-8px); }
    to { opacity: 1; transform: translateY(0); }
}

.ent-alert-success {
    background: var(--e-emerald-pale);
    border-color: rgba(5, 150, 105, 0.2);
    color: #065f46;
}

.dark .ent-alert-success { color: #6ee7b7; }

.ent-alert-error {
    background: var(--e-red-pale);
    border-color: rgba(220, 38, 38, 0.2);
    color: #991b1b;
}

.dark .ent-alert-error { color: #fca5a5; }

.ent-alert svg { width: 18px; height: 18px; flex-shrink: 0; }

/* ==================== TOOLBAR ==================== */
.ent-toolbar {
    background: var(--e-surface);
    border: 1px solid var(--e-border);
    border-radius: var(--e-radius-lg);
    padding: 0.875rem 1.25rem;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.875rem;
    flex-wrap: wrap;
}

.ent-search {
    flex: 1;
    min-width: 220px;
    position: relative;
}

.ent-search svg {
    position: absolute;
    left: 0.875rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--e-text-tertiary);
    width: 16px;
    height: 16px;
    pointer-events: none;
}

.ent-search input {
    width: 100%;
    padding: 0.5rem 0.875rem 0.5rem 2.5rem;
    border: 1.5px solid var(--e-border);
    border-radius: var(--e-radius);
    background: var(--e-bg);
    color: var(--e-text);
    font-family: var(--e-font-body);
    font-size: 0.8125rem;
    transition: all 0.2s;
}

.ent-search input:focus {
    outline: none;
    border-color: var(--e-blue);
    box-shadow: 0 0 0 3px rgba(59, 125, 216, 0.1);
}

.ent-search input::placeholder {
    color: var(--e-text-tertiary);
}

.ent-filters {
    display: flex;
    gap: 0.375rem;
}

.ent-filter-btn {
    padding: 0.4375rem 0.875rem;
    border: 1.5px solid var(--e-border);
    border-radius: 100px;
    background: transparent;
    color: var(--e-text-secondary);
    font-family: var(--e-font-body);
    font-size: 0.75rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 0.375rem;
    white-space: nowrap;
}

.ent-filter-btn:hover {
    border-color: var(--e-blue);
    color: var(--e-blue);
}

.ent-filter-btn.active {
    background: var(--e-blue);
    border-color: var(--e-blue);
    color: #fff;
}

.ent-filter-count {
    font-size: 0.6875rem;
    padding: 0.0625rem 0.4375rem;
    border-radius: 100px;
    background: rgba(255,255,255,0.2);
    font-weight: 700;
    min-width: 18px;
    text-align: center;
}

.ent-filter-btn:not(.active) .ent-filter-count {
    background: var(--e-border);
    color: var(--e-text-secondary);
}

.ent-view-toggle {
    display: flex;
    background: var(--e-bg);
    border-radius: var(--e-radius);
    padding: 0.1875rem;
    border: 1px solid var(--e-border);
}

.ent-view-btn {
    padding: 0.375rem 0.625rem;
    border: none;
    background: transparent;
    color: var(--e-text-tertiary);
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
}

.ent-view-btn:hover { color: var(--e-text-secondary); }

.ent-view-btn.active {
    background: var(--e-surface);
    color: var(--e-blue);
    box-shadow: var(--e-shadow-sm);
}

.ent-view-btn svg { width: 16px; height: 16px; }

/* ==================== GRID VIEW ==================== */
.ent-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    gap: 1rem;
}

.ent-card {
    background: var(--e-surface);
    border: 1px solid var(--e-border);
    border-radius: var(--e-radius-lg);
    padding: 1.375rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    display: flex;
    flex-direction: column;
}

.ent-card:hover {
    box-shadow: var(--e-shadow-lg);
    border-color: var(--e-slate-300);
    transform: translateY(-3px);
}

.dark .ent-card:hover {
    border-color: var(--e-slate-600);
}

.ent-card-top {
    display: flex;
    align-items: flex-start;
    gap: 0.875rem;
    margin-bottom: 1.125rem;
}

.ent-card-logo {
    width: 48px;
    height: 48px;
    border-radius: var(--e-radius);
    flex-shrink: 0;
    overflow: hidden;
    border: 1px solid var(--e-border);
}

.ent-card-logo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.ent-card-logo-ph {
    width: 48px;
    height: 48px;
    border-radius: var(--e-radius);
    background: linear-gradient(135deg, var(--e-blue) 0%, var(--e-blue-deep) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 700;
    font-size: 0.875rem;
    letter-spacing: -0.5px;
    flex-shrink: 0;
}

.ent-card-identity {
    flex: 1;
    min-width: 0;
}

.ent-card-name {
    font-family: var(--e-font-body);
    font-size: 0.9375rem;
    font-weight: 700;
    color: var(--e-text);
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.3;
}

.ent-card-sigle {
    font-size: 0.6875rem;
    color: var(--e-text-tertiary);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.75px;
    margin-top: 0.125rem;
}

.ent-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.3125rem;
    padding: 0.25rem 0.625rem;
    border-radius: 100px;
    font-size: 0.625rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    flex-shrink: 0;
    margin-left: auto;
}

.ent-badge-active {
    background: var(--e-emerald-pale);
    color: var(--e-emerald);
}

.ent-badge-inactive {
    background: var(--e-red-pale);
    color: var(--e-red);
}

.ent-badge-dot {
    width: 5px;
    height: 5px;
    border-radius: 50%;
    background: currentColor;
}

.ent-badge-active .ent-badge-dot {
    animation: ent-pulse 2s infinite;
}

@keyframes ent-pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.4; }
}

/* Card Details */
.ent-card-details {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    flex: 1;
    margin-bottom: 1.125rem;
}

.ent-card-row {
    display: flex;
    align-items: center;
    gap: 0.625rem;
}

.ent-card-row-icon {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    background: var(--e-bg);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: var(--e-text-tertiary);
}

.ent-card-row-icon svg { width: 14px; height: 14px; }

.ent-card-row-label {
    font-size: 0.6875rem;
    color: var(--e-text-tertiary);
    text-transform: uppercase;
    letter-spacing: 0.3px;
    font-weight: 600;
    min-width: 60px;
}

.ent-card-row-value {
    font-size: 0.8125rem;
    color: var(--e-text);
    font-weight: 500;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    flex: 1;
}

/* Card Footer */
.ent-card-footer {
    display: flex;
    gap: 0.5rem;
    padding-top: 1rem;
    border-top: 1px solid var(--e-border-light);
    margin-top: auto;
}

.ent-card-btn {
    flex: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.375rem;
    padding: 0.5rem;
    border-radius: var(--e-radius);
    font-family: var(--e-font-body);
    font-size: 0.75rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    border: 1.5px solid transparent;
    text-decoration: none;
}

.ent-card-btn svg { width: 14px; height: 14px; }

.ent-card-btn-view {
    background: var(--e-blue-wash);
    color: var(--e-blue);
    border-color: transparent;
}

.ent-card-btn-view:hover {
    background: var(--e-blue);
    color: #fff;
}

.ent-card-btn-edit {
    background: var(--e-amber-wash);
    color: var(--e-amber);
    border-color: transparent;
}

.ent-card-btn-edit:hover {
    background: var(--e-amber);
    color: #fff;
}

.ent-card-btn-delete {
    background: var(--e-red-pale);
    color: var(--e-red);
    border-color: transparent;
    flex: 0;
    padding: 0.5rem 0.625rem;
}

.ent-card-btn-delete:hover {
    background: var(--e-red);
    color: #fff;
}

/* ==================== TABLE VIEW ==================== */
.ent-table-wrap {
    background: var(--e-surface);
    border: 1px solid var(--e-border);
    border-radius: var(--e-radius-lg);
    overflow: hidden;
}

.ent-table {
    width: 100%;
    border-collapse: collapse;
}

.ent-table thead {
    background: var(--e-bg);
    border-bottom: 1px solid var(--e-border);
}

.ent-table th {
    padding: 0.75rem 1.25rem;
    text-align: left;
    font-size: 0.6875rem;
    font-weight: 700;
    color: var(--e-text-tertiary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.ent-table tbody tr {
    border-bottom: 1px solid var(--e-border-light);
    transition: background 0.15s;
}

.ent-table tbody tr:last-child { border-bottom: none; }
.ent-table tbody tr:hover { background: var(--e-blue-wash); }

.ent-table td {
    padding: 0.875rem 1.25rem;
    font-size: 0.8125rem;
    color: var(--e-text);
}

.ent-table-company {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.ent-table-company-info { display: flex; flex-direction: column; }

.ent-table-company-name {
    font-weight: 700;
    color: var(--e-text);
}

.ent-table-company-sigle {
    font-size: 0.6875rem;
    color: var(--e-text-tertiary);
    font-weight: 500;
}

.ent-table-actions {
    display: flex;
    gap: 0.375rem;
}

.ent-table-btn {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
}

.ent-table-btn svg { width: 15px; height: 15px; }

/* ==================== EMPTY STATE ==================== */
.ent-empty {
    text-align: center;
    padding: 4rem 2rem;
    grid-column: 1 / -1;
}

.ent-empty-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.25rem;
    background: var(--e-blue-wash);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--e-blue);
}

.ent-empty-icon svg { width: 36px; height: 36px; opacity: 0.6; }

.ent-empty h3 {
    font-family: var(--e-font-display);
    font-size: 1.375rem;
    font-weight: 400;
    color: var(--e-text);
    margin: 0 0 0.375rem 0;
}

.ent-empty p {
    color: var(--e-text-secondary);
    margin: 0 0 1.5rem 0;
    font-size: 0.875rem;
}

/* ==================== MODAL ==================== */
.ent-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    padding: 1.5rem;
    opacity: 0;
    transition: opacity 0.25s ease;
}

.ent-modal-overlay.show {
    display: flex;
    opacity: 1;
}

.ent-modal {
    background: var(--e-surface);
    border-radius: var(--e-radius-xl);
    width: 100%;
    max-width: 720px;
    max-height: 88vh;
    box-shadow: var(--e-shadow-xl), 0 0 0 1px var(--e-border);
    animation: ent-modalIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

@keyframes ent-modalIn {
    from { opacity: 0; transform: scale(0.96) translateY(12px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}

/* Modal Header */
.ent-modal-header {
    background: linear-gradient(135deg, var(--e-slate-800) 0%, var(--e-slate-900) 100%);
    padding: 1.375rem 1.75rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
}

.ent-modal-header::before {
    content: '';
    position: absolute;
    top: -60%;
    right: -20%;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(232, 133, 12, 0.15) 0%, transparent 70%);
    border-radius: 50%;
}

.ent-modal-header-left {
    display: flex;
    align-items: center;
    gap: 0.875rem;
    position: relative;
}

.ent-modal-icon {
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: var(--e-radius);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--e-amber-bright);
}

.ent-modal-icon svg { width: 20px; height: 20px; }

.ent-modal-header h2 {
    font-family: var(--e-font-display);
    font-size: 1.125rem;
    font-weight: 400;
    color: #fff;
    margin: 0;
}

.ent-modal-header p {
    font-size: 0.75rem;
    color: rgba(255,255,255,0.6);
    margin: 0.125rem 0 0 0;
}

.ent-modal-close {
    width: 32px;
    height: 32px;
    background: rgba(255,255,255,0.1);
    border: none;
    border-radius: 8px;
    color: rgba(255,255,255,0.7);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
    position: relative;
}

.ent-modal-close:hover {
    background: rgba(255,255,255,0.2);
    color: #fff;
}

.ent-modal-close svg { width: 16px; height: 16px; }

/* Modal Body */
.ent-modal-body {
    padding: 1.5rem 1.75rem;
    overflow-y: auto;
    flex: 1;
    max-height: calc(88vh - 160px);
}

.ent-modal-body::-webkit-scrollbar { width: 4px; }
.ent-modal-body::-webkit-scrollbar-track { background: transparent; }
.ent-modal-body::-webkit-scrollbar-thumb { background: var(--e-border); border-radius: 2px; }
.ent-modal-body::-webkit-scrollbar-thumb:hover { background: var(--e-text-tertiary); }

/* Form Sections */
.ent-form-section {
    margin-bottom: 1.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--e-border-light);
}

.ent-form-section:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.ent-form-section-title {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    margin-bottom: 1rem;
}

.ent-form-section-icon {
    width: 32px;
    height: 32px;
    background: var(--e-blue-wash);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--e-blue);
}

.ent-form-section-icon svg { width: 16px; height: 16px; }

.ent-form-section-icon.accent-amber {
    background: var(--e-amber-wash);
    color: var(--e-amber);
}

.ent-form-section-icon.accent-green {
    background: var(--e-emerald-pale);
    color: var(--e-emerald);
}

.ent-form-section-title h3 {
    font-size: 0.8125rem;
    font-weight: 700;
    color: var(--e-text);
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

/* Form Grid */
.ent-form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.875rem;
}

.ent-form-group { margin-bottom: 0; }

.ent-form-group.full { grid-column: 1 / -1; }

.ent-form-label {
    display: block;
    font-size: 0.6875rem;
    font-weight: 700;
    color: var(--e-text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.4px;
    margin-bottom: 0.375rem;
}

.ent-form-label.required::after {
    content: '*';
    color: var(--e-amber);
    margin-left: 0.25rem;
    font-size: 0.75rem;
}

.ent-form-input {
    width: 100%;
    padding: 0.5625rem 0.875rem;
    border: 1.5px solid var(--e-border);
    border-radius: var(--e-radius);
    background: var(--e-bg);
    color: var(--e-text);
    font-family: var(--e-font-body);
    font-size: 0.8125rem;
    transition: all 0.2s;
}

.ent-form-input:hover { border-color: var(--e-slate-300); }

.ent-form-input:focus {
    outline: none;
    border-color: var(--e-blue);
    box-shadow: 0 0 0 3px rgba(59, 125, 216, 0.1);
}

.dark .ent-form-input:hover { border-color: var(--e-slate-600); }

.ent-form-input::placeholder { color: var(--e-text-tertiary); }

textarea.ent-form-input {
    resize: vertical;
    min-height: 72px;
    line-height: 1.5;
}

.ent-form-input.error {
    border-color: var(--e-red);
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.08);
}

.ent-form-error {
    font-size: 0.6875rem;
    color: var(--e-red);
    margin-top: 0.25rem;
    font-weight: 500;
}

/* Status Selector */
.ent-status-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.75rem;
}

.ent-status-option {
    position: relative;
    display: flex;
    align-items: center;
    gap: 0.875rem;
    padding: 1rem 1.125rem;
    background: var(--e-bg);
    border: 2px solid var(--e-border);
    border-radius: var(--e-radius-lg);
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}

.ent-status-option:hover {
    border-color: var(--e-slate-300);
}

.ent-status-option.is-active { border-color: rgba(5, 150, 105, 0.3); }
.ent-status-option.is-inactive { border-color: rgba(220, 38, 38, 0.3); }

.ent-status-option.is-active.selected {
    border-color: var(--e-emerald);
    background: var(--e-emerald-pale);
}

.ent-status-option.is-inactive.selected {
    border-color: var(--e-red);
    background: var(--e-red-pale);
}

.ent-status-icon {
    width: 40px;
    height: 40px;
    border-radius: var(--e-radius);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all 0.25s;
}

.ent-status-icon svg { width: 20px; height: 20px; }

.ent-status-option.is-active .ent-status-icon {
    background: rgba(5, 150, 105, 0.1);
    color: var(--e-emerald);
}

.ent-status-option.is-active.selected .ent-status-icon {
    background: var(--e-emerald);
    color: #fff;
}

.ent-status-option.is-inactive .ent-status-icon {
    background: rgba(220, 38, 38, 0.1);
    color: var(--e-red);
}

.ent-status-option.is-inactive.selected .ent-status-icon {
    background: var(--e-red);
    color: #fff;
}

.ent-status-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--e-text);
}

.ent-status-desc {
    font-size: 0.6875rem;
    color: var(--e-text-secondary);
    margin-top: 0.0625rem;
}

.ent-status-check {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: auto;
    flex-shrink: 0;
    opacity: 0;
    transform: scale(0.5);
    transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.ent-status-check svg { width: 12px; height: 12px; color: #fff; }

.ent-status-option.selected .ent-status-check {
    opacity: 1;
    transform: scale(1);
}

.ent-status-option.is-active.selected .ent-status-check { background: var(--e-emerald); }
.ent-status-option.is-inactive.selected .ent-status-check { background: var(--e-red); }

/* Modal Footer */
.ent-modal-footer {
    padding: 1rem 1.75rem;
    background: var(--e-bg);
    border-top: 1px solid var(--e-border);
    display: flex;
    justify-content: flex-end;
    gap: 0.625rem;
}

.ent-btn-cancel {
    padding: 0.5625rem 1.125rem;
    background: transparent;
    color: var(--e-text-secondary);
    border: 1.5px solid var(--e-border);
    border-radius: var(--e-radius);
    font-family: var(--e-font-body);
    font-weight: 600;
    font-size: 0.8125rem;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
}

.ent-btn-cancel svg { width: 14px; height: 14px; }

.ent-btn-cancel:hover {
    background: var(--e-red-pale);
    border-color: var(--e-red);
    color: var(--e-red);
}

.ent-btn-submit {
    padding: 0.5625rem 1.25rem;
    background: var(--e-blue);
    color: #fff;
    border: 1.5px solid var(--e-blue);
    border-radius: var(--e-radius);
    font-family: var(--e-font-body);
    font-weight: 600;
    font-size: 0.8125rem;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    box-shadow: 0 1px 3px rgba(59, 125, 216, 0.3);
}

.ent-btn-submit svg { width: 14px; height: 14px; }

.ent-btn-submit:hover {
    background: var(--e-blue-deep);
    border-color: var(--e-blue-deep);
    box-shadow: 0 4px 12px rgba(59, 125, 216, 0.35);
    transform: translateY(-1px);
}

.ent-btn-submit:disabled {
    opacity: 0.6;
    cursor: wait;
    transform: none;
}

@keyframes ent-spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.ent-spin { animation: ent-spin 0.8s linear infinite; }

/* ==================== RESPONSIVE ==================== */
@media (max-width: 1100px) {
    .ent-stats { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 768px) {
    .ent-header { flex-direction: column; align-items: flex-start; }
    .ent-header-actions { width: 100%; }
    .ent-header-actions .btn-e { flex: 1; justify-content: center; }
    .ent-stats { grid-template-columns: 1fr 1fr; }
    .ent-toolbar { flex-direction: column; align-items: stretch; }
    .ent-search { min-width: auto; }
    .ent-filters { overflow-x: auto; }
    .ent-grid { grid-template-columns: 1fr; }
    .ent-form-grid { grid-template-columns: 1fr; }
    .ent-status-grid { grid-template-columns: 1fr; }
}

@media (max-width: 480px) {
    .ent-stats { grid-template-columns: 1fr; }
    .ent-page { padding: 0 1rem 2rem; }
}
</style>
@endsection

@section('content')
<div class="ent-page">
    <!-- Page Header -->
    <div class="ent-header">
        <div class="ent-header-left">
            <h1>Entreprises</h1>
            <p>Gérez vos entreprises partenaires et leurs informations</p>
        </div>
        <div class="ent-header-actions">
            <button type="button" class="btn-e btn-e-outline" onclick="window.print()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                Exporter
            </button>
            <button type="button" class="btn-e btn-e-primary" onclick="openCreateModal()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Nouvelle Entreprise
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="ent-stats">
        <div class="ent-stat s-blue">
            <div class="ent-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/></svg>
            </div>
            <div class="ent-stat-text">
                <h3>{{ $entreprises->count() }}</h3>
                <p>Total</p>
            </div>
        </div>
        <div class="ent-stat s-green">
            <div class="ent-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div class="ent-stat-text">
                <h3>{{ $entreprises->where('is_active', true)->count() }}</h3>
                <p>Actives</p>
            </div>
        </div>
        <div class="ent-stat s-red">
            <div class="ent-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            </div>
            <div class="ent-stat-text">
                <h3>{{ $entreprises->where('is_active', false)->count() }}</h3>
                <p>Inactives</p>
            </div>
        </div>
        <div class="ent-stat s-amber">
            <div class="ent-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div class="ent-stat-text">
                <h3>{{ number_format($entreprises->sum('nombre_employes') ?? 0) }}</h3>
                <p>Employés</p>
            </div>
        </div>
    </div>

    <!-- Notifications -->
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

    <!-- Toolbar -->
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

    <!-- Grid View -->
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
                    <span class="ent-card-row-value">{{ $entreprise->ville ?? $entreprise->pays ?? 'Non spécifié' }}</span>
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
                <form action="{{ route('admin.entreprises.destroy', $entreprise->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette entreprise ?');">
                    @csrf
                    @method('DELETE')
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
            <p>Commencez par créer votre première entreprise</p>
            <button type="button" class="btn-e btn-e-primary" onclick="openCreateModal()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Créer une entreprise
            </button>
        </div>
        @endforelse
    </div>

    <!-- Table View -->
    <div class="ent-table-wrap" id="companiesTable" style="display: none;">
        <table class="ent-table">
            <thead>
                <tr>
                    <th>Entreprise</th>
                    <th>Contact</th>
                    <th>Localisation</th>
                    <th>Employés</th>
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
                            <div class="ent-card-logo-ph" style="width:36px;height:36px;font-size:0.75rem;">{{ strtoupper(substr($entreprise->nom, 0, 2)) }}</div>
                            @endif
                            <div class="ent-table-company-info">
                                <span class="ent-table-company-name">{{ $entreprise->nom }}</span>
                                @if($entreprise->sigle)<span class="ent-table-company-sigle">{{ $entreprise->sigle }}</span>@endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <div>{{ $entreprise->email }}</div>
                        @if($entreprise->telephone)<small style="color:var(--e-text-tertiary);">{{ $entreprise->telephone }}</small>@endif
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
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ent-table-btn ent-card-btn-delete" title="Supprimer">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6"><div class="ent-empty"><h3>Aucune entreprise</h3><p>Commencez par créer votre première entreprise</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Create/Edit Modal -->
<div class="ent-modal-overlay" id="entrepriseModal">
    <div class="ent-modal">
        <div class="ent-modal-header">
            <div class="ent-modal-header-left">
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
                <!-- Informations générales -->
                <div class="ent-form-section">
                    <div class="ent-form-section-title">
                        <div class="ent-form-section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/></svg>
                        </div>
                        <h3>Informations générales</h3>
                    </div>
                    <div class="ent-form-grid">
                        <div class="ent-form-group">
                            <label class="ent-form-label required">Nom de l'entreprise</label>
                            <input type="text" name="nom" id="nom" class="ent-form-input" placeholder="Nom de l'entreprise" required>
                        </div>
                        <div class="ent-form-group">
                            <label class="ent-form-label">Sigle</label>
                            <input type="text" name="sigle" id="sigle" class="ent-form-input" placeholder="Ex: ABC">
                        </div>
                        <div class="ent-form-group">
                            <label class="ent-form-label required">Email</label>
                            <input type="email" name="email" id="email" class="ent-form-input" placeholder="contact@entreprise.com" required>
                        </div>
                        <div class="ent-form-group">
                            <label class="ent-form-label">Téléphone</label>
                            <input type="text" name="telephone" id="telephone" class="ent-form-input" placeholder="+225 XX XX XX XX">
                        </div>
                    </div>
                </div>

                <!-- Adresse -->
                <div class="ent-form-section">
                    <div class="ent-form-section-title">
                        <div class="ent-form-section-icon accent-amber">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        </div>
                        <h3>Adresse</h3>
                    </div>
                    <div class="ent-form-grid">
                        <div class="ent-form-group full">
                            <label class="ent-form-label">Adresse</label>
                            <input type="text" name="adresse" id="adresse" class="ent-form-input" placeholder="Adresse complète">
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

                <!-- Statut -->
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
                                <div class="ent-status-desc">Visible et opérationnelle</div>
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
