const cacheName = 'propertease-admin';
const filesToCache = [
  '../',
  '../login.html',
  '../dashboard.php',
  '../property-management.php',
  '../history-logs.php',
  '../transaction-logs.php',
  '../manifest.json',
  '../img/startup-logo.png',
];

self.addEventListener('install', (e) => {
  e.waitUntil(
    caches.open(cacheName).then((cache) => {
      return cache.addAll(filesToCache);
    })
  );
});

self.addEventListener('fetch', (event) => {
  event.respondWith(
    (async function () {
      const response = await caches.match(event.request);
      if (response) {
        return response;
      }

      if (new URL(event.request.url).pathname === '/') {
        return Response.redirect('/admin/login.html', 302);
      }

      return fetch(event.request);
    })()
  );
});