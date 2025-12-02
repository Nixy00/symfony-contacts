<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Factory\ContactFactory;

class ContactFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        ContactFactory::createMany(150);
    }
}
