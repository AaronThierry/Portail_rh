@extends('layouts.espace-employe')

@section('title', 'Mes congés')

@section('content')
@php
    $total    = $soldeConges['annuels'] ?? 0;
    $pris     = $soldeConges['pris'] ?? 0;
    $restants = $soldeConges['restants'] ?? 0;
    $attente  = $soldeConges['en_attente'] ?? 0;
    $jours    = fn ($n) => $n . ' jour' . (abs($n) > 1 ? 's' : '');
@endphp

<div class="rh-page">
    @include('espace-employe.partials.tabs', ['section' => 'demandes'])

    <section class="rh-head">
        <div class="rh-head-txt">
            <h1 class="rh-h1">Mes congés</h1>
            <p class="rh-lead">
                @if($total > 0)
                    {{ $jours($restants) }} disponibles sur {{ $total }} en {{ $annee }}.
                @else
                    Soumettez une demande, votre responsable puis le service RH la valident.
                @endif
            </p>
        </div>
        <div class="rh-actions">
            <button type="button" class="rh-btn" data-open="congeModal">Poser un congé</button>
        </div>
    </section>

    @if($total > 0)
        <div class="rh-figures" aria-label="Solde {{ $annee }}">
            <div class="rh-figure"><strong>{{ $restants }}</strong><span>jours disponibles</span></div>
            <div class="rh-figure"><strong>{{ $pris }}</strong><span>jours pris</span></div>
            <div class="rh-figure"><strong>{{ $attente }}</strong><span>jours en attente</span></div>
            <div class="rh-figure"><strong>{{ $total }}</strong><span>jours acquis</span></div>
        </div>
    @endif

    <section class="rh-section" aria-labelledby="titreHisto">
        <div class="rh-section-head">
            <h2 class="rh-h2" id="titreHisto">Demandes {{ $annee }}</h2>
            @if(count($anneesDisponibles) > 1)
                <label class="rh-sr" for="anneeSelect">Année</label>
                <select id="anneeSelect" class="rh-select" style="width: auto; min-height: 40px"
                        onchange="window.location.href='{{ route('espace-employe.conges') }}?annee=' + this.value">
                    @foreach($anneesDisponibles as $a)
                        <option value="{{ $a }}" {{ $a == $annee ? 'selected' : '' }}>{{ $a }}</option>
                    @endforeach
                </select>
            @endif
        </div>

        @if($conges->count() > 0)
            <ul class="rh-list rh-card-flat">
                @foreach($conges as $conge)
                    <li>
                        <div class="rh-row" style="flex-wrap: wrap">
                            <span class="rh-swatch" style="background: {{ $conge->typeConge->couleur ?? 'var(--brand)' }}"></span>
                            <span class="rh-row-main" style="min-width: 180px">
                                <span class="rh-row-title">{{ $conge->typeConge->nom ?? 'Congé' }}, {{ $jours($conge->nombre_jours) }}</span>
                                <span class="rh-row-sub">
                                    Du {{ $conge->date_debut->format('d/m/Y') }} au {{ $conge->date_fin->format('d/m/Y') }}
                                    @if($conge->statut === 'refuse' && $conge->motif_refus)
                                        <br><span style="color: var(--no)">Motif du refus : {{ $conge->motif_refus }}</span>
                                    @endif
                                </span>
                            </span>
                            <span class="rh-row-end">
                                @include('espace-employe.partials.statut', ['statut' => $conge->statut])
                                @if($conge->statut === 'en_attente')
                                    <form action="{{ route('espace-employe.conges.annuler', $conge) }}" method="POST" data-confirm="Annuler cette demande de congé ?">
                                        @csrf
                                        <button type="submit" class="rh-btn danger sm">Annuler</button>
                                    </form>
                                @endif
                                @if($conge->statut === 'approuve')
                                    @if($conge->document_officiel)
                                        <a href="{{ route('espace-employe.conges.document', $conge) }}" class="rh-btn soft sm">Note officielle</a>
                                    @endif
                                    <button type="button" class="rh-btn soft sm"
                                            data-prolonger="{{ route('espace-employe.conges.prolonger', $conge) }}"
                                            data-id="{{ $conge->id }}"
                                            data-fin="{{ $conge->date_fin->format('Y-m-d') }}"
                                            data-fin-label="{{ $conge->date_fin->format('d/m/Y') }}"
                                            data-type="{{ $conge->typeConge->nom ?? 'Congé' }}">Prolonger</button>
                                @endif
                            </span>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="rh-card rh-empty">
                <strong>Aucune demande en {{ $annee }}</strong>
                <p>Vos demandes de congé et leur avancement s'afficheront ici.</p>
                <button type="button" class="rh-btn" data-open="congeModal" style="margin-top: 8px">Poser un congé</button>
            </div>
        @endif
    </section>
</div>

{{-- ── Nouvelle demande ─────────────────────────────────────── --}}
<div class="rh-sheet" id="congeModal" role="dialog" aria-modal="true" aria-labelledby="congeModalTitre">
    <div class="rh-sheet-box">
        <div class="rh-sheet-grip"></div>
        <div class="rh-sheet-head">
            <div>
                <h2 id="congeModalTitre">Poser un congé</h2>
                <p>Votre responsable puis le service RH valident la demande.</p>
            </div>
            <button type="button" class="rh-iconbtn" data-close aria-label="Fermer">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg>
            </button>
        </div>

        <form action="{{ route('espace-employe.conges.store') }}" method="POST" enctype="multipart/form-data" class="rh-form" data-lock="Envoi…">
            @csrf
            @if($errors->any() && !old('nouvelle_date_fin'))
                <div class="rh-alert err" role="alert"><ul>@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul></div>
            @endif

            <div class="rh-field">
                <label for="type_conge_id">Type de congé</label>
                <select name="type_conge_id" id="type_conge_id" class="rh-select" required>
                    <option value="">Choisissez un type</option>
                    @foreach($typesConge as $type)
                        <option value="{{ $type->id }}" {{ old('type_conge_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->nom }}{{ $type->jours_par_an ? ' (' . $type->jours_par_an . ' j/an)' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="rh-grid2">
                <div class="rh-field">
                    <label for="date_debut">Premier jour</label>
                    <input type="date" name="date_debut" id="date_debut" class="rh-input" value="{{ old('date_debut') }}" required min="{{ date('Y-m-d') }}">
                </div>
                <div class="rh-field">
                    <label for="date_fin">Dernier jour</label>
                    <input type="date" name="date_fin" id="date_fin" class="rh-input" value="{{ old('date_fin') }}" required min="{{ date('Y-m-d') }}">
                </div>
            </div>
            <p class="rh-hint" id="dureeConge" aria-live="polite"></p>

            <div class="rh-field">
                <label for="motif">Motif <span class="rh-opt">(facultatif)</span></label>
                <textarea name="motif" id="motif" class="rh-textarea" rows="3" placeholder="Ex. voyage en famille">{{ old('motif') }}</textarea>
            </div>

            <div class="rh-field">
                <label for="piece_jointe">Pièce jointe <span class="rh-opt">(facultatif)</span></label>
                <input type="file" name="piece_jointe" id="piece_jointe" class="rh-input" accept=".pdf,.jpg,.jpeg,.png">
                <span class="rh-hint">PDF, JPG ou PNG, 5 Mo maximum.</span>
            </div>

            <div class="rh-sheet-foot">
                <button type="button" class="rh-btn soft" data-close>Annuler</button>
                <button type="submit" class="rh-btn">Envoyer la demande</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Prolonger ────────────────────────────────────────────── --}}
<div class="rh-sheet" id="prolongerModal" role="dialog" aria-modal="true" aria-labelledby="prolongerTitre">
    <div class="rh-sheet-box">
        <div class="rh-sheet-grip"></div>
        <div class="rh-sheet-head">
            <div>
                <h2 id="prolongerTitre">Prolonger un congé</h2>
                <p><span id="prolongerType">Congé</span> · se termine actuellement le <strong id="prolongerFinLabel">—</strong></p>
            </div>
            <button type="button" class="rh-iconbtn" data-close aria-label="Fermer">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg>
            </button>
        </div>

        <form id="prolongerForm" method="POST" enctype="multipart/form-data" class="rh-form" data-lock="Envoi…"
              @if(old('_conge')) action="{{ url('mon-espace/conges/' . (int) old('_conge') . '/prolonger') }}" @endif>
            @csrf
            <input type="hidden" name="_conge" id="prolongerConge" value="{{ old('_conge') }}">
            @if($errors->any() && old('nouvelle_date_fin'))
                <div class="rh-alert err" role="alert"><ul>@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul></div>
            @endif
            <div class="rh-field">
                <label for="prolongerDateFin">Nouveau dernier jour</label>
                <input type="date" name="nouvelle_date_fin" id="prolongerDateFin" class="rh-input" value="{{ old('nouvelle_date_fin') }}" required>
            </div>
            <div class="rh-field">
                <label for="prolongerMotif">Motif <span class="rh-opt">(facultatif)</span></label>
                <textarea name="motif" id="prolongerMotif" class="rh-textarea" rows="3"></textarea>
            </div>
            <div class="rh-field">
                <label for="prolongerPiece">Pièce jointe <span class="rh-opt">(facultatif)</span></label>
                <input type="file" name="piece_jointe" id="prolongerPiece" class="rh-input" accept=".pdf,.jpg,.jpeg,.png">
                <span class="rh-hint">PDF, JPG ou PNG, 5 Mo maximum.</span>
            </div>
            <div class="rh-sheet-foot">
                <button type="button" class="rh-btn soft" data-close>Annuler</button>
                <button type="submit" class="rh-btn">Demander la prolongation</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
(function () {
    // Prolongation : remplit la fenêtre avec le congé choisi
    document.querySelectorAll('[data-prolonger]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.getElementById('prolongerForm').action = btn.dataset.prolonger;
            document.getElementById('prolongerConge').value = btn.dataset.id;
            document.getElementById('prolongerType').textContent = btn.dataset.type;
            document.getElementById('prolongerFinLabel').textContent = btn.dataset.finLabel;
            var next = new Date(btn.dataset.fin + 'T12:00:00');
            next.setDate(next.getDate() + 1);
            var input = document.getElementById('prolongerDateFin');
            input.min = next.toISOString().slice(0, 10);
            input.value = '';
            rhOpen('prolongerModal', btn);
        });
    });

    // Durée indicative (jours ouvrés, hors week-ends et jours fériés chômés)
    // Même liste que Conge::JOURS_FERIES_FIXES côté serveur, qui fait foi.
    var rhFeries = @json(\App\Models\Conge::JOURS_FERIES_FIXES);
    var d1 = document.getElementById('date_debut'), d2 = document.getElementById('date_fin'), out = document.getElementById('dureeConge');
    function duree() {
        out.textContent = '';
        if (!d1.value || !d2.value) return;
        if (d1.value > d2.value) { out.textContent = 'Le dernier jour doit être après le premier.'; return; }
        d2.min = d1.value;
        var n = 0, d = new Date(d1.value + 'T12:00:00'), end = new Date(d2.value + 'T12:00:00');
        for (; d <= end; d.setDate(d.getDate() + 1)) {
            var w = d.getDay();
            var md = String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
            if (w !== 0 && w !== 6 && rhFeries.indexOf(md) === -1) n++;
        }
        out.textContent = n + ' jour' + (n > 1 ? 's' : '') + ' ouvré' + (n > 1 ? 's' : '') + ' (hors jours fériés).';
    }
    d1.addEventListener('change', duree);
    d2.addEventListener('change', duree);

    // Réouverture après une erreur, ou ouverture directe depuis l'accueil (?nouveau=1)
    @if($errors->any())
        rhOpen('{{ old('nouvelle_date_fin') ? 'prolongerModal' : 'congeModal' }}');
    @elseif(request('nouveau'))
        rhOpen('congeModal');
    @endif
})();
</script>
@endsection
