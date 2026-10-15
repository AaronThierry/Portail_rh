@extends('layouts.espace-employe')

@section('title', 'Mes absences')

@section('content')
<div class="rh-page">
    @include('espace-employe.partials.tabs', ['section' => 'demandes'])

    <section class="rh-head">
        <div class="rh-head-txt">
            <h1 class="rh-h1">Mes absences</h1>
            <p class="rh-lead">Déclarez une absence ou un retard, et envoyez un justificatif si besoin.</p>
        </div>
        <div class="rh-actions">
            <button type="button" class="rh-btn" data-open="declareAbsenceModal">Déclarer une absence</button>
        </div>
    </section>

    <div class="rh-figures" aria-label="Bilan {{ $annee }}">
        <div class="rh-figure"><strong>{{ $statsAbsences['total'] }}</strong><span>absence{{ $statsAbsences['total'] > 1 ? 's' : '' }} en {{ $annee }}</span></div>
        <div class="rh-figure"><strong>{{ $statsAbsences['justifiees'] }}</strong><span>justifiée{{ $statsAbsences['justifiees'] > 1 ? 's' : '' }}</span></div>
        <div class="rh-figure"><strong>{{ $statsAbsences['injustifiees'] }}</strong><span>sans justificatif</span></div>
        <div class="rh-figure"><strong>{{ $statsAbsences['retards'] }}</strong><span>retard{{ $statsAbsences['retards'] > 1 ? 's' : '' }}</span></div>
        @isset($statsAbsences['en_attente'])
            <div class="rh-figure"><strong>{{ $statsAbsences['en_attente'] }}</strong><span>en attente</span></div>
        @endisset
    </div>

    <section class="rh-section" aria-labelledby="titreAbs">
        <div class="rh-section-head">
            <h2 class="rh-h2" id="titreAbs">Absences {{ $annee }}</h2>
            @if(count($anneesDisponibles) > 1)
                <label class="rh-sr" for="anneeSelect">Année</label>
                <select id="anneeSelect" class="rh-select" style="width: auto; min-height: 40px"
                        onchange="window.location.href='{{ route('espace-employe.absences') }}?annee=' + this.value">
                    @foreach($anneesDisponibles as $a)
                        <option value="{{ $a }}" {{ $a == $annee ? 'selected' : '' }}>{{ $a }}</option>
                    @endforeach
                </select>
            @endif
        </div>

        @if($absences->count() > 0)
            <ul class="rh-list rh-card-flat">
                @foreach($absences as $absence)
                    <li>
                        <div class="rh-row" style="flex-wrap: wrap">
                            <span class="rh-swatch" style="background: {{ $absence->typeAbsence->couleur ?? 'var(--brand)' }}"></span>
                            <span class="rh-row-main" style="min-width: 180px">
                                <span class="rh-row-title">{{ $absence->typeAbsence->nom ?? 'Absence' }}</span>
                                <span class="rh-row-sub">
                                    {{ $absence->date_absence->translatedFormat('l j F Y') }} · {{ $absence->duree_label }}
                                    · {{ $absence->justifiee ? 'justifiée' : 'sans justificatif' }}
                                    @if($absence->motif)<br>{{ $absence->motif }}@endif
                                    @if($absence->statut === 'refusee' && $absence->motif_refus)
                                        <br><span style="color: var(--no)">Motif du refus : {{ $absence->motif_refus }}</span>
                                    @endif
                                </span>
                            </span>
                            <span class="rh-row-end">
                                @include('espace-employe.partials.statut', ['statut' => $absence->statut])
                                @if(!$absence->justifiee && $absence->statut === 'approuvee' && $absence->source === 'admin')
                                    <button type="button" class="rh-btn soft sm"
                                            data-justifier="{{ route('espace-employe.absences.justifier', $absence) }}"
                                            data-id="{{ $absence->id }}">Envoyer un justificatif</button>
                                @endif
                                @if($absence->statut === 'en_attente' && $absence->source === 'employe')
                                    <form action="{{ route('espace-employe.absences.annuler', $absence) }}" method="POST" data-confirm="Annuler cette déclaration d'absence ?">
                                        @csrf
                                        <button type="submit" class="rh-btn danger sm">Annuler</button>
                                    </form>
                                @endif
                            </span>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="rh-card rh-empty">
                <strong>Aucune absence en {{ $annee }}</strong>
                <p>Les absences déclarées par vous ou par le service RH s'afficheront ici.</p>
            </div>
        @endif
    </section>
</div>

{{-- ── Déclarer une absence ─────────────────────────────────── --}}
<div class="rh-sheet" id="declareAbsenceModal" role="dialog" aria-modal="true" aria-labelledby="absTitre">
    <div class="rh-sheet-box">
        <div class="rh-sheet-grip"></div>
        <div class="rh-sheet-head">
            <div>
                <h2 id="absTitre">Déclarer une absence</h2>
                <p>Le service RH est prévenu dès l'envoi.</p>
            </div>
            <button type="button" class="rh-iconbtn" data-close aria-label="Fermer">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg>
            </button>
        </div>

        <form action="{{ route('espace-employe.absences.store') }}" method="POST" enctype="multipart/form-data" class="rh-form" data-lock="Envoi…">
            @csrf
            @if($errors->any() && !old('_justifier'))
                <div class="rh-alert err" role="alert"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif

            <div class="rh-field">
                <label for="type_absence_id">Type d'absence</label>
                <select name="type_absence_id" id="type_absence_id" class="rh-select" required>
                    <option value="">Choisissez un type</option>
                    @foreach($typesAbsence as $type)
                        <option value="{{ $type->id }}" {{ old('type_absence_id') == $type->id ? 'selected' : '' }}>{{ $type->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div class="rh-grid2">
                <div class="rh-field">
                    <label for="date_absence">Date</label>
                    <input type="date" name="date_absence" id="date_absence" class="rh-input" value="{{ old('date_absence') }}" required>
                </div>
                <div class="rh-field">
                    <label for="dureeTypeSelect">Durée</label>
                    <select name="duree_type" id="dureeTypeSelect" class="rh-select" required>
                        <option value="">Choisissez</option>
                        <option value="journee" {{ old('duree_type') == 'journee' ? 'selected' : '' }}>Journée entière</option>
                        <option value="demi_journee" {{ old('duree_type') == 'demi_journee' ? 'selected' : '' }}>Demi-journée</option>
                        <option value="retard" {{ old('duree_type') == 'retard' ? 'selected' : '' }}>Retard</option>
                        <option value="depart_anticipe" {{ old('duree_type') == 'depart_anticipe' ? 'selected' : '' }}>Départ anticipé</option>
                    </select>
                </div>
            </div>

            <div class="rh-field" id="minutesRetardGroup" hidden>
                <label for="minutesRetardInput">Durée du retard, en minutes</label>
                <input type="number" name="minutes_retard" id="minutesRetardInput" class="rh-input" inputmode="numeric"
                       value="{{ old('minutes_retard') }}" min="1" max="480" placeholder="Ex. 30">
            </div>

            <div class="rh-field">
                <label for="motifAbs">Motif</label>
                <textarea name="motif" id="motifAbs" class="rh-textarea" rows="3" required placeholder="Ex. rendez-vous médical">{{ old('_justifier') ? '' : old('motif') }}</textarea>
            </div>

            <div class="rh-field">
                <label for="justificatifAbs">Justificatif <span class="rh-opt">(facultatif)</span></label>
                <input type="file" name="justificatif" id="justificatifAbs" class="rh-input" accept=".pdf,.jpg,.jpeg,.png">
                <span class="rh-hint">Photo, PDF, JPG ou PNG, 5 Mo maximum.</span>
            </div>

            <div class="rh-sheet-foot">
                <button type="button" class="rh-btn soft" data-close>Annuler</button>
                <button type="submit" class="rh-btn">Déclarer l'absence</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Justifier une absence ────────────────────────────────── --}}
<div class="rh-sheet" id="justifyModal" role="dialog" aria-modal="true" aria-labelledby="justTitre">
    <div class="rh-sheet-box">
        <div class="rh-sheet-grip"></div>
        <div class="rh-sheet-head">
            <div>
                <h2 id="justTitre">Envoyer un justificatif</h2>
                <p>Il sera joint à l'absence et transmis au service RH.</p>
            </div>
            <button type="button" class="rh-iconbtn" data-close aria-label="Fermer">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg>
            </button>
        </div>
        <form id="justifyForm" method="POST" enctype="multipart/form-data" class="rh-form" data-lock="Envoi…"
              @if(old('_justifier')) action="{{ url('mon-espace/absences/' . (int) old('_justifier') . '/justifier') }}" @endif>
            @csrf
            <input type="hidden" name="_justifier" id="justifyId" value="{{ old('_justifier') }}">
            @if($errors->any() && old('_justifier'))
                <div class="rh-alert err" role="alert"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif
            <div class="rh-field">
                <label for="justifFile">Justificatif</label>
                <input type="file" name="justificatif" id="justifFile" class="rh-input" accept=".pdf,.jpg,.jpeg,.png" required>
                <span class="rh-hint">Photo, PDF, JPG ou PNG, 5 Mo maximum.</span>
            </div>
            <div class="rh-field">
                <label for="justifMotif">Commentaire <span class="rh-opt">(facultatif)</span></label>
                <textarea name="motif" id="justifMotif" class="rh-textarea" rows="3"></textarea>
            </div>
            <div class="rh-sheet-foot">
                <button type="button" class="rh-btn soft" data-close>Annuler</button>
                <button type="submit" class="rh-btn">Envoyer</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
(function () {
    var sel = document.getElementById('dureeTypeSelect');
    var grp = document.getElementById('minutesRetardGroup');
    var input = document.getElementById('minutesRetardInput');
    function toggle() {
        var retard = sel.value === 'retard';
        grp.hidden = !retard;
        input.required = retard;
        if (!retard) input.value = '';
    }
    sel.addEventListener('change', toggle);
    toggle();

    document.querySelectorAll('[data-justifier]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.getElementById('justifyForm').action = btn.dataset.justifier;
            document.getElementById('justifyId').value = btn.dataset.id;
            rhOpen('justifyModal', btn);
        });
    });

    @if($errors->any())
        rhOpen('{{ old('_justifier') ? 'justifyModal' : 'declareAbsenceModal' }}');
    @elseif(request('nouveau'))
        rhOpen('declareAbsenceModal');
    @endif
})();
</script>
@endsection
