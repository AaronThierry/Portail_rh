
@extends('layouts.app')

@section('title', 'Bulletins de Paie')
@section('page-title', 'Bulletins de Paie')
@section('page-subtitle', 'Gestion des fiches de paie du personnel')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
    <polyline points="14 2 14 8 20 8"></polyline>
    <line x1="16" y1="13" x2="8" y2="13"></line>
    <line x1="16" y1="17" x2="8" y2="17"></line>
    <polyline points="10 9 9 9 8 9"></polyline>
</svg>
@endsection

@section('styles')
<style>
/* ========================================
   VARIABLES - Charte RH+
   ======================================== */
:root {
    --bp-primary: #4A90D9;
    --bp-primary-dark: #2E6BB3;
    --bp-primary-light: #E8F4FD;
    --bp-accent: #FF9500;
    --bp-accent-light: #FFF7ED;
    --bp-success: #22C55E;
    --bp-success-light: #F0FDF4;
    --bp-danger: #EF4444;
    --bp-warning: #F59E0B;
    --bp-bg: #f8fafc;
    --bp-card-bg: #ffffff;
    --bp-card-border: #e2e8f0;
    --bp-text-primary: #1e293b;
    --bp-text-secondary: #64748b;
    --bp-text-muted: #94a3b8;
    --bp-shadow: rgba(0, 0, 0, 0.04);
    --bp-shadow-lg: rgba(0, 0, 0, 0.08);
}

.dark {
    --bp-bg: #0f172a;
    --bp-card-bg: #1e293b;
    --bp-card-border: #334155;
    --bp-text-primary: #f1f5f9;
    --bp-text-secondary: #94a3b8;
    --bp-text-muted: #64748b;
    --bp-shadow: rgba(0, 0, 0, 0.3);
    --bp-shadow-lg: rgba(0, 0, 0, 0.5);
    --bp-primary-light: rgba(74, 144, 217, 0.15);
    --bp-accent-light: rgba(255, 149, 0, 0.15);
    --bp-success-light: rgba(34, 197, 94, 0.15);
}

/* ========================================
   BASE
   ======================================== */
.bulletins-page {
    padding: 1.5rem;
    min-height: 100vh;
    background: var(--bp-bg);
}

/* ========================================
   HEADER AVEC STATS
   ======================================== */
.bp-header {
    background: var(--bp-card-bg);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 20px var(--bp-shadow);
    border: 1px solid var(--bp-card-border);
    position: relative;
    overflow: hidden;
}

.bp-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--bp-primary), var(--bp-accent));
}

.bp-header-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 1.5rem;
}

.bp-header-left h1 {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--bp-text-primary);
    margin: 0 0 0.5rem 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.bp-header-left h1 svg {
    width: 32px;
    height: 32px;
    color: var(--bp-primary);
}

.bp-header-left p {
    color: var(--bp-text-secondary);
    margin: 0;
}

.bp-header-actions {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

/* Stats Cards Row */
.bp-stats-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--bp-card-border);
}

.bp-stat-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: var(--bp-bg);
    border-radius: 12px;
    transition: all 0.2s ease;
}

.bp-stat-card:hover {
    transform: translateY(-2px);
}

.bp-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.bp-stat-icon svg {
    width: 24px;
    height: 24px;
}

.bp-stat-icon.blue { background: var(--bp-primary-light); color: var(--bp-primary); }
.bp-stat-icon.green { background: var(--bp-success-light); color: var(--bp-success); }
.bp-stat-icon.orange { background: var(--bp-accent-light); color: var(--bp-accent); }

.bp-stat-info h4 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--bp-text-primary);
    margin: 0;
    line-height: 1;
}

.bp-stat-info p {
    font-size: 0.8rem;
    color: var(--bp-text-secondary);
    margin: 0.25rem 0 0 0;
}

/* ========================================
   TIMELINE ANNÉE (NAVIGATION MOIS)
   ======================================== */
.bp-timeline-section {
    background: var(--bp-card-bg);
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 12px var(--bp-shadow);
    border: 1px solid var(--bp-card-border);
}

.bp-timeline-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.bp-timeline-header h3 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--bp-text-primary);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.bp-year-selector {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.bp-year-selector select {
    padding: 0.5rem 2rem 0.5rem 1rem;
    border: 1px solid var(--bp-card-border);
    border-radius: 8px;
    background: var(--bp-card-bg);
    color: var(--bp-text-primary);
    font-weight: 600;
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.5rem center;
}

.bp-timeline-grid {
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    gap: 0.5rem;
}

.bp-month-item {
    position: relative;
    padding: 0.75rem 0.5rem;
    text-align: center;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s ease;
    border: 2px solid transparent;
    background: var(--bp-bg);
}

.bp-month-item:hover {
    border-color: var(--bp-primary);
    background: var(--bp-primary-light);
}

.bp-month-item.active {
    border-color: var(--bp-primary);
    background: var(--bp-primary);
    color: white;
}

.bp-month-item.active .bp-month-name,
.bp-month-item.active .bp-month-count {
    color: white;
}

.bp-month-item.has-data {
    background: var(--bp-success-light);
}

.bp-month-item.has-data .bp-month-count {
    color: var(--bp-success);
    font-weight: 700;
}

.bp-month-item.future {
    opacity: 0.5;
    cursor: not-allowed;
}

.bp-month-name {
    font-size: 0.7rem;
    font-weight: 600;
    color: var(--bp-text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.bp-month-count {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--bp-text-primary);
    margin-top: 0.25rem;
}

/* ========================================
   FILTRES ET RECHERCHE
   ======================================== */
.bp-filters {
    background: var(--bp-card-bg);
    border-radius: 16px;
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 12px var(--bp-shadow);
    border: 1px solid var(--bp-card-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.bp-search-box {
    position: relative;
    flex: 1;
    max-width: 400px;
}

.bp-search-box input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.75rem;
    border: 1px solid var(--bp-card-border);
    border-radius: 10px;
    background: var(--bp-bg);
    color: var(--bp-text-primary);
    font-size: 0.9rem;
    transition: all 0.2s ease;
}

.bp-search-box input:focus {
    outline: none;
    border-color: var(--bp-primary);
    box-shadow: 0 0 0 3px var(--bp-primary-light);
}

.bp-search-box svg {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    width: 18px;
    height: 18px;
    color: var(--bp-text-muted);
}

.bp-filter-badges {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.bp-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: var(--bp-primary-light);
    color: var(--bp-primary);
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
}

.bp-badge .close {
    cursor: pointer;
    opacity: 0.7;
    transition: opacity 0.2s;
}

.bp-badge .close:hover {
    opacity: 1;
}

/* ========================================
   LISTE DES BULLETINS
   ======================================== */
.bp-list-section {
    background: var(--bp-card-bg);
    border-radius: 16px;
    box-shadow: 0 2px 12px var(--bp-shadow);
    border: 1px solid var(--bp-card-border);
    overflow: hidden;
}

.bp-list-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--bp-card-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.bp-list-header h3 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--bp-text-primary);
    margin: 0;
}

.bp-list-count {
    font-size: 0.85rem;
    color: var(--bp-text-secondary);
}

/* Bulletin Item */
.bp-item {
    display: grid;
    grid-template-columns: auto 1fr auto auto;
    align-items: center;
    gap: 1.25rem;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--bp-card-border);
    transition: background 0.2s ease;
}

.bp-item:last-child {
    border-bottom: none;
}

.bp-item:hover {
    background: var(--bp-bg);
}

.bp-item-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    flex-shrink: 0;
}

.bp-item-icon svg {
    width: 24px;
    height: 24px;
}

.bp-item-info {
    min-width: 0;
}

.bp-item-name {
    font-weight: 600;
    color: var(--bp-text-primary);
    margin: 0 0 0.25rem 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.bp-item-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    font-size: 0.8rem;
    color: var(--bp-text-secondary);
}

.bp-item-meta span {
    display: flex;
    align-items: center;
    gap: 0.35rem;
}

.bp-item-periode {
    text-align: center;
}

.bp-item-periode .mois {
    font-weight: 700;
    color: var(--bp-primary);
    font-size: 1rem;
}

.bp-item-periode .annee {
    font-size: 0.75rem;
    color: var(--bp-text-secondary);
}

.bp-item-actions {
    display: flex;
    gap: 0.5rem;
}

.bp-action-btn {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    background: var(--bp-bg);
    color: var(--bp-text-secondary);
}

.bp-action-btn:hover {
    background: var(--bp-primary-light);
    color: var(--bp-primary);
}

.bp-action-btn.danger:hover {
    background: #FEE2E2;
    color: var(--bp-danger);
}

/* ========================================
   EMPTY STATE
   ======================================== */
.bp-empty {
    padding: 4rem 2rem;
    text-align: center;
}

.bp-empty-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    background: var(--bp-bg);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.bp-empty-icon svg {
    width: 40px;
    height: 40px;
    color: var(--bp-text-muted);
}

.bp-empty h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--bp-text-primary);
    margin: 0 0 0.5rem 0;
}

.bp-empty p {
    color: var(--bp-text-secondary);
    margin: 0 0 1.5rem 0;
}

/* ========================================
   BOUTONS
   ======================================== */
.bp-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.2s ease;
    border: none;
    text-decoration: none;
}

.bp-btn svg {
    width: 18px;
    height: 18px;
}

.bp-btn-primary {
    background: linear-gradient(135deg, var(--bp-primary) 0%, var(--bp-primary-dark) 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(74, 144, 217, 0.3);
}

.bp-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(74, 144, 217, 0.4);
}

.bp-btn-secondary {
    background: var(--bp-bg);
    color: var(--bp-text-primary);
    border: 1px solid var(--bp-card-border);
}

.bp-btn-secondary:hover {
    border-color: var(--bp-primary);
    color: var(--bp-primary);
}

/* ========================================
   MODAL UPLOAD
   ======================================== */
.bp-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.bp-modal-overlay.show {
    opacity: 1;
    visibility: visible;
}

.bp-modal {
    background: var(--bp-card-bg);
    border-radius: 20px;
    width: 100%;
    max-width: 600px;
    max-height: 90vh;
    overflow: hidden;
    transform: scale(0.9) translateY(20px);
    transition: transform 0.3s ease;
}

.bp-modal-overlay.show .bp-modal {
    transform: scale(1) translateY(0);
}

.bp-modal-header {
    background: linear-gradient(135deg, var(--bp-primary) 0%, var(--bp-primary-dark) 100%);
    padding: 1.5rem 2rem;
    color: white;
    position: relative;
}

.bp-modal-header h2 {
    font-size: 1.25rem;
    font-weight: 700;
    margin: 0 0 0.25rem 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.bp-modal-header p {
    margin: 0;
    opacity: 0.9;
    font-size: 0.9rem;
}

.bp-modal-close {
    position: absolute;
    top: 1rem;
    right: 1rem;
    width: 36px;
    height: 36px;
    background: rgba(255, 255, 255, 0.2);
    border: none;
    border-radius: 10px;
    cursor: pointer;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s;
}

.bp-modal-close:hover {
    background: rgba(255, 255, 255, 0.3);
}

.bp-modal-body {
    padding: 2rem;
    overflow-y: auto;
    max-height: calc(90vh - 200px);
}

.bp-form-group {
    margin-bottom: 1.5rem;
}

.bp-form-group label {
    display: block;
    font-weight: 600;
    color: var(--bp-text-primary);
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.bp-form-group label span {
    color: var(--bp-danger);
}

.bp-form-control {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 1px solid var(--bp-card-border);
    border-radius: 10px;
    background: var(--bp-bg);
    color: var(--bp-text-primary);
    font-size: 0.95rem;
    transition: all 0.2s ease;
}

.bp-form-control:focus {
    outline: none;
    border-color: var(--bp-primary);
    box-shadow: 0 0 0 3px var(--bp-primary-light);
}

.bp-form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

/* Searchable Select */
.bp-search-select { position: relative; }
.bp-search-select .bp-search-input {
    width: 100%; padding: 0.875rem 1rem 0.875rem 2.5rem; background: var(--bp-bg);
    border: 1px solid var(--bp-card-border); border-radius: 10px;
    font-size: 0.95rem; color: var(--bp-text-primary); box-sizing: border-box; transition: all 0.2s ease;
}
.bp-search-select .bp-search-input:focus { outline: none; border-color: var(--bp-primary); box-shadow: 0 0 0 3px var(--bp-primary-light); }
.bp-search-select .bp-search-icon {
    position: absolute; left: 0.875rem; top: 50%; transform: translateY(-50%);
    width: 16px; height: 16px; color: var(--bp-text-muted); pointer-events: none;
}
.bp-search-select .bp-search-clear {
    position: absolute; right: 0.625rem; top: 50%; transform: translateY(-50%);
    width: 20px; height: 20px; border: none; background: none; cursor: pointer;
    color: var(--bp-text-muted); display: none; padding: 0; font-size: 1.125rem; line-height: 1;
}
.bp-search-select .bp-search-clear:hover { color: var(--bp-text-primary); }
.bp-search-dropdown {
    display: none; position: absolute; top: 100%; left: 0; right: 0;
    background: var(--bp-card-bg); border: 1px solid var(--bp-card-border);
    border-radius: 10px; max-height: 220px; overflow-y: auto; z-index: 100;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12); margin-top: 4px;
}
.bp-search-option {
    padding: 0.75rem 1rem; cursor: pointer; font-size: 0.95rem;
    color: var(--bp-text-primary); transition: background 0.15s;
}
.bp-search-option:hover { background: var(--bp-primary-light); }
.bp-search-option .bp-opt-sub { color: var(--bp-text-muted); font-size: 0.8125rem; }
.bp-search-no-results {
    padding: 0.875rem 1rem; color: var(--bp-text-muted); font-style: italic;
    font-size: 0.875rem; text-align: center; display: none;
}

/* Form Errors */
.bp-form-error {
    font-size: 0.8125rem; color: var(--bp-danger); margin-top: 0.375rem;
}
.bp-form-group.has-error .bp-form-control,
.bp-form-group.has-error .bp-search-input {
    border-color: var(--bp-danger);
}
.bp-errors-summary {
    background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.25);
    border-radius: 10px; padding: 1rem 1.25rem; margin-bottom: 1rem;
}
.bp-errors-summary p {
    font-size: 0.875rem; font-weight: 600; color: var(--bp-danger); margin: 0 0 0.5rem;
}
.bp-errors-summary ul {
    margin: 0; padding-left: 1.25rem; list-style: disc;
}
.bp-errors-summary li {
    font-size: 0.8125rem; color: var(--bp-danger); margin-bottom: 0.25rem;
}

/* File Upload Zone */
.bp-upload-zone {
    border: 2px dashed var(--bp-card-border);
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease;
    background: var(--bp-bg);
}

.bp-upload-zone:hover,
.bp-upload-zone.dragover {
    border-color: var(--bp-primary);
    background: var(--bp-primary-light);
}

.bp-upload-zone.has-file {
    border-color: var(--bp-success);
    background: var(--bp-success-light);
}

.bp-upload-icon {
    width: 60px;
    height: 60px;
    margin: 0 auto 1rem;
    background: var(--bp-primary-light);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--bp-primary);
}

.bp-upload-icon svg {
    width: 28px;
    height: 28px;
}

.bp-upload-zone h4 {
    font-size: 1rem;
    color: var(--bp-text-primary);
    margin: 0 0 0.5rem 0;
}

.bp-upload-zone p {
    font-size: 0.85rem;
    color: var(--bp-text-secondary);
    margin: 0;
}

.bp-file-selected {
    display: none;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: white;
    border-radius: 10px;
    margin-top: 1rem;
}

.bp-upload-zone.has-file .bp-file-selected {
    display: flex;
}

.bp-file-icon {
    width: 44px;
    height: 44px;
    background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.bp-file-info {
    flex: 1;
    min-width: 0;
}

.bp-file-info h5 {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--bp-text-primary);
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.bp-file-info p {
    font-size: 0.8rem;
    color: var(--bp-text-secondary);
    margin: 0.25rem 0 0 0;
}

.bp-file-remove {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: none;
    background: #FEE2E2;
    color: var(--bp-danger);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Checkbox */
.bp-checkbox {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    cursor: pointer;
}

.bp-checkbox input {
    width: 20px;
    height: 20px;
    accent-color: var(--bp-primary);
}

.bp-checkbox span {
    font-size: 0.9rem;
    color: var(--bp-text-secondary);
}

.bp-modal-footer {
    padding: 1.5rem 2rem;
    border-top: 1px solid var(--bp-card-border);
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
}

/* ========================================
   PAGINATION
   ======================================== */
.bp-pagination {
    padding: 1rem 1.5rem;
    border-top: 1px solid var(--bp-card-border);
    display: flex;
    justify-content: center;
}

/* ========================================
   RESPONSIVE
   ======================================== */
@media (max-width: 1024px) {
    .bp-timeline-grid {
        grid-template-columns: repeat(6, 1fr);
    }
}

@media (max-width: 768px) {
    .bulletins-page {
        padding: 1rem;
    }

    .bp-header-content {
        flex-direction: column;
    }

    .bp-stats-row {
        grid-template-columns: repeat(2, 1fr);
    }

    .bp-timeline-grid {
        grid-template-columns: repeat(4, 1fr);
    }

    .bp-item {
        grid-template-columns: auto 1fr;
        gap: 1rem;
    }

    .bp-item-periode,
    .bp-item-salaire,
    .bp-item-actions {
        grid-column: 2;
    }

    .bp-form-row {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection

@section('content')
<div class="bulletins-page">
    <!-- Header avec Stats -->
    <div class="bp-header">
        <div class="bp-header-content">
            <div class="bp-header-left">
                <h1>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                    </svg>
                    Bulletins de Paie
                </h1>
                <p>Gérez et distribuez les fiches de paie de vos employés</p>
            </div>
            <div class="bp-header-actions">
                <a href="{{ route('admin.bulletins-paie.export', ['annee' => $anneeSelectionnee, 'mois' => $moisSelectionne]) }}" class="bp-btn bp-btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    Exporter
                </a>
                <button type="button" class="bp-btn bp-btn-primary" onclick="openUploadModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="17 8 12 3 7 8"></polyline>
                        <line x1="12" y1="3" x2="12" y2="15"></line>
                    </svg>
                    Ajouter un bulletin
                </button>
            </div>
        </div>

        <!-- Stats -->
        <div class="bp-stats-row">
            <div class="bp-stat-card">
                <div class="bp-stat-icon blue">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                </div>
                <div class="bp-stat-info">
                    <h4>{{ $stats['total_bulletins'] ?? 0 }}</h4>
                    <p>Bulletins en {{ $anneeSelectionnee }}</p>
                </div>
            </div>
            <div class="bp-stat-card">
                <div class="bp-stat-icon green">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <div class="bp-stat-info">
                    <h4>{{ $stats['total_employes'] ?? 0 }}</h4>
                    <p>Employés concernés</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Timeline Année -->
    <div class="bp-timeline-section">
        <div class="bp-timeline-header">
            <h3>
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                Calendrier des bulletins
            </h3>
            <div class="bp-year-selector">
                <select onchange="window.location.href='{{ route('admin.bulletins-paie.index') }}?annee=' + this.value">
                    @foreach($anneesDisponibles as $annee)
                        <option value="{{ $annee }}" {{ $annee == $anneeSelectionnee ? 'selected' : '' }}>{{ $annee }}</option>
                    @endforeach
                    @if(!$anneesDisponibles->contains(now()->year))
                        <option value="{{ now()->year }}" {{ now()->year == $anneeSelectionnee ? 'selected' : '' }}>{{ now()->year }}</option>
                    @endif
                </select>
            </div>
        </div>

        <div class="bp-timeline-grid">
            @foreach($timeline as $mois => $data)
                @php
                    $isFuture = ($anneeSelectionnee == now()->year && $mois > now()->month);
                    $isActive = $moisSelectionne == $mois;
                    $hasData = $data['total'] > 0;
                @endphp
                <a href="{{ route('admin.bulletins-paie.index', ['annee' => $anneeSelectionnee, 'mois' => $isActive ? null : $mois]) }}"
                   class="bp-month-item {{ $isActive ? 'active' : '' }} {{ $hasData ? 'has-data' : '' }} {{ $isFuture ? 'future' : '' }}"
                   @if($isFuture) onclick="return false;" @endif>
                    <div class="bp-month-name">{{ $data['mois_court'] }}</div>
                    <div class="bp-month-count">{{ $data['total'] }}</div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Filtres -->
    <div class="bp-filters">
        <form action="{{ route('admin.bulletins-paie.index') }}" method="GET" class="bp-search-box">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="hidden" name="annee" value="{{ $anneeSelectionnee }}">
            @if($moisSelectionne)<input type="hidden" name="mois" value="{{ $moisSelectionne }}">@endif
            <input type="text" name="search" value="{{ $search }}" placeholder="Rechercher par nom, prénom ou matricule...">
        </form>

        <div class="bp-filter-badges">
            @if($moisSelectionne)
                <span class="bp-badge">
                    {{ \App\Models\BulletinPaie::MOIS_NOMS[$moisSelectionne] }} {{ $anneeSelectionnee }}
                    <a href="{{ route('admin.bulletins-paie.index', ['annee' => $anneeSelectionnee]) }}" class="close">&times;</a>
                </span>
            @endif
            @if($search)
                <span class="bp-badge">
                    "{{ $search }}"
                    <a href="{{ route('admin.bulletins-paie.index', ['annee' => $anneeSelectionnee, 'mois' => $moisSelectionne]) }}" class="close">&times;</a>
                </span>
            @endif
        </div>
    </div>

    <!-- Liste des Bulletins -->
    <div class="bp-list-section">
        <div class="bp-list-header">
            <h3>
                @if($moisSelectionne)
                    Bulletins de {{ \App\Models\BulletinPaie::MOIS_NOMS[$moisSelectionne] }} {{ $anneeSelectionnee }}
                @else
                    Tous les bulletins de {{ $anneeSelectionnee }}
                @endif
            </h3>
            <span class="bp-list-count">{{ $bulletins->total() }} bulletin(s)</span>
        </div>

        @if($bulletins->count() > 0)
            @foreach($bulletins as $bulletin)
                <div class="bp-item">
                    <div class="bp-item-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                        </svg>
                    </div>
                    <div class="bp-item-info">
                        <h4 class="bp-item-name">{{ $bulletin->personnel->nom_complet }}</h4>
                        <div class="bp-item-meta">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                </svg>
                                {{ $bulletin->personnel->matricule }}
                            </span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                </svg>
                                {{ $bulletin->fichier_taille_formatee }}
                            </span>
                            <span>{{ $bulletin->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                    <div class="bp-item-periode">
                        <div class="mois">{{ $bulletin->mois_court }}</div>
                        <div class="annee">{{ $bulletin->annee }}</div>
                    </div>
                    <div class="bp-item-actions">
                        <a href="{{ route('admin.bulletins-paie.preview', $bulletin) }}" target="_blank" class="bp-action-btn" title="Prévisualiser">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </a>
                        <a href="{{ route('admin.bulletins-paie.download', $bulletin) }}" class="bp-action-btn" title="Télécharger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                        </a>
                        <form action="{{ route('admin.bulletins-paie.destroy', $bulletin) }}" method="POST" style="display: inline;" onsubmit="return confirm('Supprimer ce bulletin ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bp-action-btn danger" title="Supprimer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach

            @if($bulletins->hasPages())
                <div class="bp-pagination">
                    {{ $bulletins->links() }}
                </div>
            @endif
        @else
            <div class="bp-empty">
                <div class="bp-empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                </div>
                <h3>Aucun bulletin trouvé</h3>
                <p>
                    @if($moisSelectionne)
                        Aucun bulletin de paie pour {{ \App\Models\BulletinPaie::MOIS_NOMS[$moisSelectionne] }} {{ $anneeSelectionnee }}.
                    @else
                        Aucun bulletin de paie pour l'année {{ $anneeSelectionnee }}.
                    @endif
                </p>
                <button type="button" class="bp-btn bp-btn-primary" onclick="openUploadModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="17 8 12 3 7 8"></polyline>
                        <line x1="12" y1="3" x2="12" y2="15"></line>
                    </svg>
                    Ajouter un bulletin
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Modal Upload -->
<div class="bp-modal-overlay" id="uploadModal">
    <div class="bp-modal">
        <div class="bp-modal-header">
            <h2>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="17 8 12 3 7 8"></polyline>
                    <line x1="12" y1="3" x2="12" y2="15"></line>
                </svg>
                Ajouter un bulletin de paie
            </h2>
            <p>Uploadez le fichier PDF du bulletin</p>
            <button type="button" class="bp-modal-close" onclick="closeUploadModal()">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <form action="{{ route('admin.bulletins-paie.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
            @csrf
            <div class="bp-modal-body">
                @if($errors->any())
                <div class="bp-errors-summary">
                    <p>Veuillez corriger les erreurs suivantes :</p>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Sélection employé -->
                <div class="bp-form-group {{ $errors->has('personnel_id') ? 'has-error' : '' }}">
                    <label>Employé <span>*</span></label>
                    <div class="bp-search-select" id="bpPersonnelSearch">
                        <svg class="bp-search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <input type="text" class="bp-search-input" placeholder="Rechercher un employé..." autocomplete="off">
                        <button type="button" class="bp-search-clear" title="Effacer">&times;</button>
                        <input type="hidden" name="personnel_id" value="{{ old('personnel_id') }}" required>
                        <div class="bp-search-dropdown">
                            @foreach($personnels as $personnel)
                                <div class="bp-search-option" data-value="{{ $personnel->id }}" data-text="{{ $personnel->matricule }} - {{ $personnel->nom }} {{ $personnel->prenoms }}">
                                    {{ $personnel->matricule }} - {{ $personnel->nom }} {{ $personnel->prenoms }}
                                </div>
                            @endforeach
                            <div class="bp-search-no-results">Aucun résultat</div>
                        </div>
                    </div>
                    @error('personnel_id')
                        <div class="bp-form-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Période -->
                <div class="bp-form-row">
                    <div class="bp-form-group">
                        <label>Mois <span>*</span></label>
                        <select name="mois" class="bp-form-control" required>
                            @foreach(\App\Models\BulletinPaie::MOIS_NOMS as $num => $nom)
                                <option value="{{ $num }}" {{ $moisSelectionne == $num || (!$moisSelectionne && $num == now()->month) ? 'selected' : '' }}>
                                    {{ $nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="bp-form-group">
                        <label>Année <span>*</span></label>
                        <select name="annee" class="bp-form-control" required>
                            @for($y = now()->year; $y >= now()->year - 5; $y--)
                                <option value="{{ $y }}" {{ $anneeSelectionnee == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                @error('periode')
                    <div class="bp-form-error" style="margin-top: -0.5rem; margin-bottom: 0.75rem;">{{ $message }}</div>
                @enderror

                <!-- Upload fichier -->
                <div class="bp-form-group {{ $errors->has('fichier') ? 'has-error' : '' }}">
                    <label>Fichier PDF <span>*</span></label>
                    <div class="bp-upload-zone" id="uploadZone">
                        <input type="file" name="fichier" id="fichierInput" accept=".pdf" required hidden>
                        <div class="bp-upload-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
                            </svg>
                        </div>
                        <h4>Glissez-déposez votre fichier ici</h4>
                        <p>ou cliquez pour parcourir (PDF uniquement, max 10 Mo)</p>

                        <div class="bp-file-selected">
                            <div class="bp-file-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                </svg>
                            </div>
                            <div class="bp-file-info">
                                <h5 id="fileName">document.pdf</h5>
                                <p id="fileSize">0 Ko</p>
                            </div>
                            <button type="button" class="bp-file-remove" onclick="removeFile(event)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @error('fichier')
                        <div class="bp-form-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Options -->
                <div class="bp-form-group">
                    <label class="bp-checkbox">
                        <input type="checkbox" name="visible_employe" value="1" checked>
                        <span>Rendre visible à l'employé</span>
                    </label>
                </div>

                <!-- Commentaire -->
                <div class="bp-form-group">
                    <label>Commentaire (optionnel)</label>
                    <textarea name="commentaire" class="bp-form-control" rows="2" placeholder="Note interne..."></textarea>
                </div>
            </div>

            <div class="bp-modal-footer">
                <button type="button" class="bp-btn bp-btn-secondary" onclick="closeUploadModal()">Annuler</button>
                <button type="submit" class="bp-btn bp-btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="17 8 12 3 7 8"></polyline>
                        <line x1="12" y1="3" x2="12" y2="15"></line>
                    </svg>
                    Uploader le bulletin
                </button>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
<div class="alert-toast success" id="successToast">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
        <polyline points="22 4 12 14.01 9 11.01"></polyline>
    </svg>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert-toast error" id="errorToast">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="10"></circle>
        <line x1="15" y1="9" x2="9" y2="15"></line>
        <line x1="9" y1="9" x2="15" y2="15"></line>
    </svg>
    {{ session('error') }}
</div>
@endif

@if(session('success') || session('error'))
<style>
.alert-toast {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    padding: 1rem 1.5rem;
    border-radius: 12px;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 500;
    z-index: 2000;
    animation: slideIn 0.3s ease, slideOut 0.3s ease 4s forwards;
}
.alert-toast.success {
    background: #10B981;
    color: white;
}
.alert-toast.error {
    background: #EF4444;
    color: white;
}
@keyframes slideIn {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}
@keyframes slideOut {
    from { transform: translateX(0); opacity: 1; }
    to { transform: translateX(100%); opacity: 0; }
}
</style>
@endif
@endsection

@section('scripts')
<script>
// Modal functions
function openUploadModal() {
    document.getElementById('uploadModal').classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeUploadModal() {
    document.getElementById('uploadModal').classList.remove('show');
    document.body.style.overflow = '';
    document.getElementById('uploadForm').reset();
    document.getElementById('uploadZone').classList.remove('has-file');
}

// Close on click outside
document.getElementById('uploadModal').addEventListener('click', function(e) {
    if (e.target === this) closeUploadModal();
});

// Close on Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeUploadModal();
});

// File Upload Zone
const uploadZone = document.getElementById('uploadZone');
const fichierInput = document.getElementById('fichierInput');
const fileNameEl = document.getElementById('fileName');
const fileSizeEl = document.getElementById('fileSize');

uploadZone.addEventListener('click', function(e) {
    if (!e.target.closest('.bp-file-remove')) {
        fichierInput.click();
    }
});

uploadZone.addEventListener('dragover', function(e) {
    e.preventDefault();
    this.classList.add('dragover');
});

uploadZone.addEventListener('dragleave', function(e) {
    e.preventDefault();
    this.classList.remove('dragover');
});

uploadZone.addEventListener('drop', function(e) {
    e.preventDefault();
    this.classList.remove('dragover');
    if (e.dataTransfer.files.length) {
        fichierInput.files = e.dataTransfer.files;
        displayFile(e.dataTransfer.files[0]);
    }
});

fichierInput.addEventListener('change', function() {
    if (this.files.length) {
        displayFile(this.files[0]);
    }
});

function displayFile(file) {
    if (file.type !== 'application/pdf') {
        alert('Seuls les fichiers PDF sont acceptés.');
        return;
    }
    uploadZone.classList.add('has-file');
    fileNameEl.textContent = file.name;
    fileSizeEl.textContent = formatFileSize(file.size);
}

function removeFile(e) {
    e.stopPropagation();
    fichierInput.value = '';
    uploadZone.classList.remove('has-file');
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Ko';
    const k = 1024;
    const sizes = ['octets', 'Ko', 'Mo', 'Go'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Client-side validation before submit
document.getElementById('uploadForm').addEventListener('submit', function(e) {
    var hidden = document.querySelector('#bpPersonnelSearch input[name="personnel_id"]');
    if (!hidden || !hidden.value) {
        e.preventDefault();
        var searchInput = document.querySelector('#bpPersonnelSearch .bp-search-input');
        if (searchInput) searchInput.focus();
        alert('Veuillez sélectionner un employé.');
        return false;
    }
});

// Auto-open modal if validation errors
@if($errors->any())
    openUploadModal();
@endif

// ── Searchable Personnel Select ──
(function() {
    var wrapper = document.getElementById('bpPersonnelSearch');
    if (!wrapper) return;
    var input = wrapper.querySelector('.bp-search-input');
    var hidden = wrapper.querySelector('input[name="personnel_id"]');
    var dropdown = wrapper.querySelector('.bp-search-dropdown');
    var options = wrapper.querySelectorAll('.bp-search-option');
    var noResults = wrapper.querySelector('.bp-search-no-results');
    var clearBtn = wrapper.querySelector('.bp-search-clear');

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
        if (visible === 1 && term.length > 0) {
            options.forEach(function(opt) {
                if (opt.style.display !== 'none') selectOption(opt);
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

    input.addEventListener('focus', function() { showDropdown(); filterOptions(); });
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

    // Reset on form reset
    var form = wrapper.closest('form');
    if (form) {
        form.addEventListener('reset', function() {
            setTimeout(function() { clearSelection(); }, 0);
        });
    }
})();

// Auto-hide toasts
setTimeout(function() {
    var toast = document.getElementById('successToast');
    if (toast) toast.remove();
    var errorToast = document.getElementById('errorToast');
    if (errorToast) errorToast.remove();
}, 5000);
</script>
@endsection
