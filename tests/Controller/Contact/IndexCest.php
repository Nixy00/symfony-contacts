<?php

declare(strict_types=1);

namespace App\Tests\Controller\Contact;

use App\Factory\ContactFactory;
use App\Tests\Support\ControllerTester;

final class IndexCest
{
    public function contactListContainsRightNumberOfContacts(ControllerTester $I)
    {
        ContactFactory::createMany(5);

        $I->amOnPage('/contact');
        $I->seeResponseCodeIs(200);
        $I->seeInTitle('Liste des contacts');
        $I->see('Liste des contacts', 'h1');
        $I->seeNumberOfElements('ul li a', 5);
    }

    public function clickingSpecificContactNavigatesToCorrectRoute(ControllerTester $I): void
    {
        $contactJoe = ContactFactory::createOne([
            'firstname' => 'Joe',
            'lastname' => 'Aaaaaaaaaaaaaaa',
        ]);

        ContactFactory::createMany(5);

        $I->amOnPage('/contact');
        $I->click('Aaaaaaaaaaaaaaa, Joe');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentRouteIs('app_contact_id', [
            'id' => $contactJoe->getId(),
        ]);
    }
}
