@extends('layouts.app')

@section('title', 'Mon profil')
@section('page-title', 'Mon profil')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
</svg>
@endsection

@section('styles')
<style>
    .pf-id { display: flex; align-items: center; gap: 18px; flex-wrap: wrap; }
    .pf-photo { position: relative; width: 88px; height: 88px; flex-shrink: 0; }
    .pf-photo img, .pf-photo .pf-init { width: 88px; height: 88px; border-radius: 999px; object-fit: cover; }
    .pf-photo .pf-init { display: flex; align-items: center; justify-content: center; background: var(--ink); color: #fff; font-family: var(--display); font-size: 30px; font-weight: 700; }
    .dark .pf-photo .pf-init { color: var(--page); }
    .pf-photo button { position: absolute; right: -2px; bottom: -2px; width: 36px; height: 36px; border-radius: 999px; border: 3px solid var(--page); background: var(--brand); color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; }
    .pf-photo button svg { width: 16px; height: 16px; }
    .pf-grid { display: grid; gap: 28px; }
    @media (min-width: 1024px) { .pf-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 40px; } }
    .pf-dl { margin: 0; }
    .pf-dl div { display: flex; justify-content: space-between; gap: 16px; padding: 14px 16px; border-top: 1px solid var(--line-soft); }
    .pf-dl div:first-child { border-top: 0; }
    .pf-dl dt { color: var(--muted); font-size: 14px; flex-shrink: 0; }
    .pf-dl dd { margin: 0; font-weight: 600; font-size: 15px; text-align: right; overflow-wrap: anywhere; }
    .pf-dl dd.vide { color: var(--faint); font-weight: 500; }
    .pf-preview { display: none; width: 120px; height: 120px; border-radius: 999px; object-fit: cover; margin: 0 auto; }
    .pf-preview.show { display: block; }
    .pf-2fa-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; margin-bottom: 10px; }
    .pf-2fa-steps { display: flex; flex-direction: column; gap: 8px; margin: 12px 0; }
    .pf-2fa-steps .step { display: flex; align-items: flex-start; gap: 10px; }
    .pf-2fa-steps .step span { width: 20px; height: 20px; flex-shrink: 0; border-radius: 6px; background: var(--brand); color: #fff; font-size: 11px; font-weight: 700; display: flex; align-items: center; justify-content: center; }
    .pf-2fa-steps .step small { display: block; color: var(--muted); font-size: 12.5px; }
</style>
@endsection

@section('content')
@php
    $pfAvatar = $user->avatar ? asset(str_starts_with($user->avatar, 'storage/') ? $user->avatar : 'storage/' . $user->avatar) : null;
    $pfInit = mb_strtoupper(mb_substr($user->name ?? 'U', 0, 1));
@endphp

<div class="rh-page">
    @if(session('success'))
        <div class="rh-alert ok" role="status">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="rh-alert err" role="alert">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 8v5M12 16h.01"/></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif
    @if($errors->any())
        <div class="rh-alert err" role="alert">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 8v5M12 16h.01"/></svg>
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    <section class="rh-head">
        <div class="pf-id">
            <div class="pf-photo">
                @if($pfAvatar)
                    <img src="{{ $pfAvatar }}" alt="Photo de {{ $user->name }}">
                @else
                    <span class="pf-init" aria-hidden="true">{{ $pfInit }}</span>
                @endif
                <button type="button" data-open="photoModal" aria-label="Changer ma photo">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                </button>
            </div>
            <div class="rh-head-txt">
                <h1 class="rh-h1">{{ $user->name }}</h1>
                <p class="rh-lead">{{ $user->roles->first()->name ?? 'Utilisateur' }}@if($user->entreprise) · {{ $user->entreprise->nom }}@endif</p>
            </div>
        </div>
        <div class="rh-actions">
            <button type="button" class="rh-btn" data-open="editModal">Modifier mes informations</button>
        </div>
    </section>

    <div class="rh-figures">
        <div class="rh-figure"><strong>{{ $user->created_at->format('d/m/Y') }}</strong><span>membre depuis</span></div>
        <div class="rh-figure"><strong>{{ $user->google2fa_enabled ? 'Sécurisé' : 'Standard' }}</strong><span>niveau de sécurité</span></div>
    </div>

    <div class="pf-grid">
        <section class="rh-section" aria-labelledby="titreCoord">
            <div class="rh-section-head">
                <h2 class="rh-h2" id="titreCoord">Coordonnées</h2>
                <button type="button" class="rh-link" data-open="editModal">Modifier</button>
            </div>
            <dl class="pf-dl rh-card-flat">
                <div><dt>E-mail</dt><dd>{{ $user->email }}</dd></div>
                <div><dt>Téléphone</dt><dd class="{{ $user->phone ? '' : 'vide' }}">{{ $user->phone ?: 'Non renseigné' }}</dd></div>
            </dl>

            <h2 class="rh-h2" style="margin-top: 14px">Informations professionnelles</h2>
            <dl class="pf-dl rh-card-flat">
                <div><dt>Entreprise</dt><dd class="{{ $user->entreprise ? '' : 'vide' }}">{{ $user->entreprise->nom ?? 'Non renseignée' }}</dd></div>
                @if($user->personnel?->departement)
                    <div><dt>Département</dt><dd>{{ $user->personnel->departement->nom }}</dd></div>
                @endif
                @if($user->personnel?->service)
                    <div><dt>Service</dt><dd>{{ $user->personnel->service->nom }}</dd></div>
                @endif
            </dl>
        </section>

        <section class="rh-section" aria-labelledby="titreSecu">
            <h2 class="rh-h2" id="titreSecu">Sécurité</h2>

            <div class="rh-card">
                <div class="pf-2fa-head">
                    <div>
                        <strong style="display:block; font-size:15px">Authentification à deux facteurs</strong>
                        <span class="rh-row-sub">{{ $user->google2fa_enabled ? 'Un code sera demandé à chaque connexion.' : 'Activez la 2FA pour plus de sécurité.' }}</span>
                    </div>
                    <span class="rh-badge {{ $user->google2fa_enabled ? 'ok' : 'wait' }}">{{ $user->google2fa_enabled ? 'Activée' : 'Désactivée' }}</span>
                </div>

                @if($user->google2fa_enabled)
                    @if($user->google2fa_verified_at)
                        <p class="rh-hint">Activée le {{ $user->google2fa_verified_at->format('d/m/Y à H:i') }}</p>
                    @endif
                    <form action="{{ route('admin.two-factor.disable') }}" method="POST" data-confirm="Désactiver la 2FA rendra votre compte moins sécurisé. Continuer ?" style="margin-top: 12px">
                        @csrf @method('DELETE')
                        <button type="submit" class="rh-btn danger sm">Désactiver la 2FA</button>
                    </form>
                @else
                    <div class="pf-2fa-steps">
                        <div class="step"><span>1</span><div><strong>Téléchargez l'app</strong><small>Google Authenticator, Authy…</small></div></div>
                        <div class="step"><span>2</span><div><strong>Scannez le QR code</strong><small>Avec l'application</small></div></div>
                        <div class="step"><span>3</span><div><strong>Validez le code</strong><small>Entrez le code généré</small></div></div>
                    </div>
                    <form action="{{ route('admin.two-factor.enable') }}" method="POST">
                        @csrf
                        <button type="submit" class="rh-btn sm">Activer la 2FA</button>
                    </form>
                @endif
            </div>

            <ul class="rh-list rh-card-flat" style="margin-top: 14px">
                <li>
                    <button type="button" data-open="passwordModal" class="rh-row" style="width: 100%; border: 0; background: none; cursor: pointer; font: inherit; text-align: left">
                        <span class="rh-row-main"><span class="rh-row-title">Mot de passe</span><span class="rh-row-sub">Modifier mon mot de passe</span></span>
                        <span aria-hidden="true">›</span>
                    </button>
                </li>
            </ul>
        </section>
    </div>
</div>

{{-- ── Modifier mes informations ────────────────────────────── --}}
<div class="rh-sheet" id="editModal" role="dialog" aria-modal="true" aria-labelledby="editTitre">
    <div class="rh-sheet-box">
        <div class="rh-sheet-grip"></div>
        <div class="rh-sheet-head">
            <div>
                <h2 id="editTitre">Mes informations</h2>
                <p>Nom, e-mail et téléphone.</p>
            </div>
            <button type="button" class="rh-iconbtn" data-close aria-label="Fermer">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg>
            </button>
        </div>
        <form action="{{ route('admin.profile.update') }}" method="POST" class="rh-form" data-lock="Enregistrement…">
            @csrf @method('PUT')
            <div class="rh-field">
                <label for="name">Nom complet</label>
                <input type="text" name="name" id="name" class="rh-input" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="rh-field">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" class="rh-input" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="rh-field">
                <label for="phone">Téléphone</label>
                <input type="tel" name="phone" id="phone" class="rh-input" value="{{ old('phone', $user->phone) }}" placeholder="+225 XX XX XX XX XX">
            </div>
            <div class="rh-sheet-foot">
                <button type="button" class="rh-btn soft" data-close>Annuler</button>
                <button type="submit" class="rh-btn">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Changer la photo ─────────────────────────────────────── --}}
<div class="rh-sheet" id="photoModal" role="dialog" aria-modal="true" aria-labelledby="photoTitre">
    <div class="rh-sheet-box">
        <div class="rh-sheet-grip"></div>
        <div class="rh-sheet-head">
            <div>
                <h2 id="photoTitre">Ma photo</h2>
                <p>JPG, PNG ou GIF, 2 Mo maximum.</p>
            </div>
            <button type="button" class="rh-iconbtn" data-close aria-label="Fermer">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg>
            </button>
        </div>
        <form action="{{ route('admin.profile.avatar') }}" method="POST" enctype="multipart/form-data" class="rh-form" data-lock="Envoi…">
            @csrf
            <img id="photoPreview" class="pf-preview" alt="Aperçu de la nouvelle photo">
            <div class="rh-field">
                <label for="avatarInput">Choisir une photo</label>
                <input type="file" name="avatar" id="avatarInput" class="rh-input" accept="image/jpeg,image/png,image/gif" required>
            </div>
            <div class="rh-sheet-foot">
                <button type="submit" class="rh-btn">Enregistrer</button>
            </div>
        </form>
        @if($user->avatar)
            <form action="{{ route('admin.profile.avatar.delete') }}" method="POST" data-confirm="Supprimer la photo ?" style="margin-top: 10px">
                @csrf @method('DELETE')
                <button type="submit" class="rh-btn danger block sm">Supprimer la photo actuelle</button>
            </form>
        @endif
    </div>
</div>

{{-- ── Changer le mot de passe ──────────────────────────────── --}}
<div class="rh-sheet" id="passwordModal" role="dialog" aria-modal="true" aria-labelledby="pwdTitre">
    <div class="rh-sheet-box">
        <div class="rh-sheet-grip"></div>
        <div class="rh-sheet-head">
            <div>
                <h2 id="pwdTitre">Mot de passe</h2>
                <p>Au moins 8 caractères.</p>
            </div>
            <button type="button" class="rh-iconbtn" data-close aria-label="Fermer">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg>
            </button>
        </div>
        <form action="{{ route('admin.profile.password') }}" method="POST" class="rh-form" data-lock="Enregistrement…">
            @csrf @method('PUT')
            <div class="rh-field">
                <label for="current_password">Mot de passe actuel</label>
                <input type="password" name="current_password" id="current_password" class="rh-input" required>
                @error('current_password')<p class="rh-err">{{ $message }}</p>@enderror
            </div>
            <div class="rh-field">
                <label for="password">Nouveau mot de passe</label>
                <input type="password" name="password" id="password" class="rh-input" required minlength="8">
            </div>
            <div class="rh-field">
                <label for="password_confirmation">Confirmer le nouveau mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="rh-input" required>
            </div>
            <div class="rh-sheet-foot">
                <button type="button" class="rh-btn soft" data-close>Annuler</button>
                <button type="submit" class="rh-btn">Modifier le mot de passe</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
(function () {
    var input = document.getElementById('avatarInput'), prev = document.getElementById('photoPreview');
    if (input) {
        input.addEventListener('change', function () {
            if (!input.files || !input.files[0]) return;
            var r = new FileReader();
            r.onload = function (e) { prev.src = e.target.result; prev.classList.add('show'); };
            r.readAsDataURL(input.files[0]);
        });
    }
    @if($errors->has('name') || $errors->has('email') || $errors->has('phone'))
        rhOpen('editModal');
    @elseif($errors->has('avatar'))
        rhOpen('photoModal');
    @elseif($errors->has('current_password') || $errors->has('password'))
        rhOpen('passwordModal');
    @endif
})();
</script>
@endsection
