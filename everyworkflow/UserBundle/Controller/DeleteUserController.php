<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\UserBundle\Controller;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\UserBundle\Repository\UserRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteUserController extends AbstractController
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {
    }

    #[EwRoute(
        path: 'user/{uuid}',
        name: 'user.delete',
        methods: 'DELETE',
        permissions: 'user.delete',
        swagger: [
            'parameters' => [
                [
                    'name' => 'uuid',
                    'in' => 'path',
                ],
            ],
        ]
    )]
    public function __invoke(string $uuid): JsonResponse
    {
        try {
            $this->userRepository->deleteOneByFilter(['_id' => new \MongoDB\BSON\ObjectId($uuid)]);

            return new JsonResponse(['detail' => 'ID: '.$uuid.' deleted successfully.']);
        } catch (\Exception $e) {
            return new JsonResponse(['detail' => $e->getMessage()], 500);
        }
    }
}
