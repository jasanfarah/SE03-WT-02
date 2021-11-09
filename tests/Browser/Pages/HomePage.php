<?php


namespace Tests\Browser\Pages;

use App\Models\User;
use App\Models\Adoption;
use Illuminate\Support\Facades\Auth;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;
use phpDocumentor\Reflection\DocBlock\Description;

class HomePage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param Browser $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@element' => '.',
        ];
    }

    public function testShowListOfAdoptions(Browser $browser)
    {
        $browser->loginAs(User::find(1));
        $browser->visit('/');
        $browser->assertSeeIn('div:nth-child(1) > div > div.card-body > .pet-name', Adoption::find(1)->name);
        $browser->assertSeeIn('div:nth-child(2) > div > div.card-body > .pet-name', Adoption::find(2)->name);
        $browser->assertSeeIn('div:nth-child(3) > div > div.card-body > .pet-name', Adoption::find(3)->name);
        $browser->assertSeeIn('div:nth-child(4) > div > div.card-body > .pet-name', Adoption::find(4)->name);
        $browser->assertPresent('div:nth-child(1) > div > div.card-body > .pet-description');
        $browser->assertPresent('div:nth-child(2) > div > div.card-body > .pet-description');
        $browser->assertPresent('div:nth-child(3) > div > div.card-body > .pet-description');
        $browser->assertPresent('div:nth-child(4) > div > div.card-body > .pet-description');
    }

    public function testRegisterUser(Browser $browser){
        $browser->visit('');
        $browser->assertPresent('.register-link');
        $browser->click('.register-link');
        $browser->assertPathIs('/register');
        $browser->assertPresent('.name');
        $browser->assertPresent('.email');
        $browser->assertPresent('input[type=password].password');
        $browser->assertPresent('input[type=password].password-confirmation');
        $browser->type('.name', 'John Doe');
        $browser->type('.email', 'john@doe.com');
        $browser->type('.password', '1234');
        $browser->type('.password-confirmation', '1234');
        $browser->assertPresent('.register-submit');
        $browser->click('.register-submit');
        $browser->assertPathIs('/');
        $browser->assertAuthenticated();
        $browser->logout();
    }

    public function testLoginUser(Browser $browser)
    {
        $browser->visit('/');
        $browser->assertPresent('.login-link');
        $browser->click('.login-link');
        $browser->assertPathIs('/login');
        $browser->assertPresent('.email');
        $browser->assertPresent('input[type=password].password');
        $browser->type('.email', 'john@doe.com');
        $browser->type('.password', '1234');
        $browser->assertPresent('.login-submit');
        $browser->click('.login-submit');
        $browser->assertPathIs('/');
        $browser->assertAuthenticated();
    }
    public function testUserIsLoggedIn(Browser $browser)
    {
        $browser->loginAs(User::find(1));
        $browser->visit('/');
        $browser->assertPresent('.user-name');
        $browser->assertSeeIn('.user-name', User::find(1)->name);

    }

    public function testUserLogout(Browser $browser)
    {
        $browser->loginAs(User::find(1));
        $browser->visit('/');
        $browser->assertSeeIn('.user-name', User::find(1)->name);
        $browser->assertPresent('.logout-link');
        $browser->click('.logout-link');
        $browser->assertPathIs('/');
        $browser->assertPresent('.register-link');
        $browser->assertPresent('.login-link');
        $browser->assertGuest();
    }



    public function testCreateAdoptionPost(Browser $browser)
    {
        $browser->loginAs(User::find(1));
        $browser->visit('/');
        $browser->assertPresent('.adoption-create');
        $browser->click('.adoption-create');
        $browser->assertPathIs('/adoptions/create');
        $browser->assertPresent('.pet-name');
        $browser->assertPresent('.pet-description');
        $browser->assertPresent('.pet-image');
        $browser->type('.pet-name','Oliver');
        $browser->type('.pet-description', 'A beautiful cat');
        $browser->assertPresent('.adoption-submit');
        $browser->click('.adoption-submit');
        $browser->assertPathIs('/');
        $browser->assertSee('Post for Oliver created successfully');
        $browser->assertSeeIn('.pet-name', 'Oliver');
        $browser->assertSeeIn('.pet-description', 'A beautiful cat');

    }

    public function testPerformAdoptOwnPetAndOtherUsersPet(Browser $browser, $user)
    {
        $browser->loginAs($user);
        $browser->visit('/');
        // Check Own Pet --> "Adopt Now" not present
        $browser->assertPresent('div:nth-child(1) > div > div.card-body > .pet-name');
        $browser->click('div:nth-child(1) > div > div.card-body > .pet-show');
        $browser->assertPathIs('/adoptions/1');
        $browser->assertPresent('.pet-name');
        $browser->assertPresent('.pet-description');
        $browser->assertSeeIn('.pet-name', Adoption::find(1)->name);
        $browser->assertSeeIn('.pet-description', Adoption::find(1)->description);
        $browser->assertNotPresent('.pet-adopt');
        $browser->back();
        // Check Other User Adoption Post + Adopt
        $browser->assertPresent('div:nth-child(3) > div > div.card-body > .pet-name');
        $browser->click('div:nth-child(3) > div > div.card-body > .pet-show');
        $browser->assertPathIs('/adoptions/3');
        $browser->assertSeeIn('.pet-name', Adoption::find(3)->name);
        $browser->assertSeeIn('.pet-description', Adoption::find(3)->description);
        $browser->assertPresent('.pet-adopt');
        $browser->click('.pet-adopt');
        $browser->assertPathIs('/');
        $browser->assertSee("Pet ". Adoption::find(3)->name ." adopted successfully");
    }

    public function ShowCurrentUserAdoptions(Browser $browser){
        $browser->loginAs(User::find(1));
        $browser->visit('/');
        $browser->assertPresent('.adoption-mine');
        $browser->click('.adoption-mine');
        $browser->assertPathIs('/adoptions/mine');
        $browser->assertDontSee(Adoption::find(1)->name);
        $browser->assertDontSee(Adoption::find(2)->name);
        $browser->assertSee(Adoption::find(3)->name);
        $browser->assertSee(Adoption::find(4)->name);
        $browser->visit('/adoptions/3');
        $browser->assertNotPresent('.pet-adopt');
        $browser->visit('/adoptions/4');
        $browser->assertNotPresent('.pet-adopt');

    }
}


