@extends('layouts.auth')

@section('title', 'Choisissez votre mot de passe')
@section('heading', 'Choisissez votre mot de passe')
@section('lead', 'Vous vous êtes connecté avec un mot de passe temporaire. Remplacez-le par un mot de passe que vous seul connaissez.')

@section('content')
    <form action="{{ route('password.update-first') }}" method="POST" id="firstPwdForm" class="stack" novalidate data-lock="Enregistrement…">
        @csrf

        @foreach(['warning' => 'alert-warn', 'info' => 'alert-info', 'error' => 'alert-err'] as $key => $cls)
            @if(session($key))
                <div class="alert {{ $cls }}" role="{{ $key === 'error' ? 'alert' : 'status' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span>{{ session($key) }}</span>
                </div>
            @endif
        @endforeach

        <div class="field">
            <label for="new_password">Nouveau mot de passe</label>
            <div class="pwd">
                <input type="password" id="new_password" name="new_password" class="input"
                       autocomplete="new-password" minlength="8" required data-autofocus
                       aria-describedby="npHelp npErr"
                       @error('new_password') aria-invalid="true" @enderror>
                <button type="button" class="eye" data-toggle-pwd="new_password" aria-label="Afficher le mot de passe" aria-pressed="false">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
            </div>
            <div class="meter" id="meter" aria-hidden="true"><i></i><i></i><i></i><i></i></div>
            <span class="meter-lbl" id="npHelp" aria-live="polite"></span>
            <span class="field-err @error('new_password') show @enderror" id="npErr" role="alert">@error('new_password'){{ $message }}@enderror</span>
            <span class="caps" data-caps-for="new_password" role="status">Majuscules activées</span>
        </div>

        <ul class="reqs" aria-label="Ce qui rend un mot de passe solide">
            <li data-req="length">8 caractères minimum</li>
            <li data-req="upper">Une majuscule</li>
            <li data-req="lower">Une minuscule</li>
            <li data-req="digit">Un chiffre</li>
            <li data-req="special">Un symbole (@, #, !…)</li>
        </ul>

        <div class="field">
            <label for="new_password_confirmation">Confirmez le mot de passe</label>
            <div class="pwd">
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="input"
                       autocomplete="new-password" required aria-describedby="ncErr">
                <button type="button" class="eye" data-toggle-pwd="new_password_confirmation" aria-label="Afficher le mot de passe" aria-pressed="false">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
            </div>
            <span class="field-err" id="ncErr" role="alert">Les deux mots de passe ne sont pas identiques.</span>
        </div>

        <div class="spacer"></div>

        <button type="submit" class="submit">Enregistrer mon mot de passe</button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="center">
        @csrf
        <button type="submit" class="text-btn">Se déconnecter</button>
    </form>
@endsection

@push('scripts')
<script>
(function () {
    var pwd   = document.getElementById('new_password');
    var conf  = document.getElementById('new_password_confirmation');
    var meter = document.getElementById('meter');
    var help  = document.getElementById('npHelp');
    var npErr = document.getElementById('npErr');
    var ncErr = document.getElementById('ncErr');
    var form  = document.getElementById('firstPwdForm');

    var tests = {
        length:  function (v) { return v.length >= 8; },
        upper:   function (v) { return /[A-Z]/.test(v); },
        lower:   function (v) { return /[a-z]/.test(v); },
        digit:   function (v) { return /\d/.test(v); },
        special: function (v) { return /[^A-Za-z0-9]/.test(v); }
    };
    var labels = ['', 'Trop faible', 'Moyen', 'Bon', 'Solide'];

    pwd.addEventListener('input', function () {
        var v = pwd.value, passed = 0;
        pwd.removeAttribute('aria-invalid');
        npErr.classList.remove('show');
        Object.keys(tests).forEach(function (k) {
            var ok = tests[k](v);
            if (ok) passed++;
            document.querySelector('[data-req="' + k + '"]').classList.toggle('ok', ok);
        });
        if (!v) { meter.removeAttribute('data-level'); help.textContent = ''; return; }
        var l = !tests.length(v) ? 1 : Math.max(1, Math.min(4, passed - 1));
        meter.setAttribute('data-level', l);
        help.textContent = 'Force : ' + labels[l];
        if (conf.value) checkConfirm();
    });

    function checkConfirm() {
        var bad = conf.value && conf.value !== pwd.value;
        conf.setAttribute('aria-invalid', bad ? 'true' : 'false');
        ncErr.classList.toggle('show', !!bad);
        return !bad;
    }
    conf.addEventListener('input', checkConfirm);

    form.addEventListener('submit', function (e) {
        if (!tests.length(pwd.value)) {
            e.preventDefault();
            pwd.setAttribute('aria-invalid', 'true');
            npErr.textContent = pwd.value ? 'Il faut au moins 8 caractères.' : 'Choisissez un mot de passe.';
            npErr.classList.add('show');
            pwd.focus();
            return;
        }
        if (!conf.value || !checkConfirm()) {
            e.preventDefault();
            conf.setAttribute('aria-invalid', 'true');
            ncErr.classList.add('show');
            conf.focus();
        }
    });
})();
</script>
@endpush
