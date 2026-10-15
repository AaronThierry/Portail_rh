{{--
    Frise décorative de l'année en cours : un trait par jour.
    Jours écoulés plus foncés, week-ends plus clairs, aujourd'hui en orange.
    Paramètre : $labels (bool) — affiche le nom des mois au-dessus des colonnes.
--}}
@php
    $now   = now();
    $annee = $now->year;
    $noms  = ['janv.', 'févr.', 'mars', 'avr.', 'mai', 'juin', 'juil.', 'août', 'sept.', 'oct.', 'nov.', 'déc.'];
@endphp
<div class="year" aria-hidden="true">
    @foreach(range(1, 12) as $m)
        <div class="year-m">
            @if(!empty($labels))
                <em class="year-lbl {{ $m === $now->month ? 'now' : '' }}">{{ $noms[$m - 1] }}</em>
            @endif
            @foreach(range(1, \Carbon\Carbon::create($annee, $m, 1)->daysInMonth) as $d)
                @php
                    $date = \Carbon\Carbon::create($annee, $m, $d);
                    $cls = $date->isSameDay($now) ? 't' : ($date->lt($now) ? ($date->isWeekend() ? 'pw' : 'p') : ($date->isWeekend() ? 'w' : ''));
                @endphp<span class="{{ $cls }}"></span>
            @endforeach
        </div>
    @endforeach
</div>
