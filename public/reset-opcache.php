<?php
if (($_GET['t'] ?? '') !== 'rh2026') { http_response_code(403); exit('Forbidden'); }
if (function_exists('opcache_reset')) { opcache_reset(); }
echo 'OPcache FPM reset OK — ' . date('Y-m-d H:i:s');
