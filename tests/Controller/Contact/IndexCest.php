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

    public function clickingSpecificContactNavigatesToCorrectRoute(ControllerTester $I)
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

    public function contactsAreWellSorted(ControllerTester $I): void
    {
        ContactFactory::createSequence([
            ['lastName' => 'Zola',     'firstName' => 'Anne'],
            ['lastName' => 'Dupont',   'firstName' => 'Claire'],
            ['lastName' => 'Martin',   'firstName' => 'Benoit'],
            ['lastName' => 'Dupont',   'firstName' => 'Alain'],
            ['lastName' => 'Bernard',  'firstName' => 'David'],
        ]);

        $I->amOnPage('/contact');
        $contactTexts = $I->grabMultiple('ul li a');

        $displayedLastNames = [];
        $displayedFirstNames = [];

        foreach ($contactTexts as $text) {
            [$lastName, $firstName] = array_map('trim', explode(',', $text));
            $displayedLastNames[] = $lastName;
            $displayedFirstNames[] = $firstName;
        }

        $expectedLastNames = ['Bernard', 'Dupont', 'Dupont', 'Martin', 'Zola'];
        $expectedFirstNames = ['David', 'Alain', 'Claire', 'Benoit', 'Anne'];

        $I->assertEquals($expectedLastNames, $displayedLastNames);
        $I->assertEquals($expectedFirstNames, $displayedFirstNames);
    }
}
