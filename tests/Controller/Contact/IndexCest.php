<?php

declare(strict_types=1);

namespace App\Tests\Controller\Contact;

use App\Tests\Support\ControllerTester;

final class IndexCest
{
    public function contactListContainsRightNumberOfContacts(ControllerTester $I)
    {
        $I->amOnPage('/contact');
        $I->seeResponseCodeIs(200);
        $I->seeInTitle('Liste des contacts');
        $I->see('Liste des contacts', 'h1');
        $I->seeNumberOfElements('ul li a', 195);
    }

    public function clickingFirstContactNavigatesToCorrectRoute(ControllerTester $I)
    {
        $I->amOnPage('/contact');
        $I->click('ul > li > a');
        $I->seeCurrentRouteIs('app_contact_id');
    }
}
