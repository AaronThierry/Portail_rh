@extends('layouts.app')

@section('title', 'Mon Dossier')
@section('page-title', 'Mon Dossier')

@section('styles')
<style>
:root {
    /* RH+ Brand Colors */
    --md-primary: #4A90D9;
    --md-primary-dark: #2E6BB3;
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
    --md-bg: #0f172a;
    --md-card: #1e293b;
    --md-text: #f1f5f9;
    --md-text-muted: #94a3b8;
    --md-border: #334155;
}

.empty-state-page {
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    background: var(--md-bg);
}

.empty-state-card {
    background: var(--md-card);
    border-radius: 24px;
    padding: 3rem;
    text-align: center;
    max-width: 500px;
    width: 100%;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    border: 1px solid var(--md-border);
}

.empty-icon {
    width: 100px;
    height: 100px;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, rgba(74, 144, 217, 0.1) 0%, rgba(46, 107, 179, 0.1) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.empty-icon svg {
    width: 48px;
    height: 48px;
    color: var(--md-primary);
}

.empty-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--md-text);
    margin: 0 0 0.75rem 0;
}

.empty-description {
    color: var(--md-text-muted);
    font-size: 0.938rem;
    line-height: 1.6;
    margin: 0 0 2rem 0;
}

.empty-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-primary {
    padding: 0.875rem 1.5rem;
    background: linear-gradient(135deg, var(--md-primary) 0%, var(--md-primary-dark) 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.875rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
    box-shadow: 0 4px 15px rgba(74, 144, 217, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(74, 144, 217, 0.4);
    color: white;
}

.btn-secondary {
    padding: 0.875rem 1.5rem;
    background: rgba(74, 144, 217, 0.1);
    color: var(--md-primary);
    border: none;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.875rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
}

.btn-secondary:hover {
    background: rgba(74, 144, 217, 0.15);
}

.help-text {
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--md-border);
    color: var(--md-text-muted);
    font-size: 0.813rem;
}

.help-text a {
    color: var(--md-primary);
    text-decoration: none;
    font-weight: 500;
}

.help-text a:hover {
    text-decoration: underline;
}
</style>
@endsection

@section('content')
<div class="empty-state-page">
    <div class="empty-state-card">
        <div class="empty-icon">
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                <path d="M12 11v4m0 0l-2-2m2 2l2-2"/>
            </svg>
        </div>

        <h1 class="empty-title">Aucun dossier trouvé</h1>

        <p class="empty-description">
            Votre compte utilisateur n'est pas encore lié à un dossier personnel.
            Veuillez contacter le service des ressources humaines pour associer votre compte à votre fiche employé.
        </p>

        <div class="empty-actions">
            <a href="{{ route('dashboard') }}" class="btn-primary">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Retour au tableau de bord
            </a>
        </div>

        <p class="help-text">
            Besoin d'aide ? Contactez les <a href="mailto:rh@entreprise.com">Ressources Humaines</a>
        </p>
    </div>
</div>
@endsection
