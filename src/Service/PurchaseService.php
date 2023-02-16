<?php

namespace App\Service;

use App\Entity\Purchase;
use App\Exception\NotEnoughPlacesException;
use App\Exception\PurchaseNotFoundException;
use App\Exception\TripNotFoundException;
use App\Model\PurchaseForm;
use App\Model\PurchaseListResponse;
use App\Model\PurchaseListItem;
use App\Repository\PurchaseRepository;
use App\Repository\TripRepository;
use Doctrine\Common\Collections\Criteria;

class PurchaseService
{
    public function __construct(
        private PurchaseRepository $repository,
        private TripRepository $tripRepository,
    ) {
    }

    public function getPurchaseByID(int $id): PurchaseListResponse
    {
        $purchase = $this->repository->findOneBy(['id' => $id]);

        if (null === $purchase) {
            throw new PurchaseNotFoundException();
        }

        $trip = $this->tripRepository->findOneBy(['id' => $purchase->getTrip()])->getName();

        $item = [(new PurchaseListItem())
                ->setId($purchase->getId())
                ->setTrip($trip)
                ->setPhoneNumber($purchase->getPhoneNumber())
                ->setEmail($purchase->getEmail())
                ->setName($purchase->getName())
                ->setOrderTime($purchase->getOrderTime()->format('Y-m-d H:i:s'))
                ->setPeople($purchase->getPeople())
                ->setSum($purchase->getSum()), ];

        return new PurchaseListResponse($item);
    }

    public function getPurchases(): PurchaseListResponse
    {
        $purchases = $this->repository->findBy([], ['order_time' => Criteria::DESC]);
        $items = array_map(
            fn (Purchase $purchase) => (new PurchaseListItem())
            ->setId($purchase->getId())
            ->setTrip($this
                ->tripRepository
                ->findOneBy(['id' => $purchase->getTrip()])
                ->getName())
            ->setPhoneNumber($purchase->getPhoneNumber())
            ->setEmail($purchase->getEmail())
            ->setName($purchase->getName())
            ->setOrderTime($purchase->getOrderTime()->format('Y-m-d H:i:s'))
            ->setPeople($purchase->getPeople())
            ->setSum($purchase->getSum()), $purchases
        );

        return new PurchaseListResponse($items);
    }

    public function savePurchase(PurchaseForm $item): void
    {
        $price = $this->tripRepository->findOneBy(['id' => $item->getTrip()])->getPrice();
        $trip = $this->tripRepository->findOneBy(['id' => $item->getTrip()]);

        if (null === $trip) {
            throw new TripNotFoundException();
        } else {
            $free_places = $trip->getFreePlaces();
            if ($free_places < $item->getPeople()) {
                throw new NotEnoughPlacesException();
            }
        }

        $purchase = (new Purchase())
            ->setTrip($item->getTrip())
            ->setCountryCode($item->getCountryCode())
            ->setPhoneNumber($item->getPhoneNumber())
            ->setEmail($item->getEmail())
            ->setName($item->getName())
            ->setOrderTime(date_create_immutable('now', new \DateTimeZone('Europe/Kyiv')))
            ->setPeople($item->getPeople())
            ->setSum($price * $item->getPeople());
        $this->repository->save($purchase, true);

        $this->tripRepository->updateFreePlaces($trip, $purchase);
    }

    public function deletePurchase(int $id): void
    {
        $purchase = $this->repository->findOneBy(['id' => $id]);

        if (null === $purchase) {
            throw new PurchaseNotFoundException();
        }

        $this->repository->remove($purchase, true);
    }
}
