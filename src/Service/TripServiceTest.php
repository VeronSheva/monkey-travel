<?php

namespace App\Service;

use App\Entity\Trip;
use App\Model\TripListItem;
use App\Model\TripListResponse;
use App\Repository\TripRepository;
use Doctrine\Common\Collections\Criteria;
use PHPUnit\Framework\TestCase;

class TripServiceTest extends TestCase
{
    public function testGetAllTrips(): void
    {
        $repository = $this->createMock(TripRepository::class);
        $repository->expects($this->once())
            ->method('findBy')
            ->with([], ['price' => Criteria::ASC])
            ->willReturn([(new Trip())->setId(10)->setName('test')->setDescription('test')
                ->setDuration(10)->setPrice(200)->setDateStart(date_create_immutable('2000-02-02'))
                ->setDateEnd(date_create_immutable('2000-02-12')), ]);

        $service = new TripService($repository);

        $expected = new TripListResponse([(new TripListItem())->setName('test')
        ->setDescription('test')
        ->setDuration(10)
        ->setPrice(200)
        ->setDateStart('2000-02-02 00:00:00')
        ->setDateEnd('2000-02-12 00:00:00'), ]);

        $this->assertEquals($expected, $service->getAllTrips());
    }
}
