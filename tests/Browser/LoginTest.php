<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends DuskTestCase
{   
    /** Sometimes RefreshDatabase Conflict, It should be commented when goes into deep */
    use RefreshDatabase; 
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testAUserCanLogin()
    {   
        $user = factory(User::class)->create([
            'email' => 'masud@gmail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);

        // dd($user);
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'password')
                    ->press('Login')
                    // ->waitForLocation('/home');
                    ->assertPathIs('/home');
        });
    }
}
