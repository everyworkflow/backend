<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\StaticBlockBundle\Form;

use EveryWorkflow\DataFormBundle\Field\Select\Option;
use EveryWorkflow\DataFormBundle\Model\Form;

class StaticBlockForm extends Form implements StaticBlockFormInterface
{
    public function getFields(): array
    {
        $fields = [
            $this->formFieldFactory->create([
                'label' => 'UUID',
                'name' => '_id',
                'is_readonly' => true,
            ]),
            $this->formFieldFactory->create([
                'label' => 'Block title',
                'name' => 'block_title',
                'field_type' => 'text_field',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Block key',
                'name' => 'block_key',
                'field_type' => 'text_field',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Status',
                'name' => 'status',
                'field_type' => 'select_field',
                'options' => [
                    [
                        'key' => 'enable',
                        'value' => 'Enable',
                    ],
                    [
                        'key' => 'disable',
                        'value' => 'Disable',
                    ],
                ],
            ]),
            $this->formFieldFactory->create([
                'label' => 'Created at',
                'name' => 'created_at',
                'is_readonly' => true,
                'field_type' => 'date_time_picker_field',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Updated at',
                'name' => 'updated_at',
                'is_readonly' => true,
                'field_type' => 'date_time_picker_field',
            ]),
        ];

        $sortOrder = 5;
        foreach ($fields as $field) {
            $field->setSortOrder($sortOrder++);
        }

        return array_merge($fields, parent::getFields());
    }
}
