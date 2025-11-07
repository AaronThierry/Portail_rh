import './bootstrap';

// Dark mode toggle
document.addEventListener('DOMContentLoaded', function() {
    // Initialize dark mode from localStorage
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }

    // Theme toggle functionality
    const themeToggleButtons = document.querySelectorAll('[data-theme-toggle]');
    themeToggleButtons.forEach(button => {
        button.addEventListener('click', () => {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
        });
    });

    // ==================== SIDEBAR & MOBILE MENU ====================
    const sidebar = document.getElementById('sidebar');
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    // Function to sync burger icon with sidebar state
    const syncBurgerIcon = () => {
        if (!mobileMenuButton || !sidebar) return;

        const isMobileOpen = sidebar.classList.contains('mobile-open');

        if (isMobileOpen) {
            mobileMenuButton.classList.add('active');
            document.body.style.overflow = 'hidden'; // Prevent scroll when menu is open
        } else {
            mobileMenuButton.classList.remove('active');
            document.body.style.overflow = '';
        }
    };

    // Submenu toggle functionality
    const submenuButtons = document.querySelectorAll('.nav-link[data-submenu]');
    submenuButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const navItem = button.closest('.nav-item');

            // Close other submenus in the same section
            const currentSection = navItem.closest('.nav-section');
            currentSection.querySelectorAll('.nav-item.open').forEach(openItem => {
                if (openItem !== navItem) {
                    openItem.classList.remove('open');
                }
            });

            // Toggle current submenu
            navItem.classList.toggle('open');

            // Save opened submenus to localStorage
            const openSubmenus = [];
            document.querySelectorAll('.nav-item.open').forEach(item => {
                const submenuBtn = item.querySelector('[data-submenu]');
                const submenuId = submenuBtn?.getAttribute('data-submenu');
                if (submenuId) {
                    openSubmenus.push(submenuId);
                }
            });
            localStorage.setItem('openSubmenus', JSON.stringify(openSubmenus));
        });
    });

    // Restore opened submenus from localStorage
    try {
        const openSubmenus = JSON.parse(localStorage.getItem('openSubmenus') || '[]');
        openSubmenus.forEach(submenuId => {
            const button = document.querySelector(`[data-submenu="${submenuId}"]`);
            const navItem = button?.closest('.nav-item');
            if (navItem) {
                navItem.classList.add('open');
            }
        });
    } catch (e) {
        console.error('Error restoring submenus:', e);
    }

    // Auto-open submenu if current page is in it
    document.querySelectorAll('.submenu-link.active').forEach(link => {
        const navItem = link.closest('.nav-item');
        if (navItem) {
            navItem.classList.add('open');
        }
    });

    // ==================== MOBILE MENU TOGGLE ====================
    if (mobileMenuButton && sidebar && sidebarOverlay) {
        // Toggle mobile menu
        mobileMenuButton.addEventListener('click', (e) => {
            e.stopPropagation();
            e.preventDefault();

            const isOpen = sidebar.classList.contains('mobile-open');

            if (isOpen) {
                sidebar.classList.remove('mobile-open');
                sidebarOverlay.classList.remove('active');
            } else {
                sidebar.classList.add('mobile-open');
                sidebarOverlay.classList.add('active');
            }

            // Sync burger icon animation
            syncBurgerIcon();
        });

        // Close sidebar when clicking overlay
        sidebarOverlay.addEventListener('click', () => {
            sidebar.classList.remove('mobile-open');
            sidebarOverlay.classList.remove('active');
            syncBurgerIcon();
        });

        // Close mobile menu when clicking on a link (excluding submenu toggles)
        sidebar.querySelectorAll('a.nav-link, .submenu-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 1024) {
                    sidebar.classList.remove('mobile-open');
                    sidebarOverlay.classList.remove('active');
                    syncBurgerIcon();
                }
            });
        });

        // Close sidebar on window resize to desktop
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                if (window.innerWidth > 1024) {
                    sidebar.classList.remove('mobile-open');
                    sidebarOverlay.classList.remove('active');
                    syncBurgerIcon();
                }
            }, 250);
        });

        // Close sidebar on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && sidebar.classList.contains('mobile-open')) {
                sidebar.classList.remove('mobile-open');
                sidebarOverlay.classList.remove('active');
                syncBurgerIcon();
            }
        });

        // Initial sync on page load
        syncBurgerIcon();
    }

    // Add smooth scroll behavior
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#' && document.querySelector(href)) {
                e.preventDefault();
                document.querySelector(href).scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert-auto-hide');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });

    // ==================== INTERACTIVE ENHANCEMENTS ====================

    // Icon click animation
    document.querySelectorAll('.nav-link, .submenu-link').forEach(link => {
        link.addEventListener('click', function() {
            const icon = this.querySelector('.nav-icon, svg');
            if (icon) {
                icon.style.transform = 'scale(0.9)';
                setTimeout(() => {
                    icon.style.transform = '';
                }, 150);
            }
        });
    });

    // Smooth scroll indicator for sidebar navigation
    const sidebarNav = document.querySelector('.sidebar-nav');
    if (sidebarNav) {
        let scrollTimeout;
        sidebarNav.addEventListener('scroll', function() {
            this.classList.add('scrolling');
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
                this.classList.remove('scrolling');
            }, 1000);
        });
    }

    // Haptic feedback on mobile (if supported)
    if ('vibrate' in navigator && window.innerWidth <= 1024) {
        document.querySelectorAll('.nav-link, .submenu-link, .mobile-menu-btn').forEach(element => {
            element.addEventListener('click', () => {
                navigator.vibrate(10);
            });
        });
    }

    // ==================== PERFORMANCE OPTIMIZATIONS ====================

    // Debounce function for better performance
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Optimize scroll events
    let ticking = false;
    window.addEventListener('scroll', () => {
        if (!ticking) {
            window.requestAnimationFrame(() => {
                // Scroll-based logic here if needed
                ticking = false;
            });
            ticking = true;
        }
    });
});
