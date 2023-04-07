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
        swagger: true
    )]
    public function __invoke(Request $request): JsonResponse
    {
        $dataGrid = $this->userDataGrid->setFromRequest($request);

        return new JsonResponse($dataGrid->toArray());
    }
}
