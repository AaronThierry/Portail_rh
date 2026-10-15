@extends('layouts.app')

@section('title', 'Absences')
@section('page-title', 'Absences')

@section('content')
@php
    $nomDe = fn ($p) => $p ? trim(($p->prenoms ?? '') . ' ' . ($p->nom ?? '')) : 'Agent supprimé';
    $iniDe = fn ($p) => $p ? (mb_strtoupper(mb_substr(trim($p->prenoms ?? ''), 0, 1) . mb_substr(trim($p->nom ?? ''), 0, 1)) ?: '?') : '?';
    $jour = fn ($d) => $d ? $d->locale('fr')->isoFormat('ddd D MMM YYYY') : '';
    $isSuper = auth()->user()->hasRole('Super Admin');
    $badge = function ($a) use ($estChef) {
        return match ($a->statut) {
            'en_attente'  => $estChef ? ['new', 'À valider'] : ['off', 'Chez le chef'],
            'valide_chef' => $estChef ? ['info', 'Chez le service RH'] : ['new', 'À approuver'],
            'approuvee'   => $a->justifiee ? ['ok', 'Justifiée'] : ['wait', 'Non justifiée'],
            'refusee'     => ['no', 'Refusée'],
            default       => ['off', $a->statut],
        };
    };
    $peutEnregistrer = $personnels->isNotEmpty() && $typesAbsence->isNotEmpty();

    $rejOld = old('_reject_action');
    $rejOld = is_string($rejOld) && str_starts_with($rejOld, url('admin/absences') . '/') ? $rejOld : '';
    $ouvrirAjout = $errors->any() && !$errors->has('motif_refus');
@endphp

<div class="rh-wrap rh-page">

    @if(session('success'))
        <div class="rh-alert ok" role="status"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg><span>{{ session('success') }}</span></div>
    @endif
    @if(session('error'))
        <div class="rh-alert err" role="alert"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 8v5M12 16h.01"/></svg><span>{{ session('error') }}</span></div>
    @endif

    <section class="rh-head">
        <div class="rh-head-txt">
            <h1 class="rh-h1">Absences</h1>
            <p class="rh-lead">
                @if($estChef)
                    Les absences déclarées par vos agents passent d'abord par vous, puis par le service RH.
                @else
                    Les absences déclarées par les agents sont validées par le chef d'entreprise, puis approuvées ici. Celles que vous enregistrez vous-même vont directement au registre.
                @endif
            </p>
        </div>
        @if($peutEnregistrer)
            <div class="rh-actions">
                <button type="button" class="rh-btn" data-open="abAdd">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>
                    Enregistrer une absence
                </button>
            </div>
        @endif
    </section>

    <div class="rh-section">
        <nav class="rh-tabs" aria-label="Filtrer les absences">
            @foreach($vues as $cle => $v)
                <a href="{{ route('admin.absences.index', array_filter(['vue' => $cle, 'search' => $search ?: null])) }}" @if($vue === $cle && !$statut) aria-current="page" @endif>
                    {{ $v['label'] }}
                    @if($compteurs[$cle] > 0)
                        <span class="c {{ $cle === 'a_traiter' ? '' : 'mute' }}">{{ $compteurs[$cle] }}</span>
                    @endif
                </a>
            @endforeach
        </nav>

        <form method="GET" action="{{ route('admin.absences.index') }}" class="rh-filters" role="search">
            <input type="hidden" name="vue" value="{{ $vue }}">
            <label for="abSearch" class="sr-only">Rechercher un agent</label>
            <input id="abSearch" type="search" name="search" value="{{ $search }}" class="rh-input" placeholder="Nom, prénom ou matricule">
            @if($vue === 'registre')
                <label for="abType" class="sr-only">Type d'absence</label>
                <select id="abType" name="type_absence" class="rh-select" onchange="this.form.submit()">
                    <option value="">Tous les types</option>
                    @foreach($typesAbsence as $t)
                        <option value="{{ $t->id }}" @selected((string) $typeAbsenceId === (string) $t->id)>{{ $t->nom }}</option>
                    @endforeach
                </select>
                <label for="abJust" class="sr-only">Justification</label>
                <select id="abJust" name="justifiee" class="rh-select" onchange="this.form.submit()">
                    <option value="">Justifiées ou non</option>
                    <option value="1" @selected($justifiee === '1')>Justifiées</option>
                    <option value="0" @selected($justifiee === '0')>Non justifiées</option>
                </select>
                <label for="abAnnee" class="sr-only">Année</label>
                <select id="abAnnee" name="annee" class="rh-select" onchange="this.form.submit()">
                    @foreach($anneesDisponibles as $an)
                        <option value="{{ $an }}" @selected((int) $annee === (int) $an)>{{ $an }}</option>
                    @endforeach
                </select>
            @endif
            <button type="submit" class="rh-btn soft sm">Rechercher</button>
            @if($search || $typeAbsenceId || ($justifiee !== null && $justifiee !== '') || $statut || request('annee'))
                <a href="{{ route('admin.absences.index', ['vue' => $vue]) }}" class="rh-link">Effacer</a>
            @endif
        </form>
    </div>

    @if($vue === 'registre')
        <section class="rh-figures" aria-label="Chiffres {{ $annee }}">
            <a class="rh-figure" href="{{ route('admin.absences.index', ['vue' => 'registre', 'annee' => $annee]) }}"><strong>{{ $stats['total'] }}</strong><span>absences en {{ $annee }}</span></a>
            <a class="rh-figure" href="{{ route('admin.absences.index', ['vue' => 'registre', 'annee' => $annee, 'justifiee' => 1]) }}"><strong>{{ $stats['justifiees'] }}</strong><span>justifiées</span></a>
            <a class="rh-figure" href="{{ route('admin.absences.index', ['vue' => 'registre', 'annee' => $annee, 'justifiee' => 0]) }}"><strong>{{ $stats['injustifiees'] }}</strong><span>non justifiées</span></a>
            <div class="rh-figure"><strong>{{ $stats['retards'] }}</strong><span>retards</span></div>
        </section>
    @endif

    <section class="rh-card-flat" aria-label="Liste des absences">
        @forelse($absences as $a)
            @php
                [$bTon, $bLib] = $badge($a);
                $actionnable = ($estChef && $a->statut === 'en_attente') || (!$estChef && $a->statut === 'valide_chef');
                $refusSeul = !$estChef && $a->statut === 'en_attente';
            @endphp
            <div class="rh-row act">
                @if($a->personnel && $a->personnel->photo)
                    <img src="{{ asset('storage/' . $a->personnel->photo) }}" alt="" class="rh-ini">
                @else
                    <span class="rh-ini" aria-hidden="true">{{ $iniDe($a->personnel) }}</span>
                @endif
                <span class="rh-row-main">
                    <span class="rh-row-title">
                        {{ $nomDe($a->personnel) }} · {{ $a->typeAbsence->nom ?? 'Absence' }}, {{ mb_strtolower($a->duree_label) }}
                    </span>
                    <span class="rh-row-sub">
                        {{ ucfirst($jour($a->date_absence)) }}
                        @if($a->heure_debut) · {{ substr($a->heure_debut, 0, 5) }}@if($a->heure_fin)–{{ substr($a->heure_fin, 0, 5) }}@endif @endif
                        · {{ $a->source === 'admin' ? 'enregistrée par ' . ($a->enregistrePar->name ?? "l'administration") : "déclarée par l'agent" }}
                        @if($isSuper && $a->entreprise) · {{ $a->entreprise->nom }}@endif
                    </span>
                    @if($a->motif)
                        <span class="rh-row-sub" style="color:var(--ink-2)">« {{ \Illuminate\Support\Str::limit($a->motif, 140) }} »</span>
                    @endif
                    @if($a->statut === 'refusee' && $a->motif_refus)
                        <span class="rh-row-sub">Motif du refus : {{ \Illuminate\Support\Str::limit($a->motif_refus, 140) }}</span>
                    @endif
                </span>
                <span class="rh-row-end">
                    <span class="rh-badge {{ $bTon }}">{{ $bLib }}</span>
                    @if($a->justificatif)
                        <a href="{{ asset('storage/' . $a->justificatif) }}" target="_blank" rel="noopener" class="rh-btn soft sm">Justificatif</a>
                    @endif

                    @if($actionnable)
                        <button type="button" class="rh-btn danger sm" data-open="abReject" data-action="{{ route('admin.absences.reject', $a) }}" data-who="{{ $nomDe($a->personnel) }}">Refuser</button>
                        <form method="POST" action="{{ route('admin.absences.approve', $a) }}" data-lock>
                            @csrf
                            <button type="submit" class="rh-btn sm">{{ $estChef ? 'Valider' : 'Approuver' }}</button>
                        </form>
                    @elseif($refusSeul)
                        <button type="button" class="rh-btn danger sm" data-open="abReject" data-action="{{ route('admin.absences.reject', $a) }}" data-who="{{ $nomDe($a->personnel) }}">Refuser</button>
                    @elseif(!$estChef && in_array($a->statut, ['approuvee', 'refusee'], true))
                        @if($a->statut === 'approuvee')
                            <form method="POST" action="{{ route('admin.absences.toggle-justifiee', $a) }}" data-lock>
                                @csrf
                                <button type="submit" class="rh-btn soft sm">{{ $a->justifiee ? 'Marquer non justifiée' : 'Marquer justifiée' }}</button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('admin.absences.destroy', $a) }}" data-confirm="Supprimer définitivement cette absence ?">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rh-btn danger sm" aria-label="Supprimer l'absence de {{ $nomDe($a->personnel) }} du {{ $jour($a->date_absence) }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/></svg>
                            </button>
                        </form>
                    @endif
                </span>
            </div>
        @empty
            <div class="rh-empty">
                <span class="rh-ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></span>
                <strong>Aucune absence ici</strong>
                <p>
                    @if($search)
                        Aucun agent ne correspond à « {{ $search }} ».
                    @elseif($vue === 'a_traiter')
                        Rien à {{ $estChef ? 'valider' : 'approuver' }} pour l'instant.
                    @else
                        Aucune absence pour ce filtre.
                    @endif
                </p>
            </div>
        @endforelse

        @if($absences->hasPages())
            <div class="rh-pager">
                <span>{{ $absences->firstItem() }}–{{ $absences->lastItem() }} sur {{ $absences->total() }}</span>
                {{ $absences->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </section>
</div>

{{-- ── Refus (motif obligatoire) ── --}}
<div class="rh-sheet" id="abReject" role="dialog" aria-modal="true" aria-labelledby="abRejectTitle" @if($errors->has('motif_refus') && $rejOld) data-autoopen @endif>
    <div class="rh-sheet-box">
        <div class="rh-sheet-head">
            <div>
                <h2 id="abRejectTitle">Refuser l'absence</h2>
                <p id="abRejectWho">L'agent reçoit votre motif.</p>
            </div>
            <button type="button" class="rh-sheet-x" data-close aria-label="Fermer"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M18 6 6 18M6 6l12 12"/></svg></button>
        </div>
        <form method="POST" action="{{ $rejOld }}" id="abRejectForm" class="rh-form" data-lock>
            @csrf
            <input type="hidden" name="_reject_action" value="{{ $rejOld }}">
            <div class="rh-field">
                <label for="abMotif">Motif du refus</label>
                <textarea id="abMotif" name="motif_refus" class="rh-textarea" required maxlength="1000" placeholder="Expliquez clairement la raison à l'agent…">{{ old('motif_refus') }}</textarea>
                @error('motif_refus')<p class="rh-err">{{ $message }}</p>@enderror
                <span class="rh-hint">Une absence enregistrée par l'administration reste au registre, marquée non justifiée.</span>
            </div>
            <div class="rh-sheet-foot">
                <button type="button" class="rh-btn soft" data-close>Annuler</button>
                <button type="submit" class="rh-btn" style="background:var(--no)">Refuser</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Enregistrer une absence ── --}}
@if($peutEnregistrer)
<div class="rh-sheet" id="abAdd" role="dialog" aria-modal="true" aria-labelledby="abAddTitle" @if($ouvrirAjout) data-autoopen @endif>
    <div class="rh-sheet-box wide">
        <div class="rh-sheet-head">
            <div>
                <h2 id="abAddTitle">Enregistrer une absence</h2>
                <p>Elle va directement au registre, sans circuit de validation.</p>
            </div>
            <button type="button" class="rh-sheet-x" data-close aria-label="Fermer"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M18 6 6 18M6 6l12 12"/></svg></button>
        </div>

        @if($ouvrirAjout)
            <div class="rh-alert err" role="alert" style="margin-bottom:16px"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 8v5M12 16h.01"/></svg>
                <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.absences.store') }}" enctype="multipart/form-data" class="rh-form" data-lock>
            @csrf
            <div class="rh-field">
                <label for="abPersoFiltre">Agent</label>
                <input id="abPersoFiltre" type="search" class="rh-input" placeholder="Filtrer par nom ou matricule…" autocomplete="off" aria-controls="abPerso">
                <select id="abPerso" name="personnel_id" class="rh-select" required size="1" aria-label="Choisir l'agent">
                    <option value="">Choisir un agent…</option>
                    @foreach($personnels as $p)
                        <option value="{{ $p->id }}" @selected((string) old('personnel_id') === (string) $p->id)>{{ $p->nom }} {{ $p->prenoms }}{{ $p->matricule ? ' · ' . $p->matricule : '' }}</option>
                    @endforeach
                </select>
            </div>

            <div class="rh-grid2">
                <div class="rh-field">
                    <label for="abTypeAdd">Type</label>
                    <select id="abTypeAdd" name="type_absence_id" class="rh-select" required>
                        <option value="">Choisir…</option>
                        @foreach($typesAbsence as $t)
                            <option value="{{ $t->id }}" @selected((string) old('type_absence_id') === (string) $t->id)>{{ $t->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="rh-field">
                    <label for="abDate">Date</label>
                    <input id="abDate" type="date" name="date_absence" class="rh-input" value="{{ old('date_absence', now()->toDateString()) }}" required>
                </div>
            </div>

            <div class="rh-grid2">
                <div class="rh-field">
                    <label for="abDuree">Durée</label>
                    <select id="abDuree" name="duree_type" class="rh-select" required>
                        @foreach(\App\Models\Absence::DUREE_TYPES as $k => $lib)
                            <option value="{{ $k }}" @selected(old('duree_type', 'journee') === $k)>{{ $lib }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="rh-field" id="abRetardField">
                    <label for="abRetard">Minutes de retard</label>
                    <input id="abRetard" type="number" name="minutes_retard" class="rh-input" min="1" max="480" value="{{ old('minutes_retard') }}" inputmode="numeric" placeholder="Ex. 30">
                </div>
            </div>

            <div class="rh-grid2">
                <div class="rh-field">
                    <label for="abDebut">Heure de début <span class="rh-opt">(facultatif)</span></label>
                    <input id="abDebut" type="time" name="heure_debut" class="rh-input" value="{{ old('heure_debut') }}">
                </div>
                <div class="rh-field">
                    <label for="abFin">Heure de fin <span class="rh-opt">(facultatif)</span></label>
                    <input id="abFin" type="time" name="heure_fin" class="rh-input" value="{{ old('heure_fin') }}">
                </div>
            </div>

            <div class="rh-field">
                <label for="abMotifAdd">Motif <span class="rh-opt">(facultatif)</span></label>
                <textarea id="abMotifAdd" name="motif" class="rh-textarea" maxlength="1000" style="min-height:80px">{{ old('motif') }}</textarea>
            </div>

            <div class="rh-field">
                <label for="abJustif">Justificatif <span class="rh-opt">(PDF ou photo, 5 Mo max.)</span></label>
                <input id="abJustif" type="file" name="justificatif" class="rh-input" accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/jpeg,image/png">
            </div>

            <input type="hidden" name="justifiee" value="0">
            <label class="rh-check"><input type="checkbox" name="justifiee" value="1" @checked(old('justifiee'))> Absence justifiée</label>

            <div class="rh-sheet-foot">
                <button type="button" class="rh-btn soft" data-close>Annuler</button>
                <button type="submit" class="rh-btn">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
(function () {
    // Refus : la fenêtre partagée reçoit l'adresse de l'absence choisie
    var form = document.getElementById('abRejectForm');
    var who = document.getElementById('abRejectWho');
    document.addEventListener('click', function (e) {
        var b = e.target.closest('[data-open="abReject"][data-action]');
        if (!b || !form) return;
        form.setAttribute('action', b.getAttribute('data-action'));
        form.querySelector('[name=_reject_action]').value = b.getAttribute('data-action');
        if (who) who.textContent = 'Absence de ' + b.getAttribute('data-who') + '. L\'agent reçoit votre motif.';
    }, true);

    // Minutes de retard : seulement pour un retard
    var duree = document.getElementById('abDuree');
    var retard = document.getElementById('abRetardField');
    function syncRetard() {
        if (!duree || !retard) return;
        var on = duree.value === 'retard';
        retard.style.display = on ? '' : 'none';
        var i = retard.querySelector('input');
        if (i) i.required = on;
    }
    if (duree) { duree.addEventListener('change', syncRetard); syncRetard(); }

    // Filtre de la liste des agents
    var filtre = document.getElementById('abPersoFiltre');
    var sel = document.getElementById('abPerso');
    if (filtre && sel) {
        var opts = Array.prototype.slice.call(sel.options, 1);
        var norm = function (s) { return s.normalize('NFD').replace(/[̀-ͯ]/g, '').toLowerCase(); };
        filtre.addEventListener('input', function () {
            var q = norm(filtre.value.trim()), premier = null;
            opts.forEach(function (o) {
                var ok = !q || norm(o.text).indexOf(q) !== -1;
                o.hidden = !ok; o.disabled = !ok;
                if (ok && !premier) premier = o;
            });
            if (q && premier && (sel.selectedIndex <= 0 || sel.options[sel.selectedIndex].hidden)) sel.value = premier.value;
        });
    }
})();
</script>
@endsection
