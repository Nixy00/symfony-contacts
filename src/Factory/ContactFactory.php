<?php

namespace App\Factory;

use App\Entity\Contact;
use Transliterator;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Contact>
 */
final class ContactFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    #[\Override]
    public static function class(): string
    {
        return Contact::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    #[\Override]
    protected function defaults(): array|callable
    {
        $faker = self::faker();

        $firstname = $faker->firstName();
        $lastname = $faker->lastName();

        $firstnameLower = mb_strtolower(Transliterator::create('Any-Lower; Latin-ASCII')->transliterate($firstname));
        $lastnameLower = mb_strtolower(Transliterator::create('Any-Lower; Latin-ASCII')->transliterate($lastname));

        $domain = $faker->domainName();

        return [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => "{$firstnameLower}.{$lastnameLower}@{$domain}",
        ];
    }


    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    #[\Override]
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Contact $contact): void {})
        ;
    }
}
