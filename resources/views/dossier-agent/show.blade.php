@extends('layouts.app')

@section('title', 'Dossier de ' . $personnel->nom . ' ' . $personnel->prenoms)

@section('styles')
<style>
:root {
    --da-primary: #667eea;
    --da-secondary: #764ba2;
    --da-success: #10b981;
    --da-danger: #ef4444;
    --da-warning: #f59e0b;
    --da-info: #3b82f6;
}

.dossier-show-page {
    padding: 1.5rem;
    min-height: 100vh;
    background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
}

/* Header Agent */
.agent-header {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.agent-profile {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    flex: 1;
    min-width: 300px;
}

.agent-avatar {
    width: 100px;
    height: 100px;
    border-radius: 20px;
    background: linear-gradient(135deg, var(--da-primary) 0%, var(--da-secondary) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2.5rem;
    font-weight: 700;
    flex-shrink: 0;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.35);
}

.agent-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 20px;
}

.agent-details h1 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 0.5rem 0;
}

.agent-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    color: #64748b;
    font-size: 0.875rem;
}

.agent-meta span {
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.agent-stats-row {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    align-items: center;
}

.agent-stat-box {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
    border-radius: 14px;
    padding: 1rem 1.5rem;
    text-align: center;
    min-width: 100px;
}

.agent-stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--da-primary);
    line-height: 1;
}

.agent-stat-value.success { color: var(--da-success); }
.agent-stat-value.danger { color: var(--da-danger); }
.agent-stat-value.warning { color: var(--da-warning); }

.agent-stat-label {
    font-size: 0.75rem;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    margin-top: 0.25rem;
}

/* Actions */
.agent-actions {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.btn-action {
    padding: 0.75rem 1.25rem;
    border-radius: 12px;
    border: none;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, var(--da-primary) 0%, var(--da-secondary) 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    color: white;
}

.btn-secondary {
    background: #f1f5f9;
    color: #475569;
}

.btn-secondary:hover {
    background: #e2e8f0;
}

/* Tabs Catégories */
.categories-tabs {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    margin-bottom: 1.5rem;
    padding: 0.5rem;
    background: white;
    border-radius: 14px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
}

.category-tab {
    padding: 0.75rem 1.25rem;
    border-radius: 10px;
    border: none;
    background: transparent;
    color: #64748b;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
}

.category-tab:hover {
    background: rgba(102, 126, 234, 0.08);
    color: var(--da-primary);
}

.category-tab.active {
    background: linear-gradient(135deg, var(--da-primary) 0%, var(--da-secondary) 100%);
    color: white;
}

.category-tab .badge {
    padding: 0.125rem 0.5rem;
    background: rgba(255,255,255,0.2);
    border-radius: 20px;
    font-size: 0.75rem;
}

.category-tab:not(.active) .badge {
    background: #e2e8f0;
    color: #64748b;
}

/* Documents Grid */
.documents-section {
    margin-bottom: 2rem;
}

.documents-section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
    padding: 0 0.5rem;
}

.documents-section-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.125rem;
    font-weight: 600;
    color: #1e293b;
}

.documents-section-title .icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.documents-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1rem;
}

.document-card {
    background: white;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    transition: all 0.3s;
    border: 2px solid transparent;
}

.document-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    border-color: var(--da-primary);
}

.document-card-header {
    padding: 1rem;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
}

.document-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.document-icon.pdf { background: #fef2f2; color: #dc2626; }
.document-icon.doc { background: #eff6ff; color: #2563eb; }
.document-icon.xls { background: #f0fdf4; color: #16a34a; }
.document-icon.img { background: #fefce8; color: #ca8a04; }
.document-icon.default { background: #f1f5f9; color: #64748b; }

.document-info {
    flex: 1;
    min-width: 0;
}

.document-title {
    font-weight: 600;
    color: #1e293b;
    font-size: 0.938rem;
    margin: 0 0 0.25rem 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.document-filename {
    font-size: 0.75rem;
    color: #94a3b8;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.document-badges {
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
.doc-badge.confidentiel { background: #fef3c7; color: #92400e; }

.document-card-body {
    padding: 1rem;
}

.document-meta {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.5rem;
    font-size: 0.75rem;
    color: #64748b;
    margin-bottom: 1rem;
}

.document-meta-item {
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.document-actions {
    display: flex;
    gap: 0.5rem;
}

.doc-btn {
    flex: 1;
    padding: 0.625rem;
    border-radius: 8px;
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
    background: linear-gradient(135deg, var(--da-primary) 0%, var(--da-secondary) 100%);
    color: white;
}

.doc-btn.preview {
    background: #f1f5f9;
    color: #475569;
}

.doc-btn.delete {
    background: #fef2f2;
    color: #dc2626;
    padding: 0.625rem 0.75rem;
    flex: 0;
}

.doc-btn:hover {
    transform: translateY(-1px);
}

/* Empty Category */
.empty-category {
    text-align: center;
    padding: 3rem;
    background: white;
    border-radius: 14px;
    border: 2px dashed #e2e8f0;
}

.empty-category-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto 1rem;
    background: #f1f5f9;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
}

/* Upload Modal */
.upload-modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.7);
    backdrop-filter: blur(4px);
    z-index: 10000;
    align-items: center;
    justify-content: center;
}

.upload-modal.show {
    display: flex;
}

.upload-modal-content {
    background: white;
    border-radius: 20px;
    width: 90%;
    max-width: 600px;
    max-height: 90vh;
    overflow-y: auto;
}

.upload-modal-header {
    background: linear-gradient(135deg, var(--da-primary) 0%, var(--da-secondary) 100%);
    color: white;
    padding: 1.5rem;
    position: relative;
}

.upload-modal-header h3 {
    margin: 0;
    font-size: 1.25rem;
}

.upload-modal-close {
    position: absolute;
    right: 1rem;
    top: 1rem;
    background: rgba(255,255,255,0.2);
    border: none;
    color: white;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 1.25rem;
    transition: all 0.2s;
}

.upload-modal-close:hover {
    background: rgba(255,255,255,0.3);
    transform: rotate(90deg);
}

.upload-modal-body {
    padding: 1.5rem;
}

.form-group {
    margin-bottom: 1.25rem;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    font-size: 0.938rem;
    transition: all 0.2s;
}

.form-control:focus {
    outline: none;
    border-color: var(--da-primary);
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
}

.file-upload-zone {
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
}

.file-upload-zone:hover {
    border-color: var(--da-primary);
    background: rgba(102, 126, 234, 0.04);
}

.file-upload-zone.dragover {
    border-color: var(--da-primary);
    background: rgba(102, 126, 234, 0.08);
}

.file-upload-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto 1rem;
    background: linear-gradient(135deg, var(--da-primary) 0%, var(--da-secondary) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.form-check {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-check input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: var(--da-primary);
}

.upload-modal-footer {
    padding: 1rem 1.5rem;
    background: #f8fafc;
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
}

/* Breadcrumb */
.breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    font-size: 0.875rem;
}

.breadcrumb a {
    color: #64748b;
    text-decoration: none;
}

.breadcrumb a:hover {
    color: var(--da-primary);
}

.breadcrumb span {
    color: #94a3b8;
}

/* Responsive */
@media (max-width: 768px) {
    .agent-header {
        flex-direction: column;
    }

    .agent-profile {
        flex-direction: column;
        text-align: center;
    }

    .agent-meta {
        justify-content: center;
    }

    .agent-stats-row {
        justify-content: center;
    }

    .agent-actions {
        justify-content: center;
    }

    .form-row {
        grid-template-columns: 1fr;
    }

    .documents-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection

@section('content')
<div class="dossier-show-page">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('admin.dossier-agent.index') }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
            </svg>
            Dossiers Agents
        </a>
        <span>/</span>
        <span>{{ $personnel->nom }} {{ $personnel->prenoms }}</span>
    </div>

    <!-- Header Agent -->
    <div class="agent-header">
        <div class="agent-profile">
            <div class="agent-avatar">
                @if($personnel->photo)
                    <img src="{{ asset('storage/' . $personnel->photo) }}" alt="{{ $personnel->nom }}">
                @else
                    {{ strtoupper(substr($personnel->nom, 0, 1) . substr($personnel->prenoms, 0, 1)) }}
                @endif
            </div>
            <div class="agent-details">
                <h1>{{ $personnel->nom }} {{ $personnel->prenoms }}</h1>
                <div class="agent-meta">
                    <span>
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                        </svg>
                        {{ $personnel->matricule ?? 'Sans matricule' }}
                    </span>
                    @if($personnel->departement)
                    <span>
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        {{ $personnel->departement->nom }}
                    </span>
                    @endif
                    @if($personnel->poste)
                    <span>
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        {{ $personnel->poste }}
                    </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="agent-stats-row">
            <div class="agent-stat-box">
                <div class="agent-stat-value">{{ $stats['total'] }}</div>
                <div class="agent-stat-label">Documents</div>
            </div>
            <div class="agent-stat-box">
                <div class="agent-stat-value success">{{ $stats['actifs'] }}</div>
                <div class="agent-stat-label">Actifs</div>
            </div>
            @if($stats['expires'] > 0)
            <div class="agent-stat-box">
                <div class="agent-stat-value danger">{{ $stats['expires'] }}</div>
                <div class="agent-stat-label">Expirés</div>
            </div>
            @endif
            @if($stats['expirent_bientot'] > 0)
            <div class="agent-stat-box">
                <div class="agent-stat-value warning">{{ $stats['expirent_bientot'] }}</div>
                <div class="agent-stat-label">Expirent bientôt</div>
            </div>
            @endif
        </div>

        <div class="agent-actions">
            <button onclick="openUploadModal()" class="btn-action btn-primary">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                Ajouter un document
            </button>
            <a href="{{ route('admin.personnels.show', $personnel) }}" class="btn-action btn-secondary">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Fiche employé
            </a>
        </div>
    </div>

    @if(session('success'))
    <div style="background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    <!-- Documents par catégorie -->
    @foreach($categories as $categorie)
    <div class="documents-section" id="category-{{ $categorie->id }}">
        <div class="documents-section-header">
            <div class="documents-section-title">
                <div class="icon" style="background: {{ $categorie->couleur }};">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                </div>
                {{ $categorie->nom }}
                <span style="color: #94a3b8; font-weight: 400;">({{ $categorie->documents_count ?? count($documentsByCategory[$categorie->id] ?? []) }})</span>
            </div>
        </div>

        @if(isset($documentsByCategory[$categorie->id]) && count($documentsByCategory[$categorie->id]) > 0)
        <div class="documents-grid">
            @foreach($documentsByCategory[$categorie->id] as $document)
            @include('dossier-agent.partials.document-card', ['document' => $document])
            @endforeach
        </div>
        @else
        <div class="empty-category">
            <div class="empty-category-icon">
                <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <p style="color: #64748b; margin: 0;">Aucun document dans cette catégorie</p>
        </div>
        @endif
    </div>
    @endforeach

    <!-- Documents sans catégorie -->
    @if(count($documentsSansCategorie) > 0)
    <div class="documents-section">
        <div class="documents-section-header">
            <div class="documents-section-title">
                <div class="icon" style="background: #94a3b8;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                Non classés
                <span style="color: #94a3b8; font-weight: 400;">({{ count($documentsSansCategorie) }})</span>
            </div>
        </div>
        <div class="documents-grid">
            @foreach($documentsSansCategorie as $document)
            @include('dossier-agent.partials.document-card', ['document' => $document])
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- Modal Upload -->
<div class="upload-modal" id="uploadModal">
    <div class="upload-modal-content">
        <div class="upload-modal-header">
            <h3>Ajouter un document</h3>
            <button class="upload-modal-close" onclick="closeUploadModal()">&times;</button>
        </div>
        <form action="{{ route('admin.dossier-agent.store', $personnel) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="upload-modal-body">
                <div class="form-group">
                    <label class="form-label">Fichier *</label>
                    <div class="file-upload-zone" id="dropZone">
                        <input type="file" name="document" id="fileInput" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.webp" required style="display: none;">
                        <div class="file-upload-icon">
                            <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                        </div>
                        <p style="margin: 0; color: #64748b;" id="fileLabel">Cliquez ou glissez un fichier ici</p>
                        <small style="color: #94a3b8;">PDF, DOC, XLS, images. Max 10 Mo</small>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Catégorie</label>
                    <select name="categorie_id" class="form-control">
                        <option value="">Sans catégorie</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Titre du document</label>
                    <input type="text" name="titre" class="form-control" placeholder="Ex: CNI recto-verso">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Date du document</label>
                        <input type="date" name="date_document" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Date d'expiration</label>
                        <input type="date" name="date_expiration" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Référence</label>
                    <input type="text" name="reference" class="form-control" placeholder="Ex: N° de contrat, N° CNI...">
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="2" placeholder="Notes sur ce document..."></textarea>
                </div>

                <div style="display: flex; gap: 2rem;">
                    <div class="form-check">
                        <input type="checkbox" name="confidentiel" id="confidentiel" value="1">
                        <label for="confidentiel">Document confidentiel</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="visible_employe" id="visible_employe" value="1" checked>
                        <label for="visible_employe">Visible par l'employé</label>
                    </div>
                </div>
            </div>
            <div class="upload-modal-footer">
                <button type="button" class="btn-action btn-secondary" onclick="closeUploadModal()">Annuler</button>
                <button type="submit" class="btn-action btn-primary">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    Uploader
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function openUploadModal() {
    document.getElementById('uploadModal').classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeUploadModal() {
    document.getElementById('uploadModal').classList.remove('show');
    document.body.style.overflow = '';
}

// Fermer modal en cliquant à l'extérieur
document.getElementById('uploadModal').addEventListener('click', function(e) {
    if (e.target === this) closeUploadModal();
});

// Drag & Drop
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('fileInput');
const fileLabel = document.getElementById('fileLabel');

dropZone.addEventListener('click', () => fileInput.click());

dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('dragover');
});

dropZone.addEventListener('dragleave', () => {
    dropZone.classList.remove('dragover');
});

dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('dragover');
    if (e.dataTransfer.files.length) {
        fileInput.files = e.dataTransfer.files;
        fileLabel.textContent = e.dataTransfer.files[0].name;
    }
});

fileInput.addEventListener('change', () => {
    if (fileInput.files.length) {
        fileLabel.textContent = fileInput.files[0].name;
    }
});

// Supprimer document
function deleteDocument(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce document ?')) {
        fetch(`/dossier-agent/document/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erreur lors de la suppression');
            }
        })
        .catch(() => alert('Erreur lors de la suppression'));
    }
}

// Escape pour fermer
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeUploadModal();
});
</script>
@endsection
