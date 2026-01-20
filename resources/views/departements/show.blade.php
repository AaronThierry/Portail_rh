@extends('layouts.app')

@section('title', $departement->nom)
@section('page-title', 'Détails du Département')
@section('page-subtitle', $departement->nom)

@section('styles')
<style>
/* ========================================
   VARIABLES - Charte RH+ Premium
   ======================================== */
:root {
    --ds-primary: #4A90D9;
    --ds-primary-dark: #2E6BB3;
    --ds-primary-light: #E8F4FD;
    --ds-accent: #FF9500;
    --ds-accent-light: #FFF7ED;
    --ds-success: #22C55E;
    --ds-success-light: #F0FDF4;
    --ds-danger: #EF4444;
    --ds-danger-light: #FEF2F2;
    --ds-info: #3B82F6;
    --ds-info-light: #EFF6FF;
    --ds-purple: #8B5CF6;
    --ds-purple-light: #F5F3FF;
    --ds-bg: #f8fafc;
    --ds-card-bg: #ffffff;
    --ds-card-border: #e2e8f0;
    --ds-text-primary: #1e293b;
    --ds-text-secondary: #64748b;
    --ds-text-muted: #94a3b8;
    --ds-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    --ds-shadow-lg: 0 8px 30px rgba(0, 0, 0, 0.1);
    --ds-radius: 12px;
    --ds-radius-lg: 16px;
    --ds-radius-xl: 20px;
    --ds-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.dark {
    --ds-bg: #0f172a;
    --ds-card-bg: #1e293b;
    --ds-card-border: #334155;
    --ds-text-primary: #f1f5f9;
    --ds-text-secondary: #94a3b8;
    --ds-text-muted: #64748b;
    --ds-primary-light: rgba(74, 144, 217, 0.15);
    --ds-success-light: rgba(34, 197, 94, 0.15);
    --ds-info-light: rgba(59, 130, 246, 0.15);
    --ds-purple-light: rgba(139, 92, 246, 0.15);
}

/* ========================================
   BASE
   ======================================== */
.departement-show-page {
    padding: 1.5rem;
    min-height: 100vh;
    background: var(--ds-bg);
}

/* ========================================
   HEADER
   ======================================== */
.ds-header {
    background: var(--ds-card-bg);
    border-radius: var(--ds-radius-xl);
    padding: 2rem;
    margin-bottom: 1.5rem;
    box-shadow: var(--ds-shadow);
    border: 1px solid var(--ds-card-border);
    position: relative;
    overflow: hidden;
}

.ds-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--ds-primary), var(--ds-accent));
}

.ds-header-content {
    display: flex;
    align-items: flex-start;
    gap: 1.5rem;
    position: relative;
    z-index: 1;
}

.ds-back-btn {
    width: 44px;
    height: 44px;
    border-radius: var(--ds-radius);
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--ds-bg);
    border: 2px solid var(--ds-card-border);
    color: var(--ds-text-secondary);
    text-decoration: none;
    transition: var(--ds-transition);
    flex-shrink: 0;
}

.ds-back-btn:hover {
    border-color: var(--ds-primary);
    color: var(--ds-primary);
    background: var(--ds-primary-light);
    transform: translateX(-3px);
}

.ds-back-btn svg {
    width: 20px;
    height: 20px;
}

.ds-header-icon {
    width: 64px;
    height: 64px;
    border-radius: var(--ds-radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--ds-primary) 0%, var(--ds-primary-dark) 100%);
    color: white;
    box-shadow: 0 8px 20px rgba(74, 144, 217, 0.3);
    flex-shrink: 0;
}

.ds-header-icon svg {
    width: 32px;
    height: 32px;
}

.ds-header-info {
    flex: 1;
}

.ds-header-title {
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--ds-text-primary);
    margin: 0 0 0.5rem 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.ds-header-subtitle {
    font-size: 0.95rem;
    color: var(--ds-text-secondary);
    margin: 0 0 1rem 0;
}

.ds-header-badges {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.ds-header-actions {
    display: flex;
    gap: 0.75rem;
    flex-shrink: 0;
}

/* ========================================
   BADGES
   ======================================== */
.ds-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.875rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.ds-badge svg {
    width: 14px;
    height: 14px;
}

.ds-badge-global {
    background: var(--ds-info-light);
    color: var(--ds-info);
}

.ds-badge-entreprise {
    background: var(--ds-purple-light);
    color: var(--ds-purple);
}

.ds-badge-active {
    background: var(--ds-success-light);
    color: var(--ds-success);
}

.ds-badge-inactive {
    background: var(--ds-danger-light);
    color: var(--ds-danger);
}

/* ========================================
   BUTTONS
   ======================================== */
.ds-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    border-radius: var(--ds-radius);
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: var(--ds-transition);
    border: none;
    text-decoration: none;
}

.ds-btn svg {
    width: 18px;
    height: 18px;
}

.ds-btn-primary {
    background: linear-gradient(135deg, var(--ds-primary) 0%, var(--ds-primary-dark) 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(74, 144, 217, 0.3);
}

.ds-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(74, 144, 217, 0.4);
}

.ds-btn-danger {
    background: linear-gradient(135deg, var(--ds-danger) 0%, #DC2626 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

.ds-btn-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
}

.ds-btn-secondary {
    background: var(--ds-card-bg);
    color: var(--ds-text-primary);
    border: 2px solid var(--ds-card-border);
}

.ds-btn-secondary:hover {
    border-color: var(--ds-primary);
    color: var(--ds-primary);
}

/* ========================================
   GRID LAYOUT
   ======================================== */
.ds-grid {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 1.5rem;
}

/* ========================================
   CARDS
   ======================================== */
.ds-card {
    background: var(--ds-card-bg);
    border-radius: var(--ds-radius-lg);
    border: 1px solid var(--ds-card-border);
    overflow: hidden;
    transition: var(--ds-transition);
}

.ds-card:hover {
    box-shadow: var(--ds-shadow);
}

.ds-card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--ds-card-border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: linear-gradient(135deg, rgba(74, 144, 217, 0.03) 0%, transparent 100%);
}

.ds-card-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1rem;
    font-weight: 700;
    color: var(--ds-text-primary);
    margin: 0;
}

.ds-card-title-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--ds-primary) 0%, var(--ds-primary-dark) 100%);
    color: white;
}

.ds-card-title-icon svg {
    width: 18px;
    height: 18px;
}

.ds-card-body {
    padding: 1.5rem;
}

/* ========================================
   INFO GRID
   ======================================== */
.ds-info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.25rem;
}

.ds-info-item {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.ds-info-item.full {
    grid-column: span 2;
}

.ds-info-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--ds-text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.ds-info-value {
    font-size: 0.95rem;
    font-weight: 500;
    color: var(--ds-text-primary);
    padding: 0.75rem 1rem;
    background: var(--ds-bg);
    border-radius: 10px;
    border: 1px solid var(--ds-card-border);
}

.ds-info-value.code {
    font-family: 'SF Mono', 'Consolas', monospace;
    background: var(--ds-primary-light);
    color: var(--ds-primary);
    border-color: rgba(74, 144, 217, 0.2);
}

/* ========================================
   STATS CARDS
   ======================================== */
.ds-stats {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.ds-stat-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem;
    background: var(--ds-bg);
    border-radius: var(--ds-radius);
    transition: var(--ds-transition);
}

.ds-stat-card:hover {
    transform: translateX(4px);
}

.ds-stat-icon {
    width: 52px;
    height: 52px;
    border-radius: var(--ds-radius);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.ds-stat-icon svg {
    width: 26px;
    height: 26px;
}

.ds-stat-icon.blue {
    background: var(--ds-primary-light);
    color: var(--ds-primary);
}

.ds-stat-icon.green {
    background: var(--ds-success-light);
    color: var(--ds-success);
}

.ds-stat-icon.purple {
    background: var(--ds-purple-light);
    color: var(--ds-purple);
}

.ds-stat-info h4 {
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--ds-text-primary);
    margin: 0;
    line-height: 1;
}

.ds-stat-info p {
    font-size: 0.85rem;
    color: var(--ds-text-secondary);
    margin: 0.25rem 0 0 0;
}

/* ========================================
   SERVICES TABLE
   ======================================== */
.ds-table {
    width: 100%;
    border-collapse: collapse;
}

.ds-table thead {
    background: var(--ds-bg);
}

.ds-table th {
    padding: 1rem 1.25rem;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--ds-text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid var(--ds-card-border);
}

.ds-table td {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid var(--ds-card-border);
    vertical-align: middle;
}

.ds-table tbody tr {
    transition: var(--ds-transition);
}

.ds-table tbody tr:hover {
    background: rgba(74, 144, 217, 0.04);
}

.ds-table tbody tr:last-child td {
    border-bottom: none;
}

.ds-table-service {
    display: flex;
    align-items: center;
    gap: 0.875rem;
}

.ds-table-service-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--ds-success-light) 0%, rgba(34, 197, 94, 0.1) 100%);
    color: var(--ds-success);
    flex-shrink: 0;
}

.ds-table-service-icon svg {
    width: 20px;
    height: 20px;
}

.ds-table-service-info h4 {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--ds-text-primary);
    margin: 0 0 0.125rem 0;
}

.ds-table-service-info p {
    font-size: 0.8rem;
    color: var(--ds-text-muted);
    margin: 0;
}

.ds-table-code {
    display: inline-flex;
    padding: 0.375rem 0.75rem;
    background: var(--ds-bg);
    color: var(--ds-text-secondary);
    font-size: 0.8rem;
    font-weight: 600;
    font-family: 'SF Mono', 'Consolas', monospace;
    border-radius: 6px;
    border: 1px solid var(--ds-card-border);
}

.ds-table-count {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: var(--ds-primary-light);
    color: var(--ds-primary);
    font-weight: 700;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.ds-table-actions {
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
}

.ds-action-btn {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--ds-transition);
    background: var(--ds-bg);
    color: var(--ds-text-secondary);
    text-decoration: none;
}

.ds-action-btn svg {
    width: 16px;
    height: 16px;
}

.ds-action-btn.view:hover {
    background: var(--ds-info-light);
    color: var(--ds-info);
}

.ds-action-btn.edit:hover {
    background: var(--ds-primary-light);
    color: var(--ds-primary);
}

/* ========================================
   EMPTY STATE
   ======================================== */
.ds-empty {
    text-align: center;
    padding: 3rem 2rem;
}

.ds-empty-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    background: var(--ds-bg);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.ds-empty-icon svg {
    width: 40px;
    height: 40px;
    color: var(--ds-text-muted);
}

.ds-empty h3 {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--ds-text-primary);
    margin: 0 0 0.5rem 0;
}

.ds-empty p {
    color: var(--ds-text-secondary);
    margin: 0 0 1.5rem 0;
}

/* ========================================
   DANGER ZONE
   ======================================== */
.ds-danger-zone {
    border-color: rgba(239, 68, 68, 0.3);
}

.ds-danger-zone .ds-card-header {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.05) 0%, transparent 100%);
    border-bottom-color: rgba(239, 68, 68, 0.2);
}

.ds-danger-zone .ds-card-title-icon {
    background: linear-gradient(135deg, var(--ds-danger) 0%, #DC2626 100%);
}

.ds-danger-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}

.ds-danger-text h4 {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--ds-text-primary);
    margin: 0 0 0.25rem 0;
}

.ds-danger-text p {
    font-size: 0.85rem;
    color: var(--ds-text-secondary);
    margin: 0;
}

/* ========================================
   RESPONSIVE
   ======================================== */
@media (max-width: 1024px) {
    .ds-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .departement-show-page {
        padding: 1rem;
    }

    .ds-header {
        padding: 1.5rem;
    }

    .ds-header-content {
        flex-direction: column;
    }

    .ds-header-actions {
        width: 100%;
    }

    .ds-header-actions .ds-btn {
        flex: 1;
        justify-content: center;
    }

    .ds-info-grid {
        grid-template-columns: 1fr;
    }

    .ds-info-item.full {
        grid-column: span 1;
    }

    .ds-danger-content {
        flex-direction: column;
        text-align: center;
    }
}
</style>
@endsection

@section('content')
<div class="departement-show-page">
    <!-- Header -->
    <div class="ds-header">
        <div class="ds-header-content">
            <a href="{{ route('admin.departements.index') }}" class="ds-back-btn" title="Retour à la liste">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </a>

            <div class="ds-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>

            <div class="ds-header-info">
                <h1 class="ds-header-title">{{ $departement->nom }}</h1>
                <p class="ds-header-subtitle">
                    @if($departement->is_global)
                        Département global - Disponible pour toutes les entreprises
                    @elseif($departement->entreprise)
                        {{ $departement->entreprise->nom }}
                    @else
                        Aucune entreprise assignée
                    @endif
                </p>
                <div class="ds-header-badges">
                    @if($departement->is_global)
                    <span class="ds-badge ds-badge-global">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="2" y1="12" x2="22" y2="12"></line>
                        </svg>
                        Global
                    </span>
                    @else
                    <span class="ds-badge ds-badge-entreprise">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        </svg>
                        Entreprise
                    </span>
                    @endif

                    @if($departement->is_active)
                    <span class="ds-badge ds-badge-active">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        Actif
                    </span>
                    @else
                    <span class="ds-badge ds-badge-inactive">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                        Inactif
                    </span>
                    @endif
                </div>
            </div>

            <div class="ds-header-actions">
                <a href="{{ route('admin.departements.edit', $departement->id) }}" class="ds-btn ds-btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    Modifier
                </a>
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="ds-grid">
        <!-- Left Column -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <!-- Informations générales -->
            <div class="ds-card">
                <div class="ds-card-header">
                    <h2 class="ds-card-title">
                        <span class="ds-card-title-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="16" x2="12" y2="12"></line>
                                <line x1="12" y1="8" x2="12.01" y2="8"></line>
                            </svg>
                        </span>
                        Informations générales
                    </h2>
                </div>
                <div class="ds-card-body">
                    <div class="ds-info-grid">
                        <div class="ds-info-item">
                            <span class="ds-info-label">Nom du département</span>
                            <span class="ds-info-value">{{ $departement->nom }}</span>
                        </div>

                        <div class="ds-info-item">
                            <span class="ds-info-label">Code</span>
                            @if($departement->code)
                            <span class="ds-info-value code">{{ $departement->code }}</span>
                            @else
                            <span class="ds-info-value" style="color: var(--ds-text-muted); font-style: italic;">Non défini</span>
                            @endif
                        </div>

                        @if($departement->entreprise && !$departement->is_global)
                        <div class="ds-info-item">
                            <span class="ds-info-label">Entreprise</span>
                            <span class="ds-info-value">{{ $departement->entreprise->nom }}</span>
                        </div>
                        @endif

                        <div class="ds-info-item">
                            <span class="ds-info-label">Type</span>
                            <span class="ds-info-value">
                                @if($departement->is_global)
                                    Global (toutes entreprises)
                                @else
                                    Spécifique à l'entreprise
                                @endif
                            </span>
                        </div>

                        @if($departement->description)
                        <div class="ds-info-item full">
                            <span class="ds-info-label">Description</span>
                            <span class="ds-info-value">{{ $departement->description }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Services du département -->
            <div class="ds-card">
                <div class="ds-card-header">
                    <h2 class="ds-card-title">
                        <span class="ds-card-title-icon" style="background: linear-gradient(135deg, var(--ds-success) 0%, #059669 100%);">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="8.5" cy="7" r="4"></circle>
                                <line x1="20" y1="8" x2="20" y2="14"></line>
                                <line x1="23" y1="11" x2="17" y2="11"></line>
                            </svg>
                        </span>
                        Services ({{ $departement->services->count() }})
                    </h2>
                    <a href="{{ route('admin.services.create', ['departement_id' => $departement->id]) }}" class="ds-btn ds-btn-primary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 16px; height: 16px;">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Nouveau Service
                    </a>
                </div>

                @if($departement->services->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="ds-table">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Code</th>
                                <th>Employés</th>
                                <th>Statut</th>
                                <th style="text-align: right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($departement->services as $service)
                            <tr>
                                <td>
                                    <div class="ds-table-service">
                                        <div class="ds-table-service-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="9" cy="7" r="4"></circle>
                                            </svg>
                                        </div>
                                        <div class="ds-table-service-info">
                                            <h4>{{ $service->nom }}</h4>
                                            @if($service->description)
                                            <p>{{ Str::limit($service->description, 40) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($service->code)
                                    <span class="ds-table-code">{{ $service->code }}</span>
                                    @else
                                    <span style="color: var(--ds-text-muted);">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="ds-table-count">{{ $service->personnels->count() }}</span>
                                </td>
                                <td>
                                    @if($service->is_active)
                                    <span class="ds-badge ds-badge-active">Actif</span>
                                    @else
                                    <span class="ds-badge ds-badge-inactive">Inactif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="ds-table-actions">
                                        <a href="{{ route('admin.services.show', $service->id) }}" class="ds-action-btn view" title="Voir">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.services.edit', $service->id) }}" class="ds-action-btn edit" title="Modifier">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="ds-card-body">
                    <div class="ds-empty">
                        <div class="ds-empty-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <line x1="23" y1="11" x2="17" y2="11"></line>
                            </svg>
                        </div>
                        <h3>Aucun service</h3>
                        <p>Ce département n'a pas encore de services associés.</p>
                        <a href="{{ route('admin.services.create', ['departement_id' => $departement->id]) }}" class="ds-btn ds-btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Créer un service
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Right Column - Sidebar -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <!-- Statistiques -->
            <div class="ds-card">
                <div class="ds-card-header">
                    <h2 class="ds-card-title">
                        <span class="ds-card-title-icon" style="background: linear-gradient(135deg, var(--ds-purple) 0%, #7C3AED 100%);">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="18" y1="20" x2="18" y2="10"></line>
                                <line x1="12" y1="20" x2="12" y2="4"></line>
                                <line x1="6" y1="20" x2="6" y2="14"></line>
                            </svg>
                        </span>
                        Statistiques
                    </h2>
                </div>
                <div class="ds-card-body">
                    <div class="ds-stats">
                        <div class="ds-stat-card">
                            <div class="ds-stat-icon blue">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                            </div>
                            <div class="ds-stat-info">
                                <h4>{{ $departement->services->sum(fn($s) => $s->personnels->count()) }}</h4>
                                <p>Employés</p>
                            </div>
                        </div>

                        <div class="ds-stat-card">
                            <div class="ds-stat-icon green">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="8.5" cy="7" r="4"></circle>
                                    <line x1="20" y1="8" x2="20" y2="14"></line>
                                    <line x1="23" y1="11" x2="17" y2="11"></line>
                                </svg>
                            </div>
                            <div class="ds-stat-info">
                                <h4>{{ $departement->services->count() }}</h4>
                                <p>Services</p>
                            </div>
                        </div>

                        <div class="ds-stat-card">
                            <div class="ds-stat-icon purple">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                            </div>
                            <div class="ds-stat-info">
                                <h4>{{ $departement->services->where('is_active', true)->count() }}</h4>
                                <p>Services actifs</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Zone de danger -->
            <div class="ds-card ds-danger-zone">
                <div class="ds-card-header">
                    <h2 class="ds-card-title">
                        <span class="ds-card-title-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                                <line x1="12" y1="9" x2="12" y2="13"></line>
                                <line x1="12" y1="17" x2="12.01" y2="17"></line>
                            </svg>
                        </span>
                        Zone de danger
                    </h2>
                </div>
                <div class="ds-card-body">
                    <div class="ds-danger-content">
                        <div class="ds-danger-text">
                            <h4>Supprimer ce département</h4>
                            <p>Cette action est irréversible et supprimera toutes les données associées.</p>
                        </div>
                        @if($departement->services->count() > 0)
                        <button type="button" class="ds-btn ds-btn-secondary" disabled title="Supprimez d'abord les services associés">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            </svg>
                            Supprimer
                        </button>
                        @else
                        <form action="{{ route('admin.departements.destroy', $departement->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce département ? Cette action est irréversible.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="ds-btn ds-btn-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                                Supprimer
                            </button>
                        </form>
                        @endif
                    </div>
                    @if($departement->services->count() > 0)
                    <p style="margin-top: 1rem; font-size: 0.8rem; color: var(--ds-text-muted);">
                        * Vous devez d'abord supprimer les {{ $departement->services->count() }} service(s) associé(s) avant de pouvoir supprimer ce département.
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
