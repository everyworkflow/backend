<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBundle\Controller;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\PageBundle\DataGrid\PageDataGridInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ListPageController extends AbstractController
{
    public function __construct(
        protected PageDataGridInterface $pageDataGrid
    ) {
    }

    #[EwRoute(
        path: 'cms/page',
        name: 'cms.page',
        priority: 10,
        methods: 'GET',
        permissions: 'cms.page.list',
        swagger: [
            'tags' => ['cms_page'],
        ]
    )]
    public function __invoke(Request $request): JsonResponse
    {
        $dataGrid = $this->pageDataGrid->setFromRequest($request);

        return new JsonResponse($dataGrid->toArray());
    }
}
