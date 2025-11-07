@extends('parametres.index')

@section('content')
<div class="settings-layout">
    <!-- Settings Sidebar (inherited) -->
    @include('parametres.partials.sidebar')

    <!-- Overlay for mobile -->
    <div class="settings-sidebar-overlay" id="settingsSidebarOverlay"></div>

    <!-- Settings Content -->
    <main class="settings-content">
        <!-- Header -->
        <div class="settings-header">
            <h1 class="settings-title">Paramètres Généraux</h1>
            <p class="settings-description">Configuration générale de l'application</p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="notification success" style="margin-bottom: 24px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="notification error" style="margin-bottom: 24px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('parametres.general.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Application Settings -->
            <div class="settings-section">
                <div class="settings-section-header">
                    <div class="settings-section-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div>
                        <h3 class="settings-section-title">Informations de l'Application</h3>
                        <p class="settings-section-description">Nom, description et branding</p>
                    </div>
                </div>

                <div style="display: grid; gap: 20px;">
                    <div class="form-group">
                        <label for="app_name" class="form-label required">Nom de l'Application</label>
                        <input type="text" id="app_name" name="app_name" class="form-input"
                               value="{{ old('app_name', $settings['app_name'] ?? '') }}" required>
                        @error('app_name')
                        <div class="form-error show">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="app_description" class="form-label">Description</label>
                        <textarea id="app_description" name="app_description" class="form-textarea" rows="3">{{ old('app_description', $settings['app_description'] ?? '') }}</textarea>
                        @error('app_description')
                        <div class="form-error show">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Regional Settings -->
            <div class="settings-section">
                <div class="settings-section-header">
                    <div class="settings-section-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="2" y1="12" x2="22" y2="12"></line>
                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="settings-section-title">Paramètres Régionaux</h3>
                        <p class="settings-section-description">Langue, fuseau horaire et formats</p>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                    <div class="form-group">
                        <label for="language" class="form-label required">Langue</label>
                        <select id="language" name="language" class="form-select" required>
                            <option value="fr" {{ ($settings['language'] ?? 'fr') === 'fr' ? 'selected' : '' }}>Français</option>
                            <option value="en" {{ ($settings['language'] ?? 'fr') === 'en' ? 'selected' : '' }}>English</option>
                            <option value="ar" {{ ($settings['language'] ?? 'fr') === 'ar' ? 'selected' : '' }}>العربية</option>
                        </select>
                        @error('language')
                        <div class="form-error show">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="timezone" class="form-label required">Fuseau Horaire</label>
                        <select id="timezone" name="timezone" class="form-select" required>
                            <option value="Africa/Casablanca" {{ ($settings['timezone'] ?? '') === 'Africa/Casablanca' ? 'selected' : '' }}>Africa/Casablanca (UTC+1)</option>
                            <option value="Africa/Tunis" {{ ($settings['timezone'] ?? '') === 'Africa/Tunis' ? 'selected' : '' }}>Africa/Tunis (UTC+1)</option>
                            <option value="Africa/Algiers" {{ ($settings['timezone'] ?? '') === 'Africa/Algiers' ? 'selected' : '' }}>Africa/Algiers (UTC+1)</option>
                            <option value="Europe/Paris" {{ ($settings['timezone'] ?? '') === 'Europe/Paris' ? 'selected' : '' }}>Europe/Paris (UTC+1/+2)</option>
                            <option value="UTC" {{ ($settings['timezone'] ?? '') === 'UTC' ? 'selected' : '' }}>UTC (UTC+0)</option>
                        </select>
                        @error('timezone')
                        <div class="form-error show">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="date_format" class="form-label required">Format de Date</label>
                        <select id="date_format" name="date_format" class="form-select" required>
                            <option value="d/m/Y" {{ ($settings['date_format'] ?? 'd/m/Y') === 'd/m/Y' ? 'selected' : '' }}>jj/mm/aaaa (31/12/2025)</option>
                            <option value="m/d/Y" {{ ($settings['date_format'] ?? 'd/m/Y') === 'm/d/Y' ? 'selected' : '' }}>mm/jj/aaaa (12/31/2025)</option>
                            <option value="Y-m-d" {{ ($settings['date_format'] ?? 'd/m/Y') === 'Y-m-d' ? 'selected' : '' }}>aaaa-mm-jj (2025-12-31)</option>
                        </select>
                        @error('date_format')
                        <div class="form-error show">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="currency" class="form-label required">Devise</label>
                        <select id="currency" name="currency" class="form-select" required>
                            <option value="FCFA" {{ ($settings['currency'] ?? 'FCFA') === 'FCFA' ? 'selected' : '' }}>FCFA (Franc CFA)</option>
                            <option value="MAD" {{ ($settings['currency'] ?? 'FCFA') === 'MAD' ? 'selected' : '' }}>MAD (Dirham Marocain)</option>
                            <option value="TND" {{ ($settings['currency'] ?? 'FCFA') === 'TND' ? 'selected' : '' }}>TND (Dinar Tunisien)</option>
                            <option value="DZD" {{ ($settings['currency'] ?? 'FCFA') === 'DZD' ? 'selected' : '' }}>DZD (Dinar Algérien)</option>
                            <option value="EUR" {{ ($settings['currency'] ?? 'FCFA') === 'EUR' ? 'selected' : '' }}>EUR (Euro)</option>
                            <option value="USD" {{ ($settings['currency'] ?? 'FCFA') === 'USD' ? 'selected' : '' }}>USD (Dollar)</option>
                        </select>
                        @error('currency')
                        <div class="form-error show">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <a href="{{ route('parametres.index') }}" class="btn btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                    Annuler
                </a>
                <button type="submit" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </main>

    <!-- Mobile Toggle Button -->
    <button class="settings-mobile-toggle" id="settingsMobileToggle">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="3"></circle>
            <path d="M12 1v6m0 6v6m0-6h6m-6 0H6"></path>
        </svg>
    </button>
</div>

<style>
/* Form Styles */
.form-group {
    margin-bottom: 0;
}

.form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-secondary);
    margin-bottom: 8px;
}

.form-label.required::after {
    content: '*';
    color: var(--danger);
    margin-left: 4px;
}

.form-input,
.form-select,
.form-textarea {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid var(--card-border);
    border-radius: 10px;
    background: var(--bg-tertiary);
    color: var(--text-primary);
    font-size: 0.9375rem;
    transition: var(--transition);
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    background: var(--bg-secondary);
}

.form-textarea {
    resize: vertical;
    min-height: 100px;
}

.form-error {
    color: var(--danger);
    font-size: 0.8125rem;
    margin-top: 6px;
    display: none;
}

.form-error.show {
    display: block;
}

.form-group.error .form-input,
.form-group.error .form-select {
    border-color: var(--danger);
}

/* Buttons */
.btn {
    padding: 13px 24px;
    border-radius: 12px;
    font-size: 0.938rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 2px solid transparent;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    letter-spacing: 0.3px;
    position: relative;
    overflow: hidden;
}

.btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.2);
    transition: left 0.5s ease;
}

.btn:hover::before {
    left: 100%;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #ffffff;
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.5);
}

.btn-secondary {
    background: #ffffff;
    color: #475569;
    border-color: #e2e8f0;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.dark .btn-secondary {
    background: #334155;
    color: #e2e8f0;
    border-color: #475569;
}

.btn-secondary:hover {
    background: #f8fafc;
    border-color: #cbd5e1;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
}

/* Notification */
.notification {
    padding: 16px 24px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.notification.success {
    background: rgba(16, 185, 129, 0.1);
    border-left: 4px solid #10b981;
    color: #10b981;
}

.notification.error {
    background: rgba(239, 68, 68, 0.1);
    border-left: 4px solid #ef4444;
    color: #ef4444;
}
</style>
@endsection
