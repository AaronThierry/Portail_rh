@extends('layouts.espace-employe')

@section('title', 'Attestations')

@section('styles')
<style>
    .att-types { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px; }
    .att-type { position: relative; display: flex; flex-direction: column; gap: 4px; padding: 16px 16px 16px 48px; border-radius: var(--radius); background: var(--surface, #fff); box-shadow: 0 0 0 1px var(--line); cursor: pointer; }
    .att-type input { position: absolute; left: 16px; top: 18px; width: 20px; height: 20px; accent-color: var(--brand); margin: 0; }
    .att-type strong { font-size: 15px; }
    .att-type span { font-size: 13px; color: var(--muted); }
    .att-type:has(input:checked) { box-shadow: 0 0 0 2px var(--brand); background: var(--brand-bg); }
</style>
@endsection

@section('content')
<div class="rh-page">
    @include('espace-employe.partials.tabs', ['section' => 'documents'])

    <section class="rh-head">
        <div class="rh-head-txt">
            <h1 class="rh-h1">Attestations</h1>
            <p class="rh-lead">Le service RH prépare votre attestation, généralement sous 24 à 48 heures. Elle arrive ensuite dans « Mon dossier ».</p>
        </div>
    </section>

    <form action="{{ route('espace-employe.assistance.store') }}" method="POST" class="rh-card rh-form" id="attForm" data-lock="Envoi…">
        @csrf
        <input type="hidden" name="categorie" value="autre">
        <input type="hidden" name="priorite" value="normale">

        <fieldset style="border: 0; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 10px">
            <legend class="rh-label" style="margin-bottom: 10px">Quelle attestation ?</legend>
            <div class="att-types">
                <label class="att-type">
                    <input type="radio" name="sujet" value="Demande d'attestation de travail" required checked>
                    <strong>De travail</strong>
                    <span>Prouve que vous êtes employé(e)</span>
                </label>
                <label class="att-type">
                    <input type="radio" name="sujet" value="Demande d'attestation de salaire">
                    <strong>De salaire</strong>
                    <span>Justificatif de revenus</span>
                </label>
                <label class="att-type">
                    <input type="radio" name="sujet" value="Demande d'attestation de présence" data-date>
                    <strong>De présence</strong>
                    <span>Pour une date précise</span>
                </label>
                <label class="att-type">
                    <input type="radio" name="sujet" value="Demande d'attestation (autre)">
                    <strong>Autre</strong>
                    <span>Précisez dans le message</span>
                </label>
            </div>
        </fieldset>

        <div class="rh-field" id="dateGroup" hidden>
            <label for="datePresence">Date concernée</label>
            <input type="date" id="datePresence" class="rh-input" max="{{ date('Y-m-d') }}">
        </div>

        <div class="rh-field">
            <label for="attMessage">À quoi servira-t-elle ?</label>
            <textarea id="attMessage" class="rh-textarea" rows="3" required maxlength="2800"
                      placeholder="Ex. demande de visa, prêt bancaire, dossier administratif">{{ old('message') }}</textarea>
            <input type="hidden" name="message" id="attMessageFinal">
        </div>

        <div>
            <button type="submit" class="rh-btn">Envoyer la demande</button>
        </div>
    </form>

    <section class="rh-section" aria-labelledby="titreSuivi">
        <h2 class="rh-h2" id="titreSuivi">Mes demandes</h2>
        @if(($demandesAttestation ?? collect())->isNotEmpty())
            <ul class="rh-list rh-card-flat">
                @foreach($demandesAttestation as $req)
                    <li>
                        <a href="{{ route('espace-employe.assistance') }}#ticket-{{ $req->id }}" class="rh-row">
                            <span class="rh-row-main">
                                <span class="rh-row-title">{{ ucfirst(\Illuminate\Support\Str::after($req->sujet, "Demande d'")) }}</span>
                                <span class="rh-row-sub">Demandée le {{ $req->created_at->format('d/m/Y') }}</span>
                            </span>
                            @include('espace-employe.partials.statut', ['statut' => $req->statut])
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="rh-lead">Vous n'avez pas encore demandé d'attestation.</p>
        @endif
    </section>
</div>
@endsection

@section('scripts')
<script>
(function () {
    var form = document.getElementById('attForm');
    var dateGroup = document.getElementById('dateGroup'), dateInput = document.getElementById('datePresence');
    function syncDate() {
        var presence = !!form.querySelector('input[name=sujet]:checked[data-date]');
        dateGroup.hidden = !presence;
        dateInput.required = presence;
    }
    form.querySelectorAll('input[name=sujet]').forEach(function (r) { r.addEventListener('change', syncDate); });
    syncDate();

    // Le message envoyé au service RH regroupe l'usage et, si besoin, la date
    form.addEventListener('submit', function () {
        var msg = document.getElementById('attMessage').value.trim();
        if (!dateGroup.hidden && dateInput.value) {
            var d = new Date(dateInput.value + 'T12:00:00');
            msg = 'Date concernée : ' + d.toLocaleDateString('fr-FR') + '\n' + msg;
        }
        document.getElementById('attMessageFinal').value = 'Usage prévu : ' + msg;
    });
})();
</script>
@endsection
