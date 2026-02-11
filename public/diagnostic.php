<?php
/**
 * Diagnostic Portail RH+ - A supprimer apres utilisation
 * Acces: https://votre-domaine.com/diagnostic.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Diagnostic Portail RH+</h1><pre>";

// 1. PHP Version
echo "== PHP ==\n";
echo "Version: " . PHP_VERSION . "\n";
echo "Extensions: " . (extension_loaded('pdo_mysql') ? 'pdo_mysql OK' : 'pdo_mysql MANQUANT') . "\n";
echo "Extensions: " . (extension_loaded('mbstring') ? 'mbstring OK' : 'mbstring MANQUANT') . "\n";
echo "Extensions: " . (extension_loaded('openssl') ? 'openssl OK' : 'openssl MANQUANT') . "\n";
echo "Extensions: " . (extension_loaded('tokenizer') ? 'tokenizer OK' : 'tokenizer MANQUANT') . "\n\n";

// 2. Fichiers critiques
echo "== FICHIERS ==\n";
$root = dirname(__DIR__);
$files = [
    '.env' => $root . '/.env',
    'vendor/autoload.php' => $root . '/vendor/autoload.php',
    'bootstrap/cache/' => $root . '/bootstrap/cache',
    'storage/logs/' => $root . '/storage/logs',
    'storage/framework/sessions/' => $root . '/storage/framework/sessions',
    'storage/framework/views/' => $root . '/storage/framework/views',
    'storage/framework/cache/' => $root . '/storage/framework/cache',
    'public/build/manifest.json' => __DIR__ . '/build/manifest.json',
    'public/build/assets/' => __DIR__ . '/build/assets',
    'public/storage (symlink)' => __DIR__ . '/storage',
    'public/hot (NE DOIT PAS EXISTER)' => __DIR__ . '/hot',
];

foreach ($files as $label => $path) {
    if ($label === 'public/hot (NE DOIT PAS EXISTER)') {
        echo $label . ": " . (file_exists($path) ? "EXISTE -> PROBLEME! Supprimez-le!" : "OK (absent)") . "\n";
    } else {
        $exists = file_exists($path);
        $writable = $exists && is_writable($path);
        echo $label . ": " . ($exists ? "OK" : "MANQUANT!") . ($exists && !$writable ? " (NON ECRIVABLE!)" : "") . "\n";
    }
}

// 3. .env contenu (masque)
echo "\n== ENV ==\n";
$envPath = $root . '/.env';
if (file_exists($envPath)) {
    $env = file_get_contents($envPath);
    preg_match('/APP_ENV=(.*)/', $env, $m); echo "APP_ENV=" . trim($m[1] ?? 'NON DEFINI') . "\n";
    preg_match('/APP_DEBUG=(.*)/', $env, $m); echo "APP_DEBUG=" . trim($m[1] ?? 'NON DEFINI') . "\n";
    preg_match('/APP_URL=(.*)/', $env, $m); echo "APP_URL=" . trim($m[1] ?? 'NON DEFINI') . "\n";
    preg_match('/APP_KEY=(.*)/', $env, $m); echo "APP_KEY=" . (empty(trim($m[1] ?? '')) ? 'VIDE -> CRITIQUE!' : 'OK (defini)') . "\n";
    preg_match('/DB_CONNECTION=(.*)/', $env, $m); echo "DB_CONNECTION=" . trim($m[1] ?? 'NON DEFINI') . "\n";
    preg_match('/DB_HOST=(.*)/', $env, $m); echo "DB_HOST=" . trim($m[1] ?? 'NON DEFINI') . "\n";
    preg_match('/DB_DATABASE=(.*)/', $env, $m); echo "DB_DATABASE=" . trim($m[1] ?? 'NON DEFINI') . "\n";
    preg_match('/DB_USERNAME=(.*)/', $env, $m); echo "DB_USERNAME=" . trim($m[1] ?? 'NON DEFINI') . "\n";
} else {
    echo "FICHIER .env MANQUANT -> CRITIQUE!\n";
}

// 4. Test connexion DB
echo "\n== BASE DE DONNEES ==\n";
if (file_exists($envPath)) {
    preg_match('/DB_HOST=(.*)/', $env, $host);
    preg_match('/DB_PORT=(.*)/', $env, $port);
    preg_match('/DB_DATABASE=(.*)/', $env, $db);
    preg_match('/DB_USERNAME=(.*)/', $env, $user);
    preg_match('/DB_PASSWORD=(.*)/', $env, $pass);

    $h = trim($host[1] ?? '127.0.0.1');
    $p = trim($port[1] ?? '3306');
    $d = trim($db[1] ?? '');
    $u = trim($user[1] ?? '');
    $pw = trim($pass[1] ?? '');

    try {
        $pdo = new PDO("mysql:host=$h;port=$p;dbname=$d", $u, $pw);
        echo "Connexion: OK\n";

        // Check tables
        $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        echo "Tables: " . count($tables) . " trouvees\n";

        $required = ['users', 'roles', 'permissions', 'model_has_roles', 'model_has_permissions', 'role_has_permissions', 'personnels', 'migrations'];
        foreach ($required as $table) {
            echo "  - $table: " . (in_array($table, $tables) ? 'OK' : 'MANQUANTE!') . "\n";
        }

        // Check Super Admin role
        $stmt = $pdo->query("SELECT COUNT(*) FROM roles WHERE name = 'Super Admin'");
        $count = $stmt->fetchColumn();
        echo "\nRole 'Super Admin': " . ($count > 0 ? 'OK' : 'MANQUANT! -> Run: php artisan db:seed --class=RolesAndPermissionsSeeder --force') . "\n";

        // Check Super Admin user
        $stmt = $pdo->query("SELECT u.id, u.email, u.status, GROUP_CONCAT(r.name) as roles FROM users u LEFT JOIN model_has_roles mhr ON u.id = mhr.model_id LEFT JOIN roles r ON mhr.role_id = r.id GROUP BY u.id, u.email, u.status LIMIT 10");
        echo "\nUtilisateurs:\n";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "  - {$row['email']} | status: {$row['status']} | roles: " . ($row['roles'] ?: 'AUCUN ROLE!') . "\n";
        }

    } catch (PDOException $e) {
        echo "ERREUR CONNEXION: " . $e->getMessage() . "\n";
    }
}

// 5. Permissions
echo "\n== PERMISSIONS FICHIERS ==\n";
$dirs = ['storage', 'storage/logs', 'storage/framework', 'bootstrap/cache'];
foreach ($dirs as $dir) {
    $full = $root . '/' . $dir;
    if (is_dir($full)) {
        echo "$dir: " . (is_writable($full) ? 'OK (ecrivable)' : 'NON ECRIVABLE -> chmod -R 775 ' . $dir) . "\n";
    } else {
        echo "$dir: DOSSIER MANQUANT!\n";
    }
}

// 6. Laravel boot test
echo "\n== TEST LARAVEL ==\n";
try {
    require $root . '/vendor/autoload.php';
    $app = require_once $root . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    echo "Laravel boot: OK\n";

    // Test route
    $request = Illuminate\Http\Request::create('/admin', 'GET');
    $response = $kernel->handle($request);
    echo "Route /admin: HTTP " . $response->getStatusCode() . "\n";

    if ($response->getStatusCode() >= 400 && $response->getStatusCode() !== 302) {
        echo "CONTENU ERREUR:\n";
        echo substr(strip_tags($response->getContent()), 0, 1000) . "\n";
    }

} catch (Throwable $e) {
    echo "ERREUR LARAVEL: " . $e->getMessage() . "\n";
    echo "Fichier: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n</pre>";
echo "<p style='color:red;font-weight:bold'>SUPPRIMEZ CE FICHIER APRES UTILISATION: rm public/diagnostic.php</p>";
