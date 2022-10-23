<?php

namespace App\Tests\Controller;

use App\Entity\Trip;
use App\Tests\AbstractControllerTest;

class TripControllerTest extends AbstractControllerTest
{
    public function testGetTrips(): void
    {
        $this->em->persist((new Trip())->setName('Somewhere')
        ->setDescription('Somewhat')
        ->setDuration(10)
        ->setPrice(200)
        ->setDateStart(date_create_immutable('2000-10-10 00:00:00'))
        ->setDateEnd(date_create_immutable('2000-10-20 00:00:00')));
        $this->em->flush();

        $this->client->request('GET', '/api/v1/trips');
        $responseContent = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema($responseContent, [
            'type' => 'object',
            'required' => ['items'],
            'properties' => [
                'items' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'required' => ['id', 'name', 'description', 'duration', 'price', 'date_start', 'date_end'],
                        'properties' => [
                            'id' => ['type' => 'integer'],
                            'duration' => ['type' => 'integer'],
                            'price' => ['type' => 'integer'],
                            'description' => ['type' => 'string'],
                            'name' => ['type' => 'string'],
                            'date_start' => ['type' => 'string'],
                            'date_end' => ['type' => 'string'],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
