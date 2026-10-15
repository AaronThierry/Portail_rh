<?php

namespace App\Support;

use App\Models\Absence;
use App\Models\Conge;
use App\Models\Requete;
use App\Models\User;

/**
 * File « À traiter » de l'espace admin.
 *
 * Une seule source de vérité pour les compteurs de la barre latérale et
 * pour la page d'accueil admin, afin que les pastilles et la liste
 * annoncent toujours le même nombre.
 *
 * Circuit en deux étapes :
 *   - Chef d'Entreprise : traite ce qui est « en_attente » (étape 1) ;
 *   - Super Admin / RH / Agent administratif : approuve ce qui est
 *     « valide_chef » (étape 2).
 */
class AdminQueue
{
    /** @var array<int, array> mémo par utilisateur pour la requête en cours */
    protected static array $memo = [];

    public static function estChef(User $user): bool
    {
        return $user->hasRole("Chef d'Entreprise");
    }

    /** Statut que l'utilisateur peut faire avancer. */
    public static function statutConge(User $user): string
    {
        return self::estChef($user) ? 'en_attente' : 'valide_chef';
    }

    public static function statutAbsence(User $user): string
    {
        return self::estChef($user) ? 'en_attente' : 'valide_chef';
    }

    /** Entreprise à laquelle limiter les requêtes (null = toutes, Super Admin). */
    public static function entrepriseId(User $user): ?int
    {
        return $user->entreprise_id ?: null;
    }

    public static function congesQuery(User $user)
    {
        $q = Conge::where('statut', self::statutConge($user));
        if ($id = self::entrepriseId($user)) {
            $q->forEntreprise($id);
        }
        return $q;
    }

    public static function absencesQuery(User $user)
    {
        $q = Absence::where('statut', self::statutAbsence($user));
        if ($id = self::entrepriseId($user)) {
            $q->forEntreprise($id);
        }
        return $q;
    }

    /**
     * Requêtes demandant une action :
     *  - Super Admin : requêtes clients non lues, en attente ou en cours ;
     *  - Chef d'Entreprise : réponses reçues et pas encore lues.
     */
    public static function requetesQuery(User $user)
    {
        if ($user->hasRole('Super Admin')) {
            return Requete::nonLuesAdmin();
        }
        if (self::estChef($user)) {
            return Requete::where('user_id', $user->id)
                ->where('lu_par_chef', false)
                ->where('statut', 'repondue');
        }
        return null;
    }

    /**
     * @return array{conges:int, absences:int, requetes:int, total:int}
     */
    public static function counts(?User $user = null): array
    {
        $user = $user ?: auth()->user();
        if (!$user) {
            return ['conges' => 0, 'absences' => 0, 'requetes' => 0, 'total' => 0];
        }

        if (isset(self::$memo[$user->id])) {
            return self::$memo[$user->id];
        }

        $conges = (int) self::congesQuery($user)->count();
        $absences = (int) self::absencesQuery($user)->count();
        $rq = self::requetesQuery($user);
        $requetes = $rq ? (int) $rq->count() : 0;

        return self::$memo[$user->id] = [
            'conges' => $conges,
            'absences' => $absences,
            'requetes' => $requetes,
            'total' => $conges + $absences + $requetes,
        ];
    }
}
