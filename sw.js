var CACHE_NAME = 'tefa-cache-v1';
var urlsToCache = [
    '/assets/css/linearicons.css',
    '/assets/vendors/font-awesome/css/font-awesome.min.css',
    '/assets/css/bootstrap.css',
    '/assets/css/magnific-popup.css',
    '/assets/css/nice-select.css',
    '/assets/css/animate.min.css',
    '/assets/css/owl.carousel.css',
    '/assets/css/owl.theme.default.css',
    '/assets/css/jquery-ui.css',
    '/assets/css/main.css',
    '/assets/vendors/ResponsiveSlides/responsiveslides.css',
    '/assets/vendors/nanogallery/css/nanogallery2.min.css',
    '/assets/vendors/sweet-alert/sweet-alert.min.css',
    '/assets/vendors/datatables/css/dataTables.bootstrap.css',
    '/assets/vendors/summernote/dist/summernote.css',
    '/assets/js/vendor/jquery-2.2.4.min.js',
    '/assets/js/popper.min.js',
    '/assets/js/vendor/bootstrap.min.js',
    '/assets/js/easing.min.js',
    '/assets/js/hoverIntent.js',
    '/assets/js/superfish.min.js',
    '/assets/js/jquery.ajaxchimp.min.js',
    '/assets/js/jquery.magnific-popup.min.js',
    '/assets/js/mn-accordion.js',
    '/assets/js/jquery-ui.js',
    '/assets/js/jquery.nice-select.min.js',
    '/assets/js/owl.carousel.min.js',
    '/assets/js/mail-script.js',
    '/assets/js/main.js',
    '/assets/js/myScript.js',
    '/assets/js/backtop.js',
    '/assets/vendors/ResponsiveSlides/responsiveslides.js',
    '/assets/vendors/nanogallery/jquery.nanogallery2.min.js',
    '/assets/vendors/sweet-alert/sweet-alert.min.js',
    '/assets/vendors/datatables/js/jquery.dataTables.js',
    '/assets/vendors/datatables/js/dataTables.bootstrap.js',
    '/assets/vendors/inputmask/jquery.inputmask.bundle.min.js',
    '/assets/vendors/summernote/dist/summernote.js',
];

self.addEventListener('install', function(event) {
  // Perform install steps
  event.waitUntil(
    caches.open(CACHE_NAME).then(function(cache) {
        console.log('Install ServiceWorker, cache Opened!');
        return cache.addAll(urlsToCache);
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


self.addEventListener('activate', function(event) {
  event.waitUntil(
    caches.keys().then(function(cacheNames) {
      return Promise.all(
         cacheNames.filter(function(cacheNames){
             return cacheNames != CACHE_NAME
         }).map(function(cacheNames){
          return caches.delete(cacheName)
        })
      );
    })
  );
});