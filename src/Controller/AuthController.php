<?php

namespace App\Controller;

use App\Attribute\RequestBody;
use App\Model\ErrorResponse;
use App\Model\IdResponse;
use App\Model\SignUpRequest;
use App\Service\SignUpService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    public function __construct(private SignUpService $service)
    {
    }

    /**
     * @OA\Response (
     *     response=200,
     *     description = "Signs up a user",
     *
     *     @Model(type=IdResponse::class)
     * )
     *
     * @OA\Response (
     *     response=409,
     *     description = "This user already exists",
     *
     *     @Model(type=ErrorResponse::class)
     * )
     *
     * @OA\Response (
     *     response=400,
     *     description = "Validation failed",
     *
     *     @Model(type=ErrorResponse::class)
     * )
     */
    #[Route(
        '/api/v1/sign-up',
        methods: 'POST'
    )]
    public function signUp(#[RequestBody] SignUpRequest $request): Response
    {
        return $this->service->signUp($request);
    }
}
