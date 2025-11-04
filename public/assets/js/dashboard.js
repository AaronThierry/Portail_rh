/**
 * Dashboard JavaScript
 * Portail RH - Gestion des interactions
 */

// ===================================
// Theme Management
// ===================================

const ThemeManager = {
  STORAGE_KEY: 'theme-preference',

  init() {
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
    const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
    mediaQuery.addEventListener('change', (e) => {
      if (!this.getSavedTheme()) {
        this.setTheme(e.matches ? 'dark' : 'light', false);
      }
    });
  }
};

// ===================================
// Sidebar Management
// ===================================

const SidebarManager = {
  STORAGE_KEY: 'sidebar-collapsed',
  sidebar: null,
  sidebarToggle: null,
  mobileMenuToggle: null,

  init() {
    this.sidebar = document.getElementById('sidebar');
    this.sidebarToggle = document.getElementById('sidebarToggle');
    this.mobileMenuToggle = document.getElementById('mobileMenuToggle');

    if (!this.sidebar) return;

    // Restore sidebar state
    const isCollapsed = this.getCollapsedState();
    if (isCollapsed) {
      this.sidebar.classList.add('collapsed');
    }

    // Setup event listeners
    if (this.sidebarToggle) {
      this.sidebarToggle.addEventListener('click', () => this.toggleSidebar());
    }

    if (this.mobileMenuToggle) {
      this.mobileMenuToggle.addEventListener('click', () => this.toggleMobileSidebar());
    }

    // Close sidebar on outside click (mobile)
    this.setupOutsideClick();
  },

  toggleSidebar() {
    const isCollapsed = this.sidebar.classList.toggle('collapsed');
    this.saveCollapsedState(isCollapsed);
  },

  toggleMobileSidebar() {
    this.sidebar.classList.toggle('mobile-open');
  },

  getCollapsedState() {
    try {
      return localStorage.getItem(this.STORAGE_KEY) === 'true';
    } catch (e) {
      return false;
    }
  },

  saveCollapsedState(isCollapsed) {
    try {
      localStorage.setItem(this.STORAGE_KEY, isCollapsed);
    } catch (e) {
      console.warn('Could not save sidebar state:', e);
    }
  },

  setupOutsideClick() {
    document.addEventListener('click', (e) => {
      if (window.innerWidth <= 1024) {
        if (!this.sidebar.contains(e.target) && !this.mobileMenuToggle.contains(e.target)) {
          this.sidebar.classList.remove('mobile-open');
        }
      }
    });
  }
};

// ===================================
// Dropdown Management
// ===================================

const DropdownManager = {
  activeDropdown: null,

  init() {
    this.setupDropdowns();
    this.setupOutsideClick();
  },

  setupDropdowns() {
    // Notification dropdown
    const notificationBtn = document.getElementById('notificationBtn');
    const notificationDropdown = document.getElementById('notificationDropdown');
    if (notificationBtn && notificationDropdown) {
      notificationBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        this.toggleDropdown(notificationDropdown);
      });
    }

    // User dropdown
    const userMenuBtn = document.getElementById('userMenuBtn');
    const userDropdown = document.getElementById('userDropdown');
    if (userMenuBtn && userDropdown) {
      userMenuBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        this.toggleDropdown(userDropdown);
      });
    }
  },

  toggleDropdown(dropdown) {
    if (this.activeDropdown && this.activeDropdown !== dropdown) {
      this.activeDropdown.classList.remove('show');
    }

    dropdown.classList.toggle('show');
    this.activeDropdown = dropdown.classList.contains('show') ? dropdown : null;
  },

  closeAllDropdowns() {
    const dropdowns = document.querySelectorAll('.dropdown-menu.show');
    dropdowns.forEach(dropdown => dropdown.classList.remove('show'));
    this.activeDropdown = null;
  },

  setupOutsideClick() {
    document.addEventListener('click', () => {
      this.closeAllDropdowns();
    });

    // Prevent closing when clicking inside dropdown
    document.querySelectorAll('.dropdown-menu').forEach(dropdown => {
      dropdown.addEventListener('click', (e) => {
        e.stopPropagation();
      });
    });
  }
};

// ===================================
// Search Functionality
// ===================================

const SearchManager = {
  searchInput: null,

  init() {
    this.searchInput = document.getElementById('headerSearch');
    if (!this.searchInput) return;

    // Keyboard shortcut (Ctrl/Cmd + K)
    document.addEventListener('keydown', (e) => {
      if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        this.searchInput.focus();
      }
    });

    // Search input events
    this.searchInput.addEventListener('input', (e) => {
      this.handleSearch(e.target.value);
    });
  },

  handleSearch(query) {
    if (query.length < 2) return;

    // TODO: Implement actual search functionality
    console.log('Searching for:', query);

    // You can implement AJAX search here
    // Example:
    // fetch(`/api/search?q=${encodeURIComponent(query)}`)
    //   .then(response => response.json())
    //   .then(data => this.displayResults(data));
  },

  displayResults(results) {
    // TODO: Display search results
    console.log('Results:', results);
  }
};

// ===================================
// Notifications
// ===================================

const NotificationManager = {
  init() {
    this.setupMarkAsRead();
  },

  setupMarkAsRead() {
    const markReadBtn = document.querySelector('.mark-read-btn');
    if (markReadBtn) {
      markReadBtn.addEventListener('click', () => {
        this.markAllAsRead();
      });
    }

    // Individual notification clicks
    document.querySelectorAll('.notification-item').forEach(item => {
      item.addEventListener('click', () => {
        item.classList.remove('unread');
        this.updateBadgeCount();
      });
    });
  },

  markAllAsRead() {
    document.querySelectorAll('.notification-item.unread').forEach(item => {
      item.classList.remove('unread');
    });
    this.updateBadgeCount();
  },

  updateBadgeCount() {
    const badge = document.querySelector('.notification-badge');
    const unreadCount = document.querySelectorAll('.notification-item.unread').length;

    if (badge) {
      badge.textContent = unreadCount;
      badge.style.display = unreadCount > 0 ? 'flex' : 'none';
    }
  }
};

// ===================================
// Utility Functions
// ===================================

const Utils = {
  // Debounce function for search and other inputs
  debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
      const later = () => {
        clearTimeout(timeout);
        func(...args);
      };
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
    };
  },

  // Format date
  formatDate(date) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(date).toLocaleDateString('fr-FR', options);
  },

  // Format time ago
  timeAgo(date) {
    const seconds = Math.floor((new Date() - new Date(date)) / 1000);

    let interval = seconds / 31536000;
    if (interval > 1) return Math.floor(interval) + ' ans';

    interval = seconds / 2592000;
    if (interval > 1) return Math.floor(interval) + ' mois';

    interval = seconds / 86400;
    if (interval > 1) return Math.floor(interval) + ' jours';

    interval = seconds / 3600;
    if (interval > 1) return Math.floor(interval) + ' heures';

    interval = seconds / 60;
    if (interval > 1) return Math.floor(interval) + ' minutes';

    return 'Il y a quelques secondes';
  },

  // Show toast notification
  showToast(message, type = 'info') {
    // TODO: Implement toast notification system
    console.log(`[${type.toUpperCase()}] ${message}`);
  },

  // Confirm dialog
  confirm(message, callback) {
    if (window.confirm(message)) {
      callback();
    }
  }
};

// ===================================
// CSRF Token Setup
// ===================================

const CSRFSetup = {
  init() {
    const token = document.querySelector('meta[name="csrf-token"]')?.content;

    if (token) {
      // Setup for fetch API
      window.csrfToken = token;

      // Setup for axios if available
      if (window.axios) {
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
      }
    }
  }
};

// ===================================
// Initialize Everything
// ===================================

function initDashboard() {
  // Initialize all managers
  ThemeManager.init();
  SidebarManager.init();
  DropdownManager.init();
  SearchManager.init();
  NotificationManager.init();
  CSRFSetup.init();

  // Log initialization
  console.log('✅ Dashboard initialized successfully');
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initDashboard);
} else {
  initDashboard();
}

// Export for use in other scripts
window.Dashboard = {
  ThemeManager,
  SidebarManager,
  DropdownManager,
  SearchManager,
  NotificationManager,
  Utils
};
