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
    protected AttributeRepositoryInterface $attributeRepository;
    protected AttributeFieldFactoryInterface $attributeFieldFactory;

    public function __construct(
        AttributeRepositoryInterface $attributeRepository,
        AttributeFieldFactoryInterface $attributeFieldFactory
    ) {
        $this->attributeRepository = $attributeRepository;
        $this->attributeFieldFactory = $attributeFieldFactory;
    }

    #[EwRoute(
        path: "eav/attribute-type",
        name: 'eav.attribute_type',
        priority: 10,
        methods: 'GET',
        swagger: true
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
