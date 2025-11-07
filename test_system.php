<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

echo "╔══════════════════════════════════════════════════════════════╗\n";
echo "║           TEST DU SYSTÈME DE RÔLES ET PERMISSIONS            ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n\n";

// Test 1: Vérifier les statistiques
echo "📊 STATISTIQUES GÉNÉRALES\n";
echo "══════════════════════════════════════════════════════════════\n";
echo "Permissions : " . Permission::count() . "\n";
echo "Rôles       : " . Role::count() . "\n";
echo "Utilisateurs: " . User::count() . "\n\n";

// Test 2: Vérifier l'admin
echo "👤 VÉRIFICATION DE L'ADMINISTRATEUR\n";
echo "══════════════════════════════════════════════════════════════\n";
$admin = User::where('email', 'admin@portail-rh.com')->first();
if ($admin) {
    echo "✓ Admin trouvé    : " . $admin->name . "\n";
    echo "✓ Email           : " . $admin->email . "\n";
    echo "✓ Rôles           : " . $admin->getRoleNames()->implode(', ') . "\n";
    echo "✓ Super Admin     : " . ($admin->hasRole('super_admin') ? 'OUI' : 'NON') . "\n";
    echo "✓ Nb permissions  : " . $admin->getAllPermissions()->count() . "\n";
} else {
    echo "✗ Admin non trouvé\n";
}

echo "\n";

// Test 3: Lister les rôles
echo "🎭 LISTE DES RÔLES\n";
echo "══════════════════════════════════════════════════════════════\n";
$roles = Role::withCount(['permissions', 'users'])->get();
foreach ($roles as $role) {
    echo "• " . $role->name . "\n";
    echo "  - Permissions: " . $role->permissions_count . "\n";
    echo "  - Utilisateurs: " . $role->users_count . "\n";
}

echo "\n";

// Test 4: Vérifier quelques permissions clés
echo "🔑 PERMISSIONS CLÉS\n";
echo "══════════════════════════════════════════════════════════════\n";
$keyPermissions = [
    'view-users',
    'create-users',
    'view-roles',
    'manage-permissions',
    'view-entreprises'
];

foreach ($keyPermissions as $permName) {
    $perm = Permission::where('name', $permName)->first();
    if ($perm) {
        $rolesWithPerm = $perm->roles()->pluck('name')->implode(', ');
        echo "✓ $permName : attribuée à [$rolesWithPerm]\n";
    } else {
        echo "✗ $permName : NON TROUVÉE\n";
    }
}

echo "\n";

// Test 5: Tester les permissions de l'admin
if ($admin) {
    echo "🧪 TEST DES PERMISSIONS DE L'ADMIN\n";
    echo "══════════════════════════════════════════════════════════════\n";
    $testPermissions = [
        'view-users' => 'Voir les utilisateurs',
        'create-users' => 'Créer des utilisateurs',
        'view-roles' => 'Voir les rôles',
        'manage-permissions' => 'Gérer les permissions',
        'view-entreprises' => 'Voir les entreprises'
    ];

    foreach ($testPermissions as $perm => $label) {
        $hasPermission = $admin->can($perm);
        echo ($hasPermission ? "✓" : "✗") . " $label: " . ($hasPermission ? "OUI" : "NON") . "\n";
    }
}

echo "\n";
echo "╔══════════════════════════════════════════════════════════════╗\n";
echo "║                    TESTS TERMINÉS                            ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n";
