importScripts('/cache-polyfill.js');

self.addEventListener('install', function(e) {
    e.waitUntil(
        caches.open('ngpictures').then(function(cache) {
            return cache.addAll([
                '/assets/css/style.css',
                '/assets/fonts/ngpictures-icons.css',
                '/assets/icons/*',
                '/assets/roboto/*',
                '/assets/js/turbolinks.js',
                '/assets/js/jquery.min.js',
                '/assets/js/app/materialize.js',
                '/assets/js/app/app.init.js',
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