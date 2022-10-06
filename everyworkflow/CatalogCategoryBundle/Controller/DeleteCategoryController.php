<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogCategoryBundle\Controller;

use EveryWorkflow\CatalogCategoryBundle\Repository\CatalogCategoryRepositoryInterface;
use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteCategoryController extends AbstractController
{
    protected CatalogCategoryRepositoryInterface $catalogCategoryRepository;

    public function __construct(CatalogCategoryRepositoryInterface $catalogCategoryRepository)
    {
        $this->catalogCategoryRepository = $catalogCategoryRepository;
    }

    #[EwRoute(
        path: "catalog/category/{uuid}",
        name: 'catalog.category.delete',
        methods: 'DELETE',
        permissions: 'catalog.category.delete',
        swagger: [
            'parameters' => [
                [
                    'name' => 'uuid',
                    'in' => 'path',
                ]
            ]
        ]
    )]
    public function __invoke(string $uuid): JsonResponse
    {
        try {
            $this->catalogCategoryRepository->deleteOneByFilter(['_id' => new \MongoDB\BSON\ObjectId($uuid)]);
            return new JsonResponse(['detail' => 'ID: ' . $uuid . ' deleted successfully.']);
        } catch (\Exception $e) {
            return new JsonResponse(['detail' => $e->getMessage()], 500);
        }
    }
}
