<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogCategoryBundle\Controller;

use EveryWorkflow\CatalogCategoryBundle\DataGrid\CatalogCategoryDataGridInterface;
use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ListCategoryController extends AbstractController
{
    public function __construct(
        protected CatalogCategoryDataGridInterface $catalogCategoryDataGrid
    ) {
    }

    #[EwRoute(
        path: 'catalog/category',
        name: 'catalog.category',
        priority: 10,
        methods: 'GET',
        permissions: 'catalog.category.list',
        swagger: [
            'tags' => ['catalog_category'],
        ]
    )]
    public function __invoke(Request $request): JsonResponse
    {
        $dataGrid = $this->catalogCategoryDataGrid->setFromRequest($request);

        return new JsonResponse($dataGrid->toArray());
    }
}
