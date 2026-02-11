<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\EspaceEmployeController;
use App\Http\Controllers\DashbordController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\DossierAgentController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BulletinPaieController;

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

    // Vérification 2FA lors de la connexion (avant d'accéder à l'espace employé)
    Route::get('/two-factor/challenge', [TwoFactorController::class, 'showVerify'])->name('two-factor.show');
    Route::post('/two-factor/challenge', [TwoFactorController::class, 'verifyLogin'])->name('two-factor.verify.login');

    // Déconnexion globale
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout.get');
});

// ============================================================================
// ESPACE EMPLOYE - Mini-site dédié aux employés
// ============================================================================
Route::middleware(['auth', 'force.password.change', '2fa'])->prefix('mon-espace')->name('espace-employe.')->group(function () {
    // Dashboard employé
    Route::get('/', [EspaceEmployeController::class, 'dashboard'])->name('dashboard');

    // Profil personnel
    Route::get('/profil', [EspaceEmployeController::class, 'profil'])->name('profil');
    Route::put('/profil', [EspaceEmployeController::class, 'updateProfil'])->name('profil.update');
    Route::put('/password', [EspaceEmployeController::class, 'updatePassword'])->name('password.update');

    // Mes documents
    Route::get('/documents', [EspaceEmployeController::class, 'documents'])->name('documents');
    Route::get('/documents/{id}/preview', [EspaceEmployeController::class, 'previewDocument'])->name('documents.preview');
    Route::get('/documents/{id}/download', [EspaceEmployeController::class, 'downloadDocument'])->name('documents.download');

    // Mes bulletins de paie
    Route::get('/bulletins', [EspaceEmployeController::class, 'bulletins'])->name('bulletins');
    Route::get('/bulletins/{bulletin}/preview', [EspaceEmployeController::class, 'previewBulletin'])->name('bulletins.preview');
    Route::get('/bulletins/{bulletin}/download', [EspaceEmployeController::class, 'downloadBulletin'])->name('bulletins.download');

    Route::get('/attestations', [EspaceEmployeController::class, 'attestations'])->name('attestations');

    // Congés et demandes
    Route::get('/conges', [EspaceEmployeController::class, 'conges'])->name('conges');
    Route::post('/conges', [EspaceEmployeController::class, 'storeConge'])->name('conges.store');
    Route::get('/demandes', [EspaceEmployeController::class, 'demandes'])->name('demandes');
    Route::post('/demandes', [EspaceEmployeController::class, 'storeDemande'])->name('demandes.store');

    // Paramètres du compte
    Route::get('/parametres', [EspaceEmployeController::class, 'parametres'])->name('parametres');

    // 2FA
    Route::post('/two-factor/enable', [TwoFactorController::class, 'enable'])->name('two-factor.enable');
    Route::post('/two-factor/verify', [TwoFactorController::class, 'verify'])->name('two-factor.verify');
    Route::delete('/two-factor/disable', [TwoFactorController::class, 'disable'])->name('two-factor.disable');

    // Déconnexion
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout.get');
});

// ============================================================================
// PORTAIL ADMIN - Réservé aux superadmins
// ============================================================================
Route::middleware(['auth', 'force.password.change', '2fa', 'role:Super Admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard admin
    Route::get('/', [DashbordController::class, 'index'])->name('dashboard');

    // Gestion des personnels
    Route::resource('personnels', PersonnelController::class);

    // Gestion des départements (désactivé)
    // Route::resource('departements', DepartementController::class);

    // Gestion des services (désactivé)
    // Route::resource('services', ServiceController::class);

    // Gestion des entreprises
    Route::resource('entreprises', EntrepriseController::class);

    // Gestion des rôles et permissions
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);

    // Gestion des utilisateurs (comptes)
    Route::get('utilisateurs', [UserController::class, 'index'])->name('utilisateurs.index');
    Route::post('utilisateurs', [UserController::class, 'store'])->name('utilisateurs.store');
    Route::get('utilisateurs/{user}', [UserController::class, 'show'])->name('utilisateurs.show');
    Route::get('utilisateurs/{user}/edit', [UserController::class, 'edit'])->name('utilisateurs.edit');
    Route::put('utilisateurs/{user}', [UserController::class, 'update'])->name('utilisateurs.update');
    Route::delete('utilisateurs/{user}', [UserController::class, 'destroy'])->name('utilisateurs.destroy');

    // Gestion des accompagnements collaborateurs (désactivé — controller non implémenté)
    // Route::get('accompagnements', [AccompagnementController::class, 'index'])->name('accompagnements.index');
    // Route::get('accompagnements/create', [AccompagnementController::class, 'create'])->name('accompagnements.create');
    // Route::post('accompagnements', [AccompagnementController::class, 'store'])->name('accompagnements.store');
    // Route::get('accompagnements/{accompagnement}', [AccompagnementController::class, 'show'])->name('accompagnements.show');
    // Route::get('accompagnements/{accompagnement}/edit', [AccompagnementController::class, 'edit'])->name('accompagnements.edit');
    // Route::put('accompagnements/{accompagnement}', [AccompagnementController::class, 'update'])->name('accompagnements.update');
    // Route::delete('accompagnements/{accompagnement}', [AccompagnementController::class, 'destroy'])->name('accompagnements.destroy');
    // Route::post('accompagnements/{accompagnement}/sessions', [AccompagnementController::class, 'storeSession'])->name('accompagnements.sessions.store');
    // Route::get('accompagnements/personnel/{personnel}/info', [AccompagnementController::class, 'getPersonnelInfo'])->name('accompagnements.personnel.info');

    // Liste globale des dossiers agents
    Route::get('dossiers-agents', [DossierAgentController::class, 'index'])->name('dossiers-agents.index');

    // Catégories et alertes dossiers agents
    Route::get('dossier-agent/categories', [DossierAgentController::class, 'categories'])->name('dossier-agent.categories');
    Route::post('dossier-agent/categories', [DossierAgentController::class, 'storeCategorie'])->name('dossier-agent.categories.store');
    Route::post('dossier-agent/categories/init', [DossierAgentController::class, 'initCategories'])->name('dossier-agent.categories.init');
    Route::put('dossier-agent/categories/{categorie}', [DossierAgentController::class, 'updateCategorie'])->name('dossier-agent.categories.update');
    Route::delete('dossier-agent/categories/{categorie}', [DossierAgentController::class, 'destroyCategorie'])->name('dossier-agent.categories.destroy');
    Route::get('dossier-agent/alertes', [DossierAgentController::class, 'alertes'])->name('dossier-agent.alertes');

    // Dossier d'un agent spécifique
    Route::get('dossier-agent/{personnel}', [DossierAgentController::class, 'show'])->name('dossier-agent.show');
    Route::post('dossier-agent/{personnel}', [DossierAgentController::class, 'store'])->name('dossier-agent.store');
    Route::post('dossier-agent/{personnel}/upload-multiple', [DossierAgentController::class, 'uploadMultiple'])->name('dossier-agent.upload-multiple');
    Route::get('dossier-agent/document/{document}/preview', [DossierAgentController::class, 'preview'])->name('dossier-agent.preview');
    Route::get('dossier-agent/document/{document}/download', [DossierAgentController::class, 'download'])->name('dossier-agent.download');
    Route::delete('dossier-agent/document/{document}', [DossierAgentController::class, 'destroy'])->name('dossier-agent.destroy');

    // Paramètres
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');

    // Profil utilisateur
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::delete('profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // 2FA pour admin
    Route::post('two-factor/enable', [TwoFactorController::class, 'enable'])->name('two-factor.enable');
    Route::post('two-factor/verify', [TwoFactorController::class, 'verify'])->name('two-factor.verify');
    Route::delete('two-factor/disable', [TwoFactorController::class, 'disable'])->name('two-factor.disable');

    // Gestion des bulletins de paie
    Route::get('bulletins-paie', [BulletinPaieController::class, 'index'])->name('bulletins-paie.index');
    Route::post('bulletins-paie', [BulletinPaieController::class, 'store'])->name('bulletins-paie.store');
    Route::post('bulletins-paie/bulk', [BulletinPaieController::class, 'storeBulk'])->name('bulletins-paie.store-bulk');
    Route::get('bulletins-paie/export', [BulletinPaieController::class, 'export'])->name('bulletins-paie.export');
    Route::get('bulletins-paie/{bulletin}', [BulletinPaieController::class, 'show'])->name('bulletins-paie.show');
    Route::put('bulletins-paie/{bulletin}', [BulletinPaieController::class, 'update'])->name('bulletins-paie.update');
    Route::delete('bulletins-paie/{bulletin}', [BulletinPaieController::class, 'destroy'])->name('bulletins-paie.destroy');
    Route::get('bulletins-paie/{bulletin}/download', [BulletinPaieController::class, 'download'])->name('bulletins-paie.download');
    Route::get('bulletins-paie/{bulletin}/preview', [BulletinPaieController::class, 'preview'])->name('bulletins-paie.preview');
    Route::post('bulletins-paie/{bulletin}/replace', [BulletinPaieController::class, 'replaceFichier'])->name('bulletins-paie.replace');
});

// Redirection racine selon le rôle
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->hasRole('Super Admin')) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('espace-employe.dashboard');
    }
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    if (Auth::check() && Auth::user()->hasRole('Super Admin')) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('espace-employe.dashboard');
})->name('dashboard')->middleware(['auth']);

Route::get('/home', function () {
    if (Auth::check() && Auth::user()->hasRole('Super Admin')) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('espace-employe.dashboard');
})->name('home')->middleware(['auth']);

// Route de fallback - Redirection selon le rôle
Route::fallback(function () {
    if (Auth::check()) {
        if (Auth::user()->hasRole('Super Admin')) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('espace-employe.dashboard');
    }
    return redirect()->route('login');
});