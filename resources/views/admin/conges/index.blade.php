@extends('layouts.app')

@section('title', 'Congés')
@section('page-title', 'Congés')

@section('styles')
<style>
    .cg-layout { display: grid; gap: 20px; align-items: start; }
    @media (min-width: 1100px) { .cg-layout { grid-template-columns: minmax(0, 1fr) minmax(0, 1.05fr); gap: 24px; } .cg-detail { position: sticky; top: 88px; } }
    @media (max-width: 1099px) {
        .cg-detail.auto { display: none; }
        .cg-layout.explicit .cg-list { display: none; }
    }
    .cg-item { display: flex; align-items: center; gap: 12px; padding: 14px 18px; border-top: 1px solid var(--line-soft); color: inherit; text-decoration: none; min-height: 68px; box-sizing: border-box; }
    .cg-item:first-child { border-top: 0; }
    .cg-item:hover { background: var(--page); color: inherit; }
    .cg-item[aria-current="true"] { background: var(--brand-bg); box-shadow: inset 3px 0 0 var(--brand); }
    .cg-back { display: none; }
    @media (max-width: 1099px) { .cg-layout.explicit .cg-back { display: inline-flex; } }
    .cg-who { display: flex; align-items: center; gap: 12px; }
    .cg-who .rh-ini { width: 48px; height: 48px; font-size: 15px; }
    .cg-title { font-family: var(--display); font-weight: 700; font-size: 22px; line-height: 1.25; letter-spacing: -.01em; color: var(--ink); }
    .cg-over { display: flex; flex-direction: column; gap: 8px; }
    .cg-over li { display: flex; justify-content: space-between; gap: 12px; font-size: 14px; }
    .cg-over li span:last-child { color: var(--muted); white-space: nowrap; }
    .cg-decide { display: flex; flex-direction: column; gap: 12px; padding-top: 4px; }
    .cg-decide-btns { display: flex; gap: 8px; flex-wrap: wrap; }
    .cg-decide-btns > * { flex: 1 1 160px; }
    .cg-decide-btns .rh-btn { width: 100%; }
    .cg-more summary { cursor: pointer; font-size: 14px; font-weight: 600; color: var(--brand); list-style: none; padding: 4px 0; }
    .cg-more summary::-webkit-details-marker { display: none; }
    .cg-more[open] summary { margin-bottom: 12px; }
</style>
@endsection

@section('content')
@php
    $nomDe = fn ($p) => $p ? trim(($p->prenoms ?? '') . ' ' . ($p->nom ?? '')) : 'Agent supprimé';
    $iniDe = fn ($p) => $p ? (mb_strtoupper(mb_substr(trim($p->prenoms ?? ''), 0, 1) . mb_substr(trim($p->nom ?? ''), 0, 1)) ?: '?') : '?';
    $jour = fn ($d) => $d ? $d->locale('fr')->isoFormat('D MMM YYYY') : '';
    $jourCourt = fn ($d) => $d ? $d->locale('fr')->isoFormat('D MMM') : '';
    $periode = function ($c) use ($jour, $jourCourt) {
        if ($c->date_debut->isSameDay($c->date_fin)) return 'le ' . $jour($c->date_debut);
        if ($c->date_debut->isSameMonth($c->date_fin)) return 'du ' . $c->date_debut->day . ' au ' . $jour($c->date_fin);
        return 'du ' . $jourCourt($c->date_debut) . ' au ' . $jour($c->date_fin);
    };
    $badge = function ($statut) use ($estChef) {
        return match ($statut) {
            'en_attente'  => $estChef ? ['new', 'À valider'] : ['off', 'Chez le chef'],
            'valide_chef' => $estChef ? ['info', 'Chez le service RH'] : ['new', 'À approuver'],
            'approuve'    => ['ok', 'Approuvé'],
            'refuse'      => ['no', 'Refusé'],
            'annule'      => ['off', 'Annulé'],
            default       => ['off', $statut],
        };
    };
    $isSuper = auth()->user()->hasRole('Super Admin');
    $qs = fn (array $extra = []) => array_filter(array_merge([
        'vue' => $vue, 'search' => $search ?: null, 'annee' => request('annee'), 'statut' => $statut ?: null,
    ], $extra), fn ($v) => $v !== null && $v !== '');

    $peutDecider = $selection && (($estChef && $selection->statut === 'en_attente') || (!$estChef && $selection->statut === 'valide_chef'));
    $peutRefuserSeulement = $selection && !$estChef && $selection->statut === 'en_attente';
@endphp

<div class="rh-wrap rh-page" style="max-width:1200px">

    @if(session('success'))
        <div class="rh-alert ok" role="status"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg><span>{{ session('success') }}</span></div>
    @endif
    @if(session('error'))
        <div class="rh-alert err" role="alert"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 8v5M12 16h.01"/></svg><span>{{ session('error') }}</span></div>
    @endif
    @if($errors->any() && !$errors->has('motif_refus'))
        <div class="rh-alert err" role="alert"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 8v5M12 16h.01"/></svg><span>{{ $errors->first() }}</span></div>
    @endif

    <section class="rh-head">
        <div class="rh-head-txt">
            <h1 class="rh-h1">Congés</h1>
            <p class="rh-lead">
                @if($estChef)
                    Vous validez d'abord les demandes de votre équipe ; le service RH donne ensuite l'accord final.
                @else
                    Le chef d'entreprise valide d'abord ; vous donnez l'accord final. Choisissez une demande pour l'examiner.
                @endif
            </p>
        </div>
    </section>

    <div class="rh-section">
        <nav class="rh-tabs" aria-label="Filtrer les demandes">
            @foreach($vues as $cle => $v)
                <a href="{{ route('admin.conges.index', array_filter(['vue' => $cle, 'search' => $search ?: null, 'annee' => request('annee')])) }}" @if($vue === $cle && !$statut) aria-current="page" @endif>
                    {{ $v['label'] }}
                    @if($compteurs[$cle] > 0)
                        <span class="c {{ $cle === 'a_traiter' ? '' : 'mute' }}">{{ $compteurs[$cle] }}</span>
                    @endif
                </a>
            @endforeach
        </nav>

        <form method="GET" action="{{ route('admin.conges.index') }}" class="rh-filters" role="search">
            <input type="hidden" name="vue" value="{{ $vue }}">
            <label for="cgSearch" class="sr-only">Rechercher un agent</label>
            <input id="cgSearch" type="search" name="search" value="{{ $search }}" class="rh-input" placeholder="Nom, prénom ou matricule">
            @if(in_array($vue, ['traitees', 'toutes'], true))
                <label for="cgAnnee" class="sr-only">Année</label>
                <select id="cgAnnee" name="annee" class="rh-select" onchange="this.form.submit()">
                    @foreach($anneesDisponibles as $a)
                        <option value="{{ $a }}" @selected((int) $annee === (int) $a)>{{ $a }}</option>
                    @endforeach
                </select>
                <label for="cgStatut" class="sr-only">Statut</label>
                <select id="cgStatut" name="statut" class="rh-select" onchange="this.form.submit()">
                    <option value="">Tous les statuts</option>
                    @foreach(\App\Models\Conge::STATUTS as $k => $lib)
                        <option value="{{ $k }}" @selected($statut === $k)>{{ $lib }}</option>
                    @endforeach
                </select>
            @endif
            <button type="submit" class="rh-btn soft sm">Rechercher</button>
            @if($search || $statut || request('annee'))
                <a href="{{ route('admin.conges.index', ['vue' => $vue]) }}" class="rh-link">Effacer</a>
            @endif
        </form>
    </div>

    <div class="cg-layout {{ $selectionExplicite ? 'explicit' : '' }}">
        {{-- ── Liste ── --}}
        <section class="cg-list rh-card-flat" aria-label="Demandes de congé">
            @forelse($conges as $c)
                @php [$bTon, $bLib] = $badge($c->statut); @endphp
                <a href="{{ route('admin.conges.index', $qs(['conge' => $c->id, 'page' => request('page')])) }}#detail" class="cg-item" @if($selection && $selection->id === $c->id) aria-current="true" @endif>
                    <span class="rh-ini" aria-hidden="true">{{ $iniDe($c->personnel) }}</span>
                    <span class="rh-row-main">
                        <span class="rh-row-title">{{ $nomDe($c->personnel) }}</span>
                        <span class="rh-row-sub">
                            {{ $c->typeConge->nom ?? 'Congé' }}@if($c->conge_parent_id) (prolongation)@endif, {{ $c->nombre_jours }} {{ $c->nombre_jours > 1 ? 'jours' : 'jour' }} · {{ $periode($c) }}
                            @if($isSuper && $c->entreprise)<br>{{ $c->entreprise->nom }}@endif
                        </span>
                    </span>
                    <span class="rh-badge {{ $bTon }}">{{ $bLib }}</span>
                </a>
            @empty
                <div class="rh-empty">
                    <span class="rh-ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg></span>
                    <strong>Aucune demande ici</strong>
                    <p>
                        @if($search)
                            Aucun agent ne correspond à « {{ $search }} » dans cet onglet.
                        @elseif($vue === 'a_traiter')
                            Rien à {{ $estChef ? 'valider' : 'approuver' }} pour l'instant.
                        @else
                            Aucune demande pour ce filtre.
                        @endif
                    </p>
                </div>
            @endforelse

            @if($conges->hasPages())
                <div class="rh-pager">
                    <span>{{ $conges->firstItem() }}–{{ $conges->lastItem() }} sur {{ $conges->total() }}</span>
                    {{ $conges->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </section>

        {{-- ── Détail ── --}}
        @if($selection)
            @php
                $p = $selection->personnel;
                [$sTon, $sLib] = $badge($selection->statut);
                $resteApres = $solde ? ($solde['restants'] - (in_array($selection->statut, ['en_attente', 'valide_chef'], true) ? $selection->nombre_jours : 0)) : null;
            @endphp
            <section class="cg-detail rh-card {{ $selectionExplicite ? '' : 'auto' }}" id="detail" aria-label="Détail de la demande" style="display:flex;flex-direction:column;gap:20px;padding:24px">
                <a href="{{ route('admin.conges.index', $qs(['page' => request('page')])) }}" class="rh-link cg-back">‹ Toutes les demandes</a>

                <div class="cg-who">
                    @if($p && $p->photo)
                        <img src="{{ asset('storage/' . $p->photo) }}" alt="" class="rh-ini">
                    @else
                        <span class="rh-ini" aria-hidden="true">{{ $iniDe($p) }}</span>
                    @endif
                    <span class="rh-row-main">
                        <span class="rh-row-title" style="font-size:17px">{{ $nomDe($p) }}</span>
                        <span class="rh-row-sub">{{ collect([$p->poste ?? null, $p->matricule ?? null, $selection->entreprise->nom ?? null])->filter()->implode(' · ') }}</span>
                    </span>
                    <span class="rh-badge {{ $sTon }}">{{ $sLib }}</span>
                </div>

                <div class="cg-title">
                    {{ $selection->typeConge->nom ?? 'Congé' }}, {{ $selection->nombre_jours }} {{ $selection->nombre_jours > 1 ? 'jours' : 'jour' }}
                    @if($selection->conge_parent_id)<span class="rh-badge info" style="vertical-align:middle;margin-left:6px">Prolongation</span>@endif
                </div>

                <dl class="rh-dl">
                    <div><dt>Période</dt><dd>{{ ucfirst($periode($selection)) }}@if($selection->demi_journee_debut || $selection->demi_journee_fin) <span class="rh-hint">(demi-journée)</span>@endif</dd></div>
                    @if($solde)
                        <div><dt>Solde après la demande</dt><dd>{{ $resteApres }} {{ abs($resteApres) > 1 ? 'jours' : 'jour' }} sur {{ $solde['annuels'] }}</dd></div>
                    @else
                        <div><dt>Solde</dt><dd>Non décompté</dd></div>
                    @endif
                    <div><dt>Demandé le</dt><dd>{{ $jour($selection->created_at) }}</dd></div>
                    @if($selection->congeParent)
                        <div><dt>Prolonge</dt><dd>le congé {{ $periode($selection->congeParent) }}</dd></div>
                    @endif
                </dl>

                @if($selection->motif)
                    <div class="rh-field">
                        <span class="rh-label">Motif de l'agent</span>
                        <p class="rh-quote">{{ $selection->motif }}</p>
                    </div>
                @endif

                @if($selection->piece_jointe || $selection->document_officiel)
                    <div class="rh-actions">
                        @if($selection->piece_jointe)
                            <a href="{{ asset('storage/' . $selection->piece_jointe) }}" target="_blank" rel="noopener" class="rh-btn soft sm">Pièce jointe de l'agent</a>
                        @endif
                        @if($selection->document_officiel)
                            <a href="{{ asset('storage/' . $selection->document_officiel) }}" target="_blank" rel="noopener" class="rh-btn soft sm">Note de congé officielle</a>
                        @endif
                    </div>
                @endif

                <div class="rh-field">
                    <span class="rh-label">Suivi</span>
                    <ol class="rh-steps">
                        <li class="done">Demande déposée le {{ $jour($selection->created_at) }}</li>
                        @if($selection->valide_chef_at)
                            <li class="done">Validée par {{ $selection->valideChefPar->name ?? "le chef d'entreprise" }} le {{ $jour($selection->valide_chef_at) }}</li>
                        @elseif($selection->statut === 'en_attente')
                            <li class="now">En attente du chef d'entreprise</li>
                        @elseif($selection->statut === 'refuse' && !$selection->valide_chef_at)
                            <li class="ko">Non validée par le chef d'entreprise</li>
                        @endif
                        @if($selection->statut === 'approuve')
                            <li class="done">Approuvée par {{ $selection->traitePar->name ?? 'le service RH' }} le {{ $jour($selection->traite_at) }}</li>
                        @elseif($selection->statut === 'refuse')
                            <li class="ko">Refusée par {{ $selection->traitePar->name ?? 'le service RH' }}{{ $selection->traite_at ? ' le ' . $jour($selection->traite_at) : '' }}</li>
                        @elseif($selection->statut === 'annule')
                            <li class="ko">Annulée par l'agent</li>
                        @elseif($selection->statut === 'valide_chef')
                            <li class="now">En attente de l'accord du service RH</li>
                        @else
                            <li>Accord du service RH</li>
                        @endif
                    </ol>
                    @if($selection->motif_refus)
                        <p class="rh-quote"><strong>Motif du refus :</strong> {{ $selection->motif_refus }}</p>
                    @endif
                    @if($selection->commentaire_admin)
                        <p class="rh-quote"><strong>Commentaire :</strong> {{ $selection->commentaire_admin }}</p>
                    @endif
                </div>

                <div class="rh-field">
                    <span class="rh-label">Absents sur la même période</span>
                    @if($chevauchements->isEmpty())
                        <span class="rh-hint">Personne d'autre {{ $isSuper ? 'dans cette entreprise' : '' }} n'est absent ou en attente sur ces dates.</span>
                    @else
                        <ul class="rh-list cg-over">
                            @foreach($chevauchements as $o)
                                <li>
                                    <span>{{ $nomDe($o->personnel) }} @if($o->statut !== 'approuve')<span class="rh-hint">(en attente)</span>@endif</span>
                                    <span>{{ $periode($o) }}</span>
                                </li>
                            @endforeach
                        </ul>
                        @if($chevauchements->count() >= 3)
                            <span class="rh-note">{{ $chevauchements->count() }} autres personnes seraient absentes en même temps : vérifiez la continuité du service.</span>
                        @endif
                    @endif
                </div>

                @if($peutDecider)
                    <div class="cg-decide">
                        <form method="POST" action="{{ route('admin.conges.approve', $selection) }}" enctype="multipart/form-data" class="rh-form" id="cgApproveForm" data-lock>
                            @csrf
                            @if(!$estChef)
                                <details class="cg-more" @if($errors->has('document_officiel') || old('commentaire_admin')) open @endif>
                                    <summary>Ajouter la note officielle ou un commentaire</summary>
                                    <div class="rh-form">
                                        <div class="rh-field">
                                            <label for="cgDoc">Note de congé officielle <span class="rh-opt">(PDF, 10 Mo max.)</span></label>
                                            <input id="cgDoc" type="file" name="document_officiel" accept="application/pdf,.pdf" class="rh-input">
                                            <span class="rh-hint">L'agent pourra la télécharger depuis son espace.</span>
                                            @error('document_officiel')<p class="rh-err">{{ $message }}</p>@enderror
                                        </div>
                                        <div class="rh-field">
                                            <label for="cgComment">Commentaire pour l'agent <span class="rh-opt">(facultatif)</span></label>
                                            <textarea id="cgComment" name="commentaire_admin" class="rh-textarea" maxlength="1000" style="min-height:80px">{{ old('commentaire_admin') }}</textarea>
                                        </div>
                                    </div>
                                </details>
                            @else
                                <div class="rh-field">
                                    <label for="cgComment">Commentaire pour le service RH <span class="rh-opt">(facultatif)</span></label>
                                    <textarea id="cgComment" name="commentaire_admin" class="rh-textarea" maxlength="1000" style="min-height:80px">{{ old('commentaire_admin') }}</textarea>
                                </div>
                            @endif
                        </form>
                        <div class="cg-decide-btns">
                            <button type="submit" form="cgApproveForm" class="rh-btn">{{ $estChef ? 'Valider la demande' : 'Approuver le congé' }}</button>
                            <button type="button" class="rh-btn danger" data-open="cgReject">Refuser</button>
                        </div>
                        <span class="rh-hint">
                            {{ $estChef ? 'La demande part ensuite au service RH pour l\'accord final.' : 'L\'agent est prévenu par notification et WhatsApp.' }}
                        </span>
                    </div>
                @elseif($peutRefuserSeulement)
                    <div class="cg-decide">
                        <span class="rh-hint">Vous pourrez approuver cette demande une fois validée par le chef d'entreprise. Vous pouvez déjà la refuser si elle pose problème.</span>
                        <div class="cg-decide-btns"><button type="button" class="rh-btn danger" data-open="cgReject">Refuser la demande</button></div>
                    </div>
                @endif
            </section>

            @if($peutDecider || $peutRefuserSeulement)
                <div class="rh-sheet" id="cgReject" role="dialog" aria-modal="true" aria-labelledby="cgRejectTitle" @if($errors->has('motif_refus')) data-autoopen @endif>
                    <div class="rh-sheet-box">
                        <div class="rh-sheet-head">
                            <div>
                                <h2 id="cgRejectTitle">Refuser le congé de {{ $nomDe($p) }}</h2>
                                <p>{{ $selection->typeConge->nom ?? 'Congé' }}, {{ $periode($selection) }}. L'agent reçoit votre motif.</p>
                            </div>
                            <button type="button" class="rh-sheet-x" data-close aria-label="Fermer"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M18 6 6 18M6 6l12 12"/></svg></button>
                        </div>
                        <form method="POST" action="{{ route('admin.conges.reject', $selection) }}" class="rh-form" data-lock>
                            @csrf
                            <div class="rh-field">
                                <label for="cgMotif">Motif du refus</label>
                                <textarea id="cgMotif" name="motif_refus" class="rh-textarea" required maxlength="1000" placeholder="Ex. période de clôture, merci de proposer d'autres dates">{{ old('motif_refus') }}</textarea>
                                @error('motif_refus')<p class="rh-err">{{ $message }}</p>@enderror
                            </div>
                            <div class="rh-sheet-foot">
                                <button type="button" class="rh-btn soft" data-close>Annuler</button>
                                <button type="submit" class="rh-btn" style="background:var(--no)">Refuser le congé</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
