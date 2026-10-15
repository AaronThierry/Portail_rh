@extends('layouts.app')

@section('title', 'À traiter')
@section('page-title', 'À traiter')

@section('content')
@php
    $u = auth()->user();
    $isSuper = $u->hasRole('Super Admin');
    $prenom = $u->prenom ?? explode(' ', trim($u->name ?? 'Admin'))[0];

    $nomDe = fn ($p) => $p ? trim(($p->prenoms ?? '') . ' ' . ($p->nom ?? '')) : 'Agent supprimé';
    $iniDe = function ($p) {
        if (!$p) return '?';
        return mb_strtoupper(mb_substr(trim($p->prenoms ?? ''), 0, 1) . mb_substr(trim($p->nom ?? ''), 0, 1)) ?: '?';
    };
    $jour = fn ($d) => $d ? $d->locale('fr')->isoFormat('D MMM') : '';
    $periode = function ($debut, $fin) use ($jour) {
        if (!$debut) return '';
        if (!$fin || $debut->isSameDay($fin)) return 'le ' . $jour($debut);
        if ($debut->isSameMonth($fin)) return 'du ' . $debut->day . ' au ' . $jour($fin);
        return 'du ' . $jour($debut) . ' au ' . $jour($fin);
    };

    $total = $queue['total'];
    $nbJustif = $fileJustificatifs->count();
    $absentsTotal = $enCongeAujourdhui->count() + $absentsAujourdhui->count();
    $absentsListe = $enCongeAujourdhui->map(fn ($c) => ['nom' => $nomDe($c->personnel), 'info' => ($c->typeConge->nom ?? 'Congé') . " jusqu'au " . $jour($c->date_fin)])
        ->concat($absentsAujourdhui->map(fn ($a) => ['nom' => $nomDe($a->personnel), 'info' => ($a->typeAbsence->nom ?? 'Absence') . ' · ' . $a->duree_label]));
@endphp

<div class="rh-wrap rh-page">

    @if(session('success'))
        <div class="rh-alert ok" role="status"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg><span>{{ session('success') }}</span></div>
    @endif
    @if(session('error'))
        <div class="rh-alert err" role="alert"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 8v5M12 16h.01"/></svg><span>{{ session('error') }}</span></div>
    @endif
    @if($errors->any())
        <div class="rh-alert err" role="alert"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 8v5M12 16h.01"/></svg><span>{{ $errors->first() }}</span></div>
    @endif

    {{-- ── En-tête ── --}}
    <section class="rh-head">
        <div class="rh-head-txt">
            <span class="rh-kicker"><span id="rhGreeting">Bonjour</span> {{ $prenom }}, nous sommes le {{ now()->locale('fr')->isoFormat('dddd D MMMM') }}.</span>
            <h1 class="rh-h1">
                @if($total === 0)
                    Tout est à jour.
                @else
                    {{ $total }} {{ $total > 1 ? 'demandes attendent' : 'demande attend' }} votre décision.
                @endif
            </h1>
            <p class="rh-lead">
                @if($total === 0)
                    Aucune demande n'attend votre décision pour le moment.
                @elseif($estChef)
                    Validez ou refusez ; le service RH donne ensuite l'accord final.
                @elseif($queue['conges'] > 0)
                    {{ $queue['conges'] }} {{ $queue['conges'] > 1 ? 'congés sont déjà validés' : 'congé est déjà validé' }} par le chef d'entreprise : il ne manque que votre accord.
                @else
                    Les demandes listées ici ont déjà été validées par le chef d'entreprise.
                @endif
            </p>
        </div>
        @if($queue['conges'] > 0)
            <div class="rh-actions"><a href="{{ route('admin.conges.index') }}" class="rh-btn">Commencer par les congés</a></div>
        @elseif($queue['absences'] > 0)
            <div class="rh-actions"><a href="{{ route('admin.absences.index') }}" class="rh-btn">Voir les absences</a></div>
        @endif
    </section>

    <div class="rh-split">
        {{-- ── File d'attente ── --}}
        <section class="rh-section" aria-labelledby="tFile">
            <h2 class="rh-h2" id="tFile">À traiter</h2>

            @if($total === 0 && $nbJustif === 0)
                <div class="rh-card-flat">
                    <div class="rh-empty">
                        <span class="rh-ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M20 6 9 17l-5-5"/></svg></span>
                        <strong>Rien en attente</strong>
                        <p>Les nouvelles demandes de congé et d'absence apparaîtront ici dès qu'elles vous reviennent.</p>
                    </div>
                </div>
            @else
            <div class="rh-card-flat">

                {{-- Congés --}}
                @if($fileConges->isNotEmpty())
                    <div class="rh-group">
                        <span>{{ $estChef ? 'Demandes de congé à valider' : 'Congés validés par le chef, à approuver' }}</span>
                        <span class="n">{{ $queue['conges'] }}</span>
                    </div>
                    @foreach($fileConges as $c)
                        @php
                            $depuis = $estChef ? $c->created_at : ($c->valide_chef_at ?? $c->created_at);
                            $jours = $depuis ? (int) $depuis->diffInDays(now()) : 0;
                        @endphp
                        <div class="rh-row act">
                            <span class="rh-ini" aria-hidden="true">{{ $iniDe($c->personnel) }}</span>
                            <span class="rh-row-main">
                                <span class="rh-row-title">{{ $nomDe($c->personnel) }} · {{ $c->typeConge->nom ?? 'Congé' }}, {{ $c->nombre_jours }} {{ $c->nombre_jours > 1 ? 'jours' : 'jour' }}</span>
                                <span class="rh-row-sub">
                                    @if($isSuper && $c->entreprise){{ $c->entreprise->nom }} · @endif{{ $periode($c->date_debut, $c->date_fin) }}
                                    · {{ $estChef ? 'demandé' : 'validé par le chef' }} {{ $depuis ? $depuis->locale('fr')->diffForHumans() : '' }}
                                </span>
                            </span>
                            <span class="rh-row-end">
                                @if($jours >= 3)<span class="rh-badge new">Depuis {{ $jours }} jours</span>@endif
                                <a href="{{ route('admin.conges.index', ['conge' => $c->id]) }}" class="rh-btn soft sm">Examiner</a>
                            </span>
                        </div>
                    @endforeach
                    @if($queue['conges'] > $fileConges->count())
                        <div class="rh-more"><a href="{{ route('admin.conges.index') }}" class="rh-link">Voir les {{ $queue['conges'] }} demandes de congé</a></div>
                    @endif
                @endif

                {{-- Absences --}}
                @if($fileAbsences->isNotEmpty())
                    <div class="rh-group">
                        <span>{{ $estChef ? 'Absences à valider' : 'Absences validées par le chef, à approuver' }}</span>
                        <span class="n">{{ $queue['absences'] }}</span>
                    </div>
                    @foreach($fileAbsences as $a)
                        <div class="rh-row act">
                            <span class="rh-ini" aria-hidden="true">{{ $iniDe($a->personnel) }}</span>
                            <span class="rh-row-main">
                                <span class="rh-row-title">{{ $nomDe($a->personnel) }} · {{ $a->typeAbsence->nom ?? 'Absence' }}, {{ mb_strtolower($a->duree_label) }}</span>
                                <span class="rh-row-sub">
                                    @if($isSuper && $a->entreprise){{ $a->entreprise->nom }} · @endif{{ 'le ' . $jour($a->date_absence) }}
                                    · {{ $a->justificatif ? 'justificatif joint' : 'sans justificatif' }}
                                </span>
                            </span>
                            <span class="rh-row-end">
                                <button type="button" class="rh-btn danger sm" data-open="dbReject" data-action="{{ route('admin.absences.reject', $a) }}" data-who="{{ $nomDe($a->personnel) }}">Refuser</button>
                                <form method="POST" action="{{ route('admin.absences.approve', $a) }}" data-lock>
                                    @csrf
                                    <button type="submit" class="rh-btn sm">{{ $estChef ? 'Valider' : 'Approuver' }}</button>
                                </form>
                            </span>
                        </div>
                    @endforeach
                    @if($queue['absences'] > $fileAbsences->count())
                        <div class="rh-more"><a href="{{ route('admin.absences.index') }}" class="rh-link">Voir les {{ $queue['absences'] }} absences</a></div>
                    @endif
                @endif

                {{-- Requêtes --}}
                @if($fileRequetes->isNotEmpty())
                    <div class="rh-group">
                        <span>{{ $estChef ? 'Réponses reçues à vos requêtes' : 'Requêtes sans réponse' }}</span>
                        <span class="n">{{ $queue['requetes'] }}</span>
                    </div>
                    @foreach($fileRequetes as $r)
                        @php
                            $rNom = $r->user->name ?? 'Utilisateur';
                            $rParts = preg_split('/\s+/', trim($rNom));
                            $rIni = mb_strtoupper(mb_substr($rParts[0] ?? '?', 0, 1) . mb_substr($rParts[1] ?? '', 0, 1));
                        @endphp
                        <div class="rh-row act">
                            <span class="rh-ini" aria-hidden="true">{{ $rIni }}</span>
                            <span class="rh-row-main">
                                <span class="rh-row-title">{{ $estChef ? 'Réponse' : $rNom }} · « {{ \Illuminate\Support\Str::limit($r->sujet, 70) }} »</span>
                                <span class="rh-row-sub">
                                    @if(!$estChef && $r->entreprise){{ $r->entreprise->nom }} · @endif{{ $r->categorie_libelle }} · {{ ($estChef ? $r->repondu_le : $r->created_at)?->locale('fr')->diffForHumans() }}
                                </span>
                            </span>
                            <span class="rh-row-end">
                                @if(!$estChef && $r->isUrgente())<span class="rh-badge no">Urgente</span>@endif
                                <a href="{{ $estChef ? route('admin.requetes.show', $r) : route('admin.admin-requetes.show', $r) }}" class="rh-btn soft sm">{{ $estChef ? 'Lire' : 'Répondre' }}</a>
                            </span>
                        </div>
                    @endforeach
                @endif

                {{-- Justificatifs --}}
                @if($fileJustificatifs->isNotEmpty())
                    <div class="rh-group">
                        <span>Justificatifs reçus</span>
                        <span class="n">{{ $nbJustif }}</span>
                    </div>
                    @foreach($fileJustificatifs as $j)
                        <div class="rh-row act">
                            <span class="rh-ini" aria-hidden="true">{{ $iniDe($j->personnel) }}</span>
                            <span class="rh-row-main">
                                <span class="rh-row-title">{{ $nomDe($j->personnel) }} · justificatif pour l'absence du {{ $jour($j->date_absence) }}</span>
                                <span class="rh-row-sub">@if($isSuper && $j->entreprise){{ $j->entreprise->nom }} · @endif reçu {{ $j->updated_at?->locale('fr')->diffForHumans() }}</span>
                            </span>
                            <span class="rh-row-end">
                                <a href="{{ asset('storage/' . $j->justificatif) }}" target="_blank" rel="noopener" class="rh-btn soft sm">Voir</a>
                                <form method="POST" action="{{ route('admin.absences.toggle-justifiee', $j) }}" data-lock>
                                    @csrf
                                    <button type="submit" class="rh-btn sm">Marquer justifiée</button>
                                </form>
                            </span>
                        </div>
                    @endforeach
                @endif
            </div>
            @endif
        </section>

        {{-- ── Colonne de droite ── --}}
        <aside class="rh-page" style="gap:28px">
            <section class="rh-section" aria-labelledby="tJour">
                <h2 class="rh-h2" id="tJour">Aujourd'hui</h2>
                <div class="rh-card-flat">
                    <div class="rh-row">
                        <span class="rh-row-main">
                            <span class="rh-row-title">{{ $absentsTotal }} {{ $absentsTotal > 1 ? 'absents' : 'absent' }} sur {{ $totalEmployes }}</span>
                            <span class="rh-row-sub">{{ $enCongeAujourdhui->count() }} en congé, {{ $absentsAujourdhui->count() }} {{ $absentsAujourdhui->count() > 1 ? 'absences' : 'absence' }}</span>
                        </span>
                    </div>
                    @foreach($absentsListe->take(5) as $p)
                        <div class="rh-row" style="min-height:56px">
                            <span class="rh-row-main">
                                <span class="rh-row-title" style="font-size:14px">{{ $p['nom'] }}</span>
                                <span class="rh-row-sub">{{ $p['info'] }}</span>
                            </span>
                        </div>
                    @endforeach
                    @if($absentsListe->count() > 5)
                        <div class="rh-more"><span class="rh-row-sub">et {{ $absentsListe->count() - 5 }} {{ $absentsListe->count() - 5 > 1 ? 'autres' : 'autre' }}</span></div>
                    @endif
                </div>
            </section>

            <section class="rh-section" aria-labelledby="tVeille">
                <h2 class="rh-h2" id="tVeille">À surveiller</h2>
                <div class="rh-card-flat">
                    @if($docsExpirentBientot > 0)
                        <div class="rh-row">
                            <span class="rh-row-main">
                                <span class="rh-row-title" style="font-size:14px">{{ $docsExpirentBientot }} {{ $docsExpirentBientot > 1 ? 'documents expirent' : 'document expire' }} d'ici 30 jours</span>
                                <span class="rh-row-sub">Pièces des dossiers agents</span>
                            </span>
                            <a href="{{ route('admin.dossiers-agents.index') }}" class="rh-btn soft sm">Voir</a>
                        </div>
                    @endif
                    @if($agentsSansCompte > 0)
                        <div class="rh-row">
                            <span class="rh-row-main">
                                <span class="rh-row-title" style="font-size:14px">{{ $agentsSansCompte }} {{ $agentsSansCompte > 1 ? 'agents' : 'agent' }} sans compte</span>
                                <span class="rh-row-sub">{{ $agentsSansCompte > 1 ? 'Ils ne peuvent pas' : 'Il ne peut pas' }} voir leurs bulletins</span>
                            </span>
                            <a href="{{ $isSuper ? route('admin.utilisateurs.index') : route('admin.personnels.index') }}" class="rh-btn soft sm">{{ $isSuper ? 'Créer' : 'Voir' }}</a>
                        </div>
                    @endif
                    @if($docsExpirentBientot === 0 && $agentsSansCompte === 0)
                        <div class="rh-row"><span class="rh-row-sub">Rien à signaler.</span></div>
                    @endif
                </div>
            </section>

            <section class="rh-section" aria-labelledby="tMois">
                <h2 class="rh-h2" id="tMois">Ce mois-ci</h2>
                <div class="rh-figures">
                    <a href="{{ route('admin.conges.index', ['vue' => 'traitees']) }}" class="rh-figure"><strong>{{ $congesApprouvesMois }}</strong><span>{{ $congesApprouvesMois > 1 ? 'congés approuvés' : 'congé approuvé' }}</span></a>
                    <a href="{{ route('admin.absences.index') }}" class="rh-figure"><strong>{{ $absencesMois }}</strong><span>{{ $absencesMois > 1 ? 'absences enregistrées' : 'absence enregistrée' }}</span></a>
                </div>
                <div class="rh-figures">
                    <a href="{{ route('admin.personnels.index') }}" class="rh-figure"><strong>{{ $totalEmployes }}</strong><span>{{ $totalEmployes > 1 ? 'agents actifs' : 'agent actif' }}</span></a>
                    <a href="{{ route('admin.bulletins-paie.index') }}" class="rh-figure"><strong>{{ $statsBulletins['total_bulletins'] ?? 0 }}</strong><span>bulletins {{ $annee }}</span></a>
                    @if($isSuper)
                        <a href="{{ route('admin.entreprises.index') }}" class="rh-figure"><strong>{{ $totalEntreprises }}</strong><span>{{ $totalEntreprises > 1 ? 'entreprises' : 'entreprise' }}</span></a>
                    @endif
                </div>
            </section>
        </aside>
    </div>
</div>

{{-- Refus d'une absence (motif obligatoire) --}}
@php
    $rejOld = old('_reject_action');
    $rejOld = is_string($rejOld) && str_starts_with($rejOld, url('admin/absences') . '/') ? $rejOld : '';
@endphp
<div class="rh-sheet" id="dbReject" role="dialog" aria-modal="true" aria-labelledby="dbRejectTitle" @if($errors->has('motif_refus') && $rejOld) data-autoopen @endif>
    <div class="rh-sheet-box">
        <div class="rh-sheet-head">
            <div>
                <h2 id="dbRejectTitle">Refuser l'absence</h2>
                <p id="dbRejectWho">L'agent sera prévenu avec votre motif.</p>
            </div>
            <button type="button" class="rh-sheet-x" data-close aria-label="Fermer"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M18 6 6 18M6 6l12 12"/></svg></button>
        </div>
        <form method="POST" action="{{ $rejOld }}" id="dbRejectForm" class="rh-form" data-lock>
            @csrf
            <input type="hidden" name="_reject_action" value="{{ $rejOld }}">
            <div class="rh-field">
                <label for="dbMotif">Motif du refus</label>
                <textarea id="dbMotif" name="motif_refus" class="rh-textarea" required maxlength="1000" placeholder="Expliquez la raison à l'agent…">{{ old('motif_refus') }}</textarea>
                @error('motif_refus')<p class="rh-err">{{ $message }}</p>@enderror
            </div>
            <div class="rh-sheet-foot">
                <button type="button" class="rh-btn soft" data-close>Annuler</button>
                <button type="submit" class="rh-btn" style="background:var(--no)">Refuser</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
(function () {
    var h = new Date().getHours(), el = document.getElementById('rhGreeting');
    if (el) el.textContent = h < 18 ? 'Bonjour' : 'Bonsoir';

    var form = document.getElementById('dbRejectForm');
    var who = document.getElementById('dbRejectWho');
    document.addEventListener('click', function (e) {
        var b = e.target.closest('[data-open="dbReject"][data-action]');
        if (!b || !form) return;
        form.setAttribute('action', b.getAttribute('data-action'));
        form.querySelector('[name=_reject_action]').value = b.getAttribute('data-action');
        if (who) who.textContent = 'Absence de ' + b.getAttribute('data-who') + '. L\'agent sera prévenu avec votre motif.';
    }, true);
})();
</script>
@endsection
