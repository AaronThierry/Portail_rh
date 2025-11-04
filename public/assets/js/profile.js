/**
 * Profile Page JavaScript
 * Gestion du profil utilisateur
 */

// Elements
const elements = {
    avatarInput: document.getElementById('avatarInput'),
    avatarPreview: document.getElementById('avatarPreview'),
    profileForm: document.getElementById('profileForm'),
    passwordForm: document.getElementById('passwordForm'),
    newPassword: document.getElementById('new_password'),
    passwordStrength: document.getElementById('passwordStrength'),
    passwordStrengthBar: document.getElementById('passwordStrengthBar'),
    passwordStrengthText: document.getElementById('passwordStrengthText')
};

/**
 * Avatar Preview and Upload
 */
function initAvatarPreview() {
    if (elements.avatarInput && elements.avatarPreview) {
        elements.avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Vérifier le type de fichier
                if (!file.type.match('image.*')) {
                    showNotification('Veuillez sélectionner une image valide', 'error');
                    return;
                }

                // Vérifier la taille (max 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    showNotification('L\'image ne doit pas dépasser 2MB', 'error');
                    return;
                }

                // Afficher l'aperçu
                const reader = new FileReader();
                reader.onload = function(e) {
                    elements.avatarPreview.src = e.target.result;
                };
                reader.readAsDataURL(file);

                // Upload l'image au serveur
                uploadAvatar(file);
            }
        });
    }
}

/**
 * Upload Avatar to Server
 */
async function uploadAvatar(file) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const formData = new FormData();
    formData.append('avatar', file);

    try {
        showNotification('Upload en cours...', 'info');

        const response = await fetch('/profile/avatar', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        });

        const data = await response.json();

        if (response.ok) {
            showNotification(data.message || 'Photo de profil mise à jour avec succès', 'success');

            // Mettre à jour toutes les images de profil sur la page
            if (data.avatar_url) {
                elements.avatarPreview.src = data.avatar_url;

                // Mettre à jour l'avatar dans le header si présent
                const headerAvatar = document.querySelector('.user-avatar');
                if (headerAvatar) {
                    headerAvatar.src = data.avatar_url;
                }

                const headerAvatarLarge = document.querySelector('.user-avatar-large');
                if (headerAvatarLarge) {
                    headerAvatarLarge.src = data.avatar_url;
                }
            }

            // Recharger la page après 1 seconde pour voir les changements partout
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else if (response.status === 422) {
            // Erreurs de validation
            if (data.errors && data.errors.avatar) {
                showNotification(data.errors.avatar[0], 'error');
            } else {
                showNotification(data.message || 'Erreur de validation', 'error');
            }
        } else {
            showNotification(data.message || 'Erreur lors de l\'upload', 'error');
        }
    } catch (error) {
        console.error('Upload error:', error);
        showNotification('Erreur de connexion au serveur', 'error');
    }
}

/**
 * Password Strength Checker
 */
function checkPasswordStrength(password) {
    let strength = 0;
    let feedback = '';

    if (password.length === 0) {
        elements.passwordStrength.classList.remove('show');
        return;
    }

    elements.passwordStrength.classList.add('show');

    // Critères de force
    if (password.length >= 6) strength++;
    if (password.length >= 10) strength++;
    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
    if (/\d/.test(password)) strength++;
    if (/[^a-zA-Z0-9]/.test(password)) strength++;

    // Déterminer le niveau et la couleur
    elements.passwordStrengthBar.className = 'password-strength-bar';
    elements.passwordStrengthText.className = 'password-strength-text';

    if (strength <= 2) {
        elements.passwordStrengthBar.classList.add('weak');
        elements.passwordStrengthText.textContent = 'Faible';
        elements.passwordStrengthText.style.color = 'var(--danger)';
    } else if (strength <= 4) {
        elements.passwordStrengthBar.classList.add('medium');
        elements.passwordStrengthText.textContent = 'Moyen';
        elements.passwordStrengthText.style.color = 'var(--warning)';
    } else {
        elements.passwordStrengthBar.classList.add('strong');
        elements.passwordStrengthText.textContent = 'Fort';
        elements.passwordStrengthText.style.color = 'var(--success)';
    }
}

/**
 * Password Form Validation
 */
function validatePasswordForm() {
    let isValid = true;

    // Reset errors
    clearErrors();

    const currentPassword = document.getElementById('current_password').value;
    const newPassword = elements.newPassword.value;
    const confirmPassword = document.getElementById('new_password_confirmation').value;

    // Vérifier que tous les champs sont remplis
    if (!currentPassword) {
        showFieldError('current_password', 'Le mot de passe actuel est requis');
        isValid = false;
    }

    if (!newPassword) {
        showFieldError('new_password', 'Le nouveau mot de passe est requis');
        isValid = false;
    } else if (newPassword.length < 6) {
        showFieldError('new_password', 'Le mot de passe doit contenir au moins 6 caractères');
        isValid = false;
    }

    if (!confirmPassword) {
        showFieldError('new_password_confirmation', 'La confirmation est requise');
        isValid = false;
    } else if (newPassword !== confirmPassword) {
        showFieldError('new_password_confirmation', 'Les mots de passe ne correspondent pas');
        isValid = false;
    }

    // Vérifier que le nouveau mot de passe est différent de l'ancien
    if (currentPassword && newPassword && currentPassword === newPassword) {
        showFieldError('new_password', 'Le nouveau mot de passe doit être différent de l\'ancien');
        isValid = false;
    }

    return isValid;
}

/**
 * Profile Form Validation
 */
function validateProfileForm() {
    let isValid = true;
    clearErrors();

    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();

    if (!name) {
        showFieldError('name', 'Le nom est requis');
        isValid = false;
    } else if (name.length < 3) {
        showFieldError('name', 'Le nom doit contenir au moins 3 caractères');
        isValid = false;
    }

    if (!email) {
        showFieldError('email', 'L\'email est requis');
        isValid = false;
    } else if (!isValidEmail(email)) {
        showFieldError('email', 'L\'email n\'est pas valide');
        isValid = false;
    }

    return isValid;
}

/**
 * Email Validation
 */
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

/**
 * Show Field Error
 */
function showFieldError(fieldName, message) {
    // Capitaliser la première lettre
    const capitalizedFieldName = fieldName.split('_')
        .map(word => word.charAt(0).toUpperCase() + word.slice(1))
        .join('');

    const errorElement = document.getElementById(`error${capitalizedFieldName}`);
    const inputElement = document.getElementById(fieldName);

    if (errorElement && inputElement) {
        errorElement.textContent = message;
        errorElement.classList.add('show');
        inputElement.closest('.form-group').classList.add('error');
    }
}

/**
 * Clear All Errors
 */
function clearErrors() {
    document.querySelectorAll('.form-error').forEach(error => {
        error.classList.remove('show');
        error.textContent = '';
    });
    document.querySelectorAll('.form-group').forEach(group => {
        group.classList.remove('error');
    });
}

/**
 * Show Notification
 */
function showNotification(message, type = 'info') {
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

    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

/**
 * Form Submit Handlers
 */
function initFormHandlers() {
    // Profile form
    if (elements.profileForm) {
        elements.profileForm.addEventListener('submit', function(e) {
            if (!validateProfileForm()) {
                e.preventDefault();
                showNotification('Veuillez corriger les erreurs', 'error');
            }
        });
    }

    // Password form
    if (elements.passwordForm) {
        elements.passwordForm.addEventListener('submit', function(e) {
            if (!validatePasswordForm()) {
                e.preventDefault();
                showNotification('Veuillez corriger les erreurs', 'error');
            }
        });
    }

    // Real-time validation for email
    const emailInput = document.getElementById('email');
    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            const email = this.value.trim();
            if (email && !isValidEmail(email)) {
                showFieldError('email', 'L\'email n\'est pas valide');
            } else if (this.closest('.form-group').classList.contains('error')) {
                clearErrors();
            }
        });
    }

    // Real-time validation for name
    const nameInput = document.getElementById('name');
    if (nameInput) {
        nameInput.addEventListener('blur', function() {
            const name = this.value.trim();
            if (name && name.length < 3) {
                showFieldError('name', 'Le nom doit contenir au moins 3 caractères');
            } else if (this.closest('.form-group').classList.contains('error')) {
                clearErrors();
            }
        });
    }

    // Password confirmation validation
    const confirmPassword = document.getElementById('new_password_confirmation');
    if (confirmPassword && elements.newPassword) {
        confirmPassword.addEventListener('input', function() {
            if (this.value && elements.newPassword.value && this.value !== elements.newPassword.value) {
                showFieldError('new_password_confirmation', 'Les mots de passe ne correspondent pas');
            } else {
                const errorElement = document.getElementById('errorNewPasswordConfirmation');
                if (errorElement) {
                    errorElement.classList.remove('show');
                    this.closest('.form-group').classList.remove('error');
                }
            }
        });
    }
}

/**
 * Initialize Password Strength Checker
 */
function initPasswordStrengthChecker() {
    if (elements.newPassword) {
        elements.newPassword.addEventListener('input', function() {
            checkPasswordStrength(this.value);
        });
    }
}

/**
 * Show existing errors from server
 */
function showExistingErrors() {
    document.querySelectorAll('.form-error').forEach(error => {
        if (error.textContent.trim() !== '') {
            error.classList.add('show');
            error.closest('.form-group')?.classList.add('error');
        }
    });
}

/**
 * Auto-hide alerts
 */
function initAutoHideAlerts() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.3s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
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

/**
 * Initialize Everything
 */
function init() {
    initAvatarPreview();
    initPasswordStrengthChecker();
    initFormHandlers();
    showExistingErrors();
    initAutoHideAlerts();
    console.log('✅ Profile page initialized');
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}
