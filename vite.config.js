import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { VitePWA } from 'vite-plugin-pwa';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        VitePWA({
            // Écrit sw.js / manifest.webmanifest directement dans public/ (racine du site)
            // pour que le service worker ait une portée ("scope") sur tout le site,
            // et pas seulement sur public/build/ où atterrissent les assets versionnés.
            outDir: 'public',
            base: '/',
            registerType: 'autoUpdate',
            injectRegister: false, // Laravel/Blade n'est pas un index.html géré par Vite : on enregistre le SW nous-mêmes dans app.js
            manifest: {
                name: 'Portail RH+',
                short_name: 'Portail RH+',
                description: 'Portail RH+ — gestion des ressources humaines',
                lang: 'fr',
                start_url: '/mon-espace',
                scope: '/',
                display: 'standalone',
                background_color: '#F1F3F7',
                theme_color: '#EA580C',
                icons: [
                    { src: 'assets/images/pwa-64x64.png', sizes: '64x64', type: 'image/png' },
                    { src: 'assets/images/pwa-192x192.png', sizes: '192x192', type: 'image/png' },
                    { src: 'assets/images/pwa-512x512.png', sizes: '512x512', type: 'image/png' },
                    { src: 'assets/images/maskable-icon-512x512.png', sizes: '512x512', type: 'image/png', purpose: 'maskable' },
                ],
            },
            workbox: {
                // Les pages sont rendues côté serveur (Blade) et dynamiques :
                // pas de précache d'app-shell, uniquement du cache runtime.
                globDirectory: 'public/build',
                globPatterns: ['assets/**/*.{js,css}'],
                navigateFallback: null,
                runtimeCaching: [
                    {
                        // Pages HTML : réseau en priorité, cache en secours si hors-ligne
                        urlPattern: ({ request }) => request.mode === 'navigate',
                        handler: 'NetworkFirst',
                        options: {
                            cacheName: 'pages-cache',
                            networkTimeoutSeconds: 5,
                            expiration: { maxEntries: 40, maxAgeSeconds: 24 * 60 * 60 },
                        },
                    },
                    {
                        // JS / CSS versionnés : rapides, invalidés naturellement par le hash de build
                        urlPattern: ({ request }) => ['script', 'style', 'worker'].includes(request.destination),
                        handler: 'StaleWhileRevalidate',
                        options: { cacheName: 'assets-cache' },
                    },
                    {
                        // Images
                        urlPattern: ({ request }) => request.destination === 'image',
                        handler: 'CacheFirst',
                        options: {
                            cacheName: 'images-cache',
                            expiration: { maxEntries: 80, maxAgeSeconds: 30 * 24 * 60 * 60 },
                        },
                    },
                ],
            },
        }),
    ],
});
