<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Form\Block;

class ColBlockForm extends AbstractBlockForm implements ColBlockFormInterface
{
    public function getFields(): array
    {
        $fields = [
            $this->formFieldFactory->create([
                'label' => 'Flex',
                'name' => 'flex',
                'field_type' => 'text_field',
                'value' => '1',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Span',
                'name' => 'span',
                'field_type' => 'text_field',
                'input_type' => 'number',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Offset',
                'name' => 'offset',
                'field_type' => 'text_field',
                'input_type' => 'number',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Order',
                'name' => 'order',
                'field_type' => 'text_field',
                'input_type' => 'number',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Pull',
                'name' => 'pull',
                'field_type' => 'text_field',
                'input_type' => 'number',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Push',
                'name' => 'push',
                'field_type' => 'text_field',
                'input_type' => 'number',
            ]),
        ];

        return array_merge($fields, parent::getFields());
    }
}
