@extends('layouts.app')

@section('title', 'Profil utilisateur')
@section('page-title', 'Profil utilisateur')

@section('styles')
<style>
    .uh-grid { display: grid; gap: 28px; grid-template-columns: minmax(0, 320px) minmax(0, 1fr); align-items: start; }
    @media (max-width: 900px) { .uh-grid { grid-template-columns: 1fr; } }
    .uh-avatar { width: 96px; height: 96px; border-radius: 999px; object-fit: cover; margin: 0 auto 14px; display: block; border: 3px solid var(--line-soft); }
    .uh-name { text-align: center; font-family: var(--display); font-size: 20px; font-weight: 700; margin: 0 0 2px; }
    .uh-email { text-align: center; color: var(--muted); font-size: 14px; margin: 0 0 14px; }
    .uh-badges { display: flex; justify-content: center; gap: 6px; margin-bottom: 18px; flex-wrap: wrap; }
    .uh-actions { display: flex; flex-direction: column; gap: 8px; }
    .uh-dl div { display: flex; justify-content: space-between; gap: 16px; padding: 14px 16px; border-top: 1px solid var(--line-soft); }
    .uh-dl div:first-child { border-top: 0; }
    .uh-dl dt { color: var(--muted); font-size: 14px; flex-shrink: 0; }
    .uh-dl dd { margin: 0; font-weight: 600; font-size: 15px; text-align: right; overflow-wrap: anywhere; }
    .uh-dl dd.vide { color: var(--faint); font-weight: 500; }
    .uh-deact { margin-top: 18px; flex-direction: column; align-items: stretch; gap: 10px; }
    .uh-deact-head { display: flex; align-items: center; gap: 8px; font-family: var(--display); font-size: 15px; font-weight: 700; }
    .uh-deact dl { margin: 0; display: flex; flex-direction: column; gap: 5px; }
    .uh-deact dl div { display: flex; justify-content: space-between; gap: 12px; font-size: 13px; }
    .uh-deact dt { opacity: .8; font-weight: 500; }
    .uh-deact dd { margin: 0; font-weight: 700; text-align: right; }
</style>
@endsection

@section('content')
@php
    $roleName = $user->getRoleNames()->first() ?? 'Aucun rôle';
    $personnel = $user->personnel;
    $vide = fn ($v) => $v ?: null;
@endphp

<div class="rh-page">
    @if(session('success'))
        <div class="rh-alert ok" role="status"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg><span>{{ session('success') }}</span></div>
    @endif
    @if(session('error'))
        <div class="rh-alert err" role="alert"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 8v5M12 16h.01"/></svg><span>{{ session('error') }}</span></div>
    @endif

    <section class="rh-head">
        <div class="rh-head-txt">
            <a href="{{ route('admin.utilisateurs.index') }}" class="rh-link">← Retour à la liste</a>
            <h1 class="rh-h1" style="margin-top:6px">Profil utilisateur</h1>
        </div>
    </section>

    <div class="uh-grid">
        <div class="rh-card">
            <img src="{{ $user->avatar ? asset($user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=200&background=2563EB&color=fff&bold=true' }}" alt="" class="uh-avatar">
            <h2 class="uh-name">{{ $user->name }}</h2>
            <p class="uh-email">{{ $user->email }}</p>
            <div class="uh-badges">
                <span class="rh-badge info">{{ $roleName }}</span>
                <span class="rh-badge {{ $user->status === 'active' ? 'ok' : 'no' }}">{{ $user->status === 'active' ? 'Actif' : 'Inactif' }}</span>
            </div>
            <div class="uh-actions">
                <a href="{{ route('admin.utilisateurs.edit', $user->id) }}" class="rh-btn block">Modifier</a>
                @if($user->id !== auth()->id())
                    @if($user->status === 'active')
                        <button type="button" class="rh-btn block danger" data-open="deactivateModal">Désactiver ce compte</button>
                    @else
                        <form method="POST" action="{{ route('admin.utilisateurs.toggle-status', $user->id) }}" data-confirm="Réactiver ce compte ?">
                            @csrf
                            <button type="submit" class="rh-btn block soft">Réactiver ce compte</button>
                        </form>
                    @endif
                @endif
            </div>

            @if($user->status === 'inactive' && $user->desactive_le)
                <div class="rh-alert err uh-deact" role="status">
                    <div class="uh-deact-head">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 8v4M12 16h.01"/></svg>
                        <span>Compte désactivé{{ $user->motif_desactivation_label ? ' — ' . $user->motif_desactivation_label : '' }}</span>
                    </div>
                    <dl>
                        @if($user->date_motif_desactivation)
                            <div><dt>Date d'effet</dt><dd>{{ $user->date_motif_desactivation->format('d/m/Y') }}</dd></div>
                        @endif
                        <div><dt>Désactivé le</dt><dd>{{ $user->desactive_le->format('d/m/Y à H:i') }}</dd></div>
                        @if($user->desactivePar)
                            <div><dt>Par</dt><dd>{{ $user->desactivePar->name }}</dd></div>
                        @endif
                    </dl>
                </div>
            @endif
        </div>

        <div class="rh-page" style="gap: 20px">
            <section class="rh-section" aria-labelledby="uhPerso">
                <h2 class="rh-h2" id="uhPerso">Informations personnelles</h2>
                <dl class="uh-dl rh-card-flat">
                    <div><dt>Nom</dt><dd class="{{ $personnel ? '' : 'vide' }}">{{ $personnel->nom ?? 'Aucun personnel lié' }}</dd></div>
                    <div><dt>Prénoms</dt><dd class="{{ $personnel?->prenoms ? '' : 'vide' }}">{{ $personnel->prenoms ?? 'Non renseigné' }}</dd></div>
                    <div><dt>Téléphone</dt><dd class="{{ $personnel?->telephone ? '' : 'vide' }}">{{ $personnel?->telephone_complet ?? 'Non renseigné' }}</dd></div>
                    <div><dt>Date de naissance</dt><dd class="{{ $personnel?->date_naissance ? '' : 'vide' }}">{{ $personnel?->date_naissance ? $personnel->date_naissance->format('d/m/Y') : 'Non renseignée' }}</dd></div>
                    <div><dt>Adresse</dt><dd class="{{ $personnel?->adresse ? '' : 'vide' }}">{{ $personnel->adresse ?? 'Non renseignée' }}</dd></div>
                </dl>
            </section>

            <section class="rh-section" aria-labelledby="uhPro">
                <h2 class="rh-h2" id="uhPro">Informations professionnelles</h2>
                <dl class="uh-dl rh-card-flat">
                    <div><dt>Matricule</dt><dd class="{{ $personnel?->matricule ? '' : 'vide' }}">{{ $personnel->matricule ?? 'Non renseigné' }}</dd></div>
                    <div><dt>Poste</dt><dd class="{{ $personnel?->poste ? '' : 'vide' }}">{{ $personnel->poste ?? 'Non renseigné' }}</dd></div>
                    <div><dt>Entreprise</dt><dd class="{{ $user->entreprise ? '' : 'vide' }}">{{ $user->entreprise->nom ?? 'Non renseignée' }}</dd></div>
                    @if($personnel?->departement)
                        <div><dt>Département</dt><dd>{{ $personnel->departement->nom }}</dd></div>
                    @endif
                    @if($personnel?->service)
                        <div><dt>Service</dt><dd>{{ $personnel->service->nom }}</dd></div>
                    @endif
                    <div><dt>Date d'embauche</dt><dd class="{{ $personnel?->date_embauche ? '' : 'vide' }}">{{ $personnel?->date_embauche ? $personnel->date_embauche->format('d/m/Y') : 'Non renseignée' }}</dd></div>
                    <div><dt>Type de contrat</dt><dd class="{{ $personnel?->type_contrat ? '' : 'vide' }}">{{ $personnel->type_contrat ?? 'Non renseigné' }}</dd></div>
                </dl>
            </section>

            <section class="rh-section" aria-labelledby="uhHisto">
                <h2 class="rh-h2" id="uhHisto">Historique</h2>
                <ol class="rh-timeline rh-card-flat" style="padding: 14px 16px">
                    <li style="--rail: var(--ok)">
                        <span class="d">{{ $user->created_at->format('d/m/Y') }}</span>
                        <span class="rail"></span>
                        <span class="body">
                            <span class="rh-row-title">Compte créé</span>
                            <span class="rh-row-sub">{{ $user->created_at->format('H:i') }}</span>
                        </span>
                    </li>
                    @if($user->updated_at && !$user->updated_at->equalTo($user->created_at))
                        <li style="--rail: var(--brand)">
                            <span class="d">{{ $user->updated_at->format('d/m/Y') }}</span>
                            <span class="rail"></span>
                            <span class="body">
                                <span class="rh-row-title">Dernière modification</span>
                                <span class="rh-row-sub">{{ $user->updated_at->format('H:i') }}</span>
                            </span>
                        </li>
                    @endif
                    @if($user->desactive_le)
                        <li style="--rail: var(--no)">
                            <span class="d">{{ $user->desactive_le->format('d/m/Y') }}</span>
                            <span class="rail"></span>
                            <span class="body">
                                <span class="rh-row-title">Compte désactivé{{ $user->motif_desactivation_label ? ' — ' . $user->motif_desactivation_label : '' }}</span>
                                <span class="rh-row-sub">{{ $user->desactive_le->format('H:i') }}@if($user->desactivePar) · par {{ $user->desactivePar->name }}@endif</span>
                                @if($user->date_motif_desactivation)
                                    <span class="rh-row-sub">Date d'effet : {{ $user->date_motif_desactivation->format('d/m/Y') }}</span>
                                @endif
                            </span>
                        </li>
                    @endif
                </ol>
            </section>
        </div>
    </div>
</div>

@if($user->status === 'active' && $user->id !== auth()->id())
<div class="rh-sheet" id="deactivateModal" role="dialog" aria-modal="true" aria-labelledby="deactivateTitre">
    <div class="rh-sheet-box">
        <div class="rh-sheet-grip"></div>
        <div class="rh-sheet-head">
            <div>
                <h2 id="deactivateTitre">Désactiver ce compte</h2>
                <p>{{ $user->name }} ne pourra plus se connecter. La date et l'heure sont enregistrées automatiquement.</p>
            </div>
            <button type="button" class="rh-iconbtn" data-close aria-label="Fermer">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.utilisateurs.toggle-status', $user->id) }}" class="rh-form">
            @csrf
            <div class="rh-field">
                <label for="motifDesactivation">Motif</label>
                <select name="motif_desactivation" id="motifDesactivation" class="rh-select" required>
                    <option value="">— Sélectionner —</option>
                    <option value="demission">Démission</option>
                    <option value="licenciement">Licenciement</option>
                    <option value="fin_contrat">Fin de contrat</option>
                    <option value="autre">Autre</option>
                </select>
                @error('motif_desactivation')<p class="rh-err">{{ $message }}</p>@enderror
            </div>
            <div class="rh-field">
                <label for="dateMotifDesactivation">Date d'effet</label>
                <input type="date" name="date_motif_desactivation" id="dateMotifDesactivation" class="rh-input" value="{{ old('date_motif_desactivation', now()->format('Y-m-d')) }}" required>
                <p class="rh-hint">Date réelle du départ (dernier jour travaillé). L'horodatage de l'action est, lui, enregistré automatiquement.</p>
                @error('date_motif_desactivation')<p class="rh-err">{{ $message }}</p>@enderror
            </div>
            <div class="rh-sheet-foot">
                <button type="button" class="rh-btn soft" data-close>Annuler</button>
                <button type="submit" class="rh-btn danger">Désactiver</button>
            </div>
        </form>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
@if($errors->has('motif_desactivation') || $errors->has('date_motif_desactivation'))
    rhOpen('deactivateModal');
@endif
</script>
@endsection
