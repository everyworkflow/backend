<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogProductBundle\Controller;

use EveryWorkflow\CatalogProductBundle\Repository\CatalogProductRepositoryInterface;
use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteProductController extends AbstractController
{
    public function __construct(
        protected CatalogProductRepositoryInterface $catalogProductRepository
    ) {
    }

    #[EwRoute(
        path: 'catalog/product/{uuid}',
        name: 'catalog.product.delete',
        methods: 'DELETE',
        permissions: 'catalog.product.delete',
        swagger: [
            'tags' => ['catalog_product'],
            'parameters' => [
                [
                    'name' => 'uuid',
                    'in' => 'path',
                ],
            ],
        ]
    )]
    public function __invoke(string $uuid): JsonResponse
    {
        try {
            $this->catalogProductRepository->deleteOneByFilter(['_id' => new \MongoDB\BSON\ObjectId($uuid)]);

            return new JsonResponse(['detail' => 'ID: '.$uuid.' deleted successfully.']);
        } catch (\Exception $e) {
            return new JsonResponse(['detail' => $e->getMessage()], 500);
        }
    }
}
