<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "=== Attribution des rôles aux utilisateurs ===" . PHP_EOL . PHP_EOL;

// Récupère tous les utilisateurs
$users = User::all();

if ($users->isEmpty()) {
    echo "❌ Aucun utilisateur trouvé." . PHP_EOL;
    exit(1);
}

echo "📋 Utilisateurs trouvés: " . $users->count() . PHP_EOL . PHP_EOL;

foreach ($users as $user) {
    echo "👤 Utilisateur: {$user->name} ({$user->email})" . PHP_EOL;

    // Vérifie si l'utilisateur a déjà un rôle
    $currentRoles = $user->roles->pluck('name')->toArray();

    if (empty($currentRoles)) {
        // Si pas de rôle, on attribue Admin au premier utilisateur, Employé aux autres
        if ($user->id === 1) {
            $user->assignRole('Super Admin');
            echo "   ✅ Rôle 'Super Admin' attribué" . PHP_EOL;
        } else {
            $user->assignRole('Admin');
            echo "   ✅ Rôle 'Admin' attribué" . PHP_EOL;
        }
    } else {
        echo "   ℹ️  Rôle(s) existant(s): " . implode(', ', $currentRoles) . PHP_EOL;
    }

    echo PHP_EOL;
}

echo "✅ Attribution des rôles terminée!" . PHP_EOL;
