<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TripControllerTest extends WebTestCase
{

    public function testGetTrips(): void
    {
        $client = static::createClient();
        $client->request('GET', '/trips');
        $responseContent = $client->getResponse()->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertJsonStringEqualsJsonFile(
            __DIR__ . '\responses\TripControllerTest_testGetTrips.json' ,
        $responseContent);
    }
}
