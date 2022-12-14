<?php

namespace App\Tests\Service;

use App\Entity\Trip;
use App\Exception\TripNotFoundException;
use App\Model\TripListItem;
use App\Model\TripListResponse;
use App\Repository\TripRepository;
use App\Service\TripService;
use App\Tests\AbstractTestCase;
use Doctrine\Common\Collections\Criteria;

class TripServiceTest extends AbstractTestCase
{
    public function testGetTripByIdNotFound(): void
    {
        $repository = $this->createMock(TripRepository::class);
        $repository->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => 7])
            ->willReturn(null);

        $this->expectException(TripNotFoundException::class);

        (new TripService($repository))->getTripByID(7);
    }

    public function testGetTrips(): void
    {
        $trip = $this->createTripEntity();

        $repository = $this->createMock(TripRepository::class);
        $repository->expects($this->once())
            ->method('findBy')
            ->with([], ['price' => Criteria::ASC])
            ->willReturn([$trip]);

        $service = new TripService($repository);

        $expected = $this->createTripListResponse();

        $this->assertEquals($expected, $service->getTrips());
    }

    private function createTripEntity(): Trip
    {
        $trip = (new Trip())
            ->setName('test')
            ->setDescription('test')
            ->setPrice(200)
            ->setDuration(10)
            ->setDateStart(date_create_immutable('2000-02-02'))
            ->setDateEnd(date_create_immutable('2000-02-12'));

        $this->setEntityId($trip, 7);

        return $trip;
    }

    private function createTripListResponse(): TripListResponse
    {
        return new TripListResponse([(new TripListItem())
            ->setId(7)
            ->setName('test')
            ->setDescription('test')
            ->setPrice(200)
            ->setDuration(10)
            ->setDateStart('2000-02-02 00:00:00')
            ->setDateEnd('2000-02-12 00:00:00'), ]);
    }
}
