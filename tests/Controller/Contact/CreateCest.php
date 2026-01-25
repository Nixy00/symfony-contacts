<?php

namespace App\Tests\Controller\Contact;

use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;

class CreateCest
{
    public function formShowsCreateContactPage(ControllerTester $I): void
    {
        $user = UserFactory::createOne([
            'roles' => ['ROLE_USER'],
        ]);

        $I->amLoggedInAs($user);
        $I->amOnPage('/contact/create');

        $I->seeInTitle("Création d'un nouveau contact");
        $I->see("Création d'un nouveau contact", 'h1');
    }

    public function accessIsRestrictedToAuthenticatedUsers(ControllerTester $I): void
    {
        $I->amOnPage('/contact/create');
        $I->seeCurrentRouteIs('app_login');
    }
}
