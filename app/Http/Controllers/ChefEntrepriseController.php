<?php

namespace App\Http\Controllers;

use App\Models\Entreprise;
use App\Models\User;
use App\Mail\CompteChefEntrepriseMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class ChefEntrepriseController extends Controller
{
    /**
     * Affiche le formulaire de création d'un compte Chef d'Entreprise
     */
    public function create(Entreprise $entreprise)
    {
        $compteExistant = User::where('entreprise_id', $entreprise->id)
            ->role("Chef d'Entreprise")
            ->first();

        return view('admin.chef-entreprise.creer-compte', compact('entreprise', 'compteExistant'));
    }

    /**
     * Crée le compte Chef d'Entreprise et envoie les identifiants par email
     */
    public function store(Request $request, Entreprise $entreprise)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
        ], [
            'name.required'  => 'Le nom est obligatoire.',
            'email.required' => "L'adresse email est obligatoire.",
            'email.email'    => "L'adresse email n'est pas valide.",
            'email.unique'   => 'Cette adresse email est déjà utilisée par un autre compte.',
        ]);

        // Vérifier qu'il n'existe pas déjà un Chef d'Entreprise actif pour cette entreprise
        $compteExistant = User::where('entreprise_id', $entreprise->id)
            ->role("Chef d'Entreprise")
            ->first();

        if ($compteExistant) {
            return back()->withErrors([
                'email' => "Un compte Chef d'Entreprise existe déjà pour {$entreprise->nom} ({$compteExistant->email}).",
            ])->withInput();
        }

        // Générer un mot de passe temporaire sécurisé (12 caractères)
        $motDePasseTemporaire = $this->genererMotDePasse();

        // Créer le compte utilisateur
        $user = User::create([
            'name'                  => $request->name,
            'email'                 => $request->email,
            'password'              => Hash::make($motDePasseTemporaire),
            'entreprise_id'         => $entreprise->id,
            'force_password_change' => true,
            'status'                => 'active',
        ]);

        // Attribuer le rôle Chef d'Entreprise
        $user->assignRole("Chef d'Entreprise");

        // Envoyer l'email avec les identifiants
        try {
            Mail::to($request->email)->send(
                new CompteChefEntrepriseMail($user, $entreprise, $motDePasseTemporaire)
            );
            $emailEnvoye = true;
        } catch (\Exception $e) {
            \Log::error("Erreur envoi email Chef d'Entreprise [{$entreprise->id}]: " . $e->getMessage());
            $emailEnvoye = false;
        }

        $message = $emailEnvoye
            ? "Compte créé avec succès. Les identifiants ont été envoyés à {$request->email}."
            : "Compte créé avec succès, mais l'envoi de l'email a échoué. Identifiants : {$request->email} / {$motDePasseTemporaire}";

        return redirect()
            ->route('admin.entreprises.show', $entreprise)
            ->with('success', $message);
    }

    /**
     * Réinitialise et renvoie de nouveaux identifiants pour un compte existant
     */
    public function renvoyer(Entreprise $entreprise)
    {
        $user = User::where('entreprise_id', $entreprise->id)
            ->role("Chef d'Entreprise")
            ->firstOrFail();

        $nouveauMotDePasse = $this->genererMotDePasse();

        $user->update([
            'password'              => Hash::make($nouveauMotDePasse),
            'force_password_change' => true,
        ]);

        try {
            Mail::to($user->email)->send(
                new CompteChefEntrepriseMail($user, $entreprise, $nouveauMotDePasse)
            );
            $emailEnvoye = true;
        } catch (\Exception $e) {
            \Log::error("Erreur renvoi email Chef d'Entreprise [{$entreprise->id}]: " . $e->getMessage());
            $emailEnvoye = false;
        }

        $message = $emailEnvoye
            ? "Nouveaux identifiants envoyés à {$user->email}."
            : "Mot de passe réinitialisé, mais l'envoi de l'email a échoué. Nouveau mot de passe : {$nouveauMotDePasse}";

        return redirect()
            ->route('admin.entreprises.show', $entreprise)
            ->with('success', $message);
    }

    /**
     * Supprime le compte Chef d'Entreprise
     */
    public function destroy(Entreprise $entreprise)
    {
        $user = User::where('entreprise_id', $entreprise->id)
            ->role("Chef d'Entreprise")
            ->firstOrFail();

        $user->delete();

        return redirect()
            ->route('admin.entreprises.show', $entreprise)
            ->with('success', "Le compte Chef d'Entreprise de {$entreprise->nom} a été supprimé.");
    }

    /**
     * Génère un mot de passe temporaire sécurisé
     * Contient majuscules, minuscules, chiffres et caractères spéciaux
     */
    private function genererMotDePasse(): string
    {
        $maj    = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $min    = 'abcdefghjkmnpqrstuvwxyz';
        $chiff  = '23456789';
        $spec   = '@#$!';

        // Garantir au moins un de chaque type
        $mdp  = $maj[random_int(0, strlen($maj) - 1)];
        $mdp .= $min[random_int(0, strlen($min) - 1)];
        $mdp .= $chiff[random_int(0, strlen($chiff) - 1)];
        $mdp .= $spec[random_int(0, strlen($spec) - 1)];

        // Compléter jusqu'à 12 caractères
        $tous = $maj . $min . $chiff . $spec;
        for ($i = 4; $i < 12; $i++) {
            $mdp .= $tous[random_int(0, strlen($tous) - 1)];
        }

        // Mélanger
        return str_shuffle($mdp);
    }
}
