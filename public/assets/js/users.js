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
    if (mode === 'add') {
        elements.modalTitle.textContent = 'Ajouter un utilisateur';
        elements.btnSubmitText.textContent = 'Ajouter';
        elements.passwordLabel.classList.add('required');
        document.getElementById('userPassword').required = true;
        resetForm();
    } else {
        elements.modalTitle.textContent = 'Modifier un utilisateur';
        elements.btnSubmitText.textContent = 'Enregistrer';
        elements.passwordLabel.classList.remove('required');
        document.getElementById('userPassword').required = false;
        document.getElementById('userPassword').placeholder = 'Laisser vide pour ne pas changer';
        if (userId) {
            loadUserData(userId);
        }
    }
    elements.modal.classList.add('show');
    document.body.style.overflow = 'hidden';
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

    // Convertir FormData en objet
    const data = {};
    formData.forEach((value, key) => {
        if (key !== 'user_id') {
            data[key] = value;
        }
    });

    // Ne pas envoyer le mot de passe s'il est vide en mode édition
    if (isEdit && !data.password) {
        delete data.password;
    }

    try {
        showLoading(true);

        const url = isEdit
            ? `${USERS_CONFIG.API_BASE}/${userId}`
            : `${USERS_CONFIG.API_BASE}`;

        const method = isEdit ? 'PUT' : 'POST';

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

        const result = await response.json();

        if (response.ok) {
            showNotification(result.message || 'Utilisateur enregistré avec succès', 'success');
            closeModal();
            // Recharger la page pour voir les changements
            setTimeout(() => window.location.reload(), 1000);
        } else if (response.status === 422) {
            // Erreurs de validation
            if (result.errors) {
                Object.keys(result.errors).forEach(field => {
                    showError(field, result.errors[field][0]);
                });
            } else {
                showNotification(result.message || 'Erreur de validation', 'error');
            }
        } else {
            showNotification(result.message || 'Une erreur est survenue', 'error');
        }
    } catch (error) {
        console.error('Form submit error:', error);
        showNotification('Erreur de connexion au serveur', 'error');
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

    // Fermer modal avec Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && elements.modal.classList.contains('show')) {
            closeModal();
        }
    });

    // Fermer modal en cliquant sur l'overlay
    elements.modal?.addEventListener('click', (e) => {
        if (e.target === elements.modal) {
            closeModal();
        }
    });
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

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    initEventListeners();
    console.log('✅ Users management initialized');
});

// Expose functions globally for inline onclick handlers
window.editUser = editUser;
window.deleteUser = deleteUser;
window.closeModal = closeModal;
