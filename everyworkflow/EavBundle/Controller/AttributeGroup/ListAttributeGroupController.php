<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Controller\AttributeGroup;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\DataGridBundle\Model\DataGridInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ListAttributeGroupController extends AbstractController
{
    public function __construct(
        protected DataGridInterface $dataGrid
    ) {
    }

    #[EwRoute(
        path: 'eav/attribute-group',
        name: 'eav.attribute_group',
        priority: 10,
        methods: 'GET',
        permissions: 'eav.attribute_group.list',
        swagger: true
    )]
    public function __invoke(Request $request): JsonResponse
    {
        $dataGrid = $this->dataGrid->setFromRequest($request);

        return new JsonResponse($dataGrid->toArray());
    }
}
