<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Motorcycle;

class MotorcycleTest extends ApiTestCase
{
    public function testCreateMotorcycle(): void
    {
        static::$alwaysBootKernel = true;

        $client = static::createClient();

        $content = [
            'model' => 'Test Bike',
            'engineCapacity' => 600,
            'brand' => 'Test Brand',
            'type' => 'Deportiva',
            'extras' => ['ABS'],
            'weight' => 200,
            'limitedEdition' => false
        ];

        $response = $client->request('POST', '/api/motorcycles', ['json' => $content]);

        $this->assertResponseStatusCodeSame(201);

        $this->assertResponseHeaderSame(
            'content-type',
            'application/ld+json; charset=utf-8'
        );

        $this->assertMatchesRegularExpression('~^/api/motorcycles/\d+$~', $response->toArray()['@id']);
        $this->assertMatchesResourceItemJsonSchema(Motorcycle::class);
    }
}