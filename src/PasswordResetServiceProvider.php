<?php

namespace Noogic\PasswordReset;

use Illuminate\Support\ServiceProvider;
use Noogic\PasswordReset\Console\PasswordResetCommand;

class PasswordResetServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                PasswordResetCommand::class
            ]);
        }

        $this->publishes([
            __DIR__.'/../config/cli-password-reset.php' => base_path('config/cli-password-reset.php')
        ], 'config');
    }

    public function register()
    {
        $this->app->bind('cli-password-reset', function () {
            return new PasswordResetCommand;
        });

        $this->mergeConfigFrom(__DIR__.'/../config/cli-password-reset.php', 'cli-password-reset');
    }
}
