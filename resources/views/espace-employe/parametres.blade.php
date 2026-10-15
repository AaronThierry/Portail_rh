@extends('layouts.espace-employe')

@section('title', 'Sécurité du compte')

@section('styles')
<style>
    .pr-grid { display: grid; gap: 28px; }
    @media (min-width: 1024px) { .pr-grid { grid-template-columns: minmax(0, 1.2fr) minmax(0, 1fr); gap: 40px; align-items: start; } }
    .pr-meter { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 4px; }
    .pr-meter i { height: 4px; border-radius: 4px; background: var(--line-soft); }
    .pr-meter[data-level="1"] i:nth-child(-n+1) { background: #dc2626; }
    .pr-meter[data-level="2"] i:nth-child(-n+2) { background: var(--orange); }
    .pr-meter[data-level="3"] i:nth-child(-n+3) { background: #ca8a04; }
    .pr-meter[data-level="4"] i:nth-child(-n+4) { background: #16a34a; }
    .pf-dl { margin: 0; }
    .pf-dl div { display: flex; justify-content: space-between; align-items: center; gap: 16px; padding: 14px 16px; border-top: 1px solid var(--line-soft); }
    .pf-dl div:first-child { border-top: 0; }
    .pf-dl dt { color: var(--muted); font-size: 14px; }
    .pf-dl dd { margin: 0; font-weight: 600; text-align: right; overflow-wrap: anywhere; }
</style>
@endsection

@section('content')
@php $eyeSvg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>'; @endphp

<div class="rh-page">
    <section class="rh-head">
        <div class="rh-head-txt">
            <a href="{{ route('espace-employe.profil') }}" class="rh-link" style="padding: 0">‹ Mon profil</a>
            <h1 class="rh-h1">Sécurité du compte</h1>
            <p class="rh-lead">Votre mot de passe et l'état de votre compte.</p>
        </div>
    </section>

    <div class="pr-grid">
        <section class="rh-card rh-section" aria-labelledby="titreMdp">
            <h2 class="rh-h2" id="titreMdp">Changer de mot de passe</h2>
            <form action="{{ route('espace-employe.password.update') }}" method="POST" class="rh-form" id="pwdForm" novalidate data-lock="Enregistrement…">
                @csrf @method('PUT')
                @if($errors->any())
                    <div class="rh-alert err" role="alert">{{ $errors->first() }}</div>
                @endif

                <div class="rh-field">
                    <label for="pw0">Mot de passe actuel</label>
                    <div class="rh-pwd">
                        <input type="password" name="current_password" id="pw0" class="rh-input" autocomplete="current-password" required
                               @error('current_password') aria-invalid="true" @enderror>
                        <button type="button" class="rh-eye" data-toggle-pwd="pw0" aria-label="Afficher le mot de passe" aria-pressed="false">{!! $eyeSvg !!}</button>
                    </div>
                </div>

                <div class="rh-field">
                    <label for="pw1">Nouveau mot de passe</label>
                    <div class="rh-pwd">
                        <input type="password" name="password" id="pw1" class="rh-input" autocomplete="new-password" minlength="8" required aria-describedby="pwHelp">
                        <button type="button" class="rh-eye" data-toggle-pwd="pw1" aria-label="Afficher le mot de passe" aria-pressed="false">{!! $eyeSvg !!}</button>
                    </div>
                    <div class="pr-meter" id="pwMeter" aria-hidden="true"><i></i><i></i><i></i><i></i></div>
                    <span class="rh-hint" id="pwHelp" aria-live="polite">8 caractères minimum. Mélangez lettres, chiffres et symboles.</span>
                </div>

                <div class="rh-field">
                    <label for="pw2">Confirmez le nouveau mot de passe</label>
                    <div class="rh-pwd">
                        <input type="password" name="password_confirmation" id="pw2" class="rh-input" autocomplete="new-password" required>
                        <button type="button" class="rh-eye" data-toggle-pwd="pw2" aria-label="Afficher le mot de passe" aria-pressed="false">{!! $eyeSvg !!}</button>
                    </div>
                    <p class="rh-err" id="pwMatch" role="alert" hidden>Les deux mots de passe ne sont pas identiques.</p>
                </div>

                <div><button type="submit" class="rh-btn">Enregistrer le mot de passe</button></div>
            </form>
        </section>

        <div class="rh-page" style="gap: 28px">
            <section class="rh-section" aria-labelledby="titreCompte">
                <h2 class="rh-h2" id="titreCompte">Mon compte</h2>
                <dl class="pf-dl rh-card-flat">
                    <div><dt>Identifiant</dt><dd>{{ $user->email }}</dd></div>
                    <div>
                        <dt>Vérification en deux étapes</dt>
                        <dd>@if($user->google2fa_enabled)<span class="rh-badge ok">Activée</span>@else<span class="rh-badge off">Désactivée</span>@endif</dd>
                    </div>
                    <div><dt>Compte créé le</dt><dd>{{ $user->created_at->format('d/m/Y') }}</dd></div>
                </dl>
                <p class="rh-hint">
                    Pour changer d'adresse e-mail @unless($user->google2fa_enabled) ou activer la vérification en deux étapes @endunless,
                    <a href="{{ route('espace-employe.assistance') }}#nouvelle">contactez le service RH</a>.
                </p>
            </section>

            <section class="rh-section" aria-labelledby="titreSession">
                <h2 class="rh-h2" id="titreSession">Session</h2>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="rh-btn danger">Se déconnecter de cet appareil</button>
                </form>
            </section>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
(function () {
    var pw1 = document.getElementById('pw1'), pw2 = document.getElementById('pw2');
    var meter = document.getElementById('pwMeter'), help = document.getElementById('pwHelp'), match = document.getElementById('pwMatch');
    var def = help.textContent, labels = ['', 'Trop faible', 'Moyen', 'Bon', 'Solide'];

    pw1.addEventListener('input', function () {
        var v = pw1.value, s = 0;
        if (!v) { meter.removeAttribute('data-level'); help.textContent = def; return; }
        if (v.length >= 8) s++;
        if (v.length >= 12) s++;
        if (/[A-Z]/.test(v) && /[a-z]/.test(v)) s++;
        if (/\d/.test(v)) s++;
        if (/[^A-Za-z0-9]/.test(v)) s++;
        var l = v.length < 8 ? 1 : Math.max(1, Math.min(4, s));
        meter.setAttribute('data-level', l);
        help.textContent = 'Force : ' + labels[l] + (v.length < 8 ? ' (8 caractères minimum)' : '');
        if (pw2.value) check();
    });
    function check() {
        var bad = pw2.value && pw2.value !== pw1.value;
        match.hidden = !bad;
        pw2.setAttribute('aria-invalid', bad ? 'true' : 'false');
        return !bad;
    }
    pw2.addEventListener('input', check);

    document.getElementById('pwdForm').addEventListener('submit', function (e) {
        var cur = document.getElementById('pw0');
        if (!cur.value) { e.preventDefault(); cur.focus(); return; }
        if (pw1.value.length < 8) { e.preventDefault(); help.textContent = 'Il faut au moins 8 caractères.'; pw1.setAttribute('aria-invalid', 'true'); pw1.focus(); return; }
        if (!pw2.value || !check()) { e.preventDefault(); match.hidden = false; pw2.focus(); }
    });
})();
</script>
@endsection
