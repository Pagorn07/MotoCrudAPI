<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Motorcycle;
use App\Factory\MotorcycleFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class MotorcycleTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    protected static ?bool $alwaysBootKernel = true;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
    }

    public function testGetCollection(): void
    {
        MotorcycleFactory::createMany(100);

        $response = static::createClient()->request('GET', '/api/motorcycles');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        $this->assertJsonContains([
            '@context' => '/api/contexts/Motorcycle',
            '@id' => '/api/motorcycles',
            '@type' => 'Collection',
            'totalItems' => 100,
            'view' => [
                '@id' => '/api/motorcycles?page=1',
                '@type' => 'PartialCollectionView',
                'first' => '/api/motorcycles?page=1',
                'last' => '/api/motorcycles?page=4',
                'next' => '/api/motorcycles?page=2',
            ],
        ]);

        $this->assertCount(30, $response->toArray()['member']);
        $this->assertMatchesResourceCollectionJsonSchema(Motorcycle::class);
    }

    public function testCreateMotorcycle(): void
    {
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

    public function testDeleteMotorcycle(): void
    {
        MotorcycleFactory::createOne(['brand' => 'to_delete']);

        $iri = $this->findIriBy(Motorcycle::class, ['brand' => 'to_delete']);

        static::createClient()->request('DELETE', $iri);

        $this->assertResponseStatusCodeSame(204);
        $this->assertNull(
            static::getContainer()->get('doctrine')->getRepository(Motorcycle::class)->findOneBy(['brand' => 'to_delete'])
        );
    }
}