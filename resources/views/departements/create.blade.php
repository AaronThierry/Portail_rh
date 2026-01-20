@extends('layouts.app')

@section('title', 'Nouveau Département')
@section('page-title', 'Nouveau Département')
@section('page-subtitle', 'Créez un nouveau département')

@section('styles')
<style>
/* ========================================
   VARIABLES - Charte RH+ Premium
   ======================================== */
:root {
    --dc-primary: #4A90D9;
    --dc-primary-dark: #2E6BB3;
    --dc-primary-light: #E8F4FD;
    --dc-accent: #FF9500;
    --dc-accent-light: #FFF7ED;
    --dc-success: #22C55E;
    --dc-success-light: #F0FDF4;
    --dc-danger: #EF4444;
    --dc-danger-light: #FEF2F2;
    --dc-info: #3B82F6;
    --dc-info-light: #EFF6FF;
    --dc-purple: #8B5CF6;
    --dc-purple-light: #F5F3FF;
    --dc-bg: #f8fafc;
    --dc-card-bg: #ffffff;
    --dc-card-border: #e2e8f0;
    --dc-text-primary: #1e293b;
    --dc-text-secondary: #64748b;
    --dc-text-muted: #94a3b8;
    --dc-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    --dc-shadow-lg: 0 8px 30px rgba(0, 0, 0, 0.1);
    --dc-radius: 12px;
    --dc-radius-lg: 16px;
    --dc-radius-xl: 20px;
    --dc-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.dark {
    --dc-bg: #0f172a;
    --dc-card-bg: #1e293b;
    --dc-card-border: #334155;
    --dc-text-primary: #f1f5f9;
    --dc-text-secondary: #94a3b8;
    --dc-text-muted: #64748b;
    --dc-primary-light: rgba(74, 144, 217, 0.15);
    --dc-success-light: rgba(34, 197, 94, 0.15);
    --dc-danger-light: rgba(239, 68, 68, 0.15);
}

/* ========================================
   BASE
   ======================================== */
.departement-create-page {
    padding: 1.5rem;
    min-height: 100vh;
    background: var(--dc-bg);
}

/* ========================================
   HEADER
   ======================================== */
.dc-header {
    background: var(--dc-card-bg);
    border-radius: var(--dc-radius-xl);
    padding: 2rem;
    margin-bottom: 1.5rem;
    box-shadow: var(--dc-shadow);
    border: 1px solid var(--dc-card-border);
    position: relative;
    overflow: hidden;
}

.dc-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--dc-success), var(--dc-primary));
}

.dc-header-content {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.dc-back-btn {
    width: 44px;
    height: 44px;
    border-radius: var(--dc-radius);
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--dc-bg);
    border: 2px solid var(--dc-card-border);
    color: var(--dc-text-secondary);
    text-decoration: none;
    transition: var(--dc-transition);
    flex-shrink: 0;
}

.dc-back-btn:hover {
    border-color: var(--dc-primary);
    color: var(--dc-primary);
    background: var(--dc-primary-light);
    transform: translateX(-3px);
}

.dc-back-btn svg {
    width: 20px;
    height: 20px;
}

.dc-header-icon {
    width: 56px;
    height: 56px;
    border-radius: var(--dc-radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--dc-success) 0%, #059669 100%);
    color: white;
    box-shadow: 0 8px 20px rgba(34, 197, 94, 0.3);
    flex-shrink: 0;
}

.dc-header-icon svg {
    width: 28px;
    height: 28px;
}

.dc-header-info h1 {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--dc-text-primary);
    margin: 0 0 0.25rem 0;
}

.dc-header-info p {
    font-size: 0.9rem;
    color: var(--dc-text-secondary);
    margin: 0;
}

/* ========================================
   ALERTS
   ======================================== */
.dc-alert {
    display: flex;
    align-items: flex-start;
    gap: 0.875rem;
    padding: 1rem 1.25rem;
    border-radius: var(--dc-radius);
    margin-bottom: 1.5rem;
    border-left: 4px solid;
}

.dc-alert svg {
    width: 22px;
    height: 22px;
    flex-shrink: 0;
    margin-top: 0.125rem;
}

.dc-alert-content {
    flex: 1;
}

.dc-alert-content strong {
    display: block;
    margin-bottom: 0.5rem;
}

.dc-alert-content ul {
    margin: 0;
    padding-left: 1.25rem;
}

.dc-alert-content li {
    margin-bottom: 0.25rem;
}

.dc-alert-error {
    background: var(--dc-danger-light);
    border-color: var(--dc-danger);
    color: #991b1b;
}

.dark .dc-alert-error {
    color: #fca5a5;
}

/* ========================================
   FORM GRID
   ======================================== */
.dc-grid {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 1.5rem;
}

/* ========================================
   CARDS
   ======================================== */
.dc-card {
    background: var(--dc-card-bg);
    border-radius: var(--dc-radius-lg);
    border: 1px solid var(--dc-card-border);
    overflow: hidden;
    transition: var(--dc-transition);
}

.dc-card:hover {
    box-shadow: var(--dc-shadow);
}

.dc-card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--dc-card-border);
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.03) 0%, transparent 100%);
}

.dc-card-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1rem;
    font-weight: 700;
    color: var(--dc-text-primary);
    margin: 0;
}

.dc-card-title-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--dc-primary) 0%, var(--dc-primary-dark) 100%);
    color: white;
}

.dc-card-title-icon svg {
    width: 18px;
    height: 18px;
}

.dc-card-body {
    padding: 1.5rem;
}

/* ========================================
   FORM ELEMENTS
   ======================================== */
.dc-form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.25rem;
}

.dc-form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.dc-form-group.full {
    grid-column: span 2;
}

.dc-form-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--dc-text-primary);
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.dc-form-label .required {
    color: var(--dc-danger);
}

.dc-form-input,
.dc-form-select,
.dc-form-textarea {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid var(--dc-card-border);
    border-radius: var(--dc-radius);
    background: var(--dc-bg);
    color: var(--dc-text-primary);
    font-size: 0.95rem;
    transition: var(--dc-transition);
}

.dc-form-input:focus,
.dc-form-select:focus,
.dc-form-textarea:focus {
    outline: none;
    border-color: var(--dc-primary);
    box-shadow: 0 0 0 4px var(--dc-primary-light);
    background: var(--dc-card-bg);
}

.dc-form-input::placeholder,
.dc-form-textarea::placeholder {
    color: var(--dc-text-muted);
}

.dc-form-input:disabled,
.dc-form-select:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    background: var(--dc-card-border);
}

.dc-form-textarea {
    min-height: 120px;
    resize: vertical;
}

.dc-form-hint {
    font-size: 0.8rem;
    color: var(--dc-text-muted);
    margin-top: 0.25rem;
}

/* ========================================
   TOGGLE SWITCH
   ======================================== */
.dc-toggle-group {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.dc-toggle {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem 1.25rem;
    background: var(--dc-bg);
    border-radius: var(--dc-radius);
    transition: var(--dc-transition);
    cursor: pointer;
}

.dc-toggle:hover {
    background: var(--dc-primary-light);
}

.dc-toggle-switch {
    position: relative;
    width: 48px;
    height: 26px;
    flex-shrink: 0;
}

.dc-toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.dc-toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: var(--dc-card-border);
    transition: var(--dc-transition);
    border-radius: 26px;
}

.dc-toggle-slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: var(--dc-transition);
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.dc-toggle-switch input:checked + .dc-toggle-slider {
    background: linear-gradient(135deg, var(--dc-success) 0%, #059669 100%);
}

.dc-toggle-switch input:checked + .dc-toggle-slider:before {
    transform: translateX(22px);
}

.dc-toggle-switch input:focus + .dc-toggle-slider {
    box-shadow: 0 0 0 4px var(--dc-primary-light);
}

.dc-toggle-content {
    flex: 1;
}

.dc-toggle-title {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--dc-text-primary);
    margin: 0 0 0.25rem 0;
}

.dc-toggle-desc {
    font-size: 0.8rem;
    color: var(--dc-text-secondary);
    margin: 0;
}

/* ========================================
   BUTTONS
   ======================================== */
.dc-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.875rem 1.5rem;
    border-radius: var(--dc-radius);
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
    transition: var(--dc-transition);
    border: none;
    text-decoration: none;
    width: 100%;
}

.dc-btn svg {
    width: 20px;
    height: 20px;
}

.dc-btn-primary {
    background: linear-gradient(135deg, var(--dc-success) 0%, #059669 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
}

.dc-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(34, 197, 94, 0.4);
}

.dc-btn-secondary {
    background: var(--dc-card-bg);
    color: var(--dc-text-primary);
    border: 2px solid var(--dc-card-border);
}

.dc-btn-secondary:hover {
    border-color: var(--dc-primary);
    color: var(--dc-primary);
    background: var(--dc-primary-light);
}

.dc-actions {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

/* ========================================
   INFO CARD
   ======================================== */
.dc-info-card {
    background: var(--dc-success-light);
    border-radius: var(--dc-radius);
    padding: 1.25rem;
    display: flex;
    gap: 1rem;
}

.dc-info-card-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--dc-success);
    color: white;
    flex-shrink: 0;
}

.dc-info-card-icon svg {
    width: 20px;
    height: 20px;
}

.dc-info-card-content h4 {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--dc-text-primary);
    margin: 0 0 0.375rem 0;
}

.dc-info-card-content p {
    font-size: 0.8rem;
    color: var(--dc-text-secondary);
    margin: 0;
    line-height: 1.5;
}

/* ========================================
   RESPONSIVE
   ======================================== */
@media (max-width: 1024px) {
    .dc-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .departement-create-page {
        padding: 1rem;
    }

    .dc-header {
        padding: 1.5rem;
    }

    .dc-header-content {
        flex-wrap: wrap;
    }

    .dc-form-grid {
        grid-template-columns: 1fr;
    }

    .dc-form-group.full {
        grid-column: span 1;
    }
}
</style>
@endsection

@section('content')
<div class="departement-create-page">
    <!-- Header -->
    <div class="dc-header">
        <div class="dc-header-content">
            <a href="{{ route('admin.departements.index') }}" class="dc-back-btn" title="Retour à la liste">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </a>

            <div class="dc-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
            </div>

            <div class="dc-header-info">
                <h1>Nouveau département</h1>
                <p>Créez un nouveau département pour organiser votre structure</p>
            </div>
        </div>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
    <div class="dc-alert dc-alert-error">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="15" y1="9" x2="9" y2="15"></line>
            <line x1="9" y1="9" x2="15" y2="15"></line>
        </svg>
        <div class="dc-alert-content">
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
    <form action="{{ route('admin.departements.store') }}" method="POST">
        @csrf

        <div class="dc-grid">
            <!-- Main Form -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <!-- Informations de base -->
                <div class="dc-card">
                    <div class="dc-card-header">
                        <h2 class="dc-card-title">
                            <span class="dc-card-title-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="16" x2="12" y2="12"></line>
                                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                </svg>
                            </span>
                            Informations de base
                        </h2>
                    </div>
                    <div class="dc-card-body">
                        <div class="dc-form-grid">
                            <div class="dc-form-group full">
                                <label for="nom" class="dc-form-label">
                                    Nom du département <span class="required">*</span>
                                </label>
                                <input type="text" name="nom" id="nom" value="{{ old('nom') }}"
                                       class="dc-form-input" placeholder="Ex: Ressources Humaines" required>
                            </div>

                            <div class="dc-form-group">
                                <label for="code" class="dc-form-label">Code</label>
                                <input type="text" name="code" id="code" value="{{ old('code') }}"
                                       class="dc-form-input" placeholder="Ex: RH">
                                <span class="dc-form-hint">Code court pour identifier le département</span>
                            </div>

                            @if(auth()->user()->role === 'super_admin')
                            <div class="dc-form-group">
                                <label for="entreprise_id" class="dc-form-label">
                                    Entreprise <span class="required">*</span>
                                </label>
                                <select name="entreprise_id" id="entreprise_id" class="dc-form-select" required>
                                    <option value="">Sélectionnez une entreprise</option>
                                    @foreach($entreprises as $entreprise)
                                    <option value="{{ $entreprise->id }}" {{ old('entreprise_id') == $entreprise->id ? 'selected' : '' }}>
                                        {{ $entreprise->nom }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            <div class="dc-form-group full">
                                <label for="description" class="dc-form-label">Description</label>
                                <textarea name="description" id="description" class="dc-form-textarea"
                                          placeholder="Description du département...">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <!-- Options -->
                <div class="dc-card">
                    <div class="dc-card-header">
                        <h2 class="dc-card-title">
                            <span class="dc-card-title-icon" style="background: linear-gradient(135deg, var(--dc-purple) 0%, #7C3AED 100%);">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                </svg>
                            </span>
                            Options
                        </h2>
                    </div>
                    <div class="dc-card-body">
                        <div class="dc-toggle-group">
                            <label class="dc-toggle">
                                <div class="dc-toggle-switch">
                                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <span class="dc-toggle-slider"></span>
                                </div>
                                <div class="dc-toggle-content">
                                    <p class="dc-toggle-title">Département actif</p>
                                    <p class="dc-toggle-desc">Le département sera visible et utilisable</p>
                                </div>
                            </label>

                            @if(auth()->user()->role === 'super_admin')
                            <label class="dc-toggle">
                                <div class="dc-toggle-switch">
                                    <input type="checkbox" name="is_global" id="is_global" value="1" {{ old('is_global') ? 'checked' : '' }}>
                                    <span class="dc-toggle-slider"></span>
                                </div>
                                <div class="dc-toggle-content">
                                    <p class="dc-toggle-title">Département global</p>
                                    <p class="dc-toggle-desc">Disponible pour toutes les entreprises</p>
                                </div>
                            </label>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="dc-info-card">
                    <div class="dc-info-card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                    <div class="dc-info-card-content">
                        <h4>Conseil</h4>
                        <p>Un département permet d'organiser votre structure et de regrouper les services. Vous pourrez ensuite créer des services au sein de ce département.</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="dc-card">
                    <div class="dc-card-body">
                        <div class="dc-actions">
                            <button type="submit" class="dc-btn dc-btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                Créer le département
                            </button>
                            <a href="{{ route('admin.departements.index') }}" class="dc-btn dc-btn-secondary">
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
            entrepriseSelect.required = false;
            entrepriseSelect.value = '';
        } else {
            entrepriseSelect.disabled = false;
            entrepriseSelect.required = true;
        }
    }
});
@endif
</script>
@endsection
