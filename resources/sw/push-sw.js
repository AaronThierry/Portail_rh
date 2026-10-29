import { precacheAndRoute, cleanupOutdatedCaches } from 'workbox-precaching';
import { registerRoute } from 'workbox-routing';
import { NetworkFirst, StaleWhileRevalidate, CacheFirst } from 'workbox-strategies';
import { ExpirationPlugin } from 'workbox-expiration';

self.addEventListener('message', (event) => {
    if (event.data && event.data.type === 'SKIP_WAITING') self.skipWaiting();
});

precacheAndRoute(self.__WB_MANIFEST);
cleanupOutdatedCaches();

// Pages HTML rendues côté serveur (Blade) : réseau en priorité, cache en secours hors-ligne.
registerRoute(
    ({ request }) => request.mode === 'navigate',
    new NetworkFirst({
        cacheName: 'pages-cache',
        networkTimeoutSeconds: 5,
        plugins: [new ExpirationPlugin({ maxEntries: 40, maxAgeSeconds: 24 * 60 * 60 })],
    })
);

// JS / CSS versionnés : invalidés naturellement par le hash de build.
registerRoute(
    ({ request }) => ['script', 'style', 'worker'].includes(request.destination),
    new StaleWhileRevalidate({ cacheName: 'assets-cache' })
);

// Images
registerRoute(
    ({ request }) => request.destination === 'image',
    new CacheFirst({
        cacheName: 'images-cache',
        plugins: [new ExpirationPlugin({ maxEntries: 80, maxAgeSeconds: 30 * 24 * 60 * 60 })],
    })
);

// ══ Notifications push (Web Push / VAPID) ══
// Nécessaire pour Safari iOS : les push ne sont livrées qu'à une PWA installée
// ("Ajouter à l'écran d'accueil"), via ce service worker — jamais à un onglet classique.
self.addEventListener('push', (event) => {
    var payload = { title: 'Portail RH+', body: '' };
    try {
        if (event.data) payload = event.data.json();
    } catch (e) {
        if (event.data) payload.body = event.data.text();
    }

    var data = payload.data || {};

    event.waitUntil(
        self.registration.showNotification(payload.title || 'Portail RH+', {
            body: payload.body || '',
            icon: '/assets/images/pwa-192x192.png',
            badge: '/assets/images/pwa-64x64.png',
            data: data,
        })
    );
});

self.addEventListener('notificationclick', (event) => {
    event.notification.close();
    var url = event.notification.data && event.notification.data.url ? event.notification.data.url : '/mon-espace';

    event.waitUntil(
        self.clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function (windows) {
            for (var i = 0; i < windows.length; i++) {
                if ('focus' in windows[i]) return windows[i].focus();
            }
            if (self.clients.openWindow) return self.clients.openWindow(url);
        })
    );
});
