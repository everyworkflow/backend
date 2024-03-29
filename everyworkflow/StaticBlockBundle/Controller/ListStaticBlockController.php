<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\StaticBlockBundle\Controller;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\DataGridBundle\Model\DataGridInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ListStaticBlockController extends AbstractController
{
    public function __construct(
        protected DataGridInterface $dataGrid
    ) {
    }

    #[EwRoute(
        path: 'cms/static-block',
        name: 'cms.static_block',
        priority: 10,
        methods: 'GET',
        permissions: 'cms.static_block.list',
        swagger: [
            'tags' => ['cms_static_block'],
        ]
    )]
    public function __invoke(Request $request): JsonResponse
    {
        $dataGrid = $this->dataGrid->setFromRequest($request);

        return new JsonResponse($dataGrid->toArray());
    }
}
