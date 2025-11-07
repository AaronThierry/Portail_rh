@extends('layouts.app')

@section('title', 'Gestion des Entreprises')

@section('styles')
<style>
/* Page Container */
.entreprises-page {
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

.btn-primary:active {
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
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

.entreprises-table {
    width: 100%;
    border-collapse: collapse;
}

.entreprises-table thead {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-bottom: 2px solid rgba(102, 126, 234, 0.3);
}

.entreprises-table th {
    padding: 18px 20px;
    text-align: left;
    font-size: 0.813rem;
    font-weight: 700;
    color: #ffffff;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    white-space: nowrap;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

.entreprises-table td {
    padding: 16px 20px;
    border-bottom: 1px solid var(--card-border);
    color: var(--text-primary);
    font-size: 0.9375rem;
}

.entreprises-table tbody tr {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
}

.entreprises-table tbody tr:hover {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    transform: translateY(-1px);
}

.entreprises-table tbody tr:last-child td {
    border-bottom: none;
}

.dark .entreprises-table tbody tr:hover {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
    box-shadow: 0 2px 12px rgba(102, 126, 234, 0.2);
}

/* Company Cell */
.company-cell {
    display: flex;
    align-items: center;
    gap: 12px;
}

.company-logo {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    object-fit: cover;
    border: 2px solid var(--card-border);
}

.company-logo-placeholder {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #ffffff;
    font-weight: 700;
    font-size: 0.875rem;
}

.company-info {
    display: flex;
    flex-direction: column;
}

.company-name {
    font-weight: 600;
    color: var(--text-primary);
}

.company-sigle {
    font-size: 0.8125rem;
    color: var(--text-muted);
}

/* Badge */
.badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    white-space: nowrap;
    letter-spacing: 0.3px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
}

.badge:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.badge-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #ffffff;
}

.badge-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: #ffffff;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 8px;
}

.btn-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 2px solid transparent;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    background: rgba(148, 163, 184, 0.1);
    color: #64748b;
}

.btn-icon:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.btn-icon.btn-view {
    background: rgba(59, 130, 246, 0.1);
    color: #3b82f6;
}

.btn-icon.btn-view:hover {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: #ffffff;
    border-color: #3b82f6;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.btn-icon.btn-edit {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
}

.btn-icon.btn-edit:hover {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #ffffff;
    border-color: #10b981;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.btn-icon.btn-delete {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
}

.btn-icon.btn-delete:hover {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: #ffffff;
    border-color: #ef4444;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
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

/* Notification */
.notification {
    padding: 16px 24px;
    border-radius: 10px;
    margin-bottom: 24px;
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

    .entreprises-table {
        font-size: 0.875rem;
    }

    .entreprises-table th,
    .entreprises-table td {
        padding: 12px 16px;
    }
}
</style>
@endsection

@section('content')
<div class="entreprises-page">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Gestion des Entreprises</h1>
            <p class="page-description">Gérez les entreprises du portail RH</p>
        </div>
        <a href="{{ route('entreprises.create') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            Nouvelle Entreprise
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="notification success">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="20 6 9 17 4 12"></polyline>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="notification error">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="12"></line>
            <line x1="12" y1="16" x2="12.01" y2="16"></line>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    <!-- Toolbar -->
    <div class="table-toolbar">
        <div class="search-box">
            <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
            <input type="search" placeholder="Rechercher une entreprise..." id="searchInput">
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-card">
        <div class="table-container">
            <table class="entreprises-table">
                <thead>
                    <tr>
                        <th>Entreprise</th>
                        <th>Contact</th>
                        <th>Localisation</th>
                        <th>Employés</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($entreprises as $entreprise)
                    <tr>
                        <td>
                            <div class="company-cell">
                                @if($entreprise->logo)
                                <img src="{{ asset($entreprise->logo) }}" alt="{{ $entreprise->nom }}" class="company-logo">
                                @else
                                <div class="company-logo-placeholder">
                                    {{ strtoupper(substr($entreprise->nom, 0, 2)) }}
                                </div>
                                @endif
                                <div class="company-info">
                                    <span class="company-name">{{ $entreprise->nom }}</span>
                                    @if($entreprise->sigle)
                                    <span class="company-sigle">{{ $entreprise->sigle }}</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>{{ $entreprise->email }}</div>
                            @if($entreprise->telephone)
                            <div style="font-size: 0.8125rem; color: var(--text-muted);">{{ $entreprise->telephone }}</div>
                            @endif
                        </td>
                        <td>
                            <div>{{ $entreprise->ville ?? '-' }}</div>
                            <div style="font-size: 0.8125rem; color: var(--text-muted);">{{ $entreprise->pays }}</div>
                        </td>
                        <td>{{ $entreprise->nombre_employes ?? 'N/A' }}</td>
                        <td>
                            @if($entreprise->is_active)
                            <span class="badge badge-success">Active</span>
                            @else
                            <span class="badge badge-danger">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('entreprises.show', $entreprise->id) }}" class="btn-icon btn-view" title="Voir les détails">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </a>
                                <a href="{{ route('entreprises.edit', $entreprise->id) }}" class="btn-icon btn-edit" title="Modifier">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('entreprises.destroy', $entreprise->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette entreprise ?');">
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
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <svg class="empty-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <h3 class="empty-title">Aucune entreprise enregistrée</h3>
                                <p class="empty-description">Commencez par créer votre première entreprise</p>
                                <a href="{{ route('entreprises.create') }}" class="btn btn-primary" style="margin-top: 20px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    Créer une entreprise
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Search functionality
document.getElementById('searchInput')?.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('.entreprises-table tbody tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});
</script>
@endsection
