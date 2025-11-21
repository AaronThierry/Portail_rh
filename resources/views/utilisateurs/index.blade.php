@extends('layouts.app')

@section('title', 'Gestion des Utilisateurs')

@section('page-title', 'Comptes Utilisateurs')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/users.css') }}">
@endsection

@section('content')
<div class="users-page">
    {{-- Page Header --}}
    <div class="users-header">
        <div class="users-header-content">
            <h1>Comptes Utilisateurs</h1>
            <p>Gérez les accès et permissions pour votre personnel</p>
        </div>
        @can('create-users')
        <button class="btn btn-primary" id="btnAddUser">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="8.5" cy="7" r="4"></circle>
                <line x1="20" y1="8" x2="20" y2="14"></line>
                <line x1="23" y1="11" x2="17" y2="11"></line>
            </svg>
            Créer un compte
        </button>
        @endcan
    </div>

    {{-- Statistics Cards --}}
    <div class="users-stats">
        <div class="stat-card stat-total">
            <div class="stat-header">
                <div>
                    <div class="stat-value" data-count="{{ $users->count() }}">0</div>
                    <div class="stat-label">Total Comptes</div>
                </div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card stat-active">
            <div class="stat-header">
                <div>
                    <div class="stat-value" data-count="{{ $users->where('status', 'active')->count() }}">0</div>
                    <div class="stat-label">Comptes Actifs</div>
                </div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card stat-inactive">
            <div class="stat-header">
                <div>
                    <div class="stat-value" data-count="{{ $users->where('status', 'inactive')->count() }}">0</div>
                    <div class="stat-label">Comptes Inactifs</div>
                </div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card stat-warning">
            <div class="stat-header">
                <div>
                    <div class="stat-value" data-count="{{ $users->filter(fn($u) => !$u->personnel)->count() }}">0</div>
                    <div class="stat-label">Sans Personnel</div>
                </div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="users-toolbar">
        <div class="search-container">
            <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
            <input type="search" class="search-input" id="searchInput" placeholder="Rechercher par nom, email ou rôle...">
        </div>
        <div class="toolbar-actions">
            <button class="btn btn-secondary" id="btnFilter">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                </svg>
                Filtrer
            </button>
        </div>
    </div>

    {{-- Users Table --}}
    <div class="users-table-container">
        <table class="users-table">
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Personnel Associé</th>
                    <th>Rôle</th>
                    <th>Statut</th>
                    <th>2FA</th>
                    <th>Créé le</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="usersTableBody">
                @forelse($users as $user)
                <tr data-user-id="{{ $user->id }}">
                    <td>
                        <div class="user-cell">
                            <img src="{{ $user->avatar ? asset($user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=6366f1&color=fff' }}"
                                 alt="Avatar" class="user-avatar">
                            <div class="user-info">
                                <span class="user-name">{{ $user->name }}</span>
                                <span class="user-email">{{ $user->email }}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($user->personnel)
                            <a href="{{ route('personnels.show', $user->personnel->id) }}" class="personnel-link">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                {{ $user->personnel->matricule }} - {{ $user->personnel->nom_complet }}
                            </a>
                        @else
                            <span class="no-personnel">Aucun personnel lié</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $roles = $user->getRoleNames();
                            $roleName = $roles->first() ?? 'Aucun rôle';
                            $badgeClass = match($roleName) {
                                'Super Admin' => 'badge-danger',
                                'Admin' => 'badge-primary',
                                'Manager' => 'badge-info',
                                'RH' => 'badge-warning',
                                default => 'badge-success'
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $roleName }}</span>
                    </td>
                    <td>
                        <span class="badge {{ $user->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                            {{ $user->status === 'active' ? 'Actif' : 'Inactif' }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $user->google2fa_enabled ? 'badge-success' : 'badge-danger' }}">
                            {{ $user->google2fa_enabled ? 'Activé' : 'Désactivé' }}
                        </span>
                    </td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('utilisateurs.show', $user->id) }}" class="btn-icon btn-view" title="Voir">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </a>
                            @can('edit-users')
                            <button class="btn-icon btn-edit" title="Modifier" onclick="editUser({{ $user->id }})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </button>
                            @endcan
                            @can('delete-users')
                            <button class="btn-icon btn-delete" title="Supprimer" onclick="deleteUser({{ $user->id }})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                            </button>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <svg class="empty-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <h3 class="empty-title">Aucun compte utilisateur</h3>
                            <p class="empty-description">Commencez par créer un compte pour votre personnel</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Create/Edit User - Premium Wizard --}}
<div class="modal-overlay" id="userModal">
    <div class="modal-user modal-wizard">
        {{-- Header avec Fermeture --}}
        <div class="modal-user-header">
            <div class="modal-header-content">
                <div class="modal-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="8.5" cy="7" r="4"></circle>
                        <line x1="20" y1="8" x2="20" y2="14"></line>
                        <line x1="23" y1="11" x2="17" y2="11"></line>
                    </svg>
                </div>
                <div>
                    <h2 class="modal-title" id="modalTitle">Créer un Compte Utilisateur</h2>
                    <p class="modal-subtitle">En 3 étapes simples</p>
                </div>
            </div>
            <button class="modal-close-btn" data-modal-close aria-label="Fermer">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        {{-- Progress Steps --}}
        <div class="wizard-steps">
            <div class="step-item active" data-step="1">
                <div class="step-number">1</div>
                <span class="step-label">Employé</span>
            </div>
            <div class="step-divider"></div>
            <div class="step-item" data-step="2">
                <div class="step-number">2</div>
                <span class="step-label">Email</span>
            </div>
            <div class="step-divider"></div>
            <div class="step-item" data-step="3">
                <div class="step-number">3</div>
                <span class="step-label">Accès</span>
            </div>
        </div>

        <form id="userForm" action="{{ route('utilisateurs.store') }}">
            @csrf
            <input type="hidden" id="userId" name="user_id">

            <div class="modal-user-body">
                {{-- ÉTAPE 1: Sélection Personnel --}}
                <div class="wizard-step active" data-step="1">
                    <div class="step-content">
                        <h3 class="step-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            Sélectionner l'employé
                        </h3>
                        <p class="step-description">Choisissez l'employé pour qui vous voulez créer un compte</p>

                        <div class="form-field">
                            <label for="personnel_id" class="field-label">
                                <span class="label-text">Employé</span>
                                <span class="label-required">*</span>
                            </label>
                            <div class="select-wrapper">
                                <select id="personnel_id" name="personnel_id" class="field-input field-select" required>
                                    <option value="">-- Choisir un employé --</option>
                                @foreach($personnels_sans_compte ?? [] as $personnel)
                                <option value="{{ $personnel->id }}"
                                        data-email="{{ $personnel->email }}"
                                        data-phone="{{ $personnel->telephone_complet }}"
                                        data-department="{{ $personnel->departement->nom ?? 'N/A' }}">
                                    {{ $personnel->matricule }} - {{ $personnel->nom_complet }}
                                    @if($personnel->poste)
                                    ({{ $personnel->poste }})
                                    @endif
                                </option>
                                @endforeach
                            </select>
                            <svg class="select-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </div>
                    </div>

                        {{-- Aperçu des informations de l'employé sélectionné --}}
                        <div class="employee-preview" id="employeePreview" style="display: none;">
                            <div class="preview-card">
                                <div class="preview-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                        <polyline points="22,6 12,13 2,6"></polyline>
                                    </svg>
                                    <span id="previewEmail">email@example.com</span>
                                </div>
                                <div class="preview-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                    </svg>
                                    <span id="previewPhone">+226 XX XX XX XX</span>
                                </div>
                                <div class="preview-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                    </svg>
                                    <span id="previewDepartment">Département</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ÉTAPE 2: Email --}}
                <div class="wizard-step" data-step="2">
                    <div class="step-content">
                        <h3 class="step-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            Configurer l'email
                        </h3>
                        <p class="step-description">Saisissez l'adresse email professionnelle pour le compte</p>

                        <div class="form-field">
                            <label for="userEmail" class="field-label">
                                <span class="label-text">Adresse email</span>
                                <span class="label-required">*</span>
                            </label>
                            <div class="email-input-wrapper">
                                <input type="email"
                                       id="userEmail"
                                       name="email"
                                       class="field-input"
                                       placeholder="prenom.nom@entreprise.com"
                                       required>
                                <div class="email-validation-icon" id="emailValidIcon" style="display: none;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </div>
                            </div>
                            <div class="email-feedback" id="emailFeedback"></div>
                        </div>

                        <div class="info-box-small">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="16" x2="12" y2="12"></line>
                                <line x1="12" y1="8" x2="12.01" y2="8"></line>
                            </svg>
                            <span>L'utilisateur recevra ses identifiants de connexion par email</span>
                        </div>
                    </div>
                </div>

                {{-- ÉTAPE 3: Rôle et Statut --}}
                <div class="wizard-step" data-step="3">
                    <div class="step-content">
                        <h3 class="step-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path d="M12 1v6m0 6v6m6-12l-6 6m0 0l-6 6m12 0l-6-6m0 0l-6-6"></path>
                            </svg>
                            Définir les accès
                        </h3>
                        <p class="step-description">Choisissez le rôle et le statut du compte utilisateur</p>

                        <div class="form-grid">
                            <div class="form-field">
                                <label for="userRole" class="field-label">
                                    <span class="label-text">Rôle</span>
                                    <span class="label-required">*</span>
                                </label>
                                <div class="select-wrapper">
                                    <select id="userRole" name="role" class="field-input field-select" required>
                                        <option value="">-- Choisir un rôle --</option>
                                        @if(auth()->user()->hasRole('Super Admin'))
                                        <option value="Super Admin">🔐 Super Administrateur</option>
                                        @endif
                                        <option value="Admin">👨‍💼 Administrateur</option>
                                        <option value="Manager">📊 Manager</option>
                                        <option value="RH">👥 Ressources Humaines</option>
                                        <option value="Employé">👤 Employé</option>
                                    </select>
                                    <svg class="select-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </div>
                            </div>

                            <div class="form-field">
                                <label for="userStatus" class="field-label">
                                    <span class="label-text">Statut du compte</span>
                                    <span class="label-required">*</span>
                                </label>
                                <div class="select-wrapper">
                                    <select id="userStatus" name="status" class="field-input field-select" required>
                                        <option value="active" selected>✅ Actif</option>
                                        <option value="inactive">🚫 Inactif</option>
                                    </select>
                                    <svg class="select-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="info-box-small">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="16" x2="12" y2="12"></line>
                                <line x1="12" y1="8" x2="12.01" y2="8"></line>
                            </svg>
                            <span><strong>Mot de passe :</strong> Généré automatiquement et envoyé par email/WhatsApp</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Wizard Navigation --}}
            <div class="modal-user-footer wizard-nav">
                <button type="button" class="btn-wizard btn-prev" id="btnPrev" style="display: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                    Précédent
                </button>
                <button type="button" class="btn-cancel" data-modal-close>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                    Annuler
                </button>
                <button type="button" class="btn-wizard btn-next" id="btnNext">
                    Suivant
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
                <button type="submit" class="btn-submit btn-create" id="btnSubmit" style="display: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="8.5" cy="7" r="4"></circle>
                        <line x1="20" y1="8" x2="20" y2="14"></line>
                        <line x1="23" y1="11" x2="17" y2="11"></line>
                    </svg>
                    <span id="btnSubmitText">Créer le compte</span>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
/* ========================================
   MODALE UTILISATEUR - DESIGN ULTRA PREMIUM
   ======================================== */

.modal-user {
    background: white;
    border-radius: 16px;
    width: 100%;
    max-width: 620px;
    max-height: 90vh;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    box-shadow:
        0 20px 60px -10px rgba(99, 102, 241, 0.25),
        0 0 0 1px rgba(99, 102, 241, 0.08);
    animation: modalSlideIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-40px) scale(0.94);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* Header */
.modal-user-header {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    padding: 20px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: none;
}

/* Wizard Steps Progress */
.wizard-steps {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 18px 24px;
    background: #f8f9fc;
    border-bottom: 1px solid #e5e7eb;
}

.step-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
}

.step-number {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #e5e7eb;
    color: #9ca3af;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 14px;
    transition: all 0.3s ease;
}

.step-item.active .step-number {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: white;
}

.step-item.completed .step-number {
    background: #10b981;
    color: white;
}

.step-item.completed .step-number::after {
    content: '✓';
    font-size: 16px;
    font-weight: 900;
}

.step-label {
    font-size: 11px;
    font-weight: 600;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.step-item.active .step-label {
    color: #6366f1;
}

.step-item.completed .step-label {
    color: #10b981;
}

.step-divider {
    width: 70px;
    height: 2px;
    background: #e5e7eb;
    margin: 0 12px 24px;
    position: relative;
    transition: background 0.3s ease;
}

.step-item.completed + .step-divider {
    background: #10b981;
}

/* Wizard Steps Content */
.wizard-step {
    display: none;
}

.wizard-step.active {
    display: block;
    animation: fadeSlideIn 0.4s ease;
}

@keyframes fadeSlideIn {
    from {
        opacity: 0;
        transform: translateX(20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.step-content {
    padding: 0;
}

.step-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 6px 0;
}

.step-title svg {
    display: none;
}

.step-description {
    font-size: 0.875rem;
    color: #64748b;
    margin: 0 0 20px 0;
    line-height: 1.5;
}

/* Email Input with Validation */
.email-input-wrapper {
    position: relative;
}

.email-validation-icon {
    display: none;
}

.email-feedback {
    margin-top: 6px;
    font-size: 0.75rem;
    font-weight: 500;
    min-height: 16px;
}

.email-feedback.valid {
    color: #10b981;
}

.email-feedback.invalid {
    color: #ef4444;
}

.info-box-small {
    display: flex;
    gap: 10px;
    padding: 12px 14px;
    background: #eff6ff;
    border-radius: 8px;
    border-left: 3px solid #3b82f6;
    margin-top: 16px;
    font-size: 0.8125rem;
    color: #1e40af;
    line-height: 1.5;
}

.info-box-small svg {
    flex-shrink: 0;
    color: #3b82f6;
    width: 14px;
    height: 14px;
    margin-top: 1px;
}

/* Wizard Navigation Buttons */
.wizard-nav {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

.btn-wizard {
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
    cursor: pointer;
    border: none;
}

.btn-prev {
    background: #f3f4f6;
    color: #4b5563;
    border: 1px solid #d1d5db;
}

.btn-prev:hover {
    background: #e5e7eb;
}

.btn-next {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: white;
}

.btn-next:hover {
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
}

.btn-create {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.btn-create:hover:not(:disabled) {
    background: linear-gradient(135deg, #059669, #047857);
}

.btn-create:disabled,
.btn-next:disabled,
.btn-wizard:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.modal-header-content {
    display: flex;
    align-items: center;
    gap: 12px;
}

.modal-icon {
    display: none;
}

.modal-user-header .modal-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: white;
    margin: 0;
}

.modal-subtitle {
    display: none;
}

.modal-close-btn {
    width: 32px;
    height: 32px;
    background: rgba(255, 255, 255, 0.2);
    border: none;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
}

.modal-close-btn:hover {
    background: rgba(255, 255, 255, 0.3);
}

.modal-close-btn svg {
    stroke: white;
    width: 18px;
    height: 18px;
}

/* Body */
.modal-user-body {
    flex: 1;
    overflow-y: auto;
    padding: 24px;
    background: white;
    min-height: 300px;
}

.modal-user-body::-webkit-scrollbar {
    width: 6px;
}

.modal-user-body::-webkit-scrollbar-track {
    background: #f3f4f6;
}

.modal-user-body::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 3px;
}

.modal-user-body::-webkit-scrollbar-thumb:hover {
    background: #9ca3af;
}

/* Form Sections */
.form-section {
    margin-bottom: 24px;
}

.form-section:last-of-type {
    margin-bottom: 0;
}

.section-header {
    display: none;
}

/* Form Fields */
.form-field {
    margin-bottom: 18px;
}

.field-label {
    display: flex;
    align-items: center;
    gap: 4px;
    margin-bottom: 8px;
}

.label-text {
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
}

.label-required {
    color: #ef4444;
    font-size: 1rem;
}

.field-input {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 0.9375rem;
    font-weight: 500;
    color: #1f2937;
    background: white;
    transition: all 0.2s ease;
}

.field-input:hover {
    border-color: #9ca3af;
}

.field-input:focus {
    outline: none;
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

/* Select Wrapper */
.select-wrapper {
    position: relative;
}

.field-select {
    appearance: none;
    padding-right: 40px;
    cursor: pointer;
}

.field-select:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    background: #f9fafb;
}

.select-icon {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    stroke: #6b7280;
    width: 16px;
    height: 16px;
}

/* Form Grid */
.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
    margin-bottom: 0;
}

/* Employee Preview */
.employee-preview {
    margin-top: 16px;
}

.preview-card {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 14px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.preview-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.875rem;
    color: #4b5563;
    font-weight: 500;
}

.preview-item svg {
    stroke: #6b7280;
    flex-shrink: 0;
    width: 14px;
    height: 14px;
}

/* Info Box */
.info-box {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.06) 0%, rgba(5, 150, 105, 0.06) 100%);
    border: 2px solid rgba(16, 185, 129, 0.2);
    border-radius: 16px;
    padding: 20px;
    display: flex;
    gap: 16px;
    margin-top: 24px;
}

.info-icon {
    width: 42px;
    height: 42px;
    background: rgba(16, 185, 129, 0.12);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.info-icon svg {
    stroke: #10b981;
}

.info-content {
    flex: 1;
}

.info-title {
    font-size: 0.9375rem;
    font-weight: 700;
    color: #10b981;
    margin: 0 0 12px 0;
}

.info-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.info-list li {
    font-size: 0.875rem;
    color: #475569;
    font-weight: 600;
    line-height: 1.5;
}

.info-list strong {
    color: #1e293b;
}

/* Footer */
.modal-user-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding: 16px 20px;
    border-top: 1px solid #e5e7eb;
    background: #fafbfc;
    flex-shrink: 0;
}

.btn-cancel,
.btn-submit {
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
    border: none;
}

.btn-cancel {
    background: #f3f4f6;
    color: #4b5563;
    border: 1px solid #d1d5db;
}

.btn-cancel:hover {
    background: #e5e7eb;
}

.btn-submit {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: white;
}

.btn-submit:hover:not(:disabled) {
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
}

.btn-submit:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Responsive */
@media (max-width: 768px) {
    .modal-user {
        max-width: 95%;
        border-radius: 12px;
    }

    .modal-user-header {
        padding: 16px 20px;
    }

    .wizard-steps {
        padding: 14px 20px;
    }

    .step-number {
        width: 32px;
        height: 32px;
        font-size: 12px;
    }

    .step-label {
        font-size: 10px;
    }

    .step-divider {
        width: 50px;
        margin: 0 8px 20px;
    }

    .modal-user-body {
        padding: 20px;
    }

    .form-grid {
        grid-template-columns: 1fr;
        gap: 14px;
    }

    .modal-user-footer {
        padding: 14px 16px;
    }

    .btn-wizard {
        flex: 1;
        justify-content: center;
    }
}

/* Dark Mode via classe JavaScript */
.dark-mode .modal-user {
    background: #1f2937;
    box-shadow:
        0 20px 60px -10px rgba(0, 0, 0, 0.5),
        0 0 0 1px rgba(99, 102, 241, 0.2);
}

.dark-mode .wizard-steps {
    background: #111827;
    border-bottom: 1px solid #374151;
}

.dark-mode .step-number {
    background: #374151;
    color: #9ca3af;
}

.dark-mode .step-label {
    color: #6b7280;
}

.dark-mode .step-item.active .step-label {
    color: #818cf8;
}

.dark-mode .step-divider {
    background: #374151;
}

.dark-mode .modal-user-body {
    background: #1f2937;
}

.dark-mode .modal-user-body::-webkit-scrollbar-track {
    background: #111827;
}

.dark-mode .modal-user-body::-webkit-scrollbar-thumb {
    background: #4b5563;
}

.dark-mode .modal-user-body::-webkit-scrollbar-thumb:hover {
    background: #6b7280;
}

.dark-mode .step-title {
    color: #f9fafb;
}

.dark-mode .step-description {
    color: #9ca3af;
}

.dark-mode .label-text {
    color: #d1d5db;
}

.dark-mode .field-input {
    background: #111827;
    border-color: #374151;
    color: #f9fafb;
}

.dark-mode .field-input:hover {
    border-color: #4b5563;
}

.dark-mode .field-input:focus {
    border-color: #6366f1;
    background: #1f2937;
}

.dark-mode .field-select:disabled {
    background: #111827;
    color: #6b7280;
}

.dark-mode .select-icon {
    stroke: #9ca3af;
}

.dark-mode .preview-card {
    background: #111827;
    border-color: #374151;
}

.dark-mode .preview-item {
    color: #d1d5db;
}

.dark-mode .preview-item svg {
    stroke: #9ca3af;
}

.dark-mode .info-box-small {
    background: rgba(59, 130, 246, 0.1);
    border-left-color: #3b82f6;
    color: #93c5fd;
}

.dark-mode .info-box-small svg {
    color: #60a5fa;
}

.dark-mode .modal-user-footer {
    background: #111827;
    border-top-color: #374151;
}

.dark-mode .btn-prev {
    background: #374151;
    color: #d1d5db;
    border-color: #4b5563;
}

.dark-mode .btn-prev:hover {
    background: #4b5563;
}

.dark-mode .btn-cancel {
    background: #374151;
    color: #d1d5db;
    border-color: #4b5563;
}

.dark-mode .btn-cancel:hover {
    background: #4b5563;
}
</style>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/users.js') }}"></script>
<script>
// Dark Mode Detection and Application - Sync with site theme
function applyDarkMode() {
    const isDark = document.documentElement.classList.contains('dark');
    const modalUser = document.querySelector('.modal-user');

    if (modalUser) {
        if (isDark) {
            modalUser.classList.add('dark-mode');
        } else {
            modalUser.classList.remove('dark-mode');
        }
    }
}

// Apply dark mode on page load
document.addEventListener('DOMContentLoaded', applyDarkMode);

// Listen for dark mode changes via MutationObserver
const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
        if (mutation.attributeName === 'class') {
            applyDarkMode();
        }
    });
});

// Observe the <html> element for class changes
observer.observe(document.documentElement, {
    attributes: true,
    attributeFilter: ['class']
});

// Counter animation on load
document.addEventListener('DOMContentLoaded', () => {
    const stats = document.querySelectorAll('.stat-value[data-count]');
    stats.forEach((stat, index) => {
        const target = parseInt(stat.getAttribute('data-count'));
        const duration = 1000;
        const increment = target / (duration / 16);
        let current = 0;

        setTimeout(() => {
            const animate = () => {
                current += increment;
                if (current >= target) {
                    stat.textContent = target;
                } else {
                    stat.textContent = Math.floor(current);
                    requestAnimationFrame(animate);
                }
            };
            animate();
        }, index * 100);
    });

    // Aperçu des informations de l'employé sélectionné
    const personnelSelect = document.getElementById('personnel_id');
    const employeePreview = document.getElementById('employeePreview');
    const previewEmail = document.getElementById('previewEmail');
    const previewPhone = document.getElementById('previewPhone');
    const previewDepartment = document.getElementById('previewDepartment');

    if (personnelSelect) {
        personnelSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];

            if (this.value && selectedOption) {
                const email = selectedOption.getAttribute('data-email') || 'Non renseigné';
                const phone = selectedOption.getAttribute('data-phone') || 'Non renseigné';
                const department = selectedOption.getAttribute('data-department') || 'N/A';

                previewEmail.textContent = email;
                previewPhone.textContent = phone;
                previewDepartment.textContent = department;

                employeePreview.style.display = 'block';
            } else {
                employeePreview.style.display = 'none';
            }
        });
    }

    // Vérifier que le sidebar fonctionne correctement
    const sidebar = document.getElementById('sidebar');
    const mobileMenuButton = document.getElementById('mobileMenuButton');

    console.log('🔍 Sidebar element:', sidebar);
    console.log('🔍 Mobile menu button:', mobileMenuButton);

    // S'assurer que le sidebar n'est pas bloqué par la page utilisateurs
    if (sidebar) {
        console.log('✅ Sidebar présent et fonctionnel');
        console.log('📊 Sidebar z-index:', window.getComputedStyle(sidebar).zIndex);
    } else {
        console.error('❌ Sidebar non trouvé!');
    }

    // Test du mobile menu button
    if (mobileMenuButton) {
        console.log('✅ Bouton menu mobile présent');
        mobileMenuButton.addEventListener('click', function() {
            console.log('🎯 Menu mobile cliqué - sidebar devrait s\'ouvrir');
        }, { once: false, passive: true });
    }
});
</script>
@endsection
