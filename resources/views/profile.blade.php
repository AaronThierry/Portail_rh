@extends('layouts.app')

@section('title', 'Mon Profil')

@section('styles')
<style>
/* Profile Page Styles */
.profile-page {
    padding: 24px;
    max-width: 1200px;
    margin: 0 auto;
}

/* Page Header */
.profile-header {
    margin-bottom: 32px;
}

.profile-title {
    font-size: 1.875rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 8px;
}

.profile-subtitle {
    color: var(--text-muted);
    font-size: 0.9375rem;
}

/* Profile Layout */
.profile-grid {
    display: grid;
    grid-template-columns: 350px 1fr;
    gap: 24px;
    align-items: start;
}

/* Profile Card */
.profile-card {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: var(--border-radius);
    padding: 32px;
    text-align: center;
    position: sticky;
    top: 96px;
}

.avatar-wrapper {
    position: relative;
    width: 120px;
    height: 120px;
    margin: 0 auto 20px;
}

.profile-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid var(--card-border);
    box-shadow: var(--shadow-md);
}

.avatar-upload-btn {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--primary);
    border: 3px solid var(--card-bg);
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition);
}

.avatar-upload-btn:hover {
    background: var(--primary-hover);
    transform: scale(1.1);
}

.avatar-upload-btn input {
    display: none;
}

.profile-name {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 4px;
}

.profile-email {
    color: var(--text-muted);
    font-size: 0.9375rem;
    margin-bottom: 16px;
}

.profile-role {
    display: inline-flex;
    align-items: center;
    padding: 6px 16px;
    background: linear-gradient(135deg, var(--primary), var(--primary-hover));
    color: white;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 20px;
}

.profile-stats {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-top: 24px;
    padding-top: 24px;
    border-top: 1px solid var(--card-border);
}

.stat-item {
    text-align: center;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary);
    display: block;
}

.stat-label {
    font-size: 0.8125rem;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Form Sections */
.form-sections {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.form-section {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: var(--border-radius);
    overflow: hidden;
}

.section-header {
    padding: 20px 24px;
    border-bottom: 1px solid var(--card-border);
    display: flex;
    align-items: center;
    gap: 12px;
}

.section-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, var(--primary), var(--primary-hover));
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
}

.section-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--text-primary);
}

.section-description {
    font-size: 0.875rem;
    color: var(--text-muted);
    margin-top: 2px;
}

.section-body {
    padding: 24px;
}

/* Form Styles */
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
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
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    background: var(--bg-secondary);
}

.form-input:disabled,
.form-select:disabled {
    opacity: 0.6;
    cursor: not-allowed;
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

.form-help {
    font-size: 0.8125rem;
    color: var(--text-muted);
    margin-top: 6px;
}

/* Buttons */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding-top: 16px;
    border-top: 1px solid var(--card-border);
    margin-top: 24px;
}

.btn {
    padding: 12px 24px;
    border-radius: 10px;
    font-size: 0.9375rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary), var(--primary-hover));
    color: white;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.btn-primary:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4);
}

.btn-primary:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.btn-secondary {
    background: var(--bg-tertiary);
    color: var(--text-primary);
    border: 1px solid var(--card-border);
}

.btn-secondary:hover {
    background: var(--bg-primary);
}

/* Alert Messages */
.alert {
    padding: 16px 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 0.9375rem;
    font-weight: 500;
}

.alert-success {
    background: var(--success-light);
    color: var(--success);
    border: 1px solid var(--success);
}

.alert-error {
    background: var(--danger-light);
    color: var(--danger);
    border: 1px solid var(--danger);
}

.alert-info {
    background: var(--info-light);
    color: var(--info);
    border: 1px solid var(--info);
}

/* Password Strength Indicator */
.password-strength {
    margin-top: 8px;
    height: 4px;
    background: var(--bg-tertiary);
    border-radius: 2px;
    overflow: hidden;
    display: none;
}

.password-strength.show {
    display: block;
}

.password-strength-bar {
    height: 100%;
    width: 0;
    transition: all 0.3s ease;
    border-radius: 2px;
}

.password-strength-bar.weak {
    width: 33%;
    background: var(--danger);
}

.password-strength-bar.medium {
    width: 66%;
    background: var(--warning);
}

.password-strength-bar.strong {
    width: 100%;
    background: var(--success);
}

.password-strength-text {
    font-size: 0.75rem;
    margin-top: 4px;
    font-weight: 600;
}

/* Responsive */
@media (max-width: 1024px) {
    .profile-grid {
        grid-template-columns: 1fr;
    }

    .profile-card {
        position: relative;
        top: 0;
    }
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }

    .profile-stats {
        grid-template-columns: 1fr;
    }

    .form-actions {
        flex-direction: column;
    }

    .form-actions .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endsection

@section('content')
<div class="profile-page">
    <!-- Page Header -->
    <div class="profile-header">
        <h1 class="profile-title">Mon Profil</h1>
        <p class="profile-subtitle">Gérez vos informations personnelles et préférences</p>
    </div>

    <div class="profile-grid">
        <!-- Profile Card -->
        <div class="profile-card">
            <div class="avatar-wrapper">
                <img src="{{ $user->avatar ? asset($user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'User') . '&size=200&background=3b82f6&color=fff' }}"
                     alt="Avatar"
                     class="profile-avatar"
                     id="avatarPreview">
                <label class="avatar-upload-btn" title="Changer la photo">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                        <circle cx="12" cy="13" r="4"></circle>
                    </svg>
                    <input type="file" id="avatarInput" accept="image/*">
                </label>
            </div>

            <h2 class="profile-name">{{ $user->name ?? 'N/A' }}</h2>
            <p class="profile-email">{{ $user->email ?? 'N/A' }}</p>

            <span class="profile-role">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="8" r="7"></circle>
                    <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                </svg>
                {{ ucfirst($user->role ?? 'Employé') }}
            </span>

            <div class="profile-stats">
                <div class="stat-item">
                    <span class="stat-value">{{ $user->created_at ? $user->created_at->diffInDays(now()) : 0 }}</span>
                    <span class="stat-label">Jours</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">{{ $user->department ?? 'N/A' }}</span>
                    <span class="stat-label">Département</span>
                </div>
            </div>
        </div>

        <!-- Form Sections -->
        <div class="form-sections">
            <!-- Personal Information -->
            <div class="form-section">
                <div class="section-header">
                    <div class="section-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div>
                        <h3 class="section-title">Informations Personnelles</h3>
                        <p class="section-description">Mettez à jour vos informations personnelles</p>
                    </div>
                </div>
                <div class="section-body">
                    @if(session('success'))
                    <div class="alert alert-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-error">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        {{ session('error') }}
                    </div>
                    @endif

                    <form id="profileForm" method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-row">
                            <div class="form-group">
                                <label for="name" class="form-label required">Nom complet</label>
                                <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                                <div class="form-error" id="errorName">{{ $errors->first('name') }}</div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label required">Email</label>
                                <input type="email" id="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                                <div class="form-error" id="errorEmail">{{ $errors->first('email') }}</div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone" class="form-label">Téléphone</label>
                                <input type="tel" id="phone" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}">
                                <div class="form-error" id="errorPhone">{{ $errors->first('phone') }}</div>
                            </div>

                            <div class="form-group">
                                <label for="department" class="form-label">Département</label>
                                <input type="text" id="department" name="department" class="form-input" value="{{ old('department', $user->department) }}" disabled>
                                <p class="form-help">Contactez un administrateur pour modifier</p>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn btn-secondary" onclick="window.location.reload()">Annuler</button>
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                                Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password -->
            <div class="form-section">
                <div class="section-header">
                    <div class="section-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="section-title">Sécurité</h3>
                        <p class="section-description">Changez votre mot de passe</p>
                    </div>
                </div>
                <div class="section-body">
                    <form id="passwordForm" method="POST" action="{{ route('profile.password') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="current_password" class="form-label required">Mot de passe actuel</label>
                            <input type="password" id="current_password" name="current_password" class="form-input" required>
                            <div class="form-error" id="errorCurrentPassword">{{ $errors->first('current_password') }}</div>
                        </div>

                        <div class="form-group">
                            <label for="new_password" class="form-label required">Nouveau mot de passe</label>
                            <input type="password" id="new_password" name="new_password" class="form-input" required>
                            <div class="password-strength" id="passwordStrength">
                                <div class="password-strength-bar" id="passwordStrengthBar"></div>
                            </div>
                            <p class="password-strength-text" id="passwordStrengthText"></p>
                            <div class="form-error" id="errorNewPassword">{{ $errors->first('new_password') }}</div>
                            <p class="form-help">Minimum 6 caractères</p>
                        </div>

                        <div class="form-group">
                            <label for="new_password_confirmation" class="form-label required">Confirmer le nouveau mot de passe</label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-input" required>
                            <div class="form-error" id="errorNewPasswordConfirmation">{{ $errors->first('new_password_confirmation') }}</div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn btn-secondary" onclick="document.getElementById('passwordForm').reset()">Annuler</button>
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 1v6m0 6v6m5.657-13.657l-4.243 4.243m-2.828 2.828l-4.243 4.243m16.97 1.414l-4.243-4.243m-2.828-2.828l-4.243-4.243"></path>
                                </svg>
                                Changer le mot de passe
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/profile.js') }}"></script>
@endsection
