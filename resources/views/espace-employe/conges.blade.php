@extends('layouts.espace-employe')

@section('title', 'Congés & Absences')
@section('page-title', 'Congés & Absences')
@section('breadcrumb')
    <a href="{{ route('espace-employe.dashboard') }}">Accueil</a>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
    <span>Congés & Absences</span>
@endsection

@section('styles')
<style>
.ee-conges-page {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

/* Solde Cards */
.ee-solde-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
}

.ee-solde-card {
    background: var(--e-surface);
    border-radius: var(--e-radius-xl);
    border: 1px solid var(--e-border);
    padding: 1.5rem;
    position: relative;
    overflow: hidden;
}

.ee-solde-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
}

.ee-solde-card.total::before {
    background: var(--e-blue);
}

.ee-solde-card.pris::before {
    background: var(--e-amber);
}

.ee-solde-card.restants::before {
    background: var(--e-emerald);
}

.ee-solde-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.ee-solde-icon {
    width: 48px;
    height: 48px;
    border-radius: var(--e-radius);
    display: flex;
    align-items: center;
    justify-content: center;
}

.ee-solde-icon svg {
    width: 24px;
    height: 24px;
}

.ee-solde-icon.total {
    background: var(--e-blue-wash);
    color: var(--e-blue);
}

.ee-solde-icon.pris {
    background: var(--e-amber-wash);
    color: var(--e-amber);
}

.ee-solde-icon.restants {
    background: var(--e-emerald-pale);
    color: var(--e-emerald);
}

.ee-solde-label {
    font-size: 0.875rem;
    color: var(--e-text-secondary);
    font-weight: 500;
}

.ee-solde-value {
    font-size: 2rem;
    font-weight: 700;
    color: var(--e-text);
    line-height: 1;
}

.ee-solde-unit {
    font-size: 1rem;
    font-weight: 600;
    color: var(--e-text-secondary);
    margin-left: 0.5rem;
}

/* Action Button */
.ee-action-card {
    background: var(--e-slate-800);
    border-radius: var(--e-radius-xl);
    border-top: 3px solid var(--e-amber);
    padding: 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: white;
}

.ee-action-content h3 {
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.ee-action-content p {
    font-size: 0.9375rem;
    opacity: 0.9;
}

.ee-action-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem 1.5rem;
    background: var(--e-surface);
    border: 1px solid var(--e-border);
    border-radius: var(--e-radius);
    color: var(--e-text);
    font-size: 0.9375rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.ee-action-btn:hover {
    background: white;
    color: var(--e-blue);
}

.ee-action-btn svg {
    width: 20px;
    height: 20px;
}

/* History Card */
.ee-history-card {
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

.ee-history-filters {
    display: flex;
    gap: 0.5rem;
}

.ee-year-select {
    padding: 0.5rem 1rem;
    background: var(--e-bg);
    border: 1px solid var(--e-border);
    border-radius: var(--e-radius);
    font-size: 0.875rem;
    color: var(--e-text);
    cursor: pointer;
}

/* History Table */
.ee-history-table {
    width: 100%;
}

.ee-history-table th {
    padding: 1rem 1.5rem;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--e-text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background: var(--e-bg);
}

.ee-history-table td {
    padding: 1rem 1.5rem;
    font-size: 0.9375rem;
    color: var(--e-text);
    border-bottom: 1px solid var(--e-border);
}

.ee-history-table tr:last-child td {
    border-bottom: none;
}

.ee-history-table tr:hover td {
    background: var(--e-bg);
}

.ee-conge-type {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.ee-conge-type-icon {
    width: 36px;
    height: 36px;
    border-radius: var(--e-radius);
    display: flex;
    align-items: center;
    justify-content: center;
}

.ee-conge-type-icon svg {
    width: 18px;
    height: 18px;
}

.ee-conge-type-icon.annual {
    background: var(--e-blue);
    color: white;
}

.ee-conge-type-icon.sick {
    background: var(--e-red);
    color: white;
}

.ee-conge-type-icon.special {
    background: #7c3aed;
    color: white;
}

.ee-status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.ee-status-badge.approved {
    background: var(--e-emerald-pale);
    color: var(--e-emerald);
}

.ee-status-badge.pending {
    background: var(--e-amber-pale);
    color: var(--e-amber);
}

.ee-status-badge.rejected {
    background: var(--e-red-pale);
    color: var(--e-red);
}

.ee-status-badge svg {
    width: 12px;
    height: 12px;
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
@media (max-width: 1024px) {
    .ee-solde-grid {
        grid-template-columns: 1fr;
    }

    .ee-action-card {
        flex-direction: column;
        text-align: center;
        gap: 1.5rem;
    }
}

@media (max-width: 768px) {
    .ee-history-table {
        display: block;
        overflow-x: auto;
    }
}
</style>
@endsection

@section('content')
<div class="ee-conges-page">
    <!-- Solde Cards -->
    <div class="ee-solde-grid animate-fade-in">
        <div class="ee-solde-card total">
            <div class="ee-solde-header">
                <div class="ee-solde-icon total">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
                <span class="ee-solde-label">Congés annuels</span>
            </div>
            <div>
                <span class="ee-solde-value">{{ $soldeConges['annuels'] }}</span>
                <span class="ee-solde-unit">jours</span>
            </div>
        </div>

        <div class="ee-solde-card pris">
            <div class="ee-solde-header">
                <div class="ee-solde-icon pris">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
                <span class="ee-solde-label">Congés pris</span>
            </div>
            <div>
                <span class="ee-solde-value">{{ $soldeConges['pris'] }}</span>
                <span class="ee-solde-unit">jours</span>
            </div>
        </div>

        <div class="ee-solde-card restants">
            <div class="ee-solde-header">
                <div class="ee-solde-icon restants">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                </div>
                <span class="ee-solde-label">Congés restants</span>
            </div>
            <div>
                <span class="ee-solde-value">{{ $soldeConges['restants'] }}</span>
                <span class="ee-solde-unit">jours</span>
            </div>
        </div>
    </div>

    <!-- Action Card -->
    <div class="ee-action-card animate-fade-in" style="animation-delay: 0.1s;">
        <div class="ee-action-content">
            <h3>Besoin de prendre des congés ?</h3>
            <p>Soumettez votre demande en quelques clics et suivez son avancement.</p>
        </div>
        <button class="ee-action-btn" onclick="openRequestModal()">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Nouvelle demande
        </button>
    </div>

    <!-- History Card -->
    <div class="ee-history-card animate-fade-in" style="animation-delay: 0.2s;">
        <div class="ee-history-header">
            <h2 class="ee-history-title">Historique des congés</h2>
            <div class="ee-history-filters">
                <select class="ee-year-select">
                    <option value="2025">2025</option>
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                </select>
            </div>
        </div>

        @if($conges->count() > 0)
            <table class="ee-history-table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Période</th>
                        <th>Durée</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($conges as $conge)
                        <tr>
                            <td>
                                <div class="ee-conge-type">
                                    <div class="ee-conge-type-icon annual">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                        </svg>
                                    </div>
                                    <span>{{ $conge->type ?? 'Congé annuel' }}</span>
                                </div>
                            </td>
                            <td>{{ $conge->date_debut ?? '-' }} - {{ $conge->date_fin ?? '-' }}</td>
                            <td>{{ $conge->duree ?? '-' }} jours</td>
                            <td>
                                <span class="ee-status-badge approved">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                    Approuvé
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="ee-empty-state">
                <div class="ee-empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
                <h3 class="ee-empty-title">Aucun congé enregistré</h3>
                <p class="ee-empty-text">Vous n'avez pas encore de congés dans l'historique.</p>
            </div>
        @endif
    </div>
</div>

<script>
function openRequestModal() {
    alert('Fonctionnalité de demande de congé à venir !');
}
</script>
@endsection
