@extends('layouts.app')

@section('title', 'Détails du Personnel')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
<style>
/* Similar base styles as index but optimized for show page */
.personnel-show {
    padding: 24px;
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.back-button {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--text-muted);
    font-size: 0.9375rem;
    font-weight: 600;
    margin-bottom: 24px;
    transition: all 0.2s ease;
    text-decoration: none;
}

.back-button:hover {
    color: #667eea;
    transform: translateX(-4px);
}

.personnel-header {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 16px;
    padding: 32px;
    margin-bottom: 24px;
    display: flex;
    align-items: start;
    gap: 24px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.personnel-photo {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #667eea;
    box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
}

.personnel-header-content {
    flex: 1;
}

.personnel-name-header {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 8px;
}

.personnel-meta {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
    margin-top: 12px;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.9375rem;
    color: var(--text-muted);
}

.personnel-actions {
    display: flex;
    gap: 12px;
}

.btn {
    padding: 13px 24px;
    border-radius: 12px;
    font-size: 0.938rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #ffffff;
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.5);
}

.btn-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #ffffff;
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(16, 185, 129, 0.5);
}

.btn-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: #ffffff;
    box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
}

.btn-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(239, 68, 68, 0.5);
}

.details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 24px;
}

.detail-card {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.card-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid var(--card-border);
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-label {
    font-weight: 600;
    color: var(--text-muted);
    font-size: 0.875rem;
}

.detail-value {
    font-weight: 500;
    color: var(--text-primary);
    text-align: right;
}

.badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.badge-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #ffffff;
}

.badge-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: #ffffff;
}

.badge-info {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: #ffffff;
}

.badge-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: #ffffff;
}

/* User Assignment Card */
.user-assignment-card {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
    border: 2px solid rgba(102, 126, 234, 0.2);
}

.no-user-alert {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(217, 119, 6, 0.1) 100%);
    border: 2px dashed #f59e0b;
    padding: 20px;
    border-radius: 12px;
    text-align: center;
    margin-bottom: 20px;
}

.no-user-alert p {
    color: #d97706;
    font-weight: 600;
    margin-bottom: 12px;
}

.user-info-display {
    background: var(--bg-secondary);
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 20px;
}

.user-info-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
}

.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(15, 23, 42, 0.75);
    backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.modal-overlay.show {
    opacity: 1;
    visibility: visible;
}

.modal {
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
    width: 100%;
    max-width: 500px;
    transform: scale(0.95);
    transition: transform 0.3s ease;
}

.dark .modal {
    background: #1e293b;
}

.modal-overlay.show .modal {
    transform: scale(1);
}

.modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 24px;
    border-radius: 20px 20px 0 0;
}

.modal-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #ffffff;
}

.modal-body {
    padding: 24px;
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: block;
    font-weight: 600;
    color: var(--text-secondary);
    margin-bottom: 8px;
    font-size: 0.875rem;
}

.form-label.required::after {
    content: '*';
    color: #ef4444;
    margin-left: 4px;
}

.form-input, .form-select {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid var(--card-border);
    border-radius: 10px;
    background: var(--bg-tertiary);
    color: var(--text-primary);
    font-size: 0.9375rem;
    transition: all 0.2s ease;
}

.form-input:focus, .form-select:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
}

.checkbox-wrapper {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px;
    background: var(--bg-secondary);
    border-radius: 8px;
    cursor: pointer;
}

.checkbox-input {
    width: 20px;
    height: 20px;
    cursor: pointer;
    accent-color: #667eea;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding: 24px;
    border-top: 1px solid var(--card-border);
}

@media (max-width: 768px) {
    .personnel-header {
        flex-direction: column;
        text-align: center;
    }

    .personnel-actions {
        width: 100%;
        flex-direction: column;
    }

    .details-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection

@section('content')
<div class="personnel-show">
    <a href="{{ route('personnels.index') }}" class="back-button">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="15 18 9 12 15 6"></polyline>
        </svg>
        Retour à la liste
    </a>

    <!-- Personnel Header -->
    <div class="personnel-header">
        <img src="{{ $personnel->photo ? asset('storage/' . $personnel->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($personnel->nom_complet) . '&size=200&background=667eea&color=fff' }}" alt="Photo" class="personnel-photo">

        <div class="personnel-header-content">
            <h1 class="personnel-name-header">{{ $personnel->nom_complet }}</h1>

            <div class="personnel-meta">
                <div class="meta-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                    </svg>
                    {{ $personnel->matricule }}
                </div>
                <div class="meta-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    {{ $personnel->poste ?? 'Poste non défini' }}
                </div>
                <span class="badge {{ $personnel->is_active ? 'badge-success' : 'badge-danger' }}">
                    {{ $personnel->is_active ? 'Actif' : 'Inactif' }}
                </span>
            </div>
        </div>

        <div class="personnel-actions">
            <button class="btn btn-primary" onclick="editPersonnel()">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
                Modifier
            </button>
        </div>
    </div>

    <!-- Details Grid -->
    <div class="details-grid">
        <!-- Informations Personnelles -->
        <div class="detail-card">
            <h3 class="card-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                Informations Personnelles
            </h3>

            <div class="detail-row">
                <span class="detail-label">Civilité</span>
                <span class="detail-value">{{ $personnel->civilite ?? 'N/A' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Sexe</span>
                <span class="detail-value">{{ $personnel->sexe === 'M' ? 'Masculin' : ($personnel->sexe === 'F' ? 'Féminin' : 'N/A') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Date de Naissance</span>
                <span class="detail-value">{{ $personnel->date_naissance ? $personnel->date_naissance->format('d/m/Y') : 'N/A' }}</span>
            </div>
            @if($personnel->date_naissance)
            <div class="detail-row">
                <span class="detail-label">Âge</span>
                <span class="detail-value">{{ $personnel->age }} ans</span>
            </div>
            @endif
            <div class="detail-row">
                <span class="detail-label">N° Identification</span>
                <span class="detail-value">{{ $personnel->numero_identification ?? 'N/A' }}</span>
            </div>
        </div>

        <!-- Coordonnées -->
        <div class="detail-card">
            <h3 class="card-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                </svg>
                Coordonnées
            </h3>

            <div class="detail-row">
                <span class="detail-label">Adresse</span>
                <span class="detail-value">{{ $personnel->adresse ?? 'N/A' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Téléphone</span>
                <span class="detail-value">
                    {{ $personnel->telephone_complet ?? 'N/A' }}
                    @if($personnel->telephone_whatsapp)
                    <span class="badge badge-success" style="font-size: 0.7rem; margin-left: 8px;">WhatsApp</span>
                    @endif
                </span>
            </div>
        </div>

        <!-- Informations Professionnelles -->
        <div class="detail-card">
            <h3 class="card-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                </svg>
                Informations Professionnelles
            </h3>

            <div class="detail-row">
                <span class="detail-label">Entreprise</span>
                <span class="detail-value">{{ $personnel->entreprise->nom }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Département</span>
                <span class="detail-value">{{ $personnel->departement->nom ?? 'Non assigné' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Service</span>
                <span class="detail-value">{{ $personnel->service->nom ?? 'Non assigné' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Poste</span>
                <span class="detail-value">{{ $personnel->poste ?? 'Non défini' }}</span>
            </div>
        </div>

        <!-- Contrat -->
        <div class="detail-card">
            <h3 class="card-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
                Contrat de Travail
            </h3>

            <div class="detail-row">
                <span class="detail-label">Type de Contrat</span>
                <span class="detail-value">
                    <span class="badge {{ $personnel->type_contrat === 'CDI' ? 'badge-info' : 'badge-warning' }}">
                        {{ $personnel->type_contrat }}
                    </span>
                </span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Date d'Embauche</span>
                <span class="detail-value">{{ $personnel->date_embauche ? $personnel->date_embauche->format('d/m/Y') : 'N/A' }}</span>
            </div>
            @if($personnel->type_contrat === 'CDD' && $personnel->date_fin_contrat)
            <div class="detail-row">
                <span class="detail-label">Date de Fin</span>
                <span class="detail-value">{{ $personnel->date_fin_contrat->format('d/m/Y') }}</span>
            </div>
            @endif
            @if($personnel->date_embauche)
            <div class="detail-row">
                <span class="detail-label">Ancienneté</span>
                <span class="detail-value">{{ $personnel->anciennete }} an(s)</span>
            </div>
            @endif
        </div>

        <!-- User Assignment Card -->
        <div class="detail-card user-assignment-card">
            <h3 class="card-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <polyline points="17 11 19 13 23 9"></polyline>
                </svg>
                Compte Utilisateur
            </h3>

            @if($personnel->hasUser())
            <div class="user-info-display">
                <div class="user-info-row">
                    <span class="detail-label">Email</span>
                    <span class="detail-value">{{ $personnel->user->email }}</span>
                </div>
                <div class="user-info-row">
                    <span class="detail-label">Rôle(s)</span>
                    <span class="detail-value">
                        @foreach($personnel->user->roles as $role)
                        <span class="badge badge-primary">{{ $role->name }}</span>
                        @endforeach
                    </span>
                </div>
                <div class="user-info-row">
                    <span class="detail-label">Statut</span>
                    <span class="detail-value">
                        <span class="badge {{ $personnel->user->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                            {{ $personnel->user->status === 'active' ? 'Actif' : 'Inactif' }}
                        </span>
                    </span>
                </div>
            </div>

            <button class="btn btn-danger" onclick="detachUser()" style="width: 100%;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
                Dissocier le Compte
            </button>
            @else
            <div class="no-user-alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" style="margin: 0 auto 12px; display: block;">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                    <line x1="12" y1="9" x2="12" y2="13"></line>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg>
                <p>Ce personnel n'a pas encore de compte utilisateur</p>
            </div>

            <button class="btn btn-success" onclick="openAssignUserModal()" style="width: 100%;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <line x1="20" y1="8" x2="20" y2="14"></line>
                    <line x1="23" y1="11" x2="17" y2="11"></line>
                </svg>
                Créer un Compte Utilisateur
            </button>
            @endif
        </div>
    </div>
</div>

<!-- Assign User Modal -->
<div class="modal-overlay" id="assignUserModal">
    <div class="modal">
        <div class="modal-header">
            <h2 class="modal-title">Créer un Compte Utilisateur</h2>
        </div>

        <form id="assignUserForm">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="email" class="form-label required">Email</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="email@entreprise.com" required>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Mot de Passe</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Laisser vide pour mot de passe par défaut">
                    <small style="color: var(--text-muted); font-size: 0.8125rem;">Par défaut: password123</small>
                </div>

                <div class="form-group">
                    <label for="role" class="form-label required">Rôle</label>
                    <select id="role" name="role" class="form-select" required>
                        <option value="">Sélectionner un rôle</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Statut du Compte</label>
                    <label class="checkbox-wrapper">
                        <input type="checkbox" name="status" value="active" class="checkbox-input" checked>
                        <span class="checkbox-label">Activer le compte immédiatement</span>
                    </label>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeAssignUserModal()" style="background: #6b7280; color: #fff;">Annuler</button>
                <button type="submit" class="btn btn-success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    Créer le Compte
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Open assign user modal
function openAssignUserModal() {
    document.getElementById('assignUserModal').classList.add('show');
}

// Close assign user modal
function closeAssignUserModal() {
    document.getElementById('assignUserModal').classList.remove('show');
    document.getElementById('assignUserForm').reset();
}

// Assign user
document.getElementById('assignUserForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const submitBtn = e.target.querySelector('button[type="submit"]');

    // Convert checkbox to proper value
    if (!formData.get('status')) {
        formData.set('status', 'inactive');
    }

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span>Création en cours...</span>';

    try {
        const response = await fetch('/personnels/{{ $personnel->id }}/assign-user', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(Object.fromEntries(formData))
        });

        const data = await response.json();

        if (data.success) {
            alert(`Compte créé avec succès!\n\nIdentifiants:\nEmail: ${data.data.credentials.email}\nMot de passe: ${data.data.credentials.password}\n\nVeuillez noter ces informations.`);
            window.location.reload();
        } else {
            alert('Erreur: ' + (data.message || 'Une erreur est survenue'));
        }
    } catch (error) {
        console.error('Erreur:', error);
        alert('Erreur lors de la création du compte');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg> Créer le Compte';
    }
});

// Detach user
async function detachUser() {
    if (!confirm('Êtes-vous sûr de vouloir dissocier ce compte utilisateur?\n\nLe compte sera désactivé mais non supprimé.')) {
        return;
    }

    try {
        const response = await fetch('/personnels/{{ $personnel->id }}/detach-user', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            alert('Compte dissocié avec succès!');
            window.location.reload();
        } else {
            alert('Erreur: ' + (data.message || 'Une erreur est survenue'));
        }
    } catch (error) {
        console.error('Erreur:', error);
        alert('Erreur lors de la dissociation');
    }
}

// Close modal on escape
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeAssignUserModal();
    }
});

// Close modal on overlay click
document.getElementById('assignUserModal').addEventListener('click', (e) => {
    if (e.target.id === 'assignUserModal') {
        closeAssignUserModal();
    }
});
</script>
@endsection
