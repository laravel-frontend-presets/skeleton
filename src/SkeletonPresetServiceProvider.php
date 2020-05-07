<?php
namespace LaravelFrontendPresets\SkeletonPreset;

use Illuminate\Support\ServiceProvider;
use Laravel\Ui\UiCommand;

class SkeletonPresetServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        UiCommand::macro('skeleton', function ($command) {
            SkeletonPreset::install(false);
            $command->info('Skeleton scaffolding installed successfully.');
            $command->comment('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
        });

        UiCommand::macro('skeleton-auth', function ($command) { //optional
            SkeletonPreset::install(true);
            $command->info('Skeleton scaffolding with Auth views installed successfully.');
            $command->comment('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
        });
    }
}
