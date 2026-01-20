@extends('layouts.espace-employe')

@section('title', 'Mes Bulletins de Paie')
@section('page-title', 'Mes Bulletins de Paie')
@section('breadcrumb')
    <a href="{{ route('espace-employe.dashboard') }}">Accueil</a>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
    @if(isset($bulletinSelectionne))
        <a href="{{ route('espace-employe.bulletins') }}">Bulletins de paie</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
        <span>{{ $bulletinSelectionne->periode_formatee }}</span>
    @else
        <span>Bulletins de paie</span>
    @endif
@endsection

@section('styles')
<style>
/* ========================================
   BULLETINS DE PAIE - ESPACE EMPLOYE
   Design Répertoires Premium
   ======================================== */

/* Header Banner */
.bp-banner {
    background: linear-gradient(135deg, var(--ee-primary) 0%, var(--ee-primary-dark) 100%);
    border-radius: 24px;
    padding: 2rem 2.5rem;
    margin-bottom: 2rem;
    color: white;
    position: relative;
    overflow: hidden;
}

.bp-banner::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
    border-radius: 50%;
}

.bp-banner::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: 20%;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    border-radius: 50%;
}

.bp-banner-content {
    position: relative;
    z-index: 1;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1.5rem;
}

.bp-banner-left h1 {
    font-size: 1.75rem;
    font-weight: 800;
    margin: 0 0 0.5rem 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.bp-banner-left h1 svg {
    width: 36px;
    height: 36px;
    opacity: 0.9;
}

.bp-banner-left p {
    margin: 0;
    opacity: 0.9;
    font-size: 1rem;
}

.bp-banner-stats {
    display: flex;
    gap: 2.5rem;
}

.bp-banner-stat {
    text-align: center;
}

.bp-banner-stat-value {
    font-size: 2.25rem;
    font-weight: 800;
    line-height: 1;
}

.bp-banner-stat-label {
    font-size: 0.85rem;
    opacity: 0.9;
    margin-top: 0.25rem;
}

/* Navigation Années */
.bp-years-nav {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.bp-year-btn {
    padding: 0.75rem 1.5rem;
    background: var(--ee-card);
    border: 2px solid var(--ee-border);
    border-radius: 12px;
    font-weight: 700;
    font-size: 0.95rem;
    color: var(--ee-text-secondary);
    cursor: pointer;
    transition: all 0.25s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.bp-year-btn:hover {
    border-color: var(--ee-primary);
    color: var(--ee-primary);
    transform: translateY(-2px);
}

.bp-year-btn.active {
    background: var(--ee-primary);
    border-color: var(--ee-primary);
    color: white;
    box-shadow: 0 4px 12px rgba(74, 144, 217, 0.3);
}

.bp-year-btn .count {
    background: rgba(255,255,255,0.2);
    padding: 0.15rem 0.5rem;
    border-radius: 8px;
    font-size: 0.8rem;
}

.bp-year-btn.active .count {
    background: rgba(255,255,255,0.25);
}

/* Grille des mois (Répertoires) */
.bp-months-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 1.25rem;
}

.bp-month-folder {
    background: var(--ee-card);
    border: 1px solid var(--ee-border);
    border-radius: 18px;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
    color: inherit;
    display: block;
}

.bp-month-folder:hover:not(.empty) {
    transform: translateY(-6px);
    box-shadow: 0 20px 40px var(--ee-shadow);
    border-color: var(--ee-primary);
}

.bp-month-folder.empty {
    opacity: 0.55;
    cursor: default;
}

.bp-month-folder-header {
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1.25rem;
}

.bp-month-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.bp-month-folder:hover:not(.empty) .bp-month-icon {
    transform: scale(1.08) rotate(-3deg);
}

.bp-month-icon.available {
    background: linear-gradient(135deg, var(--ee-primary) 0%, var(--ee-primary-dark) 100%);
    color: white;
    box-shadow: 0 6px 20px rgba(74, 144, 217, 0.35);
}

.bp-month-icon.pending {
    background: var(--ee-bg);
    color: var(--ee-text-muted);
}

.bp-month-icon svg {
    width: 28px;
    height: 28px;
}

.bp-month-info {
    flex: 1;
    min-width: 0;
}

.bp-month-name {
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--ee-text);
    margin: 0 0 0.35rem 0;
}

.bp-month-status {
    font-size: 0.85rem;
    color: var(--ee-text-secondary);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.bp-month-status .badge {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.3rem 0.6rem;
    background: rgba(34, 197, 94, 0.15);
    color: #16a34a;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
}

.bp-month-status .badge svg {
    width: 12px;
    height: 12px;
}

.bp-month-footer {
    padding: 0.85rem 1.5rem;
    background: var(--ee-bg);
    border-top: 1px solid var(--ee-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.8rem;
    color: var(--ee-text-secondary);
}

.bp-month-footer .action {
    color: var(--ee-primary);
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.35rem;
    transition: gap 0.2s ease;
}

.bp-month-folder:hover:not(.empty) .bp-month-footer .action {
    gap: 0.6rem;
}

/* Vue Détail Bulletin */
.bp-detail-card {
    background: var(--ee-card);
    border: 1px solid var(--ee-border);
    border-radius: 24px;
    overflow: hidden;
}

.bp-detail-header {
    background: linear-gradient(135deg, rgba(74, 144, 217, 0.08) 0%, rgba(74, 144, 217, 0.03) 100%);
    padding: 1.75rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid var(--ee-border);
    flex-wrap: wrap;
    gap: 1rem;
}

.bp-detail-title {
    display: flex;
    align-items: center;
    gap: 1.25rem;
}

.bp-detail-icon {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, var(--ee-primary) 0%, var(--ee-primary-dark) 100%);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    box-shadow: 0 4px 16px rgba(74, 144, 217, 0.3);
}

.bp-detail-icon svg {
    width: 26px;
    height: 26px;
}

.bp-detail-title-text h2 {
    font-size: 1.35rem;
    font-weight: 700;
    color: var(--ee-text);
    margin: 0;
}

.bp-detail-title-text p {
    font-size: 0.9rem;
    color: var(--ee-text-secondary);
    margin: 0.25rem 0 0 0;
}

.bp-detail-actions {
    display: flex;
    gap: 0.75rem;
}

.bp-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.85rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.25s ease;
    text-decoration: none;
    border: none;
}

.bp-btn svg {
    width: 18px;
    height: 18px;
}

.bp-btn-primary {
    background: linear-gradient(135deg, var(--ee-primary) 0%, var(--ee-primary-dark) 100%);
    color: white;
    box-shadow: 0 4px 16px rgba(74, 144, 217, 0.3);
}

.bp-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(74, 144, 217, 0.4);
}

.bp-btn-secondary {
    background: var(--ee-card);
    color: var(--ee-text);
    border: 1px solid var(--ee-border);
}

.bp-btn-secondary:hover {
    border-color: var(--ee-primary);
    color: var(--ee-primary);
}

.bp-detail-body {
    padding: 2rem;
}

/* Preview PDF */
.bp-preview-container {
    background: #1e293b;
    border-radius: 16px;
    height: 550px;
    overflow: hidden;
    margin-bottom: 2rem;
    box-shadow: inset 0 2px 10px rgba(0,0,0,0.1);
}

.bp-preview-container iframe {
    width: 100%;
    height: 100%;
    border: none;
}

/* Info Grid */
.bp-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
}

.bp-info-card {
    background: var(--ee-bg);
    border-radius: 14px;
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.2s ease;
}

.bp-info-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px var(--ee-shadow);
}

.bp-info-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.bp-info-icon.blue { background: rgba(74, 144, 217, 0.15); color: var(--ee-primary); }
.bp-info-icon.green { background: rgba(34, 197, 94, 0.15); color: #16a34a; }
.bp-info-icon.orange { background: rgba(249, 115, 22, 0.15); color: #ea580c; }

.bp-info-icon svg {
    width: 22px;
    height: 22px;
}

.bp-info-text h4 {
    font-size: 0.7rem;
    font-weight: 700;
    color: var(--ee-text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin: 0 0 0.3rem 0;
}

.bp-info-text p {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--ee-text);
    margin: 0;
}

/* Empty State */
.bp-empty {
    text-align: center;
    padding: 5rem 2rem;
    background: var(--ee-card);
    border-radius: 24px;
    border: 1px solid var(--ee-border);
}

.bp-empty-icon {
    width: 120px;
    height: 120px;
    margin: 0 auto 2rem;
    background: linear-gradient(135deg, rgba(74, 144, 217, 0.1) 0%, rgba(74, 144, 217, 0.05) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.bp-empty-icon svg {
    width: 56px;
    height: 56px;
    color: var(--ee-primary);
    opacity: 0.6;
}

.bp-empty h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--ee-text);
    margin: 0 0 0.75rem 0;
}

.bp-empty p {
    color: var(--ee-text-secondary);
    margin: 0;
    max-width: 450px;
    margin: 0 auto;
    line-height: 1.6;
}

/* Responsive */
@media (max-width: 768px) {
    .bp-banner-content {
        flex-direction: column;
        text-align: center;
    }

    .bp-banner-stats {
        justify-content: center;
    }

    .bp-months-grid {
        grid-template-columns: 1fr;
    }

    .bp-detail-header {
        flex-direction: column;
        text-align: center;
    }

    .bp-detail-title {
        flex-direction: column;
    }

    .bp-preview-container {
        height: 400px;
    }

    .bp-info-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection

@section('content')
<div class="bp-page">
    @if(!isset($bulletinSelectionne))
        <!-- ============================================
             VUE LISTE - RÉPERTOIRES PAR MOIS
             ============================================ -->

        <!-- Banner Header -->
        <div class="bp-banner animate-fade-in">
            <div class="bp-banner-content">
                <div class="bp-banner-left">
                    <h1>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                        </svg>
                        Mes Bulletins de Paie
                    </h1>
                    <p>Consultez et téléchargez vos fiches de paie en toute sécurité</p>
                </div>
                <div class="bp-banner-stats">
                    <div class="bp-banner-stat">
                        <div class="bp-banner-stat-value">{{ $totalBulletins ?? 0 }}</div>
                        <div class="bp-banner-stat-label">Bulletins</div>
                    </div>
                    <div class="bp-banner-stat">
                        <div class="bp-banner-stat-value">{{ count($anneesDisponibles ?? []) ?: 0 }}</div>
                        <div class="bp-banner-stat-label">Années</div>
                    </div>
                </div>
            </div>
        </div>

        @if(count($anneesDisponibles ?? []) > 0)
            <!-- Navigation par années -->
            <div class="bp-years-nav animate-fade-in">
                @foreach($anneesDisponibles as $annee)
                    @php
                        $countAnnee = isset($bulletinsParAnnee[$annee]) ? $bulletinsParAnnee[$annee]->count() : 0;
                    @endphp
                    <a href="{{ route('espace-employe.bulletins', ['annee' => $annee]) }}"
                       class="bp-year-btn {{ $anneeSelectionnee == $annee ? 'active' : '' }}">
                        {{ $annee }}
                        <span class="count">{{ $countAnnee }}</span>
                    </a>
                @endforeach
            </div>

            <!-- Grille des mois -->
            <div class="bp-months-grid">
                @foreach($moisData as $mois => $data)
                    @if($data['bulletin'])
                        <a href="{{ route('espace-employe.bulletins', ['annee' => $anneeSelectionnee, 'mois' => $mois]) }}"
                           class="bp-month-folder animate-fade-in">
                            <div class="bp-month-folder-header">
                                <div class="bp-month-icon available">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                    </svg>
                                </div>
                                <div class="bp-month-info">
                                    <h3 class="bp-month-name">{{ $data['nom'] }}</h3>
                                    <div class="bp-month-status">
                                        <span class="badge">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                            Disponible
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="bp-month-footer">
                                <span>{{ $data['bulletin']->fichier_taille_formatee }}</span>
                                <span class="action">
                                    Consulter
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="9 18 15 12 9 6"></polyline>
                                    </svg>
                                </span>
                            </div>
                        </a>
                    @else
                        <div class="bp-month-folder empty animate-fade-in">
                            <div class="bp-month-folder-header">
                                <div class="bp-month-icon pending">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                                    </svg>
                                </div>
                                <div class="bp-month-info">
                                    <h3 class="bp-month-name">{{ $data['nom'] }}</h3>
                                    <div class="bp-month-status">
                                        Pas encore disponible
                                    </div>
                                </div>
                            </div>
                            <div class="bp-month-footer">
                                <span>-</span>
                                <span>En attente</span>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <!-- État vide -->
            <div class="bp-empty animate-fade-in">
                <div class="bp-empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                    </svg>
                </div>
                <h3>Aucun bulletin disponible</h3>
                <p>Vos bulletins de paie apparaîtront ici une fois qu'ils seront mis à disposition par votre service RH. Revenez bientôt !</p>
            </div>
        @endif

    @else
        <!-- ============================================
             VUE DÉTAIL - AFFICHAGE D'UN BULLETIN
             ============================================ -->

        <div class="bp-detail-card animate-fade-in">
            <div class="bp-detail-header">
                <div class="bp-detail-title">
                    <div class="bp-detail-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                        </svg>
                    </div>
                    <div class="bp-detail-title-text">
                        <h2>Bulletin de {{ $bulletinSelectionne->periode_formatee }}</h2>
                        <p>Mis à disposition le {{ $bulletinSelectionne->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                </div>
                <div class="bp-detail-actions">
                    <a href="{{ route('espace-employe.bulletins.preview', $bulletinSelectionne) }}" target="_blank" class="bp-btn bp-btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                            <polyline points="15 3 21 3 21 9"></polyline>
                            <line x1="10" y1="14" x2="21" y2="3"></line>
                        </svg>
                        Plein écran
                    </a>
                    <a href="{{ route('espace-employe.bulletins.download', $bulletinSelectionne) }}" class="bp-btn bp-btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="7 10 12 15 17 10"></polyline>
                            <line x1="12" y1="15" x2="12" y2="3"></line>
                        </svg>
                        Télécharger
                    </a>
                </div>
            </div>

            <div class="bp-detail-body">
                <!-- Preview PDF -->
                <div class="bp-preview-container">
                    <iframe src="{{ route('espace-employe.bulletins.preview', $bulletinSelectionne) }}#toolbar=0&navpanes=0&scrollbar=1"></iframe>
                </div>

                <!-- Informations -->
                <div class="bp-info-grid">
                    <div class="bp-info-card">
                        <div class="bp-info-icon blue">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                        </div>
                        <div class="bp-info-text">
                            <h4>Période</h4>
                            <p>{{ $bulletinSelectionne->periode_formatee }}</p>
                        </div>
                    </div>

                    @if($bulletinSelectionne->salaire_net)
                    <div class="bp-info-card">
                        <div class="bp-info-icon green">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="1" x2="12" y2="23"></line>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                        </div>
                        <div class="bp-info-text">
                            <h4>Net à payer</h4>
                            <p>{{ number_format($bulletinSelectionne->salaire_net, 0, ',', ' ') }} F</p>
                        </div>
                    </div>
                    @endif

                    <div class="bp-info-card">
                        <div class="bp-info-icon orange">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                        </div>
                        <div class="bp-info-text">
                            <h4>Taille</h4>
                            <p>{{ $bulletinSelectionne->fichier_taille_formatee }}</p>
                        </div>
                    </div>

                    <div class="bp-info-card">
                        <div class="bp-info-icon blue">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                            </svg>
                        </div>
                        <div class="bp-info-text">
                            <h4>Référence</h4>
                            <p>{{ $bulletinSelectionne->reference ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
