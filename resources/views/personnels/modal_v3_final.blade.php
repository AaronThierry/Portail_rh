<!-- MODALE PERSONNEL - VERSION FINALE GARANTIE -->
<style>
#personnelModalV3 input[type="text"],
#personnelModalV3 input[type="date"],
#personnelModalV3 select,
#personnelModalV3 textarea {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    font-size: 0.9375rem;
    transition: all 0.2s;
    background: white;
}

#personnelModalV3 input[type="text"]:focus,
#personnelModalV3 input[type="date"]:focus,
#personnelModalV3 select:focus,
#personnelModalV3 textarea:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

#personnelModalV3 input[type="text"]:hover,
#personnelModalV3 input[type="date"]:hover,
#personnelModalV3 select:hover,
#personnelModalV3 textarea:hover {
    border-color: #cbd5e1;
}
</style>

<div id="personnelModalV3" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); z-index: 99999; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: white; border-radius: 16px; width: 100%; max-width: 900px; max-height: 90vh; display: flex; flex-direction: column; box-shadow: 0 25px 75px rgba(102, 126, 234, 0.4), 0 10px 40px rgba(0,0,0,0.2);">

        <!-- HEADER -->
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 24px 28px; border-radius: 16px 16px 0 0; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);">
            <h2 style="margin: 0; color: white; font-size: 1.375rem; font-weight: 700; letter-spacing: -0.02em;">📋 Nouveau Personnel</h2>
            <button type="button" onclick="closePersonnelModalV3()" style="background: rgba(255,255,255,0.2); border: none; border-radius: 8px; width: 40px; height: 40px; cursor: pointer; color: white; font-size: 24px; font-weight: 300; transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.3)'; this.style.transform='rotate(90deg)';" onmouseout="this.style.background='rgba(255,255,255,0.2)'; this.style.transform='rotate(0)';">×</button>
        </div>

        <!-- PROGRESS -->
        <div style="padding: 20px 24px; background: #f8fafc; display: flex; align-items: center; justify-content: space-between; gap: 12px;">
            <div class="progress-item" data-step="1" style="flex: 1; text-align: center;">
                <div class="progress-num" style="width: 40px; height: 40px; border-radius: 50%; margin: 0 auto 8px; display: flex; align-items: center; justify-content: center; font-weight: 700; background: linear-gradient(135deg, #667eea, #764ba2); color: white;">1</div>
                <div style="font-size: 0.75rem; font-weight: 600; color: #667eea;">Identité</div>
            </div>
            <div style="flex: 1; height: 2px; background: #e2e8f0; margin-bottom: 20px;"></div>
            <div class="progress-item" data-step="2" style="flex: 1; text-align: center;">
                <div class="progress-num" style="width: 40px; height: 40px; border-radius: 50%; margin: 0 auto 8px; display: flex; align-items: center; justify-content: center; font-weight: 700; background: #e2e8f0; color: #64748b;">2</div>
                <div style="font-size: 0.75rem; font-weight: 600; color: #64748b;">Contact</div>
            </div>
            <div style="flex: 1; height: 2px; background: #e2e8f0; margin-bottom: 20px;"></div>
            <div class="progress-item" data-step="3" style="flex: 1; text-align: center;">
                <div class="progress-num" style="width: 40px; height: 40px; border-radius: 50%; margin: 0 auto 8px; display: flex; align-items: center; justify-content: center; font-weight: 700; background: #e2e8f0; color: #64748b;">3</div>
                <div style="font-size: 0.75rem; font-weight: 600; color: #64748b;">Contrat</div>
            </div>
        </div>

        <!-- FORM -->
        <form id="personnelFormV3" enctype="multipart/form-data" style="display: flex; flex-direction: column; flex: 1; min-height: 0;">
            @csrf
            <input type="hidden" name="personnel_id">

            <!-- BODY - ZONE DE SCROLL -->
            <div style="padding: 24px; overflow-y: auto; flex: 1 1 auto; min-height: 300px; max-height: 400px;">

                <!-- ÉTAPE 1 -->
                <div class="form-step" data-step="1">
                    <h3 style="margin: 0 0 24px; font-size: 1.125rem; font-weight: 700; color: #1e293b;">👤 Informations Personnelles</h3>

                    @if(auth()->user()->hasRole('Super Admin'))
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.875rem; color: #475569;">Entreprise <span style="color: #ef4444;">*</span></label>
                        <select name="entreprise_id" required style="width: 100%; padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 0.9375rem; transition: all 0.2s; background: white;" onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)'" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                            <option value="">Sélectionner une entreprise</option>
                            @foreach($entreprises as $entreprise)
                            <option value="{{ $entreprise->id }}" {{ $entreprise->id == auth()->user()->entreprise_id ? 'selected' : '' }}>{{ $entreprise->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    @else
                    <input type="hidden" name="entreprise_id" value="{{ auth()->user()->entreprise_id }}">
                    @endif

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.875rem; color: #475569;">Civilité</label>
                            <select name="civilite" style="width: 100%; padding: 10px 14px; border: 2px solid #e2e8f0; border-radius: 8px;">
                                <option value="">Sélectionner</option>
                                <option value="M.">M.</option>
                                <option value="Mme">Mme</option>
                                <option value="Mlle">Mlle</option>
                                <option value="Dr">Dr</option>
                                <option value="Pr">Pr</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.875rem; color: #475569;">Nom <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="nom" required style="width: 100%; padding: 10px 14px; border: 2px solid #e2e8f0; border-radius: 8px;">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.875rem; color: #475569;">Prénom(s) <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="prenoms" required style="width: 100%; padding: 10px 14px; border: 2px solid #e2e8f0; border-radius: 8px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.875rem; color: #475569;">Sexe</label>
                            <select name="sexe" style="width: 100%; padding: 10px 14px; border: 2px solid #e2e8f0; border-radius: 8px;">
                                <option value="">Sélectionner</option>
                                <option value="M">Masculin</option>
                                <option value="F">Féminin</option>
                            </select>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.875rem; color: #475569;">Matricule</label>
                            <input type="text" name="matricule" placeholder="Laissez vide pour auto" style="width: 100%; padding: 10px 14px; border: 2px solid #e2e8f0; border-radius: 8px;">
                            <small style="color: #64748b; font-size: 0.75rem;">PER{{ date('Y') }}####</small>
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.875rem; color: #475569;">Date de naissance</label>
                            <input type="date" name="date_naissance" style="width: 100%; padding: 10px 14px; border: 2px solid #e2e8f0; border-radius: 8px;">
                        </div>
                    </div>
                </div>

                <!-- ÉTAPE 2 -->
                <div class="form-step" data-step="2" style="display: none;">
                    <h3 style="margin: 0 0 24px; font-size: 1.125rem; font-weight: 700; color: #1e293b;">📞 Coordonnées & Documents</h3>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.875rem; color: #475569;">Adresse</label>
                        <textarea name="adresse" rows="3" style="width: 100%; padding: 10px 14px; border: 2px solid #e2e8f0; border-radius: 8px;"></textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 200px 1fr; gap: 16px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.875rem; color: #475569;">Code pays</label>
                            <select name="telephone_code_pays" style="width: 100%; padding: 10px 14px; border: 2px solid #e2e8f0; border-radius: 8px;">
                                <option value="+226" selected>🇧🇫 +226</option>
                                <option value="+225">🇨🇮 +225</option>
                                <option value="+221">🇸🇳 +221</option>
                                <option value="+33">🇫🇷 +33</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.875rem; color: #475569;">Téléphone</label>
                            <input type="text" name="telephone" style="width: 100%; padding: 10px 14px; border: 2px solid #e2e8f0; border-radius: 8px;">
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="checkbox" name="telephone_whatsapp" value="1" style="width: 18px; height: 18px;">
                            <span style="font-size: 0.9375rem; color: #475569;">📱 Ce numéro est sur WhatsApp</span>
                        </label>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.875rem; color: #475569;">Numéro identification</label>
                            <input type="text" name="numero_identification" style="width: 100%; padding: 10px 14px; border: 2px solid #e2e8f0; border-radius: 8px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.875rem; color: #475569;">Photo</label>
                            <input type="file" name="photo" accept="image/*" style="width: 100%; padding: 10px 14px; border: 2px solid #e2e8f0; border-radius: 8px;">
                        </div>
                    </div>
                </div>

                <!-- ÉTAPE 3 -->
                <div class="form-step" data-step="3" style="display: none;">
                    <h3 style="margin: 0 0 24px; font-size: 1.125rem; font-weight: 700; color: #1e293b;">💼 Poste & Contrat</h3>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.875rem; color: #475569;">Poste</label>
                            <input type="text" name="poste" style="width: 100%; padding: 10px 14px; border: 2px solid #e2e8f0; border-radius: 8px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.875rem; color: #475569;">Date d'embauche</label>
                            <input type="date" name="date_embauche" style="width: 100%; padding: 10px 14px; border: 2px solid #e2e8f0; border-radius: 8px;">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.875rem; color: #475569;">Département</label>
                            <select id="departement_select_v3" name="departement_id" onchange="window.loadServices(this.value)" style="width: 100%; padding: 10px 14px; border: 2px solid #e2e8f0; border-radius: 8px;">
                                <option value="">Sélectionner</option>
                                @foreach($departements as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.875rem; color: #475569;">Service</label>
                            <select id="service_select_v3" name="service_id" disabled style="width: 100%; padding: 10px 14px; border: 2px solid #e2e8f0; border-radius: 8px;">
                                <option value="">Choisir d'abord un département</option>
                            </select>
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 12px; font-weight: 600; font-size: 0.875rem; color: #475569;">Type de contrat <span style="color: #ef4444;">*</span></label>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                            <label style="padding: 16px; border: 2px solid #e2e8f0; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 12px;">
                                <input type="radio" name="type_contrat" value="CDI" checked onchange="toggleCDD()">
                                <div><strong>CDI</strong><br><small style="color: #64748b;">Contrat Indéterminé</small></div>
                            </label>
                            <label style="padding: 16px; border: 2px solid #e2e8f0; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 12px;">
                                <input type="radio" name="type_contrat" value="CDD" onchange="toggleCDD()">
                                <div><strong>CDD</strong><br><small style="color: #64748b;">Contrat Déterminé</small></div>
                            </label>
                        </div>
                    </div>

                    <div id="cddDateGroup" style="display: none;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.875rem; color: #475569;">Date fin contrat (CDD) <span style="color: #ef4444;">*</span></label>
                        <input type="date" name="date_fin_contrat" style="width: 100%; padding: 10px 14px; border: 2px solid #e2e8f0; border-radius: 8px;">
                    </div>
                </div>

            </div>

            <!-- FOOTER - TOUJOURS VISIBLE -->
            <div style="padding: 20px 24px; border-top: 2px solid #e2e8f0; background: #f8fafc; border-radius: 0 0 12px 12px; display: flex; justify-content: space-between; flex-shrink: 0;">
                <button type="button" id="btnPrevV3" onclick="prevStepV3()" style="display: none; padding: 10px 20px; background: #64748b; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">← Précédent</button>
                <div style="display: flex; gap: 12px; margin-left: auto;">
                    <button type="button" onclick="closePersonnelModalV3()" style="padding: 10px 20px; background: white; color: #64748b; border: 2px solid #e2e8f0; border-radius: 8px; font-weight: 600; cursor: pointer;">Annuler</button>
                    <button type="button" id="btnNextV3" onclick="nextStepV3()" style="padding: 10px 20px; background: linear-gradient(135deg, #667eea, #764ba2); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Suivant →</button>
                    <button type="submit" id="btnSubmitV3" style="display: none; padding: 10px 20px; background: linear-gradient(135deg, #10b981, #059669); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">✓ Enregistrer</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
let currentStepV3 = 1;

function openPersonnelModalV3() {
    const modal = document.getElementById('personnelModalV3');
    modal.style.display = 'flex';
    document.getElementById('personnelFormV3').reset();
    showStepV3(1);

    // Apply dark mode based on site theme
    if (document.documentElement.classList.contains('dark')) {
        modal.classList.add('dark-mode');
    }
}

function closePersonnelModalV3() {
    document.getElementById('personnelModalV3').style.display = 'none';
}

function showStepV3(step) {
    currentStepV3 = step;

    // Hide all steps
    document.querySelectorAll('.form-step').forEach(el => el.style.display = 'none');

    // Show current step
    const currentStepEl = document.querySelector(`.form-step[data-step="${step}"]`);
    if (currentStepEl) currentStepEl.style.display = 'block';

    // Update progress
    document.querySelectorAll('.progress-item').forEach((item, idx) => {
        const num = item.querySelector('.progress-num');
        const label = item.nextElementSibling?.nextElementSibling;

        if (idx + 1 === step) {
            num.style.background = 'linear-gradient(135deg, #667eea, #764ba2)';
            num.style.color = 'white';
            item.querySelector('div:last-child').style.color = '#667eea';
        } else if (idx + 1 < step) {
            num.style.background = '#10b981';
            num.style.color = 'white';
        } else {
            num.style.background = '#e2e8f0';
            num.style.color = '#64748b';
            item.querySelector('div:last-child').style.color = '#64748b';
        }
    });

    // Update buttons
    document.getElementById('btnPrevV3').style.display = step === 1 ? 'none' : 'block';
    document.getElementById('btnNextV3').style.display = step === 3 ? 'none' : 'block';
    document.getElementById('btnSubmitV3').style.display = step === 3 ? 'block' : 'none';
}

function nextStepV3() {
    // Validation avant de passer à l'étape suivante
    if (!validateStepV3(currentStepV3)) {
        return false;
    }
    if (currentStepV3 < 3) showStepV3(currentStepV3 + 1);
}

function showError(field, message) {
    // Remove existing error
    const existingError = field.parentElement.querySelector('.field-error');
    if (existingError) existingError.remove();

    // Add error message
    const error = document.createElement('div');
    error.className = 'field-error';
    error.style.cssText = 'color: #ef4444; font-size: 0.875rem; margin-top: 6px; display: flex; align-items: center; gap: 4px;';
    error.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>${message}`;
    field.parentElement.appendChild(error);
    field.style.borderColor = '#ef4444';
    field.focus();
}

function clearError(field) {
    const error = field.parentElement.querySelector('.field-error');
    if (error) error.remove();
    field.style.borderColor = '#e2e8f0';
}

function validateStepV3(step) {
    const form = document.getElementById('personnelFormV3');

    if (step === 1) {
        // Étape 1: Validation Identité
        const nom = form.querySelector('[name="nom"]');
        const prenoms = form.querySelector('[name="prenoms"]');
        let isValid = true;

        // Clear previous errors
        clearError(nom);
        clearError(prenoms);

        if (!nom.value.trim()) {
            showError(nom, 'Le nom est obligatoire');
            isValid = false;
        }

        if (!prenoms.value.trim()) {
            showError(prenoms, 'Le(s) prénom(s) est/sont obligatoire(s)');
            isValid = false;
        }

        return isValid;
    }

    if (step === 2) {
        // Étape 2: Pas de champs obligatoires
        return true;
    }

    if (step === 3) {
        // Étape 3: Validation Type de contrat
        const typeContrat = form.querySelector('input[name="type_contrat"]:checked');

        if (!typeContrat) {
            alert('❌ Veuillez sélectionner un type de contrat');
            return false;
        }

        if (typeContrat.value === 'CDD') {
            const dateFin = form.querySelector('[name="date_fin_contrat"]');
            clearError(dateFin);

            if (!dateFin.value) {
                showError(dateFin, 'La date de fin est obligatoire pour un CDD');
                return false;
            }
        }

        return true;
    }

    return true;
}

function prevStepV3() {
    if (currentStepV3 > 1) showStepV3(currentStepV3 - 1);
}

function toggleCDD() {
    const cdd = document.querySelector('input[name="type_contrat"][value="CDD"]').checked;
    document.getElementById('cddDateGroup').style.display = cdd ? 'block' : 'none';
}

async function loadServices(departementId) {
    const serviceSelect = document.getElementById('service_select_v3');
    if (!serviceSelect) return;

    if (!departementId) {
        serviceSelect.disabled = true;
        serviceSelect.innerHTML = '<option value="">Choisir d\'abord un département</option>';
        return;
    }

    serviceSelect.disabled = true;
    serviceSelect.innerHTML = '<option value="">Chargement...</option>';

    try {
        const response = await fetch(`/api/departements/${departementId}/services`);
        const services = await response.json();

        serviceSelect.innerHTML = '<option value="">Sélectionner un service</option>';
        services.forEach(service => {
            serviceSelect.innerHTML += `<option value="${service.id}">${service.nom}</option>`;
        });
        serviceSelect.disabled = false;
    } catch (error) {
        serviceSelect.innerHTML = '<option value="">Erreur</option>';
        serviceSelect.disabled = true;
    }
}

window.loadServices = loadServices;

// Form submission with improved error handling
document.getElementById('personnelFormV3').addEventListener('submit', async function(e) {
    e.preventDefault();

    // Clear all previous errors
    document.querySelectorAll('.field-error').forEach(e => e.remove());
    document.querySelectorAll('input, select, textarea').forEach(field => {
        field.style.borderColor = '#e2e8f0';
    });

    const formData = new FormData(this);
    const submitBtn = document.getElementById('btnSubmitV3');
    const originalText = submitBtn.textContent;

    // Show loading state
    submitBtn.disabled = true;
    submitBtn.textContent = '⏳ Enregistrement...';
    submitBtn.style.opacity = '0.6';

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
            // Success
            submitBtn.textContent = '✓ Personnel créé!';
            submitBtn.style.background = 'linear-gradient(135deg, #10b981, #059669)';
            submitBtn.style.opacity = '1';

            setTimeout(() => {
                closePersonnelModalV3();
                window.location.reload();
            }, 1000);
        } else {
            // Handle validation errors
            if (data.errors) {
                let firstErrorField = null;

                Object.keys(data.errors).forEach(fieldName => {
                    const field = document.querySelector(`[name="${fieldName}"]`);
                    if (field) {
                        showError(field, data.errors[fieldName][0]);
                        if (!firstErrorField) firstErrorField = field;
                    }
                });

                // Scroll to first error and focus
                if (firstErrorField) {
                    const stepEl = firstErrorField.closest('.form-step');
                    if (stepEl) {
                        const stepNum = parseInt(stepEl.getAttribute('data-step'));
                        showStepV3(stepNum);
                    }
                }

                // Show error notification
                const errorMsg = document.createElement('div');
                errorMsg.style.cssText = 'position: fixed; top: 80px; left: 50%; transform: translateX(-50%); background: linear-gradient(135deg, #ef4444, #dc2626); color: white; padding: 16px 24px; border-radius: 12px; box-shadow: 0 10px 30px rgba(239, 68, 68, 0.3); z-index: 999999; display: flex; align-items: center; gap: 12px; font-weight: 600;';
                errorMsg.innerHTML = `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>Veuillez corriger les erreurs dans le formulaire`;
                document.body.appendChild(errorMsg);
                setTimeout(() => errorMsg.remove(), 4000);

            } else {
                // Generic error
                alert('❌ Erreur: ' + (data.message || 'Erreur lors de la création du personnel'));
            }

            // Reset button
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
            submitBtn.style.opacity = '1';
        }
    } catch (error) {
        console.error('Error:', error);

        // Show network error
        const errorMsg = document.createElement('div');
        errorMsg.style.cssText = 'position: fixed; top: 80px; left: 50%; transform: translateX(-50%); background: linear-gradient(135deg, #ef4444, #dc2626); color: white; padding: 16px 24px; border-radius: 12px; box-shadow: 0 10px 30px rgba(239, 68, 68, 0.3); z-index: 999999; display: flex; align-items: center; gap: 12px; font-weight: 600;';
        errorMsg.innerHTML = `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>Erreur de connexion au serveur`;
        document.body.appendChild(errorMsg);
        setTimeout(() => errorMsg.remove(), 4000);

        // Reset button
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
        submitBtn.style.opacity = '1';
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('btnAddPersonnel');
    if (btn) btn.onclick = openPersonnelModalV3;
});

// Dark Mode Detection for Personnel Modal - Sync with site theme
function applyPersonnelDarkMode() {
    const isDark = document.documentElement.classList.contains('dark');
    const modal = document.getElementById('personnelModalV3');

    if (modal && isDark) {
        modal.classList.add('dark-mode');
    } else if (modal) {
        modal.classList.remove('dark-mode');
    }
}

// Apply on page load
document.addEventListener('DOMContentLoaded', applyPersonnelDarkMode);

// Listen for dark mode changes via MutationObserver
const personnelObserver = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
        if (mutation.attributeName === 'class') {
            applyPersonnelDarkMode();
        }
    });
});

// Observe the <html> element for class changes
personnelObserver.observe(document.documentElement, {
    attributes: true,
    attributeFilter: ['class']
});
</script>

<style>
/* Dark Mode pour Modale Personnel */
#personnelModalV3.dark-mode > div:first-child {
    background: #1f2937 !important;
}

#personnelModalV3.dark-mode > div:first-child > div:first-child {
    /* Header - keep gradient */
}

#personnelModalV3.dark-mode > div:first-child > div:nth-child(2),
#personnelModalV3.dark-mode div[style*="background: #f8fafc"][style*="padding: 20px 24px"] {
    /* Progress bar and footer */
    background: #111827 !important;
}

/* Body/Content area */
#personnelModalV3.dark-mode > div > div:nth-child(3) {
    background: #1f2937 !important;
}

#personnelModalV3.dark-mode input[type="text"],
#personnelModalV3.dark-mode input[type="date"],
#personnelModalV3.dark-mode input[type="file"],
#personnelModalV3.dark-mode select,
#personnelModalV3.dark-mode textarea,
#personnelModalV3.dark-mode input[type="radio"] + label,
#personnelModalV3.dark-mode label[style*="border: 2px solid #e2e8f0"] {
    background: #111827 !important;
    border-color: #374151 !important;
    color: #f9fafb !important;
}

#personnelModalV3.dark-mode input[type="text"]:hover,
#personnelModalV3.dark-mode input[type="date"]:hover,
#personnelModalV3.dark-mode select:hover,
#personnelModalV3.dark-mode textarea:hover,
#personnelModalV3.dark-mode label[style*="border: 2px solid #e2e8f0"]:hover {
    border-color: #4b5563 !important;
}

#personnelModalV3.dark-mode input[type="text"]:focus,
#personnelModalV3.dark-mode input[type="date"]:focus,
#personnelModalV3.dark-mode select:focus,
#personnelModalV3.dark-mode textarea:focus {
    border-color: #667eea !important;
    background: #1f2937 !important;
}

#personnelModalV3.dark-mode label {
    color: #d1d5db !important;
}

#personnelModalV3.dark-mode small {
    color: #9ca3af !important;
}

#personnelModalV3.dark-mode .form-step {
    background: transparent !important;
}

#personnelModalV3.dark-mode .form-step > div {
    background: transparent !important;
}

#personnelModalV3.dark-mode h3 {
    color: #f9fafb !important;
}

#personnelModalV3.dark-mode h2 {
    color: #f9fafb !important;
}

#personnelModalV3.dark-mode p {
    color: #9ca3af !important;
}

/* Footer buttons area */
#personnelModalV3.dark-mode > div:first-child > form > div:last-child,
#personnelModalV3.dark-mode div[style*="background: #f8fafc"] {
    background: #111827 !important;
    border-top-color: #374151 !important;
}

/* Button "Annuler" - white background button */
#personnelModalV3.dark-mode button[style*="background: white"] {
    background: #374151 !important;
    color: #d1d5db !important;
    border-color: #4b5563 !important;
}

#personnelModalV3.dark-mode button[style*="background: white"]:hover {
    background: #4b5563 !important;
}

/* Button "Précédent" - gray background button */
#personnelModalV3.dark-mode button[style*="background: #64748b"] {
    background: #374151 !important;
    color: #d1d5db !important;
}

#personnelModalV3.dark-mode button[style*="background: #64748b"]:hover {
    background: #4b5563 !important;
}

/* Progress indicators */
#personnelModalV3.dark-mode .progress-num {
    background: #374151 !important;
    color: #9ca3af !important;
}

#personnelModalV3.dark-mode .progress-item[data-step="1"] .progress-num {
    background: linear-gradient(135deg, #667eea, #764ba2) !important;
    color: white !important;
}

#personnelModalV3.dark-mode .progress-item div:last-child {
    color: #6b7280 !important;
}

#personnelModalV3.dark-mode .progress-item[data-step="1"] div:last-child {
    color: #818cf8 !important;
}

/* Lignes de séparation de la barre de progression */
#personnelModalV3.dark-mode div[style*="height: 2px; background: #e2e8f0"] {
    background: #374151 !important;
}

/* Strong elements */
#personnelModalV3.dark-mode strong {
    color: #f9fafb !important;
}

/* Span elements dans les labels */
#personnelModalV3.dark-mode span[style*="color: #ef4444"] {
    color: #ef4444 !important;
}

#personnelModalV3.dark-mode span[style*="color: #475569"] {
    color: #d1d5db !important;
}

#personnelModalV3.dark-mode span[style*="color: #64748b"] {
    color: #9ca3af !important;
}
</style>
