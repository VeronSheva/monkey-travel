<?php

namespace App\Service;

use App\Entity\Purchase;
use App\Exception\PurchaseNotFoundException;
use App\Exception\TripNotFoundException;
use App\Model\PurchaseInListItem;
use App\Model\PurchaseListResponse;
use App\Model\PurchaseOutListItem;
use App\Repository\PurchaseRepository;
use App\Repository\TripRepository;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PurchaseService
{
    public function __construct(
        private PurchaseRepository $repository,
        private TripRepository $tripRepository,
        private ValidatorInterface $validator
    ){
    }

    public function getPurchaseByID(int $id): PurchaseListResponse
    {
        $purchase = $this->repository->findOneBy(['id' => $id]);

        if (null === $purchase) {
            throw new PurchaseNotFoundException();
        }

        $trip = $this->tripRepository->findOneBy(['id' => $purchase->getTrip()])->getName();

        $item = [(new PurchaseOutListItem())
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
            fn (Purchase $purchase) => (new PurchaseOutListItem())
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

    public function savePurchase(PurchaseInListItem $item): void
    {
        $price = $this->tripRepository->findOneBy(['id' => $item->getTrip()])->getPrice();
        $trip = $this->tripRepository->findOneBy(['id' => $item->getTrip()]);

        if (null === $trip) {
            throw new TripNotFoundException();
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
    }

    public function validatePurchase(PurchaseInListItem $purchase): ?string
    {
        $errors = $this->validator->validate($purchase);
        $errorString = null;
        if (count($errors) > 0) {
            $errorString = (string) $errors;
        } else {
            $this->savePurchase($purchase);
        }
        return $errorString;
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
