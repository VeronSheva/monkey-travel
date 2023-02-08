<?php

namespace App\Controller;

use App\Const\Countries;
use App\Exception\ValidationFailedException;
use App\Model\ErrorResponse;
use App\Model\TripFilters;
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
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TripController extends AbstractController
{
    public function __construct(
        private DTOSerializer $serializer,
        private ValidatorInterface $validator,
    ) {
    }

    /**
     * @OA\Response (
     *     response=200,
     *     description = "Returns one trip with a certain id",
     *     @Model(type = TripListResponse::class)
     * )
     * @OA\Response (
     *     response = 404,
     *     description = "Trip not found",
     *     @Model(type = ErrorResponse::class)
     * )
     */
    #[Route(
        '/api/v1/get-trip/{id}',
        methods: 'GET'
    )]
    public function getTripById(int $id, TripService $service): Response
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
        '/api/v1/get-trips/{limit}/{page}', defaults: ['limit' => 5, 'page' => 1],
        methods: 'POST'
    )]
    public function getTrips(TripService $service, Request $request, int $limit, int $page): Response
    {
        $filters = $this->serializer->deserialize(
            $request->getContent(), TripFilters::class, 'json'
        );

        $errors = $this->validator->validate($filters);

        if (count($errors) > 0) {
            throw new ValidationFailedException(json_encode($errors));
        } else {
            $trips = $service->getTrips($filters, $limit, $page);
        }

        return new Response(
            $this->serializer->serialize($trips, 'json'),
            200,
            ['Content-Type' => 'application/json']
        );
    }

    #[Route(
        '/api/v1/get-countries',
        methods: 'GET'
    )]
    public function getCountries(): Response
    {
        $countries = Countries::enumToArray();

        return new Response(
            $this->serializer->serialize($countries, 'json'),
            200,
            ['Content-Type' => 'application/json',
            ]
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
    public function saveTrip(Request $request, TripService $service): Response
    {
        $item = $this->serializer->deserialize(
            $request->getContent(), TripListItem::class, 'json'
        );

        $errors = $this->validator->validate($item);

        if (count($errors) > 0) {
            throw new ValidationFailedException(json_encode($errors));
        } else {
            $service->saveTrip($item);
        }

        return new Response('success',
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
        '/api/v1/delete-trip/{id}',
        methods: 'POST'
    )]
    public function deleteTrip(int $id, TripService $service): Response
    {
        $service->deleteTrip($id);

        return new Response(
            'success',
            200,
            ['Content-Type' => 'application/json']
        );
    }
}
