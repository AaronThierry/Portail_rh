<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\ResetCodeMail;

class PasswordResetController extends Controller
{
    /**
     * Affiche le formulaire de demande de réinitialisation
     */
    public function requestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Génère et envoie un code OTP par email
     */
    public function sendResetCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'L\'adresse e-mail est requise',
            'email.email' => 'L\'adresse e-mail doit être valide',
            'email.exists' => 'Aucun compte n\'est associé à cette adresse e-mail',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Générer un code OTP à 6 chiffres
        $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Récupérer l'utilisateur
        $user = User::where('email', $request->email)->first();

        // Stocker le code dans le cache pour 10 minutes
        $cacheKey = 'password_reset_' . $request->email;
        Cache::put($cacheKey, [
            'code' => $code,
            'email' => $request->email,
            'created_at' => now()
        ], now()->addMinutes(10));

        // Envoyer l'email avec le code
        try {
            Mail::to($request->email)->send(new ResetCodeMail($user, $code));

            // Log pour debug
            \Log::info('Code OTP envoyé', [
                'email' => $request->email,
                'code' => $code // En production, ne pas logger le code
            ]);

            // Rediriger vers la page de vérification du code
            return redirect()->route('password.verify.form', ['email' => $request->email])
                ->with('success', 'Un code de vérification a été envoyé à votre adresse e-mail.');
        } catch (\Exception $e) {
            \Log::error('Erreur envoi email reset password', [
                'email' => $request->email,
                'error' => $e->getMessage()
            ]);

            return back()
                ->withErrors(['email' => 'Erreur lors de l\'envoi de l\'email: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Affiche le formulaire de vérification du code OTP
     */
    public function verifyCodeForm(Request $request)
    {
        $email = $request->get('email');

        // Vérifier que l'email est présent et qu'un code existe
        if (!$email || !Cache::has('password_reset_' . $email)) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Session expirée. Veuillez recommencer.']);
        }

        return view('auth.verify-code', ['email' => $email]);
    }

    /**
     * Vérifie le code OTP saisi
     */
    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'code' => 'required|digits:6',
        ], [
            'email.required' => 'L\'adresse e-mail est requise',
            'code.required' => 'Le code de vérification est requis',
            'code.digits' => 'Le code doit contenir 6 chiffres',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $cacheKey = 'password_reset_' . $request->email;
        $resetData = Cache::get($cacheKey);

        if (!$resetData) {
            return back()
                ->withErrors(['code' => 'Le code a expiré. Veuillez demander un nouveau code.'])
                ->withInput();
        }

        if ($resetData['code'] !== $request->code) {
            return back()
                ->withErrors(['code' => 'Le code de vérification est incorrect.'])
                ->withInput();
        }

        // Code valide, générer un token pour la réinitialisation
        $token = Str::random(64);
        Cache::put('password_reset_token_' . $token, [
            'email' => $request->email,
            'verified' => true
        ], now()->addMinutes(15));

        // Supprimer le code OTP du cache
        Cache::forget($cacheKey);

        // Rediriger vers le formulaire de nouveau mot de passe
        return redirect()->route('password.reset', ['token' => $token, 'email' => $request->email]);
    }

    /**
     * Renvoie un nouveau code OTP
     */
    public function resendCode(Request $request)
    {
        $email = $request->email;

        if (!$email) {
            return response()->json(['success' => false, 'message' => 'Adresse e-mail manquante.'], 400);
        }

        // Générer un nouveau code
        $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Utilisateur introuvable.'], 404);
        }

        // Stocker le nouveau code
        $cacheKey = 'password_reset_' . $email;
        Cache::put($cacheKey, [
            'code' => $code,
            'email' => $email,
            'created_at' => now()
        ], now()->addMinutes(10));

        // Envoyer l'email
        try {
            Mail::to($email)->send(new ResetCodeMail($user, $code));

            \Log::info('Code OTP renvoyé', [
                'email' => $email,
                'code' => $code
            ]);

            return response()->json(['success' => true, 'message' => 'Un nouveau code a été envoyé.']);
        } catch (\Exception $e) {
            \Log::error('Erreur renvoi code OTP', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);

            return response()->json(['success' => false, 'message' => 'Erreur lors de l\'envoi de l\'email.'], 500);
        }
    }

    /**
     * Affiche le formulaire de réinitialisation avec le token
     */
    public function resetForm(Request $request, $token)
    {
        $tokenData = Cache::get('password_reset_token_' . $token);

        if (!$tokenData || !$tokenData['verified']) {
            return redirect()->route('password.request')
                ->withErrors(['token' => 'Le lien de réinitialisation est invalide ou a expiré.']);
        }

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email ?? $tokenData['email']
        ]);
    }

    /**
     * Traite la réinitialisation du mot de passe
     */
    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'token.required' => 'Le token de réinitialisation est requis',
            'email.required' => 'L\'adresse e-mail est requise',
            'email.email' => 'L\'adresse e-mail doit être valide',
            'email.exists' => 'Aucun compte n\'est associé à cette adresse e-mail',
            'password.required' => 'Le mot de passe est requis',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Vérifier le token
        $tokenData = Cache::get('password_reset_token_' . $request->token);

        if (!$tokenData || !$tokenData['verified'] || $tokenData['email'] !== $request->email) {
            return back()
                ->withErrors(['token' => 'Le lien de réinitialisation est invalide ou a expiré.'])
                ->withInput();
        }

        // Réinitialiser le mot de passe
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $user->forceFill([
                'password' => Hash::make($request->password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));

            // Supprimer le token du cache
            Cache::forget('password_reset_token_' . $request->token);

            return redirect()->route('login')->with('success', 'Votre mot de passe a été réinitialisé avec succès. Vous pouvez maintenant vous connecter.');
        }

        return back()
            ->withErrors(['email' => 'Utilisateur introuvable.'])
            ->withInput();
    }
}
