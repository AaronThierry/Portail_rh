@extends('layouts.app')

@section('title', 'Gestion des Absences')
@section('page-title', 'Gestion des Absences')
@section('page-subtitle', 'Suivi et enregistrement des absences')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <circle cx="12" cy="12" r="10"></circle>
    <line x1="15" y1="9" x2="9" y2="15"></line>
    <line x1="9" y1="9" x2="15" y2="15"></line>
</svg>
@endsection

@section('styles')
<style>
/* ========================================
   VARIABLES - Charte RH+ (identique cong&eacute;s)
   ======================================== */
:root {
    --ab-primary: #4A90D9;
    --ab-primary-dark: #2E6BB3;
    --ab-primary-light: #E8F4FD;
    --ab-accent: #8b5cf6;
    --ab-accent-light: #f3e8ff;
    --ab-success: #22C55E;
    --ab-success-light: #F0FDF4;
    --ab-danger: #EF4444;
    --ab-danger-light: #FEF2F2;
    --ab-warning: #F59E0B;
    --ab-warning-light: #FFFBEB;
    --ab-bg: #f8fafc;
    --ab-card-bg: #ffffff;
    --ab-card-border: #e2e8f0;
    --ab-text-primary: #1e293b;
    --ab-text-secondary: #64748b;
    --ab-text-muted: #94a3b8;
    --ab-shadow: rgba(0, 0, 0, 0.04);
    --ab-shadow-lg: rgba(0, 0, 0, 0.08);
    --ab-radius: 12px;
    --ab-radius-lg: 16px;
}

.dark {
    --ab-bg: #0f172a;
    --ab-card-bg: #1e293b;
    --ab-card-border: #334155;
    --ab-text-primary: #f1f5f9;
    --ab-text-secondary: #94a3b8;
    --ab-text-muted: #64748b;
    --ab-shadow: rgba(0, 0, 0, 0.3);
    --ab-shadow-lg: rgba(0, 0, 0, 0.5);
    --ab-primary-light: rgba(74, 144, 217, 0.15);
    --ab-accent-light: rgba(139, 92, 246, 0.15);
    --ab-success-light: rgba(34, 197, 94, 0.15);
    --ab-danger-light: rgba(239, 68, 68, 0.15);
    --ab-warning-light: rgba(245, 158, 11, 0.15);
}

/* BASE */
.absences-page { padding: 1.5rem; max-width: 1400px; margin: 0 auto; }

/* STATS ROW */
.ab-stats { display: grid; grid-template-columns: repeat(5, 1fr); gap: 1.25rem; margin-bottom: 1.5rem; }
.ab-stat-card {
    background: var(--ab-card-bg); border: 1px solid var(--ab-card-border);
    border-radius: var(--ab-radius-lg); padding: 1.25rem;
    display: flex; align-items: center; gap: 1rem;
    box-shadow: 0 1px 3px var(--ab-shadow); position: relative; overflow: hidden;
}
.ab-stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; }
.ab-stat-card.total::before { background: var(--ab-primary); }
.ab-stat-card.justified::before { background: var(--ab-success); }
.ab-stat-card.unjustified::before { background: var(--ab-danger); }
.ab-stat-card.late::before { background: var(--ab-warning); }
.ab-stat-card.pending::before { background: var(--ab-accent); }
.ab-stat-icon {
    width: 48px; height: 48px; border-radius: var(--ab-radius);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.ab-stat-icon svg { width: 24px; height: 24px; }
.ab-stat-icon.total { background: var(--ab-primary-light); color: var(--ab-primary); }
.ab-stat-icon.justified { background: var(--ab-success-light); color: var(--ab-success); }
.ab-stat-icon.unjustified { background: var(--ab-danger-light); color: var(--ab-danger); }
.ab-stat-icon.late { background: var(--ab-warning-light); color: var(--ab-warning); }
.ab-stat-icon.pending { background: var(--ab-accent-light); color: var(--ab-accent); }
.ab-stat-value { font-size: 1.75rem; font-weight: 700; color: var(--ab-text-primary); line-height: 1; }
.ab-stat-label { font-size: 0.8125rem; color: var(--ab-text-secondary); margin-top: 0.25rem; }

/* FILTERS */
.ab-filters {
    background: var(--ab-card-bg); border: 1px solid var(--ab-card-border);
    border-radius: var(--ab-radius-lg); padding: 1.25rem; margin-bottom: 1.5rem;
    display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;
    box-shadow: 0 1px 3px var(--ab-shadow);
}
.ab-filter-group { display: flex; align-items: center; gap: 0.5rem; }
.ab-filter-label { font-size: 0.8125rem; font-weight: 600; color: var(--ab-text-secondary); white-space: nowrap; }
.ab-filter-select, .ab-filter-input {
    padding: 0.5rem 0.875rem; background: var(--ab-bg); border: 1px solid var(--ab-card-border);
    border-radius: 8px; font-size: 0.875rem; color: var(--ab-text-primary); min-width: 140px;
}
.ab-filter-select:focus, .ab-filter-input:focus { outline: none; border-color: var(--ab-primary); }
.ab-filter-btn {
    padding: 0.5rem 1rem; background: var(--ab-primary); color: white;
    border: none; border-radius: 8px; font-size: 0.875rem; font-weight: 600;
    cursor: pointer; display: flex; align-items: center; gap: 0.375rem;
}
.ab-filter-btn:hover { opacity: 0.9; }
.ab-filter-btn svg { width: 16px; height: 16px; }
.ab-filter-reset {
    padding: 0.5rem 1rem; background: transparent; color: var(--ab-text-secondary);
    border: 1px solid var(--ab-card-border); border-radius: 8px; font-size: 0.875rem;
    cursor: pointer; text-decoration: none;
}
.ab-filter-reset:hover { border-color: var(--ab-text-secondary); color: var(--ab-text-primary); }

/* ADD BUTTON */
.ab-add-btn {
    padding: 0.5rem 1rem; background: var(--ab-accent); color: white;
    border: none; border-radius: 8px; font-size: 0.875rem; font-weight: 600;
    cursor: pointer; display: flex; align-items: center; gap: 0.375rem; margin-left: auto;
}
.ab-add-btn:hover { opacity: 0.9; }
.ab-add-btn svg { width: 16px; height: 16px; }

/* TABLE */
.ab-table-card {
    background: var(--ab-card-bg); border: 1px solid var(--ab-card-border);
    border-radius: var(--ab-radius-lg); overflow: hidden;
    box-shadow: 0 1px 3px var(--ab-shadow);
}
.ab-table-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1.25rem; border-bottom: 1px solid var(--ab-card-border);
}
.ab-table-title { font-size: 1.125rem; font-weight: 700; color: var(--ab-text-primary); }
.ab-table-count {
    font-size: 0.8125rem; color: var(--ab-text-secondary); background: var(--ab-bg);
    padding: 0.375rem 0.75rem; border-radius: 20px;
}
.ab-table-wrap { overflow-x: auto; }
.ab-table { width: 100%; border-collapse: collapse; }
.ab-table th {
    padding: 0.875rem 1.25rem; text-align: left; font-size: 0.75rem; font-weight: 700;
    color: var(--ab-text-secondary); text-transform: uppercase; letter-spacing: 0.5px;
    background: var(--ab-bg); border-bottom: 1px solid var(--ab-card-border); white-space: nowrap;
}
.ab-table td {
    padding: 1rem 1.25rem; font-size: 0.9375rem; color: var(--ab-text-primary);
    border-bottom: 1px solid var(--ab-card-border); vertical-align: middle;
}
.ab-table tr:last-child td { border-bottom: none; }
.ab-table tr:hover td { background: var(--ab-bg); }

/* Employee Cell */
.ab-employee { display: flex; align-items: center; gap: 0.75rem; }
.ab-employee-avatar {
    width: 40px; height: 40px; border-radius: 10px; object-fit: cover;
    background: var(--ab-primary-light); border: 2px solid var(--ab-card-border);
}
.ab-employee-name { font-weight: 600; color: var(--ab-text-primary); font-size: 0.9375rem; }
.ab-employee-matricule { font-size: 0.75rem; color: var(--ab-text-muted); }

/* Type Badge */
.ab-type-badge {
    display: inline-flex; align-items: center; gap: 0.375rem;
    padding: 0.375rem 0.75rem; border-radius: 8px;
    font-size: 0.8125rem; font-weight: 600; white-space: nowrap;
}

/* Justifi&eacute;e Badge */
.ab-justif { display: inline-flex; align-items: center; gap: 0.375rem; padding: 0.375rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
.ab-justif.oui { background: var(--ab-success-light); color: #15803d; }
.ab-justif.non { background: var(--ab-danger-light); color: #b91c1c; }
.ab-justif.attente { background: var(--ab-warning-light); color: #92400e; }

/* Source Badge */
.ab-source {
    display: inline-flex; align-items: center; gap: 0.375rem;
    padding: 0.375rem 0.75rem; border-radius: 20px;
    font-size: 0.75rem; font-weight: 600; white-space: nowrap;
}
.ab-source.admin { background: var(--ab-primary-light); color: var(--ab-primary); }
.ab-source.employe { background: var(--ab-accent-light); color: var(--ab-accent); }

/* Statut Badge */
.ab-statut {
    display: inline-flex; align-items: center; gap: 0.375rem;
    padding: 0.375rem 0.75rem; border-radius: 20px;
    font-size: 0.75rem; font-weight: 600; white-space: nowrap;
}
.ab-statut.en-attente { background: var(--ab-warning-light); color: #92400e; }
.ab-statut.approuvee { background: var(--ab-success-light); color: #15803d; }
.ab-statut.refusee { background: var(--ab-danger-light); color: #b91c1c; }

/* Actions */
.ab-actions { display: flex; gap: 0.5rem; flex-wrap: wrap; }
.ab-btn {
    padding: 0.5rem 0.875rem; border: none; border-radius: 8px;
    font-size: 0.8125rem; font-weight: 600; cursor: pointer;
    display: inline-flex; align-items: center; gap: 0.375rem; white-space: nowrap;
}
.ab-btn svg { width: 14px; height: 14px; }
.ab-btn-toggle { background: var(--ab-success-light); color: #15803d; }
.ab-btn-toggle:hover { background: var(--ab-success); color: white; }
.ab-btn-delete { background: var(--ab-danger-light); color: #b91c1c; }
.ab-btn-delete:hover { background: var(--ab-danger); color: white; }
.ab-btn-detail { background: var(--ab-bg); color: var(--ab-text-secondary); border: 1px solid var(--ab-card-border); }
.ab-btn-detail:hover { border-color: var(--ab-primary); color: var(--ab-primary); }
.ab-btn-approve { background: var(--ab-success-light); color: #15803d; }
.ab-btn-approve:hover { background: var(--ab-success); color: white; }
.ab-btn-reject { background: var(--ab-danger-light); color: #b91c1c; }
.ab-btn-reject:hover { background: var(--ab-danger); color: white; }

/* Justificatif link */
.ab-justif-link {
    display: inline-flex; align-items: center; gap: 0.25rem;
    font-size: 0.75rem; color: var(--ab-primary); text-decoration: none; font-weight: 600;
}
.ab-justif-link:hover { text-decoration: underline; }
.ab-justif-link svg { width: 12px; height: 12px; }

/* EMPTY */
.ab-empty { text-align: center; padding: 4rem 2rem; }
.ab-empty-icon { width: 64px; height: 64px; margin: 0 auto 1rem; background: var(--ab-bg); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--ab-text-muted); }
.ab-empty-icon svg { width: 32px; height: 32px; }
.ab-empty-title { font-size: 1.125rem; font-weight: 700; color: var(--ab-text-primary); margin-bottom: 0.5rem; }
.ab-empty-text { font-size: 0.875rem; color: var(--ab-text-secondary); }

/* PAGINATION */
.ab-pagination { display: flex; align-items: center; justify-content: center; padding: 1.25rem; gap: 0.25rem; }
.ab-pagination a, .ab-pagination span { padding: 0.5rem 0.875rem; border-radius: 8px; font-size: 0.875rem; font-weight: 500; text-decoration: none; color: var(--ab-text-secondary); }
.ab-pagination a:hover { background: var(--ab-primary-light); color: var(--ab-primary); }
.ab-pagination .active span { background: var(--ab-primary); color: white; }
.ab-pagination .disabled span { opacity: 0.4; }

/* MODAL */
.ab-modal-overlay { display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.5); z-index: 1000; align-items: center; justify-content: center; padding: 1rem; }
.ab-modal-overlay.active { display: flex; }
.ab-modal { background: var(--ab-card-bg); border-radius: var(--ab-radius-lg); width: 100%; max-width: 560px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); overflow: hidden; max-height: 90vh; overflow-y: auto; }
.ab-modal-header { display: flex; align-items: center; justify-content: space-between; padding: 1.25rem; border-bottom: 1px solid var(--ab-card-border); }
.ab-modal-title { font-size: 1.0625rem; font-weight: 700; color: var(--ab-text-primary); }
.ab-modal-close { width: 32px; height: 32px; border-radius: 8px; border: none; background: var(--ab-bg); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--ab-text-secondary); }
.ab-modal-close:hover { background: var(--ab-card-border); color: var(--ab-text-primary); }
.ab-modal-close svg { width: 18px; height: 18px; }
.ab-modal-body { padding: 1.25rem; }
.ab-modal-footer { padding: 1.25rem; border-top: 1px solid var(--ab-card-border); display: flex; justify-content: flex-end; gap: 0.75rem; }
.ab-form-group { margin-bottom: 1rem; }
.ab-form-label { display: block; font-size: 0.875rem; font-weight: 600; color: var(--ab-text-primary); margin-bottom: 0.5rem; }
.ab-form-input, .ab-form-select, .ab-form-textarea {
    width: 100%; padding: 0.625rem 0.875rem; background: var(--ab-bg);
    border: 1px solid var(--ab-card-border); border-radius: 8px;
    font-size: 0.9375rem; color: var(--ab-text-primary); box-sizing: border-box;
}
.ab-form-input:focus, .ab-form-select:focus, .ab-form-textarea:focus { outline: none; border-color: var(--ab-primary); }
.ab-form-textarea { resize: vertical; min-height: 70px; }
.ab-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; }
.ab-form-hint { font-size: 0.75rem; color: var(--ab-text-muted); margin-top: 0.25rem; }

/* Searchable Select */
.ab-search-select { position: relative; }
.ab-search-select .ab-search-input {
    width: 100%; padding: 0.625rem 0.875rem 0.625rem 2.25rem; background: var(--ab-bg);
    border: 1px solid var(--ab-card-border); border-radius: 8px;
    font-size: 0.9375rem; color: var(--ab-text-primary); box-sizing: border-box;
}
.ab-search-select .ab-search-input:focus { outline: none; border-color: var(--ab-primary); }
.ab-search-select .ab-search-icon {
    position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%);
    width: 16px; height: 16px; color: var(--ab-text-muted); pointer-events: none;
}
.ab-search-select .ab-search-clear {
    position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%);
    width: 20px; height: 20px; border: none; background: none; cursor: pointer;
    color: var(--ab-text-muted); display: none; padding: 0;
}
.ab-search-select .ab-search-clear:hover { color: var(--ab-text-primary); }
.ab-search-dropdown {
    display: none; position: absolute; top: 100%; left: 0; right: 0;
    background: var(--ab-card-bg); border: 1px solid var(--ab-card-border);
    border-radius: 8px; max-height: 220px; overflow-y: auto; z-index: 100;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12); margin-top: 4px;
}
.ab-search-option {
    padding: 0.625rem 0.875rem; cursor: pointer; font-size: 0.9375rem;
    color: var(--ab-text-primary); transition: background 0.1s;
}
.ab-search-option:hover, .ab-search-option.highlighted { background: var(--ab-primary-light); }
.ab-search-option .ab-opt-sub { color: var(--ab-text-muted); font-size: 0.8125rem; }
.ab-search-no-results {
    padding: 0.875rem; color: var(--ab-text-muted); font-style: italic;
    font-size: 0.875rem; text-align: center; display: none;
}
.ab-modal-btn-cancel { padding: 0.625rem 1.25rem; background: var(--ab-bg); border: 1px solid var(--ab-card-border); border-radius: 8px; font-size: 0.875rem; font-weight: 600; color: var(--ab-text-secondary); cursor: pointer; }
.ab-modal-btn-confirm { padding: 0.625rem 1.25rem; border: none; border-radius: 8px; font-size: 0.875rem; font-weight: 600; color: white; cursor: pointer; background: var(--ab-accent); }
.ab-modal-btn-confirm:hover { opacity: 0.9; }
.ab-modal-btn-reject { padding: 0.625rem 1.25rem; border: none; border-radius: 8px; font-size: 0.875rem; font-weight: 600; color: white; cursor: pointer; background: var(--ab-danger); }
.ab-modal-btn-reject:hover { opacity: 0.9; }

/* Flash */
.ab-flash { padding: 1rem 1.25rem; border-radius: var(--ab-radius); font-size: 0.9375rem; font-weight: 500; margin-bottom: 1.25rem; }
.ab-flash-success { background: var(--ab-success-light); color: #065f46; border: 1px solid #a7f3d0; }
.ab-flash-error { background: var(--ab-danger-light); color: #991b1b; border: 1px solid #fecaca; }

/* RESPONSIVE */
@media (max-width: 1200px) { .ab-stats { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 1024px) { .ab-stats { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 768px) {
    .absences-page { padding: 1rem; }
    .ab-stats { grid-template-columns: 1fr; }
    .ab-filters { flex-direction: column; align-items: stretch; }
    .ab-actions { flex-direction: column; }
}
</style>
@endsection

@section('content')
<div class="absences-page">
    {{-- Flash --}}
    @if(session('success'))
        <div class="ab-flash ab-flash-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="ab-flash ab-flash-error">{{ session('error') }}</div>
    @endif

    {{-- Stats --}}
    <div class="ab-stats">
        <div class="ab-stat-card total">
            <div class="ab-stat-icon total">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
            </div>
            <div>
                <div class="ab-stat-value">{{ $stats['total'] }}</div>
                <div class="ab-stat-label">Total absences</div>
            </div>
        </div>
        <div class="ab-stat-card justified">
            <div class="ab-stat-icon justified">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <div>
                <div class="ab-stat-value">{{ $stats['justifiees'] }}</div>
                <div class="ab-stat-label">Justifi&eacute;es</div>
            </div>
        </div>
        <div class="ab-stat-card unjustified">
            <div class="ab-stat-icon unjustified">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
            </div>
            <div>
                <div class="ab-stat-value">{{ $stats['injustifiees'] }}</div>
                <div class="ab-stat-label">Non justifi&eacute;es</div>
            </div>
        </div>
        <div class="ab-stat-card late">
            <div class="ab-stat-icon late">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </div>
            <div>
                <div class="ab-stat-value">{{ $stats['retards'] }}</div>
                <div class="ab-stat-label">Retards</div>
            </div>
        </div>
        <div class="ab-stat-card pending">
            <div class="ab-stat-icon pending">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>
            <div>
                <div class="ab-stat-value">{{ $stats['en_attente'] }}</div>
                <div class="ab-stat-label">En attente</div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <form class="ab-filters" method="GET" action="{{ route('admin.absences.index') }}">
        <div class="ab-filter-group">
            <span class="ab-filter-label">Type</span>
            <select name="type_absence" class="ab-filter-select">
                <option value="">Tous</option>
                @foreach($typesAbsence as $type)
                    <option value="{{ $type->id }}" {{ request('type_absence') == $type->id ? 'selected' : '' }}>{{ $type->nom }}</option>
                @endforeach
            </select>
        </div>
        <div class="ab-filter-group">
            <span class="ab-filter-label">Justifi&eacute;e</span>
            <select name="justifiee" class="ab-filter-select" style="min-width: 100px;">
                <option value="">Toutes</option>
                <option value="1" {{ request('justifiee') === '1' ? 'selected' : '' }}>Oui</option>
                <option value="0" {{ request('justifiee') === '0' ? 'selected' : '' }}>Non</option>
            </select>
        </div>
        <div class="ab-filter-group">
            <span class="ab-filter-label">Statut</span>
            <select name="statut" class="ab-filter-select" style="min-width: 120px;">
                <option value="">Toutes</option>
                <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                <option value="approuvee" {{ request('statut') === 'approuvee' ? 'selected' : '' }}>Approuv&eacute;es</option>
                <option value="refusee" {{ request('statut') === 'refusee' ? 'selected' : '' }}>Refus&eacute;es</option>
            </select>
        </div>
        <div class="ab-filter-group">
            <span class="ab-filter-label">Ann&eacute;e</span>
            <select name="annee" class="ab-filter-select" style="min-width: 90px;">
                @foreach($anneesDisponibles as $a)
                    <option value="{{ $a }}" {{ request('annee', date('Y')) == $a ? 'selected' : '' }}>{{ $a }}</option>
                @endforeach
            </select>
        </div>
        <div class="ab-filter-group">
            <input type="text" name="search" class="ab-filter-input" placeholder="Nom ou matricule..." value="{{ request('search') }}">
        </div>
        <button type="submit" class="ab-filter-btn">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            Filtrer
        </button>
        <a href="{{ route('admin.absences.index') }}" class="ab-filter-reset">R&eacute;initialiser</a>
        <button type="button" class="ab-add-btn" onclick="document.getElementById('addAbsenceModal').classList.add('active')">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Enregistrer une absence
        </button>
    </form>

    {{-- Table --}}
    <div class="ab-table-card">
        <div class="ab-table-header">
            <h2 class="ab-table-title">Absences enregistr&eacute;es</h2>
            <span class="ab-table-count">{{ $absences->total() }} r&eacute;sultat{{ $absences->total() > 1 ? 's' : '' }}</span>
        </div>

        @if($absences->count() > 0)
            <div class="ab-table-wrap">
                <table class="ab-table">
                    <thead>
                        <tr>
                            <th>Employ&eacute;</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Dur&eacute;e</th>
                            <th>Source</th>
                            <th>Statut</th>
                            <th>Justifi&eacute;e</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($absences as $absence)
                            <tr>
                                <td>
                                    <div class="ab-employee">
                                        <img src="{{ $absence->personnel && $absence->personnel->photo ? asset('storage/' . $absence->personnel->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(($absence->personnel->prenoms ?? '') . ' ' . ($absence->personnel->nom ?? '')) . '&size=80&background=E8F4FD&color=4A90D9&bold=true' }}"
                                             alt="" class="ab-employee-avatar">
                                        <div>
                                            <div class="ab-employee-name">{{ $absence->personnel->prenoms ?? '' }} {{ $absence->personnel->nom ?? '' }}</div>
                                            <div class="ab-employee-matricule">{{ $absence->personnel->matricule ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="ab-type-badge" style="background: {{ $absence->typeAbsence->couleur ?? '#6b7280' }}20; color: {{ $absence->typeAbsence->couleur ?? '#6b7280' }};">
                                        {{ $absence->typeAbsence->nom ?? 'Absence' }}
                                    </span>
                                </td>
                                <td style="font-size: 0.9375rem; white-space: nowrap;">
                                    {{ $absence->date_absence->format('d/m/Y') }}
                                </td>
                                <td style="font-size: 0.875rem; color: var(--ab-text-secondary);">
                                    {{ $absence->duree_label }}
                                </td>
                                <td>
                                    <span class="ab-source {{ $absence->source === 'admin' ? 'admin' : 'employe' }}">
                                        @if($absence->source === 'admin')
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                                            Admin
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                            Employ&eacute;
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    @if($absence->statut === 'en_attente')
                                        <span class="ab-statut en-attente">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                            En attente
                                        </span>
                                    @elseif($absence->statut === 'approuvee')
                                        <span class="ab-statut approuvee">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            Approuv&eacute;e
                                        </span>
                                    @elseif($absence->statut === 'refusee')
                                        <span class="ab-statut refusee">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            Refus&eacute;e
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="ab-justif {{ $absence->justifiee ? 'oui' : 'non' }}">
                                        @if($absence->justifiee)
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            Justifi&eacute;e
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            Non justifi&eacute;e
                                        @endif
                                    </span>
                                    @if($absence->justificatif)
                                        <a href="{{ asset('storage/' . $absence->justificatif) }}" target="_blank" class="ab-justif-link" style="margin-top: 0.25rem; display: inline-flex;">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                            T&eacute;l&eacute;charger
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <div class="ab-actions">
                                        @if($absence->statut === 'en_attente')
                                            {{-- Approve button --}}
                                            <form action="{{ route('admin.absences.approve', $absence) }}" method="POST" style="margin:0;">
                                                @csrf
                                                <button type="submit" class="ab-btn ab-btn-approve" title="Approuver cette absence">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                    Approuver
                                                </button>
                                            </form>
                                            {{-- Reject button --}}
                                            <button type="button" class="ab-btn ab-btn-reject" title="Refuser cette absence" onclick="openRejectModal({{ $absence->id }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                Refuser
                                            </button>
                                        @else
                                            {{-- Toggle justifi&eacute;e --}}
                                            <form action="{{ route('admin.absences.toggle-justifiee', $absence) }}" method="POST" style="margin:0;">
                                                @csrf
                                                <button type="submit" class="ab-btn ab-btn-toggle" title="{{ $absence->justifiee ? 'Marquer non justifi&eacute;e' : 'Marquer justifi&eacute;e' }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                    {{ $absence->justifiee ? 'D&eacute;justifier' : 'Justifier' }}
                                                </button>
                                            </form>
                                            {{-- Delete --}}
                                            <form action="{{ route('admin.absences.destroy', $absence) }}" method="POST" style="margin:0;" onsubmit="return confirm('Supprimer cette absence ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="ab-btn ab-btn-delete" title="Supprimer">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($absences->hasPages())
                <div class="ab-pagination">
                    {{ $absences->withQueryString()->links('pagination::bootstrap-4') }}
                </div>
            @endif
        @else
            <div class="ab-empty">
                <div class="ab-empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                </div>
                <h3 class="ab-empty-title">Aucune absence enregistr&eacute;e</h3>
                <p class="ab-empty-text">Aucune absence ne correspond aux filtres s&eacute;lectionn&eacute;s.</p>
            </div>
        @endif
    </div>
</div>

{{-- Add Absence Modal --}}
<div class="ab-modal-overlay" id="addAbsenceModal">
    <div class="ab-modal">
        <div class="ab-modal-header">
            <h3 class="ab-modal-title">Enregistrer une absence</h3>
            <button class="ab-modal-close" onclick="closeAbModal('addAbsenceModal')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        <form action="{{ route('admin.absences.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="ab-modal-body">
                <div class="ab-form-group">
                    <label class="ab-form-label">Employ&eacute; *</label>
                    <div class="ab-search-select" id="abPersonnelSearch">
                        <svg class="ab-search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <input type="text" class="ab-search-input" placeholder="Rechercher un employ&eacute;..." autocomplete="off">
                        <button type="button" class="ab-search-clear" title="Effacer">&times;</button>
                        <input type="hidden" name="personnel_id" value="{{ old('personnel_id') }}" required>
                        <div class="ab-search-dropdown">
                            @foreach($personnels as $p)
                                <div class="ab-search-option" data-value="{{ $p->id }}" data-text="{{ $p->prenoms }} {{ $p->nom }} ({{ $p->matricule ?? '-' }})">
                                    {{ $p->prenoms }} {{ $p->nom }} <span class="ab-opt-sub">({{ $p->matricule ?? '-' }})</span>
                                </div>
                            @endforeach
                            <div class="ab-search-no-results">Aucun r&eacute;sultat</div>
                        </div>
                    </div>
                </div>

                <div class="ab-form-row">
                    <div class="ab-form-group">
                        <label class="ab-form-label">Type d'absence *</label>
                        <select name="type_absence_id" class="ab-form-select" required>
                            <option value="">S&eacute;lectionnez</option>
                            @foreach($typesAbsence as $type)
                                <option value="{{ $type->id }}" {{ old('type_absence_id') == $type->id ? 'selected' : '' }}>{{ $type->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="ab-form-group">
                        <label class="ab-form-label">Date *</label>
                        <input type="date" name="date_absence" class="ab-form-input" value="{{ old('date_absence', date('Y-m-d')) }}" required>
                    </div>
                </div>

                <div class="ab-form-row">
                    <div class="ab-form-group">
                        <label class="ab-form-label">Type de dur&eacute;e *</label>
                        <select name="duree_type" class="ab-form-select" id="dureeTypeSelect" required onchange="toggleMinutesRetard()">
                            <option value="journee" {{ old('duree_type') === 'journee' ? 'selected' : '' }}>Journ&eacute;e compl&egrave;te</option>
                            <option value="demi_journee" {{ old('duree_type') === 'demi_journee' ? 'selected' : '' }}>Demi-journ&eacute;e</option>
                            <option value="retard" {{ old('duree_type') === 'retard' ? 'selected' : '' }}>Retard</option>
                            <option value="depart_anticipe" {{ old('duree_type') === 'depart_anticipe' ? 'selected' : '' }}>D&eacute;part anticip&eacute;</option>
                        </select>
                    </div>
                    <div class="ab-form-group" id="minutesRetardGroup" style="display:none;">
                        <label class="ab-form-label">Minutes de retard</label>
                        <input type="number" name="minutes_retard" class="ab-form-input" min="1" max="480" value="{{ old('minutes_retard') }}" placeholder="Ex: 30">
                    </div>
                </div>

                <div class="ab-form-row">
                    <div class="ab-form-group">
                        <label class="ab-form-label">Heure d&eacute;but</label>
                        <input type="time" name="heure_debut" class="ab-form-input" value="{{ old('heure_debut') }}">
                    </div>
                    <div class="ab-form-group">
                        <label class="ab-form-label">Heure fin</label>
                        <input type="time" name="heure_fin" class="ab-form-input" value="{{ old('heure_fin') }}">
                    </div>
                </div>

                <div class="ab-form-group">
                    <label class="ab-form-label">Motif</label>
                    <textarea name="motif" class="ab-form-textarea" placeholder="Motif de l'absence (optionnel)">{{ old('motif') }}</textarea>
                </div>

                <div class="ab-form-group">
                    <label class="ab-form-label">Justificatif</label>
                    <input type="file" name="justificatif" class="ab-form-input" accept=".pdf,.jpg,.jpeg,.png">
                    <p class="ab-form-hint">PDF, JPG ou PNG - Max 5 Mo</p>
                </div>

                <div class="ab-form-group" style="display:flex;align-items:center;gap:0.75rem;">
                    <input type="hidden" name="justifiee" value="0">
                    <input type="checkbox" name="justifiee" value="1" id="justifieeCheck" {{ old('justifiee') ? 'checked' : '' }} style="width:18px;height:18px;accent-color:var(--ab-success);">
                    <label for="justifieeCheck" class="ab-form-label" style="margin:0;cursor:pointer;">Absence justifi&eacute;e</label>
                </div>
            </div>
            <div class="ab-modal-footer">
                <button type="button" class="ab-modal-btn-cancel" onclick="closeAbModal('addAbsenceModal')">Annuler</button>
                <button type="submit" class="ab-modal-btn-confirm">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

{{-- Reject Modal --}}
<div class="ab-modal-overlay" id="rejectModal">
    <div class="ab-modal">
        <div class="ab-modal-header">
            <h3 class="ab-modal-title">Refuser l'absence</h3>
            <button class="ab-modal-close" onclick="closeAbModal('rejectModal')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        <form id="rejectForm" method="POST" action="">
            @csrf
            <div class="ab-modal-body">
                <p style="font-size: 0.9375rem; color: var(--ab-text-secondary); margin-bottom: 1rem;">
                    Veuillez indiquer le motif du refus. L'employ&eacute; sera notifi&eacute; de cette d&eacute;cision.
                </p>
                <div class="ab-form-group">
                    <label class="ab-form-label">Motif du refus *</label>
                    <textarea name="motif_refus" class="ab-form-textarea" required placeholder="Indiquez la raison du refus..." style="min-height: 100px;"></textarea>
                </div>
            </div>
            <div class="ab-modal-footer">
                <button type="button" class="ab-modal-btn-cancel" onclick="closeAbModal('rejectModal')">Annuler</button>
                <button type="submit" class="ab-modal-btn-reject">Confirmer le refus</button>
            </div>
        </form>
    </div>
</div>

<script>
function closeAbModal(id) {
    document.getElementById(id).classList.remove('active');
}

function toggleMinutesRetard() {
    var sel = document.getElementById('dureeTypeSelect');
    var grp = document.getElementById('minutesRetardGroup');
    grp.style.display = sel.value === 'retard' ? '' : 'none';
}

function openRejectModal(absenceId) {
    var form = document.getElementById('rejectForm');
    form.action = '{{ url("admin/absences") }}/' + absenceId + '/reject';
    form.querySelector('textarea[name="motif_refus"]').value = '';
    document.getElementById('rejectModal').classList.add('active');
}

// ── Searchable Personnel Select ──
(function() {
    var wrapper = document.getElementById('abPersonnelSearch');
    if (!wrapper) return;
    var input = wrapper.querySelector('.ab-search-input');
    var hidden = wrapper.querySelector('input[name="personnel_id"]');
    var dropdown = wrapper.querySelector('.ab-search-dropdown');
    var options = wrapper.querySelectorAll('.ab-search-option');
    var noResults = wrapper.querySelector('.ab-search-no-results');
    var clearBtn = wrapper.querySelector('.ab-search-clear');

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
        // Auto-select if single result and user typed something
        if (visible === 1 && term.length > 0) {
            options.forEach(function(opt) {
                if (opt.style.display !== 'none') {
                    selectOption(opt);
                }
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

    input.addEventListener('focus', function() {
        showDropdown();
        filterOptions();
    });

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
})();

// Init on load
toggleMinutesRetard();

// Close modals on overlay click
document.querySelectorAll('.ab-modal-overlay').forEach(function(overlay) {
    overlay.addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('active');
    });
});

// Ouvrir le modal si erreurs
@if($errors->any())
    document.getElementById('addAbsenceModal').classList.add('active');
@endif
</script>
@endsection
