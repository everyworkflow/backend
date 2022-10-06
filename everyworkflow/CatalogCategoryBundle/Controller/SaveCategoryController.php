<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogCategoryBundle\Controller;

use EveryWorkflow\CatalogCategoryBundle\Repository\CatalogCategoryRepositoryInterface;
use EveryWorkflow\CatalogProductBundle\Entity\CatalogProductEntityInterface;
use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SaveCategoryController extends AbstractController
{
    protected CatalogCategoryRepositoryInterface $catalogCategoryRepository;

    public function __construct(CatalogCategoryRepositoryInterface $catalogCategoryRepository)
    {
        $this->catalogCategoryRepository = $catalogCategoryRepository;
    }

    #[EwRoute(
        path: "catalog/category/{uuid}",
        name: 'catalog.category.save',
        methods: 'POST',
        permissions: 'catalog.category.save',
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
                                'name' => [
                                    'type' => 'string',
                                    'required' => true,
                                ],
                                'path' => [
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
        $submitData = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        if ('create' === $uuid) {
            /** @var CatalogProductEntityInterface $item */
            $item = $this->catalogCategoryRepository->create($submitData);
        } else {
            $item = $this->catalogCategoryRepository->findById($uuid);
            foreach ($submitData as $key => $val) {
                $item->setData($key, $val);
            }
        }

        $item = $this->catalogCategoryRepository->saveOne($item);

        return new JsonResponse([
            'detail' => 'Successfully saved changes.',
            'item' => $item->toArray(),
        ]);
    }
}
