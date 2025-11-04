@extends('layouts.app')

@section('title', 'Gestion des Utilisateurs')

@section('styles')
<style>
/* Page Container */
.users-page {
    padding: 24px;
}

/* Page Header */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 32px;
    flex-wrap: wrap;
    gap: 16px;
}

.page-title {
    font-size: 1.875rem;
    font-weight: 700;
    color: var(--text-primary);
}

.page-description {
    color: var(--text-muted);
    font-size: 0.9375rem;
    margin-top: 4px;
}

/* Search and Actions Bar */
.table-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}

.search-box {
    position: relative;
    flex: 1;
    max-width: 400px;
}

.search-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    pointer-events: none;
}

.search-box input {
    width: 100%;
    padding: 12px 16px 12px 44px;
    border: 1px solid var(--card-border);
    border-radius: 10px;
    background: var(--bg-secondary);
    color: var(--text-primary);
    font-size: 0.9375rem;
    transition: var(--transition);
}

.search-box input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
}

.toolbar-actions {
    display: flex;
    gap: 12px;
    align-items: center;
}

/* Buttons */
.btn {
    padding: 12px 20px;
    border-radius: 10px;
    font-size: 0.9375rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary), var(--primary-hover));
    color: white;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4);
}

.btn-secondary {
    background: var(--bg-tertiary);
    color: var(--text-primary);
    border: 1px solid var(--card-border);
}

.btn-secondary:hover {
    background: var(--bg-primary);
}

/* Table Card */
.table-card {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: var(--border-radius);
    overflow: hidden;
}

.table-container {
    overflow-x: auto;
}

.users-table {
    width: 100%;
    border-collapse: collapse;
}

.users-table thead {
    background: var(--bg-tertiary);
    border-bottom: 2px solid var(--card-border);
}

.users-table th {
    padding: 16px 20px;
    text-align: left;
    font-size: 0.8125rem;
    font-weight: 700;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    white-space: nowrap;
}

.users-table td {
    padding: 16px 20px;
    border-bottom: 1px solid var(--card-border);
    color: var(--text-primary);
    font-size: 0.9375rem;
}

.users-table tbody tr {
    transition: var(--transition);
}

.users-table tbody tr:hover {
    background: var(--bg-tertiary);
}

.users-table tbody tr:last-child td {
    border-bottom: none;
}

/* User Avatar */
.user-cell {
    display: flex;
    align-items: center;
    gap: 12px;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--card-border);
}

.user-info {
    display: flex;
    flex-direction: column;
}

.user-name {
    font-weight: 600;
    color: var(--text-primary);
}

.user-email {
    font-size: 0.8125rem;
    color: var(--text-muted);
}

/* Badge */
.badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    white-space: nowrap;
}

.badge-success {
    background: var(--success-light);
    color: var(--success);
}

.badge-danger {
    background: var(--danger-light);
    color: var(--danger);
}

.badge-warning {
    background: var(--warning-light);
    color: var(--warning);
}

.badge-info {
    background: var(--info-light);
    color: var(--info);
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 8px;
}

.btn-icon {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    cursor: pointer;
    transition: var(--transition);
    background: transparent;
    color: var(--text-muted);
}

.btn-icon:hover {
    background: var(--bg-tertiary);
    color: var(--text-primary);
}

.btn-icon.btn-edit:hover {
    background: rgba(59, 130, 246, 0.1);
    color: var(--primary);
}

.btn-icon.btn-delete:hover {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
}

/* Modal */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(4px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2000;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
    padding: 20px;
}

.modal-overlay.show {
    opacity: 1;
    visibility: visible;
}

.modal {
    background: var(--card-bg);
    border-radius: 16px;
    box-shadow: var(--shadow-xl);
    width: 100%;
    max-width: 600px;
    max-height: 90vh;
    overflow: hidden;
    transform: scale(0.9) translateY(20px);
    transition: transform 0.3s ease;
}

.modal-overlay.show .modal {
    transform: scale(1) translateY(0);
}

.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 24px;
    border-bottom: 1px solid var(--card-border);
}

.modal-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
}

.modal-close {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    border: none;
    background: transparent;
    color: var(--text-muted);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition);
}

.modal-close:hover {
    background: var(--bg-tertiary);
    color: var(--text-primary);
}

.modal-body {
    padding: 24px;
    max-height: calc(90vh - 180px);
    overflow-y: auto;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding: 24px;
    border-top: 1px solid var(--card-border);
}

/* Form Styles */
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

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 20px;
    opacity: 0.5;
}

.empty-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 8px;
}

.empty-description {
    color: var(--text-muted);
    font-size: 0.9375rem;
}

/* Responsive */
@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .table-toolbar {
        flex-direction: column;
        align-items: stretch;
    }

    .search-box {
        max-width: 100%;
    }

    .toolbar-actions {
        justify-content: stretch;
    }

    .toolbar-actions .btn {
        flex: 1;
    }

    .users-table {
        font-size: 0.875rem;
    }

    .users-table th,
    .users-table td {
        padding: 12px 16px;
    }

    .modal {
        max-width: 100%;
        margin: 0;
        border-radius: 0;
        max-height: 100vh;
    }

    .modal-body {
        max-height: calc(100vh - 180px);
    }
}
</style>
@endsection

@section('content')
<div class="users-page">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Gestion des Utilisateurs</h1>
            <p class="page-description">Gérez les comptes utilisateurs du portail RH</p>
        </div>
        <button class="btn btn-primary" id="btnAddUser">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="8.5" cy="7" r="4"></circle>
                <line x1="20" y1="8" x2="20" y2="14"></line>
                <line x1="23" y1="11" x2="17" y2="11"></line>
            </svg>
            Ajouter un utilisateur
        </button>
    </div>

    <!-- Toolbar -->
    <div class="table-toolbar">
        <div class="search-box">
            <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
            <input type="search" placeholder="Rechercher un utilisateur..." id="searchInput">
        </div>
        <div class="toolbar-actions">
            <button class="btn btn-secondary" id="btnFilter">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                </svg>
                Filtrer
            </button>
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-card">
        <div class="table-container">
            <table class="users-table">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Rôle</th>
                        <th>Département</th>
                        <th>Téléphone</th>
                        <th>Statut</th>
                        <th>Date d'ajout</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="usersTableBody">
                    @forelse($users ?? [] as $user)
                    <tr data-user-id="{{ $user->id }}">
                        <td>
                            <div class="user-cell">
                                <img src="{{ $user->avatar ? asset($user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'User') . '&background=3b82f6&color=fff' }}" alt="Avatar" class="user-avatar">
                                <div class="user-info">
                                    <span class="user-name">{{ $user->name ?? 'N/A' }}</span>
                                    <span class="user-email">{{ $user->email ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-info">{{ $user->role ?? 'Employé' }}</span>
                        </td>
                        <td>{{ $user->department ?? 'Non assigné' }}</td>
                        <td>{{ $user->phone ?? 'N/A' }}</td>
                        <td>
                            <span class="badge {{ $user->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                                {{ $user->status === 'active' ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td>{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-icon btn-edit" title="Modifier" onclick="editUser({{ $user->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </button>
                                <button class="btn-icon btn-delete" title="Supprimer" onclick="deleteUser({{ $user->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
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
                                <h3 class="empty-title">Aucun utilisateur trouvé</h3>
                                <p class="empty-description">Commencez par ajouter votre premier utilisateur</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Add/Edit User -->
<div class="modal-overlay" id="userModal">
    <div class="modal">
        <div class="modal-header">
            <h2 class="modal-title" id="modalTitle">Ajouter un utilisateur</h2>
            <button class="modal-close" onclick="closeModal()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <form id="userForm">
            @csrf
            <input type="hidden" id="userId" name="user_id">
            <div class="modal-body">
                <div class="form-group">
                    <label for="userName" class="form-label required">Nom complet</label>
                    <input type="text" id="userName" name="name" class="form-input" placeholder="Ex: Jean Dupont" required>
                    <div class="form-error" id="errorName"></div>
                </div>

                <div class="form-group">
                    <label for="userEmail" class="form-label required">Email</label>
                    <input type="email" id="userEmail" name="email" class="form-input" placeholder="jean.dupont@entreprise.com" required>
                    <div class="form-error" id="errorEmail"></div>
                </div>

                <div class="form-group">
                    <label for="userPassword" class="form-label" id="passwordLabel">Mot de passe</label>
                    <input type="password" id="userPassword" name="password" class="form-input" placeholder="••••••••">
                    <div class="form-error" id="errorPassword"></div>
                </div>

                <div class="form-group">
                    <label for="userPhone" class="form-label">Téléphone</label>
                    <input type="tel" id="userPhone" name="phone" class="form-input" placeholder="+33 6 12 34 56 78">
                    <div class="form-error" id="errorPhone"></div>
                </div>

                <div class="form-group">
                    <label for="userRole" class="form-label required">Rôle</label>
                    <select id="userRole" name="role" class="form-select" required>
                        <option value="">Sélectionner un rôle</option>
                        <option value="admin">Administrateur</option>
                        <option value="manager">Manager</option>
                        <option value="employee">Employé</option>
                        <option value="hr">RH</option>
                    </select>
                    <div class="form-error" id="errorRole"></div>
                </div>

                <div class="form-group">
                    <label for="userDepartment" class="form-label">Département</label>
                    <select id="userDepartment" name="department" class="form-select">
                        <option value="">Sélectionner un département</option>
                        <option value="Ressources Humaines">Ressources Humaines</option>
                        <option value="Informatique">Informatique</option>
                        <option value="Finance">Finance</option>
                        <option value="Marketing">Marketing</option>
                        <option value="Ventes">Ventes</option>
                        <option value="Support">Support</option>
                    </select>
                    <div class="form-error" id="errorDepartment"></div>
                </div>

                <div class="form-group">
                    <label for="userStatus" class="form-label required">Statut</label>
                    <select id="userStatus" name="status" class="form-select" required>
                        <option value="active">Actif</option>
                        <option value="inactive">Inactif</option>
                    </select>
                    <div class="form-error" id="errorStatus"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Annuler</button>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    <span id="btnSubmitText">Ajouter</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/users.js') }}"></script>
@endsection
