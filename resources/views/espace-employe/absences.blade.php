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

/* Flash Messages */
.ee-abs-flash {
    padding: 1rem 1.5rem;
    border-radius: var(--e-radius);
    font-size: 0.9375rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
}
.ee-abs-flash-success { background: var(--e-emerald-pale); color: #065f46; border: 1px solid #a7f3d0; }
.ee-abs-flash-error { background: var(--e-red-pale); color: #991b1b; border: 1px solid #fecaca; }

/* Stats Cards — 5 columns */
.ee-abs-stats {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
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
.ee-abs-card.pending::before { background: #8b5cf6; }

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
.ee-abs-icon.pending { background: rgba(139, 92, 246, 0.1); color: #8b5cf6; }

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
    flex-wrap: wrap;
    gap: 1rem;
}

.ee-abs-history-title { font-size: 1.125rem; font-weight: 700; color: var(--e-text); }

.ee-abs-history-actions {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.ee-abs-year-select {
    padding: 0.5rem 1rem;
    background: var(--e-bg);
    border: 1px solid var(--e-border);
    border-radius: var(--e-radius);
    font-size: 0.875rem;
    color: var(--e-text);
    cursor: pointer;
}

.ee-abs-btn-declare {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1.25rem;
    background: var(--e-blue);
    border: none;
    border-radius: var(--e-radius);
    font-size: 0.875rem;
    font-weight: 600;
    color: white;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
}
.ee-abs-btn-declare:hover { opacity: 0.9; }
.ee-abs-btn-declare svg { width: 18px; height: 18px; }

/* Table */
.ee-abs-table-wrapper {
    overflow-x: auto;
}
.ee-abs-table { width: 100%; border-collapse: collapse; }
.ee-abs-table th {
    padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 700;
    color: var(--e-text-secondary); text-transform: uppercase; letter-spacing: 0.5px;
    background: var(--e-bg); white-space: nowrap;
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

/* Justified badge */
.ee-abs-badge {
    display: inline-flex; align-items: center; gap: 0.375rem;
    padding: 0.375rem 0.75rem; border-radius: 20px;
    font-size: 0.75rem; font-weight: 600;
}
.ee-abs-badge svg { width: 12px; height: 12px; }
.ee-abs-badge.justified { background: var(--e-emerald-pale); color: var(--e-emerald); }
.ee-abs-badge.unjustified { background: var(--e-red-pale); color: var(--e-red); }

/* Status badge */
.ee-abs-status {
    display: inline-flex; align-items: center; gap: 0.375rem;
    padding: 0.375rem 0.75rem; border-radius: 20px;
    font-size: 0.75rem; font-weight: 600;
}
.ee-abs-status svg { width: 12px; height: 12px; }
.ee-abs-status.en-attente { background: var(--e-amber-wash); color: var(--e-amber); }
.ee-abs-status.approuvee { background: var(--e-emerald-pale); color: var(--e-emerald); }
.ee-abs-status.refusee { background: var(--e-red-pale); color: var(--e-red); }

.ee-abs-motif-refus {
    display: block;
    font-size: 0.75rem;
    color: var(--e-red);
    margin-top: 0.25rem;
    font-weight: 400;
}

/* Actions column */
.ee-abs-actions {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.ee-abs-btn-sm {
    padding: 0.375rem 0.75rem;
    background: transparent;
    border: 1px solid var(--e-border);
    border-radius: var(--e-radius);
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--e-text-secondary);
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
}
.ee-abs-btn-sm:hover { border-color: var(--e-blue); color: var(--e-blue); }

.ee-abs-btn-sm.justify-btn { border-color: var(--e-emerald); color: var(--e-emerald); }
.ee-abs-btn-sm.justify-btn:hover { background: var(--e-emerald-pale); }

.ee-abs-btn-sm.cancel-btn:hover { border-color: var(--e-red); color: var(--e-red); }

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

/* Modal */
.ee-abs-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.5);
    z-index: 1000;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}
.ee-abs-modal-overlay.active { display: flex; }

.ee-abs-modal {
    background: var(--e-surface);
    border-radius: var(--e-radius-xl);
    width: 100%;
    max-width: 540px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
}

.ee-abs-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem;
    border-bottom: 1px solid var(--e-border);
}

.ee-abs-modal-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--e-text);
}

.ee-abs-modal-close {
    width: 36px; height: 36px;
    border-radius: var(--e-radius);
    border: none; background: var(--e-bg);
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    color: var(--e-text-secondary);
    transition: all 0.2s;
}
.ee-abs-modal-close:hover { background: var(--e-border); color: var(--e-text); }

.ee-abs-modal-body { padding: 1.5rem; }

.ee-abs-form-group { margin-bottom: 1.25rem; }
.ee-abs-form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--e-text);
    margin-bottom: 0.5rem;
}
.ee-abs-form-input, .ee-abs-form-select, .ee-abs-form-textarea {
    width: 100%;
    padding: 0.75rem 1rem;
    background: var(--e-bg);
    border: 1px solid var(--e-border);
    border-radius: var(--e-radius);
    font-size: 0.9375rem;
    color: var(--e-text);
    transition: border-color 0.2s;
    box-sizing: border-box;
}
.ee-abs-form-input:focus, .ee-abs-form-select:focus, .ee-abs-form-textarea:focus {
    outline: none;
    border-color: var(--e-blue);
}
.ee-abs-form-textarea { resize: vertical; min-height: 80px; }
.ee-abs-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.ee-abs-form-hint { font-size: 0.8125rem; color: var(--e-text-secondary); margin-top: 0.375rem; }
.ee-abs-form-error { font-size: 0.8125rem; color: var(--e-red); margin-top: 0.375rem; }

.ee-abs-modal-footer {
    padding: 1.5rem;
    border-top: 1px solid var(--e-border);
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
}

.ee-abs-btn-secondary {
    padding: 0.75rem 1.5rem;
    background: var(--e-bg);
    border: 1px solid var(--e-border);
    border-radius: var(--e-radius);
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--e-text);
    cursor: pointer;
    transition: all 0.2s;
}
.ee-abs-btn-secondary:hover { background: var(--e-border); }

.ee-abs-btn-primary {
    padding: 0.75rem 1.5rem;
    background: var(--e-blue);
    border: none;
    border-radius: var(--e-radius);
    font-size: 0.9375rem;
    font-weight: 600;
    color: white;
    cursor: pointer;
    transition: all 0.2s;
}
.ee-abs-btn-primary:hover { opacity: 0.9; }

/* Responsive */
@media (max-width: 1200px) {
    .ee-abs-stats { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 1024px) {
    .ee-abs-stats { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 768px) {
    .ee-abs-stats { grid-template-columns: 1fr; }
    .ee-abs-table-wrapper { overflow-x: auto; }
    .ee-abs-history-header { flex-direction: column; align-items: flex-start; }
    .ee-abs-form-row { grid-template-columns: 1fr; }
}
</style>
@endsection

@section('content')
<div class="ee-absences-page">
    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="ee-abs-flash ee-abs-flash-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="ee-abs-flash ee-abs-flash-error">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="ee-abs-flash ee-abs-flash-error">
            @foreach($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    {{-- Info Banner --}}
    <div class="ee-abs-info animate-fade-in">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="16" x2="12" y2="12"></line>
            <line x1="12" y1="8" x2="12.01" y2="8"></line>
        </svg>
        <span>Consultez et g&eacute;rez vos absences. Vous pouvez d&eacute;clarer une absence et soumettre des justificatifs.</span>
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

        <div class="ee-abs-card pending">
            <div class="ee-abs-header">
                <div class="ee-abs-icon pending">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                </div>
                <span class="ee-abs-label">En attente</span>
            </div>
            <div class="ee-abs-value">{{ $statsAbsences['en_attente'] }}</div>
        </div>
    </div>

    {{-- History --}}
    <div class="ee-abs-history animate-fade-in" style="animation-delay: 0.1s;">
        <div class="ee-abs-history-header">
            <h2 class="ee-abs-history-title">Historique des absences</h2>
            <div class="ee-abs-history-actions">
                <select class="ee-abs-year-select" onchange="window.location.href='{{ route('espace-employe.absences') }}?annee='+this.value">
                    @foreach($anneesDisponibles as $a)
                        <option value="{{ $a }}" {{ $a == $annee ? 'selected' : '' }}>{{ $a }}</option>
                    @endforeach
                </select>
                <button type="button" class="ee-abs-btn-declare" onclick="document.getElementById('declareAbsenceModal').classList.add('active')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    D&eacute;clarer une absence
                </button>
            </div>
        </div>

        @if($absences->count() > 0)
            <div class="ee-abs-table-wrapper">
                <table class="ee-abs-table">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Dur&eacute;e</th>
                            <th>Justifi&eacute;e</th>
                            <th>Statut</th>
                            <th>Motif</th>
                            <th>Actions</th>
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
                                <td>
                                    @switch($absence->statut)
                                        @case('en_attente')
                                            <span class="ee-abs-status en-attente">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                                En attente
                                            </span>
                                            @break
                                        @case('approuvee')
                                            <span class="ee-abs-status approuvee">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                Approuv&eacute;e
                                            </span>
                                            @break
                                        @case('refusee')
                                            <span class="ee-abs-status refusee">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                Refus&eacute;e
                                            </span>
                                            @if($absence->motif_refus)
                                                <span class="ee-abs-motif-refus">{{ $absence->motif_refus }}</span>
                                            @endif
                                            @break
                                    @endswitch
                                </td>
                                <td style="font-size:0.875rem;color:var(--e-text-secondary);max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $absence->motif }}">
                                    {{ $absence->motif ?? '-' }}
                                </td>
                                <td>
                                    <div class="ee-abs-actions">
                                        {{-- Justifier: non-justified approved absences from admin --}}
                                        @if(!$absence->justifiee && $absence->statut === 'approuvee' && $absence->source === 'admin')
                                            <button type="button" class="ee-abs-btn-sm justify-btn" onclick="openJustifyModal({{ $absence->id }})">
                                                Justifier
                                            </button>
                                        @endif

                                        {{-- Annuler: en_attente employee-sourced absences --}}
                                        @if($absence->statut === 'en_attente' && $absence->source === 'employe')
                                            <form action="{{ route('espace-employe.absences.annuler', $absence) }}" method="POST" onsubmit="return confirm('Annuler cette d\u00e9claration d\u0027absence ?')">
                                                @csrf
                                                <button type="submit" class="ee-abs-btn-sm cancel-btn">Annuler</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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

{{-- Modal D&eacute;clarer une absence --}}
<div class="ee-abs-modal-overlay" id="declareAbsenceModal">
    <div class="ee-abs-modal">
        <div class="ee-abs-modal-header">
            <h3 class="ee-abs-modal-title">D&eacute;clarer une absence</h3>
            <button class="ee-abs-modal-close" onclick="document.getElementById('declareAbsenceModal').classList.remove('active')">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        <form action="{{ route('espace-employe.absences.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="ee-abs-modal-body">
                <div class="ee-abs-form-group">
                    <label class="ee-abs-form-label">Type d'absence *</label>
                    <select name="type_absence_id" class="ee-abs-form-select" required>
                        <option value="">S&eacute;lectionnez un type</option>
                        @foreach($typesAbsence as $type)
                            <option value="{{ $type->id }}" {{ old('type_absence_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('type_absence_id')
                        <p class="ee-abs-form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="ee-abs-form-row">
                    <div class="ee-abs-form-group">
                        <label class="ee-abs-form-label">Date de l'absence *</label>
                        <input type="date" name="date_absence" class="ee-abs-form-input" value="{{ old('date_absence') }}" required>
                        @error('date_absence')
                            <p class="ee-abs-form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="ee-abs-form-group">
                        <label class="ee-abs-form-label">Dur&eacute;e *</label>
                        <select name="duree_type" id="dureeTypeSelect" class="ee-abs-form-select" required onchange="toggleMinutesRetard()">
                            <option value="">S&eacute;lectionnez</option>
                            <option value="journee" {{ old('duree_type') == 'journee' ? 'selected' : '' }}>Journ&eacute;e enti&egrave;re</option>
                            <option value="demi_journee" {{ old('duree_type') == 'demi_journee' ? 'selected' : '' }}>Demi-journ&eacute;e</option>
                            <option value="retard" {{ old('duree_type') == 'retard' ? 'selected' : '' }}>Retard</option>
                            <option value="depart_anticipe" {{ old('duree_type') == 'depart_anticipe' ? 'selected' : '' }}>D&eacute;part anticip&eacute;</option>
                        </select>
                        @error('duree_type')
                            <p class="ee-abs-form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="ee-abs-form-group" id="minutesRetardGroup" style="display: none;">
                    <label class="ee-abs-form-label">Dur&eacute;e du retard (minutes)</label>
                    <input type="number" name="minutes_retard" id="minutesRetardInput" class="ee-abs-form-input" value="{{ old('minutes_retard') }}" min="1" max="480" placeholder="Ex: 30">
                    @error('minutes_retard')
                        <p class="ee-abs-form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="ee-abs-form-group">
                    <label class="ee-abs-form-label">Motif *</label>
                    <textarea name="motif" class="ee-abs-form-textarea" placeholder="Indiquez la raison de votre absence" required>{{ old('motif') }}</textarea>
                    @error('motif')
                        <p class="ee-abs-form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="ee-abs-form-group">
                    <label class="ee-abs-form-label">Justificatif</label>
                    <input type="file" name="justificatif" class="ee-abs-form-input" accept=".pdf,.jpg,.jpeg,.png">
                    <p class="ee-abs-form-hint">PDF, JPG ou PNG - Max 5 Mo</p>
                    @error('justificatif')
                        <p class="ee-abs-form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="ee-abs-modal-footer">
                <button type="button" class="ee-abs-btn-secondary" onclick="document.getElementById('declareAbsenceModal').classList.remove('active')">Annuler</button>
                <button type="submit" class="ee-abs-btn-primary">Soumettre la d&eacute;claration</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Justifier une absence --}}
<div class="ee-abs-modal-overlay" id="justifyModal">
    <div class="ee-abs-modal">
        <div class="ee-abs-modal-header">
            <h3 class="ee-abs-modal-title">Soumettre un justificatif</h3>
            <button class="ee-abs-modal-close" onclick="document.getElementById('justifyModal').classList.remove('active')">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        <form id="justifyForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="ee-abs-modal-body">
                <div class="ee-abs-form-group">
                    <label class="ee-abs-form-label">Justificatif *</label>
                    <input type="file" name="justificatif" class="ee-abs-form-input" accept=".pdf,.jpg,.jpeg,.png" required>
                    <p class="ee-abs-form-hint">PDF, JPG ou PNG - Max 5 Mo</p>
                </div>

                <div class="ee-abs-form-group">
                    <label class="ee-abs-form-label">Commentaire</label>
                    <textarea name="motif" class="ee-abs-form-textarea" placeholder="Commentaire optionnel concernant le justificatif"></textarea>
                </div>
            </div>
            <div class="ee-abs-modal-footer">
                <button type="button" class="ee-abs-btn-secondary" onclick="document.getElementById('justifyModal').classList.remove('active')">Annuler</button>
                <button type="submit" class="ee-abs-btn-primary">Soumettre le justificatif</button>
            </div>
        </form>
    </div>
</div>

<script>
// Fermer les modals en cliquant sur l'overlay
document.querySelectorAll('.ee-abs-modal-overlay').forEach(function(overlay) {
    overlay.addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('active');
    });
});

// Toggle minutes_retard field
function toggleMinutesRetard() {
    var select = document.getElementById('dureeTypeSelect');
    var group = document.getElementById('minutesRetardGroup');
    var input = document.getElementById('minutesRetardInput');
    if (select.value === 'retard') {
        group.style.display = '';
    } else {
        group.style.display = 'none';
        input.value = '';
    }
}

// Open justify modal with dynamic form action
function openJustifyModal(absenceId) {
    var form = document.getElementById('justifyForm');
    form.action = '{{ url("mon-espace/absences") }}/' + absenceId + '/justifier';
    document.getElementById('justifyModal').classList.add('active');
}

// Init: toggle minutes_retard on page load (in case of old value)
toggleMinutesRetard();

// Reopen declare modal if validation errors exist
@if($errors->any())
    document.getElementById('declareAbsenceModal').classList.add('active');
@endif
</script>
@endsection
