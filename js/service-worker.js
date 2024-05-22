const cacheName = 'propertease';
const filesToCache = [
  '../',
  '../login.html',
  '../register.html',
  '../verification.php',
  '../confirmation.html',
  '../terms.html',
  '../index.php',
  '../about.php',
  '../rental-list.php',
  '../property-details.php',
  '../payment-management.php',
  '../gcash.php',
  '../contact.php',
  '../account.php',
  '../privacy-policy.php',
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
        return Response.redirect('/index.php', 302);
      }

      return fetch(event.request);
    })()
  );
});