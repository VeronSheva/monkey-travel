<?php

namespace App\Controller;

use App\Attribute\RequestBody;
use App\Const\CountryPhoneCode;
use App\Model\ErrorResponse;
use App\Model\PurchaseForm;
use App\Model\PurchaseListResponse;
use App\Service\PurchaseService;
use App\Service\Serializer\DTOSerializer;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
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

    /**
     * @OA\Response (
     *     response=200,
     *     description="Returns one purchase with a certain id",
     *
     *     @Model(type=PurchaseListResponse::class)
     * )
     *
     * @OA\Response (
     *     response=404,
     *     description="Purchase not found",
     *
     *     @Model(type=ErrorResponse::class)
     * )
     */
    #[Route(
        '/api/v1/admin/get-purchase/{id}',
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

    /**
     * @OA\Response (
     *     response=200,
     *     description="Returns all purchases",
     *
     *     @Model(type=PurchaseListResponse::class)
     * )
     * @OA\Response (
     *     response=404,
     *     description="Filter validation failed",
     *
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\Response (
     *     response=400,
     *     description="Error while unmarshalling request body",
     *
     *     @Model(type=ErrorResponse::class)
     * )
     */
    #[Route(
        '/api/v1/admin/get-purchases',
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

    /**
     * @OA\Response (
     *     response=200,
     *     description="Returns all purchases",
     *
     *     @Model(type=PurchaseListResponse::class)
     * )
     * @OA\Response (
     *     response=404,
     *     description="Filter validation failed",
     *
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\Response (
     *     response=400,
     *     description="Error while unmarshalling request body",
     *
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\Response (
     *     response=409,
     *     description="Not enough places for this trip",
     *
     *     @Model(type=ErrorResponse::class)
     * )
     */
    #[Route(
        'api/v1/save-purchase',
        methods: 'POST'
    )]
    public function savePurchase(#[RequestBody] PurchaseForm $item): Response
    {
        $this->service->savePurchase($item);

        return new Response(
            $this->serializer->serialize(['success'], 'json'),
            200,
            ['Content-Type' => 'application/json']);
    }


    /**
     * @OA\Response (
     *     response=200,
     *     description="Returns the enum CountryPhoneCode in a form of array",
     * )
     */
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

    /**
     * @OA\Response (
     *     response=200,
     *     description="Deletes a purchase from database",
     *
     * )
     * @OA\Response (
     *     response=404,
     *     description="Purchase not found",
     *
     *     @Model(type=ErrorResponse::class)
     * )
     */
    #[Route(
        '/api/v1/admin/delete-purchase/{id}',
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
