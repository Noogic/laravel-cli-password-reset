<?php

namespace Noogic\PasswordReset\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class PasswordResetCommand extends Command
{
    protected $signature = 'password:reset {--id=*} {--password=}';
    protected $description = 'Resets password for one, many or all users';

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
        if (config('app.env') === 'production') {
            return $this->error('Can\'t reset passwords in production');
        }

        $id = $this->option('id');
        $password = $this->option('password') ?: $this->defaultPassword;

        if (! $password) {
            return $this->error('Password can\'t be empty');
        }

        if (! $id) {
            return $this->handleAllUsers($password);
        }

        $userIds = is_array($id) ? $id : [$id];

        foreach ($userIds as $id) {
            $user = $this->userClass::find((int) $id);
            if (! $user) {
                $this->error("User $id not found");
                continue;
            }

            $user->update(['password' => Hash::make($password)]);
        }

        $this->info('Passwords have been reset');
    }

    protected function handleAllUsers($password)
    {
        $users = $this->userClass::all();
        foreach ($users as $user) {
            $user->update(['password' => Hash::make($password)]);
        }

        $this->info('All passwords have been reset');
    }
}
