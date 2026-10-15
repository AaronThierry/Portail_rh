{{--
    Onglets d'une section de l'espace employé.
    Paramètre : $section = 'demandes' | 'documents'
--}}
@php
    $rhTabs = $section === 'demandes'
        ? [
            ['route' => 'espace-employe.conges',    'match' => 'espace-employe.conges*',    'label' => 'Congés'],
            ['route' => 'espace-employe.absences',  'match' => 'espace-employe.absences*',  'label' => 'Absences'],
            ['route' => 'espace-employe.demandes',  'match' => 'espace-employe.demandes',   'label' => 'Historique'],
          ]
        : [
            ['route' => 'espace-employe.bulletins',    'match' => 'espace-employe.bulletins*',  'label' => 'Bulletins de paie'],
            ['route' => 'espace-employe.documents',    'match' => 'espace-employe.documents*',  'label' => 'Mon dossier'],
            ['route' => 'espace-employe.attestations', 'match' => 'espace-employe.attestations', 'label' => 'Attestations'],
          ];
@endphp
<nav class="rh-tabs" aria-label="{{ $section === 'demandes' ? 'Congés et absences' : 'Documents' }}">
    @foreach($rhTabs as $t)
        <a href="{{ route($t['route']) }}" @if(request()->routeIs($t['match'])) aria-current="page" @endif>{{ $t['label'] }}</a>
    @endforeach
</nav>
