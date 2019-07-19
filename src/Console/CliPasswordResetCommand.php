<?php

namespace Noogic\LaravelCliPasswordReset\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CliPasswordResetCommand extends Command
{
    protected $signature = 'password:reset {--id=*} {--password=}';
    protected $description = 'Resets password for one or all users';

    protected $userClass;
    protected $defaultPassword;

    public function __construct()
    {
        parent::__construct();

        $this->userClass = config('cli-password-reset.user');
        $this->defaultPassword = config('cli-password-reset.password');
    }

    public function handle()
    {
        $id = $this->option('id');
        $password = $this->option('password') ?: $this->defaultPassword;

        if (! $id) {
            return $this->handleAllUsers($password);
        }

        $userIds = is_array($id) ? $id : [$id];

        foreach ($userIds as $id) {
            $user = $this->userClass::findOrFail((int) $id);
            $user->update(['password' => Hash::make($password)]);
        }
    }

    protected function handleAllUsers($password)
    {
        $users = $this->userClass::all();
        foreach ($users as $user) {
            $user->update(['password' => Hash::make($password)]);
        }
    }
}
