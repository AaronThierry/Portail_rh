@extends('layouts.auth')

@section('title', 'Vérification en deux étapes')
@section('heading', 'Vérification en deux étapes')
@section('lead', 'Ouvrez votre application d’authentification (Google Authenticator, Authy…) et saisissez le code à 6 chiffres affiché pour Portail RH+.')

@section('content')
    <form method="POST" action="{{ route('two-factor.verify.login') }}" id="otpForm" class="stack" novalidate data-lock="Vérification…">
        @csrf

        @if(session('error'))
            <div class="alert alert-err" role="alert" id="formError">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-err" role="alert">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <div class="field">
            <label for="otpInput">Code à 6 chiffres</label>
            <input type="text" name="one_time_password" id="otpInput" class="otp-single"
                   maxlength="6" pattern="[0-9]{6}" inputmode="numeric"
                   autocomplete="one-time-code" placeholder="••••••"
                   required data-autofocus="always" aria-describedby="otpHint"
                   @if(session('error') || $errors->any()) aria-invalid="true" @endif>
            <span class="hint" id="otpHint">Le code change toutes les 30 secondes. S’il vient d’expirer, attendez le suivant.</span>
        </div>

        <div class="spacer"></div>

        <button type="submit" class="submit">Vérifier</button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="center">
        @csrf
        <span class="hint">Pas accès à votre application ?</span>
        <button type="submit" class="text-btn">Se déconnecter</button>
    </form>
@endsection

@push('scripts')
<script>
(function () {
    var input = document.getElementById('otpInput');
    var form  = document.getElementById('otpForm');

    function submitIfComplete() {
        if (input.value.length === 6) {
            form.requestSubmit ? form.requestSubmit() : form.submit();
        }
    }

    input.addEventListener('input', function () {
        input.value = input.value.replace(/\D/g, '').substring(0, 6);
        input.removeAttribute('aria-invalid');
        submitIfComplete();
    });

    form.addEventListener('submit', function (e) {
        if (input.value.length !== 6) {
            e.preventDefault();
            input.setAttribute('aria-invalid', 'true');
            input.focus();
        }
    });
})();
</script>
@endpush
