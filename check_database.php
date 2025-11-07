<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Permission;

echo "UTILISATEURS EXISTANTS:\n";
echo "══════════════════════════════════════════════════════════════\n";
$users = User::all();
foreach ($users as $user) {
    echo "• " . $user->name . " (" . $user->email . ")\n";
    echo "  Rôles: " . $user->getRoleNames()->implode(', ') . "\n";
}

echo "\n\nPERMISSIONS EXISTANTES (10 premières):\n";
echo "══════════════════════════════════════════════════════════════\n";
$permissions = Permission::orderBy('name')->limit(20)->get();
foreach ($permissions as $perm) {
    echo "• " . $perm->name . "\n";
}
