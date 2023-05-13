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
                'code' => 'form_field',
                'title' => 'Form field',
                'sort_order' => 8000,
            ])->setFields([
                $this->formFieldFactory->create([
                    'label' => 'Is searchable',
                    'name' => 'is_searchable',
                    'field_type' => 'switch_field',
                ]),
                $this->formFieldFactory->create([
                    'label' => 'Attribute option type',
                    'name' => 'attribute_option_type',
                    'field_type' => 'select_field',
                    'options' => [
                        [
                            'key' => '',
                            'value' => 'No swatch',
                        ],
                        [
                            'key' => 'text_swatch',
                            'value' => 'Text swatch',
                        ],
                        [
                            'key' => 'color_swatch',
                            'value' => 'Color swatch',
                        ],
                        [
                            'key' => 'image_swatch',
                            'value' => 'Image swatch',
                        ],
                        [
                            'key' => 'option_wise_swatch',
                            'value' => 'Option wise swatch',
                        ],
                    ],
                ]),
            ]),
            $this->getFormSectionFactory()->create([
                'section_type' => 'card_section',
                'code' => 'attribute_select_options',
                'title' => 'Options',
                'sort_order' => 10000,
            ]),
        ];

        return array_merge(parent::getSections(), $sections);
    }
}
