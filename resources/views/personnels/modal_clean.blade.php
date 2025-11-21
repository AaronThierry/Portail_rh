<!-- ========================================
     MODALE CRÉATION PERSONNEL - VERSION CLEAN
     Architecture: 3 étapes avec navigation fluide
     ======================================== -->
<div class="personnel-modal-overlay" id="personnelModal">
    <div class="personnel-modal">
        <!-- Header -->
        <div class="personnel-modal-header">
            <h2 class="personnel-modal-title">📋 Nouveau Personnel</h2>
            <button type="button" class="personnel-modal-close" onclick="closePersonnelModal()">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <!-- Progress Indicator -->
        <div class="personnel-progress">
            <div class="personnel-progress-step active" data-step="1">
                <div class="personnel-progress-number">1</div>
                <div class="personnel-progress-label">Identité</div>
            </div>
            <div class="personnel-progress-line"></div>
            <div class="personnel-progress-step" data-step="2">
                <div class="personnel-progress-number">2</div>
                <div class="personnel-progress-label">Contact</div>
            </div>
            <div class="personnel-progress-line"></div>
            <div class="personnel-progress-step" data-step="3">
                <div class="personnel-progress-number">3</div>
                <div class="personnel-progress-label">Contrat</div>
            </div>
        </div>

        <!-- Form -->
        <form id="personnelForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="personnelId" name="personnel_id">

            <!-- Modal Body avec scroll -->
            <div class="personnel-modal-body">

                <!-- ÉTAPE 1: Informations Personnelles -->
                <div class="personnel-step active" data-step="1">
                    <h3 class="personnel-step-title">👤 Informations Personnelles</h3>

                    @if(auth()->user()->hasRole('Super Admin'))
                    <div class="personnel-form-group full">
                        <label class="personnel-label required">Entreprise</label>
                        <select id="entreprise_id" name="entreprise_id" class="personnel-input" required>
                            <option value="">Sélectionner une entreprise</option>
                            @foreach($entreprises as $entreprise)
                            <option value="{{ $entreprise->id }}" {{ $entreprise->id == auth()->user()->entreprise_id ? 'selected' : '' }}>
                                {{ $entreprise->nom }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @else
                    <input type="hidden" name="entreprise_id" value="{{ auth()->user()->entreprise_id }}">
                    @endif

                    <div class="personnel-form-row">
                        <div class="personnel-form-group">
                            <label class="personnel-label">Civilité</label>
                            <select id="civilite" name="civilite" class="personnel-input">
                                <option value="">Sélectionner</option>
                                <option value="M.">M.</option>
                                <option value="Mme">Mme</option>
                                <option value="Mlle">Mlle</option>
                                <option value="Dr">Dr</option>
                                <option value="Pr">Pr</option>
                            </select>
                        </div>

                        <div class="personnel-form-group">
                            <label class="personnel-label required">Nom</label>
                            <input type="text" id="nom" name="nom" class="personnel-input" required placeholder="Nom de famille">
                        </div>
                    </div>

                    <div class="personnel-form-row">
                        <div class="personnel-form-group">
                            <label class="personnel-label required">Prénom(s)</label>
                            <input type="text" id="prenoms" name="prenoms" class="personnel-input" required placeholder="Prénom(s)">
                        </div>

                        <div class="personnel-form-group">
                            <label class="personnel-label">Sexe</label>
                            <select id="sexe" name="sexe" class="personnel-input">
                                <option value="">Sélectionner</option>
                                <option value="M">Masculin</option>
                                <option value="F">Féminin</option>
                            </select>
                        </div>
                    </div>

                    <div class="personnel-form-row">
                        <div class="personnel-form-group">
                            <label class="personnel-label">Matricule</label>
                            <input type="text" id="matricule" name="matricule" class="personnel-input" placeholder="Laissez vide pour génération auto">
                            <small class="personnel-hint">Si vide: PER{{ date('Y') }}####</small>
                        </div>

                        <div class="personnel-form-group">
                            <label class="personnel-label">Date de naissance</label>
                            <input type="date" id="date_naissance" name="date_naissance" class="personnel-input">
                        </div>
                    </div>
                </div>

                <!-- ÉTAPE 2: Coordonnées & Documents -->
                <div class="personnel-step" data-step="2">
                    <h3 class="personnel-step-title">📞 Coordonnées & Documents</h3>

                    <div class="personnel-form-group full">
                        <label class="personnel-label">Adresse</label>
                        <textarea id="adresse" name="adresse" class="personnel-input" rows="3" placeholder="Adresse complète"></textarea>
                    </div>

                    <div class="personnel-form-row">
                        <div class="personnel-form-group" style="flex: 0 0 200px;">
                            <label class="personnel-label">Code pays</label>
                            <select id="telephone_code_pays" name="telephone_code_pays" class="personnel-input">
                                <option value="+226" selected>🇧🇫 +226</option>
                                <option value="+225">🇨🇮 +225</option>
                                <option value="+221">🇸🇳 +221</option>
                                <option value="+223">🇲🇱 +223</option>
                                <option value="+227">🇳🇪 +227</option>
                                <option value="+228">🇹🇬 +228</option>
                                <option value="+229">🇧🇯 +229</option>
                                <option value="+33">🇫🇷 +33</option>
                            </select>
                        </div>

                        <div class="personnel-form-group" style="flex: 1;">
                            <label class="personnel-label">Téléphone</label>
                            <input type="text" id="telephone" name="telephone" class="personnel-input" placeholder="XX XX XX XX">
                        </div>
                    </div>

                    <div class="personnel-form-group">
                        <label class="personnel-checkbox">
                            <input type="checkbox" id="telephone_whatsapp" name="telephone_whatsapp" value="1">
                            <span>📱 Ce numéro est sur WhatsApp</span>
                        </label>
                    </div>

                    <div class="personnel-form-row">
                        <div class="personnel-form-group">
                            <label class="personnel-label">Numéro d'identification</label>
                            <input type="text" id="numero_identification" name="numero_identification" class="personnel-input" placeholder="CNI, Passeport...">
                        </div>

                        <div class="personnel-form-group">
                            <label class="personnel-label">Photo</label>
                            <input type="file" id="photo" name="photo" class="personnel-input" accept="image/*">
                            <small class="personnel-hint">Max 2 Mo (JPG, PNG)</small>
                        </div>
                    </div>
                </div>

                <!-- ÉTAPE 3: Poste & Contrat -->
                <div class="personnel-step" data-step="3">
                    <h3 class="personnel-step-title">💼 Poste & Contrat</h3>

                    <div class="personnel-form-row">
                        <div class="personnel-form-group">
                            <label class="personnel-label">Poste</label>
                            <input type="text" id="poste" name="poste" class="personnel-input" placeholder="Ex: Développeur, Comptable...">
                        </div>

                        <div class="personnel-form-group">
                            <label class="personnel-label">Date d'embauche</label>
                            <input type="date" id="date_embauche" name="date_embauche" class="personnel-input">
                        </div>
                    </div>

                    <div class="personnel-form-row">
                        <div class="personnel-form-group">
                            <label class="personnel-label">Département</label>
                            <select id="departement_id" name="departement_id" class="personnel-input" onchange="loadServices(this.value)">
                                <option value="">Sélectionner un département</option>
                                @foreach($departements as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="personnel-form-group">
                            <label class="personnel-label">Service</label>
                            <select id="service_id" name="service_id" class="personnel-input" disabled>
                                <option value="">Choisir d'abord un département</option>
                            </select>
                        </div>
                    </div>

                    <div class="personnel-form-group full">
                        <label class="personnel-label required">Type de contrat</label>
                        <div class="personnel-radio-group">
                            <label class="personnel-radio">
                                <input type="radio" name="type_contrat" value="CDI" checked onchange="toggleDateFinContrat()">
                                <span class="personnel-radio-content">
                                    <strong>CDI</strong>
                                    <small>Contrat à Durée Indéterminée</small>
                                </span>
                            </label>
                            <label class="personnel-radio">
                                <input type="radio" name="type_contrat" value="CDD" onchange="toggleDateFinContrat()">
                                <span class="personnel-radio-content">
                                    <strong>CDD</strong>
                                    <small>Contrat à Durée Déterminée</small>
                                </span>
                            </label>
                        </div>
                    </div>

                    <div class="personnel-form-group full" id="dateFinContratGroup" style="display: none;">
                        <label class="personnel-label required">Date de fin de contrat (CDD)</label>
                        <input type="date" id="date_fin_contrat" name="date_fin_contrat" class="personnel-input">
                        <small class="personnel-hint">Obligatoire pour un CDD</small>
                    </div>
                </div>

            </div>

            <!-- Footer avec boutons -->
            <div class="personnel-modal-footer">
                <div class="personnel-footer-left">
                    <button type="button" class="personnel-btn personnel-btn-secondary" id="btnPrev" onclick="prevPersonnelStep()" style="display: none;">
                        ← Précédent
                    </button>
                </div>
                <div class="personnel-footer-right">
                    <button type="button" class="personnel-btn personnel-btn-outline" onclick="closePersonnelModal()">
                        Annuler
                    </button>
                    <button type="button" class="personnel-btn personnel-btn-primary" id="btnNext" onclick="nextPersonnelStep()">
                        Suivant →
                    </button>
                    <button type="submit" class="personnel-btn personnel-btn-success" id="btnSubmit" style="display: none;">
                        ✓ Enregistrer
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
/* ========================================
   MODALE PERSONNEL - STYLES CLEAN
   ======================================== */

/* Overlay */
.personnel-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(4px);
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.personnel-modal-overlay.show {
    display: flex;
}

/* Modal Container */
.personnel-modal {
    background: white;
    border-radius: 16px;
    width: 100%;
    max-width: 800px;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    animation: modalSlideIn 0.3s ease-out;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(30px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* Header */
.personnel-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 24px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px 16px 0 0;
}

.personnel-modal-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: white;
    margin: 0;
}

.personnel-modal-close {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    border-radius: 8px;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
}

.personnel-modal-close:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: rotate(90deg);
}

.personnel-modal-close svg {
    color: white;
}

/* Progress Indicator */
.personnel-progress {
    display: flex;
    align-items: center;
    padding: 24px;
    background: #f8fafc;
    gap: 0;
}

.personnel-progress-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    flex: 0 0 auto;
}

.personnel-progress-number {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #e2e8f0;
    color: #64748b;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1rem;
    transition: all 0.3s;
}

.personnel-progress-step.active .personnel-progress-number {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    transform: scale(1.1);
}

.personnel-progress-step.completed .personnel-progress-number {
    background: #10b981;
    color: white;
}

.personnel-progress-label {
    font-size: 0.75rem;
    color: #64748b;
    font-weight: 600;
}

.personnel-progress-step.active .personnel-progress-label {
    color: #667eea;
}

.personnel-progress-line {
    flex: 1;
    height: 2px;
    background: #e2e8f0;
    margin: 0 12px;
    margin-bottom: 20px;
}

/* Modal Body */
.personnel-modal-body {
    padding: 24px;
    overflow-y: auto;
    flex: 0 0 auto;
    min-height: 300px;
    max-height: 450px;
    height: 450px;
}

.personnel-modal-body::-webkit-scrollbar {
    width: 6px;
}

.personnel-modal-body::-webkit-scrollbar-track {
    background: #f1f5f9;
}

.personnel-modal-body::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

.personnel-modal-body::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Steps */
.personnel-step {
    display: none;
}

.personnel-step.active {
    display: block;
    animation: stepFadeIn 0.3s ease-out;
}

@keyframes stepFadeIn {
    from {
        opacity: 0;
        transform: translateX(20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.personnel-step-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 24px 0;
    padding-bottom: 12px;
    border-bottom: 2px solid #e2e8f0;
}

/* Form Elements */
.personnel-form-group {
    margin-bottom: 20px;
}

.personnel-form-group.full {
    grid-column: 1 / -1;
}

.personnel-form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 20px;
}

.personnel-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: #475569;
    margin-bottom: 8px;
}

.personnel-label.required::after {
    content: '*';
    color: #ef4444;
    margin-left: 4px;
}

.personnel-input {
    width: 100%;
    padding: 10px 14px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.9375rem;
    transition: all 0.2s;
    background: white;
}

.personnel-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.personnel-hint {
    display: block;
    font-size: 0.75rem;
    color: #64748b;
    margin-top: 6px;
}

.personnel-checkbox {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    font-size: 0.9375rem;
    color: #475569;
}

.personnel-checkbox input {
    width: 18px;
    height: 18px;
    cursor: pointer;
}

/* Radio Group */
.personnel-radio-group {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

.personnel-radio {
    display: flex;
    align-items: center;
    padding: 16px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
}

.personnel-radio:hover {
    border-color: #667eea;
    background: #f8fafc;
}

.personnel-radio input {
    margin-right: 12px;
}

.personnel-radio input:checked + .personnel-radio-content {
    color: #667eea;
}

.personnel-radio-content {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.personnel-radio-content strong {
    font-size: 0.9375rem;
    font-weight: 600;
}

.personnel-radio-content small {
    font-size: 0.75rem;
    color: #64748b;
}

/* Footer */
.personnel-modal-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 24px;
    border-top: 2px solid #e2e8f0;
    background: #f8fafc;
    border-radius: 0 0 16px 16px;
}

.personnel-footer-left,
.personnel-footer-right {
    display: flex;
    gap: 12px;
}

/* Buttons */
.personnel-btn {
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 0.9375rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.personnel-btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.personnel-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.personnel-btn-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
}

.personnel-btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
}

.personnel-btn-secondary {
    background: #64748b;
    color: white;
}

.personnel-btn-secondary:hover {
    background: #475569;
}

.personnel-btn-outline {
    background: white;
    color: #64748b;
    border: 2px solid #e2e8f0;
}

.personnel-btn-outline:hover {
    border-color: #cbd5e1;
    background: #f8fafc;
}

/* Responsive */
@media (max-width: 768px) {
    .personnel-form-row {
        grid-template-columns: 1fr;
    }

    .personnel-radio-group {
        grid-template-columns: 1fr;
    }

    .personnel-modal {
        max-height: 95vh;
    }
}
</style>

<script>
// ========================================
// LOGIQUE MODALE PERSONNEL - CLEAN
// ========================================

let currentPersonnelStep = 1;
const totalPersonnelSteps = 3;

// Open modal
function openPersonnelModal() {
    document.getElementById('personnelModal').classList.add('show');
    resetPersonnelForm();
    showPersonnelStep(1);
}

// Close modal
function closePersonnelModal() {
    document.getElementById('personnelModal').classList.remove('show');
}

// Reset form
function resetPersonnelForm() {
    document.getElementById('personnelForm').reset();
    document.getElementById('personnelId').value = '';
    document.getElementById('dateFinContratGroup').style.display = 'none';
}

// Show specific step
function showPersonnelStep(step) {
    currentPersonnelStep = step;

    // Update steps
    document.querySelectorAll('.personnel-step').forEach((el, index) => {
        el.classList.toggle('active', index + 1 === step);
    });

    // Update progress
    document.querySelectorAll('.personnel-progress-step').forEach((el, index) => {
        const stepNum = index + 1;
        el.classList.remove('active', 'completed');
        if (stepNum === step) {
            el.classList.add('active');
        } else if (stepNum < step) {
            el.classList.add('completed');
        }
    });

    // Update buttons
    const btnPrev = document.getElementById('btnPrev');
    const btnNext = document.getElementById('btnNext');
    const btnSubmit = document.getElementById('btnSubmit');

    btnPrev.style.display = step === 1 ? 'none' : 'inline-flex';
    btnNext.style.display = step === totalPersonnelSteps ? 'none' : 'inline-flex';
    btnSubmit.style.display = step === totalPersonnelSteps ? 'inline-flex' : 'none';
}

// Next step
function nextPersonnelStep() {
    if (validatePersonnelStep(currentPersonnelStep)) {
        if (currentPersonnelStep < totalPersonnelSteps) {
            showPersonnelStep(currentPersonnelStep + 1);
        }
    }
}

// Previous step
function prevPersonnelStep() {
    if (currentPersonnelStep > 1) {
        showPersonnelStep(currentPersonnelStep - 1);
    }
}

// Validate current step
function validatePersonnelStep(step) {
    if (step === 1) {
        const nom = document.getElementById('nom').value.trim();
        const prenoms = document.getElementById('prenoms').value.trim();

        if (!nom || !prenoms) {
            alert('Veuillez remplir le nom et le(s) prénom(s)');
            return false;
        }
    }

    return true;
}

// Toggle date fin contrat
function toggleDateFinContrat() {
    const typeContrat = document.querySelector('input[name="type_contrat"]:checked').value;
    const dateFinGroup = document.getElementById('dateFinContratGroup');

    if (typeContrat === 'CDD') {
        dateFinGroup.style.display = 'block';
        document.getElementById('date_fin_contrat').required = true;
    } else {
        dateFinGroup.style.display = 'none';
        document.getElementById('date_fin_contrat').required = false;
        document.getElementById('date_fin_contrat').value = '';
    }
}

// Form submission
document.getElementById('personnelForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    try {
        const response = await fetch('/personnels', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (response.ok) {
            alert('Personnel créé avec succès!');
            closePersonnelModal();
            window.location.reload();
        } else {
            alert('Erreur: ' + (data.message || 'Erreur lors de la création'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Erreur de connexion');
    }
});

// Update open button onclick
document.addEventListener('DOMContentLoaded', function() {
    const btnAdd = document.getElementById('btnAddPersonnel');
    if (btnAdd) {
        btnAdd.onclick = openPersonnelModal;
    }
});
</script>
