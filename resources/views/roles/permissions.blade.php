@extends('layouts.app')

@section('title', 'Assigner Permissions - ' . $role->name)

@section('styles')
<style>
:root {
    --assign-primary: #8b5cf6;
    --assign-secondary: #7c3aed;
    --assign-success: #10b981;
    --assign-danger: #ef4444;
}

/* Page Container */
.assign-page {
    padding: 2rem;
    min-height: 100vh;
    background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%);
}

/* Hero Section */
.assign-hero {
    background: linear-gradient(135deg, var(--assign-primary) 0%, var(--assign-secondary) 100%);
    border-radius: 24px;
    padding: 2.5rem 3rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(139, 92, 246, 0.4);
}

.assign-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
    border-radius: 50%;
}

.assign-hero-content {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 2rem;
}

.assign-hero-left {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.role-avatar-large {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    font-weight: 800;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.assign-hero-text h1 {
    font-size: 2rem;
    font-weight: 800;
    color: white;
    margin: 0 0 0.5rem 0;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

.assign-hero-text p {
    font-size: 1.125rem;
    color: rgba(255, 255, 255, 0.95);
    margin: 0;
}

.role-name-highlight {
    font-weight: 800;
    color: white;
    background: rgba(255, 255, 255, 0.2);
    padding: 0.25rem 0.75rem;
    border-radius: 8px;
}

.btn-back {
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 0.875rem 1.75rem;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-back:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateX(-5px);
}

/* Main Container */
.assign-container {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 2rem;
}

/* Left Panel - Permissions */
.permissions-panel {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.panel-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid #e5e7eb;
}

.panel-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a202c;
}

.quick-actions {
    display: flex;
    gap: 0.75rem;
}

.btn-quick {
    padding: 0.625rem 1.25rem;
    border-radius: 10px;
    border: 2px solid #e5e7eb;
    background: white;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-select-all {
    border-color: var(--assign-success);
    color: var(--assign-success);
}

.btn-select-all:hover {
    background: var(--assign-success);
    color: white;
}

.btn-deselect-all {
    border-color: var(--assign-danger);
    color: var(--assign-danger);
}

.btn-deselect-all:hover {
    background: var(--assign-danger);
    color: white;
}

/* Categories */
.categories-container {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.category-block {
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.05) 0%, rgba(124, 58, 237, 0.05) 100%);
    border: 2px solid rgba(139, 92, 246, 0.15);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.category-block:hover {
    border-color: var(--assign-primary);
    box-shadow: 0 4px 20px rgba(139, 92, 246, 0.15);
}

.category-header {
    padding: 1.25rem 1.5rem;
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.08) 0%, rgba(124, 58, 237, 0.08) 100%);
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    transition: all 0.2s ease;
}

.category-header:hover {
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.12) 0%, rgba(124, 58, 237, 0.12) 100%);
}

.category-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.category-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, var(--assign-primary) 0%, var(--assign-secondary) 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
}

.category-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1a202c;
    text-transform: capitalize;
}

.category-count {
    padding: 0.375rem 0.875rem;
    background: rgba(139, 92, 246, 0.15);
    color: var(--assign-primary);
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 700;
}

.btn-toggle-category {
    padding: 0.5rem 1rem;
    background: rgba(139, 92, 246, 0.1);
    color: var(--assign-primary);
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.813rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-toggle-category:hover {
    background: var(--assign-primary);
    color: white;
}

.category-permissions {
    padding: 1.5rem;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1rem;
}

/* Permission Checkbox */
.permission-checkbox {
    position: relative;
}

.permission-checkbox input[type="checkbox"] {
    position: absolute;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
    z-index: 2;
}

.permission-label {
    display: flex;
    align-items: center;
    gap: 0.875rem;
    padding: 1rem 1.25rem;
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
}

.permission-checkbox input[type="checkbox"]:checked + .permission-label {
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.1) 0%, rgba(124, 58, 237, 0.1) 100%);
    border-color: var(--assign-primary);
    box-shadow: 0 2px 8px rgba(139, 92, 246, 0.2);
}

.permission-checkbox:hover .permission-label {
    border-color: var(--assign-primary);
    transform: translateX(3px);
}

.checkbox-icon {
    width: 24px;
    height: 24px;
    border: 2px solid #d1d5db;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    flex-shrink: 0;
    background: white;
}

.permission-checkbox input[type="checkbox"]:checked + .permission-label .checkbox-icon {
    background: linear-gradient(135deg, var(--assign-primary) 0%, var(--assign-secondary) 100%);
    border-color: var(--assign-primary);
}

.checkbox-icon svg {
    width: 14px;
    height: 14px;
    color: white;
    opacity: 0;
    transition: opacity 0.2s ease;
}

.permission-checkbox input[type="checkbox"]:checked + .permission-label .checkbox-icon svg {
    opacity: 1;
}

.permission-text {
    font-size: 0.938rem;
    font-weight: 500;
    color: #374151;
}

.permission-checkbox input[type="checkbox"]:checked + .permission-label .permission-text {
    color: var(--assign-primary);
    font-weight: 600;
}

/* Right Panel - Summary */
.summary-panel {
    position: sticky;
    top: 2rem;
    height: fit-content;
}

.summary-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.summary-header {
    text-align: center;
    margin-bottom: 2rem;
}

.summary-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1rem;
    background: linear-gradient(135deg, var(--assign-primary) 0%, var(--assign-secondary) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3);
}

.summary-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1a202c;
    margin-bottom: 0.5rem;
}

.summary-subtitle {
    font-size: 0.875rem;
    color: #6b7280;
}

/* Stats */
.stats-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.stat-box {
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.08) 0%, rgba(124, 58, 237, 0.08) 100%);
    padding: 1.25rem;
    border-radius: 14px;
    text-align: center;
    border: 2px solid rgba(139, 92, 246, 0.15);
}

.stat-value {
    font-size: 2rem;
    font-weight: 800;
    background: linear-gradient(135deg, var(--assign-primary) 0%, var(--assign-secondary) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.813rem;
    color: #6b7280;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Progress Bar */
.progress-section {
    margin-bottom: 1.5rem;
}

.progress-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.75rem;
}

.progress-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
}

.progress-percentage {
    font-size: 0.875rem;
    font-weight: 700;
    color: var(--assign-primary);
}

.progress-bar-container {
    width: 100%;
    height: 12px;
    background: #e5e7eb;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
}

.progress-bar {
    height: 100%;
    background: linear-gradient(135deg, var(--assign-primary) 0%, var(--assign-secondary) 100%);
    border-radius: 20px;
    transition: width 0.3s ease;
    box-shadow: 0 2px 4px rgba(139, 92, 246, 0.4);
}

/* Action Buttons */
.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.btn-primary {
    width: 100%;
    padding: 1rem 1.5rem;
    background: linear-gradient(135deg, var(--assign-primary) 0%, var(--assign-secondary) 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-weight: 700;
    font-size: 1rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(139, 92, 246, 0.4);
}

.btn-secondary {
    width: 100%;
    padding: 1rem 1.5rem;
    background: #f3f4f6;
    color: #374151;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.938rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    transition: all 0.2s ease;
    text-decoration: none;
}

.btn-secondary:hover {
    background: #e5e7eb;
    border-color: #d1d5db;
}

/* Alert */
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
    border-left: 5px solid #10b981;
}

/* Animations */
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
@media (max-width: 1024px) {
    .assign-container {
        grid-template-columns: 1fr;
    }

    .summary-panel {
        position: relative;
        top: 0;
    }

    .category-permissions {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .assign-page {
        padding: 1rem;
    }

    .assign-hero {
        padding: 2rem 1.5rem;
    }

    .assign-hero-text h1 {
        font-size: 1.5rem;
    }

    .quick-actions {
        flex-direction: column;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection

@section('content')
<div class="assign-page">
    <!-- Alerts -->
    @if(session('success'))
    <div class="alert alert-success">
        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    <!-- Hero Section -->
    <div class="assign-hero">
        <div class="assign-hero-content">
            <div class="assign-hero-left">
                <div class="role-avatar-large">
                    {{ strtoupper(substr($role->name, 0, 2)) }}
                </div>
                <div class="assign-hero-text">
                    <h1>Assigner les Permissions</h1>
                    <p>Configurez les accès pour le rôle <span class="role-name-highlight">{{ $role->name }}</span></p>
                </div>
            </div>
            <a href="{{ route('parametres.roles') }}" class="btn-back">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour aux Rôles
            </a>
        </div>
    </div>

    <form action="{{ route('parametres.roles.permissions.update', $role) }}" method="POST" id="permissionsForm">
        @csrf
        @method('PUT')

        <div class="assign-container">
            <!-- Left Panel - Permissions -->
            <div class="permissions-panel">
                <div class="panel-header">
                    <h2 class="panel-title">Sélectionnez les Permissions</h2>
                    <div class="quick-actions">
                        <button type="button" onclick="selectAll()" class="btn-quick btn-select-all">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Tout Sélectionner
                        </button>
                        <button type="button" onclick="deselectAll()" class="btn-quick btn-deselect-all">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Tout Désélectionner
                        </button>
                    </div>
                </div>

                <div class="categories-container">
                    @foreach($groupedPermissions as $category => $perms)
                    <div class="category-block">
                        <div class="category-header" onclick="toggleCategory('{{ $category }}')">
                            <div class="category-info">
                                <div class="category-icon">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="category-title">{{ ucfirst($category) }}</div>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <span class="category-count">{{ count($perms) }}</span>
                                <button type="button" onclick="event.stopPropagation(); toggleCategoryPermissions('{{ $category }}')" class="btn-toggle-category">
                                    Sélectionner Tout
                                </button>
                            </div>
                        </div>

                        <div class="category-permissions" id="category-{{ $category }}">
                            @foreach($perms as $permission)
                            <div class="permission-checkbox">
                                <input
                                    type="checkbox"
                                    name="permissions[]"
                                    value="{{ $permission->id }}"
                                    id="perm-{{ $permission->id }}"
                                    data-category="{{ $category }}"
                                    {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}
                                    onchange="updateCounter()"
                                >
                                <label for="perm-{{ $permission->id }}" class="permission-label">
                                    <div class="checkbox-icon">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <span class="permission-text">{{ $permission->name }}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Right Panel - Summary -->
            <div class="summary-panel">
                <div class="summary-card">
                    <div class="summary-header">
                        <div class="summary-icon">
                            <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <h3 class="summary-title">Résumé</h3>
                        <p class="summary-subtitle">Permissions sélectionnées</p>
                    </div>

                    <div class="stats-grid">
                        <div class="stat-box">
                            <div class="stat-value" id="selected-count">{{ count($rolePermissions) }}</div>
                            <div class="stat-label">Sélectionnées</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-value">{{ $permissions->count() }}</div>
                            <div class="stat-label">Total</div>
                        </div>
                    </div>

                    <div class="progress-section">
                        <div class="progress-header">
                            <span class="progress-label">Progression</span>
                            <span class="progress-percentage" id="progress-percentage">
                                {{ $permissions->count() > 0 ? round((count($rolePermissions) / $permissions->count()) * 100) : 0 }}%
                            </span>
                        </div>
                        <div class="progress-bar-container">
                            <div class="progress-bar" id="progress-bar" style="width: {{ $permissions->count() > 0 ? (count($rolePermissions) / $permissions->count()) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <button type="submit" class="btn-primary">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M5 13l4 4L19 7"/>
                            </svg>
                            Enregistrer les Permissions
                        </button>
                        <a href="{{ route('parametres.roles') }}" class="btn-secondary">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Annuler
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
const totalPermissions = {{ $permissions->count() }};

function selectAll() {
    document.querySelectorAll('input[name="permissions[]"]').forEach(checkbox => {
        checkbox.checked = true;
    });
    updateCounter();
}

function deselectAll() {
    document.querySelectorAll('input[name="permissions[]"]').forEach(checkbox => {
        checkbox.checked = false;
    });
    updateCounter();
}

function toggleCategory(category) {
    const categoryDiv = document.getElementById('category-' + category);
    if (categoryDiv.style.display === 'none') {
        categoryDiv.style.display = 'grid';
    } else {
        categoryDiv.style.display = 'none';
    }
}

function toggleCategoryPermissions(category) {
    const checkboxes = document.querySelectorAll(`input[data-category="${category}"]`);
    const allChecked = Array.from(checkboxes).every(cb => cb.checked);

    checkboxes.forEach(checkbox => {
        checkbox.checked = !allChecked;
    });

    updateCounter();
}

function updateCounter() {
    const checked = document.querySelectorAll('input[name="permissions[]"]:checked').length;
    const percentage = totalPermissions > 0 ? Math.round((checked / totalPermissions) * 100) : 0;

    document.getElementById('selected-count').textContent = checked;
    document.getElementById('progress-percentage').textContent = percentage + '%';
    document.getElementById('progress-bar').style.width = percentage + '%';
}

// Initialize counter on page load
document.addEventListener('DOMContentLoaded', function() {
    updateCounter();
});
</script>
@endsection
