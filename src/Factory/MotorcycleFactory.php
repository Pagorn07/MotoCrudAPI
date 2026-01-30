<?php

namespace App\Factory;

use App\Entity\Motorcycle;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Motorcycle>
 */
final class MotorcycleFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Motorcycle::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'brand' => self::faker()->text(40),
            'engineCapacity' => self::faker()->numberBetween(125, 1200),
            'extras' => [self::faker()->word()],
            'limitedEdition' => self::faker()->boolean(),
            'model' => self::faker()->text(50),
            'type' => self::faker()->text(50),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Motorcycle $motorcycle): void {})
        ;
    }
}
