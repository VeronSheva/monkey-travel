<?php

namespace App\Service;

use App\Entity\Trip;
use App\Exception\TripNotFoundException;
use App\Model\TripFilters;
use App\Model\TripListItem;
use App\Model\TripListResponse;
use App\Repository\TripRepository;

class TripService
{
    public function __construct(private TripRepository $tripRepository)
    {
    }

    public function getTripByID(int $id): TripListResponse
    {
        $trip = $this->tripRepository->findOneBy(['id' => $id]);

        if (null === $trip) {
            throw new TripNotFoundException();
        }

        $tripObj = [(new TripListItem())
            ->setId($trip->getId())
            ->setName($trip->getName())
            ->setDescription($trip->getDescription())
            ->setDuration($trip->getDuration())
            ->setPrice($trip->getPrice())
            ->setDateStart($trip->getDateStart()->format('d-m-Y'))
            ->setDateEnd($trip->getDateEnd()->format('d-m-Y'))
            ->setCountry($trip->getCountry())
            ->setImg($trip->getImg())
            ->setFreePlaces($trip->getFreePlaces()),
        ];

        return new TripListResponse($tripObj);
    }

    public function getTrips(TripFilters $filters, int $limit, int $page): TripListResponse
    {
        $offset = max($page - 1, 0) * $limit;
        $trips = $this->tripRepository->getFilteredTrips($filters, $offset, $limit);
        $items = [];
        foreach ($trips->getIterator()->getArrayCopy() as $trip) {
            $items[] = (new TripListItem())
                ->setId($trip[0]->getId())
                ->setName($trip[0]->getName())
                ->setDescription($trip[0]->getDescription())
                ->setDuration($trip[0]->getDuration())
                ->setPrice($trip[0]->getPrice())
                ->setDateStart($trip[0]->getDateStart()->format('d-m-Y'))
                ->setDateEnd($trip[0]->getDateEnd()->format('d-m-Y'))
                ->setCountry($trip[0]->getCountry())
                ->setImg($trip[0]->getImg())
                ->setFreePlaces($trip[0]->getFreePlaces());
        }
        $pagination = new PaginateHelperService($trips->count(), $limit, $page);

        return new TripListResponse(
            $items,
            $pagination->getPages(),
            $pagination->getPage(),
            $pagination->getPerPage(),
            $pagination->getTotal()
        );
    }

    public function saveTrip(TripListItem $tripObj): void
    {
        $trip = new Trip();
        $trip->setPrice($tripObj->getPrice())
            ->setDescription($tripObj->getDescription())
            ->setName($tripObj->getName())
            ->setDateStart(date_create_immutable($tripObj->getDateStart()))
            ->setDateEnd(date_create_immutable($tripObj->getDateEnd()))
            ->setDuration($tripObj->getDuration())
            ->setCountry($tripObj->getCountry())
            ->setImg($tripObj->getImg())
            ->setFreePlaces($tripObj->getFreePlaces());

        $this->tripRepository->add($trip, true);
    }

    public function deleteTrip(int $id): void
    {
        $trip = $this->tripRepository->findOneBy(['id' => $id]);

        if (null === $trip) {
            throw new TripNotFoundException();
        }

        $this->tripRepository->remove($trip, true);
    }
}
