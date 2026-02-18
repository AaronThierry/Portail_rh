@extends('layouts.app')

@section('title', $entreprise->nom)
@section('page-title', $entreprise->nom)
@section('page-subtitle', $entreprise->sigle ?? 'Profil entreprise')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
</svg>
@endsection

@section('styles')
<style>
/* ============================================================
   ENTREPRISE SHOW — Swiss Corporate Editorial Design System
   Geometric precision · Warm accents · Editorial typography
   Matches the index page design language
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
@keyframes ep-fadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes ep-scaleIn {
    from { opacity: 0; transform: scale(0.96); }
    to { opacity: 1; transform: scale(1); }
}

@keyframes ep-slideIn {
    from { opacity: 0; transform: translateX(-12px); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes ep-pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

/* ==================== PAGE CONTAINER ==================== */
.ep-page {
    font-family: var(--e-font-body);
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 8px;
    animation: ep-fadeUp 0.5s cubic-bezier(0.16, 1, 0.3, 1);
}

/* ==================== BREADCRUMB ==================== */
.ep-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 28px;
    font-size: 0.8125rem;
    font-weight: 500;
    animation: ep-fadeUp 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}

.ep-breadcrumb a {
    color: var(--e-text-secondary);
    text-decoration: none;
    transition: color 0.2s;
    display: flex;
    align-items: center;
    gap: 6px;
}

.ep-breadcrumb a:hover {
    color: var(--e-blue);
}

.ep-breadcrumb a svg {
    width: 15px;
    height: 15px;
}

.ep-breadcrumb-sep {
    color: var(--e-text-tertiary);
    font-size: 0.75rem;
}

.ep-breadcrumb-current {
    color: var(--e-text);
    font-weight: 600;
}

/* ==================== HERO HEADER ==================== */
.ep-hero {
    background: var(--e-surface);
    border: 1px solid var(--e-border);
    border-radius: var(--e-radius-xl);
    padding: 36px 40px;
    margin-bottom: 24px;
    position: relative;
    overflow: hidden;
    box-shadow: var(--e-shadow);
    animation: ep-scaleIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) 0.05s both;
}

.ep-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--e-blue) 0%, var(--e-amber) 100%);
}

.ep-hero::after {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 280px;
    height: 280px;
    background: radial-gradient(circle at top right, var(--e-blue-wash) 0%, transparent 70%);
    pointer-events: none;
}

.ep-hero-inner {
    display: flex;
    align-items: center;
    gap: 32px;
    position: relative;
    z-index: 1;
}

/* Avatar */
.ep-avatar {
    width: 110px;
    height: 110px;
    border-radius: var(--e-radius-lg);
    background: var(--e-blue-wash);
    border: 2px solid var(--e-border);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    flex-shrink: 0;
    transition: transform 0.3s, box-shadow 0.3s;
}

.ep-avatar:hover {
    transform: scale(1.04);
    box-shadow: var(--e-shadow-lg);
}

.ep-avatar img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 12px;
}

.ep-avatar-letters {
    font-family: var(--e-font-display);
    font-size: 2.5rem;
    color: var(--e-blue);
    letter-spacing: -1px;
    user-select: none;
}

/* Hero Info */
.ep-hero-info {
    flex: 1;
    min-width: 0;
}

.ep-company-name {
    font-family: var(--e-font-display);
    font-size: 2.25rem;
    color: var(--e-text);
    margin: 0 0 10px 0;
    line-height: 1.15;
    letter-spacing: -0.5px;
    display: flex;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
}

.ep-status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 14px;
    border-radius: 100px;
    font-family: var(--e-font-body);
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.3px;
    text-transform: uppercase;
}

.ep-status-badge.active {
    background: var(--e-emerald-pale);
    color: var(--e-emerald);
}

.ep-status-badge.inactive {
    background: var(--e-red-pale);
    color: var(--e-red);
}

.ep-status-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: currentColor;
}

.ep-status-badge.active .ep-status-dot {
    animation: ep-pulse 2s ease-in-out infinite;
}

.ep-meta-tags {
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 0;
}

.ep-meta-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.8125rem;
    color: var(--e-text-secondary);
    font-weight: 500;
}

.ep-meta-tag svg {
    width: 15px;
    height: 15px;
    color: var(--e-text-tertiary);
}

/* Hero Actions */
.ep-hero-actions {
    display: flex;
    gap: 10px;
    flex-shrink: 0;
}

.ep-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 22px;
    border-radius: var(--e-radius);
    font-family: var(--e-font-body);
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    border: 1px solid transparent;
    text-decoration: none;
    white-space: nowrap;
}

.ep-btn svg {
    width: 16px;
    height: 16px;
}

.ep-btn-primary {
    background: var(--e-blue);
    color: #fff;
    border-color: var(--e-blue);
}

.ep-btn-primary:hover {
    background: var(--e-blue-deep);
    border-color: var(--e-blue-deep);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(59, 125, 216, 0.3);
}

.ep-btn-outline {
    background: var(--e-surface);
    color: var(--e-text-secondary);
    border-color: var(--e-border);
}

.ep-btn-outline:hover {
    background: var(--e-bg);
    color: var(--e-text);
    border-color: var(--e-text-tertiary);
    transform: translateY(-2px);
}

/* ==================== STATS ROW ==================== */
.ep-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}

.ep-stat {
    background: var(--e-surface);
    border: 1px solid var(--e-border);
    border-radius: var(--e-radius-lg);
    padding: 22px 24px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: var(--e-shadow-sm);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    animation: ep-fadeUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) backwards;
}

.ep-stat:nth-child(1) { animation-delay: 0.1s; }
.ep-stat:nth-child(2) { animation-delay: 0.15s; }
.ep-stat:nth-child(3) { animation-delay: 0.2s; }
.ep-stat:nth-child(4) { animation-delay: 0.25s; }

.ep-stat:hover {
    transform: translateY(-3px);
    box-shadow: var(--e-shadow-md);
    border-color: var(--e-blue);
}

.ep-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: var(--e-radius);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.ep-stat-icon svg {
    width: 22px;
    height: 22px;
}

.ep-stat-icon.blue {
    background: var(--e-blue-pale);
    color: var(--e-blue);
}

.ep-stat-icon.emerald {
    background: var(--e-emerald-pale);
    color: var(--e-emerald);
}

.ep-stat-icon.amber {
    background: var(--e-amber-pale);
    color: var(--e-amber);
}

.ep-stat-icon.slate {
    background: var(--e-slate-100);
    color: var(--e-slate-600);
}

.dark .ep-stat-icon.slate {
    background: rgba(100, 116, 139, 0.15);
}

.ep-stat-info {
    flex: 1;
    min-width: 0;
}

.ep-stat-value {
    font-family: var(--e-font-display);
    font-size: 1.75rem;
    color: var(--e-text);
    line-height: 1;
    margin-bottom: 3px;
}

.ep-stat-label {
    font-size: 0.75rem;
    color: var(--e-text-secondary);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* ==================== MAIN LAYOUT ==================== */
.ep-layout {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 24px;
    align-items: start;
}

/* ==================== CARD ==================== */
.ep-card {
    background: var(--e-surface);
    border: 1px solid var(--e-border);
    border-radius: var(--e-radius-lg);
    overflow: hidden;
    margin-bottom: 20px;
    box-shadow: var(--e-shadow-sm);
    transition: all 0.3s;
    animation: ep-fadeUp 0.45s cubic-bezier(0.16, 1, 0.3, 1) backwards;
}

.ep-card:hover {
    box-shadow: var(--e-shadow-md);
}

.ep-card-header {
    padding: 20px 24px;
    border-bottom: 1px solid var(--e-border-light);
    display: flex;
    align-items: center;
    gap: 12px;
}

.ep-card-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.ep-card-icon svg {
    width: 18px;
    height: 18px;
}

.ep-card-icon.blue { background: var(--e-blue-pale); color: var(--e-blue); }
.ep-card-icon.amber { background: var(--e-amber-pale); color: var(--e-amber); }
.ep-card-icon.emerald { background: var(--e-emerald-pale); color: var(--e-emerald); }
.ep-card-icon.slate { background: var(--e-slate-100); color: var(--e-slate-600); }
.dark .ep-card-icon.slate { background: rgba(100, 116, 139, 0.15); }

.ep-card-title {
    font-family: var(--e-font-display);
    font-size: 1.125rem;
    color: var(--e-text);
    letter-spacing: -0.2px;
}

.ep-card-body {
    padding: 24px;
}

/* ==================== INFO GRID ==================== */
.ep-info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
}

.ep-info-item {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 16px;
    background: var(--e-bg);
    border-radius: var(--e-radius);
    border: 1px solid var(--e-border-light);
    transition: all 0.25s;
}

.ep-info-item:hover {
    border-color: var(--e-border);
    background: var(--e-surface);
    box-shadow: var(--e-shadow-sm);
}

.ep-info-item.full {
    grid-column: span 2;
}

.ep-info-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: var(--e-blue-wash);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.ep-info-icon svg {
    width: 17px;
    height: 17px;
    color: var(--e-blue);
}

.ep-info-icon.emerald { background: var(--e-emerald-pale); }
.ep-info-icon.emerald svg { color: var(--e-emerald); }
.ep-info-icon.amber { background: var(--e-amber-wash); }
.ep-info-icon.amber svg { color: var(--e-amber); }
.ep-info-icon.slate { background: var(--e-slate-100); }
.ep-info-icon.slate svg { color: var(--e-slate-500); }
.dark .ep-info-icon.slate { background: rgba(100, 116, 139, 0.12); }

.ep-info-content {
    flex: 1;
    min-width: 0;
}

.ep-info-label {
    font-size: 0.6875rem;
    text-transform: uppercase;
    letter-spacing: 0.7px;
    color: var(--e-text-tertiary);
    margin-bottom: 4px;
    font-weight: 600;
}

.ep-info-value {
    font-size: 0.9rem;
    color: var(--e-text);
    font-weight: 500;
    word-break: break-word;
    line-height: 1.5;
}

.ep-info-value.highlight {
    color: var(--e-blue);
    font-weight: 600;
}

.ep-info-value a {
    color: var(--e-blue);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s;
}

.ep-info-value a:hover {
    color: var(--e-blue-deep);
    text-decoration: underline;
}

/* ==================== SIDEBAR ==================== */
.ep-sidebar {
    position: sticky;
    top: 24px;
}

/* Quick Actions */
.ep-actions-card {
    background: var(--e-surface);
    border: 1px solid var(--e-border);
    border-radius: var(--e-radius-lg);
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: var(--e-shadow-sm);
    animation: ep-fadeUp 0.45s cubic-bezier(0.16, 1, 0.3, 1) 0.3s both;
}

.ep-actions-label {
    font-size: 0.6875rem;
    font-weight: 700;
    color: var(--e-text-tertiary);
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin-bottom: 14px;
    padding-left: 2px;
}

.ep-action-link {
    display: flex;
    align-items: center;
    gap: 12px;
    width: 100%;
    padding: 12px 14px;
    border-radius: var(--e-radius);
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--e-text-secondary);
    text-decoration: none;
    background: transparent;
    border: 1px solid transparent;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    cursor: pointer;
    margin-bottom: 4px;
}

.ep-action-link:last-child {
    margin-bottom: 0;
}

.ep-action-link svg {
    width: 18px;
    height: 18px;
    flex-shrink: 0;
    color: var(--e-text-tertiary);
    transition: color 0.25s;
}

.ep-action-link:hover {
    background: var(--e-blue-wash);
    color: var(--e-blue);
    border-color: var(--e-blue-pale);
}

.ep-action-link:hover svg {
    color: var(--e-blue);
}

.ep-action-arrow {
    margin-left: auto;
    opacity: 0;
    transform: translateX(-6px);
    transition: all 0.25s;
    width: 14px;
    height: 14px;
}

.ep-action-link:hover .ep-action-arrow {
    opacity: 1;
    transform: translateX(0);
}

/* Timeline */
.ep-timeline-card {
    background: var(--e-surface);
    border: 1px solid var(--e-border);
    border-radius: var(--e-radius-lg);
    overflow: hidden;
    box-shadow: var(--e-shadow-sm);
    animation: ep-fadeUp 0.45s cubic-bezier(0.16, 1, 0.3, 1) 0.35s both;
}

.ep-timeline-header {
    padding: 18px 20px;
    border-bottom: 1px solid var(--e-border-light);
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--e-text);
}

.ep-timeline-header svg {
    width: 16px;
    height: 16px;
    color: var(--e-amber);
}

.ep-timeline-body {
    padding: 20px;
}

.ep-timeline-item {
    display: flex;
    gap: 14px;
    position: relative;
    padding-bottom: 20px;
}

.ep-timeline-item:last-child {
    padding-bottom: 0;
}

.ep-timeline-item:not(:last-child)::after {
    content: '';
    position: absolute;
    left: 17px;
    top: 38px;
    bottom: 0;
    width: 2px;
    background: var(--e-border-light);
}

.ep-timeline-dot {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    position: relative;
    z-index: 1;
}

.ep-timeline-dot svg {
    width: 16px;
    height: 16px;
}

.ep-timeline-dot.created {
    background: var(--e-emerald-pale);
    color: var(--e-emerald);
}

.ep-timeline-dot.updated {
    background: var(--e-blue-pale);
    color: var(--e-blue);
}

.ep-timeline-content {
    flex: 1;
    padding-top: 2px;
}

.ep-timeline-text {
    font-size: 0.875rem;
    color: var(--e-text);
    font-weight: 500;
    margin-bottom: 2px;
}

.ep-timeline-date {
    font-size: 0.75rem;
    color: var(--e-text-tertiary);
    font-weight: 500;
}

/* ==================== DESCRIPTION BLOCK ==================== */
.ep-description {
    font-size: 0.9rem;
    color: var(--e-text-secondary);
    line-height: 1.7;
}

/* ==================== RESPONSIVE ==================== */
@media (max-width: 1100px) {
    .ep-layout {
        grid-template-columns: 1fr;
    }
    .ep-sidebar {
        position: static;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    .ep-actions-card,
    .ep-timeline-card {
        margin-bottom: 0;
    }
}

@media (max-width: 900px) {
    .ep-stats {
        grid-template-columns: repeat(2, 1fr);
    }
    .ep-hero-inner {
        flex-wrap: wrap;
    }
    .ep-hero-actions {
        width: 100%;
        justify-content: flex-start;
    }
}

@media (max-width: 700px) {
    .ep-stats {
        grid-template-columns: 1fr;
    }
    .ep-info-grid {
        grid-template-columns: 1fr;
    }
    .ep-info-item.full {
        grid-column: span 1;
    }
    .ep-sidebar {
        grid-template-columns: 1fr;
    }
    .ep-hero {
        padding: 24px 20px;
    }
    .ep-hero-inner {
        flex-direction: column;
        text-align: center;
    }
    .ep-meta-tags {
        justify-content: center;
    }
    .ep-hero-actions {
        justify-content: center;
    }
    .ep-company-name {
        justify-content: center;
        font-size: 1.75rem;
    }
    .ep-avatar {
        width: 90px;
        height: 90px;
    }
}
</style>
@endsection

@section('content')
<div class="ep-page">

    <!-- Breadcrumb -->
    <nav class="ep-breadcrumb">
        <a href="{{ route('admin.entreprises.index') }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"></path>
            </svg>
            Entreprises
        </a>
        <span class="ep-breadcrumb-sep">/</span>
        <span class="ep-breadcrumb-current">{{ $entreprise->nom }}</span>
    </nav>

    <!-- Hero Header -->
    <div class="ep-hero">
        <div class="ep-hero-inner">
            <!-- Avatar -->
            <div class="ep-avatar">
                @if($entreprise->logo)
                    <img src="{{ asset($entreprise->logo) }}" alt="{{ $entreprise->nom }}">
                @else
                    <span class="ep-avatar-letters">{{ strtoupper(substr($entreprise->nom, 0, 2)) }}</span>
                @endif
            </div>

            <!-- Info -->
            <div class="ep-hero-info">
                <h1 class="ep-company-name">
                    {{ $entreprise->nom }}
                    <span class="ep-status-badge {{ $entreprise->is_active ? 'active' : 'inactive' }}">
                        <span class="ep-status-dot"></span>
                        {{ $entreprise->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </h1>
                <div class="ep-meta-tags">
                    @if($entreprise->sigle)
                    <span class="ep-meta-tag">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="4 7 4 4 20 4 20 7"></polyline>
                            <line x1="9" y1="20" x2="15" y2="20"></line>
                            <line x1="12" y1="4" x2="12" y2="20"></line>
                        </svg>
                        {{ $entreprise->sigle }}
                    </span>
                    @endif
                    @if($entreprise->secteur_activite)
                    <span class="ep-meta-tag">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                            <path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"></path>
                        </svg>
                        {{ $entreprise->secteur_activite }}
                    </span>
                    @endif
                    @if($entreprise->ville)
                    <span class="ep-meta-tag">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        {{ $entreprise->ville }}, {{ $entreprise->pays ?? 'Burkina Faso' }}
                    </span>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="ep-hero-actions">
                <a href="{{ route('admin.entreprises.edit', $entreprise) }}" class="ep-btn ep-btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    Modifier
                </a>
                <a href="{{ route('admin.entreprises.index') }}" class="ep-btn ep-btn-outline">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    Retour
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="ep-stats">
        <div class="ep-stat">
            <div class="ep-stat-icon blue">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 00-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 010 7.75"></path>
                </svg>
            </div>
            <div class="ep-stat-info">
                <div class="ep-stat-value">{{ $entreprise->utilisateurs->count() }}</div>
                <div class="ep-stat-label">Utilisateurs</div>
            </div>
        </div>

        <div class="ep-stat">
            <div class="ep-stat-icon emerald">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <div class="ep-stat-info">
                <div class="ep-stat-value">{{ $entreprise->departements->count() }}</div>
                <div class="ep-stat-label">Departements</div>
            </div>
        </div>

        <div class="ep-stat">
            <div class="ep-stat-icon amber">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                    <path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"></path>
                </svg>
            </div>
            <div class="ep-stat-info">
                <div class="ep-stat-value">{{ $entreprise->services->count() }}</div>
                <div class="ep-stat-label">Services</div>
            </div>
        </div>

        <div class="ep-stat">
            <div class="ep-stat-icon slate">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 20V10"></path>
                    <path d="M18 20V4"></path>
                    <path d="M6 20v-4"></path>
                </svg>
            </div>
            <div class="ep-stat-info">
                <div class="ep-stat-value">{{ $entreprise->nombre_employes ?? 0 }}</div>
                <div class="ep-stat-label">Employes</div>
            </div>
        </div>
    </div>

    <!-- Main Layout -->
    <div class="ep-layout">

        <!-- Main Content -->
        <div class="ep-main">

            <!-- Informations generales -->
            <div class="ep-card" style="animation-delay: 0.1s;">
                <div class="ep-card-header">
                    <div class="ep-card-icon blue">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                    </div>
                    <h2 class="ep-card-title">Informations generales</h2>
                </div>
                <div class="ep-card-body">
                    <div class="ep-info-grid">
                        <div class="ep-info-item">
                            <div class="ep-info-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"></path>
                                </svg>
                            </div>
                            <div class="ep-info-content">
                                <div class="ep-info-label">Raison sociale</div>
                                <div class="ep-info-value highlight">{{ $entreprise->nom }}</div>
                            </div>
                        </div>

                        @if($entreprise->sigle)
                        <div class="ep-info-item">
                            <div class="ep-info-icon slate">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="4 7 4 4 20 4 20 7"></polyline>
                                    <line x1="9" y1="20" x2="15" y2="20"></line>
                                    <line x1="12" y1="4" x2="12" y2="20"></line>
                                </svg>
                            </div>
                            <div class="ep-info-content">
                                <div class="ep-info-label">Sigle / Acronyme</div>
                                <div class="ep-info-value">{{ $entreprise->sigle }}</div>
                            </div>
                        </div>
                        @endif

                        @if($entreprise->secteur_activite)
                        <div class="ep-info-item">
                            <div class="ep-info-icon amber">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                    <path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"></path>
                                </svg>
                            </div>
                            <div class="ep-info-content">
                                <div class="ep-info-label">Secteur d'activite</div>
                                <div class="ep-info-value">{{ $entreprise->secteur_activite }}</div>
                            </div>
                        </div>
                        @endif

                        @if($entreprise->nombre_employes)
                        <div class="ep-info-item">
                            <div class="ep-info-icon slate">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 00-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 010 7.75"></path>
                                </svg>
                            </div>
                            <div class="ep-info-content">
                                <div class="ep-info-label">Effectif declare</div>
                                <div class="ep-info-value">{{ $entreprise->nombre_employes }} employes</div>
                            </div>
                        </div>
                        @endif

                        @if($entreprise->description)
                        <div class="ep-info-item full">
                            <div class="ep-info-icon slate">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="17" y1="10" x2="3" y2="10"></line>
                                    <line x1="21" y1="6" x2="3" y2="6"></line>
                                    <line x1="21" y1="14" x2="3" y2="14"></line>
                                    <line x1="17" y1="18" x2="3" y2="18"></line>
                                </svg>
                            </div>
                            <div class="ep-info-content">
                                <div class="ep-info-label">Description</div>
                                <div class="ep-info-value ep-description">{{ $entreprise->description }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Coordonnees -->
            <div class="ep-card" style="animation-delay: 0.15s;">
                <div class="ep-card-header">
                    <div class="ep-card-icon emerald">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"></path>
                        </svg>
                    </div>
                    <h2 class="ep-card-title">Coordonnees</h2>
                </div>
                <div class="ep-card-body">
                    <div class="ep-info-grid">
                        <div class="ep-info-item">
                            <div class="ep-info-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                            </div>
                            <div class="ep-info-content">
                                <div class="ep-info-label">Email</div>
                                <div class="ep-info-value">
                                    <a href="mailto:{{ $entreprise->email }}">{{ $entreprise->email }}</a>
                                </div>
                            </div>
                        </div>

                        @if($entreprise->telephone)
                        <div class="ep-info-item">
                            <div class="ep-info-icon emerald">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"></path>
                                </svg>
                            </div>
                            <div class="ep-info-content">
                                <div class="ep-info-label">Telephone</div>
                                <div class="ep-info-value">
                                    <a href="tel:{{ $entreprise->telephone }}">{{ $entreprise->telephone }}</a>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($entreprise->site_web)
                        <div class="ep-info-item full">
                            <div class="ep-info-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="2" y1="12" x2="22" y2="12"></line>
                                    <path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"></path>
                                </svg>
                            </div>
                            <div class="ep-info-content">
                                <div class="ep-info-label">Site web</div>
                                <div class="ep-info-value">
                                    <a href="{{ $entreprise->site_web }}" target="_blank">{{ $entreprise->site_web }}</a>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Localisation -->
            <div class="ep-card" style="animation-delay: 0.2s;">
                <div class="ep-card-header">
                    <div class="ep-card-icon amber">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                    </div>
                    <h2 class="ep-card-title">Localisation</h2>
                </div>
                <div class="ep-card-body">
                    <div class="ep-info-grid">
                        @if($entreprise->adresse)
                        <div class="ep-info-item full">
                            <div class="ep-info-icon amber">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                            </div>
                            <div class="ep-info-content">
                                <div class="ep-info-label">Adresse complete</div>
                                <div class="ep-info-value">{{ $entreprise->adresse }}</div>
                            </div>
                        </div>
                        @endif

                        @if($entreprise->quartier)
                        <div class="ep-info-item">
                            <div class="ep-info-icon slate">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon>
                                    <line x1="8" y1="2" x2="8" y2="18"></line>
                                    <line x1="16" y1="6" x2="16" y2="22"></line>
                                </svg>
                            </div>
                            <div class="ep-info-content">
                                <div class="ep-info-label">Quartier</div>
                                <div class="ep-info-value">{{ $entreprise->quartier }}</div>
                            </div>
                        </div>
                        @endif

                        @if($entreprise->ville)
                        <div class="ep-info-item">
                            <div class="ep-info-icon slate">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                            </div>
                            <div class="ep-info-content">
                                <div class="ep-info-label">Ville</div>
                                <div class="ep-info-value">{{ $entreprise->ville }}</div>
                            </div>
                        </div>
                        @endif

                        @if($entreprise->code_postal)
                        <div class="ep-info-item">
                            <div class="ep-info-icon slate">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                                    <path d="M6 8h.01M10 8h.01M14 8h.01M18 8h.01M6 12h.01M10 12h.01M14 12h.01M18 12h.01M6 16h.01M10 16h.01M14 16h.01"></path>
                                </svg>
                            </div>
                            <div class="ep-info-content">
                                <div class="ep-info-label">Code postal</div>
                                <div class="ep-info-value">{{ $entreprise->code_postal }}</div>
                            </div>
                        </div>
                        @endif

                        <div class="ep-info-item">
                            <div class="ep-info-icon slate">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="2" y1="12" x2="22" y2="12"></line>
                                    <path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"></path>
                                </svg>
                            </div>
                            <div class="ep-info-content">
                                <div class="ep-info-label">Pays</div>
                                <div class="ep-info-value">{{ $entreprise->pays ?? 'Burkina Faso' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations legales -->
            @if($entreprise->numero_registre || $entreprise->numero_fiscal || $entreprise->numero_cnss)
            <div class="ep-card" style="animation-delay: 0.25s;">
                <div class="ep-card-header">
                    <div class="ep-card-icon slate">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                        </svg>
                    </div>
                    <h2 class="ep-card-title">Informations legales</h2>
                </div>
                <div class="ep-card-body">
                    <div class="ep-info-grid">
                        @if($entreprise->numero_registre)
                        <div class="ep-info-item">
                            <div class="ep-info-icon slate">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            </div>
                            <div class="ep-info-content">
                                <div class="ep-info-label">N. Registre de commerce</div>
                                <div class="ep-info-value">{{ $entreprise->numero_registre }}</div>
                            </div>
                        </div>
                        @endif

                        @if($entreprise->numero_fiscal)
                        <div class="ep-info-item">
                            <div class="ep-info-icon slate">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="12" y1="1" x2="12" y2="23"></line>
                                    <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"></path>
                                </svg>
                            </div>
                            <div class="ep-info-content">
                                <div class="ep-info-label">Identifiant Fiscal (IFU)</div>
                                <div class="ep-info-value">{{ $entreprise->numero_fiscal }}</div>
                            </div>
                        </div>
                        @endif

                        @if($entreprise->numero_cnss)
                        <div class="ep-info-item">
                            <div class="ep-info-icon slate">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                </svg>
                            </div>
                            <div class="ep-info-content">
                                <div class="ep-info-label">N. CNSS</div>
                                <div class="ep-info-value">{{ $entreprise->numero_cnss }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="ep-sidebar">
            <!-- Quick Actions -->
            <div class="ep-actions-card">
                <h3 class="ep-actions-label">Actions rapides</h3>
                <a href="{{ route('admin.entreprises.edit', $entreprise) }}" class="ep-action-link">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    Modifier l'entreprise
                    <svg class="ep-action-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </a>
                <a href="{{ route('admin.personnels.index') }}" class="ep-action-link">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 00-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 010 7.75"></path>
                    </svg>
                    Gerer le personnel
                    <svg class="ep-action-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </a>
                <a href="{{ route('admin.utilisateurs.index') }}" class="ep-action-link">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 00-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 010 7.75"></path>
                    </svg>
                    Gerer les utilisateurs
                    <svg class="ep-action-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </a>

                {{-- Accès Chef d'Entreprise --}}
                @php
                    $chefCompte = \App\Models\User::where('entreprise_id', $entreprise->id)->role("Chef d'Entreprise")->first();
                @endphp
                <a href="{{ route('admin.chef-entreprise.create', $entreprise) }}"
                   class="ep-action-link"
                   style="{{ $chefCompte ? 'background:rgba(5,150,105,0.06);border-color:rgba(5,150,105,0.15);color:#059669;' : 'background:rgba(232,133,12,0.06);border-color:rgba(232,133,12,0.15);color:#b45309;' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                        @if($chefCompte)
                            <path d="M9 12l2 2 4-4" stroke-width="2.5"/>
                        @else
                            <line x1="12" y1="11" x2="12" y2="17"/>
                            <line x1="9" y1="14" x2="15" y2="14"/>
                        @endif
                    </svg>
                    @if($chefCompte)
                        Compte Chef d'Entreprise ✓
                    @else
                        Créer accès Chef d'Entreprise
                    @endif
                    <svg class="ep-action-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </a>
            </div>

            <!-- Activity Timeline -->
            <div class="ep-timeline-card">
                <div class="ep-timeline-header">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    Activite recente
                </div>
                <div class="ep-timeline-body">
                    <div class="ep-timeline-item">
                        <div class="ep-timeline-dot created">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                        </div>
                        <div class="ep-timeline-content">
                            <div class="ep-timeline-text">Entreprise creee</div>
                            <div class="ep-timeline-date">{{ $entreprise->created_at->format('d/m/Y à H:i') }}</div>
                        </div>
                    </div>
                    @if($entreprise->updated_at && $entreprise->updated_at != $entreprise->created_at)
                    <div class="ep-timeline-item">
                        <div class="ep-timeline-dot updated">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </div>
                        <div class="ep-timeline-content">
                            <div class="ep-timeline-text">Derniere modification</div>
                            <div class="ep-timeline-date">{{ $entreprise->updated_at->format('d/m/Y à H:i') }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
