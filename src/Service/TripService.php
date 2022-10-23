<?php

namespace App\Service;

use App\Entity\Trip;
use App\Exception\TripNotFoundException;
use App\Model\TripListItem;
use App\Model\TripListResponse;
use App\Repository\TripRepository;
use Doctrine\Common\Collections\Criteria;

class TripService
{
    public function __construct(
        private TripRepository $tripRepository,
    ) {
    }

    public function getTripByID(int $id): TripListResponse
    {
        $trip = $this->tripRepository->findOneBy(['id' => $id]);

        if (null === $trip) {
            throw new TripNotFoundException();
        }

        $tripObj = [new TripListItem($trip->getId(),
            $trip->getName(),
            $trip->getDescription(),
            $trip->getDuration(),
            $trip->getPrice(),
            $trip->getDateStart()->format('Y-m-d H:i:s'),
            $trip->getDateEnd()->format('Y-m-d H:i:s')), ];

        return new TripListResponse($tripObj);
    }

    public function getAllTrips(): TripListResponse
    {
        $trips = $this->tripRepository->findBy([], ['price' => Criteria::ASC]);
        $items = array_map(
            fn (Trip $trip) => new TripListItem($trip->getId(),
                $trip->getName(),
                $trip->getDescription(),
                $trip->getPrice(),
                $trip->getDuration(),
                $trip->getDateStart()->format('Y-m-d H:i:s'),
                $trip->getDateEnd()->format('Y-m-d H:i:s')), $trips);

        return new TripListResponse($items);
    }

    public function save(TripListItem $tripObj): void
    {
        $trip = new Trip();
        $trip->setPrice($tripObj->getPrice())
            ->setDescription($tripObj->getDescription())
            ->setName($tripObj->getName())
            ->setDateStart(date_create_immutable($tripObj->getDateStart()))
            ->setDateEnd(date_create_immutable($tripObj->getDateEnd()))
            ->setDuration($tripObj->getDuration());

        $this->tripRepository->add($trip, true);
    }

    public function delete(int $id): void
    {
        $trip = $this->tripRepository->findOneBy(['id' => $id]);

        if (null === $trip) {
            throw new TripNotFoundException();
        }

        $this->tripRepository->remove($trip, true);
    }
}
