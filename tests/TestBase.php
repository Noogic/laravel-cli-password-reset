<?php

namespace Noogic\LaravelCliPasswordReset\Test;

use CreateUsersTable;
use Illuminate\Support\Facades\Config;
use Noogic\LaravelCliPasswordReset\LaravelCliPasswordResetServiceProvider;
use Noogic\LaravelCliPasswordsReset\Facades\CliPasswordReset;
use Orchestra\Testbench\TestCase;

class TestBase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            LaravelCliPasswordResetServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'CliPasswordReset' => CliPasswordReset::class
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        include_once __DIR__.'/../database/migrations/create_users_table.php.stub';

        (new CreateUsersTable)->up();

        Config::set('cli-password-reset.user', User::class);
    }
}
