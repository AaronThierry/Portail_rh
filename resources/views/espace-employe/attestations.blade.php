@extends('layouts.espace-employe')

@section('title', 'Attestations')
@section('page-title', 'Attestations')
@section('breadcrumb')
    <a href="{{ route('espace-employe.dashboard') }}">Accueil</a>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
    <span>Attestations</span>
@endsection

@section('styles')
<style>
.ee-attestations-page {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

/* Request Card */
.ee-request-card {
    background: var(--e-slate-800);
    border-radius: var(--e-radius-xl);
    border-top: 3px solid var(--e-amber);
    padding: 2.5rem;
    color: white;
    position: relative;
    overflow: hidden;
}

.ee-request-content {
    position: relative;
    z-index: 1;
}

.ee-request-title {
    font-family: var(--e-font-display);
    font-size: 1.75rem;
    font-weight: 400;
    margin-bottom: 0.75rem;
}

.ee-request-text {
    font-size: 1rem;
    opacity: 0.9;
    margin-bottom: 2rem;
    max-width: 500px;
}

/* Attestation Types */
.ee-attestation-types {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.ee-attestation-type {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: var(--e-radius-lg);
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
}

.ee-attestation-type:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-4px);
}

.ee-attestation-type-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: var(--e-radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
}

.ee-attestation-type-icon svg {
    width: 30px;
    height: 30px;
}

.ee-attestation-type-name {
    font-size: 0.9375rem;
    font-weight: 700;
}

.ee-attestation-type-desc {
    font-size: 0.75rem;
    opacity: 0.8;
}

/* History Section */
.ee-history-section {
    background: var(--e-surface);
    border-radius: var(--e-radius-xl);
    border: 1px solid var(--e-border);
    overflow: hidden;
}

.ee-history-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem;
    border-bottom: 1px solid var(--e-border);
}

.ee-history-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--e-text);
}

/* History List */
.ee-history-list {
    padding: 1rem;
}

.ee-history-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: var(--e-radius);
    margin-bottom: 0.5rem;
    transition: all 0.3s ease;
}

.ee-history-item:hover {
    background: var(--e-bg);
}

.ee-history-item:last-child {
    margin-bottom: 0;
}

.ee-history-icon {
    width: 48px;
    height: 48px;
    border-radius: var(--e-radius);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.ee-history-icon svg {
    width: 24px;
    height: 24px;
}

.ee-history-icon.work {
    background: var(--e-blue);
    color: white;
}

.ee-history-icon.salary {
    background: var(--e-emerald);
    color: white;
}

.ee-history-icon.presence {
    background: #7c3aed;
    color: white;
}

.ee-history-content {
    flex: 1;
    min-width: 0;
}

.ee-history-name {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--e-text);
    margin-bottom: 0.25rem;
}

.ee-history-date {
    font-size: 0.8125rem;
    color: var(--e-text-secondary);
}

.ee-history-status {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.ee-history-status.ready {
    background: var(--e-emerald-pale);
    color: var(--e-emerald);
}

.ee-history-status.processing {
    background: var(--e-amber-pale);
    color: var(--e-amber);
}

.ee-history-status svg {
    width: 12px;
    height: 12px;
}

.ee-history-actions {
    display: flex;
    gap: 0.5rem;
}

.ee-history-btn {
    width: 40px;
    height: 40px;
    border: none;
    border-radius: 10px;
    background: var(--e-bg);
    color: var(--e-text-secondary);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.25s ease;
}

.ee-history-btn:hover {
    background: var(--e-blue);
    color: white;
}

.ee-history-btn svg {
    width: 18px;
    height: 18px;
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
    background: var(--e-bg);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--e-text-secondary);
}

.ee-empty-icon svg {
    width: 40px;
    height: 40px;
}

.ee-empty-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--e-text);
    margin-bottom: 0.5rem;
}

.ee-empty-text {
    font-size: 0.9375rem;
    color: var(--e-text-secondary);
}

/* Responsive */
@media (max-width: 768px) {
    .ee-request-card {
        padding: 1.5rem;
    }

    .ee-attestation-types {
        grid-template-columns: 1fr 1fr;
    }

    .ee-history-item {
        flex-wrap: wrap;
    }

    .ee-history-actions {
        width: 100%;
        justify-content: flex-end;
        margin-top: 0.5rem;
    }
}
</style>
@endsection

@section('content')
<div class="ee-attestations-page">
    <!-- Request Card -->
    <div class="ee-request-card animate-fade-in">
        <div class="ee-request-content">
            <h2 class="ee-request-title">Demander une attestation</h2>
            <p class="ee-request-text">
                Sélectionnez le type d'attestation dont vous avez besoin. Le document sera généré et mis à votre disposition sous 24 à 48 heures.
            </p>

            <div class="ee-attestation-types">
                <div class="ee-attestation-type" onclick="requestAttestation('travail')">
                    <div class="ee-attestation-type-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                        </svg>
                    </div>
                    <span class="ee-attestation-type-name">Attestation de travail</span>
                    <span class="ee-attestation-type-desc">Prouve votre emploi actuel</span>
                </div>

                <div class="ee-attestation-type" onclick="requestAttestation('salaire')">
                    <div class="ee-attestation-type-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="1" x2="12" y2="23"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                    </div>
                    <span class="ee-attestation-type-name">Attestation de salaire</span>
                    <span class="ee-attestation-type-desc">Justificatif de revenus</span>
                </div>

                <div class="ee-attestation-type" onclick="requestAttestation('presence')">
                    <div class="ee-attestation-type-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                            <path d="M9 16l2 2 4-4"></path>
                        </svg>
                    </div>
                    <span class="ee-attestation-type-name">Attestation de présence</span>
                    <span class="ee-attestation-type-desc">Pour une date précise</span>
                </div>

                <div class="ee-attestation-type" onclick="requestAttestation('autre')">
                    <div class="ee-attestation-type-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="12" y1="18" x2="12" y2="12"></line>
                            <line x1="9" y1="15" x2="15" y2="15"></line>
                        </svg>
                    </div>
                    <span class="ee-attestation-type-name">Autre attestation</span>
                    <span class="ee-attestation-type-desc">Demande spécifique</span>
                </div>
            </div>
        </div>
    </div>

    <!-- History Section -->
    <div class="ee-history-section animate-fade-in" style="animation-delay: 0.1s;">
        <div class="ee-history-header">
            <h2 class="ee-history-title">Mes attestations</h2>
        </div>

        <div class="ee-history-list">
            <div class="ee-empty-state">
                <div class="ee-empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
                </div>
                <h3 class="ee-empty-title">Aucune attestation</h3>
                <p class="ee-empty-text">Vous n'avez pas encore demandé d'attestation.</p>
            </div>
        </div>
    </div>
</div>

<script>
function requestAttestation(type) {
    const types = {
        'travail': 'Attestation de travail',
        'salaire': 'Attestation de salaire',
        'presence': 'Attestation de présence',
        'autre': 'Autre attestation'
    };
    alert(`Demande de "${types[type]}" en cours de développement.`);
}
</script>
@endsection
