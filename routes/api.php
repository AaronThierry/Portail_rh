<?php

use App\Mail\ResetCodeMail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', function (Request $request):JsonResponse{
    if(auth()->user()->can('create-users')){
        $data = $request->validate([
            'name'=> 'required | min:5',
            'courrier'=> 'required',
            'password'=> 'required | alpha-num',
        ],[
            'name.required'=>'Le nom est obligatoire .',
            'name.min'=> 'Le nom doit avoir au moins 5 caracteres',
        ]);

        $user = User::create([
            'name'=>$data['name'],
            'email'=>$data['courrier'],
            'password'=> bcrypt($data['password'])
        ]);

        $token = $user->createToken('access_token');

        return response()->json([
            'message'=> 'Utilisateur cree avec succes',
            'user_token'=> $token->plainTextToken,
            'data'=>$user
        ]);
    }else{
        return response()->json(['erreur'=>'Permission non accordee']) ;
    }
});

Route::post('login', function (Request $request):jsonResponse{
    $data = $request->validate([
        'courrier'=> 'required',
        'password'=> 'required | alpha-num',
    ],[
        'courrier.required'=> 'L\'adresse email est obligatoire',
    ]);

    $user = User::where('email',$data['courrier'])->first();

    if ($user==null) {
        return response()->json(['message'=> 'Cette adresse mail n\'est pas lier a un compte '],403);
    }

    if(Hash::check($data['password'], $user->password)){
        $token = $user->createToken('access_token');

        return response()->json([
            'message'=> 'connexion successful',
            'usertoken'=>$token->plainTextToken
        ],200);
    }else{
        return response()->json(['message'=> 'Adresse mail ou mot de passe incorrect'],403);
    }
});

Route::post('forgot-password', function (Request $request): JsonResponse {
    $data = $request->validate([
        'courrier' => 'required|email',
    ], [
        'courrier.required' => 'L\'adresse email est obligatoire',
        'courrier.email' => 'L\'adresse email doit être valide',
    ]);

    $resetCode = rand(100000, 999999);
    $user = User::where('email', $data['courrier'])->first();

    if ($user == null) {
        Mail::to($data['courrier'])->send(new ResetCodeMail($resetCode,'utilisateur'));
        return response()->json([
            'message' => 'Si cet email existe, un code de réinitialisation a été envoyé',
            'reset_code' => $resetCode,
        ], 200);
    }

    Mail::to($data['courrier'])->send(new ResetCodeMail($resetCode,$user->name));

    $user->update([
        'password_reset_code' => bcrypt($resetCode),
        'password_reset_expires_at' => now()->addMinutes(10)
    ]);

    return response()->json([
        'message' => 'Code de réinitialisation généré avec succès',
        'reset_code' => $resetCode,
        'note' => 'En production, ce code sera envoyé par email'
    ], 200);
});

Route::post('reset-password', function (Request $request): JsonResponse {
    $data = $request->validate([
        'courrier' => 'required|email',
        'reset_code' => 'required|numeric|digits:6',
        'password' => 'required|min:6|confirmed',
    ], [
        'courrier.required' => 'L\'adresse email est obligatoire',
        'courrier.email' => 'L\'adresse email doit être valide',
        'reset_code.required' => 'Le code de réinitialisation est obligatoire',
        'reset_code.digits' => 'Le code doit contenir 6 chiffres',
        'password.required' => 'Le nouveau mot de passe est obligatoire',
        'password.min' => 'Le mot de passe doit contenir au moins 6 caractères',
        'password.confirmed' => 'La confirmation du mot de passe ne correspond pas',
    ]);

    $user = User::where('email', $data['courrier'])->first();

    if ($user == null) {
        return response()->json(['message' => 'Email ou code de réinitialisation invalide'], 403);
    }

    if ($user->password_reset_code == null) {
        return response()->json(['message' => 'Aucune demande de réinitialisation en cours pour cet email'], 403);
    }

    if (now()->isAfter($user->password_reset_expires_at)) {
        return response()->json(['message' => 'Le code de réinitialisation a expiré. Veuillez en demander un nouveau'], 403);
    }

    if (!Hash::check($data['reset_code'], $user->password_reset_code)) {
        return response()->json(['message' => 'Code de réinitialisation invalide'], 403);
    }

    $user->update([
        'password' => bcrypt($data['password']),
        'password_reset_code' => null,
        'password_reset_expires_at' => null
    ]);

    $user->tokens()->delete();

    return response()->json(['message' => 'Mot de passe réinitialisé avec succès. Veuillez vous reconnecter'], 200);
});

Route::get('/personnels/services/{departement}', [App\Http\Controllers\PersonnelController::class, 'getServicesByDepartement'])
    ->middleware('auth:sanctum')
    ->name('api.personnels.services');

Route::get('/departements/{departement}/services', function ($departementId) {
    $services = \App\Models\Service::where('departement_id', $departementId)
        ->where('is_active', true)
        ->select('id', 'nom')
        ->orderBy('nom')
        ->get();

    return response()->json($services);
})->name('api.departements.services');
