@extends('layouts.app')

@section('title', 'Dossiers Agents')

@section('styles')
<style>
/* ========================================
   VARIABLES - Light & Dark Mode (RH+ Brand)
   ======================================== */
:root {
    /* RH+ Brand Colors */
    --da-primary: #4A90D9;
    --da-primary-dark: #2E6BB3;
    --da-primary-light: #5BA3E8;
    --da-secondary: #F5A623;
    --da-success: #27AE60;
    --da-danger: #ef4444;
    --da-warning: #E67E22;
    --da-info: #4A90D9;

    /* Light Mode Theme */
    --da-bg: #f8fafc;
    --da-bg-secondary: #f1f5f9;
    --da-card-bg: #ffffff;
    --da-card-border: #e2e8f0;
    --da-text-primary: #1e293b;
    --da-text-secondary: #64748b;
    --da-text-muted: #94a3b8;
    --da-shadow: rgba(0, 0, 0, 0.04);
    --da-shadow-lg: rgba(0, 0, 0, 0.08);
    --da-hover-bg: rgba(74, 144, 217, 0.05);
    --da-input-bg: #f8fafc;
    --da-input-border: #e2e8f0;
    --da-divider: #e2e8f0;
}

/* Dark Mode Colors */
.dark {
    --da-bg: #0f172a;
    --da-bg-secondary: #1e293b;
    --da-card-bg: #1e293b;
    --da-card-border: #334155;
    --da-text-primary: #f1f5f9;
    --da-text-secondary: #94a3b8;
    --da-text-muted: #64748b;
    --da-shadow: rgba(0, 0, 0, 0.3);
    --da-shadow-lg: rgba(0, 0, 0, 0.5);
    --da-hover-bg: rgba(74, 144, 217, 0.15);
    --da-input-bg: #0f172a;
    --da-input-border: #334155;
    --da-divider: #334155;
}

/* ========================================
   BASE STYLES
   ======================================== */
.dossier-agent-page {
    padding: 1.5rem;
    min-height: 100vh;
    background: var(--da-bg);
    transition: background-color 0.3s ease;
}

/* ========================================
   HEADER
   ======================================== */
.da-header {
    background: var(--da-card-bg);
    border-radius: 24px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 20px var(--da-shadow);
    position: relative;
    overflow: hidden;
    border: 1px solid var(--da-card-border);
    transition: all 0.3s ease;
}

.da-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--da-primary), var(--da-secondary), var(--da-info));
}

.da-header-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.da-header-title {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.da-header-icon {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, var(--da-primary) 0%, var(--da-primary-dark) 100%);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    box-shadow: 0 8px 20px rgba(74, 144, 217, 0.3);
}

.da-header-text h1 {
    margin: 0 0 0.25rem 0;
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--da-text-primary);
}

.da-header-text p {
    margin: 0;
    color: var(--da-text-secondary);
    font-size: 0.938rem;
}

.da-header-actions {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

/* ========================================
   BUTTONS
   ======================================== */
.btn-action {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.875rem;
    text-decoration: none;
    transition: all 0.2s;
    border: none;
    cursor: pointer;
}

.btn-action-primary {
    background: linear-gradient(135deg, var(--da-primary), var(--da-primary-dark));
    color: white;
    box-shadow: 0 4px 15px rgba(74, 144, 217, 0.3);
}

.btn-action-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(74, 144, 217, 0.4);
    color: white;
}

.btn-action-secondary {
    background: var(--da-card-bg);
    color: var(--da-text-primary);
    border: 2px solid var(--da-card-border);
}

.btn-action-secondary:hover {
    border-color: var(--da-primary);
    color: var(--da-primary);
    background: var(--da-hover-bg);
}

.btn-action-warning {
    background: rgba(245, 158, 11, 0.15);
    color: var(--da-warning);
    border: 2px solid rgba(245, 158, 11, 0.3);
}

.dark .btn-action-warning {
    background: rgba(245, 158, 11, 0.2);
}

.btn-action-warning:hover {
    background: rgba(245, 158, 11, 0.25);
}

/* ========================================
   STATS GRID
   ======================================== */
.da-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.da-stat-item {
    background: var(--da-bg-secondary);
    border-radius: 16px;
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.2s;
    border: 1px solid transparent;
}

.da-stat-item:hover {
    border-color: var(--da-primary);
    background: var(--da-card-bg);
}

.da-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.da-stat-icon.primary {
    background: rgba(74, 144, 217, 0.15);
    color: var(--da-primary);
}

.da-stat-icon.success {
    background: rgba(39, 174, 96, 0.15);
    color: var(--da-success);
}

.da-stat-icon.danger {
    background: rgba(239, 68, 68, 0.15);
    color: var(--da-danger);
}

.da-stat-icon.warning {
    background: rgba(230, 126, 34, 0.15);
    color: var(--da-warning);
}

.da-stat-content {
    flex: 1;
}

.da-stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--da-text-primary);
    line-height: 1;
}

.da-stat-label {
    font-size: 0.813rem;
    color: var(--da-text-secondary);
    margin-top: 0.25rem;
}

/* ========================================
   ALERTS SECTION
   ======================================== */
.da-alerts-section {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.da-alert-banner {
    background: var(--da-card-bg);
    border-radius: 16px;
    padding: 1.25rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 4px 15px var(--da-shadow);
    position: relative;
    overflow: hidden;
    border: 1px solid var(--da-card-border);
}

.da-alert-banner::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
}

.da-alert-banner.danger::before {
    background: linear-gradient(180deg, var(--da-danger), #dc2626);
}

.da-alert-banner.warning::before {
    background: linear-gradient(180deg, var(--da-warning), #d97706);
}

.da-alert-banner .alert-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.da-alert-banner.danger .alert-icon {
    background: rgba(239, 68, 68, 0.15);
    color: var(--da-danger);
}

.da-alert-banner.warning .alert-icon {
    background: rgba(230, 126, 34, 0.15);
    color: var(--da-warning);
}

.da-alert-banner .alert-content {
    flex: 1;
}

.da-alert-banner .alert-title {
    font-weight: 600;
    color: var(--da-text-primary);
    margin: 0 0 0.125rem 0;
    font-size: 0.938rem;
}

.da-alert-banner .alert-text {
    font-size: 0.813rem;
    color: var(--da-text-secondary);
    margin: 0;
}

.da-alert-banner .alert-count {
    font-size: 1.75rem;
    font-weight: 700;
    padding: 0 1rem;
}

.da-alert-banner.danger .alert-count { color: var(--da-danger); }
.da-alert-banner.warning .alert-count { color: var(--da-warning); }

.da-alert-banner .alert-action {
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.813rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
}

.da-alert-banner.danger .alert-action {
    background: rgba(239, 68, 68, 0.15);
    color: var(--da-danger);
}

.da-alert-banner.warning .alert-action {
    background: rgba(230, 126, 34, 0.15);
    color: var(--da-warning);
}

.dark .da-alert-banner.warning .alert-action {
    color: var(--da-warning);
}

.da-alert-banner .alert-action:hover {
    transform: translateX(4px);
}

/* ========================================
   SEARCH SECTION
   ======================================== */
.da-search-section {
    background: var(--da-card-bg);
    border-radius: 16px;
    padding: 1.25rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 15px var(--da-shadow);
    border: 1px solid var(--da-card-border);
}

.da-search-form {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    align-items: center;
}

.da-search-input-wrapper {
    flex: 1;
    min-width: 280px;
    position: relative;
}

.da-search-input-wrapper svg {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--da-text-muted);
    pointer-events: none;
}

.da-search-input {
    width: 100%;
    padding: 0.875rem 1rem 0.875rem 3rem;
    border: 2px solid var(--da-input-border);
    border-radius: 12px;
    font-size: 0.938rem;
    transition: all 0.2s;
    background: var(--da-input-bg);
    color: var(--da-text-primary);
}

.da-search-input:focus {
    outline: none;
    border-color: var(--da-primary);
    background: var(--da-card-bg);
    box-shadow: 0 0 0 4px rgba(74, 144, 217, 0.15);
}

.da-search-input::placeholder {
    color: var(--da-text-muted);
}

.da-filter-dropdown {
    padding: 0.875rem 1rem;
    border: 2px solid var(--da-input-border);
    border-radius: 12px;
    font-size: 0.938rem;
    background: var(--da-card-bg);
    color: var(--da-text-primary);
    min-width: 200px;
    cursor: pointer;
    transition: all 0.2s;
}

.da-filter-dropdown:focus {
    outline: none;
    border-color: var(--da-primary);
}

.da-filter-dropdown option {
    background: var(--da-card-bg);
    color: var(--da-text-primary);
}

.btn-search {
    padding: 0.875rem 1.5rem;
    background: var(--da-primary);
    color: white;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
}

.btn-search:hover {
    background: var(--da-primary-dark);
}

.btn-reset {
    padding: 0.875rem 1rem;
    background: var(--da-bg-secondary);
    color: var(--da-text-secondary);
    border: 2px solid var(--da-card-border);
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    display: flex;
    align-items: center;
}

.btn-reset:hover {
    border-color: var(--da-danger);
    color: var(--da-danger);
}

/* ========================================
   EMPLOYEES SECTION
   ======================================== */
.da-employees-section {
    margin-bottom: 2rem;
}

.da-section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.25rem;
}

.da-section-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--da-text-primary);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.da-section-title .count-badge {
    background: var(--da-primary);
    color: white;
    font-size: 0.75rem;
    padding: 0.25rem 0.625rem;
    border-radius: 20px;
    font-weight: 600;
}

.da-employees-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    gap: 1.25rem;
}

/* ========================================
   EMPLOYEE CARD
   ======================================== */
.da-employee-card {
    background: var(--da-card-bg);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 15px var(--da-shadow);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 2px solid transparent;
}

.da-employee-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 40px var(--da-shadow-lg);
    border-color: var(--da-primary);
}

.da-employee-card-header {
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    background: var(--da-bg-secondary);
    border-bottom: 1px solid var(--da-divider);
}

.da-employee-avatar {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    background: linear-gradient(135deg, var(--da-primary) 0%, var(--da-primary-dark) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.375rem;
    font-weight: 700;
    flex-shrink: 0;
    position: relative;
    box-shadow: 0 4px 12px rgba(74, 144, 217, 0.3);
}

.da-employee-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 16px;
}

.da-employee-avatar .status-dot {
    position: absolute;
    bottom: -2px;
    right: -2px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 3px solid var(--da-card-bg);
}

.da-employee-avatar .status-dot.active {
    background: var(--da-success);
}

.da-employee-avatar .status-dot.warning {
    background: var(--da-warning);
}

.da-employee-avatar .status-dot.danger {
    background: var(--da-danger);
}

.da-employee-info {
    flex: 1;
    min-width: 0;
}

.da-employee-name {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--da-text-primary);
    margin: 0 0 0.375rem 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.da-employee-details {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    align-items: center;
}

.da-employee-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    background: var(--da-bg);
    color: var(--da-text-secondary);
}

.da-employee-badge svg {
    width: 12px;
    height: 12px;
}

.da-employee-badge.dept {
    background: rgba(74, 144, 217, 0.15);
    color: var(--da-primary-light);
}

.dark .da-employee-badge.dept {
    color: var(--da-primary-light);
}

.da-employee-card-body {
    padding: 1.25rem 1.5rem;
}

/* ========================================
   DOCUMENT STATS
   ======================================== */
.da-doc-stats {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1.25rem;
}

.da-doc-stat {
    flex: 1;
    text-align: center;
    padding: 0.875rem 0.5rem;
    border-radius: 12px;
    background: var(--da-bg-secondary);
    transition: all 0.2s;
}

.da-doc-stat:hover {
    transform: translateY(-2px);
}

.da-doc-stat.total {
    background: rgba(74, 144, 217, 0.12);
}

.da-doc-stat.valid {
    background: rgba(39, 174, 96, 0.12);
}

.da-doc-stat.expired {
    background: rgba(239, 68, 68, 0.12);
}

.da-doc-stat-value {
    font-size: 1.375rem;
    font-weight: 700;
    line-height: 1;
}

.da-doc-stat.total .da-doc-stat-value { color: var(--da-primary); }
.da-doc-stat.valid .da-doc-stat-value { color: var(--da-success); }
.da-doc-stat.expired .da-doc-stat-value { color: var(--da-danger); }

.da-doc-stat-label {
    font-size: 0.688rem;
    color: var(--da-text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 0.375rem;
}

/* ========================================
   PROGRESS BAR
   ======================================== */
.da-progress-bar {
    height: 6px;
    background: var(--da-divider);
    border-radius: 3px;
    overflow: hidden;
    margin-bottom: 1.25rem;
}

.da-progress-fill {
    height: 100%;
    border-radius: 3px;
    transition: width 0.3s ease;
}

.da-progress-fill.good {
    background: linear-gradient(90deg, var(--da-success), #34d399);
}

.da-progress-fill.warning {
    background: linear-gradient(90deg, var(--da-warning), #fbbf24);
}

.da-progress-fill.danger {
    background: linear-gradient(90deg, var(--da-danger), #f87171);
}

/* ========================================
   EMPLOYEE ACTIONS
   ======================================== */
.da-employee-actions {
    display: flex;
    gap: 0.625rem;
}

.btn-view-folder {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.875rem 1rem;
    background: linear-gradient(135deg, var(--da-primary) 0%, var(--da-primary-dark) 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.875rem;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 4px 12px rgba(74, 144, 217, 0.25);
}

.btn-view-folder:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(74, 144, 217, 0.35);
    color: white;
}

.btn-quick-action {
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-quick-action.upload {
    background: rgba(39, 174, 96, 0.15);
    color: var(--da-success);
}

.btn-quick-action.upload:hover {
    background: var(--da-success);
    color: white;
}

/* ========================================
   EMPTY STATE
   ======================================== */
.da-empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: var(--da-card-bg);
    border-radius: 24px;
    border: 2px dashed var(--da-card-border);
}

.da-empty-illustration {
    width: 120px;
    height: 120px;
    margin: 0 auto 2rem;
    background: linear-gradient(135deg, var(--da-primary) 0%, var(--da-primary-dark) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0.15;
}

.da-empty-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--da-text-primary);
    margin: 0 0 0.5rem 0;
}

.da-empty-text {
    color: var(--da-text-secondary);
    margin: 0 0 2rem 0;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}

/* ========================================
   PAGINATION
   ======================================== */
.da-pagination {
    margin-top: 2rem;
    display: flex;
    justify-content: center;
}

.da-pagination nav {
    display: flex;
    gap: 0.5rem;
}

/* ========================================
   MODAL
   ======================================== */
.da-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.7);
    backdrop-filter: blur(4px);
    z-index: 10000;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}

.dark .da-modal-overlay {
    background: rgba(0, 0, 0, 0.8);
}

.da-modal-overlay.show {
    display: flex;
}

.da-modal {
    background: var(--da-card-bg);
    border-radius: 24px;
    width: 100%;
    max-width: 480px;
    max-height: 90vh;
    overflow: hidden;
    animation: modalSlideIn 0.3s ease;
    border: 1px solid var(--da-card-border);
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-20px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.da-modal-header {
    background: linear-gradient(135deg, var(--da-primary) 0%, var(--da-primary-dark) 100%);
    color: white;
    padding: 1.5rem;
    position: relative;
}

.da-modal-header h3 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 600;
}

.da-modal-header p {
    margin: 0.5rem 0 0 0;
    opacity: 0.9;
    font-size: 0.875rem;
}

.da-modal-close {
    position: absolute;
    right: 1rem;
    top: 1rem;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
    border: none;
    color: white;
    font-size: 1.5rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.da-modal-close:hover {
    background: rgba(255,255,255,0.3);
    transform: rotate(90deg);
}

.da-modal-body {
    padding: 1.5rem;
    max-height: 60vh;
    overflow-y: auto;
}

.da-form-group {
    margin-bottom: 1.25rem;
}

.da-form-label {
    display: block;
    font-weight: 600;
    color: var(--da-text-primary);
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.da-form-control {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid var(--da-input-border);
    border-radius: 12px;
    font-size: 0.938rem;
    transition: all 0.2s;
    background: var(--da-input-bg);
    color: var(--da-text-primary);
}

.da-form-control:focus {
    outline: none;
    border-color: var(--da-primary);
    box-shadow: 0 0 0 4px rgba(74, 144, 217, 0.15);
}

.da-form-control option {
    background: var(--da-card-bg);
    color: var(--da-text-primary);
}

.da-file-upload {
    border: 2px dashed var(--da-card-border);
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
    background: var(--da-bg-secondary);
}

.da-file-upload:hover {
    border-color: var(--da-primary);
    background: var(--da-hover-bg);
}

.da-file-upload input {
    display: none;
}

.da-file-upload-icon {
    width: 48px;
    height: 48px;
    margin: 0 auto 1rem;
    background: rgba(74, 144, 217, 0.15);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--da-primary);
}

.da-file-upload-text {
    color: var(--da-text-primary);
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.da-file-upload-hint {
    font-size: 0.813rem;
    color: var(--da-text-secondary);
}

.da-modal-footer {
    padding: 1rem 1.5rem;
    background: var(--da-bg-secondary);
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
    border-top: 1px solid var(--da-divider);
}

.btn-modal {
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.875rem;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-modal-cancel {
    background: var(--da-card-bg);
    color: var(--da-text-secondary);
    border: 2px solid var(--da-card-border);
}

.btn-modal-cancel:hover {
    border-color: var(--da-text-secondary);
}

.btn-modal-submit {
    background: linear-gradient(135deg, var(--da-primary), var(--da-primary-dark));
    color: white;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-modal-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(74, 144, 217, 0.3);
}

/* ========================================
   TOAST NOTIFICATIONS
   ======================================== */
.da-toast {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    padding: 1rem 1.5rem;
    background: var(--da-text-primary);
    color: var(--da-card-bg);
    border-radius: 12px;
    box-shadow: 0 10px 40px var(--da-shadow-lg);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    z-index: 10001;
    animation: toastSlideIn 0.3s ease;
}

@keyframes toastSlideIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
}

.da-toast.success {
    background: var(--da-success);
    color: white;
}

.da-toast.error {
    background: var(--da-danger);
    color: white;
}

/* ========================================
   SELECTED FILES
   ======================================== */
#selectedFiles {
    color: var(--da-success);
}

/* ========================================
   RESPONSIVE
   ======================================== */
@media (max-width: 768px) {
    .dossier-agent-page {
        padding: 1rem;
    }

    .da-header {
        padding: 1.5rem;
    }

    .da-header-top {
        flex-direction: column;
    }

    .da-header-actions {
        width: 100%;
    }

    .da-header-actions .btn-action {
        flex: 1;
        justify-content: center;
    }

    .da-stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .da-employees-grid {
        grid-template-columns: 1fr;
    }

    .da-search-form {
        flex-direction: column;
    }

    .da-search-input-wrapper,
    .da-filter-dropdown {
        width: 100%;
        min-width: auto;
    }

    .da-alert-banner {
        flex-wrap: wrap;
    }

    .da-alert-banner .alert-count {
        order: -1;
        width: 100%;
        text-align: left;
        padding: 0 0 0.5rem 0;
    }
}
</style>
@endsection

@section('content')
<div class="dossier-agent-page">
    <!-- Header -->
    <div class="da-header">
        <div class="da-header-top">
            <div class="da-header-title">
                <div class="da-header-icon">
                    <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                </div>
                <div class="da-header-text">
                    <h1>Dossiers Agents</h1>
                    <p>Gestion centralisée des documents de vos collaborateurs</p>
                </div>
            </div>
            <div class="da-header-actions">
                @can('manage-categories-dossiers')
                <a href="{{ route('admin.dossier-agent.categories') }}" class="btn-action btn-action-secondary">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                    Répertoires
                </a>
                @endcan
                @if($stats['documents_expires'] + $stats['documents_expirent_bientot'] > 0)
                <a href="{{ route('admin.dossier-agent.alertes') }}" class="btn-action btn-action-warning">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    {{ $stats['documents_expires'] + $stats['documents_expirent_bientot'] }} Alertes
                </a>
                @endif
            </div>
        </div>

        <!-- Stats -->
        <div class="da-stats-grid">
            <div class="da-stat-item">
                <div class="da-stat-icon primary">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div class="da-stat-content">
                    <div class="da-stat-value">{{ $stats['total_personnels'] }}</div>
                    <div class="da-stat-label">Employés</div>
                </div>
            </div>
            <div class="da-stat-item">
                <div class="da-stat-icon success">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="da-stat-content">
                    <div class="da-stat-value">{{ $stats['total_documents'] }}</div>
                    <div class="da-stat-label">Documents</div>
                </div>
            </div>
            <div class="da-stat-item">
                <div class="da-stat-icon danger">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="da-stat-content">
                    <div class="da-stat-value">{{ $stats['documents_expires'] }}</div>
                    <div class="da-stat-label">Expirés</div>
                </div>
            </div>
            <div class="da-stat-item">
                <div class="da-stat-icon warning">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="da-stat-content">
                    <div class="da-stat-value">{{ $stats['documents_expirent_bientot'] }}</div>
                    <div class="da-stat-label">Expirent bientôt</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertes -->
    @if($stats['documents_expires'] > 0 || $stats['documents_expirent_bientot'] > 0)
    <div class="da-alerts-section">
        @if($stats['documents_expires'] > 0)
        <div class="da-alert-banner danger">
            <div class="alert-icon">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="alert-content">
                <h4 class="alert-title">Documents expirés</h4>
                <p class="alert-text">Action requise immédiatement</p>
            </div>
            <div class="alert-count">{{ $stats['documents_expires'] }}</div>
            <a href="{{ route('admin.dossier-agent.alertes') }}?type=expires" class="alert-action">
                Voir les détails →
            </a>
        </div>
        @endif

        @if($stats['documents_expirent_bientot'] > 0)
        <div class="da-alert-banner warning">
            <div class="alert-icon">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="alert-content">
                <h4 class="alert-title">Expirent dans 30 jours</h4>
                <p class="alert-text">Prévoir le renouvellement</p>
            </div>
            <div class="alert-count">{{ $stats['documents_expirent_bientot'] }}</div>
            <a href="{{ route('admin.dossier-agent.alertes') }}?type=bientot" class="alert-action">
                Voir les détails →
            </a>
        </div>
        @endif
    </div>
    @endif

    <!-- Recherche et filtres -->
    <div class="da-search-section">
        <form action="{{ route('admin.dossier-agent.index') }}" method="GET" class="da-search-form">
            <div class="da-search-input-wrapper">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" class="da-search-input" placeholder="Rechercher par nom, prénom ou matricule..." value="{{ request('search') }}">
            </div>
            <select name="departement" class="da-filter-dropdown" onchange="this.form.submit()">
                <option value="">Tous les départements</option>
                @php
                    $entrepriseId = auth()->user()->entreprise_id;
                    if (!$entrepriseId) {
                        $entreprise = \App\Models\Entreprise::first();
                        $entrepriseId = $entreprise?->id;
                    }
                @endphp
                @if($entrepriseId)
                @foreach(\App\Models\Departement::where('entreprise_id', $entrepriseId)->orderBy('nom')->get() as $dept)
                <option value="{{ $dept->id }}" {{ request('departement') == $dept->id ? 'selected' : '' }}>{{ $dept->nom }}</option>
                @endforeach
                @endif
            </select>
            <button type="submit" class="btn-search">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filtrer
            </button>
            @if(request('search') || request('departement'))
            <a href="{{ route('admin.dossier-agent.index') }}" class="btn-reset" title="Réinitialiser">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </a>
            @endif
        </form>
    </div>

    <!-- Liste des employés -->
    @if($personnels->count() > 0)
    <div class="da-employees-section">
        <div class="da-section-header">
            <h2 class="da-section-title">
                Employés
                <span class="count-badge">{{ $personnels->total() }}</span>
            </h2>
        </div>

        <div class="da-employees-grid">
            @foreach($personnels as $personnel)
            @php
                $totalDocs = $personnel->documents_count;
                $activeDocs = $personnel->documents()->actifs()->count();
                $expiredDocs = $personnel->documents()->expires()->count();
                $validPercent = $totalDocs > 0 ? round($activeDocs / $totalDocs * 100) : 100;
                $statusClass = $expiredDocs > 0 ? 'danger' : ($activeDocs < $totalDocs ? 'warning' : 'active');
                $progressClass = $validPercent >= 80 ? 'good' : ($validPercent >= 50 ? 'warning' : 'danger');
            @endphp
            <div class="da-employee-card">
                <div class="da-employee-card-header">
                    <div class="da-employee-avatar">
                        @if($personnel->photo)
                            <img src="{{ asset('storage/' . $personnel->photo) }}" alt="{{ $personnel->nom }}">
                        @else
                            {{ strtoupper(substr($personnel->nom, 0, 1) . substr($personnel->prenoms ?? '', 0, 1)) }}
                        @endif
                        <span class="status-dot {{ $statusClass }}"></span>
                    </div>
                    <div class="da-employee-info">
                        <h3 class="da-employee-name">{{ $personnel->nom }} {{ $personnel->prenoms }}</h3>
                        <div class="da-employee-details">
                            @if($personnel->matricule)
                            <span class="da-employee-badge">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                </svg>
                                {{ $personnel->matricule }}
                            </span>
                            @endif
                            @if($personnel->departement)
                            <span class="da-employee-badge dept">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                {{ $personnel->departement->nom }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="da-employee-card-body">
                    <div class="da-doc-stats">
                        <div class="da-doc-stat total">
                            <div class="da-doc-stat-value">{{ $totalDocs }}</div>
                            <div class="da-doc-stat-label">Total</div>
                        </div>
                        <div class="da-doc-stat valid">
                            <div class="da-doc-stat-value">{{ $activeDocs }}</div>
                            <div class="da-doc-stat-label">Valides</div>
                        </div>
                        <div class="da-doc-stat expired">
                            <div class="da-doc-stat-value">{{ $expiredDocs }}</div>
                            <div class="da-doc-stat-label">Expirés</div>
                        </div>
                    </div>

                    @if($totalDocs > 0)
                    <div class="da-progress-bar">
                        <div class="da-progress-fill {{ $progressClass }}" style="width: {{ $validPercent }}%"></div>
                    </div>
                    @endif

                    <div class="da-employee-actions">
                        <a href="{{ route('admin.dossier-agent.show', $personnel) }}" class="btn-view-folder">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"/>
                            </svg>
                            Ouvrir le dossier
                        </a>
                        <button type="button" class="btn-quick-action upload" onclick="openQuickUpload({{ $personnel->id }}, '{{ addslashes($personnel->nom . ' ' . $personnel->prenoms) }}')" title="Upload rapide">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="da-pagination">
            {{ $personnels->withQueryString()->links() }}
        </div>
    </div>
    @else
    <div class="da-empty-state">
        <div class="da-empty-illustration">
            <svg width="56" height="56" fill="white" viewBox="0 0 24 24">
                <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <h3 class="da-empty-title">Aucun employé trouvé</h3>
        <p class="da-empty-text">
            @if(request('search') || request('departement'))
                Aucun résultat ne correspond à vos critères de recherche. Essayez d'autres filtres.
            @else
                Commencez par ajouter des employés pour gérer leurs dossiers documentaires.
            @endif
        </p>
        @if(request('search') || request('departement'))
        <a href="{{ route('admin.dossier-agent.index') }}" class="btn-action btn-action-secondary">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Réinitialiser les filtres
        </a>
        @else
        <a href="{{ route('admin.personnels.index') }}" class="btn-action btn-action-primary">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
            Gérer les employés
        </a>
        @endif
    </div>
    @endif
</div>

<!-- Modal Upload Rapide -->
<div class="da-modal-overlay" id="quickUploadModal">
    <div class="da-modal">
        <div class="da-modal-header">
            <h3>Upload rapide</h3>
            <p id="modalEmployeeName">Ajouter des documents</p>
            <button class="da-modal-close" onclick="closeQuickUpload()">&times;</button>
        </div>
        <form id="quickUploadForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="personnel_id" id="quickUploadPersonnelId">
            <div class="da-modal-body">
                <div class="da-form-group">
                    <label class="da-form-label">Catégorie du document</label>
                    <select name="categorie_id" class="da-form-control">
                        <option value="">Sélectionner une catégorie...</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="da-form-group">
                    <label class="da-form-label">Document(s) à uploader</label>
                    <label class="da-file-upload" id="fileUploadLabel">
                        <input type="file" name="documents[]" id="fileInput" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.webp">
                        <div class="da-file-upload-icon">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                        </div>
                        <div class="da-file-upload-text">Cliquez ou glissez-déposez vos fichiers</div>
                        <div class="da-file-upload-hint">PDF, DOC, XLS, Images (max. 10 Mo par fichier)</div>
                    </label>
                    <div id="selectedFiles" style="margin-top: 0.75rem; font-size: 0.875rem;"></div>
                </div>
            </div>
            <div class="da-modal-footer">
                <button type="button" class="btn-modal btn-modal-cancel" onclick="closeQuickUpload()">Annuler</button>
                <button type="submit" class="btn-modal btn-modal-submit">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
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
const quickUploadModal = document.getElementById('quickUploadModal');
const quickUploadForm = document.getElementById('quickUploadForm');
const fileInput = document.getElementById('fileInput');
const selectedFilesDiv = document.getElementById('selectedFiles');

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
}

// Afficher les fichiers sélectionnés
fileInput.addEventListener('change', function() {
    const files = Array.from(this.files);
    if (files.length > 0) {
        selectedFilesDiv.innerHTML = files.map(f => `<div style="color: var(--da-success);">✓ ${f.name}</div>`).join('');
    } else {
        selectedFilesDiv.textContent = '';
    }
});

// Drag & Drop
const fileUploadLabel = document.getElementById('fileUploadLabel');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    fileUploadLabel.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    fileUploadLabel.addEventListener(eventName, () => {
        fileUploadLabel.style.borderColor = 'var(--da-primary)';
        fileUploadLabel.style.background = 'var(--da-hover-bg)';
    });
});

['dragleave', 'drop'].forEach(eventName => {
    fileUploadLabel.addEventListener(eventName, () => {
        fileUploadLabel.style.borderColor = '';
        fileUploadLabel.style.background = '';
    });
});

fileUploadLabel.addEventListener('drop', function(e) {
    const dt = e.dataTransfer;
    fileInput.files = dt.files;
    fileInput.dispatchEvent(new Event('change'));
});

// Submit
quickUploadForm.addEventListener('submit', async function(e) {
    e.preventDefault();

    const submitBtn = this.querySelector('.btn-modal-submit');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<svg class="animate-spin" width="18" height="18" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none" opacity="0.25"/><path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg> Upload...';
    submitBtn.disabled = true;

    const personnelId = document.getElementById('quickUploadPersonnelId').value;
    const formData = new FormData(this);

    try {
        const response = await fetch(`/dossier-agent/${personnelId}/upload-multiple`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
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

// Fermer modal
quickUploadModal.addEventListener('click', function(e) {
    if (e.target === this) closeQuickUpload();
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeQuickUpload();
});

// Toast notification
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `da-toast ${type}`;
    toast.innerHTML = `
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
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
</script>
@endsection
