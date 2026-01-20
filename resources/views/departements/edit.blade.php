@extends('layouts.app')

@section('title', 'Modifier Département')
@section('page-title', 'Modifier Département')
@section('page-subtitle', $departement->nom)

@section('styles')
<style>
/* ========================================
   VARIABLES - Charte RH+ Premium
   ======================================== */
:root {
    --de-primary: #4A90D9;
    --de-primary-dark: #2E6BB3;
    --de-primary-light: #E8F4FD;
    --de-accent: #FF9500;
    --de-accent-light: #FFF7ED;
    --de-success: #22C55E;
    --de-success-light: #F0FDF4;
    --de-danger: #EF4444;
    --de-danger-light: #FEF2F2;
    --de-info: #3B82F6;
    --de-info-light: #EFF6FF;
    --de-purple: #8B5CF6;
    --de-purple-light: #F5F3FF;
    --de-bg: #f8fafc;
    --de-card-bg: #ffffff;
    --de-card-border: #e2e8f0;
    --de-text-primary: #1e293b;
    --de-text-secondary: #64748b;
    --de-text-muted: #94a3b8;
    --de-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    --de-shadow-lg: 0 8px 30px rgba(0, 0, 0, 0.1);
    --de-radius: 12px;
    --de-radius-lg: 16px;
    --de-radius-xl: 20px;
    --de-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.dark {
    --de-bg: #0f172a;
    --de-card-bg: #1e293b;
    --de-card-border: #334155;
    --de-text-primary: #f1f5f9;
    --de-text-secondary: #94a3b8;
    --de-text-muted: #64748b;
    --de-primary-light: rgba(74, 144, 217, 0.15);
    --de-success-light: rgba(34, 197, 94, 0.15);
    --de-danger-light: rgba(239, 68, 68, 0.15);
}

/* ========================================
   BASE
   ======================================== */
.departement-edit-page {
    padding: 1.5rem;
    min-height: 100vh;
    background: var(--de-bg);
}

/* ========================================
   HEADER
   ======================================== */
.de-header {
    background: var(--de-card-bg);
    border-radius: var(--de-radius-xl);
    padding: 2rem;
    margin-bottom: 1.5rem;
    box-shadow: var(--de-shadow);
    border: 1px solid var(--de-card-border);
    position: relative;
    overflow: hidden;
}

.de-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--de-primary), var(--de-accent));
}

.de-header-content {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.de-back-btn {
    width: 44px;
    height: 44px;
    border-radius: var(--de-radius);
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--de-bg);
    border: 2px solid var(--de-card-border);
    color: var(--de-text-secondary);
    text-decoration: none;
    transition: var(--de-transition);
    flex-shrink: 0;
}

.de-back-btn:hover {
    border-color: var(--de-primary);
    color: var(--de-primary);
    background: var(--de-primary-light);
    transform: translateX(-3px);
}

.de-back-btn svg {
    width: 20px;
    height: 20px;
}

.de-header-icon {
    width: 56px;
    height: 56px;
    border-radius: var(--de-radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--de-primary) 0%, var(--de-primary-dark) 100%);
    color: white;
    box-shadow: 0 8px 20px rgba(74, 144, 217, 0.3);
    flex-shrink: 0;
}

.de-header-icon svg {
    width: 28px;
    height: 28px;
}

.de-header-info h1 {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--de-text-primary);
    margin: 0 0 0.25rem 0;
}

.de-header-info p {
    font-size: 0.9rem;
    color: var(--de-text-secondary);
    margin: 0;
}

/* ========================================
   ALERTS
   ======================================== */
.de-alert {
    display: flex;
    align-items: flex-start;
    gap: 0.875rem;
    padding: 1rem 1.25rem;
    border-radius: var(--de-radius);
    margin-bottom: 1.5rem;
    border-left: 4px solid;
}

.de-alert svg {
    width: 22px;
    height: 22px;
    flex-shrink: 0;
    margin-top: 0.125rem;
}

.de-alert-content {
    flex: 1;
}

.de-alert-content strong {
    display: block;
    margin-bottom: 0.5rem;
}

.de-alert-content ul {
    margin: 0;
    padding-left: 1.25rem;
}

.de-alert-content li {
    margin-bottom: 0.25rem;
}

.de-alert-error {
    background: var(--de-danger-light);
    border-color: var(--de-danger);
    color: #991b1b;
}

.dark .de-alert-error {
    color: #fca5a5;
}

/* ========================================
   FORM GRID
   ======================================== */
.de-grid {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 1.5rem;
}

/* ========================================
   CARDS
   ======================================== */
.de-card {
    background: var(--de-card-bg);
    border-radius: var(--de-radius-lg);
    border: 1px solid var(--de-card-border);
    overflow: hidden;
    transition: var(--de-transition);
}

.de-card:hover {
    box-shadow: var(--de-shadow);
}

.de-card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--de-card-border);
    background: linear-gradient(135deg, rgba(74, 144, 217, 0.03) 0%, transparent 100%);
}

.de-card-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1rem;
    font-weight: 700;
    color: var(--de-text-primary);
    margin: 0;
}

.de-card-title-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--de-primary) 0%, var(--de-primary-dark) 100%);
    color: white;
}

.de-card-title-icon svg {
    width: 18px;
    height: 18px;
}

.de-card-body {
    padding: 1.5rem;
}

/* ========================================
   FORM ELEMENTS
   ======================================== */
.de-form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.25rem;
}

.de-form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.de-form-group.full {
    grid-column: span 2;
}

.de-form-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--de-text-primary);
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.de-form-label .required {
    color: var(--de-danger);
}

.de-form-input,
.de-form-select,
.de-form-textarea {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid var(--de-card-border);
    border-radius: var(--de-radius);
    background: var(--de-bg);
    color: var(--de-text-primary);
    font-size: 0.95rem;
    transition: var(--de-transition);
}

.de-form-input:focus,
.de-form-select:focus,
.de-form-textarea:focus {
    outline: none;
    border-color: var(--de-primary);
    box-shadow: 0 0 0 4px var(--de-primary-light);
    background: var(--de-card-bg);
}

.de-form-input::placeholder,
.de-form-textarea::placeholder {
    color: var(--de-text-muted);
}

.de-form-input:disabled,
.de-form-select:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    background: var(--de-card-border);
}

.de-form-textarea {
    min-height: 120px;
    resize: vertical;
}

.de-form-hint {
    font-size: 0.8rem;
    color: var(--de-text-muted);
    margin-top: 0.25rem;
}

/* ========================================
   TOGGLE SWITCH
   ======================================== */
.de-toggle-group {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.de-toggle {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem 1.25rem;
    background: var(--de-bg);
    border-radius: var(--de-radius);
    transition: var(--de-transition);
    cursor: pointer;
}

.de-toggle:hover {
    background: var(--de-primary-light);
}

.de-toggle-switch {
    position: relative;
    width: 48px;
    height: 26px;
    flex-shrink: 0;
}

.de-toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.de-toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: var(--de-card-border);
    transition: var(--de-transition);
    border-radius: 26px;
}

.de-toggle-slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: var(--de-transition);
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.de-toggle-switch input:checked + .de-toggle-slider {
    background: linear-gradient(135deg, var(--de-primary) 0%, var(--de-primary-dark) 100%);
}

.de-toggle-switch input:checked + .de-toggle-slider:before {
    transform: translateX(22px);
}

.de-toggle-switch input:focus + .de-toggle-slider {
    box-shadow: 0 0 0 4px var(--de-primary-light);
}

.de-toggle-content {
    flex: 1;
}

.de-toggle-title {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--de-text-primary);
    margin: 0 0 0.25rem 0;
}

.de-toggle-desc {
    font-size: 0.8rem;
    color: var(--de-text-secondary);
    margin: 0;
}

/* ========================================
   BUTTONS
   ======================================== */
.de-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.875rem 1.5rem;
    border-radius: var(--de-radius);
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
    transition: var(--de-transition);
    border: none;
    text-decoration: none;
    width: 100%;
}

.de-btn svg {
    width: 20px;
    height: 20px;
}

.de-btn-primary {
    background: linear-gradient(135deg, var(--de-primary) 0%, var(--de-primary-dark) 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(74, 144, 217, 0.3);
}

.de-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(74, 144, 217, 0.4);
}

.de-btn-secondary {
    background: var(--de-card-bg);
    color: var(--de-text-primary);
    border: 2px solid var(--de-card-border);
}

.de-btn-secondary:hover {
    border-color: var(--de-primary);
    color: var(--de-primary);
    background: var(--de-primary-light);
}

.de-btn-success {
    background: linear-gradient(135deg, var(--de-success) 0%, #059669 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
}

.de-btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(34, 197, 94, 0.4);
}

.de-actions {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

/* ========================================
   INFO CARD
   ======================================== */
.de-info-card {
    background: var(--de-primary-light);
    border-radius: var(--de-radius);
    padding: 1.25rem;
    display: flex;
    gap: 1rem;
}

.de-info-card-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--de-primary);
    color: white;
    flex-shrink: 0;
}

.de-info-card-icon svg {
    width: 20px;
    height: 20px;
}

.de-info-card-content h4 {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--de-text-primary);
    margin: 0 0 0.375rem 0;
}

.de-info-card-content p {
    font-size: 0.8rem;
    color: var(--de-text-secondary);
    margin: 0;
    line-height: 1.5;
}

/* ========================================
   RESPONSIVE
   ======================================== */
@media (max-width: 1024px) {
    .de-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .departement-edit-page {
        padding: 1rem;
    }

    .de-header {
        padding: 1.5rem;
    }

    .de-header-content {
        flex-wrap: wrap;
    }

    .de-form-grid {
        grid-template-columns: 1fr;
    }

    .de-form-group.full {
        grid-column: span 1;
    }
}
</style>
@endsection

@section('content')
<div class="departement-edit-page">
    <!-- Header -->
    <div class="de-header">
        <div class="de-header-content">
            <a href="{{ route('admin.departements.index') }}" class="de-back-btn" title="Retour à la liste">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </a>

            <div class="de-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
            </div>

            <div class="de-header-info">
                <h1>Modifier le département</h1>
                <p>{{ $departement->nom }}</p>
            </div>
        </div>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
    <div class="de-alert de-alert-error">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="15" y1="9" x2="9" y2="15"></line>
            <line x1="9" y1="9" x2="15" y2="15"></line>
        </svg>
        <div class="de-alert-content">
            <strong>Erreurs de validation :</strong>
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <!-- Form -->
    <form action="{{ route('admin.departements.update', $departement->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="de-grid">
            <!-- Main Form -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <!-- Informations de base -->
                <div class="de-card">
                    <div class="de-card-header">
                        <h2 class="de-card-title">
                            <span class="de-card-title-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="16" x2="12" y2="12"></line>
                                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                </svg>
                            </span>
                            Informations de base
                        </h2>
                    </div>
                    <div class="de-card-body">
                        <div class="de-form-grid">
                            <div class="de-form-group full">
                                <label for="nom" class="de-form-label">
                                    Nom du département <span class="required">*</span>
                                </label>
                                <input type="text" name="nom" id="nom" value="{{ old('nom', $departement->nom) }}"
                                       class="de-form-input" placeholder="Ex: Ressources Humaines" required>
                            </div>

                            <div class="de-form-group">
                                <label for="code" class="de-form-label">Code</label>
                                <input type="text" name="code" id="code" value="{{ old('code', $departement->code) }}"
                                       class="de-form-input" placeholder="Ex: RH">
                                <span class="de-form-hint">Code court pour identifier le département</span>
                            </div>

                            @if(auth()->user()->role === 'super_admin')
                            <div class="de-form-group">
                                <label for="entreprise_id" class="de-form-label">
                                    Entreprise <span class="required">*</span>
                                </label>
                                <select name="entreprise_id" id="entreprise_id" class="de-form-select" {{ $departement->is_global ? 'disabled' : '' }}>
                                    <option value="">Sélectionnez une entreprise</option>
                                    @foreach($entreprises as $entreprise)
                                    <option value="{{ $entreprise->id }}" {{ old('entreprise_id', $departement->entreprise_id) == $entreprise->id ? 'selected' : '' }}>
                                        {{ $entreprise->nom }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            <div class="de-form-group full">
                                <label for="description" class="de-form-label">Description</label>
                                <textarea name="description" id="description" class="de-form-textarea"
                                          placeholder="Description du département...">{{ old('description', $departement->description) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <!-- Options -->
                <div class="de-card">
                    <div class="de-card-header">
                        <h2 class="de-card-title">
                            <span class="de-card-title-icon" style="background: linear-gradient(135deg, var(--de-purple) 0%, #7C3AED 100%);">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                </svg>
                            </span>
                            Options
                        </h2>
                    </div>
                    <div class="de-card-body">
                        <div class="de-toggle-group">
                            <label class="de-toggle">
                                <div class="de-toggle-switch">
                                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $departement->is_active) ? 'checked' : '' }}>
                                    <span class="de-toggle-slider"></span>
                                </div>
                                <div class="de-toggle-content">
                                    <p class="de-toggle-title">Département actif</p>
                                    <p class="de-toggle-desc">Activez ou désactivez ce département</p>
                                </div>
                            </label>

                            @if(auth()->user()->role === 'super_admin')
                            <label class="de-toggle">
                                <div class="de-toggle-switch">
                                    <input type="checkbox" name="is_global" id="is_global" value="1" {{ old('is_global', $departement->is_global) ? 'checked' : '' }}>
                                    <span class="de-toggle-slider"></span>
                                </div>
                                <div class="de-toggle-content">
                                    <p class="de-toggle-title">Département global</p>
                                    <p class="de-toggle-desc">Disponible pour toutes les entreprises</p>
                                </div>
                            </label>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="de-info-card">
                    <div class="de-info-card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                    </div>
                    <div class="de-info-card-content">
                        <h4>Astuce</h4>
                        <p>Un département global sera automatiquement disponible pour toutes les entreprises du système. Décochez cette option pour le limiter à une entreprise spécifique.</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="de-card">
                    <div class="de-card-body">
                        <div class="de-actions">
                            <button type="submit" class="de-btn de-btn-success">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                                Enregistrer les modifications
                            </button>
                            <a href="{{ route('admin.departements.show', $departement->id) }}" class="de-btn de-btn-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                Voir le département
                            </a>
                            <a href="{{ route('admin.departements.index') }}" class="de-btn de-btn-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                                Annuler
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Disable entreprise_id when is_global is checked
@if(auth()->user()->role === 'super_admin')
document.getElementById('is_global')?.addEventListener('change', function() {
    const entrepriseSelect = document.getElementById('entreprise_id');
    if (entrepriseSelect) {
        if (this.checked) {
            entrepriseSelect.disabled = true;
            entrepriseSelect.value = '';
        } else {
            entrepriseSelect.disabled = false;
        }
    }
});
@endif
</script>
@endsection
