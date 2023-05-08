<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SwaggerBundle\Model\Swagger;

use EveryWorkflow\EavBundle\Repository\AttributeGroupRepositoryInterface;
use EveryWorkflow\EavBundle\Repository\AttributeRepositoryInterface;
use EveryWorkflow\EavBundle\Repository\EntityRepositoryInterface;
use EveryWorkflow\SwaggerBundle\Model\SwaggerData;

class ComponentGenerator implements ComponentGeneratorInterface
{
    public function __construct(
        protected EntityRepositoryInterface $entityRepository,
        protected AttributeRepositoryInterface $attributeRepository,
        protected AttributeGroupRepositoryInterface $attributeGroupRepository
    ) {
    }

    public function generate(SwaggerData $swaggerData): SwaggerData
    {
        $components = $swaggerData->getComponents();
        $components['schemas'] = $components['schemas'] ?? [];

        $entities = $this->entityRepository->find();

        $attributeList = [];
        $attributes = $this->attributeRepository->find();
        foreach ($attributes as $attribute) {
            $attributeList[$attribute->getData('entity_code')][$attribute->getData('code')] = $attribute;
        }

        $attributeGroupList = [];
        $attributeGroups = $this->attributeGroupRepository->find();
        foreach ($attributeGroups as $attributeGroup) {
            $attributeGroupList[$attributeGroup->getData('entity_code')][$attributeGroup->getData('code')] = $attributeGroup;
        }

        foreach ($entities as $entity) {
            $entityCode = $entity->getData('code') ?? null;
            if ($entityCode && $attributeList[$entityCode]) {
                if (isset($attributeGroupList[$entityCode]) && is_array($attributeGroupList[$entityCode])) {
                    $parentModelData = [
                        'type' => 'object',
                        'oneOf' => [],
                    ];
                    foreach ($attributeGroupList[$entityCode] as $attributeGroup) {
                        $modelData = [
                            'type' => 'object',
                            'oneOf' => [],
                            'properties' => [],
                        ];
                        $attributeGroupData = $attributeGroup->getData('attribute_group_data') ?? [];
                        foreach ($attributeGroupData as $attributeGroupDataItem) {
                            if (isset($attributeGroupDataItem['attributes']) && is_array($attributeGroupDataItem['attributes'])) {
                                foreach ($attributeGroupDataItem['attributes'] as $attributeCode) {
                                    if (isset($attributeList[$entityCode][$attributeCode])) {
                                        $attribute = $attributeList[$entityCode][$attributeCode];
                                        $attributeDefaultVal = $attribute->getData('default_value') ?? '';
                                        $modelData['properties'][$attributeCode] = [
                                            'default' => $attributeDefaultVal,
                                            'type' => 'string',
                                        ];
                                    }
                                }
                            }
                        }
                        $components['schemas'][$entityCode.'_'.$attributeGroup->getData('code')] = $modelData;
                        $parentModelData['oneOf'][] = [
                            'type' => 'object',
                            '$ref' => '#/components/schemas/'.$entityCode.'_'.$attributeGroup->getData('code'),
                        ];
                    }
                    $components['schemas'][$entityCode] = $parentModelData;
                } else {
                    $modelData = [
                        'type' => 'object',
                        'properties' => [],
                    ];
                    foreach ($attributeList[$entityCode] as $attribute) {
                        $modelData['properties'][$attribute->getData('code')] = [
                            'default' => $attribute->getData('default_value') ?? '',
                            'type' => 'string',
                        ];
                    }
                    $components['schemas'][$entityCode] = $modelData;
                }
            }
        }

        ksort($components['schemas']);
        $swaggerData->setComponents($components);

        return $swaggerData;
    }
}
