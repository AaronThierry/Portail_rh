@extends('layouts.app')

@section('title', 'Modifier l\'utilisateur')
@section('page-title', 'Utilisateurs')
@section('page-subtitle', 'Modifier un compte')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
    <circle cx="12" cy="7" r="4"></circle>
</svg>
@endsection

@section('content')
<style>
/* =============================================
   PAGE EDIT UTILISATEUR — même design que index
   ============================================= */
:root {
    --usr-primary: #6366f1;
    --usr-primary-dark: #4338ca;
    --usr-orange: #FF9500;
    --usr-orange-dark: #E68600;
    --usr-success: #10b981;
    --usr-danger: #ef4444;
    --usr-warning: #f59e0b;
    --usr-gray-50: #f9fafb;
    --usr-gray-100: #f3f4f6;
    --usr-gray-200: #e5e7eb;
    --usr-gray-300: #d1d5db;
    --usr-gray-400: #9ca3af;
    --usr-gray-500: #6b7280;
    --usr-gray-600: #4b5563;
    --usr-gray-700: #374151;
    --usr-gray-800: #1f2937;
    --usr-gray-900: #111827;
}

@keyframes usr-fadeIn {
    from { opacity:0; transform:translateY(10px); }
    to   { opacity:1; transform:translateY(0); }
}
@keyframes usr-slideIn {
    from { opacity:0; transform:translateX(-20px); }
    to   { opacity:1; transform:translateX(0); }
}

/* ── Hero ─────────────────────────────────── */
.usr-hero { position:relative; border-radius:20px; overflow:hidden;
    margin-bottom:24px; animation:usr-fadeIn .4s cubic-bezier(.16,1,.3,1) .04s both; }
.usr-hero-bg {
    background:linear-gradient(135deg,#312e81 0%,#4338ca 40%,#0d9488 100%);
    padding:1.875rem 2rem; position:relative;
}
.usr-hero-bg::before {
    content:''; position:absolute; top:-70px; right:-70px; width:260px; height:260px;
    background:radial-gradient(circle,rgba(20,184,166,.35) 0%,transparent 70%);
    border-radius:50%; pointer-events:none;
}
.usr-hero-bg::after {
    content:''; position:absolute; bottom:-50px; left:-50px; width:200px; height:200px;
    background:radial-gradient(circle,rgba(99,102,241,.3) 0%,transparent 70%);
    border-radius:50%; pointer-events:none;
}
.usr-hero-inner {
    position:relative; display:flex; align-items:center;
    justify-content:space-between; gap:1.5rem; flex-wrap:wrap;
}
.usr-hero-left h1 {
    font-family:'Syne',sans-serif; font-size:1.75rem; font-weight:700;
    color:#fff; margin:0 0 .3rem; letter-spacing:-.4px; line-height:1.2;
}
.usr-hero-sub {
    font-size:.875rem; color:rgba(255,255,255,.72); margin:0;
    display:flex; align-items:center; gap:8px;
}
.usr-hero-badge {
    display:inline-flex; align-items:center; gap:6px;
    background:rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.25);
    border-radius:20px; padding:6px 14px; color:#fff; font-size:.8125rem; font-weight:500;
    backdrop-filter:blur(8px);
}
.usr-hero-badge svg { width:14px; height:14px; }

/* ── Breadcrumb / Back ─────────────────────── */
.usr-back-link {
    display:inline-flex; align-items:center; gap:8px;
    color:var(--usr-gray-600); font-size:.875rem; font-weight:500;
    text-decoration:none; margin-bottom:20px;
    transition:color .2s;
}
.usr-back-link:hover { color:var(--usr-primary); }
.usr-back-link svg { width:18px; height:18px; }

/* ── Card ──────────────────────────────────── */
.usr-edit-card {
    background:#fff; border-radius:20px; border:1px solid var(--usr-gray-200);
    box-shadow:0 4px 24px rgba(99,102,241,.08);
    overflow:hidden; animation:usr-fadeIn .45s cubic-bezier(.16,1,.3,1) .1s both;
    display:flex; flex-direction:column;
}
.usr-edit-header {
    background:linear-gradient(135deg,var(--usr-orange),var(--usr-orange-dark));
    padding:24px 28px; display:flex; align-items:center; gap:16px;
}
.usr-edit-icon {
    width:50px; height:50px; background:rgba(255,255,255,.2);
    border-radius:14px; display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.usr-edit-icon svg { width:26px; height:26px; stroke:#fff; }
.usr-edit-title { font-size:1.25rem; font-weight:700; color:#fff; margin:0 0 3px; }
.usr-edit-sub   { font-size:.875rem; color:rgba(255,255,255,.8); margin:0; }

/* ── Body ──────────────────────────────────── */
.usr-edit-body { padding:28px; background:#fff; flex:1; }
.usr-form-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
.usr-form-field { margin-bottom:0; }
.usr-form-field.full { grid-column:1/-1; }
.usr-form-label {
    display:flex; align-items:center; gap:4px;
    margin-bottom:8px; font-size:.875rem; font-weight:600; color:var(--usr-gray-700);
}
.usr-form-label .required { color:var(--usr-danger); }
.usr-form-input, .usr-form-select {
    width:100%; padding:12px 16px; border:1px solid var(--usr-gray-300);
    border-radius:10px; font-size:.9375rem; color:var(--usr-gray-800);
    background:#fff; transition:all .2s ease; box-sizing:border-box; outline:none;
}
.usr-form-input:hover,  .usr-form-select:hover  { border-color:var(--usr-gray-400); }
.usr-form-input:focus,  .usr-form-select:focus  {
    border-color:var(--usr-orange); box-shadow:0 0 0 3px rgba(255,149,0,.1);
}
.usr-select-wrapper { position:relative; }
.usr-select-wrapper select { appearance:none; padding-right:44px; cursor:pointer; }
.usr-select-wrapper::after {
    content:''; position:absolute; right:16px; top:50%; transform:translateY(-50%);
    width:0; height:0; border-left:5px solid transparent; border-right:5px solid transparent;
    border-top:6px solid var(--usr-gray-400); pointer-events:none;
}
.usr-form-hint { font-size:.75rem; color:var(--usr-gray-400); margin-top:5px; }
.usr-form-divider { grid-column:1/-1; border:none; border-top:1px solid var(--usr-gray-100); }
.usr-section-label {
    grid-column:1/-1; font-size:.75rem; font-weight:700; text-transform:uppercase;
    letter-spacing:.08em; color:var(--usr-gray-400); padding-top:4px;
}

/* ── Footer ─────────────────────────────────── */
.usr-edit-footer {
    display:flex; justify-content:flex-end; gap:12px;
    padding:20px 28px; background:var(--usr-gray-50);
    border-top:1px solid var(--usr-gray-200); flex-shrink:0;
}
.usr-btn { padding:12px 24px; border-radius:10px; font-size:.875rem; font-weight:600;
    cursor:pointer; display:inline-flex; align-items:center; gap:8px;
    transition:all .2s; border:none; text-decoration:none; }
.usr-btn svg { width:18px; height:18px; }
.usr-btn-secondary {
    background:#fff; color:var(--usr-gray-600); border:1px solid var(--usr-gray-300);
}
.usr-btn-secondary:hover { background:var(--usr-gray-100); }
.usr-btn-primary {
    background:linear-gradient(135deg,var(--usr-orange),var(--usr-orange-dark));
    color:#fff; box-shadow:0 4px 12px rgba(255,149,0,.3);
}
.usr-btn-primary:hover { transform:translateY(-1px); box-shadow:0 6px 18px rgba(255,149,0,.4); }

/* ── Notifications ──────────────────────────── */
.usr-notif {
    position:fixed; top:20px; left:50%; width:min(480px,calc(100vw - 32px));
    background:#fff; border-radius:16px; padding:0; z-index:100001; overflow:hidden;
    transform:translateX(-50%) translateY(-130%) scale(.92); opacity:0;
    transition:transform .52s cubic-bezier(.34,1.56,.64,1),opacity .28s ease;
}
.usr-notif.usr-show { transform:translateX(-50%) translateY(0) scale(1); opacity:1; }
.usr-notif::before { content:''; display:block; height:5px; width:100%; }
.usr-notif-success::before { background:linear-gradient(90deg,#059669,#10b981,#34d399); }
.usr-notif-error::before   { background:linear-gradient(90deg,#dc2626,#ef4444,#f87171); }
.usr-notif-inner { display:flex; align-items:center; gap:16px; padding:18px 20px; }
.usr-notif-icon-bg { width:52px; height:52px; border-radius:50%; flex-shrink:0;
    display:flex; align-items:center; justify-content:center; }
.usr-notif-success .usr-notif-icon-bg {
    background:linear-gradient(135deg,#d1fae5,#6ee7b7);
    box-shadow:0 0 0 8px rgba(16,185,129,.1);
}
.usr-notif-error .usr-notif-icon-bg {
    background:linear-gradient(135deg,#fee2e2,#fca5a5);
    box-shadow:0 0 0 8px rgba(239,68,68,.1);
}
.usr-notif-icon-bg svg { width:24px; height:24px; }
.usr-notif-text { flex:1; }
.usr-notif-text strong { display:block; font-size:.9375rem; font-weight:700;
    color:#111827; margin-bottom:2px; }
.usr-notif-text span { font-size:.8125rem; color:#6b7280; }
.usr-notif-close { width:32px; height:32px; border-radius:8px; border:none; background:none;
    cursor:pointer; display:flex; align-items:center; justify-content:center; color:#9ca3af;
    transition:background .2s; flex-shrink:0; }
.usr-notif-close:hover { background:#f3f4f6; }
.usr-notif-close svg { width:16px; height:16px; }
.usr-notif-progress { height:3px; background:#f3f4f6; }
.usr-notif-bar { height:100%; transform-origin:left; }
.usr-notif-success .usr-notif-bar { background:linear-gradient(90deg,#059669,#10b981,#34d399); }
.usr-notif-error   .usr-notif-bar { background:linear-gradient(90deg,#dc2626,#ef4444); }
@keyframes usr-bar { from{transform:scaleX(1)} to{transform:scaleX(0)} }
</style>

{{-- Notification premium --}}
<div class="usr-notif" id="usrNotif" role="alert" aria-live="assertive">
    <div class="usr-notif-inner">
        <div class="usr-notif-icon-bg" id="usrNotifIcon"></div>
        <div class="usr-notif-text">
            <strong id="usrNotifTitle"></strong>
            <span id="usrNotifMsg"></span>
        </div>
        <button class="usr-notif-close" onclick="usrHideNotif()">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    <div class="usr-notif-progress"><div class="usr-notif-bar" id="usrNotifBar"></div></div>
</div>

<div class="usr-page">
    {{-- Hero --}}
    <div class="usr-hero">
        <div class="usr-hero-bg">
            <div class="usr-hero-inner">
                <div class="usr-hero-left">
                    <h1>Modifier le compte</h1>
                    <p class="usr-hero-sub">
                        <span class="usr-hero-badge">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            {{ $user->name }}
                        </span>
                    </p>
                </div>
                <a href="{{ route('admin.utilisateurs.show', $user->id) }}" class="usr-btn usr-btn-secondary" style="background:rgba(255,255,255,.15);border-color:rgba(255,255,255,.3);color:#fff;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Retour au profil
                </a>
            </div>
        </div>
    </div>

    {{-- Carte principale --}}
    <div class="usr-edit-card">
        <div class="usr-edit-header">
            <div class="usr-edit-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <p class="usr-edit-title">Modifier l'utilisateur</p>
                <p class="usr-edit-sub">{{ $user->email }}</p>
            </div>
        </div>

        <form action="{{ route('admin.utilisateurs.update', $user->id) }}" method="POST" id="editForm">
            @csrf
            @method('PUT')

            <div class="usr-edit-body">
                <div class="usr-form-grid">

                    {{-- Infos personnelles --}}
                    <div class="usr-section-label">Informations personnelles</div>

                    <div class="usr-form-field full">
                        <label class="usr-form-label">Nom complet <span class="required">*</span></label>
                        <input type="text" name="name" class="usr-form-input"
                               value="{{ old('name', $user->name) }}" required placeholder="Prénom Nom">
                    </div>

                    <div class="usr-form-field">
                        <label class="usr-form-label">Adresse email <span class="required">*</span></label>
                        <input type="email" name="email" class="usr-form-input"
                               value="{{ old('email', $user->email) }}" required placeholder="email@exemple.com">
                    </div>

                    <div class="usr-form-field">
                        <label class="usr-form-label">Téléphone</label>
                        <input type="text" name="phone" class="usr-form-input"
                               value="{{ old('phone', $user->phone ?? '') }}" placeholder="+226 XX XX XX XX">
                    </div>

                    <hr class="usr-form-divider">

                    {{-- Accès --}}
                    <div class="usr-section-label">Accès & permissions</div>

                    <div class="usr-form-field">
                        <label class="usr-form-label">Rôle <span class="required">*</span></label>
                        <div class="usr-select-wrapper">
                            <select name="role" class="usr-form-select" required>
                                @if(auth()->user()->hasRole('Super Admin'))
                                <option value="super_admin" {{ ($user->role ?? '') === 'super_admin' ? 'selected' : '' }}>Super Administrateur</option>
                                @endif
                                <option value="admin"    {{ ($user->role ?? '') === 'admin'    ? 'selected' : '' }}>Administrateur</option>
                                <option value="manager"  {{ ($user->role ?? '') === 'manager'  ? 'selected' : '' }}>Manager</option>
                                <option value="hr"       {{ ($user->role ?? '') === 'hr'       ? 'selected' : '' }}>Ressources Humaines</option>
                                <option value="employee" {{ ($user->role ?? '') === 'employee' ? 'selected' : '' }}>Employé</option>
                            </select>
                        </div>
                    </div>

                    <div class="usr-form-field">
                        <label class="usr-form-label">Statut <span class="required">*</span></label>
                        <div class="usr-select-wrapper">
                            <select name="status" class="usr-form-select" required>
                                <option value="active"   {{ ($user->status ?? 'active') === 'active'   ? 'selected' : '' }}>Actif</option>
                                <option value="inactive" {{ ($user->status ?? 'active') === 'inactive' ? 'selected' : '' }}>Inactif</option>
                            </select>
                        </div>
                    </div>

                    <hr class="usr-form-divider">

                    {{-- Sécurité --}}
                    <div class="usr-section-label">Sécurité</div>

                    <div class="usr-form-field full">
                        <label class="usr-form-label">Nouveau mot de passe</label>
                        <input type="password" name="password" class="usr-form-input"
                               placeholder="Laisser vide pour ne pas modifier">
                        <p class="usr-form-hint">Minimum 6 caractères. Laisser vide pour conserver le mot de passe actuel.</p>
                    </div>

                </div>
            </div>

            <div class="usr-edit-footer">
                <a href="{{ route('admin.utilisateurs.show', $user->id) }}" class="usr-btn usr-btn-secondary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Annuler
                </a>
                <button type="submit" class="usr-btn usr-btn-primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// ── Notification premium ──────────────────────────────────
let usrNotifTimer = null;

function usrShowNotif(type, title, msg, duration = 5000) {
    const el    = document.getElementById('usrNotif');
    const icon  = document.getElementById('usrNotifIcon');
    const tEl   = document.getElementById('usrNotifTitle');
    const mEl   = document.getElementById('usrNotifMsg');
    const bar   = document.getElementById('usrNotifBar');

    el.className = 'usr-notif usr-notif-' + type;

    icon.innerHTML = type === 'success'
        ? `<svg viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
               <path d="M20 6L9 17l-5-5"/>
           </svg>`
        : `<svg viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
               <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
           </svg>`;

    tEl.textContent = title;
    mEl.textContent = msg;

    bar.style.animation = 'none';
    bar.offsetHeight; // reflow
    bar.style.animation = `usr-bar ${duration}ms linear forwards`;

    el.classList.add('usr-show');
    if (usrNotifTimer) clearTimeout(usrNotifTimer);
    usrNotifTimer = setTimeout(usrHideNotif, duration);
}

function usrHideNotif() {
    document.getElementById('usrNotif').classList.remove('usr-show');
}

// Flash sessions
@if(session('success'))
    setTimeout(() => usrShowNotif('success', 'Succès', '{{ addslashes(session('success')) }}', 6000), 300);
@endif
@if($errors->any())
    setTimeout(() => usrShowNotif('error', 'Erreur', '{{ addslashes($errors->first()) }}', 7000), 300);
@endif
</script>
@endsection
