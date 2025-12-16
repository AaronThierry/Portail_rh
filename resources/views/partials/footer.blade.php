<footer class="app-footer">
    <div class="footer-container">
        <!-- Footer Left - Branding -->
        <div class="footer-left">
            <div class="footer-brand">
                <div class="footer-logo">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2L2 7l10 5 10-5-10-5z"></path>
                        <path d="M2 17l10 5 10-5M2 12l10 5 10-5"></path>
                    </svg>
                </div>
                <p class="footer-copyright">
                    &copy; {{ date('Y') }} <span class="brand-name">Portail RH+</span>
                </p>
            </div>
        </div>

        <!-- Footer Center - Links -->
        <div class="footer-center">
            <nav class="footer-nav">
                <a href="/mentions-legales" class="footer-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                    <span>Mentions légales</span>
                </a>
                <span class="footer-divider"></span>
                <a href="/confidentialite" class="footer-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                    <span>Confidentialité</span>
                </a>
                <span class="footer-divider"></span>
                <a href="/support" class="footer-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                    <span>Support</span>
                </a>
            </nav>
        </div>

        <!-- Footer Right - Version & Status -->
        <div class="footer-right">
            <div class="footer-status">
                <span class="status-indicator online"></span>
                <span class="status-text">Système opérationnel</span>
            </div>
            <div class="footer-version-badge">
                <span class="version-label">Version</span>
                <span class="version-number">1.0.0</span>
            </div>
        </div>
    </div>
</footer>

<style>
/* ==================== FOOTER PREMIUM STYLES ==================== */

.app-footer {
    height: var(--footer-height, 60px);
    background: var(--footer-bg, #ffffff);
    border-top: 1px solid var(--footer-border, #E8ECF0);
    flex-shrink: 0;
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    background: rgba(255, 255, 255, 0.92);
    position: relative;
    z-index: 10;
}

.dark .app-footer {
    background: rgba(26, 31, 46, 0.92);
}

/* Gradient Top Border - Blue to Orange RH+ */
.app-footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(90deg,
        transparent 0%,
        var(--primary, #4A90D9) 20%,
        #FF9500 50%,
        var(--primary, #4A90D9) 80%,
        transparent 100%);
    opacity: 0.8;
}

.footer-container {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 2rem;
    gap: 2rem;
    max-width: 1920px;
    margin: 0 auto;
}

/* Footer Left - Branding */
.footer-left {
    display: flex;
    align-items: center;
}

.footer-brand {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.footer-logo {
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--primary, #4A90D9) 0%, var(--primary-dark, #2E6BB3) 100%);
    border-radius: 8px;
    color: white;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    border: 2px solid transparent;
}

.footer-logo svg {
    width: 16px;
    height: 16px;
}

.footer-logo:hover {
    transform: scale(1.1) rotate(5deg);
    background: linear-gradient(135deg, #FF9500 0%, #FF6B00 100%);
    box-shadow: 0 4px 16px rgba(255, 149, 0, 0.4);
}

.footer-copyright {
    font-size: 0.8125rem;
    color: var(--footer-text, #8B9CAD);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.brand-name {
    font-weight: 700;
    background: linear-gradient(135deg, var(--primary, #4A90D9) 0%, var(--primary-dark, #2E6BB3) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Footer Center - Navigation */
.footer-center {
    display: flex;
    align-items: center;
    justify-content: center;
}

.footer-nav {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.footer-link {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.875rem;
    font-size: 0.8125rem;
    font-weight: 500;
    color: var(--footer-text, #8B9CAD);
    text-decoration: none;
    border-radius: var(--radius-sm, 8px);
    transition: all 0.25s cubic-bezier(0.25, 1, 0.5, 1);
    position: relative;
}

.footer-link svg {
    width: 14px;
    height: 14px;
    opacity: 0.7;
    transition: all 0.25s;
}

.footer-link:hover {
    color: var(--primary, #4A90D9);
    background: var(--primary-light, #E8F4FD);
}

.footer-link:hover svg {
    opacity: 1;
    transform: scale(1.15);
}

/* Underline Animation */
.footer-link::after {
    content: '';
    position: absolute;
    bottom: 4px;
    left: 50%;
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--primary, #4A90D9) 0%, var(--primary-dark, #2E6BB3) 100%);
    border-radius: 1px;
    transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
    transform: translateX(-50%);
}

.footer-link:hover::after {
    width: calc(100% - 1.75rem);
}

.footer-divider {
    width: 1px;
    height: 16px;
    background: var(--sidebar-border, #E8ECF0);
    margin: 0 0.25rem;
}

/* Footer Right - Status & Version */
.footer-right {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.footer-status {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.375rem 0.75rem;
    background: var(--accent-green-light, #D5F5E3);
    border-radius: var(--radius-sm, 8px);
    transition: all 0.3s;
}

.dark .footer-status {
    background: rgba(39, 174, 96, 0.15);
}

.status-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    animation: status-pulse 2s ease-in-out infinite;
}

.status-indicator.online {
    background: var(--accent-green, #27AE60);
    box-shadow: 0 0 0 2px rgba(39, 174, 96, 0.2);
}

.status-indicator.warning {
    background: var(--accent-orange, #F5A623);
    box-shadow: 0 0 0 2px rgba(245, 166, 35, 0.2);
}

.status-indicator.offline {
    background: var(--accent-red, #E74C3C);
    box-shadow: 0 0 0 2px rgba(231, 76, 60, 0.2);
}

@keyframes status-pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.6;
    }
}

.status-text {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--accent-green, #27AE60);
}

.dark .status-text {
    color: #2ECC71;
}

.footer-version-badge {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.75rem;
    background: linear-gradient(135deg, var(--primary-light, #E8F4FD) 0%, var(--primary-lighter, #F0F8FF) 100%);
    border: 1px solid var(--primary-light, #E8F4FD);
    border-radius: var(--radius-sm, 8px);
    transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
    cursor: default;
}

.footer-version-badge:hover {
    background: linear-gradient(135deg, var(--primary, #4A90D9) 0%, var(--primary-dark, #2E6BB3) 100%);
    border-color: var(--primary, #4A90D9);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(74, 144, 217, 0.25);
}

.footer-version-badge:hover .version-label,
.footer-version-badge:hover .version-number {
    color: white;
}

.version-label {
    font-size: 0.6875rem;
    font-weight: 500;
    color: var(--sidebar-text-muted, #8B9CAD);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    transition: color 0.3s;
}

.version-number {
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--primary, #4A90D9);
    transition: color 0.3s;
}

.dark .footer-version-badge {
    background: var(--primary-light, #1A3A5C);
    border-color: var(--primary-light, #1A3A5C);
}

.dark .footer-version-badge:hover {
    background: linear-gradient(135deg, var(--primary, #5BA3E8) 0%, var(--primary-dark, #4A90D9) 100%);
}

/* Responsive Styles */
@media (max-width: 1024px) {
    .footer-container {
        flex-direction: column;
        padding: 1rem;
        gap: 0.75rem;
        height: auto;
        min-height: var(--footer-height, 60px);
    }

    .footer-left,
    .footer-center,
    .footer-right {
        width: 100%;
        justify-content: center;
    }

    .footer-nav {
        flex-wrap: wrap;
        justify-content: center;
    }

    .footer-divider {
        display: none;
    }

    .footer-status {
        display: none;
    }
}

@media (max-width: 640px) {
    .footer-link span {
        display: none;
    }

    .footer-link {
        padding: 0.625rem;
    }

    .footer-link svg {
        width: 18px;
        height: 18px;
    }

    .footer-link::after {
        display: none;
    }

    .footer-copyright {
        font-size: 0.75rem;
    }

    .footer-logo {
        width: 24px;
        height: 24px;
    }

    .footer-logo svg {
        width: 14px;
        height: 14px;
    }
}
</style>
