<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Form\Attribute;

use EveryWorkflow\EavBundle\Form\AttributeForm;

class TextAttributeForm extends AttributeForm implements TextAttributeFormInterface
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
                    'label' => 'Input type',
                    'name' => 'input_type',
                    'field_type' => 'select_field',
                    'default' => 'text',
                    'options' => [
                        [
                            'key' => 'text',
                            'value' => 'Text',
                        ],
                        [
                            'key' => 'email',
                            'value' => 'Email',
                        ],
                        [
                            'key' => 'password',
                            'value' => 'Password',
                        ],
                        [
                            'key' => 'number',
                            'value' => 'Number',
                        ],
                    ],
                ]),
                $this->formFieldFactory->create([
                    'label' => 'Min length',
                    'name' => 'min_lenght',
                    'field_type' => 'text_field',
                ]),
                $this->formFieldFactory->create([
                    'label' => 'Max length',
                    'name' => 'max_lenght',
                    'field_type' => 'text_field',
                ]),
                $this->formFieldFactory->create([
                    'label' => 'Validation pattern',
                    'name' => 'pattern',
                    'field_type' => 'text_field',
                ]),
                $this->formFieldFactory->create([
                    'label' => 'Prefix tab text',
                    'name' => 'prefix_tab_text',
                    'field_type' => 'text_field',
                ]),
                $this->formFieldFactory->create([
                    'label' => 'Suffix tab text',
                    'name' => 'suffix_tab_text',
                    'field_type' => 'text_field',
                ]),
                $this->formFieldFactory->create([
                    'label' => 'Prefix text',
                    'name' => 'prefix_text',
                    'field_type' => 'text_field',
                ]),
                $this->formFieldFactory->create([
                    'label' => 'Suffix text',
                    'name' => 'suffix_text',
                    'field_type' => 'text_field',
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
