/**
 * Login Form Handler
 * Gestion de l'authentification avec Ajax
 */

/**
 * Theme Management
 */
const ThemeManager = {
  STORAGE_KEY: 'theme-preference',

  init() {
    // Get saved theme or use system preference
    const savedTheme = this.getSavedTheme();
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const theme = savedTheme || (prefersDark ? 'dark' : 'light');

    this.setTheme(theme, false);
    this.initToggleButton();
    this.watchSystemPreference();
  },

  getSavedTheme() {
    try {
      return localStorage.getItem(this.STORAGE_KEY);
    } catch (e) {
      console.warn('localStorage not available:', e);
      return null;
    }
  },

  setTheme(theme, save = true) {
    document.documentElement.setAttribute('data-theme', theme);

    if (save) {
      try {
        localStorage.setItem(this.STORAGE_KEY, theme);
      } catch (e) {
        console.warn('Could not save theme preference:', e);
      }
    }
  },

  toggleTheme() {
    const currentTheme = document.documentElement.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    this.setTheme(newTheme);
  },

  initToggleButton() {
    const toggleBtn = document.getElementById('themeToggle');
    if (toggleBtn) {
      toggleBtn.addEventListener('click', () => this.toggleTheme());
    }
  },

  watchSystemPreference() {
    // Watch for system theme changes (only if user hasn't set a preference)
    const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
    mediaQuery.addEventListener('change', (e) => {
      if (!this.getSavedTheme()) {
        this.setTheme(e.matches ? 'dark' : 'light', false);
      }
    });
  }
};

// Configuration
const CONFIG = {
  API_ENDPOINT: '/login',
  REDIRECT_URL: '/dashboard'
};

// Elements
const elements = {
  loginForm: document.getElementById('loginForm'),
  courrierInput: document.getElementById('courrier'),
  passwordInput: document.getElementById('password'),
  submitBtn: document.getElementById('submitBtn'),
  togglePasswordBtn: document.getElementById('togglePassword'),
  alertBox: document.getElementById('alert'),
  errCourrier: document.getElementById('err-courrier'),
  errPassword: document.getElementById('err-password')
};

// CSRF Token
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

/**
 * Toggle password visibility
 */
function initPasswordToggle() {
  elements.togglePasswordBtn.addEventListener('click', function() {
    const type = elements.passwordInput.type === 'password' ? 'text' : 'password';
    elements.passwordInput.type = type;
    this.textContent = type === 'password' ? 'Afficher' : 'Masquer';
  });
}

/**
 * Validation helpers
 */
function isValidEmail(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
}

function showError(input, errorElement, message) {
  input.classList.add('invalid');
  input.classList.remove('valid');
  errorElement.textContent = message;
  errorElement.classList.add('show');
}

function hideError(input, errorElement) {
  input.classList.remove('invalid');
  input.classList.add('valid');
  errorElement.classList.remove('show');
}

function showAlert(message, type = 'error') {
  elements.alertBox.textContent = message;
  elements.alertBox.className = `alert alert-${type} show`;

  if (type === 'success') {
    setTimeout(() => {
      elements.alertBox.classList.remove('show');
    }, 3000);
  }
}

function hideAlert() {
  elements.alertBox.classList.remove('show');
}

function setLoading(loading) {
  if (loading) {
    elements.submitBtn.classList.add('loading');
    elements.submitBtn.disabled = true;
    elements.courrierInput.disabled = true;
    elements.passwordInput.disabled = true;
  } else {
    elements.submitBtn.classList.remove('loading');
    elements.submitBtn.disabled = false;
    elements.courrierInput.disabled = false;
    elements.passwordInput.disabled = false;
  }
}

/**
 * Real-time validation
 */
function initRealtimeValidation() {
  // Email validation
  elements.courrierInput.addEventListener('blur', function() {
    const value = this.value.trim();
    if (value && !isValidEmail(value)) {
      showError(this, elements.errCourrier, 'Veuillez entrer une adresse e-mail valide');
    } else if (value) {
      hideError(this, elements.errCourrier);
    }
  });

  elements.courrierInput.addEventListener('input', function() {
    if (this.classList.contains('invalid')) {
      const value = this.value.trim();
      if (isValidEmail(value)) {
        hideError(this, elements.errCourrier);
      }
    }
  });

  // Password validation
  elements.passwordInput.addEventListener('blur', function() {
    const value = this.value;
    if (value && value.length < 6) {
      showError(this, elements.errPassword, 'Le mot de passe doit contenir au moins 6 caractères');
    } else if (value) {
      hideError(this, elements.errPassword);
    }
  });

  elements.passwordInput.addEventListener('input', function() {
    if (this.classList.contains('invalid')) {
      if (this.value.length >= 6) {
        hideError(this, elements.errPassword);
      }
    }
  });
}

/**
 * Form submission handler
 */
async function handleFormSubmit(e) {
  e.preventDefault();
  hideAlert();

  // Reset validation states
  [elements.courrierInput, elements.passwordInput].forEach(input => {
    input.classList.remove('invalid', 'valid');
  });
  elements.errCourrier.classList.remove('show');
  elements.errPassword.classList.remove('show');

  // Get values
  const courrier = elements.courrierInput.value.trim();
  const password = elements.passwordInput.value;

  // Validate
  let isValid = true;

  if (!courrier) {
    showError(elements.courrierInput, elements.errCourrier, 'L\'adresse e-mail est requise');
    isValid = false;
  } else if (!isValidEmail(courrier)) {
    showError(elements.courrierInput, elements.errCourrier, 'Veuillez entrer une adresse e-mail valide');
    isValid = false;
  }

  if (!password) {
    showError(elements.passwordInput, elements.errPassword, 'Le mot de passe est requis');
    isValid = false;
  } else if (password.length < 6) {
    showError(elements.passwordInput, elements.errPassword, 'Le mot de passe doit contenir au moins 6 caractères');
    isValid = false;
  }

  if (!isValid) {
    return;
  }

  // Prepare data
  const loginData = {
    courrier: courrier,
    password: password
  };

  // Set loading state
  setLoading(true);

  try {
    // Send AJAX request
    const response = await fetch(CONFIG.API_ENDPOINT, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: JSON.stringify(loginData)
    });

    const data = await response.json();
console.log(response);
    if (response.ok) {
      // Success
      showAlert(data.message || 'Connexion réussie ! Redirection...', 'success');

      // Mark inputs as valid
      elements.courrierInput.classList.add('valid');
      elements.passwordInput.classList.add('valid');

      // Redirect after a short delay
      setTimeout(() => {
        window.location.href = data.redirect || CONFIG.REDIRECT_URL;
      }, 1000);

    } else {
      // Error from backend
      handleErrorResponse(response, data);
    }

  } catch (error) {
    console.error('Login error:', error);
    showAlert('Impossible de se connecter au serveur. Vérifiez votre connexion internet.', 'error');
  } finally {
    setLoading(false);
  }
}

/**
 * Handle error responses from backend
 */
function handleErrorResponse(response, data) {
  if (response.status === 422) {
    // Validation errors
    if (data.errors) {
      if (data.errors.courrier) {
        showError(elements.courrierInput, elements.errCourrier, data.errors.courrier[0]);
      }
      if (data.errors.password) {
        showError(elements.passwordInput, elements.errPassword, data.errors.password[0]);
      }
    } else {
      showAlert(data.message || 'Les informations fournies sont invalides', 'error');
    }
  } else if (response.status === 401) {
    // Unauthorized
    showAlert(data.message || 'E-mail ou mot de passe incorrect', 'error');
  } else if (response.status === 429) {
    // Too many requests
    showAlert('Trop de tentatives. Veuillez réessayer dans quelques minutes.', 'error');
  } else {
    // Other errors
    showAlert(data.message || 'Une erreur est survenue. Veuillez réessayer.', 'error');
  }
}

/**
 * Initialize the login form
 */
function init() {
  // Initialize theme manager first
  ThemeManager.init();

  // Check if all elements exist
  if (!elements.loginForm || !elements.courrierInput || !elements.passwordInput) {
    console.error('Login form elements not found');
    return;
  }

  // Initialize features
  initPasswordToggle();
  initRealtimeValidation();

  // Attach form submit handler
  elements.loginForm.addEventListener('submit', handleFormSubmit);

  // Focus first input on load
  elements.courrierInput.focus();
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}