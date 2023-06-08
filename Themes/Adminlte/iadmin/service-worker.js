importScripts("precache-manifest.ba992108eca419f5565286fb2af3a54a.js", "https://storage.googleapis.com/workbox-cdn/releases/4.3.1/workbox-sw.js");

/*
 * This file (which will be your service worker)
 * is picked up by the build system if BOTH conditions are met:
 *  - You are building for production
 *  - quasar.conf > pwa > workboxPluginMode is set to "InjectManifest"
 */

/* global workbox */
if (workbox) {
  workbox.precaching.precache(self.__precacheManifest)

  var baseUrl = self.location.hostname

  // Set a name for the current cache
  var shellCacheName = 'app_cache';
  var filesToCache = []

  // Default files to always cache
  self.__precacheManifest.forEach(file => {
    filesToCache.push(file.url)
  })


  self.__precacheManifest = [].concat(self.__precacheManifest || []);

  // Listen to installation event
  self.addEventListener('install', function (event) {
    event.waitUntil(caches.open(shellCacheName).then(function (cache) {
        // Important to `return` the promise here to have `skipWaiting()`
        // fire after the cache has been updated.
        return cache.addAll(filesToCache);
      })
    );
    self.skipWaiting();

  });

  self.addEventListener('activate', function (e) {

    e.waitUntil(
      // Get all cache containers
      caches.keys().then(function (keyList) {
        return Promise.all(keyList.map(function (key) {
          // Check and remove invalid cache containers
          if (key !== shellCacheName) {

            return caches.delete(key);
          }
        }));
      })
    )

    // Enforce immediate scope control
    return self.clients.claim();
  });

  self.addEventListener('message', event => {
    if (event.data.msg === 'clearCache') {

      event.waitUntil(
        // Get all cache containers
        caches.keys().then(function (keyList) {
          return Promise.all(keyList.map(function (key) {
            return caches.delete(key);

          }));
        })
      )
      event.waitUntil(
        caches.open(shellCacheName).then(function (cache) {
          // Important to `return` the promise here to have `skipWaiting()`
          // fire after the cache has been updated.
          return cache.addAll(filesToCache);
        })
      )

    }
  });


  //Network falling back to the cache

  self.addEventListener('fetch', function (event) {
    var requestUrl = event.request.url
    console.log('>>[SERVICE-WORKER] Resgistered BASE_URL: ', baseUrl)
    if (requestUrl.startsWith(baseUrl))
      if (event.request.clone().method === 'GET') {
        event.respondWith(
          fetch(event.request)
            .then(response => {
              //console.warn("fetch SW: ", response)
              //Make copy/clone of response
              const resClone = response.clone();

              caches  //Open cache
                .open(shellCacheName)
                .then(cache => {
                  cache.put(event.request, resClone)
                })
              return response;
            }).catch(err => caches.match(event.request).then(res => res))
        );
      }
  });

  /*
 self.addEventListener('fetch', function(event) {
	 event.respondWith(
			 return cache.match(event.request).then(function(response) {
				 var fetchPromise = fetch(event.request).then(function(networkResponse) {
					 cache.put(event.request, networkResponse.clone());
					 return networkResponse;
				 })
				 return response || fetchPromise;
			 })

	 );
 });
*/
  /*
		let refreshing;
		// The event listener that is fired when the service worker updates
		// Here we reload the page
		self.addEventListener('controllerchange', function () {
			if (refreshing) return;
			refreshing = true;
		});

		*/
  //Cache falling back to the network
  /*
  self.addEventListener('fetch', function(e) {

    e.respondWith(
      caches.match(e.request).then(function(response) {
        return response || fetch(e.request);
      })
    );
  });
  */
}

