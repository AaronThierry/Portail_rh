@extends('layouts.app')

@section('title', 'Gestion des Départements')
@section('page-title', 'Départements')
@section('page-subtitle', 'Gérez les départements du système')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
</svg>
@endsection

@section('styles')
<style>
/* ========================================
   VARIABLES - Charte RH+ Premium
   ======================================== */
:root {
    --dp-primary: #4A90D9;
    --dp-primary-dark: #2E6BB3;
    --dp-primary-light: #E8F4FD;
    --dp-accent: #FF9500;
    --dp-accent-light: #FFF7ED;
    --dp-success: #22C55E;
    --dp-success-light: #F0FDF4;
    --dp-danger: #EF4444;
    --dp-danger-light: #FEF2F2;
    --dp-warning: #F59E0B;
    --dp-warning-light: #FFFBEB;
    --dp-info: #3B82F6;
    --dp-info-light: #EFF6FF;
    --dp-purple: #8B5CF6;
    --dp-purple-light: #F5F3FF;
    --dp-bg: #f8fafc;
    --dp-card-bg: #ffffff;
    --dp-card-border: #e2e8f0;
    --dp-text-primary: #1e293b;
    --dp-text-secondary: #64748b;
    --dp-text-muted: #94a3b8;
    --dp-shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.04);
    --dp-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    --dp-shadow-lg: 0 8px 30px rgba(0, 0, 0, 0.1);
    --dp-radius-sm: 8px;
    --dp-radius: 12px;
    --dp-radius-lg: 16px;
    --dp-radius-xl: 20px;
    --dp-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.dark {
    --dp-bg: #0f172a;
    --dp-card-bg: #1e293b;
    --dp-card-border: #334155;
    --dp-text-primary: #f1f5f9;
    --dp-text-secondary: #94a3b8;
    --dp-text-muted: #64748b;
    --dp-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    --dp-shadow-lg: 0 8px 30px rgba(0, 0, 0, 0.4);
    --dp-primary-light: rgba(74, 144, 217, 0.15);
    --dp-accent-light: rgba(255, 149, 0, 0.15);
    --dp-success-light: rgba(34, 197, 94, 0.15);
    --dp-danger-light: rgba(239, 68, 68, 0.15);
    --dp-info-light: rgba(59, 130, 246, 0.15);
    --dp-purple-light: rgba(139, 92, 246, 0.15);
}

/* ========================================
   BASE
   ======================================== */
.departements-page {
    padding: 1.5rem;
    min-height: 100vh;
    background: var(--dp-bg);
}

/* ========================================
   HEADER PREMIUM
   ======================================== */
.dp-header {
    background: var(--dp-card-bg);
    border-radius: var(--dp-radius-xl);
    padding: 2rem;
    margin-bottom: 1.5rem;
    box-shadow: var(--dp-shadow);
    border: 1px solid var(--dp-card-border);
    position: relative;
    overflow: hidden;
}

.dp-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--dp-primary), var(--dp-accent), var(--dp-purple));
}

.dp-header::after {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 300px;
    height: 100%;
    background: radial-gradient(circle at 100% 0%, rgba(74, 144, 217, 0.08) 0%, transparent 70%);
    pointer-events: none;
}

.dp-header-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 1.5rem;
    position: relative;
    z-index: 1;
}

.dp-header-left {
    flex: 1;
}

.dp-header-left h1 {
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--dp-text-primary);
    margin: 0 0 0.5rem 0;
    display: flex;
    align-items: center;
    gap: 0.875rem;
    letter-spacing: -0.025em;
}

.dp-header-left h1 svg {
    width: 36px;
    height: 36px;
    padding: 8px;
    background: linear-gradient(135deg, var(--dp-primary) 0%, var(--dp-primary-dark) 100%);
    color: white;
    border-radius: var(--dp-radius);
    box-shadow: 0 4px 12px rgba(74, 144, 217, 0.3);
}

.dp-header-left p {
    color: var(--dp-text-secondary);
    margin: 0;
    font-size: 0.95rem;
}

.dp-header-actions {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

/* ========================================
   STATS ROW
   ======================================== */
.dp-stats-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 1rem;
    margin-top: 1.75rem;
    padding-top: 1.75rem;
    border-top: 1px solid var(--dp-card-border);
}

.dp-stat-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.25rem;
    background: var(--dp-bg);
    border-radius: var(--dp-radius);
    transition: var(--dp-transition);
    position: relative;
    overflow: hidden;
}

.dp-stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: var(--stat-color, var(--dp-primary));
    opacity: 0;
    transition: opacity 0.3s ease;
}

.dp-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--dp-shadow-sm);
}

.dp-stat-card:hover::before {
    opacity: 1;
}

.dp-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: var(--dp-radius);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: var(--dp-transition);
}

.dp-stat-icon svg {
    width: 24px;
    height: 24px;
}

.dp-stat-icon.blue {
    background: var(--dp-primary-light);
    color: var(--dp-primary);
}
.dp-stat-icon.green {
    background: var(--dp-success-light);
    color: var(--dp-success);
}
.dp-stat-icon.orange {
    background: var(--dp-accent-light);
    color: var(--dp-accent);
}
.dp-stat-icon.purple {
    background: var(--dp-purple-light);
    color: var(--dp-purple);
}

.dp-stat-card:hover .dp-stat-icon {
    transform: scale(1.1);
}

.dp-stat-info h4 {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--dp-text-primary);
    margin: 0;
    line-height: 1;
}

.dp-stat-info p {
    font-size: 0.8rem;
    color: var(--dp-text-secondary);
    margin: 0.25rem 0 0 0;
    font-weight: 500;
}

/* ========================================
   FILTRES ET RECHERCHE
   ======================================== */
.dp-filters {
    background: var(--dp-card-bg);
    border-radius: var(--dp-radius-lg);
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: var(--dp-shadow-sm);
    border: 1px solid var(--dp-card-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.dp-search-box {
    position: relative;
    flex: 1;
    max-width: 400px;
}

.dp-search-box input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.75rem;
    border: 2px solid var(--dp-card-border);
    border-radius: var(--dp-radius);
    background: var(--dp-bg);
    color: var(--dp-text-primary);
    font-size: 0.9rem;
    transition: var(--dp-transition);
}

.dp-search-box input:focus {
    outline: none;
    border-color: var(--dp-primary);
    box-shadow: 0 0 0 4px var(--dp-primary-light);
}

.dp-search-box input::placeholder {
    color: var(--dp-text-muted);
}

.dp-search-box svg {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    width: 18px;
    height: 18px;
    color: var(--dp-text-muted);
    transition: color 0.3s;
}

.dp-search-box:focus-within svg {
    color: var(--dp-primary);
}

.dp-filter-chips {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.dp-chip {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: var(--dp-primary-light);
    color: var(--dp-primary);
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--dp-transition);
    border: none;
}

.dp-chip:hover {
    background: var(--dp-primary);
    color: white;
}

.dp-chip.active {
    background: var(--dp-primary);
    color: white;
}

.dp-chip svg {
    width: 16px;
    height: 16px;
}

/* ========================================
   LISTE DES DÉPARTEMENTS - CARTES
   ======================================== */
.dp-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    gap: 1.25rem;
    margin-bottom: 1.5rem;
}

.dp-card {
    background: var(--dp-card-bg);
    border-radius: var(--dp-radius-lg);
    border: 1px solid var(--dp-card-border);
    overflow: hidden;
    transition: var(--dp-transition);
    position: relative;
}

.dp-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--card-color, var(--dp-primary)), transparent);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.dp-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--dp-shadow-lg);
    border-color: transparent;
}

.dp-card:hover::before {
    opacity: 1;
}

.dp-card-header {
    padding: 1.25rem 1.5rem;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    background: linear-gradient(135deg, rgba(74, 144, 217, 0.03) 0%, transparent 100%);
    border-bottom: 1px solid var(--dp-card-border);
}

.dp-card-icon {
    width: 52px;
    height: 52px;
    border-radius: var(--dp-radius);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    background: linear-gradient(135deg, var(--dp-primary) 0%, var(--dp-primary-dark) 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(74, 144, 217, 0.25);
    transition: var(--dp-transition);
}

.dp-card-icon svg {
    width: 26px;
    height: 26px;
}

.dp-card:hover .dp-card-icon {
    transform: scale(1.1) rotate(5deg);
}

.dp-card-title-section {
    flex: 1;
    min-width: 0;
}

.dp-card-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--dp-text-primary);
    margin: 0 0 0.25rem 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.dp-card-code {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.625rem;
    background: var(--dp-bg);
    color: var(--dp-text-secondary);
    font-size: 0.75rem;
    font-weight: 600;
    font-family: 'SF Mono', 'Consolas', monospace;
    border-radius: 6px;
    border: 1px solid var(--dp-card-border);
}

.dp-card-body {
    padding: 1.25rem 1.5rem;
}

.dp-card-description {
    font-size: 0.875rem;
    color: var(--dp-text-secondary);
    margin: 0 0 1rem 0;
    line-height: 1.6;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.dp-card-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.dp-meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.875rem;
    background: var(--dp-bg);
    border-radius: var(--dp-radius-sm);
    font-size: 0.8rem;
    color: var(--dp-text-secondary);
    font-weight: 500;
}

.dp-meta-item svg {
    width: 16px;
    height: 16px;
    color: var(--dp-text-muted);
}

.dp-meta-item strong {
    color: var(--dp-text-primary);
    font-weight: 700;
}

.dp-card-badges {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.dp-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.75rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.dp-badge-global {
    background: var(--dp-info-light);
    color: var(--dp-info);
}

.dp-badge-entreprise {
    background: var(--dp-purple-light);
    color: var(--dp-purple);
}

.dp-badge-active {
    background: var(--dp-success-light);
    color: var(--dp-success);
}

.dp-badge-inactive {
    background: var(--dp-danger-light);
    color: var(--dp-danger);
}

.dp-badge svg {
    width: 12px;
    height: 12px;
}

.dp-card-footer {
    padding: 1rem 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid var(--dp-card-border);
    background: var(--dp-bg);
}

.dp-card-entreprise {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8rem;
    color: var(--dp-text-secondary);
}

.dp-card-entreprise svg {
    width: 16px;
    height: 16px;
    color: var(--dp-text-muted);
}

.dp-card-actions {
    display: flex;
    gap: 0.5rem;
}

.dp-action-btn {
    width: 36px;
    height: 36px;
    border-radius: var(--dp-radius-sm);
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--dp-transition);
    background: var(--dp-card-bg);
    color: var(--dp-text-secondary);
    text-decoration: none;
}

.dp-action-btn svg {
    width: 18px;
    height: 18px;
}

.dp-action-btn:hover {
    transform: translateY(-2px);
}

.dp-action-btn.view:hover {
    background: var(--dp-info-light);
    color: var(--dp-info);
}

.dp-action-btn.edit:hover {
    background: var(--dp-primary-light);
    color: var(--dp-primary);
}

.dp-action-btn.delete:hover {
    background: var(--dp-danger-light);
    color: var(--dp-danger);
}

/* ========================================
   VUE TABLEAU ALTERNATIVE
   ======================================== */
.dp-table-section {
    background: var(--dp-card-bg);
    border-radius: var(--dp-radius-lg);
    box-shadow: var(--dp-shadow-sm);
    border: 1px solid var(--dp-card-border);
    overflow: hidden;
    display: none;
}

.dp-table-section.active {
    display: block;
}

.dp-table-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--dp-card-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(135deg, rgba(74, 144, 217, 0.03) 0%, transparent 100%);
}

.dp-table-header h3 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--dp-text-primary);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.dp-table-header h3 svg {
    width: 20px;
    height: 20px;
    color: var(--dp-primary);
}

.dp-table-count {
    font-size: 0.85rem;
    color: var(--dp-text-secondary);
    font-weight: 500;
}

.dp-table {
    width: 100%;
    border-collapse: collapse;
}

.dp-table thead {
    background: var(--dp-bg);
}

.dp-table th {
    padding: 1rem 1.25rem;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--dp-text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid var(--dp-card-border);
}

.dp-table td {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid var(--dp-card-border);
    vertical-align: middle;
}

.dp-table tbody tr {
    transition: var(--dp-transition);
}

.dp-table tbody tr:hover {
    background: rgba(74, 144, 217, 0.04);
}

.dp-table tbody tr:last-child td {
    border-bottom: none;
}

.dp-table-name {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.dp-table-icon {
    width: 42px;
    height: 42px;
    border-radius: var(--dp-radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--dp-primary-light) 0%, rgba(74, 144, 217, 0.1) 100%);
    color: var(--dp-primary);
    flex-shrink: 0;
}

.dp-table-icon svg {
    width: 20px;
    height: 20px;
}

.dp-table-name-content h4 {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--dp-text-primary);
    margin: 0 0 0.125rem 0;
}

.dp-table-name-content p {
    font-size: 0.8rem;
    color: var(--dp-text-muted);
    margin: 0;
}

.dp-table-code {
    display: inline-flex;
    padding: 0.375rem 0.75rem;
    background: var(--dp-bg);
    color: var(--dp-text-secondary);
    font-size: 0.8rem;
    font-weight: 600;
    font-family: 'SF Mono', 'Consolas', monospace;
    border-radius: 6px;
    border: 1px solid var(--dp-card-border);
}

.dp-table-services {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.dp-table-services-count {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: var(--dp-primary-light);
    color: var(--dp-primary);
    font-weight: 700;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.dp-table-actions {
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
}

/* ========================================
   BOUTONS
   ======================================== */
.dp-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    border-radius: var(--dp-radius);
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: var(--dp-transition);
    border: none;
    text-decoration: none;
}

.dp-btn svg {
    width: 18px;
    height: 18px;
}

.dp-btn-primary {
    background: linear-gradient(135deg, var(--dp-primary) 0%, var(--dp-primary-dark) 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(74, 144, 217, 0.3);
}

.dp-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(74, 144, 217, 0.4);
}

.dp-btn-secondary {
    background: var(--dp-card-bg);
    color: var(--dp-text-primary);
    border: 2px solid var(--dp-card-border);
}

.dp-btn-secondary:hover {
    border-color: var(--dp-primary);
    color: var(--dp-primary);
    background: var(--dp-primary-light);
}

.dp-btn-icon {
    width: 42px;
    height: 42px;
    padding: 0;
    justify-content: center;
    background: var(--dp-card-bg);
    border: 2px solid var(--dp-card-border);
    color: var(--dp-text-secondary);
}

.dp-btn-icon:hover {
    border-color: var(--dp-primary);
    color: var(--dp-primary);
    background: var(--dp-primary-light);
}

.dp-btn-icon.active {
    border-color: var(--dp-primary);
    color: var(--dp-primary);
    background: var(--dp-primary-light);
}

/* ========================================
   EMPTY STATE
   ======================================== */
.dp-empty {
    text-align: center;
    padding: 4rem 2rem;
    background: var(--dp-card-bg);
    border-radius: var(--dp-radius-lg);
    border: 1px solid var(--dp-card-border);
}

.dp-empty-icon {
    width: 100px;
    height: 100px;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, var(--dp-primary-light) 0%, rgba(74, 144, 217, 0.1) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.dp-empty-icon::after {
    content: '';
    position: absolute;
    inset: -8px;
    border-radius: 50%;
    border: 2px dashed var(--dp-card-border);
    animation: spin 20s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.dp-empty-icon svg {
    width: 48px;
    height: 48px;
    color: var(--dp-primary);
}

.dp-empty h3 {
    font-size: 1.375rem;
    font-weight: 700;
    color: var(--dp-text-primary);
    margin: 0 0 0.5rem 0;
}

.dp-empty p {
    color: var(--dp-text-secondary);
    margin: 0 0 1.5rem 0;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}

/* ========================================
   ALERTS
   ======================================== */
.dp-alert {
    display: flex;
    align-items: center;
    gap: 0.875rem;
    padding: 1rem 1.25rem;
    border-radius: var(--dp-radius);
    margin-bottom: 1.5rem;
    border-left: 4px solid;
}

.dp-alert svg {
    width: 22px;
    height: 22px;
    flex-shrink: 0;
}

.dp-alert-success {
    background: var(--dp-success-light);
    border-color: var(--dp-success);
    color: #166534;
}

.dark .dp-alert-success {
    color: #86efac;
}

.dp-alert-error {
    background: var(--dp-danger-light);
    border-color: var(--dp-danger);
    color: #991b1b;
}

.dark .dp-alert-error {
    color: #fca5a5;
}

/* ========================================
   VIEW TOGGLE
   ======================================== */
.dp-view-toggle {
    display: flex;
    gap: 0.25rem;
    padding: 0.25rem;
    background: var(--dp-bg);
    border-radius: var(--dp-radius);
    border: 1px solid var(--dp-card-border);
}

/* ========================================
   MODAL - RH+ DESIGN (Style Entreprise)
   ======================================== */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(10, 15, 28, 0.8);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    padding: 1rem;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.modal-overlay.show {
    display: flex;
    opacity: 1;
}

.modal {
    background: var(--dp-card-bg);
    border-radius: 12px;
    width: 100%;
    max-width: 640px;
    max-height: 88vh;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
    animation: modalSlideIn 0.35s ease-out;
    position: relative;
    display: flex;
    flex-direction: column;
    border-top: 4px solid var(--dp-primary);
}

@keyframes modalSlideIn {
    0% {
        opacity: 0;
        transform: scale(0.95) translateY(20px);
    }
    100% {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

/* Modal Header - Orange */
.modal-header {
    position: relative;
    background: linear-gradient(135deg, var(--dp-accent) 0%, #e67e00 100%);
    color: white;
    flex-shrink: 0;
}

.modal-header-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.25rem;
}

.modal-header-left {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.modal-icon {
    width: 44px;
    height: 44px;
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-icon svg {
    width: 22px;
    height: 22px;
}

.modal-header-text h2 {
    font-size: 1.125rem;
    font-weight: 700;
    margin: 0;
}

.modal-header-text p {
    font-size: 0.75rem;
    opacity: 0.9;
    margin: 0.125rem 0 0 0;
}

.modal-close {
    width: 32px;
    height: 32px;
    background: rgba(255, 255, 255, 0.15);
    border: none;
    border-radius: 8px;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.modal-close:hover {
    background: rgba(255, 255, 255, 0.95);
    color: var(--dp-danger);
}

.modal-close svg {
    width: 18px;
    height: 18px;
}

/* Modal Body */
.modal-body {
    padding: 1.25rem;
    max-height: calc(88vh - 140px);
    overflow-y: auto;
    background: var(--dp-card-bg);
    flex: 1;
}

/* Custom Scrollbar */
.modal-body::-webkit-scrollbar {
    width: 5px;
}

.modal-body::-webkit-scrollbar-track {
    background: transparent;
}

.modal-body::-webkit-scrollbar-thumb {
    background: var(--dp-card-border);
    border-radius: 3px;
}

.modal-body::-webkit-scrollbar-thumb:hover {
    background: var(--dp-primary);
}

/* Form Section */
.form-section {
    margin-bottom: 1.25rem;
    padding-bottom: 1.25rem;
    border-bottom: 1px dashed var(--dp-card-border);
    position: relative;
}

.form-section:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.form-section-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.form-section-icon {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, var(--dp-primary-light) 0%, rgba(74, 144, 217, 0.1) 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--dp-primary);
    transition: all 0.3s ease;
}

.form-section-icon svg {
    width: 18px;
    height: 18px;
}

.form-section-icon.success {
    background: linear-gradient(135deg, var(--dp-success-light) 0%, rgba(34, 197, 94, 0.1) 100%);
    color: var(--dp-success);
}

.form-section-icon.purple {
    background: linear-gradient(135deg, var(--dp-purple-light) 0%, rgba(139, 92, 246, 0.1) 100%);
    color: var(--dp-purple);
}

.form-section-title {
    font-size: 0.9375rem;
    font-weight: 700;
    color: var(--dp-text-primary);
    margin: 0;
}

/* Form Grid */
.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

@media (max-width: 640px) {
    .form-grid { grid-template-columns: 1fr; }
}

/* Form Group */
.form-group {
    margin-bottom: 0;
    position: relative;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

/* Form Label */
.form-label {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--dp-text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.5rem;
}

.form-label.required::after {
    content: '*';
    color: var(--dp-accent);
    font-size: 0.875rem;
    font-weight: 800;
}

/* Form Input */
.form-input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1.5px solid var(--dp-card-border);
    border-radius: 10px;
    background: var(--dp-bg);
    color: var(--dp-text-primary);
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.25s ease;
}

.form-input:hover {
    border-color: rgba(74, 144, 217, 0.4);
}

.form-input:focus {
    outline: none;
    border-color: var(--dp-accent);
    box-shadow: 0 0 0 3px rgba(255, 149, 0, 0.12);
}

.form-input::placeholder {
    color: var(--dp-text-muted);
    font-weight: 400;
}

textarea.form-input {
    resize: vertical;
    min-height: 80px;
    line-height: 1.5;
}

select.form-input {
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 18px;
    padding-right: 2.5rem;
}

/* Status Cards Selection */
.status-cards {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.status-card {
    position: relative;
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem;
    background: var(--dp-bg);
    border: 2px solid var(--dp-card-border);
    border-radius: 14px;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    overflow: hidden;
}

.status-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: transparent;
    transition: all 0.3s ease;
}

.status-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
}

/* Global Card Styling */
.status-card.global {
    border-color: rgba(59, 130, 246, 0.3);
}

.status-card.global:hover {
    border-color: var(--dp-info);
    background: rgba(59, 130, 246, 0.03);
}

.status-card.global.selected {
    border-color: var(--dp-info);
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.08) 0%, rgba(59, 130, 246, 0.02) 100%);
    box-shadow: 0 4px 20px rgba(59, 130, 246, 0.2);
}

.status-card.global.selected::before {
    background: linear-gradient(90deg, var(--dp-info) 0%, #60a5fa 100%);
}

.status-card.global .status-card-icon {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(59, 130, 246, 0.05) 100%);
    color: var(--dp-info);
}

.status-card.global.selected .status-card-icon {
    background: linear-gradient(135deg, var(--dp-info) 0%, #2563eb 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
}

/* Entreprise Card Styling */
.status-card.entreprise {
    border-color: rgba(139, 92, 246, 0.3);
}

.status-card.entreprise:hover {
    border-color: var(--dp-purple);
    background: rgba(139, 92, 246, 0.03);
}

.status-card.entreprise.selected {
    border-color: var(--dp-purple);
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.08) 0%, rgba(139, 92, 246, 0.02) 100%);
    box-shadow: 0 4px 20px rgba(139, 92, 246, 0.2);
}

.status-card.entreprise.selected::before {
    background: linear-gradient(90deg, var(--dp-purple) 0%, #a78bfa 100%);
}

.status-card.entreprise .status-card-icon {
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.15) 0%, rgba(139, 92, 246, 0.05) 100%);
    color: var(--dp-purple);
}

.status-card.entreprise.selected .status-card-icon {
    background: linear-gradient(135deg, var(--dp-purple) 0%, #7c3aed 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(139, 92, 246, 0.4);
}

/* Status Card Icon */
.status-card-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.status-card-icon svg {
    width: 24px;
    height: 24px;
}

/* Status Card Content */
.status-card-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.status-card-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--dp-text-primary);
    transition: color 0.3s ease;
}

.status-card-desc {
    font-size: 0.75rem;
    color: var(--dp-text-secondary);
    font-weight: 500;
}

/* Status Card Check */
.status-card-check {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: var(--dp-card-border);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    opacity: 0;
    transform: scale(0.5);
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.status-card-check svg {
    width: 14px;
    height: 14px;
    color: white;
}

.status-card.selected .status-card-check {
    opacity: 1;
    transform: scale(1);
}

.status-card.global.selected .status-card-check {
    background: linear-gradient(135deg, var(--dp-info) 0%, #2563eb 100%);
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.4);
}

.status-card.entreprise.selected .status-card-check {
    background: linear-gradient(135deg, var(--dp-purple) 0%, #7c3aed 100%);
    box-shadow: 0 2px 8px rgba(139, 92, 246, 0.4);
}

/* Entreprise Select Group */
.entreprise-select-group {
    margin-top: 1rem;
    padding: 1rem;
    background: var(--dp-bg);
    border-radius: 10px;
    border: 1px solid var(--dp-card-border);
    transition: all 0.3s ease;
}

.entreprise-select-group.disabled {
    opacity: 0.5;
    pointer-events: none;
}

/* Modal Footer */
.modal-footer {
    padding: 1rem 1.25rem;
    background: var(--dp-bg);
    border-top: 1px solid var(--dp-card-border);
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
    flex-shrink: 0;
}

.btn-cancel {
    padding: 0.625rem 1.25rem;
    background: transparent;
    color: var(--dp-text-secondary);
    border: 1.5px solid var(--dp-card-border);
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.8125rem;
    cursor: pointer;
    transition: all 0.25s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-cancel svg {
    width: 16px;
    height: 16px;
    transition: transform 0.25s ease;
}

.btn-cancel:hover {
    background: rgba(239, 68, 68, 0.08);
    border-color: var(--dp-danger);
    color: var(--dp-danger);
}

.btn-cancel:hover svg {
    transform: rotate(90deg);
}

.btn-submit {
    padding: 0.625rem 1.5rem;
    background: linear-gradient(135deg, var(--dp-accent) 0%, #e67e00 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.8125rem;
    cursor: pointer;
    transition: all 0.25s ease;
    box-shadow: 0 4px 12px rgba(255, 149, 0, 0.3);
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-submit svg {
    width: 16px;
    height: 16px;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(255, 149, 0, 0.4);
}

.btn-submit:active {
    transform: translateY(-1px);
}

.btn-submit:disabled {
    opacity: 0.7;
    cursor: wait;
    transform: none;
}

/* Loading Animation */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.animate-spin {
    animation: spin 1s linear infinite;
}

@media (max-width: 500px) {
    .status-cards {
        grid-template-columns: 1fr;
    }
}

/* ========================================
   RESPONSIVE
   ======================================== */
@media (max-width: 1024px) {
    .dp-grid {
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    }
}

@media (max-width: 768px) {
    .departements-page {
        padding: 1rem;
    }

    .dp-header {
        padding: 1.5rem;
    }

    .dp-header-content {
        flex-direction: column;
    }

    .dp-header-left h1 {
        font-size: 1.375rem;
    }

    .dp-stats-row {
        grid-template-columns: repeat(2, 1fr);
    }

    .dp-filters {
        flex-direction: column;
        align-items: stretch;
    }

    .dp-search-box {
        max-width: 100%;
    }

    .dp-grid {
        grid-template-columns: 1fr;
    }

    .dp-table th,
    .dp-table td {
        padding: 0.75rem 1rem;
    }

    .dp-card-meta {
        flex-direction: column;
    }
}

@media (max-width: 480px) {
    .dp-stats-row {
        grid-template-columns: 1fr;
    }

    .dp-card-footer {
        flex-direction: column;
        gap: 0.75rem;
    }

    .dp-card-actions {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endsection

@section('content')
<div class="departements-page">
    <!-- Alerts -->
    @if(session('success'))
    <div class="dp-alert dp-alert-success">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
        </svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="dp-alert dp-alert-error">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="15" y1="9" x2="9" y2="15"></line>
            <line x1="9" y1="9" x2="15" y2="15"></line>
        </svg>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <!-- Header Premium -->
    <div class="dp-header">
        <div class="dp-header-content">
            <div class="dp-header-left">
                <h1>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Gestion des Départements
                </h1>
                <p>Organisez et gérez la structure départementale de votre entreprise</p>
            </div>
            <div class="dp-header-actions">
                <div class="dp-view-toggle">
                    <button type="button" class="dp-btn-icon active" id="viewGrid" title="Vue grille" onclick="toggleView('grid')">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                        </svg>
                    </button>
                    <button type="button" class="dp-btn-icon" id="viewTable" title="Vue tableau" onclick="toggleView('table')">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="8" y1="6" x2="21" y2="6"></line>
                            <line x1="8" y1="12" x2="21" y2="12"></line>
                            <line x1="8" y1="18" x2="21" y2="18"></line>
                            <line x1="3" y1="6" x2="3.01" y2="6"></line>
                            <line x1="3" y1="12" x2="3.01" y2="12"></line>
                            <line x1="3" y1="18" x2="3.01" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <button type="button" class="dp-btn dp-btn-primary" onclick="openCreateModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Nouveau Département
                </button>
            </div>
        </div>

        <!-- Stats -->
        <div class="dp-stats-row">
            <div class="dp-stat-card" style="--stat-color: var(--dp-primary);">
                <div class="dp-stat-icon blue">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="dp-stat-info">
                    <h4>{{ $departements->count() }}</h4>
                    <p>Total départements</p>
                </div>
            </div>
            <div class="dp-stat-card" style="--stat-color: var(--dp-success);">
                <div class="dp-stat-icon green">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
                <div class="dp-stat-info">
                    <h4>{{ $departements->where('is_active', true)->count() }}</h4>
                    <p>Actifs</p>
                </div>
            </div>
            <div class="dp-stat-card" style="--stat-color: var(--dp-info);">
                <div class="dp-stat-icon orange">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="2" y1="12" x2="22" y2="12"></line>
                        <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                    </svg>
                </div>
                <div class="dp-stat-info">
                    <h4>{{ $departements->where('is_global', true)->count() }}</h4>
                    <p>Globaux</p>
                </div>
            </div>
            <div class="dp-stat-card" style="--stat-color: var(--dp-purple);">
                <div class="dp-stat-icon purple">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="8.5" cy="7" r="4"></circle>
                        <line x1="20" y1="8" x2="20" y2="14"></line>
                        <line x1="23" y1="11" x2="17" y2="11"></line>
                    </svg>
                </div>
                <div class="dp-stat-info">
                    <h4>{{ $departements->sum(fn($d) => $d->services->count()) }}</h4>
                    <p>Services liés</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="dp-filters">
        <form action="{{ route('admin.departements.index') }}" method="GET" class="dp-search-box">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un département...">
        </form>

        <div class="dp-filter-chips">
            <button type="button" class="dp-chip {{ !request('filter') ? 'active' : '' }}" onclick="filterDepartements('')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
                Tous
            </button>
            <button type="button" class="dp-chip {{ request('filter') === 'global' ? 'active' : '' }}" onclick="filterDepartements('global')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="2" y1="12" x2="22" y2="12"></line>
                </svg>
                Globaux
            </button>
            <button type="button" class="dp-chip {{ request('filter') === 'active' ? 'active' : '' }}" onclick="filterDepartements('active')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                Actifs
            </button>
        </div>
    </div>

    @if($departements->count() > 0)
        <!-- Vue Grille -->
        <div class="dp-grid" id="gridView">
            @foreach($departements as $departement)
            <div class="dp-card" style="--card-color: {{ $departement->is_global ? 'var(--dp-info)' : 'var(--dp-primary)' }};">
                <div class="dp-card-header">
                    <div class="dp-card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="dp-card-title-section">
                        <h3 class="dp-card-title">{{ $departement->nom }}</h3>
                        @if($departement->code)
                        <span class="dp-card-code">{{ $departement->code }}</span>
                        @endif
                    </div>
                </div>

                <div class="dp-card-body">
                    @if($departement->description)
                    <p class="dp-card-description">{{ $departement->description }}</p>
                    @else
                    <p class="dp-card-description" style="font-style: italic; opacity: 0.7;">Aucune description</p>
                    @endif

                    <div class="dp-card-meta">
                        <div class="dp-meta-item">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="8.5" cy="7" r="4"></circle>
                                <line x1="20" y1="8" x2="20" y2="14"></line>
                                <line x1="23" y1="11" x2="17" y2="11"></line>
                            </svg>
                            <strong>{{ $departement->services->count() }}</strong> service(s)
                        </div>
                    </div>

                    <div class="dp-card-badges">
                        @if($departement->is_global)
                        <span class="dp-badge dp-badge-global">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="2" y1="12" x2="22" y2="12"></line>
                            </svg>
                            Global
                        </span>
                        @else
                        <span class="dp-badge dp-badge-entreprise">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            </svg>
                            Entreprise
                        </span>
                        @endif

                        @if($departement->is_active)
                        <span class="dp-badge dp-badge-active">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            Actif
                        </span>
                        @else
                        <span class="dp-badge dp-badge-inactive">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                            Inactif
                        </span>
                        @endif
                    </div>
                </div>

                <div class="dp-card-footer">
                    <div class="dp-card-entreprise">
                        @if($departement->is_global)
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="2" y1="12" x2="22" y2="12"></line>
                        </svg>
                        <span>Toutes les entreprises</span>
                        @elseif($departement->entreprise)
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        </svg>
                        <span>{{ $departement->entreprise->nom }}</span>
                        @else
                        <span style="color: var(--dp-text-muted);">—</span>
                        @endif
                    </div>
                    <div class="dp-card-actions">
                        <a href="{{ route('admin.departements.show', $departement->id) }}" class="dp-action-btn view" title="Voir les détails">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </a>
                        <a href="{{ route('admin.departements.edit', $departement->id) }}" class="dp-action-btn edit" title="Modifier">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </a>
                        <form action="{{ route('admin.departements.destroy', $departement->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce département ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dp-action-btn delete" title="Supprimer">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Vue Tableau -->
        <div class="dp-table-section" id="tableView">
            <div class="dp-table-header">
                <h3>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Liste des départements
                </h3>
                <span class="dp-table-count">{{ $departements->count() }} département(s)</span>
            </div>
            <div style="overflow-x: auto;">
                <table class="dp-table">
                    <thead>
                        <tr>
                            <th>Département</th>
                            <th>Code</th>
                            <th>Entreprise</th>
                            <th>Services</th>
                            <th>Type</th>
                            <th>Statut</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($departements as $departement)
                        <tr>
                            <td>
                                <div class="dp-table-name">
                                    <div class="dp-table-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="dp-table-name-content">
                                        <h4>{{ $departement->nom }}</h4>
                                        @if($departement->description)
                                        <p>{{ Str::limit($departement->description, 40) }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($departement->code)
                                <span class="dp-table-code">{{ $departement->code }}</span>
                                @else
                                <span style="color: var(--dp-text-muted);">—</span>
                                @endif
                            </td>
                            <td>
                                @if($departement->is_global)
                                <span class="dp-badge dp-badge-global">Global</span>
                                @elseif($departement->entreprise)
                                {{ $departement->entreprise->nom }}
                                @else
                                <span style="color: var(--dp-text-muted);">—</span>
                                @endif
                            </td>
                            <td>
                                <div class="dp-table-services">
                                    <span class="dp-table-services-count">{{ $departement->services->count() }}</span>
                                </div>
                            </td>
                            <td>
                                @if($departement->is_global)
                                <span class="dp-badge dp-badge-global">Global</span>
                                @else
                                <span class="dp-badge dp-badge-entreprise">Entreprise</span>
                                @endif
                            </td>
                            <td>
                                @if($departement->is_active)
                                <span class="dp-badge dp-badge-active">Actif</span>
                                @else
                                <span class="dp-badge dp-badge-inactive">Inactif</span>
                                @endif
                            </td>
                            <td>
                                <div class="dp-table-actions">
                                    <a href="{{ route('admin.departements.show', $departement->id) }}" class="dp-action-btn view" title="Voir">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.departements.edit', $departement->id) }}" class="dp-action-btn edit" title="Modifier">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.departements.destroy', $departement->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Supprimer ce département ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dp-action-btn delete" title="Supprimer">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="dp-empty">
            <div class="dp-empty-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h3>Aucun département enregistré</h3>
            <p>Commencez par créer votre premier département pour organiser la structure de votre entreprise.</p>
            <a href="{{ route('admin.departements.create') }}" class="dp-btn dp-btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Créer un département
            </a>
        </div>
    @endif
</div>

<!-- Modal Création Département -->
<div class="modal-overlay" id="createModal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-header-content">
                <div class="modal-header-left">
                    <div class="modal-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </div>
                    <div class="modal-header-text">
                        <h2>Nouveau Département</h2>
                        <p>Créer un nouveau département dans l'organisation</p>
                    </div>
                </div>
                <button type="button" class="modal-close" onclick="closeCreateModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
        </div>

        <form action="{{ route('admin.departements.store') }}" method="POST" id="createForm">
            @csrf
            <div class="modal-body">
                <!-- Section Informations générales -->
                <div class="form-section">
                    <div class="form-section-header">
                        <div class="form-section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="form-section-title">Informations générales</h3>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label required">Nom du département</label>
                            <input type="text" name="nom" class="form-input" placeholder="Ex: Ressources Humaines" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Code</label>
                            <input type="text" name="code" class="form-input" placeholder="Ex: RH, TECH, FIN">
                        </div>
                        <div class="form-group full-width">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-input" rows="3" placeholder="Décrivez les responsabilités et missions du département..."></textarea>
                        </div>
                    </div>
                </div>

                @if(auth()->user()->role === 'super_admin')
                <!-- Section Type de département -->
                <div class="form-section">
                    <div class="form-section-header">
                        <div class="form-section-icon purple">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="2" y1="12" x2="22" y2="12"></line>
                                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                            </svg>
                        </div>
                        <h3 class="form-section-title">Type de département</h3>
                    </div>

                    <input type="hidden" name="is_global" id="is_global" value="0">

                    <div class="status-cards">
                        <div class="status-card global" data-type="global" onclick="selectDepartmentType('global')">
                            <div class="status-card-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="2" y1="12" x2="22" y2="12"></line>
                                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                                </svg>
                            </div>
                            <div class="status-card-content">
                                <span class="status-card-title">Global</span>
                                <span class="status-card-desc">Disponible pour toutes les entreprises</span>
                            </div>
                            <div class="status-card-check">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                        </div>

                        <div class="status-card entreprise selected" data-type="entreprise" onclick="selectDepartmentType('entreprise')">
                            <div class="status-card-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                            </div>
                            <div class="status-card-content">
                                <span class="status-card-title">Entreprise</span>
                                <span class="status-card-desc">Lié à une entreprise spécifique</span>
                            </div>
                            <div class="status-card-check">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Sélection d'entreprise -->
                    <div class="entreprise-select-group" id="entrepriseGroup">
                        <label class="form-label">Entreprise associée</label>
                        <select name="entreprise_id" class="form-input" id="entrepriseSelect">
                            <option value="">-- Sélectionner une entreprise --</option>
                            @foreach(\App\Models\Entreprise::where('is_active', true)->orderBy('nom')->get() as $entreprise)
                            <option value="{{ $entreprise->id }}">{{ $entreprise->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @endif
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeCreateModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                    Annuler
                </button>
                <button type="submit" class="btn-submit" id="submitBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    Créer le département
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Toggle View
function toggleView(view) {
    const gridView = document.getElementById('gridView');
    const tableView = document.getElementById('tableView');
    const btnGrid = document.getElementById('viewGrid');
    const btnTable = document.getElementById('viewTable');

    if (view === 'grid') {
        gridView.style.display = 'grid';
        tableView.classList.remove('active');
        btnGrid.classList.add('active');
        btnTable.classList.remove('active');
        localStorage.setItem('departements_view', 'grid');
    } else {
        gridView.style.display = 'none';
        tableView.classList.add('active');
        btnTable.classList.add('active');
        btnGrid.classList.remove('active');
        localStorage.setItem('departements_view', 'table');
    }
}

// Filter departements
function filterDepartements(filter) {
    const url = new URL(window.location.href);
    if (filter) {
        url.searchParams.set('filter', filter);
    } else {
        url.searchParams.delete('filter');
    }
    window.location.href = url.toString();
}

// Restore view preference
document.addEventListener('DOMContentLoaded', function() {
    const savedView = localStorage.getItem('departements_view');
    if (savedView === 'table') {
        toggleView('table');
    }
});

// Search on enter
document.querySelector('.dp-search-box input')?.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        this.closest('form').submit();
    }
});

// Modal functions
function openCreateModal() {
    const modal = document.getElementById('createModal');
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';

    // Focus first input
    setTimeout(() => {
        modal.querySelector('input[name="nom"]')?.focus();
    }, 100);
}

function closeCreateModal() {
    const modal = document.getElementById('createModal');
    modal.classList.remove('show');
    document.body.style.overflow = '';

    // Reset form
    document.getElementById('createForm')?.reset();

    // Reset type selection to entreprise by default
    selectDepartmentType('entreprise');
}

// Select department type (Global or Entreprise)
function selectDepartmentType(type) {
    const globalCard = document.querySelector('.status-card.global');
    const entrepriseCard = document.querySelector('.status-card.entreprise');
    const isGlobalInput = document.getElementById('is_global');
    const entrepriseGroup = document.getElementById('entrepriseGroup');

    if (type === 'global') {
        // Select Global
        globalCard?.classList.add('selected');
        entrepriseCard?.classList.remove('selected');
        if (isGlobalInput) isGlobalInput.value = '1';
        if (entrepriseGroup) {
            entrepriseGroup.classList.add('disabled');
            document.getElementById('entrepriseSelect').value = '';
        }
    } else {
        // Select Entreprise
        entrepriseCard?.classList.add('selected');
        globalCard?.classList.remove('selected');
        if (isGlobalInput) isGlobalInput.value = '0';
        if (entrepriseGroup) {
            entrepriseGroup.classList.remove('disabled');
        }
    }
}

// Close modal on overlay click
document.getElementById('createModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeCreateModal();
    }
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCreateModal();
    }
});

// Form submission with loading state
document.getElementById('createForm')?.addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<svg class="animate-spin" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Création...';
});
</script>
@endsection
