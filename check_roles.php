<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$users = App\Models\User::with('roles')->get();

echo "📊 STATUT DES RÔLES ET PERMISSIONS\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

foreach ($users as $user) {
    echo "👤 {$user->name} ({$user->email})\n";
    echo "   Rôles: ";
    if ($user->roles->count() > 0) {
        echo $user->roles->pluck('name')->join(', ');
    } else {
        echo "❌ AUCUN RÔLE";
    }
    echo "\n";
    echo "   Permissions: " . $user->getAllPermissions()->count() . " permissions\n";
    echo "\n";
}

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
