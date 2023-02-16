<?php

namespace App\Tests\Service;

use App\Entity\Purchase;
use App\Entity\Trip;
use App\Exception\PurchaseNotFoundException;
use App\Model\PurchaseListResponse;
use App\Model\PurchaseListItem;
use App\Repository\PurchaseRepository;
use App\Repository\TripRepository;
use App\Service\PurchaseService;
use App\Tests\AbstractTestCase;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PurchaseServiceTest extends AbstractTestCase
{
    public function testGetPurchaseByIdNotFound(): void
    {
        $repository = $this->createMock(PurchaseRepository::class);
        $repository->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => 50])
            ->willReturn(null);

        $tripRepository = $this->createMock(TripRepository::class);

        $validator = $this->createMock(ValidatorInterface::class);

        $this->expectException(PurchaseNotFoundException::class);

        (new PurchaseService($repository, $tripRepository, $validator))->getPurchaseByID(50);
    }

    public function testGetPurchases(): void
    {
        $trip = $this->createTripEntity();

        $purchase = $this->createPurchaseEntity($trip);

        $repository = $this->createMock(PurchaseRepository::class);
        $repository->expects($this->once())
            ->method('findBy')
            ->with([], ['order_time' => Criteria::DESC])
            ->willReturn([$purchase]);

        $tripRepository = $this->createMock(TripRepository::class);
        $tripRepository->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => $purchase->getTrip()])
            ->willReturn($trip);

        $validator = $this->createMock(ValidatorInterface::class);

        $service = new PurchaseService($repository, $tripRepository, $validator);

        $expected = $this->createPurchaseListResponse($trip);

        $this->assertEquals($expected, $service->getPurchases());
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

    private function createPurchaseEntity(Trip $trip): Purchase
    {
        $purchase = (new Purchase())
            ->setTrip($trip->getId())
            ->setPhoneNumber('33333')
            ->setEmail('ffff')
            ->setName('test')
            ->setOrderTime(date_create_immutable())
            ->setPeople(2)
            ->setSum($trip->getPrice() * 2);

        $this->setEntityId($purchase, 7);

        return $purchase;
    }

    private function createPurchaseListResponse(Trip $trip): PurchaseListResponse
    {
        return new PurchaseListResponse([(new PurchaseListItem())
            ->setId(7)
            ->setTrip($trip->getName())
            ->setPhoneNumber('33333')
            ->setEmail('ffff')
            ->setName('test')
            ->setOrderTime(date_create_immutable()->format('Y-m-d H:i:s'))
            ->setPeople(2)
            ->setSum($trip->getPrice() * 2),
        ]);
    }
}
