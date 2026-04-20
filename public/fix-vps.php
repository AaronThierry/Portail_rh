<?php
if (($_GET['t'] ?? '') !== 'rh2026') { http_response_code(403); exit('Forbidden'); }

$base = 'https://raw.githubusercontent.com/AaronThierry/Portail_rh/main/';
$files = [
    'app/Services/BulletinImportService.php',
    'app/Http/Controllers/BulletinImportController.php',
];

$results = [];
foreach ($files as $file) {
    $content = @file_get_contents($base . $file);
    if ($content === false) {
        $results[] = "FAIL: $file";
        continue;
    }
    $dest = __DIR__ . '/../' . $file;
    if (file_put_contents($dest, $content) !== false) {
        $results[] = "OK: $file";
    } else {
        $results[] = "WRITE ERROR: $file";
    }
}

if (function_exists('opcache_reset')) { opcache_reset(); $results[] = "OPcache reset OK"; }

echo implode("\n", $results) . "\n" . date('Y-m-d H:i:s');
