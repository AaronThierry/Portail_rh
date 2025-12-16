@extends('layouts.espace-employe')

@section('title', 'Mes Demandes')
@section('page-title', 'Mes Demandes')
@section('breadcrumb')
    <a href="{{ route('espace-employe.dashboard') }}">Accueil</a>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
    <span>Mes Demandes</span>
@endsection

@section('styles')
<style>
.ee-demandes-page {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

/* Stats Row */
.ee-stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
}

.ee-stat-box {
    background: var(--ee-card);
    border-radius: 16px;
    border: 1px solid var(--ee-border);
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.ee-stat-box-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.ee-stat-box-icon svg {
    width: 24px;
    height: 24px;
}

.ee-stat-box-icon.all {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.15) 0%, rgba(99, 102, 241, 0.05) 100%);
    color: var(--ee-primary);
}

.ee-stat-box-icon.pending {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(245, 158, 11, 0.05) 100%);
    color: var(--ee-warning);
}

.ee-stat-box-icon.approved {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0.05) 100%);
    color: var(--ee-success);
}

.ee-stat-box-icon.rejected {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(239, 68, 68, 0.05) 100%);
    color: var(--ee-danger);
}

.ee-stat-box-value {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--ee-text);
}

.ee-stat-box-label {
    font-size: 0.8125rem;
    color: var(--ee-text-muted);
}

/* New Request Card */
.ee-new-request-card {
    background: var(--ee-card);
    border-radius: 20px;
    border: 1px solid var(--ee-border);
    padding: 2rem;
}

.ee-new-request-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
}

.ee-new-request-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--ee-text);
}

.ee-request-types-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 1rem;
}

.ee-request-type-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
    padding: 1.5rem 1rem;
    background: var(--ee-bg-alt);
    border: 2px solid transparent;
    border-radius: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.ee-request-type-btn:hover {
    border-color: var(--ee-primary);
    background: var(--ee-primary-light);
    transform: translateY(-2px);
}

.ee-request-type-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.ee-request-type-icon svg {
    width: 26px;
    height: 26px;
}

.ee-request-type-icon.purple {
    background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
    color: white;
}

.ee-request-type-icon.blue {
    background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
    color: white;
}

.ee-request-type-icon.green {
    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    color: white;
}

.ee-request-type-icon.orange {
    background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
    color: white;
}

.ee-request-type-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--ee-text);
    text-align: center;
}

/* Demandes List */
.ee-demandes-card {
    background: var(--ee-card);
    border-radius: 20px;
    border: 1px solid var(--ee-border);
    overflow: hidden;
}

.ee-demandes-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem;
    border-bottom: 1px solid var(--ee-border);
}

.ee-demandes-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--ee-text);
}

.ee-demandes-filters {
    display: flex;
    gap: 0.5rem;
}

.ee-filter-pill {
    padding: 0.5rem 1rem;
    background: var(--ee-bg-alt);
    border: 1px solid var(--ee-border);
    border-radius: 20px;
    font-size: 0.8125rem;
    font-weight: 600;
    color: var(--ee-text-muted);
    cursor: pointer;
    transition: all 0.25s ease;
}

.ee-filter-pill:hover, .ee-filter-pill.active {
    background: var(--ee-primary);
    border-color: var(--ee-primary);
    color: white;
}

/* Demande Item */
.ee-demandes-list {
    padding: 1rem;
}

.ee-demande-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem;
    background: var(--ee-bg-alt);
    border-radius: 14px;
    margin-bottom: 0.75rem;
    transition: all 0.3s ease;
}

.ee-demande-item:hover {
    transform: translateX(4px);
}

.ee-demande-item:last-child {
    margin-bottom: 0;
}

.ee-demande-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.ee-demande-icon svg {
    width: 24px;
    height: 24px;
}

.ee-demande-content {
    flex: 1;
    min-width: 0;
}

.ee-demande-type {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--ee-text);
    margin-bottom: 0.25rem;
}

.ee-demande-date {
    font-size: 0.8125rem;
    color: var(--ee-text-muted);
}

.ee-demande-status {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.ee-demande-status.pending {
    background: rgba(245, 158, 11, 0.1);
    color: var(--ee-warning);
}

.ee-demande-status.approved {
    background: rgba(16, 185, 129, 0.1);
    color: var(--ee-success);
}

.ee-demande-status.rejected {
    background: rgba(239, 68, 68, 0.1);
    color: var(--ee-danger);
}

.ee-demande-status svg {
    width: 14px;
    height: 14px;
}

/* Empty State */
.ee-empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.ee-empty-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    background: var(--ee-bg-alt);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--ee-text-muted);
}

.ee-empty-icon svg {
    width: 40px;
    height: 40px;
}

.ee-empty-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--ee-text);
    margin-bottom: 0.5rem;
}

.ee-empty-text {
    font-size: 0.9375rem;
    color: var(--ee-text-muted);
}

/* Responsive */
@media (max-width: 1024px) {
    .ee-stats-row {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 640px) {
    .ee-stats-row {
        grid-template-columns: 1fr;
    }

    .ee-request-types-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .ee-demandes-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }

    .ee-demandes-filters {
        width: 100%;
        overflow-x: auto;
    }
}
</style>
@endsection

@section('content')
<div class="ee-demandes-page">
    <!-- Stats Row -->
    <div class="ee-stats-row animate-fade-in">
        <div class="ee-stat-box">
            <div class="ee-stat-box-icon all">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
            </div>
            <div>
                <div class="ee-stat-box-value">{{ $demandes->count() }}</div>
                <div class="ee-stat-box-label">Total demandes</div>
            </div>
        </div>
        <div class="ee-stat-box">
            <div class="ee-stat-box-icon pending">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </div>
            <div>
                <div class="ee-stat-box-value">{{ $demandes->where('statut', 'en_attente')->count() }}</div>
                <div class="ee-stat-box-label">En attente</div>
            </div>
        </div>
        <div class="ee-stat-box">
            <div class="ee-stat-box-icon approved">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <div>
                <div class="ee-stat-box-value">{{ $demandes->where('statut', 'approuvee')->count() }}</div>
                <div class="ee-stat-box-label">Approuvées</div>
            </div>
        </div>
        <div class="ee-stat-box">
            <div class="ee-stat-box-icon rejected">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
            </div>
            <div>
                <div class="ee-stat-box-value">{{ $demandes->where('statut', 'refusee')->count() }}</div>
                <div class="ee-stat-box-label">Refusées</div>
            </div>
        </div>
    </div>

    <!-- New Request Card -->
    <div class="ee-new-request-card animate-fade-in" style="animation-delay: 0.1s;">
        <div class="ee-new-request-header">
            <h2 class="ee-new-request-title">Nouvelle demande</h2>
        </div>
        <div class="ee-request-types-grid">
            <button class="ee-request-type-btn" onclick="newRequest('conge')">
                <div class="ee-request-type-icon purple">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
                <span class="ee-request-type-label">Congé / Absence</span>
            </button>
            <button class="ee-request-type-btn" onclick="newRequest('attestation')">
                <div class="ee-request-type-icon blue">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                </div>
                <span class="ee-request-type-label">Attestation</span>
            </button>
            <button class="ee-request-type-btn" onclick="newRequest('avance')">
                <div class="ee-request-type-icon green">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="1" x2="12" y2="23"></line>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                </div>
                <span class="ee-request-type-label">Avance sur salaire</span>
            </button>
            <button class="ee-request-type-btn" onclick="newRequest('autre')">
                <div class="ee-request-type-icon orange">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                </div>
                <span class="ee-request-type-label">Autre demande</span>
            </button>
        </div>
    </div>

    <!-- Demandes List -->
    <div class="ee-demandes-card animate-fade-in" style="animation-delay: 0.2s;">
        <div class="ee-demandes-header">
            <h2 class="ee-demandes-title">Historique des demandes</h2>
            <div class="ee-demandes-filters">
                <button class="ee-filter-pill active">Toutes</button>
                <button class="ee-filter-pill">En attente</button>
                <button class="ee-filter-pill">Approuvées</button>
                <button class="ee-filter-pill">Refusées</button>
            </div>
        </div>

        <div class="ee-demandes-list">
            @if($demandes->count() > 0)
                @foreach($demandes as $demande)
                    <div class="ee-demande-item">
                        <div class="ee-demande-icon" style="background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%); color: white;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                        </div>
                        <div class="ee-demande-content">
                            <div class="ee-demande-type">{{ $demande->type ?? 'Demande' }}</div>
                            <div class="ee-demande-date">{{ $demande->created_at ?? now() }}</div>
                        </div>
                        <div class="ee-demande-status pending">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            En attente
                        </div>
                    </div>
                @endforeach
            @else
                <div class="ee-empty-state">
                    <div class="ee-empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="ee-empty-title">Aucune demande</h3>
                    <p class="ee-empty-text">Vous n'avez pas encore effectué de demande.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function newRequest(type) {
    const types = {
        'conge': 'Congé / Absence',
        'attestation': 'Attestation',
        'avance': 'Avance sur salaire',
        'autre': 'Autre demande'
    };
    alert(`Formulaire de "${types[type]}" en cours de développement.`);
}
</script>
@endsection
