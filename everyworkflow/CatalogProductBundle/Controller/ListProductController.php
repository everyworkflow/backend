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
        $filterBuilderData = json_decode($request->get('filter_builder_data') ?? '', true);

        $dataGrid = $this->catalogProductDataGrid->setFromRequest($request);

        if ($filterBuilderData) {
            $filters = $this->getFilterFromBuilderData($filterBuilderData);
            $dataGrid->setFilters($filters);
        }

        return new JsonResponse($dataGrid->toArray());
    }

    protected function getFilterFromBuilderData(array $filterBuilderData): array
    {

        if (isset($filterBuilderData['or']) && is_array($filterBuilderData['or'])) {
            $conditions = [];
            foreach ($filterBuilderData['or'] as $item) {
                $conditions[] = $this->getFilterFromBuilderData($item);
            }
            unset($filterBuilderData['or']);
            $filterBuilderData['$or'] = $conditions;
        }

        if (isset($filterBuilderData['and']) && is_array($filterBuilderData['and'])) {
            $conditions = [];
            foreach ($filterBuilderData['and'] as $item) {
                $conditions[] = $this->getFilterFromBuilderData($item);
            }
            unset($filterBuilderData['and']);
            $filterBuilderData['$and'] = $conditions;
        }

        if (isset($filterBuilderData['attributes']) && is_array($filterBuilderData['attributes'])) {
            foreach ($filterBuilderData['attributes'] as $attr) {
                if (isset($attr['attribute_code'])) {
                    $option = $attr['option'] ?? 'exists';
                    $value = $attr['value'] ?? '';

                    $filter = [];

                    switch ($option) {
                        case 'exists': {
                            $filter = ['$exists' => true];
                            break;
                        }
                        case 'does_not_exists': {
                            $filter = ['$exists' => false];
                            break;
                        }
                        case 'eq': {
                            $filter = ['$eq' => $value];
                            break;
                        }
                        case 'nq': {
                            $filter = ['$nq' => $value];
                            break;
                        }
                        case 'in': {
                            $values = explode(',', $value);
                            $filter = ['$in' => $values];
                            break;
                        }
                        case 'nin': {
                            $values = explode(',', $value);
                            $filter = ['$nin' => $values];
                            break;
                        }
                        case 'gt': {
                            $filter = ['$gt' => $value];
                            break;
                        }
                        case 'gte': {
                            $filter = ['$gte' => $value];
                            break;
                        }
                        case 'lt': {
                            $filter = ['$lt' => $value];
                            break;
                        }
                        case 'lte': {
                            $filter = ['$lte' => $value];
                            break;
                        }
                        case 'regex': {
                            $filter = ['$regex' => $value];
                            break;
                        }
                        default: {
                            $filter = ['$exists' => true];
                        }
                    }

                    $filterBuilderData[$attr['attribute_code']] = $filter;
                }
            }
            unset($filterBuilderData['attributes']);
        }

        return $filterBuilderData;
    }
}
