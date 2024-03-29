<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Controller\Attribute;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\EavBundle\Factory\AttributeFieldFactoryInterface;
use EveryWorkflow\EavBundle\Repository\AttributeRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class AttributeTypeController extends AbstractController
{
    public function __construct(
        protected AttributeRepositoryInterface $attributeRepository,
        protected AttributeFieldFactoryInterface $attributeFieldFactory
    ) {
    }

    #[EwRoute(
        path: 'eav/attribute-type',
        name: 'eav.attribute_type',
        priority: 10,
        methods: 'GET',
        swagger: [
            'tags' => ['eav_attribute'],
        ]
    )]
    public function __invoke(): JsonResponse
    {
        $fields = [];
        $attributes = $this->attributeRepository->find(['entity_code' => 'user']);
        foreach ($attributes as $attribute) {
            $fields[] = $this->attributeFieldFactory->createFromAttribute($attribute)->toArray();
        }

        return new JsonResponse($fields);
    }
}
