@extends('layouts.espace-employe')

@section('title', 'Accueil')

@section('styles')
<style>
    .db-grid { display: grid; gap: 28px; }
    @media (min-width: 1024px) { .db-grid { grid-template-columns: minmax(0, 1.3fr) minmax(0, 1fr); gap: 40px; } }
    .db-hero .rh-h1 { max-width: 20ch; }
</style>
@endsection

@section('content')
@php
    $prenom   = $personnel->prenoms ?? auth()->user()->name;
    $annee    = now()->year;
    $restants = $soldeConges['restants'] ?? 0;
    $attente  = $soldeConges['en_attente'] ?? 0;
    $jours    = fn ($n) => $n . ' jour' . (abs($n) > 1 ? 's' : '');
@endphp

<div class="rh-page">

    <section class="rh-head db-hero">
        <div class="rh-head-txt">
            <span class="rh-kicker"><span id="rhGreeting">Bonjour</span> {{ $prenom }},</span>
            @if(($soldeConges['annuels'] ?? 0) > 0)
                <h1 class="rh-h1">Il vous reste {{ $jours($restants) }} de congé en {{ $annee }}.</h1>
                @if($attente > 0)
                    <p class="rh-lead">{{ $jours($restants - $attente) }} si vos demandes en attente ({{ $jours($attente) }}) sont acceptées.</p>
                @endif
            @else
                <h1 class="rh-h1">Bienvenue sur votre espace.</h1>
                <p class="rh-lead">Votre solde de congés apparaîtra ici dès que votre service RH l'aura paramétré.</p>
            @endif
        </div>
        <div class="rh-actions">
            <a href="{{ route('espace-employe.conges', ['nouveau' => 1]) }}" class="rh-btn">Poser un congé</a>
            <a href="{{ route('espace-employe.absences', ['nouveau' => 1]) }}" class="rh-btn ghost">Déclarer une absence</a>
        </div>
    </section>

    <section class="rh-card rh-section" aria-labelledby="titreAnnee">
        <div class="rh-section-head">
            <h2 class="rh-h2" id="titreAnnee">Votre année {{ $annee }}</h2>
            <a href="{{ route('espace-employe.conges') }}" class="rh-link">Détail des congés</a>
        </div>
        @include('espace-employe.partials.annee', ['calendrier' => $calendrier ?? []])
    </section>

    <div class="db-grid">
        <div class="rh-page" style="gap: 28px">
            <section class="rh-section" aria-labelledby="titreVenir">
                <h2 class="rh-h2" id="titreVenir">À venir</h2>
                @if(($aVenir ?? collect())->isNotEmpty())
                    <ol class="rh-timeline">
                        @foreach($aVenir as $c)
                            @php
                                $rail = $c->statut === 'approuve' ? 'var(--brand)' : '#f59e0b';
                                $quand = $c->date_debut->lte(now()) ? 'En cours' : $c->date_debut->translatedFormat('j M');
                            @endphp
                            <li style="--rail: {{ $rail }}">
                                <span class="d">{{ $quand }}</span>
                                <span class="rail"></span>
                                <span class="body">
                                    <span class="rh-row-title">{{ $c->typeConge->nom ?? 'Congé' }}, {{ $jours($c->nombre_jours) }}</span>
                                    <span class="rh-row-sub">
                                        Du {{ $c->date_debut->translatedFormat('j F') }} au {{ $c->date_fin->translatedFormat('j F Y') }}
                                        · @switch($c->statut)
                                            @case('en_attente') en attente de votre responsable @break
                                            @case('valide_chef') validé par votre responsable, en attente de la RH @break
                                            @default approuvé
                                        @endswitch
                                    </span>
                                </span>
                            </li>
                        @endforeach
                    </ol>
                @else
                    <p class="rh-lead">Aucun congé prévu pour l'instant.</p>
                @endif
            </section>

            <section class="rh-section" aria-labelledby="titreActivite">
                <h2 class="rh-h2" id="titreActivite">Activité récente</h2>
                @if(count($activities) > 0)
                    <ul class="rh-list rh-card-flat">
                        @foreach($activities as $activity)
                            @php
                                $url = ($activity['icon'] ?? 'file') === 'calendar'
                                    ? route('espace-employe.conges')
                                    : route('espace-employe.documents');
                            @endphp
                            <li>
                                <a href="{{ $url }}" class="rh-row">
                                    <span class="rh-row-main">
                                        <span class="rh-row-title">{{ $activity['title'] }}</span>
                                        <span class="rh-row-sub">{{ $activity['date']->diffForHumans() }}</span>
                                    </span>
                                    @if($activity['date']->isToday())
                                        <span class="rh-badge new">Nouveau</span>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="rh-lead">Rien de nouveau pour le moment.</p>
                @endif
            </section>
        </div>

        <div class="rh-page" style="gap: 28px">
            <section class="rh-section" aria-labelledby="titreBulletin">
                <h2 class="rh-h2" id="titreBulletin">Dernier bulletin</h2>
                @if($dernierBulletin ?? null)
                    <div class="rh-card" style="display: flex; flex-direction: column; gap: 14px">
                        <div>
                            <div class="rh-row-sub">Mis à disposition le {{ $dernierBulletin->created_at->translatedFormat('j F Y') }}</div>
                            <div style="font-family: var(--display); font-size: 24px; font-weight: 700; letter-spacing: -0.01em">{{ $dernierBulletin->periode_formatee }}</div>
                        </div>
                        <div class="rh-actions">
                            <a href="{{ route('espace-employe.bulletins.download', $dernierBulletin) }}" class="rh-btn" style="flex: 1">Télécharger le PDF</a>
                            <a href="{{ route('espace-employe.bulletins', ['annee' => $dernierBulletin->annee, 'mois' => $dernierBulletin->mois]) }}" class="rh-btn soft">Aperçu</a>
                        </div>
                    </div>
                @else
                    <p class="rh-lead">Vos bulletins de paie apparaîtront ici dès leur mise à disposition.</p>
                @endif
            </section>

            <section class="rh-section" aria-label="En bref">
                <div class="rh-figures">
                    <a href="{{ route('espace-employe.demandes') }}" class="rh-figure" style="text-decoration: none; color: inherit">
                        <strong>{{ $stats['demandes_en_cours'] }}</strong><span>demande{{ $stats['demandes_en_cours'] > 1 ? 's' : '' }} en attente</span>
                    </a>
                    <a href="{{ route('espace-employe.documents') }}" class="rh-figure" style="text-decoration: none; color: inherit">
                        <strong>{{ $stats['documents'] }}</strong><span>document{{ $stats['documents'] > 1 ? 's' : '' }} dans votre dossier</span>
                    </a>
                    <a href="{{ route('espace-employe.profil') }}" class="rh-figure" style="text-decoration: none; color: inherit">
                        <strong>{{ $stats['anciennete'] }}</strong><span>an{{ $stats['anciennete'] > 1 ? 's' : '' }} d'ancienneté</span>
                    </a>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
(function () {
    var h = new Date().getHours(), el = document.getElementById('rhGreeting');
    if (el) el.textContent = h < 18 ? 'Bonjour' : 'Bonsoir';
})();
</script>
@endsection
