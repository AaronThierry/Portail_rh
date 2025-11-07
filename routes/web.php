<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\PersonnelController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Routes publiques



// Routes d'authentification (accessible uniquement si non connecté)
Route::middleware('guest')->group(function () {
    Route::get('/connexion', [UserController::class, 'loginform'])->name('login');
    Route::get('/login', [UserController::class, 'loginform'])->name('login.form');
    Route::get('/inscription', [UserController::class, 'signupform'])->name('signup');

    // Routes mot de passe oublié avec OTP
    Route::get('/password/reset', [PasswordResetController::class, 'requestForm'])->name('password.request');
    Route::post('/password/send-code', [PasswordResetController::class, 'sendResetCode'])->name('password.send.code');
    Route::get('/password/verify', [PasswordResetController::class, 'verifyCodeForm'])->name('password.verify.form');
    Route::post('/password/verify', [PasswordResetController::class, 'verifyCode'])->name('password.verify.code');
    Route::post('/password/resend', [PasswordResetController::class, 'resendCode'])->name('password.resend');
    Route::get('/password/reset/{token}', [PasswordResetController::class, 'resetForm'])->name('password.reset');
    Route::post('/password/reset', [PasswordResetController::class, 'reset'])->name('password.update');
});

// Route de traitement du login (accessible même si non connecté)
Route::post('/login', [UserController::class, 'login'])->name('login.submit');

// Routes pour le changement de mot de passe obligatoire (première connexion)
Route::middleware(['auth'])->group(function () {
    Route::get('/password/change-first', [UserController::class, 'showFirstPasswordChange'])->name('password.change-first');
    Route::post('/password/change-first', [UserController::class, 'changeFirstPassword'])->name('password.update-first');
});

// Routes protégées (nécessitent une authentification)
Route::middleware(['auth', 'force.password.change', '2fa'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard', [
            'totalEmployees' => 248,
            'presentToday' => 231,
            'pendingLeaves' => 15,
            'newCandidates' => 42
        ]);
    })->name('dashboard');

    // Profil utilisateur
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [UserController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/avatar', [UserController::class, 'updateAvatar'])->name('profile.avatar');

    // Routes 2FA
    Route::post('/two-factor/enable', [TwoFactorController::class, 'enable'])->name('two-factor.enable');
    Route::post('/two-factor/verify', [TwoFactorController::class, 'verify'])->name('two-factor.verify');
    Route::delete('/two-factor/disable', [TwoFactorController::class, 'disable'])->name('two-factor.disable');

    // Vérification 2FA lors de la connexion
    Route::get('/two-factor/challenge', [TwoFactorController::class, 'showVerify'])->name('two-factor.show');
    Route::post('/two-factor/challenge', [TwoFactorController::class, 'verifyLogin'])->name('two-factor.verify.login');

    // Déconnexion
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout.get');

    // Routes RH (à implémenter)
    Route::prefix('employes')->group(function () {
        Route::get('/', function () {
            return view('dashboard');
        })->name('employes.index');
    });

    // Redirection home vers dashboard
    Route::get('/home', function () {
        return redirect()->route('dashboard');
    })->name('home');

    /**
     * ROUTES PROTÉGÉES PAR PERMISSIONS
     * Ces routes utilisent les middleware Spatie Permission pour contrôler l'accès
     * Format: middleware(['permission:nom-permission'])
     */

    // Gestion des rôles et permissions (Middleware par permission)
    Route::prefix('roles')->name('roles.')->group(function () {
        // Consultation des rôles (permission: view-roles)
        Route::middleware(['permission:view-roles'])->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::get('/statistics', [RoleController::class, 'statistics'])->name('statistics');
            Route::get('/{role}', [RoleController::class, 'show'])->name('show');
        });

        // Création de rôles (permission: create-roles)
        Route::middleware(['permission:create-roles'])->group(function () {
            Route::get('/create', [RoleController::class, 'create'])->name('create');
            Route::post('/', [RoleController::class, 'store'])->name('store');
        });

        // Édition de rôles (permission: edit-roles)
        Route::middleware(['permission:edit-roles'])->group(function () {
            Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit');
            Route::put('/{role}', [RoleController::class, 'update'])->name('update');
        });

        // Gestion des permissions d'un rôle (permission: manage-permissions)
        Route::middleware(['permission:manage-permissions'])->group(function () {
            Route::get('/{role}/permissions', [RoleController::class, 'permissions'])->name('permissions');
            Route::put('/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('permissions.sync');
        });

        // Suppression de rôles (permission: delete-roles)
        Route::middleware(['permission:delete-roles'])->group(function () {
            Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');
        });

        // Attribution de rôles aux utilisateurs (permission: assign-roles)
        Route::middleware(['permission:assign-roles'])->group(function () {
            Route::get('/users/{user}/assign', [RoleController::class, 'assignRoleForm'])->name('assign.form');
            Route::post('/users/{user}/assign', [RoleController::class, 'assignRole'])->name('assign');
        });
    });

    // Gestion des départements (CRUD complet avec permissions)
    Route::prefix('departements')->name('departements.')->group(function () {
        // Consultation (permission: view-departements)
        Route::middleware(['permission:view-departements'])->group(function () {
            Route::get('/', [DepartementController::class, 'index'])->name('index');
        });

        // Création (permission: create-departements)
        Route::middleware(['permission:create-departements'])->group(function () {
            Route::get('/create', [DepartementController::class, 'create'])->name('create');
            Route::post('/', [DepartementController::class, 'store'])->name('store');
        });

        // Édition (permission: edit-departements)
        Route::middleware(['permission:edit-departements'])->group(function () {
            Route::get('/{departement}/edit', [DepartementController::class, 'edit'])->name('edit');
            Route::put('/{departement}', [DepartementController::class, 'update'])->name('update');
        });

        // Consultation détaillée (permission: view-departements)
        Route::middleware(['permission:view-departements'])->group(function () {
            Route::get('/{departement}', [DepartementController::class, 'show'])->name('show');
        });

        // Suppression (permission: delete-departements)
        Route::middleware(['permission:delete-departements'])->group(function () {
            Route::delete('/{departement}', [DepartementController::class, 'destroy'])->name('destroy');
        });
    });

    Route::prefix('postes')->group(function () {
        Route::get('/', function () {
            return view('dashboard');
        })->name('postes.index');
    });

    Route::prefix('conges')->group(function () {
        Route::get('/', function () {
            return view('dashboard');
        })->name('conges.index');
    });

    Route::prefix('paie')->group(function () {
        Route::get('/', function () {
            return view('dashboard');
        })->name('paie.index');
    });

    Route::prefix('rapports')->group(function () {
        Route::get('/', function () {
            return view('dashboard');
        })->name('rapports.index');
    });

    // Gestion des paramètres (CRUD complet)
    Route::prefix('parametres')->name('parametres.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::get('/general', [SettingsController::class, 'general'])->name('general');
        Route::put('/general', [SettingsController::class, 'updateGeneral'])->name('general.update');
        Route::get('/security', [SettingsController::class, 'security'])->name('security');
        Route::put('/security', [SettingsController::class, 'updateSecurity'])->name('security.update');
        Route::get('/notifications', [SettingsController::class, 'notifications'])->name('notifications');
        Route::put('/notifications', [SettingsController::class, 'updateNotifications'])->name('notifications.update');

        // Routes réservées au super admin (vérification dans le contrôleur)
        Route::get('/system', [SettingsController::class, 'system'])->name('system');
        Route::post('/cache/clear', [SettingsController::class, 'clearCache'])->name('cache.clear');

        // ========================================
        // GESTION SÉPARÉE RÔLES & PERMISSIONS
        // ========================================

        // Routes pour les Rôles (Vue séparée)
        Route::get('/roles', [RoleController::class, 'index'])->name('roles');

        // Routes pour les Permissions (Vue séparée)
        Route::middleware(['permission:manage-permissions'])->group(function () {
            Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions');
            Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
            Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
            Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
        });

        // ========================================
        // GESTION UNIFIÉE RÔLES & PERMISSIONS (Alternative)
        // ========================================
        Route::get('/roles-permissions', [RolePermissionController::class, 'index'])->name('roles-permissions');

        // Rôles (unified)
        Route::post('/roles-unified', [RolePermissionController::class, 'storeRole'])->name('roles-unified.store');
        Route::put('/roles-unified/{role}', [RolePermissionController::class, 'updateRole'])->name('roles-unified.update');
        Route::delete('/roles-unified/{role}', [RolePermissionController::class, 'destroyRole'])->name('roles-unified.destroy');
        Route::post('/roles-unified/{role}/permissions', [RolePermissionController::class, 'syncPermissions'])->name('roles-unified.sync-permissions');

        // Permissions (unified)
        Route::post('/permissions-unified', [RolePermissionController::class, 'storePermission'])->name('permissions-unified.store');
        Route::put('/permissions-unified/{permission}', [RolePermissionController::class, 'updatePermission'])->name('permissions-unified.update');
        Route::delete('/permissions-unified/{permission}', [RolePermissionController::class, 'destroyPermission'])->name('permissions-unified.destroy');

        // API
        Route::get('/api/roles/{role}/permissions', [RolePermissionController::class, 'getRolePermissions'])->name('api.role-permissions');
        Route::get('/api/roles', [RolePermissionController::class, 'getAllRoles'])->name('api.roles');
        Route::get('/api/permissions', [RolePermissionController::class, 'getAllPermissions'])->name('api.permissions');
    });

    // Gestion des utilisateurs (CRUD complet)
    Route::prefix('utilisateurs')->name('utilisateurs.')->group(function () {
        // Liste des utilisateurs (permission: view-users)
        Route::middleware(['permission:view-users'])->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
        });

        // Création d'utilisateurs (permission: create-users)
        Route::middleware(['permission:create-users'])->group(function () {
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
        });

        // Édition d'utilisateurs (permission: edit-users)
        Route::middleware(['permission:edit-users'])->group(function () {
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('update');
        });

        // Voir un utilisateur (permission: view-users)
        Route::middleware(['permission:view-users'])->group(function () {
            Route::get('/{user}', [UserController::class, 'show'])->name('show');
        });

        // Suppression d'utilisateurs (permission: delete-users)
        Route::middleware(['permission:delete-users'])->group(function () {
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        });
    });

    // Gestion des entreprises (CRUD complet)
    Route::prefix('entreprises')->name('entreprises.')->group(function () {
        // Liste des entreprises (permission: view-entreprises)
        Route::middleware(['permission:view-entreprises'])->group(function () {
            Route::get('/', [EntrepriseController::class, 'index'])->name('index');
        });

        // Création d'entreprises (permission: create-entreprises)
        Route::middleware(['permission:create-entreprises'])->group(function () {
            Route::get('/create', [EntrepriseController::class, 'create'])->name('create');
            Route::post('/', [EntrepriseController::class, 'store'])->name('store');
        });

        // Édition d'entreprises (permission: edit-entreprises)
        Route::middleware(['permission:edit-entreprises'])->group(function () {
            Route::get('/{entreprise}/edit', [EntrepriseController::class, 'edit'])->name('edit');
            Route::put('/{entreprise}', [EntrepriseController::class, 'update'])->name('update');
            Route::post('/{entreprise}/toggle-status', [EntrepriseController::class, 'toggleStatus'])->name('toggle-status');
        });

        // Voir une entreprise (permission: view-entreprises)
        Route::middleware(['permission:view-entreprises'])->group(function () {
            Route::get('/{entreprise}', [EntrepriseController::class, 'show'])->name('show');
        });

        // Suppression d'entreprises (permission: delete-entreprises)
        Route::middleware(['permission:delete-entreprises'])->group(function () {
            Route::delete('/{entreprise}', [EntrepriseController::class, 'destroy'])->name('destroy');
        });
    });

    // Gestion des services (CRUD complet)
    Route::prefix('services')->name('services.')->group(function () {
        // API pour récupérer les départements d'une entreprise (avant les routes avec paramètres)
        Route::get('/api/departements/{entrepriseId}', [ServiceController::class, 'getDepartementsByEntreprise'])->name('api.departements');

        // Liste des services (permission: view-services)
        Route::middleware(['permission:view-services'])->group(function () {
            Route::get('/', [ServiceController::class, 'index'])->name('index');
        });

        // Création de services (permission: create-services)
        Route::middleware(['permission:create-services'])->group(function () {
            Route::get('/create', [ServiceController::class, 'create'])->name('create');
            Route::post('/', [ServiceController::class, 'store'])->name('store');
        });

        // Édition de services (permission: edit-services)
        Route::middleware(['permission:edit-services'])->group(function () {
            Route::get('/{service}/edit', [ServiceController::class, 'edit'])->name('edit');
            Route::put('/{service}', [ServiceController::class, 'update'])->name('update');
        });

        // Voir un service (permission: view-services)
        Route::middleware(['permission:view-services'])->group(function () {
            Route::get('/{service}', [ServiceController::class, 'show'])->name('show');
        });

        // Suppression de services (permission: delete-services)
        Route::middleware(['permission:delete-services'])->group(function () {
            Route::delete('/{service}', [ServiceController::class, 'destroy'])->name('destroy');
        });
    });

    // Gestion du personnel (CRUD complet)
    Route::prefix('personnels')->name('personnels.')->group(function () {
        // API pour récupérer les services d'un département
        Route::get('/services/{departementId}', [PersonnelController::class, 'getServicesByDepartement'])->name('api.services');

        // Liste du personnel (permission: view-personnel)
        Route::middleware(['permission:view-personnel'])->group(function () {
            Route::get('/', [PersonnelController::class, 'index'])->name('index');
            Route::get('/{personnel}', [PersonnelController::class, 'show'])->name('show');
        });

        // Création de personnel (permission: create-personnel)
        Route::middleware(['permission:create-personnel'])->group(function () {
            Route::post('/', [PersonnelController::class, 'store'])->name('store');
        });

        // Édition de personnel (permission: edit-personnel)
        Route::middleware(['permission:edit-personnel'])->group(function () {
            Route::put('/{personnel}', [PersonnelController::class, 'update'])->name('update');
        });

        // Suppression de personnel (permission: delete-personnel)
        Route::middleware(['permission:delete-personnel'])->group(function () {
            Route::delete('/{personnel}', [PersonnelController::class, 'destroy'])->name('destroy');
        });

        // Assignation et gestion des comptes utilisateurs (permission: assign-user-accounts)
        Route::middleware(['permission:assign-user-accounts'])->group(function () {
            Route::post('/{personnel}/assign-user', [PersonnelController::class, 'assignUser'])->name('assign-user');
            Route::post('/{personnel}/detach-user', [PersonnelController::class, 'detachUser'])->name('detach-user');
        });

        // Export du personnel (permission: export-personnel)
        Route::middleware(['permission:export-personnel'])->group(function () {
            Route::get('/export', [PersonnelController::class, 'export'])->name('export');
        });
    });
});

// Route de fallback - Redirection vers login si non authentifié, sinon dashboard
Route::fallback(function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});