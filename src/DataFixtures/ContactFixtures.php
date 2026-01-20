<?php

namespace App\DataFixtures;

use App\Factory\ContactFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ContactFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        ContactFactory::createMany(150);
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
