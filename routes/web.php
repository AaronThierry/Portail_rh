<?php

use App\Http\Controllers\DashbordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Routes d'authentification (accessible uniquement si non connecté)
Route::middleware('guest')->group(function () {
    Route::get('/connexion', [UserController::class, 'loginform'])->name('login');
    Route::get('/login', [UserController::class, 'loginform'])->name('login.form');
    Route::get('/inscription', [UserController::class, 'signupform'])->name('signup');
});

// Route de traitement du login (accessible même si non connecté)
Route::post('/login', [UserController::class, 'login'])->name('login.submit');

// Routes protégées (nécessitent une authentification)
Route::middleware(['auth.sanctum'])->group(function () {
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

    // Déconnexion
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout.get');

    // Routes RH (à implémenter)
    Route::prefix('employes')->group(function () {
        Route::get('/', function () {
            return view('dashboard');
        })->name('employes.index');
    });

    Route::prefix('departements')->group(function () {
        Route::get('/', function () {
            return view('dashboard');
        })->name('departements.index');
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

    Route::prefix('parametres')->group(function () {
        Route::get('/', function () {
            return view('dashboard');
        })->name('parametres.index');
    });

    // Gestion des utilisateurs (CRUD complet)
    Route::prefix('utilisateurs')->name('utilisateurs.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/{id}', [UserController::class, 'show'])->name('show');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    });
});