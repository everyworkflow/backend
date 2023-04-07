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
    public function loadAttributeFields(BaseEntityRepositoryInterface $baseEntityRepository): self
    {
        parent::loadAttributeFields($baseEntityRepository);

        $sections = $this->getSections();
        foreach ($sections as $key => $section) {
            $fields = $section->getFields();

            $fields[] = $this->formFieldFactory->create(
                [
                'label' => 'Parent',
                'name' => 'parent',
                'field_type' => 'tree_select_field',
                'options' => [
                    [
                        'title' => 'Default',
                        'value' => 'default',
                        'children' => $this->getRecursiveTreeOptions($baseEntityRepository),
                    ],
                ],
                'is_default_expand_all' => true,
                'sort_order' => 10,
                ]
            );

            $sections[$key]->setFields($fields);
        }

        return $this;
    }

    protected function getRecursiveTreeOptions(BaseEntityRepositoryInterface $baseEntityRepository, string $parentCode = 'default', array $skipCodes = []): array
    {
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
