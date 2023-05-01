<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Repository\HelperTrait;

use EveryWorkflow\EavBundle\Repository\BaseEntityRepositoryInterface;

trait AttributeGroupHelperTrait
{
    protected $entityAttributeGroups = [];

    public function getAttributeGroups(): array
    {
        if (!$this->entityAttributeGroups && $this instanceof BaseEntityRepositoryInterface) {
            $attributeGroups = $this->attributeGroupRepository->find(['entity_code' => $this->getEntityCode()]);
            foreach ($attributeGroups as $attributeGroup) {
                $this->entityAttributeGroups[$attributeGroup->getData('code')] = $attributeGroup;
            }
        }

        return $this->entityAttributeGroups;
    }

    public function getAttributeDataByGroupCode(string $groupCode): ?array
    {
        $attributeGroups = $this->getAttributeGroups();
        if ($this instanceof BaseEntityRepositoryInterface && isset($attributeGroups[$groupCode])) {
            $attributeGroup = $attributeGroups[$groupCode];
            $attributes = $this->getAttributes();

            $allUsedAttributeCodes = [];
            $attributeGroupData = $attributeGroup->getData('attribute_group_data');
            foreach ($attributeGroupData as $section) {
                if (isset($section['attributes']) && is_array($section['attributes'])) {
                    foreach ($section['attributes'] as $attributeCode) {
                        $allUsedAttributeCodes[$attributeCode] = $attributeCode;
                    }
                }
            }

            $usedAttributed = [];
            foreach ($allUsedAttributeCodes as $attributeCode) {
                if (isset($attributes[$attributeCode])) {
                    $usedAttributed[$attributeCode] = $attributes[$attributeCode];
                }
            }

            return [
                'attribute_group' => $attributeGroup,
                'attributes' => $attributes,
            ];
        }

        return null;
    }

    public function getFormByGroupCode(string $groupCode): array
    {
        return $this->entityAttributeForm->loadAttributeFields($this, $groupCode);
    }
}
