importScripts('/cache-polyfill.js');

self.addEventListener('install', function(e) {
    e.waitUntil(
        caches.open('ngpictures').then(function(cache) {
            return cache.addAll([
                '/assets/css/style.css',
                '/assets/js/turbolinks.js',
                '/assets/js/jquery.min.js',
                '/assets/js/app/materialize.js',
                '/assets/js/app/activingScript.js',
                '/assets/js/app/app.ajax.js',
                '/assets/js/app/app.js',
            ]);
        })
    );
});

self.addEventListener('fetch', function(event) {
    event.respondWith(
        caches.match(event.request).then(function(response) {
            return response || fetch(event.request);
        })
    );
});