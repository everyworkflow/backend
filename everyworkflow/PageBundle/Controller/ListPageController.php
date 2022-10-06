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
    protected PageDataGridInterface $pageDataGrid;

    public function __construct(
        PageDataGridInterface $pageDataGrid
    ) {
        $this->pageDataGrid = $pageDataGrid;
    }

    #[EwRoute(
        path: "cms/page",
        name: 'cms.page',
        priority: 10,
        methods: 'GET',
        permissions: 'cms.page.list',
        swagger: true
    )]
    public function __invoke(Request $request): JsonResponse
    {
        $dataGrid = $this->pageDataGrid->setFromRequest($request);

        return new JsonResponse($dataGrid->toArray());
    }
}
