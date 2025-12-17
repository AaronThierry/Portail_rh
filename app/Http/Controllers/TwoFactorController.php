<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class TwoFactorController extends Controller
{
    /**
     * Afficher la page de profil avec les options 2FA
     */
    public function showProfile()
    {
        $user = auth()->user();
        return view('profile', compact('user'));
    }

    /**
     * Activer le 2FA pour l'utilisateur
     */
    public function enable(Request $request)
    {
        $user = auth()->user();

        // Générer un secret Google 2FA
        $google2fa = new Google2FA();
        $secret = $google2fa->generateSecretKey();

        // Sauvegarder le secret mais ne pas activer le 2FA tout de suite
        $user->google2fa_secret = $secret;
        $user->save();

        // Générer le QR code
        $qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );

        // Créer le QR code SVG
        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrCodeSvg = $writer->writeString($qrCodeUrl);

        return view('auth.two-factor-setup', [
            'qrCodeSvg' => $qrCodeSvg,
            'secret' => $secret
        ]);
    }

    /**
     * Vérifier le code 2FA et activer la fonctionnalité
     */
    public function verify(Request $request)
    {
        $request->validate([
            'one_time_password' => 'required|string|size:6'
        ]);

        $user = auth()->user();
        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->one_time_password);

        if ($valid) {
            $user->google2fa_enabled = true;
            $user->google2fa_verified_at = now();
            $user->save();

            // Rediriger selon le rôle
            if ($user->hasRole('Super Admin')) {
                return redirect()->route('admin.profile.index')->with('success', 'Authentification à deux facteurs activée avec succès!');
            }

            return redirect()->route('espace-employe.parametres')->with('success', 'Authentification à deux facteurs activée avec succès!');
        }

        return back()->with('error', 'Code de vérification invalide. Veuillez réessayer.');
    }

    /**
     * Désactiver le 2FA
     */
    public function disable()
    {
        $user = auth()->user();

        // Désactiver le 2FA
        $user->google2fa_enabled = false;
        $user->google2fa_secret = null;
        $user->google2fa_verified_at = null;
        $user->save();

        // Rediriger selon le rôle
        if ($user->hasRole('Super Admin')) {
            return redirect()->route('admin.profile.index')->with('success', 'Authentification à deux facteurs désactivée.');
        }

        return redirect()->route('espace-employe.parametres')->with('success', 'Authentification à deux facteurs désactivée.');
    }

    /**
     * Afficher la page de vérification 2FA lors de la connexion
     */
    public function showVerify()
    {
        return view('auth.two-factor-challenge');
    }

    /**
     * Vérifier le code 2FA lors de la connexion
     */
    public function verifyLogin(Request $request)
    {
        $request->validate([
            'one_time_password' => 'required|string|size:6'
        ]);

        $user = auth()->user();

        if (!$user || !$user->google2fa_enabled) {
            return redirect()->route('login')->with('error', 'Session expirée.');
        }

        $google2fa = new Google2FA();
        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->one_time_password);

        if ($valid) {
            session(['2fa_verified' => true]);

            // Rediriger selon le rôle
            if ($user->hasRole('Super Admin')) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('espace-employe.dashboard');
        }

        return back()->with('error', 'Code de vérification invalide.');
    }
}
