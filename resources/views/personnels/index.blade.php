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
<link rel="stylesheet" href="{{ asset('assets/css/personnels.css') }}">
<style>
/* Base Variables */
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
    --danger-gradient: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    --info-gradient: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    --warning-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}

/* Page Container */
.personnel-page {
    padding: 24px;
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Page Header */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 32px;
    flex-wrap: wrap;
    gap: 16px;
}

.page-title {
    font-size: 1.875rem;
    font-weight: 700;
    color: var(--text-primary);
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.page-description {
    color: var(--text-muted);
    font-size: 0.9375rem;
    margin-top: 4px;
}

/* Statistics Cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
    margin-bottom: 32px;
}

.stat-card {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 16px;
    padding: 24px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: var(--gradient);
    transition: width 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
}

.stat-card:hover::before {
    width: 100%;
    opacity: 0.05;
}

.stat-card.total::before { background: var(--primary-gradient); }
.stat-card.active::before { background: var(--success-gradient); }
.stat-card.inactive::before { background: var(--danger-gradient); }
.stat-card.no-account::before { background: var(--warning-gradient); }

.stat-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 12px;
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.stat-card.total .stat-icon {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    color: #667eea;
}

.stat-card.active .stat-icon {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.1) 100%);
    color: #10b981;
}

.stat-card.inactive .stat-icon {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(220, 38, 38, 0.1) 100%);
    color: #ef4444;
}

.stat-card.no-account .stat-icon {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(217, 119, 6, 0.1) 100%);
    color: #f59e0b;
}

.stat-content {
    display: flex;
    flex-direction: column;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-primary);
    line-height: 1;
}

.stat-label {
    font-size: 0.875rem;
    color: var(--text-muted);
    margin-top: 8px;
    font-weight: 500;
}

/* Search and Filter Toolbar */
.table-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}

.search-box {
    position: relative;
    flex: 1;
    max-width: 400px;
}

.search-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    pointer-events: none;
}

.search-box input {
    width: 100%;
    padding: 12px 16px 12px 44px;
    border: 1px solid var(--card-border);
    border-radius: 10px;
    background: var(--bg-secondary);
    color: var(--text-primary);
    font-size: 0.9375rem;
    transition: var(--transition);
}

.search-box input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
}

.toolbar-actions {
    display: flex;
    gap: 12px;
    align-items: center;
}

/* Buttons */
.btn {
    padding: 13px 24px;
    border-radius: 12px;
    font-size: 0.938rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 2px solid transparent;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    letter-spacing: 0.3px;
    position: relative;
    overflow: hidden;
}

.btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.2);
    transition: left 0.5s ease;
}

.btn:hover::before {
    left: 100%;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #ffffff;
    box-shadow:
        0 8px 24px rgba(102, 126, 234, 0.5),
        0 4px 12px rgba(102, 126, 234, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.2);
    font-weight: 700;
    font-size: 0.9375rem;
    padding: 14px 28px;
    position: relative;
    overflow: hidden;
}

.btn-primary::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.btn-primary:hover::after {
    width: 300px;
    height: 300px;
}

.btn-primary:hover {
    transform: translateY(-3px) scale(1.02);
    box-shadow:
        0 12px 32px rgba(102, 126, 234, 0.6),
        0 6px 16px rgba(102, 126, 234, 0.4),
        inset 0 1px 0 rgba(255, 255, 255, 0.3);
}

.btn-primary:active {
    transform: translateY(-1px) scale(0.98);
}

.btn-secondary {
    background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
    color: #475569;
    border: 2px solid #e2e8f0;
    box-shadow:
        0 4px 12px rgba(0, 0, 0, 0.1),
        inset 0 1px 0 rgba(255, 255, 255, 0.8);
    font-weight: 600;
    font-size: 0.9375rem;
    padding: 14px 28px;
}

.dark .btn-secondary {
    background: linear-gradient(145deg, #334155 0%, #1e293b 100%);
    color: #e2e8f0;
    border-color: #475569;
}

.btn-secondary:hover {
    background: linear-gradient(145deg, #f8fafc 0%, #f1f5f9 100%);
    border-color: #667eea;
    transform: translateY(-2px);
    box-shadow:
        0 6px 16px rgba(102, 126, 234, 0.15),
        inset 0 1px 0 rgba(255, 255, 255, 1);
}

.btn-secondary:active {
    transform: translateY(0);
}

/* Table Card */
.table-card {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.table-container {
    overflow-x: auto;
}

.personnel-table {
    width: 100%;
    border-collapse: collapse;
}

.personnel-table thead {
    background: var(--primary-gradient);
}

.personnel-table th {
    padding: 18px 20px;
    text-align: left;
    font-size: 0.813rem;
    font-weight: 700;
    color: #ffffff;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    white-space: nowrap;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

.personnel-table td {
    padding: 16px 20px;
    border-bottom: 1px solid var(--card-border);
    color: var(--text-primary);
    font-size: 0.9375rem;
}

.personnel-table tbody tr {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
}

.personnel-table tbody tr:hover {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
    transform: translateY(-1px);
}

/* Personnel Avatar */
.personnel-cell {
    display: flex;
    align-items: center;
    gap: 12px;
}

.personnel-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--card-border);
}

.personnel-info {
    display: flex;
    flex-direction: column;
}

.personnel-name {
    font-weight: 600;
    color: var(--text-primary);
}

.personnel-matricule {
    font-size: 0.8125rem;
    color: var(--text-muted);
}

/* Badge */
.badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    white-space: nowrap;
    letter-spacing: 0.3px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.badge-success {
    background: var(--success-gradient);
    color: #ffffff;
}

.badge-danger {
    background: var(--danger-gradient);
    color: #ffffff;
}

.badge-warning {
    background: var(--warning-gradient);
    color: #ffffff;
}

.badge-info {
    background: var(--info-gradient);
    color: #ffffff;
}

.badge-primary {
    background: var(--primary-gradient);
    color: #ffffff;
}

/* Date Badge - Style Élégant */
.date-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 14px;
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(5, 150, 105, 0.08) 100%);
    border: 1.5px solid rgba(16, 185, 129, 0.2);
    border-radius: 12px;
    font-size: 0.8125rem;
    font-weight: 600;
    color: #059669;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    white-space: nowrap;
}

.date-badge:hover {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.12) 0%, rgba(5, 150, 105, 0.12) 100%);
    border-color: rgba(16, 185, 129, 0.35);
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);
}

.date-badge .date-icon {
    color: #10b981;
    flex-shrink: 0;
    transition: transform 0.3s ease;
}

.date-badge:hover .date-icon {
    transform: scale(1.1) rotate(-5deg);
}

.date-badge .date-text {
    letter-spacing: 0.3px;
    font-variant-numeric: tabular-nums;
}

.text-muted {
    color: #94a3b8;
    font-size: 0.8125rem;
    font-style: italic;
}

/* Dark mode pour date badge */
.dark .date-badge {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.12) 0%, rgba(5, 150, 105, 0.12) 100%);
    border-color: rgba(16, 185, 129, 0.3);
    color: #34d399;
}

.dark .date-badge:hover {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.18) 0%, rgba(5, 150, 105, 0.18) 100%);
    border-color: rgba(16, 185, 129, 0.45);
}

.dark .date-badge .date-icon {
    color: #34d399;
}

.dark .text-muted {
    color: #64748b;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 8px;
}

.btn-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 2px solid transparent;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.btn-icon.btn-view {
    background: rgba(59, 130, 246, 0.1);
    color: #3b82f6;
}

.btn-icon.btn-view:hover {
    background: var(--info-gradient);
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.btn-icon.btn-edit {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
}

.btn-icon.btn-edit:hover {
    background: var(--success-gradient);
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.btn-icon.btn-delete {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
}

.btn-icon.btn-delete:hover {
    background: var(--danger-gradient);
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

/* Multi-Step Modal - Ultra Professional avec animations améliorées */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(15, 23, 42, 0.85) 0%, rgba(88, 28, 135, 0.4) 100%);
    backdrop-filter: blur(16px) saturate(180%);
    -webkit-backdrop-filter: blur(16px) saturate(180%);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2000;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1),
                visibility 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    padding: 20px;
    animation: overlayPulse 3s ease-in-out infinite;
}

@keyframes overlayPulse {
    0%, 100% { backdrop-filter: blur(16px) saturate(180%); }
    50% { backdrop-filter: blur(18px) saturate(200%); }
}

.modal-overlay.show {
    opacity: 1;
    visibility: visible;
}

.modal {
    background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
    border-radius: 32px;
    box-shadow:
        0 60px 120px -30px rgba(102, 126, 234, 0.4),
        0 40px 80px -40px rgba(0, 0, 0, 0.5),
        inset 0 1px 0 rgba(255, 255, 255, 0.7),
        0 0 0 1px rgba(102, 126, 234, 0.15),
        0 0 60px -20px rgba(102, 126, 234, 0.2);
    width: 100%;
    max-width: 920px;
    height: 90vh;
    max-height: 90vh;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transform: scale(0.85) translateY(60px) rotateX(10deg);
    transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1),
                box-shadow 0.5s ease;
    position: relative;
    border: 2px solid transparent;
    background-clip: padding-box;
}

.modal::after {
    content: '';
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.5), rgba(118, 75, 162, 0.3), rgba(102, 126, 234, 0.5));
    border-radius: 32px;
    z-index: -1;
    opacity: 0.6;
    filter: blur(1px);
}

.dark .modal {
    background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%);
    border: 1px solid rgba(148, 163, 184, 0.1);
}

.modal-overlay.show .modal {
    transform: scale(1) translateY(0) rotateX(0deg);
    box-shadow:
        0 70px 140px -40px rgba(102, 126, 234, 0.5),
        0 50px 100px -50px rgba(0, 0, 0, 0.6),
        inset 0 1px 0 rgba(255, 255, 255, 0.8),
        0 0 0 1px rgba(102, 126, 234, 0.2),
        0 0 80px -30px rgba(102, 126, 234, 0.3);
}

.modal::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 400px;
    background: radial-gradient(circle at 50% 0%, rgba(102, 126, 234, 0.08) 0%, transparent 70%);
    pointer-events: none;
    z-index: 0;
}

.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 28px 18px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow: hidden;
    flex-shrink: 0;
}

.modal-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    border-radius: 50%;
}

.modal-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #ffffff;
    text-shadow: 0 2px 6px rgba(0, 0, 0, 0.12);
    letter-spacing: -0.02em;
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    gap: 10px;
}

.modal-title::before {
    content: '';
    display: inline-block;
    width: 3px;
    height: 22px;
    background: rgba(255, 255, 255, 0.5);
    border-radius: 2px;
}

.modal-close {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    border: 2px solid rgba(255, 255, 255, 0.2);
    background: rgba(255, 255, 255, 0.1);
    color: #ffffff;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    z-index: 1;
    backdrop-filter: blur(10px);
}

.modal-close:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: rotate(90deg) scale(1.05);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    border-color: rgba(255, 255, 255, 0.4);
}

.modal-close:active {
    transform: rotate(90deg) scale(0.95);
}

/* Step Indicator - Version compacte fixe */
.step-indicator {
    display: flex;
    justify-content: space-between;
    padding: 20px 32px 16px;
    background: linear-gradient(180deg, rgba(102, 126, 234, 0.03) 0%, rgba(118, 75, 162, 0.06) 100%);
    border-bottom: 1px solid rgba(102, 126, 234, 0.12);
    position: relative;
    overflow: visible;
    flex-shrink: 0;
}

/* Barre de progression animée - Réduite */
.step-indicator::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg,
        #667eea 0%,
        #764ba2 35%,
        #f093fb 65%,
        #10b981 100%);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.7s cubic-bezier(0.65, 0, 0.35, 1);
    box-shadow:
        0 2px 10px rgba(102, 126, 234, 0.4),
        0 1px 3px rgba(102, 126, 234, 0.3);
    animation: progressGlow 2s ease-in-out infinite;
}

@keyframes progressGlow {
    0%, 100% {
        box-shadow:
            0 2px 10px rgba(102, 126, 234, 0.4),
            0 1px 3px rgba(102, 126, 234, 0.3);
    }
    50% {
        box-shadow:
            0 3px 12px rgba(102, 126, 234, 0.6),
            0 2px 4px rgba(102, 126, 234, 0.4);
    }
}

.step-indicator.progress-33::before {
    transform: scaleX(0.33);
}

.step-indicator.progress-66::before {
    transform: scaleX(0.66);
}

.step-indicator.progress-100::before {
    transform: scaleX(1);
    background: linear-gradient(90deg,
        #10b981 0%,
        #34d399 50%,
        #6ee7b7 100%);
}

.step-indicator::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent 0%, rgba(102, 126, 234, 0.2) 50%, transparent 100%);
}

.step {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    cursor: pointer;
    padding: 4px 6px;
    border-radius: 10px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    background: transparent;
}

.step:hover {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.03) 0%, rgba(118, 75, 162, 0.03) 100%);
    transform: translateY(-1px);
}

.step.active {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
}

.step:not(:last-child)::after {
    content: '';
    position: absolute;
    left: calc(50% + 26px);
    right: calc(-50% + 26px);
    top: 22px;
    height: 2px;
    background: linear-gradient(90deg, var(--card-border) 0%, rgba(102, 126, 234, 0.1) 100%);
    z-index: 0;
    transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.step.active:not(:last-child)::after {
    background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    height: 3px;
    box-shadow: 0 2px 12px rgba(102, 126, 234, 0.4);
    animation: flowingLine 2s ease-in-out infinite;
}

.step.completed:not(:last-child)::after {
    background: linear-gradient(90deg, #10b981 0%, #059669 100%);
    height: 3px;
    box-shadow: 0 2px 12px rgba(16, 185, 129, 0.4);
}

@keyframes flowingLine {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.7;
    }
}

.step-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(145deg, #ffffff 0%, #f1f5f9 100%);
    border: 2px solid rgba(102, 126, 234, 0.25);
    color: var(--text-muted);
    font-weight: 700;
    font-size: 0.875rem;
    z-index: 1;
    transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    position: relative;
    box-shadow:
        0 4px 12px rgba(0, 0, 0, 0.06),
        inset 0 1px 2px rgba(255, 255, 255, 0.9),
        0 0 0 0 rgba(102, 126, 234, 0.3);
    margin-bottom: 10px;
    animation: breathe 3s ease-in-out infinite;
}

@keyframes breathe {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.01);
    }
}

.dark .step-circle {
    background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%);
}

.step-circle::before {
    content: '';
    position: absolute;
    width: calc(100% + 12px);
    height: calc(100% + 12px);
    border-radius: 50%;
    background: var(--primary-gradient);
    opacity: 0;
    transform: scale(0.85);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: -1;
}

.step.active .step-circle::before {
    opacity: 0.15;
    transform: scale(1);
    animation: pulseRing 2.5s ease-in-out infinite;
}

@keyframes pulseRing {
    0%, 100% {
        opacity: 0.15;
        transform: scale(1);
    }
    50% {
        opacity: 0.08;
        transform: scale(1.2);
    }
}

.step.active .step-circle {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
    color: #ffffff;
    transform: scale(1.08);
    box-shadow:
        0 10px 24px rgba(102, 126, 234, 0.4),
        0 6px 12px rgba(102, 126, 234, 0.25),
        0 0 0 4px rgba(102, 126, 234, 0.15),
        inset 0 1px 2px rgba(255, 255, 255, 0.3);
}

.step.completed .step-circle {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border-color: rgba(16, 185, 129, 0.5);
    color: #ffffff;
    box-shadow:
        0 6px 16px rgba(16, 185, 129, 0.3),
        0 3px 8px rgba(16, 185, 129, 0.2),
        inset 0 1px 2px rgba(255, 255, 255, 0.3);
    transform: scale(1.05);
}

.step-circle svg {
    width: 16px;
    height: 16px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.step.completed .step-circle svg {
    opacity: 0;
    transform: scale(0.5);
}

.step.completed .step-circle::after {
    content: '';
    position: absolute;
    width: 20px;
    height: 12px;
    border-left: 3px solid #ffffff;
    border-bottom: 3px solid #ffffff;
    transform: rotate(-45deg) scale(0);
    animation: checkmark 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
    margin-bottom: 4px;
}

@keyframes checkmark {
    0% {
        opacity: 0;
        transform: rotate(-45deg) scale(0);
    }
    50% {
        opacity: 1;
        transform: rotate(-45deg) scale(1.2);
    }
    100% {
        opacity: 1;
        transform: rotate(-45deg) scale(1);
    }
}

.step-info {
    text-align: center;
    width: 100%;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.step-label {
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--text-secondary);
    margin-bottom: 2px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    letter-spacing: -0.01em;
    line-height: 1.2;
}

.step.active .step-label {
    color: #667eea;
    font-size: 0.8125rem;
}

.step.completed .step-label {
    color: #10b981;
}

.step-description {
    font-size: 0.625rem;
    color: var(--text-muted);
    opacity: 0.65;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    line-height: 1.2;
    font-weight: 500;
}

.step.active .step-description {
    opacity: 1;
    color: #667eea;
    font-weight: 600;
}

.step.completed .step-description {
    opacity: 0.75;
    color: #059669;
}

/* Form doit prendre toute la hauteur disponible */
#personnelForm {
    display: flex;
    flex-direction: column;
    flex: 1;
    overflow: hidden;
    min-height: 0;
    height: 100%;
}

/* Modal Body - Scrollable avec header et footer fixes */
.modal-body {
    padding: 24px 32px 32px;
    flex: 0 1 auto;
    overflow-y: auto;
    overflow-x: hidden;
    position: relative;
    z-index: 1;
    background: linear-gradient(180deg, rgba(255, 255, 255, 0.6) 0%, rgba(248, 250, 252, 0.4) 100%);
    backdrop-filter: blur(8px);
    min-height: 300px;
    max-height: 480px;
    height: 480px;
}

.dark .modal-body {
    background: linear-gradient(180deg, rgba(15, 23, 42, 0.6) 0%, rgba(15, 23, 42, 0.4) 100%);
}

.modal-body::-webkit-scrollbar {
    width: 8px;
}

.modal-body::-webkit-scrollbar-track {
    background: rgba(102, 126, 234, 0.05);
    border-radius: 10px;
}

.modal-body::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
    border-radius: 10px;
    transition: all 0.3s ease;
}

.modal-body::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(180deg, #764ba2 0%, #667eea 100%);
}

.step-content {
    display: none !important;
    opacity: 0;
    transform: translateX(30px) scale(0.98);
    width: 100%;
}

.step-content.active {
    display: block !important;
    animation: slideInContent 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
}

/* Utility class */
.hidden {
    display: none !important;
}

@keyframes slideInContent {
    0% {
        opacity: 0;
        transform: translateX(30px) scale(0.98);
    }
    60% {
        transform: translateX(-5px) scale(1.01);
    }
    100% {
        opacity: 1;
        transform: translateX(0) scale(1);
    }
}

/* Modal Footer - Section boutons fixe en bas */
.modal-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 32px;
    border-top: 2px solid rgba(102, 126, 234, 0.2);
    background: linear-gradient(180deg, rgba(255, 255, 255, 0.98) 0%, rgba(248, 250, 252, 1) 100%);
    backdrop-filter: blur(10px);
    position: relative;
    bottom: 0;
    z-index: 10;
    gap: 16px;
    flex-shrink: 0;
    box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.05);
}

.dark .modal-footer {
    background: linear-gradient(180deg, rgba(15, 23, 42, 0.95) 0%, rgba(30, 41, 59, 0.98) 100%);
    border-top-color: rgba(148, 163, 184, 0.15);
}

.modal-footer .btn-group {
    display: flex;
    gap: 12px;
    align-items: center;
}

.modal-footer .btn-group.left {
    justify-content: flex-start;
}

.modal-footer .btn-group.right {
    justify-content: flex-end;
}

/* Step Content Header - Hiérarchie visuelle améliorée */
.step-content-header {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 32px;
    padding-bottom: 20px;
    border-bottom: 2px solid rgba(102, 126, 234, 0.12);
    position: relative;
}

.step-content-header::before {
    content: '';
    width: 5px;
    height: 40px;
    background: var(--primary-gradient);
    border-radius: 3px;
    box-shadow:
        0 3px 10px rgba(102, 126, 234, 0.4),
        0 0 20px rgba(102, 126, 234, 0.2);
}

.step-content-header::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 80px;
    height: 2px;
    background: var(--primary-gradient);
    border-radius: 2px;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.4);
}

.step-content-title {
    font-size: 1.375rem;
    font-weight: 700;
    color: var(--text-primary);
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    letter-spacing: -0.02em;
    line-height: 1.3;
}

/* Matricule Preview - Professional Badge avec espacement amélioré */
.matricule-preview {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 24px 28px;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
    border: 2px dashed rgba(102, 126, 234, 0.3);
    border-radius: 18px;
    backdrop-filter: blur(10px);
    position: relative;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.matricule-preview:hover {
    border-color: rgba(102, 126, 234, 0.5);
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.12) 0%, rgba(118, 75, 162, 0.12) 100%);
    box-shadow:
        0 8px 20px rgba(102, 126, 234, 0.15),
        inset 0 1px 0 rgba(255, 255, 255, 0.5);
}

.matricule-preview::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 5px;
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    box-shadow: 0 0 15px rgba(102, 126, 234, 0.4);
}

.matricule-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    flex-shrink: 0;
}

.matricule-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.matricule-label {
    font-size: 0.8125rem;
    font-weight: 600;
    color: #667eea;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.matricule-value {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
    font-family: 'Courier New', monospace;
    letter-spacing: 1px;
}

/* Form Grid - Espacement optimisé */
.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 28px;
    margin-bottom: 8px;
}

.form-grid.full {
    grid-template-columns: 1fr;
}

.form-group {
    margin-bottom: 0;
    position: relative;
}

/* Section spacing dans les étapes */
.step-content > .form-grid:not(:last-child),
.step-content > .form-group:not(:last-child),
.step-content > .matricule-preview:not(:last-child) {
    margin-bottom: 36px;
}

.form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 700;
    color: var(--text-secondary);
    margin-bottom: 12px;
    letter-spacing: 0.4px;
    text-transform: uppercase;
    font-size: 0.75rem;
    transition: all 0.3s ease;
}

.form-label.required::after {
    content: '*';
    color: #ef4444;
    margin-left: 6px;
    font-size: 1rem;
    animation: requiredPulse 2s ease-in-out infinite;
}

@keyframes requiredPulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.6;
    }
}

.form-input,
.form-select,
.form-textarea {
    width: 100%;
    padding: 14px 18px;
    border: 2px solid transparent;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.9);
    color: var(--text-primary);
    font-size: 0.9375rem;
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow:
        0 2px 4px rgba(0, 0, 0, 0.04),
        inset 0 1px 2px rgba(0, 0, 0, 0.03);
    position: relative;
}

.form-input:hover,
.form-select:hover,
.form-textarea:hover {
    background: rgba(255, 255, 255, 1);
    box-shadow:
        0 4px 8px rgba(0, 0, 0, 0.06),
        inset 0 1px 2px rgba(0, 0, 0, 0.02);
    border-color: rgba(102, 126, 234, 0.15);
}

.dark .form-input,
.dark .form-select,
.dark .form-textarea {
    background: rgba(30, 41, 59, 0.8);
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    outline: none;
    border-color: #667eea;
    background: #ffffff;
    box-shadow:
        0 0 0 5px rgba(102, 126, 234, 0.15),
        0 8px 20px rgba(102, 126, 234, 0.2),
        0 2px 8px rgba(102, 126, 234, 0.1);
    transform: translateY(-2px) scale(1.01);
    animation: focusPulse 2s ease-in-out infinite;
}

@keyframes focusPulse {
    0%, 100% {
        box-shadow:
            0 0 0 5px rgba(102, 126, 234, 0.15),
            0 8px 20px rgba(102, 126, 234, 0.2),
            0 2px 8px rgba(102, 126, 234, 0.1);
    }
    50% {
        box-shadow:
            0 0 0 6px rgba(102, 126, 234, 0.2),
            0 10px 24px rgba(102, 126, 234, 0.25),
            0 4px 12px rgba(102, 126, 234, 0.15);
    }
}

.dark .form-input:focus,
.dark .form-select:focus,
.dark .form-textarea:focus {
    background: #1e293b;
}

.form-input::placeholder,
.form-textarea::placeholder {
    color: #94a3b8;
    font-weight: 400;
}

.form-textarea {
    resize: vertical;
    min-height: 80px;
    line-height: 1.6;
    font-family: inherit;
}

/* ========================================
   DATE PICKER - DESIGN PROFESSIONNEL MODERNE
   ======================================== */

/* Input Date - Style de Base */
input[type="date"] {
    position: relative;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    font-weight: 600;
    font-size: 0.9375rem;
    letter-spacing: 0.5px;
    cursor: pointer;
    padding: 16px 52px 16px 52px;
    color: #1e293b;
    background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
    border: 2px solid rgba(102, 126, 234, 0.12);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Icône Calendrier à Gauche - SVG Inline */
input[type="date"] {
    background-image:
        url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='22' height='22' viewBox='0 0 24 24' fill='none' stroke='%23667eea' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='18' rx='3' ry='3'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3Cpath d='M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01M16 18h.01'%3E%3C/path%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: 16px center;
    background-size: 22px 22px;
}

/* États Hover */
input[type="date"]:hover {
    border-color: rgba(102, 126, 234, 0.3);
    background: linear-gradient(145deg, #ffffff 0%, #f1f5f9 100%);
    box-shadow:
        0 4px 12px rgba(102, 126, 234, 0.08),
        0 2px 6px rgba(0, 0, 0, 0.04);
    transform: translateY(-1px);
    background-image:
        url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='22' height='22' viewBox='0 0 24 24' fill='none' stroke='%23764ba2' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='18' rx='3' ry='3'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3Cpath d='M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01M16 18h.01'%3E%3C/path%3E%3C/svg%3E");
}

/* États Focus */
input[type="date"]:focus {
    border-color: #667eea;
    background: #ffffff;
    box-shadow:
        0 0 0 4px rgba(102, 126, 234, 0.12),
        0 8px 24px rgba(102, 126, 234, 0.15),
        0 4px 12px rgba(0, 0, 0, 0.06);
    transform: translateY(-2px) scale(1.005);
    background-image:
        url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='22' height='22' viewBox='0 0 24 24' fill='none' stroke='%23667eea' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='18' rx='3' ry='3'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3Cpath d='M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01M16 18h.01'%3E%3C/path%3E%3C/svg%3E");
}

/* Date Valide (Date Sélectionnée) */
input[type="date"]:valid {
    background: linear-gradient(145deg, #f0f4ff 0%, #e0e7ff 100%);
    border-color: rgba(102, 126, 234, 0.3);
    color: #1e293b;
    font-weight: 700;
}

/* Indicateur Calendrier Natif (Bouton Droite) */
input[type="date"]::-webkit-calendar-picker-indicator {
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    width: 28px;
    height: 28px;
    cursor: pointer;
    opacity: 0.7;
    transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    filter: brightness(0) saturate(100%) invert(43%) sepia(96%) saturate(1274%) hue-rotate(220deg) brightness(95%) contrast(93%);
    padding: 6px;
    border-radius: 8px;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
}

input[type="date"]:hover::-webkit-calendar-picker-indicator {
    opacity: 0.9;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
    transform: translateY(-50%) scale(1.12) rotate(5deg);
}

input[type="date"]:focus::-webkit-calendar-picker-indicator {
    opacity: 1;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.22) 0%, rgba(118, 75, 162, 0.22) 100%);
    transform: translateY(-50%) scale(1.18);
    animation: dateIndicatorPulse 1.8s ease-in-out infinite;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

@keyframes dateIndicatorPulse {
    0%, 100% {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.22) 0%, rgba(118, 75, 162, 0.22) 100%);
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    50% {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.32) 0%, rgba(118, 75, 162, 0.32) 100%);
        box-shadow: 0 0 0 5px rgba(102, 126, 234, 0.15);
    }
}

/* Date Naissance - Style Spécial avec Badge */
input[type="date"][name="date_naissance"] {
    background-image:
        url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='22' height='22' viewBox='0 0 24 24' fill='none' stroke='%23ec4899' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2'%3E%3C/path%3E%3Ccircle cx='12' cy='7' r='4'%3E%3C/circle%3E%3C/svg%3E");
    border-color: rgba(236, 72, 153, 0.15);
}

input[type="date"][name="date_naissance"]:hover {
    border-color: rgba(236, 72, 153, 0.3);
    background-image:
        url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='22' height='22' viewBox='0 0 24 24' fill='none' stroke='%23ec4899' stroke-width='2.6' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2'%3E%3C/path%3E%3Ccircle cx='12' cy='7' r='4'%3E%3C/circle%3E%3C/svg%3E");
}

input[type="date"][name="date_naissance"]:focus {
    border-color: #ec4899;
    background-image:
        url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='22' height='22' viewBox='0 0 24 24' fill='none' stroke='%23ec4899' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2'%3E%3C/path%3E%3Ccircle cx='12' cy='7' r='4'%3E%3C/circle%3E%3C/svg%3E");
}

input[type="date"][name="date_naissance"]:valid {
    background: linear-gradient(145deg, #fdf2f8 0%, #fce7f3 100%);
}

/* Date Embauche - Style Professionnel */
input[type="date"][name="date_embauche"] {
    background-image:
        url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='22' height='22' viewBox='0 0 24 24' fill='none' stroke='%2310b981' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='18' rx='3' ry='3'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3Cpath d='M9 16l2 2 4-4'%3E%3C/path%3E%3C/svg%3E");
    border-color: rgba(16, 185, 129, 0.15);
}

input[type="date"][name="date_embauche"]:hover {
    border-color: rgba(16, 185, 129, 0.3);
    background-image:
        url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='22' height='22' viewBox='0 0 24 24' fill='none' stroke='%2310b981' stroke-width='2.6' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='18' rx='3' ry='3'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3Cpath d='M9 16l2 2 4-4'%3E%3C/path%3E%3C/svg%3E");
}

input[type="date"][name="date_embauche"]:focus {
    border-color: #10b981;
    background-image:
        url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='22' height='22' viewBox='0 0 24 24' fill='none' stroke='%2310b981' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='18' rx='3' ry='3'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3Cpath d='M9 16l2 2 4-4'%3E%3C/path%3E%3C/svg%3E");
}

input[type="date"][name="date_embauche"]:valid {
    background: linear-gradient(145deg, #f0fdf4 0%, #dcfce7 100%);
}

/* Date Fin Contrat - Style Attention */
input[type="date"][name="date_fin_contrat"] {
    background-image:
        url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='22' height='22' viewBox='0 0 24 24' fill='none' stroke='%23f59e0b' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='18' rx='3' ry='3'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3Cpath d='M12 14v3M12 19h.01'%3E%3C/path%3E%3C/svg%3E");
    border-color: rgba(245, 158, 11, 0.15);
}

input[type="date"][name="date_fin_contrat"]:hover {
    border-color: rgba(245, 158, 11, 0.3);
    background-image:
        url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='22' height='22' viewBox='0 0 24 24' fill='none' stroke='%23f59e0b' stroke-width='2.6' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='18' rx='3' ry='3'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3Cpath d='M12 14v3M12 19h.01'%3E%3C/path%3E%3C/svg%3E");
}

input[type="date"][name="date_fin_contrat"]:focus {
    border-color: #f59e0b;
    background-image:
        url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='22' height='22' viewBox='0 0 24 24' fill='none' stroke='%23f59e0b' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='18' rx='3' ry='3'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3Cpath d='M12 14v3M12 19h.01'%3E%3C/path%3E%3C/svg%3E");
}

input[type="date"][name="date_fin_contrat"]:valid {
    background: linear-gradient(145deg, #fffbeb 0%, #fef3c7 100%);
}

/* ========================================
   DARK MODE - DATE PICKER
   ======================================== */

.dark input[type="date"] {
    background: linear-gradient(145deg, rgba(30, 41, 59, 0.95) 0%, rgba(15, 23, 42, 0.95) 100%);
    border-color: rgba(148, 163, 184, 0.2);
    color: #e2e8f0;
    background-image:
        url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='22' height='22' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='18' rx='3' ry='3'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3Cpath d='M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01M16 18h.01'%3E%3C/path%3E%3C/svg%3E");
}

.dark input[type="date"]:hover,
.dark input[type="date"]:focus {
    background: linear-gradient(145deg, rgba(30, 41, 59, 1) 0%, rgba(15, 23, 42, 1) 100%);
    border-color: rgba(148, 163, 184, 0.35);
    background-image:
        url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='22' height='22' viewBox='0 0 24 24' fill='none' stroke='%23cbd5e1' stroke-width='2.8' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='18' rx='3' ry='3'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3Cpath d='M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01M16 18h.01'%3E%3C/path%3E%3C/svg%3E");
}

.dark input[type="date"]:valid {
    background: linear-gradient(145deg, rgba(30, 41, 59, 1) 0%, rgba(51, 65, 85, 0.95) 100%);
    color: #f1f5f9;
}

.dark input[type="date"]::-webkit-calendar-picker-indicator {
    filter: brightness(0) saturate(100%) invert(80%) sepia(10%) saturate(500%) hue-rotate(180deg) brightness(95%) contrast(90%);
    background: linear-gradient(135deg, rgba(148, 163, 184, 0.12) 0%, rgba(203, 213, 225, 0.12) 100%);
}

.dark input[type="date"]:hover::-webkit-calendar-picker-indicator {
    background: linear-gradient(135deg, rgba(148, 163, 184, 0.2) 0%, rgba(203, 213, 225, 0.2) 100%);
}

.dark input[type="date"]:focus::-webkit-calendar-picker-indicator {
    background: linear-gradient(135deg, rgba(148, 163, 184, 0.28) 0%, rgba(203, 213, 225, 0.28) 100%);
}

/* ========================================
   CALENDRIER POPUP - PERSONNALISATION
   ======================================== */

/* Style du popup calendrier (Chrome/Edge) */
input[type="date"]::-webkit-datetime-edit {
    padding: 0;
    font-weight: 600;
    letter-spacing: 0.5px;
}

input[type="date"]::-webkit-datetime-edit-fields-wrapper {
    padding: 0;
}

input[type="date"]::-webkit-datetime-edit-text {
    color: rgba(102, 126, 234, 0.6);
    padding: 0 3px;
    font-weight: 500;
}

input[type="date"]::-webkit-datetime-edit-month-field,
input[type="date"]::-webkit-datetime-edit-day-field,
input[type="date"]::-webkit-datetime-edit-year-field {
    padding: 4px 6px;
    border-radius: 6px;
    transition: all 0.2s ease;
    color: #1e293b;
    font-weight: 600;
}

input[type="date"]::-webkit-datetime-edit-month-field:hover,
input[type="date"]::-webkit-datetime-edit-day-field:hover,
input[type="date"]::-webkit-datetime-edit-year-field:hover {
    background: rgba(102, 126, 234, 0.12);
    color: #667eea;
}

input[type="date"]::-webkit-datetime-edit-month-field:focus,
input[type="date"]::-webkit-datetime-edit-day-field:focus,
input[type="date"]::-webkit-datetime-edit-year-field:focus {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.18) 0%, rgba(118, 75, 162, 0.18) 100%);
    color: #667eea;
    outline: none;
    box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.2);
}

/* Placeholder quand aucune date sélectionnée */
input[type="date"]:invalid::-webkit-datetime-edit {
    color: #94a3b8;
    font-weight: 500;
}

/* Style pour les champs vides */
input[type="date"]::-webkit-datetime-edit-month-field[aria-valuetext=""],
input[type="date"]::-webkit-datetime-edit-day-field[aria-valuetext=""],
input[type="date"]::-webkit-datetime-edit-year-field[aria-valuetext=""] {
    color: #cbd5e1;
}

/* Dark mode pour les champs du calendrier */
.dark input[type="date"]::-webkit-datetime-edit-month-field,
.dark input[type="date"]::-webkit-datetime-edit-day-field,
.dark input[type="date"]::-webkit-datetime-edit-year-field {
    color: #e2e8f0;
}

.dark input[type="date"]::-webkit-datetime-edit-text {
    color: rgba(148, 163, 184, 0.6);
}

.dark input[type="date"]::-webkit-datetime-edit-month-field:hover,
.dark input[type="date"]::-webkit-datetime-edit-day-field:hover,
.dark input[type="date"]::-webkit-datetime-edit-year-field:hover {
    background: rgba(148, 163, 184, 0.15);
    color: #cbd5e1;
}

.dark input[type="date"]::-webkit-datetime-edit-month-field:focus,
.dark input[type="date"]::-webkit-datetime-edit-day-field:focus,
.dark input[type="date"]::-webkit-datetime-edit-year-field:focus {
    background: rgba(148, 163, 184, 0.22);
    color: #f1f5f9;
    box-shadow: 0 0 0 2px rgba(148, 163, 184, 0.25);
}

/* ========================================
   WRAPPER DU CHAMP DATE - AMÉLIORATION
   ======================================== */

/* Conteneur pour ajouter des effets visuels */
.form-group:has(input[type="date"]) {
    position: relative;
}

/* Badge indicateur de type de date */
.form-group:has(input[type="date"][name="date_naissance"])::after {
    content: '🎂 Naissance';
    position: absolute;
    top: -10px;
    left: 12px;
    background: linear-gradient(135deg, #ec4899 0%, #f472b6 100%);
    color: white;
    font-size: 0.6875rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 12px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    box-shadow: 0 2px 8px rgba(236, 72, 153, 0.3);
    z-index: 10;
    pointer-events: none;
    opacity: 0;
    transform: translateY(4px);
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.form-group:has(input[type="date"][name="date_naissance"]:focus)::after {
    opacity: 1;
    transform: translateY(0);
}

.form-group:has(input[type="date"][name="date_embauche"])::after {
    content: '💼 Embauche';
    position: absolute;
    top: -10px;
    left: 12px;
    background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
    color: white;
    font-size: 0.6875rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 12px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    z-index: 10;
    pointer-events: none;
    opacity: 0;
    transform: translateY(4px);
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.form-group:has(input[type="date"][name="date_embauche"]:focus)::after {
    opacity: 1;
    transform: translateY(0);
}

.form-group:has(input[type="date"][name="date_fin_contrat"])::after {
    content: '⏳ Fin CDD';
    position: absolute;
    top: -10px;
    left: 12px;
    background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
    color: white;
    font-size: 0.6875rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 12px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
    z-index: 10;
    pointer-events: none;
    opacity: 0;
    transform: translateY(4px);
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.form-group:has(input[type="date"][name="date_fin_contrat"]:focus)::after {
    opacity: 1;
    transform: translateY(0);
}

/* Animation du champ date au focus */
.form-group:has(input[type="date"]:focus) {
    animation: dateFieldGlow 2s ease-in-out infinite;
}

@keyframes dateFieldGlow {
    0%, 100% {
        filter: drop-shadow(0 0 0px transparent);
    }
    50% {
        filter: drop-shadow(0 0 8px rgba(102, 126, 234, 0.2));
    }
}

/* Info tooltip pour les dates */
input[type="date"] + .date-info {
    display: block;
    margin-top: 8px;
    padding: 8px 12px;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.06) 0%, rgba(118, 75, 162, 0.06) 100%);
    border-left: 3px solid #667eea;
    border-radius: 6px;
    font-size: 0.8125rem;
    color: #64748b;
    line-height: 1.5;
    opacity: 0;
    transform: translateY(-8px);
    transition: all 0.3s ease;
}

input[type="date"]:focus + .date-info {
    opacity: 1;
    transform: translateY(0);
}

.dark input[type="date"] + .date-info {
    background: linear-gradient(135deg, rgba(148, 163, 184, 0.08) 0%, rgba(203, 213, 225, 0.08) 100%);
    border-left-color: #94a3b8;
    color: #94a3b8;
}

.form-error {
    color: #ef4444;
    font-size: 0.8125rem;
    margin-top: 6px;
    display: none;
}

.form-error.show {
    display: block;
}

/* Phone Input with Country Code - Enhanced */
.phone-input-group {
    display: flex;
    gap: 12px;
    align-items: flex-start;
}

/* Wrapper pour drapeau + select */
.phone-input-group .country-code-wrapper {
    position: relative;
    flex: 0 0 auto;
    display: flex;
    align-items: center;
    gap: 6px;
}

/* Image du drapeau */
.phone-input-group .country-flag-img {
    width: 28px;
    height: 21px;
    border-radius: 3px;
    object-fit: cover;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(0, 0, 0, 0.1);
    flex-shrink: 0;
}

/* Sélecteur de pays - Optimisé avec noms */
.phone-input-group .country-code-select {
    min-width: 260px;
    max-width: 280px;
    flex-shrink: 0;
    font-weight: 600;
    font-size: 0.9rem;
    padding: 12px 32px 12px 12px;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23667eea' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 14px;
    appearance: none;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.phone-input-group .country-code-select:hover {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.phone-input-group .country-code-select:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15);
}

/* Style des options - Amélioré pour les noms de pays */
.phone-input-group .country-code-select option {
    padding: 12px 14px;
    font-size: 0.95rem;
    font-weight: 500;
    line-height: 1.6;
    background: white;
    color: #1e293b;
}

.phone-input-group .country-code-select option:hover {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
    color: #667eea;
}

.phone-input-group .country-code-select optgroup {
    font-weight: 800;
    font-size: 0.75rem;
    color: #667eea;
    padding: 8px 14px;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin: 4px 0;
}

/* Champ numéro de téléphone */
.phone-input-group .form-input {
    flex: 1;
    font-family: 'Courier New', monospace;
    letter-spacing: 0.5px;
    font-size: 1rem;
    font-weight: 500;
}

.phone-input-group .form-input:focus {
    font-family: 'Courier New', monospace;
}

.phone-input-group .form-input::placeholder {
    font-family: 'Courier New', monospace;
    letter-spacing: 0.5px;
}

/* Checkbox Group - Amélioré pour step 3 */
.checkbox-group {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 0;
    background: transparent;
    border-radius: 0;
    border: none;
}

.checkbox-wrapper {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    cursor: pointer;
    position: relative;
    transition: all 0.3s ease;
}

.checkbox-wrapper:hover {
    background: rgba(102, 126, 234, 0.05) !important;
    border-color: rgba(102, 126, 234, 0.4) !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
}

.checkbox-wrapper:has(input:checked) {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%) !important;
    border-color: #667eea !important;
    box-shadow:
        0 4px 12px rgba(102, 126, 234, 0.2),
        inset 0 1px 0 rgba(255, 255, 255, 0.5);
}

.checkbox-wrapper:has(input:checked)::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px 0 0 12px;
}

.checkbox-input {
    width: 20px;
    height: 20px;
    cursor: pointer;
    accent-color: #667eea;
    flex-shrink: 0;
    margin-top: 2px;
}

.checkbox-label {
    font-size: 0.9375rem;
    color: var(--text-primary);
    font-weight: 500;
    cursor: pointer;
    line-height: 1.5;
}

/* Date Fin CDD (conditional) */
#dateFin ContratGroup {
    transition: all 0.3s ease;
}

#dateFinContratGroup.hidden {
    display: none;
}

/* Modal Footer - Fixe et aligné avec header */
.modal-footer {
    display: grid;
    grid-template-columns: auto 1fr auto;
    align-items: center;
    gap: 24px;
    padding: 24px 32px;
    border-top: 2px solid rgba(102, 126, 234, 0.08);
    background: linear-gradient(180deg, rgba(102, 126, 234, 0.02) 0%, rgba(118, 75, 162, 0.03) 100%);
    position: relative;
    z-index: 10;
    flex-shrink: 0;
}

.modal-footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent 0%, rgba(102, 126, 234, 0.3) 50%, transparent 100%);
}

/* Groupe de boutons gauche (Précédent) */
.modal-footer .btn-group.left {
    grid-column: 1;
    display: flex;
    gap: 12px;
    align-items: center;
}

/* Section centrale (Raccourcis clavier) */
.modal-footer .keyboard-hints-footer {
    grid-column: 2;
    text-align: center;
    justify-self: center;
}

/* Groupe de boutons droite (Suivant/Soumettre) */
.modal-footer .btn-group.right {
    grid-column: 3;
    display: flex;
    gap: 12px;
    align-items: center;
}

/* Fallback pour l'ancien système */
.modal-footer .btn-group:not(.left):not(.right) {
    display: flex;
    gap: 16px;
    align-items: center;
}

/* Enhanced buttons in modal footer avec hiérarchie visuelle claire */
.modal-footer .btn {
    min-width: 150px;
    font-size: 0.9375rem;
    padding: 16px 32px;
    font-weight: 700;
    position: relative;
    z-index: 20;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    border-radius: 14px;
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    text-transform: none;
    letter-spacing: 0.3px;
}

.modal-footer .btn-primary {
    box-shadow:
        0 10px 28px rgba(102, 126, 234, 0.55),
        0 5px 14px rgba(102, 126, 234, 0.35),
        inset 0 1px 0 rgba(255, 255, 255, 0.25);
    animation: pulseButton 2s ease-in-out infinite;
}

@keyframes pulseButton {
    0%, 100% {
        box-shadow:
            0 10px 28px rgba(102, 126, 234, 0.55),
            0 5px 14px rgba(102, 126, 234, 0.35),
            inset 0 1px 0 rgba(255, 255, 255, 0.25);
    }
    50% {
        box-shadow:
            0 12px 32px rgba(102, 126, 234, 0.65),
            0 6px 18px rgba(102, 126, 234, 0.45),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
    }
}

.modal-footer .btn-primary:hover {
    animation: none;
    transform: translateY(-4px) scale(1.03);
    box-shadow:
        0 16px 40px rgba(102, 126, 234, 0.7),
        0 8px 20px rgba(102, 126, 234, 0.5),
        inset 0 1px 0 rgba(255, 255, 255, 0.35);
}

.modal-footer .btn-primary:active {
    transform: translateY(-2px) scale(1.01);
    transition: all 0.1s ease;
}

.modal-footer .btn-secondary {
    border-width: 2px;
    box-shadow:
        0 6px 16px rgba(0, 0, 0, 0.12),
        inset 0 1px 0 rgba(255, 255, 255, 0.9);
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}

.modal-footer .btn-secondary:hover {
    transform: translateY(-3px) scale(1.02);
    box-shadow:
        0 10px 24px rgba(0, 0, 0, 0.15),
        inset 0 1px 0 rgba(255, 255, 255, 1);
    border-color: rgba(102, 126, 234, 0.4);
}

.modal-footer .btn-secondary:active {
    transform: translateY(-1px) scale(1);
    transition: all 0.1s ease;
}

/* État désactivé avec feedback visuel */
.modal-footer .btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none !important;
    animation: none !important;
    filter: grayscale(0.3);
}

/* Icônes de navigation dans les boutons */
.modal-footer .btn-primary::after {
    content: '→';
    font-size: 1.125rem;
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    font-weight: 400;
}

.modal-footer .btn-primary:hover::after {
    transform: translateX(5px) scale(1.1);
}

.modal-footer .btn-secondary::before {
    content: '←';
    font-size: 1.125rem;
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    font-weight: 400;
}

.modal-footer .btn-secondary:hover::before {
    transform: translateX(-5px) scale(1.1);
}

/* Bouton de fermeture (annuler) */
.modal-footer .btn-outline {
    background: transparent;
    border: 2px solid rgba(203, 213, 225, 0.5);
    color: var(--text-secondary);
    box-shadow: none;
    min-width: 130px;
    padding: 14px 28px;
}

.modal-footer .btn-outline:hover {
    background: rgba(248, 250, 252, 0.8);
    border-color: rgba(102, 126, 234, 0.3);
    color: #667eea;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
}

.modal-footer .btn-outline:active {
    transform: translateY(0);
}

.dark .modal-footer .btn-outline {
    border-color: rgba(71, 85, 105, 0.5);
    color: var(--text-muted);
}

.dark .modal-footer .btn-outline:hover {
    background: rgba(30, 41, 59, 0.8);
    border-color: rgba(102, 126, 234, 0.4);
    color: #818cf8;
}

/* Indicateur de progression sur les boutons */
.modal-footer .btn-primary .step-indicator-text {
    font-size: 0.6875rem;
    opacity: 0.8;
    font-weight: 600;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

/* Responsive: Adaptation mobile du footer */
@media (max-width: 768px) {
    .modal-footer {
        grid-template-columns: 1fr;
        grid-template-rows: auto auto auto;
        gap: 16px;
        padding: 24px 20px 28px;
    }

    .modal-footer .btn-group.left {
        grid-column: 1;
        grid-row: 3;
        justify-content: space-between;
        width: 100%;
    }

    .modal-footer .keyboard-hints-footer {
        grid-column: 1;
        grid-row: 1;
        margin-bottom: 8px;
    }

    .modal-footer .btn-group.right {
        grid-column: 1;
        grid-row: 2;
        justify-content: stretch;
    }

    .modal-footer .btn-group.right .btn {
        flex: 1;
    }

    .modal-footer .btn {
        min-width: auto;
        padding: 14px 24px;
        font-size: 0.875rem;
    }

    .modal-footer .btn-outline {
        padding: 12px 20px;
    }
}

/* Animation d'apparition des boutons */
@keyframes slideInButton {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modal-footer .btn {
    animation: slideInButton 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) backwards;
}

.modal-footer .btn-group.left .btn:nth-child(1) {
    animation-delay: 0.1s;
}

.modal-footer .btn-group.left .btn:nth-child(2) {
    animation-delay: 0.15s;
}

.modal-footer .btn-group.right .btn {
    animation-delay: 0.2s;
}

/* File Upload Preview */
.file-upload-wrapper {
    position: relative;
}

.file-preview {
    margin-top: 12px;
    display: none;
}

.file-preview.show {
    display: block;
}

.file-preview img {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 12px;
    border: 2px solid var(--card-border);
}

/* Notification Toast */
.notification-toast {
    position: fixed;
    top: 20px;
    right: -400px;
    min-width: 320px;
    max-width: 420px;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    z-index: 10000;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    border-left: 4px solid #667eea;
}

.dark .notification-toast {
    background: #1e293b;
}

.notification-toast.show {
    right: 20px;
}

.notification-toast.notification-success {
    border-left-color: #10b981;
}

.notification-toast.notification-error {
    border-left-color: #ef4444;
}

.notification-toast.notification-info {
    border-left-color: #3b82f6;
}

.notification-content {
    display: flex;
    align-items: start;
    gap: 12px;
    padding: 16px 20px;
}

.notification-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: bold;
    flex-shrink: 0;
}

.notification-success .notification-icon {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.15) 100%);
    color: #10b981;
}

.notification-error .notification-icon {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(220, 38, 38, 0.15) 100%);
    color: #ef4444;
}

.notification-info .notification-icon {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(37, 99, 235, 0.15) 100%);
    color: #3b82f6;
}

.notification-message {
    flex: 1;
    font-size: 0.9375rem;
    color: var(--text-primary);
    line-height: 1.5;
}

.notification-close {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 24px;
    height: 24px;
    border: none;
    background: transparent;
    color: var(--text-muted);
    cursor: pointer;
    font-size: 24px;
    line-height: 1;
    transition: all 0.2s ease;
}

.notification-close:hover {
    color: var(--text-primary);
    transform: rotate(90deg);
}

/* Loading Spinner Animation */
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.animate-spin {
    animation: spin 1s linear infinite;
}

/* Form Improvements */
.form-input.error,
.form-select.error {
    border-color: #ef4444;
    background: rgba(239, 68, 68, 0.05);
}

.form-input:disabled,
.form-select:disabled {
    background: var(--bg-tertiary);
    opacity: 0.6;
    cursor: not-allowed;
}

/* Better Modal Scrollbar */
.modal-body::-webkit-scrollbar {
    width: 8px;
}

.modal-body::-webkit-scrollbar-track {
    background: var(--bg-secondary);
    border-radius: 10px;
}

.modal-body::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 10px;
}

.modal-body::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
}

/* Responsive */
@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .table-toolbar {
        flex-direction: column;
        align-items: stretch;
    }

    .search-box {
        max-width: 100%;
    }

    /* Mobile Step Indicator */
    .step-indicator {
        padding: 20px 16px;
    }

    .step {
        flex-direction: column;
        padding: 4px;
    }

    .step-info {
        margin-left: 0;
        margin-top: 8px;
        text-align: center;
    }

    .step-label {
        font-size: 0.75rem;
        margin-bottom: 2px;
    }

    .step-description {
        display: none;
    }

    .step-circle {
        width: 40px;
        height: 40px;
        font-size: 0.875rem;
    }

    .step:not(:last-child)::after {
        display: none;
    }

    .modal {
        max-width: 100%;
        border-radius: 0;
        max-height: 100vh;
    }

    .modal-body {
        padding: 20px;
    }

    .notification-toast {
        min-width: auto;
        left: 10px;
        right: 10px;
        max-width: calc(100% - 20px);
    }

    .notification-toast.show {
        right: 10px;
    }
}

/* Tablet */
@media (min-width: 769px) and (max-width: 1024px) {
    .step-description {
        font-size: 0.7rem;
    }

    .step-circle {
        width: 44px;
        height: 44px;
    }
}
</style>
@endsection

@section('content')
<div class="personnel-page">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Gestion du Personnel</h1>
            <p class="page-description">Gérez les employés et leurs informations</p>
        </div>
        <button class="btn btn-primary" id="btnAddPersonnel">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="8.5" cy="7" r="4"></circle>
                <line x1="20" y1="8" x2="20" y2="14"></line>
                <line x1="23" y1="11" x2="17" y2="11"></line>
            </svg>
            Ajouter un personnel
        </button>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card total">
            <div class="stat-header">
                <div class="stat-content">
                    <div class="stat-value" data-count="{{ $personnels->total() ?? 0 }}">0</div>
                    <div class="stat-label">Personnel Total</div>
                </div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="stat-card active">
            <div class="stat-header">
                <div class="stat-content">
                    <div class="stat-value" data-count="{{ $personnels->where('is_active', true)->count() }}">0</div>
                    <div class="stat-label">Personnel Actif</div>
                </div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
            </div>
        </div>
        <div class="stat-card inactive">
            <div class="stat-header">
                <div class="stat-content">
                    <div class="stat-value" data-count="{{ $personnels->where('is_active', false)->count() }}">0</div>
                    <div class="stat-label">Personnel Inactif</div>
                </div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                </div>
            </div>
        </div>
        <div class="stat-card no-account">
            <div class="stat-header">
                <div class="stat-content">
                    <div class="stat-value" data-count="{{ $personnels->whereNull('user_id')->count() }}">0</div>
                    <div class="stat-label">Sans Compte</div>
                </div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="table-toolbar">
        <div class="search-box">
            <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
            <input type="search" placeholder="Rechercher un personnel..." id="searchInput">
        </div>
        <div class="toolbar-actions">
            <button class="btn btn-secondary" id="btnFilter">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                </svg>
                Filtrer
            </button>
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-card">
        <div class="table-container">
            <table class="personnel-table">
                <thead>
                    <tr>
                        <th>Personnel</th>
                        <th>Sexe</th>
                        <th>Poste</th>
                        <th>Département</th>
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
                            <div class="personnel-cell">
                                <img src="{{ $personnel->photo_url }}" alt="{{ $personnel->nom_complet }}" class="personnel-avatar">
                                <div class="personnel-info">
                                    <span class="personnel-name">{{ $personnel->nom_complet }}</span>
                                    <span class="personnel-matricule">{{ $personnel->matricule }}</span>
                                </div>
                            </div>
                        </td>
                        <td>{{ $personnel->sexe ?? 'N/A' }}</td>
                        <td>{{ $personnel->poste ?? 'Non défini' }}</td>
                        <td>{{ $personnel->departement->nom ?? 'Non assigné' }}</td>
                        <td>
                            @if($personnel->date_embauche)
                            <div class="date-badge">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="date-icon">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                <span class="date-text">{{ \Carbon\Carbon::parse($personnel->date_embauche)->locale('fr')->isoFormat('DD MMM YYYY') }}</span>
                            </div>
                            @else
                            <span class="text-muted">Non renseignée</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $personnel->type_contrat === 'CDI' ? 'badge-info' : 'badge-warning' }}">
                                {{ $personnel->type_contrat }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $personnel->is_active ? 'badge-success' : 'badge-danger' }}">
                                {{ $personnel->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.personnels.show', $personnel->id) }}" class="btn-icon btn-view" title="Voir détails">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </a>
                                <button class="btn-icon btn-delete" title="Supprimer" onclick="deletePersonnel({{ $personnel->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 60px 20px;">
                            <div style="opacity: 0.6;">
                                <svg style="width: 80px; height: 80px; margin: 0 auto 20px; color: var(--text-muted);" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                                <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">Aucun personnel trouvé</h3>
                                <p style="color: var(--text-muted); font-size: 0.9375rem;">Commencez par ajouter votre premier employé</p>
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
    <div style="margin-top: 24px;">
        {{ $personnels->links() }}
    </div>
    @endif
</div>

<!-- ANCIENNE MODALE DÉSACTIVÉE - VOIR modal_clean.blade.php
<!-- ========================================
     MODALE CRÉATION PERSONNEL - V2 CLEAN
     ======================================== -->
{{-- <div class="modal-overlay" id="personnelModal">
    <div class="modal">
        <div class="modal-header">
            <h2 class="modal-title" id="modalTitle">Enregistrer un nouveau personnel</h2>
            <button class="modal-close" onclick="closeModal()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <!-- Step Indicator - Ultra Modern -->
        <div class="step-indicator progress-33" id="stepIndicator">
            <div class="step active" data-step="1" onclick="goToStep(1)">
                <div class="step-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <div class="step-info">
                    <div class="step-label">Informations Personnelles</div>
                    <div class="step-description">Identité et civilité</div>
                </div>
            </div>
            <div class="step" data-step="2" onclick="goToStep(2)">
                <div class="step-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                </div>
                <div class="step-info">
                    <div class="step-label">Coordonnées & Documents</div>
                    <div class="step-description">Contact et pièces</div>
                </div>
            </div>
            <div class="step" data-step="3" onclick="goToStep(3)">
                <div class="step-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                    </svg>
                </div>
                <div class="step-info">
                    <div class="step-label">Poste & Contrat</div>
                    <div class="step-description">Emploi et statut</div>
                </div>
            </div>
        </div>

        <form id="personnelForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="personnelId" name="personnel_id">

            <div class="modal-body">
                <!-- Step 1: Informations Personnelles -->
                <div class="step-content active" data-step="1">
                    @if(auth()->user()->hasRole('Super Admin'))
                    <div class="form-grid full" style="margin-bottom: 20px;">
                        <div class="form-group">
                            <label for="entreprise_id" class="form-label required">Entreprise</label>
                            <select id="entreprise_id" name="entreprise_id" class="form-select" required>
                                <option value="">Sélectionner une entreprise</option>
                                @foreach($entreprises as $entreprise)
                                <option value="{{ $entreprise->id }}" {{ $entreprise->id == auth()->user()->entreprise_id ? 'selected' : '' }}>
                                    {{ $entreprise->nom }}
                                </option>
                                @endforeach
                            </select>
                            <div class="form-error" id="errorEntreprise"></div>
                        </div>
                    </div>
                    @else
                    <input type="hidden" name="entreprise_id" value="{{ auth()->user()->entreprise_id }}">
                    @endif

                    <div class="form-grid full" style="margin-bottom: 20px;">
                        <div class="form-group">
                            <label for="matricule" class="form-label">Matricule (optionnel)</label>
                            <input type="text" id="matricule" name="matricule" class="form-input" placeholder="Laissez vide pour génération automatique">
                            <div style="margin-top: 8px; font-size: 0.813rem; color: var(--text-muted);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: inline-block; vertical-align: middle; margin-right: 4px;">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="16" x2="12" y2="12"></line>
                                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                </svg>
                                Si vide, sera généré automatiquement au format: <strong>PER{{ date('Y') }}####</strong>
                            </div>
                            <div class="form-error" id="errorMatricule"></div>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="civilite" class="form-label">Civilité</label>
                            <select id="civilite" name="civilite" class="form-select">
                                <option value="">Sélectionner</option>
                                <option value="M.">M.</option>
                                <option value="Mme">Mme</option>
                                <option value="Mlle">Mlle</option>
                                <option value="Dr">Dr</option>
                                <option value="Pr">Pr</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="sexe" class="form-label">Sexe</label>
                            <select id="sexe" name="sexe" class="form-select">
                                <option value="">Sélectionner</option>
                                <option value="M">Masculin</option>
                                <option value="F">Féminin</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="nom" class="form-label required">Nom</label>
                            <input type="text" id="nom" name="nom" class="form-input" placeholder="Nom de famille" required>
                            <div class="form-error" id="errorNom"></div>
                        </div>

                        <div class="form-group">
                            <label for="prenoms" class="form-label required">Prénoms</label>
                            <input type="text" id="prenoms" name="prenoms" class="form-input" placeholder="Prénoms" required>
                            <div class="form-error" id="errorPrenoms"></div>
                        </div>

                        <div class="form-group">
                            <label for="date_naissance" class="form-label">Date de Naissance</label>
                            <input type="date" id="date_naissance" name="date_naissance" class="form-input">
                            <small class="date-info">
                                🎂 Sélectionnez la date de naissance du personnel
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" id="photo" name="photo" class="form-input" accept="image/*" onchange="previewPhoto(event)">
                            <div class="file-preview" id="photoPreview">
                                <img id="photoPreviewImg" src="" alt="Aperçu">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Coordonnées & Documents -->
                <div class="step-content" data-step="2">
                    <h3 style="font-size: 1.1rem; font-weight: 600; color: var(--primary); margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 2px solid var(--primary-light);">
                        📞 Coordonnées de contact
                    </h3>

                    <div class="form-grid full">
                        <div class="form-group">
                            <label for="telephone" class="form-label">Téléphone Mobile</label>
                            <div class="phone-input-group">
                                <div class="country-code-wrapper">
                                    <img id="selectedCountryFlag" src="https://flagcdn.com/w40/bf.png" srcset="https://flagcdn.com/w80/bf.png 2x" alt="BF" class="country-flag-img">
                                    <select id="telephone_code_pays" name="telephone_code_pays" class="form-select country-code-select">
                                        <!-- Afrique de l'Ouest -->
                                        <optgroup label="🌍 Afrique de l'Ouest">
                                            <option value="+226" data-country="bf" selected>🇧🇫 Burkina Faso (+226)</option>
                                            <option value="+225" data-country="ci">🇨🇮 Côte d'Ivoire (+225)</option>
                                            <option value="+229" data-country="bj">🇧🇯 Bénin (+229)</option>
                                            <option value="+233" data-country="gh">🇬🇭 Ghana (+233)</option>
                                            <option value="+224" data-country="gn">🇬🇳 Guinée (+224)</option>
                                            <option value="+245" data-country="gw">🇬🇼 Guinée-Bissau (+245)</option>
                                            <option value="+231" data-country="lr">🇱🇷 Liberia (+231)</option>
                                            <option value="+223" data-country="ml">🇲🇱 Mali (+223)</option>
                                            <option value="+222" data-country="mr">🇲🇷 Mauritanie (+222)</option>
                                            <option value="+227" data-country="ne">🇳🇪 Niger (+227)</option>
                                            <option value="+234" data-country="ng">🇳🇬 Nigeria (+234)</option>
                                            <option value="+221" data-country="sn">🇸🇳 Sénégal (+221)</option>
                                            <option value="+232" data-country="sl">🇸🇱 Sierra Leone (+232)</option>
                                            <option value="+228" data-country="tg">🇹🇬 Togo (+228)</option>
                                        </optgroup>

                                        <!-- Afrique Centrale -->
                                        <optgroup label="🌍 Afrique Centrale">
                                            <option value="+237" data-country="cm">🇨🇲 Cameroun (+237)</option>
                                            <option value="+236" data-country="cf">🇨🇫 République Centrafricaine (+236)</option>
                                            <option value="+242" data-country="cg">🇨🇬 Congo-Brazzaville (+242)</option>
                                            <option value="+243" data-country="cd">🇨🇩 RD Congo (+243)</option>
                                            <option value="+240" data-country="gq">🇬🇶 Guinée Équatoriale (+240)</option>
                                            <option value="+241" data-country="ga">🇬🇦 Gabon (+241)</option>
                                            <option value="+235" data-country="td">🇹🇩 Tchad (+235)</option>
                                        </optgroup>

                                        <!-- Afrique du Nord -->
                                        <optgroup label="🌍 Afrique du Nord">
                                            <option value="+213" data-country="dz">🇩🇿 Algérie (+213)</option>
                                            <option value="+20" data-country="eg">🇪🇬 Égypte (+20)</option>
                                            <option value="+218" data-country="ly">🇱🇾 Libye (+218)</option>
                                            <option value="+212" data-country="ma">🇲🇦 Maroc (+212)</option>
                                            <option value="+216" data-country="tn">🇹🇳 Tunisie (+216)</option>
                                        </optgroup>

                                        <!-- Afrique de l'Est -->
                                        <optgroup label="🌍 Afrique de l'Est">
                                            <option value="+251" data-country="et">🇪🇹 Éthiopie (+251)</option>
                                            <option value="+254" data-country="ke">🇰🇪 Kenya (+254)</option>
                                            <option value="+250" data-country="rw">🇷🇼 Rwanda (+250)</option>
                                            <option value="+252" data-country="so">🇸🇴 Somalie (+252)</option>
                                            <option value="+211" data-country="ss">🇸🇸 Soudan du Sud (+211)</option>
                                            <option value="+249" data-country="sd">🇸🇩 Soudan (+249)</option>
                                            <option value="+255" data-country="tz">🇹🇿 Tanzanie (+255)</option>
                                            <option value="+256" data-country="ug">🇺🇬 Ouganda (+256)</option>
                                        </optgroup>

                                        <!-- Afrique Australe -->
                                        <optgroup label="🌍 Afrique Australe">
                                            <option value="+267" data-country="bw">🇧🇼 Botswana (+267)</option>
                                            <option value="+266" data-country="ls">🇱🇸 Lesotho (+266)</option>
                                            <option value="+261" data-country="mg">🇲🇬 Madagascar (+261)</option>
                                            <option value="+265" data-country="mw">🇲🇼 Malawi (+265)</option>
                                            <option value="+230" data-country="mu">🇲🇺 Maurice (+230)</option>
                                            <option value="+258" data-country="mz">🇲🇿 Mozambique (+258)</option>
                                            <option value="+264" data-country="na">🇳🇦 Namibie (+264)</option>
                                            <option value="+27" data-country="za">🇿🇦 Afrique du Sud (+27)</option>
                                            <option value="+268" data-country="sz">🇸🇿 Eswatini (+268)</option>
                                            <option value="+260" data-country="zm">🇿🇲 Zambie (+260)</option>
                                            <option value="+263" data-country="zw">🇿🇼 Zimbabwe (+263)</option>
                                        </optgroup>

                                        <!-- Europe -->
                                        <optgroup label="🇪🇺 Europe">
                                            <option value="+33" data-country="fr">🇫🇷 France (+33)</option>
                                            <option value="+32" data-country="be">🇧🇪 Belgique (+32)</option>
                                            <option value="+41" data-country="ch">🇨🇭 Suisse (+41)</option>
                                            <option value="+44" data-country="gb">🇬🇧 Royaume-Uni (+44)</option>
                                            <option value="+49" data-country="de">🇩🇪 Allemagne (+49)</option>
                                            <option value="+39" data-country="it">🇮🇹 Italie (+39)</option>
                                            <option value="+34" data-country="es">🇪🇸 Espagne (+34)</option>
                                            <option value="+351" data-country="pt">🇵🇹 Portugal (+351)</option>
                                            <option value="+31" data-country="nl">🇳🇱 Pays-Bas (+31)</option>
                                        </optgroup>

                                        <!-- Amérique du Nord -->
                                        <optgroup label="🌎 Amérique du Nord">
                                            <option value="+1" data-country="us">🇺🇸 États-Unis (+1)</option>
                                            <option value="+1" data-country="ca">🇨🇦 Canada (+1)</option>
                                        </optgroup>

                                        <!-- Asie -->
                                        <optgroup label="🌏 Asie">
                                            <option value="+86" data-country="cn">🇨🇳 Chine (+86)</option>
                                            <option value="+91" data-country="in">🇮🇳 Inde (+91)</option>
                                            <option value="+81" data-country="jp">🇯🇵 Japon (+81)</option>
                                            <option value="+971" data-country="ae">🇦🇪 Émirats Arabes Unis (+971)</option>
                                            <option value="+966" data-country="sa">🇸🇦 Arabie Saoudite (+966)</option>
                                        </optgroup>
                                </select>
                                <input type="tel" id="telephone" name="telephone" class="form-input" placeholder="XX XX XX XX XX" pattern="[0-9\s]{8,15}">
                            </div>
                            <!-- WhatsApp obligatoire pour tous les numéros -->
                            <input type="hidden" id="telephone_whatsapp" name="telephone_whatsapp" value="1">
                            <small style="color: var(--text-muted); display: block; margin-top: 8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>
                                Ce numéro sera automatiquement considéré comme WhatsApp
                            </small>
                        </div>
                    </div>

                    <div class="form-grid full">
                        <div class="form-group">
                            <label for="adresse" class="form-label">Adresse Complète</label>
                            <textarea id="adresse" name="adresse" class="form-textarea" rows="3" placeholder="Adresse complète (rue, ville, quartier, commune)"></textarea>
                        </div>
                    </div>

                    <h3 style="font-size: 1.1rem; font-weight: 600; color: var(--primary); margin: 2rem 0 1.5rem; padding-bottom: 0.75rem; border-bottom: 2px solid var(--primary-light);">
                        🆔 Documents et Identification
                    </h3>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="numero_identification" class="form-label">N° d'Identification</label>
                            <input type="text" id="numero_identification" name="numero_identification" class="form-input" placeholder="CNI, Passeport, Carte de séjour, etc.">
                            <small style="color: var(--text-muted); display: block; margin-top: 6px;">
                                💳 Carte d'identité, passeport ou autre document officiel
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Poste & Contrat -->
                <div class="step-content" data-step="3">
                    <div class="step-content-header">
                        <h3 class="step-content-title">💼 Poste et Contrat</h3>
                    </div>

                    <h3 style="font-size: 1.1rem; font-weight: 600; color: var(--primary); margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 2px solid var(--primary-light);">
                        🏢 Informations Professionnelles
                    </h3>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="poste" class="form-label">Poste</label>
                            <input type="text" id="poste" name="poste" class="form-input" placeholder="Ex: Développeur Web, Comptable, Chef de projet...">
                            <small style="color: var(--text-muted); display: block; margin-top: 6px;">
                                💼 Fonction occupée dans l'entreprise
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="date_embauche" class="form-label">Date d'Embauche</label>
                            <input type="date" id="date_embauche" name="date_embauche" class="form-input">
                            <small class="date-info">
                                💼 Date de début du contrat de travail
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="departement_id" class="form-label">Département</label>
                            <select id="departement_id" name="departement_id" class="form-select" onchange="loadServices(this.value)">
                                <option value="">Sélectionner un département</option>
                                @foreach($departements as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="service_id" class="form-label">Service</label>
                            <select id="service_id" name="service_id" class="form-select" disabled>
                                <option value="">Sélectionner d'abord un département</option>
                            </select>
                        </div>
                    </div>

                    <h3 style="font-size: 1.1rem; font-weight: 600; color: var(--primary); margin: 2rem 0 1.5rem; padding-bottom: 0.75rem; border-bottom: 2px solid var(--primary-light);">
                        📋 Type de Contrat
                    </h3>

                    <div class="form-grid full">
                        <div class="form-group">
                            <label class="form-label required">Choisir le type de contrat</label>
                            <div class="checkbox-group" style="display: flex; flex-direction: column; gap: 16px; align-items: stretch;">
                                <label class="checkbox-wrapper" style="width: 100%; padding: 16px; background: var(--bg-primary); border: 2px solid var(--card-border); border-radius: 12px; cursor: pointer; transition: all 0.3s ease;">
                                    <input type="radio" name="type_contrat" value="CDI" class="checkbox-input" checked onchange="toggleDateFinContrat()">
                                    <span class="checkbox-label" style="font-weight: 600;">
                                        ✓ CDI (Contrat à Durée Indéterminée)
                                    </span>
                                    <small style="display: block; color: var(--text-muted); margin-top: 4px; margin-left: 28px;">
                                        Contrat permanent sans date de fin
                                    </small>
                                </label>
                                <label class="checkbox-wrapper" style="width: 100%; padding: 16px; background: var(--bg-primary); border: 2px solid var(--card-border); border-radius: 12px; cursor: pointer; transition: all 0.3s ease;">
                                    <input type="radio" name="type_contrat" value="CDD" class="checkbox-input" onchange="toggleDateFinContrat()">
                                    <span class="checkbox-label" style="font-weight: 600;">
                                        ⏱ CDD (Contrat à Durée Déterminée)
                                    </span>
                                    <small style="display: block; color: var(--text-muted); margin-top: 4px; margin-left: 28px;">
                                        Contrat temporaire avec date de fin définie
                                    </small>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-grid hidden" id="dateFinContratGroup">
                        <div class="form-group">
                            <label for="date_fin_contrat" class="form-label required">Date de Fin de Contrat (CDD)</label>
                            <input type="date" id="date_fin_contrat" name="date_fin_contrat" class="form-input">
                            <div class="form-error" id="errorDateFinContrat"></div>
                            <small class="date-info">
                                ⏳ Obligatoire pour un CDD - La date doit être postérieure à la date d'embauche
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <!-- Boutons de gauche: Précédent + Annuler -->
                <div class="btn-group left">
                    <button type="button" class="btn btn-secondary" id="btnPrevStep" onclick="prevStep()" style="display: none;">
                        Précédent
                    </button>
                    <button type="button" class="btn btn-outline" onclick="closeModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="opacity: 0.6;">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                        Annuler
                    </button>
                </div>

                <!-- Centre: Indicateurs de raccourcis clavier -->
                <div class="keyboard-hints-footer"></div>

                <!-- Boutons de droite: Suivant/Soumettre -->
                <div class="btn-group right">
                    <button type="button" class="btn btn-primary" id="btnNextStep" onclick="nextStep()">
                        Suivant
                    </button>
                    <button type="submit" class="btn btn-primary" id="btnSubmit" style="display: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 4px;">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        Enregistrer le Personnel
                    </button>
                </div>
            </div>
        </form>
    </div>
</div> --}}

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
    document.getElementById('personnelForm').reset();
    currentStep = 1;
    updateStepDisplay();
}

// Next step
function nextStep() {
    if (validateStep(currentStep)) {
        currentStep++;
        updateStepDisplay();
    }
}

// Previous step
function prevStep() {
    currentStep--;
    updateStepDisplay();
}

// Go to specific step (with validation)
function goToStep(targetStep) {
    // Ne permet pas d'aller à une étape future sans validation
    if (targetStep > currentStep) {
        // Valider toutes les étapes entre current et target
        for (let i = currentStep; i < targetStep; i++) {
            if (!validateStep(i)) {
                return; // Bloque si validation échoue
            }
        }
    }

    currentStep = targetStep;
    updateStepDisplay();
}

// Update step display - Enhanced avec feedback visuel amélioré
function updateStepDisplay() {
    const stepIndicator = document.getElementById('stepIndicator');

    // Update progress bar
    stepIndicator.classList.remove('progress-33', 'progress-66', 'progress-100');
    if (currentStep === 1) {
        stepIndicator.classList.add('progress-33');
    } else if (currentStep === 2) {
        stepIndicator.classList.add('progress-66');
    } else if (currentStep === 3) {
        stepIndicator.classList.add('progress-100');
    }

    // Update step indicator
    document.querySelectorAll('.step').forEach((step, index) => {
        const stepNum = index + 1;
        step.classList.remove('active', 'completed');

        if (stepNum < currentStep) {
            step.classList.add('completed');
            step.querySelector('.step-circle').innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>';
        } else if (stepNum === currentStep) {
            step.classList.add('active');
            step.querySelector('.step-circle').innerHTML = stepNum;
        } else {
            step.querySelector('.step-circle').innerHTML = stepNum;
        }
    });

    // Update step content with animation
    const allSteps = document.querySelectorAll('.step-content');
    console.log(`📋 Total step-content elements found: ${allSteps.length}`);

    allSteps.forEach((content) => {
        content.classList.remove('active');
        const stepNum = parseInt(content.getAttribute('data-step'));
        console.log(`🔍 Checking step ${stepNum}, current: ${currentStep}`, content);
        if (stepNum === currentStep) {
            console.log(`✅ Activating step ${currentStep}`, content);
            setTimeout(() => {
                content.classList.add('active');
                const isActive = content.classList.contains('active');
                const display = window.getComputedStyle(content).display;
                console.log(`📊 Step ${currentStep} - Active class: ${isActive}, Display: ${display}`);

                // Force display for debugging
                if (stepNum === 3) {
                    console.log('🔧 Step 3 HTML:', content.innerHTML.substring(0, 200));
                }
            }, 50);
        }
    });

    // Update buttons avec animations
    const btnPrev = document.getElementById('btnPrevStep');
    const btnNext = document.getElementById('btnNextStep');
    const btnSubmit = document.getElementById('btnSubmit');

    // Bouton Précédent
    if (currentStep === 1) {
        btnPrev.style.display = 'none';
    } else {
        btnPrev.style.display = 'inline-flex';
        btnPrev.style.animation = 'slideInButton 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)';
    }

    // Boutons Suivant/Soumettre
    if (currentStep === totalSteps) {
        btnNext.style.display = 'none';
        btnSubmit.style.display = 'inline-flex';
        btnSubmit.style.animation = 'slideInButton 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)';

        // Mise à jour du texte du bouton en fonction de l'étape finale
        btnSubmit.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 4px;">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
            Enregistrer le Personnel
        `;
    } else {
        btnNext.style.display = 'inline-flex';
        btnNext.style.animation = 'slideInButton 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)';
        btnSubmit.style.display = 'none';
    }
}

// Validate step
function validateStep(step) {
    let isValid = true;
    const stepContent = document.querySelector(`.step-content[data-step="${step}"]`);
    const requiredInputs = stepContent.querySelectorAll('[required]');

    requiredInputs.forEach(input => {
        const value = input.type === 'checkbox' || input.type === 'radio'
            ? (input.type === 'radio' ? document.querySelector(`input[name="${input.name}"]:checked`) : input.checked)
            : input.value.trim();

        if (!value) {
            isValid = false;
            input.classList.add('error');

            // Show error message
            const errorId = `error${input.id.charAt(0).toUpperCase() + input.id.slice(1)}`;
            const errorElement = document.getElementById(errorId);
            if (errorElement) {
                errorElement.textContent = 'Ce champ est requis';
                errorElement.classList.add('show');
            }
        } else {
            input.classList.remove('error');

            // Hide error message
            const errorId = `error${input.id.charAt(0).toUpperCase() + input.id.slice(1)}`;
            const errorElement = document.getElementById(errorId);
            if (errorElement) {
                errorElement.classList.remove('show');
            }
        }
    });

    // Special validation for type_contrat
    if (step === 3) {
        const typeContrat = document.querySelector('input[name="type_contrat"]:checked');
        if (!typeContrat) {
            isValid = false;
            showNotification('Veuillez sélectionner un type de contrat', 'error');
        }
    }

    return isValid;
}

// Add real-time validation
function addRealTimeValidation() {
    const inputs = document.querySelectorAll('.form-input[required], .form-select[required]');

    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (!this.value.trim()) {
                this.classList.add('error');
            } else {
                this.classList.remove('error');
            }
        });

        input.addEventListener('input', function() {
            if (this.value.trim()) {
                this.classList.remove('error');
                const errorId = `error${this.id.charAt(0).toUpperCase() + this.id.slice(1)}`;
                const errorElement = document.getElementById(errorId);
                if (errorElement) {
                    errorElement.classList.remove('show');
                }
            }
        });
    });
}

// Gestion du drapeau pays avec images SVG
function initCountryFlagSelector() {
    const countrySelect = document.getElementById('telephone_code_pays');
    const flagImg = document.getElementById('selectedCountryFlag');

    if (countrySelect && flagImg) {
        countrySelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const countryCode = selectedOption.getAttribute('data-country');

            if (countryCode) {
                // Mettre à jour l'image du drapeau avec FlagCDN
                flagImg.src = `https://flagcdn.com/w40/${countryCode}.png`;
                flagImg.srcset = `https://flagcdn.com/w80/${countryCode}.png 2x`;
                flagImg.alt = countryCode.toUpperCase();
            }
        });
    }
}

// Initialize real-time validation
document.addEventListener('DOMContentLoaded', () => {
    addRealTimeValidation();
    animateStats();
    initCountryFlagSelector();
    initKeyboardNavigation();
});

// Navigation au clavier - Optimisation UX
function initKeyboardNavigation() {
    document.addEventListener('keydown', function(e) {
        const modal = document.getElementById('modalAddPersonnel');
        const isModalVisible = modal && modal.classList.contains('show');

        if (!isModalVisible) return;

        // Échap pour fermer la modal
        if (e.key === 'Escape') {
            e.preventDefault();
            closeModal();
            return;
        }

        // Empêcher la navigation si un input est focus
        const activeElement = document.activeElement;
        const isInputFocused = activeElement.tagName === 'INPUT' ||
                              activeElement.tagName === 'TEXTAREA' ||
                              activeElement.tagName === 'SELECT';

        if (isInputFocused) return;

        // Navigation entre les étapes
        if (e.key === 'ArrowRight' || (e.ctrlKey && e.key === 'Enter')) {
            e.preventDefault();
            if (currentStep < totalSteps) {
                nextStep();
            } else {
                // Sur la dernière étape, soumettre le formulaire
                document.getElementById('btnSubmit').click();
            }
        }

        if (e.key === 'ArrowLeft') {
            e.preventDefault();
            if (currentStep > 1) {
                prevStep();
            }
        }

        // Sauter à une étape spécifique (1, 2, 3)
        if (['1', '2', '3'].includes(e.key)) {
            e.preventDefault();
            const targetStep = parseInt(e.key);
            if (targetStep <= totalSteps) {
                goToStep(targetStep);
            }
        }
    });

    // Ajouter des tooltips visuels pour les raccourcis
    addKeyboardHints();
}

// Ajouter des indicateurs visuels pour les raccourcis clavier
function addKeyboardHints() {
    const hintsContainer = document.querySelector('#modalAddPersonnel .keyboard-hints-footer');
    if (!hintsContainer) return;

    // Créer un élément d'aide pour les raccourcis
    hintsContainer.innerHTML = `
        <small style="opacity: 0.7; font-size: 0.75rem; color: var(--text-muted); display: inline-block; line-height: 1.6;">
            <kbd>Échap</kbd> Fermer ·
            <kbd>←</kbd> Précédent ·
            <kbd>→</kbd> Suivant ·
            <kbd>1-3</kbd> Étape
        </small>
    `;
}

// Style pour les touches kbd
const kbdStyle = document.createElement('style');
kbdStyle.textContent = `
    .keyboard-hints kbd {
        display: inline-block;
        padding: 2px 6px;
        font-size: 0.7rem;
        font-family: 'Courier New', monospace;
        background: linear-gradient(180deg, #f8f9fa 0%, #e9ecef 100%);
        border: 1px solid #cbd5e0;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1), inset 0 -2px 0 rgba(0, 0, 0, 0.1);
        margin: 0 2px;
        font-weight: 600;
        color: #374151;
    }

    .dark .keyboard-hints kbd {
        background: linear-gradient(180deg, #374151 0%, #1f2937 100%);
        border-color: #4b5563;
        color: #e5e7eb;
    }
`;
document.head.appendChild(kbdStyle);

// Animate statistics counters
function animateStats() {
    const statValues = document.querySelectorAll('.stat-value[data-count]');

    statValues.forEach(stat => {
        const target = parseInt(stat.getAttribute('data-count'));
        const duration = 1500; // 1.5 seconds
        const increment = target / (duration / 16); // 60 FPS
        let current = 0;

        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                stat.textContent = target;
                clearInterval(timer);
            } else {
                stat.textContent = Math.floor(current);
            }
        }, 16);
    });
}

// Toggle date fin contrat visibility
function toggleDateFinContrat() {
    const typeContrat = document.querySelector('input[name="type_contrat"]:checked').value;
    const dateFinGroup = document.getElementById('dateFinContratGroup');

    if (typeContrat === 'CDD') {
        dateFinGroup.classList.remove('hidden');
        document.getElementById('date_fin_contrat').required = true;
    } else {
        dateFinGroup.classList.add('hidden');
        document.getElementById('date_fin_contrat').required = false;
    }
}

// Load services by department (OLD - for edit modal)
async function loadServicesOld(departementId) {
    const serviceSelect = document.getElementById('service_id');

    if (!departementId) {
        serviceSelect.disabled = true;
        serviceSelect.innerHTML = '<option value="">Sélectionner d\'abord un département</option>';
        return;
    }

    // Show loading state
    serviceSelect.disabled = true;
    serviceSelect.innerHTML = '<option value="">Chargement...</option>';

    try {
        const response = await fetch(`/personnels/services/${departementId}`);
        const data = await response.json();

        if (data.success && data.data) {
            serviceSelect.disabled = false;
            serviceSelect.innerHTML = '<option value="">Sélectionner un service (optionnel)</option>';

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
    submitBtn.innerHTML = '<svg class="animate-spin" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"></path></svg> Enregistrement...';

    try {
        const response = await fetch('{{ route("admin.personnels.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            },
            body: formData
        });

        const data = await response.json();

        if (response.ok && data.success) {
            showNotification('Personnel enregistré avec succès!', 'success');
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
                ${type === 'success' ? '✓' : type === 'error' ? '✕' : 'ℹ'}
            </div>
            <div class="notification-message">${message.replace(/\n/g, '<br>')}</div>
        </div>
        <button class="notification-close" onclick="this.parentElement.remove()">×</button>
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
    if (!confirm('Êtes-vous sûr de vouloir supprimer ce personnel?')) {
        return;
    }

    try {
        const response = await fetch(`/personnels/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            alert('Personnel supprimé avec succès!');
            window.location.reload();
        } else {
            alert('Erreur: ' + (data.message || 'Une erreur est survenue'));
        }
    } catch (error) {
        console.error('Erreur:', error);
        alert('Erreur lors de la suppression');
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
    console.log('🚀 Initializing personnel form...');
    updateStepDisplay();
    console.log('✅ Personnel form initialized - Step 1 active');
});
</script>
@endsection
