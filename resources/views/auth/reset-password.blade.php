@extends('layouts.auth')

@section('title', 'Nouveau mot de passe')
@section('heading', 'Choisissez un nouveau mot de passe')
@section('lead', 'Il remplacera l’ancien dès que vous l’aurez enregistré.')

@section('content')
    <form method="POST" action="{{ route('password.update') }}" id="resetForm" class="stack" novalidate data-lock="Enregistrement…">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <span class="chip">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            {{ $email }}
        </span>

        @if($errors->any())
            <div class="alert alert-err" role="alert" id="formError">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <div class="field">
            <label for="password">Nouveau mot de passe</label>
            <div class="pwd">
                <input type="password" id="password" name="password" class="input"
                       autocomplete="new-password" minlength="6" required data-autofocus
                       aria-describedby="pwdHelp"
                       @error('password') aria-invalid="true" @enderror>
                <button type="button" class="eye" data-toggle-pwd="password" aria-label="Afficher le mot de passe" aria-pressed="false">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
            </div>
            <div class="meter" id="meter" aria-hidden="true"><i></i><i></i><i></i><i></i></div>
            <span class="meter-lbl" id="pwdHelp" aria-live="polite">Au moins 6 caractères. Mélangez lettres, chiffres et symboles.</span>
            <span class="caps" data-caps-for="password" role="status">Majuscules activées</span>
        </div>

        <div class="field">
            <label for="password_confirmation">Confirmez le mot de passe</label>
            <div class="pwd">
                <input type="password" id="password_confirmation" name="password_confirmation" class="input"
                       autocomplete="new-password" minlength="6" required aria-describedby="confirmErr">
                <button type="button" class="eye" data-toggle-pwd="password_confirmation" aria-label="Afficher le mot de passe" aria-pressed="false">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
            </div>
            <span class="field-err" id="confirmErr" role="alert">Les deux mots de passe ne sont pas identiques.</span>
        </div>

        <div class="spacer"></div>

        <button type="submit" class="submit">Enregistrer le mot de passe</button>
    </form>
@endsection

@push('scripts')
<script>
(function () {
    var pwd   = document.getElementById('password');
    var conf  = document.getElementById('password_confirmation');
    var meter = document.getElementById('meter');
    var help  = document.getElementById('pwdHelp');
    var cerr  = document.getElementById('confirmErr');
    var form  = document.getElementById('resetForm');
    var defaultHelp = help.textContent;

    function level(v) {
        var s = 0;
        if (v.length >= 8) s++;
        if (v.length >= 12) s++;
        if (/[A-Z]/.test(v) && /[a-z]/.test(v)) s++;
        if (/\d/.test(v)) s++;
        if (/[^A-Za-z0-9]/.test(v)) s++;
        if (v.length < 6) return 1;
        return Math.max(1, Math.min(4, s));
    }
    var labels = ['', 'Trop faible', 'Moyen', 'Bon', 'Solide'];

    pwd.addEventListener('input', function () {
        pwd.removeAttribute('aria-invalid');
        if (!pwd.value) { meter.removeAttribute('data-level'); help.textContent = defaultHelp; return; }
        var l = level(pwd.value);
        meter.setAttribute('data-level', l);
        help.textContent = 'Force : ' + labels[l] + (pwd.value.length < 6 ? ' (6 caractères minimum)' : '');
        if (conf.value) checkConfirm();
    });

    function checkConfirm() {
        var bad = conf.value && conf.value !== pwd.value;
        conf.setAttribute('aria-invalid', bad ? 'true' : 'false');
        cerr.classList.toggle('show', !!bad);
        return !bad;
    }
    conf.addEventListener('input', checkConfirm);

    form.addEventListener('submit', function (e) {
        if (pwd.value.length < 6) {
            e.preventDefault(); pwd.setAttribute('aria-invalid', 'true');
            help.textContent = 'Le mot de passe doit contenir au moins 6 caractères.';
            pwd.focus(); return;
        }
        if (!conf.value || !checkConfirm()) {
            e.preventDefault(); conf.setAttribute('aria-invalid', 'true'); cerr.classList.add('show'); conf.focus();
        }
    });
})();
</script>
@endpush
