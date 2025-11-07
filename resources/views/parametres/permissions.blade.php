@extends('layouts.app')

@section('title', 'Gestion des Permissions')

@section('styles')
<style>
:root {
    --perm-primary: #10b981;
    --perm-secondary: #059669;
    --perm-danger: #ef4444;
    --perm-info: #3b82f6;
}

/* Page Container */
.permissions-page {
    padding: 2rem;
    min-height: 100vh;
    background: linear-gradient(135deg, #f0fdf4 0%, #d1fae5 100%);
}

/* Hero Section */
.permissions-hero {
    background: linear-gradient(135deg, var(--perm-primary) 0%, var(--perm-secondary) 100%);
    border-radius: 24px;
    padding: 3rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(16, 185, 129, 0.4);
}

.permissions-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
    border-radius: 50%;
}

.permissions-hero::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -5%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    border-radius: 50%;
}

.permissions-hero-content {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 2rem;
}

.permissions-hero-left {
    flex: 1;
    min-width: 300px;
}

.permissions-hero-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: white;
    margin: 0 0 0.5rem 0;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    letter-spacing: -0.5px;
}

.permissions-hero-subtitle {
    font-size: 1.125rem;
    color: rgba(255, 255, 255, 0.95);
    margin: 0 0 1.5rem 0;
}

.permissions-stats {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.stat-card {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.25);
    border-radius: 16px;
    padding: 1.25rem 1.5rem;
    min-width: 150px;
}

.stat-value {
    font-size: 2.5rem;
    font-weight: 800;
    color: white;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.875rem;
    color: rgba(255, 255, 255, 0.9);
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 600;
}

.btn-add-permission {
    background: white;
    color: var(--perm-primary);
    padding: 1rem 2rem;
    border-radius: 16px;
    font-weight: 700;
    font-size: 1rem;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.btn-add-permission:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
}

/* Permissions Grid */
.permissions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
    gap: 1.5rem;
}

.permission-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    border: 2px solid transparent;
}

.permission-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 6px;
    background: linear-gradient(135deg, var(--perm-primary) 0%, var(--perm-secondary) 100%);
}

.permission-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 60px rgba(16, 185, 129, 0.25);
    border-color: var(--perm-primary);
}

.permission-card-header {
    padding: 2rem;
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.05) 0%, rgba(5, 150, 105, 0.05) 100%);
}

.permission-card-top {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    margin-bottom: 1rem;
}

.permission-avatar {
    width: 64px;
    height: 64px;
    background: linear-gradient(135deg, var(--perm-primary) 0%, var(--perm-secondary) 100%);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    font-weight: 800;
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.35);
    flex-shrink: 0;
}

.permission-info {
    flex: 1;
    min-width: 0;
}

.permission-name {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1a202c;
    margin: 0 0 0.5rem 0;
    word-break: break-word;
}

.permission-guard {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.25rem 0.75rem;
    background: linear-gradient(135deg, var(--perm-info) 0%, #2563eb 100%);
    color: white;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.permission-date {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #718096;
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

.permission-card-body {
    padding: 2rem;
}

.permission-description {
    color: #4a5568;
    font-size: 0.938rem;
    line-height: 1.6;
    margin-bottom: 1.5rem;
    min-height: 48px;
}

.permission-roles-section {
    margin-bottom: 1.5rem;
    padding-top: 1.5rem;
    border-top: 2px solid #e2e8f0;
}

.permission-roles-title {
    font-size: 0.875rem;
    font-weight: 700;
    color: #4a5568;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.75rem;
}

.permission-roles-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.role-tag {
    padding: 0.5rem 1rem;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.12) 0%, rgba(118, 75, 162, 0.12) 100%);
    color: #667eea;
    border-radius: 20px;
    font-size: 0.813rem;
    font-weight: 600;
    border: 2px solid rgba(102, 126, 234, 0.25);
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.no-roles-message {
    color: #a0aec0;
    font-size: 0.875rem;
    font-style: italic;
}

.permission-actions {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem;
}

.btn-action {
    padding: 0.875rem 1rem;
    border-radius: 12px;
    border: none;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-edit {
    background: linear-gradient(135deg, var(--perm-info) 0%, #2563eb 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.btn-edit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
}

.btn-delete {
    background: linear-gradient(135deg, var(--perm-danger) 0%, #dc2626 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

.btn-delete:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
}

/* Modal Styles */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.75);
    backdrop-filter: blur(8px);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 10000;
    animation: fadeIn 0.3s ease;
}

.modal-overlay.show {
    display: flex;
}

.modal-container {
    background: white;
    border-radius: 24px;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
    animation: slideUp 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
}

.modal-header {
    background: linear-gradient(135deg, var(--perm-primary) 0%, var(--perm-secondary) 100%);
    color: white;
    padding: 2rem;
    position: relative;
}

.modal-title {
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0;
}

.modal-close {
    position: absolute;
    top: 1.25rem;
    right: 1.25rem;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    font-size: 1.5rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.modal-close:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: rotate(90deg);
}

.modal-body {
    padding: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.75rem;
    font-size: 0.938rem;
}

.form-control {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.2s ease;
    background: #f7fafc;
}

.form-control:focus {
    outline: none;
    border-color: var(--perm-primary);
    background: white;
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
}

.form-help {
    margin-top: 0.5rem;
    font-size: 0.813rem;
    color: #718096;
}

.modal-footer {
    padding: 1.5rem 2rem;
    background: #f7fafc;
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
}

.btn-modal {
    padding: 0.875rem 1.75rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.938rem;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-cancel {
    background: #e2e8f0;
    color: #4a5568;
}

.btn-cancel:hover {
    background: #cbd5e0;
}

.btn-submit {
    background: linear-gradient(135deg, var(--perm-primary) 0%, var(--perm-secondary) 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
}

/* Alert Styles */
.alert {
    padding: 1.125rem 1.5rem;
    border-radius: 14px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    font-weight: 500;
    animation: slideDown 0.3s ease;
}

.alert-success {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.12) 0%, rgba(5, 150, 105, 0.12) 100%);
    color: #059669;
    border-left: 5px solid var(--perm-primary);
}

.alert-error {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.12) 0%, rgba(220, 38, 38, 0.12) 100%);
    color: #dc2626;
    border-left: 5px solid var(--perm-danger);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 24px;
    border: 3px dashed #e2e8f0;
}

.empty-icon {
    width: 120px;
    height: 120px;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, var(--perm-primary) 0%, var(--perm-secondary) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0.2;
}

.empty-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 0.75rem;
}

.empty-text {
    color: #718096;
    font-size: 1.125rem;
    margin-bottom: 2rem;
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(50px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .permissions-page {
        padding: 1rem;
    }

    .permissions-hero {
        padding: 2rem 1.5rem;
    }

    .permissions-hero-title {
        font-size: 2rem;
    }

    .permissions-grid {
        grid-template-columns: 1fr;
    }

    .permission-actions {
        grid-template-columns: 1fr;
    }

    .permissions-stats {
        flex-direction: column;
    }
}
</style>
@endsection

@section('content')
<div class="permissions-page">
    <!-- Alerts -->
    @if(session('success'))
    <div class="alert alert-success">
        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error">
        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    <!-- Hero Section -->
    <div class="permissions-hero">
        <div class="permissions-hero-content">
            <div class="permissions-hero-left">
                <h1 class="permissions-hero-title">Gestion des Permissions</h1>
                <p class="permissions-hero-subtitle">Contrôlez les accès et les autorisations de votre système</p>
                <div class="permissions-stats">
                    <div class="stat-card">
                        <div class="stat-value">{{ $permissions->count() }}</div>
                        <div class="stat-label">Permissions</div>
                    </div>
                    <div class="stat-card">
                        @php
                            $totalRoles = \Spatie\Permission\Models\Role::count();
                        @endphp
                        <div class="stat-value">{{ $totalRoles }}</div>
                        <div class="stat-label">Rôles</div>
                    </div>
                </div>
            </div>
            <button onclick="showModal('createModal')" class="btn-add-permission">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M12 4v16m8-8H4"/>
                </svg>
                Nouvelle Permission
            </button>
        </div>
    </div>

    <!-- Permissions Grid -->
    @if($permissions->count() > 0)
    <div class="permissions-grid">
        @foreach($permissions as $permission)
        <div class="permission-card">
            <div class="permission-card-header">
                <div class="permission-card-top">
                    <div class="permission-avatar">
                        <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div class="permission-info">
                        <h3 class="permission-name">{{ $permission->name }}</h3>
                        <span class="permission-guard">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            {{ $permission->guard_name }}
                        </span>
                        <div class="permission-date">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Créée le {{ $permission->created_at->format('d/m/Y') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="permission-card-body">
                <div class="permission-description">
                    @php
                        $parts = explode('-', $permission->name);
                        $action = $parts[0] ?? '';
                        $resource = $parts[1] ?? '';

                        $actionTexts = [
                            'view' => 'Consulter',
                            'create' => 'Créer',
                            'edit' => 'Modifier',
                            'delete' => 'Supprimer',
                            'manage' => 'Gérer',
                            'assign' => 'Assigner',
                        ];

                        $resourceTexts = [
                            'users' => 'les utilisateurs',
                            'roles' => 'les rôles',
                            'permissions' => 'les permissions',
                            'entreprises' => 'les entreprises',
                            'departements' => 'les départements',
                            'services' => 'les services',
                            'documents' => 'les documents',
                            'demandes' => 'les demandes',
                            'conges' => 'les congés',
                            'paie' => 'la paie',
                            'rapports' => 'les rapports',
                        ];

                        $actionText = $actionTexts[$action] ?? ucfirst($action);
                        $resourceText = $resourceTexts[$resource] ?? $resource;
                        $description = "Permet de {$actionText} {$resourceText}";
                    @endphp
                    {{ $description }}
                </div>

                <div class="permission-roles-section">
                    <div class="permission-roles-title">Rôles ayant cette permission</div>
                    @if($permission->roles->count() > 0)
                    <div class="permission-roles-tags">
                        @foreach($permission->roles as $role)
                        <span class="role-tag">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            {{ $role->name }}
                        </span>
                        @endforeach
                    </div>
                    @else
                    <div class="no-roles-message">Aucun rôle n'utilise cette permission</div>
                    @endif
                </div>

                <div class="permission-actions">
                    <button onclick="showEditModal({{ $permission->id }}, '{{ addslashes($permission->name) }}')" class="btn-action btn-edit">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Modifier
                    </button>
                    <form action="{{ route('parametres.permissions.destroy', $permission) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette permission ? Cette action est irréversible.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-delete">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="empty-state">
        <div class="empty-icon">
            <svg width="64" height="64" fill="white" viewBox="0 0 24 24">
                <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
        </div>
        <h3 class="empty-title">Aucune permission créée</h3>
        <p class="empty-text">Commencez par créer votre première permission pour contrôler les accès</p>
        <button onclick="showModal('createModal')" class="btn-add-permission">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M12 4v16m8-8H4"/>
            </svg>
            Créer la Première Permission
        </button>
    </div>
    @endif
</div>

<!-- Create Permission Modal -->
<div class="modal-overlay" id="createModal" onclick="if(event.target === this) closeModal('createModal')">
    <div class="modal-container" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3 class="modal-title">Créer une Nouvelle Permission</h3>
            <button onclick="closeModal('createModal')" class="modal-close">&times;</button>
        </div>
        <form action="{{ route('parametres.permissions.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="permission_name" class="form-label">Nom de la Permission *</label>
                    <input type="text" id="permission_name" name="name" class="form-control" required placeholder="Ex: view-users, create-reports">
                    <div class="form-help">Format recommandé : action-ressource (ex: view-users, edit-documents)</div>
                </div>
                <div class="form-group">
                    <label for="guard_name" class="form-label">Guard Name</label>
                    <input type="text" id="guard_name" name="guard_name" class="form-control" value="web" placeholder="web">
                    <div class="form-help">Laisser "web" par défaut dans la plupart des cas</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('createModal')" class="btn-modal btn-cancel">Annuler</button>
                <button type="submit" class="btn-modal btn-submit">Créer la Permission</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Permission Modal -->
<div class="modal-overlay" id="editModal" onclick="if(event.target === this) closeModal('editModal')">
    <div class="modal-container" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3 class="modal-title">Modifier la Permission</h3>
            <button onclick="closeModal('editModal')" class="modal-close">&times;</button>
        </div>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label for="edit_permission_name" class="form-label">Nom de la Permission *</label>
                    <input type="text" id="edit_permission_name" name="name" class="form-control" required>
                    <div class="form-help">Format recommandé : action-ressource (ex: view-users, edit-documents)</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('editModal')" class="btn-modal btn-cancel">Annuler</button>
                <button type="submit" class="btn-modal btn-submit">Mettre à Jour</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function showModal(id) {
    document.getElementById(id).classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    document.getElementById(id).classList.remove('show');
    document.body.style.overflow = '';
}

function showEditModal(permissionId, permissionName) {
    document.getElementById('edit_permission_name').value = permissionName;
    document.getElementById('editForm').action = '{{ url("parametres/permissions") }}/' + permissionId;
    showModal('editModal');
}

// Close modal on Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay').forEach(m => closeModal(m.id));
    }
});
</script>
@endsection
