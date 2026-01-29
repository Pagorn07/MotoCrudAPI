<?php

namespace App\DataFixtures;

use App\Entity\Motorcycle;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class MotorcycleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $motorcycles = [
            // Deportivas
            ['Ninja 650', 649, 'Kawasaki', 'Deportiva', ['ABS', 'Control de tracción'], 193, false],
            ['YZF-R6', 599, 'Yamaha', 'Deportiva', ['ABS', 'Control de tracción', 'Quickshifter'], 190, false],
            ['CBR1000RR', 999, 'Honda', 'Deportiva', ['ABS', 'Control de tracción', 'Modos de conducción'], 201, false],
            ['Panigale V4 S', 1103, 'Ducati', 'Deportiva', ['ABS', 'DTC', 'Quickshifter', 'Suspensión electrónica'], 198, true],
            ['GSX-R1000', 999, 'Suzuki', 'Deportiva', ['ABS', 'Control de tracción'], 203, false],
            
            // Naked
            ['MT-07', 689, 'Yamaha', 'Naked', ['ABS', 'Luces LED'], 184, false],
            ['Z900', 948, 'Kawasaki', 'Naked', ['ABS', 'Control de tracción', 'TFT'], 210, false],
            ['Street Triple RS', 765, 'Triumph', 'Naked', ['ABS', 'Control de tracción', 'Quickshifter', 'Modos'], 189, true],
            ['Monster 821', 821, 'Ducati', 'Naked', ['ABS', 'Control de tracción'], 206, false],
            
            // Custom/Cruiser
            ['Iron 883', 883, 'Harley-Davidson', 'Custom', ['ABS'], 256, false],
            ['Rebel 500', 471, 'Honda', 'Custom', ['ABS'], 190, false],
            ['Bonneville T120', 1200, 'Triumph', 'Classic', ['ABS', 'Control de tracción', 'Modos'], 224, false],
            
            // Trail/Adventure
            ['Africa Twin', 1084, 'Honda', 'Trail', ['ABS', 'Control de tracción', 'Modos', 'Maletas'], 238, false],
            ['R 1250 GS', 1254, 'BMW', 'Trail', ['ABS', 'Control de tracción', 'Suspensión electrónica', 'Control de crucero'], 249, true],
            ['Versys 650', 649, 'Kawasaki', 'Trail', ['ABS'], 216, false],
        ];

        foreach ($motorcycles as [$model, $cc, $brand, $type, $extras, $weight, $limited]) {
            $moto = new Motorcycle();
            $moto->setModel($model);
            $moto->setEngineCapacity($cc);
            $moto->setBrand($brand);
            $moto->setType($type);
            $moto->setExtras($extras);
            $moto->setWeight($weight);
            $moto->setLimitedEdition($limited);
            
            $manager->persist($moto);
        }

        $manager->flush();
    }
}