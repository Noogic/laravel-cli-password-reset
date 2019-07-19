<?php

namespace Noogic\LaravelCliPasswordReset\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Noogic\LaravelCliPasswordReset\Test\User;

class CliPasswordResetCommand extends Command
{
    protected $signature = 'password:reset';

    protected $description = 'Resets password for one or all users';

    public function handle()
    {
        $this->info('Reset user password to `secret`');

        foreach (User::all() as $user) {
            $user->update(['password' => Hash::make('secret')]);
        }
    }
}
