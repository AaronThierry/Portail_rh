@extends('layouts.espace-employe')

@section('title', isset($bulletinSelectionne) && $bulletinSelectionne ? 'Bulletin de ' . $bulletinSelectionne->periode_formatee : 'Bulletins de paie')

@section('styles')
<style>
    .bp-viewer { width: 100%; height: 70vh; min-height: 420px; border: 0; border-radius: var(--radius-lg); background: var(--subtle); box-shadow: 0 0 0 1px var(--line-soft); }
    .bp-mois { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 10px; }
    .bp-m { display: flex; flex-direction: column; gap: 4px; padding: 16px; border-radius: var(--radius); background: var(--surface, #fff); box-shadow: 0 0 0 1px var(--line-soft); text-decoration: none; color: inherit; min-height: 88px; }
    a.bp-m:hover { box-shadow: 0 0 0 1.5px var(--brand); }
    .bp-m strong { font-size: 16px; }
    .bp-m span { font-size: 13px; color: var(--muted); }
    .bp-m.vide { background: var(--subtle, transparent); box-shadow: inset 0 0 0 1px var(--line-soft); }
    .bp-m.vide strong { color: var(--muted); font-weight: 600; }
</style>
@endsection

@section('content')
<div class="rh-page">
    @include('espace-employe.partials.tabs', ['section' => 'documents'])

    @if(!isset($bulletinSelectionne) || !$bulletinSelectionne)
        @php
            $dernier = collect($moisData ?? [])->filter(fn ($m) => $m['bulletin'])->last();
        @endphp

        <section class="rh-head">
            <div class="rh-head-txt">
                <h1 class="rh-h1">Bulletins de paie</h1>
                <p class="rh-lead">
                    @if(($totalBulletins ?? 0) > 0)
                        {{ $totalBulletins }} bulletin{{ $totalBulletins > 1 ? 's' : '' }} disponible{{ $totalBulletins > 1 ? 's' : '' }}, à consulter ou télécharger en PDF.
                    @else
                        Vos bulletins apparaîtront ici dès que le service RH les aura mis à disposition.
                    @endif
                </p>
            </div>
        </section>

        @if(count($anneesDisponibles ?? []) > 0)
            @if($dernier)
                <section class="rh-card" style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px" aria-label="Dernier bulletin">
                    <div>
                        <div class="rh-row-sub">Dernier bulletin {{ $anneeSelectionnee }}, mis à disposition le {{ $dernier['bulletin']->created_at->translatedFormat('j F Y') }}</div>
                        <div style="font-family: var(--display); font-size: 26px; font-weight: 700; letter-spacing: -0.01em">{{ $dernier['nom'] }} {{ $anneeSelectionnee }}</div>
                    </div>
                    <div class="rh-actions">
                        <a href="{{ route('espace-employe.bulletins.download', $dernier['bulletin']) }}" class="rh-btn">Télécharger le PDF</a>
                        <a href="{{ route('espace-employe.bulletins', ['annee' => $anneeSelectionnee, 'mois' => $dernier['mois']]) }}" class="rh-btn soft">Aperçu</a>
                    </div>
                </section>
            @endif

            <section class="rh-section" aria-labelledby="titreAnnee">
                <div class="rh-section-head">
                    <h2 class="rh-h2" id="titreAnnee">{{ $anneeSelectionnee }}</h2>
                    @if(count($anneesDisponibles) > 1)
                        <nav class="rh-tabs" aria-label="Année" style="margin: 0; padding: 0">
                            @foreach($anneesDisponibles as $a)
                                <a href="{{ route('espace-employe.bulletins', ['annee' => $a]) }}" @if($anneeSelectionnee == $a) aria-current="page" @endif>{{ $a }}</a>
                            @endforeach
                        </nav>
                    @endif
                </div>
                <div class="bp-mois">
                    @foreach($moisData as $mois => $data)
                        @if($data['bulletin'])
                            <a href="{{ route('espace-employe.bulletins', ['annee' => $anneeSelectionnee, 'mois' => $mois]) }}" class="bp-m">
                                <strong>{{ $data['nom'] }}</strong>
                                <span>PDF · {{ $data['bulletin']->fichier_taille_formatee }}</span>
                            </a>
                        @else
                            <div class="bp-m vide" aria-label="{{ $data['nom'] }} : pas de bulletin">
                                <strong>{{ $data['nom'] }}</strong>
                                <span>Pas de bulletin</span>
                            </div>
                        @endif
                    @endforeach
                </div>
            </section>
        @else
            <div class="rh-card rh-empty">
                <strong>Aucun bulletin pour l'instant</strong>
                <p>Vous recevrez une notification dès qu'un bulletin sera disponible.</p>
            </div>
        @endif
    @else
        <section class="rh-head">
            <div class="rh-head-txt">
                <a href="{{ route('espace-employe.bulletins', ['annee' => $bulletinSelectionne->annee]) }}" class="rh-link" style="padding: 0">‹ Tous les bulletins {{ $bulletinSelectionne->annee }}</a>
                <h1 class="rh-h1">{{ $bulletinSelectionne->periode_formatee }}</h1>
                <p class="rh-lead">
                    Mis à disposition le {{ $bulletinSelectionne->created_at->translatedFormat('j F Y') }}
                    @if($bulletinSelectionne->salaire_net) · net à payer {{ number_format($bulletinSelectionne->salaire_net, 0, ',', ' ') }} F CFA @endif
                    @if($bulletinSelectionne->reference) · réf. {{ $bulletinSelectionne->reference }} @endif
                </p>
            </div>
            <div class="rh-actions">
                <a href="{{ route('espace-employe.bulletins.download', $bulletinSelectionne) }}" class="rh-btn">Télécharger</a>
                <a href="{{ route('espace-employe.bulletins.preview', $bulletinSelectionne) }}" target="_blank" rel="noopener" class="rh-btn soft">Plein écran</a>
            </div>
        </section>

        <iframe class="bp-viewer" title="Bulletin de {{ $bulletinSelectionne->periode_formatee }}"
                src="{{ route('espace-employe.bulletins.preview', $bulletinSelectionne) }}#toolbar=0&navpanes=0"></iframe>
        <p class="rh-hint">L'aperçu ne s'affiche pas sur votre téléphone ? Utilisez « Télécharger ».</p>
    @endif
</div>
@endsection
