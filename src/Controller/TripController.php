<?php


namespace App\Controller;

use App\Model\TripListItem;
use App\Service\Serializer\DTOSerializer;
use App\Service\TripService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TripRepository;


class TripController extends AbstractController
{
    public function __construct(private DTOSerializer $serializer)
    {
    }

    #[Route(
        '/trip/{id}',
        methods: 'GET'
    )]
    public function getTrip(int $id, TripRepository $repository): Response
    {
        $trip = $repository->findOneBy(['id' => $id]);
        return new Response(
            $this->serializer->serialize($trip, 'json'),
            200,
            ['Content-Type' => 'application/json']
        );
    }

    #[Route(
        '/trips',
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

    #[Route(
        '/save-trip',
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

    #[Route(
        '/delete/{id}',
        methods: 'POST'
    )]
    public function delete(int $id, TripRepository $repository): Response
    {
        $trip = $repository->findOneBy(['id' => $id]);
        $repository->remove($trip, true);
        return new Response(
            'success',
            200,
            ['Content-Type' => 'application/json']
        );
    }

}
