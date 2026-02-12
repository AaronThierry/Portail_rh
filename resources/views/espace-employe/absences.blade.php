@extends('layouts.espace-employe')

@section('title', 'Mes Absences')
@section('page-title', 'Mes Absences')
@section('breadcrumb')
    <a href="{{ route('espace-employe.dashboard') }}">Accueil</a>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
    <span>Mes Absences</span>
@endsection

@section('styles')
<style>
.ee-absences-page {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

/* Stats Cards */
.ee-abs-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.5rem;
}

.ee-abs-card {
    background: var(--e-surface);
    border-radius: var(--e-radius-xl);
    border: 1px solid var(--e-border);
    padding: 1.5rem;
    position: relative;
    overflow: hidden;
}

.ee-abs-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
}

.ee-abs-card.total::before { background: var(--e-blue); }
.ee-abs-card.justified::before { background: var(--e-emerald); }
.ee-abs-card.unjustified::before { background: var(--e-red); }
.ee-abs-card.late::before { background: var(--e-amber); }

.ee-abs-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.ee-abs-icon {
    width: 48px; height: 48px;
    border-radius: var(--e-radius);
    display: flex; align-items: center; justify-content: center;
}
.ee-abs-icon svg { width: 24px; height: 24px; }
.ee-abs-icon.total { background: var(--e-blue-wash); color: var(--e-blue); }
.ee-abs-icon.justified { background: var(--e-emerald-pale); color: var(--e-emerald); }
.ee-abs-icon.unjustified { background: var(--e-red-pale); color: var(--e-red); }
.ee-abs-icon.late { background: var(--e-amber-wash); color: var(--e-amber); }

.ee-abs-label { font-size: 0.875rem; color: var(--e-text-secondary); font-weight: 500; }
.ee-abs-value { font-size: 2rem; font-weight: 700; color: var(--e-text); line-height: 1; }

/* History Card */
.ee-abs-history {
    background: var(--e-surface);
    border-radius: var(--e-radius-xl);
    border: 1px solid var(--e-border);
    overflow: hidden;
}

.ee-abs-history-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem;
    border-bottom: 1px solid var(--e-border);
}

.ee-abs-history-title { font-size: 1.125rem; font-weight: 700; color: var(--e-text); }

.ee-abs-year-select {
    padding: 0.5rem 1rem;
    background: var(--e-bg);
    border: 1px solid var(--e-border);
    border-radius: var(--e-radius);
    font-size: 0.875rem;
    color: var(--e-text);
    cursor: pointer;
}

/* Table */
.ee-abs-table { width: 100%; }
.ee-abs-table th {
    padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 700;
    color: var(--e-text-secondary); text-transform: uppercase; letter-spacing: 0.5px;
    background: var(--e-bg);
}
.ee-abs-table td {
    padding: 1rem 1.5rem; font-size: 0.9375rem; color: var(--e-text);
    border-bottom: 1px solid var(--e-border);
}
.ee-abs-table tr:last-child td { border-bottom: none; }
.ee-abs-table tr:hover td { background: var(--e-bg); }

.ee-abs-type {
    display: flex; align-items: center; gap: 0.75rem;
}
.ee-abs-type-icon {
    width: 36px; height: 36px; border-radius: var(--e-radius);
    display: flex; align-items: center; justify-content: center;
}
.ee-abs-type-icon svg { width: 18px; height: 18px; }

.ee-abs-badge {
    display: inline-flex; align-items: center; gap: 0.375rem;
    padding: 0.375rem 0.75rem; border-radius: 20px;
    font-size: 0.75rem; font-weight: 600;
}
.ee-abs-badge svg { width: 12px; height: 12px; }
.ee-abs-badge.justified { background: var(--e-emerald-pale); color: var(--e-emerald); }
.ee-abs-badge.unjustified { background: var(--e-red-pale); color: var(--e-red); }

/* Info Banner */
.ee-abs-info {
    background: var(--e-surface);
    border-radius: var(--e-radius-xl);
    border: 1px solid var(--e-border);
    border-left: 4px solid var(--e-blue);
    padding: 1.25rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    font-size: 0.9375rem;
    color: var(--e-text-secondary);
}
.ee-abs-info svg { width: 24px; height: 24px; color: var(--e-blue); flex-shrink: 0; }

/* Empty State */
.ee-abs-empty { text-align: center; padding: 4rem 2rem; }
.ee-abs-empty-icon {
    width: 80px; height: 80px; margin: 0 auto 1.5rem;
    background: var(--e-bg); border-radius: 50%;
    display: flex; align-items: center; justify-content: center; color: var(--e-text-secondary);
}
.ee-abs-empty-icon svg { width: 40px; height: 40px; }
.ee-abs-empty-title { font-size: 1.25rem; font-weight: 700; color: var(--e-text); margin-bottom: 0.5rem; }
.ee-abs-empty-text { font-size: 0.9375rem; color: var(--e-text-secondary); }

/* Responsive */
@media (max-width: 1024px) {
    .ee-abs-stats { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .ee-abs-stats { grid-template-columns: 1fr; }
    .ee-abs-table { display: block; overflow-x: auto; }
}
</style>
@endsection

@section('content')
<div class="ee-absences-page">
    {{-- Info Banner --}}
    <div class="ee-abs-info animate-fade-in">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="16" x2="12" y2="12"></line>
            <line x1="12" y1="8" x2="12.01" y2="8"></line>
        </svg>
        <span>Les absences sont enregistr&eacute;es par l'administration. Vous pouvez consulter ici votre historique pour l'ann&eacute;e {{ $annee }}.</span>
    </div>

    {{-- Stats Cards --}}
    <div class="ee-abs-stats animate-fade-in" style="animation-delay: 0.05s;">
        <div class="ee-abs-card total">
            <div class="ee-abs-header">
                <div class="ee-abs-icon total">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                </div>
                <span class="ee-abs-label">Total absences</span>
            </div>
            <div class="ee-abs-value">{{ $statsAbsences['total'] }}</div>
        </div>

        <div class="ee-abs-card justified">
            <div class="ee-abs-header">
                <div class="ee-abs-icon justified">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
                <span class="ee-abs-label">Justifi&eacute;es</span>
            </div>
            <div class="ee-abs-value">{{ $statsAbsences['justifiees'] }}</div>
        </div>

        <div class="ee-abs-card unjustified">
            <div class="ee-abs-header">
                <div class="ee-abs-icon unjustified">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                </div>
                <span class="ee-abs-label">Non justifi&eacute;es</span>
            </div>
            <div class="ee-abs-value">{{ $statsAbsences['injustifiees'] }}</div>
        </div>

        <div class="ee-abs-card late">
            <div class="ee-abs-header">
                <div class="ee-abs-icon late">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                </div>
                <span class="ee-abs-label">Retards</span>
            </div>
            <div class="ee-abs-value">{{ $statsAbsences['retards'] }}</div>
        </div>
    </div>

    {{-- History --}}
    <div class="ee-abs-history animate-fade-in" style="animation-delay: 0.1s;">
        <div class="ee-abs-history-header">
            <h2 class="ee-abs-history-title">Historique des absences</h2>
            <select class="ee-abs-year-select" onchange="window.location.href='{{ route('espace-employe.absences') }}?annee='+this.value">
                @foreach($anneesDisponibles as $a)
                    <option value="{{ $a }}" {{ $a == $annee ? 'selected' : '' }}>{{ $a }}</option>
                @endforeach
            </select>
        </div>

        @if($absences->count() > 0)
            <table class="ee-abs-table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Dur&eacute;e</th>
                        <th>Justifi&eacute;e</th>
                        <th>Motif</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($absences as $absence)
                        <tr>
                            <td>
                                <div class="ee-abs-type">
                                    <div class="ee-abs-type-icon" style="background: {{ $absence->typeAbsence->couleur ?? '#6b7280' }}; color: white;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="15" y1="9" x2="9" y2="15"></line>
                                            <line x1="9" y1="9" x2="15" y2="15"></line>
                                        </svg>
                                    </div>
                                    <span>{{ $absence->typeAbsence->nom ?? 'Absence' }}</span>
                                </div>
                            </td>
                            <td style="white-space:nowrap;">{{ $absence->date_absence->format('d/m/Y') }}</td>
                            <td style="font-size:0.875rem;color:var(--e-text-secondary);">{{ $absence->duree_label }}</td>
                            <td>
                                @if($absence->justifiee)
                                    <span class="ee-abs-badge justified">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                        Justifi&eacute;e
                                    </span>
                                @else
                                    <span class="ee-abs-badge unjustified">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                        Non justifi&eacute;e
                                    </span>
                                @endif
                            </td>
                            <td style="font-size:0.875rem;color:var(--e-text-secondary);max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $absence->motif }}">
                                {{ $absence->motif ?? '-' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="ee-abs-empty">
                <div class="ee-abs-empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
                <h3 class="ee-abs-empty-title">Aucune absence enregistr&eacute;e</h3>
                <p class="ee-abs-empty-text">Vous n'avez aucune absence pour l'ann&eacute;e {{ $annee }}.</p>
            </div>
        @endif
    </div>
</div>
@endsection
