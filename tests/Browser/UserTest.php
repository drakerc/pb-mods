<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;

class UserTest extends DuskTestCase
{
    public function login($email, $password)
    {
        $this->browse(function (Browser $browser) use ($email, $password) {
            $browser->visit('/login')
                ->type('#email-input', $email)
                ->type('#password-input', $password)
                ->press('Submit')
                ->waitFor('#logout-button', 10);
        });
    }

    public function logout()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                ->press('Logout')
                ->waitForText('Email');
        });
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLogin()
    {
        $this->login('gallanonim@anonim.com', 'anonim');
        $this->browse(function (Browser $browser) {
            $browser->assertSee('Welcome, gallanonim!');
        });
    }

    public function testRegistration()
    {
        $this->logout();
        $faker = Faker::create();

        $email = $faker->email;
        $nick = $faker->word . $faker->numberBetween(1000, 100000);
        $password = $faker->password;

        $this->browse(function (Browser $browser) use ($email, $nick, $password) {
            $browser->visit('/register')
                ->assertSee('Email')
                ->type('#email-input', $email)
                ->type('#username-input', $nick)
                ->type('#password-input', $password)
                ->type('#confirmpassword-input', $password)
                ->press('Submit')
                ->waitForText('Nie masz konta?')
                ->assertSee('Nie masz konta?');
        });

        $this->login($email, $password);
        $this->browse(function (Browser $browser) use ($nick) {
            $browser->assertSee('Welcome, ' . $nick . '!');
        });
    }

}
