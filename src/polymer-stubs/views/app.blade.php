<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1, initial-scale=1, user-scalable=yes">

    <title>My App</title>
    <meta name="description" content="My App description">

    <base href="/">

    <link rel="icon" href="favicon.png">

    <!-- See https://goo.gl/OOhYW5 -->
    <link rel="manifest" href="manifest.json">

    <!-- See https://goo.gl/qRE0vM -->
    <meta name="theme-color" content="#3f51b5">

    <!-- Add to homescreen for Chrome on Android. Fallback for manifest.json -->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="My App">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="My App">

    <!-- Homescreen icons -->
    <link rel="apple-touch-icon" href="images/manifest/icon-48x48.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/manifest/icon-72x72.png">
    <link rel="apple-touch-icon" sizes="96x96" href="images/manifest/icon-96x96.png">
    <link rel="apple-touch-icon" sizes="144x144" href="images/manifest/icon-144x144.png">
    <link rel="apple-touch-icon" sizes="192x192" href="images/manifest/icon-192x192.png">

    <!-- Tile icon for Windows 8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="images/manifest/icon-144x144.png">
    <meta name="msapplication-TileColor" content="#3f51b5">
    <meta name="msapplication-tap-highlight" content="no">

    <noscript class="lazyload">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet">
    </noscript>

    <script>
        // Register the base URL
        const baseUrl = document.querySelector('base').href;

        // Load and register pre-caching Service Worker
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register(baseUrl + 'service-worker.js');
            });
        }
    </script>
    <script>
        function addLazyScript(path, defer = false) {
            var refScript = document.getElementsByTagName('script')[0];
            var script = document.createElement('script');
            script.src = path;
            script.defer = defer;
            refScript.parentNode.insertBefore(script, refScript);
        }

        function lazyLoadStyles() {
            const lazyloads = document.querySelectorAll('noscript.lazyload');

            // This container is the HTML parser
            const container = document.createElement('div');

            Array.from(lazyloads).forEach(lazyload => {
                const parent = lazyload.parentNode;

                container.innerHTML = lazyload.textContent;

                Array.from(container.children)
                .forEach(n =>
                    parent.insertBefore(n, lazyload)
                );
            });
        }
    </script>
    <script>
        window.addEventListener('load', function() {
            addLazyScript('dist/{{$app_name}}.bundle.js', true);
            lazyLoadStyles();
        });
    </script>
    @if(isset($config) && is_array($config))
    <script>
        window.App = {!!json_encode($config)!!}
    </script>
    @endif

    <!-- Load webcomponents-loader.js to check and load any polyfills your browser needs -->
    <script src="dist/bower_components/webcomponentsjs/webcomponents-loader.js"></script>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Source Sans Pro', sans-serif;
            margin: 0;
            line-height: 1.5;
            min-height: 100vh;
            background-color: #eeeeee;
        }
    </style>
</head>

<body>
    <{{$app_name}}-app></{{$app_name}}-app>
    <noscript>
      Please enable JavaScript to view this website.
    </noscript>
</body>

</html>
