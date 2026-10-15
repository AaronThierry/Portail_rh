@extends('layouts.app')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')
@section('page-subtitle', 'Vue d\'ensemble de votre activité')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
    <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
</svg>
@endsection

@section('styles')
<style>
    .db-grid { display: grid; gap: 28px; }
    @media (min-width: 1024px) { .db-grid { grid-template-columns: minmax(0, 1.3fr) minmax(0, 1fr); gap: 40px; } }
</style>
@endsection

@section('content')
@php
    $totalPending = $statsConges['en_attente'] + $statsAbsences['en_attente'];
@endphp

<div class="rh-page">

    <section class="rh-head">
        <div class="rh-head-txt">
            <span class="rh-kicker"><span id="rhGreeting">Bonjour</span>, {{ auth()->user()->prenom ?? explode(' ', auth()->user()->name ?? 'Admin')[0] }}</span>
            <h1 class="rh-h1">Vue d'ensemble de votre portail</h1>
            <p class="rh-lead">{{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}</p>
        </div>
    </section>

    @if($totalPending > 0)
    <div class="rh-alert warn">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
            <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
        </svg>
        <span>
            <strong>{{ $totalPending }} demande{{ $totalPending > 1 ? 's' : '' }} en attente</strong> &mdash;
            @if($statsConges['en_attente'] > 0){{ $statsConges['en_attente'] }} congé{{ $statsConges['en_attente'] > 1 ? 's' : '' }}@endif
            @if($statsConges['en_attente'] > 0 && $statsAbsences['en_attente'] > 0) et @endif
            @if($statsAbsences['en_attente'] > 0){{ $statsAbsences['en_attente'] }} absence{{ $statsAbsences['en_attente'] > 1 ? 's' : '' }}@endif
            nécessite{{ $totalPending > 1 ? 'nt' : '' }} votre validation.
            @if($statsConges['en_attente'] > 0)
                <a href="{{ route('admin.conges.index') }}" class="rh-link">Congés</a>
            @endif
            @if($statsAbsences['en_attente'] > 0)
                <a href="{{ route('admin.absences.index') }}" class="rh-link">Absences</a>
            @endif
        </span>
    </div>
    @endif

    <section class="rh-section" aria-label="Indicateurs clés">
        <div class="rh-figures">
            <a href="{{ route('admin.personnels.index') }}" class="rh-figure" style="text-decoration:none;color:inherit">
                <strong>{{ $totalEmployes }}</strong><span>employé{{ $totalEmployes > 1 ? 's' : '' }} actif{{ $totalEmployes > 1 ? 's' : '' }}</span>
            </a>
            <a href="{{ route('admin.conges.index') }}" class="rh-figure" style="text-decoration:none;color:inherit">
                <strong>{{ $statsConges['en_attente'] }}</strong><span>congé{{ $statsConges['en_attente'] > 1 ? 's' : '' }} en attente</span>
            </a>
            <a href="{{ route('admin.absences.index') }}" class="rh-figure" style="text-decoration:none;color:inherit">
                <strong>{{ $statsAbsences['en_attente'] }}</strong><span>absence{{ $statsAbsences['en_attente'] > 1 ? 's' : '' }} à traiter</span>
            </a>
            <a href="{{ route('admin.bulletins-paie.index') }}" class="rh-figure" style="text-decoration:none;color:inherit">
                <strong>{{ $statsBulletins['total_bulletins'] }}</strong><span>bulletins {{ $annee }}</span>
            </a>
            @if(auth()->user()->hasRole('Super Admin'))
            <a href="{{ route('admin.entreprises.index') }}" class="rh-figure" style="text-decoration:none;color:inherit">
                <strong>{{ $totalEntreprises }}</strong><span>entreprise{{ $totalEntreprises > 1 ? 's' : '' }}</span>
            </a>
            @endif
        </div>
    </section>

    <div class="db-grid">
        <div class="rh-page" style="gap: 28px">
            <section class="rh-section" aria-labelledby="titreActivite">
                <h2 class="rh-h2" id="titreActivite">Activités récentes</h2>
                @if($activitesRecentes->count() > 0)
                    <ul class="rh-list rh-card-flat">
                        @foreach($activitesRecentes as $activite)
                            @php
                                $icoSvg = match($activite['type']) {
                                    'conge','demande_conge' => '<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/>',
                                    'absence'               => '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/>',
                                    'bulletin'               => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>',
                                    default                  => '<path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/>',
                                };
                            @endphp
                            <li>
                                <div class="rh-row">
                                    <span class="rh-ico">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $icoSvg !!}</svg>
                                    </span>
                                    <span class="rh-row-main">
                                        <span class="rh-row-title">{{ $activite['titre'] }}</span>
                                        <span class="rh-row-sub">{{ $activite['description'] }} · {{ $activite['date']->diffForHumans() }}</span>
                                    </span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="rh-lead">Aucune activité récente.</p>
                @endif
            </section>
        </div>

        <div class="rh-page" style="gap: 28px">
            <section class="rh-section" aria-label="Résumé annuel">
                <h2 class="rh-h2">Résumé {{ $annee }}</h2>
                <div class="rh-figures">
                    <div class="rh-figure"><strong>{{ $statsConges['total'] }}</strong><span>total congés</span></div>
                    <div class="rh-figure"><strong>{{ $statsAbsences['total'] }}</strong><span>total absences</span></div>
                    <div class="rh-figure"><strong>{{ $statsAbsences['retards'] }}</strong><span>retards</span></div>
                </div>
                <div class="rh-figures">
                    <div class="rh-figure"><strong>{{ number_format($statsBulletins['masse_salariale_nette'] ?? 0, 0, ',', "\u{202F}") }}&nbsp;F</strong><span>masse salariale nette</span></div>
                    <div class="rh-figure"><strong>{{ $docsExpirentBientot }}</strong><span>document{{ $docsExpirentBientot > 1 ? 's' : '' }} expirant bientôt</span></div>
                </div>
            </section>

            <section class="rh-section" aria-label="Actions rapides">
                <h2 class="rh-h2">Actions rapides</h2>
                <ul class="rh-list rh-card-flat">
                    <li>
                        <a href="{{ route('admin.personnels.index') }}" class="rh-row">
                            <span class="rh-ico">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
                            </span>
                            <span class="rh-row-main">
                                <span class="rh-row-title">Ajouter un employé</span>
                                <span class="rh-row-sub">Nouveau personnel</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.conges.index') }}" class="rh-row">
                            <span class="rh-ico">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            </span>
                            <span class="rh-row-main">
                                <span class="rh-row-title">Gestion des congés</span>
                                <span class="rh-row-sub">Valider les demandes</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.absences.index') }}" class="rh-row">
                            <span class="rh-ico">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            </span>
                            <span class="rh-row-main">
                                <span class="rh-row-title">Gestion des absences</span>
                                <span class="rh-row-sub">Suivre les absences</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.dossiers-agents.index') }}" class="rh-row">
                            <span class="rh-ico">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                            </span>
                            <span class="rh-row-main">
                                <span class="rh-row-title">Dossiers agents</span>
                                <span class="rh-row-sub">Documents RH</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.bulletins-paie.index') }}" class="rh-row">
                            <span class="rh-ico">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                            </span>
                            <span class="rh-row-main">
                                <span class="rh-row-title">Bulletins de paie</span>
                                <span class="rh-row-sub">Fiches de salaire</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.requetes.index') }}" class="rh-row">
                            <span class="rh-ico">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            </span>
                            <span class="rh-row-main">
                                <span class="rh-row-title">Requêtes RH</span>
                                <span class="rh-row-sub">Messages employés</span>
                            </span>
                        </a>
                    </li>
                </ul>
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
