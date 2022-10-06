<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Controller\Attribute;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\EavBundle\Repository\AttributeRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteAttributeController extends AbstractController
{
    protected AttributeRepositoryInterface $attributeRepository;

    public function __construct(AttributeRepositoryInterface $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    #[EwRoute(
        path: "eav/attribute/{code}",
        name: 'eav.attribute.delete',
        methods: 'DELETE',
        permissions: 'eav.attribute.delete',
        swagger: [
            'parameters' => [
                [
                    'name' => 'code',
                    'in' => 'path',
                ]
            ]
        ]
    )]
    public function __invoke(string $code): JsonResponse
    {
        try {
            $this->attributeRepository->deleteOneByFilter(['code' => $code]);
            return new JsonResponse(['detail' => 'Attribute with code: ' . $code . ' deleted successfully.']);
        } catch (\Exception $e) {
            return new JsonResponse(['detail' => $e->getMessage()], 500);
        }
    }
}
