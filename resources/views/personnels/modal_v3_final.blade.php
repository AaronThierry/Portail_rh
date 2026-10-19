{{-- Fenêtre « Nouveau personnel » — un seul formulaire, pas d'assistant par étapes --}}
<div class="rh-sheet" id="personnelModalV3" role="dialog" aria-modal="true" aria-labelledby="pmTitre">
    <div class="rh-sheet-box">
        <div class="rh-sheet-grip"></div>
        <div class="rh-sheet-head">
            <div>
                <h2 id="pmTitre">Nouveau personnel</h2>
                <p>Enregistrer un nouvel employé dans le système.</p>
            </div>
            <button type="button" class="rh-iconbtn" onclick="closePersonnelModalV3()" aria-label="Fermer">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg>
            </button>
        </div>

        <form id="personnelFormV3" enctype="multipart/form-data" class="rh-form">
            @csrf

            <div id="pm_alert_banner" class="rh-alert err" role="alert" style="display:none"></div>

            @if(auth()->user()->hasRole('Super Admin'))
                <div class="rh-field">
                    <label for="pm_entreprise">Entreprise</label>
                    <select name="entreprise_id" id="pm_entreprise" class="rh-select" required>
                        <option value="">— Sélectionner —</option>
                        @foreach($entreprises as $entreprise)
                            <option value="{{ $entreprise->id }}">{{ $entreprise->nom }}</option>
                        @endforeach
                    </select>
                </div>
            @else
                <input type="hidden" name="entreprise_id" value="{{ auth()->user()->entreprise_id }}">
            @endif

            <div class="rh-grid2">
                <div class="rh-field">
                    <label for="pm_civilite">Civilité</label>
                    <select name="civilite" id="pm_civilite" class="rh-select">
                        <option value="">—</option>
                        <option value="M.">M.</option>
                        <option value="Mme">Mme</option>
                        <option value="Mlle">Mlle</option>
                        <option value="Dr">Dr</option>
                        <option value="Pr">Pr</option>
                    </select>
                </div>
                <div class="rh-field">
                    <label for="pm_sexe">Sexe</label>
                    <select name="sexe" id="pm_sexe" class="rh-select">
                        <option value="">—</option>
                        <option value="M">Masculin</option>
                        <option value="F">Féminin</option>
                    </select>
                </div>
                <div class="rh-field">
                    <label for="pm_nom">Nom</label>
                    <input type="text" name="nom" id="pm_nom" class="rh-input" placeholder="Nom de famille" required>
                </div>
                <div class="rh-field">
                    <label for="pm_prenoms">Prénom(s)</label>
                    <input type="text" name="prenoms" id="pm_prenoms" class="rh-input" placeholder="Prénom(s)" required>
                </div>
                <div class="rh-field">
                    <label for="pm_matricule">Matricule <span class="rh-opt">(auto si vide)</span></label>
                    <input type="text" name="matricule" id="pm_matricule" class="rh-input" placeholder="Laissez vide pour générer automatiquement">
                </div>
                <div class="rh-field">
                    <label for="pm_date_naissance">Date de naissance</label>
                    <input type="date" name="date_naissance" id="pm_date_naissance" class="rh-input">
                </div>
            </div>

            <div class="rh-grid2">
                <div class="rh-field">
                    <label for="pm_code_pays">Code pays</label>
                    <select name="telephone_code_pays" id="pm_code_pays" class="rh-select">
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
                <div class="rh-field">
                    <label for="pm_telephone">Téléphone</label>
                    <input type="tel" name="telephone" id="pm_telephone" class="rh-input" placeholder="XX XX XX XX">
                </div>
            </div>
            <div class="rh-field">
                <label style="display:flex; align-items:center; gap:10px; font-weight:400; cursor:pointer">
                    <input type="checkbox" name="telephone_whatsapp" value="1">
                    <span>Ce numéro est disponible sur WhatsApp</span>
                </label>
            </div>
            <div class="rh-field">
                <label for="pm_adresse">Adresse</label>
                <textarea name="adresse" id="pm_adresse" class="rh-textarea" rows="2" placeholder="Adresse complète"></textarea>
            </div>

            <div class="rh-grid2">
                <div class="rh-field">
                    <label for="pm_numero_id">Numéro d'identification</label>
                    <input type="text" name="numero_identification" id="pm_numero_id" class="rh-input" placeholder="CNI, Passeport, etc.">
                </div>
                <div class="rh-field">
                    <label for="pm_police">Numéro de police</label>
                    <input type="text" name="police" id="pm_police" class="rh-input" placeholder="N° de police" required>
                </div>
            </div>
            <div class="rh-field">
                <label for="pm_photo">Photo <span class="rh-opt">(JPG/PNG, max 2 Mo)</span></label>
                <input type="file" name="photo" id="pm_photo" class="rh-input" accept="image/*">
            </div>

            <div class="rh-grid2">
                <div class="rh-field">
                    <label for="pm_poste">Poste</label>
                    <input type="text" name="poste" id="pm_poste" class="rh-input" placeholder="Ex. Développeur, Comptable…">
                </div>
                <div class="rh-field">
                    <label for="pm_date_embauche">Date d'embauche</label>
                    <input type="date" name="date_embauche" id="pm_date_embauche" class="rh-input">
                </div>
            </div>
            <div class="rh-grid2">
                <div class="rh-field">
                    <label for="pm_type_contrat">Type de contrat</label>
                    <select name="type_contrat" id="pm_type_contrat" class="rh-select">
                        <option value="CDI" selected>CDI — Durée indéterminée</option>
                        <option value="CDD">CDD — Durée déterminée</option>
                    </select>
                </div>
                <div class="rh-field" id="pm_cdd_group" style="display:none">
                    <label for="pm_date_fin_contrat">Date de fin de contrat</label>
                    <input type="date" name="date_fin_contrat" id="pm_date_fin_contrat" class="rh-input">
                </div>
            </div>

            <div class="rh-sheet-foot">
                <button type="button" class="rh-btn soft" onclick="closePersonnelModalV3()">Annuler</button>
                <button type="submit" class="rh-btn" id="pm_btn_submit">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<script>
function openPersonnelModalV3() {
    document.getElementById('personnelModalV3').classList.add('open');
    document.body.style.overflow = 'hidden';
    resetFormV3();
}
function closePersonnelModalV3() {
    document.getElementById('personnelModalV3').classList.remove('open');
    document.body.style.overflow = '';
}
function resetFormV3() {
    document.getElementById('personnelFormV3').reset();
    clearErrorsV3();
    clearModalAlert();
    document.getElementById('pm_cdd_group').style.display = 'none';
}
function clearErrorsV3() {
    document.querySelectorAll('.pm-field-err').forEach(e => e.remove());
}
function showFieldError(field, message) {
    if (!field) return;
    const err = document.createElement('p');
    err.className = 'rh-err pm-field-err';
    err.textContent = message;
    field.insertAdjacentElement('afterend', err);
}
function showModalAlert(html) {
    const banner = document.getElementById('pm_alert_banner');
    banner.innerHTML = html;
    banner.style.display = 'flex';
    banner.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}
function clearModalAlert() {
    const banner = document.getElementById('pm_alert_banner');
    banner.style.display = 'none';
    banner.innerHTML = '';
}

document.getElementById('pm_type_contrat').addEventListener('change', function () {
    document.getElementById('pm_cdd_group').style.display = this.value === 'CDD' ? 'block' : 'none';
    document.getElementById('pm_date_fin_contrat').required = this.value === 'CDD';
});

document.getElementById('personnelFormV3').addEventListener('submit', async function (e) {
    e.preventDefault();
    clearErrorsV3();
    clearModalAlert();

    const formData = new FormData(this);
    const submitBtn = document.getElementById('pm_btn_submit');
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.textContent = 'Enregistrement…';

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
            const nomComplet = ((data.data?.prenoms ?? '') + ' ' + (data.data?.nom ?? '')).trim();
            sessionStorage.setItem('personnel_flash', JSON.stringify({
                type: 'success',
                message: 'Personnel' + (nomComplet ? ' ' + nomComplet : '') + ' enregistré avec succès.'
            }));
            closePersonnelModalV3();
            window.location.reload();
        } else if (data.errors) {
            const lines = [];
            Object.keys(data.errors).forEach(fieldName => {
                const field = document.querySelector(`[name="${fieldName}"]`);
                const msg = data.errors[fieldName][0];
                lines.push('<li>' + msg + '</li>');
                showFieldError(field, msg);
            });
            showModalAlert('<span><strong>Veuillez corriger :</strong><ul style="margin:6px 0 0; padding-left:18px">' + lines.join('') + '</ul></span>');
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        } else {
            showModalAlert('<span>' + (data.message || "Une erreur est survenue lors de l'enregistrement.") + '</span>');
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    } catch (error) {
        showModalAlert('<span>Impossible de joindre le serveur. Vérifiez votre connexion et réessayez.</span>');
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('btnAddPersonnel');
    if (btn) btn.onclick = openPersonnelModalV3;
});
</script>
