<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogProductBundle\Controller;

use EveryWorkflow\CatalogProductBundle\DataGrid\CatalogProductDataGridInterface;
use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ListProductController extends AbstractController
{
    public function __construct(
        protected CatalogProductDataGridInterface $catalogProductDataGrid
    ) {
    }

    #[EwRoute(
        path: 'catalog/product',
        name: 'catalog.product',
        priority: 10,
        methods: 'GET',
        permissions: 'catalog.product.list',
        swagger: true
    )]
    public function __invoke(Request $request): JsonResponse
    {
        $dataGrid = $this->catalogProductDataGrid->setFromRequest($request);

        return new JsonResponse($dataGrid->toArray());
    }
}
