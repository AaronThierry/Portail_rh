<!-- ========================================
     MODALE CRÉATION PERSONNEL - DESIGN PREMIUM
     Inspiré du modal entreprise avec wizard 3 étapes
======================================== -->

<style>
/* Variables Modal Personnel */
:root {
    --pm-orange: #FF9500;
    --pm-orange-dark: #E68600;
    --pm-primary: #667eea;
    --pm-primary-dark: #5a67d8;
    --pm-success: #10b981;
    --pm-danger: #ef4444;
    --pm-bg: #ffffff;
    --pm-bg-secondary: #f8fafc;
    --pm-text: #1e293b;
    --pm-text-muted: #64748b;
    --pm-border: #e2e8f0;
}

/* Modal Overlay */
.pm-modal-overlay {
    position: fixed;
    inset: 0;
    background: linear-gradient(135deg, rgba(15, 23, 42, 0.85) 0%, rgba(102, 126, 234, 0.3) 100%);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    z-index: 99999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.pm-modal-overlay.show {
    display: flex;
    opacity: 1;
}

/* Modal Container */
.pm-modal {
    background: var(--pm-bg);
    border-radius: 20px;
    width: 100%;
    max-width: 900px;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
    box-shadow:
        0 25px 80px rgba(102, 126, 234, 0.35),
        0 15px 40px rgba(0, 0, 0, 0.2),
        0 0 0 1px rgba(255, 255, 255, 0.1);
    transform: scale(0.9) translateY(20px);
    transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    overflow: hidden;
}

.pm-modal form {
    display: flex;
    flex-direction: column;
    flex: 1;
    min-height: 0;
    overflow: hidden;
}

.pm-modal-overlay.show .pm-modal {
    transform: scale(1) translateY(0);
}

/* Modal Header - Orange Gradient */
.pm-modal-header {
    background: linear-gradient(135deg, var(--pm-orange) 0%, var(--pm-orange-dark) 100%);
    padding: 1.5rem 2rem;
    position: relative;
    overflow: hidden;
    flex-shrink: 0;
    border-radius: 20px 20px 0 0;
}

.pm-modal-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}

.pm-modal-header::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0.1) 100%);
}

.pm-modal-header-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    z-index: 2;
}

.pm-modal-header-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.pm-modal-icon {
    width: 52px;
    height: 52px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.pm-modal-icon svg {
    width: 26px;
    height: 26px;
    color: white;
}

.pm-modal-header-text h2 {
    margin: 0;
    font-size: 1.375rem;
    font-weight: 700;
    color: white;
    letter-spacing: -0.02em;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.pm-modal-header-text p {
    margin: 4px 0 0;
    font-size: 0.875rem;
    color: rgba(255, 255, 255, 0.9);
}

.pm-modal-close {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.25s ease;
    flex-shrink: 0;
}

.pm-modal-close:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: rotate(90deg);
}

.pm-modal-close svg {
    width: 20px;
    height: 20px;
}

/* Step Indicator - Compact Design */
.pm-step-indicator {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.875rem 1.5rem;
    background: var(--pm-bg-secondary);
    border-bottom: 1px solid var(--pm-border);
    gap: 0.5rem;
}

.pm-step {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    position: relative;
    cursor: pointer;
    padding: 0.375rem 0.75rem;
    border-radius: 8px;
    transition: all 0.25s ease;
}

.pm-step:hover {
    background: rgba(255, 149, 0, 0.05);
}

.pm-step:not(:last-child)::after {
    content: '';
    width: 40px;
    height: 2px;
    background: var(--pm-border);
    margin-left: 0.5rem;
    transition: all 0.3s ease;
    border-radius: 1px;
}

.pm-step.active:not(:last-child)::after,
.pm-step.completed:not(:last-child)::after {
    background: var(--pm-orange);
}

.pm-step-circle {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.8125rem;
    background: var(--pm-bg);
    border: 2px solid var(--pm-border);
    color: var(--pm-text-muted);
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.pm-step.active .pm-step-circle {
    background: linear-gradient(135deg, var(--pm-orange) 0%, var(--pm-orange-dark) 100%);
    border-color: var(--pm-orange);
    color: white;
    box-shadow: 0 3px 10px rgba(255, 149, 0, 0.35);
}

.pm-step.completed .pm-step-circle {
    background: var(--pm-success);
    border-color: var(--pm-success);
    color: white;
}

.pm-step-circle svg {
    width: 16px;
    height: 16px;
}

.pm-step-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--pm-text-muted);
    transition: all 0.25s ease;
    white-space: nowrap;
}

.pm-step.active .pm-step-label {
    color: var(--pm-orange);
    font-weight: 700;
}

.pm-step.completed .pm-step-label {
    color: var(--pm-success);
}

/* Modal Body */
.pm-modal-body {
    flex: 1;
    overflow-y: auto;
    padding: 1.5rem 1.75rem;
    min-height: 0;
}

.pm-modal-body::-webkit-scrollbar {
    width: 6px;
}

.pm-modal-body::-webkit-scrollbar-track {
    background: var(--pm-bg-secondary);
    border-radius: 3px;
}

.pm-modal-body::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, var(--pm-orange) 0%, var(--pm-orange-dark) 100%);
    border-radius: 3px;
}

/* Form Sections */
.pm-form-section {
    margin-bottom: 1.5rem;
}

.pm-form-section-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid var(--pm-border);
}

.pm-form-section-icon {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, rgba(255, 149, 0, 0.15) 0%, rgba(255, 149, 0, 0.05) 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--pm-orange);
}

.pm-form-section-icon.purple {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(102, 126, 234, 0.05) 100%);
    color: var(--pm-primary);
}

.pm-form-section-icon.green {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0.05) 100%);
    color: var(--pm-success);
}

.pm-form-section-icon svg {
    width: 20px;
    height: 20px;
}

.pm-form-section-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--pm-text);
    margin: 0;
}

/* Form Grid */
.pm-form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.pm-form-grid.cols-3 {
    grid-template-columns: repeat(3, 1fr);
}

.pm-form-group {
    margin-bottom: 0;
}

.pm-form-group.full-width {
    grid-column: 1 / -1;
}

.pm-form-label {
    display: block;
    font-size: 0.8125rem;
    font-weight: 600;
    color: var(--pm-text-muted);
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.pm-form-label.required::after {
    content: '*';
    color: var(--pm-danger);
    margin-left: 4px;
}

.pm-form-input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid var(--pm-border);
    border-radius: 10px;
    font-size: 0.9375rem;
    color: var(--pm-text);
    background: var(--pm-bg);
    transition: all 0.25s ease;
}

.pm-form-input:hover {
    border-color: #cbd5e1;
}

.pm-form-input:focus {
    outline: none;
    border-color: var(--pm-orange);
    box-shadow: 0 0 0 4px rgba(255, 149, 0, 0.1);
}

.pm-form-input::placeholder {
    color: #94a3b8;
}

.pm-form-hint {
    font-size: 0.75rem;
    color: var(--pm-text-muted);
    margin-top: 0.375rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

/* Contract Type Cards */
.pm-contract-cards {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.pm-contract-card {
    position: relative;
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.25rem;
    background: var(--pm-bg);
    border: 2px solid var(--pm-border);
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.pm-contract-card:hover {
    border-color: var(--pm-orange);
    background: rgba(255, 149, 0, 0.03);
}

.pm-contract-card.selected {
    border-color: var(--pm-orange);
    background: linear-gradient(135deg, rgba(255, 149, 0, 0.08) 0%, rgba(255, 149, 0, 0.02) 100%);
    box-shadow: 0 4px 16px rgba(255, 149, 0, 0.15);
}

.pm-contract-card.selected::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--pm-orange) 0%, var(--pm-orange-dark) 100%);
    border-radius: 12px 12px 0 0;
}

.pm-contract-card input[type="radio"] {
    display: none;
}

.pm-contract-card-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 149, 0, 0.1);
    color: var(--pm-orange);
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.pm-contract-card.selected .pm-contract-card-icon {
    background: linear-gradient(135deg, var(--pm-orange) 0%, var(--pm-orange-dark) 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(255, 149, 0, 0.3);
}

.pm-contract-card-icon svg {
    width: 22px;
    height: 22px;
}

.pm-contract-card-content {
    flex: 1;
}

.pm-contract-card-title {
    font-size: 0.9375rem;
    font-weight: 700;
    color: var(--pm-text);
    margin-bottom: 2px;
}

.pm-contract-card-desc {
    font-size: 0.75rem;
    color: var(--pm-text-muted);
}

.pm-contract-card-check {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: var(--pm-border);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transform: scale(0.5);
    transition: all 0.3s ease;
}

.pm-contract-card.selected .pm-contract-card-check {
    opacity: 1;
    transform: scale(1);
    background: linear-gradient(135deg, var(--pm-success) 0%, #059669 100%);
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
}

.pm-contract-card-check svg {
    width: 14px;
    height: 14px;
    color: white;
}

/* Step Content */
.pm-step-content {
    display: none;
    animation: pmSlideIn 0.4s ease-out;
}

.pm-step-content.active {
    display: block;
}

@keyframes pmSlideIn {
    from {
        opacity: 0;
        transform: translateX(20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Modal Footer */
.pm-modal-footer {
    padding: 1rem 1.75rem;
    background: var(--pm-bg);
    border-top: 1px solid var(--pm-border);
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 0.75rem;
    flex-shrink: 0;
}

.pm-btn {
    padding: 0.625rem 1.25rem;
    border-radius: 10px;
    font-size: 0.8125rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.pm-btn svg {
    width: 16px;
    height: 16px;
}

.pm-btn-secondary {
    background: transparent;
    color: var(--pm-text-muted);
    border: 1.5px solid var(--pm-border);
}

.pm-btn-secondary:hover {
    border-color: var(--pm-orange);
    color: var(--pm-orange);
    background: rgba(255, 149, 0, 0.05);
}

.pm-btn-cancel {
    background: transparent;
    color: var(--pm-text-muted);
    border: 1.5px solid var(--pm-border);
}

.pm-btn-cancel:hover {
    background: rgba(239, 68, 68, 0.08);
    border-color: var(--pm-danger);
    color: var(--pm-danger);
}

.pm-btn-cancel:hover svg {
    transform: rotate(90deg);
}

.pm-btn-cancel svg {
    transition: transform 0.25s ease;
}

.pm-btn-primary {
    background: linear-gradient(135deg, var(--pm-orange) 0%, var(--pm-orange-dark) 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(255, 149, 0, 0.3);
    border: none;
}

.pm-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(255, 149, 0, 0.4);
}

.pm-btn-success {
    background: linear-gradient(135deg, var(--pm-success) 0%, #059669 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    border: none;
}

.pm-btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
}

.pm-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none !important;
}

.pm-footer-left {
    margin-right: auto;
}

.pm-footer-right {
    display: flex;
    gap: 0.75rem;
}

/* Field Error */
.pm-field-error {
    color: var(--pm-danger);
    font-size: 0.8125rem;
    margin-top: 0.375rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.pm-form-input.error {
    border-color: var(--pm-danger);
}

/* CDD Date Group */
.pm-cdd-group {
    margin-top: 1rem;
    padding: 1rem;
    background: rgba(255, 149, 0, 0.05);
    border: 2px dashed rgba(255, 149, 0, 0.3);
    border-radius: 12px;
    display: none;
}

.pm-cdd-group.show {
    display: block;
    animation: pmSlideIn 0.3s ease-out;
}

/* Dark Mode Support */
.dark .pm-modal {
    --pm-bg: #1e293b;
    --pm-bg-secondary: #0f172a;
    --pm-text: #f1f5f9;
    --pm-text-muted: #94a3b8;
    --pm-border: #334155;
}

.dark .pm-modal-body {
    background: var(--pm-bg);
}

.dark .pm-form-input {
    background: var(--pm-bg-secondary);
    color: var(--pm-text);
}

.dark .pm-contract-card {
    background: var(--pm-bg-secondary);
}

.dark .pm-modal-footer {
    background: var(--pm-bg);
    border-top-color: var(--pm-border);
}

.dark .pm-btn-cancel,
.dark .pm-btn-secondary {
    background: var(--pm-bg-secondary);
    border-color: var(--pm-border);
    color: var(--pm-text-muted);
}

.dark .pm-step-indicator {
    background: linear-gradient(180deg, rgba(255, 149, 0, 0.1) 0%, var(--pm-bg-secondary) 100%);
}

.dark .pm-step-circle {
    background: var(--pm-bg-secondary);
    border-color: var(--pm-border);
}

.dark .pm-form-section-header {
    border-bottom-color: var(--pm-border);
}

.dark .pm-form-section-title {
    color: var(--pm-text);
}

.dark .pm-contract-card-title {
    color: var(--pm-text);
}

.dark .pm-cdd-group {
    background: rgba(255, 149, 0, 0.08);
    border-color: rgba(255, 149, 0, 0.2);
}

/* Responsive */
@media (max-width: 768px) {
    .pm-form-grid {
        grid-template-columns: 1fr;
    }

    .pm-contract-cards {
        grid-template-columns: 1fr;
    }

    .pm-step-label {
        font-size: 0.6875rem;
    }

    .pm-modal-footer {
        flex-direction: column;
    }

    .pm-footer-left,
    .pm-footer-right {
        width: 100%;
    }

    .pm-footer-right {
        justify-content: flex-end;
    }
}
</style>

<!-- Modal Structure -->
<div class="pm-modal-overlay" id="personnelModalV3">
    <div class="pm-modal">
        <!-- Header -->
        <div class="pm-modal-header">
            <div class="pm-modal-header-content">
                <div class="pm-modal-header-left">
                    <div class="pm-modal-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="8.5" cy="7" r="4"></circle>
                            <line x1="20" y1="8" x2="20" y2="14"></line>
                            <line x1="23" y1="11" x2="17" y2="11"></line>
                        </svg>
                    </div>
                    <div class="pm-modal-header-text">
                        <h2>Nouveau Personnel</h2>
                        <p>Enregistrer un nouvel employé dans le système</p>
                    </div>
                </div>
                <button type="button" class="pm-modal-close" onclick="closePersonnelModalV3()">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Step Indicator -->
        <div class="pm-step-indicator">
            <div class="pm-step active" data-step="1" onclick="goToStepV3(1)">
                <div class="pm-step-circle">1</div>
                <span class="pm-step-label">Identité</span>
            </div>
            <div class="pm-step" data-step="2" onclick="goToStepV3(2)">
                <div class="pm-step-circle">2</div>
                <span class="pm-step-label">Contact</span>
            </div>
            <div class="pm-step" data-step="3" onclick="goToStepV3(3)">
                <div class="pm-step-circle">3</div>
                <span class="pm-step-label">Contrat</span>
            </div>
        </div>

        <!-- Form -->
        <form id="personnelFormV3" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="personnel_id">

            <div class="pm-modal-body">
                <!-- ÉTAPE 1: Identité -->
                <div class="pm-step-content active" data-step="1">
                    @if(auth()->user()->hasRole('Super Admin'))
                    <div class="pm-form-section">
                        <div class="pm-form-section-header">
                            <div class="pm-form-section-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                                </svg>
                            </div>
                            <h3 class="pm-form-section-title">Entreprise</h3>
                        </div>
                        <div class="pm-form-group">
                            <label class="pm-form-label required">Entreprise d'affectation</label>
                            <select name="entreprise_id" class="pm-form-input" required>
                                <option value="">Sélectionner une entreprise</option>
                                @foreach($entreprises as $entreprise)
                                <option value="{{ $entreprise->id }}" {{ $entreprise->id == auth()->user()->entreprise_id ? 'selected' : '' }}>{{ $entreprise->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @else
                    <input type="hidden" name="entreprise_id" value="{{ auth()->user()->entreprise_id }}">
                    @endif

                    <div class="pm-form-section">
                        <div class="pm-form-section-header">
                            <div class="pm-form-section-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <h3 class="pm-form-section-title">Informations personnelles</h3>
                        </div>
                        <div class="pm-form-grid">
                            <div class="pm-form-group">
                                <label class="pm-form-label">Civilité</label>
                                <select name="civilite" class="pm-form-input">
                                    <option value="">Sélectionner</option>
                                    <option value="M.">M.</option>
                                    <option value="Mme">Mme</option>
                                    <option value="Mlle">Mlle</option>
                                    <option value="Dr">Dr</option>
                                    <option value="Pr">Pr</option>
                                </select>
                            </div>
                            <div class="pm-form-group">
                                <label class="pm-form-label required">Nom</label>
                                <input type="text" name="nom" class="pm-form-input" placeholder="Nom de famille" required>
                            </div>
                            <div class="pm-form-group">
                                <label class="pm-form-label required">Prénom(s)</label>
                                <input type="text" name="prenoms" class="pm-form-input" placeholder="Prénom(s)" required>
                            </div>
                            <div class="pm-form-group">
                                <label class="pm-form-label">Sexe</label>
                                <select name="sexe" class="pm-form-input">
                                    <option value="">Sélectionner</option>
                                    <option value="M">Masculin</option>
                                    <option value="F">Féminin</option>
                                </select>
                            </div>
                            <div class="pm-form-group">
                                <label class="pm-form-label">Matricule</label>
                                <input type="text" name="matricule" class="pm-form-input" placeholder="Laissez vide pour auto">
                                <span class="pm-form-hint">Format: PER{{ date('Y') }}XXXX</span>
                            </div>
                            <div class="pm-form-group">
                                <label class="pm-form-label">Date de naissance</label>
                                <input type="date" name="date_naissance" class="pm-form-input">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ÉTAPE 2: Contact -->
                <div class="pm-step-content" data-step="2">
                    <div class="pm-form-section">
                        <div class="pm-form-section-header">
                            <div class="pm-form-section-icon purple">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                            </div>
                            <h3 class="pm-form-section-title">Coordonnées</h3>
                        </div>
                        <div class="pm-form-grid">
                            <div class="pm-form-group full-width">
                                <label class="pm-form-label">Adresse</label>
                                <textarea name="adresse" class="pm-form-input" rows="2" placeholder="Adresse complète"></textarea>
                            </div>
                            <div class="pm-form-group">
                                <label class="pm-form-label">Code pays</label>
                                <select name="telephone_code_pays" class="pm-form-input">
                                    <option value="+226" selected>🇧🇫 Burkina Faso (+226)</option>
                                    <option value="+225">🇨🇮 Côte d'Ivoire (+225)</option>
                                    <option value="+221">🇸🇳 Sénégal (+221)</option>
                                    <option value="+223">🇲🇱 Mali (+223)</option>
                                    <option value="+227">🇳🇪 Niger (+227)</option>
                                    <option value="+228">🇹🇬 Togo (+228)</option>
                                    <option value="+229">🇧🇯 Bénin (+229)</option>
                                    <option value="+33">🇫🇷 France (+33)</option>
                                </select>
                            </div>
                            <div class="pm-form-group">
                                <label class="pm-form-label">Téléphone</label>
                                <input type="tel" name="telephone" class="pm-form-input" placeholder="XX XX XX XX">
                            </div>
                        </div>
                        <div class="pm-form-group" style="margin-top: 0.75rem;">
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.875rem; color: var(--pm-text-muted);">
                                <input type="checkbox" name="telephone_whatsapp" value="1" style="width: 18px; height: 18px; accent-color: var(--pm-orange);">
                                Ce numéro est disponible sur WhatsApp
                            </label>
                        </div>
                    </div>

                    <div class="pm-form-section">
                        <div class="pm-form-section-header">
                            <div class="pm-form-section-icon green">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            </div>
                            <h3 class="pm-form-section-title">Documents</h3>
                        </div>
                        <div class="pm-form-grid">
                            <div class="pm-form-group">
                                <label class="pm-form-label">Numéro d'identification</label>
                                <input type="text" name="numero_identification" class="pm-form-input" placeholder="CNI, Passeport, etc.">
                            </div>
                            <div class="pm-form-group">
                                <label class="pm-form-label">Photo</label>
                                <input type="file" name="photo" class="pm-form-input" accept="image/*">
                                <span class="pm-form-hint">JPG, PNG - Max 2 Mo</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ÉTAPE 3: Contrat -->
                <div class="pm-step-content" data-step="3">
                    <div class="pm-form-section">
                        <div class="pm-form-section-header">
                            <div class="pm-form-section-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                </svg>
                            </div>
                            <h3 class="pm-form-section-title">Poste et affectation</h3>
                        </div>
                        <div class="pm-form-grid">
                            <div class="pm-form-group">
                                <label class="pm-form-label">Poste</label>
                                <input type="text" name="poste" class="pm-form-input" placeholder="Ex: Développeur, Comptable...">
                            </div>
                            <div class="pm-form-group">
                                <label class="pm-form-label">Date d'embauche</label>
                                <input type="date" name="date_embauche" class="pm-form-input">
                            </div>
                        </div>
                    </div>

                    <div class="pm-form-section">
                        <div class="pm-form-section-header">
                            <div class="pm-form-section-icon purple">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                </svg>
                            </div>
                            <h3 class="pm-form-section-title">Type de contrat</h3>
                        </div>

                        <input type="hidden" name="type_contrat" id="pm_type_contrat" value="CDI">

                        <div class="pm-contract-cards">
                            <label class="pm-contract-card selected" data-type="CDI" onclick="selectContractType('CDI')">
                                <input type="radio" name="type_contrat_radio" value="CDI" checked>
                                <div class="pm-contract-card-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                    </svg>
                                </div>
                                <div class="pm-contract-card-content">
                                    <span class="pm-contract-card-title">CDI</span>
                                    <span class="pm-contract-card-desc">Contrat à Durée Indéterminée</span>
                                </div>
                                <div class="pm-contract-card-check">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </div>
                            </label>

                            <label class="pm-contract-card" data-type="CDD" onclick="selectContractType('CDD')">
                                <input type="radio" name="type_contrat_radio" value="CDD">
                                <div class="pm-contract-card-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>
                                </div>
                                <div class="pm-contract-card-content">
                                    <span class="pm-contract-card-title">CDD</span>
                                    <span class="pm-contract-card-desc">Contrat à Durée Déterminée</span>
                                </div>
                                <div class="pm-contract-card-check">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </div>
                            </label>
                        </div>

                        <div class="pm-cdd-group" id="pm_cdd_group">
                            <div class="pm-form-group">
                                <label class="pm-form-label required">Date de fin de contrat</label>
                                <input type="date" name="date_fin_contrat" id="pm_date_fin_contrat" class="pm-form-input">
                                <span class="pm-form-hint">Obligatoire pour un CDD</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="pm-modal-footer">
                <div class="pm-footer-left">
                    <button type="button" class="pm-btn pm-btn-secondary" id="pm_btn_prev" onclick="prevStepV3()" style="display: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                        Précédent
                    </button>
                </div>
                <div class="pm-footer-right">
                    <button type="button" class="pm-btn pm-btn-cancel" onclick="closePersonnelModalV3()">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                        Annuler
                    </button>
                    <button type="button" class="pm-btn pm-btn-primary" id="pm_btn_next" onclick="nextStepV3()">
                        Suivant
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </button>
                    <button type="submit" class="pm-btn pm-btn-success" id="pm_btn_submit" style="display: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        Enregistrer
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Variables
let currentStepV3 = 1;
const totalStepsV3 = 3;

// Open Modal
function openPersonnelModalV3() {
    const modal = document.getElementById('personnelModalV3');
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
    resetFormV3();
}

// Close Modal
function closePersonnelModalV3() {
    const modal = document.getElementById('personnelModalV3');
    modal.classList.remove('show');
    document.body.style.overflow = '';
}

// Reset Form
function resetFormV3() {
    document.getElementById('personnelFormV3').reset();
    currentStepV3 = 1;
    showStepV3(1);
    selectContractType('CDI');
}

// Show Step
function showStepV3(step) {
    currentStepV3 = step;

    // Update step content
    document.querySelectorAll('.pm-step-content').forEach(el => el.classList.remove('active'));
    const activeContent = document.querySelector(`.pm-step-content[data-step="${step}"]`);
    if (activeContent) activeContent.classList.add('active');

    // Update step indicator
    document.querySelectorAll('.pm-step').forEach((el, idx) => {
        const stepNum = idx + 1;
        el.classList.remove('active', 'completed');

        if (stepNum === step) {
            el.classList.add('active');
            el.querySelector('.pm-step-circle').innerHTML = stepNum;
        } else if (stepNum < step) {
            el.classList.add('completed');
            el.querySelector('.pm-step-circle').innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>';
        } else {
            el.querySelector('.pm-step-circle').innerHTML = stepNum;
        }
    });

    // Update buttons
    document.getElementById('pm_btn_prev').style.display = step === 1 ? 'none' : 'inline-flex';
    document.getElementById('pm_btn_next').style.display = step === totalStepsV3 ? 'none' : 'inline-flex';
    document.getElementById('pm_btn_submit').style.display = step === totalStepsV3 ? 'inline-flex' : 'none';
}

// Next Step
function nextStepV3() {
    if (validateStepV3(currentStepV3)) {
        if (currentStepV3 < totalStepsV3) {
            showStepV3(currentStepV3 + 1);
        }
    }
}

// Previous Step
function prevStepV3() {
    if (currentStepV3 > 1) {
        showStepV3(currentStepV3 - 1);
    }
}

// Go to specific step
function goToStepV3(targetStep) {
    if (targetStep < currentStepV3) {
        showStepV3(targetStep);
    } else if (targetStep > currentStepV3) {
        // Validate all steps before
        for (let i = currentStepV3; i < targetStep; i++) {
            if (!validateStepV3(i)) return;
        }
        showStepV3(targetStep);
    }
}

// Validate Step
function validateStepV3(step) {
    const form = document.getElementById('personnelFormV3');
    clearErrorsV3();

    if (step === 1) {
        const nom = form.querySelector('[name="nom"]');
        const prenoms = form.querySelector('[name="prenoms"]');
        let isValid = true;

        if (!nom.value.trim()) {
            showFieldError(nom, 'Le nom est obligatoire');
            isValid = false;
        }
        if (!prenoms.value.trim()) {
            showFieldError(prenoms, 'Le(s) prénom(s) sont obligatoires');
            isValid = false;
        }
        return isValid;
    }

    if (step === 3) {
        const typeContrat = document.getElementById('pm_type_contrat').value;
        if (typeContrat === 'CDD') {
            const dateFin = document.getElementById('pm_date_fin_contrat');
            if (!dateFin.value) {
                showFieldError(dateFin, 'La date de fin est obligatoire pour un CDD');
                return false;
            }
        }
    }

    return true;
}

// Show Field Error
function showFieldError(field, message) {
    field.classList.add('error');
    const error = document.createElement('div');
    error.className = 'pm-field-error';
    error.innerHTML = `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>${message}`;
    field.parentNode.appendChild(error);
    field.focus();
}

// Clear Errors
function clearErrorsV3() {
    document.querySelectorAll('.pm-field-error').forEach(e => e.remove());
    document.querySelectorAll('.pm-form-input.error').forEach(e => e.classList.remove('error'));
}

// Select Contract Type
function selectContractType(type) {
    document.getElementById('pm_type_contrat').value = type;

    document.querySelectorAll('.pm-contract-card').forEach(card => {
        card.classList.toggle('selected', card.dataset.type === type);
    });

    const cddGroup = document.getElementById('pm_cdd_group');
    cddGroup.classList.toggle('show', type === 'CDD');

    const dateFin = document.getElementById('pm_date_fin_contrat');
    dateFin.required = type === 'CDD';
}

// Form Submit
document.getElementById('personnelFormV3').addEventListener('submit', async function(e) {
    e.preventDefault();

    if (!validateStepV3(currentStepV3)) return;

    clearErrorsV3();

    const formData = new FormData(this);
    const submitBtn = document.getElementById('pm_btn_submit');
    const originalHTML = submitBtn.innerHTML;

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<svg class="animate-spin" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Enregistrement...';

    try {
        const response = await fetch('{{ route("admin.personnels.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (response.ok && data.success !== false) {
            submitBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg> Créé avec succès!';

            setTimeout(() => {
                closePersonnelModalV3();
                window.location.reload();
            }, 1000);
        } else {
            if (data.errors) {
                Object.keys(data.errors).forEach(fieldName => {
                    const field = document.querySelector(`[name="${fieldName}"]`);
                    if (field) {
                        const stepEl = field.closest('.pm-step-content');
                        if (stepEl) {
                            const stepNum = parseInt(stepEl.dataset.step);
                            showStepV3(stepNum);
                        }
                        showFieldError(field, data.errors[fieldName][0]);
                    }
                });
            } else {
                alert('Erreur: ' + (data.message || 'Une erreur est survenue'));
            }

            submitBtn.disabled = false;
            submitBtn.innerHTML = originalHTML;
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Erreur de connexion au serveur');
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalHTML;
    }
});

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    const modal = document.getElementById('personnelModalV3');
    if (!modal.classList.contains('show')) return;

    if (e.key === 'Escape') {
        closePersonnelModalV3();
    }
});

// Close on overlay click
document.getElementById('personnelModalV3').addEventListener('click', function(e) {
    if (e.target === this) {
        closePersonnelModalV3();
    }
});

// Init button
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('btnAddPersonnel');
    if (btn) btn.onclick = openPersonnelModalV3;
});
</script>
