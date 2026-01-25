<?php

namespace App\Tests\Controller\Contact;

use App\Factory\ContactFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;
use Symfony\Component\HttpFoundation\Response;

class DeleteCest
{
    public function formShowsContactDataBeforeDeleting(ControllerTester $I): void
    {
        $adminUser = UserFactory::createOne([
            'roles' => ['ROLE_ADMIN'],
        ]);

        $I->amLoggedInAs($adminUser);

        ContactFactory::createOne([
            'firstname' => 'Homer',
            'lastname' => 'Simpson',
        ]);

        $I->amOnPage('/contact/1/delete');

        $I->seeInTitle('Suppression de Simpson, Homer');
        $I->see('Suppression de Simpson, Homer', 'h1');
    }

    public function accessIsRestrictedToAuthenticatedUsers(ControllerTester $I): void
    {
        $contact = ContactFactory::createOne([
            'firstname' => 'Bart',
            'lastname' => 'Simpson',
        ]);

        $I->amOnPage('/contact/'.$contact->getId().'/delete');

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

        $I->amOnPage('/contact/'.$contact->getId().'/delete');

        $I->seeResponseCodeIs(Response::HTTP_FORBIDDEN);
    }
}
