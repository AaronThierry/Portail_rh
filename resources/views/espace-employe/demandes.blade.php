@extends('layouts.espace-employe')

@section('title', 'Historique des demandes')

@section('content')
@php
    $compte = [
        'all'        => $demandes->count(),
        'en_attente' => $demandes->whereIn('statut', ['en_attente', 'valide_chef'])->count(),
        'approuve'   => $demandes->where('statut', 'approuve')->count(),
        'refuse'     => $demandes->whereIn('statut', ['refuse', 'annule'])->count(),
    ];
    $jours = fn ($n) => $n . ' jour' . (abs($n) > 1 ? 's' : '');
@endphp

<div class="rh-page">
    @include('espace-employe.partials.tabs', ['section' => 'demandes'])

    <section class="rh-head">
        <div class="rh-head-txt">
            <h1 class="rh-h1">Historique des demandes</h1>
            <p class="rh-lead">Toutes vos demandes de congé, toutes années confondues.</p>
        </div>
        <div class="rh-actions">
            <a href="{{ route('espace-employe.conges', ['nouveau' => 1]) }}" class="rh-btn">Poser un congé</a>
        </div>
    </section>

    <section class="rh-section">
        <div class="rh-tabs" role="group" aria-label="Filtrer par statut" style="margin: 0; padding: 0">
            @foreach(['all' => 'Toutes', 'en_attente' => 'En attente', 'approuve' => 'Approuvées', 'refuse' => 'Refusées ou annulées'] as $k => $lbl)
                <a href="#" data-filter="{{ $k }}" @if($k === 'all') aria-current="page" @endif role="button">{{ $lbl }} ({{ $compte[$k] }})</a>
            @endforeach
        </div>

        @if($demandes->count() > 0)
            <ul class="rh-list rh-card-flat" id="listeDemandes">
                @foreach($demandes as $demande)
                    @php
                        $groupe = match ($demande->statut) {
                            'en_attente', 'valide_chef' => 'en_attente',
                            'refuse', 'annule'          => 'refuse',
                            default                     => $demande->statut,
                        };
                    @endphp
                    <li data-statut="{{ $groupe }}">
                        <div class="rh-row">
                            <span class="rh-swatch" style="background: {{ $demande->typeConge->couleur ?? 'var(--brand)' }}"></span>
                            <span class="rh-row-main">
                                <span class="rh-row-title">{{ $demande->typeConge->nom ?? 'Congé' }}, {{ $jours($demande->nombre_jours) }}</span>
                                <span class="rh-row-sub">Du {{ $demande->date_debut->format('d/m/Y') }} au {{ $demande->date_fin->format('d/m/Y') }} · envoyée {{ $demande->created_at->diffForHumans() }}</span>
                            </span>
                            <span class="rh-row-end">@include('espace-employe.partials.statut', ['statut' => $demande->statut])</span>
                        </div>
                    </li>
                @endforeach
            </ul>
            <p class="rh-lead" id="aucunResultat" hidden>Aucune demande avec ce statut.</p>
        @else
            <div class="rh-card rh-empty">
                <strong>Aucune demande pour l'instant</strong>
                <p>Vos demandes de congé et leur avancement s'afficheront ici.</p>
            </div>
        @endif
    </section>

    <section class="rh-section" aria-labelledby="titreAutres">
        <h2 class="rh-h2" id="titreAutres">Autre chose à demander ?</h2>
        <ul class="rh-list rh-card-flat">
            <li><a href="{{ route('espace-employe.absences', ['nouveau' => 1]) }}" class="rh-row"><span class="rh-row-main"><span class="rh-row-title">Déclarer une absence ou un retard</span></span><span aria-hidden="true">›</span></a></li>
            <li><a href="{{ route('espace-employe.attestations') }}" class="rh-row"><span class="rh-row-main"><span class="rh-row-title">Demander une attestation</span><span class="rh-row-sub">Travail, salaire ou présence</span></span><span aria-hidden="true">›</span></a></li>
            <li><a href="{{ route('espace-employe.assistance') }}#nouvelle" class="rh-row"><span class="rh-row-main"><span class="rh-row-title">Autre demande au service RH</span><span class="rh-row-sub">Avance sur salaire, changement d'informations…</span></span><span aria-hidden="true">›</span></a></li>
        </ul>
    </section>
</div>
@endsection

@section('scripts')
<script>
(function () {
    var pills = document.querySelectorAll('[data-filter]');
    var rows  = document.querySelectorAll('#listeDemandes > li');
    var none  = document.getElementById('aucunResultat');
    pills.forEach(function (p) {
        p.addEventListener('click', function (e) {
            e.preventDefault();
            pills.forEach(function (x) { x.removeAttribute('aria-current'); });
            p.setAttribute('aria-current', 'page');
            var f = p.dataset.filter, shown = 0;
            rows.forEach(function (r) {
                var ok = f === 'all' || r.dataset.statut === f;
                r.hidden = !ok;
                if (ok) shown++;
            });
            if (none) none.hidden = shown > 0;
        });
    });
})();
</script>
@endsection
