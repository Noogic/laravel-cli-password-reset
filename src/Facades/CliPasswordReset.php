<?php

namespace Noogic\PasswordReset\Facades;

use Illuminate\Support\Facades\Facade;

class CliPasswordReset extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cli-password-reset';
    }
}
