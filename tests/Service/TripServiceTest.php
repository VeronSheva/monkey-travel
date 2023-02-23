<?php

namespace App\Tests\Service;

use App\Entity\Trip;
use App\Exception\TripNotFoundException;
use App\Model\TripFilters;
use App\Model\TripListItem;
use App\Model\TripListResponse;
use App\Repository\TripRepository;
use App\Service\PaginateHelperService;
use App\Service\TripService;
use App\Tests\AbstractTestCase;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

    public function testGetTrips(int $page = 1, int $limit = 5): void
    {
        $trip = $this->createTripEntity();
        $offset = max($page - 1, 0) * $limit;

        $repository = $this->createMock(TripRepository::class);
        $filters = new TripFilters();

        $service = new TripService($repository);
        $repository->expects($this->once())
            ->method('getFilteredTrips')
            ->with($filters, $offset, $page)
            ->willReturn([$trip]);

        $expected = $this->createTripListResponse($trip);

        $this->assertEquals($expected, $service->getTrips($filters, $limit, $page));
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

    private function createTripListResponse(Trip $trips, int $limit, int $page ): TripListResponse
    {
        $pagination = new PaginateHelperService($trips->count(), $limit, $page);

        return new TripListResponse($trips);
    }
}
