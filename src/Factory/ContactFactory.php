<?php

namespace App\Factory;

use App\Entity\Contact;
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
    private \Transliterator $transliterator;

    public function __construct()
    {
        $this->transliterator = \Transliterator::create('Any-Lower; Latin-ASCII');
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

        $firstnameLower = $this->normalizeName($firstname);
        $lastnameLower = $this->normalizeName($lastname);

        $domain = $faker->domainName();

        return [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => "{$firstnameLower}.{$lastnameLower}@{$domain}",
        ];
    }

    protected function normalizeName(string $name): string
    {
        $nameLower = mb_strtolower($this->transliterator->transliterate($name));

        return preg_replace('/[^a-z]/', '-', $nameLower);
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
