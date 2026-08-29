import { defineConfig, minimal2023Preset } from '@vite-pwa/assets-generator/config';

// Génère toutes les icônes PWA (favicon, apple-touch-icon, pwa-192/512, maskable)
// à partir du logo existant, directement dans public/ (racine servie par Laravel).
export default defineConfig({
    preset: minimal2023Preset,
    images: ['public/assets/images/logo.png'],
});
