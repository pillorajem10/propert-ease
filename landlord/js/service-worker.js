const cacheName = 'propertease';
const filesToCache = [
  '../',
  '../login.html',
  '../dashboard.php',
  '../property-list.php',
  '../add-property.php',
  '../edit-property.php',
  '../tenant-management.php',
  '../profile.php',
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
        return Response.redirect('/login.html', 302);
      }

      return fetch(event.request);
    })()
  );
});