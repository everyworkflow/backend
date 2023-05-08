<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\UserBundle\Controller;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\UserBundle\DataGrid\UserDataGrid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ListUserController extends AbstractController
{
    public function __construct(
        protected UserDataGrid $userDataGrid
    ) {
    }

    #[EwRoute(
        path: 'user',
        name: 'user',
        priority: 10,
        methods: 'GET',
        permissions: 'user.list',
        swagger: [
            'parameters' => [
                [
                    'name' => 'page',
                    'in' => 'query',
                    'schema' => [
                        'type' => 'number',
                        'minimum' => 1,
                        'default' => 1,
                    ],
                ],
                [
                    'name' => 'per-page',
                    'in' => 'query',
                    'schema' => [
                        'type' => 'number',
                        'minimum' => 1,
                        'default' => 20,
                    ],
                ],
                [
                    'name' => 'filter',
                    'in' => 'query',
                    'schema' => [
                        'type' => 'string',
                        'default' => '{}',
                    ],
                ],
            ],
            'responses' => [
                200 => [
                    'description' => 'Json Response',
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'properties' => [
                                    'data_collection' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'meta' => [
                                                'type' => 'object',
                                                '$ref' => '#/components/schemas/data_collection_meta',
                                            ],
                                            'results' => [
                                                'type' => 'array',
                                                'items' => [
                                                    '$ref' => '#/components/schemas/user',
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]
    )]
    public function __invoke(Request $request): JsonResponse
    {
        $dataGrid = $this->userDataGrid->setFromRequest($request);

        return new JsonResponse($dataGrid->toArray());
    }
}
