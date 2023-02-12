<?php

namespace App\Controller;

use App\Attribute\RequestBody;
use App\Const\CountryPhoneCode;
use App\Model\PurchaseInListItem;
use App\Service\PurchaseService;
use App\Service\Serializer\DTOSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseController extends AbstractController
{
    public function __construct(
        private DTOSerializer $serializer,
        private PurchaseService $service
    ) {
    }

    #[Route(
        '/api/v1/get-purchase/{id}',
        methods: 'GET'
    )]
    public function getPurchaseById(int $id): Response
    {
        $purchase = $this->service->getPurchaseByID($id);

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
    public function getPurchases(): Response
    {
        $purchases = $this->service->getPurchases();

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
    public function savePurchase(#[RequestBody] PurchaseInListItem $item): Response
    {
        $this->service->savePurchase($item);

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
    public function deletePurchase(int $id): Response
    {
        $this->service->deletePurchase($id);

        return new Response(
            'success',
            200,
            ['Content-Type' => 'application/json']
        );
    }
}
