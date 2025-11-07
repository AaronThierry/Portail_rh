<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Setting;
use App\Models\User;
use App\Models\Entreprise;

class SettingsController extends Controller
{
    /**
     * Affiche la page principale des paramètres
     */
    public function index()
    {
        $user = Auth::user();
        $entreprise = $user->entreprise;

        // Récupérer les paramètres généraux
        $settings = $this->getSettings();

        // Statistiques pour le dashboard des paramètres
        $stats = [
            'total_users' => User::when($user->entreprise_id, function($query) use ($user) {
                return $query->where('entreprise_id', $user->entreprise_id);
            })->count(),
            'total_entreprises' => Entreprise::count(),
            'active_users' => User::where('statut', 'actif')
                ->when($user->entreprise_id, function($query) use ($user) {
                    return $query->where('entreprise_id', $user->entreprise_id);
                })->count(),
        ];

        return view('parametres.index', compact('settings', 'stats', 'entreprise'));
    }

    /**
     * Affiche les paramètres généraux
     */
    public function general()
    {
        $user = Auth::user();
        $entreprise = $user->entreprise;
        $settings = $this->getSettings();

        return view('parametres.general', compact('settings', 'entreprise'));
    }

    /**
     * Met à jour les paramètres généraux
     */
    public function updateGeneral(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'app_name' => 'required|string|max:255',
            'app_description' => 'nullable|string|max:500',
            'timezone' => 'required|string',
            'date_format' => 'required|string',
            'currency' => 'required|string',
            'language' => 'required|string',
        ], [
            'app_name.required' => 'Le nom de l\'application est requis',
            'timezone.required' => 'Le fuseau horaire est requis',
            'date_format.required' => 'Le format de date est requis',
            'currency.required' => 'La devise est requise',
            'language.required' => 'La langue est requise',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Sauvegarder les paramètres
            $user = Auth::user();
            $scope = $user->role === 'super_admin' ? 'global' : 'entreprise_' . $user->entreprise_id;

            foreach ($request->only(['app_name', 'app_description', 'timezone', 'date_format', 'currency', 'language']) as $key => $value) {
                $this->setSetting($key, $value, $scope);
            }

            // Vider le cache des paramètres
            Cache::forget('settings_' . $scope);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Paramètres mis à jour avec succès'
                ], 200);
            }

            return back()->with('success', 'Paramètres mis à jour avec succès');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Erreur lors de la mise à jour des paramètres',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Erreur lors de la mise à jour des paramètres');
        }
    }

    /**
     * Affiche les paramètres de sécurité
     */
    public function security()
    {
        $user = Auth::user();
        $settings = $this->getSettings();

        return view('parametres.security', compact('settings'));
    }

    /**
     * Met à jour les paramètres de sécurité
     */
    public function updateSecurity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'session_lifetime' => 'required|integer|min:1|max:1440',
            'password_expiry_days' => 'required|integer|min:0|max:365',
            'max_login_attempts' => 'required|integer|min:1|max:10',
            'enable_2fa' => 'boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $user = Auth::user();
            $scope = $user->role === 'super_admin' ? 'global' : 'entreprise_' . $user->entreprise_id;

            foreach ($request->only(['session_lifetime', 'password_expiry_days', 'max_login_attempts', 'enable_2fa']) as $key => $value) {
                $this->setSetting($key, $value, $scope);
            }

            Cache::forget('settings_' . $scope);

            return back()->with('success', 'Paramètres de sécurité mis à jour avec succès');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la mise à jour des paramètres de sécurité');
        }
    }

    /**
     * Affiche les paramètres de notifications
     */
    public function notifications()
    {
        $user = Auth::user();
        $settings = $this->getSettings();

        return view('parametres.notifications', compact('settings'));
    }

    /**
     * Met à jour les paramètres de notifications
     */
    public function updateNotifications(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'push_notifications' => 'boolean',
            'notify_user_created' => 'boolean',
            'notify_leave_request' => 'boolean',
            'notify_document_shared' => 'boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $user = Auth::user();
            $scope = $user->role === 'super_admin' ? 'global' : 'entreprise_' . $user->entreprise_id;

            foreach ($request->all() as $key => $value) {
                if ($key !== '_token' && $key !== '_method') {
                    $this->setSetting($key, $value ? '1' : '0', $scope);
                }
            }

            Cache::forget('settings_' . $scope);

            return back()->with('success', 'Paramètres de notifications mis à jour avec succès');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la mise à jour des paramètres de notifications');
        }
    }

    /**
     * Affiche les paramètres système (super admin uniquement)
     */
    public function system()
    {
        if (Auth::user()->role !== 'super_admin') {
            abort(403, 'Accès non autorisé');
        }

        $settings = $this->getSettings('global');

        // Informations système
        $systemInfo = [
            'php_version' => phpversion(),
            'laravel_version' => app()->version(),
            'database' => config('database.default'),
            'cache_driver' => config('cache.default'),
            'queue_driver' => config('queue.default'),
            'mail_driver' => config('mail.default'),
        ];

        return view('parametres.system', compact('settings', 'systemInfo'));
    }

    /**
     * Récupère un paramètre
     */
    private function getSetting($key, $default = null, $scope = null)
    {
        if ($scope === null) {
            $user = Auth::user();
            $scope = $user->role === 'super_admin' ? 'global' : 'entreprise_' . $user->entreprise_id;
        }

        $setting = Setting::where('key', $key)
            ->where('scope', $scope)
            ->first();

        return $setting ? $setting->value : $default;
    }

    /**
     * Définit un paramètre
     */
    private function setSetting($key, $value, $scope = 'global')
    {
        Setting::updateOrCreate(
            ['key' => $key, 'scope' => $scope],
            ['value' => $value]
        );
    }

    /**
     * Récupère tous les paramètres avec cache
     */
    private function getSettings($scope = null)
    {
        if ($scope === null) {
            $user = Auth::user();
            $scope = $user->role === 'super_admin' ? 'global' : 'entreprise_' . $user->entreprise_id;
        }

        return Cache::remember('settings_' . $scope, 3600, function () use ($scope) {
            $settings = Setting::where('scope', $scope)->get()->pluck('value', 'key')->toArray();

            // Valeurs par défaut
            $defaults = [
                'app_name' => config('app.name', 'Portail RH'),
                'app_description' => 'Système de gestion des ressources humaines',
                'timezone' => config('app.timezone', 'UTC'),
                'date_format' => 'd/m/Y',
                'currency' => 'FCFA',
                'language' => 'fr',
                'session_lifetime' => 120,
                'password_expiry_days' => 90,
                'max_login_attempts' => 5,
                'enable_2fa' => false,
                'email_notifications' => true,
                'sms_notifications' => false,
                'push_notifications' => false,
                'notify_user_created' => true,
                'notify_leave_request' => true,
                'notify_document_shared' => true,
            ];

            return array_merge($defaults, $settings);
        });
    }

    /**
     * Vide le cache des paramètres
     */
    public function clearCache()
    {
        if (Auth::user()->role !== 'super_admin') {
            abort(403, 'Accès non autorisé');
        }

        Cache::flush();

        return back()->with('success', 'Cache vidé avec succès');
    }
}
