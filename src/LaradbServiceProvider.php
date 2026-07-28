<?php

namespace Laradb;

use Illuminate\Support\ServiceProvider;
use Laradb\Commands\BackupCommand;
use Laradb\Commands\RestoreCommand;

class LaradbServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                BackupCommand::class,
                RestoreCommand::class,
            ]);
        }
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        
    }
}
