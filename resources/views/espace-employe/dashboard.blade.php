@extends('layouts.espace-employe')

@section('title', 'Mon Espace')
@section('page-title', 'Tableau de bord')
@section('breadcrumb')
    <span>Accueil</span>
@endsection

@section('styles')
<style>
/* ==================== DASHBOARD EMPLOYE ==================== */
.ee-dashboard {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

/* Welcome Banner */
.ee-welcome-banner {
    background: linear-gradient(135deg, var(--ee-gradient-start) 0%, var(--ee-gradient-end) 100%);
    border-radius: 20px;
    padding: 2rem;
    color: white;
    position: relative;
    overflow: hidden;
}

.ee-welcome-banner::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    border-radius: 50%;
}

.ee-welcome-banner::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: 10%;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
    border-radius: 50%;
}

.ee-welcome-content {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
}

.ee-welcome-text h2 {
    font-size: 1.75rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
}

.ee-welcome-text p {
    font-size: 1rem;
    opacity: 0.9;
}

.ee-welcome-date {
    display: flex;
    flex-direction: column;
    align-items: center;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    padding: 1.25rem 1.5rem;
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.ee-welcome-date .day {
    font-size: 2.5rem;
    font-weight: 800;
    line-height: 1;
}

.ee-welcome-date .month {
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-top: 0.25rem;
}

/* Stats Grid */
.ee-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.5rem;
}

.ee-stat-card {
    background: var(--ee-card);
    border-radius: 16px;
    padding: 1.5rem;
    border: 1px solid var(--ee-border);
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    transition: all 0.3s ease;
}

.ee-stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px var(--ee-shadow);
}

.ee-stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.ee-stat-icon svg {
    width: 28px;
    height: 28px;
}

.ee-stat-icon.primary {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.15) 0%, rgba(99, 102, 241, 0.05) 100%);
    color: var(--ee-primary);
}

.ee-stat-icon.success {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0.05) 100%);
    color: var(--ee-success);
}

.ee-stat-icon.warning {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(245, 158, 11, 0.05) 100%);
    color: var(--ee-warning);
}

.ee-stat-icon.info {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(59, 130, 246, 0.05) 100%);
    color: var(--ee-info);
}

.ee-stat-content {
    flex: 1;
}

.ee-stat-value {
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--ee-text);
    line-height: 1;
}

.ee-stat-label {
    font-size: 0.875rem;
    color: var(--ee-text-muted);
    margin-top: 0.375rem;
}

.ee-stat-trend {
    font-size: 0.75rem;
    font-weight: 600;
    margin-top: 0.5rem;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.5rem;
    border-radius: 20px;
}

.ee-stat-trend.up {
    background: rgba(16, 185, 129, 0.1);
    color: var(--ee-success);
}

.ee-stat-trend.down {
    background: rgba(239, 68, 68, 0.1);
    color: var(--ee-danger);
}

/* Main Grid */
.ee-main-grid {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 1.5rem;
}

/* Profile Card */
.ee-profile-card {
    background: var(--ee-card);
    border-radius: 20px;
    border: 1px solid var(--ee-border);
    overflow: hidden;
}

.ee-profile-header {
    background: linear-gradient(135deg, var(--ee-gradient-start) 0%, var(--ee-gradient-end) 100%);
    padding: 2rem;
    text-align: center;
    position: relative;
}

.ee-profile-header::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.ee-profile-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    border: 4px solid rgba(255, 255, 255, 0.3);
    object-fit: cover;
    margin: 0 auto 1rem;
    position: relative;
    z-index: 1;
}

.ee-profile-name {
    font-size: 1.25rem;
    font-weight: 700;
    color: white;
    position: relative;
    z-index: 1;
}

.ee-profile-role {
    font-size: 0.875rem;
    color: rgba(255, 255, 255, 0.85);
    margin-top: 0.25rem;
    position: relative;
    z-index: 1;
}

.ee-profile-body {
    padding: 1.5rem;
}

.ee-profile-info {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.ee-info-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.875rem;
    background: var(--ee-bg-alt);
    border-radius: 12px;
}

.ee-info-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: var(--ee-card);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--ee-primary);
    flex-shrink: 0;
}

.ee-info-icon svg {
    width: 20px;
    height: 20px;
}

.ee-info-content {
    flex: 1;
    min-width: 0;
}

.ee-info-label {
    font-size: 0.75rem;
    color: var(--ee-text-muted);
    font-weight: 500;
}

.ee-info-value {
    font-size: 0.875rem;
    color: var(--ee-text);
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.ee-profile-btn {
    display: block;
    width: 100%;
    padding: 0.875rem;
    background: linear-gradient(135deg, var(--ee-primary) 0%, var(--ee-primary-dark) 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 0.875rem;
    font-weight: 600;
    text-align: center;
    text-decoration: none;
    margin-top: 1.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.ee-profile-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(99, 102, 241, 0.3);
}

/* Activities Card */
.ee-activities-card {
    background: var(--ee-card);
    border-radius: 20px;
    border: 1px solid var(--ee-border);
    padding: 1.5rem;
}

.ee-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
}

.ee-card-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--ee-text);
}

.ee-card-link {
    font-size: 0.875rem;
    color: var(--ee-primary);
    text-decoration: none;
    font-weight: 600;
}

.ee-card-link:hover {
    text-decoration: underline;
}

.ee-activity-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.ee-activity-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem;
    background: var(--ee-bg-alt);
    border-radius: 12px;
    transition: all 0.3s ease;
}

.ee-activity-item:hover {
    transform: translateX(4px);
}

.ee-activity-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.ee-activity-icon.file {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.15) 0%, rgba(99, 102, 241, 0.05) 100%);
    color: var(--ee-primary);
}

.ee-activity-icon.calendar {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0.05) 100%);
    color: var(--ee-success);
}

.ee-activity-icon.user {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(245, 158, 11, 0.05) 100%);
    color: var(--ee-warning);
}

.ee-activity-icon svg {
    width: 22px;
    height: 22px;
}

.ee-activity-content {
    flex: 1;
}

.ee-activity-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--ee-text);
}

.ee-activity-date {
    font-size: 0.75rem;
    color: var(--ee-text-muted);
    margin-top: 0.25rem;
}

/* Quick Actions */
.ee-quick-actions {
    background: var(--ee-card);
    border-radius: 20px;
    border: 1px solid var(--ee-border);
    padding: 1.5rem;
}

.ee-actions-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
}

.ee-action-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
    padding: 1.5rem 1rem;
    background: var(--ee-bg-alt);
    border: 2px solid transparent;
    border-radius: 16px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.ee-action-btn:hover {
    border-color: var(--ee-primary);
    background: var(--ee-primary-light);
    transform: translateY(-4px);
}

.ee-action-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.ee-action-icon svg {
    width: 28px;
    height: 28px;
}

.ee-action-icon.purple {
    background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
    color: white;
}

.ee-action-icon.green {
    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    color: white;
}

.ee-action-icon.blue {
    background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
    color: white;
}

.ee-action-icon.orange {
    background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
    color: white;
}

.ee-action-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--ee-text);
    text-align: center;
}

/* Responsive */
@media (max-width: 1280px) {
    .ee-stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .ee-main-grid {
        grid-template-columns: 1fr;
    }

    .ee-actions-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .ee-welcome-content {
        flex-direction: column;
        text-align: center;
    }

    .ee-stats-grid {
        grid-template-columns: 1fr;
    }

    .ee-actions-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>
@endsection

@section('content')
<div class="ee-dashboard">
    <!-- Welcome Banner -->
    <div class="ee-welcome-banner animate-fade-in">
        <div class="ee-welcome-content">
            <div class="ee-welcome-text">
                <h2>Bonjour, {{ $personnel ? $personnel->prenoms : auth()->user()->name }} !</h2>
                <p>Bienvenue dans votre espace personnel. Consultez vos informations et gérez vos demandes.</p>
            </div>
            <div class="ee-welcome-date">
                <span class="day">{{ now()->format('d') }}</span>
                <span class="month">{{ now()->translatedFormat('F Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="ee-stats-grid">
        <div class="ee-stat-card animate-fade-in" style="animation-delay: 0.1s;">
            <div class="ee-stat-icon primary">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                </svg>
            </div>
            <div class="ee-stat-content">
                <div class="ee-stat-value">{{ $stats['documents'] }}</div>
                <div class="ee-stat-label">Documents</div>
            </div>
        </div>

        <div class="ee-stat-card animate-fade-in" style="animation-delay: 0.2s;">
            <div class="ee-stat-icon success">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
            </div>
            <div class="ee-stat-content">
                <div class="ee-stat-value">{{ $stats['conges_restants'] }}</div>
                <div class="ee-stat-label">Jours de congés</div>
                <span class="ee-stat-trend up">Disponibles</span>
            </div>
        </div>

        <div class="ee-stat-card animate-fade-in" style="animation-delay: 0.3s;">
            <div class="ee-stat-icon warning">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </div>
            <div class="ee-stat-content">
                <div class="ee-stat-value">{{ $stats['demandes_en_cours'] }}</div>
                <div class="ee-stat-label">Demandes en cours</div>
            </div>
        </div>

        <div class="ee-stat-card animate-fade-in" style="animation-delay: 0.4s;">
            <div class="ee-stat-icon info">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                </svg>
            </div>
            <div class="ee-stat-content">
                <div class="ee-stat-value">{{ $stats['anciennete'] }}</div>
                <div class="ee-stat-label">Années d'ancienneté</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="ee-quick-actions animate-fade-in" style="animation-delay: 0.5s;">
        <div class="ee-card-header">
            <h3 class="ee-card-title">Actions rapides</h3>
        </div>
        <div class="ee-actions-grid">
            <a href="{{ route('espace-employe.conges') }}" class="ee-action-btn">
                <div class="ee-action-icon purple">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
                <span class="ee-action-label">Demander un congé</span>
            </a>
            <a href="{{ route('espace-employe.attestations') }}" class="ee-action-btn">
                <div class="ee-action-icon green">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="12" y1="18" x2="12" y2="12"></line>
                        <line x1="9" y1="15" x2="15" y2="15"></line>
                    </svg>
                </div>
                <span class="ee-action-label">Demander une attestation</span>
            </a>
            <a href="{{ route('espace-employe.bulletins') }}" class="ee-action-btn">
                <div class="ee-action-icon blue">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                        <line x1="8" y1="21" x2="16" y2="21"></line>
                        <line x1="12" y1="17" x2="12" y2="21"></line>
                    </svg>
                </div>
                <span class="ee-action-label">Voir mes bulletins</span>
            </a>
            <a href="{{ route('espace-employe.profil') }}" class="ee-action-btn">
                <div class="ee-action-icon orange">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <span class="ee-action-label">Modifier mon profil</span>
            </a>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="ee-main-grid">
        <!-- Activities -->
        <div class="ee-activities-card animate-fade-in" style="animation-delay: 0.6s;">
            <div class="ee-card-header">
                <h3 class="ee-card-title">Activités récentes</h3>
                <a href="#" class="ee-card-link">Voir tout</a>
            </div>
            <div class="ee-activity-list">
                @foreach($activities as $activity)
                    <div class="ee-activity-item">
                        <div class="ee-activity-icon {{ $activity['icon'] }}">
                            @if($activity['icon'] === 'file')
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                </svg>
                            @elseif($activity['icon'] === 'calendar')
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            @endif
                        </div>
                        <div class="ee-activity-content">
                            <div class="ee-activity-title">{{ $activity['title'] }}</div>
                            <div class="ee-activity-date">{{ $activity['date']->diffForHumans() }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Profile Card -->
        <div class="ee-profile-card animate-fade-in" style="animation-delay: 0.7s;">
            <div class="ee-profile-header">
                <img src="{{ $personnel ? $personnel->photo_url : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&size=200&background=6366F1&color=fff' }}"
                     alt="Photo"
                     class="ee-profile-avatar">
                <div class="ee-profile-name">{{ $personnel ? $personnel->nom_complet : auth()->user()->name }}</div>
                <div class="ee-profile-role">{{ $personnel ? $personnel->poste : 'Employé' }}</div>
            </div>
            <div class="ee-profile-body">
                <div class="ee-profile-info">
                    @if($personnel)
                        <div class="ee-info-item">
                            <div class="ee-info-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                            </div>
                            <div class="ee-info-content">
                                <div class="ee-info-label">Département</div>
                                <div class="ee-info-value">{{ $personnel->departement->nom ?? 'Non assigné' }}</div>
                            </div>
                        </div>
                        <div class="ee-info-item">
                            <div class="ee-info-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                </svg>
                            </div>
                            <div class="ee-info-content">
                                <div class="ee-info-label">Service</div>
                                <div class="ee-info-value">{{ $personnel->service->nom ?? 'Non assigné' }}</div>
                            </div>
                        </div>
                        <div class="ee-info-item">
                            <div class="ee-info-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            </div>
                            <div class="ee-info-content">
                                <div class="ee-info-label">Date d'embauche</div>
                                <div class="ee-info-value">{{ $personnel->date_embauche ? $personnel->date_embauche->format('d/m/Y') : 'Non renseignée' }}</div>
                            </div>
                        </div>
                    @endif
                    <div class="ee-info-item">
                        <div class="ee-info-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </div>
                        <div class="ee-info-content">
                            <div class="ee-info-label">Email</div>
                            <div class="ee-info-value">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('espace-employe.profil') }}" class="ee-profile-btn">Voir mon profil complet</a>
            </div>
        </div>
    </div>
</div>
@endsection
