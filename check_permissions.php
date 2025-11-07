<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Vérification des permissions ===\n\n";

// 1. Vérifier si la permission 'create-users' existe
echo "1. Permission 'create-users':\n";
$permission = Spatie\Permission\Models\Permission::where('name', 'create-users')->first();
if ($permission) {
    echo "   ✅ Existe (ID: {$permission->id})\n\n";
} else {
    echo "   ❌ N'existe pas\n\n";
}

// 2. Vérifier quels rôles ont cette permission
echo "2. Rôles ayant la permission 'create-users':\n";
$roles = Spatie\Permission\Models\Role::whereHas('permissions', function($q) {
    $q->where('name', 'create-users');
})->get();

foreach ($roles as $role) {
    echo "   ✅ {$role->name} (ID: {$role->id})\n";
}

if ($roles->isEmpty()) {
    echo "   ⚠️ Aucun rôle n'a cette permission\n";
}

echo "\n";

// 3. Lister tous les rôles
echo "3. Tous les rôles disponibles:\n";
$allRoles = Spatie\Permission\Models\Role::all();
foreach ($allRoles as $role) {
    $permCount = $role->permissions->count();
    echo "   - {$role->name} (ID: {$role->id}) - {$permCount} permissions\n";
}

echo "\n";

// 4. Vérifier les utilisateurs
echo "4. Vérification des utilisateurs:\n";
$users = App\Models\User::all();
foreach ($users as $user) {
    echo "   User: {$user->name} (Email: {$user->email})\n";
    echo "     Rôles: " . $user->roles->pluck('name')->implode(', ') . "\n";
    echo "     A 'create-users': " . ($user->can('create-users') ? '✅ OUI' : '❌ NON') . "\n";
    echo "\n";
}
