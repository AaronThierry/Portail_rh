@extends('layouts.app')

@section('title', 'Gestion des Répertoires')

@section('styles')
<style>
:root {
    --rep-primary: #667eea;
    --rep-secondary: #764ba2;
    --rep-success: #10b981;
    --rep-danger: #ef4444;
    --rep-warning: #f59e0b;
}

.repertoires-page {
    padding: 1.5rem;
    min-height: 100vh;
    background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
}

/* Hero Section */
.rep-hero {
    background: linear-gradient(135deg, var(--rep-primary) 0%, var(--rep-secondary) 100%);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 15px 40px rgba(102, 126, 234, 0.3);
}

.rep-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    border-radius: 50%;
}

.rep-hero-content {
    position: relative;
    z-index: 1;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1.5rem;
}

.rep-hero-left h1 {
    font-size: 2rem;
    font-weight: 700;
    color: white;
    margin: 0 0 0.5rem 0;
}

.rep-hero-left p {
    color: rgba(255,255,255,0.9);
    margin: 0;
}

.btn-create {
    background: white;
    color: var(--rep-primary);
    padding: 0.875rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.btn-create:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}

/* Info Box */
.info-box {
    background: white;
    border-radius: 14px;
    padding: 1.25rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    border-left: 4px solid var(--rep-primary);
}

.info-box-icon {
    width: 48px;
    height: 48px;
    background: rgba(102, 126, 234, 0.1);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--rep-primary);
    flex-shrink: 0;
}

.info-box-content h4 {
    margin: 0 0 0.25rem 0;
    font-size: 0.938rem;
    color: #1e293b;
}

.info-box-content p {
    margin: 0;
    font-size: 0.813rem;
    color: #64748b;
}

/* Repertoires Grid */
.repertoires-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.25rem;
}

.repertoire-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 2px solid transparent;
}

.repertoire-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.1);
    border-color: var(--rep-primary);
}

.repertoire-card.inactive {
    opacity: 0.6;
}

.repertoire-header {
    padding: 1.5rem;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.repertoire-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    flex-shrink: 0;
    font-size: 1.5rem;
}

.repertoire-info {
    flex: 1;
    min-width: 0;
}

.repertoire-name {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1e293b;
    margin: 0 0 0.25rem 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.badge-obligatoire {
    background: linear-gradient(135deg, var(--rep-danger) 0%, #dc2626 100%);
    color: white;
    font-size: 0.625rem;
    padding: 0.125rem 0.5rem;
    border-radius: 20px;
    font-weight: 700;
    text-transform: uppercase;
}

.badge-inactive {
    background: #94a3b8;
    color: white;
    font-size: 0.625rem;
    padding: 0.125rem 0.5rem;
    border-radius: 20px;
    font-weight: 700;
}

.repertoire-description {
    font-size: 0.813rem;
    color: #64748b;
    margin: 0;
    line-height: 1.4;
}

.repertoire-stats {
    padding: 1rem 1.5rem;
    background: #f8fafc;
    display: flex;
    justify-content: space-around;
    border-top: 1px solid #e2e8f0;
}

.stat-item {
    text-align: center;
}

.stat-value {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--rep-primary);
}

.stat-label {
    font-size: 0.688rem;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.repertoire-actions {
    padding: 1rem 1.5rem;
    display: flex;
    gap: 0.5rem;
    border-top: 1px solid #e2e8f0;
}

.btn-action {
    flex: 1;
    padding: 0.625rem;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    font-size: 0.813rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.375rem;
    transition: all 0.2s;
}

.btn-edit {
    background: rgba(102, 126, 234, 0.1);
    color: var(--rep-primary);
}

.btn-edit:hover {
    background: rgba(102, 126, 234, 0.2);
}

.btn-delete {
    background: rgba(239, 68, 68, 0.1);
    color: var(--rep-danger);
}

.btn-delete:hover {
    background: rgba(239, 68, 68, 0.2);
}

.btn-toggle {
    background: rgba(245, 158, 11, 0.1);
    color: var(--rep-warning);
}

.btn-toggle:hover {
    background: rgba(245, 158, 11, 0.2);
}

/* Modal */
.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.7);
    backdrop-filter: blur(4px);
    z-index: 10000;
    align-items: center;
    justify-content: center;
}

.modal-overlay.show {
    display: flex;
}

.modal-content {
    background: white;
    border-radius: 20px;
    width: 90%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
}

.modal-header {
    background: linear-gradient(135deg, var(--rep-primary) 0%, var(--rep-secondary) 100%);
    color: white;
    padding: 1.5rem;
    position: relative;
}

.modal-header h3 {
    margin: 0;
    font-size: 1.25rem;
}

.modal-close {
    position: absolute;
    right: 1rem;
    top: 1rem;
    background: rgba(255,255,255,0.2);
    border: none;
    color: white;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 1.25rem;
}

.modal-body {
    padding: 1.5rem;
}

.form-group {
    margin-bottom: 1.25rem;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    font-size: 0.938rem;
    transition: all 0.2s;
}

.form-control:focus {
    outline: none;
    border-color: var(--rep-primary);
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
}

.color-picker-group {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.color-option {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    cursor: pointer;
    border: 3px solid transparent;
    transition: all 0.2s;
}

.color-option:hover {
    transform: scale(1.1);
}

.color-option.selected {
    border-color: #1e293b;
    box-shadow: 0 0 0 2px white, 0 0 0 4px currentColor;
}

.icon-picker-group {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.icon-option {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    cursor: pointer;
    border: 2px solid #e2e8f0;
    background: #f8fafc;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #64748b;
    transition: all 0.2s;
}

.icon-option:hover {
    border-color: var(--rep-primary);
    color: var(--rep-primary);
}

.icon-option.selected {
    border-color: var(--rep-primary);
    background: var(--rep-primary);
    color: white;
}

.form-check {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-check input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: var(--rep-primary);
}

.modal-footer {
    padding: 1rem 1.5rem;
    background: #f8fafc;
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
}

.btn-modal {
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.875rem;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-cancel {
    background: #e2e8f0;
    color: #475569;
}

.btn-submit {
    background: linear-gradient(135deg, var(--rep-primary) 0%, var(--rep-secondary) 100%);
    color: white;
}

.btn-submit:hover {
    transform: translateY(-2px);
}

/* Breadcrumb */
.breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    font-size: 0.875rem;
}

.breadcrumb a {
    color: #64748b;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.breadcrumb a:hover {
    color: var(--rep-primary);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 20px;
    border: 3px dashed #e2e8f0;
}

.empty-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, var(--rep-primary) 0%, var(--rep-secondary) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0.3;
}

/* Responsive */
@media (max-width: 768px) {
    .repertoires-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection

@section('content')
<div class="repertoires-page">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('admin.dossiers-agents.index') }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
            </svg>
            Dossiers Agents
        </a>
        <span style="color: #94a3b8;">/</span>
        <span style="color: #1e293b; font-weight: 500;">Gestion des Répertoires</span>
    </div>

    <!-- Hero Section -->
    <div class="rep-hero">
        <div class="rep-hero-content">
            <div class="rep-hero-left">
                <h1>Répertoires Globaux</h1>
                <p>Définissez les types de documents pour tous les employés de votre entreprise</p>
            </div>
            <button onclick="openCreateModal()" class="btn-create">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 4v16m8-8H4"/>
                </svg>
                Nouveau Répertoire
            </button>
        </div>
    </div>

    <!-- Info Box -->
    <div class="info-box">
        <div class="info-box-icon">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="info-box-content">
            <h4>Comment fonctionnent les répertoires ?</h4>
            <p>Les répertoires que vous créez ici s'appliquent <strong>globalement à tous les employés</strong>. Chaque employé aura ces mêmes catégories dans son dossier pour y déposer les documents correspondants.</p>
        </div>
    </div>

    @if(session('success'))
    <div style="background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    <!-- Répertoires Grid -->
    @if($categories->count() > 0)
    <div class="repertoires-grid">
        @foreach($categories as $categorie)
        <div class="repertoire-card {{ !$categorie->actif ? 'inactive' : '' }}">
            <div class="repertoire-header">
                <div class="repertoire-icon" style="background: {{ $categorie->couleur }};">
                    @include('dossier-agent.partials.icon', ['icon' => $categorie->icone])
                </div>
                <div class="repertoire-info">
                    <h3 class="repertoire-name">
                        {{ $categorie->nom }}
                        @if($categorie->obligatoire)
                        <span class="badge-obligatoire">Obligatoire</span>
                        @endif
                        @if(!$categorie->actif)
                        <span class="badge-inactive">Inactif</span>
                        @endif
                    </h3>
                    <p class="repertoire-description">{{ $categorie->description }}</p>
                </div>
            </div>
            <div class="repertoire-stats">
                <div class="stat-item">
                    <div class="stat-value">{{ $categorie->documents_count }}</div>
                    <div class="stat-label">Documents</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ $categorie->ordre }}</div>
                    <div class="stat-label">Ordre</div>
                </div>
            </div>
            <div class="repertoire-actions">
                <button class="btn-action btn-edit" onclick="openEditModal({{ json_encode($categorie) }})">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Modifier
                </button>
                <button class="btn-action btn-toggle" onclick="toggleCategorie({{ $categorie->id }}, {{ $categorie->actif ? 'false' : 'true' }})">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        @if($categorie->actif)
                        <path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        @else
                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        @endif
                    </svg>
                    {{ $categorie->actif ? 'Masquer' : 'Activer' }}
                </button>
                @if($categorie->documents_count == 0)
                <button class="btn-action btn-delete" onclick="deleteCategorie({{ $categorie->id }}, '{{ addslashes($categorie->nom) }}')">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="empty-state">
        <div class="empty-icon">
            <svg width="40" height="40" fill="white" viewBox="0 0 24 24">
                <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
            </svg>
        </div>
        <h3 style="font-size: 1.5rem; color: #1e293b; margin-bottom: 0.5rem;">Aucun répertoire configuré</h3>
        <p style="color: #64748b; margin-bottom: 1.5rem;">Créez des répertoires pour organiser les documents de vos employés</p>
        <button onclick="initDefaultCategories()" class="btn-create" style="display: inline-flex;">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
            Initialiser les répertoires par défaut
        </button>
    </div>
    @endif
</div>

<!-- Modal Création/Édition -->
<div class="modal-overlay" id="categorieModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Nouveau Répertoire</h3>
            <button class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <form id="categorieForm" method="POST">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nom du répertoire *</label>
                    <input type="text" name="nom" id="categorie_nom" class="form-control" required placeholder="Ex: Contrats, Fiches de poste...">
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" id="categorie_description" class="form-control" rows="2" placeholder="Décrivez le type de documents à stocker..."></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Couleur</label>
                    <div class="color-picker-group">
                        @php
                        $colors = ['#667eea', '#8b5cf6', '#3b82f6', '#10b981', '#06b6d4', '#14b8a6', '#f59e0b', '#ef4444', '#ec4899', '#64748b'];
                        @endphp
                        @foreach($colors as $color)
                        <div class="color-option" style="background: {{ $color }};" data-color="{{ $color }}" onclick="selectColor('{{ $color }}')"></div>
                        @endforeach
                    </div>
                    <input type="hidden" name="couleur" id="categorie_couleur" value="#667eea">
                </div>

                <div class="form-group">
                    <label class="form-label">Icône</label>
                    <div class="icon-picker-group">
                        @php
                        $icons = ['folder', 'briefcase', 'clipboard-list', 'id-card', 'graduation-cap', 'file-text', 'heart-pulse', 'calculator', 'award', 'chart-bar'];
                        @endphp
                        @foreach($icons as $icon)
                        <div class="icon-option" data-icon="{{ $icon }}" onclick="selectIcon('{{ $icon }}')">
                            @include('dossier-agent.partials.icon', ['icon' => $icon])
                        </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="icone" id="categorie_icone" value="folder">
                </div>

                <div class="form-group">
                    <label class="form-label">Ordre d'affichage</label>
                    <input type="number" name="ordre" id="categorie_ordre" class="form-control" min="1" value="1" style="width: 100px;">
                </div>

                <div class="form-check">
                    <input type="checkbox" name="obligatoire" id="categorie_obligatoire" value="1">
                    <label for="categorie_obligatoire">Répertoire obligatoire (documents requis)</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal btn-cancel" onclick="closeModal()">Annuler</button>
                <button type="submit" class="btn-modal btn-submit">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
const categorieModal = document.getElementById('categorieModal');
const categorieForm = document.getElementById('categorieForm');

function openCreateModal() {
    document.getElementById('modalTitle').textContent = 'Nouveau Répertoire';
    document.getElementById('formMethod').value = 'POST';
    categorieForm.action = '{{ route("admin.dossier-agent.categories.store") }}';
    categorieForm.reset();
    selectColor('#667eea');
    selectIcon('folder');
    categorieModal.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function openEditModal(categorie) {
    document.getElementById('modalTitle').textContent = 'Modifier le Répertoire';
    document.getElementById('formMethod').value = 'PUT';
    categorieForm.action = '{{ url("admin/dossier-agent/categories") }}/' + categorie.id;

    document.getElementById('categorie_nom').value = categorie.nom;
    document.getElementById('categorie_description').value = categorie.description || '';
    document.getElementById('categorie_ordre').value = categorie.ordre;
    document.getElementById('categorie_obligatoire').checked = categorie.obligatoire;

    selectColor(categorie.couleur);
    selectIcon(categorie.icone);

    categorieModal.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    categorieModal.classList.remove('show');
    document.body.style.overflow = '';
}

function selectColor(color) {
    document.querySelectorAll('.color-option').forEach(el => el.classList.remove('selected'));
    document.querySelector(`.color-option[data-color="${color}"]`)?.classList.add('selected');
    document.getElementById('categorie_couleur').value = color;
}

function selectIcon(icon) {
    document.querySelectorAll('.icon-option').forEach(el => el.classList.remove('selected'));
    document.querySelector(`.icon-option[data-icon="${icon}"]`)?.classList.add('selected');
    document.getElementById('categorie_icone').value = icon;
}

function toggleCategorie(id, newState) {
    fetch('{{ url("admin/dossier-agent/categories") }}/' + id, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ actif: newState })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) location.reload();
        else alert('Erreur: ' + data.message);
    })
    .catch(() => alert('Erreur lors de la mise à jour'));
}

function deleteCategorie(id, nom) {
    if (confirm(`Êtes-vous sûr de vouloir supprimer le répertoire "${nom}" ?`)) {
        fetch('{{ url("admin/dossier-agent/categories") }}/' + id, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) location.reload();
            else alert('Erreur: ' + data.message);
        })
        .catch(() => alert('Erreur lors de la suppression'));
    }
}

function initDefaultCategories() {
    if (confirm('Voulez-vous créer les répertoires par défaut (Contrats, Fiches de poste, Pièces d\'identité, etc.) ?')) {
        fetch('{{ route("admin.dossier-agent.categories.init") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) location.reload();
            else alert('Erreur: ' + data.message);
        })
        .catch(() => alert('Erreur lors de l\'initialisation'));
    }
}

// Fermer modal
categorieModal.addEventListener('click', e => { if (e.target === categorieModal) closeModal(); });
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

// Init default color/icon
selectColor('#667eea');
selectIcon('folder');
</script>
@endsection
