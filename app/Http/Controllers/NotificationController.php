<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Retourne les notifications non lues en JSON
     */
    public function index()
    {
        $user = Auth::user();

        $notifications = $user->unreadNotifications()
            ->take(10)
            ->get()
            ->map(function ($notification) {
                $data = $notification->data;
                $type = $data['type'] ?? 'info';

                // Lien contextuel selon le type
                $link = null;
                if (in_array($type, ['requete', 'nouvelle_requete']) && isset($data['requete_id'])) {
                    $link = route('admin.admin-requetes.show', $data['requete_id']);
                } elseif ($type === 'reponse_requete' && isset($data['requete_id'])) {
                    $link = route('admin.requetes.show', $data['requete_id']);
                }

                return [
                    'id' => $notification->id,
                    'type' => $type,
                    'message' => $data['message'] ?? '',
                    'conge_id' => $data['conge_id'] ?? null,
                    'employe' => $data['employe'] ?? null,
                    'date_debut' => $data['date_debut'] ?? null,
                    'date_fin' => $data['date_fin'] ?? null,
                    'status' => $data['status'] ?? null,
                    // Champs requête
                    'requete_id' => $data['requete_id'] ?? null,
                    'sujet' => $data['sujet'] ?? null,
                    'link' => $link,
                    'created_at' => $notification->created_at->diffForHumans(),
                    'created_at_raw' => $notification->created_at->toISOString(),
                ];
            });

        $count = $user->unreadNotifications()->count();

        return response()->json([
            'notifications' => $notifications,
            'count' => $count,
        ]);
    }

    /**
     * Marquer une notification comme lue
     */
    public function markAsRead($id)
    {
        $user = Auth::user();
        $user->notifications()->where('id', $id)->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    /**
     * Marquer toutes les notifications comme lues
     */
    public function markAllAsRead()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();

        return response()->json(['success' => true]);
    }
}
