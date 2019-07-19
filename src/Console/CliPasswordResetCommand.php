<?php

namespace Noogic\LaravelCliPasswordReset\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CliPasswordResetCommand extends Command
{
    protected $signature = 'password:reset {--id=*}';
    protected $description = 'Resets password for one or all users';
    protected $userClass;

    public function __construct()
    {
        parent::__construct();
        $this->userClass = config('cli-password-reset.user');
    }

    public function handle()
    {
        $id = (int) $this->option('id');

        if (! $id) {
            return $this->handleAllUsers();
        }

        $user = $this->userClass::findOrFail($id);
        $user->update(['password' => Hash::make('secret')]);
    }

    protected function handleAllUsers()
    {
        $users = $this->userClass::all();
        foreach ($users as $user) {
            $user->update(['password' => Hash::make('secret')]);
        }
    }
}
