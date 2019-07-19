<?php

namespace Noogic\LaravelCliPasswordReset;

use Illuminate\Support\ServiceProvider;
use Noogic\LaravelCliPasswordReset\Console\CliPasswordResetCommand;

class LaravelCliPasswordResetServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CliPasswordResetCommand::class
            ]);
        }

        $this->publishes([
            __DIR__.'/../config/cli-password-reset.php' => base_path('config/cli-password-reset.php')
        ], 'config');
    }

    public function register()
    {
        $this->app->bind('cli-password-reset', function () {
            return null;
        });

        $this->mergeConfigFrom(__DIR__.'/../config/cli-password-reset.php', 'cli-password-reset');
    }
}
