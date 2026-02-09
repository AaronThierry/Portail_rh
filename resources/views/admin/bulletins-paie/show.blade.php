
@extends('layouts.app')

@section('title', 'Bulletin de Paie - ' . $bulletin->personnel->nom_complet)
@section('page-title', 'Bulletin de Paie')
@section('page-subtitle', $bulletin->periode_formatee)

@section('styles')
<style>
:root {
    --bp-primary: #4A90D9;
    --bp-primary-dark: #2E6BB3;
    --bp-primary-light: #E8F4FD;
    --bp-success: #22C55E;
    --bp-success-light: #F0FDF4;
    --bp-danger: #EF4444;
    --bp-bg: #f8fafc;
    --bp-card-bg: #ffffff;
    --bp-card-border: #e2e8f0;
    --bp-text-primary: #1e293b;
    --bp-text-secondary: #64748b;
    --bp-text-muted: #94a3b8;
    --bp-shadow: rgba(0, 0, 0, 0.04);
}

.dark {
    --bp-bg: #0f172a;
    --bp-card-bg: #1e293b;
    --bp-card-border: #334155;
    --bp-text-primary: #f1f5f9;
    --bp-text-secondary: #94a3b8;
    --bp-text-muted: #64748b;
    --bp-shadow: rgba(0, 0, 0, 0.3);
    --bp-primary-light: rgba(74, 144, 217, 0.15);
    --bp-success-light: rgba(34, 197, 94, 0.15);
}

.bp-show-page {
    padding: 1.5rem;
    min-height: 100vh;
    background: var(--bp-bg);
}

.bp-breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
    font-size: 0.9rem;
    color: var(--bp-text-secondary);
}

.bp-breadcrumb a {
    color: var(--bp-primary);
    text-decoration: none;
}

.bp-breadcrumb a:hover {
    text-decoration: underline;
}

.bp-show-card {
    background: var(--bp-card-bg);
    border-radius: 20px;
    box-shadow: 0 4px 20px var(--bp-shadow);
    border: 1px solid var(--bp-card-border);
    overflow: hidden;
    margin-bottom: 1.5rem;
}

.bp-show-header {
    background: linear-gradient(135deg, var(--bp-primary) 0%, var(--bp-primary-dark) 100%);
    padding: 2rem;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.bp-show-header h1 {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0 0 0.25rem 0;
}

.bp-show-header p {
    margin: 0;
    opacity: 0.9;
    font-size: 0.95rem;
}

.bp-show-actions {
    display: flex;
    gap: 0.75rem;
}

.bp-show-actions a,
.bp-show-actions button {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.2s ease;
    border: none;
    text-decoration: none;
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.bp-show-actions a:hover,
.bp-show-actions button:hover {
    background: rgba(255, 255, 255, 0.3);
}

.bp-show-actions svg {
    width: 18px;
    height: 18px;
}

.bp-show-body {
    padding: 2rem;
}

.bp-detail-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
}

.bp-detail-group {
    padding: 1.25rem;
    background: var(--bp-bg);
    border-radius: 12px;
}

.bp-detail-group h3 {
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--bp-text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin: 0 0 1rem 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.bp-detail-group h3 svg {
    width: 16px;
    height: 16px;
}

.bp-detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid var(--bp-card-border);
}

.bp-detail-row:last-child {
    border-bottom: none;
}

.bp-detail-label {
    font-size: 0.875rem;
    color: var(--bp-text-secondary);
}

.bp-detail-value {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--bp-text-primary);
}

.bp-status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.bp-status-badge.publie {
    background: var(--bp-success-light);
    color: var(--bp-success);
}

.bp-status-badge.brouillon {
    background: #FEF3C7;
    color: #D97706;
}

.bp-status-badge.archive {
    background: #F1F5F9;
    color: var(--bp-text-muted);
}

.bp-pdf-preview {
    background: var(--bp-card-bg);
    border-radius: 20px;
    box-shadow: 0 4px 20px var(--bp-shadow);
    border: 1px solid var(--bp-card-border);
    overflow: hidden;
}

.bp-pdf-preview h3 {
    padding: 1rem 1.5rem;
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
    color: var(--bp-text-primary);
    border-bottom: 1px solid var(--bp-card-border);
}

.bp-pdf-preview iframe {
    width: 100%;
    height: 600px;
    border: none;
}

.bp-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.2s ease;
    border: none;
    text-decoration: none;
}

.bp-btn svg { width: 18px; height: 18px; }

.bp-btn-secondary {
    background: var(--bp-bg);
    color: var(--bp-text-primary);
    border: 1px solid var(--bp-card-border);
}

.bp-btn-secondary:hover {
    border-color: var(--bp-primary);
    color: var(--bp-primary);
}

@media (max-width: 768px) {
    .bp-show-page { padding: 1rem; }
    .bp-show-header { flex-direction: column; align-items: flex-start; }
    .bp-detail-grid { grid-template-columns: 1fr; }
    .bp-pdf-preview iframe { height: 400px; }
}
</style>
@endsection

@section('content')
<div class="bp-show-page">
    <div class="bp-breadcrumb">
        <a href="{{ route('admin.bulletins-paie.index') }}">Bulletins de Paie</a>
        <span>/</span>
        <span>{{ $bulletin->personnel->nom_complet }} - {{ $bulletin->periode_formatee }}</span>
    </div>

    <div class="bp-show-card">
        <div class="bp-show-header">
            <div>
                <h1>{{ $bulletin->personnel->nom_complet }}</h1>
                <p>Bulletin de paie - {{ $bulletin->periode_formatee }}</p>
            </div>
            <div class="bp-show-actions">
                <a href="{{ route('admin.bulletins-paie.preview', $bulletin) }}" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                    Ouvrir PDF
                </a>
                <a href="{{ route('admin.bulletins-paie.download', $bulletin) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    Telecharger
                </a>
            </div>
        </div>

        <div class="bp-show-body">
            <div class="bp-detail-grid">
                {{-- Informations employe --}}
                <div class="bp-detail-group">
                    <h3>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        Employe
                    </h3>
                    <div class="bp-detail-row">
                        <span class="bp-detail-label">Nom complet</span>
                        <span class="bp-detail-value">{{ $bulletin->personnel->nom_complet }}</span>
                    </div>
                    <div class="bp-detail-row">
                        <span class="bp-detail-label">Matricule</span>
                        <span class="bp-detail-value">{{ $bulletin->personnel->matricule }}</span>
                    </div>
                </div>

                {{-- Informations bulletin --}}
                <div class="bp-detail-group">
                    <h3>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                        </svg>
                        Bulletin
                    </h3>
                    <div class="bp-detail-row">
                        <span class="bp-detail-label">Reference</span>
                        <span class="bp-detail-value">{{ $bulletin->reference }}</span>
                    </div>
                    <div class="bp-detail-row">
                        <span class="bp-detail-label">Periode</span>
                        <span class="bp-detail-value">{{ $bulletin->periode_formatee }}</span>
                    </div>
                    <div class="bp-detail-row">
                        <span class="bp-detail-label">Statut</span>
                        <span class="bp-status-badge {{ $bulletin->statut }}">{{ ucfirst($bulletin->statut) }}</span>
                    </div>
                    <div class="bp-detail-row">
                        <span class="bp-detail-label">Visible employe</span>
                        <span class="bp-detail-value">{{ $bulletin->visible_employe ? 'Oui' : 'Non' }}</span>
                    </div>
                </div>

                {{-- Informations fichier --}}
                <div class="bp-detail-group">
                    <h3>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                            <polyline points="13 2 13 9 20 9"></polyline>
                        </svg>
                        Fichier
                    </h3>
                    <div class="bp-detail-row">
                        <span class="bp-detail-label">Nom original</span>
                        <span class="bp-detail-value">{{ $bulletin->fichier_nom_original }}</span>
                    </div>
                    <div class="bp-detail-row">
                        <span class="bp-detail-label">Taille</span>
                        <span class="bp-detail-value">{{ $bulletin->fichier_taille_formatee }}</span>
                    </div>
                    <div class="bp-detail-row">
                        <span class="bp-detail-label">Date d'upload</span>
                        <span class="bp-detail-value">{{ $bulletin->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    @if($bulletin->uploadedBy)
                    <div class="bp-detail-row">
                        <span class="bp-detail-label">Uploade par</span>
                        <span class="bp-detail-value">{{ $bulletin->uploadedBy->name }}</span>
                    </div>
                    @endif
                </div>

                {{-- Salaires (si renseignes) --}}
                @if($bulletin->salaire_brut || $bulletin->salaire_net)
                <div class="bp-detail-group">
                    <h3>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="1" x2="12" y2="23"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                        Salaires
                    </h3>
                    @if($bulletin->salaire_brut)
                    <div class="bp-detail-row">
                        <span class="bp-detail-label">Salaire brut</span>
                        <span class="bp-detail-value">{{ number_format($bulletin->salaire_brut, 0, ',', ' ') }} FCFA</span>
                    </div>
                    @endif
                    @if($bulletin->salaire_net)
                    <div class="bp-detail-row">
                        <span class="bp-detail-label">Salaire net</span>
                        <span class="bp-detail-value">{{ number_format($bulletin->salaire_net, 0, ',', ' ') }} FCFA</span>
                    </div>
                    @endif
                </div>
                @endif
            </div>

            @if($bulletin->commentaire)
            <div class="bp-detail-group" style="margin-top: 1.5rem;">
                <h3>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                    Commentaire
                </h3>
                <p style="margin: 0; color: var(--bp-text-secondary); font-size: 0.9rem;">{{ $bulletin->commentaire }}</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Apercu PDF --}}
    <div class="bp-pdf-preview">
        <h3>Apercu du document</h3>
        <iframe src="{{ route('admin.bulletins-paie.preview', $bulletin) }}"></iframe>
    </div>

    <div style="margin-top: 1.5rem;">
        <a href="{{ route('admin.bulletins-paie.index', ['annee' => $bulletin->annee, 'mois' => $bulletin->mois]) }}" class="bp-btn bp-btn-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Retour a la liste
        </a>
    </div>
</div>
@endsection
