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
        swagger: [
            'tags' => ['catalog'],
            'parameters' => [
                [
                    'name' => 'categoryCode',
                    'in' => 'path',
                    'default' => '',
                ],
            ],
        ]
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

        $filterQuery = [];
        $filter = [];
        if (isset($params['filter']) && is_string($params['filter'])) {
            try {
                $filter = json_decode($params['filter'], true);
            } catch (\Exception $e) {
            }
            if (!is_array($filter)) {
                $filter = [];
            }
        }
        foreach ($filter as $key => $val) {
            if ('price' === $key && is_array($val) && 2 === count($val)) {
                $filterQuery[$key] = ['$gte' => $val[0], '$lte' => $val[1]];
            } elseif (is_string($val) && '' !== $val && 'undefined' !== $val && 'null' !== $val) {
                $filterQuery[$key] = $val;
            } elseif (is_array($val) && count($val) > 0) {
                $filterQuery[$key] = ['$in' => $val];
            }
        }

        $perPage = $params['per-page'] ?? 25;
        $perPage = (int) $perPage;
        if ($perPage < 25 || $perPage > 200) {
            $currentPage = 25;
        }
        $currentPage = $params['page'] ?? 1;
        $currentPage = (int) $currentPage;
        if ($currentPage < 1) {
            $currentPage = 1;
        }
        $skip = $perPage * ($currentPage - 1);

        $itemsPipline = [];
        if (count($filterQuery)) {
            $itemsPipline[] = [
                '$match' => $filterQuery,
            ];
        }
        $itemsPipline[] = [
            '$unset' => ['flags'],
        ];
        $itemsPipline[] = [
            '$skip' => $skip,
        ];
        $itemsPipline[] = [
            '$limit' => $perPage,
        ];

        $metaDataPipline = [];
        if (count($filterQuery)) {
            $metaDataPipline[] = [
                '$match' => $filterQuery,
            ];
        }
        $metaDataPipline[] = [
            '$group' => [
                '_id' => null,
                'total_count' => [
                    '$sum' => 1,
                ],
            ],
        ];

        $pipeline = [
            [
                '$match' => $matchQuery,
            ],
            [
                '$facet' => [
                    'items' => $itemsPipline,
                    'meta_data' => $metaDataPipline,
                    'attribute_data' => [
                        [
                            '$group' => [
                                '_id' => null,

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

        if (isset($resultData['attribute_data'][0]['category'])) {
            $categoryCodeList = $resultData['attribute_data'][0]['category'] ?? [];

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
                    'min_price' => $resultData['attribute_data'][0]['min_price'] ?? 0,
                    'max_price' => $resultData['attribute_data'][0]['max_price'] ?? 0,
                ];
                $data['filter_attributes'][] = $attributeData;
            } elseif (isset($resultData['attribute_data'][0][$attribute->getCode()])) {
                $attributeData = [
                    'label' => $attribute->getName(),
                    'code' => $attribute->getCode(),
                    'type' => $attribute->getType(),
                    'entity_code' => $attribute->getEntityCode(),
                    'sort_order' => $attribute->getSortOrder(),
                ];
                if ('select_attribute' === $attribute->getType()) {
                    $options = [];
                    if (is_array($resultData['attribute_data'][0][$attribute->getCode()])) {
                        $attributeOptions = $attribute->getData('options');
                        $attributeOptions = array_column($attributeOptions, null, 'code');

                        if (is_array($resultData['attribute_data'][0][$attribute->getCode()])) {
                            foreach ($resultData['attribute_data'][0][$attribute->getCode()] as $optionCode) {
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
