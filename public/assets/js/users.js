/**
 * Users Management JavaScript
 * Gestion des utilisateurs avec modales
 */

// Configuration
const USERS_CONFIG = {
    API_BASE: '/utilisateurs',
    SEARCH_DELAY: 300
};

// Elements
const elements = {
    modal: document.getElementById('userModal'),
    modalTitle: document.getElementById('modalTitle'),
    userForm: document.getElementById('userForm'),
    userId: document.getElementById('userId'),
    btnAddUser: document.getElementById('btnAddUser'),
    btnSubmit: document.getElementById('btnSubmit'),
    btnSubmitText: document.getElementById('btnSubmitText'),
    passwordLabel: document.getElementById('passwordLabel'),
    searchInput: document.getElementById('searchInput'),
    usersTableBody: document.getElementById('usersTableBody')
};

// CSRF Token
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

// Modal Management
function openModal(mode = 'add', userId = null) {
    console.log('🎯 openModal appelée - mode:', mode, '- userId:', userId);
    console.log('📋 Modal element exists?', !!elements.modal);

    if (mode === 'add') {
        elements.modalTitle.textContent = 'Créer un Compte Utilisateur';
        elements.btnSubmitText.textContent = 'Créer le compte';
        resetForm();
    } else {
        elements.modalTitle.textContent = 'Modifier un utilisateur';
        elements.btnSubmitText.textContent = 'Enregistrer';
        if (userId) {
            loadUserData(userId);
        }
    }

    if (elements.modal) {
        elements.modal.classList.add('show');
        document.body.style.overflow = 'hidden';

        // Apply dark mode based on site theme
        const modalUser = elements.modal.querySelector('.modal-user');
        if (modalUser && document.documentElement.classList.contains('dark')) {
            modalUser.classList.add('dark-mode');
        }

        console.log('✅ Modal affichée');
    } else {
        console.error('❌ Modal element not found!');
    }
}

function closeModal() {
    elements.modal.classList.remove('show');
    document.body.style.overflow = '';
    setTimeout(() => resetForm(), 300);
}

function resetForm() {
    elements.userForm.reset();
    elements.userId.value = '';
    clearErrors();
}

// Error Handling
function clearErrors() {
    document.querySelectorAll('.form-error').forEach(error => {
        error.classList.remove('show');
        error.textContent = '';
    });
    document.querySelectorAll('.form-group').forEach(group => {
        group.classList.remove('error');
    });
}

function showError(fieldName, message) {
    const errorElement = document.getElementById(`error${fieldName.charAt(0).toUpperCase() + fieldName.slice(1)}`);
    const inputElement = document.getElementById(`user${fieldName.charAt(0).toUpperCase() + fieldName.slice(1)}`);

    if (errorElement && inputElement) {
        errorElement.textContent = message;
        errorElement.classList.add('show');
        inputElement.closest('.form-group').classList.add('error');
    }
}

// Load User Data for Editing
async function loadUserData(userId) {
    try {
        showLoading(true);

        const response = await fetch(`${USERS_CONFIG.API_BASE}/${userId}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (response.ok) {
            // Fill form with user data
            elements.userId.value = data.user.id;
            document.getElementById('userName').value = data.user.name || '';
            document.getElementById('userEmail').value = data.user.email || '';
            document.getElementById('userPhone').value = data.user.phone || '';
            document.getElementById('userRole').value = data.user.role || '';
            document.getElementById('userDepartment').value = data.user.department || '';
            document.getElementById('userStatus').value = data.user.status || 'active';
        } else {
            showNotification(data.message || 'Erreur lors du chargement des données', 'error');
            closeModal();
        }
    } catch (error) {
        console.error('Load user error:', error);
        showNotification('Erreur de connexion au serveur', 'error');
        closeModal();
    } finally {
        showLoading(false);
    }
}

// Form Submission
async function handleFormSubmit(e) {
    e.preventDefault();
    clearErrors();

    const userId = elements.userId.value;
    const isEdit = userId !== '';
    const formData = new FormData(elements.userForm);

    // Convertir FormData en objet - Inclure l'email du formulaire
    const data = {
        personnel_id: formData.get('personnel_id'),
        email: formData.get('email'),
        role: formData.get('role'),
        status: formData.get('status')
    };

    // Valider que les champs requis sont présents
    if (!data.personnel_id || !data.email || !data.role || !data.status) {
        showNotification('Veuillez remplir tous les champs requis', 'error');
        showLoading(false);
        return;
    }

    // Validation format email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(data.email)) {
        showNotification('Format d\'email invalide', 'error');
        showLoading(false);
        return;
    }

    console.log('📤 Envoi des données:', data);

    try {
        showLoading(true);

        const url = isEdit
            ? `${USERS_CONFIG.API_BASE}/${userId}`
            : `${USERS_CONFIG.API_BASE}`;

        const method = isEdit ? 'PUT' : 'POST';

        console.log('🌐 URL:', url);
        console.log('📋 Méthode:', method);

        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
        });

        console.log('📊 Response status:', response.status);
        const result = await response.json();
        console.log('📦 Response data:', result);

        if (response.ok && result.success) {
            showNotification(result.message || 'Utilisateur enregistré avec succès', 'success');
            closeModal();
            // Recharger la page pour voir les changements
            setTimeout(() => window.location.reload(), 1000);
        } else if (response.status === 422) {
            // Erreurs de validation
            if (result.errors) {
                let errorMessage = 'Erreurs de validation:\n';
                Object.keys(result.errors).forEach(field => {
                    const messages = Array.isArray(result.errors[field])
                        ? result.errors[field].join(', ')
                        : result.errors[field];
                    errorMessage += `\n• ${field}: ${messages}`;
                });
                showNotification(errorMessage, 'error');
            } else {
                showNotification(result.message || 'Erreur de validation', 'error');
            }
        } else if (response.status === 403) {
            showNotification('Vous n\'avez pas la permission de créer des utilisateurs', 'error');
        } else {
            showNotification(result.message || 'Une erreur est survenue', 'error');
        }
    } catch (error) {
        console.error('❌ Form submit error:', error);
        showNotification('Erreur de connexion au serveur: ' + error.message, 'error');
    } finally {
        showLoading(false);
    }
}

// Delete User
async function deleteUser(userId) {
    if (!confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
        return;
    }

    try {
        showLoading(true);

        const response = await fetch(`${USERS_CONFIG.API_BASE}/${userId}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const result = await response.json();

        if (response.ok) {
            showNotification(result.message || 'Utilisateur supprimé avec succès', 'success');
            // Recharger la page
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showNotification(result.message || 'Erreur lors de la suppression', 'error');
        }
    } catch (error) {
        console.error('Delete error:', error);
        showNotification('Erreur de connexion au serveur', 'error');
    } finally {
        showLoading(false);
    }
}

// Edit User
function editUser(userId) {
    openModal('edit', userId);
}

// Search Functionality
let searchTimeout;
function handleSearch(query) {
    clearTimeout(searchTimeout);

    searchTimeout = setTimeout(() => {
        const rows = elements.usersTableBody.querySelectorAll('tr');
        const searchLower = query.toLowerCase();

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchLower)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }, USERS_CONFIG.SEARCH_DELAY);
}

// Loading State
function showLoading(isLoading) {
    if (isLoading) {
        elements.btnSubmit.disabled = true;
        elements.btnSubmit.style.opacity = '0.6';
        elements.btnSubmit.style.cursor = 'not-allowed';
    } else {
        elements.btnSubmit.disabled = false;
        elements.btnSubmit.style.opacity = '1';
        elements.btnSubmit.style.cursor = 'pointer';
    }
}

// Notification System
function showNotification(message, type = 'info') {
    // Créer l'élément de notification
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.style.cssText = `
        position: fixed;
        top: 24px;
        right: 24px;
        padding: 16px 24px;
        background: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6'};
        color: white;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        z-index: 3000;
        font-weight: 600;
        animation: slideIn 0.3s ease-out;
        max-width: 400px;
    `;
    notification.textContent = message;

    document.body.appendChild(notification);

    // Supprimer après 3 secondes
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Event Listeners
function initEventListeners() {
    // Bouton ajouter
    if (elements.btnAddUser) {
        elements.btnAddUser.addEventListener('click', () => openModal('add'));
    }

    // Formulaire
    if (elements.userForm) {
        elements.userForm.addEventListener('submit', handleFormSubmit);
    }

    // Recherche
    if (elements.searchInput) {
        elements.searchInput.addEventListener('input', (e) => handleSearch(e.target.value));
    }

    // Boutons de fermeture de modal
    document.querySelectorAll('[data-modal-close]').forEach(btn => {
        btn.addEventListener('click', closeModal);
    });

    // Fermer modal avec Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && elements.modal && elements.modal.classList.contains('show')) {
            closeModal();
        }
    });

    // Fermer modal en cliquant sur l'overlay
    if (elements.modal) {
        elements.modal.addEventListener('click', (e) => {
            if (e.target === elements.modal) {
                closeModal();
            }
        });
    }
}

// Animations CSS
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// ==========================================
// WIZARD NAVIGATION
// ==========================================
let currentStep = 1;
const totalSteps = 3;

function showStep(stepNumber) {
    // Hide all steps
    document.querySelectorAll('.wizard-step').forEach(step => {
        step.classList.remove('active');
    });

    // Show current step
    const currentStepEl = document.querySelector(`.wizard-step[data-step="${stepNumber}"]`);
    if (currentStepEl) {
        currentStepEl.classList.add('active');
    }

    // Update progress steps
    document.querySelectorAll('.step-item').forEach((item, index) => {
        const stepNum = index + 1;
        item.classList.remove('active', 'completed');

        if (stepNum === stepNumber) {
            item.classList.add('active');
        } else if (stepNum < stepNumber) {
            item.classList.add('completed');
        }
    });

    // Update navigation buttons
    const btnPrev = document.getElementById('btnPrev');
    const btnNext = document.getElementById('btnNext');
    const btnSubmit = document.getElementById('btnSubmit');

    if (btnPrev) {
        btnPrev.style.display = stepNumber === 1 ? 'none' : 'flex';
    }

    if (btnNext && btnSubmit) {
        if (stepNumber === totalSteps) {
            btnNext.style.display = 'none';
            btnSubmit.style.display = 'flex';
        } else {
            btnNext.style.display = 'flex';
            btnSubmit.style.display = 'none';
        }
    }

    currentStep = stepNumber;
}

function nextStep() {
    if (validateCurrentStep()) {
        if (currentStep < totalSteps) {
            showStep(currentStep + 1);
        }
    }
}

function prevStep() {
    if (currentStep > 1) {
        showStep(currentStep - 1);
    }
}

function validateCurrentStep() {
    if (currentStep === 1) {
        // Validate employee selection
        const personnelSelect = document.getElementById('personnel_id');
        if (!personnelSelect || !personnelSelect.value) {
            showNotification('Veuillez sélectionner un employé', 'error');
            return false;
        }
        return true;
    }

    if (currentStep === 2) {
        // Validate email
        const emailInput = document.getElementById('userEmail');
        if (!emailInput || !emailInput.value) {
            showNotification('Veuillez saisir une adresse email', 'error');
            return false;
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailInput.value)) {
            showNotification('Format d\'email invalide', 'error');
            return false;
        }

        return true;
    }

    if (currentStep === 3) {
        // Validate role and status
        const roleSelect = document.getElementById('userRole');
        const statusSelect = document.getElementById('userStatus');

        if (!roleSelect || !roleSelect.value) {
            showNotification('Veuillez sélectionner un rôle', 'error');
            return false;
        }

        if (!statusSelect || !statusSelect.value) {
            showNotification('Veuillez sélectionner un statut', 'error');
            return false;
        }

        return true;
    }

    return true;
}

// ==========================================
// EMAIL VALIDATION IN REAL-TIME
// ==========================================
function validateEmailRealTime() {
    const emailInput = document.getElementById('userEmail');
    const emailFeedback = document.getElementById('emailFeedback');
    const emailValidIcon = document.getElementById('emailValidIcon');

    if (!emailInput) return;

    emailInput.addEventListener('input', function() {
        const email = this.value;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!email) {
            emailFeedback.textContent = '';
            emailFeedback.className = 'email-feedback';
            emailValidIcon.style.display = 'none';
            return;
        }

        if (emailRegex.test(email)) {
            emailFeedback.textContent = '✓ Format valide';
            emailFeedback.className = 'email-feedback valid';
            emailValidIcon.style.display = 'flex';
            this.style.borderColor = '#10b981';
        } else {
            emailFeedback.textContent = '✗ Format invalide (exemple: nom@entreprise.com)';
            emailFeedback.className = 'email-feedback invalid';
            emailValidIcon.style.display = 'none';
            this.style.borderColor = '#ef4444';
        }
    });

    emailInput.addEventListener('blur', function() {
        if (this.value && this.style.borderColor !== 'rgb(16, 185, 129)') {
            this.style.borderColor = '#ef4444';
        } else if (this.value) {
            this.style.borderColor = '#10b981';
        }
    });

    emailInput.addEventListener('focus', function() {
        if (this.value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            this.style.borderColor = emailRegex.test(this.value) ? '#10b981' : '#ef4444';
        }
    });
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    console.log('🚀 Initializing users management...');
    console.log('📋 Modal element:', elements.modal);
    console.log('🔘 Add user button:', elements.btnAddUser);
    console.log('📝 User form:', elements.userForm);

    initEventListeners();

    // Initialize wizard navigation
    const btnNext = document.getElementById('btnNext');
    const btnPrev = document.getElementById('btnPrev');

    if (btnNext) {
        btnNext.addEventListener('click', nextStep);
    }

    if (btnPrev) {
        btnPrev.addEventListener('click', prevStep);
    }

    // Initialize email validation
    validateEmailRealTime();

    // Initialize wizard to step 1
    showStep(1);

    console.log('✅ Users management initialized');
});

// Expose functions globally for inline onclick handlers
window.openModal = openModal;
window.closeModal = closeModal;
window.editUser = editUser;
window.deleteUser = deleteUser;
