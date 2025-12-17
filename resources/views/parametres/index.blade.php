@extends('layouts.app')

@section('title', 'Paramètres - Rôles et Permissions')
@section('page-title', 'Paramètres')
@section('page-subtitle', 'Configuration du système')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <circle cx="12" cy="12" r="3"></circle>
    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
</svg>
@endsection

@section('styles')
<style>
/* Modern Tabs Design */
.tabs-container {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow-md);
}

.tabs-header {
    display: flex;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
    border-bottom: 2px solid var(--card-border);
    overflow-x: auto;
}

.tab-button {
    flex: 1;
    min-width: 200px;
    padding: 20px 32px;
    border: none;
    background: transparent;
    color: var(--text-secondary);
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    position: relative;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
}

.tab-button:hover {
    background: rgba(102, 126, 234, 0.1);
    color: var(--primary);
}

.tab-button.active {
    color: var(--primary);
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
}

.tab-button.active::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 3px 3px 0 0;
}

.tab-icon {
    width: 20px;
    height: 20px;
}

.tab-badge {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 700;
    min-width: 24px;
    text-align: center;
}

.tab-content {
    display: none;
    padding: 32px;
    animation: fadeIn 0.3s ease;
}

.tab-content.active {
    display: block;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Page Header */
.page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 32px;
}

.page-title-section {
    display: flex;
    align-items: center;
    gap: 16px;
}

.page-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
}

.page-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
}

.page-description {
    color: var(--text-muted);
    font-size: 0.938rem;
    margin-top: 4px;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 12px;
}

.btn {
    padding: 12px 24px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.938rem;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

.btn-secondary {
    background: var(--bg-tertiary);
    color: var(--text-primary);
    border: 2px solid var(--card-border);
}

.btn-secondary:hover {
    border-color: var(--primary);
    background: rgba(102, 126, 234, 0.1);
}

/* Data Table */
.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table thead {
    background: var(--bg-tertiary);
}

.data-table th {
    padding: 16px;
    text-align: left;
    font-weight: 600;
    font-size: 0.875rem;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid var(--card-border);
}

.data-table td {
    padding: 16px;
    border-bottom: 1px solid var(--card-border);
    color: var(--text-primary);
}

.data-table tbody tr {
    transition: all 0.2s ease;
}

.data-table tbody tr:hover {
    background: rgba(102, 126, 234, 0.05);
}

/* Badges */
.badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 0.813rem;
    font-weight: 600;
    line-height: 1;
}

.badge-primary {
    background: rgba(102, 126, 234, 0.15);
    color: var(--primary);
}

.badge-success {
    background: rgba(16, 185, 129, 0.15);
    color: var(--success);
}

.badge-info {
    background: rgba(59, 130, 246, 0.15);
    color: var(--info);
}

.badge-warning {
    background: rgba(245, 158, 11, 0.15);
    color: var(--warning);
}

/* Action Buttons in Table */
.table-actions {
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
    transition: all 0.2s ease;
    text-decoration: none;
}

.btn-edit {
    background: rgba(59, 130, 246, 0.1);
    color: var(--info);
}

.btn-edit:hover {
    background: var(--info);
    color: white;
    transform: scale(1.1);
}

.btn-delete {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
}

.btn-delete:hover {
    background: var(--danger);
    color: white;
    transform: scale(1.1);
}

.btn-assign {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success);
}

.btn-assign:hover {
    background: var(--success);
    color: white;
    transform: scale(1.1);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 64px 32px;
}

.empty-state-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 24px;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
}

.empty-state-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 8px;
}

.empty-state-description {
    color: var(--text-muted);
    margin-bottom: 24px;
}

/* Alert Messages */
.alert {
    padding: 16px 20px;
    border-radius: 10px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 500;
}

.alert-success {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success);
    border-left: 4px solid var(--success);
}

.alert-error {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
    border-left: 4px solid var(--danger);
}

/* Responsive */
@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }

    .action-buttons {
        width: 100%;
        flex-direction: column;
    }

    .btn {
        width: 100%;
        justify-content: center;
    }

    .tabs-header {
        flex-direction: column;
    }

    .tab-button {
        min-width: auto;
    }

    .data-table {
        display: block;
        overflow-x: auto;
    }
}
</style>
@endsection

@section('content')
<div class="container-fluid" style="padding: 24px;">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title-section">
            <div class="page-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    <path d="M9 12l2 2 4-4"></path>
                </svg>
            </div>
            <div>
                <h1 class="page-title">Rôles & Permissions</h1>
                <p class="page-description">Gérer les rôles utilisateurs et leurs permissions d'accès</p>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
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
            <line x1="15" y1="9" x2="9" y2="15"></line>
            <line x1="9" y1="9" x2="15" y2="15"></line>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    <!-- Tabs Container -->
    <div class="tabs-container">
        <!-- Tabs Header -->
        <div class="tabs-header">
            <button class="tab-button active" data-tab="roles">
                <svg class="tab-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span>Rôles</span>
                <span class="tab-badge">{{ count($roles) }}</span>
            </button>
            <button class="tab-button" data-tab="permissions">
                <svg class="tab-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
                <span>Permissions</span>
                <span class="tab-badge">{{ count($permissions) }}</span>
            </button>
        </div>

        <!-- Roles Tab Content -->
        <div class="tab-content active" id="roles-tab">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary); margin: 0;">
                    Gestion des Rôles
                </h2>
                <button onclick="showCreateRoleModal()" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Créer un Rôle
                </button>
            </div>

            @if(count($roles) > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nom du Rôle</th>
                        <th>Permissions</th>
                        <th>Utilisateurs</th>
                        <th>Date de Création</th>
                        <th style="text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                                    {{ strtoupper(substr($role->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: var(--text-primary);">{{ $role->name }}</div>
                                    <div style="font-size: 0.813rem; color: var(--text-muted);">Guard: {{ $role->guard_name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                                {{ $role->permissions_count }} permission(s)
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-info">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                </svg>
                                {{ $role->users_count }} utilisateur(s)
                            </span>
                        </td>
                        <td>
                            <span style="color: var(--text-muted); font-size: 0.875rem;">
                                {{ $role->created_at->format('d/m/Y') }}
                            </span>
                        </td>
                        <td>
                            <div class="table-actions" style="justify-content: center;">
                                <button onclick="editRole({{ $role->id }}, '{{ $role->name }}')" class="btn-icon btn-edit" title="Modifier">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </button>
                                <button onclick="assignPermissions({{ $role->id }}, '{{ $role->name }}')" class="btn-icon btn-assign" title="Assigner Permissions">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M9 12l2 2 4-4"></path>
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                </button>
                                @if(!in_array($role->name, ['Super Admin', 'Admin']))
                                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce rôle ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon btn-delete" title="Supprimer">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <h3 class="empty-state-title">Aucun rôle défini</h3>
                <p class="empty-state-description">Commencez par créer un rôle pour organiser les permissions de vos utilisateurs</p>
                <button onclick="showCreateRoleModal()" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Créer le Premier Rôle
                </button>
            </div>
            @endif
        </div>

        <!-- Permissions Tab Content -->
        <div class="tab-content" id="permissions-tab">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary); margin: 0;">
                    Gestion des Permissions
                </h2>
                <button onclick="showCreatePermissionModal()" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Créer une Permission
                </button>
            </div>

            @if(count($permissions) > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nom de la Permission</th>
                        <th>Guard</th>
                        <th>Rôles Associés</th>
                        <th>Date de Création</th>
                        <th style="text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissions as $permission)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); display: flex; align-items: center; justify-content: center; color: white;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: var(--text-primary);">{{ $permission->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-info">{{ $permission->guard_name }}</span>
                        </td>
                        <td>
                            <span class="badge badge-success">
                                {{ count($permission->roles) }} rôle(s)
                            </span>
                        </td>
                        <td>
                            <span style="color: var(--text-muted); font-size: 0.875rem;">
                                {{ $permission->created_at->format('d/m/Y') }}
                            </span>
                        </td>
                        <td>
                            <div class="table-actions" style="justify-content: center;">
                                <button onclick="editPermission({{ $permission->id }}, '{{ $permission->name }}')" class="btn-icon btn-edit" title="Modifier">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </button>
                                <form action="{{ route('permissions.destroy', $permission) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette permission ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon btn-delete" title="Supprimer">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                </div>
                <h3 class="empty-state-title">Aucune permission définie</h3>
                <p class="empty-state-description">Créez des permissions pour contrôler l'accès aux fonctionnalités</p>
                <button onclick="showCreatePermissionModal()" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Créer la Première Permission
                </button>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modals will be added via JavaScript -->
<div id="modalContainer"></div>
@endsection

@section('scripts')
<script>
// Tab Switching
document.querySelectorAll('.tab-button').forEach(button => {
    button.addEventListener('click', () => {
        const tabName = button.dataset.tab;

        // Update buttons
        document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');

        // Update content
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
        document.getElementById(`${tabName}-tab`).classList.add('active');
    });
});

// Create Role Modal
function showCreateRoleModal() {
    const modal = `
        <div class="modal-overlay" onclick="closeModal()">
            <div class="modal-content" onclick="event.stopPropagation()" style="max-width: 500px;">
                <div class="modal-header">
                    <h3>Créer un Nouveau Rôle</h3>
                    <button onclick="closeModal()" class="modal-close">&times;</button>
                </div>
                <form action="{{ route('admin.roles.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="role_name">Nom du Rôle *</label>
                            <input type="text" id="role_name" name="name" class="form-control" required placeholder="Ex: Manager, Employee">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="closeModal()" class="btn btn-secondary">Annuler</button>
                        <button type="submit" class="btn btn-primary">Créer le Rôle</button>
                    </div>
                </form>
            </div>
        </div>
    `;
    document.getElementById('modalContainer').innerHTML = modal;
}

// Edit Role
function editRole(id, name) {
    const modal = `
        <div class="modal-overlay" onclick="closeModal()">
            <div class="modal-content" onclick="event.stopPropagation()" style="max-width: 500px;">
                <div class="modal-header">
                    <h3>Modifier le Rôle</h3>
                    <button onclick="closeModal()" class="modal-close">&times;</button>
                </div>
                <form action="/roles/${id}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="role_name">Nom du Rôle *</label>
                            <input type="text" id="role_name" name="name" class="form-control" required value="${name}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="closeModal()" class="btn btn-secondary">Annuler</button>
                        <button type="submit" class="btn btn-primary">Mettre à Jour</button>
                    </div>
                </form>
            </div>
        </div>
    `;
    document.getElementById('modalContainer').innerHTML = modal;
}

// Assign Permissions
function assignPermissions(roleId, roleName) {
    window.location.href = `/roles/${roleId}/permissions`;
}

// Create Permission Modal
function showCreatePermissionModal() {
    const modal = `
        <div class="modal-overlay" onclick="closeModal()">
            <div class="modal-content" onclick="event.stopPropagation()" style="max-width: 500px;">
                <div class="modal-header">
                    <h3>Créer une Nouvelle Permission</h3>
                    <button onclick="closeModal()" class="modal-close">&times;</button>
                </div>
                <form action="{{ route('permissions.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="permission_name">Nom de la Permission *</label>
                            <input type="text" id="permission_name" name="name" class="form-control" required placeholder="Ex: view-users, create-reports">
                            <small style="color: var(--text-muted); font-size: 0.813rem;">Format recommandé: action-resource (ex: view-users)</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="closeModal()" class="btn btn-secondary">Annuler</button>
                        <button type="submit" class="btn btn-primary">Créer la Permission</button>
                    </div>
                </form>
            </div>
        </div>
    `;
    document.getElementById('modalContainer').innerHTML = modal;
}

// Edit Permission
function editPermission(id, name) {
    const modal = `
        <div class="modal-overlay" onclick="closeModal()">
            <div class="modal-content" onclick="event.stopPropagation()" style="max-width: 500px;">
                <div class="modal-header">
                    <h3>Modifier la Permission</h3>
                    <button onclick="closeModal()" class="modal-close">&times;</button>
                </div>
                <form action="/permissions/${id}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="permission_name">Nom de la Permission *</label>
                            <input type="text" id="permission_name" name="name" class="form-control" required value="${name}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="closeModal()" class="btn btn-secondary">Annuler</button>
                        <button type="submit" class="btn btn-primary">Mettre à Jour</button>
                    </div>
                </form>
            </div>
        </div>
    `;
    document.getElementById('modalContainer').innerHTML = modal;
}

// Close Modal
function closeModal() {
    document.getElementById('modalContainer').innerHTML = '';
}

// Modal Styles
const modalStyles = document.createElement('style');
modalStyles.textContent = `
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
        z-index: 10000;
        animation: fadeIn 0.2s ease;
    }

    .modal-content {
        background: var(--card-bg);
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        animation: slideUp 0.3s ease;
    }

    .modal-header {
        padding: 24px 28px;
        border-bottom: 2px solid var(--card-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    .modal-close {
        width: 36px;
        height: 36px;
        border: none;
        background: var(--bg-tertiary);
        color: var(--text-secondary);
        font-size: 24px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .modal-close:hover {
        background: var(--danger);
        color: white;
    }

    .modal-body {
        padding: 28px;
    }

    .modal-footer {
        padding: 20px 28px;
        border-top: 2px solid var(--card-border);
        display: flex;
        gap: 12px;
        justify-content: flex-end;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.938rem;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid var(--card-border);
        border-radius: 10px;
        font-size: 0.938rem;
        color: var(--text-primary);
        background: var(--bg-tertiary);
        transition: all 0.2s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;
document.head.appendChild(modalStyles);
</script>
@endsection
