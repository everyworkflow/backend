<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Form\Block;

class ImageBlockForm extends AbstractBlockForm implements ImageBlockFormInterface
{
    public function getFields(): array
    {
        $fields = [
            $this->formFieldFactory->create([
                'label' => 'Image',
                'name' => 'image',
                'field_type' => 'media_image_selector_field',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Use image dark',
                'name' => 'use_image_dark',
                'field_type' => 'switch_field',
                'default_value' => 0,
                'is_actionable' => true,
                'field_actions' => [
                    [
                        [
                            'action_type' => 'hide_field',
                            'field_names' => ['image_dark']
                        ]
                    ],
                    [
                        [
                            'action_type' => 'show_field',
                            'field_names' => ['image_dark']
                        ]
                    ],
                ],
            ]),
            $this->formFieldFactory->create([
                'label' => 'Image dark',
                'name' => 'image_dark',
                'field_type' => 'media_image_selector_field',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Preview',
                'name' => 'preview',
                'field_type' => 'switch_field',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Alt text',
                'name' => 'alt',
                'field_type' => 'text_field',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Height',
                'name' => 'height',
                'field_type' => 'text_field',
                'input_type' => 'number',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Width',
                'name' => 'width',
                'field_type' => 'text_field',
                'input_type' => 'number',
            ]),
        ];

        return array_merge($fields, parent::getFields());
    }
}
