@extends('layouts.espace-employe')

@section('title', 'Mon Profil')
@section('page-title', 'Mon Profil')
@section('breadcrumb')
    <a href="{{ route('espace-employe.dashboard') }}">Accueil</a>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
    <span>Mon Profil</span>
@endsection

@section('styles')
<style>
/* ==================== PROFIL EMPLOYE ==================== */
.ee-profil-page {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

/* Alert Messages */
.ee-alert {
    padding: 1rem 1.25rem;
    border-radius: 12px;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.ee-alert.success {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%);
    border: 1px solid rgba(16, 185, 129, 0.3);
    color: var(--ee-success);
}

.ee-alert.error {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.05) 100%);
    border: 1px solid rgba(239, 68, 68, 0.3);
    color: var(--ee-danger);
}

.ee-alert svg {
    width: 22px;
    height: 22px;
    flex-shrink: 0;
}

/* Profile Header Card */
.ee-profil-header-card {
    background: var(--ee-card);
    border-radius: 24px;
    border: 1px solid var(--ee-border);
    overflow: hidden;
}

.ee-profil-cover {
    height: 200px;
    background: linear-gradient(135deg, var(--ee-gradient-start) 0%, var(--ee-gradient-end) 100%);
    position: relative;
    overflow: hidden;
}

.ee-profil-cover::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
}

.ee-profil-cover-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, transparent 0%, rgba(0,0,0,0.3) 100%);
}

.ee-profil-main-info {
    display: flex;
    align-items: flex-end;
    gap: 2rem;
    padding: 0 2rem 2rem;
    margin-top: -80px;
    position: relative;
    z-index: 1;
}

.ee-profil-avatar-wrapper {
    position: relative;
    flex-shrink: 0;
}

.ee-profil-avatar {
    width: 160px;
    height: 160px;
    border-radius: 24px;
    border: 5px solid var(--ee-card);
    object-fit: cover;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
}

.ee-profil-avatar-edit {
    position: absolute;
    bottom: 10px;
    right: 10px;
    width: 44px;
    height: 44px;
    background: linear-gradient(135deg, var(--ee-primary) 0%, var(--ee-primary-dark) 100%);
    border: 3px solid var(--ee-card);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
}

.ee-profil-avatar-edit:hover {
    transform: scale(1.1);
}

.ee-profil-avatar-edit svg {
    width: 20px;
    height: 20px;
}

.ee-profil-identity {
    flex: 1;
    padding-bottom: 0.5rem;
}

.ee-profil-name {
    font-size: 2rem;
    font-weight: 800;
    color: var(--ee-text);
    margin-bottom: 0.5rem;
}

.ee-profil-role {
    font-size: 1.125rem;
    color: var(--ee-text-muted);
    margin-bottom: 1rem;
}

.ee-profil-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.ee-profil-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: var(--ee-bg-alt);
    border-radius: 10px;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--ee-text);
}

.ee-profil-badge svg {
    width: 16px;
    height: 16px;
    color: var(--ee-primary);
}

.ee-profil-badge.active {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0.05) 100%);
    color: var(--ee-success);
}

.ee-profil-badge.active svg {
    color: var(--ee-success);
}

.ee-profil-actions {
    display: flex;
    gap: 0.75rem;
}

.ee-profil-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.875rem 1.5rem;
    border-radius: 12px;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
}

.ee-profil-btn.primary {
    background: linear-gradient(135deg, var(--ee-primary) 0%, var(--ee-primary-dark) 100%);
    color: white;
}

.ee-profil-btn.primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(99, 102, 241, 0.3);
}

.ee-profil-btn.secondary {
    background: var(--ee-bg-alt);
    color: var(--ee-text);
    border: 1px solid var(--ee-border);
}

.ee-profil-btn.secondary:hover {
    background: var(--ee-primary-light);
    border-color: var(--ee-primary);
    color: var(--ee-primary);
}

.ee-profil-btn svg {
    width: 18px;
    height: 18px;
}

/* Content Grid */
.ee-profil-grid {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 2rem;
}

/* Info Cards */
.ee-info-card {
    background: var(--ee-card);
    border-radius: 20px;
    border: 1px solid var(--ee-border);
    overflow: hidden;
}

.ee-info-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem;
    border-bottom: 1px solid var(--ee-border);
}

.ee-info-card-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--ee-text);
}

.ee-info-card-title svg {
    width: 22px;
    height: 22px;
    color: var(--ee-primary);
}

.ee-info-card-body {
    padding: 1.5rem;
}

/* Info Grid */
.ee-info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
}

.ee-info-field {
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
}

.ee-info-field.full {
    grid-column: span 2;
}

.ee-info-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--ee-text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.ee-info-value {
    font-size: 1rem;
    font-weight: 500;
    color: var(--ee-text);
    padding: 0.75rem 1rem;
    background: var(--ee-bg-alt);
    border-radius: 10px;
}

.ee-info-value.highlight {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(99, 102, 241, 0.05) 100%);
    color: var(--ee-primary);
    font-weight: 600;
}

/* Timeline */
.ee-timeline {
    display: flex;
    flex-direction: column;
    gap: 0;
}

.ee-timeline-item {
    display: flex;
    gap: 1rem;
    padding: 1rem 0;
    position: relative;
}

.ee-timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: 19px;
    top: 48px;
    bottom: 0;
    width: 2px;
    background: var(--ee-border);
}

.ee-timeline-icon {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    z-index: 1;
}

.ee-timeline-icon.primary {
    background: linear-gradient(135deg, var(--ee-primary) 0%, var(--ee-primary-dark) 100%);
    color: white;
}

.ee-timeline-icon.success {
    background: linear-gradient(135deg, var(--ee-success) 0%, #059669 100%);
    color: white;
}

.ee-timeline-icon.warning {
    background: linear-gradient(135deg, var(--ee-warning) 0%, #D97706 100%);
    color: white;
}

.ee-timeline-icon svg {
    width: 20px;
    height: 20px;
}

.ee-timeline-content {
    flex: 1;
    padding-top: 0.25rem;
}

.ee-timeline-title {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--ee-text);
}

.ee-timeline-date {
    font-size: 0.8125rem;
    color: var(--ee-text-muted);
    margin-top: 0.25rem;
}

/* Quick Stats */
.ee-quick-stats {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.ee-quick-stat {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem;
    background: var(--ee-bg-alt);
    border-radius: 14px;
    transition: all 0.3s ease;
}

.ee-quick-stat:hover {
    transform: translateX(4px);
}

.ee-quick-stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.ee-quick-stat-icon.purple {
    background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
    color: white;
}

.ee-quick-stat-icon.green {
    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    color: white;
}

.ee-quick-stat-icon.blue {
    background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
    color: white;
}

.ee-quick-stat-icon.orange {
    background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
    color: white;
}

.ee-quick-stat-icon svg {
    width: 24px;
    height: 24px;
}

.ee-quick-stat-content {
    flex: 1;
}

.ee-quick-stat-value {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--ee-text);
    line-height: 1;
}

.ee-quick-stat-label {
    font-size: 0.8125rem;
    color: var(--ee-text-muted);
    margin-top: 0.25rem;
}

/* Edit Modal */
.ee-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(4px);
    z-index: 200;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}

.ee-modal-overlay.show {
    display: flex;
}

.ee-modal {
    background: var(--ee-card);
    border-radius: 20px;
    width: 100%;
    max-width: 500px;
    max-height: 90vh;
    overflow: hidden;
    animation: modalSlideIn 0.3s ease;
}

@keyframes modalSlideIn {
    from { opacity: 0; transform: scale(0.95) translateY(20px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}

.ee-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem;
    border-bottom: 1px solid var(--ee-border);
}

.ee-modal-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--ee-text);
}

.ee-modal-close {
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 10px;
    background: var(--ee-bg-alt);
    color: var(--ee-text-muted);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.25s ease;
}

.ee-modal-close:hover {
    background: var(--ee-danger);
    color: white;
}

.ee-modal-close svg {
    width: 20px;
    height: 20px;
}

.ee-modal-body {
    padding: 1.5rem;
    overflow-y: auto;
    max-height: calc(90vh - 160px);
}

.ee-form-group {
    margin-bottom: 1.25rem;
}

.ee-form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--ee-text);
    margin-bottom: 0.5rem;
}

.ee-form-input {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid var(--ee-border);
    border-radius: 12px;
    font-size: 1rem;
    color: var(--ee-text);
    background: var(--ee-card);
    transition: all 0.25s ease;
}

.ee-form-input:focus {
    outline: none;
    border-color: var(--ee-primary);
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
}

.ee-form-input::placeholder {
    color: var(--ee-text-light);
}

.ee-modal-footer {
    padding: 1.25rem 1.5rem;
    border-top: 1px solid var(--ee-border);
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
}

/* Photo Upload */
.ee-photo-upload {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    padding: 2rem;
    border: 2px dashed var(--ee-border);
    border-radius: 16px;
    text-align: center;
    cursor: pointer;
    transition: all 0.25s ease;
}

.ee-photo-upload:hover {
    border-color: var(--ee-primary);
    background: var(--ee-primary-light);
}

.ee-photo-upload-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: var(--ee-bg-alt);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--ee-primary);
}

.ee-photo-upload-icon svg {
    width: 28px;
    height: 28px;
}

.ee-photo-upload-text {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--ee-text);
}

.ee-photo-upload-hint {
    font-size: 0.8125rem;
    color: var(--ee-text-muted);
}

/* Responsive */
@media (max-width: 1280px) {
    .ee-profil-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .ee-profil-main-info {
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 1.5rem;
        padding: 0 1.5rem 1.5rem;
    }

    .ee-profil-avatar {
        width: 120px;
        height: 120px;
    }

    .ee-profil-badges {
        justify-content: center;
    }

    .ee-profil-actions {
        justify-content: center;
    }

    .ee-profil-name {
        font-size: 1.5rem;
    }

    .ee-info-grid {
        grid-template-columns: 1fr;
    }

    .ee-info-field.full {
        grid-column: span 1;
    }
}
</style>
@endsection

@section('content')
<div class="ee-profil-page">
    <!-- Alerts -->
    @if(session('success'))
        <div class="ee-alert success">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="ee-alert error">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="15" y1="9" x2="9" y2="15"></line>
                <line x1="9" y1="9" x2="15" y2="15"></line>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <!-- Profile Header Card -->
    <div class="ee-profil-header-card animate-fade-in">
        <div class="ee-profil-cover">
            <div class="ee-profil-cover-overlay"></div>
        </div>
        <div class="ee-profil-main-info">
            <div class="ee-profil-avatar-wrapper">
                <img src="{{ $personnel->photo_url }}" alt="Photo" class="ee-profil-avatar">
                <button class="ee-profil-avatar-edit" onclick="openEditModal('photo')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                        <circle cx="12" cy="13" r="4"></circle>
                    </svg>
                </button>
            </div>
            <div class="ee-profil-identity">
                <h1 class="ee-profil-name">{{ $personnel->nom_complet }}</h1>
                <p class="ee-profil-role">{{ $personnel->poste }}</p>
                <div class="ee-profil-badges">
                    <span class="ee-profil-badge">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        {{ $personnel->matricule }}
                    </span>
                    <span class="ee-profil-badge">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                        </svg>
                        {{ $personnel->type_contrat }}
                    </span>
                    @if($personnel->is_active)
                        <span class="ee-profil-badge active">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            Actif
                        </span>
                    @endif
                </div>
            </div>
            <div class="ee-profil-actions">
                <button class="ee-profil-btn primary" onclick="openEditModal('info')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    Modifier
                </button>
                <a href="{{ route('espace-employe.documents') }}" class="ee-profil-btn secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                    Documents
                </a>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="ee-profil-grid">
        <!-- Left Column -->
        <div style="display: flex; flex-direction: column; gap: 2rem;">
            <!-- Personal Info -->
            <div class="ee-info-card animate-fade-in" style="animation-delay: 0.1s;">
                <div class="ee-info-card-header">
                    <h2 class="ee-info-card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        Informations personnelles
                    </h2>
                </div>
                <div class="ee-info-card-body">
                    <div class="ee-info-grid">
                        <div class="ee-info-field">
                            <span class="ee-info-label">Nom</span>
                            <span class="ee-info-value">{{ $personnel->nom }}</span>
                        </div>
                        <div class="ee-info-field">
                            <span class="ee-info-label">Prénoms</span>
                            <span class="ee-info-value">{{ $personnel->prenoms }}</span>
                        </div>
                        <div class="ee-info-field">
                            <span class="ee-info-label">Civilité</span>
                            <span class="ee-info-value">{{ $personnel->civilite ?? 'Non renseigné' }}</span>
                        </div>
                        <div class="ee-info-field">
                            <span class="ee-info-label">Sexe</span>
                            <span class="ee-info-value">{{ $personnel->sexe === 'M' ? 'Masculin' : ($personnel->sexe === 'F' ? 'Féminin' : 'Non renseigné') }}</span>
                        </div>
                        <div class="ee-info-field">
                            <span class="ee-info-label">Date de naissance</span>
                            <span class="ee-info-value">{{ $personnel->date_naissance ? $personnel->date_naissance->format('d/m/Y') : 'Non renseignée' }}</span>
                        </div>
                        <div class="ee-info-field">
                            <span class="ee-info-label">N° Identification</span>
                            <span class="ee-info-value">{{ $personnel->numero_identification ?? 'Non renseigné' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="ee-info-card animate-fade-in" style="animation-delay: 0.2s;">
                <div class="ee-info-card-header">
                    <h2 class="ee-info-card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        Coordonnées
                    </h2>
                </div>
                <div class="ee-info-card-body">
                    <div class="ee-info-grid">
                        <div class="ee-info-field">
                            <span class="ee-info-label">Email</span>
                            <span class="ee-info-value">{{ $personnel->email }}</span>
                        </div>
                        <div class="ee-info-field">
                            <span class="ee-info-label">Téléphone</span>
                            <span class="ee-info-value">{{ $personnel->telephone_complet ?? 'Non renseigné' }}</span>
                        </div>
                        <div class="ee-info-field full">
                            <span class="ee-info-label">Adresse</span>
                            <span class="ee-info-value">{{ $personnel->adresse ?? 'Non renseignée' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Professional Info -->
            <div class="ee-info-card animate-fade-in" style="animation-delay: 0.3s;">
                <div class="ee-info-card-header">
                    <h2 class="ee-info-card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                        </svg>
                        Informations professionnelles
                    </h2>
                </div>
                <div class="ee-info-card-body">
                    <div class="ee-info-grid">
                        <div class="ee-info-field">
                            <span class="ee-info-label">Entreprise</span>
                            <span class="ee-info-value">{{ $personnel->entreprise->nom ?? 'Non assigné' }}</span>
                        </div>
                        <div class="ee-info-field">
                            <span class="ee-info-label">Département</span>
                            <span class="ee-info-value">{{ $personnel->departement->nom ?? 'Non assigné' }}</span>
                        </div>
                        <div class="ee-info-field">
                            <span class="ee-info-label">Service</span>
                            <span class="ee-info-value">{{ $personnel->service->nom ?? 'Non assigné' }}</span>
                        </div>
                        <div class="ee-info-field">
                            <span class="ee-info-label">Poste</span>
                            <span class="ee-info-value highlight">{{ $personnel->poste }}</span>
                        </div>
                        <div class="ee-info-field">
                            <span class="ee-info-label">Type de contrat</span>
                            <span class="ee-info-value">{{ $personnel->statut_contrat }}</span>
                        </div>
                        <div class="ee-info-field">
                            <span class="ee-info-label">Date d'embauche</span>
                            <span class="ee-info-value">{{ $personnel->date_embauche ? $personnel->date_embauche->format('d/m/Y') : 'Non renseignée' }}</span>
                        </div>
                        @if($personnel->date_fin_contrat)
                            <div class="ee-info-field full">
                                <span class="ee-info-label">Date de fin de contrat</span>
                                <span class="ee-info-value">{{ $personnel->date_fin_contrat->format('d/m/Y') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div style="display: flex; flex-direction: column; gap: 2rem;">
            <!-- Quick Stats -->
            <div class="ee-info-card animate-fade-in" style="animation-delay: 0.15s;">
                <div class="ee-info-card-header">
                    <h2 class="ee-info-card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="20" x2="18" y2="10"></line>
                            <line x1="12" y1="20" x2="12" y2="4"></line>
                            <line x1="6" y1="20" x2="6" y2="14"></line>
                        </svg>
                        Statistiques
                    </h2>
                </div>
                <div class="ee-info-card-body">
                    <div class="ee-quick-stats">
                        <div class="ee-quick-stat">
                            <div class="ee-quick-stat-icon purple">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                </svg>
                            </div>
                            <div class="ee-quick-stat-content">
                                <div class="ee-quick-stat-value">{{ $personnel->anciennete ?? 0 }}</div>
                                <div class="ee-quick-stat-label">Années d'ancienneté</div>
                            </div>
                        </div>
                        <div class="ee-quick-stat">
                            <div class="ee-quick-stat-icon green">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            </div>
                            <div class="ee-quick-stat-content">
                                <div class="ee-quick-stat-value">25</div>
                                <div class="ee-quick-stat-label">Jours de congés restants</div>
                            </div>
                        </div>
                        <div class="ee-quick-stat">
                            <div class="ee-quick-stat-icon blue">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                </svg>
                            </div>
                            <div class="ee-quick-stat-content">
                                <div class="ee-quick-stat-value">{{ $personnel->documents()->count() }}</div>
                                <div class="ee-quick-stat-label">Documents dans le dossier</div>
                            </div>
                        </div>
                        <div class="ee-quick-stat">
                            <div class="ee-quick-stat-icon orange">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                            </div>
                            <div class="ee-quick-stat-content">
                                <div class="ee-quick-stat-value">{{ $personnel->age ?? '-' }}</div>
                                <div class="ee-quick-stat-label">Années d'âge</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Career Timeline -->
            <div class="ee-info-card animate-fade-in" style="animation-delay: 0.25s;">
                <div class="ee-info-card-header">
                    <h2 class="ee-info-card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        Parcours
                    </h2>
                </div>
                <div class="ee-info-card-body">
                    <div class="ee-timeline">
                        <div class="ee-timeline-item">
                            <div class="ee-timeline-icon success">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                            </div>
                            <div class="ee-timeline-content">
                                <div class="ee-timeline-title">Poste actuel</div>
                                <div class="ee-timeline-date">{{ $personnel->poste }}</div>
                            </div>
                        </div>
                        @if($personnel->date_embauche)
                            <div class="ee-timeline-item">
                                <div class="ee-timeline-icon primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                    </svg>
                                </div>
                                <div class="ee-timeline-content">
                                    <div class="ee-timeline-title">Embauche</div>
                                    <div class="ee-timeline-date">{{ $personnel->date_embauche->format('d/m/Y') }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Info Modal -->
<div class="ee-modal-overlay" id="editInfoModal">
    <div class="ee-modal">
        <div class="ee-modal-header">
            <h3 class="ee-modal-title">Modifier mes informations</h3>
            <button class="ee-modal-close" onclick="closeModal('editInfoModal')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <form action="{{ route('espace-employe.profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="ee-modal-body">
                <div class="ee-form-group">
                    <label class="ee-form-label">Téléphone</label>
                    <input type="text" name="telephone" class="ee-form-input" value="{{ $personnel->telephone }}" placeholder="Votre numéro de téléphone">
                </div>
                <div class="ee-form-group">
                    <label class="ee-form-label">Adresse</label>
                    <input type="text" name="adresse" class="ee-form-input" value="{{ $personnel->adresse }}" placeholder="Votre adresse">
                </div>
            </div>
            <div class="ee-modal-footer">
                <button type="button" class="ee-profil-btn secondary" onclick="closeModal('editInfoModal')">Annuler</button>
                <button type="submit" class="ee-profil-btn primary">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Photo Modal -->
<div class="ee-modal-overlay" id="editPhotoModal">
    <div class="ee-modal">
        <div class="ee-modal-header">
            <h3 class="ee-modal-title">Modifier ma photo</h3>
            <button class="ee-modal-close" onclick="closeModal('editPhotoModal')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <form action="{{ route('espace-employe.profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="ee-modal-body">
                <label class="ee-photo-upload">
                    <input type="file" name="photo" accept="image/*" style="display: none;" onchange="previewPhoto(this)">
                    <div class="ee-photo-upload-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="17 8 12 3 7 8"></polyline>
                            <line x1="12" y1="3" x2="12" y2="15"></line>
                        </svg>
                    </div>
                    <span class="ee-photo-upload-text">Cliquez pour sélectionner une photo</span>
                    <span class="ee-photo-upload-hint">JPG, PNG - Max 2 Mo</span>
                </label>
                <div id="photoPreview" style="display: none; text-align: center; margin-top: 1rem;">
                    <img id="previewImage" src="" alt="Aperçu" style="max-width: 200px; border-radius: 12px;">
                </div>
            </div>
            <div class="ee-modal-footer">
                <button type="button" class="ee-profil-btn secondary" onclick="closeModal('editPhotoModal')">Annuler</button>
                <button type="submit" class="ee-profil-btn primary">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function openEditModal(type) {
    if (type === 'info') {
        document.getElementById('editInfoModal').classList.add('show');
    } else if (type === 'photo') {
        document.getElementById('editPhotoModal').classList.add('show');
    }
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('show');
}

function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImage').src = e.target.result;
            document.getElementById('photoPreview').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Close modal on outside click
document.querySelectorAll('.ee-modal-overlay').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.remove('show');
        }
    });
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.ee-modal-overlay.show').forEach(modal => {
            modal.classList.remove('show');
        });
    }
});
</script>
@endsection
