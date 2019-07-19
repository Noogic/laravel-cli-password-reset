<?php

namespace Noogic\LaravelCliPasswordReset\Test;

use Illuminate\Support\Facades\Hash;

class PasswordResetTest extends TestBase
{
    /** @test */
    public function it_can_reset_all_passwords()
    {
        User::create(['name' => 'Adam', 'password' => Hash::make(rand(0, 100))]);
        User::create(['name' => 'Mike', 'password' => Hash::make(rand(0, 100))]);

        foreach (User::all() as $user) {
            $this->assertFalse(Hash::check('secret', $user->password));
        }

        $this->artisan('password:reset');

        $user->refresh();
        $this->assertTrue(Hash::check('secret', $user->password));

        $this->assertTrue(true);
    }
}
