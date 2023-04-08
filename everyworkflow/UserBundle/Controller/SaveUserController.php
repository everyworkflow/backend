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
use Symfony\Component\HttpFoundation\Request;

class SaveUserController extends AbstractController
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {
    }

    #[EwRoute(
        path: 'user/{uuid}',
        name: 'user.save',
        methods: 'POST',
        permissions: 'user.save',
        swagger: [
            'parameters' => [
                [
                    'name' => 'uuid',
                    'in' => 'path',
                    'default' => 'create',
                ],
            ],
            'requestBody' => [
                'content' => [
                    'application/json' => [
                        'schema' => [
                            'properties' => [
                                'first_name' => [
                                    'type' => 'string',
                                    'required' => true,
                                ],
                                'last_name' => [
                                    'type' => 'string',
                                    'required' => true,
                                ],
                                'email' => [
                                    'type' => 'string',
                                    'required' => true,
                                ],
                                'dob' => [
                                    'type' => 'string',
                                    'required' => true,
                                ],
                                'phone' => [
                                    'type' => 'string',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]
    )]
    public function __invoke(Request $request, string $uuid = 'create'): JsonResponse
    {
        $submitData = $request->toArray();
        if ('create' === $uuid) {
            $item = $this->userRepository->create($submitData);
        } else {
            $item = $this->userRepository->findById($uuid);
            foreach ($submitData as $key => $val) {
                $item->setData($key, $val);
            }
        }

        $item = $this->userRepository->saveOne($item);

        return new JsonResponse([
            'detail' => 'Successfully saved changes.',
            'item' => $item->toArray(),
        ]);
    }
}
