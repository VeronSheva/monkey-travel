<?php

namespace App\Controller;

use App\Const\CountryPhoneCode;
use App\Exception\ValidationFailedException;
use App\Model\PurchaseInListItem;
use App\Service\PurchaseService;
use App\Service\Serializer\DTOSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PurchaseController extends AbstractController
{
    public function __construct(
        private DTOSerializer $serializer,
        private ValidatorInterface $validator
    ) {
    }

    #[Route(
        '/api/v1/get-purchase/{id}',
        methods: 'GET'
    )]
    public function getPurchaseById(PurchaseService $service, int $id): Response
    {
        $purchase = $service->getPurchaseByID($id);

        return new Response(
            $this->serializer->serialize($purchase, 'json'),
            200,
            ['Content-Type' => 'application/json']
        );
    }

    #[Route(
        '/api/v1/get-purchases',
        methods: 'GET'
    )]
    public function getPurchases(PurchaseService $service): Response
    {
        $purchases = $service->getPurchases();

        return new Response(
            $this->serializer->serialize($purchases, 'json'),
            200,
            ['Content-Type' => 'application/json']
        );
    }

    #[Route(
        'api/v1/save-purchase',
        methods: 'POST'
    )]
    public function savePurchase(Request $request, PurchaseService $service): Response
    {
        $item = $this->serializer->deserialize(
            $request->getContent(),
            PurchaseInListItem::class, 'json'
        );
        $errors = $this->validator->validate($item);
        if (count($errors) > 0) {
            throw new ValidationFailedException(json_encode($errors));
        } else {
            $service->savePurchase($item);
        }

        return new Response(
            'success',
            200,
            ['Content-Type' => 'application/json']);
    }

    #[Route(
        'api/v1/get-country-codes',
        methods: 'GET'
    )]
    public function getCountryCodes(): Response
    {
        $codes = CountryPhoneCode::enumToArray();

        return new Response(
            $this->serializer->serialize($codes, 'json'),
            200,
            ['Content-Type' => 'application/json',
            ]
        );
    }

    #[Route(
        '/api/v1/delete-purchase/{id}',
        methods: 'POST'
    )]
    public function deletePurchase(int $id, PurchaseService $service): Response
    {
        $service->deletePurchase($id);

        return new Response(
            'success',
            200,
            ['Content-Type' => 'application/json']
        );
    }
}
