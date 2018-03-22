<?php
namespace Jlndk\PolymerWebpackPreset;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Console\PresetCommand;

class PolymerPresetServiceProvider extends ServiceProvider
{
    protected $newRouteMessage = 'Do you want to get your routes automaticly updated for the SPA (recommended)? This will delete all existing routes';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        PresetCommand::macro('polymer', function ($command) {
            PolymerPreset::install(false);

            if ($command->confirm($this->newRouteMessage)) {
                PolymerPreset::updateDefaultRoutes();
            }
            // @TODO: Add instructions for manual altenative to the automatic route replacement

            $command->info('Polymer scaffolding installed successfully.');
            $command->comment('Please run "npm install && bower install && npm run dev" to compile your fresh scaffolding.');
        });

        PresetCommand::macro('polymer-auth', function ($command) {
            PolymerPreset::install(true);

            if ($command->confirm($this->newRouteMessage)) {
                PolymerPreset::updateAuthRoutes();
            }

            $command->info('Polymer scaffolding with Auth views installed successfully.');
            $command->comment('Please run "npm install && bower install && npm run dev" to compile your fresh scaffolding.');
        });
    }
}
