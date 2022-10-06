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
use Symfony\Component\HttpFoundation\Request;

class GetProductController extends AbstractController
{
    protected CatalogProductRepositoryInterface $catalogProductRepository;

    public function __construct(CatalogProductRepositoryInterface $catalogProductRepository)
    {
        $this->catalogProductRepository = $catalogProductRepository;
    }

    #[EwRoute(
        path: "catalog/product/{uuid}",
        name: 'catalog.product.view',
        methods: 'GET',
        permissions: 'catalog.product.view',
        swagger: [
            'parameters' => [
                [
                    'name' => 'uuid',
                    'in' => 'path',
                    'default' => 'create',
                ]
            ]
        ]
    )]
    public function __invoke(Request $request, string $uuid = 'create'): JsonResponse
    {
        $data = [];

        if ($uuid !== 'create') {
            $item = $this->catalogProductRepository->findById($uuid);
            if ($item) {
                $data['item'] = $item->toArray();
            }
        }

        if ($request->get('for') === 'data-form') {
            $data['data_form'] = $this->catalogProductRepository->getForm()->toArray();
        }

        return new JsonResponse($data);
    }
}
