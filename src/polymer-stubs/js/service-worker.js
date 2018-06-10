importScripts('./dist/workbox-sw.prod.js');

// Create Workbox service worker instance
const workboxSW = new WorkboxSW({
    clientsClaim: true
});

// Placeholder array which is populated automatically by workboxBuild.injectManifest()
workboxSW.precache([]);

let staleableContent = [
    '/manifest.json',
    '/favicon.ico',
    /\.(js|css)$/
];

//register all the staleableContent
staleableContent.forEach(item => {
    workboxSW.router.registerRoute(item, workboxSW.strategies.staleWhileRevalidate());
});

workboxSW.router.registerRoute(/^(?!.*(js|css)).*$/, workboxSW.strategies.networkFirst());
