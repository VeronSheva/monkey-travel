<?php


namespace App\Service;

use App\Entity\Trip;
use App\Model\TripListItem;
use App\Model\TripListResponse;
use App\Repository\TripRepository;

class TripService
{
    public function __construct(
        private TripRepository $tripRepository,
    )
    {
    }

    public function getAllTrips(): TripListResponse
    {
        $trips = $this->tripRepository->findAll();
        $items = array_map(
            fn(Trip $trip) => (new TripListItem())
                ->setName($trip->getName())
                ->setDescription($trip->getDescription())
                ->setDuration($trip->getDuration())
                ->setPrice($trip->getPrice())
                ->setDateStart($trip->getDateStart()->format('Y-m-d H:i:s'))
                ->setDateEnd($trip->getDateEnd()->format('Y-m-d H:i:s'))
        , $trips);
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


}
