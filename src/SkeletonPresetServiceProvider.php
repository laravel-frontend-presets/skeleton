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
            SkeletonPreset::install();

            $command->info('Skeleton scaffolding installed successfully.');

            if ($command->option('auth')) {
                SkeletonPreset::installAuth();

                $command->info('Skeleton auth scaffolding installed successfully.');
            }

            $command->comment('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
        });
    }
}
