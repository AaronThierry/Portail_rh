@extends('layouts.espace-employe')

@section('title', 'Mes Documents')
@section('page-title', $currentCategory ? $currentCategory->nom : 'Mes Documents')
@section('breadcrumb')
    <a href="{{ route('espace-employe.dashboard') }}">Accueil</a>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
    @if($currentCategory)
        <a href="{{ route('espace-employe.documents') }}">Mes Documents</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
        <span>{{ $currentCategory->nom }}</span>
    @else
        <span>Mes Documents</span>
    @endif
@endsection

@section('styles')
<style>
/* ==================== DOCUMENTS PAGE - FILE EXPLORER STYLE ==================== */
.ee-documents-page {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

/* ==================== HEADER BANNER ==================== */
.ee-docs-banner {
    background: var(--e-slate-800);
    border-radius: var(--e-radius-xl);
    padding: 2rem;
    color: white;
    position: relative;
    overflow: hidden;
    box-shadow: var(--e-shadow-lg);
    border-top: 3px solid var(--e-amber);
}

.ee-docs-banner-content {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
}

.ee-docs-banner-left {
    flex: 1;
}

.ee-docs-banner-icon {
    width: 56px;
    height: 56px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: var(--e-radius);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
    border: 1px solid rgba(255, 255, 255, 0.15);
}

.ee-docs-banner-icon svg {
    width: 28px;
    height: 28px;
}

.ee-docs-banner-title {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    letter-spacing: -0.5px;
}

.ee-docs-banner-subtitle {
    font-size: 0.9375rem;
    color: rgba(255, 255, 255, 0.75);
    max-width: 400px;
    line-height: 1.5;
}

.ee-docs-banner-stats {
    display: flex;
    gap: 1rem;
}

.ee-banner-stat {
    background: rgba(255, 255, 255, 0.1);
    padding: 1.25rem 1.5rem;
    border-radius: var(--e-radius);
    border: 1px solid rgba(255, 255, 255, 0.15);
    text-align: center;
    min-width: 90px;
}

.ee-banner-stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    line-height: 1;
    color: white;
}

.ee-banner-stat-label {
    font-size: 0.6875rem;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.7);
    margin-top: 0.375rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* ==================== NAVIGATION BAR ==================== */
.ee-nav-bar {
    background: var(--e-surface);
    border-radius: var(--e-radius-lg);
    border: 1px solid var(--e-border);
    padding: 1rem 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: var(--e-shadow-sm);
}

.ee-nav-back {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1rem;
    background: var(--e-bg);
    border: 2px solid var(--e-border);
    border-radius: var(--e-radius);
    color: var(--e-text);
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.ee-nav-back:hover {
    border-color: var(--e-blue);
    color: var(--e-blue);
    background: var(--e-blue-wash);
}

.ee-nav-back svg {
    width: 18px;
    height: 18px;
}

.ee-nav-path {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex: 1;
    overflow-x: auto;
}

.ee-nav-path::-webkit-scrollbar {
    display: none;
}

.ee-path-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.875rem;
    background: var(--e-bg);
    border-radius: 10px;
    font-size: 0.8125rem;
    font-weight: 600;
    color: var(--e-text);
    text-decoration: none;
    white-space: nowrap;
    transition: all 0.3s ease;
}

.ee-path-item:hover {
    background: var(--e-blue-wash);
    color: var(--e-blue);
}

.ee-path-item.current {
    background: var(--e-blue);
    color: white;
}

.ee-path-item svg {
    width: 16px;
    height: 16px;
}

.ee-path-separator {
    color: var(--e-text-tertiary);
}

.ee-path-separator svg {
    width: 16px;
    height: 16px;
}

.ee-nav-search {
    position: relative;
    width: 280px;
}

.ee-nav-search-icon {
    position: absolute;
    left: 0.875rem;
    top: 50%;
    transform: translateY(-50%);
    width: 18px;
    height: 18px;
    color: var(--e-text-secondary);
    pointer-events: none;
}

.ee-nav-search input {
    width: 100%;
    padding: 0.625rem 1rem 0.625rem 2.5rem;
    background: var(--e-bg);
    border: 2px solid var(--e-border);
    border-radius: var(--e-radius);
    font-size: 0.875rem;
    color: var(--e-text);
    transition: all 0.3s ease;
}

.ee-nav-search input::placeholder {
    color: var(--e-text-tertiary);
}

.ee-nav-search input:focus {
    outline: none;
    border-color: var(--e-blue);
    box-shadow: 0 0 0 4px var(--e-blue-wash);
}

/* ==================== FOLDERS GRID ==================== */
.ee-folders-section {
    background: var(--e-surface);
    border-radius: var(--e-radius-lg);
    border: 1px solid var(--e-border);
    overflow: hidden;
    box-shadow: var(--e-shadow);
}

.ee-folders-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--e-border);
    background: var(--e-bg);
}

.ee-folders-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1rem;
    font-weight: 700;
    color: var(--e-text);
}

.ee-folders-title-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: var(--e-blue);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.ee-folders-title-icon svg {
    width: 18px;
    height: 18px;
}

.ee-folders-count {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--e-text-secondary);
    background: var(--e-bg);
    padding: 0.375rem 0.75rem;
    border-radius: 8px;
}

.ee-folders-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
    padding: 1.5rem;
}

/* Folder Card */
.ee-folder-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 1.5rem 1rem;
    background: var(--e-bg);
    border: 2px solid transparent;
    border-radius: var(--e-radius-lg);
    text-decoration: none;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    position: relative;
    border-top: 3px solid var(--folder-color, var(--e-blue));
}

.ee-folder-card:hover {
    border-color: var(--folder-color, var(--e-blue));
    border-top-color: var(--folder-color, var(--e-blue));
    transform: translateY(-2px);
    box-shadow: var(--e-shadow-lg);
}

.ee-folder-icon {
    width: 72px;
    height: 72px;
    margin-bottom: 1rem;
    position: relative;
    z-index: 1;
}

.ee-folder-icon-bg {
    width: 100%;
    height: 100%;
    border-radius: var(--e-radius);
    background: var(--folder-color, var(--e-blue));
    opacity: 0.15;
    position: absolute;
    top: 0;
    left: 0;
}

.ee-folder-icon svg {
    width: 100%;
    height: 100%;
    color: var(--folder-color, var(--e-blue));
    position: relative;
    z-index: 1;
}

.ee-folder-info {
    text-align: center;
    position: relative;
    z-index: 1;
    width: 100%;
}

.ee-folder-name {
    font-size: 0.9375rem;
    font-weight: 700;
    color: var(--e-text);
    margin-bottom: 0.375rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.ee-folder-count {
    font-size: 0.75rem;
    color: var(--e-text-secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.375rem;
}

.ee-folder-count svg {
    width: 14px;
    height: 14px;
}

.ee-folder-badge {
    position: absolute;
    top: 0.75rem;
    right: 0.75rem;
    background: var(--folder-color, var(--e-blue));
    color: white;
    font-size: 0.6875rem;
    font-weight: 700;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    z-index: 2;
}

/* ==================== FILES LIST ==================== */
.ee-files-section {
    background: var(--e-surface);
    border-radius: var(--e-radius-lg);
    border: 1px solid var(--e-border);
    overflow: hidden;
    box-shadow: var(--e-shadow);
}

.ee-files-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--e-border);
    background: var(--e-bg);
}

.ee-files-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.ee-category-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 10px;
    font-size: 0.875rem;
    font-weight: 700;
    color: white;
}

.ee-category-badge svg {
    width: 18px;
    height: 18px;
}

.ee-files-count {
    font-size: 0.8125rem;
    color: var(--e-text-secondary);
}

.ee-view-toggle {
    display: flex;
    gap: 0.25rem;
    background: var(--e-bg);
    padding: 0.25rem;
    border-radius: 10px;
}

.ee-view-btn {
    padding: 0.5rem;
    border: none;
    background: transparent;
    border-radius: 8px;
    color: var(--e-text-secondary);
    cursor: pointer;
    transition: all 0.3s ease;
}

.ee-view-btn:hover {
    color: var(--e-blue);
}

.ee-view-btn.active {
    background: var(--e-surface);
    color: var(--e-blue);
    box-shadow: var(--e-shadow-sm);
}

.ee-view-btn svg {
    width: 18px;
    height: 18px;
}

/* Files Grid View */
.ee-files-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1rem;
    padding: 1.5rem;
}

/* Files List View */
.ee-files-list {
    display: flex;
    flex-direction: column;
}

.ee-file-row {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--e-border);
    transition: all 0.3s ease;
}

.ee-file-row:last-child {
    border-bottom: none;
}

.ee-file-row:hover {
    background: var(--e-bg);
}

/* File Card (Grid) */
.ee-file-card {
    background: var(--e-bg);
    border-radius: var(--e-radius);
    padding: 1.25rem;
    border: 2px solid transparent;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.ee-file-card:hover {
    border-color: var(--file-color, var(--e-blue));
    transform: translateY(-2px);
    box-shadow: var(--e-shadow-lg);
}

.ee-file-card-header {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1rem;
}

.ee-file-icon {
    width: 48px;
    height: 48px;
    border-radius: var(--e-radius);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    position: relative;
}

.ee-file-icon svg {
    width: 24px;
    height: 24px;
}

.ee-file-icon.pdf {
    background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
    color: white;
    --file-color: #EF4444;
}

.ee-file-icon.doc {
    background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
    color: white;
    --file-color: #3B82F6;
}

.ee-file-icon.img {
    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    color: white;
    --file-color: #10B981;
}

.ee-file-icon.xls {
    background: linear-gradient(135deg, #22C55E 0%, #16A34A 100%);
    color: white;
    --file-color: #22C55E;
}

.ee-file-icon.default {
    background: linear-gradient(135deg, #6B7280 0%, #4B5563 100%);
    color: white;
    --file-color: #6B7280;
}

.ee-file-info {
    flex: 1;
    min-width: 0;
}

.ee-file-name {
    font-size: 0.9375rem;
    font-weight: 700;
    color: var(--e-text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: 0.25rem;
}

.ee-file-ext {
    font-size: 0.6875rem;
    font-weight: 700;
    color: var(--e-text-secondary);
    text-transform: uppercase;
    background: var(--e-surface);
    padding: 0.125rem 0.5rem;
    border-radius: 4px;
}

.ee-file-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.ee-file-meta-item {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    color: var(--e-text-secondary);
}

.ee-file-meta-item svg {
    width: 14px;
    height: 14px;
    opacity: 0.7;
}

.ee-file-actions {
    display: flex;
    gap: 0.5rem;
}

.ee-file-btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.375rem;
    padding: 0.625rem;
    border-radius: 10px;
    font-size: 0.75rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    border: none;
}

.ee-file-btn svg {
    width: 16px;
    height: 16px;
}

.ee-file-btn.primary {
    background: var(--e-blue);
    color: white;
}

.ee-file-btn.primary:hover {
    transform: translateY(-2px);
    box-shadow: var(--e-shadow);
}

.ee-file-btn.secondary {
    background: var(--e-surface);
    color: var(--e-text);
    border: 1px solid var(--e-border);
}

.ee-file-btn.secondary:hover {
    border-color: var(--e-blue);
    color: var(--e-blue);
}

/* ==================== EMPTY STATES ==================== */
.ee-empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.ee-empty-illustration {
    width: 120px;
    height: 120px;
    margin: 0 auto 1.5rem;
    background: var(--e-bg);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.ee-empty-illustration svg {
    width: 56px;
    height: 56px;
    color: var(--e-text-secondary);
    opacity: 0.5;
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
    max-width: 320px;
    margin: 0 auto;
    line-height: 1.6;
}

/* ==================== RESPONSIVE ==================== */
@media (max-width: 1024px) {
    .ee-docs-banner-content {
        flex-direction: column;
        text-align: center;
    }

    .ee-docs-banner-stats {
        justify-content: center;
    }

    .ee-nav-bar {
        flex-wrap: wrap;
    }

    .ee-nav-search {
        width: 100%;
        order: 3;
        margin-top: 0.5rem;
    }

    .ee-folders-grid {
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
    }
}

@media (max-width: 768px) {
    .ee-docs-banner {
        padding: 1.5rem;
    }

    .ee-docs-banner-title {
        font-size: 1.375rem;
    }

    .ee-banner-stat {
        padding: 1rem;
        min-width: 70px;
    }

    .ee-banner-stat-value {
        font-size: 1.5rem;
    }

    .ee-files-grid {
        grid-template-columns: 1fr;
    }

    .ee-folders-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
        padding: 1rem;
    }

    .ee-folder-card {
        padding: 1rem 0.75rem;
    }

    .ee-folder-icon {
        width: 56px;
        height: 56px;
    }
}

@media (max-width: 480px) {
    .ee-folders-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .ee-docs-banner-stats {
        flex-direction: row;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .ee-banner-stat {
        flex: 1;
        min-width: 70px;
    }
}
</style>
@endsection

@section('content')
<div class="ee-documents-page">
    <!-- Header Banner -->
    <div class="ee-docs-banner animate-fade-in">
        <div class="ee-docs-banner-content">
            <div class="ee-docs-banner-left">
                <div class="ee-docs-banner-icon">
                    @if($currentCategory)
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 3h18v18H3zM3 9h18M9 21V9"></path>
                        </svg>
                    @endif
                </div>
                <h1 class="ee-docs-banner-title">
                    {{ $currentCategory ? $currentCategory->nom : 'Mon Dossier Personnel' }}
                </h1>
                <p class="ee-docs-banner-subtitle">
                    @if($currentCategory)
                        {{ $currentCategory->description ?? 'Documents de la categorie ' . $currentCategory->nom }}
                    @else
                        Vos documents sont organises par categories pour un acces rapide et facile.
                    @endif
                </p>
            </div>
            <div class="ee-docs-banner-stats">
                <div class="ee-banner-stat">
                    <div class="ee-banner-stat-value">{{ $stats['total'] }}</div>
                    <div class="ee-banner-stat-label">Documents</div>
                </div>
                <div class="ee-banner-stat">
                    <div class="ee-banner-stat-value">{{ $stats['categories'] }}</div>
                    <div class="ee-banner-stat-label">Dossiers</div>
                </div>
                <div class="ee-banner-stat">
                    <div class="ee-banner-stat-value">{{ $stats['recent'] }}</div>
                    <div class="ee-banner-stat-label">Recents</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Bar -->
    <div class="ee-nav-bar animate-fade-in" style="animation-delay: 0.1s;">
        @if($currentCategory)
            <a href="{{ route('espace-employe.documents') }}" class="ee-nav-back">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
                Retour
            </a>
        @endif

        <div class="ee-nav-path">
            <a href="{{ route('espace-employe.documents') }}" class="ee-path-item {{ !$currentCategory ? 'current' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                </svg>
                Mon Dossier
            </a>
            @if($currentCategory)
                <span class="ee-path-separator">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </span>
                <span class="ee-path-item current">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                    </svg>
                    {{ $currentCategory->nom }}
                </span>
            @endif
        </div>

        <div class="ee-nav-search">
            <svg class="ee-nav-search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="text" placeholder="Rechercher un document..." id="searchInput">
        </div>
    </div>

    @if(!$currentCategory)
        <!-- FOLDERS VIEW -->
        @if($categoriesWithDocs->count() > 0 || $uncategorizedDocs->count() > 0)
            <div class="ee-folders-section animate-fade-in" style="animation-delay: 0.2s;">
                <div class="ee-folders-header">
                    <div class="ee-folders-title">
                        <div class="ee-folders-title-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                            </svg>
                        </div>
                        Mes Dossiers
                    </div>
                    <span class="ee-folders-count">{{ $categoriesWithDocs->count() + ($uncategorizedDocs->count() > 0 ? 1 : 0) }} dossier(s)</span>
                </div>

                <div class="ee-folders-grid">
                    @foreach($categoriesWithDocs as $category)
                        @php
                            $docsCount = $documentsByCategory->get($category->id, collect([]))->count();
                            $folderColor = $category->couleur ?? '#6366F1';
                        @endphp
                        <a href="{{ route('espace-employe.documents', ['categorie' => $category->id]) }}"
                           class="ee-folder-card"
                           style="--folder-color: {{ $folderColor }};"
                           data-name="{{ strtolower($category->nom) }}">
                            @if($documentsByCategory->get($category->id, collect([]))->where('created_at', '>=', now()->subDays(7))->count() > 0)
                                <span class="ee-folder-badge">Nouveau</span>
                            @endif
                            <div class="ee-folder-icon">
                                <div class="ee-folder-icon-bg"></div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 12H4V8h16v10z"/>
                                </svg>
                            </div>
                            <div class="ee-folder-info">
                                <div class="ee-folder-name">{{ $category->nom }}</div>
                                <div class="ee-folder-count">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                    </svg>
                                    {{ $docsCount }} document{{ $docsCount > 1 ? 's' : '' }}
                                </div>
                            </div>
                        </a>
                    @endforeach

                    @if($uncategorizedDocs->count() > 0)
                        <a href="{{ route('espace-employe.documents', ['categorie' => '0']) }}"
                           class="ee-folder-card"
                           style="--folder-color: #6B7280;"
                           data-name="autres documents">
                            <div class="ee-folder-icon">
                                <div class="ee-folder-icon-bg"></div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 12H4V8h16v10z"/>
                                </svg>
                            </div>
                            <div class="ee-folder-info">
                                <div class="ee-folder-name">Autres Documents</div>
                                <div class="ee-folder-count">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                    </svg>
                                    {{ $uncategorizedDocs->count() }} document{{ $uncategorizedDocs->count() > 1 ? 's' : '' }}
                                </div>
                            </div>
                        </a>
                    @endif
                </div>
            </div>
        @else
            <div class="ee-folders-section animate-fade-in" style="animation-delay: 0.2s;">
                <div class="ee-empty-state">
                    <div class="ee-empty-illustration">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="ee-empty-title">Aucun document disponible</h3>
                    <p class="ee-empty-text">
                        Votre dossier personnel est vide pour le moment.
                        Les documents seront affiches ici une fois ajoutes par l'administration.
                    </p>
                </div>
            </div>
        @endif

    @else
        <!-- FILES VIEW (Inside a category) -->
        @php
            $filesToShow = $selectedCategory == '0' ? $uncategorizedDocs : $documents;
            $categoryColor = $currentCategory ? ($currentCategory->couleur ?? '#6366F1') : '#6B7280';
        @endphp

        <div class="ee-files-section animate-fade-in" style="animation-delay: 0.2s;">
            <div class="ee-files-header">
                <div class="ee-files-title">
                    <span class="ee-category-badge" style="background: {{ $categoryColor }};">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                        </svg>
                        {{ $currentCategory ? $currentCategory->nom : 'Autres Documents' }}
                    </span>
                    <span class="ee-files-count">{{ $filesToShow->count() }} document{{ $filesToShow->count() > 1 ? 's' : '' }}</span>
                </div>
                <div class="ee-view-toggle">
                    <button class="ee-view-btn active" data-view="grid" title="Vue grille">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                        </svg>
                    </button>
                    <button class="ee-view-btn" data-view="list" title="Vue liste">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="8" y1="6" x2="21" y2="6"></line>
                            <line x1="8" y1="12" x2="21" y2="12"></line>
                            <line x1="8" y1="18" x2="21" y2="18"></line>
                            <line x1="3" y1="6" x2="3.01" y2="6"></line>
                            <line x1="3" y1="12" x2="3.01" y2="12"></line>
                            <line x1="3" y1="18" x2="3.01" y2="18"></line>
                        </svg>
                    </button>
                </div>
            </div>

            @if($filesToShow->count() > 0)
                <div class="ee-files-grid" id="filesContainer">
                    @foreach($filesToShow as $document)
                        @php
                            $extension = strtolower($document->extension ?? pathinfo($document->chemin ?? '', PATHINFO_EXTENSION));
                            $iconClass = 'default';
                            if (in_array($extension, ['pdf'])) $iconClass = 'pdf';
                            elseif (in_array($extension, ['doc', 'docx'])) $iconClass = 'doc';
                            elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) $iconClass = 'img';
                            elseif (in_array($extension, ['xls', 'xlsx', 'csv'])) $iconClass = 'xls';
                        @endphp
                        <div class="ee-file-card" data-name="{{ strtolower($document->titre ?? $document->nom_original ?? '') }}">
                            <div class="ee-file-card-header">
                                <div class="ee-file-icon {{ $iconClass }}">
                                    @if($iconClass === 'pdf')
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                        </svg>
                                    @elseif($iconClass === 'img')
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                            <polyline points="21 15 16 10 5 21"></polyline>
                                        </svg>
                                    @elseif($iconClass === 'xls')
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                            <rect x="8" y="12" width="8" height="6" rx="1"></rect>
                                        </svg>
                                    @elseif($iconClass === 'doc')
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                            <line x1="16" y1="13" x2="8" y2="13"></line>
                                            <line x1="16" y1="17" x2="8" y2="17"></line>
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                        </svg>
                                    @endif
                                </div>
                                <div class="ee-file-info">
                                    <div class="ee-file-name">{{ $document->titre ?? $document->nom_original ?? 'Document' }}</div>
                                    <span class="ee-file-ext">.{{ $extension ?: 'fichier' }}</span>
                                </div>
                            </div>

                            <div class="ee-file-meta">
                                <span class="ee-file-meta-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    {{ $document->created_at->format('d/m/Y') }}
                                </span>
                                @if($document->taille)
                                    <span class="ee-file-meta-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                            <polyline points="17 8 12 3 7 8"></polyline>
                                            <line x1="12" y1="3" x2="12" y2="15"></line>
                                        </svg>
                                        {{ number_format($document->taille / 1024, 0) }} Ko
                                    </span>
                                @endif
                            </div>

                            <div class="ee-file-actions">
                                <a href="{{ route('espace-employe.documents.preview', $document->id) }}" class="ee-file-btn primary" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                    Voir
                                </a>
                                <a href="{{ route('espace-employe.documents.download', $document->id) }}" class="ee-file-btn secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                    </svg>
                                    Telecharger
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="ee-empty-state">
                    <div class="ee-empty-illustration">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                        </svg>
                    </div>
                    <h3 class="ee-empty-title">Dossier vide</h3>
                    <p class="ee-empty-text">
                        Ce dossier ne contient aucun document pour le moment.
                    </p>
                </div>
            @endif
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const items = document.querySelectorAll('.ee-folder-card, .ee-file-card');

            items.forEach(item => {
                const name = item.dataset.name || '';
                if (name.includes(query) || query === '') {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }

    // View toggle (grid/list)
    const viewBtns = document.querySelectorAll('.ee-view-btn');
    const filesContainer = document.getElementById('filesContainer');

    viewBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            viewBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const view = this.dataset.view;
            if (filesContainer) {
                if (view === 'list') {
                    filesContainer.classList.remove('ee-files-grid');
                    filesContainer.classList.add('ee-files-list');
                } else {
                    filesContainer.classList.remove('ee-files-list');
                    filesContainer.classList.add('ee-files-grid');
                }
            }
        });
    });
});
</script>
@endsection
