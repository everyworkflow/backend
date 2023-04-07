<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Form\Block;

use EveryWorkflow\DataFormBundle\Field\Select\Option;

class ContainerBlockForm extends AbstractBlockForm implements ContainerBlockFormInterface
{
    public function getFields(): array
    {
        $fields = [
            $this->formFieldFactory->create([
                'label' => 'Container type',
                'name' => 'container_type',
                'field_type' => 'select_field',
                'options' => [
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => '',
                        'value' => 'Default',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'full-width',
                        'value' => 'Full width',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'container-center',
                        'value' => 'Container center',
                    ]),
                ],
            ]),
            $this->formFieldFactory->create([
                'label' => 'Content JSX style',
                'name' => 'content_style',
                'field_type' => 'textarea_field',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Use Content JSX style dark',
                'name' => 'use_content_style_dark',
                'field_type' => 'switch_field',
                'default_value' => 0,
                'is_actionable' => true,
                'field_actions' => [
                    [
                        [
                            'action_type' => 'hide_field',
                            'field_names' => ['content_style_dark']
                        ]
                    ],
                    [
                        [
                            'action_type' => 'show_field',
                            'field_names' => ['content_style_dark']
                        ]
                    ],
                ],
            ]),
            $this->formFieldFactory->create([
                'label' => 'Content JSX style dark',
                'name' => 'content_style_dark',
                'field_type' => 'textarea_field',
            ]),
        ];

        return array_merge($fields, parent::getFields());
    }
}
