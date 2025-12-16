@extends('layouts.app')

@section('title', 'Mon Dossier')
@section('page-title', 'Mon Dossier')

@section('styles')
<style>
:root {
    /* RH+ Brand Colors */
    --md-primary: #4A90D9;
    --md-primary-dark: #2E6BB3;
    --md-success: #27AE60;
    --md-danger: #ef4444;
    --md-warning: #E67E22;
    --md-accent: #F5A623;
    --md-bg: #f8fafc;
    --md-card: #ffffff;
    --md-text: #1e293b;
    --md-text-muted: #64748b;
    --md-border: #e2e8f0;
}

.dark {
    --md-primary: #5BA3E8;
    --md-primary-dark: #4A90D9;
    --md-success: #2ECC71;
    --md-warning: #F5A623;
    --md-bg: #0f172a;
    --md-card: #1e293b;
    --md-text: #f1f5f9;
    --md-text-muted: #94a3b8;
    --md-border: #334155;
}

.mon-dossier-page {
    padding: 1.5rem;
    min-height: 100vh;
    background: var(--md-bg);
}

/* Header Profil */
.profile-header {
    background: var(--md-card);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: 1px solid var(--md-border);
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
    align-items: center;
}

.profile-avatar {
    width: 100px;
    height: 100px;
    border-radius: 20px;
    background: linear-gradient(135deg, var(--md-primary) 0%, var(--md-primary-dark) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2.5rem;
    font-weight: 700;
    flex-shrink: 0;
    box-shadow: 0 8px 25px rgba(74, 144, 217, 0.3);
}

.profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 20px;
}

.profile-info {
    flex: 1;
    min-width: 250px;
}

.profile-info h1 {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--md-text);
    margin: 0 0 0.5rem 0;
}

.profile-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    color: var(--md-text-muted);
    font-size: 0.875rem;
}

.profile-meta-item {
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.profile-meta-item svg {
    width: 16px;
    height: 16px;
    opacity: 0.7;
}

/* Stats Cards */
.stats-row {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.stat-card {
    background: linear-gradient(135deg, rgba(74, 144, 217, 0.1) 0%, rgba(46, 107, 179, 0.1) 100%);
    border-radius: 14px;
    padding: 1rem 1.5rem;
    text-align: center;
    min-width: 90px;
    border: 1px solid rgba(74, 144, 217, 0.2);
}

.stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--md-primary);
    line-height: 1;
}

.stat-value.success { color: var(--md-success); }
.stat-value.danger { color: var(--md-danger); }
.stat-value.warning { color: var(--md-warning); }

.stat-label {
    font-size: 0.75rem;
    color: var(--md-text-muted);
    text-transform: uppercase;
    letter-spacing: 0.3px;
    margin-top: 0.25rem;
}

/* Catégorie Section */
.category-section {
    margin-bottom: 2rem;
}

.category-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
    padding: 0 0.25rem;
}

.category-icon {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    flex-shrink: 0;
}

.category-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--md-text);
}

.category-count {
    color: var(--md-text-muted);
    font-weight: 400;
    font-size: 0.875rem;
}

/* Documents Grid */
.documents-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1rem;
}

.doc-card {
    background: var(--md-card);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    border: 1px solid var(--md-border);
    transition: all 0.3s ease;
}

.doc-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    border-color: var(--md-primary);
}

.doc-card-header {
    padding: 1.25rem;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    background: linear-gradient(135deg, rgba(74, 144, 217, 0.04) 0%, rgba(46, 107, 179, 0.04) 100%);
}

.doc-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.doc-icon.pdf { background: #fef2f2; color: #dc2626; }
.doc-icon.doc { background: #eff6ff; color: #2563eb; }
.doc-icon.xls { background: #f0fdf4; color: #16a34a; }
.doc-icon.img { background: #fefce8; color: #ca8a04; }
.doc-icon.default { background: #f1f5f9; color: #64748b; }

.doc-info {
    flex: 1;
    min-width: 0;
}

.doc-title {
    font-weight: 600;
    color: var(--md-text);
    font-size: 0.938rem;
    margin: 0 0 0.25rem 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.doc-filename {
    font-size: 0.75rem;
    color: var(--md-text-muted);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.doc-badges {
    display: flex;
    gap: 0.375rem;
    flex-wrap: wrap;
    margin-top: 0.5rem;
}

.doc-badge {
    padding: 0.125rem 0.5rem;
    border-radius: 20px;
    font-size: 0.688rem;
    font-weight: 600;
}

.doc-badge.expire { background: #fef2f2; color: #dc2626; }
.doc-badge.expiring { background: #fffbeb; color: #d97706; }

.doc-card-body {
    padding: 1rem 1.25rem;
}

.doc-meta {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.5rem;
    font-size: 0.75rem;
    color: var(--md-text-muted);
    margin-bottom: 1rem;
}

.doc-meta-item {
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.doc-meta-item svg {
    width: 14px;
    height: 14px;
    opacity: 0.6;
}

.doc-actions {
    display: flex;
    gap: 0.5rem;
}

.doc-btn {
    flex: 1;
    padding: 0.75rem;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    font-size: 0.813rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.375rem;
    transition: all 0.2s;
    text-decoration: none;
}

.doc-btn.download {
    background: linear-gradient(135deg, var(--md-primary) 0%, var(--md-primary-dark) 100%);
    color: white;
}

.doc-btn.preview {
    background: rgba(74, 144, 217, 0.1);
    color: var(--md-primary);
}

.doc-btn:hover {
    transform: translateY(-1px);
    opacity: 0.9;
}

/* Empty State */
.empty-category {
    text-align: center;
    padding: 2.5rem;
    background: var(--md-card);
    border-radius: 16px;
    border: 2px dashed var(--md-border);
}

.empty-icon {
    width: 56px;
    height: 56px;
    margin: 0 auto 1rem;
    background: rgba(74, 144, 217, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--md-text-muted);
}

.empty-text {
    color: var(--md-text-muted);
    margin: 0;
    font-size: 0.875rem;
}

/* Info Banner */
.info-banner {
    background: linear-gradient(135deg, rgba(74, 144, 217, 0.1) 0%, rgba(46, 107, 179, 0.1) 100%);
    border: 1px solid rgba(74, 144, 217, 0.2);
    border-radius: 14px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: var(--md-text);
}

.info-banner svg {
    width: 20px;
    height: 20px;
    color: var(--md-primary);
    flex-shrink: 0;
}

.info-banner p {
    margin: 0;
    font-size: 0.875rem;
}

/* Responsive */
@media (max-width: 768px) {
    .mon-dossier-page {
        padding: 1rem;
    }

    .profile-header {
        flex-direction: column;
        text-align: center;
    }

    .profile-meta {
        justify-content: center;
    }

    .stats-row {
        justify-content: center;
    }

    .documents-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection

@section('content')
<div class="mon-dossier-page">
    <!-- Header Profil -->
    <div class="profile-header">
        <div class="profile-avatar">
            @if($personnel->photo)
                <img src="{{ asset('storage/' . $personnel->photo) }}" alt="{{ $personnel->nom }}">
            @else
                {{ strtoupper(substr($personnel->nom, 0, 1) . substr($personnel->prenoms, 0, 1)) }}
            @endif
        </div>

        <div class="profile-info">
            <h1>{{ $personnel->nom }} {{ $personnel->prenoms }}</h1>
            <div class="profile-meta">
                @if($personnel->matricule)
                <div class="profile-meta-item">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/>
                    </svg>
                    {{ $personnel->matricule }}
                </div>
                @endif
                @if($personnel->departement)
                <div class="profile-meta-item">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    {{ $personnel->departement->nom }}
                </div>
                @endif
                @if($personnel->poste)
                <div class="profile-meta-item">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    {{ $personnel->poste }}
                </div>
                @endif
            </div>
        </div>

        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-value">{{ $stats['total'] }}</div>
                <div class="stat-label">Documents</div>
            </div>
            <div class="stat-card">
                <div class="stat-value success">{{ $stats['actifs'] }}</div>
                <div class="stat-label">Actifs</div>
            </div>
            @if($stats['expires'] > 0)
            <div class="stat-card">
                <div class="stat-value danger">{{ $stats['expires'] }}</div>
                <div class="stat-label">Expirés</div>
            </div>
            @endif
            @if($stats['expirent_bientot'] > 0)
            <div class="stat-card">
                <div class="stat-value warning">{{ $stats['expirent_bientot'] }}</div>
                <div class="stat-label">Expirent bientôt</div>
            </div>
            @endif
        </div>
    </div>

    <!-- Info Banner -->
    <div class="info-banner">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p>Voici les documents de votre dossier personnel. Contactez les RH pour toute modification ou ajout de document.</p>
    </div>

    @if($stats['expires'] > 0)
    <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 14px; padding: 1rem 1.25rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
        <svg width="20" height="20" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24">
            <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>
        <p style="margin: 0; color: #991b1b; font-size: 0.875rem;">
            <strong>{{ $stats['expires'] }} document(s) expiré(s)</strong> - Veuillez contacter les RH pour les renouveler.
        </p>
    </div>
    @endif

    <!-- Documents par catégorie -->
    @php $hasDocuments = false; @endphp

    @foreach($categories as $categorie)
        @if(isset($documentsByCategory[$categorie->id]) && count($documentsByCategory[$categorie->id]) > 0)
            @php $hasDocuments = true; @endphp
            <div class="category-section">
                <div class="category-header">
                    <div class="category-icon" style="background: {{ $categorie->couleur }};">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                        </svg>
                    </div>
                    <span class="category-title">{{ $categorie->nom }}</span>
                    <span class="category-count">({{ count($documentsByCategory[$categorie->id]) }})</span>
                </div>

                <div class="documents-grid">
                    @foreach($documentsByCategory[$categorie->id] as $document)
                        @include('dossier-agent.partials.doc-card-employe', ['document' => $document])
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach

    <!-- Documents sans catégorie -->
    @if(count($documentsSansCategorie) > 0)
        @php $hasDocuments = true; @endphp
        <div class="category-section">
            <div class="category-header">
                <div class="category-icon" style="background: #94a3b8;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <span class="category-title">Autres documents</span>
                <span class="category-count">({{ count($documentsSansCategorie) }})</span>
            </div>

            <div class="documents-grid">
                @foreach($documentsSansCategorie as $document)
                    @include('dossier-agent.partials.doc-card-employe', ['document' => $document])
                @endforeach
            </div>
        </div>
    @endif

    @if(!$hasDocuments)
    <div class="empty-category">
        <div class="empty-icon">
            <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
        <p class="empty-text">Aucun document disponible dans votre dossier pour le moment.</p>
    </div>
    @endif
</div>
@endsection
