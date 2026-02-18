@extends('layouts.app')

@section('title', 'Gestion des Congés')
@section('page-title', 'Gestion des Congés')
@section('page-subtitle', 'Suivi et validation des demandes de congés')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
    <line x1="16" y1="2" x2="16" y2="6"></line>
    <line x1="8" y1="2" x2="8" y2="6"></line>
    <line x1="3" y1="10" x2="21" y2="10"></line>
</svg>
@endsection

@section('styles')
<style>
/* ========================================
   VARIABLES - Charte RH+
   ======================================== */
:root {
    --cg-primary: #4A90D9;
    --cg-primary-dark: #2E6BB3;
    --cg-primary-light: #E8F4FD;
    --cg-accent: #FF9500;
    --cg-accent-light: #FFF7ED;
    --cg-success: #22C55E;
    --cg-success-light: #F0FDF4;
    --cg-danger: #EF4444;
    --cg-danger-light: #FEF2F2;
    --cg-warning: #F59E0B;
    --cg-warning-light: #FFFBEB;
    --cg-bg: #f8fafc;
    --cg-card-bg: #ffffff;
    --cg-card-border: #e2e8f0;
    --cg-text-primary: #1e293b;
    --cg-text-secondary: #64748b;
    --cg-text-muted: #94a3b8;
    --cg-shadow: rgba(0, 0, 0, 0.04);
    --cg-shadow-lg: rgba(0, 0, 0, 0.08);
    --cg-radius: 12px;
    --cg-radius-lg: 16px;
}

.dark {
    --cg-bg: #0f172a;
    --cg-card-bg: #1e293b;
    --cg-card-border: #334155;
    --cg-text-primary: #f1f5f9;
    --cg-text-secondary: #94a3b8;
    --cg-text-muted: #64748b;
    --cg-shadow: rgba(0, 0, 0, 0.3);
    --cg-shadow-lg: rgba(0, 0, 0, 0.5);
    --cg-primary-light: rgba(74, 144, 217, 0.15);
    --cg-accent-light: rgba(255, 149, 0, 0.15);
    --cg-success-light: rgba(34, 197, 94, 0.15);
    --cg-danger-light: rgba(239, 68, 68, 0.15);
    --cg-warning-light: rgba(245, 158, 11, 0.15);
}

/* BASE */
.conges-page {
    padding: 1.5rem;
    max-width: 1400px;
    margin: 0 auto;
}

/* STATS ROW */
.cg-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.25rem;
    margin-bottom: 1.5rem;
}

.cg-stat-card {
    background: var(--cg-card-bg);
    border: 1px solid var(--cg-card-border);
    border-radius: var(--cg-radius-lg);
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 1px 3px var(--cg-shadow);
    transition: all 0.2s ease;
    position: relative;
    overflow: hidden;
}

.cg-stat-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
}
.cg-stat-card.total::before { background: var(--cg-primary); }
.cg-stat-card.pending::before { background: var(--cg-warning); }
.cg-stat-card.approved::before { background: var(--cg-success); }
.cg-stat-card.rejected::before { background: var(--cg-danger); }

.cg-stat-icon {
    width: 48px; height: 48px;
    border-radius: var(--cg-radius);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.cg-stat-icon svg { width: 24px; height: 24px; }
.cg-stat-icon.total { background: var(--cg-primary-light); color: var(--cg-primary); }
.cg-stat-icon.pending { background: var(--cg-warning-light); color: var(--cg-warning); }
.cg-stat-icon.approved { background: var(--cg-success-light); color: var(--cg-success); }
.cg-stat-icon.rejected { background: var(--cg-danger-light); color: var(--cg-danger); }

.cg-stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--cg-text-primary);
    line-height: 1;
}
.cg-stat-label {
    font-size: 0.8125rem;
    color: var(--cg-text-secondary);
    margin-top: 0.25rem;
}

/* FILTERS */
.cg-filters {
    background: var(--cg-card-bg);
    border: 1px solid var(--cg-card-border);
    border-radius: var(--cg-radius-lg);
    padding: 1.25rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
    box-shadow: 0 1px 3px var(--cg-shadow);
}

.cg-filter-group {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.cg-filter-label {
    font-size: 0.8125rem;
    font-weight: 600;
    color: var(--cg-text-secondary);
    white-space: nowrap;
}

.cg-filter-select, .cg-filter-input {
    padding: 0.5rem 0.875rem;
    background: var(--cg-bg);
    border: 1px solid var(--cg-card-border);
    border-radius: 8px;
    font-size: 0.875rem;
    color: var(--cg-text-primary);
    min-width: 140px;
}
.cg-filter-select:focus, .cg-filter-input:focus {
    outline: none;
    border-color: var(--cg-primary);
}

.cg-filter-btn {
    padding: 0.5rem 1rem;
    background: var(--cg-primary);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.375rem;
    transition: all 0.2s;
}
.cg-filter-btn:hover { opacity: 0.9; }
.cg-filter-btn svg { width: 16px; height: 16px; }

.cg-filter-reset {
    padding: 0.5rem 1rem;
    background: transparent;
    color: var(--cg-text-secondary);
    border: 1px solid var(--cg-card-border);
    border-radius: 8px;
    font-size: 0.875rem;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s;
}
.cg-filter-reset:hover { border-color: var(--cg-text-secondary); color: var(--cg-text-primary); }

/* TABLE */
.cg-table-card {
    background: var(--cg-card-bg);
    border: 1px solid var(--cg-card-border);
    border-radius: var(--cg-radius-lg);
    overflow: hidden;
    box-shadow: 0 1px 3px var(--cg-shadow);
}

.cg-table-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.25rem;
    border-bottom: 1px solid var(--cg-card-border);
}

.cg-table-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--cg-text-primary);
}

.cg-table-count {
    font-size: 0.8125rem;
    color: var(--cg-text-secondary);
    background: var(--cg-bg);
    padding: 0.375rem 0.75rem;
    border-radius: 20px;
}

.cg-table-wrap {
    overflow-x: auto;
}

.cg-table {
    width: 100%;
    border-collapse: collapse;
}

.cg-table th {
    padding: 0.875rem 1.25rem;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--cg-text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background: var(--cg-bg);
    border-bottom: 1px solid var(--cg-card-border);
    white-space: nowrap;
}

.cg-table td {
    padding: 1rem 1.25rem;
    font-size: 0.9375rem;
    color: var(--cg-text-primary);
    border-bottom: 1px solid var(--cg-card-border);
    vertical-align: middle;
}

.cg-table tr:last-child td { border-bottom: none; }
.cg-table tr:hover td { background: var(--cg-bg); }

/* Employee Cell */
.cg-employee {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.cg-employee-avatar {
    width: 40px; height: 40px;
    border-radius: 10px;
    object-fit: cover;
    background: var(--cg-primary-light);
    border: 2px solid var(--cg-card-border);
}

.cg-employee-name {
    font-weight: 600;
    color: var(--cg-text-primary);
    font-size: 0.9375rem;
}

.cg-employee-matricule {
    font-size: 0.75rem;
    color: var(--cg-text-muted);
}

/* Type Badge */
.cg-type-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.75rem;
    border-radius: 8px;
    font-size: 0.8125rem;
    font-weight: 600;
    white-space: nowrap;
}

/* Status Badge */
.cg-status {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    white-space: nowrap;
}
.cg-status svg { width: 12px; height: 12px; }
.cg-status.en_attente { background: var(--cg-warning-light); color: #b45309; }
.cg-status.valide_chef { background: #dbeafe; color: #1d4ed8; }
.dark .cg-status.valide_chef { background: rgba(59,130,246,0.18); color: #60a5fa; }
.cg-status.approuve { background: var(--cg-success-light); color: #15803d; }
.cg-status.refuse { background: var(--cg-danger-light); color: #b91c1c; }
.cg-status.annule { background: #f1f5f9; color: #64748b; }

/* Date cell */
.cg-dates { white-space: nowrap; font-size: 0.875rem; }
.cg-dates-range { color: var(--cg-text-primary); font-weight: 500; }
.cg-dates-days {
    font-size: 0.75rem;
    color: var(--cg-text-muted);
    margin-top: 0.125rem;
}

/* Actions */
.cg-actions {
    display: flex;
    gap: 0.5rem;
}

.cg-btn {
    padding: 0.5rem 0.875rem;
    border: none;
    border-radius: 8px;
    font-size: 0.8125rem;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    transition: all 0.2s;
    white-space: nowrap;
}
.cg-btn svg { width: 14px; height: 14px; }
.cg-btn-approve { background: var(--cg-success-light); color: #15803d; }
.cg-btn-approve:hover { background: var(--cg-success); color: white; }
.cg-btn-reject { background: var(--cg-danger-light); color: #b91c1c; }
.cg-btn-reject:hover { background: var(--cg-danger); color: white; }
.cg-btn-detail { background: var(--cg-bg); color: var(--cg-text-secondary); border: 1px solid var(--cg-card-border); }
.cg-btn-detail:hover { border-color: var(--cg-primary); color: var(--cg-primary); }

/* EMPTY */
.cg-empty {
    text-align: center;
    padding: 4rem 2rem;
}
.cg-empty-icon {
    width: 64px; height: 64px; margin: 0 auto 1rem;
    background: var(--cg-bg); border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: var(--cg-text-muted);
}
.cg-empty-icon svg { width: 32px; height: 32px; }
.cg-empty-title {
    font-size: 1.125rem; font-weight: 700;
    color: var(--cg-text-primary); margin-bottom: 0.5rem;
}
.cg-empty-text { font-size: 0.875rem; color: var(--cg-text-secondary); }

/* PAGINATION */
.cg-pagination {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1.25rem;
    gap: 0.25rem;
}
.cg-pagination a, .cg-pagination span {
    padding: 0.5rem 0.875rem;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    color: var(--cg-text-secondary);
    transition: all 0.2s;
}
.cg-pagination a:hover { background: var(--cg-primary-light); color: var(--cg-primary); }
.cg-pagination .active span { background: var(--cg-primary); color: white; }
.cg-pagination .disabled span { opacity: 0.4; cursor: default; }

/* MODAL */
.cg-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.5);
    z-index: 1000;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}
.cg-modal-overlay.active { display: flex; }

.cg-modal {
    background: var(--cg-card-bg);
    border-radius: var(--cg-radius-lg);
    width: 100%;
    max-width: 480px;
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
    overflow: hidden;
}

.cg-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.25rem;
    border-bottom: 1px solid var(--cg-card-border);
}

.cg-modal-title {
    font-size: 1.0625rem;
    font-weight: 700;
    color: var(--cg-text-primary);
}

.cg-modal-close {
    width: 32px; height: 32px;
    border-radius: 8px; border: none;
    background: var(--cg-bg);
    cursor: pointer; display: flex;
    align-items: center; justify-content: center;
    color: var(--cg-text-secondary);
    transition: all 0.2s;
}
.cg-modal-close:hover { background: var(--cg-card-border); color: var(--cg-text-primary); }
.cg-modal-close svg { width: 18px; height: 18px; }

.cg-modal-body { padding: 1.25rem; }

.cg-modal-info {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.cg-modal-info-item {
    padding: 0.75rem;
    background: var(--cg-bg);
    border-radius: 8px;
}

.cg-modal-info-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--cg-text-muted);
    text-transform: uppercase;
    letter-spacing: 0.3px;
    margin-bottom: 0.25rem;
}

.cg-modal-info-value {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--cg-text-primary);
}

.cg-modal-motif {
    padding: 0.75rem;
    background: var(--cg-bg);
    border-radius: 8px;
    margin-bottom: 1rem;
}

.cg-modal-motif-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--cg-text-muted);
    text-transform: uppercase;
    letter-spacing: 0.3px;
    margin-bottom: 0.25rem;
}

.cg-modal-motif-text {
    font-size: 0.9375rem;
    color: var(--cg-text-primary);
    line-height: 1.5;
}

.cg-reject-form-group {
    margin-bottom: 1rem;
}

.cg-reject-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--cg-text-primary);
    margin-bottom: 0.5rem;
}

.cg-reject-textarea {
    width: 100%;
    padding: 0.75rem;
    background: var(--cg-bg);
    border: 1px solid var(--cg-card-border);
    border-radius: 8px;
    font-size: 0.9375rem;
    color: var(--cg-text-primary);
    resize: vertical;
    min-height: 80px;
    box-sizing: border-box;
}
.cg-reject-textarea:focus { outline: none; border-color: var(--cg-danger); }

.cg-modal-footer {
    padding: 1.25rem;
    border-top: 1px solid var(--cg-card-border);
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
}

.cg-modal-btn-cancel {
    padding: 0.625rem 1.25rem;
    background: var(--cg-bg);
    border: 1px solid var(--cg-card-border);
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--cg-text-secondary);
    cursor: pointer;
}

.cg-modal-btn-confirm {
    padding: 0.625rem 1.25rem;
    border: none;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    color: white;
    cursor: pointer;
    transition: opacity 0.2s;
}
.cg-modal-btn-confirm:hover { opacity: 0.9; }
.cg-modal-btn-confirm.approve { background: var(--cg-success); }
.cg-modal-btn-confirm.reject { background: var(--cg-danger); }

/* Flash */
.cg-flash {
    padding: 1rem 1.25rem;
    border-radius: var(--cg-radius);
    font-size: 0.9375rem;
    font-weight: 500;
    margin-bottom: 1.25rem;
}
.cg-flash-success { background: var(--cg-success-light); color: #065f46; border: 1px solid #a7f3d0; }
.cg-flash-error { background: var(--cg-danger-light); color: #991b1b; border: 1px solid #fecaca; }

/* RESPONSIVE */
@media (max-width: 1024px) {
    .cg-stats { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .conges-page { padding: 1rem; }
    .cg-stats { grid-template-columns: 1fr; }
    .cg-filters { flex-direction: column; align-items: stretch; }
    .cg-table-wrap { font-size: 0.875rem; }
    .cg-actions { flex-direction: column; }
}
</style>
@endsection

@section('content')
<div class="conges-page">
    {{-- Flash --}}
    @if(session('success'))
        <div class="cg-flash cg-flash-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="cg-flash cg-flash-error">{{ session('error') }}</div>
    @endif

    {{-- Stats --}}
    <div class="cg-stats" style="grid-template-columns: repeat(5, 1fr);">
        <div class="cg-stat-card total">
            <div class="cg-stat-icon total">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
            </div>
            <div>
                <div class="cg-stat-value">{{ $stats['total'] }}</div>
                <div class="cg-stat-label">Total</div>
            </div>
        </div>
        <div class="cg-stat-card pending">
            <div class="cg-stat-icon pending">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </div>
            <div>
                <div class="cg-stat-value">{{ $stats['en_attente'] }}</div>
                <div class="cg-stat-label">En attente</div>
            </div>
        </div>
        <div class="cg-stat-card" style="border-top: none; position:relative; overflow:hidden;">
            <div style="position:absolute;top:0;left:0;right:0;height:3px;background:#3b82f6;"></div>
            <div class="cg-stat-icon" style="background:#dbeafe;color:#1d4ed8;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 12l2 2 4-4"></path>
                    <circle cx="12" cy="12" r="10"></circle>
                </svg>
            </div>
            <div>
                <div class="cg-stat-value">{{ $stats['valide_chef'] }}</div>
                <div class="cg-stat-label">Valid&eacute; Chef</div>
            </div>
        </div>
        <div class="cg-stat-card approved">
            <div class="cg-stat-icon approved">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <div>
                <div class="cg-stat-value">{{ $stats['approuve'] }}</div>
                <div class="cg-stat-label">Approuv&eacute;es</div>
            </div>
        </div>
        <div class="cg-stat-card rejected">
            <div class="cg-stat-icon rejected">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
            </div>
            <div>
                <div class="cg-stat-value">{{ $stats['refuse'] }}</div>
                <div class="cg-stat-label">Refus&eacute;es</div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <form class="cg-filters" method="GET" action="{{ route('admin.conges.index') }}">
        <div class="cg-filter-group">
            <span class="cg-filter-label">Statut</span>
            <select name="statut" class="cg-filter-select">
                <option value="">Tous</option>
                <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                <option value="valide_chef" {{ request('statut') === 'valide_chef' ? 'selected' : '' }}>Valid&eacute; Chef</option>
                <option value="approuve" {{ request('statut') === 'approuve' ? 'selected' : '' }}>Approuv&eacute;</option>
                <option value="refuse" {{ request('statut') === 'refuse' ? 'selected' : '' }}>Refus&eacute;</option>
                <option value="annule" {{ request('statut') === 'annule' ? 'selected' : '' }}>Annul&eacute;</option>
            </select>
        </div>
        <div class="cg-filter-group">
            <span class="cg-filter-label">Ann&eacute;e</span>
            <select name="annee" class="cg-filter-select">
                @foreach($anneesDisponibles as $a)
                    <option value="{{ $a }}" {{ request('annee', date('Y')) == $a ? 'selected' : '' }}>{{ $a }}</option>
                @endforeach
            </select>
        </div>
        <div class="cg-filter-group">
            <input type="text" name="search" class="cg-filter-input" placeholder="Nom ou matricule..." value="{{ request('search') }}">
        </div>
        <button type="submit" class="cg-filter-btn">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            Filtrer
        </button>
        <a href="{{ route('admin.conges.index') }}" class="cg-filter-reset">R&eacute;initialiser</a>
    </form>

    {{-- Table --}}
    <div class="cg-table-card">
        <div class="cg-table-header">
            <h2 class="cg-table-title">Demandes de cong&eacute;s</h2>
            <span class="cg-table-count">{{ $conges->total() }} r&eacute;sultat{{ $conges->total() > 1 ? 's' : '' }}</span>
        </div>

        @if($conges->count() > 0)
            <div class="cg-table-wrap">
                <table class="cg-table">
                    <thead>
                        <tr>
                            <th>Employ&eacute;</th>
                            <th>Type</th>
                            <th>P&eacute;riode</th>
                            <th>Statut</th>
                            <th>Date demande</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($conges as $conge)
                            <tr>
                                <td>
                                    <div class="cg-employee">
                                        <img src="{{ $conge->personnel && $conge->personnel->photo ? asset('storage/' . $conge->personnel->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(($conge->personnel->prenoms ?? '') . ' ' . ($conge->personnel->nom ?? '')) . '&size=80&background=E8F4FD&color=4A90D9&bold=true' }}"
                                             alt="" class="cg-employee-avatar">
                                        <div>
                                            <div class="cg-employee-name">{{ $conge->personnel->prenoms ?? '' }} {{ $conge->personnel->nom ?? '' }}</div>
                                            <div class="cg-employee-matricule">{{ $conge->personnel->matricule ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="cg-type-badge" style="background: {{ $conge->typeConge->couleur ?? '#4A90D9' }}20; color: {{ $conge->typeConge->couleur ?? '#4A90D9' }};">
                                        {{ $conge->typeConge->nom ?? 'Cong&eacute;' }}
                                    </span>
                                    @if($conge->conge_parent_id)
                                        <span class="cg-type-badge" style="background: #dbeafe; color: #2563eb; margin-left: 0.25rem; font-size: 0.6875rem;">Prolongation</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="cg-dates">
                                        <div class="cg-dates-range">{{ $conge->date_debut->format('d/m/Y') }} &rarr; {{ $conge->date_fin->format('d/m/Y') }}</div>
                                        <div class="cg-dates-days">{{ $conge->nombre_jours }} {{ $conge->nombre_jours > 1 ? 'jours' : 'jour' }}</div>
                                    </div>
                                </td>
                                <td>
                                    <span class="cg-status {{ $conge->statut }}">
                                        @switch($conge->statut)
                                            @case('en_attente')
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                                En attente
                                                @break
                                            @case('valide_chef')
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4"></path><circle cx="12" cy="12" r="10"></circle></svg>
                                                Valid&eacute; Chef
                                                @break
                                            @case('approuve')
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                Approuv&eacute;
                                                @break
                                            @case('refuse')
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                Refus&eacute;
                                                @break
                                            @case('annule')
                                                Annul&eacute;
                                                @break
                                        @endswitch
                                    </span>
                                </td>
                                <td style="font-size: 0.875rem; color: var(--cg-text-secondary);">
                                    {{ $conge->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td>
                                    <div class="cg-actions">
                                        @php $isChef = auth()->user()->hasRole("Chef d'Entreprise"); @endphp

                                        {{-- Étape 1 : Chef d'Entreprise voit bouton Valider pour en_attente --}}
                                        @if($isChef && $conge->statut === 'en_attente')
                                            <button class="cg-btn cg-btn-approve" onclick="openApproveModal({{ $conge->id }}, '{{ addslashes($conge->personnel->prenoms . ' ' . $conge->personnel->nom) }}', '{{ $conge->typeConge->nom ?? 'Congé' }}', '{{ $conge->date_debut->format('d/m/Y') }}', '{{ $conge->date_fin->format('d/m/Y') }}', {{ $conge->nombre_jours }}, true)">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4"></path><circle cx="12" cy="12" r="10"></circle></svg>
                                                Valider
                                            </button>
                                            <button class="cg-btn cg-btn-reject" onclick="openRejectModal({{ $conge->id }}, '{{ addslashes($conge->personnel->prenoms . ' ' . $conge->personnel->nom) }}')">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                Refuser
                                            </button>

                                        {{-- Étape 2 : Super Admin / RH voit Approuver pour en_attente et valide_chef --}}
                                        @elseif(!$isChef && in_array($conge->statut, ['en_attente', 'valide_chef']))
                                            <button class="cg-btn cg-btn-approve" onclick="openApproveModal({{ $conge->id }}, '{{ addslashes($conge->personnel->prenoms . ' ' . $conge->personnel->nom) }}', '{{ $conge->typeConge->nom ?? 'Congé' }}', '{{ $conge->date_debut->format('d/m/Y') }}', '{{ $conge->date_fin->format('d/m/Y') }}', {{ $conge->nombre_jours }}, false)">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                Approuver
                                            </button>
                                            <button class="cg-btn cg-btn-reject" onclick="openRejectModal({{ $conge->id }}, '{{ addslashes($conge->personnel->prenoms . ' ' . $conge->personnel->nom) }}')">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                Refuser
                                            </button>

                                        @else
                                            <button class="cg-btn cg-btn-detail" onclick="openDetailModal({{ $conge->id }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                                D&eacute;tail
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($conges->hasPages())
                <div class="cg-pagination">
                    {{ $conges->withQueryString()->links('pagination::bootstrap-4') }}
                </div>
            @endif
        @else
            <div class="cg-empty">
                <div class="cg-empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
                <h3 class="cg-empty-title">Aucune demande trouv&eacute;e</h3>
                <p class="cg-empty-text">Aucune demande de cong&eacute; ne correspond aux filtres s&eacute;lectionn&eacute;s.</p>
            </div>
        @endif
    </div>
</div>

{{-- Approve Modal --}}
<div class="cg-modal-overlay" id="approveModal">
    <div class="cg-modal">
        <div class="cg-modal-header">
            <h3 class="cg-modal-title" id="approveModalTitle">Approuver la demande</h3>
            <button class="cg-modal-close" onclick="closeModal('approveModal')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        <form id="approveForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="cg-modal-body">
                <div class="cg-modal-info">
                    <div class="cg-modal-info-item">
                        <div class="cg-modal-info-label">Employ&eacute;</div>
                        <div class="cg-modal-info-value" id="approveEmployee">-</div>
                    </div>
                    <div class="cg-modal-info-item">
                        <div class="cg-modal-info-label">Type</div>
                        <div class="cg-modal-info-value" id="approveType">-</div>
                    </div>
                    <div class="cg-modal-info-item">
                        <div class="cg-modal-info-label">P&eacute;riode</div>
                        <div class="cg-modal-info-value" id="approveDates">-</div>
                    </div>
                    <div class="cg-modal-info-item">
                        <div class="cg-modal-info-label">Dur&eacute;e</div>
                        <div class="cg-modal-info-value" id="approveDays">-</div>
                    </div>
                </div>

                <div class="cg-reject-form-group">
                    <label class="cg-reject-label">Document officiel (PDF)</label>
                    <input type="file" name="document_officiel" class="cg-reject-textarea" style="min-height: auto; padding: 0.5rem; cursor: pointer;" accept=".pdf">
                    <p style="font-size: 0.75rem; color: var(--cg-text-muted); margin-top: 0.375rem;">Note de cong&eacute; officielle &mdash; PDF, max 10 Mo. Ce document sera t&eacute;l&eacute;chargeable par l'employ&eacute;.</p>
                </div>

                <div class="cg-reject-form-group">
                    <label class="cg-reject-label">Commentaire (optionnel)</label>
                    <textarea name="commentaire_admin" class="cg-reject-textarea" placeholder="Commentaire pour l'employ&eacute;..." style="min-height: 60px;"></textarea>
                </div>

                <p style="font-size: 0.9375rem; color: var(--cg-text-secondary);">Confirmez-vous l'approbation de cette demande de cong&eacute; ?</p>
            </div>
            <div class="cg-modal-footer">
                <button type="button" class="cg-modal-btn-cancel" onclick="closeModal('approveModal')">Annuler</button>
                <button type="submit" class="cg-modal-btn-confirm approve" id="approveBtnLabel">Approuver</button>
            </div>
        </form>
    </div>
</div>

{{-- Reject Modal --}}
<div class="cg-modal-overlay" id="rejectModal">
    <div class="cg-modal">
        <div class="cg-modal-header">
            <h3 class="cg-modal-title">Refuser la demande</h3>
            <button class="cg-modal-close" onclick="closeModal('rejectModal')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="cg-modal-body">
                <p style="margin-bottom: 1rem; font-size: 0.9375rem; color: var(--cg-text-secondary);">
                    Refuser la demande de <strong id="rejectEmployee">-</strong> ?
                </p>
                <div class="cg-reject-form-group">
                    <label class="cg-reject-label">Motif du refus *</label>
                    <textarea name="motif_refus" class="cg-reject-textarea" placeholder="Indiquez la raison du refus..." required></textarea>
                </div>
            </div>
            <div class="cg-modal-footer">
                <button type="button" class="cg-modal-btn-cancel" onclick="closeModal('rejectModal')">Annuler</button>
                <button type="submit" class="cg-modal-btn-confirm reject">Refuser</button>
            </div>
        </form>
    </div>
</div>

{{-- Detail Modal --}}
<div class="cg-modal-overlay" id="detailModal">
    <div class="cg-modal">
        <div class="cg-modal-header">
            <h3 class="cg-modal-title">D&eacute;tail de la demande</h3>
            <button class="cg-modal-close" onclick="closeModal('detailModal')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        <div class="cg-modal-body" id="detailContent">
            <p style="text-align:center;color:var(--cg-text-muted);">Chargement...</p>
        </div>
        <div class="cg-modal-footer">
            <button type="button" class="cg-modal-btn-cancel" onclick="closeModal('detailModal')">Fermer</button>
        </div>
    </div>
</div>

<script>
function openApproveModal(id, employee, type, dateDebut, dateFin, jours, isChefStep) {
    document.getElementById('approveForm').action = '/admin/conges/' + id + '/approuver';
    document.getElementById('approveEmployee').textContent = employee;
    document.getElementById('approveType').textContent = type;
    document.getElementById('approveDates').textContent = dateDebut + ' - ' + dateFin;
    document.getElementById('approveDays').textContent = jours + (jours > 1 ? ' jours' : ' jour');
    // Adapter le titre et le bouton selon l'étape
    const title = isChefStep ? 'Valider la demande (Étape 1/2)' : 'Approuver la demande (Étape finale)';
    const btnLabel = isChefStep ? 'Valider' : 'Approuver définitivement';
    document.getElementById('approveModalTitle').textContent = title;
    document.getElementById('approveBtnLabel').textContent = btnLabel;
    document.getElementById('approveModal').classList.add('active');
}

function openRejectModal(id, employee) {
    document.getElementById('rejectForm').action = '/admin/conges/' + id + '/refuser';
    document.getElementById('rejectEmployee').textContent = employee;
    document.getElementById('rejectForm').querySelector('textarea').value = '';
    document.getElementById('rejectModal').classList.add('active');
}

function openDetailModal(id) {
    const modal = document.getElementById('detailModal');
    const content = document.getElementById('detailContent');
    content.innerHTML = '<p style="text-align:center;color:var(--cg-text-muted);">Chargement...</p>';
    modal.classList.add('active');

    fetch('/admin/conges/' + id, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.json())
        .then(conge => {
            const statuts = { en_attente: 'En attente', valide_chef: 'Valid\u00e9 Chef (attente RH)', approuve: 'Approuv\u00e9', refuse: 'Refus\u00e9', annule: 'Annul\u00e9' };
            let html = `
                <div class="cg-modal-info">
                    <div class="cg-modal-info-item">
                        <div class="cg-modal-info-label">Employ\u00e9</div>
                        <div class="cg-modal-info-value">${conge.personnel ? (conge.personnel.prenoms + ' ' + conge.personnel.nom) : '-'}</div>
                    </div>
                    <div class="cg-modal-info-item">
                        <div class="cg-modal-info-label">Type</div>
                        <div class="cg-modal-info-value">${conge.type_conge ? conge.type_conge.nom : '-'}</div>
                    </div>
                    <div class="cg-modal-info-item">
                        <div class="cg-modal-info-label">P\u00e9riode</div>
                        <div class="cg-modal-info-value">${conge.date_debut} \u2192 ${conge.date_fin}</div>
                    </div>
                    <div class="cg-modal-info-item">
                        <div class="cg-modal-info-label">Dur\u00e9e</div>
                        <div class="cg-modal-info-value">${conge.nombre_jours} jour${conge.nombre_jours > 1 ? 's' : ''}</div>
                    </div>
                    <div class="cg-modal-info-item">
                        <div class="cg-modal-info-label">Statut</div>
                        <div class="cg-modal-info-value">${statuts[conge.statut] || conge.statut}</div>
                    </div>
                    <div class="cg-modal-info-item">
                        <div class="cg-modal-info-label">Soumis le</div>
                        <div class="cg-modal-info-value">${conge.created_at || '-'}</div>
                    </div>
                </div>`;
            if (conge.conge_parent_id && conge.conge_parent) {
                html += `<div class="cg-modal-motif" style="border-left: 3px solid #2563eb;">
                    <div class="cg-modal-motif-label">Prolongation</div>
                    <div class="cg-modal-motif-text">Prolongation du cong\u00e9 initial du ${conge.conge_parent.date_debut} au ${conge.conge_parent.date_fin} (${conge.conge_parent.nombre_jours} jour${conge.conge_parent.nombre_jours > 1 ? 's' : ''})</div>
                </div>`;
            }
            if (conge.motif) {
                html += `<div class="cg-modal-motif">
                    <div class="cg-modal-motif-label">Motif</div>
                    <div class="cg-modal-motif-text">${conge.motif}</div>
                </div>`;
            }
            if (conge.motif_refus) {
                html += `<div class="cg-modal-motif" style="border-left: 3px solid var(--cg-danger);">
                    <div class="cg-modal-motif-label">Motif du refus</div>
                    <div class="cg-modal-motif-text">${conge.motif_refus}</div>
                </div>`;
            }
            if (conge.commentaire_admin) {
                html += `<div class="cg-modal-motif">
                    <div class="cg-modal-motif-label">Commentaire admin</div>
                    <div class="cg-modal-motif-text">${conge.commentaire_admin}</div>
                </div>`;
            }
            if (conge.document_officiel) {
                html += `<div class="cg-modal-motif" style="border-left: 3px solid var(--cg-success);">
                    <div class="cg-modal-motif-label">Document officiel</div>
                    <div class="cg-modal-motif-text"><a href="/storage/${conge.document_officiel}" target="_blank" style="color: var(--cg-primary); text-decoration: underline;">T\u00e9l\u00e9charger le PDF</a></div>
                </div>`;
            }
            content.innerHTML = html;
        })
        .catch(() => {
            content.innerHTML = '<p style="text-align:center;color:var(--cg-danger);">Erreur lors du chargement.</p>';
        });
}

function closeModal(id) {
    document.getElementById(id).classList.remove('active');
}

// Close modals on overlay click
document.querySelectorAll('.cg-modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('active');
    });
});
</script>
@endsection
