<?php

namespace App\Tests\Controller\Contact;

use App\Factory\ContactFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;
use Symfony\Component\HttpFoundation\Response;

class UpdateCest
{
    public function formShowsContactDataBeforeUpdating(ControllerTester $I): void
    {
        $adminUser = UserFactory::createOne([
            'roles' => ['ROLE_ADMIN'],
        ]);

        $I->amLoggedInAs($adminUser);

        ContactFactory::createOne([
            'firstname' => 'Homer',
            'lastname' => 'Simpson',
        ]);

        $I->amOnPage('/contact/1/update');

        $I->seeInTitle('Édition de Simpson, Homer');
        $I->see('Édition de Simpson, Homer', 'h1');
    }

    public function accessIsRestrictedToAuthenticatedUsers(ControllerTester $I): void
    {
        $contact = ContactFactory::createOne([
            'firstname' => 'Bart',
            'lastname' => 'Simpson',
        ]);

        $I->amOnPage('/contact/'.$contact->getId().'/update');

        $I->seeCurrentRouteIs('app_login');
    }

    public function accessIsRestrictedToAdminUsers(ControllerTester $I): void
    {
        $contact = ContactFactory::createOne([
            'firstname' => 'Lisa',
            'lastname' => 'Simpson',
        ]);

        $user = UserFactory::createOne([
            'roles' => ['ROLE_USER'],
        ]);

        $I->amLoggedInAs($user);

        $I->amOnPage('/contact/'.$contact->getId().'/update');

        $I->seeResponseCodeIs(Response::HTTP_FORBIDDEN);
    }
}
