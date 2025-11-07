<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

echo "╔══════════════════════════════════════════════════════════════╗" . PHP_EOL;
echo "║   TEST DES VUES ET ROUTES - SYSTÈME DE PERMISSIONS          ║" . PHP_EOL;
echo "╚══════════════════════════════════════════════════════════════╝" . PHP_EOL . PHP_EOL;

// 1. Vérifier les routes
echo "🔍 VÉRIFICATION DES ROUTES" . PHP_EOL;
echo "══════════════════════════════════════════════════════════════" . PHP_EOL;

$routesToTest = [
    'parametres.roles' => 'GET /parametres/roles',
    'parametres.permissions' => 'GET /parametres/permissions',
    'parametres.roles.permissions' => 'GET /parametres/roles/{role}/permissions',
];

foreach ($routesToTest as $routeName => $routePath) {
    $route = Route::getRoutes()->getByName($routeName);
    if ($route) {
        echo "✅ Route '{$routeName}' existe" . PHP_EOL;
        echo "   URI: " . $route->uri() . PHP_EOL;
        echo "   Action: " . $route->getActionName() . PHP_EOL;
    } else {
        echo "❌ Route '{$routeName}' introuvable" . PHP_EOL;
    }
    echo PHP_EOL;
}

// 2. Vérifier les vues
echo "👁️  VÉRIFICATION DES VUES" . PHP_EOL;
echo "══════════════════════════════════════════════════════════════" . PHP_EOL;

$viewsToTest = [
    'parametres.roles' => 'resources/views/parametres/roles.blade.php',
    'parametres.permissions' => 'resources/views/parametres/permissions.blade.php',
    'roles.permissions' => 'resources/views/roles/permissions.blade.php',
    'roles.index' => 'resources/views/roles/index.blade.php',
    'roles.create' => 'resources/views/roles/create.blade.php',
    'roles.edit' => 'resources/views/roles/edit.blade.php',
];

foreach ($viewsToTest as $viewName => $filePath) {
    if (View::exists($viewName)) {
        $fullPath = resource_path('views/' . str_replace('.', '/', $viewName) . '.blade.php');
        $exists = file_exists($fullPath);
        echo ($exists ? "✅" : "⚠️") . " Vue '{$viewName}' " . ($exists ? "existe" : "enregistrée mais fichier non trouvé") . PHP_EOL;
        if ($exists) {
            $size = filesize($fullPath);
            echo "   Taille: " . number_format($size) . " octets" . PHP_EOL;
            echo "   Chemin: {$filePath}" . PHP_EOL;
        }
    } else {
        echo "❌ Vue '{$viewName}' introuvable" . PHP_EOL;
    }
    echo PHP_EOL;
}

// 3. Vérifier les middlewares sur les routes
echo "🛡️  VÉRIFICATION DES MIDDLEWARES" . PHP_EOL;
echo "══════════════════════════════════════════════════════════════" . PHP_EOL;

$middlewareRoutes = [
    'parametres.roles' => ['web', 'auth'],
    'roles.index' => ['web', 'auth', 'permission:view-roles'],
];

foreach ($middlewareRoutes as $routeName => $expectedMiddleware) {
    $route = Route::getRoutes()->getByName($routeName);
    if ($route) {
        $middleware = $route->middleware();
        echo "📌 Route: {$routeName}" . PHP_EOL;
        echo "   Middlewares: " . implode(', ', $middleware) . PHP_EOL;
    }
    echo PHP_EOL;
}

// 4. Tester un rendu de vue simple (sans données)
echo "🎨 TEST DE RENDU" . PHP_EOL;
echo "══════════════════════════════════════════════════════════════" . PHP_EOL;

try {
    // Test avec des données factices
    $testData = [
        'roles' => collect([
            (object)[
                'id' => 1,
                'name' => 'Test Role',
                'created_at' => now(),
                'permissions_count' => 10,
                'users_count' => 5,
            ]
        ])
    ];

    // Essai de rendu
    $rendered = View::make('parametres.roles', $testData)->render();
    $renderSize = strlen($rendered);

    echo "✅ Vue 'parametres.roles' rendue avec succès" . PHP_EOL;
    echo "   Taille du HTML: " . number_format($renderSize) . " octets" . PHP_EOL;
    echo "   Contient 'Gestion des Rôles': " . (str_contains($rendered, 'Gestion des Rôles') ? 'Oui' : 'Non') . PHP_EOL;
    echo "   Contient 'Test Role': " . (str_contains($rendered, 'Test Role') ? 'Oui' : 'Non') . PHP_EOL;
} catch (\Exception $e) {
    echo "❌ Erreur lors du rendu de la vue" . PHP_EOL;
    echo "   Message: " . $e->getMessage() . PHP_EOL;
    echo "   Fichier: " . $e->getFile() . ":" . $e->getLine() . PHP_EOL;
}

echo PHP_EOL;

// 5. Vérifier le layout parent
echo "📄 VÉRIFICATION DU LAYOUT" . PHP_EOL;
echo "══════════════════════════════════════════════════════════════" . PHP_EOL;

if (View::exists('layouts.app')) {
    echo "✅ Layout 'layouts.app' existe" . PHP_EOL;
    $layoutPath = resource_path('views/layouts/app.blade.php');
    if (file_exists($layoutPath)) {
        $size = filesize($layoutPath);
        echo "   Taille: " . number_format($size) . " octets" . PHP_EOL;
    }
} else {
    echo "❌ Layout 'layouts.app' introuvable" . PHP_EOL;
}

echo PHP_EOL;

// 6. Résumé
echo "📊 RÉSUMÉ" . PHP_EOL;
echo "══════════════════════════════════════════════════════════════" . PHP_EOL;

$totalRoutes = count($routesToTest);
$totalViews = count($viewsToTest);
$existingRoutes = 0;
$existingViews = 0;

foreach ($routesToTest as $routeName => $routePath) {
    if (Route::getRoutes()->getByName($routeName)) {
        $existingRoutes++;
    }
}

foreach ($viewsToTest as $viewName => $filePath) {
    if (View::exists($viewName)) {
        $existingViews++;
    }
}

echo "✅ Routes: {$existingRoutes}/{$totalRoutes}" . PHP_EOL;
echo "✅ Vues: {$existingViews}/{$totalViews}" . PHP_EOL;

if ($existingRoutes === $totalRoutes && $existingViews === $totalViews) {
    echo PHP_EOL;
    echo "╔══════════════════════════════════════════════════════════════╗" . PHP_EOL;
    echo "║          ✅ TOUS LES TESTS ONT RÉUSSI !                     ║" . PHP_EOL;
    echo "╚══════════════════════════════════════════════════════════════╝" . PHP_EOL;
} else {
    echo PHP_EOL;
    echo "╔══════════════════════════════════════════════════════════════╗" . PHP_EOL;
    echo "║       ⚠️  CERTAINS ÉLÉMENTS SONT MANQUANTS                  ║" . PHP_EOL;
    echo "╚══════════════════════════════════════════════════════════════╝" . PHP_EOL;
}
