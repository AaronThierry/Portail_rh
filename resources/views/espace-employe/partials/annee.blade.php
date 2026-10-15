{{--
    Frise de l'année en cours, un trait par jour.
    Paramètre : $calendrier = ['2026-04-13' => 'c' (congé pris) | 'a' (en attente) | 'x' (absence), …]
    Week-ends plus clairs, jours fériés fixes encadrés, aujourd'hui en orange.
--}}
@php
    $rhNow    = now()->startOfDay();
    $rhYear   = $rhNow->year;
    $rhMois   = ['janv.', 'févr.', 'mars', 'avr.', 'mai', 'juin', 'juil.', 'août', 'sept.', 'oct.', 'nov.', 'déc.'];
    // Jours fériés à date fixe au Burkina Faso (les fêtes religieuses mobiles ne sont pas incluses)
    $rhFeries = ['01-01', '01-03', '03-08', '05-01', '08-05', '08-15', '11-01', '12-11', '12-25'];
    $calendrier = $calendrier ?? [];
@endphp
<div class="rh-year" aria-hidden="true">
    @foreach(range(1, 12) as $m)
        <div class="rh-year-m">
            <em class="{{ $m === $rhNow->month ? 'now' : '' }}"><span class="s">{{ mb_strtoupper(mb_substr($rhMois[$m - 1], 0, 1)) }}</span><span class="l">{{ $rhMois[$m - 1] }}</span></em>
            @foreach(range(1, \Carbon\Carbon::create($rhYear, $m, 1)->daysInMonth) as $d)
                @php
                    $rhDate = \Carbon\Carbon::create($rhYear, $m, $d);
                    $rhKey  = $rhDate->format('Y-m-d');
                    if ($rhDate->isSameDay($rhNow))                        $rhC = 't';
                    elseif (isset($calendrier[$rhKey]))                     $rhC = $calendrier[$rhKey];
                    elseif (in_array($rhDate->format('m-d'), $rhFeries))    $rhC = 'f';
                    elseif ($rhDate->lt($rhNow))                            $rhC = $rhDate->isWeekend() ? 'pw' : 'p';
                    else                                                    $rhC = $rhDate->isWeekend() ? 'w' : '';
                @endphp<i class="{{ $rhC }}"></i>
            @endforeach
        </div>
    @endforeach
</div>
<div class="rh-legend">
    <span><i style="background: var(--brand)"></i>Congés pris</span>
    <span><i style="background: #f59e0b"></i>En attente</span>
    <span><i style="background: #a78bfa"></i>Absences</span>
    <span><i style="box-shadow: inset 0 0 0 1px var(--faint)"></i>Férié</span>
    <span><i style="background: var(--orange)"></i>Aujourd'hui</span>
</div>
