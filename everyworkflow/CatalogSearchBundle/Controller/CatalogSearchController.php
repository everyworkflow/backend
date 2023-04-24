<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogSearchBundle\Controller;

use EveryWorkflow\CatalogCategoryBundle\Repository\CatalogCategoryRepositoryInterface;
use EveryWorkflow\CatalogProductBundle\Repository\CatalogProductRepositoryInterface;
use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CatalogSearchController extends AbstractController
{
    public function __construct(
        protected CatalogCategoryRepositoryInterface $catalogCategoryRepository,
        protected CatalogProductRepositoryInterface $catalogProductRepository
    ) {
    }

    #[EwRoute(
        path: 'catalog/search/{categoryCode}',
        name: 'catalog.search',
        priority: 10,
        methods: 'GET',
        swagger: true
    )]
    public function __invoke(Request $request, string $categoryCode = ''): JsonResponse
    {
        $attributes = $this->catalogProductRepository->getAttributes();

        $matchQuery = [
            'status' => 'enable',
        ];
        if ('' !== $categoryCode) {
            $matchQuery['category'] = $categoryCode;
        }

        $params = $request->query->all();
        $perPage = $params['per-page'] ?? 24;
        $perPage = (int) $perPage;
        if ($perPage < 24 || $perPage > 240) {
            $currentPage = 24;
        }
        $currentPage = $params['page'] ?? 1;
        $currentPage = (int) $currentPage;
        if ($currentPage < 1) {
            $currentPage = 1;
        }
        $skip = $perPage * ($currentPage - 1);

        $pipeline = [
            [
                '$match' => $matchQuery,
            ],
            [
                '$facet' => [
                    'items' => [
                        [
                            '$unset' => ['flag'],
                        ],
                        [
                            '$skip' => $skip,
                        ],
                        [
                            '$limit' => $perPage,
                        ],
                    ],
                    'meta_data' => [
                        [
                            '$group' => [
                                '_id' => null,
                                'total_count' => [
                                    '$sum' => 1,
                                ],
                                'max_price' => [
                                    '$max' => '$price',
                                ],
                                'min_price' => [
                                    '$min' => '$price',
                                ],
                                'category' => [
                                    '$addToSet' => '$category',
                                ],
                                'color' => [
                                    '$addToSet' => '$color',
                                ],
                                'size' => [
                                    '$addToSet' => '$size',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $result = $this->catalogProductRepository->getCollection()->aggregate($pipeline);
        $resultData = [];
        foreach ($result as $item) {
            $resultData = $this->catalogProductRepository->mapDocumentToArray($item);
            break;
        }

        $totalCount = $resultData['meta_data'][0]['total_count'] ?? 1;
        $resultItems = $resultData['items'] ?? [];

        foreach ($resultItems as &$item) {
            $item['price_formatted'] = 'Rs. '.number_format($item['price'], 0);
        }

        $resultItemCount = count($resultItems);
        $lastPage = ceil($totalCount / $perPage);
        $data = [
            'data_collection' => [
                'meta' => [
                    'current_page' => $currentPage,
                    'from' => $skip,
                    'last_page' => $lastPage,
                    'per_page' => $perPage,
                    'result_count' => $resultItemCount,
                    'to' => $skip + $resultItemCount,
                    'total_count' => $totalCount,
                ],
                'results' => $resultItems,
            ],
            'child_category' => [],
            'filter_attributes' => [],
        ];

        $data['child_category'] = [
            'label' => 'Category',
            'code' => 'category',
            'type' => 'category_attribute',
            'entity_code' => 'product',
            'sort_order' => 1,
            'options' => [],
        ];

        if (isset($resultData['meta_data'][0]['category'])) {
            $categoryCodeList = $resultData['meta_data'][0]['category'] ?? [];

            // TODO: Remove below _debug_category_code_list after stable
            $data['child_category']['_debug_category_code_list'] = $categoryCodeList;

            $categoryResult = $this->catalogCategoryRepository->find([
                'code' => ['$in' => $categoryCodeList],
            ]);
            $options = [];
            foreach ($categoryResult as $category) {
                $options[] = [
                    'label' => $category->getData('name'),
                    'code' => $category->getData('code'),
                ];
            }
            $data['child_category']['options'] = $options;
        }

        foreach ($attributes as $attribute) {
            if ('price' === $attribute->getCode()) {
                $attributeData = [
                    'label' => $attribute->getName(),
                    'code' => $attribute->getCode(),
                    'type' => $attribute->getType(),
                    'entity_code' => $attribute->getEntityCode(),
                    'sort_order' => $attribute->getSortOrder(),
                    'min_price' => $resultData['meta_data'][0]['min_price'] ?? 0,
                    'max_price' => $resultData['meta_data'][0]['max_price'] ?? 0,
                ];
                $data['filter_attributes'][] = $attributeData;
            } elseif (isset($resultData['meta_data'][0][$attribute->getCode()])) {
                $attributeData = [
                    'label' => $attribute->getName(),
                    'code' => $attribute->getCode(),
                    'type' => $attribute->getType(),
                    'entity_code' => $attribute->getEntityCode(),
                    'sort_order' => $attribute->getSortOrder(),
                ];
                if ('select_attribute' === $attribute->getType()) {
                    $options = [];
                    if (is_array($resultData['meta_data'][0][$attribute->getCode()])) {
                        $attributeOptions = $attribute->getData('options');
                        $attributeOptions = array_column($attributeOptions, null, 'code');

                        if (is_array($resultData['meta_data'][0][$attribute->getCode()])) {
                            foreach ($resultData['meta_data'][0][$attribute->getCode()] as $optionCode) {
                                if (isset($attributeOptions[$optionCode])) {
                                    $options[] = $attributeOptions[$optionCode];
                                }
                            }
                        }
                    }
                    $attributeData['options'] = $options;
                }
                $data['filter_attributes'][] = $attributeData;
            }
        }

        return new JsonResponse($data);
    }
}
