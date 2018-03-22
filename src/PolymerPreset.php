<?php
namespace Jlndk\PolymerWebpackPreset;

use Artisan;
use Illuminate\Support\Arr;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\Presets\Preset;

class PolymerPreset extends Preset
{
    /**
     * Install the preset.
     *
     * @return void
     */
    public static function install($withAuth = false)
    {
        static::updatePackages($withAuth);
        static::updateSass();
        static::updateBootstrapping();
        static::updateDefaultViews();

        if ($withAuth) {
            static::addAuthViews();
        }

        static::removeNodeModules();
    }

    /**
     * Update the frontend dependencies.
     *
     * @return void
     */
    protected static function updatePackages($withAuth = false)
    {
        static::updateNodePackages();
        static::updateBowerPackages();

        //Move webpack files
        if($withAuth) {
            copy(__DIR__.'/polymer-stubs/webpack.auth.config.js', base_path('webpack.config.js'));
        } else {
            copy(__DIR__.'/polymer-stubs/webpack.config.js', base_path('webpack.config.js'));
        }
    }

    /**
     * Update the "package.json" file.
     *
     * @return void
     */
    protected static function updateNodePackages()
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }
        $packages = json_decode(file_get_contents(base_path('package.json')), true);
        $packages['devDependencies'] = static::updateNodePackageArray(
            $packages['devDependencies']
        );
        ksort($packages['devDependencies']);

        $packages['scripts'] = [
            'dev'               => 'npm run build',
            'build'             => 'webpack --progress --colors',
            'build-min'         => 'npm run build -- -p',
            'watch'             => 'webpack --watch --progress --colors',
            'watch-min'         => 'npm run watch -- -p',
            'watch-poll'        => 'npm run watch -- --watch-poll',
            'watch-poll-min'    => 'npm run watch-poll -- -p',
            'graph'             => 'webpack --profile --json > graph.json',
        ];

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    /**
     * Update the given package array.
     *
     * @param  array  $packages
     * @return array
     */
    protected static function updateNodePackageArray(array $packages)
    {
        // Packages to add to the package.json
        $packagesToAdd = [
            'webpack' => '^3.6.0',
            'polymer-webpack-loader'=> '^2.0.0',
            'babel-loader' => '^7.1.2',
            'workbox-webpack-plugin' => '^2.0.3',
            'copy-webpack-plugin' => '^4.0.1',
            'babel-core' => '^6.26.0',
            'babel-preset-env' => '^1.6.0',
            'babel-plugin-syntax-dynamic-import' => '^6.18.0',
        ];

        // Packages to remove from the package.json
        $packagesToRemove = [
            'jquery',
            'bootstrap-sass',
            'bootstrap',
            'laravel-mix',
            'vue'
        ];

        return $packagesToAdd + Arr::except($packages, $packagesToRemove);
    }

    /**
     * Update the "bower.json" file.
     *
     * @return void
     */
    protected static function updateBowerPackages()
    {
        copy(__DIR__.'/polymer-stubs/bower.json', base_path('bower.json'));
    }

    /**
     * Update the Sass files for the application.
     *
     * @return void
     */
    protected static function updateSass()
    {
        // Clean up all the files in the sass folder
        tap(new Filesystem, function ($filesystem) {
            if ($filesystem->exists(resource_path('assets/sass'))) {
                $filesystem->cleanDirectory(resource_path('assets/sass'));
            }
        });
    }

    /**
     * Update the bootstrapping files.
     *
     * @return void
     */
    protected static function updateBootstrapping()
    {
        tap(new Filesystem, function ($filesystem) {
            if ($filesystem->exists(resource_path('assets/js'))) {
                $filesystem->deleteDirectory(resource_path('assets/js'));
            }

            if ($filesystem->exists(resource_path('assets/elements'))) {
                $filesystem->deleteDirectory(resource_path('assets/elements'));
            }

            $filesystem->copyDirectory(__DIR__.'/polymer-stubs/elements/my', resource_path('assets/elements/my'));
            $filesystem->copyDirectory(__DIR__.'/polymer-stubs/elements/shared', resource_path('assets/elements/shared'));
            $filesystem->copyDirectory(__DIR__.'/polymer-stubs/js', resource_path('assets/js'));
        });
    }

    /**
     * Update the default views.
     *
     * @return void
     */
    protected static function updateDefaultViews()
    {
        tap(new Filesystem, function ($filesystem) {
            // Remove default welcome page
            if ($filesystem->exists(resource_path('views/welcome.blade.php'))) {
                $filesystem->delete(resource_path('views/welcome.blade.php'));
            }

            // Copy new one from the stubs folder
            $filesystem->copy(__DIR__.'/polymer-stubs/views/app.blade.php', resource_path('views/app.blade.php'));
        });
    }

    /**
     * Update the authentication views.
     *
     * @return void
     */
    protected static function addAuthViews()
    {
        tap(new Filesystem, function ($filesystem) {
            // Add App controller
            $filesystem->copy(__DIR__.'/polymer-stubs/Controllers/AppController.php', app_path('Http/Controllers/AppController.php'));
            //Add authentication app controller
            $filesystem->copy(__DIR__.'/polymer-stubs/Controllers/AuthAppController.php', app_path('Http/Controllers/Auth/AppController.php'));

            $filesystem->copyDirectory(__DIR__.'/polymer-stubs/elements/auth', resource_path('assets/elements/auth'));
        });
    }

    /**
     * Update routes for the SPA without authentication.
     *
     * @return void
     */
    public static function updateDefaultRoutes()
    {
        tap(new Filesystem, function ($filesystem) {
            // Update routes
            if ($filesystem->exists(base_path('routes/web.php'))) {
                $filesystem->delete(base_path('routes/web.php'));
            }

            $filesystem->copy(__DIR__.'/polymer-stubs/routes/web.php', base_path('routes/web.php'));
        });
    }

    /**
     * Update routes for the SPA with authentication.
     *
     * @return void
     */
    public static function updateAuthRoutes()
    {
        tap(new Filesystem, function ($filesystem) {
            // Update routes
            if ($filesystem->exists(base_path('routes/web.php'))) {
                $filesystem->delete(base_path('routes/web.php'));
            }

            $filesystem->copy(__DIR__.'/polymer-stubs/routes/web-auth.php', base_path('routes/web.php'));
        });
    }
}
