<?php
if (($_GET['t'] ?? '') !== 'rh2026') { http_response_code(403); exit('Forbidden'); }

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$target = 'mounira.traore@rhplus.site';
$refName = 'Faycal';

// Find reference user roles
$ref = \App\Models\User::where('name', 'like', "%$refName%")->first();
if (!$ref) {
    exit("Utilisateur de référence '$refName' introuvable.");
}
$refRoles = $ref->getRoleNames()->toArray();

// Find target user
$user = \App\Models\User::where('email', $target)->first();
if (!$user) {
    exit("Utilisateur '$target' introuvable.");
}

$before = $user->getRoleNames()->toArray();

// Sync roles
$user->syncRoles($refRoles);

$after = $user->fresh()->getRoleNames()->toArray();

echo "Référence : {$ref->name} ({$ref->email})\n";
echo "Rôles référence : " . implode(', ', $refRoles) . "\n\n";
echo "Cible : {$user->name} ({$user->email})\n";
echo "Avant : " . (implode(', ', $before) ?: '(aucun)') . "\n";
echo "Après : " . (implode(', ', $after) ?: '(aucun)') . "\n";
echo "\nOK — " . date('Y-m-d H:i:s');
