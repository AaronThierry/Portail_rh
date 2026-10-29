<?php

namespace App\Http\Controllers;

use App\Models\WebPushSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WebPushSubscriptionController extends Controller
{
    /**
     * Enregistre (ou réassigne) un abonnement Web Push pour l'utilisateur connecté.
     * Appelé par le navigateur juste après l'autorisation de notification.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'endpoint' => 'required|string',
            'keys.p256dh' => 'required|string',
            'keys.auth' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Erreur de validation', 'errors' => $validator->errors()], 422);
        }

        WebPushSubscription::updateOrCreate(
            ['endpoint_hash' => hash('sha256', $request->endpoint)],
            [
                'user_id' => Auth::id(),
                'endpoint' => $request->endpoint,
                'p256dh' => $request->input('keys.p256dh'),
                'auth' => $request->input('keys.auth'),
            ]
        );

        return response()->json(['success' => true]);
    }

    /**
     * Retire un abonnement (désactivation des notifications depuis ce navigateur).
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), ['endpoint' => 'required|string']);
        if ($validator->fails()) {
            return response()->json(['message' => 'Erreur de validation'], 422);
        }

        WebPushSubscription::where('user_id', Auth::id())
            ->where('endpoint_hash', hash('sha256', $request->endpoint))
            ->delete();

        return response()->json(['success' => true]);
    }
}
