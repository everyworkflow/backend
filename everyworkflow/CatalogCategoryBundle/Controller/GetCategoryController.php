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
use Symfony\Component\HttpFoundation\Request;

class GetCategoryController extends AbstractController
{
    public function __construct(
        protected CatalogCategoryRepositoryInterface $catalogCategoryRepository
    ) {
    }

    #[EwRoute(
        path: 'catalog/category/{uuid}',
        name: 'catalog.category.view',
        methods: 'GET',
        permissions: 'catalog.category.view',
        swagger: [
            'parameters' => [
                [
                    'name' => 'uuid',
                    'in' => 'path',
                    'default' => 'create',
                ],
            ],
        ]
    )]
    public function __invoke(Request $request, string $uuid = 'create'): JsonResponse
    {
        $data = [];

        if ('create' !== $uuid) {
            $item = $this->catalogCategoryRepository->findById($uuid);
            if ($item) {
                $data['item'] = $item->toArray();
            }
        }

        if ('data-form' === $request->get('for')) {
            $data['data_form'] = $this->catalogCategoryRepository->getForm()->toArray();
        }

        return new JsonResponse($data);
    }
}
