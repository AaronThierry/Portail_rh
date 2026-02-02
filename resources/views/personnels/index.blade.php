@extends('layouts.app')

@section('title', 'Gestion du Personnel')
@section('page-title', 'Personnel')
@section('page-subtitle', 'Gérez les fiches du personnel')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
    <circle cx="9" cy="7" r="4"></circle>
    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
</svg>
@endsection

@section('styles')
<style>
/* ============================================================
   PERSONNEL — Swiss Corporate Editorial Design System
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
@keyframes pp-fadeUp {
    from { opacity: 0; transform: translateY(14px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes pp-scaleIn {
    from { opacity: 0; transform: scale(0.97); }
    to { opacity: 1; transform: scale(1); }
}

@keyframes pp-countUp {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes pp-spin {
    to { transform: rotate(360deg); }
}

/* ==================== PAGE CONTAINER ==================== */
.pp-page {
    font-family: var(--e-font-body);
    max-width: 1440px;
    margin: 0 auto;
    padding: 0 8px;
    animation: pp-fadeUp 0.45s cubic-bezier(0.16, 1, 0.3, 1);
}

/* ==================== PAGE HEADER ==================== */
.pp-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 28px;
    gap: 20px;
    animation: pp-fadeUp 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}

.pp-header-left h1 {
    font-family: var(--e-font-display);
    font-size: 2rem;
    color: var(--e-text);
    margin: 0 0 4px 0;
    letter-spacing: -0.5px;
    line-height: 1.15;
}

.pp-header-left p {
    color: var(--e-text-secondary);
    font-size: 0.875rem;
    margin: 0;
    font-weight: 500;
}

.pp-btn-add {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 24px;
    background: var(--e-blue);
    color: #fff;
    border: none;
    border-radius: var(--e-radius);
    font-family: var(--e-font-body);
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    white-space: nowrap;
}

.pp-btn-add svg {
    width: 17px;
    height: 17px;
}

.pp-btn-add:hover {
    background: var(--e-blue-deep);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(59, 125, 216, 0.3);
}

/* ==================== STATS GRID ==================== */
.pp-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}

.pp-stat {
    background: var(--e-surface);
    border: 1px solid var(--e-border);
    border-radius: var(--e-radius-lg);
    padding: 22px 24px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: var(--e-shadow-sm);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    animation: pp-fadeUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) backwards;
    position: relative;
    overflow: hidden;
}

.pp-stat:nth-child(1) { animation-delay: 0.05s; }
.pp-stat:nth-child(2) { animation-delay: 0.1s; }
.pp-stat:nth-child(3) { animation-delay: 0.15s; }
.pp-stat:nth-child(4) { animation-delay: 0.2s; }

.pp-stat::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    opacity: 0;
    transition: opacity 0.3s;
}

.pp-stat:hover {
    transform: translateY(-3px);
    box-shadow: var(--e-shadow-md);
}

.pp-stat:hover::after { opacity: 1; }

.pp-stat.blue::after { background: var(--e-blue); }
.pp-stat.emerald::after { background: var(--e-emerald); }
.pp-stat.red::after { background: var(--e-red); }
.pp-stat.amber::after { background: var(--e-amber); }

.pp-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: var(--e-radius);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.pp-stat-icon svg {
    width: 22px;
    height: 22px;
}

.pp-stat.blue .pp-stat-icon { background: var(--e-blue-pale); color: var(--e-blue); }
.pp-stat.emerald .pp-stat-icon { background: var(--e-emerald-pale); color: var(--e-emerald); }
.pp-stat.red .pp-stat-icon { background: var(--e-red-pale); color: var(--e-red); }
.pp-stat.amber .pp-stat-icon { background: var(--e-amber-pale); color: var(--e-amber); }

.pp-stat-info { flex: 1; min-width: 0; }

.pp-stat-value {
    font-family: var(--e-font-display);
    font-size: 1.75rem;
    color: var(--e-text);
    line-height: 1;
    margin-bottom: 3px;
}

.pp-stat-label {
    font-size: 0.75rem;
    color: var(--e-text-secondary);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* ==================== TOOLBAR ==================== */
.pp-toolbar {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
    animation: pp-fadeUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) 0.15s both;
}

.pp-search {
    flex: 1;
    max-width: 400px;
    position: relative;
}

.pp-search svg {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    width: 17px;
    height: 17px;
    color: var(--e-text-tertiary);
    pointer-events: none;
    transition: color 0.2s;
}

.pp-search input {
    width: 100%;
    padding: 10px 14px 10px 42px;
    background: var(--e-surface);
    border: 1px solid var(--e-border);
    border-radius: var(--e-radius);
    font-family: var(--e-font-body);
    font-size: 0.875rem;
    color: var(--e-text);
    outline: none;
    transition: all 0.2s;
}

.pp-search input::placeholder {
    color: var(--e-text-tertiary);
}

.pp-search input:focus {
    border-color: var(--e-blue);
    box-shadow: 0 0 0 3px rgba(59, 125, 216, 0.1);
}

.pp-search:focus-within svg {
    color: var(--e-blue);
}

.pp-btn-filter {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 10px 18px;
    background: var(--e-surface);
    color: var(--e-text-secondary);
    border: 1px solid var(--e-border);
    border-radius: var(--e-radius);
    font-family: var(--e-font-body);
    font-size: 0.8125rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.pp-btn-filter svg {
    width: 16px;
    height: 16px;
}

.pp-btn-filter:hover {
    background: var(--e-bg);
    border-color: var(--e-text-tertiary);
    color: var(--e-text);
}

/* ==================== TABLE CARD ==================== */
.pp-table-card {
    background: var(--e-surface);
    border: 1px solid var(--e-border);
    border-radius: var(--e-radius-lg);
    overflow: hidden;
    box-shadow: var(--e-shadow-sm);
    animation: pp-scaleIn 0.45s cubic-bezier(0.16, 1, 0.3, 1) 0.2s both;
}

.pp-table-wrap {
    overflow-x: auto;
}

.pp-table-wrap::-webkit-scrollbar {
    height: 6px;
}

.pp-table-wrap::-webkit-scrollbar-track {
    background: var(--e-border-light);
}

.pp-table-wrap::-webkit-scrollbar-thumb {
    background: var(--e-border);
    border-radius: 3px;
}

/* ==================== TABLE ==================== */
.pp-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.875rem;
}

.pp-table thead {
    background: var(--e-bg);
    border-bottom: 1px solid var(--e-border);
}

.pp-table thead th {
    padding: 13px 18px;
    text-align: left;
    font-size: 0.6875rem;
    font-weight: 700;
    color: var(--e-text-tertiary);
    text-transform: uppercase;
    letter-spacing: 0.7px;
    white-space: nowrap;
    user-select: none;
}

.pp-table tbody tr {
    border-bottom: 1px solid var(--e-border-light);
    transition: background 0.15s;
}

.pp-table tbody tr:last-child {
    border-bottom: none;
}

.pp-table tbody tr:hover {
    background: var(--e-blue-wash);
}

.pp-table tbody td {
    padding: 14px 18px;
    color: var(--e-text);
    vertical-align: middle;
    white-space: nowrap;
}

/* Personnel Cell */
.pp-cell-person {
    display: flex;
    align-items: center;
    gap: 12px;
}

.pp-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    object-fit: cover;
    border: 2px solid var(--e-border-light);
    flex-shrink: 0;
    transition: transform 0.2s;
}

.pp-table tbody tr:hover .pp-avatar {
    transform: scale(1.08);
}

.pp-person-info {
    min-width: 0;
}

.pp-person-name {
    font-weight: 600;
    color: var(--e-text);
    display: block;
    line-height: 1.3;
    font-size: 0.875rem;
}

.pp-person-matricule {
    font-size: 0.75rem;
    color: var(--e-text-tertiary);
    font-weight: 500;
    font-family: 'DM Sans', monospace;
    letter-spacing: 0.3px;
}

/* Date Badge */
.pp-date {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.8125rem;
    color: var(--e-text-secondary);
}

.pp-date svg {
    width: 14px;
    height: 14px;
    color: var(--e-text-tertiary);
}

/* Badges */
.pp-badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 12px;
    border-radius: 100px;
    font-size: 0.6875rem;
    font-weight: 600;
    letter-spacing: 0.2px;
    text-transform: uppercase;
}

.pp-badge-info {
    background: var(--e-blue-pale);
    color: var(--e-blue);
}

.pp-badge-warning {
    background: var(--e-amber-pale);
    color: var(--e-amber);
}

.pp-badge-success {
    background: var(--e-emerald-pale);
    color: var(--e-emerald);
}

.pp-badge-danger {
    background: var(--e-red-pale);
    color: var(--e-red);
}

/* Action Buttons */
.pp-actions {
    display: flex;
    align-items: center;
    gap: 6px;
}

.pp-act-btn {
    width: 34px;
    height: 34px;
    border-radius: 9px;
    border: 1px solid var(--e-border);
    background: var(--e-surface);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    color: var(--e-text-secondary);
    text-decoration: none;
}

.pp-act-btn svg {
    width: 16px;
    height: 16px;
}

.pp-act-btn.view:hover {
    background: var(--e-blue-wash);
    border-color: var(--e-blue-pale);
    color: var(--e-blue);
}

.pp-act-btn.delete:hover {
    background: var(--e-red-pale);
    border-color: rgba(220, 38, 38, 0.3);
    color: var(--e-red);
}

/* ==================== EMPTY STATE ==================== */
.pp-empty {
    padding: 80px 20px;
    text-align: center;
}

.pp-empty-icon {
    width: 72px;
    height: 72px;
    margin: 0 auto 20px;
    border-radius: var(--e-radius-lg);
    background: var(--e-blue-wash);
    display: flex;
    align-items: center;
    justify-content: center;
}

.pp-empty-icon svg {
    width: 32px;
    height: 32px;
    color: var(--e-blue);
}

.pp-empty h3 {
    font-family: var(--e-font-display);
    font-size: 1.25rem;
    color: var(--e-text);
    margin: 0 0 8px 0;
}

.pp-empty p {
    color: var(--e-text-secondary);
    font-size: 0.875rem;
    margin: 0 0 24px 0;
}

.pp-empty-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 22px;
    background: var(--e-blue);
    color: #fff;
    border: none;
    border-radius: var(--e-radius);
    font-family: var(--e-font-body);
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s;
}

.pp-empty-btn svg {
    width: 16px;
    height: 16px;
}

.pp-empty-btn:hover {
    background: var(--e-blue-deep);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(59, 125, 216, 0.3);
}

/* ==================== PAGINATION ==================== */
.pp-pagination {
    margin-top: 20px;
    display: flex;
    justify-content: center;
    animation: pp-fadeUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) 0.3s both;
}

.pp-pagination nav {
    display: flex;
    align-items: center;
    gap: 4px;
}

.pp-pagination .pagination {
    display: flex;
    align-items: center;
    gap: 4px;
    list-style: none;
    padding: 0;
    margin: 0;
}

.pp-pagination .page-item .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 36px;
    height: 36px;
    padding: 0 10px;
    border-radius: 9px;
    border: 1px solid var(--e-border);
    background: var(--e-surface);
    color: var(--e-text-secondary);
    font-family: var(--e-font-body);
    font-size: 0.8125rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s;
}

.pp-pagination .page-item .page-link:hover {
    background: var(--e-blue-wash);
    border-color: var(--e-blue-pale);
    color: var(--e-blue);
}

.pp-pagination .page-item.active .page-link {
    background: var(--e-blue);
    border-color: var(--e-blue);
    color: #fff;
}

.pp-pagination .page-item.disabled .page-link {
    opacity: 0.4;
    cursor: not-allowed;
}

/* ==================== TEXT MUTED ==================== */
.pp-muted {
    color: var(--e-text-tertiary);
    font-size: 0.8125rem;
}

/* ==================== NOTIFICATION TOAST ==================== */
.notification-toast {
    position: fixed;
    top: 24px;
    right: 24px;
    min-width: 320px;
    max-width: 440px;
    padding: 16px 20px;
    border-radius: var(--e-radius);
    background: var(--e-surface);
    border: 1px solid var(--e-border);
    box-shadow: var(--e-shadow-lg);
    display: flex;
    align-items: center;
    gap: 12px;
    z-index: 10000;
    transform: translateX(120%);
    transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    font-family: var(--e-font-body);
}

.notification-toast.show {
    transform: translateX(0);
}

.notification-toast .notification-content {
    display: flex;
    align-items: center;
    gap: 12px;
    flex: 1;
}

.notification-toast .notification-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    font-weight: 700;
    flex-shrink: 0;
}

.notification-success .notification-icon {
    background: var(--e-emerald-pale);
    color: var(--e-emerald);
}

.notification-error .notification-icon {
    background: var(--e-red-pale);
    color: var(--e-red);
}

.notification-info .notification-icon {
    background: var(--e-blue-pale);
    color: var(--e-blue);
}

.notification-toast .notification-message {
    font-size: 0.8125rem;
    color: var(--e-text);
    font-weight: 500;
    line-height: 1.4;
}

.notification-toast .notification-close {
    background: none;
    border: none;
    font-size: 1.25rem;
    color: var(--e-text-tertiary);
    cursor: pointer;
    padding: 4px;
    line-height: 1;
    transition: color 0.2s;
}

.notification-toast .notification-close:hover {
    color: var(--e-text);
}

/* ==================== SPINNER ==================== */
.pp-spin {
    animation: pp-spin 0.8s linear infinite;
}

/* ==================== RESPONSIVE ==================== */
@media (max-width: 1280px) {
    .pp-stats {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .pp-header {
        flex-direction: column;
        align-items: flex-start;
    }
    .pp-stats {
        grid-template-columns: 1fr;
    }
    .pp-toolbar {
        flex-direction: column;
        align-items: stretch;
    }
    .pp-search {
        max-width: none;
    }
    .pp-header-left h1 {
        font-size: 1.5rem;
    }
}
</style>
@endsection

@section('content')
<div class="pp-page">

    <!-- Page Header -->
    <div class="pp-header">
        <div class="pp-header-left">
            <h1>Gestion du Personnel</h1>
            <p>Gerez les employes et leurs informations</p>
        </div>
        <button class="pp-btn-add" id="btnAddPersonnel">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Nouveau personnel
        </button>
    </div>

    <!-- Stats Grid -->
    <div class="pp-stats">
        <div class="pp-stat blue">
            <div class="pp-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="pp-stat-info">
                <div class="pp-stat-value" data-count="{{ $personnels->total() ?? 0 }}">0</div>
                <div class="pp-stat-label">Total</div>
            </div>
        </div>
        <div class="pp-stat emerald">
            <div class="pp-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <div class="pp-stat-info">
                <div class="pp-stat-value" data-count="{{ $personnels->where('is_active', true)->count() }}">0</div>
                <div class="pp-stat-label">Actifs</div>
            </div>
        </div>
        <div class="pp-stat red">
            <div class="pp-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
            </div>
            <div class="pp-stat-info">
                <div class="pp-stat-value" data-count="{{ $personnels->where('is_active', false)->count() }}">0</div>
                <div class="pp-stat-label">Inactifs</div>
            </div>
        </div>
        <div class="pp-stat amber">
            <div class="pp-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                    <line x1="12" y1="9" x2="12" y2="13"></line>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg>
            </div>
            <div class="pp-stat-info">
                <div class="pp-stat-value" data-count="{{ $personnels->whereNull('user_id')->count() }}">0</div>
                <div class="pp-stat-label">Sans compte</div>
            </div>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="pp-toolbar">
        <div class="pp-search">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
            <input type="search" placeholder="Rechercher un personnel..." id="searchInput">
        </div>
        <button class="pp-btn-filter" id="btnFilter">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
            </svg>
            Filtrer
        </button>
    </div>

    <!-- Table -->
    <div class="pp-table-card">
        <div class="pp-table-wrap">
            <table class="pp-table">
                <thead>
                    <tr>
                        <th>Personnel</th>
                        <th>Sexe</th>
                        <th>Poste</th>
                        <th>Departement</th>
                        <th>Date Embauche</th>
                        <th>Contrat</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="personnelTableBody">
                    @forelse($personnels as $personnel)
                    <tr data-personnel-id="{{ $personnel->id }}">
                        <td>
                            <div class="pp-cell-person">
                                <img src="{{ $personnel->photo_url }}" alt="{{ $personnel->nom_complet }}" class="pp-avatar">
                                <div class="pp-person-info">
                                    <span class="pp-person-name">{{ $personnel->nom_complet }}</span>
                                    <span class="pp-person-matricule">{{ $personnel->matricule }}</span>
                                </div>
                            </div>
                        </td>
                        <td>{{ $personnel->sexe ?? 'N/A' }}</td>
                        <td>{{ $personnel->poste ?? 'Non defini' }}</td>
                        <td>{{ $personnel->departement->nom ?? 'Non assigne' }}</td>
                        <td>
                            @if($personnel->date_embauche)
                            <div class="pp-date">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                {{ \Carbon\Carbon::parse($personnel->date_embauche)->locale('fr')->isoFormat('DD MMM YYYY') }}
                            </div>
                            @else
                            <span class="pp-muted">Non renseignee</span>
                            @endif
                        </td>
                        <td>
                            <span class="pp-badge {{ $personnel->type_contrat === 'CDI' ? 'pp-badge-info' : 'pp-badge-warning' }}">
                                {{ $personnel->type_contrat }}
                            </span>
                        </td>
                        <td>
                            <span class="pp-badge {{ $personnel->is_active ? 'pp-badge-success' : 'pp-badge-danger' }}">
                                {{ $personnel->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td>
                            <div class="pp-actions">
                                <a href="{{ route('admin.personnels.show', $personnel->id) }}" class="pp-act-btn view" title="Voir details">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </a>
                                <button class="pp-act-btn delete" title="Supprimer" onclick="deletePersonnel({{ $personnel->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="pp-empty">
                                <div class="pp-empty-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </div>
                                <h3>Aucun personnel trouve</h3>
                                <p>Commencez par ajouter votre premier employe</p>
                                <button type="button" class="pp-empty-btn" onclick="document.getElementById('btnAddPersonnel').click()">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                    Creer un personnel
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($personnels->hasPages())
    <div class="pp-pagination">
        {{ $personnels->links() }}
    </div>
    @endif
</div>

@include('personnels.modal_v3_final')

@endsection

@section('scripts')
<script>
// Multi-step form logic
let currentStep = 1;
const totalSteps = 3;

// Open modal
document.getElementById('btnAddPersonnel').addEventListener('click', () => {
    document.getElementById('personnelModal').classList.add('show');
    resetForm();
});

// Close modal
function closeModal() {
    document.getElementById('personnelModal').classList.remove('show');
    resetForm();
}

// Reset form
function resetForm() {
    currentStep = 1;
    const form = document.getElementById('personnelForm');
    if (form) form.reset();
    updateStepDisplay();
}

function nextStep() {
    if (validateStep(currentStep) && currentStep < totalSteps) {
        currentStep++;
        updateStepDisplay();
    }
}

function prevStep() {
    if (currentStep > 1) {
        currentStep--;
        updateStepDisplay();
    }
}

function goToStep(targetStep) {
    if (targetStep < currentStep) {
        currentStep = targetStep;
        updateStepDisplay();
    } else if (targetStep > currentStep) {
        for (let i = currentStep; i < targetStep; i++) {
            if (!validateStep(i)) return;
        }
        currentStep = targetStep;
        updateStepDisplay();
    }
}

function updateStepDisplay() {
    // Update step content
    document.querySelectorAll('.form-step').forEach(step => {
        step.classList.remove('active');
    });
    const activeStep = document.querySelector(`.form-step[data-step="${currentStep}"]`);
    if (activeStep) activeStep.classList.add('active');

    // Update step indicators
    document.querySelectorAll('.step').forEach(indicator => {
        const step = parseInt(indicator.dataset.step);
        indicator.classList.remove('active', 'completed');
        if (step === currentStep) indicator.classList.add('active');
        if (step < currentStep) indicator.classList.add('completed');
    });

    // Update progress indicator
    const stepIndicator = document.getElementById('stepIndicator');
    if (stepIndicator) {
        stepIndicator.className = `step-indicator progress-${Math.round((currentStep / totalSteps) * 100)}`;
    }

    // Update navigation buttons
    const prevBtn = document.getElementById('btnPrev');
    const nextBtn = document.getElementById('btnNext');
    const submitBtn = document.getElementById('btnSubmit');
    const stepText = document.getElementById('stepIndicatorText');

    if (prevBtn) prevBtn.style.display = currentStep === 1 ? 'none' : 'inline-flex';
    if (nextBtn) nextBtn.style.display = currentStep === totalSteps ? 'none' : 'inline-flex';
    if (submitBtn) submitBtn.style.display = currentStep === totalSteps ? 'inline-flex' : 'none';
    if (stepText) stepText.textContent = `Etape ${currentStep} sur ${totalSteps}`;
}

function validateStep(step) {
    const stepEl = document.querySelector(`.form-step[data-step="${step}"]`);
    if (!stepEl) return true;

    const requiredFields = stepEl.querySelectorAll('[required]');
    let valid = true;

    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.classList.add('error');
            valid = false;
        } else {
            field.classList.remove('error');
        }
    });

    if (!valid) {
        showNotification('Veuillez remplir tous les champs requis', 'error');
    }

    return valid;
}

function addRealTimeValidation() {
    document.querySelectorAll('.form-step [required]').forEach(field => {
        field.addEventListener('input', () => {
            if (field.value.trim()) {
                field.classList.remove('error');
            }
        });
    });
}

function initCountryFlagSelector() {
    const countrySelect = document.getElementById('telephone_code_pays');
    if (!countrySelect) return;
    countrySelect.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption && selectedOption.dataset.flag) {
            this.style.backgroundImage = `url('https://flagcdn.com/w20/${selectedOption.dataset.flag}.png')`;
        }
    });
}

function initKeyboardNavigation() {
    document.addEventListener('keydown', (e) => {
        const modal = document.getElementById('personnelModal');
        const isModalVisible = modal && modal.classList.contains('show');

        if (!isModalVisible) return;

        // Escape to close modal
        if (e.key === 'Escape') {
            closeModal();
            return;
        }

        // Ctrl+Enter to submit or go to next step
        if (e.ctrlKey && e.key === 'Enter') {
            e.preventDefault();
            if (currentStep === totalSteps) {
                document.getElementById('personnelForm').dispatchEvent(new Event('submit'));
            } else {
                nextStep();
            }
        }

        // Ctrl+Backspace to go to previous step
        if (e.ctrlKey && e.key === 'Backspace') {
            e.preventDefault();
            prevStep();
        }
    });
}

function addKeyboardHints() {
    const hintsContainer = document.querySelector('#modalAddPersonnel .keyboard-hints-footer');
    if (hintsContainer) {
        hintsContainer.innerHTML = `
            <span class="kbd-hint"><kbd>Ctrl</kbd>+<kbd>Enter</kbd> Suivant</span>
            <span class="kbd-hint"><kbd>Ctrl</kbd>+<kbd>Back</kbd> Precedent</span>
            <span class="kbd-hint"><kbd>Esc</kbd> Fermer</span>
        `;
    }
}

// Animate stat counters
function animateStats() {
    document.querySelectorAll('.pp-stat-value[data-count]').forEach(el => {
        const target = parseInt(el.dataset.count) || 0;
        const duration = 600;
        const start = performance.now();

        function tick(now) {
            const elapsed = now - start;
            const progress = Math.min(elapsed / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.round(target * eased);
            if (progress < 1) requestAnimationFrame(tick);
        }

        requestAnimationFrame(tick);
    });
}

function toggleDateFinContrat() {
    const typeContrat = document.getElementById('type_contrat');
    const dateFinGroup = document.getElementById('dateFinContratGroup');

    if (typeContrat && dateFinGroup) {
        if (typeContrat.value === 'CDD') {
            dateFinGroup.style.display = 'block';
        } else {
            dateFinGroup.style.display = 'none';
        }
    }
}

// Load services by department (OLD - for edit modal)
async function loadServicesOld(departementId) {
    const serviceSelect = document.getElementById('service_id');

    if (!departementId) {
        serviceSelect.disabled = true;
        serviceSelect.innerHTML = '<option value="">Selectionner d\'abord un departement</option>';
        return;
    }

    serviceSelect.disabled = true;
    serviceSelect.innerHTML = '<option value="">Chargement...</option>';

    try {
        const response = await fetch(`/personnels/services/${departementId}`);
        const data = await response.json();
        if (data.success && data.data.length > 0) {
            serviceSelect.disabled = false;
            serviceSelect.innerHTML = '<option value="">Selectionner un service (optionnel)</option>';
            data.data.forEach(service => {
                const option = document.createElement('option');
                option.value = service.id;
                option.textContent = service.nom;
                serviceSelect.appendChild(option);
            });
        } else {
            serviceSelect.disabled = false;
            serviceSelect.innerHTML = '<option value="">Aucun service disponible</option>';
        }
    } catch (error) {
        console.error('Erreur lors du chargement des services:', error);
        serviceSelect.disabled = false;
        serviceSelect.innerHTML = '<option value="">Erreur de chargement</option>';
        showNotification('Erreur lors du chargement des services', 'error');
    }
}

// Preview photo
function previewPhoto(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('photoPreviewImg').src = e.target.result;
            document.getElementById('photoPreview').classList.add('show');
        };
        reader.readAsDataURL(file);
    }
}

// Submit form
document.getElementById('personnelForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    // Validate final step
    if (!validateStep(currentStep)) {
        showNotification('Veuillez remplir tous les champs requis', 'error');
        return;
    }

    const formData = new FormData(e.target);
    const submitBtn = document.getElementById('btnSubmit');

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<svg class="pp-spin" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"></path></svg> Enregistrement...';

    try {
        const response = await fetch('{{ route("admin.personnels.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: formData
        });

        const data = await response.json();

        if (response.ok && data.success) {
            showNotification('Personnel enregistre avec succes!', 'success');
            closeModal();
            setTimeout(() => {
                window.location.href = window.location.href;
            }, 800);
        } else {
            // Display validation errors
            if (data.errors) {
                let errorMessage = 'Erreurs de validation:\n';
                Object.keys(data.errors).forEach(key => {
                    errorMessage += `- ${data.errors[key][0]}\n`;
                });
                showNotification(errorMessage, 'error');
            } else {
                showNotification(data.message || 'Une erreur est survenue lors de l\'enregistrement', 'error');
            }
        }
    } catch (error) {
        console.error('Erreur:', error);
        showNotification('Erreur de connexion au serveur', 'error');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg> Enregistrer';
    }
});

// Notification system
function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotif = document.querySelector('.notification-toast');
    if (existingNotif) {
        existingNotif.remove();
    }

    const notif = document.createElement('div');
    notif.className = `notification-toast notification-${type}`;
    notif.innerHTML = `
        <div class="notification-content">
            <div class="notification-icon">
                ${type === 'success' ? '&#10003;' : type === 'error' ? '&#10005;' : '&#8505;'}
            </div>
            <div class="notification-message">${message.replace(/\n/g, '<br>')}</div>
        </div>
        <button class="notification-close" onclick="this.parentElement.remove()">&times;</button>
    `;
    document.body.appendChild(notif);

    setTimeout(() => {
        notif.classList.add('show');
    }, 100);

    setTimeout(() => {
        notif.classList.remove('show');
        setTimeout(() => notif.remove(), 300);
    }, 5000);
}

// Close modal on escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeModal();
    }
});

// Close modal on overlay click
document.getElementById('personnelModal').addEventListener('click', (e) => {
    if (e.target.id === 'personnelModal') {
        closeModal();
    }
});

// Delete personnel
async function deletePersonnel(id) {
    if (!confirm('Etes-vous sur de vouloir supprimer ce personnel?')) {
        return;
    }

    try {
        const response = await fetch(`/admin/personnels/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            showNotification('Personnel supprime avec succes!', 'success');
            setTimeout(() => window.location.reload(), 800);
        } else {
            showNotification('Erreur: ' + (data.message || 'Une erreur est survenue'), 'error');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showNotification('Erreur lors de la suppression', 'error');
    }
}

// Search functionality
document.getElementById('searchInput').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#personnelTableBody tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing personnel form...');
    updateStepDisplay();
    animateStats();
    addRealTimeValidation();
    initCountryFlagSelector();
    initKeyboardNavigation();
    addKeyboardHints();
    console.log('Personnel form initialized - Step 1 active');
});
</script>
@endsection
