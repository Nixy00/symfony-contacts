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
        $I->seeNumberOfElements('ul.contacts li a', 5);
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
        $contactTexts = $I->grabMultiple('ul.contacts li a');

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

    public function searchFormCanBeFilledAndSent(ControllerTester $I): void
    {
        $I->amOnPage('/contact');
        $I->seeResponseCodeIsSuccessful();
        $I->fillField('search', 'foo');
        $I->click('Rechercher');
        $I->seeCurrentRouteIs('app_contact');
        $I->seeInCurrentUrl('search=foo');
    }

    public function searchResultRestrictsContactList(ControllerTester $I): void
    {
        $contact1 = ContactFactory::createOne([
            'lastname' => 'Leclerc',
            'firstname' => 'Alice',
        ]);
        $contact2 = ContactFactory::createOne([
            'lastname' => 'Martin',
            'firstname' => 'Félix',
        ]);
        $contact3 = ContactFactory::createOne([
            'lastname' => 'Dupont',
            'firstname' => 'Lea',
        ]);
        $contact4 = ContactFactory::createOne([
            'lastname' => 'Legrand',
            'firstname' => 'Leo',
        ]);
        $I->amOnPage('/contact?search=Le');
        $I->seeResponseCodeIsSuccessful();
        $contactTexts = $I->grabMultiple('ul.contacts li a');
        $expectedContacts = [
            'Leclerc, Alice',
            'Dupont, Lea',
            'Legrand, Leo',
        ];
        foreach ($expectedContacts as $expected) {
            $I->assertContains($expected, $contactTexts);
        }
        $I->seeInField('search', 'Le');
    }

}
