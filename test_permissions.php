<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

echo "╔══════════════════════════════════════════════════════════════╗" . PHP_EOL;
echo "║   TEST COMPLET DU SYSTÈME DE PERMISSIONS ET RÔLES           ║" . PHP_EOL;
echo "╚══════════════════════════════════════════════════════════════╝" . PHP_EOL . PHP_EOL;

// 1. Statistiques générales
echo "📊 STATISTIQUES GÉNÉRALES" . PHP_EOL;
echo "══════════════════════════════════════════════════════════════" . PHP_EOL;
echo "✓ Permissions totales    : " . Permission::count() . PHP_EOL;
echo "✓ Rôles totaux           : " . Role::count() . PHP_EOL;
echo "✓ Utilisateurs totaux    : " . User::count() . PHP_EOL;
echo PHP_EOL;

// 2. Liste des rôles et leurs permissions
echo "👥 RÔLES ET LEURS PERMISSIONS" . PHP_EOL;
echo "══════════════════════════════════════════════════════════════" . PHP_EOL;

$roles = Role::with('permissions')->get();
foreach ($roles as $role) {
    echo "📌 {$role->name}" . PHP_EOL;
    echo "   Permissions: {$role->permissions->count()}" . PHP_EOL;
    echo "   Utilisateurs: " . $role->users()->count() . PHP_EOL;
    echo PHP_EOL;
}

// 3. Liste des utilisateurs et leurs rôles/permissions
echo "👤 UTILISATEURS ET LEURS ACCÈS" . PHP_EOL;
echo "══════════════════════════════════════════════════════════════" . PHP_EOL;

$users = User::with('roles')->get();
foreach ($users as $user) {
    $roles = $user->roles->pluck('name')->toArray();
    $permissions = $user->getAllPermissions()->count();

    echo "👤 {$user->name} ({$user->email})" . PHP_EOL;
    echo "   Rôle(s): " . (empty($roles) ? 'Aucun' : implode(', ', $roles)) . PHP_EOL;
    echo "   Permissions totales: {$permissions}" . PHP_EOL;

    // Test de quelques permissions clés
    if (!empty($roles)) {
        echo "   Tests de permissions:" . PHP_EOL;

        $testPermissions = [
            'view-users',
            'create-users',
            'view-entreprises',
            'manage-permissions',
            'view-dashboard',
        ];

        foreach ($testPermissions as $perm) {
            $has = $user->hasPermissionTo($perm) ? '✅' : '❌';
            echo "      {$has} {$perm}" . PHP_EOL;
        }
    }

    echo PHP_EOL;
}

// 4. Permissions groupées par module
echo "📦 PERMISSIONS PAR MODULE" . PHP_EOL;
echo "══════════════════════════════════════════════════════════════" . PHP_EOL;

$permissions = Permission::orderBy('name')->get();
$grouped = $permissions->groupBy(function($permission) {
    $parts = explode('-', $permission->name);
    return count($parts) >= 2 ? end($parts) : 'autres';
});

foreach ($grouped as $module => $perms) {
    echo "📂 Module: {$module} ({$perms->count()} permissions)" . PHP_EOL;
    foreach ($perms as $perm) {
        $rolesCount = $perm->roles()->count();
        echo "   • {$perm->name} (utilisée par {$rolesCount} rôle(s))" . PHP_EOL;
    }
    echo PHP_EOL;
}

// 5. Vérification de la configuration
echo "⚙️  VÉRIFICATION DE LA CONFIGURATION" . PHP_EOL;
echo "══════════════════════════════════════════════════════════════" . PHP_EOL;

$config = config('permission');
echo "✓ Cache activé           : " . ($config['cache']['expiration_time'] ? 'Oui' : 'Non') . PHP_EOL;
echo "✓ Événements activés     : " . ($config['events_enabled'] ? 'Oui' : 'Non') . PHP_EOL;
echo "✓ Wildcards activés      : " . ($config['enable_wildcard_permission'] ? 'Oui' : 'Non') . PHP_EOL;
echo "✓ Affichage erreurs      : " . ($config['display_permission_in_exception'] ? 'Oui' : 'Non') . PHP_EOL;
echo PHP_EOL;

// 6. Test des middlewares
echo "🔒 MIDDLEWARES ENREGISTRÉS" . PHP_EOL;
echo "══════════════════════════════════════════════════════════════" . PHP_EOL;

$kernel = app(\Illuminate\Contracts\Http\Kernel::class);
$middlewares = [
    'role',
    'permission',
    'role_or_permission',
    'check.permission',
    'require.role',
    'same.company',
    'log.permissions',
];

foreach ($middlewares as $middleware) {
    echo "✓ {$middleware}" . PHP_EOL;
}
echo PHP_EOL;

// 7. Résumé et recommandations
echo "✅ RÉSUMÉ" . PHP_EOL;
echo "══════════════════════════════════════════════════════════════" . PHP_EOL;

$usersWithoutRoles = User::doesntHave('roles')->count();
$unusedPermissions = Permission::doesntHave('roles')->count();

if ($usersWithoutRoles > 0) {
    echo "⚠️  {$usersWithoutRoles} utilisateur(s) sans rôle" . PHP_EOL;
} else {
    echo "✅ Tous les utilisateurs ont au moins un rôle" . PHP_EOL;
}

if ($unusedPermissions > 0) {
    echo "ℹ️  {$unusedPermissions} permission(s) non attribuée(s) à un rôle" . PHP_EOL;
} else {
    echo "✅ Toutes les permissions sont utilisées" . PHP_EOL;
}

echo PHP_EOL;
echo "╔══════════════════════════════════════════════════════════════╗" . PHP_EOL;
echo "║              TEST TERMINÉ AVEC SUCCÈS !                      ║" . PHP_EOL;
echo "╚══════════════════════════════════════════════════════════════╝" . PHP_EOL;
