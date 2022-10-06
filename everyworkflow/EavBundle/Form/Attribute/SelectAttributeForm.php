<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Form\Attribute;

use EveryWorkflow\EavBundle\Form\AttributeForm;

class SelectAttributeForm extends AttributeForm implements SelectAttributeFormInterface
{
    /**
     * @return BaseSectionInterface[]
     */
    public function getSections(): array
    {
        $sections = [
            $this->getFormSectionFactory()->create([
                'section_type' => 'card_section',
                'code' => 'attribute_select_options',
                'title' => 'Options',
                'sort_order' => 8000,
            ]),
            $this->getFormSectionFactory()->create([
                'section_type' => 'card_section',
                'code' => 'form_field',
                'title' => 'Form field',
                'sort_order' => 10000,
            ])->setFields([
                $this->formFieldFactory->create([
                    'label' => 'Is searchable',
                    'name' => 'is_searchable',
                    'field_type' => 'switch_field',
                ]),
            ]),
        ];
        return array_merge(parent::getSections(), $sections);
    }

    public function toArray(): array
    {
        $this->dataObject->setDataIfNot(self::KEY_IS_SIDE_FORM_ANCHOR_ENABLE, true);
        return parent::toArray();
    }
}
