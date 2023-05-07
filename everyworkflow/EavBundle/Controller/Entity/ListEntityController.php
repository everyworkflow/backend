<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Controller\Entity;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\DataGridBundle\Model\DataGridInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ListEntityController extends AbstractController
{
    public function __construct(
        protected DataGridInterface $dataGrid
    ) {
    }

    #[EwRoute(
        path: 'eav/entity',
        name: 'eav.entity',
        priority: 10,
        methods: 'GET',
        permissions: 'eav.entity.list',
        swagger: [
            'tags' => ['eav_entity'],
        ]
    )]
    public function __invoke(Request $request): JsonResponse
    {
        $dataGrid = $this->dataGrid->setFromRequest($request);

        return new JsonResponse($dataGrid->toArray());
    }
}
