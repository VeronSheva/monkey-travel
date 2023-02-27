<?php

namespace App\Controller;

use App\Model\ErrorResponse;
use App\Service\RoleService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    public function __construct(private RoleService $roleService)
    {
    }

    /**
     * @OA\Response (
     *     response=200,
     *     description="Promote user to admin",
     * )
     * @OA\Response (
     *     response=404,
     *     description="User not found",
     *
     *     @Model(type=ErrorResponse::class)
     * )
     */
    #[Route(
        '/api/v1/admin/grantAdmin/{userId}',
        methods: 'POST'
    )]
    public function makeAdmin(int $userId): Response
    {
        $this->roleService->grantAdmin($userId);

        return $this->json('null');
    }
}
