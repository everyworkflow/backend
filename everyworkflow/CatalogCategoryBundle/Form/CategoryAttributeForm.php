<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogCategoryBundle\Form;

use EveryWorkflow\EavBundle\Form\EntityAttributeForm;
use EveryWorkflow\EavBundle\Repository\BaseEntityRepositoryInterface;

class CategoryAttributeForm extends EntityAttributeForm implements CategoryAttributeFormInterface
{
    public function loadAttributeFields(
        BaseEntityRepositoryInterface $baseEntityRepository,
        string $attributeGroupCode = 'default'
    ): self {
        parent::loadAttributeFields($baseEntityRepository);

        $sections = $this->getSections();
        foreach ($sections as $key => $section) {
            $fields = $section->getFields();

            foreach ($fields as $fKey => $field) {
                if ('parent' === $field->getName()) {
                    $fieldData = $field->toArray();
                    $fieldData['field_type'] = 'tree_select_field';
                    $fieldData['options'] = [
                            [
                                'title' => 'Default',
                                'value' => '---',
                                'children' => $this->getRecursiveTreeOptions($baseEntityRepository),
                            ],
                        ];
                    $fieldData['is_default_expand_all'] = true;
                    $fields[$fKey] = $this->formFieldFactory->create($fieldData);
                }
            }

            $sections[$key]->setFields($fields);
        }

        return $this;
    }

    protected function getRecursiveTreeOptions(
        BaseEntityRepositoryInterface $baseEntityRepository,
        string $parentCode = '---',
        array $skipCodes = []
    ): array {
        $itemList = [];
        $items = $baseEntityRepository->find(['parent' => $parentCode]);
        foreach ($items as $item) {
            $currentCode = $item->getData('code');
            if ($currentCode && !in_array($currentCode, $skipCodes, true)) {
                $itemList[] = [
                    'title' => $item->getData('name'),
                    'value' => $currentCode,
                    'children' => $this->getRecursiveTreeOptions($baseEntityRepository, $currentCode, $skipCodes),
                ];
            }
        }

        return $itemList;
    }
}
