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
            // Code source du SW écrit à la main (resources/sw/push-sw.js) plutôt que généré :
            // nécessaire pour y ajouter les listeners "push"/"notificationclick" (Web Push VAPID).
            strategies: 'injectManifest',
            srcDir: 'resources/sw',
            filename: 'push-sw.js',
            injectManifest: {
                globDirectory: 'public/build',
                globPatterns: ['assets/**/*.{js,css}'],
            },
            manifest: {
                name: 'Portail RH+',
                short_name: 'Portail RH+',
                description: 'Portail RH+ — gestion des ressources humaines',
                lang: 'fr',
                start_url: '/mon-espace',
                scope: '/',
                display: 'standalone',
                background_color: '#F1F3F7',
                theme_color: '#2563EB',
                icons: [
                    { src: '/assets/images/pwa-64x64.png', sizes: '64x64', type: 'image/png' },
                    { src: '/assets/images/pwa-192x192.png', sizes: '192x192', type: 'image/png' },
                    { src: '/assets/images/pwa-512x512.png', sizes: '512x512', type: 'image/png' },
                    { src: '/assets/images/maskable-icon-512x512.png', sizes: '512x512', type: 'image/png', purpose: 'maskable' },
                ],
            },
        }),
    ],
});
