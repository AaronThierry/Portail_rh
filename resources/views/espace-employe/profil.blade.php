@extends('layouts.espace-employe')

@section('title', 'Mon profil')

@section('styles')
<style>
    .pf-id { display: flex; align-items: center; gap: 18px; flex-wrap: wrap; }
    .pf-photo { position: relative; width: 88px; height: 88px; flex-shrink: 0; }
    .pf-photo img, .pf-photo .pf-init { width: 88px; height: 88px; border-radius: 999px; object-fit: cover; }
    .pf-photo .pf-init { display: flex; align-items: center; justify-content: center; background: var(--ink); color: #fff; font-family: var(--display); font-size: 30px; font-weight: 700; }
    html.dark .pf-photo .pf-init { color: var(--page); }
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
</style>
@endsection

@section('content')
@php
    $photo  = $personnel->photo ? asset('storage/' . $personnel->photo) : null;
    $init   = strtoupper(mb_substr($personnel->prenoms ?? '', 0, 1) . mb_substr($personnel->nom ?? '', 0, 1));
    $manque = collect(['telephone' => 'votre téléphone', 'adresse' => 'votre adresse'])->filter(fn ($l, $k) => empty($personnel->$k));
    $vide   = fn ($v, $txt = 'Non renseigné') => $v ?: $txt;
@endphp

<div class="rh-page">
    <section class="rh-head">
        <div class="pf-id">
            <div class="pf-photo">
                @if($photo)
                    <img src="{{ $photo }}" alt="Photo de {{ $personnel->nom_complet }}">
                @else
                    <span class="pf-init" aria-hidden="true">{{ $init }}</span>
                @endif
                <button type="button" data-open="photoModal" aria-label="Changer ma photo">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                </button>
            </div>
            <div class="rh-head-txt">
                <h1 class="rh-h1">{{ $personnel->nom_complet }}</h1>
                <p class="rh-lead">{{ $personnel->poste ?? 'Poste non renseigné' }}@if($personnel->entreprise) · {{ $personnel->entreprise->nom }}@endif</p>
            </div>
        </div>
        <div class="rh-actions">
            <button type="button" class="rh-btn" data-open="editModal">Modifier mes coordonnées</button>
        </div>
    </section>

    @if($manque->isNotEmpty())
        <div class="rh-alert warn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span>Ajoutez {{ $manque->implode(' et ') }} pour que le service RH puisse vous joindre.
                <button type="button" class="rh-link" data-open="editModal" style="padding: 0; color: inherit; text-decoration: underline">Compléter</button></span>
        </div>
    @endif

    <div class="rh-figures">
        <div class="rh-figure"><strong>{{ $personnel->anciennete ?? 0 }}</strong><span>an{{ ($personnel->anciennete ?? 0) > 1 ? 's' : '' }} d'ancienneté</span></div>
        @if(($soldeConges['annuels'] ?? 0) > 0)
            <a href="{{ route('espace-employe.conges') }}" class="rh-figure" style="text-decoration: none; color: inherit"><strong>{{ $soldeConges['restants'] }}</strong><span>jours de congé restants</span></a>
        @endif
        <a href="{{ route('espace-employe.documents') }}" class="rh-figure" style="text-decoration: none; color: inherit"><strong>{{ $personnel->documents()->where('visible_employe', true)->where('confidentiel', false)->count() }}</strong><span>documents dans mon dossier</span></a>
    </div>

    <div class="pf-grid">
        <section class="rh-section" aria-labelledby="titreCoord">
            <div class="rh-section-head">
                <h2 class="rh-h2" id="titreCoord">Coordonnées</h2>
                <button type="button" class="rh-link" data-open="editModal">Modifier</button>
            </div>
            <dl class="pf-dl rh-card-flat">
                <div><dt>E-mail</dt><dd>{{ $personnel->email ?? auth()->user()->email }}</dd></div>
                <div><dt>Téléphone</dt><dd class="{{ $personnel->telephone ? '' : 'vide' }}">{{ $personnel->telephone ? $personnel->telephone_complet : 'Non renseigné' }}</dd></div>
                <div><dt>Adresse</dt><dd class="{{ $personnel->adresse ? '' : 'vide' }}">{{ $vide($personnel->adresse, 'Non renseignée') }}</dd></div>
            </dl>

            <h2 class="rh-h2" style="margin-top: 14px">Identité</h2>
            <dl class="pf-dl rh-card-flat">
                <div><dt>Nom</dt><dd>{{ $personnel->nom }}</dd></div>
                <div><dt>Prénoms</dt><dd>{{ $personnel->prenoms }}</dd></div>
                <div><dt>Civilité</dt><dd class="{{ $personnel->civilite ? '' : 'vide' }}">{{ $vide($personnel->civilite, 'Non renseignée') }}</dd></div>
                <div><dt>Date de naissance</dt><dd class="{{ $personnel->date_naissance ? '' : 'vide' }}">{{ $personnel->date_naissance ? $personnel->date_naissance->format('d/m/Y') : 'Non renseignée' }}</dd></div>
                <div><dt>N° d'identification</dt><dd class="{{ $personnel->numero_identification ? '' : 'vide' }}">{{ $vide($personnel->numero_identification) }}</dd></div>
            </dl>
            <p class="rh-hint">Une erreur dans votre identité ? <a href="{{ route('espace-employe.assistance') }}#nouvelle">Signalez-la au service RH</a>.</p>
        </section>

        <section class="rh-section" aria-labelledby="titreContrat">
            <h2 class="rh-h2" id="titreContrat">Mon contrat</h2>
            <dl class="pf-dl rh-card-flat">
                <div><dt>Matricule</dt><dd>{{ $vide($personnel->matricule) }}</dd></div>
                <div><dt>Poste</dt><dd class="{{ $personnel->poste ? '' : 'vide' }}">{{ $vide($personnel->poste) }}</dd></div>
                <div><dt>Contrat</dt><dd>{{ $personnel->statut_contrat ?? $personnel->type_contrat }}</dd></div>
                <div><dt>Date d'embauche</dt><dd class="{{ $personnel->date_embauche ? '' : 'vide' }}">{{ $personnel->date_embauche ? $personnel->date_embauche->format('d/m/Y') : 'Non renseignée' }}</dd></div>
                @if($personnel->date_fin_contrat)
                    <div><dt>Fin de contrat</dt><dd>{{ $personnel->date_fin_contrat->format('d/m/Y') }}</dd></div>
                @endif
                <div><dt>Entreprise</dt><dd>{{ $personnel->entreprise->nom ?? 'Non renseignée' }}</dd></div>
                @if($personnel->departement)
                    <div><dt>Département</dt><dd>{{ $personnel->departement->nom }}</dd></div>
                @endif
                @if($personnel->service)
                    <div><dt>Service</dt><dd>{{ $personnel->service->nom }}</dd></div>
                @endif
            </dl>

            <ul class="rh-list rh-card-flat" style="margin-top: 14px">
                <li><a href="{{ route('espace-employe.parametres') }}" class="rh-row"><span class="rh-row-main"><span class="rh-row-title">Mot de passe et sécurité</span></span><span aria-hidden="true">›</span></a></li>
                <li><a href="{{ route('espace-employe.attestations') }}" class="rh-row"><span class="rh-row-main"><span class="rh-row-title">Demander une attestation</span></span><span aria-hidden="true">›</span></a></li>
            </ul>
        </section>
    </div>
</div>

{{-- ── Modifier mes coordonnées ─────────────────────────────── --}}
<div class="rh-sheet" id="editModal" role="dialog" aria-modal="true" aria-labelledby="editTitre">
    <div class="rh-sheet-box">
        <div class="rh-sheet-grip"></div>
        <div class="rh-sheet-head">
            <div>
                <h2 id="editTitre">Mes coordonnées</h2>
                <p>Le service RH s'en sert pour vous joindre.</p>
            </div>
            <button type="button" class="rh-iconbtn" data-close aria-label="Fermer">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg>
            </button>
        </div>
        <form action="{{ route('espace-employe.profil.update') }}" method="POST" class="rh-form" data-lock="Enregistrement…">
            @csrf @method('PUT')
            @if($errors->has('telephone') || $errors->has('adresse'))
                <div class="rh-alert err" role="alert">{{ $errors->first('telephone') ?: $errors->first('adresse') }}</div>
            @endif
            <div class="rh-field">
                <label for="telephone">Téléphone</label>
                <input type="tel" name="telephone" id="telephone" class="rh-input" inputmode="tel" autocomplete="tel"
                       value="{{ old('telephone', $personnel->telephone) }}" placeholder="Ex. 70 12 34 56" maxlength="20">
            </div>
            <div class="rh-field">
                <label for="adresse">Adresse</label>
                <input type="text" name="adresse" id="adresse" class="rh-input" autocomplete="street-address"
                       value="{{ old('adresse', $personnel->adresse) }}" placeholder="Ex. secteur 22, Bobo-Dioulasso" maxlength="255">
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
                <p>JPG ou PNG, 2 Mo maximum.</p>
            </div>
            <button type="button" class="rh-iconbtn" data-close aria-label="Fermer">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg>
            </button>
        </div>
        <form action="{{ route('espace-employe.profil.update') }}" method="POST" enctype="multipart/form-data" class="rh-form" data-lock="Envoi…">
            @csrf @method('PUT')
            @error('photo')<div class="rh-alert err" role="alert">{{ $message }}</div>@enderror
            <img id="photoPreview" class="pf-preview" alt="Aperçu de la nouvelle photo">
            <div class="rh-field">
                <label for="photoInput">Choisir une photo</label>
                <input type="file" name="photo" id="photoInput" class="rh-input" accept="image/jpeg,image/png" required>
            </div>
            <div class="rh-sheet-foot">
                <button type="button" class="rh-btn soft" data-close>Annuler</button>
                <button type="submit" class="rh-btn">Enregistrer la photo</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
(function () {
    var input = document.getElementById('photoInput'), prev = document.getElementById('photoPreview');
    input.addEventListener('change', function () {
        if (!input.files || !input.files[0]) return;
        var r = new FileReader();
        r.onload = function (e) { prev.src = e.target.result; prev.classList.add('show'); };
        r.readAsDataURL(input.files[0]);
    });
    @if($errors->has('photo'))
        rhOpen('photoModal');
    @elseif($errors->has('telephone') || $errors->has('adresse'))
        rhOpen('editModal');
    @endif
})();
</script>
@endsection
