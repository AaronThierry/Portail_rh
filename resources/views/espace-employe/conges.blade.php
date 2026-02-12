@extends('layouts.espace-employe')

@section('title', 'Mes Congés')
@section('page-title', 'Mes Congés')
@section('breadcrumb')
    <a href="{{ route('espace-employe.dashboard') }}">Accueil</a>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
    <span>Mes Congés</span>
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

.ee-status-badge.cancelled {
    background: #f1f5f9;
    color: #64748b;
}

.ee-status-badge svg {
    width: 12px;
    height: 12px;
}

/* Flash Messages */
.ee-flash {
    padding: 1rem 1.5rem;
    border-radius: var(--e-radius);
    font-size: 0.9375rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
}
.ee-flash-success { background: var(--e-emerald-pale); color: #065f46; border: 1px solid #a7f3d0; }
.ee-flash-error { background: var(--e-red-pale); color: #991b1b; border: 1px solid #fecaca; }

/* Conge Modal */
.ee-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.5);
    z-index: 1000;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}
.ee-modal-overlay.active { display: flex; }

.ee-modal {
    background: var(--e-surface);
    border-radius: var(--e-radius-xl);
    width: 100%;
    max-width: 540px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
}

.ee-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem;
    border-bottom: 1px solid var(--e-border);
}

.ee-modal-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--e-text);
}

.ee-modal-close {
    width: 36px; height: 36px;
    border-radius: var(--e-radius);
    border: none; background: var(--e-bg);
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    color: var(--e-text-secondary);
    transition: all 0.2s;
}
.ee-modal-close:hover { background: var(--e-border); color: var(--e-text); }

.ee-modal-body { padding: 1.5rem; }

.ee-form-group { margin-bottom: 1.25rem; }
.ee-form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--e-text);
    margin-bottom: 0.5rem;
}
.ee-form-input, .ee-form-select, .ee-form-textarea {
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
.ee-form-input:focus, .ee-form-select:focus, .ee-form-textarea:focus {
    outline: none;
    border-color: var(--e-blue);
}
.ee-form-textarea { resize: vertical; min-height: 80px; }
.ee-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.ee-form-hint { font-size: 0.8125rem; color: var(--e-text-secondary); margin-top: 0.375rem; }
.ee-form-error { font-size: 0.8125rem; color: var(--e-red); margin-top: 0.375rem; }

.ee-modal-footer {
    padding: 1.5rem;
    border-top: 1px solid var(--e-border);
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
}

.ee-btn-secondary {
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
.ee-btn-secondary:hover { background: var(--e-border); }

.ee-btn-primary {
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
.ee-btn-primary:hover { opacity: 0.9; }

.ee-conge-actions { display: flex; gap: 0.5rem; }
.ee-btn-cancel-sm {
    padding: 0.375rem 0.75rem;
    background: transparent;
    border: 1px solid var(--e-border);
    border-radius: var(--e-radius);
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--e-text-secondary);
    cursor: pointer;
    transition: all 0.2s;
}
.ee-btn-cancel-sm:hover { border-color: var(--e-red); color: var(--e-red); }

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
    {{-- Flash messages --}}
    @if(session('success'))
        <div class="ee-flash ee-flash-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="ee-flash ee-flash-error">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="ee-flash ee-flash-error">
            @foreach($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

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
        <button class="ee-action-btn" onclick="document.getElementById('congeModal').classList.add('active')">
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
                <select class="ee-year-select" onchange="window.location.href='{{ route('espace-employe.conges') }}?annee='+this.value">
                    @foreach($anneesDisponibles as $a)
                        <option value="{{ $a }}" {{ $a == $annee ? 'selected' : '' }}>{{ $a }}</option>
                    @endforeach
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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($conges as $conge)
                        <tr>
                            <td>
                                <div class="ee-conge-type">
                                    <div class="ee-conge-type-icon" style="background: {{ $conge->typeConge->couleur ?? 'var(--e-blue)' }}; color: white;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                        </svg>
                                    </div>
                                    <span>{{ $conge->typeConge->nom ?? 'Congé' }}</span>
                                </div>
                            </td>
                            <td>{{ $conge->date_debut->format('d/m/Y') }} - {{ $conge->date_fin->format('d/m/Y') }}</td>
                            <td>{{ $conge->nombre_jours }} {{ $conge->nombre_jours > 1 ? 'jours' : 'jour' }}</td>
                            <td>
                                @switch($conge->statut)
                                    @case('en_attente')
                                        <span class="ee-status-badge pending">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                            En attente
                                        </span>
                                        @break
                                    @case('approuve')
                                        <span class="ee-status-badge approved">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            Approuvé
                                        </span>
                                        @break
                                    @case('refuse')
                                        <span class="ee-status-badge rejected">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            Refusé
                                        </span>
                                        @break
                                    @case('annule')
                                        <span class="ee-status-badge cancelled">Annulé</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                <div class="ee-conge-actions">
                                    @if($conge->statut === 'en_attente')
                                        <form action="{{ route('espace-employe.conges.annuler', $conge) }}" method="POST" onsubmit="return confirm('Annuler cette demande ?')">
                                            @csrf
                                            <button type="submit" class="ee-btn-cancel-sm">Annuler</button>
                                        </form>
                                    @endif
                                    @if($conge->statut === 'approuve')
                                        <button class="ee-btn-cancel-sm" style="border-color: var(--e-blue); color: var(--e-blue);" onclick="openProlongerModal({{ $conge->id }}, '{{ $conge->date_fin->format('Y-m-d') }}', '{{ $conge->date_fin->format('d/m/Y') }}', '{{ addslashes($conge->typeConge->nom ?? 'Congé') }}')" title="Prolonger ce congé">Prolonger</button>
                                        @if($conge->document_officiel)
                                            <a href="{{ route('espace-employe.conges.document', $conge) }}" class="ee-btn-cancel-sm" style="border-color: var(--e-emerald); color: var(--e-emerald); text-decoration: none; display: inline-flex; align-items: center; gap: 0.25rem;" title="Télécharger la note officielle">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                                Note officielle
                                            </a>
                                        @endif
                                    @endif
                                    @if($conge->statut === 'refuse' && $conge->motif_refus)
                                        <button class="ee-btn-cancel-sm" onclick="alert('Motif du refus :\n{{ addslashes($conge->motif_refus) }}')" title="Voir le motif">Motif</button>
                                    @endif
                                </div>
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
                <p class="ee-empty-text">Vous n'avez pas encore de congés pour l'année {{ $annee }}.</p>
            </div>
        @endif
    </div>
</div>

{{-- Modal Nouvelle Demande --}}
<div class="ee-modal-overlay" id="congeModal">
    <div class="ee-modal">
        <div class="ee-modal-header">
            <h3 class="ee-modal-title">Nouvelle demande de congé</h3>
            <button class="ee-modal-close" onclick="document.getElementById('congeModal').classList.remove('active')">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        <form action="{{ route('espace-employe.conges.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="ee-modal-body">
                <div class="ee-form-group">
                    <label class="ee-form-label">Type de congé *</label>
                    <select name="type_conge_id" class="ee-form-select" required>
                        <option value="">Sélectionnez un type</option>
                        @foreach($typesConge as $type)
                            <option value="{{ $type->id }}" {{ old('type_conge_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->nom }} ({{ $type->jours_par_an }} j/an)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="ee-form-row">
                    <div class="ee-form-group">
                        <label class="ee-form-label">Date de début *</label>
                        <input type="date" name="date_debut" class="ee-form-input" value="{{ old('date_debut') }}" required min="{{ date('Y-m-d') }}">
                    </div>
                    <div class="ee-form-group">
                        <label class="ee-form-label">Date de fin *</label>
                        <input type="date" name="date_fin" class="ee-form-input" value="{{ old('date_fin') }}" required min="{{ date('Y-m-d') }}">
                    </div>
                </div>

                <div class="ee-form-group">
                    <label class="ee-form-label">Motif</label>
                    <textarea name="motif" class="ee-form-textarea" placeholder="Raison de votre demande (optionnel)">{{ old('motif') }}</textarea>
                </div>

                <div class="ee-form-group">
                    <label class="ee-form-label">Pièce jointe</label>
                    <input type="file" name="piece_jointe" class="ee-form-input" accept=".pdf,.jpg,.jpeg,.png">
                    <p class="ee-form-hint">PDF, JPG ou PNG - Max 5 Mo</p>
                </div>
            </div>
            <div class="ee-modal-footer">
                <button type="button" class="ee-btn-secondary" onclick="document.getElementById('congeModal').classList.remove('active')">Annuler</button>
                <button type="submit" class="ee-btn-primary">Soumettre la demande</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Prolongation --}}
<div class="ee-modal-overlay" id="prolongerModal">
    <div class="ee-modal">
        <div class="ee-modal-header">
            <h3 class="ee-modal-title">Prolonger un congé</h3>
            <button class="ee-modal-close" onclick="document.getElementById('prolongerModal').classList.remove('active')">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        <form id="prolongerForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="ee-modal-body">
                <div style="padding: 0.75rem; background: var(--e-blue-wash); border-radius: var(--e-radius); margin-bottom: 1.25rem; font-size: 0.875rem; color: var(--e-blue);">
                    <strong id="prolongerTypeLabel">Congé</strong> &mdash; Fin actuelle : <strong id="prolongerDateFinLabel">-</strong>
                </div>

                <div class="ee-form-group">
                    <label class="ee-form-label">Nouvelle date de fin *</label>
                    <input type="date" name="nouvelle_date_fin" id="prolongerDateFin" class="ee-form-input" required>
                    <p class="ee-form-hint">La nouvelle date doit être postérieure à la date de fin actuelle.</p>
                </div>

                <div class="ee-form-group">
                    <label class="ee-form-label">Motif de la prolongation</label>
                    <textarea name="motif" class="ee-form-textarea" placeholder="Raison de la prolongation (optionnel)"></textarea>
                </div>

                <div class="ee-form-group">
                    <label class="ee-form-label">Pièce jointe</label>
                    <input type="file" name="piece_jointe" class="ee-form-input" accept=".pdf,.jpg,.jpeg,.png">
                    <p class="ee-form-hint">PDF, JPG ou PNG - Max 5 Mo</p>
                </div>
            </div>
            <div class="ee-modal-footer">
                <button type="button" class="ee-btn-secondary" onclick="document.getElementById('prolongerModal').classList.remove('active')">Annuler</button>
                <button type="submit" class="ee-btn-primary">Demander la prolongation</button>
            </div>
        </form>
    </div>
</div>

<script>
// Fermer les modals en cliquant à l'extérieur
document.querySelectorAll('.ee-modal-overlay').forEach(function(overlay) {
    overlay.addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('active');
    });
});

// Ouvrir le modal prolonger
function openProlongerModal(congeId, dateFinYmd, dateFinFormatted, typeName) {
    document.getElementById('prolongerForm').action = '/mon-espace/conges/' + congeId + '/prolonger';
    document.getElementById('prolongerTypeLabel').textContent = typeName;
    document.getElementById('prolongerDateFinLabel').textContent = dateFinFormatted;

    var dateInput = document.getElementById('prolongerDateFin');
    // Min = lendemain de la date de fin actuelle
    var nextDay = new Date(dateFinYmd);
    nextDay.setDate(nextDay.getDate() + 1);
    var minDate = nextDay.toISOString().split('T')[0];
    dateInput.min = minDate;
    dateInput.value = '';

    document.getElementById('prolongerModal').classList.add('active');
}

// Ouvrir le modal si erreurs de validation
@if($errors->any())
    @if(old('nouvelle_date_fin'))
        document.getElementById('prolongerModal').classList.add('active');
    @else
        document.getElementById('congeModal').classList.add('active');
    @endif
@endif
</script>
@endsection
