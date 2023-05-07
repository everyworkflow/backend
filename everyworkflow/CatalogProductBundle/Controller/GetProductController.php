<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogProductBundle\Controller;

use EveryWorkflow\CatalogProductBundle\Repository\CatalogProductRepositoryInterface;
use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use MongoDB\BSON\ObjectId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetProductController extends AbstractController
{
    public function __construct(
        protected CatalogProductRepositoryInterface $catalogProductRepository
    ) {
    }

    #[EwRoute(
        path: 'catalog/product/{slug}',
        name: 'catalog.product.view',
        methods: 'GET',
        // permissions: 'catalog.product.view',
        swagger: [
            'tags' => ['catalog_product'],
            'parameters' => [
                [
                    'name' => 'uuid',
                    'in' => 'path',
                    'default' => 'create',
                ],
            ],
        ]
    )]
    public function __invoke(Request $request, string $slug = 'create'): JsonResponse
    {
        $data = [];

        if ('create' !== $slug) {
            $query = [];
            try {
                $query['_id'] = new ObjectId($slug);
            } catch (\Exception $e) {
                $query['url_key'] = $slug;
            }
            $item = $this->catalogProductRepository->findOne($query);
            if ($item) {
                $data['item'] = $item->toArray();
                $data['item']['price_formatted'] = 'Rs. '.number_format($data['item']['price'], 0);
            }
        }

        if ('data-form' === $request->get('for')) {
            $data['data_form'] = $this->catalogProductRepository->getForm()->toArray();
        }

        return new JsonResponse($data);
    }
}
