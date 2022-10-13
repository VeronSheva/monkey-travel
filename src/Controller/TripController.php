<?php

namespace App\Controller;

use App\Model\ErrorResponse;
use App\Model\TripListItem;
use App\Model\TripListResponse;
use App\Service\Serializer\DTOSerializer;
use App\Service\TripService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TripController extends AbstractController
{
    public function __construct(private DTOSerializer $serializer)
    {
    }

    /**
     * @OA\Response (
     *     response=200,
     *     description = "Returns one trip with a certain id",
     *     @Model(type=TripListResponse::class)
     * )
     * @OA\Response (
     *     response = 404,
     *     description = "Trip not found",
     *     @Model(type = ErrorResponse::class)
     * )
     */
    #[Route(
        '/api/v1/trip/{id}',
        methods: 'GET'
    )]
    public function getTrip(int $id, TripService $service): Response
    {
        $trip = $service->getTripByID($id);

        return new Response(
            $this->serializer->serialize($trip, 'json'),
            200,
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * @OA\Response (
     *     response = 200,
     *     description = "Returns all trips ordered by price",
     *
     *     @Model (type = TripListResponse::class)
     * )
     */
    #[Route(
        '/api/v1/trips',
        methods: 'GET'
    )]
    public function getTrips(TripService $service): Response
    {
        $list = $service->getAllTrips();

        return new Response(
            $this->serializer->serialize($list, 'json'),
            200,
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="Saves a new trip to database",
     *
     * )
     */
    #[Route(
        '/api/v1/save-trip',
        methods: 'POST'
    )]
    public function saveNewTrip(Request $request, TripService $service): Response
    {
        $tripOb = $this->serializer->deserialize(
            $request->getContent(), TripListItem::class, 'json'
        );
        $service->save($tripOb);

        return new Response(
            'success',
            200,
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * @OA\Response (
     *     response = 200,
     *     description = "Deletes a trip from database",
     *
     * )
     * @OA\Response (
     *     response = 404,
     *     description = "Trip not found",
     *     @Model(type = ErrorResponse::class)
     * )
     */
    #[Route(
        '/api/v1/delete/{id}',
        methods: 'POST'
    )]
    public function delete(int $id, TripService $service): Response
    {
        $service->delete($id);

        return new Response(
            'success',
            200,
            ['Content-Type' => 'application/json']
        );
    }
}
