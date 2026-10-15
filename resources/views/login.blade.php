@extends('layouts.auth')

@section('title', 'Connexion')
@section('home', true)
@section('heading', 'Connexion')
@section('lead', 'Vos congés, absences et bulletins de paie, au même endroit.')

@section('before')
    @include('partials.app-loader')
@endsection

@section('content')
    <form method="POST" action="{{ route('login.submit') }}" id="loginForm" class="stack" novalidate data-lock="Connexion…">
        @csrf

        @if(session('success'))
            <div class="alert alert-ok" role="status">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-err" role="alert" id="loginError">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <div class="field">
            <label for="courrier">Adresse e-mail</label>
            <input type="email" id="courrier" name="courrier" class="input"
                   value="{{ old('courrier') }}"
                   placeholder="prenom.nom@entreprise.com"
                   autocomplete="username" inputmode="email" autocapitalize="none" spellcheck="false"
                   required {{ old('courrier') ? '' : 'data-autofocus' }}
                   @if($errors->any()) aria-invalid="true" aria-describedby="loginError" @endif>
        </div>

        <div class="field">
            <label for="password">Mot de passe</label>
            <div class="pwd">
                <input type="password" id="password" name="password" class="input"
                       autocomplete="current-password" minlength="6" required
                       {{ old('courrier') ? 'data-autofocus' : '' }}
                       @if($errors->has('password')) aria-invalid="true" aria-describedby="loginError" @endif>
                <button type="button" class="eye" data-toggle-pwd="password" aria-label="Afficher le mot de passe" aria-pressed="false">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
            </div>
            <span class="caps" data-caps-for="password" role="status">Majuscules activées</span>
        </div>

        <div class="row">
            <label class="check">
                <input type="checkbox" name="remember" id="rememberMe" {{ old('remember') ? 'checked' : '' }}>
                Rester connecté
            </label>
            <a href="{{ route('password.request') }}" class="link">Mot de passe oublié</a>
        </div>

        <div class="spacer"></div>

        <div>
            <button type="submit" class="submit">Se connecter</button>
            <p class="help">Pas encore de compte ? Votre service RH vous l'envoie par e-mail.</p>
        </div>
    </form>
@endsection

@push('scripts')
<script>
(function () {
    // Dans l'app mobile, la connexion doit persister pour que le déverrouillage
    // par code PIN ait un sens après une fermeture complète de l'app.
    try {
        var isApp = !!(window.Capacitor && window.Capacitor.isNativePlatform && window.Capacitor.isNativePlatform())
            || window.matchMedia('(display-mode: standalone)').matches
            || window.navigator.standalone === true;
        if (isApp) document.getElementById('rememberMe').checked = true;
    } catch (e) {}

    // Validation légère avant envoi
    var form = document.getElementById('loginForm');
    var fields = [document.getElementById('courrier'), document.getElementById('password')];
    form.addEventListener('submit', function (e) {
        var bad = null;
        fields.forEach(function (f) {
            var ok = f.checkValidity();
            f.setAttribute('aria-invalid', ok ? 'false' : 'true');
            if (!ok && !bad) bad = f;
        });
        if (bad) { e.preventDefault(); bad.focus(); }
    });
})();
</script>
@endpush
