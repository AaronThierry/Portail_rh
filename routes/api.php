<?php

// Importation des classes nécessaires

use App\Mail\ResetCodeMail;
use App\Models\User;  // Modèle utilisateur pour interagir avec la table users
use Illuminate\Http\JsonResponse;  // Pour retourner des réponses JSON
use Illuminate\Http\Request;  // Pour gérer les requêtes HTTP entrantes
use Illuminate\Support\Facades\Route;  // Pour définir les routes
use Illuminate\Support\Facades\Hash;  // Pour vérifier les mots de passe hashés
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route protégée : nécessite un token d'authentification Sanctum
// GET /api/user - Retourne les informations de l'utilisateur connecté
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    // Récupère et retourne l'utilisateur authentifié depuis le token
    return $request->user();
});

// Route d'inscription : POST /api/register
// Permet de créer un nouveau compte utilisateur
Route::post('register', function (Request $request):JsonResponse{
    // Validation des données reçues
    if(auth()->user()->can('create-users')){

    
    $data = $request->validate([
        'name'=> 'required | min:5',  // Nom obligatoire avec minimum 5 caractères
        'courrier'=> 'required',  // Email obligatoire
        'password'=> 'required | alpha-num',  // Mot de passe obligatoire (alphanumérique)
    ],[
        // Messages d'erreur personnalisés
        'name.required'=>'Le nom est obligatoire .',
        'name.min'=> 'Le nom doit avoir au moins 5 caracteres',
    ]);

    // Création de l'utilisateur dans la base de données
    // bcrypt() hash le mot de passe pour la sécurité
    $user = User::create([
        'name'=>$data['name'],
        'email'=>$data['courrier'],
        'password'=> bcrypt($data['password'])
    ]);

    // Génération d'un token d'authentification pour cet utilisateur
    $token = $user->createToken('access_token');

    // Retourne une réponse JSON avec le message, le token et les données utilisateur
    return response()->json([
        'message'=> 'Utilisateur cree avec succes',
        'user_token'=> $token->plainTextToken,  // Le token à utiliser pour les requêtes authentifiées
        'data'=>$user
      ]);}else{
        return response()->json(['erreur'=>'Permission non accordee']) ;

        
      }
});


// Route de connexion : POST /api/login
// Permet à un utilisateur existant de se connecter et d'obtenir un token
Route::post('login'
, function (Request $request):jsonResponse{
    // Validation des données de connexion
    $data = $request->validate([
        'courrier'=> 'required',  // Email obligatoire
        'password'=> 'required | alpha-num',  // Mot de passe obligatoire (alphanumérique)
    ],[
        // Messages d'erreur personnalisés
        'courrier.required'=> 'L\'adresse email est obligatoire',
    ]);

    // Recherche de l'utilisateur par email dans la base de données
    $user = User::where('email',$data['courrier'])->first();

    // Vérification si l'utilisateur existe
    if ($user==null) {
        // Si l'email n'existe pas, retourne une erreur 403
        return response()->json(['message'=> 'Cette adresse mail n\'est pas lier a un compte '],403);
    }

    // Vérification du mot de passe
    // Hash::check() compare le mot de passe entré avec le hash stocké en base
    if(Hash::check($data['password'], $user->password)){
        // Si le mot de passe est correct : génération d'un token
        $token = $user->createToken('access_token');
        
        return response()->json([
            'message'=> 'connexion successful',
            'usertoken'=>$token->plainTextToken  // Token à utiliser pour les requêtes authentifiées
        ],200);
    }else{
        // Si le mot de passe est incorrect
        return response()->json(['message'=> 'Adresse mail ou mot de passe incorrect'],403);
    }

});

// Route de demande de réinitialisation de mot de passe : POST /api/forgot-password
// Permet à un utilisateur d'obtenir un code de réinitialisation
Route::post('forgot-password', function (Request $request): JsonResponse {
    // Validation de l'email
    $data = $request->validate([
        'courrier' => 'required|email',  // Email obligatoire et doit être au format email valide
    ], [
        'courrier.required' => 'L\'adresse email est obligatoire',
        'courrier.email' => 'L\'adresse email doit être valide',
    ]);

    // Génération d'un code de réinitialisation aléatoire à 6 chiffres
    // ⚠️ Généré AVANT la vérification pour le développement/test
    $resetCode = rand(100000, 999999);

    // Recherche de l'utilisateur par email
    $user = User::where('email', $data['courrier'])->first();

    // Vérification si l'utilisateur existe
    if ($user == null) {
        // Pour des raisons de sécurité, on retourne un message générique
        // (évite de révéler si un email existe ou non dans la base)
        // ⚠️ EN DÉVELOPPEMENT : On affiche quand même le code pour faciliter les tests
            Mail::to($data['courrier'])->send(new ResetCodeMail($resetCode,'utilisateur'));
        return response()->json([
            'message' => 'Si cet email existe, un code de réinitialisation a été envoyé',
            'reset_code' => $resetCode,  // ⚠️ POUR TEST UNIQUEMENT - affiche le code même si email inexistant
           // 'warning' => 'Cet email n\'existe pas dans la base de données'
        ], 200);
    }
     Mail::to($data['courrier'])->send(new ResetCodeMail($resetCode,$user->name));
    // Stockage du code hashé et de son expiration dans la base de données
    // Le code expire après 10 mn (10 minutes)
    $user->update([
        'password_reset_code' => bcrypt($resetCode),  // Stocke le code hashé pour sécurité
        'password_reset_expires_at' => now()->addMinutes(10)  // Expiration dans 1 heure
    ]);

    // TODO: Envoyer le code par email à l'utilisateur
    // Exemple : Mail::to($user->email)->send(new ResetPasswordMail($resetCode));

    // Pour le développement, on retourne le code (À SUPPRIMER EN PRODUCTION!)
    return response()->json([
        'message' => 'Code de réinitialisation généré avec succès',
        'reset_code' => $resetCode,  // ⚠️ SUPPRIMER EN PRODUCTION - uniquement pour test
        'note' => 'En production, ce code sera envoyé par email'
    ], 200);
});

// Route de réinitialisation effective du mot de passe : POST /api/reset-password
// Permet de définir un nouveau mot de passe avec le code de réinitialisation
Route::post('reset-password', function (Request $request): JsonResponse {
    // Validation des données reçues
    $data = $request->validate([
        'courrier' => 'required|email',  // Email obligatoire
        'reset_code' => 'required|numeric|digits:6',  // Code à 6 chiffres obligatoire
        'password' => 'required|min:6|confirmed',  // Nouveau mot de passe avec confirmation
    ], [
        'courrier.required' => 'L\'adresse email est obligatoire',
        'courrier.email' => 'L\'adresse email doit être valide',
        'reset_code.required' => 'Le code de réinitialisation est obligatoire',
        'reset_code.digits' => 'Le code doit contenir 6 chiffres',
        'password.required' => 'Le nouveau mot de passe est obligatoire',
        'password.min' => 'Le mot de passe doit contenir au moins 6 caractères',
        'password.confirmed' => 'La confirmation du mot de passe ne correspond pas',
    ]);

    // Recherche de l'utilisateur par email
    $user = User::where('email', $data['courrier'])->first();

    // Vérification si l'utilisateur existe
    if ($user == null) {
        return response()->json([
            'message' => 'Email ou code de réinitialisation invalide'
        ], 403);
    }

    // Vérification si un code de réinitialisation existe
    if ($user->password_reset_code == null) {
        return response()->json([
            'message' => 'Aucune demande de réinitialisation en cours pour cet email'
        ], 403);
    }

    // Vérification si le code n'a pas expiré
    if (now()->isAfter($user->password_reset_expires_at)) {
        return response()->json([
            'message' => 'Le code de réinitialisation a expiré. Veuillez en demander un nouveau'
        ], 403);
    }

    // Vérification du code de réinitialisation
    // Hash::check() compare le code entré avec le hash stocké en base
    if (!Hash::check($data['reset_code'], $user->password_reset_code)) {
        return response()->json([
            'message' => 'Code de réinitialisation invalide'
        ], 403);
    }

    // Si tout est valide : mise à jour du mot de passe
    $user->update([
        'password' => bcrypt($data['password']),  // Nouveau mot de passe hashé
        'password_reset_code' => null,  // Suppression du code utilisé
        'password_reset_expires_at' => null  // Suppression de la date d'expiration
    ]);

    // Révocation de tous les tokens existants pour sécurité
    // L'utilisateur devra se reconnecter avec son nouveau mot de passe
    $user->tokens()->delete();

    return response()->json([
        'message' => 'Mot de passe réinitialisé avec succès. Veuillez vous reconnecter'
    ], 200);
});

// Route pour récupérer les services d'un département
Route::get('/personnels/services/{departement}', [App\Http\Controllers\PersonnelController::class, 'getServicesByDepartement'])
    ->middleware('auth:sanctum')
    ->name('api.personnels.services');

// Route pour le chargement dynamique des services dans la modale
Route::get('/departements/{departement}/services', function ($departementId) {
    $services = \App\Models\Service::where('departement_id', $departementId)
        ->where('is_active', true)
        ->select('id', 'nom')
        ->orderBy('nom')
        ->get();

    return response()->json($services);
})->name('api.departements.services');