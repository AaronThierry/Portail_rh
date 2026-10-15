{{--
    Badge de statut commun aux congés, absences et requêtes.
    Paramètre : $statut (string)
--}}
@php
    [$rhCls, $rhLbl] = match ($statut) {
        'en_attente'              => ['wait', 'En attente'],
        'valide_chef'             => ['info', 'Validé par le responsable'],
        'en_cours'                => ['info', 'En cours'],
        'approuve', 'approuvee'   => ['ok',   'Approuvé' . ($statut === 'approuvee' ? 'e' : '')],
        'repondue'                => ['ok',   'Répondue'],
        'refuse', 'refusee'       => ['no',   'Refusé' . ($statut === 'refusee' ? 'e' : '')],
        'annule', 'annulee'       => ['off',  'Annulé' . ($statut === 'annulee' ? 'e' : '')],
        'fermee'                  => ['off',  'Fermée'],
        default                   => ['off',  ucfirst(str_replace('_', ' ', (string) $statut))],
    };
@endphp
<span class="rh-badge {{ $rhCls }}">{{ $rhLbl }}</span>
