<?php

namespace App\Http\Controllers;

use App\Models\DeviceToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DeviceTokenController extends Controller
{
    /**
     * Enregistre (ou réassigne) le jeton FCM de cet appareil pour l'utilisateur connecté.
     * Appelé par l'app mobile juste après la connexion.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string|max:512',
            'platform' => 'nullable|string|in:android,ios',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Erreur de validation', 'errors' => $validator->errors()], 422);
        }

        DeviceToken::updateOrCreate(
            ['token' => $request->token],
            ['user_id' => Auth::id(), 'platform' => $request->platform ?? 'android']
        );

        return response()->json(['success' => true]);
    }

    /**
     * Retire le jeton de cet appareil (déconnexion) pour ne plus recevoir de push dessus.
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), ['token' => 'required|string']);
        if ($validator->fails()) {
            return response()->json(['message' => 'Erreur de validation'], 422);
        }

        DeviceToken::where('user_id', Auth::id())->where('token', $request->token)->delete();

        return response()->json(['success' => true]);
    }
}
