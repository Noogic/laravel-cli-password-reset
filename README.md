# A Laravel command to easily reset user passwords

This Laravel package adds the command `password:reset` to your Laravel artisan commands.

> Due to the common sense, this package is **disabled in _production_ environments**. If you are in a production environment, you should never know any user's password. In case you want to test this command in production, just use an staging enviornment.

## Installation

You can install this package via composer using:
```
composer require noogic/laravel-cli-password-reset
```

The package will automatically register its services provider.


## Configuration

The package comes with its own configuration to locate de _User_ class and define the _default password_.

``` 
'user' => 'App\User',
'password' => 'secret',
```

You can change it by publishing the `config/cli-password-reset.php` config file:
```
php artisan vendor:publish --provider="Noogic\PasswordReset\PasswordResetServiceProvider"
```


## How to use

The **default behaviour** is to reset all User's password to the default password:
```
php artisan password:reset
```

You can **specify the password** without changing the default value:
```
php artisan password:reset --pasword=anotherpassword
```

You can change the password **only to specified users** by passing the ids:
```
php artisan password:reset --id=1 --id=5 --id=12
```

And finally, you can combine the specific password with the specified users
```
php artisan password:reset --password=anotherpassword --id=1 --id=3
```