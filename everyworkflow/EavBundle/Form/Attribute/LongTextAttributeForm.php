<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Form\Attribute;

use EveryWorkflow\EavBundle\Form\AttributeForm;

class LongTextAttributeForm extends AttributeForm implements LongTextAttributeFormInterface
{
    /**
     * @return BaseSectionInterface[]
     */
    public function getSections(): array
    {
        $sections = [
            $this->getFormSectionFactory()->create([
                'section_type' => 'card_section',
                'code' => 'form_field',
                'title' => 'Form Field',
                'sort_order' => 10000,
            ])->setFields([
                $this->formFieldFactory->create([
                    'label' => 'Field type',
                    'name' => 'field_type',
                    'field_type' => 'select_field',
                    'default' => 'text',
                    'options' => [
                        [
                            'key' => 'textarea_field',
                            'value' => 'Textarea field',
                        ],
                        [
                            'key' => 'markdown_field',
                            'value' => 'Markdown field',
                        ],
                        [
                            'key' => 'wysiwyg_field',
                            'value' => 'Wysiwyg field',
                        ],
                    ],
                ]),
                $this->formFieldFactory->create([
                    'label' => 'Row count',
                    'name' => 'row_count',
                    'field_type' => 'text_field',
                    'input_type' => 'number',
                    'default' => '5'
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
