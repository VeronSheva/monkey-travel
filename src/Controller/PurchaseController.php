<?php

namespace App\Controller;

use App\Model\PurchaseInListItem;
use App\Service\PurchaseService;
use App\Service\Serializer\DTOSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseController extends AbstractController
{
    public function __construct(private DTOSerializer $serializer)
    {
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

        return new Response(
            $service->validatePurchase($item),
            200,
            ['Content-Type' => 'application/json']);
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
