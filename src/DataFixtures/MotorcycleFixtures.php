<?php

namespace App\DataFixtures;

use App\Factory\MotorcycleFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MotorcycleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        MotorcycleFactory::createMany(10);
    }
}