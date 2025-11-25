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
        $I->seeNumberOfElements('ul li', 195);
    }
}
