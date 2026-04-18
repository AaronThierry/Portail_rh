@extends('layouts.app')

@section('title', 'Modifier l\'utilisateur')

@section('content')
<style>
:root {
    --ind: #6366f1; --ind-d: #4338ca; --ind-900: #312e81;
    --teal: #14b8a6; --teal-d: #0d9488;
    --gray-50: #f8fafc; --gray-100: #f1f5f9; --gray-200: #e2e8f0;
    --gray-400: #94a3b8; --gray-600: #475569; --gray-700: #334155; --gray-900: #0f172a;
}
.edit-wrap { max-width: 680px; margin: 0 auto; padding: 32px 16px; }
.edit-back { display:inline-flex; align-items:center; gap:8px; color:var(--gray-600);
    font-size:.875rem; font-weight:500; text-decoration:none; margin-bottom:24px;
    transition:color .2s; }
.edit-back:hover { color:var(--ind); }
.edit-back svg { width:18px; height:18px; }
.edit-card { background:#fff; border-radius:20px; border:1px solid var(--gray-200);
    overflow:hidden; box-shadow:0 4px 24px rgba(99,102,241,.08); }
.edit-header { background:linear-gradient(135deg,var(--ind-900),var(--ind-d),#1d4ed8);
    padding:28px 32px; color:#fff; }
.edit-header h1 { font-size:1.25rem; font-weight:700; margin:0 0 4px 0; }
.edit-header p { font-size:.875rem; opacity:.75; margin:0; }
.edit-body { padding:32px; }
.edit-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
.edit-field { display:flex; flex-direction:column; gap:6px; }
.edit-field.full { grid-column:1/-1; }
.edit-label { font-size:.8125rem; font-weight:600; color:var(--gray-700); }
.edit-input, .edit-select {
    padding:11px 14px; border:1.5px solid var(--gray-200); border-radius:10px;
    font-size:.875rem; color:var(--gray-900); background:#fff;
    transition:border-color .2s, box-shadow .2s; outline:none; width:100%; box-sizing:border-box;
}
.edit-input:focus, .edit-select:focus {
    border-color:var(--ind); box-shadow:0 0 0 3px rgba(99,102,241,.12);
}
.edit-hint { font-size:.75rem; color:var(--gray-400); }
.edit-divider { grid-column:1/-1; border:none; border-top:1px solid var(--gray-100); margin:4px 0; }
.edit-footer { display:flex; justify-content:flex-end; gap:12px; padding:20px 32px;
    background:var(--gray-50); border-top:1px solid var(--gray-200); flex-shrink:0; }
.btn-cancel { padding:11px 24px; border-radius:10px; font-size:.875rem; font-weight:600;
    background:#fff; color:var(--gray-600); border:1.5px solid var(--gray-200);
    cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:8px;
    transition:all .2s; }
.btn-cancel:hover { background:var(--gray-100); }
.btn-save { padding:11px 28px; border-radius:10px; font-size:.875rem; font-weight:600;
    background:linear-gradient(135deg,var(--ind-d),var(--ind));
    color:#fff; border:none; cursor:pointer; display:inline-flex; align-items:center; gap:8px;
    box-shadow:0 4px 14px rgba(99,102,241,.35); transition:all .2s; }
.btn-save:hover { transform:translateY(-1px); box-shadow:0 6px 18px rgba(99,102,241,.45); }
.btn-save svg, .btn-cancel svg { width:16px; height:16px; }
.edit-alert { padding:12px 16px; border-radius:10px; font-size:.875rem; margin-bottom:20px;
    display:flex; align-items:center; gap:10px; }
.edit-alert.success { background:#d1fae5; color:#065f46; border:1px solid #6ee7b7; }
.edit-alert.error   { background:#fee2e2; color:#991b1b; border:1px solid #fca5a5; }
</style>

<div class="edit-wrap">
    <a href="{{ route('admin.utilisateurs.show', $user->id) }}" class="edit-back">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Retour au profil
    </a>

    @if(session('success'))
    <div class="edit-alert success">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="edit-alert error">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        {{ $errors->first() }}
    </div>
    @endif

    <div class="edit-card">
        <div class="edit-header">
            <h1>Modifier l'utilisateur</h1>
            <p>{{ $user->name }} &mdash; {{ $user->email }}</p>
        </div>

        <form action="{{ route('admin.utilisateurs.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="edit-body">
                <div class="edit-grid">
                    <div class="edit-field full">
                        <label class="edit-label">Nom complet *</label>
                        <input type="text" name="name" class="edit-input"
                               value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="edit-field">
                        <label class="edit-label">Adresse email *</label>
                        <input type="email" name="email" class="edit-input"
                               value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="edit-field">
                        <label class="edit-label">Téléphone</label>
                        <input type="text" name="phone" class="edit-input"
                               value="{{ old('phone', $user->phone ?? '') }}"
                               placeholder="+226 XX XX XX XX">
                    </div>

                    <hr class="edit-divider">

                    <div class="edit-field">
                        <label class="edit-label">Rôle *</label>
                        <select name="role" class="edit-select" required>
                            @if(auth()->user()->hasRole('Super Admin'))
                            <option value="super_admin" {{ ($user->role ?? '') === 'super_admin' ? 'selected' : '' }}>Super Administrateur</option>
                            @endif
                            <option value="admin"    {{ ($user->role ?? '') === 'admin'    ? 'selected' : '' }}>Administrateur</option>
                            <option value="manager"  {{ ($user->role ?? '') === 'manager'  ? 'selected' : '' }}>Manager</option>
                            <option value="hr"       {{ ($user->role ?? '') === 'hr'       ? 'selected' : '' }}>Ressources Humaines</option>
                            <option value="employee" {{ ($user->role ?? '') === 'employee' ? 'selected' : '' }}>Employé</option>
                        </select>
                    </div>

                    <div class="edit-field">
                        <label class="edit-label">Statut *</label>
                        <select name="status" class="edit-select" required>
                            <option value="active"   {{ ($user->status ?? 'active') === 'active'   ? 'selected' : '' }}>Actif</option>
                            <option value="inactive" {{ ($user->status ?? 'active') === 'inactive' ? 'selected' : '' }}>Inactif</option>
                        </select>
                    </div>

                    <div class="edit-field full">
                        <label class="edit-label">Nouveau mot de passe</label>
                        <input type="password" name="password" class="edit-input"
                               placeholder="Laisser vide pour ne pas changer">
                        <span class="edit-hint">Minimum 6 caractères. Laisser vide pour conserver le mot de passe actuel.</span>
                    </div>
                </div>
            </div>

            <div class="edit-footer">
                <a href="{{ route('admin.utilisateurs.show', $user->id) }}" class="btn-cancel">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Annuler
                </a>
                <button type="submit" class="btn-save">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
