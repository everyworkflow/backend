<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogProductBundle\Controller;

use EveryWorkflow\CatalogProductBundle\Entity\CatalogProductEntityInterface;
use EveryWorkflow\CatalogProductBundle\Repository\CatalogProductRepositoryInterface;
use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SaveProductController extends AbstractController
{
    protected CatalogProductRepositoryInterface $catalogProductRepository;

    public function __construct(CatalogProductRepositoryInterface $catalogProductRepository)
    {
        $this->catalogProductRepository = $catalogProductRepository;
    }

    #[EwRoute(
        path: "catalog/product/{uuid}",
        name: 'catalog.product.save',
        methods: 'POST',
        permissions: 'catalog.product.save',
        swagger: [
            'parameters' => [
                [
                    'name' => 'uuid',
                    'in' => 'path',
                    'default' => 'create',
                ]
            ],
            'requestBody' => [
                'content' => [
                    'application/json' => [
                        'schema' => [
                            'properties' => [
                                'sku' => [
                                    'type' => 'string',
                                    'required' => true,
                                ],
                                'name' => [
                                    'type' => 'string',
                                    'required' => true,
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    )]
    public function __invoke(Request $request, string $uuid = 'create'): JsonResponse
    {
        $submitData = $request->toArray();
        if ('create' === $uuid) {
            /** @var CatalogProductEntityInterface $item */
            $item = $this->catalogProductRepository->create($submitData);
        } else {
            $item = $this->catalogProductRepository->findById($uuid);
            foreach ($submitData as $key => $val) {
                $item->setData($key, $val);
            }
            
        }

        $item = $this->catalogProductRepository->saveOne($item);

        return new JsonResponse([
            'detail' => 'Successfully saved changes.',
            'item' => $item->toArray(),
        ]);
    }
}
