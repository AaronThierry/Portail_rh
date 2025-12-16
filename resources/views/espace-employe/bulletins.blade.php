@extends('layouts.espace-employe')

@section('title', 'Bulletins de paie')
@section('page-title', 'Bulletins de paie')
@section('breadcrumb')
    <a href="{{ route('espace-employe.dashboard') }}">Accueil</a>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
    <span>Bulletins de paie</span>
@endsection

@section('styles')
<style>
.ee-bulletins-page {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

/* Bulletins Grid */
.ee-bulletins-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
}

.ee-bulletin-card {
    background: var(--ee-card);
    border-radius: 20px;
    border: 1px solid var(--ee-border);
    padding: 1.5rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.ee-bulletin-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px var(--ee-shadow);
    border-color: var(--ee-primary);
}

.ee-bulletin-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.25rem;
}

.ee-bulletin-month {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--ee-text);
}

.ee-bulletin-year {
    font-size: 0.875rem;
    color: var(--ee-primary);
    font-weight: 600;
    background: var(--ee-primary-light);
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
}

.ee-bulletin-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--ee-primary) 0%, var(--ee-primary-dark) 100%);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin-bottom: 1rem;
}

.ee-bulletin-icon svg {
    width: 30px;
    height: 30px;
}

.ee-bulletin-info {
    margin-bottom: 1.25rem;
}

.ee-bulletin-label {
    font-size: 0.75rem;
    color: var(--ee-text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.25rem;
}

.ee-bulletin-amount {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--ee-text);
}

.ee-bulletin-actions {
    display: flex;
    gap: 0.75rem;
}

.ee-bulletin-btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem;
    border-radius: 12px;
    font-size: 0.8125rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
    text-decoration: none;
    border: none;
}

.ee-bulletin-btn.primary {
    background: var(--ee-primary);
    color: white;
}

.ee-bulletin-btn.primary:hover {
    background: var(--ee-primary-dark);
}

.ee-bulletin-btn.secondary {
    background: var(--ee-bg-alt);
    color: var(--ee-text);
    border: 1px solid var(--ee-border);
}

.ee-bulletin-btn.secondary:hover {
    border-color: var(--ee-primary);
    color: var(--ee-primary);
}

.ee-bulletin-btn svg {
    width: 16px;
    height: 16px;
}

/* Year Filter */
.ee-filter-card {
    background: var(--ee-card);
    border-radius: 16px;
    border: 1px solid var(--ee-border);
    padding: 1rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.ee-filter-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--ee-text);
}

.ee-filter-years {
    display: flex;
    gap: 0.5rem;
}

.ee-year-btn {
    padding: 0.5rem 1rem;
    background: var(--ee-bg-alt);
    border: 1px solid var(--ee-border);
    border-radius: 10px;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--ee-text-muted);
    cursor: pointer;
    transition: all 0.25s ease;
}

.ee-year-btn:hover, .ee-year-btn.active {
    background: var(--ee-primary);
    border-color: var(--ee-primary);
    color: white;
}

/* Empty State */
.ee-empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: var(--ee-card);
    border-radius: 20px;
    border: 1px solid var(--ee-border);
}

.ee-empty-icon {
    width: 100px;
    height: 100px;
    margin: 0 auto 1.5rem;
    background: var(--ee-bg-alt);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--ee-text-muted);
}

.ee-empty-icon svg {
    width: 50px;
    height: 50px;
}

.ee-empty-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--ee-text);
    margin-bottom: 0.75rem;
}

.ee-empty-text {
    font-size: 1rem;
    color: var(--ee-text-muted);
    max-width: 400px;
    margin: 0 auto;
}

/* Responsive */
@media (max-width: 640px) {
    .ee-filter-card {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }

    .ee-filter-years {
        width: 100%;
        overflow-x: auto;
    }
}
</style>
@endsection

@section('content')
<div class="ee-bulletins-page">
    <!-- Year Filter -->
    <div class="ee-filter-card animate-fade-in">
        <span class="ee-filter-title">Filtrer par année</span>
        <div class="ee-filter-years">
            <button class="ee-year-btn active">2025</button>
            <button class="ee-year-btn">2024</button>
            <button class="ee-year-btn">2023</button>
            <button class="ee-year-btn">2022</button>
        </div>
    </div>

    @if($bulletins->count() > 0)
        <div class="ee-bulletins-grid">
            @foreach($bulletins as $bulletin)
                <div class="ee-bulletin-card animate-fade-in">
                    <div class="ee-bulletin-header">
                        <span class="ee-bulletin-month">{{ $bulletin->mois ?? 'Janvier' }}</span>
                        <span class="ee-bulletin-year">{{ $bulletin->annee ?? '2025' }}</span>
                    </div>
                    <div class="ee-bulletin-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                            <line x1="8" y1="21" x2="16" y2="21"></line>
                            <line x1="12" y1="17" x2="12" y2="21"></line>
                        </svg>
                    </div>
                    <div class="ee-bulletin-info">
                        <div class="ee-bulletin-label">Net à payer</div>
                        <div class="ee-bulletin-amount">{{ number_format($bulletin->net_a_payer ?? 0, 0, ',', ' ') }} FCFA</div>
                    </div>
                    <div class="ee-bulletin-actions">
                        <button class="ee-bulletin-btn secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                            Voir
                        </button>
                        <button class="ee-bulletin-btn primary">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                            PDF
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="ee-empty-state animate-fade-in">
            <div class="ee-empty-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                    <line x1="8" y1="21" x2="16" y2="21"></line>
                    <line x1="12" y1="17" x2="12" y2="21"></line>
                </svg>
            </div>
            <h3 class="ee-empty-title">Aucun bulletin disponible</h3>
            <p class="ee-empty-text">Vos bulletins de paie apparaîtront ici dès qu'ils seront disponibles.</p>
        </div>
    @endif
</div>
@endsection
