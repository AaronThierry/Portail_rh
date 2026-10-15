@extends('layouts.auth')

@section('title', 'Mot de passe oublié')
@section('heading', 'Mot de passe oublié')
@section('lead', 'Indiquez votre adresse e-mail : nous vous envoyons un code à 6 chiffres pour choisir un nouveau mot de passe.')

@section('content')
    <form method="POST" action="{{ route('password.send.code') }}" class="stack" data-lock="Envoi du code…">
        @csrf

        @if(session('success'))
            <div class="alert alert-ok" role="status">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-err" role="alert" id="formError">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <div class="field">
            <label for="email">Adresse e-mail</label>
            <input type="email" id="email" name="email" class="input"
                   value="{{ old('email') }}"
                   placeholder="prenom.nom@entreprise.com"
                   autocomplete="username" inputmode="email" autocapitalize="none" spellcheck="false"
                   required data-autofocus
                   @if($errors->any()) aria-invalid="true" aria-describedby="formError" @endif>
            <span class="hint">Le code arrive en quelques instants. Pensez à regarder dans vos spams.</span>
        </div>

        <div class="spacer"></div>

        <div>
            <button type="submit" class="submit">Recevoir le code</button>
            <p class="center">
                <a href="{{ route('login') }}" class="link back">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 18l-6-6 6-6"/></svg>
                    Retour à la connexion
                </a>
            </p>
        </div>
    </form>
@endsection
