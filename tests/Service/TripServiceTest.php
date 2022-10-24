<?php

namespace App\Tests\Service;

use App\Entity\Trip;
use App\Model\TripListItem;
use App\Model\TripListResponse;
use App\Repository\TripRepository;
use App\Service\TripService;
use App\Tests\AbstractTestCase;
use Doctrine\Common\Collections\Criteria;

class TripServiceTest extends AbstractTestCase
{
    public function testGetAllTrips(): void
    {
        $trip = (new Trip())->setName('test')->setDescription('test')
            ->setPrice(200)->setDuration(10)->setDateStart(date_create_immutable('2000-02-02'))
            ->setDateEnd(date_create_immutable('2000-02-12'));

        $this->setEntityId($trip, 7);

        $repository = $this->createMock(TripRepository::class);
        $repository->expects($this->once())
            ->method('findBy')
            ->with([], ['price' => Criteria::ASC])
            ->willReturn([$trip]);

        $service = new TripService($repository);

        $expected = new TripListResponse([new TripListItem(7, 'test', 'test',
            200, 10, '2000-02-02 00:00:00', '2000-02-12 00:00:00'),
             ]);

        $this->assertEquals($expected, $service->getAllTrips());
    }
}
