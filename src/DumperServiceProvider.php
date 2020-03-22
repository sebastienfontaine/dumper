<?php

namespace SebastienFontaine\Dumper;

use Illuminate\Support\ServiceProvider;
use SebastienFontaine\Dumper\Events\DumperEventHandler;

class DumperServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('dumper.enabled') === false) {
            return;
        }

        $this->registerPublishing();

        $this->app['events']->subscribe(DumperEventHandler::class);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/dumper.php', 'dumper'
        );

        $this->commands([
            Console\DumperPublishCommand::class,
            Console\DumperBackupCommand::class,
        ]);
    }

    private function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/dumper.php' => config_path('dumper.php'),
            ], 'dumper-config');
        }
    }
}
