<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Controller\Entity;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\EavBundle\Repository\AttributeRepositoryInterface;
use EveryWorkflow\EavBundle\Repository\EntityRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteEntityController extends AbstractController
{
    public function __construct(
        protected EntityRepositoryInterface $entityRepository,
        protected AttributeRepositoryInterface $attributeRepository
    ) {
    }

    #[EwRoute(
        path: 'eav/entity/{code}',
        name: 'eav.entity.delete',
        methods: 'DELETE',
        permissions: 'eav.entity.delete',
        swagger: [
            'tags' => ['eav_entity'],
            'parameters' => [
                [
                    'name' => 'code',
                    'in' => 'path',
                ],
            ],
        ]
    )]
    public function __invoke(string $code): JsonResponse
    {
        try {
            $this->entityRepository->deleteOneByFilter(['code' => $code]);
            $this->attributeRepository->deleteByFilter(['entity_code' => $code]);

            return new JsonResponse(['detail' => 'Entity with code: ' . $code . ' deleted successfully.']);
        } catch (\Exception $e) {
            return new JsonResponse(['detail' => $e->getMessage()], 500);
        }
    }
}
