@extends('layouts.app')

@section('title', 'Gestion des Repertoires')
@section('page-title', 'Repertoires Documents')
@section('page-subtitle', 'Organisez les categories de documents')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
</svg>
@endsection

@section('styles')
<style>
/* ============================================================
   REPERTOIRES — Swiss Corporate Editorial Design System
   Geometric precision - Warm accents - Editorial typography
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
    --e-blue: #3b7dd8;
    --e-blue-deep: #2563a0;
    --e-blue-pale: #dbeafe;
    --e-blue-wash: #eff6ff;
    --e-amber: #e8850c;
    --e-amber-pale: #fef3c7;
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
    --e-emerald-pale: rgba(5, 150, 105, 0.15);
    --e-red-pale: rgba(220, 38, 38, 0.15);
}

/* ==================== ANIMATIONS ==================== */
@keyframes rc-fadeUp {
    from { opacity: 0; transform: translateY(14px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes rc-scaleIn {
    from { opacity: 0; transform: scale(0.96); }
    to { opacity: 1; transform: scale(1); }
}
@keyframes rc-slideDown {
    from { opacity: 0; transform: translateY(-10px) scale(0.98); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}
@keyframes rc-countUp {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ==================== PAGE ==================== */
.rc-page {
    font-family: var(--e-font-body);
    max-width: 1440px;
    margin: 0 auto;
    padding: 0 1.5rem 3rem;
    color: var(--e-text);
}

/* ==================== BREADCRUMB ==================== */
.rc-breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
    font-size: 0.8125rem;
    font-weight: 500;
    animation: rc-fadeUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) both;
}
.rc-breadcrumb a {
    color: var(--e-text-secondary);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.375rem;
    transition: color 0.2s;
}
.rc-breadcrumb a:hover { color: var(--e-blue); }
.rc-breadcrumb-sep { color: var(--e-text-tertiary); font-size: 0.75rem; }
.rc-breadcrumb-current { color: var(--e-text); font-weight: 600; }

/* ==================== HEADER ==================== */
.rc-header {
    background: var(--e-surface);
    border: 1px solid var(--e-border);
    border-radius: var(--e-radius-xl);
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--e-shadow);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 2rem;
    flex-wrap: wrap;
    animation: rc-fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) 0.05s both;
    position: relative;
    overflow: hidden;
}
.rc-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--e-blue), var(--e-blue-deep));
    border-radius: 4px 4px 0 0;
}
.rc-header-left {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    flex: 1;
    min-width: 280px;
}
.rc-header-icon {
    width: 64px;
    height: 64px;
    border-radius: var(--e-radius-lg);
    background: linear-gradient(135deg, var(--e-blue) 0%, var(--e-blue-deep) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    flex-shrink: 0;
    box-shadow: 0 8px 24px rgba(59, 125, 216, 0.3);
}
.rc-header-icon svg { width: 28px; height: 28px; }
.rc-header-title {
    font-family: var(--e-font-display);
    font-size: 1.625rem;
    font-weight: 400;
    margin: 0 0 0.25rem;
    letter-spacing: -0.01em;
    color: var(--e-text);
}
.rc-header-subtitle {
    font-size: 0.8125rem;
    color: var(--e-text-secondary);
    margin: 0;
}
.rc-header-stats {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}
.rc-stat-pill {
    background: var(--e-bg);
    border: 1px solid var(--e-border);
    border-radius: var(--e-radius);
    padding: 0.625rem 1rem;
    text-align: center;
    min-width: 80px;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.rc-stat-pill:hover {
    box-shadow: var(--e-shadow-md);
    transform: translateY(-2px);
}
.rc-stat-value {
    font-size: 1.375rem;
    font-weight: 700;
    font-family: var(--e-font-display);
    color: var(--e-blue);
    line-height: 1;
    animation: rc-countUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
}
.rc-stat-label {
    font-size: 0.625rem;
    color: var(--e-text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
    margin-top: 0.25rem;
}

/* ==================== ACTIONS BAR ==================== */
.rc-actions {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}
.rc-btn {
    padding: 0.75rem 1.25rem;
    border-radius: var(--e-radius);
    border: 1px solid transparent;
    font-weight: 600;
    font-size: 0.8125rem;
    font-family: var(--e-font-body);
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    text-decoration: none;
    line-height: 1;
}
.rc-btn svg { width: 16px; height: 16px; }
.rc-btn-primary {
    background: var(--e-blue);
    color: white;
    box-shadow: 0 4px 12px rgba(59, 125, 216, 0.3);
}
.rc-btn-primary:hover {
    background: var(--e-blue-deep);
    box-shadow: 0 6px 16px rgba(59, 125, 216, 0.4);
    transform: translateY(-1px);
}
.rc-btn-outline {
    background: var(--e-surface);
    color: var(--e-text-secondary);
    border-color: var(--e-border);
}
.rc-btn-outline:hover {
    border-color: var(--e-slate-300);
    color: var(--e-text);
    background: var(--e-bg);
}

/* ==================== INFO BANNER ==================== */
.rc-info-banner {
    background: var(--e-blue-wash);
    border: 1px solid var(--e-blue-pale);
    border-radius: var(--e-radius-lg);
    padding: 1.25rem 1.5rem;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    animation: rc-fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) 0.1s both;
}
.rc-info-banner-icon {
    width: 40px;
    height: 40px;
    background: var(--e-blue-pale);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--e-blue);
    flex-shrink: 0;
}
.rc-info-banner-icon svg { width: 20px; height: 20px; }
.rc-info-banner-content h4 {
    margin: 0 0 0.125rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--e-text);
}
.rc-info-banner-content p {
    margin: 0;
    font-size: 0.8125rem;
    color: var(--e-text-secondary);
    line-height: 1.5;
}

/* ==================== FLASH ==================== */
.rc-flash {
    padding: 1rem 1.25rem;
    border-radius: var(--e-radius);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
    animation: rc-slideDown 0.5s cubic-bezier(0.16, 1, 0.3, 1) both;
}
.rc-flash-success {
    background: var(--e-emerald-pale);
    color: #065f46;
    border: 1px solid rgba(5, 150, 105, 0.2);
}
.rc-flash-error {
    background: var(--e-red-pale);
    color: #991b1b;
    border: 1px solid rgba(220, 38, 38, 0.2);
}

/* ==================== GRID ==================== */
.rc-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.25rem;
}

/* ==================== CARD ==================== */
.rc-card {
    background: var(--e-surface);
    border: 1px solid var(--e-border);
    border-radius: var(--e-radius-lg);
    overflow: hidden;
    box-shadow: var(--e-shadow-sm);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    animation: rc-scaleIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) both;
    position: relative;
}
.rc-card:hover {
    box-shadow: var(--e-shadow-lg);
    transform: translateY(-3px);
    border-color: var(--e-blue);
}
.rc-card.rc-card-inactive {
    opacity: 0.55;
}
.rc-card.rc-card-inactive:hover { opacity: 0.8; }
.rc-card-color-bar {
    height: 4px;
    width: 100%;
}
.rc-card-header {
    padding: 1.5rem 1.5rem 0;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}
.rc-card-icon {
    width: 52px;
    height: 52px;
    border-radius: var(--e-radius);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.rc-card-icon svg { width: 22px; height: 22px; }
.rc-card-info { flex: 1; min-width: 0; }
.rc-card-name {
    font-size: 1rem;
    font-weight: 600;
    color: var(--e-text);
    margin: 0 0 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}
.rc-badge {
    padding: 0.1rem 0.5rem;
    border-radius: 100px;
    font-size: 0.5625rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.4px;
}
.rc-badge-required {
    background: var(--e-red-pale);
    color: var(--e-red);
}
.rc-badge-inactive {
    background: var(--e-slate-100);
    color: var(--e-text-tertiary);
}
.rc-card-desc {
    font-size: 0.8125rem;
    color: var(--e-text-secondary);
    margin: 0;
    line-height: 1.45;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.rc-card-stats {
    padding: 1rem 1.5rem;
    display: flex;
    gap: 1.5rem;
}
.rc-card-stat {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.75rem;
    color: var(--e-text-secondary);
}
.rc-card-stat svg { width: 14px; height: 14px; color: var(--e-text-tertiary); }
.rc-card-stat strong {
    font-weight: 700;
    color: var(--e-text);
    font-size: 0.875rem;
}
.rc-card-actions {
    padding: 0.875rem 1.5rem;
    display: flex;
    gap: 0.5rem;
    border-top: 1px solid var(--e-border-light);
}
.rc-card-btn {
    flex: 1;
    padding: 0.5rem 0.75rem;
    border-radius: 8px;
    border: 1px solid transparent;
    cursor: pointer;
    font-size: 0.75rem;
    font-weight: 600;
    font-family: var(--e-font-body);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.375rem;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    line-height: 1;
}
.rc-card-btn svg { width: 14px; height: 14px; }
.rc-card-btn-edit {
    background: var(--e-blue-wash);
    color: var(--e-blue);
}
.rc-card-btn-edit:hover { background: var(--e-blue-pale); }
.rc-card-btn-toggle {
    background: var(--e-amber-pale);
    color: var(--e-amber);
}
.rc-card-btn-toggle:hover { background: #fde68a; }
.rc-card-btn-delete {
    background: var(--e-red-pale);
    color: var(--e-red);
    flex: 0;
    padding: 0.5rem 0.625rem;
}
.rc-card-btn-delete:hover { background: #fecaca; }

/* ==================== EMPTY STATE ==================== */
.rc-empty {
    text-align: center;
    padding: 4rem 2rem;
    background: var(--e-surface);
    border: 2px dashed var(--e-border);
    border-radius: var(--e-radius-xl);
    animation: rc-fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
}
.rc-empty-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    background: var(--e-bg);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--e-text-tertiary);
}
.rc-empty-icon svg { width: 36px; height: 36px; }
.rc-empty h3 {
    font-family: var(--e-font-display);
    font-size: 1.375rem;
    font-weight: 400;
    color: var(--e-text);
    margin: 0 0 0.5rem;
}
.rc-empty p {
    color: var(--e-text-secondary);
    margin: 0 0 2rem;
    font-size: 0.875rem;
}

/* ==================== MODAL ==================== */
.rc-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.75);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    z-index: 10000;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    opacity: 0;
    transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.rc-modal-overlay.show {
    display: flex;
    opacity: 1;
}
.rc-modal {
    background: var(--e-surface);
    border-radius: var(--e-radius-xl);
    width: 100%;
    max-width: 560px;
    max-height: 92vh;
    overflow: hidden;
    box-shadow: 0 32px 64px -12px rgba(0,0,0,0.3), 0 0 0 1px rgba(255,255,255,0.05);
    transform: scale(0.92) translateY(20px);
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
.rc-modal-overlay.show .rc-modal {
    transform: scale(1) translateY(0);
}
.rc-modal-header {
    background: linear-gradient(135deg, var(--e-slate-800) 0%, var(--e-slate-900) 100%);
    color: white;
    padding: 1.75rem 2rem 1.5rem;
    position: relative;
    overflow: hidden;
}
.rc-modal-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 280px;
    height: 280px;
    background: radial-gradient(circle, rgba(59, 125, 216, 0.25) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}
.rc-modal-header-content {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    gap: 1rem;
}
.rc-modal-icon {
    width: 50px;
    height: 50px;
    background: rgba(59, 125, 216, 0.2);
    backdrop-filter: blur(8px);
    border-radius: var(--e-radius);
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(59, 125, 216, 0.3);
    flex-shrink: 0;
}
.rc-modal-icon svg { width: 24px; height: 24px; }
.rc-modal-title {
    margin: 0 0 0.25rem;
    font-family: var(--e-font-display);
    font-size: 1.25rem;
    font-weight: 400;
    letter-spacing: -0.01em;
}
.rc-modal-subtitle {
    margin: 0;
    font-size: 0.8125rem;
    color: rgba(255,255,255,0.65);
}
.rc-modal-close {
    position: absolute;
    right: 1.25rem;
    top: 1.25rem;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.12);
    color: white;
    width: 36px;
    height: 36px;
    border-radius: 10px;
    cursor: pointer;
    font-size: 1.125rem;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 3;
}
.rc-modal-close:hover {
    background: rgba(255,255,255,0.15);
    transform: rotate(90deg);
}
.rc-modal-body {
    padding: 1.75rem 2rem;
    max-height: calc(92vh - 220px);
    overflow-y: auto;
}
.rc-modal-body::-webkit-scrollbar { width: 5px; }
.rc-modal-body::-webkit-scrollbar-track { background: var(--e-slate-100); border-radius: 3px; }
.rc-modal-body::-webkit-scrollbar-thumb { background: var(--e-slate-300); border-radius: 3px; }

/* ==================== FORM STYLES ==================== */
.rc-form-group { margin-bottom: 1.25rem; }
.rc-form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: var(--e-text);
    margin-bottom: 0.5rem;
    font-size: 0.8125rem;
}
.rc-form-label svg { width: 15px; height: 15px; color: var(--e-blue); }
.rc-form-label .rc-required { color: var(--e-red); font-weight: 700; }
.rc-form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1.5px solid var(--e-border);
    border-radius: var(--e-radius);
    font-size: 0.875rem;
    font-family: var(--e-font-body);
    color: var(--e-text);
    background: var(--e-surface);
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    box-sizing: border-box;
}
.rc-form-control:hover { border-color: var(--e-slate-300); }
.rc-form-control:focus {
    outline: none;
    border-color: var(--e-blue);
    box-shadow: 0 0 0 3px rgba(59, 125, 216, 0.12);
}
.rc-form-control::placeholder { color: var(--e-text-tertiary); }

/* Color & Icon pickers */
.rc-picker-grid {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}
.rc-color-option {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    cursor: pointer;
    border: 3px solid transparent;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
}
.rc-color-option:hover { transform: scale(1.12); }
.rc-color-option.selected {
    border-color: var(--e-text);
    box-shadow: 0 0 0 2px var(--e-surface), 0 0 0 4px var(--e-text);
    transform: scale(1.08);
}
.rc-icon-option {
    width: 46px;
    height: 46px;
    border-radius: var(--e-radius);
    cursor: pointer;
    border: 1.5px solid var(--e-border);
    background: var(--e-bg);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--e-text-secondary);
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}
.rc-icon-option:hover {
    border-color: var(--e-blue);
    color: var(--e-blue);
    background: var(--e-blue-wash);
}
.rc-icon-option.selected {
    border-color: var(--e-blue);
    background: var(--e-blue);
    color: white;
    box-shadow: 0 4px 12px rgba(59, 125, 216, 0.3);
}

/* Checkbox */
.rc-form-check {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.875rem 1rem;
    background: var(--e-bg);
    border-radius: var(--e-radius);
    border: 1.5px solid transparent;
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    margin-top: 0.5rem;
}
.rc-form-check:hover { background: var(--e-slate-100); border-color: var(--e-border); }
.rc-form-check.checked { background: var(--e-blue-wash); border-color: var(--e-blue); }
.rc-form-check input[type="checkbox"] { display: none; }
.rc-check-box {
    width: 20px;
    height: 20px;
    border-radius: 6px;
    border: 2px solid var(--e-slate-300);
    background: var(--e-surface);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
    flex-shrink: 0;
}
.rc-form-check.checked .rc-check-box {
    background: var(--e-blue);
    border-color: transparent;
}
.rc-check-box svg { width: 12px; height: 12px; color: white; opacity: 0; transform: scale(0.5); transition: all 0.2s; }
.rc-form-check.checked .rc-check-box svg { opacity: 1; transform: scale(1); }
.rc-check-label { font-weight: 600; font-size: 0.8125rem; color: var(--e-text); }
.rc-check-desc { font-size: 0.6875rem; color: var(--e-text-secondary); margin-top: 0.125rem; }

/* Form row */
.rc-form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

/* Modal Footer */
.rc-modal-footer {
    padding: 1.25rem 2rem;
    background: var(--e-bg);
    border-top: 1px solid var(--e-border);
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
}
.rc-btn-modal {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    border-radius: var(--e-radius);
    font-size: 0.875rem;
    font-weight: 600;
    font-family: var(--e-font-body);
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    border: none;
    line-height: 1;
}
.rc-btn-modal svg { width: 16px; height: 16px; }
.rc-btn-modal-cancel {
    background: var(--e-surface);
    color: var(--e-text-secondary);
    border: 1.5px solid var(--e-border);
}
.rc-btn-modal-cancel:hover { border-color: var(--e-slate-300); color: var(--e-text); }
.rc-btn-modal-submit {
    background: var(--e-blue);
    color: white;
    box-shadow: 0 4px 14px rgba(59, 125, 216, 0.3);
}
.rc-btn-modal-submit:hover {
    background: var(--e-blue-deep);
    box-shadow: 0 6px 18px rgba(59, 125, 216, 0.4);
    transform: translateY(-1px);
}

/* ==================== RESPONSIVE ==================== */
@media (max-width: 768px) {
    .rc-header { flex-direction: column; padding: 1.5rem; }
    .rc-header-left { min-width: auto; }
    .rc-grid { grid-template-columns: 1fr; }
    .rc-form-row { grid-template-columns: 1fr; }
    .rc-header-stats { justify-content: center; }
    .rc-actions { justify-content: center; }
}
</style>
@endsection

@section('content')
<div class="rc-page">
    <!-- Breadcrumb -->
    <div class="rc-breadcrumb">
        <a href="{{ route('admin.dossiers-agents.index') }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
            </svg>
            Dossiers Agents
        </a>
        <span class="rc-breadcrumb-sep">/</span>
        <span class="rc-breadcrumb-current">Repertoires Documents</span>
    </div>

    <!-- Header -->
    <div class="rc-header">
        <div class="rc-header-left">
            <div class="rc-header-icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                </svg>
            </div>
            <div>
                <h1 class="rc-header-title">Repertoires Globaux</h1>
                <p class="rc-header-subtitle">Definissez les types de documents pour tous les employes</p>
            </div>
        </div>

        <div class="rc-header-stats">
            <div class="rc-stat-pill">
                <div class="rc-stat-value">{{ $categories->count() }}</div>
                <div class="rc-stat-label">Repertoires</div>
            </div>
            <div class="rc-stat-pill">
                <div class="rc-stat-value" style="color: var(--e-emerald);">{{ $categories->where('actif', true)->count() }}</div>
                <div class="rc-stat-label">Actifs</div>
            </div>
            <div class="rc-stat-pill">
                <div class="rc-stat-value" style="color: var(--e-red);">{{ $categories->where('obligatoire', true)->count() }}</div>
                <div class="rc-stat-label">Obligatoires</div>
            </div>
        </div>

        <div class="rc-actions">
            <button onclick="openCreateModal()" class="rc-btn rc-btn-primary">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 4v16m8-8H4"/>
                </svg>
                Nouveau repertoire
            </button>
        </div>
    </div>

    <!-- Info Banner -->
    <div class="rc-info-banner">
        <div class="rc-info-banner-icon">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="rc-info-banner-content">
            <h4>Comment fonctionnent les repertoires ?</h4>
            <p>Les repertoires que vous creez ici s'appliquent <strong>globalement a tous les employes</strong>. Chaque employe aura ces memes categories dans son dossier pour y deposer les documents correspondants.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="rc-flash rc-flash-success">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="rc-flash rc-flash-error">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    <!-- Grid des repertoires -->
    @if($categories->count() > 0)
    <div class="rc-grid">
        @foreach($categories as $categorie)
        <div class="rc-card {{ !$categorie->actif ? 'rc-card-inactive' : '' }}" style="animation-delay: {{ $loop->index * 0.05 }}s">
            <div class="rc-card-color-bar" style="background: {{ $categorie->couleur }};"></div>
            <div class="rc-card-header">
                <div class="rc-card-icon" style="background: {{ $categorie->couleur }};">
                    @include('dossier-agent.partials.icon', ['icon' => $categorie->icone, 'size' => 22])
                </div>
                <div class="rc-card-info">
                    <h3 class="rc-card-name">
                        {{ $categorie->nom }}
                        @if($categorie->obligatoire)
                        <span class="rc-badge rc-badge-required">Requis</span>
                        @endif
                        @if(!$categorie->actif)
                        <span class="rc-badge rc-badge-inactive">Inactif</span>
                        @endif
                    </h3>
                    <p class="rc-card-desc">{{ $categorie->description ?: 'Aucune description' }}</p>
                </div>
            </div>
            <div class="rc-card-stats">
                <div class="rc-card-stat">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <strong>{{ $categorie->documents_count }}</strong> documents
                </div>
                <div class="rc-card-stat">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                    </svg>
                    Ordre <strong>{{ $categorie->ordre }}</strong>
                </div>
            </div>
            <div class="rc-card-actions">
                <button class="rc-card-btn rc-card-btn-edit" onclick="openEditModal({{ json_encode($categorie) }})">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Modifier
                </button>
                <button class="rc-card-btn rc-card-btn-toggle" onclick="toggleCategorie({{ $categorie->id }}, {{ $categorie->actif ? 'false' : 'true' }})">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        @if($categorie->actif)
                        <path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M3 3l18 18"/>
                        @else
                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        @endif
                    </svg>
                    {{ $categorie->actif ? 'Masquer' : 'Activer' }}
                </button>
                @if($categorie->documents_count == 0)
                <button class="rc-card-btn rc-card-btn-delete" onclick="deleteCategorie({{ $categorie->id }}, '{{ addslashes($categorie->nom) }}')">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="rc-empty">
        <div class="rc-empty-icon">
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
            </svg>
        </div>
        <h3>Aucun repertoire configure</h3>
        <p>Creez des repertoires pour organiser les documents de vos employes</p>
        <button onclick="initDefaultCategories()" class="rc-btn rc-btn-primary">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
            Initialiser les repertoires par defaut
        </button>
    </div>
    @endif
</div>

<!-- Modal Creation/Edition -->
<div class="rc-modal-overlay" id="categorieModal">
    <div class="rc-modal">
        <div class="rc-modal-header">
            <div class="rc-modal-header-content">
                <div class="rc-modal-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="rc-modal-title" id="modalTitle">Nouveau Repertoire</h3>
                    <p class="rc-modal-subtitle">Configurez les proprietes du repertoire</p>
                </div>
            </div>
            <button class="rc-modal-close" onclick="closeModal()">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form id="categorieForm" method="POST">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="rc-modal-body">
                <div class="rc-form-group">
                    <label class="rc-form-label">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                        Nom du repertoire <span class="rc-required">*</span>
                    </label>
                    <input type="text" name="nom" id="categorie_nom" class="rc-form-control" required placeholder="Ex: Contrats, Fiches de poste...">
                </div>

                <div class="rc-form-group">
                    <label class="rc-form-label">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                        Description
                    </label>
                    <textarea name="description" id="categorie_description" class="rc-form-control" rows="2" placeholder="Decrivez le type de documents a stocker..."></textarea>
                </div>

                <div class="rc-form-row">
                    <div class="rc-form-group">
                        <label class="rc-form-label">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                            Couleur
                        </label>
                        <div class="rc-picker-grid">
                            @php
                            $colors = ['#667eea', '#8b5cf6', '#3b82f6', '#10b981', '#06b6d4', '#14b8a6', '#f59e0b', '#ef4444', '#ec4899', '#64748b'];
                            @endphp
                            @foreach($colors as $color)
                            <div class="rc-color-option" style="background: {{ $color }};" data-color="{{ $color }}" onclick="selectColor('{{ $color }}')"></div>
                            @endforeach
                        </div>
                        <input type="hidden" name="couleur" id="categorie_couleur" value="#667eea">
                    </div>

                    <div class="rc-form-group">
                        <label class="rc-form-label">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                            </svg>
                            Ordre d'affichage
                        </label>
                        <input type="number" name="ordre" id="categorie_ordre" class="rc-form-control" min="1" value="{{ $categories->count() + 1 }}">
                    </div>
                </div>

                <div class="rc-form-group">
                    <label class="rc-form-label">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="7" height="7" rx="1"/>
                            <rect x="14" y="3" width="7" height="7" rx="1"/>
                            <rect x="3" y="14" width="7" height="7" rx="1"/>
                            <rect x="14" y="14" width="7" height="7" rx="1"/>
                        </svg>
                        Icone
                    </label>
                    <div class="rc-picker-grid">
                        @php
                        $icons = ['folder', 'briefcase', 'clipboard-list', 'id-card', 'graduation-cap', 'file-text', 'heart-pulse', 'calculator', 'award', 'chart-bar'];
                        @endphp
                        @foreach($icons as $icon)
                        <div class="rc-icon-option" data-icon="{{ $icon }}" onclick="selectIcon('{{ $icon }}')">
                            @include('dossier-agent.partials.icon', ['icon' => $icon, 'size' => 20])
                        </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="icone" id="categorie_icone" value="folder">
                </div>

                <label class="rc-form-check" id="obligatoireCheck">
                    <input type="checkbox" name="obligatoire" id="categorie_obligatoire" value="1">
                    <div class="rc-check-box">
                        <svg fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </div>
                    <div>
                        <span class="rc-check-label">Repertoire obligatoire</span>
                        <span class="rc-check-desc">Les documents de ce type sont requis pour chaque employe</span>
                    </div>
                </label>
            </div>
            <div class="rc-modal-footer">
                <button type="button" class="rc-btn-modal rc-btn-modal-cancel" onclick="closeModal()">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Annuler
                </button>
                <button type="submit" class="rc-btn-modal rc-btn-modal-submit">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7"/>
                    </svg>
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
const categorieModal = document.getElementById('categorieModal');
const categorieForm = document.getElementById('categorieForm');

function openCreateModal() {
    document.getElementById('modalTitle').textContent = 'Nouveau Repertoire';
    document.getElementById('formMethod').value = 'POST';
    categorieForm.action = '{{ route("admin.dossier-agent.categories.store") }}';
    categorieForm.reset();
    selectColor('#667eea');
    selectIcon('folder');
    document.getElementById('categorie_ordre').value = '{{ $categories->count() + 1 }}';
    categorieModal.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function openEditModal(categorie) {
    document.getElementById('modalTitle').textContent = 'Modifier le Repertoire';
    document.getElementById('formMethod').value = 'PUT';
    categorieForm.action = '{{ url("admin/dossier-agent/categories") }}/' + categorie.id;

    document.getElementById('categorie_nom').value = categorie.nom;
    document.getElementById('categorie_description').value = categorie.description || '';
    document.getElementById('categorie_ordre').value = categorie.ordre;

    const obligatoireCheckbox = document.getElementById('categorie_obligatoire');
    obligatoireCheckbox.checked = categorie.obligatoire;
    updateCheckState(obligatoireCheckbox);

    selectColor(categorie.couleur);
    selectIcon(categorie.icone);

    categorieModal.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    categorieModal.classList.remove('show');
    document.body.style.overflow = '';
}

function selectColor(color) {
    document.querySelectorAll('.rc-color-option').forEach(el => el.classList.remove('selected'));
    document.querySelector(`.rc-color-option[data-color="${color}"]`)?.classList.add('selected');
    document.getElementById('categorie_couleur').value = color;
}

function selectIcon(icon) {
    document.querySelectorAll('.rc-icon-option').forEach(el => el.classList.remove('selected'));
    document.querySelector(`.rc-icon-option[data-icon="${icon}"]`)?.classList.add('selected');
    document.getElementById('categorie_icone').value = icon;
}

function updateCheckState(checkbox) {
    const wrapper = checkbox.closest('.rc-form-check');
    if (checkbox.checked) {
        wrapper.classList.add('checked');
    } else {
        wrapper.classList.remove('checked');
    }
}

function toggleCategorie(id, newState) {
    fetch('{{ url("admin/dossier-agent/categories") }}/' + id, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ actif: newState })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) location.reload();
        else alert('Erreur: ' + data.message);
    })
    .catch(() => alert('Erreur lors de la mise a jour'));
}

function deleteCategorie(id, nom) {
    if (confirm('Supprimer le repertoire "' + nom + '" ?')) {
        fetch('{{ url("admin/dossier-agent/categories") }}/' + id, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) location.reload();
            else alert('Erreur: ' + data.message);
        })
        .catch(() => alert('Erreur lors de la suppression'));
    }
}

function initDefaultCategories() {
    if (confirm('Initialiser les 10 repertoires par defaut (Contrats, Fiches de poste, Pieces d\'identite, etc.) ?')) {
        fetch('{{ route("admin.dossier-agent.categories.init") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) location.reload();
            else alert('Erreur: ' + data.message);
        })
        .catch(() => alert('Erreur lors de l\'initialisation'));
    }
}

// Checkbox toggle
document.querySelectorAll('.rc-form-check input[type="checkbox"]').forEach(cb => {
    cb.addEventListener('change', function() { updateCheckState(this); });
});

// Fermer modal
categorieModal.addEventListener('click', e => { if (e.target === categorieModal) closeModal(); });
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

// Init default selections
selectColor('#667eea');
selectIcon('folder');
</script>
@endsection
