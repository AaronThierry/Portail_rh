@extends('layouts.espace-employe')

@section('title', 'Mes Documents')
@section('page-title', 'Mes Documents')
@section('breadcrumb')
    <a href="{{ route('espace-employe.dashboard') }}">Accueil</a>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
    <span>Mes Documents</span>
@endsection

@section('styles')
<style>
.ee-documents-page {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

/* Stats Bar */
.ee-stats-bar {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
}

.ee-stat-mini {
    background: var(--ee-card);
    border-radius: 16px;
    border: 1px solid var(--ee-border);
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.ee-stat-mini-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.ee-stat-mini-icon svg {
    width: 24px;
    height: 24px;
}

.ee-stat-mini-icon.blue {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.15) 0%, rgba(99, 102, 241, 0.05) 100%);
    color: var(--ee-primary);
}

.ee-stat-mini-icon.green {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0.05) 100%);
    color: var(--ee-success);
}

.ee-stat-mini-icon.orange {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(245, 158, 11, 0.05) 100%);
    color: var(--ee-warning);
}

.ee-stat-mini-icon.red {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(239, 68, 68, 0.05) 100%);
    color: var(--ee-danger);
}

.ee-stat-mini-value {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--ee-text);
}

.ee-stat-mini-label {
    font-size: 0.8125rem;
    color: var(--ee-text-muted);
}

/* Documents Card */
.ee-documents-card {
    background: var(--ee-card);
    border-radius: 20px;
    border: 1px solid var(--ee-border);
    overflow: hidden;
}

.ee-documents-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem;
    border-bottom: 1px solid var(--ee-border);
}

.ee-documents-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--ee-text);
}

.ee-documents-filters {
    display: flex;
    gap: 0.75rem;
}

.ee-filter-btn {
    padding: 0.5rem 1rem;
    background: var(--ee-bg-alt);
    border: 1px solid var(--ee-border);
    border-radius: 10px;
    font-size: 0.8125rem;
    font-weight: 600;
    color: var(--ee-text-muted);
    cursor: pointer;
    transition: all 0.25s ease;
}

.ee-filter-btn:hover, .ee-filter-btn.active {
    background: var(--ee-primary-light);
    border-color: var(--ee-primary);
    color: var(--ee-primary);
}

/* Documents Grid */
.ee-documents-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1rem;
    padding: 1.5rem;
}

.ee-document-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1.25rem;
    background: var(--ee-bg-alt);
    border-radius: 14px;
    border: 1px solid transparent;
    transition: all 0.3s ease;
}

.ee-document-item:hover {
    border-color: var(--ee-primary);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px var(--ee-shadow);
}

.ee-document-icon {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.ee-document-icon svg {
    width: 26px;
    height: 26px;
}

.ee-document-icon.pdf {
    background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
    color: white;
}

.ee-document-icon.doc {
    background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
    color: white;
}

.ee-document-icon.img {
    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    color: white;
}

.ee-document-icon.default {
    background: linear-gradient(135deg, #6B7280 0%, #4B5563 100%);
    color: white;
}

.ee-document-content {
    flex: 1;
    min-width: 0;
}

.ee-document-name {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--ee-text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: 0.25rem;
}

.ee-document-category {
    font-size: 0.75rem;
    color: var(--ee-primary);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.ee-document-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    font-size: 0.75rem;
    color: var(--ee-text-muted);
}

.ee-document-actions {
    display: flex;
    gap: 0.5rem;
}

.ee-doc-action {
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 10px;
    background: var(--ee-card);
    color: var(--ee-text-muted);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.25s ease;
}

.ee-doc-action:hover {
    background: var(--ee-primary);
    color: white;
}

.ee-doc-action svg {
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
    .ee-stats-bar {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 640px) {
    .ee-stats-bar {
        grid-template-columns: 1fr;
    }

    .ee-documents-grid {
        grid-template-columns: 1fr;
    }

    .ee-documents-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }

    .ee-documents-filters {
        width: 100%;
        overflow-x: auto;
    }
}
</style>
@endsection

@section('content')
<div class="ee-documents-page">
    <!-- Stats Bar -->
    <div class="ee-stats-bar animate-fade-in">
        <div class="ee-stat-mini">
            <div class="ee-stat-mini-icon blue">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                </svg>
            </div>
            <div>
                <div class="ee-stat-mini-value">{{ $documents->count() }}</div>
                <div class="ee-stat-mini-label">Total documents</div>
            </div>
        </div>
        <div class="ee-stat-mini">
            <div class="ee-stat-mini-icon green">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <div>
                <div class="ee-stat-mini-value">{{ $documents->where('statut', 'actif')->count() }}</div>
                <div class="ee-stat-mini-label">Documents actifs</div>
            </div>
        </div>
        <div class="ee-stat-mini">
            <div class="ee-stat-mini-icon orange">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </div>
            <div>
                <div class="ee-stat-mini-value">{{ $documents->where('statut', 'en_attente')->count() }}</div>
                <div class="ee-stat-mini-label">En attente</div>
            </div>
        </div>
        <div class="ee-stat-mini">
            <div class="ee-stat-mini-icon red">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                    <line x1="12" y1="9" x2="12" y2="13"></line>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg>
            </div>
            <div>
                <div class="ee-stat-mini-value">{{ $documents->where('statut', 'expire')->count() }}</div>
                <div class="ee-stat-mini-label">Expirés</div>
            </div>
        </div>
    </div>

    <!-- Documents Card -->
    <div class="ee-documents-card animate-fade-in" style="animation-delay: 0.1s;">
        <div class="ee-documents-header">
            <h2 class="ee-documents-title">Mes Documents</h2>
            <div class="ee-documents-filters">
                <button class="ee-filter-btn active">Tous</button>
                <button class="ee-filter-btn">Contrats</button>
                <button class="ee-filter-btn">Attestations</button>
                <button class="ee-filter-btn">Identité</button>
            </div>
        </div>

        @if($documents->count() > 0)
            <div class="ee-documents-grid">
                @foreach($documents as $document)
                    @php
                        $extension = pathinfo($document->fichier, PATHINFO_EXTENSION);
                        $iconClass = 'default';
                        if (in_array($extension, ['pdf'])) $iconClass = 'pdf';
                        elseif (in_array($extension, ['doc', 'docx'])) $iconClass = 'doc';
                        elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) $iconClass = 'img';
                    @endphp
                    <div class="ee-document-item">
                        <div class="ee-document-icon {{ $iconClass }}">
                            @if($iconClass === 'pdf')
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                </svg>
                            @elseif($iconClass === 'img')
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                </svg>
                            @endif
                        </div>
                        <div class="ee-document-content">
                            <div class="ee-document-name">{{ $document->nom }}</div>
                            <div class="ee-document-category">{{ $document->categorie->nom ?? 'Non catégorisé' }}</div>
                            <div class="ee-document-meta">
                                <span>{{ $document->created_at->format('d/m/Y') }}</span>
                                @if($document->date_expiration)
                                    <span>Expire: {{ $document->date_expiration->format('d/m/Y') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="ee-document-actions">
                            <a href="{{ route('espace-employe.documents.preview', $document->id) }}" class="ee-doc-action" title="Voir" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </a>
                            <a href="{{ route('espace-employe.documents.download', $document->id) }}" class="ee-doc-action" title="Télécharger">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="ee-empty-state">
                <div class="ee-empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                </div>
                <h3 class="ee-empty-title">Aucun document</h3>
                <p class="ee-empty-text">Votre dossier ne contient pas encore de documents.</p>
            </div>
        @endif
    </div>
</div>
@endsection
