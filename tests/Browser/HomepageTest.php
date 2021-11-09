<?php

namespace Tests\Browser;

use App\Models\Adoption;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\Browser\Pages\HomePage;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class HomepageTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     */

    public function testGetListOfAdoptions()
    {
        User::factory(2)->has(Adoption::factory()->count(2), 'listings')
            ->create();

        $this->browse(function (Browser $browser)
        {
            $browser->visit(new HomePage())->testShowListOfAdoptions();
        });
    }

    public function testGuestRegisterUser()
    {
        $this->browse(function (Browser $browser)
        {
            $browser->visit(new HomePage())->testRegisterUser();
        });

        $createdUser = User::where('email', 'john@doe.com')->first();
        $this->assertNotNull($createdUser, 'Unable to locate the registered user, are you saving the correct details?');
        $this->assertTrue(Hash::check('1234', $createdUser->password),
            'Unable to verify that the user\'s password is equal to the one the user signed up with. ' .
            'Did you remember to hash the password before saving to the database? Passwords should never be stored in clear text. Please check: https://laravel.com/docs/8.x/hashing and https://laravel.com/docs/8.x/helpers#method-bcrypt');
    }

    public function testGuestLoginUser()
    {
        User::factory()->create([
            'email'    => 'john@doe.com',
            'password' => bcrypt('1234'),
        ]);

        $this->browse(function (Browser $browser)
        {
            $browser->visit(new HomePage())->testLoginUser();
        });
    }

    public function testUserIsLoggedIn()
    {
        User::factory(1)->create();

        $this->browse(function (Browser $browser)
        {
            $browser->visit(new HomePage())->testUserIsLoggedIn();
        });
    }

    public function testLogoutCurrentUser()
    {
        User::factory(1)->create();

        $this->browse(function (Browser $browser)
        {
            $browser->visit(new HomePage())->testUserLogout();
        });
    }


    public function testUserCanCreateAdoptionPost()
    {
        User::factory(1)->create();

        $this->browse(function (Browser $browser)
        {
            $browser->visit(new HomePage())->testCreateAdoptionPost();
        });
    }

    public function testGuestCannotCreateAdoptionPost()
    {
        $this->assertGuest();
        $this->get('adoptions/create')
            ->assertRedirect("login");
    }

    public function testAdoptAnotherUsersPet()
    {
        $users = User::factory(2)->has(Adoption::factory()->count(2), 'listings')
            ->create();
        $this->browse(function (Browser $browser) use ($users)
        {
            $browser->visit(new HomePage())->testPerformAdoptOwnPetAndOtherUsersPet($users[0]);
        });

        $this->assertEquals(1, $users[0]->adoptions->count(), 'Expected logged in user to have one adoption, but none was found.');
    }

    public function testGuestsCannotAdoptPets()
    {
        User::factory(2)->has(Adoption::factory()->count(2), 'listings')
            ->create();
        $this->browse(function (Browser $browser)
        {
            $browser->logout();
            $browser->assertGuest();
            $browser->visit('/');
            $browser->assertPresent('div:nth-child(1) > div > div.card-body > .pet-name');
            $browser->click('div:nth-child(1) > div > div.card-body > .pet-show');
            $browser->assertPathIs('/adoptions/1');
            $browser->assertNotPresent('.pet-adopt');
        });
    }

    public function testShowCurrentUserAdoptions()
    {
        User::factory(2)->
        has(Adoption::factory()->count(2), 'listings')
            ->create();
        $first_user_id = User::find(1)->id;
        $third_post    = Adoption::find(3);
        $fourth_post   = Adoption::find(4);

        $third_post->adopted_by  = $first_user_id;
        $fourth_post->adopted_by = $first_user_id;
        $third_post->save();
        $fourth_post->save();

        $this->browse(function (Browser $browser)
        {
            $browser->visit(new HomePage())->ShowCurrentUserAdoptions();
        });
    }
}


